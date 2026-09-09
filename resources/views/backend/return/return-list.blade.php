<!-- Sales & Purchase Return Management Section Start -->
<div class="main-content">
    <div class="page-content min-h-screen flex flex-col justify-between">
        <div class="data-table flex-grow">
            
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-10">

                    <!-- 1. Top Section: Page Title & New Return Button (Fixed 38px) -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="1 4 1 10 7 10"></polyline>
                                    <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Return Management</h1>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-0">MARSS CORPORATION - Sales & Purchase Return Management</p>
                            </div>
                        </div>

                        <!-- Right Controls: + New Return Button (Fixed 38px) -->
                        <div class="flex items-center flex-wrap gap-2">
                            <button id="mainNewReturnBtn" onclick="triggerNewReturnModal()" type="button" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>New Sales Return</span>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Mode Toggle Nav Tabs (Fixed 38px height) -->
                    <div class="flex items-center gap-2 mb-4">
                        <button id="tabSalesReturnBtn" onclick="switchReturnTab('sales')" type="button" class="inline-flex items-center gap-2 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                            <i class="fa-solid fa-cart-shopping text-xs"></i>
                            <span>Sales Return</span>
                        </button>
                        <button id="tabPurchaseReturnBtn" onclick="switchReturnTab('purchase')" type="button" class="inline-flex items-center gap-2 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 active:scale-[0.98] text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                            <i class="fa-solid fa-truck-ramp-box text-xs"></i>
                            <span>Purchase Return</span>
                        </button>
                    </div>

                    <!-- 3. Quick Search Box (Fixed 38px inputs/buttons) -->
                    <div id="searchCardBox" class="rounded-xl border border-slate-300 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40 p-3.5 sm:p-4 mb-4 transition-colors" style="border-left: 4px solid #15803d !important;">
                        <h5 id="searchCardTitle" class="text-sm sm:text-base font-bold text-slate-800 dark:text-white mb-1 flex items-center gap-2">
                            <i class="fa-solid fa-magnifying-glass text-emerald-600"></i> Quick Invoice Search & Process Return
                        </h5>
                        <p id="searchCardDesc" class="text-xs text-slate-500 dark:text-slate-400 mb-2.5">Search invoice number to process sales return:</p>
                        
                        <div class="flex flex-row items-stretch gap-2.5">
                            <div class="search-input-wrapper unified-ui-border flex-1 min-w-0 min-h-[38px] flex items-center px-3 py-2 sm:py-0 sm:h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                                <input type="text" id="quickInvoiceSearchInput" style="border: none !important; outline: none !important; box-shadow: none !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0" placeholder="Enter invoice number (e.g. #InvID00001)..." onkeydown="if(event.key==='Enter') triggerQuickReturnSearch()" />
                            </div>
                            <button id="searchCardSubmitBtn" onclick="triggerQuickReturnSearch()" type="button" class="inline-flex items-center justify-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150 flex-shrink-0 whitespace-nowrap">
                                <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                                <span>Search & Return</span>
                            </button>
                        </div>
                    </div>

                    <!-- 4. History Controls Row: Title + Search & Entries -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2.5 sm:gap-3 mb-4">
                        <div class="flex items-center gap-2">
                            <h5 id="historyTableTitle" class="text-base sm:text-lg font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0 flex items-center gap-2">
                                <i class="fa-solid fa-clock-rotate-left text-emerald-600"></i> Sales Return History
                            </h5>
                            <span id="returnRecordCountBadge" class="display-info-box font-bold text-emerald-700 dark:text-emerald-400 px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-slate-800 text-xs">0 Records</span>
                        </div>

                        <!-- Search Bar + Show Entry Side-by-Side -->
                        <div class="flex items-center gap-2 sm:gap-2.5 w-full md:w-auto">
                            <!-- Search Bar -->
                            <div class="search-input-wrapper unified-ui-border flex-1 md:w-[260px] lg:w-[300px] h-[38px] flex items-center px-3 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                                <input type="text" id="historySearchInput" style="border: none !important; outline: none !important; box-shadow: none !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0" placeholder="Filter returns..." />
                            </div>

                            <!-- Entries Selector: 15 default -->
                            <div class="entries-wrapper unified-ui-border flex items-center gap-1 bg-white dark:bg-slate-800/90 px-3 h-[38px] rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 shadow-sm transition-all hover:border-emerald-500 flex-shrink-0">
                                <span class="text-slate-400 dark:text-slate-400 text-[11px] uppercase tracking-wider font-bold">Show:</span>
                                <select id="entries" class="bg-transparent border-0 text-xs font-bold text-emerald-700 dark:text-emerald-400 focus:outline-none cursor-pointer py-1 pr-1">
                                    <option value="15" selected class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">15</option>
                                    <option value="50" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">50</option>
                                    <option value="100" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">100</option>
                                    <option value="200" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">200</option>
                                    <option value="500" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">500</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop Table (SL left, Refund Amount right) -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[40px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                    <th class="p-[10px] text-start w-[120px] whitespace-nowrap">Return Date</th>
                                    <th id="thInvoiceNo" class="p-[10px] text-start w-[130px] whitespace-nowrap">Invoice No</th>
                                    <th id="thPartyName" class="p-[10px] text-start whitespace-nowrap">Customer Name</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Returned Product</th>
                                    <th class="p-[10px] text-center w-[90px] whitespace-nowrap">Qty</th>
                                    <th class="p-[10px] text-end w-[140px] rounded-tr-2xl whitespace-nowrap">Refund Amount</th>
                                </tr>
                            </thead>
                            <tbody id="tableList" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200"></tbody>
                            <tfoot class="bg-slate-50/90 dark:bg-slate-800/70 text-slate-800 dark:text-slate-100 font-bold border-t-2 border-emerald-600/30 dark:border-emerald-600/20 text-xs sm:text-sm">
                                <tr>
                                    <td colspan="5" class="p-[10px] text-end font-bold text-slate-600 dark:text-slate-300">Total Returned Refund Value:</td>
                                    <td id="tfootTotalQty" class="p-[10px] text-center font-bold text-slate-800 dark:text-slate-100 whitespace-nowrap">0 pcs</td>
                                    <td id="tfootTotalAmount" class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ 0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Mobile Card List View (< 768px) -->
                    <div id="mobileCardList" class="block md:hidden mb-3 space-y-3"></div>

                    <!-- Modern Smart Pagination and Display Info Footer -->
                    <div class="flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-800 gap-3">
                        <div id="display-info"></div>
                        <div id="pagination" class="flex items-center gap-1 sm:gap-1.5 flex-nowrap justify-center max-w-full overflow-x-auto pb-1"></div>
                    </div>

                </div>
            </div>

        </div>

        <!-- 5. Sticky Bottom Copyright Section -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)]">
            <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>

    </div>
