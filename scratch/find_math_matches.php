<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "order_details columns: " . implode(', ', Schema::getColumnListing('order_details')) . PHP_EOL;

$allAmounts = [];
$orders = DB::table('orders')->get();
foreach ($orders as $o) {
    foreach ((array)$o as $k => $v) {
        if (is_numeric($v) && (float)$v > 0) $allAmounts["order_{$o->id}_{$k}"] = (float)$v;
    }
}
$orderDetails = DB::table('order_details')->get();
foreach ($orderDetails as $od) {
    foreach ((array)$od as $k => $v) {
        if (is_numeric($v) && (float)$v > 0) $allAmounts["od_{$od->id}_{$k}"] = (float)$v;
    }
}
$cpd = DB::table('customer_payment_details')->get();
foreach ($cpd as $c) {
    foreach ((array)$c as $k => $v) {
        if (is_numeric($v) && (float)$v > 0) $allAmounts["cpd_{$c->id}_{$k}"] = (float)$v;
    }
}
$customers = DB::table('customers')->get();
foreach ($customers as $cu) {
    foreach ((array)$cu as $k => $v) {
        if (is_numeric($v) && (float)$v > 0) $allAmounts["cust_{$cu->id}_{$k}"] = (float)$v;
    }
}

echo "Total numeric fields collected: " . count($allAmounts) . PHP_EOL;

foreach ($allAmounts as $k => $v) {
    if (abs($v - 29620) < 0.01) echo "EXACT MATCH FOR 29620: $k = $v\n";
    if (abs($v - 253300) < 0.01) echo "EXACT MATCH FOR 253300: $k = $v\n";
}

$keys = array_keys($allAmounts);
$count = count($keys);
for ($i = 0; $i < $count; $i++) {
    for ($j = $i + 1; $j < $count; $j++) {
        $k1 = $keys[$i];
        $k2 = $keys[$j];
        $v1 = $allAmounts[$k1];
        $v2 = $allAmounts[$k2];
        if (abs(($v1 + $v2) - 29620) < 0.01) echo "SUM MATCH 29620: $k1 ($v1) + $k2 ($v2)\n";
        if (abs(abs($v1 - $v2) - 29620) < 0.01) echo "DIFF MATCH 29620: |$k1 ($v1) - $k2 ($v2)|\n";
    }
}
