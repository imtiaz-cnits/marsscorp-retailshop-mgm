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

            // 8. Payment Details Reconciliation (Phase 2.4 - Option A: True Ledger-Driven Paid Amount)
            // Authoritative paid amount is strictly derived from the payment ledger.
            // Client-supplied paid_amount is completely ignored as an authoritative instruction.
            // Payment detail records are NEVER created, overwritten, modified, or deleted during purchase editing.
            $authoritativePaid = $existingLedgerPaid;
            $effectivePaid = $authoritativePaid + $returnAdj;
            $newDue = max(0, $effectiveTotal - $effectivePaid);

            // 9. Update Purchase Header
            $purchase->referance_no = $request->input('referance_no', $purchase->referance_no);
            $purchase->date = $formattedDate;
            $purchase->supplier_id = $supplier_id;
            $purchase->grand_subtotal = $grandSubtotal;
            $purchase->delivery_charge = $deliveryCharge;
            $purchase->discount_amount = $discountAmount;
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
        try {
            $request->validate(['id' => 'required']);
            $purchase = BatteryPurchase::find($request->input('id'));

            if (!$purchase) {
                return response()->json(['status' => 'fail', 'message' => 'Purchase not found']);
            }

            $hasReturns = DB::table('battery_purchase_returns')->where('purchase_id', $purchase->id)->exists();
            if ($hasReturns) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'এই পারচেজ ইনভয়েসের বিপরীতে রিটার্ন এন্ট্রি রয়েছে, তাই ডিলিট করা সম্ভব নয়।'
                ]);
            }

            // Restore product stock
            $details = BatteryPurchaseOrderDetail::where('purchase_id', $purchase->id)->get();
            foreach ($details as $d) {
                $product = BatteryProduct::find($d->product_id);
                if ($product) {
                    $product->decrement('quantity', $d->quantity);
                }
            }

            BatteryPurchaseOrderDetail::where('purchase_id', $purchase->id)->delete();
            BatteryPurchasePaymentDetail::where('purchases_id', $purchase->id)->delete();
            $purchase->delete();

            return response()->json(['status' => 'success', 'message' => 'Purchase deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
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
        $returnAdj = (float) ($purchaseinvoicedata->return_adjustment_amount ?? 0);

        // Authoritative paid amount derived from payment details ledger
        $paidAmount = (float) ($purchaseinvoicedata->paymentDetails ? $purchaseinvoicedata->paymentDetails->sum('paid_amount') : 0);

        // Effective financial calculations
        $effectiveGrandTotal = max(0, ($subTotal - $discountAmount) + $deliveryCharge);
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
            'returnAdj',
            'paidAmount',
            'dueAmount',
            'totalDueFromAllPurchases'
        ));
    }
}

