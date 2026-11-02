<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== TESTING MYSQL CONNECTION DRAIN & ISOLATION LOGIC ===\n";

$myId = DB::select("SELECT CONNECTION_ID() as id")[0]->id;
echo "Current Migration CLI Connection ID: $myId\n";

$processes = DB::select("
    SELECT ID, USER, HOST, DB, COMMAND, TIME, STATE 
    FROM information_schema.PROCESSLIST 
    WHERE ID != ? AND USER != 'event_scheduler' AND COMMAND != 'Daemon'
", [$myId]);

echo "Found " . count($processes) . " other non-system connection(s):\n";
printf("%-8s | %-15s | %-25s | %-15s | %-10s | %-6s\n", "ID", "User", "Host", "DB", "Command", "Time");
echo str_repeat("-", 85) . "\n";
foreach ($processes as $p) {
    printf("%-8d | %-15s | %-25s | %-15s | %-10s | %-6d\n", $p->ID, $p->USER, $p->HOST, $p->DB ?? 'NULL', $p->COMMAND, $p->TIME);
}

// In the isolation protocol, if count > 0, we can iterate and terminate:
// foreach ($processes as $p) { DB::statement("KILL {$p->ID}"); }

$inFlightTrx = DB::select("SELECT COUNT(*) as cnt FROM information_schema.INNODB_TRX")[0]->cnt;
echo "\nIn-flight InnoDB Transactions: $inFlightTrx\n";

if ($inFlightTrx === 0) {
    echo "PASS: Zero in-flight transactions detected.\n";
} else {
    echo "FAIL: In-flight transactions present!\n";
}

