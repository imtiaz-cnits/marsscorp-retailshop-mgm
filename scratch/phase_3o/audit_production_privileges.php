<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== WORKSTREAM A: MYSQL 8.4.3 PRIVILEGE FORENSIC AUDIT (READ-ONLY) ===\n";

// 1. All Users from mysql.user
echo "\n--- 1. ACCOUNTS IN mysql.user ---\n";
$users = DB::select("SELECT User, Host, account_locked, password_expired FROM mysql.user");
printf("%-20s | %-15s | %-15s | %-15s\n", "User", "Host", "Account Locked", "Pass Expired");
echo str_repeat("-", 75) . "\n";
foreach ($users as $u) {
    printf("%-20s | %-15s | %-15s | %-15s\n", $u->User, $u->Host, $u->account_locked, $u->password_expired);
}

// 2. SHOW GRANTS for each user
echo "\n--- 2. SHOW GRANTS FOR EACH ACCOUNT ---\n";
$accountGrants = [];
foreach ($users as $u) {
    $userHost = "`{$u->User}`@`{$u->Host}`";
    echo "\nGrants for $userHost:\n";
    try {
        $grants = DB::select("SHOW GRANTS FOR $userHost");
        $accountGrants[$userHost] = [];
        foreach ($grants as $g) {
            $grantStr = array_values((array)$g)[0];
            echo "  $grantStr\n";
            $accountGrants[$userHost][] = $grantStr;
        }
    } catch (\Exception $e) {
        echo "  Error querying grants: " . $e->getMessage() . "\n";
        $accountGrants[$userHost] = "ERROR: " . $e->getMessage();
    }
}

// 3. Database-level privileges in mysql.db
echo "\n--- 3. DATABASE-LEVEL PRIVILEGES (mysql.db) ---\n";
$dbPrivs = DB::select("SELECT User, Host, Db, Select_priv, Insert_priv, Update_priv, Delete_priv, Create_priv, Drop_priv, Grant_priv FROM mysql.db");
if (empty($dbPrivs)) {
    echo "No rows in mysql.db (no explicit db-level grants defined directly in mysql.db).\n";
} else {
    foreach ($dbPrivs as $d) {
        echo json_encode($d) . "\n";
    }
}

// 4. Table-level privileges in mysql.tables_priv
echo "\n--- 4. TABLE-LEVEL PRIVILEGES (mysql.tables_priv) ---\n";
$tblPrivs = DB::select("SELECT User, Host, Db, Table_name, Table_priv, Column_priv FROM mysql.tables_priv");
if (empty($tblPrivs)) {
    echo "No rows in mysql.tables_priv (no table-specific grants).\n";
} else {
    foreach ($tblPrivs as $t) {
        echo json_encode($t) . "\n";
    }
}

// 5. Column-level privileges in mysql.columns_priv
echo "\n--- 5. COLUMN-LEVEL PRIVILEGES (mysql.columns_priv) ---\n";
$colPrivs = DB::select("SELECT User, Host, Db, Table_name, Column_name, Column_priv FROM mysql.columns_priv");
if (empty($colPrivs)) {
    echo "No rows in mysql.columns_priv (no column-specific grants).\n";
} else {
    foreach ($colPrivs as $c) {
        echo json_encode($c) . "\n";
    }
}

// 6. Routine privileges in mysql.procs_priv
echo "\n--- 6. ROUTINE PRIVILEGES (mysql.procs_priv) ---\n";
$procPrivs = DB::select("SELECT User, Host, Db, Routine_name, Routine_type, Proc_priv FROM mysql.procs_priv");
if (empty($procPrivs)) {
    echo "No rows in mysql.procs_priv.\n";
} else {
    foreach ($procPrivs as $p) {
        echo json_encode($p) . "\n";
    }
}

// 7. Roles and Default Roles in MySQL 8.4
echo "\n--- 7. ROLES & ROLE EDGES (mysql.role_edges & mysql.default_roles) ---\n";
try {
    $roleEdges = DB::select("SELECT FROM_HOST, FROM_USER, TO_HOST, TO_USER, WITH_ADMIN_OPTION FROM mysql.role_edges");
    echo "Role Edges Count: " . count($roleEdges) . "\n";
    foreach ($roleEdges as $re) {
        echo "  Role: {$re->FROM_USER}@{$re->FROM_HOST} -> User: {$re->TO_USER}@{$re->TO_HOST}\n";
    }
} catch (\Exception $e) {
    echo "  mysql.role_edges query note: " . $e->getMessage() . "\n";
}

try {
    $defRoles = DB::select("SELECT HOST, USER, DEFAULT_ROLE_HOST, DEFAULT_ROLE_USER FROM mysql.default_roles");
    echo "Default Roles Count: " . count($defRoles) . "\n";
    foreach ($defRoles as $dr) {
        echo "  User: {$dr->USER}@{$dr->HOST} -> Default Role: {$dr->DEFAULT_ROLE_USER}@{$dr->DEFAULT_ROLE_HOST}\n";
    }
} catch (\Exception $e) {
    echo "  mysql.default_roles query note: " . $e->getMessage() . "\n";
}

// 8. information_schema.SCHEMA_PRIVILEGES for marsscorpdb
echo "\n--- 8. SCHEMA_PRIVILEGES for marsscorpdb ---\n";
$schemaPrivs = DB::select("SELECT * FROM information_schema.SCHEMA_PRIVILEGES WHERE TABLE_SCHEMA = 'marsscorpdb'");
echo "marsscorpdb schema privileges count: " . count($schemaPrivs) . "\n";
foreach ($schemaPrivs as $sp) {
    echo json_encode($sp) . "\n";
}

// 9. Inspect Laravel .env configuration for DB user
echo "\n--- 9. LARAVEL .ENV DATABASE CONNECTION CREDENTIALS IDENTITY ---\n";
$dbConfig = config('database.connections.mysql');
echo "Config DB Connection: " . ($dbConfig['driver'] ?? 'N/A') . "\n";
echo "Host: " . ($dbConfig['host'] ?? 'N/A') . ":" . ($dbConfig['port'] ?? 'N/A') . "\n";
echo "Database: " . ($dbConfig['database'] ?? 'N/A') . "\n";
echo "Username: " . ($dbConfig['username'] ?? 'N/A') . "\n";
echo "Password Configured: " . (!empty($dbConfig['password']) ? "YES (MASKED)" : "NO / EMPTY") . "\n";

file_put_contents('scratch/phase_3o/privilege_inventory_raw.json', json_encode([
    'users' => $users,
    'account_grants' => $accountGrants,
    'db_privs' => $dbPrivs,
    'tbl_privs' => $tblPrivs,
    'col_privs' => $colPrivs,
    'proc_privs' => $procPrivs,
    'role_edges' => $roleEdges ?? [],
    'default_roles' => $defRoles ?? [],
    'schema_privs' => $schemaPrivs,
    'env_db_user' => $dbConfig['username'] ?? 'N/A'
], JSON_PRETTY_PRINT));

echo "\nPrivilege inventory saved to scratch/phase_3o/privilege_inventory_raw.json\n";

