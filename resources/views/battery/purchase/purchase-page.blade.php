@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Purchase List - MARSS CORPORATION')
@section('content')

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
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Purchase List</h1>
                                <small class="text-slate-500 dark:text-slate-400 text-xs">Battery procurement orders and inventory cost records</small>
                            </div>
                        </div>

                        <!-- Right Controls: + Create Purchase Button -->
                        <div class="flex items-center flex-wrap gap-2">
                            <button id="openModalBtns" type="button" class="btn-create-purchase inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] rounded-xl shadow-sm transition-all duration-150 font-semibold text-sm cursor-pointer" data-bs-toggle="modal" data-bs-target="#purchaseCreateModal">
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
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding: 0 8px !important;" class="w-full h-full bg-transparent border-0 outline-none text-[13px] text-slate-800 dark:text-slate-100 placeholder:text-[13px] placeholder:font-normal placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search Purchase..." />
                        </div>

                        <!-- 2nd: Start Date with Flatpickr (col-start-date) -->
                        <div class="col-start-date date-input-wrapper unified-ui-border h-[38px] flex items-center px-3 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm focus-within:border-emerald-600 transition-all cursor-pointer flex-shrink-0">
                            <input type="text" id="startDate" name="startDate" placeholder="Start Date" style="padding: 0 6px !important;" class="w-full bg-transparent border-0 outline-none text-[11px] font-medium text-slate-700 dark:text-slate-200 placeholder:text-[11px] placeholder:font-normal placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 cursor-pointer" />
                            <svg class="w-3.5 h-3.5 text-slate-400 pointer-events-none ms-1 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>

                        <!-- 3rd: End Date with Flatpickr (col-end-date) -->
                        <div class="col-end-date date-input-wrapper unified-ui-border h-[38px] flex items-center px-3 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm focus-within:border-emerald-600 transition-all cursor-pointer flex-shrink-0">
                            <input type="text" id="endDate" name="endDate" placeholder="End Date" style="padding: 0 6px !important;" class="w-full bg-transparent border-0 outline-none text-[11px] font-medium text-slate-700 dark:text-slate-200 placeholder:text-[11px] placeholder:font-normal placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 cursor-pointer" />
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
                        <div class="col-filter custom-searchable-select custom-filter-dropdown flex-shrink-0" id="purchaseFilterDropdown" style="position: relative !important;">
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
                            <div class="select-menu dropdown-menus shadow-xl" style="min-width: 170px; right: 0 !important; left: auto !important;">
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

                    <!-- 3. Desktop Table (14 Columns matching Retail, solid emerald header, 5px cell padding) -->
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

        <!-- 6. Sticky Bottom Copyright Section -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)] mt-auto">
            <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>
    </div>
</div>
<!-- Hero Main Content End -->

<!-- Full-Screen Image Preview Modal -->
<div id="imagePreviewModal" class="image-preview-overlay" onclick="if(event.target === this) closeImagePopup()" style="display: none; position: fixed; inset: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.85); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); z-index: 99999999; align-items: center; justify-content: center; padding: 20px; overflow: hidden; margin: 0; box-sizing: border-box;">
    <div class="relative flex flex-col items-center justify-center select-none" style="max-height: 80vh; max-width: 88vw; margin: auto;" onclick="event.stopPropagation()">
        <button type="button" onclick="closeImagePopup()" class="absolute -top-3.5 -right-3.5 z-50 w-9 h-9 rounded-full bg-rose-600 hover:bg-rose-700 text-white flex items-center justify-center shadow-2xl transition-transform hover:scale-110 cursor-pointer border-2 border-white focus:outline-none" title="Close Preview">
            <i class="fa-solid fa-xmark text-sm font-bold"></i>
        </button>
        <div class="rounded-2xl overflow-hidden shadow-2xl bg-slate-900 border border-white/20 flex items-center justify-center p-1" style="max-height: 80vh; max-width: 88vw; box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7);">
            <img id="imagePreviewSrc" src="" alt="Preview" class="block w-auto h-auto rounded-xl object-contain" style="max-height: calc(80vh - 12px); max-width: calc(88vw - 12px); object-fit: contain; display: block;" />
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: Purchase Product Modal (Matching Retail Exact Design) -->
<!-- ======================================================== -->
<div class="modal fade" id="purchaseCreateModal" tabindex="-1" aria-labelledby="purchaseCreateModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="padding: 0 !important;">
        <div class="modal-content" style="padding: 0 !important;">
            <!-- Sticky Green Header with White Text & Red Close Icon -->
            <div style="background-color: #15803d; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 20; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <h2 style="font-size: 18px; font-weight: 700; color: #ffffff; margin: 0; padding: 0; line-height: 1.2; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-cart-flatbed text-white text-base"></i>
                    <span>Purchase Product</span>
                </h2>
                <button type="button" class="close-btn close" data-bs-dismiss="modal" aria-label="Close" style="position: static !important; width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #dc2626; color: #ffffff; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.15s ease; margin: 0; padding: 0;" title="Close">
                    <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 14px;"></i>
                </button>
            </div>

            <form onsubmit="return saveBatteryPurchaseOrder(event)" id="purchaseCreateForm" style="display: flex; flex-direction: column; flex: 1 1 auto; overflow: hidden; margin: 0;">
                <!-- Scrollable Body Content -->
                <div class="purchase-modal-body p-4 sm:p-5" style="overflow-y: auto; flex: 1 1 auto; max-height: calc(90vh - 130px); text-align: left;">
                    
                    <!-- Top Info Cards: Supplier & Invoice Details -->
                    <div class="row g-3 mb-3">
                        <div class="col-lg-6">
                            <div class="purchase-clean-card rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 p-4 h-100">
                                <h5 class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 flex items-center gap-1.5 mb-3 text-left">
                                    <i class="fa-solid fa-truck-field text-emerald-600 dark:text-emerald-400"></i>
                                    <span>Supplier Information</span>
                                </h5>
                                <div class="flex items-center gap-2">
                                    <div class="relative flex-grow" id="searchableSupplierWrapper">
                                        <input type="text" id="supplierSearchInput" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" placeholder="Search or Select Supplier *" autocomplete="off" />
                                        <input type="hidden" id="SupplierDataList" value="none">
                                        <div id="supplierDropdownList" class="dropdown-menu shadow-xl w-full p-0 overflow-auto rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800" style="max-height: 250px; display: none; position: absolute; z-index: 1050; top: 100%; left: 0;"></div>
                                    </div>
                                    <button type="button" class="inline-flex items-center gap-1 px-3 h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-150 border-0 flex-shrink-0 cursor-pointer" onclick="openSupplierCreateModal()">
                                        <i class="fa-solid fa-plus text-xs"></i>
                                        <span>New</span>
                                    </button>
                                </div>

                                <div id="supplierCreditNotice" class="mt-3 d-none">
                                    <div class="p-2.5 rounded-xl flex justify-between items-center bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/40">
                                        <span id="supplierCreditBadge" class="font-bold text-xs text-slate-800 dark:text-white">
                                            <i class="fa-solid fa-gift me-1 text-emerald-600 dark:text-emerald-400"></i> Return Credit Available: <strong>৳ 0.00</strong>
                                        </span>
                                        <label class="flex items-center gap-2 mb-0 px-2 py-1 bg-white dark:bg-slate-800 rounded-lg border border-emerald-300 dark:border-emerald-700 shadow-sm cursor-pointer">
                                            <input type="checkbox" id="useReturnCreditCheckboxBanner" onchange="syncReturnCreditCheckbox(this.checked)" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                                            <span class="font-bold text-xs text-emerald-700 dark:text-emerald-400">Adjust Return Credit</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="purchase-clean-card rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 p-4 h-100">
                                <h5 class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 flex items-center gap-1.5 mb-3 text-left">
                                    <i class="fa-solid fa-file-invoice text-emerald-600 dark:text-emerald-400"></i>
                                    <span>Invoice & Voucher Details</span>
                                </h5>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Ref / Invoice No <span class="text-rose-500">*</span></label>
                                        <input type="text" placeholder="Reference No *" id="ReferenceNo" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Purchase Date <span class="text-rose-500">*</span></label>
                                        <input type="text" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" id="PurchaseDate" placeholder="DD-MM-YYYY" autocomplete="off" required style="cursor: pointer;" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Payable Balance</label>
                                        <input type="text" readonly placeholder="Payable Amount" id="PurchasePayableAmount" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-100 dark:bg-slate-800/80 text-emerald-700 dark:text-emerald-400 text-xs font-bold" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Attach Invoice Doc</label>
                                        <input type="file" id="AttachDocument" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Search & Scanner Box -->
                    <div class="purchase-clean-card rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 p-4 mb-3">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2 flex justify-between items-center text-left">
                            <span><i class="fa-solid fa-barcode text-emerald-600 dark:text-emerald-400 me-1"></i> Scan Barcode or Select Product <span class="text-rose-500">*</span></span>
                            <span class="px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/40 text-emerald-700 dark:text-emerald-400 text-xs font-bold"><i class="fa-solid fa-bolt me-1"></i> Auto-Cart Enabled</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <div class="flex-grow relative">
                                <input type="text" id="productInputData" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" placeholder="Scan barcode or type product name/code (Auto-adds to list)..." autocomplete="off" />
                                <ul id="productDropdown" class="list-group absolute w-full shadow-xl rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 mt-1" style="z-index: 1050; max-height: 280px; overflow-y: auto; display: none;"></ul>
                            </div>
                            <button type="button" class="inline-flex items-center gap-1 px-3 h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-150 border-0 flex-shrink-0 cursor-pointer" onclick="openProductCreateModal()" title="Add New Product">
                                <i class="fa-solid fa-plus text-xs"></i>
                                <span>New</span>
                            </button>
                            <button type="button" class="inline-flex items-center gap-1.5 px-4 h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-150 border-0 flex-shrink-0 cursor-pointer" onclick="openPurchaseCameraScanner()">
                                <i class="fa-solid fa-camera text-xs"></i>
                                <span>Scan Camera</span>
                            </button>
                        </div>
                    </div>

                    <!-- Cart Item Table -->
                    <div class="table-container rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden mb-3 bg-white dark:bg-slate-900 shadow-sm">
                        <table class="responsive-table w-full text-left border-collapse text-xs">
                            <thead class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                <tr>
                                    <th class="p-2.5">Product Name</th>
                                    <th class="p-2.5">Barcodes</th>
                                    <th class="p-2.5 text-center" style="width: 130px;">Qty</th>
                                    <th class="p-2.5 text-end" style="width: 130px;">Cost Price (৳)</th>
                                    <th class="p-2.5 text-end" style="width: 130px;">Sub Total</th>
                                    <th class="p-2.5 text-center" style="width: 60px;">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800" id="orderTableBody">
                                <!-- Dynamic Items -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Bottom Summary & Payment Details Card -->
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="purchase-clean-card rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 p-4 h-100">
                                <h5 class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 flex items-center gap-1.5 mb-3 text-left">
                                    <i class="fa-solid fa-credit-card text-emerald-600 dark:text-emerald-400"></i>
                                    <span>Payment Method & Details</span>
                                </h5>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Payment Method</label>
                                        <select class="form-select modern-select-dropdown w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-semibold focus:border-emerald-600 focus:outline-none transition-all" id="paymentMethod" onchange="handlePurchasePaymentMethodChange(this.value)" style="cursor: pointer;">
                                            <option value="" selected class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">Select Method</option>
                                            <option value="Cash" class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">Cash</option>
                                            <option value="Bkash" class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">Bkash</option>
                                            <option value="Nagad" class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">Nagad</option>
                                            <option value="Rocket" class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">Rocket</option>
                                            <option value="Bank" class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">Bank</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Paid Amount (৳)</label>
                                        <input type="number" step="any" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-bold" id="paidAmount" value="0" />
                                    </div>

                                    <!-- Mobile Banking Fields (Bkash / Nagad / Rocket) -->
                                    <div class="col-12 mt-1" id="mobileBankingFields" style="display: none;">
                                        <div class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-100/70 dark:bg-slate-800/60">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Payment Number</label>
                                                    <input type="text" id="paymentNumber" class="form-control w-full h-[36px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" placeholder="e.g. 017xxxxxxxx" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Transaction ID</label>
                                                    <input type="text" id="transactionIdInput" class="form-control w-full h-[36px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" placeholder="e.g. TRX12345678" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bank Banking Fields (Bank) -->
                                    <div class="col-12 mt-1" id="bankBankingFields" style="display: none;">
                                        <div class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-100/70 dark:bg-slate-800/60">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Bank Name</label>
                                                    <input type="text" id="bankNameInput" class="form-control w-full h-[36px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" placeholder="e.g. Islami Bank / DBBL" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Bank / Account Number</label>
                                                    <input type="text" id="bankNumberInput" class="form-control w-full h-[36px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" placeholder="e.g. 2050xxxxxxxx" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12" style="display: none;">
                                        <input type="text" id="paymentDetails" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs mt-1" placeholder="Enter transaction details..." />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="purchase-clean-card rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 p-4">
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between items-center py-1 border-b border-slate-200 dark:border-slate-800">
                                        <span class="text-slate-500 dark:text-slate-400 font-semibold">Total Quantity:</span>
                                        <span class="font-bold text-slate-800 dark:text-white text-sm" id="totalQuantity">0.00</span>
                                    </div>
                                    <div class="flex justify-between items-center py-1 border-b border-slate-200 dark:border-slate-800">
                                        <span class="text-slate-500 dark:text-slate-400 font-semibold">Grand Subtotal:</span>
                                        <span class="font-bold text-slate-800 dark:text-white text-sm">৳ <span id="totalSubTotal">0.00</span></span>
                                        <input type="hidden" id="grandSubtotal" value="0.00" />
                                    </div>
                                    <div class="flex justify-between items-center py-1 border-b border-slate-200 dark:border-slate-800">
                                        <label for="deliveryTransportCharge" class="text-slate-600 dark:text-slate-300 font-semibold mb-0 cursor-pointer">
                                            Delivery & Transport Charge:
                                        </label>
                                        <div class="flex items-center gap-1">
                                            <span class="text-slate-400 font-bold text-xs">৳</span>
                                            <input type="number" step="any" min="0" class="form-control w-28 h-8 text-end font-bold rounded-lg text-xs border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white focus:border-emerald-600 focus:outline-none" id="deliveryTransportCharge" value="0" placeholder="0.00" oninput="calculateDuePayment()" />
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center py-1 border-b border-slate-200 dark:border-slate-800">
                                        <label for="purchaseDiscountInput" class="text-slate-600 dark:text-slate-300 font-semibold mb-0 cursor-pointer">
                                            Discount:
                                        </label>
                                        <div class="flex items-center gap-1.5">
                                            <select id="purchaseDiscountType" class="form-select h-8 px-2 py-0 text-xs font-bold rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white focus:border-emerald-600 focus:outline-none cursor-pointer" onchange="calculateDuePayment()" style="width: 58px;">
                                                <option value="fixed">৳</option>
                                                <option value="percent">%</option>
                                            </select>
                                            <input type="number" step="any" min="0" class="form-control w-28 h-8 text-end font-bold rounded-lg text-xs border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white focus:border-emerald-600 focus:outline-none" id="purchaseDiscountInput" value="0" placeholder="0.00" oninput="calculateDuePayment()" />
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center py-1" style="display: none;">
                                        <label class="inline-flex items-center gap-2 cursor-pointer mb-0">
                                            <input type="checkbox" id="useReturnCreditCheckbox" onchange="syncReturnCreditCheckbox(this.checked)" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                                            <span class="font-bold text-xs text-emerald-700 dark:text-emerald-400">Return Credit Adj</span>
                                        </label>
                                        <input type="number" step="0.01" min="0" class="form-control w-28 h-8 text-end font-bold rounded-lg text-xs" id="returnAdjustmentAmount" value="0.00" disabled oninput="calculateDuePayment()" />
                                    </div>
                                    <div class="flex justify-between items-center p-2.5 rounded-xl bg-slate-800 text-white dark:bg-slate-950 my-2">
                                        <span class="font-bold text-xs">Net Payable:</span>
                                        <span class="font-bold text-base text-emerald-400">৳ <span id="netPayableDisplay">0.00</span></span>
                                        <input type="hidden" id="netPayableAmount" value="0.00" />
                                    </div>
                                    <div class="flex justify-between items-center py-1 border-b border-slate-200 dark:border-slate-800">
                                        <span class="text-slate-500 dark:text-slate-400 font-semibold">Due Amount:</span>
                                        <span class="font-bold text-rose-600 dark:text-rose-400 text-sm">৳ <input type="text" id="dueAmount" value="0.00" readonly class="border-0 bg-transparent text-rose-600 dark:text-rose-400 font-bold text-end" style="width: 90px;" /></span>
                                    </div>
                                    <div class="flex justify-between items-center py-1">
                                        <span class="text-slate-500 dark:text-slate-400 font-semibold">Payment Status:</span>
                                        <span id="paymentStatusDisplay" class="partial-payment-status">Unpaid</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sticky Bottom Modal Footer with Left-Right Padding and Red Cancel Button -->
                <div class="purchase-modal-footer bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 p-4 flex items-center justify-between gap-3 flex-shrink-0" style="position: sticky; bottom: 0; z-index: 20;">
                    <button type="button" class="px-5 h-[38px] rounded-xl text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:scale-[0.98] transition-all shadow-sm border-0 cursor-pointer" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="flex-grow sm:flex-grow-0 sm:min-w-[240px] h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-xs font-bold rounded-xl shadow transition-all duration-150 flex items-center justify-center gap-2 border-0 cursor-pointer">
                        <i class="fa-solid fa-circle-check text-sm"></i>
                        <span>Submit Purchase Order</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quick Create Battery Supplier Modal -->
