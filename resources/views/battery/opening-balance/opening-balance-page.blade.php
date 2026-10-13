@extends('layouts.dashboard-sidenav')
@section('title', 'Opening Balance List - MARSS CORPORATION')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Hero Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-screen flex flex-col justify-between">
        <div class="data-table flex-grow">
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-10">
                    
                    <!-- 1. Top Section: Page Title & Add Opening Balance Button (Fixed 38px) -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                        <!-- Page Title -->
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Opening Balance List</h1>
                        </div>

                        <!-- Right Controls: + Add Opening Balance Button (Fixed 38px) -->
                        <div class="flex items-center flex-wrap gap-2">
                            <button id="openModalBtns" onclick="openOpeningBalanceModal()" type="button" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Add Opening Balance</span>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Controls & Filter Row: Search Bar + Show Entry -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2.5 sm:gap-3 mb-4">
                        <div class="flex items-center gap-2 sm:gap-2.5 w-full md:w-auto">
                            <!-- Search Bar -->
                            <div class="search-input-wrapper unified-ui-border flex-1 md:w-[280px] lg:w-[320px] h-[38px] flex items-center px-3 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                                <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0" placeholder="Search Opening Balance..." />
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

                    <!-- 3. Desktop Table (SL left, Action far right, Unified container border) -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                    <th class="p-[10px] text-start w-[130px] whitespace-nowrap">Date</th>
                                    <th class="p-[10px] text-end w-[180px] whitespace-nowrap">Opening Balance Amount</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Note</th>
                                    <th class="p-[10px] text-center w-[75px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableList" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200"></tbody>
                            <tfoot class="bg-slate-50/90 dark:bg-slate-800/70 text-slate-800 dark:text-slate-100 font-bold border-t-2 border-emerald-600/30 dark:border-emerald-600/20 text-xs sm:text-sm">
                                <tr>
                                    <td colspan="2" class="p-[10px] text-end font-bold text-slate-600 dark:text-slate-300">Total Opening Balance:</td>
                                    <td id="totalOpeningBalanceAmount" class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ 0.00</td>
                                    <td colspan="2" class="p-[10px]"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- 4. Mobile Card List View (< 768px) -->
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

<!-- Add / Edit Opening Balance Modal Start -->
<div class="modal fade" id="createOpeningBalanceModal" tabindex="-1" aria-labelledby="createOpeningBalanceModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
            <!-- Sticky Top Green Header -->
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.2); color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <h5 class="modal-title m-0 text-white fw-bold" id="createOpeningBalanceModalLabel" style="font-size: 16px; color: #ffffff !important;">Add New Opening Balance</h5>
                </div>
                <!-- Circular Red Close Button with White Icon -->
                <button type="button" class="custom-modal-close-btn d-flex align-items-center justify-content-center border-0 shadow-sm" data-bs-dismiss="modal" onclick="closeOpeningBalanceModal()" aria-label="Close" style="position: relative !important; top: auto !important; right: auto !important; width: 26px !important; height: 26px !important; min-width: 26px !important; min-height: 26px !important; border-radius: 50% !important; background-color: #ef4444 !important; color: #ffffff !important; cursor: pointer !important; transition: all 0.2s ease; padding: 0 !important; margin: 0 !important; flex-shrink: 0 !important;" title="Close">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Scrollable Modal Body (strictly left aligned, 2-column layout!) -->
            <div class="modal-body custom-scrollbar text-start" style="text-align: left !important;">
                <form id="openingBalanceForm" onsubmit="return SaveOpeningBalance(event)" class="text-start" style="text-align: left !important;">
                    <input type="hidden" id="obId" value="" />
                    <div class="row g-2.5 text-start" style="text-align: left !important;">
                        
                        <!-- Date (Column 1) -->
                        <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                            <label for="obDate" class="custom-modal-label text-start" style="text-align: left !important;">
                                <i class="fa-regular fa-calendar-days text-emerald-600 me-1"></i> Date <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="custom-modal-input text-start" id="obDate" required style="text-align: left !important;" placeholder="YYYY-MM-DD" autocomplete="off" />
                        </div>

                        <!-- Amount (Column 2) -->
                        <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                            <label for="obAmount" class="custom-modal-label text-start" style="text-align: left !important;">
                                Opening Balance Amount (৳) <span class="text-danger">*</span>
                            </label>
                            <input type="number" step="any" placeholder="0.00" id="obAmount" required class="custom-modal-input text-start fw-bold text-rose-600" style="text-align: left !important;" />
                        </div>

                        <!-- Note (Full Column) -->
                        <div class="col-12 text-start" style="text-align: left !important;">
                            <label for="obNote" class="custom-modal-label text-start" style="text-align: left !important;">Note (Optional)</label>
                            <textarea name="obNote" id="obNote" rows="2" placeholder="Enter note or details..." class="custom-modal-input text-start" style="height: 64px !important; padding: 8px 14px !important; resize: none; text-align: left !important;"></textarea>
                        </div>

                    </div>
                </form>
            </div>

            <!-- Sticky Bottom Footer with Red Cancel & Green Save Buttons (Strict 38px height) -->
            <div class="modal-footer d-flex align-items-center justify-content-end gap-2 flex-shrink-0">
                <button type="button" onclick="closeOpeningBalanceModal()" class="btn fw-semibold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important; cursor: pointer; transition: opacity 0.2s;">
                    Cancel
                </button>
                <button type="button" id="saveObBtn" onclick="SaveOpeningBalance(event)" class="btn text-white fw-bold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; font-size: 13.5px !important; cursor: pointer;">
                    Submit
                </button>
            </div>

        </div>
    </div>
