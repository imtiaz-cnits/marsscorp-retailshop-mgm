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
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

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
    $purchaseinvoicedata = Purchase::with(['supplier', 'orderDetails.product', 'paymentDetails'])->findOrFail($id);

    // Calculate Subtotal from Order Details
    $subTotal = (float) $purchaseinvoicedata->orderDetails->sum(function ($orderDetail) {
        return (float) ($orderDetail->cost_price ?? 0) * (float) ($orderDetail->quantity ?? 1);
    });

    $deliveryCharge = (float) ($purchaseinvoicedata->delivery_charge ?? 0);
    $discountAmount = (float) ($purchaseinvoicedata->discount_amount ?? 0);
    $discountType = $purchaseinvoicedata->discount_type ?? 'fixed';
    $discountRate = $purchaseinvoicedata->discount_rate !== null ? (float) $purchaseinvoicedata->discount_rate : null;

    // Calculate Paid Amount from Payment Details
    $paidAmount = (float) ($purchaseinvoicedata->paymentDetails ? $purchaseinvoicedata->paymentDetails->sum('paid_amount') : $purchaseinvoicedata->paid_amount);

    // Fetch payment status
    $paymentDetailsStatus = $purchaseinvoicedata->paymentDetails->pluck('payment_status')->first() ?? ($paidAmount >= ($subTotal - $discountAmount + $deliveryCharge) ? 'Fully Paid' : ($paidAmount > 0 ? 'Partial Paid' : 'Unpaid'));

    // Previous due amount from supplier record
    $PreviousDueAmount = (float) ($purchaseinvoicedata->supplier->purchase_payable_amount ?? 0);

    // Calculate Net Total & Due Amount
    $netTotal = max(0, $subTotal - $discountAmount + $deliveryCharge);
    $dueAmount = max(0, $netTotal - $paidAmount);
    $supplierDueAmount = $PreviousDueAmount;
    $purchaseDueAmount = (float) Purchase::where('supplier_id', $purchaseinvoicedata->supplier_id)->sum('due_amount');

    // Total due from all purchases
    $totalDueFromAllPurchases = $supplierDueAmount + $purchaseDueAmount;

    // Return view with all variables
    return view('backend.purchase.purchase-invoice-print', compact(
        'purchaseinvoicedata',
        'paymentDetailsStatus',
        'PreviousDueAmount',
        'subTotal',
        'deliveryCharge',
        'discountAmount',
        'discountType',
        'discountRate',
        'netTotal',
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
            $deliveryCharge = (float) ($purchase->delivery_charge ?? 0);
            $discountAmount = (float) ($purchase->discount_amount ?? 0);
            $returnAdj = (float) ($purchase->return_adjustment_amount ?? 0);

            $effectiveGrandTotal = max(0, ($grandTotal - $discountAmount) + $deliveryCharge);
            $effectivePaid = $totalPaid + $returnAdj;
            $dueAmount = max(0, $effectiveGrandTotal - $effectivePaid);

            $paymentMethod = $purchase->paymentDetails?->sortByDesc('created_at')->first()?->payment_method ?? 'N/A';

            $paymentStatus = 'Unpaid';
            if ($effectivePaid >= $effectiveGrandTotal && $effectiveGrandTotal > 0) {
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
                'raw_date'          => $purchase->date ? \Carbon\Carbon::parse($purchase->date)->format('Y-m-d') : '',
                'referance_no'      => $purchase->referance_no ?? 'No Reference',
                'supplier_id'       => $purchase->supplier?->supplier_id ?? 'N/A',
                'supplier_db_id'    => $purchase->supplier_id,
                'supplier'          => $purchase->supplier?->name ?? 'N/A',
                'grand_subtotal'    => $grandTotal,
                'delivery_charge'   => $deliveryCharge,
                'discount_amount'   => $discountAmount,
                'discount_type'     => $purchase->discount_type ?? 'fixed',
                'discount_rate'     => $purchase->discount_rate !== null ? (float) $purchase->discount_rate : null,
                'paid_amount'       => $totalPaid,
                'due_amount'        => $dueAmount,
                'payment_method'    => $paymentMethod,
                'payment_status'    => $paymentStatus,
                'return_amount'     => (float) $totalReturnAmount,
                'attach_document'   => $purchase->attach_document,
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

            // Parse and format date to Y-m-d for database storage
            $formattedDate = null;
            if ($request->filled('date')) {
                try {
                    $formattedDate = Carbon::parse($request->date)->format('Y-m-d');
                } catch (\Exception $e) {
                    $formattedDate = now()->format('Y-m-d');
                }
            } else {
                $formattedDate = now()->format('Y-m-d');
            }

            $formattedDueDate = null;
            if ($request->filled('purchase_due_collection_date')) {
                try {
                    $formattedDueDate = Carbon::parse($request->purchase_due_collection_date)->format('Y-m-d');
                } catch (\Exception $e) {
                    $formattedDueDate = $formattedDate;
                }
            } else {
                $formattedDueDate = $formattedDate;
            }

            // Validate & resolve supplier_id
            $supplier_id = null;
            if ($request->filled('supplier_id') && $request->supplier_id !== 'none') {
                if (is_numeric($request->supplier_id)) {
                    $supplier_id = (int) $request->supplier_id;
                } else {
                    $foundSupplier = Supplier::where('supplier_id', trim($request->supplier_id))->first();
                    if ($foundSupplier) {
                        $supplier_id = $foundSupplier->id;
                    }
                }
            }

            if (!$supplier_id || !Supplier::where('id', $supplier_id)->exists()) {
                DB::rollBack();
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Please select a valid supplier.'
                ]);
            }

            // Create Purchase record
            $purchaseData = [
                'purchase_id' => $this->generatePurchasesID(),
                'purchase_payable_amount' => $request->purchase_payable_amount,
                'paid_amount' => $request->paid_amount,
                'due_amount' => $request->due_amount,
                'referance_no' => $request->referance_no,
                'date' => $formattedDate,
                'grand_subtotal' => $request->grand_subtotal,
                'attach_document' => $img_url,
                'supplier_id' => $supplier_id,
                'user_id' => $user_id,
            ];

            if (Schema::hasColumn('purchases', 'delivery_charge')) {
                $purchaseData['delivery_charge'] = (float) ($request->delivery_charge ?? 0);
            }

            if (Schema::hasColumn('purchases', 'discount_amount')) {
                $purchaseData['discount_amount'] = (float) ($request->discount_amount ?? 0);
            }

            if (Schema::hasColumn('purchases', 'discount_type')) {
                $purchaseData['discount_type'] = $request->input('discount_type', 'fixed');
            }

            if (Schema::hasColumn('purchases', 'discount_rate')) {
                $purchaseData['discount_rate'] = $request->filled('discount_rate') ? (float) $request->discount_rate : null;
            }

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
            PurchasePaymentDetails::create([
                'purchases_id' => $purchase->id,
                'paid_amount' => $request->paid_amount,
                'discount_amount' => $request->discount_amount ?? 0,
                'transaction_id' => $request->transaction_id ?? null,
                'purchase_due_collection_date' => $formattedDueDate,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'user_id' => $user_id,
            ]);


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
        $id = $prefix . str_pad($number, 5, '0', STR_PAD_LEFT);
        while (Purchase::where('purchase_id', $id)->exists()) {
            $number++;
            $id = $prefix . str_pad($number, 5, '0', STR_PAD_LEFT);
        }
        return $id;
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
        $grandTotal = (float) ($purchase->grand_subtotal ?? 0);
        $deliveryCharge = (float) ($purchase->delivery_charge ?? 0);
        $discountAmount = (float) ($purchase->discount_amount ?? 0);
        $netTotal = max(0, ($grandTotal - $discountAmount) + $deliveryCharge);
        $dueAmount = max(0, $netTotal - $totalPaid);

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
        $grandTotal  = (float) ($purchase->grand_subtotal ?? 0);
        $deliveryCharge = (float) ($purchase->delivery_charge ?? 0);
        $discountAmount = (float) ($purchase->discount_amount ?? 0);
        $netTotal    = max(0, ($grandTotal - $discountAmount) + $deliveryCharge);
        $newDue      = max(0, $netTotal - $newPaid);

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
        $purchase_id = $request->input('id');
        if (!$purchase_id) {
            return response()->json(['status' => 'fail', 'message' => 'Purchase ID is required']);
        }

        $purchase = Purchase::with(['orderDetails', 'paymentDetails'])->find($purchase_id);
        if (!$purchase) {
            return response()->json(['status' => 'fail', 'message' => 'Purchase not found']);
        }

        DB::beginTransaction();
        try {
            $user_id = Auth::id() ?? $purchase->user_id;

            $updateDate = $purchase->date;
            if ($request->filled('date')) {
                try {
                    $dateStr = trim($request->input('date'));
                    if (str_contains($dateStr, '-')) {
                        $parts = explode('-', $dateStr);
                        if (count($parts) === 3 && strlen($parts[0]) === 2 && strlen($parts[2]) === 4) {
                            $updateDate = Carbon::createFromFormat('d-m-Y', $dateStr)->format('Y-m-d');
                        } else {
                            $updateDate = Carbon::parse($dateStr)->format('Y-m-d');
                        }
                    } else {
                        $updateDate = Carbon::parse($dateStr)->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    $updateDate = $purchase->date;
                }
            }

            // Supplier resolution
            $supplier_id = $purchase->supplier_id;
            if ($request->filled('supplier_id') && $request->supplier_id !== 'none') {
                $supplier_id = (int) $request->supplier_id;
            }

            // Document upload
            $img_url = $purchase->attach_document;
            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $img_name = "{$user_id}-" . time() . "-" . $img->getClientOriginalName();
                $img_url = "uploads/purchases-img/{$img_name}";
                $destination = public_path('uploads/purchases-img');
                if (!file_exists($destination)) {
                    @mkdir($destination, 0777, true);
                }
                $img->move($destination, $img_name);
            }

            // Check if any products have been returned
            $purchaseReturns = DB::table('purchase_returns')
                ->where('purchase_id', $purchase->id)
                ->get();
            $returnsByProduct = $purchaseReturns->groupBy('product_id')->map(function ($group) {
                return $group->sum('quantity');
            });

            // Handle products reconciliation
            $rawProducts = $request->input('products');
            $products = null;
            if ($rawProducts) {
                $products = is_array($rawProducts) ? $rawProducts : json_decode($rawProducts, true);
            }

            $lineItemsCalculatedSubtotal = 0;

            if (is_array($products)) {
                // Map old details by product_id
                $oldDetails = $purchase->orderDetails;
                $oldItemsMap = [];
                foreach ($oldDetails as $od) {
                    $oldItemsMap[$od->product_id] = [
                        'quantity'   => (int) $od->quantity,
                        'cost_price' => (float) $od->cost_price,
                        'subtotal'   => (float) $od->subtotal,
                    ];
                }

                // Map new items by product_id
                $newItemsMap = [];
                foreach ($products as $p) {
                    if (isset($p['product_id']) && !empty($p['product_id'])) {
                        $pId = (int) $p['product_id'];
                        $qty = (int) ($p['quantity'] ?? 0);
                        $cost = (float) ($p['cost_price'] ?? 0);
                        $sub = (float) ($p['subtotal'] ?? ($qty * $cost));

                        if (isset($newItemsMap[$pId])) {
                            $newItemsMap[$pId]['quantity'] += $qty;
                            $newItemsMap[$pId]['subtotal'] += $sub;
                        } else {
                            $newItemsMap[$pId] = [
                                'product_id'   => $pId,
                                'quantity'     => $qty,
                                'cost_price'   => $cost,
                                'subtotal'     => $sub,
                                'product_code' => $p['product_code'] ?? null,
                            ];
                        }
                    }
                }

                // Validate return constraints
                foreach ($returnsByProduct as $retProdId => $retQty) {
                    if (!isset($newItemsMap[$retProdId])) {
                        DB::rollBack();
                        return response()->json([
                            'status'  => 'fail',
                            'message' => "এই ক্রয় ইনভয়েসে পণ্য আইডি #{$retProdId} এর বিপরীতে রিটার্ন রেকর্ড থাকায় এটিকে তালিকা থেকে বাদ দেওয়া যাবে না।"
                        ]);
                    }
                    if ($newItemsMap[$retProdId]['quantity'] < $retQty) {
                        DB::rollBack();
                        return response()->json([
                            'status'  => 'fail',
                            'message' => "পণ্য আইডি #{$retProdId} এর জন্য ইতিমধ্যে {$retQty} টি রিটার্ন এন্ট্রি রয়েছে, তাই ক্রয় সংখ্যা {$retQty} এর নিচে কমানো সম্ভব নয়।"
                        ]);
                    }
                }

                // Union of all product IDs
                $allProductIds = array_unique(array_merge(array_keys($oldItemsMap), array_keys($newItemsMap)));

                foreach ($allProductIds as $pId) {
                    $productModel = Product::where('id', $pId)->lockForUpdate()->first();
                    if (!$productModel) continue;

                    $oldQty  = $oldItemsMap[$pId]['quantity'] ?? 0;
                    $oldCost = $oldItemsMap[$pId]['cost_price'] ?? 0;

                    $newQty  = $newItemsMap[$pId]['quantity'] ?? 0;
                    $newCost = $newItemsMap[$pId]['cost_price'] ?? 0;

                    $deltaQty = $newQty - $oldQty;

                    $currentStock = (int) $productModel->quantity;
                    $finalStock   = $currentStock + $deltaQty;
                    if ($deltaQty < 0 && $finalStock < 0) {
                        DB::rollBack();
                        return response()->json([
                            'status'  => 'fail',
                            'message' => "স্টক অপ্রতুল: \"{$productModel->name}\" এর বর্তমান স্টক {$currentStock} পিস, তাই " . abs($deltaQty) . " পিস কমানো সম্ভব নয়।"
                        ]);
                    }

                    // Weighted average cost price recalculation using incremental inventory valuation
                    $currentCost = (float) $productModel->cost_price;
                    $currentInventoryValue = $currentStock * $currentCost;

                    $oldPurchaseValue = $oldQty * $oldCost;
                    $newPurchaseValue = $newQty * $newCost;
                    $deltaValue       = $newPurchaseValue - $oldPurchaseValue;

                    $finalInventoryValue = $currentInventoryValue + $deltaValue;

                    if ($finalStock > 0) {
                        if ($finalInventoryValue > 0) {
                            $productModel->cost_price = round($finalInventoryValue / $finalStock, 2);
                        }
                    } elseif ($newCost > 0) {
                        $productModel->cost_price = round($newCost, 2);
                    }

                    $productModel->quantity = $finalStock;

                    // Barcodes / serials merge if provided
                    if (!empty($newItemsMap[$pId]['product_code'])) {
                        $newCodes = $newItemsMap[$pId]['product_code'];
                        if (!is_array($newCodes)) {
                            $newCodes = json_decode($newCodes, true) ?? [];
                        }
                        if (is_array($newCodes) && count($newCodes) > 0) {
                            $existingCodes = [];
                            if ($productModel->product_code) {
                                $existingCodes = is_array($productModel->product_code)
                                    ? $productModel->product_code
                                    : (json_decode($productModel->product_code, true) ?? [$productModel->product_code]);
                            }
                            $mergedCodes = array_values(array_unique(array_merge($existingCodes, $newCodes)));
                            $productModel->product_code = json_encode($mergedCodes);
                        }
                    }

                    $productModel->save();
                }

                // Delete old order details and recreate new ones
                PurchaseOrderDetails::where('purchase_id', $purchase->id)->delete();

                foreach ($newItemsMap as $newItem) {
                    $itemSubtotal = round($newItem['quantity'] * $newItem['cost_price'], 2);
                    $lineItemsCalculatedSubtotal += $itemSubtotal;

                    PurchaseOrderDetails::create([
                        'purchase_id' => $purchase->id,
                        'product_id'  => $newItem['product_id'],
                        'quantity'    => $newItem['quantity'],
                        'cost_price'  => $newItem['cost_price'],
                        'subtotal'    => $itemSubtotal,
                        'user_id'     => $user_id,
                    ]);
                }
            } else {
                $lineItemsCalculatedSubtotal = (float) $purchase->grand_subtotal;
            }

            // Financial Calculations
            $grandSubtotal = is_array($products) ? $lineItemsCalculatedSubtotal : floatval($request->input('grand_subtotal', $purchase->grand_subtotal));
            $deliveryCharge = floatval($request->input('delivery_charge', $purchase->delivery_charge ?? 0));
            $discountAmount = floatval($request->input('discount_amount', $purchase->discount_amount ?? 0));
            $returnAdj = floatval($request->input('return_adjustment_amount', $purchase->return_adjustment_amount ?? 0));

            $effectiveTotal = max(0, ($grandSubtotal - $discountAmount) + $deliveryCharge);

            $requestedPaid = $request->filled('paid_amount') ? round(floatval($request->input('paid_amount')), 2) : (float) $purchase->paid_amount;
            $effectivePaid = $requestedPaid + $returnAdj;
            $newDue = max(0, $effectiveTotal - $effectivePaid);

            // Reconcile Payment Details
            $paymentMethod = $request->input('payment_method', 'Cash');
            $transactionId = $request->input('transaction_id', null);
            $paymentStatus = $request->input('payment_status', ($newDue <= 0 ? 'Fully Paid' : ($requestedPaid > 0 ? 'Partial Paid' : 'Unpaid')));

            $firstPayment = $purchase->paymentDetails->first();
            if ($firstPayment) {
                $firstPayment->paid_amount = $requestedPaid;
                $firstPayment->discount_amount = $discountAmount;
                if ($request->filled('payment_method')) $firstPayment->payment_method = $paymentMethod;
                if ($request->filled('transaction_id')) $firstPayment->transaction_id = $transactionId;
                $firstPayment->payment_status = $paymentStatus;
                $firstPayment->purchase_due_collection_date = $updateDate;
                $firstPayment->save();
            } elseif ($requestedPaid > 0) {
                PurchasePaymentDetails::create([
                    'purchases_id'    => $purchase->id,
                    'paid_amount'     => $requestedPaid,
                    'discount_amount' => $discountAmount,
                    'transaction_id'  => $transactionId,
                    'payment_method'  => $paymentMethod,
                    'payment_status'  => $paymentStatus,
                    'purchase_due_collection_date' => $updateDate,
                    'user_id'         => $user_id,
                ]);
            }

            // Update Purchase Record
            $updateData = [
                'referance_no'             => $request->input('referance_no', $purchase->referance_no),
                'date'                     => $updateDate,
                'supplier_id'              => $supplier_id,
                'grand_subtotal'           => $grandSubtotal,
                'delivery_charge'          => $deliveryCharge,
                'discount_amount'          => $discountAmount,
                'discount_type'            => $request->input('discount_type', $purchase->discount_type ?? 'fixed'),
                'discount_rate'            => $request->filled('discount_rate') ? (float) $request->discount_rate : null,
                'return_adjustment_amount' => $returnAdj,
                'paid_amount'              => $requestedPaid,
                'due_amount'               => $newDue,
                'attach_document'          => $img_url,
            ];
            if ($request->filled('purchase_payable_amount')) {
                $updateData['purchase_payable_amount'] = $request->input('purchase_payable_amount');
            }

            $purchase->update($updateData);

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Purchase updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'fail', 'message' => 'Failed to update purchase: ' . $e->getMessage()]);
        }
    }

    public function PurchasesDelete(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $purchase_id = $request->input('id');

        DB::beginTransaction();
        try {
            // 1. Find and lock purchase
            $purchase = Purchase::where('id', $purchase_id)
                ->orWhere('purchase_id', $purchase_id)
                ->lockForUpdate()
                ->first();

            if (!$purchase) {
                DB::rollBack();
                return response()->json([
                    'status' => 'fail',
                    'message' => 'পারচেজ রেকর্ডটি খুঁজে পাওয়া যায়নি বা ইতিমধ্যে ডিলিট করা হয়েছে।'
                ], 404);
            }

            // 2. Check for existing purchase returns
            $hasReturns = DB::table('purchase_returns')->where('purchase_id', $purchase->id)->exists();
            if ($hasReturns) {
                DB::rollBack();
                return response()->json([
                    'status' => 'fail',
                    'message' => 'এই পারচেজ ইনভয়েসের বিপরীতে রিটার্ন এন্ট্রি রয়েছে, তাই ডিলিট করা সম্ভব নয়। রিটার্ন রেকর্ড আগে সামঞ্জস্য করতে হবে।'
                ], 422);
            }

            // 3. Load purchase line items
            $orderDetails = PurchaseOrderDetails::where('purchase_id', $purchase->id)->get();

            // Group required quantities by product_id
            $qtyByProduct = [];
            foreach ($orderDetails as $item) {
                $pid = $item->product_id;
                $qtyByProduct[$pid] = ($qtyByProduct[$pid] ?? 0) + (int) $item->quantity;
            }

            // 4. Pre-check: Validate that current stock is sufficient for every product (prevent negative stock)
            foreach ($qtyByProduct as $productId => $qtyToReverse) {
                $product = Product::lockForUpdate()->find($productId);
                if (!$product) {
                    continue;
                }

                if ($product->quantity < $qtyToReverse) {
                    DB::rollBack();
                    $name = $product->product_name ?? ('পণ্য #' . $productId);
                    return response()->json([
                        'status' => 'fail',
                        'message' => "পণ্য '{$name}' ইতিমধ্যে বিক্রি বা ব্যবহার হয়ে গেছে (বর্তমান স্টক: {$product->quantity}, পারচেজ পরিমাণ: {$qtyToReverse})। স্টক নেগেটিভ হওয়া রোধে এই পারচেজ ডিলিট করা সম্ভব নয়।"
                    ], 422);
                }
            }

            // 5. Reverse product stock & recalculate cost price
            foreach ($orderDetails as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);
                if (!$product) {
                    continue;
                }

                $qtyToReverse = (int) $item->quantity;
                $purchaseCost = (float) $item->cost_price;
                $currentQty = (int) $product->quantity;
                $currentCost = (float) $product->cost_price;

                $newQty = max(0, $currentQty - $qtyToReverse);

                // Find previous or latest other purchase for this product
                $previousPurchase = PurchaseOrderDetails::where('product_id', $product->id)
                    ->where('purchase_id', '!=', $purchase->id)
                    ->latest('id')
                    ->first();

                if ($newQty > 0) {
                    $currentTotalValue = $currentCost * $currentQty;
                    $purchasedValue = $purchaseCost * $qtyToReverse;
                    $remainingValue = $currentTotalValue - $purchasedValue;

                    if ($remainingValue > 0) {
                        $product->cost_price = round($remainingValue / $newQty, 2);
                    } elseif ($previousPurchase) {
                        $product->cost_price = round((float) $previousPurchase->cost_price, 2);
                    }
                } else {
                    // Stock is 0; restore previous purchase cost price if available
                    if ($previousPurchase) {
                        $product->cost_price = round((float) $previousPurchase->cost_price, 2);
                    }
                }

                $product->quantity = $newQty;
                $product->save();
            }

            // 6. Delete payment details first (due to foreign key constraint to purchase_order_details)
            PurchasePaymentDetails::where('purchases_id', $purchase->id)->delete();

            // 7. Delete purchase order details
            PurchaseOrderDetails::where('purchase_id', $purchase->id)->delete();

            // 8. Delete attached document file if exists
            if (!empty($purchase->attach_document)) {
                $docPath = public_path($purchase->attach_document);
                if (file_exists($docPath) && is_file($docPath)) {
                    @unlink($docPath);
                }
            }

            // 9. Delete purchase record
            $purchase->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'পারচেজ এবং সম্পর্কিত স্টক ও পেমেন্ট রেকর্ড সফলভাবে রিভার্স ও ডিলিট করা হয়েছে।'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'fail',
                'message' => 'পারচেজ ডিলিট করতে সমস্যা হয়েছে: ' . $e->getMessage()
            ], 500);
        }
    }

    public function PurchaseSplitInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase_id'              => 'required|integer|exists:purchases,id',
            'detail_ids'               => 'required|array|min:1',
            'detail_ids.*'             => 'required|integer|exists:purchase_order_details,id',
            'new_discount_type'        => 'nullable|string|in:fixed,percent',
            'new_discount_rate'        => 'nullable|numeric|min:0|max:100',
            'new_discount_amount'      => 'nullable|numeric|min:0',
            'original_discount_type'   => 'nullable|string|in:fixed,percent',
            'original_discount_rate'   => 'nullable|numeric|min:0|max:100',
            'original_discount_amount' => 'nullable|numeric|min:0',
            'referance_no'             => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'fail',
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $sourcePurchase = Purchase::with(['orderDetails', 'paymentDetails', 'supplier'])
                ->where('id', $request->purchase_id)
                ->lockForUpdate()
                ->firstOrFail();

            $allDetails = $sourcePurchase->orderDetails;
            $selectedDetailIds = array_unique($request->detail_ids);

            // Validation: Ensure all selected IDs belong to this purchase
            $validIds = $allDetails->pluck('id')->all();
            foreach ($selectedDetailIds as $sId) {
                if (!in_array($sId, $validIds)) {
                    DB::rollBack();
                    return response()->json([
                        'status'  => 'fail',
                        'message' => "Line item ID #{$sId} does not belong to purchase {$sourcePurchase->purchase_id}."
                    ], 422);
                }
            }

            // Cannot split all items
            if (count($selectedDetailIds) >= $allDetails->count()) {
                DB::rollBack();
                return response()->json([
                    'status'  => 'fail',
                    'message' => 'Cannot split all items into a new invoice. At least one line item must remain in the source purchase.'
                ], 422);
            }

            $selectedDetails = $allDetails->whereIn('id', $selectedDetailIds);
            $remainingDetails = $allDetails->whereNotIn('id', $selectedDetailIds);

            // 1. Calculate Subtotals (Preserve exact cost_price and quantities)
            $newSubtotal = (float) $selectedDetails->sum(function ($d) {
                return (float) ($d->cost_price ?? 0) * (float) ($d->quantity ?? 1);
            });

            $remainingSubtotal = (float) $remainingDetails->sum(function ($d) {
                return (float) ($d->cost_price ?? 0) * (float) ($d->quantity ?? 1);
            });

            // 2. New Invoice Discount Calculation
            $newDiscountType = $request->input('new_discount_type', 'fixed');
            $newDiscountRate = $request->filled('new_discount_rate') ? (float) $request->new_discount_rate : null;
            $newDiscountAmount = 0.00;

            if ($newDiscountType === 'percent' && $newDiscountRate !== null) {
                $newDiscountAmount = round(($newSubtotal * $newDiscountRate) / 100, 2);
            } else {
                $newDiscountAmount = round((float) $request->input('new_discount_amount', 0), 2);
            }
            $newDiscountAmount = min($newSubtotal, max(0, $newDiscountAmount));
            $newNetPayable = max(0, $newSubtotal - $newDiscountAmount);

            // 3. Remaining (Source) Invoice Discount Calculation
            if ($request->filled('original_discount_type')) {
                $origDiscountType = $request->input('original_discount_type');
                $origDiscountRate = $request->filled('original_discount_rate') ? (float) $request->original_discount_rate : null;
                if ($origDiscountType === 'percent' && $origDiscountRate !== null) {
                    $remainingDiscountAmount = round(($remainingSubtotal * $origDiscountRate) / 100, 2);
                } else {
                    $remainingDiscountAmount = round((float) $request->input('original_discount_amount', 0), 2);
                }
            } else {
                // Preserve verified configuration of source purchase
                $origDiscountType = $sourcePurchase->discount_type ?? 'fixed';
                $origDiscountRate = $sourcePurchase->discount_rate !== null ? (float) $sourcePurchase->discount_rate : null;
                if ($origDiscountType === 'percent' && $origDiscountRate !== null) {
                    $remainingDiscountAmount = round(($remainingSubtotal * $origDiscountRate) / 100, 2);
                } else {
                    $prevFixed = (float) ($sourcePurchase->discount_amount ?? 0);
                    if ($sourcePurchase->grand_subtotal > 0 && $prevFixed > 0) {
                        $remainingDiscountAmount = round($prevFixed * ($remainingSubtotal / $sourcePurchase->grand_subtotal), 2);
                    } else {
                        $remainingDiscountAmount = 0.00;
                    }
                }
            }
            $remainingDiscountAmount = min($remainingSubtotal, max(0, $remainingDiscountAmount));
            $sourceDelivery = (float) ($sourcePurchase->delivery_charge ?? 0);
            $remainingNetPayable = max(0, ($remainingSubtotal - $remainingDiscountAmount) + $sourceDelivery);

            // 4. Authoritative Payment Allocation
            $historicalPaid = (float) ($sourcePurchase->paymentDetails ? $sourcePurchase->paymentDetails->sum('paid_amount') : $sourcePurchase->paid_amount);
            $combinedPayable = $remainingNetPayable + $newNetPayable;

            if ($combinedPayable <= 0) {
                $newPaid = 0.00;
                $remainingPaid = 0.00;
            } elseif ($historicalPaid >= $combinedPayable) {
                // Fully covered - both invoices will be settled
                $newPaid = $newNetPayable;
                $remainingPaid = $remainingNetPayable;
                $excessPaid = round($historicalPaid - $combinedPayable, 2);
                if ($excessPaid > 0) {
                    // Retain excess payment in the source invoice payment records to strictly preserve total paid history
                    $remainingPaid = round($remainingPaid + $excessPaid, 2);
                }
            } else {
                // Proportionally distribute paid amount
                $newPaid = round($historicalPaid * ($newNetPayable / $combinedPayable), 2);
                $remainingPaid = max(0, round($historicalPaid - $newPaid, 2));
            }

            $newDue = max(0, round($newNetPayable - $newPaid, 2));
            $remainingDue = max(0, round($remainingNetPayable - $remainingPaid, 2));

            $newStatus = ($newDue <= 0 && $newNetPayable > 0) ? 'Fully Paid' : ($newPaid > 0 ? 'Partial Paid' : 'Unpaid');
            $remainingStatus = ($remainingDue <= 0 && $remainingNetPayable > 0) ? 'Fully Paid' : ($remainingPaid > 0 ? 'Partial Paid' : 'Unpaid');

            // 5. Generate New Purchase ID & Reference
            $newPurchaseId = $this->generatePurchasesID();
            $newRef = $request->input('referance_no') 
                ?: ($sourcePurchase->referance_no ? $sourcePurchase->referance_no . '-SPLIT' : 'SPLIT-' . time());

            // 6. Create New Purchase Record
            $newPurchase = Purchase::create([
                'purchase_id'              => $newPurchaseId,
                'referance_no'             => $newRef,
                'date'                     => $sourcePurchase->date,
                'grand_subtotal'           => $newSubtotal,
                'delivery_charge'          => 0.00,
                'discount_amount'          => $newDiscountAmount,
                'discount_type'            => $newDiscountType,
                'discount_rate'            => $newDiscountRate,
                'paid_amount'              => $newPaid,
                'due_amount'               => $newDue,
                'purchase_payable_amount'  => $newDue,
                'return_adjustment_amount' => 0.00,
                'attach_document'          => $sourcePurchase->attach_document,
                'supplier_id'              => $sourcePurchase->supplier_id,
                'user_id'                  => Auth::id() ?? $sourcePurchase->user_id,
            ]);

            // 7. Reassign Selected Line Items (Zero stock modifications!)
            PurchaseOrderDetails::whereIn('id', $selectedDetailIds)
                ->update(['purchase_id' => $newPurchase->id]);

            // 8. Update Source Purchase Record
            $sourcePurchase->update([
                'grand_subtotal'          => $remainingSubtotal,
                'discount_amount'         => $remainingDiscountAmount,
                'discount_type'           => $origDiscountType,
                'discount_rate'           => $origDiscountRate,
                'paid_amount'             => $remainingPaid,
                'due_amount'              => $remainingDue,
                'purchase_payable_amount' => $remainingDue,
            ]);

            // 9. Allocate Payment Details Records
            $firstPayment = $sourcePurchase->paymentDetails->first();
            $paymentMethod = $firstPayment ? $firstPayment->payment_method : 'Bank';
            $sourceTrx = $firstPayment ? $firstPayment->transaction_id : null;
            $dueDate = $firstPayment ? $firstPayment->purchase_due_collection_date : $sourcePurchase->date;

            if ($newPaid > 0) {
                PurchasePaymentDetails::create([
                    'purchases_id'                 => $newPurchase->id,
                    'paid_amount'                  => $newPaid,
                    'discount_amount'              => 0.00,
                    'payment_method'               => $paymentMethod,
                    'transaction_id'               => $sourceTrx ? "Allocated from {$sourcePurchase->purchase_id} ({$sourceTrx})" : "Allocated from {$sourcePurchase->purchase_id}",
                    'payment_status'               => $newStatus,
                    'purchase_due_collection_date' => $dueDate,
                    'user_id'                      => Auth::id() ?? $sourcePurchase->user_id,
                ]);
            }

            if ($firstPayment) {
                $firstPayment->update([
                    'paid_amount'    => $remainingPaid,
                    'payment_status' => $remainingStatus,
                ]);
            }

            DB::commit();

            return response()->json([
                'status'          => 'success',
                'message'         => "Successfully split " . count($selectedDetailIds) . " items into new invoice {$newPurchaseId}.",
                'source_purchase' => $sourcePurchase->fresh(['orderDetails.product', 'paymentDetails']),
                'new_purchase'    => $newPurchase->fresh(['orderDetails.product', 'paymentDetails']),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Purchase Split Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'status'  => 'fail',
                'message' => 'Failed to split purchase invoice: ' . $e->getMessage()
            ], 500);
        }
    }

}
