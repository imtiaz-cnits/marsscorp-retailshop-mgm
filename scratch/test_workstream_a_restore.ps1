# Test script for Workstream A: Restore Path with Spaces and Error Handling
$ErrorActionPreference = "Stop"

$ProjectRoot = "d:\Running Works\04. Clients Back-end Projects - 2025\PHP - Laravel\MARSS Corp\marsscorp-retailshop-mgm"
$MysqlCli    = "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe"
$BackupFile  = "$ProjectRoot\storage\app\backups\marsscorpdb_pre_migration_backup_20261103.sql"

# Generate unique disposable staging database
$TestUid   = [System.Guid]::NewGuid().ToString("N").Substring(0, 8)
$TestDb    = "marss_test_k_$TestUid"
$TestDbErr = "marss_test_k_err_$TestUid"

Write-Host ">>> Unique Disposable Test DB: $TestDb" -ForegroundColor Cyan
Write-Host ">>> Backup file full path (contains spaces): $BackupFile" -ForegroundColor Cyan

# 1. Test Option Verification
Write-Host "`n--- 1. Testing --abort-source-on-error option on MySQL 8.4.3 ---" -ForegroundColor Yellow
$proc = Start-Process -FilePath $MysqlCli -ArgumentList "--abort-source-on-error" -NoNewWindow -Wait -PassThru -RedirectStandardError "scratch/test_opt_err.txt"
$optExit = $proc.ExitCode
$optErrText = Get-Content "scratch/test_opt_err.txt" -Raw
Write-Host "Exit Code: $optExit | Output: $optErrText" -ForegroundColor $(if ($optExit -ne 0) { "Red" } else { "Green" })

# 2. Test Path with Spaces using Native source in MySQL CLI
Write-Host "`n--- 2. Testing MySQL CLI 'source' with spaces in path ---" -ForegroundColor Yellow
# Create database
$createSql = "DROP DATABASE IF EXISTS ``{0}``; CREATE DATABASE ``{0}`` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" -f $TestDb
& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --execute=$createSql

# Path formatted with forward slashes
$forwardPath = $BackupFile.Replace('\', '/')
# In MySQL CLI, source command with quotes around path:
$sourceCmdWithQuotes = 'source "{0}"' -f $forwardPath
Write-Host "Testing source command with quotes: $sourceCmdWithQuotes"
& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --database=$TestDb --execute=$sourceCmdWithQuotes
$exitWithQuotes = $LASTEXITCODE
Write-Host "Exit code with quotes: $exitWithQuotes"

# Check table count
$tblCount = (& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --skip-column-names --execute="SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$TestDb';").Trim()
Write-Host "Tables restored into $TestDb - $tblCount / 55"

# Clean up TestDb
$dropSql = "DROP DATABASE IF EXISTS ``{0}``;" -f $TestDb
& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --execute=$dropSql
Write-Host "Cleaned up disposable DB: $TestDb"

# 3. Test CMD Byte Redirection with spaces in path
Write-Host "`n--- 3. Testing CMD Byte Redirection with spaces in path ---" -ForegroundColor Yellow
& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --execute=$createSql
$cmdExec = '"{0}" --host=127.0.0.1 --port=3306 --user=root {1} < "{2}"' -f $MysqlCli, $TestDb, $BackupFile
Write-Host "Executing CMD: $cmdExec"
cmd.exe /c $cmdExec
$exitCmd = $LASTEXITCODE
Write-Host "Exit code from CMD: $exitCmd"
$tblCountCmd = (& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --skip-column-names --execute="SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$TestDb';").Trim()
Write-Host "Tables restored via CMD into $TestDb - $tblCountCmd / 55"

# Clean up TestDb
& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --execute=$dropSql
Write-Host "Cleaned up disposable DB: $TestDb"

# 4. Test Error Handling on Corrupted SQL Dump
Write-Host "`n--- 4. Testing Error Handling on Corrupted SQL Dump ---" -ForegroundColor Yellow
$CorruptFile = "$ProjectRoot\scratch\corrupt_dump_test.sql"
"CREATE TABLE test_tbl_ok (id INT PRIMARY KEY);`nTHIS IS AN INTENTIONAL SYNTAX ERROR ILLEGAL SQL;`nCREATE TABLE test_tbl_fail (id INT PRIMARY KEY);" | Set-Content -Path $CorruptFile -Encoding UTF8

# Test 4a: MySQL CLI with source on corrupt file
Write-Host "4a: Testing 'source' on corrupt file..."
& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --execute=$createSql
$corruptForwardPath = $CorruptFile.Replace('\', '/')
$corruptSourceCmd = 'source "{0}"' -f $corruptForwardPath
& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --database=$TestDb --execute=$corruptSourceCmd
$exitSourceErr = $LASTEXITCODE
Write-Host "source on corrupt file exit code: $exitSourceErr"
$tablesAfterSourceErr = (& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --skip-column-names --execute="SELECT table_name FROM information_schema.tables WHERE table_schema = '$TestDb';")
Write-Host "Tables created during source error test: $tablesAfterSourceErr"

# Test 4b: CMD byte redirection on corrupt file
Write-Host "`n4b: Testing CMD byte redirection on corrupt file..."
& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --execute=$dropSql
& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --execute=$createSql
$cmdCorrupt = '"{0}" --host=127.0.0.1 --port=3306 --user=root {1} < "{2}"' -f $MysqlCli, $TestDb, $CorruptFile
cmd.exe /c $cmdCorrupt
$exitCmdErr = $LASTEXITCODE
Write-Host "CMD redirection on corrupt file exit code: $exitCmdErr"
$tablesAfterCmdErr = (& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --skip-column-names --execute="SELECT table_name FROM information_schema.tables WHERE table_schema = '$TestDb';")
Write-Host "Tables created during CMD error test: $tablesAfterCmdErr"

# Clean up
& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --execute=$dropSql
Remove-Item -Path $CorruptFile -Force
Write-Host "Cleaned up disposable DB: $TestDb and corrupt file."
