<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

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
        $order = \App\Models\Order::with(['details', 'payment', 'productReturns'])
            ->whereIn('order_no', [$rawNo, $withHash, $withoutHash])
            ->orWhere('id', $rawNo)
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

        $customer = $customerId ? \App\Models\Customer::find($customerId) : null;
        $customerName = $customer ? ($customer->customer_name ?? $customer->name) : 'N/A';

        $this->info("Target Invoice Details:");
        $this->line("  • Invoice No: {$orderNumber} (ID: {$orderId})");
        $this->line("  • Customer  : {$customerName} (ID: {$customerId})");
        $this->line("  • Financials: Subtotal = {$subTotal}, Paid = {$paidAmount}, Due = {$dueAmount}");

        // 1. Revert product stocks (accounting for any prior returns already restored to inventory)
        $this->info("\n[1/5] Product Stock Reconciliation:");
        if ($order->details->isEmpty()) {
            $associatedReturns = \App\Models\ProductReturn::where('order_id', $orderId)->get();
            if ($associatedReturns->isNotEmpty()) {
                $this->line("  - No active order line items found (lines were fully returned under legacy return logic).");
                foreach ($associatedReturns as $ret) {
                    $p = \App\Models\Product::find($ret->product_id);
                    $pName = $p ? $p->product_name : "Product #{$ret->product_id}";
                    $this->line("  - Return Record #{$ret->id}: {$ret->quantity}x {$pName} was previously returned to inventory.");
                    $this->line("    => Net stock movement for this invoice was 0. Current stock remains unchanged.");
                }
            } else {
                $this->line("  - No items found in order_details. Product stocks remain unchanged.");
            }
        } else {
            foreach ($order->details as $detail) {
                $product = \App\Models\Product::find($detail->product_id);
                if ($product) {
                    $returnedQty = (float) \App\Models\ProductReturn::where('order_id', $orderId)
                        ->where('product_id', $detail->product_id)
                        ->sum('quantity');
                    $netRestoreQty = max(0, (float)$detail->quantity - $returnedQty);
                    if ($netRestoreQty > 0) {
                        $oldQty = $product->quantity;
                        if (!$dryRun) {
                            $product->increment('quantity', $netRestoreQty);
                        }
                        $newQty = $oldQty + $netRestoreQty;
                        $this->line("  ✓ Product #{$product->id} ({$product->product_name}): Stock {$oldQty} -> {$newQty} (+{$netRestoreQty})");
                    } else {
                        $this->line("  - Product #{$product->id} ({$product->product_name}): Stock unchanged (All {$detail->quantity} item(s) were already returned to inventory).");
                    }
                }
            }
        }

        // 2. Delete associated product returns
        $this->info("\n[2/5] Product Returns Cleanup:");
        $returnCount = \App\Models\ProductReturn::where('order_id', $orderId)->count();
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
        $paymentCount = \App\Models\OrderPaymentDetails::where('order_id', $orderId)->count();
        if ($paymentCount > 0) {
            $totalPaymentSum = (float) \App\Models\OrderPaymentDetails::where('order_id', $orderId)->sum('paid_amount');
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
        $detailCount = \App\Models\OrderDetails::where('order_id', $orderId)->count();
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
            $this->info("\n✓ [SUCCESS] Invoice {$orderNumber} (ID: {$orderId}) deleted successfully from database!");
        }

    } catch (\Exception $e) {
        \Illuminate\Support\Facades\DB::rollBack();
        $this->error("\n[ERROR] Invoice deletion failed: " . $e->getMessage());
    }
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


