<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReturnController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\StockOverviewController;
use App\Http\Controllers\SupplierDueCollectionController;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseOrderDetails;
use App\Models\PurchasePaymentDetails;
use App\Models\PurchaseReturn;
use App\Models\Supplier;
use App\Models\SupplierDueCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


function assertSafeTestDbName(string $dbName): void
{
    if (!preg_match('/^marsscorpdb_safety_test_[a-zA-Z0-9_]+$/', $dbName) || strtolower($dbName) === 'marsscorpdb') {
        throw new RuntimeException("SAFETY ABORT: Invalid disposable test schema name '{$dbName}'.");
    }
}

/**
 * Switch Laravel MySQL connection strictly to the isolated disposable test database.
 */
function useIsolatedTestDatabase(string $dbName): void
{
    assertSafeTestDbName($dbName);
    config(['database.default' => 'mysql']);
    config(['database.connections.mysql.database' => $dbName]);
    DB::purge('mysql');
    DB::reconnect('mysql');

    $activeDb = DB::selectOne('SELECT DATABASE() AS db')->db ?? null;
    if ($activeDb !== $dbName) {
        throw new RuntimeException("SAFETY ABORT: Expected isolated DB '{$dbName}', got '{$activeDb}'.");
    }
}

// Handle child concurrency worker mode
if (isset($argv[1]) && $argv[1] === '--worker') {
    $workerTask = $argv[2] ?? '';
    $payload = json_decode($argv[3] ?? '{}', true) ?: [];
    $workerDbName = (string) ($payload['test_db'] ?? '');

    useIsolatedTestDatabase($workerDbName);
    $user = User::firstOrFail();
    Auth::login($user);

    $readyFile = $payload['ready_file'] ?? '';

    try {
        if ($workerTask === 'delete_purchase_holding_lock') {
            $purchaseId = (int) $payload['purchase_id'];
            Purchase::deleting(function () use ($readyFile) {
                if ($readyFile) {
                    file_put_contents($readyFile, 'locked');
                }
                usleep(800000); // Hold InnoDB row lock for 800ms before commit
            });
            $ctrl = new PurchasesController();
            $resp = $ctrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $purchaseId]));
            echo json_encode(['status' => $resp->getStatusCode(), 'body' => $resp->getData(true)]);
            exit(0);
        }

        if ($workerTask === 'create_order_holding_lock') {
            Order::created(function () use ($readyFile) {
                if ($readyFile) {
                    file_put_contents($readyFile, 'locked');
                }
                usleep(800000); // Hold Product FOR UPDATE lock inside OrderCreate transaction
            });
            $ctrl = new OrderController();
            $req = Request::create('/api/order-create', 'POST', [
                'customer_id' => $payload['customer_id'],
                'sub_total' => $payload['sub_total'],
                'paid_amount' => $payload['sub_total'],
                'discount_amount' => 0,
                'due_amount' => 0,
                'previous_due_amount' => 0,
                'invoice_date' => $payload['invoice_date'] ?? '2026-11-18',
                'payment_method' => 'Cash',
                'payment_status' => 'Fully Paid',
                'products' => json_encode($payload['products']),
            ]);
            $resp = $ctrl->OrderCreate($req);
            echo json_encode(['status' => $resp->getStatusCode(), 'body' => $resp->getData(true)]);
            exit(0);
        }

        if ($workerTask === 'update_invoice_holding_lock') {
            OrderDetails::saved(function () use ($readyFile) {
                static $signaled = false;
                if (!$signaled && $readyFile) {
                    file_put_contents($readyFile, 'locked');
                    $signaled = true;
                    usleep(800000); // Hold Order + OrderDetails + Product FOR UPDATE locks
                }
            });
            $ctrl = new InvoiceController();
            $req = Request::create('/api/update-invoice', 'POST', [
                'id' => $payload['order_id'],
                'items' => json_encode($payload['items']),
            ]);
            $resp = $ctrl->updateInvoiceDetails($req);
            echo json_encode(['status' => $resp->getStatusCode(), 'body' => $resp->getData(true)]);
            exit(0);
        }

        if ($workerTask === 'customer_return_holding_lock') {
            \App\Models\ProductReturn::created(function () use ($readyFile) {
                static $signaled = false;
                if (!$signaled && $readyFile) {
                    file_put_contents($readyFile, 'locked');
                    $signaled = true;
                    usleep(800000); // Hold OrderDetails + Product FOR UPDATE locks
                }
            });
            $ctrl = new ProductReturnController();
            $req = Request::create('/api/return-product', 'POST', [
                'order_id' => $payload['order_id'],
                'customer_id' => $payload['customer_id'],
                'date' => '2026-11-18',
                'products' => $payload['products'],
            ]);
            $resp = $ctrl->ReturnProductCreate($req);
            echo json_encode(['status' => $resp->getStatusCode(), 'body' => $resp->getData(true)]);
            exit(0);
        }

        if ($workerTask === 'supplier_payment_holding_lock') {
            Purchase::updated(function () use ($readyFile) {
                static $signaled = false;
                if (!$signaled && $readyFile) {
                    file_put_contents($readyFile, 'locked');
                    $signaled = true;
                    usleep(800000); // Hold Supplier -> Purchase locks
                }
            });
            $ctrl = new SupplierDueCollectionController();
            $resp = $ctrl->SupplierPaymentDetailsUpdate(Request::create('/api/supplier-payment-update', 'POST', [
                'supplier_id' => $payload['supplier_id'],
                'paid_amount' => $payload['paid_amount'],
                'discount_amount' => 0,
                'payment_method' => 'Cash',
                'due_collection_date' => date('Y-m-d'),
                'transaction_id' => $payload['transaction_id'] ?? 'TRX-W16',
                'collection_type' => 'purchase',
            ]));
            echo json_encode(['status' => $resp->getStatusCode(), 'body' => $resp->getData(true)]);
            exit(0);
        }

        if ($workerTask === 'purchase_return_holding_lock') {
            PurchaseReturn::created(function () use ($readyFile) {
                static $signaled = false;
                if (!$signaled && $readyFile) {
                    file_put_contents($readyFile, 'locked');
                    $signaled = true;
                    usleep(800000); // Hold Supplier -> Purchase -> POD -> Product locks
                }
            });
            $ctrl = new ProductReturnController();
            $resp = $ctrl->PurchaseReturnProductCreate(Request::create('/api/purchase-return', 'POST', [
                'purchase_id' => $payload['purchase_id'],
                'supplier_id' => $payload['supplier_id'],
                'date' => date('Y-m-d'),
                'products' => $payload['products'],
            ]));
            echo json_encode(['status' => $resp->getStatusCode(), 'body' => $resp->getData(true)]);
            exit(0);
        }

        if ($workerTask === 'door_variant_update_holding_lock') {
            Product::updated(function () use ($readyFile) {
                static $signaled = false;
                if (!$signaled && $readyFile) {
                    file_put_contents($readyFile, 'locked');
                    $signaled = true;
                    usleep(800000); // Hold sorted variant group locks
                }
            });
            $ctrl = new ProductController();
            $resp = $ctrl->ProductUpdate(Request::create('/api/product-update', 'POST', $payload['request_data']));
            echo json_encode(['status' => $resp->getStatusCode(), 'body' => $resp->getData(true)]);
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
echo "  MARSS RETAIL — PURCHASE & STOCK SAFETY V3.6-A REGRESSION SUITE      \n";
echo "======================================================================\n\n";

$testDbName = 'marsscorpdb_safety_test_v36a_' . date('Ymd_His') . '_' . substr(bin2hex(random_bytes(3)), 0, 6);
assertSafeTestDbName($testDbName);

$passCount = 0;
$failCount = 0;
$cleanupFiles = [];
$cleanupDirs = [];
$childProcs = [];
$createdSchemaByThisRun = false;

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

function makeTempUploadFile(string $prefix, string $content = 'dummy-invoice-scan'): UploadedFile
{
    global $cleanupFiles;
    $tmpPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $prefix . '_' . uniqid() . '.jpg';
    file_put_contents($tmpPath, $content);
    $cleanupFiles[] = $tmpPath;
    return new UploadedFile($tmpPath, $prefix . '.jpg', 'image/jpeg', null, true);
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

// Create disposable MySQL test schema without ever touching marsscorpdb
$host = config('database.connections.mysql.host', '127.0.0.1');
$port = config('database.connections.mysql.port', '3306');
$dbUser = config('database.connections.mysql.username', 'root');
$dbPass = config('database.connections.mysql.password', '');

$adminPdo = new PDO("mysql:host={$host};port={$port}", $dbUser, $dbPass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);


try {
    $existsStmt = $adminPdo->prepare('SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?');
    $existsStmt->execute([$testDbName]);
    if ($existsStmt->fetchColumn() !== false) {
        throw new RuntimeException("SAFETY ABORT: Schema `{$testDbName}` already exists; refusing to drop or overwrite.");
    }

    $adminPdo->exec('CREATE DATABASE `' . $testDbName . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    $createdSchemaByThisRun = true;
    echo "[INIT] Created fresh disposable MySQL schema `{$testDbName}`.\n";

    useIsolatedTestDatabase($testDbName);

    Artisan::call('migrate', ['--force' => true]);
    echo "[INIT] Migrated schema into `{$testDbName}` cleanly.\n";

    // Seed purely synthetic master records (ZERO production data)
    $userId = DB::table('users')->insertGetId([
        'name' => 'Safety Test Admin',
        'email' => 'safety-test@local.invalid',
        'mobile' => '01700000000',
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

    $customerId = DB::table('customers')->insertGetId([
        'customer_id' => 'CUST-SYN-001',
        'customer_name' => 'Synthetic Customer',
        'mobile' => '01800000001',
        'previous_due_amount' => '0',
        'user_id' => $userId,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $purCtrl = new PurchasesController();
    $orderCtrl = new OrderController();
    $invCtrl = new InvoiceController();
    $returnCtrl = new ProductReturnController();
    $dueCtrl = new SupplierDueCollectionController();
    $stockCtrl = new StockOverviewController();
    $prodCtrl = new ProductController();

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

    $createPurchaseViaController = function (array $items, string $date = '2026-10-01', float $paid = 0, ?string $attachName = null, ?string $timestamp = null, ?int $customSupplierId = null) use ($purCtrl, $supplierId): Purchase {
        global $cleanupFiles;
        $subtotal = 0.0;
        foreach ($items as $it) {
            $subtotal += ((int) $it['quantity']) * ((float) $it['cost_price']);
        }
        $due = max(0, $subtotal - $paid);
        $params = [
            'supplier_id' => $customSupplierId ?? $supplierId,
            'date' => $date,
            'grand_subtotal' => $subtotal,
            'paid_amount' => $paid,
            'due_amount' => $due,
            'payment_method' => $paid > 0 ? 'Cash' : 'Select Method',
            'products' => json_encode($items),
        ];
        $files = [];
        if ($attachName !== null) {
            $files['img'] = makeTempUploadFile($attachName);
        }
        $req = Request::create('/api/create-purchases', 'POST', $params, [], $files);
        $resp = $purCtrl->PurchasesCreate($req);
        $data = $resp->getData(true);
        if (($data['status'] ?? '') !== 'success') {
            throw new RuntimeException('Helper PurchasesCreate failed: ' . ($data['message'] ?? 'unknown'));
        }
        $p = Purchase::latest('id')->firstOrFail();
        if (!empty($p->attach_document)) {
            $cleanupFiles[] = public_path($p->attach_document);
        }
        if ($timestamp !== null) {
            DB::table('purchases')->where('id', $p->id)->update(['created_at' => $timestamp, 'updated_at' => $timestamp]);
            DB::table('purchase_order_details')->where('purchase_id', $p->id)->update(['created_at' => $timestamp, 'updated_at' => $timestamp]);
            DB::table('purchase_payment_details')->where('purchases_id', $p->id)->update(['created_at' => $timestamp, 'updated_at' => $timestamp]);
            $p->refresh();
        }
        return $p;
    };

    $createOrderViaController = function (array $lines, string $invoiceDate = '2026-10-05', ?string $timestamp = null) use ($orderCtrl, $customerId): Order {
        $sub = 0;
        foreach ($lines as $ln) {
            $sub += ((int) $ln['quantity']) * ((float) $ln['selling_price']);
        }
        $req = Request::create('/api/order-create', 'POST', [
            'customer_id' => $customerId,
            'sub_total' => $sub,
            'paid_amount' => $sub,
            'discount_amount' => 0,
            'due_amount' => 0,
            'previous_due_amount' => 0,
            'invoice_date' => $invoiceDate,
            'payment_method' => 'Cash',
            'payment_status' => 'Fully Paid',
            'products' => json_encode($lines),
        ]);
        $resp = $orderCtrl->OrderCreate($req);
        $data = $resp->getData(true);
        if (($data['status'] ?? '') !== 'success') {
            throw new RuntimeException('Helper OrderCreate failed: ' . ($data['message'] ?? 'unknown'));
        }
        $o = Order::findOrFail($data['invoice_id']);
        if ($timestamp !== null) {
            DB::table('orders')->where('id', $o->id)->update(['created_at' => $timestamp, 'updated_at' => $timestamp]);
            DB::table('order_details')->where('order_id', $o->id)->update(['created_at' => $timestamp, 'updated_at' => $timestamp]);
            DB::table('order_payment_details')->where('order_id', $o->id)->update(['created_at' => $timestamp, 'updated_at' => $timestamp]);
            $o->refresh();
        }
        return $o;
    };

    // ----------------------------------------------------------------------
    // TEST 9C: Fail-closed retired purchase:reconcile-shahin-alam check
    // ----------------------------------------------------------------------
    echo "\n--- TEST 9C: Retired Reconciliation Command Fail-Closed Check ---\n";
    $reconcileExit = Artisan::call('purchase:reconcile-shahin-alam', ['--force' => true]);
    assertTest('T9C Retired purchase:reconcile-shahin-alam fails closed (exit=1)', $reconcileExit === 1);

    // ----------------------------------------------------------------------
    // TEST 1: Partially Sold Purchase Deletion Blocked (422)
    // ----------------------------------------------------------------------
    echo "\n--- TEST 1: Partially Sold Purchase Deletion Blocked (422) ---\n";
    $p1 = $createSyntheticProduct('T1 Partial Sold Item', 'T1-CODE', 0, 100);
    $pur1 = $createPurchaseViaController([['product_id' => $p1->id, 'quantity' => 6, 'cost_price' => 100]], '2026-10-01', 600, 't1_doc', '2026-10-01 10:00:00');
    $createOrderViaController([['product_id' => $p1->id, 'quantity' => 2, 'price' => 100, 'selling_price' => 150]], '2026-10-05', '2026-10-05 10:00:00');
    $resp1 = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur1->id]));
    assertTest('T1 HTTP status is 422', $resp1->getStatusCode() === 422);
    assertTest('T1 Stock remains 4', (int) $p1->fresh()->quantity === 4, 'qty=' . $p1->fresh()->quantity);
    assertTest('T1 Purchase & attachment preserved', Purchase::find($pur1->id) !== null && file_exists(public_path($pur1->attach_document)));

    // ----------------------------------------------------------------------
    // TEST 2: Fully Sold Purchase Deletion Blocked (422)
    // ----------------------------------------------------------------------
    echo "\n--- TEST 2: Fully Sold Purchase Deletion Blocked (422) ---\n";
    $p2 = $createSyntheticProduct('T2 Fully Sold Item', 'T2-CODE', 0, 200);
    $pur2 = $createPurchaseViaController([['product_id' => $p2->id, 'quantity' => 2, 'cost_price' => 200]], '2026-10-01', 400, null, '2026-10-01 10:00:00');
    $createOrderViaController([['product_id' => $p2->id, 'quantity' => 2, 'price' => 200, 'selling_price' => 300]], '2026-10-05', '2026-10-05 10:00:00');
    $resp2 = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur2->id]));
    assertTest('T2 HTTP status is 422', $resp2->getStatusCode() === 422);
    assertTest('T2 Stock remains 0', (int) $p2->fresh()->quantity === 0);
    assertTest('T2 Purchase & POD intact', Purchase::find($pur2->id) !== null && PurchaseOrderDetails::where('purchase_id', $pur2->id)->count() === 1);

    // ----------------------------------------------------------------------
    // TEST 3: Purchase Return Before Deletion Blocked (Both tables checked)
    // ----------------------------------------------------------------------
    echo "\n--- TEST 3: Purchase Return Before Deletion Blocked (422) ---\n";
    $p3 = $createSyntheticProduct('T3 Return Item', 'T3-CODE', 0, 100);
    $pur3 = $createPurchaseViaController([['product_id' => $p3->id, 'quantity' => 6, 'cost_price' => 100]], '2026-10-01', 0, null, '2026-10-01 10:00:00');
    $pod3 = PurchaseOrderDetails::where('purchase_id', $pur3->id)->firstOrFail();
    $retResp = $returnCtrl->PurchaseReturnProductCreate(Request::create('/api/purchase-return', 'POST', [
        'purchase_id' => $pur3->id,
        'supplier_id' => $supplierId,
        'date' => '2026-10-03',
        'products' => [['purchase_order_detail_id' => $pod3->id, 'product_id' => $p3->id, 'quantity' => 2]],
    ]));
    assertTest('T3 Return processed cleanly', $retResp->getStatusCode() === 200 && (int) $p3->fresh()->quantity === 4);
    $resp3a = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur3->id]));
    assertTest('T3A Delete blocked when purchase_returns row present (422)', $resp3a->getStatusCode() === 422 && (int) $p3->fresh()->quantity === 4);
    DB::table('purchase_returns')->where('purchase_id', $pur3->id)->delete();
    $resp3b = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur3->id]));
    assertTest('T3B Delete blocked when ONLY pod.return_quantity > 0 (422)', $resp3b->getStatusCode() === 422 && (int) $p3->fresh()->quantity === 4);

    // ----------------------------------------------------------------------
    // TEST 4: Multiple Purchases of Same SKU (Unconsumed 2nd Batch Allowed)
    // ----------------------------------------------------------------------
    echo "\n--- TEST 4: Unconsumed Second Purchase Batch Deletion Allowed (200) ---\n";
    $p4 = $createSyntheticProduct('T4 Multi Batch Item', 'T4-CODE', 0, 100);
    $pur4a = $createPurchaseViaController([['product_id' => $p4->id, 'quantity' => 6, 'cost_price' => 100]], '2026-10-01', 600, 't4_a', '2026-10-01 10:00:00');
    $createOrderViaController([['product_id' => $p4->id, 'quantity' => 2, 'price' => 100, 'selling_price' => 150]], '2026-10-05', '2026-10-05 10:00:00'); // 6 -> 4
    $pur4b = $createPurchaseViaController([['product_id' => $p4->id, 'quantity' => 6, 'cost_price' => 150]], '2026-10-10', 900, 't4_b', '2026-10-10 10:00:00'); // 4 -> 10, weighted cost 130
    $pur4bDocAbs = public_path($pur4b->attach_document);
    $resp4 = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur4b->id, 'reason' => 'Duplicate entry test']));
    assertTest('T4 HTTP status is 200', $resp4->getStatusCode() === 200);
    assertTest('T4 Stock restored cleanly to 4', (int) $p4->fresh()->quantity === 4, 'qty=' . $p4->fresh()->quantity);
    assertTest('T4 Cost price restored to 100.00', abs((float) $p4->fresh()->cost_price - 100.0) < 0.01, 'cost=' . $p4->fresh()->cost_price);
    assertTest('T4 Pur #2 deleted & Pur #1 intact', Purchase::find($pur4b->id) === null && Purchase::find($pur4a->id) !== null);
    assertTest('T4 Pur #2 attachment removed & Pur #1 attachment intact', !file_exists($pur4bDocAbs) && file_exists(public_path($pur4a->attach_document)));

    // ----------------------------------------------------------------------
    // TEST 5: Pooled Multi-Purchase Deletion After Intermediate Sale (Policy P2)
    // ----------------------------------------------------------------------
    echo "\n--- TEST 5: Pooled Multi-Purchase Deletion After Intermediate Sale (Policy P2) ---\n";
    $p5 = $createSyntheticProduct('T5 Policy P2 Item', 'T5-CODE', 0, 100);
    $pur5a = $createPurchaseViaController([['product_id' => $p5->id, 'quantity' => 6, 'cost_price' => 100]], '2026-10-01', 600, null, '2026-10-01 10:00:00');
    $createOrderViaController([['product_id' => $p5->id, 'quantity' => 4, 'price' => 100, 'selling_price' => 150]], '2026-10-05', '2026-10-05 10:00:00');
    $pur5b = $createPurchaseViaController([['product_id' => $p5->id, 'quantity' => 6, 'cost_price' => 150]], '2026-10-10', 900, null, '2026-10-10 10:00:00');
    $resp5 = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur5a->id]));
    assertTest('T5 Policy P2 blocks Pur A delete (422)', $resp5->getStatusCode() === 422);
    assertTest('T5 Stock (8) & cost_price (137.50) untouched', (int) $p5->fresh()->quantity === 8 && abs((float) $p5->fresh()->cost_price - 137.50) < 0.01);
    assertTest('T5 Both purchases & payments intact', Purchase::find($pur5a->id) !== null && Purchase::find($pur5b->id) !== null);

    // Sub-case: A(6) -> B(6) -> Sale(7) => stock=5 < 6
    $p5s = $createSyntheticProduct('T5 Deficit Subcase', 'T5S-CODE', 0, 100);
    $pur5sa = $createPurchaseViaController([['product_id' => $p5s->id, 'quantity' => 6, 'cost_price' => 100]], '2026-10-01', 600, null, '2026-10-01 10:00:00');
    $createPurchaseViaController([['product_id' => $p5s->id, 'quantity' => 6, 'cost_price' => 150]], '2026-10-02', 900, null, '2026-10-02 10:00:00');
    $createOrderViaController([['product_id' => $p5s->id, 'quantity' => 7, 'price' => 125, 'selling_price' => 180]], '2026-10-05', '2026-10-05 10:00:00');
    $resp5s = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur5sa->id]));
    assertTest('T5 Sub-case insufficient stock (5 < 6) blocked (422)', $resp5s->getStatusCode() === 422 && (int) $p5s->fresh()->quantity === 5);

    // ----------------------------------------------------------------------
    // TEST 6: Clean Multi-Line Purchase Delete, Missing Product 404, & No Silent Clamp
    // ----------------------------------------------------------------------
    echo "\n--- TEST 6: Clean Multi-Line Purchase Delete, Missing Product 404, & No Silent Clamping ---\n";
    $p6 = $createSyntheticProduct('T6 Clean Delete Item', 'T6-CODE', 0, 100);
    $pur6 = $createPurchaseViaController([
        ['product_id' => $p6->id, 'quantity' => 3, 'cost_price' => 100],
        ['product_id' => $p6->id, 'quantity' => 3, 'cost_price' => 120],
    ], '2026-10-01', 660, 't6_doc', '2026-10-01 10:00:00');
    $doc6Abs = public_path($pur6->attach_document);
    $resp6 = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur6->id]));
    assertTest('T6 Clean multi-line delete returns 200', $resp6->getStatusCode() === 200);
    assertTest('T6 Stock = 0, details/payments deleted, file unlinked', (int) $p6->fresh()->quantity === 0
        && Purchase::find($pur6->id) === null
        && PurchaseOrderDetails::where('purchase_id', $pur6->id)->count() === 0
        && PurchasePaymentDetails::where('purchases_id', $pur6->id)->count() === 0
        && !file_exists($doc6Abs));

    $p6c = $createSyntheticProduct('T6 No Clamp Item', 'T6C-CODE', 0, 100);
    $pur6c = $createPurchaseViaController([['product_id' => $p6c->id, 'quantity' => 6, 'cost_price' => 100]], '2026-10-01', 600, null, '2026-10-01 10:00:00');
    $p6c->update(['quantity' => '3']);
    $resp6c = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur6c->id]));
    assertTest('T6 No silent clamp: returns 422 & stock stays 3', $resp6c->getStatusCode() === 422 && (int) $p6c->fresh()->quantity === 3);

    $missingProdReq = $purCtrl->PurchasesCreate(Request::create('/api/create-purchases', 'POST', [
        'supplier_id' => $supplierId,
        'date' => '2026-10-15',
        'grand_subtotal' => 100,
        'paid_amount' => 0,
        'due_amount' => 100,
        'payment_method' => 'Select Method',
        'products' => json_encode([['product_id' => 999999, 'quantity' => 2, 'cost_price' => 50]]),
    ]));
    assertTest('T6B PurchasesCreate rolls back with 404 on missing product_id (no silent skip)', $missingProdReq->getStatusCode() === 404);

    // ----------------------------------------------------------------------
    // TEST 7: PurchasesUpdate() P2 Parity + Unconsumed Edit & return_quantity Preservation
    // ----------------------------------------------------------------------
    echo "\n--- TEST 7: PurchasesUpdate() P2 Parity & Unconsumed Edit ---\n";
    $p7 = $createSyntheticProduct('T7 Update Item', 'T7-CODE', 5, 882);
    // Prior sale BEFORE purchase date
    $createOrderViaController([['product_id' => $p7->id, 'quantity' => 1, 'price' => 882, 'selling_price' => 1200]], '2026-10-01', '2026-10-01 10:00:00'); // 5 -> 4
    $pur7 = $createPurchaseViaController([['product_id' => $p7->id, 'quantity' => 6, 'cost_price' => 882]], '2026-10-04', 0, null, '2026-10-04 10:00:00'); // 4 -> 10
    $updOk = $purCtrl->PurchasesUpdate(Request::create('/api/update-purchases', 'POST', [
        'id' => $pur7->id,
        'products' => json_encode([['product_id' => $p7->id, 'quantity' => 5, 'cost_price' => 882]]),
    ]));
    assertTest('T7A Unconsumed edit (sales strictly before purchase date) returns 200 & stock = 9', $updOk->getStatusCode() === 200 && (int) $p7->fresh()->quantity === 9);

    // Verify return_quantity preservation on unconsumed edit
    DB::table('purchase_order_details')->where('purchase_id', $pur7->id)->update(['return_quantity' => 2]);
    $updRetBlock = $purCtrl->PurchasesUpdate(Request::create('/api/update-purchases', 'POST', [
        'id' => $pur7->id,
        'products' => json_encode([['product_id' => $p7->id, 'quantity' => 1, 'cost_price' => 882]]),
    ]));
    $updRetKeep = $purCtrl->PurchasesUpdate(Request::create('/api/update-purchases', 'POST', [
        'id' => $pur7->id,
        'products' => json_encode([['product_id' => $p7->id, 'quantity' => 4, 'cost_price' => 882]]),
    ]));
    $preservedRetQty = (int) PurchaseOrderDetails::where('purchase_id', $pur7->id)->value('return_quantity');
    assertTest('T7A Preserves return_quantity=2 & blocks reducing below returned qty', $updRetBlock->getStatusCode() === 422 && $updRetKeep->getStatusCode() === 200 && $preservedRetQty === 2);

    // Now test backdating purchase date to 2026-09-30 (across existing 2026-10-01 sale) -> MUST BLOCK 422!
    $updBackdateBlock = $purCtrl->PurchasesUpdate(Request::create('/api/update-purchases', 'POST', [
        'id' => $pur7->id,
        'date' => '2026-09-30',
        'products' => json_encode([['product_id' => $p7->id, 'quantity' => 4, 'cost_price' => 882]]),
    ]));
    assertTest('T7B Backdating purchase date earlier than historical sale blocked (422)', $updBackdateBlock->getStatusCode() === 422 && $pur7->fresh()->date === '2026-10-04');

    // Now add a sale AFTER purchase date (2026-10-14 >= 2026-10-04), plus replenishment purchase so stock is ample
    $createOrderViaController([['product_id' => $p7->id, 'quantity' => 2, 'price' => 882, 'selling_price' => 1200]], '2026-10-14', '2026-10-14 10:00:00'); // 8 -> 6
    $createPurchaseViaController([['product_id' => $p7->id, 'quantity' => 10, 'cost_price' => 950]], '2026-10-20', 0, null, '2026-10-20 10:00:00'); // 6 -> 16
    $updP2Bypass = $purCtrl->PurchasesUpdate(Request::create('/api/update-purchases', 'POST', [
        'id' => $pur7->id,
        'products' => json_encode([['product_id' => $p7->id, 'quantity' => 2, 'cost_price' => 500]]),
    ]));
    assertTest('T7B PurchasesUpdate() P2 bypass blocked (422) when subsequent sale exists', $updP2Bypass->getStatusCode() === 422 && (int) $p7->fresh()->quantity === 16);

    // ----------------------------------------------------------------------
    // TEST 13: Empirical Policy P2 Business-Date Drift & Backdated Purchases
    // ----------------------------------------------------------------------
    echo "\n--- TEST 13: Empirical P2 Business-Date Integrity (#24 Backdate & #InvID00098 Edit) ---\n";
    // T13A: Backdated purchase #24 pattern: date='2026-09-23', created_at='2026-10-29 22:21:31', sale invoice_date='2026-10-19'
    $p13a = $createSyntheticProduct('T13A Backdated Pur24 Pattern', 'T13A-CODE', 0, 500);
    $pur13a = $createPurchaseViaController([['product_id' => $p13a->id, 'quantity' => 6, 'cost_price' => 500]], '2026-09-23', 0, null, '2026-10-29 22:21:31');
    $createOrderViaController([['product_id' => $p13a->id, 'quantity' => 1, 'price' => 500, 'selling_price' => 800]], '2026-10-19', '2026-10-19 10:00:00');
    $createPurchaseViaController([['product_id' => $p13a->id, 'quantity' => 6, 'cost_price' => 500]], '2026-10-30', 0, null, '2026-10-30 10:00:00');
    $del13a = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur13a->id]));
    $upd13a = $purCtrl->PurchasesUpdate(Request::create('/api/update-purchases', 'POST', [
        'id' => $pur13a->id,
        'products' => json_encode([['product_id' => $p13a->id, 'quantity' => 3, 'cost_price' => 500]]),
    ]));
    assertTest('T13A Backdated purchase blocked on BOTH delete & update despite newer created_at (422)', $del13a->getStatusCode() === 422 && $upd13a->getStatusCode() === 422);

    // T13B: #InvID00098 pattern: Order created 2026-10-26, edited on 2026-10-29 AFTER purchase date=2026-10-29
    $p13b = $createSyntheticProduct('T13B Inv98 False Positive Elimination', 'T13B-CODE', 5, 400);
    $ord13b = $createOrderViaController([['product_id' => $p13b->id, 'quantity' => 1, 'price' => 400, 'selling_price' => 600]], '2026-10-26', '2026-10-26 05:00:00'); // 5 -> 4
    $od13bBefore = OrderDetails::where('order_id', $ord13b->id)->firstOrFail();
    $pur13b = $createPurchaseViaController([['product_id' => $p13b->id, 'quantity' => 6, 'cost_price' => 400]], '2026-10-29', 0, null, '2026-10-29 22:11:18'); // 4 -> 10
    $invEditResp = $invCtrl->updateInvoiceDetails(Request::create('/api/update-invoice', 'POST', [
        'id' => $ord13b->id,
        'invoice_date' => '2026-10-26',
        'sub_total' => 1200,
        'paid_amount' => 1200,
        'discount_amount' => 0,
        'items' => json_encode([['product_id' => $p13b->id, 'quantity' => 2, 'cost_price' => 400, 'selling_price' => 600]]),
    ]));
    $od13bAfter = OrderDetails::where('order_id', $ord13b->id)->firstOrFail();
    $del13b = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur13b->id]));
    assertTest('T13B Invoice edit preserves detail id/created_at & order created_at; Oct-29 unconsumed purchase delete allowed (200)',
        $invEditResp->getStatusCode() === 200
        && $od13bAfter->id === $od13bBefore->id
        && (string) $od13bAfter->created_at === '2026-10-26 05:00:00'
        && (string) $ord13b->fresh()->created_at === '2026-10-26 05:00:00'
        && $del13b->getStatusCode() === 200
        && (int) $p13b->fresh()->quantity === 3
    );

    // T13C: Null invoice_date on an active sale forces conservative 422 block
    $p13c = $createSyntheticProduct('T13C Null InvoiceDate Item', 'T13C-CODE', 5, 100);
    $ord13c = $createOrderViaController([['product_id' => $p13c->id, 'quantity' => 1, 'price' => 100, 'selling_price' => 150]], '2026-10-01', '2026-10-01 10:00:00');
    DB::table('orders')->where('id', $ord13c->id)->update(['invoice_date' => null]);
    $pur13c = $createPurchaseViaController([['product_id' => $p13c->id, 'quantity' => 5, 'cost_price' => 100]], '2026-10-20', 0, null, '2026-10-20 10:00:00');
    $del13c = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur13c->id]));
    assertTest('T13C Ambiguous NULL invoice_date on active sale blocks P2 conservatively (422)', $del13c->getStatusCode() === 422);

    // ----------------------------------------------------------------------
    // TEST 14: InvoiceController::updateInvoiceDetails() Return & Negative-Stock Guards
    // ----------------------------------------------------------------------
    echo "\n--- TEST 14: updateInvoiceDetails() Return Preservation & Negative-Stock Guard ---\n";
    $p14a = $createSyntheticProduct('T14A Returned Inv Item', 'T14A-CODE', 10, 100);
    $p14b = $createSyntheticProduct('T14B Added Inv Item', 'T14B-CODE', 4, 200);
    $ord14 = $createOrderViaController([['product_id' => $p14a->id, 'quantity' => 5, 'price' => 100, 'selling_price' => 150]], '2026-10-10', '2026-10-10 09:00:00'); // p14a=5
    $od14 = OrderDetails::where('order_id', $ord14->id)->firstOrFail();

    $ret14 = $returnCtrl->ReturnProductCreate(Request::create('/api/return-product', 'POST', [
        'order_id' => $ord14->id,
        'customer_id' => $customerId,
        'date' => '2026-10-11',
        'products' => [['order_detail_id' => $od14->id, 'product_id' => $p14a->id, 'quantity' => 2]],
    ]));
    assertTest('T14 Customer return processed (return_quantity=2, stock=7)', $ret14->getStatusCode() === 200 && (int) $od14->fresh()->return_quantity === 2 && (int) $p14a->fresh()->quantity === 7);

    $invRemoveRet = $invCtrl->updateInvoiceDetails(Request::create('/api/update-invoice', 'POST', [
        'id' => $ord14->id,
        'items' => json_encode([['product_id' => $p14b->id, 'quantity' => 1, 'cost_price' => 200, 'selling_price' => 300]]),
    ]));
    assertTest('T14B Blocks removing item with existing returns (422)', $invRemoveRet->getStatusCode() === 422);

    $invBelowRet = $invCtrl->updateInvoiceDetails(Request::create('/api/update-invoice', 'POST', [
        'id' => $ord14->id,
        'items' => json_encode([['product_id' => $p14a->id, 'quantity' => 1, 'cost_price' => 100, 'selling_price' => 150]]),
    ]));
    assertTest('T14B Blocks reducing qty below return_quantity=2 (422)', $invBelowRet->getStatusCode() === 422);

    $invNegStock = $invCtrl->updateInvoiceDetails(Request::create('/api/update-invoice', 'POST', [
        'id' => $ord14->id,
        'items' => json_encode([
            ['product_id' => $p14a->id, 'quantity' => 5, 'cost_price' => 100, 'selling_price' => 150],
            ['product_id' => $p14b->id, 'quantity' => 6, 'cost_price' => 200, 'selling_price' => 300],
        ]),
    ]));
    assertTest('T14C Blocks insufficient stock (422) & prevents negative stock', $invNegStock->getStatusCode() === 422 && (int) $p14b->fresh()->quantity === 4 && (int) $p14a->fresh()->quantity === 7);

    $invValid = $invCtrl->updateInvoiceDetails(Request::create('/api/update-invoice', 'POST', [
        'id' => $ord14->id,
        'items' => json_encode([
            ['product_id' => $p14a->id, 'quantity' => 4, 'cost_price' => 100, 'selling_price' => 150],
            ['product_id' => $p14b->id, 'quantity' => 2, 'cost_price' => 200, 'selling_price' => 300],
        ]),
    ]));
    $od14Updated = OrderDetails::findOrFail($od14->id);
    assertTest('T14A Valid edit preserves return_quantity=2, detail ID, created_at & adjusts stocks cleanly (p14a=8, p14b=2)',
        $invValid->getStatusCode() === 200
        && (int) $od14Updated->return_quantity === 2
        && (string) $od14Updated->created_at === '2026-10-10 09:00:00'
        && (int) $p14a->fresh()->quantity === 8
        && (int) $p14b->fresh()->quantity === 2
    );

    // ----------------------------------------------------------------------
    // TEST 15: Multi-SKU Concurrency, Payment Updates, Split Attachments, & Remaining Writers
    // ----------------------------------------------------------------------
    echo "\n--- TEST 15: Concurrency, Deadlock Prevention, Payments, Split Invoices & Writers ---\n";

    $p15a = $createSyntheticProduct('T15A Inv Edit Concurrency', 'T15A-CODE', 5, 100);
    $ord15a = $createOrderViaController([['product_id' => $p15a->id, 'quantity' => 1, 'price' => 100, 'selling_price' => 150]], '2026-11-18'); // stock=4
    $sig15a = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'sig15a_' . uniqid();
    $cleanupFiles[] = $sig15a;
    $w15a = spawnWorker('update_invoice_holding_lock', [
        'order_id' => $ord15a->id,
        'ready_file' => $sig15a,
        'items' => [['product_id' => $p15a->id, 'quantity' => 4, 'cost_price' => 100, 'selling_price' => 150]], // consumes 3 more -> stock=1
    ]);
    $gotSig15a = waitForSignalFile($sig15a, 5000);
    $t15a = microtime(true);
    $ordResp15a = $orderCtrl->OrderCreate(Request::create('/api/order-create', 'POST', [
        'customer_id' => $customerId,
        'sub_total' => 300,
        'paid_amount' => 300,
        'discount_amount' => 0,
        'due_amount' => 0,
        'previous_due_amount' => 0,
        'invoice_date' => '2026-11-18',
        'payment_method' => 'Cash',
        'payment_status' => 'Fully Paid',
        'products' => json_encode([['product_id' => $p15a->id, 'quantity' => 2, 'price' => 100, 'selling_price' => 150]]),
    ]));
    $elapsed15aMs = (microtime(true) - $t15a) * 1000;
    $res15a = closeWorker($w15a);
    assertTest('T15A updateInvoiceDetails won lock -> OrderCreate blocked (' . round($elapsed15aMs) . 'ms) & rejected 422, stock=1 (never -1)',
        $gotSig15a && $res15a['exit'] === 0 && $ordResp15a->getStatusCode() === 422 && (int) $p15a->fresh()->quantity === 1
    );

    $pLow = $createSyntheticProduct('T15 Low ID SKU', 'T15-LOW', 10, 100);
    $pHigh = $createSyntheticProduct('T15 High ID SKU', 'T15-HIGH', 10, 100);
    $ord15 = $createOrderViaController([
        ['product_id' => $pLow->id, 'quantity' => 4, 'price' => 100, 'selling_price' => 150],
        ['product_id' => $pHigh->id, 'quantity' => 4, 'price' => 100, 'selling_price' => 150],
    ], '2026-11-18'); // both stocks now 6
    $odLow = OrderDetails::where('order_id', $ord15->id)->where('product_id', $pLow->id)->firstOrFail();
    $odHigh = OrderDetails::where('order_id', $ord15->id)->where('product_id', $pHigh->id)->firstOrFail();

    $sig15 = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'sig15_' . uniqid();
    $cleanupFiles[] = $sig15;
    $w15 = spawnWorker('customer_return_holding_lock', [
        'order_id' => $ord15->id,
        'customer_id' => $customerId,
        'ready_file' => $sig15,
        'products' => [
            ['order_detail_id' => $odHigh->id, 'product_id' => $pHigh->id, 'quantity' => 2],
            ['order_detail_id' => $odLow->id, 'product_id' => $pLow->id, 'quantity' => 2],
        ],
    ]);
    $gotSig15 = waitForSignalFile($sig15, 5000);
    $t15 = microtime(true);
    $ordResp15 = $orderCtrl->OrderCreate(Request::create('/api/order-create', 'POST', [
        'customer_id' => $customerId,
        'sub_total' => 600,
        'paid_amount' => 600,
        'discount_amount' => 0,
        'due_amount' => 0,
        'previous_due_amount' => 0,
        'invoice_date' => '2026-11-18',
        'payment_method' => 'Cash',
        'payment_status' => 'Fully Paid',
        'products' => json_encode([
            ['product_id' => $pLow->id, 'quantity' => 2, 'price' => 100, 'selling_price' => 150],
            ['product_id' => $pHigh->id, 'quantity' => 2, 'price' => 100, 'selling_price' => 150],
        ]),
    ]));
    $elapsed15Ms = (microtime(true) - $t15) * 1000;
    $res15 = closeWorker($w15);
    assertTest('T15B Reverse-order ReturnProductCreate vs OrderCreate serialized cleanly without deadlock (' . round($elapsed15Ms) . 'ms), final stocks = 6/6',
        $gotSig15 && $res15['exit'] === 0 && $ordResp15->getStatusCode() === 200
        && (int) $pLow->fresh()->quantity === 6 && (int) $pHigh->fresh()->quantity === 6,
        'worker_out=' . trim($res15['out'])
    );

    $otherSupplierId = DB::table('suppliers')->insertGetId([
        'supplier_id' => 'SUP-SYN-999',
        'name' => 'Other Supplier',
        'company' => 'Other Co',
        'mobile' => '01700000999',
        'address' => 'Test Lab',
        'purchase_payable_amount' => '0',
        'status' => 'Active',
        'user_id' => $userId,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $p15c = $createSyntheticProduct('T15C Purchase Return Ownership', 'T15C-CODE', 0, 100);
    $pur15c = $createPurchaseViaController([['product_id' => $p15c->id, 'quantity' => 5, 'cost_price' => 100]], '2026-11-01', 0);
    $pod15c = PurchaseOrderDetails::where('purchase_id', $pur15c->id)->firstOrFail();
    $badPurRetResp = $returnCtrl->PurchaseReturnProductCreate(Request::create('/api/purchase-return', 'POST', [
        'purchase_id' => $pur15c->id,
        'supplier_id' => $otherSupplierId,
        'date' => '2026-11-02',
        'products' => [['purchase_order_detail_id' => $pod15c->id, 'product_id' => $p15c->id, 'quantity' => 1]],
    ]));
    assertTest('T15C PurchaseReturnProductCreate rejects mismatched supplier_id (422)', $badPurRetResp->getStatusCode() === 422 && (int) $p15c->fresh()->quantity === 5);

    $p15d = $createSyntheticProduct('T15D Payment Item', 'T15D-CODE', 0, 500);
    $pur15d = $createPurchaseViaController([['product_id' => $p15d->id, 'quantity' => 4, 'cost_price' => 500]], '2026-10-01', 500, null, '2026-10-01 10:00:00');
    $payResp = $purCtrl->updatePaymentDetails(Request::create('/api/update-purchase-payment', 'POST', [
        'id' => $pur15d->id,
        'paid_amount' => 700,
        'payment_method' => 'Bank',
        'transaction_id' => 'BNK-15D',
    ]));
    assertTest('T15D updatePaymentDetails() synchronizes paid=1200, due=800',
        $payResp->getStatusCode() === 200
        && abs((float) $pur15d->fresh()->paid_amount - 1200.0) < 0.01
        && abs((float) $pur15d->fresh()->due_amount - 800.0) < 0.01
    );

    $p15e1 = $createSyntheticProduct('T15E Parent SKU', 'T15E-1', 0, 100);
    $p15e2 = $createSyntheticProduct('T15E Child SKU', 'T15E-2', 0, 200);
    $pur15e = $createPurchaseViaController([
        ['product_id' => $p15e1->id, 'quantity' => 2, 'cost_price' => 100],
        ['product_id' => $p15e2->id, 'quantity' => 2, 'cost_price' => 200],
    ], '2026-10-01', 600, 't15_shared', '2026-10-01 10:00:00');
    $sharedAttachAbs = public_path($pur15e->attach_document);
    $pod15e2 = PurchaseOrderDetails::where('purchase_id', $pur15e->id)->where('product_id', $p15e2->id)->firstOrFail();
    $splitResp = $purCtrl->PurchaseSplitInvoice(Request::create('/api/split-purchase', 'POST', [
        'purchase_id' => $pur15e->id,
        'detail_ids' => [$pod15e2->id],
    ]));
    $splitPurchase = Purchase::where('id', '>', $pur15e->id)->latest('id')->first();
    $delSplitChild = $splitPurchase ? $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $splitPurchase->id])) : null;
    assertTest('T15E Deleting split purchase preserves shared attach_document for remaining parent',
        $splitResp->getStatusCode() === 200 && $delSplitChild && $delSplitChild->getStatusCode() === 200 && file_exists($sharedAttachAbs)
    );
    $delSplitParent = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur15e->id]));
    assertTest('T15E Deleting last owner unlinks attach_document cleanly', $delSplitParent->getStatusCode() === 200 && !file_exists($sharedAttachAbs));

    $p15f = $createSyntheticProduct('T15F Stock Adjust SKU', 'T15F-CODE', 5, 100);
    $adjResp = $stockCtrl->RetailStockAdjust(Request::create('/api/retail-stock-adjust', 'POST', [
        'product_id' => $p15f->id,
        'new_quantity' => 9,
        'reason' => 'Physical recount',
    ]));
    $qtyAfterAdj = (int) $p15f->fresh()->quantity;
    $prodUpdBad = $prodCtrl->ProductUpdate(Request::create('/api/product-update', 'POST', [
        'id' => $p15f->id,
        'product_name' => 'T15F Stock Adjust SKU',
        'brand_id' => $brandId,
        'category_id' => $categoryId,
        'quantity' => -3,
        'cost_price' => 100,
        'sell_price' => 150,
    ]));
    $prodUpdOk = $prodCtrl->ProductUpdate(Request::create('/api/product-update', 'POST', [
        'id' => $p15f->id,
        'product_name' => 'T15F Stock Adjust SKU',
        'brand_id' => $brandId,
        'category_id' => $categoryId,
        'quantity' => 12,
        'cost_price' => 110,
        'sell_price' => 160,
    ]));
    $prodUpdOkBody = $prodUpdOk->getData(true);
    assertTest('T15F RetailStockAdjust (9) & ProductUpdate (rejects -3 with 422, updates to 12)',
        $adjResp->getStatusCode() === 200
        && $qtyAfterAdj === 9
        && $prodUpdBad->getStatusCode() === 422
        && $prodUpdOk->getStatusCode() === 200
        && ($prodUpdOkBody['status'] ?? '') === 'success'
        && (int) $p15f->fresh()->quantity === 12
    );

    // ----------------------------------------------------------------------
    // TEST 8: Real Multi-Connection Concurrency (Sale vs Purchase Delete)
    // ----------------------------------------------------------------------
    echo "\n--- TEST 8: Real Multi-Connection Concurrency (OrderCreate vs PurchasesDelete) ---\n";
    $p8a = $createSyntheticProduct('T8A Concurrent Item', 'T8A-CODE', 0, 100);
    $pur8a = $createPurchaseViaController([['product_id' => $p8a->id, 'quantity' => 6, 'cost_price' => 100]], '2026-11-18', 0, null, '2026-11-18 09:00:00');
    $sig8a = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'sig8a_' . uniqid();
    $cleanupFiles[] = $sig8a;
    $w8a = spawnWorker('delete_purchase_holding_lock', ['purchase_id' => $pur8a->id, 'ready_file' => $sig8a]);
    $gotSig8a = waitForSignalFile($sig8a, 5000);
    $t0 = microtime(true);
    $ordResp8a = $orderCtrl->OrderCreate(Request::create('/api/order-create', 'POST', [
        'customer_id' => $customerId,
        'sub_total' => 300,
        'paid_amount' => 300,
        'discount_amount' => 0,
        'due_amount' => 0,
        'previous_due_amount' => 0,
        'invoice_date' => '2026-11-18',
        'payment_method' => 'Cash',
        'payment_status' => 'Fully Paid',
        'products' => json_encode([['product_id' => $p8a->id, 'quantity' => 2, 'price' => 100, 'selling_price' => 150]]),
    ]));
    $elapsed8aMs = (microtime(true) - $t0) * 1000;
    $res8a = closeWorker($w8a);
    assertTest('T8A Delete won lock -> OrderCreate blocked (' . round($elapsed8aMs) . 'ms) & rejected 422, stock=0 (never -2)',
        $gotSig8a && $res8a['exit'] === 0 && $ordResp8a->getStatusCode() === 422 && (int) $p8a->fresh()->quantity === 0
    );

    $p8b = $createSyntheticProduct('T8B Concurrent Item', 'T8B-CODE', 0, 100);
    $pur8b = $createPurchaseViaController([['product_id' => $p8b->id, 'quantity' => 6, 'cost_price' => 100]], '2026-11-18', 0, null, '2026-11-18 09:00:00');
    $sig8b = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'sig8b_' . uniqid();
    $cleanupFiles[] = $sig8b;
    $w8b = spawnWorker('create_order_holding_lock', [
        'customer_id' => $customerId,
        'sub_total' => 300,
        'ready_file' => $sig8b,
        'products' => [['product_id' => $p8b->id, 'quantity' => 2, 'price' => 100, 'selling_price' => 150]],
    ]);
    $gotSig8b = waitForSignalFile($sig8b, 5000);
    $t1 = microtime(true);
    $delResp8b = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur8b->id]));
    $elapsed8bMs = (microtime(true) - $t1) * 1000;
    $res8b = closeWorker($w8b);
    assertTest('T8B OrderCreate won lock -> PurchasesDelete blocked (' . round($elapsed8bMs) . 'ms) & rejected 422, stock=4',
        $gotSig8b && $res8b['exit'] === 0 && $delResp8b->getStatusCode() === 422 && (int) $p8b->fresh()->quantity === 4
    );

    // ----------------------------------------------------------------------
    // TEST 10: Failed DB Commit With Attachment (Post-Commit Unlink Guard)
    // ----------------------------------------------------------------------
    echo "\n--- TEST 10: Failed DB Commit Preserves Invoice Attachment ---\n";
    $p10 = $createSyntheticProduct('T10 Rollback Attachment Item', 'T10-CODE', 0, 100);
    $pur10 = $createPurchaseViaController([['product_id' => $p10->id, 'quantity' => 6, 'cost_price' => 100]], '2026-10-01', 600, 't10_doc', '2026-10-01 10:00:00');
    $doc10Abs = public_path($pur10->attach_document);
    Purchase::deleting(function () {
        throw new RuntimeException('Simulated DB constraint error before commit');
    });
    $resp10 = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur10->id]));
    Purchase::flushEventListeners();
    assertTest('T10 Returns HTTP 500 & rolls back purchase/stock', $resp10->getStatusCode() === 500
        && (int) $p10->fresh()->quantity === 6
        && Purchase::find($pur10->id) !== null);
    assertTest('T10 Attachment file STILL EXISTS on disk after rollback', file_exists($doc10Abs));

    // ----------------------------------------------------------------------
    // TEST 11: Supplier Payment & Due Collection Integrity (422)
    // ----------------------------------------------------------------------
    echo "\n--- TEST 11: Supplier Payment & Due Collection Integrity ---\n";
    $supplier11Id = DB::table('suppliers')->insertGetId([
        'supplier_id' => 'SUP-SYN-011',
        'name' => 'Synthetic Supplier 11',
        'company' => 'Synthetic Co 11',
        'mobile' => '01700000011',
        'address' => 'Test Lab 11',
        'purchase_payable_amount' => '0',
        'status' => 'Active',
        'user_id' => $userId,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $p11 = $createSyntheticProduct('T11 Due Settlement Item', 'T11-CODE', 0, 1000);
    $pur11 = $createPurchaseViaController([['product_id' => $p11->id, 'quantity' => 10, 'cost_price' => 1000]], '2026-10-01', 0, null, '2026-10-01 10:00:00', $supplier11Id);
    $dueResp = $dueCtrl->SupplierPaymentDetailsUpdate(Request::create('/api/supplier-payment-update', 'POST', [
        'supplier_id' => $supplier11Id,
        'paid_amount' => 10000,
        'discount_amount' => 0,
        'payment_method' => 'Cash',
        'due_collection_date' => '2026-10-05',
        'transaction_id' => 'TRX-T11-001',
        'collection_type' => 'purchase',
    ]));
    assertTest('T11 Supplier due settled via SupplierPaymentDetailsUpdate', $dueResp->getStatusCode() === 200);
    $resp11 = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur11->id]));
    assertTest('T11 PurchasesDelete blocked (422) with due collection linked', $resp11->getStatusCode() === 422);
    assertTest('T11 Purchase, payment details & supplier_due_collections remain synchronized',
        Purchase::find($pur11->id) !== null
        && PurchasePaymentDetails::where('purchases_id', $pur11->id)->count() === 2
        && SupplierDueCollection::where('supplier_id', $supplier11Id)->count() === 1
        && abs((float) Supplier::findOrFail($supplier11Id)->purchase_payable_amount) < 0.01);

    // ----------------------------------------------------------------------
    // TEST 16: V3.6-A Targeted High/Low Fixes (Deadlock, Date Validation, P2 Edge Cases, Door Variants, CLI Delete)
    // ----------------------------------------------------------------------
    echo "\n--- TEST 16: V3.6-A Concurrency, Date Validation, P2 Edge Cases, Door Variants & CLI Delete ---\n";

    // T16A: Cross-table lock standardization: SupplierPaymentDetailsUpdate vs PurchaseReturnProductCreate (BOTH directions)
    $sup16a = DB::table('suppliers')->insertGetId([
        'supplier_id' => 'SUP-SYN-16A',
        'name' => 'Synthetic Supplier 16A',
        'company' => 'Synthetic Co 16A',
        'mobile' => '01700000161',
        'address' => 'Test Lab 16A',
        'purchase_payable_amount' => '0',
        'status' => 'Active',
        'user_id' => $userId,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $p16a = $createSyntheticProduct('T16A Concurrent Return vs Due', 'T16A-CODE', 0, 500);
    $pur16a = $createPurchaseViaController([['product_id' => $p16a->id, 'quantity' => 10, 'cost_price' => 500]], '2026-11-18', 0, null, '2026-11-18 10:00:00', $sup16a);
    $pod16a = PurchaseOrderDetails::where('purchase_id', $pur16a->id)->firstOrFail();

    // Direction 1: Worker holds SupplierPaymentDetailsUpdate (Supplier -> Purchase), parent runs PurchaseReturnProductCreate
    $sig16a1 = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'sig16a1_' . uniqid();
    $cleanupFiles[] = $sig16a1;
    $w16a1 = spawnWorker('supplier_payment_holding_lock', [
        'ready_file' => $sig16a1,
        'supplier_id' => $sup16a,
        'paid_amount' => 2000,
        'transaction_id' => 'TRX-16A-1',
    ]);
    $gotSig16a1 = waitForSignalFile($sig16a1, 5000);
    $t16a1 = microtime(true);
    $ret16a1 = $returnCtrl->PurchaseReturnProductCreate(Request::create('/api/purchase-return', 'POST', [
        'purchase_id' => $pur16a->id,
        'supplier_id' => $sup16a,
        'date' => '2026-11-18',
        'products' => [['purchase_order_detail_id' => $pod16a->id, 'product_id' => $p16a->id, 'quantity' => 2]],
    ]));
    $elapsed16a1Ms = (microtime(true) - $t16a1) * 1000;
    $res16a1 = closeWorker($w16a1);

    // Direction 2: Worker holds PurchaseReturnProductCreate (Supplier -> Purchase -> POD -> Product), parent runs SupplierPaymentDetailsUpdate
    $sig16a2 = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'sig16a2_' . uniqid();
    $cleanupFiles[] = $sig16a2;
    $w16a2 = spawnWorker('purchase_return_holding_lock', [
        'ready_file' => $sig16a2,
        'purchase_id' => $pur16a->id,
        'supplier_id' => $sup16a,
        'products' => [['purchase_order_detail_id' => $pod16a->id, 'product_id' => $p16a->id, 'quantity' => 1]],
    ]);
    $gotSig16a2 = waitForSignalFile($sig16a2, 5000);
    $t16a2 = microtime(true);
    $due16a2 = $dueCtrl->SupplierPaymentDetailsUpdate(Request::create('/api/supplier-payment-update', 'POST', [
        'supplier_id' => $sup16a,
        'paid_amount' => 1000,
        'discount_amount' => 0,
        'payment_method' => 'Cash',
        'due_collection_date' => date('Y-m-d'),
        'transaction_id' => 'TRX-16A-2',
        'collection_type' => 'purchase',
    ]));
    $elapsed16a2Ms = (microtime(true) - $t16a2) * 1000;
    $res16a2 = closeWorker($w16a2);

    $pur16aFresh = $pur16a->fresh();
    assertTest(
        'T16A Both concurrent directions (SupplierPaymentDetailsUpdate <-> PurchaseReturnProductCreate) serialized cleanly with ZERO deadlock ('
        . round($elapsed16a1Ms) . 'ms / ' . round($elapsed16a2Ms) . 'ms)',
        $gotSig16a1 && $res16a1['exit'] === 0 && $ret16a1->getStatusCode() === 200
        && $gotSig16a2 && $res16a2['exit'] === 0 && $due16a2->getStatusCode() === 200
        && (int) $p16a->fresh()->quantity === 7
        && abs((float) $pur16aFresh->paid_amount - 3000.0) < 0.01
        && abs((float) $pur16aFresh->due_amount - 500.0) < 0.01,
        "qty={$p16a->fresh()->quantity}, paid={$pur16aFresh->paid_amount}, due={$pur16aFresh->due_amount}"
    );

    // T16B: PurchasesUpdate() strict date validation matrix (V35-HIGH-3)
    $p16b = $createSyntheticProduct('T16B Date Validation SKU', 'T16B-CODE', 0, 100);
    $pur16b = $createPurchaseViaController([['product_id' => $p16b->id, 'quantity' => 5, 'cost_price' => 100]], '2026-10-10', 0, null, '2026-10-10 10:00:00');
    $updOmit = $purCtrl->PurchasesUpdate(Request::create('/api/update-purchases', 'POST', [
        'id' => $pur16b->id,
        'referance_no' => 'REF-OMIT',
    ]));
    $updBadFormat = $purCtrl->PurchasesUpdate(Request::create('/api/update-purchases', 'POST', [
        'id' => $pur16b->id,
        'date' => '2026/99/01',
    ]));
    $updImpossible = $purCtrl->PurchasesUpdate(Request::create('/api/update-purchases', 'POST', [
        'id' => $pur16b->id,
        'date' => '2026-02-30',
    ]));
    $updExplicitEmpty = $purCtrl->PurchasesUpdate(Request::create('/api/update-purchases', 'POST', [
        'id' => $pur16b->id,
        'date' => '',
    ]));
    $updExplicitNull = $purCtrl->PurchasesUpdate(Request::create('/api/update-purchases', 'POST', [
        'id' => $pur16b->id,
        'date' => null,
    ]));
    $updFutureDate = $purCtrl->PurchasesUpdate(Request::create('/api/update-purchases', 'POST', [
        'id' => $pur16b->id,
        'date' => '2099-01-01',
    ]));
    $updValidDmy = $purCtrl->PurchasesUpdate(Request::create('/api/update-purchases', 'POST', [
        'id' => $pur16b->id,
        'date' => '09-10-2026',
    ]));
    assertTest('T16B PurchasesUpdate() omits->keeps (200), rejects bad/impossible/null/empty/future (422), accepts valid DD-MM-YYYY (200)',
        $updOmit->getStatusCode() === 200
        && $updBadFormat->getStatusCode() === 422
        && $updImpossible->getStatusCode() === 422
        && $updExplicitEmpty->getStatusCode() === 422
        && $updExplicitNull->getStatusCode() === 422
        && $updFutureDate->getStatusCode() === 422
        && $updValidDmy->getStatusCode() === 200
        && $pur16b->fresh()->date === '2026-10-09',
        'final_date=' . $pur16b->fresh()->date
    );

    // T16C: P2 Edge Cases & invoice:delete CLI workflow
    $origSqlMode = DB::selectOne('SELECT @@SESSION.sql_mode AS m')->m ?? '';
    $p16c1 = $createSyntheticProduct('T16C Malformed InvoiceDate', 'T16C-1', 5, 100);
    $ord16c1 = $createOrderViaController([['product_id' => $p16c1->id, 'quantity' => 1, 'price' => 100, 'selling_price' => 150]], '2026-10-01', '2026-10-01 10:00:00');
    DB::statement("SET SESSION sql_mode = 'ALLOW_INVALID_DATES'");
    DB::table('orders')->where('id', $ord16c1->id)->update(['invoice_date' => '2026-02-30']);
    DB::statement("SET SESSION sql_mode = ?", [$origSqlMode]);
    $pur16c1 = $createPurchaseViaController([['product_id' => $p16c1->id, 'quantity' => 4, 'cost_price' => 100]], '2026-10-15', 0, null, '2026-10-15 10:00:00');
    $delMalformedInv = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur16c1->id]));

    $p16c2 = $createSyntheticProduct('T16C Null Pur Date/Created', 'T16C-2', 0, 100);
    $pur16c2 = $createPurchaseViaController([['product_id' => $p16c2->id, 'quantity' => 4, 'cost_price' => 100]], '2026-10-15', 0, null, '2026-10-15 10:00:00');
    DB::table('purchases')->where('id', $pur16c2->id)->update(['date' => null]);
    $delNullPurDate = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur16c2->id]));
    DB::table('purchases')->where('id', $pur16c2->id)->update(['date' => '2026-10-15']);
    $p2Refl = new ReflectionMethod($purCtrl, 'validatePurchaseHistoricalIntegrity');
    $p2Refl->setAccessible(true);
    $purNullCreated = $pur16c2->fresh();
    $purNullCreated->created_at = null;
    $delNullPurCreated = $p2Refl->invoke($purCtrl, $purNullCreated, [$p16c2->id], 'delete', $userId);

    $p16c3 = $createSyntheticProduct('T16C Same Day Sale/Purchase', 'T16C-3', 5, 100);
    $pur16c3 = $createPurchaseViaController([['product_id' => $p16c3->id, 'quantity' => 4, 'cost_price' => 100]], '2026-10-20', 0, null, '2026-10-20 10:00:00');
    $ord16c3 = $createOrderViaController([['product_id' => $p16c3->id, 'quantity' => 1, 'price' => 100, 'selling_price' => 150]], '2026-10-20', '2026-10-20 12:00:00');
    $delSameDay = $purCtrl->PurchasesDelete(Request::create('/api/delete-purchases', 'POST', ['id' => $pur16c3->id]));

    $cliDry = Artisan::call('invoice:delete', ['order_no' => $ord16c3->order_no, '--dry-run' => true]);
    $stockAfterCliDry = (int) $p16c3->fresh()->quantity;
    $cliLive = Artisan::call('invoice:delete', ['order_no' => $ord16c3->order_no, '--force' => true]);
    $stockAfterCliLive = (int) $p16c3->fresh()->quantity;
    assertTest('T16C P2 edge blocks (malformed invoice_date, NULL pur date/created_at, same-day=422) & invoice:delete CLI dry-run/live',
        $delMalformedInv->getStatusCode() === 422
        && $delNullPurDate->getStatusCode() === 422
        && $delNullPurCreated->getStatusCode() === 422
        && $delSameDay->getStatusCode() === 422
        && $cliDry === 0 && $stockAfterCliDry === 8
        && $cliLive === 0 && $stockAfterCliLive === 9 && Order::find($ord16c3->id) === null
    );

    // T16D: Concurrent ProductUpdate() on two different door variants of same SKU (V35-LOW-1)
    $doorName = 'T16D Door Concurrent Lock';
    $doorLeft = Product::create([
        'product_name' => $doorName,
        'quantity' => '5',
        'cost_price' => '1000',
        'sell_price' => '1500',
        'status' => 'Active',
        'product_code' => json_encode(['T16D-DOOR']),
        'brand_id' => $brandId,
        'category_id' => $categoryId,
        'door_side' => 'Left Handed',
        'user_id' => $userId,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $doorRight = Product::create([
        'product_name' => $doorName,
        'quantity' => '5',
        'cost_price' => '1000',
        'sell_price' => '1500',
        'status' => 'Active',
        'product_code' => json_encode(['T16D-DOOR']),
        'brand_id' => $brandId,
        'category_id' => $categoryId,
        'door_side' => 'Right Handed',
        'user_id' => $userId,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $sig16d = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'sig16d_' . uniqid();
    $cleanupFiles[] = $sig16d;
    $w16d = spawnWorker('door_variant_update_holding_lock', [
        'ready_file' => $sig16d,
        'request_data' => [
            'id' => $doorRight->id,
            'product_name' => $doorName,
            'brand_id' => $brandId,
            'category_id' => $categoryId,
            'cost_price' => 1100,
            'sell_price' => 1600,
            'door_qty_left' => 8,
            'door_qty_right' => 8,
            'door_qty_both' => 0,
        ],
    ]);
    $gotSig16d = waitForSignalFile($sig16d, 5000);
    $t16d = microtime(true);
    $doorParentResp = $prodCtrl->ProductUpdate(Request::create('/api/product-update', 'POST', [
        'id' => $doorLeft->id,
        'product_name' => $doorName,
        'brand_id' => $brandId,
        'category_id' => $categoryId,
        'cost_price' => 1200,
        'sell_price' => 1700,
        'door_qty_left' => 11,
        'door_qty_right' => 12,
        'door_qty_both' => 0,
    ]));
    $elapsed16dMs = (microtime(true) - $t16d) * 1000;
    $res16d = closeWorker($w16d);
    $doorParentBody = $doorParentResp->getData(true);
    assertTest('T16D Concurrent door-variant ProductUpdate() on Left vs Right serialized without deadlock (' . round($elapsed16dMs) . 'ms)',
        $gotSig16d && $res16d['exit'] === 0
        && $doorParentResp->getStatusCode() === 200 && ($doorParentBody['status'] ?? '') === 'success'
        && (int) $doorLeft->fresh()->quantity === 11 && (int) $doorRight->fresh()->quantity === 12
    );

} finally {
    Purchase::flushEventListeners();
    Order::flushEventListeners();
    OrderDetails::flushEventListeners();
    \App\Models\ProductReturn::flushEventListeners();
    PurchaseReturn::flushEventListeners();
    Product::flushEventListeners();

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
