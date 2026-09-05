<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\OrderPaymentDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Include the Log facade


class InvoiceController extends Controller
{

    public function InvoicePrintReceipt()
{
    try {
        $latestOrderPaymentDetails = OrderPaymentDetails::with('order.customer', 'order.details.product')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$latestOrderPaymentDetails) {
            return response()->json(['error' => 'No order payment details found']);
        }

        $orderId = $latestOrderPaymentDetails->order_id;
        $order   = Order::with('customer', 'details.product', 'user')->find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found']);
        }

        $customer = $order->customer;

        // এই কাস্টমারের এই অর্ডার বাদ দিয়ে বাকি সব অর্ডারের due_amount এর যোগফল
        $previousOrdersDue = Order::where('customer_id', $customer->id)
            ->where('id', '!=', $orderId)
            ->sum('due_amount');

        // কাস্টমার টেবিলের previous_due_amount + আগের অর্ডারগুলোর due = প্রকৃত previous due
        $actualPreviousDue = ($customer->previous_due_amount ?? 0) + $previousOrdersDue;

        $responseData = [
            'id'                 => $orderId,
            'order_no'            => $order->order_no,
            'invoice_date'        => $order->created_at->format('d-m-Y'),
            'invoice_time'        => $order->created_at->format('h:i:s A'),
            'operator_name'       => $order->user->name ?? 'N/A',
            'payment_status'      => $latestOrderPaymentDetails->payment_status,
            'total_cost'          => $order->total_cost,
            'sub_total'           => $order->sub_total,
            'discount_amount'     => $order->discount_amount,
            'paid_amount'         => $order->paid_amount,
            'due_amount'          => $order->due_amount, // এই অর্ডারের বাকি
            'previous_due_amount' => $actualPreviousDue,  // এখানে নতুন ক্যালকুলেটেড মান
            'total_due_amount'    => $actualPreviousDue + $order->due_amount, // ঐচ্ছিক: মোট বাকি
            'order_note'          => $order->order_note,
            'payment_method'      => $latestOrderPaymentDetails->payment_method,
            'transaction_id'      => $latestOrderPaymentDetails->transaction_id,
            'customer'            => [
                'id'            => $customer->id,
                'customer_name' => $customer->customer_name,
                'quantity'      => $order->quantity,
                'mobile'        => $customer->mobile,
                'address'       => $customer->address,
            ],
            'order_details' => $order->details->map(function ($detail) {
                $codes = json_decode($detail->product->product_code ?? '[]', true);
                $code = is_array($codes) ? ($codes[0] ?? 'N/A') : ($detail->product->product_code ?? 'N/A');
                return [
                    'product_name'   => $detail->product->product_name ?? 'N/A',
                    'product_code'   => $code,
                    'imei'           => $detail->product->imei_no ?? 'N/A',
                    'quantity'       => $detail->quantity,
                    'selling_price'  => $detail->selling_price,
                    'price'          => $detail->price
                ];
            })->toArray(),
        ];

