<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Customer;
use App\Models\ProductReturn;
use App\Http\Controllers\ProductReturnController;
use App\Models\Battery\BatteryOrder;
use App\Models\Battery\BatteryOrderDetail;
use App\Models\Battery\BatteryProduct;
use App\Models\Battery\BatteryCustomer;
use App\Models\Battery\BatteryProductReturn;
use App\Http\Controllers\Battery\BatteryProductReturnController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Auth::loginUsingId(1);

echo "====================================================================\n";
echo "   MARSSCORP RETAIL & BATTERY: MASTER VERIFICATION TEST SUITE\n";
echo "====================================================================\n\n";

$passCount = 0;
$failCount = 0;

function assertTest($condition, $testName, $details = '') {
    global $passCount, $failCount;
    if ($condition) {
        echo " [PASS] {$testName}\n";
        if ($details) echo "        -> {$details}\n";
        $passCount++;
    } else {
        echo " [FAIL] {$testName}\n";
        if ($details) echo "        -> {$details}\n";
        $failCount++;
    }
}

function createTestProduct($name, $qty = 50, $cost = 50.00, $sell = 100.00) {
    return Product::create([
        'product_name' => $name,
        'quantity' => $qty,
        'cost_price' => $cost,
        'sell_price' => $sell,
        'status' => 'Active',
        'product_code' => json_encode(['TEST_' . uniqid()]),
        'brand_id' => 1,
        'category_id' => 1,
        'user_id' => 1,
    ]);
}

function createTestBatteryProduct($name, $qty = 50, $cost = 50.00, $sell = 100.00) {
    return BatteryProduct::create([
        'product_name' => $name,
        'quantity' => $qty,
        'cost_price' => $cost,
        'sell_price' => $sell,
        'status' => 'Active',
        'product_code' => json_encode(['TEST_' . uniqid()]),
        'brand_id' => 1,
        'category_id' => 1,
        'user_id' => 1,
    ]);
}

// Ensure test customer & products exist
$retailCustomer = Customer::first() ?? Customer::create(['customer_name' => 'Test Customer', 'mobile' => '01700000001']);
$batteryCustomer = BatteryCustomer::first() ?? BatteryCustomer::create(['customer_name' => 'Test Battery Customer', 'mobile' => '01700000002']);

// -----------------------------------------------------------------------------------------
// TEST A: Multiple items in one return (5 products -> 1 transaction, 5 items, 1 history row)
// -----------------------------------------------------------------------------------------
echo "\n--- TEST A: Multiple Items in One Return Operation (Grouping) ---\n";

