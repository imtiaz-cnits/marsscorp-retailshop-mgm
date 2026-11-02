<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Orders columns: " . implode(', ', Schema::getColumnListing('orders')) . PHP_EOL;
echo "CPD columns: " . implode(', ', Schema::getColumnListing('customer_payment_details')) . PHP_EOL;

$firstOrder = DB::table('orders')->where('customer_id', 1)->first();
echo "Sample order: " . json_encode($firstOrder, JSON_PRETTY_PRINT) . PHP_EOL;

