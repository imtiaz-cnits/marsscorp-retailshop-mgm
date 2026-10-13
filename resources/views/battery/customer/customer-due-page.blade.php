@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Customer Due List - MARSS CORPORATION')
@section('content')

<!-- Flatpickr Styles & Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-screen flex flex-col justify-between">
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
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0" id="pageTitleHeading">Customer Due List</h1>
                        </div>
                    </div>

                    <!-- Modern Tabs: 1. Customer Due List | 2. Due Collection List -->
                    <div class="mb-4">
                        <div class="cp-tab-nav">
                            <button type="button" class="cp-tab-btn active" id="tabBtnCustomerDue" onclick="switchCustomerDueTab('due-list')">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                    <line x1="2" y1="10" x2="22" y2="10"></line>
                                </svg>
                                <span>Customer Due List</span>
                                <span id="dueListCount" class="tab-count">0</span>
                            </button>

                            <button type="button" class="cp-tab-btn" id="tabBtnDueCollection" onclick="switchCustomerDueTab('collection-list')">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                <span>Due Collection List</span>
                                <span id="collectionListCount" class="tab-count">0</span>
                            </button>
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

                    {{-- ═════════════════════════════════════════════════════════
                         TAB PANE 1: CUSTOMER DUE LIST
                    ═════════════════════════════════════════════════════════ --}}
                    <div id="pane-due-list" class="tab-pane-content">
                        <!-- Desktop Table -->
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

                        <!-- Mobile Card List View -->
                        <div id="mobileCardList" class="block md:hidden mb-3 space-y-3"></div>
                    </div>

                    {{-- ═════════════════════════════════════════════════════════
                         TAB PANE 2: DUE COLLECTION LIST
                    ═════════════════════════════════════════════════════════ --}}
                    <div id="pane-collection-list" class="tab-pane-content" style="display: none;">
                        <!-- Desktop Table -->
                        <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                            <table id="collectionTable" class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                        <th class="p-[10px] text-center w-[40px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                        <th class="p-[10px] text-start w-[110px] whitespace-nowrap">Date</th>
                                        <th class="p-[10px] text-start w-[120px] whitespace-nowrap">Customer ID</th>
                                        <th class="p-[10px] text-start whitespace-nowrap">Customer Name</th>
                                        <th class="p-[10px] text-end w-[130px] whitespace-nowrap">Previous Due Amount</th>
                                        <th class="p-[10px] text-end w-[130px] whitespace-nowrap">Paid Amount</th>
                                        <th class="p-[10px] text-end w-[130px] whitespace-nowrap">Due Amount</th>
                                        <th class="p-[10px] text-center w-[110px] rounded-tr-2xl whitespace-nowrap">Payment Status</th>
                                    </tr>
                                </thead>
                                <tbody id="collectionTableList" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200"></tbody>
                                <tfoot class="bg-slate-50/90 dark:bg-slate-800/70 text-slate-800 dark:text-slate-100 font-bold border-t-2 border-emerald-600/30 dark:border-emerald-600/20 text-xs sm:text-sm">
                                    <tr>
                                        <td colspan="4" class="p-[10px] text-end font-bold text-slate-600 dark:text-slate-300">Sub Total:</td>
                                        <td id="subTotalPayable" class="p-[10px] text-end font-bold text-slate-800 dark:text-slate-200 whitespace-nowrap">0.00 TK</td>
                                        <td id="subTotalPaid" class="p-[10px] text-end font-bold text-emerald-700 dark:text-emerald-400 whitespace-nowrap">0.00 TK</td>
                                        <td id="subTotalDue" class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">0.00 TK</td>
                                        <td class="p-[10px]"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Mobile Card List View -->
                        <div id="collectionMobileCardList" class="block md:hidden mb-3 space-y-3"></div>
                    </div>

                    <!-- Modern Smart Pagination and Display Info Footer -->
                    <div class="flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-800 gap-3">
                        <div id="display-info"></div>
                        <div id="pagination" class="flex items-center gap-1 sm:gap-1.5 flex-nowrap justify-center max-w-full overflow-x-auto pb-1"></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sticky Bottom Copyright Section -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)]">
            <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>

    </div>
</div>
<!-- Main Content End -->

