<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('invoice:delete {order_no} {--dry-run : Simulate invoice deletion without database changes} {--force : Force deletion without interactive confirmation}', function () {
    $rawNo = trim($this->argument('order_no'));
    $dryRun = $this->option('dry-run');
    $force = $this->option('force');

    $withHash = str_starts_with($rawNo, '#') ? $rawNo : '#' . $rawNo;
    $withoutHash = ltrim($rawNo, '#');

    $this->info("=============================================================");
    $this->info("             Invoice Deletion & Reversal Tool                ");
    $this->info("=============================================================");
    if ($dryRun) {
        $this->warn("MODE: DRY RUN (Simulation only - Database will NOT be modified)\n");
    } else {
        $this->alert("MODE: LIVE DELETION\n");
    }

    \Illuminate\Support\Facades\DB::beginTransaction();

    try {
        $order = \App\Models\Order::whereIn('order_no', [$rawNo, $withHash, $withoutHash])
            ->orWhere('id', $rawNo)
            ->lockForUpdate()
            ->first();

        if (!$order) {
            \Illuminate\Support\Facades\DB::rollBack();
            $this->error("Invoice '{$rawNo}' not found in database!");
            return;
        }

        $orderId = $order->id;
        $orderNumber = $order->order_no;
        $customerId = $order->customer_id;
        $dueAmount = (float) $order->due_amount;
        $paidAmount = (float) $order->paid_amount;
        $subTotal = (float) $order->sub_total;

        // Lock details, returns, payments, and impacted products in deterministic ascending ID order
        $lockedDetails = \App\Models\OrderDetails::where('order_id', $orderId)
            ->orderBy('id', 'asc')
            ->lockForUpdate()
            ->get();

        $lockedReturns = \App\Models\ProductReturn::where('order_id', $orderId)
            ->orderBy('id', 'asc')
            ->lockForUpdate()
            ->get();

        $lockedPayments = \App\Models\OrderPaymentDetails::where('order_id', $orderId)
            ->orderBy('id', 'asc')
            ->lockForUpdate()
            ->get();

        $productIds = $lockedDetails->pluck('product_id')
            ->merge($lockedReturns->pluck('product_id'))
            ->map(fn ($v) => (int) $v)
            ->unique()
            ->filter()
            ->sort()
            ->values()
            ->all();

        $lockedProducts = !empty($productIds)
            ? \App\Models\Product::whereIn('id', $productIds)->orderBy('id', 'asc')->lockForUpdate()->get()->keyBy('id')
            : collect();

        $customer = $customerId ? \App\Models\Customer::lockForUpdate()->find($customerId) : null;
        $customerName = $customer ? ($customer->customer_name ?? $customer->name) : 'N/A';

        $this->info("Target Invoice Details:");
        $this->line("  • Invoice No: {$orderNumber} (ID: {$orderId})");
        $this->line("  • Customer  : {$customerName} (ID: {$customerId})");
        $this->line("  • Financials: Subtotal = {$subTotal}, Paid = {$paidAmount}, Due = {$dueAmount}");

        // 1. Revert product stocks (accounting for any prior returns already restored to inventory)
        $this->info("\n[1/5] Product Stock Reconciliation:");
        if ($lockedDetails->isEmpty()) {
            if ($lockedReturns->isNotEmpty()) {
                $this->line("  - No active order line items found (lines were fully returned under legacy return logic).");
                foreach ($lockedReturns as $ret) {
                    $p = $lockedProducts->get((int) $ret->product_id);
                    $pName = $p ? $p->product_name : "Product #{$ret->product_id}";
                    $this->line("  - Return Record #{$ret->id}: {$ret->quantity}x {$pName} was previously returned to inventory.");
                    $this->line("    => Net stock movement for this invoice was 0. Current stock remains unchanged.");
                }
            } else {
                $this->line("  - No items found in order_details. Product stocks remain unchanged.");
            }
        } else {
            // Aggregate returns by detail_id / product_id using locked rows
            $returnsByProduct = $lockedReturns->groupBy('product_id')->map(fn ($g) => (float) $g->sum('quantity'));
            foreach ($lockedDetails as $detail) {
                $product = $lockedProducts->get((int) $detail->product_id);
                if ($product) {
                    $returnedFromTable = (float) ($returnsByProduct->get($detail->product_id) ?? 0);
                    $returnedFromDetail = (float) ($detail->return_quantity ?? 0);
                    $returnedQty = max($returnedFromTable, $returnedFromDetail);
                    $netRestoreQty = max(0, (float) $detail->quantity - $returnedQty);
                    if ($netRestoreQty > 0) {
                        $oldQty = (int) $product->quantity;
                        $newQty = $oldQty + (int) $netRestoreQty;
                        if (!$dryRun) {
                            $product->quantity = $newQty;
                            $product->save();
                        }
                        $this->line("  ✓ Product #{$product->id} ({$product->product_name}): Stock {$oldQty} -> {$newQty} (+{$netRestoreQty})");
                    } else {
                        $this->line("  - Product #{$product->id} ({$product->product_name}): Stock unchanged (All {$detail->quantity} item(s) were already returned to inventory).");
                    }
                }
            }
        }

        // 2. Delete associated product returns
        $this->info("\n[2/5] Product Returns Cleanup:");
        $returnCount = $lockedReturns->count();
        if ($returnCount > 0) {
            if (!$dryRun) {
                \App\Models\ProductReturn::where('order_id', $orderId)->delete();
            }
            $this->line("  ✓ Removed {$returnCount} associated product return record(s).");
        } else {
            $this->line("  - No associated product returns found.");
        }

        // 3. Delete associated payments
        $this->info("\n[3/5] Payment & Daily Ledger Reversal:");
        $paymentCount = $lockedPayments->count();
        if ($paymentCount > 0) {
            $totalPaymentSum = (float) $lockedPayments->sum('paid_amount');
            if (!$dryRun) {
                \App\Models\OrderPaymentDetails::where('order_id', $orderId)->delete();
            }
            $this->line("  ✓ Removed {$paymentCount} payment record(s) totaling ৳{$totalPaymentSum}.");
            $this->line("    => Dynamic daily receipt & sales ledger collections automatically reversed.");
        } else {
            $this->line("  - No payment records found.");
        }

        // 4. Delete order details
        $this->info("\n[4/5] Order Item Details Removal:");
        $detailCount = $lockedDetails->count();
        if (!$dryRun) {
            \App\Models\OrderDetails::where('order_id', $orderId)->delete();
        }
        $this->line("  ✓ Removed {$detailCount} order item detail row(s).");

        // 5. Delete order
        $this->info("\n[5/5] Primary Invoice Removal:");
        if (!$dryRun) {
            $order->delete();
        }
        $this->line("  ✓ Order record #{$orderNumber} (ID: {$orderId}) removed.");

        // Check customer due impact
        if ($customer) {
            $prevDue = (float) ($customer->previous_due_amount ?? 0);
            $remOrdersDue = (float) \App\Models\Order::where('customer_id', $customerId)
                ->where('id', '!=', $orderId)
                ->sum('due_amount');
            $newTotalDue = $prevDue + $remOrdersDue;
            $this->info("\nCustomer Due Recalculation:");
            $this->line("  • Customer: {$customerName}");
            $this->line("  • Opening/Previous Due: ৳{$prevDue}");
            $this->line("  • Remaining Orders Due: ৳{$remOrdersDue}");
            $this->line("  • Resulting Total Due : ৳{$newTotalDue}");
        }

        if ($dryRun) {
            \Illuminate\Support\Facades\DB::rollBack();
            $this->warn("\n[DRY RUN COMPLETE] No changes were committed to the database.");
            $this->info("To execute this deletion permanently on this environment, run:");
            $this->info("  php artisan invoice:delete \"{$rawNo}\" --force");
        } else {
            if (!$force && !$this->confirm("\nAre you sure you want to permanently delete Invoice {$orderNumber} and all associated records?")) {
                \Illuminate\Support\Facades\DB::rollBack();
                $this->warn("\nOperation cancelled by user. No changes were saved.");
                return;
            }

            \Illuminate\Support\Facades\DB::commit();
            Log::info('CLI Invoice Deleted', [
                'order_id' => $orderId,
                'order_no' => $orderNumber,
                'details_deleted' => $detailCount,
                'returns_deleted' => $returnCount,
                'payments_deleted' => $paymentCount,
                'timestamp' => now()->toIso8601String(),
            ]);
            $this->info("\n✓ [SUCCESS] Invoice {$orderNumber} (ID: {$orderId}) deleted successfully from database!");
        }

    } catch (\Exception $e) {
        \Illuminate\Support\Facades\DB::rollBack();
        Log::error('CLI Invoice Deletion Failed', ['order_no' => $rawNo, 'error' => $e->getMessage()]);
        $this->error("\n[ERROR] Invoice deletion failed: " . $e->getMessage());
    }
})->purpose('Safely delete an invoice, restore product stock, and remove all relationships by invoice number or ID');

Artisan::command('purchase:reconcile-shahin-alam {--dry-run : Disabled legacy option} {--force : Disabled legacy option}', function () {
    $this->error('[DISABLED] Historical command purchase:reconcile-shahin-alam has been permanently retired (fail-closed) to prevent mass stock wipe.');
    $this->line('No automated stock-repair CLI command is enabled in this release; any stock adjustment requires separate owner-approved verification and release.');

    Log::warning('Blocked attempt to execute retired command purchase:reconcile-shahin-alam', [
        'dry_run' => (bool) $this->option('dry-run'),
        'force' => (bool) $this->option('force'),
        'timestamp' => now()->toIso8601String(),
    ]);

    return 1;
})->purpose('[DISABLED] Permanently retired historical Shahin Alam reconciliation script');

