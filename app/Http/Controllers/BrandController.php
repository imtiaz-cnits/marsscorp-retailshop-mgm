<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{



    public function BrandList()
    {
        try {
            $user_id = Auth::id();
            $BrandData = Brand::latest()->get();
            return response()->json(['status' => 'success', 'BrandData' => $BrandData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
    public function BrandCreate(Request $request)
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
                $img_url = "uploads/brand-img/{$img_name}";

                // Upload File
                $img->move(public_path('uploads/brand-img'), $img_name);
            }

            // Create new brand
            $brand = Brand::create([
                'name' => $request->input('name'),
                'status' => $request->input('status'),
                'logo' => $img_url,
                'user_id' => $user_id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Brand Created Successfully',
                'newBrandId' => $brand->id,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }



    function BrandById(Request $request){
        try {
            $user_id = Auth::id();
            $request->validate(["id" => 'required|string']);

            $rows = Brand ::where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


public function BrandUpdate(Request $request)
{
    try {
        $user_id = Auth::id();
        $BrandData_Update = Brand::find($request->input('id'));

        if (!$BrandData_Update) {
            return response()->json(['status' => 'fail', 'message' => 'Brand not found.']);
        }

        $BrandData_Update->name = $request->input('name'); // Use parentheses for input
        $BrandData_Update->status = $request->input('status');

        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$t}-{$file_name}";
            $img_url = "uploads/brand-img/{$img_name}";

            // Upload File
            $img->move(public_path('uploads/brand-img'), $img_name);

            // Delete old image if it exists
            if ($BrandData_Update->logo && file_exists(public_path($BrandData_Update->logo))) {
                unlink(public_path($BrandData_Update->logo));
            }

            $BrandData_Update->logo = $img_url; // Correct property to set logo
        }

        $BrandData_Update->save();

        return response()->json(['status' => 'success', 'message' => 'Brand updated successfully']);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}



function BrandDelete(Request $request)
{
    try {
        // Validation
        $request->validate(['id' => 'required|string|min:1']);

        $brand_id = $request->input('id');
        $brand_delete = Brand::find($brand_id);

        if (!$brand_delete) {
            return response()->json(['status' => 'fail', 'message' => 'Brand not found.']);
        }

        // Delete image if it exists
        if ($brand_delete->logo && file_exists(public_path($brand_delete->logo))) {
            unlink(public_path($brand_delete->logo));
        }

        // Delete brand
        $brand_delete->delete();

        return response()->json(['status' => 'success', 'message' => 'Brand deleted successfully']);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}





}
