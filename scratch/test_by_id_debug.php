<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;

$controller = new ProductController();
$req = new Request(['id' => '1']);
$res = $controller->ProductByID($req);
echo json_encode($res->getData(), JSON_PRETTY_PRINT);
