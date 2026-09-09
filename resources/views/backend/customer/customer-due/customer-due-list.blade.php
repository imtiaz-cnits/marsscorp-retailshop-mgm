    <!-- Hero Main Content Start -->
    <div class="main-content">
        <div class="page-content min-h-[calc(100vh-70px)] flex flex-col justify-between">
            <div class="data-table flex-grow">
                <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                    <div class="card-body product-card-body p-4 sm:p-6 md:p-10">
                        
                        <!-- 1. Top Section: Page Title -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                        <line x1="2" y1="10" x2="22" y2="10"></line>
                                    </svg>
                                </div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Customer Due List</h1>
                            </div>
                        </div>

                        <!-- 2. Controls & Filter Row: Search Bar + Show Entry -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-2.5 sm:gap-3 mb-4">
                            <div class="flex items-center gap-2 sm:gap-2.5 w-full md:w-auto">
                                <!-- Search Bar with icon -->
                                <div class="search-input-wrapper unified-ui-border flex-1 md:w-[280px] lg:w-[320px] h-[38px] flex items-center px-3 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                                    <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                    <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search Customer Due..." />
                                </div>

                                <!-- Entries Selector -->
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

                        <!-- 3. Desktop Table (SL header, Action on the far right, Unified container border) -->
                        <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                            <table id="printTable" class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                        <th class="p-[10px] text-center w-[40px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                        <th class="p-[10px] text-start w-[120px] whitespace-nowrap">Customer ID</th>
                                        <th class="p-[10px] text-start whitespace-nowrap">Customer Name</th>
                                        <th class="p-[10px] text-start w-[140px] whitespace-nowrap">Customer Mobile</th>
                                        <th class="p-[10px] text-end w-[130px] whitespace-nowrap">Previous Due Amount</th>
                                        <th class="p-[10px] text-end w-[130px] whitespace-nowrap">Order Due Amount</th>
                                        <th class="p-[10px] text-end w-[130px] whitespace-nowrap">Total Due Amount</th>
                                        <th class="p-[10px] text-center w-[75px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableList" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200"></tbody>
                                <tfoot class="bg-slate-50/90 dark:bg-slate-800/70 text-slate-800 dark:text-slate-100 font-bold border-t-2 border-emerald-600/30 dark:border-emerald-600/20 text-xs sm:text-sm">
                                    <tr>
                                        <td colspan="4" class="p-[10px] text-end font-bold text-slate-600 dark:text-slate-300">Total:</td>
                                        <td id="total_previous_due_amount" class="p-[10px] text-end font-bold text-slate-800 dark:text-slate-200 whitespace-nowrap">৳ 0.00</td>
                                        <td id="total_order_due_amount" class="p-[10px] text-end font-bold text-slate-800 dark:text-slate-200 whitespace-nowrap">৳ 0.00</td>
                                        <td id="total_total_due_amount" class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ 0.00</td>
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

            <!-- 6. Sticky Bottom Copyright Section -->
            <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)]">
                <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                    &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
                </footer>
            </div>

        </div>
    </div>
    <!-- Hero Main Content End -->

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
        #printTable tbody td,
        #printTable tfoot td {
            padding: 10px !important;
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

        body[light-mode="dark"] #searchInput,
        body[light-mode="dark"] .search-input-wrapper,
        body[data-layout-mode="dark"] .search-input-wrapper,
        html.dark .search-input-wrapper,
        body[light-mode="dark"] .entries-wrapper,
        body[light-mode="dark"] .copyright,
        body[light-mode="dark"] .due-mobile-card,
        body[data-layout-mode="dark"] .due-mobile-card,
        html.dark .due-mobile-card,
        body[light-mode="dark"] #printTable td .edit-link,
        body[data-layout-mode="dark"] #printTable td .edit-link,
        html.dark #printTable td .edit-link,
        body[light-mode="dark"] .due-mobile-card .edit-link,
        body[data-layout-mode="dark"] .due-mobile-card .edit-link,
        html.dark .due-mobile-card .edit-link,
        body[light-mode="dark"] #display-info .display-info-box {
            border-color: #334155 !important;
        }

        body[light-mode="dark"] #printTable td .edit-link,
        body[data-layout-mode="dark"] #printTable td .edit-link,
        html.dark #printTable td .edit-link,
        body[light-mode="dark"] .due-mobile-card .edit-link,
        body[data-layout-mode="dark"] .due-mobile-card .edit-link,
        html.dark .due-mobile-card .edit-link {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
        body[light-mode="dark"] #printTable td .edit-link:hover,
        body[data-layout-mode="dark"] #printTable td .edit-link:hover,
        html.dark #printTable td .edit-link:hover,
        body[light-mode="dark"] .due-mobile-card .edit-link:hover,
        body[data-layout-mode="dark"] .due-mobile-card .edit-link:hover,
        html.dark .due-mobile-card .edit-link:hover {
            background-color: #16a34a !important;
            border-color: #16a34a !important;
            color: #ffffff !important;
        }

        /* Smart Pagination */
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
            color: #f8fafc !important;
        }

        /* Mobile View Styles */
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
        let rawCustomerDueData = [];
        let currentPage = 1;
        let pageSize = 15;

        function formatBdCurrency(amount) {
            let num = parseFloat(amount);
            if (isNaN(num)) return "0.00";
            return num.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        $(document).ready(function () {
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
                const res = await axios.get("/api/customer-due-list", HeaderToken());
                hideLoader();

                if (res.data.status === "success" && Array.isArray(res.data.CustomerData)) {
                    rawCustomerDueData = res.data.CustomerData;
                    renderPaginatedList();
                } else {
                    console.error("Failed to fetch customer dues: No data found.");
                }
            } catch (error) {
                hideLoader();
                console.error("Error fetching Customer Due List:", error);
                unauthorized(error.response ? error.response.status : 500);
            }
        }

        function renderPaginatedList() {
            if (!rawCustomerDueData) return;

            let searchTerm = $("#searchInput").val().toLowerCase().trim();

            // 1. Filter Customer Dues
            let filtered = rawCustomerDueData.filter(function (item) {
                let customerId = (item.customer_id || "").toLowerCase();
                let name = (item.customer_name || "").toLowerCase();
                let mobile = (item.mobile || "").toLowerCase();

                return !searchTerm || customerId.includes(searchTerm) || name.includes(searchTerm) || mobile.includes(searchTerm);
            });

            // Ensure newly added records appear at the top
            filtered.sort((a, b) => (b.id || 0) - (a.id || 0));

            // 2. Calculate Totals
            let totalPreviousDue = 0;
            let totalOrderDue = 0;
            let totalTotalDue = 0;

            filtered.forEach(item => {
                totalPreviousDue += parseFloat(item.previous_due_amount) || 0;
                totalOrderDue += parseFloat(item.order_due_amount) || 0;
                totalTotalDue += parseFloat(item.total_due_amount) || 0;
            });

            $("#total_previous_due_amount").text(`৳ ${formatBdCurrency(totalPreviousDue)}`);
            $("#total_order_due_amount").text(`৳ ${formatBdCurrency(totalOrderDue)}`);
            $("#total_total_due_amount").text(`৳ ${formatBdCurrency(totalTotalDue)}`);

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
                tableList.html('<tr><td colspan="8" class="text-center text-rose-500 p-8 font-semibold"><svg class="w-6 h-6 mx-auto mb-2 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>No customer dues found.</td></tr>');
                mobileCardList.html('<div class="p-6 text-center text-rose-500 font-semibold bg-white dark:bg-slate-800 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm">No customer dues found.</div>');
            } else {
                pageItems.forEach(function (item, idx) {
                    let realIndex = startIndex + idx;
                    const previous_due = parseFloat(item.previous_due_amount) || 0;
                    const order_due = parseFloat(item.order_due_amount) || 0;
                    const total_due = parseFloat(item.total_due_amount) || 0;

                    // Modern Action Button on far right (Collect Due button)
                    let actionHtml = `
                        <div class="flex items-center justify-center gap-1.5">
                            <button data-id="${item.id}" type="button" class="edit-link w-[30px] h-[30px] rounded-lg bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200/80 hover:border-emerald-600 dark:bg-emerald-950/40 dark:border-slate-800 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white flex items-center justify-center transition-all duration-150 shadow-sm" title="Collect Due Payment">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </button>
                        </div>
                    `;

                    // Desktop Table Row
                    let row = `
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors border-b border-slate-100 dark:border-slate-800">
                            <td class="p-[10px] text-center font-semibold text-slate-400 dark:text-slate-500">${realIndex + 1}</td>
                            <td class="p-[10px] text-start whitespace-nowrap">
                                <span class="font-mono font-bold text-xs text-emerald-600 dark:text-emerald-400 inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    ${item.customer_id || 'N/A'}
                                </span>
                            </td>
                            <td class="p-[10px] text-start">
                                <span class="font-bold text-slate-800 dark:text-slate-100 text-sm leading-snug">${item.customer_name}</span>
                            </td>
                            <td class="p-[10px] text-start font-medium text-slate-600 dark:text-slate-300 whitespace-nowrap">${item.mobile || '-'}</td>
                            <td class="p-[10px] text-end font-medium text-slate-700 dark:text-slate-300 whitespace-nowrap">৳ ${formatBdCurrency(previous_due)}</td>
                            <td class="p-[10px] text-end font-medium text-slate-700 dark:text-slate-300 whitespace-nowrap">৳ ${formatBdCurrency(order_due)}</td>
                            <td class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ ${formatBdCurrency(total_due)}</td>
                            <td class="p-[10px] text-center">${actionHtml}</td>
                        </tr>`;
                    tableList.append(row);

                    // Mobile Card View
                    let mobileCard = `
                        <div class="due-mobile-card unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800/90 shadow-sm transition-all mb-3">
                            <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100 dark:border-slate-800">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="badge bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold" style="font-size: 10px;">#${realIndex + 1}</span>
                                    <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-slate-800 font-semibold" style="font-size: 10px;">
                                        <i class="fa-solid fa-user me-1 text-emerald-600"></i>${item.customer_id || 'N/A'}
                                    </span>
                                </div>
                                <span class="badge bg-rose-50 text-rose-600 border border-rose-200 dark:bg-rose-950/40 dark:text-rose-400 font-bold" style="font-size: 10px;">Due</span>
                            </div>

                            <div class="mb-2">
                                <h6 class="font-bold text-slate-800 dark:text-slate-100 mb-0.5 text-sm leading-snug">${item.customer_name}</h6>
                                <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                    <span>${item.mobile || 'No Mobile'}</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-2 bg-slate-50 dark:bg-slate-900/50 p-2.5 rounded-xl my-2 text-center items-center border border-slate-100 dark:border-slate-800">
                                <div class="border-r border-slate-300 dark:border-slate-800">
                                    <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">Prev Due</span>
                                    <span class="font-bold text-slate-700 dark:text-slate-300 text-xs">৳ ${formatBdCurrency(previous_due)}</span>
                                </div>
                                <div class="border-r border-slate-300 dark:border-slate-800">
                                    <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">Order Due</span>
                                    <span class="font-bold text-slate-700 dark:text-slate-300 text-xs">৳ ${formatBdCurrency(order_due)}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">Total Due</span>
                                    <span class="font-bold text-rose-600 dark:text-rose-400 text-xs">৳ ${formatBdCurrency(total_due)}</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-2.5 mt-1 border-t border-slate-100 dark:border-slate-800">
                                <span class="text-xs text-slate-500 dark:text-slate-400">Action:</span>
                                <button data-id="${item.id}" type="button" class="edit-link inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200 dark:bg-emerald-950/40 dark:border-slate-800 dark:text-emerald-400 font-semibold text-xs transition-all shadow-sm">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                    <span>Collect Due</span>
                                </button>
                            </div>
                        </div>`;
                    mobileCardList.append(mobileCard);
                });
            }

            // Bind click on collect due buttons
            $(document).off('click', '.edit-link').on('click', async function () {
                let id = $(this).data('id') || $(this).attr('data-id');
                if (typeof FillUpUpdateForm === 'function') {
                    await FillUpUpdateForm(id);
                }
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
                    <span>records</span>
                </div>
            `);

            renderPaginationControls(totalPages);
        }

        function renderPaginationControls(totalPages) {
            let pagContainer = $("#pagination");
            pagContainer.empty();

            if (totalPages <= 1) return;

            let prevDisabled = currentPage === 1 ? 'disabled' : '';
            let prevBtn = `<button type="button" class="custom-pagination-btn pagination-nav-btn ${prevDisabled}" ${currentPage === 1 ? 'disabled' : ''} onclick="goToPage(${currentPage - 1})">
                <svg class="w-3 h-3 me-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg> Prev
            </button>`;
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
    </script>
