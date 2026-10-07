<?php

// database/verify_phase5_isolation.php
// Verification script for Database & Financial Calculation Isolation (Sections M & N)

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// Retail Models
use App\Models\Product as RetailProduct;
use App\Models\Customer as RetailCustomer;
use App\Models\Supplier as RetailSupplier;
use App\Models\Order as RetailOrder;
use App\Models\Expense as RetailExpense;
use App\Models\Purchase as RetailPurchase;
use App\Models\OrderPaymentDetails as RetailOrderPayment;
use App\Models\PurchasePaymentDetails as RetailPurchasePayment;
use App\Models\CustomerPaymentDetails as RetailCustomerPayment;
use App\Models\User;

// Battery Models
use App\Models\Battery\BatteryProduct;
use App\Models\Battery\BatteryCustomer;
use App\Models\Battery\BatterySupplier;
use App\Models\Battery\BatteryOrder;
use App\Models\Battery\BatteryOrderDetail;
use App\Models\Battery\BatteryOrderPaymentDetail;
use App\Models\Battery\BatteryPurchase;
use App\Models\Battery\BatteryPurchaseOrderDetail;
use App\Models\Battery\BatteryPurchasePaymentDetail;
use App\Models\Battery\BatteryExpense;
use App\Models\Battery\BatteryExpenseType;
use App\Models\Battery\BatteryCustomerPaymentDetail;

// Authenticate as first user if available
$user = User::first();
if ($user) {
    Auth::login($user);
}
$userId = $user ? $user->id : 1;

echo "====================================================================\n";
echo "   PHASE 5: DATABASE & FINANCIAL CALCULATION ISOLATION VERIFICATION\n";
echo "====================================================================\n\n";

$allPassed = true;
$testResults = [];

function recordTestResult($name, $passed, $details = '') {
    global $testResults, $allPassed;
    if (!$passed) $allPassed = false;
    $status = $passed ? "\033[32m[PASS]\033[0m" : "\033[31m[FAIL]\033[0m";
    echo "{$status} {$name}\n";
    if (!empty($details)) {
        echo "       {$details}\n";
    }
    $testResults[] = ['name' => $name, 'passed' => $passed, 'details' => $details];
}

// -------------------------------------------------------------------------------------------------
// TEST A: RETAIL RECORD INSERTION & BATTERY VISIBILITY ISOLATION
// -------------------------------------------------------------------------------------------------
echo "\n--- TEST A: Retail Insertion vs Battery Isolation ---\n";

$retailToken = 'RETAIL-ISOLATION-TEST-9999';
$batToken = 'BATTERY-ISOLATION-TEST-9999';

// Pre-cleanup child records first, then parents
DB::table('battery_customer_payment_details')->whereIn('customer_id', function($q) use ($batToken) {
    $q->select('id')->from('battery_customers')->where('address_details', 'like', "%{$batToken}%");
})->delete();

$testOrderIds = DB::table('battery_orders')->where('order_no', 'BAT-INV-ISO-9999')->pluck('id');
DB::table('battery_order_payment_details')->whereIn('order_id', $testOrderIds)->delete();
DB::table('battery_order_details')->whereIn('order_id', $testOrderIds)->delete();
DB::table('battery_orders')->where('order_no', 'BAT-INV-ISO-9999')->delete();

$testPurchaseIds = DB::table('battery_purchases')->where('purchase_id', 'BAT-PUR-ISO-9999')->pluck('id');
DB::table('battery_purchase_payment_details')->whereIn('purchases_id', $testPurchaseIds)->delete();
DB::table('battery_purchase_order_details')->whereIn('purchase_id', $testPurchaseIds)->delete();
DB::table('battery_purchases')->where('purchase_id', 'BAT-PUR-ISO-9999')->delete();

DB::table('battery_expenses')->where('expense_details', 'like', "%Battery isolation test expense%")->delete();
DB::table('battery_expense_types')->where('type_name', 'Battery Iso Type')->delete();

DB::table('battery_customers')->where('address_details', 'like', "%{$batToken}%")->delete();
DB::table('battery_suppliers')->where('address', 'like', "%{$batToken}%")->delete();
DB::table('battery_products')->where('product_name', 'like', "%{$batToken}%")->delete();

DB::table('products')->where('product_name', 'like', "%{$retailToken}%")->delete();
DB::table('customers')->where('address_details', 'like', "%{$retailToken}%")->delete();
DB::table('suppliers')->where('address', 'like', "%{$retailToken}%")->delete();

