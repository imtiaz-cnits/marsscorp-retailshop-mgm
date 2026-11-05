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
use App\Models\Invest;
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

            $startDay = Carbon::createFromFormat('Y-m-d', $startDate)->toDateString();
            $endDay   = Carbon::createFromFormat('Y-m-d', $endDate)->toDateString();

            $invoices = BatteryOrder::with(['productReturns', 'details'])
                ->whereBetween(DB::raw("COALESCE(invoice_date, DATE(created_at))"), [$startDay, $endDay])
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
            $startDay  = $startDate->toDateString();
            $endDay    = $endDate->toDateString();

            $openingBalance = $this->getOpeningBalanceForDate($startDate);

            $collectionFromSales = DB::table('battery_order_payment_details')
                ->whereBetween(DB::raw("DATE(COALESCE(NULLIF(battery_order_payment_details.due_collection_date, ''), battery_order_payment_details.created_at))"), [$startDay, $endDay])
                ->sum('paid_amount') ?? 0;

            $collectionFromCustomerDue = DB::table('battery_customer_payment_details')
                ->whereBetween(DB::raw("DATE(COALESCE(battery_customer_payment_details.due_collection_date, battery_customer_payment_details.created_at))"), [$startDay, $endDay])
                ->sum('previous_due_amount') ?? 0;

            $totalCollectionFromSales = $collectionFromSales + $collectionFromCustomerDue;

            $totalPaidToSupplier = DB::table('battery_purchase_payment_details')
                ->whereBetween(DB::raw("DATE(COALESCE(battery_purchase_payment_details.purchase_due_collection_date, battery_purchase_payment_details.created_at))"), [$startDay, $endDay])
                ->sum('paid_amount') ?? 0;

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
                ->whereBetween(DB::raw("DATE(COALESCE(battery_purchase_payment_details.purchase_due_collection_date, battery_purchase_payment_details.created_at))"), [$startDay, $endDay])
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
            ->where(DB::raw("DATE(COALESCE(NULLIF(battery_order_payment_details.due_collection_date, ''), battery_order_payment_details.created_at))"), '>=', $fromDay)
            ->where(DB::raw("DATE(COALESCE(NULLIF(battery_order_payment_details.due_collection_date, ''), battery_order_payment_details.created_at))"), '<', $toDay)
            ->sum('paid_amount') ?? 0;

        $supplierPayment = DB::table('battery_purchase_payment_details')
            ->where(DB::raw("DATE(COALESCE(battery_purchase_payment_details.purchase_due_collection_date, battery_purchase_payment_details.created_at))"), '>=', $fromDay)
            ->where(DB::raw("DATE(COALESCE(battery_purchase_payment_details.purchase_due_collection_date, battery_purchase_payment_details.created_at))"), '<', $toDay)
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

            $startDay = Carbon::parse($startDate)->toDateString();
            $endDay   = Carbon::parse($endDate)->toDateString();

            $dateCol       = "COALESCE(battery_orders.invoice_date, DATE(battery_orders.created_at))";
            $orderDateCol  = "COALESCE(battery_orders.invoice_date, DATE(battery_orders.created_at))";
            $returnDateCol = "DATE(COALESCE(NULLIF(battery_product_returns.date, ''), battery_product_returns.created_at))";

            $TotalCostAmounts = DB::table('battery_order_details')
                ->join('battery_orders', 'battery_order_details.order_id', '=', 'battery_orders.id')
                ->select(DB::raw("{$dateCol} AS date"), DB::raw('SUM(battery_order_details.price * battery_order_details.quantity) AS total_cost_amount'))
                ->whereBetween(DB::raw($dateCol), [$startDay, $endDay])
                ->groupBy(DB::raw($dateCol))
                ->get();

            $TotalSalesAmounts = DB::table('battery_order_details')
                ->join('battery_orders', 'battery_order_details.order_id', '=', 'battery_orders.id')
                ->select(DB::raw("{$dateCol} AS date"), DB::raw('SUM(battery_order_details.selling_price * battery_order_details.quantity) AS sub_total_amount'))
                ->whereBetween(DB::raw($dateCol), [$startDay, $endDay])
                ->groupBy(DB::raw($dateCol))
                ->get();

            $TotalpaidAmounts = DB::table('battery_orders')
                ->select(DB::raw("{$orderDateCol} AS date"), DB::raw('SUM(paid_amount) AS total_paid_amount'))
                ->whereBetween(DB::raw($orderDateCol), [$startDay, $endDay])
                ->groupBy(DB::raw($orderDateCol))
                ->get();

            $TotalDiscountAmounts = DB::table('battery_orders')
                ->select(DB::raw("{$orderDateCol} AS date"), DB::raw('SUM(discount_amount) AS total_discount_amount'))
                ->whereBetween(DB::raw($orderDateCol), [$startDay, $endDay])
                ->groupBy(DB::raw($orderDateCol))
                ->get();

            $TotalDueAmounts = DB::table('battery_orders')
                ->select(DB::raw("{$orderDateCol} AS date"), DB::raw('SUM(due_amount) AS total_due_amount'))
                ->whereBetween(DB::raw($orderDateCol), [$startDay, $endDay])
                ->groupBy(DB::raw($orderDateCol))
                ->get();

            $TotalReturnAmounts = DB::table('battery_product_returns')
                ->select(DB::raw("{$returnDateCol} AS date"), DB::raw('SUM(amount) AS total_amount'))
                ->whereBetween(DB::raw($returnDateCol), [$startDay, $endDay])
                ->groupBy(DB::raw($returnDateCol))
                ->get();

            $TotalExpenseAmounts = DB::table('battery_expenses')
                ->select(
                    DB::raw("DATE(COALESCE(NULLIF(date, ''), created_at)) AS date"),
                    DB::raw('SUM(expense_amount) AS total_expense_amount')
                )
                ->whereBetween(DB::raw("DATE(COALESCE(NULLIF(date, ''), created_at))"), [$startDay, $endDay])
                ->groupBy(DB::raw("DATE(COALESCE(NULLIF(date, ''), created_at))"))
                ->get();

            // Merging all sums by date into reportData for frontend table consumption
            $reportData = [];
            $allDates = [];

            foreach (array_merge(
                $TotalCostAmounts->toArray(),
                $TotalSalesAmounts->toArray(),
                $TotalpaidAmounts->toArray(),
                $TotalDiscountAmounts->toArray(),
                $TotalReturnAmounts->toArray(),
                $TotalDueAmounts->toArray(),
                $TotalExpenseAmounts->toArray()
            ) as $item) {
                $allDates[] = $item->date;
            }
            $allDates = array_unique($allDates);

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

            return response()->json([
                'status'               => 'success',
                'reportData'           => $reportData,
                'TotalCostAmounts'     => $TotalCostAmounts,
                'TotalSalesAmounts'    => $TotalSalesAmounts,
                'TotalpaidAmounts'     => $TotalpaidAmounts,
                'TotalDiscountAmounts' => $TotalDiscountAmounts,
                'TotalDueAmounts'      => $TotalDueAmounts,
                'TotalReturnAmounts'   => $TotalReturnAmounts,
                'TotalExpenseAmounts'  => $TotalExpenseAmounts,
            ])
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
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
            $endDate   = Carbon::parse($endDate)->endOfDay();
            $startDay  = $startDate->toDateString();
            $endDay    = $endDate->toDateString();

            // 1. Fetch Sales (Cash Payments)
            $sales = DB::table('battery_order_payment_details')
                ->join('battery_orders', 'battery_order_payment_details.order_id', '=', 'battery_orders.id')
                ->leftJoin('battery_customers', 'battery_orders.customer_id', '=', 'battery_customers.id')
                ->whereBetween(DB::raw("DATE(COALESCE(NULLIF(battery_order_payment_details.due_collection_date, ''), battery_order_payment_details.created_at))"), [$startDay, $endDay])
                ->where('battery_order_payment_details.paid_amount', '>', 0)
                ->select(
                    'battery_order_payment_details.*',
                    'battery_orders.order_no',
                    'battery_customers.customer_name'
                )
                ->get()
                ->map(function($item) {
                    $txDate = !empty($item->due_collection_date) ? Carbon::parse($item->due_collection_date) : Carbon::parse($item->created_at);
                    if (!empty($item->due_collection_date) && $item->created_at) {
                        $time = Carbon::parse($item->created_at);
                        $txDate = Carbon::parse($item->due_collection_date)->setTime($time->hour, $time->minute, $time->second);
                    }
                    return [
                        'timestamp'     => $txDate->toDateTimeString(),
                        'date'          => $txDate->format('d M Y, h:i A'),
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
                ->whereBetween(DB::raw("DATE(COALESCE(battery_customer_payment_details.due_collection_date, battery_customer_payment_details.created_at))"), [$startDay, $endDay])
                ->where('battery_customer_payment_details.paid_amount', '>', 0)
                ->select(
                    'battery_customer_payment_details.*',
                    'battery_customers.customer_name',
                    'battery_customers.customer_id as cust_code'
                )
                ->get()
                ->map(function($item) {
                    $txDate = !empty($item->due_collection_date) ? Carbon::parse($item->due_collection_date) : Carbon::parse($item->created_at);
                    if (!empty($item->due_collection_date) && $item->created_at) {
                        $time = Carbon::parse($item->created_at);
                        $txDate = Carbon::parse($item->due_collection_date)->setTime($time->hour, $time->minute, $time->second);
                    }
                    return [
                        'timestamp'     => $txDate->toDateTimeString(),
                        'date'          => $txDate->format('d M Y, h:i A'),
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
                ->whereBetween(DB::raw("DATE(COALESCE(NULLIF(battery_expenses.date, ''), battery_expenses.created_at))"), [$startDay, $endDay])
                ->where('battery_expenses.expense_amount', '>', 0)
                ->select('battery_expenses.*', 'battery_expense_types.type_name')
                ->get()
                ->map(function($item) {
                    $typeName = $item->type_name ?? 'General Expense';
                    $txDate = !empty($item->date) ? Carbon::parse($item->date) : Carbon::parse($item->created_at);
                    if (!empty($item->date) && $item->created_at) {
                        $time = Carbon::parse($item->created_at);
                        $txDate = Carbon::parse($item->date)->setTime($time->hour, $time->minute, $time->second);
                    }
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
                ->whereBetween(DB::raw("DATE(COALESCE(battery_supplier_due_collections.payment_date, battery_supplier_due_collections.created_at))"), [$startDay, $endDay])
                ->where('battery_supplier_due_collections.paid_amount', '>', 0)
                ->select('battery_supplier_due_collections.*', 'battery_suppliers.name as supplier_name')
                ->get()
                ->map(function($item) {
                    $txDate = !empty($item->payment_date) ? Carbon::parse($item->payment_date) : Carbon::parse($item->created_at);
                    if (!empty($item->payment_date) && $item->created_at) {
                        $time = Carbon::parse($item->created_at);
                        $txDate = Carbon::parse($item->payment_date)->setTime($time->hour, $time->minute, $time->second);
                    }
                    return [
                        'timestamp'     => $txDate->toDateTimeString(),
                        'date'          => $txDate->format('d M Y, h:i A'),
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

    public function PersonalInvestorTransactionReport(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            if (!$startDate || !$endDate) {
                return response()->json(['status' => 'fail', 'message' => 'Start and End dates are required']);
            }

            $startDay = Carbon::parse($startDate)->toDateString();
            $endDay   = Carbon::parse($endDate)->toDateString();

            // Battery Expenses of type 'Personal'
            $expenseQuery = BatteryExpense::query()
                ->whereHas('expenseType', function ($query) {
                    $query->where('type_name', 'like', '%Personal%');
                })
                ->whereBetween(DB::raw("DATE(COALESCE(NULLIF(battery_expenses.date, ''), battery_expenses.created_at))"), [$startDay, $endDay]);

            $ExpenseData = $expenseQuery->with('expenseType')->get();
            $ExpenseData->map(function ($expense) {
                $expense->type_name = $expense->expenseType->type_name ?? 'Personal';
                return $expense;
            });

            // Invest Data
            $investQuery = Invest::query()
                ->whereBetween('date', [$startDay, $endDay]);

            $InvestData = $investQuery->with('investor_infos')->get();
            $InvestData->map(function ($invest) {
                $invest->name = $invest->investor_infos->name ?? 'N/A';
                return $invest;
            });

            $ExpenceAmount = $ExpenseData->sum('expense_amount');
            $InvestAmount = $InvestData->sum('invest_amount');

            return response()->json([
                'status' => 'success',
                'ExpenseData' => $ExpenseData,
                'InvestData' => $InvestData,
                'ExpenceAmount' => $ExpenceAmount,
                'InvestAmount' => $InvestAmount,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}