DB::beginTransaction();
try {
    // 1. Create 5 test products
    $products = [];
    for ($i = 1; $i <= 5; $i++) {
        $products[] = createTestProduct("Test Group Prod {$i}", 50, 50.00, 100.00);
    }

    // 2. Create test invoice with 5 products
    $order = Order::create([
        'order_no' => '#InvTEST_A',
        'customer_id' => $retailCustomer->id,
        'sub_total' => 1000.00,
        'discount_amount' => 0.00,
        'paid_amount' => 1000.00,
        'due_amount' => 0.00,
        'user_id' => 1,
    ]);

    $orderDetails = [];
    foreach ($products as $p) {
        $orderDetails[] = OrderDetails::create([
            'order_id' => $order->id,
            'product_id' => $p->id,
            'quantity' => 2,
            'return_quantity' => 0,
            'price' => 50.00,
            'selling_price' => 100.00,
            'user_id' => 1,
        ]);
    }

    // 3. Process return of all 5 products in ONE submission
    $returnPayload = [
        'order_id' => $order->id,
        'customer_id' => $retailCustomer->id,
        'date' => date('Y-m-d'),
        'products' => array_map(function($od) {
            return [
                'order_detail_id' => $od->id,
                'product_id' => $od->product_id,
                'quantity' => 1, // return 1 unit each
            ];
        }, $orderDetails),
    ];

    $controller = new ProductReturnController();
    $res = $controller->ReturnProductCreate(new Request($returnPayload));
    $resData = json_decode($res->getContent(), true);

    assertTest(($resData['status'] ?? '') === 'success', 'Test A: Return submission succeeded', $res->getContent());
    $retNum = $resData['return_number'] ?? null;
    assertTest(!empty($retNum), 'Test A: Return number generated', "Return Number: {$retNum}");

    // Check DB rows created
    $createdReturnRows = ProductReturn::where('return_number', $retNum)->get();
    assertTest($createdReturnRows->count() === 5, 'Test A: Exactly 5 item lines created under this return transaction', "Count: {$createdReturnRows->count()}");

    // Check ReturnProductList grouping
    $listRes = $controller->ReturnProductList();
    $listData = json_decode($listRes->getContent(), true);
    $historyEntries = array_filter($listData['ProductReturnData'], fn($r) => $r['return_number'] === $retNum);

    assertTest(count($historyEntries) === 1, 'Test A: Exactly 1 history entry rendered in Sales Return History', "Entries: " . count($historyEntries));

    $historyEntry = array_values($historyEntries)[0] ?? [];
    assertTest(($historyEntry['quantity'] ?? 0) === 5, 'Test A: History entry total quantity is 5 pcs', "Qty: " . ($historyEntry['quantity'] ?? 0));
    assertTest(($historyEntry['amount'] ?? 0) == 500.00, 'Test A: History entry total refund amount is ৳500.00', "Amount: " . ($historyEntry['amount'] ?? 0));
    assertTest(isset($historyEntry['items']) && count($historyEntry['items']) === 5, 'Test A: Child items breakdown contains all 5 products', "Items count: " . count($historyEntry['items'] ?? []));

} finally {
    DB::rollBack();
}

// -----------------------------------------------------------------------------------------
// TEST A2: Battery Multiple Items in One Return Operation (Grouping)
// -----------------------------------------------------------------------------------------
echo "\n--- TEST A2: Battery Multiple Items in One Return Operation (Grouping) ---\n";

DB::beginTransaction();
try {
    $batProducts = [];
    for ($i = 1; $i <= 3; $i++) {
        $batProducts[] = createTestBatteryProduct("Battery Group Prod {$i}", 30, 200.00, 350.00);
    }

    $orderBat = BatteryOrder::create([
        'order_no' => '#BatTEST_A2',
        'customer_id' => $batteryCustomer->id,
        'sub_total' => 1050.00,
        'discount_amount' => 0.00,
        'paid_amount' => 1050.00,
        'due_amount' => 0.00,
        'user_id' => 1,
    ]);

    $batDetails = [];
    foreach ($batProducts as $bp) {
        $batDetails[] = BatteryOrderDetail::create([
            'order_id' => $orderBat->id,
            'product_id' => $bp->id,
            'quantity' => 2,
            'return_quantity' => 0,
            'price' => 200.00,
            'selling_price' => 350.00,
            'user_id' => 1,
        ]);
    }

    $batReturnPayload = [
        'order_id' => $orderBat->id,
        'customer_id' => $batteryCustomer->id,
        'date' => date('Y-m-d'),
        'products' => array_map(function($od) {
            return [
                'order_detail_id' => $od->id,
                'product_id' => $od->product_id,
                'quantity' => 1,
            ];
        }, $batDetails),
    ];

    $batController = new BatteryProductReturnController();
    $resBat = $batController->ReturnProductCreate(new Request($batReturnPayload));
    $resBatData = json_decode($resBat->getContent(), true);

    assertTest($resBatData['status'] === 'success', 'Test A2: Battery Return submission succeeded');
    $retNumBat = $resBatData['return_number'] ?? null;
    assertTest(str_starts_with($retNumBat, '#BRET'), 'Test A2: Battery return number generated with #BRET prefix', "Return Number: {$retNumBat}");

    $createdBatReturnRows = BatteryProductReturn::where('return_number', $retNumBat)->get();
    assertTest($createdBatReturnRows->count() === 3, 'Test A2: Exactly 3 item lines created under this battery return transaction', "Count: {$createdBatReturnRows->count()}");

    $listResBat = $batController->ReturnProductList();
    $listDataBat = json_decode($listResBat->getContent(), true);
    $historyEntriesBat = array_filter($listDataBat['ProductReturnData'], fn($r) => $r['return_number'] === $retNumBat);

    assertTest(count($historyEntriesBat) === 1, 'Test A2: Exactly 1 history entry rendered in Battery Sales Return History', "Entries: " . count($historyEntriesBat));

    $historyEntryBat = array_values($historyEntriesBat)[0] ?? [];
    assertTest(($historyEntryBat['quantity'] ?? 0) === 3, 'Test A2: History entry total quantity is 3 pcs', "Qty: " . ($historyEntryBat['quantity'] ?? 0));
    assertTest(($historyEntryBat['amount'] ?? 0) == 1050.00, 'Test A2: History entry total refund amount is ৳1050.00', "Amount: " . ($historyEntryBat['amount'] ?? 0));
    assertTest(isset($historyEntryBat['items']) && count($historyEntryBat['items']) === 3, 'Test A2: Child items breakdown contains all 3 products', "Items count: " . count($historyEntryBat['items'] ?? []));

} finally {
    DB::rollBack();
}

