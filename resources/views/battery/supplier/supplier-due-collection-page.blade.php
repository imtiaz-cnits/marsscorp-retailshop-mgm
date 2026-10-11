@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Supplier Due Collection History - MARSS CORPORATION')
@section('content')

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
                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Supplier Due Payment History</h1>
                                <small class="text-slate-500 dark:text-slate-400 text-xs">Record of payments disbursed towards battery supplier due settlements</small>
                            </div>
                        </div>

                        <!-- Top Right Controls -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('battery.supplier.due') }}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] min-h-[38px] max-h-[38px] bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-200 text-xs font-semibold rounded-xl border border-slate-300 dark:border-slate-700 transition-all shadow-sm">
                                <i class="fa-solid fa-arrow-left"></i>
                                <span>Back to Dues</span>
                            </a>
                        </div>
                    </div>

                    <!-- 2. Controls & Filter Row: Search on Left, Show Entries & Filter Dropdown on Right -->
                    <div class="controls-row-wrapper mb-4 w-full">
                        <!-- Search Bar -->
                        <div class="search-input-wrapper unified-ui-border h-[38px] flex items-center bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding-left: 4px !important; padding-right: 4px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Searching Payment History..." />
                        </div>

                        <!-- Secondary Controls Group (Show Entries + Filter Dropdown) -->
                        <div class="controls-filter-group">
                            <div class="entries-wrapper unified-ui-border flex items-center gap-1.5 bg-white dark:bg-slate-800/90 h-[38px] rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 shadow-sm transition-all hover:border-emerald-500">
                                <span class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider whitespace-nowrap">SHOW:</span>
                                <select id="entries" class="bg-transparent border-0 text-xs sm:text-sm font-bold text-emerald-700 dark:text-emerald-400 focus:outline-none cursor-pointer py-1 pr-1 text-end" style="cursor: pointer;">
                                    <option value="15" selected class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">15</option>
                                    <option value="25" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">25</option>
                                    <option value="50" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">50</option>
                                    <option value="100" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">100</option>
                                    <option value="200" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">200</option>
                                </select>
                            </div>

                            <!-- Filter Dropdown -->
                            <div class="filter-dropdown-container">
                                <div class="custom-searchable-select custom-filter-dropdown w-full" id="filterDropdownWrap">
                                    <div class="select-trigger unified-ui-border flex items-center justify-between px-3 sm:px-3.5 h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-sm text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-200 cursor-pointer hover:border-emerald-500 transition-all duration-150 w-full" style="padding-left: 14px !important; padding-right: 12px !important;" onclick="toggleDueFilterDropdown(event)">
                                        <div class="flex items-center gap-1.5 overflow-hidden">
                                            <svg class="w-3.5 h-3.5 text-slate-500 dark:text-slate-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                                            </svg>
                                            <span id="selectedFilterLabel" class="selected-text truncate font-semibold">All time</span>
                                        </div>
                                        <svg class="w-3.5 h-3.5 text-slate-400 chevron-icon transition-transform duration-200 flex-shrink-0 ms-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </div>
                                    <div class="select-menu shadow-xl w-full" style="min-width: 170px;">
                                        <div class="select-options-list">
                                            <div class="select-option-item active" data-filter="all" onclick="selectDueFilter(event, 'all', 'All time')">
                                                <span>All time</span>
                                                <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </div>
                                            <div class="select-option-item" data-filter="today" onclick="selectDueFilter(event, 'today', 'Today')">
                                                <span>Today</span>
                                            </div>
                                            <div class="select-option-item" data-filter="7" onclick="selectDueFilter(event, '7', 'Last 7 Days')">
                                                <span>Last 7 Days</span>
                                            </div>
                                            <div class="select-option-item" data-filter="30" onclick="selectDueFilter(event, '30', 'Last Month')">
                                                <span>Last Month</span>
                                            </div>
                                            <div class="select-option-item" data-filter="365" onclick="selectDueFilter(event, '365', 'Last Year')">
                                                <span>Last Year</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Desktop Table (SL rounded-tl-2xl, Status rounded-tr-2xl, solid emerald header, single line, 10px padding) -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900 mb-4">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Date</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Supplier ID</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Supplier Name</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Previous Due Amount</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Paid Amount</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Due Amount</th>
                                    <th class="p-[10px] text-center w-[120px] rounded-tr-2xl whitespace-nowrap">Payment Status</th>
                                </tr>
                            </thead>
                            <tbody id="tableList" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                                <tr>
                                    <td colspan="8" class="text-center py-6 text-slate-400">Loading payment history...</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="bg-slate-50/80 dark:bg-slate-800/80 font-bold text-sm border-t border-slate-200 dark:border-slate-800">
                                    <td colspan="4" class="p-[10px] text-end font-bold text-slate-700 dark:text-slate-200">Sub Total:</td>
                                    <td id="subTotalPayable" class="p-[10px] text-end font-bold text-slate-700 dark:text-slate-300 whitespace-nowrap">0.00 TK</td>
                                    <td id="subTotalPaid" class="p-[10px] text-end font-bold text-emerald-600 dark:text-emerald-400 whitespace-nowrap">0.00 TK</td>
                                    <td id="subTotalDue" class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">0.00 TK</td>
                                    <td class="p-[10px]"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- 4. Mobile Card List View -->
                    <div id="mobileCardList" class="block md:hidden mb-3 space-y-3"></div>

                    <!-- 5. Modern Smart Pagination and Display Info Footer -->
                    <div class="flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-800 gap-3">
                        <div id="display-info"></div>
                        <div id="pagination" class="flex items-center gap-1 sm:gap-1.5 flex-nowrap justify-center max-w-full overflow-x-auto pb-1"></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sticky Bottom Copyright Section -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)] mt-auto">
            <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>

    </div>
