<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\OrderPaymentDetails;
use App\Models\Product;
use App\Models\ProductReturn;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class InvoiceController extends Controller
{

    public function InvoicePrintReceipt(Request $request)
    {
        try {
            $invoiceId = $request->query('id');

            if ($invoiceId) {
                $order = Order::with('customer', 'details.product', 'user')->find($invoiceId);
                if (!$order) {
                    return response()->json(['status' => 'error', 'message' => 'Order not found']);
                }
                $latestOrderPaymentDetails = OrderPaymentDetails::where('order_id', $order->id)
                    ->orderBy('created_at', 'desc')
                    ->first();
            } else {
                // fallback: latest order
                $latestOrderPaymentDetails = OrderPaymentDetails::with('order.customer', 'order.details.product')
                    ->orderBy('created_at', 'desc')
                    ->first();
                if (!$latestOrderPaymentDetails) {
                    return response()->json(['status' => 'error', 'message' => 'No order found']);
                }
                $order = Order::with('customer', 'details.product', 'user')->find($latestOrderPaymentDetails->order_id);
                if (!$order) {
                    return response()->json(['status' => 'error', 'message' => 'Order not found']);
                }
            }

            $customer = $order->customer;

            $previousOrdersDue = Order::where('customer_id', $customer->id)
                ->where('id', '!=', $order->id)
                ->sum('due_amount');

            $actualPreviousDue = ($customer->previous_due_amount ?? 0) + $previousOrdersDue;

            $details = $order->details->map(function ($detail) {
                $qty   = (float) ($detail->quantity ?? 0);
                $price = (float) ($detail->selling_price ?? $detail->price ?? 0);
                return [
                    'product_name'  => $detail->product->product_name ?? 'N/A',
                    'quantity'      => $qty,
                    'price'         => $price,
                    'total'         => $price * $qty,
                ];
            })->toArray();

            $rows = [
                'id'                  => $order->id,
                'order_no'            => $order->order_no,
                'invoice_date'        => $order->invoice_date ?? $order->created_at->format('d-m-Y'),
                'order_note'          => $order->order_note,
                'sub_total'           => $order->sub_total,
                'discount_amount'     => $order->discount_amount,
                'discount_type'       => $order->discount_type,
                'discount_rate'       => $order->discount_rate,
                'delivery_charge'     => (float) ($order->delivery_charge ?? 0),
                'paid_amount'         => $order->paid_amount,
                'due_amount'          => $order->due_amount,
                'previous_due_amount' => $actualPreviousDue,
                'payment_method'      => $latestOrderPaymentDetails ? $latestOrderPaymentDetails->payment_method : '',
                'customer'            => [
                    'customer_name'    => $customer->customer_name,
                    'mobile'           => $customer->mobile,
                    'address_details'  => $customer->address_details ?? $customer->address ?? '',
                ],
                'details'             => $details,
            ];

            return response()->json(['status' => 'success', 'rows' => $rows]);

        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
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
            ->select(['id', 'order_no', 'sub_total', 'discount_amount', 'discount_type', 'discount_rate', 'paid_amount', 'due_amount', 'customer_id', 'created_at']);

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
            'id', 'order_no', 'sub_total', 'discount_amount', 'discount_type', 'discount_rate', 'paid_amount',
            'due_amount', 'customer_id', 'user_id', 'invoice_date'
        ]);

        // Apply date filters if both or either date is provided
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('invoice_date', [$startDate, $endDate]);
        } elseif ($startDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $query->where('invoice_date', '>=', $startDate);
        } elseif ($endDate) {
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->where('invoice_date', '<=', $endDate);
        }

        // Order results so the newest invoices always appear at the top (Section 7 & 8)
        $query->orderBy('id', 'DESC');

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

        $order = Order::with('customer', 'details.product', 'payment')
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
                'discount_type' => $order->discount_type,
                'discount_rate' => $order->discount_rate,
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
    $id = $request->input('id');
    $user_id = Auth::id();

    DB::beginTransaction();
    try {
        $order = Order::lockForUpdate()->find($id);
        if (!$order) {
            DB::rollBack();
            return response()->json([
                'status' => 'fail',
                'message' => 'ইনভয়েসটি খুঁজে পাওয়া যায়নি।'
            ], 404);
        }

        // 1. Validate & decode incoming items cleanly
        $itemsRaw = $request->input('items');
        if (is_string($itemsRaw)) {
            $items = json_decode($itemsRaw, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                DB::rollBack();
                return response()->json([
                    'status' => 'fail',
                    'message' => 'ইনভয়েস পণ্যের ফরম্যাট সঠিক নয়।'
                ], 422);
            }
        } elseif (is_array($itemsRaw)) {
            $items = $itemsRaw;
        } else {
            DB::rollBack();
            return response()->json([
                'status' => 'fail',
                'message' => 'ইনভয়েস আপডেট করতে কমপক্ষে একটি বৈধ পণ্য আবশ্যক।'
            ], 422);
        }

        if (!is_array($items) || count($items) === 0) {
            DB::rollBack();
            return response()->json([
                'status' => 'fail',
                'message' => 'ইনভয়েসে কমপক্ষে একটি পণ্য থাকতে হবে।'
            ], 422);
        }

        $newItemsByProduct = [];
        foreach ($items as $item) {
            $productId = (int) ($item['product_id'] ?? 0);
            $qty = (int) ($item['quantity'] ?? 0);
            $sellingPrice = (float) ($item['selling_price'] ?? 0);
            $costPrice = (float) ($item['cost_price'] ?? 0);

            if ($productId <= 0 || $qty <= 0) {
                DB::rollBack();
                return response()->json([
                    'status' => 'fail',
                    'message' => 'সকল ইনভয়েস পণ্যের আইডি ও পরিমাণ অবশ্যই ০-এর বেশি হতে হবে।'
                ], 422);
            }

            if (isset($newItemsByProduct[$productId])) {
                $newItemsByProduct[$productId]['quantity'] += $qty;
                $newItemsByProduct[$productId]['selling_price'] = $sellingPrice;
                $newItemsByProduct[$productId]['cost_price'] = $costPrice;
            } else {
                $newItemsByProduct[$productId] = [
                    'product_id'    => $productId,
                    'quantity'      => $qty,
                    'selling_price' => $sellingPrice,
                    'cost_price'    => $costPrice,
                ];
            }
        }

        // Validate invoice_date if supplied (preserve existing if omitted; NEVER alter $order->created_at)
        $oldInvoiceDate = $order->invoice_date;
        $normalizedInvoiceDate = $order->invoice_date;
        if ($request->filled('invoice_date')) {
            try {
                $normalizedInvoiceDate = Carbon::parse($request->input('invoice_date'))->format('Y-m-d');
            } catch (\Throwable $e) {
                DB::rollBack();
                return response()->json([
                    'status' => 'fail',
                    'message' => 'ইনভয়েসের তারিখ সঠিক ফরম্যাটে নয়।'
                ], 422);
            }
        }

        // 2. Lock existing order details, product returns, and payment rows
        $oldDetails = OrderDetails::where('order_id', $order->id)
            ->orderBy('id', 'asc')
            ->lockForUpdate()
            ->get();

        $lockedReturns = ProductReturn::where('order_id', $order->id)
            ->orderBy('id', 'asc')
            ->lockForUpdate()
            ->get();

        $lockedPayments = OrderPaymentDetails::where('order_id', $order->id)
            ->orderBy('id', 'asc')
            ->lockForUpdate()
            ->get();

        $oldDetailsByProduct = $oldDetails->groupBy(fn ($d) => (int) $d->product_id);
        $oldQtyByProduct = [];
        $returnedByProduct = [];

        foreach ($oldDetails as $od) {
            $pid = (int) $od->product_id;
            $oldQtyByProduct[$pid] = ($oldQtyByProduct[$pid] ?? 0) + (int) $od->quantity;
            $returnedByProduct[$pid] = ($returnedByProduct[$pid] ?? 0) + (int) ($od->return_quantity ?? 0);
        }

        $returnsSumByProduct = [];
        foreach ($lockedReturns as $ret) {
            $pid = (int) $ret->product_id;
            $returnsSumByProduct[$pid] = ($returnsSumByProduct[$pid] ?? 0) + (int) $ret->quantity;
        }
        foreach ($returnsSumByProduct as $pid => $retSum) {
            $returnedByProduct[$pid] = max((int) ($returnedByProduct[$pid] ?? 0), $retSum);
        }

        // 3. Collect all affected product IDs from old + new items and lock in ascending ID order
        $productIds = array_values(array_unique(array_merge(array_keys($oldQtyByProduct), array_keys($newItemsByProduct))));
        sort($productIds);

        $lockedProducts = !empty($productIds)
            ? Product::whereIn('id', $productIds)->orderBy('id', 'asc')->lockForUpdate()->get()->keyBy('id')
            : collect();

        foreach (array_keys($newItemsByProduct) as $reqPid) {
            if (!$lockedProducts->has($reqPid)) {
                DB::rollBack();
                return response()->json([
                    'status' => 'fail',
                    'message' => "পণ্য আইডি #{$reqPid} খুঁজে পাওয়া যায়নি।"
                ], 404);
            }
        }

        // 4. Protect existing returns before any mutation
        foreach ($returnedByProduct as $retPid => $retQty) {
            if ($retQty <= 0) {
                continue;
            }
            if (!isset($newItemsByProduct[$retPid])) {
                DB::rollBack();
                Log::warning('InvoiceUpdate blocked: attempted to remove returned product', [
                    'actor_user_id' => $user_id,
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'product_id' => $retPid,
                    'returned_qty' => $retQty,
                ]);
                return response()->json([
                    'status' => 'fail',
                    'message' => "এই ইনভয়েসে পণ্য আইডি #{$retPid} এর বিপরীতে ইতিমধ্যে {$retQty} পিস রিটার্ন রেকর্ড থাকায় এটিকে তালিকা থেকে বাদ দেওয়া যাবে না।"
                ], 422);
            }
            if ($newItemsByProduct[$retPid]['quantity'] < $retQty) {
                DB::rollBack();
                Log::warning('InvoiceUpdate blocked: quantity below returned qty', [
                    'actor_user_id' => $user_id,
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'product_id' => $retPid,
                    'requested_qty' => $newItemsByProduct[$retPid]['quantity'],
                    'returned_qty' => $retQty,
                ]);
                return response()->json([
                    'status' => 'fail',
                    'message' => "পণ্য আইডি #{$retPid} এর বিপরীতে ইতিমধ্যে {$retQty} পিস রিটার্ন থাকায় বিক্রয় সংখ্যা {$retQty} এর নিচে কমানো সম্ভব নয়।"
                ], 422);
            }
        }

        // 5. Validate net stock delta for ALL SKUs before mutating any row (prevent negative stock)
        $stockPlan = [];
        foreach ($productIds as $pId) {
            $product = $lockedProducts->get($pId);
            if (!$product) {
                continue;
            }
            $oldQty = (int) ($oldQtyByProduct[$pId] ?? 0);
            $newQty = (int) ($newItemsByProduct[$pId]['quantity'] ?? 0);
            $stockDelta = $oldQty - $newQty;
            $currentStock = (int) $product->quantity;
            $finalStock = $currentStock + $stockDelta;

            if ($finalStock < 0) {
                DB::rollBack();
                $productTitle = $product->product_name ?? ("পণ্য #{$pId}");
                Log::warning('InvoiceUpdate blocked: insufficient stock', [
                    'actor_user_id' => $user_id,
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'product_id' => $pId,
                    'current_stock' => $currentStock,
                    'old_invoice_qty' => $oldQty,
                    'new_invoice_qty' => $newQty,
                    'stock_delta' => $stockDelta,
                ]);
                return response()->json([
                    'status' => 'fail',
                    'message' => "স্টক অপ্রতুল: '{$productTitle}' এর বর্তমান স্টক {$currentStock} পিস, অতিরিক্ত " . abs($stockDelta) . " পিস যোগ করা সম্ভব নয়।"
                ], 422);
            }

            $stockPlan[$pId] = [
                'product' => $product,
                'old_qty' => $oldQty,
                'new_qty' => $newQty,
                'delta' => $stockDelta,
                'old_stock' => $currentStock,
                'new_stock' => $finalStock,
            ];
        }

        // 6. Apply stock changes cleanly
        $auditProducts = [];
        foreach ($stockPlan as $pId => $plan) {
            if ($plan['delta'] !== 0) {
                $plan['product']->quantity = $plan['new_stock'];
                $plan['product']->save();
            }
            $auditProducts[] = [
                'product_id' => $pId,
                'old_qty' => $plan['old_qty'],
                'new_qty' => $plan['new_qty'],
                'old_stock' => $plan['old_stock'],
                'new_stock' => $plan['new_stock'],
                'preserved_return_qty' => (int) ($returnedByProduct[$pId] ?? 0),
            ];
        }

        // 7. Reconcile OrderDetails IN-PLACE to preserve id, return_quantity, and original created_at
        $calculatedSubTotal = 0;
        foreach ($productIds as $pId) {
            $existingRows = $oldDetailsByProduct->get($pId, collect());

            if (isset($newItemsByProduct[$pId])) {
                $newItem = $newItemsByProduct[$pId];
                $preservedReturnQty = (int) ($returnedByProduct[$pId] ?? 0);
                $calculatedSubTotal += $newItem['selling_price'] * $newItem['quantity'];

                if ($existingRows->isNotEmpty()) {
                    $primaryRow = $existingRows->first();
                    $primaryRow->quantity = $newItem['quantity'];
                    $primaryRow->price = $newItem['cost_price'];
                    $primaryRow->selling_price = $newItem['selling_price'];
                    $primaryRow->return_quantity = $preservedReturnQty;
                    $primaryRow->user_id = $user_id ?? $primaryRow->user_id;
                    $primaryRow->save();

                    foreach ($existingRows->slice(1) as $dupRow) {
                        ProductReturn::where('order_detail_id', $dupRow->id)
                            ->update(['order_detail_id' => $primaryRow->id]);
                        $dupRow->delete();
                    }
                } else {
                    OrderDetails::create([
                        'order_id'        => $order->id,
                        'product_id'      => $pId,
                        'quantity'        => $newItem['quantity'],
                        'return_quantity' => 0,
                        'price'           => $newItem['cost_price'],
                        'selling_price'   => $newItem['selling_price'],
                        'user_id'         => $user_id ?? $order->user_id,
                    ]);
                }
            } else {
                foreach ($existingRows as $removedRow) {
                    $removedRow->delete();
                }
            }
        }

        $subTotal = floatval($request->input('sub_total', $calculatedSubTotal));
        if ($subTotal <= 0) {
            $subTotal = $calculatedSubTotal;
        }

        $discountAmount = floatval($request->input('discount_amount', 0));
        $paidAmount = floatval($request->input('paid_amount', 0));
        $dueAmount = max(0, $subTotal - $discountAmount - $paidAmount);

        $order->sub_total = $subTotal;
        $order->discount_amount = $discountAmount;
        $order->paid_amount = $paidAmount;
        $order->due_amount = $dueAmount;
        $order->order_note = $request->input('order_note');

        if ($request->filled('discount_type')) {
            $order->discount_type = $request->input('discount_type');
        }
        if ($request->has('discount_rate')) {
            $order->discount_rate = $request->filled('discount_rate') ? (float)$request->input('discount_rate') : null;
        }
        if ($request->filled('customer_id')) {
            $order->customer_id = $request->input('customer_id');
        }
        if ($request->filled('invoice_date')) {
            $order->invoice_date = $normalizedInvoiceDate;
        }
        // Preserve original $order->created_at strictly for historical P2 integrity
        $order->save();

        $paymentStatus = $dueAmount <= 0 ? 'Fully Paid' : ($paidAmount > 0 ? 'Partial Paid' : 'Unpaid');
        if ($lockedPayments->count() === 1) {
            $primaryPayment = $lockedPayments->first();
            $primaryPayment->paid_amount = $paidAmount;
            $primaryPayment->discount_amount = $discountAmount;
            $primaryPayment->payment_status = $paymentStatus;
            $primaryPayment->due_collection_date = $normalizedInvoiceDate ?? $primaryPayment->due_collection_date ?? now();
            $primaryPayment->user_id = $user_id ?? $primaryPayment->user_id;
            $primaryPayment->save();
        } elseif ($lockedPayments->isEmpty()) {
            OrderPaymentDetails::create([
                'order_id' => $order->id,
                'paid_amount' => $paidAmount,
                'discount_amount' => $discountAmount,
                'payment_status' => $paymentStatus,
                'payment_method' => 'Cash',
                'due_collection_date' => $normalizedInvoiceDate ?? now(),
                'user_id' => $user_id ?? $order->user_id,
            ]);
        }

        DB::commit();

        Log::info('Invoice Updated', [
            'actor_user_id' => $user_id,
            'order_id' => $order->id,
            'order_no' => $order->order_no,
            'old_invoice_date' => $oldInvoiceDate,
            'new_invoice_date' => $order->invoice_date,
            'products' => $auditProducts,
            'sub_total' => $subTotal,
            'paid_amount' => $paidAmount,
            'due_amount' => $dueAmount,
            'result' => 'success',
            'timestamp' => now()->toIso8601String(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Invoice and product items updated successfully!'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error("Invoice Update Error: " . $e->getMessage(), [
            'actor_user_id' => $user_id,
            'order_id' => $id,
        ]);
        return response()->json([
            'status' => 'fail',
            'message' => 'Failed to update invoice: ' . $e->getMessage()
        ], 500);
    }
}

}