// 1. Insert unique Retail Product
$rProd = DB::table('products')->insertGetId([
    'product_name' => 'Retail Iso Test Product',
    'product_code' => json_encode([$retailToken]),
    'sell_price' => 500.00,
    'cost_price' => 300.00,
    'quantity' => 50,
    'brand_id' => 1,
    'category_id' => 1,
    'status' => 'Active',
    'user_id' => $userId,
    'created_at' => now(),
    'updated_at' => now(),
]);

// 2. Insert unique Retail Customer
$rCust = DB::table('customers')->insertGetId([
    'customer_id' => 'CUST-ISO-9999',
    'customer_name' => 'Retail Iso Customer',
    'mobile' => '01999999999',
    'address_details' => $retailToken,
    'previous_due_amount' => 1250.00,
    'user_id' => $userId,
    'created_at' => now(),
    'updated_at' => now(),
]);

// 3. Insert unique Retail Supplier
$rSupp = DB::table('suppliers')->insertGetId([
    'supplier_id' => 'SUP-ISO-9999',
    'name' => 'Retail Iso Supplier',
    'company' => 'Retail Iso Company',
    'mobile' => '01888888888',
    'address' => $retailToken,
    'purchase_payable_amount' => 2500.00,
    'status' => 'Active',
    'user_id' => $userId,
    'created_at' => now(),
    'updated_at' => now(),
]);

// Check Battery queries for leak of retail token
$batProdMatch = BatteryProduct::where('product_name', 'like', "%{$retailToken}%")
    ->orWhere('product_code', 'like', "%{$retailToken}%")
    ->count();

$batCustMatch = BatteryCustomer::where('customer_name', 'like', "%{$retailToken}%")
    ->orWhere('mobile', '01999999999')
    ->orWhere('address_details', 'like', "%{$retailToken}%")
    ->count();

$batSuppMatch = BatterySupplier::where('name', 'like', "%{$retailToken}%")
    ->orWhere('mobile', '01888888888')
    ->orWhere('address', 'like', "%{$retailToken}%")
    ->count();

recordTestResult(
    'A.1 Retail Product never appears in Battery Product queries',
    $batProdMatch === 0,
    "Matches found in battery_products: {$batProdMatch} (Expected: 0)"
);

recordTestResult(
    'A.2 Retail Customer never appears in Battery Customer queries',
    $batCustMatch === 0,
    "Matches found in battery_customers: {$batCustMatch} (Expected: 0)"
);

recordTestResult(
    'A.3 Retail Supplier never appears in Battery Supplier queries',
    $batSuppMatch === 0,
    "Matches found in battery_suppliers: {$batSuppMatch} (Expected: 0)"
);

// -------------------------------------------------------------------------------------------------
// TEST B: BATTERY RECORD INSERTION & RETAIL VISIBILITY ISOLATION
// -------------------------------------------------------------------------------------------------
echo "\n--- TEST B: Battery Insertion vs Retail Isolation ---\n";

$batToken = 'BATTERY-ISOLATION-TEST-9999';

// 1. Insert unique Battery Product
$bProd = DB::table('battery_products')->insertGetId([
    'product_name' => 'Battery Iso Test Product',
    'product_code' => json_encode([$batToken]),
    'cost_price' => 2000.00,
    'sell_price' => 3200.00,
    'quantity' => 15,
    'brand_id' => 1,
    'category_id' => 1,
    'status' => 'Active',
    'user_id' => $userId,
    'created_at' => now(),
    'updated_at' => now(),
]);

// 2. Insert unique Battery Customer
$bCust = DB::table('battery_customers')->insertGetId([
    'customer_id' => 'BAT-CUST-ISO-9999',
    'customer_name' => 'Battery Iso Customer',
    'mobile' => '01777777777',
    'address_details' => $batToken,
    'previous_due_amount' => 3500.00,
    'user_id' => $userId,
    'created_at' => now(),
    'updated_at' => now(),
]);

// 3. Insert unique Battery Supplier
$bSupp = DB::table('battery_suppliers')->insertGetId([
    'supplier_id' => 'BAT-SUP-ISO-9999',
    'name' => 'Battery Iso Supplier',
    'company' => 'Battery Iso Company',
    'mobile' => '01666666666',
    'address' => $batToken,
    'purchase_payable_amount' => 4500.00,
    'user_id' => $userId,
    'created_at' => now(),
    'updated_at' => now(),
]);

// Check Retail queries for leak of battery token
$retProdMatch = RetailProduct::where('product_name', 'like', "%{$batToken}%")
    ->orWhere('product_code', 'like', "%{$batToken}%")
    ->count();

