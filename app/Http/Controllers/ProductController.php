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
            $ProductData = Product::with(['category', 'subCategory', 'unit'])->get();
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
                $productImgPath = "uploads/Product-img/{$productImgName}";
                $productImg->move(public_path('uploads/Product-img'), $productImgName);
            }

            // Create Product
            $product = Product::create([
                'img_url' => $productImgPath,
                'product_name' => $request->product_name,
                'quantity' => (!is_null($request->quantity) && $request->quantity !== '') ? $request->quantity : 0,
                'cost_price' => (!is_null($request->cost_price) && $request->cost_price !== '') ? $request->cost_price : 0,
                'sell_price' => (!is_null($request->sell_price) && $request->sell_price !== '') ? $request->sell_price : 0,
                'status' => $request->status ?? 'Active',
                'product_code' => is_string($request->product_code) ? $request->product_code : json_encode(array_values($barcodes)),
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'door_side' => (!empty($request->door_side) && $request->door_side !== 'none') ? $request->door_side : null,
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

    function ProductByID(Request $request)
    {

        try {
            $user_id = Auth::id();
            $request->validate(["id" => 'required']);
            $rows = Product::with(['category', 'subCategory', 'unit'])->where('id', $request->input('id'))->first();
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

            $product->product_name = $request->input('product_name');
            $product->quantity = (!is_null($request->input('quantity')) && $request->input('quantity') !== '') ? $request->input('quantity') : 0;
            $product->cost_price = (!is_null($request->input('cost_price')) && $request->input('cost_price') !== '') ? $request->input('cost_price') : 0;
            $product->sell_price = (!is_null($request->input('sell_price')) && $request->input('sell_price') !== '') ? $request->input('sell_price') : 0;
            $product->status = $request->input('status') ?? 'Active';
            $product->brand_id = (!empty($request->input('brand_id')) && $request->input('brand_id') !== 'none') ? $request->input('brand_id') : null;
            $product->category_id = (!empty($request->input('category_id')) && $request->input('category_id') !== 'none') ? $request->input('category_id') : null;
            $product->door_side = (!empty($request->input('door_side')) && $request->input('door_side') !== 'none') ? $request->input('door_side') : null;
            $product->sub_category_id = (!empty($request->input('sub_category_id')) && $request->input('sub_category_id') !== 'none') ? $request->input('sub_category_id') : null;
            $product->unit_id = (!empty($request->input('unit_id')) && $request->input('unit_id') !== 'none') ? $request->input('unit_id') : null;

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


            // Handle Product Image Upload
            if ($request->hasFile('img_url')) {
                $img = $request->file('img_url');
                $img_name = time() . '-' . $user_id . '-' . $img->getClientOriginalName();
                $img_url = "uploads/Product-img/{$img_name}";
                $img->move(public_path('uploads/Product-img'), $img_name);

                // Remove old image if exists
                if ($product->img_url && file_exists(public_path($product->img_url))) {
                    @unlink(public_path($product->img_url));
                }

                $product->img_url = $img_url;
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
