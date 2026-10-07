<?php

namespace App\Http\Controllers\Battery;

use Exception;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatterySupplier;
use App\Models\Battery\BatteryPurchase;
use App\Models\Battery\BatterySupplierDueCollection;
use App\Models\Battery\BatteryPurchasePaymentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BatterySupplierDueCollectionController extends Controller
{
    public function SupplierDueCollectionList()
    {
        try {
            $SupplierDueCollectionData = BatterySupplierDueCollection::with('supplier:id,name,supplier_id')->latest()->get();
            return response()->json(['status' => 'success', 'SupplierDueCollectionData' => $SupplierDueCollectionData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function SupplierDueCollectionByID(Request $request)
    {
        try {
            $request->validate(["id" => 'required']);

            $supplier = BatterySupplier::find($request->input('id'));

            if (!$supplier) {
                return response()->json(['status' => 'fail', 'message' => 'Supplier not found']);
            }

            $supplier_due = (float) ($supplier->purchase_payable_amount ?? 0);
            $purchase_due = (float) BatteryPurchase::where('supplier_id', $supplier->id)->sum('due_amount');
            $total_due = $supplier_due + $purchase_due;

            return response()->json([
                'status' => 'success',
                'supplier_due' => $supplier_due,
                'purchase_due' => $purchase_due,
                'total_due' => $total_due,
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function SupplierPaymentDetailsUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id = Auth::id() ?? 1;
            $supplierId = $request->input('supplier_id') ?? $request->input('id');
            $supplier = BatterySupplier::findOrFail($supplierId);

            $inputPaidAmount = floatval($request->paid_amount ?? 0);
            $inputDiscountAmount = floatval($request->discount_amount ?? 0);
            $paymentMethod = $request->payment_method ?? 'Cash';
            $rawDate = $request->input('due_collection_date') ?? $request->input('payment_date') ?? $request->input('collection_date');
            $dueCollectionDate = date('Y-m-d');
            if (!empty($rawDate)) {
                try {
                    $dueCollectionDate = Carbon::parse(str_replace('/', '-', trim($rawDate)))->format('Y-m-d');
                } catch (\Exception $e) {
                    $dueCollectionDate = date('Y-m-d');
                }
            }
            $transactionId = $request->transaction_id ?? $request->note ?? null;
            $collectionType = $request->collection_type ?? 'all';

            $totalAvailablePaid = $inputPaidAmount;
            $totalAvailableDiscount = $inputDiscountAmount;

            $supplierPreviousDue = floatval($supplier->purchase_payable_amount ?? 0);
            $purchasesPaidTotal = 0;
            $purchasesDiscountTotal = 0;

            // Step 1: Clear previous due (Previous Due)
            if (($collectionType === 'all' || $collectionType === 'previous') && ($totalAvailablePaid + $totalAvailableDiscount) > 0 && $supplierPreviousDue > 0) {
                $totalPowerToPay = $totalAvailablePaid + $totalAvailableDiscount;

                if ($totalPowerToPay >= $supplierPreviousDue) {
                    $usedFromDiscount = min($totalAvailableDiscount, $supplierPreviousDue);
                    $usedFromPaid = $supplierPreviousDue - $usedFromDiscount;

                    $totalAvailableDiscount -= $usedFromDiscount;
                    $totalAvailablePaid -= $usedFromPaid;

                    $supplier->update(['purchase_payable_amount' => 0]);

                    $remainingOrderDue = (float) BatteryPurchase::where('supplier_id', $supplier->id)
                        ->where('due_amount', '>', 0)
                        ->sum('due_amount');

                    BatterySupplierDueCollection::create([
                        'supplier_id' => $supplier->id,
                        'paid_amount' => $usedFromPaid,
                        'discount_amount' => $usedFromDiscount,
                        'due_amount' => $remainingOrderDue,
                        'payment_date' => $dueCollectionDate,
                        'payment_method' => $paymentMethod,
                        'transaction_id' => $transactionId,
                        'user_id' => $user_id,
                    ]);
                } else {
                    $usedAmount = $totalPowerToPay;
                    $paidRatio = $totalPowerToPay > 0 ? ($totalAvailablePaid / $totalPowerToPay) : 0;
                    $usedFromPaid = round($usedAmount * $paidRatio, 2);
                    $usedFromDiscount = $usedAmount - $usedFromPaid;

                    $supplier->update([
                        'purchase_payable_amount' => $supplierPreviousDue - $usedAmount
                    ]);

                    $totalAvailableDiscount = 0;
                    $totalAvailablePaid = 0;

                    $remainingPreviousDue = $supplierPreviousDue - $usedAmount;
                    $remainingOrderDue = (float) BatteryPurchase::where('supplier_id', $supplier->id)
                        ->where('due_amount', '>', 0)
                        ->sum('due_amount');
                    $totalRemainingDue = $remainingPreviousDue + $remainingOrderDue;

                    BatterySupplierDueCollection::create([
                        'supplier_id' => $supplier->id,
                        'paid_amount' => $usedFromPaid,
                        'discount_amount' => $usedFromDiscount,
                        'due_amount' => $totalRemainingDue,
                        'payment_date' => $dueCollectionDate,
                        'payment_method' => $paymentMethod,
                        'transaction_id' => $transactionId,
                        'user_id' => $user_id,
                    ]);
                }
            }

            // Step 2: Clear purchase invoice dues (FIFO)
            if (($collectionType === 'all' || $collectionType === 'purchase') && ($totalAvailablePaid + $totalAvailableDiscount) > 0) {
                $duePurchases = BatteryPurchase::where('supplier_id', $supplier->id)
                    ->where('due_amount', '>', 0)
                    ->orderBy('created_at', 'asc')
                    ->get();

                foreach ($duePurchases as $purchase) {
                    $availableToPay = $totalAvailablePaid + $totalAvailableDiscount;
                    if ($availableToPay <= 0) break;

                    $purchaseDue = floatval($purchase->due_amount);
                    $amountToPay = min($availableToPay, $purchaseDue);

                    $totalInput = $inputPaidAmount + $inputDiscountAmount;
                    $paidRatio = $totalInput > 0 ? ($inputPaidAmount / $totalInput) : 1;
                    $discountRatio = 1 - $paidRatio;

                    $usedFromDiscount = min($totalAvailableDiscount, round($amountToPay * $discountRatio, 2));
                    $usedFromPaid = $amountToPay - $usedFromDiscount;
                    $usedFromPaid = min($usedFromPaid, $totalAvailablePaid);

                    $totalUsed = $usedFromPaid + $usedFromDiscount;
                    if ($totalUsed > $amountToPay) {
                        $diff = $totalUsed - $amountToPay;
                        $usedFromPaid -= $diff;
                    }

                    $newDue = max(0, $purchase->due_amount - ($usedFromPaid + $usedFromDiscount));
                    $purchase->update([
                        'due_amount' => $newDue,
                        'paid_amount' => $purchase->paid_amount + $usedFromPaid,
                    ]);

                    if ($usedFromPaid > 0 || $usedFromDiscount > 0) {
                        $paymentStatus = $newDue == 0 ? 'Fully Paid' : 'Partial Paid';

                        BatteryPurchasePaymentDetail::create([
                            'purchases_id' => $purchase->id,
                            'paid_amount' => $usedFromPaid,
                            'discount_amount' => $usedFromDiscount,
                            'payment_status' => $paymentStatus,
                            'payment_method' => $paymentMethod,
                            'purchase_due_collection_date' => $dueCollectionDate,
                            'transaction_id' => $transactionId,
                            'user_id' => $user_id,
                        ]);
                    }

                    $totalAvailablePaid -= $usedFromPaid;
                    $totalAvailableDiscount -= $usedFromDiscount;

                    $purchasesPaidTotal += $usedFromPaid;
                    $purchasesDiscountTotal += $usedFromDiscount;
                }

                if ($purchasesPaidTotal > 0 || $purchasesDiscountTotal > 0) {
                    $remainingPreviousDue = floatval($supplier->purchase_payable_amount ?? 0);
                    $remainingPurchaseDue = (float) BatteryPurchase::where('supplier_id', $supplier->id)
                        ->where('due_amount', '>', 0)
                        ->sum('due_amount');

                    $totalRemainingDue = $remainingPreviousDue + $remainingPurchaseDue;

                    BatterySupplierDueCollection::create([
                        'supplier_id' => $supplier->id,
                        'paid_amount' => $purchasesPaidTotal,
                        'discount_amount' => $purchasesDiscountTotal,
                        'due_amount' => $totalRemainingDue,
                        'payment_date' => $dueCollectionDate,
                        'payment_method' => $paymentMethod,
                        'transaction_id' => $transactionId,
                        'user_id' => $user_id,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Supplier payment updated successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Battery Supplier Due Collection Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
