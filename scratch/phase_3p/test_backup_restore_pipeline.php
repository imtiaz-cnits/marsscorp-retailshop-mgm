<?php
/**
 * scratch/phase_3p/test_backup_restore_pipeline.php
 * Workstream D: Fresh Backup & Restore Pipeline Drill
 */

$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "=================================================================\n";
echo "WORKSTREAM D: FRESH BACKUP & RESTORE PIPELINE DRILL\n";
echo "=================================================================\n\n";

$sourceDb = 'marsscorpdb';
$targetDb = 'marsscorpdb_p3p_restore_test';
$dumpFile = __DIR__ . '/p3p_pipeline_test.sql';

// 1. Clean up target db if exists
$pdo->exec("DROP DATABASE IF EXISTS `{$targetDb}`");
$pdo->exec("CREATE DATABASE `{$targetDb}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
echo "[Step 1] Created fresh clean database: {$targetDb}\n";

// 2. Execute mysqldump
$mysqldumpExe = 'C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysqldump.exe';
$cmd = "\"{$mysqldumpExe}\" -h 127.0.0.1 -P 3306 -u root --single-transaction --quick --no-autocommit --routines --triggers --hex-blob --result-file=\"{$dumpFile}\" {$sourceDb} 2>&1";
echo "[Step 2] Executing mysqldump: {$cmd}\n";
exec($cmd, $dumpOutput, $dumpExit);

echo "  mysqldump Exit Code: {$dumpExit}\n";
if ($dumpExit !== 0) {
    die("CRITICAL FAILURE: mysqldump failed with exit code {$dumpExit}\n");
}

$fileSize = filesize($dumpFile);
echo "  Dump file size: " . number_format($fileSize) . " bytes\n";
if ($fileSize <= 0) {
    die("CRITICAL FAILURE: Dump file is empty!\n");
}

// Check trailer
$fileHandle = fopen($dumpFile, 'r');
fseek($fileHandle, max(0, $fileSize - 1024));
$trailerChunk = fread($fileHandle, 1024);
fclose($fileHandle);

$hasTrailer = strpos($trailerChunk, 'Dump completed on') !== false;
echo "  Trailer check ('Dump completed on'): " . ($hasTrailer ? "PASS" : "FAIL") . "\n";
if (!$hasTrailer) {
    die("CRITICAL FAILURE: Dump file trailer missing!\n");
}

$dumpSha256 = hash_file('sha256', $dumpFile);
echo "  Dump SHA-256: {$dumpSha256}\n";

// 3. Restore dump into targetDb
$mysqlExe = 'C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe';
$restoreCmd = "\"{$mysqlExe}\" -h 127.0.0.1 -P 3306 -u root {$targetDb} < \"{$dumpFile}\"";
echo "[Step 3] Restoring dump into {$targetDb}...\n";
exec("cmd /c \"{$restoreCmd}\"", $restoreOutput, $restoreExit);
echo "  mysql restore Exit Code: {$restoreExit}\n";
if ($restoreExit !== 0) {
    die("CRITICAL FAILURE: Restore failed with exit code {$restoreExit}\n");
}

// 4. Verification Drill
echo "\n[Step 4] Running In-Depth Schema & Integrity Verification...\n";

// A. Table count parity
$srcTables = $pdo->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$sourceDb}' ORDER BY TABLE_NAME")->fetchAll(PDO::FETCH_COLUMN);
$tgtTables = $pdo->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$targetDb}' ORDER BY TABLE_NAME")->fetchAll(PDO::FETCH_COLUMN);
$tablesParity = ($srcTables === $tgtTables);
echo "  • Table Count: Source=" . count($srcTables) . ", Target=" . count($tgtTables) . " -> " . ($tablesParity ? "PASS" : "FAIL") . "\n";

