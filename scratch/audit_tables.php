<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$rawTables = DB::select('SHOW TABLES');
$dbName = DB::getDatabaseName();
$prop = "Tables_in_" . $dbName;
$tables = array_map(fn($t) => $t->$prop, $rawTables);

$returnTables = array_filter($tables, fn($t) => stripos($t, 'return') !== false);
echo "Return tables:\n" . json_encode(array_values($returnTables), JSON_PRETTY_PRINT) . "\n";

foreach ($returnTables as $table) {
    echo "\nTable '{$table}' columns:\n" . json_encode(Schema::getColumnListing($table)) . "\n";
}
