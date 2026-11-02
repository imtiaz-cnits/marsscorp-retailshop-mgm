<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb_staging_verify', 'root', '');

$errors = [];

// 1. Individual Customers
$nur = $pdo->query("SELECT customer_name, previous_due_amount FROM battery_customers WHERE customer_name LIKE '%Nur%'")->fetch(PDO::FETCH_ASSOC);
if (!$nur || abs($nur['previous_due_amount'] - 467465.00) > 0.01) {
    $errors[] = "Nur Battery opening due mismatch. Got: " . ($nur['previous_due_amount'] ?? 'null');
}

$riyaz = $pdo->query("SELECT id, customer_name, previous_due_amount FROM battery_customers WHERE customer_name LIKE '%Riyaz%'")->fetch(PDO::FETCH_ASSOC);
if (!$riyaz || abs($riyaz['previous_due_amount'] - 23592.00) > 0.01) {
    $errors[] = "Riyaz Battery opening due mismatch. Got: " . ($riyaz['previous_due_amount'] ?? 'null');
}
$riyazOrderDue = $pdo->query("SELECT SUM(due_amount) FROM battery_orders WHERE customer_id = {$riyaz['id']}")->fetchColumn();
if (abs($riyazOrderDue - 37674.00) > 0.01) {
    $errors[] = "Riyaz Battery order due mismatch. Got: {$riyazOrderDue}";
}
$riyazTotal = $riyaz['previous_due_amount'] + $riyazOrderDue;
if (abs($riyazTotal - 61266.00) > 0.01) {
    $errors[] = "Riyaz Battery total receivable mismatch. Got: {$riyazTotal}";
}

$saleha = $pdo->query("SELECT id, customer_name, previous_due_amount FROM battery_customers WHERE customer_name LIKE '%Saleha%'")->fetch(PDO::FETCH_ASSOC);
if (!$saleha || abs($saleha['previous_due_amount'] - 0.00) > 0.01) {
    $errors[] = "Ma Saleha opening due mismatch. Got: " . ($saleha['previous_due_amount'] ?? 'null');
}
$salehaOrderDue = $pdo->query("SELECT SUM(due_amount) FROM battery_orders WHERE customer_id = {$saleha['id']}")->fetchColumn();
if (abs($salehaOrderDue - 94500.00) > 0.01) {
    $errors[] = "Ma Saleha order due mismatch. Got: {$salehaOrderDue}";
}

$totalRec = $pdo->query("SELECT (SELECT SUM(previous_due_amount) FROM battery_customers) + (SELECT SUM(due_amount) FROM battery_orders)")->fetchColumn();
if (abs($totalRec - 623231.00) > 0.01) {
    $errors[] = "Total Receivables mismatch. Got: {$totalRec}";
}

// 2. Individual Suppliers
$polo = $pdo->query("SELECT name, purchase_payable_amount FROM battery_suppliers WHERE name LIKE '%Polo%'")->fetch(PDO::FETCH_ASSOC);
if (!$polo || abs($polo['purchase_payable_amount'] - 7360.00) > 0.01) {
    $errors[] = "Polo Battery payable mismatch. Got: " . ($polo['purchase_payable_amount'] ?? 'null');
}

$ck124 = $pdo->query("SELECT id, name, purchase_payable_amount FROM battery_suppliers WHERE name LIKE '%124%' OR name LIKE '%CK%'")->fetch(PDO::FETCH_ASSOC);
if (!$ck124 || abs($ck124['purchase_payable_amount'] - 0.00) > 0.01) {
    $errors[] = "CK124 opening payable mismatch. Got: " . ($ck124['purchase_payable_amount'] ?? 'null');
}
$ck124PurchDue = $pdo->query("SELECT SUM(due_amount) FROM battery_purchases WHERE supplier_id = {$ck124['id']}")->fetchColumn();
if (abs($ck124PurchDue - 108000.00) > 0.01) {
    $errors[] = "CK124 purchase due mismatch. Got: {$ck124PurchDue}";
}

