<!-- Flatpickr Styles & Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Hero Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-screen flex flex-col justify-between">
        <div class="data-table flex-grow">
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-10">
                    
                    <!-- 1. Top Section: Page Title (Zero bottom margin, description removed) -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Invoices List</h1>
                        </div>
                    </div>

                    <!-- 2. Controls & Filter Rows: Searchbar + 2 Date Fields in Row 1; Show Entries + Filter + Export in Row 2 -->
                    <!-- Row 1: 3 Columns in 1 Row on Desktop: Search Bar, Start Date, End Date -->
                    <div class="row-controls-grid grid grid-cols-1 sm:grid-cols-3 gap-2.5 sm:gap-3 mb-3 sm:mb-4 w-full">
                        <!-- 1st Column: Search Bar -->
                        <div class="search-input-wrapper unified-ui-border h-[38px] flex items-center px-4 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding: 0 8px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Searching Invoice..." />
                        </div>

                        <!-- 2nd Column: Start Date with Flatpickr -->
                        <div class="date-input-wrapper unified-ui-border h-[38px] flex items-center px-4 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm focus-within:border-emerald-600 transition-all cursor-pointer">
                            <input type="text" id="startDate" name="dateInput" placeholder="Start Date" style="padding: 0 6px !important;" class="w-full bg-transparent border-0 outline-none text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200 placeholder:text-slate-400 p-0 cursor-pointer" />
                            <svg class="w-3.5 h-3.5 text-slate-400 pointer-events-none ms-1 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>

                        <!-- 3rd Column: End Date with Flatpickr -->
                        <div class="date-input-wrapper unified-ui-border h-[38px] flex items-center px-4 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm focus-within:border-emerald-600 transition-all cursor-pointer">
                            <input type="text" id="endDate" name="dateInput" placeholder="End Date" style="padding: 0 6px !important;" class="w-full bg-transparent border-0 outline-none text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200 placeholder:text-slate-400 p-0 cursor-pointer" />
                            <svg class="w-3.5 h-3.5 text-slate-400 pointer-events-none ms-1 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                    </div>

                    <!-- Row 2: Show Entries + Filter on Left, Export Buttons on Right above Table (Centered on Mobile) -->
                    <div class="row-actions-bar flex flex-col sm:flex-row items-center justify-between gap-2.5 sm:gap-3 mb-4 w-full">
                        <!-- Left Group: Show Entries + Filter Dropdown (Centered on Mobile, Left-aligned on Desktop) -->
                        <div class="filter-controls-group flex items-center justify-center sm:justify-start gap-2 sm:gap-2.5 flex-wrap w-full sm:w-auto">
                            <!-- Entries Selector (Default 15) -->
                            <div class="entries-wrapper unified-ui-border flex items-center gap-1 bg-white dark:bg-slate-800/90 px-3 h-[38px] rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 shadow-sm transition-all hover:border-emerald-500 flex-shrink-0">
                                <span class="text-slate-400 dark:text-slate-400 text-[11px] uppercase tracking-wider font-bold">Show:</span>
                                <select id="entries" class="bg-transparent border-0 text-xs font-bold text-emerald-700 dark:text-emerald-400 focus:outline-none cursor-pointer py-1 pr-1">
                                    <option value="10" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">10</option>
                                    <option value="15" selected class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">15</option>
                                    <option value="25" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">25</option>
                                    <option value="50" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">50</option>
                                    <option value="100" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">100</option>
                                </select>
                            </div>

                            <!-- Custom Quick Filter Dropdown (Compact width) -->
                            <div class="custom-searchable-select custom-filter-dropdown w-[130px] sm:w-[145px] flex-shrink-0" id="invoiceFilterDropdown">
                                <div class="select-trigger unified-ui-border flex items-center justify-between px-3 h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-sm text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-200 cursor-pointer hover:border-emerald-500 transition-all duration-150" onclick="toggleCustomInvoiceFilter()">
                                    <div class="flex items-center gap-1.5 overflow-hidden">
                                        <svg class="w-3.5 h-3.5 text-slate-500 dark:text-slate-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                                        </svg>
                                        <span id="selectedFilterLabel" class="selected-text truncate font-semibold">Filter</span>
                                    </div>
                                    <svg class="w-3.5 h-3.5 text-slate-400 chevron-icon transition-transform duration-200 flex-shrink-0 ms-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </div>
                                <div class="select-menu dropdown-menus shadow-xl" style="min-width: 170px;">
                                    <div class="select-options-list">
                                        <a href="#" data-filter="all" class="select-option-item active" onclick="selectInvoiceFilterOption(event, 'all', 'All time')">
                                            <span>All time</span>
                                            <i class="fa-solid fa-check small text-emerald-600 check-icon"></i>
                                        </a>
                                        <a href="#" data-filter="today" class="select-option-item" onclick="selectInvoiceFilterOption(event, 'today', 'Today')">
                                            <span>Today</span>
                                        </a>
                                        <a href="#" data-filter="7" class="select-option-item" onclick="selectInvoiceFilterOption(event, '7', 'Last 7 Days')">
                                            <span>Last 7 Days</span>
                                        </a>
                                        <a href="#" data-filter="30" class="select-option-item" onclick="selectInvoiceFilterOption(event, '30', 'Last Month')">
                                            <span>Last Month</span>
                                        </a>
                                        <a href="#" data-filter="365" class="select-option-item" onclick="selectInvoiceFilterOption(event, '365', 'Last Year')">
                                            <span>Last Year</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Group: Export Action Buttons (Centered on Mobile, Right-aligned on Desktop) -->
                        {{-- <div class="export-buttons-group flex items-center justify-center sm:justify-end gap-1.5 flex-wrap w-full sm:w-auto sm:ms-auto">
                            <button id="copyBtn" type="button" title="Copy Table" class="unified-ui-border w-[38px] h-[38px] min-w-[38px] min-h-[38px] flex items-center justify-center rounded-xl bg-slate-100/80 hover:bg-slate-200/80 text-slate-700 hover:text-slate-900 shadow-sm transition-all duration-150 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-white">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                            </button>
                            <button id="csvBtn" type="button" title="Export CSV" class="unified-ui-border w-[38px] h-[38px] min-w-[38px] min-h-[38px] flex items-center justify-center rounded-xl bg-slate-100/80 hover:bg-slate-200/80 text-slate-700 hover:text-slate-900 shadow-sm transition-all duration-150 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-white">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="8" y1="13" x2="16" y2="13"></line>
                                    <line x1="8" y1="17" x2="16" y2="17"></line>
                                </svg>
                            </button>
                            <button id="pdfBtn" type="button" title="Export PDF" class="unified-ui-border w-[38px] h-[38px] min-w-[38px] min-h-[38px] flex items-center justify-center rounded-xl bg-slate-100/80 hover:bg-slate-200/80 text-slate-700 hover:text-slate-900 shadow-sm transition-all duration-150 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-white">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                </svg>
                            </button>
                            <button id="printBtn" type="button" title="Print Table" class="unified-ui-border w-[38px] h-[38px] min-w-[38px] min-h-[38px] flex items-center justify-center rounded-xl bg-slate-100/80 hover:bg-slate-200/80 text-slate-700 hover:text-slate-900 shadow-sm transition-all duration-150 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-white">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                    <rect x="6" y="14" width="12" height="8"></rect>
                                </svg>
                            </button>
                            <button id="xlsxBtn" type="button" title="Export Excel" class="unified-ui-border w-[38px] h-[38px] min-w-[38px] min-h-[38px] flex items-center justify-center rounded-xl bg-slate-100/80 hover:bg-slate-200/80 text-slate-700 hover:text-slate-900 shadow-sm transition-all duration-150 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-white">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="9" y1="13" x2="15" y2="17"></line>
                                    <line x1="15" y1="13" x2="9" y2="17"></line>
                                </svg>
                            </button>
                        </div> --}}
                    </div>

                    <!-- 3. Desktop Table (SL header, solid emerald header, single line, 10px padding) -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900 mb-4">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                    <th class="p-[10px] text-start w-[125px] whitespace-nowrap">Invoice No</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Customer Info</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Financial Summary</th>
                                    <th class="p-[10px] text-start w-[115px] whitespace-nowrap">Created By</th>
                                    <th class="p-[10px] text-start w-[115px] whitespace-nowrap">Date</th>
                                    <th class="p-[10px] text-center w-[110px] whitespace-nowrap">Status</th>
                                    <th class="p-[10px] text-center w-[150px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200"></tbody>
                        </table>
                    </div>

                    <!-- 4. Mobile Card List View (Shown on Mobile Screens < 768px) -->
                    <div id="mobileCardList" class="block md:hidden mb-3 space-y-3"></div>

                    <!-- 5. Modern Smart Pagination & Display Info Footer -->
                    <div class="flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-800 gap-3">
                        <div id="display-info"></div>
                        <div id="pagination" class="flex items-center gap-1 sm:gap-1.5 flex-nowrap justify-center max-w-full overflow-x-auto pb-1"></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- 6. Sticky Bottom Copyright Section with flex mt-auto for zoom-out safety -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)] mt-auto">
            <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>

