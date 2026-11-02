<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== SEARCHING FOR 136000 ACROSS ALL TABLES ===\n";
$tables = DB::select('SHOW TABLES');
$tableKey = 'Tables_in_' . config('database.connections.mysql.database');

foreach ($tables as $t) {
    $tbl = $t->$tableKey;
    $cols = DB::getSchemaBuilder()->getColumnListing($tbl);
    foreach ($cols as $c) {
        $found = DB::table($tbl)->where($c, 'LIKE', '%136000%')->get();
        if ($found->isNotEmpty()) {
            foreach ($found as $r) {
                echo "Table: $tbl | Column: $c | Row: " . json_encode($r) . "\n";
            }
        }
    }
}
echo "Search finished.\n";

