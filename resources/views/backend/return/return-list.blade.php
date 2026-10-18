<!-- Sales & Purchase Return Management Section Start -->
<div class="main-content">
    <div class="page-content min-h-screen flex flex-col justify-between">
        <div class="data-table flex-grow">
            
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-10">

                    <!-- 1. Top Section: Page Title & New Return Button (Fixed 38px) -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="1 4 1 10 7 10"></polyline>
                                    <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Return Management</h1>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-0">MARSS CORPORATION - Sales & Purchase Return Management</p>
                            </div>
                        </div>

                        <!-- Right Controls: + New Return Button (Fixed 38px) -->
                        <div class="flex items-center flex-wrap gap-2">
                            <button id="mainNewReturnBtn" onclick="triggerNewReturnModal()" type="button" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>New Sales Return</span>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Mode Toggle Nav Tabs (Fixed 38px height) -->
                    <div class="flex items-center gap-2 mb-4">
                        <button id="tabSalesReturnBtn" onclick="switchReturnTab('sales')" type="button" class="inline-flex items-center gap-2 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                            <i class="fa-solid fa-cart-shopping text-xs"></i>
                            <span>Sales Return</span>
                        </button>
                        <button id="tabPurchaseReturnBtn" onclick="switchReturnTab('purchase')" type="button" class="inline-flex items-center gap-2 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 active:scale-[0.98] text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                            <i class="fa-solid fa-truck-ramp-box text-xs"></i>
                            <span>Purchase Return</span>
                        </button>
                    </div>

                    <!-- 3. Quick Search Box (Fixed 38px inputs/buttons) -->
                    <div id="searchCardBox" class="rounded-xl border border-slate-300 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40 p-3.5 sm:p-4 mb-4 transition-colors" style="border-left: 4px solid #15803d !important;">
                        <h5 id="searchCardTitle" class="text-sm sm:text-base font-bold text-slate-800 dark:text-white mb-1 flex items-center gap-2">
                            <i class="fa-solid fa-magnifying-glass text-emerald-600"></i> Quick Invoice Search & Process Return
                        </h5>
                        <p id="searchCardDesc" class="text-xs text-slate-500 dark:text-slate-400 mb-2.5">Search invoice number to process sales return:</p>
                        
                        <div class="flex flex-row items-stretch gap-2.5">
                            <div class="search-input-wrapper unified-ui-border flex-1 min-w-0 min-h-[38px] flex items-center px-3 py-2 sm:py-0 sm:h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                                <input type="text" id="quickInvoiceSearchInput" style="border: none !important; outline: none !important; box-shadow: none !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0" placeholder="Enter invoice number (e.g. #InvID00001)..." onkeydown="if(event.key==='Enter') triggerQuickReturnSearch()" />
                            </div>
                            <button id="searchCardSubmitBtn" onclick="triggerQuickReturnSearch()" type="button" class="inline-flex items-center justify-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150 flex-shrink-0 whitespace-nowrap">
                                <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                                <span>Search & Return</span>
                            </button>
                        </div>
                    </div>

                    <!-- 4. History Controls Row: Title + Search & Entries -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2.5 sm:gap-3 mb-4">
                        <div class="flex items-center gap-2">
                            <h5 id="historyTableTitle" class="text-base sm:text-lg font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0 flex items-center gap-2">
                                <i class="fa-solid fa-clock-rotate-left text-emerald-600"></i> Sales Return History
                            </h5>
                            <span id="returnRecordCountBadge" class="display-info-box font-bold text-emerald-700 dark:text-emerald-400 px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-slate-800 text-xs">0 Records</span>
                        </div>

                        <!-- Search Bar + Show Entry Side-by-Side -->
                        <div class="flex items-center gap-2 sm:gap-2.5 w-full md:w-auto">
                            <!-- Search Bar -->
                            <div class="search-input-wrapper unified-ui-border flex-1 md:w-[260px] lg:w-[300px] h-[38px] flex items-center px-3 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                                <input type="text" id="historySearchInput" style="border: none !important; outline: none !important; box-shadow: none !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0" placeholder="Filter returns..." />
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

                    <!-- Desktop Table (SL left, Action right) -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[40px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                    <th class="p-[10px] text-start w-[120px] whitespace-nowrap">Return Date</th>
                                    <th id="thInvoiceNo" class="p-[10px] text-start w-[130px] whitespace-nowrap">Invoice No</th>
                                    <th id="thPartyName" class="p-[10px] text-start whitespace-nowrap">Customer Name</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Returned Product</th>
                                    <th class="p-[10px] text-center w-[90px] whitespace-nowrap">Qty</th>
                                    <th class="p-[10px] text-end w-[130px] whitespace-nowrap">Refund Amount</th>
                                    <th class="p-[10px] text-center w-[110px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableList" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200"></tbody>
                            <tfoot class="bg-slate-50/90 dark:bg-slate-800/70 text-slate-800 dark:text-slate-100 font-bold border-t-2 border-emerald-600/30 dark:border-emerald-600/20 text-xs sm:text-sm">
                                <tr>
                                    <td colspan="5" class="p-[10px] text-end font-bold text-slate-600 dark:text-slate-300">Total Returned Refund Value:</td>
                                    <td id="tfootTotalQty" class="p-[10px] text-center font-bold text-slate-800 dark:text-slate-100 whitespace-nowrap">0 pcs</td>
                                    <td id="tfootTotalAmount" class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ 0.00</td>
                                    <td class="p-[10px] text-center"></td>
                                </tr>
                            </tfoot>
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

        <!-- 5. Sticky Bottom Copyright Section -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)]">
            <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>

    </div>
</div>
<!-- Sales & Purchase Return Management Section End -->

