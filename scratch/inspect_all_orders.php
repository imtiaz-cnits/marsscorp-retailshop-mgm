<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Check if orders has soft deletes
$hasDeletedAt = Illuminate\Support\Facades\Schema::hasColumn('orders', 'deleted_at');
echo "orders has deleted_at: " . ($hasDeletedAt ? 'YES' : 'NO') . PHP_EOL;

// Check all orders in ERP
$allOrders = DB::table('orders')->get();
echo "Total orders in orders table: " . $allOrders->count() . PHP_EOL;

// Group orders by customer_id
$customerOrderCounts = DB::table('orders')
    ->select('customer_id', DB::raw('count(*) as count'), DB::raw('sum(due_amount) as total_due'))
    ->groupBy('customer_id')
    ->get();

echo "Orders by customer_id:\n";
foreach ($customerOrderCounts as $c) {
    $cust = DB::table('customers')->where('id', $c->customer_id)->first();
    echo sprintf("Customer ID: %s (%s) | Orders: %d | Total Due: %s\n", $c->customer_id, $cust->customer_name ?? 'UNKNOWN', $c->count, $c->total_due);
}

