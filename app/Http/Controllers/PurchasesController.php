<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrderDetails;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchasePaymentDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class PurchasesController extends Controller
{



    // public function PurchaseShowDetails($id)
    // {
    //     // Fetch purchase invoice data with related supplier, order details, and payment details
    //     $purchaseinvoicedata = Purchase::with(['supplier', 'orderDetails', 'paymentDetails'])->findOrFail($id);

    //     // Calculate Subtotal from Order Details
    //     $subTotal = $purchaseinvoicedata->orderDetails->sum(function ($orderDetail) {
    //         return $orderDetail->cost_price * $orderDetail->quantity;
    //     });

    //     // Calculate Paid Amount from Payment Details
    //     $paidAmount = $purchaseinvoicedata->paymentDetails->sum('paid_amount');

    //     // Fetch payment status (make sure the `status` field is available)
    //     $paymentDetailsStatus = $purchaseinvoicedata->paymentDetails->pluck('payment_status')->first();  // Assuming it's a string column
    //     $PreviousDueAmount = $purchaseinvoicedata->pluck('due_amount')->first();  // Assuming it's a string column

    //     // Calculate Due Amount
    //     $dueAmount = $subTotal - $paidAmount;

    //     // Return the view with data
    //     return view('backend.purchase.purchase-invoice-print',
    //         compact('purchaseinvoicedata', 'paymentDetailsStatus', 'PreviousDueAmount', 'subTotal', 'paidAmount', 'dueAmount')
    //     );
    // }


public function PurchaseShowDetails($id)
{
    // Fetch purchase invoice data with related supplier, order details, and payment details
    $purchaseinvoicedata = Purchase::with(['supplier', 'orderDetails', 'paymentDetails'])->findOrFail($id);

    // Calculate Subtotal from Order Details
    $subTotal = $purchaseinvoicedata->orderDetails->sum(function ($orderDetail) {
        return $orderDetail->cost_price * $orderDetail->quantity;
    });

    // Calculate Paid Amount from Payment Details
    $paidAmount = $purchaseinvoicedata->paymentDetails->sum('paid_amount');

    // Fetch payment status (get the first status found)
    $paymentDetailsStatus = $purchaseinvoicedata->paymentDetails->pluck('payment_status')->first();

    // Previous due amount from the current purchase (stored in DB)
    $PreviousDueAmount = $purchaseinvoicedata->supplier->purchase_payable_amount;

    // Calculate Due Amount (in case it's not stored directly)
    $dueAmount = $subTotal - $paidAmount;
    $supplierDueAmount = $purchaseinvoicedata->supplier->sum('purchase_payable_amount');
    $purchaseDueAmount = Purchase::sum('due_amount');

    // NEW: Calculate total due from all purchases
    $totalDueFromAllPurchases = $supplierDueAmount + $purchaseDueAmount;

    // Return view with all variables
    return view('backend.purchase.purchase-invoice-print', compact(
        'purchaseinvoicedata',
        'paymentDetailsStatus',
        'PreviousDueAmount',
        'subTotal',
        'paidAmount',
        'dueAmount',
        'totalDueFromAllPurchases'
    ));
}




//     public function PurchasesList()
// {
//     try {
//         $PurchasessData = Purchase::with([
//             'supplier',
//             'orderDetails.product',
//             'orderDetails.paymentDetails',
//         ])
//         ->orderBy('created_at', 'desc')
//         ->get();

//         $formattedPurchasessData = $PurchasessData->map(function ($purchase) {
//             // Sum all paid amounts from related payment details
//             $totalPaid = $purchase->orderDetails->flatMap(function ($orderDetail) {
//                 return $orderDetail->paymentDetails;
//             })->sum('paid_amount');

//             // Calculate due
//             $dueAmount = floatval($purchase->grand_subtotal) - floatval($totalPaid);

//             return [
//                 'id' => $purchase->id,
//                 'purchase_id' => $purchase->purchase_id,
//                 'referance_no' => $purchase->referance_no,
//                 'date' => $purchase->date,
//                 'grand_subtotal' => $purchase->grand_subtotal,
//                 'paid_amount' => $totalPaid,
//                 'due_amount' => $dueAmount,
//                 'attach_document' => $purchase->attach_document,
//                 'supplier_id' => $purchase->supplier_id,
//                 'user_id' => $purchase->user_id,
//                 'supplier' => $purchase->supplier ? $purchase->supplier->name : 'N/A',
//                 'supplier_id' => $purchase->supplier ? $purchase->supplier->supplier_id : 'N/A',
//                 'orderDetails' => $purchase->orderDetails->map(function ($orderDetail) {
//                     return [
//                         'id' => $orderDetail->id,
//                         'product_id' => $orderDetail->product_id,
//                         'purchase_id' => $orderDetail->purchase_id,
//                         'quantity' => $orderDetail->quantity,
//                         'cost_price' => $orderDetail->cost_price,
//                         'subtotal' => $orderDetail->subtotal,
//                         'product' => $orderDetail->product ? $orderDetail->product->name : 'N/A',
//                         'paymentDetails' => $orderDetail->paymentDetails->map(function ($paymentDetail) {
//                             return [
//                                 'id' => $paymentDetail->id,
//                                 'purchase_order_details_id' => $paymentDetail->purchase_order_details_id,
//                                 'paid_amount' => $paymentDetail->paid_amount,
//                                 'payment_method' => $paymentDetail->payment_method,
//                                 'payment_status' => $paymentDetail->payment_status,
//                                 'user_id' => $paymentDetail->user_id,
//                             ];
//                         }),
//                     ];
//                 }),
//             ];
//         });

//         return response()->json([
//             'status' => 'success',
//             'PurchasessData' => $formattedPurchasessData
//         ]);
//     } catch (\Exception $e) {
//         return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
//     }
// }


// PurchaseController.php এর মধ্যে
// PurchaseController.php
public function PurchasesList()
{
    try {
        $purchases = Purchase::with(['supplier', 'paymentDetails', 'orderDetails.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        $hasPurchaseReturns = Schema::hasTable('purchase_returns');

        $formatted = $purchases->map(function ($purchase) use ($hasPurchaseReturns) {
            $totalPaid = (float) ($purchase->paymentDetails ? $purchase->paymentDetails->sum('paid_amount') : 0);
            $grandTotal = (float) ($purchase->grand_subtotal ?? 0);
            $returnAdj = (float) ($purchase->return_adjustment_amount ?? 0);

            $effectivePaid = $totalPaid + $returnAdj;
            $dueAmount = max(0, $grandTotal - $effectivePaid);

            $paymentMethod = $purchase->paymentDetails?->sortByDesc('created_at')->first()?->payment_method ?? 'N/A';

            $paymentStatus = 'Unpaid';
            if ($effectivePaid >= $grandTotal && $grandTotal > 0) {
                $paymentStatus = 'Fully Paid';
            } elseif ($effectivePaid > 0) {
                $paymentStatus = 'Partial Paid';
            }

            // Extract unique barcodes for products in this purchase
            $barcodes = [];
            if ($purchase->orderDetails) {
                $barcodes = $purchase->orderDetails->flatMap(function ($detail) {
                    if (!$detail->product || !$detail->product->product_code) return [];
                    $code = $detail->product->product_code;
                    $parsed = is_array($code) ? $code : (json_decode($code, true) ?? [$code]);
                    return is_array($parsed) ? $parsed : [$parsed];
                })->filter()->unique()->values()->all();
            }

            // Total return amount for this purchase
            $totalReturnAmount = 0;
            if ($hasPurchaseReturns) {
                try {
                    $totalReturnAmount = DB::table('purchase_returns')
                        ->where('purchase_id', $purchase->id)
                        ->sum('amount') ?? 0;
                } catch (\Exception $ex) {
                    $totalReturnAmount = 0;
                }
            }

            $purIdStr = $purchase->purchase_id;
            if (!$purIdStr || str_starts_with($purIdStr, 'me-pur-')) {
                $purIdStr = '#PurID' . str_pad($purchase->id, 5, '0', STR_PAD_LEFT);
            }

            return [
                'id'                => $purchase->id,
                'purchase_id'       => $purIdStr,
                'date'              => $purchase->date 
                    ? \Carbon\Carbon::parse($purchase->date)->format('d-m-Y') 
                    : 'N/A',
                'referance_no'      => $purchase->referance_no ?? 'No Reference',
                'supplier_id'       => $purchase->supplier?->supplier_id ?? 'N/A',
                'supplier_db_id'    => $purchase->supplier_id,
                'supplier'          => $purchase->supplier?->name ?? 'N/A',
                'grand_subtotal'    => $grandTotal,
                'paid_amount'       => $totalPaid,
                'due_amount'        => $dueAmount,
                'payment_method'    => $paymentMethod,
                'payment_status'    => $paymentStatus,
                'return_amount'     => (float) $totalReturnAmount,
                'barcodes'          => $barcodes,
            ];
        });

        return response()->json([
            'status' => 'success',
            'PurchasessData' => $formatted
        ]);

    } catch (\Exception $e) {
        \Log::error('Purchase List Error: ' . $e->getMessage());
        return response()->json([
            'status' => 'fail',
            'PurchasessData' => [],
            'message' => $e->getMessage()
        ]);
    }
}


    public function PurchasesCreate(Request $request)
    {
        try {
            $user_id = Auth::id();
            DB::beginTransaction();

            // Handle document upload if there's an image file
            $img_url = null;
            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $img_name = "{$user_id}-" . time() . "-" . $img->getClientOriginalName();
                $img_url = "uploads/purchases-img/{$img_name}";
                $img->move(public_path('uploads/purchases-img'), $img_name);
            }

            // Create Purchase record
            $purchaseData = [
                'purchase_id' => $this->generatePurchasesID(),
                'purchase_payable_amount' => $request->purchase_payable_amount,
                'paid_amount' => $request->paid_amount,
                'due_amount' => $request->due_amount,
                'referance_no' => $request->referance_no,
                'date' => $request->date,
                'grand_subtotal' => $request->grand_subtotal,
                'attach_document' => $img_url,
                'supplier_id' => $request->supplier_id,
                'user_id' => $user_id,
            ];

            if (Schema::hasColumn('purchases', 'return_adjustment_amount')) {
                $purchaseData['return_adjustment_amount'] = (float) ($request->return_adjustment_amount ?? 0);
            }

            $purchase = Purchase::create($purchaseData);


            // Save product details in the `purchase_product_details` table
            $products = json_decode($request->products, true); // Decode the JSON string to an array
            foreach ($products as $product) {
                if (isset($product['product_id'], $product['quantity'])) {
                    $purchaseorderDetails = PurchaseOrderDetails::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $product['product_id'],
                        'quantity' => $product['quantity'],
                        'cost_price' => $product['cost_price'],
                        'subtotal' => $product['subtotal'],
                        'user_id' => $user_id,
                    ]);

                    $productModel = Product::find($product['product_id']);
                    if ($productModel) {
                        // Existing data
                        $existingCostPrice = (float) $productModel->cost_price;
                        $existingQuantity = (int) $productModel->quantity;

                        // New purchase data
                        $newCostPrice = (float) $product['cost_price'];
                        $newQuantity = (int) $product['quantity'];

                        // Calculate totals
                        $existingTotal = $existingCostPrice * $existingQuantity;
                        $newTotal = $newCostPrice * $newQuantity;

                        // Combine totals and quantities
                        $combinedTotal = $existingTotal + $newTotal;
                        $combinedQuantity = $existingQuantity + $newQuantity;

                        // Calculate new cost price
                        $updatedCostPrice = $combinedTotal / $combinedQuantity;

                        // Update product
                        $productModel->quantity = $combinedQuantity; // Update quantity
                        $productModel->cost_price = round($updatedCostPrice, 2); // Round to 2 decimal places for cost price


                        // Safely update or merge product_code
                        if (isset($product['product_code']) && !empty($product['product_code'])) {
                            $newCodes = $product['product_code'];

                            if (!is_array($newCodes)) {
                                $newCodes = json_decode($newCodes, true) ?? [];
                            }

                            if (is_array($newCodes) && count($newCodes) > 0) {
                                // Decode existing product codes
                                $existingCodes = [];
                                if ($productModel->product_code) {
                                    $existingCodes = is_array($productModel->product_code) 
                                        ? $productModel->product_code 
                                        : (json_decode($productModel->product_code, true) ?? []);
                                }

                                // Merge existing and new codes without duplicates
                                $mergedCodes = array_values(array_unique(array_merge($existingCodes, $newCodes)));
                                $productModel->product_code = json_encode($mergedCodes);
                            }
                        }
                        $productModel->save();
                    }
                }
            }

            // Check if the purchase is partially or fully paid
            // if ($request->paid > 0) {
            PurchasePaymentDetails::create([
                'purchases_id' => $purchase->id,
                'paid_amount' => $request->paid_amount,
                'discount_amount' => $request->discount_amount,
                'purchase_due_collection_date' => $request->purchase_due_collection_date,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'user_id' => $user_id,
            ]);
            // }


            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Purchase created successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'fail', 'message' => 'Failed to create purchase: ' . $e->getMessage()]);
        }
    }


