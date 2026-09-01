<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Invest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class InvestController extends Controller
{
    public function InvestList(Request $request)
    {
        try {
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');

            $query = Invest::query();

            if ($startDate && $endDate) {
                $startDate = Carbon::parse($startDate)->startOfDay();
                $endDate = Carbon::parse($endDate)->endOfDay();
                $query->whereBetween('date', [$startDate, $endDate]);
            }

            // Eager load the InvestorInfo relationship
            $InvestData = $query->with('investor_infos')->get();

            // Add 'investor_name' directly, defaulting to 'N/A' if null
            $InvestData->map(function ($invest) {
                $invest->investor_name = $invest->investor_infos->name ?? 'N/A';
                return $invest;
            });

            $subTotal = $InvestData->sum('invest_amount');

            return response()->json([
                'status' => 'success',
                'InvestData' => $InvestData,
                'subTotal' => $subTotal
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    public function InvestCreate(Request $request)
    {
        try {
            $user_id = Auth::id();


            // Create the category
            Invest::create([
                'investor_info_id' => $request->input('investor_info_id'),
                'invest_amount' => $request->input('invest_amount'),
                'invest_details' => $request->input('invest_details'),
                'date' => $request->input('date'),
                'user_id' => $user_id
            ]);
            return response()->json(['status' => 'success', 'message' => "Invest Created Successfully"]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }



    function InvestByID(Request $request){
        try {
            $user_id = Auth::id();
            $request->validate(["id" => 'required|string']);

            $rows = Invest ::where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    public function InvestUpdate(Request $request)
    {
        try {
            $user_id = Auth::id();

            // Find the supplier record to update
            $InvestData_Update = Invest::find($request->input('id'));

            // Update the supplier's fields
            $InvestData_Update->investor_info_id = $request->input('investor_info_id');
            $InvestData_Update->invest_amount = $request->input('invest_amount');
            $InvestData_Update->invest_details = $request->input('invest_details');
            $InvestData_Update->date = $request->input('date');
            // Save the updated Invest data
            $InvestData_Update->save();

            // Return success response
            return response()->json(['status' => 'success', 'message' => 'Invest updated successfully']);
        } catch (Exception $e) {
            // Log the error for debugging purposes
            Log::error('Invest Update Error: ' . $e->getMessage());

            // Return failure response
            return response()->json(['status' => 'fail', 'message' => 'An error occurred while updating the Invest.']);
        }
    }


function InvestDelete(Request $request)
{
    try {
        $request->validate([
            'id' => 'required|string|min:1'
        ]);

        $Invest_ID = $request->input('id');
        $InvestData_Delete = Invest::find($Invest_ID);

        if (!$InvestData_Delete) {
            return response()->json(['status' => 'fail', 'message' => 'Invest not found.']);
        }

        Invest::where('id', $Invest_ID)->delete();

        return response()->json(['status' => 'success', 'message' => 'Invest Delete Successful']);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}
}
