<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = DB::select('SHOW TABLES');
$tableKey = 'Tables_in_' . config('database.connections.mysql.database');

echo "Searching for 29620, 253300 across all tables...\n";
$matches = [];
foreach ($tables as $t) {
    $tbl = $t->$tableKey;
    $cols = DB::getSchemaBuilder()->getColumnListing($tbl);
    foreach ($cols as $c) {
        $found = DB::table($tbl)->where($c, 'LIKE', '%29620%')->orWhere($c, 'LIKE', '%253300%')->get();
        if ($found->isNotEmpty()) {
            foreach ($found as $row) {
                $matches[] = "Table: $tbl | Column: $c | Row: " . json_encode($row);
            }
        }
    }
}

if (empty($matches)) {
    echo "NO direct match found for '29620' or '253300' in ANY table.\n";
} else {
    foreach ($matches as $m) {
        echo $m . "\n";
    }
}

