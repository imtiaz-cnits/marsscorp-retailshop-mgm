<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$sourceTables = [
    'users',
    'customers',
    'customer_payment_details',
    'suppliers',
    'supplier_due_collections',
    'categories',
    'sub_categories',
    'brands',
    'units',
    'products',
    'purchases',
    'purchase_order_details',
    'purchase_payment_details',
    'orders',
    'order_details'
];

function getTableHash($dbName, $tableName) {
    $columns = DB::select("
        SELECT COLUMN_NAME 
        FROM information_schema.COLUMNS 
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? 
        ORDER BY ORDINAL_POSITION
    ", [$dbName, $tableName]);
    
    $colList = array_map(function($c) { return '`' . $c->COLUMN_NAME . '`'; }, $columns);
    $concatExpr = "CONCAT_WS('#', " . implode(', ', array_map(function($c) { return "COALESCE($c, 'NULL')"; }, $colList)) . ")";
    
    // Order by primary key or all columns
    $pks = DB::select("
        SELECT COLUMN_NAME 
        FROM information_schema.KEY_COLUMN_USAGE 
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND CONSTRAINT_NAME = 'PRIMARY' 
        ORDER BY ORDINAL_POSITION
    ", [$dbName, $tableName]);
    
    $orderBy = !empty($pks) ? implode(', ', array_map(function($p) { return '`' . $p->COLUMN_NAME . '`'; }, $pks)) : $colList[0];
    
    $rows = DB::select("SELECT $concatExpr AS row_str FROM `$dbName`.`$tableName` ORDER BY $orderBy");
    $ctx = hash_init('sha256');
    foreach ($rows as $r) {
        hash_update($ctx, $r->row_str . "\n");
    }
    return [
        'count' => count($rows),
        'hash' => hash_final($ctx)
    ];
}

echo "=== COMPUTING 15 SOURCE TABLE STREAMING SHA-256 PARITY ===\n";
printf("%-26s | %-6s | %-64s | %-64s | %-6s\n", "Table Name", "Rows", "Production (marsscorpdb)", "Staging (staging_verify)", "Parity");
echo str_repeat("-", 175) . "\n";

$allMatch = true;
$results = [];

foreach ($sourceTables as $tbl) {
    $prod = getTableHash('marsscorpdb', $tbl);
    $stage = getTableHash('marsscorpdb_staging_verify', $tbl);
    $match = ($prod['count'] === $stage['count'] && $prod['hash'] === $stage['hash']);
    if (!$match) $allMatch = false;
    
    $status = $match ? 'MATCH' : 'MISMATCH';
    printf("%-26s | %-6d | %-64s | %-64s | %-6s\n", $tbl, $prod['count'], $prod['hash'], $stage['hash'], $status);
    $results[$tbl] = [
        'rows' => $prod['count'],
        'prod_hash' => $prod['hash'],
        'stage_hash' => $stage['hash'],
        'match' => $match
    ];
}

echo str_repeat("-", 175) . "\n";
echo "OVERALL 15/15 PARITY: " . ($allMatch ? "ALL MATCH (100% BIT-FOR-BIT IDENTICAL)" : "FAILURES DETECTED") . "\n";
file_put_contents('scratch/source_hashes_result.json', json_encode($results, JSON_PRETTY_PRINT));

