<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$content = file('app/Http/Controllers/CustomerDueCollectionController.php');
for ($i = 1250; $i <= 1325; $i++) {
    echo ($i+1) . ": " . $content[$i];
}

