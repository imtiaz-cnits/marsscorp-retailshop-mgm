<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== PURCHASES (purchase_order_details) ===\n";
$purchases = DB::table('purchase_order_details')->whereIn('product_id', [568, 736, 737])->get();
foreach ($purchases as $pu) {
    echo json_encode($pu) . "\n";
}

echo "\n=== ORDER DETAILS (order_details) ===\n";
$orders = DB::table('order_details')->whereIn('product_id', [568, 736, 737])->get();
foreach ($orders as $od) {
    echo json_encode($od) . "\n";
}
