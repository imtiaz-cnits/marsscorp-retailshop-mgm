<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
$retail15 = [
    'categories', 'brands', 'units', 'expense_types', 'suppliers', 'customers',
    'products', 'expenses', 'purchases', 'purchase_order_details', 'purchase_payment_details',
    'orders', 'order_details', 'order_payment_details', 'customer_payment_details'
];

function computeStreamingTableHash(PDO $pdo, string $db, string $tbl): string {
    $cols = $pdo->query("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '{$db}' AND TABLE_NAME = '{$tbl}' ORDER BY ORDINAL_POSITION")->fetchAll(PDO::FETCH_COLUMN);
    $pkCols = $pdo->query("SELECT COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = '{$db}' AND TABLE_NAME = '{$tbl}' AND CONSTRAINT_NAME = 'PRIMARY' ORDER BY ORDINAL_POSITION")->fetchAll(PDO::FETCH_COLUMN);
    $orderBy = !empty($pkCols) ? implode(', ', array_map(fn($c) => "`{$c}`", $pkCols)) : '1';
    
    $colList = implode(', ', array_map(fn($c) => "`{$c}`", $cols));
    $stmt = $pdo->query("SELECT {$colList} FROM `{$db}`.`{$tbl}` ORDER BY {$orderBy}");
    
    $ctx = hash_init('sha256');
    $rowCount = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rowCount++;
        $serializedRow = '';
        foreach ($row as $val) {
            if ($val === null) {
                $serializedRow .= "N;";
            } else {
                $serializedRow .= "S:" . strlen($val) . ":\"{$val}\";";
            }
        }
        hash_update($ctx, $serializedRow);
    }
    // Include rowCount in hash to guarantee boundary integrity
    hash_update($ctx, "ROWCOUNT:{$rowCount}");
    return hash_final($ctx);
}

$mismatches = 0;
echo "Streaming SHA-256 Hash Verification (Source: marsscorpdb vs Staging: marsscorpdb_staging_verify):\n";
echo str_repeat('-', 90) . "\n";
printf("%-26s | %-16s | %-16s | %s\n", "Table", "Source Hash", "Staging Hash", "Status");
echo str_repeat('-', 90) . "\n";

foreach ($retail15 as $tbl) {
    $srcHash = computeStreamingTableHash($pdo, 'marsscorpdb', $tbl);
    $stgHash = computeStreamingTableHash($pdo, 'marsscorpdb_staging_verify', $tbl);
    $match = ($srcHash === $stgHash);
    if (!$match) $mismatches++;
    printf("%-26s | %-16s | %-16s | %s\n", 
        $tbl, 
        substr($srcHash, 0, 16) . '...', 
        substr($stgHash, 0, 16) . '...', 
        $match ? "MATCH" : "MISMATCH"
    );
}
echo str_repeat('-', 90) . "\n";
echo "Total Tables Checked: " . count($retail15) . " | Mismatches: $mismatches\n";
if ($mismatches > 0) exit(1);

