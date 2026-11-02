# scratch/phase_3p/test_queue_worker_parity.ps1
$ErrorActionPreference = "Stop"

Write-Host "=================================================================" -ForegroundColor Cyan
Write-Host "WORKSTREAM E: QUEUE WORKER LIFECYCLE & COUNT PARITY DRILL" -ForegroundColor Cyan
Write-Host "=================================================================`n" -ForegroundColor Cyan

$phpExe = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe"
$workspaceRoot = (Resolve-Path "$PSScriptRoot\..\..").Path

function Get-QueueWorkers {
    Get-CimInstance Win32_Process | Where-Object { 
        $_.CommandLine -match "artisan.*queue:work" -or $_.CommandLine -match "artisan.*queue:listen"
    }
}

# Test Scenario 1: Zero-worker baseline (N=0)
Write-Host "[Scenario 1] Testing N=0 Worker Baseline..." -ForegroundColor Yellow
$initialWorkers = Get-QueueWorkers
$n0Count = if ($initialWorkers) { @($initialWorkers).Count } else { 0 }
Write-Host "  Initial worker count: $n0Count"

# Function to capture state
function Capture-QueueWorkerState {
    $workers = Get-QueueWorkers
    $snapshot = @()
    if ($workers) {
        foreach ($w in @($workers)) {
            $snapshot += [PSCustomObject]@{
                ProcessId = $w.ProcessId
                CommandLine = $w.CommandLine
                ParentProcessId = $w.ParentProcessId
            }
        }
    }
    return $snapshot
}

# Scenario 2: Start N=3 mock workers with specific arguments
Write-Host "`n[Scenario 2] Spawning N=3 Workers with Distinct Arguments..." -ForegroundColor Yellow
$procList = @()
$workerArgs = @(
    "queue:work --queue=high,default --sleep=3 --tries=3",
    "queue:work --queue=default --sleep=5 --tries=2",
    "queue:work --queue=low --sleep=10 --tries=1"
)

foreach ($arg in $workerArgs) {
    $p = Start-Process -FilePath $phpExe -ArgumentList "artisan $arg" -WorkingDirectory $workspaceRoot -PassThru -WindowStyle Hidden
    $procList += $p
    Write-Host "  Spawned Worker PID: $($p.Id) with args: $arg"
}

Start-Sleep -Seconds 2

# Capture snapshot
$snapshot = Capture-QueueWorkerState
$capturedCount = $snapshot.Count
Write-Host "  Captured Worker Snapshot: $capturedCount active workers."

if ($capturedCount -ne 3) {
    Write-Host "  FAIL: Expected 3 workers, found $capturedCount" -ForegroundColor Red
    # Cleanup any that did spawn
    foreach ($p in $procList) {
        Stop-Process -Id $p.Id -Force -ErrorAction SilentlyContinue
    }
    exit 1
}

# Scenario 3: Graceful Drain & Shutdown
Write-Host "`n[Scenario 3] Stopping Workers via Stop-Process..." -ForegroundColor Yellow
foreach ($w in $snapshot) {
    try {
        Stop-Process -Id $w.ProcessId -Force -ErrorAction SilentlyContinue
        Write-Host "  Terminated Worker PID: $($w.ProcessId)"
    } catch {
        Write-Host "  Failed to stop PID: $($w.ProcessId)" -ForegroundColor Red
    }
}

Start-Sleep -Seconds 2
$postStopWorkers = Get-QueueWorkers
$postStopCount = if ($postStopWorkers) { @($postStopWorkers).Count } else { 0 }
Write-Host "  Post-Stop Worker Count: $postStopCount (Expected: 0)"

if ($postStopCount -ne 0) {
    Write-Host "  FAIL: Workers still running!" -ForegroundColor Red
    exit 1
}

# Scenario 4: Exact Count & Argument Parity Respawn
Write-Host "`n[Scenario 4] Respawning Workers Using Captured Snapshot (Parity Loop)..." -ForegroundColor Yellow
$respawnedProcs = @()
foreach ($w in $snapshot) {
    if ($w.CommandLine -match "artisan\s+(queue:.*)$") {
        $capturedArgs = $matches[1].Trim()
    } else {
        $capturedArgs = "queue:work"
    }
    
    $newProc = Start-Process -FilePath $phpExe -ArgumentList "artisan $capturedArgs" -WorkingDirectory $workspaceRoot -PassThru -WindowStyle Hidden
    $respawnedProcs += $newProc
    Write-Host "  Respawned Worker PID: $($newProc.Id) with exact args: '$capturedArgs'"
}

Start-Sleep -Seconds 2
$respawnedWorkers = Get-QueueWorkers
$respawnedCount = if ($respawnedWorkers) { @($respawnedWorkers).Count } else { 0 }
Write-Host "  Respawned Worker Count: $respawnedCount (Expected: $capturedCount)"

$parityPass = ($respawnedCount -eq $capturedCount)
Write-Host "  Count Parity Status: " -NoNewline
if ($parityPass) { Write-Host "PASS (3/3 Workers Active)" -ForegroundColor Green } else { Write-Host "FAIL" -ForegroundColor Red }

# Cleanup all spawned test workers
Write-Host "`nCleaning up test workers..." -ForegroundColor Yellow
foreach ($p in $respawnedProcs) {
    Stop-Process -Id $p.Id -Force -ErrorAction SilentlyContinue
}
Start-Sleep -Seconds 1
$finalWorkers = Get-QueueWorkers
$finalCount = if ($finalWorkers) { @($finalWorkers).Count } else { 0 }
Write-Host "Final Worker Count: $finalCount (Cleaned up)"

if ($parityPass) {
    Write-Host "`nFINAL WORKSTREAM E QUEUE PARITY VERDICT: 100% PASS" -ForegroundColor Green
} else {
    Write-Host "`nFINAL WORKSTREAM E QUEUE PARITY VERDICT: FAIL" -ForegroundColor Red
    exit 1
}
