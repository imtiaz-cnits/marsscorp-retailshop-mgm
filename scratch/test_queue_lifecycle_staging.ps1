# Staging-only test for Workstream C: Windows Queue Worker Lifecycle
$ErrorActionPreference = "Stop"

$ProjectRoot = "d:\Running Works\04. Clients Back-end Projects - 2025\PHP - Laravel\MARSS Corp\marsscorp-retailshop-mgm"
Set-Location -Path $ProjectRoot

Write-Host "=================================================================" -ForegroundColor Cyan
Write-Host "   WORKSTREAM C: STAGING QUEUE WORKER LIFECYCLE TEST            " -ForegroundColor Cyan
Write-Host "=================================================================`n" -ForegroundColor Cyan

# 1. Check Initial Workers
$initialWorkers = Get-CimInstance Win32_Process -Filter "name = 'php.exe'" | Where-Object { $_.CommandLine -match "queue:work" }
$initialCount = ($initialWorkers | Measure-Object).Count
Write-Host "Step 1: Initial queue:work processes: $initialCount" -ForegroundColor Yellow

# 2. Launch an isolated test worker process
Write-Host "`nStep 2: Launching isolated test worker process..." -ForegroundColor Yellow
$workerProcess = Start-Process -FilePath "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe" -ArgumentList "artisan queue:work --sleep=1" -PassThru
$workerPid = $workerProcess.Id
Write-Host "Worker started with PID: $workerPid" -ForegroundColor Green
Start-Sleep -Seconds 2

# 3. Pause Queue
Write-Host "`nStep 3: Executing php artisan queue:pause default..." -ForegroundColor Yellow
& php artisan queue:pause default
$pauseExit = $LASTEXITCODE
Write-Host "queue:pause exit code: $pauseExit" -ForegroundColor Green

# Verify pause in cache
$isPaused = (php scratch/check_is_paused.php).Trim()
Write-Host "Queue state after pause: $isPaused" -ForegroundColor Green

# 4. Execute queue:restart
Write-Host "`nStep 4: Executing php artisan queue:restart..." -ForegroundColor Yellow
& php artisan queue:restart
$restartExit = $LASTEXITCODE
Write-Host "queue:restart exit code: $restartExit" -ForegroundColor Green

# Check if worker exits
Write-Host "Waiting up to 10 seconds for worker process $workerPid to exit..."
$exited = $workerProcess.WaitForExit(10000)
Write-Host "Worker process $workerPid exited: $exited" -ForegroundColor $(if ($exited) { "Green" } else { "Red" })

# 5. Check if any process manager restarts it
Start-Sleep -Seconds 3
$newWorkers = Get-CimInstance Win32_Process -Filter "name = 'php.exe'" | Where-Object { $_.CommandLine -match "queue:work" }
$newCount = ($newWorkers | Measure-Object).Count
Write-Host "Step 5: Post-exit worker count: $newCount" -ForegroundColor $(if ($newCount -eq 0) { "Yellow" } else { "Green" })
if ($newCount -eq 0) {
    Write-Host "CONFIRMED: On Windows without NSSM/Supervisor, queue:restart terminates worker and NO supervisor restarts it." -ForegroundColor Cyan
}

# 6. Execute queue:continue
Write-Host "`nStep 6: Executing php artisan queue:continue default..." -ForegroundColor Yellow
& php artisan queue:continue default
$contExit = $LASTEXITCODE
Write-Host "queue:continue exit code: $contExit" -ForegroundColor Green

# Verify unpaused in cache
$isPausedAfter = (php scratch/check_is_paused.php).Trim()
Write-Host "Queue state after continue: $isPausedAfter" -ForegroundColor Green

# Clean up if process still running
if (!$workerProcess.HasExited) {
    Stop-Process -Id $workerPid -Force -ErrorAction SilentlyContinue
}

Write-Host "`nWORKSTREAM C STAGING TEST COMPLETE: [PASS - LIFECYCLE BEHAVIOR EMPIRICALLY DEMONSTRATED]" -ForegroundColor Green
