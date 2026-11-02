<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb_staging_verify', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$currentDb = $pdo->query("SELECT DATABASE()")->fetchColumn();
if ($currentDb !== 'marsscorpdb_staging_verify') {
    fwrite(STDERR, "FATAL: Connection identity mismatch! Expected 'marsscorpdb_staging_verify', got '{$currentDb}'\n");
    exit(1);
}

$expected21 = [
    'battery_brands', 'battery_categories', 'battery_customer_payment_details', 'battery_customers',
    'battery_expense_types', 'battery_expenses', 'battery_migration_mappings', 'battery_opening_balances',
    'battery_order_details', 'battery_order_payment_details', 'battery_orders', 'battery_product_returns',
    'battery_products', 'battery_purchase_order_details', 'battery_purchase_payment_details',
    'battery_purchase_returns', 'battery_purchases', 'battery_sub_categories', 'battery_supplier_due_collections',
    'battery_suppliers', 'battery_units'
];
sort($expected21);

$actualBatteryTables = $pdo->query("
    SELECT TABLE_NAME 
    FROM information_schema.TABLES 
    WHERE TABLE_SCHEMA = 'marsscorpdb_staging_verify' 
      AND TABLE_NAME LIKE 'battery_%'
    ORDER BY TABLE_NAME
")->fetchAll(PDO::FETCH_COLUMN);

if ($expected21 !== $actualBatteryTables) {
    fwrite(STDERR, "FATAL: Battery tables list mismatch in staging!\n");
    exit(1);
}

// Count rows across all 21 tables
$totalRows = 0;
$rowCounts = [];
foreach ($expected21 as $tbl) {
    $c = (int)$pdo->query("SELECT COUNT(*) FROM `marsscorpdb_staging_verify`.`{$tbl}`")->fetchColumn();
    $rowCounts[$tbl] = $c;
    $totalRows += $c;
}

echo "Current Staging Battery Rows: {$totalRows}\n";
echo "Pre-state inspection verified.\n";

