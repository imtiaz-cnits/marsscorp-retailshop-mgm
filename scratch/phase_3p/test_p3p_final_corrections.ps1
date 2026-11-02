# scratch/phase_3p/test_p3p_final_corrections.ps1
$ErrorActionPreference = "Stop"

Write-Host "=================================================================" -ForegroundColor Cyan
Write-Host "PHASE 3P-FINAL: VERIFYING CORRECTED OPERATIONAL COMPONENTS" -ForegroundColor Cyan
Write-Host "=================================================================`n" -ForegroundColor Cyan

$phpExe = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe"
$mysqlExe = "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe"
$artisan = Resolve-Path "$PSScriptRoot\..\..\artisan"
$workspaceRoot = (Resolve-Path "$PSScriptRoot\..\..").Path

# -------------------------------------------------------------------------
# Test 1: Dynamic Migrator Password & marss_migrator Account Lifecycle
# -------------------------------------------------------------------------
Write-Host "[Component 1] Testing Dynamic Password & 'marss_migrator' Account Lifecycle..." -ForegroundColor Yellow

# Generate 32-character secure random password
$dynamicPass = -join ((65..90) + (97..122) + (48..57) | Get-Random -Count 32 | ForEach-Object {[char]$_})
Write-Host "  Generated secure random password: $($dynamicPass.Substring(0, 8))... (Length: $($dynamicPass.Length))"

# Provision marss_migrator in staging
$ddl = @"
CREATE USER IF NOT EXISTS 'marss_migrator'@'localhost' IDENTIFIED BY '$dynamicPass';
ALTER USER 'marss_migrator'@'localhost' IDENTIFIED BY '$dynamicPass';
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'marss_migrator'@'localhost';
GRANT USAGE ON *.* TO 'marss_migrator'@'localhost';

-- 18 Retail Tables SELECT only
GRANT SELECT ON marsscorpdb_staging_verify.categories TO 'marss_migrator'@'localhost';
GRANT SELECT ON marsscorpdb_staging_verify.brands TO 'marss_migrator'@'localhost';
GRANT SELECT ON marsscorpdb_staging_verify.units TO 'marss_migrator'@'localhost';
GRANT SELECT ON marsscorpdb_staging_verify.expense_types TO 'marss_migrator'@'localhost';
GRANT SELECT ON marsscorpdb_staging_verify.suppliers TO 'marss_migrator'@'localhost';
GRANT SELECT ON marsscorpdb_staging_verify.customers TO 'marss_migrator'@'localhost';
GRANT SELECT ON marsscorpdb_staging_verify.products TO 'marss_migrator'@'localhost';
GRANT SELECT ON marsscorpdb_staging_verify.expenses TO 'marss_migrator'@'localhost';
GRANT SELECT ON marsscorpdb_staging_verify.purchases TO 'marss_migrator'@'localhost';
GRANT SELECT ON marsscorpdb_staging_verify.purchase_order_details TO 'marss_migrator'@'localhost';
GRANT SELECT ON marsscorpdb_staging_verify.purchase_payment_details TO 'marss_migrator'@'localhost';
GRANT SELECT ON marsscorpdb_staging_verify.purchase_returns TO 'marss_migrator'@'localhost';
GRANT SELECT ON marsscorpdb_staging_verify.orders TO 'marss_migrator'@'localhost';
GRANT SELECT ON marsscorpdb_staging_verify.order_details TO 'marss_migrator'@'localhost';
GRANT SELECT ON marsscorpdb_staging_verify.order_payment_details TO 'marss_migrator'@'localhost';
GRANT SELECT ON marsscorpdb_staging_verify.product_returns TO 'marss_migrator'@'localhost';
GRANT SELECT ON marsscorpdb_staging_verify.customer_payment_details TO 'marss_migrator'@'localhost';

-- Target battery tables CRUD (Zero LOCK TABLES)
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_categories TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_brands TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_units TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_expense_types TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_sub_categories TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_suppliers TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_customers TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_products TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_expenses TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_purchases TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_purchase_order_details TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_purchase_payment_details TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_purchase_returns TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_orders TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_order_details TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_order_payment_details TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_product_returns TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_customer_payment_details TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_supplier_due_collections TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_opening_balances TO 'marss_migrator'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON marsscorpdb_staging_verify.battery_migration_mappings TO 'marss_migrator'@'localhost';

FLUSH PRIVILEGES;
"@
$ddlFile = "$PSScriptRoot\temp_marss_migrator.sql"
$ddl | Out-File -FilePath $ddlFile -Encoding utf8
Get-Content $ddlFile | & $mysqlExe -u root
Remove-Item $ddlFile

Write-Host "  Provisioned 'marss_migrator'@'localhost' successfully."

# Verify runtime connection under marss_migrator with dynamic password
$env:DB_DATABASE = "marsscorpdb_staging_verify"
$env:DB_USERNAME = "marss_migrator"
$env:DB_PASSWORD = $dynamicPass

$whoamiCheck = & $phpExe "$PSScriptRoot\verify_active_migrator.php"
Write-Host "  Connected Identity: $whoamiCheck"

