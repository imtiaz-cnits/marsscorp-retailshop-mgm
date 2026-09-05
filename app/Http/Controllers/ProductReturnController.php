<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use App\Models\ProductReturn;
use App\Models\Purchase;
use App\Models\PurchaseOrderDetails;
use App\Models\PurchaseReturn;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;


class ProductReturnController extends Controller
{

    // public function ReturnShowDetails($id)
    // {
    //     // Load order with related customer, details, and their associated products and payment
    //     $invoice = Order::with([
    //         'customer',
    //         'details.product', // Eager load product within details
    //         'payment'
    //     ])->findOrFail($id);

    //     // Calculate the total amount
    //     $subTotal = $invoice->details->sum(function ($orderDetail) {
    //         return $orderDetail->price * $orderDetail->quantity;
    //     });

    //     // Calculate paid and due amounts
    //     $paidAmount = $invoice->payment ? $invoice->payment->paid_amount : 0;
    //     $dueAmount = $subTotal - $paidAmount;

    //     // Filter the details to only show products whose quantity is 0
    //     $filteredDetails = $invoice->details->filter(function ($orderDetail) {
    //         // Only show products with quantity 0
    //         return $orderDetail->product->quantity == 0;
    //     });

    //     // Pass the required data to the view
    //     return view('backend.view-return.return-details', compact('invoice', 'subTotal', 'paidAmount', 'dueAmount', 'filteredDetails'));
    // }




    public function ReturnShowDetails($id)
    {
        $invoice = Order::with(['customer', 'details', 'payment'])->findOrFail($id);

        // Ensure that the order ID is available
        $orderID = $invoice->id;

        // Calculate the total amount, paid amount, and due amount
        $subTotal = $invoice->details->sum(function($orderDetail) {
            return $orderDetail->price * $orderDetail->quantity;
        });

        $paidAmount = $invoice->payment ? $invoice->payment->paid_amount : 0;
        $dueAmount = $subTotal - $paidAmount;

        // Pass the calculated values to the view
        return view('backend.view-return.return-details', compact('invoice', 'subTotal', 'paidAmount', 'dueAmount'));
    }



