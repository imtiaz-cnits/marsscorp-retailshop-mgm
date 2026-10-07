@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Supplier Due - MARSS CORPORATION')
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
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Supplier Due List</h1>
                                <small class="text-slate-500 dark:text-slate-400 text-xs">Outstanding payables to battery suppliers & manufacturers</small>
                            </div>
                        </div>

                        <!-- Right Controls -->
                        <div class="flex items-center flex-wrap gap-2">
                            <a href="{{ route('battery.supplier.due.collection') }}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                <span>Payment History</span>
                            </a>
                        </div>
                    </div>

                    <!-- 2. Controls & Search Row -->
                    <div class="controls-row-wrapper mb-4 w-full">
                        <div class="search-input-wrapper unified-ui-border h-[38px] flex items-center bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding-left: 4px !important; padding-right: 4px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search suppliers with due balance..." />
                        </div>
                    </div>

                    <!-- 3. Desktop Table -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900 mb-4">
                        <table class="w-full text-left border-collapse" id="supplierDueTable">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">#</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Supplier ID</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Supplier Name</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Previous Due</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Purchase Due</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Total Outstanding</th>
                                    <th class="p-[10px] text-center w-[120px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="supplierDueTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                                <tr>
                                    <td colspan="7" class="text-center py-6 text-slate-400">Loading supplier dues...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- 4. Mobile Card Container -->
                    <div id="mobileCardList" class="block md:hidden mb-3 space-y-3"></div>

                    <!-- 5. Summary & Info -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-4 pt-3 border-t border-slate-200 dark:border-slate-800">
                        <div id="display-info" class="text-xs text-slate-500 dark:text-slate-400"></div>
                        <div id="totalDueSummary" class="text-sm font-bold text-rose-600 dark:text-rose-400"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pay Supplier Due Modal -->
