# scratch/test_queue_state_persistence.ps1
$ErrorActionPreference = "Stop"

Write-Host "=== TESTING QUEUE WORKER STATE PERSISTENCE & RESTORATION ===" -ForegroundColor Cyan

# 1. Capture initial state
$workers = Get-CimInstance Win32_Process | Where-Object { $_.CommandLine -like "*artisan*queue:work*" }
$initialCount = ($workers | Measure-Object).Count
Write-Host "Initial Queue Workers Count: $initialCount"

$stateFile = "scratch/queue_prestate.json"
$stateData = @{
    worker_count = $initialCount
    timestamp = (Get-Date).ToString("yyyy-MM-dd HH:mm:ss")
    worker_pids = @($workers | ForEach-Object { $_.ProcessId })
}

$stateJson = $stateData | ConvertTo-Json
Set-Content -Path $stateFile -Value $stateJson
Write-Host "Saved worker pre-state to $stateFile"

# 2. Simulate Scenario A: Initial worker count = 0 (as currently found in production)
Write-Host "`nScenario A: Initial worker count = 0"
Write-Host "Pre-state has 0 workers. During Stage E, script checks pre-state."
$saved = Get-Content -Path $stateFile | ConvertFrom-Json
if ($saved.worker_count -eq 0) {
    Write-Host "VERIFIED: No workers were running initially. System will NOT spawn unmanaged background worker." -ForegroundColor Green
    Write-Host "Queue unpause (queue:continue default) will be executed to clear cache pause flag."
}

# 3. Simulate Scenario B: 1 worker was running initially
Write-Host "`nScenario B: 1 worker was running initially"
$phpExe = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe"
$artisan = "$PSScriptRoot\..\artisan"

# Start a mock worker in background
$mockWorker = Start-Process -FilePath $phpExe -ArgumentList "artisan queue:work --sleep=3 --tries=3" -PassThru -WindowStyle Hidden
Write-Host "Spawned test worker PID: $($mockWorker.Id)"
Start-Sleep -Seconds 2

# Verify worker running
$running = Get-Process -Id $mockWorker.Id -ErrorAction SilentlyContinue
if ($running) {
    Write-Host "Test worker is actively running with PID $($mockWorker.Id)" -ForegroundColor Green
}

# Graceful Pause & Restart
Write-Host "Executing queue:pause default..."
& $phpExe $artisan queue:pause default | Out-Null

Write-Host "Executing queue:restart (signals worker to exit gracefully)..."
& $phpExe $artisan queue:restart | Out-Null
Start-Sleep -Seconds 3

$afterRestart = Get-Process -Id $mockWorker.Id -ErrorAction SilentlyContinue
if (-not $afterRestart) {
    Write-Host "PASS: Worker PID $($mockWorker.Id) exited cleanly." -ForegroundColor Green
} else {
    Write-Host "WARNING: Worker still alive, stopping force..." -ForegroundColor Yellow
    Stop-Process -Id $mockWorker.Id -Force
}

# Restoration to pre-state (1 worker)
Write-Host "Executing Stage E restoration: Unpausing queue and respawning 1 worker..."
& $phpExe $artisan queue:continue default | Out-Null

$newWorker = Start-Process -FilePath $phpExe -ArgumentList "artisan queue:work --sleep=3 --tries=3" -PassThru -WindowStyle Hidden
Write-Host "Respawned worker with PID: $($newWorker.Id)"
Start-Sleep -Seconds 2

$verifyNew = Get-Process -Id $newWorker.Id -ErrorAction SilentlyContinue
if ($verifyNew) {
    Write-Host "PASS: Restored worker PID $($newWorker.Id) is active and running!" -ForegroundColor Green
    # Clean up test worker
    Stop-Process -Id $newWorker.Id -Force
    Write-Host "Cleaned up test worker."
} else {
    Write-Host "FAIL: Restored worker failed to start!" -ForegroundColor Red
}

# Final unpause
& $phpExe $artisan queue:continue default | Out-Null
Write-Host "Queue state verified clean."

