@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Expense & Salary Management - MARSS CORPORATION')
@section('content')

<!-- Flatpickr Styles & Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Hero Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-screen flex flex-col justify-between">
        <div class="data-table flex-grow">
            
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-10">

                    <!-- 1. Top Section: Page Title & Create Expense Button (Fixed 38px) -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                    <path d="M7 15h0M2 9.5h20"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Expense & Salary Management</h1>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-0">Company expenses and staff salary records & reports</p>
                            </div>
                        </div>

                        <!-- Right Controls: + Create Expense Button (Strictly only this button) -->
                        <div class="flex items-center flex-wrap gap-2">
                            <button id="openModalBtns" onclick="openExpenseModal()" type="button" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Create Expense</span>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Live Summary Counter Cards (1 col mobile, 2 col tablet, 4 col desktop) -->
                    <div class="expense-summary-grid mb-4">
                        <!-- Total Expense -->
                        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40 p-3 sm:p-3.5 transition-colors relative overflow-hidden" style="border-left: 4px solid #dc2626 !important;">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-[11px] uppercase font-bold tracking-wider block">Total Expenses</span>
                                    <h4 class="text-rose-600 dark:text-rose-400 font-extrabold text-base sm:text-xl my-1" id="statTotalExpense">৳ 0.00</h4>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-xs font-medium"><i class="fa-solid fa-receipt me-1"></i> All Entries</span>
                                </div>
                                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400 flex items-center justify-center border border-rose-100 dark:border-slate-800 flex-shrink-0">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2"></rect><line x1="8" y1="6" x2="16" y2="6"></line><line x1="16" y1="14" x2="16" y2="18"></line><path d="M16 10h.01M12 10h.01M8 10h.01M12 14h.01M8 14h.01M12 18h.01M8 18h.01"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Today's Expense -->
                        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40 p-3 sm:p-3.5 transition-colors relative overflow-hidden" style="border-left: 4px solid #16a34a !important;">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-[11px] uppercase font-bold tracking-wider block">Today's Expense</span>
                                    <h4 class="text-emerald-600 dark:text-emerald-400 font-extrabold text-base sm:text-xl my-1" id="statTodayExpense">৳ 0.00</h4>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-xs font-medium"><i class="fa-regular fa-calendar-check me-1"></i> Today's Total</span>
                                </div>
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 flex-shrink-0">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                </div>
                            </div>
                        </div>

                        <!-- This Month's Expense -->
                        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40 p-3 sm:p-3.5 transition-colors relative overflow-hidden" style="border-left: 4px solid #0284c7 !important;">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-[11px] uppercase font-bold tracking-wider block">This Month's Expense</span>
                                    <h4 class="text-sky-600 dark:text-sky-400 font-extrabold text-base sm:text-xl my-1" id="statMonthExpense">৳ 0.00</h4>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-xs font-medium"><i class="fa-solid fa-chart-line me-1"></i> Month Total</span>
                                </div>
                                <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 dark:bg-sky-950/40 dark:text-sky-400 flex items-center justify-center border border-sky-100 dark:border-slate-800 flex-shrink-0">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Staff Total Salary -->
                        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40 p-3 sm:p-3.5 transition-colors relative overflow-hidden" style="border-left: 4px solid #6366f1 !important;">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-[11px] uppercase font-bold tracking-wider block">Staff Total Salary</span>
                                    <h4 class="text-indigo-600 dark:text-indigo-400 font-extrabold text-base sm:text-xl my-1" id="statSalaryExpense">৳ 0.00</h4>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-xs font-medium"><i class="fa-solid fa-user-tie me-1"></i> Salary Paid</span>
                                </div>
                                <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-950/40 dark:text-indigo-400 flex items-center justify-center border border-indigo-100 dark:border-slate-800 flex-shrink-0">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Controls & Filter Row: Search Bar + Show Entry Side-by-Side (38px height) -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2.5 sm:gap-3 mb-4">
                        <div class="flex items-center gap-2">
                            <h5 class="text-base sm:text-lg font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0 flex items-center gap-2">
                                <i class="fa-solid fa-list-ol text-emerald-600"></i> Expense & Salary List
                            </h5>
                        </div>

                        <!-- Search Bar + Show Entry Side-by-Side -->
                        <div class="flex items-center gap-2 sm:gap-2.5 w-full md:w-auto">
                            <!-- Search Bar -->
                            <div class="search-input-wrapper unified-ui-border flex-1 md:w-[280px] lg:w-[320px] h-[38px] flex items-center px-3 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                                <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search type/details/staff..." />
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

                    <!-- 4. Desktop Table View -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[40px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                    <th class="p-[10px] text-start w-[110px] whitespace-nowrap">Date</th>
                                    <th class="p-[10px] text-start w-[140px] whitespace-nowrap">Expense Type</th>
                                    <th class="p-[10px] text-start w-[150px] whitespace-nowrap">Staff Profile</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Details</th>
                                    <th class="p-[10px] text-end w-[130px] whitespace-nowrap">Amount (৳)</th>
                                    <th class="p-[10px] text-center w-[75px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableList" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200"></tbody>
                            <tfoot class="bg-slate-50/90 dark:bg-slate-800/70 text-slate-800 dark:text-slate-100 font-bold border-t-2 border-emerald-600/30 dark:border-emerald-600/20 text-xs sm:text-sm">
                                <tr>
                                    <td colspan="5" class="p-[10px] text-end font-bold text-slate-600 dark:text-slate-300">Total Filtered:</td>
                                    <td id="pageTotalExpense" class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ 0.00</td>
                                    <td class="p-[10px]"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- 5. Mobile Card List View (Shown on Mobile Screens < 768px) -->
                    <div id="mobileCardList" class="block md:hidden mb-3 space-y-3"></div>

                    <!-- 6. Modern Smart Pagination and Display Info Footer -->
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
<!-- Hero Main Content End -->

<!-- Create Expense Modal Start (Retail 1:1 Design) -->
<div class="modal fade" id="createExpenseModal" tabindex="-1" aria-labelledby="createExpenseModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
            <!-- Sticky Top Green Header -->
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.2); color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            <path d="M7 15h0M2 9.5h20"></path>
                        </svg>
                    </div>
                    <h5 class="modal-title m-0 text-white fw-bold" id="createExpenseModalLabel" style="font-size: 16px; color: #ffffff !important;">Create Expense</h5>
                </div>
                <!-- Circular Red Close Button with White Icon -->
                <button type="button" class="custom-modal-close-btn d-flex align-items-center justify-content-center border-0 shadow-sm" data-bs-dismiss="modal" onclick="closeExpenseModal()" aria-label="Close" title="Close">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Scrollable Modal Body (ONLY between header and buttons, strictly left aligned) -->
            <div class="modal-body custom-scrollbar text-start" style="text-align: left !important;">
                <form id="expenseForm" onsubmit="return SaveExpense(event)" class="text-start" style="text-align: left !important;">
                    
                    <!-- Top Date & Quick Action Buttons (2 Column Row on desktop, stacked on mobile) -->
                    <div class="row g-2.5 mb-3 align-items-end text-start">
                        <div class="col-md-6 col-12 text-start">
                            <label for="ExpenseDate" class="custom-modal-label text-start" style="text-align: left !important;">
                                <i class="fa-regular fa-calendar-days text-emerald-600 me-1"></i> Expense Date <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="custom-modal-input text-start" id="ExpenseDate" required placeholder="YYYY-MM-DD" style="text-align: left !important; cursor: pointer;" />
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="d-flex flex-column flex-md-row gap-2 mt-2 mt-md-0">
                                <button type="button" class="btn btn-quick-newtype fw-semibold w-100 d-inline-flex align-items-center justify-content-center gap-1.5 shadow-sm" onclick="openBrandModal()">
                                    <i class="fa-solid fa-folder-plus"></i> + Create New Type
                                </button>
                                <button type="button" class="btn btn-quick-newstaff fw-semibold w-100 d-inline-flex align-items-center justify-content-center gap-1.5 shadow-sm" onclick="openStaffQuickModal()">
                                    <i class="fa-solid fa-user-plus"></i> + Add New Staff
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Multi-Expense Checkbox Selection List -->
                    <div class="expense-type-box rounded-2xl p-3 border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-900/50 mb-2">
                        <div class="d-flex align-items-center justify-content-between mb-2.5 pb-2 border-b border-slate-200 dark:border-slate-800">
                            <h6 class="fw-bold text-slate-800 dark:text-slate-100 mb-0 text-sm d-flex align-items-center gap-2">
                                <i class="fa-solid fa-list-check text-emerald-600"></i> Select Expense Type and Enter Amount:
                            </h6>
                            <span class="badge bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-300 dark:border-slate-800 px-2.5 py-1 fw-bold text-xs" id="selectedItemsCounter">
                                0 Selected
                            </span>
                        </div>

                        <div id="ExpenseTypesContainer">
                            <div class="text-center py-4 text-slate-400">
                                <i class="fa-solid fa-circle-notch fa-spin me-2"></i> Loading expense types...
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Sticky Bottom Footer with Red Cancel & Green Save Buttons (Strict 38px height) -->
            <div class="modal-footer d-flex align-items-center justify-content-end gap-2 flex-shrink-0">
                <button type="button" data-bs-dismiss="modal" onclick="closeExpenseModal()" class="btn fw-semibold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important; cursor: pointer; transition: opacity 0.2s;">
                    Cancel
                </button>
                <button type="button" onclick="SaveExpense(event)" class="btn text-white fw-bold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; font-size: 13.5px !important; cursor: pointer;">
                    Submit
                </button>
            </div>

        </div>
    </div>
</div>
<!-- Create Expense Modal End -->

<!-- Add New Expense Type Sub-Modal Start (Retail 1:1 Design) -->
<div class="newbrand" id="addBrandModal" style="z-index: 9999999;">
    <div class="newbrand-content shadow-lg border-0" style="border-radius: 16px; width: 95%; max-width: 540px; padding: 22px 24px;">
        <div class="d-flex align-items-center justify-content-between mb-3.5 pb-2 border-bottom border-slate-100 dark:border-slate-800">
            <h5 class="fw-bold text-slate-800 dark:text-slate-100 mb-0 d-flex align-items-center gap-2" style="font-size: 16px;">
                <i class="fa-solid fa-folder-plus text-emerald-600"></i> New Expense Type
            </h5>
            <button type="button" class="custom-modal-close-btn d-flex align-items-center justify-content-center border-0 shadow-sm" onclick="closeBrandModal()" aria-label="Close" title="Close">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <form onsubmit="saveExpenseType(event)">
            <div class="row g-3 mb-4 text-start" style="text-align: left !important;">
                <div class="col-12 col-md-6 text-start" style="text-align: left !important;">
                    <label for="CreateExpenseTypeName" class="custom-modal-label text-start" style="display: block !important; text-align: left !important; margin-bottom: 6px !important;">Expense Type Name <span class="text-danger">*</span></label>
                    <input type="text" id="CreateExpenseTypeName" class="custom-modal-input text-start" placeholder="e.g.: Shop Rent, Salary" required style="display: block !important; width: 100% !important; text-align: left !important; pointer-events: auto !important;" />
                </div>
                <div class="col-12 col-md-6 text-start" style="text-align: left !important;">
                    <label for="ExpenseSelectStatus" class="custom-modal-label text-start" style="display: block !important; text-align: left !important; margin-bottom: 6px !important;">Status <span class="text-danger">*</span></label>
                    <select class="custom-modal-input text-start" id="ExpenseSelectStatus" style="display: block !important; width: 100% !important; text-align: left !important; cursor: pointer !important; pointer-events: auto !important;">
                        <option value="Active" selected>Active</option>
                        <option value="InActive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 pt-2 border-top border-slate-100 dark:border-slate-800">
                <button type="button" class="btn text-white px-4 fw-semibold shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; border: none !important; cursor: pointer;" onclick="closeBrandModal()">Cancel</button>
                <button type="submit" class="btn text-white px-4 fw-bold shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; cursor: pointer;">Save</button>
            </div>
        </form>
    </div>
