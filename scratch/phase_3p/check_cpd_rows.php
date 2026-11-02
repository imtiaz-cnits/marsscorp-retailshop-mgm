<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb', 'root', '');
$rows = $pdo->query("SELECT id, customer_id, paid_amount, due_amount, previous_due_amount, due_collection_date, transaction_id FROM customer_payment_details WHERE id IN (4, 6, 15, 19, 27)")->fetchAll(PDO::FETCH_ASSOC);
print_r($rows);

