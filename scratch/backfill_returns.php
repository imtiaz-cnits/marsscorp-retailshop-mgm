<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\ProductReturn;
use App\Models\Battery\BatteryProductReturn;

echo "Backfilling Retail Sales Returns...\n";

// Group existing records by order_id and created_at to identify original submissions
$retailReturns = ProductReturn::orderBy('created_at')->orderBy('id')->get();
$groups = [];
foreach ($retailReturns as $ret) {
    if ($ret->return_number) continue;
    $key = $ret->order_id . '_' . ($ret->created_at ? $ret->created_at->format('Y-m-d H:i:s') : 'none_' . $ret->id);
    $groups[$key][] = $ret;
}

$retSeq = 1;
// Find highest existing RET number if any
$latestRet = DB::table('product_returns')->whereNotNull('return_number')->orderBy('id', 'desc')->first();
if ($latestRet && preg_match('/#RET(\d+)/', $latestRet->return_number, $m)) {
    $retSeq = (int)$m[1] + 1;
}

foreach ($groups as $key => $items) {
    $retNum = sprintf('#RET%05d', $retSeq++);
    foreach ($items as $item) {
        $unitPrice = $item->quantity > 0 ? round($item->amount / $item->quantity, 2) : 0;
        DB::table('product_returns')->where('id', $item->id)->update([
            'return_number' => $retNum,
            'unit_price' => $unitPrice,
        ]);
        echo "Updated ProductReturn ID {$item->id} with return_number {$retNum}\n";
    }
}

echo "\nBackfilling Battery Sales Returns...\n";
$batteryReturns = BatteryProductReturn::orderBy('created_at')->orderBy('id')->get();
$bGroups = [];
foreach ($batteryReturns as $ret) {
    if ($ret->return_number) continue;
    $key = $ret->order_id . '_' . ($ret->created_at ? $ret->created_at->format('Y-m-d H:i:s') : 'none_' . $ret->id);
    $bGroups[$key][] = $ret;
}

$bSeq = 1;
$latestBRet = DB::table('battery_product_returns')->whereNotNull('return_number')->orderBy('id', 'desc')->first();
if ($latestBRet && preg_match('/#BRET(\d+)/', $latestBRet->return_number, $m)) {
    $bSeq = (int)$m[1] + 1;
}

foreach ($bGroups as $key => $items) {
    $retNum = sprintf('#BRET%05d', $bSeq++);
    foreach ($items as $item) {
        $unitPrice = $item->quantity > 0 ? round($item->amount / $item->quantity, 2) : 0;
        DB::table('battery_product_returns')->where('id', $item->id)->update([
            'return_number' => $retNum,
            'unit_price' => $unitPrice,
        ]);
        echo "Updated BatteryProductReturn ID {$item->id} with return_number {$retNum}\n";
    }
}

echo "Backfill completed successfully.\n";
