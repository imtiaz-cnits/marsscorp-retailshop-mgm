<?php

namespace App\Http\Controllers\Battery;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatterySubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BatterySubCategoryController extends Controller
{
    public function getSubCategoriesByCategory($categoryId)
    {
        try {
            $subCategories = BatterySubCategory::where('category_id', $categoryId)->get();
            return response()->json([
                'status' => 'success',
                'subCategories' => $subCategories,
                'data' => $subCategories
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Failed to fetch subcategories: ' . $e->getMessage()
            ]);
        }
    }

    public function SubCategoryList()
    {
        try {
            $SubCategoryData = BatterySubCategory::with('category')->get();
            return response()->json(['status' => 'success', 'SubCategoryData' => $SubCategoryData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function SubCategoryCreate(Request $request)
    {
        try {
            $user_id = Auth::id();
            $name = $request->sub_category_name ?? $request->name;

            $subCat = BatterySubCategory::create([
                'name' => $name,
                'category_id' => $request->category_id,
                'user_id' => $user_id,
            ]);

            return response()->json(['status' => 'success', 'message' => 'SubCategory Created Successfully', 'subCategory' => $subCat]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => 'fail', 'message' => 'Internal Server Error'], 500);
        }
    }

    public function SubCategoryByID(Request $request)
    {
        try {
            $request->validate(["id" => 'required']);
            $SubCategory = BatterySubCategory::with('category')->where('id', $request->input('id'))->first();

            if (!$SubCategory) {
                return response()->json(['status' => 'fail', 'message' => 'SubCategory not found']);
            }

            return response()->json(['status' => 'success', 'rows' => $SubCategory]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function SubCategoryUpdate(Request $request)
    {
        try {
            $SubCategory = BatterySubCategory::findOrFail($request->input('id'));

            $name = $request->input('sub_category_name') ?? $request->input('name');
            if ($name !== null) {
                $SubCategory->name = $name;
            }
            if ($request->filled('category_id')) {
                $SubCategory->category_id = $request->input('category_id');
            }

            $SubCategory->save();

            return response()->json(['status' => 'success', 'message' => 'Sub Category updated successfully']);
        } catch (Exception $e) {
            Log::error('BatterySubCategory Update Error: ' . $e->getMessage());
            return response()->json(['status' => 'fail', 'message' => 'An error occurred while updating the Sub Category.']);
        }
    }

    public function SubCategoryDelete(Request $request)
    {
        try {
            $request->validate(['id' => 'required']);
            $SubCategory = BatterySubCategory::find($request->input('id'));

            if (!$SubCategory) {
                return response()->json(['status' => 'fail', 'message' => 'SubCategory not found.']);
            }

            $SubCategory->delete();

            return response()->json(['status' => 'success', 'message' => 'SubCategory deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
