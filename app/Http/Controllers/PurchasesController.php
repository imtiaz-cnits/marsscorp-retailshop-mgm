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
use App\Models\SupplierDueCollection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

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
        Log::error('Purchase List Error: ' . $e->getMessage());
        return response()->json([
            'status' => 'fail',
            'PurchasessData' => [],
            'message' => $e->getMessage()
        ]);
    }
}


    public function PurchasesCreate(Request $request)
    {
        $uploadedFilePath = null;

        try {
            $user_id = Auth::id() ?? auth('sanctum')->id() ?? auth()->id() ?? $request->user()?->id ?? \App\Models\User::first()?->id ?? 1;
            DB::beginTransaction();

            // Handle document upload if there's an image file
            $img_url = null;
            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $destination = public_path('uploads/purchases-img');
                if (!file_exists($destination)) {
                    @mkdir($destination, 0777, true);
                }
                $cleanName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $img->getClientOriginalName());
                $img_name = "{$user_id}-" . time() . "-" . $cleanName;
                $img_url = "uploads/purchases-img/{$img_name}";
                $img->move($destination, $img_name);
                $uploadedFilePath = public_path($img_url);
            }

            // Parse and format date to Y-m-d for database storage
            $formattedDate = now()->format('Y-m-d');
            if ($request->filled('date')) {
                try {
                    $formattedDate = Carbon::parse($request->date)->format('Y-m-d');
                } catch (\Throwable $e) {
                    $formattedDate = now()->format('Y-m-d');
                }
            }

            $formattedDueDate = $formattedDate;
            if ($request->filled('purchase_due_collection_date')) {
                try {
                    $formattedDueDate = Carbon::parse($request->purchase_due_collection_date)->format('Y-m-d');
                } catch (\Throwable $e) {
                    $formattedDueDate = $formattedDate;
                }
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
                $this->cleanupOrphanFile($uploadedFilePath);
                Log::warning('PurchasesCreate failed: invalid supplier', [
                    'actor_user_id' => $user_id,
                    'supplier_input' => $request->input('supplier_id'),
                ]);
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Please select a valid supplier.'
                ]);
            }

            // Validate products
            $products = $request->products;
            if (!is_array($products)) {
                $products = json_decode($products, true) ?? [];
            }
            if (!is_array($products) || count($products) === 0) {
                DB::rollBack();
                $this->cleanupOrphanFile($uploadedFilePath);
                Log::warning('PurchasesCreate failed: empty product list', [
                    'actor_user_id' => $user_id,
                    'supplier_id' => $supplier_id,
                ]);
                return response()->json([
                    'status' => 'fail',
                    'message' => 'At least one product must be added to purchase.'
                ]);
            }

            // Validate line quantities and lock products in deterministic ascending ID order
            $productIdsToLock = [];
            foreach ($products as $product) {
                if (isset($product['product_id'], $product['quantity'])) {
                    $prodId = (int) $product['product_id'];
                    $qty = (int) $product['quantity'];
                    if ($prodId <= 0 || $qty <= 0) {
                        DB::rollBack();
                        $this->cleanupOrphanFile($uploadedFilePath);
                        Log::warning('PurchasesCreate failed: invalid product quantity', [
                            'actor_user_id' => $user_id,
                            'supplier_id' => $supplier_id,
                            'product_id' => $prodId,
                            'quantity' => $qty,
                        ]);
                        return response()->json([
                            'status' => 'fail',
                            'message' => 'All purchase items must have valid product IDs and positive quantities.'
                        ], 422);
                    }
                    $productIdsToLock[] = $prodId;
                }
            }

            $productIdsToLock = array_values(array_unique($productIdsToLock));
            sort($productIdsToLock);

            $lockedProducts = !empty($productIdsToLock)
                ? Product::whereIn('id', $productIdsToLock)->orderBy('id', 'asc')->lockForUpdate()->get()->keyBy('id')
                : collect();

            foreach ($productIdsToLock as $pidCheck) {
                if (!$lockedProducts->has($pidCheck)) {
                    DB::rollBack();
                    $this->cleanupOrphanFile($uploadedFilePath);
                    Log::warning('PurchasesCreate failed: product not found', [
                        'actor_user_id' => $user_id,
                        'supplier_id' => $supplier_id,
                        'missing_product_id' => $pidCheck,
                    ]);
                    return response()->json([
                        'status' => 'fail',
                        'message' => "Product ID #{$pidCheck} was not found."
                    ], 404);
                }
            }

            // Create Purchase record
            $purchaseData = [
                'purchase_id' => $this->generatePurchasesID(),
                'purchase_payable_amount' => $request->purchase_payable_amount ?? $request->grand_subtotal ?? 0,
                'paid_amount' => $request->paid_amount ?? 0,
                'due_amount' => $request->due_amount ?? 0,
                'referance_no' => $request->referance_no,
                'date' => $formattedDate,
                'grand_subtotal' => $request->grand_subtotal ?? 0,
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

            // Save product details in the `purchase_order_details` table and mutate locked products
            $auditProducts = [];
            foreach ($products as $product) {
                if (isset($product['product_id'], $product['quantity'])) {
                    $prodId = (int) $product['product_id'];
                    $qty = (int) $product['quantity'];
                    $costPrice = (float) ($product['cost_price'] ?? 0);
                    $subtotal = (float) ($product['subtotal'] ?? ($costPrice * $qty));

                    $productModel = $lockedProducts->get($prodId);
                    if (!$productModel) {
                        DB::rollBack();
                        $this->cleanupOrphanFile($uploadedFilePath);
                        return response()->json([
                            'status' => 'fail',
                            'message' => "Product ID #{$prodId} was not found."
                        ], 404);
                    }

                    PurchaseOrderDetails::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $prodId,
                        'quantity' => $qty,
                        'cost_price' => $costPrice,
                        'subtotal' => $subtotal,
                        'user_id' => $user_id,
                    ]);

                    // Existing inventory
                    $existingCostPrice = (float) $productModel->cost_price;
                    $existingQuantity = (int) $productModel->quantity;

                    // Weighted average cost calculation with zero/negative stock safety
                    if ($existingQuantity > 0 && ($existingQuantity + $qty) > 0) {
                        $updatedCostPrice = (($existingCostPrice * $existingQuantity) + ($costPrice * $qty)) / ($existingQuantity + $qty);
                        $productModel->cost_price = round($updatedCostPrice, 2);
                    } else {
                        // If stock was 0 or negative, incoming purchase establishes unit cost price
                        $productModel->cost_price = round($costPrice, 2);
                    }

                    $newStock = $existingQuantity + $qty;
                    $productModel->quantity = $newStock;

                    // Safely update or merge product_code
                    if (isset($product['product_code']) && !empty($product['product_code'])) {
                        $newCodes = $product['product_code'];

                        if (!is_array($newCodes)) {
                            $decoded = json_decode($newCodes, true);
                            $newCodes = is_array($decoded) ? $decoded : (is_string($newCodes) ? [$newCodes] : []);
                        }

                        if (is_array($newCodes) && count($newCodes) > 0) {
                            $existingCodes = [];
                            if (!empty($productModel->product_code)) {
                                if (is_array($productModel->product_code)) {
                                    $existingCodes = $productModel->product_code;
                                } else {
                                    $decoded = json_decode($productModel->product_code, true);
                                    $existingCodes = is_array($decoded) ? $decoded : (is_scalar($decoded) && $decoded !== '' ? [(string)$decoded] : [(string)$productModel->product_code]);
                                }
                            }

                            $mergedCodes = array_values(array_unique(array_merge($existingCodes, $newCodes)));
                            $productModel->product_code = json_encode($mergedCodes);
                        }
                    }

                    $productModel->save();

                    $auditProducts[] = [
                        'product_id' => $prodId,
                        'added_qty' => $qty,
                        'old_stock' => $existingQuantity,
                        'new_stock' => $newStock,
                        'unit_cost' => $costPrice,
                        'old_cost' => $existingCostPrice,
                        'new_cost' => (float) $productModel->cost_price,
                    ];
                }
            }

            // Record payment details
            $paidAmount = (float) ($request->paid_amount ?? 0);
            $paymentMethod = $request->payment_method;
            if (empty($paymentMethod) || $paymentMethod === 'Select Method') {
                $paymentMethod = $paidAmount > 0 ? 'Cash' : null;
            }
            $paymentStatus = $request->payment_status ?: ($paidAmount > 0 ? ((float)($request->due_amount ?? 0) <= 0 ? 'Fully Paid' : 'Partial Paid') : 'Unpaid');

            PurchasePaymentDetails::create([
                'purchases_id' => $purchase->id,
                'paid_amount' => $paidAmount,
                'discount_amount' => (float) ($request->discount_amount ?? 0),
                'transaction_id' => $request->transaction_id ?? null,
                'purchase_due_collection_date' => $formattedDueDate,
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentStatus,
                'user_id' => $user_id,
            ]);

            DB::commit();

            Log::info('Purchase Created', [
                'actor_user_id' => $user_id,
                'purchase_id' => $purchase->id,
                'purchase_code' => $purchase->purchase_id,
                'supplier_id' => $supplier_id,
                'date' => $formattedDate,
                'grand_subtotal' => (float) $purchase->grand_subtotal,
                'paid_amount' => $paidAmount,
                'due_amount' => (float) $purchase->due_amount,
                'products' => $auditProducts,
                'result' => 'success',
                'timestamp' => now()->toIso8601String(),
            ]);

            \App\Services\ActivityLogger::log(
                'Purchase',
                'Purchase',
                "Created purchase #{$purchase->purchase_id} (Total: ৳ " . number_format((float)$purchase->grand_subtotal, 2) . ", Paid: ৳ " . number_format((float)$purchase->paid_amount, 2) . ")",
                ['purchase_id' => $purchase->id, 'purchase_code' => $purchase->purchase_id, 'supplier_id' => $supplier_id]
            );

            return response()->json(['status' => 'success', 'message' => 'Purchase created successfully']);
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->cleanupOrphanFile($uploadedFilePath);
            Log::error('Purchase Create Error: ' . $e->getMessage(), [
                'actor_user_id' => Auth::id(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return response()->json([
                'status' => 'fail',
                'message' => 'Failed to create purchase: ' . $e->getMessage()
            ], 200);
        }
    }


private function generatePurchasesID()
{
    $prefix = '#PurID';

    $last = Purchase::orderBy('id', 'desc')->first();
    $number = $last ? ($last->id + 1) : 1;
    $id = $prefix . str_pad($number, 5, '0', STR_PAD_LEFT);
    while (Purchase::where('purchase_id', $id)->exists()) {
        $number++;
        $id = $prefix . str_pad($number, 5, '0', STR_PAD_LEFT);
    }
    return $id;
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
        Log::error('API Error: ' . $e->getMessage());
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
    $request->validate([
        'id'             => 'required|integer|exists:purchases,id',
        'paid_amount'    => 'required|numeric|min:0.01',
        'payment_method' => 'required|string',
        'transaction_id' => 'nullable|string|max:255'
    ]);

    DB::beginTransaction();
    $actorUserId = Auth::id();
    try {
        $purchase = Purchase::lockForUpdate()->findOrFail($request->id);
        $lockedPayments = PurchasePaymentDetails::where('purchases_id', $purchase->id)
            ->orderBy('id', 'asc')
            ->lockForUpdate()
            ->get();

        $oldPaid        = (float) $purchase->paid_amount;
        $oldDue         = (float) $purchase->due_amount;
        $currentPaid    = (float) ($lockedPayments->sum('paid_amount') ?? 0);
        $addedPaid      = (float) $request->paid_amount;
        $newPaid        = $currentPaid + $addedPaid;
        $grandTotal     = (float) ($purchase->grand_subtotal ?? 0);
        $deliveryCharge = (float) ($purchase->delivery_charge ?? 0);
        $discountAmount = (float) ($purchase->discount_amount ?? 0);
        $netTotal       = max(0, ($grandTotal - $discountAmount) + $deliveryCharge);
        $newDue         = max(0, $netTotal - $newPaid);

        $todayDate = Carbon::today()->format('Y-m-d');

        PurchasePaymentDetails::create([
            'purchases_id'                => $purchase->id,
            'paid_amount'                 => $addedPaid,
            'discount_amount'             => 0,
            'payment_method'              => $request->payment_method,
            'transaction_id'              => $request->transaction_id,
            'payment_status'              => $newDue <= 0 ? 'Fully Paid' : 'Partial Paid',
            'purchase_due_collection_date'=> $todayDate,
            'purchase_order_details_id'   => null,
            'user_id'                     => $actorUserId,
        ]);

        $purchase->update([
            'paid_amount' => $newPaid,
            'due_amount'  => $newDue,
        ]);

        DB::commit();

        Log::info('Purchase Payment Updated', [
            'actor_user_id' => $actorUserId,
            'purchase_id' => $purchase->id,
            'purchase_code' => $purchase->purchase_id,
            'supplier_id' => $purchase->supplier_id,
            'added_paid_amount' => $addedPaid,
            'old_paid_amount' => $oldPaid,
            'new_paid_amount' => $newPaid,
            'old_due_amount' => $oldDue,
            'new_due_amount' => $newDue,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'result' => 'success',
            'timestamp' => now()->toIso8601String(),
        ]);

        return response()->json([
            'status'   => 'success',
            'message'  => 'Payment saved successfully!',
            'new_paid' => $newPaid,
            'new_due'  => $newDue,
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Purchase Payment Update Error', [
            'actor_user_id' => $actorUserId,
            'purchase_id' => $request->input('id'),
            'error' => $e->getMessage(),
        ]);
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

    /**
     * Unified Conservative Historical Integrity Check (Policy P2) shared by PurchasesDelete & PurchasesUpdate.
     *
     * Relies on parent business dates (`purchases.date` vs `orders.invoice_date`) rather than
     * volatile `order_details.created_at` (which historically drifted on invoice edits).
     * Never infers FIFO/lot attribution from pooled stock; blocks conservatively on any
     * subsequent sale or missing/malformed/ambiguous business date so manual review is required.
     */
    private function parseStrictBusinessDate(mixed $rawDate, bool $allowTimeSuffix = false): ?string
    {
        if ($rawDate instanceof \DateTimeInterface) {
            return $rawDate->format('Y-m-d');
        }
        if (!is_string($rawDate)) {
            return null;
        }
        $dateStr = trim($rawDate);
        if ($dateStr === '') {
            return null;
        }

        if ($allowTimeSuffix && preg_match('/^(\d{4})-(\d{2})-(\d{2})(?:[ T]\d{2}:\d{2}:\d{2})?$/', $dateStr, $m)) {
            $year = (int) $m[1];
            $month = (int) $m[2];
            $day = (int) $m[3];
            return checkdate($month, $day, $year) ? sprintf('%04d-%02d-%02d', $year, $month, $day) : null;
        }

        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $dateStr, $m)) {
            $year = (int) $m[1];
            $month = (int) $m[2];
            $day = (int) $m[3];
            return checkdate($month, $day, $year) ? sprintf('%04d-%02d-%02d', $year, $month, $day) : null;
        }

        if (preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', $dateStr, $m)) {
            $day = (int) $m[1];
            $month = (int) $m[2];
            $year = (int) $m[3];
            return checkdate($month, $day, $year) ? sprintf('%04d-%02d-%02d', $year, $month, $day) : null;
        }

        return null;
    }

    private function validatePurchaseHistoricalIntegrity(
        Purchase $purchase,
        array $productIds,
        string $operation,
        ?int $actorUserId = null,
        ?string $proposedDate = null
    ) {
        $productIds = array_values(array_unique(array_filter(array_map('intval', $productIds))));
        sort($productIds);

        if (empty($productIds)) {
            return null;
        }

        // 1. Validate Purchase business date & created_at conservatively
        if (empty($purchase->date)) {
            Log::warning("Purchase {$operation} blocked: missing purchase business date (manual review required)", [
                'actor_user_id' => $actorUserId,
                'purchase_id' => $purchase->id,
                'purchase_code' => $purchase->purchase_id,
                'reason' => 'missing_purchase_date',
            ]);
            return response()->json([
                'status' => 'fail',
                'message' => 'এই পারচেজ রেকর্ডের ব্যবসায়িক তারিখ (date) অনুপস্থিত থাকায় ঐতিহাসিক লাইনেজ যাচাই করা সম্ভব নয়; ম্যানুয়াল রিভিউ প্রয়োজন।'
            ], 422);
        }

        $purchaseDateStr = $this->parseStrictBusinessDate($purchase->date, allowTimeSuffix: true);
        if ($purchaseDateStr === null) {
            Log::warning("Purchase {$operation} blocked: malformed purchase business date", [
                'actor_user_id' => $actorUserId,
                'purchase_id' => $purchase->id,
                'purchase_code' => $purchase->purchase_id,
                'raw_date' => $purchase->date,
                'reason' => 'malformed_purchase_date',
            ]);
            return response()->json([
                'status' => 'fail',
                'message' => 'পারচেজের তারিখ সঠিক ফরম্যাটে না থাকায় অপারেশনটি ব্লক করা হয়েছে; ম্যানুয়াল রিভিউ প্রয়োজন।'
            ], 422);
        }

        if (empty($purchase->created_at) || str_starts_with((string) $purchase->created_at, '0000-00-00')) {
            Log::warning("Purchase {$operation} blocked: missing purchase created_at", [
                'actor_user_id' => $actorUserId,
                'purchase_id' => $purchase->id,
                'purchase_code' => $purchase->purchase_id,
                'reason' => 'missing_purchase_created_at',
            ]);
            return response()->json([
                'status' => 'fail',
                'message' => 'পারচেজ তৈরির টাইমস্ট্যাম্প অনুপস্থিত থাকায় ঐতিহাসিক ইন্টেগ্রিটি যাচাই সম্ভব নয়; ম্যানুয়াল রিভিউ প্রয়োজন।'
            ], 422);
        }

        $effectiveStartDateStr = $purchaseDateStr;
        $proposedDateStr = null;
        if ($proposedDate !== null) {
            $proposedDateStr = $this->parseStrictBusinessDate($proposedDate);
            if ($proposedDateStr === null) {
                Log::warning("Purchase {$operation} blocked: malformed proposed purchase date", [
                    'actor_user_id' => $actorUserId,
                    'purchase_id' => $purchase->id,
                    'raw_proposed_date' => $proposedDate,
                    'reason' => 'malformed_proposed_date',
                ]);
                return response()->json([
                    'status' => 'fail',
                    'message' => 'প্রস্তাবিত পারচেজ তারিখটি সঠিক নয়।'
                ], 422);
            }
            if ($proposedDateStr < $effectiveStartDateStr) {
                $effectiveStartDateStr = $proposedDateStr;
            }
        }

        // Reject future-dated purchase anomalies (> 1 day ahead of created_at) on both stored and proposed dates
        $purchaseCreatedCarbon = Carbon::parse($purchase->created_at);
        $maxAllowedPurchaseDate = $purchaseCreatedCarbon->copy()->addDay()->endOfDay();
        if (
            Carbon::parse($effectiveStartDateStr)->gt($maxAllowedPurchaseDate) ||
            ($proposedDateStr !== null && Carbon::parse($proposedDateStr)->gt($maxAllowedPurchaseDate))
        ) {
            Log::warning("Purchase {$operation} blocked: purchase business date exceeds created_at", [
                'actor_user_id' => $actorUserId,
                'purchase_id' => $purchase->id,
                'purchase_code' => $purchase->purchase_id,
                'purchase_date' => $proposedDateStr ?? $effectiveStartDateStr,
                'purchase_created_at' => (string) $purchase->created_at,
                'reason' => 'ambiguous_future_purchase_date',
            ]);
            return response()->json([
                'status' => 'fail',
                'message' => 'পারচেজের তারিখ ও তৈরির সময়ের মধ্যে অসঙ্গতি থাকায় ম্যানুয়াল রিভিউ ছাড়া পরিবর্তন করা যাবে না।'
            ], 422);
        }

        // 2. Inspect active net sales joined to parent orders using business dates
        $salesRows = DB::table('order_details AS od')
            ->join('orders AS o', 'o.id', '=', 'od.order_id')
            ->whereIn('od.product_id', $productIds)
            ->whereRaw('(CAST(od.quantity AS SIGNED) - COALESCE(od.return_quantity, 0)) > 0')
            ->select([
                'od.product_id',
                'od.order_id',
                'o.order_no',
                'o.invoice_date',
                'o.created_at AS order_created_at',
                DB::raw('(CAST(od.quantity AS SIGNED) - COALESCE(od.return_quantity, 0)) AS net_sold'),
            ])
            ->orderBy('od.product_id', 'asc')
            ->orderBy('o.id', 'asc')
            ->get();

        $ambiguousOrders = [];
        $subsequentSalesByProduct = [];

        foreach ($salesRows as $row) {
            if (empty($row->invoice_date)) {
                $ambiguousOrders[] = [
                    'order_id' => $row->order_id,
                    'order_no' => $row->order_no,
                    'product_id' => (int) $row->product_id,
                    'reason' => 'null_invoice_date',
                ];
                continue;
            }

            $invoiceDateStr = $this->parseStrictBusinessDate($row->invoice_date, allowTimeSuffix: true);
            if ($invoiceDateStr === null) {
                $ambiguousOrders[] = [
                    'order_id' => $row->order_id,
                    'order_no' => $row->order_no,
                    'product_id' => (int) $row->product_id,
                    'raw_invoice_date' => $row->invoice_date,
                    'reason' => 'malformed_invoice_date',
                ];
                continue;
            }

            if ($invoiceDateStr >= $effectiveStartDateStr) {
                $pid = (int) $row->product_id;
                if (!isset($subsequentSalesByProduct[$pid])) {
                    $subsequentSalesByProduct[$pid] = [
                        'net_sold' => 0,
                        'orders' => [],
                    ];
                }
                $subsequentSalesByProduct[$pid]['net_sold'] += (int) $row->net_sold;
                $subsequentSalesByProduct[$pid]['orders'][] = ($row->order_no ?? ('#' . $row->order_id)) . " ({$invoiceDateStr})";
            }
        }

        if (!empty($ambiguousOrders)) {
            Log::warning("Purchase {$operation} blocked: ambiguous or missing invoice date on historical sales", [
                'actor_user_id' => $actorUserId,
                'purchase_id' => $purchase->id,
                'purchase_code' => $purchase->purchase_id,
                'purchase_date' => $effectiveStartDateStr,
                'ambiguous_orders' => array_slice($ambiguousOrders, 0, 10),
                'reason' => 'missing_or_malformed_invoice_date',
            ]);
            return response()->json([
                'status' => 'fail',
                'message' => 'সংশ্লিষ্ট একটি বা একাধিক বিক্রয় ইনভয়েসে তারিখ (invoice_date) অনুপস্থিত বা অস্পষ্ট থাকায় ঐতিহাসিক স্টক যাচাই সম্ভব নয়। অনুগ্রহ করে ম্যানুয়াল রিভিউ করুন।'
            ], 422);
        }

        if (!empty($subsequentSalesByProduct)) {
            $firstPid = array_key_first($subsequentSalesByProduct);
            $firstProduct = Product::find($firstPid);
            $productName = $firstProduct?->product_name ?? ("পণ্য #{$firstPid}");
            $soldCount = $subsequentSalesByProduct[$firstPid]['net_sold'];

            Log::warning("Purchase {$operation} blocked: Policy P2 historical business-date integrity lock", [
                'actor_user_id' => $actorUserId,
                'purchase_id' => $purchase->id,
                'purchase_code' => $purchase->purchase_id,
                'purchase_date' => $effectiveStartDateStr,
                'purchase_created_at' => (string) $purchase->created_at,
                'blocked_products' => $subsequentSalesByProduct,
                'reason' => 'subsequent_sales_on_or_after_purchase_business_date',
            ]);

            return response()->json([
                'status' => 'fail',
                'message' => "পণ্য '{$productName}' এই পারচেজের ব্যবসায়িক তারিখ ({$effectiveStartDateStr}) বা তার পরে ইতিমধ্যে {$soldCount} পিস বিক্রি হয়েছে (ঐতিহাসিক COGS/ইনভয়েস রেকর্ড বিদ্যমান)। পুলকৃত স্টকের কস্ট বেসিস সুরক্ষায় সরাসরি পারচেজ {$operation} করা সম্ভব নয়; অনুগ্রহ করে কম্পেনসেটিং অ্যাডজাস্টমেন্ট বা ম্যানুয়াল রিভিউ ব্যবহার করুন।"
            ], 422);
        }

        return null;
    }

    public function PurchasesUpdate(Request $request)
    {
        $purchase_id = $request->input('id');
        if (!$purchase_id) {
            return response()->json(['status' => 'fail', 'message' => 'Purchase ID is required'], 422);
        }

        $newUploadedFilePath = null;
        $oldAttachmentToCleanup = null;

        DB::beginTransaction();
        try {
            $purchase = Purchase::lockForUpdate()->find($purchase_id);
            if (!$purchase) {
                DB::rollBack();
                return response()->json(['status' => 'fail', 'message' => 'Purchase not found'], 404);
            }

            $user_id = Auth::id() ?? $purchase->user_id;
            $oldPurchaseDate = !empty($purchase->date)
                ? $this->parseStrictBusinessDate($purchase->date, allowTimeSuffix: true)
                : null;
            $oldPaid = (float) $purchase->paid_amount;

            $lockedOldDetails = PurchaseOrderDetails::where('purchase_id', $purchase->id)
                ->orderBy('id', 'asc')
                ->lockForUpdate()
                ->get();

            $lockedPayments = PurchasePaymentDetails::where('purchases_id', $purchase->id)
                ->orderBy('id', 'asc')
                ->lockForUpdate()
                ->get();

            $updateDate = $purchase->date;
            $hasExplicitDate = $request->has('date');
            if ($hasExplicitDate) {
                $parsedInputDate = $this->parseStrictBusinessDate($request->input('date'));
                if ($parsedInputDate === null) {
                    DB::rollBack();
                    Log::warning('PurchasesUpdate blocked: invalid date input', [
                        'actor_user_id' => $user_id,
                        'purchase_id' => $purchase->id,
                        'raw_date' => $request->input('date'),
                    ]);
                    return response()->json([
                        'status' => 'fail',
                        'message' => 'পারচেজের তারিখটি সঠিক নয়; অনুগ্রহ করে বৈধ YYYY-MM-DD বা DD-MM-YYYY তারিখ দিন।'
                    ], 422);
                }
                $updateDate = $parsedInputDate;
            }

            // Supplier resolution
            $supplier_id = $purchase->supplier_id;
            if ($request->filled('supplier_id') && $request->supplier_id !== 'none') {
                $supplier_id = (int) $request->supplier_id;
            }

            // Document upload (old file cleanup deferred strictly until after DB::commit)
            $img_url = $purchase->attach_document;
            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $cleanName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $img->getClientOriginalName());
                $img_name = "{$user_id}-" . time() . "-" . $cleanName;
                $img_url = "uploads/purchases-img/{$img_name}";
                $destination = public_path('uploads/purchases-img');
                if (!file_exists($destination)) {
                    @mkdir($destination, 0777, true);
                }
                $img->move($destination, $img_name);
                $newUploadedFilePath = public_path($img_url);
                $oldAttachmentToCleanup = $purchase->attach_document;
            }

            // Check if any products have been returned (purchase_returns table OR purchase_order_details.return_quantity)
            $purchaseReturns = DB::table('purchase_returns')
                ->where('purchase_id', $purchase->id)
                ->get();
            $returnsByProduct = $purchaseReturns->groupBy('product_id')->map(function ($group) {
                return (int) $group->sum('quantity');
            })->toArray();

            // Handle products reconciliation
            $rawProducts = $request->input('products');
            $products = null;
            if ($rawProducts !== null && $rawProducts !== '') {
                $products = is_array($rawProducts) ? $rawProducts : json_decode($rawProducts, true);
            }

            $oldItemsMap = [];
            foreach ($lockedOldDetails as $od) {
                $pid = (int) $od->product_id;
                $odQty = (int) $od->quantity;
                $odRet = (int) ($od->return_quantity ?? 0);
                $odCost = (float) $od->cost_price;
                $odSub = (float) $od->subtotal;

                if (isset($oldItemsMap[$pid])) {
                    $oldItemsMap[$pid]['quantity'] += $odQty;
                    $oldItemsMap[$pid]['return_quantity'] += $odRet;
                    $oldItemsMap[$pid]['subtotal'] += $odSub;
                } else {
                    $oldItemsMap[$pid] = [
                        'quantity'        => $odQty,
                        'return_quantity' => $odRet,
                        'cost_price'      => $odCost,
                        'subtotal'        => $odSub,
                    ];
                }
            }

            foreach ($oldItemsMap as $pid => $info) {
                $returnsByProduct[$pid] = max((int) ($returnsByProduct[$pid] ?? 0), (int) $info['return_quantity']);
            }

            $newItemsMap = [];
            if (is_array($products)) {
                foreach ($products as $p) {
                    if (isset($p['product_id']) && !empty($p['product_id'])) {
                        $pId = (int) $p['product_id'];
                        $qty = (int) ($p['quantity'] ?? 0);
                        $cost = (float) ($p['cost_price'] ?? 0);
                        $sub = (float) ($p['subtotal'] ?? ($qty * $cost));

                        if ($qty <= 0) {
                            DB::rollBack();
                            $this->cleanupOrphanFile($newUploadedFilePath);
                            return response()->json([
                                'status' => 'fail',
                                'message' => "পণ্য আইডি #{$pId} এর পরিমাণ অবশ্যই ০-এর বেশি হতে হবে।"
                            ], 422);
                        }

                        if (isset($newItemsMap[$pId])) {
                            $newItemsMap[$pId]['quantity'] += $qty;
                            $newItemsMap[$pId]['subtotal'] += $sub;
                        } else {
                            $newItemsMap[$pId] = [
                                'product_id'      => $pId,
                                'quantity'        => $qty,
                                'return_quantity' => (int) ($oldItemsMap[$pId]['return_quantity'] ?? 0),
                                'cost_price'      => $cost,
                                'subtotal'        => $sub,
                                'product_code'    => $p['product_code'] ?? null,
                            ];
                        }
                    }
                }
            }

            // Enforce Policy P2 Historical Integrity on PurchasesUpdate() whenever inventory, cost, supplier, or date changes
            $normalizedUpdateDate = !empty($updateDate)
                ? $this->parseStrictBusinessDate($updateDate, allowTimeSuffix: true)
                : null;
            $dateChanged = $hasExplicitDate && $normalizedUpdateDate !== $oldPurchaseDate;
            $supplierChanged = $request->filled('supplier_id') && (int) $supplier_id !== (int) $purchase->supplier_id;
            $financialsChanged = $request->filled('grand_subtotal') || $request->filled('discount_amount') || $request->filled('delivery_charge');
            $inventoryImpactedIds = is_array($products)
                ? array_values(array_unique(array_merge(array_keys($oldItemsMap), array_keys($newItemsMap))))
                : array_keys($oldItemsMap);

            if (is_array($products) || $dateChanged || $supplierChanged || $financialsChanged) {
                $p2Block = $this->validatePurchaseHistoricalIntegrity(
                    $purchase,
                    $inventoryImpactedIds,
                    'update',
                    $user_id,
                    $dateChanged ? $normalizedUpdateDate : null
                );
                if ($p2Block !== null) {
                    DB::rollBack();
                    $this->cleanupOrphanFile($newUploadedFilePath);
                    return $p2Block;
                }
            }

            $lineItemsCalculatedSubtotal = 0;
            $auditProducts = [];

            if (is_array($products)) {
                // Validate return constraints
                foreach ($returnsByProduct as $retProdId => $retQty) {
                    if ($retQty <= 0) {
                        continue;
                    }
                    if (!isset($newItemsMap[$retProdId])) {
                        DB::rollBack();
                        $this->cleanupOrphanFile($newUploadedFilePath);
                        Log::warning('PurchasesUpdate blocked: attempted to remove returned product', [
                            'actor_user_id' => $user_id,
                            'purchase_id' => $purchase->id,
                            'product_id' => $retProdId,
                            'returned_qty' => $retQty,
                        ]);
                        return response()->json([
                            'status'  => 'fail',
                            'message' => "এই ক্রয় ইনভয়েসে পণ্য আইডি #{$retProdId} এর বিপরীতে রিটার্ন রেকর্ড থাকায় এটিকে তালিকা থেকে বাদ দেওয়া যাবে না।"
                        ], 422);
                    }
                    if ($newItemsMap[$retProdId]['quantity'] < $retQty) {
                        DB::rollBack();
                        $this->cleanupOrphanFile($newUploadedFilePath);
                        Log::warning('PurchasesUpdate blocked: quantity below returned qty', [
                            'actor_user_id' => $user_id,
                            'purchase_id' => $purchase->id,
                            'product_id' => $retProdId,
                            'requested_qty' => $newItemsMap[$retProdId]['quantity'],
                            'returned_qty' => $retQty,
                        ]);
                        return response()->json([
                            'status'  => 'fail',
                            'message' => "পণ্য আইডি #{$retProdId} এর জন্য ইতিমধ্যে {$retQty} টি রিটার্ন এন্ট্রি রয়েছে, তাই ক্রয় সংখ্যা {$retQty} এর নিচে কমানো সম্ভব নয়।"
                        ], 422);
                    }
                }

                // Union of all product IDs in deterministic ascending order to avoid deadlocks
                $allProductIds = array_values(array_unique(array_merge(array_keys($oldItemsMap), array_keys($newItemsMap))));
                sort($allProductIds);

                $lockedProducts = !empty($allProductIds)
                    ? Product::whereIn('id', $allProductIds)->orderBy('id', 'asc')->lockForUpdate()->get()->keyBy('id')
                    : collect();

                // Verify all requested new product IDs actually exist
                foreach (array_keys($newItemsMap) as $reqPid) {
                    if (!$lockedProducts->has($reqPid)) {
                        DB::rollBack();
                        $this->cleanupOrphanFile($newUploadedFilePath);
                        return response()->json([
                            'status' => 'fail',
                            'message' => "পণ্য আইডি #{$reqPid} খুঁজে পাওয়া যায়নি।"
                        ], 404);
                    }
                }

                foreach ($allProductIds as $pId) {
                    $productModel = $lockedProducts->get($pId);
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
                        $this->cleanupOrphanFile($newUploadedFilePath);
                        $productTitle = $productModel->product_name ?? ("পণ্য #{$pId}");
                        Log::warning('PurchasesUpdate blocked: insufficient stock', [
                            'actor_user_id' => $user_id,
                            'purchase_id' => $purchase->id,
                            'product_id' => $pId,
                            'current_stock' => $currentStock,
                            'delta_qty' => $deltaQty,
                        ]);
                        return response()->json([
                            'status'  => 'fail',
                            'message' => "স্টক অপ্রতুল: \"{$productTitle}\" এর বর্তমান স্টক {$currentStock} পিস, তাই " . abs($deltaQty) . " পিস কমানো সম্ভব নয়।"
                        ], 422);
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

                    $auditProducts[] = [
                        'product_id' => $pId,
                        'old_purchase_qty' => $oldQty,
                        'new_purchase_qty' => $newQty,
                        'delta_qty' => $deltaQty,
                        'old_stock' => $currentStock,
                        'new_stock' => $finalStock,
                        'old_cost' => $currentCost,
                        'new_cost' => (float) $productModel->cost_price,
                    ];
                }

                // Delete old order details and recreate new ones (preserving return_quantity)
                PurchaseOrderDetails::where('purchase_id', $purchase->id)->delete();

                foreach ($newItemsMap as $newItem) {
                    $itemSubtotal = round($newItem['quantity'] * $newItem['cost_price'], 2);
                    $lineItemsCalculatedSubtotal += $itemSubtotal;

                    PurchaseOrderDetails::create([
                        'purchase_id'     => $purchase->id,
                        'product_id'      => $newItem['product_id'],
                        'quantity'        => $newItem['quantity'],
                        'return_quantity' => $newItem['return_quantity'],
                        'cost_price'      => $newItem['cost_price'],
                        'subtotal'        => $itemSubtotal,
                        'user_id'         => $user_id,
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

            // Guard multiple payment records from silent corruption using locked payment rows
            $paymentCount = $lockedPayments->count();
            if ($paymentCount > 1 && $request->filled('paid_amount')) {
                $reqPaidCheck = round((float) $request->input('paid_amount'), 2);
                $existingTotalPaid = round((float) $lockedPayments->sum('paid_amount'), 2);
                if (abs($reqPaidCheck - $existingTotalPaid) > 0.01 && abs($reqPaidCheck - (float) $purchase->paid_amount) > 0.01) {
                    DB::rollBack();
                    $this->cleanupOrphanFile($newUploadedFilePath);
                    Log::warning('PurchasesUpdate blocked: multiple payment records guard', [
                        'actor_user_id' => $user_id,
                        'purchase_id' => $purchase->id,
                        'payment_count' => $paymentCount,
                        'requested_paid' => $reqPaidCheck,
                        'existing_paid' => $existingTotalPaid,
                    ]);
                    return response()->json([
                        'status' => 'fail',
                        'message' => 'এই পারচেজের বিপরীতে একাধিক পেমেন্ট/ডিউ কালেকশন এন্ট্রি থাকায় এখান থেকে paid amount পরিবর্তন করা যাবে না।'
                    ], 422);
                }
            }

            $requestedPaid = $request->filled('paid_amount') ? round(floatval($request->input('paid_amount')), 2) : (float) $purchase->paid_amount;
            if ($paymentCount > 1) {
                $requestedPaid = round((float) $lockedPayments->sum('paid_amount'), 2);
            }
            $effectivePaid = $requestedPaid + $returnAdj;
            $newDue = max(0, $effectiveTotal - $effectivePaid);

            // Reconcile Payment Details (only safely overwrite single initial payment row)
            $paymentMethod = $request->input('payment_method', 'Cash');
            $transactionId = $request->input('transaction_id', null);
            $paymentStatus = $request->input('payment_status', ($newDue <= 0 ? 'Fully Paid' : ($requestedPaid > 0 ? 'Partial Paid' : 'Unpaid')));

            $firstPayment = $lockedPayments->first();
            if ($firstPayment && $paymentCount === 1) {
                $firstPayment->paid_amount = $requestedPaid;
                $firstPayment->discount_amount = $discountAmount;
                if ($request->filled('payment_method')) $firstPayment->payment_method = $paymentMethod;
                if ($request->filled('transaction_id')) $firstPayment->transaction_id = $transactionId;
                $firstPayment->payment_status = $paymentStatus;
                $firstPayment->purchase_due_collection_date = $updateDate;
                $firstPayment->save();
            } elseif (!$firstPayment && $requestedPaid > 0) {
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

            // Clean up replaced old attachment strictly AFTER commit and only if unreferenced elsewhere
            if ($oldAttachmentToCleanup && $oldAttachmentToCleanup !== $img_url) {
                if (!Purchase::where('attach_document', $oldAttachmentToCleanup)->exists()) {
                    $this->cleanupOrphanFile(public_path($oldAttachmentToCleanup));
                }
            }

            Log::info('Purchase Updated', [
                'actor_user_id' => $user_id,
                'purchase_id' => $purchase->id,
                'purchase_code' => $purchase->purchase_id,
                'supplier_id' => $supplier_id,
                'old_date' => $oldPurchaseDate,
                'new_date' => $normalizedUpdateDate,
                'old_paid_amount' => $oldPaid,
                'new_paid_amount' => $requestedPaid,
                'new_due_amount' => $newDue,
                'products' => $auditProducts,
                'result' => 'success',
                'timestamp' => now()->toIso8601String(),
            ]);

            return response()->json(['status' => 'success', 'message' => 'Purchase updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->cleanupOrphanFile($newUploadedFilePath);
            Log::error('Purchase Update Error: ' . $e->getMessage(), [
                'actor_user_id' => Auth::id(),
                'purchase_id' => $purchase_id,
            ]);
            return response()->json(['status' => 'fail', 'message' => 'Failed to update purchase: ' . $e->getMessage()], 500);
        }
    }

    public function PurchasesDelete(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'reason' => 'nullable|string|max:500',
        ]);

        $purchase_id = $request->input('id');
        $actorUserId = Auth::id();
        $reason = $request->input('reason');

        DB::beginTransaction();
        try {
            // 1. Find and lock purchase row
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

            // 2. Check for existing purchase returns (BOTH purchase_returns table AND purchase_order_details.return_quantity)
            $hasReturns = DB::table('purchase_returns')->where('purchase_id', $purchase->id)->exists();
            $hasReturnedQty = PurchaseOrderDetails::where('purchase_id', $purchase->id)
                ->where('return_quantity', '>', 0)
                ->exists();

            if ($hasReturns || $hasReturnedQty) {
                DB::rollBack();
                Log::warning('PurchasesDelete blocked: purchase has returns', [
                    'actor_user_id' => $actorUserId,
                    'purchase_id' => $purchase->id,
                    'purchase_code' => $purchase->purchase_id,
                    'has_purchase_returns_rows' => $hasReturns,
                    'has_pod_return_quantity' => $hasReturnedQty,
                ]);
                return response()->json([
                    'status' => 'fail',
                    'message' => 'এই পারচেজ ইনভয়েসের বিপরীতে রিটার্ন এন্ট্রি বা রিটার্ন সংখ্যা রয়েছে, তাই ডিলিট করা সম্ভব নয়। রিটার্ন রেকর্ড আগে সামঞ্জস্য করতে হবে।'
                ], 422);
            }

            // 3. Supplier due collection & payment ledger integrity check
            $payments = PurchasePaymentDetails::where('purchases_id', $purchase->id)
                ->orderBy('id', 'asc')
                ->lockForUpdate()
                ->get();

            $paymentBlocked = false;
            $paymentBlockReason = '';

            if ($payments->count() > 1) {
                $paymentBlocked = true;
                $paymentBlockReason = 'multiple_payment_records';
            } elseif ((float) $purchase->paid_amount > 0 && $payments->isEmpty()) {
                $paymentBlocked = true;
                $paymentBlockReason = 'paid_amount_without_payment_record';
            } else {
                foreach ($payments as $pRow) {
                    if ($pRow->created_at && $purchase->created_at && $pRow->created_at->gt($purchase->created_at->copy()->addSeconds(5))) {
                        $paymentBlocked = true;
                        $paymentBlockReason = 'subsequent_payment_created_after_purchase';
                        break;
                    }
                }
            }

            if (!$paymentBlocked && $purchase->supplier_id) {
                $dueCollectionQuery = SupplierDueCollection::where('supplier_id', $purchase->supplier_id)
                    ->where('purchase_payable_amount', 0);

                if ($purchase->created_at) {
                    $dueCollectionQuery->where('created_at', '>=', $purchase->created_at);
                }

                $matchingCollections = $dueCollectionQuery->get();
                if ($matchingCollections->isNotEmpty()) {
                    $wasUpdatedAfterCreate = $purchase->updated_at && $purchase->created_at && $purchase->updated_at->gt($purchase->created_at->copy()->addSeconds(1));
                    foreach ($matchingCollections as $sdc) {
                        foreach ($payments as $pRow) {
                            $sameDate = $pRow->purchase_due_collection_date && $sdc->due_collection_date
                                && (string) $pRow->purchase_due_collection_date === (string) $sdc->due_collection_date;
                            $sameTrx = $sdc->transaction_id !== null && $pRow->transaction_id === $sdc->transaction_id;
                            $paymentAtOrAfterSdc = $pRow->created_at && $sdc->created_at && $pRow->created_at->gte($sdc->created_at->copy()->subSeconds(2));

                            if (($wasUpdatedAfterCreate || $paymentAtOrAfterSdc) && ($sameDate || $sameTrx) && (float) $pRow->paid_amount > 0) {
                                $paymentBlocked = true;
                                $paymentBlockReason = 'linked_supplier_due_collection';
                                break 2;
                            }
                        }
                    }
                }
            }

            if ($paymentBlocked) {
                DB::rollBack();
                Log::warning('PurchasesDelete blocked: supplier payment / due collection linkage', [
                    'actor_user_id' => $actorUserId,
                    'purchase_id' => $purchase->id,
                    'purchase_code' => $purchase->purchase_id,
                    'reason' => $paymentBlockReason,
                    'payment_count' => $payments->count(),
                ]);
                return response()->json([
                    'status' => 'fail',
                    'message' => 'এই পারচেজ ইনভয়েসের বিপরীতে পরবর্তী পেমেন্ট বা সাপ্লায়ার ডিউ কালেকশন এন্ট্রি যুক্ত রয়েছে। ডিলিট করার আগে পেমেন্ট/কালেকশন রেকর্ড আলাদাভাবে রিভার্স করুন।'
                ], 422);
            }

            // 4. Load purchase line items and aggregate net quantities & values per product_id
            $orderDetails = PurchaseOrderDetails::where('purchase_id', $purchase->id)
                ->orderBy('id', 'asc')
                ->lockForUpdate()
                ->get();

            $groupedByProduct = [];
            foreach ($orderDetails as $item) {
                $pid = (int) $item->product_id;
                $netQty = max(0, (int) $item->quantity - (int) ($item->return_quantity ?? 0));
                $netVal = $netQty * (float) $item->cost_price;

                if (!isset($groupedByProduct[$pid])) {
                    $groupedByProduct[$pid] = [
                        'net_qty'   => 0,
                        'net_value' => 0.0,
                    ];
                }
                $groupedByProduct[$pid]['net_qty'] += $netQty;
                $groupedByProduct[$pid]['net_value'] += $netVal;
            }

            // Deterministic ascending sort on product_id to eliminate lock-order deadlocks
            ksort($groupedByProduct);
            $productIds = array_keys($groupedByProduct);

            // 5. Lock all impacted products once in deterministic ascending ID order
            $lockedProducts = !empty($productIds)
                ? Product::whereIn('id', $productIds)->orderBy('id', 'asc')->lockForUpdate()->get()->keyBy('id')
                : collect();

            // 6. Validate Stock Sufficiency before any mutation
            $productsRequiringP2 = [];
            foreach ($groupedByProduct as $productId => $group) {
                $product = $lockedProducts->get($productId);
                if (!$product) {
                    continue;
                }

                $netQtyToReverse = (int) $group['net_qty'];
                $currentQty = (int) $product->quantity;
                $name = $product->product_name ?? ('পণ্য #' . $productId);

                if ($currentQty < $netQtyToReverse) {
                    DB::rollBack();
                    Log::warning('PurchasesDelete blocked: insufficient stock', [
                        'actor_user_id' => $actorUserId,
                        'purchase_id' => $purchase->id,
                        'product_id' => $productId,
                        'current_qty' => $currentQty,
                        'net_qty_to_reverse' => $netQtyToReverse,
                    ]);
                    return response()->json([
                        'status' => 'fail',
                        'message' => "পণ্য '{$name}' ইতিমধ্যে বিক্রি বা ব্যবহার হয়ে গেছে (বর্তমান স্টক: {$currentQty}, রিভার্স পরিমাণ: {$netQtyToReverse})। স্টক নেগেটিভ হওয়া রোধে এই পারচেজ ডিলিট করা সম্ভব নয়।"
                    ], 422);
                }

                if ($netQtyToReverse > 0) {
                    $productsRequiringP2[] = $productId;
                }
            }

            // 6b. Policy P2 (Unified Historical Business-Date Integrity Lock)
            $p2Block = $this->validatePurchaseHistoricalIntegrity($purchase, $productsRequiringP2, 'delete', $actorUserId);
            if ($p2Block !== null) {
                DB::rollBack();
                return $p2Block;
            }

            // 7. Mutate each grouped product ONCE using pre-locked models (zero silent clamping)
            $auditProducts = [];
            foreach ($groupedByProduct as $productId => $group) {
                $product = $lockedProducts->get($productId);
                if (!$product) {
                    continue;
                }

                $netQtyToReverse = (int) $group['net_qty'];
                $netPurchaseValue = (float) $group['net_value'];
                $currentQty = (int) $product->quantity;
                $currentCost = (float) $product->cost_price;

                if ($currentQty < $netQtyToReverse) {
                    throw new RuntimeException("Insufficient stock invariant violation for Product #{$productId}.");
                }

                $newQty = $currentQty - $netQtyToReverse;
                $newCost = $currentCost;

                // Find previous/latest other purchase for this product as clean fallback
                $previousPurchase = PurchaseOrderDetails::where('product_id', $product->id)
                    ->where('purchase_id', '!=', $purchase->id)
                    ->latest('id')
                    ->first();

                if ($newQty > 0) {
                    $currentTotalValue = $currentCost * $currentQty;
                    $remainingValue = $currentTotalValue - $netPurchaseValue;

                    if ($remainingValue > 0) {
                        $newCost = round($remainingValue / $newQty, 2);
                    } elseif ($previousPurchase) {
                        $newCost = round((float) $previousPurchase->cost_price, 2);
                    }
                } else {
                    if ($previousPurchase) {
                        $newCost = round((float) $previousPurchase->cost_price, 2);
                    }
                }

                if ($netQtyToReverse > 0 || abs($newCost - $currentCost) > 0.0001) {
                    $affected = DB::table('products')
                        ->where('id', $product->id)
                        ->where('quantity', (string) $product->quantity)
                        ->update([
                            'quantity'   => (string) $newQty,
                            'cost_price' => (string) $newCost,
                            'updated_at' => now(),
                        ]);

                    if ($affected !== 1) {
                        throw new RuntimeException("Affected row assertion failed updating Product #{$product->id} (affected={$affected}).");
                    }
                }

                $auditProducts[] = [
                    'product_id' => $productId,
                    'old_qty' => $currentQty,
                    'reversed_qty' => $netQtyToReverse,
                    'new_qty' => $newQty,
                    'old_cost' => $currentCost,
                    'new_cost' => $newCost,
                ];
            }

            // 8. Delete payment details first (FK ON DELETE RESTRICT to purchases.id)
            $deletedPaymentCount = PurchasePaymentDetails::where('purchases_id', $purchase->id)->delete();

            // 9. Delete purchase order details
            $deletedDetailsCount = PurchaseOrderDetails::where('purchase_id', $purchase->id)->delete();
            if ($deletedDetailsCount !== $orderDetails->count()) {
                throw new RuntimeException(
                    "PurchaseOrderDetails delete count mismatch for purchase #{$purchase->id}: expected {$orderDetails->count()}, deleted {$deletedDetailsCount}."
                );
            }

            // Capture attachment path BEFORE delete/commit; NEVER unlink before commit!
            $attachDocument = $purchase->attach_document;
            $purchaseCode = $purchase->purchase_id;
            $supplierId = $purchase->supplier_id;
            $deletedPurchaseDbId = $purchase->id;

            // 10. Delete purchase record
            $purchase->delete();

            DB::commit();

            // 11. Post-commit attachment cleanup (only if no other purchase references same document)
            $attachmentDeleted = false;
            if (!empty($attachDocument)) {
                if (!Purchase::where('attach_document', $attachDocument)->exists()) {
                    $attachmentDeleted = $this->cleanupOrphanFile(public_path($attachDocument));
                }
            }

            Log::info('Purchase Deleted', [
                'actor_user_id' => $actorUserId,
                'purchase_id' => $deletedPurchaseDbId,
                'purchase_code' => $purchaseCode,
                'supplier_id' => $supplierId,
                'reason' => $reason,
                'reversed_products' => $auditProducts,
                'deleted_payments_count' => $deletedPaymentCount,
                'deleted_details_count' => $deletedDetailsCount,
                'attachment_path' => $attachDocument,
                'attachment_deleted' => $attachmentDeleted,
                'result' => 'success',
                'timestamp' => now()->toIso8601String(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'পারচেজ এবং সম্পর্কিত স্টক ও পেমেন্ট রেকর্ড সফলভাবে রিভার্স ও ডিলিট করা হয়েছে।'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Purchase Delete Error', [
                'actor_user_id' => $actorUserId,
                'purchase_input_id' => $purchase_id,
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'status' => 'fail',
                'message' => 'পারচেজ ডিলিট করতে সমস্যা হয়েছে: ' . $e->getMessage()
            ], 500);
        }
    }

    private function cleanupOrphanFile(?string $absolutePath): bool
    {
        if (!empty($absolutePath) && file_exists($absolutePath) && is_file($absolutePath)) {
            return @unlink($absolutePath);
        }
        return false;
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

            Log::info('Purchase Split Invoice Completed', [
                'actor_user_id' => Auth::id(),
                'source_purchase_id' => $sourcePurchase->id,
                'new_purchase_id' => $newPurchase->id,
                'new_purchase_code' => $newPurchaseId,
                'moved_detail_ids' => array_values($selectedDetailIds),
                'result' => 'success',
                'timestamp' => now()->toIso8601String(),
            ]);

            return response()->json([
                'status'          => 'success',
                'message'         => "Successfully split " . count($selectedDetailIds) . " items into new invoice {$newPurchaseId}.",
                'source_purchase' => $sourcePurchase->fresh(['orderDetails.product', 'paymentDetails']),
                'new_purchase'    => $newPurchase->fresh(['orderDetails.product', 'paymentDetails']),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Purchase Split Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'status'  => 'fail',
                'message' => 'Failed to split purchase invoice: ' . $e->getMessage()
            ], 500);
        }
    }

}
