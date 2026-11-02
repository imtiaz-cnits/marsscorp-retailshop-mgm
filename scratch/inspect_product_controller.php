<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$content = file_get_contents('app/Http/Controllers/ProductController.php');
$lines = explode("\n", $content);
foreach ($lines as $i => $l) {
    if (strpos($l, 'quantity') !== false) {
        echo ($i+1) . ": " . trim($l) . "\n";
    }
}

