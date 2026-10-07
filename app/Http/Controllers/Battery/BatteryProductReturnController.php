<?php

namespace App\Http\Controllers\Battery;

use Exception;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryOrder;
use App\Models\Battery\BatteryProduct;
use App\Models\Battery\BatteryCustomer;
use App\Models\Battery\BatteryOrderDetail;
use App\Models\Battery\BatteryProductReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BatteryProductReturnController extends Controller
{
    public function ReturnProductList()
    {
        try {
            $ProductReturnData = BatteryProductReturn::with(['customer', 'order', 'product'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    $cName = $item->customer ? ($item->customer->name ?? $item->customer->customer_name) : 'Guest Customer';
                    $pName = $item->product ? ($item->product->product_name ?? 'N/A') : 'N/A';

                    $qty = (int) ($item->quantity ?? 0);
                    if ($qty <= 0) $qty = 1;

                    return [
                        'id'              => $item->id,
                        'order_no'        => $item->order->order_no ?? 'N/A',
                        'customer_name'   => $cName,
                        'product_name'    => $pName,
                        'quantity'        => $qty,
                        'amount'          => (float) $item->amount,
                        'due_amount'      => (float) $item->due_amount,
                        'discount_amount' => (float) $item->discount_amount,
                        'date'            => $item->date ?? $item->created_at->format('Y-m-d'),
                    ];
                });

            return response()->json([
                'status' => 'success',
                'ProductReturnData' => $ProductReturnData,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function SearchInvoiceForReturn(Request $request)
    {
        try {
            $orderNo = trim($request->input('order_no'));
            if (!$orderNo) {
                return response()->json(['status' => 'fail', 'message' => 'Invoice number is required']);
            }

            $cleanNo = ltrim($orderNo, '#');

            $order = BatteryOrder::with(['customer', 'details.product'])
                ->where('order_no', $orderNo)
                ->orWhere('order_no', '#' . $cleanNo)
                ->orWhere('order_no', $cleanNo)
                ->orWhere('id', $cleanNo)
                ->first();

            if (!$order) {
                $order = BatteryOrder::with(['customer', 'details.product'])
                    ->where('order_no', 'LIKE', "%{$cleanNo}%")
                    ->first();
            }

            if (!$order) {
                return response()->json(['status' => 'fail', 'message' => "No invoice found matching '{$orderNo}'"]);
            }

            $cName = $order->customer ? ($order->customer->name ?? $order->customer->customer_name) : 'Guest Customer';

            $items = $order->details->map(function($detail) {
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
                $sellingPrice = (float) $detail->selling_price;
                $unitPrice = $qty > 0 ? ($sellingPrice / $qty) : 0;

                return [
                    'order_detail_id'     => $detail->id,
                    'product_id'          => $detail->product_id,
                    'product_name'        => $detail->product ? $detail->product->product_name : 'Product',
                    'product_code'        => $code,
                    'quantity'            => $qty,
                    'unit_price'          => round($unitPrice, 2),
                    'total_selling_price' => $sellingPrice,
                ];
            });

            return response()->json([
                'status' => 'success',
                'order' => [
                    'id'              => $order->id,
                    'order_no'        => $order->order_no,
                    'customer_id'     => $order->customer_id ?? 0,
                    'customer_name'   => $cName,
                    'customer_mobile' => $order->customer ? $order->customer->mobile : 'N/A',
                    'invoice_date'    => Carbon::parse($order->invoice_date ?? $order->created_at)->format('d M Y'),
                    'sub_total'       => (float) $order->sub_total,
                    'paid_amount'     => (float) $order->paid_amount,
                    'due_amount'      => (float) $order->due_amount,
                    'discount_amount' => (float) $order->discount_amount,
                    'items'           => $items
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function ReturnProductCreate(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'customer_id' => 'required',
            'products' => 'required|array|min:1',
            'date' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $user_id = Auth::id();
            $order = BatteryOrder::with('details')->findOrFail($request->order_id);

            $totalReturnAmount = 0;
            $totalDiscountToReduce = 0;
            $totalDueToReduce = 0;
            $totalOrderQty = $order->details->sum('quantity');

            foreach ($request->products as $returnedItem) {
                $orderDetail = BatteryOrderDetail::findOrFail($returnedItem['order_detail_id']);
                $product = BatteryProduct::findOrFail($returnedItem['product_id']);
                $returnQty = (int) $returnedItem['quantity'];

                if ($returnQty > $orderDetail->quantity) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'fail',
                        'message' => "Return quantity for product ID {$product->id} cannot exceed purchased quantity."
                    ], 400);
                }

                $returnAmount = $returnQty * ($orderDetail->selling_price / max(1, $orderDetail->quantity));
                $returnCostAmount = $returnQty * ($orderDetail->price / max(1, $orderDetail->quantity));

                $discountToReduce = ($totalOrderQty > 0) ? ($returnQty * ($order->discount_amount / $totalOrderQty)) : 0;
                $dueToReduce = ($totalOrderQty > 0) ? ($returnQty * ($order->due_amount / $totalOrderQty)) : 0;

                BatteryProductReturn::create([
                    'order_id' => $order->id,
                    'amount' => $returnAmount,
                    'discount_amount' => $discountToReduce,
                    'due_amount' => $dueToReduce,
                    'date' => $request->date,
                    'customer_id' => $request->customer_id,
                    'user_id' => $user_id,
                    'product_id' => $product->id,
                    'quantity' => $returnQty,
                ]);

                // Increment battery product stock
                $product->increment('quantity', $returnQty);

                // Update battery order details
                $orderDetail->decrement('quantity', $returnQty);
                if ($orderDetail->quantity > 0) {
                    $orderDetail->price -= $returnCostAmount;
                    $orderDetail->selling_price -= $returnAmount;
                    $orderDetail->save();
                } else {
                    $orderDetail->delete();
                }

                $totalReturnAmount += $returnAmount;
                $totalDiscountToReduce += $discountToReduce;
                $totalDueToReduce += $dueToReduce;
            }

            // Update Battery Order totals
            $order->sub_total = max(0, $order->sub_total - $totalReturnAmount);
            $order->discount_amount = max(0, $order->discount_amount - $totalDiscountToReduce);
            $order->due_amount = max(0, $order->due_amount - $totalDueToReduce);
            $order->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Sales return processed successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Battery Sales Return Error: ' . $e->getMessage());
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }
}
