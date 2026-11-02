<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$prodCount = DB::table('battery_products')->count();
$stagingCount = DB::select('SELECT COUNT(*) as c FROM marsscorpdb_staging_verify.battery_products')[0]->c;
$prodActiveDb = DB::connection()->getDatabaseName();

echo "Active DB: {$prodActiveDb}\n";
echo "marsscorpdb battery_products: {$prodCount}\n";
echo "marsscorpdb_staging_verify battery_products: {$stagingCount}\n";

