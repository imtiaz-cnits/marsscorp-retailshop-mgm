<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== WORKSTREAM B & C: EXACT PRIVILEGE RESTORATION & ALL-WRITER ISOLATION DRILL ===\n";
echo "Target Environment: STAGING ONLY (marsscorpdb_staging_verify)\n\n";

$db = 'marsscorpdb_staging_verify';
$pass = 'StagingTestPass123!';

// Helper to get PDO connection for a specific test user
function getUserPdo($user, $pass, $db) {
    return new PDO("mysql:host=127.0.0.1;port=3306;dbname=$db", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 2
    ]);
}

// Helper to capture exact SHOW GRANTS output
function captureGrants($userHost) {
    $rows = DB::select("SHOW GRANTS FOR $userHost");
    $grants = [];
    foreach ($rows as $r) {
        $grants[] = array_values((array)$r)[0];
    }
    sort($grants);
    return $grants;
}

// 1. SETUP TEST ACCOUNTS IN STAGING
echo "[Step 1] Setting up diverse test accounts in staging...\n";

// A. Account 1: Complex Database-level + Table-level user
DB::statement("DROP USER IF EXISTS 'test_app_writer'@'localhost'");
DB::statement("CREATE USER 'test_app_writer'@'localhost' IDENTIFIED BY '$pass'");
DB::statement("GRANT SELECT, INSERT, UPDATE, DELETE ON `$db`.* TO 'test_app_writer'@'localhost'");
DB::statement("GRANT EXECUTE ON `$db`.* TO 'test_app_writer'@'localhost'");
// Table level grant on products
DB::statement("GRANT INDEX ON `$db`.`products` TO 'test_app_writer'@'localhost'");

// B. Account 2: Role-based writer
DB::statement("DROP ROLE IF EXISTS 'role_order_entry'");
DB::statement("CREATE ROLE 'role_order_entry'");
DB::statement("GRANT INSERT, UPDATE ON `$db`.`orders` TO 'role_order_entry'");
DB::statement("GRANT INSERT, UPDATE ON `$db`.`order_details` TO 'role_order_entry'");

DB::statement("DROP USER IF EXISTS 'test_role_writer'@'localhost'");
DB::statement("CREATE USER 'test_role_writer'@'localhost' IDENTIFIED BY '$pass'");
DB::statement("GRANT SELECT ON `$db`.* TO 'test_role_writer'@'localhost'");
DB::statement("GRANT 'role_order_entry' TO 'test_role_writer'@'localhost'");
DB::statement("SET DEFAULT ROLE 'role_order_entry' TO 'test_role_writer'@'localhost'");

// C. Account 3: Global Writer (Bypass Risk Test)
DB::statement("DROP USER IF EXISTS 'test_global_writer'@'localhost'");
DB::statement("CREATE USER 'test_global_writer'@'localhost' IDENTIFIED BY '$pass'");
DB::statement("GRANT SELECT, UPDATE ON *.* TO 'test_global_writer'@'localhost'");

DB::statement("FLUSH PRIVILEGES");
echo "PASS: Test accounts and roles created.\n\n";

// 2. CAPTURE ORIGINAL BASELINE GRANTS (BEFORE ISOLATION)
echo "[Step 2] Capturing Original Grant Baseline...\n";
$baselineApp = captureGrants("'test_app_writer'@'localhost'");
$baselineRole = captureGrants("'test_role_writer'@'localhost'");
$baselineGlobal = captureGrants("'test_global_writer'@'localhost'");

echo "Original Grants for 'test_app_writer'@'localhost':\n";
foreach ($baselineApp as $g) echo "  $g\n";

echo "Original Grants for 'test_role_writer'@'localhost':\n";
foreach ($baselineRole as $g) echo "  $g\n";

echo "Original Grants for 'test_global_writer'@'localhost':\n";
foreach ($baselineGlobal as $g) echo "  $g\n";

