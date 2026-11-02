<?php
$p = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$p->exec("CREATE DATABASE IF NOT EXISTS p3p_ro_test");
$p->exec("CREATE TABLE IF NOT EXISTS p3p_ro_test.t (id INT)");
$p->exec("ALTER DATABASE p3p_ro_test READ ONLY = 1");

echo "Schema read_only option set to 1.\n";
try {
    $p->exec("INSERT INTO p3p_ro_test.t VALUES (1)");
    echo "Root was able to insert!\n";
} catch (\PDOException $e) {
    echo "Blocked! Error code: " . $e->errorInfo[1] . " | " . $e->getMessage() . "\n";
}

$p->exec("ALTER DATABASE p3p_ro_test READ ONLY = 0");
$p->exec("DROP DATABASE p3p_ro_test");
echo "Cleaned up.\n";

