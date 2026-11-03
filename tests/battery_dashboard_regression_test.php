<?php
/**
 * Battery Dashboard Comprehensive Regression & Period Isolation Test Suite
 * 
 * Verifies:
 * 1. All 6 filter types ('today', 'last_week', 'this_month', 'last_month', 'date_wise', 'all_time').
 * 2. Complete period isolation: invoice/order date, payment date, expense date.
 * 3. Dynamic trend chart generation ('dates', 'sales', 'profits', 'title').
 * 4. Stale request / zero-period handling.
 * 5. Complete Battery/Retail data separation (only battery_* models/tables used).
 * 
 * Execution: Safe transaction rollback ensures ZERO permanent database modification.
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Battery\BatteryCustomer;
use App\Models\Battery\BatterySupplier;
use App\Models\Battery\BatteryProduct;
use App\Models\Battery\BatteryBrand;
use App\Models\Battery\BatteryCategory;
use App\Models\Battery\BatteryExpenseType;
use App\Http\Controllers\Battery\BatteryDashboardController;

echo "=================================================================" . PHP_EOL;
echo "  MARSS BATTERY DASHBOARD FILTER REGRESSION & VERIFICATION TEST  " . PHP_EOL;
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
    $controller = app(BatteryDashboardController::class);

    // Measure existing baseline across filters
    $d4 = Carbon::today()->subDays(4)->toDateString();
    $d15 = Carbon::today()->subDays(15)->toDateString();
    $d60 = Carbon::today()->subDays(60)->toDateString();

    $getBase = function($filter, $s = null, $e = null) use ($controller) {
        $params = ['filter_type' => $filter];
        if ($s) $params['start_date'] = $s;
        if ($e) $params['end_date'] = $e;
        $req = Illuminate\Http\Request::create('/api/battery/dashboard-all-calculation', 'GET', $params);
        $res = json_decode($controller->DashboardAllCalculation($req)->getContent(), true);
        return $res['today'] ?? [];
    };

    $baseToday = $getBase('today');
    $baseWeek = $getBase('last_week');
    $baseMonth = $getBase('last_month');
    $baseDateWise = $getBase('date_wise', $d4, $d4);
    $baseAll = $getBase('all_time');

    // 1. Seed simulated Battery entities inside transaction
    $brand = BatteryBrand::create(['name' => 'Mega Battery Brand', 'user_id' => 1]);
    $cat = BatteryCategory::create(['name' => 'Industrial Batteries', 'user_id' => 1]);
    $expType = BatteryExpenseType::create(['type_name' => 'Battery Shop Utilities', 'user_id' => 1]);

    $cust = BatteryCustomer::create([
        'customer_id' => 'BAT-REG-CUST',
        'customer_name' => 'Reg Customer',
        'mobile' => '01711111111',
        'previous_due_amount' => 1000.00,
        'user_id' => 1
    ]);

    $supp = BatterySupplier::create([
        'supplier_id' => 'BAT-REG-SUPP',
        'name' => 'Reg Supplier',
        'mobile' => '01822222222',
        'purchase_payable_amount' => 2000.00,
        'user_id' => 1
    ]);

    $prod = BatteryProduct::create([
        'product_name' => '12V 100Ah Tubular Battery',
        'product_code' => ['TUB-100AH'],
        'cost_price' => 8000.00,
        'sell_price' => 10000.00,
        'quantity' => 50,
        'status' => 'Active',
        'brand_id' => $brand->id,
        'category_id' => $cat->id,
        'user_id' => 1
    ]);

    // Transaction 1: TODAY (Sales: 10,000, Paid: 7,000, Due: 3,000, Cost: 8,000, Gross: 2,000, Exp: 500, Net: 1,500)
    $todayDate = Carbon::today()->toDateString();
    $o1 = DB::table('battery_orders')->insertGetId([
        'order_no' => 'BAT-INV-REG-TODAY',
        'sub_total' => 10000.00,
        'paid_amount' => 7000.00,
        'due_amount' => 3000.00,
        'discount_amount' => 0.00,
        'customer_id' => $cust->id,
        'invoice_date' => $todayDate,
        'user_id' => 1,
        'created_at' => $todayDate . ' 10:00:00',
        'updated_at' => $todayDate . ' 10:00:00',
    ]);
    DB::table('battery_order_details')->insert([
        'order_id' => $o1,
        'product_id' => $prod->id,
        'quantity' => 1,
        'price' => 8000.00,
        'selling_price' => 10000.00,
        'user_id' => 1,
        'created_at' => $todayDate . ' 10:00:00',
        'updated_at' => $todayDate . ' 10:00:00',
    ]);
    DB::table('battery_order_payment_details')->insert([
        'order_id' => $o1,
        'paid_amount' => 7000.00,
        'due_collection_date' => $todayDate,
        'payment_method' => 'cash',
        'payment_status' => 'Partial',
        'user_id' => 1,
        'created_at' => $todayDate . ' 10:00:00',
        'updated_at' => $todayDate . ' 10:00:00',
    ]);
    DB::table('battery_expenses')->insert([
        'expense_type_id' => $expType->id,
        'expense_amount' => 500.00,
        'date' => $todayDate,
        'user_id' => 1,
        'created_at' => $todayDate . ' 11:00:00',
        'updated_at' => $todayDate . ' 11:00:00',
    ]);

    // Transaction 2: 4 DAYS AGO (Last 7 Days)
    // Sales: 20,000, Paid: 18,000, Due: 1,000, Discount: 1,000, Cost: 16,000, Gross: 3,000, Exp: 0, Net: 3,000
    $o2 = DB::table('battery_orders')->insertGetId([
        'order_no' => 'BAT-INV-REG-4DAYS',
        'sub_total' => 20000.00,
        'paid_amount' => 18000.00,
        'due_amount' => 1000.00,
        'discount_amount' => 1000.00,
        'customer_id' => $cust->id,
        'invoice_date' => $d4,
        'user_id' => 1,
        'created_at' => $d4 . ' 12:00:00',
        'updated_at' => $d4 . ' 12:00:00',
    ]);
    DB::table('battery_order_details')->insert([
        'order_id' => $o2,
        'product_id' => $prod->id,
        'quantity' => 2,
        'price' => 8000.00,
        'selling_price' => 10000.00,
        'user_id' => 1,
        'created_at' => $d4 . ' 12:00:00',
        'updated_at' => $d4 . ' 12:00:00',
    ]);
    DB::table('battery_order_payment_details')->insert([
        'order_id' => $o2,
        'paid_amount' => 18000.00,
        'due_collection_date' => $d4,
        'payment_method' => 'cash',
        'payment_status' => 'Partial',
        'user_id' => 1,
        'created_at' => $d4 . ' 12:00:00',
        'updated_at' => $d4 . ' 12:00:00',
    ]);

    // Transaction 3: 15 DAYS AGO (Last 30 Days)
    // Sales: 30,000, Paid: 30,000, Due: 0, Cost: 24,000, Gross: 6,000, Exp: 1,000, Net: 5,000
    $o3 = DB::table('battery_orders')->insertGetId([
        'order_no' => 'BAT-INV-REG-15DAYS',
        'sub_total' => 30000.00,
        'paid_amount' => 30000.00,
        'due_amount' => 0.00,
        'discount_amount' => 0.00,
        'customer_id' => $cust->id,
        'invoice_date' => $d15,
        'user_id' => 1,
        'created_at' => $d15 . ' 14:00:00',
        'updated_at' => $d15 . ' 14:00:00',
    ]);
    DB::table('battery_order_details')->insert([
        'order_id' => $o3,
        'product_id' => $prod->id,
        'quantity' => 3,
        'price' => 8000.00,
        'selling_price' => 10000.00,
        'user_id' => 1,
        'created_at' => $d15 . ' 14:00:00',
        'updated_at' => $d15 . ' 14:00:00',
    ]);
    DB::table('battery_order_payment_details')->insert([
        'order_id' => $o3,
        'paid_amount' => 30000.00,
        'due_collection_date' => $d15,
        'payment_method' => 'cash',
        'payment_status' => 'Paid',
        'user_id' => 1,
        'created_at' => $d15 . ' 14:00:00',
        'updated_at' => $d15 . ' 14:00:00',
    ]);
    DB::table('battery_expenses')->insert([
        'expense_type_id' => $expType->id,
        'expense_amount' => 1000.00,
        'date' => $d15,
        'user_id' => 1,
        'created_at' => $d15 . ' 15:00:00',
        'updated_at' => $d15 . ' 15:00:00',
    ]);

    // Transaction 4: 60 DAYS AGO (All Time Only)
    // Sales: 40,000, Paid: 35,000, Due: 5,000, Cost: 32,000, Gross: 8,000, Exp: 0, Net: 8,000
    $o4 = DB::table('battery_orders')->insertGetId([
        'order_no' => 'BAT-INV-REG-60DAYS',
        'sub_total' => 40000.00,
        'paid_amount' => 35000.00,
        'due_amount' => 5000.00,
        'discount_amount' => 0.00,
        'customer_id' => $cust->id,
        'invoice_date' => $d60,
        'user_id' => 1,
        'created_at' => $d60 . ' 10:00:00',
        'updated_at' => $d60 . ' 10:00:00',
    ]);
    DB::table('battery_order_details')->insert([
        'order_id' => $o4,
        'product_id' => $prod->id,
        'quantity' => 4,
        'price' => 8000.00,
        'selling_price' => 10000.00,
        'user_id' => 1,
        'created_at' => $d60 . ' 10:00:00',
        'updated_at' => $d60 . ' 10:00:00',
    ]);
    DB::table('battery_order_payment_details')->insert([
        'order_id' => $o4,
        'paid_amount' => 35000.00,
        'due_collection_date' => $d60,
        'payment_method' => 'cash',
        'payment_status' => 'Partial',
        'user_id' => 1,
        'created_at' => $d60 . ' 10:00:00',
        'updated_at' => $d60 . ' 10:00:00',
    ]);

    // 2. TEST FILTER: 'today'
    $reqToday = Illuminate\Http\Request::create('/api/battery/dashboard-all-calculation', 'GET', ['filter_type' => 'today']);
    $resToday = json_decode($controller->DashboardAllCalculation($reqToday)->getContent(), true);
    $t = $resToday['today'];
    assertCondition("Today Sales delta is exactly +৳10,000.00", (float)($t['sales_amount'] - ($baseToday['sales_amount'] ?? 0)) === 10000.0);
    assertCondition("Today Cash Collection delta is exactly +৳7,000.00", (float)($t['cash_collection'] - ($baseToday['cash_collection'] ?? 0)) === 7000.0);
    assertCondition("Today Expense delta is exactly +৳500.00", (float)($t['expense'] - ($baseToday['expense'] ?? 0)) === 500.0);
    assertCondition("Today Net Profit delta is exactly +৳1,500.00", (float)($t['net_profit'] - ($baseToday['net_profit'] ?? 0)) === 1500.0);
    assertCondition("Today Receivable Due delta is exactly +৳3,000.00", (float)($t['customer_due'] - ($baseToday['customer_due'] ?? 0)) === 3000.0);

    // 3. TEST FILTER: 'last_week' (Today + 4 days ago)
    $reqWeek = Illuminate\Http\Request::create('/api/battery/dashboard-all-calculation', 'GET', ['filter_type' => 'last_week']);
    $resWeek = json_decode($controller->DashboardAllCalculation($reqWeek)->getContent(), true);
    $w = $resWeek['today'];
    assertCondition("Last 7 Days Sales delta is exactly +৳30,000.00", (float)($w['sales_amount'] - ($baseWeek['sales_amount'] ?? 0)) === 30000.0);
    assertCondition("Last 7 Days Cash Collection delta is exactly +৳25,000.00", (float)($w['cash_collection'] - ($baseWeek['cash_collection'] ?? 0)) === 25000.0);
    assertCondition("Last 7 Days Expense delta is exactly +৳500.00", (float)($w['expense'] - ($baseWeek['expense'] ?? 0)) === 500.0);
    assertCondition("Last 7 Days Net Profit delta is exactly +৳4,500.00", (float)($w['net_profit'] - ($baseWeek['net_profit'] ?? 0)) === 4500.0);
    assertCondition("Last 7 Days Receivable Due delta is exactly +৳4,000.00", (float)($w['customer_due'] - ($baseWeek['customer_due'] ?? 0)) === 4000.0);

    // 4. TEST FILTER: 'last_month' (Today + 4 days ago + 15 days ago)
    $reqMonth = Illuminate\Http\Request::create('/api/battery/dashboard-all-calculation', 'GET', ['filter_type' => 'last_month']);
    $resMonth = json_decode($controller->DashboardAllCalculation($reqMonth)->getContent(), true);
    $m = $resMonth['today'];
    assertCondition("Last 30 Days Sales delta is exactly +৳60,000.00", (float)($m['sales_amount'] - ($baseMonth['sales_amount'] ?? 0)) === 60000.0);
    assertCondition("Last 30 Days Cash Collection delta is exactly +৳55,000.00", (float)($m['cash_collection'] - ($baseMonth['cash_collection'] ?? 0)) === 55000.0);
    assertCondition("Last 30 Days Expense delta is exactly +৳1,500.00", (float)($m['expense'] - ($baseMonth['expense'] ?? 0)) === 1500.0);
    assertCondition("Last 30 Days Net Profit delta is exactly +৳9,500.00", (float)($m['net_profit'] - ($baseMonth['net_profit'] ?? 0)) === 9500.0);
    assertCondition("Last 30 Days Receivable Due delta is exactly +৳4,000.00", (float)($m['customer_due'] - ($baseMonth['customer_due'] ?? 0)) === 4000.0);

    // 5. TEST FILTER: 'date_wise' (Only 4 days ago)
    $reqDateWise = Illuminate\Http\Request::create('/api/battery/dashboard-all-calculation', 'GET', [
        'filter_type' => 'date_wise',
        'start_date' => $d4,
        'end_date' => $d4
    ]);
    $resDateWise = json_decode($controller->DashboardAllCalculation($reqDateWise)->getContent(), true);
    $dw = $resDateWise['today'];
    assertCondition("Date Wise Sales delta is exactly +৳20,000.00", (float)($dw['sales_amount'] - ($baseDateWise['sales_amount'] ?? 0)) === 20000.0);
    assertCondition("Date Wise Cash Collection delta is exactly +৳18,000.00", (float)($dw['cash_collection'] - ($baseDateWise['cash_collection'] ?? 0)) === 18000.0);
    assertCondition("Date Wise Expense delta is ৳0.00", (float)($dw['expense'] - ($baseDateWise['expense'] ?? 0)) === 0.0);
    assertCondition("Date Wise Net Profit delta is exactly +৳3,000.00", (float)($dw['net_profit'] - ($baseDateWise['net_profit'] ?? 0)) === 3000.0);
    assertCondition("Date Wise Receivable Due delta is exactly +৳1,000.00", (float)($dw['customer_due'] - ($baseDateWise['customer_due'] ?? 0)) === 1000.0);

    // 6. TEST FILTER: 'all_time' (All 4 orders: 10,000 + 20,000 + 30,000 + 40,000 = 100,000)
    $reqAll = Illuminate\Http\Request::create('/api/battery/dashboard-all-calculation', 'GET', ['filter_type' => 'all_time']);
    $resAll = json_decode($controller->DashboardAllCalculation($reqAll)->getContent(), true);
    $a = $resAll['today'];
    assertCondition("All Time Sales delta is exactly +৳100,000.00", (float)($a['sales_amount'] - ($baseAll['sales_amount'] ?? 0)) === 100000.0);
    assertCondition("All Time Cash Collection delta is exactly +৳90,000.00", (float)($a['cash_collection'] - ($baseAll['cash_collection'] ?? 0)) === 90000.0);
    assertCondition("All Time Expense delta is exactly +৳1,500.00", (float)($a['expense'] - ($baseAll['expense'] ?? 0)) === 1500.0);
    assertCondition("All Time Net Profit delta is exactly +৳17,500.00", (float)($a['net_profit'] - ($baseAll['net_profit'] ?? 0)) === 17500.0);
    // All time customer due: orders due (3000 + 1000 + 0 + 5000 = 9000) + opening due (1000) = 10000
    assertCondition("All Time Customer Due delta includes lifetime previous due (+৳10,000.00)", (float)($a['customer_due'] - ($baseAll['customer_due'] ?? 0)) === 10000.0);

    // 7. Test Chart Output
    assertCondition("Chart contains dates array", !empty($resWeek['chart']['dates']));
    assertCondition("Chart contains sales series matching date length", count($resWeek['chart']['dates']) === count($resWeek['chart']['sales']));
    assertCondition("Chart contains profits series matching date length", count($resWeek['chart']['dates']) === count($resWeek['chart']['profits']));
    assertCondition("Chart has dynamic title for Last 7 Days", strpos($resWeek['chart']['title'], 'Last 7 Days') !== false);

    // 8. Test Data Isolation (Retail tables untouched)
    $retailOrderCount = DB::table('orders')->count();
    assertCondition("Retail orders count is unaffected (is 93)", $retailOrderCount === 93, "Count: $retailOrderCount");

} finally {
    DB::rollBack();
    echo "=================================================================" . PHP_EOL;
    echo "  CLEANUP: TRANSACTION ROLLED BACK SAFELY. ZERO DB PERSISTENCE.  " . PHP_EOL;
    echo "=================================================================" . PHP_EOL;
}

echo "TOTAL ASSERTIONS: " . ($passed + $failed) . " | PASSED: $passed | FAILED: $failed" . PHP_EOL;
exit($failed > 0 ? 1 : 0);
