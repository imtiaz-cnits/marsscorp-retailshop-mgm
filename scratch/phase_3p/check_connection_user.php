<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$res = DB::select("SELECT CURRENT_USER() as cu, USER() as u, DATABASE() as db")[0];
echo "Connected as: {$res->cu} (Client: {$res->u}) on DB: {$res->db}\n";

