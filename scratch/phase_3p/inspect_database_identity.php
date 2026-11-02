<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== WORKSTREAM A: DATABASE CONNECTION & CONFIGURATION AUDIT ===\n";

$dbConnections = config('database.connections');
echo "Configured database connections in Laravel:\n";
foreach (array_keys($dbConnections) as $conn) {
    echo "  - $conn (driver: {$dbConnections[$conn]['driver']})\n";
}

echo "\nDefault connection: " . config('database.default') . "\n";
$mysql = config('database.connections.mysql');
echo "MySQL Connection Parameters (Masked):\n";
echo "  Host: {$mysql['host']}\n";
echo "  Port: {$mysql['port']}\n";
echo "  Database: {$mysql['database']}\n";
echo "  Username: {$mysql['username']}\n";
echo "  Password Configured: " . (!empty($mysql['password']) ? "YES" : "NO / EMPTY") . "\n";

// Test dynamic runtime connection configuration for migration
echo "\nTesting dynamic runtime connection switching to a custom test account...\n";
config([
    'database.connections.migration_test' => [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'marsscorpdb_staging_verify',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => true,
        'engine' => null,
    ]
]);

$connTest = DB::connection('migration_test')->select("SELECT CURRENT_USER(), USER(), DATABASE()");
echo "Switched Connection Result: " . json_encode($connTest[0]) . "\n";

