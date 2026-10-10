<?php

/**
 * Battery Purchase Return Reconciliation Utility
 * 
 * Synchronizes historical Battery purchase headers and supplier balances
 * according to verified Retail Shop accounting formulas.
 * 
 * Usage:
 *   php database/reconcile_battery_purchase_returns.php              # Defaults to --dry-run
 *   php database/reconcile_battery_purchase_returns.php --dry-run    # Explicit dry-run
 *   php database/reconcile_battery_purchase_returns.php --apply      # Applies only on isolated test DB
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Battery\BatteryPurchase;
use App\Models\Battery\BatteryPurchaseOrderDetail;
use App\Models\Battery\BatteryPurchaseReturn;
use App\Models\Battery\BatterySupplier;

$isDryRun = true;
$isApply = false;
$forceProduction = false;

foreach ($argv as $arg) {
    if (str_starts_with($arg, '--db=')) {
        $targetDb = substr($arg, 5);
        \Illuminate\Support\Facades\Config::set('database.connections.mysql.database', $targetDb);
        DB::purge('mysql');
        DB::reconnect('mysql');
    }
    if ($arg === '--apply') {
        $isApply = true;
        $isDryRun = false;
    }
    if ($arg === '--dry-run') {
        $isDryRun = true;
        $isApply = false;
    }
    if ($arg === '--force-production-authorized') {
        $forceProduction = true;
    }
}

$currentDb = config('database.connections.mysql.database');

echo "================================================================================\n";
echo "       BATTERY PURCHASE RETURN HISTORICAL RECONCILIATION UTILITY\n";
echo "================================================================================\n";
echo "Mode: " . ($isDryRun ? "DRY RUN (No database mutations)" : "APPLY (Database writes enabled)") . "\n";
echo "Connected Database: {$currentDb}\n";
echo "Timestamp: " . date('Y-m-d H:i:s') . "\n";
echo "--------------------------------------------------------------------------------\n\n";

if ($isApply && $currentDb === 'marsscorpdb' && !$forceProduction) {
    echo "SAFETY GUARD: Applying reconciliation on production database 'marsscorpdb' is BLOCKED.\n";
    echo "Separate authorization is required before production mutations can be performed.\n";
    echo "Reverting to DRY RUN mode.\n\n";
    $isDryRun = true;
    $isApply = false;
}

// 1. Discover all purchases with return records or line-item header discrepancies
$allPurchases = BatteryPurchase::with(['supplier', 'orderDetails', 'paymentDetails'])
    ->orderBy('id', 'asc')
    ->get();

$affectedPurchases = [];
$totalDiscrepancyAmount = 0;
$totalReturnVolume = 0;

foreach ($allPurchases as $purchase) {
    $lineSum = (float) BatteryPurchaseOrderDetail::where('purchase_id', $purchase->id)->sum('subtotal');
    $returnsSum = (float) BatteryPurchaseReturn::where('purchase_id', $purchase->id)->sum('amount');
    $headerSubtotal = (float) $purchase->grand_subtotal;
    $headerDue = (float) $purchase->due_amount;
    $headerPaid = (float) $purchase->paid_amount;
    
    $hasDiscrepancy = abs($headerSubtotal - $lineSum) > 0.001;
    $hasReturns = $returnsSum > 0;

    if ($hasDiscrepancy || $hasReturns) {
        $supplier = $purchase->supplier;
        $supplierPayable = (float) ($supplier ? $supplier->purchase_payable_amount : 0);
        
        // Retail formula: remainingSubTotal = sum of line items
        $proposedSubtotal = $lineSum;
        // Payments made on this purchase
        $effectivePayments = (float) ($purchase->paymentDetails ? $purchase->paymentDetails->sum('paid_amount') : $headerPaid);
        // Correct remaining due is max(0, proposedSubtotal - effectivePayments)
        $proposedDue = max(0, $proposedSubtotal - $effectivePayments);

        $subtotalNeedsAdjustment = abs($headerSubtotal - $proposedSubtotal) > 0.001;
        $dueNeedsAdjustment = abs($headerDue - $proposedDue) > 0.001;

        if (!$subtotalNeedsAdjustment && !$dueNeedsAdjustment) {
            continue; // Already fully reconciled
        }

        // Determine qualification reason and status
        $status = 'QUALIFIED';
        $reason = [];
        if ($subtotalNeedsAdjustment) {
            $reason[] = "Header subtotal (৳{$headerSubtotal}) does not match line-item sum (৳{$lineSum})";
        }
        if ($dueNeedsAdjustment) {
            $reason[] = "Header due (৳{$headerDue}) does not match reconciled remaining due (৳{$proposedDue})";
        }

        // Check if supplier balance is already adjusted or needs sync
        $supplierStatus = "OK";
        $proposedSupplierPayable = $supplierPayable;
        if ($supplierPayable > 0 && $supplierPayable >= $returnsSum) {
            $supplierStatus = "HAS_OPENING_BALANCE";
        }

        $affectedPurchases[] = [
            'purchase_id'               => $purchase->id,
            'purchase_ref'              => $purchase->referance_no ?? '#PurID' . str_pad($purchase->id, 5, '0', STR_PAD_LEFT),
            'supplier_id'               => $purchase->supplier_id,
            'supplier_name'             => $supplier ? ($supplier->name ?? $supplier->company) : 'N/A',
            'current_subtotal'          => $headerSubtotal,
            'proposed_subtotal'         => $proposedSubtotal,
            'lineitem_sum'              => $lineSum,
            'current_paid'              => $headerPaid,
            'current_due'               => $headerDue,
            'proposed_due'              => $proposedDue,
            'returns_sum'               => $returnsSum,
            'current_supplier_payable'  => $supplierPayable,
            'proposed_supplier_payable' => $proposedSupplierPayable,
            'status'                    => $status,
            'reasons'                   => implode('; ', $reason),
        ];

        $totalDiscrepancyAmount += abs($headerSubtotal - $lineSum);
        $totalReturnVolume += $returnsSum;
    }
}

echo "DISCOVERY RESULTS:\n";
echo "Found " . count($affectedPurchases) . " purchase record(s) requiring reconciliation.\n\n";

printf(
    "%-6s | %-12s | %-24s | %-12s | %-12s | %-10s | %-10s | %-10s\n",
    "ID", "Ref No", "Supplier", "Curr Subtot", "Prop Subtot", "Curr Due", "Prop Due", "Returns"
);
echo str_repeat("-", 108) . "\n";

foreach ($affectedPurchases as $item) {
    printf(
        "%-6d | %-12s | %-24s | ৳%-11.2f | ৳%-11.2f | ৳%-9.2f | ৳%-9.2f | ৳%-9.2f\n",
        $item['purchase_id'],
        substr($item['purchase_ref'], 0, 12),
        substr($item['supplier_name'], 0, 24),
        $item['current_subtotal'],
        $item['proposed_subtotal'],
        $item['current_due'],
        $item['proposed_due'],
        $item['returns_sum']
    );
}
echo str_repeat("-", 108) . "\n\n";

echo "DETAILED REASONS & QUALIFICATIONS:\n";
foreach ($affectedPurchases as $item) {
    echo "• Purchase ID {$item['purchase_id']} [{$item['purchase_ref']}]:\n";
    echo "  - Reasons: {$item['reasons']}\n";
    echo "  - Subtotal Adjustment: ৳{$item['current_subtotal']} -> ৳{$item['proposed_subtotal']} (Diff: -৳" . ($item['current_subtotal'] - $item['proposed_subtotal']) . ")\n";
    echo "  - Purchase Due Adjustment: ৳{$item['current_due']} -> ৳{$item['proposed_due']}\n";
    echo "  - Supplier: {$item['supplier_name']} [FK supplier_id: {$item['supplier_id']}]\n";
    echo "  - Supplier Opening Payable (purchase_payable_amount): ৳{$item['current_supplier_payable']}\n";
    echo "  - Retail Parity Note: Synchronizes purchase header to match active line-items and payments. Preserves supplier opening balance to prevent double deduction.\n\n";
}

echo "AGGREGATE FINANCIAL IMPACT SUMMARY:\n";
echo "--------------------------------------------------------------------------------\n";
echo "Total Affected Purchases:           " . count($affectedPurchases) . "\n";
echo "Total Historical Return Volume:     ৳" . number_format($totalReturnVolume, 2) . "\n";
echo "Total Subtotal Discrepancy:         ৳" . number_format($totalDiscrepancyAmount, 2) . "\n";
echo "Net Purchase Header Correction:    -৳" . number_format($totalDiscrepancyAmount, 2) . "\n";
echo "Supplier Balances Affected (FKs):   " . implode(', ', array_unique(array_column($affectedPurchases, 'supplier_id'))) . "\n";
echo "--------------------------------------------------------------------------------\n\n";

if ($isApply) {
    echo "EXECUTING RECONCILIATION WRITES...\n";
    DB::beginTransaction();
    try {
        $updatedCount = 0;
        foreach ($affectedPurchases as $item) {
            $p = BatteryPurchase::find($item['purchase_id']);
            if ($p) {
                $p->update([
                    'grand_subtotal' => $item['proposed_subtotal'],
                    'due_amount'     => $item['proposed_due'],
                ]);
                $updatedCount++;
            }
        }
        DB::commit();
        echo "SUCCESS: Reconciled {$updatedCount} purchase header records.\n";
    } catch (\Exception $e) {
        DB::rollBack();
        echo "ERROR: Reconciliation failed and was rolled back: " . $e->getMessage() . "\n";
        exit(1);
    }
} else {
    echo "DRY RUN COMPLETE: Zero database mutations performed.\n";
    echo "To execute reconciliation on an isolated database:\n";
    echo "  php database/reconcile_battery_purchase_returns.php --apply\n";
}

echo "================================================================================\n";
exit(0);
