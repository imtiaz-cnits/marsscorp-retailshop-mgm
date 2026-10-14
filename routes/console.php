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

