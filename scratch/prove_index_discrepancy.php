<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== INDEX DISCREPANCY FORENSIC PROOF ===\n";

$distinctCount = DB::select("SELECT COUNT(DISTINCT TABLE_NAME, INDEX_NAME) as cnt FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = 'marsscorpdb'")[0]->cnt;
$totalRows = DB::select("SELECT COUNT(*) as cnt FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = 'marsscorpdb'")[0]->cnt;

echo "Distinct Physical Indexes (TABLE_NAME + INDEX_NAME): $distinctCount\n";
echo "Total Rows in information_schema.STATISTICS: $totalRows\n";
echo "Difference (Secondary Column Parts in Composite Indexes): " . ($totalRows - $distinctCount) . "\n\n";

echo "=== THE EXACT 6 COMPOSITE INDEX SECONDARY COLUMN PARTS ===\n";
$secondaryCols = DB::select("
    SELECT TABLE_NAME, INDEX_NAME, SEQ_IN_INDEX, COLUMN_NAME, NON_UNIQUE
    FROM information_schema.STATISTICS
    WHERE TABLE_SCHEMA = 'marsscorpdb' AND SEQ_IN_INDEX > 1
    ORDER BY TABLE_NAME, INDEX_NAME, SEQ_IN_INDEX
");

printf("%-30s | %-35s | %-5s | %-20s\n", "Table Name", "Index Name", "Seq", "Column Name");
echo str_repeat("-", 100) . "\n";
foreach ($secondaryCols as $col) {
    printf("%-30s | %-35s | %-5d | %-20s\n", $col->TABLE_NAME, $col->INDEX_NAME, $col->SEQ_IN_INDEX, $col->COLUMN_NAME);
}

