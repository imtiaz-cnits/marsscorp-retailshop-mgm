<?php
$p = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$p->exec("CREATE DATABASE IF NOT EXISTS p3p_ro_priv_test");
$p->exec("CREATE TABLE IF NOT EXISTS p3p_ro_priv_test.t (id INT)");
$p->exec("DROP USER IF EXISTS 'ro_test_user'@'localhost'");
$p->exec("CREATE USER 'ro_test_user'@'localhost' IDENTIFIED BY 'pass123'");
$p->exec("GRANT ALL ON p3p_ro_priv_test.* TO 'ro_test_user'@'localhost'");

// Let's test various administrative privileges to see if any allows write under READ ONLY = 1
$privs = [
    'SYSTEM_VARIABLES_ADMIN',
    'CONNECTION_ADMIN',
    'SUPER',
    'REPLICATION_SLAVE_ADMIN',
    'SCHEMA_REGISTRATION_ADMIN'
];

foreach ($privs as $priv) {
    try {
        $p->exec("GRANT $priv ON *.* TO 'ro_test_user'@'localhost'");
    } catch (\Exception $e) {
        echo "Could not grant $priv: " . $e->getMessage() . "\n";
    }
}
$p->exec("FLUSH PRIVILEGES");

$p->exec("ALTER DATABASE p3p_ro_priv_test READ ONLY = 1");

$u = new PDO('mysql:host=127.0.0.1;port=3306;dbname=p3p_ro_priv_test', 'ro_test_user', 'pass123', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
try {
    $u->exec("INSERT INTO t VALUES (99)");
    echo "SUCCESS: ro_test_user was able to write under READ ONLY = 1!\n";
} catch (\PDOException $e) {
    echo "BLOCKED: " . $e->getMessage() . "\n";
}

$p->exec("ALTER DATABASE p3p_ro_priv_test READ ONLY = 0");
$p->exec("DROP USER 'ro_test_user'@'localhost'");
$p->exec("DROP DATABASE p3p_ro_priv_test");

