<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Connect to staging
config(['database.connections.mysql.database' => 'marsscorpdb_staging_verify']);
DB::purge('mysql');
DB::reconnect('mysql');

$db = DB::connection()->getDatabaseName();
echo "Connected to: $db\n";

$batteryTables = [
    'battery_brands', 'battery_categories', 'battery_customer_payment_details', 'battery_customers',
    'battery_expense_types', 'battery_expenses', 'battery_order_details', 'battery_order_payment_details',
    'battery_orders', 'battery_product_returns', 'battery_products', 'battery_purchase_order_details',
    'battery_purchase_payment_details', 'battery_purchase_returns', 'battery_purchases', 'battery_sub_categories',
    'battery_supplier_due_collections', 'battery_suppliers', 'battery_units', 'battery_warranty_cards', 'battery_warranty_claims'
];

$hasRows = false;
foreach ($batteryTables as $t) {
    if (Illuminate\Support\Facades\Schema::hasTable($t)) {
        $c = DB::table($t)->count();
        if ($c > 0) {
            echo "Table $t has $c rows!\n";
            $hasRows = true;
        }
    }
}
$mapCount = Illuminate\Support\Facades\Schema::hasTable('battery_migration_mappings') ? DB::table('battery_migration_mappings')->count() : 0;
echo "battery_migration_mappings count: $mapCount\n";
echo "Staging clean: " . (!$hasRows && $mapCount === 0 ? "YES" : "NO") . "\n";

