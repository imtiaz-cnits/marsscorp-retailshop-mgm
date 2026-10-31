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
use App\Models\Battery\BatteryProduct;
use App\Models\Battery\BatteryCustomer;
use App\Models\Battery\BatterySupplier;
use App\Models\Battery\BatteryExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BatteryDashboardController extends Controller
{
    public function DashboardAllCalculation(Request $request = null)
    {
        try {
            $filterType = $request ? $request->query('filter_type', 'today') : 'today';
            $customStart = $request ? $request->query('start_date') : null;
            $customEnd = $request ? $request->query('end_date') : null;

            $today = Carbon::today()->toDateString();
            $currentYear = date('Y');
            $currentMonth = date('m');

            if ($filterType === 'last_week') {
                $filterStart = Carbon::today()->subDays(6)->toDateString();
                $filterEnd = $today;
            } elseif ($filterType === 'last_month') {
                $filterStart = Carbon::today()->subDays(29)->toDateString();
                $filterEnd = $today;
            } elseif ($filterType === 'date_wise' && $customStart) {
                $filterStart = Carbon::parse($customStart)->toDateString();
                $filterEnd = $customEnd ? Carbon::parse($customEnd)->toDateString() : $filterStart;
                if ($filterStart > $filterEnd) {
                    $tmp = $filterStart;
                    $filterStart = $filterEnd;
                    $filterEnd = $tmp;
                }
            } else {
                $filterType = 'today';
                $filterStart = $today;
                $filterEnd = $today;
            }

            // --- 1. FILTERED BANNER METRICS ---
            $todaySalesCount = BatteryOrder::where(function($q) use ($filterStart, $filterEnd) {
                $q->whereBetween(DB::raw("COALESCE(invoice_date, DATE(created_at))"), [$filterStart, $filterEnd]);
            })->count();

            $todaySalesAmount = (float) BatteryOrder::where(function($q) use ($filterStart, $filterEnd) {
                $q->whereBetween(DB::raw("COALESCE(invoice_date, DATE(created_at))"), [$filterStart, $filterEnd]);
            })->sum('sub_total');

            $todayDetails = DB::table('battery_order_details')
                ->join('battery_orders', 'battery_order_details.order_id', '=', 'battery_orders.id')
                ->where(function($q) use ($filterStart, $filterEnd) {
                    $q->whereBetween(DB::raw("COALESCE(battery_orders.invoice_date, DATE(battery_orders.created_at))"), [$filterStart, $filterEnd]);
                })
                ->selectRaw('SUM( (battery_order_details.selling_price - battery_order_details.price) * battery_order_details.quantity ) as gross_profit')
                ->first();

            $todayDiscountGiven = (float) BatteryOrder::where(function($q) use ($filterStart, $filterEnd) {
                $q->whereBetween(DB::raw("COALESCE(invoice_date, DATE(created_at))"), [$filterStart, $filterEnd]);
            })->sum('discount_amount');

            $todayGrossProfit = ((float)($todayDetails->gross_profit ?? 0)) - $todayDiscountGiven;

            $todayExpense = (float) BatteryExpense::whereBetween(
                DB::raw("COALESCE(NULLIF(date, ''), DATE(created_at))"),
                [$filterStart, $filterEnd]
            )->sum('expense_amount');

            $todayNetProfit = $todayGrossProfit - $todayExpense;

            $todayCashCollection = (float) BatteryOrderPaymentDetail::where(function($q) use ($filterStart, $filterEnd) {
                $q->whereBetween(DB::raw("COALESCE(NULLIF(due_collection_date, ''), DATE(created_at))"), [$filterStart, $filterEnd]);
            })->sum('paid_amount')
            + (float) BatteryCustomerPaymentDetail::where(function($q) use ($filterStart, $filterEnd) {
                $q->whereBetween(DB::raw("COALESCE(due_collection_date, DATE(created_at))"), [$filterStart, $filterEnd]);
            })->sum('paid_amount');

            $todayPurchaseAmount = (float) BatteryPurchase::where(function($q) use ($filterStart, $filterEnd) {
                $q->whereBetween(DB::raw("COALESCE(date, DATE(created_at))"), [$filterStart, $filterEnd]);
            })->sum('grand_subtotal');

            $filteredReceivableDue = (float) BatteryOrder::where(function($q) use ($filterStart, $filterEnd) {
                $q->whereBetween(DB::raw("COALESCE(invoice_date, DATE(created_at))"), [$filterStart, $filterEnd]);
            })->sum('due_amount');

            $filteredPayableDue = (float) BatteryPurchase::where(function($q) use ($filterStart, $filterEnd) {
                $q->whereBetween(DB::raw("COALESCE(date, DATE(created_at))"), [$filterStart, $filterEnd]);
            })->sum('due_amount');

            $filteredReturn = (float) \App\Models\Battery\BatteryProductReturn::where(function($q) use ($filterStart, $filterEnd) {
                $q->whereBetween(DB::raw("COALESCE(NULLIF(date, ''), DATE(created_at))"), [$filterStart, $filterEnd]);
            })->sum('amount');

            // --- 2. THIS MONTH'S METRICS ---
            $monthlySalesCount = BatteryOrder::where(function($q) use ($currentYear, $currentMonth) {
                $q->where(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('invoice_date', $currentYear)->whereMonth('invoice_date', $currentMonth);
                })->orWhere(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth);
                });
            })->count();

            $monthlySalesAmount = (float) BatteryOrder::where(function($q) use ($currentYear, $currentMonth) {
                $q->where(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('invoice_date', $currentYear)->whereMonth('invoice_date', $currentMonth);
                })->orWhere(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth);
                });
            })->sum('sub_total');

            $monthlyDetails = DB::table('battery_order_details')
                ->join('battery_orders', 'battery_order_details.order_id', '=', 'battery_orders.id')
                ->where(function($q) use ($currentYear, $currentMonth) {
                    $q->where(function($sq) use ($currentYear, $currentMonth) {
                        $sq->whereYear('battery_orders.invoice_date', $currentYear)->whereMonth('battery_orders.invoice_date', $currentMonth);
                    })->orWhere(function($sq) use ($currentYear, $currentMonth) {
                        $sq->whereYear('battery_orders.created_at', $currentYear)->whereMonth('battery_orders.created_at', $currentMonth);
                    });
                })
                ->selectRaw('SUM( (battery_order_details.selling_price - battery_order_details.price) * battery_order_details.quantity ) as gross_profit')
                ->first();

            $monthlyDiscountGiven = (float) BatteryOrder::where(function($q) use ($currentYear, $currentMonth) {
                $q->where(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('invoice_date', $currentYear)->whereMonth('invoice_date', $currentMonth);
                })->orWhere(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth);
                });
            })->sum('discount_amount');

            $monthlyGrossProfit = ((float)($monthlyDetails->gross_profit ?? 0)) - $monthlyDiscountGiven;

            $monthlyExpense = (float) BatteryExpense::whereRaw(
                "YEAR(DATE(COALESCE(NULLIF(date, ''), created_at))) = ? AND MONTH(DATE(COALESCE(NULLIF(date, ''), created_at))) = ?",
                [$currentYear, $currentMonth]
            )->sum('expense_amount');

            $monthlyNetProfit = $monthlyGrossProfit - $monthlyExpense;

            $monthlyCashCollection = (float) BatteryOrderPaymentDetail::where(function($q) use ($currentYear, $currentMonth) {
                $q->where(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('due_collection_date', $currentYear)->whereMonth('due_collection_date', $currentMonth);
                })->orWhere(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth);
                });
            })->sum('paid_amount')
            + (float) BatteryCustomerPaymentDetail::where(function($q) use ($currentYear, $currentMonth) {
                $q->where(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('due_collection_date', $currentYear)->whereMonth('due_collection_date', $currentMonth);
                })->orWhere(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth);
                });
            })->sum('paid_amount');

            $monthlyPurchaseAmount = (float) BatteryPurchase::where(function($q) use ($currentYear, $currentMonth) {
                $q->where(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('date', $currentYear)->whereMonth('date', $currentMonth);
                })->orWhere(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth);
                });
            })->sum('grand_subtotal');

            // --- 3. FINANCIAL SUMMARY & INVENTORY ---
            $totalCustomers = BatteryCustomer::count();
            $totalSuppliers = BatterySupplier::count();
            $totalProducts = BatteryProduct::count();

            $totalCustomerDue = (float) BatteryCustomer::sum('previous_due_amount') + (float) BatteryOrder::sum('due_amount');
            $totalSupplierPayable = (float) BatterySupplier::sum('purchase_payable_amount') + (float) BatteryPurchase::sum('due_amount');
            $totalReturn = (float) \App\Models\Battery\BatteryProductReturn::sum('amount');
            $totalDiscount = (float) BatteryOrder::sum('discount_amount');

            $stockValuation = BatteryProduct::selectRaw('SUM(CAST(cost_price AS DECIMAL(10,2)) * CAST(quantity AS DECIMAL(10,2))) as cost_value, SUM(CAST(sell_price AS DECIMAL(10,2)) * CAST(quantity AS DECIMAL(10,2))) as sell_value, SUM(CASE WHEN CAST(quantity AS DECIMAL(10,2)) <= 10 THEN 1 ELSE 0 END) as low_stock_count')->first();

            $lowStockProducts = BatteryProduct::whereRaw('CAST(quantity AS DECIMAL(10,2)) <= 10')
                ->orderByRaw('CAST(quantity AS DECIMAL(10,2)) asc')
                ->take(10)
                ->get();

            $recentInvoices = BatteryOrder::with('customer')
                ->latest()
                ->take(5)
                ->get();

            $todayPayload = [
                'sales_count'     => $todaySalesCount,
                'sales_amount'    => $todaySalesAmount,
                'gross_profit'    => $todayGrossProfit,
                'expense'         => $todayExpense,
                'net_profit'      => $todayNetProfit,
                'cash_collection' => $todayCashCollection,
                'purchase_amount' => $todayPurchaseAmount,
                'customer_due'    => $filteredReceivableDue,
                'supplier_payable'=> $filteredPayableDue,
                'total_return'    => $filteredReturn,
                'total_discount'  => $todayDiscountGiven,
            ];

            $monthlyPayload = [
                'sales_count'     => $monthlySalesCount,
                'sales_amount'    => $monthlySalesAmount,
                'gross_profit'    => $monthlyGrossProfit,
                'expense'         => $monthlyExpense,
                'net_profit'      => $monthlyNetProfit,
                'cash_collection' => $monthlyCashCollection,
                'purchase_amount' => $monthlyPurchaseAmount,
            ];

            $financialPayload = [
                'customer_due'              => $filteredReceivableDue,
                'supplier_payable'          => $filteredPayableDue,
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
