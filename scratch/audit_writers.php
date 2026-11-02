<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=================================================================\n";
echo "           DATABASE & APPLICATION WRITER DETECTION AUDIT         \n";
echo "=================================================================\n\n";

// 1. Active Database Connections
echo "--- 1. Database Connections (information_schema.PROCESSLIST) ---\n";
$procList = DB::select("SELECT ID, USER, HOST, DB, COMMAND, TIME, STATE, INFO FROM information_schema.PROCESSLIST");
echo sprintf("%-6s | %-12s | %-20s | %-15s | %-10s | %-6s | %-15s | %s\n", "ID", "USER", "HOST", "DB", "COMMAND", "TIME", "STATE", "INFO");
echo str_repeat("-", 100) . "\n";
foreach ($procList as $p) {
    echo sprintf("%-6s | %-12s | %-20s | %-15s | %-10s | %-6s | %-15s | %s\n", 
        $p->ID, $p->USER, $p->HOST, $p->DB ?? 'NULL', $p->COMMAND, $p->TIME, $p->STATE ?? '', substr($p->INFO ?? '', 0, 30));
}

// 2. Active Transactions
echo "\n--- 2. Active InnoDB Transactions (information_schema.INNODB_TRX) ---\n";
$trxList = DB::select("SELECT trx_id, trx_state, trx_started, trx_tables_locked, trx_rows_locked, trx_rows_modified, trx_query FROM information_schema.INNODB_TRX");
if (empty($trxList)) {
    echo "Zero active InnoDB transactions.\n";
} else {
    foreach ($trxList as $t) {
        echo sprintf("TRX ID: %s | State: %s | Started: %s | Locked Tables: %s | Modified Rows: %s | Query: %s\n",
            $t->trx_id, $t->trx_state, $t->trx_started, $t->trx_tables_locked, $t->trx_rows_modified, $t->trx_query ?? 'NULL');
    }
}

// 3. MySQL Events
echo "\n--- 3. Database Events (information_schema.EVENTS) ---\n";
$events = DB::select("SELECT EVENT_SCHEMA, EVENT_NAME, STATUS, INTERVAL_VALUE, INTERVAL_FIELD FROM information_schema.EVENTS WHERE EVENT_SCHEMA = 'marsscorpdb'");
$schedulerStatus = DB::select("SHOW VARIABLES LIKE 'event_scheduler'")[0]->Value;
echo "MySQL event_scheduler: $schedulerStatus\n";
echo "Events in marsscorpdb: " . count($events) . "\n";

// 4. Queue Jobs (Pending, Reserved, In-Flight)
echo "\n--- 4. Queue Status (database queue) ---\n";
$jobsCount = DB::table('jobs')->count();
$reservedCount = DB::table('jobs')->whereNotNull('reserved_at')->count();
$pendingCount = DB::table('jobs')->whereNull('reserved_at')->count();
$failedCount = DB::table('failed_jobs')->count();
echo "Total Jobs: $jobsCount (Pending: $pendingCount, Reserved/In-Flight: $reservedCount) | Failed Jobs: $failedCount\n";

// 5. Windows Running Processes (PHP, Apache, MySQL)
echo "\n--- 5. Application Processes (OS Process Audit) ---\n";
$phpProcesses = shell_exec('powershell -Command "Get-Process -Name php, httpd -ErrorAction SilentlyContinue | Select-Object Id, ProcessName, Path, StartTime | Format-Table -AutoSize | Out-String"');
echo $phpProcesses ?: "Zero php or httpd processes returned.\n";

// 6. Windows Scheduled Tasks
echo "--- 6. Windows Scheduled Tasks for Project/Artisan ---\n";
$schedTasks = shell_exec('powershell -Command "Get-ScheduledTask | Where-Object { $_.TaskName -match \'laravel|marss|artisan\' -or $_.Description -match \'marss|laravel\' } | Select-Object TaskName, State | Format-Table -AutoSize | Out-String"');
echo $schedTasks ?: "Zero Laravel/MARSS Windows scheduled tasks found.\n";

// 7. Laravel Scheduled Tasks (Console Kernel)
echo "--- 7. Laravel Scheduled Tasks in Kernel/Routes ---\n";
$schedule = app()->make(Illuminate\Console\Scheduling\Schedule::class);
$events = $schedule->events();
echo "Scheduled events defined in Laravel: " . count($events) . "\n";
foreach ($events as $ev) {
    echo " - Command/Expression: " . ($ev->command ?? $ev->description ?? 'Closure') . " | Cron: " . $ev->expression . "\n";
}