</div>
<!-- Add New Expense Type Sub-Modal End -->

<!-- Quick Add New Staff Sub-Modal Start (Retail 1:1 Design) -->
<div class="newbrand" id="addStaffQuickModal" style="z-index: 9999999;">
    <div class="newbrand-content shadow-lg border-0" style="border-radius: 16px; width: 95%; max-width: 580px; padding: 22px 24px;">
        <div class="d-flex align-items-center justify-content-between mb-3.5 pb-2 border-bottom border-slate-100 dark:border-slate-800">
            <h5 class="fw-bold text-slate-800 dark:text-slate-100 mb-0 d-flex align-items-center gap-2" style="font-size: 16px;">
                <i class="fa-solid fa-user-plus text-indigo-600"></i> Add New Staff
            </h5>
            <button type="button" class="custom-modal-close-btn d-flex align-items-center justify-content-center border-0 shadow-sm" onclick="closeStaffQuickModal()" aria-label="Close" title="Close">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <form onsubmit="saveQuickStaff(event)">
            <div class="row g-3 mb-3 text-start" style="text-align: left !important;">
                <div class="col-12 col-md-6 text-start" style="text-align: left !important;">
                    <label for="QuickStaffName" class="custom-modal-label text-start" style="display: block !important; text-align: left !important; margin-bottom: 6px !important;">Staff Full Name <span class="text-danger">*</span></label>
                    <input type="text" id="QuickStaffName" class="custom-modal-input text-start" placeholder="e.g.: Md. Rafiq Ahmed" required style="display: block !important; width: 100% !important; text-align: left !important; pointer-events: auto !important;" />
                </div>
                <div class="col-12 col-md-6 text-start" style="text-align: left !important;">
                    <label for="QuickStaffMobile" class="custom-modal-label text-start" style="display: block !important; text-align: left !important; margin-bottom: 6px !important;">Mobile Number <span class="text-danger">*</span></label>
                    <input type="text" id="QuickStaffMobile" class="custom-modal-input text-start" placeholder="017XXXXXXXX" required style="display: block !important; width: 100% !important; text-align: left !important; pointer-events: auto !important;" />
                </div>
                <div class="col-12 col-md-6 text-start" style="text-align: left !important;">
                    <label for="QuickStaffEmail" class="custom-modal-label text-start" style="display: block !important; text-align: left !important; margin-bottom: 6px !important;">Email (Optional)</label>
                    <input type="email" id="QuickStaffEmail" class="custom-modal-input text-start" placeholder="staff@anisstore.com" style="display: block !important; width: 100% !important; text-align: left !important; pointer-events: auto !important;" />
                </div>
                <div class="col-12 col-md-6 text-start" style="text-align: left !important;">
                    <label for="QuickStaffRole" class="custom-modal-label text-start" style="display: block !important; text-align: left !important; margin-bottom: 6px !important;">Role / Status <span class="text-danger">*</span></label>
                    <select class="custom-modal-input text-start" id="QuickStaffRole" style="display: block !important; width: 100% !important; text-align: left !important; cursor: pointer !important; pointer-events: auto !important;">
                        <option value="staff" selected>Staff</option>
                        <option value="cashier">Cashier</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 pt-2 border-top border-slate-100 dark:border-slate-800">
                <button type="button" class="btn text-white px-4 fw-semibold shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; border: none !important; cursor: pointer;" onclick="closeStaffQuickModal()">Cancel</button>
                <button type="submit" class="btn text-white px-4 fw-bold shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; cursor: pointer;">Save Staff</button>
            </div>
        </form>
    </div>
</div>
<!-- Quick Add New Staff Sub-Modal End -->

<!-- Item Expense Details Sub-Modal Start (Retail 1:1 Design) -->
<div class="newbrand" id="itemExpenseDetailsModal" style="z-index: 9999995;">
    <div class="newbrand-content shadow-lg border-0" style="border-radius: 16px; width: 95%; max-width: 580px; padding: 22px 24px;">
        <div class="d-flex align-items-center justify-content-between mb-3.5 pb-2 border-bottom border-slate-100 dark:border-slate-800">
            <h5 class="fw-bold text-slate-800 dark:text-slate-100 mb-0 d-flex align-items-center gap-2" style="font-size: 16px;">
                <i class="fa-solid fa-pen-to-square text-emerald-600"></i>
                <span id="itemDetailsModalTypeName">Expense Details</span>
            </h5>
            <button type="button" class="custom-modal-close-btn d-flex align-items-center justify-content-center border-0 shadow-sm" onclick="closeItemDetailsModal()" aria-label="Close" style="width: 26px !important; height: 26px !important; min-width: 26px !important; min-height: 26px !important; border-radius: 50% !important; background-color: #ef4444 !important; color: #ffffff !important; cursor: pointer !important; padding: 0 !important; margin: 0 !important;" title="Close">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <form id="itemDetailsForm" onsubmit="return saveItemDetailsModal(event)">
            <input type="hidden" id="modalActiveTypeId" value="" />

            <!-- General Expense Fields Container -->
            <div id="modalGeneralExpenseFields">
                <div class="row g-3 mb-3 text-start" style="text-align: left !important;">
                    <div class="col-12 col-md-6 text-start" style="text-align: left !important;">
                        <label for="modalExpenseAmount" class="custom-modal-label text-start">Amount (৳) <span class="text-danger">*</span></label>
                        <input type="number" step="any" min="0.01" id="modalExpenseAmount" class="custom-modal-input text-start fw-bold text-rose-600" placeholder="0.00" style="font-size: 15px;" />
                    </div>
                    <div class="col-12 col-md-6 text-start" style="text-align: left !important;">
                        <label for="modalExpenseDetails" class="custom-modal-label text-start">Details / Note</label>
                        <input type="text" id="modalExpenseDetails" class="custom-modal-input text-start" placeholder="Enter expense details..." />
                    </div>
                </div>
            </div>

            <!-- Salary Expense Fields Container -->
            <div id="modalSalaryExpenseFields" class="d-none">
                <!-- Row 1: Select Staff (1 row full width) -->
                <div class="row g-2.5 mb-2.5 text-start" style="text-align: left !important;">
                    <div class="col-12 text-start" style="text-align: left !important;">
                        <label for="modalSalaryStaff" class="custom-modal-label text-start" style="text-align: left !important;">Select Staff <span class="text-danger">*</span></label>
                        <select id="modalSalaryStaff" class="custom-modal-input text-start" style="text-align: left !important; cursor: pointer;">
                            <option value="">-- Select Staff --</option>
                        </select>
                    </div>
                </div>
                <!-- Row 2: Amount & Details / Note (1 row 2 columns) -->
                <div class="row g-2.5 mb-3 text-start" style="text-align: left !important;">
                    <div class="col-6 text-start" style="text-align: left !important;">
                        <label for="modalSalaryAmount" class="custom-modal-label text-start" style="text-align: left !important;">Amount (৳) <span class="text-danger">*</span></label>
                        <input type="number" step="any" min="0.01" id="modalSalaryAmount" class="custom-modal-input text-start fw-bold text-rose-600" placeholder="0.00" style="font-size: 15px; text-align: left !important;" />
                    </div>
                    <div class="col-6 text-start" style="text-align: left !important;">
                        <label for="modalSalaryDetails" class="custom-modal-label text-start" style="text-align: left !important;">Details / Note</label>
                        <input type="text" id="modalSalaryDetails" class="custom-modal-input text-start" placeholder="Monthly Salary" style="text-align: left !important;" />
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="d-flex justify-content-end gap-2 pt-2 border-top border-slate-100 dark:border-slate-800">
                <button type="button" class="btn text-white px-4 fw-semibold shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; border: none !important; cursor: pointer;" onclick="closeItemDetailsModal()">Cancel</button>
                <button type="submit" class="btn text-white px-4 fw-bold shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; cursor: pointer;">Save Details</button>
            </div>
        </form>
    </div>
</div>
<!-- Item Expense Details Sub-Modal End -->

