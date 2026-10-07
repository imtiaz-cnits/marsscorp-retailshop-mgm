<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

$user = User::first();
if (!$user) {
    die("No user found in database for authentication.\n");
}
Sanctum::actingAs($user, ['*']);

$results = [];

function makeApiCall($app, $method, $uri, $params = [], $headers = []) {
    $server = [
        'HTTP_ACCEPT' => 'application/json',
    ];
    foreach ($headers as $k => $v) {
        $server['HTTP_' . strtoupper(str_replace('-', '_', $k))] = $v;
    }
    $req = Illuminate\Http\Request::create($uri, $method, $params, [], [], $server);
    $res = $app->handle($req);
    $json = json_decode($res->getContent(), true);
    return [
        'status_code' => $res->getStatusCode(),
        'body' => $json,
        'raw' => $res->getContent()
    ];
}

echo "========================================================\n";
echo "   PHASE 5: FINAL UI INTEGRATION SMOKE TEST RUNNER      \n";
echo "========================================================\n\n";

// Helper: Ensure valid base brand & category exist
$baseBrand = DB::table('battery_brands')->first();
if (!$baseBrand) {
    $baseBrandId = DB::table('battery_brands')->insertGetId([
        'name' => 'Default Battery Brand',
        'user_id' => $user->id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
} else {
    $baseBrandId = $baseBrand->id;
}

$baseCat = DB::table('battery_categories')->first();
if (!$baseCat) {
    $baseCatId = DB::table('battery_categories')->insertGetId([
        'name' => 'Default Battery Category',
        'user_id' => $user->id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
} else {
    $baseCatId = $baseCat->id;
}

// -----------------------------------------------------------------------------
// Flow 1: Product (list, create, edit, delete)
// -----------------------------------------------------------------------------
echo "[1] Testing Product Flow...";
try {
    // 1. List
    $list = makeApiCall($app, 'GET', '/api/battery/product-list');
    if ($list['status_code'] !== 200 || !isset($list['body']['ProductData'])) {
        throw new Exception("Product list failed: status {$list['status_code']}");
    }

    // 2. Create
    $uniqueCode = 'TEST-BAT-' . time();
    $create = makeApiCall($app, 'POST', '/api/battery/create-product', [
        'product_name' => 'Smoke Test Battery 100Ah',
        'product_code' => json_encode([$uniqueCode]),
        'brand_id'     => $baseBrandId,
        'category_id'  => $baseCatId,
        'cost_price'   => 8500,
        'sell_price'   => 10500,
        'quantity'     => 15,
        'status'       => 'Active',
    ]);
    if ($create['status_code'] !== 200 || ($create['body']['status'] ?? '') !== 'success') {
        throw new Exception("Product create failed: " . ($create['body']['message'] ?? $create['raw']));
    }
    $prodId = $create['body']['product']['id'] ?? $create['body']['products'][0]['id'] ?? null;
    if (!$prodId) {
        $p = DB::table('battery_products')->where('product_name', 'Smoke Test Battery 100Ah')->first();
        $prodId = $p ? $p->id : null;
    }

    // 3. Edit (By-ID and Update)
    $byId = makeApiCall($app, 'POST', '/api/battery/product-by-id', ['id' => $prodId]);
    if ($byId['status_code'] !== 200) {
        throw new Exception("Product by-id failed: status {$byId['status_code']}");
    }

    $update = makeApiCall($app, 'POST', '/api/battery/update-product', [
        'id'           => $prodId,
        'product_name' => 'Smoke Test Battery 100Ah Updated',
        'brand_id'     => $baseBrandId,
        'category_id'  => $baseCatId,
        'cost_price'   => 8700,
        'sell_price'   => 10800,
        'quantity'     => 20,
    ]);
    if ($update['status_code'] !== 200 || ($update['body']['status'] ?? '') !== 'success') {
        throw new Exception("Product update failed: " . ($update['body']['message'] ?? $update['raw']));
    }

    // 4. Delete
    $del = makeApiCall($app, 'POST', '/api/battery/delete-product', ['id' => $prodId]);
    if ($del['status_code'] !== 200 || ($del['body']['status'] ?? '') !== 'success') {
        throw new Exception("Product delete failed: " . ($del['body']['message'] ?? $del['raw']));
    }

    $results['1. Product'] = 'PASS';
    echo " PASS\n";
} catch (Exception $e) {
    $results['1. Product'] = 'FAIL: ' . $e->getMessage();
    echo " FAIL: " . $e->getMessage() . "\n";
}

// -----------------------------------------------------------------------------
// Flow 2: Brand (list, create, edit, delete)
// -----------------------------------------------------------------------------
echo "[2] Testing Brand Flow...";
try {
    // 1. List
    $list = makeApiCall($app, 'GET', '/api/battery/brand-list');
    if ($list['status_code'] !== 200 || !isset($list['body']['BrandData'])) {
        throw new Exception("Brand list failed: status {$list['status_code']}");
    }

    // 2. Create
    $brandName = 'SmokeBrand_' . time();
    $create = makeApiCall($app, 'POST', '/api/battery/create-brand', [
        'name' => $brandName,
    ]);
    if ($create['status_code'] !== 200 || ($create['body']['status'] ?? '') !== 'success') {
        throw new Exception("Brand create failed: " . ($create['body']['message'] ?? $create['raw']));
    }
    $brandId = $create['body']['newBrandId'] ?? null;
    if (!$brandId) {
        $b = DB::table('battery_brands')->where('name', $brandName)->first();
        $brandId = $b ? $b->id : null;
    }

    // 3. Edit (By-ID and Update)
    $byId = makeApiCall($app, 'POST', '/api/battery/brand-by-id', ['id' => $brandId]);
    if ($byId['status_code'] !== 200) {
        throw new Exception("Brand by-id failed: status {$byId['status_code']}");
    }

    $update = makeApiCall($app, 'POST', '/api/battery/update-brand', [
        'id'   => $brandId,
        'name' => $brandName . '_Upd',
    ]);
    if ($update['status_code'] !== 200 || ($update['body']['status'] ?? '') !== 'success') {
        throw new Exception("Brand update failed: " . ($update['body']['message'] ?? $update['raw']));
    }

    // 4. Delete
    $del = makeApiCall($app, 'POST', '/api/battery/delete-brand', ['id' => $brandId]);
    if ($del['status_code'] !== 200 || ($del['body']['status'] ?? '') !== 'success') {
        throw new Exception("Brand delete failed: " . ($del['body']['message'] ?? $del['raw']));
    }

    $results['2. Brand'] = 'PASS';
    echo " PASS\n";
} catch (Exception $e) {
    $results['2. Brand'] = 'FAIL: ' . $e->getMessage();
    echo " FAIL: " . $e->getMessage() . "\n";
}

// -----------------------------------------------------------------------------
// Flow 3: Category / Sub-category (list, create/edit/delete, category filtering)
// -----------------------------------------------------------------------------
echo "[3] Testing Category/Sub-category Flow...";
try {
    // 1. List
    $catList = makeApiCall($app, 'GET', '/api/battery/category-list');
    if ($catList['status_code'] !== 200 || !isset($catList['body']['CategoryData'])) {
        throw new Exception("Category list failed: status {$catList['status_code']}");
    }

    // 2. Create Category
    $catName = 'SmokeCat_' . time();
    $createCat = makeApiCall($app, 'POST', '/api/battery/create-category', [
        'name' => $catName,
    ]);
    if ($createCat['status_code'] !== 200 || ($createCat['body']['status'] ?? '') !== 'success') {
        throw new Exception("Category create failed: " . ($createCat['body']['message'] ?? $createCat['raw']));
    }
    $catId = $createCat['body']['newCategoryId'] ?? null;
    if (!$catId) {
        $c = DB::table('battery_categories')->where('name', $catName)->first();
        $catId = $c ? $c->id : null;
    }

    // 3. Edit Category
    $updateCat = makeApiCall($app, 'POST', '/api/battery/update-category', [
        'id'   => $catId,
        'name' => $catName . '_Upd',
    ]);
    if ($updateCat['status_code'] !== 200 || ($updateCat['body']['status'] ?? '') !== 'success') {
        throw new Exception("Category update failed: " . ($updateCat['body']['message'] ?? $updateCat['raw']));
    }

    // 4. Sub-category Create
    $subName = 'SmokeSub_' . time();
    $createSub = makeApiCall($app, 'POST', '/api/battery/sub-create-category', [
        'category_id'       => $catId,
        'sub_category_name' => $subName,
    ]);
    if ($createSub['status_code'] !== 200 || ($createSub['body']['status'] ?? '') !== 'success') {
        throw new Exception("Sub-category create failed: " . ($createSub['body']['message'] ?? $createSub['raw']));
    }
    $subId = $createSub['body']['data']['id'] ?? null;
    if (!$subId) {
        $s = DB::table('battery_sub_categories')->where('name', $subName)->first();
        $subId = $s ? $s->id : null;
    }

    // 5. Category Filtering
    $filter = makeApiCall($app, 'GET', "/api/battery/sub-category-list/{$catId}");
    if ($filter['status_code'] !== 200 || !isset($filter['body']['data'])) {
        throw new Exception("Category filtering failed: status {$filter['status_code']}");
    }

    // 6. Delete Sub-category & Category
    $delSub = makeApiCall($app, 'POST', '/api/battery/delete-sub-category', ['id' => $subId]);
    if ($delSub['status_code'] !== 200 || ($delSub['body']['status'] ?? '') !== 'success') {
        throw new Exception("Sub-category delete failed: " . ($delSub['body']['message'] ?? $delSub['raw']));
    }

    $delCat = makeApiCall($app, 'POST', '/api/battery/delete-category', ['id' => $catId]);
    if ($delCat['status_code'] !== 200 || ($delCat['body']['status'] ?? '') !== 'success') {
        throw new Exception("Category delete failed: " . ($delCat['body']['message'] ?? $delCat['raw']));
    }

    $results['3. Category/Sub-category'] = 'PASS';
    echo " PASS\n";
} catch (Exception $e) {
    $results['3. Category/Sub-category'] = 'FAIL: ' . $e->getMessage();
    echo " FAIL: " . $e->getMessage() . "\n";
}

// -----------------------------------------------------------------------------
// Flow 4: Supplier (list, create/edit/delete)
// -----------------------------------------------------------------------------
echo "[4] Testing Supplier Flow...";
try {
    // 1. List
    $list = makeApiCall($app, 'GET', '/api/battery/supplier-list');
    if ($list['status_code'] !== 200 || !isset($list['body']['SupplierData'])) {
        throw new Exception("Supplier list failed: status {$list['status_code']}");
    }

    // 2. Create
    $suppName = 'SmokeSupplier_' . time();
    $create = makeApiCall($app, 'POST', '/api/battery/create-supplier', [
        'name'    => $suppName,
        'mobile'  => '01711' . rand(100000, 999999),
        'address' => 'Dhaka Battery Market',
    ]);
    if ($create['status_code'] !== 200 || ($create['body']['status'] ?? '') !== 'success') {
        throw new Exception("Supplier create failed: " . ($create['body']['message'] ?? $create['raw']));
    }
    $suppId = $create['body']['supplier']['id'] ?? $create['body']['data']['id'] ?? null;
    if (!$suppId) {
        $s = DB::table('battery_suppliers')->where('name', $suppName)->first();
        $suppId = $s ? $s->id : null;
    }

    // 3. Edit (By-ID and Update)
    $byId = makeApiCall($app, 'POST', '/api/battery/supplier-by-id', ['id' => $suppId]);
    if ($byId['status_code'] !== 200) {
        throw new Exception("Supplier by-id failed: status {$byId['status_code']}");
    }

    $update = makeApiCall($app, 'POST', '/api/battery/update-supplier', [
        'id'      => $suppId,
        'name'    => $suppName . '_Upd',
        'address' => 'Updated Address',
    ]);
    if ($update['status_code'] !== 200 || ($update['body']['status'] ?? '') !== 'success') {
        throw new Exception("Supplier update failed: " . ($update['body']['message'] ?? $update['raw']));
    }

    // 4. Delete
    $del = makeApiCall($app, 'POST', '/api/battery/delete-supplier', ['id' => $suppId]);
    if ($del['status_code'] !== 200 || ($del['body']['status'] ?? '') !== 'success') {
        throw new Exception("Supplier delete failed: " . ($del['body']['message'] ?? $del['raw']));
    }

    $results['4. Supplier'] = 'PASS';
    echo " PASS\n";
} catch (Exception $e) {
    $results['4. Supplier'] = 'FAIL: ' . $e->getMessage();
    echo " FAIL: " . $e->getMessage() . "\n";
}

// -----------------------------------------------------------------------------
// Flow 5: Customer (list, create/edit/delete)
// -----------------------------------------------------------------------------
echo "[5] Testing Customer Flow...";
try {
    // 1. List
    $list = makeApiCall($app, 'GET', '/api/battery/customer-list');
    if ($list['status_code'] !== 200 || !isset($list['body']['CustomerData'])) {
        throw new Exception("Customer list failed: status {$list['status_code']}");
    }

    // 2. Create
    $custName = 'SmokeCustomer_' . time();
    $create = makeApiCall($app, 'POST', '/api/battery/create-customer', [
        'customer_name'   => $custName,
        'mobile'          => '01811' . rand(100000, 999999),
        'address_details' => 'Mirpur Dhaka',
    ]);
    if ($create['status_code'] !== 200 || ($create['body']['status'] ?? '') !== 'success') {
        throw new Exception("Customer create failed: " . ($create['body']['message'] ?? $create['raw']));
    }
    $custId = $create['body']['customer']['id'] ?? $create['body']['data']['id'] ?? null;
    if (!$custId) {
        $c = DB::table('battery_customers')->where('customer_name', $custName)->first();
        $custId = $c ? $c->id : null;
    }

    // 3. Edit (By-ID and Update)
    $byId = makeApiCall($app, 'POST', '/api/battery/customer-by-id', ['id' => $custId]);
    if ($byId['status_code'] !== 200) {
        throw new Exception("Customer by-id failed: status {$byId['status_code']}");
    }

    $update = makeApiCall($app, 'POST', '/api/battery/update-customer', [
        'id'            => $custId,
        'customer_name' => $custName . '_Upd',
    ]);
    if ($update['status_code'] !== 200 || ($update['body']['status'] ?? '') !== 'success') {
        throw new Exception("Customer update failed: " . ($update['body']['message'] ?? $update['raw']));
    }

    // 4. Delete
    $del = makeApiCall($app, 'POST', '/api/battery/delete-customer', ['id' => $custId]);
    if ($del['status_code'] !== 200 || ($del['body']['status'] ?? '') !== 'success') {
        throw new Exception("Customer delete failed: " . ($del['body']['message'] ?? $del['raw']));
    }

    $results['5. Customer'] = 'PASS';
    echo " PASS\n";
} catch (Exception $e) {
    $results['5. Customer'] = 'FAIL: ' . $e->getMessage();
    echo " FAIL: " . $e->getMessage() . "\n";
}

// -----------------------------------------------------------------------------
// Flow 6: POS (product search, add item, quantity, subtotal, discount, delivery, paid, due, create order)
// -----------------------------------------------------------------------------
echo "[6] Testing POS Order Flow...";
try {
    // 1. Setup temporary product and customer for POS
    $posCust = makeApiCall($app, 'POST', '/api/battery/create-customer', [
        'customer_name' => 'POS Test Customer',
        'mobile'        => '01911' . rand(100000, 999999),
    ]);
    $posCustId = $posCust['body']['customer']['id'] ?? DB::table('battery_customers')->where('customer_name', 'POS Test Customer')->value('id');

    $posProd = makeApiCall($app, 'POST', '/api/battery/create-product', [
        'product_name' => 'POS Test Inverter Battery 150Ah',
        'product_code' => json_encode(['POS-BAT-' . time()]),
        'brand_id'     => $baseBrandId,
        'category_id'  => $baseCatId,
        'cost_price'   => 12000,
        'sell_price'   => 15000,
        'quantity'     => 10,
        'status'       => 'Active',
    ]);
    $posProdId = $posProd['body']['product']['id'] ?? $posProd['body']['products'][0]['id'] ?? DB::table('battery_products')->where('product_name', 'POS Test Inverter Battery 150Ah')->value('id');

    // 2. Product Search
    $search = makeApiCall($app, 'GET', '/api/battery/product-search-by-name', ['name' => 'Inverter']);
    if ($search['status_code'] !== 200) {
        throw new Exception("POS product search failed: status {$search['status_code']}");
    }

    // 3. Create POS Order
    // Calculation:
    // Item: 2 pcs @ 15000 = 30000
    // Delivery: 200
    // Discount: 500
    // Total: 30000 + 200 - 500 = 29700
    // Paid: 20000
    // Due: 9700
    $orderRes = makeApiCall($app, 'POST', '/api/battery/create-order', [
        'customer_id'     => $posCustId,
        'sub_total'       => 30000,
        'delivery_charge' => 200,
        'discount_amount' => 500,
        'paid_amount'     => 20000,
        'due_amount'      => 9700,
        'payment_method'  => 'Cash',
        'payment_status'  => 'Partial Paid',
        'products'        => json_encode([
            [
                'product_id'    => $posProdId,
                'quantity'      => 2,
                'cost_price'    => 12000,
                'selling_price' => 15000,
            ]
        ]),
    ]);

    if ($orderRes['status_code'] !== 200 || ($orderRes['body']['status'] ?? '') !== 'success') {
        throw new Exception("POS order creation failed: " . ($orderRes['body']['message'] ?? $orderRes['raw']));
    }

    $orderId = $orderRes['body']['invoice_id'] ?? null;

    // Verify stock was decremented: was 10, sold 2 => 8
    $remStock = DB::table('battery_products')->where('id', $posProdId)->value('quantity');
    if ((int)$remStock !== 8) {
        throw new Exception("Stock was not decremented accurately: expected 8, got {$remStock}");
    }

    // Cleanup POS test records
    DB::table('battery_order_payment_details')->where('order_id', $orderId)->delete();
    DB::table('battery_order_details')->where('order_id', $orderId)->delete();
    DB::table('battery_orders')->where('id', $orderId)->delete();
    DB::table('battery_products')->where('id', $posProdId)->delete();
    DB::table('battery_customers')->where('id', $posCustId)->delete();

    $results['6. POS Flow'] = 'PASS';
    echo " PASS\n";
} catch (Exception $e) {
    $results['6. POS Flow'] = 'FAIL: ' . $e->getMessage();
    echo " FAIL: " . $e->getMessage() . "\n";
}

// -----------------------------------------------------------------------------
// Flow 7: Purchase (product selection, supplier, submission, payment)
// -----------------------------------------------------------------------------
echo "[7] Testing Purchase Flow...";
try {
    $supp = makeApiCall($app, 'POST', '/api/battery/create-supplier', [
        'name'   => 'Purchase Test Supplier',
        'mobile' => '01722' . rand(100000, 999999),
    ]);
    $suppId = $supp['body']['supplier']['id'] ?? $supp['body']['data']['id'] ?? DB::table('battery_suppliers')->where('name', 'Purchase Test Supplier')->value('id');

    $prod = makeApiCall($app, 'POST', '/api/battery/create-product', [
        'product_name' => 'Purchase Test Battery 60Ah',
        'brand_id'     => $baseBrandId,
        'category_id'  => $baseCatId,
        'cost_price'   => 5000,
        'sell_price'   => 6500,
        'quantity'     => 5,
        'status'       => 'Active',
    ]);
    $prodId = $prod['body']['product']['id'] ?? $prod['body']['products'][0]['id'] ?? DB::table('battery_products')->where('product_name', 'Purchase Test Battery 60Ah')->value('id');

    // 1. Create Purchase
    // 10 units @ 5000 = 50000
    // Paid = 30000, Due = 20000
    $purRes = makeApiCall($app, 'POST', '/api/battery/create-purchases', [
        'supplier_id'    => $suppId,
        'grand_subtotal' => 50000,
        'paid_amount'    => 30000,
        'due_amount'     => 20000,
        'payment_status' => 'partial',
        'payment_type'   => 'Cash',
        'products'       => json_encode([
            [
                'product_id' => $prodId,
                'quantity'   => 10,
                'cost_price' => 5000,
                'subtotal'   => 50000,
            ]
        ]),
    ]);
    if ($purRes['status_code'] !== 200 || ($purRes['body']['status'] ?? '') !== 'success') {
        throw new Exception("Purchase creation failed: " . ($purRes['body']['message'] ?? $purRes['raw']));
    }
    $purId = $purRes['body']['data']['id'] ?? null;

    // 2. Payment Details By ID
    $payDetails = makeApiCall($app, 'POST', '/api/battery/purchase-payment-details-by-id', ['id' => $purId]);
    if ($payDetails['status_code'] !== 200) {
        throw new Exception("Purchase payment details fetch failed");
    }

    // 3. Update Purchase Payment (pay remaining 20000)
    $payUpdate = makeApiCall($app, 'POST', '/api/battery/update-purchase-payment', [
        'purchases_id'   => $purId,
        'paid_amount'    => 20000,
        'payment_type'   => 'Cash',
        'payment_status' => 'paid',
    ]);
    if ($payUpdate['status_code'] !== 200 || ($payUpdate['body']['status'] ?? '') !== 'success') {
        throw new Exception("Purchase payment update failed: " . ($payUpdate['body']['message'] ?? $payUpdate['raw']));
    }

    // Cleanup
    DB::table('battery_purchase_payment_details')->where('purchases_id', $purId)->delete();
    DB::table('battery_purchase_order_details')->where('purchase_id', $purId)->delete();
    DB::table('battery_purchases')->where('id', $purId)->delete();
    DB::table('battery_products')->where('id', $prodId)->delete();
    DB::table('battery_suppliers')->where('id', $suppId)->delete();

    $results['7. Purchase Flow'] = 'PASS';
    echo " PASS\n";
} catch (Exception $e) {
    $results['7. Purchase Flow'] = 'FAIL: ' . $e->getMessage();
    echo " FAIL: " . $e->getMessage() . "\n";
}

// -----------------------------------------------------------------------------
// Flow 8: Due collection (customer due collection, supplier due collection)
// -----------------------------------------------------------------------------
echo "[8] Testing Due Collection Flow...";
try {
    // 1. Customer Due List
    $custDueList = makeApiCall($app, 'GET', '/api/battery/customer-due-list');
    if ($custDueList['status_code'] !== 200) {
        throw new Exception("Customer due list failed");
    }

    // Create temp customer with due
    $tempCust = DB::table('battery_customers')->insertGetId([
        'customer_id'          => 'BAT-CUST-9999',
        'customer_name'        => 'Due Test Customer',
        'mobile'               => '01611' . rand(100000, 999999),
        'previous_due_amount'  => 5000,
        'user_id'              => $user->id,
        'created_at'           => now(),
        'updated_at'           => now(),
    ]);

    // Collect Customer Due
    $custCollect = makeApiCall($app, 'POST', '/api/battery/customer-payment-details-update', [
        'customer_id'         => $tempCust,
        'paid_amount'         => 3000,
        'payment_type'        => 'Cash',
        'due_collection_date' => now()->format('Y-m-d'),
    ]);
    if ($custCollect['status_code'] !== 200 || ($custCollect['body']['status'] ?? '') !== 'success') {
        throw new Exception("Customer due collection failed: " . ($custCollect['body']['message'] ?? $custCollect['raw']));
    }

    // Customer Due Collection History
    $custHistory = makeApiCall($app, 'GET', '/api/battery/customer-due-collection-list');
    if ($custHistory['status_code'] !== 200) {
        throw new Exception("Customer due collection list failed");
    }

    // 2. Supplier Due List
    $suppDueList = makeApiCall($app, 'GET', '/api/battery/supplier-due-list');
    if ($suppDueList['status_code'] !== 200) {
        throw new Exception("Supplier due list failed");
    }

    // Cleanup
    DB::table('battery_customer_payment_details')->where('customer_id', $tempCust)->delete();
    DB::table('battery_customers')->where('id', $tempCust)->delete();

    $results['8. Due Collection'] = 'PASS';
    echo " PASS\n";
} catch (Exception $e) {
    $results['8. Due Collection'] = 'FAIL: ' . $e->getMessage();
    echo " FAIL: " . $e->getMessage() . "\n";
}

// -----------------------------------------------------------------------------
// Flow 9: Expenses (expense type, expense creation)
// -----------------------------------------------------------------------------
echo "[9] Testing Expense Flow...";
try {
    // 1. Expense Type CRUD
    $expTypeList = makeApiCall($app, 'GET', '/api/battery/expense-type-list');
    if ($expTypeList['status_code'] !== 200) {
        throw new Exception("Expense type list failed");
    }

    $createType = makeApiCall($app, 'POST', '/api/battery/create-expense-type', [
        'type_name' => 'Battery Delivery Fuel ' . time(),
    ]);
    if ($createType['status_code'] !== 200 || ($createType['body']['status'] ?? '') !== 'success') {
        throw new Exception("Expense type create failed");
    }
    $typeId = $createType['body']['data']['id'] ?? null;
    if (!$typeId) {
        $typeId = DB::table('battery_expense_types')->latest('id')->value('id');
    }

    // 2. Expense Creation
    $createExp = makeApiCall($app, 'POST', '/api/battery/create-expense', [
        'expense_type_id' => $typeId,
        'expense_amount'  => 1200,
        'expense_for'     => 'Local delivery fuel smoke test',
        'date'            => now()->format('Y-m-d'),
    ]);
    if ($createExp['status_code'] !== 200 || ($createExp['body']['status'] ?? '') !== 'success') {
        throw new Exception("Expense create failed");
    }
    $expId = $createExp['body']['data']['id'] ?? DB::table('battery_expenses')->latest('id')->value('id');

    // 3. Expense List
    $expList = makeApiCall($app, 'GET', '/api/battery/expense-list');
    if ($expList['status_code'] !== 200) {
        throw new Exception("Expense list failed");
    }

    // Cleanup
    DB::table('battery_expenses')->where('id', $expId)->delete();
    DB::table('battery_expense_types')->where('id', $typeId)->delete();

    $results['9. Expenses'] = 'PASS';
    echo " PASS\n";
} catch (Exception $e) {
    $results['9. Expenses'] = 'FAIL: ' . $e->getMessage();
    echo " FAIL: " . $e->getMessage() . "\n";
}

// -----------------------------------------------------------------------------
// Flow 10: Returns (sales return search/create, purchase return search/create)
// -----------------------------------------------------------------------------
echo "[10] Testing Returns Flow...";
try {
    // 1. Sales Returns List
    $retList = makeApiCall($app, 'GET', '/api/battery/return-product-list');
    if ($retList['status_code'] !== 200) {
        throw new Exception("Sales return list failed");
    }

    // 2. Search Invoice for Return
    $searchInv = makeApiCall($app, 'GET', '/api/battery/search-invoice-for-return', ['order_no' => 'NON_EXISTENT_ORDER_999']);
    if ($searchInv['status_code'] !== 200 && $searchInv['status_code'] !== 404) {
        throw new Exception("Sales return search invoice failed");
    }

    // 3. Purchase Returns List
    $purRetList = makeApiCall($app, 'GET', '/api/battery/purchase-return-list');
    if ($purRetList['status_code'] !== 200) {
        throw new Exception("Purchase return list failed");
    }

    // 4. Search Purchase for Return
    $searchPur = makeApiCall($app, 'GET', '/api/battery/search-purchase-for-return', ['purchase_id' => '99999']);
    if ($searchPur['status_code'] !== 200 && $searchPur['status_code'] !== 404) {
        throw new Exception("Purchase return search failed");
    }

    $results['10. Returns'] = 'PASS';
    echo " PASS\n";
} catch (Exception $e) {
    $results['10. Returns'] = 'FAIL: ' . $e->getMessage();
    echo " FAIL: " . $e->getMessage() . "\n";
}

// -----------------------------------------------------------------------------
// Flow 11: Reports (sales, ledger, income/expense, receipt/payment, stock-out)
// -----------------------------------------------------------------------------
echo "[11] Testing Reports Flow...";
try {
    $today = now()->format('Y-m-d');

    // 1. Sales Report
    $sales = makeApiCall($app, 'GET', '/api/battery/sales-report-list', ['start_date' => $today, 'end_date' => $today]);
    if ($sales['status_code'] !== 200) throw new Exception("Sales report failed: status {$sales['status_code']}");

    // 2. Daily Ledger
    $ledger = makeApiCall($app, 'GET', '/api/battery/daily-ledger-report-list', ['start_date' => $today, 'end_date' => $today]);
    if ($ledger['status_code'] !== 200) throw new Exception("Daily ledger report failed: status {$ledger['status_code']}");

    // 3. Income Expense
    $incExp = makeApiCall($app, 'GET', '/api/battery/income-expense-report-list', ['start_date' => $today, 'end_date' => $today]);
    if ($incExp['status_code'] !== 200) throw new Exception("Income/Expense report failed: status {$incExp['status_code']}");

    // 4. Daily Receipt Payment
    $recPay = makeApiCall($app, 'GET', '/api/battery/daily-receipt-payment-report', ['start_date' => $today, 'end_date' => $today]);
    if ($recPay['status_code'] !== 200) throw new Exception("Receipt/Payment report failed: status {$recPay['status_code']}");

    // 5. Stock-out Report
    $stockOut = makeApiCall($app, 'GET', '/api/battery/stock-out-product-list');
    if ($stockOut['status_code'] !== 200) throw new Exception("Stock-out report failed: status {$stockOut['status_code']}");

    $results['11. Reports'] = 'PASS';
    echo " PASS\n";
} catch (Exception $e) {
    $results['11. Reports'] = 'FAIL: ' . $e->getMessage();
    echo " FAIL: " . $e->getMessage() . "\n";
}

// -----------------------------------------------------------------------------
// Flow 12: Navigation
// -----------------------------------------------------------------------------
echo "[12] Testing Navigation Flow...";
try {
    // 1. Retail Dashboard returns 200
    $retailReq = Illuminate\Http\Request::create('/admin-dashboard', 'GET');
    $retailRes = $app->handle($retailReq);
    if ($retailRes->getStatusCode() !== 200) throw new Exception("Retail /admin-dashboard failed: status {$retailRes->getStatusCode()}");

    // 2. Battery Dashboard returns 200
    $batReq = Illuminate\Http\Request::create('/battery/dashboard', 'GET');
    $batRes = $app->handle($batReq);
    if ($batRes->getStatusCode() !== 200) throw new Exception("Battery /battery/dashboard failed: status {$batRes->getStatusCode()}");

    // 3. Verify sidebar conditional rendering
    $retailContent = $retailRes->getContent();
    $batContent = $batRes->getContent();

    // In battery content, Battery sidebar must be included
    if (!str_contains($batContent, 'sidebar-panels') && !str_contains($batContent, 'Battery POS') && !str_contains($batContent, 'battery/pos')) {
        throw new Exception("Battery dashboard does not render Battery sidebar links");
    }

    // In retail content, Retail sidebar must remain intact
    if (!str_contains($retailContent, 'Retail Shop') || !str_contains($retailContent, 'admin-dashboard-pos')) {
        throw new Exception("Retail dashboard missing retail links");
    }

    $results['12. Navigation'] = 'PASS';
    echo " PASS\n";
} catch (Exception $e) {
    $results['12. Navigation'] = 'FAIL: ' . $e->getMessage();
    echo " FAIL: " . $e->getMessage() . "\n";
}

// -----------------------------------------------------------------------------
// Flow 13: API Namespacing Strictness Audit
// -----------------------------------------------------------------------------
echo "[13] Testing API Namespacing Strictness...";
try {
    $viewDir = realpath(__DIR__ . '/../resources/views/battery');
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewDir));
    $violations = [];

    foreach ($rii as $file) {
        if ($file->isDir()) continue;
        if (substr($file->getFilename(), -10) !== '.blade.php') continue;

        $content = file_get_contents($file->getPathname());
        // Match any axios.get/post/etc pointing to /api/... that does NOT start with /api/battery/
        if (preg_match_all('/axios\.(get|post|put|delete)\s*\(\s*[\'"]\/api\/(?!battery\/)([\w\-\/]+)[\'"]/i', $content, $matches)) {
            foreach ($matches[0] as $match) {
                // allow shared read-only location/district lookup if needed, otherwise flag
                if (!str_contains($match, 'location-list') && !str_contains($match, 'district-list') && !str_contains($match, 'create-location')) {
                    $violations[] = $file->getFilename() . " => " . $match;
                }
            }
        }
    }

    if (!empty($violations)) {
        throw new Exception("Found un-namespaced Battery API calls: " . implode(", ", $violations));
    }

    $results['13. API Namespacing'] = 'PASS';
    echo " PASS\n";
} catch (Exception $e) {
    $results['13. API Namespacing'] = 'FAIL: ' . $e->getMessage();
    echo " FAIL: " . $e->getMessage() . "\n";
}

// -----------------------------------------------------------------------------
// Flow 14: Existing Retail Protection Audit
// -----------------------------------------------------------------------------
echo "[14] Testing Existing Retail Protection...";
try {
    $diff = shell_exec('git diff resources/views/layouts/dashboard-sidenav.blade.php 2>&1');
    if (!str_contains($diff, '$isBattery') || !str_contains($diff, 'battery.layouts.sidebar-panels')) {
        throw new Exception("dashboard-sidenav.blade.php missing approved switcher logic");
    }

    $modifiedFiles = shell_exec('git diff --name-only 2>&1');
    $modifiedList = array_filter(explode("\n", trim($modifiedFiles)));
    $allowedModified = [
        'resources/views/layouts/dashboard-sidenav.blade.php',
        'routes/api.php',
        'routes/web.php',
    ];
    foreach ($modifiedList as $m) {
        $m = trim($m);
        if ($m && !in_array($m, $allowedModified)) {
            // Note: tests or new battery controllers inside app/Http/Controllers/Battery are not modified existing retail files
            if (!str_starts_with($m, 'app/Http/Controllers/Battery/') && !str_starts_with($m, 'tests/')) {
                throw new Exception("Unexpected existing file was modified: " . $m);
            }
        }
    }

    $results['14. Existing Retail Protection'] = 'PASS';
    echo " PASS\n";
} catch (Exception $e) {
    $results['14. Existing Retail Protection'] = 'FAIL: ' . $e->getMessage();
    echo " FAIL: " . $e->getMessage() . "\n";
}

// -----------------------------------------------------------------------------
// Flow 15: Theme Audit
// -----------------------------------------------------------------------------
echo "[15] Testing Theme Audit...";
try {
    $gitStatus = shell_exec('git status --short 2>&1');
    if (str_contains($gitStatus, 'battery.css') || str_contains($gitStatus, 'resources/css/battery')) {
        throw new Exception("Unapproved battery theme CSS file detected");
    }

    $results['15. Theme Compliance'] = 'PASS';
    echo " PASS\n";
} catch (Exception $e) {
    $results['15. Theme Compliance'] = 'FAIL: ' . $e->getMessage();
    echo " FAIL: " . $e->getMessage() . "\n";
}

echo "\n========================================================\n";
echo "                   FINAL TEST SUMMARY                   \n";
echo "========================================================\n";
$allPass = true;
foreach ($results as $flow => $status) {
    echo str_pad($flow, 35) . " : " . $status . "\n";
    if ($status !== 'PASS') $allPass = false;
}
echo "========================================================\n";
echo "OVERALL STATUS: " . ($allPass ? "ALL FLOWS PASSED" : "FAILURES DETECTED") . "\n";
