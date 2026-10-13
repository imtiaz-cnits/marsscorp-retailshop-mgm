<?php

namespace App\Http\Controllers\Battery;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BatteryStockOverviewController extends Controller
{
    /**
     * Display Battery Stock Overview Page
     */
    public function BatteryStockOverviewPage()
    {
        return view('battery.stock-overview.stock-overview-page');
    }

    /**
     * Fetch Live Data & Metrics for Battery Stock Overview
     */
    public function BatteryStockOverviewData(Request $request)
    {
        try {
            // 1. Calculate Global Summary Metrics across all Battery Products
            $valuation = BatteryProduct::selectRaw('
                SUM(CAST(COALESCE(quantity, 0) AS DECIMAL(10,2))) as total_units,
                COUNT(id) as total_skus,
                SUM(CAST(COALESCE(cost_price, 0) AS DECIMAL(10,2)) * CAST(COALESCE(quantity, 0) AS DECIMAL(10,2))) as cost_value,
                SUM(CAST(COALESCE(sell_price, 0) AS DECIMAL(10,2)) * CAST(COALESCE(quantity, 0) AS DECIMAL(10,2))) as sell_value,
                SUM(CASE WHEN CAST(COALESCE(quantity, 0) AS DECIMAL(10,2)) > 0 AND CAST(COALESCE(quantity, 0) AS DECIMAL(10,2)) <= 5 THEN 1 ELSE 0 END) as low_stock_count,
                SUM(CASE WHEN CAST(COALESCE(quantity, 0) AS DECIMAL(10,2)) <= 0 THEN 1 ELSE 0 END) as out_of_stock_count
            ')->first();

            $totalUnits = (float)($valuation->total_units ?? 0);
            $totalSkus  = (int)($valuation->total_skus ?? 0);
            $costValue  = (float)($valuation->cost_value ?? 0);
            $sellValue  = (float)($valuation->sell_value ?? 0);
            $potentialMargin = $sellValue - $costValue;
            $markupPercent   = $costValue > 0 ? round(($potentialMargin / $costValue) * 100, 1) : 0;

            $lowStockCount   = (int)($valuation->low_stock_count ?? 0);
            $outOfStockCount = (int)($valuation->out_of_stock_count ?? 0);

            // 2. Query Battery Products with Eager Loading
            $query = BatteryProduct::with(['category', 'brand', 'unit', 'subCategory']);

            // Tab Filter: all | low | out
            $tab = $request->input('tab', 'all');
            if ($tab === 'low') {
                $query->whereRaw('CAST(COALESCE(quantity, 0) AS DECIMAL(10,2)) > 0 AND CAST(COALESCE(quantity, 0) AS DECIMAL(10,2)) <= 5');
            } elseif ($tab === 'out') {
                $query->whereRaw('CAST(COALESCE(quantity, 0) AS DECIMAL(10,2)) <= 0');
            }

            // Search Filter
            if ($request->filled('search')) {
                $search = trim($request->input('search'));
                $query->where(function ($q) use ($search) {
                    $q->where('product_name', 'LIKE', "%{$search}%")
                      ->orWhere('product_code', 'LIKE', "%{$search}%")
                      ->orWhereJsonContains('product_code', $search)
                      ->orWhere('id', $search)
                      ->orWhereHas('category', function ($cq) use ($search) {
                          $cq->where('name', 'LIKE', "%{$search}%");
                      })
                      ->orWhereHas('brand', function ($bq) use ($search) {
                          $bq->where('name', 'LIKE', "%{$search}%");
                      });
                });
            }

            $products = $query->latest('id')->get();

            // 3. Format Products
            $formattedProducts = $products->map(function ($p) {
                $qty = (float)($p->quantity ?? 0);
                $cost = (float)($p->cost_price ?? 0);
                $sell = (float)($p->sell_price ?? 0);
                $totalCost = $qty * $cost;

                // Determine Stock Status
                if ($qty <= 0) {
                    $status = 'Out of Stock';
                    $statusBadge = 'danger';
                } elseif ($qty <= 5) {
                    $status = 'Low Stock';
                    $statusBadge = 'warning';
                } else {
                    $status = 'Available';
                    $statusBadge = 'success';
                }

                // Handle Battery Barcodes / Serials (cast as array or json)
                $barcodes = [];
                if (!empty($p->product_code)) {
                    if (is_array($p->product_code)) {
                        $barcodes = $p->product_code;
                    } else {
                        $decoded = json_decode($p->product_code, true);
                        $barcodes = is_array($decoded) ? $decoded : [$p->product_code];
                    }
                }
                $barcodeDisplay = !empty($barcodes) ? implode(', ', $barcodes) : 'N/A';
                $primaryBarcode = !empty($barcodes) ? $barcodes[0] : 'N/A';

                return [
                    'id'               => $p->id,
                    'product_name'     => $p->product_name ?? 'Unnamed Battery',
                    'barcode'          => $primaryBarcode,
                    'barcode_display'  => $barcodeDisplay,
                    'category_name'    => $p->category->name ?? $p->category->category_name ?? 'Uncategorized',
                    'brand_name'       => $p->brand->name ?? 'No Brand',
                    'unit_name'        => $p->unit->unit_name ?? $p->unit->name ?? 'Pcs',
                    'quantity'         => $qty,
                    'cost_price'       => $cost,
                    'sell_price'       => $sell,
                    'total_cost_value' => $totalCost,
                    'stock_status'     => $status,
                    'status_badge'     => $statusBadge,
                    'img_url'          => $p->img_url ? asset($p->img_url) : null
                ];
            });

            return response()->json([
                'status'  => 'success',
                'summary' => [
                    'total_units'      => $totalUnits,
                    'total_skus'       => $totalSkus,
                    'cost_value'       => $costValue,
                    'sell_value'       => $sellValue,
                    'potential_margin' => $potentialMargin,
                    'markup_percent'   => $markupPercent,
                    'tab_counts'       => [
                        'all' => $totalSkus,
                        'low' => $lowStockCount,
                        'out' => $outOfStockCount,
                    ]
                ],
                'products' => $formattedProducts
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Safely Adjust Battery Product Stock Quantity
     */
    public function BatteryStockAdjust(Request $request)
    {
        try {
            $request->validate([
                'product_id'   => 'required|integer|exists:battery_products,id',
                'new_quantity' => 'required|numeric|min:0',
                'reason'       => 'nullable|string|max:255'
            ]);

            $product = BatteryProduct::findOrFail($request->product_id);
            $oldQty  = (float)($product->quantity ?? 0);
            $newQty  = (float)$request->new_quantity;
            $reason  = $request->input('reason', 'Physical Inventory Recount');

            $product->quantity = $newQty;
            $product->save();

            // Safe Audit Log in application logger (No schema changes)
            Log::info("Battery Stock Adjustment: Product #{$product->id} ('{$product->product_name}') adjusted from {$oldQty} to {$newQty} by User ID " . (Auth::id() ?? 'System') . ". Reason: {$reason}");

            return response()->json([
                'status'  => 'success',
                'message' => "Stock quantity for \"{$product->product_name}\" has been updated to {$newQty}."
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
