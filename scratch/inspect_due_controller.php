<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$content = file_get_contents('app/Http/Controllers/CustomerDueCollectionController.php');
$lines = explode("\n", $content);
foreach ($lines as $i => $l) {
    if (strpos($l, 'previous_due_amount') !== false || strpos($l, 'due_amount') !== false) {
        echo ($i+1) . ": " . trim($l) . "\n";
    }
}

