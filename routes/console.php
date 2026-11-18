<?php

use App\Services\ShahinAlomStockRepairService;
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

Artisan::command(
    'purchase:repair-shahin-alam {--expected-db= : Expected MySQL database name} {--expected-host= : Expected MySQL @@hostname} {--expected-port= : Expected MySQL @@port} {--execute : Execute Category A (-15 units) repair (REQUIRES --confirm-physical-verification, --approval-manifest, and HMAC secret)} {--confirm-physical-verification : Confirm signed physical verification Forms 6A/6B and explicit owner approval} {--approval-manifest= : Path to signed JSON approval manifest file}',
    function (ShahinAlomStockRepairService $repairService) {
        $execute = (bool) $this->option('execute');
        $confirmed = (bool) $this->option('confirm-physical-verification');
        $expectedDb = trim((string) ($this->option('expected-db') ?? ''));
        $expectedHost = trim((string) ($this->option('expected-host') ?? ''));
        $expectedPortRaw = trim((string) ($this->option('expected-port') ?? ''));
        if ($expectedPortRaw !== '') {
            if (!ctype_digit($expectedPortRaw)) {
                $this->error("[REFUSED] Invalid --expected-port '{$expectedPortRaw}': must be an integer between 1 and 65535.");
                return 1;
            }
            $expectedPort = (int) $expectedPortRaw;
            if ($expectedPort < 1 || $expectedPort > 65535) {
                $this->error("[REFUSED] Invalid --expected-port '{$expectedPortRaw}': must be between 1 and 65535.");
                return 1;
            }
        } else {
            $expectedPort = null;
        }
        $manifestPath = trim((string) ($this->option('approval-manifest') ?? ''));

        if (!$execute) {
            if ($expectedDb === '') {
                $this->error('[DRY-RUN REFUSED] Explicit --expected-db=<database_name> is required.');
                return 1;
            }

            $this->info('=============================================================');
            $this->info('  Shahin Alom Category A Stock Repair — DRY RUN (Read-Only)  ');
            $this->info('=============================================================');

            try {
                $result = $repairService->runDryRun(
                    $expectedDb,
                    $expectedHost !== '' ? $expectedHost : null,
                    $expectedPort
                );
            } catch (\Throwable $e) {
                $this->error('[DRY-RUN ABORTED] ' . $e->getMessage());
                return 1;
            }

            $this->line("Database   : {$result['db_meta']['db']} @ {$result['db_meta']['host']}:{$result['db_meta']['port']}");
            $this->line("DB Ledger  : " . ($result['db_ledger_ready'] ? 'READY (stock_repair_executions present)' : 'NOT APPLIED (migration pending — live --execute will fail closed)'));
            $this->line("Already Run: " . ($result['already_executed'] ? 'YES (blocked by stock_repair_executions ledger)' : 'NO'));
            $this->line("34-SKU Sum : {$result['pre_sum_34']} -> planned {$result['planned_post_sum_34']} (delta {$result['planned_delta']})");
            $this->line("Cat-A Sum  : {$result['pre_sum_9']} -> planned {$result['planned_post_sum_9']}");

            $rows = array_map(static fn (array $r) => [
                $r['id'],
                $r['name'],
                $r['barcode'],
                $r['current_qty'],
                $r['planned_qty'],
                $r['delta'],
            ], $result['targets']);

            $this->table(['ID', 'Product Name', 'Barcode', 'Current Qty', 'Planned Qty', 'Delta'], $rows);
            $this->warn('[DRY RUN COMPLETE] Transaction rolled back. Zero database rows were modified.');
            return 0;
        }

        if ($expectedDb === '' || $expectedHost === '' || $expectedPort === null || $expectedPort <= 0) {
            $this->error('[REFUSED] Live execution requires explicit --expected-db=<db>, --expected-host=<host>, and --expected-port=<port>.');
            return 1;
        }

        if (!$confirmed) {
            $this->error('[REFUSED] Live execution requires --confirm-physical-verification (signed Forms 6A/6B and explicit owner approval).');
            return 1;
        }

        if ($manifestPath === '') {
            $this->error('[REFUSED] Live execution requires --approval-manifest=<path/to/manifest.json>.');
            return 1;
        }

        $this->alert('MODE: LIVE APPROVED EXECUTION (Category A: 9 SKUs, -15 Units)');

        try {
            $result = $repairService->executeApprovedRepairFromFile($manifestPath, $expectedDb, true, $expectedHost, $expectedPort);
        } catch (\Throwable $e) {
            $this->error('[EXECUTION FAILED — ROLLED BACK] ' . $e->getMessage());
            return 1;
        }

        $this->info("[SUCCESS] Committed Category A repair #{$result['execution_id']} on {$result['db_meta']['db']} ({$result['repair_reference']}): 9 SKUs ({$result['pre_sum_9']} -> {$result['post_sum_9']}), 34 SKUs ({$result['pre_sum_34']} -> {$result['post_sum_34']}).");
        return 0;
    }
)->purpose('Dry-run by default; atomically verifies and applies approved Shahin Alom Category A (-15 units) ledger repair');
