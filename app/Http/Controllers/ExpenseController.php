<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function AllExpensesDataShow()
    {
        try {
            // Fetch first 30 Expenses regardless of category
            $Expenses = Expense::limit(30)->get();

            return response()->json([
                'ExpenseFrontData' => $Expenses,
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }



//     public function ExpenseList(Request $request)
// {
//     try {
//         // Get the start and end dates from the request
//         $startDate = $request->query('start_date');
//         $endDate = $request->query('end_date');

//         $query = Expense::query();

//         // Apply date filters if provided
//         if ($startDate && $endDate) {
//             // Ensure only date comparison without time
//             $query->whereDate('date', '>=', $startDate)
//                   ->whereDate('date', '<=', $endDate);
//         }

//         // Eager load the expense type relationship
//         $ExpenseData = $query->with('expenseType')->get();

//         // Add type_name directly, defaulting to 'N/A' if null
//         $ExpenseData->map(function ($expense) {
//             $expense->type_name = $expense->expenseType->type_name ?? 'N/A';
//             return $expense;
//         });

//         // Calculate subtotal
//         $subTotal = $ExpenseData->sum('expense_amount');

//         return response()->json([
//             'status' => 'success',
//             'ExpenseData' => $ExpenseData,
//             'subTotal' => $subTotal
//         ]);
//     } catch (\Exception $e) {
//         return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
//     }
// }




// public function ExpenseList(Request $request)
// {
//     try {
//         // Get the start and end dates from the request
//         $startDate = $request->query('start_date');
//         $endDate = $request->query('end_date');

//         $query = Expense::query();

//         // Apply date filters if provided
//         if ($startDate && $endDate) {
//             $startDate = Carbon::parse($startDate)->startOfDay();
//             $endDate = Carbon::parse($endDate)->endOfDay();
//             $query->whereBetween('date', [$startDate, $endDate]);
//         }

//         // Eager load the expense type relationship
//         $ExpenseData = $query->with('expenseType')->get();

//         // Add type_name directly, defaulting to 'N/A' if null
//         $ExpenseData->map(function ($expense) {
//             $expense->type_name = $expense->expenseType->type_name ?? 'N/A';
//             $expense->date = $expense->date->format('Y-m-d'); // Ensure date format
//             return $expense;
//         });

//         // Calculate subtotal
//         $subTotal = $ExpenseData->sum('expense_amount');

//         return response()->json([
//             'status' => 'success',
//             'ExpenseData' => $ExpenseData,  // Ensure correct response key
//             'subTotal' => $subTotal
//         ]);
//     } catch (\Exception $e) {
//         return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
//     }
// }







    public function ExpenseList(Request $request)
    {
        try {
            $user_id = Auth::id();

            // Fetch expenses with their related expense types and staff
            $ExpenseData = Expense::with(['expenseType', 'staff:id,name,mobile,email,role'])->latest()->get();

            // Today and This Month dates
            $today = Carbon::today()->format('Y-m-d');
            $thisMonthStart = Carbon::now()->startOfMonth()->format('Y-m-d');
            $thisMonthEnd = Carbon::now()->endOfMonth()->format('Y-m-d');

            // Calculate live summary statistics
            $subTotal = (float) $ExpenseData->sum('expense_amount');
            $todayExpense = (float) $ExpenseData->filter(function ($e) use ($today) {
                return Carbon::parse($e->date)->format('Y-m-d') === $today;
            })->sum('expense_amount');

            $thisMonthExpense = (float) $ExpenseData->filter(function ($e) use ($thisMonthStart, $thisMonthEnd) {
                $d = Carbon::parse($e->date)->format('Y-m-d');
                return $d >= $thisMonthStart && $d <= $thisMonthEnd;
            })->sum('expense_amount');

            $totalSalaryPaid = (float) $ExpenseData->filter(function ($e) {
                $typeName = strtolower($e->expenseType->type_name ?? '');
                return $e->staff_id !== null || 
                       str_contains($typeName, 'sal') || 
                       str_contains($typeName, 'বেতন') || 
                       str_contains($typeName, 'সেলারী') || 
                       str_contains($typeName, 'স্যালারি');
            })->sum('expense_amount');

            // Append type_name and staff_name for easier frontend rendering
            $ExpenseData->map(function ($expense) {
                $expense->type_name = $expense->expenseType->type_name ?? 'N/A';
                $expense->staff_name = $expense->staff->name ?? null;
                return $expense;
            });

            return response()->json([
                'status' => 'success',
                'ExpenseData' => $ExpenseData,
                'subTotal' => $subTotal,
                'todayExpense' => $todayExpense,
                'thisMonthExpense' => $thisMonthExpense,
                'totalSalaryPaid' => $totalSalaryPaid,
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function ExpenseCreate(Request $request)
    {
        try {
            $user_id = Auth::id();

            // Check if batch payload (items array) sent
            if ($request->has('items') && is_array($request->input('items'))) {
                $items = $request->input('items');
                $createdCount = 0;

                foreach ($items as $item) {
                    if (empty($item['expense_type_id']) || empty($item['expense_amount'])) continue;

                    Expense::create([
                        'expense_type_id' => $item['expense_type_id'],
                        'staff_id'        => !empty($item['staff_id']) ? $item['staff_id'] : null,
                        'expense_amount'  => $item['expense_amount'],
                        'expense_details' => $item['expense_details'] ?? '',
                        'date'            => !empty($item['date']) ? $item['date'] : date('Y-m-d'),
                        'user_id'         => $user_id
                    ]);
                    $createdCount++;
                }

                return response()->json(['status' => 'success', 'message' => "{$createdCount} টি এক্সপেন্স সফলভাবে সংরক্ষণ করা হয়েছে"]);
            }

            // Single Expense creation fallback
            $expenseDate = $request->input('date') ?: date('Y-m-d');

            Expense::create([
                'expense_type_id' => $request->input('expense_type_id'),
                'staff_id'        => $request->input('staff_id') ?: null,
                'expense_amount'  => $request->input('expense_amount'),
                'expense_details' => $request->input('expense_details'),
                'date'            => $expenseDate,
                'user_id'         => $user_id
            ]);

            return response()->json(['status' => 'success', 'message' => "Expense Created Successfully"]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function StaffList()
    {
        try {
            $staffs = \App\Models\User::select('id', 'name', 'mobile', 'email', 'role')->get();
            return response()->json(['status' => 'success', 'StaffData' => $staffs]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function StaffSalaryHistory(Request $request)
    {
        try {
            $staffId = $request->query('id') ?? $request->input('id');
            $staff = \App\Models\User::findOrFail($staffId);

            $salaryExpenses = Expense::with('expenseType')
                ->where('staff_id', $staffId)
                ->latest()
                ->get();

            $totalSalaryPaid = (float) $salaryExpenses->sum('expense_amount');

            return response()->json([
                'status' => 'success',
                'staff'  => $staff,
                'history' => $salaryExpenses,
                'totalSalaryPaid' => $totalSalaryPaid
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }



    function ExpenseByID(Request $request){
        try {
            $user_id = Auth::id();
            $request->validate(["id" => 'required|string']);

            $rows = Expense ::where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    public function ExpenseUpdate(Request $request)
    {
        try {
            $user_id = Auth::id();

            // Find the supplier record to update
            $ExpenseData_Update = Expense::find($request->input('id'));

            // Update the supplier's fields
            $ExpenseData_Update->expense_type_id = $request->input('expense_type_id');
            if ($request->has('staff_id')) {
                $ExpenseData_Update->staff_id = $request->input('staff_id') ?: null;
            }
            $ExpenseData_Update->expense_amount = $request->input('expense_amount');
            $ExpenseData_Update->expense_details = $request->input('expense_details');
            $ExpenseData_Update->date = $request->input('date');
            // Save the updated Expense data
            $ExpenseData_Update->save();

            // Return success response
            return response()->json(['status' => 'success', 'message' => 'Expense updated successfully']);
        } catch (Exception $e) {
            // Log the error for debugging purposes
            Log::error('Expense Update Error: ' . $e->getMessage());

            // Return failure response
            return response()->json(['status' => 'fail', 'message' => 'An error occurred while updating the Expense.']);
        }
    }


function ExpenseDelete(Request $request)
{
    try {
        $request->validate([
            'id' => 'required|string|min:1'
        ]);

        $Expense_ID = $request->input('id');
        $ExpenseData_Delete = Expense::find($Expense_ID);

        if (!$ExpenseData_Delete) {
            return response()->json(['status' => 'fail', 'message' => 'Expense not found.']);
        }

        Expense::where('id', $Expense_ID)->delete();

        return response()->json(['status' => 'success', 'message' => 'Expense Delete Successful']);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}
}
