<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$tables = DB::select("SHOW TABLES LIKE 'battery_%'");
$counts = [];
foreach ($tables as $t) {
    $tname = array_values((array)$t)[0];
    $c = DB::table($tname)->count();
    $counts[$tname] = $c;
}
echo json_encode($counts, JSON_PRETTY_PRINT) . PHP_EOL;

