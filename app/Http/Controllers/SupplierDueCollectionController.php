<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\SupplierDueCollection;
use App\Models\PurchasePaymentDetails;

class SupplierDueCollectionController extends Controller
{

    public function SupplierDueCollectionList()
    {
        try {
            // Fetch all subcategories with their associated categories
            $SupplierDueCollectionData = SupplierDueCollection::with('supplier:id,name,supplier_id')->get();
            return response()->json(['status' => 'success', 'SupplierDueCollectionData' => $SupplierDueCollectionData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }



    //   public function SupplierDueCollectionByID(Request $request){
    //         try {
    //             $user_id = Auth::id();
    //             $request->validate(["id" => 'required|string']);

    //             $rows = Supplier::where('id', $request->input('id'))->first();
    //             return response()->json(['status' => 'success', 'rows' => $rows]);
    //         } catch (Exception $e) {
    //             return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    //         }
    //     }


// public function SupplierDueCollectionByID(Request $request)
// {
//     try {
//         $request->validate(["id" => 'required|string']);

//         $supplier = Supplier::find($request->input('id'));

//         if (!$supplier) {
//             return response()->json(['status' => 'fail', 'message' => 'Supplier not found']);
//         }

//         // Supplier previous due directly from supplier record
//         $supplier_due = $supplier->purchase_payable_amount ?? 0;

//         // Step 1: Get all purchase IDs for this supplier
//         $purchaseIds = Purchase::where('supplier_id', $supplier->id)->pluck('id');

//         // Step 2: Get all order detail IDs linked to those purchases
//         $orderDetailIds = \App\Models\PurchaseOrderDetails::whereIn('purchase_id', $purchaseIds)->pluck('id');

//         // Step 3: Sum the due_amounts from payment details
//         $purchase_due = PurchasePaymentDetails::whereIn('purchase_order_details_id', $orderDetailIds)->sum('due_amount');

//         // Total due = supplier + purchase dues
//         $total_due = $supplier_due + $purchase_due;

//         return response()->json([
//             'status' => 'success',
//             'supplier_due' => $supplier_due,
//             'purchase_due' => $purchase_due,
//             'total_due' => $total_due,
//         ]);

//     } catch (\Exception $e) {
//         return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
//     }
// }


public function SupplierDueCollectionByID(Request $request)
{
    try {
        $request->validate(["id" => 'required|string']);

        // Adjust here based on your frontend:
        // if frontend sends DB id:
        $supplier = Supplier::find($request->input('id'));

        // OR if frontend sends supplier_id (custom field), use:
        // $supplier = Supplier::where('supplier_id', $request->input('id'))->first();

        if (!$supplier) {
            return response()->json(['status' => 'fail', 'message' => 'Supplier not found']);
        }

        $supplier_due = $supplier->purchase_payable_amount ?? 0;

        // Sum purchase payable amount from purchases of this supplier
        $purchase_due = Purchase::where('supplier_id', $supplier->id)->sum('due_amount');

        $total_due = $supplier_due + $purchase_due;

        return response()->json([
            'status' => 'success',
            'supplier_due' => $supplier_due,
            'purchase_due' => $purchase_due,
            'total_due' => $total_due,
        ]);

    } catch (\Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}




// public function SupplierPaymentDetailsUpdate(Request $request)
//     {
//         DB::beginTransaction();
//         try {
//             $user_id = Auth::id();
//             $supplier = Supplier::findOrFail($request->input('id'));

//             $inputPaidAmount = $request->paid_amount ?? 0;
//             $inputDiscountAmount = $request->discount_amount ?? 0;
//             $paymentMethod = $request->payment_method ?? null;
//             $dueCollectionDate = $request->due_collection_date ?? now();
//             $transactionId = $request->transaction_id ?? null;

//             $totalAvailablePaid = $inputPaidAmount;
//             $totalAvailableDiscount = $inputDiscountAmount;

//             $supplierPreviousDue = $supplier->purchase_payable_amount ?? 0;
//             $originalPreviousDue = $supplierPreviousDue;

//             $purchasesPaidTotal = 0;
//             $purchasesDiscountTotal = 0;

//             // 1. --------- Step 1: Clear Previous Supplier Due ----------
//             if (($totalAvailablePaid + $totalAvailableDiscount) > 0 && $supplierPreviousDue > 0) {
//                 $totalPowerToPay = $totalAvailablePaid + $totalAvailableDiscount;

//                 if ($totalPowerToPay >= $supplierPreviousDue) {
//                     $usedFromDiscount = min($totalAvailableDiscount, $supplierPreviousDue);
//                     $usedFromPaid = max(0, $supplierPreviousDue - $usedFromDiscount);

//                     $totalAvailableDiscount -= $usedFromDiscount;
//                     $totalAvailablePaid -= $usedFromPaid;

//                     $supplier->update(['purchase_payable_amount' => 0]);

//                     $remainingOrderDue = Purchase::where('supplier_id', $supplier->id)
//                         ->where('due_amount', '>', 0)
//                         ->sum('due_amount');

//                     $totalRemainingDue = $remainingOrderDue;

//                     SupplierDueCollection::create([
//                         'supplier_id' => $supplier->id,
//                         'paid_amount' => $usedFromPaid,
//                         'discount_amount' => $usedFromDiscount,
//                         'due_amount' => $totalRemainingDue,
//                         'payment_status' => ($totalRemainingDue == 0) ? 'Fully Paid' : 'Partial Paid',
//                         'purchase_payable_amount' => $originalPreviousDue,
//                         'payment_method' => $paymentMethod,
//                         'due_collection_date' => $dueCollectionDate,
//                         'transaction_id' => $transactionId,
//                         'user_id' => $user_id,
//                     ]);
//                 } else {
//                     $usedAmount = $totalPowerToPay;
                    
//                     $paidRatio = $totalPowerToPay > 0 ? ($totalAvailablePaid / $totalPowerToPay) : 0;
//                     $usedFromPaid = round($usedAmount * $paidRatio, 2);
//                     $usedFromDiscount = $usedAmount - $usedFromPaid;

//                     $supplier->update([
//                         'purchase_payable_amount' => $supplierPreviousDue - $usedAmount
//                     ]);

//                     $totalAvailableDiscount = 0;
//                     $totalAvailablePaid = 0;
                    
//                     $remainingPreviousDue = $supplierPreviousDue - $usedAmount;
//                     $remainingOrderDue = Purchase::where('supplier_id', $supplier->id)
//                         ->where('due_amount', '>', 0)
//                         ->sum('due_amount');

//                     $totalRemainingDue = $remainingPreviousDue + $remainingOrderDue;

//                     SupplierDueCollection::create([
//                         'supplier_id' => $supplier->id,
//                         'paid_amount' => $usedFromPaid,
//                         'discount_amount' => $usedFromDiscount,
//                         'due_amount' => $totalRemainingDue,
//                         'payment_status' => 'Partial Paid',
//                         'purchase_payable_amount' => $originalPreviousDue,
//                         'payment_method' => $paymentMethod,
//                         'due_collection_date' => $dueCollectionDate,
//                         'transaction_id' => $transactionId,
//                         'user_id' => $user_id,
//                     ]);
//                 }
//             }


//             // 2. --------- Step 2: Clear Purchase Orders (FIFO) ----------
//             if (($totalAvailablePaid + $totalAvailableDiscount) > 0) {
//                 $duePurchases = Purchase::where('supplier_id', $supplier->id)
//                     ->where('due_amount', '>', 0)
//                     ->orderBy('created_at', 'asc')
//                     ->get();

//                 foreach ($duePurchases as $purchase) {
//                     $availableToPay = $totalAvailablePaid + $totalAvailableDiscount;
//                     if ($availableToPay <= 0) break;

//                     $purchaseDue = $purchase->due_amount;
//                     $amountToPay = min($availableToPay, $purchaseDue);

//                     $totalInput = $inputPaidAmount + $inputDiscountAmount;
//                     $paidRatio = $totalInput > 0 ? ($inputPaidAmount / $totalInput) : 1;
//                     $discountRatio = 1 - $paidRatio;
                    
//                     $usedFromDiscount = min($totalAvailableDiscount, round($amountToPay * $discountRatio, 2));
//                     $usedFromPaid = $amountToPay - $usedFromDiscount;
                    
//                     $usedFromPaid = min($usedFromPaid, $totalAvailablePaid);
                    
//                     $totalUsed = $usedFromPaid + $usedFromDiscount;
//                     if ($totalUsed > $amountToPay) {
//                         $diff = $totalUsed - $amountToPay;
//                         $usedFromPaid -= $diff;
//                     }

//                     // Purchase আপডেট
//                     $purchase->update([
//                         'due_amount' => max(0, $purchase->due_amount - ($usedFromPaid + $usedFromDiscount)),
//                         'paid_amount' => $purchase->paid_amount + $usedFromPaid,
//                     ]);
                    
//                     // 💡 ফিক্স: 'purchases_id' ব্যবহার করা হলো (মডেলের সাথে মিল রেখে)
//                     if ($usedFromPaid > 0 || $usedFromDiscount > 0) {
//                         $remainingDueAfterUpdate = max(0, $purchase->due_amount - ($usedFromPaid + $usedFromDiscount));
//                         $paymentStatus = ($remainingDueAfterUpdate == 0) ? 'Fully Paid' : 'Partial Paid';

//                         PurchasePaymentDetails::create([
//                             'purchases_id' => $purchase->id, // ✅ পরিবর্তন: purchases_id ব্যবহার করা হলো
//                             'paid_amount' => $usedFromPaid,
//                             'discount_amount' => $usedFromDiscount,
//                             'payment_status' => $paymentStatus, 
//                             'payment_method' => $paymentMethod,
//                             'purchase_due_collection_date' => $dueCollectionDate,
//                             'transaction_id' => $transactionId,
//                             'user_id' => $user_id,
//                             // 'purchase_order_details_id' ফিল্ডটি বাদ দেওয়া হলো কারণ এটি এখন ইনভয়েস লেভেলের পেমেন্ট
//                         ]);
//                     }
                    
//                     $totalAvailablePaid -= $usedFromPaid;
//                     $totalAvailableDiscount -= $usedFromDiscount;

//                     $purchasesPaidTotal += $usedFromPaid;
//                     $purchasesDiscountTotal += $usedFromDiscount;
//                 }

//                 // Insert summary SupplierDueCollection for purchases
//                 if ($purchasesPaidTotal > 0 || $purchasesDiscountTotal > 0) {
//                     $remainingPreviousDue = $supplier->purchase_payable_amount;
//                     $remainingPurchaseDue = Purchase::where('supplier_id', $supplier->id)
//                         ->where('due_amount', '>', 0)
//                         ->sum('due_amount');

//                     $totalRemainingDue = $remainingPreviousDue + $remainingPurchaseDue;

//                     $paymentStatus = ($totalRemainingDue == 0) ? 'Fully Paid' : 'Partial Paid';

//                     SupplierDueCollection::create([
//                         'supplier_id' => $supplier->id,
//                         'paid_amount' => $purchasesPaidTotal,
//                         'discount_amount' => $purchasesDiscountTotal,
//                         'due_amount' => $totalRemainingDue,
//                         'payment_status' => $paymentStatus,
//                         'purchase_payable_amount' => $originalPreviousDue,
//                         'payment_method' => $paymentMethod,
//                         'due_collection_date' => $dueCollectionDate,
//                         'transaction_id' => $transactionId,
//                         'user_id' => $user_id,
//                     ]);
//                 }
//             }

//             DB::commit();

//             return response()->json([
//                 'status' => 'success',
//                 'message' => 'Supplier and purchase payment updated successfully.'
//             ]);
//         } catch (\Exception $e) {
//             DB::rollBack();
//             // 🚨 ইরর ডিবাগ করার জন্য এই ব্লকটি আপডেট করা হলো
//             return response()->json([
//                 'status' => 'fail',
//                 'message' => $e->getMessage() . " (File: " . $e->getFile() . " Line: " . $e->getLine() . ")",
//             ], 500);
//         }
//     }



public function SupplierPaymentDetailsUpdate(Request $request)
{
    DB::beginTransaction();
    try {
        $user_id = Auth::id();
        $supplier = Supplier::findOrFail($request->input('id'));

        $inputPaidAmount     = $request->paid_amount ?? 0;
        $inputDiscountAmount = $request->discount_amount ?? 0;
        $paymentMethod       = $request->payment_method ?? null;
        $dueCollectionDate   = $request->due_collection_date ?? now();
        $transactionId       = $request->transaction_id ?? null;
        $collectionType      = $request->collection_type ?? 'all'; // 'all', 'previous', 'purchase'

        $totalAvailablePaid     = $inputPaidAmount;
        $totalAvailableDiscount = $inputDiscountAmount;

        // পেমেন্টের আগে সাপ্লাইয়ারের পুরানো ডিউ কত ছিল?
        $supplierPreviousDue = $supplier->purchase_payable_amount ?? 0;

        $purchasesPaidTotal     = 0;
        $purchasesDiscountTotal = 0;

        // Step 1: পুরানো ডিউ (Previous Due) ক্লিয়ার করা ('all' অথবা 'previous' মোডে)
        if (($collectionType === 'all' || $collectionType === 'previous') && ($totalAvailablePaid + $totalAvailableDiscount) > 0 && $supplierPreviousDue > 0) {
            $totalPowerToPay = $totalAvailablePaid + $totalAvailableDiscount;

            if ($totalPowerToPay >= $supplierPreviousDue) {
                // পুরো পুরানো ডিউ ক্লিয়ার হবে
                $usedFromDiscount = min($totalAvailableDiscount, $supplierPreviousDue);
                $usedFromPaid     = $supplierPreviousDue - $usedFromDiscount;

                $totalAvailableDiscount -= $usedFromDiscount;
                $totalAvailablePaid     -= $usedFromPaid;

                $supplier->update(['purchase_payable_amount' => 0]);

                $remainingOrderDue = Purchase::where('supplier_id', $supplier->id)
                    ->where('due_amount', '>', 0)
                    ->sum('due_amount');
                $totalRemainingDue = $remainingOrderDue;

                SupplierDueCollection::create([
                    'supplier_id'            => $supplier->id,
                    'paid_amount'            => $usedFromPaid,
                    'discount_amount'        => $usedFromDiscount,
                    'due_amount'             => $totalRemainingDue,
                    'payment_status'         => $totalRemainingDue == 0 ? 'Fully Paid' : 'Partial Paid',
                    'purchase_payable_amount'=> $usedFromPaid + $usedFromDiscount,
                    'payment_method'         => $paymentMethod,
                    'due_collection_date'    => $dueCollectionDate,
                    'transaction_id'         => $transactionId,
                    'user_id'                => $user_id,
                ]);
            } else {
                // আংশিক পুরানো ডিউ ক্লিয়ার হবে
                $usedAmount = $totalPowerToPay;

                $paidRatio        = $totalPowerToPay > 0 ? ($totalAvailablePaid / $totalPowerToPay) : 0;
                $usedFromPaid     = round($usedAmount * $paidRatio, 2);
                $usedFromDiscount = $usedAmount - $usedFromPaid;

                $supplier->update([
                    'purchase_payable_amount' => $supplierPreviousDue - $usedAmount
                ]);

                $totalAvailableDiscount = 0;
                $totalAvailablePaid     = 0;

                $remainingPreviousDue = $supplierPreviousDue - $usedAmount;
                $remainingOrderDue    = Purchase::where('supplier_id', $supplier->id)
                    ->where('due_amount', '>', 0)
                    ->sum('due_amount');
                $totalRemainingDue    = $remainingPreviousDue + $remainingOrderDue;

                SupplierDueCollection::create([
                    'supplier_id'            => $supplier->id,
                    'paid_amount'            => $usedFromPaid,
                    'discount_amount'        => $usedFromDiscount,
                    'due_amount'             => $totalRemainingDue,
                    'payment_status'         => 'Partial Paid',
                    'purchase_payable_amount'=> $usedAmount,
                    'payment_method'         => $paymentMethod,
                    'due_collection_date'    => $dueCollectionDate,
                    'transaction_id'         => $transactionId,
                    'user_id'                => $user_id,
                ]);
            }
        }

        // Step 2: নতুন পারচেজের ডিউ ক্লিয়ার (FIFO) ('all' অথবা 'purchase' মোডে)
        if (($collectionType === 'all' || $collectionType === 'purchase') && ($totalAvailablePaid + $totalAvailableDiscount) > 0) {
            $duePurchases = Purchase::where('supplier_id', $supplier->id)
                ->where('due_amount', '>', 0)
                ->orderBy('created_at', 'asc')
                ->get();

            foreach ($duePurchases as $purchase) {
                $availableToPay = $totalAvailablePaid + $totalAvailableDiscount;
                if ($availableToPay <= 0) break;

                $purchaseDue = $purchase->due_amount;
                $amountToPay = min($availableToPay, $purchaseDue);

                $totalInput    = $inputPaidAmount + $inputDiscountAmount;
                $paidRatio     = $totalInput > 0 ? ($inputPaidAmount / $totalInput) : 1;
                $discountRatio = 1 - $paidRatio;

                $usedFromDiscount = min($totalAvailableDiscount, round($amountToPay * $discountRatio, 2));
                $usedFromPaid     = $amountToPay - $usedFromDiscount;
                $usedFromPaid     = min($usedFromPaid, $totalAvailablePaid);

                $totalUsed = $usedFromPaid + $usedFromDiscount;
                if ($totalUsed > $amountToPay) {
                    $diff = $totalUsed - $amountToPay;
                    $usedFromPaid -= $diff;
                }

                $purchase->update([
                    'due_amount'  => max(0, $purchase->due_amount - ($usedFromPaid + $usedFromDiscount)),
                    'paid_amount' => $purchase->paid_amount + $usedFromPaid,
                ]);

                if ($usedFromPaid > 0 || $usedFromDiscount > 0) {
                    $remainingDueAfterUpdate = max(0, $purchase->fresh()->due_amount);
                    $paymentStatus = $remainingDueAfterUpdate == 0 ? 'Fully Paid' : 'Partial Paid';

                    PurchasePaymentDetails::create([
                        'purchases_id'                => $purchase->id,
                        'paid_amount'                 => $usedFromPaid,
                        'discount_amount'             => $usedFromDiscount,
                        'payment_status'              => $paymentStatus,
                        'payment_method'              => $paymentMethod,
                        'purchase_due_collection_date'=> $dueCollectionDate,
                        'transaction_id'              => $transactionId,
                        'user_id'                     => $user_id,
                    ]);
                }

                $totalAvailablePaid     -= $usedFromPaid;
                $totalAvailableDiscount -= $usedFromDiscount;

                $purchasesPaidTotal     += $usedFromPaid;
                $purchasesDiscountTotal += $usedFromDiscount;
            }

            // সামারি এন্ট্রি (শুধু নতুন পারচেজের পেমেন্ট)
            if ($purchasesPaidTotal > 0 || $purchasesDiscountTotal > 0) {
                $remainingPreviousDue = $supplier->purchase_payable_amount;
                $remainingPurchaseDue = Purchase::where('supplier_id', $supplier->id)
                    ->where('due_amount', '>', 0)
                    ->sum('due_amount');

                $totalRemainingDue = $remainingPreviousDue + $remainingPurchaseDue;

                SupplierDueCollection::create([
                    'supplier_id'            => $supplier->id,
                    'paid_amount'            => $purchasesPaidTotal,
                    'discount_amount'        => $purchasesDiscountTotal,
                    'due_amount'             => $totalRemainingDue,
                    'payment_status'         => $totalRemainingDue == 0 ? 'Fully Paid' : 'Partial Paid',
                    'purchase_payable_amount'=> 0, // নতুন পারচেজের পেমেন্ট → পুরানো ডিউ না
                    'payment_method'         => $paymentMethod,
                    'due_collection_date'    => $dueCollectionDate,
                    'transaction_id'         => $transactionId,
                    'user_id'                => $user_id,
                ]);
            }
        }

        DB::commit();

        return response()->json([
            'status'  => 'success',
            'message' => 'Supplier payment updated successfully.'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status'  => 'fail',
            'message' => 'Error: ' . $e->getMessage() . ' (Line: ' . $e->getLine() . ')'
        ], 500);
    }
}





}