</div>
<!-- Add / Edit Opening Balance Modal End -->

<!-- Delete Confirmation Modal Start -->
<div class="modal fade" id="deleteOpeningBalanceModal" tabindex="-1" aria-labelledby="deleteOpeningBalanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm sm:modal-md my-3" style="max-width: 440px;">
        <div class="modal-content bg-white dark:bg-slate-900 border-0 rounded-2xl shadow-2xl overflow-hidden transition-colors flex flex-col" style="border: none !important;">
            
            <!-- Sticky Top Header -->
            <div class="modal-header sticky top-0 z-20 px-4 sm:px-5 py-3.5 bg-rose-600 text-white flex items-center justify-between shadow-sm border-0 flex-shrink-0" style="background-color: #dc2626 !important; color: #ffffff !important; border: none !important;">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </div>
                    <h5 class="modal-title text-base font-bold text-white tracking-tight mb-0" id="deleteOpeningBalanceModalLabel" style="color: #ffffff !important;">Delete Opening Balance</h5>
                </div>
                <!-- Circular Dark Red Close Button with White Icon -->
                <button type="button" class="qv-close-btn" data-bs-dismiss="modal" aria-label="Close" style="width: 30px !important; height: 30px !important; min-width: 30px !important; min-height: 30px !important; border-radius: 50% !important; background-color: #991b1b !important; color: #ffffff !important; border: none !important; display: flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; padding: 0 !important; margin: 0 !important;">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4 text-center">
                <div class="w-14 h-14 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto mb-3.5 border border-rose-100 dark:border-slate-800">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <h4 class="text-base sm:text-lg font-bold text-slate-800 dark:text-slate-100 mb-1.5">Confirm Deletion</h4>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mb-0">Are you sure you want to delete this opening balance? This action cannot be undone.</p>
                <input type="hidden" id="deleteOpeningBalanceID" />
            </div>

            <!-- Sticky Bottom Footer (Strict 38px buttons) -->
            <div class="modal-footer sticky bottom-0 z-20 px-4 sm:px-5 py-3 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 flex items-center justify-center gap-2.5 flex-shrink-0">
                <button type="button" class="px-4 h-[38px] min-h-[38px] max-h-[38px] rounded-xl text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 unified-ui-border text-xs sm:text-sm font-semibold transition-all shadow-sm flex items-center justify-center cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700" data-bs-dismiss="modal">
                    No
                </button>
                <button type="button" onclick="itemDeleteOpeningBalance()" class="px-5 h-[38px] min-h-[38px] max-h-[38px] rounded-xl text-white text-xs sm:text-sm font-semibold transition-all shadow-sm flex items-center justify-center cursor-pointer hover:bg-rose-700 active:scale-[0.98]" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important;">
                    Yes
                </button>
            </div>

        </div>
    </div>
