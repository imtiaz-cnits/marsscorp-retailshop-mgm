<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\PurchasesController;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use App\Services\ShahinAlomStockRepairService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

const TEST_REPAIR_HMAC_SECRET = 'test_only_ephemeral_hmac_secret_32bytes_min_v36!';

function assertSafeRepairTestDbName(string $dbName): void
{
    if (!preg_match('/^marsscorpdb_safety_test_[a-zA-Z0-9_]+$/', $dbName) || strtolower($dbName) === 'marsscorpdb') {
        throw new RuntimeException("SAFETY ABORT: Invalid disposable repair test schema name '{$dbName}'.");
    }
}

/**
 * Switch Laravel MySQL connection strictly to the isolated disposable test database.
 */
function useIsolatedRepairTestDatabase(string $dbName): void
{
    assertSafeRepairTestDbName($dbName);
    config(['database.default' => 'mysql']);
    config(['database.connections.mysql.database' => $dbName]);
    DB::purge('mysql');
    DB::reconnect('mysql');

    $activeDb = DB::selectOne('SELECT DATABASE() AS db')->db ?? null;
    if ($activeDb !== $dbName) {
        throw new RuntimeException("SAFETY ABORT: Expected isolated DB '{$dbName}', got '{$activeDb}'.");
    }
}

/**
 * Build a synthetic test-only signed approval manifest fixture (never real Forms 6A/6B sign-off).
 */
function buildValidApprovalManifest(
    string $host,
    int $port,
    string $db,
    string $repairRef = 'REPAIR-SYN-V36-001',
    ?string $verifDate = null,
    string $hmacSecret = TEST_REPAIR_HMAC_SECRET
): array {
    $unsigned = ShahinAlomStockRepairService::buildManifestPayload(
        $repairRef,
        $verifDate ?? date('Y-m-d'),
        'Synthetic Fixture Approver (Test Only)',
        ['SYNTHETIC-FORM-6A', 'SYNTHETIC-FORM-6B'],
        $db,
        $host,
        $port
    );
    $unsigned['signature'] = ShahinAlomStockRepairService::computeManifestSignature($unsigned, $hmacSecret);
    return $unsigned;
}

// Handle child concurrency worker mode
if (isset($argv[1]) && $argv[1] === '--worker') {
    $workerTask = $argv[2] ?? '';
    $payload = json_decode($argv[3] ?? '{}', true) ?: [];
    $workerDbName = (string) ($payload['test_db'] ?? '');

    useIsolatedRepairTestDatabase($workerDbName);
    $user = User::firstOrFail();
    Auth::login($user);

    $readyFile = $payload['ready_file'] ?? '';

    try {
        if ($workerTask === 'repair_holding_lock') {
            $lockDir = $payload['lock_dir'] ?? null;
            $repairKey = $payload['repair_key'] ?? 'shahin_alam_test_key';
            $repairRef = $payload['repair_ref'] ?? 'REPAIR-SYN-V36-001';
            $host = $payload['host'];
            $port = (int) $payload['port'];
            $manifest = buildValidApprovalManifest($host, $port, $workerDbName, $repairRef);

            $service = new ShahinAlomStockRepairService($lockDir, $repairKey, TEST_REPAIR_HMAC_SECRET);
            $result = $service->executeApprovedRepair(
                $workerDbName,
                true,
                $host,
                $port,
                $manifest,
                null,
                function () use ($readyFile) {
                    if ($readyFile) {
                        file_put_contents($readyFile, 'locked');
                    }
                    usleep(800000); // Hold all 34 SKU FOR UPDATE + stock_repair_executions locks before COMMIT
                }
            );
            echo json_encode(['status' => 200, 'result' => $result]);
            exit(0);
        }

        if ($workerTask === 'hold_product_704_for_update') {
            $pdo = DB::connection()->getPdo();
            $pdo->beginTransaction();
            $stmt = $pdo->query('SELECT id, quantity FROM products WHERE id = 704 FOR UPDATE');
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($readyFile) {
                file_put_contents($readyFile, 'locked');
            }
            usleep(800000); // Hold exclusive FOR UPDATE lock on SKU 704 for 800ms
            $pdo->rollBack();
            echo json_encode(['status' => 200, 'locked_row' => $row]);
            exit(0);
        }

        fwrite(STDERR, "Unknown worker task: {$workerTask}\n");
        exit(2);
    } catch (Throwable $e) {
        echo json_encode(['status' => 500, 'error' => $e->getMessage()]);
        exit(1);
    }
}

echo "======================================================================\n";
echo "  MARSS RETAIL — SHAHIN ALOM REPAIR INFRASTRUCTURE V3.6-B SUITE       \n";
echo "======================================================================\n\n";

$testDbName = 'marsscorpdb_safety_test_v36b_' . date('Ymd_His') . '_' . substr(bin2hex(random_bytes(3)), 0, 6);
assertSafeRepairTestDbName($testDbName);

$passCount = 0;
$failCount = 0;
$cleanupFiles = [];
$cleanupDirs = [];
$childProcs = [];
$createdSchemaByThisRun = false;
$origHmacEnv = getenv(ShahinAlomStockRepairService::HMAC_ENV_VAR);

function assertTest(string $name, bool $condition, string $details = ''): void
{
    global $passCount, $failCount;
    if ($condition) {
        $passCount++;
        echo "  [PASS] {$name}\n";
        if ($details !== '') {
            echo "         -> {$details}\n";
        }
    } else {
        $failCount++;
        echo "  [FAIL] {$name}\n";
        if ($details !== '') {
            echo "         -> {$details}\n";
        }
    }
}

