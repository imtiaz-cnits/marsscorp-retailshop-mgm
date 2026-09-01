<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// 1. Fetch all product records ordered by ID
$allProducts = Product::orderBy('id', 'asc')->get();

$seen = [];
$duplicatesToDelete = [];
$uniqueProducts = [];

foreach ($allProducts as $p) {
    $normalized = strtolower(trim($p->product_name));
    if (isset($seen[$normalized])) {
        $duplicatesToDelete[] = $p->id;
    } else {
        $seen[$normalized] = true;
        $uniqueProducts[] = $p->product_name;
    }
}

echo "Total products in DB before: " . $allProducts->count() . "\n";
echo "Duplicate rows to remove: " . count($duplicatesToDelete) . "\n";
echo "Unique products count: " . count($uniqueProducts) . "\n";

// Delete duplicates from DB
if (count($duplicatesToDelete) > 0) {
    Product::whereIn('id', $duplicatesToDelete)->delete();
}

echo "Total products in DB after cleanup: " . Product::count() . "\n";

// 2. Now update DatabaseSeeder.php with the unique list
$seederPath = __DIR__ . '/../database/seeders/DatabaseSeeder.php';
$seederContent = file_get_contents($seederPath);

// Format unique products as array code
$formattedArray = "        \$productNames = [\n";
foreach ($uniqueProducts as $name) {
    $escapedName = str_replace("'", "\\'", $name);
    $formattedArray .= "            '{$escapedName}',\n";
}
$formattedArray .= "        ];";

// Replace $productNames array in DatabaseSeeder.php
$pattern = '/\$productNames = \[\s*.*?\s*\];/s';
$updatedSeederContent = preg_replace($pattern, $formattedArray, $seederContent);

file_put_contents($seederPath, $updatedSeederContent);
echo "DatabaseSeeder.php updated successfully with unique product list.\n";
