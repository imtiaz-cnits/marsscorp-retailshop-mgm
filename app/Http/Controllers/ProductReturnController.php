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
use Illuminate\Support\Facades\Log;
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

        // Calculate the total selling amount, paid amount, and due amount accurately
        $subTotal = (float) ($invoice->sub_total ?? $invoice->details->sum(function($orderDetail) {
            return (float) ($orderDetail->selling_price ?? $orderDetail->price ?? 0) * (float) $orderDetail->quantity;
        }));

        $paidAmount = (float) ($invoice->paid_amount ?? ($invoice->payment ? $invoice->payment->paid_amount : 0));
        $dueAmount = (float) ($invoice->due_amount ?? max(0, $subTotal - $paidAmount));

        // Pass the calculated values to the view
        return view('backend.view-return.return-details', compact('invoice', 'subTotal', 'paidAmount', 'dueAmount'));
    }



    public function ReturnProductList()
    {
        try {
            $returns = ProductReturn::with(['customer', 'order', 'product.unit', 'orderDetail'])
                ->orderBy('created_at', 'desc')
                ->orderBy('id', 'desc')
                ->get();

            // Group returns by return_number (with fallback for legacy records)
            $grouped = $returns->groupBy(function ($item) {
                return $item->return_number ?: ('LEGACY_' . $item->order_id . '_' . ($item->created_at ? $item->created_at->format('Y-m-d_H:i:s') : $item->id));
            });

            $ProductReturnData = $grouped->map(function ($group) {
                $first = $group->first();
                $returnNumber = $first->return_number ?: ('#RET' . str_pad($first->id, 5, '0', STR_PAD_LEFT));
                $order = $first->order;
                $customer = $first->customer;

                $cName = $customer ? ($customer->name ?? $customer->customer_name) : 'Guest Customer';
                $cMobile = $customer ? ($customer->mobile ?? $customer->phone ?? '') : '';

                $totalQty = $group->sum('quantity');
                $totalAmount = $group->sum('amount');
                $totalDueAmount = $group->sum('due_amount');
                $totalDiscountAmount = $group->sum('discount_amount');

                // Build detailed child items array for modal / details view
                $items = $group->map(function ($item) {
                    $pName = $item->product ? ($item->product->product_name ?? 'N/A') : 'N/A';
                    $unitName = ($item->product && $item->product->unit) ? ($item->product->unit->name ?? 'pcs') : 'pcs';
                    $code = $item->product?->product_code ?? 'N/A';
                    if (is_array($code)) {
                        $code = $code[0] ?? 'N/A';
                    } elseif (is_string($code) && str_starts_with($code, '[')) {
                        try {
                            $arr = json_decode($code, true);
                            $code = $arr[0] ?? 'N/A';
                        } catch (\Exception $e) {
                        }
                    }

                    $unitPrice = (float) ($item->unit_price ?: ($item->quantity > 0 ? round($item->amount / $item->quantity, 2) : 0));

                    return [
                        'id'              => $item->id,
                        'order_detail_id' => $item->order_detail_id,
                        'product_id'      => $item->product_id,
                        'product_name'    => $pName,
                        'product_code'    => $code,
                        'unit'            => $unitName,
                        'quantity'        => (int) $item->quantity,
                        'unit_price'      => $unitPrice,
                        'amount'          => (float) $item->amount,
                        'due_amount'      => (float) $item->due_amount,
                        'discount_amount' => (float) $item->discount_amount,
                    ];
                })->values();

                // Product summary string
                $productNames = $group->map(function ($item) {
                    return $item->product ? $item->product->product_name : 'Product';
                })->unique()->values();

                if ($productNames->count() === 1) {
                    $productSummary = $productNames[0];
                } elseif ($productNames->count() === 2) {
                    $productSummary = $productNames[0] . ', ' . $productNames[1];
                } else {
                    $productSummary = $productNames[0] . ', ' . $productNames[1] . ' (+' . ($productNames->count() - 2) . ' more)';
                }

                $primaryUnit = ($items[0]['unit'] ?? 'pcs');

                return [
                    'id'                   => $first->id,
                    'return_number'        => $returnNumber,
                    'order_id'             => $first->order_id ?? ($order ? $order->id : null),
                    'customer_id'          => $first->customer_id ?? ($customer ? $customer->id : null),
                    'order_no'             => $order->order_no ?? 'N/A',
                    'customer_name'        => $cName,
                    'customer_mobile'      => $cMobile,
                    'product_name'         => $productSummary,
                    'product_summary'      => $productSummary,
                    'unit'                 => $primaryUnit,
                    'quantity'             => (int) $totalQty,
                    'amount'               => (float) round($totalAmount, 2),
                    'due_amount'           => (float) round($totalDueAmount, 2),
                    'discount_amount'      => (float) round($totalDiscountAmount, 2),
                    'date'                 => $first->date ?? ($first->created_at ? $first->created_at->format('Y-m-d') : null),
                    'created_at_formatted' => $first->created_at ? $first->created_at->format('d M Y, h:i A') : '',
                    'items_count'          => $items->count(),
                    'items'                => $items,
                ];
            })->values();

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

    private function generateReturnNumber(): string
    {
        $lastReturn = ProductReturn::whereNotNull('return_number')->orderBy('id', 'desc')->first();
        $nextNumber = 1;
        if ($lastReturn && preg_match('/#RET(\d+)/', $lastReturn->return_number, $matches)) {
            $nextNumber = (int) $matches[1] + 1;
        }

        return sprintf('#RET%05d', $nextNumber);
    }

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

        $actorUserId = Auth::id();
        try {
            DB::beginTransaction();

            $order = Order::lockForUpdate()->findOrFail($request->order_id);
            $user_id = $actorUserId ?? ($order->user_id ?? 1);

            // Deterministically lock OrderDetails and Product rows in ascending ID order BEFORE iterating
            $detailIds = collect($request->products)->pluck('order_detail_id')->map(fn ($v) => (int) $v)->unique()->sort()->values()->all();
            $productIds = collect($request->products)->pluck('product_id')->map(fn ($v) => (int) $v)->unique()->sort()->values()->all();

            $lockedDetails = OrderDetails::whereIn('id', $detailIds)->orderBy('id', 'asc')->lockForUpdate()->get()->keyBy('id');
            $lockedProducts = Product::whereIn('id', $productIds)->orderBy('id', 'asc')->lockForUpdate()->get()->keyBy('id');

            // Aggregate request lines by order_detail_id so duplicate lines cannot exceed available returnable qty
            $aggregatedByDetail = [];
            foreach ($request->products as $returnedItem) {
                $dId = (int) $returnedItem['order_detail_id'];
                $pId = (int) $returnedItem['product_id'];
                $qty = (int) $returnedItem['quantity'];
                if (isset($aggregatedByDetail[$dId])) {
                    if ($aggregatedByDetail[$dId]['product_id'] !== $pId) {
                        DB::rollBack();
                        return response()->json([
                            'status' => 'fail',
                            'message' => 'একই ইনভয়েস লাইনে ভিন্ন প্রোডাক্ট আইডি পাওয়া গেছে।'
                        ], 422);
                    }
                    $aggregatedByDetail[$dId]['quantity'] += $qty;
                } else {
                    $aggregatedByDetail[$dId] = [
                        'order_detail_id' => $dId,
                        'product_id' => $pId,
                        'quantity' => $qty,
                    ];
                }
            }

            // Verify ownership & returnable quantities BEFORE mutating any row
            foreach ($aggregatedByDetail as $dId => $agg) {
                $orderDetail = $lockedDetails->get($dId);
                $product = $lockedProducts->get($agg['product_id']);
                if (!$orderDetail || !$product) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'fail',
                        'message' => 'Referenced order line item or product was not found.'
                    ], 404);
                }

                if ((int) $orderDetail->order_id !== (int) $order->id || (int) $orderDetail->product_id !== (int) $product->id) {
                    DB::rollBack();
                    Log::warning('ReturnProductCreate blocked: order_detail ownership mismatch', [
                        'actor_user_id' => $user_id,
                        'order_id' => $order->id,
                        'order_detail_id' => $orderDetail->id,
                        'detail_order_id' => $orderDetail->order_id,
                        'detail_product_id' => $orderDetail->product_id,
                        'requested_product_id' => $product->id,
                    ]);
                    return response()->json([
                        'status' => 'fail',
                        'message' => 'ইনভয়েস লাইন আইটেম ও পণ্য এই অর্ডারের সাথে সামঞ্জস্যপূর্ণ নয়।'
                    ], 422);
                }

                $priorReturns = (int) ProductReturn::where('order_detail_id', $orderDetail->id)
                    ->orWhere(function ($q) use ($order, $product) {
                        $q->whereNull('order_detail_id')
                          ->where('order_id', $order->id)
                          ->where('product_id', $product->id);
                    })->sum('quantity');
                $priorReturnedQty = max((int) ($orderDetail->return_quantity ?? 0), $priorReturns);
                $availableReturnQty = max(0, (int) $orderDetail->quantity - $priorReturnedQty);

                if ($agg['quantity'] > $availableReturnQty) {
                    DB::rollBack();
                    Log::warning('ReturnProductCreate blocked: exceeds returnable quantity', [
                        'actor_user_id' => $user_id,
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'requested_qty' => $agg['quantity'],
                        'available_return_qty' => $availableReturnQty,
                    ]);
                    return response()->json([
                        'status' => 'fail',
                        'message' => "Return quantity for product '{$product->product_name}' cannot exceed available returnable quantity ({$availableReturnQty})."
                    ], 400);
                }
                $aggregatedByDetail[$dId]['prior_returned_qty'] = $priorReturnedQty;
            }

            // Generate one shared return transaction number for this entire submission
            $returnNumber = $this->generateReturnNumber();

            $totalReturnAmount = 0;
            $totalDiscountToReduce = 0;
            $totalDueToReduce = 0;

            // Value-proportional discount ratio based on order sub_total
            $orderSubTotal = (float) $order->sub_total;
            $orderDiscountAmount = (float) ($order->discount_amount ?? 0);
            $remainingDiscount = $orderDiscountAmount;
            $remainingDue = (float) ($order->due_amount ?? 0);

            $discountRatio = ($orderSubTotal > 0 && $orderDiscountAmount > 0)
                ? ($orderDiscountAmount / $orderSubTotal)
                : 0;

            $auditItems = [];
            foreach ($aggregatedByDetail as $dId => $agg) {
                $orderDetail = $lockedDetails->get($dId);
                $product = $lockedProducts->get($agg['product_id']);
                $returnQty = $agg['quantity'];
                $priorReturnedQty = $agg['prior_returned_qty'];

                // Historical immutable unit selling price
                $unitSellingPrice = (float) $orderDetail->selling_price;
                $lineReturnAmount = round($returnQty * $unitSellingPrice, 2);

                // Value-proportional discount allocation (capped by remaining invoice discount)
                $discountToReduce = 0;
                if ($discountRatio > 0 && $remainingDiscount > 0) {
                    $discountToReduce = min(round($lineReturnAmount * $discountRatio, 2), $remainingDiscount);
                    $remainingDiscount = max(0, $remainingDiscount - $discountToReduce);
                }

                // Due reduction (capped by net line return value and remaining invoice due across batch)
                $dueToReduce = 0;
                if ($remainingDue > 0) {
                    $netLineAmount = max(0, $lineReturnAmount - $discountToReduce);
                    $dueToReduce = min($netLineAmount, $remainingDue);
                    $remainingDue = max(0, $remainingDue - $dueToReduce);
                }

                // Create ProductReturn record with batch return_number, order_detail_id, and explicit unit_price
                ProductReturn::create([
                    'return_number'   => $returnNumber,
                    'order_id'        => $order->id,
                    'order_detail_id' => $orderDetail->id,
                    'product_id'      => $product->id,
                    'quantity'        => $returnQty,
                    'unit_price'      => $unitSellingPrice,
                    'amount'          => $lineReturnAmount,
                    'discount_amount' => $discountToReduce,
                    'due_amount'      => $dueToReduce,
                    'date'            => $request->date,
                    'customer_id'     => $order->customer_id ?? $request->customer_id,
                    'user_id'         => $user_id,
                ]);

                // Update locked product stock atomically - NEVER alters product cost_price or sell_price
                $oldStock = (int) $product->quantity;
                $newStock = $oldStock + $returnQty;
                $product->quantity = $newStock;
                $product->save();

                // Track returned quantity immutably on order detail (NEVER alter quantity, price, or selling_price, and NEVER delete detail!)
                $orderDetail->return_quantity = $priorReturnedQty + $returnQty;
                $orderDetail->save();

                $auditItems[] = [
                    'order_detail_id' => $orderDetail->id,
                    'product_id' => $product->id,
                    'returned_qty' => $returnQty,
                    'old_stock' => $oldStock,
                    'new_stock' => $newStock,
                ];

                $totalReturnAmount += $lineReturnAmount;
                $totalDiscountToReduce += $discountToReduce;
                $totalDueToReduce += $dueToReduce;
            }

            // Record return adjustment on order if supported, preserving historical sub_total, paid_amount, discount, and due_amount intact
            if (Schema::hasColumn('orders', 'return_adjustment_amount')) {
                $newReturnAdj = (float) ($order->return_adjustment_amount ?? 0) + $totalDueToReduce;
                $order->update([
                    'return_adjustment_amount' => $newReturnAdj,
                ]);
            }

            DB::commit();

            Log::info('Customer Return Created', [
                'actor_user_id' => $user_id,
                'return_number' => $returnNumber,
                'order_id' => $order->id,
                'order_no' => $order->order_no,
                'customer_id' => $order->customer_id,
                'total_refund_amount' => (float) round($totalReturnAmount, 2),
                'items' => $auditItems,
                'result' => 'success',
                'timestamp' => now()->toIso8601String(),
            ]);

            \App\Services\ActivityLogger::log(
                'RETURN',
                'Returns',
                "Processed sales return #{$returnNumber} for invoice \"{$order->order_no}\". Refund Amount: ৳ " . number_format($totalReturnAmount, 2) . ".",
                ['return_number' => $returnNumber, 'order_no' => $order->order_no, 'refund_amount' => $totalReturnAmount]
            );

            return response()->json([
                'status' => 'success',
                'message' => "Product Return Successfully Processed",
                'return_number' => $returnNumber,
                'total_refund_amount' => (float) round($totalReturnAmount, 2),
                'remaining_sub_total' => (float) $order->sub_total,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Customer Return Error', [
                'actor_user_id' => $actorUserId,
                'order_id' => $request->input('order_id'),
                'error' => $e->getMessage(),
            ]);
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

        $actorUserId = Auth::id();
        $requestedPurchaseId = (int) $request->purchase_id;
        $requestedSupplierId = (int) $request->supplier_id;

        // Unlocked preliminary lookup to standardize cross-table lock order:
        // Supplier (id ASC) -> Purchase -> PurchaseOrderDetails (id ASC) -> Product (id ASC)
        $preliminaryPurchase = Purchase::select(['id', 'supplier_id'])->find($requestedPurchaseId);
        if (!$preliminaryPurchase) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Purchase record not found.'
            ], 404);
        }

        $supplierIdsToLock = array_values(array_unique(array_filter([
            (int) $preliminaryPurchase->supplier_id,
            $requestedSupplierId,
        ])));
        sort($supplierIdsToLock);

        try {
            DB::beginTransaction();

            $user_id = $actorUserId;
            $lockedSuppliers = Supplier::whereIn('id', $supplierIdsToLock)
                ->orderBy('id', 'asc')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $supplier = $lockedSuppliers->get($requestedSupplierId);
            if (!$supplier) {
                DB::rollBack();
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Selected supplier not found.'
                ], 404);
            }

            // Lock Purchase strictly AFTER Supplier(s) to match SupplierPaymentDetailsUpdate()
            $purchase = Purchase::with('orderDetails')->lockForUpdate()->findOrFail($requestedPurchaseId);

            if ((int) $purchase->supplier_id !== (int) $preliminaryPurchase->supplier_id) {
                DB::rollBack();
                Log::warning('PurchaseReturnProductCreate blocked: concurrent supplier reassignment race', [
                    'actor_user_id' => $user_id,
                    'purchase_id' => $purchase->id,
                    'preliminary_supplier_id' => (int) $preliminaryPurchase->supplier_id,
                    'locked_supplier_id' => (int) $purchase->supplier_id,
                ]);
                return response()->json([
                    'status' => 'fail',
                    'message' => 'পারচেজের সাপ্লাইয়ার তথ্য সমসাময়িকভাবে পরিবর্তিত হয়েছে; অনুগ্রহ করে আবার চেষ্টা করুন।'
                ], 409);
            }

            if ((int) $purchase->supplier_id !== (int) $supplier->id) {
                DB::rollBack();
                Log::warning('PurchaseReturnProductCreate blocked: supplier mismatch', [
                    'actor_user_id' => $user_id,
                    'purchase_id' => $purchase->id,
                    'purchase_supplier_id' => $purchase->supplier_id,
                    'requested_supplier_id' => $supplier->id,
                ]);
                return response()->json([
                    'status' => 'fail',
                    'message' => 'নির্বাচিত সাপ্লাইয়ার এই পারচেজ ইনভয়েসের সাথে মিলছে না।'
                ], 422);
            }

            // Deterministically lock all referenced PurchaseOrderDetails and Product rows
            $detailIds = collect($request->products)->pluck('purchase_order_detail_id')->map(fn ($v) => (int) $v)->unique()->sort()->values()->all();
            $productIds = collect($request->products)->pluck('product_id')->map(fn ($v) => (int) $v)->unique()->sort()->values()->all();

            $lockedDetails = PurchaseOrderDetails::whereIn('id', $detailIds)->orderBy('id', 'asc')->lockForUpdate()->get()->keyBy('id');
            $lockedProducts = Product::whereIn('id', $productIds)->orderBy('id', 'asc')->lockForUpdate()->get()->keyBy('id');

            // Aggregate request lines by detail ID and validate ownership & stock BEFORE mutating any row
            $aggregatedByDetail = [];
            $totalRequestedByProduct = [];
            foreach ($request->products as $returnedItem) {
                $dId = (int) $returnedItem['purchase_order_detail_id'];
                $pId = (int) $returnedItem['product_id'];
                $qty = (int) $returnedItem['quantity'];
                if (isset($aggregatedByDetail[$dId])) {
                    if ($aggregatedByDetail[$dId]['product_id'] !== $pId) {
                        DB::rollBack();
                        return response()->json([
                            'status' => 'fail',
                            'message' => 'একই পারচেজ লাইনে ভিন্ন প্রোডাক্ট আইডি পাওয়া গেছে।'
                        ], 422);
                    }
                    $aggregatedByDetail[$dId]['quantity'] += $qty;
                } else {
                    $aggregatedByDetail[$dId] = [
                        'purchase_order_detail_id' => $dId,
                        'product_id' => $pId,
                        'quantity' => $qty,
                    ];
                }
                $totalRequestedByProduct[$pId] = ($totalRequestedByProduct[$pId] ?? 0) + $qty;
            }

            foreach ($aggregatedByDetail as $dId => $agg) {
                $orderDetail = $lockedDetails->get($dId);
                $product = $lockedProducts->get($agg['product_id']);
                if (!$orderDetail || !$product) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'fail',
                        'message' => 'Referenced purchase line item or product was not found.'
                    ], 404);
                }

                if ((int) $orderDetail->purchase_id !== (int) $purchase->id || (int) $orderDetail->product_id !== (int) $product->id) {
                    DB::rollBack();
                    Log::warning('PurchaseReturnProductCreate blocked: detail ownership mismatch', [
                        'actor_user_id' => $user_id,
                        'purchase_id' => $purchase->id,
                        'purchase_order_detail_id' => $orderDetail->id,
                        'detail_purchase_id' => $orderDetail->purchase_id,
                        'detail_product_id' => $orderDetail->product_id,
                        'requested_product_id' => $product->id,
                    ]);
                    return response()->json([
                        'status' => 'fail',
                        'message' => 'পারচেজ লাইন আইটেম ও পণ্য এই পারচেজের সাথে সামঞ্জস্যপূর্ণ নয়।'
                    ], 422);
                }

                $remainingPurchasedQty = max(0, (int) $orderDetail->quantity - (int) ($orderDetail->return_quantity ?? 0));
                if ($agg['quantity'] > $remainingPurchasedQty) {
                    DB::rollBack();
                    $prodName = $product->product_name ?? ("Product #{$product->id}");
                    Log::warning('PurchaseReturnProductCreate blocked: exceeds purchased quantity', [
                        'actor_user_id' => $user_id,
                        'purchase_id' => $purchase->id,
                        'product_id' => $product->id,
                        'requested_qty' => $agg['quantity'],
                        'remaining_purchased_qty' => $remainingPurchasedQty,
                    ]);
                    return response()->json([
                        'status' => 'fail',
                        'message' => "Return quantity for product {$prodName} exceeds remaining purchased quantity ({$remainingPurchasedQty})."
                    ], 422);
                }
            }

            foreach ($totalRequestedByProduct as $pId => $neededReturnQty) {
                $product = $lockedProducts->get($pId);
                $currentStock = (int) $product->quantity;
                if ($currentStock < $neededReturnQty) {
                    DB::rollBack();
                    $prodName = $product->product_name ?? ("Product #{$product->id}");
                    Log::warning('PurchaseReturnProductCreate blocked: insufficient stock', [
                        'actor_user_id' => $user_id,
                        'purchase_id' => $purchase->id,
                        'product_id' => $product->id,
                        'current_stock' => $currentStock,
                        'requested_return_qty' => $neededReturnQty,
                    ]);
                    return response()->json([
                        'status' => 'fail',
                        'message' => "Insufficient stock for product {$prodName}: current stock is {$currentStock}, cannot return {$neededReturnQty}."
                    ], 422);
                }
            }

            $totalReturnAmount = 0;
            $date = Carbon::parse($request->date)->format('Y-m-d');
            $auditItems = [];

            foreach ($aggregatedByDetail as $dId => $agg) {
                $orderDetail = $lockedDetails->get($dId);
                $product = $lockedProducts->get($agg['product_id']);
                $returnQty = $agg['quantity'];
                $currentStock = (int) $product->quantity;

                // Unit price calculation
                $unitPrice = $orderDetail->cost_price;
                $returnAmount = $returnQty * $unitPrice;

                // Save purchase return record
                PurchaseReturn::create([
                    'purchase_id' => $purchase->id,
                    'supplier_id' => $supplier->id,
                    'product_id' => $product->id,
                    'purchase_order_detail_id' => $orderDetail->id,
                    'quantity' => $returnQty,
                    'amount' => $returnAmount,
                    'due_amount' => $returnAmount,
                    'date' => $date,
                    'user_id' => $user_id,
                ]);

                // Update locked product stock atomically
                $newStock = $currentStock - $returnQty;
                $product->quantity = $newStock;
                $product->save();

                // Update purchase order detail return tracking
                $orderDetail->return_quantity = ($orderDetail->return_quantity ?? 0) + $returnQty;
                $orderDetail->save();

                $auditItems[] = [
                    'purchase_order_detail_id' => $orderDetail->id,
                    'product_id' => $product->id,
                    'returned_qty' => $returnQty,
                    'old_stock' => $currentStock,
                    'new_stock' => $newStock,
                    'return_amount' => $returnAmount,
                ];

                $totalReturnAmount += $returnAmount;
            }

            // Update purchase totals
            $currentPurchaseOrderDetailsSubtotal = PurchaseOrderDetails::where('purchase_id', $purchase->id)->sum('subtotal');
            $remainingSubTotal = $currentPurchaseOrderDetailsSubtotal;
            $remainingPaid = $purchase->paid_amount;
            $remainingDue = max(0, ($purchase->due_amount - $totalReturnAmount));

            $purchase->update([
                'grand_subtotal' => $remainingSubTotal,
                'paid_amount' => $remainingPaid,
                'due_amount' => $remainingDue,
            ]);

            // Update supplier balance
            $supplier->update([
                'purchase_payable_amount' => max(0, $supplier->purchase_payable_amount - $totalReturnAmount),
            ]);

            DB::commit();

            Log::info('Purchase Return Created', [
                'actor_user_id' => $user_id,
                'purchase_id' => $purchase->id,
                'purchase_code' => $purchase->purchase_id,
                'supplier_id' => $supplier->id,
                'total_return_amount' => $totalReturnAmount,
                'remaining_sub_total' => $remainingSubTotal,
                'remaining_due' => $remainingDue,
                'items' => $auditItems,
                'result' => 'success',
                'timestamp' => now()->toIso8601String(),
            ]);

            \App\Services\ActivityLogger::log(
                'RETURN',
                'Returns',
                "Processed purchase return for invoice \"{$purchase->purchase_id}\". Return Amount: ৳ " . number_format($totalReturnAmount, 2) . ".",
                ['purchase_code' => $purchase->purchase_id, 'return_amount' => $totalReturnAmount]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Purchase Return Successfully Processed',
                'remaining_sub_total' => $remainingSubTotal,
                'remaining_due' => $remainingDue,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Purchase Return Error', [
                'actor_user_id' => $actorUserId,
                'purchase_id' => $request->input('purchase_id'),
                'error' => $e->getMessage(),
            ]);
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

            $items = $order->details->map(function($detail) use ($order) {
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

                $totalQty = (int) $detail->quantity;
                $priorReturns = (int) ProductReturn::where('order_detail_id', $detail->id)
                    ->orWhere(function ($q) use ($order, $detail) {
                        $q->whereNull('order_detail_id')
                          ->where('order_id', $order->id)
                          ->where('product_id', $detail->product_id);
                    })->sum('quantity');
                $returnedQty = max((int) ($detail->return_quantity ?? 0), $priorReturns);
                $availableQty = max(0, $totalQty - $returnedQty);
                $unitPrice = (float) $detail->selling_price;

                return [
                    'order_detail_id'     => $detail->id,
                    'product_id'          => $detail->product_id,
                    'product_name'        => $detail->product ? $detail->product->product_name : 'Product',
                    'product_code'        => $code,
                    'quantity'            => $availableQty,
                    'purchased_quantity'  => $totalQty,
                    'returned_quantity'   => $returnedQty,
                    'unit_price'          => round($unitPrice, 2),
                    'total_selling_price' => round($unitPrice * $availableQty, 2),
                ];
            })->filter(function($item) {
                return $item['quantity'] > 0;
            })->values();

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
            $PurchaseReturnData = PurchaseReturn::with(['supplier', 'purchase', 'product.unit'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    $sName = $item->supplier ? ($item->supplier->name ?? $item->supplier->company) : 'Supplier';
                    $pName = $item->product ? ($item->product->product_name ?? 'N/A') : 'N/A';
                    $pNo = $item->purchase ? ('#PurID' . str_pad($item->purchase->id, 5, '0', STR_PAD_LEFT)) : 'N/A';

                    $qty = (int) ($item->quantity ?? 1);
                    if ($qty <= 0) $qty = 1;

                    $sMobile = $item->supplier ? ($item->supplier->mobile ?? $item->supplier->phone ?? '') : '';
                    $unitName = ($item->product && $item->product->unit) ? ($item->product->unit->name ?? 'pcs') : 'pcs';

                    return [
                        'id'              => $item->id,
                        'purchase_id'     => $item->purchase_id ?? ($item->purchase ? $item->purchase->id : null),
                        'supplier_id'     => $item->supplier_id ?? ($item->supplier ? $item->supplier->id : null),
                        'product_id'      => $item->product_id,
                        'purchase_no'     => $pNo,
                        'supplier_name'   => $sName,
                        'supplier_mobile' => $sMobile,
                        'product_name'    => $pName,
                        'unit'            => $unitName,
                        'quantity'        => $qty,
                        'amount'          => (float) $item->amount,
                        'due_amount'      => (float) $item->due_amount,
                        'date'            => $item->date ?? ($item->created_at ? $item->created_at->format('Y-m-d') : null),
                        'created_at_formatted' => $item->created_at ? $item->created_at->format('d M Y, h:i A') : '',
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
