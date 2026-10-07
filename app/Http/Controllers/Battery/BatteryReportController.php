<?php

namespace App\Http\Controllers\Battery;

use Exception;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryOrder;
use App\Models\Battery\BatteryOrderDetail;
use App\Models\Battery\BatteryOrderPaymentDetail;
use App\Models\Battery\BatteryCustomerPaymentDetail;
use App\Models\Battery\BatteryPurchase;
use App\Models\Battery\BatteryPurchasePaymentDetail;
use App\Models\Battery\BatterySupplierDueCollection;
use App\Models\Battery\BatteryExpense;
use App\Models\Battery\BatteryExpenseType;
use App\Models\Battery\BatteryOpeningBalance;
use App\Models\Battery\BatteryProductReturn;
use App\Models\Battery\BatterySupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BatteryReportController extends Controller
{
    public function SalesReportList(Request $request)
    {
        try {
            $user_id = Auth::id();
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            if (!$startDate || !$endDate) {
                return response()->json(['status' => 'fail', 'message' => 'Start and End dates are required']);
            }

            $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();

            $invoices = BatteryOrder::with(['productReturns', 'details'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get()
                ->map(function ($order) {
                    $returnAmount = $order->productReturns->sum('amount');
                    $orderDetailsAmount = $order->details->sum('price');
                    $orderDetailsSellingAmount = $order->details->sum('selling_price');
                    return [
                        'order_no'      => $order->order_no,
                        'paid_amount'   => $order->paid_amount,
                        'due_amount'    => $order->due_amount,
                        'return_amount' => $returnAmount,
                        'total_cost'    => $orderDetailsAmount,
                        'selling_price' => $orderDetailsSellingAmount,
                    ];
                });

            return response()->json(['status' => 'success', 'SalesReportData' => $invoices]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

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

            $openingBalance = $this->getOpeningBalanceForDate($startDate);

            $collectionFromSales = DB::table('battery_order_payment_details')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('paid_amount') ?? 0;

            $collectionFromCustomerDue = DB::table('battery_customer_payment_details')
                ->whereBetween('due_collection_date', [$startDate, $endDate])
                ->sum('previous_due_amount') ?? 0;

            $totalCollectionFromSales = $collectionFromSales + $collectionFromCustomerDue;

            $totalPaidToSupplier = DB::table('battery_purchase_payment_details')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('paid_amount') ?? 0;

            $startDay = $startDate->toDateString();
            $endDay   = $endDate->toDateString();

            $totalExpense = DB::table('battery_expenses')
                ->whereBetween(DB::raw("DATE(COALESCE(NULLIF(battery_expenses.date, ''), battery_expenses.created_at))"), [$startDay, $endDay])
                ->sum('expense_amount') ?? 0;

            $closingBalance = $openingBalance
                            + $totalCollectionFromSales
                            - $totalPaidToSupplier
                            - $totalExpense;

            $supplierPayments = DB::table('battery_purchase_payment_details')
                ->join('battery_purchases', 'battery_purchase_payment_details.purchases_id', '=', 'battery_purchases.id')
                ->join('battery_suppliers', 'battery_purchases.supplier_id', '=', 'battery_suppliers.id')
                ->whereBetween('battery_purchase_payment_details.created_at', [$startDate, $endDate])
                ->selectRaw('battery_suppliers.name as supplier_name, SUM(battery_purchase_payment_details.paid_amount) as total_paid')
                ->groupBy('battery_suppliers.id', 'battery_suppliers.name')
                ->get();

            $expensesByType = DB::table('battery_expenses')
                ->join('battery_expense_types', 'battery_expenses.expense_type_id', '=', 'battery_expense_types.id')
                ->whereBetween(DB::raw("DATE(COALESCE(NULLIF(battery_expenses.date, ''), battery_expenses.created_at))"), [$startDay, $endDay])
                ->selectRaw('battery_expense_types.type_name, SUM(battery_expenses.expense_amount) as total_expense')
                ->groupBy('battery_expense_types.id', 'battery_expense_types.type_name')
                ->get();

            return response()->json([
                'status'               => 'success',
                'OpeningBalance'       => round($openingBalance, 2),
                'CollectionFromSales'  => round($totalCollectionFromSales, 2),
                'TotalPaidToSupplier'  => round($totalPaidToSupplier, 2),
                'TotalExpense'         => round($totalExpense, 2),
                'ClosingBalance'       => round($closingBalance, 2),
                'TotalBalanceAmount'   => round($closingBalance, 2),
                'SupplierPayments'     => $supplierPayments,
                'Expenses'             => $expensesByType,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    private function getOpeningBalanceForDate($targetDate)
    {
        $lastManual = DB::table('battery_opening_balances')
            ->where('date', '<=', $targetDate)
            ->orderBy('date', 'desc')
            ->first();

        if (!$lastManual) {
            return 0.00;
        }

        $manualDate = Carbon::parse($lastManual->date)->startOfDay();
        $manualAmount = floatval($lastManual->amount);

        if ($manualDate->isSameDay($targetDate)) {
            return $manualAmount;
        }

        $netFlow = $this->calculateNetFlowFrom($manualDate->copy()->addDay(), $targetDate);

        return $manualAmount + $netFlow;
    }

    private function calculateNetFlowFrom($fromDate, $toDate)
    {
        $fromDay = Carbon::parse($fromDate)->toDateString();
        $toDay   = Carbon::parse($toDate)->toDateString();

        $income = DB::table('battery_order_payment_details')
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<', $toDate)
            ->sum('paid_amount') ?? 0;

        $supplierPayment = DB::table('battery_purchase_payment_details')
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<', $toDate)
            ->sum('paid_amount') ?? 0;

        $expense = DB::table('battery_expenses')
            ->where(DB::raw("DATE(COALESCE(NULLIF(battery_expenses.date, ''), battery_expenses.created_at))"), '>=', $fromDay)
            ->where(DB::raw("DATE(COALESCE(NULLIF(battery_expenses.date, ''), battery_expenses.created_at))"), '<', $toDay)
            ->sum('expense_amount') ?? 0;

        return $income - $supplierPayment - $expense;
    }

    public function AllSummeryReport(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            if (!$startDate || !$endDate) {
                return response()->json(['status' => 'fail', 'message' => 'Start and End dates are required']);
            }

            $endDate = Carbon::parse($endDate)->endOfDay()->toDateTimeString();

            $TotalCostAmounts = DB::table('battery_order_details')
                ->select(DB::raw('DATE(created_at) AS date'), DB::raw('SUM(price * quantity) AS total_cost_amount'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            $TotalSalesAmounts = DB::table('battery_order_details')
                ->select(DB::raw('DATE(created_at) AS date'), DB::raw('SUM(selling_price * quantity) AS sub_total_amount'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            $TotalpaidAmounts = DB::table('battery_orders')
                ->select(DB::raw('DATE(created_at) AS date'), DB::raw('SUM(paid_amount) AS total_paid_amount'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            $TotalDiscountAmounts = DB::table('battery_orders')
                ->select(DB::raw('DATE(created_at) AS date'), DB::raw('SUM(discount_amount) AS total_discount_amount'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            $TotalDueAmounts = DB::table('battery_orders')
                ->select(DB::raw('DATE(created_at) AS date'), DB::raw('SUM(due_amount) AS total_due_amount'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            $TotalReturnAmounts = DB::table('battery_product_returns')
                ->select(DB::raw('DATE(created_at) AS date'), DB::raw('SUM(amount) AS total_amount'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            $startDay = Carbon::parse($startDate)->toDateString();
            $endDay   = Carbon::parse($endDate)->toDateString();

            $TotalExpenseAmounts = DB::table('battery_expenses')
                ->select(
                    DB::raw("DATE(COALESCE(NULLIF(date, ''), created_at)) AS date"),
                    DB::raw('SUM(expense_amount) AS total_expense_amount')
                )
                ->whereBetween(DB::raw("DATE(COALESCE(NULLIF(date, ''), created_at))"), [$startDay, $endDay])
                ->groupBy(DB::raw("DATE(COALESCE(NULLIF(date, ''), created_at))"))
                ->get();

            return response()->json([
                'TotalCostAmounts'     => $TotalCostAmounts,
                'TotalSalesAmounts'    => $TotalSalesAmounts,
                'TotalpaidAmounts'     => $TotalpaidAmounts,
                'TotalDiscountAmounts' => $TotalDiscountAmounts,
                'TotalDueAmounts'      => $TotalDueAmounts,
                'TotalReturnAmounts'   => $TotalReturnAmounts,
                'TotalExpenseAmounts'  => $TotalExpenseAmounts,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to fetch total values: ' . $e->getMessage()], 500);
        }
    }

    public function DailyLedgerReportList(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            if (!$startDate || !$endDate) {
                return response()->json(['status' => 'fail', 'message' => 'Start date and End date are required']);
            }

            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();

            // 1. Fetch Sales (Cash Payments)
            $sales = DB::table('battery_order_payment_details')
                ->join('battery_orders', 'battery_order_payment_details.order_id', '=', 'battery_orders.id')
                ->leftJoin('battery_customers', 'battery_orders.customer_id', '=', 'battery_customers.id')
                ->whereBetween('battery_order_payment_details.created_at', [$startDate, $endDate])
                ->where('battery_order_payment_details.paid_amount', '>', 0)
                ->select(
                    'battery_order_payment_details.*',
                    'battery_orders.order_no',
                    'battery_customers.customer_name'
                )
                ->get()
                ->map(function($item) {
                    return [
                        'timestamp'     => $item->created_at,
                        'date'          => Carbon::parse($item->created_at)->format('d M Y, h:i A'),
                        'particulars'   => "ব্যাটারি বিক্রয় - ইনভয়েস #".$item->order_no,
                        'party_name'    => $item->customer_name ?? 'Guest Customer',
                        'type'          => 'inflow',
                        'category'      => 'বিক্রয় কালেকশন (Sales)',
                        'inflow'        => (float) $item->paid_amount,
                        'outflow'       => 0,
                        'ref_no'        => $item->order_no,
                    ];
                });

            // 2. Fetch Customer Due Collections
            $customerDues = DB::table('battery_customer_payment_details')
                ->leftJoin('battery_customers', 'battery_customer_payment_details.customer_id', '=', 'battery_customers.id')
                ->whereBetween('battery_customer_payment_details.created_at', [$startDate, $endDate])
                ->where('battery_customer_payment_details.paid_amount', '>', 0)
                ->select(
                    'battery_customer_payment_details.*',
                    'battery_customers.customer_name',
                    'battery_customers.customer_id as cust_code'
                )
                ->get()
                ->map(function($item) {
                    return [
                        'timestamp'     => $item->created_at,
                        'date'          => Carbon::parse($item->created_at)->format('d M Y, h:i A'),
                        'particulars'   => "কাস্টমার বকেয়া কালেকশন",
                        'party_name'    => $item->customer_name ?? 'Customer',
                        'type'          => 'inflow',
                        'category'      => 'বকেয়া কালেকশন (Due Collection)',
                        'inflow'        => (float) $item->paid_amount,
                        'outflow'       => 0,
                        'ref_no'        => 'DUE-PAY-'.$item->id,
                    ];
                });

            // 3. Fetch Expenses
            $expenses = DB::table('battery_expenses')
                ->leftJoin('battery_expense_types', 'battery_expenses.expense_type_id', '=', 'battery_expense_types.id')
                ->whereBetween('battery_expenses.created_at', [$startDate, $endDate])
                ->where('battery_expenses.expense_amount', '>', 0)
                ->select('battery_expenses.*', 'battery_expense_types.type_name')
                ->get()
                ->map(function($item) {
                    $typeName = $item->type_name ?? 'General Expense';
                    $txDate = Carbon::parse($item->created_at);
                    return [
                        'timestamp'     => $txDate->toDateTimeString(),
                        'date'          => $txDate->format('d M Y, h:i A'),
                        'particulars'   => "ব্যাটারি খরচ - " . ($item->expense_details ?: $typeName),
                        'party_name'    => $typeName,
                        'type'          => 'outflow',
                        'category'      => 'দোকান খরচ (Expense)',
                        'inflow'        => 0,
                        'outflow'       => (float) $item->expense_amount,
                        'ref_no'        => 'BAT-EXP-'.$item->id,
                    ];
                });

            // 4. Fetch Supplier Payments
            $supplierPayments = DB::table('battery_supplier_due_collections')
                ->leftJoin('battery_suppliers', 'battery_supplier_due_collections.supplier_id', '=', 'battery_suppliers.id')
                ->whereBetween('battery_supplier_due_collections.created_at', [$startDate, $endDate])
                ->where('battery_supplier_due_collections.paid_amount', '>', 0)
                ->select('battery_supplier_due_collections.*', 'battery_suppliers.name as supplier_name')
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
                        'ref_no'        => 'BAT-SUP-PAY-'.$item->id,
                    ];
                });

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
