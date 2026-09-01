<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function LocationList()
    {
        try {
            $user_id = Auth::id();
            $LocationData = Location::latest()->get();
            return response()->json(['status' => 'success', 'LocationData' => $LocationData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
    public function LocationCreate(Request $request)
    {
        try {
            $user_id = Auth::id();
            // Create new location
            $location = Location::create([
                'name' => $request->input('name'),
                'status' => $request->input('status'),
                'user_id' => $user_id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Location Created Successfully',
                'newLocationId' => $location->id,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }



    function LocationById(Request $request){
        try {
            $user_id = Auth::id();
            $request->validate(["id" => 'required|string']);

            $rows = Location ::where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


public function LocationUpdate(Request $request)
{
    try {
        $user_id = Auth::id();
        $LocationData_Update = Location::find($request->input('id'));

        if (!$LocationData_Update) {
            return response()->json(['status' => 'fail', 'message' => 'Location not found.']);
        }

        $LocationData_Update->name = $request->input('name'); // Use parentheses for input
        $LocationData_Update->status = $request->input('status');

        $LocationData_Update->save();

        return response()->json(['status' => 'success', 'message' => 'Location updated successfully']);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}



function LocationDelete(Request $request)
{
    try {
        // Validation
        $request->validate(['id' => 'required|string|min:1']);

        $location_id = $request->input('id');
        $location_delete = Location::find($location_id);

        if (!$location_delete) {
            return response()->json(['status' => 'fail', 'message' => 'Location not found.']);
        }

        // Delete location
        $location_delete->delete();

        return response()->json(['status' => 'success', 'message' => 'Location deleted successfully']);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}

}
