$php = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe"
$script = "$PSScriptRoot\bg_table_locker.php"
$sig = "$PSScriptRoot\release_lock.signal"
if (Test-Path $sig) { Remove-Item $sig -Force }

Write-Host "Starting background lock process..."
$proc = Start-Process -FilePath $php -ArgumentList "`"$script`"" -PassThru -NoNewWindow
Start-Sleep -Seconds 2

Write-Host "Verifying lock behavior from second connection..."
$testScript = @'
<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=marsscorpdb_staging_verify', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$pdo->exec("SET SESSION lock_wait_timeout = 2");

// Test 1: Writing to retail table 'orders' should FAIL (blocked by MDL error 1205)
try {
    $pdo->exec("INSERT INTO orders (order_no, sub_total) VALUES ('TEST-LOCK-999', 100)");
    echo "FAIL_RETAIL_WRITE_ALLOWED\n";
} catch (\PDOException $e) {
    if (strpos($e->getMessage(), '1205') !== false || strpos($e->getMessage(), 'Lock wait timeout') !== false) {
        echo "SUCCESS_RETAIL_WRITE_BLOCKED: Lock wait timeout exceeded (MDL Error 1205)\n";
    } else {
        echo "UNEXPECTED_ERROR: " . $e->getMessage() . "\n";
    }
}

// Test 2: Writing to battery table 'battery_units' should SUCCEED
try {
    $pdo->exec("INSERT INTO battery_units (unit_name, user_id) VALUES ('Test Unit Lock', 1)");
    $id = $pdo->lastInsertId();
    $pdo->exec("DELETE FROM battery_units WHERE id = {$id}");
    echo "SUCCESS_BATTERY_WRITE_ALLOWED\n";
} catch (\PDOException $e) {
    echo "FAIL_BATTERY_WRITE_BLOCKED: " . $e->getMessage() . "\n";
}

// Test 3: Reading from retail table 'products' should SUCCEED
try {
    $cnt = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    echo "SUCCESS_RETAIL_READ_ALLOWED: count={$cnt}\n";
} catch (\PDOException $e) {
    echo "FAIL_RETAIL_READ_BLOCKED: " . $e->getMessage() . "\n";
}
'@
$testFile = "$PSScriptRoot\temp_test_lock.php"
$testScript | Out-File -FilePath $testFile -Encoding utf8
& $php $testFile
Remove-Item $testFile -Force

Write-Host "Signalling background locker to release..."
New-Item -ItemType File -Path $sig -Force | Out-Null
$proc.WaitForExit(5000)
Write-Host "Locker exited with code: $($proc.ExitCode)"
