<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

config(['database.connections.mysql.database' => 'marsscorpdb_staging_verify']);
DB::purge('mysql');
DB::reconnect('mysql');

DB::table('battery_brands')->delete();
DB::table('battery_units')->delete();
echo "Cleaned brands and units in staging.\n";

