    <!-- Hero Main Content Start -->
    <div class="main-content">
        <div class="page-content min-h-[calc(100vh-70px)] flex flex-col justify-between">
            <div class="data-table flex-grow">
                <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                    <div class="card-body product-card-body p-4 sm:p-6 md:p-10">
                        
                        <!-- 1. Top Section: Page Title (No margin below) & Top Action Buttons -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                            <!-- Page Title inside .card-body (Zero bottom margin, description removed) -->
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                </div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Product List</h1>
                            </div>

                            <!-- Right Controls: + Add Product Button (Fixed 38px, white text on hover) & Action Buttons with Unified Border -->
                            <div class="flex items-center flex-wrap gap-2">
                                <button id="openModalBtns" onclick="openProductCreateModal()" type="button" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                    <span>Add Product</span>
                                </button>

                                <!-- Action Buttons (38px x 38px, Unified Border matching Searchbar, Dropdowns, Table) -->
                                <div class="flex items-center gap-1.5">
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
                                </div>
                            </div>
                        </div>

                        <!-- 2. Controls & Filter Row: On Mobile: Row 1 = Search + Show, Row 2 = Brand + Category | On Desktop: Clean Flex Row -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-2.5 sm:gap-3 mb-4">
                            <!-- Group 1: Search Bar + Show Entry (Side-by-Side on Mobile & Desktop) -->
                            <div class="flex items-center gap-2 sm:gap-2.5 w-full md:w-auto">
                                <!-- Search Bar with perfectly aligned icon & placeholder -->
                                <div class="search-input-wrapper unified-ui-border flex-1 md:w-[260px] lg:w-[300px] h-[38px] flex items-center px-3 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                                    <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                    <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search Product..." />
                                </div>

                                <!-- Entries Selector: Beside Search Bar in Mobile & Desktop -->
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

                            <!-- Group 2: All Brands + All Categories (Side-by-Side in 1 Row on Mobile & Desktop) -->
                            <div class="flex items-center gap-2 sm:gap-2.5 w-full md:w-auto">
                                <!-- Brand Filter Dropdown -->
                                <select id="filterBrand" class="hidden">
                                    <option value="">All Brands</option>
                                </select>
                                <div class="custom-searchable-select custom-filter-dropdown flex-1 min-w-0 md:w-[200px] lg:w-[230px]" id="filterBrandDropdown">
                                    <div class="select-trigger unified-ui-border flex items-center justify-between px-3 sm:px-3.5 h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-sm text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-200 cursor-pointer hover:border-emerald-500 transition-all duration-150" onclick="toggleCustomListFilter('filterBrandDropdown')">
                                        <span class="selected-text text-truncate flex-1">All Brands</span>
                                        <svg class="w-3.5 h-3.5 text-slate-400 chevron-icon transition-transform duration-200 flex-shrink-0 ms-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </div>
                                    <div class="select-menu">
                                        <div class="search-wrap">
                                            <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                            <input type="text" placeholder="Search Brand..." oninput="filterCustomListOptions('filterBrandDropdown', this.value)" class="unified-ui-border w-full h-8 pl-8 pr-2 text-xs bg-white dark:bg-slate-800 rounded-lg outline-none focus:border-emerald-500 text-slate-800 dark:text-slate-100" />
                                        </div>
                                        <div class="select-options-list">
                                            <div class="select-option-item active" data-value="" data-label="All Brands" onclick="selectCustomFilterOption('filterBrandDropdown', 'filterBrand', '', 'All Brands')">
                                                <span>All Brands</span>
                                                <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Category Filter Dropdown -->
                                <select id="filterCategory" class="hidden">
                                    <option value="">All Categories</option>
                                </select>
                                <div class="custom-searchable-select custom-filter-dropdown flex-1 min-w-0 md:w-[200px] lg:w-[230px]" id="filterCategoryDropdown">
                                    <div class="select-trigger unified-ui-border flex items-center justify-between px-3 sm:px-3.5 h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-sm text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-200 cursor-pointer hover:border-emerald-500 transition-all duration-150" onclick="toggleCustomListFilter('filterCategoryDropdown')">
                                        <span class="selected-text text-truncate flex-1">All Categories</span>
                                        <svg class="w-3.5 h-3.5 text-slate-400 chevron-icon transition-transform duration-200 flex-shrink-0 ms-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </div>
                                    <div class="select-menu">
                                        <div class="search-wrap">
                                            <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                            <input type="text" placeholder="Search Category..." oninput="filterCustomListOptions('filterCategoryDropdown', this.value)" class="unified-ui-border w-full h-8 pl-8 pr-2 text-xs bg-white dark:bg-slate-800 rounded-lg outline-none focus:border-emerald-500 text-slate-800 dark:text-slate-100" />
                                        </div>
                                        <div class="select-options-list">
                                            <div class="select-option-item active" data-value="" data-label="All Categories" onclick="selectCustomFilterOption('filterCategoryDropdown', 'filterCategory', '', 'All Categories')">
                                                <span>All Categories</span>
                                                <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Desktop Table (SL header, Action on the right of Stock, Zero vertical borders, Unified container border) -->
                        <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                            <table id="printTable" class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                        <th class="p-[10px] text-center w-[40px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                        {{-- <th class="p-[10px] text-center w-[70px] whitespace-nowrap">Image</th> --}}
                                        <th class="p-[10px] text-start w-[110px] whitespace-nowrap">Barcode</th>
                                        <th class="p-[10px] text-start whitespace-nowrap">Name</th>
                                        <th class="p-[10px] text-start w-[130px] whitespace-nowrap">Category</th>
                                        <th class="p-[10px] text-center w-[85px] whitespace-nowrap">Quantity</th>
                                        <th class="p-[10px] text-end w-[95px] whitespace-nowrap">Cost Price</th>
                                        <th class="p-[10px] text-end w-[115px] whitespace-nowrap">Total Cost Price</th>
                                        <th class="p-[10px] text-end w-[95px] whitespace-nowrap">Selling Price</th>
                                        <th class="p-[10px] text-center w-[85px] whitespace-nowrap">Stock</th>
                                        <th class="p-[10px] text-center w-[75px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableList" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200"></tbody>
                                <tfoot class="bg-slate-50/90 dark:bg-slate-800/70 text-slate-800 dark:text-slate-100 font-bold border-t-2 border-emerald-600/30 dark:border-emerald-600/20 text-xs sm:text-sm">
                                    <tr>
                                        <td colspan="4" class="p-[10px] text-end font-bold text-slate-600 dark:text-slate-300">Total:</td>
                                        <td id="totalQuantity" class="p-[10px] text-center font-bold text-slate-900 dark:text-white">0</td>
                                        <td id="totalCostPrice" class="p-[10px] text-end font-bold text-slate-900 dark:text-white">0.00</td>
                                        <td id="totalCostQuantityPrice" class="p-[10px] text-end font-bold text-emerald-700 dark:text-emerald-400">0.00</td>
                                        <td id="totalSellingPrice" class="p-[10px] text-end font-bold text-slate-900 dark:text-white">0.00</td>
                                        <td class="p-[10px]"></td>
                                        <td class="p-[10px]"></td>
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

            <!-- 6. Sticky Bottom Copyright Section (Positioned right below card-body) -->
            <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)]">
                <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                    &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
                </footer>
            </div>

        </div>
    </div>
    <!-- Hero Main Content End -->

    <style>
        /* Card-body padding on all sides with generous breathing room */
        .product-card-body {
            padding: 10px !important; /* ~20px on mobile */
        }
       
        @media (min-width: 768px) {
            .product-card-body {
                padding: 16px !important; /* ~40px on desktop */
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

        /* Table headers strictly 1 line, no wrapping */
        #printTable thead th {
            white-space: nowrap !important;
        }

        /* Modern Pill Badges */
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

        .badge.available {
            background-color: #10b981 !important;
            color: #ffffff !important;
            box-shadow: 0 1px 2px rgba(16, 185, 129, 0.2);
        }

        .badge.out-of-stock {
            background-color: #ef4444 !important;
            color: #ffffff !important;
            box-shadow: 0 1px 2px rgba(239, 68, 68, 0.2);
        }

        /* + Add Product Button Fix: strict 38px height & keep white text on hover */
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

        /* Custom Searchable Select Dropdown Design (Matching Modal & School Theme) */
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
            min-width: 100%;
            width: max-content;
            max-width: 320px;
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
        .custom-filter-dropdown .search-wrap {
            padding: 4px 6px;
            border-bottom: 1px solid #f1f5f9;
            margin-bottom: 4px;
            position: relative;
            background: #ffffff !important;
        }
        .custom-filter-dropdown .select-options-list {
            max-height: 200px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }
        .custom-filter-dropdown .select-options-list::-webkit-scrollbar {
            width: 4px;
        }
        .custom-filter-dropdown .select-options-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
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

        /* Dark Mode: Full Dark Theme for Card, Page, and All Borders set to slate-800 (#334155) */
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

        /* Unified border color (#334155) across all fields, buttons, product images, barcode badges, and action buttons in Dark Mode */
        body[light-mode="dark"] #searchInput,
        body[light-mode="dark"] .search-input-wrapper,
        body[data-layout-mode="dark"] .search-input-wrapper,
        html.dark .search-input-wrapper,
        body.dark-mode .search-input-wrapper,
        body.dark .search-input-wrapper,
        body[light-mode="dark"] .entries-wrapper,
        body[light-mode="dark"] .custom-filter-dropdown .select-trigger,
        body[light-mode="dark"] .custom-filter-dropdown .select-menu,
        body[light-mode="dark"] .custom-filter-dropdown .search-wrap,
        body[light-mode="dark"] .custom-filter-dropdown .search-wrap input,
        body[light-mode="dark"] #copyBtn,
        body[light-mode="dark"] #csvBtn,
        body[light-mode="dark"] #pdfBtn,
        body[light-mode="dark"] #printBtn,
        body[light-mode="dark"] #xlsxBtn,
        body[light-mode="dark"] .product-mobile-card,
        body[light-mode="dark"] .copyright,
        body[light-mode="dark"] #printTable td img,
        body[data-layout-mode="dark"] #printTable td img,
        html.dark #printTable td img,
        body[light-mode="dark"] #tableList td img,
        body[data-layout-mode="dark"] #tableList td img,
        html.dark #tableList td img,
        body[light-mode="dark"] .product-mobile-card img,
        body[data-layout-mode="dark"] .product-mobile-card img,
        html.dark .product-mobile-card img,
        body[light-mode="dark"] .barcode-badge,
        body[data-layout-mode="dark"] .barcode-badge,
        html.dark .barcode-badge,
        body[light-mode="dark"] #printTable td .barcode-badge,
        body[data-layout-mode="dark"] #printTable td .barcode-badge,
        html.dark #printTable td .barcode-badge,
        body[light-mode="dark"] #tableList td .barcode-badge,
        body[data-layout-mode="dark"] #tableList td .barcode-badge,
        html.dark #tableList td .barcode-badge,
        body[light-mode="dark"] #printTable td .edit-link,
        body[data-layout-mode="dark"] #printTable td .edit-link,
        html.dark #printTable td .edit-link,
        body[light-mode="dark"] #tableList td .edit-link,
        body[data-layout-mode="dark"] #tableList td .edit-link,
        html.dark #tableList td .edit-link,
        body[light-mode="dark"] #printTable td .custom-delete-modal-btn,
        body[data-layout-mode="dark"] #printTable td .custom-delete-modal-btn,
        html.dark #printTable td .custom-delete-modal-btn,
        body[light-mode="dark"] #tableList td .custom-delete-modal-btn,
        body[data-layout-mode="dark"] #tableList td .custom-delete-modal-btn,
        html.dark #tableList td .custom-delete-modal-btn,
        body[light-mode="dark"] #printTable td .toggle-variant-btn,
        body[data-layout-mode="dark"] #printTable td .toggle-variant-btn,
        html.dark #printTable td .toggle-variant-btn,
        body[light-mode="dark"] #tableList td .toggle-variant-btn,
        body[data-layout-mode="dark"] #tableList td .toggle-variant-btn,
        html.dark #tableList td .toggle-variant-btn,
        body[light-mode="dark"] .product-mobile-card .edit-link,
        body[data-layout-mode="dark"] .product-mobile-card .edit-link,
        html.dark .product-mobile-card .edit-link,
        body[light-mode="dark"] #printTable td .badge,
        body[data-layout-mode="dark"] #printTable td .badge,
        html.dark #printTable td .badge,
        body[light-mode="dark"] #display-info span.border,
        body[data-layout-mode="dark"] #display-info span.border,
        html.dark #display-info span.border,
        body[light-mode="dark"] #display-info .rounded-md,
        body[data-layout-mode="dark"] #display-info .rounded-md,
        html.dark #display-info .rounded-md,
        body[light-mode="dark"] #display-info .display-info-box,
        body[data-layout-mode="dark"] #display-info .display-info-box,
        html.dark #display-info .display-info-box {
            border-color: #334155 !important;
        }

        /* Display info boxes dark mode background */
        body[light-mode="dark"] #display-info span.border,
        body[data-layout-mode="dark"] #display-info span.border,
        html.dark #display-info span.border,
        body[light-mode="dark"] #display-info .rounded-md,
        body[data-layout-mode="dark"] #display-info .rounded-md,
        html.dark #display-info .rounded-md,
        body[light-mode="dark"] #display-info .display-info-box,
        body[data-layout-mode="dark"] #display-info .display-info-box,
        html.dark #display-info .display-info-box {
            background-color: #1e293b !important;
        }

        /* Product image dark mode background */
        body[light-mode="dark"] #printTable td img,
        body[data-layout-mode="dark"] #printTable td img,
        html.dark #printTable td img,
        body[light-mode="dark"] #tableList td img,
        body[data-layout-mode="dark"] #tableList td img,
        html.dark #tableList td img,
        body[light-mode="dark"] .product-mobile-card img,
        body[data-layout-mode="dark"] .product-mobile-card img,
        html.dark .product-mobile-card img {
            background-color: #1e293b !important;
        }

        /* Barcode badge dark mode background & text color */
        body[light-mode="dark"] .barcode-badge,
        body[data-layout-mode="dark"] .barcode-badge,
        html.dark .barcode-badge,
        body[light-mode="dark"] #printTable td .barcode-badge,
        body[data-layout-mode="dark"] #printTable td .barcode-badge,
        html.dark #printTable td .barcode-badge,
        body[light-mode="dark"] #tableList td .barcode-badge,
        body[data-layout-mode="dark"] #tableList td .barcode-badge,
        html.dark #tableList td .barcode-badge {
            background-color: #1e293b !important;
            color: #34d399 !important;
        }

        /* Action buttons dark mode styling */
        body[light-mode="dark"] #printTable td .edit-link,
        body[data-layout-mode="dark"] #printTable td .edit-link,
        html.dark #printTable td .edit-link,
        body[light-mode="dark"] #tableList td .edit-link,
        body[data-layout-mode="dark"] #tableList td .edit-link,
        html.dark #tableList td .edit-link,
        body[light-mode="dark"] #printTable td .custom-delete-modal-btn,
        body[data-layout-mode="dark"] #printTable td .custom-delete-modal-btn,
        html.dark #printTable td .custom-delete-modal-btn,
        body[light-mode="dark"] #tableList td .custom-delete-modal-btn,
        body[data-layout-mode="dark"] #tableList td .custom-delete-modal-btn,
        html.dark #tableList td .custom-delete-modal-btn,
        body[light-mode="dark"] #printTable td .toggle-variant-btn,
        body[data-layout-mode="dark"] #printTable td .toggle-variant-btn,
        html.dark #printTable td .toggle-variant-btn,
        body[light-mode="dark"] #tableList td .toggle-variant-btn,
        body[data-layout-mode="dark"] #tableList td .toggle-variant-btn,
        html.dark #tableList td .toggle-variant-btn,
        body[light-mode="dark"] .product-mobile-card .edit-link,
        body[data-layout-mode="dark"] .product-mobile-card .edit-link,
        html.dark .product-mobile-card .edit-link,
        body[light-mode="dark"] .product-mobile-card .custom-delete-modal-btn,
        body[data-layout-mode="dark"] .product-mobile-card .custom-delete-modal-btn,
        html.dark .product-mobile-card .custom-delete-modal-btn {
            background-color: #1e293b !important;
        }

        body[light-mode="dark"] #printTable td .edit-link:hover,
        body[data-layout-mode="dark"] #printTable td .edit-link:hover,
        html.dark #printTable td .edit-link:hover,
        body[light-mode="dark"] #tableList td .edit-link:hover,
        body[data-layout-mode="dark"] #tableList td .edit-link:hover,
        html.dark #tableList td .edit-link:hover,
        body[light-mode="dark"] .product-mobile-card .edit-link:hover,
        body[data-layout-mode="dark"] .product-mobile-card .edit-link:hover,
        html.dark .product-mobile-card .edit-link:hover {
            background-color: #16a34a !important;
            border-color: #16a34a !important;
            color: #ffffff !important;
        }

        body[light-mode="dark"] #printTable td .custom-delete-modal-btn:hover,
        body[data-layout-mode="dark"] #printTable td .custom-delete-modal-btn:hover,
        html.dark #printTable td .custom-delete-modal-btn:hover,
        body[light-mode="dark"] #tableList td .custom-delete-modal-btn:hover,
        body[data-layout-mode="dark"] #tableList td .custom-delete-modal-btn:hover,
        html.dark #tableList td .custom-delete-modal-btn:hover,
        body[light-mode="dark"] .product-mobile-card .custom-delete-modal-btn:hover,
        body[data-layout-mode="dark"] .product-mobile-card .custom-delete-modal-btn:hover,
        html.dark .product-mobile-card .custom-delete-modal-btn:hover {
            background-color: #dc2626 !important;
            border-color: #dc2626 !important;
            color: #ffffff !important;
        }

        body[light-mode="dark"] #printTable td .toggle-variant-btn:hover,
        body[data-layout-mode="dark"] #printTable td .toggle-variant-btn:hover,
        html.dark #printTable td .toggle-variant-btn:hover,
        body[light-mode="dark"] #tableList td .toggle-variant-btn:hover,
        body[data-layout-mode="dark"] #tableList td .toggle-variant-btn:hover,
        html.dark #tableList td .toggle-variant-btn:hover {
            background-color: #334155 !important;
            border-color: #475569 !important;
            color: #ffffff !important;
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

        body[light-mode="dark"] .custom-filter-dropdown .select-trigger {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
        }
        body[light-mode="dark"] .custom-filter-dropdown .select-menu {
            background-color: #1e293b !important;
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.5) !important;
        }
        body[light-mode="dark"] .custom-filter-dropdown .search-wrap {
            background-color: #1e293b !important;
        }
        body[light-mode="dark"] .custom-filter-dropdown .search-wrap input {
            background-color: #0f172a !important;
            color: #f8fafc !important;
        }
        body[light-mode="dark"] .custom-filter-dropdown .select-option-item {
            background-color: #1e293b !important;
            color: #cbd5e1 !important;
            border-left-color: transparent !important;
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

        /* Mobile View Dark Mode: Unify ALL borders to #334155 (same as desktop) */
        body[light-mode="dark"] .product-mobile-card,
        body[data-layout-mode="dark"] .product-mobile-card,
        html.dark .product-mobile-card,
        body.dark-mode .product-mobile-card,
        body.dark .product-mobile-card {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }

        body[light-mode="dark"] .product-mobile-card *,
        body[data-layout-mode="dark"] .product-mobile-card *,
        html.dark .product-mobile-card *,
        body.dark-mode .product-mobile-card *,
        body.dark .product-mobile-card * {
            border-color: #334155 !important;
        }

        body[light-mode="dark"] .product-mobile-card .badge,
        body[data-layout-mode="dark"] .product-mobile-card .badge,
        html.dark .product-mobile-card .badge {
            border-color: #334155 !important;
        }

        body[light-mode="dark"] .product-mobile-card .grid,
        body[data-layout-mode="dark"] .product-mobile-card .grid,
        html.dark .product-mobile-card .grid {
            border-color: #334155 !important;
            background-color: #0f172a !important;
        }

        body[light-mode="dark"] .product-mobile-card .grid > div,
        body[data-layout-mode="dark"] .product-mobile-card .grid > div,
        html.dark .product-mobile-card .grid > div {
            border-color: #334155 !important;
        }

        body[light-mode="dark"] .product-mobile-card img,
        body[data-layout-mode="dark"] .product-mobile-card img,
        html.dark .product-mobile-card img {
            border-color: #334155 !important;
            background-color: #0f172a !important;
        }

        body[light-mode="dark"] .product-mobile-card .barcode-badge,
        body[data-layout-mode="dark"] .product-mobile-card .barcode-badge,
        html.dark .product-mobile-card .barcode-badge {
            border-color: #334155 !important;
            background-color: #0f172a !important;
            color: #34d399 !important;
        }

        body[light-mode="dark"] .product-mobile-card .edit-link,
        body[data-layout-mode="dark"] .product-mobile-card .edit-link,
        html.dark .product-mobile-card .edit-link,
        body[light-mode="dark"] .product-mobile-card .custom-delete-modal-btn,
        body[data-layout-mode="dark"] .product-mobile-card .custom-delete-modal-btn,
        html.dark .product-mobile-card .custom-delete-modal-btn {
            border-color: #334155 !important;
            background-color: #0f172a !important;
        }

        body[light-mode="dark"] .product-mobile-card .text-dark,
        body[light-mode="dark"] .product-mobile-card h6 {
            color: #f8fafc !important;
        }

        body[light-mode="dark"] .product-mobile-card .bg-light {
            background-color: #0f172a !important;
        }

        body[light-mode="dark"] .product-mobile-card .text-muted {
            color: #94a3b8 !important;
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

        /* Dark Mode Smart Pagination */
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

        /* Desktop Table TH & TD padding strictly 10px on all sides (10, 10) */
        #printTable th,
        #printTable td,
        #printTable thead th,
        #printTable tbody td,
        #printTable tfoot td {
            padding: 10px !important;
        }

        #printTable tr.variant-accordion-row > td {
            padding: 10px !important;
        }

        /* Mobile View: Reduced padding for page-content, card-body, and 1-line pagination */
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
        let currentPage = 1;
        let pageSize = 15;

        // Dynamic Bangladeshi Currency Formatter (e.g. 42,080.00, 28,87,396.00)
        function formatBdCurrency(amount) {
            let num = parseFloat(amount);
            if (isNaN(num)) return "0.00";
            return num.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
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
            getList();
            loadFilterBrands();
            loadFilterCategories();
            $("#searchInput").val("");
        });

        $(document).on('click', '.pos-theme-toggle-btn', function() {
            setTimeout(syncThemeClasses, 50);
        });

        // --- Event Listeners ---
        $("#searchInput").on("keyup search input", function() {
            currentPage = 1;
            renderPaginatedList();
        });

        $("#filterBrand, #filterCategory").on("change", function() {
            currentPage = 1;
            renderPaginatedList();
        });

        $("#entries").on("change", function() {
            pageSize = parseInt($(this).val()) || 15;
            currentPage = 1;
            renderPaginatedList();
        });

        // Custom List Filter Dropdown Handler functions
        function toggleCustomListFilter(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            if (!dropdown) return;
            const wasOpen = dropdown.classList.contains('is-open');
            closeAllCustomListFilters();
            if (!wasOpen) {
                dropdown.classList.add('is-open');
                const chevron = dropdown.querySelector('.chevron-icon');
                if (chevron) chevron.style.transform = 'rotate(180deg)';
                const input = dropdown.querySelector('.search-wrap input');
                if (input) {
                    input.value = '';
                    filterCustomListOptions(dropdownId, '');
                    setTimeout(() => input.focus(), 50);
                }
            }
        }

        function closeAllCustomListFilters() {
            document.querySelectorAll('.custom-filter-dropdown').forEach(d => {
                d.classList.remove('is-open');
                const chevron = d.querySelector('.chevron-icon');
                if (chevron) chevron.style.transform = 'rotate(0deg)';
            });
        }

        $(document).on('click', function(e) {
            if (!e.target.closest('.custom-filter-dropdown')) {
                closeAllCustomListFilters();
            }
        });

        function filterCustomListOptions(dropdownId, searchVal) {
            const dropdown = document.getElementById(dropdownId);
            if (!dropdown) return;
            const listEl = dropdown.querySelector('.select-options-list');
            if (!listEl) return;
            const items = listEl.querySelectorAll('.select-option-item');
            const query = (searchVal || '').trim().toLowerCase();
            let matchCount = 0;

            items.forEach(item => {
                const text = (item.getAttribute('data-label') || item.innerText || '').toLowerCase();
                if (!query || text.includes(query)) {
                    item.style.display = 'flex';
                    matchCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            let noResultEl = listEl.querySelector('.no-results-msg');
            if (matchCount === 0) {
                if (!noResultEl) {
                    noResultEl = document.createElement('div');
                    noResultEl.className = 'no-results-msg text-center py-2 text-slate-400 text-xs';
                    noResultEl.textContent = 'No options found';
                    listEl.appendChild(noResultEl);
                }
            } else if (noResultEl) {
                noResultEl.remove();
            }
        }

        function selectCustomFilterOption(dropdownId, nativeSelectId, val, label) {
            const dropdown = document.getElementById(dropdownId);
            const nativeSelect = document.getElementById(nativeSelectId);

            if (nativeSelect) {
                $(nativeSelect).val(val).trigger('change');
            }

            if (dropdown) {
                const triggerText = dropdown.querySelector('.selected-text');
                if (triggerText) {
                    triggerText.textContent = label;
                }

                dropdown.querySelectorAll('.select-option-item').forEach(item => {
                    if (item.getAttribute('data-value') === String(val)) {
                        item.classList.add('active');
                        if (!item.querySelector('.check-icon')) {
                            item.innerHTML = `<span>${item.getAttribute('data-label')}</span><svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
                        }
                    } else {
                        item.classList.remove('active');
                        const check = item.querySelector('.check-icon');
                        if (check) check.remove();
                    }
                });
            }

            closeAllCustomListFilters();
        }

        async function getList() {
            try {
                showLoader();
                let res = await axios.get("/api/product-list", HeaderToken());
                hideLoader();

                if (res.data.status !== 'success') {
                    console.error('Error fetching product data:', res.data.message);
                    return;
                }

                let productList = res.data.ProductData || [];
                productList.sort((a, b) => (parseInt(b.id) || 0) - (parseInt(a.id) || 0));
                window.allProductsList = productList;
                pageSize = parseInt($("#entries").val()) || 15;
                currentPage = 1;
                renderPaginatedList();

            } catch (e) {
                hideLoader();
                console.error('Error fetching product data:', e.message || e);
                unauthorized(e.response ? e.response.status : 500);
            }
        }

        function renderPaginatedList() {
            if (!window.allProductsList) return;

            let searchTerm = $("#searchInput").val().toLowerCase().trim();
            let selectedBrandId = $("#filterBrand").val();
            let selectedBrandText = $("#filterBrand option:selected").text().toLowerCase().trim();
            let selectedCatId = $("#filterCategory").val();
            let selectedCatText = $("#filterCategory option:selected").text().toLowerCase().trim();

            // 1. Filter products (Independent or Combined Filter)
            let filtered = window.allProductsList.filter(function(item) {
                let productName = (item.product_name || "").toLowerCase();
                let categoryName = (item.category ? item.category.category_name : "").toLowerCase();
                let brandName = (item.brand ? item.brand.name : "").toLowerCase();
                let doorSide = (item.door_side || "").toLowerCase();
                let codeStr = "";
                try {
                    let parsed = typeof item.product_code === 'string' ? JSON.parse(item.product_code) : item.product_code;
                    codeStr = Array.isArray(parsed) ? parsed.join(" ") : String(parsed);
                } catch (e) {
                    codeStr = String(item.product_code || "");
                }
                codeStr = codeStr.toLowerCase();

                let matchSearch = !searchTerm || productName.includes(searchTerm) || categoryName.includes(searchTerm) || brandName.includes(searchTerm) || doorSide.includes(searchTerm) || codeStr.includes(searchTerm);
                let matchBrand = !selectedBrandId || selectedBrandText === "all brands" || (item.brand && String(item.brand.id) === String(selectedBrandId)) || (String(item.brand_id) === String(selectedBrandId));
                let matchCat = !selectedCatId || selectedCatText === "all categories" || (item.category && String(item.category.id) === String(selectedCatId)) || (String(item.category_id) === String(selectedCatId));

                return matchSearch && matchBrand && matchCat;
            });

            // Ensure filtered items are sorted newest first
            filtered.sort((a, b) => (parseInt(b.id) || 0) - (parseInt(a.id) || 0));

            // Calculate Grand Totals for Filtered Items (exact sum of all underlying stock)
            let totalQuantity = 0;
            let totalCostPrice = 0;
            let totalSellingPrice = 0;
            let totalCostQuantityPrice = 0;

            filtered.forEach(function(item) {
                totalQuantity += parseInt(item.quantity) || 0;
                totalCostPrice += parseFloat(item.cost_price) || 0;
                totalSellingPrice += parseFloat(item.sell_price) || 0;
                totalCostQuantityPrice += (parseFloat(item.cost_price) * parseInt(item.quantity)) || 0;
            });

            $("#totalQuantity").text(totalQuantity.toFixed(0));
            $("#totalCostPrice").text(formatBdCurrency(totalCostPrice));
            $("#totalCostQuantityPrice").text(formatBdCurrency(totalCostQuantityPrice));
            $("#totalSellingPrice").text(formatBdCurrency(totalSellingPrice));

            // 2. Group products by (category_id, brand_id, product_name)
            let groupedMap = {};
            let groupedList = [];

            filtered.forEach(function(item) {
                let catId = item.category_id || (item.category ? item.category.id : 0);
                let brandId = item.brand_id || (item.brand ? item.brand.id : 0);
                let pName = (item.product_name || "").trim().toLowerCase();
                let key = `${catId}_${brandId}_${pName}`;
                let itemId = parseInt(item.id) || 0;

                if (!groupedMap[key]) {
                    groupedMap[key] = {
                        key: key,
                        maxId: itemId,
                        mainItem: item,
                        items: [],
                        totalQuantity: 0,
                        totalCostQuantityPrice: 0,
                        minCostPrice: parseFloat(item.cost_price) || 0,
                        maxCostPrice: parseFloat(item.cost_price) || 0,
                        minSellPrice: parseFloat(item.sell_price) || 0,
                        maxSellPrice: parseFloat(item.sell_price) || 0,
                        handednessCount: {
                            left: 0,
                            right: 0,
                            both: 0,
                            none: 0
                        }
                    };
                    groupedList.push(groupedMap[key]);
                } else {
                    if (itemId > groupedMap[key].maxId) {
                        groupedMap[key].maxId = itemId;
                        groupedMap[key].mainItem = item;
                    }
                }

                let g = groupedMap[key];
                g.items.push(item);
                let qty = parseInt(item.quantity) || 0;
                let cost = parseFloat(item.cost_price) || 0;
                let sell = parseFloat(item.sell_price) || 0;

                g.totalQuantity += qty;
                g.totalCostQuantityPrice += (cost * qty);
                if (cost < g.minCostPrice) g.minCostPrice = cost;
                if (cost > g.maxCostPrice) g.maxCostPrice = cost;
                if (sell < g.minSellPrice) g.minSellPrice = sell;
                if (sell > g.maxSellPrice) g.maxSellPrice = sell;

                // Track handedness counts
                let side = (item.door_side || "").toLowerCase();
                if (side.includes('left')) {
                    g.handednessCount.left += qty;
                } else if (side.includes('right')) {
                    g.handednessCount.right += qty;
                } else if (side.includes('both')) {
                    g.handednessCount.both += qty;
                } else {
                    g.handednessCount.none += qty;
                }
            });

            // Ensure groups with newest products are at the top of the table
            groupedList.sort((a, b) => (b.maxId || 0) - (a.maxId || 0));

            // 3. Pagination Calculations based on Grouped Rows
            let totalItems = groupedList.length;
            let totalPages = Math.ceil(totalItems / pageSize) || 1;
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;

            let startIndex = (currentPage - 1) * pageSize;
            let endIndex = Math.min(startIndex + pageSize, totalItems);
            let pageItems = groupedList.slice(startIndex, endIndex);

            let tableList = $("#tableList");
            let mobileCardList = $("#mobileCardList");

            tableList.empty();
            mobileCardList.empty();

            if (pageItems.length === 0) {
                tableList.html('<tr><td colspan="10" class="text-center text-rose-500 p-8 font-semibold"><svg class="w-6 h-6 mx-auto mb-2 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>কোনো পণ্য পাওয়া যায়নি।</td></tr>');
                mobileCardList.html('<div class="p-6 text-center text-rose-500 font-semibold bg-white dark:bg-slate-800 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm">কোনো পণ্য পাওয়া যায়নি।</div>');
            } else {
                pageItems.forEach(function(group, idx) {
                    let realIndex = startIndex + idx;
                    let item = group.mainItem;
                    let isMultiVariant = group.items.length > 1;
                    const img_url = item.img_url ? item.img_url : "{{ asset('backend/assets/img/product-img.svg') }}";
                    let stockStatusClass = group.totalQuantity > 0 ? "available" : "out-of-stock";
                    let stockStatusText = group.totalQuantity > 0 ? "Available" : "Out of Stock";
                    let categoryName = item.category ? item.category.category_name : '-';
                    let unitName = item.unit ? item.unit.unit_name : '';
                    let brandBadge = item.brand && item.brand.name ? `<div class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 flex items-center gap-1"><svg class="w-3 h-3 text-emerald-600 dark:text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg><span>${item.brand.name}</span></div>` : '';
                    let brandMobileBadge = item.brand && item.brand.name ? `<span class="badge bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-800" style="font-size: 10px;">${item.brand.name}</span>` : '';

                    // Barcode formatting: combine all barcodes for group
                    let allBarcodesHtml = '';
                    if (isMultiVariant) {
                        let combinedCodes = [];
                        group.items.forEach(sub => {
                            try {
                                let parsed = typeof sub.product_code === 'string' ? JSON.parse(sub.product_code) : sub.product_code;
                                if (Array.isArray(parsed)) combinedCodes.push(...parsed);
                                else if (parsed) combinedCodes.push(parsed);
                            } catch (e) {
                                if (sub.product_code) combinedCodes.push(sub.product_code);
                            }
                        });
                        combinedCodes = [...new Set(combinedCodes.filter(Boolean))];
                        allBarcodesHtml = combinedCodes.length > 0 ?
                            combinedCodes.slice(0, 3).map(c => `<span class="barcode-badge inline-flex items-center px-2 py-0.5 rounded-md font-mono text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-slate-800 dark:text-emerald-300 dark:border-slate-800 mr-1 mb-1">${c}</span>`).join('') + (combinedCodes.length > 3 ? `<span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300 border border-slate-300 dark:border-slate-800">+${combinedCodes.length - 3}</span>` : '') :
                            '<span class="text-slate-400 text-xs">N/A</span>';
                    } else {
                        allBarcodesHtml = formatProductCode(item.product_code);
                    }

                    // Handedness Breakdown UI
                    let handednessBreakdownHtml = '';
                    let hasHandedness = group.handednessCount.left > 0 || group.handednessCount.right > 0 || group.handednessCount.both > 0;

                    if (hasHandedness) {
                        handednessBreakdownHtml = `
                        <div class="flex flex-col items-center gap-1 mt-1">
                            ${group.handednessCount.left > 0 ? `<span class="badge bg-sky-50 text-sky-700 border border-sky-200 dark:bg-sky-950/40 dark:text-sky-300 dark:border-slate-800 px-2 py-0.5 font-semibold w-full text-start" style="font-size: 10px; border-radius: 6px;">👈 Left: <strong>${group.handednessCount.left}</strong></span>` : ''}
                            ${group.handednessCount.right > 0 ? `<span class="badge bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-950/40 dark:text-indigo-300 dark:border-slate-800 px-2 py-0.5 font-semibold w-full text-start" style="font-size: 10px; border-radius: 6px;">👉 Right: <strong>${group.handednessCount.right}</strong></span>` : ''}
                            ${group.handednessCount.both > 0 ? `<span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-slate-800 px-2 py-0.5 font-semibold w-full text-start" style="font-size: 10px; border-radius: 6px;">↔️ Both: <strong>${group.handednessCount.both}</strong></span>` : ''}
                            ${group.handednessCount.none > 0 && (group.handednessCount.left > 0 || group.handednessCount.right > 0 || group.handednessCount.both > 0) ? `<span class="badge bg-slate-100 text-slate-600 border border-slate-300 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-800 px-2 py-0.5 font-semibold w-full text-start" style="font-size: 10px; border-radius: 6px;">Std: <strong>${group.handednessCount.none}</strong></span>` : ''}
                        </div>`;
                    } else if (item.door_side) {
                        let doorIcon = item.door_side.toLowerCase().includes('left') ? '👈' : (item.door_side.toLowerCase().includes('right') ? '👉' : '↔️');
                        handednessBreakdownHtml = `<div class="mt-1"><span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-slate-800 px-2 py-0.5 font-semibold" style="font-size: 10px; border-radius: 6px;">${doorIcon} ${item.door_side}</span></div>`;
                    }

                    // Variant Tag in Name Column
                    let variantBadgeName = isMultiVariant ?
                        `<div class="mt-1"><span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-slate-800"><i class="fa-solid fa-layer-group me-1"></i>${group.items.length} Handedness Variants</span></div>` :
                        (item.door_side ? `<span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-slate-800 ms-1">${item.door_side}</span>` : '');

                    // Modern Action Icons (Sleek minimalist stroke SVG icons, placed on the right of Stock)
                    let actionHtml = '';
                    if (isMultiVariant) {
                        actionHtml = `
                            <div class="flex items-center justify-center gap-1.5">
                                <button type="button" class="w-[30px] h-[30px] rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-300 border border-slate-300 dark:border-slate-800 flex items-center justify-center transition-all duration-150 toggle-variant-btn shadow-sm" data-target="variant-row-${realIndex}" title="Show / Hide Handedness Variants (${group.items.length} items)">
                                    <svg class="w-3.5 h-3.5 chevron-icon transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>
                                <a data-id="${item.id}" href="#" class="link edit-link w-[30px] h-[30px] rounded-lg bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200/80 hover:border-emerald-600 dark:bg-emerald-950/40 dark:border-slate-800 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white flex items-center justify-center transition-all duration-150 shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Edit Main Variant">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg>
                                </a>
                            </div>
                        `;
                    } else {
                        actionHtml = `
                            <div id="action_btn_wrap" class="flex items-center justify-center gap-1.5">
                                <a data-id="${item.id}" href="#" class="link edit-link w-[30px] h-[30px] rounded-lg bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200/80 hover:border-emerald-600 dark:bg-emerald-950/40 dark:border-slate-800 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white flex items-center justify-center transition-all duration-150 shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Edit Product">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg>
                                </a>
                                <a href="#" data-id="${item.id}" class="link custom-delete-modal-btn w-[30px] h-[30px] rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200/80 hover:border-rose-600 dark:bg-rose-950/40 dark:border-slate-800 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white flex items-center justify-center transition-all duration-150 shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmationModal" title="Delete Product">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </a>
                            </div>
                        `;
                    }

                    let costDisplay = group.minCostPrice === group.maxCostPrice ?
                        formatBdCurrency(group.minCostPrice) :
                        `${formatBdCurrency(group.minCostPrice)} - ${formatBdCurrency(group.maxCostPrice)}`;

                    let sellDisplay = group.minSellPrice === group.maxSellPrice ?
                        formatBdCurrency(group.minSellPrice) :
                        `${formatBdCurrency(group.minSellPrice)} - ${formatBdCurrency(group.maxSellPrice)}`;

                    // Table Row: SL at start, Action at the very right of Stock, Zero right overflow on 100% desktop screens
                    let mainRow = `
                    <tr class="${isMultiVariant ? 'group-parent-row' : ''} hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors border-b border-slate-100 dark:border-slate-800">
                        <td class="p-[10px] text-center font-semibold text-slate-400 dark:text-slate-500">${realIndex + 1}</td>
                        <!-- <td class="p-[10px] text-center">
                            <img class="w-[44px] h-[44px] object-cover rounded-xl border border-slate-300 dark:border-slate-800 shadow-sm mx-auto" alt="${item.product_name}" src="${img_url}">
                        </td> -->
                        <td class="p-[10px] text-start">${allBarcodesHtml}</td>
                        <td class="p-[10px] text-start">
                            <div class="font-bold text-slate-800 dark:text-slate-100 text-sm leading-snug">${item.product_name} ${unitName ? `<span class="text-slate-400 dark:text-slate-500 font-normal text-xs">(${unitName})</span>` : ''}</div>
                            ${variantBadgeName}
                        </td>
                        <td class="p-[10px] text-start">
                            <span class="font-medium text-slate-700 dark:text-slate-200">${categoryName}</span>
                            ${brandBadge}
                        </td>
                        <td class="p-[10px] text-center">
                            <span class="font-bold text-slate-800 dark:text-slate-100 text-sm">${group.totalQuantity} ${unitName}</span>
                            ${handednessBreakdownHtml}
                        </td>
                        <td class="p-[10px] text-end font-medium text-slate-600 dark:text-slate-300 whitespace-nowrap">৳ ${costDisplay}</td>
                        <td class="p-[10px] text-end font-bold text-slate-900 dark:text-white whitespace-nowrap">৳ ${formatBdCurrency(group.totalCostQuantityPrice)}</td>
                        <td class="p-[10px] text-end font-semibold text-emerald-600 dark:text-emerald-400 whitespace-nowrap">৳ ${sellDisplay}</td>
                        <td class="p-[10px] text-center">
                            <span class="badge ${stockStatusClass}">
                                ${stockStatusText}
                            </span>
                        </td>
                        <td class="p-[10px] text-center">${actionHtml}</td>
                    </tr>`;

                    tableList.append(mainRow);

                    // Expandable Sub-table for Multi-variant items
                    if (isMultiVariant) {
                        let subRows = group.items.map(subItem => {
                            let subDoorSide = subItem.door_side || 'Standard';
                            let subDoorIcon = subDoorSide.toLowerCase().includes('left') ? '👈' : (subDoorSide.toLowerCase().includes('right') ? '👉' : (subDoorSide.toLowerCase().includes('both') ? '↔️' : '🚪'));
                            let subBadgeClass = subDoorSide.toLowerCase().includes('left') ? 'bg-sky-50 text-sky-700 border-sky-200 dark:bg-sky-950/40 dark:text-sky-300' : (subDoorSide.toLowerCase().includes('right') ? 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-950/40 dark:text-indigo-300' : 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300');
                            let subStockStatus = subItem.quantity > 0 ? 'available' : 'out-of-stock';
                            let subStockText = subItem.quantity > 0 ? 'Available' : 'Out of Stock';
                            let subCodes = formatProductCode(subItem.product_code);
                            let subTotalCost = formatBdCurrency(parseFloat(subItem.cost_price) * parseInt(subItem.quantity));

                            return `
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="px-3 py-2 text-start">
                                    <span class="badge ${subBadgeClass} border px-2 py-0.5 font-bold" style="font-size: 11px; border-radius: 6px;">
                                        ${subDoorIcon} ${subDoorSide}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-start">${subCodes}</td>
                                <td class="px-3 py-2 text-center font-bold text-slate-800 dark:text-slate-100">${subItem.quantity} ${unitName}</td>
                                <td class="px-3 py-2 text-end text-slate-600 dark:text-slate-300 whitespace-nowrap">৳ ${formatBdCurrency(subItem.cost_price)}</td>
                                <td class="px-3 py-2 text-end font-bold text-slate-900 dark:text-white whitespace-nowrap">৳ ${subTotalCost}</td>
                                <td class="px-3 py-2 text-end text-emerald-600 dark:text-emerald-400 font-semibold whitespace-nowrap">৳ ${formatBdCurrency(subItem.sell_price)}</td>
                                <td class="px-3 py-2 text-center">
                                    <span class="badge ${subStockStatus}" style="font-size: 10px;">${subStockText}</span>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <a data-id="${subItem.id}" href="#" class="link edit-link w-[26px] h-[26px] rounded-md bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200 dark:bg-emerald-950/40 dark:border-slate-800 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white flex items-center justify-center transition-all" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Edit this variant">
                                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                            </svg>
                                        </a>
                                        <a href="#" data-id="${subItem.id}" class="link custom-delete-modal-btn w-[26px] h-[26px] rounded-md bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200 dark:bg-rose-950/40 dark:border-slate-800 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white flex items-center justify-center transition-all" data-bs-toggle="modal" data-bs-target="#confirmationModal" title="Delete this variant">
                                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>`;
                        }).join('');

                        let accordionRow = `
                        <tr id="variant-row-${realIndex}" class="variant-accordion-row bg-slate-50/80 dark:bg-slate-900/60" style="display: none;">
                            <td colspan="10" class="p-4">
                                <div class="rounded-xl border border-emerald-200/80 dark:border-slate-800 shadow-sm p-4 bg-white dark:bg-slate-800/90">
                                    <div class="flex items-center justify-between mb-3 pb-3 border-b border-slate-100 dark:border-slate-800">
                                        <h6 class="font-bold text-slate-800 dark:text-slate-100 text-xs sm:text-sm flex items-center gap-2 mb-0">
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 20V6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14"></path><path d="M2 20h20"></path><path d="M14 12v.01"></path></svg>
                                            <span><strong>${item.product_name}</strong> - ডোর সাইড ও স্টক ভ্যারিয়েন্ট বিস্তারিত (${group.items.length} Handedness Items)</span>
                                        </h6>
                                        <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/50 dark:text-emerald-300 dark:border-slate-800 font-semibold text-xs px-2.5 py-1">মোট স্টক: ${group.totalQuantity} ${unitName}</span>
                                    </div>
                                    <div class="overflow-x-auto rounded-lg border border-slate-200/70 dark:border-slate-800">
                                        <table class="w-full text-left border-collapse text-xs">
                                            <thead class="bg-slate-50 dark:bg-slate-800/80 text-slate-500 dark:text-slate-400 font-semibold border-b border-slate-200/70 dark:border-slate-800">
                                                <tr>
                                                    <th class="px-3 py-2 text-start w-[150px]">ডোর সাইড (Handedness)</th>
                                                    <th class="px-3 py-2 text-start">বারকোড (Barcode)</th>
                                                    <th class="px-3 py-2 text-center w-[110px]">স্টক পরিমাণ</th>
                                                    <th class="px-3 py-2 text-end w-[110px]">ক্রয়মূল্য</th>
                                                    <th class="px-3 py-2 text-end w-[110px]">মোট ক্রয়</th>
                                                    <th class="px-3 py-2 text-end w-[110px]">বিক্রয়মূল্য</th>
                                                    <th class="px-3 py-2 text-center w-[90px]">স্ট্যাটাস</th>
                                                    <th class="px-3 py-2 text-center w-[80px]">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                                ${subRows}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>`;
                        tableList.append(accordionRow);
                    }

                    // Mobile Card View
                    let mobileVariantsHtml = '';
                    if (isMultiVariant) {
                        mobileVariantsHtml = `
                        <div class="border-t border-slate-100 dark:border-slate-800 pt-2.5 mt-2.5">
                            <button type="button" class="btn-outline-success w-full font-semibold flex items-center justify-between px-3 py-2 rounded-xl text-xs bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-slate-800 toggle-variant-btn" data-target="mobile-variant-card-${realIndex}">
                                <span><i class="fa-solid fa-layer-group me-1.5"></i> ভ্যারিয়েন্ট স্টক তালিকা (${group.items.length} টি)</span>
                                <svg class="w-3.5 h-3.5 chevron-icon transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </button>
                            <div id="mobile-variant-card-${realIndex}" class="mt-2.5 space-y-2" style="display: none;">
                                ${group.items.map(subItem => {
                                    let subDoorSide = subItem.door_side || 'Standard';
                                    let subDoorIcon = subDoorSide.toLowerCase().includes('left') ? '👈' : (subDoorSide.toLowerCase().includes('right') ? '👉' : (subDoorSide.toLowerCase().includes('both') ? '↔️' : '🚪'));
                                    let subBadgeClass = subDoorSide.toLowerCase().includes('left') ? 'bg-sky-50 text-sky-700 border-sky-200 dark:bg-sky-950/40 dark:text-sky-300' : (subDoorSide.toLowerCase().includes('right') ? 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-950/40 dark:text-indigo-300' : 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300');
                                    let subCodes = formatProductCode(subItem.product_code);
                                    return `
                                    <div class="border border-slate-300 dark:border-slate-800 rounded-xl p-2.5 bg-slate-50 dark:bg-slate-900/60">
                                        <div class="flex items-center justify-between mb-1.5">
                                            <span class="badge ${subBadgeClass} border font-bold" style="font-size: 11px;">${subDoorIcon} ${subDoorSide}</span>
                                            <div class="flex items-center gap-1.5">
                                                <a data-id="${subItem.id}" href="#" class="edit-link w-[28px] h-[28px] rounded-lg border border-slate-300 dark:border-slate-800 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:text-emerald-600 flex items-center justify-center" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Edit">
                                                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                                </a>
                                                <a href="#" data-id="${subItem.id}" class="custom-delete-modal-btn w-[28px] h-[28px] rounded-lg border border-slate-300 dark:border-slate-800 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:text-rose-600 flex items-center justify-center" data-bs-toggle="modal" data-bs-target="#confirmationModal" title="Delete">
                                                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">${subCodes}</div>
                                        <div class="flex justify-between text-xs font-bold text-slate-800 dark:text-slate-100">
                                            <span>স্টক: ${subItem.quantity} ${unitName}</span>
                                            <span>ক্রয়: ৳ ${formatBdCurrency(subItem.cost_price)}</span>
                                        </div>
                                    </div>
                                    `;
                                }).join('')}
                            </div>
                        </div>`;
                    }

                    let mobileCard = `
                    <div class="product-mobile-card card border border-slate-300 dark:border-slate-800 shadow-sm rounded-2xl p-3.5 bg-white dark:bg-slate-800/90 transition-all">
                        <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="badge bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold" style="font-size: 10px;">#${realIndex + 1}</span>
                                <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-slate-800 font-semibold" style="font-size: 10px;">
                                    <i class="fa-solid fa-folder me-1 text-emerald-600"></i>${categoryName}
                                </span>
                                ${brandMobileBadge}
                                ${isMultiVariant ? `<span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-slate-800 font-bold" style="font-size: 10px;"><i class="fa-solid fa-layer-group me-1"></i>${group.items.length} Variants</span>` : ''}
                            </div>
                            <div>
                                <span class="badge ${stockStatusClass} px-2.5 py-1 font-bold" style="font-size: 10px;">
                                    ${stockStatusText}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mb-2">
                            <img src="${img_url}" alt="${item.product_name}" class="w-[50px] h-[50px] object-cover rounded-xl border border-slate-300 dark:border-slate-800 flex-shrink-0 shadow-sm" />
                            <div class="overflow-hidden">
                                <h6 class="font-bold text-slate-800 dark:text-slate-100 mb-0.5 truncate text-sm leading-snug">${item.product_name} ${unitName ? `<span class="text-slate-400 font-normal text-xs">(${unitName})</span>` : ''}</h6>
                                <div class="flex items-center gap-1 flex-wrap">
                                    <span class="text-slate-400 text-[11px]">কোড:</span>
                                    ${allBarcodesHtml}
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 bg-slate-50 dark:bg-slate-900/50 p-2.5 rounded-xl my-2 text-center items-center border border-slate-100 dark:border-slate-800">
                            <div class="border-r border-slate-300 dark:border-slate-800">
                                <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">মোট পরিমাণ</span>
                                <span class="font-bold text-slate-800 dark:text-slate-100 text-xs">${group.totalQuantity} ${unitName}</span>
                            </div>
                            <div class="border-r border-slate-300 dark:border-slate-800">
                                <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">ক্রয়মূল্য</span>
                                <span class="font-bold text-rose-600 dark:text-rose-400 text-xs">৳ ${costDisplay}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">বিক্রয়মূল্য</span>
                                <span class="font-bold text-emerald-600 dark:text-emerald-400 text-xs">৳ ${sellDisplay}</span>
                            </div>
                        </div>

                        ${hasHandedness ? `
                        <div class="flex items-center gap-1.5 flex-wrap mb-2">
                            ${group.handednessCount.left > 0 ? `<span class="badge bg-sky-50 text-sky-700 border border-sky-200 dark:bg-sky-950/40 dark:text-sky-300 font-bold" style="font-size: 10px;">👈 Left: ${group.handednessCount.left}</span>` : ''}
                            ${group.handednessCount.right > 0 ? `<span class="badge bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-950/40 dark:text-indigo-300 font-bold" style="font-size: 10px;">👉 Right: ${group.handednessCount.right}</span>` : ''}
                            ${group.handednessCount.both > 0 ? `<span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 font-bold" style="font-size: 10px;">↔️ Both: ${group.handednessCount.both}</span>` : ''}
                        </div>` : ''}

                        <div class="flex items-center justify-between pt-2.5 mt-1 border-t border-slate-100 dark:border-slate-800">
                            <div class="text-slate-500 dark:text-slate-400 text-xs">
                                মোট ক্রয়: <span class="font-bold text-slate-800 dark:text-slate-100">৳ ${formatBdCurrency(group.totalCostQuantityPrice)}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <a data-id="${item.id}" href="#" class="edit-link w-[32px] h-[32px] rounded-xl bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200 dark:bg-emerald-950/40 dark:border-slate-800 dark:text-emerald-400 flex items-center justify-center transition-all shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Edit">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                </a>
                                ${!isMultiVariant ? `
                                <a href="#" data-id="${item.id}" class="custom-delete-modal-btn w-[32px] h-[32px] rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200 dark:bg-rose-950/40 dark:border-slate-800 dark:text-rose-400 flex items-center justify-center transition-all shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmationModal" title="Delete">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </a>
                                ` : ''}
                            </div>
                        </div>

                        ${mobileVariantsHtml}
                    </div>`;

                    mobileCardList.append(mobileCard);
                });
            }

            // Accordion toggle button listener
            $(document).off('click', '.toggle-variant-btn').on('click', '.toggle-variant-btn', function(e) {
                e.preventDefault();
                let targetId = $(this).data('target');
                let targetEl = $('#' + targetId);
                let chevron = $(this).find('.chevron-icon');

                if (targetEl.is(':visible')) {
                    targetEl.hide();
                    if (chevron.length) chevron.css('transform', 'rotate(0deg)');
                } else {
                    targetEl.show();
                    if (chevron.length) chevron.css('transform', 'rotate(180deg)');
                }
            });

            // Edit button listener
            $(document).off('click', '.edit-link').on('click', function(e) {
                let id = $(this).data('id') || $(this).attr('data-id');
                if (id && typeof FillUpUpdateForm === 'function') {
                    FillUpUpdateForm(id);
                }
            });

            // Delete button listener
            $(document).off('click', '.custom-delete-modal-btn').on('click', '.custom-delete-modal-btn', function() {
                let id = $(this).data('id');
                $("#deleteID").val(id);
                $("#confirmationModal").modal('show');
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
                    <span>products</span>
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
            renderPaginatedList();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        async function loadFilterBrands() {
            try {
                let res = await axios.get("/api/brand-list", HeaderToken());
                if (res.data && res.data.status === "success" && res.data.BrandData) {
                    let options = '<option value="">All Brands</option>';
                    let customOptionsHtml = `
                        <div class="select-option-item active" data-value="" data-label="All Brands" onclick="selectCustomFilterOption('filterBrandDropdown', 'filterBrand', '', 'All Brands')">
                            <span>All Brands</span>
                            <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                    `;
                    res.data.BrandData.forEach(brand => {
                        options += `<option value="${brand.id}">${brand.name}</option>`;
                        customOptionsHtml += `
                            <div class="select-option-item" data-value="${brand.id}" data-label="${brand.name}" onclick="selectCustomFilterOption('filterBrandDropdown', 'filterBrand', '${brand.id}', '${brand.name.replace(/'/g, "\\'")}')">
                                <span>${brand.name}</span>
                            </div>
                        `;
                    });
                    $("#filterBrand").html(options);
                    $("#filterBrandDropdown .select-options-list").html(customOptionsHtml);
                }
            } catch (e) {
                console.error("Filter brand loading failed", e);
            }
        }

        async function loadFilterCategories() {
            try {
                let res = await axios.get("/api/category-list", HeaderToken());
                if (res.data && res.data.status === "success" && res.data.CategoryData) {
                    let options = '<option value="">All Categories</option>';
                    let customOptionsHtml = `
                        <div class="select-option-item active" data-value="" data-label="All Categories" onclick="selectCustomFilterOption('filterCategoryDropdown', 'filterCategory', '', 'All Categories')">
                            <span>All Categories</span>
                            <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                    `;
                    res.data.CategoryData.forEach(cat => {
                        options += `<option value="${cat.id}">${cat.category_name}</option>`;
                        customOptionsHtml += `
                            <div class="select-option-item" data-value="${cat.id}" data-label="${cat.category_name}" onclick="selectCustomFilterOption('filterCategoryDropdown', 'filterCategory', '${cat.id}', '${cat.category_name.replace(/'/g, "\\'")}')">
                                <span>${cat.category_name}</span>
                            </div>
                        `;
                    });
                    $("#filterCategory").html(options);
                    $("#filterCategoryDropdown .select-options-list").html(customOptionsHtml);
                }
            } catch (e) {
                console.error("Filter category loading failed", e);
            }
        }

        function formatProductCode(productCode) {
            try {
                let parsed = typeof productCode === 'string' ? JSON.parse(productCode) : productCode;
                if (Array.isArray(parsed) && parsed.length > 0) {
                    return parsed.map(code => `<span class="barcode-badge inline-flex items-center px-2 py-0.5 rounded-md font-mono text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-slate-800 dark:text-emerald-300 dark:border-slate-800 mr-1 mb-1">${code}</span>`).join('');
                } else if (parsed) {
                    return `<span class="barcode-badge inline-flex items-center px-2 py-0.5 rounded-md font-mono text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-slate-800 dark:text-emerald-300 dark:border-slate-800 mr-1 mb-1">${parsed}</span>`;
                }
                return '<span class="text-slate-400 text-xs">N/A</span>';
            } catch (e) {
                return `<span class="barcode-badge inline-flex items-center px-2 py-0.5 rounded-md font-mono text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-slate-800 dark:text-emerald-300 dark:border-slate-800 mr-1 mb-1">${productCode || 'N/A'}</span>`;
            }
        }
    </script>