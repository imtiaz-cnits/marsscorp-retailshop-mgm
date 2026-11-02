<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$ref = new ReflectionClass(Illuminate\Queue\Worker::class);
echo "Worker file: " . $ref->getFileName() . PHP_EOL;
$lines = file($ref->getFileName());
foreach ($lines as $num => $line) {
    if (stripos($line, 'pause') !== false) {
        echo ($num + 1) . ": " . trim($line) . PHP_EOL;
    }
}

