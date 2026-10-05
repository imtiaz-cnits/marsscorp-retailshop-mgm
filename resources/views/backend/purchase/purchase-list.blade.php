<!-- Flatpickr Styles & Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Hero Main Content Start -->
<div class="main-content min-h-screen flex flex-col justify-between">
    <div class="page-content purchase-page-content flex-grow flex flex-col justify-between">
        <div class="data-table flex-grow">
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-8">

                    <!-- 1. Top Section: Page Title & Top Action Buttons -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Purchase List</h1>
                        </div>

                        <!-- Right Controls: + Create Purchase Button -->
                        <div class="flex items-center flex-wrap gap-2">
                            <button id="openModalBtns" type="button" class="btn-create-purchase inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] rounded-xl shadow-sm transition-all duration-150 font-semibold text-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Create Purchase</span>
                            </button>
                        </div>
                    </div>

                    <!-- Controls & Filter Row: 5 Columns on Desktop (1 Row), 2 Items Per Row on Mobile -->
                    <div class="controls-five-cols-bar mb-3 w-full">
                        <!-- 1st: Search Bar (col-search) -->
                        <div class="col-search search-input-wrapper unified-ui-border h-[38px] flex items-center px-4 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding: 0 8px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search Purchase..." />
                        </div>

                        <!-- 2nd: Start Date with Flatpickr (col-start-date) -->
                        <div class="col-start-date date-input-wrapper unified-ui-border h-[38px] flex items-center px-3 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm focus-within:border-emerald-600 transition-all cursor-pointer flex-shrink-0">
                            <input type="text" id="startDate" name="startDate" placeholder="Start Date" style="padding: 0 6px !important;" class="w-full bg-transparent border-0 outline-none text-xs font-medium text-slate-700 dark:text-slate-200 placeholder:text-xs placeholder:font-normal placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 cursor-pointer" />
                            <svg class="w-3.5 h-3.5 text-slate-400 pointer-events-none ms-1 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>

                        <!-- 3rd: End Date with Flatpickr (col-end-date) -->
                        <div class="col-end-date date-input-wrapper unified-ui-border h-[38px] flex items-center px-3 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm focus-within:border-emerald-600 transition-all cursor-pointer flex-shrink-0">
                            <input type="text" id="endDate" name="endDate" placeholder="End Date" style="padding: 0 6px !important;" class="w-full bg-transparent border-0 outline-none text-xs font-medium text-slate-700 dark:text-slate-200 placeholder:text-xs placeholder:font-normal placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 cursor-pointer" />
                            <svg class="w-3.5 h-3.5 text-slate-400 pointer-events-none ms-1 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>

                        <!-- 4th: Entries Selector (col-entries) -->
                        <div class="col-entries entries-wrapper unified-ui-border flex items-center justify-between gap-1 bg-white dark:bg-slate-800/90 h-[38px] px-3 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 shadow-sm transition-all hover:border-emerald-500 flex-shrink-0">
                            <span class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider whitespace-nowrap">SHOW:</span>
                            <select id="entries" class="bg-transparent border-0 text-xs sm:text-sm font-bold text-emerald-700 dark:text-emerald-400 focus:outline-none cursor-pointer py-1 pr-1 text-end" style="cursor: pointer;">
                                <option value="15" selected class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">15</option>
                                <option value="50" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">50</option>
                                <option value="100" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">100</option>
                                <option value="200" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">200</option>
                                <option value="500" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">500</option>
                            </select>
                        </div>

                        <!-- 5th: Custom Quick Filter Dropdown (col-filter) -->
                        <div class="col-filter custom-searchable-select custom-filter-dropdown flex-shrink-0" id="purchaseFilterDropdown">
                            <div class="select-trigger unified-ui-border flex items-center justify-between px-3 h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-sm text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-200 cursor-pointer hover:border-emerald-500 transition-all duration-150" onclick="toggleCustomPurchaseFilter()">
                                <div class="flex items-center gap-1.5 overflow-hidden">
                                    <svg class="w-3.5 h-3.5 text-slate-500 dark:text-slate-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                                    </svg>
                                    <span id="selectedPurchaseFilterLabel" class="selected-text truncate font-semibold">Filter</span>
                                </div>
                                <svg class="w-3.5 h-3.5 text-slate-400 chevron-icon transition-transform duration-200 flex-shrink-0 ms-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </div>
                            <div class="select-menu dropdown-menus shadow-xl" style="min-width: 170px;">
                                <div class="select-options-list">
                                    <a href="#" data-filter="all" class="select-option-item active" onclick="selectPurchaseFilterOption(event, 'all', 'All time')">
                                        <span>All time</span>
                                        <i class="fa-solid fa-check small text-emerald-600 check-icon"></i>
                                    </a>
                                    <a href="#" data-filter="today" class="select-option-item" onclick="selectPurchaseFilterOption(event, 'today', 'Today')">
                                        <span>Today</span>
                                    </a>
                                    <a href="#" data-filter="7" class="select-option-item" onclick="selectPurchaseFilterOption(event, '7', 'Last 7 Days')">
                                        <span>Last 7 Days</span>
                                    </a>
                                    <a href="#" data-filter="30" class="select-option-item" onclick="selectPurchaseFilterOption(event, '30', 'Last Month')">
                                        <span>Last Month</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Desktop Table (SL rounded-tl-2xl, Action on far right with rounded-tr-2xl, solid emerald header, 2-line header, 3-dot dropdown) -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900 mb-4" style="min-height: 250px;">
                        <table id="printTable" class="w-full text-left border-collapse min-w-full table-auto">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="py-2 px-[5px] text-center w-[34px] rounded-tl-2xl bg-[#15803d] text-white" style="font-size: 11px !important; padding-left: 5px !important; padding-right: 5px !important;">SL</th>
                                    <th class="py-2 px-[5px] text-center w-[46px] bg-[#15803d] text-white leading-tight whitespace-nowrap" style="font-size: 11px !important; padding-left: 5px !important; padding-right: 5px !important;">Img</th>
                                    <th class="py-2 px-[5px] text-center bg-[#15803d] text-white leading-tight whitespace-nowrap" style="font-size: 11px !important; padding-left: 5px !important; padding-right: 5px !important;">Date</th>
                                    <th class="py-2 px-[5px] text-center bg-[#15803d] text-white leading-tight whitespace-nowrap" style="font-size: 11px !important; padding-left: 5px !important; padding-right: 5px !important;">Purchase<br>ID</th>
                                    <th class="py-2 px-[5px] text-start bg-[#15803d] text-white leading-tight whitespace-nowrap" style="font-size: 11px !important; padding-left: 5px !important; padding-right: 5px !important;">Reference<br>No</th>
                                    <th class="py-2 px-[5px] text-start bg-[#15803d] text-white leading-tight whitespace-nowrap" style="font-size: 11px !important; padding-left: 5px !important; padding-right: 5px !important;">Supplier<br>ID</th>
                                    <th class="py-2 px-[5px] text-start bg-[#15803d] text-white leading-tight" style="font-size: 11px !important; padding-left: 5px !important; padding-right: 5px !important;">Supplier<br>Name</th>
                                    <th class="py-2 px-[5px] text-end bg-[#15803d] text-white leading-tight whitespace-nowrap" style="font-size: 11px !important; padding-left: 5px !important; padding-right: 5px !important;">Grand<br>Total</th>
                                    <th class="py-2 px-[5px] text-end bg-[#15803d] text-white leading-tight whitespace-nowrap" style="font-size: 11px !important; padding-left: 5px !important; padding-right: 5px !important;">Paid<br>Amount</th>
                                    <th class="py-2 px-[5px] text-end bg-[#15803d] text-white leading-tight whitespace-nowrap" style="font-size: 11px !important; padding-left: 5px !important; padding-right: 5px !important;">Due<br>Amount</th>
                                    <th class="py-2 px-[5px] text-end bg-[#15803d] text-white leading-tight whitespace-nowrap" style="font-size: 11px !important; padding-left: 5px !important; padding-right: 5px !important;">Return<br>Amount</th>
                                    <th class="py-2 px-[5px] text-center bg-[#15803d] text-white leading-tight whitespace-nowrap" style="font-size: 11px !important; padding-left: 5px !important; padding-right: 5px !important;">Payment<br>Method</th>
                                    <th class="py-2 px-[5px] text-center bg-[#15803d] text-white leading-tight whitespace-nowrap" style="font-size: 11px !important; padding-left: 5px !important; padding-right: 5px !important;">Status</th>
                                    <th class="py-2 px-[5px] text-center w-[40px] rounded-tr-2xl bg-[#15803d] text-white" style="font-size: 11px !important; padding-left: 5px !important; padding-right: 5px !important;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableList" class="divide-y divide-slate-100 dark:divide-slate-800 text-[11px] lg:text-xs text-slate-700 dark:text-slate-200"></tbody>
                            <tfoot>
                                <tr class="bg-slate-50/80 dark:bg-slate-800/80 font-bold text-xs border-t border-slate-200 dark:border-slate-800">
                                    <td colspan="7" class="py-2 px-[5px] text-end font-bold text-slate-700 dark:text-slate-200">Total:</td>
                                    <td id="totalGrandTotal" class="py-2 px-[5px] text-end font-bold text-slate-800 dark:text-white text-xs sm:text-[12.5px] whitespace-nowrap font-mono">৳ 0.00</td>
                                    <td id="totalPaidAmount" class="py-2 px-[5px] text-end font-bold text-emerald-600 dark:text-emerald-400 text-xs sm:text-[12.5px] whitespace-nowrap font-mono">৳ 0.00</td>
                                    <td id="totalDueAmount" class="py-2 px-[5px] text-end font-bold text-rose-600 dark:text-rose-400 text-xs sm:text-[12.5px] whitespace-nowrap font-mono">৳ 0.00</td>
                                    <td id="totalReturnAmount" class="py-2 px-[5px] text-end font-bold text-rose-600 dark:text-rose-400 text-xs sm:text-[12.5px] whitespace-nowrap font-mono">৳ 0.00</td>
                                    <td colspan="3" class="py-2 px-[5px]"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- 4. Mobile Card List View (Shown on Mobile Screens < 768px) -->
                    <div id="mobileCardList" class="block md:hidden mb-3 space-y-3"></div>

                    <!-- 5. Modern Smart Pagination and Display Info Footer -->
                    <div class="flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-800 gap-3">
                        <div id="display-info"></div>
                        <div id="pagination" class="flex items-center gap-1 sm:gap-1.5 flex-nowrap justify-center max-w-full overflow-x-auto pb-1"></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- 6. Sticky Bottom Copyright Section -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)] mt-auto">
            <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>
    </div>