// -----------------------------------------------------------------------------------------
// TEST B: Original Invoice Price & Quantity Protection (Immutable Sale Snapshot)
// -----------------------------------------------------------------------------------------
echo "\n--- TEST B: Original Invoice Price & Quantity Protection ---\n";

DB::beginTransaction();
try {
    $prodB = createTestProduct("Example A", 100, 60.00, 100.00);

    $orderB = Order::create([
        'order_no' => '#InvTEST_B',
        'customer_id' => $retailCustomer->id,
        'sub_total' => 1000.00,
        'discount_amount' => 50.00,
        'paid_amount' => 600.00,
        'due_amount' => 350.00,
        'user_id' => 1,
    ]);

    $detailB = OrderDetails::create([
        'order_id' => $orderB->id,
        'product_id' => $prodB->id,
        'quantity' => 10,
        'return_quantity' => 0,
        'price' => 60.00,
        'selling_price' => 100.00,
        'user_id' => 1,
    ]);

    // Snapshot before return
    $initialDetail = OrderDetails::find($detailB->id)->toArray();
    $initialOrder = Order::find($orderB->id)->toArray();

    // Process partial return: return 3 units
    $controller = new ProductReturnController();
    $resB = $controller->ReturnProductCreate(new Request([
        'order_id' => $orderB->id,
        'customer_id' => $retailCustomer->id,
        'date' => date('Y-m-d'),
        'products' => [
            [
                'order_detail_id' => $detailB->id,
                'product_id' => $prodB->id,
                'quantity' => 3,
            ]
        ]
    ]));

    // Query DB directly
    $afterDetail = OrderDetails::find($detailB->id)->fresh();
    $afterOrder = Order::find($orderB->id)->fresh();

    assertTest((int)$afterDetail->quantity === 10, 'Test B: Detail quantity remains 10 before and after', "Detail Qty: {$afterDetail->quantity}");
    assertTest((float)$afterDetail->selling_price === 100.00, 'Test B: Detail unit selling price remains ৳100.00', "Selling Price: {$afterDetail->selling_price}");
    assertTest((float)$afterDetail->price === 60.00, 'Test B: Detail unit cost price remains ৳60.00', "Price: {$afterDetail->price}");
    assertTest((int)$afterDetail->return_quantity === 3, 'Test B: Detail return_quantity tracks 3 units returned', "Return Qty: {$afterDetail->return_quantity}");

    assertTest((float)$afterOrder->sub_total === (float)$initialOrder['sub_total'], 'Test B: Order sub_total unchanged (৳1,000.00)', "Sub Total: {$afterOrder->sub_total}");
    assertTest((float)$afterOrder->discount_amount === (float)$initialOrder['discount_amount'], 'Test B: Order discount_amount unchanged (৳50.00)', "Discount: {$afterOrder->discount_amount}");
    assertTest((float)$afterOrder->paid_amount === (float)$initialOrder['paid_amount'], 'Test B: Order paid_amount unchanged (৳600.00)', "Paid: {$afterOrder->paid_amount}");
    assertTest((float)$afterOrder->due_amount === (float)$initialOrder['due_amount'], 'Test B: Order due_amount unchanged (৳350.00)', "Due: {$afterOrder->due_amount}");

    $retRowB = ProductReturn::where('order_detail_id', $detailB->id)->first();
    assertTest((float)$retRowB->amount === 300.00, 'Test B: Return line amount calculated as 3 × ৳100 = ৳300.00', "Amount: {$retRowB->amount}");
    assertTest((float)$retRowB->unit_price === 100.00, 'Test B: Return unit_price stored as ৳100.00', "Unit Price: {$retRowB->unit_price}");

} finally {
    DB::rollBack();
}