    public function ReturnProductList()
    {
        try {
            $ProductReturnData = ProductReturn::with(['customer', 'order', 'product'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    $cName = $item->customer ? ($item->customer->name ?? $item->customer->customer_name) : 'Guest Customer';
                    $pName = $item->product ? ($item->product->product_name ?? 'N/A') : 'N/A';
                    
                    // Fallback for legacy returns created before product_id/quantity columns were added
                    if ($pName === 'N/A' && $item->order && $item->order->details && $item->order->details->count() > 0) {
                        $firstDetail = $item->order->details->first();
                        if ($firstDetail && $firstDetail->product) {
                            $pName = $firstDetail->product->product_name;
                        }
                    }

                    $qty = (int) ($item->quantity ?? 0);
                    if ($qty <= 0) $qty = 1; // Minimum 1 pcs fallback for legacy records

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



// public function ReturnProductCreate(Request $request)
// {
//     try {
//         $user_id = Auth::id();
//         $order = Order::findOrFail($request->order_id);
//         $totalReturnAmount = 0;
//         $totalDiscountToReduce = 0;

//         foreach ($request->products as $returnedItem) {
//             $orderDetail = OrderDetails::findOrFail($returnedItem['order_detail_id']);
//             $product = Product::findOrFail($returnedItem['product_id']);
//             $returnQty = (int) $returnedItem['quantity'];

//             // Ensure return quantity does not exceed purchased quantity
//             if ($returnQty > $orderDetail->quantity) {
//                 return response()->json([
//                     'status' => 'fail',
//                     'message' => "Return quantity cannot exceed purchased quantity."
//                 ], 400);
//             }

//             // Calculate return amount based on the product's original price and selling price
//             $returnAmount = $returnQty * ($orderDetail->selling_price / $orderDetail->quantity);
//             $returnCostAmount = $returnQty * ($orderDetail->price / $orderDetail->quantity);

//             // Proportional discount calculation
//             $discountToReduce = $returnQty * ($order->discount_amount / $order->details->sum('quantity'));
//             $totalDiscountToReduce += $discountToReduce;

//             $dueToReduce = $returnQty * ($order->due_amount / $order->details->sum('quantity'));
//             // Create return entry in ProductReturn table
//             ProductReturn::create([
//                 'order_id' => $order->id,
//                 'amount' => $returnAmount,
//                 'discount_amount' => $discountToReduce,
//                 'due_amount' => $dueToReduce,
//                 'date' => $request->date,
//                 'customer_id' => $request->customer_id,
//                 'user_id' => $user_id,
//                 'product_id' => $product->id,
//                 'quantity' => $returnQty,
//             ]);

//             // Update product stock
//             $product->increment('quantity', $returnQty);

//             // Update OrderDetails quantity and check if it needs to be deleted
//             $orderDetail->decrement('quantity', $returnQty);

//             if ($orderDetail->quantity > 0) {
//                 // Only update price and selling_price when quantity > 0
//                 // Keep original price as a base and decrease based on remaining quantity
//                 $orderDetail->price -= ($returnCostAmount);
//                 $orderDetail->selling_price -= ($returnAmount);
//                 $orderDetail->save();
//             } else {
//                 $orderDetail->delete();
//             }

//             $totalReturnAmount += $returnAmount;
//         }





//         // Recalculate the remaining order values based on updated OrderDetails
//         $remainingSubTotal = $order->details->sum(fn($d) => $d->quantity * $d->selling_price);
//         $remainingDiscount = max(0, $order->discount_amount - $totalDiscountToReduce);
//         $remainingPaid = max(0, $order->paid_amount - ($totalReturnAmount - $totalDiscountToReduce));
//         $remainingDue = max(0, $order->due_amount - ($remainingDiscount - $remainingPaid));

//         // Update order with the new values
//         $order->sub_total = $remainingSubTotal;
//         $order->discount_amount = $remainingDiscount;
//         $order->paid_amount = $remainingPaid;
//         $order->due_amount = $dueToReduce;
//         $order->save();

//         return response()->json(['status' => 'success', 'message' => "Product Return Successfully Processed"]);
//     } catch (Exception $e) {
//         return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
//     }
// }


// public function ReturnProductCreate(Request $request)
// {
//     try {
//         $user_id = Auth::id();
//         $order = Order::findOrFail($request->order_id);
//         $totalReturnAmount = 0;
//         $totalDiscountToReduce = 0;
//         $totalDueToReduce = 0;
//         foreach ($request->products as $returnedItem) {
//             $orderDetail = OrderDetails::findOrFail($returnedItem['order_detail_id']);
//             $product = Product::findOrFail($returnedItem['product_id']);
//             $returnQty = (int) $returnedItem['quantity'];

//             // Ensure return quantity does not exceed purchased quantity
//             if ($returnQty > $orderDetail->quantity) {
//                 return response()->json([
//                     'status' => 'fail',
//                     'message' => "Return quantity cannot exceed purchased quantity."
//                 ], 400);
//             }


//             // Calculate return values
//             $returnAmount = $returnQty * ($orderDetail->selling_price / $orderDetail->quantity);
//             $returnCostAmount = $returnQty * ($orderDetail->price / $orderDetail->quantity);

//             // Corrected Discount Return Calculation
//             $totalOrderQty = $order->details->sum('quantity');
//             $discountToReduce = ($totalOrderQty > 0) ? ($returnQty * ($order->discount_amount / $totalOrderQty)) : 0;
//             $totalDiscountToReduce += $discountToReduce;

//             // Corrected Due Amount Reduction Calculation
//             $dueToReduce = ($totalOrderQty > 0) ? ($returnQty * ($order->due_amount / $totalOrderQty)) : 0;
//             $totalDueToReduce += $dueToReduce;
//             // Create return entry

//             ProductReturn::create([
//                 'order_id' => $order->id,
//                 'amount' => $returnAmount,
//                 'discount_amount' => $discountToReduce,
//                 'due_amount' => $dueToReduce,
//                 'date' => $request->date,
//                 'customer_id' => $request->customer_id,
//                 'user_id' => $user_id,
//                 'product_id' => $product->id,
//                 'quantity' => $returnQty,
//             ]);
//             // Update product stock
//             $product->increment('quantity', $returnQty);

//             // Update OrderDetails quantity
//             $orderDetail->decrement('quantity', $returnQty);

//             if ($orderDetail->quantity > 0) {
//                 // Adjust selling price & cost price only if some quantity remains
//                 $orderDetail->price -= $returnCostAmount;
//                 $orderDetail->selling_price -= $returnAmount;
//                 $orderDetail->save();
//             } else {
//                 $orderDetail->delete();
//             }

//             $totalReturnAmount += $returnAmount;
//         }

//         // Recalculate order totals
//         $remainingSubTotal = $order->details->sum(fn($d) => $d->quantity * $d->selling_price);
//         $remainingDiscount = max(0, $order->discount_amount - $totalDiscountToReduce);
//         $remainingPaid = max(0, $order->paid_amount - ($totalReturnAmount - $totalDiscountToReduce));
//         $remainingDue = max(0, $order->due_amount - $totalDueToReduce);

//         // Update order with new values
//         $order->sub_total = $remainingSubTotal;
//         $order->discount_amount = $remainingDiscount;
//         $order->paid_amount = $remainingPaid;
//         $order->due_amount = $remainingDue;
//         $order->save();

//         return response()->json(['status' => 'success', 'message' => "Product Return Successfully Processed"]);
//     } catch (Exception $e) {
//         return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
//     }
// }

public function ReturnProductCreate(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'customer_id' => 'required|exists:customers,id',
        'products' => 'required|array|min:1',
        'products.*.order_detail_id' => 'required|exists:order_details,id',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
        'date' => 'required|date',
    ]);

    try {
        DB::beginTransaction();

        $user_id = Auth::id();
        $order = Order::with('details')->findOrFail($request->order_id);

        $totalReturnAmount = 0;
        $totalDiscountToReduce = 0;
        $totalDueToReduce = 0;
        $totalOrderQty = $order->details->sum('quantity'); // Total order quantity for proportional calculations

        foreach ($request->products as $returnedItem) {
            $orderDetail = OrderDetails::findOrFail($returnedItem['order_detail_id']);
            $product = Product::findOrFail($returnedItem['product_id']);
            $returnQty = (int) $returnedItem['quantity'];

            // Ensure return quantity does not exceed purchased quantity
            if ($returnQty > $orderDetail->quantity) {
                DB::rollBack();
                return response()->json([
                    'status' => 'fail',
                    'message' => "Return quantity for product ID {$product->id} cannot exceed purchased quantity."
                ], 400);
            }

            // Calculate return amounts proportionally
            $returnAmount = $returnQty * ($orderDetail->selling_price / $orderDetail->quantity);
            $returnCostAmount = $returnQty * ($orderDetail->price / $orderDetail->quantity);

            // Discount and due reduction proportional to quantity
            $discountToReduce = ($totalOrderQty > 0) ? ($returnQty * ($order->discount_amount / $totalOrderQty)) : 0;
            $dueToReduce = ($totalOrderQty > 0) ? ($returnQty * ($order->due_amount / $totalOrderQty)) : 0;

            // Create ProductReturn record
            ProductReturn::create([
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

            // Update stock
            $product->increment('quantity', $returnQty);

            // Update OrderDetails
            $orderDetail->decrement('quantity', $returnQty);
            if ($orderDetail->quantity > 0) {
                $orderDetail->price -= $returnCostAmount;
                $orderDetail->selling_price -= $returnAmount;
                $orderDetail->save();
            } else {
                $orderDetail->delete();
            }

            // Accumulate totals
            $totalReturnAmount += $returnAmount;
            $totalDiscountToReduce += $discountToReduce;
            $totalDueToReduce += $dueToReduce;
        }

        // New calculations based on original order subtotal
        $remainingSubTotal = max(0, $order->sub_total - $totalReturnAmount);
        $remainingDiscount = max(0, $order->discount_amount - $totalDiscountToReduce);
        $remainingPaid = max(0, $order->paid_amount - ($totalReturnAmount - $totalDiscountToReduce));
        $remainingDue = max(0, $remainingSubTotal - $remainingPaid - $remainingDiscount);

        // Update order
        $order->update([
            'sub_total' => $remainingSubTotal,
            'discount_amount' => $remainingDiscount,
            'paid_amount' => $remainingPaid,
            'due_amount' => $remainingDue,
        ]);

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => "Product Return Successfully Processed",
            'remaining_sub_total' => $remainingSubTotal,
            'remaining_due' => $remainingDue,
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => 'fail',
            'message' => $e->getMessage(),
        ], 500);
    }
}



// purchase product return start

// public function PurchaseReturnShowDetails($id)
// {
//     // Load purchase with related supplier, order details, and payment details
//     $purchase = Purchase::with(['supplier', 'orderDetails', 'paymentDetails'])->findOrFail($id);

//     // Ensure purchase ID is available
//     $purchaseID = $purchase->id;

//     // Calculate subtotal from order details
//     $subTotal = $purchase->orderDetails->sum(function ($detail) {
//         return $detail->cost_price * $detail->quantity;
//     });

//     // Calculate total paid amount from payment details
//     $paidAmount = $purchase->paymentDetails->sum('paid_amount');

   
//     // Due amount calculation
//     $dueAmount = $subTotal - $paidAmount;

//     $totalPayableAmount = $dueAmount + ($purchase->supplier->purchase_payable_amount ?? 0);

//     // Pass to view
//     return view('backend.view-return.purchase-return-details', compact(
//         'purchase',
//         'subTotal',
//         'paidAmount',
//         'dueAmount',
//         'totalPayableAmount',
//     ));
// }


public function PurchaseReturnShowDetails($id)
{
    // Load purchase with related supplier, order details, and payment details
    // orderDetails ও paymentDetails লোড করা হচ্ছে কারণ ভিউতে এগুলো প্রদর্শন করার প্রয়োজন হতে পারে।
    $purchase = Purchase::with(['supplier', 'orderDetails', 'paymentDetails'])->findOrFail($id);

    // 💡 স্মার্ট আপডেট: যেহেতু PurchaseReturnProductCreate ফাংশনটি রিটার্নের পরে
    // 'purchases' টেবিলের grand_subtotal, paid_amount, ও due_amount কলামগুলি আপডেট করে,
    // তাই সরাসরি মডেল থেকে সেই আপডেট করা মানগুলি ব্যবহার করা উচিত।

    // 1. অবশিষ্ট সাবটোটাল (গ্র্যান্ড টোটাল) সরাসরি মডেলের আপডেট করা কলাম থেকে নেওয়া
    $subTotal = $purchase->grand_subtotal; // এটি এখন অবশিষ্ট অর্ডারের মোট মূল্য

    // 2. মোট পরিশোধিত পরিমাণ সরাসরি মডেলের আপডেট করা কলাম থেকে নেওয়া
    $paidAmount = $purchase->paid_amount; 

    // 3. অবশিষ্ট বকেয়া সরাসরি মডেলের আপডেট করা কলাম থেকে নেওয়া
    $dueAmount = $purchase->due_amount; 

    // 4. মোট প্রদেয় পরিমাণ (Total Payable Amount)
    // এটি সাপ্লায়ারের মোট বকেয়ার সাথে এই ইনভয়েসের অবশিষ্ট বকেয়া নয়।
    // এই মানটি সাধারণত purchase_payable_amount কলামে আপডেটেড থাকে।
    // তবে ইনভয়েসের প্রসঙ্গে এটি অবশিষ্ট 'dueAmount' বা 'remaining amount' বোঝানো উচিত।
    // যদি আপনি পূর্বের লজিক অনুসরণ করতে চান:
    $totalPayableAmount = $dueAmount + ($purchase->supplier->purchase_payable_amount ?? 0);
    // তবে এই ভিউ-এর জন্য, 'subTotal' এবং 'dueAmount' যথেষ্ট।
    
    // আপনি চাইলে ভিউতে স্পষ্টতার জন্য শুধুমাত্র ইনভয়েসের অবশিষ্ট বকেয়া দেখাতে পারেন:
    // $totalPayableAmount = $dueAmount;
    
    // Pass to view
    return view('backend.view-return.purchase-return-details', compact(
        'purchase',
        'subTotal',       // $purchase->grand_subtotal
        'paidAmount',     // $purchase->paid_amount
        'dueAmount',      // $purchase->due_amount
        'totalPayableAmount', // সাপ্লায়ারের মোট বকেয়া সহ
    ));
}


//  public function PurchaseReturnProductCreate(Request $request)
// {
//     $request->validate([
//         'purchase_id' => 'required|exists:purchases,id',
//         'supplier_id' => 'required|exists:suppliers,id',
//         'products' => 'required|array|min:1',
//         'products.*.purchase_order_detail_id' => 'required|exists:purchase_order_details,id',
//         'products.*.product_id' => 'required|exists:products,id',
//         'products.*.quantity' => 'required|integer|min:1',
//         'date' => 'required|date_format:d-m-Y',
//     ]);

//     try {
//         DB::beginTransaction();

//         $user_id = Auth::id();
//         $purchase = Purchase::with('orderDetails')->findOrFail($request->purchase_id);
//         $supplier = Supplier::findOrFail($request->supplier_id);

//         $totalReturnAmount = 0;

//         foreach ($request->products as $returnedItem) {
//             $orderDetail = PurchaseOrderDetails::findOrFail($returnedItem['purchase_order_detail_id']);
//             $product = Product::findOrFail($returnedItem['product_id']);
//             $returnQty = (int) $returnedItem['quantity'];

//             // ✅ Validate return quantity
//             if ($returnQty > $orderDetail->quantity) {
//                 DB::rollBack();
//                 return response()->json([
//                     'status' => 'fail',
//                     'message' => "Return quantity for product {$product->name} exceeds purchased quantity."
//                 ], 400);
//             }

//             // ✅ Unit price
//             $unitPrice = ($orderDetail->quantity > 0) 
//                 ? ($orderDetail->cost_price / $orderDetail->quantity) 
//                 : 0;

//             $returnAmount = $returnQty * $unitPrice;

//             // ✅ Date format fix
//             $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

//             PurchaseReturn::create([
//                 'purchase_id' => $purchase->id,
//                 'supplier_id' => $supplier->id,
//                 'product_id' => $product->id,
//                 'purchase_order_detail_id' => $orderDetail->id,
//                 'quantity' => $returnQty,
//                 'amount' => $returnAmount,
//                 'due_amount' => $returnAmount, // direct return amount
//                 'date' => $date,
//                 'user_id' => $user_id,
//             ]);

//             // ✅ Update product stock
//             $product->decrement('quantity', $returnQty);

//             // ✅ Update purchase order detail
//             if ($orderDetail->quantity > $returnQty) {
//                 $orderDetail->quantity -= $returnQty;
//                 $orderDetail->subtotal -= $returnAmount;
//                 $orderDetail->save();
//             } else {
//                 $orderDetail->delete();
//             }

//             $totalReturnAmount += $returnAmount;
//         }

//         // ✅ Recalculate purchase totals
//         $remainingSubTotal = max(0, $purchase->grand_subtotal - $totalReturnAmount);

//         // paid_amount as it is (don’t subtract return)
//         $remainingPaid = $purchase->paid_amount;

//         // ✅ Due should reduce directly by returnAmount
//         $remainingDue = max(0, $purchase->due_amount - $totalReturnAmount);

//         $purchase->update([
//             'grand_subtotal' => $remainingSubTotal,
//             'due_amount' => $remainingDue,
//         ]);

//         // ✅ Update supplier payable balance
//         $supplier->update([
//             'purchase_payable_amount' => max(0, $supplier->purchase_payable_amount - $totalReturnAmount),
//         ]);

//         DB::commit();

//         return response()->json([
//             'status' => 'success',
//             'message' => 'Purchase Return Successfully Processed',
//             'remaining_sub_total' => $remainingSubTotal,
//             'remaining_due' => $remainingDue,
//         ]);

//     } catch (\Exception $e) {
//         DB::rollBack();
//         return response()->json([
//             'status' => 'fail',
//             'message' => $e->getMessage(),
//             'file' => $e->getFile(),
//             'line' => $e->getLine()
//         ], 500);
//     }
// }

// public function PurchaseReturnProductCreate(Request $request)
// {
//     $request->validate([
//         'purchase_id' => 'required|exists:purchases,id',
//         'supplier_id' => 'required|exists:suppliers,id',
//         'products' => 'required|array|min:1',
//         'products.*.purchase_order_detail_id' => 'required|exists:purchase_order_details,id',
//         'products.*.product_id' => 'required|exists:products,id',
//         'products.*.quantity' => 'required|integer|min:1',
//         'date' => 'required|date_format:d-m-Y',
//     ]);

//     try {
//         DB::beginTransaction();

//         $user_id = Auth::id();
//         $purchase = Purchase::with('orderDetails')->findOrFail($request->purchase_id);
//         $supplier = Supplier::findOrFail($request->supplier_id);

//         $totalReturnAmount = 0;
//         $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

//         foreach ($request->products as $returnedItem) {
//             $orderDetail = PurchaseOrderDetails::findOrFail($returnedItem['purchase_order_detail_id']);
//             $product = Product::findOrFail($returnedItem['product_id']);
//             $returnQty = (int) $returnedItem['quantity'];

//             // ✅ Validate return qty (should not exceed purchased qty)
//             if ($returnQty > $orderDetail->quantity) {
//                 DB::rollBack();
//                 return response()->json([
//                     'status' => 'fail',
//                     'message' => "Return quantity for product {$product->name} exceeds purchased quantity."
//                 ], 400);
//             }

//             // ✅ Prefer stored unit price (avoid fraction problem)
//             $unitPrice = $orderDetail->unit_price ?? ($orderDetail->cost_price * max(1, $orderDetail->quantity));

//             $returnAmount = $returnQty * $unitPrice;

//             // ✅ Save return entry
//             PurchaseReturn::create([
//                 'purchase_id' => $purchase->id,
//                 'supplier_id' => $supplier->id,
//                 'product_id' => $product->id,
//                 'purchase_order_detail_id' => $orderDetail->id,
//                 'quantity' => $returnQty,
//                 'amount' => $returnAmount,
//                 'due_amount' => $returnAmount,
//                 'date' => $date,
//                 'user_id' => $user_id,
//             ]);

//             // ✅ Update stock (check before decrement)
//             if ($product->quantity >= $returnQty) {
//                 $product->decrement('quantity', $returnQty);
//             }

//             // ✅ Update order detail
//             $orderDetail->quantity -= $returnQty;
//             $orderDetail->subtotal = $orderDetail->quantity * $unitPrice;

//             if ($orderDetail->quantity > 0) {
//                 $orderDetail->save();
//             } else {
//                 $orderDetail->delete();
//             }

//             $totalReturnAmount += $returnAmount;
//         }

//         // ✅ Recalculate purchase totals
//         $remainingSubTotal = max(0, $purchase->grand_subtotal - $totalReturnAmount);

//         // Paid amount stay same
//         $remainingPaid = $purchase->paid_amount;

//         // Due reduce by return amount
//         $remainingDue = max(0, ($purchase->due_amount - $totalReturnAmount));

//         $purchase->update([
//             'grand_subtotal' => $remainingSubTotal,
//             'paid_amount' => $remainingPaid,
//             'due_amount' => $remainingDue,
//         ]);

//         // ✅ Update supplier balance
//         $supplier->update([
//             'purchase_payable_amount' => max(0, $supplier->purchase_payable_amount - $totalReturnAmount),
//         ]);

//         DB::commit();

//         return response()->json([
//             'status' => 'success',
//             'message' => 'Purchase Return Successfully Processed',
//             'remaining_sub_total' => $remainingSubTotal,
//             'remaining_due' => $remainingDue,
//         ]);

//     } catch (\Exception $e) {
//         DB::rollBack();
//         return response()->json([
//             'status' => 'fail',
//             'message' => $e->getMessage(),
//             'file' => $e->getFile(),
//             'line' => $e->getLine()
//         ], 500);
//     }
// }



public function PurchaseReturnProductCreate(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'products' => 'required|array|min:1',
            'products.*.purchase_order_detail_id' => 'required|exists:purchase_order_details,id',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $user_id = Auth::id();
            $purchase = Purchase::with('orderDetails')->findOrFail($request->purchase_id);
            $supplier = Supplier::findOrFail($request->supplier_id);

            $totalReturnAmount = 0;
            $date = Carbon::parse($request->date)->format('Y-m-d');

            foreach ($request->products as $returnedItem) {
                // `PurchaseOrderDetails` টেবিল ব্যবহার করা হলো
                $orderDetail = PurchaseOrderDetails::findOrFail($returnedItem['purchase_order_detail_id']);
                // `Product` টেবিল ব্যবহার করা হলো
                $product = Product::findOrFail($returnedItem['product_id']);
                $returnQty = (int) $returnedItem['quantity'];

                // 1. ✅ ভ্যালিডেশন: অবশিষ্ট কেনা পরিমাণের থেকে বেশি রিটার্ন করা যাবে না
                if ($returnQty > $orderDetail->quantity) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'fail',
                        'message' => "Return quantity for product {$product->name} exceeds remaining purchased quantity."
                    ], 400);
                }

                // 2. ✅ ইউনিট প্রাইস গণনা: unit_price/cost_price ব্যবহার করে
                // আমরা ধরে নিচ্ছি `cost_price` কলামটি প্রতি ইউনিটের মূল্য ধারণ করে।
                // এটি আপনার ভুল রিটার্ন অ্যামাউন্টের সমস্যা সমাধান করবে।
                $unitPrice = $orderDetail->cost_price; // Assuming cost_price holds the Unit Price

                // রিটার্নের মোট মূল্য
                $returnAmount = $returnQty * $unitPrice;

                // 3. ✅ রিটার্ন এন্ট্রি সংরক্ষণ (`purchase_returns` টেবিল)
                PurchaseReturn::create([
                    'purchase_id' => $purchase->id,
                    'supplier_id' => $supplier->id,
                    'product_id' => $product->id,
                    'purchase_order_detail_id' => $orderDetail->id,
                    'quantity' => $returnQty,
                    'amount' => $returnAmount,
                    'due_amount' => $returnAmount, // রিটার্ন অ্যামাউন্ট বকেয়া হিসাবে যুক্ত হবে
                    'date' => $date,
                    'user_id' => $user_id,
                ]);

                // 4. ✅ স্টক আপডেট (`products` টেবিল)
                // রিটার্ন করা হলে স্টক কমিয়ে দেওয়া হবে
                if ($product->quantity >= $returnQty) {
                    $product->decrement('quantity', $returnQty);
                }

                // 5. ✅ অর্ডার ডিটেইল আপডেট (`purchase_order_details` টেবিল)
                $orderDetail->quantity -= $returnQty;
                
                // সাবটোটাল আপডেট: অবশিষ্ট পরিমাণ * ইউনিট প্রাইস
                // এটি আপনার ভুল সাবটোটাল আপডেটের সমস্যা সমাধান করবে।
                $orderDetail->subtotal = $orderDetail->quantity * $unitPrice; 

                if ($orderDetail->quantity > 0) {
                    $orderDetail->save();
                } else {
                    $orderDetail->delete(); // পরিমাণ ০ হলে ডিটেইল মুছে ফেলা হবে
                }

                $totalReturnAmount += $returnAmount;
            } // foreach লুপ শেষ

