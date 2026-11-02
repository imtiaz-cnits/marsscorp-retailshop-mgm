<?php
$p = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$p->exec("CREATE DATABASE IF NOT EXISTS p3p_ro_test");
$p->exec("CREATE TABLE IF NOT EXISTS p3p_ro_test.t (id INT)");

$p->exec("CREATE USER IF NOT EXISTS 'test_u'@'localhost' IDENTIFIED BY 'pass123'");
$p->exec("GRANT ALL ON p3p_ro_test.* TO 'test_u'@'localhost'");
$p->exec("FLUSH PRIVILEGES");

$p->exec("ALTER DATABASE p3p_ro_test READ ONLY = 1");

$uPdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=p3p_ro_test', 'test_u', 'pass123', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
try {
    $uPdo->exec("INSERT INTO t VALUES (1)");
    echo "test_u was able to write!\n";
} catch (\PDOException $e) {
    echo "test_u blocked! " . $e->getMessage() . "\n";
}

$p->exec("ALTER DATABASE p3p_ro_test READ ONLY = 0");
$p->exec("DROP USER 'test_u'@'localhost'");
$p->exec("DROP DATABASE p3p_ro_test");
echo "Cleaned up.\n";