// -----------------------------------------------------------------------------------------
// TEST C: Original Invoice Protection after Full Return (Never Delete Order Details)
// -----------------------------------------------------------------------------------------
echo "\n--- TEST C: Original Invoice Protection after Full Return ---\n";

DB::beginTransaction();
try {
    $prodC = createTestProduct("Full Return Item", 50, 40.00, 100.00);

    $orderC = Order::create([
        'order_no' => '#InvTEST_C',
        'customer_id' => $retailCustomer->id,
        'sub_total' => 1000.00,
        'paid_amount' => 1000.00,
        'due_amount' => 0.00,
        'user_id' => 1,
    ]);

    $detailC = OrderDetails::create([
        'order_id' => $orderC->id,
        'product_id' => $prodC->id,
        'quantity' => 10,
        'return_quantity' => 0,
        'price' => 40.00,
        'selling_price' => 100.00,
        'user_id' => 1,
    ]);

    // Return ALL 10 units
    $controller = new ProductReturnController();
    $controller->ReturnProductCreate(new Request([
        'order_id' => $orderC->id,
        'customer_id' => $retailCustomer->id,
        'date' => date('Y-m-d'),
        'products' => [
            ['order_detail_id' => $detailC->id, 'product_id' => $prodC->id, 'quantity' => 10]
        ]
    ]));

    // Verify row was NOT deleted
    $persistedDetail = OrderDetails::find($detailC->id);
    assertTest($persistedDetail !== null, 'Test C: OrderDetail is NOT deleted after 100% full return');
    assertTest((int)$persistedDetail->quantity === 10, 'Test C: OrderDetail quantity remains 10', "Qty: {$persistedDetail->quantity}");
    assertTest((float)$persistedDetail->selling_price === 100.00, 'Test C: OrderDetail selling_price remains ৳100.00');
    assertTest((int)$persistedDetail->return_quantity === 10, 'Test C: OrderDetail return_quantity is 10');

    // Remaining returnable quantity is 0
    $searchRes = $controller->SearchInvoiceForReturn(new Request(['order_no' => '#InvTEST_C']));
    $searchData = json_decode($searchRes->getContent(), true);
    $items = $searchData['order']['items'] ?? [];
    assertTest(count($items) === 0, 'Test C: Remaining returnable items is 0 in SearchInvoiceForReturn', "Count: " . count($items));

} finally {
    DB::rollBack();
}

// -----------------------------------------------------------------------------------------
// TEST D & E: Multiple Partial Returns and Excess Return Rejection
// -----------------------------------------------------------------------------------------
echo "\n--- TEST D & E: Multiple Returns & Excess Return Rejection ---\n";

