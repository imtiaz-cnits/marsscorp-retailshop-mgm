<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Thana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThanaController extends Controller
{
    public function ThanaList()
    {
        try {
            // Fetch upazilas with their district name, sorted by the latest
            $ThanaData = Thana::with('district:id,district_name','upazila:id,upazila_name')->latest()->get();

            return response()->json(['status' => 'success', 'ThanaData' => $ThanaData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    public function ThanaCreate(Request $request)
    {
        try {
            $user_id = Auth::id();
            // Create the Thana
            Thana::create([
                'Thana_name' => $request->input('Thana_name'),
                'status' => $request->input('status'),
                'district_id' => $request->input('district_id'),
                'upazila_id' => $request->input('upazila_id'),
                'user_id' => $user_id
            ]);
            return response()->json(['status' => 'success', 'message' => "Thana Created Successfully"]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    function ThanaByID(Request $request){
        try {
            $user_id = Auth::id();
            $request->validate(["id" => 'required|string']);

            $rows = Thana ::where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    function ThanaUpdate(Request $request)
    {
    try {
        $user_id = Auth::id();
        $ThanaData_Update = Thana::find($request->input('id'));

        if (!$ThanaData_Update) {
            return response()->json(['status' => 'fail', 'message' => 'Thana not found.']);
        }

        // Validate inputs
        $validatedData = $request->validate([
            'Thana_name' => 'required|string|max:255',
            'district_id' => 'required|string|max:255',
            'upazila_id' => 'required|string|max:255',
            'status' => 'required|in:Active,InActive',
        ]);

        // Update Thana name and status
        $ThanaData_Update->Thana_name = $validatedData['Thana_name'];
        $ThanaData_Update->status = $validatedData['status'];
        $ThanaData_Update->district_id = $validatedData['district_id'];
        $ThanaData_Update->upazila_id = $validatedData['upazila_id'];

        $ThanaData_Update->save();

        return response()->json(['status' => 'success', 'message' => 'Thana updated successfully']);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
    }

    function ThanaDelete(Request $request)
    {
    try {
        // Validation
        $request->validate(['id' => 'required|string|min:1']);

        $Thana_id = $request->input('id');
        $Thana_delete = Thana::find($Thana_id);

        if (!$Thana_delete) {
            return response()->json(['status' => 'fail', 'message' => 'Thana not found.']);
        }


        // Delete Thana
        $Thana_delete->delete();

        return response()->json(['status' => 'success', 'message' => 'Thana deleted successfully']);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
    }
}
