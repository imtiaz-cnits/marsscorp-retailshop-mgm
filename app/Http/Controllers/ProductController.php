<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\BuyerInfo;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{


    public function ProductIDSearch(Request $request)
    {
        $productID = $request->input('product_id');

        // Check if the product_code (which is a JSON array) contains the given product_id
        $product = Product::whereJsonContains('product_code', $productID)->first();

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

            $products = Product::where('product_name', 'LIKE', "%{$query}%")
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
                if (!empty($p->door_side)) {
                    $displayName .= " ({$p->door_side})";
                }

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
                    'door_side' => $p->door_side,
                    'img_url' => $p->img_url,
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $formatted
            ]);
        } catch (Exception $e) {
            Log::error('Product Search Error: ' . $e->getMessage());
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }




    public function AllProductsDataShow()
    {
        try {
            // Fetch first 30 products regardless of category
            $products = Product::limit(30)->get();

            return response()->json([
                'ProductFrontData' => $products,
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    public function ProductStockOut(Request $request)
    {
        try {
            // Get start_date and end_date from the request
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Query low stock and out-of-stock products (quantity <= 10)
            $query = Product::with(['category', 'subCategory', 'unit'])
                ->whereRaw('CAST(quantity AS DECIMAL(10,2)) <= 10');

            // If start_date and end_date are provided, filter by created_at date range
            if (!empty($startDate) && !empty($endDate)) {
                $startDate = Carbon::parse($startDate)->startOfDay();
                $endDate = Carbon::parse($endDate)->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            // Fetch filtered data sorted ascending by quantity
            $ProductData = $query->orderByRaw('CAST(quantity AS DECIMAL(10,2)) asc')->get();

            return response()->json(['status' => 'success', 'ProductData' => $ProductData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }




    public function ProductList()
    {
        try {
            $ProductData = Product::with(['category', 'subCategory', 'unit', 'brand'])->latest('id')->get();
            return response()->json(['status' => 'success', 'ProductData' => $ProductData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    // public function ProductList()
    // {
    //     try {
    //         $ProductData = Product::select('id', 'img_url', 'product_name', 'cost_price', 'sell_price', 'product_code', 'quantity')->get();
    //         return response()->json(['status' => 'success', 'ProductData' => $ProductData]);
    //     } catch (Exception $e) {
    //         return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    //     }
    // }



    public function ProductCreate(Request $request)
    {
        try {
            $user_id = Auth::id();

            // Decode and extract barcodes from request
            $barcodes = [];
            if (is_array($request->product_code)) {
                $barcodes = array_filter($request->product_code);
            } else if (is_string($request->product_code)) {
                $decoded = json_decode($request->product_code, true);
                if (is_array($decoded)) {
                    $barcodes = array_filter($decoded);
                } else if (!empty(trim($request->product_code))) {
                    $barcodes = [trim($request->product_code)];
                }
            }

            // Check for duplicate barcodes in database
            foreach ($barcodes as $code) {
                $codeStr = trim((string)$code);
                if (empty($codeStr)) continue;

                $existingProduct = Product::whereJsonContains('product_code', $codeStr)->first();
                if ($existingProduct) {
                    return response()->json([
                        'status' => 'fail',
                        'message' => "এই বারকোডটি ({$codeStr}) ইতিমধ্যে \"{$existingProduct->product_name}\" প্রোডাক্টে যুক্ত রয়েছে!"
                    ]);
                }
            }

            // Initialize image paths as null
            $productImgPath = null;

            // Handle product image upload
            if ($request->hasFile('img')) {
                $productImg = $request->file('img');
                $productImgName = time() . '-' . $user_id . '-' . $productImg->getClientOriginalName();
                $productImgPath = "uploads/product-img/{$productImgName}";
                $productImg->move(public_path('uploads/product-img'), $productImgName);
            }

            $leftQty = floatval($request->input('door_qty_left', 0));
            $rightQty = floatval($request->input('door_qty_right', 0));
            $bothQty = floatval($request->input('door_qty_both', 0));

            $doorEntries = [];
            if ($leftQty > 0) $doorEntries['Left Handed'] = $leftQty;
            if ($rightQty > 0) $doorEntries['Right Handed'] = $rightQty;
            if ($bothQty > 0) $doorEntries['Both Handed'] = $bothQty;

            $productName = trim($request->product_name);
            $catId = (!empty($request->category_id) && $request->category_id !== 'none') ? $request->category_id : null;
            $brandId = (!empty($request->brand_id) && $request->brand_id !== 'none') ? $request->brand_id : null;

            // Check if duplicate product already exists
            if (count($doorEntries) > 1) {
                foreach (array_keys($doorEntries) as $side) {
                    $existQ = Product::where('product_name', $productName)->where('door_side', $side);
                    if ($catId) $existQ->where('category_id', $catId);
                    if ($brandId) $existQ->where('brand_id', $brandId);
                    $existing = $existQ->first();
                    if ($existing) {
                        return response()->json([
                            'status' => 'fail',
                            'message' => "\"{$productName}\" ({$side}) ইতিমধ্যে ডাটাবেজে রয়েছে! স্টক বাড়াতে Purchase বা Edit করুন।"
                        ]);
                    }
                }
            } else {
                $checkDoorSide = null;
                if (count($doorEntries) === 1) {
                    $checkDoorSide = array_key_first($doorEntries);
                } else if (!empty($request->door_side) && $request->door_side !== 'none') {
                    $checkDoorSide = $request->door_side;
                }

                $existQ = Product::where('product_name', $productName);
                if ($catId) $existQ->where('category_id', $catId);
                if ($brandId) $existQ->where('brand_id', $brandId);
                if ($checkDoorSide) {
                    $existQ->where('door_side', $checkDoorSide);
                } else {
                    $existQ->where(function ($q) {
                        $q->whereNull('door_side')->orWhere('door_side', '');
                    });
                }

                $existing = $existQ->first();
                if ($existing) {
                    return response()->json([
                        'status' => 'fail',
                        'message' => "এই ব্র্যান্ড ও ক্যাটাগরিতে \"{$productName}\" ইতিমধ্যে ডাটাবেজে রয়েছে! নতুন প্রোডাক্ট না বানিয়ে স্টক বাড়াতে Purchase অথবা Edit করুন।"
                    ]);
                }
            }

            // If multiple door handedness quantities are entered
            if (count($doorEntries) > 1) {
                $createdProducts = [];
                foreach ($doorEntries as $side => $qty) {
                    $p = Product::create([
                        'img_url' => $productImgPath,
                        'product_name' => $request->product_name,
                        'quantity' => $qty,
                        'cost_price' => (!is_null($request->cost_price) && $request->cost_price !== '') ? $request->cost_price : 0,
                        'sell_price' => (!is_null($request->sell_price) && $request->sell_price !== '') ? $request->sell_price : 0,
                        'status' => $request->status ?? 'Active',
                        'product_code' => is_string($request->product_code) ? $request->product_code : json_encode(array_values($barcodes)),
                        'brand_id' => (!empty($request->brand_id) && $request->brand_id !== 'none') ? $request->brand_id : null,
                        'category_id' => (!empty($request->category_id) && $request->category_id !== 'none') ? $request->category_id : null,
                        'door_side' => $side,
                        'sub_category_id' => $request->sub_category_id,
                        'unit_id' => $request->unit_id,
                        'user_id' => $user_id,
                    ]);
                    $createdProducts[] = $p;
                }
                return response()->json(['status' => 'success', 'message' => 'Product Variants Created Successfully', 'products' => $createdProducts]);
            }

            // Single door side or standard product
            $doorSide = null;
            $quantity = (!is_null($request->quantity) && $request->quantity !== '') ? $request->quantity : 0;

            if (count($doorEntries) === 1) {
                $doorSide = array_key_first($doorEntries);
                $quantity = $doorEntries[$doorSide];
            } else if (!empty($request->door_side) && $request->door_side !== 'none') {
                $doorSide = $request->door_side;
            }

            // Create Product
            $product = Product::create([
                'img_url' => $productImgPath,
                'product_name' => $request->product_name,
                'quantity' => $quantity,
                'cost_price' => (!is_null($request->cost_price) && $request->cost_price !== '') ? $request->cost_price : 0,
                'sell_price' => (!is_null($request->sell_price) && $request->sell_price !== '') ? $request->sell_price : 0,
                'status' => $request->status ?? 'Active',
                'product_code' => is_string($request->product_code) ? $request->product_code : json_encode(array_values($barcodes)),
                'brand_id' => (!empty($request->brand_id) && $request->brand_id !== 'none') ? $request->brand_id : null,
                'category_id' => (!empty($request->category_id) && $request->category_id !== 'none') ? $request->category_id : null,
                'door_side' => $doorSide,
                'sub_category_id' => $request->sub_category_id,
                'unit_id' => $request->unit_id,
                'user_id' => $user_id,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Product Created Successfully', 'product' => $product]);
        } catch (Exception $e) {
            Log::error($e->getMessage()); // Log the error message
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
            $doorSide = $request->input('door_side');
            if ($doorSide === 'none' || empty($doorSide)) $doorSide = null;

            if (empty($productName)) {
                return response()->json(['exists' => false]);
            }

            $query = Product::where('product_name', $productName);
            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }
            if ($brandId) {
                $query->where('brand_id', $brandId);
            }
            if ($doorSide) {
                $query->where('door_side', $doorSide);
            } else {
                $query->where(function ($q) {
                    $q->whereNull('door_side')->orWhere('door_side', '');
                });
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

    function ProductByID(Request $request)
    {

        try {
            $user_id = Auth::id();
            $request->validate(["id" => 'required']);
            $rows = Product::with(['category', 'subCategory', 'unit', 'brand'])->where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    public function ProductUpdate(Request $request)
    {
        try {
            $user_id = Auth::id();

            // Update Product Info
            $product = Product::findOrFail($request->input('id'));

            $productName = $request->input('product_name');
            $costPrice = (!is_null($request->input('cost_price')) && $request->input('cost_price') !== '') ? $request->input('cost_price') : 0;
            $sellPrice = (!is_null($request->input('sell_price')) && $request->input('sell_price') !== '') ? $request->input('sell_price') : 0;
            $status = $request->input('status') ?? 'Active';
            $brandId = (!empty($request->input('brand_id')) && $request->input('brand_id') !== 'none') ? $request->input('brand_id') : null;
            $categoryId = (!empty($request->input('category_id')) && $request->input('category_id') !== 'none') ? $request->input('category_id') : null;
            $subCategoryId = (!empty($request->input('sub_category_id')) && $request->input('sub_category_id') !== 'none') ? $request->input('sub_category_id') : null;
            $unitId = (!empty($request->input('unit_id')) && $request->input('unit_id') !== 'none') ? $request->input('unit_id') : null;

            // Handle Product Image Upload
            if ($request->hasFile('img_url')) {
                $img = $request->file('img_url');
                $img_name = time() . '-' . $user_id . '-' . $img->getClientOriginalName();
                $img_url = "uploads/product-img/{$img_name}";
                $img->move(public_path('uploads/product-img'), $img_name);

                // Remove old image if exists
                if ($product->img_url && file_exists(public_path($product->img_url))) {
                    @unlink(public_path($product->img_url));
                }

                $product->img_url = $img_url;
            }

            // Handle Product Barcodes
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

                    $existing = Product::whereJsonContains('product_code', $codeStr)
                        ->where('id', '!=', $product->id)
                        ->first();
                    if ($existing) {
                        return response()->json([
                            'status' => 'fail',
                            'message' => "এই বারকোডটি ({$codeStr}) ইতিমধ্যে \"{$existing->product_name}\" প্রোডাক্টে যুক্ত রয়েছে!"
                        ]);
                    }
                    $cleanCodes[] = $codeStr;
                }
                $product->product_code = json_encode(array_values(array_unique($cleanCodes)));
            }

            // Check if handedness quantities are provided
            $leftQty = $request->has('door_qty_left') ? floatval($request->input('door_qty_left')) : null;
            $rightQty = $request->has('door_qty_right') ? floatval($request->input('door_qty_right')) : null;
            $bothQty = $request->has('door_qty_both') ? floatval($request->input('door_qty_both')) : null;

            $hasDoorQuantities = (!is_null($leftQty) || !is_null($rightQty) || !is_null($bothQty));

            if ($hasDoorQuantities && ($leftQty > 0 || $rightQty > 0 || $bothQty > 0)) {
                $doorMap = [
                    'Left Handed' => $leftQty ?? 0,
                    'Right Handed' => $rightQty ?? 0,
                    'Both Handed' => $bothQty ?? 0,
                ];

                // Find existing variants of this product (same product_name & category_id)
                $variants = Product::where('product_name', $product->product_name)
                    ->where('category_id', $product->category_id)
                    ->where(function ($q) use ($product) {
                        if ($product->brand_id) {
                            $q->where('brand_id', $product->brand_id);
                        }
                    })
                    ->get();

                $assignedProductIds = [];

                foreach ($doorMap as $side => $qty) {
                    // Try to find existing variant for this door_side
                    $existingVariant = $variants->first(function ($v) use ($side) {
                        return $v->door_side === $side;
                    });

                    // If not found and current product matches this side or has no side yet
                    if (!$existingVariant && ($product->door_side === $side || empty($product->door_side)) && !in_array($product->id, $assignedProductIds)) {
                        $existingVariant = $product;
                    }

                    if ($existingVariant) {
                        $existingVariant->product_name = $productName;
                        $existingVariant->quantity = $qty;
                        $existingVariant->cost_price = $costPrice;
                        $existingVariant->sell_price = $sellPrice;
                        $existingVariant->status = $status;
                        $existingVariant->brand_id = $brandId;
                        $existingVariant->category_id = $categoryId;
                        $existingVariant->door_side = $side;
                        $existingVariant->sub_category_id = $subCategoryId;
                        $existingVariant->unit_id = $unitId;
                        if ($product->img_url) {
                            $existingVariant->img_url = $product->img_url;
                        }
                        $existingVariant->save();
                        $assignedProductIds[] = $existingVariant->id;
                    } else if ($qty > 0) {
                        // Create new variant if quantity > 0
                        $newVariant = Product::create([
                            'img_url' => $product->img_url,
                            'product_name' => $productName,
                            'quantity' => $qty,
                            'cost_price' => $costPrice,
                            'sell_price' => $sellPrice,
                            'status' => $status,
                            'product_code' => $product->product_code,
                            'brand_id' => $brandId,
                            'category_id' => $categoryId,
                            'door_side' => $side,
                            'sub_category_id' => $subCategoryId,
                            'unit_id' => $unitId,
                            'user_id' => $user_id,
                        ]);
                        $assignedProductIds[] = $newVariant->id;
                    }
                }

                // If current product wasn't assigned in the loop, update it with main values
                if (!in_array($product->id, $assignedProductIds)) {
                    $product->product_name = $productName;
                    $product->cost_price = $costPrice;
                    $product->sell_price = $sellPrice;
                    $product->status = $status;
                    $product->brand_id = $brandId;
                    $product->category_id = $categoryId;
                    $product->sub_category_id = $subCategoryId;
                    $product->unit_id = $unitId;
                    $product->save();
                }

                return response()->json(['status' => 'success', 'message' => 'Product and Door variants updated successfully']);
            }

            // Standard product update without multi-door quantities
            $product->product_name = $productName;
            $product->quantity = (!is_null($request->input('quantity')) && $request->input('quantity') !== '') ? $request->input('quantity') : 0;
            $product->cost_price = $costPrice;
            $product->sell_price = $sellPrice;
            $product->status = $status;
            $product->brand_id = $brandId;
            $product->category_id = $categoryId;
            $product->door_side = (!empty($request->input('door_side')) && $request->input('door_side') !== 'none') ? $request->input('door_side') : null;
            $product->sub_category_id = $subCategoryId;
            $product->unit_id = $unitId;
            $product->save();

            return response()->json(['status' => 'success', 'message' => 'Product updated successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function ProductDelete(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'id' => 'required|integer',
            ]);

            $productID = $request->input('id');

            // Check if the product exists
            $product = Product::find($productID);
            if (!$product) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Product not found.'
                ]);
            }

            // Check if product is associated with orders or purchases
            $hasOrders = DB::table('order_details')->where('product_id', $productID)->exists();
            $hasPurchases = DB::table('purchase_order_details')->where('product_id', $productID)->exists();
            $hasReturns = DB::table('purchase_returns')->where('product_id', $productID)->exists();

            if ($hasOrders || $hasPurchases || $hasReturns) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'এই প্রোডাক্টটি পূর্বের কাস্টমার ইনভয়েস অথবা পারচেজে ব্যবহৃত হয়েছে, তাই সরাসরি ডিলিট করা যাবে না। স্টক বন্ধ করতে প্রোডাক্টটি Edit করে Quantity 0 করে দিন।'
                ]);
            }

            // Delete associated image file if it exists
            if ($product->img_url) {
                $filePath = public_path($product->img_url);

                if (file_exists($filePath)) {
                    if (!unlink($filePath)) {
                        return response()->json([
                            'status' => 'fail',
                            'message' => 'Failed to delete the product image.'
                        ]);
                    }
                }
            }
            // Delete the product record
            $product->delete();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully.'
            ]);
        } catch (Exception $e) {
            // Log the error for debugging
            Log::error('Product Delete Error: ' . $e->getMessage());

            // Return failure response
            return response()->json([
                'status' => 'fail',
                'message' => 'An error occurred while deleting the product.'
            ]);
        }
    }

    public function UnitList()
    {
        try {
            $units = Unit::all();
            return response()->json(['status' => 'success', 'units' => $units]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