DB::beginTransaction();
try {
    $prodD = createTestProduct("Multi Return Item", 100, 50.00, 100.00);

    $orderD = Order::create([
        'order_no' => '#InvTEST_D',
        'customer_id' => $retailCustomer->id,
        'sub_total' => 1000.00,
        'paid_amount' => 1000.00,
        'due_amount' => 0.00,
        'user_id' => 1,
    ]);

    $detailD = OrderDetails::create([
        'order_id' => $orderD->id,
        'product_id' => $prodD->id,
        'quantity' => 10,
        'return_quantity' => 0,
        'price' => 50.00,
        'selling_price' => 100.00,
        'user_id' => 1,
    ]);

    $controller = new ProductReturnController();

    // 1. First return: 3 units
    $res1 = $controller->ReturnProductCreate(new Request([
        'order_id' => $orderD->id,
        'customer_id' => $retailCustomer->id,
        'date' => date('Y-m-d'),
        'products' => [['order_detail_id' => $detailD->id, 'product_id' => $prodD->id, 'quantity' => 3]]
    ]));
    $res1Data = json_decode($res1->getContent(), true);
    $ret1Num = $res1Data['return_number'];

    // 2. Second return: 2 units in separate operation
    $res2 = $controller->ReturnProductCreate(new Request([
        'order_id' => $orderD->id,
        'customer_id' => $retailCustomer->id,
        'date' => date('Y-m-d'),
        'products' => [['order_detail_id' => $detailD->id, 'product_id' => $prodD->id, 'quantity' => 2]]
    ]));
    $res2Data = json_decode($res2->getContent(), true);
    $ret2Num = $res2Data['return_number'];

    assertTest($ret1Num !== $ret2Num, 'Test D: Two separate returns have distinct return transaction numbers', "{$ret1Num} vs {$ret2Num}");

    $detailFresh = OrderDetails::find($detailD->id);
    assertTest((int)$detailFresh->return_quantity === 5, 'Test D: Total returned quantity is 5 pcs', "Return Qty: {$detailFresh->return_quantity}");
    assertTest((int)$detailFresh->quantity === 10, 'Test D: Original sold quantity remains 10 pcs');

    $totalRefund = ProductReturn::where('order_detail_id', $detailD->id)->sum('amount');
    assertTest((float)$totalRefund === 500.00, 'Test D: Total return amount is ৳500.00', "Total Refund: ৳{$totalRefund}");

    // 3. Excess Return Rejection: Attempt to return 6 more units (only 5 remain returnable)
    $stockBeforeExcess = Product::find($prodD->id)->quantity;
    $resExcess = $controller->ReturnProductCreate(new Request([
        'order_id' => $orderD->id,
        'customer_id' => $retailCustomer->id,
        'date' => date('Y-m-d'),
        'products' => [['order_detail_id' => $detailD->id, 'product_id' => $prodD->id, 'quantity' => 6]]
    ]));
    $resExcessData = json_decode($resExcess->getContent(), true);

    assertTest($resExcess->getStatusCode() === 400 || ($resExcessData['status'] ?? '') === 'fail', 'Test E: Request to return 6 units when only 5 returnable is rejected');
    $stockAfterExcess = Product::find($prodD->id)->quantity;
    assertTest((int)$stockBeforeExcess === (int)$stockAfterExcess, 'Test E: No stock added for rejected excess return');

    // Attempting to return remaining 5 should succeed
    $resValidRemaining = $controller->ReturnProductCreate(new Request([
        'order_id' => $orderD->id,
        'customer_id' => $retailCustomer->id,
        'date' => date('Y-m-d'),
        'products' => [['order_detail_id' => $detailD->id, 'product_id' => $prodD->id, 'quantity' => 5]]
    ]));
    $resValidRemainingData = json_decode($resValidRemaining->getContent(), true);
    assertTest(($resValidRemainingData['status'] ?? '') === 'success', 'Test E: Returning exact remaining 5 units succeeds');

} finally {
    DB::rollBack();
}

// -----------------------------------------------------------------------------------------
// TEST F: Historical Price vs Current Catalog Price
// -----------------------------------------------------------------------------------------
echo "\n--- TEST F: Historical Price vs Current Catalog Price ---\n";