// B. Column count parity
$srcCols = $pdo->query("SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, IS_NULLABLE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '{$sourceDb}' ORDER BY TABLE_NAME, ORDINAL_POSITION")->fetchAll(PDO::FETCH_NUM);
$tgtCols = $pdo->query("SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, IS_NULLABLE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '{$targetDb}' ORDER BY TABLE_NAME, ORDINAL_POSITION")->fetchAll(PDO::FETCH_NUM);
$colsParity = ($srcCols === $tgtCols);
echo "  • Columns Parity: Source=" . count($srcCols) . ", Target=" . count($tgtCols) . " -> " . ($colsParity ? "PASS" : "FAIL") . "\n";

// C. Primary Keys parity
$srcPKs = $pdo->query("SELECT TABLE_NAME, COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = '{$sourceDb}' AND CONSTRAINT_NAME = 'PRIMARY' ORDER BY TABLE_NAME, ORDINAL_POSITION")->fetchAll(PDO::FETCH_NUM);
$tgtPKs = $pdo->query("SELECT TABLE_NAME, COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = '{$targetDb}' AND CONSTRAINT_NAME = 'PRIMARY' ORDER BY TABLE_NAME, ORDINAL_POSITION")->fetchAll(PDO::FETCH_NUM);
$pkParity = ($srcPKs === $tgtPKs);
echo "  • Primary Keys Parity: Source=" . count($srcPKs) . ", Target=" . count($tgtPKs) . " -> " . ($pkParity ? "PASS" : "FAIL") . "\n";

// D. Foreign Keys parity (45 FKs)
$srcFKs = $pdo->query("SELECT TABLE_NAME, CONSTRAINT_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = '{$sourceDb}' AND REFERENCED_TABLE_NAME IS NOT NULL ORDER BY TABLE_NAME, CONSTRAINT_NAME, ORDINAL_POSITION")->fetchAll(PDO::FETCH_NUM);
$tgtFKs = $pdo->query("SELECT TABLE_NAME, CONSTRAINT_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = '{$targetDb}' AND REFERENCED_TABLE_NAME IS NOT NULL ORDER BY TABLE_NAME, CONSTRAINT_NAME, ORDINAL_POSITION")->fetchAll(PDO::FETCH_NUM);
$fkParity = ($srcFKs === $tgtFKs);
echo "  • Foreign Keys Parity (45 FKs): Source=" . count($srcFKs) . ", Target=" . count($tgtFKs) . " -> " . ($fkParity ? "PASS" : "FAIL") . "\n";

// E. Index Count parity (174 distinct indexes)
$srcIdx = $pdo->query("SELECT TABLE_NAME, INDEX_NAME, NON_UNIQUE, COLUMN_NAME, SEQ_IN_INDEX FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = '{$sourceDb}' ORDER BY TABLE_NAME, INDEX_NAME, SEQ_IN_INDEX")->fetchAll(PDO::FETCH_NUM);
$tgtIdx = $pdo->query("SELECT TABLE_NAME, INDEX_NAME, NON_UNIQUE, COLUMN_NAME, SEQ_IN_INDEX FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = '{$targetDb}' ORDER BY TABLE_NAME, INDEX_NAME, SEQ_IN_INDEX")->fetchAll(PDO::FETCH_NUM);
$idxParity = ($srcIdx === $tgtIdx);
echo "  • Indexes Parity (174 entries): Source=" . count($srcIdx) . ", Target=" . count($tgtIdx) . " -> " . ($idxParity ? "PASS" : "FAIL") . "\n";

// F. Canonical row hashing on 15 source Retail tables
$retail15 = [
    'categories', 'brands', 'units', 'expense_types', 'suppliers', 'customers',
    'products', 'expenses', 'purchases', 'purchase_order_details', 'purchase_payment_details',
    'orders', 'order_details', 'order_payment_details', 'customer_payment_details'
];

