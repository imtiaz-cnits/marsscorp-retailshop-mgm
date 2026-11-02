<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$identity = DB::selectOne("SELECT DATABASE() as db, CURRENT_USER() as cur_user, USER() as usr");
var_dump($identity);
$curUsername = explode('@', $identity->cur_user)[0];
var_dump($curUsername);
$expectedUser = 'marss_migrator';
var_dump($curUsername !== $expectedUser);