</div>
<!-- Hero Main Content End -->

<!-- Full-Screen Image Preview Modal (Overlay, Max 80vh, No Scroll, Centered) -->
<div id="imagePreviewModal" class="image-preview-overlay" onclick="if(event.target === this) closeImagePopup()" style="display: none; position: fixed; inset: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.85); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); z-index: 99999999; align-items: center; justify-content: center; padding: 20px; overflow: hidden; margin: 0; box-sizing: border-box;">
    <!-- Centered Card Container (Max 80vh, Zero Scroll) -->
    <div class="relative flex flex-col items-center justify-center select-none" style="max-height: 80vh; max-width: 88vw; margin: auto;" onclick="event.stopPropagation()">
        <!-- Floating Close Button on Top Right Corner -->
        <button type="button" onclick="closeImagePopup()" class="absolute -top-3.5 -right-3.5 z-50 w-9 h-9 rounded-full bg-rose-600 hover:bg-rose-700 text-white flex items-center justify-center shadow-2xl transition-transform hover:scale-110 cursor-pointer border-2 border-white focus:outline-none" title="Close Preview">
            <i class="fa-solid fa-xmark text-sm font-bold"></i>
        </button>
        <!-- Image Box strictly constrained within 80vh -->
        <div class="rounded-2xl overflow-hidden shadow-2xl bg-slate-900 border border-white/20 flex items-center justify-center p-1" style="max-height: 80vh; max-width: 88vw; box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7);">
            <img id="imagePreviewSrc" src="" alt="Preview" class="block w-auto h-auto rounded-xl object-contain" style="max-height: calc(80vh - 12px); max-width: calc(88vw - 12px); object-fit: contain; display: block;" />
        </div>
    </div>
