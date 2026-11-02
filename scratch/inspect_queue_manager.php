<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$manager = app('queue');
$ref = new ReflectionMethod($manager, 'pause');
echo "QueueManager::pause method defined in: " . $ref->getDeclaringClass()->getName() . PHP_EOL;

$connection = $manager->connection('database');
echo "Connection class: " . get_class($connection) . PHP_EOL;
$refConn = new ReflectionClass($connection);
echo "Has pause method in connection: " . ($refConn->hasMethod('pause') ? 'YES' : 'NO') . PHP_EOL;

if ($refConn->hasMethod('pause')) {
    $refPause = $refConn->getMethod('pause');
    echo "pause defined in: " . $refPause->getDeclaringClass()->getName() . PHP_EOL;
}

