<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Expense;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\OrderDetails;
use App\Models\OrderPaymentDetails;
use App\Models\CustomerPaymentDetails;
use App\Models\PurchasePaymentDetails;
use App\Models\ProductReturn;
use App\Services\DashboardDateFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function DashboardAllCalculation(Request $request = null)
    {
        try {
            // Standardized date filter resolution via DashboardDateFilterService
            [$filterType, $filterStart, $filterEnd, $chartTitle] = DashboardDateFilterService::resolveFilterRange($request);

            $today = Carbon::today()->toDateString();

            // --- 1. FILTERED BANNER METRICS (STRICT BUSINESS DATE ISOLATION) ---
            $salesScope = Order::when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                $query->whereBetween(DB::raw("COALESCE(invoice_date, DATE(created_at))"), [$filterStart, $filterEnd]);
            });

            $todaySalesCount = (int) (clone $salesScope)->count();
            $todaySalesAmount = (float) (clone $salesScope)->sum('sub_total');
            $todayDiscountGiven = (float) (clone $salesScope)->sum('discount_amount');
            $filteredReceivableDue = (float) (clone $salesScope)->sum('due_amount');

            $todayDetails = DB::table('order_details')
                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                ->when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                    $query->whereBetween(DB::raw("COALESCE(orders.invoice_date, DATE(orders.created_at))"), [$filterStart, $filterEnd]);
                })
                ->selectRaw('SUM( (CAST(order_details.selling_price AS DECIMAL(15,2)) - CAST(order_details.price AS DECIMAL(15,2))) * (CAST(order_details.quantity AS DECIMAL(15,2)) - CAST(COALESCE(order_details.return_quantity, 0) AS DECIMAL(15,2))) ) as gross_profit')
                ->first();

            $todayGrossProfit = ((float)($todayDetails->gross_profit ?? 0)) - $todayDiscountGiven;

            $todayExpense = (float) Expense::when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                DashboardDateFilterService::applyDateFilter($query, 'date', $filterStart, $filterEnd);
            })->sum('expense_amount');

            $todayNetProfit = $todayGrossProfit - $todayExpense;

            $todayOrderCollection = (float) OrderPaymentDetails::when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                DashboardDateFilterService::applyDateFilter($query, 'due_collection_date', $filterStart, $filterEnd);
            })->sum('paid_amount');

            $todayCustCollection = (float) CustomerPaymentDetails::when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                DashboardDateFilterService::applyDateFilter($query, 'due_collection_date', $filterStart, $filterEnd);
            })->sum('paid_amount');

            $todayCashCollection = $todayOrderCollection + $todayCustCollection;

            $purchaseScope = Purchase::when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                DashboardDateFilterService::applyDateFilter($query, 'date', $filterStart, $filterEnd);
            });

            $todayPurchaseAmount = (float) (clone $purchaseScope)->sum('grand_subtotal');
            $filteredPayableDue = (float) (clone $purchaseScope)->sum('due_amount');

            // Supplier Payment (Purchase payments + general supplier due collections)
            $purchasePayCol = (float) PurchasePaymentDetails::when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                DashboardDateFilterService::applyDateFilter($query, 'purchase_due_collection_date', $filterStart, $filterEnd);
            })->sum('paid_amount');

            $supplierDueCol = 0.0;
            if (DB::getSchemaBuilder()->hasTable('supplier_due_collections')) {
                $supplierDueCol = (float) DB::table('supplier_due_collections')->when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                    DashboardDateFilterService::applyDateFilter($query, 'due_collection_date', $filterStart, $filterEnd);
                })->sum('paid_amount');
            }

            $todaySupplierPayment = $purchasePayCol + $supplierDueCol;

            $filteredReturn = (float) ProductReturn::when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                DashboardDateFilterService::applyDateFilter($query, 'date', $filterStart, $filterEnd);
            })->sum('amount');

            // --- 2. THIS MONTH'S METRICS (STRICT TRANSACTION DATE ISOLATION) ---
            $monthStart = Carbon::now()->startOfMonth()->toDateString();
            $monthEnd = Carbon::now()->endOfMonth()->toDateString();

            $monthlySalesScope = Order::whereBetween(DB::raw("COALESCE(invoice_date, DATE(created_at))"), [$monthStart, $monthEnd]);
            $monthlySalesCount = (int) (clone $monthlySalesScope)->count();
            $monthlySalesAmount = (float) (clone $monthlySalesScope)->sum('sub_total');
            $monthlyDiscountGiven = (float) (clone $monthlySalesScope)->sum('discount_amount');

            $monthlyDetails = DB::table('order_details')
                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                ->whereBetween(DB::raw("COALESCE(orders.invoice_date, DATE(orders.created_at))"), [$monthStart, $monthEnd])
                ->selectRaw('SUM( (CAST(order_details.selling_price AS DECIMAL(15,2)) - CAST(order_details.price AS DECIMAL(15,2))) * (CAST(order_details.quantity AS DECIMAL(15,2)) - CAST(COALESCE(order_details.return_quantity, 0) AS DECIMAL(15,2))) ) as gross_profit')
                ->first();

            $monthlyGrossProfit = ((float)($monthlyDetails->gross_profit ?? 0)) - $monthlyDiscountGiven;

            $monthlyExpense = (float) Expense::whereBetween(
                DB::raw(DashboardDateFilterService::dateSql('date')),
                [$monthStart, $monthEnd]
            )->sum('expense_amount');

            $monthlyNetProfit = $monthlyGrossProfit - $monthlyExpense;

            $monthlyOrderCol = (float) OrderPaymentDetails::whereBetween(
                DB::raw(DashboardDateFilterService::dateSql('due_collection_date')),
                [$monthStart, $monthEnd]
            )->sum('paid_amount');

            $monthlyCustCol = (float) CustomerPaymentDetails::whereBetween(
                DB::raw(DashboardDateFilterService::dateSql('due_collection_date')),
                [$monthStart, $monthEnd]
            )->sum('paid_amount');

            $monthlyCashCollection = $monthlyOrderCol + $monthlyCustCol;

            $monthlyPurchaseAmount = (float) Purchase::whereBetween(
                DB::raw(DashboardDateFilterService::dateSql('date')),
                [$monthStart, $monthEnd]
            )->sum('grand_subtotal');

            $monthlyPurchasePay = (float) PurchasePaymentDetails::whereBetween(
                DB::raw(DashboardDateFilterService::dateSql('purchase_due_collection_date')),
                [$monthStart, $monthEnd]
            )->sum('paid_amount');

            $monthlySuppDueCol = 0.0;
            if (DB::getSchemaBuilder()->hasTable('supplier_due_collections')) {
                $monthlySuppDueCol = (float) DB::table('supplier_due_collections')->whereBetween(
                    DB::raw(DashboardDateFilterService::dateSql('due_collection_date')),
                    [$monthStart, $monthEnd]
                )->sum('paid_amount');
            }

            $monthlySupplierPayment = $monthlyPurchasePay + $monthlySuppDueCol;

            // --- 3. FINANCIAL SUMMARY & INVENTORY ---
            $totalCustomers = Customer::count();
            $totalSuppliers = Supplier::count();
            $totalProducts = Product::count();

            $totalCustomerDue = (float) Customer::sum('previous_due_amount') + (float) Order::sum('due_amount');
            $totalSupplierPayable = (float) Supplier::sum('purchase_payable_amount') + (float) Purchase::sum('due_amount');
            $totalReturn = (float) ProductReturn::sum('amount');
            $totalDiscount = (float) Order::sum('discount_amount');

            $stockValuation = Product::selectRaw('SUM(CAST(cost_price AS DECIMAL(10,2)) * CAST(quantity AS DECIMAL(10,2))) as cost_value, SUM(CAST(sell_price AS DECIMAL(10,2)) * CAST(quantity AS DECIMAL(10,2))) as sell_value, SUM(CASE WHEN CAST(quantity AS DECIMAL(10,2)) <= 10 THEN 1 ELSE 0 END) as low_stock_count')->first();

            // Low Stock Items (quantity <= 10 units)
            $lowStockProducts = Product::whereRaw('CAST(quantity AS DECIMAL(10,2)) <= 10')
                ->orderByRaw('CAST(quantity AS DECIMAL(10,2)) asc')
                ->take(10)
                ->get();

            // Recent 5 Sales Invoices
            $recentInvoices = Order::with('customer')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function($inv) {
                    $cName = $inv->customer ? ($inv->customer->name ?? $inv->customer->customer_name) : 'Guest Customer';
                    return [
                        'id'             => $inv->id,
                        'order_no'       => $inv->order_no,
                        'customer_name'  => $cName,
                        'date'           => \Carbon\Carbon::parse($inv->invoice_date ?? $inv->created_at)->format('d M Y'),
                        'grand_subtotal' => (float)$inv->sub_total,
                        'sub_total'      => (float)$inv->sub_total,
                        'paid_amount'    => (float)$inv->paid_amount,
                        'due_amount'     => (float)$inv->due_amount,
                    ];
                });

            // --- 4. DYNAMIC DAILY SALES & PROFIT TREND CHART ---
            $chartDates = [];
            $chartSales = [];
            $chartProfits = [];

            $chartStart = $filterStart ?: Carbon::today()->subDays(29)->toDateString();
            $chartEnd = $filterEnd ?: $today;

            if ($filterType === 'today') {
                $chartStart = Carbon::today()->subDays(6)->toDateString();
                $chartEnd = $today;
            }

            $startDateObj = Carbon::parse($chartStart);
            $endDateObj = Carbon::parse($chartEnd);
            if ($startDateObj->diffInDays($endDateObj) > 60) {
                $startDateObj = $endDateObj->copy()->subDays(60);
            }

            for ($d = $startDateObj->copy(); $d->lte($endDateObj); $d->addDay()) {
                $targetDate = $d->toDateString();
                $formattedLabel = $d->format('d M');

                $daySales = (float) Order::where(function($q) use ($targetDate) {
                    $q->whereDate('invoice_date', $targetDate)
                      ->orWhere(function($sq) use ($targetDate) {
                          $sq->whereNull('invoice_date')->whereDate('created_at', $targetDate);
                      });
                })->sum('sub_total');

                $dayDetails = DB::table('order_details')
                    ->join('orders', 'order_details.order_id', '=', 'orders.id')
                    ->where(function($q) use ($targetDate) {
                        $q->whereDate('orders.invoice_date', $targetDate)
                          ->orWhere(function($sq) use ($targetDate) {
                              $sq->whereNull('orders.invoice_date')->whereDate('orders.created_at', $targetDate);
                          });
                    })
                    ->selectRaw('SUM( (CAST(order_details.selling_price AS DECIMAL(15,2)) - CAST(order_details.price AS DECIMAL(15,2))) * (CAST(order_details.quantity AS DECIMAL(15,2)) - CAST(COALESCE(order_details.return_quantity, 0) AS DECIMAL(15,2))) ) as gross_profit')
                    ->first();

                $dayDiscount = (float) Order::where(function($q) use ($targetDate) {
                    $q->whereDate('invoice_date', $targetDate)
                      ->orWhere(function($sq) use ($targetDate) {
                          $sq->whereNull('invoice_date')->whereDate('created_at', $targetDate);
                      });
                })->sum('discount_amount');

                $dayGrossProfit = ((float)($dayDetails->gross_profit ?? 0)) - $dayDiscount;

                $dayExpense = (float) Expense::where(
                    DB::raw(DashboardDateFilterService::dateSql('date')),
                    $targetDate
                )->sum('expense_amount');

                $dayNetProfit = $dayGrossProfit - $dayExpense;

                $chartDates[] = $formattedLabel;
                $chartSales[] = round($daySales, 2);
                $chartProfits[] = round($dayNetProfit, 2);
            }

            $todayPayload = [
                'sales_count'             => $todaySalesCount,
                'sales_amount'            => $todaySalesAmount,
                'gross_profit'            => $todayGrossProfit,
                'expense'                 => $todayExpense,
                'net_profit'              => $todayNetProfit,
                'cash_collection'         => $todayCashCollection,
                'purchase_amount'         => $todayPurchaseAmount,
                'supplier_payment'        => $todaySupplierPayment,
                'customer_due'            => ($filterType === 'all_time' ? $totalCustomerDue : $filteredReceivableDue),
                'period_customer_due'     => $filteredReceivableDue,
                'supplier_payable'        => ($filterType === 'all_time' ? $totalSupplierPayable : $filteredPayableDue),
                'period_supplier_payable' => $filteredPayableDue,
                'total_return'            => $filteredReturn,
                'total_discount'          => $todayDiscountGiven,
                'filter_type'             => $filterType,
                'filter_start'            => $filterStart,
                'filter_end'              => $filterEnd,
            ];

            $monthlyPayload = [
                'sales_count'      => $monthlySalesCount,
                'sales_amount'     => $monthlySalesAmount,
                'gross_profit'     => $monthlyGrossProfit,
                'expense'          => $monthlyExpense,
                'net_profit'       => $monthlyNetProfit,
                'cash_collection'  => $monthlyCashCollection,
                'purchase_amount'  => $monthlyPurchaseAmount,
                'supplier_payment' => $monthlySupplierPayment,
            ];

            $financialPayload = [
                'customer_due'              => $totalCustomerDue,
                'supplier_payable'          => $totalSupplierPayable,
                'period_customer_due'       => $filteredReceivableDue,
                'period_supplier_payable'   => $filteredPayableDue,
                'lifetime_customer_due'     => $totalCustomerDue,
                'lifetime_supplier_payable' => $totalSupplierPayable,
                'total_customers'           => $totalCustomers,
                'total_suppliers'           => $totalSuppliers,
                'total_products'            => $totalProducts,
                'cost_stock_value'          => (float)($stockValuation->cost_value ?? 0),
                'sell_stock_value'          => (float)($stockValuation->sell_value ?? 0),
                'low_stock_count'           => (int)($stockValuation->low_stock_count ?? 0),
                'total_return'              => $filteredReturn,
                'total_discount'            => $todayDiscountGiven,
            ];

            return response()->json([
                'status'    => 'success',
                'today'     => $todayPayload,
                'monthly'   => $monthlyPayload,
                'financial' => $financialPayload,
                'chart'     => [
                    'dates'   => $chartDates,
                    'sales'   => $chartSales,
                    'profits' => $chartProfits,
                    'title'   => $chartTitle,
                ],
                'summary'   => [
                    'today' => $todayPayload,
                    'monthly' => $monthlyPayload,
                    'inventory' => [
                        'total_products'  => $totalProducts,
                        'cost_value'      => (float)($stockValuation->cost_value ?? 0),
                        'sell_value'      => (float)($stockValuation->sell_value ?? 0),
                        'low_stock_count' => (int)($stockValuation->low_stock_count ?? 0),
                    ],
                    'entities' => [
                        'customers'        => $totalCustomers,
                        'suppliers'        => $totalSuppliers,
                        'customer_due'     => $filteredReceivableDue,
                        'supplier_payable' => $filteredPayableDue,
                        'total_return'     => $filteredReturn,
                        'total_discount'   => $todayDiscountGiven,
                    ],
                ],
                'low_stock_products' => $lowStockProducts,
                'recent_invoices'    => $recentInvoices,
                // Fallbacks for legacy bindings:
                'todayGrossProfit'             => $todayGrossProfit,
                'todayNetProfit'               => $todayNetProfit,
                'todayTotalSalesAmount'        => $todaySalesAmount,
                'todayTotalPaidAmount'         => $todayCashCollection,
                'todayTotalPurchaseCostAmount' => $todayPurchaseAmount,
                'todayTotalExpensesAmount'     => $todayExpense,
                'todayTotalBalanceAmount'      => $todayNetProfit,
                'monthlyTotalProfit'           => $monthlyNetProfit,
            ]);

        } catch (\Exception $e) {
            Log::error('Retail Dashboard Error: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function GetLowStockNotifications()
    {
        try {
            $lowStockProducts = Product::whereRaw('CAST(quantity AS DECIMAL(10,2)) <= 10')
                ->orderByRaw('CAST(quantity AS DECIMAL(10,2)) asc')
                ->take(15)
                ->get()
                ->map(function($product) {
                    return [
                        'id'           => $product->id,
                        'product_name' => $product->product_name ?? 'Unknown Product',
                        'product_code' => $product->product_code ?? 'N/A',
                        'quantity'     => (float)($product->quantity ?? 0),
                        'unit_name'    => $product->unit ? $product->unit->name : 'টি',
                    ];
                });

            return response()->json([
                'status' => 'success',
                'count'  => count($lowStockProducts),
                'data'   => $lowStockProducts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
