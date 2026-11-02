<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$prods = DB::table('products')->whereIn('id', [567, 568, 569, 736, 737])->get();
foreach ($prods as $p) {
    echo json_encode($p, JSON_PRETTY_PRINT) . PHP_EOL;
}

echo "\nOrder details for these products:\n";
$ods = DB::table('order_details')->whereIn('product_id', [567, 568, 569, 736, 737])->get();
foreach ($ods as $od) {
    echo sprintf("OD ID: %d | Order ID: %d | Product ID: %d | Qty: %d | Price: %s\n",
        $od->id, $od->order_id, $od->product_id, $od->quantity, $od->selling_price);
}

echo "\nPurchase details for these products:\n";
$pds = DB::table('purchase_order_details')->whereIn('product_id', [567, 568, 569, 736, 737])->get();
foreach ($pds as $pd) {
    echo sprintf("PD ID: %d | Purchase ID: %d | Product ID: %d | Qty: %d | Cost: %s\n",
        $pd->id, $pd->purchase_id, $pd->product_id, $pd->quantity, $pd->cost_price);
}
