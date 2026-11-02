<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb', 'root', '');
$exists = $pdo->query("SHOW TABLES LIKE 'supplier_due_collections'")->fetchColumn();
echo "Table supplier_due_collections exists: " . ($exists ? "YES" : "NO") . "\n";
if ($exists) {
    $rows = $pdo->query("SELECT id, supplier_id, paid_amount, due_amount, payment_date FROM supplier_due_collections")->fetchAll(PDO::FETCH_ASSOC);
    print_r($rows);
}