private function generatePurchasesID()
{
    $prefix = '#PurID';

    $newId = DB::transaction(function () use ($prefix) {
        $last = Purchase::orderBy('id', 'desc')->first();
        $number = $last ? ($last->id + 1) : 1;
        return $prefix . str_pad($number, 5, '0', STR_PAD_LEFT);
    });

    return $newId;
}


    // purchase purchase_payable_amount due clear function


    // public function getPaymentDetailsById(Request $request)
    //     {
    //         try {
    //             $request->validate([
    //                 "id" => 'required|integer|exists:purchases,id'
    //             ]);

    //             $purchase = Purchase::with('orderDetails.paymentDetails')
    //                                 ->where('id', $request->id)
    //                                 ->first();

    //             if (!$purchase) {
    //                 return response()->json(['status' => 'fail', 'message' => 'Purchase not found.']);
    //             }

    //             // Calculate total paid amount and due amount
    //             $totalPaidAmount = $purchase->orderDetails->flatMap->paymentDetails->sum('paid_amount');
    //             $PaidAmount = $purchase->orderDetails->flatMap->paymentDetails->sum('paid_amount');
    //             $totalDueAmount = $purchase->grand_subtotal - $totalPaidAmount;

    //             return response()->json([
    //                 'status' => 'success',
    //                 'purchase' => $purchase,
    //                 'paid_amount' => $totalPaidAmount,
    //                 'due_amount' => $totalDueAmount
    //             ]);
    //         } catch (\Exception $e) {
    //             return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    //         }
    //     }



    // public function getPaymentDetailsById(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             "id" => 'required|integer|exists:purchases,id'
    //         ]);

    //         $purchase = Purchase::with('orderDetails.paymentDetails')->find($request->id);

    //         if (!$purchase) {
    //             return response()->json(['status' => 'fail', 'message' => 'Purchase not found.']);
    //         }

    //         $totalPaidAmount = 0;

    //         // Ensure orderDetails exist before accessing paymentDetails
    //         foreach ($purchase->orderDetails as $orderDetail) {
    //             foreach ($orderDetail->paymentDetails as $paymentDetail) {
    //                 $totalPaidAmount += $paymentDetail->paid_amount;
    //             }
    //         }

    //         $totalDueAmount = $purchase->grand_subtotal - $totalPaidAmount;

    //         return response()->json([
    //             'status' => 'success',
    //             'purchase' => $purchase,
    //             'paid_amount' => $totalPaidAmount,
    //             'due_amount' => max(0, $totalDueAmount) // Prevent negative values
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    //     }
    // }

