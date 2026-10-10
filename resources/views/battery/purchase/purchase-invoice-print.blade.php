@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Purchase Invoice')

@section('topbar_back_button')
  <a href="javascript:void(0)" onclick="if(window.history.length > 1 && document.referrer && document.referrer !== window.location.href){ window.history.back(); } else { window.location.href = '{{ route('battery.purchases') }}'; }" class="topbar-back-btn" title="Back">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back</span>
  </a>
@endsection

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
        max-width: 100%;
        margin: 0px 0px 24px 0px !important;
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #cbd5e1;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex !important;
        flex-direction: column !important;
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
        padding-bottom: 0px;
        margin-bottom: 10px;
        border-bottom: none !important;
    }
    body[light-mode="dark"] .invoice-header-grid,
    html[light-mode="dark"] .invoice-header-grid,
    body[data-layout-mode="dark"] .invoice-header-grid,
    html.dark .invoice-header-grid,
    body.dark .invoice-header-grid,
    body.dark-mode .invoice-header-grid,
    [data-theme="dark"] .invoice-header-grid {
        border-bottom: none !important;
    }

    .billed-to-details {
        text-align: left !important;
        color: #000000 !important;
    }
    .company-details {
        text-align: right !important;
        color: #000000 !important;
    }

    /* Meta Table (Invoice No / Date) */
    .invoice-meta-table {
        width: 100% !important;
        max-width: 260px !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
        border: 1.5px solid #000000 !important;
        margin-top: 6px !important;
    }
    .invoice-meta-table tr td {
        border-right: 1px solid #000000 !important;
        border-bottom: 1px solid #000000 !important;
        border-top: none !important;
        border-left: none !important;
        color: #000000 !important;
    }
    .invoice-meta-table tr td:last-child {
        border-right: none !important;
    }
    .invoice-meta-table tr:last-child td {
        border-bottom: none !important;
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
        margin-top: 0px !important;
        border: 1px solid #000000 !important;
        border-radius: 0px !important;
        overflow: hidden !important;
    }
    .invoice-container .invoice_table_list th {
        background-color: #f1f5f9 !important;
        color: #000000 !important;
        font-weight: 700 !important;
        font-size: 12px !important;
        border: 1px solid #000000 !important;
        padding: 6px 8px !important;
        text-align: center !important;
    }
    .invoice-container .invoice_table_list td {
        border: 1px solid #000000 !important;
        color: #000000 !important;
        font-size: 12px !important;
        padding: 6px 8px !important;
        background-color: #ffffff !important;
    }
    .invoice-container .invoice_table_list .amount_text {
        font-weight: 600 !important;
        color: #000000 !important;
    }
    .invoice-container .invoice_table_list .amount {
        font-weight: 700 !important;
        color: #000000 !important;
    }
    .invoice-container .invoice_table_list .table_bg {
        background-color: #f8fafc !important;
        color: #000000 !important;
    }
    .invoice-container .full-paid {
        font-weight: 800 !important;
        font-size: 18px !important;
        text-align: center !important;
        color: #15803d !important;
        background-color: #f0fdf4 !important;
    }

    /* Order Summary tbody below order_details */
    .invoice-container .invoice_table_list #order_summary td,
    .invoice-container .invoice_table_list #payment_status {
        border: 1.5px solid #000000 !important;
        color: #000000 !important;
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
            size: portrait;
            margin: 0mm;
        }
        html, body {
            width: 100% !important;
            min-height: 100vh !important;
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
            height: auto !important;
            display: block !important;
            float: none !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            background: #ffffff !important;
        }
        .vertical-menu,
        .navbar-header,
        #page-topbar,
        .navbar-brand-box,
        .sidebar-menu,
        .sidebar,
        .print-button,
        .copyright,
        .footer,
        .hide-on-print {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
            border: none !important;
            box-shadow: none !important;
        }
        .invoice-container {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 100% !important;
            min-height: var(--print-min-height, calc(100vh - 4px)) !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            padding: 16px 16px 0 16px !important;
            margin: 0 !important;
            background: #ffffff !important;
            display: flex !important;
            flex-direction: column !important;
            box-sizing: border-box !important;
        }
        .invoice-main-content {
            flex: 1 0 auto !important;
            flex-grow: 1 !important;
            width: 100% !important;
        }
        .invoice-header-grid {
            display: grid !important;
            grid-template-columns: 1fr 1fr 1fr !important;
            width: 100% !important;
            gap: 15px !important;
            border-bottom: none !important;
            padding-bottom: 0 !important;
            margin-bottom: 10px !important;
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
            max-width: 260px !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: 1.5px solid #000000 !important;
            margin-top: 6px !important;
        }
        .invoice-meta-table tr td {
            border-right: 1px solid #000000 !important;
            border-bottom: 1px solid #000000 !important;
            border-top: none !important;
            border-left: none !important;
            color: #000000 !important;
            padding: 3px 6px !important;
            font-size: 11px !important;
            background: #ffffff !important;
        }
        .invoice-meta-table tr td:last-child {
            border-right: none !important;
        }
        .invoice-meta-table tr:last-child td {
            border-bottom: none !important;
        }
        .invoice-meta-table td#order_no {
            color: #047857 !important;
        }
        .logo-wrapper {
            text-align: center !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
        }
        .logo-wrapper h2 {
            color: #000000 !important;
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
        .company-details h4 {
            text-align: right !important;
            color: #000000 !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            margin-bottom: 2px !important;
        }
        .company-details p {
            text-align: right !important;
            color: #000000 !important;
            font-size: 11px !important;
            line-height: 1.4 !important;
            margin-bottom: 2px !important;
            white-space: normal !important;
        }
        .company-details p.text-emerald-700 {
            color: #047857 !important;
        }
        .invoice_table_list {
            width: 100% !important;
            border-collapse: collapse !important;
            border: 1px solid #000000 !important;
            margin-top: 0 !important;
        }
        .invoice_table_list th {
            background-color: #f1f5f9 !important;
            color: #000000 !important;
            border: 1px solid #000000 !important;
            padding: 6px 8px !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            text-align: center !important;
        }
        .invoice_table_list td {
            background-color: #ffffff !important;
            color: #000000 !important;
            border: 1px solid #000000 !important;
            padding: 6px 8px !important;
            font-size: 12px !important;
        }
        .invoice_table_list .amount_text {
            text-align: right !important;
            font-weight: 600 !important;
            color: #000000 !important;
        }
        .invoice_table_list .amount {
            text-align: right !important;
            font-weight: 700 !important;
            color: #000000 !important;
        }
        .full-paid {
            color: #15803d !important;
            background-color: #ffffff !important;
            text-align: center !important;
            font-weight: 800 !important;
            font-size: 16px !important;
        }
        .invoice_table_list #order_summary,
        .invoice_table_list #order_summary tr {
            break-inside: avoid !important;
            page-break-inside: avoid !important;
        }
        .invoice_table_list #order_summary td,
        .invoice_table_list #payment_status {
            border: 1.5px solid #000000 !important;
            color: #000000 !important;
        }
        .invoice-container .bill-footer-section {
            position: static !important;
            display: block !important;
            width: 100% !important;
            margin-top: auto !important;
            margin-bottom: 0 !important;
            padding-top: 10px !important;
            padding-bottom: 0 !important;
            page-break-before: auto !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        .invoice-container .taka-words-box {
            color: #000000 !important;
            margin-top: 14px !important;
            margin-bottom: 20px !important;
        }
        .invoice-container .taka-words-val {
            border-bottom: 1px dotted #000000 !important;
            color: #000000 !important;
        }
        .invoice-container .signatures-row {
            display: flex !important;
            justify-content: space-between !important;
            color: #000000 !important;
            margin-top: 20px !important;
            padding-bottom: 6px !important;
        }
        .invoice-container .sig-box {
            border-top: 1px dotted #000000 !important;
            color: #000000 !important;
            width: 35% !important;
        }
        .invoice-container .bottom-color-bar {
            display: flex !important;
            height: 12px !important;
            width: calc(100% + 32px) !important;
            margin-left: -16px !important;
            margin-right: -16px !important;
            margin-bottom: 0 !important;
            margin-top: 6px !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .invoice-container .bottom-color-bar .red-bar {
            width: 50% !important;
            background-color: #dc2626 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .invoice-container .bottom-color-bar .green-bar {
            width: 50% !important;
            background-color: #15803d !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
</style>

<div class="main-content min-h-screen flex flex-col justify-between">
    <div class="page-content invoice-page-content flex-grow flex flex-col justify-between">
        <div class="invoice-container min-h-screen flex flex-col justify-between">
            <div class="invoice-main-content flex-1 flex flex-col">
                <!-- 3-Column Equal Top Header: Left (Billed To), Center (Logo & Title), Right (Company Info) -->
                <div class="invoice-header-grid">
                    <!-- 1. Left Column: Billed To Details & Invoice Meta -->
                    <div class="billed-to-details">
                        <h4 class="text-sm font-bold text-black uppercase tracking-wider mb-1" style="color: #000000 !important;">Billed To</h4>
                        <p class="font-bold text-black text-sm mb-0.5" id="SupplierName" style="color: #000000 !important;">{{ $purchaseinvoicedata->supplier->name ?? 'N/A' }}</p>
                        <p class="text-xs text-black mb-0.5" id="SupplierAddress" style="color: #000000 !important;">{{ $purchaseinvoicedata->supplier->address ?? 'N/A' }}</p>
                        <p class="text-xs text-black mb-2" style="color: #000000 !important;">Phone: <span class="font-semibold text-black font-mono" id="SupplierMobile" style="color: #000000 !important;">{{ $purchaseinvoicedata->supplier->mobile ?? 'N/A' }}</span></p>

                        <table class="invoice-meta-table text-xs">
                            <tr>
                                <td class="p-1.5 px-2 bg-slate-50 dark:bg-slate-800 font-semibold text-black" style="color: #000000 !important;">Invoice No:</td>
                                <td class="p-1.5 px-2 font-bold text-emerald-700 dark:text-emerald-400 font-mono" id="order_no">{{ $purchaseinvoicedata->purchase_id }}</td>
                            </tr>
                            <tr>
                                <td class="p-1.5 px-2 bg-slate-50 dark:bg-slate-800 font-semibold text-black" style="color: #000000 !important;">Invoice Date:</td>
                                <td class="p-1.5 px-2 font-medium text-black font-mono" id="invoice_date" style="color: #000000 !important;">{{ $purchaseinvoicedata->date ? \Carbon\Carbon::parse($purchaseinvoicedata->date)->format('d-m-Y') : \Carbon\Carbon::parse($purchaseinvoicedata->created_at)->format('d-m-Y') }}</td>
                            </tr>
                            @if(!empty($purchaseinvoicedata->referance_no))
                            <tr>
                                <td class="p-1.5 px-2 bg-slate-50 dark:bg-slate-800 font-semibold text-black" style="color: #000000 !important;">Reference No:</td>
                                <td class="p-1.5 px-2 font-medium text-black font-mono" style="color: #000000 !important;">{{ $purchaseinvoicedata->referance_no }}</td>
                            </tr>
                            @endif
                            @if(!empty($purchaseinvoicedata->attach_document))
                            <tr class="hide-on-print">
                                <td class="p-1.5 px-2 bg-slate-50 dark:bg-slate-800 font-semibold text-black" style="color: #000000 !important;">Document:</td>
                                <td class="p-1.5 px-2 font-medium text-emerald-600 font-mono"><a href="/{{ $purchaseinvoicedata->attach_document }}" target="_blank" class="hover:underline flex items-center gap-1"><i class="fa-solid fa-paperclip"></i> View File</a></td>
                            </tr>
                            @endif
                        </table>
                    </div>

                    <!-- 2. Center Column: Purchase Details Title, Logo & Print Button -->
                    <div class="logo-wrapper text-center flex flex-col items-center justify-center">
                        <h2 class="text-base sm:text-lg font-bold text-black mb-2 tracking-tight" style="color: #000000 !important;">Purchase Details</h2>
                        <img src="{{ asset('backend/assets/img/marss-corporation-icon2.svg') }}" onerror="this.src='{{ asset('backend/assets/icons/marss-corporation-logo.svg') }}'" alt="MARSS Corporation Logo" class="mb-2" style="max-height: 48px; max-width: 180px; object-fit: contain;" />
                        <button type="button" class="print-button inline-flex items-center gap-1.5 px-4 py-1.5 bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-150 border-0 cursor-pointer" onclick="updatePrintLayoutPages(); window.print()">
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
                        <h4 class="text-sm font-bold text-black uppercase tracking-wider mb-1" style="color: #000000 !important;">MARSS CORPORATION</h4>
                        <p class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 mb-1">Retail &amp; Wholesale Management System</p>
                        <p class="text-xs text-black mb-0.5 leading-relaxed" style="color: #000000 !important;">All Kinds of Dry &amp; Gel Battery Supplier</p>
                        <p class="text-xs text-black mb-0.5" style="color: #000000 !important;">Success Super Market, Sadar Police Fari,</p>
                        <p class="text-xs text-black mb-1" style="color: #000000 !important;">Ataikula Road, Pabna</p>
                        <p class="text-xs text-black mb-0.5" style="color: #000000 !important;">Mobile: <span class="font-semibold text-black font-mono" style="color: #000000 !important;">01975-703216, 01715-842083</span></p>
                        <p class="text-xs text-black" style="color: #000000 !important;">Email: <span class="font-medium text-black" style="color: #000000 !important;">marsscorporation2018@gmail.com</span></p>
                    </div>
                </div>

                <!-- Table Section -->
                <table class="invoice_table_list">
                    <thead>
                        <tr>
                            <th style="width: 8%; text-align: center;">SL. No.</th>
                            <th style="text-align: left;">Product</th>
                            <th style="width: 12%; text-align: center;">Quantity</th>
                            <th style="width: 15%; text-align: right;">Rate</th>
                            <th style="width: 18%; text-align: right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody id="order_details">
                        @foreach ($purchaseinvoicedata->orderDetails as $key => $orderDetail)
                        <tr>
                            <td style="text-align: center;">{{ $key + 1 }}</td>
                            <td style="text-align: left;">{{ $orderDetail->product->product_name ?? 'N/A' }}</td>
                            <td style="text-align: center;">{{ $orderDetail->quantity }}</td>
                            <td style="text-align: right;">৳ {{ number_format((float)($orderDetail->cost_price ?? 0), 2) }}</td>
                            <td style="text-align: right;">৳ {{ number_format((float)(($orderDetail->cost_price ?? 0) * ($orderDetail->quantity ?? 1)), 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    @php
                        $summaryRowCount = 5 + (($deliveryCharge ?? 0) > 0 ? 1 : 0) + (($discountAmount ?? 0) > 0 ? 1 : 0) + (($returnAdj ?? 0) > 0 ? 1 : 0);
                    @endphp
                    <tbody id="order_summary" class="break-inside-avoid">
                        <tr>
                            <td colspan="2" rowspan="{{ $summaryRowCount }}" id="payment_status" class="full-paid">
                                {{ $paymentDetailsStatus ?? 'Unpaid' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="amount_text" style="text-align: right">Sub Total:</td>
                            <td class="amount" id="sub_total" style="text-align: right">৳ {{ number_format((float)($subTotal ?? 0), 2) }}</td>
                        </tr>
                        @if(($deliveryCharge ?? 0) > 0)
                        <tr>
                            <td colspan="2" class="amount_text" style="text-align: right">Delivery &amp; Transport Charge:</td>
                            <td class="amount" style="text-align: right">৳ {{ number_format((float)($deliveryCharge ?? 0), 2) }}</td>
                        </tr>
                        @endif
                        @if(($discountAmount ?? 0) > 0)
                        <tr>
                            <td colspan="2" class="amount_text" style="text-align: right">Discount Amount:</td>
                            <td class="amount" style="text-align: right">৳ {{ number_format((float)($discountAmount ?? 0), 2) }}</td>
                        </tr>
                        @endif
                        @if(($returnAdj ?? 0) > 0)
                        <tr>
                            <td colspan="2" class="amount_text" style="text-align: right">Return Adjustment:</td>
                            <td class="amount" style="text-align: right">৳ {{ number_format((float)($returnAdj ?? 0), 2) }}</td>
                        </tr>
                        @endif
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
                            <td class="amount" style="text-align: right">৳ {{ number_format((float)($PreviousDueAmount ?? 0), 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="amount_text" style="text-align: right">Total Due Amount:</td>
                            <td class="amount" style="text-align: right">৳ {{ number_format((float)($PreviousDueAmount ?? 0) + (float)($dueAmount ?? 0), 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Bill Footer Section: Taka in Words, Signatures, Copyright, Color Bar -->
            <div class="bill-footer-section mt-auto" style="margin-top: auto; width: 100%;">
                <!-- Taka in Words -->
                <div class="taka-words-box" style="width: 100%; margin-top: 25px; margin-bottom: 40px;">
                    <div class="taka-words-line" style="display: flex; align-items: flex-end;">
                        <span class="meta-label" style="font-weight: 700; font-size: 12px; color: #000000;">Taka in Words:</span>
                        <span class="taka-words-val" id="purchase_taka_words" style="flex: 1; border-bottom: 1px dotted #000000; font-weight: 700; padding-left: 6px; color: #000000;"></span>
                    </div>
                </div>

                <!-- Signature Lines -->
                <div class="signatures-row" style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 35px; padding-bottom: 15px; font-size: 12px; font-weight: 600; color: #000000;">
                    <div class="sig-box" style="width: 35%; text-align: center; border-top: 1px dotted #000000; padding-top: 4px; color: #000000;">
                        Received by
                    </div>
                    <div class="sig-box" style="width: 35%; text-align: center; border-top: 1px dotted #000000; padding-top: 4px; color: #000000;">
                        Authorized Signature
                    </div>
                </div>

                <!-- Centered Copyright -->
                <div class="invoice-bottom-copyright" style="text-align: center; font-size: 11px; color: #475569; margin: 10px 0 6px 0;">
                    Powered by: <a href="https://codenextit.com" target="_blank" style="color: inherit; text-decoration: none;">CodeNext IT</a> - <a href="https://codenextit.com" target="_blank" style="color: inherit; text-decoration: none;">www.codenextit.com</a>
                </div>

                <!-- Red & Green Bottom Accent Bar -->
                <div class="bottom-color-bar" style="display: flex; height: 12px; width: calc(100% + 48px); margin-left: -24px; margin-right: -24px; margin-bottom: -24px;">
                    <div class="red-bar" style="width: 50%; background-color: #dc2626;"></div>
                    <div class="green-bar" style="width: 50%; background-color: #15803d;"></div>
                </div>
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
    function numberToWords(num) {
        num = Math.round(Number(num) || 0);
        if (num === 0) return 'Zero Taka Only';

        const single = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        const double = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

        function convertLessThanOneThousand(n) {
            let str = '';
            if (n >= 100) {
                str += single[Math.floor(n / 100)] + ' Hundred ';
                n %= 100;
            }
            if (n >= 20) {
                str += double[Math.floor(n / 10)] + ' ';
                n %= 10;
            }
            if (n > 0) {
                str += single[n] + ' ';
            }
            return str;
        }

        let crore = Math.floor(num / 10000000);
        num %= 10000000;
        let lakh = Math.floor(num / 100000);
        num %= 100000;
        let thousand = Math.floor(num / 1000);
        num %= 1000;
        let remainder = num;

        let res = '';
        if (crore > 0) {
            res += convertLessThanOneThousand(crore) + 'Crore ';
        }
        if (lakh > 0) {
            res += convertLessThanOneThousand(lakh) + 'Lakh ';
        }
        if (thousand > 0) {
            res += convertLessThanOneThousand(thousand) + 'Thousand ';
        }
        if (remainder > 0) {
            res += convertLessThanOneThousand(remainder);
        }

        return res.trim() ? res.trim() + ' Taka Only' : 'Zero Taka Only';
    }

    function updatePrintLayoutPages() {
        const header = document.querySelector('.invoice-header-grid');
        const table = document.querySelector('.invoice_table_list');
        const footer = document.querySelector('.bill-footer-section');
        const container = document.querySelector('.invoice-container');
        if (!header || !table || !footer || !container) return;

        const naturalHeight = header.offsetHeight + table.offsetHeight + footer.offsetHeight;
        const pageThreshold = 1020;
        const numPages = Math.max(1, Math.ceil(naturalHeight / pageThreshold));

        container.style.setProperty('--print-min-height', `calc(${numPages * 100}vh - 4px)`);
    }

    window.addEventListener('beforeprint', updatePrintLayoutPages);

    window.onload = function() {
        const wordsEl = document.getElementById('purchase_taka_words');
        if (wordsEl) {
            let totalVal = parseFloat("{{ ((float)($PreviousDueAmount ?? 0) + (float)($dueAmount ?? 0)) > 0 ? ((float)($PreviousDueAmount ?? 0) + (float)($dueAmount ?? 0)) : (float)($subTotal ?? 0) }}") || 0;
            wordsEl.innerText = numberToWords(Math.round(totalVal));
        }
        updatePrintLayoutPages();
    };
</script>

@endsection
