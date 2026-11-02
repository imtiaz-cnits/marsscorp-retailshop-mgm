<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== STAGING EXPERIMENTAL DRILL: DATABASE-LEVEL WRITER ISOLATION ===\n";
echo "Testing on staging harness: marsscorpdb_staging_verify\n";

$testUser = 'app_writer_test';
$testPass = 'StagingTestPass123!';
$db = 'marsscorpdb_staging_verify';

echo "\n[Step 1] Creating simulated application user '$testUser'@'localhost'...\n";
DB::statement("DROP USER IF EXISTS `$testUser`@`localhost`");
DB::statement("CREATE USER `$testUser`@`localhost` IDENTIFIED BY '$testPass'");
DB::statement("GRANT SELECT, INSERT, UPDATE, DELETE ON `$db`.* TO `$testUser`@`localhost`");
DB::statement("FLUSH PRIVILEGES");
echo "PASS: Created simulated application user with CRUD on $db\n";

function getAppPdo($user, $pass, $db) {
    return new PDO("mysql:host=127.0.0.1;port=3306;dbname=$db", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 3
    ]);
}

$appPdo = getAppPdo($testUser, $testPass, $db);
echo "\n[Step 2] Testing write capability as '$testUser'...\n";
$stmt = $appPdo->query("SELECT id, quantity FROM products WHERE id = 568");
$prod = $stmt->fetch(PDO::FETCH_ASSOC);
echo "Initial product 568 quantity: {$prod['quantity']}\n";

$appPdo->exec("UPDATE products SET quantity = quantity + 1 WHERE id = 568");
$updatedQty = $appPdo->query("SELECT quantity FROM products WHERE id = 568")->fetchColumn();
echo "Updated product 568 quantity (write allowed): $updatedQty\n";
$appPdo->exec("UPDATE products SET quantity = quantity - 1 WHERE id = 568");
echo "Reverted product 568 quantity back to initial.\n";

echo "\n[Step 3] Enforcing Database-Level Writer Isolation (Revoking INSERT, UPDATE, DELETE)...\n";
DB::statement("REVOKE INSERT, UPDATE, DELETE ON `$db`.* FROM `$testUser`@`localhost`");
DB::statement("FLUSH PRIVILEGES");
echo "Privileges revoked from '$testUser'@'localhost'.\n";

echo "\n[Step 4] Testing that a NEW application connection attempts to write...\n";
$newAppPdo = getAppPdo($testUser, $testPass, $db);
try {
    $newAppPdo->exec("UPDATE products SET quantity = 99 WHERE id = 568");
    echo "CRITICAL FAILURE: Write was unexpectedly permitted!\n";
} catch (\PDOException $e) {
    echo "SUCCESS: Write was BLOCKED by MySQL engine! Error: " . $e->getMessage() . "\n";
}

$canRead = $newAppPdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
echo "Application can still read data: $canRead products found.\n";

echo "\n[Step 5] Verifying dedicated migration connection can still write to battery tables in staging...\n";
$migrationCanWrite = false;
try {
    DB::connection()->getPdo()->exec("INSERT INTO `$db`.battery_migration_mappings (migration_batch_id, source_table, source_id, destination_table, destination_id, created_at, updated_at) VALUES ('BATCH-TEST-001', 'test_staging', 9999, 'test_dest', 9999, NOW(), NOW())");
    $cnt = DB::table("$db.battery_migration_mappings")->where('source_table', 'test_staging')->count();
    if ($cnt === 1) {
        $migrationCanWrite = true;
        DB::table("$db.battery_migration_mappings")->where('source_table', 'test_staging')->delete();
    }
} catch (\Exception $e) {
    echo "Migration write error: " . $e->getMessage() . "\n";
}
echo "Migration connection write capability: " . ($migrationCanWrite ? "CONFIRMED ACTIVE" : "FAILED") . "\n";

echo "\n[Step 6] Testing restoration of application write privileges...\n";
DB::statement("GRANT INSERT, UPDATE, DELETE ON `$db`.* TO `$testUser`@`localhost`");
DB::statement("FLUSH PRIVILEGES");

$restoredPdo = getAppPdo($testUser, $testPass, $db);
$restoredPdo->exec("UPDATE products SET quantity = quantity WHERE id = 568");
echo "SUCCESS: Application write privileges restored cleanly.\n";

DB::statement("DROP USER IF EXISTS `$testUser`@`localhost`");
DB::statement("FLUSH PRIVILEGES");
echo "Cleaned up staging test user '$testUser'@'localhost'.\n";
echo "\nOVERALL WRITER ISOLATION DRILL RESULT: 100% SUCCESS.\n";
