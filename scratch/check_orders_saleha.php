<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$orders = DB::table('orders')->where('customer_id', 1)->get();
foreach ($orders as $o) {
    echo json_encode($o) . "\n";
}
echo "\nMath check: 213,180 (Total Due after CPD #31) - 94,500 (Order #62 Due) = " . (213180 - 94500) . "\n";
echo "And customers.previous_due_amount in DB is exactly: " . DB::table('customers')->where('id', 1)->value('previous_due_amount') . "\n";
