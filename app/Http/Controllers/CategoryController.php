<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
   // List all Categories
public function AJXCategoryList()
{
    try {
        // Fetch all categories
        $CategoryData = Category::latest()->get();
        return response()->json(['status' => 'success', 'CategoryData' => $CategoryData]);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}

public function GetCategoriesList()
{
    try {
        // Fetch all categories
        $GetCategoryData = Category::all();
        return response()->json(['status' => 'success', 'GetCategoryData' => $GetCategoryData]);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}


public function BrandWishProductDataShow(Request $request)
{
    try {
        $brandId = $request->get('brand_id', 0);

        // Initialize the query for products
        $query = Product::query()->with(['category', 'brand']);

        // Apply brand filter only if a specific brand is selected
        if ($brandId != 0) {
            $query->where('brand_id', $brandId);
        }

        // Retrieve products without pagination
        $products = $query->latest()->get();

        return response()->json([
            'ProductFrontData' => $products,
        ]);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}


public function GetBrandsList()
{
    try {
        // Fetch all brands
        $GetBrandData = Brand::all();
        return response()->json(['status' => 'success', 'GetBrandData' => $GetBrandData]);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}


   // List all Categories
public function CategoryList()
{
    try {
        // Fetch all categories
        $CategoryData = Category::all();
        return response()->json(['status' => 'success', 'CategoryData' => $CategoryData]);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}

public function CategoryCreate(Request $request)
{
    try {
        $user_id = Auth::id();
        $img_url = null;

        // Check if an image file is provided
        if ($request->hasFile('img_url')) {
            $img = $request->file('img_url');
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$t}-{$file_name}";
            $img_url = "uploads/category-img/{$img_name}";

            // Upload File
            $img->move(public_path('uploads/category-img'), $img_name);
        }

        // Create the category
        $category = Category::create([
            'category_name' => $request->input('category_name'),
            'img_url' => $img_url,
            'status' => $request->input('status'),
            'user_id' => $user_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => "Category Created Successfully",
            'newCategoryId' => $category->id,
        ]);

    } catch (Exception $e) {
        return response()->json([
            'status' => 'fail',
            'message' => $e->getMessage(),
        ]);
    }
}

function CategoryByID(Request $request){
    try {
        $user_id = Auth::id();
        $request->validate(["id" => 'required|string']);

        $rows = Category ::where('id', $request->input('id'))->first();
        return response()->json(['status' => 'success', 'rows' => $rows]);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}

function CategoryUpdate(Request $request)
{
try {
    $user_id = Auth::id();
    $CategoryData_Update = Category::find($request->input('id'));

    if (!$CategoryData_Update) {
        return response()->json(['status' => 'fail', 'message' => 'Category not found.']);
    }

    // Validate inputs
    $validatedData = $request->validate([
        'category_name' => 'required|string|max:255',
        'status' => 'required|in:Active,InActive',
        'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024', // Max 1MB
    ]);

    // Update Category name and status
    $CategoryData_Update->category_name = $validatedData['category_name'];
    $CategoryData_Update->status = $validatedData['status'];

    if ($request->hasFile('img')) {
        $img = $request->file('img');
        $t = time();
        $file_name = $img->getClientOriginalName();
        $img_name = "{$user_id}-{$t}-{$file_name}";
        $img_url = "uploads/category-img/{$img_name}";

        // Upload File
        $img->move(public_path('uploads/category-img'), $img_name);

        // Delete old image if it exists
        if ($CategoryData_Update->img_url && file_exists(public_path($CategoryData_Update->img_url))) {
            unlink(public_path($CategoryData_Update->img_url));
        }

        $CategoryData_Update->img_url = $img_url; // Correct property to set img_url
    }

    $CategoryData_Update->save();

    return response()->json(['status' => 'success', 'message' => 'Category updated successfully']);
} catch (Exception $e) {
    return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
}
}

function CategoryDelete(Request $request)
{
try {
    // Validation
    $request->validate(['id' => 'required|string|min:1']);

    $Category_id = $request->input('id');
    $Category_delete = Category::find($Category_id);

    if (!$Category_delete) {
        return response()->json(['status' => 'fail', 'message' => 'Category not found.']);
    }


    // Delete Category
    $Category_delete->delete();

    return response()->json(['status' => 'success', 'message' => 'Category deleted successfully']);
} catch (Exception $e) {
    return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
}
}


}
