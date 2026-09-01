<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "=== ORDER_DETAILS TABLE COLUMNS ===\n";
print_r(Schema::getColumnListing('order_details'));

echo "\n=== ORDER_DETAILS SAMPLE DATA ===\n";
$sample = DB::table('order_details')->latest('id')->limit(5)->get();
print_r($sample);

echo "\n=== ORDERS SAMPLE DATA ===\n";
$orders = DB::table('orders')->latest('id')->limit(5)->get();
print_r($orders);
