<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Default Cache Store: " . config('cache.default') . PHP_EOL;
echo "Cache Store Config: " . json_encode(config('cache.stores.' . config('cache.default')), JSON_PRETTY_PRINT) . PHP_EOL;