<!-- Edit Expense Modal Start (Retail 1:1 Design) -->
<div class="modal fade" id="updateExpenseModal" tabindex="-1" aria-labelledby="updateExpenseModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
            <!-- Sticky Top Green Header -->
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.2); color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                            <path d="M12 20h9"></path>
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                        </svg>
                    </div>
                    <h5 class="modal-title m-0 text-white fw-bold" id="updateExpenseModalLabel" style="font-size: 16px; color: #ffffff !important;">Update Expense</h5>
                </div>
                <!-- Circular Red Close Button with White Icon -->
                <button type="button" class="custom-modal-close-btn d-flex align-items-center justify-content-center border-0 shadow-sm" data-bs-dismiss="modal" aria-label="Close" title="Close">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Scrollable Modal Body (strictly left aligned) -->
            <div class="modal-body custom-scrollbar text-start" style="text-align: left !important;">
                <form onsubmit="return UpdateExpense(event)" class="text-start" style="text-align: left !important;">
                    <input type="hidden" id="updateID">

                    <div class="row g-2.5 text-start" style="text-align: left !important;">
                        
                        <!-- Expense Type -->
                        <div class="col-12 text-start" style="text-align: left !important;">
                            <label class="custom-modal-label text-start" style="text-align: left !important;">Expense Type <span class="text-danger">*</span></label>
                            <select class="custom-modal-input text-start" id="UpdateExpenseTypeInfoID" onchange="checkUpdateExpenseSalaryType()" required style="text-align: left !important; cursor: pointer !important;">
                                <option value="">Select Expense Type</option>
                            </select>
                        </div>

                        <!-- Staff Select (Conditional) -->
                        <div class="col-12 text-start d-none" id="UpdateStaffContainer" style="text-align: left !important;">
                            <label class="custom-modal-label text-start" style="text-align: left !important;">Select Staff <span class="text-danger">*</span></label>
                            <select class="custom-modal-input text-start" id="UpdateStaffInfoID" style="text-align: left !important; cursor: pointer !important;">
                                <option value="">-- Select Staff --</option>
                            </select>
                        </div>

                        <!-- Expense Amount & Date (2 Columns) -->
                        <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                            <label class="custom-modal-label text-start" style="text-align: left !important;">Expense Amount (৳) <span class="text-danger">*</span></label>
                            <input type="number" step="any" class="custom-modal-input text-start fw-bold text-rose-600" placeholder="0.00" id="UpdateExpenseAmount" required style="text-align: left !important;" />
                        </div>
                        <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                            <label class="custom-modal-label text-start" style="text-align: left !important;">Expense Date <span class="text-danger">*</span></label>
                            <input type="text" class="custom-modal-input text-start" id="UpdateExpenseDate" required placeholder="YYYY-MM-DD" style="text-align: left !important; cursor: pointer;" />
                        </div>

                        <!-- Expense Details -->
                        <div class="col-12 text-start" style="text-align: left !important;">
                            <label class="custom-modal-label text-start" style="text-align: left !important;">Expense Details</label>
                            <textarea class="custom-modal-input text-start" placeholder="Expense Details..." id="UpdateExpenseDetails" rows="2" style="height: 60px !important; padding: 8px 14px !important; resize: none; text-align: left !important;"></textarea>
                        </div>

                    </div>
                </form>
            </div>

            <!-- Sticky Bottom Footer with Red Cancel & Green Update Buttons (Strict 38px height) -->
            <div class="modal-footer d-flex align-items-center justify-content-end gap-2 flex-shrink-0">
                <button type="button" data-bs-dismiss="modal" class="btn fw-semibold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important; cursor: pointer; transition: opacity 0.2s;">
                    Cancel
                </button>
                <button type="button" onclick="UpdateExpense(event)" class="btn text-white fw-bold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; font-size: 13.5px !important; cursor: pointer;">
                    Update
                </button>
            </div>

        </div>
    </div>
</div>
<!-- Edit Expense Modal End -->

<!-- Expense Delete Confirmation Modal Start (Retail 1:1 Design) -->
<div class="modal fade" id="expenseDeleteModal" tabindex="-1" aria-labelledby="expenseDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm sm:modal-md my-3" style="max-width: 440px;">
        <div class="modal-content bg-white dark:bg-slate-900 border-0 rounded-2xl shadow-2xl overflow-hidden transition-colors flex flex-col" style="border: none !important;">
            
            <!-- Sticky Top Header (Red) -->
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
                    <h5 class="modal-title text-base font-bold text-white tracking-tight mb-0" id="expenseDeleteModalLabel" style="color: #ffffff !important;">Delete Expense</h5>
                </div>
                <!-- Circular Red Close Button with White Icon -->
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
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mb-0">Are you sure you want to delete this expense record? This action cannot be undone.</p>
                <input type="hidden" id="deleteID" />
            </div>

            <!-- Sticky Bottom Footer (Strict 38px buttons) -->
            <div class="modal-footer sticky bottom-0 z-20 px-4 sm:px-5 py-3 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 flex items-center justify-center gap-2.5 flex-shrink-0">
                <button type="button" class="px-4 h-[38px] min-h-[38px] max-h-[38px] rounded-xl text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 unified-ui-border text-xs sm:text-sm font-semibold transition-all shadow-sm flex items-center justify-center cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" onclick="itemDelete()" class="px-5 h-[38px] min-h-[38px] max-h-[38px] rounded-xl text-white text-xs sm:text-sm font-semibold transition-all shadow-sm flex items-center justify-center cursor-pointer hover:bg-rose-700 active:scale-[0.98]" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important;">
                    Yes, Delete
                </button>
            </div>

        </div>
    </div>
