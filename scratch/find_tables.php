<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Check customer_ledgers or similar tables if any exist
$tables = DB::select('SHOW TABLES');
$tableNames = array_map('current', $tables);
echo "Tables matching ledger, transaction, payment, due:\n";
foreach ($tableNames as $t) {
    if (preg_match('/(ledger|trans|pay|due|hist|order|sale)/i', $t)) {
        echo " - $t\n";
    }
}

