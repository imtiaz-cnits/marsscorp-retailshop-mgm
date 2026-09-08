<!-- Hero Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-[calc(100vh-70px)] flex flex-col justify-between">
        <div class="data-table flex-grow">
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-10">

                    <!-- 1. Top Section: Page Title & Top Action Buttons -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="3" width="15" height="13"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Supplier List</h1>
                        </div>

                        <!-- Right Controls: + Create Supplier Button & Action Buttons with Unified Border -->
                        <div class="flex items-center flex-wrap gap-2">
                            <button id="openModalBtns" onclick="openSupplierCreateModal()" type="button" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Create Supplier</span>
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

                    <!-- 2. Controls & Filter Row: Desktop (Search big on left, Show Entries on right); Mobile (Row 1 Search, Row 2 Show Entries) -->
                    <div class="controls-row-wrapper mb-4 w-full">
                        <!-- Search Bar: Big on Left on Desktop, Full Width on Mobile -->
                        <div class="search-input-wrapper unified-ui-border h-[38px] flex items-center bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding-left: 4px !important; padding-right: 4px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search Supplier..." />
                        </div>

                        <!-- Secondary Controls Group (Show Entries) -->
                        <div class="controls-filter-group">
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
                        </div>
                    </div>

                    <!-- 3. Desktop Table (SL rounded-tl-2xl, Action rounded-tr-2xl, solid emerald header, single line, 10px padding) -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900 mb-4">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                    <th class="p-[10px] text-center w-[65px] whitespace-nowrap" style="width: 65px !important;">Image</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Supplier ID</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Name</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Company</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Payable Amount</th>
                                    <th class="p-[10px] text-center w-[100px] whitespace-nowrap">Status</th>
                                    <th class="p-[10px] text-center w-[90px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableList" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200"></tbody>
                            <tfoot>
                                <tr class="bg-slate-50/80 dark:bg-slate-800/80 font-bold text-sm border-t border-slate-200 dark:border-slate-800">
                                    <td colspan="5" class="p-[10px] text-end font-bold text-slate-700 dark:text-slate-200">Total Payable:</td>
                                    <td id="totalPayableaamountPrice" class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ 0.00</td>
                                    <td colspan="2" class="p-[10px]"></td>
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

    /* Controls Row & Elements: Desktop (Search big on left, Show Entries on right); Mobile (Row 1 Search, Row 2 Show Entries) */
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

    /* Desktop View: Big Search on Left, then Show Entry on Right */
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
    }

    /* Mobile View: Search Supplier and Show Entries side-by-side in 1 row */
    @media (max-width: 639px) {
        .controls-row-wrapper {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 8px !important;
        }
        .search-input-wrapper {
            flex: 1 1 auto !important;
            min-width: 0 !important;
            width: auto !important;
        }
        .controls-filter-group {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            flex: 0 0 auto !important;
            width: auto !important;
        }
        .entries-wrapper {
            flex: 0 0 auto !important;
            width: max-content !important;
            white-space: nowrap !important;
        }
    }

    /* Unified UI Border Color for Light Mode across all fields, buttons, and table */
    .unified-ui-border {
        border: 1.5px solid #cbd5e1 !important;
    }

    /* Supplier Profile Avatar for Mobile and Table Views */
    .supplier-profile-avatar {
        width: 44px !important;
        height: 44px !important;
        min-width: 44px !important;
        min-height: 44px !important;
        max-width: 44px !important;
        max-height: 44px !important;
        border-radius: 50% !important;
        object-fit: cover !important;
        display: block !important;
        flex-shrink: 0 !important;
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

    /* + Create Supplier Button Fix: strict 38px height & keep white text on hover */
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
        font-weight: 600;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        background-color: #15803d !important;
        color: #ffffff !important;
        border: none !important;
        padding: 10px !important;
    }

    /* Table cells strictly 10px padding & no wrapping */
    #printTable tbody td {
        padding: 10px !important;
        vertical-align: middle !important;
        white-space: nowrap !important;
    }

    /* Fixed 65px Width for Image Column (Column 2) */
    #printTable th:nth-child(2),
    #printTable td:nth-child(2) {
        width: 65px !important;
        min-width: 65px !important;
        max-width: 65px !important;
        text-align: center !important;
        padding-left: 4px !important;
        padding-right: 4px !important;
    }

    /* Dark Mode Overrides */
    body[light-mode="dark"] .unified-ui-border {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #printTable thead th {
        background-color: #14532d !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] #printTable tbody tr:hover {
        background-color: rgba(30, 41, 59, 0.6) !important;
    }
    body[light-mode="dark"] .card {
        background-color: #0f172a !important;
        border-color: #1e293b !important;
    }
    body[light-mode="dark"] .table-responsive {
        background-color: #0f172a !important;
        border-color: #1e293b !important;
    }
    body[light-mode="dark"] #printTable tbody tr {
        border-color: #1e293b !important;
    }
    body[light-mode="dark"] #printTable tbody td {
        color: #f1f5f9 !important;
        border-color: #1e293b !important;
    }
    body[light-mode="dark"] #printTable tfoot tr {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .copyright {
        background-color: rgba(15, 23, 42, 0.95) !important;
        border-color: #1e293b !important;
    }

    /* Pagination button styling */
    .custom-pagination-btn {
        height: 32px;
        min-width: 32px;
        padding: 0 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background-color: #ffffff;
        color: #334155;
        transition: all 0.15s ease-in-out;
        cursor: pointer;
    }
    .custom-pagination-btn:hover:not(.disabled):not(.active) {
        background-color: #f1f5f9;
        border-color: #94a3b8;
        color: #0f172a;
    }
    .custom-pagination-btn.active {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
        box-shadow: 0 2px 4px rgba(21, 128, 61, 0.25);
    }
    .custom-pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        background-color: #f8fafc;
        border-color: #e2e8f0;
        color: #94a3b8;
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
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] .custom-pagination-btn.disabled {
        background-color: #0f172a !important;
        border-color: #1e293b !important;
        color: #475569 !important;
    }