<div class="modal fade" id="batteryQuickSupplierCreateModal" tabindex="-1" aria-hidden="true" style="z-index: 1070;" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 480px; margin: auto;">
        <div class="modal-content rounded-2xl border-0 shadow-2xl overflow-hidden bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100">
            <div style="background-color: #15803d; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between;">
                <h5 class="text-white font-bold text-sm m-0 flex items-center gap-2">
                    <i class="fa-solid fa-truck-field"></i> Create Battery Supplier
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" style="width: 26px; height: 26px; border-radius: 50%; background: #dc2626; color: #fff; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>
            <form onsubmit="return quickSaveBatterySupplier(event)" class="p-4 space-y-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Supplier Name <span class="text-rose-500">*</span></label>
                    <input type="text" id="quickSupplierName" required class="form-control rounded-xl text-xs h-[38px] w-full border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white" placeholder="Enter supplier name">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Mobile Number <span class="text-rose-500">*</span></label>
                    <input type="text" id="quickSupplierMobile" required class="form-control rounded-xl text-xs h-[38px] w-full border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white" placeholder="e.g. 017xxxxxxxx">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Company</label>
                    <input type="text" id="quickSupplierCompany" class="form-control rounded-xl text-xs h-[38px] w-full border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white" placeholder="Company name">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Address</label>
                    <input type="text" id="quickSupplierAddress" class="form-control rounded-xl text-xs h-[38px] w-full border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white" placeholder="Address">
                </div>
                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" class="btn btn-secondary px-3 py-1.5 rounded-xl text-xs" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success px-4 py-1.5 rounded-xl text-xs font-bold" style="background:#15803d; border-color:#15803d;">Save Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Camera Scanner Modal for Purchase -->
<div class="modal fade" id="purchaseCameraScanModal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <h5 class="modal-title fs-6 fw-bold">
                    <i class="fa-solid fa-barcode text-success me-2"></i> Product Barcode Scanner (Purchase)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" onclick="stopPurchaseCameraScanner()"></button>
            </div>
            <div class="modal-body p-3 text-center bg-light">
                <div id="purchaseCameraScannerStatus" class="alert alert-info py-2 small mb-3">
                    <i class="fa-solid fa-circle-notch fa-spin me-1"></i> Starting camera... Hold barcode in front of camera.
                </div>

                <div id="purchaseReader" style="width: 100%; min-height: 250px; background: #000; border-radius: 12px; overflow: hidden; margin: 0 auto;"></div>

                <div class="d-flex justify-content-between align-items-center mt-3 px-1">
                    <span id="purchaseLastScannedText" class="badge bg-dark text-wrap p-2" style="font-size: 13px;">Scanned: -</span>
                    <button type="button" class="btn btn-outline-dark btn-sm rounded-pill" onclick="switchPurchaseCamera()">
                        <i class="fa-solid fa-camera-rotate me-1"></i> Switch Camera
                    </button>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 py-2">
                <button type="button" class="btn btn-secondary btn-sm w-100 rounded-pill" data-bs-dismiss="modal" onclick="stopPurchaseCameraScanner()">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: Edit Purchase Modal (Matching Retail Pattern) -->
<!-- ======================================================== -->
<!-- ======================================================== -->
<!-- MODAL: Edit Battery Purchase Modal (Matching Retail Exact Design & Image 5) -->
<!-- ======================================================== -->
<section class="modal fade" id="purchaseUpdateModal" tabindex="-1" aria-labelledby="purchaseUpdateModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 650px;">
        <div class="modal-content rounded-2xl border-0 shadow-2xl overflow-hidden bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100">
            <!-- Sticky Green Header with White Text & Red Close Icon -->
            <div style="background-color: #15803d; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 10;">
                <h2 style="font-size: 18px; font-weight: 700; color: #ffffff; margin: 0; padding: 0; line-height: 1.2; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                    <span>Update Purchase</span>
                </h2>
                <button type="button" class="close-btn close" data-bs-dismiss="modal" aria-label="Close" style="position: static !important; width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #dc2626; color: #ffffff; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.15s ease; margin: 0; padding: 0;" title="Close">
                    <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 14px;"></i>
                </button>
            </div>

            <!-- Form Body -->
            <div class="modal-body p-4 sm:p-5" style="text-align: left;">
                <form onsubmit="return saveEditBatteryPurchase(event)" id="editPurchaseForm">
                    <input type="hidden" id="editPurchaseId">

                    <div class="row g-3">
                        <div class="col-md-6 mb-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Reference No</label>
                            <input type="text" class="form-control" placeholder="Enter Reference No" id="UpdateReferanceNo" />
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Date <span class="text-rose-500">*</span></label>
                            <input type="text" class="form-control" id="UpdatePurchaseDate" placeholder="DD-MM-YYYY" autocomplete="off" required style="cursor: pointer;" />
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Grand Total (৳) <span class="text-rose-500">*</span></label>
                            <input type="number" step="any" class="form-control font-bold" placeholder="Grand Subtotal" id="UpdateGrandSubtotal" required />
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Delivery & Transport Charge (৳)</label>
                            <input type="number" step="any" min="0" class="form-control font-bold" placeholder="Delivery & Transport Charge" id="UpdateDeliveryCharge" value="0" />
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Paid Amount (৳)</label>
                            <input type="number" step="any" class="form-control font-bold text-emerald-600 dark:text-emerald-400" placeholder="Paid Amount" id="UpdatePaidAmount" />
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Due Amount (৳)</label>
                            <input type="number" step="any" class="form-control font-bold text-rose-600 dark:text-rose-400 bg-slate-50 dark:bg-slate-800/60" placeholder="Due Amount" id="UpdateDueAmount" readonly />
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Supplier</label>
                            <!-- Searchable Supplier Dropdown for Update Modal -->
                            <div class="relative" id="updateSearchableSupplierWrapper">
                                <input type="text" id="updateSupplierSearchInput" class="form-control w-full" placeholder="Search or Select Supplier..." autocomplete="off" style="cursor: pointer;" />
                                <input type="hidden" id="UpdateSupplierSelect" value="" />
                                <div id="updateSupplierDropdownList" class="dropdown-menu shadow-xl w-full p-0 overflow-auto rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800" style="max-height: 220px; display: none; position: absolute; z-index: 1070; top: 100%; left: 0;"></div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-0 text-left">Attach Invoice Doc</label>
                                <span id="currentDocLink" class="text-[11px] font-semibold text-emerald-600 dark:text-emerald-400"></span>
                            </div>
                            <input type="file" id="UpdateAttachDocument" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs" />
                        </div>
                    </div>

                    <!-- Cancel button red with white text, Update button emerald with white text -->
                    <div class="modal-footer-wrap flex items-center justify-end gap-2 mt-4 pt-3 border-t border-slate-200 dark:border-slate-800">
                        <button type="button" class="px-4 h-[38px] rounded-xl text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:scale-[0.98] transition-all shadow-sm border-0 cursor-pointer" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="inline-flex items-center gap-1.5 px-5 h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-150 border-0 cursor-pointer">
                            <i class="fa-solid fa-check text-xs"></i>
                            <span>Update Purchase</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- ======================================================== -->
<!-- MODAL: Delete Confirmation Modal (Compact & Clean Design) -->
<!-- ======================================================== -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin: auto;">
        <div class="modal-content rounded-2xl border-0 shadow-2xl overflow-hidden bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 p-5 text-center">
            <input type="hidden" id="deleteID">
            <div class="w-12 h-12 rounded-full bg-rose-100 dark:bg-rose-950/50 text-rose-600 flex items-center justify-center mx-auto mb-3 border border-rose-200 dark:border-rose-900">
                <i class="fa-solid fa-triangle-exclamation text-xl" style="color: #dc2626;"></i>
            </div>
            <h4 class="font-bold text-slate-800 dark:text-white mb-1.5" style="font-size: 15px !important;">Delete Battery Purchase?</h4>
            <p class="text-slate-500 dark:text-slate-400 mb-4 leading-normal" style="font-size: 11px !important; line-height: 1.45 !important;">
                Are you sure you want to delete this purchase order? Inventory quantities and costs will be adjusted safely. This action cannot be reversed.
            </p>
            <div class="flex items-center justify-center gap-2">
                <button type="button" class="btn px-3.5 py-1.5 rounded-xl text-xs font-semibold border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" onclick="confirmDeleteBatteryPurchase()" class="btn px-4 py-1.5 text-white rounded-xl text-xs font-semibold transition-all shadow-sm" style="background-color: #dc2626 !important; border: none !important;">
                    Confirm Delete
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- SUB-MODAL: Add New Supplier (Matching Image 4 Exactly) -->
<!-- ======================================================== -->
<div class="purchase-submodal" id="purchaseSupplierCreateModal">
    <div class="purchase-submodal-content" style="width: 650px; max-width: 95%; max-height: 90vh; border-radius: 16px; background: #ffffff; padding: 0; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); display: flex; flex-direction: column; text-align: left;">
        <!-- Sticky Green Header with Truck Icon & Red Close Button -->
        <div style="background-color: #15803d; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 10; border-top-left-radius: 16px; border-top-right-radius: 16px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-truck-field" style="color: #ffffff; font-size: 18px;"></i>
                <h2 style="font-size: 18px; font-weight: 700; color: #ffffff; margin: 0; padding: 0; line-height: 1.2;">Add New Supplier</h2>
            </div>
            <button type="button" onclick="closePurchaseSupplierModal()" class="close-btn closes" style="width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #dc2626; color: #ffffff; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.15s ease;" title="Close">
                <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 14px;"></i>
            </button>
        </div>

        <!-- Scrollable Modal Body -->
        <div style="padding: 20px 24px; overflow-y: auto; flex: 1 1 auto; max-height: calc(90vh - 130px);" class="purchase-submodal-body">
            <form onsubmit="return savePurchaseSupplier(event)" id="purchaseSupplierForm">
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <label for="purchaseSupplierName" class="form-label-title" style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">Supplier Name <span style="color: #ef4444;">*</span></label>
                        <input type="text" placeholder="Enter Supplier Name" id="purchaseSupplierName" required class="form-control" style="width: 100%; height: 42px; border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" />
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="purchaseSupplierMobile" class="form-label-title" style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">Supplier Mobile <span style="color: #ef4444;">*</span></label>
                        <input type="text" placeholder="Enter Supplier Mobile" id="purchaseSupplierMobile" required class="form-control" style="width: 100%; height: 42px; border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" />
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="purchaseSupplierCompany" class="form-label-title" style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">Supplier Company</label>
                        <input type="text" placeholder="Enter Supplier Company" id="purchaseSupplierCompany" class="form-control" style="width: 100%; height: 42px; border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" />
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="purchaseSupplierAddress" class="form-label-title" style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">Supplier Address</label>
                        <input type="text" placeholder="Enter Supplier Address" id="purchaseSupplierAddress" class="form-control" style="width: 100%; height: 42px; border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" />
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="purchaseSupplierEmail" class="form-label-title" style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">Supplier Email</label>
                        <input type="email" placeholder="Enter Supplier Email" id="purchaseSupplierEmail" class="form-control" style="width: 100%; height: 42px; border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" />
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="purchaseSupplierPayableAmount" class="form-label-title" style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">Purchase Payable Amount</label>
                        <input type="number" step="any" placeholder="Enter Purchase Payable Amount" id="purchaseSupplierPayableAmount" class="form-control" style="width: 100%; height: 42px; border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" />
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="purchaseSupplierStatus" class="form-label-title" style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">Status <span style="color: #ef4444;">*</span></label>
                        <select class="form-select" id="purchaseSupplierStatus" style="width: 100%; height: 42px; border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px; cursor: pointer;">
                            <option value="Active" selected>Active</option>
                            <option value="InActive">Inactive</option>
                        </select>
                    </div>

                    <!-- Upload Photo -->
                    <div class="col-lg-12 mb-2">
                        <label class="form-label-title" style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">Supplier Image</label>
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <div id="purchaseSupplierImgBox" style="width: 80px; height: 70px; min-width: 80px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1.5px dashed #cbd5e1; position: relative;">
                                <svg id="purchaseSupplierDefaultIcon" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                                <img id="purchaseSupplierImgPreview" src="" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; display: none;" />
                            </div>

                            <div style="flex: 1;">
                                <label style="cursor: pointer; position: relative; width: 100%; height: 44px; border-radius: 8px; display: flex; justify-content: center; align-items: center; background: #f1f5f9; border: 1px solid #cbd5e1; font-size: 13px; font-weight: 600; color: #475569;">
                                    <span>Upload Photo</span>
                                    <input type="file" id="purchaseSupplierImageFile" onchange="previewPurchaseSupplierImage(this)" accept="image/*" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer;" />
                                </label>
                                <p style="margin: 4px 0 0 0; font-size: 11px; color: #94a3b8;">PNG, JPEG or GIF (up to 1 MB)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sticky / Full-width Submit button -->
                <div class="mt-3">
                    <button type="submit" class="btn text-white w-full py-2.5" style="background-color: #15803d; border-radius: 8px; font-weight: 700; font-size: 15px; border: none; cursor: pointer; transition: all 0.2s;">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- SUB-MODAL: Add New Product (Matching Image 5 Exactly) -->
<!-- ======================================================== -->
<div class="purchase-submodal" id="purchaseProductCreateModal">
    <div class="purchase-submodal-content" style="width: 750px; max-width: 95%; max-height: 90vh; border-radius: 16px; background: #ffffff; padding: 0; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); display: flex; flex-direction: column; text-align: left;">
        <!-- Header: Green Gradient with Cart Icon & Red Close Button -->
        <div style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); padding: 12px 18px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 10; border-top-left-radius: 16px; border-top-right-radius: 16px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-cart-plus" style="color: #ffffff; font-size: 18px;"></i>
                <h2 style="font-size: 18px; font-weight: 700; color: #ffffff; margin: 0; padding: 0; line-height: 1.2;">Add New Product</h2>
            </div>
            <button type="button" onclick="closePurchaseProductModal()" class="close-btn closes" style="width: 24px; height: 24px; min-width: 24px; min-height: 24px; border-radius: 50%; background-color: #ef4444; color: #ffffff; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.15s ease;" title="Close">
                <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 11px;"></i>
            </button>
        </div>

        <!-- Scrollable Modal Body -->
        <div style="padding: 18px 22px; overflow-y: auto; flex: 1 1 auto; max-height: calc(90vh - 120px);" class="purchase-submodal-body">
            <form onsubmit="return savePurchaseProduct(event)" id="purchaseProductCreateForm">
                <!-- Row 1: Brand (+), Category* (+), Sub-Category (+) with Search Filter Dropdown Design -->
                <div class="row g-2.5 mb-2">
                    <div class="col-lg-4 col-md-6 col-12">
                        <label for="modalProductBrand" style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 4px; display: block;">Brand</label>
                        <div class="d-flex align-items-center w-100 gap-2">
                            <!-- Native select kept hidden for 100% backend & DOM compatibility -->
                            <select class="d-none" id="modalProductBrand">
                                <option value="none">Select Brand</option>
                            </select>

                            <!-- Custom Searchable Brand Dropdown -->
                            <div class="custom-searchable-select flex-grow-1" id="modalBrandDropdown">
                                <div class="select-trigger d-flex align-items-center justify-content-between px-3" onclick="toggleCustomProductDropdown('modalBrandDropdown')">
                                    <span class="selected-text text-truncate" id="modalBrandSelectedText" style="font-size: 13px; font-weight: 500; color: #64748b;">Select Brand</span>
                                    <i class="fa-solid fa-chevron-down ms-1 text-muted" style="font-size: 12px; transition: transform 0.2s;"></i>
                                </div>
                                <div class="select-menu">
                                    <div class="search-wrap">
                                        <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="top: 50%; transform: translateY(-50%); left: 10px; font-size: 12px;"></i>
                                        <input type="text" placeholder="Search Brand..." oninput="filterCustomProductDropdown('modalBrandDropdown', this.value)" autocomplete="off">
                                    </div>
                                    <div class="select-options-list" id="modalBrandOptionsList">
                                        <!-- Brand options will load here -->
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn-add newbrand-open text-nowrap" onclick="openBrandSubModal()" style="width: 42px; height: 42px; min-width: 42px; padding: 0 !important; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; border-radius: 8px; background-color: #16a34a; border: none; color: #fff;" title="Add New Brand">
                                <i class="fa-solid fa-plus" style="font-size: 18px !important; color: #ffffff !important; line-height: 1 !important;"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <label for="modalProductCategory" style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 4px; display: block;">Category <span style="color: #ef4444;">*</span></label>
                        <div class="d-flex align-items-center w-100 gap-2">
                            <!-- Native select kept hidden for 100% backend & DOM compatibility -->
                            <select class="d-none" id="modalProductCategory" required>
                                <option value="" selected>Select Category *</option>
                            </select>

                            <!-- Custom Searchable Category Dropdown -->
                            <div class="custom-searchable-select flex-grow-1" id="modalCategoryDropdown">
                                <div class="select-trigger d-flex align-items-center justify-content-between px-3" onclick="toggleCustomProductDropdown('modalCategoryDropdown')">
                                    <span class="selected-text text-truncate" id="modalCategorySelectedText" style="font-size: 13px; font-weight: 500; color: #64748b;">Select Category <span class="text-danger">*</span></span>
                                    <i class="fa-solid fa-chevron-down ms-1 text-muted" style="font-size: 12px; transition: transform 0.2s;"></i>
                                </div>
                                <div class="select-menu">
                                    <div class="search-wrap">
                                        <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="top: 50%; transform: translateY(-50%); left: 10px; font-size: 12px;"></i>
                                        <input type="text" placeholder="Search Category..." oninput="filterCustomProductDropdown('modalCategoryDropdown', this.value)" autocomplete="off">
                                    </div>
                                    <div class="select-options-list" id="modalCategoryOptionsList">
                                        <!-- Category options will load here -->
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn-add newcategory-open text-nowrap" onclick="openCategorySubModal()" style="width: 42px; height: 42px; min-width: 42px; padding: 0 !important; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; border-radius: 8px; background-color: #16a34a; border: none; color: #fff;" title="Add New Category">
                                <i class="fa-solid fa-plus" style="font-size: 18px !important; color: #ffffff !important; line-height: 1 !important;"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 col-12">
                        <label for="modalProductSubCategory" style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 4px; display: block;">Sub-Category</label>
                        <div class="d-flex align-items-center w-100 gap-2">
                            <!-- Native select kept hidden for 100% backend & DOM compatibility -->
                            <select class="d-none" id="modalProductSubCategory">
                                <option value="none" selected>Select Sub-Category</option>
                            </select>

                            <!-- Custom Searchable Sub-Category Dropdown -->
                            <div class="custom-searchable-select flex-grow-1" id="modalSubCategoryDropdown">
                                <div class="select-trigger d-flex align-items-center justify-content-between px-3" onclick="toggleCustomProductDropdown('modalSubCategoryDropdown')">
                                    <span class="selected-text text-truncate" id="modalSubCategorySelectedText" style="font-size: 13px; font-weight: 500; color: #64748b;">Select Sub-Category</span>
                                    <i class="fa-solid fa-chevron-down ms-1 text-muted" style="font-size: 12px; transition: transform 0.2s;"></i>
                                </div>
                                <div class="select-menu">
                                    <div class="search-wrap">
                                        <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="top: 50%; transform: translateY(-50%); left: 10px; font-size: 12px;"></i>
                                        <input type="text" placeholder="Search Sub-Category..." oninput="filterCustomProductDropdown('modalSubCategoryDropdown', this.value)" autocomplete="off">
                                    </div>
                                    <div class="select-options-list" id="modalSubCategoryOptionsList">
                                        <!-- Sub-Category options will load here -->
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn-add newsubcategory-open text-nowrap" onclick="openSubCategorySubModal()" style="width: 42px; height: 42px; min-width: 42px; padding: 0 !important; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; border-radius: 8px; background-color: #16a34a; border: none; color: #fff;" title="Add New Sub-Category">
                                <i class="fa-solid fa-plus" style="font-size: 18px !important; color: #ffffff !important; line-height: 1 !important;"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Product Photo Upload Box -->
                <div class="row g-2.5 mb-2">
                    <div class="col-lg-12">
                        <label style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 4px; display: block;">Product Photo</label>
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <div id="modalProductImgBox" style="width: 84px; height: 70px; min-width: 84px; border-radius: 8px; background: #f8fafc; border: 1.5px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                                <i id="modalProductImgDefaultIcon" class="fa-regular fa-image" style="font-size: 26px; color: #94a3b8;"></i>
                                <img id="modalProductImgPreview" src="" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; display: none;" />
                            </div>
                            <div style="flex: 1;">
                                <label style="cursor: pointer; position: relative; width: 100%; height: 44px; border-radius: 8px; display: flex; justify-content: center; align-items: center; background: #f1f5f9; border: 1px solid #cbd5e1; font-size: 13px; font-weight: 600; color: #475569; gap: 6px;">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <span>Upload Photo</span>
                                    <input type="file" id="modalProductImageFile" onchange="previewPurchaseProductImage(this)" accept="image/*" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer;" />
                                </label>
                                <p style="margin: 4px 0 0 0; font-size: 11px; color: #94a3b8;">PNG, JPEG or GIF (up to 1 MB)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 3: Product Name* -->
                <div class="row g-2.5 mb-2">
                    <div class="col-lg-12">
                        <label for="modalProductName" style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 4px; display: block;">Product Name <span style="color: #ef4444;">*</span></label>
                        <input type="text" placeholder="Product Name *" id="modalProductName" required class="form-control" style="width: 100%; height: 42px; border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" />
                    </div>
                </div>

                <!-- Row 4: Quantity, Cost Price, Selling Price (3 columns) -->
                <div class="row g-2.5 mb-2">
                    <div class="col-lg-4 col-md-4 col-12">
                        <label for="modalProductQuantity" style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 4px; display: block;">Product Quantity</label>
                        <input type="number" step="1" placeholder="Quantity" id="modalProductQuantity" class="form-control" style="width: 100%; height: 42px; border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" />
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <label for="modalProductCostPrice" style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 4px; display: block;">Cost Price</label>
                        <input type="number" step="any" placeholder="Cost Price" id="modalProductCostPrice" class="form-control" style="width: 100%; height: 42px; border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" />
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <label for="modalProductSellingPrice" style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 4px; display: block;">Selling Price</label>
                        <input type="number" step="any" placeholder="Selling Price" id="modalProductSellingPrice" class="form-control" style="width: 100%; height: 42px; border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" />
                    </div>
                </div>

                <!-- Row 5: Barcode / Product Code + Camera Scan button -->
                <div class="row g-2.5 mb-2">
                    <div class="col-lg-12">
                        <label for="modalProductCodeInput" style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 4px; display: block;">Barcode / Product Code</label>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <input type="text" id="modalProductCodeInput" class="form-control" placeholder="Enter or scan barcode..." style="flex: 1; height: 42px; border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 8px 12px; font-size: 13.5px;" />
                            <button type="button" onclick="openPurchaseCameraScannerForSubmodal()" class="btn text-white fw-bold d-flex align-items-center gap-2 px-3" style="height: 42px; border-radius: 8px; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none; font-size: 13px; cursor: pointer;">
                                <i class="fa-solid fa-camera"></i>
                                <span>Camera Scan</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sticky Footer: Reset (Red) & Submit (Green) -->
                <div class="modal-footer px-0 pt-3 pb-0 d-flex align-items-center justify-content-end gap-2" style="border-top: 1px solid #e2e8f0; margin-top: 14px;">
                    <button type="button" onclick="resetPurchaseProductForm()" class="btn fw-semibold px-4" style="height: 38px; border-radius: 8px; font-size: 13.5px; background-color: #dc2626 !important; color: #ffffff !important; border: none !important; cursor: pointer;">Reset</button>
                    <button type="submit" class="btn text-white fw-bold px-5 shadow-sm" style="height: 38px; border-radius: 8px; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none; font-size: 13.5px; cursor: pointer;">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Product modal to Add New Brand Modal Start (Matching Image 2) -->
