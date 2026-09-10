@extends('layouts.dashboard-sidenav')
@section('title', 'Low Stock & Stock-Out Report - MARSS CORPORATION')
@section('content')
<style>
/* â”€â”€ Export Button Styles â”€â”€ */
.export-btn {
    display: inline-flex; align-items: center; gap: 5px;
    height: 32px; padding: 0 12px; border-radius: 8px;
    font-size: 11.5px; font-weight: 700; cursor: pointer;
    border: 1.5px solid transparent; transition: all 0.15s;
    white-space: nowrap; text-decoration: none;
}
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
/* Dark mode */
body[data-layout-mode="dark"] .export-btn--copy,
html.dark .export-btn--copy  { background:#1e293b; color:#94a3b8; border-color:#334155; }
body[data-layout-mode="dark"] .export-btn--csv,
html.dark .export-btn--csv   { background:#022c1e; color:#34d399; border-color:#064e3b; }
body[data-layout-mode="dark"] .export-btn--excel,
html.dark .export-btn--excel { background:#022c1e; color:#4ade80; border-color:#065f46; }
body[data-layout-mode="dark"] .export-btn--pdf,
html.dark .export-btn--pdf   { background:#3b0006; color:#f87171; border-color:#7f1d1d; }
body[data-layout-mode="dark"] .export-btn--print,
html.dark .export-btn--print { background:#0c1a3b; color:#60a5fa; border-color:#1e3a5f; }
@media print { .export-btn { display: none !important; } }
</style>

<!-- Hero Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-screen flex flex-col justify-between">
        <div class="data-table flex-grow">
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body">

                    <!-- 1. Page Title -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 dark:bg-rose-950/50 dark:text-rose-400 flex items-center justify-center border border-rose-100 dark:border-slate-700 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                    <line x1="12" y1="9" x2="12" y2="13"></line>
                                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Low Stock &amp; Stock-Out Report</h1>
                        </div>
                        <!-- Legend badges — number only inside brackets -->
                        <div class="flex items-center flex-wrap gap-2">
                            <span id="legendLowStock" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-50 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-800/60 text-amber-700 dark:text-amber-400 text-[11px] font-bold">
                                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                                Low Stock (0)
                            </span>
                            <span id="legendOutOfStock" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800/60 text-rose-700 dark:text-rose-400 text-[11px] font-bold">
                                <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                                Out of Stock (0)
                            </span>
                        </div>
                    </div>

                    <!-- 2. Summary Cards — 4col / 2col / 1col (CSS controlled) -->
                    <div id="summaryCards" class="summary-grid mb-5">
                        <div class="summary-card summary-card--amber">
                            <p class="summary-card__label">Low Stock Items</p>
                            <p id="summaryLowStock" class="summary-card__value" style="color:#92400e;">0 Products</p>
                        </div>
                        <div class="summary-card summary-card--rose">
                            <p class="summary-card__label" style="color:#be123c;">Out of Stock</p>
                            <p id="summaryOutOfStock" class="summary-card__value" style="color:#be123c;">0 Products</p>
                        </div>
                        <div class="summary-card summary-card--slate">
                            <p class="summary-card__label" style="color:#64748b;">Total Cost Value</p>
                            <p id="summaryCostValue" class="summary-card__value" style="color:#334155;">৳ 0.00</p>
                        </div>
                        <div class="summary-card summary-card--emerald">
                            <p class="summary-card__label" style="color:#065f46;">Total Sell Value</p>
                            <p id="summarySellValue" class="summary-card__value" style="color:#065f46;">৳ 0.00</p>
                        </div>
                    </div>

                    <!-- 3. Controls: Search + Show Entry -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2.5 mb-4">
                        <div class="flex items-center gap-2 w-full md:w-auto">
                            <!-- Search -->
                            <div class="search-input-wrapper control-border flex-1 md:w-[300px] lg:w-[380px] h-[38px] flex items-center px-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm transition-all">
                                <svg class="w-4 h-4 text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <input type="text" id="searchInput" class="search-bare-input w-full h-full bg-transparent text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal" placeholder="Search product or barcode..." />
                            </div>
                            <!-- Entries -->
                            <div class="control-border flex items-center gap-1 bg-white dark:bg-slate-800 px-3 h-[38px] rounded-xl shadow-sm flex-shrink-0 hover:border-emerald-500 transition-all">
                                <span class="text-[11px] uppercase tracking-wider font-bold text-slate-400">Show:</span>
                                <select id="entries" class="bg-transparent border-0 text-xs font-bold text-emerald-700 dark:text-emerald-400 focus:outline-none cursor-pointer py-1 pr-1">
                                    <option value="15" selected>15</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Desktop Table -->
                    <div class="control-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="tbl-th text-center w-[46px] rounded-tl-2xl">SL</th>
                                    <th class="tbl-th text-center w-[56px]">Img</th>
                                    <th class="tbl-th text-start">Product Name</th>
                                    <th class="tbl-th text-start">Barcode / Code</th>
                                    <th class="tbl-th text-start">Category</th>
                                    <th class="tbl-th text-center">Stock Qty</th>
                                    <th class="tbl-th text-end">Cost Price (৳)</th>
                                    <th class="tbl-th text-end">Sell Price (৳)</th>
                                    <th class="tbl-th text-center">Status</th>
                                    <th class="tbl-th text-center rounded-tr-2xl">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableList" class="divide-y divide-slate-100 dark:divide-slate-700/60 text-sm text-slate-700 dark:text-slate-200"></tbody>
                            <tfoot class="bg-slate-50 dark:bg-slate-800/80 font-bold border-t-2 border-emerald-600/30 dark:border-emerald-700/40 text-xs sm:text-sm">
                                <tr>
                                    <td colspan="5" class="tbl-td text-end font-bold text-slate-600 dark:text-slate-300">Total Low Stock Qty:</td>
                                    <td id="totalQuantity" class="tbl-td text-center font-bold text-rose-600 dark:text-rose-400">0</td>
                                    <td id="totalCostPrice" class="tbl-td text-end font-bold text-slate-700 dark:text-slate-100">৳ 0.00</td>
                                    <td id="totalSellingPrice" class="tbl-td text-end font-bold text-emerald-600 dark:text-emerald-400">৳ 0.00</td>
                                    <td colspan="2" class="tbl-td"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- 5. Mobile Cards -->
                    <div id="mobileCardList" class="block md:hidden mb-3 space-y-3"></div>

                    <!-- 6. Pagination -->
                    <div class="flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-700/60 gap-3">
                        <div id="display-info" class="text-xs text-slate-500 dark:text-slate-400 font-medium"></div>
                        <div id="pagination" class="flex items-center gap-1 flex-nowrap justify-center max-w-full overflow-x-auto pb-1"></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sticky Copyright -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-700 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)]">
            <footer class="text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>
    </div>
</div>

<style>
    /* ── Card body padding ── */
    .product-card-body { padding: 16px; }
    @media (min-width: 640px)  { .product-card-body { padding: 24px; } }
    @media (min-width: 1024px) { .product-card-body { padding: 32px; } }

    /* ══════════════════════════════════════════
       SUMMARY CARDS GRID — 4col / 2col / 1col
    ══════════════════════════════════════════ */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }
    @media (max-width: 1023px) {
        .summary-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 639px) {
        .summary-grid { grid-template-columns: 1fr; }
    }

    /* Summary card base */
    .summary-card {
        border-radius: 12px;
        padding: 14px;
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
    }
    .summary-card__label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 6px;
        margin-top: 0;
    }
    .summary-card__value {
        font-size: 1.2rem;
        font-weight: 700;
        margin: 0;
    }

    /* Light mode card variants */
    .summary-card--amber { border-color: #fde68a; background: #fffbeb; }
    .summary-card--amber .summary-card__label { color: #b45309; }
    .summary-card--amber .summary-card__value { color: #92400e; }

    .summary-card--rose  { border-color: #fecaca; background: #fff1f2; }
    .summary-card--rose  .summary-card__label { color: #be123c; }
    .summary-card--rose  .summary-card__value { color: #be123c; }

    .summary-card--slate { border-color: #e2e8f0; background: #f8fafc; }
    .summary-card--slate .summary-card__label { color: #64748b; }
    .summary-card--slate .summary-card__value { color: #334155; }

    .summary-card--emerald { border-color: #a7f3d0; background: #ecfdf5; }
    .summary-card--emerald .summary-card__label { color: #065f46; }
    .summary-card--emerald .summary-card__value { color: #065f46; }

    /* Dark mode card variants */
    body[data-layout-mode="dark"] .summary-card,
    html.dark .summary-card {
        background: #1e293b;
        border-color: #334155 !important;
    }
    body[data-layout-mode="dark"] .summary-card--amber,
    html.dark .summary-card--amber { border-color: #78350f !important; background: #1c1008 !important; }
    body[data-layout-mode="dark"] .summary-card--amber .summary-card__label,
    html.dark .summary-card--amber .summary-card__label { color: #fbbf24 !important; }
    body[data-layout-mode="dark"] .summary-card--amber .summary-card__value,
    html.dark .summary-card--amber .summary-card__value { color: #fde68a !important; }

    body[data-layout-mode="dark"] .summary-card--rose,
    html.dark .summary-card--rose { border-color: #7f1d1d !important; background: #1c0606 !important; }
    body[data-layout-mode="dark"] .summary-card--rose .summary-card__label,
    html.dark .summary-card--rose .summary-card__label { color: #f87171 !important; }
    body[data-layout-mode="dark"] .summary-card--rose .summary-card__value,
    html.dark .summary-card--rose .summary-card__value { color: #fca5a5 !important; }

    body[data-layout-mode="dark"] .summary-card--slate,
    html.dark .summary-card--slate { border-color: #334155 !important; background: #1e293b !important; }
    body[data-layout-mode="dark"] .summary-card--slate .summary-card__label,
    html.dark .summary-card--slate .summary-card__label { color: #94a3b8 !important; }
    body[data-layout-mode="dark"] .summary-card--slate .summary-card__value,
    html.dark .summary-card--slate .summary-card__value { color: #e2e8f0 !important; }

    body[data-layout-mode="dark"] .summary-card--emerald,
    html.dark .summary-card--emerald { border-color: #064e3b !important; background: #022c1e !important; }
    body[data-layout-mode="dark"] .summary-card--emerald .summary-card__label,
    html.dark .summary-card--emerald .summary-card__label { color: #34d399 !important; }
    body[data-layout-mode="dark"] .summary-card--emerald .summary-card__value,
    html.dark .summary-card--emerald .summary-card__value { color: #6ee7b7 !important; }

    /* ── Control border (inputs, table wrapper) ── */
    .control-border {
        border: 1.5px solid #cbd5e1 !important;
    }
    body[data-layout-mode="dark"] .control-border,
    html.dark .control-border {
        border-color: #475569 !important;
    }

    /* ── Search input reset ── */
    .search-bare-input {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }
    .search-input-wrapper:focus-within {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21,128,61,0.18) !important;
    }

    /* ── Table cell padding ── */
    .tbl-th { padding: 10px 12px !important; white-space: nowrap !important; }
    .tbl-td { padding: 10px 12px !important; }

    /* ── Product Name column: wrap after ~2 words ── */
    .col-product-name {
        max-width: 160px;
        word-break: break-word;
        white-space: normal !important;
        line-height: 1.4;
    }

    /* ── Action button: square shape ── */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        padding: 0 8px;
        border-radius: 8px;
        background: #15803d;
        color: #ffffff;
        transition: background 0.15s, transform 0.1s;
        flex-shrink: 0;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }
    .action-btn:hover { background: #16a34a; }
    .action-btn:active { transform: scale(0.95); }

    /* ── Product image: fix border color in dark mode ── */
    .product-img {
        width: 32px;
        height: 32px;
        object-fit: contain;
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
        padding: 2px;
        display: block;
        margin: 0 auto;
    }
    body[data-layout-mode="dark"] .product-img,
    html.dark .product-img {
        border-color: #334155 !important;
        background: #1e293b;
    }

    /* ── Table tbody divider + row hover ── */
    #printTable tbody tr:hover td {
        background-color: #f8fafc !important;
    }
    body[data-layout-mode="dark"] #printTable tbody tr:hover td,
    html.dark #printTable tbody tr:hover td {
        background-color: #1e293b !important;
    }

    /* ── Table border lines in dark mode ── */
    body[data-layout-mode="dark"] #printTable tbody tr,
    html.dark #printTable tbody tr {
        border-color: #334155 !important;
    }

    /* ── Card dark mode ── */
    body[data-layout-mode="dark"] .card,
    html.dark .card {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[data-layout-mode="dark"] #printTable,
    html.dark #printTable {
        background-color: #0f172a !important;
    }
    body[data-layout-mode="dark"] #printTable tfoot,
    html.dark #printTable tfoot {
        background-color: #1e293b !important;
    }
    .data-table { background: transparent !important; }

    /* ── Pagination button base ── */
    .pg-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 34px;
        min-width: 34px;
        padding: 0 10px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.15s ease;
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        color: #475569;
        cursor: pointer;
        user-select: none;
    }
    body[data-layout-mode="dark"] .pg-btn,
    html.dark .pg-btn,
    body[light-mode="dark"] .pg-btn {
        background: #1e293b;
        color: #94a3b8;
        border-color: #334155;
    }
    .pg-btn:hover:not(:disabled):not(.pg-active) {
        background: #f0fdf4;
        border-color: #16a34a;
        color: #15803d;
    }
    body[data-layout-mode="dark"] .pg-btn:hover:not(:disabled):not(.pg-active),
    html.dark .pg-btn:hover:not(:disabled):not(.pg-active),
    body[light-mode="dark"] .pg-btn:hover:not(:disabled):not(.pg-active) {
        background: #052e16;
        border-color: #16a34a;
        color: #4ade80;
    }
    .pg-btn.pg-active {
        background: #15803d;
        color: #ffffff;
        border-color: #15803d;
        box-shadow: 0 1px 4px rgba(21,128,61,0.30);
    }
    .pg-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }
    .pg-ellipsis {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 34px;
        min-width: 24px;
        font-size: 0.75rem;
        color: #94a3b8;
    }

    /* ── Out-of-stock status badge — light red bg, single line ── */
    .badge-out { background:#fee2e2; color:#b91c1c; border:1px solid #fecaca; white-space:nowrap; }
    body[data-layout-mode="dark"] .badge-out,
    html.dark .badge-out,
    body[light-mode="dark"] .badge-out { background:#3b0000; color:#f87171; border-color:#7f1d1d; }
    .badge-low { background:#fef3c7; color:#b45309; border:1px solid #fde68a; white-space:nowrap; }
    body[data-layout-mode="dark"] .badge-low,
    html.dark .badge-low,
    body[light-mode="dark"] .badge-low { background:#27180a; color:#fbbf24; border-color:#78350f; }
</style>

<script>
    let allProductData = [];
    let currentPage    = 1;

    // ── BD currency separator (1,00,000.00) ──
    function bdFormat(amount) {
        const num = parseFloat(amount) || 0;
        const [intPart, decPart] = num.toFixed(2).split('.');
        let last3 = intPart.slice(-3);
        let rest   = intPart.slice(0, -3);
        let formatted = rest.length > 0
            ? rest.replace(/\B(?=(\d{2})+(?!\d))/g, ',') + ',' + last3
            : last3;
        return formatted + '.' + decPart;
    }

    document.addEventListener("DOMContentLoaded", () => {
        fetchInvoiceReport();
        document.getElementById("entries").addEventListener("change", () => { currentPage = 1; renderTable(); });
        document.getElementById("searchInput").addEventListener("keyup",  () => { currentPage = 1; renderTable(); });
    });

    async function fetchInvoiceReport() { await getList(); }

    async function getList() {
        try {
            showLoader();
            const res = await axios.get("/api/stock-out-product-list", HeaderToken());
            hideLoader();

            if (res.data.status !== 'success') {
                console.error('Error fetching product data:', res.data.message);
                return;
            }

            // Filter: qty <= 10
            allProductData = (res.data.ProductData || []).filter(item => parseFloat(item.quantity || 0) <= 10);

            // Summary cards
            const outOfStock = allProductData.filter(i => parseFloat(i.quantity || 0) <= 0).length;
            const lowStock   = allProductData.filter(i => parseFloat(i.quantity || 0) > 0).length;
            let totalCost = 0, totalSell = 0;
            allProductData.forEach(i => {
                totalCost += parseFloat(i.cost_price || 0);
                totalSell += parseFloat(i.sell_price || 0);
            });

            document.getElementById('summaryLowStock').textContent   = lowStock + ' Products';
            document.getElementById('summaryOutOfStock').textContent = outOfStock + ' Products';
            document.getElementById('summaryCostValue').textContent  = '৳ ' + bdFormat(totalCost);
            document.getElementById('summarySellValue').textContent  = '৳ ' + bdFormat(totalSell);

            // Legend badges — number only
            document.getElementById('legendLowStock').childNodes[2].textContent = ' Low Stock (' + lowStock + ')';
            document.getElementById('legendOutOfStock').childNodes[2].textContent = ' Out of Stock (' + outOfStock + ')';

            currentPage = 1;
            renderTable();
        } catch (e) {
            hideLoader();
            console.error('Error:', e.message || e);
        }
    }

    function renderTable() {
        const search  = document.getElementById("searchInput").value.toLowerCase();
        const perPage = parseInt(document.getElementById("entries").value) || 15;

        const filtered = allProductData.filter(item =>
            (item.product_name || '').toLowerCase().includes(search) ||
            (formatProductCode(item.product_code) || '').toLowerCase().includes(search) ||
            ((item.category && item.category.category_name) || '').toLowerCase().includes(search)
        );

        const total      = filtered.length;
        const totalPages = Math.ceil(total / perPage) || 1;
        if (currentPage > totalPages) currentPage = 1;
        const start    = (currentPage - 1) * perPage;
        const pageData = filtered.slice(start, start + perPage);

        // Footer totals from full filtered set
        let totalQty = 0, totalCostAmt = 0, totalSellAmt = 0;
        filtered.forEach(item => {
            totalQty     += parseFloat(item.quantity || 0);
            totalCostAmt += parseFloat(item.cost_price || 0);
            totalSellAmt += parseFloat(item.sell_price || 0);
        });

        // ── Desktop Table ──
        const tbody = document.getElementById('tableList');
        tbody.innerHTML = '';

        if (pageData.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="10" class="tbl-td text-center py-10">
                        <div class="flex flex-col items-center gap-2 text-emerald-600 dark:text-emerald-400">
                            <svg class="w-10 h-10 opacity-60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="font-bold text-sm">All products have sufficient stock!</p>
                            <p class="text-xs text-slate-400">No products with stock ≤ 10 found.</p>
                        </div>
                    </td>
                </tr>`;
        } else {
            pageData.forEach((item, index) => {
                const img_url      = item.img_url ? item.img_url : "{{ asset('backend/assets/img/product-img.svg') }}";
                const qtyNum       = parseFloat(item.quantity) || 0;
                const unitName     = item.unit ? (item.unit.unit_name || item.unit.name || 'pcs') : 'pcs';
                const categoryName = item.category ? item.category.category_name : 'N/A';
                const isOut        = qtyNum <= 0;
                const qtyColor     = isOut ? 'text-rose-600 dark:text-rose-400' : 'text-amber-600 dark:text-amber-400';

                // Status badge — single line, halka red for out-of-stock
                const statusBadge = isOut
                    ? `<span class="badge-out inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-rose-500 flex-shrink-0"></span>Out of Stock</span>`
                    : `<span class="badge-low inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-amber-400 flex-shrink-0"></span>Low Stock</span>`;

                // Action — icon only, square shape via .action-btn
                const actionBtn = `
                    <a href="/admin-dashboard-Purchase" title="Purchase Stock" class="action-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </a>`;

                tbody.innerHTML += `
                    <tr class="tbl-row">
                        <td class="tbl-td text-center text-slate-400 font-semibold">${start + index + 1}</td>
                        <td class="tbl-td text-center">
                            <img src="${img_url}" alt="${item.product_name}" class="product-img" loading="lazy" />
                        </td>
                        <td class="tbl-td col-product-name font-semibold text-slate-800 dark:text-slate-100">${item.product_name}</td>
                        <td class="tbl-td">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[11px] font-mono border border-slate-200 dark:border-slate-700">${formatProductCode(item.product_code)}</span>
                        </td>
                        <td class="tbl-td text-slate-600 dark:text-slate-400">${categoryName}</td>
                        <td class="tbl-td text-center font-bold ${qtyColor}">${qtyNum} ${unitName}</td>
                        <td class="tbl-td text-end font-semibold text-rose-600 dark:text-rose-400">৳ ${bdFormat(item.cost_price)}</td>
                        <td class="tbl-td text-end font-semibold text-emerald-600 dark:text-emerald-400">৳ ${bdFormat(item.sell_price)}</td>
                        <td class="tbl-td text-center">${statusBadge}</td>
                        <td class="tbl-td text-center">${actionBtn}</td>
                    </tr>`;
            });
        }

        // Footer totals
        document.getElementById('totalQuantity').textContent     = totalQty;
        document.getElementById('totalCostPrice').textContent    = '৳ ' + bdFormat(totalCostAmt);
        document.getElementById('totalSellingPrice').textContent = '৳ ' + bdFormat(totalSellAmt);

        // ── Mobile Cards ──
        const mobileList = document.getElementById('mobileCardList');
        mobileList.innerHTML = '';
        pageData.forEach((item, index) => {
            const qtyNum  = parseFloat(item.quantity) || 0;
            const unit    = item.unit ? (item.unit.unit_name || item.unit.name || 'pcs') : 'pcs';
            const catName = item.category ? item.category.category_name : 'N/A';
            const isOut   = qtyNum <= 0;
            const imgSrc  = item.img_url ? item.img_url : "{{ asset('backend/assets/img/product-img.svg') }}";
            mobileList.innerHTML += `
                <div class="control-border rounded-xl p-3 bg-white dark:bg-slate-900 shadow-sm flex gap-3">
                    <img src="${imgSrc}" alt="${item.product_name}" class="w-12 h-12 rounded-lg object-contain border border-slate-100 dark:border-slate-700 flex-shrink-0 p-0.5" />
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-1 mb-1">
                            <p class="font-bold text-sm text-slate-800 dark:text-slate-100 truncate">${item.product_name}</p>
                            <span class="text-xs font-bold ${isOut ? 'text-rose-600' : 'text-amber-600'} flex-shrink-0">${qtyNum} ${unit}</span>
                        </div>
                        <p class="text-xs text-slate-400 mb-1.5">${catName} &bull; <span class="font-mono">${formatProductCode(item.product_code)}</span></p>
                        <div class="flex items-center justify-between">
                            <div class="flex gap-2 text-xs">
                                <span class="text-rose-600 font-semibold">Cost: ৳ ${bdFormat(item.cost_price)}</span>
                                <span class="text-emerald-600 font-semibold">Sell: ৳ ${bdFormat(item.sell_price)}</span>
                            </div>
                            <a href="/admin-dashboard-Purchase" title="Purchase"
                               class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-700 hover:bg-emerald-600 text-white">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>`;
        });

        // Display info
        document.getElementById('display-info').innerHTML = total > 0
            ? `<span class="text-xs text-slate-500 dark:text-slate-400">Showing <strong class="text-slate-700 dark:text-slate-200">${start + 1}–${Math.min(start + perPage, total)}</strong> of <strong class="text-slate-700 dark:text-slate-200">${total}</strong> products</span>`
            : `<span class="text-xs text-slate-400">No low/out-of-stock products found</span>`;

        renderPagination(totalPages);
    }

    // ── Pagination — same style as product list ──
    function renderPagination(totalPages) {
        const container = document.getElementById('pagination');
        container.innerHTML = '';
        if (totalPages <= 1) return;

        // Prev
        const prevBtn = document.createElement('button');
        prevBtn.className = 'pg-btn' + (currentPage === 1 ? '' : '');
        prevBtn.innerHTML = '&lsaquo;';
        prevBtn.disabled  = currentPage === 1;
        prevBtn.onclick   = () => goPage(currentPage - 1);
        container.appendChild(prevBtn);

        // Page numbers with ellipsis
        let pagesToShow = new Set();
        pagesToShow.add(1);
        pagesToShow.add(totalPages);
        for (let i = Math.max(2, currentPage - 1); i <= Math.min(totalPages - 1, currentPage + 1); i++) {
            pagesToShow.add(i);
        }
        const sorted = [...pagesToShow].sort((a, b) => a - b);

        let prev = 0;
        sorted.forEach(p => {
            if (p - prev > 1) {
                const ellipsis = document.createElement('span');
                ellipsis.className = 'pg-ellipsis';
                ellipsis.textContent = '…';
                container.appendChild(ellipsis);
            }
            const btn = document.createElement('button');
            btn.className = 'pg-btn' + (p === currentPage ? ' pg-active' : '');
            btn.textContent = p;
            btn.onclick = () => goPage(p);
            container.appendChild(btn);
            prev = p;
        });

        // Next
        const nextBtn = document.createElement('button');
        nextBtn.className = 'pg-btn';
        nextBtn.innerHTML = '&rsaquo;';
        nextBtn.disabled  = currentPage === totalPages;
        nextBtn.onclick   = () => goPage(currentPage + 1);
        container.appendChild(nextBtn);
    }

    function goPage(page) {
        const perPage  = parseInt(document.getElementById("entries").value) || 15;
        const search   = document.getElementById("searchInput").value.toLowerCase();
        const filtered = allProductData.filter(item =>
            (item.product_name || '').toLowerCase().includes(search) ||
            (formatProductCode(item.product_code) || '').toLowerCase().includes(search) ||
            ((item.category && item.category.category_name) || '').toLowerCase().includes(search)
        );
        const totalPages = Math.ceil(filtered.length / perPage) || 1;
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderTable();
    }

    function formatProductCode(productCode) {
        try {
            const parsed = JSON.parse(productCode);
            if (Array.isArray(parsed)) return parsed.join(', ');
        } catch (e) {}
        return productCode || 'N/A';
    }

    /* â”€â”€ Export Functions â”€â”€ */
    function exportCopy(tableId) {
        const tbl = document.getElementById(tableId); if (!tbl) return;
        const rows = [...tbl.querySelectorAll('tr')].map(r => [...r.querySelectorAll('th,td')].map(c => c.innerText.trim()).join('\t')).join('\n');
        navigator.clipboard.writeText(rows).then(() => showExportToast('Copied to clipboard!', '#15803d'));
    }
    function exportCSV(tableId, filename) {
        const tbl = document.getElementById(tableId); if (!tbl) return;
        const rows = [...tbl.querySelectorAll('tr')].map(r => [...r.querySelectorAll('th,td')].map(c => '"' + c.innerText.trim().replace(/"/g,'""') + '"').join(','));
        const blob = new Blob([rows.join('\n')], { type: 'text/csv;charset=utf-8;' });
        const a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = filename + '.csv'; a.click();
    }
    function exportExcel(tableId, filename) {
        const tbl = document.getElementById(tableId); if (!tbl) return;
        const html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"><head><meta charset="utf-8"></head><body>' + tbl.outerHTML + '</body></html>';
        const blob = new Blob([html], { type: 'application/vnd.ms-excel' });
        const a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = filename + '.xls'; a.click();
    }
    function exportPDF(tableId, title) {
        const tbl = document.getElementById(tableId); if (!tbl) return;
        const win = window.open('', '_blank');
        win.document.write('<html><head><title>' + title + '</title><style>body{font-family:Arial,sans-serif;font-size:12px;padding:20px}h2{color:#15803d;margin-bottom:12px}table{border-collapse:collapse;width:100%}th{background:#15803d;color:#fff;padding:7px 10px;text-align:left;font-size:11px}td{padding:6px 10px;border-bottom:1px solid #e2e8f0;font-size:11px}tr:nth-child(even)td{background:#f8fafc}@media print{body{padding:0}}</style></head><body><h2>' + title + '</h2>' + tbl.outerHTML + '</body></html>');
        win.document.close(); win.focus(); setTimeout(() => { win.print(); win.close(); }, 400);
    }
    function showExportToast(msg, color) {
        const t = document.createElement('div');
        t.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;padding:10px 18px;border-radius:10px;background:' + color + ';color:#fff;font-size:13px;font-weight:600;box-shadow:0 4px 16px rgba(0,0,0,0.18);transition:opacity .4s';
        t.textContent = msg; document.body.appendChild(t);
        setTimeout(() => { t.style.opacity = '0'; setTimeout(() => t.remove(), 400); }, 2000);
    }
</script>

@endsection



