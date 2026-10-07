<?php

namespace App\Http\Controllers\Battery;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BatteryExpenseTypeController extends Controller
{
    public function ExpenseTypeList()
    {
        try {
            $hasSalary = BatteryExpenseType::where(function($query) {
                $query->where('type_name', 'LIKE', '%salary%')
                      ->orWhere('type_name', 'LIKE', '%sallery%')
                      ->orWhere('type_name', 'LIKE', '%বেতন%')
                      ->orWhere('type_name', 'LIKE', '%সেলারী%')
                      ->orWhere('type_name', 'LIKE', '%স্যালারি%')
                      ->orWhere('type_name', 'LIKE', '%স্টাফ%');
            })->exists();

            if (!$hasSalary) {
                $firstUser = \App\Models\User::first();
                BatteryExpenseType::create([
                    'type_name' => 'Salary',
                    'status' => 'Active',
                    'user_id' => Auth::id() ?: ($firstUser ? $firstUser->id : 1)
                ]);
            }

            $ExpenseTypeData = BatteryExpenseType::latest()->get();
            return response()->json(['status' => 'success', 'ExpenseTypeData' => $ExpenseTypeData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function ExpenseTypeCreate(Request $request)
    {
        try {
            $user_id = Auth::id();

            BatteryExpenseType::create([
                'type_name' => $request->input('type_name'),
                'status' => $request->input('status') ?? 'Active',
                'user_id' => $user_id
            ]);

            return response()->json(['status' => 'success', 'message' => "ExpenseType Created Successfully"]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function ExpenseTypeByID(Request $request)
    {
        try {
            $request->validate(["id" => 'required']);
            $rows = BatteryExpenseType::where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function ExpenseTypeUpdate(Request $request)
    {
        try {
            $expenseType = BatteryExpenseType::find($request->input('id'));

            if (!$expenseType) {
                return response()->json(['status' => 'fail', 'message' => 'ExpenseType not found.']);
            }

            $validatedData = $request->validate([
                'type_name' => 'required|string|max:255',
                'status' => 'required|in:Active,InActive',
            ]);

            $expenseType->type_name = $validatedData['type_name'];
            $expenseType->status = $validatedData['status'];
            $expenseType->save();

            return response()->json(['status' => 'success', 'message' => 'ExpenseType updated successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function ExpenseTypeDelete(Request $request)
    {
        try {
            $request->validate(['id' => 'required']);
            $expenseType = BatteryExpenseType::find($request->input('id'));

            if (!$expenseType) {
                return response()->json(['status' => 'fail', 'message' => 'ExpenseType not found.']);
            }

            $typeName = strtolower($expenseType->type_name);
            $salaryKeywords = ['salary', 'sallery', 'salery', 'salari', 'salry', 'বেতন', 'সেলারী', 'সেলারি', 'স্যালারি', 'স্যালারী'];
            foreach ($salaryKeywords as $kw) {
                if (str_contains($typeName, $kw)) {
                    return response()->json(['status' => 'fail', 'message' => 'সেলারী টাইপ ডিলিট করা যাবে না। এটি সিস্টেমের জন্য আবশ্যক।']);
                }
            }

            $expenseType->delete();

            return response()->json(['status' => 'success', 'message' => 'ExpenseType deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
