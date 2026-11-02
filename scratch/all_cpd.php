<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== ALL CUSTOMER PAYMENT DETAILS IN ERP ===\n";
$allCpd = DB::table('customer_payment_details')->orderBy('id')->get();
foreach ($allCpd as $c) {
    echo sprintf("ID: %-3d | Cust: %-3d | Date: %s | Paid: %-8s | Disc: %-5s | PrevDue: %-8s | Due: %-8s | Method: %-6s | Created: %s\n",
        $c->id, $c->customer_id, $c->due_collection_date, $c->paid_amount, $c->discount_amount, $c->previous_due_amount, $c->due_amount, $c->payment_method ?? '', $c->created_at);
}

