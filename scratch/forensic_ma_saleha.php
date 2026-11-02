<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$customer = DB::table('customers')->where('id', 1)->first();
echo "CUSTOMER ID 1:\n";
print_r($customer);

echo "\nORDERS FOR CUSTOMER ID 1:\n";
$orders = DB::table('orders')->where('customer_id', 1)->orderBy('id')->get();
foreach ($orders as $o) {
    echo sprintf(
        "Order ID: %d | Invoice: %s | Date: %s | Total: %s | Paid: %s | Due: %s | Prev Due: %s | Grand Total: %s\n",
        $o->id, $o->invoice_no, $o->order_date, $o->total, $o->pay_amount, $o->due_amount, $o->previous_due_amount, $o->grand_total ?? 'NULL'
    );
}

echo "\nPAYMENT DETAILS (customer_payment_details) FOR CUSTOMER ID 1:\n";
$payments = DB::table('customer_payment_details')->where('customer_id', 1)->orderBy('id')->get();
foreach ($payments as $p) {
    echo sprintf(
        "CPD ID: %d | Order ID: %s | Date: %s | Paid: %s | Prev Due: %s | Current Due: %s | Note: %s\n",
        $p->id, $p->order_id ?? 'NULL', $p->created_at, $p->pay_amount, $p->previous_due_amount ?? 'NULL', $p->current_due_amount ?? 'NULL', $p->note ?? ''
    );
}

