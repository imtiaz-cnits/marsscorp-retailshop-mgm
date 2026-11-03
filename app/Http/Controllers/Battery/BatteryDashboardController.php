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
use App\Models\Battery\BatteryProduct;
use App\Models\Battery\BatteryCustomer;
use App\Models\Battery\BatterySupplier;
use App\Models\Battery\BatteryExpense;
use App\Models\Battery\BatteryProductReturn;
use App\Services\DashboardDateFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BatteryDashboardController extends Controller
{
    public function DashboardAllCalculation(Request $request = null)
    {
        try {
            // Standardized date filter resolution via DashboardDateFilterService
            [$filterType, $filterStart, $filterEnd, $chartTitle] = DashboardDateFilterService::resolveFilterRange($request);

            $today = Carbon::today()->toDateString();

            // --- 1. FILTERED BANNER METRICS (STRICT BUSINESS DATE ISOLATION) ---
            $salesScope = BatteryOrder::when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                $query->whereBetween(DB::raw("COALESCE(invoice_date, DATE(created_at))"), [$filterStart, $filterEnd]);
            });

            $todaySalesCount = (int) (clone $salesScope)->count();
            $todaySalesAmount = (float) (clone $salesScope)->sum('sub_total');
            $todayDiscountGiven = (float) (clone $salesScope)->sum('discount_amount');
            $filteredReceivableDue = (float) (clone $salesScope)->sum('due_amount');

            $todayDetails = DB::table('battery_order_details')
                ->join('battery_orders', 'battery_order_details.order_id', '=', 'battery_orders.id')
                ->when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                    $query->whereBetween(DB::raw("COALESCE(battery_orders.invoice_date, DATE(battery_orders.created_at))"), [$filterStart, $filterEnd]);
                })
                ->selectRaw('SUM( (CAST(battery_order_details.selling_price AS DECIMAL(15,2)) - CAST(battery_order_details.price AS DECIMAL(15,2))) * (CAST(battery_order_details.quantity AS DECIMAL(15,2)) - CAST(COALESCE(battery_order_details.return_quantity, 0) AS DECIMAL(15,2))) ) as gross_profit')
                ->first();

            $todayGrossProfit = ((float)($todayDetails->gross_profit ?? 0)) - $todayDiscountGiven;

            $todayExpense = (float) BatteryExpense::when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                DashboardDateFilterService::applyDateFilter($query, 'date', $filterStart, $filterEnd);
            })->sum('expense_amount');

            $todayNetProfit = $todayGrossProfit - $todayExpense;

            $todayOrderCollection = (float) BatteryOrderPaymentDetail::when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                DashboardDateFilterService::applyDateFilter($query, 'due_collection_date', $filterStart, $filterEnd);
            })->sum('paid_amount');

            $todayCustCollection = (float) BatteryCustomerPaymentDetail::when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                DashboardDateFilterService::applyDateFilter($query, 'due_collection_date', $filterStart, $filterEnd);
            })->sum('paid_amount');

            $todayCashCollection = $todayOrderCollection + $todayCustCollection;

            $purchaseScope = BatteryPurchase::when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                DashboardDateFilterService::applyDateFilter($query, 'date', $filterStart, $filterEnd);
            });

            $todayPurchaseAmount = (float) (clone $purchaseScope)->sum('grand_subtotal');
            $filteredPayableDue = (float) (clone $purchaseScope)->sum('due_amount');

            // Supplier Payment (Purchase payments + general supplier due collections)
            $purchasePayCol = (float) BatteryPurchasePaymentDetail::when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                DashboardDateFilterService::applyDateFilter($query, 'purchase_due_collection_date', $filterStart, $filterEnd);
            })->sum('paid_amount');

            $supplierDueCol = 0.0;
            if (DB::getSchemaBuilder()->hasTable('battery_supplier_due_collections')) {
                $supplierDueCol = (float) DB::table('battery_supplier_due_collections')->when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                    DashboardDateFilterService::applyDateFilter($query, 'payment_date', $filterStart, $filterEnd);
                })->sum('paid_amount');
            }

            $todaySupplierPayment = $purchasePayCol + $supplierDueCol;

            $filteredReturn = (float) BatteryProductReturn::when($filterStart && $filterEnd, function($query) use ($filterStart, $filterEnd) {
                DashboardDateFilterService::applyDateFilter($query, 'date', $filterStart, $filterEnd);
            })->sum('amount');

            // --- 2. THIS MONTH'S METRICS (STRICT TRANSACTION DATE ISOLATION) ---
            $monthStart = Carbon::now()->startOfMonth()->toDateString();
            $monthEnd = Carbon::now()->endOfMonth()->toDateString();

            $monthlySalesScope = BatteryOrder::whereBetween(DB::raw("COALESCE(invoice_date, DATE(created_at))"), [$monthStart, $monthEnd]);
            $monthlySalesCount = (int) (clone $monthlySalesScope)->count();
            $monthlySalesAmount = (float) (clone $monthlySalesScope)->sum('sub_total');
            $monthlyDiscountGiven = (float) (clone $monthlySalesScope)->sum('discount_amount');

            $monthlyDetails = DB::table('battery_order_details')
                ->join('battery_orders', 'battery_order_details.order_id', '=', 'battery_orders.id')
                ->whereBetween(DB::raw("COALESCE(battery_orders.invoice_date, DATE(battery_orders.created_at))"), [$monthStart, $monthEnd])
                ->selectRaw('SUM( (CAST(battery_order_details.selling_price AS DECIMAL(15,2)) - CAST(battery_order_details.price AS DECIMAL(15,2))) * (CAST(battery_order_details.quantity AS DECIMAL(15,2)) - CAST(COALESCE(battery_order_details.return_quantity, 0) AS DECIMAL(15,2))) ) as gross_profit')
                ->first();

            $monthlyGrossProfit = ((float)($monthlyDetails->gross_profit ?? 0)) - $monthlyDiscountGiven;

            $monthlyExpense = (float) BatteryExpense::whereBetween(
                DB::raw(DashboardDateFilterService::dateSql('date')),
                [$monthStart, $monthEnd]
            )->sum('expense_amount');

            $monthlyNetProfit = $monthlyGrossProfit - $monthlyExpense;

            $monthlyOrderCol = (float) BatteryOrderPaymentDetail::whereBetween(
                DB::raw(DashboardDateFilterService::dateSql('due_collection_date')),
                [$monthStart, $monthEnd]
            )->sum('paid_amount');

            $monthlyCustCol = (float) BatteryCustomerPaymentDetail::whereBetween(
                DB::raw(DashboardDateFilterService::dateSql('due_collection_date')),
                [$monthStart, $monthEnd]
            )->sum('paid_amount');

            $monthlyCashCollection = $monthlyOrderCol + $monthlyCustCol;

            $monthlyPurchaseAmount = (float) BatteryPurchase::whereBetween(
                DB::raw(DashboardDateFilterService::dateSql('date')),
                [$monthStart, $monthEnd]
            )->sum('grand_subtotal');

            $monthlyPurchasePay = (float) BatteryPurchasePaymentDetail::whereBetween(
                DB::raw(DashboardDateFilterService::dateSql('purchase_due_collection_date')),
                [$monthStart, $monthEnd]
            )->sum('paid_amount');

            $monthlySuppDueCol = 0.0;
            if (DB::getSchemaBuilder()->hasTable('battery_supplier_due_collections')) {
                $monthlySuppDueCol = (float) DB::table('battery_supplier_due_collections')->whereBetween(
                    DB::raw(DashboardDateFilterService::dateSql('payment_date')),
                    [$monthStart, $monthEnd]
                )->sum('paid_amount');
            }

            $monthlySupplierPayment = $monthlyPurchasePay + $monthlySuppDueCol;

            // --- 3. FINANCIAL SUMMARY & INVENTORY ---
            $totalCustomers = BatteryCustomer::count();
            $totalSuppliers = BatterySupplier::count();
            $totalProducts = BatteryProduct::count();

            $totalCustomerDue = (float) BatteryCustomer::sum('previous_due_amount') + (float) BatteryOrder::sum('due_amount');
            $totalSupplierPayable = (float) BatterySupplier::sum('purchase_payable_amount') + (float) BatteryPurchase::sum('due_amount');
            $totalReturn = (float) BatteryProductReturn::sum('amount');
            $totalDiscount = (float) BatteryOrder::sum('discount_amount');

            $stockValuation = BatteryProduct::selectRaw('SUM(CAST(cost_price AS DECIMAL(10,2)) * CAST(quantity AS DECIMAL(10,2))) as cost_value, SUM(CAST(sell_price AS DECIMAL(10,2)) * CAST(quantity AS DECIMAL(10,2))) as sell_value, SUM(CASE WHEN CAST(quantity AS DECIMAL(10,2)) <= 10 THEN 1 ELSE 0 END) as low_stock_count')->first();

            $lowStockProducts = BatteryProduct::whereRaw('CAST(quantity AS DECIMAL(10,2)) <= 10')
                ->orderByRaw('CAST(quantity AS DECIMAL(10,2)) asc')
                ->take(10)
                ->get()
                ->map(function($product) {
                    $code = '';
                    if (!empty($product->product_code)) {
                        $parsed = is_array($product->product_code) ? $product->product_code : json_decode($product->product_code, true);
                        $code = is_array($parsed) ? ($parsed[0] ?? '') : $parsed;
                    }
                    return [
                        'id'           => $product->id,
                        'name'         => $product->product_name ?? 'Unknown Battery',
                        'product_name' => $product->product_name ?? 'Unknown Battery',
                        'battery_code' => $code ?: ('BAT-' . $product->id),
                        'quantity'     => (float)($product->quantity ?? 0),
                        'unit'         => $product->unit ? $product->unit->name : 'টি',
                    ];
                });

            $recentInvoices = BatteryOrder::with('customer')
                ->latest()
                ->take(5)
                ->get()
                ->map(function($inv) {
                    $cName = $inv->customer ? ($inv->customer->customer_name ?? $inv->customer->name) : 'Walk-in';
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

                $daySales = (float) BatteryOrder::where(function($q) use ($targetDate) {
                    $q->whereDate('invoice_date', $targetDate)
                      ->orWhere(function($sq) use ($targetDate) {
                          $sq->whereNull('invoice_date')->whereDate('created_at', $targetDate);
                      });
                })->sum('sub_total');

                $dayDetails = DB::table('battery_order_details')
                    ->join('battery_orders', 'battery_order_details.order_id', '=', 'battery_orders.id')
                    ->where(function($q) use ($targetDate) {
                        $q->whereDate('battery_orders.invoice_date', $targetDate)
                          ->orWhere(function($sq) use ($targetDate) {
                              $sq->whereNull('battery_orders.invoice_date')->whereDate('battery_orders.created_at', $targetDate);
                          });
                    })
                    ->selectRaw('SUM( (CAST(battery_order_details.selling_price AS DECIMAL(15,2)) - CAST(battery_order_details.price AS DECIMAL(15,2))) * (CAST(battery_order_details.quantity AS DECIMAL(15,2)) - CAST(COALESCE(battery_order_details.return_quantity, 0) AS DECIMAL(15,2))) ) as gross_profit')
                    ->first();

                $dayDiscount = (float) BatteryOrder::where(function($q) use ($targetDate) {
                    $q->whereDate('invoice_date', $targetDate)
                      ->orWhere(function($sq) use ($targetDate) {
                          $sq->whereNull('invoice_date')->whereDate('created_at', $targetDate);
                      });
                })->sum('discount_amount');

                $dayGrossProfit = ((float)($dayDetails->gross_profit ?? 0)) - $dayDiscount;

                $dayExpense = (float) BatteryExpense::where(
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
                    'financial' => $financialPayload
                ],
                'low_stock_products' => $lowStockProducts,
                'recent_invoices'    => $recentInvoices,
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
            Log::error('Battery Dashboard Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function GetLowStockNotifications()
    {
        try {
            $lowStockProducts = BatteryProduct::whereRaw('CAST(quantity AS DECIMAL(10,2)) <= 10')
                ->orderByRaw('CAST(quantity AS DECIMAL(10,2)) asc')
                ->take(15)
                ->get()
                ->map(function($product) {
                    return [
                        'id'           => $product->id,
                        'product_name' => $product->product_name ?? 'Unknown Battery',
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
