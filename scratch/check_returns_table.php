<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== TABLE: product_returns ===\n";
$returns = DB::table('product_returns')->get();
echo "Count: " . $returns->count() . "\n";
foreach ($returns as $r) {
    echo json_encode($r, JSON_PRETTY_PRINT) . PHP_EOL;
}

