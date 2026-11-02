<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$ref = new ReflectionMethod(Illuminate\Queue\QueueManager::class, 'pause');
$filename = $ref->getFileName();
$startLine = $ref->getStartLine();
$endLine = $ref->getEndLine();

$lines = file($filename);
for ($i = $startLine - 1; $i < $endLine; $i++) {
    echo ($i + 1) . ": " . $lines[$i];
}

