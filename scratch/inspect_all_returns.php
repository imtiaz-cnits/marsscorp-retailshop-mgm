<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ProductReturn;

$all = ProductReturn::with('product', 'order')->orderBy('id')->get();
echo "Total ProductReturn rows: " . $all->count() . "\n\n";
foreach ($all as $r) {
    echo "ID: {$r->id} | OrderID: {$r->order_id} (" . ($r->order->order_no ?? 'N/A') . ") | Product: " . ($r->product->product_name ?? 'N/A') . " | Qty: {$r->quantity} | Amount: {$r->amount} | Date: {$r->date} | CreatedAt: {$r->created_at}\n";
}
