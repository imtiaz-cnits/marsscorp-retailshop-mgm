<?php

namespace App\Http\Controllers\Battery;

use Exception;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryOrder;
use App\Models\Battery\BatteryOrderDetail;
use App\Models\Battery\BatteryOrderPaymentDetail;
use App\Models\Battery\BatteryProduct;
use App\Models\Battery\BatteryCustomer;
use App\Models\Battery\BatteryProductReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BatteryInvoiceController extends Controller
{
    public function InvoiceOrderPaymentDetails(Request $request)
    {
        try {
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');

            $query = BatteryOrder::with([
                'customer:id,customer_name,customer_id,mobile',
                'productReturns',
                'user:id,name'
            ])->select([
                'id', 'order_no', 'sub_total', 'discount_amount', 'paid_amount',
                'due_amount', 'customer_id', 'user_id', 'invoice_date'
            ]);

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

            $query->orderBy('id', 'DESC');

            $InvoicePaymentDetails = $query->get()->map(function ($order) {
                $order->total_return_amount = (float) $order->productReturns->sum('amount');
                return $order;
            });

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
            $request->validate(["id" => 'required']);

            $order = BatteryOrder::with(['customer', 'details.product', 'payment', 'payments'])
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

    public function InvoicePaymentDetailsUpdate(Request $request)
    {
        try {
            $user_id = Auth::id();
            $order = BatteryOrder::findOrFail($request->input('id'));

            $newPaidAmount = floatval($order->paid_amount) + floatval($request->paid_amount ?? 0);
            $newDueAmount = max(0, floatval($order->due_amount) - floatval($request->paid_amount ?? 0));

            $order->paid_amount = $newPaidAmount;
            $order->due_amount = $newDueAmount;
            $order->save();

            $status = $newDueAmount <= 0 ? 'Fully Paid' : 'Partial Paid';

            $newPayment = BatteryOrderPaymentDetail::create([
                'order_id' => $order->id,
                'paid_amount' => $request->paid_amount ?? 0,
                'discount_amount' => $request->discount_amount ?? 0,
                'payment_status' => $status,
                'user_id' => $user_id,
                'transaction_id' => $request->transaction_id ?? null,
                'payment_method' => $request->payment_method ?? 'Cash',
                'due_collection_date' => now()->format('Y-m-d'),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Order payment details updated successfully',
                'updated_order' => $order,
                'updated_id' => $newPayment->id
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function getInvoiceFullDetailsById(Request $request)
    {
        try {
            $id = $request->input('id');
            $order = BatteryOrder::with(['customer', 'user', 'details.product'])->findOrFail($id);

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
            $order = BatteryOrder::with('details')->findOrFail($id);
            $user_id = Auth::id();

            $itemsRaw = $request->input('items');
            $items = is_array($itemsRaw) ? $itemsRaw : json_decode($itemsRaw, true);
            if (!is_array($items)) {
                $items = [];
            }

            // Restore previous stock
            foreach ($order->details as $oldDetail) {
                $product = BatteryProduct::find($oldDetail->product_id);
                if ($product) {
                    $product->increment('quantity', $oldDetail->quantity);
                }
            }

            BatteryOrderDetail::where('order_id', $order->id)->delete();

            $calculatedSubTotal = 0;
            foreach ($items as $item) {
                $productId = intval($item['product_id']);
                $qty = floatval($item['quantity']);
                $sellingPrice = floatval($item['selling_price']);
                $costPrice = floatval($item['cost_price'] ?? 0);

                if ($productId <= 0 || $qty <= 0) continue;

                $itemSubTotal = $sellingPrice * $qty;
                $calculatedSubTotal += $itemSubTotal;

                BatteryOrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'price' => $costPrice,
                    'selling_price' => $sellingPrice,
                    'user_id' => $user_id,
                ]);

                $product = BatteryProduct::find($productId);
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

            BatteryOrderPaymentDetail::where('order_id', $order->id)->delete();

            $paymentStatus = $dueAmount <= 0 ? 'Fully Paid' : ($paidAmount > 0 ? 'Partial Paid' : 'Unpaid');

            BatteryOrderPaymentDetail::create([
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
            Log::error("Battery Invoice Update Error: " . $e->getMessage());
            return response()->json([
                'status' => 'fail',
                'message' => 'Failed to update invoice: ' . $e->getMessage()
            ], 500);
        }
    }

    public function InvoiceOrderDuePaymentDetails(Request $request)
    {
        try {
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');

            $query = BatteryOrder::with('customer:id,customer_name,customer_id,mobile', 'productReturns')
                ->select(['id', 'order_no', 'sub_total', 'discount_amount', 'paid_amount', 'due_amount', 'customer_id', 'created_at']);

            if ($startDate && $endDate) {
                $startDate = Carbon::parse($startDate)->startOfDay();
                $endDate = Carbon::parse($endDate)->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $query->orderBy('created_at', 'DESC');

            $InvoicePaymentDetails = $query->get()->map(function ($order) {
                $order->total_return_amount = (float) $order->productReturns->sum('amount');
                return $order;
            })->filter(function ($order) {
                return $order->due_amount > 0;
            })->values();

            return response()->json(['status' => 'success', 'InvoicePaymentDetails' => $InvoicePaymentDetails->toArray()]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function InvoiceShowDetails($id)
    {
        $invoice = BatteryOrder::with(['customer', 'details.product', 'payment', 'paymentDetails'])->find($id);

        if (!$invoice) {
            abort(404, 'Battery invoice not found');
        }

        $currentDue = (float) ($invoice->due_amount ?? 0);

        // Previous orders due for this customer up to this invoice
        $previousOrdersDue = (float) BatteryOrder::where('customer_id', $invoice->customer_id)
            ->where('id', '!=', $invoice->id)
            ->where('created_at', '<', $invoice->created_at)
            ->sum('due_amount');

        $customerPreviousDue = (float) ($invoice->customer->previous_due_amount ?? 0);
        $actualPreviousDue   = $customerPreviousDue + $previousOrdersDue;
        $totalDue            = $actualPreviousDue + $currentDue;

        return view('battery.invoice.due-invoice-print', compact(
            'invoice',
            'currentDue',
            'actualPreviousDue',
            'totalDue'
        ));
    }
}
