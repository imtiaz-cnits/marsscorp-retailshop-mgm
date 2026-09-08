<!-- Hero Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-[calc(100vh-70px)] flex flex-col justify-between">
        <div class="data-table flex-grow">
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-10">
                    
                    <!-- 1. Top Section: Page Title & Top Action Buttons -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                        <!-- Page Title inside .card-body (Zero bottom margin, description removed) -->
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                    <polyline points="2 17 12 22 22 17"></polyline>
                                    <polyline points="2 12 12 17 22 12"></polyline>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Category List</h1>
                        </div>

                        <!-- Right Controls: + Create Category Button & Action Buttons with Unified Border -->
                        <div class="flex items-center flex-wrap gap-2">
                            <button id="openModalBtns" type="button" data-bs-toggle="modal" data-bs-target="#categoryCreateModal" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Create Category</span>
                            </button>

                            <!-- Action Buttons (38px x 38px, Unified Border matching Searchbar, Dropdowns, Table) -->
                            {{-- <div class="flex items-center gap-1.5">
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
                    </div>

                    <!-- 2. Controls & Filter Row: Desktop (Search big on left, Show Entries, All Status on right); Mobile (Row 1 Search, Row 2 Show Entries + Status) -->
                    <div class="controls-row-wrapper mb-4 w-full">
                        <!-- Search Bar: Big on Left on Desktop, Full Width on Mobile -->
                        <div class="search-input-wrapper unified-ui-border h-[38px] flex items-center bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding-left: 4px !important; padding-right: 4px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search Category..." />
                        </div>

                        <!-- Secondary Controls Group (Show Entries + Status Filter) -->
                        <div class="controls-filter-group">
                            <!-- Show Entries: Content-width only on both desktop and mobile -->
                            <div class="entries-wrapper unified-ui-border flex items-center gap-1.5 bg-white dark:bg-slate-800/90 h-[38px] rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 shadow-sm transition-all hover:border-emerald-500">
                                <span class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider whitespace-nowrap">SHOW:</span>
                                <select id="entries" class="bg-transparent border-0 text-xs sm:text-sm font-bold text-emerald-700 dark:text-emerald-400 focus:outline-none cursor-pointer py-1 pr-1 text-end" style="cursor: pointer;">
                                    <option value="15" selected class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">15</option>
                                    <option value="50" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">50</option>
                                    <option value="100" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">100</option>
                                    <option value="200" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">200</option>
                                    <option value="500" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">500</option>
                                </select>
                            </div>

                            <!-- Status Filter: Expands on mobile, fixed 170px on desktop -->
                            <div class="filter-status-container">
                                <select id="filterStatus" class="hidden">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <div class="custom-searchable-select custom-filter-dropdown w-full" id="filterStatusDropdown">
                                    <div class="select-trigger unified-ui-border flex items-center justify-between px-3 sm:px-3.5 h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-sm text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-200 cursor-pointer hover:border-emerald-500 transition-all duration-150 w-full" style="padding-left: 14px !important; padding-right: 12px !important;" onclick="toggleCustomStatusFilter()">
                                        <div class="flex items-center gap-1.5 overflow-hidden">
                                            <svg class="w-3.5 h-3.5 text-slate-500 dark:text-slate-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                                            </svg>
                                            <span id="selectedStatusLabel" class="selected-text truncate font-semibold">All Status</span>
                                        </div>
                                        <svg class="w-3.5 h-3.5 text-slate-400 chevron-icon transition-transform duration-200 flex-shrink-0 ms-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </div>
                                    <div class="select-menu dropdown-menus shadow-xl w-full" style="min-width: 170px;">
                                        <div class="select-options-list">
                                            <div class="select-option-item active" data-value="" onclick="selectStatusFilterOption(event, '', 'All Status')">
                                                <span>All Status</span>
                                                <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </div>
                                            <div class="select-option-item" data-value="active" onclick="selectStatusFilterOption(event, 'active', 'Active')">
                                                <span>Active</span>
                                            </div>
                                            <div class="select-option-item" data-value="inactive" onclick="selectStatusFilterOption(event, 'inactive', 'Inactive')">
                                                <span>Inactive</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Desktop Table (SL rounded-tl-2xl, Action rounded-tr-2xl, solid emerald header, single line, 10px padding) -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900 mb-4">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                    <th class="p-[10px] text-center w-[65px] whitespace-nowrap" style="width: 65px !important;">Image</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Category Name</th>
                                    <th class="p-[10px] text-center w-[120px] whitespace-nowrap">Status</th>
                                    <th class="p-[10px] text-center w-[100px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableList" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200"></tbody>
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
        background: transparent !important;
    }
    .copyright {
        margin-top: auto !important;
        width: 100% !important;
    }

    /* Card-body padding standard */
    .product-card-body {
        padding: 10px !important;
    }
    @media (min-width: 768px) {
        .product-card-body {
            padding: 16px !important;
        }
    }

    /* Controls Row & Elements: Desktop (Search big on left, Show Entries, All Status on right); Mobile (Row 1 Search, Row 2 Show Entries + Status) */
    .controls-row-wrapper {
        width: 100% !important;
        margin-bottom: 16px;
    }
    .search-input-wrapper {
        padding-left: 14px !important;
        padding-right: 14px !important;
    }
    /* Show Entries: Strictly content-width on both desktop & mobile */
    .entries-wrapper {
        width: max-content !important;
        flex-shrink: 0 !important;
        padding-left: 12px !important;
        padding-right: 8px !important;
    }

    /* Desktop View: Big Search on Left, then Show Entry, then All Status */
    @media (min-width: 640px) {
        .controls-row-wrapper {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 14px !important;
        }
        .search-input-wrapper {
            flex: 1 1 auto !important;
            width: auto !important;
            min-width: 0 !important;
        }
        .controls-filter-group {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 12px !important;
            flex: 0 0 auto !important;
        }
        .entries-wrapper {
            flex: 0 0 auto !important;
            width: max-content !important;
        }
        .filter-status-container {
            flex: 0 0 170px !important;
            width: 170px !important;
            min-width: 170px !important;
        }
    }

    /* Mobile View: Row 1 = Search (full width), Row 2 = Show Entries + All Status (side-by-side) */
    @media (max-width: 639px) {
        .controls-row-wrapper {
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
        }
        .search-input-wrapper {
            width: 100% !important;
        }
        .controls-filter-group {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 8px !important;
            width: 100% !important;
        }
        .entries-wrapper {
            flex: 0 0 auto !important;
            width: max-content !important;
        }
        .filter-status-container {
            flex: 1 1 auto !important;
            width: 100% !important;
            min-width: 0 !important;
        }
    }

    /* Unified UI Border Color for Light Mode across all fields, buttons, and table */
    .unified-ui-border {
        border: 1.5px solid #cbd5e1 !important;
    }

    /* Search input wrapper focus ring */
    .search-input-wrapper:focus-within {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.25) !important;
    }

    /* Inner input inside searchbar must never have its own focus border, outline, or shadow */
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

    /* + Create Category Button Fix: strict 38px height & keep white text on hover */
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

    /* Table headers strictly 1 line, no wrapping */
    #printTable thead th {
        white-space: nowrap !important;
    }

    /* Table TH & TD padding strictly 10px on all sides */
    #printTable th,
    #printTable td,
    #printTable thead th,
    #printTable tbody td {
        padding: 10px !important;
        vertical-align: middle !important;
    }

    /* Logo & Image Column Small Profile Type */
    #printTable th:nth-child(2),
    #printTable td:nth-child(2) {
        width: 65px !important;
        max-width: 65px !important;
        text-align: center !important;
        vertical-align: middle !important;
    }
    #printTable td:nth-child(2) img,
    #tableList td img {
        width: 38px !important;
        height: 38px !important;
        min-width: 38px !important;
        max-width: 38px !important;
        min-height: 38px !important;
        max-height: 38px !important;
        border-radius: 50% !important;
        object-fit: cover !important;
        display: inline-block !important;
        margin: 0 auto !important;
    }

    /* Modal Dark Mode Title White & Dropdown Pointer Fix */
    .modal-header,
    .modal-header *,
    .modal-header h5,
    .modal-header .modal-title,
    .modal-header span,
    .modal-header i {
        color: #ffffff !important;
    }
    .modal-content {
        border-radius: 16px !important;
        overflow: hidden !important;
    }
    .form-select,
    select.form-select {
        cursor: pointer !important;
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
        min-width: 100%;
        width: max-content;
        max-width: 240px;
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
    .custom-filter-dropdown .select-options-list {
        max-height: 200px;
        overflow-y: auto;
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

    /* Modern Smart Pagination Button Styles */
    .custom-pagination-btn {
        min-width: 36px;
        height: 36px;
        padding: 0 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 600;
        border-radius: 10px;
        border: 1.5px solid #cbd5e1;
        background-color: #ffffff;
        color: #475569;
        transition: all 0.2s ease-in-out;
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
        border-color: #16a34a !important;
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3) !important;
        font-weight: 700;
    }
    .custom-pagination-btn.disabled {
        opacity: 0.45;
        cursor: not-allowed;
        background-color: #f8fafc;
        border-color: #cbd5e1;
        color: #94a3b8;
    }

    /* Dark Mode Theme Rules Matching Product List (#334155 Borders) */
    body[light-mode="dark"] .card,
    body[data-layout-mode="dark"] .card,
    html.dark .card,
    body.dark-mode .card {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .card-body,
    body[data-layout-mode="dark"] .card-body,
    html.dark .card-body {
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
    html.dark .unified-ui-border,
    body[light-mode="dark"] #printTable,
    body[light-mode="dark"] #printTable th,
    body[light-mode="dark"] #printTable td,
    body[light-mode="dark"] #searchInput,
    body[light-mode="dark"] .search-input-wrapper,
    body[light-mode="dark"] .entries-wrapper,
    body[light-mode="dark"] .custom-filter-dropdown .select-trigger,
    body[light-mode="dark"] .custom-filter-dropdown .select-menu,
    body[light-mode="dark"] #copyBtn,
    body[light-mode="dark"] #csvBtn,
    body[light-mode="dark"] #pdfBtn,
    body[light-mode="dark"] #printBtn,
    body[light-mode="dark"] #xlsxBtn,
    body[light-mode="dark"] .category-mobile-card,
    body[light-mode="dark"] .category-mobile-card img,
    body[light-mode="dark"] #printTable td img,
    body[light-mode="dark"] .edit-link,
    body[light-mode="dark"] .custom-delete-modal-btn,
    body[light-mode="dark"] #display-info .display-info-box {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .custom-filter-dropdown .select-trigger {
        background-color: #1e293b !important;
        color: #f1f5f9 !important;
    }
    body[light-mode="dark"] .custom-filter-dropdown .select-menu {
        background-color: #1e293b !important;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.5) !important;
    }
    body[light-mode="dark"] .custom-filter-dropdown .select-option-item {
        background-color: #1e293b !important;
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .custom-filter-dropdown .select-option-item:hover {
        background-color: #334155 !important;
        color: #4ade80 !important;
        border-left: 4px solid #22c55e !important;
    }
    body[light-mode="dark"] .custom-filter-dropdown .select-option-item.active {
        background-color: rgba(34, 197, 94, 0.15) !important;
        color: #4ade80 !important;
        border-left: 4px solid #22c55e !important;
    }
    body[light-mode="dark"] #copyBtn,
    body[light-mode="dark"] #csvBtn,
    body[light-mode="dark"] #pdfBtn,
    body[light-mode="dark"] #printBtn,
    body[light-mode="dark"] #xlsxBtn {
        background-color: #1e293b !important;
        color: #94a3b8 !important;
    }
    body[light-mode="dark"] #copyBtn:hover,
    body[light-mode="dark"] #csvBtn:hover,
    body[light-mode="dark"] #pdfBtn:hover,
    body[light-mode="dark"] #printBtn:hover,
    body[light-mode="dark"] #xlsxBtn:hover {
        background-color: #334155 !important;
        border-color: #475569 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .category-mobile-card {
        background-color: #1e293b !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .category-mobile-card img,
    body[light-mode="dark"] #printTable td img {
        background-color: #1e293b !important;
    }
    body[light-mode="dark"] .custom-pagination-btn {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .custom-pagination-btn:hover:not(.disabled):not(.active) {
        background-color: #334155 !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] .custom-pagination-btn.active {
        background: linear-gradient(135deg, #16a34a, #15803d) !important;
        color: #ffffff !important;
        border-color: #16a34a !important;
    }
    body[light-mode="dark"] .custom-pagination-btn.disabled {
        background-color: #0f172a !important;
        border-color: #1e293b !important;
        color: #475569 !important;
    }
    body[light-mode="dark"] #display-info .display-info-box {
        background-color: #1e293b !important;
    }

    /* Mobile View: Reduced padding & 1-line pagination */
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
    let rawCategoryData = [];
    let currentPage = 1;
    let pageSize = 15;

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
        getList();
        $("#searchInput").val("");
    });

    $(document).on('click', '.pos-theme-toggle-btn', function() {
        setTimeout(syncThemeClasses, 50);
    });

    // Close dropdown on outer click
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('filterStatusDropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            dropdown.classList.remove('is-open');
        }
    });

    function toggleCustomStatusFilter() {
        const dropdown = document.getElementById('filterStatusDropdown');
        if (dropdown) {
            dropdown.classList.toggle('is-open');
        }
    }

    function selectStatusFilterOption(event, val, label) {
        event.preventDefault();
        event.stopPropagation();
        $("#filterStatus").val(val);
        $("#selectedStatusLabel").text(label);

        $("#filterStatusDropdown .select-option-item").removeClass('active');
        $("#filterStatusDropdown .select-option-item").find('.check-icon').remove();

        const currentItem = event.currentTarget;
        currentItem.classList.add('active');
        $(currentItem).append('<svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>');

        $("#filterStatusDropdown").removeClass('is-open');
        currentPage = 1;
        renderPaginatedList();
    }

    // --- Event Listeners ---
    $("#searchInput").on("keyup search input", function() {
        currentPage = 1;
        renderPaginatedList();
    });

    $("#entries").on("change", function() {
        pageSize = parseInt($(this).val()) || 15;
        currentPage = 1;
        renderPaginatedList();
    });

    async function getList() {
        try {
            showLoader();
            let res = await axios.get("/api/category-list", HeaderToken());
            hideLoader();

            if (res.data && res.data.status === "success" && res.data.CategoryData) {
                rawCategoryData = res.data.CategoryData;
                // Always sort newest first (ID descending) so newly created categories appear on top
                rawCategoryData.sort((a, b) => (b.id || 0) - (a.id || 0));
                currentPage = 1;
                renderPaginatedList();
            } else {
                rawCategoryData = [];
                renderPaginatedList();
            }
        } catch (e) {
            hideLoader();
            console.error("Category Fetch Error:", e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    function renderPaginatedList() {
        let searchTerm = ($("#searchInput").val() || "").toLowerCase().trim();
        let statusFilter = ($("#filterStatus").val() || "").toLowerCase().trim();

        // 1. Filter Categories (Search + Status)
        let filtered = rawCategoryData.filter(function(item) {
            let name = (item.category_name || "").toLowerCase();
            let status = (item.status || "Active").toLowerCase();
            let matchesSearch = !searchTerm || name.includes(searchTerm);
            let matchesStatus = !statusFilter || status === statusFilter;
            return matchesSearch && matchesStatus;
        });

        // 2. Pagination Calculations
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
            tableList.html('<tr><td colspan="5" class="text-center text-rose-500 font-bold p-8 dark:text-rose-400">❌ No categories found.</td></tr>');
            mobileCardList.html('<div class="p-6 text-center text-rose-500 dark:text-rose-400 font-bold bg-white dark:bg-slate-800 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm">❌ No categories found.</div>');
        } else {
            pageItems.forEach(function(item, idx) {
                let realIndex = startIndex + idx;
                let img = item.img_url ? (item.img_url.startsWith('http') ? item.img_url : '/' + item.img_url.replace(/^\/+/, '')) : "{{ asset('backend/assets/img/category-defult-img.svg') }}";
                let isActive = (item.status === 'Active' || item.status === 'active');
                let statusBadgeHtml = isActive
                    ? `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-slate-800 shadow-xs">Active</span>`
                    : `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-950/40 dark:text-rose-300 dark:border-slate-800 shadow-xs">Inactive</span>`;

                // Desktop Row
                let row = `
                    <tr data-row="${realIndex + 1}" class="transition-colors">
                        <td class="text-center font-bold text-slate-400 dark:text-slate-500">${realIndex + 1}</td>
                        <td class="text-center" style="width: 65px !important;">
                            <div class="inline-flex items-center justify-center rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-xs overflow-hidden mx-auto" style="width: 38px !important; height: 38px !important; min-width: 38px !important; min-height: 38px !important; border-radius: 50% !important;">
                                <img alt="${item.category_name}" src="${img}" style="width: 38px !important; height: 38px !important; border-radius: 50% !important; object-fit: cover !important; display: block;" onerror="this.src='{{ asset('backend/assets/img/category-defult-img.svg') }}'">
                            </div>
                        </td>
                        <td class="text-start">
                            <span class="font-bold text-slate-800 dark:text-slate-100 text-sm sm:text-base">${item.category_name}</span>
                        </td>
                        <td class="text-center">
                            ${statusBadgeHtml}
                        </td>
                        <td class="text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <button type="button" data-id="${item.id}" class="edit-link w-[30px] h-[30px] rounded-lg bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200 dark:bg-emerald-950/40 dark:border-slate-800 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white flex items-center justify-center transition-all shadow-sm" data-bs-toggle="modal" data-bs-target="#categoryUpdateModal" title="Edit Category">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg>
                                </button>
                                <button type="button" data-id="${item.id}" class="custom-delete-modal-btn w-[30px] h-[30px] rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200 dark:bg-rose-950/40 dark:border-slate-800 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white flex items-center justify-center transition-all shadow-sm" data-bs-toggle="modal" data-bs-target="#categoryDeleteModal" title="Delete Category">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>`;
                tableList.append(row);

                // Mobile Card View
                let mobileCard = `
                    <div class="category-mobile-card unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800/80 shadow-sm mb-3 transition-all">
                        <div class="flex items-center justify-between pb-2.5 mb-2.5 border-b border-slate-100 dark:border-slate-800">
                            <span class="px-2 py-0.5 rounded-md font-mono text-[11px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">#${realIndex + 1}</span>
                            ${statusBadgeHtml}
                        </div>
                        <div class="flex items-center gap-3 mb-2.5">
                            <div class="rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 flex-shrink-0 overflow-hidden flex items-center justify-center shadow-xs" style="width: 40px !important; height: 40px !important; border-radius: 50% !important;">
                                <img src="${img}" style="width: 40px !important; height: 40px !important; border-radius: 50% !important; object-fit: cover !important;" onerror="this.src='{{ asset('backend/assets/img/category-defult-img.svg') }}'">
                            </div>
                            <div>
                                <h6 class="font-bold text-slate-800 dark:text-slate-100 text-sm sm:text-base leading-snug">${item.category_name}</h6>
                                <span class="text-[11px] font-medium text-slate-400 dark:text-slate-500">Category Item</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-2.5 mt-1 border-t border-slate-100 dark:border-slate-800">
                            <span class="text-xs font-semibold text-slate-400 dark:text-slate-500">Actions:</span>
                            <div class="flex items-center gap-2">
                                <button type="button" data-id="${item.id}" class="edit-link w-[32px] h-[32px] rounded-xl bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200 dark:bg-emerald-950/40 dark:border-slate-800 dark:text-emerald-400 flex items-center justify-center transition-all shadow-sm" data-bs-toggle="modal" data-bs-target="#categoryUpdateModal" title="Edit Category">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg>
                                </button>
                                <button type="button" data-id="${item.id}" class="custom-delete-modal-btn w-[32px] h-[32px] rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200 dark:bg-rose-950/40 dark:border-slate-800 dark:text-rose-400 flex items-center justify-center transition-all shadow-sm" data-bs-toggle="modal" data-bs-target="#categoryDeleteModal" title="Delete Category">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>`;
                mobileCardList.append(mobileCard);
            });
        }

        // Bind events for edit & delete buttons
        $('.edit-link').off('click').on('click', async function() {
            let id = $(this).data('id');
            if (typeof FillUpCategoryUpdateForm === 'function') {
                await FillUpCategoryUpdateForm(id);
            }
        });

        $('.custom-delete-modal-btn').off('click').on('click', function() {
            let id = $(this).data('id');
            $("#deleteCategoryID").val(id);
        });

        // 3. Update Display Info & Pagination UI (Modern clean style)
        let fromCount = totalItems > 0 ? startIndex + 1 : 0;
        let toCount = endIndex;
        $("#display-info").html(`
            <div class="flex items-center gap-1.5 text-xs sm:text-sm font-medium text-slate-500 dark:text-slate-400">
                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                <span>Showing</span>
                <span class="display-info-box font-bold text-slate-800 dark:text-slate-100 px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-800">${fromCount} – ${toCount}</span>
                <span>of</span>
                <span class="display-info-box font-bold text-emerald-700 dark:text-emerald-400 px-1.5 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-slate-800">${totalItems}</span>
                <span>categories</span>
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
            <button type="button" class="custom-pagination-btn pagination-nav-btn ${prevDisabled}" ${currentPage === 1 ? 'disabled' : ''} onclick="goToPage(${currentPage - 1})">
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
            <button type="button" class="custom-pagination-btn pagination-nav-btn ${nextDisabled}" ${currentPage === totalPages ? 'disabled' : ''} onclick="goToPage(${currentPage + 1})">
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
</script>
