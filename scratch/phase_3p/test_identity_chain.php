<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb_staging_verify', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$errors = [];

// 1. Identity Chain for Products
$products = [
    ['src_id' => 737, 'expected_name' => 'Benq', 'open' => 0, 'exp_close' => 1],
    ['src_id' => 568, 'expected_name' => 'PTB-250', 'open' => 1, 'exp_close' => 0],
    ['src_id' => 736, 'expected_name' => 'AP-29', 'open' => 2, 'exp_close' => 0],
    ['src_id' => 567, 'expected_name' => 'HPD-225T', 'open' => 0, 'exp_close' => 0],
    ['src_id' => 569, 'expected_name' => 'NEXCELL-235', 'open' => 0, 'exp_close' => 0],
];

echo "=== IDENTITY CHAIN: PRODUCTS ===\n";
foreach ($products as $p) {
    // A. Source table check
    $srcRow = $pdo->query("SELECT id, product_name FROM products WHERE id = {$p['src_id']}")->fetch(PDO::FETCH_ASSOC);
    if (!$srcRow) {
        $errors[] = "Source product {$p['src_id']} not found in 'products'!";
        continue;
    }
    
    // B. Mapping check
    $mapStmt = $pdo->prepare("SELECT destination_id FROM battery_migration_mappings WHERE source_module = 'retail' AND source_table = 'products' AND source_id = ?");
    $mapStmt->execute([$p['src_id']]);
    $destId = $mapStmt->fetchColumn();
    if (!$destId) {
        $errors[] = "No mapping found for Source Product {$p['src_id']} ({$p['expected_name']})!";
        continue;
    }
    
    // C. Destination table check & Business Identity Equivalence
    $destRow = $pdo->query("SELECT id, product_name, quantity FROM battery_products WHERE id = {$destId}")->fetch(PDO::FETCH_ASSOC);
    if (!$destRow || empty($destRow['product_name'])) {
        $errors[] = "Destination battery_products {$destId} not found or null!";
        continue;
    }
    
    // Explicit business name equivalence
    if (trim($srcRow['product_name']) !== trim($destRow['product_name'])) {
        $errors[] = "Product business identity equivalence failed: Source '{$srcRow['product_name']}' vs Dest '{$destRow['product_name']}'!";
    }
    
    // D. Transaction balance check via destination_id
    $purch = (int)$pdo->query("SELECT COALESCE(SUM(quantity), 0) FROM battery_purchase_order_details WHERE product_id = {$destId}")->fetchColumn();
    $sales = (int)$pdo->query("SELECT COALESCE(SUM(quantity), 0) FROM battery_order_details WHERE product_id = {$destId}")->fetchColumn();
    $ret   = (int)$pdo->query("SELECT COALESCE(SUM(quantity), 0) FROM battery_product_returns WHERE product_id = {$destId}")->fetchColumn();
    
    $calcClose = $p['open'] + $purch - $sales + $ret;
    $actualClose = (int)$destRow['quantity'];
    
    $status = ($calcClose === $p['exp_close'] && $actualClose === $p['exp_close']) ? "MATCH" : "MISMATCH";
    if ($status === "MISMATCH") {
        $errors[] = "Product {$p['expected_name']} equation mismatch: calc={$calcClose}, actual={$actualClose}, exp={$p['exp_close']}";
    }
    
    printf("Src ID %-3d -> Dest ID %-2d | %-12s | Open: %d + Purch: %d - Sales: %d + Ret: %d = Calc: %d (Actual: %d) [%s]\n",
        $p['src_id'], $destId, $destRow['product_name'], $p['open'], $purch, $sales, $ret, $calcClose, $actualClose, $status);
}

// 2. Identity Chain for Customers
$customers = [
    ['src_id' => 2,  'exp_name' => 'Nur Battery', 'exp_open' => 467465.00, 'exp_order_due' => 0.00,    'exp_total' => 467465.00],
    ['src_id' => 5,  'exp_name' => 'Riyaz Battery', 'exp_open' => 23592.00, 'exp_order_due' => 37674.00, 'exp_total' => 61266.00],
    ['src_id' => 1,  'exp_name' => 'Ma Saleha',     'exp_open' => 0.00,     'exp_order_due' => 94500.00, 'exp_total' => 94500.00],
];

