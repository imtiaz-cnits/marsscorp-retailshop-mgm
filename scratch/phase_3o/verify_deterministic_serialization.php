<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== WORKSTREAM F: RIGOROUS DETERMINISTIC SERIALIZATION & BACKUP INTEGRITY ===\n";

$sourceTables = [
    'users', 'customers', 'customer_payment_details', 'suppliers', 'supplier_due_collections',
    'categories', 'sub_categories', 'brands', 'units', 'products', 'purchases',
    'purchase_order_details', 'purchase_payment_details', 'orders', 'order_details'
];

function getStrictDeterministicTableHash($dbName, $tableName) {
    // 1. Column ordering strictly by ORDINAL_POSITION
    $columns = DB::select("
        SELECT COLUMN_NAME, DATA_TYPE, NUMERIC_PRECISION, NUMERIC_SCALE 
        FROM information_schema.COLUMNS 
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? 
        ORDER BY ORDINAL_POSITION
    ", [$dbName, $tableName]);
    
    // 2. Data type-specific canonical serialization
    $colExprs = array_map(function($c) {
        $name = '`' . $c->COLUMN_NAME . '`';
        $type = strtolower($c->DATA_TYPE);
        
        // Date/Time normalization
        if (in_array($type, ['datetime', 'timestamp'])) {
            return "DATE_FORMAT($name, '%Y-%m-%d %H:%i:%s')";
        }
        if ($type === 'date') {
            return "DATE_FORMAT($name, '%Y-%m-%d')";
        }
        if ($type === 'time') {
            return "DATE_FORMAT($name, '%H:%i:%s')";
        }
        // Binary/Blob lossless hex encoding
        if (in_array($type, ['blob', 'tinyblob', 'mediumblob', 'longblob', 'binary', 'varbinary'])) {
            return "HEX($name)";
        }
        // Floating point / Decimal precision stabilization
        if (in_array($type, ['decimal', 'numeric'])) {
            $scale = $c->NUMERIC_SCALE ?? 2;
            return "FORMAT($name, $scale)";
        }
        return $name;
    }, $columns);
    
    $jsonExpr = "JSON_ARRAY(" . implode(', ', $colExprs) . ")";
    
    // 3. Deterministic row ordering strictly by Primary Key
    $pks = DB::select("
        SELECT COLUMN_NAME 
        FROM information_schema.KEY_COLUMN_USAGE 
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND CONSTRAINT_NAME = 'PRIMARY' 
        ORDER BY ORDINAL_POSITION
    ", [$dbName, $tableName]);
    
    $orderBy = !empty($pks) ? implode(', ', array_map(function($p) { return '`' . $p->COLUMN_NAME . '`'; }, $pks)) : $colExprs[0];
    
    // 4. Stream rows with deterministic newline row boundary
    $rows = DB::select("SELECT $jsonExpr AS canonical_row FROM `$dbName`.`$tableName` ORDER BY $orderBy");
    
    $ctx = hash_init('sha256');
    foreach ($rows as $r) {
        hash_update($ctx, $r->canonical_row . "\n");
    }
    
    return [
        'count' => count($rows),
        'hash' => hash_final($ctx),
        'sample' => !empty($rows) ? $rows[0]->canonical_row : 'EMPTY'
    ];
}

echo "Computing strict deterministic hashes for production (marsscorpdb) and staging (marsscorpdb_staging_verify)...\n";
printf("%-26s | %-6s | %-64s | %-64s | %-6s\n", "Table Name", "Rows", "Production Hash", "Staging Hash", "Parity");
echo str_repeat("-", 175) . "\n";

$allMatch = true;
$hashCatalog = [];

foreach ($sourceTables as $tbl) {
    $prod = getStrictDeterministicTableHash('marsscorpdb', $tbl);
    $stage = getStrictDeterministicTableHash('marsscorpdb_staging_verify', $tbl);
    $match = ($prod['count'] === $stage['count'] && $prod['hash'] === $stage['hash']);
    if (!$match) $allMatch = false;
    
    printf("%-26s | %-6d | %-64s | %-64s | %-6s\n", $tbl, $prod['count'], $prod['hash'], $stage['hash'], ($match ? "MATCH" : "MISMATCH"));
    $hashCatalog[$tbl] = [
        'rows' => $prod['count'],
        'prod_hash' => $prod['hash'],
        'stage_hash' => $stage['hash'],
        'match' => $match,
        'sample' => $prod['sample']
    ];
}

echo str_repeat("-", 175) . "\n";
echo "STRICT DETERMINISTIC PARITY VERDICT: " . ($allMatch ? "15/15 100% BIT-FOR-BIT IDENTICAL" : "FAILURES DETECTED") . "\n";

file_put_contents('scratch/phase_3o/deterministic_hashes_catalog.json', json_encode($hashCatalog, JSON_PRETTY_PRINT));

