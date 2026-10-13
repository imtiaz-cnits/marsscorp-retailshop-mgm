@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Expense Types - MARSS CORPORATION')
@section('content')

<!-- Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-screen flex flex-col justify-between">
        <div class="data-table flex-grow">
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-10">
                    
                    <!-- 1. Top Section: Page Title & Create Expense Type Button (Fixed 38px) -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                    <line x1="9" y1="7" x2="15" y2="7"></line>
                                    <line x1="9" y1="11" x2="13" y2="11"></line>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Expense Type List</h1>
                        </div>

                        <!-- Right Controls: + Create Expense Type Button (Strictly only this button) -->
                        <div class="flex items-center flex-wrap gap-2">
                            <button id="openModalBtns" onclick="openExpenseTypeCreateModal()" type="button" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Create Expense Type</span>
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
                                <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search Expense Type..." />
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

                    <!-- 3. Desktop Table (SL header on left, Action on far right) -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Type Name</th>
                                    <th class="p-[10px] text-center w-[120px] whitespace-nowrap">Status</th>
                                    <th class="p-[10px] text-center w-[75px] rounded-tr-2xl whitespace-nowrap">Action</th>
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

        <!-- Sticky Bottom Copyright Section -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)]">
            <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>

    </div>
</div>
<!-- Main Content End -->

<!-- Create Expense Type Modal -->
<div class="modal fade" id="createExpenseTypeModal" tabindex="-1" aria-labelledby="createExpenseTypeModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 520px;">
        <div class="modal-content bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-2xl rounded-2xl overflow-hidden flex flex-col">
            
            <div class="modal-header-green flex items-center justify-between px-4 py-3 border-0 flex-shrink-0">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            <line x1="12" y1="6" x2="12" y2="12"></line>
                            <line x1="9" y1="9" x2="15" y2="9"></line>
                        </svg>
                    </div>
                    <h5 class="text-base font-bold text-white tracking-tight m-0" id="createExpenseTypeModalLabel">Create Expense Type</h5>
                </div>
                <button type="button" class="qv-close-btn" data-bs-dismiss="modal" onclick="closeExpenseTypeModal()" aria-label="Close" title="Close">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div class="modal-body p-4 text-start overflow-y-auto">
                <form onsubmit="return SaveExpenseType(event)">
                    <div class="row g-2.5 text-start">
                        <div class="col-12 col-md-6 text-start">
                            <label for="ExpenseTypeName" class="custom-modal-label">Expense Type Name <span class="text-rose-500">*</span></label>
                            <input type="text" id="ExpenseTypeName" placeholder="Enter type name" required class="custom-modal-input" />
                        </div>
                        <div class="col-12 col-md-6 text-start">
                            <label for="SelectStatus" class="custom-modal-label">Status <span class="text-rose-500">*</span></label>
                            <select id="SelectStatus" required class="custom-modal-input">
                                <option value="Active" selected>Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex items-center justify-end gap-2 flex-shrink-0">
                <button type="button" onclick="closeExpenseTypeModal()" class="cp-btn-cancel">
                    Cancel
                </button>
                <button type="button" onclick="SaveExpenseType(event)" class="cp-btn-primary">
                    Submit
                </button>
            </div>

        </div>
    </div>
</div>

