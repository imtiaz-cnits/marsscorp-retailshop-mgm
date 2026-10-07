<?php

namespace App\Http\Controllers\Battery;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BatteryCategoryController extends Controller
{
    public function CategoryList()
    {
        try {
            $CategoryData = BatteryCategory::all();
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

            if ($request->hasFile('img_url')) {
                $img = $request->file('img_url');
                $t = time();
                $file_name = $img->getClientOriginalName();
                $img_name = "{$user_id}-{$t}-{$file_name}";
                $img_url = "uploads/battery-category-img/{$img_name}";

                $destination = public_path('uploads/battery-category-img');
                if (!file_exists($destination)) {
                    @mkdir($destination, 0777, true);
                }
                $img->move($destination, $img_name);
            }

            $catName = $request->input('category_name') ?? $request->input('name');
            $category = BatteryCategory::create([
                'name' => $catName,
                'img_url' => $img_url,
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

    public function CategoryByID(Request $request)
    {
        try {
            $request->validate(["id" => 'required']);
            $rows = BatteryCategory::where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function CategoryUpdate(Request $request)
    {
        try {
            $user_id = Auth::id();
            $category = BatteryCategory::find($request->input('id'));

            if (!$category) {
                return response()->json(['status' => 'fail', 'message' => 'Category not found.']);
            }

            $catName = $request->input('category_name') ?? $request->input('name');
            if ($catName) {
                $category->name = $catName;
            }

            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $t = time();
                $file_name = $img->getClientOriginalName();
                $img_name = "{$user_id}-{$t}-{$file_name}";
                $img_url = "uploads/battery-category-img/{$img_name}";

                $destination = public_path('uploads/battery-category-img');
                if (!file_exists($destination)) {
                    @mkdir($destination, 0777, true);
                }
                $img->move($destination, $img_name);

                if ($category->img_url && file_exists(public_path($category->img_url))) {
                    @unlink(public_path($category->img_url));
                }

                $category->img_url = $img_url;
            }

            $category->save();

            return response()->json(['status' => 'success', 'message' => 'Category updated successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function CategoryDelete(Request $request)
    {
        try {
            $request->validate(['id' => 'required']);
            $category = BatteryCategory::find($request->input('id'));

            if (!$category) {
                return response()->json(['status' => 'fail', 'message' => 'Category not found.']);
            }

            if ($category->img_url && file_exists(public_path($category->img_url))) {
                @unlink(public_path($category->img_url));
            }

            $category->delete();

            return response()->json(['status' => 'success', 'message' => 'Category deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
