<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Config database: " . config('database.connections.mysql.database') . "\n";
echo "DB facade database: " . \Illuminate\Support\Facades\DB::connection()->getDatabaseName() . "\n";

