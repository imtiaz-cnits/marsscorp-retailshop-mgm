<!-- Hero Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-screen flex flex-col justify-between">
        <div class="data-table flex-grow">
            
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-10">

                    <!-- 1. Top Section: Page Title & Header Actions (Fixed 38px) -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                    <path d="M7 15h0M2 9.5h20"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Expense & Salary Management</h1>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-0">Company expenses and staff salary records & reports</p>
                            </div>
                        </div>

                        <!-- Right Controls: + Create Expense Button (Fixed 38px) -->
                        <div class="flex items-center flex-wrap gap-2">
                            <button id="openModalBtns" onclick="openExpenseModal()" type="button" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Create Expense</span>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Live Summary Counter Cards (1 col mobile, 2 col tablet, 4 col desktop) -->
                    <div class="expense-summary-grid mb-4">
                        <!-- Total Expense -->
                        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40 p-3 sm:p-3.5 transition-colors relative overflow-hidden" style="border-left: 4px solid #dc2626 !important;">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-[11px] uppercase font-bold tracking-wider block">Total Expenses</span>
                                    <h4 class="text-rose-600 dark:text-rose-400 font-extrabold text-base sm:text-xl my-1" id="statTotalExpense">৳ 0.00</h4>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-xs font-medium"><i class="fa-solid fa-receipt me-1"></i> All Entries</span>
                                </div>
                                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400 flex items-center justify-center border border-rose-100 dark:border-slate-800 flex-shrink-0">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2"></rect><line x1="8" y1="6" x2="16" y2="6"></line><line x1="16" y1="14" x2="16" y2="18"></line><path d="M16 10h.01M12 10h.01M8 10h.01M12 14h.01M8 14h.01M12 18h.01M8 18h.01"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Today's Expense -->
                        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40 p-3 sm:p-3.5 transition-colors relative overflow-hidden" style="border-left: 4px solid #16a34a !important;">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-[11px] uppercase font-bold tracking-wider block">Today's Expense</span>
                                    <h4 class="text-emerald-600 dark:text-emerald-400 font-extrabold text-base sm:text-xl my-1" id="statTodayExpense">৳ 0.00</h4>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-xs font-medium"><i class="fa-regular fa-calendar-check me-1"></i> Today's Total</span>
                                </div>
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 flex-shrink-0">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                </div>
                            </div>
                        </div>

                        <!-- This Month's Expense -->
                        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40 p-3 sm:p-3.5 transition-colors relative overflow-hidden" style="border-left: 4px solid #0284c7 !important;">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-[11px] uppercase font-bold tracking-wider block">This Month's Expense</span>
                                    <h4 class="text-sky-600 dark:text-sky-400 font-extrabold text-base sm:text-xl my-1" id="statMonthExpense">৳ 0.00</h4>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-xs font-medium"><i class="fa-solid fa-chart-line me-1"></i> Month Total</span>
                                </div>
                                <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 dark:bg-sky-950/40 dark:text-sky-400 flex items-center justify-center border border-sky-100 dark:border-slate-800 flex-shrink-0">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Staff Total Salary -->
                        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40 p-3 sm:p-3.5 transition-colors relative overflow-hidden" style="border-left: 4px solid #6366f1 !important;">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-[11px] uppercase font-bold tracking-wider block">Staff Total Salary</span>
                                    <h4 class="text-indigo-600 dark:text-indigo-400 font-extrabold text-base sm:text-xl my-1" id="statSalaryExpense">৳ 0.00</h4>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-xs font-medium"><i class="fa-solid fa-user-tie me-1"></i> Salary Paid</span>
                                </div>
                                <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-950/40 dark:text-indigo-400 flex items-center justify-center border border-indigo-100 dark:border-slate-800 flex-shrink-0">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Controls & Filter Row: Search Bar + Show Entry Side-by-Side (38px height) -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2.5 sm:gap-3 mb-4">
                        <div class="flex items-center gap-2">
                            <h5 class="text-base sm:text-lg font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0 flex items-center gap-2">
                                <i class="fa-solid fa-list-ol text-emerald-600"></i> Expense & Salary List
                            </h5>
                        </div>

                        <!-- Search Bar + Show Entry Side-by-Side -->
                        <div class="flex items-center gap-2 sm:gap-2.5 w-full md:w-auto">
                            <!-- Search Bar -->
                            <div class="search-input-wrapper unified-ui-border flex-1 md:w-[280px] lg:w-[320px] h-[38px] flex items-center px-3 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                                <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search type/details/staff..." />
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

                    <!-- Desktop Table View -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[40px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                    <th class="p-[10px] text-start w-[110px] whitespace-nowrap">Date</th>
                                    <th class="p-[10px] text-start w-[140px] whitespace-nowrap">Expense Type</th>
                                    <th class="p-[10px] text-start w-[150px] whitespace-nowrap">Staff Profile</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Details</th>
                                    <th class="p-[10px] text-end w-[130px] whitespace-nowrap">Amount (৳)</th>
                                    <th class="p-[10px] text-center w-[75px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableList" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200"></tbody>
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

        <!-- 4. Sticky Bottom Copyright Section -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)]">
            <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>

    </div>
