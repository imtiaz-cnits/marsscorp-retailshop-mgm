<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== TABLE: opening_balances ===\n";
$obs = DB::table('opening_balances')->get();
echo "Count: " . $obs->count() . "\n";
foreach ($obs as $ob) {
    echo json_encode($ob, JSON_PRETTY_PRINT) . PHP_EOL;
}

