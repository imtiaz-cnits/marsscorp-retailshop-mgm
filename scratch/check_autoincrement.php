<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$batteryTables = [
    'battery_brands', 'battery_categories', 'battery_customer_payment_details', 'battery_customers',
    'battery_expense_types', 'battery_expenses', 'battery_order_details', 'battery_order_payment_details',
    'battery_orders', 'battery_product_returns', 'battery_products', 'battery_purchase_order_details',
    'battery_purchase_payment_details', 'battery_purchase_returns', 'battery_purchases', 'battery_sub_categories',
    'battery_supplier_due_collections', 'battery_suppliers', 'battery_units', 'battery_warranty_cards', 'battery_warranty_claims',
    'battery_migration_mappings'
];

echo "Checking AUTO_INCREMENT for battery tables in marsscorpdb:\n";
foreach ($batteryTables as $t) {
    $row = DB::selectOne("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'marsscorpdb' AND TABLE_NAME = ?", [$t]);
    echo sprintf("%-35s : %s\n", $t, $row->AUTO_INCREMENT ?? 'NULL');
}

