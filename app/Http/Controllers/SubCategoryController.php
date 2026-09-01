<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SubCategoryController extends Controller
{



public function getSubCategoriesByCategory($categoryId)
{
    try {
        $subCategories = SubCategory::where('category_id', $categoryId)->get();
        return response()->json([
            'status' => 'success',
            'subCategories' => $subCategories
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'fail',
            'message' => 'Failed to fetch subcategories: ' . $e->getMessage()
        ]);
    }
}


    // public function SubCategoryList()
    // {
    //     try {
    //         // Fetch all categories
    //         $SubCategoryData = SubCategory::all();
    //         return response()->json(['status' => 'success', 'SubCategoryData' => $SubCategoryData]);
    //     } catch (Exception $e) {
    //         return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    //     }
    // }

    public function SubCategoryList()
{
    try {
        // Fetch all subcategories with their associated categories
        $SubCategoryData = SubCategory::with('category:id,category_name')->get();
        return response()->json(['status' => 'success', 'SubCategoryData' => $SubCategoryData]);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}



    public function SubCategoryCreate(Request $request)
    {
        try {
            $user_id = Auth::id();

            $SubCategory = SubCategory::create([
                'sub_category_name' => $request->sub_category_name,
                'status' => $request->status,
                'category_id' => $request->category_id,
                'user_id' => $user_id,
            ]);

            return response()->json(['status' => 'success', 'message' => 'SubCategory Created Successfully']);
        } catch (Exception $e) {
            Log::error($e->getMessage()); // Log the error message
            return response()->json(['status' => 'fail', 'message' => 'Internal Server Error'], 500);
        }
    }

    function SubCategoryByID(Request $request)
    {
        try {
            $user_id = Auth::id();
            $request->validate(["id" => 'required|string']);

            // Load SubCategory with related category
            $SubCategory = SubCategory::with('category')->where('id', $request->input('id'))->first();

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
        $user_id = Auth::id();

        // Update SubCategory Info
        $SubCategory = SubCategory::findOrFail($request->input('id'));

        $SubCategory->sub_category_name = $request->input('sub_category_name');
        $SubCategory->status = $request->input('status');
        $SubCategory->category_id = $request->input('category_id');


        $SubCategory->save();

        // Return success response
        return response()->json(['status' => 'success', 'message' => 'Sub Category updated successfully']);
    } catch (Exception $e) {
        // Log the error for debugging
        Log::error('SubCategory Update Error: ' . $e->getMessage());

        // Return failure response
        return response()->json(['status' => 'fail', 'message' => 'An error occurred while updating the Sub Category.']);
    }
}


function SubCategoryDelete(Request $request)
{
    try {
        // Validation
        $request->validate(['id' => 'required|string|min:1']);

        $SubCategory_id = $request->input('id');
        $SubCategory_delete = SubCategory::find($SubCategory_id);

        if (!$SubCategory_delete) {
            return response()->json(['status' => 'fail', 'message' => 'SubCategory not found.']);
        }

        // Delete SubCategory
        $SubCategory_delete->delete();

        return response()->json(['status' => 'success', 'message' => 'SubCategory deleted successfully']);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}

}
