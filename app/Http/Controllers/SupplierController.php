<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Supplier;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{

    public function SupplierPayableDueList(Request $request)
    {
        try {
            // Get start and end dates from the request
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            // Query suppliers with the purchase_payable_amount and within date range
            $query = Supplier::query();

            if ($startDate && $endDate) {
                // Filter by date range if provided
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            // Only include suppliers with a purchase_payable_amount
            $query->where('purchase_payable_amount', '>', 0);

            // Fetch filtered data
            $SupplierData = $query->latest()->get();

            return response()->json(['status' => 'success', 'SupplierData' => $SupplierData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    public function SupplierList()
    {
        try {
            $hasReturnAdjCol = Schema::hasColumn('purchases', 'return_adjustment_amount');
            $hasPurchaseReturns = Schema::hasTable('purchase_returns');

            $SupplierData = Supplier::all()->map(function($s) use ($hasReturnAdjCol, $hasPurchaseReturns) {
                $totalReturns = $hasPurchaseReturns ? (float) DB::table('purchase_returns')->where('supplier_id', $s->id)->sum('amount') : 0;
                $totalAdjusted = $hasReturnAdjCol ? (float) DB::table('purchases')->where('supplier_id', $s->id)->sum('return_adjustment_amount') : 0;
                $availableCredit = max(0, $totalReturns - $totalAdjusted);

                $s->return_credit_balance = round($availableCredit, 2);
                return $s;
            });
            return response()->json(['status' => 'success', 'SupplierData' => $SupplierData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

// public function SupplierDueList()
// {
//     try {
//         $user_id = Auth::id();
//         // Fetch customers with purchase_payable_amount > 0
//         $SupplierData = Supplier::where('purchase_payable_amount', '>', 0)
//                                 ->orderBy('created_at', 'desc')
//                                 ->get();

//         return response()->json(['status' => 'success', 'SupplierData' => $SupplierData]);
//     } catch (Exception $e) {
//         return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
//     }
// }


// work it 1st 

// public function SupplierDueList()
// {
//     try {
//         $user_id = Auth::id();

//         // Get suppliers
//         $suppliers = Supplier::orderBy('created_at', 'desc')->get();

//         // Get total due amounts per supplier with join
//         $dueAmounts = DB::table('purchase_payment_details')
//             ->join('purchase_order_details', 'purchase_payment_details.purchase_order_details_id', '=', 'purchase_order_details.id')
//             ->join('purchases', 'purchase_order_details.purchase_id', '=', 'purchases.id')
//             ->select('purchases.supplier_id', DB::raw('SUM(purchase_payment_details.due_amount) as total_due_amount'))
//             ->groupBy('purchases.supplier_id')
//             ->pluck('total_due_amount', 'supplier_id');  // Pluck as [supplier_id => total_due_amount]

//         // Map suppliers with due amount
//         $SupplierData = $suppliers->map(function ($supplier) use ($dueAmounts) {
//             return [
//                 'id' => $supplier->id,
//                 'supplier_id' => $supplier->supplier_id,
//                 'img_url' => $supplier->img_url,
//                 'name' => $supplier->name,
//                 'company' => $supplier->company,
//                 'purchase_payable_amount' => $supplier->purchase_payable_amount,
//                 'status' => $supplier->status,
//                 'total_due_amount' => $dueAmounts[$supplier->id] ?? 0,
//             ];
//         });

//         return response()->json(['status' => 'success', 'SupplierData' => $SupplierData]);
//     } catch (Exception $e) {
//         return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
//     }
// }


// public function SupplierDueList()
// {
//     try {
//         $user_id = Auth::id();

//         // Get all suppliers (without any conditions)
//         $suppliers = Supplier::orderBy('created_at', 'desc')->get();

//         // Calculate total due_amount from PurchasePaymentDetails grouped by supplier_id via joins
//         $dueAmounts = DB::table('purchase_payment_details')
//             ->join('purchase_order_details', 'purchase_payment_details.purchase_order_details_id', '=', 'purchase_order_details.id')
//             ->join('purchases', 'purchase_order_details.purchase_id', '=', 'purchases.id')
//             ->select('purchases.supplier_id', DB::raw('SUM(purchase_payment_details.due_amount) as total_due_amount'))
//             ->groupBy('purchases.supplier_id')
//             ->pluck('total_due_amount', 'supplier_id');  // key: supplier_id, value: sum of due_amount

//         // Map suppliers to add the total_due_amount field
//         $SupplierData = $suppliers->map(function ($supplier) use ($dueAmounts) {
//             return [
//                 'id' => $supplier->id,
//                 'supplier_id' => $supplier->supplier_id,
//                 'img_url' => $supplier->img_url,
//                 'name' => $supplier->name,
//                 'company' => $supplier->company,
//                 'purchase_payable_amount' => $supplier->purchase_payable_amount,
//                 'status' => $supplier->status,
//                 'total_due_amount' => $dueAmounts[$supplier->id] ?? 0,
//             ];
//         });

//         return response()->json(['status' => 'success', 'SupplierData' => $SupplierData]);

//     } catch (Exception $e) {
//         return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
//     }
// }


public function SupplierDueList()
{
    try {
        $user_id = Auth::id();

        // ১. সব সাপ্লায়ার নিয়ে আসা
        $suppliers = Supplier::orderBy('created_at', 'desc')->get();

        // ২. পার্সেস টেবিল থেকে ডিউ ক্যালকুলেট করা
        $dueAmounts = DB::table('purchases')
            ->select('supplier_id', DB::raw('SUM(due_amount) as total_due_amount'))
            ->groupBy('supplier_id')
            ->pluck('total_due_amount', 'supplier_id');

        // ৩. ডাটা ম্যাপ করা এবং শেষে ফিল্টার করা
        $SupplierData = $suppliers->map(function ($supplier) use ($dueAmounts) {
            return [
                'id' => $supplier->id,
                'supplier_id' => $supplier->supplier_id,
                'img_url' => $supplier->img_url,
                'name' => $supplier->name,
                'company' => $supplier->company,
                'purchase_payable_amount' => $supplier->purchase_payable_amount ?? 0, // Previous Due
                'status' => $supplier->status,
                'total_due_amount' => $dueAmounts[$supplier->id] ?? 0, // Current Invoice Due
            ];
        })
        // === পরিবর্তনটি এখানে করা হয়েছে ===
        ->filter(function ($item) {
            $previousDue = (float) $item['purchase_payable_amount'];
            $currentDue  = (float) $item['total_due_amount'];
            
            // দুইটা মিলিয়ে যদি ০ টাকার বেশি পায়, তবেই দেখাবে
            return ($previousDue + $currentDue) > 0;
        })
        ->values(); 

        return response()->json(['status' => 'success', 'SupplierData' => $SupplierData]);

    } catch (\Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}




public function SupplierCreate(Request $request)
{
    try {
        $user_id = Auth::id();
        $img_url = null;

        // Check if an image file is provided
        if ($request->hasFile('img_url')) {
            $img = $request->file('img_url');
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$t}-{$file_name}";
            $img_url = "uploads/supplier-img/{$img_name}";

            // Upload File
            $img->move(public_path('uploads/supplier-img'), $img_name);
        }

        // Generate SupplierID
        $lastSupplier = Supplier::latest('id')->first(); // Get the last created supplier
        $nextId = $lastSupplier ? intval(substr($lastSupplier->supplier_id, 4)) + 1 : 10001;
        $supplierId = 'SUP-' . $nextId;

        // Creating the supplier entry
        $newSupplier = Supplier::create([
            'supplier_id' => $supplierId,
            'name' => $request->input('name'),
            'company' => $request->input('company') ?? '',
            'mobile' => $request->input('mobile'),
            'address' => $request->input('address') ?? '',
            'email' => $request->input('email') ?? '',
            'img_url' => $img_url,
            'purchase_payable_amount' => $request->input('purchase_payable_amount') ?: 0,
            'status' => $request->input('status') ?: 'Active',
            'user_id' => $user_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Supplier Created Successfully',
            'supplier' => $newSupplier
        ]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}


function SupplierByID(Request $request){
    try {
        $user_id = Auth::id();
        $request->validate(["id" => 'required|string']);

        $rows = Supplier ::where('id', $request->input('id'))->first();
        return response()->json(['status' => 'success', 'rows' => $rows]);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}


public function SupplierUpdate(Request $request)
{
    try {
        $user_id = Auth::id();
        // Find the supplier record to update
        $SupplierData_Update = Supplier::find($request->input('id'));

        // Update the supplier's fields
        $SupplierData_Update->name = $request->input('name');
        $SupplierData_Update->company = $request->input('company') ?? '';
        $SupplierData_Update->mobile = $request->input('mobile');
        $SupplierData_Update->address = $request->input('address') ?? '';
        $SupplierData_Update->email = $request->input('email') ?? '';
        $SupplierData_Update->purchase_payable_amount = $request->input('purchase_payable_amount') ?: 0;
        $SupplierData_Update->status = $request->input('status') ?: 'Active';

        // Handle the image file if it exists
        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$t}-{$file_name}";
            $img_url = "uploads/supplier-img/{$img_name}";

            // Move the file to the desired directory
            if ($img->move(public_path('uploads/supplier-img/'), $img_name)) {
                // Delete the old image if it exists
                if ($SupplierData_Update->img_url && file_exists(public_path($SupplierData_Update->img_url))) {
                    unlink(public_path($SupplierData_Update->img_url));
                }
                // Update the img_url field in the database
                $SupplierData_Update->img_url = $img_url;
            }
        }

        // Save the updated supplier data
        $SupplierData_Update->save();

        // Return success response
        return response()->json(['status' => 'success', 'message' => 'Supplier updated successfully']);
    } catch (Exception $e) {
        // Log the error for debugging purposes
        Log::error('Supplier Update Error: ' . $e->getMessage());

        // Return failure response
        return response()->json(['status' => 'fail', 'message' => 'An error occurred while updating the supplier.']);
    }
}


function SupplierDelete(Request $request)
{
    DB::beginTransaction();
    try {
        $request->validate([
            'id' => 'required|string|min:1'
        ]);

        $Supplier_ID = $request->input('id');
        $SupplierData_Delete = Supplier::find($Supplier_ID);

        if (!$SupplierData_Delete) {
            return response()->json(['status' => 'fail', 'message' => 'Supplier not found.']);
        }

        // 1. Delete supplier due collections
        if (Schema::hasTable('supplier_due_collections')) {
            DB::table('supplier_due_collections')->where('supplier_id', $Supplier_ID)->delete();
        }

        // 2. Fetch all purchases belonging to this supplier
        $purchaseIds = DB::table('purchases')->where('supplier_id', $Supplier_ID)->pluck('id')->toArray();

        if (!empty($purchaseIds)) {
            // Delete purchase order details
            if (Schema::hasTable('purchase_order_details')) {
                DB::table('purchase_order_details')->whereIn('purchase_id', $purchaseIds)->delete();
            }
            
            // Delete purchase payment details
            if (Schema::hasTable('purchase_payment_details')) {
                DB::table('purchase_payment_details')->whereIn('purchases_id', $purchaseIds)->delete();
            }

            // Delete purchases
            DB::table('purchases')->whereIn('id', $purchaseIds)->delete();
        }

        if ($SupplierData_Delete->img_url && file_exists(public_path($SupplierData_Delete->img_url))) {
            @unlink(public_path($SupplierData_Delete->img_url));
        }

        Supplier::where('id', $Supplier_ID)->delete();

        DB::commit();

        return response()->json(['status' => 'success', 'message' => 'Supplier Delete Successful']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}

    public function SupplierProfilePage($id)
    {
        return view('pages.back-end-page.supplier-profile-page', compact('id'));
    }

    public function SupplierProfileData($id)
    {
        try {
            $supplier = Supplier::where(function ($q) use ($id) {
                if (is_numeric($id)) {
                    $q->where('id', $id);
                }
                $q->orWhere('supplier_id', $id);
            })->first();

            if (!$supplier) {
                return response()->json(['status' => 'fail', 'message' => 'Supplier not found']);
            }

            $purchases = Purchase::with(['orderDetails.product', 'paymentDetails'])
                ->where('supplier_id', $supplier->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($purchase) {
                    $totalPaid = (float) $purchase->paymentDetails->sum('paid_amount');
                    $grandTotal = (float) $purchase->grand_subtotal;
                    $returnAdj = (float) ($purchase->return_adjustment_amount ?? 0);

                    $effectivePaid = $totalPaid + $returnAdj;
                    $dueAmount = max(0, $grandTotal - $effectivePaid);
                    $paymentStatus = ($effectivePaid >= $grandTotal && $grandTotal > 0) ? 'Fully Paid' : ($effectivePaid > 0 ? 'Partial Paid' : 'Unpaid');

                    $barcodes = $purchase->orderDetails->flatMap(function ($detail) {
                        if (!$detail->product || !$detail->product->product_code) return [];
                        $code = $detail->product->product_code;
                        $parsed = is_array($code) ? $code : (json_decode($code, true) ?? [$code]);
                        return is_array($parsed) ? $parsed : [$parsed];
                    })->filter()->unique()->values()->all();

                    return [
                        'id'                       => $purchase->id,
                        'purchase_id'              => $purchase->purchase_id,
                        'date'                     => $purchase->date ? \Carbon\Carbon::parse($purchase->date)->format('d-m-Y') : 'N/A',
                        'referance_no'             => $purchase->referance_no ?? 'No Reference',
                        'grand_subtotal'           => $grandTotal,
                        'return_adjustment_amount' => $returnAdj,
                        'paid_amount'              => $totalPaid,
                        'due_amount'               => $dueAmount,
                        'payment_method'           => $purchase->paymentDetails->first()?->payment_method ?? 'N/A',
                        'payment_status'           => $paymentStatus,
                        'barcodes'                 => $barcodes,
                    ];
                });

            // 1. Initial Purchase Payments (First PaymentDetail entry per purchase)
            $firstPaymentIds = DB::table('purchase_payment_details')
                ->join('purchases', 'purchase_payment_details.purchases_id', '=', 'purchases.id')
                ->where('purchases.supplier_id', $supplier->id)
                ->groupBy('purchase_payment_details.purchases_id')
                ->select(DB::raw('MIN(purchase_payment_details.id) as first_id'))
                ->pluck('first_id');

            $initialPurchasePayments = DB::table('purchase_payment_details')
                ->join('purchases', 'purchase_payment_details.purchases_id', '=', 'purchases.id')
                ->whereIn('purchase_payment_details.id', $firstPaymentIds)
                ->where('purchase_payment_details.paid_amount', '>', 0)
                ->select(
                    'purchase_payment_details.id',
                    'purchase_payment_details.paid_amount',
                    'purchase_payment_details.discount_amount',
                    'purchase_payment_details.payment_method',
                    'purchase_payment_details.payment_status',
                    'purchase_payment_details.transaction_id',
                    'purchase_payment_details.created_at',
                    'purchases.purchase_id'
                )
                ->get();

            // 2. Supplier Due Collections (supplier_due_collections)
            $dueCollections = DB::table('supplier_due_collections')
                ->where('supplier_id', $supplier->id)
                ->where('paid_amount', '>', 0)
                ->select(
                    'id',
                    'paid_amount',
                    'discount_amount',
                    'payment_method',
                    'transaction_id',
                    'payment_status',
                    'created_at',
                    DB::raw('"Due Collection" as purchase_id')
                )
                ->get();

            // 3. Purchase Returns
            $returns = DB::table('purchase_returns')
                ->leftJoin('products', 'purchase_returns.product_id', '=', 'products.id')
                ->leftJoin('purchases', 'purchase_returns.purchase_id', '=', 'purchases.id')
                ->where('purchase_returns.supplier_id', $supplier->id)
                ->select(
                    'purchase_returns.id',
                    'purchase_returns.amount',
                    'purchase_returns.due_amount',
                    'purchase_returns.quantity',
                    'purchase_returns.date',
                    'purchase_returns.created_at',
                    'products.product_name',
                    'purchases.id as db_purchase_id',
                    'purchases.purchase_id'
                )
                ->orderBy('purchase_returns.created_at', 'desc')
                ->get()
                ->map(function($r) {
                    $purNo = $r->purchase_id ? (str_starts_with($r->purchase_id, 'me-pur-') ? ('#PurID' . str_pad($r->db_purchase_id, 5, '0', STR_PAD_LEFT)) : $r->purchase_id) : ('#PurID' . str_pad($r->db_purchase_id ?? 0, 5, '0', STR_PAD_LEFT));
                    return [
                        'id'                   => $r->id,
                        'purchase_no'          => $purNo,
                        'product_name'         => $r->product_name ?? 'N/A',
                        'quantity'             => (int) ($r->quantity ?? 1),
                        'amount'               => (float) $r->amount,
                        'date'                 => $r->date ? \Carbon\Carbon::parse($r->date)->format('d-m-Y') : \Carbon\Carbon::parse($r->created_at)->format('d-m-Y'),
                        'created_at_formatted' => \Carbon\Carbon::parse($r->created_at)->format('d-m-Y h:i A')
                    ];
                });

            // Merge all transactions sorted by date
            $allTransactions = $initialPurchasePayments->concat($dueCollections)->sortByDesc('created_at')->values()->map(function ($trx) {
                $trx->created_at_formatted = \Carbon\Carbon::parse($trx->created_at)->format('d-m-Y h:i A');
                return $trx;
            });

            $totalPurchasesCount = $purchases->count();
            $totalPurchasesAmount = (float) $purchases->sum('grand_subtotal');
            $totalPurchaseDue = (float) $purchases->sum('due_amount');
            $supplierPreviousDue = (float) ($supplier->purchase_payable_amount ?? 0);
            $totalReturnsAmount = (float) $returns->sum('amount');
            $totalReturnsAdjusted = (float) $purchases->sum('return_adjustment_amount');
            $availableReturnCredit = max(0, $totalReturnsAmount - $totalReturnsAdjusted);

            $totalDueAmount = max(0, $supplierPreviousDue + $totalPurchaseDue - $availableReturnCredit);
            $totalPaidAmount = (float) $initialPurchasePayments->sum('paid_amount') + (float) $dueCollections->sum('paid_amount');

            return response()->json([
                'status'       => 'success',
                'supplier'     => $supplier,
                'summary'      => [
                    'total_purchases'        => $totalPurchasesCount,
                    'total_amount'           => $totalPurchasesAmount,
                    'total_paid'             => $totalPaidAmount,
                    'total_returns'          => $totalReturnsAmount,
                    'total_returns_adjusted' => $totalReturnsAdjusted,
                    'available_credit'       => $availableReturnCredit,
                    'total_due'              => $totalDueAmount,
                ],
                'purchases'    => $purchases,
                'returns'      => $returns,
                'transactions' => $allTransactions,
            ]);
        } catch (\Exception $e) {
            \Log::error('SupplierProfileData Error: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
