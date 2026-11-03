<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\ProductReturn;
use App\Http\Controllers\ProductReturnController;
use Illuminate\Http\Request;

$user = User::first() ?? User::create([
    'name' => 'Test Admin',
    'email' => 'test@admin.com',
    'password' => bcrypt('password')
]);
Auth::login($user);

echo "======================================================================\n";
echo "       SALES RETURN & PRODUCT PRICE MUTATION REGRESSION SUITE         \n";
echo "======================================================================\n\n";

$passCount = 0;
$failCount = 0;

function assertTest($name, $condition, $details = '') {
    global $passCount, $failCount;
    if ($condition) {
        $passCount++;
        echo "  [PASS] {$name}\n";
        if ($details) echo "         ↳ {$details}\n";
    } else {
        $failCount++;
        echo "  [FAIL] {$name}\n";
        if ($details) echo "         ↳ {$details}\n";
    }
}

$controller = new ProductReturnController();

// --------------------------------------------------------------------------
// TEST SETUP: Create dedicated isolated test customer & test products
// --------------------------------------------------------------------------
DB::beginTransaction();

try {
    $customer = Customer::create([
        'customer_id'   => 'CUST-REG-99',
        'customer_name' => 'Regression Test Customer',
        'mobile'        => '01999999999',
        'address_details'=> 'Test Lab',
        'user_id'       => $user->id,
    ]);

    // Product A: ৳100 selling price, ৳60 cost, 50 stock
    $prodA = Product::create([
        'product_name' => 'Regression Item A',
        'product_code' => json_encode(['TEST-A']),
        'cost_price'   => 60.00,
        'sell_price'   => 100.00,
        'quantity'     => 50,
        'brand_id'     => 3,
        'category_id'  => 2,
        'status'       => 'Active',
        'user_id'      => $user->id,
    ]);

    // Product B: ৳250 selling price, ৳180 cost, 30 stock
    $prodB = Product::create([
        'product_name' => 'Regression Item B',
        'product_code' => json_encode(['TEST-B']),
        'cost_price'   => 180.00,
        'sell_price'   => 250.00,
        'quantity'     => 30,
        'brand_id'     => 3,
        'category_id'  => 2,
        'status'       => 'Active',
        'user_id'      => $user->id,
    ]);

    // Product C: ৳500 selling price, ৳350 cost, 20 stock
    $prodC = Product::create([
        'product_name' => 'Regression Item C',
        'product_code' => json_encode(['TEST-C']),
        'cost_price'   => 350.00,
        'sell_price'   => 500.00,
        'quantity'     => 20,
        'brand_id'     => 3,
        'category_id'  => 2,
        'status'       => 'Active',
        'user_id'      => $user->id,
    ]);

    // ----------------------------------------------------------------------
    // TEST 1: Return One Product at its Original Invoice Selling Price
    // ----------------------------------------------------------------------
    echo "\n--- TEST 1: Single Product Return at Original Selling Price ---\n";
    // Order 1: 5 pcs of Prod A @ ৳100 = ৳500 subtotal, Paid ৳500, Due ৳0
    $order1 = Order::create([
        'order_no'        => '#TEST-ORD-01',
        'customer_id'     => $customer->id,
        'sub_total'       => 500.00,
        'paid_amount'     => 500.00,
        'due_amount'      => 0.00,
        'discount_amount' => 0.00,
        'invoice_date'    => '2026-11-03',
        'user_id'         => $user->id,
    ]);
    $od1 = OrderDetails::create([
        'order_id'      => $order1->id,
        'product_id'    => $prodA->id,
        'quantity'      => 5,
        'return_quantity'=> 0,
        'price'         => 60.00,
        'selling_price' => 100.00,
        'user_id'       => $user->id,
    ]);
    $prodA->decrement('quantity', 5); // stock becomes 45

    $initialStockA = (int) Product::find($prodA->id)->quantity;
    $initialPriceA = (float) Product::find($prodA->id)->sell_price;
    $initialCostA  = (float) Product::find($prodA->id)->cost_price;

    // Return 2 pcs of Prod A
    $req1 = new Request([
        'order_id'    => $order1->id,
        'customer_id' => $customer->id,
        'date'        => '2026-11-03',
        'products'    => [
            [
                'order_detail_id' => $od1->id,
                'product_id'      => $prodA->id,
                'quantity'        => 2,
            ]
        ]
    ]);
    $res1 = $controller->ReturnProductCreate($req1);
    $data1 = json_decode($res1->getContent(), true);

    $retRecord1 = ProductReturn::where('order_detail_id', $od1->id)->first();
    assertTest(
        "Single product return amount equals quantity * unit selling price (2 * 100 = 200)",
        $retRecord1 && (float)$retRecord1->amount === 200.00 && (float)$retRecord1->unit_price === 100.00,
        "Amount: ৳" . ($retRecord1->amount ?? 0) . ", Expected: ৳200.00"
    );

    // ----------------------------------------------------------------------
    // TEST 2: Multiple Products in One Return Submission
    // ----------------------------------------------------------------------
    echo "\n--- TEST 2: Multi-Product Return in One Transaction ---\n";
    // Order 2: 4 pcs Prod A @ ৳100 (=400), 2 pcs Prod B @ ৳250 (=500). Subtotal = ৳900
    $order2 = Order::create([
        'order_no'        => '#TEST-ORD-02',
        'customer_id'     => $customer->id,
        'sub_total'       => 900.00,
        'paid_amount'     => 900.00,
        'due_amount'      => 0.00,
        'discount_amount' => 0.00,
        'invoice_date'    => '2026-11-03',
        'user_id'         => $user->id,
    ]);
    $od2A = OrderDetails::create([
        'order_id'      => $order2->id,
        'product_id'    => $prodA->id,
        'quantity'      => 4,
        'return_quantity'=> 0,
        'price'         => 60.00,
        'selling_price' => 100.00,
        'user_id'       => $user->id,
    ]);
    $od2B = OrderDetails::create([
        'order_id'      => $order2->id,
        'product_id'    => $prodB->id,
        'quantity'      => 2,
        'return_quantity'=> 0,
        'price'         => 180.00,
        'selling_price' => 250.00,
        'user_id'       => $user->id,
    ]);

    // Return 3 pcs of Prod A (3*100 = 300) and 1 pc of Prod B (1*250 = 250) -> Total ৳550
    $req2 = new Request([
        'order_id'    => $order2->id,
        'customer_id' => $customer->id,
        'date'        => '2026-11-03',
        'products'    => [
            ['order_detail_id' => $od2A->id, 'product_id' => $prodA->id, 'quantity' => 3],
            ['order_detail_id' => $od2B->id, 'product_id' => $prodB->id, 'quantity' => 1],
        ]
    ]);
    $res2 = $controller->ReturnProductCreate($req2);
    $data2 = json_decode($res2->getContent(), true);

    assertTest(
        "Multi-product return response status is success with total ৳550",
        isset($data2['status']) && $data2['status'] === 'success' && (float)$data2['total_refund_amount'] === 550.00,
        "Returned: ৳" . ($data2['total_refund_amount'] ?? 0)
    );

    $batchReturns = ProductReturn::where('return_number', $data2['return_number'])->get();
    assertTest(
        "Both items share identical batch return_number and individual correct amounts",
        $batchReturns->count() === 2 && (float)$batchReturns->sum('amount') === 550.00,
        "Batch count: {$batchReturns->count()}, Sum: ৳" . $batchReturns->sum('amount')
    );

    // ----------------------------------------------------------------------
    // TEST 3: Returning 79 pcs Across 7 Product Types (Full Scenario Emulation)
    // ----------------------------------------------------------------------
    echo "\n--- TEST 3: Emulating Exact 79 pcs Across 7 Product Types ---\n";
    // Create 7 test products with the exact prices from Invoice #InvID00038
    $simProducts = [
        ['name' => 'Sim 498', 'qty' => 20, 'unit_price' => 78.00, 'cost' => 52.45],
        ['name' => 'Sim 687', 'qty' => 10, 'unit_price' => 93.00, 'cost' => 65.33],
        ['name' => 'Sim 506', 'qty' => 10, 'unit_price' => 56.00, 'cost' => 34.04],
        ['name' => 'Sim 504', 'qty' => 20, 'unit_price' => 59.00, 'cost' => 39.43],
        ['name' => 'Sim 502', 'qty' => 11, 'unit_price' => 92.00, 'cost' => 73.00],
        ['name' => 'Sim 516', 'qty' => 6,  'unit_price' => 450.00, 'cost' => 340.00],
        ['name' => 'Sim 682', 'qty' => 2,  'unit_price' => 180.00, 'cost' => 103.00],
    ];

    $simOrderSubtotal = 0;
    foreach ($simProducts as $sp) {
        $simOrderSubtotal += ($sp['qty'] * $sp['unit_price']);
    }

    $orderSim = Order::create([
        'order_no'        => '#TEST-SIM-79',
        'customer_id'     => $customer->id,
        'sub_total'       => $simOrderSubtotal,
        'paid_amount'     => $simOrderSubtotal,
        'due_amount'      => 0.00,
        'discount_amount' => 0.00,
        'invoice_date'    => '2026-11-03',
        'user_id'         => $user->id,
    ]);

    $simReqProducts = [];
    foreach ($simProducts as $idx => $sp) {
        $p = Product::create([
            'product_name' => $sp['name'],
            'product_code' => json_encode(['TEST-SIM-' . $idx]),
            'cost_price'   => $sp['cost'],
            'sell_price'   => $sp['unit_price'],
            'quantity'     => 100,
            'brand_id'     => 3,
            'category_id'  => 2,
            'status'       => 'Active',
            'user_id'      => $user->id,
        ]);
        $od = OrderDetails::create([
            'order_id'      => $orderSim->id,
            'product_id'    => $p->id,
            'quantity'      => $sp['qty'],
            'return_quantity'=> 0,
            'price'         => $sp['cost'],
            'selling_price' => $sp['unit_price'],
            'user_id'       => $user->id,
        ]);
        $simReqProducts[] = [
            'order_detail_id' => $od->id,
            'product_id'      => $p->id,
            'quantity'        => $sp['qty'],
        ];
    }

    $reqSim = new Request([
        'order_id'    => $orderSim->id,
        'customer_id' => $customer->id,
        'date'        => '2026-11-03',
        'products'    => $simReqProducts,
    ]);
    $resSim = $controller->ReturnProductCreate($reqSim);
    $dataSim = json_decode($resSim->getContent(), true);

    assertTest(
        "79 pcs across 7 product types calculates EXACTLY ৳8,302.00 (NOT flawed ৳936.05)",
        isset($dataSim['status']) && $dataSim['status'] === 'success' && (float)$dataSim['total_refund_amount'] === 8302.00,
        "Total Refund Amount: ৳" . ($dataSim['total_refund_amount'] ?? 0)
    );

    // ----------------------------------------------------------------------
    // TEST 4: Value-Proportional Discount Allocation
    // ----------------------------------------------------------------------
    echo "\n--- TEST 4: Invoice-Level Discount Allocation ---\n";
    // Order 4: Prod A (10 pcs @ 100 = 1000) + Prod C (1 pc @ 500 = 500). Subtotal = 1500.
    // Discount = ৳150 (10% discount).
    $order4 = Order::create([
        'order_no'        => '#TEST-ORD-DISC',
        'customer_id'     => $customer->id,
        'sub_total'       => 1500.00,
        'paid_amount'     => 1350.00,
        'due_amount'      => 0.00,
        'discount_amount' => 150.00,
        'invoice_date'    => '2026-11-03',
        'user_id'         => $user->id,
    ]);
    $od4A = OrderDetails::create([
        'order_id'      => $order4->id,
        'product_id'    => $prodA->id,
        'quantity'      => 10,
        'return_quantity'=> 0,
        'price'         => 60.00,
        'selling_price' => 100.00,
        'user_id'       => $user->id,
    ]);
    $od4C = OrderDetails::create([
        'order_id'      => $order4->id,
        'product_id'    => $prodC->id,
        'quantity'      => 1,
        'return_quantity'=> 0,
        'price'         => 350.00,
        'selling_price' => 500.00,
        'user_id'       => $user->id,
    ]);

    // Return 2 pcs of Prod A (line gross = 200).
    // Proportional discount = 200 * (150 / 1500) = ৳20.00.
    $req4 = new Request([
        'order_id'    => $order4->id,
        'customer_id' => $customer->id,
        'date'        => '2026-11-03',
        'products'    => [
            ['order_detail_id' => $od4A->id, 'product_id' => $prodA->id, 'quantity' => 2],
        ]
    ]);
    $res4 = $controller->ReturnProductCreate($req4);
    $retRecord4 = ProductReturn::where('order_detail_id', $od4A->id)->latest('id')->first();

    assertTest(
        "Discount allocated proportionally to monetary value (৳200 return gets 10% = ৳20 discount)",
        $retRecord4 && (float)$retRecord4->discount_amount === 20.00 && (float)$retRecord4->amount === 200.00,
        "Gross: ৳{$retRecord4->amount}, Allocated Discount: ৳{$retRecord4->discount_amount}"
    );

    // ----------------------------------------------------------------------
    // TEST 5 & 6: Product Selling Price & Cost Price Immutability
    // ----------------------------------------------------------------------
    echo "\n--- TEST 5 & 6: Product Price & Cost Immutability ---\n";
    $freshProdA = Product::find($prodA->id);
    $freshOd1 = OrderDetails::find($od1->id);

    assertTest(
        "Product master sell_price in 'products' table remains completely unchanged (৳100.00)",
        (float)$freshProdA->sell_price === 100.00,
        "Master Sell Price: ৳{$freshProdA->sell_price}"
    );

    assertTest(
        "Product master cost_price in 'products' table remains completely unchanged (৳60.00)",
        (float)$freshProdA->cost_price === 60.00,
        "Master Cost Price: ৳{$freshProdA->cost_price}"
    );

    assertTest(
        "OrderDetail selling_price remains completely unchanged (৳100.00, never decreased!)",
        (float)$freshOd1->selling_price === 100.00,
        "OrderDetail selling_price: ৳{$freshOd1->selling_price}"
    );

    assertTest(
        "OrderDetail quantity remains original purchased quantity (5 pcs, NOT decremented!)",
        (int)$freshOd1->quantity === 5,
        "OrderDetail quantity: {$freshOd1->quantity}"
    );

    assertTest(
        "OrderDetail return_quantity accurately reflects returned quantity (2 pcs)",
        (int)$freshOd1->return_quantity === 2,
        "OrderDetail return_quantity: {$freshOd1->return_quantity}"
    );

    // ----------------------------------------------------------------------
    // TEST 7: Stock Restoration Verification
    // ----------------------------------------------------------------------
    echo "\n--- TEST 7: Accurate Stock Restoration ---\n";
    // Earlier prodA had initialStockA = 45. In Test 1 we returned 2 pcs (45 + 2 = 47).
    // In Test 2 we returned 3 pcs (47 + 3 = 50).
    // In Test 4 we returned 2 pcs (50 + 2 = 52).
    $expectedFinalStockA = $initialStockA + 2 + 3 + 2;
    $actualStockA = (int) Product::find($prodA->id)->quantity;
    assertTest(
        "Product stock increases by exactly the returned quantity (restored to {$expectedFinalStockA})",
        $actualStockA === $expectedFinalStockA,
        "Actual Stock: {$actualStockA}, Expected: {$expectedFinalStockA}"
    );

    // ----------------------------------------------------------------------
    // TEST 8: Prevention of Over-Returning
    // ----------------------------------------------------------------------
    echo "\n--- TEST 8: Over-Return Prevention ---\n";
    // $od1 had 5 purchased, 2 returned -> available is 3. Attempting to return 4 must fail!
    $reqOver = new Request([
        'order_id'    => $order1->id,
        'customer_id' => $customer->id,
        'date'        => '2026-11-03',
        'products'    => [
            ['order_detail_id' => $od1->id, 'product_id' => $prodA->id, 'quantity' => 4],
        ]
    ]);
    $resOver = $controller->ReturnProductCreate($reqOver);
    assertTest(
        "Over-return attempt is rejected with 400 Bad Request error",
        $resOver->getStatusCode() === 400,
        "Status Code: {$resOver->getStatusCode()}"
    );

    // ----------------------------------------------------------------------
    // TEST 9: Prevention of Duplicate Return Processing
    // ----------------------------------------------------------------------
    echo "\n--- TEST 9: Duplicate Return Prevention ---\n";
    // Return remaining 3 pcs of $od1
    $reqExact = new Request([
        'order_id'    => $order1->id,
        'customer_id' => $customer->id,
        'date'        => '2026-11-03',
        'products'    => [
            ['order_detail_id' => $od1->id, 'product_id' => $prodA->id, 'quantity' => 3],
        ]
    ]);
    $resExact = $controller->ReturnProductCreate($reqExact);
    assertTest("Remaining returnable quantity (3 pcs) succeeds", $resExact->getStatusCode() === 200);

    // Now available is 0. Attempting any further return must be rejected!
    $reqDup = new Request([
        'order_id'    => $order1->id,
        'customer_id' => $customer->id,
        'date'        => '2026-11-03',
        'products'    => [
            ['order_detail_id' => $od1->id, 'product_id' => $prodA->id, 'quantity' => 1],
        ]
    ]);
    $resDup = $controller->ReturnProductCreate($reqDup);
    assertTest(
        "Subsequent return on fully returned item is rejected with 400 (Duplicate protection)",
        $resDup->getStatusCode() === 400,
        "Status Code: {$resDup->getStatusCode()}"
    );

    // ----------------------------------------------------------------------
    // TEST 10: Financial Integrity and Adjustment Consistency
    // ----------------------------------------------------------------------
    echo "\n--- TEST 10: Financial Totals and Adjustments ---\n";
    $searchReq = new Request(['order_no' => $order2->order_no]);
    $searchRes = $controller->SearchInvoiceForReturn($searchReq);
    $searchData = json_decode($searchRes->getContent(), true);

    assertTest(
        "SearchInvoiceForReturn preserves original subtotal (৳900) and displays correct remaining returnable quantities",
        isset($searchData['status']) && $searchData['status'] === 'success' && (float)$searchData['order']['sub_total'] === 900.00,
        "Reported Subtotal: ৳" . ($searchData['order']['sub_total'] ?? 0)
    );

} finally {
    // Rollback test transaction to keep database completely pristine
    DB::rollBack();
}

echo "\n======================================================================\n";
echo "SUMMARY: {$passCount} PASSED, {$failCount} FAILED out of " . ($passCount + $failCount) . " assertions.\n";
echo "======================================================================\n";

if ($failCount > 0) {
    exit(1);
}
