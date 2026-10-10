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
            $PurchaseReturnData = BatteryPurchaseReturn::with(['supplier', 'purchase', 'product'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    $sName = $item->supplier ? ($item->supplier->name ?? $item->supplier->company) : 'N/A';
                    $pName = $item->product ? ($item->product->product_name ?? 'N/A') : 'N/A';
                    $pId = $item->purchase ? ($item->purchase->purchase_id ?? '#PurID' . str_pad($item->purchase->id, 5, '0', STR_PAD_LEFT)) : 'N/A';

                    return [
                        'id'            => $item->id,
                        'purchase_id'   => $pId,
                        'supplier_name' => $sName,
                        'product_name'  => $pName,
                        'quantity'      => (int) ($item->quantity ?? 1),
                        'amount'        => (float) $item->amount,
                        'due_amount'    => (float) $item->due_amount,
                        'date'          => $item->date ?? $item->created_at->format('Y-m-d'),
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

                $qty = (int) $detail->quantity;
                $costPrice = (float) $detail->cost_price;

                return [
                    'purchase_order_detail_id' => $detail->id,
                    'product_id'               => $detail->product_id,
                    'product_name'             => $detail->product ? $detail->product->product_name : 'Product',
                    'product_code'             => $code,
                    'quantity'                 => $qty,
                    'cost_price'               => round($costPrice, 2),
                    'unit_price'               => round($costPrice, 2),
                    'subtotal'                 => (float) $detail->subtotal,
                ];
            });

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

                if ($returnQty > $orderDetail->quantity) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'fail',
                        'message' => "Return quantity for product {$product->product_name} exceeds remaining purchased quantity."
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

                $orderDetail->quantity -= $returnQty;
                $orderDetail->subtotal = $orderDetail->quantity * $unitPrice;

                if ($orderDetail->quantity > 0) {
                    $orderDetail->save();
                } else {
                    $orderDetail->delete();
                }

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
        $purchaseReturn = BatteryPurchaseReturn::with(['purchase', 'supplier', 'product', 'user'])->findOrFail($id);

        return view('battery.return.purchase-return-details', compact('purchaseReturn'));
    }
}