echo "\n  • Canonical Row Hashing (15 Source Retail Tables):\n";
$hashMismatches = 0;
foreach ($retail15 as $tbl) {
    // Get columns
    $cols = $pdo->query("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '{$sourceDb}' AND TABLE_NAME = '{$tbl}' ORDER BY ORDINAL_POSITION")->fetchAll(PDO::FETCH_COLUMN);
    $concatExpr = "CONCAT_WS('#', " . implode(', ', array_map(function($c) { return "COALESCE(`{$c}`, 'NULL')"; }, $cols)) . ")";
    
    $srcHashSql = "SELECT SHA2(GROUP_CONCAT(SHA2({$concatExpr}, 256) ORDER BY id SEPARATOR ''), 256) AS h FROM `{$sourceDb}`.`{$tbl}`";
    $tgtHashSql = "SELECT SHA2(GROUP_CONCAT(SHA2({$concatExpr}, 256) ORDER BY id SEPARATOR ''), 256) AS h FROM `{$targetDb}`.`{$tbl}`";
    
    $srcHash = $pdo->query($srcHashSql)->fetchColumn();
    $tgtHash = $pdo->query($tgtHashSql)->fetchColumn();
    
    $match = ($srcHash === $tgtHash);
    if (!$match) $hashMismatches++;
    echo "    - Table {$tbl}: " . ($match ? "MATCH" : "MISMATCH") . " (" . substr($srcHash ?? 'EMPTY', 0, 16) . "...)\n";
}

// G. Financial sanity check on restored DB
$nurDue = $pdo->query("SELECT previous_due_amount FROM `{$targetDb}`.customers WHERE id = 2")->fetchColumn();
$riyazDue = $pdo->query("SELECT previous_due_amount FROM `{$targetDb}`.customers WHERE id = 5")->fetchColumn();
$order53Due = $pdo->query("SELECT due_amount FROM `{$targetDb}`.orders WHERE id = 53")->fetchColumn();
$poloPayable = $pdo->query("SELECT purchase_payable_amount FROM `{$targetDb}`.suppliers WHERE id = 1")->fetchColumn();
$ck124PurDue = $pdo->query("SELECT due_amount FROM `{$targetDb}`.purchases WHERE id = 15")->fetchColumn();

echo "\n  • Restored DB Financial Baselines:\n";
echo "    - Nur Battery Customer Previous Due: ৳{$nurDue} (Expected: 467465.00)\n";
echo "    - Riyaz Customer Previous Due: ৳{$riyazDue} (Expected: 23592.00)\n";
echo "    - Order #53 Due: ৳{$order53Due} (Expected: 37674.00)\n";
echo "    - Polo Battery Supplier Payable: ৳{$poloPayable} (Expected: 7360.00)\n";
echo "    - Purchase #15 Due: ৳{$ck124PurDue} (Expected: 108000.00)\n";

$financialPass = (
    abs($nurDue - 467465.00) < 0.01 &&
    abs($riyazDue - 23592.00) < 0.01 &&
    abs($order53Due - 37674.00) < 0.01 &&
    abs($poloPayable - 7360.00) < 0.01 &&
    abs($ck124PurDue - 108000.00) < 0.01
);

echo "    - Financial Baseline Status: " . ($financialPass ? "PASS" : "FAIL") . "\n";

// 5. Cleanup
echo "\n[Step 5] Dropping disposable test database {$targetDb} and temporary dump file...\n";
$pdo->exec("DROP DATABASE IF EXISTS `{$targetDb}`");
if (file_exists($dumpFile)) {
    unlink($dumpFile);
}
echo "  Cleanup complete.\n";

$allPassed = ($dumpExit === 0 && $fileSize > 0 && $hasTrailer && $restoreExit === 0 && $tablesParity && $colsParity && $pkParity && $fkParity && $idxParity && $hashMismatches === 0 && $financialPass);

echo "\nFINAL WORKSTREAM D PIPELINE DRILL: " . ($allPassed ? "100% PASS" : "FAIL") . "\n";
