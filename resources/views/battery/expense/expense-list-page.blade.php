@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Expenses - MARSS CORPORATION')
@section('content')

<!-- Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-[calc(100vh-70px)] flex flex-col justify-between">
        <div class="data-table flex-grow">
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-10">
                    
                    <!-- 1. Top Section -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                    <path d="M7 15h0M2 9.5h20"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Battery Operating Expenses</h1>
                                <small class="text-slate-500 dark:text-slate-400 text-xs">Track day-to-day shop overhead, supplies, charging costs, and utilities</small>
                            </div>
                        </div>

                        <!-- Right Controls -->
                        <div class="flex items-center flex-wrap gap-2">
                            <a href="{{ route('battery.expense.types') }}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] min-h-[38px] max-h-[38px] bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-200 text-xs font-semibold rounded-xl border border-slate-300 dark:border-slate-700 transition-all shadow-sm">
                                <i class="fa-solid fa-tags"></i>
                                <span>Expense Types</span>
                            </a>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#expenseCreateModal" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Record Expense</span>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Stat Summary Cards -->
                    <div class="expense-summary-grid mb-4">
                        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40 p-3 sm:p-3.5 transition-colors relative overflow-hidden" style="border-left: 4px solid #16a34a !important;">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-[11px] uppercase font-bold tracking-wider block">Today's Expense</span>
                                    <h4 class="text-emerald-600 dark:text-emerald-400 font-extrabold text-base sm:text-xl my-1" id="statToday">৳ 0.00</h4>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-xs font-medium"><i class="fa-regular fa-calendar-check me-1"></i> Today</span>
                                </div>
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 flex-shrink-0">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40 p-3 sm:p-3.5 transition-colors relative overflow-hidden" style="border-left: 4px solid #0284c7 !important;">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-[11px] uppercase font-bold tracking-wider block">This Month's Expense</span>
                                    <h4 class="text-sky-600 dark:text-sky-400 font-extrabold text-base sm:text-xl my-1" id="statMonth">৳ 0.00</h4>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-xs font-medium"><i class="fa-solid fa-chart-line me-1"></i> Month Total</span>
                                </div>
                                <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 dark:bg-sky-950/40 dark:text-sky-400 flex items-center justify-center border border-sky-100 dark:border-slate-800 flex-shrink-0">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40 p-3 sm:p-3.5 transition-colors relative overflow-hidden" style="border-left: 4px solid #dc2626 !important;">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-[11px] uppercase font-bold tracking-wider block">Total Filtered</span>
                                    <h4 class="text-rose-600 dark:text-rose-400 font-extrabold text-base sm:text-xl my-1" id="statTotal">৳ 0.00</h4>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px] sm:text-xs font-medium"><i class="fa-solid fa-receipt me-1"></i> Grand Total</span>
                                </div>
                                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400 flex items-center justify-center border border-rose-100 dark:border-slate-800 flex-shrink-0">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2"></rect><line x1="8" y1="6" x2="16" y2="6"></line><line x1="16" y1="14" x2="16" y2="18"></line><path d="M16 10h.01M12 10h.01M8 10h.01M12 14h.01M8 14h.01M12 18h.01M8 18h.01"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Controls & Filter Row -->
                    <div class="controls-row-wrapper mb-4 w-full">
                        <div class="search-input-wrapper unified-ui-border h-[38px] flex items-center bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding-left: 4px !important; padding-right: 4px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search expenses by type or details..." />
                        </div>

                        <div class="flex items-center gap-2 flex-wrap">
                            <input type="date" id="startDate" class="unified-ui-border h-[38px] px-3 bg-white dark:bg-slate-800/90 rounded-xl text-xs text-slate-700 dark:text-slate-200">
                            <input type="date" id="endDate" class="unified-ui-border h-[38px] px-3 bg-white dark:bg-slate-800/90 rounded-xl text-xs text-slate-700 dark:text-slate-200">
                            <button type="button" onclick="getBatteryExpenses()" class="h-[38px] px-3.5 bg-emerald-700 hover:bg-emerald-600 text-white rounded-xl text-xs font-semibold shadow-sm">Filter</button>
                            <div class="entries-wrapper unified-ui-border flex items-center gap-1.5 bg-white dark:bg-slate-800/90 px-3 h-[38px] rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 shadow-sm transition-all hover:border-emerald-500">
                                <span class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider whitespace-nowrap">SHOW:</span>
                                <select id="entries" class="bg-transparent border-0 text-xs sm:text-sm font-bold text-emerald-700 dark:text-emerald-400 focus:outline-none cursor-pointer py-1 pr-1 text-end">
                                    <option value="15" selected>15</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Desktop Table -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900 mb-4">
                        <table class="w-full text-left border-collapse" id="expenseTable">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">#</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Date</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Expense Category</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Details / Purpose</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Amount (৳)</th>
                                    <th class="p-[10px] text-center w-[100px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="expenseTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                                <tr>
                                    <td colspan="6" class="text-center py-6 text-slate-400">Loading battery expenses...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- 5. Mobile Card Container -->
                    <div id="mobileCardList" class="block md:hidden mb-3 space-y-3"></div>

                    <!-- 6. Modern Pagination & Info Footer -->
                    <div class="flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-800 gap-3">
                        <div id="display-info" class="text-xs text-slate-500 dark:text-slate-400"></div>
                        <div id="pagination" class="flex items-center gap-1 sm:gap-1.5 flex-nowrap justify-center max-w-full overflow-x-auto pb-1"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="expenseCreateModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 520px;">
        <div class="modal-content rounded-2xl border-0 shadow-lg overflow-hidden bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100">
            <div class="modal-header px-4 py-3 border-0" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; color: #ffffff !important;">
                <h5 class="modal-title font-bold text-base flex items-center gap-2 text-white m-0">
                    <i class="fa-solid fa-plus-circle text-white"></i> Record Battery Expense
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createExpenseForm" onsubmit="saveBatteryExpense(event)">
                <div class="modal-body p-4 space-y-3">
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Expense Category <span class="text-red-500">*</span></label>
                        <select id="createExpenseCategory" required class="form-select rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                            <option value="">Select Expense Type</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Expense Date <span class="text-red-500">*</span></label>
                        <input type="date" id="createExpenseDate" value="{{ date('Y-m-d') }}" required class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Amount (৳) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" id="createExpenseAmount" required min="1" placeholder="0.00" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white font-bold h-[42px]">
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Details / Note</label>
                        <textarea id="createExpenseDetails" rows="2" placeholder="Description of the expense" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-t border-slate-200 dark:border-slate-800 px-4 py-3 flex justify-end gap-2">
                    <button type="button" class="btn px-4 text-white font-semibold" style="background-color: #dc2626 !important; border-radius: 8px !important; height: 38px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4 text-white font-semibold" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; border-radius: 8px !important; height: 38px;">Save Expense</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="expenseUpdateModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 520px;">
        <div class="modal-content rounded-2xl border-0 shadow-lg overflow-hidden bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100">
            <div class="modal-header px-4 py-3 border-0" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; color: #ffffff !important;">
                <h5 class="modal-title font-bold text-base flex items-center gap-2 text-white m-0">
                    <i class="fa-solid fa-pen-to-square text-white"></i> Edit Battery Expense
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateExpenseForm" onsubmit="updateBatteryExpense(event)">
                <input type="hidden" id="updateExpenseId">
                <div class="modal-body p-4 space-y-3">
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Expense Category <span class="text-red-500">*</span></label>
                        <select id="updateExpenseCategory" required class="form-select rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                            <option value="">Select Expense Type</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Expense Date <span class="text-red-500">*</span></label>
                        <input type="date" id="updateExpenseDate" required class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Amount (৳) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" id="updateExpenseAmount" required min="1" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white font-bold h-[42px]">
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Details / Note</label>
                        <textarea id="updateExpenseDetails" rows="2" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-t border-slate-200 dark:border-slate-800 px-4 py-3 flex justify-end gap-2">
                    <button type="button" class="btn px-4 text-white font-semibold" style="background-color: #dc2626 !important; border-radius: 8px !important; height: 38px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4 text-white font-semibold" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; border-radius: 8px !important; height: 38px;">Update Expense</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="expenseDeleteModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content rounded-2xl border-0 shadow-lg text-center p-4 bg-white dark:bg-slate-900">
            <input type="hidden" id="deleteExpenseId">
            <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-triangle-exclamation text-2xl" style="color: #dc2626;"></i>
            </div>
            <h5 class="font-bold text-slate-800 dark:text-white mb-1">Delete Expense?</h5>
            <p class="text-xs text-slate-500 mb-4">This record will be permanently deleted. This action cannot be undone.</p>
            <div class="flex justify-center gap-2">
                <button type="button" class="btn px-4 rounded-xl text-sm font-semibold border border-slate-300 text-slate-700 hover:bg-slate-100" data-bs-dismiss="modal">Cancel</button>
                <button type="button" onclick="confirmDeleteBatteryExpense()" class="btn px-4 text-white rounded-xl text-sm font-semibold" style="background-color: #dc2626 !important; border: none !important;">Delete</button>
            </div>
        </div>
    </div>