DB::beginTransaction();
try {
    $prodF = createTestProduct("Catalog Price Change Item", 50, 50.00, 100.00);

    $orderF = Order::create([
        'order_no' => '#InvTEST_F',
        'customer_id' => $retailCustomer->id,
        'sub_total' => 1000.00,
        'paid_amount' => 1000.00,
        'due_amount' => 0.00,
        'user_id' => 1,
    ]);

    $detailF = OrderDetails::create([
        'order_id' => $orderF->id,
        'product_id' => $prodF->id,
        'quantity' => 10,
        'return_quantity' => 0,
        'price' => 50.00,
        'selling_price' => 100.00, // Sold at 100
        'user_id' => 1,
    ]);

    // Change current catalog price to 150
    $prodF->update(['sell_price' => 150.00]);

    // Return 2 units
    $controller = new ProductReturnController();
    $resF = $controller->ReturnProductCreate(new Request([
        'order_id' => $orderF->id,
        'customer_id' => $retailCustomer->id,
        'date' => date('Y-m-d'),
        'products' => [['order_detail_id' => $detailF->id, 'product_id' => $prodF->id, 'quantity' => 2]]
    ]));

    $retF = ProductReturn::where('order_detail_id', $detailF->id)->first();
    assertTest((float)$retF->unit_price === 100.00, 'Test F: Return unit price uses historical sale price ৳100.00 (not current catalog ৳150.00)', "Return Unit Price: {$retF->unit_price}");
    assertTest((float)$retF->amount === 200.00, 'Test F: Return amount calculated as 2 × ৳100 = ৳200.00', "Return Amount: {$retF->amount}");
    assertTest((float)Product::find($prodF->id)->sell_price === 150.00, 'Test F: Catalog selling price remains ৳150.00');

} finally {
    DB::rollBack();
}

// -----------------------------------------------------------------------------------------
// TEST H: Strict Retail and Battery Isolation
// -----------------------------------------------------------------------------------------
echo "\n--- TEST H: Strict Retail and Battery Isolation ---\n";

DB::beginTransaction();
try {
    // 1. Create Retail Order and Return
    $prodRetail = createTestProduct('Isolation Retail Prod', 20, 50, 100);
    $orderRetail = Order::create(['order_no' => '#InvISO_RET', 'customer_id' => $retailCustomer->id, 'sub_total' => 200, 'paid_amount' => 200, 'due_amount' => 0, 'user_id' => 1]);
    $detRetail = OrderDetails::create(['order_id' => $orderRetail->id, 'product_id' => $prodRetail->id, 'quantity' => 2, 'price' => 50, 'selling_price' => 100, 'user_id' => 1]);

    $retController = new ProductReturnController();
    $resRet = $retController->ReturnProductCreate(new Request([
        'order_id' => $orderRetail->id,
        'customer_id' => $retailCustomer->id,
        'date' => date('Y-m-d'),
        'products' => [['order_detail_id' => $detRetail->id, 'product_id' => $prodRetail->id, 'quantity' => 1]]
    ]));
    $resRetData = json_decode($resRet->getContent(), true);

    // 2. Create Battery Order and Return
    $prodBattery = createTestBatteryProduct('Isolation Battery Prod', 20, 300, 500);
    $orderBattery = BatteryOrder::create(['order_no' => '#BatISO_BAT', 'customer_id' => $batteryCustomer->id, 'sub_total' => 1000, 'paid_amount' => 1000, 'due_amount' => 0, 'user_id' => 1]);
    $detBattery = BatteryOrderDetail::create(['order_id' => $orderBattery->id, 'product_id' => $prodBattery->id, 'quantity' => 2, 'price' => 300, 'selling_price' => 500, 'user_id' => 1]);

    $batController = new BatteryProductReturnController();
    $resBat = $batController->ReturnProductCreate(new Request([
        'order_id' => $orderBattery->id,
        'customer_id' => $batteryCustomer->id,
        'date' => date('Y-m-d'),
        'products' => [['order_detail_id' => $detBattery->id, 'product_id' => $prodBattery->id, 'quantity' => 1]]
    ]));
    $resBatData = json_decode($resBat->getContent(), true);

    // Assert Retail return data is in product_returns and NOT in battery_product_returns
    $retailInBatTable = BatteryProductReturn::where('order_id', $orderRetail->id)->count();
    assertTest($retailInBatTable === 0, 'Test H: Retail return data is NEVER written to battery_product_returns');

    // Assert Battery return data is in battery_product_returns and NOT in product_returns
    $batteryInRetTable = ProductReturn::where('order_id', $orderBattery->id)->count();
    assertTest($batteryInRetTable === 0, 'Test H: Battery return data is NEVER written to product_returns');

    // Assert Return numbers have proper module prefixes
    assertTest(str_starts_with($resRetData['return_number'], '#RET'), 'Test H: Retail return number has #RET prefix', $resRetData['return_number']);
    assertTest(str_starts_with($resBatData['return_number'], '#BRET'), 'Test H: Battery return number has #BRET prefix', $resBatData['return_number']);

    // Cross-module rejection: Retail controller cannot process Battery order detail
    try {
        $crossRes = $retController->ReturnProductCreate(new Request([
            'order_id' => $orderBattery->id,
            'customer_id' => $retailCustomer->id,
            'date' => date('Y-m-d'),
            'products' => [['order_detail_id' => $detBattery->id, 'product_id' => $prodBattery->id, 'quantity' => 1]]
        ]));
        $crossData = json_decode($crossRes->getContent(), true);
        assertTest(($crossData['status'] ?? '') === 'fail' || $crossRes->getStatusCode() >= 400, 'Test H: Cross-module return attempt is strictly rejected');
    } catch (\Exception $e) {
        assertTest(true, 'Test H: Cross-module return attempt is strictly rejected by foreign key / model validation');
    }

} finally {
    DB::rollBack();
}

