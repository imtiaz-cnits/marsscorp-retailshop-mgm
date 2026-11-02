<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tblCount = DB::select("SELECT COUNT(*) as cnt FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'marsscorpdb_staging_verify'")[0]->cnt;
echo ($tblCount >= 55) ? "COMPLETE" : "INCOMPLETE";
