<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Upazilas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpazilasController extends Controller
{

    public function UpazilaList()
    {
        try {
            // Fetch upazilas with their district name, sorted by the latest
            $UpazilasData = Upazilas::with('district:id,district_name')->latest()->get();

            return response()->json(['status' => 'success', 'UpazilasData' => $UpazilasData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    public function UpazilaCreate(Request $request)
    {
        try {
            $user_id = Auth::id();
            // Create the Upazilas
            Upazilas::create([
                'upazila_name' => $request->input('upazila_name'),
                'district_id' => $request->input('district_id'),
                'status' => $request->input('status'),
                'user_id' => $user_id
            ]);
            return response()->json(['status' => 'success', 'message' => "Upazilas Created Successfully"]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    function UpazilaByID(Request $request){
        try {
            $user_id = Auth::id();
            $request->validate(["id" => 'required|string']);

            $rows = Upazilas ::where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    function UpazilaUpdate(Request $request)
    {
    try {
        $user_id = Auth::id();
        $UpazilasData_Update = Upazilas::find($request->input('id'));

        if (!$UpazilasData_Update) {
            return response()->json(['status' => 'fail', 'message' => 'Upazilas not found.']);
        }

        // Validate inputs
        $validatedData = $request->validate([
            'upazila_name' => 'required|string|max:255',
            'district_id' => 'required|string|max:255',
            'status' => 'required|in:Active,InActive',
        ]);

        // Update Upazilas name and status
        $UpazilasData_Update->upazila_name = $validatedData['upazila_name'];
        $UpazilasData_Update->district_id = $validatedData['district_id'];
        $UpazilasData_Update->status = $validatedData['status'];

        $UpazilasData_Update->save();

        return response()->json(['status' => 'success', 'message' => 'Upazilas updated successfully']);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
    }

    function UpazilaDelete(Request $request)
    {
    try {
        // Validation
        $request->validate(['id' => 'required|string|min:1']);

        $Upazilas_id = $request->input('id');
        $Upazilas_delete = Upazilas::find($Upazilas_id);

        if (!$Upazilas_delete) {
            return response()->json(['status' => 'fail', 'message' => 'Upazilas not found.']);
        }


        // Delete Upazilas
        $Upazilas_delete->delete();

        return response()->json(['status' => 'success', 'message' => 'Upazilas deleted successfully']);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
    }
}
