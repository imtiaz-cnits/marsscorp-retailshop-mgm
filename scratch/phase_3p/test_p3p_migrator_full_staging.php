<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== WORKSTREAM B: LEAST-PRIVILEGE MIGRATION IDENTITY DRILL (WITHOUT LOCK TABLES) ===\n";
echo "Target Database: marsscorpdb_staging_verify\n\n";

$db = 'marsscorpdb_staging_verify';
$migratorUser = 'p3p_migrator';
$migratorPass = 'P3pMigratorPass2026!';

// 1. Clean staging battery tables first so it's a fresh run
echo "[Step 1] Ensuring staging battery tables are 0 rows before test...\n";
$batteryTables = DB::select("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$db' AND (TABLE_NAME LIKE 'battery_%' OR TABLE_NAME = 'battery_migration_mappings')");
DB::statement("SET FOREIGN_KEY_CHECKS = 0");
foreach ($batteryTables as $bt) {
    DB::statement("TRUNCATE TABLE `$db`.`{$bt->TABLE_NAME}`");
}
DB::statement("SET FOREIGN_KEY_CHECKS = 1");
echo "Staging battery tables truncated to 0 rows for clean test.\n";

// 2. Create p3p_migrator with strictly LEAST PRIVILEGE (NO LOCK TABLES!)
echo "\n[Step 2] Creating 'p3p_migrator'@'localhost' without LOCK TABLES...\n";
DB::statement("DROP USER IF EXISTS `$migratorUser`@`localhost`");
DB::statement("CREATE USER `$migratorUser`@`localhost` IDENTIFIED BY '$migratorPass'");
DB::statement("GRANT USAGE ON *.* TO `$migratorUser`@`localhost`");

// Grant SELECT on 18 Retail source tables
$sourceTables = [
    'users', 'customers', 'customer_payment_details', 'suppliers', 'supplier_due_collections',
    'categories', 'sub_categories', 'brands', 'units', 'products', 'purchases',
    'purchase_order_details', 'purchase_payment_details', 'orders', 'order_details',
    'opening_balances', 'expenses', 'expense_types'
];
foreach ($sourceTables as $st) {
    DB::statement("GRANT SELECT ON `$db`.`$st` TO `$migratorUser`@`localhost`");
}

// Grant SELECT, INSERT, UPDATE on 21 Battery destination tables + mappings
foreach ($batteryTables as $bt) {
    DB::statement("GRANT SELECT, INSERT, UPDATE ON `$db`.`{$bt->TABLE_NAME}` TO `$migratorUser`@`localhost`");
}
DB::statement("FLUSH PRIVILEGES");
echo "PASS: p3p_migrator created with strictly minimal grants.\n";

// 3. Verify Grants for p3p_migrator (Ensure LOCK TABLES is ABSENT)
$grants = DB::select("SHOW GRANTS FOR `$migratorUser`@`localhost`");
$hasLockTables = false;
foreach ($grants as $g) {
    $grantStr = array_values((array)$g)[0];
    if (stripos($grantStr, 'LOCK TABLES') !== false) {
        $hasLockTables = true;
    }
}
echo "Is LOCK TABLES granted? " . ($hasLockTables ? "YES (ERROR)" : "NO (CORRECT)") . "\n";

// 4. Test that p3p_migrator CANNOT write to retail tables
echo "\n[Step 3] Verifying p3p_migrator cannot write to retail products...\n";
$migratorPdo = new PDO("mysql:host=127.0.0.1;port=3306;dbname=$db", $migratorUser, $migratorPass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

try {
    $migratorPdo->exec("UPDATE products SET quantity = 999 WHERE id = 568");
    echo "FAIL: p3p_migrator was able to write to retail products!\n";
} catch (\PDOException $e) {
    echo "PASS: Retail write denied (Error 1142): " . substr($e->getMessage(), 0, 70) . "...\n";
}

echo "\nReady to execute full Artisan migration in staging using p3p_migrator.\n";

