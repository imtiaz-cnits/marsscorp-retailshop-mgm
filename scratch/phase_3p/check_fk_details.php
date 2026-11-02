<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb', 'root', '');
$fkConstraints = $pdo->query("SELECT COUNT(DISTINCT CONSTRAINT_NAME) FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = 'marsscorpdb' AND REFERENCED_TABLE_NAME IS NOT NULL")->fetchColumn();
$allFkConstraints = $pdo->query("SELECT COUNT(DISTINCT CONSTRAINT_NAME) FROM information_schema.REFERENTIAL_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = 'marsscorpdb'")->fetchColumn();
echo "Distinct FK constraints (KCU): $fkConstraints\n";
echo "REFERENTIAL_CONSTRAINTS: $allFkConstraints\n";

