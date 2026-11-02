<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== DATABASE USER & PRIVILEGES INSPECTION ===\n";
$currentUser = DB::select("SELECT CURRENT_USER(), USER(), DATABASE()")[0];
echo "Current User: " . json_encode($currentUser) . "\n";

try {
    $grants = DB::select("SHOW GRANTS FOR CURRENT_USER()");
    echo "Grants:\n";
    foreach ($grants as $g) {
        echo "  " . array_values((array)$g)[0] . "\n";
    }
} catch (\Exception $e) {
    echo "Could not show grants: " . $e->getMessage() . "\n";
}

$users = DB::select("SELECT User, Host FROM mysql.user");
echo "\nAvailable MySQL Users:\n";
foreach ($users as $u) {
    echo "  User: {$u->User}@{$u->Host}\n";
}

