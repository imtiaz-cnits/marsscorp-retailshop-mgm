$ErrorActionPreference = "Stop"
$phpExe = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe"
$workspaceRoot = (Get-Location).Path
$artisan = "$workspaceRoot\artisan"

Write-Host "=== TEST: NON-ZERO BASELINE QUEUE WORKER LIFECYCLE DRILL ===" -ForegroundColor Cyan

# 1. Spawn a dedicated test worker on isolated staging queue
$testQueueName = "staging_audit_queue"
$testWorkerArgs = "`"$artisan`" queue:work --queue=$testQueueName --sleep=3 --tries=3"
Write-Host "Spawning test worker: $phpExe $testWorkerArgs"
$testWorkerProc = Start-Process -FilePath $phpExe -ArgumentList $testWorkerArgs -WorkingDirectory $workspaceRoot -WindowStyle Hidden -PassThru
Start-Sleep -Seconds 2

if ($testWorkerProc.HasExited) {
    throw "Failed to start initial test worker! Process exited immediately."
}
Write-Host "Test worker spawned successfully. PID: $($testWorkerProc.Id)" -ForegroundColor Green

# 2. Inspect running workers via CIM
function Get-ActiveQueueWorkers {
    Get-CimInstance Win32_Process | Where-Object { 
        $_.CommandLine -match "artisan.*queue:work" -or $_.CommandLine -match "artisan.*queue:listen"
    }
}

$initialWorkers = @(Get-ActiveQueueWorkers)
$initialCount = $initialWorkers.Count
Write-Host "Baseline Active Worker Count: $initialCount (Non-Zero Baseline: $(if ($initialCount -gt 0) {'PASS'} else {'FAIL'}))"

if ($initialCount -eq 0) {
    throw "Non-zero baseline requirement failed! Expected at least 1 running worker."
}

# 3. Capture high-fidelity metadata snapshot
$workerSnapshot = @()
foreach ($w in $initialWorkers) {
    $procObj = Get-Process -Id $w.ProcessId -ErrorAction SilentlyContinue
    $execPath = if ($procObj -and $procObj.Path) { $procObj.Path } else { $phpExe }
    
    # Robust argument extraction: find everything after the executable in CommandLine
    $cmdLine = $w.CommandLine
    $rawArgs = ""
    if ($cmdLine -match '^(?:"([^"]+)"|(\S+))\s+(.*)$') {
        $rawArgs = $Matches[3]
    } else {
        $rawArgs = $cmdLine -replace '.*php(\.exe)?\s+', ''
    }

    # Extract queue name and connection
    $qName = if ($rawArgs -match '--queue=([^\s]+)') { $Matches[1] } else { 'default' }
    $qConn = if ($rawArgs -match '--connection=([^\s]+)') { $Matches[1] } else { 'default' }

    $workerSnapshot += [PSCustomObject]@{
        ProcessId        = $w.ProcessId
        ExecutablePath   = $execPath
        Arguments        = $rawArgs
        QueueName        = $qName
        QueueConnection  = $qConn
        WorkingDirectory = $workspaceRoot
    }
    Write-Host "Captured Worker PID $($w.ProcessId): Executable=$execPath | Queue=$qName | Args=$rawArgs"
}

$snapshotPath = "$workspaceRoot\storage\app\queue_worker_snapshot.json"
$workerSnapshot | ConvertTo-Json -Depth 4 | Out-File -FilePath $snapshotPath -Encoding utf8
Write-Host "Persisted snapshot to: $snapshotPath" -ForegroundColor Green

# 4. Graceful Drain via artisan queue:restart
Write-Host "`nBroadcasting artisan queue:restart for graceful drain..."
& $phpExe $artisan queue:restart
$drainTimeout = 30
$sw = [System.Diagnostics.Stopwatch]::StartNew()
$drained = $false

while ($sw.Elapsed.TotalSeconds -lt $drainTimeout) {
    $current = @(Get-ActiveQueueWorkers)
    if ($current.Count -eq 0) {
        $drained = $true
        break
    }
    Start-Sleep -Seconds 1
}

if (-not $drained) {
    throw "Graceful drain timed out! Workers failed to stop within ${drainTimeout}s."
}
Write-Host "Graceful drain confirmed: 0 workers running." -ForegroundColor Green

# 5. Worker Restoration Procedure using Snapshot Metadata
Write-Host "`nRestoring $($workerSnapshot.Count) worker(s) using exact snapshot metadata..."
$restoredPids = @()
foreach ($snap in $workerSnapshot) {
    $restoredProc = Start-Process -FilePath $snap.ExecutablePath -ArgumentList $snap.Arguments -WorkingDirectory $snap.WorkingDirectory -WindowStyle Hidden -PassThru
    $restoredPids += $restoredProc.Id
    Write-Host "Respawned worker PID $($restoredProc.Id) with Queue=$($snap.QueueName)"
}

Start-Sleep -Seconds 2

# 6. Verification of Restored Worker Health, Arguments, and Count Parity
$finalWorkers = @(Get-ActiveQueueWorkers)
$finalCount = $finalWorkers.Count

Write-Host "`n=== RESTORATION VERIFICATION ===" -ForegroundColor Cyan
Write-Host "Initial Worker Count: $initialCount | Final Worker Count: $finalCount"

if ($initialCount -ne $finalCount) {
    throw "Worker count parity failed! Initial: $initialCount, Final: $finalCount"
}

# Verify each restored worker is alive and executing with correct arguments
foreach ($w in $finalWorkers) {
    $p = Get-Process -Id $w.ProcessId -ErrorAction SilentlyContinue
    if (-not $p -or $p.HasExited) {
        throw "Restored worker PID $($w.ProcessId) is dead or exited!"
    }
    if ($w.CommandLine -notmatch $testQueueName) {
        throw "Restored worker CommandLine mismatch! Expected queue: $testQueueName, Got: $($w.CommandLine)"
    }
    Write-Host "Verified Worker PID $($w.ProcessId): Healthy, Responsive, Queue=$testQueueName" -ForegroundColor Green
}

# 7. Cleanup test workers
Write-Host "`nCleaning up test workers..."
& $phpExe $artisan queue:restart
Start-Sleep -Seconds 2
foreach ($pidToKill in $restoredPids) {
    Stop-Process -Id $pidToKill -Force -ErrorAction SilentlyContinue
}
if (Test-Path $snapshotPath) { Remove-Item $snapshotPath -Force }

Write-Host "NON-ZERO WORKER BASELINE TEST COMPLETED: 100% PASS!" -ForegroundColor Green