$retCustMatch = RetailCustomer::where('customer_name', 'like', "%{$batToken}%")
    ->orWhere('mobile', '01777777777')
    ->orWhere('address_details', 'like', "%{$batToken}%")
    ->count();

$retSuppMatch = RetailSupplier::where('name', 'like', "%{$batToken}%")
    ->orWhere('mobile', '01666666666')
    ->orWhere('address', 'like', "%{$batToken}%")
    ->count();

recordTestResult(
    'B.1 Battery Product never appears in Retail Product queries',
    $retProdMatch === 0,
    "Matches found in products: {$retProdMatch} (Expected: 0)"
);

recordTestResult(
    'B.2 Battery Customer never appears in Retail Customer queries',
    $retCustMatch === 0,
    "Matches found in customers: {$retCustMatch} (Expected: 0)"
);

recordTestResult(
    'B.3 Battery Supplier never appears in Retail Supplier queries',
    $retSuppMatch === 0,
    "Matches found in suppliers: {$retSuppMatch} (Expected: 0)"
);

// -------------------------------------------------------------------------------------------------
// TEST C: BATTERY TRANSACTIONS VS RETAIL FINANCIAL DELTAS (ZERO-DELTA GUARANTEE)
// -------------------------------------------------------------------------------------------------
echo "\n--- TEST C: Battery Transactions vs Retail Financial Balances (Zero-Delta Guarantee) ---\n";

// Baseline Retail Financial State
$baselineRetailSales = (float) DB::table('orders')->sum('sub_total');
$baselineRetailOrderDetailsCount = DB::table('order_details')->count();
$baselineRetailCustomerReceivables = (float) DB::table('customers')->sum('previous_due_amount') + (float) DB::table('orders')->sum('due_amount');
$baselineRetailSupplierPayables = (float) DB::table('suppliers')->sum('purchase_payable_amount') + (float) DB::table('purchases')->sum('due_amount');
$baselineRetailPurchases = (float) DB::table('purchases')->sum('grand_subtotal');
$baselineRetailPurchaseDetailsCount = DB::table('purchase_order_details')->count();
$baselineRetailExpenses = (float) DB::table('expenses')->sum('expense_amount');
$baselineRetailOrderPayments = (float) DB::table('order_payment_details')->sum('paid_amount');
$baselineRetailPurchasePayments = (float) DB::table('purchase_payment_details')->sum('paid_amount');
$baselineRetailCustDueCollections = (float) DB::table('customer_payment_details')->sum('paid_amount');

echo "Baseline Retail Metrics Captured:\n";
echo " - Retail Sales (sub_total): " . number_format($baselineRetailSales, 2) . "\n";
echo " - Retail Customer Total Due: " . number_format($baselineRetailCustomerReceivables, 2) . "\n";
echo " - Retail Supplier Total Due: " . number_format($baselineRetailSupplierPayables, 2) . "\n";
echo " - Retail Purchases (grand_subtotal): " . number_format($baselineRetailPurchases, 2) . "\n";
echo " - Retail Expenses (expense_amount): " . number_format($baselineRetailExpenses, 2) . "\n";
echo " - Retail Order Payments (paid_amount): " . number_format($baselineRetailOrderPayments, 2) . "\n\n";

// Execute simulated battery transactions:
// 1. Battery Sale (Order, Detail, Payment)
$bOrder = DB::table('battery_orders')->insertGetId([
    'order_no' => 'BAT-INV-ISO-9999',
    'customer_id' => $bCust,
    'sub_total' => 3200.00,
    'discount_amount' => 200.00,
    'paid_amount' => 2500.00,
    'due_amount' => 500.00,
    'invoice_date' => now()->toDateString(),
    'user_id' => $userId,
    'created_at' => now(),
    'updated_at' => now(),
]);

$bOrderDetail = DB::table('battery_order_details')->insertGetId([
    'order_id' => $bOrder,
    'product_id' => $bProd,
    'quantity' => 1,
    'price' => 2000.00,
    'selling_price' => 3200.00,
    'user_id' => $userId,
    'created_at' => now(),
    'updated_at' => now(),
]);

$bOrderPayment = DB::table('battery_order_payment_details')->insertGetId([
    'order_id' => $bOrder,
    'paid_amount' => 2500.00,
    'payment_method' => 'Cash',
    'user_id' => $userId,
    'created_at' => now(),
    'updated_at' => now(),
]);