</div>

<style>
    /* 5-Column Controls Row: 1 Row on Desktop, 2 Items Per Row on Mobile */
    .controls-five-cols-bar {
        display: grid !important;
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 8px !important;
        width: 100% !important;
        align-items: center !important;
    }
    .controls-five-cols-bar .col-search {
        grid-column: span 2 !important;
        width: 100% !important;
    }
    .controls-five-cols-bar .col-start-date,
    .controls-five-cols-bar .col-end-date,
    .controls-five-cols-bar .col-entries,
    .controls-five-cols-bar .col-filter {
        grid-column: span 1 !important;
        width: 100% !important;
    }
    .controls-five-cols-bar .col-entries {
        display: flex !important;
        justify-content: space-between !important;
    }
    .controls-five-cols-bar .col-filter .select-trigger {
        width: 100% !important;
    }

    @media (min-width: 768px) {
        .controls-five-cols-bar {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            align-items: center !important;
            gap: 8px !important;
        }
        .controls-five-cols-bar .col-search {
            flex: 1 1 0% !important;
            min-width: 140px !important;
            width: auto !important;
        }
        .controls-five-cols-bar .col-start-date {
            flex: 0 0 135px !important;
            width: 135px !important;
        }
        .controls-five-cols-bar .col-end-date {
            flex: 0 0 135px !important;
            width: 135px !important;
        }
        .controls-five-cols-bar .col-entries {
            flex: 0 0 auto !important;
            width: auto !important;
        }
        .controls-five-cols-bar .col-filter {
            flex: 0 0 130px !important;
            width: 130px !important;
        }
    }

    /* Flatpickr z-index on top of modals */
    .flatpickr-calendar {
        z-index: 999999 !important;
    }

    /* Date field placeholder text size and weight matching other inputs */
    #startDate, #endDate {
        font-size: 12px !important;
        font-weight: 500 !important;
    }
    #startDate::placeholder, #endDate::placeholder {
        font-size: 12px !important;
        font-weight: 400 !important;
        color: #94a3b8 !important;
    }

    /* Full Height & Sticky Layout with Equal Gap from Top Bar */
    html, body {
        min-height: 100vh !important;
    }
    .main-content {
        min-height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
    }
    .purchase-page-content {
        min-height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
        flex-grow: 1 !important;
        /* Equal gap top, left, right, bottom */
        padding: calc(70px + 16px) 16px 16px 16px !important;
        box-sizing: border-box !important;
    }
    @media (min-width: 768px) {
        .purchase-page-content {
            padding: calc(70px + 20px) 20px 20px 20px !important;
        }
    }

    /* Table headers & cells 5px left-right padding */
    #printTable thead th,
    .table-responsive table thead th,
    .data-table .table-responsive table thead th {
        font-size: 11px !important;
        font-weight: 600 !important;
        line-height: 1.25 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.025em !important;
        padding-left: 5px !important;
        padding-right: 5px !important;
    }

    #printTable tbody td,
    .table-responsive table tbody td,
    .data-table .table-responsive table tbody td {
        padding-left: 5px !important;
        padding-right: 5px !important;
    }

    /* Action Dropdown Menu High Z-Index & Dropup placement */
    .table-responsive .dropdown-menu {
        z-index: 99999 !important;
    }
    .dropup .dropdown-menu {
        top: auto !important;
        bottom: 100% !important;
        margin-bottom: 4px !important;
    }

    /* Create Purchase Button Styling with Solid Hover */
    .btn-create-purchase,
    #openModalBtns {
        background-color: #15803d !important;
        color: #ffffff !important;
        border: none !important;
    }
    .btn-create-purchase:hover,
    #openModalBtns:hover {
        background-color: #166534 !important;
        color: #ffffff !important;
        transform: translateY(-1px);
    }
    .btn-create-purchase:active,
    #openModalBtns:active {
        transform: scale(0.98);
    }
    .btn-create-purchase *,
    #openModalBtns * {
        color: #ffffff !important;
    }

    /* Action Buttons with High-Contrast Hover Styles */
    .action-btn-edit {
        background-color: #ecfdf5 !important;
        color: #059669 !important;
        border: 1px solid rgba(16, 185, 129, 0.25) !important;
    }
    .action-btn-edit:hover {
        background-color: #15803d !important;
        color: #ffffff !important;
        border-color: #15803d !important;
    }
    .action-btn-edit:hover i {
        color: #ffffff !important;
    }

    .action-btn-view {
        background-color: #eef2ff !important;
        color: #4f46e5 !important;
        border: 1px solid rgba(99, 102, 241, 0.25) !important;
    }
    .action-btn-view:hover {
        background-color: #4f46e5 !important;
        color: #ffffff !important;
        border-color: #4f46e5 !important;
    }
    .action-btn-view:hover i {
        color: #ffffff !important;
    }

    .action-btn-return {
        background-color: #fffbeb !important;
        color: #d97706 !important;
        border: 1px solid rgba(245, 158, 11, 0.25) !important;
    }
    .action-btn-return:hover {
        background-color: #d97706 !important;
        color: #ffffff !important;
        border-color: #d97706 !important;
    }
    .action-btn-return:hover i {
        color: #ffffff !important;
    }

    .action-btn-delete {
        background-color: #fef2f2 !important;
        color: #dc2626 !important;
        border: 1px solid rgba(239, 68, 68, 0.25) !important;
    }
    .action-btn-delete:hover {
        background-color: #dc2626 !important;
        color: #ffffff !important;
        border-color: #dc2626 !important;
    }
    .action-btn-delete:hover i {
        color: #ffffff !important;
    }

    /* Dark Mode Borders & Elements matching product-list */
    .unified-ui-border {
        border: 1px solid #cbd5e1 !important;
    }
    body[light-mode="dark"] .unified-ui-border,
    html[light-mode="dark"] .unified-ui-border,
    body[data-layout-mode="dark"] .unified-ui-border,
    html.dark .unified-ui-border,
    body.dark .unified-ui-border,
    body.dark-mode .unified-ui-border {
        border: 1px solid #334155 !important;
    }

    body[light-mode="dark"] .action-btn-edit,
    html.dark .action-btn-edit {
        background-color: rgba(16, 185, 129, 0.12) !important;
        border: 1px solid rgba(16, 185, 129, 0.25) !important;
        color: #34d399 !important;
    }
    body[light-mode="dark"] .action-btn-view,
    html.dark .action-btn-view {
        background-color: rgba(99, 102, 241, 0.12) !important;
        border: 1px solid rgba(99, 102, 241, 0.25) !important;
        color: #818cf8 !important;
    }
    body[light-mode="dark"] .action-btn-return,
    html.dark .action-btn-return {
        background-color: rgba(245, 158, 11, 0.12) !important;
        border: 1px solid rgba(245, 158, 11, 0.25) !important;
        color: #fbbf24 !important;
    }
    body[light-mode="dark"] .action-btn-delete,
    html.dark .action-btn-delete {
        background-color: rgba(239, 68, 68, 0.12) !important;
        border: 1px solid rgba(239, 68, 68, 0.25) !important;
        color: #f87171 !important;
    }

    /* Status badge borders subtle in dark mode */
    body[light-mode="dark"] .badge-status-fully-paid,
    html.dark .badge-status-fully-paid {
        background-color: rgba(16, 185, 129, 0.12) !important;
        color: #34d399 !important;
        border: 1px solid rgba(16, 185, 129, 0.25) !important;
    }
    body[light-mode="dark"] .badge-status-partial-paid,
    html.dark .badge-status-partial-paid {
        background-color: rgba(245, 158, 11, 0.12) !important;
        color: #fbbf24 !important;
        border: 1px solid rgba(245, 158, 11, 0.25) !important;
    }
    body[light-mode="dark"] .badge-status-unpaid,
    html.dark .badge-status-unpaid {
        background-color: rgba(239, 68, 68, 0.12) !important;
        color: #f87171 !important;
        border: 1px solid rgba(239, 68, 68, 0.25) !important;
    }

    /* Controls Row Responsive Layout with Mobile Padding */
    .controls-row-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .search-input-wrapper {
        flex: 1;
        min-width: 0;
        padding: 0 12px;
    }
    .controls-filter-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }
    .entries-wrapper {
        padding: 0 10px;
    }

    @media (max-width: 767.98px) {
        .controls-row-wrapper {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
            padding: 8px 0 !important;
            margin-bottom: 12px !important;
        }
        .search-input-wrapper {
            width: 100% !important;
            height: 42px !important;
            padding: 0 14px !important;
        }
        .search-input-wrapper input {
            padding-top: 8px !important;
            padding-bottom: 8px !important;
            height: 100% !important;
            font-size: 13px !important;
        }
        .controls-filter-group {
            width: 100% !important;
            display: flex;
            gap: 10px;
        }
        .entries-wrapper {
            flex: 1;
            height: 42px !important;
            justify-content: space-between;
        }
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
        left: 0;
        min-width: 170px;
        z-index: 9999 !important;
        background: #ffffff !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 12px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.12), 0 4px 12px rgba(0, 0, 0, 0.06) !important;
        padding: 6px;
        max-height: none !important;
        overflow: visible !important;
        overflow-y: visible !important;
    }
    .custom-filter-dropdown .select-options-list {
        max-height: none !important;
        overflow: visible !important;
        overflow-y: visible !important;
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

    body[light-mode="dark"] .custom-filter-dropdown .select-menu,
    html.dark .custom-filter-dropdown .select-menu {
        background: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .custom-filter-dropdown .select-option-item,
    html.dark .custom-filter-dropdown .select-option-item {
        background-color: #1e293b !important;
        color: #f1f5f9 !important;
    }
    body[light-mode="dark"] .custom-filter-dropdown .select-option-item:hover,
    html.dark .custom-filter-dropdown .select-option-item:hover {
        background-color: #0f172a !important;
        color: #34d399 !important;
        border-left: 4px solid #34d399 !important;
    }
    body[light-mode="dark"] .custom-filter-dropdown .select-option-item.active,
    html.dark .custom-filter-dropdown .select-option-item.active {
        background-color: rgba(16, 185, 129, 0.2) !important;
        color: #34d399 !important;
        border-left: 4px solid #34d399 !important;
    }

    /* Solid Green Header Across Light & Dark Mode and Horizontal Scroll */
    #printTable thead tr,
    #printTable thead th {
        background-color: #15803d !important;
        color: #ffffff !important;
        white-space: nowrap !important;
    }
    body[light-mode="dark"] #printTable thead tr,
    body[light-mode="dark"] #printTable thead th,
    html[light-mode="dark"] #printTable thead tr,
    html[light-mode="dark"] #printTable thead th,
    body[data-layout-mode="dark"] #printTable thead tr,
    body[data-layout-mode="dark"] #printTable thead th,
    html.dark #printTable thead tr,
    html.dark #printTable thead th,
    body.dark #printTable thead tr,
    body.dark #printTable thead th,
    body.dark-mode #printTable thead tr,
    body.dark-mode #printTable thead th {
        background-color: #15803d !important;
        color: #ffffff !important;
    }

    /* Single-line Clean Table Rows & Cell Padding */
    #printTable th, #printTable td {
        padding: 10px !important;
        vertical-align: middle !important;
    }
    #printTable tbody tr {
        transition: background-color 0.15s ease;
    }

    body[light-mode="dark"] #printTable tbody tr:hover,
    html[light-mode="dark"] #printTable tbody tr:hover,
    body[data-layout-mode="dark"] #printTable tbody tr:hover,
    html.dark #printTable tbody tr:hover,
    body.dark #printTable tbody tr:hover,
    body.dark-mode #printTable tbody tr:hover {
        background-color: #1e293b !important;
    }

    body[light-mode="dark"] #printTable tfoot tr,
    html[light-mode="dark"] #printTable tfoot tr,
    body[data-layout-mode="dark"] #printTable tfoot tr,
    html.dark #printTable tfoot tr,
    body.dark #printTable tfoot tr,
    body.dark-mode #printTable tfoot tr {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }

    /* Modern Smart Pagination Button Styles */
    .custom-pagination-btn {
        min-width: 34px;
        height: 34px;
        padding: 0 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12.5px;
        font-weight: 600;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background-color: #ffffff;
        color: #475569;
        transition: all 0.15s ease-in-out;
        text-decoration: none;
        cursor: pointer;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    .custom-pagination-btn:hover:not(.disabled):not(.active) {
        background-color: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }
    .custom-pagination-btn.active {
        background: linear-gradient(135deg, #16a34a, #15803d) !important;
        color: #ffffff !important;
        border-color: #15803d !important;
        box-shadow: 0 2px 6px rgba(22, 163, 74, 0.3) !important;
    }
    .custom-pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        background-color: #f8fafc;
        border-color: #e2e8f0;
        color: #94a3b8;
    }

    /* Dark Mode Smart Pagination */
    body[light-mode="dark"] .custom-pagination-btn,
    html[light-mode="dark"] .custom-pagination-btn,
    body[data-layout-mode="dark"] .custom-pagination-btn,
    html.dark .custom-pagination-btn,
    body.dark .custom-pagination-btn,
    body.dark-mode .custom-pagination-btn {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .custom-pagination-btn:hover:not(.disabled):not(.active),
    html[light-mode="dark"] .custom-pagination-btn:hover:not(.disabled):not(.active),
    body[data-layout-mode="dark"] .custom-pagination-btn:hover:not(.disabled):not(.active),
    html.dark .custom-pagination-btn:hover:not(.disabled):not(.active),
    body.dark .custom-pagination-btn:hover:not(.disabled):not(.active),
    body.dark-mode .custom-pagination-btn:hover:not(.disabled):not(.active) {
        background-color: #334155 !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] .custom-pagination-btn.active,
    html[light-mode="dark"] .custom-pagination-btn.active,
    body[data-layout-mode="dark"] .custom-pagination-btn.active,
    html.dark .custom-pagination-btn.active,
    body.dark .custom-pagination-btn.active,
    body.dark-mode .custom-pagination-btn.active {
        background: linear-gradient(135deg, #16a34a, #15803d) !important;
        color: #ffffff !important;
        border-color: #16a34a !important;
    }
    body[light-mode="dark"] .custom-pagination-btn.disabled,
    html[light-mode="dark"] .custom-pagination-btn.disabled,
    body[data-layout-mode="dark"] .custom-pagination-btn.disabled,
    html.dark .custom-pagination-btn.disabled,
    body.dark .custom-pagination-btn.disabled,
    body.dark-mode .custom-pagination-btn.disabled {
        background-color: #0f172a !important;
        border-color: #1e293b !important;
        color: #475569 !important;
    }

    /* Print Styles */
    @media print {
        body * {
            visibility: hidden;
        }
        #printTable, #printTable * {
            visibility: visible;
        }
        #printTable {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        #printTable th:last-child,
        #printTable td:last-child {
            display: none !important;
        }
    }
</style>

<script>
    function viewInvoice(id) {
        window.location.href = `/purchase-invoice/${id}`;
    }

    function viewPurchaseInvoice(id) {
        window.location.href = `/purchase-return/${id}`;
    }

    function formatBarcodes(barcodes) {
        if (!barcodes || !Array.isArray(barcodes) || barcodes.length === 0) {
            return '<span class="text-slate-400 text-xs">N/A</span>';
        }
        return barcodes.map(code => `<span class="inline-block px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/40 text-[11px] font-mono font-semibold me-1">${code}</span>`).join('');
    }

    let rawPurchaseData = [];
    let currentPage = 1;
    let pageSize = 15;
    let startPicker = null;
    let endPicker = null;

    function initPurchaseFlatpickr() {
        if (typeof flatpickr !== 'undefined') {
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
                    currentPage = 1;
                    renderPaginatedList();
                },
                onClose: function() {
                    currentPage = 1;
                    renderPaginatedList();
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
                    currentPage = 1;
                    renderPaginatedList();
                },
                onClose: function() {
                    currentPage = 1;
                    renderPaginatedList();
                }
            });
        }
    }

    function toggleCustomPurchaseFilter() {
        const dropdown = document.getElementById('purchaseFilterDropdown');
        if (!dropdown) return;
        const isOpen = dropdown.classList.contains('is-open');
        dropdown.classList.toggle('is-open', !isOpen);
        const chevron = dropdown.querySelector('.chevron-icon');
        if (chevron) {
            chevron.style.transform = !isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
        }
    }

    function selectPurchaseFilterOption(e, filterVal, labelText) {
        if (e) e.preventDefault();
        const dropdown = document.getElementById('purchaseFilterDropdown');
        if (dropdown) {
            const labelEl = document.getElementById('selectedPurchaseFilterLabel');
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
        } else if (filterVal === 'all') {
            startDate = '';
            endDate = '';
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

        currentPage = 1;
        renderPaginatedList();
    }

    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('purchaseFilterDropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            dropdown.classList.remove('is-open');
            const chevron = dropdown.querySelector('.chevron-icon');
            if (chevron) chevron.style.transform = 'rotate(0deg)';
        }
    });

    $(document).ready(function () {
        if ($.fn.select2) $('.select2').select2();
        $("#entries").val("15");
        initPurchaseFlatpickr();
        getList();
        $("#searchInput").val("");
    });

    $("#searchInput").on("keyup search input", function () {
        currentPage = 1;
        renderPaginatedList();
    });

    $("#entries").on("change", function () {
        pageSize = parseInt($(this).val()) || 15;
        currentPage = 1;
        renderPaginatedList();
    });

    async function getList() {
        try {
            showLoader();
            const res = await axios.get("/api/purchases-list", HeaderToken());
            hideLoader();

            rawPurchaseData = res.data.PurchasessData || res.data.rows || res.data.data || [];
            // Sort newest added data to the top
            if (Array.isArray(rawPurchaseData)) {
                rawPurchaseData.sort((a, b) => (parseInt(b.id) || 0) - (parseInt(a.id) || 0));
            }
            renderPaginatedList();
        } catch (err) {
            hideLoader();
            console.error("Error fetching purchase list:", err);
            unauthorized(err.response ? err.response.status : 500);
        }
    }

    function renderPaginatedList() {
        if (!rawPurchaseData) return;

        let searchTerm = $("#searchInput").val().toLowerCase().trim();
        let startVal = $("#startDate").val();
        let endVal = $("#endDate").val();

        // 1. Filter Purchases by search & date range
        let filtered = rawPurchaseData.filter(function (item) {
            let purchaseId = (item.purchase_id || "").toLowerCase();
            let supplierName = (item.supplier || "").toLowerCase();
            let supplierId = (item.supplier_id || "").toLowerCase();
            let refNo = (item.referance_no || "").toLowerCase();
            let status = (item.payment_status || "").toLowerCase();
            let barcodesStr = Array.isArray(item.barcodes) ? item.barcodes.join(' ').toLowerCase() : "";

            let matchSearch = !searchTerm || purchaseId.includes(searchTerm) || supplierName.includes(searchTerm) || supplierId.includes(searchTerm) || refNo.includes(searchTerm) || status.includes(searchTerm) || barcodesStr.includes(searchTerm);

            let matchDate = true;
            let itemDate = item.raw_date || "";
            if (!itemDate && item.date && item.date !== 'N/A') {
                let parts = item.date.split('-');
                if (parts.length === 3) {
                    itemDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
                }
            }

            if (startVal && itemDate) {
                if (itemDate < startVal) matchDate = false;
            } else if (startVal && !itemDate) {
                matchDate = false;
            }

            if (endVal && itemDate) {
                if (itemDate > endVal) matchDate = false;
            } else if (endVal && !itemDate) {
                matchDate = false;
            }

            return matchSearch && matchDate;
        });

        // 2. Calculate Totals
        let totalG = 0, totalP = 0, totalD = 0, totalReturn = 0;
        filtered.forEach(item => {
            totalG += (parseFloat(item.grand_subtotal) || 0) + (parseFloat(item.delivery_charge) || 0);
            totalP += parseFloat(item.paid_amount) || 0;
            totalD += parseFloat(item.due_amount) || 0;
            totalReturn += parseFloat(item.return_amount) || 0;
        });

        $("#totalGrandTotal").text(`৳ ${totalG.toFixed(2)}`);
        $("#totalPaidAmount").text(`৳ ${totalP.toFixed(2)}`);
        $("#totalDueAmount").text(`৳ ${totalD.toFixed(2)}`);
        $("#totalReturnAmount").text(`৳ ${totalReturn.toFixed(2)}`);

        // 3. Pagination Calculations
        let totalItems = filtered.length;
        let totalPages = Math.ceil(totalItems / pageSize) || 1;
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        let startIndex = (currentPage - 1) * pageSize;
        let endIndex = Math.min(startIndex + pageSize, totalItems);
        let pageItems = filtered.slice(startIndex, endIndex);

        let tbody = $("#tableList");
        let mobileCardList = $("#mobileCardList");

        tbody.empty();
        mobileCardList.empty();

        if (pageItems.length === 0) {
            tbody.html('<tr><td colspan="14" class="text-center text-rose-500 p-6 font-bold">❌ No purchase data found.</td></tr>');
            mobileCardList.html('<div class="p-6 text-center text-rose-500 font-bold bg-white dark:bg-slate-800 rounded-2xl unified-ui-border shadow-sm">❌ No purchase data found.</div>');
        } else {
            pageItems.forEach(function (item, idx) {
                let realIndex = startIndex + idx;
                const g = (parseFloat(item.grand_subtotal) || 0) + (parseFloat(item.delivery_charge) || 0);
                const p = parseFloat(item.paid_amount) || 0;
                const d = parseFloat(item.due_amount) || 0;
                const r = parseFloat(item.return_amount) || 0;

                const statusClass = item.payment_status === 'Fully Paid'
                    ? 'badge-status-fully-paid bg-emerald-50 text-emerald-700 border border-emerald-200'
                    : item.payment_status === 'Partial Paid'
                    ? 'badge-status-partial-paid bg-amber-50 text-amber-700 border border-amber-200'
                    : 'badge-status-unpaid bg-rose-50 text-rose-700 border border-rose-200';

                const isLastRow = (idx >= pageItems.length - 2 && pageItems.length > 1);

                let imgHtml = '';
                if (item.attach_document) {
                    let imgSrc = item.attach_document.startsWith('http') || item.attach_document.startsWith('/') ? item.attach_document : `/${item.attach_document}`;
                    imgHtml = `
                        <div class="w-7 h-7 rounded-full border border-slate-200 dark:border-slate-700 overflow-hidden mx-auto shadow-xs cursor-pointer hover:scale-110 hover:border-emerald-500 transition-all bg-slate-100 dark:bg-slate-800 flex items-center justify-center" onclick="openImagePopup('${imgSrc}', 'Purchase #${item.purchase_id || item.id}')" title="Click to view full image">
                            <img src="${imgSrc}" alt="Doc" class="w-full h-full object-cover" onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\\'fa-solid fa-file-image text-slate-400 text-xs\\'></i>';">
                        </div>
                    `;
                } else {
                    imgHtml = `<div class="w-7 h-7 rounded-full border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-300 dark:text-slate-600 flex items-center justify-center mx-auto text-[10px]" title="No Document"><i class="fa-solid fa-image"></i></div>`;
                }

                // Desktop Row (Action is placed on the FAR RIGHT)
                let row = `
                    <tr data-row="${realIndex + 1}" class="hover:bg-slate-50/80 dark:hover:bg-slate-800/60 transition-colors">
                        <td class="py-2 px-[5px] text-center font-semibold text-slate-500 dark:text-slate-400 text-[11px]">${realIndex + 1}</td>
                        <td class="py-2 px-[5px] text-center">${imgHtml}</td>
                        <td class="py-2 px-[5px] text-center font-medium text-slate-600 dark:text-slate-300 text-[11px] lg:text-xs whitespace-nowrap">${item.date || 'N/A'}</td>
                        <td class="py-2 px-[5px] text-center font-bold text-emerald-700 dark:text-emerald-400 text-[11px] lg:text-xs whitespace-nowrap">${item.purchase_id || 'N/A'}</td>
                        <td class="py-2 px-[5px] text-start font-medium text-slate-500 dark:text-slate-400 text-[11px] lg:text-xs whitespace-nowrap">${item.referance_no || '-'}</td>
                        <td class="py-2 px-[5px] text-start whitespace-nowrap">
                            <a href="/supplier/profile/${item.supplier_db_id || item.supplier_id}" class="inline-flex items-center gap-1 font-semibold text-emerald-700 dark:text-emerald-400 hover:underline text-[11px] lg:text-xs">
                                <i class="fa-solid fa-truck-field text-[10px]"></i>
                                <span>${item.supplier_id || 'N/A'}</span>
                            </a>
                        </td>
                        <td class="py-2 px-[5px] text-start font-bold text-slate-800 dark:text-slate-100 text-[11px] lg:text-xs max-w-[120px] truncate" title="${item.supplier || ''}">
                            <a href="/supplier/profile/${item.supplier_db_id || item.supplier_id}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                                ${item.supplier || 'N/A'}
                            </a>
                        </td>
                        <td class="py-2 px-[5px] text-end font-bold text-slate-800 dark:text-slate-100 text-xs sm:text-[12.5px] whitespace-nowrap font-mono">৳ ${g.toFixed(2)}</td>
                        <td class="py-2 px-[5px] text-end font-bold text-emerald-600 dark:text-emerald-400 text-xs sm:text-[12.5px] whitespace-nowrap font-mono">৳ ${p.toFixed(2)}</td>
                        <td class="py-2 px-[5px] text-end font-bold text-rose-600 dark:text-rose-400 text-xs sm:text-[12.5px] whitespace-nowrap font-mono">৳ ${d.toFixed(2)}</td>
                        <td class="py-2 px-[5px] text-end font-bold text-rose-600 dark:text-rose-400 text-xs sm:text-[12.5px] whitespace-nowrap font-mono">৳ ${r.toFixed(2)}</td>
                        <td class="py-2 px-[5px] text-center font-medium text-slate-600 dark:text-slate-300 text-[11px] lg:text-xs whitespace-nowrap">${item.payment_method || 'N/A'}</td>
                        <td class="py-2 px-[5px] text-center whitespace-nowrap">
                            <span class="px-1.5 py-0.5 rounded-md text-[10.5px] lg:text-xs font-bold inline-flex items-center gap-0.5 ${statusClass}">
                                ${item.payment_status || 'Unpaid'}
                            </span>
                        </td>
                        <td class="py-2 px-[5px] text-center">
                            <div class="dropdown ${isLastRow ? 'dropup' : ''} inline-block position-relative">
                                <button class="w-[26px] h-[26px] rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center shadow-sm transition-all duration-150 mx-auto" type="button" data-bs-toggle="dropdown" data-bs-display="static" data-bs-boundary="viewport" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical text-xs"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-xl border border-slate-200 dark:border-slate-700 rounded-xl p-1 bg-white dark:bg-slate-800 text-xs" style="min-width: 145px; z-index: 99999;">
                                    <li>
                                        <a class="dropdown-item rounded-lg px-2.5 py-1.5 flex items-center gap-2 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700/60 font-medium" href="javascript:void(0)" onclick="viewInvoice(${item.id})">
                                            <i class="fa-solid fa-eye text-emerald-600 dark:text-emerald-400 w-4 text-center"></i>
                                            <span>View Memo</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-lg px-2.5 py-1.5 flex items-center gap-2 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700/60 font-medium edit-link" href="javascript:void(0)" data-id="${item.id}" data-bs-toggle="modal" data-bs-target="#purchaseUpdateModal">
                                            <i class="fa-solid fa-pen-to-square text-amber-500 w-4 text-center"></i>
                                            <span>Edit</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-lg px-2.5 py-1.5 flex items-center gap-2 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700/60 font-medium" href="javascript:void(0)" onclick="viewPurchaseInvoice(${item.id})">
                                            <i class="fa-solid fa-rotate-left text-indigo-500 w-4 text-center"></i>
                                            <span>Return</span>
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1 border-slate-200 dark:border-slate-700"></li>
                                    <li>
                                        <a class="dropdown-item rounded-lg px-2.5 py-1.5 flex items-center gap-2 text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 font-medium custom-delete-modal-btn" href="javascript:void(0)" data-id="${item.id}" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                                            <i class="fa-solid fa-trash w-4 text-center"></i>
                                            <span>Delete</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>`;
                tbody.append(row);

                // Mobile Card View
                let mobileCard = `
                    <div class="purchase-mobile-card p-4 rounded-2xl bg-white dark:bg-slate-800/90 unified-ui-border shadow-sm relative transition-all">
                        <div class="flex items-center justify-between pb-2.5 mb-2.5 border-b border-slate-200 dark:border-slate-700">
                            <div class="flex items-center gap-1.5">
                                <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-bold">#${realIndex + 1}</span>
                                <span class="px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/40 text-emerald-700 dark:text-emerald-400 text-xs font-bold">
                                    <i class="fa-solid fa-receipt me-1"></i>${item.purchase_id || 'N/A'}
                                </span>
                            </div>
                            <div>
                                <span class="px-2 py-0.5 rounded-md text-xs font-bold inline-flex items-center gap-1 ${statusClass}">
                                    ${item.payment_status || 'Unpaid'}
                                </span>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="flex items-center justify-between">
                                <h6 class="font-bold text-slate-800 dark:text-white text-sm m-0 flex items-center gap-1">
                                    <i class="fa-solid fa-truck-field text-emerald-600 dark:text-emerald-400"></i>
                                    <span>${item.supplier || 'N/A'}</span>
                                </h6>
                                <span class="text-slate-500 dark:text-slate-400 text-xs font-medium">${item.date || ''}</span>
                            </div>
                            <div class="text-slate-500 dark:text-slate-400 text-xs mt-1">
                                Ref: <span class="font-semibold text-slate-700 dark:text-slate-300">${item.referance_no || 'N/A'}</span>
                            </div>
                            <div class="mt-1.5">${formatBarcodes(item.barcodes)}</div>
                        </div>

                        <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-700/60 my-2.5">
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div>
                                    <span class="text-slate-500 dark:text-slate-400">Grand Total:</span>
                                    <div class="font-bold text-slate-800 dark:text-white text-sm">৳ ${g.toFixed(2)}</div>
                                </div>
                                <div class="text-end">
                                    <span class="text-slate-500 dark:text-slate-400">Paid:</span>
                                    <div class="font-bold text-emerald-600 dark:text-emerald-400 text-sm">৳ ${p.toFixed(2)}</div>
                                </div>
                                <div class="mt-1">
                                    <span class="text-slate-500 dark:text-slate-400">Due:</span>
                                    <div class="font-bold text-rose-600 dark:text-rose-400">৳ ${d.toFixed(2)}</div>
                                </div>
                                <div class="text-end mt-1">
                                    <span class="text-slate-500 dark:text-slate-400">Return:</span>
                                    <div class="font-bold text-rose-600 dark:text-rose-400">৳ ${r.toFixed(2)}</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2.5 mt-1 border-t border-slate-200 dark:border-slate-700">
                            <button onclick="viewInvoice(${item.id})" class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 dark:bg-indigo-950/40 dark:hover:bg-indigo-900/50 dark:text-indigo-400 text-xs font-semibold rounded-lg border border-indigo-200 dark:border-indigo-800/40 transition-colors">
                                <i class="fa-solid fa-eye text-xs"></i>
                                <span>View Memo</span>
                            </button>
                            <div class="flex items-center gap-1.5">
                                <a data-id="${item.id}" href="#" class="edit-link action-btn-edit w-[32px] h-[32px] rounded-lg flex items-center justify-center transition-all duration-150 shadow-sm" data-bs-toggle="modal" data-bs-target="#purchaseUpdateModal" title="Edit Purchase">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </a>
                                <button onclick="viewPurchaseInvoice(${item.id})" class="action-btn-return w-[32px] h-[32px] rounded-lg flex items-center justify-center transition-all duration-150 shadow-sm" title="Purchase Return">
                                    <i class="fa-solid fa-rotate-left text-xs"></i>
                                </button>
                                <a href="#" data-id="${item.id}" class="custom-delete-modal-btn action-btn-delete w-[32px] h-[32px] rounded-lg flex items-center justify-center transition-all duration-150 shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmationModal" title="Delete Purchase">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>`;
                mobileCardList.append(mobileCard);
            });
        }

        // Delete button listener
        $(".custom-delete-modal-btn").on("click", function () {
            let id = $(this).data("id");
            $("#deleteID").val(id);
            $("#confirmationModal").modal("show");
        });

        // 4. Update Display Info & Pagination UI
        let fromCount = totalItems > 0 ? startIndex + 1 : 0;
        let toCount = endIndex;
        $("#display-info").html(`
            <div class="flex items-center gap-1.5 text-xs sm:text-sm font-medium text-slate-500 dark:text-slate-400">
                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                <span>Showing</span>
                <span class="font-bold text-slate-700 dark:text-slate-200 px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">${fromCount} – ${toCount}</span>
                <span>of</span>
                <span class="font-bold text-emerald-700 dark:text-emerald-400 px-1.5 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-slate-800">${totalItems}</span>
                <span>purchases</span>
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
        let prevBtn = `
            <button type="button" class="custom-pagination-btn ${prevDisabled}" ${currentPage === 1 ? 'disabled' : ''} onclick="goToPage(${currentPage - 1})">
                <svg class="w-3 h-3 me-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg> Prev
            </button>
        `;
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
        let nextBtn = `
            <button type="button" class="custom-pagination-btn ${nextDisabled}" ${currentPage === totalPages ? 'disabled' : ''} onclick="goToPage(${currentPage + 1})">
                Next <svg class="w-3 h-3 ms-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
        `;
        pagContainer.append(nextBtn);
    }

    function goToPage(page) {
        currentPage = page;
        renderPaginatedList();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Export Buttons Functionality
    $("#copyBtn").on("click", function() {
        let table = document.getElementById("printTable");
        let range = document.createRange();
        range.selectNode(table);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand("copy");
        window.getSelection().removeAllRanges();
        if (typeof successToast === "function") successToast("Table copied to clipboard!");
        else alert("Table copied to clipboard!");
    });

    $("#printBtn").on("click", function() {
        window.print();
    });

    $("#csvBtn").on("click", function() {
        let csv = [];
        let rows = document.querySelectorAll("#printTable tr");
        for (let i = 0; i < rows.length; i++) {
            let row = [], cols = rows[i].querySelectorAll("td, th");
            for (let j = 0; j < cols.length; j++) {
                if (j === cols.length - 1) continue; // Skip action column
                let text = cols[j].innerText.replace(/"/g, '""').trim();
                row.push('"' + text + '"');
            }
            csv.push(row.join(","));
        }
        let csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
        let downloadLink = document.createElement("a");
        downloadLink.download = "purchase-list.csv";
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    });

    $("#pdfBtn").on("click", function() {
        window.print();
    });

    $("#xlsxBtn").on("click", function() {
        let csv = [];
        let rows = document.querySelectorAll("#printTable tr");
        for (let i = 0; i < rows.length; i++) {
            let row = [], cols = rows[i].querySelectorAll("td, th");
            for (let j = 0; j < cols.length; j++) {
                if (j === cols.length - 1) continue; // Skip action column
                let text = cols[j].innerText.replace(/"/g, '""').trim();
                row.push('"' + text + '"');
            }
            csv.push(row.join("\t"));
        }
        let file = new Blob([csv.join("\n")], { type: "application/vnd.ms-excel" });
        let downloadLink = document.createElement("a");
        downloadLink.download = "purchase-list.xls";
        downloadLink.href = window.URL.createObjectURL(file);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    });

    window.refreshPurchaseList = getList;

    function openImagePopup(src, title) {
        const modal = document.getElementById('imagePreviewModal');
        const img = document.getElementById('imagePreviewSrc');
        if (modal && img) {
            if (modal.parentElement !== document.body) {
                document.body.appendChild(modal);
            }
            img.src = src;
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function closeImagePopup() {
        const modal = document.getElementById('imagePreviewModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
            const img = document.getElementById('imagePreviewSrc');
            if (img) img.src = '';
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeImagePopup();
    });
</script>
