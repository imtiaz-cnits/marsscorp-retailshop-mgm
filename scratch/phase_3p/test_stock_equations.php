<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb_staging_verify', 'root', '');

$products = [
    ['name' => 'Benq', 'src_id' => 737, 'inferred_open' => 0, 'exp_close' => 1],
    ['name' => 'PTB-250', 'src_id' => 568, 'inferred_open' => 1, 'exp_close' => 0],
    ['name' => 'AP-29', 'src_id' => 736, 'inferred_open' => 2, 'exp_close' => 0],
    ['name' => 'HPD-225T', 'src_id' => 567, 'inferred_open' => 0, 'exp_close' => 0],
    ['name' => 'NEXCELL-235', 'src_id' => 569, 'inferred_open' => 0, 'exp_close' => 0],
];

echo "Per-Product Stock Verification:\n";
echo str_repeat('-', 80) . "\n";
printf("%-12s | %-6s | %-6s | %-6s | %-6s | %-6s | %-6s | %s\n", "Product", "Open", "Purch", "Sales", "Ret", "Calculated", "Actual", "Status");
echo str_repeat('-', 80) . "\n";

foreach ($products as $p) {
    $row = $pdo->query("SELECT id, quantity FROM battery_products WHERE product_name = '{$p['name']}'")->fetch(PDO::FETCH_ASSOC);
    $batId = $row['id'];
    $actualQty = (int)$row['quantity'];
    
    $purchStmt = $pdo->query("SELECT COALESCE(SUM(quantity), 0) FROM battery_purchase_order_details WHERE product_id = {$batId}");
    $purchQty = (int)$purchStmt->fetchColumn();
    
    $salesStmt = $pdo->query("SELECT COALESCE(SUM(quantity), 0) FROM battery_order_details WHERE product_id = {$batId}");
    $salesQty = (int)$salesStmt->fetchColumn();
    
    $retStmt = $pdo->query("SELECT COALESCE(SUM(quantity), 0) FROM battery_product_returns WHERE product_id = {$batId}");
    $retQty = (int)$retStmt->fetchColumn();
    
    $calcClosing = $p['inferred_open'] + $purchQty - $salesQty + $retQty;
    $status = ($calcClosing === $p['exp_close'] && $actualQty === $p['exp_close']) ? "PASS" : "FAIL";
    
    printf("%-12s | %-6d | %-6d | %-6d | %-6d | %-6d | %-6d | %s\n", 
        $p['name'], $p['inferred_open'], $purchQty, $salesQty, $retQty, $calcClosing, $actualQty, $status);
}
echo str_repeat('-', 80) . "\n";

