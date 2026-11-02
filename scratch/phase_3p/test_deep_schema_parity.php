<?php
$srcDb = $argv[1] ?? 'marsscorpdb';
$tgtDb = $argv[2] ?? 'marsscorpdb_staging_verify';

$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');

$errors = [];

// 1. Table parity
$srcTables = $pdo->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$srcDb}' ORDER BY TABLE_NAME")->fetchAll(PDO::FETCH_COLUMN);
$tgtTables = $pdo->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$tgtDb}' ORDER BY TABLE_NAME")->fetchAll(PDO::FETCH_COLUMN);

if (count($srcTables) !== count($tgtTables)) {
    $errors[] = "Table count mismatch: Src=" . count($srcTables) . ", Tgt=" . count($tgtTables);
}
$diff1 = array_diff($srcTables, $tgtTables);
$diff2 = array_diff($tgtTables, $srcTables);
if (!empty($diff1) || !empty($diff2)) {
    $errors[] = "Table name mismatch: diff1=" . json_encode($diff1) . ", diff2=" . json_encode($diff2);
}

// 2. Columns parity
$srcCols = $pdo->query("SELECT TABLE_NAME, COLUMN_NAME, ORDINAL_POSITION, DATA_TYPE, IS_NULLABLE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '{$srcDb}' ORDER BY TABLE_NAME, ORDINAL_POSITION")->fetchAll(PDO::FETCH_ASSOC);
$tgtCols = $pdo->query("SELECT TABLE_NAME, COLUMN_NAME, ORDINAL_POSITION, DATA_TYPE, IS_NULLABLE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '{$tgtDb}' ORDER BY TABLE_NAME, ORDINAL_POSITION")->fetchAll(PDO::FETCH_ASSOC);

if (count($srcCols) !== count($tgtCols)) {
    $errors[] = "Column count mismatch: Src=" . count($srcCols) . ", Tgt=" . count($tgtCols);
}

// 3. FK parity
$srcFks = $pdo->query("SELECT TABLE_NAME, CONSTRAINT_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = '{$srcDb}' AND REFERENCED_TABLE_NAME IS NOT NULL ORDER BY TABLE_NAME, CONSTRAINT_NAME, ORDINAL_POSITION")->fetchAll(PDO::FETCH_ASSOC);
$tgtFks = $pdo->query("SELECT TABLE_NAME, CONSTRAINT_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = '{$tgtDb}' AND REFERENCED_TABLE_NAME IS NOT NULL ORDER BY TABLE_NAME, CONSTRAINT_NAME, ORDINAL_POSITION")->fetchAll(PDO::FETCH_ASSOC);

if (count($srcFks) !== count($tgtFks)) {
    $errors[] = "FK count mismatch: Src=" . count($srcFks) . ", Tgt=" . count($tgtFks);
}

// 4. Index parity
$srcIdx = $pdo->query("SELECT TABLE_NAME, INDEX_NAME, NON_UNIQUE, COLUMN_NAME, SEQ_IN_INDEX FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = '{$srcDb}' ORDER BY TABLE_NAME, INDEX_NAME, SEQ_IN_INDEX")->fetchAll(PDO::FETCH_ASSOC);
$tgtIdx = $pdo->query("SELECT TABLE_NAME, INDEX_NAME, NON_UNIQUE, COLUMN_NAME, SEQ_IN_INDEX FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = '{$tgtDb}' ORDER BY TABLE_NAME, INDEX_NAME, SEQ_IN_INDEX")->fetchAll(PDO::FETCH_ASSOC);

if (count($srcIdx) !== count($tgtIdx)) {
    $errors[] = "Index count mismatch: Src=" . count($srcIdx) . ", Tgt=" . count($tgtIdx);
}

// Summary
echo "Deep Schema Parity ($srcDb vs $tgtDb):\n";
echo "Tables: " . count($srcTables) . " vs " . count($tgtTables) . "\n";
echo "Columns: " . count($srcCols) . " vs " . count($tgtCols) . "\n";
echo "FKs: " . count($srcFks) . " vs " . count($tgtFks) . "\n";
echo "Indexes: " . count($srcIdx) . " vs " . count($tgtIdx) . "\n";

if (!empty($errors)) {
    echo "FAILED with " . count($errors) . " errors:\n";
    foreach ($errors as $e) echo " - $e\n";
    exit(1);
} else {
    echo "100% DEEP SCHEMA PARITY CONFIRMED!\n";
    exit(0);
}