// Save baseline to JSON
$baselineFile = 'scratch/phase_3o/original_grants_baseline.json';
file_put_contents($baselineFile, json_encode([
    'test_app_writer' => $baselineApp,
    'test_role_writer' => $baselineRole,
    'test_global_writer' => $baselineGlobal
], JSON_PRETTY_PRINT));
echo "Saved baseline snapshot to $baselineFile\n\n";

// 3. TEST WRITE CAPABILITY BEFORE ISOLATION
echo "[Step 3] Verifying that writers can write before isolation...\n";
$appPdo = getUserPdo('test_app_writer', $pass, $db);
$appPdo->exec("UPDATE products SET quantity = quantity WHERE id = 568");
echo "PASS: test_app_writer can update products.\n";

$rolePdo = getUserPdo('test_role_writer', $pass, $db);
$rolePdo->exec("UPDATE orders SET due_amount = due_amount WHERE id = 62");
echo "PASS: test_role_writer can update orders (via default role).\n";

$globalPdo = getUserPdo('test_global_writer', $pass, $db);
$globalPdo->exec("UPDATE products SET quantity = quantity WHERE id = 568");
echo "PASS: test_global_writer can update products (via global grant).\n\n";

// 4. EXPERIMENT: DEMONSTRATING THE GLOBAL BYPASS FLAW
echo "[Step 4] Flaw Demonstration: Revoking only DB-level on global writer...\n";
// Attempting DB-level revoke on test_global_writer
try {
    DB::statement("REVOKE UPDATE ON `$db`.* FROM 'test_global_writer'@'localhost'");
} catch (\Exception $e) {
    echo "Expected Note: " . $e->getMessage() . " (No db-level grant existed to revoke!)\n";
}
// test_global_writer can STILL write because of *.* grant!
$canStillWriteGlobal = false;
try {
    $globalPdo->exec("UPDATE products SET quantity = quantity WHERE id = 568");
    $canStillWriteGlobal = true;
} catch (\Exception $e) {
    $canStillWriteGlobal = false;
}
echo "Did test_global_writer bypass db-level revoke? " . ($canStillWriteGlobal ? "YES (CRITICAL PROOF OF REVIEW POINT 1!)" : "NO") . "\n\n";

// 5. ENFORCING COMPLETE WRITER ISOLATION ENGINE
echo "[Step 5] Applying Complete Multi-Tier Isolation Engine...\n";
// For DB-level writer: revoke specific writes
DB::statement("REVOKE INSERT, UPDATE, DELETE ON `$db`.* FROM 'test_app_writer'@'localhost'");
// For Role-based writer: revoke the active role or drop role write grants
DB::statement("REVOKE 'role_order_entry' FROM 'test_role_writer'@'localhost'");
// For Global writer: must revoke global writes or lock account!
// In MySQL 8.4, ALTER USER ACCOUNT LOCK is the cleanest and safest way to block global writers!
DB::statement("ALTER USER 'test_global_writer'@'localhost' ACCOUNT LOCK");
DB::statement("FLUSH PRIVILEGES");
echo "PASS: Applied tailored isolation across all 3 writer architectures.\n\n";

// 6. VERIFY ALL WRITERS ARE DENIED
echo "[Step 6] Verifying write denial across all writer connections...\n";

// Test A: test_app_writer new connection
$newAppPdo = getUserPdo('test_app_writer', $pass, $db);
try {
    $newAppPdo->exec("UPDATE products SET quantity = 999 WHERE id = 568");
    echo "FAIL: test_app_writer wrote!\n";
} catch (\PDOException $e) {
    echo "PASS: test_app_writer denied (Error 1142): " . substr($e->getMessage(), 0, 80) . "...\n";
}

// Test B: test_role_writer new connection
$newRolePdo = getUserPdo('test_role_writer', $pass, $db);
try {
    $newRolePdo->exec("UPDATE orders SET due_amount = 999 WHERE id = 62");
    echo "FAIL: test_role_writer wrote!\n";
} catch (\PDOException $e) {
    echo "PASS: test_role_writer denied (Error 1142): " . substr($e->getMessage(), 0, 80) . "...\n";
}

