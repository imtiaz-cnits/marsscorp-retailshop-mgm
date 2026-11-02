<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$content = file('app/Console/Commands/MigrateRetailToBatteryCommand.php');
for ($i = 505; $i <= 555; $i++) {
    echo ($i+1) . ": " . $content[$i];
}

