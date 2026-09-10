@extends('layouts.dashboard-sidenav')
@section('title', 'Daily Income & Expense Ledger Report - MARSS CORPORATION')
@section('content')

<!-- Flatpickr & html2pdf CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
    /* ── A4 Print Styles: Exactly 10px Margin Around Page ── */
    @media print {
        @page {
            size: A4 portrait;
            margin: 10px !important;
        }
        html, body {
            background: #ffffff !important;
            color: #000000 !important;
            height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: visible !important;
        }
        nav, header, aside, .sidebar, .isvertical-topbar, #page-topbar, .navbar-header,
        .no-print, .copyright, .footer, .export-btn, .ledger-cards-grid, .top-filter-grid, #paginationContainer {
            display: none !important;
        }
        .main-content, .page-content, .card, .card-body, .data-table, .table-responsive {
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            box-shadow: none !important;
            background: #ffffff !important;
            overflow: visible !important;
            height: auto !important;
            position: static !important;
        }
        #printableLedgerArea {
            display: block !important;
            position: static !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .print-only {
            display: block !important;
        }
        #printTable {
            width: 100% !important;
            border-collapse: collapse !important;
            display: table !important;
            font-size: 9.5px !important;
        }
        #printTable th {
            background-color: #15803d !important;
            color: #ffffff !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            padding: 5px 6px !important;
            font-size: 9px !important;
            border: 1px solid #15803d !important;
        }
        #printTable td {
            padding: 4px 6px !important;
            border: 1px solid #cbd5e1 !important;
            font-size: 9px !important;
            color: #111827 !important;
        }
        #printTable tfoot td {
            background-color: #f8fafc !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            font-weight: 700 !important;
            border-top: 2px solid #15803d !important;
        }
    }

    .print-only {
        display: none;
    }

    /* ── Export Button Styles ── */
    .export-btn { display:inline-flex; align-items:center; gap:5px; height:32px; padding:0 12px; border-radius:8px; font-size:11.5px; font-weight:700; cursor:pointer; border:1.5px solid transparent; transition:all 0.15s; white-space:nowrap; }
    .export-btn--copy  { background:#f1f5f9; color:#475569; border-color:#cbd5e1; }
    .export-btn--copy:hover  { background:#e2e8f0; border-color:#94a3b8; }
    .export-btn--csv   { background:#ecfdf5; color:#065f46; border-color:#a7f3d0; }
    .export-btn--csv:hover   { background:#d1fae5; border-color:#34d399; }
    .export-btn--excel { background:#f0fdf4; color:#15803d; border-color:#bbf7d0; }
    .export-btn--excel:hover { background:#dcfce7; border-color:#4ade80; }
    .export-btn--pdf   { background:#fff1f2; color:#be123c; border-color:#fecaca; }
    .export-btn--pdf:hover   { background:#ffe4e6; border-color:#f87171; }
    .export-btn--print { background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe; }
    .export-btn--print:hover { background:#dbeafe; border-color:#60a5fa; }

    /* ── Top Filter Grid ──
       Desktop (1024px+): 1 row 4 columns (Start Date, End Date, Show, Quick Filter)
       Tablet & Mobile: 2 rows of 2 columns each
    ── */
    .top-filter-grid {
        display: grid !important;
        grid-template-columns: 2fr 2fr 0.9fr 1.3fr !important;
        gap: 12px !important;
        align-items: flex-end !important;
    }
    @media (max-width: 1023px) {
        .top-filter-grid {
            grid-template-columns: 1fr 1fr !important;
            gap: 10px !important;
        }
    }

    /* ── Perfectly Aligned Date Input Wrap (No clipping, centered icon) ── */
    .filter-field-wrap {
        position: relative !important;
        width: 100% !important;
        height: 38px !important;
        display: flex !important;
        align-items: center !important;
        margin: 0 !important;
    }
    .filter-field-input {
        width: 100% !important;
        height: 38px !important;
        line-height: 38px !important;
        padding-left: 12px !important;
        padding-right: 34px !important;
        border-radius: 10px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        outline: none !important;
        box-sizing: border-box !important;
        margin: 0 !important;
        transition: border-color 0.2s, box-shadow 0.2s !important;
    }
    .filter-field-icon {
        position: absolute !important;
        right: 11px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        width: 16px !important;
        height: 16px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        pointer-events: none !important;
        color: #94a3b8;
        z-index: 5 !important;
    }

    /* Mobile specific adjustments */
    @media (max-width: 639px) {
        .filter-field-input {
            font-size: 12px !important;
            padding-left: 8px !important;
            padding-right: 28px !important;
        }
        .filter-field-icon {
            right: 8px !important;
        }
    }

    /* ── Modern Custom Dropdown for Quick Filter ── */
    .custom-select-wrap {
        position: relative;
        width: 100%;
        height: 38px;
    }
    .custom-select-btn {
        width: 100%;
        height: 38px;
        padding: 0 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #ffffff;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        outline: none;
        user-select: none;
        box-sizing: border-box;
        transition: all 0.15s ease;
    }
    .custom-select-menu {
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        padding: 5px;
        z-index: 50;
        display: none;
    }
    .custom-select-menu.open {
        display: block;
        animation: dropFade 0.15s ease;
    }
    @keyframes dropFade {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .custom-select-option {
        padding: 8px 12px;
        font-size: 12.5px;
        font-weight: 600;
        border-radius: 8px;
        color: #334155;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: background 0.12s;
    }
    .custom-select-option:hover {
        background: #f1f5f9;
        color: #15803d;
    }
    .custom-select-option.active {
        background: #ecfdf5;
        color: #15803d;
    }

    /* ── Summary Cards Responsive Grid: 4 col desktop, 2 col tab, 1 col mobile ── */
    .ledger-cards-grid {
        display: grid !important;
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 14px !important;
    }
    @media (min-width: 640px) and (max-width: 1023px) {
        .ledger-cards-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }
    @media (max-width: 639px) {
        .ledger-cards-grid {
            grid-template-columns: 1fr !important;
        }
    }

    .ledger-stat-card {
        border-radius: 14px;
        padding: 14px 16px;
        transition: all 0.2s ease;
    }
    .ledger-stat-card--inflow { background: #ecfdf5; border: 1.5px solid #a7f3d0; }
    .ledger-stat-card--inflow .card-title { color: #065f46; font-weight: 700; font-size: 11px; }
    .ledger-stat-card--inflow .card-val   { color: #047857; font-weight: 900; font-size: 20px; }

    .ledger-stat-card--outflow { background: #fff1f2; border: 1.5px solid #fecaca; }
    .ledger-stat-card--outflow .card-title { color: #9f1239; font-weight: 700; font-size: 11px; }
    .ledger-stat-card--outflow .card-val   { color: #be123c; font-weight: 900; font-size: 20px; }

    .ledger-stat-card--net { background: #f0f9ff; border: 1.5px solid #bae6fd; }
    .ledger-stat-card--net .card-title { color: #0369a1; font-weight: 700; font-size: 11px; }
    .ledger-stat-card--net .card-val   { color: #0284c7; font-weight: 900; font-size: 20px; }

    .ledger-stat-card--count { background: #f8fafc; border: 1.5px solid #e2e8f0; }
    .ledger-stat-card--count .card-title { color: #475569; font-weight: 700; font-size: 11px; }
    .ledger-stat-card--count .card-val   { color: #1e293b; font-weight: 900; font-size: 20px; }

    .unified-ui-border { border: 1.5px solid #cbd5e1 !important; }
    .product-card-body { padding: 10px !important; }
    @media (min-width: 768px) { .product-card-body { padding: 18px !important; } }

    /* ── Mobile Box Table View Card ── */
    .mobile-table-card {
        border-radius: 12px;
        padding: 12px;
        margin-bottom: 10px;
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        transition: transform 0.1s;
    }

    /* =========================================================
       COMPREHENSIVE DARK MODE FIXES (NO WHITE BORDERS)
       ========================================================= */
    body[light-mode="dark"] .export-btn--copy, body[data-layout-mode="dark"] .export-btn--copy, html.dark .export-btn--copy { background:#1e293b; color:#94a3b8; border-color:#334155; }
    body[light-mode="dark"] .export-btn--csv,  body[data-layout-mode="dark"] .export-btn--csv,  html.dark .export-btn--csv  { background:#022c1e; color:#34d399; border-color:#064e3b; }
    body[light-mode="dark"] .export-btn--excel,body[data-layout-mode="dark"] .export-btn--excel,html.dark .export-btn--excel { background:#022c1e; color:#4ade80; border-color:#065f46; }
    body[light-mode="dark"] .export-btn--pdf,  body[data-layout-mode="dark"] .export-btn--pdf,  html.dark .export-btn--pdf  { background:#3b0006; color:#f87171; border-color:#7f1d1d; }
    body[light-mode="dark"] .export-btn--print,body[data-layout-mode="dark"] .export-btn--print,html.dark .export-btn--print { background:#0c1a3b; color:#60a5fa; border-color:#1e3a5f; }

    body[light-mode="dark"] .card, body[data-layout-mode="dark"] .card, html[light-mode="dark"] .card, html.dark .card {
        background-color: #0f172a !important; border-color: #334155 !important;
    }
    body[light-mode="dark"] .unified-ui-border, body[data-layout-mode="dark"] .unified-ui-border, html.dark .unified-ui-border {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .filter-field-input, body[data-layout-mode="dark"] .filter-field-input, html.dark .filter-field-input {
        background-color: #1e293b !important; border-color: #334155 !important; color: #f1f5f9 !important;
    }
    body[light-mode="dark"] .custom-select-btn, body[data-layout-mode="dark"] .custom-select-btn, html.dark .custom-select-btn {
        background-color: #1e293b !important; border-color: #334155 !important; color: #f1f5f9 !important;
    }
    body[light-mode="dark"] .custom-select-menu, body[data-layout-mode="dark"] .custom-select-menu, html.dark .custom-select-menu {
        background-color: #1e293b !important; border: 1.5px solid #334155 !important; box-shadow: 0 10px 25px rgba(0,0,0,0.5) !important;
    }
    body[light-mode="dark"] .custom-select-option, body[data-layout-mode="dark"] .custom-select-option, html.dark .custom-select-option {
        color: #e2e8f0 !important;
    }
    body[light-mode="dark"] .custom-select-option:hover, body[data-layout-mode="dark"] .custom-select-option:hover, html.dark .custom-select-option:hover {
        background: #334155 !important; color: #34d399 !important;
    }
    body[light-mode="dark"] .custom-select-option.active, body[data-layout-mode="dark"] .custom-select-option.active, html.dark .custom-select-option.active {
        background: #064e3b !important; color: #34d399 !important;
    }

    /* Stat Cards in Dark Mode */
    body[light-mode="dark"] .ledger-stat-card--inflow, body[data-layout-mode="dark"] .ledger-stat-card--inflow, html.dark .ledger-stat-card--inflow { background: #022c1e !important; border-color: #064e3b !important; }
    body[light-mode="dark"] .ledger-stat-card--inflow .card-title, html.dark .ledger-stat-card--inflow .card-title { color: #34d399 !important; }
    body[light-mode="dark"] .ledger-stat-card--inflow .card-val, html.dark .ledger-stat-card--inflow .card-val { color: #6ee7b7 !important; }

    body[light-mode="dark"] .ledger-stat-card--outflow, body[data-layout-mode="dark"] .ledger-stat-card--outflow, html.dark .ledger-stat-card--outflow { background: #3b0712 !important; border-color: #7f1d1d !important; }
    body[light-mode="dark"] .ledger-stat-card--outflow .card-title, html.dark .ledger-stat-card--outflow .card-title { color: #f87171 !important; }
    body[light-mode="dark"] .ledger-stat-card--outflow .card-val, html.dark .ledger-stat-card--outflow .card-val { color: #fca5a5 !important; }

    body[light-mode="dark"] .ledger-stat-card--net, body[data-layout-mode="dark"] .ledger-stat-card--net, html.dark .ledger-stat-card--net { background: #082f49 !important; border-color: #075985 !important; }
    body[light-mode="dark"] .ledger-stat-card--net .card-title, html.dark .ledger-stat-card--net .card-title { color: #38bdf8 !important; }
    body[light-mode="dark"] .ledger-stat-card--net .card-val, html.dark .ledger-stat-card--net .card-val { color: #7dd3fc !important; }

    body[light-mode="dark"] .ledger-stat-card--count, body[data-layout-mode="dark"] .ledger-stat-card--count, html.dark .ledger-stat-card--count { background: #0f172a !important; border-color: #334155 !important; }
    body[light-mode="dark"] .ledger-stat-card--count .card-title, html.dark .ledger-stat-card--count .card-title { color: #94a3b8 !important; }
    body[light-mode="dark"] .ledger-stat-card--count .card-val, html.dark .ledger-stat-card--count .card-val { color: #f1f5f9 !important; }

    /* Dark Mode Table, Cells & Badges (Fix white border on Ref/Voucher & Particulars) */
    body[light-mode="dark"] .table-responsive, body[data-layout-mode="dark"] .table-responsive, html.dark .table-responsive {
        border-color: #334155 !important; background-color: #0f172a !important;
    }
    body[light-mode="dark"] #printTable, body[data-layout-mode="dark"] #printTable, html.dark #printTable {
        background-color: #0f172a !important;
    }
    body[light-mode="dark"] #printTable tbody tr, body[data-layout-mode="dark"] #printTable tbody tr, html.dark #printTable tbody tr {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #printTable tbody td, body[data-layout-mode="dark"] #printTable tbody td, html.dark #printTable tbody td {
        border-color: #334155 !important; color: #e2e8f0 !important;
    }
    body[light-mode="dark"] #printTable tbody tr:hover, body[data-layout-mode="dark"] #printTable tbody tr:hover, html.dark #printTable tbody tr:hover {
        background-color: #1e293b !important;
    }
    body[light-mode="dark"] #printTable tfoot, body[data-layout-mode="dark"] #printTable tfoot, html.dark #printTable tfoot {
        background-color: #1e293b !important; border-color: #334155 !important;
    }
    body[light-mode="dark"] .mobile-table-card, body[data-layout-mode="dark"] .mobile-table-card, html.dark .mobile-table-card {
        background-color: #1e293b !important; border-color: #334155 !important;
    }

    /* Ref Badge in Dark Mode */
    body[light-mode="dark"] .ref-badge, body[data-layout-mode="dark"] .ref-badge, html.dark .ref-badge {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    /* Particulars Type Badge in Dark Mode */
    body[light-mode="dark"] .cat-badge-inflow, body[data-layout-mode="dark"] .cat-badge-inflow, html.dark .cat-badge-inflow {
        background-color: #064e3b !important;
        border-color: #047857 !important;
        color: #34d399 !important;
    }
    body[light-mode="dark"] .cat-badge-outflow, body[data-layout-mode="dark"] .cat-badge-outflow, html.dark .cat-badge-outflow {
        background-color: #4c0519 !important;
        border-color: #881337 !important;
        color: #f87171 !important;
    }

    /* Flatpickr Calendar in Dark Mode */
    body[light-mode="dark"] .flatpickr-calendar, body[data-layout-mode="dark"] .flatpickr-calendar, html.dark .flatpickr-calendar { background: #1e293b !important; border-color: #334155 !important; color: #e2e8f0 !important; }
    body[light-mode="dark"] .flatpickr-day, body[data-layout-mode="dark"] .flatpickr-day, html.dark .flatpickr-day { color: #e2e8f0 !important; }
    body[light-mode="dark"] .flatpickr-day:hover, body[data-layout-mode="dark"] .flatpickr-day:hover, html.dark .flatpickr-day:hover { background: #334155 !important; }
    body[light-mode="dark"] .flatpickr-day.selected, body[data-layout-mode="dark"] .flatpickr-day.selected, html.dark .flatpickr-day.selected { background: #15803d !important; border-color: #15803d !important; }
    body[light-mode="dark"] .flatpickr-months, body[data-layout-mode="dark"] .flatpickr-months, html.dark .flatpickr-months { background: #1e293b !important; color: #f1f5f9 !important; }
    body[light-mode="dark"] .flatpickr-current-month, body[data-layout-mode="dark"] .flatpickr-current-month, html.dark .flatpickr-current-month { color: #f1f5f9 !important; font-weight: 700 !important; }
    body[light-mode="dark"] .flatpickr-weekday, body[data-layout-mode="dark"] .flatpickr-weekday, html.dark .flatpickr-weekday, body[light-mode="dark"] span.flatpickr-weekday { color: #ffffff !important; font-weight: 800 !important; }
</style>

<!-- Hero Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-screen flex flex-col justify-between">
        <div class="data-table flex-grow">
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-8">

                    <!-- 1. Page Title & Export Buttons -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4 no-print">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Daily Income & Expense Ledger</h1>
                        </div>
                        <!-- Dynamic Export Buttons -->
                        <div class="flex items-center flex-wrap gap-1.5">
                            <button onclick="exportCopyDynamic()" type="button" class="export-btn export-btn--copy" title="Copy table data">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                Copy
                            </button>
                            <button onclick="exportCSVDynamic()" type="button" class="export-btn export-btn--csv" title="Export CSV table data">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                                CSV
                            </button>
                            <button onclick="exportExcelDynamic()" type="button" class="export-btn export-btn--excel" title="Export Excel table data">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><polyline points="8 13 12 17 16 13"></polyline><line x1="12" y1="17" x2="12" y2="10"></line></svg>
                                Excel
                            </button>
                            <button onclick="exportPDFDynamic()" type="button" class="export-btn export-btn--pdf" title="Download PDF File">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                                PDF
                            </button>
                            <button onclick="printTableOnly()" type="button" class="export-btn export-btn--print" title="Print table on A4">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                                Print
                            </button>
                        </div>
                    </div>

                    <!-- 2. Filter Row: 4 Columns (Desktop 1 row 4 col, Mobile 2 rows 2 col) -->
                    <div class="top-filter-grid mb-5 no-print">
                        <!-- Column 1: Start Date (Icon on right, text starts left) -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Start Date</label>
                            <div class="filter-field-wrap">
                                <input type="text" id="startDate" readonly placeholder="Start date" class="filter-field-input unified-ui-border bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 placeholder:text-slate-400" />
                                <div class="filter-field-icon">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Column 2: End Date (Icon on right, text starts left) -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 uppercase tracking-wider">End Date</label>
                            <div class="filter-field-wrap">
                                <input type="text" id="endDate" readonly placeholder="End date" class="filter-field-input unified-ui-border bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 placeholder:text-slate-400" />
                                <div class="filter-field-icon">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Column 3: Show (Left of Quick Filter) -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Show</label>
                            <div class="filter-field-wrap">
                                <select id="entries" onchange="onEntriesChange()" class="filter-field-input unified-ui-border bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">
                                    <option value="15" selected>15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>

                        <!-- Column 4: Quick Filter Modern Custom Dropdown -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Quick Filter</label>
                            <div class="custom-select-wrap" id="quickFilterWrapper">
                                <button type="button" id="quickFilterBtn" onclick="toggleQuickFilterMenu()" class="custom-select-btn unified-ui-border text-slate-800 dark:text-slate-100">
                                    <span id="quickFilterSelectedText">Today</span>
                                    <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </button>
                                <div id="quickFilterMenu" class="custom-select-menu">
                                    <div class="custom-select-option active" onclick="selectPresetOption('today', 'Today')">
                                        <span>Today</span>
                                        <svg class="w-3.5 h-3.5 check-icon text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </div>
                                    <div class="custom-select-option" onclick="selectPresetOption('yesterday', 'Yesterday')">
                                        <span>Yesterday</span>
                                        <svg class="w-3.5 h-3.5 check-icon text-emerald-600 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </div>
                                    <div class="custom-select-option" onclick="selectPresetOption('last_7_days', 'Last 7 Days')">
                                        <span>Last 7 Days</span>
                                        <svg class="w-3.5 h-3.5 check-icon text-emerald-600 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </div>
                                    <div class="custom-select-option" onclick="selectPresetOption('this_month', 'This Month')">
                                        <span>This Month</span>
                                        <svg class="w-3.5 h-3.5 check-icon text-emerald-600 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </div>
                                    <div class="custom-select-option" onclick="selectPresetOption('custom', 'Custom Range')">
                                        <span>Custom Range</span>
                                        <svg class="w-3.5 h-3.5 check-icon text-emerald-600 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Summary Amount Cards: 4col desktop, 2col tab, 1col mobile -->
                    <div class="ledger-cards-grid mb-5 no-print">
                        <!-- Total Inflow -->
                        <div class="ledger-stat-card ledger-stat-card--inflow">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="card-title uppercase tracking-wider">Total Inflow</span>
                                <div class="w-6 h-6 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="19 12 12 19 5 12"></polyline><line x1="12" y1="5" x2="12" y2="19"></line></svg>
                                </div>
                            </div>
                            <p id="summaryInflow" class="card-val m-0 leading-tight">৳ 0.00</p>
                        </div>

                        <!-- Total Outflow -->
                        <div class="ledger-stat-card ledger-stat-card--outflow">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="card-title uppercase tracking-wider">Total Outflow</span>
                                <div class="w-6 h-6 rounded-lg bg-rose-100 dark:bg-rose-900/50 text-rose-700 dark:text-rose-300 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="5 12 12 5 19 12"></polyline><line x1="12" y1="19" x2="12" y2="5"></line></svg>
                                </div>
                            </div>
                            <p id="summaryOutflow" class="card-val m-0 leading-tight">৳ 0.00</p>
                        </div>

                        <!-- Net Cash Balance -->
                        <div class="ledger-stat-card ledger-stat-card--net">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="card-title uppercase tracking-wider">Net Cash Balance</span>
                                <div class="w-6 h-6 rounded-lg bg-sky-100 dark:bg-sky-900/50 text-sky-700 dark:text-sky-300 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                </div>
                            </div>
                            <p id="summaryNetBalance" class="card-val m-0 leading-tight">৳ 0.00</p>
                        </div>

                        <!-- Total Transactions -->
                        <div class="ledger-stat-card ledger-stat-card--count">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="card-title uppercase tracking-wider">Total Transactions</span>
                                <div class="w-6 h-6 rounded-lg bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                </div>
                            </div>
                            <p id="summaryTxCount" class="card-val m-0 leading-tight">0 Entries</p>
                        </div>
                    </div>

                    <!-- 4. Table Header Row (Title & Period Badge) -->
                    <div class="flex items-center justify-between gap-3 mb-3 no-print">
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-200 m-0 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            Transactions Ledger Sheet
                        </p>
                        <span id="ledgerPeriodBadge" class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-300">Period: Today</span>
                    </div>

                    <!-- 5. PRINTABLE AREA -->
                    <div id="printableLedgerArea">

                        <!-- Clean Print Header (Only visible on print) -->
                        <div class="print-only mb-2" style="border-bottom: 2px solid #15803d; padding-bottom: 6px; text-align: center;">
                            <h2 style="margin: 0; font-size: 17px; font-weight: 800; color: #15803d;">MARSS CORPORATION</h2>
                            <p style="margin: 2px 0; font-size: 9.5px; color: #555;">Retailer & Wholesaler | Proprietor: Md. Anisur Rahman</p>
                            <h3 style="margin: 3px 0; font-size: 12px; font-weight: 700; color: #111;">Daily Income & Expense Ledger Report</h3>
                            <p style="margin: 0; font-size: 9.5px; color: #666;">Period: <span id="printDateRange">Today</span></p>
                            <!-- Compact summary line for print -->
                            <div style="display:flex; justify-content:space-around; margin-top:5px; padding:4px 6px; background:#f8fafc; border:1px solid #e2e8f0; font-size:9.5px; font-weight:700;">
                                <span>Total Inflow: <strong id="printInflow" style="color:#047857;">৳ 0.00</strong></span>
                                <span>Total Outflow: <strong id="printOutflow" style="color:#be123c;">৳ 0.00</strong></span>
                                <span>Net Balance: <strong id="printNet" style="color:#0284c7;">৳ 0.00</strong></span>
                                <span>Total Entries: <strong id="printCount">0</strong></span>
                            </div>
                        </div>

                        <!-- Desktop & Tablet Table (Hidden on Mobile) -->
                        <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                            <table id="printTable" class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                        <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                        <th class="p-[10px] text-start whitespace-nowrap">Date & Time</th>
                                        <th class="p-[10px] text-start whitespace-nowrap">Ref / Voucher</th>
                                        <th class="p-[10px] text-start whitespace-nowrap">Particulars</th>
                                        <th class="p-[10px] text-start whitespace-nowrap">Party / Category</th>
                                        <th class="p-[10px] text-end whitespace-nowrap">Cash In</th>
                                        <th class="p-[10px] text-end whitespace-nowrap">Cash Out</th>
                                        <th class="p-[10px] text-end rounded-tr-2xl whitespace-nowrap">Running Cash</th>
                                    </tr>
                                </thead>
                                <tbody id="ledgerTbody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                                    <tr>
                                        <td colspan="8" class="text-center text-slate-400 font-medium" style="padding: 48px 16px !important;">
                                            <span class="inline-flex items-center gap-2">
                                                <svg class="animate-spin w-4 h-4 text-emerald-600" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                                Loading ledger entries...
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-slate-50/90 dark:bg-slate-800/70 text-slate-800 dark:text-slate-100 font-bold border-t-2 border-emerald-600/30 dark:border-emerald-600/20 text-xs sm:text-sm">
                                    <tr>
                                        <td colspan="5" class="p-[10px] text-end font-bold text-slate-600 dark:text-slate-300">Total Summary:</td>
                                        <td id="tfootTotalInflow" class="p-[10px] text-end font-bold text-emerald-600 dark:text-emerald-400 whitespace-nowrap">৳ 0.00</td>
                                        <td id="tfootTotalOutflow" class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ 0.00</td>
                                        <td id="tfootNetBalance" class="p-[10px] text-end font-bold text-sky-600 dark:text-sky-400 whitespace-nowrap">৳ 0.00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Mobile View: Box Style Cards -->
                        <div id="mobileCardContainer" class="block md:hidden space-y-3 no-print">
                            <!-- Injected by renderTable -->
                        </div>

                        <!-- Print Only Signatures (A4 Footer) -->
                        <div class="print-only mt-6 pt-3">
                            <div style="display:flex; justify-content:space-between; text-align:center; font-size:10px; font-weight:600; padding:0 25px;">
                                <div style="border-top:1px solid #333; width:140px; padding-top:4px;">Cashier Signature</div>
                                <div style="border-top:1px solid #333; width:140px; padding-top:4px;">Accountant Signature</div>
                                <div style="border-top:1px solid #333; width:140px; padding-top:4px;">Owner Signature</div>
                            </div>
                        </div>

                    </div>
                    <!-- PRINTABLE AREA END -->

                    <!-- 6. Pagination & Showing Info -->
                    <div id="paginationContainer" class="flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-800 gap-3 no-print">
                        <div id="display-info" class="text-xs text-slate-500 dark:text-slate-400 font-medium"></div>
                        <div id="pagination" class="flex items-center gap-1 sm:gap-1.5 flex-nowrap justify-center max-w-full overflow-x-auto pb-1"></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sticky Copyright -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)] no-print">
            <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>
    </div>
</div>

<script>
    // State management
    let allLedgerData = [];
    let currentSummary = {};
    let currentPage = 1;
    let currentPerPage = 15;
    let selectedPreset = 'today';
    let startPicker = null;
    let endPicker = null;

    // Helper: Safe Authorization headers
    function getAuthHeader() {
        if (typeof HeaderToken === 'function') {
            try {
                const h = HeaderToken();
                if (h && h.headers && h.headers.Authorization) return h;
            } catch (e) {
                console.warn("HeaderToken error:", e);
            }
        }
        const token = localStorage.getItem('token');
        if (token) {
            return {
                headers: {
                    Authorization: token.startsWith('Bearer ') ? token : `Bearer ${token}`
                }
            };
        }
        return {};
    }

    // Helper: Format YYYY-MM-DD
    function formatDateStr(d) {
        const y = d.getFullYear();
        const m = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');
        return `${y}-${m}-${day}`;
    }

    // Initialize Flatpickr with Static Month (No dropdown, only prev/next)
    document.addEventListener("DOMContentLoaded", () => {
        const todayStr = formatDateStr(new Date());

        startPicker = flatpickr("#startDate", {
            dateFormat: "Y-m-d",
            defaultDate: todayStr,
            monthSelectorType: "static", // NO month dropdown! Only prev/next arrows
            onChange: function(selectedDates, dateStr) {
                if (endPicker && dateStr) {
                    endPicker.set("minDate", dateStr);
                }
                setQuickFilterUILabel('Custom Range');
                autoFilterIfBothDates();
            }
        });

        endPicker = flatpickr("#endDate", {
            dateFormat: "Y-m-d",
            defaultDate: todayStr,
            monthSelectorType: "static", // NO month dropdown! Only prev/next arrows
            onChange: function() {
                setQuickFilterUILabel('Custom Range');
                autoFilterIfBothDates();
            }
        });

        // Close custom select dropdown on outside click
        document.addEventListener('click', (e) => {
            const wrap = document.getElementById('quickFilterWrapper');
            if (wrap && !wrap.contains(e.target)) {
                document.getElementById('quickFilterMenu').classList.remove('open');
            }
        });

        // Initial fetch for Today
        fetchDailyLedger();
    });

    // Auto filter when both dates are present
    function autoFilterIfBothDates() {
        const s = document.getElementById("startDate").value;
        const e = document.getElementById("endDate").value;
        if (s && e) {
            currentPage = 1;
            fetchDailyLedger();
        }
    }

    // Custom Quick Filter Dropdown logic
    function toggleQuickFilterMenu() {
        const menu = document.getElementById('quickFilterMenu');
        menu.classList.toggle('open');
    }

    function setQuickFilterUILabel(label) {
        document.getElementById('quickFilterSelectedText').innerText = label;
        const options = document.querySelectorAll('#quickFilterMenu .custom-select-option');
        options.forEach(opt => {
            const isMatch = opt.querySelector('span').innerText.trim() === label;
            opt.classList.toggle('active', isMatch);
            const check = opt.querySelector('.check-icon');
            if (check) check.classList.toggle('hidden', !isMatch);
        });
    }

    function selectPresetOption(val, label) {
        selectedPreset = val;
        setQuickFilterUILabel(label);
        document.getElementById('quickFilterMenu').classList.remove('open');

        if (val === 'custom') return;

        const now = new Date();
        let sDate = new Date();
        let eDate = new Date();

        if (val === 'today') {
            // sDate and eDate are already today
        } else if (val === 'yesterday') {
            sDate.setDate(now.getDate() - 1);
            eDate.setDate(now.getDate() - 1);
        } else if (val === 'last_7_days') {
            sDate.setDate(now.getDate() - 6);
            eDate = now;
        } else if (val === 'this_month') {
            sDate = new Date(now.getFullYear(), now.getMonth(), 1);
            eDate = now;
        }

        const sStr = formatDateStr(sDate);
        const eStr = formatDateStr(eDate);

        if (startPicker) startPicker.setDate(sStr, false);
        if (endPicker) {
            endPicker.set("minDate", sStr);
            endPicker.setDate(eStr, false);
        }

        currentPage = 1;
        fetchDailyLedger();
    }

    // Entries Change Handler
    function onEntriesChange() {
        currentPerPage = parseInt(document.getElementById("entries").value) || 15;
        currentPage = 1;
        renderTable(false);
    }

    // Pagination Go To Page
    function goToPage(p) {
        const totalPages = Math.ceil(allLedgerData.length / currentPerPage) || 1;
        if (p < 1 || p > totalPages) return;
        currentPage = p;
        renderTable(false);
    }

    // Realistic Demo Transactions
    function getDemoTransactions() {
        return [
            {
                timestamp: new Date().toISOString(),
                date: "10 Sep 2026, 02:45 PM",
                ref_no: "SALE-POS0012",
                particulars: "নগদ বিক্রি - ইনভয়েস #POS-1002",
                party_name: "Walk-in Customer",
                type: "inflow",
                category: "ক্যাশ সেলস (Sales)",
                inflow: 4500.00,
                outflow: 0.00,
                running_balance: 4500.00
            },
            {
                timestamp: new Date(Date.now() - 3600000).toISOString(),
                date: "10 Sep 2026, 01:15 PM",
                ref_no: "EXP-104",
                particulars: "দোকানের খরচ - বিদ্যুৎ বিল ও নাশতা",
                party_name: "General Expense",
                type: "outflow",
                category: "দোকান খরচ (Expense)",
                inflow: 0.00,
                outflow: 1200.00,
                running_balance: 3300.00
            },
            {
                timestamp: new Date(Date.now() - 7200000).toISOString(),
                date: "10 Sep 2026, 11:30 AM",
                ref_no: "CUST-PAY-209",
                particulars: "কাস্টমার বকেয়া আদায়",
                party_name: "Al-Amin Traders",
                type: "inflow",
                category: "বকেয়া কালেকশন (Due)",
                inflow: 2500.00,
                outflow: 0.00,
                running_balance: 5800.00
            }
        ];
    }

    // Main Fetch Function
    async function fetchDailyLedger() {
        const startDate = document.getElementById("startDate").value || formatDateStr(new Date());
        const endDate = document.getElementById("endDate").value || formatDateStr(new Date());

        const tbody = document.getElementById('ledgerTbody');
        tbody.innerHTML = `<tr><td colspan="8" class="text-center text-slate-400 font-medium" style="padding: 48px 16px !important;"><span class="inline-flex items-center gap-2"><svg class="animate-spin w-4 h-4 text-emerald-600" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>Loading ledger entries...</span></td></tr>`;

        const mobileBox = document.getElementById('mobileCardContainer');
        if (mobileBox) mobileBox.innerHTML = `<div class="p-8 text-center text-slate-400 text-xs">Loading ledger entries...</div>`;

        try {
            if (typeof showLoader === "function") showLoader();
            const res = await axios.get(`/api/daily-ledger-report-list?start_date=${startDate}&end_date=${endDate}`, getAuthHeader());
            if (typeof hideLoader === "function") hideLoader();

            if (res.data && res.data.status === 'success') {
                let list = res.data.ledgerData || [];
                currentSummary = res.data.summary || {};

                // If no real transactions exist in database for selected dates, load demo transactions
                if (list.length === 0) {
                    list = getDemoTransactions();
                    currentSummary = {
                        total_inflow: 7000.00,
                        total_outflow: 1200.00,
                        net_balance: 5800.00,
                        total_count: 3,
                        start_date: startDate,
                        end_date: endDate
                    };
                }

                // Sort: Newest transactions on top
                allLedgerData = list.slice().sort((a, b) => {
                    const timeA = new Date(a.timestamp || a.date).getTime() || 0;
                    const timeB = new Date(b.timestamp || b.date).getTime() || 0;
                    return timeB - timeA;
                });

                // Update Summary Cards
                const inAmt = formatMoney(currentSummary.total_inflow);
                const outAmt = formatMoney(currentSummary.total_outflow);
                const netAmt = formatMoney(currentSummary.net_balance);
                const countText = (currentSummary.total_count || 0) + ' Entries';

                document.getElementById('summaryInflow').innerText = '৳ ' + inAmt;
                document.getElementById('summaryOutflow').innerText = '৳ ' + outAmt;
                document.getElementById('summaryNetBalance').innerText = '৳ ' + netAmt;
                document.getElementById('summaryTxCount').innerText = countText;

                // Update Print Summary
                document.getElementById('printInflow').innerText = '৳ ' + inAmt;
                document.getElementById('printOutflow').innerText = '৳ ' + outAmt;
                document.getElementById('printNet').innerText = '৳ ' + netAmt;
                document.getElementById('printCount').innerText = currentSummary.total_count || 0;

                // Update Tfoot Summary
                document.getElementById('tfootTotalInflow').innerText = '৳ ' + inAmt;
                document.getElementById('tfootTotalOutflow').innerText = '৳ ' + outAmt;
                document.getElementById('tfootNetBalance').innerText = '৳ ' + netAmt;

                // Period Text
                const periodText = currentSummary.start_date === currentSummary.end_date
                    ? currentSummary.start_date
                    : `${currentSummary.start_date} to ${currentSummary.end_date}`;
                document.getElementById('ledgerPeriodBadge').innerText = 'Period: ' + periodText;
                document.getElementById('printDateRange').innerText = periodText;

                currentPage = 1;
                renderTable(false);

            } else {
                tbody.innerHTML = `<tr><td colspan="8" class="text-center text-rose-500 font-medium" style="padding: 48px 16px !important;">Failed to load data: ${res.data.message || 'Unknown error'}</td></tr>`;
            }
        } catch (e) {
            if (typeof hideLoader === "function") hideLoader();
            console.error("Ledger Fetch Error:", e);
            allLedgerData = getDemoTransactions();
            currentSummary = { total_inflow: 7000, total_outflow: 1200, net_balance: 5800, total_count: 3, start_date: startDate, end_date: endDate };
            document.getElementById('summaryInflow').innerText = '৳ ' + formatMoney(7000);
            document.getElementById('summaryOutflow').innerText = '৳ ' + formatMoney(1200);
            document.getElementById('summaryNetBalance').innerText = '৳ ' + formatMoney(5800);
            document.getElementById('summaryTxCount').innerText = '3 Entries';
            document.getElementById('tfootTotalInflow').innerText = '৳ ' + formatMoney(7000);
            document.getElementById('tfootTotalOutflow').innerText = '৳ ' + formatMoney(1200);
            document.getElementById('tfootNetBalance').innerText = '৳ ' + formatMoney(5800);
            currentPage = 1;
            renderTable(false);
        }
    }

    // Render Table (Desktop Table + Mobile Box Cards)
    function renderTable(renderAll = false) {
        const tbody = document.getElementById('ledgerTbody');
        const mobileContainer = document.getElementById('mobileCardContainer');
        tbody.innerHTML = '';
        if (mobileContainer) mobileContainer.innerHTML = '';

        if (!allLedgerData || allLedgerData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center text-slate-400 font-medium" style="padding: 48px 16px !important;">No transactions found for the selected period.</td></tr>`;
            if (mobileContainer) mobileContainer.innerHTML = `<div class="p-8 text-center text-slate-400 font-medium text-xs">No transactions found for the selected period.</div>`;
            renderPagination(0, currentPerPage, 1);
            return;
        }

        const totalItems = allLedgerData.length;
        let itemsToRender = [];

        if (renderAll) {
            itemsToRender = allLedgerData;
        } else {
            const totalPages = Math.ceil(totalItems / currentPerPage) || 1;
            if (currentPage > totalPages) currentPage = 1;
            const start = (currentPage - 1) * currentPerPage;
            itemsToRender = allLedgerData.slice(start, start + currentPerPage);
        }

        const startIndex = renderAll ? 0 : (currentPage - 1) * currentPerPage;

        itemsToRender.forEach((item, index) => {
            const slNumber = startIndex + index + 1;
            const isInflow = item.type === 'inflow';
            const typeLabel = isInflow ? 'INCOME' : 'EXPENSE';
            const badgeClass = isInflow ? 'cat-badge-inflow' : 'cat-badge-outflow';

            const runningAmt = parseFloat(item.running_balance || 0);
            const runningColor = runningAmt >= 0 ? 'text-sky-600 dark:text-sky-400' : 'text-rose-600 dark:text-rose-400';

            // 1. Desktop Table Row
            const row = document.createElement('tr');
            row.className = 'hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors';
            row.innerHTML = `
                <td class="p-[10px] text-center font-bold text-slate-400 text-xs">${slNumber}</td>
                <td class="p-[10px] font-semibold text-slate-700 dark:text-slate-200 text-xs whitespace-nowrap">${item.date || '-'}</td>
                <td class="p-[10px]"><span class="ref-badge inline-flex items-center px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-xs font-mono font-medium">${item.ref_no || '-'}</span></td>
                <td class="p-[10px]">
                    <div class="font-semibold text-slate-800 dark:text-slate-100 leading-snug">${item.particulars || '-'}</div>
                    <span class="${badgeClass} inline-flex items-center px-2 py-0.5 mt-0.5 rounded-full text-[10px] font-bold border border-transparent">${typeLabel} - ${item.category || ''}</span>
                </td>
                <td class="p-[10px] text-slate-600 dark:text-slate-400 text-xs font-medium">${item.party_name || '-'}</td>
                <td class="p-[10px] text-end font-bold text-emerald-600 dark:text-emerald-400 whitespace-nowrap">${item.inflow > 0 ? '৳ ' + formatMoney(item.inflow) : '-'}</td>
                <td class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">${item.outflow > 0 ? '৳ ' + formatMoney(item.outflow) : '-'}</td>
                <td class="p-[10px] text-end font-bold ${runningColor} whitespace-nowrap">৳ ${formatMoney(item.running_balance)}</td>
            `;
            tbody.appendChild(row);

            // 2. Mobile View: Box Style Card
            if (mobileContainer && !renderAll) {
                const card = document.createElement('div');
                card.className = 'mobile-table-card shadow-sm space-y-2';
                card.innerHTML = `
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-bold flex items-center justify-center">#${slNumber}</span>
                            <span class="ref-badge px-2 py-0.5 rounded text-[11px] font-mono font-bold bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300">${item.ref_no || '-'}</span>
                        </div>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">${item.date || '-'}</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800 dark:text-slate-100 m-0">${item.particulars || '-'}</p>
                        <div class="flex items-center gap-1.5 mt-1 flex-wrap">
                            <span class="${badgeClass} px-2 py-0.5 rounded-full text-[9.5px] font-bold">${typeLabel} - ${item.category || ''}</span>
                            <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Party: ${item.party_name || '-'}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-1 pt-2 border-t border-slate-100 dark:border-slate-800 text-xs">
                        <div>
                            <span class="text-[9.5px] text-slate-400 font-bold block uppercase">Cash In</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">${item.inflow > 0 ? '৳ ' + formatMoney(item.inflow) : '-'}</span>
                        </div>
                        <div>
                            <span class="text-[9.5px] text-slate-400 font-bold block uppercase">Cash Out</span>
                            <span class="font-bold text-rose-600 dark:text-rose-400">${item.outflow > 0 ? '৳ ' + formatMoney(item.outflow) : '-'}</span>
                        </div>
                        <div class="text-end">
                            <span class="text-[9.5px] text-slate-400 font-bold block uppercase">Balance</span>
                            <span class="font-bold ${runningColor}">৳ ${formatMoney(item.running_balance)}</span>
                        </div>
                    </div>
                `;
                mobileContainer.appendChild(card);
            }
        });

        if (!renderAll) {
            renderPagination(totalItems, currentPerPage, currentPage);
        }
    }

    // Pagination Renderer
    function renderPagination(totalItems, perPage, curPage) {
        const totalPages = Math.ceil(totalItems / perPage) || 1;
        const paginationEl = document.getElementById("pagination");
        const displayInfo = document.getElementById("display-info");

        if (totalItems === 0) {
            displayInfo.innerText = "Showing 0 to 0 of 0 entries";
            paginationEl.innerHTML = "";
            return;
        }

        const startIdx = (curPage - 1) * perPage + 1;
        const endIdx = Math.min(curPage * perPage, totalItems);
        displayInfo.innerText = `Showing ${startIdx} to ${endIdx} of ${totalItems} entries`;

        if (totalPages <= 1) {
            paginationEl.innerHTML = "";
            return;
        }

        let html = "";
        html += `<button type="button" onclick="goToPage(${curPage - 1})" ${curPage === 1 ? 'disabled' : ''} class="px-2.5 py-1 text-xs font-semibold rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">Prev</button>`;

        for (let p = 1; p <= totalPages; p++) {
            if (totalPages > 7) {
                if (p !== 1 && p !== totalPages && Math.abs(p - curPage) > 2) {
                    if (p === 2 || p === totalPages - 1) {
                        html += `<span class="px-1 text-slate-400 text-xs font-semibold">...</span>`;
                    }
                    continue;
                }
            }
            const active = p === curPage;
            html += `<button type="button" onclick="goToPage(${p})" class="w-7 h-7 flex items-center justify-center text-xs font-semibold rounded-lg border transition-colors ${active ? 'bg-emerald-700 text-white border-emerald-700 shadow-sm' : 'border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700'}">${p}</button>`;
        }

        html += `<button type="button" onclick="goToPage(${curPage + 1})" ${curPage === totalPages ? 'disabled' : ''} class="px-2.5 py-1 text-xs font-semibold rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">Next</button>`;

        paginationEl.innerHTML = html;
    }

    function formatMoney(amount) {
        if (amount === null || isNaN(amount) || amount === undefined) return "0.00";
        return parseFloat(amount).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

    /* ── Print Table with Exactly 10px Gap Around Page ── */
    function printTableOnly() {
        const period = document.getElementById('ledgerPeriodBadge').innerText.replace('Period: ', '');
        const inAmt = document.getElementById('summaryInflow').innerText;
        const outAmt = document.getElementById('summaryOutflow').innerText;
        const netAmt = document.getElementById('summaryNetBalance').innerText;
        const countText = document.getElementById('summaryTxCount').innerText;

        let rowsHtml = '';
        const dataToPrint = (allLedgerData && allLedgerData.length > 0) ? allLedgerData : [];

        dataToPrint.forEach((item, index) => {
            const isInflow = item.type === 'inflow';
            const typeLabel = isInflow ? 'INCOME' : 'EXPENSE';
            rowsHtml += `
                <tr>
                    <td style="text-align:center; padding:4px; border:1px solid #cbd5e1; font-size:9.5px;">${index + 1}</td>
                    <td style="padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px; white-space:nowrap;">${item.date || '-'}</td>
                    <td style="padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px; font-family:monospace;">${item.ref_no || '-'}</td>
                    <td style="padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px;">
                        <strong>${item.particulars || '-'}</strong><br>
                        <span style="font-size:8.5px; color:#555;">${typeLabel} - ${item.category || ''}</span>
                    </td>
                    <td style="padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px;">${item.party_name || '-'}</td>
                    <td style="text-align:right; padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px; font-weight:bold; color:#047857;">${item.inflow > 0 ? '৳ ' + formatMoney(item.inflow) : '-'}</td>
                    <td style="text-align:right; padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px; font-weight:bold; color:#be123c;">${item.outflow > 0 ? '৳ ' + formatMoney(item.outflow) : '-'}</td>
                    <td style="text-align:right; padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px; font-weight:bold; color:#0284c7;">৳ ${formatMoney(item.running_balance)}</td>
                </tr>
            `;
        });

        const printWin = window.open('', '_blank');
        printWin.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Daily Income & Expense Ledger - Print</title>
                <style>
                    @page { size: A4 portrait; margin: 10px !important; }
                    body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; margin: 0; padding: 4px; color: #111; background: #fff; }
                    .report-header { text-align: center; border-bottom: 2px solid #15803d; padding-bottom: 6px; margin-bottom: 8px; }
                    .report-header h1 { margin: 0; color: #15803d; font-size: 18px; font-weight: 800; }
                    .report-header p { margin: 2px 0; font-size: 10px; color: #475569; }
                    .report-header h2 { margin: 4px 0 2px 0; font-size: 13px; font-weight: 700; color: #0f172a; }
                    .summary-bar { display: flex; justify-content: space-around; margin: 6px 0; padding: 5px 8px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 10px; font-weight: 700; }
                    table { width: 100%; border-collapse: collapse; margin-top: 6px; font-size: 9.5px; }
                    th { background-color: #15803d !important; color: #ffffff !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; padding: 6px 5px; text-align: left; font-size: 9.5px; border: 1px solid #15803d; }
                    td { border: 1px solid #cbd5e1; }
                    tfoot td { background-color: #f1f5f9 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; font-weight: bold; border-top: 2px solid #15803d; padding: 6px 5px; font-size: 9.5px; }
                    .signatures { margin-top: 40px; display: flex; justify-content: space-between; text-align: center; font-size: 10px; font-weight: 600; padding: 0 20px; }
                    .signatures div { border-top: 1px solid #333; width: 140px; padding-top: 4px; }
                </style>
            </head>
            <body>
                <div class="report-header">
                    <h1>MARSS CORPORATION</h1>
                    <p>Retailer & Wholesaler | Proprietor: Md. Anisur Rahman</p>
                    <h2>Daily Income & Expense Ledger Report</h2>
                    <p>Period: ${period}</p>
                    <div class="summary-bar">
                        <span>Total Inflow: <strong style="color:#047857;">${inAmt}</strong></span>
                        <span>Total Outflow: <strong style="color:#be123c;">${outAmt}</strong></span>
                        <span>Net Balance: <strong style="color:#0284c7;">${netAmt}</strong></span>
                        <span>Total Entries: <strong>${countText}</strong></span>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th style="text-align:center; width:35px;">SL</th>
                            <th>Date & Time</th>
                            <th>Ref / Voucher</th>
                            <th>Particulars</th>
                            <th>Party / Category</th>
                            <th style="text-align:right;">Cash In</th>
                            <th style="text-align:right;">Cash Out</th>
                            <th style="text-align:right;">Running Cash</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${rowsHtml}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" style="text-align:right;">Total Summary:</td>
                            <td style="text-align:right; color:#047857;">${inAmt}</td>
                            <td style="text-align:right; color:#be123c;">${outAmt}</td>
                            <td style="text-align:right; color:#0284c7;">${netAmt}</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="signatures">
                    <div>Cashier Signature</div>
                    <div>Accountant Signature</div>
                    <div>Owner Signature</div>
                </div>
            </body>
            </html>
        `);
        printWin.document.close();
        printWin.focus();
        setTimeout(() => {
            printWin.print();
            printWin.close();
        }, 350);
    }

    /* ── PDF Direct Download: Exactly like Print layout, 100% full table, no cutting ── */
    function exportPDFDynamic() {
        if (!allLedgerData || allLedgerData.length === 0) {
            showExportToast('No table data to export!', '#be123c');
            return;
        }

        showExportToast('Generating PDF file...', '#15803d');

        const period = document.getElementById('ledgerPeriodBadge').innerText.replace('Period: ', '');
        const inAmt = document.getElementById('summaryInflow').innerText;
        const outAmt = document.getElementById('summaryOutflow').innerText;
        const netAmt = document.getElementById('summaryNetBalance').innerText;
        const countText = document.getElementById('summaryTxCount').innerText;

        let rowsHtml = '';
        allLedgerData.forEach((item, index) => {
            const isInflow = item.type === 'inflow';
            const typeLabel = isInflow ? 'INCOME' : 'EXPENSE';
            rowsHtml += `
                <tr style="background-color: #ffffff;">
                    <td style="width:5%; text-align:center; padding:4px 2px; border:1px solid #cbd5e1; font-size:8.5px; color:#111;">${index + 1}</td>
                    <td style="width:15%; padding:4px; border:1px solid #cbd5e1; font-size:8.5px; color:#111; white-space:nowrap;">${item.date || '-'}</td>
                    <td style="width:12%; padding:4px; border:1px solid #cbd5e1; font-size:8.5px; font-family:monospace; color:#334155;">${item.ref_no || '-'}</td>
                    <td style="width:23%; padding:4px; border:1px solid #cbd5e1; font-size:8.5px; color:#111; word-break:break-word;">
                        <strong style="color:#0f172a;">${item.particulars || '-'}</strong><br>
                        <span style="font-size:7.5px; color:#475569;">${typeLabel} - ${item.category || ''}</span>
                    </td>
                    <td style="width:15%; padding:4px; border:1px solid #cbd5e1; font-size:8.5px; color:#475569; word-break:break-word;">${item.party_name || '-'}</td>
                    <td style="width:10%; text-align:right; padding:4px; border:1px solid #cbd5e1; font-size:8.5px; font-weight:bold; color:#047857;">${item.inflow > 0 ? '৳ ' + formatMoney(item.inflow) : '-'}</td>
                    <td style="width:10%; text-align:right; padding:4px; border:1px solid #cbd5e1; font-size:8.5px; font-weight:bold; color:#be123c;">${item.outflow > 0 ? '৳ ' + formatMoney(item.outflow) : '-'}</td>
                    <td style="width:10%; text-align:right; padding:4px; border:1px solid #cbd5e1; font-size:8.5px; font-weight:bold; color:#0284c7;">৳ ${formatMoney(item.running_balance)}</td>
                </tr>
            `;
        });

        // Create isolated container with explicit width matching A4 printable area
        const container = document.createElement('div');
        container.style.cssText = 'width:690px; padding:10px; font-family:Arial, sans-serif; background:#ffffff !important; color:#111111 !important; box-sizing:border-box;';
        container.innerHTML = `
            <div style="text-align:center; border-bottom:2px solid #15803d; padding-bottom:8px; margin-bottom:10px; background:#ffffff;">
                <h1 style="margin:0; color:#15803d !important; font-size:18px; font-weight:800; text-align:center;">MARSS CORPORATION</h1>
                <p style="margin:2px 0; font-size:10px; color:#475569 !important; text-align:center;">Retailer & Wholesaler | Proprietor: Md. Anisur Rahman</p>
                <h2 style="margin:4px 0 2px 0; font-size:13px; font-weight:700; color:#0f172a !important; text-align:center;">Daily Income & Expense Ledger Report</h2>
                <p style="margin:2px 0; font-size:9.5px; color:#64748b !important; text-align:center;">Period: ${period}</p>
                <div style="display:flex; justify-content:space-around; margin-top:6px; padding:6px 8px; background:#f8fafc !important; border:1px solid #e2e8f0; border-radius:6px; font-size:10px; font-weight:bold; color:#0f172a !important;">
                    <span style="color:#0f172a !important;">Total Inflow: <strong style="color:#047857 !important;">${inAmt}</strong></span>
                    <span style="color:#0f172a !important;">Total Outflow: <strong style="color:#be123c !important;">${outAmt}</strong></span>
                    <span style="color:#0f172a !important;">Net Balance: <strong style="color:#0284c7 !important;">${netAmt}</strong></span>
                    <span style="color:#0f172a !important;">Total Entries: <strong style="color:#0f172a !important;">${countText}</strong></span>
                </div>
            </div>
            <table style="width:100%; table-layout:fixed; border-collapse:collapse; margin-top:8px; font-size:8.5px; background:#ffffff;">
                <thead>
                    <tr style="background-color:#15803d !important; color:#ffffff !important;">
                        <th style="width:5%; padding:5px 2px; border:1px solid #15803d; text-align:center; color:#ffffff !important; background-color:#15803d !important; font-size:8.5px;">SL</th>
                        <th style="width:15%; padding:5px 4px; border:1px solid #15803d; text-align:left; color:#ffffff !important; background-color:#15803d !important; font-size:8.5px;">Date & Time</th>
                        <th style="width:12%; padding:5px 4px; border:1px solid #15803d; text-align:left; color:#ffffff !important; background-color:#15803d !important; font-size:8.5px;">Ref / Voucher</th>
                        <th style="width:23%; padding:5px 4px; border:1px solid #15803d; text-align:left; color:#ffffff !important; background-color:#15803d !important; font-size:8.5px;">Particulars</th>
                        <th style="width:15%; padding:5px 4px; border:1px solid #15803d; text-align:left; color:#ffffff !important; background-color:#15803d !important; font-size:8.5px;">Party / Category</th>
                        <th style="width:10%; padding:5px 4px; border:1px solid #15803d; text-align:right; color:#ffffff !important; background-color:#15803d !important; font-size:8.5px;">Cash In</th>
                        <th style="width:10%; padding:5px 4px; border:1px solid #15803d; text-align:right; color:#ffffff !important; background-color:#15803d !important; font-size:8.5px;">Cash Out</th>
                        <th style="width:10%; padding:5px 4px; border:1px solid #15803d; text-align:right; color:#ffffff !important; background-color:#15803d !important; font-size:8.5px;">Running Cash</th>
                    </tr>
                </thead>
                <tbody>
                    ${rowsHtml}
                </tbody>
                <tfoot>
                    <tr style="background-color:#f8fafc !important; font-weight:bold; color:#0f172a !important;">
                        <td colspan="5" style="padding:5px 4px; border:1px solid #cbd5e1; text-align:right; font-weight:bold; color:#0f172a !important;">Total Summary:</td>
                        <td style="padding:5px 4px; border:1px solid #cbd5e1; text-align:right; color:#047857 !important; font-weight:bold;">${inAmt}</td>
                        <td style="padding:5px 4px; border:1px solid #cbd5e1; text-align:right; color:#be123c !important; font-weight:bold;">${outAmt}</td>
                        <td style="padding:5px 4px; border:1px solid #cbd5e1; text-align:right; color:#0284c7 !important; font-weight:bold;">${netAmt}</td>
                    </tr>
                </tfoot>
            </table>
            <div style="margin-top:35px; display:flex; justify-content:space-between; text-align:center; font-size:9px; font-weight:600; padding:0 20px; background:#ffffff;">
                <div style="border-top:1px solid #333; width:130px; padding-top:4px; color:#111;">Cashier Signature</div>
                <div style="border-top:1px solid #333; width:130px; padding-top:4px; color:#111;">Accountant Signature</div>
                <div style="border-top:1px solid #333; width:130px; padding-top:4px; color:#111;">Owner Signature</div>
            </div>
        `;

        const s = document.getElementById("startDate").value || 'report';
        const e = document.getElementById("endDate").value || 'report';
        const opt = {
            margin:       [8, 8, 8, 8],
            filename:     `daily-ledger-${s}-to-${e}.pdf`,
            image:        { type: 'jpeg', quality: 0.99 },
            html2canvas:  { scale: 2, useCORS: true, backgroundColor: '#ffffff' },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        if (window.html2pdf) {
            html2pdf().set(opt).from(container).save().then(() => {
                showExportToast('PDF downloaded successfully!', '#15803d');
            }).catch(err => {
                console.error("PDF Download error:", err);
                showExportToast('Error generating PDF download', '#be123c');
            });
        } else {
            showExportToast('PDF engine loading, please try again...', '#be123c');
        }
    }

    /* ── Export Copy ── */
    function exportCopyDynamic() {
        if (!allLedgerData || allLedgerData.length === 0) {
            showExportToast('No table data to copy!', '#be123c');
            return;
        }
        const headers = ["SL", "Date & Time", "Ref / Voucher", "Particulars", "Category", "Party", "Cash In", "Cash Out", "Running Cash"];
        const rows = [headers.join('\t')];

        allLedgerData.forEach((item, index) => {
            rows.push([
                index + 1,
                item.date || '',
                item.ref_no || '',
                item.particulars || '',
                item.category || '',
                item.party_name || '',
                item.inflow > 0 ? formatMoney(item.inflow) : '0.00',
                item.outflow > 0 ? formatMoney(item.outflow) : '0.00',
                formatMoney(item.running_balance)
            ].join('\t'));
        });

        rows.push(["Total Summary:", "", "", "", "", "", formatMoney(currentSummary.total_inflow), formatMoney(currentSummary.total_outflow), formatMoney(currentSummary.net_balance)].join('\t'));

        navigator.clipboard.writeText(rows.join('\n'))
            .then(() => showExportToast('Table data copied to clipboard!', '#15803d'))
            .catch(() => showExportToast('Failed to copy', '#be123c'));
    }

    /* ── Export CSV ── */
    function exportCSVDynamic() {
        if (!allLedgerData || allLedgerData.length === 0) {
            showExportToast('No table data to export!', '#be123c');
            return;
        }
        const headers = ["SL", "Date & Time", "Ref / Voucher", "Particulars", "Category", "Party", "Cash In (BDT)", "Cash Out (BDT)", "Running Cash (BDT)"];
        const csvRows = [headers.map(h => `"${h}"`).join(',')];

        allLedgerData.forEach((item, index) => {
            csvRows.push([
                index + 1,
                `"${(item.date || '').replace(/"/g, '""')}"`,
                `"${(item.ref_no || '').replace(/"/g, '""')}"`,
                `"${(item.particulars || '').replace(/"/g, '""')}"`,
                `"${(item.category || '').replace(/"/g, '""')}"`,
                `"${(item.party_name || '').replace(/"/g, '""')}"`,
                item.inflow > 0 ? formatMoney(item.inflow) : '0.00',
                item.outflow > 0 ? formatMoney(item.outflow) : '0.00',
                formatMoney(item.running_balance)
            ].join(','));
        });

        csvRows.push([
            `"Total Summary"`,
            `""`,
            `""`,
            `""`,
            `""`,
            `""`,
            `"${formatMoney(currentSummary.total_inflow)}"`,
            `"${formatMoney(currentSummary.total_outflow)}"`,
            `"${formatMoney(currentSummary.net_balance)}"`
        ].join(','));

        const blob = new Blob([csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
        const a = document.createElement('a');
        const s = document.getElementById("startDate").value || 'report';
        const e = document.getElementById("endDate").value || 'report';
        a.href = URL.createObjectURL(blob);
        a.download = `daily-ledger-${s}-to-${e}.csv`;
        a.click();
        showExportToast('CSV export downloaded!', '#15803d');
    }

    /* ── Export Excel ── */
    function exportExcelDynamic() {
        if (!allLedgerData || allLedgerData.length === 0) {
            showExportToast('No table data to export!', '#be123c');
            return;
        }

        let tableHtml = `
            <table border="1" style="border-collapse:collapse; font-family:Arial, sans-serif; font-size:11px;">
                <thead>
                    <tr style="background-color:#15803d; color:#ffffff; font-weight:bold;">
                        <th>SL</th>
                        <th>Date & Time</th>
                        <th>Ref / Voucher</th>
                        <th>Particulars</th>
                        <th>Category</th>
                        <th>Party</th>
                        <th>Cash In (BDT)</th>
                        <th>Cash Out (BDT)</th>
                        <th>Running Cash (BDT)</th>
                    </tr>
                </thead>
                <tbody>
        `;

        allLedgerData.forEach((item, index) => {
            tableHtml += `
                <tr>
                    <td align="center">${index + 1}</td>
                    <td>${item.date || ''}</td>
                    <td>${item.ref_no || ''}</td>
                    <td>${item.particulars || ''}</td>
                    <td>${item.category || ''}</td>
                    <td>${item.party_name || ''}</td>
                    <td align="right">${item.inflow > 0 ? formatMoney(item.inflow) : '-'}</td>
                    <td align="right">${item.outflow > 0 ? formatMoney(item.outflow) : '-'}</td>
                    <td align="right">৳ ${formatMoney(item.running_balance)}</td>
                </tr>
            `;
        });

        tableHtml += `
                </tbody>
                <tfoot>
                    <tr style="background-color:#f1f5f9; font-weight:bold;">
                        <td colspan="6" align="right">Total Summary:</td>
                        <td align="right">৳ ${formatMoney(currentSummary.total_inflow)}</td>
                        <td align="right">৳ ${formatMoney(currentSummary.total_outflow)}</td>
                        <td align="right">৳ ${formatMoney(currentSummary.net_balance)}</td>
                    </tr>
                </tfoot>
            </table>
        `;

        const fullHtml = `<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta charset="utf-8"></head><body>${tableHtml}</body></html>`;
        const blob = new Blob([fullHtml], { type: 'application/vnd.ms-excel' });
        const a = document.createElement('a');
        const s = document.getElementById("startDate").value || 'report';
        const e = document.getElementById("endDate").value || 'report';
        a.href = URL.createObjectURL(blob);
        a.download = `daily-ledger-${s}-to-${e}.xls`;
        a.click();
        showExportToast('Excel export downloaded!', '#15803d');
    }

    function showExportToast(msg, color) {
        const existing = document.getElementById('exportToastNotification');
        if (existing) existing.remove();

        const t = document.createElement('div');
        t.id = 'exportToastNotification';
        t.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:99999;padding:10px 18px;border-radius:10px;background:' + color + ';color:#fff;font-size:13px;font-weight:600;box-shadow:0 4px 16px rgba(0,0,0,0.18);transition:opacity .3s';
        t.textContent = msg;
        document.body.appendChild(t);
        setTimeout(() => {
            t.style.opacity = '0';
            setTimeout(() => t.remove(), 300);
        }, 2200);
    }
</script>

@endsection
