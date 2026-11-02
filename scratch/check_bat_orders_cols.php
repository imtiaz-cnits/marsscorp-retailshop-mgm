<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

echo "battery_order_details columns: " . implode(', ', Schema::getColumnListing('battery_order_details')) . PHP_EOL;
echo "battery_orders columns: " . implode(', ', Schema::getColumnListing('battery_orders')) . PHP_EOL;

