<?php

namespace App\Http\Controllers\Battery;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BatteryBrandController extends Controller
{
    public function BrandList()
    {
        try {
            $BrandData = BatteryBrand::latest()->get();
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

            if ($request->hasFile('img_url')) {
                $img = $request->file('img_url');
                $t = time();
                $file_name = $img->getClientOriginalName();
                $img_name = "{$user_id}-{$t}-{$file_name}";
                $img_url = "uploads/battery-brand-img/{$img_name}";

                $destination = public_path('uploads/battery-brand-img');
                if (!file_exists($destination)) {
                    @mkdir($destination, 0777, true);
                }
                $img->move($destination, $img_name);
            }

            $brand = BatteryBrand::create([
                'name' => $request->input('name'),
                'img_url' => $img_url,
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

    public function BrandById(Request $request)
    {
        try {
            $request->validate(["id" => 'required']);
            $rows = BatteryBrand::where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function BrandUpdate(Request $request)
    {
        try {
            $user_id = Auth::id();
            $brand = BatteryBrand::find($request->input('id'));

            if (!$brand) {
                return response()->json(['status' => 'fail', 'message' => 'Brand not found.']);
            }

            $brand->name = $request->input('name');

            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $t = time();
                $file_name = $img->getClientOriginalName();
                $img_name = "{$user_id}-{$t}-{$file_name}";
                $img_url = "uploads/battery-brand-img/{$img_name}";

                $destination = public_path('uploads/battery-brand-img');
                if (!file_exists($destination)) {
                    @mkdir($destination, 0777, true);
                }
                $img->move($destination, $img_name);

                if ($brand->img_url && file_exists(public_path($brand->img_url))) {
                    @unlink(public_path($brand->img_url));
                }

                $brand->img_url = $img_url;
            }

            $brand->save();

            return response()->json(['status' => 'success', 'message' => 'Brand updated successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function BrandDelete(Request $request)
    {
        try {
            $request->validate(['id' => 'required']);
            $brand = BatteryBrand::find($request->input('id'));

            if (!$brand) {
                return response()->json(['status' => 'fail', 'message' => 'Brand not found.']);
            }

            if ($brand->logo && file_exists(public_path($brand->logo))) {
                @unlink(public_path($brand->logo));
            }

            $brand->delete();

            return response()->json(['status' => 'success', 'message' => 'Brand deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
