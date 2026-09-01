<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\InvestorInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvestorInfoController extends Controller
{
    public function InvestorInfoList()
    {
        try {
            // Fetch all categories
            $InvestorInfoData = InvestorInfo::all();
            return response()->json(['status' => 'success', 'InvestorInfoData' => $InvestorInfoData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function InvestorInfoCreate(Request $request)
    {
        try {
            $user_id = Auth::id();
            // Create the InvestorInfo
            InvestorInfo::create([
                'investor_id' => $this->generateInvestorID(),
                'name' => $request->input('name'),
                'mobile' => $request->input('mobile'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'status' => $request->input('status'),
                'user_id' => $user_id
            ]);
            return response()->json(['status' => 'success', 'message' => "Investor Info Created Successfully"]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    private function generateInvestorID()
{
    $currentYear = date('Y');
    $lastPurchase = InvestorInfo::orderBy('id', 'desc')->first();
    $lastIdNumber = $lastPurchase ? (int)substr($lastPurchase->investor_id, -4) : 0;
    $newIdNumber = $lastIdNumber + 1;
    return '#Invs-' . $currentYear . '-' . str_pad($newIdNumber, 4, '0', STR_PAD_LEFT);
}

    function InvestorInfoByID(Request $request){
        try {
            $user_id = Auth::id();
            $request->validate(["id" => 'required|string']);

            $rows = InvestorInfo ::where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    function InvestorInfoUpdate(Request $request)
    {
    try {
        $user_id = Auth::id();
        $InvestorInfoData_Update = InvestorInfo::find($request->input('id'));

        if (!$InvestorInfoData_Update) {
            return response()->json(['status' => 'fail', 'message' => 'Investor Info not found.']);
        }

        // Update InvestorInfo name and status
        $InvestorInfoData_Update->name = $request->input('name');
        $InvestorInfoData_Update->mobile = $request->input('mobile');
        $InvestorInfoData_Update->address = $request->input('address');
        $InvestorInfoData_Update->email = $request->input('email');
        $InvestorInfoData_Update->status = $request->input('status');
        $InvestorInfoData_Update->save();

        return response()->json(['status' => 'success', 'message' => 'Investor Info updated successfully']);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
    }

    function InvestorInfoDelete(Request $request)
    {
    try {
        // Validation
        $request->validate(['id' => 'required|string|min:1']);

        $InvestorInfo_id = $request->input('id');
        $InvestorInfo_delete = InvestorInfo::find($InvestorInfo_id);

        if (!$InvestorInfo_delete) {
            return response()->json(['status' => 'fail', 'message' => 'Investor Info not found.']);
        }


        // Delete InvestorInfo
        $InvestorInfo_delete->delete();

        return response()->json(['status' => 'success', 'message' => 'Investor Info deleted successfully']);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
    }
}
