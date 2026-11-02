<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$u = DB::select("SELECT CURRENT_USER() as cu, DATABASE() as db")[0];
echo "LARAVEL_ACTIVE_USER: " . $u->cu . " | ACTIVE_DB: " . $u->db . "\n";
