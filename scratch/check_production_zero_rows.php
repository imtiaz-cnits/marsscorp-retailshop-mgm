<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$activeDb = DB::connection()->getDatabaseName();
echo "Active database: $activeDb\n";

$batteryTables = [
    'battery_brands', 'battery_categories', 'battery_customer_payment_details', 'battery_customers',
    'battery_expense_types', 'battery_expenses', 'battery_order_details', 'battery_order_payment_details',
    'battery_orders', 'battery_product_returns', 'battery_products', 'battery_purchase_order_details',
    'battery_purchase_payment_details', 'battery_purchase_returns', 'battery_purchases', 'battery_sub_categories',
    'battery_supplier_due_collections', 'battery_suppliers', 'battery_units', 'battery_warranty_cards', 'battery_warranty_claims'
];

$allEmpty = true;
foreach ($batteryTables as $t) {
    if (Schema::hasTable($t)) {
        $count = DB::table($t)->count();
        if ($count > 0) {
            echo "TABLE HAS ROWS: $t = $count rows!\n";
            $allEmpty = false;
        }
    }
}
$mapCount = Schema::hasTable('battery_migration_mappings') ? DB::table('battery_migration_mappings')->count() : 0;
if ($mapCount > 0) {
    echo "battery_migration_mappings has $mapCount rows!\n";
    $allEmpty = false;
}

if ($allEmpty) {
    echo "CONFIRMED: All 21 battery tables and mapping table in production have EXACTLY 0 ROWS.\n";
} else {
    echo "ALERT: Production battery tables are NOT empty!\n";
}

