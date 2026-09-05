<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\OrderPaymentDetails;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerPaymentDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class CustomerController extends Controller
{

// public function getCustomerInvoiceReport(Request $request)
// {
//     $customerId = $request->get('customer_id');  // This is a string (e.g., #MEC-2025-0149)
//     $startDate = Carbon::parse($request->get('start_date'));
//     $endDate = Carbon::parse($request->get('end_date'));

//     // Find the customer using 'customer_id' (string)
//     $customer = Order::where('customer_id', $customerId) ->
//     Customer::where('customer_id', $customerId)->first();

//     if (!$customer) {
//         return response()->json([
//             'status' => 'error',
//             'message' => 'Customer not found.'
//         ]);
//     }

//     // Fetch orders related to this customer within the given date range
//     $orderPaymentDetails = OrderPaymentDetails::whereHas('order', function ($query) use ($customer, $startDate, $endDate) {
//         $query->whereBetween('created_at', [$startDate, $endDate])
//               ->where('customer_id', $customer->id);  // Match with 'customers.id'
//     })
//     ->with('order.customer')
//     ->get();

//     return response()->json([
//         'status' => 'success',
//         'customer' => $customer,
//         'orderPaymentDetails' => $orderPaymentDetails,
//     ]);
// }


public function getCustomerInvoiceReport(Request $request)
{
    $customerUniqueId = $request->get('customer_id'); // e.g., #MEC-2025-0149
    $startDate = Carbon::parse($request->get('start_date'))->startOfDay();
    $endDate = Carbon::parse($request->get('end_date'))->endOfDay();

    // Find the customer by the string-based customer_id
    $customer = Customer::where('customer_id', $customerUniqueId)->first();

    if (!$customer) {
        return response()->json([
            'status' => 'error',
            'message' => 'Customer not found.'
        ]);
    }

    // Fetch order payment details within the date range for the customer
    $orderPaymentDetails = OrderPaymentDetails::whereHas('order', function ($query) use ($customer, $startDate, $endDate) {
        $query->where('customer_id', $customer->id)
              ->whereBetween('created_at', [$startDate, $endDate]);
    })
    ->with('order.customer') // eager load related customer through order
    ->latest()
    ->get();

    return response()->json([
        'status' => 'success',
        'customer' => $customer,
        'orderPaymentDetails' => $orderPaymentDetails,
    ]);
}

public function customerList()
{
    // Eager load only needed order fields
    $customers = Customer::with(['orders:id,customer_id,due_amount,created_at'])->latest()->get();

    $customerData = $customers->map(function ($customer) {
        // Sum the due amounts of all related orders
        $orderDueTotal = (float) $customer->orders->sum('due_amount');
        $remPrevDue = (float) ($customer->previous_due_amount ?? 0);

        // Computed effective total due
        $effectiveTotalDue = max(0, $remPrevDue + $orderDueTotal);

        $customer->total_due = round($effectiveTotalDue, 2);
        $customer->previous_due_amount = round($effectiveTotalDue, 2);

        $totalReturns = (float) DB::table('product_returns')->where('customer_id', $customer->id)->sum('amount');
        $totalAdjusted = Schema::hasColumn('orders', 'return_adjustment_amount')
            ? (float) DB::table('orders')->where('customer_id', $customer->id)->sum('return_adjustment_amount')
            : 0;
        $availableCredit = max(0, $totalReturns - $totalAdjusted);

        $customer->return_credit_balance = round($availableCredit, 2);

        // Optionally sort the customer's orders by latest
        $customer->orders = $customer->orders->sortByDesc('created_at')->values();

        return $customer;
    });

    return response()->json([
        'status' => 'success',
        'CustomerData' => $customerData
    ]);
}



// public function CustomerDueList()
// {
//     try {
//         $user_id = Auth::id();

//         // Get customers with orders and their due amounts
//         $CustomerData = Customer::with(['orders' => function ($query) {
//             $query->select('id', 'customer_id', 'due_amount');
//         }])
//         ->where(function ($q) {
//             $q->where('previous_due_amount', '>', 0)
//               ->orWhereHas('orders', function ($q2) {
//                   $q2->where('due_amount', '>', 0);
//               });
//         })
//         ->orderBy('created_at', 'desc')
//         ->get();

//         // Add total_due field: previous_due_amount + total order due_amount
//         $CustomerData = $CustomerData->map(function ($customer) {
//             $orderDue = $customer->orders->sum('due_amount');
//             $customer->total_due = $customer->previous_due_amount + $orderDue;
//             return $customer;
//         });

//         return response()->json([
//             'status' => 'success',
//             'CustomerData' => $CustomerData
//         ]);

//     } catch (\Exception $e) {
//         return response()->json([
//             'status' => 'fail',
//             'message' => $e->getMessage()
//         ]);
//     }
// }


public function CustomerDueList()
{
    try {
        $user_id = Auth::id();

        // Get customers with orders and their due amounts
        $CustomerData = Customer::with(['orders' => function ($query) {
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

        // Add calculated fields
        $CustomerData = $CustomerData->map(function ($customer) {
            $orderDue = $customer->orders->sum('due_amount');
            $customer->order_due_amount = $orderDue; // new field
            $customer->previous_due_amount = $customer->previous_due_amount ?? 0;
            $customer->total_due_amount = $customer->previous_due_amount + $orderDue; // new field
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

        $productImgPath = null;

        // Handle product image upload
        if ($request->hasFile('img')) {
            $productImg = $request->file('img');
            $productImgName = time() . '-' . $user_id . '-' . $productImg->getClientOriginalName();
            $productImgPath = "uploads/customer-img/{$productImgName}";
            $productImg->move(public_path('uploads/customer-img'), $productImgName);
        }

        // Create the CustomerData
        $CustomerID = Customer::create([
            'customer_id' => $this->generateCustomerID(),
            'img_url' => $productImgPath,
            'customer_name' => $request->input('customer_name'),
            'address_details' => $request->input('address_details'),
            'mobile' => $request->input('mobile'),
            'email' => $request->input('email'),
            'nid' => $request->input('nid'),
            'previous_due_amount' => $request->input('previous_due_amount'),
            'location_id' => $request->input('location_id'),
            'district_id' => $request->input('district_id'),
            'user_id' => $user_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => "Customer Created Successfully",
            'customer' => $CustomerID
        ]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}

private function generateCustomerID()
{
    $lastCustomer = Customer::orderBy('id', 'desc')->first();
    $lastIdNumber = 0;

    if ($lastCustomer && $lastCustomer->customer_id) {
        if (preg_match('/(\d+)$/', $lastCustomer->customer_id, $matches)) {
            $lastIdNumber = (int) $matches[1];
        }
    }

    $newIdNumber = $lastIdNumber + 1;
    return 'CUST-' . str_pad($newIdNumber, 4, '0', STR_PAD_LEFT);
}



function CustomerByID(Request $request){
    try {
        $user_id = Auth::id();
        $request->validate(["id" => 'required|string']);

        $rows = Customer ::where('id', $request->input('id'))->first();
        return response()->json(['status' => 'success', 'rows' => $rows]);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}




public function CustomerUpdate(Request $request)
{
    try {
        $user_id = Auth::id();

        // Fetch the customer data by ID
        $CustomerData_Update = Customer::find($request->input('id'));
        if (!$CustomerData_Update) {
            return response()->json(['status' => 'fail', 'message' => 'Customer not found.']);
        }
        // Update customer details
        $CustomerData_Update->customer_name = $request->input('customer_name');
        $CustomerData_Update->address_details = $request->input('address_details');
        $CustomerData_Update->mobile = $request->input('mobile');
        $CustomerData_Update->email = $request->input('email');
        $CustomerData_Update->nid = $request->input('nid');
        $CustomerData_Update->previous_due_amount = $request->input('previous_due_amount');
        $CustomerData_Update->district_id = $request->input('district_id');
        $CustomerData_Update->location_id = $request->input('location_id', null);
        // No need to set customer_id again, it's already set


        // Handle image upload if file is provided
        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$t}-{$file_name}";
            $img_url = "uploads/customer-img/{$img_name}";

            // Upload File
            $img->move(public_path('uploads/customer-img'), $img_name);

            // Delete old image if it exists
            if ($CustomerData_Update->img_url && file_exists(public_path($CustomerData_Update->img_url))) {
                unlink(public_path($CustomerData_Update->img_url));
            }

            $CustomerData_Update->img_url = $img_url; // Correct property to set img_url
        }

        // Save the customer and payment details
        $CustomerData_Update->save();

        return response()->json(['status' => 'success', 'message' => 'Customer updated successfully']);
    } catch (Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}



public function CustomerDelete(Request $request)
{
    DB::beginTransaction();
    try {
        // Validation
        $request->validate(['id' => 'required|string|min:1']);

        $customer_id = $request->input('id');
        $customer_delete = Customer::find($customer_id);

        if (!$customer_delete) {
            return response()->json(['status' => 'fail', 'message' => 'Customer not found.']);
        }

        // 1. Delete associated customer payment details
        if (Schema::hasTable('customer_payment_details')) {
            DB::table('customer_payment_details')->where('customer_id', $customer_id)->delete();
        }

        // 2. Delete product returns associated with customer
        if (Schema::hasTable('product_returns')) {
            DB::table('product_returns')->where('customer_id', $customer_id)->delete();
        }

        // 3. Fetch all orders belonging to this customer
        $orderIds = DB::table('orders')->where('customer_id', $customer_id)->pluck('id')->toArray();

        if (!empty($orderIds)) {
            // Delete order details
            if (Schema::hasTable('order_details')) {
                DB::table('order_details')->whereIn('order_id', $orderIds)->delete();
            }
            
            // Delete order payment details
            if (Schema::hasTable('order_payment_details')) {
                DB::table('order_payment_details')->whereIn('order_id', $orderIds)->delete();
            }

            // Delete product returns associated with orders
            if (Schema::hasTable('product_returns')) {
                DB::table('product_returns')->whereIn('order_id', $orderIds)->delete();
            }

            // Delete orders
            DB::table('orders')->whereIn('id', $orderIds)->delete();
        }

        // 4. Delete customer image if it exists
        if ($customer_delete->img_url && file_exists(public_path($customer_delete->img_url))) {
            @unlink(public_path($customer_delete->img_url));
        }

        // 5. Delete customer record
        $customer_delete->delete();

        DB::commit();

        return response()->json(['status' => 'success', 'message' => 'Customer deleted successfully']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}

// ১. ব্লেড ফাইল রিটার্ন করার জন্য
    public function CustomerProfilePage($id)
    {
        // কাস্টমারের আইডি ব্লেডে পাঠিয়ে দিচ্ছি, যাতে এপিআই কল করার সময় আইডিটা পাই
        return view('backend.customer.customer-profile', compact('id')); 
    }

    // ২. কাস্টমারের সমস্ত ডাটা এপিআই এর মাধ্যমে পাঠানোর জন্য
   public function CustomerProfileData(Request $request, $id)
{
    try {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['status' => 'fail', 'message' => 'Customer not found']);
        }

        // Sales Returns list for this customer
        $selectCols = [
            'product_returns.id',
            'product_returns.amount',
            'product_returns.due_amount',
            'product_returns.date',
            'product_returns.created_at',
            'orders.id as db_order_id',
            'orders.order_no'
        ];

        if (Schema::hasColumn('product_returns', 'quantity')) {
            $selectCols[] = 'product_returns.quantity';
        }
        if (Schema::hasColumn('product_returns', 'product_id')) {
            $selectCols[] = 'products.product_name';
        }

        $returnsQuery = DB::table('product_returns')
            ->leftJoin('orders', 'product_returns.order_id', '=', 'orders.id');

        if (Schema::hasColumn('product_returns', 'product_id')) {
            $returnsQuery->leftJoin('products', 'product_returns.product_id', '=', 'products.id');
        }

        $returns = $returnsQuery->where('product_returns.customer_id', $id)
            ->select($selectCols)
            ->orderBy('product_returns.created_at', 'desc')
            ->get()
            ->map(function($r) {
                return [
                    'id'                   => $r->id,
                    'order_no'             => $r->order_no ?? ('#InvID' . str_pad($r->db_order_id ?? 0, 5, '0', STR_PAD_LEFT)),
                    'product_name'         => $r->product_name ?? 'N/A',
                    'quantity'             => (int) ($r->quantity ?? 1),
                    'amount'               => (float) $r->amount,
                    'date'                 => $r->date ? \Carbon\Carbon::parse($r->date)->format('d-m-Y') : \Carbon\Carbon::parse($r->created_at)->format('d-m-Y'),
                    'created_at_formatted' => \Carbon\Carbon::parse($r->created_at)->format('d-m-Y h:i A')
                ];
            });

        // Invoices with accurate effective paid & due calculations
        $invoices = Order::where('customer_id', $id)
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ->map(function($order) {
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

        // ১. ইনভয়েসের প্রথম পেমেন্ট (Initial Checkout Payments - No Double Counting)
        $firstPaymentDetailIds = DB::table('order_payment_details')
            ->join('orders', 'order_payment_details.order_id', '=', 'orders.id')
            ->where('orders.customer_id', $id)
            ->groupBy('order_payment_details.order_id')
            ->select(DB::raw('MIN(order_payment_details.id) as first_id'))
            ->pluck('first_id');

        $initialInvoicePayments = DB::table('order_payment_details')
            ->join('orders', 'order_payment_details.order_id', '=', 'orders.id')
            ->whereIn('order_payment_details.id', $firstPaymentDetailIds)
            ->where('order_payment_details.paid_amount', '>', 0)
            ->select(
                'order_payment_details.paid_amount', 
                'order_payment_details.discount_amount',
                'order_payment_details.payment_method', 
                'order_payment_details.transaction_id', 
                'order_payment_details.created_at', 
                'orders.order_no as reference_no',
                DB::raw('"Invoice Payment" as type')
            )
            ->get();

        // ২. কাস্টমারের সমস্ত বকেয়া কালেকশন হিস্ট্রি (customer_payment_details)
        $dueCollections = DB::table('customer_payment_details')
            ->where('customer_id', $id)
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

        // ৩. পেমেন্ট সমুহ একত্রিত করে ক্রমানুসারে সাজানো
        $allTransactions = $initialInvoicePayments->concat($dueCollections)
            ->sortByDesc('created_at')
            ->values();

        // ৪. সঠিক ও নিখুঁত সামারি ক্যালকুলেশন
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

    } catch (\Exception $e) {
        return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    }
}



}