echo "\n=== IDENTITY CHAIN: CUSTOMERS ===\n";
foreach ($customers as $c) {
    $srcRow = $pdo->query("SELECT id, customer_name FROM customers WHERE id = {$c['src_id']}")->fetch(PDO::FETCH_ASSOC);
    $mapStmt = $pdo->prepare("SELECT destination_id FROM battery_migration_mappings WHERE source_module = 'retail' AND source_table = 'customers' AND source_id = ?");
    $mapStmt->execute([$c['src_id']]);
    $destId = $mapStmt->fetchColumn();
    if (!$destId) {
        $errors[] = "No mapping found for Customer {$c['src_id']} ({$c['exp_name']})!";
        continue;
    }
    
    $destRow = $pdo->query("SELECT id, customer_name, previous_due_amount FROM battery_customers WHERE id = {$destId}")->fetch(PDO::FETCH_ASSOC);
    if (!$destRow || empty($destRow['customer_name'])) {
        $errors[] = "Destination battery_customers {$destId} not found or null!";
        continue;
    }
    
    // Explicit business identity equivalence
    if (trim($srcRow['customer_name']) !== trim($destRow['customer_name'])) {
        $errors[] = "Customer business identity equivalence failed: Source '{$srcRow['customer_name']}' vs Dest '{$destRow['customer_name']}'!";
    }
    $ordersDue = (float)$pdo->query("SELECT COALESCE(SUM(due_amount), 0) FROM battery_orders WHERE customer_id = {$destId}")->fetchColumn();
    $openDue = (float)$destRow['previous_due_amount'];
    $totalRec = $openDue + $ordersDue;
    
    $match = (abs($openDue - $c['exp_open']) < 0.01 && abs($ordersDue - $c['exp_order_due']) < 0.01 && abs($totalRec - $c['exp_total']) < 0.01);
    if (!$match) $errors[] = "Customer {$c['exp_name']} balance mismatch!";
    
    printf("Src ID %-2d -> Dest ID %-2d | %-16s | Open: ৳%-10.2f + Orders: ৳%-9.2f = Total: ৳%-10.2f [%s]\n",
        $c['src_id'], $destId, $destRow['customer_name'], $openDue, $ordersDue, $totalRec, $match ? "MATCH" : "MISMATCH");
}

// 3. Identity Chain for Suppliers
$suppliers = [
    ['src_id' => 1,  'exp_name' => 'Polo Battery', 'exp_open' => 7360.00, 'exp_purch_due' => 0.00,      'exp_total' => 7360.00],
    ['src_id' => 11, 'exp_name' => 'CK124',        'exp_open' => 0.00,    'exp_purch_due' => 108000.00, 'exp_total' => 108000.00],
];

echo "\n=== IDENTITY CHAIN: SUPPLIERS ===\n";
foreach ($suppliers as $s) {
    $srcRow = $pdo->query("SELECT id, name FROM suppliers WHERE id = {$s['src_id']}")->fetch(PDO::FETCH_ASSOC);
    $mapStmt = $pdo->prepare("SELECT destination_id FROM battery_migration_mappings WHERE source_module = 'retail' AND source_table = 'suppliers' AND source_id = ?");
    $mapStmt->execute([$s['src_id']]);
    $destId = $mapStmt->fetchColumn();
    if (!$destId) {
        $errors[] = "No mapping found for Supplier {$s['src_id']} ({$s['exp_name']})!";
        continue;
    }
    
    $destRow = $pdo->query("SELECT id, name, purchase_payable_amount FROM battery_suppliers WHERE id = {$destId}")->fetch(PDO::FETCH_ASSOC);
    if (!$destRow || empty($destRow['name'])) {
        $errors[] = "Destination battery_suppliers {$destId} not found or null!";
        continue;
    }
    
    // Explicit business identity equivalence
    if (trim($srcRow['name']) !== trim($destRow['name'])) {
        $errors[] = "Supplier business identity equivalence failed: Source '{$srcRow['name']}' vs Dest '{$destRow['name']}'!";
    }
    $purchDue = (float)$pdo->query("SELECT COALESCE(SUM(due_amount), 0) FROM battery_purchases WHERE supplier_id = {$destId}")->fetchColumn();
    $openPay = (float)$destRow['purchase_payable_amount'];
    $totalPay = $openPay + $purchDue;
    
    $match = (abs($openPay - $s['exp_open']) < 0.01 && abs($purchDue - $s['exp_purch_due']) < 0.01 && abs($totalPay - $s['exp_total']) < 0.01);
    if (!$match) $errors[] = "Supplier {$s['exp_name']} balance mismatch!";
    
    printf("Src ID %-2d -> Dest ID %-2d | %-16s | Open: ৳%-10.2f + Purch: ৳%-10.2f = Total: ৳%-10.2f [%s]\n",
        $s['src_id'], $destId, $destRow['name'], $openPay, $purchDue, $totalPay, $match ? "MATCH" : "MISMATCH");
}

if (!empty($errors)) {
    echo "\nERRORS DETECTED:\n" . implode("\n", $errors) . "\n";
    exit(1);
} else {
    echo "\nALL IDENTITY-BASED CHAINS PASSED WITH 100% RELATIONAL PARITY!\n";
    exit(0);
}

