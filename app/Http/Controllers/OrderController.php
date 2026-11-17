<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrderPaymentDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class OrderController extends Controller
{



    // public function OrderCreate(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $user_id = Auth::id();
    //         $orderNo = $request->order_no ?? $this->generateOrderNumber();

    //         // Validate required fields
    //         $request->validate([
    //             'customer_name' => 'required|string',
    //             'mobile' => 'required|string',
    //             'address_details' => 'nullable|string',
    //             'sub_total' => 'required|numeric',
    //             'total_cost' => 'required|numeric',
    //             'paid_amount' => 'required|numeric',
    //             'due_amount' => 'required|numeric',
    //         ]);

    //         // Check if the customer exists by customer_id or mobile number
    //       // Check if the customer exists by customer_id or mobile number
    //       $customer = Customer::where('mobile', $request->mobile)->first();

    //       if ($customer) {
    //           // Customer exists, update their details and add to due amounts
    //           $customer->update([
    //               'customer_name' => $request->customer_name,
    //               'address_details' => $request->address_details,
    //               'date' => $request->date,
    //               'user_id' => $user_id,
    //               'previous_due_amount' => ($customer->previous_due_amount ?? 0) + ($request->previous_due_amount ?? 0),
    //           ]);
    //       } else {
    //           // Customer doesn't exist, create a new one if no customer_id provided
    //           $customer = Customer::create([
    //               'customer_id' => $this->generateCustomerID(), // Generate a new customer ID
    //               'customer_name' => $request->customer_name,
    //               'mobile' => $request->mobile,
    //               'address_details' => $request->address_details,
    //               'date' => $request->date,
    //               'user_id' => $user_id,
    //               'previous_due_amount' => $request->previous_due_amount ?? 0,
    //           ]);
    //       }

    //       // Continue with the rest of the logic, such as creating an order, etc.


    //         $previousDueAmount = ($request->previous_due_amount ?? 0) + ($request->due_amount ?? 0);

    //         // Create Order
    //         $order = Order::create([
    //             'customer_id' => $customer->id,
    //             'order_no' => $orderNo,
    //             'sub_total' => $request->sub_total,
    //             'total_cost' => $request->total_cost,
    //             'paid_amount' => $request->paid_amount,
    //             'discount_amount' => $request->discount_amount,
    //             'due_amount' => $request->due_amount,
    //             'previous_due_amount' => $request->previous_due_amount,
    //             'user_id' => $user_id,
    //         ]);

    //         // Update customer's due amount
    //         $customer->update(['previous_due_amount' => $previousDueAmount]);

    //         // Decode and handle products
    //         $products = json_decode($request->products, true);
    //         foreach ($products as $product) {
    //             if (isset($product['product_id'], $product['quantity'], $product['price'])) {
    //                 // Create OrderDetails
    //                 $orderDetails = OrderDetails::create([
    //                     'product_id' => $product['product_id'],
    //                     'order_id' => $order->id,
    //                     'quantity' => $product['quantity'],
    //                     'price' => $product['price'],
    //                     'selling_price' => $product['selling_price'],
    //                     'user_id' => $user_id,
    //                 ]);

    //                 // Update product stock
    //                 $productModel = Product::find($product['product_id']);
    //                 if ($productModel) {
    //                     $productModel->quantity -= $product['quantity'];
    //                     $productModel->save();
    //                 }
    //             }
    //         }

    //         // Create payment details
    //         OrderPaymentDetails::create([
    //             'order_id' => $order->id,
    //             'paid_amount' => $request->paid_amount,
    //             'transaction_id' => $request->transaction_id,
    //             'payment_method' => $request->payment_method,
    //             'payment_status' => $request->payment_status,
    //             'user_id' => $user_id,
    //         ]);

    //         DB::commit();
    //         return response()->json(['status' => 'success', 'message' => 'Order created successfully']);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['status' => 'fail', 'message' => 'Order creation failed: ' . $e->getMessage()]);
    //     }
    // }




    // public function OrderCreate(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $user_id = Auth::id();
    //     $orderNo = $request->order_no ?? $this->generateOrderNumber();

    //     $order = Order::create([
    //         'customer_id' => $request->customer_id,
    //         'order_no' => $orderNo,
    //         'sub_total' => $request->sub_total,
    //         'paid_amount' => $request->paid_amount,
    //         'discount_amount' => $request->discount_amount,
    //         'due_amount' => $request->due_amount,
    //         'previous_due_amount' => $request->previous_due_amount,
    //         'user_id' => $user_id,
    //     ]);
    //         // Decode and handle products
    //         // Decode and handle products
    //         $products = json_decode($request->products, true);

    //         foreach ($products as $product) {
    //             if (isset($product['product_id'], $product['quantity'], $product['price'], $product['selling_price'])) {
    //                 // Correct total cost calculation
    //                 $totalCost = $product['price'] * $product['quantity'];
    //                 $totalSellingPrice = $product['selling_price'] * $product['quantity'];

    //                 // Create OrderDetails
    //                 $orderDetails = OrderDetails::create([
    //                     'product_id' => $product['product_id'],
    //                     'order_id' => $order->id,
    //                     'quantity' => $product['quantity'],
    //                     'price' => $totalCost, // Corrected
    //                     'selling_price' => $totalSellingPrice, // Corrected
    //                     'user_id' => $user_id,
    //                 ]);

    //                 // Update product stock
    //                 $productModel = Product::find($product['product_id']);
    //                 if ($productModel) {
    //                     $productModel->quantity -= $product['quantity'];
    //                     $productModel->save();
    //                 }
    //             }
    //         }


    //         // Create payment details
    //         OrderPaymentDetails::create([
    //             'order_id' => $order->id,
    //             'paid_amount' => $request->paid_amount,
    //             'transaction_id' => $request->transaction_id,
    //             'payment_method' => $request->payment_method,
    //             'payment_status' => $request->payment_status,
    //             'user_id' => $user_id,
    //         ]);

    //         DB::commit();
    //         return response()->json(['status' => 'success', 'message' => 'Order created successfully']);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['status' => 'fail', 'message' => 'Order creation failed: ' . $e->getMessage()]);
    //     }
    // }



    public function OrderCreate(Request $request)
    {
        if (empty($request->customer_id)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'কাস্টমার সিলেক্ট অথবা তৈরি করা আবশ্যক!'
            ], 422);
        }

        $user_id = Auth::id();
        DB::beginTransaction();
        try {
            $orderNo = $request->order_no ?? $this->generateOrderNumber();

            // Decode and validate products BEFORE creating order/deducting stock
            $products = is_array($request->products)
                ? $request->products
                : (json_decode($request->products, true) ?? []);

            $qtyByProduct = [];
            foreach ($products as $product) {
                if (isset($product['product_id'], $product['quantity'], $product['price'], $product['selling_price'])) {
                    $pid = (int) $product['product_id'];
                    $qty = (int) $product['quantity'];
                    if ($pid <= 0 || $qty <= 0) {
                        DB::rollBack();
                        return response()->json([
                            'status' => 'fail',
                            'message' => 'সকল বিক্রয় পণ্যের পরিমাণ অবশ্যই ০-এর বেশি হতে হবে।'
                        ], 422);
                    }
                    $qtyByProduct[$pid] = ($qtyByProduct[$pid] ?? 0) + $qty;
                }
            }

            // Deterministic ascending row lock across all impacted products
            ksort($qtyByProduct);
            $productIdsToLock = array_keys($qtyByProduct);
            $lockedProducts = !empty($productIdsToLock)
                ? Product::whereIn('id', $productIdsToLock)->orderBy('id', 'asc')->lockForUpdate()->get()->keyBy('id')
                : collect();

            $stockSnapshots = [];
            foreach ($qtyByProduct as $pid => $neededQty) {
                $productModel = $lockedProducts->get($pid);
                if (!$productModel) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'fail',
                        'message' => "পণ্য আইডি #{$pid} পাওয়া যায়নি।"
                    ], 404);
                }
                $availableQty = (int) $productModel->quantity;
                if ($availableQty < $neededQty) {
                    DB::rollBack();
                    $name = $productModel->product_name ?? ("পণ্য #{$pid}");
                    Log::warning('OrderCreate blocked: insufficient stock', [
                        'actor_user_id' => $user_id,
                        'customer_id' => $request->customer_id,
                        'product_id' => $pid,
                        'available_stock' => $availableQty,
                        'requested_qty' => $neededQty,
                    ]);
                    return response()->json([
                        'status' => 'fail',
                        'message' => "স্টক অপ্রতুল: '{$name}' এর বর্তমান স্টক {$availableQty} পিস, কিন্তু {$neededQty} পিস বিক্রি করা সম্ভব নয়।"
                    ], 422);
                }
                $stockSnapshots[$pid] = $availableQty;
            }

            $orderData = [
                'customer_id' => $request->customer_id,
                'order_no' => $orderNo,
                'sub_total' => $request->sub_total,
                'delivery_charge' => (float) ($request->delivery_charge ?? 0),
                'paid_amount' => $request->paid_amount,
                'discount_amount' => $request->discount_amount,
                'due_amount' => $request->due_amount,
                'previous_due_amount' => $request->previous_due_amount,
                'order_note' => $request->order_note,
                'invoice_date' => $request->invoice_date,
                'user_id' => $user_id,
            ];

            if (Schema::hasColumn('orders', 'return_adjustment_amount')) {
                $orderData['return_adjustment_amount'] = (float) ($request->return_adjustment_amount ?? 0);
            }

            if (Schema::hasColumn('orders', 'discount_type')) {
                $orderData['discount_type'] = $request->input('discount_type', 'fixed');
            }
            if (Schema::hasColumn('orders', 'discount_rate')) {
                $orderData['discount_rate'] = $request->filled('discount_rate') ? (float) $request->discount_rate : null;
            }

            // Create Order
            $order = Order::create($orderData);

            foreach ($products as $product) {
                if (isset($product['product_id'], $product['quantity'], $product['price'], $product['selling_price'])) {
                    $pid = (int) $product['product_id'];
                    $qty = (int) $product['quantity'];

                    // Create OrderDetails
                    OrderDetails::create([
                        'product_id' => $pid,
                        'order_id' => $order->id,
                        'quantity' => $qty,
                        'price' => $product['price'],
                        'selling_price' => $product['selling_price'],
                        'user_id' => $user_id,
                    ]);

                    // Update locked product stock safely
                    $productModel = $lockedProducts->get($pid);
                    if ($productModel) {
                        $productModel->quantity = (int) $productModel->quantity - $qty;
                        $productModel->save();
                    }
                }
            }


            // Create payment details
            OrderPaymentDetails::create([
                'order_id' => $order->id,
                'paid_amount' => $request->paid_amount,
                'transaction_id' => $request->transaction_id,
                'payment_method' => $request->payment_method,
                'due_collection_date' => $request->invoice_date,
                'payment_status' => $request->payment_status,
                'user_id' => $user_id,
            ]);

            DB::commit();

            $auditProducts = [];
            foreach ($qtyByProduct as $pid => $soldQty) {
                $oldStock = $stockSnapshots[$pid] ?? 0;
                $auditProducts[] = [
                    'product_id' => $pid,
                    'sold_qty' => $soldQty,
                    'old_stock' => $oldStock,
                    'new_stock' => $oldStock - $soldQty,
                ];
            }
            Log::info('Order Created', [
                'actor_user_id' => $user_id,
                'order_id' => $order->id,
                'order_no' => $order->order_no,
                'customer_id' => $order->customer_id,
                'invoice_date' => $order->invoice_date,
                'sub_total' => $order->sub_total,
                'paid_amount' => $order->paid_amount,
                'due_amount' => $order->due_amount,
                'products' => $auditProducts,
                'result' => 'success',
                'timestamp' => now()->toIso8601String(),
            ]);

            return response()->json(['status' => 'success', 'message' => 'Order created successfully', 'invoice_id' => $order->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Creation Error', [
                'actor_user_id' => $user_id,
                'customer_id' => $request->customer_id,
                'error' => $e->getMessage(),
            ]);
            return response()->json(['status' => 'fail', 'message' => 'Order creation failed: ' . $e->getMessage()], 500);
        }
    }





    // public function OrderCreate(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $user_id = Auth::id();
    //         $orderNo = $request->order_no ?? $this->generateOrderNumber();

    //         // Validate required fields
    //         $request->validate([
    //             'customer_name' => 'required|string',
    //             'customer_id' => 'required|string',
    //             'address_details' => 'nullable|string',
    //             'sub_total' => 'required|numeric',
    //             'paid_amount' => 'required|numeric',
    //             'due_amount' => 'required|numeric',
    //         ]);

    //         $customer = Customer::where('customer_id', $request->customer_id)->first();

    //         $previousDueAmount = ($request->previous_due_amount ?? 0) + ($request->due_amount ?? 0);

    //         // Create Order
    //         $order = Order::create([
    //             'customer_id' => $customer->id,
    //             'order_no' => $orderNo,
    //             'sub_total' => $request->sub_total,
    //             'paid_amount' => $request->paid_amount,
    //             'discount_amount' => $request->discount_amount,
    //             'due_amount' => $request->due_amount,
    //             'previous_due_amount' => $request->previous_due_amount,
    //             'user_id' => $user_id,
    //         ]);

    //         // Update customer's due amount
    //         $customer->update(['previous_due_amount' => $previousDueAmount]);

    //         // Decode and handle products
    //         // Decode and handle products
    //         $products = json_decode($request->products, true);

    //         foreach ($products as $product) {
    //             if (isset($product['product_id'], $product['quantity'], $product['price'], $product['selling_price'])) {
    //                 // Correct total cost calculation
    //                 $totalCost = $product['price'] * $product['quantity'];
    //                 $totalSellingPrice = $product['selling_price'] * $product['quantity'];

    //                 // Create OrderDetails
    //                 $orderDetails = OrderDetails::create([
    //                     'product_id' => $product['product_id'],
    //                     'order_id' => $order->id,
    //                     'quantity' => $product['quantity'],
    //                     'price' => $totalCost, // Corrected
    //                     'selling_price' => $totalSellingPrice, // Corrected
    //                     'user_id' => $user_id,
    //                 ]);

    //                 // Update product stock
    //                 $productModel = Product::find($product['product_id']);
    //                 if ($productModel) {
    //                     $productModel->quantity -= $product['quantity'];
    //                     $productModel->save();
    //                 }
    //             }
    //         }


    //         // Create payment details
    //         OrderPaymentDetails::create([
    //             'order_id' => $order->id,
    //             'paid_amount' => $request->paid_amount,
    //             'transaction_id' => $request->transaction_id,
    //             'payment_method' => $request->payment_method,
    //             'payment_status' => $request->payment_status,
    //             'user_id' => $user_id,
    //         ]);

    //         DB::commit();
    //         return response()->json(['status' => 'success', 'message' => 'Order created successfully']);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['status' => 'fail', 'message' => 'Order creation failed: ' . $e->getMessage()]);
    //     }
    // }

    private function generateOrderNumber()
    {
        $lastOrder = Order::latest('id')->first();
        $lastOrderNo = $lastOrder?->order_no;

        // Extract numeric part and increment
        $nextOrderNumber = 1;
        if ($lastOrderNo && preg_match('/#InvID(\d+)/', $lastOrderNo, $matches)) {
            $nextOrderNumber = (int) $matches[1] + 1;
        }

        // Format as #POS00001
        return sprintf('#InvID%05d', $nextOrderNumber);
    }

    private function generateCustomerID()
    {
        $lastCustomer = Customer::orderBy('id', 'desc')->first();
        $lastIdNumber = 0;

        if ($lastCustomer && $lastCustomer->customer_id) {
            if (preg_match('/(\d+)$/', $lastCustomer->customer_id, $matches)) {
                $lastIdNumber = (int) $matches[1];
            }
        }

        $newIdNumber = $lastIdNumber + 1;
        return 'CUST-' . str_pad($newIdNumber, 4, '0', STR_PAD_LEFT);
    }
}
