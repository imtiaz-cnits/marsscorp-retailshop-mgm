@extends('layouts.dashboard-sidenav')
@section('title', 'Invoice Page')
@section('content')

<style>
    /* Full Height & Sticky Layout with Equal Top Bar Gap */
    html, body {
        min-height: 100vh !important;
    }
    .main-content {
        min-height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
    }
    .invoice-page-content {
        min-height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
        flex-grow: 1 !important;
        padding: calc(70px + 20px) 20px 0 20px !important;
        box-sizing: border-box !important;
    }
    .invoice-container {
        flex-grow: 1 !important;
        margin-bottom: 24px !important;
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #cbd5e1;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    body[light-mode="dark"] .invoice-container,
    html[light-mode="dark"] .invoice-container,
    body[data-layout-mode="dark"] .invoice-container,
    html.dark .invoice-container,
    body.dark .invoice-container,
    body.dark-mode .invoice-container,
    [data-theme="dark"] .invoice-container {
        background: #0f172a !important;
        border-color: #334155 !important;
    }

    /* 3 Equal Header Columns */
    .invoice-header-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 20px;
        align-items: start;
        padding-bottom: 20px;
        margin-bottom: 20px;
        border-bottom: 1px solid #cbd5e1;
    }
    body[light-mode="dark"] .invoice-header-grid,
    html[light-mode="dark"] .invoice-header-grid,
    body[data-layout-mode="dark"] .invoice-header-grid,
    html.dark .invoice-header-grid,
    body.dark .invoice-header-grid,
    body.dark-mode .invoice-header-grid,
    [data-theme="dark"] .invoice-header-grid {
        border-bottom-color: #334155 !important;
    }

    .billed-to-details {
        text-align: left !important;
    }
    .company-details {
        text-align: right !important;
    }

    /* Meta Table (Invoice No / Date) */
    .invoice-meta-table {
        width: 100% !important;
        max-width: 220px !important;
        border-collapse: collapse !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        overflow: hidden !important;
        margin-top: 6px !important;
    }
    .invoice-meta-table tr,
    .invoice-meta-table td {
        border: 1px solid #cbd5e1 !important;
    }
    body[light-mode="dark"] .invoice-meta-table,
    body[light-mode="dark"] .invoice-meta-table tr,
    body[light-mode="dark"] .invoice-meta-table td,
    html[light-mode="dark"] .invoice-meta-table,
    html[light-mode="dark"] .invoice-meta-table tr,
    html[light-mode="dark"] .invoice-meta-table td,
    body[data-layout-mode="dark"] .invoice-meta-table,
    body[data-layout-mode="dark"] .invoice-meta-table tr,
    body[data-layout-mode="dark"] .invoice-meta-table td,
    html.dark .invoice-meta-table,
    html.dark .invoice-meta-table tr,
    html.dark .invoice-meta-table td,
    body.dark .invoice-meta-table,
    body.dark .invoice-meta-table tr,
    body.dark .invoice-meta-table td,
    body.dark-mode .invoice-meta-table,
    body.dark-mode .invoice-meta-table tr,
    body.dark-mode .invoice-meta-table td,
    [data-theme="dark"] .invoice-meta-table,
    [data-theme="dark"] .invoice-meta-table tr,
    [data-theme="dark"] .invoice-meta-table td {
        border-color: #334155 !important;
    }

    /* Main Invoice Table Styles for Light & Dark Mode */
    .invoice-container .invoice_table_list {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-top: 16px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        overflow: hidden !important;
    }
    .invoice-container .invoice_table_list th {
        background-color: #f1f5f9 !important;
        color: #1e293b !important;
        font-weight: 700 !important;
        font-size: 13.5px !important;
        border: 1px solid #cbd5e1 !important;
        padding: 9px 12px !important;
        text-align: center !important;
    }
    .invoice-container .invoice_table_list td {
        border: 1px solid #cbd5e1 !important;
        color: #334155 !important;
        font-size: 13px !important;
        padding: 8px 12px !important;
        background-color: #ffffff !important;
    }
    .invoice-container .invoice_table_list .amount_text {
        font-weight: 600 !important;
    }
    .invoice-container .invoice_table_list .amount {
        font-weight: 700 !important;
    }
    .invoice-container .invoice_table_list .table_bg {
        background-color: #f8fafc !important;
    }
    .invoice-container .full-paid {
        font-weight: 800 !important;
        font-size: 18px !important;
        text-align: center !important;
        color: #15803d !important;
        background-color: #f0fdf4 !important;
    }

    /* Dark Mode Table Colors & Borders */
    body[light-mode="dark"] .invoice-container .invoice_table_list,
    html[light-mode="dark"] .invoice-container .invoice_table_list,
    body[data-layout-mode="dark"] .invoice-container .invoice_table_list,
    html.dark .invoice-container .invoice_table_list,
    body.dark .invoice-container .invoice_table_list,
    body.dark-mode .invoice-container .invoice_table_list,
    [data-theme="dark"] .invoice-container .invoice_table_list {
        border-color: #334155 !important;
    }

    body[light-mode="dark"] .invoice-container .invoice_table_list th,
    html[light-mode="dark"] .invoice-container .invoice_table_list th,
    body[data-layout-mode="dark"] .invoice-container .invoice_table_list th,
    html.dark .invoice-container .invoice_table_list th,
    body.dark .invoice-container .invoice_table_list th,
    body.dark-mode .invoice-container .invoice_table_list th,
    [data-theme="dark"] .invoice-container .invoice_table_list th {
        background-color: #1e293b !important;
        color: #f8fafc !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] .invoice-container .invoice_table_list td,
    html[light-mode="dark"] .invoice-container .invoice_table_list td,
    body[data-layout-mode="dark"] .invoice-container .invoice_table_list td,
    html.dark .invoice-container .invoice_table_list td,
    body.dark .invoice-container .invoice_table_list td,
    body.dark-mode .invoice-container .invoice_table_list td,
    [data-theme="dark"] .invoice-container .invoice_table_list td {
        background-color: #0f172a !important;
        color: #f8fafc !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] .invoice-container .invoice_table_list .table_bg,
    html[light-mode="dark"] .invoice-container .invoice_table_list .table_bg,
    body[data-layout-mode="dark"] .invoice-container .invoice_table_list .table_bg,
    html.dark .invoice-container .invoice_table_list .table_bg,
    body.dark .invoice-container .invoice_table_list .table_bg,
    body.dark-mode .invoice-container .invoice_table_list .table_bg,
    [data-theme="dark"] .invoice-container .invoice_table_list .table_bg {
        background-color: #1e293b !important;
        color: #f8fafc !important;
    }

    body[light-mode="dark"] .invoice-container .full-paid,
    html[light-mode="dark"] .invoice-container .full-paid,
    body[data-layout-mode="dark"] .invoice-container .full-paid,
    html.dark .invoice-container .full-paid,
    body.dark .invoice-container .full-paid,
    body.dark-mode .invoice-container .full-paid,
    [data-theme="dark"] .invoice-container .full-paid {
        background-color: #1e293b !important;
        color: #34d399 !important;
        border-color: #334155 !important;
    }

    /* Footer Message Styled Matching Table Border */
    .invoice-container .footer-message {
        margin-top: 14px !important;
        padding: 8px 12px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        text-align: left !important;
        color: #64748b !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        background-color: transparent !important;
    }
    .invoice-container .footer-message p {
        color: inherit !important;
        font-size: 13px !important;
        margin: 0 !important;
        text-align: left !important;
    }

    body[light-mode="dark"] .invoice-container .footer-message,
    html[light-mode="dark"] .invoice-container .footer-message,
    body[data-layout-mode="dark"] .invoice-container .footer-message,
    html.dark .invoice-container .footer-message,
    body.dark .invoice-container .footer-message,
    body.dark-mode .invoice-container .footer-message,
    [data-theme="dark"] .invoice-container .footer-message {
        border-color: #334155 !important;
        color: #ffffff !important;
        background-color: #0f172a !important;
    }
    body[light-mode="dark"] .invoice-container .footer-message p,
    html[light-mode="dark"] .invoice-container .footer-message p,
    body[data-layout-mode="dark"] .invoice-container .footer-message p,
    html.dark .invoice-container .footer-message p,
    body.dark .invoice-container .footer-message p,
    body.dark-mode .invoice-container .footer-message p,
    [data-theme="dark"] .invoice-container .footer-message p {
        color: #ffffff !important;
    }

    @media (max-width: 768px) {
        .invoice-header-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        .billed-to-details,
        .company-details {
            text-align: left !important;
        }
    }

    /* Print Styles: Full Width A4 Paper Output */
    @media print {
        @page {
            size: A4 portrait;
            margin: 8mm 10mm;
        }
        html, body {
            width: 100% !important;
            height: auto !important;
            min-height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #ffffff !important;
            color: #000000 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        #layout-wrapper,
        .main-content,
        .page-content,
        .invoice-page-content {
            position: static !important;
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            min-height: auto !important;
            display: block !important;
            float: none !important;
            left: 0 !important;
            right: 0 !important;
        }
        .vertical-menu,
        .navbar-header,
        #page-topbar,
        .navbar-brand-box,
        .sidebar-menu,
        .sidebar,
        .print-button,
        .copyright,
        .footer {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }
        .invoice-container {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 100% !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
            background: #ffffff !important;
        }
        .invoice-header-grid {
            display: grid !important;
            grid-template-columns: 1fr 1fr 1fr !important;
            width: 100% !important;
            gap: 15px !important;
            border-bottom: 1px solid #cbd5e1 !important;
            padding-bottom: 12px !important;
            margin-bottom: 14px !important;
            align-items: start !important;
        }
        .billed-to-details {
            text-align: left !important;
            width: 100% !important;
            color: #000000 !important;
        }
        .billed-to-details * {
            text-align: left !important;
            color: #000000 !important;
        }
        .invoice-meta-table {
            width: 100% !important;
            max-width: 220px !important;
            border-collapse: collapse !important;
            border: 1px solid #cbd5e1 !important;
            margin-top: 6px !important;
        }
        .invoice-meta-table tr,
        .invoice-meta-table td {
            border: 1px solid #cbd5e1 !important;
            color: #000000 !important;
            padding: 3px 6px !important;
            font-size: 11px !important;
            background: #ffffff !important;
        }
        .logo-wrapper {
            text-align: center !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
        }
        .logo-wrapper img {
            max-height: 48px !important;
            max-width: 180px !important;
            width: auto !important;
            display: block !important;
            margin: 0 auto 6px auto !important;
        }
        .company-details {
            text-align: right !important;
            width: 100% !important;
            color: #000000 !important;
        }
        .company-details p {
            text-align: right !important;
            color: #000000 !important;
            font-size: 11px !important;
            line-height: 1.4 !important;
            margin-bottom: 2px !important;
            white-space: normal !important;
        }
        .invoice_table_list {
            width: 100% !important;
            border-collapse: collapse !important;
            border: 1px solid #cbd5e1 !important;
            margin-top: 10px !important;
        }
        .invoice_table_list th {
            background-color: #f1f5f9 !important;
            color: #000000 !important;
            border: 1px solid #cbd5e1 !important;
            padding: 6px 8px !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            text-align: center !important;
        }
        .invoice_table_list td {
            background-color: #ffffff !important;
            color: #000000 !important;
            border: 1px solid #cbd5e1 !important;
            padding: 6px 8px !important;
            font-size: 12px !important;
        }
        .invoice_table_list .amount_text {
            text-align: right !important;
            font-weight: 600 !important;
        }
        .invoice_table_list .amount {
            text-align: right !important;
            font-weight: 700 !important;
        }
        .full-paid {
            color: #000000 !important;
            background-color: #ffffff !important;
            text-align: center !important;
            font-weight: 800 !important;
            font-size: 16px !important;
        }
        .invoice-container .footer-message {
            width: 100% !important;
            border: 1px solid #cbd5e1 !important;
            color: #000000 !important;
            margin-top: 12px !important;
            padding: 6px 10px !important;
            text-align: left !important;
            font-size: 11px !important;
            box-sizing: border-box !important;
            background: #ffffff !important;
        }
        .invoice-container .footer-message p {
            color: #000000 !important;
            margin: 0 !important;
            text-align: left !important;
        }
    }
</style>

<div class="main-content min-h-screen flex flex-col justify-between">
    <div class="page-content invoice-page-content flex-grow flex flex-col justify-between">
        <div class="invoice-container">
            <!-- 3-Column Equal Top Header: Left (Billed To), Center (Logo & Title), Right (Company Info) -->
            <div class="invoice-header-grid">
                <!-- 1. Left Column: Billed To Details & Invoice Meta -->
                <div class="billed-to-details">
                    <h4 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider mb-1">Billed To</h4>
                    <p class="font-bold text-slate-800 dark:text-slate-100 text-sm mb-0.5" id="SupplierName">{{ $purchaseinvoicedata->supplier->name ?? 'N/A' }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-0.5" id="SupplierAddress">{{ $purchaseinvoicedata->supplier->address ?? 'N/A' }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-2">Phone: <span class="font-semibold text-slate-700 dark:text-slate-300" id="SupplierMobile">{{ $purchaseinvoicedata->supplier->mobile ?? 'N/A' }}</span></p>

                    <table class="invoice-meta-table text-xs">
                        <tr>
                            <td class="p-1.5 px-2 bg-slate-50 dark:bg-slate-800 font-semibold text-slate-600 dark:text-slate-300">Invoice No:</td>
                            <td class="p-1.5 px-2 font-bold text-emerald-700 dark:text-emerald-400 font-mono" id="order_no">{{ $purchaseinvoicedata->purchase_id }}</td>
                        </tr>
                        <tr>
                            <td class="p-1.5 px-2 bg-slate-50 dark:bg-slate-800 font-semibold text-slate-600 dark:text-slate-300">Invoice Date:</td>
                            <td class="p-1.5 px-2 font-medium text-slate-700 dark:text-slate-300" id="invoice_date">{{ \Carbon\Carbon::parse($purchaseinvoicedata->created_at)->format('d-m-Y') }}</td>
                        </tr>
                    </table>
                </div>

                <!-- 2. Center Column: Purchase Details Title, Logo & Print Button -->
                <div class="logo-wrapper text-center flex flex-col items-center justify-center">
                    <h2 class="text-base sm:text-lg font-bold text-slate-800 dark:text-white mb-2 tracking-tight">Purchase Details</h2>
                    <img src="{{ asset('backend/assets/img/marss-corporation-icon2.svg') }}" onerror="this.src='{{ asset('backend/assets/icons/marss-corporation-logo.svg') }}'" alt="MARSS Corporation Logo" class="mb-2" style="max-height: 48px; max-width: 180px; object-fit: contain;" />
                    <button type="button" class="print-button inline-flex items-center gap-1.5 px-4 py-1.5 bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-150 border-0 cursor-pointer" onclick="window.print()">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                            <rect x="6" y="14" width="12" height="8"></rect>
                        </svg>
                        <span>Print</span>
                    </button>
                </div>

                <!-- 3. Right Column: Company Official Information -->
                <div class="company-details text-left md:text-right">
                    <p class="font-bold text-slate-800 dark:text-white text-sm mb-1">মার্স কর্পোরেশন (MARSS CORPORATION)</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-1 leading-relaxed">বিভিন্ন প্রকার দেশী বিদেশী কসমেটিক, ষ্টেশনারী, ইমিটেশন, ব্রেসিয়ার, পেন্টি, বেল্ট পাইকারী ও খুচরা বিক্রেতা।</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">ঝালাইপট্টি, পাবনা।</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">মোবাইলঃ <span class="font-semibold text-slate-700 dark:text-slate-300">০১৭৯২-৮৩৩৭৪৭, ০১৭১১-৪৫১৩৩৪</span></p>
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
                    </tr>
                </thead>
                <tbody id="order_details">
                    @foreach ($purchaseinvoicedata->orderDetails as $key => $orderDetail)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $orderDetail->product->product_name ?? 'N/A' }}</td>
                        <td>{{ $orderDetail->quantity }}</td>
                        <td style="text-align: right">৳ {{ number_format((float)($orderDetail->cost_price ?? 0), 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tr>
                    <td colspan="1" rowspan="6" id="payment_status" class="full-paid">
                        {{ $paymentDetailsStatus ?? 'Not Available' }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="amount_text" style="text-align: right">Sub Total:</td>
                    <td class="amount" id="sub_total" style="text-align: right">৳ {{ number_format((float)($subTotal ?? 0), 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="amount_text table_bg" style="text-align: right">Paid Amount:</td>
                    <td class="amount table_bg" id="paidamount" style="text-align: right">৳ {{ number_format((float)($paidAmount ?? 0), 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="amount_text" style="text-align: right">Due Amount:</td>
                    <td id="due_amount" class="amount" style="text-align: right">৳ {{ number_format((float)($dueAmount ?? 0), 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="amount_text" style="text-align: right">Previous Due Amount:</td>
                    <td id="due_amount" class="amount" style="text-align: right">৳ {{ number_format((float)($PreviousDueAmount ?? 0), 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="amount_text" style="text-align: right">Total Due Amount:</td>
                    <td id="due_amount" class="amount" style="text-align: right">৳ {{ number_format((float)($PreviousDueAmount ?? 0) + (float)($dueAmount ?? 0), 2) }}</td>
                </tr>
            </table>

            <!-- Footer Message -->
            <div class="footer-message">
                <p>
                    Powered by: CodeNext IT - www.codenextit.com
                </p>
            </div>
        </div>

        <!-- Sticky Bottom Copyright Section -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)] mt-auto w-full">
            <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        window.print();
    }
</script>

@endsection