<!-- Update Expense Type Modal (Fixed Height & 2 Columns) -->
<div class="modal fade" id="updateExpenseTypeModal" tabindex="-1" aria-labelledby="updateExpenseTypeModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 520px;">
        <div class="modal-content bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 shadow-2xl rounded-2xl overflow-hidden flex flex-col">
            
            <div class="modal-header-green flex items-center justify-between px-4 py-3 border-0 flex-shrink-0">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20h9"></path>
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                        </svg>
                    </div>
                    <h5 class="text-base font-bold text-white tracking-tight m-0" id="updateExpenseTypeModalLabel">Update Expense Type</h5>
                </div>
                <button type="button" class="qv-close-btn" data-bs-dismiss="modal" aria-label="Close" title="Close">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div class="modal-body p-4 text-start overflow-y-auto">
                <form id="updateForm" onsubmit="return UpdateExpenseType(event)">
                    <input type="hidden" id="updateID">
                    <div class="row g-2.5 text-start">
                        <div class="col-12 col-md-6 text-start">
                            <label for="UpdateExpenseTypeName" class="custom-modal-label">Expense Type Name <span class="text-rose-500">*</span></label>
                            <input type="text" placeholder="Update Expense Type Name" id="UpdateExpenseTypeName" required class="custom-modal-input" />
                        </div>
                        <div class="col-12 col-md-6 text-start">
                            <label for="UpdateSelectStatus" class="custom-modal-label">Status <span class="text-rose-500">*</span></label>
                            <select id="UpdateSelectStatus" required class="custom-modal-input">
                                <option value="Active">Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex items-center justify-end gap-2 flex-shrink-0">
                <button type="button" data-bs-dismiss="modal" class="cp-btn-cancel">
                    Cancel
                </button>
                <button type="button" onclick="UpdateExpenseType(event)" class="cp-btn-primary">
                    Update
                </button>
            </div>

        </div>
    </div>
</div>

