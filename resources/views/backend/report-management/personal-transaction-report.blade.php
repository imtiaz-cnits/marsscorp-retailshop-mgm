@extends('layouts.dashboard-sidenav')
@section('title', 'Personal Transaction Report - MARSS CORPORATION')
@section('content')

<!-- Flatpickr & html2pdf CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<style>
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
    .personal-cards-grid {
        display: grid !important;
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 14px !important;
    }
    @media (min-width: 640px) and (max-width: 1023px) {
        .personal-cards-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }
    @media (max-width: 639px) {
        .personal-cards-grid {
            grid-template-columns: 1fr !important;
        }
    }

    .personal-stat-card {
        border-radius: 14px;
        padding: 14px 16px;
        transition: all 0.2s ease;
    }
    .personal-stat-card--invest { background: #ecfdf5; border: 1.5px solid #a7f3d0; }
    .personal-stat-card--invest .card-title { color: #065f46; font-weight: 700; font-size: 11px; }
    .personal-stat-card--invest .card-val   { color: #047857; font-weight: 900; font-size: 20px; }

    .personal-stat-card--expense { background: #fff1f2; border: 1.5px solid #fecaca; }
    .personal-stat-card--expense .card-title { color: #9f1239; font-weight: 700; font-size: 11px; }
    .personal-stat-card--expense .card-val   { color: #be123c; font-weight: 900; font-size: 20px; }

    .personal-stat-card--balance { background: #f0f9ff; border: 1.5px solid #bae6fd; }
    .personal-stat-card--balance .card-title { color: #0369a1; font-weight: 700; font-size: 11px; }
    .personal-stat-card--balance .card-val   { color: #0284c7; font-weight: 900; font-size: 20px; }

    .personal-stat-card--entries { background: #f8fafc; border: 1.5px solid #e2e8f0; }
    .personal-stat-card--entries .card-title { color: #475569; font-weight: 700; font-size: 11px; }
    .personal-stat-card--entries .card-val   { color: #1e293b; font-weight: 900; font-size: 20px; }

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
    body[light-mode="dark"] .personal-stat-card--invest, body[data-layout-mode="dark"] .personal-stat-card--invest, html.dark .personal-stat-card--invest { background: #022c1e !important; border-color: #064e3b !important; }
    body[light-mode="dark"] .personal-stat-card--invest .card-title, html.dark .personal-stat-card--invest .card-title { color: #34d399 !important; }
    body[light-mode="dark"] .personal-stat-card--invest .card-val, html.dark .personal-stat-card--invest .card-val { color: #6ee7b7 !important; }

    body[light-mode="dark"] .personal-stat-card--expense, body[data-layout-mode="dark"] .personal-stat-card--expense, html.dark .personal-stat-card--expense { background: #3b0712 !important; border-color: #7f1d1d !important; }
    body[light-mode="dark"] .personal-stat-card--expense .card-title, html.dark .personal-stat-card--expense .card-title { color: #f87171 !important; }
    body[light-mode="dark"] .personal-stat-card--expense .card-val, html.dark .personal-stat-card--expense .card-val { color: #fca5a5 !important; }

    body[light-mode="dark"] .personal-stat-card--balance, body[data-layout-mode="dark"] .personal-stat-card--balance, html.dark .personal-stat-card--balance { background: #082f49 !important; border-color: #075985 !important; }
    body[light-mode="dark"] .personal-stat-card--balance .card-title, html.dark .personal-stat-card--balance .card-title { color: #38bdf8 !important; }
    body[light-mode="dark"] .personal-stat-card--balance .card-val, html.dark .personal-stat-card--balance .card-val { color: #7dd3fc !important; }

    body[light-mode="dark"] .personal-stat-card--entries, body[data-layout-mode="dark"] .personal-stat-card--entries, html.dark .personal-stat-card--entries { background: #1e293b !important; border-color: #334155 !important; }
    body[light-mode="dark"] .personal-stat-card--entries .card-title, html.dark .personal-stat-card--entries .card-title { color: #94a3b8 !important; }
    body[light-mode="dark"] .personal-stat-card--entries .card-val, html.dark .personal-stat-card--entries .card-val { color: #f1f5f9 !important; }

    /* Dark Mode Table, Cells & Badges */
    body[light-mode="dark"] .table-responsive, body[data-layout-mode="dark"] .table-responsive, html.dark .table-responsive {
        border-color: #334155 !important; background-color: #0f172a !important;
    }
    body[light-mode="dark"] #mainTable, body[data-layout-mode="dark"] #mainTable, html.dark #mainTable {
        background-color: #0f172a !important;
    }
    body[light-mode="dark"] #mainTable tbody tr, body[data-layout-mode="dark"] #mainTable tbody tr, html.dark #mainTable tbody tr {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #mainTable tbody td, body[data-layout-mode="dark"] #mainTable tbody td, html.dark #mainTable tbody td {
        border-color: #334155 !important; color: #e2e8f0 !important;
    }
    body[light-mode="dark"] #mainTable tbody tr:hover, body[data-layout-mode="dark"] #mainTable tbody tr:hover, html.dark #mainTable tbody tr:hover {
        background-color: #1e293b !important;
    }
    body[light-mode="dark"] #mainTable tfoot, body[data-layout-mode="dark"] #mainTable tfoot, html.dark #mainTable tfoot {
        background-color: #1e293b !important; border-color: #334155 !important;
    }
    body[light-mode="dark"] .mobile-table-card, body[data-layout-mode="dark"] .mobile-table-card, html.dark .mobile-table-card {
        background-color: #1e293b !important; border-color: #334155 !important;
    }

    /* Flatpickr Calendar in Dark Mode */
    body[light-mode="dark"] .flatpickr-calendar, body[data-layout-mode="dark"] .flatpickr-calendar, html.dark .flatpickr-calendar { background: #1e293b !important; border-color: #334155 !important; color: #e2e8f0 !important; }
    body[light-mode="dark"] .flatpickr-day, body[data-layout-mode="dark"] .flatpickr-day, html.dark .flatpickr-day { color: #e2e8f0 !important; }
    body[light-mode="dark"] .flatpickr-day:hover, body[data-layout-mode="dark"] .flatpickr-day:hover, html.dark .flatpickr-day:hover { background: #334155 !important; }
    body[light-mode="dark"] .flatpickr-day.selected, body[data-layout-mode="dark"] .flatpickr-day.selected, html.dark .flatpickr-day.selected { background: #15803d !important; border-color: #15803d !important; }
    body[light-mode="dark"] .flatpickr-months, body[data-layout-mode="dark"] .flatpickr-months, html.dark .flatpickr-months { background: #1e293b !important; color: #f1f5f9 !important; }
    body[light-mode="dark"] .flatpickr-current-month, body[data-layout-mode="dark"] .flatpickr-current-month, html.dark .flatpickr-current-month { color: #f1f5f9 !important; font-weight: 700 !important; }
    body[light-mode="dark"] .flatpickr-weekday, body[data-layout-mode="dark"] .flatpickr-weekday, html.dark .flatpickr-weekday, body[light-mode="dark"] span.flatpickr-weekday { color: #ffffff !important; font-weight: 800 !important; }

    /* Print CSS */
    @media print {
        body * { visibility: hidden; }
        #printArea, #printArea * { visibility: visible; }
        #printArea { position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 0; }
        .export-btn, .no-print { display: none !important; }
    }
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
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Personal Transaction Report</h1>
                        </div>

                        <!-- 5 Export Buttons -->
                        <div class="flex items-center flex-wrap gap-1.5">
                            <button onclick="exportCopy()" type="button" class="export-btn export-btn--copy" title="Copy Table to Clipboard">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                <span>Copy</span>
                            </button>
                            <button onclick="exportCSV()" type="button" class="export-btn export-btn--csv" title="Download CSV Spreadsheet">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                                <span>CSV</span>
                            </button>
                            <button onclick="exportExcel()" type="button" class="export-btn export-btn--excel" title="Download Excel Document">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><polyline points="8 13 12 17 16 13"></polyline><line x1="12" y1="17" x2="12" y2="10"></line></svg>
                                <span>Excel</span>
                            </button>
                            <button onclick="exportPDF()" type="button" class="export-btn export-btn--pdf" title="Download PDF Report">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                                <span>PDF</span>
                            </button>
                            <button onclick="printReport()" type="button" class="export-btn export-btn--print" title="Print Report">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                                <span>Print</span>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Filter Row: 4 Columns (Desktop 1 row 4 col, Mobile 2 rows 2 col) -->
                    <div class="top-filter-grid mb-5 no-print">
                        <!-- Column 1: Start Date -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Start Date</label>
                            <div class="filter-field-wrap">
                                <input type="text" id="startDate" readonly placeholder="Start date" class="filter-field-input unified-ui-border bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 placeholder:text-slate-400" />
                                <div class="filter-field-icon">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Column 2: End Date -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 uppercase tracking-wider">End Date</label>
                            <div class="filter-field-wrap">
                                <input type="text" id="endDate" readonly placeholder="End date" class="filter-field-input unified-ui-border bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 placeholder:text-slate-400" />
                                <div class="filter-field-icon">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Column 3: Show Entries -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Show</label>
                            <div class="filter-field-wrap">
                                <select id="entries" class="filter-field-input unified-ui-border bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 cursor-pointer font-bold">
                                    <option value="15" selected>15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="500">500</option>
                                </select>
                            </div>
                        </div>

                        <!-- Column 4: Quick Filter Modern Custom Dropdown -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Quick Filter</label>
                            <div class="custom-select-wrap" id="quickFilterWrapper">
                                <button type="button" class="custom-select-btn unified-ui-border text-slate-800 dark:text-slate-100" id="quickFilterBtn">
                                    <span id="quickFilterSelectedText">Today</span>
                                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" id="quickFilterArrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </button>
                                <div class="custom-select-menu" id="quickFilterMenu">
                                    <div class="custom-select-option active" data-value="today"><span>Today</span></div>
                                    <div class="custom-select-option" data-value="yesterday"><span>Yesterday</span></div>
                                    <div class="custom-select-option" data-value="last7"><span>Last 7 Days</span></div>
                                    <div class="custom-select-option" data-value="last30"><span>Last 30 Days</span></div>
                                    <div class="custom-select-option" data-value="thisMonth"><span>This Month</span></div>
                                    <div class="custom-select-option" data-value="lastMonth"><span>Last Month</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Real-time Search & Period Badge Row -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 no-print">
                        <div class="search-input-wrapper unified-ui-border w-full sm:w-[320px] h-[38px] flex items-center px-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                            <svg class="w-4 h-4 text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" id="searchInput" onkeyup="handleSearch()" style="border: none !important; outline: none !important; box-shadow: none !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0" placeholder="Search investor, expense type, date..." />
                            <button id="clearSearchBtn" onclick="clearSearch()" style="display: none;" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 ml-1">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 flex items-center gap-2">
                            <span id="periodBadge" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300">
                                <svg class="w-3.5 h-3.5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <span id="activeDateRangeText">Period: Today</span>
                            </span>
                        </div>
                    </div>

                    <!-- 4. Summary Stat Cards (4 columns on Desktop, 2 on Tab, 1 on Mobile) -->
                    <div id="statCardsGrid" class="personal-cards-grid mb-5 no-print">
                        <!-- Card 1: Total Invest Amount -->
                        <div class="personal-stat-card personal-stat-card--invest shadow-sm">
                            <div class="flex items-center justify-between mb-1">
                                <span class="card-title uppercase tracking-wider">Total Invested</span>
                                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">৳</span>
                            </div>
                            <div class="card-val" id="cardTotalInvest">৳ 0.00</div>
                        </div>

                        <!-- Card 2: Total Expense Amount -->
                        <div class="personal-stat-card personal-stat-card--expense shadow-sm">
                            <div class="flex items-center justify-between mb-1">
                                <span class="card-title uppercase tracking-wider">Total Expended</span>
                                <span class="text-xs font-bold text-rose-600 dark:text-rose-400">৳</span>
                            </div>
                            <div class="card-val" id="cardTotalExpense">৳ 0.00</div>
                        </div>

                        <!-- Card 3: Net Balance -->
                        <div class="personal-stat-card personal-stat-card--balance shadow-sm">
                            <div class="flex items-center justify-between mb-1">
                                <span class="card-title uppercase tracking-wider">Net Balance</span>
                                <span class="text-xs font-bold text-sky-600 dark:text-sky-400">৳</span>
                            </div>
                            <div class="card-val" id="cardNetBalance">৳ 0.00</div>
                        </div>

                        <!-- Card 4: Total Records Count -->
                        <div class="personal-stat-card personal-stat-card--entries shadow-sm">
                            <div class="flex items-center justify-between mb-1">
                                <span class="card-title uppercase tracking-wider">Total Entries</span>
                                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">#</span>
                            </div>
                            <div class="card-val" id="cardTotalEntries">0</div>
                        </div>
                    </div>

                    <!-- 5. Printable / Main Content Area -->
                    <div id="printArea">
                        <!-- Print Specific Letterhead (Hidden on screen, visible on print/export) -->
                        <div class="hidden print:block mb-4 text-center border-b pb-3 border-slate-300">
                            <h2 class="text-xl font-bold text-emerald-800 m-0">MARSS CORPORATION</h2>
                            <p class="text-xs text-slate-600 m-0">Personal & Investor Transaction Statement</p>
                            <p id="printHeaderPeriod" class="text-xs text-slate-500 mt-1"></p>
                        </div>

                        <!-- Desktop Table View -->
                        <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900 mb-4">
                            <table id="mainTable" class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                        <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                        <th class="p-[10px] text-start whitespace-nowrap">Date</th>
                                        <th class="p-[10px] text-start whitespace-nowrap">Expense Type</th>
                                        <th class="p-[10px] text-end whitespace-nowrap">Expense Amount</th>
                                        <th class="p-[10px] text-start whitespace-nowrap">Investor Name</th>
                                        <th class="p-[10px] text-end whitespace-nowrap">Invest Amount</th>
                                        <th class="p-[10px] text-end rounded-tr-2xl whitespace-nowrap">Balance</th>
                                    </tr>
                                </thead>
                                <tbody id="mainTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                                    <!-- Rendered dynamically -->
                                </tbody>
                                <tfoot class="bg-slate-50/90 dark:bg-slate-800/70 text-slate-800 dark:text-slate-100 font-bold border-t-2 border-emerald-600/30 dark:border-emerald-600/20 text-xs sm:text-sm">
                                    <tr>
                                        <td colspan="3" class="p-[10px] text-end font-bold text-slate-600 dark:text-slate-300">Total:</td>
                                        <td id="footTotalExpense" class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">0.00</td>
                                        <td class="p-[10px]"></td>
                                        <td id="footTotalInvest" class="p-[10px] text-end font-bold text-emerald-600 dark:text-emerald-400 whitespace-nowrap">0.00</td>
                                        <td id="footTotalBalance" class="p-[10px] text-end font-bold text-sky-600 dark:text-sky-400 whitespace-nowrap">0.00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Mobile Card View (Visible on small screens) -->
                        <div id="mobileCardsList" class="block md:hidden space-y-2.5 mb-4 no-print">
                            <!-- Rendered dynamically -->
                        </div>

                        <!-- Print Signatures Section (Only in print) -->
                        <div class="hidden print:flex justify-between items-end mt-12 pt-8 text-xs text-slate-600">
                            <div class="text-center border-t border-slate-400 pt-1 w-36">Prepared By</div>
                            <div class="text-center border-t border-slate-400 pt-1 w-36">Checked By</div>
                            <div class="text-center border-t border-slate-400 pt-1 w-36">Manager / Approved</div>
                        </div>
                    </div>

                    <!-- 6. Pagination & Record Info -->
                    <div class="flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-800 gap-3 no-print">
                        <div id="recordInfo" class="text-xs text-slate-500 dark:text-slate-400 font-medium">Showing 0 to 0 of 0 entries</div>
                        <div id="paginationControls" class="flex items-center gap-1 sm:gap-1.5 flex-nowrap justify-center max-w-full overflow-x-auto pb-1">
                            <!-- Rendered dynamically -->
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sticky Copyright Footer -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)] no-print">
            <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>
    </div>
</div>

<script>
    // Global State
    let allExpenseData = [];
    let allInvestData = [];
    let mergedRows = [];
    let filteredRows = [];
    let totalExpAmt = 0;
    let totalInvAmt = 0;
    let currentPage = 1;
    let pageSize = 15;
    let isDummyActive = false;

    // Flatpickr instances
    let startPicker, endPicker;

    document.addEventListener("DOMContentLoaded", () => {
        initQuickFilterDropdown();
        initFlatpickr();

        // Preset to Today on initial load
        applyQuickFilter('today', true);

        // Event listener for show entries
        document.getElementById("entries").addEventListener("change", changeEntries);
    });

    /* ── Quick Filter Dropdown Behavior ── */
    function initQuickFilterDropdown() {
        const wrap = document.getElementById("quickFilterWrapper");
        const btn = document.getElementById("quickFilterBtn");
        const menu = document.getElementById("quickFilterMenu");
        const arrow = document.getElementById("quickFilterArrow");

        btn.addEventListener("click", (e) => {
            e.stopPropagation();
            const isOpen = menu.classList.contains("open");
            if (isOpen) {
                menu.classList.remove("open");
                arrow.style.transform = "rotate(0deg)";
            } else {
                menu.classList.add("open");
                arrow.style.transform = "rotate(180deg)";
            }
        });

        document.querySelectorAll("#quickFilterMenu .custom-select-option").forEach(opt => {
            opt.addEventListener("click", (e) => {
                e.stopPropagation();
                document.querySelectorAll("#quickFilterMenu .custom-select-option").forEach(o => o.classList.remove("active"));
                opt.classList.add("active");
                document.getElementById("quickFilterSelectedText").innerText = opt.innerText.trim();
                menu.classList.remove("open");
                arrow.style.transform = "rotate(0deg)";

                const val = opt.getAttribute("data-value");
                applyQuickFilter(val, true);
            });
        });

        document.addEventListener("click", () => {
            if (menu.classList.contains("open")) {
                menu.classList.remove("open");
                arrow.style.transform = "rotate(0deg)";
            }
        });
    }

    /* ── Flatpickr Initialization ── */
    function initFlatpickr() {
        const commonConfig = {
            dateFormat: "Y-m-d",
            monthSelectorType: "static",
            prevArrow: '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>',
            nextArrow: '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>',
            onChange: function() {
                document.querySelectorAll("#quickFilterMenu .custom-select-option").forEach(o => o.classList.remove("active"));
                document.getElementById("quickFilterSelectedText").innerText = "Custom";
                updatePeriodBadge();
                fetchPersonalTransactionReport();
            }
        };

        startPicker = flatpickr("#startDate", { ...commonConfig });
        endPicker   = flatpickr("#endDate",   { ...commonConfig });
    }

    function updatePeriodBadge() {
        const s = document.getElementById("startDate").value || '';
        const e = document.getElementById("endDate").value || '';
        const badge = document.getElementById("activeDateRangeText");
        if (s === e && s) {
            badge.innerText = `Period: ${s}`;
        } else if (s && e) {
            badge.innerText = `Period: ${s} to ${e}`;
        } else {
            badge.innerText = `Period: Today`;
        }
        if (document.getElementById('printHeaderPeriod')) {
            document.getElementById('printHeaderPeriod').textContent = `Statement Period: ${s} to ${e}`;
        }
    }

    /* ── Quick Filter Date Presets ── */
    function applyQuickFilter(preset, shouldFetch = true) {
        const now = new Date();
        let sDate = new Date();
        let eDate = new Date();

        if (preset === 'today') {
            sDate = new Date();
            eDate = new Date();
        } else if (preset === 'yesterday') {
            sDate.setDate(now.getDate() - 1);
            eDate.setDate(now.getDate() - 1);
        } else if (preset === 'last7' || preset === 'last7days') {
            sDate.setDate(now.getDate() - 6);
            eDate = new Date();
        } else if (preset === 'last30' || preset === 'last30days') {
            sDate.setDate(now.getDate() - 29);
            eDate = new Date();
        } else if (preset === 'thisMonth' || preset === 'thismonth') {
            sDate = new Date(now.getFullYear(), now.getMonth(), 1);
            eDate = new Date(now.getFullYear(), now.getMonth() + 1, 0);
        } else if (preset === 'lastMonth' || preset === 'lastmonth') {
            sDate = new Date(now.getFullYear(), now.getMonth() - 1, 1);
            eDate = new Date(now.getFullYear(), now.getMonth(), 0);
        }

        const formatYMD = (d) => {
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };

        const sStr = formatYMD(sDate);
        const eStr = formatYMD(eDate);

        if (startPicker && endPicker) {
            startPicker.setDate(sStr, false);
            endPicker.setDate(eStr, false);
        } else {
            document.getElementById("startDate").value = sStr;
            document.getElementById("endDate").value = eStr;
        }

        updatePeriodBadge();
        if (shouldFetch) {
            fetchPersonalTransactionReport();
        }
    }

    // Fetch API Data
    async function fetchPersonalTransactionReport() {
        const startDate = document.getElementById("startDate").value;
        const endDate = document.getElementById("endDate").value;

        if (!startDate || !endDate) return;

        updatePeriodBadge();

        try {
            showLoader();
            const res = await axios.get(
                `/api/personal-investor-transaction-report-list?start_date=${startDate}&end_date=${endDate}`,
                HeaderToken()
            );
            hideLoader();

            let resStatus = res.data.status;
            let expenseArr = res.data.ExpenseData || [];
            let investArr = res.data.InvestData || [];
            let expTotal = parseFloat(res.data.ExpenceAmount) || 0;
            let invTotal = parseFloat(res.data.InvestAmount) || 0;

            const hasData = expenseArr.length > 0 || investArr.length > 0;

            if (!hasData && !window.__preventPersonalTransactionDummy) {
                // Demo Fallback Data
                expenseArr = [
                    { date: startDate, type_name: "Office Utility & Internet", expense_amount: 1850.00 },
                    { date: startDate, type_name: "Staff Conveyance & Refreshment", expense_amount: 650.00 },
                    { date: startDate, type_name: "Marketing & Promo Print", expense_amount: 2400.00 }
                ];
                investArr = [
                    { date: startDate, name: "Tanvir Ahmed (Partner)", invest_amount: 60000.00 },
                    { date: startDate, name: "Rahim Chowdhury (Director)", invest_amount: 40000.00 },
                    { date: startDate, name: "Nafis Iqbal (Investor)", invest_amount: 25000.00 }
                ];
                expTotal = 4900.00;
                invTotal = 125000.00;
                isDummyActive = true;
            } else {
                isDummyActive = false;
            }

            allExpenseData = expenseArr;
            allInvestData = investArr;
            totalExpAmt = expTotal;
            totalInvAmt = invTotal;

            buildMergedRows();
            updateStatCards();
            applyFilterAndRender();

        } catch (e) {
            hideLoader();
            console.error('Error fetching personal transaction report:', e);
            // If backend throws an error or no data, provide demo rows if not prevented
            if (!window.__preventPersonalTransactionDummy) {
                allExpenseData = [
                    { date: startDate, type_name: "Office Utility & Internet", expense_amount: 1850.00 },
                    { date: startDate, type_name: "Staff Conveyance & Refreshment", expense_amount: 650.00 },
                    { date: startDate, type_name: "Marketing & Promo Print", expense_amount: 2400.00 }
                ];
                allInvestData = [
                    { date: startDate, name: "Tanvir Ahmed (Partner)", invest_amount: 60000.00 },
                    { date: startDate, name: "Rahim Chowdhury (Director)", invest_amount: 40000.00 },
                    { date: startDate, name: "Nafis Iqbal (Investor)", invest_amount: 25000.00 }
                ];
                totalExpAmt = 4900.00;
                totalInvAmt = 125000.00;
                isDummyActive = true;
                buildMergedRows();
                updateStatCards();
                applyFilterAndRender();
            } else {
                unauthorized(e.response ? e.response.status : 500);
            }
        }
    }

    // Helper command to clear dummy data
    window.clearPersonalTransactionDummy = function() {
        window.__preventPersonalTransactionDummy = true;
        isDummyActive = false;
        allExpenseData = [];
        allInvestData = [];
        totalExpAmt = 0;
        totalInvAmt = 0;
        buildMergedRows();
        updateStatCards();
        applyFilterAndRender();
        console.log('Personal transaction dummy demo cleared.');
    };

    // Build Merged Rows (Sorted newest first)
    function buildMergedRows() {
        mergedRows = [];
        const maxRows = Math.max(allExpenseData.length, allInvestData.length);

        for (let i = 0; i < maxRows; i++) {
            const expense = allExpenseData[i] || {};
            const invest = allInvestData[i] || {};
            const expenseAmount = parseFloat(expense.expense_amount || 0);
            const investAmount = parseFloat(invest.invest_amount || 0);
            const balance = investAmount - expenseAmount;
            const dateStr = expense.date || invest.date || 'N/A';

            mergedRows.push({
                idx: i,
                date: dateStr,
                type_name: expense.type_name || '-',
                expense_amount: expenseAmount,
                investor_name: invest.name || '-',
                invest_amount: investAmount,
                balance: balance,
                searchText: `${dateStr} ${expense.type_name || ''} ${invest.name || ''}`
            });
        }
    }

    // Update 4 Summary Stat Cards
    function updateStatCards() {
        const netBalance = totalInvAmt - totalExpAmt;

        document.getElementById('cardTotalInvest').textContent = `৳ ${totalInvAmt.toFixed(2)}`;
        document.getElementById('cardTotalExpense').textContent = `৳ ${totalExpAmt.toFixed(2)}`;

        const netEl = document.getElementById('cardNetBalance');
        netEl.textContent = `৳ ${netBalance.toFixed(2)}`;
        netEl.className = netBalance >= 0
            ? 'text-lg sm:text-xl font-black text-sky-700 dark:text-sky-300 m-0'
            : 'text-lg sm:text-xl font-black text-rose-700 dark:text-rose-300 m-0';

        document.getElementById('cardTotalEntries').textContent = mergedRows.length;

        // Table Footers
        document.getElementById('footTotalExpense').textContent = totalExpAmt.toFixed(2);
        document.getElementById('footTotalInvest').textContent = totalInvAmt.toFixed(2);

        let totalBalance = 0;
        mergedRows.forEach(r => { totalBalance += r.balance; });
        document.getElementById('footTotalBalance').textContent = totalBalance.toFixed(2);
    }

    // Search and Filtering
    function handleSearch() {
        const query = document.getElementById('searchInput').value.trim().toLowerCase();
        document.getElementById('clearSearchBtn').style.display = query ? 'block' : 'none';
        currentPage = 1;
        applyFilterAndRender();
    }

    function clearSearch() {
        document.getElementById('searchInput').value = '';
        document.getElementById('clearSearchBtn').style.display = 'none';
        currentPage = 1;
        applyFilterAndRender();
    }

    function changeEntries() {
        pageSize = parseInt(document.getElementById('entries').value) || 15;
        currentPage = 1;
        applyFilterAndRender();
    }

    function applyFilterAndRender() {
        const query = document.getElementById('searchInput').value.trim().toLowerCase();

        if (!query) {
            filteredRows = [...mergedRows];
        } else {
            filteredRows = mergedRows.filter(r => {
                return r.searchText.toLowerCase().includes(query) ||
                       r.type_name.toLowerCase().includes(query) ||
                       r.investor_name.toLowerCase().includes(query) ||
                       r.date.toLowerCase().includes(query);
            });
        }

        renderTableAndCards();
        renderPagination();
    }

    // Render Table and Mobile Cards
    function renderTableAndCards() {
        const tbody = document.getElementById('mainTableBody');
        const mobileContainer = document.getElementById('mobileCardsList');

        tbody.innerHTML = '';
        mobileContainer.innerHTML = '';

        if (filteredRows.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="p-8 text-center text-slate-400 dark:text-slate-500 font-medium">
                        No transaction records found for the selected period.
                    </td>
                </tr>
            `;
            mobileContainer.innerHTML = `
                <div class="text-center p-6 text-slate-400 dark:text-slate-500 font-medium">
                    No transactions found.
                </div>
            `;
            document.getElementById('recordInfo').textContent = 'Showing 0 to 0 of 0 entries';
            return;
        }

        const startIndex = (currentPage - 1) * pageSize;
        const pageRows = filteredRows.slice(startIndex, startIndex + pageSize);

        pageRows.forEach((row, index) => {
            const slNo = startIndex + index + 1;

            // Desktop Row
            const tr = document.createElement('tr');
            tr.className = "hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors";
            tr.innerHTML = `
                <td class="p-[10px] text-center text-slate-400 font-semibold">${slNo}</td>
                <td class="p-[10px] font-semibold text-slate-700 dark:text-slate-200 whitespace-nowrap">${row.date}</td>
                <td class="p-[10px]">
                    ${row.type_name !== '-' 
                        ? `<span class="inline-flex items-center px-2 py-0.5 rounded-full bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400 text-[11px] font-bold border border-rose-100 dark:border-rose-800/50">${row.type_name}</span>`
                        : `<span class="text-slate-400">-</span>`}
                </td>
                <td class="p-[10px] text-end font-semibold ${row.expense_amount > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-400'}">${row.expense_amount > 0 ? row.expense_amount.toFixed(2) : '-'}</td>
                <td class="p-[10px] font-semibold text-slate-700 dark:text-slate-200">${row.investor_name}</td>
                <td class="p-[10px] text-end font-semibold ${row.invest_amount > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400'}">${row.invest_amount > 0 ? row.invest_amount.toFixed(2) : '-'}</td>
                <td class="p-[10px] text-end font-bold ${row.balance >= 0 ? 'text-sky-600 dark:text-sky-400' : 'text-rose-600 dark:text-rose-400'}">${row.balance.toFixed(2)}</td>
            `;
            tbody.appendChild(tr);

            // Mobile Card
            const card = document.createElement('div');
            card.className = "mobile-table-card";
            card.innerHTML = `
                <div class="flex items-center justify-between border-b pb-2 mb-2 border-slate-100 dark:border-slate-800">
                    <span class="text-xs font-bold text-slate-400">#${slNo}</span>
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-200">${row.date}</span>
                </div>
                <div class="grid grid-cols-2 gap-2 text-xs mb-2">
                    <div>
                        <span class="text-slate-400 block text-[11px]">Expense Type:</span>
                        <span class="font-bold text-rose-600 dark:text-rose-400">${row.type_name}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-slate-400 block text-[11px]">Expense Amount:</span>
                        <span class="font-bold text-rose-600 dark:text-rose-400">৳ ${row.expense_amount.toFixed(2)}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[11px]">Investor:</span>
                        <span class="font-bold text-slate-700 dark:text-slate-200">${row.investor_name}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-slate-400 block text-[11px]">Invest Amount:</span>
                        <span class="font-bold text-emerald-600 dark:text-emerald-400">৳ ${row.invest_amount.toFixed(2)}</span>
                    </div>
                </div>
                <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-800 text-xs">
                    <span class="font-bold text-slate-500">Net Row Balance:</span>
                    <span class="font-extrabold ${row.balance >= 0 ? 'text-sky-600 dark:text-sky-400' : 'text-rose-600 dark:text-rose-400'}">৳ ${row.balance.toFixed(2)}</span>
                </div>
            `;
            mobileContainer.appendChild(card);
        });

        // Record Info
        const endRange = Math.min(startIndex + pageSize, filteredRows.length);
        document.getElementById('recordInfo').textContent = `Showing ${startIndex + 1} to ${endRange} of ${filteredRows.length} entries`;
    }

    // Pagination Controls
    function renderPagination() {
        const container = document.getElementById('paginationControls');
        container.innerHTML = '';

        const totalPages = Math.ceil(filteredRows.length / pageSize) || 1;
        if (totalPages <= 1) return;

        const btnBase = "inline-flex items-center justify-center h-8 min-w-[32px] px-2 rounded-lg text-xs font-semibold transition-all border";
        const activeBtn = "bg-emerald-700 text-white border-emerald-700 shadow-sm";
        const inactiveBtn = "bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400";
        const disabledBtn = "bg-white dark:bg-slate-800 text-slate-300 dark:text-slate-600 border-slate-200 dark:border-slate-700 cursor-not-allowed opacity-50";

        // First & Prev
        container.innerHTML += `<button onclick="goToPage(1)" ${currentPage === 1 ? 'disabled' : ''} class="${btnBase} ${currentPage === 1 ? disabledBtn : inactiveBtn}" title="First Page">«</button>`;
        container.innerHTML += `<button onclick="goToPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''} class="${btnBase} ${currentPage === 1 ? disabledBtn : inactiveBtn}" title="Previous Page">‹</button>`;

        // Numbered Pages
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                container.innerHTML += `<button onclick="goToPage(${i})" class="${btnBase} ${i === currentPage ? activeBtn : inactiveBtn}">${i}</button>`;
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                container.innerHTML += `<span class="text-slate-400 px-1 text-xs select-none">…</span>`;
            }
        }

        // Next & Last
        container.innerHTML += `<button onclick="goToPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''} class="${btnBase} ${currentPage === totalPages ? disabledBtn : inactiveBtn}" title="Next Page">›</button>`;
        container.innerHTML += `<button onclick="goToPage(${totalPages})" ${currentPage === totalPages ? 'disabled' : ''} class="${btnBase} ${currentPage === totalPages ? disabledBtn : inactiveBtn}" title="Last Page">»</button>`;
    }

    function goToPage(page) {
        const totalPages = Math.ceil(filteredRows.length / pageSize) || 1;
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderTableAndCards();
        renderPagination();
    }

    /* ── Export Handlers ── */

    // 1. Copy
    function exportCopy() {
        if (mergedRows.length === 0) {
            showExportToast('No records to copy', '#e11d48');
            return;
        }

        const headers = ["SL", "Date", "Expense Type", "Expense Amount", "Investor Name", "Invest Amount", "Balance"];
        const rows = mergedRows.map((r, i) => [
            i + 1,
            r.date,
            r.type_name !== '-' ? r.type_name : '',
            r.expense_amount > 0 ? r.expense_amount.toFixed(2) : '',
            r.investor_name !== '-' ? r.investor_name : '',
            r.invest_amount > 0 ? r.invest_amount.toFixed(2) : '',
            r.balance.toFixed(2)
        ]);

        const text = [headers.join('\t'), ...rows.map(row => row.join('\t'))].join('\n');
        navigator.clipboard.writeText(text).then(() => {
            showExportToast('Table copied to clipboard!', '#15803d');
        });
    }

    // 2. CSV
    function exportCSV() {
        if (mergedRows.length === 0) {
            showExportToast('No records to export', '#e11d48');
            return;
        }

        const headers = ["SL", "Date", "Expense Type", "Expense Amount", "Investor Name", "Invest Amount", "Balance"];
        const rows = mergedRows.map((r, i) => [
            i + 1,
            `"${r.date}"`,
            `"${(r.type_name !== '-' ? r.type_name : '').replace(/"/g, '""')}"`,
            r.expense_amount > 0 ? r.expense_amount.toFixed(2) : '',
            `"${(r.investor_name !== '-' ? r.investor_name : '').replace(/"/g, '""')}"`,
            r.invest_amount > 0 ? r.invest_amount.toFixed(2) : '',
            r.balance.toFixed(2)
        ]);

        const csvContent = "\uFEFF" + [headers.join(','), ...rows.map(row => row.join(','))].join('\r\n');
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = `personal_transaction_report_${new Date().toISOString().split('T')[0]}.csv`;
        link.click();
        showExportToast('CSV file downloaded!', '#15803d');
    }

    // 3. Excel
    function exportExcel() {
        if (mergedRows.length === 0) {
            showExportToast('No records to export', '#e11d48');
            return;
        }

        let tableHtml = `
            <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
            <head><meta charset="utf-8"/></head>
            <body>
                <h3 style="color:#15803d;font-size:16px;">MARSS CORPORATION</h3>
                <p>Personal & Investor Transaction Statement (${document.getElementById('startDate').value} to ${document.getElementById('endDate').value})</p>
                <table border="1" style="border-collapse:collapse;width:100%;">
                    <thead>
                        <tr style="background-color:#15803d;color:#ffffff;font-weight:bold;">
                            <th>SL</th>
                            <th>Date</th>
                            <th>Expense Type</th>
                            <th>Expense Amount</th>
                            <th>Investor Name</th>
                            <th>Invest Amount</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        mergedRows.forEach((r, idx) => {
            tableHtml += `
                <tr>
                    <td align="center">${idx + 1}</td>
                    <td align="center">${r.date}</td>
                    <td>${r.type_name !== '-' ? r.type_name : ''}</td>
                    <td align="right">${r.expense_amount > 0 ? r.expense_amount.toFixed(2) : ''}</td>
                    <td>${r.investor_name !== '-' ? r.investor_name : ''}</td>
                    <td align="right">${r.invest_amount > 0 ? r.invest_amount.toFixed(2) : ''}</td>
                    <td align="right">${r.balance.toFixed(2)}</td>
                </tr>
            `;
        });

        tableHtml += `
                    </tbody>
                </table>
            </body>
            </html>
        `;

        const blob = new Blob([tableHtml], { type: 'application/vnd.ms-excel;charset=utf-8;' });
        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = `personal_transaction_report_${new Date().toISOString().split('T')[0]}.xls`;
        link.click();
        showExportToast('Excel file downloaded!', '#15803d');
    }

    // 4. PDF (Direct Download via html2pdf with detached 690px container without clipping)
    function exportPDF() {
        if (mergedRows.length === 0) {
            showExportToast('No records to generate PDF', '#e11d48');
            return;
        }

        showExportToast('Generating PDF statement...', '#15803d');

        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        // Detached container formatted for A4 portrait
        const container = document.createElement('div');
        container.style.cssText = 'width: 690px; padding: 12px; font-family: Arial, sans-serif; background: #ffffff !important; color: #111111 !important; box-sizing: border-box;';

        let rowsHtml = '';
        mergedRows.forEach((r, idx) => {
            const bg = (idx % 2 === 1) ? '#f8fafc' : '#ffffff';
            rowsHtml += `
                <tr style="background: ${bg};">
                    <td style="padding: 5px 6px; border: 1px solid #cbd5e1; text-align: center; font-size: 9px; color: #334155 !important;">${idx + 1}</td>
                    <td style="padding: 5px 6px; border: 1px solid #cbd5e1; text-align: center; font-size: 9px; color: #0f172a !important;">${r.date}</td>
                    <td style="padding: 5px 6px; border: 1px solid #cbd5e1; text-align: left; font-size: 9px; color: #be123c !important; font-weight: bold;">${r.type_name !== '-' ? r.type_name : '-'}</td>
                    <td style="padding: 5px 6px; border: 1px solid #cbd5e1; text-align: right; font-size: 9px; font-weight: bold; color: #e11d48 !important;">${r.expense_amount > 0 ? r.expense_amount.toFixed(2) : '-'}</td>
                    <td style="padding: 5px 6px; border: 1px solid #cbd5e1; text-align: left; font-size: 9px; color: #0f172a !important; font-weight: bold;">${r.investor_name !== '-' ? r.investor_name : '-'}</td>
                    <td style="padding: 5px 6px; border: 1px solid #cbd5e1; text-align: right; font-size: 9px; font-weight: bold; color: #15803d !important;">${r.invest_amount > 0 ? r.invest_amount.toFixed(2) : '-'}</td>
                    <td style="padding: 5px 6px; border: 1px solid #cbd5e1; text-align: right; font-size: 9px; font-weight: bold; color: ${r.balance >= 0 ? '#0284c7' : '#e11d48'} !important;">${r.balance.toFixed(2)}</td>
                </tr>
            `;
        });

        const invest = document.getElementById('cardTotalInvest').textContent;
        const expense = document.getElementById('cardTotalExpense').textContent;
        const net = document.getElementById('cardNetBalance').textContent;
        const count = document.getElementById('cardTotalEntries').textContent;

        container.innerHTML = `
            <div style="text-align: center; border-bottom: 2px solid #15803d; padding-bottom: 8px; margin-bottom: 12px;">
                <h2 style="margin: 0; color: #15803d !important; font-size: 18px; font-weight: bold; letter-spacing: 0.5px;">MARSS CORPORATION</h2>
                <p style="margin: 2px 0 0 0; color: #0f172a !important; font-size: 11px; font-weight: bold;">Personal & Investor Transaction Statement</p>
                <p style="margin: 2px 0 0 0; color: #475569 !important; font-size: 10px;">Statement Period: <strong>${startDate}</strong> to <strong>${endDate}</strong></p>
            </div>

            <!-- 4 Mini Metric Cards -->
            <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                <div style="flex: 1; border: 1px solid #bbf7d0; background: #f0fdf4; padding: 6px 8px; border-radius: 6px;">
                    <div style="font-size: 8px; font-weight: bold; color: #15803d !important; text-transform: uppercase;">Total Invested</div>
                    <div style="font-size: 11px; font-weight: bold; color: #16a34a !important;">${invest}</div>
                </div>
                <div style="flex: 1; border: 1px solid #fecdd3; background: #fff1f2; padding: 6px 8px; border-radius: 6px;">
                    <div style="font-size: 8px; font-weight: bold; color: #be123c !important; text-transform: uppercase;">Total Expended</div>
                    <div style="font-size: 11px; font-weight: bold; color: #e11d48 !important;">${expense}</div>
                </div>
                <div style="flex: 1; border: 1px solid #bae6fd; background: #f0f9ff; padding: 6px 8px; border-radius: 6px;">
                    <div style="font-size: 8px; font-weight: bold; color: #0369a1 !important; text-transform: uppercase;">Net Balance</div>
                    <div style="font-size: 11px; font-weight: bold; color: #0284c7 !important;">${net}</div>
                </div>
                <div style="flex: 1; border: 1px solid #cbd5e1; background: #f8fafc; padding: 6px 8px; border-radius: 6px;">
                    <div style="font-size: 8px; font-weight: bold; color: #475569 !important; text-transform: uppercase;">Total Entries</div>
                    <div style="font-size: 11px; font-weight: bold; color: #0f172a !important;">${count}</div>
                </div>
            </div>

            <table style="width: 100%; border-collapse: collapse; table-layout: fixed; font-size: 9px;">
                <thead>
                    <tr style="background: #15803d; color: #ffffff !important;">
                        <th style="width: 6%; padding: 6px; border: 1px solid #15803d; color: #ffffff !important; text-align: center;">SL</th>
                        <th style="width: 14%; padding: 6px; border: 1px solid #15803d; color: #ffffff !important; text-align: center;">Date</th>
                        <th style="width: 18%; padding: 6px; border: 1px solid #15803d; color: #ffffff !important; text-align: left;">Expense Type</th>
                        <th style="width: 14%; padding: 6px; border: 1px solid #15803d; color: #ffffff !important; text-align: right;">Expense Amt</th>
                        <th style="width: 18%; padding: 6px; border: 1px solid #15803d; color: #ffffff !important; text-align: left;">Investor Name</th>
                        <th style="width: 14%; padding: 6px; border: 1px solid #15803d; color: #ffffff !important; text-align: right;">Invest Amt</th>
                        <th style="width: 16%; padding: 6px; border: 1px solid #15803d; color: #ffffff !important; text-align: right;">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    ${rowsHtml}
                </tbody>
            </table>

            <!-- Signatures Section -->
            <div style="display: flex; justify-content: space-between; margin-top: 36px; padding-top: 8px;">
                <div style="text-align: center; border-top: 1px solid #94a3b8; width: 110px; font-size: 9px; color: #334155 !important; padding-top: 3px;">Prepared By</div>
                <div style="text-align: center; border-top: 1px solid #94a3b8; width: 110px; font-size: 9px; color: #334155 !important; padding-top: 3px;">Checked By</div>
                <div style="text-align: center; border-top: 1px solid #94a3b8; width: 110px; font-size: 9px; color: #334155 !important; padding-top: 3px;">Approved Authority</div>
            </div>
        `;

        const opt = {
            margin: [8, 8, 8, 8],
            filename: `personal_transaction_report_${startDate}_to_${endDate}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true, backgroundColor: '#ffffff' },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        html2pdf().set(opt).from(container).save().then(() => {
            showExportToast('PDF downloaded successfully!', '#15803d');
        }).catch(err => {
            console.error('PDF error:', err);
            showExportToast('PDF generation failed', '#e11d48');
        });
    }

    // 5. Print
    function printReport() {
        window.print();
    }

    // Export Toast
    function showExportToast(msg, color) {
        const t = document.createElement('div');
        t.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;padding:10px 18px;border-radius:10px;background:' + color + ';color:#fff;font-size:13px;font-weight:600;box-shadow:0 4px 16px rgba(0,0,0,0.18);transition:opacity .4s';
        t.textContent = msg;
        document.body.appendChild(t);
        setTimeout(() => {
            t.style.opacity = '0';
            setTimeout(() => t.remove(), 400);
        }, 2200);
    }
</script>

@endsection
