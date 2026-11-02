<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$opd = DB::table('order_payment_details')->where('order_id', 62)->get();
echo "order_payment_details for Order 62: " . json_encode($opd, JSON_PRETTY_PRINT) . PHP_EOL;

// Check how order controller calculates previous due amount
$files = glob('app/Http/Controllers/*.php');
foreach ($files as $f) {
    $content = file_get_contents($f);
    if (strpos($content, 'previous_due_amount') !== false) {
        echo "Found previous_due_amount in: $f\n";
    }
}
$subfiles = glob('app/Http/Controllers/*/*.php');
foreach ($subfiles as $f) {
    $content = file_get_contents($f);
    if (strpos($content, 'previous_due_amount') !== false) {
        echo "Found previous_due_amount in: $f\n";
    }
}

