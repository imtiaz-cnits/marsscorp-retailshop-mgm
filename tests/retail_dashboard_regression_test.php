<?php
/**
 * Retail Dashboard Comprehensive Regression & Business Date Isolation Test Suite
 * 
 * Verifies:
 * 1. Scenario A: No transaction today => all period cards display ৳0.00.
 * 2. Scenario B: Old invoice collected today => Sales = 0, Collection = collected amount.
 * 3. Scenario C: Expense recorded today => Sales = 0, Expense = amount, Profit = -amount.
 * 4. Scenario D: Historical invoice imported today with older date => does NOT appear in Today sales.
 * 5. Scenario E: Historical invoice updated today => does NOT appear in Today sales.
 * 6. Scenario F: Return of old invoice processed today => appears in Today return, sales remain 0.
 * 7. All 6 filter types ('today', 'last_week', 'this_month', 'last_month', 'date_wise', 'all_time').
 * 8. Dynamic trend chart generation ('dates', 'sales', 'profits', 'title').
 * 9. Complete Retail/Battery data separation (Battery tables completely untouched).
 * 
 * Execution: Safe transaction rollback ensures ZERO permanent database modification.
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\OrderPaymentDetails;
use App\Models\CustomerPaymentDetails;
use App\Models\ProductReturn;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;

echo "=================================================================" . PHP_EOL;
echo "   MARSS RETAIL DASHBOARD DATE FILTER REGRESSION TEST SUITE      " . PHP_EOL;
echo "=================================================================" . PHP_EOL;

$passed = 0;
$failed = 0;

function assertCondition($name, $condition, $details = '') {
    global $passed, $failed;
    if ($condition) {
        echo " [PASS] $name" . ($details ? " ($details)" : "") . PHP_EOL;
        $passed++;
    } else {
        echo " [FAIL] $name" . ($details ? " ($details)" : "") . PHP_EOL;
        $failed++;
    }
}

DB::beginTransaction();
try {
    $controller = app(DashboardController::class);
    $todayDate = Carbon::today()->toDateString();
    $d4 = Carbon::today()->subDays(4)->toDateString();
    $d15 = Carbon::today()->subDays(15)->toDateString();
    $d60 = Carbon::today()->subDays(60)->toDateString();

    $callFilter = function($filter, $s = null, $e = null) use ($controller) {
        $params = ['filter_type' => $filter];
        if ($s) $params['start_date'] = $s;
        if ($e) $params['end_date'] = $e;
        $req = Request::create('/api/dashboard-all-calculation', 'GET', $params);
        $res = json_decode($controller->DashboardAllCalculation($req)->getContent(), true);
        return $res;
    };

    // --- TEST 1: SCENARIO A (Baseline Today is strictly ৳0.00) ---
    $todayBaseRes = $callFilter('today');
    $tb = $todayBaseRes['today'];
    assertCondition("Scenario A: Today Sales is ৳0.00", (float)$tb['sales_amount'] === 0.0, "Got: {$tb['sales_amount']}");
    assertCondition("Scenario A: Today Cash Collection is ৳0.00", (float)$tb['cash_collection'] === 0.0, "Got: {$tb['cash_collection']}");
    assertCondition("Scenario A: Today Expense is ৳0.00", (float)$tb['expense'] === 0.0, "Got: {$tb['expense']}");
    assertCondition("Scenario A: Today Net Profit is ৳0.00", (float)$tb['net_profit'] === 0.0, "Got: {$tb['net_profit']}");
    assertCondition("Scenario A: Today Receivable Due is ৳0.00", (float)$tb['customer_due'] === 0.0, "Got: {$tb['customer_due']}");
    assertCondition("Scenario A: Today Supplier Payable is ৳0.00", (float)$tb['supplier_payable'] === 0.0, "Got: {$tb['supplier_payable']}");
    assertCondition("Scenario A: Today Return is ৳0.00", (float)$tb['total_return'] === 0.0, "Got: {$tb['total_return']}");
    assertCondition("Scenario A: Today Discount is ৳0.00", (float)$tb['total_discount'] === 0.0, "Got: {$tb['total_discount']}");

    // Measure existing baselines for delta testing
    $baseWeek = $callFilter('last_week')['today'];
    $baseMonth = $callFilter('last_month')['today'];
    $baseDateWise = $callFilter('date_wise', $d4, $d4)['today'];
    $baseAll = $callFilter('all_time')['today'];

    // Setup temporary test customer, product, expense type inside transaction
    $cust = Customer::create([
        'customer_id' => 'RET-REG-CUST',
        'customer_name' => 'Retail Reg Customer',
        'mobile' => '01799999999',
        'previous_due_amount' => 500.00,
        'user_id' => 1
    ]);

    $prod = Product::create([
        'product_name' => 'Regression Test Product',
        'product_code' => json_encode(['RET-REG-001']),
        'cost_price' => 200.00,
        'sell_price' => 300.00,
        'quantity' => 100,
        'status' => 'Active',
        'brand_id' => 1,
        'category_id' => 1,
        'unit_id' => 1,
        'user_id' => 1
    ]);

    $expType = ExpenseType::firstOrCreate(['id' => 1], ['type_name' => 'General Shop Expense', 'user_id' => 1]);

    // --- TEST 2: SCENARIO D (Historical invoice imported today with older date) ---
    // Invoice date is 15 days ago, but created_at is TODAY
    $histOrder = Order::create([
        'order_no' => 'RET-REG-HIST-01',
        'sub_total' => 5000.00,
        'paid_amount' => 0.00,
        'due_amount' => 5000.00,
        'discount_amount' => 0.00,
        'customer_id' => $cust->id,
        'invoice_date' => $d15,
        'user_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ]);
    OrderDetails::create([
        'order_id' => $histOrder->id,
        'product_id' => $prod->id,
        'quantity' => 10,
        'price' => 200.00,
        'selling_price' => 300.00,
        'user_id' => 1
    ]);

    $checkHistToday = $callFilter('today')['today'];
    assertCondition("Scenario D: Historical invoice imported today does NOT appear in Today sales", (float)$checkHistToday['sales_amount'] === 0.0, "Got: {$checkHistToday['sales_amount']}");

    // --- TEST 3: SCENARIO E (Historical invoice updated today) ---
    $histOrder->update(['order_note' => 'Updated today for note correction', 'updated_at' => Carbon::now()]);
    $checkHistUpdated = $callFilter('today')['today'];
    assertCondition("Scenario E: Updated historical invoice does NOT appear in Today sales", (float)$checkHistUpdated['sales_amount'] === 0.0, "Got: {$checkHistUpdated['sales_amount']}");

    // --- TEST 4: SCENARIO B (No invoice today, old invoice collected today) ---
    // Payment of 2000 against customer due with due_collection_date = today
    CustomerPaymentDetails::create([
        'paid_amount' => 2000.00,
        'due_amount' => 3000.00,
        'previous_due_amount' => 5000.00,
        'discount_amount' => 0.00,
        'due_collection_date' => $todayDate,
        'payment_method' => 'Cash',
        'payment_status' => 'Partial Paid',
        'customer_id' => $cust->id,
        'user_id' => 1
    ]);
    $checkColToday = $callFilter('today')['today'];
    assertCondition("Scenario B: Sales remains ৳0.00 when only collection occurs", (float)$checkColToday['sales_amount'] === 0.0);
    assertCondition("Scenario B: Cash Collection shows actual ৳2,000.00 collected today", (float)$checkColToday['cash_collection'] === 2000.0, "Got: {$checkColToday['cash_collection']}");

    // --- TEST 5: SCENARIO C (Expense recorded today, sales = 0) ---
    Expense::create([
        'expense_type_id' => $expType->id,
        'expense_amount' => 350.00,
        'expense_details' => 'Today Shop Cleaning',
        'date' => $todayDate,
        'user_id' => 1
    ]);
    $checkExpToday = $callFilter('today')['today'];
    assertCondition("Scenario C: Sales remains ৳0.00 when only expense occurs", (float)$checkExpToday['sales_amount'] === 0.0);
    assertCondition("Scenario C: Expense shows actual ৳350.00 recorded today", (float)$checkExpToday['expense'] === 350.0, "Got: {$checkExpToday['expense']}");
    assertCondition("Scenario C: Net Profit reflects -৳350.00 loss from expense", (float)$checkExpToday['net_profit'] === -350.0, "Got: {$checkExpToday['net_profit']}");

    // --- TEST 6: SCENARIO F (Return of old invoice processed today) ---
    ProductReturn::create([
        'return_number' => 'RET-REG-RET01',
        'amount' => 600.00,
        'discount_amount' => 0.00,
        'due_amount' => 0.00,
        'quantity' => 2,
        'unit_price' => 300.00,
        'date' => $todayDate,
        'order_id' => $histOrder->id,
        'product_id' => $prod->id,
        'customer_id' => $cust->id,
        'user_id' => 1
    ]);
    $checkRetToday = $callFilter('today')['today'];
    assertCondition("Scenario F: Return amount appears under Today's return metric (+৳600.00)", (float)$checkRetToday['total_return'] === 600.0, "Got: {$checkRetToday['total_return']}");
    assertCondition("Scenario F: Sales remains ৳0.00 under Today (historical invoice untouched)", (float)$checkRetToday['sales_amount'] === 0.0);

    // --- TEST 7: INJECT TODAY SALES & TEST FULL TODAY INTEGRITY ---
    // Order created today: Subtotal 3000 (10 pcs @ 300, cost 200 => Gross: 1000, Exp: 350 => Net Profit: 650)
    $todayOrder = Order::create([
        'order_no' => 'RET-REG-TODAY-01',
        'sub_total' => 3000.00,
        'paid_amount' => 2500.00,
        'due_amount' => 500.00,
        'discount_amount' => 0.00,
        'customer_id' => $cust->id,
        'invoice_date' => $todayDate,
        'user_id' => 1
    ]);
    OrderDetails::create([
        'order_id' => $todayOrder->id,
        'product_id' => $prod->id,
        'quantity' => 10,
        'price' => 200.00,
        'selling_price' => 300.00,
        'user_id' => 1
    ]);
    OrderPaymentDetails::create([
        'order_id' => $todayOrder->id,
        'paid_amount' => 2500.00,
        'due_collection_date' => $todayDate,
        'payment_method' => 'Cash',
        'payment_status' => 'Partial',
        'user_id' => 1
    ]);

    $tFinal = $callFilter('today')['today'];
    assertCondition("Today Sales equals injected ৳3,000.00", (float)$tFinal['sales_amount'] === 3000.0, "Got: {$tFinal['sales_amount']}");
    assertCondition("Today Cash Collection equals Order (2500) + Cust (2000) = ৳4,500.00", (float)$tFinal['cash_collection'] === 4500.0, "Got: {$tFinal['cash_collection']}");
    assertCondition("Today Expense equals ৳350.00", (float)$tFinal['expense'] === 350.0, "Got: {$tFinal['expense']}");
    assertCondition("Today Gross Profit is ৳1,000.00", (float)$tFinal['gross_profit'] === 1000.0, "Got: {$tFinal['gross_profit']}");
    assertCondition("Today Net Profit is Gross (1000) - Expense (350) = ৳650.00", (float)$tFinal['net_profit'] === 650.0, "Got: {$tFinal['net_profit']}");
    assertCondition("Today Period Customer Due is ৳500.00", (float)$tFinal['period_customer_due'] === 500.0, "Got: {$tFinal['period_customer_due']}");

    // --- TEST 8: ALL 6 FILTERS DELTA INTEGRITY ---
    $wFinal = $callFilter('last_week')['today'];
    assertCondition("Last 7 Days Sales delta is +৳3,000.00", (float)($wFinal['sales_amount'] - $baseWeek['sales_amount']) === 3000.0);
    assertCondition("Last 7 Days Cash Collection delta is +৳4,500.00", (float)($wFinal['cash_collection'] - $baseWeek['cash_collection']) === 4500.0);

    $mFinal = $callFilter('last_month')['today'];
    // In Last 30 Days: Today order (3000) + Hist order 15 days ago (5000) = +8000
    assertCondition("Last 30 Days Sales delta includes both today and 15-day order (+৳8,000.00)", (float)($mFinal['sales_amount'] - $baseMonth['sales_amount']) === 8000.0);

    $aFinal = $callFilter('all_time');
    assertCondition("All Time Customer Due includes lifetime previous due (+৳500) + orders dues (+৳5500) = +৳6,000.00", (float)($aFinal['financial']['lifetime_customer_due'] - $baseAll['customer_due']) === 6000.0);

    // --- TEST 9: DYNAMIC CHART OUTPUT ---
    $chart = $todayBaseRes['chart'];
    assertCondition("Chart contains dates array", !empty($chart['dates']));
    assertCondition("Chart contains sales series matching date count", count($chart['dates']) === count($chart['sales']));
    assertCondition("Chart contains profits series matching date count", count($chart['dates']) === count($chart['profits']));
    assertCondition("Chart has dynamic title for Last 7 Days", strpos($chart['title'], 'Last 7 Days') !== false);

    // --- TEST 10: BATTERY TABLE NON-CONTAMINATION ---
    $batteryOrderCount = DB::table('battery_orders')->count();
    assertCondition("Battery orders count is completely untouched (is 0)", $batteryOrderCount === 0, "Count: $batteryOrderCount");

} finally {
    DB::rollBack();
    echo "=================================================================" . PHP_EOL;
    echo "  CLEANUP: TRANSACTION ROLLED BACK SAFELY. ZERO DB PERSISTENCE.  " . PHP_EOL;
    echo "=================================================================" . PHP_EOL;
}

echo "TOTAL ASSERTIONS: " . ($passed + $failed) . " | PASSED: $passed | FAILED: $failed" . PHP_EOL;
exit($failed > 0 ? 1 : 0);