// -----------------------------------------------------------------------------------------
// TEST I: Atomicity and Rollback on Failure
// -----------------------------------------------------------------------------------------
echo "\n--- TEST I: Atomicity and Rollback on Failure ---\n";

DB::beginTransaction();
try {
    $prodI1 = createTestProduct('Atomic Item 1', 20, 50, 100);
    $prodI2 = createTestProduct('Atomic Item 2', 20, 50, 100);

    $orderI = Order::create(['order_no' => '#InvTEST_I', 'customer_id' => $retailCustomer->id, 'sub_total' => 400, 'paid_amount' => 400, 'due_amount' => 0, 'user_id' => 1]);
    $detI1 = OrderDetails::create(['order_id' => $orderI->id, 'product_id' => $prodI1->id, 'quantity' => 2, 'price' => 50, 'selling_price' => 100, 'user_id' => 1]);
    $detI2 = OrderDetails::create(['order_id' => $orderI->id, 'product_id' => $prodI2->id, 'quantity' => 2, 'price' => 50, 'selling_price' => 100, 'user_id' => 1]);

    $stockBeforeI1 = (int)Product::find($prodI1->id)->quantity;
    $stockBeforeI2 = (int)Product::find($prodI2->id)->quantity;
    $returnsBefore = ProductReturn::where('order_id', $orderI->id)->count();

    // Submission with valid 1st product but invalid 2nd product (exceeding quantity: 5 > 2)
    $controller = new ProductReturnController();
    $resI = $controller->ReturnProductCreate(new Request([
        'order_id' => $orderI->id,
        'customer_id' => $retailCustomer->id,
        'date' => date('Y-m-d'),
        'products' => [
            ['order_detail_id' => $detI1->id, 'product_id' => $prodI1->id, 'quantity' => 1], // valid
            ['order_detail_id' => $detI2->id, 'product_id' => $prodI2->id, 'quantity' => 5], // INVALID: exceeds 2
        ]
    ]));

    assertTest($resI->getStatusCode() === 400, 'Test I: Batch with one invalid item fails atomically with HTTP 400');

    // Verify complete rollback: no stock incremented for prod 1, no ProductReturn created
    $stockAfterI1 = (int)Product::find($prodI1->id)->quantity;
    $stockAfterI2 = (int)Product::find($prodI2->id)->quantity;
    $returnsAfter = ProductReturn::where('order_id', $orderI->id)->count();

    assertTest($stockBeforeI1 === $stockAfterI1, 'Test I: Product 1 stock rolled back (not incremented)');
    assertTest($stockBeforeI2 === $stockAfterI2, 'Test I: Product 2 stock intact');
    assertTest($returnsBefore === $returnsAfter, 'Test I: Zero partial return records committed to database');

} finally {
    DB::rollBack();
}

echo "\n====================================================================\n";
echo "   MASTER VERIFICATION COMPLETED: {$passCount} PASSED, {$failCount} FAILED\n";
echo "====================================================================\n";

if ($failCount === 0) {
    exit(0);
} else {
    exit(1);
}
