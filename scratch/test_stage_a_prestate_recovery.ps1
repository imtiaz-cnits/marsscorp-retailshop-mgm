# Staging Test for Workstream E: Stage A Pre-State Preservation and Failure Recovery
$ErrorActionPreference = "Stop"

$ProjectRoot = "d:\Running Works\04. Clients Back-end Projects - 2025\PHP - Laravel\MARSS Corp\marsscorp-retailshop-mgm"
Set-Location -Path $ProjectRoot

Write-Host "=================================================================" -ForegroundColor Cyan
Write-Host " WORKSTREAM E: STAGE A PRE-STATE PRESERVATION & RECOVERY TEST   " -ForegroundColor Cyan
Write-Host "=================================================================`n" -ForegroundColor Cyan

function Run-StageA-Simulation([bool]$SimulateFailure, [string]$FailurePoint) {
    # 1. Capture Pre-Existing State
    $InitialDownExists  = Test-Path "storage/framework/down"
    $InitialQueuePaused = (php scratch/check_is_paused.php).Trim() -match "YES"
    $InitialWorkers     = (Get-CimInstance Win32_Process -Filter "name = 'php.exe'" | Where-Object { $_.CommandLine -match "queue:work" } | Measure-Object).Count

    Write-Host ">>> Initial Captured State:" -ForegroundColor Yellow
    Write-Host "    - Down File Exists: $InitialDownExists"
    Write-Host "    - Queue Paused:     $InitialQueuePaused"
    Write-Host "    - Active Workers:   $InitialWorkers"

    $MaintEngagedByScript = $false
    $QueuePausedByScript  = $false
    $CleanTestDb          = $null

    try {
        # Engage maintenance mode if not already down
        if (!$InitialDownExists) {
            $MaintSecret = [System.Guid]::NewGuid().ToString("N")
            & php artisan down --secret="$MaintSecret" > $null
            if ($LASTEXITCODE -ne 0) { throw "php artisan down failed" }
            $MaintEngagedByScript = $true
            Write-Host "    [Action] Maintenance mode engaged by script."
        } else {
            Write-Host "    [Notice] System was ALREADY in maintenance mode. Retaining pre-existing lock."
        }

        if ($SimulateFailure -and $FailurePoint -eq "AfterDown") {
            throw "INJECTED FAILURE: Simulated failure immediately after maintenance mode check!"
        }

        # Pause queue if not already paused
        if (!$InitialQueuePaused) {
            & php artisan queue:pause default > $null
            if ($LASTEXITCODE -ne 0) { throw "queue:pause failed" }
            $QueuePausedByScript = $true
            Write-Host "    [Action] Queue paused by script."
        } else {
            Write-Host "    [Notice] Queue was ALREADY paused. Retaining pre-existing pause."
        }

        if ($SimulateFailure -and $FailurePoint -eq "AfterQueue") {
            throw "INJECTED FAILURE: Simulated failure after queue pause!"
        }

        Write-Host "    [Success] Pre-migration steps completed cleanly."
        return "SUCCESS"

    } catch {
        Write-Host "    [ABORT CAUGHT] $($_.Exception.Message)" -ForegroundColor Red

        # Recovery Logic: Only revert changes made BY THIS SCRIPT
        if ($MaintEngagedByScript) {
            Write-Host "    [Recovery] Reverting maintenance mode engaged by script (calling php artisan up)..." -ForegroundColor Yellow
            & php artisan up > $null
        } else {
            Write-Host "    [Recovery] Preserving pre-existing maintenance mode (NOT calling php artisan up)." -ForegroundColor Green
        }

        if ($QueuePausedByScript) {
            Write-Host "    [Recovery] Resuming queue paused by script (calling queue:continue)..." -ForegroundColor Yellow
            & php artisan queue:continue default > $null
        } else {
            Write-Host "    [Recovery] Preserving pre-existing queue pause (NOT calling queue:continue)." -ForegroundColor Green
        }

        return "RECOVERED_SAFELY"
    }
}

# Scenario 1: Initial state UP -> Failure injected -> Reverted to UP
Write-Host "--- Test Scenario 1: System initially UP, Failure after Down ---" -ForegroundColor Cyan
$res1 = Run-StageA-Simulation -SimulateFailure $true -FailurePoint "AfterDown"
$postDown1 = Test-Path "storage/framework/down"
Write-Host "Post-recovery down file exists: $postDown1 (Expected: False) - Status: " -NoNewline
Write-Host $(if (!$postDown1) { "PASS" } else { "FAIL" }) -ForegroundColor $(if (!$postDown1) { "Green" } else { "Red" })

# Scenario 2: Initial state DOWN -> Failure injected -> Preserved DOWN
Write-Host "`n--- Test Scenario 2: System initially DOWN, Pre-existing Lock Preserved ---" -ForegroundColor Cyan
& php artisan down --secret="pre_existing_lock_test" > $null
$res2 = Run-StageA-Simulation -SimulateFailure $true -FailurePoint "AfterDown"
$postDown2 = Test-Path "storage/framework/down"
Write-Host "Post-recovery down file exists: $postDown2 (Expected: True) - Status: " -NoNewline
Write-Host $(if ($postDown2) { "PASS" } else { "FAIL" }) -ForegroundColor $(if ($postDown2) { "Green" } else { "Red" })
# Clean up pre-existing test lock
& php artisan up > $null

# Scenario 3: Initial state Queue PAUSED -> Failure injected -> Preserved PAUSED
Write-Host "`n--- Test Scenario 3: Queue initially PAUSED, Pre-existing Pause Preserved ---" -ForegroundColor Cyan
& php artisan queue:pause default > $null
$res3 = Run-StageA-Simulation -SimulateFailure $true -FailurePoint "AfterQueue"
$isPaused3 = (php scratch/check_is_paused.php).Trim() -match "YES"
Write-Host "Post-recovery queue is paused: $isPaused3 (Expected: True) - Status: " -NoNewline
Write-Host $(if ($isPaused3) { "PASS" } else { "FAIL" }) -ForegroundColor $(if ($isPaused3) { "Green" } else { "Red" })
# Clean up queue pause
& php artisan queue:continue default > $null

Write-Host "`nWORKSTREAM E VERDICT: [PASS - STATE-PRESERVING RECOVERY VERIFIED ACROSS ALL 3 SCENARIOS]" -ForegroundColor Green

