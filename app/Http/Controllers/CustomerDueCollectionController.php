<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrderPaymentDetails;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerPaymentDetails;
use Illuminate\Support\Facades\Log;

class CustomerDueCollectionController extends Controller
{

    public function CustomerDueCollectionList()
    {
        try {
            // Fetch all subcategories with their associated categories
            $CustomerDueCollectionData = CustomerPaymentDetails::with('customer:id,customer_name,customer_id')->get();
            return response()->json(['status' => 'success', 'CustomerDueCollectionData' => $CustomerDueCollectionData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }



    // function CustomerDueCollectionByID(Request $request){
    //     try {
    //         $user_id = Auth::id();
    //         $request->validate(["id" => 'required|string']);

    //         $rows = Customer ::where('id', $request->input('id'))->first();
    //         return response()->json(['status' => 'success', 'rows' => $rows]);
    //     } catch (Exception $e) {
    //         return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    //     }
    // }


    function CustomerDueCollectionByID(Request $request)
    {
        try {
            $user_id = Auth::id();
            $request->validate(["id" => 'required|string']);
    
            $customer = Customer::where('id', $request->input('id'))->first();
    
            if (!$customer) {
                return response()->json(['status' => 'fail', 'message' => 'Customer not found']);
            }
    
            // Previous Due from Customer table
            $previous_due = $customer->previous_due_amount ?? 0;
    
            // Order Due: Sum of all orders' due_amount for this customer
            $order_due = Order::where('customer_id', $customer->id)->sum('due_amount') ?? 0;
    
            // Total Due
            $total_due = $previous_due + $order_due;
    
            return response()->json([
                'status' => 'success',
                'rows' => $customer,
                'previous_due' => $previous_due,
                'order_due' => $order_due,
                'total_due' => $total_due
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }



// public function CustomerPaymentDetailsUpdate(Request $request)
// {
//     DB::beginTransaction();
//     try {
//         $user_id = Auth::id();
//         $customer = Customer::findOrFail($request->input('id'));

//         $paidAmount = $request->paid_amount ?? 0;
//         $discountAmount = $request->discount_amount ?? 0;
//         $totalAvailableAmount = $paidAmount + $discountAmount;

//         // First, handle customer previous due amount
//         $previousDueAmount = $customer->previous_due_amount ?? 0;
//         if ($totalAvailableAmount > 0 && $previousDueAmount > 0) {
//             if ($totalAvailableAmount >= $previousDueAmount) {
//                 // If available amount is more than previous due, clear it
//                 $totalAvailableAmount -= $previousDueAmount;
//                 $customer->update(['previous_due_amount' => 0]);
//             } else {
//                 // Partially clear previous due
//                 $customer->update(['previous_due_amount' => $previousDueAmount - $totalAvailableAmount]);
//                 $totalAvailableAmount = 0;
//             }
//         }

//         // Now handle due orders for the customer, sorted by the oldest due first
//         $dueOrders = Order::where('customer_id', $customer->id)
//             ->where('due_amount', '>', 0)
//             ->orderBy('created_at', 'asc')
//             ->get();

//         foreach ($dueOrders as $order) {
//             if ($totalAvailableAmount <= 0) {
//                 break; // No more money to pay dues
//             }

//             if ($totalAvailableAmount >= $order->due_amount) {
//                 // If available amount is more than due, clear this order
//                 $totalAvailableAmount -= $order->due_amount;
//                 $order->update([
//                     'due_amount' => 0,
//                     'paid_amount' => $order->paid_amount + $order->due_amount,
//                 ]);
//             } else {
//                 // Partially clear this order
//                 $order->update([
//                     'due_amount' => $order->due_amount - $totalAvailableAmount,
//                     'paid_amount' => $order->paid_amount + $totalAvailableAmount,
//                 ]);
//                 $totalAvailableAmount = 0;
//                 break;
//             }
//         }

//         // Create a new CustomerPaymentDetails record
//         $newCustomerPaymentDetails = CustomerPaymentDetails::create([
//             'customer_id' => $customer->id,
//             'paid_amount' => $paidAmount,
//             'discount_amount' => $discountAmount,
//             'due_amount' => $customer->previous_due_amount, // Reflect the remaining due amount for the customer
//             'payment_status' => $customer->previous_due_amount == 0 ? 'Fully Paid' : 'Partial Paid',
//             'previous_due_amount' => $previousDueAmount,
//             'payment_method' => $request->payment_method,
//             'due_collection_date' => $request->due_collection_date,
//             'transaction_id' => $request->transaction_id ?? null,
//             'user_id' => $user_id,
//         ]);

//         DB::commit();

//         return response()->json([
//             'status' => 'success',
//             'message' => 'Customer payment details updated successfully',
//             'updated_details' => $newCustomerPaymentDetails
//         ]);

//     } catch (Exception $e) {
//         DB::rollBack();
//         return response()->json([
//             'status' => 'fail',
//             'message' => $e->getMessage()
//         ]);
//     }
// }



// public function CustomerPaymentDetailsUpdate(Request $request)
// {
//     DB::beginTransaction();
//     try {
//         $user_id = Auth::id();
//         $customer = Customer::findOrFail($request->input('id'));

//         $paidAmount = $request->paid_amount ?? 0;
//         $discountAmount = $request->discount_amount ?? 0;
//         $totalAvailableAmount = $paidAmount + $discountAmount;

//         // First, handle customer previous due amount
//         $previousDueAmount = $customer->previous_due_amount ?? 0;
//         $customerPaymentDetails = null;

//         if ($totalAvailableAmount > 0 && $previousDueAmount > 0) {
//             if ($totalAvailableAmount >= $previousDueAmount) {
//                 // If available amount is more than previous due, clear it
//                 $totalAvailableAmount -= $previousDueAmount;
//                 $customer->update(['previous_due_amount' => 0]);

//                 // Create a CustomerPaymentDetails record after clearing previous due amount
//                 $customerPaymentDetails = CustomerPaymentDetails::create([
//                     'customer_id' => $customer->id,
//                     'paid_amount' => $paidAmount,
//                     'discount_amount' => $discountAmount,
//                     'due_amount' => $customer->previous_due_amount, // Reflect the cleared amount
//                     'payment_status' => 'Fully Paid',
//                     'previous_due_amount' => $previousDueAmount,
//                     'payment_method' => $request->payment_method,
//                     'due_collection_date' => $request->due_collection_date,
//                     'transaction_id' => $request->transaction_id ?? null,
//                     'user_id' => $user_id,
//                 ]);
//             } else {
//                 // Partially clear previous due
//                 $customer->update(['previous_due_amount' => $previousDueAmount - $totalAvailableAmount]);

//                 // Create a CustomerPaymentDetails record for partial payment
//                 $customerPaymentDetails = CustomerPaymentDetails::create([
//                     'customer_id' => $customer->id,
//                     'paid_amount' => $paidAmount,
//                     'discount_amount' => $discountAmount,
//                     'due_amount' => $customer->previous_due_amount, // Reflect the remaining due amount for the customer
//                     'payment_status' => 'Partial Paid',
//                     'previous_due_amount' => $previousDueAmount,
//                     'payment_method' => $request->payment_method,
//                     'due_collection_date' => $request->due_collection_date,
//                     'transaction_id' => $request->transaction_id ?? null,
//                     'user_id' => $user_id,
//                 ]);
//                 $totalAvailableAmount = 0;
//             }
//         }

//         // Now handle due orders for the customer, sorted by the oldest due first
//         if ($totalAvailableAmount > 0) {
//             $dueOrders = Order::where('customer_id', $customer->id)
//                 ->where('due_amount', '>', 0)
//                 ->orderBy('created_at', 'asc')
//                 ->get();

//             foreach ($dueOrders as $order) {
//                 if ($totalAvailableAmount <= 0) {
//                     break; // No more money to pay dues
//                 }

//                 // If there's dues on the order, we handle the payment with OrderPaymentDetails
//                 if ($order->due_amount > 0) {
//                     if ($totalAvailableAmount >= $order->due_amount) {
//                         // If available amount is more than due, clear this order
//                         $totalAvailableAmount -= $order->due_amount;
//                         $order->update([
//                             'due_amount' => 0,
//                             'paid_amount' => $order->paid_amount + $order->due_amount,
//                         ]);

//                         // Create an OrderPaymentDetails record for the cleared dues
//                         OrderPaymentDetails::create([
//                             'order_id' => $order->id,
//                             'paid_amount' => $order->due_amount,
//                             'discount_amount' => 0,
//                             'payment_status' => 'Paid',
//                             'user_id' => $user_id,
//                             'payment_method' => $request->payment_method,
//                             'due_collection_date' => $request->due_collection_date,
//                             'transaction_id' => $request->transaction_id ?? null,
//                         ]);
//                     } else {
//                         // Partially clear this order
//                         $order->update([
//                             'due_amount' => $order->due_amount - $totalAvailableAmount,
//                             'paid_amount' => $order->paid_amount + $totalAvailableAmount,
//                         ]);
                        
//                         // Create an OrderPaymentDetails record for partial payment
//                         OrderPaymentDetails::create([
//                             'order_id' => $order->id,
//                             'paid_amount' => $totalAvailableAmount,
//                             'discount_amount' => 0,
//                             'payment_status' => 'Partial Paid',
//                             'user_id' => $user_id,
//                             'payment_method' => $request->payment_method,
//                             'due_collection_date' => $request->due_collection_date,
//                             'transaction_id' => $request->transaction_id ?? null,
//                         ]);
                        
//                         $totalAvailableAmount = 0;
//                         break;
//                     }
//                 }
//             }
//         }

//         DB::commit();

//         return response()->json([
//             'status' => 'success',
//             'message' => 'Customer payment details updated successfully',
//             'updated_details' => $customerPaymentDetails
//         ]);

//     } catch (Exception $e) {
//         DB::rollBack();
//         return response()->json([
//             'status' => 'fail',
//             'message' => $e->getMessage()
//         ]);
//     }
// }

//------------------------------------- main -------------------------------------


// public function CustomerPaymentDetailsUpdate(Request $request)
// {
//     DB::beginTransaction();
//     try {
//         $user_id = Auth::id();
//         $customer = Customer::findOrFail($request->input('id'));

//         $paidAmount = $request->paid_amount ?? 0;
//         $discountAmount = $request->discount_amount ?? 0;
//         $totalAvailableAmount = $paidAmount; // **Only paid amount is used to clear dues**
        
//         // Save original due amounts
//         $previousDueAmount = $customer->previous_due_amount ?? 0;
//         $originalTotalAvailable = $totalAvailableAmount; // Save for reporting later
//         $originalDiscountAmount = $discountAmount;

//         $customerPaymentDetails = null;

//         // First, handle customer's previous due
//         if ($totalAvailableAmount > 0 && $previousDueAmount > 0) {
//             if ($totalAvailableAmount >= $previousDueAmount) {
//                 $totalAvailableAmount -= $previousDueAmount;
//                 $customer->update(['previous_due_amount' => 0]);
//             } else {
//                 $customer->update(['previous_due_amount' => $previousDueAmount - $totalAvailableAmount]);
//                 $totalAvailableAmount = 0;
//             }
//         }

//         // Second, handle customer's orders
//         if ($totalAvailableAmount > 0) {
//             $dueOrders = Order::where('customer_id', $customer->id)
//                 ->where('due_amount', '>', 0)
//                 ->orderBy('created_at', 'asc')
//                 ->get();

//             foreach ($dueOrders as $order) {
//                 if ($totalAvailableAmount <= 0) {
//                     break; // No more paid money left
//                 }

//                 $orderDueBefore = $order->due_amount; // Save old due for calculating inserted amount

//                 if ($totalAvailableAmount >= $order->due_amount) {
//                     $payingNow = $order->due_amount;
//                     $totalAvailableAmount -= $order->due_amount;

//                     $order->update([
//                         'due_amount' => 0,
//                         'paid_amount' => $order->paid_amount + $payingNow,
//                     ]);

//                     OrderPaymentDetails::create([
//                         'order_id' => $order->id,
//                         'paid_amount' => $payingNow,
//                         'discount_amount' => 0,
//                         'payment_status' => 'Paid',
//                         'payment_method' => $request->payment_method,
//                         'due_collection_date' => $request->due_collection_date,
//                         'transaction_id' => $request->transaction_id ?? null,
//                         'user_id' => $user_id,
//                     ]);
//                 } else {
//                     $payingNow = $totalAvailableAmount;

//                     $order->update([
//                         'due_amount' => $order->due_amount - $payingNow,
//                         'paid_amount' => $order->paid_amount + $payingNow,
//                     ]);

//                     OrderPaymentDetails::create([
//                         'order_id' => $order->id,
//                         'paid_amount' => $payingNow,
//                         'discount_amount' => 0,
//                         'payment_status' => 'Partial Paid',
//                         'payment_method' => $request->payment_method,
//                         'due_collection_date' => $request->due_collection_date,
//                         'transaction_id' => $request->transaction_id ?? null,
//                         'user_id' => $user_id,
//                     ]);

//                     $totalAvailableAmount = 0;
//                     break;
//                 }
//             }
//         }

//         // After clearing due and orders, create CustomerPaymentDetails
//         $customerPaymentDetails = CustomerPaymentDetails::create([
//             'customer_id' => $customer->id,
//             'paid_amount' => $originalTotalAvailable, // original paid amount
//             'discount_amount' => $originalDiscountAmount, // original discount amount
//             'due_amount' => $customer->previous_due_amount, // current remaining due
//             'payment_status' => $customer->previous_due_amount == 0 ? 'Fully Paid' : 'Partial Paid',
//             'previous_due_amount' => $previousDueAmount,
//             'payment_method' => $request->payment_method,
//             'due_collection_date' => $request->due_collection_date,
//             'transaction_id' => $request->transaction_id ?? null,
//             'user_id' => $user_id,
//         ]);

//         DB::commit();

//         return response()->json([
//             'status' => 'success',
//             'message' => 'Customer payment details updated successfully',
//             'updated_details' => $customerPaymentDetails
//         ]);

//     } catch (Exception $e) {
//         DB::rollBack();
//         return response()->json([
//             'status' => 'fail',
//             'message' => $e->getMessage()
//         ]);
//     }
// }


// public function CustomerPaymentDetailsUpdate(Request $request)
// {
//     DB::beginTransaction();
//     try {
//         $user_id = Auth::id();
//         $customer = Customer::findOrFail($request->input('id'));

//         $inputPaidAmount = $request->paid_amount ?? 0;
//         $inputDiscountAmount = $request->discount_amount ?? 0;
//         $paymentMethod = $request->payment_method ?? null;
//         $dueCollectionDate = $request->due_collection_date ?? null;
//         $transactionId = $request->transaction_id ?? null;

//         $totalAvailablePaid = $inputPaidAmount;
//         $totalAvailableDiscount = $inputDiscountAmount;

//         $customerPreviousDue = $customer->previous_due_amount ?? 0;

//         // --------- Step 1: Clear Previous Due First ----------
//         if (($totalAvailablePaid + $totalAvailableDiscount) > 0 && $customerPreviousDue > 0) {
//             $totalPowerToPay = $totalAvailablePaid + $totalAvailableDiscount;

//             if ($totalPowerToPay >= $customerPreviousDue) {
//                 // Fully clear previous due
//                 $usedFromDiscount = min($totalAvailableDiscount, $customerPreviousDue);
//                 $usedFromPaid = $customerPreviousDue - $usedFromDiscount;

//                 $totalAvailableDiscount -= $usedFromDiscount;
//                 $totalAvailablePaid -= $usedFromPaid;

//                 // Update customer previous due
//                 $customer->update(['previous_due_amount' => 0]);

//                 // Insert into customer_payment_details
//                 CustomerPaymentDetails::create([
//                     'customer_id' => $customer->id,
//                     'paid_amount' => $usedFromPaid,
//                     'discount_amount' => $usedFromDiscount,
//                     'due_amount' => 0,
//                     'payment_status' => 'Fully Paid',
//                     'previous_due_amount' => $customerPreviousDue,
//                     'payment_method' => $paymentMethod,
//                     'due_collection_date' => $dueCollectionDate,
//                     'transaction_id' => $transactionId,
//                     'user_id' => $user_id,
//                 ]);
//             } else {
//                 // Partially clear previous due
//                 $usedFromDiscount = min($totalAvailableDiscount, $totalPowerToPay);
//                 $usedFromPaid = $totalPowerToPay - $usedFromDiscount;

//                 $customer->update([
//                     'previous_due_amount' => $customerPreviousDue - $totalPowerToPay
//                 ]);

//                 // Insert into customer_payment_details
//                 CustomerPaymentDetails::create([
//                     'customer_id' => $customer->id,
//                     'paid_amount' => $usedFromPaid,
//                     'discount_amount' => $usedFromDiscount,
//                     'due_amount' => $customerPreviousDue - $totalPowerToPay,
//                     'payment_status' => 'Partial Paid',
//                     'previous_due_amount' => $customerPreviousDue,
//                     'payment_method' => $paymentMethod,
//                     'due_collection_date' => $dueCollectionDate,
//                     'transaction_id' => $transactionId,
//                     'user_id' => $user_id,
//                 ]);

//                 $totalAvailableDiscount = 0;
//                 $totalAvailablePaid = 0;
//             }
//         }

//         // --------- Step 2: Clear Orders (after previous due) ----------
//         if (($totalAvailablePaid + $totalAvailableDiscount) > 0) {
//             $dueOrders = Order::where('customer_id', $customer->id)
//                 ->where('due_amount', '>', 0)
//                 ->orderBy('created_at', 'asc')
//                 ->get();

//             foreach ($dueOrders as $order) {
//                 if (($totalAvailablePaid + $totalAvailableDiscount) <= 0) {
//                     break;
//                 }

//                 $orderDue = $order->due_amount;
//                 $orderPreviousDue = $order->due_amount;

//                 $powerToPay = $totalAvailablePaid + $totalAvailableDiscount;

//                 if ($powerToPay >= $orderDue) {
//                     // Fully clear order
//                     $usedFromDiscount = min($totalAvailableDiscount, $orderDue);
//                     $usedFromPaid = $orderDue - $usedFromDiscount;

//                     $totalAvailableDiscount -= $usedFromDiscount;
//                     $totalAvailablePaid -= $usedFromPaid;

//                     $order->update([
//                         'due_amount' => 0,
//                         'paid_amount' => $order->paid_amount + $usedFromPaid,
//                     ]);

//                     OrderPaymentDetails::create([
//                         'order_id' => $order->id,
//                         'paid_amount' => $usedFromPaid,
//                         'discount_amount' => $usedFromDiscount,
//                         'payment_status' => 'Paid',
//                         'payment_method' => $paymentMethod,
//                         'due_collection_date' => $dueCollectionDate,
//                         'transaction_id' => $transactionId,
//                         'user_id' => $user_id,
//                     ]);
//                 } else {
//                     // Partially clear order
//                     $usedFromDiscount = min($totalAvailableDiscount, $powerToPay);
//                     $usedFromPaid = $powerToPay - $usedFromDiscount;

//                     $order->update([
//                         'due_amount' => $order->due_amount - ($usedFromPaid + $usedFromDiscount),
//                         'paid_amount' => $order->paid_amount + $usedFromPaid,
//                     ]);

//                     OrderPaymentDetails::create([
//                         'order_id' => $order->id,
//                         'paid_amount' => $usedFromPaid,
//                         'discount_amount' => $usedFromDiscount,
//                         'payment_status' => 'Partial Paid',
//                         'payment_method' => $paymentMethod,
//                         'due_collection_date' => $dueCollectionDate,
//                         'transaction_id' => $transactionId,
//                         'user_id' => $user_id,
//                     ]);

//                     $totalAvailableDiscount = 0;
//                     $totalAvailablePaid = 0;
//                     break;
//                 }
//             }
//         }

//         DB::commit();

//         return response()->json([
//             'status' => 'success',
//             'message' => 'Customer and order payment updated successfully.'
//         ]);

//     } catch (Exception $e) {
//         DB::rollBack();
//         return response()->json([
//             'status' => 'fail',
//             'message' => $e->getMessage()
//         ]);
//     }
// }


// public function CustomerPaymentDetailsUpdate(Request $request)
// {
//     DB::beginTransaction();
//     try {
//         $user_id = Auth::id();
//         $customer = Customer::findOrFail($request->input('id'));

//         $inputPaidAmount = $request->paid_amount ?? 0;
//         $inputDiscountAmount = $request->discount_amount ?? 0;
//         $paymentMethod = $request->payment_method ?? null;
//         $dueCollectionDate = $request->due_collection_date ?? null;
//         $transactionId = $request->transaction_id ?? null;

//         $totalAvailablePaid = $inputPaidAmount;
//         $totalAvailableDiscount = $inputDiscountAmount;

//         $customerPreviousDue = $customer->previous_due_amount ?? 0;

//         // --------- Step 1: Clear Previous Due First ----------
//         if (($totalAvailablePaid + $totalAvailableDiscount) > 0 && $customerPreviousDue > 0) {
//             $totalPowerToPay = $totalAvailablePaid + $totalAvailableDiscount;

//             if ($totalPowerToPay >= $customerPreviousDue) {
//                 // Fully clear previous due
//                 $usedFromDiscount = min($totalAvailableDiscount, $customerPreviousDue);
//                 $usedFromPaid = $customerPreviousDue - $usedFromDiscount;

//                 $totalAvailableDiscount -= $usedFromDiscount;
//                 $totalAvailablePaid -= $usedFromPaid;

//                 $customer->update(['previous_due_amount' => 0]);

//                 CustomerPaymentDetails::create([
//                     'customer_id' => $customer->id,
//                     'paid_amount' => $usedFromPaid,
//                     'discount_amount' => $usedFromDiscount,
//                     'due_amount' => 0,
//                     'payment_status' => 'Fully Paid',
//                     'previous_due_amount' => $customerPreviousDue,
//                     'payment_method' => $paymentMethod,
//                     'due_collection_date' => $dueCollectionDate,
//                     'transaction_id' => $transactionId,
//                     'user_id' => $user_id,
//                 ]);
//             } else {
//                 // Partially clear previous due
//                 $usedFromDiscount = min($totalAvailableDiscount, $totalPowerToPay);
//                 $usedFromPaid = $totalPowerToPay - $usedFromDiscount;

//                 $customer->update([
//                     'previous_due_amount' => $customerPreviousDue - $totalPowerToPay
//                 ]);

//                 CustomerPaymentDetails::create([
//                     'customer_id' => $customer->id,
//                     'paid_amount' => $usedFromPaid,
//                     'discount_amount' => $usedFromDiscount,
//                     'due_amount' => $customerPreviousDue - $totalPowerToPay,
//                     'payment_status' => 'Partial Paid',
//                     'previous_due_amount' => $customerPreviousDue,
//                     'payment_method' => $paymentMethod,
//                     'due_collection_date' => $dueCollectionDate,
//                     'transaction_id' => $transactionId,
//                     'user_id' => $user_id,
//                 ]);

//                 $totalAvailableDiscount = 0;
//                 $totalAvailablePaid = 0;
//             }
//         }

//         // --------- Step 2: Clear Orders (after previous due) ----------
//         if (($totalAvailablePaid + $totalAvailableDiscount) > 0) {
//             $dueOrders = Order::where('customer_id', $customer->id)
//                 ->where('due_amount', '>', 0)
//                 ->orderBy('created_at', 'asc')
//                 ->get();

//             $totalDueAmount = $dueOrders->sum('due_amount');

//             if ($totalDueAmount > 0) {
//                 foreach ($dueOrders as $index => $order) {
//                     if (($totalAvailablePaid + $totalAvailableDiscount) <= 0) {
//                         break;
//                     }

//                     $orderDue = $order->due_amount;

//                     $percentage = $orderDue / $totalDueAmount;

//                     $shouldPay = round($percentage * $inputPaidAmount, 2);
//                     $shouldDiscount = round($percentage * $inputDiscountAmount, 2);

//                     $payable = min($shouldPay + $shouldDiscount, $orderDue);

//                     $usedFromDiscount = min($shouldDiscount, $payable);
//                     $usedFromPaid = min($shouldPay, $payable - $usedFromDiscount);

//                     // Protect against negative available amounts
//                     $usedFromPaid = min($usedFromPaid, $totalAvailablePaid);
//                     $usedFromDiscount = min($usedFromDiscount, $totalAvailableDiscount);

//                     $order->update([
//                         'due_amount' => max(0, $order->due_amount - ($usedFromPaid + $usedFromDiscount)),
//                         'paid_amount' => $order->paid_amount + $usedFromPaid,
//                     ]);

//                     OrderPaymentDetails::create([
//                         'order_id' => $order->id,
//                         'paid_amount' => $usedFromPaid,
//                         'discount_amount' => $usedFromDiscount,
//                         'payment_status' => ($order->due_amount == 0) ? 'Paid' : 'Partial Paid',
//                         'payment_method' => $paymentMethod,
//                         'due_collection_date' => $dueCollectionDate,
//                         'transaction_id' => $transactionId,
//                         'user_id' => $user_id,
//                     ]);

//                     $totalAvailablePaid -= $usedFromPaid;
//                     $totalAvailableDiscount -= $usedFromDiscount;
//                 }
//             }
//         }

//         DB::commit();

//         return response()->json([
//             'status' => 'success',
//             'message' => 'Customer and order payment updated successfully.'
//         ]);

//     } catch (Exception $e) {
//         DB::rollBack();
//         return response()->json([
//             'status' => 'fail',
//             'message' => $e->getMessage()
//         ]);
//     }
// }


// public function  CustomerPaymentDetailsUpdate(Request $request)
// {
//     DB::beginTransaction();
//     try {
//         $user_id = Auth::id();
//         $customer = Customer::findOrFail($request->input('id'));

//         $inputPaidAmount = $request->paid_amount ?? 0;
//         $inputDiscountAmount = $request->discount_amount ?? 0;
//         $paymentMethod = $request->payment_method ?? null;
//         $dueCollectionDate = $request->due_collection_date ?? null;
//         $transactionId = $request->transaction_id ?? null;

//         $totalAvailablePaid = $inputPaidAmount;
//         $totalAvailableDiscount = $inputDiscountAmount;

//         $customerPreviousDue = $customer->previous_due_amount ?? 0;

//         // --------- Step 1: Clear Previous Due First ----------
//         if (($totalAvailablePaid + $totalAvailableDiscount) > 0 && $customerPreviousDue > 0) {
//             $totalPowerToPay = $totalAvailablePaid + $totalAvailableDiscount;

//             if ($totalPowerToPay >= $customerPreviousDue) {
//                 // Fully clear previous due
//                 $usedFromDiscount = min($totalAvailableDiscount, $customerPreviousDue);
//                 $usedFromPaid = $customerPreviousDue - $usedFromDiscount;

//                 $totalAvailableDiscount -= $usedFromDiscount;
//                 $totalAvailablePaid -= $usedFromPaid;

//                 $customer->update(['previous_due_amount' => 0]);

//                 CustomerPaymentDetails::create([
//                     'customer_id' => $customer->id,
//                     'paid_amount' => $usedFromPaid,
//                     'discount_amount' => $usedFromDiscount,
//                     'due_amount' => 0,
//                     'payment_status' => 'Fully Paid',
//                     'previous_due_amount' => $customerPreviousDue,
//                     'payment_method' => $paymentMethod,
//                     'due_collection_date' => $dueCollectionDate,
//                     'transaction_id' => $transactionId,
//                     'user_id' => $user_id,
//                 ]);
//             } else {
//                 // Partially clear previous due
//                 $usedFromDiscount = min($totalAvailableDiscount, $totalPowerToPay);
//                 $usedFromPaid = $totalPowerToPay - $usedFromDiscount;

//                 $customer->update([
//                     'previous_due_amount' => $customerPreviousDue - $totalPowerToPay
//                 ]);

//                 CustomerPaymentDetails::create([
//                     'customer_id' => $customer->id,
//                     'paid_amount' => $usedFromPaid,
//                     'discount_amount' => $usedFromDiscount,
//                     'due_amount' => $customerPreviousDue - $totalPowerToPay,
//                     'payment_status' => 'Partial Paid',
//                     'previous_due_amount' => $customerPreviousDue,
//                     'payment_method' => $paymentMethod,
//                     'due_collection_date' => $dueCollectionDate,
//                     'transaction_id' => $transactionId,
//                     'user_id' => $user_id,
//                 ]);

//                 // After partial payment, the discount amount is fully used
//                 $totalAvailableDiscount = 0;
//                 $totalAvailablePaid = 0;
//             }
//         }

//         // --------- Step 2: Clear Orders (after previous due) ----------
//         if (($totalAvailablePaid + $totalAvailableDiscount) > 0) {
//             $dueOrders = Order::where('customer_id', $customer->id)
//                 ->where('due_amount', '>', 0)
//                 ->orderBy('created_at', 'asc')
//                 ->get();

//             $totalDueAmount = $dueOrders->sum('due_amount');

//             if ($totalDueAmount > 0) {
//                 foreach ($dueOrders as $order) {
//                     if (($totalAvailablePaid + $totalAvailableDiscount) <= 0) {
//                         break;
//                     }

//                     $orderDue = $order->due_amount;
//                     $percentage = $orderDue / $totalDueAmount;

//                     // Calculate proportional share of paid and discount amounts
//                     $shouldPay = round($percentage * $inputPaidAmount, 2);
//                     $shouldDiscount = round($percentage * $inputDiscountAmount, 2);

//                     // Ensure the discount used in previous due is NOT used here
//                     $remainingDiscountForOrders = max(0, $totalAvailableDiscount);

//                     // Calculate the total payable amount (paid + discount)
//                     $payable = min($shouldPay + $remainingDiscountForOrders, $orderDue);

//                     $usedFromDiscount = min($remainingDiscountForOrders, $payable);
//                     $usedFromPaid = min($shouldPay, $payable - $usedFromDiscount);

//                     // Protect against negative available amounts
//                     $usedFromPaid = min($usedFromPaid, $totalAvailablePaid);
//                     $usedFromDiscount = min($usedFromDiscount, $remainingDiscountForOrders);

//                     $order->update([
//                         'due_amount' => max(0, $order->due_amount - ($usedFromPaid + $usedFromDiscount)),
//                         'paid_amount' => $order->paid_amount + $usedFromPaid,
//                     ]);

//                     OrderPaymentDetails::create([
//                         'order_id' => $order->id,
//                         'paid_amount' => $usedFromPaid,
//                         'discount_amount' => $usedFromDiscount,
//                         'payment_status' => ($order->due_amount == 0) ? 'Paid' : 'Partial Paid',
//                         'payment_method' => $paymentMethod,
//                         'due_collection_date' => $dueCollectionDate,
//                         'transaction_id' => $transactionId,
//                         'user_id' => $user_id,
//                     ]);

//                     // Deduct the amounts from the total available for future usage
//                     $totalAvailablePaid -= $usedFromPaid;
//                     $totalAvailableDiscount -= $usedFromDiscount;
//                 }
//             }
//         }

//         DB::commit();

//         return response()->json([
//             'status' => 'success',
//             'message' => 'Customer and order payment updated successfully.'
//         ]);

//     } catch (Exception $e) {
//         DB::rollBack();
//         return response()->json([
//             'status' => 'fail',
//             'message' => $e->getMessage()
//         ]);
//     }
// }

// public function CustomerPaymentDetailsUpdate(Request $request)
// {
//     DB::beginTransaction();
//     try {
//         $user_id = Auth::id();
//         $customer = Customer::findOrFail($request->input('id'));

//         $inputPaidAmount = $request->paid_amount ?? 0;
//         $inputDiscountAmount = $request->discount_amount ?? 0;
//         $paymentMethod = $request->payment_method ?? null;
//         $dueCollectionDate = $request->due_collection_date ?? null;
//         $transactionId = $request->transaction_id ?? null;

//         $totalAvailablePaid = $inputPaidAmount;
//         $totalAvailableDiscount = $inputDiscountAmount;

//         $customerPreviousDue = $customer->previous_due_amount ?? 0;
//         $inserted = false; // Track if we inserted any record

//         // --------- Step 1: Clear Previous Due ----------
//         if (($totalAvailablePaid + $totalAvailableDiscount) > 0 && $customerPreviousDue > 0) {
//             $totalPowerToPay = $totalAvailablePaid + $totalAvailableDiscount;

//             if ($totalPowerToPay >= $customerPreviousDue) {
//                 // Fully clear previous due
//                 $usedFromDiscount = min($totalAvailableDiscount, $customerPreviousDue);
//                 $usedFromPaid = $customerPreviousDue - $usedFromDiscount;

//                 $totalAvailableDiscount -= $usedFromDiscount;
//                 $totalAvailablePaid -= $usedFromPaid;

//                 $customer->update(['previous_due_amount' => 0]);

//                 CustomerPaymentDetails::create([
//                     'customer_id' => $customer->id,
//                     'paid_amount' => $usedFromPaid,
//                     'discount_amount' => $usedFromDiscount,
//                     'due_amount' => 0,
//                     'payment_status' => 'Fully Paid',
//                     'previous_due_amount' => $customerPreviousDue,
//                     'payment_method' => $paymentMethod,
//                     'due_collection_date' => $dueCollectionDate,
//                     'transaction_id' => $transactionId,
//                     'user_id' => $user_id,
//                 ]);

              

//                 $inserted = true;
//             } else {
//                 // Partially clear previous due
//                 $usedFromDiscount = min($totalAvailableDiscount, $totalPowerToPay);
//                 $usedFromPaid = $totalPowerToPay - $usedFromDiscount;

//                 $customer->update([
//                     'previous_due_amount' => $customerPreviousDue - $totalPowerToPay
//                 ]);

//                 CustomerPaymentDetails::create([
//                     'customer_id' => $customer->id,
//                     'paid_amount' => $usedFromPaid,
//                     'discount_amount' => $usedFromDiscount,
//                     'due_amount' => $customerPreviousDue - $totalPowerToPay,
//                     'payment_status' => 'Partial Paid',
//                     'previous_due_amount' => $customerPreviousDue,
//                     'payment_method' => $paymentMethod,
//                     'due_collection_date' => $dueCollectionDate,
//                     'transaction_id' => $transactionId,
//                     'user_id' => $user_id,
//                 ]);

                
//                 $totalAvailableDiscount = 0;
//                 $totalAvailablePaid = 0;
//                 $inserted = true;
//             }
//         }

//         // --------- Step 2: Clear Orders ----------
//         if (($totalAvailablePaid + $totalAvailableDiscount) > 0) {
//             $dueOrders = Order::where('customer_id', $customer->id)
//                 ->where('due_amount', '>', 0)
//                 ->orderBy('created_at', 'asc')
//                 ->get();

//             $totalDueAmount = $dueOrders->sum('due_amount');

//             if ($totalDueAmount > 0) {
//                 foreach ($dueOrders as $order) {
//                     if (($totalAvailablePaid + $totalAvailableDiscount) <= 0) {
//                         break;
//                     }

//                     $orderDue = $order->due_amount;
//                     $percentage = $orderDue / $totalDueAmount;

//                     // Calculate proportional amounts
//                     $shouldPay = round($percentage * $inputPaidAmount, 2);
//                     $shouldDiscount = round($percentage * $inputDiscountAmount, 2);

//                     $remainingDiscountForOrders = max(0, $totalAvailableDiscount);

//                     $payable = min($shouldPay + $remainingDiscountForOrders, $orderDue);

//                     $usedFromDiscount = min($remainingDiscountForOrders, $payable);
//                     $usedFromPaid = min($shouldPay, $payable - $usedFromDiscount);

//                     $usedFromPaid = min($usedFromPaid, $totalAvailablePaid);
//                     $usedFromDiscount = min($usedFromDiscount, $remainingDiscountForOrders);

//                     $order->update([
//                         'due_amount' => max(0, $order->due_amount - ($usedFromPaid + $usedFromDiscount)),
//                         'paid_amount' => $order->paid_amount + $usedFromPaid,
//                     ]);

//                     OrderPaymentDetails::create([
//                         'order_id' => $order->id,
//                         'paid_amount' => $usedFromPaid,
//                         'discount_amount' => $usedFromDiscount,
//                         'payment_status' => ($order->due_amount == 0) ? 'Paid' : 'Partial Paid',
//                         'payment_method' => $paymentMethod,
//                         'due_collection_date' => $dueCollectionDate,
//                         'transaction_id' => $transactionId,
//                         'user_id' => $user_id,
//                     ]);

//                     $totalAvailablePaid -= $usedFromPaid;
//                     $totalAvailableDiscount -= $usedFromDiscount;
//                     $inserted = true;
//                 }
//             }
//         }

//         // --------- Step 3: Fallback (if nothing inserted but payment exists) ----------
//         if (!$inserted && ($inputPaidAmount + $inputDiscountAmount) > 0) {
//             CustomerPaymentDetails::create([
//                 'customer_id' => $customer->id,
//                 'paid_amount' => $inputPaidAmount,
//                 'discount_amount' => $inputDiscountAmount,
//                 'due_amount' => $customer->previous_due_amount,
//                 'payment_status' => 'Paid (No due orders)',
//                 'previous_due_amount' => $customerPreviousDue,
//                 'payment_method' => $paymentMethod,
//                 'due_collection_date' => $dueCollectionDate,
//                 'transaction_id' => $transactionId,
//                 'user_id' => $user_id,
//             ]);
//         }

//         DB::commit();

//         return response()->json([
//             'status' => 'success',
//             'message' => 'Customer and order payment updated successfully.'
//         ]);

//     } catch (Exception $e) {
//         DB::rollBack();
//         return response()->json([
//             'status' => 'fail',
//             'message' => $e->getMessage()
//         ]);
//     }
// }

// public function CustomerPaymentDetailsUpdate(Request $request)
// {
//     DB::beginTransaction();
//     try {
//         $user_id = Auth::id();
//         $customer = Customer::findOrFail($request->input('id'));

//         $inputPaidAmount = $request->paid_amount ?? 0;
//         $inputDiscountAmount = $request->discount_amount ?? 0;
//         $paymentMethod = $request->payment_method ?? null;
//         $dueCollectionDate = $request->due_collection_date ?? null;
//         $transactionId = $request->transaction_id ?? null;

//         $totalAvailablePaid = $inputPaidAmount;
//         $totalAvailableDiscount = $inputDiscountAmount;

//         $customerPreviousDue = $customer->previous_due_amount ?? 0;
//         $originalPreviousDue = $customerPreviousDue;

//         $originalOrderDue = Order::where('customer_id', $customer->id)
//             ->where('due_amount', '>', 0)
//             ->sum('due_amount');

//         $ordersPaidTotal = 0;
//         $ordersDiscountTotal = 0;

//         // --------- Step 1: Clear Previous Due First ----------
//         if (($totalAvailablePaid + $totalAvailableDiscount) > 0 && $customerPreviousDue > 0) {
//             $totalPowerToPay = $totalAvailablePaid + $totalAvailableDiscount;

//             $remainingOrderDueBeforePayment = $originalOrderDue;

//             if ($totalPowerToPay >= $customerPreviousDue) {
//                 // Fully clear previous due
//                 $usedFromDiscount = min($totalAvailableDiscount, $customerPreviousDue);
//                 $usedFromPaid = $customerPreviousDue - $usedFromDiscount;

//                 $totalAvailableDiscount -= $usedFromDiscount;
//                 $totalAvailablePaid -= $usedFromPaid;

//                 $customer->update(['previous_due_amount' => 0]);

//                 $remainingOrderDueAfterPayment = Order::where('customer_id', $customer->id)
//                     ->where('due_amount', '>', 0)
//                     ->sum('due_amount');

//                 $totalRemainingDue = $remainingOrderDueAfterPayment;

//                 CustomerPaymentDetails::create([
//                     'customer_id' => $customer->id,
//                     'paid_amount' => $usedFromPaid,
//                     'discount_amount' => $usedFromDiscount,
//                     'due_amount' => $totalRemainingDue, // previous due cleared, so only orders remain
//                     'payment_status' => ($totalRemainingDue == 0) ? 'Fully Paid' : 'Partial Paid',
//                     'previous_due_amount' => $originalPreviousDue,
//                     'payment_method' => $paymentMethod,
//                     'due_collection_date' => $dueCollectionDate,
//                     'transaction_id' => $transactionId,
//                     'user_id' => $user_id,
//                 ]);
//             } else {
//                 // Partially clear previous due
//                 $usedFromDiscount = min($totalAvailableDiscount, $totalPowerToPay);
//                 $usedFromPaid = $totalPowerToPay - $usedFromDiscount;

//                 $customer->update([
//                     'previous_due_amount' => $customerPreviousDue - $totalPowerToPay
//                 ]);

//                 $remainingPreviousDueAfterPayment = $customerPreviousDue - $totalPowerToPay;
//                 $remainingOrderDueAfterPayment = Order::where('customer_id', $customer->id)
//                     ->where('due_amount', '>', 0)
//                     ->sum('due_amount');

//                 $totalRemainingDue = $remainingPreviousDueAfterPayment + $remainingOrderDueAfterPayment;

//                 CustomerPaymentDetails::create([
//                     'customer_id' => $customer->id,
//                     'paid_amount' => $usedFromPaid,
//                     'discount_amount' => $usedFromDiscount,
//                     'due_amount' => $totalRemainingDue, // previous + orders
//                     'payment_status' => 'Partial Paid',
//                     'previous_due_amount' => $originalPreviousDue,
//                     'payment_method' => $paymentMethod,
//                     'due_collection_date' => $dueCollectionDate,
//                     'transaction_id' => $transactionId,
//                     'user_id' => $user_id,
//                 ]);

//                 $totalAvailableDiscount = 0;
//                 $totalAvailablePaid = 0;
//             }
//         }

//         // --------- Step 2: Clear Orders (after previous due) ----------
//         if (($totalAvailablePaid + $totalAvailableDiscount) > 0) {
//             $dueOrders = Order::where('customer_id', $customer->id)
//                 ->where('due_amount', '>', 0)
//                 ->orderBy('created_at', 'asc')
//                 ->get();

//             $totalDueAmount = $dueOrders->sum('due_amount');

//             if ($totalDueAmount > 0) {
//                 foreach ($dueOrders as $order) {
//                     if (($totalAvailablePaid + $totalAvailableDiscount) <= 0) {
//                         break;
//                     }

//                     $orderDue = $order->due_amount;
//                     $percentage = $orderDue / $totalDueAmount;

//                     $shouldPay = round($percentage * $inputPaidAmount, 2);
//                     $shouldDiscount = round($percentage * $inputDiscountAmount, 2);

//                     $remainingDiscountForOrders = max(0, $totalAvailableDiscount);

//                     $payable = min($shouldPay + $remainingDiscountForOrders, $orderDue);

//                     $usedFromDiscount = min($remainingDiscountForOrders, $payable);
//                     $usedFromPaid = min($shouldPay, $payable - $usedFromDiscount);

//                     $usedFromPaid = min($usedFromPaid, $totalAvailablePaid);
//                     $usedFromDiscount = min($usedFromDiscount, $remainingDiscountForOrders);

//                     $order->update([
//                         'due_amount' => max(0, $order->due_amount - ($usedFromPaid + $usedFromDiscount)),
//                         'paid_amount' => $order->paid_amount + $usedFromPaid,
//                     ]);

//                     OrderPaymentDetails::create([
//                         'order_id' => $order->id,
//                         'paid_amount' => $usedFromPaid,
//                         'discount_amount' => $usedFromDiscount,
//                         'payment_status' => ($order->due_amount == 0) ? 'Paid' : 'Partial Paid',
//                         'payment_method' => $paymentMethod,
//                         'due_collection_date' => $dueCollectionDate,
//                         'transaction_id' => $transactionId,
//                         'user_id' => $user_id,
//                     ]);

//                     $totalAvailablePaid -= $usedFromPaid;
//                     $totalAvailableDiscount -= $usedFromDiscount;

//                     $ordersPaidTotal += $usedFromPaid;
//                     $ordersDiscountTotal += $usedFromDiscount;
//                 }

//                 // Insert summary CustomerPaymentDetails for orders
//                 if ($ordersPaidTotal > 0 || $ordersDiscountTotal > 0) {
//                     $remainingPreviousDue = $customer->previous_due_amount;
//                     $remainingOrderDue = Order::where('customer_id', $customer->id)
//                         ->where('due_amount', '>', 0)
//                         ->sum('due_amount');

//                     $totalRemainingDue = $remainingPreviousDue + $remainingOrderDue;

//                     $paymentStatus = ($totalRemainingDue == 0) ? 'Fully Paid' : 'Partial Paid';

//                     CustomerPaymentDetails::create([
//                         'customer_id' => $customer->id,
//                         'paid_amount' => $ordersPaidTotal,
//                         'discount_amount' => $ordersDiscountTotal,
//                         'due_amount' => $totalRemainingDue, // previous + order due after order payments
//                         'payment_status' => $paymentStatus,
//                         'previous_due_amount' => $originalPreviousDue,
//                         'payment_method' => $paymentMethod,
//                         'due_collection_date' => $dueCollectionDate,
//                         'transaction_id' => $transactionId,
//                         'user_id' => $user_id,
//                     ]);
//                 }
//             }
//         }

//         DB::commit();

//         return response()->json([
//             'status' => 'success',
//             'message' => 'Customer and order payment updated successfully.'
//         ]);
//     } catch (Exception $e) {
//         DB::rollBack();
//         return response()->json([
//             'status' => 'fail',
//             'message' => $e->getMessage()
//         ]);
//     }
// }






public function CustomerPaymentDetailsUpdate(Request $request)
{
    DB::beginTransaction();
    try {
        $user_id = Auth::id() ?? 1;
        $cId = $request->input('customer_id') ?? $request->input('id');
        $customer = Customer::findOrFail($cId);

        $inputPaidAmount     = $request->paid_amount ?? 0;
        $inputDiscountAmount = $request->discount_amount ?? 0;
        $paymentMethod       = $request->payment_method ?? null;
        $dueCollectionDate   = $request->due_collection_date ?? $request->collection_date ?? date('Y-m-d');
        $transactionId       = $request->transaction_id ?? null;
        $collectionType      = $request->collection_type ?? 'all'; // 'all', 'previous', 'invoice'

        $totalAvailablePaid     = $inputPaidAmount;
        $totalAvailableDiscount = $inputDiscountAmount;

        // পেমেন্টের আগে কাস্টমারের পুরানো ডিউ কত ছিল?
        $customerPreviousDue = $customer->previous_due_amount ?? 0;

        $ordersPaidTotal     = 0;
        $ordersDiscountTotal = 0;

        // Step 1: পুরানো ডিউ (Previous Due) ক্লিয়ার করা ('all' অথবা 'previous' মোডে)
        if (($collectionType === 'all' || $collectionType === 'previous') && ($totalAvailablePaid + $totalAvailableDiscount) > 0 && $customerPreviousDue > 0) {
            $totalPowerToPay = $totalAvailablePaid + $totalAvailableDiscount;

            if ($totalPowerToPay >= $customerPreviousDue) {
                // পুরো পুরানো ডিউ ক্লিয়ার হবে
                $usedFromDiscount = min($totalAvailableDiscount, $customerPreviousDue);
                $usedFromPaid     = $customerPreviousDue - $usedFromDiscount;

                $totalAvailableDiscount -= $usedFromDiscount;
                $totalAvailablePaid     -= $usedFromPaid;

                $customer->update(['previous_due_amount' => 0]);

                $remainingOrderDue = Order::where('customer_id', $customer->id)
                    ->where('due_amount', '>', 0)
                    ->sum('due_amount');
                $totalRemainingDue = $remainingOrderDue;

                CustomerPaymentDetails::create([
                    'customer_id'         => $customer->id,
                    'paid_amount'         => $usedFromPaid,
                    'discount_amount'     => $usedFromDiscount,
                    'due_amount'          => $totalRemainingDue,
                    'payment_status'      => $totalRemainingDue == 0 ? 'Fully Paid' : 'Partial Paid',
                    'previous_due_amount' => $usedFromPaid + $usedFromDiscount,
                    'payment_method'      => $paymentMethod,
                    'due_collection_date' => $dueCollectionDate,
                    'transaction_id'      => $transactionId,
                    'user_id'             => $user_id,
                ]);
            } else {
                // আংশিক পুরানো ডিউ ক্লিয়ার হবে
                $usedAmount = $totalPowerToPay;

                $paidRatio        = $totalPowerToPay > 0 ? ($totalAvailablePaid / $totalPowerToPay) : 0;
                $usedFromPaid     = round($usedAmount * $paidRatio, 2);
                $usedFromDiscount = $usedAmount - $usedFromPaid;

                $customer->update([
                    'previous_due_amount' => $customerPreviousDue - $usedAmount
                ]);

                $totalAvailableDiscount = 0;
                $totalAvailablePaid     = 0;

                $remainingPreviousDue = $customerPreviousDue - $usedAmount;
                $remainingOrderDue    = Order::where('customer_id', $customer->id)
                    ->where('due_amount', '>', 0)
                    ->sum('due_amount');
                $totalRemainingDue    = $remainingPreviousDue + $remainingOrderDue;

                CustomerPaymentDetails::create([
                    'customer_id'         => $customer->id,
                    'paid_amount'         => $usedFromPaid,
                    'discount_amount'     => $usedFromDiscount,
                    'due_amount'          => $totalRemainingDue,
                    'payment_status'      => 'Partial Paid',
                    'previous_due_amount' => $usedAmount,
                    'payment_method'      => $paymentMethod,
                    'due_collection_date' => $dueCollectionDate,
                    'transaction_id'      => $transactionId,
                    'user_id'             => $user_id,
                ]);
            }
        }

        // Step 2: নতুন অর্ডারের ডিউ ক্লিয়ার (FIFO) ('all' অথবা 'invoice' মোডে)
        if (($collectionType === 'all' || $collectionType === 'invoice') && ($totalAvailablePaid + $totalAvailableDiscount) > 0) {
            $dueOrders = Order::where('customer_id', $customer->id)
                ->where('due_amount', '>', 0)
                ->orderBy('created_at', 'asc')
                ->get();

            foreach ($dueOrders as $order) {
                $availableToPay = $totalAvailablePaid + $totalAvailableDiscount;
                if ($availableToPay <= 0) break;

                $orderDue    = $order->due_amount;
                $amountToPay = min($availableToPay, $orderDue);

                $totalInput     = $inputPaidAmount + $inputDiscountAmount;
                $paidRatio      = $totalInput > 0 ? ($inputPaidAmount / $totalInput) : 1;
                $discountRatio  = 1 - $paidRatio;

                $usedFromDiscount = min($totalAvailableDiscount, round($amountToPay * $discountRatio, 2));
                $usedFromPaid     = $amountToPay - $usedFromDiscount;
                $usedFromPaid     = min($usedFromPaid, $totalAvailablePaid);

                $totalUsed = $usedFromPaid + $usedFromDiscount;
                if ($totalUsed > $amountToPay) {
                    $diff = $totalUsed - $amountToPay;
                    $usedFromPaid -= $diff;
                }

                $order->update([
                    'due_amount'  => max(0, $order->due_amount - ($usedFromPaid + $usedFromDiscount)),
                    'paid_amount' => $order->paid_amount + $usedFromPaid,
                ]);

                if ($usedFromPaid > 0 || $usedFromDiscount > 0) {
                    $remainingDue = max(0, $order->fresh()->due_amount);
                    $paymentStatus = $remainingDue == 0 ? 'Paid' : 'Partial Paid';

                    OrderPaymentDetails::create([
                        'order_id'             => $order->id,
                        'paid_amount'          => $usedFromPaid,
                        'discount_amount'      => $usedFromDiscount,
                        'payment_status'       => $paymentStatus,
                        'payment_method'       => $paymentMethod,
                        'due_collection_date'  => $dueCollectionDate,
                        'transaction_id'       => $transactionId,
                        'user_id'              => $user_id,
                    ]);
                }

                $totalAvailablePaid     -= $usedFromPaid;
                $totalAvailableDiscount -= $usedFromDiscount;

                $ordersPaidTotal     += $usedFromPaid;
                $ordersDiscountTotal += $usedFromDiscount;
            }

            // সামারি এন্ট্রি (শুধু অর্ডারের পেমেন্ট)
            if ($ordersPaidTotal > 0 || $ordersDiscountTotal > 0) {
                $remainingPreviousDue = $customer->previous_due_amount;
                $remainingOrderDue    = Order::where('customer_id', $customer->id)
                    ->where('due_amount', '>', 0)
                    ->sum('due_amount');

                $totalRemainingDue = $remainingPreviousDue + $remainingOrderDue;

                CustomerPaymentDetails::create([
                    'customer_id'         => $customer->id,
                    'paid_amount'         => $ordersPaidTotal,
                    'discount_amount'     => $ordersDiscountTotal,
                    'due_amount'          => $totalRemainingDue,
                    'payment_status'      => $totalRemainingDue == 0 ? 'Fully Paid' : 'Partial Paid',
                    'previous_due_amount' => 0, // নতুন অর্ডারের পেমেন্ট → পুরানো ডিউ না
                    'payment_method'      => $paymentMethod,
                    'due_collection_date' => $dueCollectionDate,
                    'transaction_id'      => $transactionId,
                    'user_id'             => $user_id,
                ]);
            }
        }

        DB::commit();

        return response()->json([
            'status'  => 'success',
            'message' => 'Customer payment updated successfully.'
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
