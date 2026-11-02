$MysqlCli = "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe"
$BackupFile = "d:\Running Works\04. Clients Back-end Projects - 2025\PHP - Laravel\MARSS Corp\marsscorp-retailshop-mgm\storage\app\backups\marsscorpdb_pre_migration_backup_20261103.sql"
$TestDb = "marss_test_space_check"

# Create DB
$createSql = "DROP DATABASE IF EXISTS ``{0}``; CREATE DATABASE ``{0}`` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" -f $TestDb
& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --execute=$createSql

# Test 1: source without quotes
$forwardPath = $BackupFile.Replace('\', '/')
$sourceNoQuotes = "source $forwardPath"
Write-Host "Testing source WITHOUT quotes: $sourceNoQuotes"
& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --database=$TestDb --execute=$sourceNoQuotes
Write-Host "Exit code without quotes: $LASTEXITCODE"
$tblCount1 = (& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --skip-column-names --execute="SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$TestDb';").Trim()
Write-Host "Tables restored without quotes: $tblCount1"

# Cleanup
$dropSql = "DROP DATABASE IF EXISTS ``{0}``;" -f $TestDb
& $MysqlCli --host=127.0.0.1 --port=3306 --user=root --execute=$dropSql