</div>
<!-- Delete Confirmation Modal End -->

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

    #openModalBtns,
    .data-table #openModalBtns {
        height: 38px !important;
        min-height: 38px !important;
        max-height: 38px !important;
        background-color: #15803d !important;
        background: #15803d !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        transition: all 0.2s ease !important;
    }
    #openModalBtns:hover,
    #openModalBtns:focus,
    #openModalBtns:active,
    .data-table #openModalBtns:hover,
    .data-table #openModalBtns:focus,
    .data-table #openModalBtns:active {
        background-color: #166534 !important;
        background: #166534 !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 4px 6px -1px rgba(22, 163, 74, 0.2), 0 2px 4px -2px rgba(22, 163, 74, 0.2) !important;
    }
    #openModalBtns *,
    #openModalBtns:hover *,
    .data-table #openModalBtns *,
    .data-table #openModalBtns:hover * {
        color: #ffffff !important;
        stroke: #ffffff !important;
    }

    .data-table {
        background: transparent !important;
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
    body[light-mode="dark"] .ob-mobile-card,
    body[data-layout-mode="dark"] .ob-mobile-card,
    html.dark .ob-mobile-card,
    body[light-mode="dark"] #display-info .display-info-box,
    body[data-layout-mode="dark"] #display-info .display-info-box,
    html.dark #display-info .display-info-box {
        border-color: #334155 !important;
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

    /* Modal Container & Strict Center Alignment */
    #createOpeningBalanceModal.modal {
        background: rgba(15, 23, 42, 0.6) !important;
        backdrop-filter: blur(4px) !important;
        -webkit-backdrop-filter: blur(4px) !important;
        z-index: 1055 !important;
    }
    #createOpeningBalanceModal.modal.show {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    #createOpeningBalanceModal .modal-dialog {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        max-width: 520px !important;
        width: 95% !important;
        margin: auto !important;
        max-height: 90vh !important;
        height: auto !important;
        display: flex !important;
        align-items: center !important;
    }
    #createOpeningBalanceModal .modal-content {
        border-radius: 16px !important;
        overflow: hidden !important;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        display: flex !important;
        flex-direction: column !important;
        max-height: 90vh !important;
        width: 100% !important;
    }

    #createOpeningBalanceModal .modal-header {
        background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important;
        color: #ffffff !important;
        padding: 12px 20px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        position: relative !important;
        flex-shrink: 0 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15) !important;
    }

    #createOpeningBalanceModal .modal-body {
        padding: 16px 20px !important;
        overflow-y: auto !important;
        max-height: calc(90vh - 125px) !important;
        background-color: #ffffff !important;
        text-align: left !important;
    }

    #createOpeningBalanceModal .modal-footer {
        padding: 10px 20px !important;
        background-color: #f8fafc !important;
        border-top: 1px solid #e2e8f0 !important;
        position: relative !important;
        flex-shrink: 0 !important;
    }

    .custom-modal-label {
        display: block !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #334155 !important;
        margin-top: 6px !important;
        margin-bottom: 4px !important;
        text-align: left !important;
    }

    .custom-modal-input {
        width: 100% !important;
        height: 42px !important;
        padding: 0 14px !important;
        font-size: 13.5px !important;
        color: #0f172a !important;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        outline: none !important;
        transition: border-color 0.15s ease, box-shadow 0.15s ease !important;
        box-sizing: border-box !important;
        text-align: left !important;
    }
    .custom-modal-input:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.2) !important;
    }

    /* Dark Mode Create Modal */
    body[light-mode="dark"] #createOpeningBalanceModal .modal-content,
    body[data-layout-mode="dark"] #createOpeningBalanceModal .modal-content,
    html.dark #createOpeningBalanceModal .modal-content,
    body.dark-mode #createOpeningBalanceModal .modal-content,
    body.dark #createOpeningBalanceModal .modal-content {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #createOpeningBalanceModal .modal-body,
    body[data-layout-mode="dark"] #createOpeningBalanceModal .modal-body,
    html.dark #createOpeningBalanceModal .modal-body,
    body.dark-mode #createOpeningBalanceModal .modal-body,
    body.dark #createOpeningBalanceModal .modal-body {
        background-color: #0f172a !important;
    }
    body[light-mode="dark"] #createOpeningBalanceModal .modal-footer,
    body[data-layout-mode="dark"] #createOpeningBalanceModal .modal-footer,
    html.dark #createOpeningBalanceModal .modal-footer,
    body.dark-mode #createOpeningBalanceModal .modal-footer,
    body.dark #createOpeningBalanceModal .modal-footer {
        background-color: #1e293b !important;
        border-top-color: #334155 !important;
    }
    body[light-mode="dark"] #createOpeningBalanceModal .custom-modal-label,
    body[data-layout-mode="dark"] #createOpeningBalanceModal .custom-modal-label,
    html.dark #createOpeningBalanceModal .custom-modal-label,
    body.dark-mode #createOpeningBalanceModal .custom-modal-label,
    body.dark #createOpeningBalanceModal .custom-modal-label {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] #createOpeningBalanceModal .custom-modal-input,
    body[data-layout-mode="dark"] #createOpeningBalanceModal .custom-modal-input,
    html.dark #createOpeningBalanceModal .custom-modal-input,
    body.dark-mode #createOpeningBalanceModal .custom-modal-input,
    body.dark #createOpeningBalanceModal .custom-modal-input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }

    /* Delete Modal Strict Center */
    #deleteOpeningBalanceModal.modal {
        background: rgba(15, 23, 42, 0.6) !important;
        backdrop-filter: blur(4px) !important;
        -webkit-backdrop-filter: blur(4px) !important;
        z-index: 1060 !important;
    }
    #deleteOpeningBalanceModal.modal.show {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    #deleteOpeningBalanceModal .modal-dialog {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        max-width: 440px !important;
        width: 92% !important;
        margin: auto !important;
    }
    #deleteOpeningBalanceModal .modal-content {
        border: none !important;
        border-radius: 1rem !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        overflow: hidden !important;
    }
    body[light-mode="dark"] #deleteOpeningBalanceModal .modal-content,
    html.dark #deleteOpeningBalanceModal .modal-content,
    body.dark #deleteOpeningBalanceModal .modal-content,
    body[data-layout-mode="dark"] #deleteOpeningBalanceModal .modal-content {
        background-color: #0f172a !important;
        border: 1px solid #1e293b !important;
    }

    /* Flatpickr Calendar */
    .flatpickr-calendar {
        z-index: 99999999 !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.15), 0 8px 10px -6px rgba(0,0,0,0.1) !important;
        border: 1px solid #cbd5e1 !important;
    }
    .flatpickr-monthDropdown-months {
        pointer-events: none !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        appearance: none !important;
        cursor: default !important;
        background: transparent !important;
        border: none !important;
        outline: none !important;
        font-weight: 600;
    }
    body[data-layout-mode="dark"] .flatpickr-calendar,
    body[light-mode="dark"] .flatpickr-calendar,
    html.dark .flatpickr-calendar,
    body.dark-mode .flatpickr-calendar,
    body.dark .flatpickr-calendar {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-months,
    body[light-mode="dark"] .flatpickr-months,
    html.dark .flatpickr-months,
    body[data-layout-mode="dark"] .flatpickr-month,
    body[light-mode="dark"] .flatpickr-month {
        background: #0f172a !important;
        color: #f1f5f9 !important;
        fill: #f1f5f9 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-current-month,
    body[light-mode="dark"] .flatpickr-current-month,
    html.dark .flatpickr-current-month {
        color: #f1f5f9 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-day,
    body[light-mode="dark"] .flatpickr-day,
    html.dark .flatpickr-day {
        color: #e2e8f0 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-day:hover,
    body[light-mode="dark"] .flatpickr-day:hover,
    html.dark .flatpickr-day:hover {
        background: #334155 !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-day.today,
    body[light-mode="dark"] .flatpickr-day.today,
    html.dark .flatpickr-day.today {
        border-color: #10b981 !important;
        color: #10b981 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-day.selected,
    body[light-mode="dark"] .flatpickr-day.selected,
    html.dark .flatpickr-day.selected {
        background: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }
</style>

<script>
    let rawOpeningBalanceData = [];
    let currentPage = 1;
    let pageSize = 15;
    window.obDatepicker = null;

    function formatBdCurrency(amount) {
        let num = parseFloat(amount);
        if (isNaN(num)) return "0.00";
        return num.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function initObDatepicker() {
        const dateInput = document.getElementById('obDate');
        if (dateInput && typeof flatpickr !== 'undefined') {
            if (window.obDatepicker) window.obDatepicker.destroy();
            window.obDatepicker = flatpickr(dateInput, {
                dateFormat: "Y-m-d",
                defaultDate: new Date(),
                allowInput: true,
                clickOpens: true,
                disableMobile: true,
                onOpen: function() {
                    $(document).off('focusin.bs.modal');
                }
            });
        }
    }

    function openOpeningBalanceModal() {
        document.getElementById('openingBalanceForm').reset();
        document.getElementById('obId').value = '';
        document.getElementById('createOpeningBalanceModalLabel').innerText = 'Add New Opening Balance';
        document.getElementById('saveObBtn').innerText = 'Submit';
        
        if (window.obDatepicker) {
            window.obDatepicker.setDate(new Date(), true);
        } else {
            const dateInput = document.getElementById('obDate');
            if (dateInput) dateInput.value = new Date().toISOString().split('T')[0];
        }

        $('#createOpeningBalanceModal').modal('show');
    }

    function closeOpeningBalanceModal() {
        $('#createOpeningBalanceModal').modal('hide');
        document.getElementById('openingBalanceForm').reset();
        document.getElementById('obId').value = '';
    }

    $(document).ready(function () {
        getList();
        $("#searchInput").val("");
        initObDatepicker();

        $('#createOpeningBalanceModal').on('shown.bs.modal', function () {
            initObDatepicker();
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
    });

    async function getList() {
        try {
            if (typeof showLoader === 'function') showLoader();
            let res = await axios.get("/api/battery/opening-balance-list", HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data.status === "success" && Array.isArray(res.data.data)) {
                rawOpeningBalanceData = res.data.data;
                renderPaginatedList();
            } else {
                console.error("Failed to fetch opening balance: No data found.");
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            if (typeof unauthorized === 'function') unauthorized(e.response?.status);
        }
    }

    function renderPaginatedList() {
        if (!rawOpeningBalanceData) return;

        let searchTerm = ($("#searchInput").val() || "").toLowerCase().trim();

        // 1. Filter
        let filtered = rawOpeningBalanceData.filter(function (item) {
            let note = (item.note || "").toLowerCase();
            let date = (item.date || "").toLowerCase();
            let amount = (item.amount ?? item.opening_balance ?? "").toString();

            return !searchTerm || note.includes(searchTerm) || date.includes(searchTerm) || amount.includes(searchTerm);
        });

        // 2. New data top-a dekhabe
        filtered.sort((a, b) => (b.id || 0) - (a.id || 0));

        // Total amount
        let totalAmount = 0;
        filtered.forEach(item => {
            totalAmount += parseFloat(item.amount ?? item.opening_balance) || 0;
        });
        $("#totalOpeningBalanceAmount").text(`৳ ${formatBdCurrency(totalAmount)}`);

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
            tableList.html('<tr><td colspan="5" class="text-center text-rose-500 p-8 font-semibold"><svg class="w-6 h-6 mx-auto mb-2 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>No opening balance found.</td></tr>');
            mobileCardList.html('<div class="p-6 text-center text-rose-500 font-semibold bg-white dark:bg-slate-800 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm">No opening balance found.</div>');
        } else {
            pageItems.forEach(function (item, idx) {
                let realIndex = startIndex + idx;
                let amount = parseFloat(item.amount ?? item.opening_balance) || 0;

                // Action Buttons
                let actionHtml = `
                    <div class="flex items-center justify-center gap-1.5">
                        <button data-id="${item.id}" type="button" class="edit-link w-[30px] h-[30px] rounded-lg bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200/80 hover:border-emerald-600 dark:bg-emerald-950/40 dark:border-slate-800 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white flex items-center justify-center transition-all duration-150 shadow-sm" onclick="editOpeningBalance(${item.id})" title="Edit Opening Balance">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                        </button>
                        <button data-id="${item.id}" type="button" class="custom-delete-modal-btn w-[30px] h-[30px] rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200/80 hover:border-rose-600 dark:bg-rose-950/40 dark:border-slate-800 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white flex items-center justify-center transition-all duration-150 shadow-sm" onclick="openDeleteOpeningBalanceModal(${item.id})" title="Delete Opening Balance">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </button>
                    </div>
                `;

                // Desktop Table Row
                let row = `
                    <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors border-b border-slate-100 dark:border-slate-800">
                        <td class="p-[10px] text-center font-semibold text-slate-400 dark:text-slate-500">${realIndex + 1}</td>
                        <td class="p-[10px] text-start whitespace-nowrap font-medium text-slate-700 dark:text-slate-300"><i class="fa-regular fa-calendar-check text-emerald-600 me-1"></i> ${item.date || '-'}</td>
                        <td class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ ${formatBdCurrency(amount)}</td>
                        <td class="p-[10px] text-start font-medium text-slate-600 dark:text-slate-300">${item.note || '-'}</td>
                        <td class="p-[10px] text-center">${actionHtml}</td>
                    </tr>`;
                tableList.append(row);

                // Mobile Card View
                let mobileCard = `
                    <div class="ob-mobile-card unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800/90 shadow-sm transition-all mb-3">
                        <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="badge bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold" style="font-size: 10px;">#${realIndex + 1}</span>
                            <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-slate-800 font-semibold" style="font-size: 10px;">
                                <i class="fa-regular fa-calendar-check me-1"></i>${item.date || '-'}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-2 bg-slate-50 dark:bg-slate-900/50 p-2.5 rounded-xl my-2 text-center items-center border border-slate-100 dark:border-slate-800">
                            <div class="border-r border-slate-300 dark:border-slate-800 text-start px-2">
                                <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">Amount</span>
                                <span class="font-bold text-rose-600 dark:text-rose-400 text-sm">৳ ${formatBdCurrency(amount)}</span>
                            </div>
                            <div class="text-start px-2">
                                <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">Note</span>
                                <span class="text-xs text-slate-700 dark:text-slate-300 truncate block">${item.note || '-'}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-1.5 pt-2 border-t border-slate-100 dark:border-slate-800">
                            <button type="button" class="edit-link w-[32px] h-[32px] rounded-xl bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200 dark:bg-emerald-950/40 dark:border-slate-800 dark:text-emerald-400 flex items-center justify-center transition-all shadow-sm" onclick="editOpeningBalance(${item.id})" title="Edit">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                            </button>
                            <button type="button" class="custom-delete-modal-btn w-[32px] h-[32px] rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200 dark:bg-rose-950/40 dark:border-slate-800 dark:text-rose-400 flex items-center justify-center transition-all shadow-sm" onclick="openDeleteOpeningBalanceModal(${item.id})" title="Delete">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
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
                <span>entries</span>
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

    async function editOpeningBalance(id) {
        try {
            if (typeof showLoader === 'function') showLoader();
            let res = await axios.post("/api/battery/opening-balance-by-id", { id: id.toString() }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data.status === 'success' && res.data.data) {
                let d = res.data.data;
                document.getElementById('obId').value = d.id;
                document.getElementById('createOpeningBalanceModalLabel').innerText = 'Edit Opening Balance';
                document.getElementById('saveObBtn').innerText = 'Update';

                if (window.obDatepicker) {
                    window.obDatepicker.setDate(d.date, true);
                } else {
                    document.getElementById('obDate').value = d.date;
                }
                document.getElementById('obAmount').value = d.amount ?? d.opening_balance;
                document.getElementById('obNote').value = d.note || '';

                $('#createOpeningBalanceModal').modal('show');
            } else {
                if (typeof errorToast === 'function') errorToast("Record not found!");
            }
        } catch(e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            if (typeof errorToast === 'function') errorToast("Failed to fetch balance details.");
        }
    }

    async function SaveOpeningBalance(event) {
        if (event && typeof event.preventDefault === 'function') event.preventDefault();

        const id = document.getElementById('obId') ? document.getElementById('obId').value : '';
        const date = document.getElementById('obDate').value;
        const amount = document.getElementById('obAmount').value;
        const note = document.getElementById('obNote').value.trim();

        if (!date) {
            if (typeof errorToast === 'function') errorToast("Date is required!");
            else alert("Date is required!");
            return;
        }
        if (!amount || parseFloat(amount) < 0) {
            if (typeof errorToast === 'function') errorToast("Valid Amount is required!");
            else alert("Valid Amount is required!");
            return;
        }

        let payload = {
            date: date,
            amount: amount,
            note: note || ''
        };
        if (id) payload.id = id;

        try {
            if (typeof showLoader === 'function') showLoader();

            let apiUrl = id ? "/api/battery/update-opening-balance" : "/api/battery/create-opening-balance";
            const res = await axios.post(apiUrl, payload, HeaderToken());

            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === "success") {
                if (typeof successToast === 'function') successToast(res.data.message || "Opening Balance saved successfully!");
                else alert(res.data.message || "Opening Balance saved successfully!");
                closeOpeningBalanceModal();
                await getList();
            } else {
                if (typeof errorToast === 'function') errorToast(res.data?.message || "Failed to save!");
                else alert(res.data?.message || "Failed to save!");
            }

        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            if (e.response?.status === 401 && typeof unauthorized === 'function') {
                unauthorized(401);
            } else {
                if (typeof errorToast === 'function') errorToast(e.response?.data?.message || "Server error. Please try again.");
                else alert(e.response?.data?.message || "Server error. Please try again.");
            }
        }
    }

    function openDeleteOpeningBalanceModal(id) {
        document.getElementById('deleteOpeningBalanceID').value = id;
        $("#deleteOpeningBalanceModal").modal('show');
    }

    async function itemDeleteOpeningBalance() {
        try {
            let id = document.getElementById('deleteOpeningBalanceID').value;
            if (!id) {
                if (typeof errorToast === 'function') errorToast("Opening Balance ID is missing.");
                return;
            }

            if (typeof showLoader === 'function') showLoader();

            let res = await axios.post(
                "/api/battery/delete-opening-balance",
                { id: id },
                HeaderToken()
            );

            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === "success") {
                if (typeof successToast === 'function') successToast(res.data.message || "Deleted successfully!");
                $("#deleteOpeningBalanceModal").modal('hide');
                await getList();
            } else {
                if (typeof errorToast === 'function') errorToast(res.data?.message || "Failed to delete!");
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            if (typeof errorToast === 'function') errorToast("Failed to delete opening balance.");
        }
    }
</script>

@endsection
