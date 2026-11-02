# scratch/phase_3p/run_staging_migration_as_migrator.ps1
$ErrorActionPreference = "Stop"

Write-Host "=== EXECUTING ARTISAN MIGRATION AS LEAST-PRIVILEGE 'p3p_migrator' ===" -ForegroundColor Cyan
Write-Host "Target Database: marsscorpdb_staging_verify"
Write-Host "Target User: p3p_migrator (WITHOUT LOCK TABLES, ZERO RETAIL WRITES)`n"

$env:DB_DATABASE = "marsscorpdb_staging_verify"
$env:DB_USERNAME = "p3p_migrator"
$env:DB_PASSWORD = "P3pMigratorPass2026!"

$phpExe = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe"
$artisan = "$PSScriptRoot\..\..\artisan"

# First verify who Laravel connects as
$userCheck = & $phpExe "$PSScriptRoot\verify_active_migrator.php"
Write-Host $userCheck

if (-not ($userCheck -match "p3p_migrator@localhost")) {
    Write-Host "CRITICAL ERROR: Laravel did not connect as p3p_migrator!" -ForegroundColor Red
    exit 1
}

# Now execute the actual migration command
Write-Host "Executing: php artisan battery:migrate-from-retail --force ..."
$output = & $phpExe $artisan battery:migrate-from-retail --force 2>&1
$output | Out-File -FilePath "$PSScriptRoot\staging_migration_migrator.log" -Encoding utf8
$output | ForEach-Object { Write-Host $_ }

$exitCode = $LASTEXITCODE
$exitFg = if ($exitCode -eq 0) { "Green" } else { "Red" }
Write-Host "`nMigration Process Exit Code: $exitCode" -ForegroundColor $exitFg

if ($exitCode -eq 0) {
    Write-Host "PASS: Full migration executed successfully using least-privilege 'p3p_migrator' without LOCK TABLES!" -ForegroundColor Green
} else {
    Write-Host "FAIL: Migration failed under p3p_migrator!" -ForegroundColor Red
    exit 1
}
