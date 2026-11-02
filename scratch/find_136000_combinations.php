<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== SEARCHING FOR COMBINATIONS EQUALING 136000 ===\n";

// Check all orders in September 2026
$sepOrders = DB::table('orders')->whereBetween('invoice_date', ['2026-09-01', '2026-10-06'])->get();
echo "Orders between Sep 1 and Oct 6: " . $sepOrders->count() . "\n";
$sum = 0;
foreach ($sepOrders as $o) {
    if (abs((float)$o->sub_total - 136000) < 1 || abs((float)$o->due_amount - 136000) < 1) {
        echo "Found order matching 136000: " . json_encode($o) . "\n";
    }
}

// Check all CPDs
$cpds = DB::table('customer_payment_details')->whereBetween('due_collection_date', ['2026-09-01', '2026-10-06'])->get();
echo "CPDs between Sep 1 and Oct 6: " . $cpds->count() . "\n";
foreach ($cpds as $c) {
    if (abs((float)$c->paid_amount - 136000) < 1) {
        echo "Found CPD matching 136000: " . json_encode($c) . "\n";
    }
}

// Check sum of CPDs for other customers that might have been misallocated
$cpdByCust = DB::table('customer_payment_details')->whereBetween('due_collection_date', ['2026-09-07', '2026-10-06'])
    ->select('customer_id', DB::raw('sum(paid_amount) as total_paid'))
    ->groupBy('customer_id')
    ->get();
echo "CPD sum by customer between Sep 7 and Oct 6:\n";
foreach ($cpdByCust as $cc) {
    echo "Cust ID: {$cc->customer_id} | Total Paid: {$cc->total_paid}\n";
}