        return response()->json($responseData);

    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

// public function InvoicePrintReceipt()
// {
//     try {
//         $latestOrderPaymentDetails = OrderPaymentDetails::with('order.customer', 'order.details.product')
//             ->orderBy('created_at', 'desc')
//             ->first();

//         if (!$latestOrderPaymentDetails) {
//             return response()->json(['error' => 'No order payment details found']);
//         }

//         $orderId = $latestOrderPaymentDetails->order_id;
//         $order = Order::with('customer', 'details.product')->find($orderId);

//         if (!$order) {
//             return response()->json(['error' => 'Order not found']);
//         }

//         $responseData = [
//             'id' => $orderId,
//             'order_no' => $order->order_no,
//             'invoice_date' => $order->created_at->format('d-m-Y'),
//             'payment_status' => $latestOrderPaymentDetails->payment_status,
//             'total_cost' => $order->total_cost,
//             'sub_total' => $order->sub_total,
//             'discount_amount' => $order->discount_amount,
//             'paid_amount' => $order->paid_amount,
//             'due_amount' => $order->due_amount,
//             'previous_due_amount' => $order->previous_due_amount,
//             'order_note' => $order->order_note,
//             'payment_method' => $latestOrderPaymentDetails->payment_method,
//             'transaction_id' => $latestOrderPaymentDetails->transaction_id,
//             'customer' => [
//                 'id' => $order->customer->id,
//                 'customer_name' => $order->customer->customer_name,
//                 'quantity' => $order->quantity,
//                 'mobile' => $order->customer->mobile,
//                 'address' => $order->customer->address,
//             ],
//             'order_details' => $order->details->map(function ($detail) {
//                 return [
//                     'product_name' => $detail->product->product_name ?? 'N/A',
//                     'imei' => $detail->product->imei_no ?? 'N/A',
//                     'quantity' => $detail->quantity,
//                     'selling_price' => $detail->selling_price,
//                     'price' => $detail->price
//                 ];
//             })->toArray(),
//         ];

//         return response()->json($responseData);

//     } catch (Exception $e) {
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// }

public function InvoiceOrderDuePaymentDetails(Request $request)
{
    try {
        // Get the start and end dates from the request, if provided
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Build the query with date filtering if both dates are provided
        $query = Order::with('customer:id,customer_name,customer_id,mobile', 'productReturns') // Include returns and customer details
            ->select(['id', 'order_no', 'sub_total', 'discount_amount', 'paid_amount', 'due_amount', 'customer_id', 'created_at']);

        // Apply date filters if both dates are provided and are in valid format
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Order the results by the most recent `created_at` date
        $query->orderBy('created_at', 'DESC');

        // Get the results
        $InvoicePaymentDetails = $query->get()->map(function ($order) {
            // Calculate the total return amount for each order
            $order->total_return_amount = $order->productReturns->sum('amount');
            return $order;
        });

        // Filter orders with due amount greater than 0
        $InvoicePaymentDetails = $InvoicePaymentDetails->filter(function ($order) {
            return $order->due_amount > 0;
        });

        // Ensure that the response contains the correct data
        return response()->json(['status' => 'success', 'InvoicePaymentDetails' => $InvoicePaymentDetails->toArray()]);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}





// public function InvoiceOrderPaymentDetails(Request $request)
// {
//     try {
//         // Get the start and end dates from the request, if provided
//         $startDate = $request->query('start_date');
//         $endDate = $request->query('end_date');

//         // Build the query with date filtering if both dates are provided
//         $query = Order::with('customer:id,customer_name,customer_id,mobile','', 'productReturns') // Include returns and customer details
//             ->select(['id', 'order_no', 'sub_total', 'discount_amount', 'paid_amount', 'due_amount', 'customer_id', 'created_at']);

//         // Apply date filters if both dates are provided and are in valid format
//         if ($startDate && $endDate) {
//             $startDate = Carbon::parse($startDate)->startOfDay();
//             $endDate = Carbon::parse($endDate)->endOfDay();
//             $query->whereBetween('created_at', [$startDate, $endDate]);
//         }

//         // Order the results by the most recent `created_at` date
//         $query->orderBy('created_at', 'DESC');

//         // Get the results
//         $InvoicePaymentDetails = $query->get()->map(function ($order) {
//             // Calculate the total return amount for each order
//             $order->total_return_amount = $order->productReturns->sum('amount');
//             return $order;
//         });

//         // Ensure that the response contains the correct data
//         return response()->json(['status' => 'success', 'InvoicePaymentDetails' => $InvoicePaymentDetails->toArray()]);
//     } catch (Exception $e) {
//         return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
//     }
// }



public function InvoiceOrderPaymentDetails(Request $request)
{
    try {
        // Get the start and end dates from the request, if provided
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Build the query with date filtering if both dates are provided
        $query = Order::with([
            'customer:id,customer_name,customer_id,mobile',
            'productReturns',
            'user:id,name' // Load the user's name
        ])->select([
            'id', 'order_no', 'sub_total', 'discount_amount', 'paid_amount',
            'due_amount', 'customer_id', 'user_id', 'invoice_date'
        ]);

        // Apply date filters if both dates are provided and are in valid format
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('invoice_date', [$startDate, $endDate]);
        }

        // Order the results by the most recent `created_at` date
        $query->orderBy('invoice_date', 'DESC');

        // Get the results
        $InvoicePaymentDetails = $query->get()->map(function ($order) {
            // Calculate the total return amount for each order
            $order->total_return_amount = $order->productReturns->sum('amount');
            return $order;
        });

        // Return JSON response with data
        return response()->json([
            'status' => 'success',
            'InvoicePaymentDetails' => $InvoicePaymentDetails->toArray()
        ]);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}


public function InvoicePaymentDetailsByID(Request $request)
{
    try {
        $user_id = Auth::id();

        $request->validate([
            "id" => 'required|string'
        ]);

        $order = Order::with('customer', 'details', 'payment')
                      ->where('id', $request->input('id'))
                      ->first();

        if (!$order) {
            return response()->json(['status' => 'fail', 'message' => 'Order not found.']);
        }

        return response()->json(['status' => 'success', 'rows' => $order]);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}



// public function InvoicePaymentDetailsUpdate(Request $request)
// {
//     try {
//         $user_id = Auth::id();

//         $orderPaymentDetails = Order::find($request->input('id'));

//         // Update the Order table with new paid_amount and due_amount
//         $newPaidAmount = $orderPaymentDetails->paid_amount + $request->paid_amount;

//         $orderPaymentDetails->paid_amount = $newPaidAmount;
//         $orderPaymentDetails->due_amount = $request->due_amount;
//         $orderPaymentDetails->save(); // Save the updated order

//         // Create new OrderPaymentDetails record
//         $newOrderPaymentDetails = new OrderPaymentDetails();
//         $newOrderPaymentDetails->order_id = $orderPaymentDetails->id;
//         $newOrderPaymentDetails->paid_amount = $request->paid_amount;
//         $newOrderPaymentDetails->discount_amount = $request->discount_amount;
//         $newOrderPaymentDetails->payment_status = $request->payment_status;
//         $newOrderPaymentDetails->user_id = $user_id;
//         $newOrderPaymentDetails->transaction_id = $request->transaction_id;
//         $newOrderPaymentDetails->payment_method = $request->payment_method;
//         $newOrderPaymentDetails->save();

//         return response()->json([
//             'status' => 'success',
//             'message' => 'Order payment details updated successfully',
//             'updated_order' => $orderPaymentDetails, // Return the updated order details
//             'updated_id' => $newOrderPaymentDetails->id
//         ]);
//     } catch (Exception $e) {
//         return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
//     }
// }



public function InvoicePaymentDetailsUpdate(Request $request)
{
    try {
        $user_id = Auth::id();

        // Validate request data
        $validatedData = $request->validate([
            'id' => 'required|exists:orders,id',
            'paid_amount' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'payment_status' => 'required|string|max:50',
            'due_collection_date' => 'nullable|date',
            'payment_method' => 'required|string|max:50',
            'transaction_id' => 'nullable|string|max:100',
        ]);

        // Fetch the order details
        $orderPaymentDetails = Order::findOrFail($validatedData['id']);

        // Ensure null values do not cause errors
        $currentPaidAmount = $orderPaymentDetails->paid_amount ?? 0;
        $currentDueAmount = $orderPaymentDetails->due_amount ?? 0;

        // Get the new payment and discount amounts
        $paidAmount = $validatedData['paid_amount'];
        $discountAmount = $validatedData['discount_amount'] ?? 0;

        // Ensure discount does not exceed due amount
        $applicableDiscount = min($discountAmount, $currentDueAmount);

        // Calculate new paid and due amounts
        $newPaidAmount = $currentPaidAmount + $paidAmount;
        $newDueAmount = max(0, $currentDueAmount - $paidAmount - $applicableDiscount);

        // Update Order table
        $orderPaymentDetails->update([
            'paid_amount' => $newPaidAmount,
            'due_amount' => $newDueAmount,
        ]);

        // Create new OrderPaymentDetails record
        $newOrderPaymentDetails = OrderPaymentDetails::create([
            'order_id' => $orderPaymentDetails->id,
            'paid_amount' => $paidAmount,
            'discount_amount' => $applicableDiscount,
            'due_amount' => $newDueAmount,
            'payment_status' => $validatedData['payment_status'],
            'due_collection_date' => $validatedData['due_collection_date'],
            'user_id' => $user_id,
            'transaction_id' => $validatedData['transaction_id'],
            'payment_method' => $validatedData['payment_method'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order payment details updated successfully',
            'updated_order' => $orderPaymentDetails,
            'updated_id' => $newOrderPaymentDetails->id
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'fail',
            'message' => 'An error occurred: ' . $e->getMessage()
        ], 500);
    }
}



// public function InvoiceShowDetails($id)
// {
//     $invoice = Order::with(['customer','user', 'details', 'payment'])->findOrFail($id);

//     // Calculate the total amount, paid amount, and due amount
//     $subTotal = $invoice->details->sum(function($orderDetail) {
//         return $orderDetail->price * $orderDetail->quantity;
//     });

//     $paidAmount = $invoice->payment ? $invoice->payment->paid_amount : 0;
//     $dueAmount = $subTotal - $paidAmount;

//     // Pass the calculated values to the view
//     return view('backend.view-invoice.due-invoice-print', compact('invoice', 'subTotal', 'paidAmount', 'dueAmount'));
// }

public function InvoiceShowDetails($id)
{
    $invoice = Order::with(['customer', 'details.product', 'payment'])->findOrFail($id);

    // শুধু ডাটাবেস থেকে নিবে, কোনো ক্যালকুলেশন না
    $currentDue = $invoice->due_amount ?? 0;

    // আগের সব অর্ডারের due_amount (এই অর্ডারের আগের সময় পর্যন্ত)
    $previousOrdersDue = Order::where('customer_id', $invoice->customer_id)
        ->where('id', '!=', $invoice->id)
        ->where('created_at', '<', $invoice->created_at)
        ->sum('due_amount');

    $customerPreviousDue = $invoice->customer->previous_due_amount ?? 0;
    $actualPreviousDue   = $customerPreviousDue + $previousOrdersDue;
    $totalDue            = $actualPreviousDue + $currentDue;

    return view('backend.view-invoice.due-invoice-print', compact(
        'invoice',
        'currentDue',
        'actualPreviousDue',
        'totalDue'
    ));
}


// API endpoint to fetch invoice details by ID
public function getInvoiceDetailsById(Request $request)
{
    $invoiceId = $request->input('id');

    // Fetch the invoice with related customer and order details
    $invoice = Order::with(['customer', 'details', 'payment'])
                    ->where('id', $invoiceId)
                    ->firstOrFail();

    // Get the payment details for the invoice
    $paymentDetails = $invoice->payment;

    // Calculate the subtotal by multiplying price and quantity for each order detail
    $subTotal = $invoice->details->sum(function($orderDetail) {
        return $orderDetail->price * $orderDetail->quantity;
    });

    // Get the paid amount from payment details (if available)
    $paidAmount = $paymentDetails ? $paymentDetails->paid_amount : 0;

    // Calculate the due amount
    $dueAmount = $subTotal - $paidAmount;

    return response()->json([
        'status' => 'success',
        'rows' => [
            'order_no' => $invoice->order_no,
            'created_at' => $invoice->created_at,
            'customer' => $invoice->customer,
            'order_details' => $invoice->details,
            'sub_total' => $subTotal,
            'paid_amount' => $paidAmount,
            'due_amount' => $dueAmount,
        ]
    ]);
}

public function getInvoiceFullDetailsById(Request $request)
{
    try {
        $id = $request->input('id');
        $order = Order::with(['customer', 'user', 'details.product'])->findOrFail($id);

        $formattedDetails = $order->details->map(function($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->product_name ?? 'N/A',
                'product_code' => $item->product->product_code ?? '',
                'cost_price' => $item->price ?? ($item->product->cost_price ?? 0),
                'selling_price' => $item->selling_price ?? ($item->product->sell_price ?? 0),
                'quantity' => $item->quantity,
                'total_price' => $item->selling_price * $item->quantity,
            ];
        });

        return response()->json([
            'status' => 'success',
            'rows' => [
                'id' => $order->id,
                'order_no' => $order->order_no,
                'sub_total' => $order->sub_total,
                'paid_amount' => $order->paid_amount,
                'discount_amount' => $order->discount_amount,
                'due_amount' => $order->due_amount,
                'order_note' => $order->order_note,
                'customer_id' => $order->customer_id,
                'invoice_date' => $order->invoice_date ?? ($order->created_at ? $order->created_at->format('Y-m-d') : ''),
                'customer' => $order->customer,
                'details' => $formattedDetails,
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
    }
}

public function updateInvoiceDetails(Request $request)
{
    DB::beginTransaction();
    try {
        $id = $request->input('id');
        $order = Order::with('details')->findOrFail($id);
        $user_id = Auth::id();

        // 1. Process Product Items array from request
        $itemsRaw = $request->input('items');
        $items = is_array($itemsRaw) ? $itemsRaw : json_decode($itemsRaw, true);
        if (!is_array($items)) {
            $items = [];
        }

        // Restore old stock for previous order details
        foreach ($order->details as $oldDetail) {
            $product = Product::find($oldDetail->product_id);
            if ($product) {
                $product->increment('quantity', $oldDetail->quantity);
            }
        }

        // Delete old order details
        OrderDetails::where('order_id', $order->id)->delete();

        // Re-create order details and deduct new stock
        $calculatedSubTotal = 0;
        foreach ($items as $item) {
            $productId = intval($item['product_id']);
            $qty = floatval($item['quantity']);
            $sellingPrice = floatval($item['selling_price']);
            $costPrice = floatval($item['cost_price'] ?? 0);

            if ($productId <= 0 || $qty <= 0) continue;

            $itemSubTotal = $sellingPrice * $qty;
            $calculatedSubTotal += $itemSubTotal;

            // Create OrderDetail
            OrderDetails::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $qty,
                'price' => $costPrice,
                'selling_price' => $sellingPrice,
                'user_id' => $user_id,
            ]);

            // Deduct stock for product
            $product = Product::find($productId);
            if ($product) {
                $product->decrement('quantity', $qty);
            }
        }

        $subTotal = floatval($request->input('sub_total', $calculatedSubTotal));
        if ($subTotal <= 0) {
            $subTotal = $calculatedSubTotal;
        }

        $discountAmount = floatval($request->input('discount_amount', 0));
        $paidAmount = floatval($request->input('paid_amount', 0));
        $dueAmount = max(0, $subTotal - $discountAmount - $paidAmount);
        $invoiceDate = $request->input('invoice_date');

        $order->sub_total = $subTotal;
        $order->discount_amount = $discountAmount;
        $order->paid_amount = $paidAmount;
        $order->due_amount = $dueAmount;
        $order->order_note = $request->input('order_note');

        if ($request->filled('customer_id')) {
            $order->customer_id = $request->input('customer_id');
        }
        if ($invoiceDate) {
            $order->invoice_date = $invoiceDate;
            $order->created_at = Carbon::parse($invoiceDate);
        }
        $order->save();

        // Delete previous payment details records for this order to prevent duplicate payment history
        OrderPaymentDetails::where('order_id', $order->id)->delete();

        $paymentStatus = $dueAmount <= 0 ? 'Fully Paid' : ($paidAmount > 0 ? 'Partial Paid' : 'Unpaid');

        OrderPaymentDetails::create([
            'order_id' => $order->id,
            'paid_amount' => $paidAmount,
            'discount_amount' => $discountAmount,
            'payment_status' => $paymentStatus,
            'payment_method' => 'Cash',
            'due_collection_date' => $invoiceDate ?? now(),
            'user_id' => $user_id,
        ]);

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Invoice and product items updated successfully!'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error("Invoice Update Error: " . $e->getMessage());
        return response()->json([
            'status' => 'fail',
            'message' => 'Failed to update invoice: ' . $e->getMessage()
        ], 500);
    }
}

}









