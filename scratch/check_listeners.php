<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$dispatcher = app('events');
$ref = new ReflectionClass($dispatcher);
$prop = $ref->getProperty('listeners');
$prop->setAccessible(true);
$listeners = $prop->getValue($dispatcher);

echo "Registered event listeners:\n";
foreach (array_keys($listeners) as $eventName) {
    if (preg_match('/eloquent|battery|model/i', $eventName)) {
        echo " - $eventName\n";
    }
}