<div class="newbrand" id="purchaseAddBrandModal">
    <div class="newbrand-content">
        <div class="newmodal-header">
            <h3>Add New Brand</h3>
            <button type="button" class="newmodal-close-btn newbrand-close" onclick="closeBrandSubModal()" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="addBrandForm" onsubmit="saveBrandSubModal(event)">
            <div class="newmodal-upload-area">
                <div class="newmodal-img-preview" id="BrandImgBox">
                    <i class="fa-regular fa-image" id="BrandImgIcon"></i>
                    <img id="BrandImgPreview" src="" alt="Preview" style="display: none;" />
                </div>
                <div class="newmodal-upload-info">
                    <label for="CreateBrandImg" class="newmodal-file-btn">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Upload Photo
                    </label>
                    <input type="file" id="CreateBrandImg" accept="image/*" style="display: none;" onchange="previewBrandModalImage(this)" />
                    <p>PNG, JPG or GIF (up to 1 MB)</p>
                </div>
            </div>

            <div class="newmodal-form-group">
                <label class="newmodal-label" for="quickBrandName">Brand Name <span class="text-danger">*</span></label>
                <input type="text" id="quickBrandName" class="newmodal-input" placeholder="Enter brand name" required />
            </div>

            <div class="newmodal-form-group">
                <label class="newmodal-label" for="BrandSelectStatus">Status <span class="text-danger">*</span></label>
                <div class="newmodal-select-wrapper">
                    <select id="BrandSelectStatus" class="newmodal-select" required>
                        <option value="Active" selected>Active</option>
                        <option value="InActive">Inactive</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
            </div>

            <div class="newmodal-actions">
                <button type="button" class="newmodal-btn-cancel newbrand-close" onclick="closeBrandSubModal()">Cancel</button>
                <button type="submit" class="newmodal-btn-save">Save Brand</button>
            </div>
        </form>
    </div>
</div>
<!-- Add Product modal to New Brand Modal End -->

<!-- Add Product modal to New Category Modal Start (Matching Image 3) -->
<div class="newcategory" id="purchaseAddCategoryModal">
    <div class="newcategory-content">
        <div class="newmodal-header">
            <h3>Add New Category</h3>
            <button type="button" class="newmodal-close-btn newcategory-close" onclick="closeCategorySubModal()" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="addCategoryForm" onsubmit="saveCategorySubModal(event)">
            <div class="newmodal-upload-area">
                <div class="newmodal-img-preview" id="CategoryImgBox">
                    <i class="fa-regular fa-image" id="CategoryImgIcon"></i>
                    <img id="CategoryImgPreview" src="" alt="Preview" style="display: none;" />
                </div>
                <div class="newmodal-upload-info">
                    <label for="CategoryImg" class="newmodal-file-btn">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Upload Photo
                    </label>
                    <input type="file" id="CategoryImg" accept="image/*" style="display: none;" onchange="previewCategoryModalImage(this)" />
                    <p>PNG, JPG or GIF (up to 1 MB)</p>
                </div>
            </div>

            <div class="newmodal-form-group">
                <label class="newmodal-label" for="quickCategoryName">Category Name <span class="text-danger">*</span></label>
                <input type="text" id="quickCategoryName" class="newmodal-input" placeholder="Enter category name" required />
            </div>

            <div class="newmodal-form-group">
                <label class="newmodal-label" for="CategorySelectStatus">Status <span class="text-danger">*</span></label>
                <div class="newmodal-select-wrapper">
                    <select id="CategorySelectStatus" class="newmodal-select" required>
                        <option value="Active" selected>Active</option>
                        <option value="InActive">Inactive</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
            </div>

            <div class="newmodal-actions">
                <button type="button" class="newmodal-btn-cancel newcategory-close" onclick="closeCategorySubModal()">Cancel</button>
                <button type="submit" class="newmodal-btn-save">Save Category</button>
            </div>
        </form>
    </div>
</div>
<!-- Add Product modal to New Category Modal End -->

<!-- Add Product modal to New Sub-Category Modal Start (Matching Image 4) -->
<div class="newcategory" id="purchaseAddSubCategoryModal">
    <div class="newcategory-content">
        <div class="newmodal-header">
            <h3>Add New Sub-Category</h3>
            <button type="button" class="newmodal-close-btn newsubcategory-close" onclick="closeSubCategorySubModal()" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="addSubCategoryForm" onsubmit="saveSubCategorySubModal(event)">
            <div class="newmodal-form-group">
                <label class="newmodal-label">Category <span class="text-danger">*</span></label>
                <!-- Native select kept hidden for form validation & value retention -->
                <select id="SubCategoryParentID" class="d-none" required>
                    <option value="none" disabled selected>Select Category *</option>
                </select>
                <!-- Custom Searchable Dropdown for Sub-Category Category -->
                <div class="custom-subcategory-select" id="subCategoryCategoryDropdown">
                    <div class="select-trigger" onclick="toggleSubCategoryCategoryDropdown()">
                        <span class="selected-text text-truncate" id="subCategoryCategorySelectedText">Select Category *</span>
                        <i class="fa-solid fa-chevron-down ms-1"></i>
                    </div>
                    <div class="select-menu">
                        <div class="search-wrap">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="subCategoryCategorySearchInput" placeholder="Search Category..." oninput="filterSubCategoryCategoryOptions(this.value)" autocomplete="off">
                        </div>
                        <div class="select-options-list" id="subCategoryCategoryOptionsList">
                            <!-- Category options loaded dynamically -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="newmodal-form-group">
                <label class="newmodal-label" for="quickSubCategoryName">Sub-Category Name <span class="text-danger">*</span></label>
                <input type="text" id="quickSubCategoryName" class="newmodal-input" placeholder="Enter sub-category name" required />
            </div>

            <div class="newmodal-form-group">
                <label class="newmodal-label" for="SubCategorySelectStatus">Status <span class="text-danger">*</span></label>
                <div class="newmodal-select-wrapper">
                    <select id="SubCategorySelectStatus" class="newmodal-select" required>
                        <option value="Active" selected>Active</option>
                        <option value="InActive">Inactive</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
            </div>

            <div class="newmodal-actions">
                <button type="button" class="newmodal-btn-cancel newsubcategory-close" onclick="closeSubCategorySubModal()">Cancel</button>
                <button type="submit" class="newmodal-btn-save">Save Sub-Category</button>
            </div>
        </form>
    </div>
