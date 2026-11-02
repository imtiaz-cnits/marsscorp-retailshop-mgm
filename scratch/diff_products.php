<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$prodRows = DB::select("SELECT * FROM marsscorpdb.products ORDER BY id");
$stageRows = DB::select("SELECT * FROM marsscorpdb_staging_verify.products ORDER BY id");

echo "Prod rows: " . count($prodRows) . ", Stage rows: " . count($stageRows) . "\n";

$diffCount = 0;
for ($i = 0; $i < count($prodRows); $i++) {
    $p = (array)$prodRows[$i];
    $s = (array)$stageRows[$i];
    
    $diffs = [];
    foreach ($p as $k => $v) {
        if ($p[$k] !== $s[$k]) {
            $diffs[$k] = ['prod' => $p[$k], 'stage' => $s[$k]];
        }
    }
    if (!empty($diffs)) {
        $diffCount++;
        echo "Product ID {$p['id']} differs in: " . json_encode($diffs) . "\n";
        if ($diffCount > 5) break;
    }
}
echo "Total differing products: $diffCount\n";