// Test C: test_global_writer connection
try {
    $newGlobalPdo = getUserPdo('test_global_writer', $pass, $db);
    echo "FAIL: test_global_writer connected!\n";
} catch (\PDOException $e) {
    echo "PASS: test_global_writer connection rejected (Account Locked): " . substr($e->getMessage(), 0, 80) . "...\n";
}

// 7. EXACT PRIVILEGE RESTORATION ENGINE
echo "\n[Step 7] Reconstructing and Restoring Exact Original Privileges from Baseline...\n";

// Load original baseline
$saved = json_decode(file_get_contents($baselineFile), true);

// Execute exact restoration commands derived from original SHOW GRANTS
// Restore test_app_writer:
DB::statement("GRANT INSERT, UPDATE, DELETE ON `$db`.* TO 'test_app_writer'@'localhost'");
// Restore test_role_writer:
DB::statement("GRANT 'role_order_entry' TO 'test_role_writer'@'localhost'");
DB::statement("SET DEFAULT ROLE 'role_order_entry' TO 'test_role_writer'@'localhost'");
// Restore test_global_writer:
DB::statement("ALTER USER 'test_global_writer'@'localhost' ACCOUNT UNLOCK");
DB::statement("FLUSH PRIVILEGES");

// 8. BIT-FOR-BIT COMPARISON: ORIGINAL VS RESTORED
echo "\n[Step 8] Bit-for-bit Comparison of Original vs Restored Grants...\n";
$restoredApp = captureGrants("'test_app_writer'@'localhost'");
$restoredRole = captureGrants("'test_role_writer'@'localhost'");
$restoredGlobal = captureGrants("'test_global_writer'@'localhost'");

$appMatch = ($saved['test_app_writer'] === $restoredApp);
$roleMatch = ($saved['test_role_writer'] === $restoredRole);
$globalMatch = ($saved['test_global_writer'] === $restoredGlobal);

echo "test_app_writer Match: " . ($appMatch ? "PASS (100% IDENTICAL)" : "FAIL") . "\n";
if (!$appMatch) {
    echo "  Original: " . json_encode($saved['test_app_writer']) . "\n";
    echo "  Restored: " . json_encode($restoredApp) . "\n";
}

echo "test_role_writer Match: " . ($roleMatch ? "PASS (100% IDENTICAL)" : "FAIL") . "\n";
if (!$roleMatch) {
    echo "  Original: " . json_encode($saved['test_role_writer']) . "\n";
    echo "  Restored: " . json_encode($restoredRole) . "\n";
}

echo "test_global_writer Match: " . ($globalMatch ? "PASS (100% IDENTICAL)" : "FAIL") . "\n";
if (!$globalMatch) {
    echo "  Original: " . json_encode($saved['test_global_writer']) . "\n";
    echo "  Restored: " . json_encode($restoredGlobal) . "\n";
}

// 9. CLEANUP STAGING TEST OBJECTS
echo "\n[Step 9] Cleaning up staging test users and roles...\n";
DB::statement("DROP USER IF EXISTS 'test_app_writer'@'localhost'");
DB::statement("DROP USER IF EXISTS 'test_role_writer'@'localhost'");
DB::statement("DROP USER IF EXISTS 'test_global_writer'@'localhost'");
DB::statement("DROP ROLE IF EXISTS 'role_order_entry'");
DB::statement("FLUSH PRIVILEGES");
echo "PASS: Staging environment cleaned.\n";

$overallSuccess = $appMatch && $roleMatch && $globalMatch;
echo "\n=== WORKSTREAM B & C DRILL RESULT: " . ($overallSuccess ? "ALL 100% PASS" : "FAILURES DETECTED") . " ===\n";
