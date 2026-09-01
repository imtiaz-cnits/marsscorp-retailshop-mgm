<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Invest;
use App\Models\Expense;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrderPaymentDetails;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerPaymentDetails;
use App\Models\PurchasePaymentDetails;
use App\Models\OpeningBalance;

class ReportManagementController extends Controller
{





public function SalesReportList(Request $request)
{
    try {
        $user_id = Auth::id();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validate the date inputs
        if (!$startDate || !$endDate) {
            return response()->json(['status' => 'fail', 'message' => 'Start and End dates are required']);
        }

        // Validate the format of the dates
        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
        $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

        if (!$startDate || !$endDate) {
            return response()->json(['status' => 'fail', 'message' => 'Invalid date format. Please use YYYY-MM-DD']);
        }

        // Query invoices filtered by date range and user, including product return amounts
        $invoices = Order::with(['productReturns','details'])
            ->where('user_id', $user_id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->map(function ($order) {
                // Calculate the total return amount for the order
                $returnAmount = $order->productReturns->sum('amount');
                $orderDetailsAmount = $order->details->sum('price');
                $orderDetailsSellingAmount = $order->details->sum('selling_price');
                return [
                    'order_no' => $order->order_no,
                    'paid_amount' => $order->paid_amount,
                    'due_amount' => $order->due_amount,
                    'return_amount' => $returnAmount,
                    'total_cost' => $orderDetailsAmount,
                    'selling_price' => $orderDetailsSellingAmount,
                ];
            });

        return response()->json(['status' => 'success', 'SalesReportData' => $invoices]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}

// Daily Receipt And Payment Report
public function DailyReceiptPaymentReport(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate   = $request->input('end_date');

            if (!$startDate || !$endDate) {
                return response()->json(['status' => 'fail', 'message' => 'Date required']);
            }

            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate   = Carbon::parse($endDate)->endOfDay();

            // ১. আজকের জন্য Opening Balance বের করা
            $openingBalance = $this->getOpeningBalanceForDate($startDate);

            // ২. আজকের ট্রানজেকশন
            $collectionFromSales = DB::table('order_payment_details')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('paid_amount') ?? 0;

            $collectionFromCustomerDue= DB::table('customer_payment_details')
                ->whereBetween('due_collection_date', [$startDate, $endDate])
                ->sum('previous_due_amount') ?? 0;

            $totalCollectionFromSales = $collectionFromSales + $collectionFromCustomerDue;

            $totalPaidToSupplier = DB::table('purchase_payment_details')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('paid_amount') ?? 0;

            $totalExpense = DB::table('expenses')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('expense_amount') ?? 0;

            // ৩. আজকের Closing Balance (কালকের Opening হবে)
            $closingBalance = $openingBalance 
                            + $collectionFromSales 
                            - $totalPaidToSupplier 
                            - $totalExpense;

            // বিস্তারিত রিপোর্ট
            $supplierPayments = DB::table('purchase_payment_details')
                ->join('purchases', 'purchase_payment_details.purchases_id', '=', 'purchases.id')
                ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
                ->whereBetween('purchase_payment_details.created_at', [$startDate, $endDate])
                ->selectRaw('suppliers.name as supplier_name, SUM(purchase_payment_details.paid_amount) as total_paid')
                ->groupBy('suppliers.id', 'suppliers.name')
                ->get();

            $expensesByType = DB::table('expenses')
                ->join('expense_types', 'expenses.expense_type_id', '=', 'expense_types.id')
                ->whereBetween('expenses.created_at', [$startDate, $endDate])
                ->selectRaw('expense_types.type_name, SUM(expenses.expense_amount) as total_expense')
                ->groupBy('expense_types.id', 'expense_types.type_name')
                ->get();

            return response()->json([
                'status'               => 'success',
                'OpeningBalance'       => round($openingBalance, 2),
                'CollectionFromSales'  => round($totalCollectionFromSales, 2),
                'TotalPaidToSupplier'  => round($totalPaidToSupplier, 2),
                'TotalExpense'         => round($totalExpense, 2),
                'ClosingBalance'       => round($closingBalance, 2),
                'TotalBalanceAmount'   => round($closingBalance, 2), // ফ্রন্টএন্ডে যেটা দেখাচ্ছো
                'SupplierPayments'     => $supplierPayments,
                'Expenses'             => $expensesByType,
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // এটাই তোমার চাওয়া মতো সবচেয়ে সিম্পল + সঠিক লজিক
    private function getOpeningBalanceForDate($targetDate)
    {
        // Step 1: সর্বশেষ ম্যানুয়াল Opening Balance খুঁজে বের করো (যেটা targetDate এর আগে বা সমান)
        $lastManual = DB::table('opening_balances')
            ->where('date', '<=', $targetDate)
            ->orderBy('date', 'desc')
            ->first();

        if (!$lastManual) {
            // কখনো Opening Balance দেওয়া হয়নি → 0
            return 0.00;
        }

        $manualDate = Carbon::parse($lastManual->date)->startOfDay();
        $manualAmount = floatval($lastManual->amount);

        // Step 2: যদি আজকেই ম্যানুয়াল Opening দেওয়া হয় → শুধু সেটাই রিটার্ন করো
        if ($manualDate->isSameDay($targetDate)) {
            return $manualAmount;
        }

        // Step 3: যদি আগের কোনো দিন দেওয়া হয় → সেই দিনের পর থেকে আজ পর্যন্ত নেট ফ্লো যোগ করো
        $netFlow = $this->calculateNetFlowFrom($manualDate->copy()->addDay(), $targetDate);

        return $manualAmount + $netFlow;
    }

    // নেট ক্যাশ ফ্লো (Income - Supplier Payment - Expense)
    private function calculateNetFlowFrom($fromDate, $toDate)
    {
        $income = DB::table('order_payment_details')
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<', $toDate)
            ->sum('paid_amount') ?? 0;

        $supplierPayment = DB::table('purchase_payment_details')
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<', $toDate)
            ->sum('paid_amount') ?? 0;

        $expense = DB::table('expenses')
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<', $toDate)
            ->sum('expense_amount') ?? 0;

        return $income - $supplierPayment - $expense;
    }
// public function DailyReceiptPaymentReport(Request $request)
// {
//     try {
//         $startDate = $request->input('start_date');
//         $endDate   = $request->input('end_date');

//         if (!$startDate || !$endDate) {
//             return response()->json(['status' => 'fail', 'message' => 'Start and End dates are required']);
//         }

//         $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
//         $endDate   = \Carbon\Carbon::parse($endDate)->endOfDay();

//         // Step 1: Get the latest Opening Balance before or on startDate
//         $latestOpeningBalance = \DB::table('opening_balances')
//             ->where('date', '<=', $startDate)
//             ->orderBy('date', 'desc')
//             ->first();

//         $openingBalance = 0;

//         if ($latestOpeningBalance) {
//             // যদি ম্যানুয়ালি Opening Balance দেওয়া থাকে → সেটাই প্রাইমারি
//             $openingBalance = floatval($latestOpeningBalance->amount);
//             $openingDate    = \Carbon\Carbon::parse($latestOpeningBalance->date)->startOfDay();

//             // এখন এই তারিখের পর থেকে শুরু করে startDate পর্যন্ত ট্রানজেকশন যোগ করবো
//             $balanceTillStartDate = $this->calculateNetCashFlow($openingDate, $startDate);

//             $openingBalance += $balanceTillStartDate;
//         } else {
//             // কোনো Opening Balance নাই → শুরু থেকে হিসাব করো
//             $openingBalance = $this->calculateNetCashFlow(null, $startDate);
//         }

//         // Step 2: Collection from Sales (within date range)
//         $collectionFromSales = \DB::table('order_payment_details')
//             ->whereBetween('created_at', [$startDate, $endDate])
//             ->sum('paid_amount');

//         // Step 3: Payment to Suppliers (within date range)
//         $supplierPayments = \DB::table('purchase_payment_details')
//             ->join('purchases', 'purchase_payment_details.purchases_id', '=', 'purchases.id')
//             ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
//             ->whereBetween('purchase_payment_details.created_at', [$startDate, $endDate])
//             ->selectRaw('
//                 suppliers.supplier_id,
//                 suppliers.name as supplier_name,
//                 SUM(purchase_payment_details.paid_amount) as total_paid
//             ')
//             ->groupBy('suppliers.supplier_id', 'suppliers.name')
//             ->get();

//         // Step 4: Expenses by Type
//         $expensesByType = \DB::table('expenses')
//             ->join('expense_types', 'expenses.expense_type_id', '=', 'expense_types.id')
//             ->whereBetween('expenses.created_at', [$startDate, $endDate])
//             ->selectRaw('
//                 expense_types.type_name,
//                 SUM(expenses.expense_amount) as total_expense
//             ')
//             ->groupBy('expense_types.id', 'expense_types.type_name')
//             ->get();

//         // Final Response
//         return response()->json([
//             'status'              => 'success',
//             'OpeningBalance'      => round($openingBalance, 2),
//             'CollectionFromSales' => round($collectionFromSales, 2),
//             'SupplierPayments'    => $supplierPayments,
//             'Expenses'            => $expensesByType,
//             'TotalPaidToSupplier' => round($supplierPayments->sum('total_paid'), 2),
//             'TotalExpense'        => round($expensesByType->sum('total_expense'), 2),
//             'NetCashFlowToday'    => round($collectionFromSales - $supplierPayments->sum('total_paid') - $expensesByType->sum('total_expense'), 2),
//             'ClosingBalance'      => round($openingBalance + $collectionFromSales - $supplierPayments->sum('total_paid') - $expensesByType->sum('total_expense'), 2),
//         ]);

//     } catch (\Exception $e) {
//         \Log::error('Daily Report Error: ' . $e->getMessage());
//         return response()->json(['status' => 'error', 'message' => 'Server Error: ' . $e->getMessage()], 500);
//     }
// }

// /**
//  * Helper: Calculate net cash flow between two dates
//  * Income: Sales Collection
//  * Expense: Purchase Payment + Expenses
//  */
// private function calculateNetCashFlow($fromDate = null, $toDate)
// {
//     $queryIncome = \DB::table('order_payment_details');
//     $queryPurchasePayment = \DB::table('purchase_payment_details');
//     $queryExpense = \DB::table('expenses');

//     if ($fromDate) {
//         $fromDate = \Carbon\Carbon::parse($fromDate)->addDay()->startOfDay(); // next day from opening
//         $queryIncome = $queryIncome->where('created_at', '>=', $fromDate);
//         $queryPurchasePayment = $queryPurchasePayment->where('created_at', '>=', $fromDate);
//         $queryExpense = $queryExpense->where('created_at', '>=', $fromDate);
//     }

//     $totalIncome = $queryIncome->where('created_at', '<', $toDate)->sum('paid_amount');
//     $totalPurchasePayment = $queryPurchasePayment->where('created_at', '<', $toDate)->sum('paid_amount');
//     $totalExpense = $queryExpense->where('created_at', '<', $toDate)->sum('expense_amount');

//     return $totalIncome - ($totalPurchasePayment + $totalExpense);
// }


// public function DailyReceiptPaymentReport(Request $request)
// {
//     try {
//         $user_id = Auth::id();

//         $startDate = $request->input('start_date');
//         $endDate = $request->input('end_date');

//         // Validate the date inputs
//         if (!$startDate || !$endDate) {
//             return response()->json(['status' => 'fail', 'message' => 'Start and End dates are required']);
//         }

//         // Validate the format of the dates
//         $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
//         $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

//         // Calculate Opening Balance (Total payments - Total expenses - Total purchases before startDate)
//         $totalPreviousPayments = OrderPaymentDetails::where('created_at', '<', $startDate)->sum('paid_amount');
//         $totalPreviousExpenses = Expense::where('created_at', '<', $startDate)->sum('expense_amount');
//         $totalPreviousPurchases = Purchase::where('created_at', '<', $startDate)->sum('due_amount');

//         $openingBalance = $totalPreviousPayments - ($totalPreviousExpenses + $totalPreviousPurchases);
        

//         // Calculate Collection From Sales during the provided date range
//         $collectionFromSales = OrderPaymentDetails::whereBetween('created_at', [$startDate, $endDate])->sum('paid_amount');

//         // Daily Receipt & Payment Report - সঠিক উপায় (তোমার সিস্টেমের সাথে মিলবে)
//         $paymentToSuppliers = PurchasePaymentDetails::whereBetween('purchase_payment_details.created_at', [$startDate, $endDate])
//             ->join('purchases', 'purchase_payment_details.purchases_id', '=', 'purchases.id') // এটাই সঠিক
//             ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
//             ->selectRaw('
//                 suppliers.id as supplier_id, 
//                 suppliers.name as supplier_name, 
//                 SUM(purchase_payment_details.paid_amount) as total_paid
//             ')
//             ->groupBy('suppliers.id', 'suppliers.name')
//             ->get();
// // Calculate Expenses grouped by Expense Type during the provided date range
// $expensesByType = Expense::join('expense_types', 'expenses.expense_type_id', '=', 'expense_types.id')
//     ->whereBetween('expenses.created_at', [$startDate, $endDate]) // Specify table alias for created_at
//     ->selectRaw('expense_types.id as expense_type_id, expense_types.type_name, SUM(expenses.expense_amount) as total_expense')
//     ->groupBy('expense_types.id', 'expense_types.type_name')
//     ->get();


//         return response()->json([
//             'OpeningBalance' => $openingBalance,
//             'CollectionFromSales' => $collectionFromSales,
//             'SupplierPayments' => $paymentToSuppliers,
//             'Expenses' => $expensesByType
//         ]);
//     } catch (Exception $e) {
//         return response()->json(['error' => 'Unable to fetch total values. ' . $e->getMessage()], 500);
//     }
// }

// public function DailyReceiptPaymentReport(Request $request)
// {
//     try {
//         $authUser = Auth::user();

//         // যদি সুপার এডমিন বা অ্যাকাউন্ট্যান্ট হয় — তাহলে user_id প্যারামিটার থেকে নেবে
//         $targetUserId = $request->input('user_id');

//         // শুধু এডমিনই অন্যের রিপোর্ট দেখতে পারবে
//         if ($targetUserId && $authUser->role === 'admin') { // role = 'admin' বা 'accountant' যা তোমার আছে
//             $user_id = $targetUserId;
//         } else {
//             $user_id = $authUser->id; // নরমাল ইউজার শুধু নিজেরটা দেখবে
//         }

//         $startDate = $request->input('start_date');
//         $endDate   = $request->input('end_date');

//         if (!$startDate || !$endDate) {
//             return response()->json(['status' => 'fail', 'message' => 'Dates required']);
//         }

//         $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
//         $endDate   = \Carbon\Carbon::parse($endDate)->endOfDay();

//         // ম্যানুয়াল Opening Balance চেক করো
//         $manualOpening = OpeningBalance::where('user_id', $user_id)->first();

//         if ($manualOpening && $manualOpening->date <= $startDate->format('Y-m-d')) {
//             $openingBalance = $manualOpening->amount;
//         } else {
//             // অটো ক্যালকুলেট করো (startDate এর আগের সব ট্রানজেকশন)
//             $previousSales     = OrderPaymentDetails::where('user_id', $user_id)
//                 ->where('created_at', '<', $startDate)->sum('paid_amount');

//             $previousPurchases = PurchasePaymentDetails::where('user_id', $user_id)
//                 ->where('created_at', '<', $startDate)->sum('paid_amount');

//             $previousExpenses  = Expense::where('user_id', $user_id)
//                 ->where('created_at', '<', $startDate)->sum('expense_amount');

//             $openingBalance = $previousSales - ($previousPurchases + $previousExpenses);
//         }

//         // রিপোর্টের তারিখের মধ্যে ডাটা
//         $collectionFromSales = OrderPaymentDetails::where('user_id', $user_id)
//             ->whereBetween('created_at', [$startDate, $endDate])->sum('paid_amount');

//         $paymentToSuppliers = PurchasePaymentDetails::where('user_id', $user_id)
//             ->whereBetween('created_at', [$startDate, $endDate])
//             ->join('purchases', 'purchase_payment_details.purchases_id', '=', 'purchases.id')
//             ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
//             ->selectRaw('suppliers.name as supplier_name, SUM(purchase_payment_details.paid_amount) as total_paid')
//             ->groupBy('suppliers.id', 'suppliers.name')
//             ->get();

//         $expensesByType = Expense::where('user_id', $user_id)
//             ->whereBetween('created_at', [$startDate, $endDate])
//             ->join('expense_types', 'expenses.expense_type_id', '=', 'expense_types.id')
//             ->selectRaw('expense_types.type_name, SUM(expenses.expense_amount) as total_expense')
//             ->groupBy('expense_types.id', 'expense_types.type_name')
//             ->get();

//         // ক্লোজিং ব্যালেন্স
//         $totalPaidToSuppliers = $paymentToSuppliers->sum('total_paid');
//         $totalExpenses = $expensesByType->sum('total_expense');

//         $closingBalance = $openingBalance + $collectionFromSales - ($totalPaidToSuppliers + $totalExpenses);

//         return response()->json([
//             'status' => 'success',
//             'user_id' => $user_id,
//             'user_name' => \App\Models\User::find($user_id)?->name ?? 'Unknown',
//             'report_date_range' => $startDate->format('d-m-Y') . ' to ' . $endDate->format('d-m-Y'),
//             'OpeningBalance'      => round($openingBalance, 2),
//             'CollectionFromSales' => round($collectionFromSales, 2),
//             'PaymentToSuppliers'  => $totalPaidToSuppliers,
//             'TotalExpenses'       => round($totalExpenses, 2),
//             'ClosingBalance'      => round($closingBalance, 2),
//             'SupplierPayments'    => $paymentToSuppliers,
//             'Expenses'            => $expensesByType
//         ]);

//     } catch (Exception $e) {
//         return response()->json([
//             'status' => 'fail',
//             'message' => 'Error: ' . $e->getMessage()
//         ], 500);
//     }
// }


    public function AllSummeryReport(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Validate date inputs
            if (!$startDate || !$endDate) {
                return response()->json(['status' => 'fail', 'message' => 'Start and End dates are required']);
            }

            // Ensure that the end date includes the whole day (set time to 23:59:59)
            $endDate = Carbon::parse($endDate)->endOfDay()->toDateTimeString();

            // Query data with aggregation for each date
            $TotalCostAmounts = DB::table('order_details')
                ->select(DB::raw('DATE(created_at) AS date'), DB::raw('SUM(price * quantity) AS total_cost_amount'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            $TotalSalesAmounts = DB::table('order_details')
                ->select(DB::raw('DATE(created_at) AS date'), DB::raw('SUM(selling_price * quantity) AS sub_total_amount'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            $TotalpaidAmounts = DB::table('orders')
                ->select(DB::raw('DATE(created_at) AS date'), DB::raw('SUM(paid_amount) AS total_paid_amount'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            $TotalDiscountAmounts = DB::table('orders')
                ->select(DB::raw('DATE(created_at) AS date'), DB::raw('SUM(discount_amount) AS total_discount_amount'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            $TotalDueAmounts = DB::table('orders')
                ->select(DB::raw('DATE(created_at) AS date'), DB::raw('SUM(due_amount) AS total_due_amount'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            $TotalReturnAmounts = DB::table('product_returns')
                ->select(DB::raw('DATE(created_at) AS date'), DB::raw('SUM(amount) AS total_amount'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            $TotalExpenseAmounts = DB::table('expenses')
                ->select(DB::raw('DATE(created_at) AS date'), DB::raw('SUM(expense_amount) AS total_expense_amount'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();


            // Merging all the sums by date into a single array
            $reportData = [];
            $allDates = [];

            // Collect all distinct dates
            foreach (array_merge(
                $TotalCostAmounts->toArray(),
                $TotalSalesAmounts->toArray(),
                $TotalpaidAmounts->toArray(),
                $TotalDiscountAmounts->toArray(),
                $TotalReturnAmounts->toArray(),
                $TotalDueAmounts->toArray(),
                $TotalExpenseAmounts->toArray(),
                // $TotalInvestAmounts->toArray()
            ) as $item) {
                $allDates[] = $item->date;
            }
            $allDates = array_unique($allDates);

            // Initialize all dates with default values
            foreach ($allDates as $date) {
                $reportData[$date] = [
                    'date' => $date,
                    'total_cost_amount' => 0,
                    'sub_total_amount' => 0,
                    'total_paid_amount' => 0,
                    'total_discount_amount' => 0,
                    'total_due_amount' => 0,
                    'total_expense_amount' => 0,
                    'total_amount' => 0,
                ];
            }

            // Populate data into the reportData array
            foreach ($TotalCostAmounts as $CostAmount) {
                $reportData[$CostAmount->date]['total_cost_amount'] = $CostAmount->total_cost_amount;
            }
            foreach ($TotalSalesAmounts as $SalesAmount) {
                $reportData[$SalesAmount->date]['sub_total_amount'] = $SalesAmount->sub_total_amount;
            }
            foreach ($TotalpaidAmounts as $PaidAmount) {
                $reportData[$PaidAmount->date]['total_paid_amount'] = $PaidAmount->total_paid_amount;
            }
            foreach ($TotalDiscountAmounts as $DiscountAmount) {
                $reportData[$DiscountAmount->date]['total_discount_amount'] = $DiscountAmount->total_discount_amount;
            }
            foreach ($TotalDueAmounts as $DueAmount) {
                $reportData[$DueAmount->date]['total_due_amount'] = $DueAmount->total_due_amount;
            }
            foreach ($TotalExpenseAmounts as $ExpenseAmount) {
                $reportData[$ExpenseAmount->date]['total_expense_amount'] = $ExpenseAmount->total_expense_amount;
            }
            foreach ($TotalReturnAmounts as $ReturnAmounts) {
                $reportData[$ReturnAmounts->date]['total_amount'] = $ReturnAmounts->total_amount;
            }

            $reportData = array_values($reportData);

            return response()->json(['status' => 'success', 'reportData' => $reportData]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }




    public function PersonalInvestorTransactionReport(Request $request)
    {
        try {
            // Get the start and end dates from the request
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // If dates are not provided, return an error
            if (!$startDate || !$endDate) {
                return response()->json(['status' => 'fail', 'message' => 'Start and End dates are required']);
            }

            // Expense Query - Filter by expense type "Personal" and date range
            $expenseQuery = Expense::query()
                ->whereHas('expenseType', function ($query) {
                    $query->where('type_name', 'Personal');
                })
                ->whereBetween('date', [$startDate, $endDate]);

            // Fetch the Expense Data with Expense Type
            $ExpenseData = $expenseQuery->with('expenseType')->get();
            $ExpenseData->map(function ($expense) {
                $expense->type_name = $expense->expenseType->type_name ?? 'N/A';
                return $expense;
            });

            // Invest Query - Filter by date range
            $investQuery = Invest::query()
                ->whereBetween('date', [$startDate, $endDate]);

            // Fetch the Invest Data with Investor Info
            $InvestData = $investQuery->with('investor_infos')->get();
            $InvestData->map(function ($invest) {
                $invest->name = $invest->investor_infos->name ?? 'N/A';
                return $invest;
            });

            // Calculate the subtotals for expenses and investments
            $ExpenceAmount = $ExpenseData->sum('expense_amount');
            $InvestAmount = $InvestData->sum('invest_amount');

            return response()->json([
                'status' => 'success',
                'ExpenseData' => $ExpenseData,
                'InvestData' => $InvestData,
                'ExpenceAmount' => $ExpenceAmount,
                'InvestAmount' => $InvestAmount
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function BestSellingProductsReport(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            if (!$startDate || !$endDate) {
                return response()->json(['status' => 'fail', 'message' => 'Start and End dates are required']);
            }

            $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
            $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();

            // Query to get Best Selling Products
           
            $bestSellingProducts = DB::table('order_details')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->select(
                    // 👇 এখানে products.name এর বদলে products.product_name হবে
                    'products.product_name as product_name', 
                    DB::raw('SUM(CAST(order_details.quantity AS DECIMAL(10,2))) as total_quantity'),
                    DB::raw('SUM(CAST(order_details.price AS DECIMAL(10,2))) as total_cost_amount'),
                    DB::raw('SUM(CAST(order_details.selling_price AS DECIMAL(10,2))) as total_selling_amount')
                )
                ->whereBetween('order_details.created_at', [$startDate, $endDate])
                // 👇 এখানেও products.name এর বদলে products.product_name হবে
                ->groupBy('products.id', 'products.product_name') 
                ->orderBy('total_quantity', 'desc')
                ->get();

            return response()->json([
                'status' => 'success', 
                'BestSellingData' => $bestSellingProducts
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    // Daily Income & Expense Ledger Report List
    public function DailyLedgerReportList(Request $request)
    {
        try {
            $startDateStr = $request->input('start_date', Carbon::today()->toDateString());
            $endDateStr   = $request->input('end_date', Carbon::today()->toDateString());

            $startDate = Carbon::parse($startDateStr)->startOfDay();
            $endDate   = Carbon::parse($endDateStr)->endOfDay();

            // 1. Fetch Sales Cash Collections
            $sales = OrderPaymentDetails::with('order.customer')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get()
                ->map(function($item) {
                    $cName = $item->order && $item->order->customer ? ($item->order->customer->name ?? $item->order->customer->customer_name) : 'Walk-in Customer';
                    return [
                        'timestamp'     => $item->created_at->toDateTimeString(),
                        'date'          => $item->created_at->format('d M Y, h:i A'),
                        'particulars'   => "নগদ বিক্রি - ইনভয়েস " . ($item->order->order_no ?? '#POS'),
                        'party_name'    => $cName,
                        'type'          => 'inflow',
                        'category'      => 'ক্যাশ সেলস (Sales)',
                        'inflow'        => (float) $item->paid_amount,
                        'outflow'       => 0,
                        'ref_no'        => $item->order->order_no ?? 'SALE-'.$item->id,
                    ];
                });

            // 2. Fetch Customer Due Collections
            $customerDues = CustomerPaymentDetails::with('customer')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get()
                ->map(function($item) {
                    $cName = $item->customer ? ($item->customer->name ?? $item->customer->customer_name) : 'Customer';
                    return [
                        'timestamp'     => $item->created_at->toDateTimeString(),
                        'date'          => $item->created_at->format('d M Y, h:i A'),
                        'particulars'   => "কাস্টমার বকেয়া আদায়",
                        'party_name'    => $cName,
                        'type'          => 'inflow',
                        'category'      => 'বকেয়া কালেকশন (Due Collection)',
                        'inflow'        => (float) $item->paid_amount,
                        'outflow'       => 0,
                        'ref_no'        => 'CUST-PAY-'.$item->id,
                    ];
                });

            // 3. Fetch Expenses
            $expenses = Expense::with('expenseType')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get()
                ->map(function($item) {
                    $typeName = $item->expenseType ? $item->expenseType->name : 'General Expense';
                    return [
                        'timestamp'     => $item->created_at->toDateTimeString(),
                        'date'          => $item->created_at->format('d M Y, h:i A'),
                        'particulars'   => "দোকানের খরচ - " . ($item->expense_name ?? $typeName),
                        'party_name'    => $typeName,
                        'type'          => 'outflow',
                        'category'      => 'দোকান খরচ (Expense)',
                        'inflow'        => 0,
                        'outflow'       => (float) $item->expense_amount,
                        'ref_no'        => 'EXP-'.$item->id,
                    ];
                });

            // 4. Fetch Supplier Payments
            $supplierPayments = DB::table('supplier_due_collections')
                ->leftJoin('suppliers', 'supplier_due_collections.supplier_id', '=', 'suppliers.id')
                ->whereBetween('supplier_due_collections.created_at', [$startDate, $endDate])
                ->select('supplier_due_collections.*', 'suppliers.name as supplier_name')
                ->get()
                ->map(function($item) {
                    return [
                        'timestamp'     => $item->created_at,
                        'date'          => Carbon::parse($item->created_at)->format('d M Y, h:i A'),
                        'particulars'   => "সাপ্লায়ার বকেয়া পরিশোধ",
                        'party_name'    => $item->supplier_name ?? 'Supplier',
                        'type'          => 'outflow',
                        'category'      => 'সাপ্লায়ার পরিশোধ (Supplier Due)',
                        'inflow'        => 0,
                        'outflow'       => (float) $item->paid_amount,
                        'ref_no'        => 'SUP-PAY-'.$item->id,
                    ];
                });

            // Combine all transactions and sort chronologically
            $allTransactions = collect([])
                ->concat($sales)
                ->concat($customerDues)
                ->concat($expenses)
                ->concat($supplierPayments)
                ->sortBy('timestamp')
                ->values();

            $runningBalance = 0;
            $totalInflow = 0;
            $totalOutflow = 0;

            $ledgerData = $allTransactions->map(function($tx) use (&$runningBalance, &$totalInflow, &$totalOutflow) {
                $totalInflow += $tx['inflow'];
                $totalOutflow += $tx['outflow'];
                $runningBalance += ($tx['inflow'] - $tx['outflow']);
                $tx['running_balance'] = round($runningBalance, 2);
                return $tx;
            });

            return response()->json([
                'status' => 'success',
                'summary' => [
                    'total_inflow'   => round($totalInflow, 2),
                    'total_outflow'  => round($totalOutflow, 2),
                    'net_balance'    => round($runningBalance, 2),
                    'total_count'    => count($ledgerData),
                    'start_date'     => $startDate->format('d M Y'),
                    'end_date'       => $endDate->format('d M Y'),
                ],
                'ledgerData' => $ledgerData
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

}
