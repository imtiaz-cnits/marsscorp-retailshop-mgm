<?php

namespace App\Http\Controllers\Battery;

use Exception;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryProduct;
use App\Models\Battery\BatteryPurchase;
use App\Models\Battery\BatteryPurchaseOrderDetail;
use App\Models\Battery\BatteryPurchasePaymentDetail;
use App\Models\Battery\BatterySupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BatteryPurchaseController extends Controller
{
    public function PurchasesList()
    {
        try {
            $purchases = BatteryPurchase::with(['supplier', 'paymentDetails', 'orderDetails.product'])
                ->orderBy('created_at', 'desc')
                ->get();

            $formatted = $purchases->map(function ($purchase) {
                $totalPaid = (float) ($purchase->paymentDetails ? $purchase->paymentDetails->sum('paid_amount') : 0);
                $grandTotal = (float) ($purchase->grand_subtotal ?? 0);
                $deliveryCharge = (float) ($purchase->delivery_charge ?? 0);
                $discountAmount = (float) ($purchase->discount_amount ?? 0);
                $returnAdj = (float) ($purchase->return_adjustment_amount ?? 0);

                $effectiveGrandTotal = max(0, ($grandTotal - $discountAmount) + $deliveryCharge);
                $effectivePaid = $totalPaid + $returnAdj;
                $dueAmount = max(0, $effectiveGrandTotal - $effectivePaid);

                $paymentMethod = $purchase->paymentDetails?->sortByDesc('created_at')->first()?->payment_method ?? 'N/A';

                $paymentStatus = 'Unpaid';
                if ($effectivePaid >= $effectiveGrandTotal && $effectiveGrandTotal > 0) {
                    $paymentStatus = 'Fully Paid';
                } elseif ($effectivePaid > 0) {
                    $paymentStatus = 'Partial Paid';
                }

                $barcodes = [];
                if ($purchase->orderDetails) {
                    $barcodes = $purchase->orderDetails->flatMap(function ($detail) {
                        if (!$detail->product || !$detail->product->product_code) return [];
                        $code = $detail->product->product_code;
                        $parsed = is_array($code) ? $code : (json_decode($code, true) ?? [$code]);
                        return is_array($parsed) ? $parsed : [$parsed];
                    })->filter()->unique()->values()->all();
                }

                $totalReturnAmount = 0;
                try {
                    $totalReturnAmount = (float) DB::table('battery_purchase_returns')
                        ->where('purchase_id', $purchase->id)
                        ->sum('amount');
                } catch (\Exception $ex) {
                    $totalReturnAmount = 0;
                }

                $purIdStr = $purchase->purchase_id;
                if (!$purIdStr || str_starts_with($purIdStr, 'me-pur-')) {
                    $purIdStr = '#PurID' . str_pad($purchase->id, 5, '0', STR_PAD_LEFT);
                }

                return [
                    'id'                => $purchase->id,
                    'purchase_id'       => $purIdStr,
                    'date'              => $purchase->date ? Carbon::parse($purchase->date)->format('d-m-Y') : 'N/A',
                    'raw_date'          => $purchase->date ? Carbon::parse($purchase->date)->format('Y-m-d') : '',
                    'referance_no'      => $purchase->referance_no ?? 'No Reference',
                    'supplier_id'       => $purchase->supplier?->supplier_id ?? 'N/A',
                    'supplier_db_id'    => $purchase->supplier_id,
                    'supplier'          => $purchase->supplier?->name ?? 'N/A',
                    'grand_subtotal'    => $grandTotal,
                    'delivery_charge'   => $deliveryCharge,
                    'discount_amount'   => $discountAmount,
                    'paid_amount'       => $totalPaid,
                    'due_amount'        => $dueAmount,
                    'payment_method'    => $paymentMethod,
                    'payment_status'    => $paymentStatus,
                    'return_amount'     => (float) $totalReturnAmount,
                    'attach_document'   => $purchase->attach_document,
                    'barcodes'          => $barcodes,
                ];
            });

            return response()->json([
                'status' => 'success',
                'PurchasessData' => $formatted
            ]);
        } catch (\Exception $e) {
            Log::error('Battery Purchase List Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'fail',
                'PurchasessData' => [],
                'message' => $e->getMessage()
            ]);
        }
    }

    public function PurchasesCreate(Request $request)
    {
        try {
            $user_id = Auth::id();
            DB::beginTransaction();

            $img_url = null;
            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $img_name = "{$user_id}-" . time() . "-" . $img->getClientOriginalName();
                $img_url = "uploads/battery-purchases-img/{$img_name}";
                $destination = public_path('uploads/battery-purchases-img');
                if (!file_exists($destination)) {
                    @mkdir($destination, 0777, true);
                }
                $img->move($destination, $img_name);
            }

            $formattedDate = now()->format('Y-m-d');
            if ($request->filled('date')) {
                try {
                    $formattedDate = Carbon::parse($request->date)->format('Y-m-d');
                } catch (\Exception $e) {
                    $formattedDate = now()->format('Y-m-d');
                }
            }

            $formattedDueDate = $formattedDate;
            if ($request->filled('purchase_due_collection_date')) {
                try {
                    $formattedDueDate = Carbon::parse($request->purchase_due_collection_date)->format('Y-m-d');
                } catch (\Exception $e) {
                    $formattedDueDate = $formattedDate;
                }
            }

            $supplier_id = null;
            if ($request->filled('supplier_id') && $request->supplier_id !== 'none') {
                $supplier_id = $request->supplier_id;
            }

            $lastPurchase = BatteryPurchase::latest('id')->first();
            $nextPurchaseNumber = $lastPurchase ? ($lastPurchase->id + 1) : 1;
            $purchaseIdString = '#PurID' . str_pad($nextPurchaseNumber, 5, '0', STR_PAD_LEFT);

            $purchase = BatteryPurchase::create([
                'purchase_id' => $purchaseIdString,
                'supplier_id' => $supplier_id,
                'date' => $formattedDate,
                'referance_no' => $request->referance_no,
                'grand_subtotal' => $request->grand_subtotal ?? $request->total_amount ?? $request->sub_total ?? 0,
                'paid_amount' => $request->paid_amount ?? 0,
                'due_amount' => $request->due_amount ?? 0,
                'delivery_charge' => floatval($request->delivery_charge ?? 0),
                'discount_amount' => floatval($request->discount_amount ?? 0),
                'return_adjustment_amount' => floatval($request->return_adjustment_amount ?? 0),
                'attach_document' => $img_url,
                'user_id' => $user_id,
            ]);

            $products = is_array($request->products) ? $request->products : json_decode($request->products, true);
            if (is_array($products)) {
                foreach ($products as $product) {
                    if (isset($product['product_id'], $product['quantity'])) {
                        BatteryPurchaseOrderDetail::create([
                            'purchase_id' => $purchase->id,
                            'product_id' => $product['product_id'],
                            'quantity' => $product['quantity'],
                            'cost_price' => $product['cost_price'],
                            'subtotal' => $product['subtotal'],
                            'user_id' => $user_id,
                        ]);

                        $productModel = BatteryProduct::find($product['product_id']);
                        if ($productModel) {
                            $existingCostPrice = (float) $productModel->cost_price;
                            $existingQuantity = (int) $productModel->quantity;
                            $newCostPrice = (float) $product['cost_price'];
                            $newQuantity = (int) $product['quantity'];

                            $combinedQuantity = $existingQuantity + $newQuantity;

                            if ($combinedQuantity > 0) {
                                $existingTotal = $existingCostPrice * max(0, $existingQuantity);
                                $newTotal = $newCostPrice * $newQuantity;
                                $updatedCostPrice = ($existingTotal + $newTotal) / $combinedQuantity;
                                $productModel->cost_price = round($updatedCostPrice, 2);
                            }

                            $productModel->quantity = $combinedQuantity;

                            if (!empty($product['product_code'])) {
                                $newCodes = $product['product_code'];
                                if (!is_array($newCodes)) {
                                    $newCodes = json_decode($newCodes, true) ?? [];
                                }
                                if (is_array($newCodes) && count($newCodes) > 0) {
                                    $existingCodes = [];
                                    if ($productModel->product_code) {
                                        $existingCodes = is_array($productModel->product_code)
                                            ? $productModel->product_code
                                            : (json_decode($productModel->product_code, true) ?? [$productModel->product_code]);
                                    }
                                    $mergedCodes = array_values(array_unique(array_merge($existingCodes, $newCodes)));
                                    $productModel->product_code = json_encode($mergedCodes);
                                }
                            }

                            $productModel->save();
                        }
                    }
                }
            }

            if (floatval($request->paid_amount) > 0) {
                BatteryPurchasePaymentDetail::create([
                    'purchases_id' => $purchase->id,
                    'paid_amount' => $request->paid_amount,
                    'discount_amount' => $request->discount_amount ?? 0,
                    'payment_method' => $request->payment_method ?? 'Cash',
                    'purchase_due_collection_date' => $formattedDueDate,
                    'payment_status' => (floatval($request->due_amount) <= 0) ? 'Fully Paid' : 'Partial Paid',
                    'transaction_id' => $request->transaction_id ?? null,
                    'user_id' => $user_id,
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Purchase created successfully',
                'purchase_id' => $purchase->id,
                'data' => $purchase,
                'id' => $purchase->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Battery Purchase Create Error: ' . $e->getMessage());
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }

    public function PurchasesByID(Request $request)
    {
        try {
            $request->validate(['id' => 'required']);
            $purchase = BatteryPurchase::with(['supplier', 'orderDetails.product', 'paymentDetails'])
                ->where('id', $request->input('id'))
                ->first();

            if (!$purchase) {
                return response()->json(['status' => 'fail', 'message' => 'Purchase not found']);
            }

            return response()->json(['status' => 'success', 'rows' => $purchase]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function PurchasesUpdate(Request $request)
    {
        try {
            $user_id = Auth::id();
            $purchase = BatteryPurchase::findOrFail($request->input('id'));

            $purchase->referance_no = $request->input('referance_no') ?? $purchase->referance_no;
            if ($request->filled('date')) {
                $purchase->date = Carbon::parse($request->input('date'))->format('Y-m-d');
            }
            if ($request->filled('supplier_id') && $request->input('supplier_id') !== 'none') {
                $purchase->supplier_id = $request->input('supplier_id');
            }
            $purchase->save();

            return response()->json(['status' => 'success', 'message' => 'Purchase updated successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function PurchasesDelete(Request $request)
    {
        try {
            $request->validate(['id' => 'required']);
            $purchase = BatteryPurchase::find($request->input('id'));

            if (!$purchase) {
                return response()->json(['status' => 'fail', 'message' => 'Purchase not found']);
            }

            $hasReturns = DB::table('battery_purchase_returns')->where('purchase_id', $purchase->id)->exists();
            if ($hasReturns) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'এই পারচেজ ইনভয়েসের বিপরীতে রিটার্ন এন্ট্রি রয়েছে, তাই ডিলিট করা সম্ভব নয়।'
                ]);
            }

            // Restore product stock
            $details = BatteryPurchaseOrderDetail::where('purchase_id', $purchase->id)->get();
            foreach ($details as $d) {
                $product = BatteryProduct::find($d->product_id);
                if ($product) {
                    $product->decrement('quantity', $d->quantity);
                }
            }

            BatteryPurchaseOrderDetail::where('purchase_id', $purchase->id)->delete();
            BatteryPurchasePaymentDetail::where('purchases_id', $purchase->id)->delete();
            $purchase->delete();

            return response()->json(['status' => 'success', 'message' => 'Purchase deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function getPaymentDetailsById(Request $request)
    {
        try {
            $purchaseId = $request->input('id');
            $purchase = BatteryPurchase::with(['supplier', 'paymentDetails'])->findOrFail($purchaseId);

            return response()->json([
                'status' => 'success',
                'purchase' => $purchase,
                'paymentDetails' => $purchase->paymentDetails,
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function updatePaymentDetails(Request $request)
    {
        try {
            $user_id = Auth::id();
            $purchaseId = $request->input('id') ?? $request->input('purchases_id');
            $purchase = BatteryPurchase::findOrFail($purchaseId);

            $paidAmount = floatval($request->input('paid_amount', 0));
            $paymentMethod = $request->input('payment_method', 'Cash');

            $newPaid = $purchase->paid_amount + $paidAmount;
            $newDue = max(0, $purchase->due_amount - $paidAmount);

            $purchase->paid_amount = $newPaid;
            $purchase->due_amount = $newDue;
            $purchase->save();

            $status = $newDue == 0 ? 'Fully Paid' : 'Partial Paid';

            BatteryPurchasePaymentDetail::create([
                'purchases_id' => $purchase->id,
                'paid_amount' => $paidAmount,
                'discount_amount' => 0,
                'payment_method' => $paymentMethod,
                'payment_status' => $status,
                'purchase_due_collection_date' => now()->format('Y-m-d'),
                'transaction_id' => $request->input('transaction_id'),
                'user_id' => $user_id,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Payment recorded successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
