<?php

namespace App\Http\Controllers\Battery;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatterySupplier;
use App\Models\Battery\BatteryPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BatterySupplierController extends Controller
{
    public function SupplierList()
    {
        try {
            $SupplierData = BatterySupplier::all()->map(function($s) {
                $totalReturns = (float) DB::table('battery_purchase_returns')->where('supplier_id', $s->id)->sum('amount');
                $totalAdjusted = (float) DB::table('battery_purchases')->where('supplier_id', $s->id)->sum('return_adjustment_amount');
                $availableCredit = max(0, $totalReturns - $totalAdjusted);

                $s->return_credit_balance = round($availableCredit, 2);
                return $s;
            });
            return response()->json(['status' => 'success', 'SupplierData' => $SupplierData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function SupplierDueList()
    {
        try {
            $suppliers = BatterySupplier::orderBy('created_at', 'desc')->get();

            $dueAmounts = DB::table('battery_purchases')
                ->select('supplier_id', DB::raw('SUM(due_amount) as total_due_amount'))
                ->groupBy('supplier_id')
                ->pluck('total_due_amount', 'supplier_id');

            $SupplierData = $suppliers->map(function ($supplier) use ($dueAmounts) {
                return [
                    'id' => $supplier->id,
                    'supplier_id' => $supplier->supplier_id,
                    'name' => $supplier->name,
                    'company' => $supplier->company,
                    'purchase_payable_amount' => $supplier->purchase_payable_amount ?? 0,
                    'status' => $supplier->status,
                    'total_due_amount' => $dueAmounts[$supplier->id] ?? 0,
                ];
            })
            ->filter(function ($item) {
                $previousDue = (float) $item['purchase_payable_amount'];
                $currentDue  = (float) $item['total_due_amount'];
                return ($previousDue + $currentDue) > 0;
            })
            ->values();

            return response()->json(['status' => 'success', 'SupplierData' => $SupplierData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function SupplierCreate(Request $request)
    {
        try {
            $user_id = Auth::id();

            $lastSupplier = BatterySupplier::latest('id')->first();
            $nextId = $lastSupplier ? intval(substr($lastSupplier->supplier_id, 8)) + 1 : 10001;
            $supplierId = 'BAT-SUP-' . $nextId;

            $newSupplier = BatterySupplier::create([
                'supplier_id' => $supplierId,
                'name' => $request->input('name'),
                'company' => $request->input('company'),
                'purchase_payable_amount' => $request->input('purchase_payable_amount') ?? 0,
                'mobile' => $request->input('mobile'),
                'address' => $request->input('address'),
                'user_id' => $user_id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Supplier Created Successfully',
                'supplier' => $newSupplier,
            ]);
        } catch (Exception $e) {
            Log::error('Battery Supplier Create Error: ' . $e->getMessage());
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function SupplierByID(Request $request)
    {
        try {
            $request->validate(["id" => 'required']);
            $rows = BatterySupplier::where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function SupplierUpdate(Request $request)
    {
        try {
            $user_id = Auth::id();
            $supplier = BatterySupplier::find($request->input('id'));

            if (!$supplier) {
                return response()->json(['status' => 'fail', 'message' => 'Supplier not found.']);
            }

            $supplier->name = $request->input('name');
            $supplier->company = $request->input('company');
            $supplier->purchase_payable_amount = $request->input('purchase_payable_amount') ?? $supplier->purchase_payable_amount;
            $supplier->mobile = $request->input('mobile') ?? $supplier->mobile;
            $supplier->address = $request->input('address') ?? $supplier->address;

            $supplier->save();

            return response()->json(['status' => 'success', 'message' => 'Supplier updated successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function SupplierDelete(Request $request)
    {
        try {
            $request->validate(['id' => 'required']);
            $supplier = BatterySupplier::find($request->input('id'));

            if (!$supplier) {
                return response()->json(['status' => 'fail', 'message' => 'Supplier not found.']);
            }

            $hasPurchases = DB::table('battery_purchases')->where('supplier_id', $supplier->id)->exists();
            if ($hasPurchases) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'এই সাপ্লাইয়ারের অধীনে পারচেজ রেকর্ড রয়েছে, তাই ডিলিট করা সম্ভব নয়।'
                ]);
            }

            $supplier->delete();

            return response()->json(['status' => 'success', 'message' => 'Supplier deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
