<?php

namespace App\Http\Controllers\Battery;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Battery\BatterySupplier;
use App\Models\Battery\BatteryPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BatterySupplierController extends Controller
{
    public function SupplierList()
    {
        try {
            $SupplierData = BatterySupplier::all()->map(function($s) {
                $totalReturns = (float) DB::table('battery_purchase_returns')->where('supplier_id', $s->id)->sum('amount');
                $totalAdjusted = (float) DB::table('battery_purchases')->where('supplier_id', $s->id)->sum('return_adjustment_amount');
                $availableCredit = max(0, $totalReturns - $totalAdjusted);

                $s->return_credit_balance = round($availableCredit, 2);
                return $s;
            });
            return response()->json(['status' => 'success', 'SupplierData' => $SupplierData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function SupplierDueList()
    {
        try {
            $suppliers = BatterySupplier::orderBy('created_at', 'desc')->get();

            $dueAmounts = DB::table('battery_purchases')
                ->select('supplier_id', DB::raw('SUM(due_amount) as total_due_amount'))
                ->groupBy('supplier_id')
                ->pluck('total_due_amount', 'supplier_id');

            $SupplierData = $suppliers->map(function ($supplier) use ($dueAmounts) {
                return [
                    'id' => $supplier->id,
                    'supplier_id' => $supplier->supplier_id,
                    'name' => $supplier->name,
                    'company' => $supplier->company,
                    'purchase_payable_amount' => $supplier->purchase_payable_amount ?? 0,
                    'status' => $supplier->status,
                    'total_due_amount' => $dueAmounts[$supplier->id] ?? 0,
                ];
            })
            ->filter(function ($item) {
                $previousDue = (float) $item['purchase_payable_amount'];
                $currentDue  = (float) $item['total_due_amount'];
                return ($previousDue + $currentDue) > 0;
            })
            ->values();

            return response()->json(['status' => 'success', 'SupplierData' => $SupplierData]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function SupplierCreate(Request $request)
    {
        try {
            $user_id = Auth::id();

            $lastSupplier = BatterySupplier::latest('id')->first();
            $nextId = $lastSupplier ? intval(substr($lastSupplier->supplier_id, 8)) + 1 : 10001;
            $supplierId = 'BAT-SUP-' . $nextId;

            $newSupplier = BatterySupplier::create([
                'supplier_id' => $supplierId,
                'name' => $request->input('name'),
                'company' => $request->input('company'),
                'purchase_payable_amount' => $request->input('purchase_payable_amount') ?? 0,
                'mobile' => $request->input('mobile'),
                'address' => $request->input('address'),
                'user_id' => $user_id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Supplier Created Successfully',
                'supplier' => $newSupplier,
            ]);
        } catch (Exception $e) {
            Log::error('Battery Supplier Create Error: ' . $e->getMessage());
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function SupplierByID(Request $request)
    {
        try {
            $request->validate(["id" => 'required']);
            $rows = BatterySupplier::where('id', $request->input('id'))->first();
            return response()->json(['status' => 'success', 'rows' => $rows]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function SupplierUpdate(Request $request)
    {
        try {
            $user_id = Auth::id();
            $supplier = BatterySupplier::find($request->input('id'));

            if (!$supplier) {
                return response()->json(['status' => 'fail', 'message' => 'Supplier not found.']);
            }

            $supplier->name = $request->input('name');
            $supplier->company = $request->input('company');
            $supplier->purchase_payable_amount = $request->input('purchase_payable_amount') ?? $supplier->purchase_payable_amount;
            $supplier->mobile = $request->input('mobile') ?? $supplier->mobile;
            $supplier->address = $request->input('address') ?? $supplier->address;

            $supplier->save();

            return response()->json(['status' => 'success', 'message' => 'Supplier updated successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function SupplierDelete(Request $request)
    {
        try {
            $request->validate(['id' => 'required']);
            $supplier = BatterySupplier::find($request->input('id'));

            if (!$supplier) {
                return response()->json(['status' => 'fail', 'message' => 'Supplier not found.']);
            }

            $hasPurchases = DB::table('battery_purchases')->where('supplier_id', $supplier->id)->exists();
            if ($hasPurchases) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'এই সাপ্লাইয়ারের অধীনে পারচেজ রেকর্ড রয়েছে, তাই ডিলিট করা সম্ভব নয়।'
                ]);
            }

            $supplier->delete();

            return response()->json(['status' => 'success', 'message' => 'Supplier deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function SupplierProfilePage($id)
    {
        return view('battery.supplier.supplier-profile', compact('id'));
    }

    public function SupplierProfileData($id)
    {
        try {
            $supplier = BatterySupplier::where(function ($q) use ($id) {
                if (is_numeric($id)) {
                    $q->where('id', $id);
                }
                $q->orWhere('supplier_id', $id);
            })->first();

            if (!$supplier) {
                return response()->json(['status' => 'fail', 'message' => 'Supplier not found']);
            }

            $purchases = BatteryPurchase::with(['orderDetails.product', 'paymentDetails'])
                ->where('supplier_id', $supplier->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($purchase) {
                    $totalPaid = (float) $purchase->paymentDetails->sum('paid_amount');
                    $grandTotal = (float) ($purchase->grand_subtotal ?? 0);
                    $deliveryCharge = (float) ($purchase->delivery_charge ?? 0);
                    $discountAmount = (float) ($purchase->discount_amount ?? 0);
                    $returnAdj = (float) ($purchase->return_adjustment_amount ?? 0);

                    $effectiveGrandTotal = max(0, ($grandTotal - $discountAmount) + $deliveryCharge);
                    $effectivePaid = $totalPaid + $returnAdj;
                    $dueAmount = max(0, $effectiveGrandTotal - $effectivePaid);
                    $paymentStatus = ($effectivePaid >= $effectiveGrandTotal && $effectiveGrandTotal > 0) ? 'Fully Paid' : ($effectivePaid > 0 ? 'Partial Paid' : 'Unpaid');

                    $barcodes = $purchase->orderDetails->flatMap(function ($detail) {
                        if (!$detail->product || !$detail->product->product_code) return [];
                        $code = $detail->product->product_code;
                        $parsed = is_array($code) ? $code : (json_decode($code, true) ?? [$code]);
                        return is_array($parsed) ? $parsed : [$parsed];
                    })->filter()->unique()->values()->all();

                    return [
                        'id'                       => $purchase->id,
                        'purchase_id'              => $purchase->purchase_id,
                        'date'                     => $purchase->date ? \Carbon\Carbon::parse($purchase->date)->format('d-m-Y') : 'N/A',
                        'referance_no'             => $purchase->referance_no ?? 'No Reference',
                        'grand_subtotal'           => $grandTotal,
                        'delivery_charge'          => $deliveryCharge,
                        'discount_amount'          => $discountAmount,
                        'effective_grand_total'    => $effectiveGrandTotal,
                        'return_adjustment_amount' => $returnAdj,
                        'paid_amount'              => $totalPaid,
                        'due_amount'               => $dueAmount,
                        'payment_method'           => $purchase->paymentDetails->first()?->payment_method ?? 'N/A',
                        'payment_status'           => $paymentStatus,
                        'barcodes'                 => $barcodes,
                        'attach_document'          => $purchase->attach_document,
                    ];
                });

            // 1. Initial Purchase Payments (First PaymentDetail entry per purchase)
            $firstPaymentIds = DB::table('battery_purchase_payment_details')
                ->join('battery_purchases', 'battery_purchase_payment_details.purchases_id', '=', 'battery_purchases.id')
                ->where('battery_purchases.supplier_id', $supplier->id)
                ->groupBy('battery_purchase_payment_details.purchases_id')
                ->select(DB::raw('MIN(battery_purchase_payment_details.id) as first_id'))
                ->pluck('first_id');

            $initialPurchasePayments = DB::table('battery_purchase_payment_details')
                ->join('battery_purchases', 'battery_purchase_payment_details.purchases_id', '=', 'battery_purchases.id')
                ->whereIn('battery_purchase_payment_details.id', $firstPaymentIds)
                ->where('battery_purchase_payment_details.paid_amount', '>', 0)
                ->select(
                    'battery_purchase_payment_details.id',
                    'battery_purchase_payment_details.paid_amount',
                    'battery_purchase_payment_details.discount_amount',
                    'battery_purchase_payment_details.payment_method',
                    'battery_purchase_payment_details.payment_status',
                    'battery_purchase_payment_details.transaction_id',
                    'battery_purchase_payment_details.created_at',
                    'battery_purchases.purchase_id'
                )
                ->get();

            // 2. Battery Supplier Due Collections (battery_supplier_due_collections)
            $dueCollections = DB::table('battery_supplier_due_collections')
                ->where('supplier_id', $supplier->id)
                ->where('paid_amount', '>', 0)
                ->select(
                    'id',
                    'paid_amount',
                    'discount_amount',
                    'payment_method',
                    'transaction_id',
                    DB::raw('"Paid" as payment_status'),
                    'created_at',
                    DB::raw('"Due Collection" as purchase_id')
                )
                ->get();

            // 3. Battery Purchase Returns
            $returns = DB::table('battery_purchase_returns')
                ->leftJoin('battery_products', 'battery_purchase_returns.product_id', '=', 'battery_products.id')
                ->leftJoin('battery_purchases', 'battery_purchase_returns.purchase_id', '=', 'battery_purchases.id')
                ->where('battery_purchase_returns.supplier_id', $supplier->id)
                ->select(
                    'battery_purchase_returns.id',
                    'battery_purchase_returns.amount',
                    'battery_purchase_returns.due_amount',
                    'battery_purchase_returns.quantity',
                    'battery_purchase_returns.date',
                    'battery_purchase_returns.created_at',
                    'battery_products.product_name',
                    'battery_purchases.id as db_purchase_id',
                    'battery_purchases.purchase_id'
                )
                ->orderBy('battery_purchase_returns.created_at', 'desc')
                ->get()
                ->map(function ($r) {
                    $purNo = $r->purchase_id ? (str_starts_with($r->purchase_id, 'me-pur-') ? ('#PurID' . str_pad($r->db_purchase_id, 5, '0', STR_PAD_LEFT)) : $r->purchase_id) : ('#PurID' . str_pad($r->db_purchase_id ?? 0, 5, '0', STR_PAD_LEFT));
                    return [
                        'id'                   => $r->id,
                        'purchase_no'          => $purNo,
                        'product_name'         => $r->product_name ?? 'N/A',
                        'quantity'             => (int) ($r->quantity ?? 1),
                        'amount'               => (float) $r->amount,
                        'date'                 => $r->date ? \Carbon\Carbon::parse($r->date)->format('d-m-Y') : \Carbon\Carbon::parse($r->created_at)->format('d-m-Y'),
                        'created_at_formatted' => \Carbon\Carbon::parse($r->created_at)->format('d-m-Y h:i A')
                    ];
                });

            // Merge all transactions sorted by date
            $allTransactions = $initialPurchasePayments->concat($dueCollections)->sortByDesc('created_at')->values()->map(function ($trx) {
                $trx->created_at_formatted = \Carbon\Carbon::parse($trx->created_at)->format('d-m-Y h:i A');
                return $trx;
            });

            $totalPurchasesCount = $purchases->count();
            $totalPurchasesAmount = (float) $purchases->sum('grand_subtotal');
            $totalPurchaseDue = (float) $purchases->sum('due_amount');
            $supplierPreviousDue = (float) ($supplier->purchase_payable_amount ?? 0);
            $totalReturnsAmount = (float) $returns->sum('amount');
            $totalReturnsAdjusted = (float) $purchases->sum('return_adjustment_amount');
            $availableReturnCredit = max(0, $totalReturnsAmount - $totalReturnsAdjusted);

            $totalDueAmount = max(0, $supplierPreviousDue + $totalPurchaseDue - $availableReturnCredit);
            $totalPaidAmount = (float) $initialPurchasePayments->sum('paid_amount') + (float) $dueCollections->sum('paid_amount');

            return response()->json([
                'status'       => 'success',
                'supplier'     => $supplier,
                'summary'      => [
                    'total_purchases'        => $totalPurchasesCount,
                    'total_amount'           => $totalPurchasesAmount,
                    'total_paid'             => $totalPaidAmount,
                    'total_returns'          => $totalReturnsAmount,
                    'total_returns_adjusted' => $totalReturnsAdjusted,
                    'available_credit'       => $availableReturnCredit,
                    'total_due'              => $totalDueAmount,
                ],
                'purchases'    => $purchases,
                'returns'      => $returns,
                'transactions' => $allTransactions,
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