<!-- Quick View Invoice Details Modal -->
<div id="invoiceQuickViewModal" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg my-3" style="max-height: 88vh;">
        <div class="modal-content bg-white dark:bg-slate-900 border-0 rounded-2xl shadow-2xl overflow-hidden transition-colors flex flex-col" style="max-height: 88vh; border: none !important;">
            <!-- Modal Header: Sticky top, Green background, White text, Red round close button -->
            <div class="modal-header sticky top-0 z-20 px-4 py-3 bg-emerald-700 text-white flex items-center justify-between shadow-sm border-0 flex-shrink-0" style="background-color: #15803d !important; color: #ffffff !important; border: none !important;">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/20 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </div>
                    <div>
                        <h5 class="modal-title text-base sm:text-lg font-bold text-white tracking-tight mb-0.5" id="qvInvoiceOrderNo" style="color: #ffffff !important;">Invoice Details</h5>
                        <div class="flex items-center gap-1.5 flex-wrap text-xs" id="qvInvoiceHeaderBadges"></div>
                    </div>
                </div>
                <!-- Red Circular Borderless Close Button with White Icon -->
                <button type="button" class="qv-close-btn" data-bs-dismiss="modal" aria-label="Close" style="width: 32px !important; height: 32px !important; min-width: 32px !important; min-height: 32px !important; max-width: 32px !important; max-height: 32px !important; border-radius: 50% !important; flex: 0 0 32px !important; padding: 0 !important; margin: 0 !important; background-color: #dc2626 !important; border: none !important; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Modal Body: Scrollable middle section -->
            <div class="modal-body p-4 space-y-3.5 overflow-y-auto custom-scrollbar flex-1" style="max-height: calc(88vh - 120px);">
                <!-- KPI Cards Grid: 4 columns on desktop, 2 columns on mobile -->
                <div class="qv-cards-grid grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                    <div class="qv-stat-box p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-center">
                        <span class="qv-label block text-[10px] font-semibold text-slate-400 dark:text-slate-400 uppercase tracking-wider mb-1">Payment Status</span>
                        <div id="qvInvoiceStatusBadgeWrap" class="inline-block"></div>
                    </div>
                    <div class="qv-stat-box p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-center">
                        <span class="qv-label block text-[10px] font-semibold text-slate-400 dark:text-slate-400 uppercase tracking-wider mb-1">Total Items</span>
                        <span id="qvInvoiceTotalItems" class="text-sm sm:text-base font-bold text-slate-800 dark:text-slate-100">0</span>
                    </div>
                    <div class="qv-stat-box p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-center">
                        <span class="qv-label block text-[10px] font-semibold text-slate-400 dark:text-slate-400 uppercase tracking-wider mb-1">Total Amount</span>
                        <span id="qvInvoiceTotalAmount" class="text-sm sm:text-base font-bold text-slate-700 dark:text-slate-200">৳ 0.00</span>
                    </div>
                    <div class="qv-stat-box p-2.5 rounded-xl bg-emerald-50 dark:bg-slate-800 border border-emerald-200 dark:border-slate-700 text-center">
                        <span class="qv-label block text-[10px] font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-1">Paid / Due</span>
                        <span id="qvInvoicePaidDue" class="text-sm sm:text-base font-bold text-emerald-700 dark:text-emerald-300">৳ 0.00</span>
                    </div>
                </div>

                <!-- Specification Box with Top Margin & Generous Padding -->
                <div class="qv-spec-box rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden mt-3">
                    <div class="qv-spec-header bg-slate-100 dark:bg-slate-800 px-5 sm:px-6 py-3 border-b border-slate-200 dark:border-slate-700 font-bold text-xs text-slate-700 dark:text-slate-200 uppercase tracking-wider flex items-center justify-between flex-wrap gap-2">
                        <span>Invoice Specification</span>
                        <span id="qvInvoiceTotalValue" class="text-emerald-700 dark:text-emerald-400 font-bold">Total Value: ৳ 0.00</span>
                    </div>
                    <div class="divide-y divide-slate-200 dark:divide-slate-700 text-xs">
                        <div class="qv-spec-row grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-white dark:bg-slate-800/90">
                            <span class="font-semibold text-slate-500 dark:text-slate-400">Invoice No:</span>
                            <span id="qvInvoiceNo" class="col-span-2 font-mono font-bold text-slate-800 dark:text-slate-100"></span>
                        </div>
                        <div class="qv-spec-row-alt grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-slate-50 dark:bg-slate-800/50">
                            <span class="font-semibold text-slate-500 dark:text-slate-400">Customer Name:</span>
                            <span id="qvInvoiceCustomerName" class="col-span-2 font-medium text-slate-800 dark:text-slate-200"></span>
                        </div>
                        <div class="qv-spec-row grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-white dark:bg-slate-800/90">
                            <span class="font-semibold text-slate-500 dark:text-slate-400">Mobile Number:</span>
                            <span id="qvInvoiceCustomerMobile" class="col-span-2 font-medium text-slate-800 dark:text-slate-200"></span>
                        </div>
                        <div class="qv-spec-row-alt grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-slate-50 dark:bg-slate-800/50">
                            <span class="font-semibold text-slate-500 dark:text-slate-400">Customer ID:</span>
                            <span id="qvInvoiceCustomerId" class="col-span-2 font-medium text-slate-800 dark:text-slate-200"></span>
                        </div>
                        <div class="qv-spec-row grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-white dark:bg-slate-800/90">
                            <span class="font-semibold text-slate-500 dark:text-slate-400">Created By:</span>
                            <span id="qvInvoiceCreatedBy" class="col-span-2 font-medium text-slate-800 dark:text-slate-200"></span>
                        </div>
                        <div class="qv-spec-row-alt grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-slate-50 dark:bg-slate-800/50">
                            <span class="font-semibold text-slate-500 dark:text-slate-400">Invoice Date:</span>
                            <span id="qvInvoiceDate" class="col-span-2 font-medium text-slate-800 dark:text-slate-200"></span>
                        </div>
                        <div class="qv-spec-row grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-white dark:bg-slate-800/90">
                            <span class="font-semibold text-slate-500 dark:text-slate-400">Sub Total:</span>
                            <span id="qvInvoiceSubTotal" class="col-span-2 font-medium text-slate-800 dark:text-slate-200"></span>
                        </div>
                        <div class="qv-spec-row-alt grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-slate-50 dark:bg-slate-800/50">
                            <span class="font-semibold text-slate-500 dark:text-slate-400">Discount Amount:</span>
                            <span id="qvInvoiceDiscount" class="col-span-2 font-medium text-slate-800 dark:text-slate-200"></span>
                        </div>
                        <div class="qv-spec-row grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-white dark:bg-slate-800/90">
                            <span class="font-semibold text-slate-500 dark:text-slate-400">Paid Amount:</span>
                            <span id="qvInvoicePaid" class="col-span-2 font-bold text-emerald-600 dark:text-emerald-400"></span>
                        </div>
                        <div class="qv-spec-row-alt grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-slate-50 dark:bg-slate-800/50">
                            <span class="font-semibold text-slate-500 dark:text-slate-400">Due Amount:</span>
                            <span id="qvInvoiceDue" class="col-span-2 font-bold text-rose-600 dark:text-rose-400"></span>
                        </div>
                    </div>
                </div>

                <!-- Purchased Items Breakdown Section -->
                <div id="qvInvoiceItemsSection" class="space-y-2 mt-6 pt-1" style="margin-top: 24px !important;">
                    <h6 class="font-bold text-xs uppercase tracking-wider text-slate-600 dark:text-slate-400 flex items-center gap-1.5 mb-0 px-1">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                        <span>Purchased Items & Products Breakdown</span>
                    </h6>
                    <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold border-b border-slate-200 dark:border-slate-700">
                                <tr>
                                    <th class="px-4 py-2.5 text-center w-[50px]">SL</th>
                                    <th class="px-4 py-2.5">Product Name</th>
                                    <th class="px-4 py-2.5 text-center">Qty</th>
                                    <th class="px-4 py-2.5 text-end">Price</th>
                                    <th class="px-4 py-2.5 text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody id="qvInvoiceItemsTableBody" class="divide-y divide-slate-200 dark:divide-slate-700">
                                <tr>
                                    <td colspan="5" class="text-center py-3 text-slate-400">Loading items...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal Footer: Sticky bottom, Cancel button 38px height, Red background, White text -->
            <div class="modal-footer sticky bottom-0 z-20 px-4 py-2.5 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 flex justify-end flex-shrink-0">
                <button type="button" class="px-4 h-[38px] min-h-[38px] max-h-[38px] rounded-xl bg-red-600 hover:bg-red-700 active:scale-[0.98] text-white text-xs sm:text-sm font-semibold transition-all shadow-sm flex items-center justify-center border-0" data-bs-dismiss="modal" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important;">Cancel</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Full Height & Zoom-Out Sticky Footer Fix */
    html, body {
        min-height: 100vh !important;
    }
    .main-content {
        min-height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
    }
    .page-content {
        min-height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
        flex-grow: 1 !important;
        padding-bottom: 0 !important;
    }
    .data-table {
        flex-grow: 1 !important;
    }
    .copyright {
        margin-top: auto !important;
        width: 100% !important;
    }

    /* Card-body padding standard */
    .product-card-body {
        padding: 14px !important;
    }
    @media (min-width: 640px) {
        .product-card-body {
            padding: 18px !important;
        }
    }
    @media (min-width: 768px) {
        .product-card-body {
            padding: 24px !important;
        }
    }

    /* Unified UI Border Color for Light Mode across all fields, buttons, and table */
    .unified-ui-border {
        border: 1.5px solid #cbd5e1 !important;
    }

    /* 3 Columns in Row 1 on Desktop & Tablet (>= 640px) */
    .row-controls-grid {
        display: grid !important;
        grid-template-columns: 1fr;
        gap: 10px;
    }
    @media (min-width: 640px) {
        .row-controls-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            gap: 12px !important;
        }
    }

    /* Mobile centering for Show Entries, Filter dropdown, and Export buttons */
    @media (max-width: 639px) {
        .row-actions-bar {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
        }
        .filter-controls-group {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        .export-buttons-group {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
    }
    @media (min-width: 640px) {
        .row-actions-bar {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: space-between !important;
        }
        .filter-controls-group {
            display: flex !important;
            justify-content: flex-start !important;
            width: auto !important;
            margin: 0 !important;
        }
        .export-buttons-group {
            display: flex !important;
            justify-content: flex-end !important;
            width: auto !important;
            margin-left: auto !important;
            margin-right: 0 !important;
        }
    }

    /* Generous Left-Right Padding for Search and Date Fields */
    .search-input-wrapper,
    .date-input-wrapper {
        padding-left: 14px !important;
        padding-right: 14px !important;
    }

    /* Search input wrapper focus ring */
    .search-input-wrapper:focus-within,
    .date-input-wrapper:focus-within {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.25) !important;
    }

    /* Inner input inside searchbar must never have its own focus border, outline, or shadow */
    #searchInput,
    #searchInput:focus,
    #searchInput:focus-visible,
    #searchInput:active,
    body[light-mode="dark"] #searchInput,
    body[light-mode="dark"] #searchInput:focus,
    .flatpickr-input,
    .flatpickr-input:focus {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }

    /* Table headers strictly 1 line, no wrapping */
    #printTable thead th {
        white-space: nowrap !important;
    }

    /* Table row hover in light and dark mode (never turns white in dark mode) */
    #printTable tbody tr {
        transition: background-color 0.15s ease-in-out;
    }
    #printTable tbody tr:hover {
        background-color: rgba(241, 245, 249, 0.7) !important;
    }
    body[light-mode="dark"] #printTable tbody tr:hover,
    body[data-layout-mode="dark"] #printTable tbody tr:hover,
    html.dark #printTable tbody tr:hover,
    body.dark-mode #printTable tbody tr:hover {
        background-color: rgba(30, 41, 59, 0.6) !important;
    }

    /* Custom Filter Dropdown Styling */
    .custom-filter-dropdown {
        position: relative;
        user-select: none;
    }
    .custom-filter-dropdown.is-open {
        z-index: 50 !important;
    }
    .custom-filter-dropdown .select-trigger {
        transition: all 0.2s ease;
    }
    .custom-filter-dropdown .select-trigger:hover {
        border-color: #16a34a !important;
    }
    .custom-filter-dropdown.is-open .select-trigger {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15) !important;
    }
    .custom-filter-dropdown .select-menu {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        right: 0;
        min-width: 170px;
        z-index: 9999 !important;
        background: #ffffff !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 12px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.12), 0 4px 12px rgba(0, 0, 0, 0.06) !important;
        padding: 6px;
    }
    .custom-filter-dropdown.is-open .select-menu {
        display: block !important;
    }
    .custom-filter-dropdown .select-option-item {
        background-color: #ffffff !important;
        color: #334155;
        padding: 8px 12px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer !important;
        border-radius: 6px;
        border-left: 4px solid transparent !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.15s ease-in-out;
        margin-bottom: 2px;
        text-decoration: none !important;
    }
    .custom-filter-dropdown .select-option-item:hover {
        background-color: #f0fdf4 !important;
        color: #15803d !important;
        border-left: 4px solid #16a34a !important;
    }
    .custom-filter-dropdown .select-option-item.active {
        background-color: #dcfce7 !important;
        color: #15803d !important;
        border-left: 4px solid #16a34a !important;
        font-weight: 600;
    }

    /* Customer ID Badge, Status Badge & Action Button Borders in Light Mode */
    .customer-id-badge {
        border: 1.5px solid #cbd5e1 !important;
    }
    .status-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.25rem 0.65rem;
        border-radius: 9999px;
        font-size: 0.72rem;
        font-weight: 600;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        border: 1.5px solid #cbd5e1 !important;
    }
    .action-btn {
        border: 1.5px solid #cbd5e1 !important;
        background-color: #f8fafc;
    }
    .action-btn-print { color: #15803d; }
    .action-btn-print:hover { background-color: #dcfce7; border-color: #16a34a !important; }
    .action-btn-return { color: #d97706; }
    .action-btn-return:hover { background-color: #fef3c7; border-color: #f59e0b !important; }
    .action-btn-due { color: #2563eb; }
    .action-btn-due:hover { background-color: #dbeafe; border-color: #3b82f6 !important; }
    .action-btn-edit { color: #7c3aed; }
    .action-btn-edit:hover { background-color: #ede9fe; border-color: #8b5cf6 !important; }

    /* Quick View Action Button - Distinct Sky Blue Eye Icon, Exact Same Border & Bg as Edit/Delete Buttons */
    .quick-view-btn {
        background-color: #f0f9ff !important;
        border: 1.5px solid #cbd5e1 !important;
        color: #0284c7 !important;
        transition: all 0.15s ease-in-out !important;
    }
    .quick-view-btn svg {
        stroke: #0284c7 !important;
        color: #0284c7 !important;
        transition: stroke 0.15s ease-in-out !important;
    }
    .quick-view-btn:hover {
        background-color: #e0f2fe !important;
        border-color: #0284c7 !important;
        color: #0284c7 !important;
    }
    .quick-view-btn:hover svg {
        stroke: #0284c7 !important;
        color: #0284c7 !important;
    }

    /* Quick View Modal Generous Left/Right Padding */
    #invoiceQuickViewModal .qv-spec-header {
        padding: 12px 20px !important;
    }
    #invoiceQuickViewModal .qv-spec-row,
    #invoiceQuickViewModal .qv-spec-row-alt {
        padding: 10px 20px !important;
    }
    #invoiceQuickViewModal #qvInvoiceItemsSection {
        margin-top: 24px !important;
    }
    #invoiceQuickViewModal #qvInvoiceItemsSection table th,
    #invoiceQuickViewModal #qvInvoiceItemsSection table td {
        padding-left: 16px !important;
        padding-right: 16px !important;
    }

    /* Flatpickr Theme & No-Month-Dropdown Enhancements */
    .flatpickr-calendar {
        border-radius: 14px !important;
        box-shadow: 0 16px 36px rgba(0,0,0,0.14) !important;
        border: 1.5px solid #cbd5e1 !important;
        font-family: inherit !important;
    }
    .flatpickr-calendar .flatpickr-monthDropdown-months {
        display: none !important;
    }
    .flatpickr-current-month .cur-month {
        font-weight: 700 !important;
        margin-left: 0 !important;
    }
    .flatpickr-day.selected, 
    .flatpickr-day.startRange, 
    .flatpickr-day.endRange {
        background: #15803d !important;
        border-color: #15803d !important;
        color: #fff !important;
    }
    .flatpickr-day:hover {
        background: #dcfce7 !important;
        color: #15803d !important;
    }

    /* Mobile Financial Summary Grid (2-column side-by-side with top margin) */
    .mobile-fin-grid {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 8px !important;
        margin-top: 14px !important;
        margin-bottom: 10px !important;
    }

    /* Display Info Badge in Light and Dark Mode */
    .display-info-badge {
        background-color: #f8fafc !important;
        border: 1px solid #cbd5e1 !important;
        color: #475569 !important;
    }
    .display-info-badge .stat-count {
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #0f172a !important;
    }
    .display-info-badge .stat-total {
        background-color: #ecfdf5 !important;
        border: 1px solid #a7f3d0 !important;
        color: #047857 !important;
    }

    /* Data-table background fix: completely transparent to eliminate white gaps */
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

    /* ==========================================================================
       DARK MODE SPECIFIC STYLING (Zero White Background Glitches, Unified #334155 Borders)
       ========================================================================== */
    body[light-mode="dark"] .main-content,
    body[data-layout-mode="dark"] .main-content,
    html.dark .main-content {
        background-color: #0b0f19 !important;
    }

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
    body[light-mode="dark"] #printTable tr {
        border-color: #334155 !important;
    }

    /* Unified #334155 border across customer info, status, and action buttons */
    body[light-mode="dark"] .customer-id-badge,
    body[data-layout-mode="dark"] .customer-id-badge,
    html.dark .customer-id-badge {
        border: 1.5px solid #334155 !important;
        background-color: #1e293b !important;
        color: #cbd5e1 !important;
    }

    body[light-mode="dark"] .status-pill,
    body[data-layout-mode="dark"] .status-pill,
    html.dark .status-pill {
        border: 1.5px solid #334155 !important;
    }

    body[light-mode="dark"] .action-btn,
    body[data-layout-mode="dark"] .action-btn,
    html.dark .action-btn {
        border: 1.5px solid #334155 !important;
        background-color: #1e293b !important;
    }

    /* Specific vibrant action colors in Dark Mode */
    body[light-mode="dark"] .action-btn-print,
    body[data-layout-mode="dark"] .action-btn-print,
    html.dark .action-btn-print {
        color: #34d399 !important;
        background-color: rgba(6, 78, 59, 0.3) !important;
    }
    body[light-mode="dark"] .action-btn-print:hover,
    body[data-layout-mode="dark"] .action-btn-print:hover,
    html.dark .action-btn-print:hover {
        background-color: #059669 !important;
        color: #ffffff !important;
    }

    /* Sales return icon: bright warm amber / gold, clearly visible in dark mode */
    body[light-mode="dark"] .action-btn-return,
    body[data-layout-mode="dark"] .action-btn-return,
    html.dark .action-btn-return {
        color: #fbbf24 !important;
        background-color: rgba(245, 158, 11, 0.2) !important;
    }
    body[light-mode="dark"] .action-btn-return:hover,
    body[data-layout-mode="dark"] .action-btn-return:hover,
    html.dark .action-btn-return:hover {
        background-color: #d97706 !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] .action-btn-due,
    body[data-layout-mode="dark"] .action-btn-due,
    html.dark .action-btn-due {
        color: #60a5fa !important;
        background-color: rgba(37, 99, 235, 0.2) !important;
    }
    body[light-mode="dark"] .action-btn-due:hover,
    body[data-layout-mode="dark"] .action-btn-due:hover,
    html.dark .action-btn-due:hover {
        background-color: #2563eb !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] .action-btn-edit,
    body[data-layout-mode="dark"] .action-btn-edit,
    html.dark .action-btn-edit {
        color: #c084fc !important;
        background-color: rgba(147, 51, 234, 0.2) !important;
    }
    body[light-mode="dark"] .action-btn-edit:hover,
    body[data-layout-mode="dark"] .action-btn-edit:hover,
    html.dark .action-btn-edit:hover {
        background-color: #7c3aed !important;
        color: #ffffff !important;
    }

    /* Quick View Action Button in Dark Mode */
    body[light-mode="dark"] .quick-view-btn,
    body[data-layout-mode="dark"] .quick-view-btn,
    html.dark .quick-view-btn,
    body.dark .quick-view-btn,
    body[light-mode="dark"] #printTable td .quick-view-btn,
    body[data-layout-mode="dark"] #printTable td .quick-view-btn,
    html.dark #printTable td .quick-view-btn,
    body[light-mode="dark"] .invoice-mobile-card .quick-view-btn,
    body[data-layout-mode="dark"] .invoice-mobile-card .quick-view-btn,
    html.dark .invoice-mobile-card .quick-view-btn {
        background-color: #1e293b !important;
        border: 1.5px solid #334155 !important;
        border-color: #334155 !important;
        color: #38bdf8 !important;
    }
    body[light-mode="dark"] .quick-view-btn svg,
    body[data-layout-mode="dark"] .quick-view-btn svg,
    html.dark .quick-view-btn svg,
    body.dark .quick-view-btn svg,
    body[light-mode="dark"] #printTable td .quick-view-btn svg,
    body[data-layout-mode="dark"] #printTable td .quick-view-btn svg,
    html.dark #printTable td .quick-view-btn svg,
    body[light-mode="dark"] .invoice-mobile-card .quick-view-btn svg,
    body[data-layout-mode="dark"] .invoice-mobile-card .quick-view-btn svg,
    html.dark .invoice-mobile-card .quick-view-btn svg {
        stroke: #38bdf8 !important;
        color: #38bdf8 !important;
    }
    body[light-mode="dark"] .quick-view-btn:hover,
    body[data-layout-mode="dark"] .quick-view-btn:hover,
    html.dark .quick-view-btn:hover,
    body.dark .quick-view-btn:hover,
    body[light-mode="dark"] #printTable td .quick-view-btn:hover,
    body[data-layout-mode="dark"] #printTable td .quick-view-btn:hover,
    html.dark #printTable td .quick-view-btn:hover,
    body[light-mode="dark"] .invoice-mobile-card .quick-view-btn:hover,
    body[data-layout-mode="dark"] .invoice-mobile-card .quick-view-btn:hover,
    html.dark .invoice-mobile-card .quick-view-btn:hover {
        background-color: #0c4a6e !important;
        border-color: #0284c7 !important;
        color: #38bdf8 !important;
    }
    body[light-mode="dark"] .quick-view-btn:hover svg,
    body[data-layout-mode="dark"] .quick-view-btn:hover svg,
    html.dark .quick-view-btn:hover svg,
    body.dark .quick-view-btn:hover svg {
        stroke: #38bdf8 !important;
        color: #38bdf8 !important;
    }

    /* Quick View Modal Dark Mode Fixes */
    #invoiceQuickViewModal .modal-content {
        border: none !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
    }
    body[light-mode="dark"] #invoiceQuickViewModal .modal-content,
    html.dark #invoiceQuickViewModal .modal-content,
    body.dark #invoiceQuickViewModal .modal-content {
        background-color: #0f172a !important;
        border: none !important;
        border-color: transparent !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] #invoiceQuickViewModal .qv-stat-box,
    html.dark #invoiceQuickViewModal .qv-stat-box,
    body.dark #invoiceQuickViewModal .qv-stat-box {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] #invoiceQuickViewModal .qv-stat-box *,
    html.dark #invoiceQuickViewModal .qv-stat-box *,
    body.dark #invoiceQuickViewModal .qv-stat-box * {
        color: #f8fafc !important;
    }
    body[light-mode="dark"] #invoiceQuickViewModal .qv-stat-box .qv-label,
    html.dark #invoiceQuickViewModal .qv-stat-box .qv-label,
    body.dark #invoiceQuickViewModal .qv-stat-box .qv-label {
        color: #94a3b8 !important;
    }
    body[light-mode="dark"] #invoiceQuickViewModal .qv-spec-box,
    html.dark #invoiceQuickViewModal .qv-spec-box,
    body.dark #invoiceQuickViewModal .qv-spec-box {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #invoiceQuickViewModal .qv-spec-header,
    html.dark #invoiceQuickViewModal .qv-spec-header,
    body.dark #invoiceQuickViewModal .qv-spec-header {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] #invoiceQuickViewModal .qv-spec-row,
    html.dark #invoiceQuickViewModal .qv-spec-row,
    body.dark #invoiceQuickViewModal .qv-spec-row {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] #invoiceQuickViewModal .qv-spec-row-alt,
    html.dark #invoiceQuickViewModal .qv-spec-row-alt,
    body.dark #invoiceQuickViewModal .qv-spec-row-alt {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] #invoiceQuickViewModal #qvInvoiceItemsSection table,
    html.dark #invoiceQuickViewModal #qvInvoiceItemsSection table {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #invoiceQuickViewModal #qvInvoiceItemsSection table thead,
    html.dark #invoiceQuickViewModal #qvInvoiceItemsSection table thead {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] #invoiceQuickViewModal #qvInvoiceItemsSection table thead th,
    html.dark #invoiceQuickViewModal #qvInvoiceItemsSection table thead th {
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] #invoiceQuickViewModal #qvInvoiceItemsSection table tbody tr,
    html.dark #invoiceQuickViewModal #qvInvoiceItemsSection table tbody tr {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #invoiceQuickViewModal #qvInvoiceItemsSection table tbody tr:hover,
    html.dark #invoiceQuickViewModal #qvInvoiceItemsSection table tbody tr:hover {
        background-color: rgba(30, 41, 59, 0.6) !important;
    }
    body[light-mode="dark"] #invoiceQuickViewModal .modal-footer,
    html.dark #invoiceQuickViewModal .modal-footer {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #searchInput,
    body[light-mode="dark"] .search-input-wrapper,
    body[light-mode="dark"] .date-input-wrapper,
    body[light-mode="dark"] .entries-wrapper,
    body[light-mode="dark"] .custom-filter-dropdown .select-trigger,
    body[light-mode="dark"] .custom-filter-dropdown .select-menu,
    body[light-mode="dark"] #copyBtn,
    body[light-mode="dark"] #csvBtn,
    body[light-mode="dark"] #pdfBtn,
    body[light-mode="dark"] #printBtn,
    body[light-mode="dark"] #xlsxBtn,
    body[light-mode="dark"] .invoice-mobile-card {
        border-color: #334155 !important;
    }

    body[light-mode="dark"] .custom-filter-dropdown .select-menu {
        background-color: #0f172a !important;
    }

    body[light-mode="dark"] .custom-filter-dropdown .select-option-item {
        background-color: #0f172a !important;
        color: #cbd5e1 !important;
    }

    body[light-mode="dark"] .custom-filter-dropdown .select-option-item:hover {
        background-color: #1e293b !important;
        color: #34d399 !important;
        border-left-color: #10b981 !important;
    }

    body[light-mode="dark"] .custom-filter-dropdown .select-option-item.active {
        background-color: #064e3b !important;
        color: #6ee7b7 !important;
        border-left-color: #10b981 !important;
    }

    body[light-mode="dark"] .invoice-mobile-card {
        background-color: #1e293b !important;
        color: #f8fafc !important;
    }

    body[light-mode="dark"] .mobile-fin-grid > div {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }

    /* Dark Mode Flatpickr */
    body[light-mode="dark"] .flatpickr-calendar {
        background: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .flatpickr-day {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .flatpickr-day:hover {
        background: #1e293b !important;
        color: #34d399 !important;
    }
    body[light-mode="dark"] .flatpickr-current-month,
    body[light-mode="dark"] .flatpickr-month {
        color: #fff !important;
        fill: #fff !important;
    }
    body[light-mode="dark"] .flatpickr-months .flatpickr-prev-month, 
    body[light-mode="dark"] .flatpickr-months .flatpickr-next-month {
        color: #fff !important;
        fill: #fff !important;
    }
    body[light-mode="dark"] span.flatpickr-weekday {
        color: #94a3b8 !important;
    }

    /* Dark Mode Showing Box & Pagination Fix (Strictly dark bg, no white box) */
    body[light-mode="dark"] .display-info-badge,
    body[data-layout-mode="dark"] .display-info-badge,
    html.dark .display-info-badge,
    body.dark-mode .display-info-badge {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }
    body[light-mode="dark"] .display-info-badge .stat-count,
    body[data-layout-mode="dark"] .display-info-badge .stat-count,
    html.dark .display-info-badge .stat-count,
    body.dark-mode .display-info-badge .stat-count {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .display-info-badge .stat-total,
    body[data-layout-mode="dark"] .display-info-badge .stat-total,
    html.dark .display-info-badge .stat-total,
    body.dark-mode .display-info-badge .stat-total {
        background-color: #064e3b !important;
        border-color: #047857 !important;
        color: #6ee7b7 !important;
    }

    body[light-mode="dark"] #pagination button,
    body[data-layout-mode="dark"] #pagination button {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] #pagination button:hover:not([disabled]),
    body[data-layout-mode="dark"] #pagination button:hover:not([disabled]) {
        background-color: #334155 !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] #pagination button[disabled],
    body[data-layout-mode="dark"] #pagination button[disabled] {
        background-color: #0f172a !important;
        border-color: #1e293b !important;
        color: #475569 !important;
    }
    body[light-mode="dark"] #pagination button.border-emerald-700,
    body[data-layout-mode="dark"] #pagination button.border-emerald-700 {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }
</style>

<script>
    let currentPage = 1;
    let pageSize = 15;
    let rawInvoiceData = [];
    let startPicker = null;
    let endPicker = null;

    // Helper: Dynamic Bangladeshi Currency Formatter
    function formatBdCurrency(amount) {
        let val = parseFloat(amount) || 0;
        return val.toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Sync Tailwind dark class automatically with application light-mode state
    function syncThemeClasses() {
        let isDark = document.body.getAttribute('light-mode') === 'dark' || 
                     document.body.getAttribute('data-layout-mode') === 'dark' ||
                     localStorage.getItem('lightMode') === 'dark';
        if (isDark) {
            document.documentElement.classList.add('dark');
            document.body.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
            document.body.classList.remove('dark');
        }
    }

    $(document).ready(function() {
        syncThemeClasses();
        $("#entries").val("15");
        initFlatpickr();
        fetchInvoiceReport();

        // Close custom filter dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('invoiceFilterDropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                dropdown.classList.remove('is-open');
                const chevron = dropdown.querySelector('.chevron-icon');
                if (chevron) chevron.style.transform = 'rotate(0deg)';
            }
        });
    });

    $(document).on('click', '.pos-theme-toggle-btn, .light-mode-button', function() {
        setTimeout(syncThemeClasses, 50);
    });

    function initFlatpickr() {
        startPicker = flatpickr("#startDate", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            altInputClass: "w-full bg-transparent border-0 outline-none text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200 placeholder:text-slate-400 p-0 m-0 cursor-pointer",
            allowInput: true,
            monthSelectorType: "static",
            onChange: function(selectedDates, dateStr) {
                if (endPicker) {
                    endPicker.set("minDate", dateStr);
                }
                fetchInvoiceReport();
            },
            onClose: function() {
                fetchInvoiceReport();
            }
        });

        endPicker = flatpickr("#endDate", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            altInputClass: "w-full bg-transparent border-0 outline-none text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200 placeholder:text-slate-400 p-0 m-0 cursor-pointer",
            allowInput: true,
            monthSelectorType: "static",
            onChange: function(selectedDates, dateStr) {
                if (startPicker) {
                    startPicker.set("maxDate", dateStr);
                }
                fetchInvoiceReport();
            },
            onClose: function() {
                fetchInvoiceReport();
            }
        });
    }

    function toggleCustomInvoiceFilter() {
        const dropdown = document.getElementById('invoiceFilterDropdown');
        if (!dropdown) return;
        const isOpen = dropdown.classList.contains('is-open');
        dropdown.classList.toggle('is-open', !isOpen);
        const chevron = dropdown.querySelector('.chevron-icon');
        if (chevron) {
            chevron.style.transform = !isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
        }
    }

    function selectInvoiceFilterOption(e, filterVal, labelText) {
        if (e) e.preventDefault();
        const dropdown = document.getElementById('invoiceFilterDropdown');
        if (dropdown) {
            const labelEl = document.getElementById('selectedFilterLabel');
            if (labelEl) labelEl.textContent = labelText;

            dropdown.querySelectorAll('.select-option-item').forEach(item => {
                if (item.getAttribute('data-filter') === filterVal) {
                    item.classList.add('active');
                    if (!item.querySelector('.check-icon')) {
                        item.innerHTML = `<span>${labelText}</span><i class="fa-solid fa-check small text-emerald-600 check-icon"></i>`;
                    }
                } else {
                    item.classList.remove('active');
                    const check = item.querySelector('.check-icon');
                    if (check) check.remove();
                }
            });

            dropdown.classList.remove('is-open');
            const chevron = dropdown.querySelector('.chevron-icon');
            if (chevron) chevron.style.transform = 'rotate(0deg)';
        }

        // Apply date range
        let today = new Date();
        let startDate = '';
        let endDate = today.toISOString().split('T')[0];

        if (filterVal === 'today') {
            startDate = endDate;
        } else if (filterVal === '7') {
            let d = new Date();
            d.setDate(d.getDate() - 7);
            startDate = d.toISOString().split('T')[0];
        } else if (filterVal === '30') {
            let d = new Date();
            d.setDate(d.getDate() - 30);
            startDate = d.toISOString().split('T')[0];
        } else if (filterVal === '365') {
            let d = new Date();
            d.setDate(d.getDate() - 365);
            startDate = d.toISOString().split('T')[0];
        }

        if (startPicker) {
            startPicker.setDate(startDate, false);
        } else {
            $("#startDate").val(startDate);
        }

        if (endPicker) {
            endPicker.setDate(endDate, false);
        } else {
            $("#endDate").val(endDate);
        }

        fetchInvoiceReport();
    }

    $("#searchInput").on("keyup search input", function () {
        currentPage = 1;
        renderPaginatedList();
    });

    $("#entries").on("change", function () {
        pageSize = parseInt($(this).val()) || 15;
        currentPage = 1;
        renderPaginatedList();
    });

    function viewReturn(id) {
        window.location.href = `/return/${id}`;
    }

    function viewInvoice(id) {
        window.location.href = `/invoice/${id}`;
    }

    async function fetchInvoiceReport() {
        const startDate = document.getElementById("startDate") ? document.getElementById("startDate").value : '';
        const endDate = document.getElementById("endDate") ? document.getElementById("endDate").value : '';
        await getList(startDate, endDate);
    }

    async function getList(startDate = '', endDate = '') {
        try {
            showLoader();
            let res = await axios.get("/api/invoice-order-payment-details", {
                ...HeaderToken(),
                params: {
                    start_date: startDate,
                    end_date: endDate
                }
            });
            hideLoader();

            if (Array.isArray(res.data['InvoicePaymentDetails'])) {
                rawInvoiceData = res.data['InvoicePaymentDetails'];
                // Sort by ID descending so newest invoices appear at the top (Section 7 & 8)
                rawInvoiceData.sort((a, b) => (parseInt(b.id) || 0) - (parseInt(a.id) || 0));
            } else {
                rawInvoiceData = [];
            }

            currentPage = 1;
            renderPaginatedList();

        } catch (e) {
            hideLoader();
            console.error(e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    function renderPaginatedList() {
        if (!rawInvoiceData) return;

        let searchTerm = $("#searchInput").val().toLowerCase().trim();

        // 1. Filter Invoices
        let filtered = rawInvoiceData.filter(function (item) {
            let orderNo = (item.order_no || "").toLowerCase();
            let customerName = (item.customer?.customer_name || "").toLowerCase();
            let customerMobile = (item.customer?.mobile || "").toLowerCase();
            let customerId = (item.customer?.customer_id || "").toLowerCase();
            let userName = (item.user?.name || "").toLowerCase();

            return !searchTerm || orderNo.includes(searchTerm) || customerName.includes(searchTerm) || customerMobile.includes(searchTerm) || customerId.includes(searchTerm) || userName.includes(searchTerm);
        });

        // Sort descending by id as guaranteed by Section 7 & 8 of PROJECT_RULES
        filtered.sort((a, b) => (parseInt(b.id) || 0) - (parseInt(a.id) || 0));

        // 2. Pagination Calculations
        let totalItems = filtered.length;
        let totalPages = Math.ceil(totalItems / pageSize) || 1;
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        let startIndex = (currentPage - 1) * pageSize;
        let endIndex = Math.min(startIndex + pageSize, totalItems);
        let pageItems = filtered.slice(startIndex, endIndex);

        let tableList = $("#printTable tbody");
        let mobileCardList = $("#mobileCardList");

        tableList.empty();
        mobileCardList.empty();

        if (pageItems.length === 0) {
            tableList.html('<tr><td colspan="8" class="text-center text-rose-500 dark:text-rose-400 p-8 font-semibold"><div class="flex flex-col items-center justify-center gap-2"><svg class="w-8 h-8 text-rose-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg><span>No invoices found.</span></div></td></tr>');
            mobileCardList.html('<div class="p-6 text-center text-rose-500 dark:text-rose-400 font-semibold bg-white dark:bg-slate-800/60 rounded-2xl unified-ui-border shadow-sm">❌ No invoices found.</div>');
        } else {
            pageItems.forEach(function (item, idx) {
                let realIndex = startIndex + idx;
                const subTotal = item['sub_total'] ? parseFloat(item['sub_total']) : 0;
                const discountAmount = item['discount_amount'] ? parseFloat(item['discount_amount']) : 0;
                const paidAmount = item['paid_amount'] ? parseFloat(item['paid_amount']) : 0;
                const dueAmount = item['due_amount'] ? parseFloat(item['due_amount']) : 0;

                let paymentStatus = '';
                let statusBadgeClass = '';
                if (dueAmount === 0 && paidAmount > 0) {
                    paymentStatus = 'Fully Paid';
                    statusBadgeClass = 'status-badge-paid bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400';
                } else if (dueAmount > 0 && paidAmount > 0) {
                    paymentStatus = 'Partial Paid';
                    statusBadgeClass = 'status-badge-partial bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-400';
                } else if (dueAmount > 0 && paidAmount === 0) {
                    paymentStatus = 'Unpaid';
                    statusBadgeClass = 'status-badge-unpaid bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:text-rose-400';
                } else {
                    paymentStatus = 'Return';
                    statusBadgeClass = 'status-badge-return bg-purple-100 text-purple-700 dark:bg-purple-950/40 dark:text-purple-400';
                }

                let formattedDate = item['invoice_date'] ? new Intl.DateTimeFormat('en-US', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(item['invoice_date'])) : 'N/A';

                // Desktop Row (matches product-list row styling, sleek hover, unified borders)
                let row = `
                    <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors border-b border-slate-100 dark:border-slate-800">
                        <td class="p-[10px] text-center font-bold text-slate-500 dark:text-slate-400">${realIndex + 1}</td>
                        <td class="p-[10px] font-bold text-slate-800 dark:text-slate-100">${item['order_no'] || '-'}</td>
                        <td class="p-[10px]">
                            ${item['customer']?.id ? `
                                <a href="/customer/profile/${item['customer'].id}" class="text-emerald-700 dark:text-emerald-400 font-bold hover:underline" title="View Customer Profile">
                                    <div>${item['customer']?.customer_name ?? 'Walk-in Customer'}</div>
                                </a>
                            ` : `
                                <div class="font-bold text-slate-800 dark:text-slate-100">${item['customer']?.customer_name ?? 'Walk-in Customer'}</div>
                            `}
                            <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1 mt-0.5"><i class="fa-solid fa-phone text-[10px]"></i><span>${item['customer']?.mobile ?? '-'}</span></div>
                            ${item['customer']?.customer_id ? `
                                <a href="/customer/profile/${item['customer'].id}" class="inline-block mt-1">
                                    <span class="customer-id-badge inline-flex items-center gap-1 px-1.5 py-0.5 rounded font-bold text-[10px]">
                                        ID: ${item['customer'].customer_id} <i class="fa-solid fa-arrow-up-right-from-square text-[8px]"></i>
                                    </span>
                                </a>
                            ` : ''}
                        </td>
                        <td class="p-[10px] text-xs">
                            <div class="text-slate-700 dark:text-slate-200">Total: <span class="font-bold text-slate-900 dark:text-white">৳ ${formatBdCurrency(subTotal)}</span></div>
                            <div class="text-slate-500 dark:text-slate-400">Discount: ৳ ${formatBdCurrency(discountAmount)}</div>
                            <div class="text-emerald-600 dark:text-emerald-400 font-medium">Paid: <span class="font-bold">৳ ${formatBdCurrency(paidAmount)}</span></div>
                            ${dueAmount > 0 ? `<div class="text-rose-600 dark:text-rose-400 font-bold">Due: ৳ ${formatBdCurrency(dueAmount)}</div>` : ''}
                        </td>
                        <td class="p-[10px] text-xs font-semibold text-slate-600 dark:text-slate-300 whitespace-nowrap"><i class="fa-solid fa-user me-1 text-slate-400"></i>${item['user']?.name ?? 'System'}</td>
                        <td class="p-[10px] text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap"><i class="fa-regular fa-calendar me-1 text-slate-400"></i>${formattedDate}</td>
                        <td class="p-[10px] text-center">
                            <span class="status-pill ${statusBadgeClass}">
                                ${paymentStatus}
                            </span>
                        </td>
                        <td class="p-[10px] text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <button type="button" class="action-btn quick-view-btn w-[32px] h-[32px] rounded-lg flex items-center justify-center transition-all shadow-sm" onclick="openInvoiceQuickView('${item.id}')" title="Quick View Invoice">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                                <button class="action-btn action-btn-print w-[32px] h-[32px] rounded-lg flex items-center justify-center transition-all shadow-sm" onclick="viewInvoice(${item.id})" title="Print Invoice">
                                    <i class="fa-solid fa-print text-xs"></i>
                                </button>
                                <button class="action-btn action-btn-return w-[32px] h-[32px] rounded-lg flex items-center justify-center transition-all shadow-sm" onclick="viewReturn(${item.id})" title="Sales Return">
                                    <i class="fa-solid fa-rotate-left text-xs"></i>
                                </button>
                                <a data-id="${item['id']}" href="#" class="action-btn action-btn-due edit-link w-[32px] h-[32px] rounded-lg flex items-center justify-center transition-all shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Due Collection / Payment">
                                    <i class="fa-solid fa-hand-holding-dollar text-xs"></i>
                                </a>
                                <a data-id="${item['id']}" href="#" class="action-btn action-btn-edit edit-link w-[32px] h-[32px] rounded-lg flex items-center justify-center transition-all shadow-sm" data-bs-toggle="modal" data-bs-target="#invoiceFullEditModal" title="Edit Invoice">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>`;
                tableList.append(row);

                // Mobile Card View (2x2 side-by-side financial box with margin top)
                let mobileCard = `
                    <div class="invoice-mobile-card unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800/60 shadow-sm mb-3">
                        <div class="flex items-center justify-between pb-2 mb-2.5 border-b border-slate-100 dark:border-slate-700">
                            <div class="flex items-center gap-1.5">
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs">#${realIndex + 1}</span>
                                <span class="font-bold text-slate-800 dark:text-slate-100 text-xs flex items-center gap-1">
                                    <i class="fa-solid fa-file-invoice text-emerald-600"></i>${item['order_no'] || '-'}
                                </span>
                            </div>
                            <div>
                                <span class="status-pill ${statusBadgeClass}">
                                    ${paymentStatus}
                                </span>
                            </div>
                        </div>

                        <div>
                            ${item['customer']?.id ? `
                                <a href="/customer/profile/${item['customer'].id}" class="text-emerald-700 dark:text-emerald-400 font-bold text-sm hover:underline block mb-0.5" title="View Customer Profile">
                                    <i class="fa-solid fa-user-circle text-emerald-600 me-1"></i>${item['customer']?.customer_name ?? 'Walk-in Customer'}
                                </a>
                            ` : `
                                <div class="font-bold text-slate-800 dark:text-slate-100 text-sm mb-0.5">
                                    <i class="fa-solid fa-user-circle text-emerald-600 me-1"></i>${item['customer']?.customer_name ?? 'Walk-in Customer'}
                                </div>
                            `}
                            <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-xs">
                                <span><i class="fa-solid fa-phone me-1"></i>${item['customer']?.mobile ?? '-'}</span>
                                ${item['customer']?.customer_id ? `
                                    <a href="/customer/profile/${item['customer'].id}">
                                        <span class="customer-id-badge px-1.5 py-0.5 rounded font-bold text-[10px]">ID: ${item['customer'].customer_id}</span>
                                    </a>
                                ` : ''}
                            </div>
                        </div>

                        <!-- 2x2 Grid Side-by-Side (Left-Right) with margin-top -->
                        <div class="mobile-fin-grid">
                            <div class="flex items-center justify-between px-2.5 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-900/70 border border-slate-200 dark:border-slate-700">
                                <span class="text-slate-500 dark:text-slate-400 text-xs font-semibold">Total:</span>
                                <span class="font-bold text-slate-800 dark:text-slate-100 text-xs">৳ ${formatBdCurrency(subTotal)}</span>
                            </div>
                            <div class="flex items-center justify-between px-2.5 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-900/70 border border-slate-200 dark:border-slate-700">
                                <span class="text-slate-500 dark:text-slate-400 text-xs font-semibold">Discount:</span>
                                <span class="font-bold text-slate-600 dark:text-slate-300 text-xs">৳ ${formatBdCurrency(discountAmount)}</span>
                            </div>
                            <div class="flex items-center justify-between px-2.5 py-1.5 rounded-xl bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-slate-700">
                                <span class="text-emerald-600 dark:text-emerald-400 text-xs font-semibold">Paid:</span>
                                <span class="font-bold text-emerald-600 dark:text-emerald-400 text-xs">৳ ${formatBdCurrency(paidAmount)}</span>
                            </div>
                            <div class="flex items-center justify-between px-2.5 py-1.5 rounded-xl ${dueAmount > 0 ? 'bg-rose-50/50 dark:bg-rose-950/20 border border-rose-200 dark:border-slate-700' : 'bg-slate-50 dark:bg-slate-900/70 border border-slate-200 dark:border-slate-700'}">
                                <span class="${dueAmount > 0 ? 'text-rose-600 dark:text-rose-400 font-bold' : 'text-slate-500 dark:text-slate-400'} text-xs font-semibold">Due:</span>
                                <span class="font-bold ${dueAmount > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-500 dark:text-slate-400'} text-xs">৳ ${formatBdCurrency(dueAmount)}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2.5 mt-1 border-t border-slate-100 dark:border-slate-700">
                            <div class="text-slate-500 dark:text-slate-400 text-xs">
                                <i class="fa-regular fa-calendar me-1"></i>${formattedDate} <span class="ms-1">(${item['user']?.name ?? 'System'})</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button type="button" class="action-btn quick-view-btn w-[30px] h-[30px] rounded-lg flex items-center justify-center shadow-sm" onclick="openInvoiceQuickView('${item.id}')" title="Quick View Invoice">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                                <button class="action-btn action-btn-print w-[30px] h-[30px] rounded-lg flex items-center justify-center shadow-sm" onclick="viewInvoice(${item.id})" title="Print Invoice">
                                    <i class="fa-solid fa-print text-xs"></i>
                                </button>
                                <button class="action-btn action-btn-return w-[30px] h-[30px] rounded-lg flex items-center justify-center shadow-sm" onclick="viewReturn(${item.id})" title="Return Product">
                                    <i class="fa-solid fa-rotate-left text-xs"></i>
                                </button>
                                <a data-id="${item['id']}" href="#" class="action-btn action-btn-due edit-link w-[30px] h-[30px] rounded-lg flex items-center justify-center shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Due Collection / Payment">
                                    <i class="fa-solid fa-hand-holding-dollar text-xs"></i>
                                </a>
                                <a data-id="${item['id']}" href="#" class="action-btn action-btn-edit edit-link w-[30px] h-[30px] rounded-lg flex items-center justify-center shadow-sm" data-bs-toggle="modal" data-bs-target="#invoiceFullEditModal" title="Edit Invoice">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>`;
                mobileCardList.append(mobileCard);
            });
        }

        // 3. Update Display Info & Pagination UI (Fixed dark mode bg)
        let fromCount = totalItems > 0 ? startIndex + 1 : 0;
        let toCount = endIndex;
        $("#display-info").html(`
            <div class="display-info-badge px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 flex-wrap shadow-sm">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Showing</span>
                <span class="stat-count px-2 py-0.5 rounded-md font-bold">${fromCount} – ${toCount}</span>
                <span>of</span>
                <span class="stat-total px-2 py-0.5 rounded-md font-bold">${totalItems}</span>
                <span>invoices</span>
            </div>
        `);

        renderPaginationControls(totalPages);
    }

    function renderPaginationControls(totalPages) {
        let pagContainer = $("#pagination");
        pagContainer.empty();

        let pages = Math.max(1, totalPages || 1);

        // Prev Button
        let prevDisabled = currentPage <= 1;
        let prevBtn = `
            <button type="button" class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition-all ${
                prevDisabled
                    ? 'border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50 text-slate-300 dark:text-slate-600 cursor-not-allowed'
                    : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 active:scale-95 shadow-sm'
            }" ${prevDisabled ? 'disabled' : ''} onclick="goToPage(${currentPage - 1})">
                &lsaquo; Prev
            </button>
        `;
        pagContainer.append(prevBtn);

        // Smart Page Numbers
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(pages, currentPage + 2);

        if (startPage > 1) {
            pagContainer.append(`
                <button type="button" class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 shadow-sm transition-all" onclick="goToPage(1)">1</button>
            `);
            if (startPage > 2) {
                pagContainer.append(`<span class="px-1 text-slate-400 font-bold text-xs">...</span>`);
            }
        }

        for (let p = startPage; p <= endPage; p++) {
            let isActive = p === currentPage;
            let pageBtn = `
                <button type="button" class="px-3 py-1.5 text-xs font-bold rounded-lg border transition-all ${
                    isActive
                        ? 'border-emerald-700 bg-emerald-700 text-white shadow-sm'
                        : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 shadow-sm'
                }" onclick="goToPage(${p})">${p}</button>
            `;
            pagContainer.append(pageBtn);
        }

        if (endPage < pages) {
            if (endPage < pages - 1) {
                pagContainer.append(`<span class="px-1 text-slate-400 font-bold text-xs">...</span>`);
            }
            pagContainer.append(`
                <button type="button" class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 shadow-sm transition-all" onclick="goToPage(${pages})">${pages}</button>
            `);
        }

        // Next Button
        let nextDisabled = currentPage >= pages;
        let nextBtn = `
            <button type="button" class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition-all ${
                nextDisabled
                    ? 'border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50 text-slate-300 dark:text-slate-600 cursor-not-allowed'
                    : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 active:scale-95 shadow-sm'
            }" ${nextDisabled ? 'disabled' : ''} onclick="goToPage(${currentPage + 1})">
                Next &rsaquo;
            </button>
        `;
        pagContainer.append(nextBtn);
    }

    function goToPage(page) {
        currentPage = page;
        renderPaginatedList();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    async function openInvoiceQuickView(invoiceId) {
        if (!rawInvoiceData || rawInvoiceData.length === 0) return;
        let invoice = rawInvoiceData.find(i => String(i.id) === String(invoiceId));
        if (!invoice) return;

        const paidAmount = parseFloat(invoice.paid_amount || 0);
        const dueAmount = parseFloat(invoice.due_amount || 0);
        const subTotal = parseFloat(invoice.sub_total || 0);
        const discountAmount = parseFloat(invoice.discount_amount || 0);

        let statusBadgeHtml = '';
        if (dueAmount <= 0) {
            statusBadgeHtml = '<span class="badge available">Paid</span>';
        } else if (paidAmount > 0) {
            statusBadgeHtml = '<span class="badge" style="background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;">Partial Paid</span>';
        } else {
            statusBadgeHtml = '<span class="badge out-of-stock">Unpaid</span>';
        }
        $("#qvInvoiceStatusBadgeWrap").html(statusBadgeHtml);

        $("#qvInvoiceOrderNo").html(`Invoice #${invoice.order_no || '-'}`);
        let custName = invoice.customer ? (invoice.customer.customer_name || 'Walk-in Customer') : 'Walk-in Customer';
        let dateFormatted = invoice.invoice_date ? new Intl.DateTimeFormat('en-US', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(invoice.invoice_date)) : (invoice.created_at ? new Intl.DateTimeFormat('en-US', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(invoice.created_at)) : 'N/A');

        let badges = `<span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/20 text-white border border-white/30">${custName}</span>`;
        badges += `<span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/20 text-white border border-white/30"><i class="fa-regular fa-calendar me-1"></i>${dateFormatted}</span>`;
        $("#qvInvoiceHeaderBadges").html(badges);

        $("#qvInvoiceTotalItems").text('...');
        $("#qvInvoiceTotalAmount").text(`৳ ${formatBdCurrency(subTotal)}`);
        $("#qvInvoicePaidDue").text(`৳ ${formatBdCurrency(paidAmount)} / ৳ ${formatBdCurrency(dueAmount)}`);

        $("#qvInvoiceTotalValue").text(`Total Value: ৳ ${formatBdCurrency(subTotal)}`);
        $("#qvInvoiceNo").text(`#${invoice.order_no || '-'}`);
        $("#qvInvoiceCustomerName").text(custName);
        $("#qvInvoiceCustomerMobile").text(invoice.customer?.mobile || 'N/A');
        $("#qvInvoiceCustomerId").text(invoice.customer?.customer_id ? `ID: ${invoice.customer.customer_id}` : 'N/A');
        $("#qvInvoiceCreatedBy").text(invoice.user?.name || 'System');
        $("#qvInvoiceDate").text(dateFormatted);
        $("#qvInvoiceSubTotal").text(`৳ ${formatBdCurrency(subTotal)}`);
        $("#qvInvoiceDiscount").text(`৳ ${formatBdCurrency(discountAmount)}`);
        $("#qvInvoicePaid").text(`৳ ${formatBdCurrency(paidAmount)}`);
        $("#qvInvoiceDue").text(`৳ ${formatBdCurrency(dueAmount)}`);

        let modalEl = document.getElementById('invoiceQuickViewModal');
        if (window.bootstrap && window.bootstrap.Modal) {
            let modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modalInstance.show();
        } else if (typeof $(modalEl).modal === 'function') {
            $(modalEl).modal('show');
        }

        $("#qvInvoiceItemsTableBody").html('<tr><td colspan="5" class="text-center py-4 text-slate-400 dark:text-slate-500"><i class="fa-solid fa-spinner fa-spin me-2 text-emerald-600"></i>Loading purchased items...</td></tr>');
        try {
            let res = await axios.post("/api/invoice-payment-details-by-id", { id: String(invoiceId) }, HeaderToken());
            if (res.data && res.data.status === "success" && res.data.rows) {
                let order = res.data.rows;
                let details = order.details || [];
                let totalQty = details.reduce((acc, d) => acc + (parseInt(d.quantity) || 0), 0);
                $("#qvInvoiceTotalItems").text(totalQty);

                if (details.length > 0) {
                    let itemsHtml = details.map((d, index) => {
                        let pName = d.product?.product_name || `Product #${d.product_id || '-'}`;
                        let qty = parseInt(d.quantity) || 0;
                        let price = parseFloat(d.price) || 0;
                        let total = parseFloat(d.total) || (qty * price);
                        return `
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-4 py-2.5 text-center font-bold text-slate-500 dark:text-slate-400">${index + 1}</td>
                                <td class="px-4 py-2.5 font-semibold text-slate-800 dark:text-slate-200">${pName}</td>
                                <td class="px-4 py-2.5 text-center font-bold text-slate-800 dark:text-slate-100">${qty}</td>
                                <td class="px-4 py-2.5 text-end text-slate-600 dark:text-slate-300">৳ ${formatBdCurrency(price)}</td>
                                <td class="px-4 py-2.5 text-end font-semibold text-emerald-600 dark:text-emerald-400">৳ ${formatBdCurrency(total)}</td>
                            </tr>
                        `;
                    }).join('');
                    $("#qvInvoiceItemsTableBody").html(itemsHtml);
                } else {
                    $("#qvInvoiceItemsTableBody").html('<tr><td colspan="5" class="text-center py-4 text-slate-400 dark:text-slate-500">No purchased items recorded for this invoice.</td></tr>');
                }
            } else {
                $("#qvInvoiceItemsTableBody").html('<tr><td colspan="5" class="text-center py-4 text-slate-400 dark:text-slate-500">No items available.</td></tr>');
            }
        } catch (err) {
            console.error("Error fetching invoice items:", err);
            $("#qvInvoiceItemsTableBody").html('<tr><td colspan="5" class="text-center py-4 text-rose-500">Failed to load invoice items.</td></tr>');
        }
    }

</script>