</div>
<!-- Expense Delete Confirmation Modal End -->

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
    #printTable tbody td, #printTable tfoot td {
        padding: 10px !important;
    }

    /* 4 Summary Cards Grid */
    .expense-summary-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 12px;
    }
    @media (min-width: 640px) {
        .expense-summary-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (min-width: 1024px) {
        .expense-summary-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    /* Modal Container & Dead-Center Positioning (Matching Retail 1:1) */
    #createExpenseModal.modal,
    #updateExpenseModal.modal,
    #expenseDeleteModal.modal {
        overflow-y: hidden !important;
        padding-right: 0 !important;
        background: rgba(15, 23, 42, 0.6) !important;
        backdrop-filter: blur(4px) !important;
        -webkit-backdrop-filter: blur(4px) !important;
        z-index: 1060 !important;
    }
    #createExpenseModal.modal.show,
    #updateExpenseModal.modal.show,
    #expenseDeleteModal.modal.show {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    #createExpenseModal .modal-dialog,
    #updateExpenseModal .modal-dialog,
    #expenseDeleteModal .modal-dialog {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        position: static !important;
        top: auto !important;
        left: auto !important;
        transform: none !important;
        margin: auto !important;
        height: auto !important;
        display: flex !important;
        align-items: center !important;
        padding: 0 !important;
        overflow: visible !important;
    }
    #createExpenseModal .modal-dialog {
        max-width: 820px !important;
        width: 95% !important;
        max-height: 92vh !important;
    }
    #updateExpenseModal .modal-dialog {
        max-width: 560px !important;
        width: 95% !important;
        max-height: 90vh !important;
    }
    #expenseDeleteModal .modal-dialog {
        max-width: 440px !important;
        width: 92% !important;
    }

    #createExpenseModal .modal-content,
    #updateExpenseModal .modal-content {
        border-radius: 16px !important;
        overflow: hidden !important;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
    }
    #createExpenseModal .modal-content {
        max-height: 92vh !important;
    }
    #updateExpenseModal .modal-content {
        max-height: 90vh !important;
    }
    #expenseDeleteModal .modal-content {
        border: none !important;
        border-radius: 1rem !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        overflow: hidden !important;
        background-color: #ffffff !important;
        width: 100% !important;
    }

    #createExpenseModal .modal-header,
    #updateExpenseModal .modal-header {
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

    #createExpenseModal .modal-body,
    #updateExpenseModal .modal-body {
        padding: 16px 20px !important;
        overflow-y: auto !important;
        background-color: #ffffff !important;
        text-align: left !important;
    }
    #createExpenseModal .modal-body {
        max-height: calc(92vh - 125px) !important;
    }
    #updateExpenseModal .modal-body {
        max-height: calc(90vh - 125px) !important;
    }

    #createExpenseModal .modal-footer,
    #updateExpenseModal .modal-footer {
        padding: 10px 20px !important;
        background-color: #f8fafc !important;
        border-top: 1px solid #e2e8f0 !important;
        position: relative !important;
        flex-shrink: 0 !important;
    }

    /* Modal Form Labels & Input Fields */
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
        border: 1.5px solid #cbd5e1 !important;
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

    /* Circular Close Button with Red Background */
    .custom-modal-close-btn {
        position: relative !important;
        top: auto !important;
        right: auto !important;
        width: 26px !important;
        height: 26px !important;
        min-width: 26px !important;
        min-height: 26px !important;
        border-radius: 50% !important;
        background-color: #ef4444 !important;
        color: #ffffff !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        padding: 0 !important;
        margin: 0 !important;
        flex-shrink: 0 !important;
        border: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    .custom-modal-close-btn:hover {
        background-color: #dc2626 !important;
        transform: scale(1.05);
    }

    /* Quick Action Buttons (Full width on mobile, side-by-side on desktop) */
    .btn-quick-newtype {
        height: 42px !important;
        border-radius: 8px !important;
        border: 1.5px solid #10b981 !important;
        color: #047857 !important;
        background-color: #ecfdf5 !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        transition: all 0.2s ease !important;
    }
    .btn-quick-newtype:hover {
        background-color: #d1fae5 !important;
        color: #065f46 !important;
    }

    .btn-quick-newstaff {
        height: 42px !important;
        border-radius: 8px !important;
        border: 1.5px solid #6366f1 !important;
        color: #4338ca !important;
        background-color: #eef2ff !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        transition: all 0.2s ease !important;
    }
    .btn-quick-newstaff:hover {
        background-color: #e0e7ff !important;
        color: #3730a3 !important;
    }

    /* Sub-modal Styles Overrides (.newbrand and .newbrand-content) */
    .newbrand {
        display: none;
        position: fixed !important;
        inset: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        background: rgba(15, 23, 42, 0.65) !important;
        backdrop-filter: blur(3px) !important;
        -webkit-backdrop-filter: blur(3px) !important;
        z-index: 9999999 !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 16px !important;
        pointer-events: auto !important;
    }
    .newbrand.show,
    .newbrand[style*="display: flex"] {
        display: flex !important;
    }
    .newbrand-content {
        position: relative !important;
        left: auto !important;
        top: auto !important;
        transform: none !important;
        margin: auto !important;
        pointer-events: auto !important;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 16px !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35) !important;
        width: 95% !important;
        padding: 22px 24px !important;
    }
    #addBrandModal .newbrand-content {
        max-width: 540px !important;
    }
    #addStaffQuickModal .newbrand-content {
        max-width: 580px !important;
    }
    .newbrand-content .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    .newbrand-content .form-group {
        display: block !important;
        width: 100% !important;
    }
    .newbrand-content label {
        display: block !important;
        text-align: left !important;
        font-weight: 600 !important;
        color: #334155 !important;
        font-size: 13px !important;
        margin-bottom: 6px !important;
    }
    .newbrand-content input,
    .newbrand-content select {
        display: block !important;
        width: 100% !important;
        height: 42px !important;
        padding: 0 14px !important;
        border-radius: 8px !important;
        border: 1.5px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        font-size: 13.5px !important;
        color: #0f172a !important;
        outline: none !important;
        text-align: left !important;
        pointer-events: auto !important;
        box-sizing: border-box !important;
    }
    .newbrand-content input:focus,
    .newbrand-content select:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.2) !important;
    }

    /* Expense Types Grid & Checkbox Cards */
    .expense-types-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 8px;
    }
    @media (min-width: 640px) {
        .expense-types-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
    }
    .available-expense-card {
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        background-color: #ffffff;
        padding: 7px 10px;
        transition: all 0.15s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        min-height: 38px;
        cursor: pointer;
        user-select: none;
    }
    .available-expense-card:hover {
        border-color: #10b981 !important;
        background-color: #f0fdf4 !important;
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(16, 185, 129, 0.12);
    }
    .available-expense-card .click-indicator-icon {
        color: #10b981;
        font-size: 11px;
        opacity: 0.8;
        transition: all 0.15s ease;
    }
    .available-expense-card:hover .click-indicator-icon {
        opacity: 1;
        transform: scale(1.15);
    }

    .selected-expense-item {
        border: 1.5px solid #10b981 !important;
        border-radius: 10px;
        background-color: #f0fdf4 !important;
        padding: 8px 12px;
        transition: all 0.15s ease;
        box-shadow: 0 1px 3px rgba(16, 185, 129, 0.1);
        cursor: pointer;
    }
    .selected-expense-item:hover {
        background-color: #dcfce7 !important;
        box-shadow: 0 3px 8px rgba(16, 185, 129, 0.18);
    }

    /* Flatpickr Calendar Styling */
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

    /* Action Buttons Hover & Table Links */
    #openModalBtns {
        background-color: #15803d !important;
        color: #ffffff !important;
        border: none !important;
    }
    #openModalBtns:hover {
        background-color: #166534 !important;
        color: #ffffff !important;
    }
    #openModalBtns:hover span,
    #openModalBtns:hover svg {
        color: #ffffff !important;
        stroke: #ffffff !important;
    }

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

    .custom-delete-modal-btn {
        width: 30px !important;
        height: 30px !important;
        border-radius: 8px !important;
        background-color: #fff1f2 !important;
        color: #e11d48 !important;
        border: 1px solid #fecdd3 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.15s ease-in-out !important;
    }
    .custom-delete-modal-btn:hover {
        background-color: #e11d48 !important;
        border-color: #e11d48 !important;
        color: #ffffff !important;
    }
    .custom-delete-modal-btn:hover i,
    .custom-delete-modal-btn:hover svg {
        color: #ffffff !important;
        stroke: #ffffff !important;
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

    /* Dark Mode Overrides (Retail 1:1) */
    body[data-layout-mode="dark"] #createExpenseModal .modal-content,
    body[light-mode="dark"] #createExpenseModal .modal-content,
    html.dark #createExpenseModal .modal-content,
    body.dark-mode #createExpenseModal .modal-content,
    body.dark #createExpenseModal .modal-content,
    body[light-mode="dark"] #updateExpenseModal .modal-content,
    body[data-layout-mode="dark"] #updateExpenseModal .modal-content,
    html.dark #updateExpenseModal .modal-content,
    body.dark-mode #updateExpenseModal .modal-content,
    body.dark #updateExpenseModal .modal-content,
    body[light-mode="dark"] #expenseDeleteModal .modal-content,
    html.dark #expenseDeleteModal .modal-content,
    body.dark #expenseDeleteModal .modal-content,
    body[data-layout-mode="dark"] #expenseDeleteModal .modal-content {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }

    body[data-layout-mode="dark"] #createExpenseModal .modal-body,
    body[light-mode="dark"] #createExpenseModal .modal-body,
    html.dark #createExpenseModal .modal-body,
    body.dark-mode #createExpenseModal .modal-body,
    body.dark #createExpenseModal .modal-body,
    body[light-mode="dark"] #updateExpenseModal .modal-body,
    body[data-layout-mode="dark"] #updateExpenseModal .modal-body,
    html.dark #updateExpenseModal .modal-body,
    body.dark-mode #updateExpenseModal .modal-body,
    body.dark #updateExpenseModal .modal-body {
        background-color: #0f172a !important;
    }

    body[data-layout-mode="dark"] #createExpenseModal .modal-footer,
    body[light-mode="dark"] #createExpenseModal .modal-footer,
    html.dark #createExpenseModal .modal-footer,
    body.dark-mode #createExpenseModal .modal-footer,
    body.dark #createExpenseModal .modal-footer,
    body[light-mode="dark"] #updateExpenseModal .modal-footer,
    body[data-layout-mode="dark"] #updateExpenseModal .modal-footer,
    html.dark #updateExpenseModal .modal-footer,
    body.dark-mode #updateExpenseModal .modal-footer,
    body.dark #updateExpenseModal .modal-footer,
    body[light-mode="dark"] #expenseDeleteModal .modal-footer,
    html.dark #expenseDeleteModal .modal-footer,
    body.dark #expenseDeleteModal .modal-footer,
    body[data-layout-mode="dark"] #expenseDeleteModal .modal-footer {
        background-color: #1e293b !important;
        border-top-color: #334155 !important;
    }

    body[data-layout-mode="dark"] .custom-modal-label,
    body[light-mode="dark"] .custom-modal-label,
    html.dark .custom-modal-label,
    body.dark-mode .custom-modal-label,
    body.dark .custom-modal-label {
        color: #cbd5e1 !important;
    }

    body[data-layout-mode="dark"] .custom-modal-input,
    body[light-mode="dark"] .custom-modal-input,
    html.dark .custom-modal-input,
    body.dark-mode .custom-modal-input,
    body.dark .custom-modal-input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[data-layout-mode="dark"] .custom-modal-input:focus,
    body[light-mode="dark"] .custom-modal-input:focus,
    html.dark .custom-modal-input:focus {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2) !important;
    }

    /* Dark Mode for Quick Action Buttons */
    body[data-layout-mode="dark"] .btn-quick-newtype,
    body[light-mode="dark"] .btn-quick-newtype,
    html.dark .btn-quick-newtype,
    body.dark-mode .btn-quick-newtype,
    body.dark .btn-quick-newtype {
        background-color: rgba(16, 185, 129, 0.15) !important;
        border-color: #059669 !important;
        color: #34d399 !important;
    }
    body[data-layout-mode="dark"] .btn-quick-newtype:hover,
    body[light-mode="dark"] .btn-quick-newtype:hover,
    html.dark .btn-quick-newtype:hover {
        background-color: rgba(16, 185, 129, 0.25) !important;
    }

    body[data-layout-mode="dark"] .btn-quick-newstaff,
    body[light-mode="dark"] .btn-quick-newstaff,
    html.dark .btn-quick-newstaff,
    body.dark-mode .btn-quick-newstaff,
    body.dark .btn-quick-newstaff {
        background-color: rgba(99, 102, 241, 0.15) !important;
        border-color: #4f46e5 !important;
        color: #a5b4fc !important;
    }
    body[data-layout-mode="dark"] .btn-quick-newstaff:hover,
    body[light-mode="dark"] .btn-quick-newstaff:hover,
    html.dark .btn-quick-newstaff:hover {
        background-color: rgba(99, 102, 241, 0.25) !important;
    }

    /* Dark Mode for Sub-Modals */
    body[data-layout-mode="dark"] .newbrand-content,
    body[light-mode="dark"] .newbrand-content,
    html.dark .newbrand-content,
    body.dark-mode .newbrand-content,
    body.dark .newbrand-content {
        background-color: #0f172a !important;
        border: 1px solid #334155 !important;
        color: #f8fafc !important;
    }
    body[data-layout-mode="dark"] .newbrand-content h5,
    body[light-mode="dark"] .newbrand-content h5,
    html.dark .newbrand-content h5 {
        color: #f8fafc !important;
    }
    body[data-layout-mode="dark"] .newbrand-content .border-bottom,
    body[data-layout-mode="dark"] .newbrand-content .border-top,
    body[light-mode="dark"] .newbrand-content .border-bottom,
    body[light-mode="dark"] .newbrand-content .border-top,
    html.dark .newbrand-content .border-bottom,
    html.dark .newbrand-content .border-top {
        border-color: #334155 !important;
    }
    body[data-layout-mode="dark"] .newbrand-content label,
    body[light-mode="dark"] .newbrand-content label,
    html.dark .newbrand-content label,
    body.dark-mode .newbrand-content label,
    body.dark .newbrand-content label {
        color: #cbd5e1 !important;
    }
    body[data-layout-mode="dark"] .newbrand-content input,
    body[data-layout-mode="dark"] .newbrand-content select,
    body[light-mode="dark"] .newbrand-content input,
    body[light-mode="dark"] .newbrand-content select,
    html.dark .newbrand-content input,
    html.dark .newbrand-content select,
    body.dark-mode .newbrand-content input,
    body.dark-mode .newbrand-content select,
    body.dark .newbrand-content input,
    body.dark .newbrand-content select {
        background-color: #1e293b !important;
        border: 1px solid #334155 !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }

    /* Dark Mode for Expense Types Box & Cards */
    body[data-layout-mode="dark"] .expense-type-box,
    body[light-mode="dark"] .expense-type-box,
    html.dark .expense-type-box,
    body.dark-mode .expense-type-box,
    body.dark .expense-type-box {
        background-color: rgba(15, 23, 42, 0.6) !important;
        border-color: #334155 !important;
    }
    body[data-layout-mode="dark"] .available-expense-card,
    body[light-mode="dark"] .available-expense-card,
    html.dark .available-expense-card,
    body.dark-mode .available-expense-card,
    body.dark .available-expense-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[data-layout-mode="dark"] .available-expense-card:hover,
    body[light-mode="dark"] .available-expense-card:hover,
    html.dark .available-expense-card:hover,
    body.dark-mode .available-expense-card:hover,
    body.dark .available-expense-card:hover {
        background-color: rgba(16, 185, 129, 0.15) !important;
        border-color: #10b981 !important;
    }
    body[data-layout-mode="dark"] .available-expense-card span,
    body[light-mode="dark"] .available-expense-card span,
    html.dark .available-expense-card span {
        color: #f8fafc !important;
    }

    body[data-layout-mode="dark"] .selected-expense-item,
    body[light-mode="dark"] .selected-expense-item,
    html.dark .selected-expense-item,
    body.dark-mode .selected-expense-item,
    body.dark .selected-expense-item {
        background-color: rgba(6, 78, 59, 0.25) !important;
        border-color: #10b981 !important;
    }
    body[data-layout-mode="dark"] .selected-expense-item:hover,
    body[light-mode="dark"] .selected-expense-item:hover,
    html.dark .selected-expense-item:hover {
        background-color: rgba(6, 78, 59, 0.4) !important;
    }

    /* Unified UI Border & Table Dark Mode Overrides (Matching other battery pages) */
    body[light-mode="dark"] .unified-ui-border,
    body[data-layout-mode="dark"] .unified-ui-border,
    html.dark .unified-ui-border,
    body.dark-mode .unified-ui-border,
    body.dark .unified-ui-border {
        border-color: #334155 !important;
    }
    body[data-layout-mode="dark"] #printTable,
    body[data-layout-mode="dark"] #printTable th,
    body[data-layout-mode="dark"] #printTable td,
    body[data-layout-mode="dark"] #printTable tr,
    body[light-mode="dark"] #printTable,
    body[light-mode="dark"] #printTable th,
    body[light-mode="dark"] #printTable td,
    body[light-mode="dark"] #printTable tr,
    html.dark #printTable th,
    html.dark #printTable td {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .card,
    body[data-layout-mode="dark"] .card,
    html.dark .card,
    body.dark-mode .card,
    body.dark .card {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .search-input-wrapper,
    body[data-layout-mode="dark"] .search-input-wrapper,
    html.dark .search-input-wrapper {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .entries-wrapper,
    body[data-layout-mode="dark"] .entries-wrapper,
    html.dark .entries-wrapper {
        border-color: #334155 !important;
    }

    /* Staff Tag Badge styling with Dark Mode support (prevents white tag in dark mode) */
    .staff-tag-badge {
        font-size: 9px !important;
        font-weight: 700 !important;
        padding: 2px 6px !important;
        border-radius: 6px !important;
        background-color: #eef2ff !important;
        color: #4338ca !important;
        border: 1px solid #c7d2fe !important;
        display: inline-flex !important;
        align-items: center !important;
        line-height: normal !important;
    }
    body[data-layout-mode="dark"] .staff-tag-badge,
    body[light-mode="dark"] .staff-tag-badge,
    html.dark .staff-tag-badge,
    body.dark-mode .staff-tag-badge,
    body.dark .staff-tag-badge {
        background-color: rgba(99, 102, 241, 0.22) !important;
        color: #a5b4fc !important;
        border-color: rgba(99, 102, 241, 0.45) !important;
    }
    body[data-layout-mode="dark"] .available-expense-card .badge,
    body[light-mode="dark"] .available-expense-card .badge,
    html.dark .available-expense-card .badge,
    body.dark-mode .available-expense-card .badge,
    body.dark .available-expense-card .badge,
    body[data-layout-mode="dark"] .selected-expense-item .badge,
    body[light-mode="dark"] .selected-expense-item .badge,
    html.dark .selected-expense-item .badge,
    body.dark-mode .selected-expense-item .badge,
    body.dark .selected-expense-item .badge {
        background-color: rgba(99, 102, 241, 0.22) !important;
        color: #a5b4fc !important;
        border-color: rgba(99, 102, 241, 0.45) !important;
    }

    body[data-layout-mode="dark"] .modal-salary-row,
    body[light-mode="dark"] .modal-salary-row,
    html.dark .modal-salary-row {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    /* Custom Search Filter Dropdown (Select2) in Item Expense Details Modal */
    #itemExpenseDetailsModal .select2-container {
        width: 100% !important;
        display: block !important;
    }
    #itemExpenseDetailsModal .select2-container--default .select2-selection--single {
        height: 42px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 8px !important;
        display: flex !important;
        align-items: center !important;
        padding: 0 10px !important;
        background-color: #ffffff !important;
        transition: border-color 0.15s ease, box-shadow 0.15s ease !important;
    }
    #itemExpenseDetailsModal .select2-container--default .select2-selection--single:focus,
    #itemExpenseDetailsModal .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.2) !important;
    }
    #itemExpenseDetailsModal .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px !important;
        color: #0f172a !important;
        font-size: 13.5px !important;
        font-weight: 500 !important;
        padding-left: 2px !important;
        padding-right: 20px !important;
    }
    #itemExpenseDetailsModal .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #94a3b8 !important;
    }
    #itemExpenseDetailsModal .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
        right: 10px !important;
    }
    .select2-dropdown {
        z-index: 9999999 !important;
        border-radius: 10px !important;
        border: 1.5px solid #cbd5e1 !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15) !important;
        overflow: hidden !important;
        background-color: #ffffff !important;
    }
    .select2-container--default .select2-search--dropdown {
        padding: 8px 10px !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 6px !important;
        padding: 6px 12px !important;
        outline: none !important;
        font-size: 13px !important;
        width: 100% !important;
        color: #0f172a !important;
        background-color: #ffffff !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 2px rgba(21, 128, 61, 0.2) !important;
    }
    .select2-container--default .select2-results__option {
        padding: 8px 12px !important;
        font-size: 13px !important;
        color: #334155 !important;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #15803d !important;
        color: #ffffff !important;
    }
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #ecfdf5 !important;
        color: #065f46 !important;
        font-weight: 600 !important;
    }

    /* Dark Mode Select2 Styles */
    body[light-mode="dark"] #itemExpenseDetailsModal .select2-container--default .select2-selection--single,
    html.dark #itemExpenseDetailsModal .select2-container--default .select2-selection--single,
    body[data-layout-mode="dark"] #itemExpenseDetailsModal .select2-container--default .select2-selection--single,
    body.dark #itemExpenseDetailsModal .select2-container--default .select2-selection--single {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #itemExpenseDetailsModal .select2-container--default .select2-selection--single .select2-selection__rendered,
    html.dark #itemExpenseDetailsModal .select2-container--default .select2-selection--single .select2-selection__rendered,
    body[data-layout-mode="dark"] #itemExpenseDetailsModal .select2-container--default .select2-selection--single .select2-selection__rendered,
    body.dark #itemExpenseDetailsModal .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .select2-dropdown,
    html.dark .select2-dropdown,
    body[data-layout-mode="dark"] .select2-dropdown,
    body.dark .select2-dropdown {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .select2-container--default .select2-search--dropdown .select2-search__field,
    html.dark .select2-container--default .select2-search--dropdown .select2-search__field,
    body[data-layout-mode="dark"] .select2-container--default .select2-search--dropdown .select2-search__field,
    body.dark .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .select2-container--default .select2-results__option,
    html.dark .select2-container--default .select2-results__option,
    body[data-layout-mode="dark"] .select2-container--default .select2-results__option,
    body.dark .select2-container--default .select2-results__option {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .select2-container--default .select2-results__option[aria-selected=true],
    html.dark .select2-container--default .select2-results__option[aria-selected=true],
    body[data-layout-mode="dark"] .select2-container--default .select2-results__option[aria-selected=true],
    body.dark .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: rgba(16, 185, 129, 0.2) !important;
        color: #34d399 !important;
    }
    body[light-mode="dark"] .select2-container--default .select2-results__option--highlighted[aria-selected],
    html.dark .select2-container--default .select2-results__option--highlighted[aria-selected],
    body[data-layout-mode="dark"] .select2-container--default .select2-results__option--highlighted[aria-selected],
    body.dark .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #15803d !important;
        color: #ffffff !important;
    }

    /* Flatpickr Dark Mode */
    body[data-layout-mode="dark"] .flatpickr-calendar,
    body[light-mode="dark"] .flatpickr-calendar,
    html.dark .flatpickr-calendar,
    body.dark-mode .flatpickr-calendar,
    body.dark .flatpickr-calendar {
        background: #1e293b !important;
        border-color: #334155 !important;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.5), 0 4px 10px -2px rgba(0,0,0,0.4) !important;
        color: #f1f5f9 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-months,
    body[light-mode="dark"] .flatpickr-months,
    html.dark .flatpickr-months,
    body.dark-mode .flatpickr-months,
    body.dark .flatpickr-months,
    body[data-layout-mode="dark"] .flatpickr-month,
    body[light-mode="dark"] .flatpickr-month,
    html.dark .flatpickr-month,
    body.dark-mode .flatpickr-month,
    body.dark .flatpickr-month {
        background: #0f172a !important;
        color: #f1f5f9 !important;
        fill: #f1f5f9 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-current-month,
    body[light-mode="dark"] .flatpickr-current-month,
    html.dark .flatpickr-current-month,
    body.dark-mode .flatpickr-current-month,
    body.dark .flatpickr-current-month,
    body[data-layout-mode="dark"] .flatpickr-current-month .numInputWrapper input,
    body[light-mode="dark"] .flatpickr-current-month .numInputWrapper input,
    html.dark .flatpickr-current-month .numInputWrapper input,
    body[data-layout-mode="dark"] .flatpickr-current-month .flatpickr-monthDropdown-months,
    body[light-mode="dark"] .flatpickr-current-month .flatpickr-monthDropdown-months,
    html.dark .flatpickr-current-month .flatpickr-monthDropdown-months,
    body.dark-mode .flatpickr-current-month .flatpickr-monthDropdown-months,
    body.dark .flatpickr-current-month .flatpickr-monthDropdown-months {
        color: #f1f5f9 !important;
        background: transparent !important;
    }
    body[data-layout-mode="dark"] .flatpickr-prev-month,
    body[light-mode="dark"] .flatpickr-prev-month,
    html.dark .flatpickr-prev-month,
    body.dark-mode .flatpickr-prev-month,
    body.dark .flatpickr-prev-month,
    body[data-layout-mode="dark"] .flatpickr-next-month,
    body[light-mode="dark"] .flatpickr-next-month,
    html.dark .flatpickr-next-month,
    body.dark-mode .flatpickr-next-month,
    body.dark .flatpickr-next-month {
        color: #94a3b8 !important;
        fill: #94a3b8 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-prev-month:hover,
    body[light-mode="dark"] .flatpickr-prev-month:hover,
    html.dark .flatpickr-prev-month:hover,
    body[data-layout-mode="dark"] .flatpickr-next-month:hover,
    body[light-mode="dark"] .flatpickr-next-month:hover,
    html.dark .flatpickr-next-month:hover {
        color: #10b981 !important;
        fill: #10b981 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-weekdays,
    body[light-mode="dark"] .flatpickr-weekdays,
    html.dark .flatpickr-weekdays,
    body.dark-mode .flatpickr-weekdays,
    body.dark .flatpickr-weekdays {
        background: #0f172a !important;
    }
    body[data-layout-mode="dark"] span.flatpickr-weekday,
    body[light-mode="dark"] span.flatpickr-weekday,
    html.dark span.flatpickr-weekday,
    body.dark-mode span.flatpickr-weekday,
    body.dark span.flatpickr-weekday {
        background: #0f172a !important;
        color: #64748b !important;
    }
    body[data-layout-mode="dark"] .flatpickr-day,
    body[light-mode="dark"] .flatpickr-day,
    html.dark .flatpickr-day,
    body.dark-mode .flatpickr-day,
    body.dark .flatpickr-day {
        color: #e2e8f0 !important;
        border-color: transparent !important;
    }
    body[data-layout-mode="dark"] .flatpickr-day:hover,
    body[light-mode="dark"] .flatpickr-day:hover,
    html.dark .flatpickr-day:hover,
    body.dark-mode .flatpickr-day:hover,
    body.dark .flatpickr-day:hover {
        background: #334155 !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-day.today,
    body[light-mode="dark"] .flatpickr-day.today,
    html.dark .flatpickr-day.today,
    body.dark-mode .flatpickr-day.today,
    body.dark .flatpickr-day.today {
        border-color: #10b981 !important;
        color: #10b981 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-day.today:hover,
    body[light-mode="dark"] .flatpickr-day.today:hover,
    html.dark .flatpickr-day.today:hover {
        background: #10b981 !important;
        color: #ffffff !important;
    }
    body[data-layout-mode="dark"] .flatpickr-day.selected,
    body[light-mode="dark"] .flatpickr-day.selected,
    html.dark .flatpickr-day.selected,
    body.dark-mode .flatpickr-day.selected,
    body.dark .flatpickr-day.selected {
        background: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }

    /* Dark Mode Pagination */
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
    let globalExpenseData = [];
    let globalExpenseTypes = [];
    let globalStaffList = [];
    let currentPage = 1;
    let pageSize = 15;
    let salaryRowCounters = {};
    let expenseDatePicker = null;
    let updateDatePicker = null;

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

    $(document).ready(function () {
        $("#entries").val("15");
        $('#createExpenseModal, #updateExpenseModal, #expenseDeleteModal, #addBrandModal, #addStaffQuickModal, #itemExpenseDetailsModal').appendTo('body');
        initExpenseDatePickers();
        getExpenseList();
        loadExpenseTypesAndStaff();
    });

    function initExpenseDatePickers() {
        const createDateInput = document.getElementById('ExpenseDate');
        if (createDateInput) {
            if (expenseDatePicker) expenseDatePicker.destroy();
            expenseDatePicker = flatpickr(createDateInput, {
                dateFormat: "Y-m-d",
                defaultDate: new Date(),
                allowInput: true,
                static: false,
                appendTo: document.body,
                disableMobile: true
            });
        }
        const updateDateInput = document.getElementById('UpdateExpenseDate');
        if (updateDateInput) {
            if (updateDatePicker) updateDatePicker.destroy();
            updateDatePicker = flatpickr(updateDateInput, {
                dateFormat: "Y-m-d",
                allowInput: true,
                static: false,
                appendTo: document.body,
                disableMobile: true
            });
        }
    }

    // ── Fetch Expenses & Stats ──
    async function getExpenseList() {
        try {
            showLoader();
            const res = await axios.get("/api/battery/expense-list", HeaderToken());
            hideLoader();

            if (res.data.status === "success") {
                globalExpenseData = res.data.ExpenseData || [];
                
                // Update 4 Summary Counters
                $('#statTotalExpense').text(`৳ ${formatBdCurrency(res.data.subTotal || 0)}`);
                $('#statTodayExpense').text(`৳ ${formatBdCurrency(res.data.todayExpense || 0)}`);
                $('#statMonthExpense').text(`৳ ${formatBdCurrency(res.data.thisMonthExpense || 0)}`);
                $('#statSalaryExpense').text(`৳ ${formatBdCurrency(res.data.totalSalaryPaid || 0)}`);

                renderExpensePaginatedList();
            }
        } catch (error) {
            hideLoader();
            console.error("Error fetching Battery Expense List:", error);
        }
    }

    async function loadExpenseTypesAndStaff() {
        try {
            const [typesRes, staffRes] = await Promise.all([
                axios.get('/api/battery/expense-type-list', HeaderToken()),
                axios.get('/api/battery/staff-list', HeaderToken()).catch(() => axios.get('/api/staff-list', HeaderToken()))
            ]);

            if (typesRes.data.status === 'success' || typesRes.data.ExpenseTypeData) {
                globalExpenseTypes = typesRes.data.ExpenseTypeData || [];
            }
            if (staffRes.data.status === 'success') {
                globalStaffList = staffRes.data.StaffData || [];
            }

            renderExpenseTypeCheckboxes();
            populateUpdateExpenseTypeDropdown();
        } catch (e) {
            console.error("Error loading expense types or staff:", e);
        }
    }

    $("#searchInput").on("keyup search input", function () {
        currentPage = 1;
        renderExpensePaginatedList();
    });

    $("#entries").on("change", function () {
        pageSize = parseInt($(this).val()) || 15;
        currentPage = 1;
        renderExpensePaginatedList();
    });

    // ── Render Desktop Table & Mobile Cards ──
    function renderExpensePaginatedList() {
        if (!globalExpenseData) return;

        let searchTerm = $("#searchInput").val().toLowerCase().trim();

        let filtered = globalExpenseData.filter(function (item) {
            let typeName = (item.type_name || (item.expense_type ? item.expense_type.type_name : "")).toLowerCase();
            let details = (item.expense_details || "").toLowerCase();
            let staffName = (item.staff_name || (item.staff ? item.staff.name : "")).toLowerCase();
            let dateStr = (item.date || "").toLowerCase();

            return !searchTerm || typeName.includes(searchTerm) || details.includes(searchTerm) || staffName.includes(searchTerm) || dateStr.includes(searchTerm);
        });

        let pageSum = 0;
        filtered.forEach(item => {
            pageSum += parseFloat(item.expense_amount) || 0;
        });
        $("#pageTotalExpense").text(`৳ ${formatBdCurrency(pageSum)}`);

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
            tableList.html('<tr><td colspan="7" class="text-center text-rose-500 p-8 font-semibold"><svg class="w-6 h-6 mx-auto mb-2 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>No expenses found.</td></tr>');
            mobileCardList.html('<div class="p-6 text-center text-rose-500 font-semibold bg-white dark:bg-slate-800 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm">No expenses found.</div>');
        } else {
            pageItems.forEach(function (item, idx) {
                let realIndex = startIndex + idx;
                let typeName = item.type_name || (item.expense_type ? item.expense_type.type_name : 'N/A');
                let staffDisplay = item.staff ? `<span class="badge bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300 font-semibold text-xs border border-indigo-200 dark:border-slate-800"><i class="fa-solid fa-user-tie me-1"></i> ${item.staff.name}</span>` : '<span class="text-slate-400 text-xs">General Expense</span>';
                let amount = parseFloat(item.expense_amount) || 0;

                // Action Buttons
                let actionHtml = `
                    <div class="flex items-center justify-center gap-1.5">
                        <button onclick="openEditModal(${item.id})" type="button" class="edit-link" title="Edit Expense">
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                        </button>
                        <button onclick="openDeleteModal(${item.id})" type="button" class="custom-delete-modal-btn" title="Delete Expense">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
                `;

                // Desktop Row
                let row = `
                    <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors border-b border-slate-100 dark:border-slate-800">
                        <td class="p-[10px] text-center font-semibold text-slate-400 dark:text-slate-500">${realIndex + 1}</td>
                        <td class="p-[10px] text-start whitespace-nowrap text-slate-600 dark:text-slate-300 font-medium">
                            <i class="fa-regular fa-calendar-check text-emerald-600 me-1"></i> ${formatDate(item.date)}
                        </td>
                        <td class="p-[10px] text-start">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-slate-800">${typeName}</span>
                        </td>
                        <td class="p-[10px] text-start whitespace-nowrap">${staffDisplay}</td>
                        <td class="p-[10px] text-start text-slate-600 dark:text-slate-300 text-xs font-medium">${item.expense_details || '-'}</td>
                        <td class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ ${formatBdCurrency(amount)}</td>
                        <td class="p-[10px] text-center">${actionHtml}</td>
                    </tr>`;
                tableList.append(row);

                // Mobile Card View
                let mobileCard = `
                    <div class="unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800/90 shadow-sm transition-all mb-3">
                        <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-xs text-slate-500 font-medium"><i class="fa-regular fa-calendar-check text-emerald-600 me-1"></i> ${formatDate(item.date)}</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">${typeName}</span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <div>${staffDisplay}</div>
                            <span class="font-extrabold text-rose-600 dark:text-rose-400 text-sm">৳ ${formatBdCurrency(amount)}</span>
                        </div>
                        <p class="text-xs text-slate-500 mb-2">${item.expense_details || 'No details provided'}</p>
                        <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                            ${actionHtml}
                        </div>
                    </div>`;
                mobileCardList.append(mobileCard);
            });
        }

        updatePaginationUI(totalItems, startIndex, endIndex, totalPages);
    }

    // ── Create Modal Helpers ──
    let selectedExpenseData = {}; // keyed by type_id: { type_id, type_name, is_salary, amount, details, is_saved, staff_rows: [] }
    let activeEditingTypeId = null;

    function openExpenseModal() {
        const dateInput = document.getElementById('ExpenseDate');
        const today = new Date().toISOString().split('T')[0];
        if (dateInput && !dateInput.value) {
            dateInput.value = today;
        }
        initExpenseDatePickers();

        if (globalExpenseTypes.length === 0) {
            loadExpenseTypesAndStaff();
        }

        const modalEl = document.getElementById('createExpenseModal');
        if (modalEl) {
            try {
                let modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modalInstance.show();
                return;
            } catch(e) {
                if (typeof $ !== 'undefined') $('#createExpenseModal').modal('show');
            }
        }
    }

    function closeExpenseModal() {
        try {
            const modalEl = document.getElementById('createExpenseModal');
            if (modalEl) {
                let modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
            }
        } catch(e) {
            console.warn("Bootstrap modal hide error:", e);
        }
        if (typeof $ !== 'undefined') {
            $('#createExpenseModal').modal('hide');
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css({ 'overflow': '', 'padding-right': '' });
        }
        resetExpenseForm();
    }

    function isSalaryTypeName(typeName) {
        if (!typeName) return false;
        const name = typeName.toLowerCase();
        const keywords = ['salary', 'sallery', 'salery', 'salari', 'payroll', 'wage', 'wages', 'বেতন', 'সেলারী', 'স্যালারি'];
        return keywords.some(k => name.includes(k));
    }

    function renderExpenseTypeCheckboxes() {
        const container = document.getElementById('ExpenseTypesContainer');
        if (!container) return;

        if (globalExpenseTypes.length === 0) {
            container.innerHTML = `<div class="text-slate-400 py-3 text-center">No expense types found. Click "+ Create New Type" above.</div>`;
            return;
        }

        const selectedKeys = Object.keys(selectedExpenseData).filter(k => selectedExpenseData[k] && selectedExpenseData[k].is_saved);
        const counterBadge = document.getElementById('selectedItemsCounter');
        if (counterBadge) {
            counterBadge.innerText = `${selectedKeys.length} Selected`;
        }

        let selectedHtml = '';
        if (selectedKeys.length > 0) {
            selectedHtml += `
                <div class="selected-expenses-section mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-xs fw-bold text-emerald-700 dark:text-emerald-400 text-uppercase tracking-wider">
                            <i class="fa-solid fa-circle-check me-1"></i> Selected Items (${selectedKeys.length}):
                        </span>
                        <small class="text-slate-400 text-xs">
                            <i class="fa-solid fa-pen text-emerald-600 me-1"></i> Click card to edit amount/details
                        </small>
                    </div>
                    <div class="d-flex flex-column gap-2">
            `;

            selectedKeys.forEach(typeId => {
                const item = selectedExpenseData[typeId];
                let summaryText = '';
                let totalAmount = 0;

                if (item.is_salary) {
                    const st = globalStaffList.find(s => s.id == (item.staff_id || (item.staff_rows && item.staff_rows[0]?.staff_id)));
                    const staffName = st ? st.name : (item.staff_name || 'Staff');
                    totalAmount = parseFloat(item.amount) || 0;
                    summaryText = `Staff: ${staffName}${item.details ? ' • Note: ' + item.details : ''}`;
                } else {
                    totalAmount = parseFloat(item.amount) || 0;
                    summaryText = item.details ? `Note: ${item.details}` : 'No details entered';
                }

                selectedHtml += `
                    <div class="selected-expense-item" onclick="openItemDetailsModal(${item.type_id})">
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <div class="d-flex align-items-center gap-2.5 flex-grow-1 min-w-0">
                                <span class="d-flex align-items-center justify-content-center rounded-circle bg-emerald-600 text-white flex-shrink-0" style="width: 24px; height: 24px; font-size: 11px;">
                                    <i class="fa-solid fa-check"></i>
                                </span>
                                <div class="min-w-0">
                                    <div class="d-flex align-items-center gap-1.5 flex-wrap">
                                        <span class="fw-bold text-slate-800 dark:text-slate-100 text-sm">${item.type_name}</span>
                                        ${item.is_salary ? '<span class="staff-tag-badge">👨‍💼 Staff Salary</span>' : ''}
                                    </div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400 text-truncate" style="max-width: 320px;">
                                        ${summaryText}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-shrink-0" onclick="event.stopPropagation()">
                                <span class="badge bg-white dark:bg-slate-800 text-rose-600 dark:text-rose-400 border border-slate-200 dark:border-slate-700 fw-bold px-2.5 py-1.5 text-xs shadow-xs">
                                    ৳ ${formatBdCurrency(totalAmount)}
                                </span>
                                <button type="button" class="btn btn-sm btn-outline-success d-inline-flex align-items-center justify-content-center p-0 rounded-circle" style="width: 28px; height: 28px;" title="Click to Edit" onclick="openItemDetailsModal(${item.type_id})">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center justify-content-center p-0 rounded-circle" style="width: 28px; height: 28px;" title="Remove / Unselect" onclick="unselectExpenseItem(${item.type_id})">
                                    <i class="fa-solid fa-xmark text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });

            selectedHtml += `
                    </div>
                </div>
            `;
        }

        // Available items — All types always remain visible (never blank / empty)
        let availableHtml = `
            <div class="available-expenses-section">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs fw-bold text-slate-600 dark:text-slate-400 text-uppercase tracking-wider">
                        Available Expense Types:
                    </span>
                    <small class="text-slate-400 text-xs">
                        <i class="fa-solid fa-arrow-pointer text-emerald-600 me-1"></i> Click card to enter amount
                    </small>
                </div>
                <div class="expense-types-grid">
        `;

        if (globalExpenseTypes.length === 0) {
            availableHtml += `<div class="text-slate-400 py-2 text-center text-xs" style="grid-column: 1 / -1;">No expense types found. Click "+ Create New Type" above.</div>`;
        } else {
            globalExpenseTypes.forEach(type => {
                const isSalary = isSalaryTypeName(type.type_name);
                const isSelected = selectedKeys.includes(String(type.id));
                const activeCardClass = isSelected ? 'border-emerald-500 bg-emerald-50/70 dark:bg-emerald-950/30 dark:border-emerald-600/60' : '';
                const checkIcon = isSelected 
                    ? `<i class="fa-solid fa-square-check text-emerald-600 dark:text-emerald-400 text-xs flex-shrink-0"></i>`
                    : `<i class="fa-regular fa-square text-slate-400 text-xs flex-shrink-0"></i>`;

                availableHtml += `
                    <div class="available-expense-card ${activeCardClass}" onclick="selectAndOpenItemModal(${type.id})" title="${isSelected ? 'Click to edit amount' : 'Click to select and enter amount'}">
                        <div class="d-flex align-items-center gap-2 min-w-0">
                            ${checkIcon}
                            <span class="text-slate-700 dark:text-slate-200 fw-semibold text-xs text-truncate">
                                ${type.type_name}
                            </span>
                            ${isSalary ? '<span class="staff-tag-badge">Staff</span>' : ''}
                        </div>
                        <span class="click-indicator-icon flex-shrink-0" title="${isSelected ? 'Edit' : 'Select'}">
                            <i class="${isSelected ? 'fa-solid fa-pen' : 'fa-solid fa-arrow-up-right-from-square'}"></i>
                        </span>
                    </div>
                `;
            });
        }

        availableHtml += `
                </div>
            </div>
        `;

        container.innerHTML = selectedHtml + availableHtml;
    }

    function selectAndOpenItemModal(typeId) {
        const typeObj = globalExpenseTypes.find(t => t.id == typeId);
        if (!typeObj) return;

        const isSalary = isSalaryTypeName(typeObj.type_name);
        if (!selectedExpenseData[typeId]) {
            selectedExpenseData[typeId] = {
                type_id: typeId,
                type_name: typeObj.type_name,
                is_salary: isSalary,
                staff_id: '',
                amount: '',
                details: '',
                is_saved: false
            };
        }
        openItemDetailsModal(typeId);
    }

    function openItemDetailsModal(typeId) {
        const typeObj = globalExpenseTypes.find(t => t.id == typeId);
        if (!typeObj) return;

        activeEditingTypeId = typeId;
        const isSalary = isSalaryTypeName(typeObj.type_name);

        if (!selectedExpenseData[typeId]) {
            selectedExpenseData[typeId] = {
                type_id: typeId,
                type_name: typeObj.type_name,
                is_salary: isSalary,
                staff_id: '',
                amount: '',
                details: '',
                is_saved: false
            };
        }

        const item = selectedExpenseData[typeId];

        const titleEl = document.getElementById('itemDetailsModalTypeName');
        if (titleEl) {
            titleEl.innerHTML = `<span class="text-emerald-600 dark:text-emerald-400">${item.type_name}</span> - Details`;
        }

        const activeInput = document.getElementById('modalActiveTypeId');
        if (activeInput) activeInput.value = typeId;

        const genContainer = document.getElementById('modalGeneralExpenseFields');
        const salContainer = document.getElementById('modalSalaryExpenseFields');

        if (isSalary) {
            if (genContainer) genContainer.classList.add('d-none');
            if (salContainer) salContainer.classList.remove('d-none');

            // Populate Staff Dropdown with Select2
            const staffSelect = $('#modalSalaryStaff');
            if (staffSelect.length) {
                if (staffSelect.data('select2')) {
                    staffSelect.select2('destroy');
                }
                const currentStaffId = item.staff_id || (item.staff_rows && item.staff_rows[0]?.staff_id) || '';
                let optionsHtml = '<option value="">-- Select Staff --</option>' + globalStaffList.map(s => 
                    `<option value="${s.id}" ${currentStaffId == s.id ? 'selected' : ''}>${s.name} (${s.mobile || 'Staff'})</option>`
                ).join('');
                staffSelect.html(optionsHtml);
                if (typeof $.fn.select2 !== 'undefined') {
                    staffSelect.select2({
                        dropdownParent: $('#itemExpenseDetailsModal'),
                        placeholder: '-- Select Staff --',
                        width: '100%',
                        allowClear: false
                    });
                }
                if (currentStaffId) {
                    staffSelect.val(currentStaffId).trigger('change.select2');
                }
            }

            const salAmt = document.getElementById('modalSalaryAmount');
            const salDet = document.getElementById('modalSalaryDetails');
            if (salAmt) salAmt.value = item.amount || (item.staff_rows && item.staff_rows[0]?.amount) || '';
            if (salDet) salDet.value = item.details || (item.staff_rows && item.staff_rows[0]?.details) || '';
        } else {
            if (genContainer) genContainer.classList.remove('d-none');
            if (salContainer) salContainer.classList.add('d-none');

            const amtInput = document.getElementById('modalExpenseAmount');
            const detInput = document.getElementById('modalExpenseDetails');
            if (amtInput) amtInput.value = item.amount || '';
            if (detInput) detInput.value = item.details || '';
        }

        const modal = document.getElementById('itemExpenseDetailsModal');
        if (modal) {
            modal.classList.add('show');
            modal.style.display = 'flex';
            modal.style.opacity = '1';
            modal.style.visibility = 'visible';
            modal.style.zIndex = '9999995';

            setTimeout(() => {
                if (isSalary) {
                    const staffVal = $('#modalSalaryStaff').val();
                    if (!staffVal && typeof $.fn.select2 !== 'undefined') {
                        $('#modalSalaryStaff').select2('open');
                    } else {
                        const salAmt = document.getElementById('modalSalaryAmount');
                        if (salAmt) salAmt.focus();
                    }
                } else {
                    const amtInput = document.getElementById('modalExpenseAmount');
                    if (amtInput) amtInput.focus();
                }
            }, 100);
        }
    }

    function refreshModalStaffDropdowns() {
        if (activeEditingTypeId && selectedExpenseData[activeEditingTypeId]?.is_salary) {
            const staffSelect = $('#modalSalaryStaff');
            if (staffSelect.length) {
                const curVal = staffSelect.val();
                if (staffSelect.data('select2')) {
                    staffSelect.select2('destroy');
                }
                staffSelect.html('<option value="">-- Select Staff --</option>' + globalStaffList.map(s => 
                    `<option value="${s.id}" ${curVal == s.id ? 'selected' : ''}>${s.name} (${s.mobile || 'Staff'})</option>`
                ).join(''));
                if (typeof $.fn.select2 !== 'undefined') {
                    staffSelect.select2({
                        dropdownParent: $('#itemExpenseDetailsModal'),
                        placeholder: '-- Select Staff --',
                        width: '100%',
                        allowClear: false
                    });
                }
                if (curVal) {
                    staffSelect.val(curVal).trigger('change.select2');
                }
            }
        }
    }

    function saveItemDetailsModal(event) {
        if (event && typeof event.preventDefault === 'function') event.preventDefault();
        if (!activeEditingTypeId || !selectedExpenseData[activeEditingTypeId]) return false;

        const item = selectedExpenseData[activeEditingTypeId];

        if (item.is_salary) {
            const staffId = $('#modalSalaryStaff').val() || '';
            const amtInput = document.getElementById('modalSalaryAmount');
            const detInput = document.getElementById('modalSalaryDetails');

            const amt = parseFloat(amtInput ? amtInput.value : 0);
            const details = detInput ? detInput.value.trim() : '';

            if (!staffId) {
                errorToast("Please select staff!");
                if (typeof $.fn.select2 !== 'undefined') $('#modalSalaryStaff').select2('open');
                return false;
            }
            if (isNaN(amt) || amt <= 0) {
                errorToast("Please enter a valid salary amount!");
                if (amtInput) amtInput.focus();
                return false;
            }

            const staffObj = globalStaffList.find(s => s.id == staffId);
            item.staff_id = staffId;
            item.staff_name = staffObj ? staffObj.name : 'Staff';
            item.amount = amt;
            item.details = details;
            item.staff_rows = [{ staff_id: staffId, amount: amt, details: details }];
            item.is_saved = true;
        } else {
            const amtInput = document.getElementById('modalExpenseAmount');
            const detInput = document.getElementById('modalExpenseDetails');

            const amt = parseFloat(amtInput ? amtInput.value : 0);
            const details = detInput ? detInput.value.trim() : '';

            if (isNaN(amt) || amt <= 0) {
                errorToast("Please enter a valid expense amount!");
                if (amtInput) amtInput.focus();
                return false;
            }

            item.amount = amt;
            item.details = details;
            item.is_saved = true;
        }

        closeItemDetailsModal(true);
        renderExpenseTypeCheckboxes();
        return false;
    }

    function closeItemDetailsModal(saved = false) {
        if (!saved && activeEditingTypeId && selectedExpenseData[activeEditingTypeId]) {
            if (!selectedExpenseData[activeEditingTypeId].is_saved) {
                delete selectedExpenseData[activeEditingTypeId];
            }
        }

        if (typeof $.fn.select2 !== 'undefined' && $('#modalSalaryStaff').data('select2')) {
            $('#modalSalaryStaff').select2('close');
        }

        const modal = document.getElementById('itemExpenseDetailsModal');
        if (modal) {
            modal.classList.remove('show');
            modal.style.display = 'none';
            modal.style.opacity = '0';
            modal.style.visibility = 'hidden';
        }

        activeEditingTypeId = null;
        renderExpenseTypeCheckboxes();
    }

    function unselectExpenseItem(typeId) {
        if (selectedExpenseData[typeId]) {
            delete selectedExpenseData[typeId];
            renderExpenseTypeCheckboxes();
        }
    }

    // ── Sub-Modals: New Type & New Staff ──
    function openBrandModal() {
        const modal = document.getElementById('addBrandModal');
        if (modal) {
            modal.style.display = 'flex';
            modal.classList.add('show');
        }
    }
    function closeBrandModal() {
        const modal = document.getElementById('addBrandModal');
        if (modal) {
            modal.style.display = 'none';
            modal.classList.remove('show');
        }
    }
    function openStaffQuickModal() {
        const modal = document.getElementById('addStaffQuickModal');
        if (modal) {
            modal.style.display = 'flex';
            modal.classList.add('show');
        }
    }
    function closeStaffQuickModal() {
        const modal = document.getElementById('addStaffQuickModal');
        if (modal) {
            modal.style.display = 'none';
            modal.classList.remove('show');
        }
    }

    async function saveExpenseType(event) {
        event.preventDefault();
        try {
            const expenseTypeName = document.getElementById('CreateExpenseTypeName').value.trim();
            const expenseStatus = document.getElementById('ExpenseSelectStatus').value;

            if (!expenseTypeName) {
                errorToast("Expense Type Name is required!");
                return;
            }

            const payload = {
                type_name: expenseTypeName,
                status: expenseStatus
            };

            const res = await axios.post("/api/battery/create-expense-type", payload, HeaderToken());

            if (res.data.status === "success") {
                successToast(res.data.message || "Expense type created!");
                document.getElementById('CreateExpenseTypeName').value = '';
                closeBrandModal();
                await loadExpenseTypesAndStaff();
            } else {
                errorToast(res.data.message || "Failed to create type");
            }
        } catch (e) {
            unauthorized(e.response?.status || 500);
        }
    }

    async function saveQuickStaff(event) {
        event.preventDefault();
        try {
            const name = document.getElementById('QuickStaffName').value.trim();
            const mobile = document.getElementById('QuickStaffMobile').value.trim();
            const email = document.getElementById('QuickStaffEmail').value.trim();
            const role = document.getElementById('QuickStaffRole').value;

            if (!name || !mobile) {
                errorToast("Staff name and mobile number are required!");
                return;
            }

            const formData = new FormData();
            formData.append('name', name);
            formData.append('mobile', mobile);
            formData.append('email', email);
            formData.append('password', '123456');
            formData.append('role', role);
            formData.append('status', 'approved');

            const res = await axios.post('/create-user-admin', formData, HeaderToken());

            if (res.data.status === 'success') {
                successToast(res.data.message || "New staff added successfully!");
                document.getElementById('QuickStaffName').value = '';
                document.getElementById('QuickStaffMobile').value = '';
                document.getElementById('QuickStaffEmail').value = '';
                closeStaffQuickModal();
                await loadExpenseTypesAndStaff();
                refreshModalStaffDropdowns();
            } else {
                errorToast(res.data.message || "Failed to create staff");
            }
        } catch (e) {
            console.error("Staff save error:", e);
            errorToast(e.response?.data?.message || "Could not create staff");
        }
    }

    // ── Save Batch Expenses ──
    async function SaveExpense(event) {
        if (event && typeof event.preventDefault === 'function') event.preventDefault();
        try {
            const expenseDate = document.getElementById('ExpenseDate').value;
            if (!expenseDate) {
                errorToast("Date selection is required!");
                return false;
            }

            const selectedKeys = Object.keys(selectedExpenseData).filter(k => selectedExpenseData[k] && selectedExpenseData[k].is_saved);
            if (selectedKeys.length === 0) {
                errorToast("Please select at least one expense type and enter amount!");
                return false;
            }

            const checkedItems = [];
            let isValid = true;

            for (const typeId of selectedKeys) {
                const item = selectedExpenseData[typeId];
                if (item.is_salary) {
                    const staffId = item.staff_id || (item.staff_rows && item.staff_rows[0]?.staff_id);
                    const amt = parseFloat(item.amount || (item.staff_rows && item.staff_rows[0]?.amount));
                    const details = item.details || (item.staff_rows && item.staff_rows[0]?.details) || '';

                    if (!staffId) {
                        errorToast(`Staff selection is required for ${item.type_name}!`);
                        isValid = false;
                        break;
                    }
                    if (isNaN(amt) || amt <= 0) {
                        errorToast(`Please enter valid amount for ${item.type_name}!`);
                        isValid = false;
                        break;
                    }
                    checkedItems.push({
                        expense_type_id: typeId,
                        staff_id: staffId,
                        expense_amount: amt,
                        expense_details: details,
                        date: expenseDate
                    });
                } else {
                    const amount = parseFloat(item.amount);
                    if (isNaN(amount) || amount <= 0) {
                        errorToast(`Please enter amount for ${item.type_name}!`);
                        isValid = false;
                        break;
                    }
                    checkedItems.push({
                        expense_type_id: typeId,
                        staff_id: null,
                        expense_amount: amount,
                        expense_details: item.details || '',
                        date: expenseDate
                    });
                }
            }

            if (!isValid || checkedItems.length === 0) return false;

            showLoader();
            const payload = { items: checkedItems };
            const res = await axios.post("/api/battery/create-expense", payload, HeaderToken());
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message);
                resetExpenseForm();
                closeExpenseModal();
                await getExpenseList();
            } else {
                errorToast(res.data.message || "An error occurred");
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            unauthorized(e.response?.status || 500);
        }
    }

    function resetExpenseForm() {
        const form = document.getElementById('expenseForm');
        if (form) form.reset();

        selectedExpenseData = {};
        activeEditingTypeId = null;
        renderExpenseTypeCheckboxes();

        const today = new Date().toISOString().split('T')[0];
        const dateInput = document.getElementById('ExpenseDate');
        if (dateInput) dateInput.value = today;
    }

    // ── Update Expense ──
    function populateUpdateExpenseTypeDropdown() {
        const select = document.getElementById('UpdateExpenseTypeInfoID');
        if (!select) return;
        select.innerHTML = '<option value="">Select Expense Type</option>' + globalExpenseTypes.map(t => `<option value="${t.id}" data-name="${t.type_name}">${t.type_name}</option>`).join('');
    }

    function checkUpdateExpenseSalaryType() {
        const select = document.getElementById('UpdateExpenseTypeInfoID');
        const selectedOpt = select.options[select.selectedIndex];
        const typeName = selectedOpt ? selectedOpt.getAttribute('data-name') : '';
        const container = document.getElementById('UpdateStaffContainer');
        const staffSelect = document.getElementById('UpdateStaffInfoID');

        if (isSalaryTypeName(typeName)) {
            container.classList.remove('d-none');
            staffSelect.setAttribute('required', 'required');
            staffSelect.innerHTML = '<option value="">-- Select Staff --</option>' + globalStaffList.map(s => `<option value="${s.id}">${s.name} (${s.mobile || 'Staff'})</option>`).join('');
        } else {
            container.classList.add('d-none');
            staffSelect.removeAttribute('required');
            staffSelect.value = '';
        }
    }

    async function openEditModal(id) {
        try {
            showLoader();
            const res = await axios.post("/api/battery/expense-by-id", { id: id.toString() }, HeaderToken());
            hideLoader();

            if (res.data.status === "success" && res.data.rows) {
                const row = res.data.rows;
                document.getElementById('updateID').value = row.id;
                document.getElementById('UpdateExpenseTypeInfoID').value = row.expense_type_id;
                checkUpdateExpenseSalaryType();

                if (row.staff_id) {
                    document.getElementById('UpdateStaffInfoID').value = row.staff_id;
                }
                document.getElementById('UpdateExpenseAmount').value = row.expense_amount;
                document.getElementById('UpdateExpenseDate').value = row.date;
                document.getElementById('UpdateExpenseDetails').value = row.expense_details || '';

                const modalEl = document.getElementById('updateExpenseModal');
                let modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modalInstance.show();
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            unauthorized(e.response?.status || 500);
        }
    }

    async function UpdateExpense(event) {
        if (event) event.preventDefault();
        try {
            const updateID = document.getElementById('updateID').value;
            const typeId = document.getElementById('UpdateExpenseTypeInfoID').value;
            const staffId = document.getElementById('UpdateStaffInfoID').value || null;
            const amount = document.getElementById('UpdateExpenseAmount').value;
            const date = document.getElementById('UpdateExpenseDate').value;
            const details = document.getElementById('UpdateExpenseDetails').value;

            if (!typeId || !amount || !date) {
                errorToast("Please fill all required fields!");
                return;
            }

            const payload = {
                id: updateID,
                expense_type_id: typeId,
                staff_id: staffId,
                expense_amount: amount,
                date: date,
                expense_details: details
            };

            showLoader();
            const res = await axios.post("/api/battery/update-expense", payload, HeaderToken());
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message || "Expense updated successfully!");
                const modalEl = document.getElementById('updateExpenseModal');
                let modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
                await getExpenseList();
            } else {
                errorToast(res.data.message || "Failed to update expense");
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            unauthorized(e.response?.status || 500);
        }
    }

    // ── Delete Expense ──
    function openDeleteModal(id) {
        document.getElementById('deleteID').value = id;
        const modalEl = document.getElementById('expenseDeleteModal');
        let modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modalInstance.show();
    }

    async function itemDelete() {
        try {
            const id = document.getElementById('deleteID').value;
            showLoader();
            const res = await axios.post("/api/battery/delete-expense", { id: id }, HeaderToken());
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message || "Expense deleted successfully!");
                const modalEl = document.getElementById('expenseDeleteModal');
                let modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
                await getExpenseList();
            } else {
                errorToast(res.data.message || "Failed to delete expense");
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
        renderExpensePaginatedList();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>
@endsection
