<?php

namespace App\Http\Controllers\Battery;

use Exception;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryPurchase;
use App\Models\Battery\BatteryPurchaseOrderDetail;
use App\Models\Battery\BatteryPurchaseReturn;
use App\Models\Battery\BatteryProduct;
use App\Models\Battery\BatterySupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BatteryPurchaseReturnController extends Controller
{
    public function PurchaseReturnList()
    {
        try {
            $PurchaseReturnData = BatteryPurchaseReturn::with(['supplier', 'purchase', 'product.unit'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    $sName = $item->supplier ? ($item->supplier->name ?? $item->supplier->company) : 'N/A';
                    $pName = $item->product ? ($item->product->product_name ?? 'N/A') : 'N/A';
                    $pId = $item->purchase ? ($item->purchase->purchase_id ?? '#PurID' . str_pad($item->purchase->id, 5, '0', STR_PAD_LEFT)) : 'N/A';
                    $purDbId = $item->purchase_id ?? ($item->purchase ? $item->purchase->id : null);
                    $supId = $item->supplier_id ?? ($item->supplier ? $item->supplier->id : null);
                    $sMobile = $item->supplier ? ($item->supplier->mobile ?? $item->supplier->phone ?? '') : '';
                    $unitName = ($item->product && $item->product->unit) ? ($item->product->unit->name ?? 'pcs') : 'pcs';

                    return [
                        'id'              => $item->id,
                        'purchase_id'     => $purDbId,
                        'purchase_db_id'  => $purDbId,
                        'purchase_no'     => $pId,
                        'supplier_id'     => $supId,
                        'supplier_name'   => $sName,
                        'supplier_mobile' => $sMobile,
                        'product_name'    => $pName,
                        'unit'            => $unitName,
                        'quantity'        => (int) ($item->quantity ?? 1),
                        'amount'          => (float) $item->amount,
                        'due_amount'      => (float) $item->due_amount,
                        'date'            => $item->date ?? ($item->created_at ? $item->created_at->format('Y-m-d') : null),
                        'created_at_formatted' => $item->created_at ? $item->created_at->format('d M Y, h:i A') : '',
                    ];
                });

            return response()->json([
                'status' => 'success',
                'PurchaseReturnData' => $PurchaseReturnData,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function SearchPurchaseForReturn(Request $request)
    {
        try {
            $purchaseNo = trim($request->input('purchase_no'));
            if (!$purchaseNo) {
                return response()->json(['status' => 'fail', 'message' => 'Purchase invoice number is required']);
            }

            $cleanNo = ltrim(preg_replace('/[^0-9]/', '', $purchaseNo), '0');
            if (!$cleanNo) $cleanNo = $purchaseNo;

            $purchase = BatteryPurchase::with(['supplier', 'orderDetails.product'])
                ->where('id', $cleanNo)
                ->orWhere('id', $purchaseNo)
                ->orWhere('purchase_id', $purchaseNo)
                ->first();

            if (!$purchase) {
                $purchase = BatteryPurchase::with(['supplier', 'orderDetails.product'])
                    ->whereHas('supplier', function($q) use ($purchaseNo) {
                        $q->where('name', 'LIKE', "%{$purchaseNo}%")
                          ->orWhere('company', 'LIKE', "%{$purchaseNo}%");
                    })
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            if (!$purchase) {
                return response()->json(['status' => 'fail', 'message' => "No purchase invoice found matching '{$purchaseNo}'"]);
            }

            $sName = $purchase->supplier ? ($purchase->supplier->name ?? $purchase->supplier->company ?? 'Supplier') : 'Supplier';
            $pNo = '#PurID' . str_pad($purchase->id, 5, '0', STR_PAD_LEFT);

            $items = $purchase->orderDetails->map(function($detail) {
                $code = 'N/A';
                if ($detail->product && $detail->product->product_code) {
                    $rawCode = $detail->product->product_code;
                    if (is_array($rawCode)) $code = $rawCode[0] ?? 'N/A';
                    elseif (is_string($rawCode) && str_starts_with($rawCode, '[')) {
                        try { $arr = json_decode($rawCode, true); $code = $arr[0] ?? 'N/A'; } catch(\Exception $e){}
                    } else {
                        $code = $rawCode;
                    }
                }

                $totalQty = (int) $detail->quantity;
                $returnedQty = (int) ($detail->return_quantity ?? 0);
                $availableQty = max(0, $totalQty - $returnedQty);
                $costPrice = (float) $detail->cost_price;

                return [
                    'purchase_order_detail_id' => $detail->id,
                    'product_id'               => $detail->product_id,
                    'product_name'             => $detail->product ? $detail->product->product_name : 'Product',
                    'product_code'             => $code,
                    'quantity'                 => $availableQty,
                    'purchased_quantity'       => $totalQty,
                    'returned_quantity'        => $returnedQty,
                    'cost_price'               => round($costPrice, 2),
                    'unit_price'               => round($costPrice, 2),
                    'subtotal'                 => round($costPrice * $availableQty, 2),
                ];
            })->filter(function($item) {
                return $item['quantity'] > 0;
            })->values();

            return response()->json([
                'status' => 'success',
                'purchase' => [
                    'id'               => $purchase->id,
                    'purchase_id'      => $pNo,
                    'supplier_id'      => $purchase->supplier_id ?? 0,
                    'supplier_name'    => $sName,
                    'supplier_mobile'  => $purchase->supplier ? $purchase->supplier->mobile : 'N/A',
                    'date'             => Carbon::parse($purchase->date ?? $purchase->created_at)->format('d M Y'),
                    'grand_subtotal'   => (float) $purchase->grand_subtotal,
                    'paid_amount'      => (float) $purchase->paid_amount,
                    'due_amount'       => (float) $purchase->due_amount,
                    'delivery_charge'  => (float) ($purchase->delivery_charge ?? 0),
                    'discount_amount'  => (float) ($purchase->discount_amount ?? 0),
                    'items'            => $items
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function PurchaseReturnProductCreate(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required',
            'supplier_id' => 'required',
            'products' => 'required|array|min:1',
            'date' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $user_id = Auth::id() ?? 1;
            $purchase = BatteryPurchase::with('orderDetails')->findOrFail($request->purchase_id);
            $supplier = BatterySupplier::findOrFail($request->supplier_id);

            $date = Carbon::parse($request->date)->format('Y-m-d');
            $totalReturnAmount = 0;

            foreach ($request->products as $returnedItem) {
                $detailId = $returnedItem['purchase_order_detail_id'] ?? $returnedItem['purchase_details_id'] ?? null;
                if (!$detailId) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'fail',
                        'message' => 'Missing purchase detail reference.'
                    ], 400);
                }

                $orderDetail = BatteryPurchaseOrderDetail::findOrFail($detailId);
                $product = BatteryProduct::findOrFail($returnedItem['product_id']);
                $returnQty = (int) $returnedItem['quantity'];

                $availableReturnQty = $orderDetail->quantity - ($orderDetail->return_quantity ?? 0);

                if ($returnQty > $availableReturnQty) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'fail',
                        'message' => "Return quantity for product {$product->product_name} exceeds remaining available quantity."
                    ], 400);
                }

                $unitPrice = (float) $orderDetail->cost_price;
                $returnAmount = $returnQty * $unitPrice;

                BatteryPurchaseReturn::create([
                    'purchase_id' => $purchase->id,
                    'supplier_id' => $supplier->id,
                    'product_id' => $product->id,
                    'purchase_order_detail_id' => $orderDetail->id,
                    'quantity' => $returnQty,
                    'amount' => $returnAmount,
                    'due_amount' => $returnAmount,
                    'date' => $date,
                    'user_id' => $user_id,
                ]);

                // Decrement stock for purchase return
                if ($product->quantity >= $returnQty) {
                    $product->decrement('quantity', $returnQty);
                }

                // Preserve purchase detail line and track return quantity
                $orderDetail->return_quantity = ($orderDetail->return_quantity ?? 0) + $returnQty;
                $orderDetail->save();

                $totalReturnAmount += $returnAmount;
            }

            // 6. Update Parent Battery Purchase Header (Retail-equivalent Parity)
            $currentPurchaseOrderDetailsSubtotal = BatteryPurchaseOrderDetail::where('purchase_id', $purchase->id)->sum('subtotal');
            $remainingSubTotal = (float) $currentPurchaseOrderDetailsSubtotal;
            $remainingPaid = (float) $purchase->paid_amount;
            $remainingDue = max(0, (float) $purchase->due_amount - $totalReturnAmount);

            $purchase->update([
                'grand_subtotal' => $remainingSubTotal,
                'paid_amount'    => $remainingPaid,
                'due_amount'     => $remainingDue,
            ]);

            // 7. Update Battery Supplier Payable Balance (Retail-equivalent Parity)
            $supplier->update([
                'purchase_payable_amount' => max(0, (float) $supplier->purchase_payable_amount - $totalReturnAmount),
            ]);

            DB::commit();

            return response()->json([
                'status'              => 'success',
                'message'             => 'Purchase Return Successfully Processed',
                'remaining_sub_total' => $remainingSubTotal,
                'remaining_due'       => $remainingDue,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Battery Purchase Return Error: ' . $e->getMessage());
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }

    public function PurchaseReturnShowDetails($id)
    {
        // 1. Check if $id is an existing BatteryPurchase (initiated from Purchase List Return action)
        $purchase = BatteryPurchase::with(['supplier', 'orderDetails.product', 'paymentDetails'])->find($id);

        if ($purchase) {
            $subTotal = (float) $purchase->orderDetails->sum(function ($detail) {
                return (float) ($detail->cost_price ?? 0) * (int) ($detail->quantity ?? 1);
            });
            $paidAmount = (float) ($purchase->paymentDetails ? $purchase->paymentDetails->sum('paid_amount') : 0);
            $dueAmount = (float) $purchase->due_amount;
            $supplierPayable = (float) ($purchase->supplier->purchase_payable_amount ?? 0);
            $totalPayableAmount = $supplierPayable + $dueAmount;

            return view('battery.return.purchase-return-details', compact(
                'purchase',
                'subTotal',
                'paidAmount',
                'dueAmount',
                'totalPayableAmount'
            ));
        }

        // 2. Fallback to existing BatteryPurchaseReturn voucher
        $purchaseReturn = BatteryPurchaseReturn::with(['purchase.supplier', 'supplier', 'product', 'user'])->findOrFail($id);

        return view('battery.return.purchase-return-details', compact('purchaseReturn'));
    }
}

