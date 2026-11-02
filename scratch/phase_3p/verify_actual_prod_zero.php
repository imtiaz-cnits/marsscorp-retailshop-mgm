<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb', 'root', '');
$tables = $pdo->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'marsscorpdb' AND TABLE_NAME LIKE 'battery_%' ORDER BY TABLE_NAME")->fetchAll(PDO::FETCH_COLUMN);
$total = 0;
foreach ($tables as $t) {
    $c = (int)$pdo->query("SELECT COUNT(*) FROM `marsscorpdb`.`{$t}`")->fetchColumn();
    $total += $c;
}
echo "Total tables: " . count($tables) . " | Total rows in marsscorpdb battery tables: " . $total . "\n";

