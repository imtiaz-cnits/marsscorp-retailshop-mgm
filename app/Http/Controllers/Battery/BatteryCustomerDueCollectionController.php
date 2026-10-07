<?php

namespace App\Http\Controllers\Battery;

use Exception;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryCustomer;
use App\Models\Battery\BatteryOrder;
use App\Models\Battery\BatteryCustomerPaymentDetail;
use App\Models\Battery\BatteryOrderPaymentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BatteryCustomerDueCollectionController extends Controller
{
    public function CustomerDueCollectionList()
    {
        try {
            $CustomerDueCollectionData = BatteryCustomerPaymentDetail::with('customer:id,customer_name,customer_id')->latest()->get();
            return response()->json(['status' => 'success', 'CustomerDueCollectionData' => $CustomerDueCollectionData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function CustomerDueCollectionByID(Request $request)
    {
        try {
            $request->validate(["id" => 'required']);

            $customer = BatteryCustomer::where('id', $request->input('id'))->first();

            if (!$customer) {
                return response()->json(['status' => 'fail', 'message' => 'Customer not found']);
            }

            $previous_due = (float) ($customer->previous_due_amount ?? 0);
            $order_due = (float) BatteryOrder::where('customer_id', $customer->id)->sum('due_amount');
            $total_due = $previous_due + $order_due;

            return response()->json([
                'status' => 'success',
                'rows' => $customer,
                'previous_due' => $previous_due,
                'order_due' => $order_due,
                'total_due' => $total_due
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function CustomerPaymentDetailsUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id = Auth::id() ?? 1;
            $customerId = $request->input('customer_id') ?? $request->input('id');
            $customer = BatteryCustomer::findOrFail($customerId);

            $inputPaidAmount = floatval($request->paid_amount ?? 0);
            $inputDiscountAmount = floatval($request->discount_amount ?? 0);
            $paymentMethod = $request->payment_method ?? 'Cash';

            $rawDate = $request->input('due_collection_date') ?? $request->input('payment_date') ?? $request->input('collection_date');
            $dueCollectionDate = date('Y-m-d');
            if (!empty($rawDate)) {
                try {
                    $dueCollectionDate = Carbon::parse(str_replace('/', '-', trim($rawDate)))->format('Y-m-d');
                } catch (\Exception $e) {
                    $dueCollectionDate = date('Y-m-d');
                }
            }

            $transactionId = $request->transaction_id ?? $request->note ?? null;
            $collectionType = $request->collection_type ?? 'all';

            $totalAvailablePaid = $inputPaidAmount;
            $totalAvailableDiscount = $inputDiscountAmount;

            $customerPreviousDue = floatval($customer->previous_due_amount ?? 0);

            $ordersPaidTotal = 0;
            $ordersDiscountTotal = 0;

            // Step 1: Clear previous due (Previous Due)
            if (($collectionType === 'all' || $collectionType === 'previous') && ($totalAvailablePaid + $totalAvailableDiscount) > 0 && $customerPreviousDue > 0) {
                $totalPowerToPay = $totalAvailablePaid + $totalAvailableDiscount;

                if ($totalPowerToPay >= $customerPreviousDue) {
                    $usedFromDiscount = min($totalAvailableDiscount, $customerPreviousDue);
                    $usedFromPaid = $customerPreviousDue - $usedFromDiscount;

                    $totalAvailableDiscount -= $usedFromDiscount;
                    $totalAvailablePaid -= $usedFromPaid;

                    $customer->update(['previous_due_amount' => 0]);

                    $remainingOrderDue = (float) BatteryOrder::where('customer_id', $customer->id)
                        ->where('due_amount', '>', 0)
                        ->sum('due_amount');
                    $totalRemainingDue = $remainingOrderDue;

                    BatteryCustomerPaymentDetail::create([
                        'customer_id'         => $customer->id,
                        'paid_amount'         => $usedFromPaid,
                        'discount_amount'     => $usedFromDiscount,
                        'due_amount'          => $totalRemainingDue,
                        'payment_status'      => $totalRemainingDue == 0 ? 'Fully Paid' : 'Partial Paid',
                        'previous_due_amount' => $usedFromPaid + $usedFromDiscount,
                        'payment_method'      => $paymentMethod,
                        'due_collection_date' => $dueCollectionDate,
                        'transaction_id'      => $transactionId,
                        'user_id'             => $user_id,
                    ]);
                } else {
                    $usedAmount = $totalPowerToPay;
                    $paidRatio = $totalPowerToPay > 0 ? ($totalAvailablePaid / $totalPowerToPay) : 0;
                    $usedFromPaid = round($usedAmount * $paidRatio, 2);
                    $usedFromDiscount = $usedAmount - $usedFromPaid;

                    $customer->update([
                        'previous_due_amount' => $customerPreviousDue - $usedAmount
                    ]);

                    $totalAvailableDiscount = 0;
                    $totalAvailablePaid = 0;

                    $remainingPreviousDue = $customerPreviousDue - $usedAmount;
                    $remainingOrderDue = (float) BatteryOrder::where('customer_id', $customer->id)
                        ->where('due_amount', '>', 0)
                        ->sum('due_amount');
                    $totalRemainingDue = $remainingPreviousDue + $remainingOrderDue;

                    BatteryCustomerPaymentDetail::create([
                        'customer_id'         => $customer->id,
                        'paid_amount'         => $usedFromPaid,
                        'discount_amount'     => $usedFromDiscount,
                        'due_amount'          => $totalRemainingDue,
                        'payment_status'      => 'Partial Paid',
                        'previous_due_amount' => $usedAmount,
                        'payment_method'      => $paymentMethod,
                        'due_collection_date' => $dueCollectionDate,
                        'transaction_id'      => $transactionId,
                        'user_id'             => $user_id,
                    ]);
                }
            }

            // Step 2: FIFO order due payoff
            if (($collectionType === 'all' || $collectionType === 'invoice') && ($totalAvailablePaid + $totalAvailableDiscount) > 0) {
                $dueOrders = BatteryOrder::where('customer_id', $customer->id)
                    ->where('due_amount', '>', 0)
                    ->orderBy('created_at', 'asc')
                    ->get();

                foreach ($dueOrders as $order) {
                    $availableToPay = $totalAvailablePaid + $totalAvailableDiscount;
                    if ($availableToPay <= 0) break;

                    $orderDue = floatval($order->due_amount);
                    $amountToPay = min($availableToPay, $orderDue);

                    $totalInput = $inputPaidAmount + $inputDiscountAmount;
                    $paidRatio = $totalInput > 0 ? ($inputPaidAmount / $totalInput) : 1;
                    $discountRatio = 1 - $paidRatio;

                    $usedFromDiscount = min($totalAvailableDiscount, round($amountToPay * $discountRatio, 2));
                    $usedFromPaid = $amountToPay - $usedFromDiscount;
                    $usedFromPaid = min($usedFromPaid, $totalAvailablePaid);

                    $totalUsed = $usedFromPaid + $usedFromDiscount;
                    if ($totalUsed > $amountToPay) {
                        $diff = $totalUsed - $amountToPay;
                        $usedFromPaid -= $diff;
                    }

                    $order->update([
                        'due_amount'  => max(0, $order->due_amount - ($usedFromPaid + $usedFromDiscount)),
                        'paid_amount' => $order->paid_amount + $usedFromPaid,
                    ]);

                    if ($usedFromPaid > 0 || $usedFromDiscount > 0) {
                        $remainingDue = max(0, $order->fresh()->due_amount);
                        $paymentStatus = $remainingDue == 0 ? 'Paid' : 'Partial Paid';

                        BatteryOrderPaymentDetail::create([
                            'order_id'            => $order->id,
                            'paid_amount'         => $usedFromPaid,
                            'discount_amount'     => $usedFromDiscount,
                            'payment_status'      => $paymentStatus,
                            'payment_method'      => $paymentMethod,
                            'due_collection_date' => $dueCollectionDate,
                            'transaction_id'      => $transactionId,
                            'user_id'             => $user_id,
                        ]);
                    }

                    $totalAvailablePaid -= $usedFromPaid;
                    $totalAvailableDiscount -= $usedFromDiscount;

                    $ordersPaidTotal += $usedFromPaid;
                    $ordersDiscountTotal += $usedFromDiscount;
                }

                if ($ordersPaidTotal > 0 || $ordersDiscountTotal > 0) {
                    $remainingPreviousDue = floatval($customer->previous_due_amount ?? 0);
                    $remainingOrderDue = (float) BatteryOrder::where('customer_id', $customer->id)
                        ->where('due_amount', '>', 0)
                        ->sum('due_amount');

                    $totalRemainingDue = $remainingPreviousDue + $remainingOrderDue;

                    BatteryCustomerPaymentDetail::create([
                        'customer_id'         => $customer->id,
                        'paid_amount'         => $ordersPaidTotal,
                        'discount_amount'     => $ordersDiscountTotal,
                        'due_amount'          => $totalRemainingDue,
                        'payment_status'      => $totalRemainingDue == 0 ? 'Fully Paid' : 'Partial Paid',
                        'previous_due_amount' => 0,
                        'payment_method'      => $paymentMethod,
                        'due_collection_date' => $dueCollectionDate,
                        'transaction_id'      => $transactionId,
                        'user_id'             => $user_id,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Customer payment updated successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Battery Customer Due Collection Error: ' . $e->getMessage());
            return response()->json([
                'status'  => 'fail',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
