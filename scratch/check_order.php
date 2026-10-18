<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$orders = App\Models\Order::latest('id')->take(5)->get();
foreach ($orders as $order) {
    echo "ID: {$order->id} | {$order->order_no} | Subtotal: {$order->sub_total} | Discount: {$order->discount_amount} | Type: {$order->discount_type} | Rate: {$order->discount_rate}\n";
}