<!-- Delete Confirmation Modal (Dead-Centered, No Duplicate Box) -->
<div class="modal fade" id="expenseTypeDeleteModal" tabindex="-1" aria-labelledby="expenseTypeDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
        <div class="modal-content bg-white dark:bg-slate-900 border-0 rounded-2xl shadow-2xl overflow-hidden flex flex-col">
            
            <div class="modal-header px-4 py-3 bg-rose-600 text-white flex items-center justify-between border-0 flex-shrink-0" style="background-color: #dc2626 !important; color: #ffffff !important;">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </div>
                    <h5 class="text-base font-bold text-white tracking-tight m-0" id="expenseTypeDeleteModalLabel">Delete Expense Type</h5>
                </div>
                <button type="button" class="qv-close-btn" data-bs-dismiss="modal" aria-label="Close" style="background-color: #991b1b !important;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div class="modal-body p-6 text-center">
                <div class="w-14 h-14 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto mb-3.5 border border-rose-100 dark:border-slate-800">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <h4 class="text-base sm:text-lg font-bold text-slate-800 dark:text-slate-100 mb-1.5">Confirm Deletion</h4>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mb-0">Are you sure you want to delete this expense type? This action cannot be undone.</p>
                <input type="hidden" id="deleteID" />
            </div>

            <div class="modal-footer px-4 py-3 bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 flex items-center justify-center gap-2.5 flex-shrink-0">
                <button type="button" class="px-4 h-[38px] rounded-xl text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 unified-ui-border text-xs sm:text-sm font-semibold shadow-sm hover:bg-slate-100 dark:hover:bg-slate-700 cursor-pointer" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" onclick="itemDelete()" class="px-5 h-[38px] rounded-xl text-white text-xs sm:text-sm font-semibold shadow-sm bg-rose-600 hover:bg-rose-700 active:scale-[0.98] cursor-pointer" style="background-color: #dc2626 !important;">
                    Yes, Delete
                </button>
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
    #printTable tbody td {
        padding: 10px !important;
    }

    /* Action Buttons Hover - Strictly Never White in Light Mode */
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

    /* Universal Modal Reset & Centering - Remove duplicate white box & excessive height */
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
    #createExpenseTypeModal .modal-dialog,
    #updateExpenseTypeModal .modal-dialog,
    #exampleModal .modal-dialog,
    #expenseTypeDeleteModal .modal-dialog,
    #confirmationModal .modal-dialog {
        position: static !important;
        top: auto !important;
        left: auto !important;
        right: auto !important;
        bottom: auto !important;
        transform: none !important;
        margin: auto !important;
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
    #createExpenseTypeModal .modal-dialog form,
    #updateExpenseTypeModal .modal-dialog form,
    #expenseTypeDeleteModal .modal-dialog form {
        background: transparent !important;
        padding: 0 !important;
        margin: 0 !important;
        max-height: none !important;
        overflow: visible !important;
    }
    #createExpenseTypeModal .modal-dialog,
    #updateExpenseTypeModal .modal-dialog {
        max-width: 520px !important;
        width: 95% !important;
        margin: auto !important;
        max-height: 90vh !important;
        height: auto !important;
        display: flex !important;
        align-items: center !important;
    }
    #expenseTypeDeleteModal .modal-dialog {
        max-width: 440px !important;
        width: 95% !important;
        margin: auto !important;
        display: flex !important;
        align-items: center !important;
    }
    .modal-header-green {
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%) !important;
        color: #ffffff !important;
        border: none !important;
        padding: 12px 16px !important;
    }

    .qv-close-btn {
        width: 30px !important;
        height: 30px !important;
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

    .custom-modal-label {
        display: block !important;
        font-size: 11.5px !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #475569;
        margin-bottom: 5px !important;
    }
    html.dark .custom-modal-label,
    body.dark .custom-modal-label,
    body[data-layout-mode="dark"] .custom-modal-label { color: #94a3b8 !important; }

    .custom-modal-input {
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
    .custom-modal-input:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.18) !important;
    }
    html.dark .custom-modal-input,
    body.dark .custom-modal-input,
    body[data-layout-mode="dark"] .custom-modal-input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
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
        transition: all 0.15s !important;
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
        transition: all 0.15s !important;
    }
    .cp-btn-primary:hover { background-color: #166534 !important; transform: translateY(-1px); color: #ffffff !important; }

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
    let globalExpenseTypeData = [];
    let currentPage = 1;
    let pageSize = 15;

    $(document).ready(function () {
        $("#entries").val("15");
        $('#createExpenseTypeModal, #updateExpenseTypeModal, #expenseTypeDeleteModal').appendTo('body');
        getExpenseTypeList();
    });

    async function getExpenseTypeList() {
        try {
            showLoader();
            const res = await axios.get("/api/battery/expense-type-list", HeaderToken());
            hideLoader();

            if (res.data.status === "success") {
                globalExpenseTypeData = res.data.ExpenseTypeData || [];
                renderExpenseTypePaginatedList();
            }
        } catch (error) {
            hideLoader();
            console.error("Error fetching Battery Expense Type List:", error);
        }
    }

    $("#searchInput").on("keyup search input", function () {
        currentPage = 1;
        renderExpenseTypePaginatedList();
    });

    $("#entries").on("change", function () {
        pageSize = parseInt($(this).val()) || 15;
        currentPage = 1;
        renderExpenseTypePaginatedList();
    });

    function renderExpenseTypePaginatedList() {
        if (!globalExpenseTypeData) return;

        let searchTerm = $("#searchInput").val().toLowerCase().trim();

        let filtered = globalExpenseTypeData.filter(function (item) {
            let typeName = (item.type_name || "").toLowerCase();
            let status = (item.status || "").toLowerCase();
            return !searchTerm || typeName.includes(searchTerm) || status.includes(searchTerm);
        });

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
            tableList.html('<tr><td colspan="4" class="text-center text-rose-500 p-8 font-semibold"><svg class="w-6 h-6 mx-auto mb-2 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>No expense types found.</td></tr>');
            mobileCardList.html('<div class="p-6 text-center text-rose-500 font-semibold bg-white dark:bg-slate-800 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm">No expense types found.</div>');
        } else {
            pageItems.forEach(function (item, idx) {
                let realIndex = startIndex + idx;
                let isActive = item.status === 'Active';
                let statusBadge = isActive 
                    ? `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-slate-800">Active</span>`
                    : `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-950/40 dark:text-rose-300 dark:border-slate-800">Inactive</span>`;

                // Action Buttons
                let actionHtml = `
                    <div class="flex items-center justify-center gap-1.5">
                        <button onclick="openEditModal(${item.id})" type="button" class="edit-link" title="Edit Expense Type">
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                        </button>
                        <button onclick="openDeleteModal(${item.id})" type="button" class="custom-delete-modal-btn" title="Delete Expense Type">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
                `;

                // Desktop Row
                let row = `
                    <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors border-b border-slate-100 dark:border-slate-800">
                        <td class="p-[10px] text-center font-semibold text-slate-400 dark:text-slate-500">${realIndex + 1}</td>
                        <td class="p-[10px] text-start font-bold text-slate-800 dark:text-slate-100 text-sm">${item.type_name}</td>
                        <td class="p-[10px] text-center">${statusBadge}</td>
                        <td class="p-[10px] text-center">${actionHtml}</td>
                    </tr>`;
                tableList.append(row);

                // Mobile Card View
                let mobileCard = `
                    <div class="unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800/90 shadow-sm transition-all mb-3">
                        <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="badge bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold" style="font-size: 10px;">#${realIndex + 1}</span>
                            ${statusBadge}
                        </div>
                        <h6 class="font-bold text-slate-800 dark:text-slate-100 text-sm mb-2">${item.type_name}</h6>
                        <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                            ${actionHtml}
                        </div>
                    </div>`;
                mobileCardList.append(mobileCard);
            });
        }

        updatePaginationUI(totalItems, startIndex, endIndex, totalPages);
    }

    // ── Create Modal ──
    function openExpenseTypeCreateModal() {
        document.getElementById('ExpenseTypeName').value = '';
        document.getElementById('SelectStatus').value = 'Active';
        const modalEl = document.getElementById('createExpenseTypeModal');
        let modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modalInstance.show();
    }

    function closeExpenseTypeModal() {
        const modalEl = document.getElementById('createExpenseTypeModal');
        let modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    }

    async function SaveExpenseType(event) {
        if (event) event.preventDefault();
        try {
            const name = document.getElementById('ExpenseTypeName').value.trim();
            const status = document.getElementById('SelectStatus').value;

            if (!name) {
                errorToast("Expense Type Name is required!");
                return;
            }

            const payload = { type_name: name, status: status };

            showLoader();
            const res = await axios.post("/api/battery/create-expense-type", payload, HeaderToken());
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message || "Expense Type created successfully!");
                closeExpenseTypeModal();
                await getExpenseTypeList();
            } else {
                errorToast(res.data.message || "Failed to create type");
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            unauthorized(e.response?.status || 500);
        }
    }

    // ── Update Modal ──
    async function openEditModal(id) {
        try {
            showLoader();
            const res = await axios.post("/api/battery/expense-type-by-id", { id: id.toString() }, HeaderToken());
            hideLoader();

            if (res.data.status === "success" && res.data.rows) {
                const row = res.data.rows;
                document.getElementById('updateID').value = row.id;
                document.getElementById('UpdateExpenseTypeName').value = row.type_name;
                document.getElementById('UpdateSelectStatus').value = row.status || 'Active';

                const modalEl = document.getElementById('updateExpenseTypeModal');
                let modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modalInstance.show();
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            unauthorized(e.response?.status || 500);
        }
    }

    async function UpdateExpenseType(event) {
        if (event) event.preventDefault();
        try {
            const updateID = document.getElementById('updateID').value;
            const name = document.getElementById('UpdateExpenseTypeName').value.trim();
            const status = document.getElementById('UpdateSelectStatus').value;

            if (!name) {
                errorToast("Expense Type Name is required!");
                return;
            }

            const payload = { id: updateID, type_name: name, status: status };

            showLoader();
            const res = await axios.post("/api/battery/update-expense-type", payload, HeaderToken());
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message || "Expense Type updated successfully!");
                const modalEl = document.getElementById('updateExpenseTypeModal');
                let modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
                await getExpenseTypeList();
            } else {
                errorToast(res.data.message || "Failed to update type");
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            unauthorized(e.response?.status || 500);
        }
    }

    // ── Delete Modal ──
    function openDeleteModal(id) {
        document.getElementById('deleteID').value = id;
        const modalEl = document.getElementById('expenseTypeDeleteModal');
        let modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modalInstance.show();
    }

    async function itemDelete() {
        try {
            const id = document.getElementById('deleteID').value;
            showLoader();
            const res = await axios.post("/api/battery/delete-expense-type", { id: id }, HeaderToken());
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message || "Expense Type deleted successfully!");
                const modalEl = document.getElementById('expenseTypeDeleteModal');
                let modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
                await getExpenseTypeList();
            } else {
                errorToast(res.data.message || "Failed to delete expense type");
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
        renderExpenseTypePaginatedList();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>
@endsection