<!-- Action Button Due Collection Modal Start -->
<div class="modal fade" id="customerDueCollectModal" tabindex="-1" aria-labelledby="customerDueCollectModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-white dark:bg-slate-900 border-0 shadow-2xl overflow-hidden flex flex-col">

            <!-- Sticky Green Header -->
            <div class="modal-header-green flex-shrink-0 px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-white/20 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                            <circle cx="12" cy="12" r="2"></circle>
                            <path d="M6 12h.01M18 12h.01"></path>
                        </svg>
                    </div>
                    <h5 class="text-base font-bold text-white tracking-tight mb-0" id="customerDueCollectModalLabel">Collect Customer Due</h5>
                </div>

                <!-- Circular Red Close Button with White Icon -->
                <button type="button" class="qv-close-btn" data-bs-dismiss="modal" onclick="closeModal(document.getElementById('customerDueCollectModal'))" aria-label="Close">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form id="paymentForm" onsubmit="SavePaymentInfo(event)" class="flex flex-col flex-1 overflow-hidden m-0 p-0">
                <div class="modal-body px-4 pt-3 pb-2 space-y-3 text-start overflow-y-auto">

                    <!-- Hidden Reference Elements -->
                    <span id="MyTotalDueAmount" style="display: none;">৳ 0</span>
                    <span id="PreviousDueAmount" style="display: none;">৳ 0</span>
                    <span id="ShowDiscountAmount" style="display: none;">৳ 0</span>
                    <input type="hidden" id="updateID">
                    <input type="hidden" id="selectedPaymentMethod" value="cash">

                    <!-- Customer Info Box -->
                    <div class="cdc-info-box">
                        <!-- Customer Name + ID Row -->
                        <div class="flex items-center justify-between mb-2.5">
                            <div class="flex items-center gap-2">
                                <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400 inline-flex items-center justify-center text-xs flex-shrink-0">
                                    <i class="fa-solid fa-user-tie"></i>
                                </span>
                                <span class="font-bold text-slate-800 dark:text-slate-100 text-sm" id="modalCustomerName">Customer</span>
                            </div>
                            <span class="cp-badge cp-badge-id font-mono text-xs" id="modalCustomerId">ID</span>
                        </div>

                        <!-- Due Breakdown Table -->
                        <div class="cdc-due-table-wrap">
                            <table class="cdc-due-table w-full">
                                <thead>
                                    <tr>
                                        <th>Previous Due</th>
                                        <th>Invoice Due</th>
                                        <th class="text-end">Total Target Due</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="PreviousDue">৳ 0.00</td>
                                        <td id="OrderDue">৳ 0.00</td>
                                        <td class="text-end font-extrabold text-rose-600 dark:text-rose-400" id="TotalDue">৳ 0.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Due Grid (hidden on desktop) -->
                        <div class="cdc-due-mobile-grid">
                            <div class="cdc-due-mobile-cell">
                                <span class="cdc-due-label">Prev Due</span>
                                <span class="cdc-due-val" id="mobilePreviousDue">৳ 0.00</span>
                            </div>
                            <div class="cdc-due-mobile-cell">
                                <span class="cdc-due-label">Invoice Due</span>
                                <span class="cdc-due-val" id="mobileOrderDue">৳ 0.00</span>
                            </div>
                            <div class="cdc-due-mobile-cell cdc-due-mobile-total">
                                <span class="cdc-due-label text-rose-600">Total Due</span>
                                <span class="cdc-due-val text-rose-600 dark:text-rose-400" id="mobileTotalDue">৳ 0.00</span>
                            </div>
                        </div>

                        <!-- Remaining Due + Status Pill -->
                        <div class="cdc-remaining-row mt-2.5 pt-2.5 border-t border-emerald-200/70 dark:border-slate-700/60 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-300">
                                Remaining Due:&nbsp;<strong id="ShowtotalDuePayable" class="text-emerald-700 dark:text-emerald-400 font-extrabold text-sm">৳ 0.00</strong>
                            </span>
                            <span id="ShowpaymentStatusDisplay" class="badge px-3 py-1 font-bold text-xs bg-amber-500 text-white rounded-full">Pending</span>
                        </div>
                    </div>

                    <!-- Row 1: Collected Amount + Discount (2 Columns) -->
                    <div class="row g-2.5 mb-2 text-start">
                        <div class="col-6 text-start">
                            <label class="cdc-label" for="UpdateDueAmountclear">
                                Collected Amount (৳) <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" step="any" id="UpdateDueAmountclear" oninput="calculateDuePayment()" placeholder="0.00" class="cp-modal-input font-bold text-emerald-700 dark:text-emerald-400" required style="width: 100% !important;" />
                        </div>
                        <div class="col-6 text-start">
                            <label class="cdc-label" for="UpdateDiscountAmountclear">
                                Discount / Waiver (৳)
                            </label>
                            <input type="number" step="any" value="0" id="UpdateDiscountAmountclear" oninput="calculateDuePayment()" placeholder="0.00" class="cp-modal-input" style="width: 100% !important;" />
                        </div>
                    </div>

                    <!-- Row 2: Payment Method + Collection Date (2 Columns) -->
                    <div class="row g-2.5 mb-2 text-start">
                        <div class="col-6 text-start">
                            <label class="cdc-label">Payment Method</label>
                            <div class="custom-modal-dropdown relative" id="modalPaymentDropdown">
                                <div class="select-trigger unified-ui-border flex items-center justify-between px-3 h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-xs text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200 cursor-pointer hover:border-emerald-500 transition-all" onclick="toggleDuePaymentDropdown()">
                                    <span class="selected-text flex items-center gap-2" id="selectedPaymentText">
                                        <i class="fa-solid fa-money-bill text-emerald-600"></i> Cash
                                    </span>
                                    <svg class="w-3.5 h-3.5 text-slate-400 chevron-icon transition-transform duration-200 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </div>
                                <div class="select-menu shadow-2xl" style="display: none; z-index: 999999 !important;">
                                    <div class="select-option-item active" data-value="cash" onclick="selectDuePaymentOption('cash', '<i class=\'fa-solid fa-money-bill text-emerald-600\'></i> Cash')">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-money-bill text-emerald-600"></i> Cash</span>
                                    </div>
                                    <div class="select-option-item" data-value="bkash" onclick="selectDuePaymentOption('bkash', '<i class=\'fa-solid fa-mobile-screen text-pink-600\'></i> bKash')">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-mobile-screen text-pink-600"></i> bKash</span>
                                    </div>
                                    <div class="select-option-item" data-value="nagad" onclick="selectDuePaymentOption('nagad', '<i class=\'fa-solid fa-wallet text-orange-600\'></i> Nagad')">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-wallet text-orange-600"></i> Nagad</span>
                                    </div>
                                    <div class="select-option-item" data-value="rocket" onclick="selectDuePaymentOption('rocket', '<i class=\'fa-solid fa-bolt text-purple-600\'></i> Rocket')">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-bolt text-purple-600"></i> Rocket</span>
                                    </div>
                                    <div class="select-option-item" data-value="bank" onclick="selectDuePaymentOption('bank', '<i class=\'fa-solid fa-building-columns text-blue-600\'></i> Bank Transfer')">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-building-columns text-blue-600"></i> Bank Transfer</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 text-start">
                            <label class="cdc-label" for="DueCollectionDate">Collection Date</label>
                            <input type="text" id="DueCollectionDate" placeholder="YYYY-MM-DD" class="cp-modal-input cursor-pointer" style="width: 100% !important;" />
                        </div>
                    </div>

                    <!-- Row 3: Transaction ID / Note (Full Width) -->
                    <div class="mb-1 text-start">
                        <label class="cdc-label" for="transactionInput">Transaction ID / Note</label>
                        <input type="text" id="transactionInput" placeholder="e.g. TrxID / Receipt No" class="cp-modal-input" style="width: 100% !important;" />
                    </div>

                </div>

                <!-- Sticky Footer: Cancel + Submit -->
                <div class="modal-footer-sticky flex-shrink-0">
                    <button type="button" class="cp-btn-cancel" data-bs-dismiss="modal" onclick="closeModal(document.getElementById('customerDueCollectModal'))">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        <span>Cancel</span>
                    </button>
                    <button type="submit" class="cp-btn-primary">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Submit Collection</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Action Button Due Collection Modal End -->

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

    #printTable thead th, #collectionTable thead th {
        white-space: nowrap !important;
        padding: 10px !important;
    }
    #printTable tbody td, #printTable tfoot td,
    #collectionTable tbody td, #collectionTable tfoot td {
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

    /* Tabs Styling */
    .cp-tab-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        overflow-x: auto;
        flex-wrap: nowrap;
        white-space: nowrap;
        padding-bottom: 6px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .cp-tab-nav::-webkit-scrollbar {
        display: none;
    }
    .cp-tab-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        background-color: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #475569;
        cursor: pointer;
        white-space: nowrap;
        flex-shrink: 0;
        transition: all 0.18s ease-in-out;
    }
    .cp-tab-btn:hover {
        border-color: #16a34a !important;
        color: #15803d !important;
        background-color: #f0fdf4 !important;
    }
    .cp-tab-btn.active {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(21, 128, 61, 0.3) !important;
    }
    .cp-tab-btn .tab-count {
        font-size: 11px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 9999px;
        background-color: #e2e8f0;
        color: #334155;
        transition: all 0.18s ease-in-out;
    }
    .cp-tab-btn.active .tab-count {
        background-color: rgba(255, 255, 255, 0.25) !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] .cp-tab-btn,
    html.dark .cp-tab-btn,
    body.dark .cp-tab-btn {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }
    body[light-mode="dark"] .cp-tab-btn:hover,
    html.dark .cp-tab-btn:hover,
    body.dark .cp-tab-btn:hover {
        background-color: #0f2d1f !important;
        border-color: #16a34a !important;
        color: #4ade80 !important;
    }
    body[light-mode="dark"] .cp-tab-btn.active,
    html.dark .cp-tab-btn.active,
    body.dark .cp-tab-btn.active {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] .cp-tab-btn .tab-count,
    html.dark .cp-tab-btn .tab-count,
    body.dark .cp-tab-btn .tab-count {
        background-color: #334155;
        color: #cbd5e1;
    }

    /* Action Buttons Hover - strictly never turns white in light mode */
    .edit-link {
        width: 30px !important;
        height: 30px !important;
        border-radius: 8px !important;
        background-color: #ecfdf5 !important;
        color: #15803d !important;
        border: 1px solid #a7f3d0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.15s ease-in-out !important;
    }
    .edit-link:hover {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }
    .edit-link:hover i,
    .edit-link:hover svg {
        color: #ffffff !important;
        stroke: #ffffff !important;
    }

    /* Modal Centering & Styling */
    .modal {
        background: rgba(15, 23, 42, 0.6) !important;
        backdrop-filter: blur(4px) !important;
        -webkit-backdrop-filter: blur(4px) !important;
        z-index: 1060 !important;
    }
    .modal.show {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    .modal .modal-dialog,
    #customerDueCollectModal .modal-dialog {
        position: static !important;
        top: auto !important;
        left: auto !important;
        right: auto !important;
        bottom: auto !important;
        transform: none !important;
        margin: auto !important;
        max-width: 540px !important;
        width: 95% !important;
        background: transparent !important;
        background-color: transparent !important;
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
        min-width: auto !important;
        height: auto !important;
        max-height: none !important;
        overflow: visible !important;
    }
    .modal .modal-dialog form,
    #customerDueCollectModal .modal-dialog form {
        background: transparent !important;
        padding: 0 !important;
        margin: 0 !important;
        max-height: none !important;
        overflow: visible !important;
    }
    #customerDueCollectModal .modal-content {
        width: 100% !important;
        max-height: 88vh !important;
        margin: 0 !important;
        border-radius: 18px !important;
        border: none !important;
        display: flex !important;
        flex-direction: column !important;
        overflow: hidden !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        background: #ffffff !important;
    }
    body[light-mode="dark"] #customerDueCollectModal .modal-content,
    html.dark #customerDueCollectModal .modal-content {
        background: #0f172a !important;
        border: 1px solid #334155 !important;
    }
    #customerDueCollectModal .modal-body {
        flex: 1 1 auto !important;
        max-height: calc(88vh - 125px) !important;
        overflow-y: auto !important;
        overscroll-behavior: contain !important;
        padding: 14px 18px !important;
    }

    .modal-header-green {
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%) !important;
        color: #ffffff !important;
        border: none !important;
        padding: 12px 16px !important;
    }

    .qv-close-btn {
        width: 32px !important;
        height: 32px !important;
        border-radius: 50% !important;
        background-color: #dc2626 !important;
        border: none !important;
        color: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 !important;
        cursor: pointer !important;
        transition: all 0.15s ease-in-out !important;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.25) !important;
    }
    .qv-close-btn:hover { background-color: #b91c1c !important; transform: scale(1.08); }
    .qv-close-btn svg { width: 14px !important; height: 14px !important; stroke: #ffffff !important; display: block !important; }

    .cdc-info-box {
        background: #f0fdf4;
        border: 1.5px solid #bbf7d0;
        border-radius: 14px;
        padding: 12px 14px;
    }
    html.dark .cdc-info-box,
    body.dark .cdc-info-box,
    body[data-layout-mode="dark"] .cdc-info-box {
        background: #1e293b !important;
        border-color: #334155 !important;
    }

    .cdc-due-table-wrap {
        border-radius: 10px;
        overflow: hidden;
        border: 1.5px solid #bbf7d0;
        background: #ffffff;
    }
    html.dark .cdc-due-table-wrap,
    body.dark .cdc-due-table-wrap,
    body[data-layout-mode="dark"] .cdc-due-table-wrap {
        background: #0f172a !important;
        border-color: #334155 !important;
    }
    .cdc-due-table { width: 100%; border-collapse: collapse; text-align: left; }
    .cdc-due-table thead tr { background: #f1f5f9; border-bottom: 1px solid #e2e8f0; }
    html.dark .cdc-due-table thead tr,
    body.dark .cdc-due-table thead tr,
    body[data-layout-mode="dark"] .cdc-due-table thead tr {
        background: #1e293b !important;
        border-bottom-color: #334155 !important;
    }
    .cdc-due-table th {
        padding: 9px 14px;
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #475569;
        white-space: nowrap;
    }
    html.dark .cdc-due-table th,
    body.dark .cdc-due-table th,
    body[data-layout-mode="dark"] .cdc-due-table th { color: #94a3b8 !important; }
    .cdc-due-table td {
        padding: 10px 14px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
    }
    html.dark .cdc-due-table td,
    body.dark .cdc-due-table td,
    body[data-layout-mode="dark"] .cdc-due-table td { color: #e2e8f0 !important; }

    .cdc-due-mobile-grid { display: none; }
    @media (max-width: 480px) {
        .cdc-due-table-wrap { display: none; }
        .cdc-due-mobile-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
            margin-top: 10px;
        }
    }
    .cdc-due-mobile-cell {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 6px;
        text-align: center;
    }
    html.dark .cdc-due-mobile-cell,
    body.dark .cdc-due-mobile-cell,
    body[data-layout-mode="dark"] .cdc-due-mobile-cell { background: #1e293b !important; border-color: #334155 !important; }
    .cdc-due-mobile-total { background: #fff1f2 !important; border-color: #fecdd3 !important; }
    html.dark .cdc-due-mobile-total,
    body.dark .cdc-due-mobile-total,
    body[data-layout-mode="dark"] .cdc-due-mobile-total { background: #4c0519 !important; border-color: #be123c !important; }
    .cdc-due-label { display: block; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; color: #64748b; margin-bottom: 2px; }
    .cdc-due-val { display: block; font-size: 12px; font-weight: 700; color: #334155; }
    html.dark .cdc-due-val,
    body.dark .cdc-due-val,
    body[data-layout-mode="dark"] .cdc-due-val { color: #e2e8f0 !important; }

    .cdc-label {
        display: block;
        text-align: left !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #475569;
        margin-bottom: 6px;
        margin-top: 6px;
    }
    html.dark .cdc-label,
    body.dark .cdc-label,
    body[data-layout-mode="dark"] .cdc-label { color: #94a3b8 !important; }

    .cp-modal-input {
        height: 38px !important;
        min-height: 38px !important;
        max-height: 38px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 12px !important;
        font-size: 13px !important;
        padding: 0 12px !important;
        width: 100% !important;
        background-color: #ffffff !important;
        color: #1e293b !important;
        outline: none !important;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .cp-modal-input:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.18) !important;
    }
    html.dark .cp-modal-input,
    body.dark .cp-modal-input,
    body[data-layout-mode="dark"] .cp-modal-input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }

    .modal-footer-sticky {
        position: sticky;
        bottom: 0;
        z-index: 20;
        padding: 10px 16px !important;
        border-top: 1px solid #e2e8f0;
        background-color: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }
    html.dark .modal-footer-sticky,
    body.dark .modal-footer-sticky,
    body[data-layout-mode="dark"] .modal-footer-sticky {
        background-color: #0f172a !important;
        border-top-color: #334155 !important;
    }

    .cp-btn-cancel {
        height: 38px !important; min-height: 38px !important;
        padding: 0 18px !important; border-radius: 12px !important;
        background-color: #dc2626 !important; color: #ffffff !important;
        font-weight: 700 !important; font-size: 13px !important;
        display: inline-flex !important; align-items: center !important;
        justify-content: center !important; gap: 6px !important;
        border: none !important; cursor: pointer !important;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3) !important;
        transition: all 0.15s !important; white-space: nowrap !important;
    }
    .cp-btn-cancel:hover { background-color: #b91c1c !important; transform: translateY(-1px); color: #ffffff !important; }

    .cp-btn-primary {
        height: 38px !important; min-height: 38px !important;
        padding: 0 18px !important; border-radius: 12px !important;
        background-color: #15803d !important; color: #ffffff !important;
        font-weight: 700 !important; font-size: 13px !important;
        display: inline-flex !important; align-items: center !important;
        justify-content: center !important; gap: 6px !important;
        border: none !important; cursor: pointer !important;
        box-shadow: 0 2px 8px rgba(21, 128, 61, 0.3) !important;
        transition: all 0.15s !important; white-space: nowrap !important;
    }
    .cp-btn-primary:hover { background-color: #166534 !important; transform: translateY(-1px); color: #ffffff !important; }

    .cp-badge {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 2px 10px; border-radius: 9999px; font-size: 11px;
        font-weight: 700; white-space: nowrap;
    }
    .cp-badge-id { background: #f0fdf4; color: #15803d; border: 1px solid #86efac; font-family: monospace; }
    html.dark .cp-badge-id,
    body.dark .cp-badge-id,
    body[data-layout-mode="dark"] .cp-badge-id { background: #064e3b; color: #a7f3d0; border-color: #047857; }

    /* Custom Dropdown in Modal - Root Level on top */
    .custom-modal-dropdown .select-menu {
        position: absolute;
        width: 100%;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        z-index: 999999 !important;
        overflow: hidden;
    }
    html.dark .custom-modal-dropdown .select-menu,
    body.dark .custom-modal-dropdown .select-menu,
    body[data-layout-mode="dark"] .custom-modal-dropdown .select-menu {
        background: #1e293b;
        border-color: #334155;
    }

    /* Flatpickr Calendar Styling - Root Level on top of all modals */
    .flatpickr-calendar {
        z-index: 99999999 !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.15), 0 8px 10px -6px rgba(0,0,0,0.1) !important;
        border: 1px solid #cbd5e1 !important;
    }
    .flatpickr-input {
        width: 100% !important;
        height: 38px !important;
        min-height: 38px !important;
        max-height: 38px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 12px !important;
        font-size: 13px !important;
        padding: 0 12px !important;
        background-color: #ffffff !important;
        color: #1e293b !important;
        outline: none !important;
        display: block !important;
        box-sizing: border-box !important;
    }
    .flatpickr-input:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.18) !important;
    }
    html.dark .flatpickr-input,
    body.dark .flatpickr-input,
    body[data-layout-mode="dark"] .flatpickr-input,
    body[light-mode="dark"] .flatpickr-input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    .select-option-item {
        padding: 9px 12px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        transition: all 0.12s;
        color: #334155;
    }
    html.dark .select-option-item,
    body.dark .select-option-item,
    body[data-layout-mode="dark"] .select-option-item { color: #cbd5e1; }
    .select-option-item:hover,
    .select-option-item.active {
        background-color: #f0fdf4;
        color: #15803d;
    }
    html.dark .select-option-item:hover,
    html.dark .select-option-item.active,
    body.dark .select-option-item:hover,
    body.dark .select-option-item.active,
    body[data-layout-mode="dark"] .select-option-item:hover,
    body[data-layout-mode="dark"] .select-option-item.active {
        background-color: #064e3b;
        color: #6ee7b7;
    }

    /* Status Badges */
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
    .badge-paid {
        background-color: #10b981 !important;
        color: #ffffff !important;
        font-size: 10px !important;
        padding: 2px 8px !important;
    }
    .badge-partial {
        background-color: #f59e0b !important;
        color: #ffffff !important;
        font-size: 10px !important;
        padding: 2px 8px !important;
    }
    .badge-unpaid {
        background-color: #ef4444 !important;
        color: #ffffff !important;
        font-size: 10px !important;
        padding: 2px 8px !important;
    }
    .badge-return {
        background-color: #64748b !important;
        color: #ffffff !important;
        font-size: 10px !important;
        padding: 2px 8px !important;
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
        background-color: #ffffff;
        color: #334155;
        border: 1.5px solid #cbd5e1;
        transition: all 0.15s ease-in-out;
        cursor: pointer;
    }
    .custom-pagination-btn:hover:not(:disabled) {
        border-color: #16a34a !important;
        color: #ffffff !important;
        background-color: #16a34a !important;
    }
    .custom-pagination-btn.active {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(21, 128, 61, 0.3) !important;
    }
    .custom-pagination-btn:disabled {
        opacity: 0.45;
        cursor: not-allowed;
    }

    html.dark .custom-pagination-btn,
    body.dark .custom-pagination-btn,
    body[light-mode="dark"] .custom-pagination-btn {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    html.dark .custom-pagination-btn:hover:not(:disabled),
    body.dark .custom-pagination-btn:hover:not(:disabled),
    body[light-mode="dark"] .custom-pagination-btn:hover:not(:disabled) {
        border-color: #16a34a !important;
        background-color: #16a34a !important;
        color: #ffffff !important;
    }
    html.dark .custom-pagination-btn.active,
    body.dark .custom-pagination-btn.active,
    body[light-mode="dark"] .custom-pagination-btn.active {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }
</style>

<script>
    let rawCustomerDueData = [];
    let rawDueCollectionData = [];
    let activeCustomerTab = 'due-list';
    let currentPage = 1;
    let pageSize = 15;
    let dueListFlatpickrInstance = null;

    function formatBdCurrency(val) {
        let num = parseFloat(val) || 0;
        return num.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function formatDate(dateStr) {
        if (!dateStr) return "-";
        try {
            const date = new Date(dateStr);
            if (isNaN(date.getTime())) return dateStr;
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        } catch (e) {
            return dateStr;
        }
    }

    function initDueListDatePicker() {
        const dateInput = document.getElementById('DueCollectionDate');
        if (!dateInput) return;
        if (dueListFlatpickrInstance) {
            dueListFlatpickrInstance.destroy();
        }
        dueListFlatpickrInstance = flatpickr(dateInput, {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            defaultDate: new Date(),
            allowInput: true,
            static: false,
            appendTo: document.body,
            disableMobile: true,
            onOpen: function() {
                $(document).off('focusin.bs.modal');
            }
        });
    }

    $(document).ready(function () {
        $("#entries").val("15");
        $('#customerDueCollectModal').appendTo('body');
        loadCustomerDueData();
        loadCustomerDueCollectionData();
    });

    function switchCustomerDueTab(tab) {
        activeCustomerTab = tab;
        currentPage = 1;

        if (tab === 'due-list') {
            $('#tabBtnCustomerDue').addClass('active');
            $('#tabBtnDueCollection').removeClass('active');
            $('#pane-due-list').show();
            $('#pane-collection-list').hide();
            $('#pageTitleHeading').text('Customer Due List');
            $('#searchInput').attr('placeholder', 'Search Customer Due...');
        } else {
            $('#tabBtnDueCollection').addClass('active');
            $('#tabBtnCustomerDue').removeClass('active');
            $('#pane-due-list').hide();
            $('#pane-collection-list').show();
            $('#pageTitleHeading').text('Due Collection List');
            $('#searchInput').attr('placeholder', 'Search Due Collection...');
        }

        renderCurrentTabList();
    }

    $("#searchInput").on("keyup search input", function () {
        currentPage = 1;
        renderCurrentTabList();
    });

    $("#entries").on("change", function () {
        pageSize = parseInt($(this).val()) || 15;
        currentPage = 1;
        renderCurrentTabList();
    });

    function renderCurrentTabList() {
        if (activeCustomerTab === 'due-list') {
            renderCustomerDuePaginatedList();
        } else {
            renderCustomerDueCollectionPaginatedList();
        }
    }

    // ── Fetch 1: Customer Due List ──
    async function loadCustomerDueData() {
        try {
            showLoader();
            const res = await axios.get("/api/battery/customer-due-list", HeaderToken());
            hideLoader();

            if (res.data.status === "success" && Array.isArray(res.data.CustomerData)) {
                rawCustomerDueData = res.data.CustomerData;
                $('#dueListCount').text(rawCustomerDueData.length);
                if (activeCustomerTab === 'due-list') {
                    renderCustomerDuePaginatedList();
                }
            }
        } catch (error) {
            hideLoader();
            console.error("Error fetching Battery Customer Due List:", error);
        }
    }

    // ── Fetch 2: Customer Due Collection List ──
    async function loadCustomerDueCollectionData() {
        try {
            let res = await axios.get("/api/battery/customer-due-collection-list", HeaderToken());
            if (res.data && Array.isArray(res.data['CustomerDueCollectionData'])) {
                rawDueCollectionData = res.data['CustomerDueCollectionData'];
                $('#collectionListCount').text(rawDueCollectionData.length);
                if (activeCustomerTab === 'collection-list') {
                    renderCustomerDueCollectionPaginatedList();
                }
            }
        } catch (e) {
            console.error("Error fetching Battery Customer Due Collection List:", e);
        }
    }

    // ── Render Tab 1: Customer Due List ──
    function renderCustomerDuePaginatedList() {
        if (!rawCustomerDueData) return;

        let searchTerm = $("#searchInput").val().toLowerCase().trim();

        let filtered = rawCustomerDueData.filter(function (item) {
            let customerId = (item.customer_id || "").toLowerCase();
            let name = (item.customer_name || item.name || "").toLowerCase();
            let mobile = (item.mobile || item.phone || "").toLowerCase();

            return !searchTerm || customerId.includes(searchTerm) || name.includes(searchTerm) || mobile.includes(searchTerm);
        });

        filtered.sort((a, b) => (b.id || 0) - (a.id || 0));

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
            tableList.html('<tr><td colspan="8" class="text-center text-rose-500 p-8 font-semibold"><svg class="w-6 h-6 mx-auto mb-2 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>No battery customer dues found.</td></tr>');
            mobileCardList.html('<div class="p-6 text-center text-rose-500 font-semibold bg-white dark:bg-slate-800 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm">No battery customer dues found.</div>');
        } else {
            pageItems.forEach(function (item, idx) {
                let realIndex = startIndex + idx;
                const previous_due = parseFloat(item.previous_due_amount) || 0;
                const order_due = parseFloat(item.order_due_amount) || 0;
                const total_due = parseFloat(item.total_due_amount) || 0;
                const displayName = item.customer_name || item.name || 'Walk-in Customer';
                const displayMobile = item.mobile || item.phone || '-';

                // Action Button: Due / Money Dollar Icon button
                let actionHtml = `
                    <div class="flex items-center justify-center gap-1.5">
                        <button data-id="${item.id}" onclick="openCollectDueModal(${item.id})" type="button" class="edit-link" title="Collect Customer Due">
                            <i class="fa-solid fa-dollar-sign text-xs"></i>
                        </button>
                    </div>
                `;

                // Desktop Table Row
                let row = `
                    <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors border-b border-slate-100 dark:border-slate-800">
                        <td class="p-[10px] text-center font-semibold text-slate-400 dark:text-slate-500">${realIndex + 1}</td>
                        <td class="p-[10px] text-start whitespace-nowrap">
                            <a href="/battery/customer/profile/${item.id}" class="font-mono font-bold text-xs text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 hover:underline inline-flex items-center gap-1" title="View Customer Profile">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span>${item.customer_id || 'N/A'}</span>
                            </a>
                        </td>
                        <td class="p-[10px] text-start">
                            <span class="font-bold text-slate-800 dark:text-slate-100 text-sm leading-snug">${displayName}</span>
                        </td>
                        <td class="p-[10px] text-start font-medium text-slate-600 dark:text-slate-300 whitespace-nowrap">${displayMobile}</td>
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
                                <a href="/battery/customer/profile/${item.id}" class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-slate-800 font-semibold" style="font-size: 10px;">
                                    <i class="fa-solid fa-user me-1 text-emerald-600"></i>${item.customer_id || 'N/A'}
                                </a>
                            </div>
                            <span class="badge bg-rose-50 text-rose-600 border border-rose-200 dark:bg-rose-950/40 dark:text-rose-400 font-bold" style="font-size: 10px;">Due</span>
                        </div>

                        <div class="mb-2">
                            <h6 class="font-bold text-slate-800 dark:text-slate-100 mb-0.5 text-sm leading-snug">${displayName}</h6>
                            <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                <span>${displayMobile}</span>
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
                            <button data-id="${item.id}" onclick="openCollectDueModal(${item.id})" type="button" class="edit-link inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold shadow-sm" style="width: auto !important; height: 32px !important;">
                                <i class="fa-solid fa-dollar-sign text-xs"></i>
                                <span>Collect Due</span>
                            </button>
                        </div>
                    </div>`;
                mobileCardList.append(mobileCard);
            });
        }

        updatePaginationUI(totalItems, startIndex, endIndex, totalPages);
    }

    // ── Render Tab 2: Due Collection List ──
    function renderCustomerDueCollectionPaginatedList() {
        if (!rawDueCollectionData) return;

        let searchTerm = $("#searchInput").val().toLowerCase().trim();

        let filtered = rawDueCollectionData.filter(function (item) {
            let customerName = (item.customer ? (item.customer.customer_name || item.customer.name) : "").toLowerCase();
            let customerID = (item.customer ? item.customer.customer_id : "").toLowerCase();
            let dateStr = (item.due_collection_date || "").toLowerCase();

            return !searchTerm || customerName.includes(searchTerm) || customerID.includes(searchTerm) || dateStr.includes(searchTerm);
        });

        filtered.sort((a, b) => (b.id || 0) - (a.id || 0));

        let subTotalPayable = 0;
        let subTotalPaid = 0;
        let subTotalDue = 0;

        filtered.forEach(item => {
            subTotalPayable += parseFloat(item.previous_due_amount) || 0;
            subTotalPaid += parseFloat(item.paid_amount) || 0;
            subTotalDue += parseFloat(item.due_amount) || 0;
        });

        $("#subTotalPayable").text(`${formatBdCurrency(subTotalPayable)} TK`);
        $("#subTotalPaid").text(`${formatBdCurrency(subTotalPaid)} TK`);
        $("#subTotalDue").text(`${formatBdCurrency(subTotalDue)} TK`);

        let totalItems = filtered.length;
        let totalPages = Math.ceil(totalItems / pageSize) || 1;
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        let startIndex = (currentPage - 1) * pageSize;
        let endIndex = Math.min(startIndex + pageSize, totalItems);
        let pageItems = filtered.slice(startIndex, endIndex);

        let tableList = $("#collectionTableList");
        let mobileCardList = $("#collectionMobileCardList");

        tableList.empty();
        mobileCardList.empty();

        if (pageItems.length === 0) {
            tableList.html('<tr><td colspan="8" class="text-center text-rose-500 p-8 font-semibold"><svg class="w-6 h-6 mx-auto mb-2 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>No collection records found.</td></tr>');
            mobileCardList.html('<div class="p-6 text-center text-rose-500 font-semibold bg-white dark:bg-slate-800 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm">No collection records found.</div>');
        } else {
            pageItems.forEach(function (item, idx) {
                let realIndex = startIndex + idx;
                let dueAmount = parseFloat(item['due_amount']) || 0;
                let paidAmount = parseFloat(item['paid_amount']) || 0;
                let payableAmount = parseFloat(item['previous_due_amount']) || 0;
                let customerName = item.customer ? (item.customer.customer_name || item.customer.name) : "N/A";
                let customerID = item.customer ? item.customer.customer_id : "N/A";
                let customerRealId = item.customer ? item.customer.id : (item.customer_id || '');

                let paymentStatus = 'Return';
                let statusClass = 'badge-return';
                if (dueAmount === 0 && paidAmount > 0) {
                    paymentStatus = 'Fully Paid';
                    statusClass = 'badge-paid';
                } else if (dueAmount > 0 && paidAmount > 0) {
                    paymentStatus = 'Partial Paid';
                    statusClass = 'badge-partial';
                } else if (dueAmount > 0 && paidAmount === 0) {
                    paymentStatus = 'Unpaid';
                    statusClass = 'badge-unpaid';
                }

                // Desktop Table Row
                let row = `
                    <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors border-b border-slate-100 dark:border-slate-800">
                        <td class="p-[10px] text-center font-semibold text-slate-400 dark:text-slate-500">${realIndex + 1}</td>
                        <td class="p-[10px] text-start whitespace-nowrap text-slate-600 dark:text-slate-300 font-medium">${formatDate(item.due_collection_date)}</td>
                        <td class="p-[10px] text-start whitespace-nowrap">
                            <a href="${customerRealId ? '/battery/customer/profile/' + customerRealId : 'javascript:void(0)'}" class="font-mono font-bold text-xs text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 hover:underline inline-flex items-center gap-1" title="View Customer Profile">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span>${customerID}</span>
                            </a>
                        </td>
                        <td class="p-[10px] text-start">
                            <span class="font-bold text-slate-800 dark:text-slate-100 text-sm leading-snug">${customerName}</span>
                        </td>
                        <td class="p-[10px] text-end font-medium text-slate-700 dark:text-slate-300 whitespace-nowrap">৳ ${formatBdCurrency(payableAmount)}</td>
                        <td class="p-[10px] text-end font-medium text-emerald-700 dark:text-emerald-400 whitespace-nowrap">৳ ${formatBdCurrency(paidAmount)}</td>
                        <td class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ ${formatBdCurrency(dueAmount)}</td>
                        <td class="p-[10px] text-center">
                            <span class="badge ${statusClass}">${paymentStatus}</span>
                        </td>
                    </tr>`;
                tableList.append(row);

                // Mobile Card View
                let mobileCard = `
                    <div class="due-col-mobile-card unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800/90 shadow-sm transition-all mb-3">
                        <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-xs text-slate-500 font-medium">${formatDate(item.due_collection_date)}</span>
                            <span class="badge ${statusClass}">${paymentStatus}</span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <h6 class="font-bold text-slate-800 dark:text-slate-100 text-sm mb-0">${customerName}</h6>
                                <span class="font-mono text-xs text-slate-400">${customerID}</span>
                            </div>
                            <span class="badge bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold" style="font-size: 10px;">#${realIndex + 1}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2 bg-slate-50 dark:bg-slate-900/50 p-2.5 rounded-xl my-2 text-center items-center border border-slate-100 dark:border-slate-800">
                            <div class="border-r border-slate-300 dark:border-slate-800">
                                <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">Payable</span>
                                <span class="font-bold text-slate-700 dark:text-slate-300 text-xs">৳ ${formatBdCurrency(payableAmount)}</span>
                            </div>
                            <div class="border-r border-slate-300 dark:border-slate-800">
                                <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">Paid</span>
                                <span class="font-bold text-emerald-700 dark:text-emerald-400 text-xs">৳ ${formatBdCurrency(paidAmount)}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">Due</span>
                                <span class="font-bold text-rose-600 dark:text-rose-400 text-xs">৳ ${formatBdCurrency(dueAmount)}</span>
                            </div>
                        </div>
                    </div>`;
                mobileCardList.append(mobileCard);
            });
        }

        updatePaginationUI(totalItems, startIndex, endIndex, totalPages);
    }

    // ── Open & Fill Due Collection Modal ──
    async function openCollectDueModal(id) {
        if (!id) return;
        try {
            document.getElementById('updateID').value = id;
            openModal(document.getElementById('customerDueCollectModal'));
            showLoader();

            let res = await axios.post("/api/battery/customer-due-collection-details-by-id", {
                id: id.toString()
            }, HeaderToken());

            hideLoader();

            if (res.data.status === "success") {
                const data = res.data;
                const customer = data.rows || {};

                // Name & ID
                $('#modalCustomerName').text(customer.customer_name || customer.name || 'Customer');
                $('#modalCustomerId').text(customer.customer_id || 'CUST-0000');

                let prevDue = parseFloat(data.previous_due || 0).toFixed(2);
                let orderDue = parseFloat(data.order_due || 0).toFixed(2);
                let totalDue = parseFloat(data.total_due || 0).toFixed(2);

                // Update Values
                $('#PreviousDue').text(`৳ ${prevDue}`);
                $('#mobilePreviousDue').text(`৳ ${prevDue}`);
                $('#OrderDue').text(`৳ ${orderDue}`);
                $('#mobileOrderDue').text(`৳ ${orderDue}`);
                $('#TotalDue').text(`৳ ${totalDue}`);
                $('#mobileTotalDue').text(`৳ ${totalDue}`);
                $('#MyTotalDueAmount').text(`৳ ${totalDue}`);
                $('#PreviousDueAmount').text(`৳ ${prevDue}`);
                $('#ShowtotalDuePayable').text(`৳ ${totalDue}`);

                // Reset inputs
                document.getElementById('UpdateDueAmountclear').value = totalDue > 0 ? totalDue : '';
                document.getElementById('UpdateDiscountAmountclear').value = '0';
                document.getElementById('transactionInput').value = '';

                // Calculate initial
                calculateDuePayment();

                // Default Payment Method: Cash
                selectDuePaymentOption('cash', '<i class="fa-solid fa-money-bill text-emerald-600"></i> Cash');

                initDueListDatePicker();
            } else {
                errorToast(res.data.message || "Failed to fetch customer due details.");
            }
        } catch (e) {
            hideLoader();
            console.error("Error opening collect modal:", e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    function calculateDuePayment() {
        const totalDueText = document.getElementById('TotalDue').innerText || '0';
        const totalDueAmount = parseFloat(totalDueText.replace(/[^\d.-]/g, '')) || 0;

        const enteredAmount = parseFloat(document.getElementById('UpdateDueAmountclear').value) || 0;
        const discountAmount = parseFloat(document.getElementById('UpdateDiscountAmountclear').value) || 0;

        const totalPaidWithDiscount = enteredAmount + discountAmount;
        const newTotalDue = parseFloat((totalDueAmount - totalPaidWithDiscount).toFixed(2));
        const finalDueAmount = newTotalDue >= 0 ? newTotalDue : 0;

        document.getElementById('ShowtotalDuePayable').textContent = `৳ ${finalDueAmount.toFixed(2)}`;

        const paymentStatusDisplay = document.getElementById('ShowpaymentStatusDisplay');
        if (finalDueAmount === 0 && enteredAmount > 0) {
            paymentStatusDisplay.textContent = "Fully Paid";
            paymentStatusDisplay.className = "badge px-3 py-1 font-bold text-xs bg-emerald-600 text-white rounded-full";
        } else if (enteredAmount > 0 && finalDueAmount < totalDueAmount) {
            paymentStatusDisplay.textContent = "Partial Paid";
            paymentStatusDisplay.className = "badge px-3 py-1 font-bold text-xs bg-blue-600 text-white rounded-full";
        } else {
            paymentStatusDisplay.textContent = "Unpaid";
            paymentStatusDisplay.className = "badge px-3 py-1 font-bold text-xs bg-rose-600 text-white rounded-full";
        }

        const showDiscount = document.getElementById('ShowDiscountAmount');
        if (showDiscount) {
            showDiscount.textContent = `৳ ${discountAmount.toFixed(2)}`;
        }
    }

    function toggleDuePaymentDropdown() {
        const dropdown = document.getElementById('modalPaymentDropdown');
        if (!dropdown) return;
        const menu = dropdown.querySelector('.select-menu');
        if (menu) {
            menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
        }
    }

    function selectDuePaymentOption(value, html) {
        document.getElementById('selectedPaymentMethod').value = value;
        const dropdown = document.getElementById('modalPaymentDropdown');
        if (dropdown) {
            dropdown.querySelector('.selected-text').innerHTML = html;
            dropdown.querySelectorAll('.select-option-item').forEach(el => {
                if (el.getAttribute('data-value') === value) {
                    el.classList.add('active');
                } else {
                    el.classList.remove('active');
                }
            });
            dropdown.querySelector('.select-menu').style.display = 'none';
        }
    }

    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('modalPaymentDropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            const menu = dropdown.querySelector('.select-menu');
            if (menu) menu.style.display = 'none';
        }
    });

    function openModal(modalEl) {
        if (!modalEl) return;
        if (window.bootstrap && window.bootstrap.Modal) {
            let modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modalInstance.show();
        } else if (typeof $ !== 'undefined' && $(modalEl).modal) {
            $(modalEl).modal('show');
        } else {
            modalEl.style.display = 'block';
            modalEl.classList.add('show');
        }
    }

    function closeModal(modalEl) {
        if (!modalEl) return;
        if (window.bootstrap && window.bootstrap.Modal) {
            let modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
            else {
                modalEl.style.display = 'none';
                modalEl.classList.remove('show');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
            }
        } else if (typeof $ !== 'undefined' && $(modalEl).modal) {
            $(modalEl).modal('hide');
        } else {
            modalEl.style.display = 'none';
            modalEl.classList.remove('show');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
        }
    }

    async function SavePaymentInfo(event) {
        if (event) event.preventDefault();

        try {
            const paidAmount = parseFloat(document.getElementById('UpdateDueAmountclear').value) || 0;
            const DiscountAmount = parseFloat(document.getElementById('UpdateDiscountAmountclear').value) || 0;
            const PreviousDue = parseFloat(document.getElementById('PreviousDue').innerText.replace(/[^\d.-]/g, '')) || 0;
            const dueAmount = parseFloat(document.getElementById('ShowtotalDuePayable').innerText.replace(/[^\d.-]/g, '')) || 0;
            const transactionId = document.getElementById('transactionInput').value;
            const CollectionDate = document.getElementById('DueCollectionDate').value;
            const paymentStatus = document.getElementById('ShowpaymentStatusDisplay').innerText;
            const updateID = parseInt(document.getElementById('updateID').value);
            const paymentMethod = document.getElementById('selectedPaymentMethod').value || 'cash';

            if (!paidAmount || paidAmount <= 0) {
                errorToast('Please enter a valid pay amount.');
                return;
            }
            if (!paymentStatus) {
                errorToast('Payment status is missing.');
                return;
            }

            let formData = new FormData();
            formData.append('id', updateID);
            formData.append('paid_amount', paidAmount);
            formData.append('discount_amount', DiscountAmount);
            formData.append('due_amount', dueAmount);
            formData.append('previous_due_amount', PreviousDue);
            formData.append('due_collection_date', CollectionDate);
            formData.append('payment_status', paymentStatus);
            formData.append('transaction_id', transactionId);
            formData.append('payment_method', paymentMethod);

            showLoader();
            let res = await axios.post("/api/battery/customer-payment-details-update", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            });
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message || "Due collection updated successfully!");
                closeModal(document.getElementById('customerDueCollectModal'));
                
                await loadCustomerDueData();
                await loadCustomerDueCollectionData();
            } else {
                errorToast(res.data.message || "Failed to update collection.");
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            unauthorized(e.response?.status || 500);
        }
    }

    // ── Pagination UI ──
    function updatePaginationUI(totalItems, startIndex, endIndex, totalPages) {
        let displayInfo = $("#display-info");
        if (totalItems === 0) {
            displayInfo.html('<span class="display-info-box font-medium text-slate-500">Showing 0 to 0 of 0 entries</span>');
        } else {
            displayInfo.html(`<span class="display-info-box font-medium text-slate-500">Showing ${startIndex + 1} to ${endIndex} of ${totalItems} entries</span>`);
        }

        let pagContainer = $("#pagination");
        pagContainer.empty();
        if (totalPages <= 1) return;

        let prevDisabled = currentPage === 1 ? 'disabled' : '';
        let prevBtn = `<button type="button" class="custom-pagination-btn pagination-nav-btn ${prevDisabled}" ${currentPage === 1 ? 'disabled' : ''} onclick="goToPage(${currentPage - 1})">
            <svg class="w-3 h-3 me-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg> Previous
        </button>`;
        pagContainer.append(prevBtn);

        let maxVisible = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
        let endPage = Math.min(totalPages, startPage + maxVisible - 1);
        if (endPage - startPage + 1 < maxVisible) {
            startPage = Math.max(1, endPage - maxVisible + 1);
        }

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
        renderCurrentTabList();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>
@endsection