// 2. Battery Purchase (Purchase, Detail, Payment)
$bPurchase = DB::table('battery_purchases')->insertGetId([
    'purchase_id' => 'BAT-PUR-ISO-9999',
    'supplier_id' => $bSupp,
    'purchase_payable_amount' => 10000.00,
    'grand_subtotal' => 10000.00,
    'paid_amount' => 6000.00,
    'due_amount' => 4000.00,
    'date' => now()->toDateString(),
    'user_id' => $userId,
    'created_at' => now(),
    'updated_at' => now(),
]);

$bPurchaseDetail = DB::table('battery_purchase_order_details')->insertGetId([
    'purchase_id' => $bPurchase,
    'product_id' => $bProd,
    'quantity' => 5,
    'cost_price' => 2000.00,
    'subtotal' => 10000.00,
    'user_id' => $userId,
    'created_at' => now(),
    'updated_at' => now(),
]);

$bPurchasePayment = DB::table('battery_purchase_payment_details')->insertGetId([
    'purchases_id' => $bPurchase,
    'paid_amount' => 6000.00,
    'payment_method' => 'Cash',
    'user_id' => $userId,
    'created_at' => now(),
    'updated_at' => now(),
]);

// 3. Battery Expense
$bExpenseType = DB::table('battery_expense_types')->insertGetId([
    'type_name' => 'Battery Iso Type',
    'user_id' => $userId,
    'created_at' => now(),
    'updated_at' => now(),
]);

$bExpense = DB::table('battery_expenses')->insertGetId([
    'expense_type_id' => $bExpenseType,
    'expense_amount' => 750.00,
    'date' => now()->toDateString(),
    'expense_details' => 'Battery isolation test expense',
    'user_id' => $userId,
    'created_at' => now(),
    'updated_at' => now(),
]);

// 4. Battery Customer Due Collection
$bCustPayment = DB::table('battery_customer_payment_details')->insertGetId([
    'customer_id' => $bCust,
    'paid_amount' => 500.00,
    'payment_method' => 'Cash',
    'user_id' => $userId,
    'created_at' => now(),
    'updated_at' => now(),
]);

// Post-Transaction Retail Financial State
$postRetailSales = (float) DB::table('orders')->sum('sub_total');
$postRetailOrderDetailsCount = DB::table('order_details')->count();
$postRetailCustomerReceivables = (float) DB::table('customers')->sum('previous_due_amount') + (float) DB::table('orders')->sum('due_amount');
$postRetailSupplierPayables = (float) DB::table('suppliers')->sum('purchase_payable_amount') + (float) DB::table('purchases')->sum('due_amount');
$postRetailPurchases = (float) DB::table('purchases')->sum('grand_subtotal');
$postRetailPurchaseDetailsCount = DB::table('purchase_order_details')->count();
$postRetailExpenses = (float) DB::table('expenses')->sum('expense_amount');
$postRetailOrderPayments = (float) DB::table('order_payment_details')->sum('paid_amount');
$postRetailPurchasePayments = (float) DB::table('purchase_payment_details')->sum('paid_amount');
$postRetailCustDueCollections = (float) DB::table('customer_payment_details')->sum('paid_amount');

// Verification of exact 0.00 deltas
$deltaSales = abs($postRetailSales - $baselineRetailSales);
$deltaOrderDetails = $postRetailOrderDetailsCount - $baselineRetailOrderDetailsCount;
$deltaCustReceivables = abs($postRetailCustomerReceivables - $baselineRetailCustomerReceivables);
$deltaSuppPayables = abs($postRetailSupplierPayables - $baselineRetailSupplierPayables);
$deltaPurchases = abs($postRetailPurchases - $baselineRetailPurchases);
$deltaPurchaseDetails = $postRetailPurchaseDetailsCount - $baselineRetailPurchaseDetailsCount;
$deltaExpenses = abs($postRetailExpenses - $baselineRetailExpenses);
$deltaOrderPayments = abs($postRetailOrderPayments - $baselineRetailOrderPayments);
$deltaPurchasePayments = abs($postRetailPurchasePayments - $baselineRetailPurchasePayments);
$deltaCustDueCollections = abs($postRetailCustDueCollections - $baselineRetailCustDueCollections);

recordTestResult(
    'C.1 Retail Sales Subtotal Delta is Exactly 0.00',
    $deltaSales < 0.0001,
    "Baseline: {$baselineRetailSales}, Post: {$postRetailSales}, Delta: {$deltaSales}"
);

recordTestResult(
    'C.2 Retail Order Details Count Delta is Exactly 0',
    $deltaOrderDetails === 0,
    "Delta: {$deltaOrderDetails}"
);

