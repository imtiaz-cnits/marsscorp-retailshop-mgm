<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$custs = DB::table('customers')->where('customer_name', 'LIKE', '%saleha%')->orWhere('mobile', 'LIKE', '%01711387958%')->get();
echo "Customers matching Saleha or mobile:\n";
foreach ($custs as $c) {
    echo json_encode($c, JSON_PRETTY_PRINT) . PHP_EOL;
}

