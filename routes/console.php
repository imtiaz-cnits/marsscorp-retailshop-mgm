<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('invoice:delete {order_no}', function () {
    $orderNo = $this->argument('order_no');
    \Illuminate\Support\Facades\DB::transaction(function () use ($orderNo) {
        $order = \App\Models\Order::with(['details', 'payment', 'productReturns'])
            ->where('order_no', $orderNo)
            ->orWhere('id', $orderNo)
            ->first();

        if (!$order) {
            $this->error("Invoice '{$orderNo}' not found!");
            return;
        }

        $orderId = $order->id;
        $orderNumber = $order->order_no;

        // Delete associated records
        $order->productReturns()->delete();
        $order->payment()->delete();
        $order->details()->delete();
        $order->delete();

        $this->info("Invoice {$orderNumber} (ID: {$orderId}) deleted successfully from database!");
    });
})->purpose('Safely delete an invoice and all its relationships by invoice number or ID');

