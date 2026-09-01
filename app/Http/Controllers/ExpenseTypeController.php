<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseTypeController extends Controller
{
    public function ExpenseTypeList()
    {
        try {
            // Guarantee that Sallery/Salary type exists in database at all times
            $hasSalary = ExpenseType::where(function($query) {
                $query->where('type_name', 'LIKE', '%salary%')
                      ->orWhere('type_name', 'LIKE', '%sallery%')
                      ->orWhere('type_name', 'LIKE', '%বেতন%')
                      ->orWhere('type_name', 'LIKE', '%সেলারী%')
                      ->orWhere('type_name', 'LIKE', '%স্যালারি%')
                      ->orWhere('type_name', 'LIKE', '%স্টাফ%');
            })->exists();

            if (!$hasSalary) {
                $firstUser = \App\Models\User::first();
                ExpenseType::create([
                    'type_name' => 'Sallery',
                    'status' => 'Active',
                    'user_id' => Auth::id() ?: ($firstUser ? $firstUser->id : 1)
                ]);
            }

            $ExpenseTypeData = ExpenseType::latest()->get();
            return response()->json(['status' => 'success', 'ExpenseTypeData' => $ExpenseTypeData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function ExpenseTypeCreate(Request $request)
    {
        try {
            $user_id = Auth::id();
            // Create the ExpenseType
            ExpenseType::create([
                'type_name' => $request->input('type_name'),
                'status' => $request->input('status'),
                'user_id' => $user_id
            ]);
            return response()->json(['status' => 'success', 'message' => "ExpenseType Created Successfully"]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    function ExpenseTypeByID(Request $request){
        try {
            $user_id = Auth::id();
            $request->validate(["id" => 'required|string']);

            $rows = ExpenseType::where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    function ExpenseTypeUpdate(Request $request)
    {
        try {
            $user_id = Auth::id();
            $ExpenseTypeData_Update = ExpenseType::find($request->input('id'));

            if (!$ExpenseTypeData_Update) {
                return response()->json(['status' => 'fail', 'message' => 'ExpenseType not found.']);
            }

            // Validate inputs
            $validatedData = $request->validate([
                'type_name' => 'required|string|max:255',
                'status' => 'required|in:Active,InActive',
            ]);

            // Update ExpenseType name and status
            $ExpenseTypeData_Update->type_name = $validatedData['type_name'];
            $ExpenseTypeData_Update->status = $validatedData['status'];

            $ExpenseTypeData_Update->save();

            return response()->json(['status' => 'success', 'message' => 'ExpenseType updated successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    function ExpenseTypeDelete(Request $request)
    {
        try {
            // Validation
            $request->validate(['id' => 'required|string|min:1']);

            $ExpenseType_id = $request->input('id');
            $ExpenseType_delete = ExpenseType::find($ExpenseType_id);

            if (!$ExpenseType_delete) {
                return response()->json(['status' => 'fail', 'message' => 'ExpenseType not found.']);
            }

            // Prevent deleting Salary expense type
            $typeName = strtolower($ExpenseType_delete->type_name);
            $salaryKeywords = ['salary', 'sallery', 'salery', 'salari', 'salry', 'বেতন', 'সেলারী', 'সেলারি', 'স্যালারি', 'স্যালারী'];
            foreach ($salaryKeywords as $kw) {
                if (str_contains($typeName, $kw)) {
                    return response()->json(['status' => 'fail', 'message' => 'সেলারী টাইপ ডিলিট করা যাবে না। এটি সিস্টেমের জন্য আবশ্যক।']);
                }
            }

            // Delete ExpenseType
            $ExpenseType_delete->delete();

            return response()->json(['status' => 'success', 'message' => 'ExpenseType deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
