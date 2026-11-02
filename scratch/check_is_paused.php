<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$isPaused = app('queue')->isPaused('database', 'default');
echo "Queue 'database:default' isPaused: " . ($isPaused ? 'YES' : 'NO') . PHP_EOL;