</div>

<style>
    .unified-ui-border {
        border: 1px solid #cbd5e1 !important;
    }
    .dark .unified-ui-border {
        border: 1px solid #334155 !important;
    }
    .expense-summary-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
    @media (min-width: 640px) {
        .expense-summary-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    .action-btn {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.15s ease;
    }
    .action-btn-edit {
        background-color: #ecfdf5;
        color: #047857;
    }
    .action-btn-edit:hover {
        background-color: #d1fae5;
        color: #065f46;
    }
    .action-btn-delete {
        background-color: #fff1f2;
        color: #e11d48;
    }
    .action-btn-delete:hover {
        background-color: #ffe4e6;
        color: #be123c;
    }
    .controls-row-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    @media (min-width: 768px) {
        .controls-row-wrapper {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }
    .search-input-wrapper {
        width: 100%;
        max-width: 360px;
        padding: 0 12px;
    }
</style>

<script>
    let rawExpenses = [];
    let expenseTypesList = [];
    let currentPage = 1;
    let pageSize = 15;

    document.addEventListener("DOMContentLoaded", function() {
        loadExpenseTypes();
        getBatteryExpenses();

        $('#searchInput').on('input', function() { currentPage = 1; renderExpenses(); });
        $('#entries').on('change', function() { pageSize = parseInt(this.value) || 15; currentPage = 1; renderExpenses(); });
    });

    async function loadExpenseTypes() {
        try {
            const res = await axios.get('/api/battery/expense-type-list', HeaderToken());
            if (res.data && res.data.status === 'success') {
                expenseTypesList = res.data.ExpenseTypeData || [];
                let opts = '<option value="">Select Expense Type</option>';
                expenseTypesList.forEach(t => { opts += `<option value="${t.id}">${t.name}</option>`; });
                $('#createExpenseCategory').html(opts);
                $('#updateExpenseCategory').html(opts);
            }
        } catch (e) {
            console.error(e);
        }
    }

    async function getBatteryExpenses() {
        try {
            const start = $('#startDate').val();
            const end = $('#endDate').val();
            let url = "/api/battery/expense-list";
            if (start && end) url += `?start_date=${start}&end_date=${end}`;

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.get(url, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                rawExpenses = res.data.ExpenseData || [];
                $('#statToday').text('৳ ' + parseFloat(res.data.todayExpense || 0).toLocaleString());
                $('#statMonth').text('৳ ' + parseFloat(res.data.thisMonthExpense || 0).toLocaleString());
                $('#statTotal').text('৳ ' + parseFloat(res.data.subTotal || 0).toLocaleString());
                renderExpenses();
            } else {
                rawExpenses = [];
                renderExpenses();
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            errorToast("Failed to load battery expenses");
        }
    }

    function renderExpenses() {
        const search = ($('#searchInput').val() || '').toLowerCase().trim();
        const filtered = rawExpenses.filter(e => {
            const type = (e.type_name || e.expense_type?.name || '').toLowerCase();
            const details = (e.expense_details || '').toLowerCase();
            return type.includes(search) || details.includes(search);
        });

        const total = filtered.length;
        const totalPages = Math.ceil(total / pageSize) || 1;
        if (currentPage > totalPages) currentPage = 1;

        const start = (currentPage - 1) * pageSize;
        const pageItems = filtered.slice(start, start + pageSize);

        const tbody = document.getElementById('expenseTableBody');
        const mobileContainer = document.getElementById('mobileCardList');
        tbody.innerHTML = '';
        mobileContainer.innerHTML = '';

        if (pageItems.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center py-8 text-slate-400">No battery expenses found.</td></tr>`;
            mobileContainer.innerHTML = `<div class="p-6 text-center text-slate-400 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">No battery expenses found.</div>`;
        } else {
            pageItems.forEach((e, idx) => {
                const sl = start + idx + 1;
                const typeName = e.type_name || (e.expense_type ? e.expense_type.name : '—');

                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="p-[10px] text-center text-slate-400 font-medium">${sl}</td>
                        <td class="p-[10px] font-mono text-xs text-slate-600 dark:text-slate-300">${e.date}</td>
                        <td class="p-[10px] font-semibold text-slate-800 dark:text-slate-100">${typeName}</td>
                        <td class="p-[10px] text-slate-500 text-xs">${e.expense_details || '—'}</td>
                        <td class="p-[10px] text-end font-bold text-amber-600 dark:text-amber-400">৳ ${parseFloat(e.expense_amount || 0).toLocaleString()}</td>
                        <td class="p-[10px] text-center">
                            <div class="inline-flex items-center gap-1.5">
                                <button onclick="openEditExpenseModal(${e.id})" class="action-btn action-btn-edit" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button onclick="openDeleteExpenseModal(${e.id})" class="action-btn action-btn-delete" title="Delete">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;

                mobileContainer.innerHTML += `
                    <div class="p-4 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-mono text-slate-400">#${sl} | ${e.date}</span>
                            <span class="font-bold text-amber-600">৳ ${parseFloat(e.expense_amount || 0).toLocaleString()}</span>
                        </div>
                        <div class="font-bold text-slate-800 dark:text-white">${typeName}</div>
                        ${e.expense_details ? `<div class="text-xs text-slate-500">${e.expense_details}</div>` : ''}
                        <div class="pt-2 flex justify-end gap-2 border-t border-slate-100 dark:border-slate-800">
                            <button onclick="openEditExpenseModal(${e.id})" class="action-btn action-btn-edit" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button onclick="openDeleteExpenseModal(${e.id})" class="action-btn action-btn-delete" title="Delete">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
        }

        document.getElementById('display-info').innerHTML = total > 0
            ? `Showing <strong>${start + 1}–${Math.min(start + pageSize, total)}</strong> of <strong>${total}</strong> expenses`
            : `0 expenses found`;

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        const p = document.getElementById('pagination');
        p.innerHTML = '';
        if (totalPages <= 1) return;

        const btnClass = "h-8 min-w-[32px] px-2 rounded-lg text-xs font-semibold border flex items-center justify-center ";
        p.innerHTML += `<button onclick="goPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''} class="${btnClass} ${currentPage === 1 ? 'opacity-40 cursor-not-allowed border-slate-200 text-slate-400' : 'border-slate-200 dark:border-slate-700 hover:bg-slate-100'}">‹</button>`;
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                p.innerHTML += `<button onclick="goPage(${i})" class="${btnClass} ${i === currentPage ? 'bg-emerald-700 text-white border-emerald-700' : 'border-slate-200 dark:border-slate-700 hover:bg-slate-100'}">${i}</button>`;
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                p.innerHTML += `<span class="px-1 text-slate-400">…</span>`;
            }
        }
        p.innerHTML += `<button onclick="goPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''} class="${btnClass} ${currentPage === totalPages ? 'opacity-40 cursor-not-allowed border-slate-200 text-slate-400' : 'border-slate-200 dark:border-slate-700 hover:bg-slate-100'}">›</button>`;
    }

    function goPage(page) { currentPage = page; renderExpenses(); }

    async function saveBatteryExpense(e) {
        e.preventDefault();
        try {
            const expense_type_id = $('#createExpenseCategory').val();
            const date = $('#createExpenseDate').val();
            const expense_amount = $('#createExpenseAmount').val();
            const expense_details = $('#createExpenseDetails').val();

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/create-expense', {
                expense_type_id, date, expense_amount, expense_details
            }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Expense recorded');
                $('#expenseCreateModal').modal('hide');
                $('#createExpenseForm')[0].reset();
                getBatteryExpenses();
            } else {
                errorToast(res.data.message || 'Failed to record expense');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            errorToast(err.response?.data?.message || 'Error saving expense');
        }
    }

    async function openEditExpenseModal(id) {
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/expense-by-id', { id }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success' && res.data.data) {
                const e = res.data.data;
                $('#updateExpenseId').val(e.id);
                $('#updateExpenseCategory').val(e.expense_type_id);
                $('#updateExpenseDate').val(e.date);
                $('#updateExpenseAmount').val(e.expense_amount);
                $('#updateExpenseDetails').val(e.expense_details || '');
                $('#expenseUpdateModal').modal('show');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            errorToast('Failed to load expense details');
        }
    }

    async function updateBatteryExpense(e) {
        e.preventDefault();
        try {
            const id = $('#updateExpenseId').val();
            const expense_type_id = $('#updateExpenseCategory').val();
            const date = $('#updateExpenseDate').val();
            const expense_amount = $('#updateExpenseAmount').val();
            const expense_details = $('#updateExpenseDetails').val();

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/update-expense', {
                id, expense_type_id, date, expense_amount, expense_details
            }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Expense updated');
                $('#expenseUpdateModal').modal('hide');
                getBatteryExpenses();
            } else {
                errorToast(res.data.message || 'Failed to update expense');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            errorToast(err.response?.data?.message || 'Error updating expense');
        }
    }

    function openDeleteExpenseModal(id) {
        $('#deleteExpenseId').val(id);
        $('#expenseDeleteModal').modal('show');
    }

    async function confirmDeleteBatteryExpense() {
        try {
            const id = $('#deleteExpenseId').val();
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/delete-expense', { id }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Expense deleted');
                $('#expenseDeleteModal').modal('hide');
                getBatteryExpenses();
            } else {
                errorToast(res.data.message || 'Failed to delete expense');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            errorToast(err.response?.data?.message || 'Error deleting expense');
        }
    }
</script>

@endsection
