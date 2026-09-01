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
        DB::beginTransaction();
        try {
            $user_id = Auth::id();
            $orderNo = $request->order_no ?? $this->generateOrderNumber();

            $orderData = [
                'customer_id' => $request->customer_id,
                'order_no' => $orderNo,
                'sub_total' => $request->sub_total,
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

            // Create Order
            $order = Order::create($orderData);

            // Decode and handle products
            $products = json_decode($request->products, true);

            foreach ($products as $product) {
                if (isset($product['product_id'], $product['quantity'], $product['price'], $product['selling_price'])) {
                    // Correct total cost calculation
                    $totalCost = $product['price'] * $product['quantity'];
                    $totalSellingPrice = $product['selling_price'] * $product['quantity'];

                    // Create OrderDetails
                    $orderDetails = OrderDetails::create([
                        'product_id' => $product['product_id'],
                        'order_id' => $order->id,
                        'quantity' => $product['quantity'],
                        'price' => $product['price'], // Corrected
                        'selling_price' => $product['selling_price'], // Corrected
                        'user_id' => $user_id,
                    ]);

                    // Update product stock
                    $productModel = Product::find($product['product_id']);
                    if ($productModel) {
                        $productModel->quantity -= $product['quantity'];
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
            return response()->json(['status' => 'success', 'message' => 'Order created successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'fail', 'message' => 'Order creation failed: ' . $e->getMessage()]);
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
