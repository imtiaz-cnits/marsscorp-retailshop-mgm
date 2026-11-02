<?php
$pA = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$pA->exec("CREATE DATABASE IF NOT EXISTS p3p_lock_test");
$pA->exec("CREATE TABLE IF NOT EXISTS p3p_lock_test.retail_tbl (id INT)");
$pA->exec("CREATE TABLE IF NOT EXISTS p3p_lock_test.battery_tbl (id INT)");

// Connection A locks retail_tbl READ
$pA->exec("LOCK TABLES p3p_lock_test.retail_tbl READ");
echo "Connection A acquired READ lock on retail_tbl.\n";

// Connection B tries to write to battery_tbl (should succeed!)
$pB = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$pB->exec("INSERT INTO p3p_lock_test.battery_tbl VALUES (101)");
echo "Connection B successfully wrote to battery_tbl while retail_tbl is locked!\n";

// Connection B tries to write to retail_tbl with short timeout (should be blocked!)
$pB->exec("SET SESSION lock_wait_timeout = 2");
try {
    $pB->exec("INSERT INTO p3p_lock_test.retail_tbl VALUES (202)");
    echo "CRITICAL: Connection B was able to write to retail_tbl!\n";
} catch (\PDOException $e) {
    echo "BLOCKED: Connection B could NOT write to retail_tbl! (" . $e->getMessage() . ")\n";
}

$pA->exec("UNLOCK TABLES");
$pA->exec("DROP DATABASE p3p_lock_test");
echo "Cleaned up.\n";