<!-- Quick View Return Details Modal -->
<div id="returnQuickViewModal" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg my-3" style="max-height: 88vh;">
        <div class="modal-content bg-white dark:bg-slate-900 border-0 rounded-2xl shadow-2xl overflow-hidden transition-colors flex flex-col" style="max-height: 88vh; border: none !important;">
            
            <!-- Modal Header: Sticky top, Solid Emerald #15803d, White text, Red round close button -->
            <div class="modal-header sticky top-0 z-20 px-4 py-3 bg-emerald-700 text-white flex items-center justify-between shadow-sm border-0 flex-shrink-0" style="background-color: #15803d !important; color: #ffffff !important; border: none !important;">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/20 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </div>
                    <div>
                        <h5 class="modal-title text-base sm:text-lg font-bold text-white tracking-tight mb-0.5" id="qvReturnModalTitle" style="color: #ffffff !important;">Return Details</h5>
                        <div class="flex items-center gap-1.5 flex-wrap text-xs" id="qvReturnHeaderBadges"></div>
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
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                    <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-center">
                        <span class="block text-[10px] font-semibold text-slate-400 dark:text-slate-400 uppercase tracking-wider mb-1">Return Date</span>
                        <span id="qvStatReturnDate" class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-100">-</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-center">
                        <span class="block text-[10px] font-semibold text-slate-400 dark:text-slate-400 uppercase tracking-wider mb-1">Returned Qty</span>
                        <span id="qvStatReturnQty" class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-100">-</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-rose-50 dark:bg-slate-800 border border-rose-200 dark:border-slate-700 text-center">
                        <span class="block text-[10px] font-semibold text-rose-600 dark:text-rose-400 uppercase tracking-wider mb-1">Refund Amount</span>
                        <span id="qvStatRefundAmount" class="text-xs sm:text-sm font-bold text-rose-600 dark:text-rose-400">৳ 0.00</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-emerald-50 dark:bg-slate-800 border border-emerald-200 dark:border-slate-700 text-center">
                        <span class="block text-[10px] font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-1">Due Adjustment</span>
                        <span id="qvStatDueAmount" class="text-xs sm:text-sm font-bold text-emerald-700 dark:text-emerald-300">৳ 0.00</span>
                    </div>
                </div>

                <!-- Specification Box with Top Margin & Generous Padding -->
                <div class="rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden mt-3">
                    <div class="bg-slate-100 dark:bg-slate-800 px-5 sm:px-6 py-2.5 border-b border-slate-200 dark:border-slate-700 font-bold text-xs text-slate-700 dark:text-slate-200 uppercase tracking-wider flex items-center justify-between flex-wrap gap-2">
                        <span>Return Specifications</span>
                        <span id="qvReturnTag" class="text-emerald-700 dark:text-emerald-400 font-bold"></span>
                    </div>
                    <div class="divide-y divide-slate-200 dark:divide-slate-700 text-xs">
                        <div class="grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-white dark:bg-slate-800/90">
                            <span class="font-semibold text-slate-500 dark:text-slate-400">Return ID:</span>
                            <span id="qvSpecReturnId" class="col-span-2 font-mono font-bold text-slate-800 dark:text-slate-100"></span>
                        </div>
                        <div class="grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-slate-50 dark:bg-slate-800/50">
                            <span id="qvSpecOrigInvoiceLabel" class="font-semibold text-slate-500 dark:text-slate-400">Original Invoice:</span>
                            <span id="qvSpecOrigInvoice" class="col-span-2 font-medium text-slate-800 dark:text-slate-200"></span>
                        </div>
                        <div class="grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-white dark:bg-slate-800/90">
                            <span id="qvSpecPartyLabel" class="font-semibold text-slate-500 dark:text-slate-400">Customer Name:</span>
                            <span id="qvSpecPartyName" class="col-span-2 font-medium text-slate-800 dark:text-slate-200"></span>
                        </div>
                        <div class="grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-slate-50 dark:bg-slate-800/50">
                            <span class="font-semibold text-slate-500 dark:text-slate-400">Contact Mobile:</span>
                            <span id="qvSpecPartyMobile" class="col-span-2 font-medium text-slate-800 dark:text-slate-200"></span>
                        </div>
                        <div class="grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-white dark:bg-slate-800/90">
                            <span class="font-semibold text-slate-500 dark:text-slate-400">Returned Product:</span>
                            <span id="qvSpecProductName" class="col-span-2 font-bold text-slate-800 dark:text-slate-100"></span>
                        </div>
                        <div class="grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-slate-50 dark:bg-slate-800/50">
                            <span class="font-semibold text-slate-500 dark:text-slate-400">Return Quantity:</span>
                            <span id="qvSpecQty" class="col-span-2 font-bold text-slate-800 dark:text-slate-100"></span>
                        </div>
                        <div class="grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-white dark:bg-slate-800/90">
                            <span class="font-semibold text-slate-500 dark:text-slate-400">Refund Amount:</span>
                            <span id="qvSpecRefundAmount" class="col-span-2 font-bold text-rose-600 dark:text-rose-400"></span>
                        </div>
                        <div class="grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-slate-50 dark:bg-slate-800/50">
                            <span class="font-semibold text-slate-500 dark:text-slate-400">Due Adjustment:</span>
                            <span id="qvSpecDueAmount" class="col-span-2 font-bold text-emerald-600 dark:text-emerald-400"></span>
                        </div>
                        <div class="grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-white dark:bg-slate-800/90">
                            <span class="font-semibold text-slate-500 dark:text-slate-400">Processed On:</span>
                            <span id="qvSpecTimestamp" class="col-span-2 font-medium text-slate-800 dark:text-slate-200"></span>
                        </div>
                    </div>
                </div>

                <!-- Returned Products Breakdown Table for Multi-Product Returns -->
                <div id="qvItemsBreakdownWrapper" class="rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden mt-3">
                    <div class="bg-slate-100 dark:bg-slate-800 px-5 sm:px-6 py-2.5 border-b border-slate-200 dark:border-slate-700 font-bold text-xs text-slate-700 dark:text-slate-200 uppercase tracking-wider flex items-center justify-between">
                        <span><i class="fa-solid fa-boxes-stacked text-emerald-600 me-1.5"></i> Returned Products Breakdown</span>
                        <span id="qvItemsBreakdownBadge" class="display-info-box font-bold text-emerald-700 dark:text-emerald-400 px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-slate-800 text-xs">0 Items</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left">
                            <thead class="bg-slate-50 dark:bg-slate-800/80 text-slate-600 dark:text-slate-300 font-semibold border-b border-slate-200 dark:border-slate-700 uppercase tracking-wider">
                                <tr>
                                    <th class="p-2.5 text-center w-10">SL</th>
                                    <th class="p-2.5">Product Name</th>
                                    <th class="p-2.5 text-center w-24">Return Qty</th>
                                    <th class="p-2.5 text-end w-28">Sale Rate</th>
                                    <th class="p-2.5 text-end w-32">Refund Amount</th>
                                </tr>
                            </thead>
                            <tbody id="qvItemsBreakdownTbody" class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-200"></tbody>
                            <tfoot class="bg-slate-50 dark:bg-slate-800/60 font-bold border-t border-slate-200 dark:border-slate-700">
                                <tr>
                                    <td colspan="2" class="p-2.5 text-end text-slate-600 dark:text-slate-400">Total:</td>
                                    <td id="qvItemsBreakdownTotalQty" class="p-2.5 text-center text-slate-800 dark:text-slate-100 whitespace-nowrap">0 pcs</td>
                                    <td></td>
                                    <td id="qvItemsBreakdownTotalAmount" class="p-2.5 text-end text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ 0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal Footer: Sticky bottom, Actions + Cancel button -->
            <div class="modal-footer sticky bottom-0 z-20 px-4 py-2.5 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 flex items-center justify-between flex-shrink-0">
                <div id="qvFooterActionLinks" class="flex items-center gap-2 flex-wrap"></div>
                <button type="button" class="px-4 h-[38px] min-h-[38px] max-h-[38px] rounded-xl bg-red-600 hover:bg-red-700 active:scale-[0.98] text-white text-xs sm:text-sm font-semibold transition-all shadow-sm flex items-center justify-center border-0" data-bs-dismiss="modal" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important;">Close</button>
            </div>
        </div>
    </div>
