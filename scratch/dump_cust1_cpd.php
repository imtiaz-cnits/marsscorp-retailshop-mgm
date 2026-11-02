<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$cpds = DB::table('customer_payment_details')->where('customer_id', 1)->orderBy('id')->get();
foreach ($cpds as $c) {
    echo json_encode($c, JSON_PRETTY_PRINT) . PHP_EOL;
}