            // 6. ✅ পারচেজ টোটাল আপডেট (`purchases` টেবিল)
            
            // স্মার্ট পদ্ধতি: অবশিষ্ট সকল orderDetails-এর মোট সাবটোটাল বের করা
            // এটি মাল্টিপল আইটেম রিটার্নের পরে সঠিক grand_subtotal নিশ্চিত করবে।
            $currentPurchaseOrderDetailsSubtotal = PurchaseOrderDetails::where('purchase_id', $purchase->id)->sum('subtotal');
            $remainingSubTotal = $currentPurchaseOrderDetailsSubtotal;
            
            // Paid amount remains the same, as the refund/adjustment happens through due amount or supplier balance.
            $remainingPaid = $purchase->paid_amount;

            // বকেয়া কমিয়ে দেওয়া হবে রিটার্ন অ্যামাউন্ট অনুযায়ী
            $remainingDue = max(0, ($purchase->due_amount - $totalReturnAmount)); 

            $purchase->update([
                'grand_subtotal' => $remainingSubTotal,
                'paid_amount' => $remainingPaid,
                'due_amount' => $remainingDue,
            ]);

            // 7. ✅ সাপ্লায়ার ব্যালেন্স আপডেট (`suppliers` টেবিল)
            $supplier->update([
                'purchase_payable_amount' => max(0, $supplier->purchase_payable_amount - $totalReturnAmount),
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Purchase Return Successfully Processed',
                'remaining_sub_total' => $remainingSubTotal,
                'remaining_due' => $remainingDue,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    // Search invoice by Order No for processing returns
    public function SearchInvoiceForReturn(Request $request)
    {
        try {
            $orderNo = trim($request->input('order_no'));
            if (!$orderNo) {
                return response()->json(['status' => 'fail', 'message' => 'Invoice number is required']);
            }

            // Remove leading # if present or try matching
            $cleanNo = ltrim($orderNo, '#');

            $order = Order::with(['customer', 'details.product'])
                ->where('order_no', $orderNo)
                ->orWhere('order_no', '#' . $cleanNo)
                ->orWhere('order_no', $cleanNo)
                ->orWhere('id', $cleanNo)
                ->first();

            if (!$order) {
                $order = Order::with(['customer', 'details.product'])
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
                    else if (is_string($rawCode) && str_starts_with($rawCode, '[')) {
                        try { $arr = json_decode($rawCode, true); $code = $arr[0] ?? 'N/A'; } catch(\Exception $e){}
                    } else {
                        $code = $rawCode;
                    }
                }

                $qty = (int) $detail->quantity;
                $sellingPrice = (float) $detail->selling_price;
                $unitPrice = $qty > 0 ? ($sellingPrice / $qty) : 0;

                return [
                    'order_detail_id' => $detail->id,
                    'product_id'      => $detail->product_id,
                    'product_name'    => $detail->product ? $detail->product->product_name : 'Product',
                    'product_code'    => $code,
                    'quantity'        => $qty,
                    'unit_price'      => round($unitPrice, 2),
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
                    'invoice_date'    => \Carbon\Carbon::parse($order->invoice_date ?? $order->created_at)->format('d M Y'),
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

    // Search purchase by Purchase ID / Invoice No for processing returns
    public function SearchPurchaseForReturn(Request $request)
    {
        try {
            $purchaseNo = trim($request->input('purchase_no'));
            if (!$purchaseNo) {
                return response()->json(['status' => 'fail', 'message' => 'Purchase invoice number is required']);
            }

            $cleanNo = ltrim(preg_replace('/[^0-9]/', '', $purchaseNo), '0');
            if (!$cleanNo) $cleanNo = $purchaseNo;

            $purchase = Purchase::with(['supplier', 'orderDetails.product'])
                ->where('id', $cleanNo)
                ->orWhere('id', $purchaseNo)
                ->first();

            if (!$purchase) {
                $purchase = Purchase::with(['supplier', 'orderDetails.product'])
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
                    else if (is_string($rawCode) && str_starts_with($rawCode, '[')) {
                        try { $arr = json_decode($rawCode, true); $code = $arr[0] ?? 'N/A'; } catch(\Exception $e){}
                    } else {
                        $code = $rawCode;
                    }
                }

                $qty = (int) $detail->quantity;
                $costPrice = (float) ($detail->cost_price ?? $detail->unit_price ?? 0);

                return [
                    'purchase_order_detail_id' => $detail->id,
                    'product_id'               => $detail->product_id,
                    'product_name'             => $detail->product ? $detail->product->product_name : 'Product',
                    'product_code'             => $code,
                    'quantity'                 => $qty,
                    'unit_price'               => round($costPrice, 2),
                    'subtotal'                 => (float) ($detail->subtotal ?? ($qty * $costPrice)),
                ];
            });

            return response()->json([
                'status' => 'success',
                'purchase' => [
                    'id'              => $purchase->id,
                    'purchase_no'     => $pNo,
                    'supplier_id'     => $purchase->supplier_id ?? 0,
                    'supplier_name'   => $sName,
                    'supplier_mobile' => $purchase->supplier ? $purchase->supplier->mobile : 'N/A',
                    'purchase_date'   => \Carbon\Carbon::parse($purchase->date ?? $purchase->created_at)->format('d M Y'),
                    'grand_subtotal'  => (float) $purchase->grand_subtotal,
                    'paid_amount'     => (float) $purchase->paid_amount,
                    'due_amount'      => (float) $purchase->due_amount,
                    'items'           => $items
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    // List all purchase returns
    public function PurchaseReturnList()
    {
        try {
            $PurchaseReturnData = PurchaseReturn::with(['supplier', 'purchase', 'product'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    $sName = $item->supplier ? ($item->supplier->name ?? $item->supplier->company) : 'Supplier';
                    $pName = $item->product ? ($item->product->product_name ?? 'N/A') : 'N/A';
                    $pNo = $item->purchase ? ('#PurID' . str_pad($item->purchase->id, 5, '0', STR_PAD_LEFT)) : 'N/A';

                    $qty = (int) ($item->quantity ?? 1);
                    if ($qty <= 0) $qty = 1;

                    return [
                        'id'              => $item->id,
                        'purchase_no'     => $pNo,
                        'supplier_name'   => $sName,
                        'product_name'    => $pName,
                        'quantity'        => $qty,
                        'amount'          => (float) $item->amount,
                        'due_amount'      => (float) $item->due_amount,
                        'date'            => $item->date ?? $item->created_at->format('Y-m-d'),
                    ];
                });

            return response()->json([
                'status' => 'success',
                'PurchaseReturnData' => $PurchaseReturnData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ]);
        }
    }

}
