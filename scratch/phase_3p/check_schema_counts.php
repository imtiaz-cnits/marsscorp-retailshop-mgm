<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb', 'root', '');
$tables = $pdo->query("SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'marsscorpdb'")->fetchColumn();
$cols = $pdo->query("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = 'marsscorpdb'")->fetchColumn();
$fks = $pdo->query("SELECT COUNT(*) FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = 'marsscorpdb' AND REFERENCED_TABLE_NAME IS NOT NULL")->fetchColumn();
$idxs = $pdo->query("SELECT COUNT(DISTINCT TABLE_NAME, INDEX_NAME) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = 'marsscorpdb'")->fetchColumn();
echo "Tables: $tables | Columns: $cols | FKs: $fks | Indexes: $idxs\n";

