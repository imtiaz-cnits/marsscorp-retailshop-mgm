<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$prodIdx = DB::select("SELECT TABLE_NAME, INDEX_NAME FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = 'marsscorpdb' GROUP BY TABLE_NAME, INDEX_NAME");
$stagIdx = DB::select("SELECT TABLE_NAME, INDEX_NAME FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = 'marsscorpdb_staging_verify' GROUP BY TABLE_NAME, INDEX_NAME");

echo "Production index count: " . count($prodIdx) . PHP_EOL;
echo "Staging index count: " . count($stagIdx) . PHP_EOL;

$prodSet = [];
foreach ($prodIdx as $p) {
    $prodSet[$p->TABLE_NAME . '.' . $p->INDEX_NAME] = true;
}
$stagSet = [];
foreach ($stagIdx as $s) {
    $stagSet[$s->TABLE_NAME . '.' . $s->INDEX_NAME] = true;
}

$diff = array_diff_key($prodSet, $stagSet);
echo "Indexes in production but NOT in staging:\n";
foreach ($diff as $k => $v) {
    echo " - $k\n";
}

$diff2 = array_diff_key($stagSet, $prodSet);
echo "Indexes in staging but NOT in production:\n";
foreach ($diff2 as $k => $v) {
    echo " - $k\n";
}

