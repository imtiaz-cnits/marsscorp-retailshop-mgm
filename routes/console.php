<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('invoice:delete {order_no}', function () {
    $rawNo = trim($this->argument('order_no'));
    $withHash = str_starts_with($rawNo, '#') ? $rawNo : '#' . $rawNo;
    $withoutHash = ltrim($rawNo, '#');

    \Illuminate\Support\Facades\DB::transaction(function () use ($rawNo, $withHash, $withoutHash) {
        $order = \App\Models\Order::with(['details', 'payment', 'productReturns'])
            ->whereIn('order_no', [$rawNo, $withHash, $withoutHash])
            ->orWhere('id', $rawNo)
            ->first();

        if (!$order) {
            $this->error("Invoice '{$rawNo}' not found!");
            return;
        }

        $orderId = $order->id;
        $orderNumber = $order->order_no;
        $customerId = $order->customer_id;
        $dueAmount = $order->due_amount;
        $paidAmount = $order->paid_amount;

        $this->info("Found Invoice {$orderNumber} (ID: {$orderId}):");
        $this->line("- Customer ID: {$customerId}");
        $this->line("- Subtotal: {$order->sub_total}, Paid: {$paidAmount}, Due: {$dueAmount}");

        // 1. Revert product stocks
        $this->info("\nRestoring product stocks...");
        foreach ($order->details as $detail) {
            $product = \App\Models\Product::find($detail->product_id);
            if ($product) {
                $oldQty = $product->quantity;
                $product->increment('quantity', $detail->quantity);
                $newQty = $product->fresh()->quantity;
                $this->line("  ✓ Product #{$product->id} ({$product->product_name}): Stock {$oldQty} -> {$newQty} (+{$detail->quantity})");
            }
        }

        // 2. Delete associated product returns
        $returnCount = \App\Models\ProductReturn::where('order_id', $orderId)->count();
        if ($returnCount > 0) {
            \App\Models\ProductReturn::where('order_id', $orderId)->delete();
            $this->line("  ✓ Deleted {$returnCount} product return record(s).");
        }

        // 3. Delete associated payments
        $paymentCount = \App\Models\OrderPaymentDetails::where('order_id', $orderId)->count();
        if ($paymentCount > 0) {
            \App\Models\OrderPaymentDetails::where('order_id', $orderId)->delete();
            $this->line("  ✓ Deleted {$paymentCount} payment detail record(s) (Total Paid: {$paidAmount}).");
        }

        // 4. Delete order details
        $detailCount = \App\Models\OrderDetails::where('order_id', $orderId)->count();
        \App\Models\OrderDetails::where('order_id', $orderId)->delete();
        $this->line("  ✓ Deleted {$detailCount} order item(s).");

        // 5. Delete order
        $order->delete();
        $this->info("\n✓ Invoice {$orderNumber} (ID: {$orderId}) deleted successfully from database!");

        // 6. Check updated customer due
        if ($customerId) {
            $customer = \App\Models\Customer::find($customerId);
            if ($customer) {
                $remDue = \App\Models\Order::where('customer_id', $customerId)->sum('due_amount');
                $totalDue = ($customer->previous_due_amount ?? 0) + $remDue;
                $this->info("Customer '{$customer->customer_name}' remaining total due is now: {$totalDue} (Previous: {$customer->previous_due_amount}, Orders Due: {$remDue})");
            }
        }
    });
})->purpose('Safely delete an invoice, restore product stock, and remove all relationships by invoice number or ID');