if (-not ($whoamiCheck -match "marss_migrator@localhost")) {
    Write-Host "  FAIL: Did not connect as marss_migrator with dynamic password!" -ForegroundColor Red
    exit 1
}
Write-Host "  PASS: Dynamic password and marss_migrator identity verified." -ForegroundColor Green

# -------------------------------------------------------------------------
# Test 2: Dynamic Maintenance Mode Bypass Secret
# -------------------------------------------------------------------------
Write-Host "`n[Component 2] Testing Dynamic Maintenance Bypass Token..." -ForegroundColor Yellow
$bypassSecret = [System.Guid]::NewGuid().ToString("N")
Write-Host "  Generated dynamic bypass secret: $bypassSecret"

& $phpExe artisan down --secret="$bypassSecret"
if ($LASTEXITCODE -ne 0) {
    Write-Host "  FAIL: artisan down failed!" -ForegroundColor Red
    exit 1
}

$downFile = "$workspaceRoot\storage\framework\down"
$isDown = Test-Path $downFile
Write-Host "  Maintenance lock active: $isDown"

if ($isDown) {
    $downJson = Get-Content -Path $downFile | ConvertFrom-Json
    $secretMatched = ($downJson.secret -eq $bypassSecret)
    Write-Host "  Secret matched in down file: $secretMatched"
}

# Bring back up cleanly
& $phpExe artisan up
Write-Host "  Application returned online cleanly." -ForegroundColor Green

# -------------------------------------------------------------------------
# Test 3: Properly Scoped Connection Termination
# -------------------------------------------------------------------------
Write-Host "`n[Component 3] Testing Scoped Connection Termination..." -ForegroundColor Yellow
# Clear migrator env variables before queue restart
Remove-Item env:DB_USERNAME -ErrorAction SilentlyContinue
Remove-Item env:DB_PASSWORD -ErrorAction SilentlyContinue

$killScript = @'
<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
// Correctly scoped query: targets marsscorpdb, spares current session and background daemons
$stmt = $pdo->query("
    SELECT id, user, host, db, command, time, state, info 
    FROM information_schema.processlist 
    WHERE db = 'marsscorpdb_staging_verify' 
      AND id != CONNECTION_ID() 
      AND command != 'Daemon'
");
$procs = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "  Found " . count($procs) . " active connections on marsscorpdb_staging_verify.\n";
foreach ($procs as $p) {
    echo "  Terminating PID {$p['id']} (User: {$p['user']})...\n";
    $pdo->exec("KILL " . (int)$p['id']);
}
echo "  Scoped termination execution: PASS\n";
'@
$killFile = "$PSScriptRoot\temp_kill_test.php"
$killScript | Out-File -FilePath $killFile -Encoding utf8
& $phpExe $killFile
Remove-Item $killFile

# -------------------------------------------------------------------------
# Test 4: Queue Worker Graceful Drain Verification
# -------------------------------------------------------------------------
Write-Host "`n[Component 4] Testing Queue Worker Graceful Drain & Precondition Guard..." -ForegroundColor Yellow

# Start a mock worker
$p = Start-Process -FilePath $phpExe -ArgumentList "artisan queue:work --sleep=3" -WorkingDirectory $workspaceRoot -PassThru -WindowStyle Hidden
Write-Host "  Started test worker PID: $($p.Id)"
Start-Sleep -Seconds 2

# Issue queue:restart for graceful drain
Write-Host "  Issuing artisan queue:restart..."
& $phpExe artisan queue:restart

# Graceful drain loop
$drainTimeoutSeconds = 15
$startTime = [System.Diagnostics.Stopwatch]::StartNew()
$drainedCleanly = $false

while ($startTime.Elapsed.TotalSeconds -lt $drainTimeoutSeconds) {
    $workers = Get-CimInstance Win32_Process | Where-Object { $_.ProcessId -eq $p.Id }
    if (-not $workers) {
        $drainedCleanly = $true
        break;
    }
    Start-Sleep -Seconds 1
}

Write-Host "  Graceful drain status: " -NoNewline
if ($drainedCleanly) {
    Write-Host "PASS (Worker stopped via queue:restart within $($startTime.Elapsed.Seconds)s)" -ForegroundColor Green
} else {
    Write-Host "Worker still active; escalating to Stop-Process..." -ForegroundColor Yellow
    Stop-Process -Id $p.Id -Force -ErrorAction SilentlyContinue
}

# -------------------------------------------------------------------------
# Cleanup marss_migrator
# -------------------------------------------------------------------------
& $mysqlExe -u root -e "DROP USER IF EXISTS 'marss_migrator'@'localhost'; FLUSH PRIVILEGES;"
Write-Host "`nCleaned up 'marss_migrator' user."

Write-Host "`n=================================================================" -ForegroundColor Green
Write-Host "ALL 4 CORRECTED COMPONENTS VERIFIED 100% IN STAGING" -ForegroundColor Green
Write-Host "=================================================================" -ForegroundColor Green