public function getPaymentDetailsById(Request $request)
{
    try {
        $request->validate([
            "id" => 'required|integer|exists:purchases,id'
        ]);

        $purchase = Purchase::with('paymentDetails')
            ->findOrFail($request->id);

        $totalPaid = $purchase->paymentDetails->sum('paid_amount') ?? 0;
        $grandTotal = (float) $purchase->grand_subtotal;
        $dueAmount = max(0, $grandTotal - $totalPaid);

        return response()->json([
            'status'       => 'success',
            'purchase_id'  => $purchase->id,           // এটা যোগ করো
            'grand_total'  => $grandTotal,
            'paid_amount'  => $totalPaid,
            'due_amount'   => $dueAmount,
            'date'         => $purchase->date 
                ? \Carbon\Carbon::parse($purchase->date)->format('d-m-Y') 
                : 'N/A',
            'referance_no' => $purchase->referance_no ?? 'No Reference',
        ]);

    } catch (\Exception $e) {
        \Log::error('API Error: ' . $e->getMessage());
        return response()->json([
            'status'  => 'fail',
            'message' => 'Purchase not found!'
        ], 404);
    }
}


    // public function updatePaymentDetails(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'id' => 'required|integer|exists:purchases,id',
    //             'paid_amount' => 'required|numeric|min:0',
    //             'payment_method' => 'required|string',
    //             'transaction_id' => 'nullable|string'
    //         ]);

    //         $user_id = Auth::id();
    //         $purchase = Purchase::findOrFail($request->id);

    //         // Calculate new amounts
    //         $totalPaid = $purchase->orderDetails->flatMap->paymentDetails->sum('paid_amount') + $request->paid_amount;
    //         $newDueAmount = $purchase->grand_subtotal - $totalPaid;

    //         // Update purchase due amount
    //         $purchase->update([
    //             'purchase_payable_amount' => $newDueAmount
    //         ]);

    //         // Insert into purchase_payment_details
    //         PurchasePaymentDetails::create([
    //             'purchase_order_details_id' => $purchase->orderDetails->first()->id ?? null, // Get first order detail ID
    //             'paid_amount' => $request->paid_amount,
    //             'due_amount' => $newDueAmount,
    //             'payment_status' => $newDueAmount == 0 ? 'paid' : 'partial',
    //             'payment_method' => $request->payment_method,
    //             'transaction_id' => $request->transaction_id,
    //             'user_id' => $user_id
    //         ]);

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Purchase payment updated successfully',
    //             'paid_amount' => $totalPaid,
    //             'due_amount' => $newDueAmount
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    //     }
    // }



