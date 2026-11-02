<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb_staging_verify', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$initialCount = (int)$pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
echo "Initial orders count: {$initialCount}\n";

// Case A: Test when lock is NOT held (should insert inside transaction and immediately ROLLBACK)
echo "--- Testing Probe Behavior when lock is NOT held ---\n";
$pdo->beginTransaction();
try {
    $pdo->exec("INSERT INTO orders (order_no, sub_total, user_id) VALUES ('MDL-TEST-UNLOCKED', 1, 1)");
    $countDuringTx = (int)$pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
    echo "Count during transaction: {$countDuringTx}\n";
    $pdo->rollBack();
    echo "Rolled back probe transaction.\n";
} catch (\Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    echo "Exception: " . $e->getMessage() . "\n";
}
$countAfterRollback = (int)$pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
echo "Count after rollback: {$countAfterRollback} (Unchanged: " . ($initialCount === $countAfterRollback ? "YES" : "NO") . ")\n";

// Case B: Test when lock IS held
echo "\n--- Testing Probe Behavior when lock IS held ---\n";
// Connection 1 locks orders
$lockConn = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb_staging_verify', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$lockConn->exec("LOCK TABLES orders READ");

// Connection 2 attempts probe with timeout
$probeConn = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb_staging_verify', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$probeConn->exec("SET SESSION lock_wait_timeout = 2");

$probeConn->beginTransaction();
$probeStatus = "UNKNOWN";
try {
    $probeConn->exec("INSERT INTO orders (order_no, sub_total) VALUES ('MDL-TEST-LOCKED', 1)");
    $probeConn->rollBack();
    $probeStatus = "FAIL_UNLOCKED";
} catch (\PDOException $e) {
    if ($probeConn->inTransaction()) $probeConn->rollBack();
    if (strpos($e->getMessage(), '1205') !== false || strpos($e->getMessage(), 'Lock wait timeout') !== false) {
        $probeStatus = "PASS_MDL_LOCKED";
    } else {
        $probeStatus = "ERROR: " . $e->getMessage();
    }
}
$lockConn->exec("UNLOCK TABLES");

echo "Probe status with lock active: {$probeStatus}\n";
$finalCount = (int)$pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
echo "Final orders count: {$finalCount} (100% Unchanged: " . ($initialCount === $finalCount ? "YES" : "NO") . ")\n";

if ($probeStatus === "PASS_MDL_LOCKED" && $initialCount === $finalCount) {
    echo "SAFE TABLE-LOCK PROBE DRILL: 100% PASS!\n";
    exit(0);
} else {
    echo "SAFE TABLE-LOCK PROBE DRILL: FAIL!\n";
    exit(1);
}
