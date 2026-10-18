<?php

namespace App\Http\Controllers\Battery;

use Exception;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryOrder;
use App\Models\Battery\BatteryProduct;
use App\Models\Battery\BatteryCustomer;
use App\Models\Battery\BatteryOrderDetail;
use App\Models\Battery\BatteryProductReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class BatteryProductReturnController extends Controller
{
    private function generateBatteryReturnNumber(): string
    {
        $lastReturn = BatteryProductReturn::whereNotNull('return_number')->orderBy('id', 'desc')->first();
        $nextNumber = 1;
        if ($lastReturn && preg_match('/#BRET(\d+)/', $lastReturn->return_number, $matches)) {
            $nextNumber = (int) $matches[1] + 1;
        }

        return sprintf('#BRET%05d', $nextNumber);
    }

    public function ReturnProductList()
    {
        try {
            $returns = BatteryProductReturn::with(['customer', 'order', 'product.unit', 'orderDetail'])
                ->orderBy('created_at', 'desc')
                ->orderBy('id', 'desc')
                ->get();

            // Group returns by return_number (with fallback for legacy records)
            $grouped = $returns->groupBy(function ($item) {
                return $item->return_number ?: ('LEGACY_' . $item->order_id . '_' . ($item->created_at ? $item->created_at->format('Y-m-d_H:i:s') : $item->id));
            });

            $ProductReturnData = $grouped->map(function ($group) {
                $first = $group->first();
                $returnNumber = $first->return_number ?: ('#BRET' . str_pad($first->id, 5, '0', STR_PAD_LEFT));
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

    public function SearchInvoiceForReturn(Request $request)
    {
        try {
            $orderNo = trim($request->input('order_no'));
            if (!$orderNo) {
                return response()->json(['status' => 'fail', 'message' => 'Invoice number is required']);
            }

            $cleanNo = ltrim($orderNo, '#');

            $order = BatteryOrder::with(['customer', 'details.product'])
                ->where('order_no', $orderNo)
                ->orWhere('order_no', '#' . $cleanNo)
                ->orWhere('order_no', $cleanNo)
                ->orWhere('id', $cleanNo)
                ->first();

            if (!$order) {
                $order = BatteryOrder::with(['customer', 'details.product'])
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
                    elseif (is_string($rawCode) && str_starts_with($rawCode, '[')) {
                        try { $arr = json_decode($rawCode, true); $code = $arr[0] ?? 'N/A'; } catch(\Exception $e){}
                    } else {
                        $code = $rawCode;
                    }
                }

                $totalQty = (int) $detail->quantity;
                $priorReturns = (int) BatteryProductReturn::where('order_detail_id', $detail->id)->sum('quantity');
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
                    'invoice_date'    => Carbon::parse($order->invoice_date ?? $order->created_at)->format('d M Y'),
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

    public function ReturnProductCreate(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:battery_orders,id',
            'customer_id' => 'required',
            'products' => 'required|array|min:1',
            'products.*.order_detail_id' => 'required|exists:battery_order_details,id',
            'products.*.product_id' => 'required|exists:battery_products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $order = BatteryOrder::with('details')->findOrFail($request->order_id);
            $user_id = Auth::id() ?? ($order->user_id ?? 1);

            // Generate one shared return transaction number for this entire submission
            $returnNumber = $this->generateBatteryReturnNumber();

            $totalReturnAmount = 0;
            $totalDiscountToReduce = 0;
            $totalDueToReduce = 0;
            $totalOrderQty = (int) $order->details->sum('quantity');

            foreach ($request->products as $returnedItem) {
                // Lock rows for concurrency protection
                $orderDetail = BatteryOrderDetail::where('id', $returnedItem['order_detail_id'])->lockForUpdate()->firstOrFail();
                $product = BatteryProduct::where('id', $returnedItem['product_id'])->lockForUpdate()->firstOrFail();
                $returnQty = (int) $returnedItem['quantity'];

                // Calculate cumulative prior returns against this exact line item
                $priorReturns = (int) BatteryProductReturn::where('order_detail_id', $orderDetail->id)->sum('quantity');
                $priorReturnedQty = max((int) ($orderDetail->return_quantity ?? 0), $priorReturns);
                $availableReturnQty = max(0, (int) $orderDetail->quantity - $priorReturnedQty);

                // Reject if return quantity exceeds remaining returnable quantity
                if ($returnQty > $availableReturnQty) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'fail',
                        'message' => "Return quantity for product '{$product->product_name}' cannot exceed available returnable quantity ({$availableReturnQty})."
                    ], 400);
                }

                // Historical immutable unit selling price
                $unitSellingPrice = (float) $orderDetail->selling_price;
                $lineReturnAmount = round($returnQty * $unitSellingPrice, 2);

                $discountToReduce = ($totalOrderQty > 0) ? round($returnQty * ($order->discount_amount / $totalOrderQty), 2) : 0;
                $dueToReduce = min($lineReturnAmount, (float) $order->due_amount);

                // Create BatteryProductReturn record
                BatteryProductReturn::create([
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

                // Increment battery product stock atomically
                $product->increment('quantity', $returnQty);

                // Update battery order details return_quantity (preserve invoice line)
                $orderDetail->return_quantity = $priorReturnedQty + $returnQty;
                $orderDetail->save();

                $totalReturnAmount += $lineReturnAmount;
                $totalDiscountToReduce += $discountToReduce;
                $totalDueToReduce += $dueToReduce;
            }

            // Record return adjustment on battery order if supported, preserving historical sub_total, paid_amount, and due_amount intact
            if (Schema::hasColumn('battery_orders', 'return_adjustment_amount')) {
                $newReturnAdj = (float) ($order->return_adjustment_amount ?? 0) + $totalDueToReduce;
                $order->update([
                    'return_adjustment_amount' => $newReturnAdj,
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Sales return processed successfully.',
                'return_number' => $returnNumber,
                'total_refund_amount' => (float) round($totalReturnAmount, 2),
                'remaining_sub_total' => (float) $order->sub_total,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Battery Sales Return Error: ' . $e->getMessage());
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }

    public function ReturnShowDetails($id)
    {
        $order = BatteryOrder::with(['customer', 'details.product', 'payment', 'paymentDetails'])->find($id);
        if ($order) {
            $invoice = $order;
            $subTotal = $invoice->details->sum(function($orderDetail) {
                return ($orderDetail->selling_price ?: ($orderDetail->price * $orderDetail->quantity));
            });
            $paidAmount = (float) ($invoice->paid_amount ?? ($invoice->payment ? $invoice->payment->paid_amount : 0));
            $dueAmount = (float) ($invoice->due_amount ?? max(0, $subTotal - $paidAmount));

            return view('battery.return.return-product', compact('invoice', 'subTotal', 'paidAmount', 'dueAmount'));
        }

        $return = BatteryProductReturn::with(['order', 'customer', 'product', 'user', 'orderDetail'])->findOrFail($id);

        return view('battery.return.return-details', compact('return'));
    }
}
