<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistrictController extends Controller
{

    public function DistrictList()
    {
        try {
            $user_id = Auth::id();
            $DistrictData = District::latest()->get();;
            return response()->json(['status' => 'success', 'DistrictData' => $DistrictData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
    public function DistrictCreate(Request $request)
    {
        try {
            $user_id = Auth::id();
            // Create new District
            $District = District::create([
                'district_name' => $request->input('district_name'),
                'status' => $request->input('status'),
                'user_id' => $user_id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'District Created Successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }



    function DistrictByID(Request $request){
        try {
            $user_id = Auth::id();
            $request->validate(["id" => 'required|string']);

            $rows = District ::where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


public function DistrictUpdate(Request $request)
{
    try {
        $user_id = Auth::id();
        $DistrictData_Update = District::find($request->input('id'));

        if (!$DistrictData_Update) {
            return response()->json(['status' => 'fail', 'message' => 'District not found.']);
        }

        $DistrictData_Update->district_name = $request->input('district_name'); // Use parentheses for input
        $DistrictData_Update->status = $request->input('status');

        $DistrictData_Update->save();

        return response()->json(['status' => 'success', 'message' => 'District updated successfully']);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}



function DistrictDelete(Request $request)
{
    try {
        // Validation
        $request->validate(['id' => 'required|string|min:1']);

        $District_id = $request->input('id');
        $District_delete = District::find($District_id);

        if (!$District_delete) {
            return response()->json(['status' => 'fail', 'message' => 'District not found.']);
        }

        // Delete District
        $District_delete->delete();

        return response()->json(['status' => 'success', 'message' => 'District deleted successfully']);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}

}
