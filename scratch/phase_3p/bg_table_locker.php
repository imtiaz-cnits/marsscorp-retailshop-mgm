<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb_staging_verify', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

// Lock the 18 retail tables
$pdo->exec("LOCK TABLES 
    categories READ, brands READ, units READ, expense_types READ, 
    suppliers READ, customers READ, products READ, expenses READ, 
    purchases READ, purchase_order_details READ, purchase_payment_details READ, 
    purchase_returns READ, orders READ, order_details READ, 
    order_payment_details READ, product_returns READ, 
    customer_payment_details READ, supplier_due_collections READ;");

echo "TABLES_LOCKED\n";
flush();

$signalFile = __DIR__ . '/release_lock.signal';
if (file_exists($signalFile)) unlink($signalFile);

$startTime = time();
while (!file_exists($signalFile)) {
    usleep(100000); // 100ms
    if (time() - $startTime > 30) {
        echo "TIMEOUT\n";
        break;
    }
}

$pdo->exec("UNLOCK TABLES");
echo "TABLES_UNLOCKED\n";
if (file_exists($signalFile)) unlink($signalFile);
exit(0);

