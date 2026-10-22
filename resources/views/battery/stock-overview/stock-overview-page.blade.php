@extends('layouts.dashboard-sidenav')
@section('title', 'Stock Overview - MARSS CORPORATION')
@section('content')
<!-- html2pdf CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<style>
/* ── Export Button Styles ── */
.export-btn {
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    height: 36px !important;
    padding: 0 14px !important;
    border-radius: 10px !important;
    font-size: 12px !important;
    font-weight: 700 !important;
    cursor: pointer !important;
    border: 1.5px solid transparent !important;
    transition: all 0.15s ease !important;
    white-space: nowrap !important;
    text-decoration: none !important;
}
.export-btn svg, .export-btn i { pointer-events: none; flex-shrink: 0; }

.export-btn--excel { background: #f0fdf4 !important; color: #15803d !important; border-color: #bbf7d0 !important; }
.export-btn--excel:hover, .export-btn--excel:focus { background: #dcfce7 !important; border-color: #4ade80 !important; color: #15803d !important; }

.export-btn--pdf   { background: #fff1f2 !important; color: #be123c !important; border-color: #fecaca !important; }
.export-btn--pdf:hover, .export-btn--pdf:focus   { background: #ffe4e6 !important; border-color: #f87171 !important; color: #be123c !important; }

.export-btn--print { background: #eff6ff !important; color: #1d4ed8 !important; border-color: #bfdbfe !important; }
.export-btn--print:hover, .export-btn--print:focus { background: #dbeafe !important; border-color: #60a5fa !important; color: #1d4ed8 !important; }

/* Dark mode */
body[light-mode="dark"] .export-btn--excel, body[data-layout-mode="dark"] .export-btn--excel, html.dark .export-btn--excel { background: #022c1e !important; color: #4ade80 !important; border-color: #065f46 !important; }
body[light-mode="dark"] .export-btn--pdf, body[data-layout-mode="dark"] .export-btn--pdf, html.dark .export-btn--pdf { background: #3b0006 !important; color: #f87171 !important; border-color: #7f1d1d !important; }
body[light-mode="dark"] .export-btn--print, body[data-layout-mode="dark"] .export-btn--print, html.dark .export-btn--print { background: #0c1a3b !important; color: #60a5fa !important; border-color: #1e3a5f !important; }

/* Light mode anti-white hover rules for controls & buttons */
.search-clean-box:hover, .search-clean-input:focus { border-color: #10b981 !important; }
.entries-clean-box:hover { border-color: #10b981 !important; }
#entries:hover { color: #047857 !important; }
.pg-btn:hover { background: #e2e8f0 !important; color: #0f172a !important; border-color: #94a3b8 !important; }

/* Filter Buttons */
.stock-filter-btn {
    background: #ffffff;
    color: #334155;
    border: 1.5px solid #cbd5e1 !important;
}
body[light-mode="dark"] .stock-filter-btn,
body[data-layout-mode="dark"] .stock-filter-btn,
html.dark .stock-filter-btn {
    background: #1e293b;
    color: #cbd5e1;
    border-color: #334155 !important;
}
.stock-filter-btn.active-filter {
    background-color: #15803d !important;
    color: #ffffff !important;
    border-color: #15803d !important;
    box-shadow: 0 2px 8px rgba(21, 128, 61, 0.25) !important;
}
.stock-filter-btn.active-filter .filter-count-badge {
    background-color: rgba(255, 255, 255, 0.25) !important;
    color: #ffffff !important;
}

@media print { .export-btn, .stock-filter-btn, .search-clean-box, .entries-clean-box, #paginationWrapper, .adjust-action-col { display: none !important; } }

    /* ── Custom Sort Component Styles (Matching Custom Entries & Universal Design) ── */
    .custom-sort-component {
        position: relative;
        display: inline-block;
        user-select: none;
    }
    .custom-sort-standalone {
        height: 38px;
        min-width: 170px;
    }
    @media (min-width: 640px) {
        .custom-sort-standalone {
            height: 40px;
            min-width: 185px;
        }
    }
    .custom-sort-trigger {
        display: inline-flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        height: 100%;
        width: 100%;
        cursor: pointer;
        padding: 0 12px;
        border-radius: 12px;
        border: 1.5px solid #cbd5e1;
        background: #ffffff;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        transition: all 0.15s ease;
    }
    .custom-sort-trigger:hover {
        border-color: #10b981;
    }
    .custom-sort-menu {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        min-width: 195px;
        background-color: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        z-index: 9999 !important;
        padding: 4px;
        overflow: hidden;
    }
    .custom-sort-component.is-open .custom-sort-menu {
        display: block !important;
        animation: customSortFadeIn 0.15s ease-out forwards;
    }
    .custom-sort-component.is-open .sort-chevron-icon {
        transform: rotate(180deg);
    }
    @keyframes customSortFadeIn {
        from {
            opacity: 0;
            transform: translateY(-4px) scale(0.97);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    .custom-sort-list {
        display: flex;
        flex-direction: column;
        gap: 2px;
        max-height: 260px;
        overflow-y: auto;
    }
    .custom-sort-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding: 8px 12px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .custom-sort-item:hover {
        background-color: #f1f5f9;
        color: #15803d;
    }
    .custom-sort-item.active {
        background-color: #f0fdf4;
        color: #15803d;
        font-weight: 700;
    }

    /* Dark Mode Support for Custom Sort Dropdown */
    body[light-mode="dark"] .custom-sort-trigger,
    body[data-layout-mode="dark"] .custom-sort-trigger,
    html.dark .custom-sort-trigger,
    body.dark .custom-sort-trigger,
    body.dark-mode .custom-sort-trigger,
    [data-theme="dark"] .custom-sort-trigger {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
        box-shadow: none !important;
    }
    body[light-mode="dark"] .custom-sort-trigger:hover,
    body[data-layout-mode="dark"] .custom-sort-trigger:hover,
    html.dark .custom-sort-trigger:hover,
    body.dark .custom-sort-trigger:hover,
    body.dark-mode .custom-sort-trigger:hover,
    [data-theme="dark"] .custom-sort-trigger:hover {
        border-color: #059669 !important;
    }
    body[light-mode="dark"] .custom-sort-menu,
    body[data-layout-mode="dark"] .custom-sort-menu,
    html.dark .custom-sort-menu,
    body.dark .custom-sort-menu,
    body.dark-mode .custom-sort-menu,
    [data-theme="dark"] .custom-sort-menu {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.5) !important;
    }
    body[light-mode="dark"] .custom-sort-item,
    body[data-layout-mode="dark"] .custom-sort-item,
    html.dark .custom-sort-item,
    body.dark .custom-sort-item,
    body.dark-mode .custom-sort-item,
    [data-theme="dark"] .custom-sort-item {
        color: #cbd5e1 !important;
        background-color: transparent !important;
    }
    body[light-mode="dark"] .custom-sort-item:hover,
    body[data-layout-mode="dark"] .custom-sort-item:hover,
    html.dark .custom-sort-item:hover,
    body.dark .custom-sort-item:hover,
    body.dark-mode .custom-sort-item:hover,
    [data-theme="dark"] .custom-sort-item:hover {
        background-color: #334155 !important;
        color: #4ade80 !important;
    }
    body[light-mode="dark"] .custom-sort-item.active,
    body[data-layout-mode="dark"] .custom-sort-item.active,
    html.dark .custom-sort-item.active,
    body.dark .custom-sort-item.active,
    body.dark-mode .custom-sort-item.active,
    [data-theme="dark"] .custom-sort-item.active {
        background-color: rgba(34, 197, 94, 0.15) !important;
        color: #4ade80 !important;
    }

</style>

<!-- Hero Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-screen flex flex-col justify-between">
        <div class="data-table flex-grow">
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body">

                    <!-- 1. Page Title & Export Actions -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-700 shadow-sm flex-shrink-0">
                                <i class="fa-solid fa-chart-line text-base"></i>
                            </div>
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Stock Overview</h1>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-0 font-medium">Battery Module — Real-time inventory levels, valuation, and stock adjustment</p>
                            </div>
                        </div>

                        <!-- Only 3 Export Buttons: Excel, PDF, Print -->
                        <div class="flex items-center flex-wrap gap-2">
                            <button onclick="exportExcel()" type="button" class="export-btn export-btn--excel" title="Export Excel table data">
                                <i class="fa-solid fa-file-excel"></i>
                                <span>Excel</span>
                            </button>
                            <button onclick="exportPDF()" type="button" class="export-btn export-btn--pdf" title="Download PDF File">
                                <i class="fa-solid fa-file-pdf"></i>
                                <span>PDF</span>
                            </button>
                            <button onclick="printTableOnly()" type="button" class="export-btn export-btn--print" title="Print table on A4">
                                <i class="fa-solid fa-print"></i>
                                <span>Print</span>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Summary Cards — 4col / 2col / 1col -->
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

                    <!-- 3. Controls: Search + Show Entry + 3 Filter Buttons (1 row on Desktop, 2 rows on Mobile) -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
                        <!-- Row 1 on mobile, Left on desktop -->
                        <div class="flex items-center gap-2.5 flex-1 min-w-0">
                            <!-- Search (Single Border, Clean) -->
                            <div class="search-clean-box flex-1 md:max-w-xs lg:max-w-sm h-10 px-3 bg-white dark:bg-slate-800 rounded-xl flex items-center shadow-sm transition-all">
                                <svg class="w-4 h-4 text-slate-400 shrink-0 mr-2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                                <input type="text" id="searchInput" class="search-clean-input w-full h-full bg-transparent text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400" placeholder="Search product or barcode..." />
                            </div>
                                                        <!-- Sort Dropdown (Single Clean Universal Component) -->
                            <div class="shrink-0 flex items-center">
                                <div class="custom-sort-component custom-sort-standalone" id="stockSortWrapper">
                                    <div class="custom-sort-trigger" id="stockSortTrigger" onclick="toggleStockSortMenu(event)" title="Sort Products">
                                        <div class="flex items-center gap-1.5 overflow-hidden">
                                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">SORT:</span>
                                            <span class="custom-sort-value text-xs sm:text-sm font-bold text-emerald-700 dark:text-emerald-400 truncate max-w-[110px] sm:max-w-[130px]" id="stockSortSelectedText">Category (A-Z)</span>
                                        </div>
                                        <svg class="w-3.5 h-3.5 text-emerald-700 dark:text-emerald-400 sort-chevron-icon transition-transform duration-200 shrink-0" id="stockSortChevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </div>
                                    <div class="custom-sort-menu shadow-xl" id="stockSortMenu">
                                        <div class="custom-sort-list">
                                            <div class="custom-sort-item active" data-sort="category_asc" onclick="selectStockSort('category_asc', 'Category (A-Z)')">
                                                <span>Category (A-Z)</span>
                                                <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 sort-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </div>
                                            <div class="custom-sort-item" data-sort="name_asc" onclick="selectStockSort('name_asc', 'Alphabet (A - Z)')">
                                                <span>Alphabet (A - Z)</span>
                                                <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 sort-check-icon hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </div>
                                            <div class="custom-sort-item" data-sort="name_desc" onclick="selectStockSort('name_desc', 'Alphabet (Z - A)')">
                                                <span>Alphabet (Z - A)</span>
                                                <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 sort-check-icon hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </div>
                                            <div class="custom-sort-item" data-sort="stock_asc" onclick="selectStockSort('stock_asc', 'Stock: Low to High')">
                                                <span>Stock: Low to High</span>
                                                <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 sort-check-icon hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </div>
                                            <div class="custom-sort-item" data-sort="stock_desc" onclick="selectStockSort('stock_desc', 'Stock: High to Low')">
                                                <span>Stock: High to Low</span>
                                                <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 sort-check-icon hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </div>
                                            <div class="custom-sort-item" data-sort="default" onclick="selectStockSort('default', 'Default (Newest)')">
                                                <span>Default (Newest)</span>
                                                <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 sort-check-icon hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Entries (Single Clean Universal Component) -->
                            <div class="shrink-0 flex items-center">
                                <select id="entries">
                                    <option value="15" selected>15</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 2 on mobile, Right on desktop: 3 Stock Filter Buttons in same row -->
                        <div class="flex items-center gap-2 overflow-x-auto shrink-0 pb-1 md:pb-0">
                            <button type="button" id="tabAllStock" onclick="setStockFilter('all')" class="stock-filter-btn active-filter h-10 px-3.5 rounded-xl text-xs font-bold flex items-center gap-2 transition-all cursor-pointer whitespace-nowrap">
                                <span>All Stock</span>
                                <span id="badgeAllStock" class="filter-count-badge px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-100">0</span>
                            </button>
                            <button type="button" id="tabLowStock" onclick="setStockFilter('low')" class="stock-filter-btn h-10 px-3.5 rounded-xl text-xs font-bold flex items-center gap-2 transition-all cursor-pointer whitespace-nowrap">
                                <span>Low Stock</span>
                                <span id="badgeLowStock" class="filter-count-badge px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 dark:bg-amber-900/60 text-amber-800 dark:text-amber-300">0</span>
                            </button>
                            <button type="button" id="tabOutOfStock" onclick="setStockFilter('out')" class="stock-filter-btn h-10 px-3.5 rounded-xl text-xs font-bold flex items-center gap-2 transition-all cursor-pointer whitespace-nowrap">
                                <span>Out of Stock</span>
                                <span id="badgeOutOfStock" class="filter-count-badge px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 dark:bg-rose-900/60 text-rose-800 dark:text-rose-300">0</span>
                            </button>
                        </div>
                    </div>

                    <!-- 4. Desktop Table -->
                    <div class="control-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="tbl-th text-center w-[46px] rounded-tl-2xl">SL</th>
                                    <th class="tbl-th text-center w-[54px]">Img</th>
                                    <th class="tbl-th text-start w-[180px] max-w-[200px]">Product Name</th>
                                    <th class="tbl-th text-start min-w-[160px]">Barcode / Code</th>
                                    <th class="tbl-th text-start min-w-[130px]">Category</th>
                                    <th class="tbl-th text-center w-[95px]">Stock Qty</th>
                                    <th class="tbl-th text-end w-[110px]">Cost Price (৳)</th>
                                    <th class="tbl-th text-end w-[110px]">Sell Price (৳)</th>
                                    <th class="tbl-th text-center w-[110px]">Status</th>
                                    <th class="tbl-th text-center rounded-tr-2xl w-[75px] adjust-action-col">Adjust</th>
                                </tr>
                            </thead>
                            <tbody id="tableList" class="divide-y divide-slate-100 dark:divide-slate-700/60 text-sm text-slate-700 dark:text-slate-200"></tbody>
                            <tfoot class="bg-slate-50 dark:bg-slate-800/80 font-bold border-t-2 border-emerald-600/30 dark:border-emerald-700/40 text-xs sm:text-sm">
                                <tr>
                                    <td colspan="5" class="tbl-td text-end font-bold text-slate-600 dark:text-slate-300">Total Filtered Qty:</td>
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
                    <div class="flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-700/60 gap-3" id="paginationWrapper">
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

<!-- ══════════════════════════════════════════
     ADJUST STOCK QUANTITY MODAL
══════════════════════════════════════════ -->
<div id="adjustStockModal" class="fixed inset-0 overflow-y-auto" role="dialog" aria-modal="true" onclick="if(event.target === this) closeAdjustModal()" style="display: none; position: fixed !important; inset: 0 !important; width: 100vw !important; height: 100vh !important; z-index: 999999 !important; background: rgba(11, 16, 27, 0.75) !important; backdrop-filter: blur(4px) !important; -webkit-backdrop-filter: blur(4px) !important; padding: 16px !important; align-items: center; justify-content: center;">
    <div class="adjust-modal-card relative transform transition-all my-auto" onclick="event.stopPropagation()">

        <!-- Modal Header (Forest Green #15803d) -->
        <div class="flex items-center justify-between bg-[#15803d] text-white" style="background-color: #15803d !important; border-top-left-radius: 20px; border-top-right-radius: 20px; padding: 14px 20px !important;">
            <div class="flex items-center gap-2.5">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line>
                    <line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line>
                    <line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line>
                    <line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line>
                </svg>
                <h3 class="text-sm sm:text-base font-bold text-white tracking-wide uppercase m-0 p-0" style="color: #ffffff !important;">
                    ADJUST STOCK QUANTITY
                </h3>
            </div>
            <!-- Red circular close button with white icon -->
            <button type="button" onclick="closeAdjustModal()" title="Close" class="w-8 h-8 rounded-full bg-red-600 hover:bg-red-700 active:bg-red-800 text-white flex items-center justify-center transition-all border-0 shadow cursor-pointer">
                <i class="fa-solid fa-xmark text-sm text-white"></i>
            </button>
        </div>

        <!-- Modal Body Form (20px padding on all sides) -->
        <form id="adjustStockForm" onsubmit="handleAdjustSubmit(event)" class="adjust-modal-form m-0" style="padding: 20px !important; overflow: visible !important;">
            <input type="hidden" id="adjustProductId">

            <!-- Product Info Box -->
            <div class="adjust-info-box p-3.5">
                <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase truncate m-0" id="adjustProductName">
                    Product Name
                </h4>
                <div class="flex items-center justify-between mt-2 pt-1.5 border-t border-slate-200/80 dark:border-slate-700/60">
                    <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">Current Registered Stock:</span>
                    <span class="text-xs font-bold text-red-600 dark:text-red-400" id="adjustCurrentStock">
                        0 Pcs
                    </span>
                </div>
            </div>

            <!-- New Physical Stock Input (with top gap and inside unit badge) -->
            <div class="adjust-field-group" style="margin-top: 16px !important;">
                <label for="newPhysicalQuantity" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                    New Physical Stock Quantity <span class="text-red-500">*</span>
                </label>
                <div class="relative w-full" style="position: relative; width: 100%; box-sizing: border-box;">
                    <input type="number" step="any" min="0" id="newPhysicalQuantity" required
                           class="adjust-input-field" placeholder="0">
                    <span class="adjust-unit-badge" id="adjustUnitLabel">Pcs</span>
                </div>
            </div>

            <!-- Adjustment Reason Custom Dropdown (with top gap and root overlay) -->
            <div class="adjust-field-group" style="margin-top: 16px !important; position: relative; z-index: 100;">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                    Adjustment Reason <span class="text-red-500">*</span>
                </label>
                <div class="relative w-full" id="customReasonWrapper" style="position: relative; width: 100%; box-sizing: border-box;">
                    <input type="hidden" id="adjustmentReason" name="reason" value="Physical Inventory Recount">
                    <button type="button" id="reasonSelectBtn" onclick="toggleReasonMenu(event)"
                            class="custom-select-trigger" aria-haspopup="listbox" aria-expanded="false">
                        <span id="reasonSelectedText" class="truncate font-medium">Physical Inventory Recount</span>
                        <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-200" id="reasonChevronIcon"></i>
                    </button>
                    <div id="reasonDropdownMenu" class="custom-select-menu hidden" role="listbox">
                        <div class="custom-select-option selected" data-value="Physical Inventory Recount" onclick="selectReason('Physical Inventory Recount')">
                            <span>Physical Inventory Recount</span>
                            <i class="fa-solid fa-check text-xs text-emerald-600 dark:text-emerald-400 option-check"></i>
                        </div>
                        <div class="custom-select-option" data-value="Damaged / Broken Goods" onclick="selectReason('Damaged / Broken Goods')">
                            <span>Damaged / Broken Goods</span>
                            <i class="fa-solid fa-check text-xs text-emerald-600 dark:text-emerald-400 option-check hidden"></i>
                        </div>
                        <div class="custom-select-option" data-value="Customer Return / Cancellation" onclick="selectReason('Customer Return / Cancellation')">
                            <span>Customer Return / Cancellation</span>
                            <i class="fa-solid fa-check text-xs text-emerald-600 dark:text-emerald-400 option-check hidden"></i>
                        </div>
                        <div class="custom-select-option" data-value="Supplier Replacement" onclick="selectReason('Supplier Replacement')">
                            <span>Supplier Replacement</span>
                            <i class="fa-solid fa-check text-xs text-emerald-600 dark:text-emerald-400 option-check hidden"></i>
                        </div>
                        <div class="custom-select-option" data-value="Showroom Display / Sample" onclick="selectReason('Showroom Display / Sample')">
                            <span>Showroom Display / Sample</span>
                            <i class="fa-solid fa-check text-xs text-emerald-600 dark:text-emerald-400 option-check hidden"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Action Buttons: Cancel (Red), Save Stock Update (Green) -->
            <div class="flex items-center justify-center gap-3 pt-3 border-t border-slate-100 dark:border-slate-800" style="margin-top: 20px !important;">
                <button type="button" onclick="closeAdjustModal()"
                        class="h-10 px-6 rounded-xl bg-red-600 hover:bg-red-700 active:bg-red-800 text-white font-bold text-xs transition-colors shadow-sm cursor-pointer border-0">
                    Cancel
                </button>
                <button type="submit" id="saveAdjustBtn"
                        class="h-10 px-6 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs transition-colors shadow-md flex items-center gap-1.5 cursor-pointer border-0">
                    <span>Save Stock Update</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════
     PRODUCT IMAGE PREVIEW POPUP MODAL
══════════════════════════════════════════ -->
<div id="productImageModal" role="dialog" aria-modal="true" onclick="if(event.target === this) closeImagePreview()" style="display: none; position: fixed !important; top: 0 !important; left: 0 !important; width: 100vw !important; height: 100vh !important; z-index: 99999999 !important; background: rgba(11, 16, 27, 0.85) !important; backdrop-filter: blur(6px) !important; -webkit-backdrop-filter: blur(6px) !important; padding: 16px !important; box-sizing: border-box !important; align-items: center !important; justify-content: center !important; overflow: hidden !important;">
    <div style="position: relative !important; max-width: 90vw !important; max-height: 90vh !important; display: flex !important; align-items: center !important; justify-content: center !important; box-sizing: border-box !important;" onclick="event.stopPropagation()">
        <!-- Red circular close button positioned on top-right border -->
        <button type="button" onclick="closeImagePreview()" title="Close" style="position: absolute !important; top: -14px !important; right: -14px !important; width: 34px !important; height: 34px !important; border-radius: 9999px !important; background-color: #dc2626 !important; color: #ffffff !important; display: flex !important; align-items: center !important; justify-content: center !important; border: 2.5px solid #ffffff !important; box-shadow: 0 10px 25px rgba(0,0,0,0.45) !important; cursor: pointer !important; z-index: 99999 !important; padding: 0 !important; outline: none !important;">
            <i class="fa-solid fa-xmark" style="font-size: 15px !important; color: #ffffff !important; line-height: 1 !important;"></i>
        </button>

        <!-- Image Wrapper strictly within 90vh and 90vw -->
        <div style="border-radius: 16px !important; overflow: hidden !important; background: #ffffff !important; border: 2px solid rgba(255,255,255,0.95) !important; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.65) !important; padding: 4px !important; display: flex !important; align-items: center !important; justify-content: center !important; max-width: 90vw !important; max-height: 90vh !important; box-sizing: border-box !important;">
            <img id="previewModalImg" src="" alt="Product Preview" style="display: block !important; max-width: calc(90vw - 16px) !important; max-height: calc(90vh - 16px) !important; width: auto !important; height: auto !important; object-fit: contain !important; border-radius: 12px !important; user-select: none !important;" />
        </div>
    </div>
</div>

<style>
    /* Card body padding */
    .product-card-body { padding: 16px; }
    @media (min-width: 640px)  { .product-card-body { padding: 24px; } }
    @media (min-width: 1024px) { .product-card-body { padding: 32px; } }

    /* Summary cards grid */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }
    @media (max-width: 1023px) { .summary-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; } }
    @media (max-width: 639px)  {
        .summary-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 8px !important; }
        .summary-card { padding: 10px 12px !important; }
        .summary-card__label { font-size: 0.625rem !important; }
        .summary-card__value { font-size: 1.15rem !important; }
    }

    .summary-card {
        border-radius: 12px;
        padding: 14px;
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
    }
    body[data-layout-mode="dark"] .summary-card,
    html.dark .summary-card,
    body[light-mode="dark"] .summary-card {
        background: #0f172a;
        border-color: #1e293b;
    }
    .summary-card--amber   { background: #fffbeb; border-color: #fde68a; }
    .summary-card--rose    { background: #fff1f2; border-color: #fecaca; }
    .summary-card--slate   { background: #f8fafc; border-color: #e2e8f0; }
    .summary-card--emerald { background: #f0fdf4; border-color: #bbf7d0; }

    body[data-layout-mode="dark"] .summary-card--amber,
    html.dark .summary-card--amber,
    body[light-mode="dark"] .summary-card--amber   { background: #1c1407; border-color: #78350f; }
    body[data-layout-mode="dark"] .summary-card--rose,
    html.dark .summary-card--rose,
    body[light-mode="dark"] .summary-card--rose    { background: #20070a; border-color: #881337; }
    body[data-layout-mode="dark"] .summary-card--slate,
    html.dark .summary-card--slate,
    body[light-mode="dark"] .summary-card--slate   { background: #0f172a; border-color: #1e293b; }
    body[data-layout-mode="dark"] .summary-card--emerald,
    html.dark .summary-card--emerald,
    body[light-mode="dark"] .summary-card--emerald { background: #051e11; border-color: #064e3b; }

    .summary-card__label {
        font-size: 0.6875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 4px;
        color: #64748b;
    }
    body[data-layout-mode="dark"] .summary-card__label,
    html.dark .summary-card__label,
    body[light-mode="dark"] .summary-card__label { color: #94a3b8; }
    .summary-card__value {
        font-size: 1.35rem;
        font-weight: 800;
        line-height: 1.2;
        margin: 0;
    }

    /* Table styles - Left/Right padding 10px */
    .tbl-th { padding: 9px 10px !important; font-size: 11px; white-space: nowrap; }
    .tbl-td { padding: 7px 10px !important; font-size: 12.5px; vertical-align: middle; }
    .product-img { width: 34px; height: 34px; border-radius: 8px; object-fit: contain; border: 1px solid #e2e8f0; padding: 2px; cursor: pointer; transition: transform 0.15s ease, opacity 0.15s ease; }
    .product-img:hover { transform: scale(1.08); opacity: 0.85; }
    body[data-layout-mode="dark"] .product-img, html.dark .product-img, body[light-mode="dark"] .product-img { border-color: #334155; }
    .col-product-name {
        width: 180px !important;
        max-width: 200px !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    /* Control border */
    .control-border { border: 1.5px solid #cbd5e1 !important; }
    body[data-layout-mode="dark"] .control-border,
    html.dark .control-border,
    body[light-mode="dark"] .control-border { border-color: #334155 !important; }

    /* Clean Search & Entries - Single Box, Single Border */
    .search-clean-box, .entries-clean-box {
        border: 1.5px solid #cbd5e1 !important;
    }
    .search-clean-box:focus-within, .entries-clean-box:focus-within {
        border-color: #10b981 !important;
    }
    .search-clean-input {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        background: transparent !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .search-clean-input:focus {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
    }
    .entries-clean-select {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        background: transparent !important;
        padding: 2px 4px !important;
        margin: 0 !important;
        -webkit-appearance: menulist !important;
        appearance: menulist !important;
    }
    .entries-clean-select:focus {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
    }
    body[light-mode="dark"] .search-clean-box,
    body[data-layout-mode="dark"] .search-clean-box,
    html.dark .search-clean-box,
    body.dark .search-clean-box,
    body[light-mode="dark"] .entries-clean-box,
    body[data-layout-mode="dark"] .entries-clean-box,
    html.dark .entries-clean-box,
    body.dark .entries-clean-box {
        border-color: #334155 !important;
    }

    /* Modal Styling - Compact width, subtle dark borders, overflow visible for dropdown */
    .adjust-modal-card {
        max-width: 440px !important;
        width: 100% !important;
        border-radius: 20px !important;
        overflow: visible !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
    }
    body[light-mode="dark"] .adjust-modal-card,
    body[data-layout-mode="dark"] .adjust-modal-card,
    html.dark .adjust-modal-card,
    body.dark .adjust-modal-card {
        background: #0f172a !important;
        border: 1px solid #334155 !important; /* Subtle dark border, not white! */
    }

    .adjust-info-box {
        background: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 14px !important;
    }
    body[light-mode="dark"] .adjust-info-box,
    body[data-layout-mode="dark"] .adjust-info-box,
    html.dark .adjust-info-box,
    body.dark .adjust-info-box {
        background: #1e293b !important;
        border: 1px solid #334155 !important;
    }

    .adjust-input-field {
        width: 100% !important;
        box-sizing: border-box !important;
        height: 44px !important;
        padding: 10px 52px 10px 16px !important;
        border-radius: 12px !important;
        border: 1.5px solid #cbd5e1 !important;
        background: #ffffff !important;
        color: #dc2626 !important;
        font-size: 14px !important;
        font-weight: 700 !important;
        outline: none !important;
        box-shadow: none !important;
        transition: all 0.2s ease !important;
    }
    .adjust-unit-badge {
        position: absolute !important;
        right: 14px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        color: #94a3b8 !important;
        pointer-events: none !important;
        line-height: 1 !important;
    }
    .adjust-input-field:focus {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15) !important;
    }
    body[light-mode="dark"] .adjust-input-field,
    body[data-layout-mode="dark"] .adjust-input-field,
    html.dark .adjust-input-field,
    body.dark .adjust-input-field {
        background: #1e293b !important;
        border: 1.5px solid #334155 !important; /* Subtle dark border, not white! */
        color: #f87171 !important;
    }
    body[light-mode="dark"] .adjust-input-field:focus,
    body[data-layout-mode="dark"] .adjust-input-field:focus,
    html.dark .adjust-input-field:focus,
    body.dark .adjust-input-field:focus {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2) !important;
    }

    /* Custom Dropdown Trigger */
    .custom-select-trigger {
        width: 100% !important;
        box-sizing: border-box !important;
        height: 44px !important;
        padding: 10px 16px !important;
        border-radius: 12px !important;
        border: 1.5px solid #cbd5e1 !important;
        background: #ffffff !important;
        color: #1e293b !important;
        font-size: 13.5px !important;
        font-weight: 500 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        outline: none !important;
    }
    .custom-select-trigger:hover, .custom-select-trigger:focus {
        border-color: #10b981 !important;
    }
    body[light-mode="dark"] .custom-select-trigger,
    body[data-layout-mode="dark"] .custom-select-trigger,
    html.dark .custom-select-trigger,
    body.dark .custom-select-trigger {
        background: #1e293b !important;
        border: 1.5px solid #334155 !important; /* Subtle dark border, not white! */
        color: #e2e8f0 !important;
    }
    body[light-mode="dark"] .custom-select-trigger:hover,
    body[data-layout-mode="dark"] .custom-select-trigger:hover,
    html.dark .custom-select-trigger:hover,
    body.dark .custom-select-trigger:hover {
        border-color: #10b981 !important;
    }

    /* Custom Dropdown Menu - Floats on top or bottom dynamically */
    .custom-select-menu {
        position: absolute !important;
        left: 0 !important;
        right: 0 !important;
        top: calc(100% + 6px);
        background: #ffffff !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 12px !important;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.22) !important;
        z-index: 9999999 !important;
        padding: 6px !important;
        max-height: 240px !important;
        overflow-y: auto !important;
    }
    body[light-mode="dark"] .custom-select-menu,
    body[data-layout-mode="dark"] .custom-select-menu,
    html.dark .custom-select-menu,
    body.dark .custom-select-menu {
        background: #1e293b !important;
        border: 1px solid #334155 !important;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.5) !important;
    }

    /* Custom Entries Standalone Component Height Alignment */
    .custom-entries-standalone,
    .custom-entries-standalone .custom-entries-trigger {
        height: 40px !important;
        border-radius: 12px !important;
    }

    .custom-select-option {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 9px 12px !important;
        border-radius: 8px !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        color: #334155 !important;
        cursor: pointer !important;
        transition: background 0.15s ease !important;
    }
    .custom-select-option:hover {
        background: #f0fdf4 !important;
        color: #15803d !important;
    }
    .custom-select-option.selected {
        background: #dcfce7 !important;
        color: #15803d !important;
        font-weight: 700 !important;
    }
    body[light-mode="dark"] .custom-select-option,
    body[data-layout-mode="dark"] .custom-select-option,
    html.dark .custom-select-option,
    body.dark .custom-select-option {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .custom-select-option:hover,
    body[data-layout-mode="dark"] .custom-select-option:hover,
    html.dark .custom-select-option:hover,
    body.dark .custom-select-option:hover {
        background: rgba(16, 185, 129, 0.15) !important;
        color: #34d399 !important;
    }
    body[light-mode="dark"] .custom-select-option.selected,
    body[data-layout-mode="dark"] .custom-select-option.selected,
    html.dark .custom-select-option.selected,
    body.dark .custom-select-option.selected {
        background: rgba(16, 185, 129, 0.25) !important;
        color: #34d399 !important;
        font-weight: 700 !important;
    }

    /* Pagination button */
    .pg-btn {
        display: inline-flex; align-items: center; justify-content: center;
        height: 34px; min-width: 34px; padding: 0 10px; border-radius: 8px;
        font-size: 0.75rem; font-weight: 600; transition: all 0.15s ease;
        border: 1.5px solid #e2e8f0; background: #ffffff; color: #475569;
        cursor: pointer; user-select: none;
    }
    body[data-layout-mode="dark"] .pg-btn, html.dark .pg-btn, body[light-mode="dark"] .pg-btn {
        background: #1e293b; color: #94a3b8; border-color: #334155;
    }
    .pg-btn:hover:not(:disabled):not(.pg-active) { background: #f0fdf4; border-color: #16a34a; color: #15803d; }
    .pg-btn.pg-active { background: #15803d; color: #ffffff; border-color: #15803d; box-shadow: 0 1px 4px rgba(21,128,61,0.30); }
    .pg-btn:disabled { opacity: 0.4; cursor: not-allowed; }

    /* Badges */
    .badge-out { background:#fee2e2; color:#b91c1c; border:1px solid #fecaca; white-space:nowrap; }
    body[data-layout-mode="dark"] .badge-out, html.dark .badge-out, body[light-mode="dark"] .badge-out { background:#3b0000; color:#f87171; border-color:#7f1d1d; }
    .badge-low { background:#fef3c7; color:#b45309; border:1px solid #fde68a; white-space:nowrap; }
    body[data-layout-mode="dark"] .badge-low, html.dark .badge-low, body[light-mode="dark"] .badge-low { background:#27180a; color:#fbbf24; border-color:#78350f; }
    .badge-avail { background:#dcfce7; color:#15803d; border:1px solid #bbf7d0; white-space:nowrap; }
    body[data-layout-mode="dark"] .badge-avail, html.dark .badge-avail, body[light-mode="dark"] .badge-avail { background:#052e16; color:#4ade80; border-color:#166534; }
</style>

<script>
    let allProductData = [];
    let currentFilter  = 'all'; // 'all' | 'low' | 'out'
    let currentSort    = 'category_asc'; // 'category_asc' | 'name_asc' | 'name_desc' | 'stock_asc' | 'stock_desc' | 'default'
    let currentPage    = 1;

    function getItemCategoryName(item) {
        if (!item) return '';
        if (item.category_name) return item.category_name;
        if (item.category) {
            return item.category.category_name || item.category.name || '';
        }
        return '';
    }

    function toggleStockSortMenu(e) {
        e.stopPropagation();
        const wrapper = document.getElementById('stockSortWrapper');
        if (!wrapper) return;
        const isOpen = wrapper.classList.contains('is-open');
        document.querySelectorAll('.custom-sort-component.is-open').forEach(w => w.classList.remove('is-open'));
        if (!isOpen) {
            const menu = document.getElementById('stockSortMenu');
            const trigger = document.getElementById('stockSortTrigger');
            if (trigger && menu) {
                const rect = trigger.getBoundingClientRect();
                const spaceBelow = window.innerHeight - rect.bottom;
                if (spaceBelow < 260 && rect.top > spaceBelow) {
                    menu.style.top = 'auto';
                    menu.style.bottom = 'calc(100% + 6px)';
                } else {
                    menu.style.top = 'calc(100% + 6px)';
                    menu.style.bottom = 'auto';
                }
            }
            wrapper.classList.add('is-open');
        }
    }

    function selectStockSort(sortKey, label) {
        currentSort = sortKey;
        const textEl = document.getElementById('stockSortSelectedText');
        if (textEl) textEl.textContent = label;

        const wrapper = document.getElementById('stockSortWrapper');
        if (wrapper) {
            wrapper.querySelectorAll('.custom-sort-item').forEach(item => {
                const isMatch = item.getAttribute('data-sort') === sortKey;
                item.classList.toggle('active', isMatch);
                const checkIcon = item.querySelector('.sort-check-icon');
                if (checkIcon) {
                    checkIcon.classList.toggle('hidden', !isMatch);
                }
            });
            wrapper.classList.remove('is-open');
        }
        currentPage = 1;
        renderTable();
    }

    document.addEventListener('click', (e) => {
        if (!e.target.closest('#stockSortWrapper')) {
            const wrapper = document.getElementById('stockSortWrapper');
            if (wrapper) wrapper.classList.remove('is-open');
        }
    });

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

    function formatProductCode(code) {
        if (!code) return '-';
        if (Array.isArray(code)) return code.join(', ');
        try {
            const parsed = JSON.parse(code);
            if (Array.isArray(parsed)) return parsed.join(', ');
        } catch(e) {}
        return code;
    }

    function formatProductName(name, maxWords = 3) {
        if (!name) return '-';
        const words = name.trim().split(/\s+/);
        if (words.length > maxWords) {
            return words.slice(0, maxWords).join(' ') + '...';
        }
        return name;
    }

    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("adjustStockModal");
        if (modal && modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }
        const imgModal = document.getElementById("productImageModal");
        if (imgModal && imgModal.parentElement !== document.body) {
            document.body.appendChild(imgModal);
        }
        loadStockOverviewData();
        document.getElementById("entries").addEventListener("change", () => { currentPage = 1; renderTable(); });
        document.getElementById("searchInput").addEventListener("keyup",  () => { currentPage = 1; renderTable(); });
    });

    function setStockFilter(filter) {
        currentFilter = filter;
        document.querySelectorAll('.stock-filter-btn').forEach(btn => btn.classList.remove('active-filter'));
        if (filter === 'all') document.getElementById('tabAllStock').classList.add('active-filter');
        if (filter === 'low') document.getElementById('tabLowStock').classList.add('active-filter');
        if (filter === 'out') document.getElementById('tabOutOfStock').classList.add('active-filter');
        currentPage = 1;
        renderTable();
    }

    async function loadStockOverviewData() {
        try {
            showLoader();
            const res = await axios.get("/api/battery/stock-overview-data", HeaderToken());
            hideLoader();

            if (res.data.status !== 'success') {
                console.error('Error fetching battery stock data:', res.data.message);
                return;
            }

            allProductData = res.data.products || [];
            const summary  = res.data.summary || {};

            // Calculate Counts for Buttons & Summary Cards
            const totalCount = allProductData.length;
            const outOfStock = allProductData.filter(i => parseFloat(i.quantity || 0) <= 0).length;
            const lowStock   = allProductData.filter(i => {
                const q = parseFloat(i.quantity || 0);
                return q > 0 && q <= 5;
            }).length;

            let totalCost = summary.cost_value || 0;
            let totalSell = summary.sell_value || 0;

            if (!totalCost && !totalSell) {
                allProductData.forEach(i => {
                    const q = parseFloat(i.quantity || 0);
                    totalCost += (parseFloat(i.cost_price || 0) * q);
                    totalSell += (parseFloat(i.sell_price || 0) * q);
                });
            }

            // Summary cards
            document.getElementById('summaryLowStock').textContent   = lowStock + ' Products';
            document.getElementById('summaryOutOfStock').textContent = outOfStock + ' Products';
            document.getElementById('summaryCostValue').textContent  = '৳ ' + bdFormat(totalCost);
            document.getElementById('summarySellValue').textContent  = '৳ ' + bdFormat(totalSell);

            // Button Badge Counts (numbers inside buttons)
            document.getElementById('badgeAllStock').textContent   = totalCount;
            document.getElementById('badgeLowStock').textContent   = lowStock;
            document.getElementById('badgeOutOfStock').textContent = outOfStock;

            renderTable();
        } catch (e) {
            hideLoader();
            console.error('Error:', e.message || e);
        }
    }

    function getFilteredList() {
        const search = (document.getElementById("searchInput").value || '').toLowerCase().trim();

        let list = allProductData.filter(item => {
            const qty = parseFloat(item.quantity || 0);

            // Filter Tab
            if (currentFilter === 'low') {
                if (!(qty > 0 && qty <= 5)) return false;
            } else if (currentFilter === 'out') {
                if (qty > 0) return false;
            }

            // Search
            if (search) {
                const name = (item.product_name || '').toLowerCase();
                const code = (formatProductCode(item.barcode_display || item.barcode || item.product_code) || '').toLowerCase();
                const cat  = getItemCategoryName(item).toLowerCase();
                const idStr = String(item.id);
                return name.includes(search) || code.includes(search) || cat.includes(search) || idStr === search;
            }

            return true;
        });

        // Apply Dynamic Sort Order
        if (currentSort === 'category_asc') {
            list.sort((a, b) => {
                const catA = getItemCategoryName(a).toLowerCase();
                const catB = getItemCategoryName(b).toLowerCase();
                const cmp = catA.localeCompare(catB, undefined, { sensitivity: 'base' });
                if (cmp !== 0) return cmp;
                const nameA = (a.product_name || '').toLowerCase();
                const nameB = (b.product_name || '').toLowerCase();
                return nameA.localeCompare(nameB, undefined, { sensitivity: 'base' });
            });
        } else if (currentSort === 'name_asc') {
            list.sort((a, b) => {
                const nameA = (a.product_name || '').toLowerCase();
                const nameB = (b.product_name || '').toLowerCase();
                return nameA.localeCompare(nameB, undefined, { sensitivity: 'base' });
            });
        } else if (currentSort === 'name_desc') {
            list.sort((a, b) => {
                const nameA = (a.product_name || '').toLowerCase();
                const nameB = (b.product_name || '').toLowerCase();
                return nameB.localeCompare(nameA, undefined, { sensitivity: 'base' });
            });
        } else if (currentSort === 'stock_asc') {
            list.sort((a, b) => (parseFloat(a.quantity || 0)) - (parseFloat(b.quantity || 0)));
        } else if (currentSort === 'stock_desc') {
            list.sort((a, b) => (parseFloat(b.quantity || 0)) - (parseFloat(a.quantity || 0)));
        } else if (currentSort === 'default') {
            list.sort((a, b) => (parseInt(b.id || 0)) - (parseInt(a.id || 0)));
        }

        return list;
    }

    function renderTable() {
        const filtered = getFilteredList();
        const perPage  = parseInt(document.getElementById("entries").value) || 15;
        const total    = filtered.length;
        const totalPages = Math.ceil(total / perPage) || 1;
        if (currentPage > totalPages) currentPage = 1;
        const start    = (currentPage - 1) * perPage;
        const pageData = filtered.slice(start, start + perPage);

        // Footer totals from full filtered set
        let totalQty = 0, totalCostAmt = 0, totalSellAmt = 0;
        filtered.forEach(item => {
            const q = parseFloat(item.quantity || 0);
            totalQty     += q;
            totalCostAmt += (parseFloat(item.cost_price || 0) * q);
            totalSellAmt += (parseFloat(item.sell_price || 0) * q);
        });

        // ── Desktop Table ──
        const tbody = document.getElementById('tableList');
        tbody.innerHTML = '';

        if (pageData.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="10" class="tbl-td text-center py-10">
                        <div class="flex flex-col items-center gap-2 text-emerald-600 dark:text-emerald-400">
                            <i class="fa-solid fa-box-open text-2xl text-slate-300 dark:text-slate-600 mb-1"></i>
                            <p class="font-bold text-sm">No products found for active filter!</p>
                            <p class="text-xs text-slate-400">Try switching tabs or changing search query.</p>
                        </div>
                    </td>
                </tr>`;
        } else {
            pageData.forEach((item, index) => {
                const img_url      = item.img_url ? item.img_url : "{{ asset('backend/assets/img/product-img.svg') }}";
                const qtyNum       = parseFloat(item.quantity) || 0;
                const unitName     = item.unit_name || (item.unit ? (item.unit.unit_name || item.unit.name || 'pcs') : 'pcs');
                const categoryName = item.category_name || (item.category ? item.category.category_name : 'N/A');
                const isOut        = qtyNum <= 0;
                const isLow        = qtyNum > 0 && qtyNum <= 5;
                const qtyColor     = isOut ? 'text-rose-600 dark:text-rose-400' : (isLow ? 'text-amber-600 dark:text-amber-400' : 'text-slate-800 dark:text-slate-200');

                // Status badge
                let statusBadge = `<span class="badge-avail inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 flex-shrink-0"></span>Available</span>`;
                if (isOut) {
                    statusBadge = `<span class="badge-out inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-rose-500 flex-shrink-0"></span>Out of Stock</span>`;
                } else if (isLow) {
                    statusBadge = `<span class="badge-low inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-amber-400 flex-shrink-0"></span>Low Stock</span>`;
                }

                // Adjust Action Button
                const adjustBtn = `
                    <button type="button" onclick="openAdjustModal(${item.id})" class="action-btn adjust-btn inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-700 hover:bg-emerald-600 text-white transition-all shadow-sm" title="Adjust Stock Quantity">
                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                    </button>`;

                tbody.innerHTML += `
                    <tr class="tbl-row hover:bg-slate-50/70 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="tbl-td text-center text-slate-400 font-semibold">${start + index + 1}</td>
                        <td class="tbl-td text-center">
                            <img src="${img_url}" alt="${item.product_name}" class="product-img" onclick="openImagePreview('${img_url}')" title="Click to view image" loading="lazy" />
                        </td>
                        <td class="tbl-td col-product-name font-semibold text-slate-800 dark:text-slate-100" title="${item.product_name || ''}">${formatProductName(item.product_name, 3)}</td>
                        <td class="tbl-td">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[11px] font-mono border border-slate-200 dark:border-slate-700">${formatProductCode(item.barcode_display || item.barcode || item.product_code)}</span>
                        </td>
                        <td class="tbl-td text-slate-600 dark:text-slate-400">${categoryName}</td>
                        <td class="tbl-td text-center font-bold ${qtyColor}">${qtyNum} ${unitName}</td>
                        <td class="tbl-td text-end font-semibold text-rose-600 dark:text-rose-400">৳ ${bdFormat(item.cost_price)}</td>
                        <td class="tbl-td text-end font-semibold text-emerald-600 dark:text-emerald-400">৳ ${bdFormat(item.sell_price)}</td>
                        <td class="tbl-td text-center">${statusBadge}</td>
                        <td class="tbl-td text-center adjust-action-col">${adjustBtn}</td>
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
        pageData.forEach((item) => {
            const qtyNum  = parseFloat(item.quantity) || 0;
            const unit    = item.unit_name || (item.unit ? (item.unit.unit_name || item.unit.name || 'pcs') : 'pcs');
            const catName = item.category_name || (item.category ? item.category.category_name : 'N/A');
            const isOut   = qtyNum <= 0;
            const isLow   = qtyNum > 0 && qtyNum <= 5;
            const imgSrc  = item.img_url ? item.img_url : "{{ asset('backend/assets/img/product-img.svg') }}";
            const qtyColor = isOut ? 'text-rose-600' : (isLow ? 'text-amber-600' : 'text-slate-800');

            mobileList.innerHTML += `
                <div class="control-border rounded-xl p-3 bg-white dark:bg-slate-900 shadow-sm flex flex-col gap-2.5">
                    <div class="flex gap-3 items-center">
                        <img src="${imgSrc}" alt="${item.product_name}" class="w-12 h-12 rounded-lg object-contain border border-slate-100 dark:border-slate-700 flex-shrink-0 p-0.5 cursor-pointer hover:opacity-80 transition-opacity" onclick="openImagePreview('${imgSrc}')" title="Click to view image" />
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-1 mb-0.5">
                                <p class="font-bold text-sm text-slate-800 dark:text-slate-100 m-0 truncate" title="${item.product_name || ''}">${formatProductName(item.product_name, 3)}</p>
                                <span class="text-xs font-bold ${qtyColor} flex-shrink-0">${qtyNum} ${unit}</span>
                            </div>
                            <p class="text-xs text-slate-400 mb-0">${catName} &bull; <span class="font-mono">${formatProductCode(item.barcode_display || item.barcode || item.product_code)}</span></p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-800 text-xs">
                        <div class="flex gap-3">
                            <span class="text-rose-600 font-semibold">Cost: ৳ ${bdFormat(item.cost_price)}</span>
                            <span class="text-emerald-600 font-semibold">Sell: ৳ ${bdFormat(item.sell_price)}</span>
                        </div>
                        <button type="button" onclick="openAdjustModal(${item.id})" class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-bold gap-1 shadow-sm">
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                            <span>Adjust</span>
                        </button>
                    </div>
                </div>`;
        });

        renderPagination(total, totalPages, perPage, start);
    }

    function renderPagination(total, totalPages, perPage, start) {
        const displayInfo = document.getElementById('display-info');
        const end = Math.min(start + perPage, total);
        displayInfo.textContent = total > 0 ? `Showing ${start + 1} to ${end} of ${total} entries` : 'No entries to display';

        const pg = document.getElementById('pagination');
        pg.innerHTML = '';
        if (totalPages <= 1) return;

        // Prev
        pg.innerHTML += `<button onclick="goPage(${currentPage - 1})" class="pg-btn" ${currentPage === 1 ? 'disabled' : ''}>Prev</button>`;

        // Numbers
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                pg.innerHTML += `<button onclick="goPage(${i})" class="pg-btn ${i === currentPage ? 'pg-active' : ''}">${i}</button>`;
            } else if (i === currentPage - 3 || i === currentPage + 3) {
                pg.innerHTML += `<span class="pg-ellipsis">...</span>`;
            }
        }

        // Next
        pg.innerHTML += `<button onclick="goPage(${currentPage + 1})" class="pg-btn" ${currentPage === totalPages ? 'disabled' : ''}>Next</button>`;
    }

    function goPage(p) {
        currentPage = p;
        renderTable();
    }

    // ── Adjust Modal Handlers ──
    function openAdjustModal(productId) {
        const product = allProductData.find(p => p.id === productId);
        if (!product) return;

        document.getElementById("adjustProductId").value = product.id;
        document.getElementById("adjustProductName").innerText = product.product_name;
        const unitName = product.unit_name || (product.unit ? (product.unit.unit_name || product.unit.name || 'Pcs') : 'Pcs');
        document.getElementById("adjustCurrentStock").innerText = `${parseFloat(product.quantity || 0)} ${unitName}`;
        document.getElementById("adjustUnitLabel").innerText = unitName;
        document.getElementById("newPhysicalQuantity").value = parseFloat(product.quantity || 0);

        selectReason("Physical Inventory Recount");

        const modal = document.getElementById("adjustStockModal");
        if (modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }
        modal.style.setProperty('display', 'flex', 'important');
        setTimeout(() => {
            const input = document.getElementById("newPhysicalQuantity");
            if (input) { input.focus(); input.select(); }
        }, 100);
    }

    function closeAdjustModal() {
        const modal = document.getElementById("adjustStockModal");
        if (modal) modal.style.setProperty('display', 'none', 'important');
        const menu = document.getElementById('reasonDropdownMenu');
        if (menu) {
            menu.classList.add('hidden');
            menu.style.top = 'calc(100% + 6px)';
            menu.style.bottom = 'auto';
        }
        const chevron = document.getElementById('reasonChevronIcon');
        if (chevron) chevron.style.transform = 'rotate(0deg)';
    }

    function toggleReasonMenu(e) {
        if (e) { e.preventDefault(); e.stopPropagation(); }
        const menu = document.getElementById('reasonDropdownMenu');
        const chevron = document.getElementById('reasonChevronIcon');
        const wrapper = document.getElementById('customReasonWrapper') || document.getElementById('reasonSelectBtn');
        if (!menu) return;
        const isHidden = menu.classList.contains('hidden');
        if (isHidden) {
            // Dynamic place change: check available space below on screen
            const triggerEl = document.getElementById('reasonSelectBtn') || wrapper || menu.parentElement;
            const rect = triggerEl.getBoundingClientRect();
            const spaceBelow = window.innerHeight - rect.bottom;
            const spaceAbove = rect.top;

            if (spaceBelow < 240 && spaceAbove > spaceBelow) {
                // Not enough space below, show on top of field
                menu.style.top = 'auto';
                menu.style.bottom = 'calc(100% + 6px)';
                menu.style.boxShadow = '0 -16px 36px rgba(0, 0, 0, 0.22)';
            } else {
                // Enough space below, show below field
                menu.style.bottom = 'auto';
                menu.style.top = 'calc(100% + 6px)';
                menu.style.boxShadow = '0 16px 36px rgba(0, 0, 0, 0.22)';
            }

            menu.classList.remove('hidden');
            if (chevron) chevron.style.transform = 'rotate(180deg)';
        } else {
            menu.classList.add('hidden');
            if (chevron) chevron.style.transform = 'rotate(0deg)';
        }
    }

    function selectReason(val) {
        const input = document.getElementById('adjustmentReason');
        const label = document.getElementById('reasonSelectedText');
        if (input) input.value = val;
        if (label) label.innerText = val;
        document.querySelectorAll('.custom-select-option').forEach(opt => {
            const isMatch = opt.getAttribute('data-value') === val;
            opt.classList.toggle('selected', isMatch);
            const check = opt.querySelector('.option-check');
            if (check) check.classList.toggle('hidden', !isMatch);
        });
        const menu = document.getElementById('reasonDropdownMenu');
        if (menu) menu.classList.add('hidden');
        const chevron = document.getElementById('reasonChevronIcon');
        if (chevron) chevron.style.transform = 'rotate(0deg)';
    }

    // Close dropdown on outside click
    document.addEventListener('click', function(e) {
        const wrapper = document.getElementById('customReasonWrapper');
        const menu = document.getElementById('reasonDropdownMenu');
        if (menu && !menu.classList.contains('hidden')) {
            if (wrapper && !wrapper.contains(e.target)) {
                menu.classList.add('hidden');
                const chevron = document.getElementById('reasonChevronIcon');
                if (chevron) chevron.style.transform = 'rotate(0deg)';
            }
        }
    });

    // ── Image Preview Modal Handlers ──
    function openImagePreview(src) {
        if (!src) return;
        const modal = document.getElementById('productImageModal');
        const img = document.getElementById('previewModalImg');
        if (img) img.src = src;
        if (modal) modal.style.setProperty('display', 'flex', 'important');
    }

    function closeImagePreview() {
        const modal = document.getElementById('productImageModal');
        if (modal) modal.style.setProperty('display', 'none', 'important');
        const img = document.getElementById('previewModalImg');
        if (img) img.src = '';
    }

    // Close modals on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAdjustModal();
            closeImagePreview();
        }
    });

    async function handleAdjustSubmit(e) {
        e.preventDefault();
        const saveBtn = document.getElementById("saveAdjustBtn");
        const prodId = document.getElementById("adjustProductId").value;
        const newQty = parseFloat(document.getElementById("newPhysicalQuantity").value);
        const reason = document.getElementById("adjustmentReason").value;

        if (isNaN(newQty) || newQty < 0) {
            showExportToast("Please enter a valid stock quantity (≥ 0).", "#be123c");
            return;
        }

        saveBtn.disabled = true;
        saveBtn.innerHTML = `<span>Saving...</span>`;

        try {
            const token = localStorage.getItem("token") || "";
            const res = await axios.post("/api/battery/stock-adjust", {
                product_id: prodId,
                new_quantity: newQty,
                reason: reason
            }, HeaderToken());

            if (res.data.status === "success") {
                showExportToast(res.data.message || "Stock successfully updated!", "#15803d");
                closeAdjustModal();
                await loadStockOverviewData();
            } else {
                showExportToast(res.data.message || "Failed to update stock.", "#be123c");
            }
        } catch (err) {
            console.error("Stock Adjust Error:", err);
            const msg = (err.response && err.response.data && err.response.data.message) ? err.response.data.message : "Error updating stock.";
            showExportToast(msg, "#be123c");
        } finally {
            saveBtn.disabled = false;
            saveBtn.innerHTML = `<span>Save Stock Update</span>`;
        }
    }

    // ── Export Handlers (Excel, PDF, Print) ──
    function getExportData() {
        return getFilteredList();
    }

    function exportExcel() {
        const data = getExportData();
        if (!data || data.length === 0) {
            showExportToast('No stock data to export!', '#be123c');
            return;
        }

        let totQty = 0, totCost = 0, totSell = 0;
        let rowsHtml = '';
        data.forEach((item, idx) => {
            const qty = parseFloat(item.quantity || 0);
            const cp = parseFloat(item.cost_price || 0);
            const sp = parseFloat(item.sell_price || 0);
            const unit = item.unit_name || (item.unit ? (item.unit.unit_name || item.unit.name || 'Pcs') : 'Pcs');
            totQty += qty;
            totCost += (cp * qty);
            totSell += (sp * qty);
            const status = qty <= 0 ? 'Out of Stock' : (qty <= 5 ? 'Low Stock' : 'Available');
            const cleanBarcode = formatProductCode(item.barcode_display || item.barcode || item.product_code);
            const cleanName = (item.product_name || '-').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            const cleanCat = (item.category_name || (item.category ? item.category.category_name : 'N/A')).replace(/</g, '&lt;').replace(/>/g, '&gt;');

            rowsHtml += `<tr>` +
                `<td align="center" style="border:1px solid #cbd5e1; padding:6px; mso-number-format:'0';">${idx + 1}</td>` +
                `<td align="left" style="border:1px solid #cbd5e1; padding:6px; mso-number-format:'\\@';">${cleanName}</td>` +
                `<td align="left" style="border:1px solid #cbd5e1; padding:6px; mso-number-format:'\\@';">${cleanBarcode}</td>` +
                `<td align="left" style="border:1px solid #cbd5e1; padding:6px; mso-number-format:'\\@';">${cleanCat}</td>` +
                `<td align="center" style="border:1px solid #cbd5e1; padding:6px;">${qty} ${unit}</td>` +
                `<td align="right" style="border:1px solid #cbd5e1; padding:6px; mso-number-format:'#,##0.00';">${cp.toFixed(2)}</td>` +
                `<td align="right" style="border:1px solid #cbd5e1; padding:6px; mso-number-format:'#,##0.00';">${sp.toFixed(2)}</td>` +
                `<td align="center" style="border:1px solid #cbd5e1; padding:6px;">${status}</td>` +
            `</tr>`;
        });

        const filterTitle = currentFilter === 'low' ? 'Low Stock' : (currentFilter === 'out' ? 'Out of Stock' : 'All Stock');
        const dateStr = new Date().toLocaleDateString('en-GB');

        const excelHtml = `<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">` +
            `<head>` +
            `<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">` +
            `<style>` +
            `th { background-color: #15803d; color: #ffffff; font-weight: bold; border: 1px solid #15803d; }` +
            `td { border: 1px solid #cbd5e1; }` +
            `</style>` +
            `</head>` +
            `<body>` +
            `<table border="1" style="border-collapse:collapse; font-family:Arial, sans-serif; font-size:11px;">` +
            `<thead>` +
            `<tr><th colspan="8" style="background-color:#15803d; color:#ffffff; font-size:15px; font-weight:bold; text-align:center; height:32px; border:1px solid #15803d;">MARSS CORPORATION</th></tr>` +
            `<tr><th colspan="8" style="background-color:#f0fdf4; color:#166534; font-size:11px; font-weight:bold; text-align:center; height:24px; border:1px solid #bbf7d0;">Battery Module — Stock Overview Report (${filterTitle}) - ${dateStr}</th></tr>` +
            `<tr style="background-color:#15803d; color:#ffffff; font-weight:bold; height:26px;">` +
            `<th style="background-color:#15803d; color:#ffffff; text-align:center; width:45px; border:1px solid #15803d;">SL</th>` +
            `<th style="background-color:#15803d; color:#ffffff; text-align:left; width:220px; border:1px solid #15803d;">Product Name</th>` +
            `<th style="background-color:#15803d; color:#ffffff; text-align:left; width:160px; border:1px solid #15803d;">Barcode / Code</th>` +
            `<th style="background-color:#15803d; color:#ffffff; text-align:left; width:130px; border:1px solid #15803d;">Category</th>` +
            `<th style="background-color:#15803d; color:#ffffff; text-align:center; width:90px; border:1px solid #15803d;">Stock Qty</th>` +
            `<th style="background-color:#15803d; color:#ffffff; text-align:right; width:110px; border:1px solid #15803d;">Cost Price (BDT)</th>` +
            `<th style="background-color:#15803d; color:#ffffff; text-align:right; width:110px; border:1px solid #15803d;">Sell Price (BDT)</th>` +
            `<th style="background-color:#15803d; color:#ffffff; text-align:center; width:100px; border:1px solid #15803d;">Status</th>` +
            `</tr>` +
            `</thead>` +
            `<tbody>${rowsHtml}</tbody>` +
            `<tfoot>` +
            `<tr style="font-weight:bold; background-color:#f1f5f9; height:26px;">` +
            `<td colspan="4" align="right" style="border:1px solid #cbd5e1; font-weight:bold; padding:6px;">Grand Total:</td>` +
            `<td align="center" style="border:1px solid #cbd5e1; font-weight:bold; color:#15803d; padding:6px;">${totQty}</td>` +
            `<td align="right" style="border:1px solid #cbd5e1; font-weight:bold; padding:6px;">৳ ${totCost.toFixed(2)}</td>` +
            `<td align="right" style="border:1px solid #cbd5e1; font-weight:bold; color:#047857; padding:6px;">৳ ${totSell.toFixed(2)}</td>` +
            `<td style="border:1px solid #cbd5e1;"></td>` +
            `</tr>` +
            `</tfoot>` +
            `</table>` +
            `</body>` +
            `</html>`;

        const blob = new Blob(['\ufeff', excelHtml], { type: 'application/vnd.ms-excel;charset=utf-8' });
        const a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = `battery_stock_overview_${currentFilter}_${new Date().toISOString().split('T')[0]}.xls`;
        a.click();
        showExportToast('Excel file downloaded successfully!', '#15803d');
    }

    function exportPDF() {
        const data = getExportData();
        if (!data || data.length === 0) {
            showExportToast('No stock data to export!', '#be123c');
            return;
        }

        showExportToast('Preparing PDF download...', '#15803d');
        const container = document.createElement('div');
        container.style.cssText = 'width: 690px; padding: 12px; font-family: Arial, sans-serif; background: #ffffff !important; color: #111111 !important; box-sizing: border-box;';

        let totQty = 0, totCost = 0, totSell = 0;
        let rowsHtml = '';
        data.forEach((item, idx) => {
            const qty = parseFloat(item.quantity || 0);
            const cp = parseFloat(item.cost_price || 0);
            const sp = parseFloat(item.sell_price || 0);
            const unit = item.unit_name || (item.unit ? (item.unit.unit_name || item.unit.name || 'Pcs') : 'Pcs');
            totQty += qty;
            totCost += (cp * qty);
            totSell += (sp * qty);
            const status = qty <= 0 ? 'Out of Stock' : (qty <= 5 ? 'Low Stock' : 'Available');
            const bg = (idx % 2 === 1) ? '#f8fafc' : '#ffffff';
            rowsHtml += `
                <tr style="background: ${bg};">
                    <td style="text-align:center; padding:4px; border:1px solid #cbd5e1; font-size:9.5px;">${idx + 1}</td>
                    <td style="padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px;">${item.product_name || '-'}</td>
                    <td style="padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px; font-family:monospace;">${formatProductCode(item.barcode_display || item.barcode || item.product_code)}</td>
                    <td style="padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px;">${item.category_name || (item.category ? item.category.category_name : 'N/A')}</td>
                    <td style="text-align:center; padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px; font-weight:bold; color:${qty <= 0 ? '#be123c' : (qty <= 5 ? '#d97706' : '#15803d')};">${qty} ${unit}</td>
                    <td style="text-align:right; padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px;">৳ ${bdFormat(cp)}</td>
                    <td style="text-align:right; padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px; color:#047857; font-weight:bold;">৳ ${bdFormat(sp)}</td>
                    <td style="text-align:center; padding:4px 6px; border:1px solid #cbd5e1; font-size:9px; font-weight:bold; color:${qty <= 0 ? '#be123c' : (qty <= 5 ? '#b45309' : '#15803d')};">${status}</td>
                </tr>
            `;
        });

        const filterTitle = currentFilter === 'low' ? 'Low Stock' : (currentFilter === 'out' ? 'Out of Stock' : 'All Stock Items');
        container.innerHTML = `
            <div style="text-align: center; border-bottom: 2px solid #15803d; padding-bottom: 6px; margin-bottom: 8px;">
                <h1 style="margin: 0; color: #15803d; font-size: 18px; font-weight: 800;">MARSS CORPORATION</h1>
                <p style="margin: 2px 0; font-size: 10px; color: #475569;">Battery Module — Stock Overview Report (${filterTitle})</p>
                <p style="margin: 2px 0; font-size: 10px; color: #64748b;">Date: ${new Date().toLocaleDateString('en-GB')}</p>
                <div style="display: flex; justify-content: space-around; margin: 6px 0; padding: 5px 8px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 10px; font-weight: 700;">
                    <span>Filter: <strong>${filterTitle}</strong></span>
                    <span>Total Records: <strong>${data.length}</strong></span>
                    <span>Total Units: <strong>${totQty}</strong></span>
                </div>
            </div>
            <table style="width: 100%; border-collapse: collapse; font-size: 9.5px;">
                <thead>
                    <tr style="background-color: #15803d; color: #ffffff;">
                        <th style="padding: 5px; text-align: center; border: 1px solid #15803d;">SL</th>
                        <th style="padding: 5px; text-align: left; border: 1px solid #15803d;">Product Name</th>
                        <th style="padding: 5px; text-align: left; border: 1px solid #15803d;">Barcode / Code</th>
                        <th style="padding: 5px; text-align: left; border: 1px solid #15803d;">Category</th>
                        <th style="padding: 5px; text-align: center; border: 1px solid #15803d;">Stock Qty</th>
                        <th style="padding: 5px; text-align: right; border: 1px solid #15803d;">Cost Price</th>
                        <th style="padding: 5px; text-align: right; border: 1px solid #15803d;">Sell Price</th>
                        <th style="padding: 5px; text-align: center; border: 1px solid #15803d;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    ${rowsHtml}
                </tbody>
                <tfoot>
                    <tr style="background-color: #f1f5f9; font-weight: bold; border-top: 2px solid #15803d;">
                        <td colspan="4" style="text-align: right; padding: 5px; border: 1px solid #cbd5e1;">Grand Total:</td>
                        <td style="text-align: center; padding: 5px; border: 1px solid #cbd5e1; color:#15803d;">${totQty}</td>
                        <td style="text-align: right; padding: 5px; border: 1px solid #cbd5e1;">৳ ${bdFormat(totCost)}</td>
                        <td style="text-align: right; padding: 5px; border: 1px solid #cbd5e1; color:#047857;">৳ ${bdFormat(totSell)}</td>
                        <td style="border: 1px solid #cbd5e1;"></td>
                    </tr>
                </tfoot>
            </table>
            <div style="margin-top: 36px; display: flex; justify-content: space-between; text-align: center; font-size: 10px; font-weight: 600; padding: 0 20px;">
                <div style="border-top: 1px solid #333; width: 140px; padding-top: 4px;">Cashier Signature</div>
                <div style="border-top: 1px solid #333; width: 140px; padding-top: 4px;">Accountant Signature</div>
                <div style="border-top: 1px solid #333; width: 140px; padding-top: 4px;">Owner Signature</div>
            </div>
        `;

        const opt = {
            margin: [8, 8, 8, 8],
            filename: `battery_stock_overview_${currentFilter}_${new Date().toISOString().split('T')[0]}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true, backgroundColor: '#ffffff' },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        html2pdf().set(opt).from(container).save().then(() => {
            showExportToast('PDF downloaded successfully!', '#15803d');
        }).catch(err => {
            console.error('PDF error:', err);
            showExportToast('PDF generation failed', '#be123c');
        });
    }

    function printTableOnly() {
        const data = getExportData();
        if (!data || data.length === 0) {
            showExportToast('No stock data to print!', '#be123c');
            return;
        }

        const dateStr = new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
        const filterTitle = currentFilter === 'low' ? 'Low Stock' : (currentFilter === 'out' ? 'Out of Stock' : 'All Stock');

        let totQty = 0, totCost = 0, totSell = 0;
        let rowsHtml = '';
        data.forEach((item, index) => {
            const qty = parseFloat(item.quantity || 0);
            const cp = parseFloat(item.cost_price || 0);
            const sp = parseFloat(item.sell_price || 0);
            const unit = item.unit_name || (item.unit ? (item.unit.unit_name || item.unit.name || 'Pcs') : 'Pcs');
            totQty += qty;
            totCost += (cp * qty);
            totSell += (sp * qty);
            const status = qty <= 0 ? 'Out of Stock' : (qty <= 5 ? 'Low Stock' : 'Available');
            const statusColor = qty <= 0 ? '#be123c' : (qty <= 5 ? '#b45309' : '#15803d');

            rowsHtml += `
                <tr>
                    <td style="text-align:center; padding:4px; border:1px solid #cbd5e1; font-size:9.5px;">${index + 1}</td>
                    <td style="padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px;"><strong>${item.product_name || '-'}</strong></td>
                    <td style="padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px; font-family:monospace;">${formatProductCode(item.barcode_display || item.barcode || item.product_code)}</td>
                    <td style="padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px;">${item.category_name || (item.category ? item.category.category_name : 'N/A')}</td>
                    <td style="text-align:center; padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px; font-weight:bold; color:${qty <= 0 ? '#be123c' : (qty <= 5 ? '#d97706' : '#15803d')};">${qty} ${unit}</td>
                    <td style="text-align:right; padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px;">৳ ${bdFormat(cp)}</td>
                    <td style="text-align:right; padding:4px 6px; border:1px solid #cbd5e1; font-size:9.5px; color:#047857; font-weight:bold;">৳ ${bdFormat(sp)}</td>
                    <td style="text-align:center; padding:4px 6px; border:1px solid #cbd5e1; font-size:9px; font-weight:bold; color:${statusColor};">${status}</td>
                </tr>
            `;
        });

        const printWin = window.open('', '_blank');
        printWin.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Stock Overview - Print</title>
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
                    <p>Battery Module — Stock Overview Report (${filterTitle})</p>
                    <p>Date: ${dateStr}</p>
                    <div class="summary-bar">
                        <span>Filter: <strong>${filterTitle}</strong></span>
                        <span>Total Items: <strong>${data.length}</strong></span>
                        <span>Total Qty: <strong>${totQty}</strong></span>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th style="text-align:center; width:35px;">SL</th>
                            <th>Product Name</th>
                            <th>Barcode / Code</th>
                            <th>Category</th>
                            <th style="text-align:center;">Stock Qty</th>
                            <th style="text-align:right;">Cost Price</th>
                            <th style="text-align:right;">Sell Price</th>
                            <th style="text-align:center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${rowsHtml}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="text-align:right;">Grand Total:</td>
                            <td style="text-align:center; color:#15803d;">${totQty}</td>
                            <td style="text-align:right;">৳ ${bdFormat(totCost)}</td>
                            <td style="text-align:right; color:#047857;">৳ ${bdFormat(totSell)}</td>
                            <td></td>
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

    function showExportToast(msg, color) {
        const t = document.createElement('div');
        t.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;padding:10px 18px;border-radius:10px;background:' + color + ';color:#fff;font-size:13px;font-weight:600;box-shadow:0 4px 16px rgba(0,0,0,0.18);transition:opacity .4s';
        t.textContent = msg; document.body.appendChild(t);
        setTimeout(() => { t.style.opacity = '0'; setTimeout(() => t.remove(), 400); }, 2500);
    }
</script>

@endsection