</div>
<!-- Sales & Purchase Return Management Section End -->

<style>
    .product-card-body {
        padding: 10px !important;
    }
    @media (min-width: 768px) {
        .product-card-body {
            padding: 16px !important;
        }
    }

    .unified-ui-border {
        border: 1.5px solid #cbd5e1 !important;
    }

    .search-input-wrapper:focus-within {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.25) !important;
    }

    #quickInvoiceSearchInput,
    #quickInvoiceSearchInput:focus,
    #historySearchInput,
    #historySearchInput:focus,
    body[light-mode="dark"] #quickInvoiceSearchInput,
    body[light-mode="dark"] #historySearchInput {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }

    #printTable thead th {
        white-space: nowrap !important;
        padding: 10px !important;
    }
    #printTable tbody td,
    #printTable tfoot td {
        padding: 10px !important;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.25rem 0.65rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
    }

    .data-table {
        background: transparent !important;
    }
    body[light-mode="dark"] .data-table,
    body[data-layout-mode="dark"] .data-table,
    html.dark .data-table,
    body.dark-mode .data-table,
    body.dark .data-table {
        background: transparent !important;
        background-color: transparent !important;
    }

    /* Dark Mode */
    body[light-mode="dark"] .card,
    body[data-layout-mode="dark"] .card,
    html.dark .card,
    body.dark-mode .card,
    body.dark .card {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .card-body,
    body[data-layout-mode="dark"] .card-body,
    html.dark .card-body,
    body.dark-mode .card-body,
    body.dark .card-body {
        background-color: #0f172a !important;
    }
    body[light-mode="dark"] .page-content,
    body[data-layout-mode="dark"] .page-content,
    html.dark .page-content {
        background-color: #0b0f19 !important;
    }
    body[light-mode="dark"] .table-responsive,
    body[data-layout-mode="dark"] .table-responsive,
    html.dark .table-responsive {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .unified-ui-border,
    body[data-layout-mode="dark"] .unified-ui-border,
    html.dark .unified-ui-border {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #printTable,
    body[light-mode="dark"] #printTable th,
    body[light-mode="dark"] #printTable td,
    body[light-mode="dark"] #printTable tr,
    body[light-mode="dark"] #printTable tfoot {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #printTable tbody tr:hover {
        background-color: rgba(30, 41, 59, 0.6) !important;
    }

    body[light-mode="dark"] #quickInvoiceSearchInput,
    body[light-mode="dark"] #historySearchInput,
    body[light-mode="dark"] .search-input-wrapper,
    body[data-layout-mode="dark"] .search-input-wrapper,
    html.dark .search-input-wrapper,
    body.dark-mode .search-input-wrapper,
    body.dark .search-input-wrapper {
        border-color: #334155 !important;
        background-color: rgba(30, 41, 59, 0.9) !important;
    }
    body[light-mode="dark"] .entries-wrapper,
    body[data-layout-mode="dark"] .entries-wrapper,
    html.dark .entries-wrapper,
    body.dark-mode .entries-wrapper,
    body.dark .entries-wrapper {
        border-color: #334155 !important;
        background-color: rgba(30, 41, 59, 0.9) !important;
    }
    body[light-mode="dark"] #searchCardBox,
    body[data-layout-mode="dark"] #searchCardBox,
    html.dark #searchCardBox,
    body.dark-mode #searchCardBox,
    body.dark #searchCardBox {
        background-color: rgba(30, 41, 59, 0.4) !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #tabPurchaseReturnBtn,
    body[data-layout-mode="dark"] #tabPurchaseReturnBtn,
    html.dark #tabPurchaseReturnBtn,
    body.dark-mode #tabPurchaseReturnBtn,
    body.dark #tabPurchaseReturnBtn {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .return-mobile-card,
    body[data-layout-mode="dark"] .return-mobile-card,
    html.dark .return-mobile-card,
    body[light-mode="dark"] #display-info .display-info-box,
    body[data-layout-mode="dark"] #display-info .display-info-box,
    html.dark #display-info .display-info-box {
        border-color: #334155 !important;
    }

    /* Pagination */
    .custom-pagination-btn {
        min-width: 32px;
        height: 32px;
        padding: 0 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        background-color: #ffffff;
        color: #334155;
        border: 1.5px solid #cbd5e1;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        cursor: pointer;
        transition: all 0.15s ease-in-out;
        user-select: none;
    }
    .custom-pagination-btn:hover:not(:disabled) {
        background-color: #f1f5f9;
        border-color: #94a3b8;
        color: #0f172a;
    }
    .custom-pagination-btn.active {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
        box-shadow: 0 2px 4px rgba(21, 128, 61, 0.25) !important;
    }
    .custom-pagination-btn:disabled,
    .custom-pagination-btn.disabled {
        opacity: 0.45;
        cursor: not-allowed !important;
        pointer-events: none;
    }
    .custom-pagination-btn.pagination-nav-btn {
        font-weight: 600;
        padding: 0 12px;
    }

    body[light-mode="dark"] .custom-pagination-btn,
    body[data-layout-mode="dark"] .custom-pagination-btn,
    html.dark .custom-pagination-btn,
    body.dark-mode .custom-pagination-btn,
    body.dark .custom-pagination-btn {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .custom-pagination-btn:hover:not(:disabled),
    body[data-layout-mode="dark"] .custom-pagination-btn:hover:not(:disabled),
    html.dark .custom-pagination-btn:hover:not(:disabled),
    body.dark-mode .custom-pagination-btn:hover:not(:disabled),
    body.dark .custom-pagination-btn:hover:not(:disabled) {
        background-color: #334155 !important;
        border-color: #475569 !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] .custom-pagination-btn.active,
    body[data-layout-mode="dark"] .custom-pagination-btn.active,
    html.dark .custom-pagination-btn.active,
    body.dark-mode .custom-pagination-btn.active,
    body.dark .custom-pagination-btn.active {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }

    @media (max-width: 768px) {
        .page-content {
            padding-left: 8px !important;
            padding-right: 8px !important;
            padding-top: 76px !important;
            padding-bottom: 8px !important;
        }
        .card-body {
            padding: 10px 8px !important;
        }
        #pagination {
            gap: 4px !important;
            flex-wrap: nowrap !important;
            justify-content: center !important;
            max-width: 100% !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
        }
        .custom-pagination-btn {
            min-width: 28px !important;
            height: 28px !important;
            padding: 0 6px !important;
            font-size: 11px !important;
            border-radius: 6px !important;
        }
        .custom-pagination-btn.pagination-nav-btn {
            padding: 0 6px !important;
            font-size: 10.5px !important;
        }
    }
</style>

<script>
    let activeReturnTab = 'sales'; // 'sales' or 'purchase'
    let rawReturnList = [];
    let currentPage = 1;
    let pageSize = 15;

    document.addEventListener("DOMContentLoaded", () => {
        fetchActiveReturnList();

        $("#historySearchInput").on("keyup search input", function () {
            currentPage = 1;
            renderPaginatedReturnList();
        });

        $("#entries").on("change", function () {
            pageSize = parseInt($(this).val()) || 15;
            currentPage = 1;
            renderPaginatedReturnList();
        });
    });

    function switchReturnTab(tab) {
        activeReturnTab = tab;
        const salesBtn = document.getElementById('tabSalesReturnBtn');
        const purchaseBtn = document.getElementById('tabPurchaseReturnBtn');
        const mainNewBtn = document.getElementById('mainNewReturnBtn');

        const searchCardBox = document.getElementById('searchCardBox');
        const searchTitle = document.getElementById('searchCardTitle');
        const searchDesc = document.getElementById('searchCardDesc');
        const searchInput = document.getElementById('quickInvoiceSearchInput');

        const historyTitle = document.getElementById('historyTableTitle');
        const thInvoiceNo = document.getElementById('thInvoiceNo');
        const thPartyName = document.getElementById('thPartyName');

        if (tab === 'purchase') {
            salesBtn.className = 'inline-flex items-center gap-2 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 active:scale-[0.98] text-sm font-semibold rounded-xl shadow-sm transition-all duration-150';
            purchaseBtn.className = 'inline-flex items-center gap-2 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150';
            
            mainNewBtn.innerHTML = `
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>New Purchase Return</span>
            `;

            searchCardBox.style.borderLeft = '5px solid #0d9488 !important';
            searchTitle.innerHTML = `<i class="fa-solid fa-magnifying-glass text-teal-600"></i> Quick Purchase Memo Search & Process Return`;
            searchDesc.innerText = `Search purchase memo number to process return to supplier:`;
            searchInput.placeholder = `Enter purchase memo number (e.g. #PurID00001)...`;

            historyTitle.innerHTML = `<i class="fa-solid fa-truck-ramp-box text-emerald-600"></i> Purchase Return History`;
            thInvoiceNo.innerText = 'Purchase Memo No';
            thPartyName.innerText = 'Supplier Name';
        } else {
            salesBtn.className = 'inline-flex items-center gap-2 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150';
            purchaseBtn.className = 'inline-flex items-center gap-2 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 active:scale-[0.98] text-sm font-semibold rounded-xl shadow-sm transition-all duration-150';

            mainNewBtn.innerHTML = `
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>New Sales Return</span>
            `;

            searchCardBox.style.borderLeft = '5px solid #15803d !important';
            searchTitle.innerHTML = `<i class="fa-solid fa-magnifying-glass text-emerald-600"></i> Quick Invoice Search & Process Return`;
            searchDesc.innerText = `Search invoice number to process sales return:`;
            searchInput.placeholder = `Enter invoice number (e.g. #InvID00001)...`;

            historyTitle.innerHTML = `<i class="fa-solid fa-clock-rotate-left text-emerald-600"></i> Sales Return History`;
            thInvoiceNo.innerText = 'Invoice No';
            thPartyName.innerText = 'Customer Name';
        }

        searchInput.value = '';
        $("#historySearchInput").val('');
        currentPage = 1;
        fetchActiveReturnList();
    }

    function triggerNewReturnModal() {
        openReturnModal('', activeReturnTab);
    }

    function triggerQuickReturnSearch() {
        const val = document.getElementById('quickInvoiceSearchInput').value.trim();
        if (!val) {
            alert(activeReturnTab === 'purchase' ? 'Please enter a purchase memo number' : 'Please enter an invoice number');
            return;
        }
        openReturnModal(val, activeReturnTab);
    }

    async function fetchActiveReturnList() {
        try {
            if (typeof showLoader === "function") showLoader();

            let url = activeReturnTab === 'purchase' ? '/api/purchase-return-list' : '/api/return-product-list';
            const res = await axios.get(url, HeaderToken());
            if (typeof hideLoader === "function") hideLoader();

            if (res.data && res.data.status === 'success') {
                rawReturnList = (activeReturnTab === 'purchase' ? res.data.PurchaseReturnData : res.data.ProductReturnData) || [];
                renderPaginatedReturnList();
            } else {
                document.getElementById("tableList").innerHTML = `<tr><td colspan="7" class="text-center py-6 text-rose-500 font-semibold">Failed to load return history</td></tr>`;
            }
        } catch (e) {
            if (typeof hideLoader === "function") hideLoader();
            console.error("Fetch Return List Error:", e);
        }
    }

    function renderPaginatedReturnList() {
        if (!rawReturnList) return;

        let searchVal = ($("#historySearchInput").val() || "").toLowerCase().trim();

        // 1. Filter
        let filtered = rawReturnList.filter(item => {
            const refNo = (activeReturnTab === 'purchase' ? item.purchase_no : item.order_no) || '';
            const partyName = (activeReturnTab === 'purchase' ? item.supplier_name : item.customer_name) || '';
            const product = item.product_name || '';
            const date = item.date || '';

            return !searchVal || 
                   refNo.toLowerCase().includes(searchVal) || 
                   partyName.toLowerCase().includes(searchVal) || 
                   product.toLowerCase().includes(searchVal) ||
                   date.toLowerCase().includes(searchVal);
        });

        // 2. New data top-a dekhabe
        filtered.sort((a, b) => (b.id || 0) - (a.id || 0));

        // Total sum calculations
        let sumQty = 0;
        let sumAmount = 0;
        filtered.forEach(item => {
            sumQty += parseInt(item.quantity) || 0;
            sumAmount += parseFloat(item.amount) || 0;
        });
        document.getElementById('tfootTotalQty').innerText = `${sumQty} pcs`;
        document.getElementById('tfootTotalAmount').innerText = `৳ ${formatMoney(sumAmount)}`;
        document.getElementById('returnRecordCountBadge').innerText = `${filtered.length} Records`;

        // 3. Pagination Calculations
        let totalItems = filtered.length;
        let totalPages = Math.ceil(totalItems / pageSize) || 1;
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        let startIndex = (currentPage - 1) * pageSize;
        let endIndex = Math.min(startIndex + pageSize, totalItems);
        let pageItems = filtered.slice(startIndex, endIndex);

        let tableList = $("#tableList");
        let mobileCardList = $("#mobileCardList");

        tableList.empty();
        mobileCardList.empty();

        if (pageItems.length === 0) {
            tableList.html(`<tr><td colspan="7" class="text-center text-rose-500 p-8 font-semibold"><svg class="w-6 h-6 mx-auto mb-2 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>No ${activeReturnTab === 'purchase' ? 'purchase' : 'sales'} returns found.</td></tr>`);
            mobileCardList.html(`<div class="p-6 text-center text-rose-500 font-semibold bg-white dark:bg-slate-800 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm">No ${activeReturnTab === 'purchase' ? 'purchase' : 'sales'} returns found.</div>`);
        } else {
            pageItems.forEach(function (item, idx) {
                let realIndex = startIndex + idx;
                const qty = parseInt(item.quantity) || 0;
                const amount = parseFloat(item.amount) || 0;
                const refNo = (activeReturnTab === 'purchase' ? item.purchase_no : item.order_no) || 'N/A';
                const partyName = (activeReturnTab === 'purchase' ? item.supplier_name : item.customer_name) || 'N/A';

                // Desktop Table Row
                let row = `
                    <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors border-b border-slate-100 dark:border-slate-800">
                        <td class="p-[10px] text-center font-semibold text-slate-400 dark:text-slate-500">${realIndex + 1}</td>
                        <td class="p-[10px] text-start whitespace-nowrap font-medium text-slate-700 dark:text-slate-300"><i class="fa-regular fa-calendar-check text-emerald-600 me-1"></i> ${formatReturnDate(item.date)}</td>
                        <td class="p-[10px] text-start whitespace-nowrap"><span class="badge bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 dark:border-slate-800 font-mono font-bold">${refNo}</span></td>
                        <td class="p-[10px] text-start font-bold text-slate-800 dark:text-slate-100">${partyName}</td>
                        <td class="p-[10px] text-start font-medium text-slate-600 dark:text-slate-300">${item.product_name || '-'}</td>
                        <td class="p-[10px] text-center whitespace-nowrap"><span class="badge bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 font-bold">${qty} pcs</span></td>
                        <td class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ ${formatMoney(amount)}</td>
                    </tr>
                `;
                tableList.append(row);

                // Mobile Card View
                let mobileCard = `
                    <div class="return-mobile-card unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800/90 shadow-sm transition-all mb-3">
                        <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="badge bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold" style="font-size: 10px;">#${realIndex + 1}</span>
                                <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-slate-800 font-mono font-bold" style="font-size: 10px;">
                                    ${refNo}
                                </span>
                            </div>
                            <span class="badge bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 font-semibold" style="font-size: 10px;">
                                <i class="fa-regular fa-calendar-check me-1"></i>${formatReturnDate(item.date)}
                            </span>
                        </div>

                        <div class="mb-2">
                            <h6 class="font-bold text-slate-800 dark:text-slate-100 mb-0.5 text-sm leading-snug">${partyName}</h6>
                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                <span>Product: <strong>${item.product_name || '-'}</strong></span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 bg-slate-50 dark:bg-slate-900/50 p-2.5 rounded-xl my-2 text-center items-center border border-slate-100 dark:border-slate-800">
                            <div class="border-r border-slate-300 dark:border-slate-800 text-start px-2">
                                <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">Quantity</span>
                                <span class="font-bold text-slate-800 dark:text-slate-100 text-sm">${qty} pcs</span>
                            </div>
                            <div class="text-start px-2">
                                <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">Refund Amount</span>
                                <span class="font-bold text-rose-600 dark:text-rose-400 text-sm">৳ ${formatMoney(amount)}</span>
                            </div>
                        </div>
                    </div>`;
                mobileCardList.append(mobileCard);
            });
        }

        // 4. Update Display Info & Pagination UI
        let fromCount = totalItems > 0 ? startIndex + 1 : 0;
        let toCount = endIndex;
        $("#display-info").html(`
            <div class="flex items-center gap-1.5 text-xs sm:text-sm font-medium text-slate-500 dark:text-slate-400">
                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                <span>Showing</span>
                <span class="display-info-box font-bold text-slate-800 dark:text-slate-100 px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-800">${fromCount} – ${toCount}</span>
                <span>of</span>
                <span class="display-info-box font-bold text-emerald-700 dark:text-emerald-400 px-1.5 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-slate-800">${totalItems}</span>
                <span>returns</span>
            </div>
        `);

        renderPaginationControls(totalPages);
    }

    function renderPaginationControls(totalPages) {
        let pagContainer = $("#pagination");
        pagContainer.empty();

        if (totalPages <= 1) return;

        // Prev Button
        let prevDisabled = currentPage === 1 ? 'disabled' : '';
        let prevBtn = `<button type="button" class="custom-pagination-btn pagination-nav-btn ${prevDisabled}" ${currentPage === 1 ? 'disabled' : ''} onclick="goToPage(${currentPage - 1})">
            <svg class="w-3 h-3 me-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg> Prev
        </button>`;
        pagContainer.append(prevBtn);

        // Smart Page Numbers
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, currentPage + 2);

        if (startPage > 1) {
            pagContainer.append(`<button type="button" class="custom-pagination-btn" onclick="goToPage(1)">1</button>`);
            if (startPage > 2) {
                pagContainer.append(`<span class="px-1 text-slate-400 font-bold">...</span>`);
            }
        }

        for (let p = startPage; p <= endPage; p++) {
            let activeClass = (p === currentPage) ? 'active' : '';
            let pageBtn = `<button type="button" class="custom-pagination-btn ${activeClass}" onclick="goToPage(${p})">${p}</button>`;
            pagContainer.append(pageBtn);
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                pagContainer.append(`<span class="px-1 text-slate-400 font-bold">...</span>`);
            }
            pagContainer.append(`<button type="button" class="custom-pagination-btn" onclick="goToPage(${totalPages})">${totalPages}</button>`);
        }

        // Next Button
        let nextDisabled = currentPage === totalPages ? 'disabled' : '';
        let nextBtn = `<button type="button" class="custom-pagination-btn pagination-nav-btn ${nextDisabled}" ${currentPage === totalPages ? 'disabled' : ''} onclick="goToPage(${currentPage + 1})">
            Next <svg class="w-3 h-3 ms-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </button>`;
        pagContainer.append(nextBtn);
    }

    function goToPage(page) {
        currentPage = page;
        renderPaginatedReturnList();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    function formatReturnDate(dateString) {
        if (!dateString) return 'N/A';
        const options = { year: 'numeric', month: 'short', day: '2-digit' };
        return new Date(dateString).toLocaleDateString('en-US', options);
    }

    function formatMoney(amount) {
        if (amount === null || isNaN(amount)) return "0.00";
        return parseFloat(amount).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }
</script>
