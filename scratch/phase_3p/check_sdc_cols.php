<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb', 'root', '');
$cols = $pdo->query("DESCRIBE supplier_due_collections")->fetchAll(PDO::FETCH_ASSOC);
foreach ($cols as $c) {
    echo $c['Field'] . " (" . $c['Type'] . ")\n";
}
echo "\nRows:\n";
$rows = $pdo->query("SELECT * FROM supplier_due_collections")->fetchAll(PDO::FETCH_ASSOC);
print_r($rows);

