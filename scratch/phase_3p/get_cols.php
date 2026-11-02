<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb_staging_verify', 'root', '');
echo "ORDERS:\n" . implode(", ", $pdo->query("DESCRIBE orders")->fetchAll(PDO::FETCH_COLUMN)) . "\n\n";
echo "BATTERY_UNITS:\n" . implode(", ", $pdo->query("DESCRIBE battery_units")->fetchAll(PDO::FETCH_COLUMN)) . "\n";