public function updatePaymentDetails(Request $request)
{
    try {
        $request->validate([
            'id'             => 'required|integer|exists:purchases,id',
            'paid_amount'    => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string|max:255'
        ]);

        $purchase = Purchase::with('paymentDetails')->findOrFail($request->id);

        $currentPaid = $purchase->paymentDetails->sum('paid_amount') ?? 0;
        $newPaid     = $currentPaid + $request->paid_amount;
        $newDue      = max(0, $purchase->grand_subtotal - $newPaid);

        // শুধু created_at এর তারিখটা নিয়ে purchase_due_collection_date এ ঢুকাবে
        $todayDate = Carbon::today()->format('Y-m-d'); // শুধু তারিখ, টাইম না

        PurchasePaymentDetails::create([
            'purchases_id'                => $purchase->id,
            'paid_amount'                 => $request->paid_amount,
            'discount_amount'             => 0,
            'payment_method'              => $request->payment_method,
            'transaction_id'              => $request->transaction_id,
            'payment_status'              => $newDue <= 0 ? 'Fully Paid' : 'Partial Paid',
            'purchase_due_collection_date'=> $todayDate,   // এটাই তুমি চেয়েছো
            'purchase_order_details_id'   => null,
            'user_id'                     => auth()->id(),
        ]);

        $purchase->update(['due_amount' => $newDue]);

        return response()->json([
            'status'   => 'success',
            'message'  => 'Payment saved successfully!',
            'new_paid' => $newPaid,
            'new_due'  => $newDue,
        ]);

    } catch (\Exception $e) {
        \Log::error('Payment Error: ' . $e->getMessage());
        return response()->json([
            'status'  => 'fail',
            'message' => 'Payment failed.'
        ], 500);
    }
}

    public function PurchasesByID(Request $request)
    {
        try {
            $purchase_id = $request->input('id');
            $purchase = Purchase::with(['supplier', 'orderDetails.product', 'paymentDetails'])->find($purchase_id);
            if (!$purchase) {
                return response()->json(['status' => 'fail', 'message' => 'Purchase not found']);
            }
            return response()->json(['status' => 'success', 'rows' => $purchase]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function PurchasesUpdate(Request $request)
    {
        try {
            $purchase_id = $request->input('id');
            $purchase = Purchase::find($purchase_id);
            if (!$purchase) {
                return response()->json(['status' => 'fail', 'message' => 'Purchase not found']);
            }

            $purchase->update([
                'referance_no' => $request->input('referance_no', $purchase->referance_no),
                'date' => $request->input('date', $purchase->date),
                'grand_subtotal' => $request->input('grand_subtotal', $purchase->grand_subtotal),
                'paid_amount' => $request->input('paid_amount', $purchase->paid_amount),
                'due_amount' => $request->input('due_amount', $purchase->due_amount),
                'supplier_id' => $request->input('supplier_id', $purchase->supplier_id),
            ]);

            return response()->json(['status' => 'success', 'message' => 'Purchase updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function PurchasesDelete(Request $request)
    {
        try {
            $purchase_id = $request->input('id');

            DB::beginTransaction();

            PurchaseOrderDetails::where('purchase_id', $purchase_id)->delete();
            PurchasePaymentDetails::where('purchases_id', $purchase_id)->delete();
            Purchase::where('id', $purchase_id)->delete();

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Purchase deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

}
