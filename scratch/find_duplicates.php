<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$duplicates = DB::table('products')
    ->select(DB::raw('LOWER(TRIM(product_name)) as lower_name'), DB::raw('COUNT(*) as count'))
    ->groupBy('lower_name')
    ->having('count', '>', 1)
    ->get();

echo "Duplicate groups count: " . $duplicates->count() . "\n";
foreach ($duplicates as $d) {
    echo "- {$d->lower_name} ({$d->count} times)\n";
}
