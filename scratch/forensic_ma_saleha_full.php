<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== CUSTOMER ID 1 (MA SALEHA ENTERPICE) FORENSIC INSPECTION ===\n";
$customer = DB::table('customers')->where('id', 1)->first();
echo "Customer ID: {$customer->id} (Code: {$customer->customer_id})\n";
echo "Name: {$customer->customer_name}\n";
echo "Current previous_due_amount in DB: {$customer->previous_due_amount}\n";
echo "Created At: {$customer->created_at}\n";
echo "Updated At: {$customer->updated_at}\n\n";

echo "=== CPD RECORDS (ORDERED BY ID) ===\n";
$cpds = DB::table('customer_previous_dues')
    ->where('customer_id', 1)
    ->orderBy('id', 'asc')
    ->get();

$running = 409680.00;
echo "Opening previous_due_amount baseline: 409,680.00\n";
printf("%-4s | %-12s | %-19s | %-19s | %-10s | %-12s | %-12s\n", 
    "ID", "Pay Date", "Created At", "Updated At", "Paid Amt", "Stored Due", "Running Math");
echo str_repeat("-", 105) . "\n";

foreach ($cpds as $c) {
    $running -= (float)$c->payment_amount;
    printf("%-4d | %-12s | %-19s | %-19s | %-10.2f | %-12.2f | %-12.2f\n",
        $c->id,
        $c->previous_due_date,
        $c->created_at,
        $c->updated_at,
        (float)$c->payment_amount,
        (float)$c->current_due_amount,
        $running
    );
}

echo "\n=== ORDERS FOR CUSTOMER ID 1 ===\n";
$orders = DB::table('orders')->where('customer_id', 1)->get();
foreach ($orders as $o) {
    echo "Order ID: {$o->id}, Order No: {$o->order_no}, Date: {$o->order_date}, Created: {$o->created_at}, Total: {$o->total_amount}, Paid: {$o->paid_amount}, Due: {$o->due_amount}\n";
}
