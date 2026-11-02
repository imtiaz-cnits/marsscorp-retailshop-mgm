<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$batteryTables = [
    'battery_categories', 'battery_brands', 'battery_units', 'battery_expense_types',
    'battery_suppliers', 'battery_customers', 'battery_products', 'battery_expenses',
    'battery_purchases', 'battery_purchase_order_details', 'battery_purchase_payment_details',
    'battery_purchase_returns', 'battery_purchase_return_details', 'battery_orders',
    'battery_order_details', 'battery_order_payment_details', 'battery_product_returns',
    'battery_product_return_details', 'battery_customer_payment_details',
    'battery_supplier_due_collections', 'battery_supplier_payment_details',
    'battery_migration_mappings'
];

$nonZero = [];
foreach ($batteryTables as $table) {
    try {
        $count = DB::table($table)->count();
        if ($count > 0) {
            $nonZero[$table] = $count;
        }
    } catch (\Exception $e) {
        $nonZero[$table] = "Error: " . $e->getMessage();
    }
}

echo "Production (marsscorpdb) Battery Non-Zero Tables: " . json_encode($nonZero) . "\n";