Artisan::command('purchase:reconcile-shahin-alam {--dry-run : Simulate changes without saving} {--force : Apply changes without confirmation}', function () {
    $dryRun = $this->option('dry-run');
    $force = $this->option('force');

    $this->info("=============================================================");
    $this->info("  Shahin Alam Purchase (#PurID00013) Stock Reconciliation");
    $this->info("=============================================================");
    if ($dryRun) {
        $this->warn("MODE: DRY RUN (Simulation only - Database will NOT be modified)\n");
    } else {
        $this->alert("MODE: LIVE EXECUTION (Changes WILL be applied to database)\n");
    }

    $purchaseItems = [
        ['product_id' => 704, 'purchased_qty' => 10, 'cost_price' => 626.50, 'product_name' => 'Ring Towel Rali'],
        ['product_id' => 705, 'purchased_qty' => 4,  'cost_price' => 3426.50, 'product_name' => 'Moving sink Mixer Star'],
        ['product_id' => 706, 'purchased_qty' => 6,  'cost_price' => 1256.50, 'product_name' => '6" Push Basin weste'],
        ['product_id' => 707, 'purchased_qty' => 4,  'cost_price' => 1186.50, 'product_name' => 'Premimum Square Shower'],
        ['product_id' => 708, 'purchased_qty' => 10, 'cost_price' => 346.50, 'product_name' => 'Soap Case Steal'],
        ['product_id' => 709, 'purchased_qty' => 2,  'cost_price' => 3496.50, 'product_name' => 'Besin Mixer Oliver'],
        ['product_id' => 710, 'purchased_qty' => 3,  'cost_price' => 1746.50, 'product_name' => '3" Round Shower'],
        ['product_id' => 711, 'purchased_qty' => 6,  'cost_price' => 696.50, 'product_name' => 'Glass Self-24"'],
        ['product_id' => 712, 'purchased_qty' => 4,  'cost_price' => 1326.50, 'product_name' => 'Liver Big Cock'],
        ['product_id' => 713, 'purchased_qty' => 3,  'cost_price' => 1886.50, 'product_name' => 'Round Moving Shower'],
        ['product_id' => 714, 'purchased_qty' => 3,  'cost_price' => 2166.50, 'product_name' => 'Singel Liver Basin piller Cock'],
        ['product_id' => 715, 'purchased_qty' => 6,  'cost_price' => 682.50, 'product_name' => '18"-Glass Self'],
        ['product_id' => 418, 'purchased_qty' => 4,  'cost_price' => 1256.50, 'product_name' => 'Satter Cilling Shower-6"'],
        ['product_id' => 716, 'purchased_qty' => 2,  'cost_price' => 5106.50, 'product_name' => '1" Shower Mixer'],
        ['product_id' => 717, 'purchased_qty' => 2,  'cost_price' => 3776.50, 'product_name' => '12" Top Piller Cock'],
        ['product_id' => 718, 'purchased_qty' => 6,  'cost_price' => 836.50, 'product_name' => '24" Tawel Rail'],
        ['product_id' => 719, 'purchased_qty' => 6,  'cost_price' => 836.50, 'product_name' => 'Push Shower Royal Pro'],
        ['product_id' => 408, 'purchased_qty' => 12, 'cost_price' => 446.50, 'product_name' => 'Basin West'],
        ['product_id' => 720, 'purchased_qty' => 10, 'cost_price' => 556.50, 'product_name' => 'Premimum Soap Case'],
        ['product_id' => 721, 'purchased_qty' => 10, 'cost_price' => 696.50, 'product_name' => 'Angel Stop Cock'],
        ['product_id' => 722, 'purchased_qty' => 3,  'cost_price' => 2236.50, 'product_name' => '4" Square Moving Shower'],
        ['product_id' => 723, 'purchased_qty' => 3,  'cost_price' => 2376.50, 'product_name' => 'Moving Piller Cock Oliver'],
        ['product_id' => 724, 'purchased_qty' => 3,  'cost_price' => 2446.50, 'product_name' => 'Moving Sink Cock Oliver'],
        ['product_id' => 725, 'purchased_qty' => 6,  'cost_price' => 882.00, 'product_name' => 'Push Shower'],
        ['product_id' => 726, 'purchased_qty' => 2,  'cost_price' => 9090.25, 'product_name' => '18*32" Handmade Sink'],
        ['product_id' => 727, 'purchased_qty' => 1,  'cost_price' => 9940.75, 'product_name' => '18*36" Handmade Sink'],
        ['product_id' => 728, 'purchased_qty' => 6,  'cost_price' => 505.75, 'product_name' => 'Moving Shower'],
        ['product_id' => 729, 'purchased_qty' => 12, 'cost_price' => 250.75, 'product_name' => 'Angel Stop Cock-S2C'],
        ['product_id' => 730, 'purchased_qty' => 6,  'cost_price' => 697.00, 'product_name' => 'Moving Piller Cock liver'],
        ['product_id' => 731, 'purchased_qty' => 6,  'cost_price' => 697.00, 'product_name' => 'Moving Piller Cock Besin'],
        ['product_id' => 732, 'purchased_qty' => 6,  'cost_price' => 697.00, 'product_name' => 'Moving Sink Cock Liver'],
        ['product_id' => 733, 'purchased_qty' => 10, 'cost_price' => 293.25, 'product_name' => 'Liver Big Cock-S1L'],
        ['product_id' => 734, 'purchased_qty' => 10, 'cost_price' => 293.25, 'product_name' => 'Big Cock Crown'],
        ['product_id' => 735, 'purchased_qty' => 6,  'cost_price' => 697.00, 'product_name' => 'Moving Sink Cock'],
    ];

    \Illuminate\Support\Facades\DB::beginTransaction();

    try {
        $tableRows = [];
        $totalDeducted = 0;
        $totalSold = 0;

        foreach ($purchaseItems as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            if (!$product) {
                $tableRows[] = [
                    $item['product_id'],
                    $item['product_name'],
                    $item['purchased_qty'],
                    'N/A',
                    'NOT FOUND',
                    0,
                    0,
                    'N/A'
                ];
                continue;
            }

            $currentStock = (int) $product->quantity;
            $purchasedQty = (int) $item['purchased_qty'];

            // How much of this purchase is still sitting as ghost stock in inventory
            $deductQty = min($currentStock, $purchasedQty);
            $soldQty = max(0, $purchasedQty - $currentStock);
            $newStock = max(0, $currentStock - $deductQty);

            // Recompute cost price
            $newCost = $product->cost_price;
            $prevPurchase = \App\Models\PurchaseOrderDetails::where('product_id', $product->id)
                ->where('purchase_id', '!=', 13)
                ->latest('id')
                ->first();

            if ($newStock > 0) {
                $currentVal = (float)$product->cost_price * $currentStock;
                $purchasedVal = (float)$item['cost_price'] * $deductQty;
                $remVal = $currentVal - $purchasedVal;
                if ($remVal > 0) {
                    $newCost = round($remVal / $newStock, 2);
                } elseif ($prevPurchase) {
                    $newCost = round((float)$prevPurchase->cost_price, 2);
                }
            } else {
                if ($prevPurchase) {
                    $newCost = round((float)$prevPurchase->cost_price, 2);
                }
            }

            $tableRows[] = [
                $product->id,
                $product->product_name,
                $purchasedQty,
                $soldQty > 0 ? "<fg=yellow>{$soldQty}</>" : '0',
                $currentStock,
                "-{$deductQty}",
                "<fg=green>{$newStock}</>",
                $newCost
            ];

            $totalDeducted += $deductQty;
            $totalSold += $soldQty;

            if (!$dryRun) {
                $product->quantity = $newStock;
                $product->cost_price = $newCost;
                $product->save();
            }
        }

        $this->table(
            ['ID', 'Product Name', 'Pur Qty', 'Sold Qty', 'Old Stock', 'Deducted', 'New Stock', 'New Cost'],
            $tableRows
        );

        $this->info("\nSummary:");
        $this->line("- Total items checked: " . count($purchaseItems));
        $this->line("- Total ghost stock deducted from inventory: <fg=green>{$totalDeducted}</>");
        $this->line("- Items already sold to customers: <fg=yellow>{$totalSold}</>");

        // Also clean up residual purchase record if it still exists (e.g. on local)
        $residualPurchase = \App\Models\Purchase::find(13);
        if ($residualPurchase) {
            $this->info("\nFound residual Purchase #PurID00013 in database. Cleaning up...");
            if (!$dryRun) {
                \App\Models\PurchasePaymentDetails::where('purchases_id', 13)->delete();
                \App\Models\PurchaseOrderDetails::where('purchase_id', 13)->delete();
                $residualPurchase->delete();
                $this->line("✓ Residual purchase, payment details, and order details removed.");
            } else {
                $this->line("(Dry-Run) Would remove residual purchase #PurID00013 and dependent records.");
            }
        } else {
            $this->line("\n✓ Purchase record was already deleted from purchases table.");
        }

        if ($dryRun) {
            \Illuminate\Support\Facades\DB::rollBack();
            $this->warn("\n[DRY RUN COMPLETE] No changes were committed to the database.");
            $this->info("To apply these changes permanently, run:");
            $this->info("  php artisan purchase:reconcile-shahin-alam --force");
        } else {
            if (!$force && !$this->confirm('Do you want to permanently commit these stock adjustments?')) {
                \Illuminate\Support\Facades\DB::rollBack();
                $this->warn("\nOperation cancelled by user. No changes were saved.");
                return;
            }

            \Illuminate\Support\Facades\DB::commit();
            $this->info("\n[SUCCESS] Shahin Alam purchase stock successfully reconciled in database!");
        }
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\DB::rollBack();
        $this->error("\n[ERROR] Reconciliation failed: " . $e->getMessage());
    }
})->purpose('Reconcile ghost inventory stock left behind from Shahin Alam deleted purchase #PurID00013');


