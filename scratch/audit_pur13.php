<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== PURCHASE_ORDER_DETAILS SCHEMA ===\n";
print_r(Schema::getColumnListing('purchase_order_details'));

echo "\n=== PURCHASE_PAYMENT_DETAILS SCHEMA ===\n";
print_r(Schema::getColumnListing('purchase_payment_details'));

echo "\n=== SUPPLIERS SCHEMA ===\n";
print_r(Schema::getColumnListing('suppliers'));

echo "\n=== SUPPLIER DUE COLLECTIONS SCHEMA ===\n";
print_r(Schema::getColumnListing('supplier_due_collections'));

echo "\n=== DETAILS OF PURCHASE #PurID00013 (id=13) ===\n";
$items = DB::table('purchase_order_details')
    ->leftJoin('products', 'purchase_order_details.product_id', '=', 'products.id')
    ->where('purchase_order_details.purchase_id', 13)
    ->select('purchase_order_details.*', 'products.product_name')
    ->get();

echo "Total Line Items: " . $items->count() . "\n";
$calcSubtotal = 0;
foreach ($items as $idx => $it) {
    $cost = (float)($it->cost_price ?? $it->unit_cost ?? $it->price ?? 0);
    $qty = (float)$it->quantity;
    $lineTotal = (float)($it->total ?? ($cost * $qty));
    $calcSubtotal += $lineTotal;
    echo sprintf(
        "Line %2d | ID: %4d | ProdID: %4d | %-32s | Qty: %3s | Cost: %10.2f | LineTotal: %10.2f\n",
        $idx + 1,
        $it->id,
        $it->product_id,
        substr($it->product_name ?? 'N/A', 0, 32),
        $qty,
        $cost,
        $lineTotal
    );
}

echo "\nCalculated Subtotal of 34 items: " . number_format($calcSubtotal, 2) . "\n";

echo "\n=== PAYMENT DETAILS FOR PURCHASE 13 ===\n";
$payments = DB::table('purchase_payment_details')->where('purchases_id', 13)->get();
print_r($payments->toArray());

echo "\n=== SUPPLIER #9 INFO ===\n";
$supplier = DB::table('suppliers')->where('id', 9)->first();
print_r((array)$supplier);

echo "\n=== SUPPLIER DUE COLLECTIONS FOR SUPPLIER #9 ===\n";
$collections = DB::table('supplier_due_collections')->where('supplier_id', 9)->get();
print_r($collections->toArray());

echo "\n=== ALL PURCHASES FOR SUPPLIER #9 ===\n";
$allPurchases = DB::table('purchases')->where('supplier_id', 9)->get();
print_r($allPurchases->toArray());

