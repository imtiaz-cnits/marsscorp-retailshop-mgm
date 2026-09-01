<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$total = App\Models\Product::count();
$greaterThanZero = App\Models\Product::where('quantity', '>', 0)->count();
$zeroOrLess = App\Models\Product::where('quantity', '<=', 0)->count();

echo "Total Products: {$total}\n";
echo "Quantity > 0: {$greaterThanZero}\n";
echo "Quantity <= 0: {$zeroOrLess}\n";
