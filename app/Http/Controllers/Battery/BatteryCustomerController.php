<?php

namespace App\Http\Controllers\Battery;

use Exception;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatteryCustomer;
use App\Models\Battery\BatteryOrder;
use App\Models\Battery\BatteryProductReturn;
use App\Models\Battery\BatteryOrderPaymentDetail;
use App\Models\Battery\BatteryCustomerPaymentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BatteryCustomerController extends Controller
{
    public function CustomerList()
    {
        try {
            $customers = BatteryCustomer::with(['orders:id,customer_id,due_amount,created_at'])->latest()->get();

            $customerData = $customers->map(function ($customer) {
                $orderDueTotal = (float) $customer->orders->sum('due_amount');
                $remPrevDue = (float) ($customer->previous_due_amount ?? 0);
                $effectiveTotalDue = max(0, $remPrevDue + $orderDueTotal);

                $customer->total_due = round($effectiveTotalDue, 2);
                $customer->previous_due_amount = round($effectiveTotalDue, 2);

                $totalReturns = (float) DB::table('battery_product_returns')->where('customer_id', $customer->id)->sum('amount');
                $totalAdjusted = (float) DB::table('battery_orders')->where('customer_id', $customer->id)->sum('return_adjustment_amount');
                $availableCredit = max(0, $totalReturns - $totalAdjusted);

                $customer->return_credit_balance = round($availableCredit, 2);
                $customer->orders = $customer->orders->sortByDesc('created_at')->values();

                return $customer;
            });

            return response()->json([
                'status' => 'success',
                'CustomerData' => $customerData
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function CustomerDueList()
    {
        try {
            $CustomerData = BatteryCustomer::with(['orders' => function ($query) {
                $query->select('id', 'customer_id', 'due_amount');
            }])
            ->where(function ($q) {
                $q->where('previous_due_amount', '>', 0)
                  ->orWhereHas('orders', function ($q2) {
                      $q2->where('due_amount', '>', 0);
                  });
            })
            ->orderBy('created_at', 'desc')
            ->get();

            $CustomerData = $CustomerData->map(function ($customer) {
                $orderDue = (float) $customer->orders->sum('due_amount');
                $customer->order_due_amount = $orderDue;
                $customer->previous_due_amount = (float) ($customer->previous_due_amount ?? 0);
                $customer->total_due_amount = $customer->previous_due_amount + $orderDue;
                return $customer;
            });

            return response()->json([
                'status' => 'success',
                'CustomerData' => $CustomerData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function CustomerCreate(Request $request)
    {
        try {
            $user_id = Auth::id();
            $imgPath = null;

            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $imgName = time() . '-' . $user_id . '-' . $img->getClientOriginalName();
                $imgPath = "uploads/battery-customer-img/{$imgName}";
                $destination = public_path('uploads/battery-customer-img');
                if (!file_exists($destination)) {
                    @mkdir($destination, 0777, true);
                }
                $img->move($destination, $imgName);
            }

            $customer = BatteryCustomer::create([
                'customer_id' => $this->generateCustomerID(),
                'img_url' => $imgPath,
                'customer_name' => $request->input('customer_name'),
                'address_details' => $request->input('address_details'),
                'mobile' => $request->input('mobile'),
                'email' => $request->input('email'),
                'nid' => $request->input('nid'),
                'previous_due_amount' => $request->input('previous_due_amount') ?? 0,
                'district_id' => $request->input('district_id'),
                'user_id' => $user_id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => "Customer Created Successfully",
                'customer' => $customer
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    private function generateCustomerID()
    {
        $lastCustomer = BatteryCustomer::orderBy('id', 'desc')->first();
        $lastIdNumber = 0;

        if ($lastCustomer && $lastCustomer->customer_id) {
            if (preg_match('/(\d+)$/', $lastCustomer->customer_id, $matches)) {
                $lastIdNumber = (int) $matches[1];
            }
        }

        $newIdNumber = $lastIdNumber + 1;
        return 'BAT-CUST-' . str_pad($newIdNumber, 4, '0', STR_PAD_LEFT);
    }

    public function CustomerByID(Request $request)
    {
        try {
            $request->validate(["id" => 'required']);
            $rows = BatteryCustomer::where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function CustomerUpdate(Request $request)
    {
        try {
            $user_id = Auth::id();
            $customer = BatteryCustomer::find($request->input('id'));

            if (!$customer) {
                return response()->json(['status' => 'fail', 'message' => 'Customer not found.']);
            }

            $customer->customer_name = $request->input('customer_name') ?? $customer->customer_name;
            $customer->address_details = $request->input('address_details') ?? $customer->address_details;
            $customer->mobile = $request->input('mobile') ?? $customer->mobile;
            $customer->email = $request->input('email') ?? $customer->email;
            $customer->nid = $request->input('nid') ?? $customer->nid;
            $customer->previous_due_amount = $request->input('previous_due_amount') ?? $customer->previous_due_amount;
            $customer->district_id = $request->input('district_id') ?? $customer->district_id;

            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $imgName = time() . '-' . $user_id . '-' . $img->getClientOriginalName();
                $imgPath = "uploads/battery-customer-img/{$imgName}";
                $destination = public_path('uploads/battery-customer-img');
                if (!file_exists($destination)) {
                    @mkdir($destination, 0777, true);
                }
                $img->move($destination, $imgName);

                if ($customer->img_url && file_exists(public_path($customer->img_url))) {
                    @unlink(public_path($customer->img_url));
                }

                $customer->img_url = $imgPath;
            }

            $customer->save();

            return response()->json(['status' => 'success', 'message' => 'Customer updated successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function CustomerDelete(Request $request)
    {
        try {
            $request->validate(['id' => 'required']);
            $customer = BatteryCustomer::find($request->input('id'));

            if (!$customer) {
                return response()->json(['status' => 'fail', 'message' => 'Customer not found.']);
            }

            $hasOrders = DB::table('battery_orders')->where('customer_id', $customer->id)->exists();
            if ($hasOrders) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'এই কাস্টমারের ইনভয়েস রেকর্ড রয়েছে, তাই ডিলিট করা সম্ভব নয়।'
                ]);
            }

            if ($customer->img_url && file_exists(public_path($customer->img_url))) {
                @unlink(public_path($customer->img_url));
            }

            $customer->delete();

            return response()->json(['status' => 'success', 'message' => 'Customer deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function CustomerProfilePage($id)
    {
        return view('battery.customer.customer-profile', compact('id'));
    }

    public function CustomerProfileData($id)
    {
        try {
            $customer = BatteryCustomer::where(function ($q) use ($id) {
                if (is_numeric($id)) {
                    $q->where('id', $id);
                }
                $q->orWhere('customer_id', $id);
            })->first();

            if (!$customer) {
                return response()->json(['status' => 'fail', 'message' => 'Customer not found']);
            }

            // Sales Returns list for this battery customer
            $returns = DB::table('battery_product_returns')
                ->leftJoin('battery_orders', 'battery_product_returns.order_id', '=', 'battery_orders.id')
                ->leftJoin('battery_products', 'battery_product_returns.product_id', '=', 'battery_products.id')
                ->where('battery_product_returns.customer_id', $customer->id)
                ->select([
                    'battery_product_returns.id',
                    'battery_product_returns.amount',
                    'battery_product_returns.due_amount',
                    'battery_product_returns.quantity',
                    'battery_product_returns.date',
                    'battery_product_returns.created_at',
                    'battery_orders.id as db_order_id',
                    'battery_orders.order_no',
                    'battery_products.product_name'
                ])
                ->orderBy('battery_product_returns.created_at', 'desc')
                ->get()
                ->map(function ($r) {
                    return [
                        'id'                   => $r->id,
                        'order_no'             => $r->order_no ?? ('#InvID' . str_pad($r->db_order_id ?? 0, 5, '0', STR_PAD_LEFT)),
                        'product_name'         => $r->product_name ?? 'N/A',
                        'quantity'             => (int) ($r->quantity ?? 1),
                        'amount'               => (float) $r->amount,
                        'date'                 => $r->date ? Carbon::parse($r->date)->format('d-m-Y') : Carbon::parse($r->created_at)->format('d-m-Y'),
                        'created_at_formatted' => Carbon::parse($r->created_at)->format('d-m-Y h:i A')
                    ];
                });

            // Battery Orders / Invoices with accurate effective paid & due calculations
            $invoices = BatteryOrder::where('customer_id', $customer->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($order) {
                    $subTotal = (float) $order->sub_total;
                    $paidAmount = (float) $order->paid_amount;
                    $returnAdj = (float) ($order->return_adjustment_amount ?? 0);

                    $effectivePaid = $paidAmount + $returnAdj;
                    $dueAmount = max(0, $subTotal - $effectivePaid);
                    $paymentStatus = ($effectivePaid >= $subTotal && $subTotal > 0) ? 'Fully Paid' : ($effectivePaid > 0 ? 'Partial Paid' : 'Unpaid');

                    $order->due_amount = $dueAmount;
                    $order->return_adjustment_amount = $returnAdj;
                    $order->payment_status = $paymentStatus;
                    return $order;
                });

            // 1. Initial Invoice Payments (No Double Counting)
            $firstPaymentDetailIds = DB::table('battery_order_payment_details')
                ->join('battery_orders', 'battery_order_payment_details.order_id', '=', 'battery_orders.id')
                ->where('battery_orders.customer_id', $customer->id)
                ->groupBy('battery_order_payment_details.order_id')
                ->select(DB::raw('MIN(battery_order_payment_details.id) as first_id'))
                ->pluck('first_id');

            $initialInvoicePayments = DB::table('battery_order_payment_details')
                ->join('battery_orders', 'battery_order_payment_details.order_id', '=', 'battery_orders.id')
                ->whereIn('battery_order_payment_details.id', $firstPaymentDetailIds)
                ->where('battery_order_payment_details.paid_amount', '>', 0)
                ->select(
                    'battery_order_payment_details.paid_amount',
                    'battery_order_payment_details.discount_amount',
                    'battery_order_payment_details.payment_method',
                    'battery_order_payment_details.transaction_id',
                    'battery_order_payment_details.created_at',
                    'battery_orders.order_no as reference_no',
                    DB::raw('"Invoice Payment" as type')
                )
                ->get();

            // 2. Battery Customer Due Collection History
            $dueCollections = DB::table('battery_customer_payment_details')
                ->where('customer_id', $customer->id)
                ->where('paid_amount', '>', 0)
                ->select(
                    'paid_amount',
                    'discount_amount',
                    'payment_method',
                    'transaction_id',
                    'created_at',
                    DB::raw('"Due Collection" as reference_no'),
                    DB::raw('"Due Collection" as type')
                )
                ->get();

            // 3. Transactions unified and sorted
            $allTransactions = $initialInvoicePayments->concat($dueCollections)
                ->sortByDesc('created_at')
                ->values()
                ->map(function ($trx) {
                    $trx->created_at_formatted = Carbon::parse($trx->created_at)->format('d-m-Y h:i A');
                    return $trx;
                });

            // 4. Summary metrics
            $totalBilled = (float) $invoices->sum('sub_total');
            $totalInvoiceDue = (float) $invoices->sum('due_amount');
            $customerPreviousDue = (float) ($customer->previous_due_amount ?? 0);

            $totalReturnsAmount = (float) $returns->sum('amount');
            $totalReturnsAdjusted = (float) $invoices->sum('return_adjustment_amount');
            $availableCredit = max(0, $totalReturnsAmount - $totalReturnsAdjusted);

            $totalCurrentDue = max(0, $customerPreviousDue + $totalInvoiceDue - $availableCredit);

            $totalInitialPaid = (float) $initialInvoicePayments->sum('paid_amount');
            $totalDueCollected = (float) $dueCollections->sum('paid_amount');
            $totalPaidSum = $totalInitialPaid + $totalDueCollected;

            $summary = [
                'total_invoices'         => $invoices->count(),
                'total_billed'           => $totalBilled,
                'total_paid'             => $totalPaidSum,
                'total_returns'          => $totalReturnsAmount,
                'total_returns_adjusted' => $totalReturnsAdjusted,
                'available_credit'       => $availableCredit,
                'opening_due'            => $customerPreviousDue,
                'invoice_due'            => $totalInvoiceDue,
                'total_due'              => $totalCurrentDue,
            ];

            return response()->json([
                'status'       => 'success',
                'customer'     => $customer,
                'summary'      => $summary,
                'invoices'     => $invoices,
                'returns'      => $returns,
                'transactions' => $allTransactions
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
