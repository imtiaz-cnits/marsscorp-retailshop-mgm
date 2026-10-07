<?php

namespace App\Http\Controllers\Battery;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryOrder;
use App\Models\Battery\BatteryProduct;
use App\Models\Battery\BatteryCustomer;
use App\Models\Battery\BatteryOrderDetail;
use App\Models\Battery\BatteryOrderPaymentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BatteryOrderController extends Controller
{
    public function OrderCreate(Request $request)
    {
        if (empty($request->customer_id) || $request->customer_id === 'none') {
            return response()->json([
                'status' => 'fail',
                'message' => 'কাস্টমার সিলেক্ট অথবা তৈরি করা আবশ্যক!'
            ], 422);
        }

        DB::beginTransaction();
        try {
            $user_id = Auth::id();
            $orderNo = $request->order_no ?? $this->generateOrderNumber();

            $order = BatteryOrder::create([
                'customer_id' => $request->customer_id,
                'order_no' => $orderNo,
                'sub_total' => $request->sub_total,
                'delivery_charge' => floatval($request->delivery_charge ?? 0),
                'paid_amount' => $request->paid_amount ?? 0,
                'discount_amount' => $request->discount_amount ?? 0,
                'due_amount' => $request->due_amount ?? 0,
                'previous_due_amount' => $request->previous_due_amount ?? 0,
                'return_adjustment_amount' => floatval($request->return_adjustment_amount ?? 0),
                'order_note' => $request->order_note,
                'invoice_date' => $request->invoice_date ?? now()->format('Y-m-d'),
                'user_id' => $user_id,
            ]);

            $products = is_array($request->products) ? $request->products : json_decode($request->products, true);
            if (is_array($products)) {
                foreach ($products as $product) {
                    if (isset($product['product_id'], $product['quantity'])) {
                        $costPrice = $product['cost_price'] ?? ($product['price'] ?? 0);
                        $sellingPrice = $product['selling_price'] ?? ($product['price'] ?? 0);

                        BatteryOrderDetail::create([
                            'product_id' => $product['product_id'],
                            'order_id' => $order->id,
                            'quantity' => $product['quantity'],
                            'price' => $costPrice,
                            'selling_price' => $sellingPrice,
                            'user_id' => $user_id,
                        ]);

                        $productModel = BatteryProduct::find($product['product_id']);
                        if ($productModel) {
                            $productModel->quantity -= $product['quantity'];
                            $productModel->save();
                        }
                    }
                }
            }

            $paymentStatus = floatval($request->due_amount ?? 0) <= 0 ? 'Fully Paid' : (floatval($request->paid_amount ?? 0) > 0 ? 'Partial Paid' : 'Unpaid');

            BatteryOrderPaymentDetail::create([
                'order_id' => $order->id,
                'paid_amount' => $request->paid_amount ?? 0,
                'transaction_id' => $request->transaction_id ?? null,
                'payment_method' => $request->payment_method ?? 'Cash',
                'due_collection_date' => $request->invoice_date ?? now()->format('Y-m-d'),
                'payment_status' => $paymentStatus,
                'user_id' => $user_id,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully',
                'invoice_id' => $order->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Battery Order Create Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'fail',
                'message' => 'Order creation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generateOrderNumber()
    {
        $lastOrder = BatteryOrder::latest('id')->first();
        $lastOrderNo = $lastOrder?->order_no;

        $nextOrderNumber = 1;
        if ($lastOrderNo && preg_match('/#BAT-INV(\d+)/', $lastOrderNo, $matches)) {
            $nextOrderNumber = (int) $matches[1] + 1;
        } elseif ($lastOrder) {
            $nextOrderNumber = $lastOrder->id + 1;
        }

        return sprintf('#BAT-INV%05d', $nextOrderNumber);
    }
}