$totalPay = $pdo->query("SELECT (SELECT SUM(purchase_payable_amount) FROM battery_suppliers) + (SELECT SUM(due_amount) FROM battery_purchases)")->fetchColumn();
if (abs($totalPay - 115360.00) > 0.01) {
    $errors[] = "Total Payables mismatch. Got: {$totalPay}";
}

// 3. Option B Pure Expenses
$expTotal = $pdo->query("SELECT SUM(expense_amount) FROM battery_expenses")->fetchColumn();
if (abs($expTotal - 260.00) > 0.01) {
    $errors[] = "Battery expenses mismatch. Got: {$expTotal}";
}

// 4. Collections
$custColl = $pdo->query("SELECT SUM(paid_amount) FROM battery_customer_payment_details")->fetchColumn();
if (abs($custColl - 144186.00) > 0.01) {
    $errors[] = "Customer collections mismatch. Got: {$custColl}";
}
$suppColl = $pdo->query("SELECT SUM(paid_amount) FROM battery_supplier_due_collections")->fetchColumn();
if (abs($suppColl - 105000.00) > 0.01) {
    $errors[] = "Supplier collections mismatch. Got: {$suppColl}";
}

// 5. Invoices
// Order #26 (InvID00024): 1 PTB-250 unit mirrored at 0.00 sub_total / 0.00 due
$order26Map = $pdo->query("SELECT destination_id FROM battery_migration_mappings WHERE source_module = 'retail' AND source_table = 'orders' AND source_id = 26")->fetchColumn();
if ($order26Map) {
    $ord26 = $pdo->query("SELECT sub_total, due_amount FROM battery_orders WHERE id = {$order26Map}")->fetch(PDO::FETCH_ASSOC);
    if (abs($ord26['sub_total'] - 0.00) > 0.01 || abs($ord26['due_amount'] - 0.00) > 0.01) {
        $errors[] = "Order #26 mirror value mismatch. Subtotal: {$ord26['sub_total']}, Due: {$ord26['due_amount']}";
    }
} else {
    $errors[] = "Order #26 mapping not found";
}

// Order #62 (InvID00060): 7 Benq units @ 13,500 = 94,500.00
$order62Map = $pdo->query("SELECT destination_id FROM battery_migration_mappings WHERE source_module = 'retail' AND source_table = 'orders' AND source_id = 62")->fetchColumn();
if ($order62Map) {
    $ord62 = $pdo->query("SELECT sub_total, due_amount FROM battery_orders WHERE id = {$order62Map}")->fetch(PDO::FETCH_ASSOC);
    if (abs($ord62['due_amount'] - 94500.00) > 0.01) {
        $errors[] = "Order #62 due mismatch. Got: {$ord62['due_amount']}";
    }
} else {
    $errors[] = "Order #62 mapping not found";
}

// 6. Mappings Uniqueness
$dupMappings = $pdo->query("SELECT COUNT(*) - COUNT(DISTINCT source_module, source_table, source_id) FROM battery_migration_mappings")->fetchColumn();
if ((int)$dupMappings !== 0) {
    $errors[] = "Duplicate mappings detected: {$dupMappings}";
}

if (!empty($errors)) {
    echo "FAILED with " . count($errors) . " errors:\n";
    foreach ($errors as $e) echo " - $e\n";
    exit(1);
} else {
    echo "ALL INDIVIDUAL RECONCILIATION CHECKS PASSED PERFECTLY!\n";
    echo "Customers: Nur (৳467,465), Riyaz (৳23,592 + ৳37,674 = ৳61,266), Ma Saleha (৳0 + ৳94,500 = ৳94,500). Total Receivables: ৳623,231.00\n";
    echo "Suppliers: Polo (৳7,360), CK124 (৳108,000). Total Payables: ৳115,360.00\n";
    echo "Expenses: Option B Acid Purchase = ৳260.00\n";
    echo "Collections: Customer = ৳144,186.00, Supplier = ৳105,000.00\n";
    echo "Orders: #26 mirrored at ৳0.00, #62 at ৳94,500.00\n";
    echo "Mappings: Unique, 0 duplicates.\n";
    exit(0);
}
