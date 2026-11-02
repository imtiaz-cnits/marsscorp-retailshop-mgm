<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== WORKSTREAM D: MIGRATION COMMAND LEAST-PRIVILEGE ANALYSIS ===\n";

$commandFile = 'app/Console/Commands/MigrateRetailToBatteryCommand.php';
$content = file_get_contents($commandFile);

echo "Command File Size: " . strlen($content) . " bytes\n";

// Find all table names referenced in the command file
preg_match_all("/(?:table|from|into|join|update)\s*\(\s*['\"]([^'\"]+)['\"]/i", $content, $matches);
$tablesDirect = array_unique($matches[1]);
sort($tablesDirect);

echo "Directly referenced tables in Command file:\n";
foreach ($tablesDirect as $tbl) {
    echo "  - $tbl\n";
}

// Check models referenced
preg_match_all('/use App\\\Models\\\([A-Za-z0-9_\\\\]+);/', $content, $modelMatches);
$models = array_unique($modelMatches[1]);
echo "\nModels imported in Command:\n";
foreach ($models as $m) {
    echo "  - $m\n";
}

// Test in staging: Create a dedicated least-privilege user
$migratorUser = 'marss_migrator_test';
$migratorPass = 'MigratorSecurePass2026!';
$db = 'marsscorpdb_staging_verify';

echo "\n[Step 1] Creating dedicated least-privilege migration user in staging...\n";
DB::statement("DROP USER IF EXISTS `$migratorUser`@`localhost`");
DB::statement("CREATE USER `$migratorUser`@`localhost` IDENTIFIED BY '$migratorPass'");

// Required Permissions:
// 1. SELECT on all Retail source tables
$sourceTables = [
    'users', 'customers', 'customer_payment_details', 'suppliers', 'supplier_due_collections',
    'categories', 'sub_categories', 'brands', 'units', 'products', 'purchases',
    'purchase_order_details', 'purchase_payment_details', 'orders', 'order_details',
    'opening_balances', 'expenses', 'expense_types'
];

foreach ($sourceTables as $st) {
    DB::statement("GRANT SELECT ON `$db`.`$st` TO `$migratorUser`@`localhost`");
}

// 2. SELECT, INSERT, UPDATE on all battery tables and mappings
$batteryTables = DB::select("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$db' AND (TABLE_NAME LIKE 'battery_%' OR TABLE_NAME = 'battery_migration_mappings')");
foreach ($batteryTables as $bt) {
    DB::statement("GRANT SELECT, INSERT, UPDATE ON `$db`.`{$bt->TABLE_NAME}` TO `$migratorUser`@`localhost`");
}

// 3. Metadata and Lock permissions
DB::statement("GRANT LOCK TABLES ON `$db`.* TO `$migratorUser`@`localhost`");
DB::statement("FLUSH PRIVILEGES");
echo "PASS: Granted least-privilege permissions to '$migratorUser'@'localhost'.\n";

// Show Grants for migrator user
$migratorGrants = DB::select("SHOW GRANTS FOR `$migratorUser`@`localhost`");
echo "\nGrants for Least-Privilege Migration User:\n";
foreach ($migratorGrants as $mg) {
    echo "  " . array_values((array)$mg)[0] . "\n";
}

// Test that migrator user CANNOT write to retail tables
echo "\n[Step 2] Testing that migrator user CANNOT write to retail tables...\n";
$migratorPdo = new PDO("mysql:host=127.0.0.1;port=3306;dbname=$db", $migratorUser, $migratorPass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

try {
    $migratorPdo->exec("UPDATE products SET quantity = 999 WHERE id = 568");
    echo "CRITICAL FLAW: Migrator user wrote to retail products table!\n";
} catch (\PDOException $e) {
    echo "PASS: Migrator user write to retail table DENIED: " . substr($e->getMessage(), 0, 80) . "...\n";
}

// Test that migrator user CAN write to battery_migration_mappings
echo "\n[Step 3] Testing that migrator user CAN write to battery_migration_mappings...\n";
$migratorPdo->exec("INSERT INTO battery_migration_mappings (migration_batch_id, source_table, source_id, destination_table, destination_id, created_at, updated_at) VALUES ('TEST-LEAST-01', 'test_src', 1, 'test_dest', 1, NOW(), NOW())");
$cnt = DB::table("$db.battery_migration_mappings")->where('migration_batch_id', 'TEST-LEAST-01')->count();
echo "PASS: Migrator user successfully inserted mapping record (Row count: $cnt).\n";
DB::table("$db.battery_migration_mappings")->where('migration_batch_id', 'TEST-LEAST-01')->delete();

// Clean up
DB::statement("DROP USER IF EXISTS `$migratorUser`@`localhost`");
DB::statement("FLUSH PRIVILEGES");
echo "PASS: Staging test migrator user cleaned up.\n";