function setTestHmacEnv(?string $secret): void
{
    if ($secret === null) {
        putenv(ShahinAlomStockRepairService::HMAC_ENV_VAR);
        unset($_ENV[ShahinAlomStockRepairService::HMAC_ENV_VAR], $_SERVER[ShahinAlomStockRepairService::HMAC_ENV_VAR]);
        return;
    }
    putenv(ShahinAlomStockRepairService::HMAC_ENV_VAR . '=' . $secret);
    $_ENV[ShahinAlomStockRepairService::HMAC_ENV_VAR] = $secret;
    $_SERVER[ShahinAlomStockRepairService::HMAC_ENV_VAR] = $secret;
}

function spawnWorker(string $task, array $payload): array
{
    global $childProcs, $testDbName;
    $payload['test_db'] = $testDbName;
    $phpBin = PHP_BINARY;
    $script = __FILE__;
    $jsonArg = json_encode($payload);
    $cmd = [
        $phpBin,
        $script,
        '--worker',
        $task,
        $jsonArg,
    ];
    $descriptors = [
        0 => ['pipe', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w'],
    ];
    $proc = proc_open($cmd, $descriptors, $pipes, dirname(__DIR__));
    if (!is_resource($proc)) {
        throw new RuntimeException("Failed to spawn worker {$task}");
    }
    fclose($pipes[0]);
    $handle = ['proc' => $proc, 'stdout' => $pipes[1], 'stderr' => $pipes[2], 'closed' => false];
    $childProcs[] = &$handle;
    return $handle;
}

function waitForSignalFile(string $path, int $timeoutMs = 5000): bool
{
    $start = microtime(true);
    while ((microtime(true) - $start) * 1000 < $timeoutMs) {
        if (file_exists($path)) {
            return true;
        }
        usleep(25000);
    }
    return false;
}

function closeWorker(array &$handle): array
{
    if (!empty($handle['closed'])) {
        return ['exit' => 0, 'out' => '', 'err' => ''];
    }
    $out = stream_get_contents($handle['stdout']);
    $err = stream_get_contents($handle['stderr']);
    @fclose($handle['stdout']);
    @fclose($handle['stderr']);
    $code = proc_close($handle['proc']);
    $handle['closed'] = true;
    return ['exit' => $code, 'out' => $out, 'err' => $err];
}

$host = config('database.connections.mysql.host', '127.0.0.1');
$port = config('database.connections.mysql.port', '3306');
$dbUser = config('database.connections.mysql.username', 'root');
$dbPass = config('database.connections.mysql.password', '');

$adminPdo = new PDO("mysql:host={$host};port={$port}", $dbUser, $dbPass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$testLockDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'marss_repair_test_' . uniqid();
mkdir($testLockDir, 0775, true);
$cleanupDirs[] = $testLockDir;

try {
    $existsStmt = $adminPdo->prepare('SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?');
    $existsStmt->execute([$testDbName]);
    if ($existsStmt->fetchColumn() !== false) {
        throw new RuntimeException("SAFETY ABORT: Schema `{$testDbName}` already exists; refusing to drop or overwrite.");
    }

    $adminPdo->exec('CREATE DATABASE `' . $testDbName . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    $createdSchemaByThisRun = true;
    echo "[INIT] Created fresh disposable MySQL schema `{$testDbName}`.\n";

    useIsolatedRepairTestDatabase($testDbName);

    Artisan::call('migrate', ['--force' => true]);
    echo "[INIT] Migrated schema into `{$testDbName}` cleanly.\n";

    $dbMetaRow = DB::selectOne('SELECT @@hostname AS host, @@port AS port');
    $mysqlHost = (string) $dbMetaRow->host;
    $mysqlPort = (int) $dbMetaRow->port;

    // Seed purely synthetic master records (ZERO production data)
    $userId = DB::table('users')->insertGetId([
        'name' => 'Repair Test Admin',
        'email' => 'repair-test@local.invalid',
        'mobile' => '01700000099',
        'otp' => '000000',
        'status' => 'approved',
        'role' => 'admin',
        'password' => password_hash('secret123', PASSWORD_BCRYPT),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $user = User::findOrFail($userId);
    Auth::login($user);

    $brandId = DB::table('brands')->insertGetId([
        'name' => 'Synthetic Brand',
        'status' => 'Active',
        'user_id' => $userId,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $categoryId = DB::table('categories')->insertGetId([
        'category_name' => 'Synthetic Category',
        'status' => 'Active',
        'user_id' => $userId,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $supplierId = DB::table('suppliers')->insertGetId([
        'supplier_id' => 'SUP-SYN-001',
        'name' => 'Synthetic Supplier',
        'company' => 'Synthetic Co',
        'mobile' => '01700000001',
        'address' => 'Test Lab',
        'purchase_payable_amount' => '0',
        'status' => 'Active',
        'user_id' => $userId,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $purCtrl = new PurchasesController();

    $createSyntheticProduct = function (string $name, string $code, int $qty = 0, float $cost = 100.0, ?int $forcedId = null) use ($brandId, $categoryId, $userId): Product {
        $data = [
            'product_name' => $name,
            'quantity' => (string) $qty,
            'cost_price' => (string) $cost,
            'sell_price' => (string) ($cost * 1.5),
            'status' => 'Active',
            'product_code' => json_encode([$code]),
            'brand_id' => $brandId,
            'category_id' => $categoryId,
            'user_id' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        if ($forcedId !== null) {
            $data['id'] = $forcedId;
            DB::table('products')->insert($data);
            return Product::findOrFail($forcedId);
        }
        return Product::create($data);
    };

    // ----------------------------------------------------------------------
    // TEST 9 & TEST 12: ShahinAlomStockRepairService V3.6-B Manifest, Host/Port, DB Ledger & Idempotency
    // ----------------------------------------------------------------------
    echo "\n--- TEST 9 & 12: Repair Service DB Ledger, Signed Manifest, Host/Port, 34-SKU Check & Concurrency ---\n";

    $syntheticQtys = [
        408 => 13, 418 => 4, 704 => 10, 705 => 4, 706 => 6, 707 => 4, 708 => 10, 709 => 2,
        710 => 3,  711 => 6, 712 => 4,  713 => 3, 714 => 3, 715 => 6, 716 => 2,  717 => 0,
        718 => 6,  719 => 6, 720 => 10, 721 => 10, 722 => 3, 723 => 3, 724 => 3,  725 => 6,
        726 => 2,  727 => 1, 728 => 6,  729 => 12, 730 => 6, 731 => 6, 732 => 6,  733 => 10,
        734 => 10, 735 => 6,
    ];

    DB::table('purchases')->insert([
        ['id' => 23, 'purchase_id' => '#PurID00023', 'supplier_id' => $supplierId, 'user_id' => $userId, 'date' => '2026-09-23', 'grand_subtotal' => '1000', 'paid_amount' => '0', 'due_amount' => '1000', 'created_at' => now(), 'updated_at' => now()],
        ['id' => 24, 'purchase_id' => '#PurID00024', 'supplier_id' => $supplierId, 'user_id' => $userId, 'date' => '2026-09-23', 'grand_subtotal' => '1000', 'paid_amount' => '0', 'due_amount' => '1000', 'created_at' => now(), 'updated_at' => now()],
    ]);

    foreach (ShahinAlomStockRepairService::ALL_34_SHAHIN_SKUS as $sku) {
        $qty = $syntheticQtys[$sku['id']];
        $createSyntheticProduct($sku['name'], $sku['barcode'], $qty, 500, $sku['id']);
        DB::table('purchase_order_details')->insert([
            'purchase_id' => $sku['purchase_id'],
            'product_id' => $sku['id'],
            'quantity' => (string) $qty,
            'cost_price' => '500',
            'subtotal' => (string) ($qty * 500),
            'user_id' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    $repairKey = 'v36_regression_key';
    $repairRef = 'REPAIR-SYN-V36-001';
    $service = new ShahinAlomStockRepairService($testLockDir, $repairKey, TEST_REPAIR_HMAC_SECRET);
    $validManifest = buildValidApprovalManifest($mysqlHost, $mysqlPort, $testDbName, $repairRef);

    // 9A: DB / host / port mismatch & out-of-range port guards
    $wrongDbThrown = false;
    try {
        $service->runDryRun('wrong_db_name', $mysqlHost, $mysqlPort);
    } catch (RuntimeException $e) {
        $wrongDbThrown = str_contains($e->getMessage(), 'Database identity mismatch');
    }
    $wrongHostThrown = false;
    try {
        $service->executeApprovedRepair($testDbName, true, 'WRONG_PROD_HOST', $mysqlPort, buildValidApprovalManifest('WRONG_PROD_HOST', $mysqlPort, $testDbName));
    } catch (RuntimeException $e) {
        $wrongHostThrown = str_contains($e->getMessage(), 'Database host mismatch');
    }
    $wrongPortThrown = false;
    try {
        $service->executeApprovedRepair($testDbName, true, $mysqlHost, $mysqlPort + 1, buildValidApprovalManifest($mysqlHost, $mysqlPort + 1, $testDbName));
    } catch (RuntimeException $e) {
        $wrongPortThrown = str_contains($e->getMessage(), 'Database port mismatch');
    }
    $badPortRangeThrown = false;
    try {
        $service->runDryRun($testDbName, $mysqlHost, 70000);
    } catch (RuntimeException $e) {
        $badPortRangeThrown = str_contains($e->getMessage(), '1 and 65535');
    }
    assertTest('T9A Aborts on DB, host, port mismatch, or out-of-range port (>65535)', $wrongDbThrown && $wrongHostThrown && $wrongPortThrown && $badPortRangeThrown);

    // 9B: Refuses execution without confirmation OR incomplete/mismatched manifest
    $unconfirmedThrown = false;
    try {
        $service->executeApprovedRepair($testDbName, false, $mysqlHost, $mysqlPort, $validManifest);
    } catch (RuntimeException $e) {
        $unconfirmedThrown = str_contains($e->getMessage(), 'Physical verification');
    }
    $badManifest = $validManifest;
    $badManifest['items'][0]['approved_physical_count'] = 99;
    $badManifest['signature'] = ShahinAlomStockRepairService::computeManifestSignature($badManifest, TEST_REPAIR_HMAC_SECRET);
    $badManifestThrown = false;
    try {
        $service->executeApprovedRepair($testDbName, true, $mysqlHost, $mysqlPort, $badManifest);
    } catch (RuntimeException $e) {
        $badManifestThrown = str_contains($e->getMessage(), 'approved_physical_count mismatch');
    }
    assertTest('T9B Refuses execution without confirmation or valid manifest', $unconfirmedThrown && $badManifestThrown);

    // 9I & 9J: Strict manifest typing, bounded date, HMAC signature & file hardening (V35-HIGH-2)
    $badPortTypeManifest = $validManifest;
    $badPortTypeManifest['target_port'] = "{$mysqlPort}abc";
    $badPortTypeManifest['signature'] = ShahinAlomStockRepairService::computeManifestSignature($badPortTypeManifest, TEST_REPAIR_HMAC_SECRET);
    $badPortTypeRejected = false;
    try {
        $service->validateApprovalManifest($badPortTypeManifest, $testDbName, $mysqlHost, $mysqlPort);
    } catch (RuntimeException $e) {
        $badPortTypeRejected = str_contains($e->getMessage(), 'target_port must be an exact integer');
    }

    $boolCountManifest = $validManifest;
    $boolCountManifest['items'][2]['approved_physical_count'] = true; // SKU 714 ('new' === '1')
    $boolCountManifest['signature'] = ShahinAlomStockRepairService::computeManifestSignature($boolCountManifest, TEST_REPAIR_HMAC_SECRET);
    $boolCountRejected = false;
    try {
        $service->validateApprovalManifest($boolCountManifest, $testDbName, $mysqlHost, $mysqlPort);
    } catch (RuntimeException $e) {
        $boolCountRejected = str_contains($e->getMessage(), 'approved_physical_count mismatch');
    }

    $futureVerifManifest = buildValidApprovalManifest($mysqlHost, $mysqlPort, $testDbName, $repairRef, date('Y-m-d', strtotime('+2 days')));
    $futureVerifRejected = false;
    try {
        $service->validateApprovalManifest($futureVerifManifest, $testDbName, $mysqlHost, $mysqlPort);
    } catch (RuntimeException $e) {
        $futureVerifRejected = str_contains($e->getMessage(), 'cannot be in the future');
    }

    $staleVerifManifest = buildValidApprovalManifest($mysqlHost, $mysqlPort, $testDbName, $repairRef, date('Y-m-d', strtotime('-45 days')));
    $staleVerifRejected = false;
    try {
        $service->validateApprovalManifest($staleVerifManifest, $testDbName, $mysqlHost, $mysqlPort);
    } catch (RuntimeException $e) {
        $staleVerifRejected = str_contains($e->getMessage(), 'is stale');
    }

    $tamperedSigManifest = $validManifest;
    $tamperedSigManifest['authorized_approver'] = 'Unauthorized Self Approver';
    $tamperedSigRejected = false;
    try {
        $service->validateApprovalManifest($tamperedSigManifest, $testDbName, $mysqlHost, $mysqlPort);
    } catch (RuntimeException $e) {
        $tamperedSigRejected = str_contains($e->getMessage(), 'HMAC-SHA256 signature verification failed');
    }

    $noSecretService = new ShahinAlomStockRepairService($testLockDir, $repairKey, '');
    $missingSecretRejected = false;
    try {
        $noSecretService->validateApprovalManifest($validManifest, $testDbName, $mysqlHost, $mysqlPort);
    } catch (RuntimeException $e) {
        $missingSecretRejected = str_contains($e->getMessage(), 'missing or blank');
    }

    assertTest('T9I Strict manifest typing, date bounds, HMAC tamper check & missing secret fail-closed',
        $badPortTypeRejected && $boolCountRejected && $futureVerifRejected && $staleVerifRejected && $tamperedSigRejected && $missingSecretRejected
    );

    // 9L: Whitespace-only / whitespace-padded HMAC secret rejection + manifest helper reproducibility
    $wsOnlyRejected = false;
    try {
        (new ShahinAlomStockRepairService($testLockDir, $repairKey, str_repeat(' ', 36)))
            ->validateApprovalManifest($validManifest, $testDbName, $mysqlHost, $mysqlPort);
    } catch (RuntimeException $e) {
        $wsOnlyRejected = str_contains($e->getMessage(), 'missing or blank');
    }
    $leadingPadRejected = false;
    try {
        (new ShahinAlomStockRepairService($testLockDir, $repairKey, ' ' . TEST_REPAIR_HMAC_SECRET))
            ->validateApprovalManifest($validManifest, $testDbName, $mysqlHost, $mysqlPort);
    } catch (RuntimeException $e) {
        $leadingPadRejected = str_contains($e->getMessage(), 'whitespace');
    }
    $trailingNewlineRejected = false;
    try {
        ShahinAlomStockRepairService::signManifest($validManifest, TEST_REPAIR_HMAC_SECRET . "\n");
    } catch (RuntimeException $e) {
        $trailingNewlineRejected = str_contains($e->getMessage(), 'whitespace');
    }
    $unsignedHelper = ShahinAlomStockRepairService::buildManifestPayload(
        'REPAIR-SYN-HELPER-01',
        date('Y-m-d'),
        'Synthetic Helper Fixture',
        ['SYNTHETIC-6A', 'SYNTHETIC-6B'],
        $testDbName,
        $mysqlHost,
        $mysqlPort
    );
    $signedHelper1 = ShahinAlomStockRepairService::signManifest($unsignedHelper, TEST_REPAIR_HMAC_SECRET);
    $signedHelper2 = ShahinAlomStockRepairService::signManifest($unsignedHelper, TEST_REPAIR_HMAC_SECRET);
    $validatedHelper = $service->validateApprovalManifest($signedHelper1, $testDbName, $mysqlHost, $mysqlPort);
    assertTest('T9L Rejects blank/whitespace-padded HMAC secrets & reproduces canonical signed manifest deterministically',
        $wsOnlyRejected && $leadingPadRejected && $trailingNewlineRejected
        && $signedHelper1['signature'] === $signedHelper2['signature']
        && $validatedHelper['repair_reference'] === 'REPAIR-SYN-HELPER-01'
    );

    $dirRejected = false;
    try {
        $service->loadAndValidateManifestFile($testLockDir, $testDbName, $mysqlHost, $mysqlPort);
    } catch (RuntimeException $e) {
        $dirRejected = str_contains($e->getMessage(), 'not a readable regular file');
    }
    $oversizePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'oversize_manifest_' . uniqid() . '.json';
    $cleanupFiles[] = $oversizePath;
    file_put_contents($oversizePath, str_repeat(' ', 70000));
    $oversizeRejected = false;
    try {
        $service->loadAndValidateManifestFile($oversizePath, $testDbName, $mysqlHost, $mysqlPort);
    } catch (RuntimeException $e) {
        $oversizeRejected = str_contains($e->getMessage(), 'file size out of allowed bounds');
    }
    $validManifestFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'valid_manifest_' . uniqid() . '.json';
    $cleanupFiles[] = $validManifestFile;
    file_put_contents($validManifestFile, json_encode($validManifest));
    $loadedFromFile = $service->loadAndValidateManifestFile($validManifestFile, $testDbName, $mysqlHost, $mysqlPort);
    $symlinkRejected = true;
    $symlinkPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'symlink_manifest_' . uniqid() . '.json';
    if (@symlink($validManifestFile, $symlinkPath)) {
        $cleanupFiles[] = $symlinkPath;
        $symlinkRejected = false;
        try {
            $service->loadAndValidateManifestFile($symlinkPath, $testDbName, $mysqlHost, $mysqlPort);
        } catch (RuntimeException $e) {
            $symlinkRejected = str_contains($e->getMessage(), 'symbolic link');
        }
    }
    assertTest('T9J Manifest file loader enforces is_file(), size cap, symlink rejection, and loads valid signed JSON',
        $dirRejected && $oversizeRejected && $symlinkRejected && ($loadedFromFile['repair_reference'] ?? '') === $repairRef
    );

    // 9E: Non-Category-A SKU barcode tampering rejected
    DB::table('products')->where('id', 705)->update(['product_code' => json_encode(['TAMPERED'])]);
    $tamper34Thrown = false;
    try {
        $service->runDryRun($testDbName, $mysqlHost, $mysqlPort);
    } catch (RuntimeException $e) {
        $tamper34Thrown = str_contains($e->getMessage(), '34-SKU identity mismatch');
    }
    DB::table('products')->where('id', 705)->update(['product_code' => json_encode(['0123S'])]);
    assertTest('T9E Detects identity mismatch on non-Category-A SKU 705', $tamper34Thrown);

    // 9G: Fail-closed when stock_repair_executions table is absent (V35-CRIT-1)
    DB::statement('RENAME TABLE `stock_repair_executions` TO `_tmp_missing_sre`');
    $dryMissingTable = $service->runDryRun($testDbName, $mysqlHost, $mysqlPort);
    $missingTableBlocked = false;
    try {
        $service->executeApprovedRepair($testDbName, true, $mysqlHost, $mysqlPort, $validManifest);
    } catch (RuntimeException $e) {
        $missingTableBlocked = str_contains($e->getMessage(), 'stock_repair_executions');
    } finally {
        DB::statement('RENAME TABLE `_tmp_missing_sre` TO `stock_repair_executions`');
    }
    assertTest('T9G Repair fails closed if stock_repair_executions table is absent & dry-run reports db_ledger_ready=false',
        $missingTableBlocked && $dryMissingTable['db_ledger_ready'] === false && $dryMissingTable['already_executed'] === false
    );

    // 9K: Dry-run is truly read-only consistent snapshot and does NOT block on concurrent FOR UPDATE lock on SKU 704
    $sig9k = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'sig9k_' . uniqid();
    $cleanupFiles[] = $sig9k;
    $w9k = spawnWorker('hold_product_704_for_update', ['ready_file' => $sig9k]);
    $gotSig9k = waitForSignalFile($sig9k, 5000);
    $tDryStart = microtime(true);
    $dryNonBlocking = $service->runDryRun($testDbName, $mysqlHost, $mysqlPort);
    $dryElapsedMs = (microtime(true) - $tDryStart) * 1000;
    $res9k = closeWorker($w9k);
    assertTest('T9K Dry-run uses non-blocking consistent snapshot (' . round($dryElapsedMs) . 'ms < 500ms while SKU 704 FOR UPDATE locked 800ms)',
        $gotSig9k && $res9k['exit'] === 0 && $dryElapsedMs < 500
        && $dryNonBlocking['pre_sum_34'] === 192 && $dryNonBlocking['planned_post_sum_34'] === 177 && $dryNonBlocking['pre_sum_9'] === 59,
        'elapsed=' . round($dryElapsedMs) . 'ms'
    );

    // Dry-run succeeds with 59 -> 44 and 192 -> 177 and db_ledger_ready=true
    $dryRes = $service->runDryRun($testDbName, $mysqlHost, $mysqlPort);
    assertTest('T9 Dry-run validates all 34 SKUs (192->177) & 9 Cat A (59->44) with 0 commits',
        $dryRes['committed'] === false && $dryRes['db_ledger_ready'] === true && $dryRes['already_executed'] === false
        && $dryRes['pre_sum_34'] === 192 && $dryRes['planned_post_sum_34'] === 177 && $dryRes['pre_sum_9'] === 59);

    // 12: Atomic Rollback when 1 target SKU (735) mismatches expected quantity AND zero ledger row written
    DB::table('products')->where('id', 735)->update(['quantity' => '5']);
    $mismatchThrown = false;
    try {
        $service->executeApprovedRepair($testDbName, true, $mysqlHost, $mysqlPort, $validManifest);
    } catch (RuntimeException $e) {
        $mismatchThrown = true;
    }
    $afterRollbackCatA = DB::table('products')->whereIn('id', array_column(ShahinAlomStockRepairService::CATEGORY_A_TARGETS, 'id'))->orderBy('id')->pluck('quantity', 'id')->toArray();
    assertTest('T12 Mismatch on 735 rolls back ALL 9 SKUs & creates NO stock_repair_executions row',
        $mismatchThrown && (string) $afterRollbackCatA[704] === '10' && (string) $afterRollbackCatA[735] === '5'
        && DB::table('stock_repair_executions')->count() === 0);
    DB::table('products')->where('id', 735)->update(['quantity' => '6']);

    // 12B: Post-ledger-insert failure rolls back BOTH the 9 SKU updates AND the stock_repair_executions row atomically
    $hookThrown = false;
    $ledgerCountInsideHook = 0;
    try {
        $service->executeApprovedRepair(
            $testDbName,
            true,
            $mysqlHost,
            $mysqlPort,
            $validManifest,
            null,
            function (PDO $pdo) use (&$ledgerCountInsideHook) {
                $ledgerCountInsideHook = (int) $pdo->query('SELECT COUNT(*) FROM stock_repair_executions')->fetchColumn();
                throw new RuntimeException('Simulated failure right after INSERT INTO stock_repair_executions before COMMIT');
            }
        );
    } catch (RuntimeException $e) {
        $hookThrown = str_contains($e->getMessage(), 'Simulated failure');
    }
    assertTest('T12B Rollback after stock_repair_executions INSERT removes BOTH SKU updates AND ledger row atomically',
        $hookThrown && $ledgerCountInsideHook === 1
        && DB::table('stock_repair_executions')->count() === 0
        && (string) Product::findOrFail(704)->quantity === '10'
        && (string) Product::findOrFail(735)->quantity === '6'
    );

    // 9D: Concurrent PurchasesCreate on SKU 725 while repair service holds FOR UPDATE lock
    $sig9d = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'sig9d_' . uniqid();
    $cleanupFiles[] = $sig9d;
    $w9d = spawnWorker('repair_holding_lock', [
        'ready_file' => $sig9d,
        'lock_dir' => $testLockDir,
        'repair_key' => $repairKey,
        'repair_ref' => $repairRef,
        'host' => $mysqlHost,
        'port' => $mysqlPort,
    ]);
    $gotSig9d = waitForSignalFile($sig9d, 5000);
    $t9 = microtime(true);
    $concurrentPurResp = $purCtrl->PurchasesCreate(Request::create('/api/create-purchases', 'POST', [
        'supplier_id' => $supplierId,
        'date' => '2026-11-18',
        'grand_subtotal' => 5292,
        'paid_amount' => 0,
        'due_amount' => 5292,
        'payment_method' => 'Select Method',
        'products' => json_encode([['product_id' => 725, 'quantity' => 6, 'cost_price' => 882]]),
    ]));
    $elapsed9dMs = (microtime(true) - $t9) * 1000;
    $res9d = closeWorker($w9d);
    $qty725After = (int) Product::findOrFail(725)->quantity;
    $qty719After = (int) Product::findOrFail(719)->quantity;
    $qty408After = (int) Product::findOrFail(408)->quantity;
    $sreRow = DB::table('stock_repair_executions')->where('repair_key', $repairKey)->first();
    assertTest('T9D Concurrent PurchasesCreate waited on lock (' . round($elapsed9dMs) . 'ms), read post-repair 4 & added 6 = 10; DB ledger persisted',
        $gotSig9d && $res9d['exit'] === 0 && $concurrentPurResp->getStatusCode() === 200
        && $qty725After === 10 && $qty719After === 6 && $qty408After === 13
        && $sreRow !== null && $sreRow->repair_reference === $repairRef && strlen((string) $sreRow->manifest_sha256) === 64,
        "qty725={$qty725After}, qty719={$qty719After}, qty408={$qty408After}"
    );

    // 9F: Duplicate execution blocked by DB ledger (no .executed.json!) even if all 9 SKUs later return to [10, 6, 3, 6, 10, 6, 6, 6, 6]
    foreach (ShahinAlomStockRepairService::CATEGORY_A_TARGETS as $t) {
        DB::table('products')->where('id', $t['id'])->update(['quantity' => $t['old']]);
    }
    $dryAfterCommit = $service->runDryRun($testDbName, $mysqlHost, $mysqlPort);
    $dupBlockedThrown = false;
    try {
        $service->executeApprovedRepair($testDbName, true, $mysqlHost, $mysqlPort, $validManifest);
    } catch (RuntimeException $e) {
        $dupBlockedThrown = str_contains($e->getMessage(), 'Duplicate repair execution blocked by database ledger');
    }
    assertTest('T9F DB ledger blocks duplicate execution even when stock matches [10,6,3,6,10,6,6,6,6] (zero FS marker)',
        $dupBlockedThrown && $dryAfterCommit['already_executed'] === true && (string) Product::findOrFail(704)->quantity === '10'
    );

    // 9H: Manifest reuse (same repair_reference) blocked even under a different repair_key
    $altKeyService = new ShahinAlomStockRepairService($testLockDir, 'alt_repair_key_v36', TEST_REPAIR_HMAC_SECRET);
    $reuseRefBlocked = false;
    try {
        $altKeyService->executeApprovedRepair($testDbName, true, $mysqlHost, $mysqlPort, $validManifest);
    } catch (RuntimeException $e) {
        $reuseRefBlocked = str_contains($e->getMessage(), 'repair_reference');
    }
    assertTest('T9H Manifest reuse blocked by DB repair_reference uniqueness even under alternate repair_key', $reuseRefBlocked);

    // ----------------------------------------------------------------------
    // TEST 17: End-to-End Artisan CLI (`purchase:repair-shahin-alam`) Regression Matrix
    // ----------------------------------------------------------------------
    echo "\n--- TEST 17: End-to-End Artisan CLI Matrix (Dry-Run, Refusals, Signed Fixture Execute & Duplicate) ---\n";

    // T17A: CLI Dry-run refusals (missing db, malformed port, out-of-range port, wrong host) + valid CLI dry-run
    $cliDryNoDb = Artisan::call('purchase:repair-shahin-alam');
    $cliDryBadPort = Artisan::call('purchase:repair-shahin-alam', ['--expected-db' => $testDbName, '--expected-port' => '3306abc']);
    $cliDryPortZero = Artisan::call('purchase:repair-shahin-alam', ['--expected-db' => $testDbName, '--expected-port' => '0']);
    $cliDryPortHigh = Artisan::call('purchase:repair-shahin-alam', ['--expected-db' => $testDbName, '--expected-port' => '65536']);
    $cliDryWrongHost = Artisan::call('purchase:repair-shahin-alam', ['--expected-db' => $testDbName, '--expected-host' => 'WRONG_HOST', '--expected-port' => (string) $mysqlPort]);
    $cliDryValid = Artisan::call('purchase:repair-shahin-alam', ['--expected-db' => $testDbName, '--expected-host' => $mysqlHost, '--expected-port' => (string) $mysqlPort]);
    assertTest('T17A CLI dry-run refuses missing db, malformed/invalid port, wrong host (exit=1) & succeeds read-only when valid (exit=0)',
        $cliDryNoDb === 1 && $cliDryBadPort === 1 && $cliDryPortZero === 1 && $cliDryPortHigh === 1
        && $cliDryWrongHost === 1 && $cliDryValid === 0 && (string) Product::findOrFail(704)->quantity === '10'
    );

    // T17B: CLI --execute flag refusals (missing host/port, malformed port, unconfirmed, missing manifest, wrong db)
    $cliManifestUnsigned = ShahinAlomStockRepairService::buildManifestPayload(
        'REPAIR-SYN-CLI-V36B-001',
        date('Y-m-d'),
        'Synthetic CLI Fixture Approver',
        ['SYNTHETIC-FORM-6A', 'SYNTHETIC-FORM-6B'],
        $testDbName,
        $mysqlHost,
        $mysqlPort
    );
    $cliManifestSigned = ShahinAlomStockRepairService::signManifest($cliManifestUnsigned, TEST_REPAIR_HMAC_SECRET);
    $cliManifestFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'cli_valid_manifest_' . uniqid() . '.json';
    $cleanupFiles[] = $cliManifestFile;
    file_put_contents($cliManifestFile, json_encode($cliManifestSigned, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    $cliExecNoHost = Artisan::call('purchase:repair-shahin-alam', [
        '--execute' => true, '--expected-db' => $testDbName, '--expected-port' => (string) $mysqlPort,
        '--confirm-physical-verification' => true, '--approval-manifest' => $cliManifestFile,
    ]);
    $cliExecBadPort = Artisan::call('purchase:repair-shahin-alam', [
        '--execute' => true, '--expected-db' => $testDbName, '--expected-host' => $mysqlHost, '--expected-port' => '3306abc',
        '--confirm-physical-verification' => true, '--approval-manifest' => $cliManifestFile,
    ]);
    $cliExecNoConfirm = Artisan::call('purchase:repair-shahin-alam', [
        '--execute' => true, '--expected-db' => $testDbName, '--expected-host' => $mysqlHost, '--expected-port' => (string) $mysqlPort,
        '--approval-manifest' => $cliManifestFile,
    ]);
    $cliExecNoManifest = Artisan::call('purchase:repair-shahin-alam', [
        '--execute' => true, '--expected-db' => $testDbName, '--expected-host' => $mysqlHost, '--expected-port' => (string) $mysqlPort,
        '--confirm-physical-verification' => true,
    ]);
    $cliExecWrongDb = Artisan::call('purchase:repair-shahin-alam', [
        '--execute' => true, '--expected-db' => 'wrong_db', '--expected-host' => $mysqlHost, '--expected-port' => (string) $mysqlPort,
        '--confirm-physical-verification' => true, '--approval-manifest' => $cliManifestFile,
    ]);
    assertTest('T17B CLI --execute refuses missing host/confirm/manifest, malformed port, and wrong DB (exit=1)',
        $cliExecNoHost === 1 && $cliExecBadPort === 1 && $cliExecNoConfirm === 1
        && $cliExecNoManifest === 1 && $cliExecWrongDb === 1
        && (string) Product::findOrFail(704)->quantity === '10'
    );

    // T17C: CLI --execute refuses missing/whitespace HMAC secret, invalid signature, and missing migration table
    setTestHmacEnv(null);
    $cliExecMissingSecret = Artisan::call('purchase:repair-shahin-alam', [
        '--execute' => true, '--expected-db' => $testDbName, '--expected-host' => $mysqlHost, '--expected-port' => (string) $mysqlPort,
        '--confirm-physical-verification' => true, '--approval-manifest' => $cliManifestFile,
    ]);

    setTestHmacEnv(' ' . TEST_REPAIR_HMAC_SECRET);
    $cliExecPaddedSecret = Artisan::call('purchase:repair-shahin-alam', [
        '--execute' => true, '--expected-db' => $testDbName, '--expected-host' => $mysqlHost, '--expected-port' => (string) $mysqlPort,
        '--confirm-physical-verification' => true, '--approval-manifest' => $cliManifestFile,
    ]);

    setTestHmacEnv(TEST_REPAIR_HMAC_SECRET);
    $tamperedCliManifest = $cliManifestSigned;
    $tamperedCliManifest['signature'] = str_repeat('a', 64);
    $tamperedCliFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'cli_tampered_manifest_' . uniqid() . '.json';
    $cleanupFiles[] = $tamperedCliFile;
    file_put_contents($tamperedCliFile, json_encode($tamperedCliManifest));
    $cliExecBadSig = Artisan::call('purchase:repair-shahin-alam', [
        '--execute' => true, '--expected-db' => $testDbName, '--expected-host' => $mysqlHost, '--expected-port' => (string) $mysqlPort,
        '--confirm-physical-verification' => true, '--approval-manifest' => $tamperedCliFile,
    ]);

    DB::statement('RENAME TABLE `stock_repair_executions` TO `_tmp_cli_missing_sre`');
    try {
        $cliExecNoTable = Artisan::call('purchase:repair-shahin-alam', [
            '--execute' => true, '--expected-db' => $testDbName, '--expected-host' => $mysqlHost, '--expected-port' => (string) $mysqlPort,
            '--confirm-physical-verification' => true, '--approval-manifest' => $cliManifestFile,
        ]);
    } finally {
        DB::statement('RENAME TABLE `_tmp_cli_missing_sre` TO `stock_repair_executions`');
    }
    assertTest('T17C CLI --execute refuses missing/padded HMAC secret, invalid signature, and missing migration (exit=1)',
        $cliExecMissingSecret === 1 && $cliExecPaddedSecret === 1 && $cliExecBadSig === 1 && $cliExecNoTable === 1
        && (string) Product::findOrFail(704)->quantity === '10'
    );

    // T17D: End-to-end CLI --execute with valid synthetic fixture succeeds cleanly (59->44, 192->177) & duplicate CLI --execute fails closed
    $cliExecOk = Artisan::call('purchase:repair-shahin-alam', [
        '--execute' => true,
        '--expected-db' => $testDbName,
        '--expected-host' => $mysqlHost,
        '--expected-port' => (string) $mysqlPort,
        '--confirm-physical-verification' => true,
        '--approval-manifest' => $cliManifestFile,
    ]);
    $catAIds = array_column(ShahinAlomStockRepairService::CATEGORY_A_TARGETS, 'id');
    $all34Ids = array_column(ShahinAlomStockRepairService::ALL_34_SHAHIN_SKUS, 'id');
    $postCliCatASum = (int) DB::table('products')->whereIn('id', $catAIds)->sum(DB::raw('CAST(quantity AS SIGNED)'));
    $postCliAll34Sum = (int) DB::table('products')->whereIn('id', $all34Ids)->sum(DB::raw('CAST(quantity AS SIGNED)'));
    $cliLedgerRow = DB::table('stock_repair_executions')->where('repair_reference', 'REPAIR-SYN-CLI-V36B-001')->first();

    // Reset stock temporarily back to [10,6,3,6,10,6,6,6,6] and verify CLI duplicate --execute STILL refuses (exit=1)
    foreach (ShahinAlomStockRepairService::CATEGORY_A_TARGETS as $t) {
        DB::table('products')->where('id', $t['id'])->update(['quantity' => $t['old']]);
    }
    $cliExecDuplicate = Artisan::call('purchase:repair-shahin-alam', [
        '--execute' => true,
        '--expected-db' => $testDbName,
        '--expected-host' => $mysqlHost,
        '--expected-port' => (string) $mysqlPort,
        '--confirm-physical-verification' => true,
        '--approval-manifest' => $cliManifestFile,
    ]);
    assertTest('T17D CLI --execute commits 59->44 (192->177) with DB ledger row & blocks duplicate CLI --execute (exit=1)',
        $cliExecOk === 0 && $postCliCatASum === 44 && $postCliAll34Sum === 177
        && $cliLedgerRow !== null && $cliLedgerRow->repair_key === 'shahin_alam_cat_a_v3_repair'
        && $cliExecDuplicate === 1 && (string) Product::findOrFail(704)->quantity === '10'
    );

} finally {
    setTestHmacEnv($origHmacEnv !== false ? $origHmacEnv : null);
    Purchase::flushEventListeners();

    foreach ($childProcs as &$procHandle) {
        if (empty($procHandle['closed']) && isset($procHandle['proc']) && is_resource($procHandle['proc'])) {
            @proc_terminate($procHandle['proc']);
            @fclose($procHandle['stdout']);
            @fclose($procHandle['stderr']);
            @proc_close($procHandle['proc']);
            $procHandle['closed'] = true;
        }
    }
    unset($procHandle);

    foreach ($cleanupFiles as $file) {
        if (is_string($file) && file_exists($file) && is_file($file)) {
            @unlink($file);
        }
    }
    foreach ($cleanupDirs as $dir) {
        if (is_string($dir) && is_dir($dir)) {
            foreach (glob($dir . DIRECTORY_SEPARATOR . '*') ?: [] as $f) {
                @unlink($f);
            }
            @rmdir($dir);
        }
    }
    if ($createdSchemaByThisRun) {
        $adminPdo->exec('DROP DATABASE IF EXISTS `' . $testDbName . '`');
        echo "\n[CLEANUP] Dropped self-created disposable schema `{$testDbName}` and removed temporary test artifacts.\n";
    }
}

echo "\n======================================================================\n";
echo "SUMMARY: PASS = {$passCount} | FAIL = {$failCount}\n";
echo "======================================================================\n";

exit($failCount > 0 ? 1 : 0);
