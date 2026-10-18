<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;

$orders = Order::whereIn('id', [98, 99])->get();
foreach ($orders as $order) {
    $order->discount_type = 'percent';
    $order->discount_rate = 15.00;
    $order->save();
    echo "Updated order {$order->order_no}: discount_type={$order->discount_type}, discount_rate={$order->discount_rate}\n";
}