</div>
<!-- Hero Main Content End -->

<style>
    /* Full Height Layout & Sticky Copyright */
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

    /* Controls Row & Elements */
    .controls-row-wrapper {
        width: 100% !important;
        margin-bottom: 16px;
    }
    .search-input-wrapper {
        padding-left: 14px !important;
        padding-right: 14px !important;
    }
    .entries-wrapper {
        width: max-content !important;
        flex-shrink: 0 !important;
        padding-left: 12px !important;
        padding-right: 8px !important;
    }

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
        .filter-dropdown-container {
            width: 170px !important;
            flex: 0 0 auto !important;
        }
    }

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
            flex: 1 1 50% !important;
            width: 50% !important;
            justify-content: space-between !important;
            padding-left: 14px !important;
            padding-right: 10px !important;
        }
        .filter-dropdown-container {
            flex: 1 1 50% !important;
            width: 50% !important;
        }
    }

    /* Custom Filter Dropdown Styling */
    .custom-filter-dropdown {
        position: relative;
    }
    .custom-filter-dropdown .select-menu {
        display: none;
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        z-index: 9999;
        border-radius: 12px;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }
    .custom-filter-dropdown.open .select-menu {
        display: block !important;
    }
    .custom-filter-dropdown.open .chevron-icon {
        transform: rotate(180deg);
    }
    .select-options-list {
        padding: 4px;
        max-height: 250px;
        overflow-y: auto;
    }
    .select-option-item {
        padding: 8px 12px;
        font-size: 13px;
        font-weight: 500;
        color: #334155;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.15s ease;
    }
    .select-option-item:hover {
        background-color: #f1f5f9;
        color: #15803d;
    }
    .select-option-item.active {
        background-color: #f0fdf4;
        color: #15803d;
        font-weight: 700;
    }

    /* Unified UI Border Color */
    .unified-ui-border {
        border: 1.5px solid #cbd5e1 !important;
    }

    /* Search input wrapper focus ring */
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

    /* Table styling */
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
    #printTable tbody td {
        padding: 10px !important;
        vertical-align: middle !important;
        white-space: nowrap !important;
    }

    /* Light Mode Button Hover Protection */
    .btn-create-supplier:hover,
    .btn-save:hover,
    .submit:hover,
    #openModalBtns:hover,
    #action_btn_wrap a:hover {
        background-color: #166534 !important;
        color: #ffffff !important;
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

    /* Dark Mode Overrides */
    body[light-mode="dark"] .unified-ui-border { border-color: #334155 !important; }
    body[light-mode="dark"] #printTable thead th { background-color: #14532d !important; color: #ffffff !important; }
    body[light-mode="dark"] #printTable tbody tr:hover { background-color: rgba(30, 41, 59, 0.6) !important; }
    body[light-mode="dark"] .card,
    body[light-mode="dark"] .table-responsive { background-color: #0f172a !important; border-color: #1e293b !important; }
    body[light-mode="dark"] #printTable tbody tr,
    body[light-mode="dark"] #printTable tbody td { color: #f1f5f9 !important; border-color: #1e293b !important; }
    body[light-mode="dark"] #printTable tfoot tr { background-color: #1e293b !important; border-color: #334155 !important; }
    body[light-mode="dark"] .copyright { background-color: rgba(15, 23, 42, 0.95) !important; border-color: #1e293b !important; }
</style>

<script>
    let currentPage = 1;
    let pageSize = 15;
    let rawDueCollectionData = [];
    let currentFilter = 'all';

    function formatBdCurrency(amount) {
        let num = parseFloat(amount);
        if (isNaN(num)) return "0.00";
        return num.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function formatDate(dateString) {
        if (!dateString) return "—";
        const d = new Date(dateString);
        if (isNaN(d.getTime())) return dateString;
        const day = String(d.getDate()).padStart(2, '0');
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const year = d.getFullYear();
        return `${day}-${month}-${year}`;
    }

    $(document).ready(function() {
        $("#entries").val("15");
        getList();
    });

    // Close dropdown on outside click
    document.addEventListener("click", function(event) {
        const wrap = document.getElementById("filterDropdownWrap");
        if (wrap && !wrap.contains(event.target)) {
            wrap.classList.remove("open");
        }
    });

    function toggleDueFilterDropdown(event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        const wrap = document.getElementById("filterDropdownWrap");
        if (wrap) {
            wrap.classList.toggle("open");
        }
    }

    function selectDueFilter(event, filterKey, filterLabel) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        currentFilter = filterKey;
        $("#selectedFilterLabel").text(filterLabel);

        const wrap = document.getElementById("filterDropdownWrap");
        if (wrap) {
            wrap.querySelectorAll(".select-option-item").forEach(item => {
                item.classList.remove("active");
                const existingCheck = item.querySelector(".check-icon");
                if (existingCheck) existingCheck.remove();

                if (item.getAttribute("data-filter") === filterKey) {
                    item.classList.add("active");
                    const checkSvg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                    checkSvg.setAttribute("class", "w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 check-icon");
                    checkSvg.setAttribute("viewBox", "0 0 24 24");
                    checkSvg.setAttribute("fill", "none");
                    checkSvg.setAttribute("stroke", "currentColor");
                    checkSvg.setAttribute("stroke-width", "2.5");
                    checkSvg.setAttribute("stroke-linecap", "round");
                    checkSvg.setAttribute("stroke-linejoin", "round");
                    checkSvg.innerHTML = '<polyline points="20 6 9 17 4 12"></polyline>';
                    item.appendChild(checkSvg);
                }
            });
            wrap.classList.remove("open");
        }

        currentPage = 1;
        renderPaginatedList();
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

    async function getList() {
        try {
            if (typeof showLoader === 'function') showLoader();
            let res = await axios.get("/api/battery/supplier-due-collection-list", HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && Array.isArray(res.data['SupplierDueCollectionData'])) {
                rawDueCollectionData = res.data['SupplierDueCollectionData'];
                rawDueCollectionData.sort((a, b) => (parseInt(b.id) || 0) - (parseInt(a.id) || 0));
            } else {
                rawDueCollectionData = [];
            }

            currentPage = 1;
            renderPaginatedList();
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    function renderPaginatedList() {
        if (!rawDueCollectionData) return;

        let searchTerm = ($("#searchInput").val() || "").toLowerCase().trim();

        // 1. Filter Data
        let filtered = rawDueCollectionData.filter(function (item) {
            let supplierName = (item.supplier ? item.supplier.name : "").toLowerCase();
            let supplierID = (item.supplier ? item.supplier.supplier_id : "").toLowerCase();
            let paymentDate = item.payment_date || item.created_at || "";
            let dateFormatted = formatDate(paymentDate).toLowerCase();
            let method = (item.payment_method || "").toLowerCase();
            let trx = (item.transaction_id || "").toLowerCase();

            let dueAmount = parseFloat(item['due_amount']) || 0;
            let paidAmount = parseFloat(item['paid_amount']) || 0;
            let paymentStatus = (dueAmount === 0 && paidAmount > 0)
                ? 'fully paid'
                : (dueAmount > 0 && paidAmount > 0)
                    ? 'partial paid'
                    : 'unpaid';

            let matchesSearch = !searchTerm || supplierName.includes(searchTerm) || supplierID.includes(searchTerm) || dateFormatted.includes(searchTerm) || paymentStatus.includes(searchTerm) || method.includes(searchTerm) || trx.includes(searchTerm);
            if (!matchesSearch) return false;

            // Date filtering
            if (currentFilter === 'all') return true;

            const rowDate = new Date(paymentDate);
            if (isNaN(rowDate.getTime())) return true;

            const now = new Date();
            const startOfToday = new Date(now.getFullYear(), now.getMonth(), now.getDate());

            if (currentFilter === 'today') {
                return rowDate >= startOfToday;
            } else if (currentFilter === '7') {
                const past7 = new Date(startOfToday);
                past7.setDate(past7.getDate() - 7);
                return rowDate >= past7;
            } else if (currentFilter === '30') {
                const past30 = new Date(startOfToday);
                past30.setDate(past30.getDate() - 30);
                return rowDate >= past30;
            } else if (currentFilter === '365') {
                const past365 = new Date(startOfToday);
                past365.setDate(past365.getDate() - 365);
                return rowDate >= past365;
            }
            return true;
        });

        filtered.sort((a, b) => (parseInt(b.id) || 0) - (parseInt(a.id) || 0));

        // 2. Calculate Totals
        let totalPaid = 0;
        let totalDue = 0;
        let totalPayable = 0;
        filtered.forEach(item => {
            let p = parseFloat(item['paid_amount']) || 0;
            let d = parseFloat(item['due_amount']) || 0;
            totalPaid += p;
            totalDue += d;
            totalPayable += (p + d);
        });

        $("#subTotalPayable").text(`${formatBdCurrency(totalPayable)} TK`);
        $("#subTotalPaid").text(`${formatBdCurrency(totalPaid)} TK`);
        $("#subTotalDue").text(`${formatBdCurrency(totalDue)} TK`);

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
            tableList.html('<tr><td colspan="8" class="text-center text-rose-500 font-bold p-6">❌ No supplier due payment history found.</td></tr>');
            mobileCardList.html('<div class="p-6 text-center text-rose-500 font-bold bg-white dark:bg-slate-800 rounded-2xl unified-ui-border shadow-sm">❌ No supplier due payment history found.</div>');
        } else {
            pageItems.forEach(function (item, idx) {
                let realIndex = startIndex + idx;
                let dateDisplay = formatDate(item['payment_date'] || item['created_at']);
                let supplierID = item.supplier ? item.supplier.supplier_id : '—';
                let supplierName = item.supplier ? item.supplier.name : 'N/A';
                let supplierDbId = item.supplier ? item.supplier.id : (item.supplier_id || '#');
                let img_url = (item.supplier && item.supplier.img_url) ? item.supplier.img_url : "{{ asset('backend/assets/img/demo-img.jpeg') }}";

                let paidAmount = parseFloat(item['paid_amount']) || 0;
                let dueAmount = parseFloat(item['due_amount']) || 0;
                let prevDueAmount = paidAmount + dueAmount;

                let paymentStatus = (dueAmount === 0 && paidAmount > 0)
                    ? 'Fully Paid'
                    : (dueAmount > 0 && paidAmount > 0)
                        ? 'Partial Paid'
                        : 'Unpaid';

                let statusBadgeClass = paymentStatus === 'Fully Paid'
                    ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800/40'
                    : (paymentStatus === 'Partial Paid'
                        ? 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/40 dark:text-amber-400 dark:border-amber-800/40'
                        : 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/40 dark:text-rose-400 dark:border-rose-800/40');

                // Desktop Row
                let row = `
                    <tr data-row="${realIndex + 1}" class="hover:bg-slate-50/80 dark:hover:bg-slate-800/60 transition-colors">
                        <td class="p-[10px] text-center font-semibold text-slate-500 dark:text-slate-400 text-xs">${realIndex + 1}</td>
                        <td class="p-[10px] text-start whitespace-nowrap text-xs font-semibold text-slate-600 dark:text-slate-300">${dateDisplay}</td>
                        <td class="p-[10px] text-start whitespace-nowrap">
                            <a href="/battery/supplier/profile/${supplierDbId}" class="inline-flex items-center gap-1 font-semibold text-emerald-600 hover:text-emerald-700 hover:underline dark:text-emerald-400 dark:hover:text-emerald-300 text-xs whitespace-nowrap cursor-pointer" title="View Profile">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="3" width="15" height="13"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                </svg>
                                <span>${supplierID}</span>
                            </a>
                        </td>
                        <td class="p-[10px] text-start whitespace-nowrap font-bold text-slate-800 dark:text-slate-100">${supplierName}</td>
                        <td class="p-[10px] text-end font-semibold text-slate-700 dark:text-slate-300 whitespace-nowrap">৳ ${formatBdCurrency(prevDueAmount)}</td>
                        <td class="p-[10px] text-end font-bold text-emerald-600 dark:text-emerald-400 whitespace-nowrap">৳ ${formatBdCurrency(paidAmount)}</td>
                        <td class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ ${formatBdCurrency(dueAmount)}</td>
                        <td class="p-[10px] text-center w-[120px] whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold border ${statusBadgeClass}">
                                ${paymentStatus}
                            </span>
                        </td>
                    </tr>`;
                tableList.append(row);

                // Mobile Card View
                let mobileCard = `
                    <div class="supplier-mobile-card unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800/60 shadow-sm mb-3">
                        <div class="flex items-center justify-between pb-2 mb-2.5 border-b border-slate-100 dark:border-slate-700/60">
                            <div class="flex items-center gap-1.5">
                                <span class="px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[11px] font-bold">#${realIndex + 1}</span>
                                <span class="text-xs text-slate-500 font-mono">${dateDisplay}</span>
                            </div>
                            <div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold border ${statusBadgeClass}">
                                    ${paymentStatus}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mb-2.5">
                            <img src="${img_url}" class="rounded-full border border-slate-200 dark:border-slate-700 shadow-xs" style="width: 44px !important; height: 44px !important; object-fit: cover;" onerror="this.src='{{ asset('backend/assets/img/demo-img.jpeg') }}'">
                            <div class="overflow-hidden">
                                <h6 class="font-bold text-slate-800 dark:text-slate-100 text-sm truncate">${supplierName}</h6>
                                <a href="/battery/supplier/profile/${supplierDbId}" class="text-emerald-600 dark:text-emerald-400 text-xs font-semibold hover:underline">${supplierID}</a>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 my-2.5">
                            <div class="p-2 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/60">
                                <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 block">Paid Amount:</span>
                                <span class="font-bold text-xs text-emerald-600 dark:text-emerald-400">৳ ${formatBdCurrency(paidAmount)}</span>
                            </div>
                            <div class="p-2 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/60">
                                <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 block">Remaining Due:</span>
                                <span class="font-bold text-xs text-rose-600 dark:text-rose-400">৳ ${formatBdCurrency(dueAmount)}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2 mt-1 border-t border-slate-100 dark:border-slate-700/60 text-xs text-slate-500">
                            <span>Method: <strong class="text-slate-700 dark:text-slate-300">${item['payment_method'] || 'Cash'}</strong></span>
                            ${item['transaction_id'] ? `<span>Trx: <strong class="text-slate-700 dark:text-slate-300">${item['transaction_id']}</strong></span>` : ''}
                        </div>
                    </div>`;
                mobileCardList.append(mobileCard);
            });
        }

        // Display Info
        let fromCount = totalItems > 0 ? startIndex + 1 : 0;
        let toCount = endIndex;
        $("#display-info").html(`
            <div class="flex items-center gap-1.5 text-xs sm:text-sm font-medium text-slate-500 dark:text-slate-400">
                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                <span>Showing</span>
                <span class="font-bold text-slate-800 dark:text-slate-100 px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-800">${fromCount} – ${toCount}</span>
                <span>of</span>
                <span class="font-bold text-emerald-700 dark:text-emerald-400 px-1.5 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-slate-800">${totalItems}</span>
                <span>entries</span>
            </div>
        `);

        renderPaginationControls(totalPages);
    }

    function renderPaginationControls(totalPages) {
        let pagContainer = $("#pagination");
        pagContainer.empty();

        if (totalPages <= 1) return;

        let prevDisabled = currentPage === 1 ? 'disabled' : '';
        let prevBtn = `
            <button type="button" class="custom-pagination-btn ${prevDisabled}" ${currentPage === 1 ? 'disabled' : ''} onclick="goToPage(${currentPage - 1})">
                <svg class="w-3 h-3 me-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg> Prev
            </button>
        `;
        pagContainer.append(prevBtn);

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

@endsection
