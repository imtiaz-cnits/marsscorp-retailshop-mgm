<?php

namespace App\Http\Controllers\Battery;

use Exception;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BatteryProductController extends Controller
{
    public function ProductIDSearch(Request $request)
    {
        $productID = $request->input('product_id');

        $product = BatteryProduct::whereJsonContains('product_code', $productID)->first();

        if ($product) {
            return response()->json([
                'status' => 'success',
                'product' => $product
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }
    }

    public function ProductSearchByName(Request $request)
    {
        try {
            $query = trim($request->input('query', ''));
            if ($query === '') {
                return response()->json(['status' => 'success', 'data' => []]);
            }

            $products = BatteryProduct::where('product_name', 'LIKE', "%{$query}%")
                ->orWhere('product_code', 'LIKE', "%{$query}%")
                ->orWhereJsonContains('product_code', $query)
                ->orWhere('id', $query)
                ->limit(25)
                ->get();

            $formatted = $products->map(function ($p) {
                $codes = [];
                if ($p->product_code) {
                    if (is_array($p->product_code)) {
                        $codes = $p->product_code;
                    } else {
                        $decoded = json_decode($p->product_code, true);
                        $codes = is_array($decoded) ? $decoded : [$p->product_code];
                    }
                }
                $primaryCode = !empty($codes) ? $codes[0] : '';
                $displayCodes = implode(', ', $codes);

                $displayName = $p->product_name;

                return [
                    'id' => $p->id,
                    'name' => $displayName,
                    'product_name' => $p->product_name,
                    'product_code' => $primaryCode,
                    'display_codes' => $displayCodes,
                    'all_codes' => $codes,
                    'cost_price' => floatval($p->cost_price ?? 0),
                    'sell_price' => floatval($p->sell_price ?? 0),
                    'quantity' => floatval($p->quantity ?? 0),
                    'img_url' => $p->img_url,
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $formatted
            ]);
        } catch (Exception $e) {
            Log::error('Battery Product Search Error: ' . $e->getMessage());
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function ProductList()
    {
        try {
            $ProductData = BatteryProduct::with(['category', 'subCategory', 'unit', 'brand'])->latest('id')->get();
            return response()->json(['status' => 'success', 'ProductData' => $ProductData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function ProductStockOut(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $query = BatteryProduct::with(['category', 'subCategory', 'unit'])
                ->whereRaw('CAST(quantity AS DECIMAL(10,2)) <= 10');

            if (!empty($startDate) && !empty($endDate)) {
                $startDate = Carbon::parse($startDate)->startOfDay();
                $endDate = Carbon::parse($endDate)->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $ProductData = $query->orderByRaw('CAST(quantity AS DECIMAL(10,2)) asc')->get();

            return response()->json(['status' => 'success', 'ProductData' => $ProductData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function checkDuplicateProduct(Request $request)
    {
        try {
            $productName = trim($request->input('product_name', ''));
            $categoryId = $request->input('category_id');
            if ($categoryId === 'none' || empty($categoryId)) $categoryId = null;
            $brandId = $request->input('brand_id');
            if ($brandId === 'none' || empty($brandId)) $brandId = null;

            if (empty($productName)) {
                return response()->json(['exists' => false]);
            }

            $query = BatteryProduct::where('product_name', $productName);
            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }
            if ($brandId) {
                $query->where('brand_id', $brandId);
            }

            $existing = $query->first(['id', 'product_name', 'quantity', 'cost_price', 'sell_price']);
            return response()->json([
                'exists' => (bool)$existing,
                'product' => $existing
            ]);
        } catch (Exception $e) {
            return response()->json(['exists' => false, 'error' => $e->getMessage()]);
        }
    }

    public function ProductCreate(Request $request)
    {
        try {
            $user_id = Auth::id();

            $productImgPath = null;
            if ($request->hasFile('img_url')) {
                $img = $request->file('img_url');
                $img_name = time() . '-' . $user_id . '-' . $img->getClientOriginalName();
                $productImgPath = "uploads/battery-product-img/{$img_name}";
                $destination = public_path('uploads/battery-product-img');
                if (!file_exists($destination)) {
                    @mkdir($destination, 0777, true);
                }
                $img->move($destination, $img_name);
            }

            $brandId = (!empty($request->brand_id) && $request->brand_id !== 'none') ? $request->brand_id : null;
            $catId = (!empty($request->category_id) && $request->category_id !== 'none') ? $request->category_id : null;
            $subCatId = (!empty($request->sub_category_id) && $request->sub_category_id !== 'none') ? $request->sub_category_id : null;
            $unitId = (!empty($request->unit_id) && $request->unit_id !== 'none') ? $request->unit_id : null;

            $barcodes = [];
            if ($request->has('product_code')) {
                $rawCode = $request->product_code;
                $codes = json_decode($rawCode, true);
                if (!is_array($codes)) {
                    if (!empty(trim((string)$rawCode))) {
                        $codes = array_map('trim', explode(',', $rawCode));
                    } else {
                        $codes = [];
                    }
                }
                foreach ($codes as $code) {
                    $codeStr = trim((string)$code);
                    if (!empty($codeStr)) {
                        $barcodes[] = $codeStr;
                    }
                }
            }

            $quantity = (!is_null($request->quantity) && $request->quantity !== '') ? $request->quantity : 0;
            $costPrice = (!is_null($request->cost_price) && $request->cost_price !== '') ? $request->cost_price : 0;
            $sellPrice = (!is_null($request->sell_price) && $request->sell_price !== '') ? $request->sell_price : 0;

            $product = BatteryProduct::create([
                'img_url' => $productImgPath,
                'product_name' => $request->product_name,
                'quantity' => $quantity,
                'cost_price' => $costPrice,
                'sell_price' => $sellPrice,
                'status' => $request->status ?? 'Active',
                'product_code' => is_string($request->product_code) && !empty($request->product_code) ? $request->product_code : json_encode(array_values($barcodes)),
                'brand_id' => $brandId,
                'category_id' => $catId,
                'sub_category_id' => $subCatId,
                'unit_id' => $unitId,
                'user_id' => $user_id,
            ]);

            $product->load(['brand', 'category']);

            return response()->json(['status' => 'success', 'message' => 'Product Created Successfully', 'product' => $product]);
        } catch (Exception $e) {
            Log::error('Battery Product Create Error: ' . $e->getMessage());
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function ProductByID(Request $request)
    {
        try {
            $request->validate(["id" => 'required']);
            $rows = BatteryProduct::with(['category', 'subCategory', 'unit', 'brand'])->where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function ProductUpdate(Request $request)
    {
        try {
            $user_id = Auth::id();
            $product = BatteryProduct::findOrFail($request->input('id'));

            $productName = $request->input('product_name');
            $costPrice = (!is_null($request->input('cost_price')) && $request->input('cost_price') !== '') ? $request->input('cost_price') : 0;
            $sellPrice = (!is_null($request->input('sell_price')) && $request->input('sell_price') !== '') ? $request->input('sell_price') : 0;
            $status = $request->input('status') ?? 'Active';
            $brandId = (!empty($request->input('brand_id')) && $request->input('brand_id') !== 'none') ? $request->input('brand_id') : null;
            $categoryId = (!empty($request->input('category_id')) && $request->input('category_id') !== 'none') ? $request->input('category_id') : null;
            $subCategoryId = (!empty($request->input('sub_category_id')) && $request->input('sub_category_id') !== 'none') ? $request->input('sub_category_id') : null;
            $unitId = (!empty($request->input('unit_id')) && $request->input('unit_id') !== 'none') ? $request->input('unit_id') : null;

            if ($request->hasFile('img_url')) {
                $img = $request->file('img_url');
                $img_name = time() . '-' . $user_id . '-' . $img->getClientOriginalName();
                $img_url = "uploads/battery-product-img/{$img_name}";
                $destination = public_path('uploads/battery-product-img');
                if (!file_exists($destination)) {
                    @mkdir($destination, 0777, true);
                }
                $img->move($destination, $img_name);

                if ($product->img_url && file_exists(public_path($product->img_url))) {
                    @unlink(public_path($product->img_url));
                }

                $product->img_url = $img_url;
            }

            if ($request->has('product_code')) {
                $rawCode = $request->input('product_code');
                $codes = json_decode($rawCode, true);
                if (!is_array($codes)) {
                    if (!empty(trim((string)$rawCode))) {
                        $codes = array_map('trim', explode(',', $rawCode));
                    } else {
                        $codes = [];
                    }
                }

                $cleanCodes = [];
                foreach ($codes as $code) {
                    $codeStr = trim((string)$code);
                    if (empty($codeStr)) continue;

                    $existing = BatteryProduct::whereJsonContains('product_code', $codeStr)
                        ->where('id', '!=', $product->id)
                        ->first();
                    if ($existing) {
                        return response()->json([
                            'status' => 'fail',
                            'message' => "বারকোড \"{$codeStr}\" ইতিমধ্যে প্রোডাক্ট \"{$existing->product_name}\" এ ব্যবহৃত হয়েছে।"
                        ]);
                    }
                    $cleanCodes[] = $codeStr;
                }
                $product->product_code = json_encode(array_values(array_unique($cleanCodes)));
            }

            $product->product_name = $productName;
            $product->cost_price = $costPrice;
            $product->sell_price = $sellPrice;
            $product->status = $status;
            $product->brand_id = $brandId;
            $product->category_id = $categoryId;
            $product->sub_category_id = $subCategoryId;
            $product->unit_id = $unitId;

            if ($request->has('quantity') && !is_null($request->input('quantity'))) {
                $product->quantity = $request->input('quantity');
            }

            $product->save();

            return response()->json(['status' => 'success', 'message' => 'Product updated successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function ProductDelete(Request $request)
    {
        try {
            $request->validate(['id' => 'required|integer']);

            $productID = $request->input('id');
            $product = BatteryProduct::find($productID);
            if (!$product) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Product not found.'
                ]);
            }

            $hasOrders = DB::table('battery_order_details')->where('product_id', $productID)->exists();
            $hasPurchases = DB::table('battery_purchase_order_details')->where('product_id', $productID)->exists();
            $hasPurchaseReturns = DB::table('battery_purchase_returns')->where('product_id', $productID)->exists();
            $hasSalesReturns = DB::table('battery_product_returns')->where('product_id', $productID)->exists();

            if ($hasOrders || $hasPurchases || $hasPurchaseReturns || $hasSalesReturns) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'এই ব্যাটারি প্রোডাক্টটি পূর্বের কাস্টমার ইনভয়েস অথবা পারচেজে ব্যবহৃত হয়েছে, তাই সরাসরি ডিলিট করা যাবে না। স্টক বন্ধ করতে প্রোডাক্টটি Edit করে Quantity 0 করে দিন।'
                ]);
            }

            if ($product->img_url && file_exists(public_path($product->img_url))) {
                @unlink(public_path($product->img_url));
            }

            $product->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully.'
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
