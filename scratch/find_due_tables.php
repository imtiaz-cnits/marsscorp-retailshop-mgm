<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = DB::select("SHOW TABLES");
foreach ($tables as $t) {
    $tbl = array_values((array)$t)[0];
    if (strpos($tbl, 'due') !== false || strpos($tbl, 'prev') !== false || strpos($tbl, 'customer') !== false || strpos($tbl, 'cpd') !== false) {
        echo "Table: $tbl\n";
    }
}

