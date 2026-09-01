<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Unit;
use App\Models\User;

$user = User::where('email', 'admin@gmail.com')->first() ?? User::first();
$brand = Brand::firstOrCreate(['name' => 'General'], ['status' => 'active', 'user_id' => $user->id]);
$category = Category::firstOrCreate(['category_name' => 'Door'], ['status' => 'active', 'user_id' => $user->id]);
$unit = Unit::firstOrCreate(['unit_name' => 'Pcs'], ['status' => 'active', 'user_id' => $user->id]);

$rawList = [
    "Akij Door Flash",
    "Neo Door one side Tamper",
    "Neo Door non Temper",
    "Full Aluminum Door",
    "Neo PvC Door",
    "N.M- Hot Stamp door",
    "N.M 3' Door",
    "N.M 5\" Door"
];

$existingNames = Product::pluck('product_name')->map(fn($n) => strtolower(trim($n)))->toArray();

$insertedCount = 0;
$skippedCount = 0;

foreach ($rawList as $item) {
    $trimmed = trim($item);
    $normalized = strtolower($trimmed);

    if (in_array($normalized, $existingNames)) {
        $skippedCount++;
    } else {
        $nextId = Product::max('id') + 1;
        Product::create([
            'product_name' => $trimmed,
            'quantity' => '0',
            'cost_price' => '0',
            'sell_price' => '0',
            'status' => 'active',
            'product_code' => json_encode(['PRD-' . str_pad($nextId, 4, '0', STR_PAD_LEFT)]),
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'unit_id' => $unit->id,
            'user_id' => $user->id,
        ]);
        $existingNames[] = $normalized;
        $insertedCount++;
    }
}

echo "Inserted new products: {$insertedCount}\n";
echo "Skipped existing duplicates: {$skippedCount}\n";
echo "Total products in DB now: " . Product::count() . "\n";