recordTestResult(
    'C.3 Retail Customer Total Receivables Delta is Exactly 0.00',
    $deltaCustReceivables < 0.0001,
    "Baseline: {$baselineRetailCustomerReceivables}, Post: {$postRetailCustomerReceivables}, Delta: {$deltaCustReceivables}"
);

recordTestResult(
    'C.4 Retail Supplier Total Payables Delta is Exactly 0.00',
    $deltaSuppPayables < 0.0001,
    "Baseline: {$baselineRetailSupplierPayables}, Post: {$postRetailSupplierPayables}, Delta: {$deltaSuppPayables}"
);

recordTestResult(
    'C.5 Retail Purchases Grand Subtotal Delta is Exactly 0.00',
    $deltaPurchases < 0.0001,
    "Baseline: {$baselineRetailPurchases}, Post: {$postRetailPurchases}, Delta: {$deltaPurchases}"
);

recordTestResult(
    'C.6 Retail Expenses Delta is Exactly 0.00',
    $deltaExpenses < 0.0001,
    "Baseline: {$baselineRetailExpenses}, Post: {$postRetailExpenses}, Delta: {$deltaExpenses}"
);

recordTestResult(
    'C.7 Retail Payment Ledger (Order + Purchase + Due) Delta is Exactly 0.00',
    ($deltaOrderPayments + $deltaPurchasePayments + $deltaCustDueCollections) < 0.0001,
    "Order Payment Delta: {$deltaOrderPayments}, Purchase Payment Delta: {$deltaPurchasePayments}, Due Col Delta: {$deltaCustDueCollections}"
);

// -------------------------------------------------------------------------------------------------
// TEST D: COMPLETE CLEANUP OF TEST ARTIFACTS
// -------------------------------------------------------------------------------------------------
echo "\n--- TEST D: Test Records Cleanup ---\n";

// Delete Retail Test Records
DB::table('products')->where('id', $rProd)->delete();
DB::table('customers')->where('id', $rCust)->delete();
DB::table('suppliers')->where('id', $rSupp)->delete();

// Delete Battery Test Records
DB::table('battery_customer_payment_details')->where('id', $bCustPayment)->delete();
DB::table('battery_expenses')->where('id', $bExpense)->delete();
DB::table('battery_expense_types')->where('id', $bExpenseType)->delete();
DB::table('battery_purchase_payment_details')->where('id', $bPurchasePayment)->delete();
DB::table('battery_purchase_order_details')->where('id', $bPurchaseDetail)->delete();
DB::table('battery_purchases')->where('id', $bPurchase)->delete();
DB::table('battery_order_payment_details')->where('id', $bOrderPayment)->delete();
DB::table('battery_order_details')->where('id', $bOrderDetail)->delete();
DB::table('battery_orders')->where('id', $bOrder)->delete();
DB::table('battery_suppliers')->where('id', $bSupp)->delete();
DB::table('battery_customers')->where('id', $bCust)->delete();
DB::table('battery_products')->where('id', $bProd)->delete();

// Verify cleanup
$remRetailProd = DB::table('products')->where('id', $rProd)->count();
$remRetailCust = DB::table('customers')->where('id', $rCust)->count();
$remRetailSupp = DB::table('suppliers')->where('id', $rSupp)->count();
$remBatteryOrder = DB::table('battery_orders')->where('id', $bOrder)->count();
$remBatteryPurchase = DB::table('battery_purchases')->where('id', $bPurchase)->count();
$remBatteryExpense = DB::table('battery_expenses')->where('id', $bExpense)->count();

$cleanupPassed = ($remRetailProd === 0 && $remRetailCust === 0 && $remRetailSupp === 0 && 
                  $remBatteryOrder === 0 && $remBatteryPurchase === 0 && $remBatteryExpense === 0);

recordTestResult(
    'D.1 All Temporary Test Records Cleaned Up With 0 Remnants',
    $cleanupPassed,
    "Remnants: Retail(P:{$remRetailProd}, C:{$remRetailCust}, S:{$remRetailSupp}) | Battery(O:{$remBatteryOrder}, P:{$remBatteryPurchase}, E:{$remBatteryExpense})"
);

echo "\n====================================================================\n";
if ($allPassed) {
    echo "   \033[32mALL ISOLATION TESTS PASSED (100% COMPLETE & ZERO DELTA VERIFIED)\033[0m\n";
} else {
    echo "   \033[31mSOME ISOLATION TESTS FAILED - REVIEW LOGS ABOVE\033[0m\n";
}
echo "====================================================================\n";

exit($allPassed ? 0 : 1);
