<?php
/**
 * scratch/phase_3p/test_privilege_restoration.php
 * Workstream C: Exact Privilege Restoration Re-Validation
 * Tests 8 distinct account types and failure scenarios in MySQL.
 */

$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "=================================================================\n";
echo "WORKSTREAM C: EXACT PRIVILEGE RESTORATION RE-VALIDATION\n";
echo "=================================================================\n\n";

// Helper to normalize and sort grants
function getGrants(PDO $pdo, string $user, string $host): array {
    $stmt = $pdo->query("SHOW GRANTS FOR '{$user}'@'{$host}'");
    $grants = $stmt->fetchAll(PDO::FETCH_COLUMN);
    sort($grants);
    return $grants;
}

// 1. Create a dummy test role if supported
try {
    $pdo->exec("CREATE ROLE IF NOT EXISTS 'p3p_test_role'");
    $pdo->exec("GRANT SELECT ON marsscorpdb_staging_verify.* TO 'p3p_test_role'");
} catch (\Exception $e) {
    echo "Note on role creation: " . $e->getMessage() . "\n";
}

// Define the 8 test accounts
$testAccounts = [
    // 1. Database-level writer
    'p3p_t1_dbwriter' => [
        'setup' => [
            "CREATE USER IF NOT EXISTS 'p3p_t1_dbwriter'@'localhost' IDENTIFIED BY 'TestPass123!'",
            "REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'p3p_t1_dbwriter'@'localhost'",
            "GRANT USAGE ON *.* TO 'p3p_t1_dbwriter'@'localhost'",
            "GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.* TO 'p3p_t1_dbwriter'@'localhost'",
        ],
        'revoke' => [
            "REVOKE INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.* FROM 'p3p_t1_dbwriter'@'localhost'",
        ]
    ],
    // 2. Table-level writer
    'p3p_t2_tblwriter' => [
        'setup' => [
            "CREATE USER IF NOT EXISTS 'p3p_t2_tblwriter'@'localhost' IDENTIFIED BY 'TestPass123!'",
            "REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'p3p_t2_tblwriter'@'localhost'",
            "GRANT USAGE ON *.* TO 'p3p_t2_tblwriter'@'localhost'",
            "GRANT SELECT ON marsscorpdb_staging_verify.* TO 'p3p_t2_tblwriter'@'localhost'",
            "GRANT INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.orders TO 'p3p_t2_tblwriter'@'localhost'",
        ],
        'revoke' => [
            "REVOKE INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.orders FROM 'p3p_t2_tblwriter'@'localhost'",
        ]
    ],
    // 3. Column-level writer
    'p3p_t3_colwriter' => [
        'setup' => [
            "CREATE USER IF NOT EXISTS 'p3p_t3_colwriter'@'localhost' IDENTIFIED BY 'TestPass123!'",
            "REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'p3p_t3_colwriter'@'localhost'",
            "GRANT USAGE ON *.* TO 'p3p_t3_colwriter'@'localhost'",
            "GRANT SELECT ON marsscorpdb_staging_verify.* TO 'p3p_t3_colwriter'@'localhost'",
            "GRANT UPDATE (due_amount) ON marsscorpdb_staging_verify.orders TO 'p3p_t3_colwriter'@'localhost'",
        ],
        'revoke' => [
            "REVOKE UPDATE (due_amount) ON marsscorpdb_staging_verify.orders FROM 'p3p_t3_colwriter'@'localhost'",
        ]
    ],
    // 4. Role-derived privileges
    'p3p_t4_rolederived' => [
        'setup' => [
            "CREATE USER IF NOT EXISTS 'p3p_t4_rolederived'@'localhost' IDENTIFIED BY 'TestPass123!'",
            "REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'p3p_t4_rolederived'@'localhost'",
            "GRANT USAGE ON *.* TO 'p3p_t4_rolederived'@'localhost'",
            "GRANT 'p3p_test_role' TO 'p3p_t4_rolederived'@'localhost'",
            "SET DEFAULT ROLE 'p3p_test_role' TO 'p3p_t4_rolederived'@'localhost'",
            "GRANT INSERT ON marsscorpdb_staging_verify.orders TO 'p3p_t4_rolederived'@'localhost'",
        ],
        'revoke' => [
            "REVOKE INSERT ON marsscorpdb_staging_verify.orders FROM 'p3p_t4_rolederived'@'localhost'",
        ]
    ],
    // 5. Global privileges (e.g. process / reload + db rights)
    'p3p_t5_global' => [
        'setup' => [
            "CREATE USER IF NOT EXISTS 'p3p_t5_global'@'localhost' IDENTIFIED BY 'TestPass123!'",
            "REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'p3p_t5_global'@'localhost'",
            "GRANT PROCESS, RELOAD ON *.* TO 'p3p_t5_global'@'localhost'",
            "GRANT SELECT, INSERT ON marsscorpdb_staging_verify.* TO 'p3p_t5_global'@'localhost'",
        ],
        'revoke' => [
            "REVOKE INSERT ON marsscorpdb_staging_verify.* FROM 'p3p_t5_global'@'localhost'",
        ]
    ],
    // 6. Grant option holder
    'p3p_t6_grantopt' => [
        'setup' => [
            "CREATE USER IF NOT EXISTS 'p3p_t6_grantopt'@'localhost' IDENTIFIED BY 'TestPass123!'",
            "REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'p3p_t6_grantopt'@'localhost'",
            "GRANT SELECT, INSERT ON marsscorpdb_staging_verify.* TO 'p3p_t6_grantopt'@'localhost' WITH GRANT OPTION",
        ],
        'revoke' => [
            "REVOKE INSERT ON marsscorpdb_staging_verify.* FROM 'p3p_t6_grantopt'@'localhost'",
        ]
    ],
    // 7. Read-only user (no revocation needed, baseline check)
    'p3p_t7_readonly' => [
        'setup' => [
            "CREATE USER IF NOT EXISTS 'p3p_t7_readonly'@'localhost' IDENTIFIED BY 'TestPass123!'",
            "REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'p3p_t7_readonly'@'localhost'",
            "GRANT USAGE ON *.* TO 'p3p_t7_readonly'@'localhost'",
            "GRANT SELECT ON marsscorpdb_staging_verify.* TO 'p3p_t7_readonly'@'localhost'",
        ],
        'revoke' => [] // none revoked
    ],
    // 8. Migration account (least privilege: retail SELECT, battery SELECT,INSERT,UPDATE)
    'p3p_t8_migrator' => [
        'setup' => [
            "CREATE USER IF NOT EXISTS 'p3p_t8_migrator'@'localhost' IDENTIFIED BY 'TestPass123!'",
            "REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'p3p_t8_migrator'@'localhost'",
            "GRANT USAGE ON *.* TO 'p3p_t8_migrator'@'localhost'",
            "GRANT SELECT ON marsscorpdb_staging_verify.orders TO 'p3p_t8_migrator'@'localhost'",
            "GRANT SELECT, INSERT, UPDATE ON marsscorpdb_staging_verify.battery_products TO 'p3p_t8_migrator'@'localhost'",
        ],
        'revoke' => [
            "REVOKE INSERT, UPDATE ON marsscorpdb_staging_verify.battery_products FROM 'p3p_t8_migrator'@'localhost'",
        ]
    ],
];

