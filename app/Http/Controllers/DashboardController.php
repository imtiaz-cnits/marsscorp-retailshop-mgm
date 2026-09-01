<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Invest;
use App\Models\Expense;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrderPaymentDetails;
use App\Models\PurchaseOrderDetails;
use Illuminate\Support\Facades\Auth;
use App\Models\SupplierDueCollection;
use App\Models\CustomerPaymentDetails;
use App\Models\PurchasePaymentDetails;

class DashboardController extends Controller
{

    public function DashboardAllCalculation()
    {
        try {
            $today = Carbon::today()->toDateString();
            $currentYear = date('Y');
            $currentMonth = date('m');

            // --- 1. TODAY'S METRICS ---
            $todaySalesCount = Order::where(function($q) use ($today) {
                $q->whereDate('invoice_date', $today)->orWhereDate('created_at', $today);
            })->count();

            $todaySalesAmount = (float) Order::where(function($q) use ($today) {
                $q->whereDate('invoice_date', $today)->orWhereDate('created_at', $today);
            })->sum('sub_total');
            
            $todayDetails = DB::table('order_details')
                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                ->where(function($q) use ($today) {
                    $q->whereDate('orders.invoice_date', $today)->orWhereDate('orders.created_at', $today);
                })
                ->selectRaw('SUM( (order_details.selling_price - order_details.price) * order_details.quantity ) as gross_profit')
                ->first();

            $todayDiscountGiven = (float) Order::where(function($q) use ($today) {
                $q->whereDate('invoice_date', $today)->orWhereDate('created_at', $today);
            })->sum('discount_amount');

            $todayGrossProfit = ((float)($todayDetails->gross_profit ?? 0)) - $todayDiscountGiven;

            $todayExpense = (float) Expense::where(function($q) use ($today) {
                $q->whereDate('date', $today)->orWhereDate('created_at', $today);
            })->sum('expense_amount');

            $todayNetProfit = $todayGrossProfit - $todayExpense;

            $todayCashCollection = (float) OrderPaymentDetails::where(function($q) use ($today) {
                $q->whereDate('due_collection_date', $today)->orWhereDate('created_at', $today);
            })->sum('paid_amount') 
            + (float) CustomerPaymentDetails::where(function($q) use ($today) {
                $q->whereDate('due_collection_date', $today)->orWhereDate('created_at', $today);
            })->sum('paid_amount');

            $todayPurchaseAmount = (float) Purchase::where(function($q) use ($today) {
                $q->whereDate('date', $today)->orWhereDate('created_at', $today);
            })->sum('grand_subtotal');

            // --- 2. THIS MONTH'S METRICS ---
            $monthlySalesCount = Order::where(function($q) use ($currentYear, $currentMonth) {
                $q->where(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('invoice_date', $currentYear)->whereMonth('invoice_date', $currentMonth);
                })->orWhere(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth);
                });
            })->count();

            $monthlySalesAmount = (float) Order::where(function($q) use ($currentYear, $currentMonth) {
                $q->where(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('invoice_date', $currentYear)->whereMonth('invoice_date', $currentMonth);
                })->orWhere(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth);
                });
            })->sum('sub_total');
            
            $monthlyDetails = DB::table('order_details')
                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                ->where(function($q) use ($currentYear, $currentMonth) {
                    $q->where(function($sq) use ($currentYear, $currentMonth) {
                        $sq->whereYear('orders.invoice_date', $currentYear)->whereMonth('orders.invoice_date', $currentMonth);
                    })->orWhere(function($sq) use ($currentYear, $currentMonth) {
                        $sq->whereYear('orders.created_at', $currentYear)->whereMonth('orders.created_at', $currentMonth);
                    });
                })
                ->selectRaw('SUM( (order_details.selling_price - order_details.price) * order_details.quantity ) as gross_profit')
                ->first();

            $monthlyDiscountGiven = (float) Order::where(function($q) use ($currentYear, $currentMonth) {
                $q->where(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('invoice_date', $currentYear)->whereMonth('invoice_date', $currentMonth);
                })->orWhere(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth);
                });
            })->sum('discount_amount');

            $monthlyGrossProfit = ((float)($monthlyDetails->gross_profit ?? 0)) - $monthlyDiscountGiven;

            $monthlyExpense = (float) Expense::where(function($q) use ($currentYear, $currentMonth) {
                $q->where(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('date', $currentYear)->whereMonth('date', $currentMonth);
                })->orWhere(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth);
                });
            })->sum('expense_amount');

            $monthlyNetProfit = $monthlyGrossProfit - $monthlyExpense;

            $monthlyCashCollection = (float) OrderPaymentDetails::where(function($q) use ($currentYear, $currentMonth) {
                $q->where(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('due_collection_date', $currentYear)->whereMonth('due_collection_date', $currentMonth);
                })->orWhere(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth);
                });
            })->sum('paid_amount') 
            + (float) CustomerPaymentDetails::where(function($q) use ($currentYear, $currentMonth) {
                $q->where(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('due_collection_date', $currentYear)->whereMonth('due_collection_date', $currentMonth);
                })->orWhere(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth);
                });
            })->sum('paid_amount');

            $monthlyPurchaseAmount = (float) Purchase::where(function($q) use ($currentYear, $currentMonth) {
                $q->where(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('date', $currentYear)->whereMonth('date', $currentMonth);
                })->orWhere(function($sq) use ($currentYear, $currentMonth) {
                    $sq->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth);
                });
            })->sum('grand_subtotal');

            // --- 3. FINANCIAL SUMMARY & INVENTORY ---
            $totalCustomers = Customer::count();
            $totalSuppliers = Supplier::count();
            $totalProducts = \App\Models\Product::count();

            $totalCustomerDue = (float) Customer::sum('previous_due_amount') + (float) Order::sum('due_amount');
            $totalSupplierPayable = (float) Supplier::sum('purchase_payable_amount') + (float) Purchase::sum('due_amount');

            $stockValuation = \App\Models\Product::selectRaw('SUM(CAST(cost_price AS DECIMAL(10,2)) * CAST(quantity AS DECIMAL(10,2))) as cost_value, SUM(CAST(sell_price AS DECIMAL(10,2)) * CAST(quantity AS DECIMAL(10,2))) as sell_value, SUM(CASE WHEN CAST(quantity AS DECIMAL(10,2)) <= 10 THEN 1 ELSE 0 END) as low_stock_count')->first();

            // Low Stock Items (quantity <= 10 units)
            $lowStockProducts = \App\Models\Product::whereRaw('CAST(quantity AS DECIMAL(10,2)) <= 10')
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
                        'paid_amount'    => (float)$inv->paid_amount,
                        'due_amount'     => (float)$inv->due_amount,
                    ];
                });

            // --- 4. DAILY SALES & PROFIT CHART DATA (Last 15 Days) ---
            $chartDates = [];
            $chartSales = [];
            $chartProfits = [];

            for ($i = 14; $i >= 0; $i--) {
                $targetDate = Carbon::today()->subDays($i)->toDateString();
                $formattedLabel = Carbon::today()->subDays($i)->format('d M');

                $daySales = (float) Order::where(function($q) use ($targetDate) {
                    $q->whereDate('invoice_date', $targetDate)->orWhereDate('created_at', $targetDate);
                })->sum('sub_total');

                $dayDetails = DB::table('order_details')
                    ->join('orders', 'order_details.order_id', '=', 'orders.id')
                    ->where(function($q) use ($targetDate) {
                        $q->whereDate('orders.invoice_date', $targetDate)->orWhereDate('orders.created_at', $targetDate);
                    })
                    ->selectRaw('SUM( (order_details.selling_price - order_details.price) * order_details.quantity ) as gross_profit')
                    ->first();

                $dayDiscount = (float) Order::where(function($q) use ($targetDate) {
                    $q->whereDate('invoice_date', $targetDate)->orWhereDate('created_at', $targetDate);
                })->sum('discount_amount');

                $dayGrossProfit = ((float)($dayDetails->gross_profit ?? 0)) - $dayDiscount;

                $dayExpense = (float) Expense::where(function($q) use ($targetDate) {
                    $q->whereDate('date', $targetDate)->orWhereDate('created_at', $targetDate);
                })->sum('expense_amount');

                $dayNetProfit = $dayGrossProfit - $dayExpense;

                $chartDates[] = $formattedLabel;
                $chartSales[] = round($daySales, 2);
                $chartProfits[] = round($dayNetProfit, 2);
            }

            return response()->json([
                'status' => 'success',
                'today' => [
                    'sales_count'     => $todaySalesCount,
                    'sales_amount'    => $todaySalesAmount,
                    'gross_profit'    => $todayGrossProfit,
                    'expense'         => $todayExpense,
                    'net_profit'      => $todayNetProfit,
                    'cash_collection' => $todayCashCollection,
                    'purchase_amount' => $todayPurchaseAmount,
                ],
                'monthly' => [
                    'sales_count'     => $monthlySalesCount,
                    'sales_amount'    => $monthlySalesAmount,
                    'gross_profit'    => $monthlyGrossProfit,
                    'expense'         => $monthlyExpense,
                    'net_profit'      => $monthlyNetProfit,
                    'cash_collection' => $monthlyCashCollection,
                    'purchase_amount' => $monthlyPurchaseAmount,
                ],
                'financial' => [
                    'customer_due'     => $totalCustomerDue,
                    'supplier_payable' => $totalSupplierPayable,
                    'total_customers'  => $totalCustomers,
                    'total_suppliers'  => $totalSuppliers,
                    'total_products'   => $totalProducts,
                    'cost_stock_value' => (float)($stockValuation->cost_value ?? 0),
                    'sell_stock_value' => (float)($stockValuation->sell_value ?? 0),
                    'low_stock_count'  => (int)($stockValuation->low_stock_count ?? 0),
                ],
                'chart' => [
                    'dates'   => $chartDates,
                    'sales'   => $chartSales,
                    'profits' => $chartProfits,
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
            \Log::error('Dashboard Error: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function GetLowStockNotifications()
    {
        try {
            $lowStockProducts = \App\Models\Product::whereRaw('CAST(quantity AS DECIMAL(10,2)) <= 10')
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