</div>
<!-- Expense List Main Content End -->

<style>
    /* Responsive Summary Cards: 4 columns desktop, 2 columns tablet, 1 column mobile */
    .expense-summary-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }
    @media (min-width: 640px) {
        .expense-summary-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (min-width: 992px) {
        .expense-summary-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    /* Fixed 38px Create Expense Button + Non-white hover */
    #openModalBtns {
        height: 38px !important;
        min-height: 38px !important;
        max-height: 38px !important;
        background-color: #15803d !important;
        color: #ffffff !important;
        border: none !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
        border-radius: 12px !important;
        transition: all 0.2s ease !important;
    }
    #openModalBtns:hover,
    #openModalBtns:focus,
    #openModalBtns:active {
        background-color: #16a34a !important;
        color: #ffffff !important;
        border: none !important;
    }
    #openModalBtns * {
        color: #ffffff !important;
    }

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

    #searchInput,
    #searchInput:focus,
    #searchInput:focus-visible,
    #searchInput:active,
    body[light-mode="dark"] #searchInput,
    body[light-mode="dark"] #searchInput:focus {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }

    #printTable thead th {
        white-space: nowrap !important;
        padding: 10px !important;
    }
    #printTable tbody td {
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
    body[data-layout-mode="dark"] #printTable,
    body[data-layout-mode="dark"] #printTable th,
    body[data-layout-mode="dark"] #printTable td,
    body[data-layout-mode="dark"] #printTable tr,
    body[light-mode="dark"] #printTable,
    body[light-mode="dark"] #printTable th,
    body[light-mode="dark"] #printTable td,
    body[light-mode="dark"] #printTable tr,
    html.dark #printTable th,
    html.dark #printTable td {
        border-color: #334155 !important;
    }
    body[data-layout-mode="dark"] #printTable tbody tr:hover,
    body[light-mode="dark"] #printTable tbody tr:hover,
    html.dark #printTable tbody tr:hover {
        background-color: rgba(30, 41, 59, 0.6) !important;
    }

    body[light-mode="dark"] #searchInput,
    body[light-mode="dark"] .search-input-wrapper,
    body[data-layout-mode="dark"] .search-input-wrapper,
    html.dark .search-input-wrapper,
    body.dark-mode .search-input-wrapper,
    body.dark .search-input-wrapper,
    body[light-mode="dark"] .entries-wrapper,
    body[data-layout-mode="dark"] .entries-wrapper,
    html.dark .entries-wrapper,
    body.dark-mode .entries-wrapper,
    body.dark .entries-wrapper,
    body[light-mode="dark"] .copyright,
    body[data-layout-mode="dark"] .copyright,
    body[light-mode="dark"] .expense-mobile-card,
    body[data-layout-mode="dark"] .expense-mobile-card,
    html.dark .expense-mobile-card,
    body[light-mode="dark"] #display-info .display-info-box,
    body[data-layout-mode="dark"] #display-info .display-info-box,
    html.dark #display-info .display-info-box {
        border-color: #334155 !important;
    }

    /* Summary cards & icon wrappers dark mode */
    body[data-layout-mode="dark"] .expense-summary-grid > div,
    body[light-mode="dark"] .expense-summary-grid > div,
    html.dark .expense-summary-grid > div,
    body.dark-mode .expense-summary-grid > div,
    body.dark .expense-summary-grid > div {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body[data-layout-mode="dark"] .expense-summary-grid .w-9,
    body[light-mode="dark"] .expense-summary-grid .w-9,
    html.dark .expense-summary-grid .w-9,
    body.dark-mode .expense-summary-grid .w-9,
    body.dark .expense-summary-grid .w-9 {
        border-color: #334155 !important;
    }
    body[data-layout-mode="dark"] .card .w-9,
    body[light-mode="dark"] .card .w-9,
    html.dark .card .w-9 {
        border-color: #334155 !important;
    }

    /* Action buttons styling */
    body[light-mode="dark"] #printTable td .edit-link,
    body[data-layout-mode="dark"] #printTable td .edit-link,
    html.dark #printTable td .edit-link,
    body[light-mode="dark"] #tableList td .edit-link,
    body[data-layout-mode="dark"] #tableList td .edit-link,
    html.dark #tableList td .edit-link,
    body[light-mode="dark"] .expense-mobile-card .edit-link,
    body[data-layout-mode="dark"] .expense-mobile-card .edit-link,
    html.dark .expense-mobile-card .edit-link,
    body[light-mode="dark"] #printTable td .custom-delete-modal-btn,
    body[data-layout-mode="dark"] #printTable td .custom-delete-modal-btn,
    html.dark #printTable td .custom-delete-modal-btn,
    body[light-mode="dark"] #tableList td .custom-delete-modal-btn,
    body[data-layout-mode="dark"] #tableList td .custom-delete-modal-btn,
    html.dark #tableList td .custom-delete-modal-btn,
    body[light-mode="dark"] .expense-mobile-card .custom-delete-modal-btn,
    body[data-layout-mode="dark"] .expense-mobile-card .custom-delete-modal-btn,
    html.dark .expense-mobile-card .custom-delete-modal-btn {
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
    let rawExpenseList = [];
    let currentPage = 1;
    let pageSize = 15;

    function formatBdCurrency(amount) {
        let num = parseFloat(amount);
        if (isNaN(num)) return "0.00";
        return num.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    $(document).ready(function () {
        getExpenseList();
        $("#searchInput").val("");
    });

    $("#searchInput").on("keyup search input", function () {
        currentPage = 1;
        renderPaginatedExpenseList();
    });

    $("#entries").on("change", function () {
        pageSize = parseInt($(this).val()) || 15;
        currentPage = 1;
        renderPaginatedExpenseList();
    });

    async function getExpenseList() {
        try {
            showLoader();
            let res = await axios.get("/api/expense-list", HeaderToken());
            hideLoader();

            if (res.data.status === "success" || res.data.ExpenseData) {
                rawExpenseList = res.data.ExpenseData || [];

                // Set Counter Stats
                document.getElementById('statTotalExpense').innerText = `৳ ${(res.data.subTotal || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}`;
                document.getElementById('statTodayExpense').innerText = `৳ ${(res.data.todayExpense || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}`;
                document.getElementById('statMonthExpense').innerText = `৳ ${(res.data.thisMonthExpense || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}`;
                document.getElementById('statSalaryExpense').innerText = `৳ ${(res.data.totalSalaryPaid || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}`;

                renderPaginatedExpenseList();
            }
        } catch (e) {
            hideLoader();
            console.error("Expense List fetch error:", e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    function renderPaginatedExpenseList() {
        if (!rawExpenseList) return;

        let searchVal = ($("#searchInput").val() || "").toLowerCase().trim();

        // 1. Filter
        let filtered = rawExpenseList.filter(item => {
            const type = (item.type_name || '').toLowerCase();
            const details = (item.expense_details || '').toLowerCase();
            const staff = (item.staff_name || '').toLowerCase();
            const amount = (item.expense_amount || '').toString();
            return !searchVal || type.includes(searchVal) || details.includes(searchVal) || staff.includes(searchVal) || amount.includes(searchVal);
        });

        // 2. Newest data on top
        filtered.sort((a, b) => (b.id || 0) - (a.id || 0));

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
            tableList.html('<tr><td colspan="7" class="text-center text-rose-500 p-8 font-semibold"><svg class="w-6 h-6 mx-auto mb-2 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>No expense data found.</td></tr>');
            mobileCardList.html('<div class="p-6 text-center text-rose-500 font-semibold bg-white dark:bg-slate-800 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm">No expense data found.</div>');
        } else {
            pageItems.forEach(function(item, idx) {
                let realIndex = startIndex + idx;
                const dateFormatted = item.date ? new Date(item.date).toLocaleDateString('en-GB') : '-';
                const amountFormatted = parseFloat(item.expense_amount || 0).toLocaleString('en-IN', {minimumFractionDigits: 2});
                
                let staffBadge = '<span class="text-slate-400 dark:text-slate-500 text-xs font-medium">General Expense</span>';
                if (item.staff_id && item.staff_name) {
                    staffBadge = `
                        <a href="/admin-dashboard-staff-profile?id=${item.staff_id}" class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 dark:border-slate-800 hover:underline" title="View staff profile">
                            <i class="fa-solid fa-user-tie text-[10px]"></i> ${item.staff_name}
                        </a>
                    `;
                } else if (item.staff_name) {
                    staffBadge = `<span class="badge bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 text-xs">${item.staff_name}</span>`;
                }

                // Action Buttons (SL left, Action far right)
                let actionHtml = `
                    <div class="flex items-center justify-center gap-1.5">
                        <button data-id="${item.id}" type="button" class="edit-link w-[30px] h-[30px] rounded-lg bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200/80 hover:border-emerald-600 dark:bg-emerald-950/40 dark:border-slate-800 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white flex items-center justify-center transition-all duration-150 shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Edit Expense">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                        </button>
                        <button data-id="${item.id}" type="button" class="custom-delete-modal-btn w-[30px] h-[30px] rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200/80 hover:border-rose-600 dark:bg-rose-950/40 dark:border-slate-800 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white flex items-center justify-center transition-all duration-150 shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmationModal" title="Delete Expense">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </button>
                    </div>
                `;

                // Desktop Table Row
                let row = `
                    <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors border-b border-slate-100 dark:border-slate-800">
                        <td class="p-[10px] text-center font-semibold text-slate-400 dark:text-slate-500">${realIndex + 1}</td>
                        <td class="p-[10px] text-start whitespace-nowrap font-medium text-slate-700 dark:text-slate-300"><i class="fa-regular fa-calendar-check text-emerald-600 me-1"></i> ${dateFormatted}</td>
                        <td class="p-[10px] text-start whitespace-nowrap"><span class="badge bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 dark:border-slate-800 font-semibold">${item.type_name || 'N/A'}</span></td>
                        <td class="p-[10px] text-start whitespace-nowrap">${staffBadge}</td>
                        <td class="p-[10px] text-start text-xs text-slate-500 dark:text-slate-400 max-w-[250px] truncate">${item.expense_details || '-'}</td>
                        <td class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ ${amountFormatted}</td>
                        <td class="p-[10px] text-center">${actionHtml}</td>
                    </tr>
                `;
                tableList.append(row);

                // Mobile Card View
                let mobileCard = `
                    <div class="expense-mobile-card unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800/90 shadow-sm transition-all mb-3">
                        <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="badge bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold" style="font-size: 10px;">#${realIndex + 1}</span>
                                <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-slate-800 font-semibold" style="font-size: 10px;">
                                    <i class="fa-regular fa-calendar-check me-1"></i>${dateFormatted}
                                </span>
                            </div>
                            <div>
                                <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-slate-800 font-semibold" style="font-size: 10px;">${item.type_name || 'N/A'}</span>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="text-xs font-semibold text-slate-800 dark:text-slate-200 mb-1">${staffBadge}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-900/60 p-2 rounded-xl border border-slate-100 dark:border-slate-800">
                                <i class="fa-solid fa-align-left me-1 opacity-70"></i>${item.expense_details || 'No details provided'}
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2 mt-2 border-t border-slate-100 dark:border-slate-800">
                            <div>
                                <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">Amount</span>
                                <span class="font-extrabold text-rose-600 dark:text-rose-400 text-sm">৳ ${amountFormatted}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button data-id="${item.id}" type="button" class="edit-link w-[32px] h-[32px] rounded-xl bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200 dark:bg-emerald-950/40 dark:border-slate-800 dark:text-emerald-400 flex items-center justify-center transition-all shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Edit">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                </button>
                                <button data-id="${item.id}" type="button" class="custom-delete-modal-btn w-[32px] h-[32px] rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200 dark:bg-rose-950/40 dark:border-slate-800 dark:text-rose-400 flex items-center justify-center transition-all shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmationModal" title="Delete">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>`;
                mobileCardList.append(mobileCard);
            });
        }

        // Bind delete button ID listener
        $(document).off('click', '.custom-delete-modal-btn').on('click', '.custom-delete-modal-btn', function() {
            let id = $(this).data('id') || $(this).attr('data-id');
            $("#deleteID").val(id);
            $("#confirmationModal").modal('show');
        });

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
                <span>expenses</span>
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
        renderPaginatedExpenseList();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    function openExpenseModal() {
        const bsModal = document.getElementById('createExpenseModal');
        if (bsModal) {
            $('#createExpenseModal').modal('show');
            return;
        }
        const modalWrapper = document.getElementById('myModal');
        const modalSection = document.querySelector('.financemodal');
        if (modalWrapper) modalWrapper.style.display = 'block';
        if (modalSection) modalSection.style.display = 'block';
    }
</script>