</div>
<!-- Add Product modal to New Sub-Category Modal End -->

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

    /* Search and Date field placeholder */
    #searchInput, #startDate, #endDate, .flatpickr-input, .date-input-wrapper input, .search-input-wrapper input {
        font-size: 11px !important;
        font-weight: 500 !important;
    }
    #searchInput::placeholder, #startDate::placeholder, #endDate::placeholder, .flatpickr-input::placeholder,
    .date-input-wrapper input::placeholder, .search-input-wrapper input::placeholder {
        font-size: 11px !important;
        font-weight: 400 !important;
        color: #94a3b8 !important;
        opacity: 1 !important;
    }

    /* Table headers & cells 5px left-right padding */
    #printTable thead th {
        font-size: 11px !important;
        font-weight: 600 !important;
        line-height: 1.25 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.025em !important;
        padding-left: 5px !important;
        padding-right: 5px !important;
        background-color: #15803d !important;
        color: #ffffff !important;
        white-space: nowrap !important;
    }

    #printTable tbody td {
        padding: 8px 5px !important;
        vertical-align: middle !important;
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
    .btn-create-purchase *,
    #openModalBtns * {
        color: #ffffff !important;
    }

    /* Unified UI Border */
    .unified-ui-border {
        border: 1px solid #cbd5e1 !important;
    }
    body[light-mode="dark"] .unified-ui-border,
    html.dark .unified-ui-border {
        border: 1px solid #334155 !important;
    }

    /* Dropdown Menus */
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
    .custom-filter-dropdown .select-menu {
        display: none;
        position: absolute !important;
        top: calc(100% + 6px) !important;
        right: 0 !important;
        left: auto !important;
        min-width: 170px !important;
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

    /* Smart Pagination */
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

    /* ========================================================
       Purchase Product Modal Styling Matching Retail Exactly
       ======================================================== */
    #purchaseCreateModal .modal-dialog {
        max-width: 1080px !important;
        width: 95% !important;
        margin: 1.75rem auto !important;
        padding: 0 !important;
    }

    #purchaseCreateModal .modal-content {
        border-radius: 16px !important;
        border: none !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35) !important;
        overflow: hidden;
        background: #ffffff;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        padding: 0 !important;
    }

    body[light-mode="dark"] #purchaseCreateModal .modal-content,
    html[light-mode="dark"] #purchaseCreateModal .modal-content,
    body[data-layout-mode="dark"] #purchaseCreateModal .modal-content,
    html.dark #purchaseCreateModal .modal-content,
    body.dark #purchaseCreateModal .modal-content,
    body.dark-mode #purchaseCreateModal .modal-content {
        background-color: #0f172a !important;
        color: #f8fafc !important;
    }

    body[light-mode="dark"] #purchaseCreateModal .purchase-modal-body,
    html[light-mode="dark"] #purchaseCreateModal .purchase-modal-body,
    html.dark #purchaseCreateModal .purchase-modal-body,
    body.dark #purchaseCreateModal .purchase-modal-body {
        background-color: #0f172a !important;
    }

    body[light-mode="dark"] #purchaseCreateModal .purchase-modal-footer,
    html[light-mode="dark"] #purchaseCreateModal .purchase-modal-footer,
    html.dark #purchaseCreateModal .purchase-modal-footer,
    body.dark #purchaseCreateModal .purchase-modal-footer {
        background-color: #0f172a !important;
        border-top-color: #334155 !important;
    }

    body[light-mode="dark"] #purchaseCreateModal .purchase-clean-card,
    html.dark #purchaseCreateModal .purchase-clean-card,
    body.dark #purchaseCreateModal .purchase-clean-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #purchaseCreateModal .form-control,
    body[light-mode="dark"] #purchaseCreateModal .form-select,
    html.dark #purchaseCreateModal .form-control,
    html.dark #purchaseCreateModal .form-select {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] #supplierDropdownList,
    html.dark #supplierDropdownList,
    body.dark #supplierDropdownList {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #supplierDropdownList .supplier-select-item:hover,
    html.dark #supplierDropdownList .supplier-select-item:hover,
    body.dark #supplierDropdownList .supplier-select-item:hover {
        background-color: #0f172a !important;
    }

    body[light-mode="dark"] #purchaseCreateModal .table-container,
    html.dark #purchaseCreateModal .table-container,
    body.dark #purchaseCreateModal .table-container {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #purchaseCreateModal .responsive-table th,
    html.dark #purchaseCreateModal .responsive-table th {
        background-color: #0f172a !important;
        color: #ffffff !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #purchaseCreateModal .responsive-table td,
    html.dark #purchaseCreateModal .responsive-table td {
        border-color: #334155 !important;
        color: #ffffff !important;
    }

    .modern-select-dropdown {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2310b981' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 12px center !important;
        background-size: 14px 10px !important;
        padding-right: 36px !important;
        appearance: none !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
    }

    #productDropdown:empty {
        display: none !important;
    }

    #productDropdown .list-group-item {
        padding: 8px 12px;
        transition: all 0.15s ease;
        border-color: #e2e8f0;
    }

    #productDropdown .list-group-item:hover {
        background-color: #f1f5f9 !important;
    }

    body[light-mode="dark"] #productDropdown,
    html.dark #productDropdown,
    body.dark #productDropdown {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #productDropdown .list-group-item,
    html.dark #productDropdown .list-group-item,
    body.dark #productDropdown .list-group-item {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }

    body[light-mode="dark"] #productDropdown .list-group-item:hover,
    html.dark #productDropdown .list-group-item:hover,
    body.dark #productDropdown .list-group-item:hover {
        background-color: #0f172a !important;
    }

    .partial-payment-status {
        background-color: #fef3c7;
        color: #92400e;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: bold;
        font-size: 12px;
    }

    .fully-paid-status {
        background-color: #dcfce7;
        color: #166534;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: bold;
        font-size: 12px;
    }

    /* ========================================================
       Reset legacy styles on confirmationModal (Delete Modal)
       Eliminates duplicate white box and centers on viewport
       ======================================================== */
    #confirmationModal.modal {
        display: none;
        background: rgba(15, 23, 42, 0.6) !important;
        backdrop-filter: blur(4px) !important;
        -webkit-backdrop-filter: blur(4px) !important;
        z-index: 1060 !important;
    }
    #confirmationModal.modal.show {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    #confirmationModal .modal-dialog {
        position: static !important;
        top: auto !important;
        left: auto !important;
        transform: none !important;
        margin: auto !important;
        max-width: 420px !important;
        width: 92% !important;
        background: transparent !important;
        background-color: transparent !important;
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
        min-width: auto !important;
        overflow: visible !important;
    }
    #confirmationModal .modal-content {
        background: #ffffff !important;
        border-radius: 20px !important;
        border: 1px solid rgba(226, 232, 240, 0.8) !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        padding: 28px 24px 24px !important;
        text-align: center !important;
        position: relative !important;
        overflow: hidden !important;
        margin: 0 !important;
        width: 100% !important;
    }
    body[light-mode="dark"] #confirmationModal .modal-content,
    html.dark #confirmationModal .modal-content,
    body.dark #confirmationModal .modal-content {
        background: #0f172a !important;
        color: #ffffff !important;
        border: 1px solid #1e293b !important;
    }

    /* ========================================================
       Protect button hover across all Supplier and Purchase pages
       Keep solid emerald #166534 hover, prevents turning white
       ======================================================== */
    #openModalBtns,
    .btn-create-purchase,
    .btn-create-supplier,
    .btn-save,
    .save-btn {
        background-color: #15803d !important;
        color: #ffffff !important;
        border: 1px solid #15803d !important;
    }

    #openModalBtns:hover,
    #openModalBtns:focus,
    .btn-create-purchase:hover,
    .btn-create-purchase:focus,
    .btn-create-supplier:hover,
    .btn-create-supplier:focus,
    .btn-save:hover,
    .btn-save:focus,
    .save-btn:hover,
    .save-btn:focus,
    .data-table #openModalBtns:hover,
    .data-table #openModalBtns:focus {
        background-color: #166534 !important;
        background: #166534 !important;
        color: #ffffff !important;
        border-color: #166534 !important;
    }
    #openModalBtns svg,
    #openModalBtns i,
    .btn-create-purchase svg,
    .btn-create-purchase i,
    .btn-create-supplier svg,
    .btn-create-supplier i {
        color: #ffffff !important;
        stroke: #ffffff !important;
    }

    /* Sub-Modals (Supplier & Product on top of Purchase Modal) */
    .purchase-submodal {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        margin: 0 !important;
        padding: 15px !important;
        background: rgba(0, 0, 0, 0.65) !important;
        display: none;
        align-items: center !important;
        justify-content: center !important;
        z-index: 1070 !important;
        box-sizing: border-box !important;
        backdrop-filter: blur(2px) !important;
        -webkit-backdrop-filter: blur(2px) !important;
    }
    .purchase-submodal.show {
        display: flex !important;
    }
    .purchase-submodal-content {
        position: relative !important;
        margin: auto !important;
        animation: submodalFadeIn 0.2s ease-out;
    }
    @keyframes submodalFadeIn {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }
    body[light-mode="dark"] .purchase-submodal-content,
    html.dark .purchase-submodal-content,
    body.dark .purchase-submodal-content {
        background-color: #0f172a !important;
        color: #f8fafc !important;
        border: 1px solid #334155 !important;
    }
    body[light-mode="dark"] .purchase-submodal-body,
    html.dark .purchase-submodal-body,
    body.dark .purchase-submodal-body {
        background-color: #0f172a !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .purchase-submodal input,
    body[light-mode="dark"] .purchase-submodal select,
    html.dark .purchase-submodal input,
    html.dark .purchase-submodal select {
        background-color: #1e293b !important;
        color: #f8fafc !important;
        border-color: #334155 !important;
    }

    /* ========================================================
       Retail Parity: Add New Brand/Category/Sub-Category Styles
       ======================================================== */
    .btn-add {
        width: 42px !important;
        height: 42px !important;
        min-width: 42px !important;
        padding: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
        border-radius: 8px !important;
        background-color: #16a34a !important;
        border: none !important;
        color: #ffffff !important;
        transition: all 0.2s ease !important;
    }
    .btn-add:hover {
        background-color: #15803d !important;
        opacity: 0.95 !important;
    }
    .btn-add i {
        font-size: 18px !important;
        color: #ffffff !important;
        line-height: 1 !important;
        font-weight: 700 !important;
    }

    /* Custom Searchable Select for Product Modal (Brand, Category, Sub-Category) */
    .custom-searchable-select {
        position: relative !important;
        width: 100% !important;
        user-select: none;
    }
    .custom-searchable-select .select-trigger {
        height: 42px;
        border-radius: 8px;
        cursor: pointer !important;
        border: 1px solid #cbd5e1 !important;
        background: #ffffff;
        transition: all 0.2s ease;
        user-select: none;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 14px;
    }
    .custom-searchable-select .select-trigger:hover {
        border-color: #16a34a !important;
    }
    .custom-searchable-select.is-open .select-trigger {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.15) !important;
    }
    .custom-searchable-select .select-trigger .selected-text {
        font-size: 13px;
        font-weight: 500;
        color: #64748b;
    }
    .custom-searchable-select .select-trigger .selected-text.has-value {
        color: #0f172a;
        font-weight: 600;
    }
    .custom-searchable-select .select-menu {
        display: none;
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        width: 100%;
        min-width: 100%;
        z-index: 1080 !important;
        background: #ffffff !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 10px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.25), 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        padding: 6px;
    }
    .custom-searchable-select.is-open .select-menu {
        display: block !important;
    }
    .custom-searchable-select .search-wrap {
        padding: 4px 6px;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 4px;
        position: relative;
        background: #ffffff !important;
        z-index: 2;
    }
    .custom-searchable-select .search-wrap input {
        height: 34px !important;
        font-size: 13px !important;
        border-radius: 6px !important;
        border: 1px solid #cbd5e1 !important;
        padding-left: 28px !important;
        padding-right: 8px !important;
        width: 100% !important;
        outline: none !important;
        box-sizing: border-box !important;
        background: #ffffff !important;
        color: #0f172a !important;
    }
    .custom-searchable-select .search-wrap input:focus {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.1) !important;
    }
    .custom-searchable-select .select-options-list {
        max-height: 180px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }
    .custom-searchable-select .select-option-item {
        padding: 8px 10px;
        font-size: 13px;
        cursor: pointer !important;
        border-radius: 6px;
        margin: 1px 2px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #334155;
        transition: all 0.15s ease;
    }
    .custom-searchable-select .select-option-item:hover {
        background-color: #f0fdf4;
        color: #15803d;
    }
    .custom-searchable-select .select-option-item.active {
        background-color: #dcfce7;
        color: #15803d;
        font-weight: 700;
    }

    /* Clean Modern Sub-Modal Styling for Add New Brand, Add New Category & Sub-Category */
    .newbrand,
    .newcategory,
    #purchaseAddBrandModal,
    #purchaseAddCategoryModal,
    #purchaseAddSubCategoryModal {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        margin: 0 !important;
        padding: 0 !important;
        background: rgba(15, 23, 42, 0.75) !important;
        display: none;
        justify-content: center !important;
        align-items: center !important;
        z-index: 100000000 !important;
        backdrop-filter: blur(6px) !important;
        -webkit-backdrop-filter: blur(6px) !important;
    }
    .newbrand.show,
    .newcategory.show,
    #purchaseAddBrandModal.show,
    #purchaseAddCategoryModal.show,
    #purchaseAddSubCategoryModal.show {
        display: flex !important;
        opacity: 1 !important;
        visibility: visible !important;
        z-index: 100000000 !important;
    }
    .newbrand-content,
    .newcategory-content,
    .newbrand.show .newbrand-content,
    .newcategory.show .newcategory-content,
    #purchaseAddBrandModal .newbrand-content,
    #purchaseAddCategoryModal .newcategory-content,
    #purchaseAddSubCategoryModal .newcategory-content {
        position: relative !important;
        top: auto !important;
        left: auto !important;
        right: auto !important;
        bottom: auto !important;
        transform: none !important;
        margin: auto !important;
        background: #ffffff !important;
        padding: 24px 28px !important;
        border-radius: 16px !important;
        width: 440px !important;
        max-width: 90vw !important;
        max-height: 90vh !important;
        overflow-y: auto !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35) !important;
        border: 1px solid #f1f5f9;
        z-index: 100000001 !important;
    }
    .newmodal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }
    .newmodal-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    .newmodal-close-btn {
        background: #ef4444 !important;
        color: #ffffff !important;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .newmodal-close-btn:hover {
        background: #dc2626 !important;
        color: #ffffff !important;
    }
    .newmodal-close-btn i {
        color: #ffffff !important;
        font-size: 14px !important;
    }
    .newmodal-upload-area {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
        background: #f8fafc;
        padding: 14px;
        border-radius: 12px;
        border: 1px dashed #cbd5e1;
    }
    .newmodal-img-preview {
        width: 72px;
        height: 72px;
        border-radius: 10px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
    .newmodal-img-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .newmodal-img-preview i {
        font-size: 26px;
        color: #94a3b8;
    }
    .newmodal-upload-info {
        flex: 1;
    }
    .newmodal-file-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 14px;
        background: #ffffff;
        color: #334155;
        font-size: 13px;
        font-weight: 600;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    .newmodal-file-btn:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }
    .newmodal-upload-info p {
        margin: 6px 0 0 0;
        font-size: 11px;
        color: #64748b;
    }
    .newmodal-form-group {
        margin-bottom: 16px;
    }
    .newmodal-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }
    .newmodal-input,
    .newmodal-select {
        width: 100%;
        height: 42px;
        padding: 8px 14px;
        font-size: 14px;
        color: #1e293b;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        outline: none;
        transition: all 0.2s ease;
    }
    .newmodal-input:focus,
    .newmodal-select:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15);
    }
    .newmodal-select-wrapper {
        position: relative;
        width: 100%;
    }
    .newmodal-select-wrapper select {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 36px;
    }
    .newmodal-select-wrapper i {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: #64748b;
        font-size: 12px;
    }

    /* Custom Searchable Dropdown for Sub-Category Modal */
    .custom-subcategory-select {
        position: relative !important;
        width: 100% !important;
        user-select: none;
    }
    .custom-subcategory-select .select-trigger {
        height: 42px;
        border-radius: 8px;
        cursor: pointer !important;
        border: 1px solid #cbd5e1 !important;
        background: #ffffff;
        transition: all 0.2s ease;
        user-select: none;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 14px;
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
    }
    .custom-subcategory-select .select-trigger:hover {
        border-color: #16a34a !important;
    }
    .custom-subcategory-select.is-open .select-trigger {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.15) !important;
    }
    .custom-subcategory-select .select-trigger i.fa-chevron-down {
        font-size: 12px;
        color: #64748b;
        transition: transform 0.2s ease;
    }
    .custom-subcategory-select.is-open .select-trigger i.fa-chevron-down {
        transform: rotate(180deg);
    }
    .custom-subcategory-select .select-trigger .selected-text {
        font-size: 14px;
        font-weight: 500;
        color: #64748b;
    }
    .custom-subcategory-select .select-trigger .selected-text.has-value {
        color: #0f172a;
        font-weight: 600;
    }
    .custom-subcategory-select .select-menu {
        display: none;
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        width: 100%;
        min-width: 100%;
        z-index: 100000005 !important;
        background: #ffffff !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 10px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.25), 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        padding: 6px;
    }
    .custom-subcategory-select.is-open .select-menu {
        display: block !important;
    }
    .custom-subcategory-select .search-wrap {
        padding: 4px 6px;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 4px;
        position: relative;
        background: #ffffff !important;
        z-index: 2;
    }
    .custom-subcategory-select .search-wrap i {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 14px;
        font-size: 12px;
        color: #94a3b8;
        pointer-events: none;
    }
    .custom-subcategory-select .search-wrap input {
        height: 34px !important;
        font-size: 13px !important;
        border-radius: 6px !important;
        border: 1px solid #cbd5e1 !important;
        padding-left: 32px !important;
        padding-right: 8px !important;
        width: 100% !important;
        outline: none !important;
        box-sizing: border-box !important;
        background: #ffffff !important;
        color: #0f172a !important;
        line-height: normal !important;
    }
    .custom-subcategory-select .search-wrap input:focus {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.1) !important;
    }
    .custom-subcategory-select .select-options-list {
        max-height: 180px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }
    .custom-subcategory-select .select-option-item {
        padding: 8px 10px;
        font-size: 13px;
        cursor: pointer !important;
        border-radius: 6px;
        margin: 1px 2px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #334155;
        transition: all 0.15s ease;
        user-select: none;
    }
    .custom-subcategory-select .select-option-item:hover {
        background-color: #f0fdf4;
        color: #15803d;
    }
    .custom-subcategory-select .select-option-item.active {
        background-color: #dcfce7;
        color: #15803d;
        font-weight: 700;
    }

    /* Modal Action Buttons */
    .newmodal-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 22px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }
    .newmodal-btn-cancel {
        padding: 9px 18px;
        font-size: 13px;
        font-weight: 600;
        color: #ffffff !important;
        background: #ef4444 !important;
        border: 1px solid #ef4444 !important;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .newmodal-btn-cancel:hover {
        background: #dc2626 !important;
        border-color: #dc2626 !important;
        color: #ffffff !important;
    }
    .newmodal-btn-save {
        padding: 9px 22px;
        font-size: 13px;
        font-weight: 600;
        color: #ffffff;
        background: linear-gradient(135deg, #16a34a, #15803d);
        border: none;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);
        transition: all 0.2s ease;
    }
    .newmodal-btn-save:hover {
        background: linear-gradient(135deg, #15803d, #166534);
        box-shadow: 0 6px 16px rgba(22, 163, 74, 0.35);
        transform: translateY(-1px);
    }

    /* Dark Mode Overrides for Add Brand/Category/Sub-Category Modals */
    body[light-mode="dark"] .newbrand-content,
    body[light-mode="dark"] .newcategory-content,
    html.dark .newbrand-content,
    html.dark .newcategory-content {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .newmodal-header,
    html.dark .newmodal-header {
        border-bottom-color: #1e293b !important;
    }
    body[light-mode="dark"] .newmodal-header h3,
    html.dark .newmodal-header h3 {
        color: #ffffff !important;
    }
    body[light-mode="dark"] .newmodal-upload-area,
    html.dark .newmodal-upload-area {
        background: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .newmodal-img-preview,
    html.dark .newmodal-img-preview {
        background: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .newmodal-file-btn,
    html.dark .newmodal-file-btn {
        background: #0f172a !important;
        color: #cbd5e1 !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .newmodal-label,
    html.dark .newmodal-label {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .newmodal-input,
    body[light-mode="dark"] .newmodal-select,
    html.dark .newmodal-input,
    html.dark .newmodal-select {
        background: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .newmodal-actions,
    html.dark .newmodal-actions {
        border-top-color: #1e293b !important;
    }
    body[light-mode="dark"] .custom-searchable-select .select-trigger,
    html.dark .custom-searchable-select .select-trigger,
    body[light-mode="dark"] .custom-subcategory-select .select-trigger,
    html.dark .custom-subcategory-select .select-trigger {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .custom-searchable-select .select-trigger .selected-text,
    html.dark .custom-searchable-select .select-trigger .selected-text,
    body[light-mode="dark"] .custom-subcategory-select .select-trigger .selected-text,
    html.dark .custom-subcategory-select .select-trigger .selected-text {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .custom-searchable-select .select-menu,
    html.dark .custom-searchable-select .select-menu,
    body[light-mode="dark"] .custom-subcategory-select .select-menu,
    html.dark .custom-subcategory-select .select-menu {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.6) !important;
    }
    body[light-mode="dark"] .custom-searchable-select .search-wrap,
    html.dark .custom-searchable-select .search-wrap,
    body[light-mode="dark"] .custom-subcategory-select .search-wrap,
    html.dark .custom-subcategory-select .search-wrap {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .custom-searchable-select .search-wrap input,
    html.dark .custom-searchable-select .search-wrap input,
    body[light-mode="dark"] .custom-subcategory-select .search-wrap input,
    html.dark .custom-subcategory-select .search-wrap input {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .custom-searchable-select .select-option-item,
    html.dark .custom-searchable-select .select-option-item,
    body[light-mode="dark"] .custom-subcategory-select .select-option-item,
    html.dark .custom-subcategory-select .select-option-item {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .custom-searchable-select .select-option-item:hover,
    html.dark .custom-searchable-select .select-option-item:hover,
    body[light-mode="dark"] .custom-subcategory-select .select-option-item:hover,
    html.dark .custom-subcategory-select .select-option-item:hover {
        background-color: #334155 !important;
        color: #ffffff !important;
    }
</style>

<script>
    let rawPurchaseData = [];
    let suppliersList = [];
    let productsList = [];
    let currentPage = 1;
    let pageSize = 15;
    let startPicker = null;
    let endPicker = null;
    let createDatePicker = null;
    let editDatePicker = null;
    let currentEditReturnAdj = 0;

    function initPurchaseFlatpickr() {
        if (window.flatpickr) {
            startPicker = flatpickr("#startDate", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                altInputClass: "w-full bg-transparent border-0 outline-none text-[11px] font-medium text-slate-700 dark:text-slate-200 placeholder:text-[11px] placeholder:font-normal placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 cursor-pointer",
                allowInput: false,
                disableMobile: true,
                onChange: function(selectedDates, dateStr) {
                    if (endPicker && selectedDates[0]) {
                        endPicker.set('minDate', selectedDates[0]);
                    }
                    currentPage = 1;
                    renderPaginatedList();
                }
            });

            endPicker = flatpickr("#endDate", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                altInputClass: "w-full bg-transparent border-0 outline-none text-[11px] font-medium text-slate-700 dark:text-slate-200 placeholder:text-[11px] placeholder:font-normal placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 cursor-pointer",
                allowInput: false,
                disableMobile: true,
                onChange: function(selectedDates, dateStr) {
                    if (startPicker && selectedDates[0]) {
                        startPicker.set('maxDate', selectedDates[0]);
                    }
                    currentPage = 1;
                    renderPaginatedList();
                }
            });

            createDatePicker = flatpickr("#createPurchaseDate", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                altInputClass: "form-control rounded-xl text-xs sm:text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px] border-slate-300",
                defaultDate: new Date().toISOString().split('T')[0],
                disableMobile: true
            });

            editDatePicker = flatpickr("#editPurchaseDate", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                altInputClass: "form-control rounded-xl text-xs sm:text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px] border-slate-300",
                disableMobile: true
            });
        }
    }

    function toggleCustomPurchaseFilter() {
        const dropdown = document.getElementById('purchaseFilterDropdown');
        if (!dropdown) return;
        dropdown.classList.toggle('is-open');
        const chevron = dropdown.querySelector('.chevron-icon');
        if (chevron) {
            chevron.style.transform = dropdown.classList.contains('is-open') ? 'rotate(180deg)' : 'rotate(0deg)';
        }
    }

    function selectPurchaseFilterOption(e, filterVal, label) {
        if (e) e.preventDefault();
        const dropdown = document.getElementById('purchaseFilterDropdown');
        if (dropdown) {
            const labelSpan = document.getElementById('selectedPurchaseFilterLabel');
            if (labelSpan) labelSpan.textContent = label;

            dropdown.querySelectorAll('.select-option-item').forEach(item => {
                if (item.getAttribute('data-filter') === filterVal) {
                    item.classList.add('active');
                    if (!item.querySelector('.check-icon')) {
                        const check = document.createElement('i');
                        check.className = 'fa-solid fa-check small text-emerald-600 check-icon';
                        item.appendChild(check);
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
        $("#entries").val("15");
        initPurchaseFlatpickr();
        loadPrerequisites();
        getList();
        refreshSupplierList();
        setupProductSearchAndCart();

        // Searchable supplier input dropdown events
        const suppInput = document.getElementById("supplierSearchInput");
        const suppList = document.getElementById("supplierDropdownList");
        if (suppInput && suppList) {
            suppInput.addEventListener("focus", function() {
                renderSupplierDropdownItems(allSuppliersData);
                suppList.style.display = "block";
            });
            suppInput.addEventListener("input", function() {
                const query = this.value.trim().toLowerCase();
                if (!query) {
                    renderSupplierDropdownItems(allSuppliersData);
                    suppList.style.display = "block";
                    return;
                }
                const filtered = allSuppliersData.filter(s =>
                    (s.name && s.name.toLowerCase().includes(query)) ||
                    (s.supplier_id && s.supplier_id.toLowerCase().includes(query)) ||
                    (s.mobile && s.mobile.includes(query))
                );
                renderSupplierDropdownItems(filtered);
                suppList.style.display = "block";
            });
            document.addEventListener("click", function(e) {
                const wrapper = document.getElementById("searchableSupplierWrapper");
                if (wrapper && !wrapper.contains(e.target)) {
                    suppList.style.display = "none";
                }
            });
        }

        // Initialize today's date for PurchaseDate
        const pDateInput = document.getElementById('PurchaseDate');
        if (pDateInput && !pDateInput.value) {
            const now = new Date();
            const d = String(now.getDate()).padStart(2, '0');
            const m = String(now.getMonth() + 1).padStart(2, '0');
            const y = now.getFullYear();
            pDateInput.value = `${d}-${m}-${y}`;
        }
        initCreateDatePicker();

        $('#purchaseCreateModal').on('shown.bs.modal', function () {
            initCreateDatePicker();
            refreshSupplierList();
        });

        $('#purchaseUpdateModal').on('shown.bs.modal', function () {
            initUpdateDatePicker();
            setupUpdateSupplierSearch();
        });

        // Global outside click listener for custom dropdowns
        document.addEventListener("click", function(e) {
            document.querySelectorAll('.custom-searchable-select.is-open').forEach(el => {
                if (!el.contains(e.target)) el.classList.remove('is-open');
            });
            const subCatDropdown = document.getElementById('subCategoryCategoryDropdown');
            if (subCatDropdown && subCatDropdown.classList.contains('is-open') && !subCatDropdown.contains(e.target)) {
                subCatDropdown.classList.remove('is-open');
            }
        });

        // Append modals to body so stacking context / overflows never offset them
        $('#confirmationModal').appendTo('body');
        $('#purchaseCreateModal').appendTo('body');
        $('#purchaseUpdateModal').appendTo('body');
        $('#purchaseCameraScanModal').appendTo('body');
        $('#purchaseSupplierCreateModal').appendTo('body');
        $('#purchaseProductCreateModal').appendTo('body');
        $('#purchaseAddBrandModal').appendTo('body');
        $('#purchaseAddCategoryModal').appendTo('body');
        $('#purchaseAddSubCategoryModal').appendTo('body');

        $("#searchInput").on("keyup search input", function () {
            currentPage = 1;
            renderPaginatedList();
        });

        $("#entries").on("change", function () {
            pageSize = parseInt($(this).val()) || 15;
            currentPage = 1;
            renderPaginatedList();
        });
    });

    async function loadPrerequisites() {
        try {
            const [sRes, pRes] = await Promise.all([
                axios.get('/api/battery/supplier-list', HeaderToken()),
                axios.get('/api/battery/product-list', HeaderToken())
            ]);

            if (sRes.data && sRes.data.status === 'success') {
                suppliersList = sRes.data.data || sRes.data.SupplierData || [];
                let sOpts = '<option value="">Select Supplier</option>';
                suppliersList.forEach(s => {
                    const code = s.supplier_id ? ` (${s.supplier_id})` : '';
                    sOpts += `<option value="${s.id}">${s.name}${code}</option>`;
                });
                $('#createPurchaseSupplier').html(sOpts);
                $('#editPurchaseSupplier').html(sOpts);
            }

            if (pRes.data && pRes.data.status === 'success') {
                productsList = pRes.data.ProductData || [];
            }
        } catch (e) {
            console.error("Error loading prerequisites:", e);
        }
    }

    async function getList() {
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.get("/api/battery/purchases-list", HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            rawPurchaseData = res.data.PurchasessData || res.data.rows || [];
            if (Array.isArray(rawPurchaseData)) {
                rawPurchaseData.sort((a, b) => (parseInt(b.id) || 0) - (parseInt(a.id) || 0));
            }
            renderPaginatedList();
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
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

                // Desktop Row (14 Columns, action with 3-dot dropdown on far right)
                let row = `
                    <tr data-row="${realIndex + 1}" class="hover:bg-slate-50/80 dark:hover:bg-slate-800/60 transition-colors">
                        <td class="py-2 px-[5px] text-center font-semibold text-slate-500 dark:text-slate-400 text-[11px]">${realIndex + 1}</td>
                        <td class="py-2 px-[5px] text-center">${imgHtml}</td>
                        <td class="py-2 px-[5px] text-center font-medium text-slate-600 dark:text-slate-300 text-[11px] lg:text-xs whitespace-nowrap">${item.date || 'N/A'}</td>
                        <td class="py-2 px-[5px] text-center font-bold text-emerald-700 dark:text-emerald-400 text-[11px] lg:text-xs whitespace-nowrap">${item.purchase_id || 'N/A'}</td>
                        <td class="py-2 px-[5px] text-start font-medium text-slate-500 dark:text-slate-400 text-[11px] lg:text-xs whitespace-nowrap">${item.referance_no || '-'}</td>
                        <td class="py-2 px-[5px] text-start whitespace-nowrap">
                            ${item.supplier_db_id ? `
                                <a href="/battery/supplier/profile/${item.supplier_db_id}" class="inline-flex items-center gap-1 font-semibold text-emerald-700 dark:text-emerald-400 hover:underline text-[11px] lg:text-xs">
                                    <i class="fa-solid fa-truck-field text-[10px]"></i>
                                    <span>${item.supplier_id || 'N/A'}</span>
                                </a>
                            ` : `<span class="text-slate-400">${item.supplier_id || 'N/A'}</span>`}
                        </td>
                        <td class="py-2 px-[5px] text-start font-bold text-slate-800 dark:text-slate-100 text-[11px] lg:text-xs max-w-[120px] truncate" title="${item.supplier || ''}">
                            ${item.supplier_db_id ? `
                                <a href="/battery/supplier/profile/${item.supplier_db_id}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                                    ${item.supplier || 'N/A'}
                                </a>
                            ` : (item.supplier || 'N/A')}
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
                                <button class="w-[26px] h-[26px] rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center shadow-sm transition-all duration-150 mx-auto cursor-pointer" type="button" data-bs-toggle="dropdown" data-bs-display="static" data-bs-boundary="viewport" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical text-xs"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-xl border border-slate-200 dark:border-slate-700 rounded-xl p-1 bg-white dark:bg-slate-800 text-xs" style="min-width: 145px; z-index: 99999;">
                                    <li>
                                        <a class="dropdown-item rounded-lg px-2.5 py-1.5 flex items-center gap-2 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700/60 font-medium" href="/battery/purchase-invoice/${item.id}">
                                            <i class="fa-solid fa-eye text-emerald-600 dark:text-emerald-400 w-4 text-center"></i>
                                            <span>View Memo</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-lg px-2.5 py-1.5 flex items-center gap-2 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700/60 font-medium edit-link" href="javascript:void(0)" onclick="openEditPurchaseModal(${item.id})">
                                            <i class="fa-solid fa-pen-to-square text-amber-500 w-4 text-center"></i>
                                            <span>Edit</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-lg px-2.5 py-1.5 flex items-center gap-2 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700/60 font-medium" href="/battery/purchase-return/${item.id}">
                                            <i class="fa-solid fa-rotate-left text-indigo-500 w-4 text-center"></i>
                                            <span>Return</span>
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1 border-slate-200 dark:border-slate-700"></li>
                                    <li>
                                        <a class="dropdown-item rounded-lg px-2.5 py-1.5 flex items-center gap-2 text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 font-medium" href="javascript:void(0)" onclick="openDeletePurchaseModal(${item.id})">
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
                            <a href="/battery/purchase-invoice/${item.id}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 dark:bg-indigo-950/40 dark:hover:bg-indigo-900/50 dark:text-indigo-400 text-xs font-semibold rounded-lg border border-indigo-200 dark:border-indigo-800/40 transition-colors">
                                <i class="fa-solid fa-eye text-xs"></i>
                                <span>View Memo</span>
                            </a>
                            <div class="flex items-center gap-1.5">
                                <button onclick="openEditPurchaseModal(${item.id})" class="w-[32px] h-[32px] rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 flex items-center justify-center transition-all shadow-sm" title="Edit Purchase">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <a href="/battery/purchase-return/${item.id}" class="w-[32px] h-[32px] rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-600 border border-indigo-200 flex items-center justify-center transition-all shadow-sm" title="Purchase Return">
                                    <i class="fa-solid fa-rotate-left text-xs"></i>
                                </a>
                                <button onclick="openDeletePurchaseModal(${item.id})" class="w-[32px] h-[32px] rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 flex items-center justify-center transition-all shadow-sm" title="Delete Purchase">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
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
    }

    function openImagePopup(src, title) {
        document.getElementById('imagePreviewSrc').src = src;
        const modal = document.getElementById('imagePreviewModal');
        modal.style.display = 'flex';
    }

    function closeImagePopup() {
        document.getElementById('imagePreviewModal').style.display = 'none';
        document.getElementById('imagePreviewSrc').src = '';
    }

    // ==========================================
    // RETAIL MATCHED PURCHASE PRODUCT WORKFLOW
    // ==========================================
    window.createPurchaseDatepicker = null;
    let allSuppliersData = [];
    let UpdatebarcodeLists = {};
    let debounceTimer;

    function initCreateDatePicker() {
        const dateInput = document.getElementById("PurchaseDate");
        if (dateInput && typeof flatpickr !== "undefined") {
            if (window.createPurchaseDatepicker) {
                window.createPurchaseDatepicker.destroy();
            }
            window.createPurchaseDatepicker = flatpickr(dateInput, {
                dateFormat: "d-m-Y",
                allowInput: true,
                clickOpens: true,
                disableMobile: true
            });
        }
    }

    // ========================================================
    // Sub-Modal: Supplier & Product Creation from Purchase Form
    // ========================================================
    function openSupplierCreateModal() {
        const modal = document.getElementById('purchaseSupplierCreateModal');
        if (modal) {
            if (modal.parentNode && modal.parentNode !== document.body) {
                document.body.appendChild(modal);
            }
            modal.style.setProperty('display', 'flex', 'important');
            setTimeout(() => {
                modal.classList.add('show');
                document.getElementById('purchaseSupplierName')?.focus();
            }, 20);
        }
    }

    function closePurchaseSupplierModal() {
        const modal = document.getElementById('purchaseSupplierCreateModal');
        if (modal) {
            modal.classList.remove('show');
            modal.style.setProperty('display', 'none', 'important');
            document.getElementById('purchaseSupplierForm')?.reset();
            $('#purchaseSupplierImgPreview').hide().attr('src', '');
            $('#purchaseSupplierDefaultIcon').show();
        }
    }

    function previewPurchaseSupplierImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#purchaseSupplierImgPreview').attr('src', e.target.result).show();
                $('#purchaseSupplierDefaultIcon').hide();
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    async function savePurchaseSupplier(e) {
        if (e) e.preventDefault();
        const name = document.getElementById('purchaseSupplierName')?.value?.trim();
        const mobile = document.getElementById('purchaseSupplierMobile')?.value?.trim();
        const company = document.getElementById('purchaseSupplierCompany')?.value?.trim();
        const address = document.getElementById('purchaseSupplierAddress')?.value?.trim();
        const email = document.getElementById('purchaseSupplierEmail')?.value?.trim();
        const payable = parseFloat(document.getElementById('purchaseSupplierPayableAmount')?.value) || 0;
        const status = document.getElementById('purchaseSupplierStatus')?.value || 'Active';
        const imgFile = document.getElementById('purchaseSupplierImageFile')?.files[0];

        if (!name || !mobile) {
            errorToast("Supplier Name and Mobile are required");
            return false;
        }

        let formData = new FormData();
        formData.append('name', name);
        formData.append('mobile', mobile);
        formData.append('company', company);
        formData.append('address', address);
        if (email) formData.append('email', email);
        formData.append('purchase_payable_amount', payable);
        formData.append('status', status);
        if (imgFile) {
            formData.append('img_url', imgFile);
        }

        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/create-supplier', formData, {
                headers: { 'Content-Type': 'multipart/form-data', ...HeaderToken().headers }
            });
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data.status === 'success') {
                successToast("Supplier created successfully");
                closePurchaseSupplierModal();

                const newSupplierId = res.data.supplier?.id || res.data.data?.id || null;
                await refreshSupplierList(newSupplierId);

                // Auto-select in current Purchase modal
                if (newSupplierId) {
                    selectSupplierItem({
                        id: newSupplierId,
                        name: name,
                        payable: payable,
                        credit: 0
                    });
                }
            } else {
                errorToast(res.data.message || "Failed to create supplier");
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error("Create Supplier Error:", err);
            errorToast(err.response?.data?.message || "Error creating supplier");
        }
        return false;
    }

    function openProductCreateModal() {
        const modal = document.getElementById('purchaseProductCreateModal');
        if (modal) {
            if (modal.parentNode && modal.parentNode !== document.body) {
                document.body.appendChild(modal);
            }
            modal.style.setProperty('display', 'flex', 'important');
            loadProductModalDropdowns();
            setTimeout(() => {
                modal.classList.add('show');
                document.getElementById('modalProductName')?.focus();
            }, 20);
        }
    }

    function closePurchaseProductModal() {
        const modal = document.getElementById('purchaseProductCreateModal');
        if (modal) {
            modal.classList.remove('show');
            modal.style.setProperty('display', 'none', 'important');
            resetPurchaseProductForm();
        }
    }

    function resetPurchaseProductForm() {
        document.getElementById('purchaseProductCreateForm')?.reset();
        $('#modalProductImgPreview').hide().attr('src', '');
        $('#modalProductImgDefaultIcon').show();
        $('#modalProductBrand').val('none');
        $('#modalBrandSelectedText').text('Select Brand').css('color', '#64748b');
        $('#modalProductCategory').val('');
        $('#modalCategorySelectedText').html('Select Category <span class="text-danger">*</span>').css('color', '#64748b');
        $('#modalProductSubCategory').val('none');
        $('#modalSubCategorySelectedText').text('Select Sub-Category').css('color', '#64748b');
        $('#modalSubCategoryOptionsList').html('<div class="select-option-item active" data-value="none" data-label="Select Sub-Category" onclick="selectCustomProductOption(\'modalSubCategoryDropdown\', \'modalProductSubCategory\', \'none\', \'Select Sub-Category\')"><span>Select Sub-Category</span><i class="fa-solid fa-check small text-success"></i></div>');
    }

    // Custom Searchable Dropdown Helpers for Add New Product Modal
    function toggleCustomProductDropdown(dropdownId) {
        const el = document.getElementById(dropdownId);
        if (!el) return;
        const wasOpen = el.classList.contains('is-open');
        document.querySelectorAll('.custom-searchable-select.is-open').forEach(d => {
            if (d !== el) d.classList.remove('is-open');
        });
        if (wasOpen) {
            el.classList.remove('is-open');
        } else {
            el.classList.add('is-open');
            const searchInput = el.querySelector('.search-wrap input');
            if (searchInput) {
                searchInput.value = '';
                filterCustomProductDropdown(dropdownId, '');
                setTimeout(() => searchInput.focus(), 60);
            }
        }
    }

    function filterCustomProductDropdown(dropdownId, query) {
        const el = document.getElementById(dropdownId);
        if (!el) return;
        const q = (query || '').toLowerCase().trim();
        const items = el.querySelectorAll('.select-option-item');
        items.forEach(item => {
            const label = (item.getAttribute('data-label') || item.innerText || '').toLowerCase();
            if (!q || label.includes(q)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function selectCustomProductOption(dropdownId, nativeSelectId, val, label) {
        const el = document.getElementById(dropdownId);
        const nativeSelect = document.getElementById(nativeSelectId);
        if (nativeSelect) {
            nativeSelect.value = val;
            nativeSelect.dispatchEvent(new Event('change'));
        }
        if (el) {
            const triggerText = el.querySelector('.selected-text');
            if (triggerText) {
                triggerText.textContent = label;
                triggerText.style.color = (val && val !== 'none') ? '#0f172a' : '#64748b';
            }
            el.querySelectorAll('.select-option-item').forEach(item => {
                if (String(item.getAttribute('data-value')) === String(val)) {
                    item.classList.add('active');
                    if (!item.querySelector('.fa-check')) {
                        item.innerHTML += '<i class="fa-solid fa-check small text-success"></i>';
                    }
                } else {
                    item.classList.remove('active');
                    const c = item.querySelector('.fa-check');
                    if (c) c.remove();
                }
            });
            el.classList.remove('is-open');
        }

        if (nativeSelectId === 'modalProductCategory') {
            loadSubCategoriesForProductModal(val);
        }
    }

    // Custom Searchable Dropdown for Sub-Category Category
    function toggleSubCategoryCategoryDropdown() {
        const el = document.getElementById('subCategoryCategoryDropdown');
        if (!el) return;
        el.classList.toggle('is-open');
        if (el.classList.contains('is-open')) {
            const input = document.getElementById('subCategoryCategorySearchInput');
            if (input) {
                input.value = '';
                filterSubCategoryCategoryOptions('');
                setTimeout(() => input.focus(), 60);
            }
        }
    }

    function filterSubCategoryCategoryOptions(query) {
        const q = (query || '').toLowerCase().trim();
        const items = document.querySelectorAll('#subCategoryCategoryOptionsList .select-option-item');
        items.forEach(item => {
            const text = (item.getAttribute('data-label') || item.innerText || '').toLowerCase();
            if (!q || text.includes(q)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function selectSubCategoryCategoryOption(id, name) {
        const hiddenSelect = document.getElementById('SubCategoryParentID');
        const triggerText = document.getElementById('subCategoryCategorySelectedText');
        const dropdown = document.getElementById('subCategoryCategoryDropdown');
        if (hiddenSelect) {
            hiddenSelect.value = id;
        }
        if (triggerText) {
            triggerText.textContent = name;
            triggerText.classList.add('has-value');
            triggerText.style.color = (id && id !== 'none') ? '#0f172a' : '#64748b';
        }
        if (dropdown) {
            dropdown.querySelectorAll('.select-option-item').forEach(item => {
                if (String(item.getAttribute('data-value')) === String(id)) {
                    item.classList.add('active');
                    if (!item.querySelector('.fa-check')) {
                        item.innerHTML += '<i class="fa-solid fa-check small text-success"></i>';
                    }
                } else {
                    item.classList.remove('active');
                    const c = item.querySelector('.fa-check');
                    if (c) c.remove();
                }
            });
            dropdown.classList.remove('is-open');
        }
    }

    let productModalBrandsData = [];
    let productModalCategoriesData = [];

    async function loadProductModalDropdowns(selectedBrandId = null, selectedCategoryId = null) {
        try {
            const [bRes, cRes] = await Promise.all([
                axios.get('/api/battery/brand-list', HeaderToken()),
                axios.get('/api/battery/category-list', HeaderToken())
            ]);

            productModalBrandsData = bRes.data?.BrandData || bRes.data?.data || [];
            productModalCategoriesData = cRes.data?.CategoryData || cRes.data?.data || [];

            // 1. Populate Brand Native Select & Custom Searchable Dropdown
            const bSelect = document.getElementById('modalProductBrand');
            const bList = document.getElementById('modalBrandOptionsList');
            const bTrigger = document.getElementById('modalBrandSelectedText');
            let currBrandVal = selectedBrandId ? String(selectedBrandId) : (bSelect ? bSelect.value : 'none');
            let currBrandName = 'Select Brand';

            if (bSelect) {
                let html = '<option value="none">Select Brand</option>';
                productModalBrandsData.forEach(b => {
                    const sel = (String(b.id) === currBrandVal) ? 'selected' : '';
                    if (sel) currBrandName = b.name;
                    html += `<option value="${b.id}" ${sel}>${b.name}</option>`;
                });
                bSelect.innerHTML = html;
            }

            if (bList) {
                let listHtml = `<div class="select-option-item ${(currBrandVal === 'none' || !currBrandVal) ? 'active' : ''}" data-value="none" data-label="Select Brand" onclick="selectCustomProductOption('modalBrandDropdown', 'modalProductBrand', 'none', 'Select Brand')">
                    <span>Select Brand</span>
                    ${(currBrandVal === 'none' || !currBrandVal) ? '<i class="fa-solid fa-check small text-success"></i>' : ''}
                </div>`;
                productModalBrandsData.forEach(b => {
                    const isSel = (String(b.id) === currBrandVal);
                    if (isSel) currBrandName = b.name;
                    listHtml += `<div class="select-option-item ${isSel ? 'active' : ''}" data-value="${b.id}" data-label="${b.name}" onclick="selectCustomProductOption('modalBrandDropdown', 'modalProductBrand', '${b.id}', '${b.name.replace(/'/g, "\\'")}')">
                        <span>${b.name}</span>
                        ${isSel ? '<i class="fa-solid fa-check small text-success"></i>' : ''}
                    </div>`;
                });
                bList.innerHTML = listHtml;
            }
            if (bTrigger) {
                bTrigger.textContent = currBrandName;
                bTrigger.style.color = (currBrandVal && currBrandVal !== 'none') ? '#0f172a' : '#64748b';
            }

            // 2. Populate Category Native Select & Custom Searchable Dropdown
            const cSelect = document.getElementById('modalProductCategory');
            const cList = document.getElementById('modalCategoryOptionsList');
            const cTrigger = document.getElementById('modalCategorySelectedText');
            let currCatVal = selectedCategoryId ? String(selectedCategoryId) : (cSelect ? cSelect.value : '');
            let currCatName = 'Select Category *';

            if (cSelect) {
                let html = '<option value="">Select Category *</option>';
                productModalCategoriesData.forEach(c => {
                    const sel = (String(c.id) === currCatVal) ? 'selected' : '';
                    if (sel) currCatName = c.name;
                    html += `<option value="${c.id}" ${sel}>${c.name}</option>`;
                });
                cSelect.innerHTML = html;
            }

            if (cList) {
                let listHtml = `<div class="select-option-item ${(currCatVal === '' || !currCatVal) ? 'active' : ''}" data-value="" data-label="Select Category *" onclick="selectCustomProductOption('modalCategoryDropdown', 'modalProductCategory', '', 'Select Category *')">
                    <span>Select Category *</span>
                    ${(currCatVal === '' || !currCatVal) ? '<i class="fa-solid fa-check small text-success"></i>' : ''}
                </div>`;
                productModalCategoriesData.forEach(c => {
                    const isSel = (String(c.id) === currCatVal);
                    if (isSel) currCatName = c.name;
                    listHtml += `<div class="select-option-item ${isSel ? 'active' : ''}" data-value="${c.id}" data-label="${c.name}" onclick="selectCustomProductOption('modalCategoryDropdown', 'modalProductCategory', '${c.id}', '${c.name.replace(/'/g, "\\'")}')">
                        <span>${c.name}</span>
                        ${isSel ? '<i class="fa-solid fa-check small text-success"></i>' : ''}
                    </div>`;
                });
                cList.innerHTML = listHtml;
            }
            if (cTrigger) {
                cTrigger.textContent = currCatName;
                cTrigger.style.color = (currCatVal && currCatVal !== '') ? '#0f172a' : '#64748b';
            }

            // 3. Populate SubCategory Sub-Modal Category Dropdown
            const subCatSelect = document.getElementById('SubCategoryParentID');
            const subCatList = document.getElementById('subCategoryCategoryOptionsList');
            if (subCatSelect) {
                let sHtml = '<option value="none" disabled selected>Select Category *</option>';
                productModalCategoriesData.forEach(c => {
                    sHtml += `<option value="${c.id}">${c.name}</option>`;
                });
                subCatSelect.innerHTML = sHtml;
            }
            if (subCatList) {
                let sListHtml = `<div class="select-option-item active" data-value="none" data-label="Select Category *" onclick="selectSubCategoryCategoryOption('none', 'Select Category *')">
                    <span>Select Category *</span>
                    <i class="fa-solid fa-check small text-success"></i>
                </div>`;
                productModalCategoriesData.forEach(c => {
                    sListHtml += `<div class="select-option-item" data-value="${c.id}" data-label="${c.name}" onclick="selectSubCategoryCategoryOption('${c.id}', '${c.name.replace(/'/g, "\\'")}')">
                        <span>${c.name}</span>
                    </div>`;
                });
                subCatList.innerHTML = sListHtml;
            }

            if (currCatVal) {
                loadSubCategoriesForProductModal(currCatVal);
            }
        } catch (e) {
            console.error("Error loading brand/category dropdowns:", e);
        }
    }

    async function loadSubCategoriesForProductModal(categoryId, selectedSubId = null) {
        const subSelect = document.getElementById('modalProductSubCategory');
        const subList = document.getElementById('modalSubCategoryOptionsList');
        const subTrigger = document.getElementById('modalSubCategorySelectedText');

        if (!categoryId || categoryId === 'none') {
            if (subSelect) subSelect.innerHTML = '<option value="none">Select Sub-Category</option>';
            if (subList) subList.innerHTML = '<div class="select-option-item active" data-value="none" data-label="Select Sub-Category" onclick="selectCustomProductOption(\'modalSubCategoryDropdown\', \'modalProductSubCategory\', \'none\', \'Select Sub-Category\')"><span>Select Sub-Category</span><i class="fa-solid fa-check small text-success"></i></div>';
            if (subTrigger) {
                subTrigger.textContent = 'Select Sub-Category';
                subTrigger.style.color = '#64748b';
            }
            return;
        }

        try {
            const res = await axios.get(`/api/battery/sub-category-list/${categoryId}`, HeaderToken());
            let subData = res.data?.SubCategoryData || res.data?.data || [];
            let currSubVal = selectedSubId ? String(selectedSubId) : 'none';
            let currSubName = 'Select Sub-Category';

            if (subSelect) {
                let html = '<option value="none">Select Sub-Category</option>';
                subData.forEach(s => {
                    const sel = (String(s.id) === currSubVal) ? 'selected' : '';
                    if (sel) currSubName = s.name;
                    html += `<option value="${s.id}" ${sel}>${s.name}</option>`;
                });
                subSelect.innerHTML = html;
            }

            if (subList) {
                let listHtml = `<div class="select-option-item ${(currSubVal === 'none') ? 'active' : ''}" data-value="none" data-label="Select Sub-Category" onclick="selectCustomProductOption('modalSubCategoryDropdown', 'modalProductSubCategory', 'none', 'Select Sub-Category')">
                    <span>Select Sub-Category</span>
                    ${(currSubVal === 'none') ? '<i class="fa-solid fa-check small text-success"></i>' : ''}
                </div>`;
                subData.forEach(s => {
                    const isSel = (String(s.id) === currSubVal);
                    if (isSel) currSubName = s.name;
                    listHtml += `<div class="select-option-item ${isSel ? 'active' : ''}" data-value="${s.id}" data-label="${s.name}" onclick="selectCustomProductOption('modalSubCategoryDropdown', 'modalProductSubCategory', '${s.id}', '${s.name.replace(/'/g, "\\'")}')">
                        <span>${s.name}</span>
                        ${isSel ? '<i class="fa-solid fa-check small text-success"></i>' : ''}
                    </div>`;
                });
                subList.innerHTML = listHtml;
            }

            if (subTrigger) {
                subTrigger.textContent = currSubName;
                subTrigger.style.color = (currSubVal && currSubVal !== 'none') ? '#0f172a' : '#64748b';
            }
        } catch (e) {
            console.error("Error loading subcategories:", e);
        }
    }

    function previewPurchaseProductImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#modalProductImgPreview').attr('src', e.target.result).show();
                $('#modalProductImgDefaultIcon').hide();
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    async function savePurchaseProduct(e) {
        if (e) e.preventDefault();
        const brandId = document.getElementById('modalProductBrand')?.value;
        const categoryId = document.getElementById('modalProductCategory')?.value;
        const subCategoryId = document.getElementById('modalProductSubCategory')?.value;
        const name = document.getElementById('modalProductName')?.value?.trim();
        const quantity = parseFloat(document.getElementById('modalProductQuantity')?.value) || 0;
        const costPrice = parseFloat(document.getElementById('modalProductCostPrice')?.value) || 0;
        const sellingPrice = parseFloat(document.getElementById('modalProductSellingPrice')?.value) || 0;
        const productCode = document.getElementById('modalProductCodeInput')?.value?.trim() || '';
        const imgFile = document.getElementById('modalProductImageFile')?.files[0];

        if (!name) {
            errorToast("Product Name is required");
            return false;
        }
        if (!categoryId || categoryId === 'none') {
            errorToast("Product Category is required");
            return false;
        }
        if (!brandId || brandId === 'none') {
            errorToast("Product Brand is required");
            return false;
        }

        let formData = new FormData();
        formData.append('product_name', name);
        formData.append('name', name);
        formData.append('brand_id', brandId);
        formData.append('category_id', categoryId);
        if (subCategoryId && subCategoryId !== 'none') {
            formData.append('sub_category_id', subCategoryId);
        }
        formData.append('quantity', quantity);
        formData.append('cost_price', costPrice);
        formData.append('selling_price', sellingPrice);
        formData.append('sell_price', sellingPrice);
        formData.append('product_code', productCode);
        formData.append('status', 'Active');
        if (imgFile) {
            formData.append('img_url', imgFile);
        }

        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/create-product', formData, {
                headers: { 'Content-Type': 'multipart/form-data', ...HeaderToken().headers }
            });
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data.status === 'success') {
                successToast("Product created successfully");
                closePurchaseProductModal();

                const newProd = res.data.product || {
                    id: res.data.data?.id || res.data.productId || Date.now(),
                    name: name,
                    product_name: name,
                    cost_price: costPrice,
                    product_code: productCode,
                    display_codes: productCode
                };

                // Add to purchase cart table directly
                addProductToTable({
                    id: newProd.id,
                    name: newProd.product_name || newProd.name,
                    product_name: newProd.product_name || newProd.name,
                    cost_price: parseFloat(newProd.cost_price) || costPrice,
                    product_code: newProd.product_code || productCode,
                    display_codes: newProd.product_code || productCode
                }, productCode);

            } else {
                errorToast(res.data.message || "Failed to create product");
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error("Create Product Error:", err);
            errorToast(err.response?.data?.message || "Error creating product");
        }
        return false;
    }

    // Quick Add Mini-modals for Brand, Category, Sub-Category (Matching Images 2, 3, 4)
    function previewBrandModalImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#BrandImgPreview').attr('src', e.target.result).show();
                $('#BrandImgIcon').hide();
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewCategoryModalImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#CategoryImgPreview').attr('src', e.target.result).show();
                $('#CategoryImgIcon').hide();
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function openBrandSubModal() {
        const m = document.getElementById('purchaseAddBrandModal');
        if (m) {
            if (m.parentNode !== document.body) document.body.appendChild(m);
            m.style.setProperty('display', 'flex', 'important');
            setTimeout(() => { m.classList.add('show'); $('#quickBrandName').focus(); }, 20);
        }
    }
    function closeBrandSubModal() {
        const m = document.getElementById('purchaseAddBrandModal');
        if (m) {
            m.classList.remove('show');
            m.style.setProperty('display', 'none', 'important');
            $('#quickBrandName').val('');
            $('#CreateBrandImg').val('');
            $('#BrandImgPreview').hide().attr('src', '');
            $('#BrandImgIcon').show();
            $('#BrandSelectStatus').val('Active');
        }
    }
    async function saveBrandSubModal(e) {
        if (e) e.preventDefault();
        const name = $('#quickBrandName').val().trim();
        const status = $('#BrandSelectStatus').val() || 'Active';
        const imgFile = document.getElementById('CreateBrandImg')?.files[0];
        if (!name) {
            errorToast('Brand Name is required');
            return;
        }
        let formData = new FormData();
        formData.append('name', name);
        formData.append('status', status);
        if (imgFile) formData.append('img_url', imgFile);

        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/create-brand', formData, {
                headers: { 'Content-Type': 'multipart/form-data', ...HeaderToken().headers }
            });
            if (typeof hideLoader === 'function') hideLoader();
            if (res.data?.status === 'success') {
                successToast('Brand created successfully');
                closeBrandSubModal();
                const newId = res.data.newBrandId || res.data.data?.id || res.data.brand?.id;
                await loadProductModalDropdowns(newId, null);
            } else {
                errorToast(res.data?.message || 'Failed to create brand');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to save brand');
        }
    }

    function openCategorySubModal() {
        const m = document.getElementById('purchaseAddCategoryModal');
        if (m) {
            if (m.parentNode !== document.body) document.body.appendChild(m);
            m.style.setProperty('display', 'flex', 'important');
            setTimeout(() => { m.classList.add('show'); $('#quickCategoryName').focus(); }, 20);
        }
    }
    function closeCategorySubModal() {
        const m = document.getElementById('purchaseAddCategoryModal');
        if (m) {
            m.classList.remove('show');
            m.style.setProperty('display', 'none', 'important');
            $('#quickCategoryName').val('');
            $('#CategoryImg').val('');
            $('#CategoryImgPreview').hide().attr('src', '');
            $('#CategoryImgIcon').show();
            $('#CategorySelectStatus').val('Active');
        }
    }
    async function saveCategorySubModal(e) {
        if (e) e.preventDefault();
        const name = $('#quickCategoryName').val().trim();
        const status = $('#CategorySelectStatus').val() || 'Active';
        const imgFile = document.getElementById('CategoryImg')?.files[0];
        if (!name) {
            errorToast('Category Name is required');
            return;
        }
        let formData = new FormData();
        formData.append('name', name);
        formData.append('category_name', name);
        formData.append('status', status);
        if (imgFile) formData.append('img_url', imgFile);

        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/create-category', formData, {
                headers: { 'Content-Type': 'multipart/form-data', ...HeaderToken().headers }
            });
            if (typeof hideLoader === 'function') hideLoader();
            if (res.data?.status === 'success') {
                successToast('Category created successfully');
                closeCategorySubModal();
                const newId = res.data.newCategoryId || res.data.data?.id || res.data.category?.id;
                await loadProductModalDropdowns(null, newId);
            } else {
                errorToast(res.data?.message || 'Failed to create category');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to save category');
        }
    }

    function openSubCategorySubModal() {
        const m = document.getElementById('purchaseAddSubCategoryModal');
        if (m) {
            if (m.parentNode !== document.body) document.body.appendChild(m);
            const currCatId = $('#modalProductCategory').val();
            if (currCatId && currCatId !== 'none') {
                const catName = $('#modalCategorySelectedText').text().replace('*', '').trim();
                selectSubCategoryCategoryOption(currCatId, catName);
            }
            m.style.setProperty('display', 'flex', 'important');
            setTimeout(() => { m.classList.add('show'); $('#quickSubCategoryName').focus(); }, 20);
        }
    }
    function closeSubCategorySubModal() {
        const m = document.getElementById('purchaseAddSubCategoryModal');
        if (m) {
            m.classList.remove('show');
            m.style.setProperty('display', 'none', 'important');
            $('#quickSubCategoryName').val('');
            $('#SubCategorySelectStatus').val('Active');
        }
    }
    async function saveSubCategorySubModal(e) {
        if (e) e.preventDefault();
        const name = $('#quickSubCategoryName').val().trim();
        const catId = $('#SubCategoryParentID').val() || $('#modalProductCategory').val();
        const status = $('#SubCategorySelectStatus').val() || 'Active';
        if (!name) {
            errorToast('Sub-Category Name is required');
            return;
        }
        if (!catId || catId === 'none') {
            errorToast('Please select a Category first');
            return;
        }
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/sub-create-category', { name: name, category_id: catId, status: status }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();
            if (res.data?.status === 'success') {
                successToast('Sub-Category created successfully');
                closeSubCategorySubModal();
                const newId = res.data.newSubCategoryId || res.data.data?.id || res.data.sub_category?.id;
                await loadSubCategoriesForProductModal(catId, newId);
            } else {
                errorToast(res.data?.message || 'Failed to create sub-category');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to save sub-category');
        }
    }

    function openPurchaseCameraScannerForSubmodal() {
        window.submodalScanningActive = true;
        openPurchaseCameraScanner();
    }

    async function refreshSupplierList(selectedSupplierId = null) {
        try {
            const res = await axios.get("/api/battery/supplier-list", HeaderToken());
            allSuppliersData = res.data.SupplierData || res.data.data || [];
            renderSupplierDropdownItems(allSuppliersData);

            if (selectedSupplierId) {
                const found = allSuppliersData.find(s => s.id == selectedSupplierId);
                if (found) {
                    selectSupplierItem(found);
                }
            }
        } catch (error) {
            console.error("Error occurred while fetching Battery Suppliers:", error);
        }
    }

    function renderSupplierDropdownItems(suppliers) {
        const listContainer = document.getElementById("supplierDropdownList");
        if (!listContainer) return;

        if (!suppliers || suppliers.length === 0) {
            listContainer.innerHTML = `<div class="p-2 text-muted text-center small">No suppliers found</div>`;
            return;
        }

        let html = suppliers.map(s => {
            const creditVal = parseFloat(s.return_credit_balance || 0);
            const creditLabel = creditVal > 0 ? `<span class="badge bg-teal ms-1" style="background:#0d9488; color:#fff;">🎁 ৳${creditVal.toFixed(2)}</span>` : '';
            const payable = parseFloat(s.purchase_payable_amount || 0);
            const payableLabel = payable > 0 ? `<span class="badge bg-danger ms-1">Due: ৳${payable.toFixed(2)}</span>` : '';
            const suppIdBadge = s.supplier_id ? `<span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 me-1 font-mono">${s.supplier_id}</span>` : '';

            return `
                <div class="dropdown-item px-3 py-2 border-bottom supplier-select-item"
                     data-id="${s.id}"
                     data-name="${s.name}"
                     data-payable="${payable}"
                     data-credit="${creditVal}"
                     style="cursor: pointer;">
                     <div class="fw-bold text-dark flex items-center">${suppIdBadge} <span>${s.name}</span> ${s.company ? `<small class="text-muted ms-1">(${s.company})</small>` : ''}</div>
                     <div class="small text-muted">${s.mobile || ''} ${payableLabel} ${creditLabel}</div>
                </div>
            `;
        }).join('');

        listContainer.innerHTML = html;

        listContainer.querySelectorAll('.supplier-select-item').forEach(item => {
            item.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const payable = this.getAttribute('data-payable');
                const credit = parseFloat(this.getAttribute('data-credit')) || 0;

                selectSupplierItem({ id, name, payable, credit });
                listContainer.style.display = 'none';
            });
        });
    }

    function selectSupplierItem(s) {
        document.getElementById("SupplierDataList").value = s.id;
        document.getElementById("supplierSearchInput").value = s.name;
        document.getElementById("PurchasePayableAmount").value = s.payable || 0;

        window.availableSupplierCredit = s.credit || 0;

        const creditNotice = document.getElementById("supplierCreditNotice");
        const creditBadge = document.getElementById("supplierCreditBadge");
        if (creditNotice && creditBadge) {
            if (s.credit && s.credit > 0) {
                creditBadge.innerHTML = `<i class="fa-solid fa-gift me-1 text-emerald-600 dark:text-emerald-400"></i> Return Credit Available: <strong>৳ ${parseFloat(s.credit).toFixed(2)}</strong>`;
                creditNotice.classList.remove('d-none');
            } else {
                creditNotice.classList.add('d-none');
            }
        }

        if (typeof syncReturnCreditCheckbox === 'function') {
            syncReturnCreditCheckbox(false);
        }
    }

    window.syncReturnCreditCheckbox = function(isChecked) {
        const tableCb = document.getElementById("useReturnCreditCheckbox");
        const bannerCb = document.getElementById("useReturnCreditCheckboxBanner");
        if (tableCb) tableCb.checked = isChecked;
        if (bannerCb) bannerCb.checked = isChecked;

        toggleReturnCreditAdjustment();
    };

    window.toggleReturnCreditAdjustment = function() {
        const checkbox = document.getElementById("useReturnCreditCheckbox");
        const returnAdjInput = document.getElementById("returnAdjustmentAmount");
        const maxCredit = parseFloat(window.availableSupplierCredit || 0);

        if (checkbox && checkbox.checked) {
            if (returnAdjInput) {
                returnAdjInput.disabled = false;
                returnAdjInput.style.backgroundColor = "#ffffff";
                returnAdjInput.setAttribute("max", maxCredit);
                returnAdjInput.value = maxCredit > 0 ? maxCredit.toFixed(2) : "0.00";
            }
        } else {
            if (returnAdjInput) {
                returnAdjInput.value = "0.00";
                returnAdjInput.disabled = true;
                returnAdjInput.style.backgroundColor = "#f1f5f9";
            }
        }

        calculateDuePayment();
    };

    window.calculateDuePayment = function() {
        const grandSubtotalInput = document.getElementById("grandSubtotal");
        const paidAmountInput = document.getElementById("paidAmount");
        const dueAmountInput = document.getElementById("dueAmount");
        const paymentStatusDisplay = document.getElementById("paymentStatusDisplay");

        let rawSubtotal = parseFloat(window.purchaseRawSubtotal ?? grandSubtotalInput?.value) || 0;
        let deliveryCharge = parseFloat(document.getElementById("deliveryTransportCharge")?.value) || 0;

        let discType = document.getElementById("purchaseDiscountType")?.value || 'fixed';
        let discVal = parseFloat(document.getElementById("purchaseDiscountInput")?.value) || 0;
        let discountAmount = 0;
        if (discType === 'percent') {
            discountAmount = (rawSubtotal * discVal) / 100;
        } else {
            discountAmount = discVal;
        }
        if (discountAmount < 0) discountAmount = 0;
        if (discountAmount > rawSubtotal) discountAmount = rawSubtotal;

        let discountedSubtotal = Math.max(0, rawSubtotal - discountAmount);

        let subTotalEl = document.getElementById("totalSubTotal");
        if (subTotalEl) {
            if (discountAmount > 0) {
                subTotalEl.innerHTML = `${discountedSubtotal.toFixed(2)} <span class="text-[11px] font-normal text-rose-500">(-৳ ${discountAmount.toFixed(2)})</span>`;
            } else {
                subTotalEl.innerText = rawSubtotal.toFixed(2);
            }
        }

        let checkbox = document.getElementById("useReturnCreditCheckbox");
        let returnAdjInput = document.getElementById("returnAdjustmentAmount");
        let netPayableInput = document.getElementById("netPayableAmount");
        let netDisplay = document.getElementById("netPayableDisplay");

        let totalWithDelivery = discountedSubtotal + deliveryCharge;

        let returnAdj = 0;
        if (checkbox && checkbox.checked) {
            let maxCredit = parseFloat(window.availableSupplierCredit || 0);
            returnAdj = parseFloat(returnAdjInput?.value) || 0;
            if (returnAdj > maxCredit) {
                returnAdj = maxCredit;
                if (returnAdjInput) returnAdjInput.value = maxCredit.toFixed(2);
            }
            if (returnAdj > totalWithDelivery) {
                returnAdj = totalWithDelivery;
                if (returnAdjInput) returnAdjInput.value = totalWithDelivery.toFixed(2);
            }
        } else {
            if (returnAdjInput) returnAdjInput.value = "0.00";
        }

        let netPayable = Math.max(0, totalWithDelivery - returnAdj);
        if (netPayableInput) netPayableInput.value = netPayable.toFixed(2);
        if (netDisplay) netDisplay.textContent = netPayable.toFixed(2);

        let paidAmount = parseFloat(paidAmountInput?.value) || 0;
        let dueAmount = Math.max(0, netPayable - paidAmount);

        if (dueAmountInput) dueAmountInput.value = dueAmount.toFixed(2);

        if (paymentStatusDisplay) {
            if (paidAmount === 0 && netPayable > 0) {
                paymentStatusDisplay.textContent = "Unpaid";
                paymentStatusDisplay.className = "partial-payment-status bg-danger text-white";
            } else if (paidAmount < netPayable) {
                paymentStatusDisplay.textContent = "Partial Paid";
                paymentStatusDisplay.className = "partial-payment-status";
            } else {
                paymentStatusDisplay.textContent = "Fully Paid";
                paymentStatusDisplay.className = "fully-paid-status";
            }
        }
    };

    function handlePurchasePaymentMethodChange(method) {
        const mobileFields = document.getElementById('mobileBankingFields');
        const bankFields = document.getElementById('bankBankingFields');

        if (['Bkash', 'Nagad', 'Rocket'].includes(method)) {
            if (mobileFields) mobileFields.style.display = 'block';
            if (bankFields) bankFields.style.display = 'none';
        } else if (method === 'Bank') {
            if (mobileFields) mobileFields.style.display = 'none';
            if (bankFields) bankFields.style.display = 'block';
        } else {
            if (mobileFields) mobileFields.style.display = 'none';
            if (bankFields) bankFields.style.display = 'none';
        }
    }

    // Camera Scanner logic
    let purchaseHtml5QrCode = null;
    let purchaseFacingMode = "environment";
    let lastPurchaseScannedCode = "";

    function openPurchaseCameraScanner() {
        const modalEl = new bootstrap.Modal(document.getElementById('purchaseCameraScanModal'));
        modalEl.show();
        setTimeout(() => {
            startPurchaseCameraScanner();
        }, 350);
    }

    function startPurchaseCameraScanner() {
        if (purchaseHtml5QrCode && purchaseHtml5QrCode.isScanning) {
            purchaseHtml5QrCode.stop().then(() => initPurchaseHtml5QrCode()).catch(() => initPurchaseHtml5QrCode());
        } else {
            initPurchaseHtml5QrCode();
        }
    }

    function initPurchaseHtml5QrCode() {
        const statusEl = document.getElementById('purchaseCameraScannerStatus');
        if (statusEl) {
            statusEl.className = "alert alert-info py-2 small mb-3";
            statusEl.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-1"></i> Starting camera... Hold barcode in front of camera.';
        }

        if (typeof Html5Qrcode === 'undefined') {
            if (statusEl) statusEl.innerHTML = 'Camera scanner library not available.';
            return;
        }

        purchaseHtml5QrCode = new Html5Qrcode("purchaseReader");
        const config = { fps: 15, qrbox: { width: 280, height: 160 }, aspectRatio: 1.777778 };

        purchaseHtml5QrCode.start(
            { facingMode: purchaseFacingMode },
            config,
            (decodedText) => onPurchaseBarcodeSuccess(decodedText),
            (err) => {}
        ).catch((err) => {
            console.error("Camera error:", err);
            if (statusEl) {
                statusEl.className = "alert alert-danger py-2 small mb-3";
                statusEl.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> Camera permission denied or device not found.';
            }
        });
    }

    function onPurchaseBarcodeSuccess(code) {
        code = code.trim();
        if (!code || code === lastPurchaseScannedCode) return;
        lastPurchaseScannedCode = code;

        const lastScannedBadge = document.getElementById('purchaseLastScannedText');
        if (lastScannedBadge) {
            lastScannedBadge.textContent = "Scanned: " + code;
            lastScannedBadge.className = "badge bg-success text-wrap p-2";
        }

        if (window.submodalScanningActive) {
            const subInput = document.getElementById("modalProductCodeInput");
            if (subInput) {
                subInput.value = code;
            }
            window.submodalScanningActive = false;
        } else {
            const input = document.getElementById("productInputData");
            if (input) {
                input.value = code;
                input.dispatchEvent(new Event('input'));
            }
        }

        stopPurchaseCameraScanner();
        const modalEl = bootstrap.Modal.getInstance(document.getElementById('purchaseCameraScanModal'));
        if (modalEl) modalEl.hide();

        setTimeout(() => { lastPurchaseScannedCode = ""; }, 2000);
    }

    function switchPurchaseCamera() {
        purchaseFacingMode = (purchaseFacingMode === "environment") ? "user" : "environment";
        startPurchaseCameraScanner();
    }

    function stopPurchaseCameraScanner() {
        if (purchaseHtml5QrCode) {
            purchaseHtml5QrCode.stop().then(() => purchaseHtml5QrCode.clear()).catch(e => console.error(e));
        }
    }

    // Product Autocomplete and Table Cart logic
    function setupProductSearchAndCart() {
        const productInput = document.getElementById("productInputData");
        const productDropdown = document.getElementById("productDropdown");

        if (productInput) {
            productInput.addEventListener("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    const code = this.value.trim();
                    if (code) processBarcodeOrSearchDirect(code);
                }
            });

            productInput.addEventListener("focus", function() {
                if (this.value.trim() && productDropdown && productDropdown.children.length > 0) {
                    productDropdown.style.display = "block";
                }
            });

            productInput.addEventListener("input", function() {
                clearTimeout(debounceTimer);
                const query = this.value.trim();

                if (!query) {
                    if (productDropdown) {
                        productDropdown.style.display = "none";
                        productDropdown.innerHTML = "";
                    }
                    return;
                }

                debounceTimer = setTimeout(async () => {
                    try {
                        const res = await axios.post("/api/battery/product-search-by-name", { query: query }, HeaderToken());
                        if (!productDropdown) return;
                        productDropdown.innerHTML = "";

                        if (res.data.status === "success" && res.data.data && res.data.data.length > 0) {
                            const exactBarcodeMatch = res.data.data.find(p =>
                                (p.product_code && p.product_code.toLowerCase() === query.toLowerCase()) ||
                                (Array.isArray(p.all_codes) && p.all_codes.some(c => String(c).toLowerCase() === query.toLowerCase()))
                            );

                            if (exactBarcodeMatch && res.data.data.length === 1) {
                                addProductToTable(exactBarcodeMatch, query);
                                productInput.value = "";
                                productDropdown.style.display = "none";
                                productDropdown.innerHTML = "";
                                return;
                            }

                            productDropdown.style.display = "block";
                            res.data.data.forEach(product => {
                                const li = document.createElement("li");
                                li.className = "list-group-item d-flex justify-content-between align-items-center py-2 px-3";
                                li.style.cursor = "pointer";

                                const barcodeText = product.display_codes || product.product_code;
                                const barcodeBadge = barcodeText
                                    ? `<span class="badge bg-secondary text-white ms-2" style="font-size: 11px;">${barcodeText}</span>`
                                    : '';

                                li.innerHTML = `
                                    <div class="d-flex align-items-center flex-wrap">
                                        <span class="fw-bold text-dark dark:text-light" style="font-size: 13px;">${product.name || product.product_name}</span>
                                        ${barcodeBadge}
                                    </div>
                                    <span class="badge bg-success font-bold" style="font-size: 12px;">৳ ${(parseFloat(product.cost_price) || 0).toFixed(2)}</span>
                                `;
                                li.addEventListener("click", () => {
                                    addProductToTable(product);
                                    productInput.value = "";
                                    productDropdown.style.display = "none";
                                    productDropdown.innerHTML = "";
                                });
                                productDropdown.appendChild(li);
                            });
                        } else {
                            productDropdown.style.display = "block";
                            productDropdown.innerHTML = `<li class="list-group-item text-center text-muted py-2 small">No battery product found for "${query}"</li>`;
                        }
                    } catch (error) {
                        console.error("Product Search Error:", error);
                        if (productDropdown) productDropdown.style.display = "none";
                    }
                }, 250);
            });

            document.addEventListener("click", function(e) {
                if (productDropdown && productInput && !productInput.contains(e.target) && !productDropdown.contains(e.target)) {
                    productDropdown.style.display = "none";
                }
            });
        }
    }

    async function processBarcodeOrSearchDirect(query) {
        try {
            const res = await axios.post("/api/battery/product-search-by-name", { query: query }, HeaderToken());
            if (res.data.status === "success" && res.data.data && res.data.data.length > 0) {
                const found = res.data.data.find(p =>
                    (p.product_code && p.product_code.toLowerCase() === query.toLowerCase()) ||
                    (Array.isArray(p.all_codes) && p.all_codes.some(c => String(c).toLowerCase() === query.toLowerCase()))
                ) || res.data.data[0];

                addProductToTable(found, query);
                const input = document.getElementById("productInputData");
                if (input) input.value = "";
                const dd = document.getElementById("productDropdown");
                if (dd) { dd.style.display = "none"; dd.innerHTML = ""; }
            } else {
                errorToast("No battery product found matching: " + query);
            }
        } catch (e) {
            console.error("Direct barcode search error:", e);
        }
    }

    function addProductToTable(product, specificBarcode = null) {
        const tableBody = document.getElementById("orderTableBody");
        const existingRow = document.querySelector(`#orderTableBody tr[data-product-id="${product.id}"]`);

        if (existingRow) {
            const qtyInput = existingRow.querySelector(".quantity");
            qtyInput.value = parseInt(qtyInput.value) + 1;
            if (specificBarcode) {
                appendBarcodeToRow(existingRow, product.id, specificBarcode);
            }
            updateRowSubtotal(existingRow);
            updateTotals();
            return;
        }

        let initialBarcode = specificBarcode || '';
        if (!initialBarcode) {
            if (Array.isArray(product.all_codes) && product.all_codes.length > 0) {
                initialBarcode = product.all_codes[0];
            } else if (product.product_code) {
                initialBarcode = product.product_code;
            }
        }
        UpdatebarcodeLists[product.id] = initialBarcode ? [initialBarcode] : [];

        const row = document.createElement("tr");
        row.setAttribute("data-product-id", product.id);
        row.className = "hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors";

        const productName = product.name || product.product_name || 'Product';
        const costPrice = parseFloat(product.cost_price) || 0;

        row.innerHTML = `
            <td class="p-2.5 font-bold text-slate-800 dark:text-slate-100">
                <span class="product-id-val d-none">${product.id}</span>
                <span>${productName}</span>
                <div class="text-[11px] text-slate-400 font-normal">ID: ${product.product_id || product.id}</div>
            </td>
            <td class="p-2.5">
                <div class="d-flex align-items-center gap-1">
                    <input type="text" id="UpdateProductCode" class="form-control form-control-sm" style="font-size: 11px; width: 140px;" value="${initialBarcode}" readonly />
                    <button type="button" class="btn btn-sm btn-outline-secondary px-1.5 py-0.5" onclick="promptAddBarcode(this, ${product.id})" title="Add Barcode">
                        <i class="fa-solid fa-plus text-[10px]"></i>
                    </button>
                </div>
            </td>
            <td class="p-2.5 text-center">
                <input type="number" class="form-control form-control-sm quantity text-center font-bold" min="1" value="1" style="width: 70px; margin: 0 auto;" oninput="updateRowSubtotal(this.closest('tr')); updateTotals();" />
            </td>
            <td class="p-2.5 text-end">
                <input type="number" step="any" class="form-control form-control-sm cost-price text-end font-bold" value="${costPrice}" style="width: 90px; margin-left: auto;" oninput="updateRowSubtotal(this.closest('tr')); updateTotals();" />
            </td>
            <td class="p-2.5 text-end font-bold text-slate-800 dark:text-white subtotal">৳ ${costPrice.toFixed(2)}</td>
            <td class="p-2.5 text-center">
                <button type="button" class="btn btn-sm btn-outline-danger p-1 rounded-lg" onclick="removeProductRow(this)" title="Remove">
                    <i class="fa-solid fa-trash text-xs"></i>
                </button>
            </td>
        `;

        tableBody.appendChild(row);
        updateTotals();
    }

    function appendBarcodeToRow(row, productId, barcode) {
        if (!UpdatebarcodeLists[productId]) UpdatebarcodeLists[productId] = [];
        if (!UpdatebarcodeLists[productId].includes(barcode)) {
            UpdatebarcodeLists[productId].push(barcode);
            const input = row.querySelector("#UpdateProductCode");
            if (input) input.value = UpdatebarcodeLists[productId].join(', ');
        }
    }

    function promptAddBarcode(btn, productId) {
        const barcode = prompt("Enter additional barcode for this product:");
        if (barcode && barcode.trim()) {
            const row = btn.closest("tr");
            appendBarcodeToRow(row, productId, barcode.trim());
        }
    }

    function updateRowSubtotal(row) {
        const qty = parseInt(row.querySelector(".quantity").value) || 0;
        const price = parseFloat(row.querySelector(".cost-price").value) || 0;
        const subtotal = qty * price;
        row.querySelector(".subtotal").innerText = `৳ ${subtotal.toFixed(2)}`;
    }

    function removeProductRow(btn) {
        const row = btn.closest("tr");
        const productId = row.getAttribute("data-product-id");
        delete UpdatebarcodeLists[productId];
        row.remove();
        updateTotals();
    }

    function updateTotals() {
        let totalQty = 0;
        let totalSub = 0;

        document.querySelectorAll("#orderTableBody tr").forEach(row => {
            const qty = parseInt(row.querySelector(".quantity").value) || 0;
            const price = parseFloat(row.querySelector(".cost-price").value) || 0;
            totalQty += qty;
            totalSub += qty * price;
        });

        window.purchaseRawSubtotal = totalSub;
        const qtyEl = document.getElementById("totalQuantity");
        if (qtyEl) qtyEl.innerText = totalQty;
        const subEl = document.getElementById("totalSubTotal");
        if (subEl) subEl.innerText = totalSub.toFixed(2);
        const grandInput = document.getElementById("grandSubtotal");
        if (grandInput) grandInput.value = totalSub.toFixed(2);

        calculateDuePayment();
    }

    async function saveBatteryPurchaseOrder(event) {
        if (event) event.preventDefault();

        let supplierIdVal = document.getElementById('SupplierDataList')?.value;
        const suppInputVal = document.getElementById('supplierSearchInput')?.value.trim();

        if ((!supplierIdVal || supplierIdVal === 'none') && suppInputVal && Array.isArray(allSuppliersData)) {
            const query = suppInputVal.toLowerCase();
            const matched = allSuppliersData.find(s =>
                (s.supplier_id && s.supplier_id.toLowerCase() === query) ||
                (s.name && s.name.toLowerCase() === query) ||
                (s.mobile && s.mobile === query)
            );
            if (matched) {
                selectSupplierItem(matched);
                supplierIdVal = matched.id;
            }
        }

        if (!supplierIdVal || supplierIdVal === 'none' || supplierIdVal.trim() === '') {
            errorToast("Please select a Supplier!");
            document.getElementById('supplierSearchInput')?.focus();
            return;
        }

        const refNoVal = document.getElementById('ReferenceNo')?.value.trim();
        if (!refNoVal) {
            errorToast("Please enter Reference / Invoice No!");
            document.getElementById('ReferenceNo')?.focus();
            return;
        }

        const purchaseDateVal = document.getElementById('PurchaseDate')?.value.trim();
        if (!purchaseDateVal) {
            errorToast("Please select a Purchase Date!");
            document.getElementById('PurchaseDate')?.focus();
            return;
        }

        const products = [];
        const rows = document.querySelectorAll('#orderTableBody tr');

        rows.forEach(row => {
            const productId = row.querySelector('.product-id-val').innerText.trim();
            const quantity = parseInt(row.querySelector('.quantity').value) || 0;
            const costPrice = parseFloat(row.querySelector('.cost-price').value) || 0;
            const subtotalText = row.querySelector('.subtotal').innerText.replace(/[^\d.]/g, '');
            const subtotal = parseFloat(subtotalText) || (quantity * costPrice);
            const ProductCodes = UpdatebarcodeLists[productId] || [];

            if (quantity <= 0) {
                errorToast("Quantity must be greater than zero!");
                return;
            }

            products.push({
                product_id: productId,
                quantity: quantity,
                product_code: ProductCodes,
                cost_price: costPrice,
                subtotal: subtotal
            });
        });

        if (products.length === 0) {
            errorToast("At least one product must be added!");
            return;
        }

        const selectedMethod = document.getElementById('paymentMethod')?.value || 'Cash';
        let trxDetails = '';
        if (['Bkash', 'Nagad', 'Rocket'].includes(selectedMethod)) {
            const pNum = document.getElementById('paymentNumber')?.value.trim() || '';
            const tId = document.getElementById('transactionIdInput')?.value.trim() || '';
            trxDetails = [pNum ? 'Number: ' + pNum : '', tId ? 'TrxID: ' + tId : ''].filter(Boolean).join(' | ');
        } else if (selectedMethod === 'Bank') {
            const bName = document.getElementById('bankNameInput')?.value.trim() || '';
            const bNum = document.getElementById('bankNumberInput')?.value.trim() || '';
            trxDetails = [bName ? 'Bank: ' + bName : '', bNum ? 'A/C: ' + bNum : ''].filter(Boolean).join(' | ');
        } else {
            trxDetails = document.getElementById('paymentDetails')?.value.trim() || '';
        }

        let formData = new FormData();
        formData.append('supplier_id', supplierIdVal);
        formData.append('purchase_payable_amount', document.getElementById('PurchasePayableAmount')?.value || 0);
        formData.append('date', purchaseDateVal);
        formData.append('purchase_due_collection_date', purchaseDateVal);
        formData.append('referance_no', refNoVal);
        formData.append('payment_status', document.getElementById('paymentStatusDisplay')?.textContent.trim() || 'Unpaid');
        formData.append('grand_subtotal', parseFloat(document.getElementById('grandSubtotal')?.value) || 0);
        formData.append('delivery_charge', parseFloat(document.getElementById('deliveryTransportCharge')?.value) || 0);

        let rawSubVal = window.purchaseRawSubtotal || parseFloat(document.getElementById('grandSubtotal')?.value) || 0;
        let discTypeVal = document.getElementById('purchaseDiscountType')?.value || 'fixed';
        let discNumVal = parseFloat(document.getElementById('purchaseDiscountInput')?.value) || 0;
        let discAmountVal = (discTypeVal === 'percent') ? (rawSubVal * discNumVal / 100) : discNumVal;
        if (discAmountVal < 0) discAmountVal = 0;
        if (discAmountVal > rawSubVal) discAmountVal = rawSubVal;
        formData.append('discount_amount', discAmountVal || 0);

        formData.append('return_adjustment_amount', parseFloat(document.getElementById('returnAdjustmentAmount')?.value) || 0);
        formData.append('payment_method', selectedMethod);
        formData.append('paid_amount', parseFloat(document.getElementById('paidAmount')?.value) || 0);
        formData.append('due_amount', parseFloat(document.getElementById('dueAmount')?.value) || 0);
        formData.append('transaction_id', trxDetails);
        formData.append('products', JSON.stringify(products));

        const imgInput = document.getElementById('AttachDocument');
        if (imgInput && imgInput.files[0]) {
            formData.append('img', imgInput.files[0]);
        }

        const config = {
            headers: {
                'content-type': 'multipart/form-data',
                ...HeaderToken().headers
            }
        };

        try {
            if (typeof showLoader === 'function') showLoader();
            let res = await axios.post("/api/battery/create-purchases", formData, config);
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data['status'] === "success") {
                successToast(res.data['message'] || "Battery Purchase Order Submitted!");
                document.getElementById("purchaseCreateForm")?.reset();
                $('#purchaseCreateModal').modal('hide');
                getList();
            } else {
                errorToast(res.data['message'] || "Failed to create battery purchase");
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error("Purchase Save Error:", e);
            errorToast(e.response?.data?.message || "Failed to submit purchase order.");
            unauthorized(e.response?.status);
        }
    }

    // ==========================================
    // EDIT PURCHASE WORKFLOW (Matching Image 5 & Retail Exact Logic)
    // ==========================================
    let updatePurchaseDatepicker = null;
    let updateAllSuppliersData = [];

    function initUpdateDatePicker() {
        const dateInput = document.getElementById("UpdatePurchaseDate");
        if (dateInput && typeof flatpickr !== "undefined") {
            if (updatePurchaseDatepicker) {
                try { updatePurchaseDatepicker.destroy(); } catch (e) {}
            }
            updatePurchaseDatepicker = flatpickr(dateInput, {
                dateFormat: "d-m-Y",
                allowInput: true,
                clickOpens: true,
                disableMobile: true
            });
        }
    }

    function renderUpdateSupplierDropdownItems(suppliers) {
        const listContainer = document.getElementById("updateSupplierDropdownList");
        if (!listContainer) return;

        if (!suppliers || suppliers.length === 0) {
            listContainer.innerHTML = `<div class="p-2.5 text-slate-400 text-center text-xs">No suppliers found</div>`;
            return;
        }

        let html = suppliers.map(s => {
            return `
                <div class="dropdown-item px-3.5 py-2 border-b border-slate-100 dark:border-slate-800 update-supplier-item hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors"
                     data-id="${s.id}"
                     data-name="${s.name}"
                     style="cursor: pointer;">
                     <div class="font-bold text-slate-800 dark:text-slate-100 text-xs flex items-center justify-between">
                         <span>${s.name} ${s.company ? `<span class="text-[11px] font-normal text-slate-500 dark:text-slate-400">(${s.company})</span>` : ''}</span>
                         <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono">${s.supplier_id || ''}</span>
                     </div>
                </div>
            `;
        }).join('');

        listContainer.innerHTML = html;

        listContainer.querySelectorAll('.update-supplier-item').forEach(item => {
            item.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                document.getElementById("UpdateSupplierSelect").value = id;
                document.getElementById("updateSupplierSearchInput").value = name;
                listContainer.style.display = 'none';
            });
        });
    }

    function setupUpdateSupplierSearch() {
        const suppInput = document.getElementById("updateSupplierSearchInput");
        const suppList = document.getElementById("updateSupplierDropdownList");

        if (suppInput && suppList) {
            suppInput.onfocus = function() {
                suppList.style.display = "block";
                renderUpdateSupplierDropdownItems(updateAllSuppliersData);
            };

            suppInput.oninput = function() {
                const query = this.value.toLowerCase().trim();
                suppList.style.display = "block";

                const filtered = updateAllSuppliersData.filter(s =>
                    (s.name && s.name.toLowerCase().includes(query)) ||
                    (s.mobile && s.mobile.toLowerCase().includes(query)) ||
                    (s.company && s.company.toLowerCase().includes(query)) ||
                    (s.supplier_id && s.supplier_id.toLowerCase().includes(query))
                );

                renderUpdateSupplierDropdownItems(filtered);
            };

            document.addEventListener("click", function(e) {
                const wrapper = document.getElementById("updateSearchableSupplierWrapper");
                if (wrapper && !wrapper.contains(e.target)) {
                    suppList.style.display = "none";
                }
            });
        }
    }

    function recalculateUpdateDue() {
        let g = parseFloat($('#UpdateGrandSubtotal').val()) || 0;
        let del = parseFloat($('#UpdateDeliveryCharge').val()) || 0;
        let p = parseFloat($('#UpdatePaidAmount').val()) || 0;
        let due = Math.max(0, (g + del) - p);
        $('#UpdateDueAmount').val(due.toFixed(2));
    }

    async function openEditPurchaseModal(id) {
        try {
            if (typeof showLoader === 'function') showLoader();
            $('#editPurchaseId').val(id);

            // 1. Load battery suppliers if not yet loaded
            if (!updateAllSuppliersData || updateAllSuppliersData.length === 0) {
                let sRes = await axios.get("/api/battery/supplier-list", HeaderToken());
                updateAllSuppliersData = sRes.data.SupplierData || sRes.data.data || [];
                renderUpdateSupplierDropdownItems(updateAllSuppliersData);
            }

            // 2. Fetch purchase by id
            let res = await axios.post("/api/battery/purchases-by-id", {
                id: id.toString()
            }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            let data = res.data.rows;
            if (data) {
                document.getElementById('UpdateReferanceNo').value = data.referance_no || '';

                let dateVal = data.date || '';
                if (dateVal && dateVal.includes('-')) {
                    let parts = dateVal.split('-');
                    if (parts[0].length === 4) {
                        // Convert Y-m-d to d-m-Y
                        dateVal = `${parts[2]}-${parts[1]}-${parts[0]}`;
                    }
                }
                document.getElementById('UpdatePurchaseDate').value = dateVal;
                initUpdateDatePicker();
                if (updatePurchaseDatepicker) {
                    updatePurchaseDatepicker.setDate(dateVal, true, "d-m-Y");
                }

                document.getElementById('UpdateGrandSubtotal').value = data.grand_subtotal || 0;
                document.getElementById('UpdateDeliveryCharge').value = data.delivery_charge || 0;
                document.getElementById('UpdatePaidAmount').value = data.paid_amount || 0;
                document.getElementById('UpdateDueAmount').value = data.due_amount || 0;

                // Reset file input & show current document link
                const docInput = document.getElementById('UpdateAttachDocument');
                if (docInput) docInput.value = '';

                const docLink = document.getElementById('currentDocLink');
                if (docLink) {
                    if (data.attach_document) {
                        let docSrc = data.attach_document.startsWith('http') || data.attach_document.startsWith('/') ? data.attach_document : `/${data.attach_document}`;
                        docLink.innerHTML = `<a href="${docSrc}" target="_blank" class="hover:underline flex items-center gap-1 text-emerald-600 dark:text-emerald-400 font-semibold"><i class="fa-solid fa-file"></i> View Current</a>`;
                    } else {
                        docLink.innerHTML = '';
                    }
                }

                if (data.supplier_id) {
                    document.getElementById('UpdateSupplierSelect').value = data.supplier_id;
                    const foundSupp = updateAllSuppliersData.find(s => s.id == data.supplier_id);
                    if (foundSupp) {
                        document.getElementById('updateSupplierSearchInput').value = foundSupp.name;
                    } else if (data.supplier) {
                        document.getElementById('updateSupplierSearchInput').value = data.supplier;
                    }
                } else {
                    document.getElementById('UpdateSupplierSelect').value = '';
                    document.getElementById('updateSupplierSearchInput').value = '';
                }

                setupUpdateSupplierSearch();
                $('#UpdateGrandSubtotal, #UpdateDeliveryCharge, #UpdatePaidAmount').off('input.updateDue').on('input.updateDue', recalculateUpdateDue);

                $('#purchaseUpdateModal').modal('show');
            } else {
                errorToast('Failed to load purchase details');
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            errorToast('Error loading purchase details');
        }
    }

    async function saveEditBatteryPurchase(event) {
        if (event) event.preventDefault();
        try {
            let id = $('#editPurchaseId').val();
            let grandSubtotal = $('#UpdateGrandSubtotal').val();
            let paidAmount = $('#UpdatePaidAmount').val() || 0;
            let dueAmount = $('#UpdateDueAmount').val() || 0;

            let formData = new FormData();
            formData.append('id', id);
            formData.append('referance_no', $('#UpdateReferanceNo').val().trim());
            formData.append('date', $('#UpdatePurchaseDate').val());
            formData.append('grand_subtotal', grandSubtotal);
            formData.append('delivery_charge', parseFloat($('#UpdateDeliveryCharge').val()) || 0);
            formData.append('paid_amount', paidAmount);
            formData.append('due_amount', dueAmount);
            formData.append('supplier_id', $('#UpdateSupplierSelect').val());

            const imgInput = document.getElementById('UpdateAttachDocument');
            if (imgInput && imgInput.files[0]) {
                formData.append('img', imgInput.files[0]);
            }

            if (typeof showLoader === 'function') showLoader();
            let res = await axios.post("/api/battery/update-purchases", formData, {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            });
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message || 'Battery purchase updated successfully');
                $("#purchaseUpdateModal").modal('hide');
                getList();
            } else {
                errorToast(res.data.message || 'Failed to update purchase');
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error("Error:", e.response);
            errorToast(e.response?.data?.message || "Failed to update purchase.");
        }
        return false;
    }

    // ==========================================
    // DELETE PURCHASE WORKFLOW
    // ==========================================
    function openDeletePurchaseModal(id) {
        $('#deleteID').val(id);
        $('#confirmationModal').modal('show');
    }

    async function confirmDeleteBatteryPurchase() {
        try {
            const id = $('#deleteID').val();
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/delete-purchases', { id: id }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Purchase deleted successfully');
                $('#confirmationModal').modal('hide');
                getList();
            } else {
                errorToast(res.data.message || 'Failed to delete purchase');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            errorToast(err.response?.data?.message || 'Error deleting purchase');
        }
    }
</script>

@endsection
