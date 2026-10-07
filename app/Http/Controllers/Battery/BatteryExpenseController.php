<?php

namespace App\Http\Controllers\Battery;

use Exception;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryExpense;
use App\Models\Battery\BatteryExpenseType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BatteryExpenseController extends Controller
{
    public function ExpenseList(Request $request)
    {
        try {
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');

            $query = BatteryExpense::with(['expenseType', 'staff:id,name,mobile,email,role']);

            if ($startDate && $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            }

            $ExpenseData = $query->latest('date')->latest('id')->get();

            $today = Carbon::today()->format('Y-m-d');
            $thisMonthStart = Carbon::now()->startOfMonth()->format('Y-m-d');
            $thisMonthEnd = Carbon::now()->endOfMonth()->format('Y-m-d');

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

            if ($request->has('items') && is_array($request->input('items'))) {
                $items = $request->input('items');
                $createdCount = 0;

                foreach ($items as $item) {
                    if (empty($item['expense_type_id']) || empty($item['expense_amount'])) continue;

                    $itemDate = !empty($item['date']) ? $item['date'] : date('Y-m-d');
                    $createdAt = Carbon::parse($itemDate)->setTime(now()->hour, now()->minute, now()->second);

                    BatteryExpense::create([
                        'expense_type_id' => $item['expense_type_id'],
                        'staff_id'        => !empty($item['staff_id']) ? $item['staff_id'] : null,
                        'expense_amount'  => $item['expense_amount'],
                        'expense_details' => $item['expense_details'] ?? '',
                        'date'            => $itemDate,
                        'user_id'         => $user_id,
                        'created_at'      => $createdAt
                    ]);
                    $createdCount++;
                }

                return response()->json(['status' => 'success', 'message' => "{$createdCount} টি ব্যাটারি এক্সপেন্স সফলভাবে সংরক্ষণ করা হয়েছে"]);
            }

            $expenseDate = $request->input('date') ?: date('Y-m-d');
            $createdAt = Carbon::parse($expenseDate)->setTime(now()->hour, now()->minute, now()->second);

            BatteryExpense::create([
                'expense_type_id' => $request->input('expense_type_id'),
                'staff_id'        => $request->input('staff_id') ?: null,
                'expense_amount'  => $request->input('expense_amount'),
                'expense_details' => $request->input('expense_details'),
                'date'            => $expenseDate,
                'user_id'         => $user_id,
                'created_at'      => $createdAt
            ]);

            return response()->json(['status' => 'success', 'message' => "Expense Created Successfully"]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function ExpenseByID(Request $request)
    {
        try {
            $request->validate(["id" => 'required']);
            $rows = BatteryExpense::with(['expenseType', 'staff'])->where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function ExpenseUpdate(Request $request)
    {
        try {
            $expense = BatteryExpense::find($request->input('id'));

            if (!$expense) {
                return response()->json(['status' => 'fail', 'message' => 'Expense not found.']);
            }

            $expenseDate = $request->input('date') ?: $expense->date;

            $expense->expense_type_id = $request->input('expense_type_id');
            $expense->staff_id = $request->input('staff_id') ?: null;
            $expense->expense_amount = $request->input('expense_amount');
            $expense->expense_details = $request->input('expense_details');
            $expense->date = $expenseDate;
            $expense->save();

            return response()->json(['status' => 'success', 'message' => 'Expense updated successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function ExpenseDelete(Request $request)
    {
        try {
            $request->validate(['id' => 'required']);
            $expense = BatteryExpense::find($request->input('id'));

            if (!$expense) {
                return response()->json(['status' => 'fail', 'message' => 'Expense not found.']);
            }

            $expense->delete();

            return response()->json(['status' => 'success', 'message' => 'Expense deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