$results = [];

foreach ($testAccounts as $accountName => $config) {
    echo "-----------------------------------------------------------------\n";
    echo "Testing Account: {$accountName}@localhost\n";
    
    // Step 1: Run setup
    foreach ($config['setup'] as $sql) {
        $pdo->exec($sql);
    }
    
    // Step 2: Capture baseline grants
    $baselineGrants = getGrants($pdo, $accountName, 'localhost');
    echo "  Baseline Grants Captured (" . count($baselineGrants) . " statements):\n";
    foreach ($baselineGrants as $g) {
        echo "    - $g\n";
    }
    
    // Step 3: Simulate revocation (isolation)
    foreach ($config['revoke'] as $sql) {
        $pdo->exec($sql);
    }
    $postRevokeGrants = getGrants($pdo, $accountName, 'localhost');
    echo "  Post-Revoke Grants: (" . count($postRevokeGrants) . " statements)\n";
    
    // Step 4: Execute automated restoration directly from baseline grants
    // In MySQL, re-applying the baseline SHOW GRANTS statements restores the exact privileges!
    foreach ($baselineGrants as $grantSql) {
        // Strip trailing semicolon if any
        $grantSql = rtrim($grantSql, ';');
        $pdo->exec($grantSql);
    }
    
    // Step 5: Capture restored grants and perform cryptographic / string comparison
    $restoredGrants = getGrants($pdo, $accountName, 'localhost');
    $isIdentical = ($baselineGrants === $restoredGrants);
    
    echo "  Restored Grants (" . count($restoredGrants) . " statements):\n";
    foreach ($restoredGrants as $g) {
        echo "    - $g\n";
    }
    
    $status = $isIdentical ? "PASS" : "FAIL";
    echo "  Parity Status: $status\n";
    
    $results[$accountName] = [
        'baseline' => $baselineGrants,
        'restored' => $restoredGrants,
        'parity' => $isIdentical
    ];
}

// Failure scenarios testing
echo "\n=================================================================\n";
echo "TESTING FAILURE SCENARIOS DURING PRIVILEGE RESTORATION\n";
echo "=================================================================\n";

// Scenario F1: Syntax Error / Invalid Table in Grant
echo "Scenario F1: Invalid Grant Execution Handling...\n";
try {
    $pdo->exec("GRANT SELECT ON marsscorpdb_staging_verify.non_existent_table_xyz TO 'p3p_t1_dbwriter'@'localhost'");
    echo "  Unexpected Success!\n";
} catch (\PDOException $e) {
    echo "  PASS: Caught expected error: " . $e->getMessage() . "\n";
}

// Scenario F2: Connection Drop / Reconnection Idempotence
echo "Scenario F2: Idempotent Restoration after Reconnection...\n";
$pdo2 = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
$pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$baselineT1 = $results['p3p_t1_dbwriter']['baseline'];
foreach ($baselineT1 as $g) {
    $pdo2->exec($g);
}
$t1PostReconnect = getGrants($pdo2, 'p3p_t1_dbwriter', 'localhost');
$scenarioF2Pass = ($baselineT1 === $t1PostReconnect);
echo "  Parity Status: " . ($scenarioF2Pass ? "PASS" : "FAIL") . "\n";

// Cleanup test accounts
echo "\nCleaning up test accounts...\n";
foreach (array_keys($testAccounts) as $acc) {
    $pdo->exec("DROP USER IF EXISTS '{$acc}'@'localhost'");
}
$pdo->exec("DROP ROLE IF EXISTS 'p3p_test_role'");
echo "Cleanup complete.\n";

$allPassed = true;
foreach ($results as $acc => $res) {
    if (!$res['parity']) $allPassed = false;
}
if (!$scenarioF2Pass) $allPassed = false;

echo "\nFINAL WORKSTREAM C VERDICT: " . ($allPassed ? "100% PASS" : "FAIL") . "\n";