</style>

<script>
    let currentPage = 1;
    let pageSize = 15;
    let rawSupplierData = [];

    $(document).ready(function() {
        $("#entries").val("15");
        getList();
    });

    $("#searchInput").on("keyup search input", function () {
        currentPage = 1;
        renderPaginatedList();
    });

    $("#entries").on("change", function () {
        pageSize = parseInt($(this).val()) || 15;
        currentPage = 1;
        renderPaginatedList();
    });    // Dynamic Bangladeshi Currency Formatter (e.g. 42,080.00, 28,87,396.00)
    function formatBdCurrency(amount) {
        let num = parseFloat(amount);
        if (isNaN(num)) return "0.00";
        return num.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    // Function to fetch and display the supplier list
    async function getList() {
        try {
            showLoader();
            let res = await axios.get("/api/supplier-list", HeaderToken());
            hideLoader();

            if (Array.isArray(res.data['SupplierData'])) {
                rawSupplierData = res.data['SupplierData'];
                // Sort newest added data to the top
                rawSupplierData.sort((a, b) => (parseInt(b.id) || 0) - (parseInt(a.id) || 0));
            } else {
                rawSupplierData = [];
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
        if (!rawSupplierData) return;

        let searchTerm = $("#searchInput").val().toLowerCase().trim();

        // 1. Filter Suppliers
        let filtered = rawSupplierData.filter(function (item) {
            let supplierId = (item.supplier_id || "").toLowerCase();
            let name = (item.name || "").toLowerCase();
            let company = (item.company || "").toLowerCase();
            let status = (item.status || "").toLowerCase();

            return !searchTerm || supplierId.includes(searchTerm) || name.includes(searchTerm) || company.includes(searchTerm) || status.includes(searchTerm);
        });

        // Ensure newest on top
        filtered.sort((a, b) => (parseInt(b.id) || 0) - (parseInt(a.id) || 0));

        // 2. Calculate Totals
        let totalPayableAmount = 0;
        filtered.forEach(item => {
            totalPayableAmount += parseFloat(item['purchase_payable_amount']) || 0;
        });
        $("#totalPayableaamountPrice").text(`৳ ${formatBdCurrency(totalPayableAmount)}`);

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
            tableList.html('<tr><td colspan="8" class="text-center text-rose-500 font-bold p-6">❌ No suppliers found.</td></tr>');
            mobileCardList.html('<div class="p-6 text-center text-rose-500 font-bold bg-white dark:bg-slate-800 rounded-2xl unified-ui-border shadow-sm">❌ No suppliers found.</div>');
        } else {
            pageItems.forEach(function (item, idx) {
                let realIndex = startIndex + idx;
                const img_url = item['img_url'] ? item['img_url'] : "{{ asset('backend/assets/img/demo-img.jpeg') }}";
                let payableAmount = parseFloat(item['purchase_payable_amount']) || 0;

                let statusBadgeClass = item['status'] === 'Active' 
                    ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800/40' 
                    : 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/40 dark:text-rose-400 dark:border-rose-800/40';

                // Desktop Row (SL, Image, Supplier ID, Name, Company, Payable Amount, Status, Action)
                let row = `
                    <tr data-row="${realIndex + 1}" class="hover:bg-slate-50/80 dark:hover:bg-slate-800/60 transition-colors">
                        <td class="p-[10px] text-center font-semibold text-slate-500 dark:text-slate-400 text-xs">${realIndex + 1}</td>
                        <td class="p-[10px] text-center w-[65px]" style="width: 65px !important;">
                            <div class="flex justify-center">
                                <img style="width: 38px; height: 38px; object-fit: cover;" class="rounded-full border border-slate-200 dark:border-slate-700 shadow-xs" alt="${item['name']}" src="${img_url}" onerror="this.src='{{ asset('backend/assets/img/demo-img.jpeg') }}'">
                            </div>
                        </td>
                        <td class="p-[10px] text-start whitespace-nowrap">
                            <a href="/supplier/profile/${item['id']}" class="inline-flex items-center gap-1 font-semibold text-emerald-600 dark:text-emerald-400 hover:underline text-xs whitespace-nowrap">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="3" width="15" height="13"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                </svg>
                                <span>${item['supplier_id']}</span>
                            </a>
                        </td>
                        <td class="p-[10px] text-start whitespace-nowrap">
                            <a href="/supplier/profile/${item['id']}" class="font-bold text-slate-800 dark:text-slate-100 hover:text-emerald-600 transition-colors">${item['name']}</a>
                        </td>
                        <td class="p-[10px] text-start whitespace-nowrap text-slate-600 dark:text-slate-400 font-medium">${item['company'] || '-'}</td>
                        <td class="p-[10px] text-end font-bold ${payableAmount > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-700 dark:text-slate-300'} whitespace-nowrap">৳ ${formatBdCurrency(payableAmount)}</td>
                        <td class="p-[10px] text-center w-[100px] whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold border ${statusBadgeClass}">
                                ${item['status'] || 'Active'}
                            </span>
                        </td>
                        <td class="p-[10px] text-center">
                            <div id="action_btn_wrap" class="flex items-center justify-center gap-1.5">
                                <a data-id="${item['id']}" href="#" class="link edit-link w-[30px] h-[30px] rounded-lg bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200/80 hover:border-emerald-600 dark:bg-emerald-950/40 dark:border-slate-800 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white flex items-center justify-center transition-all duration-150 shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Edit">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg>
                                </a>
                                <a href="#" data-id="${item['id']}" class="link custom-delete-modal-btn w-[30px] h-[30px] rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200/80 hover:border-rose-600 dark:bg-rose-950/40 dark:border-slate-800 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white flex items-center justify-center transition-all duration-150 shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmationModal" title="Delete">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>`;
                tableList.append(row);

                // Mobile Card View
                let mobileCard = `
                    <div class="supplier-mobile-card unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800/60 shadow-sm mb-3">
                        <div class="flex items-center justify-between pb-2 mb-2.5 border-b border-slate-100 dark:border-slate-700/60">
                            <div class="flex items-center gap-1.5">
                                <span class="px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[11px] font-bold">#${realIndex + 1}</span>
                                <span class="px-2 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/40 text-emerald-700 dark:text-emerald-400 text-xs font-bold inline-flex items-center gap-1">
                                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="1" y="3" width="15" height="13"></rect>
                                        <polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon>
                                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                    </svg>
                                    ${item['supplier_id']}
                                </span>
                            </div>
                            <div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold border ${statusBadgeClass}">
                                    ${item['status'] || 'Active'}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mb-2.5">
                            <img src="${img_url}" class="supplier-profile-avatar border border-slate-200 dark:border-slate-700 shadow-xs" style="width: 44px !important; height: 44px !important; min-width: 44px !important; min-height: 44px !important; max-width: 44px !important; max-height: 44px !important; border-radius: 50% !important; object-fit: cover !important; display: block !important; flex-shrink: 0 !important;" onerror="this.src='{{ asset('backend/assets/img/demo-img.jpeg') }}'">
                            <div class="overflow-hidden">
                                <h6 class="font-bold text-slate-800 dark:text-slate-100 text-sm truncate">${item['name']}</h6>
                                <span class="text-slate-500 dark:text-slate-400 text-xs inline-flex items-center gap-1 truncate">
                                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M3 7v14M21 7v14M6 7V3h12v4M9 11h2M9 15h2M13 11h2M13 15h2"></path></svg>
                                    ${item['company'] || 'No Company'}
                                </span>
                            </div>
                        </div>

                        <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/60 my-2 flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Payable Due:</span>
                            <span class="font-bold text-sm ${payableAmount > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-800 dark:text-slate-100'}">৳ ${formatBdCurrency(payableAmount)}</span>
                        </div>

                        <div class="flex items-center justify-between pt-2.5 mt-1 border-t border-slate-100 dark:border-slate-700/60">
                            <a href="/supplier/profile/${item['id']}" class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:hover:bg-emerald-900/50 dark:text-emerald-400 text-xs font-semibold rounded-lg border border-emerald-200 dark:border-emerald-800/40 transition-colors">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                Profile
                            </a>
                            <div class="flex items-center gap-1.5">
                                <a data-id="${item['id']}" href="#" class="edit-link w-[30px] h-[30px] rounded-lg bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200/80 hover:border-emerald-600 dark:bg-emerald-950/40 dark:border-slate-800 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white flex items-center justify-center transition-all duration-150 shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Edit">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg>
                                </a>
                                <a href="#" data-id="${item['id']}" class="custom-delete-modal-btn w-[30px] h-[30px] rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200/80 hover:border-rose-600 dark:bg-rose-950/40 dark:border-slate-800 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white flex items-center justify-center transition-all duration-150 shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmationModal" title="Delete">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>`;
                mobileCardList.append(mobileCard);
            });
        }

        // Delete button listener
        $('.custom-delete-modal-btn').on('click', function() {
            let id = $(this).data('id');
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
                <span class="font-bold text-slate-800 dark:text-slate-100 px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-800">${fromCount} – ${toCount}</span>
                <span>of</span>
                <span class="font-bold text-emerald-700 dark:text-emerald-400 px-1.5 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-slate-800">${totalItems}</span>
                <span>suppliers</span>
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
</script>
