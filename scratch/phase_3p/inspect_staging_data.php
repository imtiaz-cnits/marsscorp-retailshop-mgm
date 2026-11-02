<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb_staging_verify', 'root', '');
$stmt = $pdo->query("SELECT id, product_name, quantity FROM battery_products");
while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo $r['id'] . ": " . $r['product_name'] . " = " . $r['quantity'] . "\n";
}

