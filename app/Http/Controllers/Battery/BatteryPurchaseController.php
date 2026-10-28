<?php

namespace App\Http\Controllers\Battery;

use Exception;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryProduct;
use App\Models\Battery\BatteryPurchase;
use App\Models\Battery\BatteryPurchaseOrderDetail;
use App\Models\Battery\BatteryPurchasePaymentDetail;
use App\Models\Battery\BatterySupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BatteryPurchaseController extends Controller
{
    public function PurchasesList()
    {
        try {
            $purchases = BatteryPurchase::with(['supplier', 'paymentDetails', 'orderDetails.product'])
                ->orderBy('created_at', 'desc')
                ->get();

            $formatted = $purchases->map(function ($purchase) {
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

                $barcodes = [];
                if ($purchase->orderDetails) {
                    $barcodes = $purchase->orderDetails->flatMap(function ($detail) {
                        if (!$detail->product || !$detail->product->product_code) return [];
                        $code = $detail->product->product_code;
                        $parsed = is_array($code) ? $code : (json_decode($code, true) ?? [$code]);
                        return is_array($parsed) ? $parsed : [$parsed];
                    })->filter()->unique()->values()->all();
                }

                $totalReturnAmount = 0;
                try {
                    $totalReturnAmount = (float) DB::table('battery_purchase_returns')
                        ->where('purchase_id', $purchase->id)
                        ->sum('amount');
                } catch (\Exception $ex) {
                    $totalReturnAmount = 0;
                }

                $purIdStr = $purchase->purchase_id;
                if (!$purIdStr || str_starts_with($purIdStr, 'me-pur-')) {
                    $purIdStr = '#PurID' . str_pad($purchase->id, 5, '0', STR_PAD_LEFT);
                }

                return [
                    'id'                => $purchase->id,
                    'purchase_id'       => $purIdStr,
                    'date'              => $purchase->date ? Carbon::parse($purchase->date)->format('d-m-Y') : 'N/A',
                    'raw_date'          => $purchase->date ? Carbon::parse($purchase->date)->format('Y-m-d') : '',
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
            Log::error('Battery Purchase List Error: ' . $e->getMessage());
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

            $img_url = null;
            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $img_name = "{$user_id}-" . time() . "-" . $img->getClientOriginalName();
                $img_url = "uploads/battery-purchases-img/{$img_name}";
                $destination = public_path('uploads/battery-purchases-img');
                if (!file_exists($destination)) {
                    @mkdir($destination, 0777, true);
                }
                $img->move($destination, $img_name);
            }

            $formattedDate = now()->format('Y-m-d');
            if ($request->filled('date')) {
                try {
                    $formattedDate = Carbon::parse($request->date)->format('Y-m-d');
                } catch (\Exception $e) {
                    $formattedDate = now()->format('Y-m-d');
                }
            }

            $formattedDueDate = $formattedDate;
            if ($request->filled('purchase_due_collection_date')) {
                try {
                    $formattedDueDate = Carbon::parse($request->purchase_due_collection_date)->format('Y-m-d');
                } catch (\Exception $e) {
                    $formattedDueDate = $formattedDate;
                }
            }

            $supplier_id = null;
            if ($request->filled('supplier_id') && $request->supplier_id !== 'none') {
                $supplier_id = $request->supplier_id;
            }

            $lastPurchase = BatteryPurchase::latest('id')->first();
            $nextPurchaseNumber = $lastPurchase ? ($lastPurchase->id + 1) : 1;
            $purchaseIdString = '#PurID' . str_pad($nextPurchaseNumber, 5, '0', STR_PAD_LEFT);

            $purchase = BatteryPurchase::create([
                'purchase_id' => $purchaseIdString,
                'supplier_id' => $supplier_id,
                'date' => $formattedDate,
                'referance_no' => $request->referance_no,
                'grand_subtotal' => $request->grand_subtotal ?? $request->total_amount ?? $request->sub_total ?? 0,
                'paid_amount' => $request->paid_amount ?? 0,
                'due_amount' => $request->due_amount ?? 0,
                'delivery_charge' => floatval($request->delivery_charge ?? 0),
                'discount_amount' => floatval($request->discount_amount ?? 0),
                'discount_type' => $request->input('discount_type', 'fixed'),
                'discount_rate' => $request->filled('discount_rate') ? (float) $request->discount_rate : null,
                'return_adjustment_amount' => floatval($request->return_adjustment_amount ?? 0),
                'attach_document' => $img_url,
                'user_id' => $user_id,
            ]);

            $products = is_array($request->products) ? $request->products : json_decode($request->products, true);
            if (is_array($products)) {
                foreach ($products as $product) {
                    if (isset($product['product_id'], $product['quantity'])) {
                        BatteryPurchaseOrderDetail::create([
                            'purchase_id' => $purchase->id,
                            'product_id' => $product['product_id'],
                            'quantity' => $product['quantity'],
                            'cost_price' => $product['cost_price'],
                            'subtotal' => $product['subtotal'],
                            'user_id' => $user_id,
                        ]);

                        $productModel = BatteryProduct::find($product['product_id']);
                        if ($productModel) {
                            $existingCostPrice = (float) $productModel->cost_price;
                            $existingQuantity = (int) $productModel->quantity;
                            $newCostPrice = (float) $product['cost_price'];
                            $newQuantity = (int) $product['quantity'];

                            $combinedQuantity = $existingQuantity + $newQuantity;

                            if ($combinedQuantity > 0) {
                                $existingTotal = $existingCostPrice * max(0, $existingQuantity);
                                $newTotal = $newCostPrice * $newQuantity;
                                $updatedCostPrice = ($existingTotal + $newTotal) / $combinedQuantity;
                                $productModel->cost_price = round($updatedCostPrice, 2);
                            }

                            $productModel->quantity = $combinedQuantity;

                            if (!empty($product['product_code'])) {
                                $newCodes = $product['product_code'];
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
                    }
                }
            }

            if (floatval($request->paid_amount) > 0) {
                BatteryPurchasePaymentDetail::create([
                    'purchases_id' => $purchase->id,
                    'paid_amount' => $request->paid_amount,
                    'discount_amount' => $request->discount_amount ?? 0,
                    'payment_method' => $request->payment_method ?? 'Cash',
                    'purchase_due_collection_date' => $formattedDueDate,
                    'payment_status' => (floatval($request->due_amount) <= 0) ? 'Fully Paid' : 'Partial Paid',
                    'transaction_id' => $request->transaction_id ?? null,
                    'user_id' => $user_id,
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Purchase created successfully',
                'purchase_id' => $purchase->id,
                'data' => $purchase,
                'id' => $purchase->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Battery Purchase Create Error: ' . $e->getMessage());
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }

    public function PurchasesByID(Request $request)
    {
        try {
            $request->validate(['id' => 'required']);
            $purchase = BatteryPurchase::with(['supplier', 'orderDetails.product', 'paymentDetails'])
                ->where('id', $request->input('id'))
                ->first();

            if (!$purchase) {
                return response()->json(['status' => 'fail', 'message' => 'Purchase not found']);
            }

            return response()->json(['status' => 'success', 'rows' => $purchase]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function PurchasesUpdate(Request $request)
    {
        // 1. Validate ID exists and is provided (Defect C remediation)
        $purchaseId = $request->input('id');
        if (!$purchaseId) {
            return response()->json([
                'status'  => 'fail',
                'message' => 'Purchase ID is required'
            ]);
        }

        $purchase = BatteryPurchase::with(['orderDetails', 'paymentDetails'])->find($purchaseId);
        if (!$purchase) {
            return response()->json([
                'status'  => 'fail',
                'message' => 'Purchase not found'
            ]);
        }

        // Section 4: Protect against existing header / payment ledger discrepancies
        $existingHeaderPaid = round((float) $purchase->paid_amount, 2);
        $existingLedgerPaid = round((float) $purchase->paymentDetails->sum('paid_amount'), 2);

        if (abs($existingHeaderPaid - $existingLedgerPaid) > 0.01) {
            return response()->json([
                'status'  => 'fail',
                'message' => "আর্থিক অসঙ্গতি সনাক্ত: এই ক্রয়ের হেডারে পরিশোধিত পরিমাণ (৳" . number_format($existingHeaderPaid, 2) . ") এবং পেমেন্ট লেজারের মোট পরিমাণ (৳" . number_format($existingLedgerPaid, 2) . ") এর মধ্যে অমিল রয়েছে। তথ্য সুরক্ষার্থে এডিট বাতিল করা হয়েছে। অনুগ্রহ করে পেমেন্ট লেজার নিরীক্ষা করুন।"
            ]);
        }

        DB::beginTransaction();
        try {
            $user_id = Auth::id() ?? $purchase->user_id;

            // 2. Format Date
            $formattedDate = $purchase->date;
            if ($request->filled('date')) {
                try {
                    $dateStr = trim($request->input('date'));
                    if (str_contains($dateStr, '-')) {
                        $parts = explode('-', $dateStr);
                        if (count($parts) === 3 && strlen($parts[0]) === 2 && strlen($parts[2]) === 4) {
                            $formattedDate = Carbon::createFromFormat('d-m-Y', $dateStr)->format('Y-m-d');
                        } else {
                            $formattedDate = Carbon::parse($dateStr)->format('Y-m-d');
                        }
                    } else {
                        $formattedDate = Carbon::parse($dateStr)->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    $formattedDate = $purchase->date;
                }
            }

            // 3. Supplier
            $supplier_id = $purchase->supplier_id;
            if ($request->filled('supplier_id') && $request->input('supplier_id') !== 'none') {
                $supplier_id = $request->input('supplier_id');
            }

            // 4. File Attachment
            $img_url = $purchase->attach_document;
            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $img_name = "{$user_id}-" . time() . "-" . $img->getClientOriginalName();
                $img_url = "uploads/battery-purchases-img/{$img_name}";
                $destination = public_path('uploads/battery-purchases-img');
                if (!file_exists($destination)) {
                    @mkdir($destination, 0777, true);
                }
                $img->move($destination, $img_name);
            }

            // 5. Check Returns Protection
            $purchaseReturns = DB::table('battery_purchase_returns')
                ->where('purchase_id', $purchase->id)
                ->get();
            $returnsByProduct = $purchaseReturns->groupBy('product_id')->map(function ($group) {
                return $group->sum('quantity');
            });

            // 6. Handle Products / Line Items Reconciliation
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
                            // Merge duplicate product lines if submitted
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

                // Union of all product IDs involved
                $allProductIds = array_unique(array_merge(array_keys($oldItemsMap), array_keys($newItemsMap)));

                foreach ($allProductIds as $pId) {
                    $productModel = BatteryProduct::where('id', $pId)->lockForUpdate()->first();
                    if (!$productModel) continue;

                    $oldQty  = $oldItemsMap[$pId]['quantity'] ?? 0;
                    $oldCost = $oldItemsMap[$pId]['cost_price'] ?? 0;

                    $newQty  = $newItemsMap[$pId]['quantity'] ?? 0;
                    $newCost = $newItemsMap[$pId]['cost_price'] ?? 0;

                    $deltaQty = $newQty - $oldQty;

                    // Check stock sufficiency if reducing
                    $currentStock = (int) $productModel->quantity;
                    $finalStock   = $currentStock + $deltaQty;
                    if ($deltaQty < 0 && $finalStock < 0) {
                        DB::rollBack();
                        return response()->json([
                            'status'  => 'fail',
                            'message' => "স্টক অপ্রতুল: \"{$productModel->product_name}\" এর বর্তমান স্টক {$currentStock} পিস, তাই " . abs($deltaQty) . " পিস কমানো সম্ভব নয়।"
                        ]);
                    }

                    // Weighted average cost price recalculation using incremental inventory valuation (Defect A remediation)
                    $currentCost = (float) $productModel->cost_price;
                    $currentInventoryValue = $currentStock * $currentCost;

                    $oldPurchaseValue = $oldQty * $oldCost;
                    $newPurchaseValue = $newQty * $newCost;
                    $deltaValue       = $newPurchaseValue - $oldPurchaseValue;

                    $finalInventoryValue = $currentInventoryValue + $deltaValue;

                    if ($finalStock > 0) {
                        // Guard against invalid/negative inventory valuation caused by excessive retrospective price reductions after historical sales
                        if ($finalInventoryValue <= 0) {
                            DB::rollBack();
                            return response()->json([
                                'status'  => 'fail',
                                'message' => "ইনভেন্টরি ভ্যালুয়েশন ত্রুটি: পূর্ববর্তী বিক্রয়ের কারণে \"{$productModel->product_name}\" এর জন্য এই মূল্য/পরিমাণ পরিবর্তন প্রযোজ্য নয়।"
                            ]);
                        }
                        $productModel->cost_price = round($finalInventoryValue / $finalStock, 2);
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
                BatteryPurchaseOrderDetail::where('purchase_id', $purchase->id)->delete();

                foreach ($newItemsMap as $newItem) {
                    $itemSubtotal = round($newItem['quantity'] * $newItem['cost_price'], 2);
                    $lineItemsCalculatedSubtotal += $itemSubtotal;

                    BatteryPurchaseOrderDetail::create([
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

            // 7. Calculate Financial Totals
            $grandSubtotal = is_array($products) ? $lineItemsCalculatedSubtotal : floatval($request->input('grand_subtotal', $purchase->grand_subtotal));
            $deliveryCharge = floatval($request->input('delivery_charge', $purchase->delivery_charge ?? 0));
            $discountAmount = floatval($request->input('discount_amount', $purchase->discount_amount ?? 0));
            $returnAdj = floatval($purchase->return_adjustment_amount ?? 0);

            $effectiveTotal = max(0, ($grandSubtotal - $discountAmount) + $deliveryCharge);

            // 8. Payment Details Reconciliation
            $authoritativePaid = $existingLedgerPaid;
            $firstPayment = $purchase->paymentDetails->first();
            if ($firstPayment) {
                if ($request->filled('paid_amount')) {
                    $requestedPaid = round(floatval($request->input('paid_amount')), 2);
                    $diff = $requestedPaid - $authoritativePaid;
                    $firstPayment->paid_amount = max(0, (float)$firstPayment->paid_amount + $diff);
                    $authoritativePaid = $requestedPaid;
                }
                if ($request->filled('payment_method')) $firstPayment->payment_method = $request->input('payment_method');
                if ($request->filled('transaction_id')) $firstPayment->transaction_id = $request->input('transaction_id');
                $firstPayment->discount_amount = $discountAmount;
                $firstPayment->purchase_due_collection_date = $formattedDate;
                $firstPayment->payment_status = ($effectiveTotal - $authoritativePaid) <= 0 ? 'Fully Paid' : ($authoritativePaid > 0 ? 'Partial Paid' : 'Unpaid');
                $firstPayment->save();
            } elseif ($request->filled('paid_amount') && floatval($request->input('paid_amount')) > 0) {
                $requestedPaid = round(floatval($request->input('paid_amount')), 2);
                BatteryPurchasePaymentDetail::create([
                    'purchases_id'    => $purchase->id,
                    'paid_amount'     => $requestedPaid,
                    'discount_amount' => $discountAmount,
                    'transaction_id'  => $request->input('transaction_id'),
                    'payment_method'  => $request->input('payment_method', 'Cash'),
                    'payment_status'  => ($effectiveTotal - $requestedPaid) <= 0 ? 'Fully Paid' : 'Partial Paid',
                    'purchase_due_collection_date' => $formattedDate,
                    'user_id'         => $user_id,
                ]);
                $authoritativePaid = $requestedPaid;
            }

            $effectivePaid = $authoritativePaid + $returnAdj;
            $newDue = max(0, $effectiveTotal - $effectivePaid);

            // 9. Update Purchase Header
            $purchase->referance_no = $request->input('referance_no', $purchase->referance_no);
            $purchase->date = $formattedDate;
            $purchase->supplier_id = $supplier_id;
            $purchase->grand_subtotal = $grandSubtotal;
            $purchase->delivery_charge = $deliveryCharge;
            $purchase->discount_amount = $discountAmount;
            if ($request->filled('discount_type')) {
                $purchase->discount_type = $request->input('discount_type');
            }
            if ($request->has('discount_rate')) {
                $purchase->discount_rate = $request->filled('discount_rate') ? (float) $request->discount_rate : null;
            }
            if ($request->filled('return_adjustment_amount')) {
                $purchase->return_adjustment_amount = (float) $request->return_adjustment_amount;
            }
            $purchase->paid_amount = $authoritativePaid;
            $purchase->due_amount = $newDue;
            $purchase->attach_document = $img_url;
            $purchase->save();

            DB::commit();

            return response()->json([
                'status'   => 'success',
                'message'  => 'Purchase updated successfully',
                'purchase' => $purchase->fresh()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Battery Purchase Update Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status'  => 'fail',
                'message' => 'Failed to update purchase. Please check your data and try again.'
            ], 500);
        }
    }

    public function PurchasesDelete(Request $request)
    {
        $request->validate(['id' => 'required']);
        $purchase_id = $request->input('id');

        DB::beginTransaction();
        try {
            $purchase = BatteryPurchase::where('id', $purchase_id)
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

            $hasReturns = DB::table('battery_purchase_returns')->where('purchase_id', $purchase->id)->exists();
            if ($hasReturns) {
                DB::rollBack();
                return response()->json([
                    'status' => 'fail',
                    'message' => 'এই পারচেজ ইনভয়েসের বিপরীতে রিটার্ন এন্ট্রি রয়েছে, তাই ডিলিট করা সম্ভব নয়। রিটার্ন রেকর্ড আগে সামঞ্জস্য করতে হবে।'
                ], 422);
            }

            $orderDetails = BatteryPurchaseOrderDetail::where('purchase_id', $purchase->id)->get();

            // Group required quantities by product_id
            $qtyByProduct = [];
            foreach ($orderDetails as $item) {
                $pid = $item->product_id;
                $qtyByProduct[$pid] = ($qtyByProduct[$pid] ?? 0) + (int) $item->quantity;
            }

            // Pre-check stock: prevent negative stock
            foreach ($qtyByProduct as $productId => $qtyToReverse) {
                $product = BatteryProduct::lockForUpdate()->find($productId);
                if (!$product) {
                    continue;
                }

                if ($product->quantity < $qtyToReverse) {
                    DB::rollBack();
                    $name = $product->product_name ?? ('ব্যাটারি পণ্য #' . $productId);
                    return response()->json([
                        'status' => 'fail',
                        'message' => "ব্যাটারি পণ্য '{$name}' ইতিমধ্যে বিক্রি বা ব্যবহার হয়ে গেছে (বর্তমান স্টক: {$product->quantity}, পারচেজ পরিমাণ: {$qtyToReverse})। স্টক নেগেটিভ হওয়া রোধে এই পারচেজ ডিলিট করা সম্ভব নয়।"
                    ], 422);
                }
            }

            // Reverse product stock and recalculate cost price
            foreach ($orderDetails as $item) {
                $product = BatteryProduct::lockForUpdate()->find($item->product_id);
                if (!$product) {
                    continue;
                }

                $qtyToReverse = (int) $item->quantity;
                $purchaseCost = (float) $item->cost_price;
                $currentQty = (int) $product->quantity;
                $currentCost = (float) $product->cost_price;

                $newQty = max(0, $currentQty - $qtyToReverse);

                $previousPurchase = BatteryPurchaseOrderDetail::where('product_id', $product->id)
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
                    if ($previousPurchase) {
                        $product->cost_price = round((float) $previousPurchase->cost_price, 2);
                    }
                }

                $product->quantity = $newQty;
                $product->save();
            }

            // Delete payment details
            BatteryPurchasePaymentDetail::where('purchases_id', $purchase->id)->delete();

            // Delete order details
            BatteryPurchaseOrderDetail::where('purchase_id', $purchase->id)->delete();

            // Delete attached document file if exists
            if (!empty($purchase->attach_document)) {
                $docPath = public_path($purchase->attach_document);
                if (file_exists($docPath) && is_file($docPath)) {
                    @unlink($docPath);
                }
            }

            // Delete purchase record
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

    public function getPaymentDetailsById(Request $request)
    {
        try {
            $purchaseId = $request->input('id');
            $purchase = BatteryPurchase::with(['supplier', 'paymentDetails'])->findOrFail($purchaseId);

            return response()->json([
                'status' => 'success',
                'purchase' => $purchase,
                'paymentDetails' => $purchase->paymentDetails,
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function updatePaymentDetails(Request $request)
    {
        try {
            $user_id = Auth::id();
            $purchaseId = $request->input('id') ?? $request->input('purchases_id');
            $purchase = BatteryPurchase::findOrFail($purchaseId);

            $paidAmount = floatval($request->input('paid_amount', 0));
            $paymentMethod = $request->input('payment_method', 'Cash');

            $newPaid = $purchase->paid_amount + $paidAmount;
            $newDue = max(0, $purchase->due_amount - $paidAmount);

            $purchase->paid_amount = $newPaid;
            $purchase->due_amount = $newDue;
            $purchase->save();

            $status = $newDue == 0 ? 'Fully Paid' : 'Partial Paid';

            BatteryPurchasePaymentDetail::create([
                'purchases_id' => $purchase->id,
                'paid_amount' => $paidAmount,
                'discount_amount' => 0,
                'payment_method' => $paymentMethod,
                'payment_status' => $status,
                'purchase_due_collection_date' => now()->format('Y-m-d'),
                'transaction_id' => $request->input('transaction_id'),
                'user_id' => $user_id,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Payment recorded successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function PurchaseShowDetails($id)
    {
        $purchaseinvoicedata = BatteryPurchase::with(['supplier', 'orderDetails.product', 'paymentDetails'])->find($id);

        if (!$purchaseinvoicedata) {
            abort(404, 'Battery purchase not found');
        }

        // Calculate Subtotal from Order Details
        $subTotal = (float) $purchaseinvoicedata->orderDetails->sum(function ($orderDetail) {
            return (float) ($orderDetail->cost_price ?? 0) * (int) ($orderDetail->quantity ?? 1);
        });

        $deliveryCharge = (float) ($purchaseinvoicedata->delivery_charge ?? 0);
        $discountAmount = (float) ($purchaseinvoicedata->discount_amount ?? 0);
        $discountType = $purchaseinvoicedata->discount_type ?? 'fixed';
        $discountRate = $purchaseinvoicedata->discount_rate !== null ? (float) $purchaseinvoicedata->discount_rate : null;
        $returnAdj = (float) ($purchaseinvoicedata->return_adjustment_amount ?? 0);

        // Authoritative paid amount derived from payment details ledger
        $paidAmount = (float) ($purchaseinvoicedata->paymentDetails ? $purchaseinvoicedata->paymentDetails->sum('paid_amount') : 0);

        // Effective financial calculations
        $netTotal = max(0, $subTotal - $discountAmount + $deliveryCharge);
        $effectiveGrandTotal = $netTotal;
        $effectivePaid = $paidAmount + $returnAdj;
        $dueAmount = max(0, $effectiveGrandTotal - $effectivePaid);

        // Derived payment status
        $paymentDetailsStatus = 'Unpaid';
        if ($effectivePaid >= $effectiveGrandTotal && $effectiveGrandTotal > 0) {
            $paymentDetailsStatus = 'Fully Paid';
        } elseif ($effectivePaid > 0) {
            $paymentDetailsStatus = 'Partial Paid';
        }

        // Supplier previous / opening due
        $PreviousDueAmount = (float) ($purchaseinvoicedata->supplier->purchase_payable_amount ?? 0);

        // Total due across all purchases for this supplier
        $supplierDueAmount = $PreviousDueAmount;
        $purchaseDueAmount = (float) BatteryPurchase::where('supplier_id', $purchaseinvoicedata->supplier_id)->sum('due_amount');
        $totalDueFromAllPurchases = $supplierDueAmount + $purchaseDueAmount;

        return view('battery.purchase.purchase-invoice-print', compact(
            'purchaseinvoicedata',
            'paymentDetailsStatus',
            'PreviousDueAmount',
            'subTotal',
            'deliveryCharge',
            'discountAmount',
            'discountType',
            'discountRate',
            'netTotal',
            'returnAdj',
            'paidAmount',
            'dueAmount',
            'totalDueFromAllPurchases'
        ));
    }

    public function PurchaseSplitInvoice(Request $request)
    {
        $request->validate([
            'purchase_id'              => 'required|integer|exists:battery_purchases,id',
            'detail_ids'               => 'required|array|min:1',
            'detail_ids.*'             => 'required|integer|exists:battery_purchase_order_details,id',
            'new_discount_type'        => 'nullable|string|in:fixed,percent',
            'new_discount_rate'        => 'nullable|numeric|min:0|max:100',
            'new_discount_amount'      => 'nullable|numeric|min:0',
            'original_discount_type'   => 'nullable|string|in:fixed,percent',
            'original_discount_rate'   => 'nullable|numeric|min:0|max:100',
            'original_discount_amount' => 'nullable|numeric|min:0',
            'referance_no'             => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $sourcePurchase = BatteryPurchase::with(['orderDetails', 'paymentDetails', 'supplier'])
                ->where('id', $request->purchase_id)
                ->lockForUpdate()
                ->firstOrFail();

            $allDetails = $sourcePurchase->orderDetails;
            $selectedDetailIds = array_unique($request->detail_ids);

            // Validation: Ensure all selected IDs belong to this battery purchase
            $validIds = $allDetails->pluck('id')->all();
            foreach ($selectedDetailIds as $sId) {
                if (!in_array($sId, $validIds)) {
                    DB::rollBack();
                    return response()->json([
                        'status'  => 'fail',
                        'message' => "Line item ID #{$sId} does not belong to battery purchase {$sourcePurchase->purchase_id}."
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
                $newPaid = $newNetPayable;
                $remainingPaid = $remainingNetPayable;
                $excessPaid = round($historicalPaid - $combinedPayable, 2);
                if ($excessPaid > 0) {
                    $remainingPaid = round($remainingPaid + $excessPaid, 2);
                }
            } else {
                $newPaid = round($historicalPaid * ($newNetPayable / $combinedPayable), 2);
                $remainingPaid = max(0, round($historicalPaid - $newPaid, 2));
            }

            $newDue = max(0, round($newNetPayable - $newPaid, 2));
            $remainingDue = max(0, round($remainingNetPayable - $remainingPaid, 2));

            $newStatus = ($newDue <= 0 && $newNetPayable > 0) ? 'Fully Paid' : ($newPaid > 0 ? 'Partial Paid' : 'Unpaid');
            $remainingStatus = ($remainingDue <= 0 && $remainingNetPayable > 0) ? 'Fully Paid' : ($remainingPaid > 0 ? 'Partial Paid' : 'Unpaid');

            // 5. Generate New Battery Purchase ID
            $lastPurchase = BatteryPurchase::latest('id')->first();
            $nextPurchaseNumber = $lastPurchase ? ($lastPurchase->id + 1) : 1;
            $newPurchaseId = '#PurID' . str_pad($nextPurchaseNumber, 5, '0', STR_PAD_LEFT);
            while (BatteryPurchase::where('purchase_id', $newPurchaseId)->exists()) {
                $nextPurchaseNumber++;
                $newPurchaseId = '#PurID' . str_pad($nextPurchaseNumber, 5, '0', STR_PAD_LEFT);
            }

            $newRef = $request->input('referance_no') 
                ?: ($sourcePurchase->referance_no ? $sourcePurchase->referance_no . '-SPLIT' : 'SPLIT-' . time());

            // 6. Create New Battery Purchase Record
            $newPurchase = BatteryPurchase::create([
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

            // 7. Reassign Selected Line Items (Zero stock movements!)
            BatteryPurchaseOrderDetail::whereIn('id', $selectedDetailIds)
                ->update(['purchase_id' => $newPurchase->id]);

            // 8. Update Source Battery Purchase Record
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
                BatteryPurchasePaymentDetail::create([
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
                'message'         => "Successfully split " . count($selectedDetailIds) . " items into new battery invoice {$newPurchaseId}.",
                'source_purchase' => $sourcePurchase->fresh(['orderDetails.product', 'paymentDetails']),
                'new_purchase'    => $newPurchase->fresh(['orderDetails.product', 'paymentDetails']),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Battery Purchase Split Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'status'  => 'fail',
                'message' => 'Failed to split battery purchase invoice: ' . $e->getMessage()
            ], 500);
        }
    }
}

