<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Initial connection username: " . config('database.connections.mysql.username') . "\n";
$id1 = DB::selectOne("SELECT DATABASE() as db, CURRENT_USER() as cur_user, USER() as usr");
echo "Initial runtime identity: DB={$id1->db}, CURRENT_USER={$id1->cur_user}, USER={$id1->usr}\n";

// Now dynamically reconfigure to marss_migrator
// (First let's create a dummy test user or see what happens)
echo "Reconfiguring connection config...\n";
config(['database.connections.mysql.username' => 'root']);
DB::purge('mysql');
DB::reconnect('mysql');
$id2 = DB::selectOne("SELECT DATABASE() as db, CURRENT_USER() as cur_user, USER() as usr");
echo "Reconnected runtime identity: DB={$id2->db}, CURRENT_USER={$id2->cur_user}, USER={$id2->usr}\n";