<div class="modal fade" id="paySupplierDueModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 520px;">
        <div class="modal-content rounded-2xl border-0 shadow-lg overflow-hidden bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100">
            <div class="modal-header px-4 py-3 border-0" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; color: #ffffff !important;">
                <h5 class="modal-title font-bold text-base flex items-center gap-2 text-white m-0">
                    <i class="fa-solid fa-money-bill-transfer text-white"></i> Record Supplier Due Payment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="payDueForm" onsubmit="submitSupplierPayment(event)">
                <input type="hidden" id="paySupplierId">
                <div class="modal-body p-4 space-y-3">
                    <div class="p-3 bg-emerald-50/60 dark:bg-slate-800/60 rounded-xl border border-emerald-100 dark:border-slate-700">
                        <div class="text-xs text-slate-500 dark:text-slate-400">Supplier:</div>
                        <div class="font-bold text-sm text-slate-800 dark:text-white" id="paySupplierName">—</div>
                        <div class="text-xs text-rose-600 font-semibold mt-1">Total Due: ৳ <span id="paySupplierTotalDue">0.00</span></div>
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Paid Amount (৳) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" id="payAmount" required min="1" placeholder="0.00" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white font-bold h-[42px]">
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Discount Amount (৳)</label>
                        <input type="number" step="0.01" id="payDiscount" value="0" placeholder="0.00" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Payment Method</label>
                        <select id="payMethod" class="form-select rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                            <option value="Cash">Cash</option>
                            <option value="Bank">Bank Transfer</option>
                            <option value="bKash">bKash</option>
                            <option value="Nagad">Nagad</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Payment Date</label>
                        <input type="date" id="payDate" value="{{ date('Y-m-d') }}" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Note / Trx ID</label>
                        <input type="text" id="payNote" placeholder="e.g. Trx ID or Cheque No" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                    </div>
                </div>
                <div class="modal-footer border-t border-slate-200 dark:border-slate-800 px-4 py-3 flex justify-end gap-2">
                    <button type="button" class="btn px-4 text-white font-semibold" style="background-color: #dc2626 !important; border-radius: 8px !important; height: 38px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4 text-white font-semibold" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; border-radius: 8px !important; height: 38px;">Record Payment</button>
                </div>
            </form>
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
    .controls-row-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    @media (min-width: 640px) {
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
    let rawDueList = [];

    document.addEventListener("DOMContentLoaded", function() {
        getBatterySupplierDueList();
        $('#searchInput').on('input', renderDueList);
    });

    async function getBatterySupplierDueList() {
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.get("/api/battery/supplier-due-list", HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                rawDueList = res.data.SupplierData || [];
                renderDueList();
            } else {
                rawDueList = [];
                renderDueList();
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            errorToast("Failed to load supplier due list");
        }
    }

    function renderDueList() {
        const search = ($('#searchInput').val() || '').toLowerCase().trim();
        const filtered = rawDueList.filter(s => (s.name || '').toLowerCase().includes(search) || (s.supplier_id || '').toLowerCase().includes(search));

        const tbody = document.getElementById('supplierDueTableBody');
        const mobileContainer = document.getElementById('mobileCardList');
        tbody.innerHTML = '';
        mobileContainer.innerHTML = '';

        let grandDue = 0;

        if (filtered.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center py-8 text-emerald-600 font-semibold"><i class="fa-solid fa-circle-check me-1"></i> No outstanding supplier dues!</td></tr>`;
            mobileContainer.innerHTML = `<div class="p-6 text-center text-emerald-600 font-semibold bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800"><i class="fa-solid fa-circle-check me-1"></i> No outstanding supplier dues!</div>`;
        } else {
            filtered.forEach((s, idx) => {
                const prev = parseFloat(s.purchase_payable_amount || 0);
                const cur = parseFloat(s.total_due_amount || 0);
                const total = prev + cur;
                grandDue += total;

                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="p-[10px] text-center text-slate-400 font-medium">${idx + 1}</td>
                        <td class="p-[10px] font-mono text-xs text-slate-500">${s.supplier_id || '—'}</td>
                        <td class="p-[10px] font-semibold text-slate-800 dark:text-slate-100">${s.name}</td>
                        <td class="p-[10px] text-end text-slate-600 dark:text-slate-300">৳ ${prev.toLocaleString()}</td>
                        <td class="p-[10px] text-end text-slate-600 dark:text-slate-300">৳ ${cur.toLocaleString()}</td>
                        <td class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400">৳ ${total.toLocaleString()}</td>
                        <td class="p-[10px] text-center">
                            <button onclick="openPayDueModal(${s.id}, '${escapeHtml(s.name)}', ${total})" class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-700 hover:bg-emerald-600 text-white rounded-lg text-xs font-semibold shadow-sm transition-all">
                                <i class="fa-solid fa-hand-holding-dollar"></i> Pay Due
                            </button>
                        </td>
                    </tr>
                `;

                mobileContainer.innerHTML += `
                    <div class="p-4 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-mono text-slate-400">#${idx + 1} | ${s.supplier_id || ''}</span>
                            <span class="text-xs font-bold text-rose-600">Total: ৳ ${total.toLocaleString()}</span>
                        </div>
                        <div class="font-bold text-slate-800 dark:text-white">${s.name}</div>
                        <div class="grid grid-cols-2 text-xs text-slate-600 dark:text-slate-400 pt-1 border-t border-slate-100 dark:border-slate-800">
                            <div>Prev Due: ৳ ${prev.toLocaleString()}</div>
                            <div class="text-end">Cur Due: ৳ ${cur.toLocaleString()}</div>
                        </div>
                        <div class="pt-2 flex justify-end">
                            <button onclick="openPayDueModal(${s.id}, '${escapeHtml(s.name)}', ${total})" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-emerald-700 hover:bg-emerald-600 text-white rounded-xl text-xs font-semibold shadow-sm">
                                <i class="fa-solid fa-hand-holding-dollar"></i> Pay Due
                            </button>
                        </div>
                    </div>
                `;
            });
        }

        document.getElementById('display-info').innerText = `Total Suppliers with Due: ${filtered.length}`;
        document.getElementById('totalDueSummary').innerText = `Total Payable: ৳ ${grandDue.toLocaleString()}`;
    }

    function escapeHtml(text) {
        return text ? text.replace(/'/g, "\\'") : '';
    }

    function openPayDueModal(id, name, totalDue) {
        $('#paySupplierId').val(id);
        $('#paySupplierName').text(name);
        $('#paySupplierTotalDue').text(parseFloat(totalDue).toLocaleString());
        $('#payAmount').val(totalDue);
        $('#payDiscount').val(0);
        $('#paySupplierDueModal').modal('show');
    }

    async function submitSupplierPayment(e) {
        e.preventDefault();
        try {
            const supplier_id = $('#paySupplierId').val();
            const paid_amount = $('#payAmount').val();
            const discount_amount = $('#payDiscount').val() || 0;
            const payment_method = $('#payMethod').val();
            const due_collection_date = $('#payDate').val();
            const transaction_id = $('#payNote').val();

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/supplier-payment-details-update', {
                supplier_id, paid_amount, discount_amount, payment_method, due_collection_date, transaction_id
            }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Payment recorded successfully');
                $('#paySupplierDueModal').modal('hide');
                getBatterySupplierDueList();
            } else {
                errorToast(res.data.message || 'Payment update failed');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            errorToast(err.response?.data?.message || 'Error processing payment');
        }
    }
</script>

@endsection