</div>

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

    #quickInvoiceSearchInput,
    #quickInvoiceSearchInput:focus,
    #historySearchInput,
    #historySearchInput:focus,
    body[light-mode="dark"] #quickInvoiceSearchInput,
    body[light-mode="dark"] #historySearchInput {
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

    body[light-mode="dark"] #quickInvoiceSearchInput,
    body[light-mode="dark"] #historySearchInput,
    body[light-mode="dark"] .search-input-wrapper,
    body[data-layout-mode="dark"] .search-input-wrapper,
    html.dark .search-input-wrapper,
    body.dark-mode .search-input-wrapper,
    body.dark .search-input-wrapper {
        border-color: #334155 !important;
        background-color: rgba(30, 41, 59, 0.9) !important;
    }
    body[light-mode="dark"] .entries-wrapper,
    body[data-layout-mode="dark"] .entries-wrapper,
    html.dark .entries-wrapper,
    body.dark-mode .entries-wrapper,
    body.dark .entries-wrapper {
        border-color: #334155 !important;
        background-color: rgba(30, 41, 59, 0.9) !important;
    }
    body[light-mode="dark"] #searchCardBox,
    body[data-layout-mode="dark"] #searchCardBox,
    html.dark #searchCardBox,
    body.dark-mode #searchCardBox,
    body.dark #searchCardBox {
        background-color: rgba(30, 41, 59, 0.4) !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #tabPurchaseReturnBtn,
    body[data-layout-mode="dark"] #tabPurchaseReturnBtn,
    html.dark #tabPurchaseReturnBtn,
    body.dark-mode #tabPurchaseReturnBtn,
    body.dark #tabPurchaseReturnBtn {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .return-mobile-card,
    body[data-layout-mode="dark"] .return-mobile-card,
    html.dark .return-mobile-card,
    body[light-mode="dark"] #display-info .display-info-box,
    body[data-layout-mode="dark"] #display-info .display-info-box,
    html.dark #display-info .display-info-box {
        border-color: #334155 !important;
    }

    /* Return Action Buttons (View, Invoice, Profile) */
    .btn-return-action {
        width: 28px !important;
        height: 28px !important;
        min-width: 28px !important;
        min-height: 28px !important;
        max-width: 28px !important;
        max-height: 28px !important;
        border-radius: 8px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.15s ease-in-out !important;
        text-decoration: none !important;
        cursor: pointer !important;
        padding: 0 !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
    }
    .btn-return-action:active {
        transform: scale(0.95);
    }

    /* Light Mode */
    .btn-return-action-view {
        background-color: #ecfdf5 !important;
        color: #047857 !important;
        border: 1px solid #a7f3d0 !important;
    }
    .btn-return-action-view:hover {
        background-color: #059669 !important;
        color: #ffffff !important;
        border-color: #059669 !important;
    }
    .btn-return-action-view:hover i,
    .btn-return-action-view:hover svg {
        color: #ffffff !important;
    }

    .btn-return-action-invoice {
        background-color: #eff6ff !important;
        color: #1d4ed8 !important;
        border: 1px solid #bfdbfe !important;
    }
    .btn-return-action-invoice:hover {
        background-color: #2563eb !important;
        color: #ffffff !important;
        border-color: #2563eb !important;
    }
    .btn-return-action-invoice:hover i,
    .btn-return-action-invoice:hover svg {
        color: #ffffff !important;
    }

    .btn-return-action-profile {
        background-color: #faf5ff !important;
        color: #7e22ce !important;
        border: 1px solid #e9d5ff !important;
    }
    .btn-return-action-profile:hover {
        background-color: #9333ea !important;
        color: #ffffff !important;
        border-color: #9333ea !important;
    }
    .btn-return-action-profile:hover i,
    .btn-return-action-profile:hover svg {
        color: #ffffff !important;
    }

    /* Dark Mode: subtle soft borders, never harsh white */
    body[light-mode="dark"] .btn-return-action,
    body[data-layout-mode="dark"] .btn-return-action,
    html.dark .btn-return-action,
    body.dark-mode .btn-return-action,
    body.dark .btn-return-action {
        border-color: rgba(255, 255, 255, 0.12) !important;
    }

    body[light-mode="dark"] .btn-return-action-view,
    body[data-layout-mode="dark"] .btn-return-action-view,
    html.dark .btn-return-action-view,
    body.dark-mode .btn-return-action-view,
    body.dark .btn-return-action-view {
        background-color: rgba(6, 78, 59, 0.4) !important;
        color: #6ee7b7 !important;
    }
    body[light-mode="dark"] .btn-return-action-view:hover,
    body[data-layout-mode="dark"] .btn-return-action-view:hover,
    html.dark .btn-return-action-view:hover,
    body.dark-mode .btn-return-action-view:hover,
    body.dark .btn-return-action-view:hover {
        background-color: #059669 !important;
        color: #ffffff !important;
        border-color: #059669 !important;
    }

    body[light-mode="dark"] .btn-return-action-invoice,
    body[data-layout-mode="dark"] .btn-return-action-invoice,
    html.dark .btn-return-action-invoice,
    body.dark-mode .btn-return-action-invoice,
    body.dark .btn-return-action-invoice {
        background-color: rgba(30, 58, 138, 0.4) !important;
        color: #93c5fd !important;
    }
    body[light-mode="dark"] .btn-return-action-invoice:hover,
    body[data-layout-mode="dark"] .btn-return-action-invoice:hover,
    html.dark .btn-return-action-invoice:hover,
    body.dark-mode .btn-return-action-invoice:hover,
    body.dark .btn-return-action-invoice:hover {
        background-color: #2563eb !important;
        color: #ffffff !important;
        border-color: #2563eb !important;
    }

    body[light-mode="dark"] .btn-return-action-profile,
    body[data-layout-mode="dark"] .btn-return-action-profile,
    html.dark .btn-return-action-profile,
    body.dark-mode .btn-return-action-profile,
    body.dark .btn-return-action-profile {
        background-color: rgba(88, 28, 135, 0.4) !important;
        color: #d8b4fe !important;
    }
    body[light-mode="dark"] .btn-return-action-profile:hover,
    body[data-layout-mode="dark"] .btn-return-action-profile:hover,
    html.dark .btn-return-action-profile:hover,
    body.dark-mode .btn-return-action-profile:hover,
    body.dark .btn-return-action-profile:hover {
        background-color: #9333ea !important;
        color: #ffffff !important;
        border-color: #9333ea !important;
    }

    /* Mobile Action Buttons in Dark Mode */
    body[light-mode="dark"] .btn-mobile-view,
    body[data-layout-mode="dark"] .btn-mobile-view,
    html.dark .btn-mobile-view,
    body[light-mode="dark"] .btn-mobile-invoice,
    body[data-layout-mode="dark"] .btn-mobile-invoice,
    html.dark .btn-mobile-invoice,
    body[light-mode="dark"] .btn-mobile-profile,
    body[data-layout-mode="dark"] .btn-mobile-profile,
    html.dark .btn-mobile-profile {
        border-color: rgba(255, 255, 255, 0.12) !important;
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
    let activeReturnTab = 'sales'; // 'sales' or 'purchase'
    let rawReturnList = [];
    let currentFilteredReturns = [];
    let currentPage = 1;
    let pageSize = 15;

    document.addEventListener("DOMContentLoaded", () => {
        fetchActiveReturnList();

        $("#historySearchInput").on("keyup search input", function () {
            currentPage = 1;
            renderPaginatedReturnList();
        });

        $("#entries").on("change", function () {
            pageSize = parseInt($(this).val()) || 15;
            currentPage = 1;
            renderPaginatedReturnList();
        });
    });

    function switchReturnTab(tab) {
        activeReturnTab = tab;
        const salesBtn = document.getElementById('tabSalesReturnBtn');
        const purchaseBtn = document.getElementById('tabPurchaseReturnBtn');
        const mainNewBtn = document.getElementById('mainNewReturnBtn');

        const searchCardBox = document.getElementById('searchCardBox');
        const searchTitle = document.getElementById('searchCardTitle');
        const searchDesc = document.getElementById('searchCardDesc');
        const searchInput = document.getElementById('quickInvoiceSearchInput');

        const historyTitle = document.getElementById('historyTableTitle');
        const thInvoiceNo = document.getElementById('thInvoiceNo');
        const thPartyName = document.getElementById('thPartyName');

        if (tab === 'purchase') {
            salesBtn.className = 'inline-flex items-center gap-2 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 active:scale-[0.98] text-sm font-semibold rounded-xl shadow-sm transition-all duration-150';
            purchaseBtn.className = 'inline-flex items-center gap-2 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150';
            
            mainNewBtn.innerHTML = `
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>New Purchase Return</span>
            `;

            searchCardBox.style.borderLeft = '5px solid #0d9488 !important';
            searchTitle.innerHTML = `<i class="fa-solid fa-magnifying-glass text-teal-600"></i> Quick Purchase Memo Search & Process Return`;
            searchDesc.innerText = `Search purchase memo number to process return to supplier:`;
            searchInput.placeholder = `Enter purchase memo number (e.g. #PurID00001)...`;

            historyTitle.innerHTML = `<i class="fa-solid fa-truck-ramp-box text-emerald-600"></i> Purchase Return History`;
            thInvoiceNo.innerText = 'Purchase Memo No';
            thPartyName.innerText = 'Supplier Name';
        } else {
            salesBtn.className = 'inline-flex items-center gap-2 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150';
            purchaseBtn.className = 'inline-flex items-center gap-2 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 active:scale-[0.98] text-sm font-semibold rounded-xl shadow-sm transition-all duration-150';

            mainNewBtn.innerHTML = `
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>New Sales Return</span>
            `;

            searchCardBox.style.borderLeft = '5px solid #15803d !important';
            searchTitle.innerHTML = `<i class="fa-solid fa-magnifying-glass text-emerald-600"></i> Quick Invoice Search & Process Return`;
            searchDesc.innerText = `Search invoice number to process sales return:`;
            searchInput.placeholder = `Enter invoice number (e.g. #InvID00001)...`;

            historyTitle.innerHTML = `<i class="fa-solid fa-clock-rotate-left text-emerald-600"></i> Sales Return History`;
            thInvoiceNo.innerText = 'Invoice No';
            thPartyName.innerText = 'Customer Name';
        }

        searchInput.value = '';
        $("#historySearchInput").val('');
        currentPage = 1;
        fetchActiveReturnList();
    }

    function triggerNewReturnModal() {
        openReturnModal('', activeReturnTab);
    }

    function triggerQuickReturnSearch() {
        const val = document.getElementById('quickInvoiceSearchInput').value.trim();
        if (!val) {
            alert(activeReturnTab === 'purchase' ? 'Please enter a purchase memo number' : 'Please enter an invoice number');
            return;
        }
        openReturnModal(val, activeReturnTab);
    }

    async function fetchActiveReturnList() {
        try {
            if (typeof showLoader === "function") showLoader();

            let url = activeReturnTab === 'purchase' ? '/api/purchase-return-list' : '/api/return-product-list';
            const res = await axios.get(url, HeaderToken());
            if (typeof hideLoader === "function") hideLoader();

            if (res.data && res.data.status === 'success') {
                rawReturnList = (activeReturnTab === 'purchase' ? res.data.PurchaseReturnData : res.data.ProductReturnData) || [];
                renderPaginatedReturnList();
            } else {
                document.getElementById("tableList").innerHTML = `<tr><td colspan="7" class="text-center py-6 text-rose-500 font-semibold">Failed to load return history</td></tr>`;
            }
        } catch (e) {
            if (typeof hideLoader === "function") hideLoader();
            console.error("Fetch Return List Error:", e);
        }
    }

    function renderPaginatedReturnList() {
        if (!rawReturnList) return;

        let searchVal = ($("#historySearchInput").val() || "").toLowerCase().trim();

        // 1. Filter
        let filtered = rawReturnList.filter(item => {
            const refNo = (activeReturnTab === 'purchase' ? item.purchase_no : item.order_no) || '';
            const partyName = (activeReturnTab === 'purchase' ? item.supplier_name : item.customer_name) || '';
            const product = item.product_name || '';
            const date = item.date || '';

            return !searchVal || 
                   refNo.toLowerCase().includes(searchVal) || 
                   partyName.toLowerCase().includes(searchVal) || 
                   product.toLowerCase().includes(searchVal) ||
                   date.toLowerCase().includes(searchVal);
        });

        // 2. New data top-a dekhabe
        filtered.sort((a, b) => (b.id || 0) - (a.id || 0));
        currentFilteredReturns = filtered;

        // Total sum calculations
        let sumQty = 0;
        let sumAmount = 0;
        filtered.forEach(item => {
            sumQty += parseInt(item.quantity) || 0;
            sumAmount += parseFloat(item.amount) || 0;
        });
        document.getElementById('tfootTotalQty').innerText = `${sumQty} pcs`;
        document.getElementById('tfootTotalAmount').innerText = `৳ ${formatMoney(sumAmount)}`;
        document.getElementById('returnRecordCountBadge').innerText = `${filtered.length} Records`;

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
            tableList.html(`<tr><td colspan="8" class="text-center text-rose-500 p-8 font-semibold"><svg class="w-6 h-6 mx-auto mb-2 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>No ${activeReturnTab === 'purchase' ? 'purchase' : 'sales'} returns found.</td></tr>`);
            mobileCardList.html(`<div class="p-6 text-center text-rose-500 font-semibold bg-white dark:bg-slate-800 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm">No ${activeReturnTab === 'purchase' ? 'purchase' : 'sales'} returns found.</div>`);
        } else {
            pageItems.forEach(function (item, idx) {
                let realIndex = startIndex + idx;
                const qty = parseInt(item.quantity) || 0;
                const unit = item.unit || 'pcs';
                const amount = parseFloat(item.amount) || 0;
                const refNo = (activeReturnTab === 'purchase' ? item.purchase_no : item.order_no) || 'N/A';
                const partyName = (activeReturnTab === 'purchase' ? item.supplier_name : item.customer_name) || 'N/A';

                // 1. Invoice / Memo Link
                let invoiceLinkHtml = '';
                if (activeReturnTab === 'sales') {
                    if (item.order_id) {
                        invoiceLinkHtml = `
                            <a href="/invoice/${item.order_id}" class="badge bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 dark:border-slate-800 font-mono font-bold hover:bg-emerald-100 hover:text-emerald-800 dark:hover:bg-emerald-900/60 dark:hover:text-emerald-200 transition-colors inline-flex items-center gap-1 group/inv cursor-pointer" title="View original sales invoice #${refNo}">
                                <span>${refNo}</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[9px] opacity-60 group-hover/inv:opacity-100 transition-opacity"></i>
                            </a>
                        `;
                    } else {
                        invoiceLinkHtml = `<span class="badge bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 dark:border-slate-800 font-mono font-bold">${refNo}</span>`;
                    }
                } else {
                    if (item.purchase_id) {
                        invoiceLinkHtml = `
                            <a href="/purchase-invoice/${item.purchase_id}" class="badge bg-teal-50 text-teal-700 dark:bg-teal-950/40 dark:text-teal-300 border border-teal-200 dark:border-slate-800 font-mono font-bold hover:bg-teal-100 hover:text-teal-800 dark:hover:bg-teal-900/60 dark:hover:text-teal-200 transition-colors inline-flex items-center gap-1 group/pur cursor-pointer" title="View original purchase memo #${refNo}">
                                <span>${refNo}</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[9px] opacity-60 group-hover/pur:opacity-100 transition-opacity"></i>
                            </a>
                        `;
                    } else {
                        invoiceLinkHtml = `<span class="badge bg-teal-50 text-teal-700 dark:bg-teal-950/40 dark:text-teal-300 border border-teal-200 dark:border-slate-800 font-mono font-bold">${refNo}</span>`;
                    }
                }

                // 2. Customer / Supplier Link
                let partyLinkHtml = '';
                if (activeReturnTab === 'sales') {
                    if (item.customer_id) {
                        partyLinkHtml = `
                            <a href="/customer/profile/${item.customer_id}" class="font-bold text-slate-800 dark:text-slate-100 hover:text-emerald-600 dark:hover:text-emerald-400 hover:underline transition-colors inline-flex items-center gap-1 group/party" title="View customer profile">
                                <span>${escapeHtml(partyName)}</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[9.5px] opacity-0 group-hover/party:opacity-100 text-emerald-600 transition-opacity"></i>
                            </a>
                        `;
                    } else {
                        partyLinkHtml = `<span class="font-bold text-slate-800 dark:text-slate-100">${escapeHtml(partyName)}</span>`;
                    }
                } else {
                    if (item.supplier_id) {
                        partyLinkHtml = `
                            <a href="/supplier/profile/${item.supplier_id}" class="font-bold text-slate-800 dark:text-slate-100 hover:text-emerald-600 dark:hover:text-emerald-400 hover:underline transition-colors inline-flex items-center gap-1 group/party" title="View supplier profile">
                                <span>${escapeHtml(partyName)}</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[9.5px] opacity-0 group-hover/party:opacity-100 text-emerald-600 transition-opacity"></i>
                            </a>
                        `;
                    } else {
                        partyLinkHtml = `<span class="font-bold text-slate-800 dark:text-slate-100">${escapeHtml(partyName)}</span>`;
                    }
                }

                // 3. Action URLs
                let invoiceViewUrl = activeReturnTab === 'sales' 
                    ? (item.order_id ? `/invoice/${item.order_id}` : null)
                    : (item.purchase_id ? `/purchase-invoice/${item.purchase_id}` : null);
                
                let profileViewUrl = activeReturnTab === 'sales'
                    ? (item.customer_id ? `/customer/profile/${item.customer_id}` : null)
                    : (item.supplier_id ? `/supplier/profile/${item.supplier_id}` : null);

                // Return Reference String
                const returnRefStr = item.return_number || (activeReturnTab === 'purchase' ? `#PurRetID${String(item.id).padStart(5, '0')}` : `#SalesRetID${String(item.id).padStart(5, '0')}`);
                const returnBadgeHtml = `<span class="badge bg-emerald-600 hover:bg-emerald-700 text-white font-mono font-bold text-[10.5px] px-2 py-0.5 rounded shadow-sm inline-flex items-center gap-1 cursor-pointer transition-colors" onclick="openReturnQuickView(${realIndex})" title="View return details: ${returnRefStr}"><i class="fa-solid fa-receipt text-[9px]"></i>${returnRefStr}</span>`;

                // Product Summary with Multi-Item Badge
                let productDisplayHtml = '';
                if (item.items && item.items.length > 1) {
                    productDisplayHtml = `
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <span class="font-medium text-slate-700 dark:text-slate-200">${escapeHtml(item.product_name || '-')}</span>
                            <span class="badge bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 font-bold text-[10px] px-2 py-0.5 rounded-full border border-emerald-300 dark:border-emerald-700 cursor-pointer hover:bg-emerald-200 dark:hover:bg-emerald-900/60 transition-colors inline-flex items-center gap-1" onclick="openReturnQuickView(${realIndex})" title="Click to view all ${item.items.length} returned items">
                                <i class="fa-solid fa-boxes-stacked text-[9px]"></i>${item.items.length} items
                            </span>
                        </div>
                    `;
                } else {
                    productDisplayHtml = `<span class="font-medium text-slate-600 dark:text-slate-300">${escapeHtml(item.product_name || '-')}</span>`;
                }

                // Desktop Table Row
                let row = `
                    <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors border-b border-slate-100 dark:border-slate-800">
                        <td class="p-[10px] text-center font-semibold text-slate-400 dark:text-slate-500">${realIndex + 1}</td>
                        <td class="p-[10px] text-start whitespace-nowrap font-medium text-slate-700 dark:text-slate-300"><i class="fa-regular fa-calendar-check text-emerald-600 me-1"></i> ${formatReturnDate(item.date)}</td>
                        <td class="p-[10px] text-start whitespace-nowrap">
                            <div class="flex flex-col items-start gap-1">
                                ${returnBadgeHtml}
                                ${invoiceLinkHtml}
                            </div>
                        </td>
                        <td class="p-[10px] text-start">${partyLinkHtml}</td>
                        <td class="p-[10px] text-start">${productDisplayHtml}</td>
                        <td class="p-[10px] text-center whitespace-nowrap"><span class="badge bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 font-bold">${qty} ${unit}</span></td>
                        <td class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ ${formatMoney(amount)}</td>
                        <td class="p-[10px] text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1">
                                <button type="button" onclick="openReturnQuickView(${realIndex})" class="btn-return-action btn-return-action-view" title="Quick View Summary" aria-label="Quick View">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </button>
                                ${invoiceViewUrl ? `
                                <a href="${invoiceViewUrl}" class="btn-return-action btn-return-action-invoice" title="Open Original ${activeReturnTab === 'purchase' ? 'Purchase Memo' : 'Sales Invoice'}" aria-label="Open Invoice">
                                    <i class="fa-solid fa-file-invoice text-xs"></i>
                                </a>
                                ` : ''}
                                ${profileViewUrl ? `
                                <a href="${profileViewUrl}" class="btn-return-action btn-return-action-profile" title="View ${activeReturnTab === 'purchase' ? 'Supplier' : 'Customer'} Profile" aria-label="View Profile">
                                    <i class="fa-solid fa-user text-xs"></i>
                                </a>
                                ` : ''}
                            </div>
                        </td>
                    </tr>
                `;
                tableList.append(row);

                // Mobile Card View
                let mobileCard = `
                    <div class="return-mobile-card unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800/90 shadow-sm transition-all mb-3">
                        <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="badge bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold" style="font-size: 10px;">#${realIndex + 1}</span>
                                ${returnBadgeHtml}
                                ${invoiceLinkHtml}
                            </div>
                            <span class="badge bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 font-semibold" style="font-size: 10px;">
                                <i class="fa-regular fa-calendar-check me-1"></i>${formatReturnDate(item.date)}
                            </span>
                        </div>

                        <div class="mb-2">
                            <h6 class="font-bold text-slate-800 dark:text-slate-100 mb-0.5 text-sm leading-snug">${partyLinkHtml}</h6>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                ${productDisplayHtml}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 bg-slate-50 dark:bg-slate-900/50 p-2.5 rounded-xl my-2 text-center items-center border border-slate-100 dark:border-slate-800">
                            <div class="border-r border-slate-300 dark:border-slate-800 text-start px-2">
                                <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">Quantity</span>
                                <span class="font-bold text-slate-800 dark:text-slate-100 text-sm">${qty} ${unit}</span>
                            </div>
                            <div class="text-start px-2">
                                <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">Refund Amount</span>
                                <span class="font-bold text-rose-600 dark:text-rose-400 text-sm">৳ ${formatMoney(amount)}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-800 gap-2">
                            <span class="text-[11px] text-slate-400 font-medium">Actions:</span>
                            <div class="flex items-center gap-1.5">
                                <button type="button" onclick="openReturnQuickView(${realIndex})" class="btn-mobile-view px-2.5 py-1 text-xs font-semibold rounded-lg bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300 border border-emerald-200 dark:border-slate-700 hover:bg-emerald-600 hover:text-white flex items-center gap-1 transition-all cursor-pointer">
                                    <i class="fa-solid fa-eye text-[11px]"></i>
                                    <span>Quick View</span>
                                </button>
                                ${invoiceViewUrl ? `
                                <a href="${invoiceViewUrl}" class="btn-mobile-invoice px-2.5 py-1 text-xs font-semibold rounded-lg bg-blue-50 text-blue-700 dark:bg-blue-950/50 dark:text-blue-300 border border-blue-200 dark:border-slate-700 hover:bg-blue-600 hover:text-white flex items-center gap-1 transition-all">
                                    <i class="fa-solid fa-file-invoice text-[11px]"></i>
                                    <span>${activeReturnTab === 'purchase' ? 'Memo' : 'Invoice'}</span>
                                </a>
                                ` : ''}
                                ${profileViewUrl ? `
                                <a href="${profileViewUrl}" class="btn-mobile-profile px-2.5 py-1 text-xs font-semibold rounded-lg bg-purple-50 text-purple-700 dark:bg-purple-950/50 dark:text-purple-300 border border-purple-200 dark:border-slate-700 hover:bg-purple-600 hover:text-white flex items-center gap-1 transition-all">
                                    <i class="fa-solid fa-user text-[11px]"></i>
                                    <span>Profile</span>
                                </a>
                                ` : ''}
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
                <span class="display-info-box font-bold text-slate-800 dark:text-slate-100 px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-800">${fromCount} – ${toCount}</span>
                <span>of</span>
                <span class="display-info-box font-bold text-emerald-700 dark:text-emerald-400 px-1.5 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-slate-800">${totalItems}</span>
                <span>returns</span>
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
        renderPaginatedReturnList();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    function openReturnQuickView(realIndex) {
        // 1. Reset all fields immediately to prevent stale data
        $("#qvReturnModalTitle").text("Loading Return Details...");
        $("#qvReturnHeaderBadges").empty();
        $("#qvStatReturnDate").text("-");
        $("#qvStatReturnQty").text("-");
        $("#qvStatRefundAmount").text("-");
        $("#qvStatDueAmount").text("-");
        $("#qvReturnTag").text("");
        
        $("#qvSpecReturnId").text("-");
        $("#qvSpecOrigInvoice").empty();
        $("#qvSpecPartyName").empty();
        $("#qvSpecPartyMobile").text("-");
        $("#qvSpecProductName").text("-");
        $("#qvSpecQty").text("-");
        $("#qvSpecRefundAmount").text("-");
        $("#qvSpecDueAmount").text("-");
        $("#qvSpecTimestamp").text("-");
        $("#qvFooterActionLinks").empty();
        $("#qvItemsBreakdownTbody").empty();

        let item = (currentFilteredReturns && currentFilteredReturns[realIndex]) ? currentFilteredReturns[realIndex] : rawReturnList[realIndex];
        if (!item) return;

        const isPurchase = activeReturnTab === 'purchase';
        const returnIdStr = item.return_number || (isPurchase 
            ? `#PurRetID${String(item.id).padStart(5, '0')}`
            : `#SalesRetID${String(item.id).padStart(5, '0')}`);
        const refNo = (isPurchase ? item.purchase_no : item.order_no) || 'N/A';
        const partyName = (isPurchase ? item.supplier_name : item.customer_name) || 'N/A';
        const partyMobile = (isPurchase ? item.supplier_mobile : item.customer_mobile) || 'N/A';
        const qty = parseInt(item.quantity) || 0;
        const unit = item.unit || 'pcs';
        const amount = parseFloat(item.amount) || 0;
        const dueAmount = parseFloat(item.due_amount) || 0;
        const dateStr = formatReturnDate(item.date);
        const timestampStr = item.created_at_formatted || dateStr;

        $("#qvReturnModalTitle").text(isPurchase ? "Purchase Return Summary" : "Sales Return Summary");
        $("#qvReturnTag").text(isPurchase ? "Purchase Return" : "Sales Return");
        $("#qvSpecOrigInvoiceLabel").text(isPurchase ? "Purchase Memo:" : "Original Invoice:");
        $("#qvSpecPartyLabel").text(isPurchase ? "Supplier Name:" : "Customer Name:");

        $("#qvReturnHeaderBadges").html(`
            <span class="badge bg-white/20 text-white font-mono text-[10px] font-bold border border-white/30">${returnIdStr}</span>
            <span class="badge bg-emerald-500/30 text-emerald-100 text-[10px] font-semibold border border-emerald-400/30">${isPurchase ? 'Supplier Return' : 'Customer Return'}</span>
        `);

        $("#qvStatReturnDate").text(dateStr);
        $("#qvStatReturnQty").text(`${qty} ${unit}`);
        $("#qvStatRefundAmount").text(`৳ ${formatMoney(amount)}`);
        $("#qvStatDueAmount").text(`৳ ${formatMoney(dueAmount)}`);

        $("#qvSpecReturnId").text(returnIdStr);

        // Clickable original invoice
        let origInvHtml = '';
        if (isPurchase) {
            if (item.purchase_id) {
                origInvHtml = `
                    <a href="/purchase-invoice/${item.purchase_id}" class="badge bg-teal-50 text-teal-700 dark:bg-teal-950/40 dark:text-teal-300 border border-teal-200 dark:border-slate-800 font-mono font-bold hover:bg-teal-100 hover:text-teal-800 dark:hover:bg-teal-900/60 dark:hover:text-teal-200 transition-colors inline-flex items-center gap-1 cursor-pointer" title="Open Purchase Memo #${refNo}">
                        <span>${refNo}</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                    </a>
                `;
            } else {
                origInvHtml = `<span class="badge bg-teal-50 text-teal-700 dark:bg-teal-950/40 dark:text-teal-300 border border-teal-200 dark:border-slate-800 font-mono font-bold">${refNo}</span>`;
            }
        } else {
            if (item.order_id) {
                origInvHtml = `
                    <a href="/invoice/${item.order_id}" class="badge bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 dark:border-slate-800 font-mono font-bold hover:bg-emerald-100 hover:text-emerald-800 dark:hover:bg-emerald-900/60 dark:hover:text-emerald-200 transition-colors inline-flex items-center gap-1 cursor-pointer" title="Open Sales Invoice #${refNo}">
                        <span>${refNo}</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                    </a>
                `;
            } else {
                origInvHtml = `<span class="badge bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 dark:border-slate-800 font-mono font-bold">${refNo}</span>`;
            }
        }
        $("#qvSpecOrigInvoice").html(origInvHtml);

        // Clickable party name
        let partyNameHtml = '';
        if (isPurchase) {
            if (item.supplier_id) {
                partyNameHtml = `
                    <a href="/supplier/profile/${item.supplier_id}" class="font-bold text-slate-800 dark:text-slate-100 hover:text-emerald-600 dark:hover:text-emerald-400 hover:underline transition-colors inline-flex items-center gap-1" title="Open Supplier Profile">
                        <span>${escapeHtml(partyName)}</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-emerald-600"></i>
                    </a>
                `;
            } else {
                partyNameHtml = `<span class="font-medium text-slate-800 dark:text-slate-200">${escapeHtml(partyName)}</span>`;
            }
        } else {
            if (item.customer_id) {
                partyNameHtml = `
                    <a href="/customer/profile/${item.customer_id}" class="font-bold text-slate-800 dark:text-slate-100 hover:text-emerald-600 dark:hover:text-emerald-400 hover:underline transition-colors inline-flex items-center gap-1" title="Open Customer Profile">
                        <span>${escapeHtml(partyName)}</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-emerald-600"></i>
                    </a>
                `;
            } else {
                partyNameHtml = `<span class="font-medium text-slate-800 dark:text-slate-200">${escapeHtml(partyName)}</span>`;
            }
        }
        $("#qvSpecPartyName").html(partyNameHtml);

        $("#qvSpecPartyMobile").text(partyMobile || 'N/A');
        $("#qvSpecProductName").text(item.product_name || '-');
        $("#qvSpecQty").text(`${qty} ${unit}`);
        $("#qvSpecRefundAmount").text(`৳ ${formatMoney(amount)}`);
        $("#qvSpecDueAmount").text(`৳ ${formatMoney(dueAmount)}`);
        $("#qvSpecTimestamp").text(timestampStr);

        // Populate Products Breakdown Table
        let itemsList = item.items && item.items.length > 0 ? item.items : [{
            product_name: item.product_name || 'Product',
            quantity: qty,
            unit: unit,
            unit_price: qty > 0 ? (amount / qty) : 0,
            amount: amount
        }];

        let tbody = $("#qvItemsBreakdownTbody");
        tbody.empty();
        itemsList.forEach((it, i) => {
            let uPrice = it.unit_price ? parseFloat(it.unit_price) : (it.quantity > 0 ? (it.amount / it.quantity) : 0);
            let lAmt = parseFloat(it.amount) || 0;
            let tr = `
                <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors">
                    <td class="p-2.5 text-center text-slate-400 font-medium">${i + 1}</td>
                    <td class="p-2.5 font-semibold text-slate-800 dark:text-slate-100">${escapeHtml(it.product_name || 'Product')}</td>
                    <td class="p-2.5 text-center whitespace-nowrap"><span class="badge bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 font-bold">${it.quantity} ${it.unit || 'pcs'}</span></td>
                    <td class="p-2.5 text-end whitespace-nowrap text-slate-700 dark:text-slate-300">৳ ${formatMoney(uPrice)}</td>
                    <td class="p-2.5 text-end whitespace-nowrap font-bold text-rose-600 dark:text-rose-400">৳ ${formatMoney(lAmt)}</td>
                </tr>
            `;
            tbody.append(tr);
        });
        $("#qvItemsBreakdownBadge").text(`${itemsList.length} ${itemsList.length === 1 ? 'Product' : 'Products'}`);
        $("#qvItemsBreakdownTotalQty").text(`${qty} ${unit}`);
        $("#qvItemsBreakdownTotalAmount").text(`৳ ${formatMoney(amount)}`);

        let footerLinksHtml = '';
        if (isPurchase) {
            if (item.purchase_id) {
                footerLinksHtml += `
                    <a href="/purchase-invoice/${item.purchase_id}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] rounded-xl bg-teal-50 hover:bg-teal-100 text-teal-700 dark:bg-teal-950/40 dark:hover:bg-teal-900/60 dark:text-teal-300 border border-teal-200 dark:border-slate-700 text-xs sm:text-sm font-semibold transition-all">
                        <i class="fa-solid fa-file-invoice text-xs"></i>
                        <span>Open Purchase Memo</span>
                    </a>
                `;
            }
            if (item.supplier_id) {
                footerLinksHtml += `
                    <a href="/supplier/profile/${item.supplier_id}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-700 dark:bg-purple-950/40 dark:hover:bg-purple-900/60 dark:text-purple-300 border border-purple-200 dark:border-slate-700 text-xs sm:text-sm font-semibold transition-all">
                        <i class="fa-solid fa-truck text-xs"></i>
                        <span>Supplier Profile</span>
                    </a>
                `;
            }
        } else {
            if (item.order_id) {
                footerLinksHtml += `
                    <a href="/invoice/${item.order_id}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:hover:bg-emerald-900/60 dark:text-emerald-300 border border-emerald-200 dark:border-slate-700 text-xs sm:text-sm font-semibold transition-all">
                        <i class="fa-solid fa-file-invoice text-xs"></i>
                        <span>Open Invoice</span>
                    </a>
                `;
            }
            if (item.customer_id) {
                footerLinksHtml += `
                    <a href="/customer/profile/${item.customer_id}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-700 dark:bg-purple-950/40 dark:hover:bg-purple-900/60 dark:text-purple-300 border border-purple-200 dark:border-slate-700 text-xs sm:text-sm font-semibold transition-all">
                        <i class="fa-solid fa-user text-xs"></i>
                        <span>Customer Profile</span>
                    </a>
                `;
            }
        }
        $("#qvFooterActionLinks").html(footerLinksHtml);

        const modalEl = document.getElementById('returnQuickViewModal');
        if (modalEl && window.bootstrap) {
            const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
            modalInstance.show();
        }
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatReturnDate(dateString) {
        if (!dateString) return 'N/A';
        const d = new Date(dateString);
        if (isNaN(d.getTime())) return dateString;
        const options = { year: 'numeric', month: 'short', day: '2-digit' };
        return d.toLocaleDateString('en-US', options);
    }

    function formatMoney(amount) {
        if (amount === null || isNaN(amount)) return "0.00";
        return parseFloat(amount).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }
</script>
