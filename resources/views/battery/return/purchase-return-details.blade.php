@extends('layouts.dashboard-sidenav')
@section('title', isset($purchase) ? 'Purchase Product Return Page' : 'Battery Purchase Return Details - MARSS CORPORATION')

@section('topbar_back_button')
  <a href="javascript:void(0)" onclick="if(window.history.length > 1 && document.referrer && document.referrer !== window.location.href){ window.history.back(); } else { window.location.href = '{{ route('battery.purchases') }}'; }" class="topbar-back-btn" title="Back">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back</span>
  </a>
@endsection

@section('content')

@if(isset($purchase))
    {{-- ═════════════════════════════════════════════════════════════════
         INTERACTIVE PURCHASE RETURN INVOICE (MATCHING RETAIL SCREENSHOT)
         ═════════════════════════════════════════════════════════════════ --}}
    <!-- Hero Main Content Start -->
    <div class="main-content">
        <div class="page-content">
            <div class="invoice-container">

                <div class="billing-section">
                    <div class="wrapper">
                        <div class="billing-to">
                            <h3><strong>Supplier Details</strong></h3>
                            <p>
                                <strong id="SupplierName">{{ $purchase->supplier->name ?? $purchase->supplier->company ?? 'N/A' }}</strong>
                            </p>
                            <p id="SupplierAddress">{{ $purchase->supplier->address ?? '' }}</p>
                            <p>Phone: <span id="SupplierMobile">{{ $purchase->supplier->mobile ?? 'N/A' }}</span></p>
                        </div>

                        <div class="invoice-wrapper">
                            <table>
                                <tr>
                                    <td class="number">Purchase Ref No:</td>
                                    <td id="referance_no">{{ $purchase->referance_no ?? $purchase->purchase_id ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="date">Purchase Date:</td>
                                    <td id="purchase_date">{{ $purchase->date ? \Carbon\Carbon::parse($purchase->date)->format('d-m-Y') : \Carbon\Carbon::parse($purchase->created_at)->format('d-m-Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="logo-wrapper">
                        <h2><strong>Purchase Return</strong></h2>
                        <img src="{{ asset('backend/assets/icons/marss-corporation-logo.svg') }}" alt="MARSS CORPORATION Logo" style="max-height: 48px;" />
                        <div class="button">
                            <button class="print-icon" onclick="ReturnPurchaseSave(event)" style="cursor: pointer;">
                                <span class="text p-4">Return</span>
                            </button>
                        </div>
                    </div>

                    <strong style="display: none" id="PurchaseID">{{ $purchase->id ?? 'N/A' }}</strong><br />
                    <strong style="display: none" id="SupplierID">{{ $purchase->supplier->id ?? 'N/A' }}</strong><br />

                    <div class="shop-details">
                        <h3>
                            <strong>MARSS CORPORATION</strong>
                        </h3>
                        <div class="contact" style="display: flex; gap: 4px">
                            <p>Cell:</p>
                            <p>
                                <span>01975-703216</span>,
                                <span>01715-842083</span>
                            </p>
                        </div>
                        <p>Success Super Market,</p>
                        <p>Sadar Police Fari, Ataikula Road Pabna</p>
                        <p>marsscorporation2018@gmail.com</p>
                    </div>
                </div>

                <!-- Table Section -->
                <table class="invoice_table_list">
                    <thead>
                        <tr>
                            <th>SL. No.</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Return Quantity</th>
                            <th>Return</th>
                        </tr>
                    </thead>
                    <tbody id="purchase_order_details">
                        @if ($purchase->orderDetails && $purchase->orderDetails->isNotEmpty())
                            @foreach ($purchase->orderDetails as $key => $detail)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $detail->product->product_name ?? $detail->product->name ?? 'N/A' }}</td>
                                    <td>{{ $detail->quantity ?? 'N/A' }}</td>
                                    <td>৳{{ number_format($detail->cost_price) }}</td>
                                    <td>
                                        <input type="number" class="return-quantity" name="return_quantity[]"
                                            min="1" max="{{ $detail->quantity }}" value="1"
                                            data-product-id="{{ $detail->product_id }}"
                                            data-order-detail-id="{{ $detail->id }}"
                                            style="width: 70px; text-align: center; border: 1px solid #cbd5e1; border-radius: 6px; padding: 3px 6px;">
                                    </td>
                                    <td>
                                        <span class="checkbox">
                                            <input type="checkbox" class="return-checkbox" name="return_product[]"
                                                value="{{ $detail->id }}" style="width: 18px; height: 18px; cursor: pointer;">
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center py-4 text-slate-400">No products available for return.</td>
                            </tr>
                        @endif

                        <tr>
                            <td colspan="3" rowspan="4" id="payment_status" class="full-paid" style="vertical-align: middle; text-align: center; font-weight: bold;">
                                @if ($dueAmount <= 0)
                                    Fully Paid
                                @elseif($paidAmount > 0)
                                    Partial Paid
                                @else
                                    Unpaid
                                @endif
                            </td>
                            <td colspan="2" class="amount_text"><span>Sub Total:</span></td>
                            <td colspan="2" class="amount"><span id="sub_total">৳{{ number_format($subTotal) }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="amount_text"><span>Paid Amount:</span></td>
                            <td colspan="2" class="amount"><span id="paidamount">৳{{ number_format($paidAmount) }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="amount_text"><span>Due Amount:</span></td>
                            <td colspan="2" class="amount"><span>৳{{ number_format($dueAmount) }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="amount_text">Total Payable Amount:</td>
                            <td id="total_payable_amount" class="amount">৳{{ number_format($totalPayableAmount) }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Footer Message -->
                <div class="footer-message">
                    <p>
                        <strong style="border-bottom: 1px solid gray; font-size: 12px; font-weight: 800;">TERMS AND CONDITIONS</strong>
                    </p>
                    <p class="google-text">
                        Purchased goods can only be returned within 3 days of delivery with proper documentation.
                    </p>
                    <p class="google-text">
                        Damaged or used goods will not be accepted for return.
                    </p>
                    <p>
                        Developed By <a href="https://codenextit.com" target="_blank" style="color:inherit;">CodeNext IT</a> - <a href="https://codenextit.com" target="_blank" style="color:inherit;">www.codenextit.com</a> (+08801788428280)
                    </p>
                </div>
            </div>
            <div class="copyright">
                <footer class="footer text-center py-3 mt-4 text-muted small border-top">&copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-success fw-bold text-decoration-none">CodeNext IT</a></footer>
            </div>
        </div>
    </div>
    <!-- Hero Main Content End -->

    <script>
        async function ReturnPurchaseSave(event) {
            event.preventDefault();

            try {
                const selectedProducts = document.querySelectorAll('.return-checkbox:checked');
                if (selectedProducts.length === 0) {
                    alert('Please select at least one product to return.');
                    return;
                }

                const PurchaseID = document.getElementById('PurchaseID').innerText.trim();
                const purchase_date = document.getElementById('purchase_date').innerText.trim();
                const SupplierID = document.getElementById('SupplierID').innerText.trim();

                let returnData = [];

                selectedProducts.forEach(checkbox => {
                    let row = checkbox.closest('tr');
                    let quantityInput = row.querySelector('.return-quantity');

                    let orderDetailId = checkbox.value;
                    let productId = quantityInput.dataset.productId;
                    let returnQty = parseInt(quantityInput.value);

                    returnData.push({
                        purchase_order_detail_id: orderDetailId,
                        product_id: productId,
                        quantity: returnQty
                    });
                });

                let payload = {
                    purchase_id: PurchaseID,
                    date: purchase_date,
                    supplier_id: SupplierID,
                    products: returnData
                };

                if (typeof showLoader === 'function') showLoader();
                const res = await axios.post("/api/battery/create-purchase-return", payload, HeaderToken());
                if (typeof hideLoader === 'function') hideLoader();

                if (res.data.status === "success") {
                    if (typeof successToast === 'function') {
                        successToast(res.data.message || 'Purchase Return Processed Successfully');
                    } else {
                        alert(res.data.message || 'Purchase Return Processed Successfully');
                    }
                    setTimeout(() => {
                        window.location.href = "{{ route('battery.purchases') }}";
                    }, 1000);
                } else {
                    if (typeof errorToast === 'function') {
                        errorToast(res.data.message || 'Failed to process return');
                    } else {
                        alert(res.data.message || 'Failed to process return');
                    }
                }
            } catch (e) {
                if (typeof hideLoader === 'function') hideLoader();
                console.error(e);
                if (typeof errorToast === 'function') {
                    errorToast(e.response?.data?.message || 'An error occurred while processing your request.');
                } else {
                    alert(e.response?.data?.message || 'An error occurred while processing your request.');
                }
            }
        }
    </script>
@else
    {{-- Fallback voucher view if a single BatteryPurchaseReturn record was passed --}}
    <!-- Main Content Start -->
    <div class="main-content">
        <div class="page-content min-h-[calc(100vh-70px)] flex flex-col justify-between">
            <div class="data-table flex-grow">
                
                <div class="no-print flex items-center justify-between mb-4 flex-wrap gap-2">
                    <a href="{{ route('battery.purchases') }}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-200 text-xs font-semibold rounded-xl border border-slate-300 dark:border-slate-700 transition-all shadow-sm">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Back to Purchases</span>
                    </a>
                    <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-4 h-[38px] bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm transition-all">
                        <i class="fa-solid fa-print"></i>
                        <span>Print Return Voucher</span>
                    </button>
                </div>

                <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-6 p-6 sm:p-8 max-w-4xl mx-auto print:shadow-none print:border-none print:p-0">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between border-b border-slate-200 dark:border-slate-800 pb-5 mb-6 gap-4">
                        <div class="flex items-start gap-3">
                            <img src="{{ asset('backend/assets/icons/marss-corporation-logo.svg') }}" alt="MARSS Corporation Logo" style="height: 48px; width: auto; object-fit: contain;" />
                            <div>
                                <h2 class="text-xl font-black text-emerald-700 dark:text-emerald-400 m-0 tracking-tight leading-tight">
                                    <span class="text-rose-600">MARSS</span> CORPORATION
                                </h2>
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 m-0">Battery Division • Supplier Stock Return Voucher</p>
                                <p class="text-[11px] text-slate-400 dark:text-slate-500 m-0">Success Super Market, Sadar Police Fari, Pabna</p>
                            </div>
                        </div>
                        <div class="text-right sm:text-right">
                            <span class="inline-block px-3 py-1 bg-amber-50 text-amber-700 dark:bg-amber-950/50 dark:text-amber-300 text-xs font-black uppercase tracking-wider rounded-lg border border-amber-200 dark:border-amber-900 mb-1">
                                Purchase Return Voucher
                            </span>
                            <div class="text-xs font-mono font-bold text-slate-700 dark:text-slate-300">
                                Voucher #PR-{{ str_pad($purchaseReturn->id, 5, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="text-[11px] text-slate-500 dark:text-slate-400">
                                Date: {{ \Carbon\Carbon::parse($purchaseReturn->date ?? $purchaseReturn->created_at)->format('d-m-Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 bg-slate-50 dark:bg-slate-800/40 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Supplier Information</span>
                            <h4 class="text-sm font-bold text-slate-800 dark:text-white m-0">
                                {{ $purchaseReturn->supplier->name ?? $purchaseReturn->supplier->company ?? 'Supplier' }}
                            </h4>
                            <p class="text-xs text-slate-600 dark:text-slate-300 m-0">
                                {{ $purchaseReturn->supplier->address ?? 'Tejgaon I/A, Dhaka' }}
                            </p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 m-0">
                                Phone: <span class="font-mono">{{ $purchaseReturn->supplier->mobile ?? 'N/A' }}</span>
                            </p>
                        </div>
                        <div class="sm:border-l sm:border-slate-200 dark:sm:border-slate-700 sm:pl-4">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Original Purchase Reference</span>
                            <div class="flex items-center gap-2 mb-0.5">
                                <span class="text-xs text-slate-500">Purchase Ref:</span>
                                <span class="text-xs font-mono font-bold text-emerald-700 dark:text-emerald-400">
                                    {{ $purchaseReturn->purchase->referance_no ?? $purchaseReturn->purchase->purchase_id ?? ('#PurID' . str_pad($purchaseReturn->purchase_id, 5, '0', STR_PAD_LEFT)) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden mb-6">
                        <table class="w-full text-xs text-left">
                            <thead class="bg-[#15803d] text-white font-bold uppercase text-[11px]">
                                <tr>
                                    <th class="p-3 text-center">#</th>
                                    <th class="p-3">Returned Battery Product</th>
                                    <th class="p-3 text-center">Return Qty</th>
                                    <th class="p-3 text-end">Credit Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-slate-100 dark:border-slate-800">
                                    <td class="p-3 text-center font-bold text-slate-500">1</td>
                                    <td class="p-3 font-bold text-slate-800 dark:text-white">
                                        {{ $purchaseReturn->product->product_name ?? 'Product' }}
                                    </td>
                                    <td class="p-3 text-center font-bold text-emerald-700 dark:text-emerald-400">
                                        {{ (int)($purchaseReturn->quantity ?? 1) }} pcs
                                    </td>
                                    <td class="p-3 text-end font-bold text-slate-800 dark:text-white">
                                        ৳ {{ number_format((float)$purchaseReturn->amount, 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection
