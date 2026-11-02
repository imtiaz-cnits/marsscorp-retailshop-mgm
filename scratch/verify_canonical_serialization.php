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

function getCanonicalTableHash($dbName, $tableName) {
    // Get columns in ordinal position
    $columns = DB::select("
        SELECT COLUMN_NAME, DATA_TYPE 
        FROM information_schema.COLUMNS 
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? 
        ORDER BY ORDINAL_POSITION
    ", [$dbName, $tableName]);
    
    // Build JSON_ARRAY expression with explicit CAST for binary/datetime if needed
    $colExprs = array_map(function($c) {
        $name = '`' . $c->COLUMN_NAME . '`';
        // Cast datetimes and dates to explicit standard strings to avoid tz/representation variance
        if (in_array(strtolower($c->DATA_TYPE), ['datetime', 'timestamp'])) {
            return "DATE_FORMAT($name, '%Y-%m-%d %H:%i:%s')";
        }
        if (in_array(strtolower($c->DATA_TYPE), ['date'])) {
            return "DATE_FORMAT($name, '%Y-%m-%d')";
        }
        return $name;
    }, $columns);
    
    $jsonExpr = "JSON_ARRAY(" . implode(', ', $colExprs) . ")";
    
    // Order by primary key or all columns
    $pks = DB::select("
        SELECT COLUMN_NAME 
        FROM information_schema.KEY_COLUMN_USAGE 
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND CONSTRAINT_NAME = 'PRIMARY' 
        ORDER BY ORDINAL_POSITION
    ", [$dbName, $tableName]);
    
    $orderBy = !empty($pks) ? implode(', ', array_map(function($p) { return '`' . $p->COLUMN_NAME . '`'; }, $pks)) : $colExprs[0];
    
    $rows = DB::select("SELECT $jsonExpr AS json_row FROM `$dbName`.`$tableName` ORDER BY $orderBy");
    
    $ctx = hash_init('sha256');
    foreach ($rows as $r) {
        hash_update($ctx, $r->json_row . "\n");
    }
    
    return [
        'count' => count($rows),
        'hash' => hash_final($ctx),
        'sample' => !empty($rows) ? $rows[0]->json_row : 'EMPTY'
    ];
}

echo "=== CANONICAL SERIALIZATION (JSON_ARRAY) 15-TABLE PARITY AUDIT ===\n";
printf("%-26s | %-6s | %-64s | %-64s | %-6s\n", "Table Name", "Rows", "Production (marsscorpdb)", "Staging (staging_verify)", "Parity");
echo str_repeat("-", 175) . "\n";

$allMatch = true;
$results = [];

foreach ($sourceTables as $tbl) {
    $prod = getCanonicalTableHash('marsscorpdb', $tbl);
    $stage = getCanonicalTableHash('marsscorpdb_staging_verify', $tbl);
    $match = ($prod['count'] === $stage['count'] && $prod['hash'] === $stage['hash']);
    if (!$match) $allMatch = false;
    
    $status = $match ? 'MATCH' : 'MISMATCH';
    printf("%-26s | %-6d | %-64s | %-64s | %-6s\n", $tbl, $prod['count'], $prod['hash'], $stage['hash'], $status);
    $results[$tbl] = [
        'rows' => $prod['count'],
        'prod_hash' => $prod['hash'],
        'stage_hash' => $stage['hash'],
        'match' => $match,
        'sample' => $prod['sample']
    ];
}

echo str_repeat("-", 175) . "\n";
echo "CANONICAL PARITY RESULT: " . ($allMatch ? "15/15 BIT-FOR-BIT CANONICAL MATCH" : "FAILURES DETECTED") . "\n";
echo "Sample Row (users): " . $results['users']['sample'] . "\n";
echo "Sample Row (customers): " . substr($results['customers']['sample'], 0, 100) . "...\n";

file_put_contents('scratch/canonical_hashes_result.json', json_encode($results, JSON_PRETTY_PRINT));

