<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$prodUpdatedAt = DB::table('marsscorpdb.products')->where('id', 568)->value('updated_at');
echo "Prod updated_at: $prodUpdatedAt\n";
DB::table('marsscorpdb_staging_verify.products')->where('id', 568)->update(['updated_at' => $prodUpdatedAt]);
echo "Updated staging Product 568 updated_at back to baseline.\n";

