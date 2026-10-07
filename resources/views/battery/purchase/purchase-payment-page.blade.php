@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Purchase Payments - MARSS CORPORATION')
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
                                    <line x1="2" y1="10" x2="22" y2="10"></line>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Purchase Payment Management</h1>
                                <small class="text-slate-500 dark:text-slate-400 text-xs">Record payments against specific battery purchase orders</small>
                            </div>
                        </div>

                        <!-- Right Controls -->
                        <div class="flex items-center flex-wrap gap-2">
                            <a href="{{ route('battery.purchases') }}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] min-h-[38px] max-h-[38px] bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-200 text-xs font-semibold rounded-xl border border-slate-300 dark:border-slate-700 transition-all shadow-sm">
                                <i class="fa-solid fa-arrow-left"></i>
                                <span>Back to Purchases</span>
                            </a>
                        </div>
                    </div>

                    <!-- 2. Controls & Filter Row -->
                    <div class="controls-row-wrapper mb-4 w-full">
                        <div class="search-input-wrapper unified-ui-border h-[38px] flex items-center bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding-left: 4px !important; padding-right: 4px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search by Purchase ID or Supplier..." />
                        </div>

                        <div class="entries-wrapper unified-ui-border flex items-center gap-1.5 bg-white dark:bg-slate-800/90 px-3 h-[38px] rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 shadow-sm transition-all hover:border-emerald-500">
                            <span class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider whitespace-nowrap">SHOW:</span>
                            <select id="entries" class="bg-transparent border-0 text-xs sm:text-sm font-bold text-emerald-700 dark:text-emerald-400 focus:outline-none cursor-pointer py-1 pr-1 text-end">
                                <option value="15" selected>15</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>

                    <!-- 3. Desktop Table -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900 mb-4">
                        <table class="w-full text-left border-collapse" id="paymentTable">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">#</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Purchase ID</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Date</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Supplier</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Total Amount</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Paid Amount</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Due Amount</th>
                                    <th class="p-[10px] text-center w-[120px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="paymentTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                                <tr>
                                    <td colspan="8" class="text-center py-6 text-slate-400">Loading purchase payments...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- 4. Mobile Card Container -->
                    <div id="mobileCardList" class="block md:hidden mb-3 space-y-3"></div>

                    <!-- 5. Modern Pagination & Info Footer -->
                    <div class="flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-800 gap-3">
                        <div id="display-info" class="text-xs text-slate-500 dark:text-slate-400"></div>
                        <div id="pagination" class="flex items-center gap-1 sm:gap-1.5 flex-nowrap justify-center max-w-full overflow-x-auto pb-1"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pay Purchase Modal -->
<div class="modal fade" id="payPurchaseModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 520px;">
        <div class="modal-content rounded-2xl border-0 shadow-lg overflow-hidden bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100">
            <div class="modal-header px-4 py-3 border-0" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; color: #ffffff !important;">
                <h5 class="modal-title font-bold text-base flex items-center gap-2 text-white m-0">
                    <i class="fa-solid fa-credit-card text-white"></i> Add Purchase Payment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="payPurchaseForm" onsubmit="submitPurchasePayment(event)">
                <input type="hidden" id="payPurchaseId">
                <div class="modal-body p-4 space-y-3">
                    <div class="p-3 bg-emerald-50/60 dark:bg-slate-800/60 rounded-xl border border-emerald-100 dark:border-slate-700 text-xs space-y-1">
                        <div>Purchase ID: <strong id="modalPurchaseId" class="text-emerald-700 font-mono"></strong></div>
                        <div>Supplier: <strong id="modalSupplierName" class="text-slate-800 dark:text-white"></strong></div>
                        <div class="text-rose-600 font-bold">Outstanding Due: ৳ <span id="modalDueAmount">0.00</span></div>
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Paid Amount (৳) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" id="modalPaidAmount" required min="1" placeholder="0.00" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white font-bold h-[42px]">
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Payment Method</label>
                        <select id="modalPayMethod" class="form-select rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                            <option value="Cash">Cash</option>
                            <option value="Bank">Bank Transfer</option>
                            <option value="bKash">bKash</option>
                            <option value="Nagad">Nagad</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Trx ID / Note</label>
                        <input type="text" id="modalPayNote" placeholder="Payment reference or note" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                    </div>

                    <!-- Payment History for this purchase -->
                    <div class="pt-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 block mb-1">Previous Payments:</span>
                        <div id="modalPaymentHistory" class="space-y-1 text-xs text-slate-600 dark:text-slate-300 max-h-[140px] overflow-y-auto"></div>
                    </div>
                </div>
                <div class="modal-footer border-t border-slate-200 dark:border-slate-800 px-4 py-3 flex justify-end gap-2">
                    <button type="button" class="btn px-4 text-white font-semibold" style="background-color: #dc2626 !important; border-radius: 8px !important; height: 38px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4 text-white font-semibold" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; border-radius: 8px !important; height: 38px;">Save Payment</button>
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
    let rawPurchases = [];
    let currentPage = 1;
    let pageSize = 15;

    document.addEventListener("DOMContentLoaded", function() {
        getPurchasePayments();
        $('#searchInput').on('input', function() { currentPage = 1; renderPayments(); });
        $('#entries').on('change', function() { pageSize = parseInt(this.value) || 15; currentPage = 1; renderPayments(); });
    });

    async function getPurchasePayments() {
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.get("/api/battery/purchases-list", HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                rawPurchases = res.data.PurchasessData || [];
                renderPayments();
            } else {
                rawPurchases = [];
                renderPayments();
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            errorToast("Failed to load purchase payments");
        }
    }

    function renderPayments() {
        const search = ($('#searchInput').val() || '').toLowerCase().trim();
        const filtered = rawPurchases.filter(p => {
            const idMatch = (p.purchase_id || '').toLowerCase().includes(search);
            const supMatch = (p.supplier || '').toLowerCase().includes(search);
            return idMatch || supMatch;
        });

        const total = filtered.length;
        const totalPages = Math.ceil(total / pageSize) || 1;
        if (currentPage > totalPages) currentPage = 1;

        const start = (currentPage - 1) * pageSize;
        const pageItems = filtered.slice(start, start + pageSize);

        const tbody = document.getElementById('paymentTableBody');
        const mobileContainer = document.getElementById('mobileCardList');
        tbody.innerHTML = '';
        mobileContainer.innerHTML = '';

        if (pageItems.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center py-8 text-slate-400">No purchases found.</td></tr>`;
            mobileContainer.innerHTML = `<div class="p-6 text-center text-slate-400 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">No purchases found.</div>`;
        } else {
            pageItems.forEach((p, idx) => {
                const sl = start + idx + 1;
                const due = parseFloat(p.due_amount || 0);

                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="p-[10px] text-center text-slate-400 font-medium">${sl}</td>
                        <td class="p-[10px] font-mono text-xs font-bold text-emerald-700 dark:text-emerald-400">${p.purchase_id}</td>
                        <td class="p-[10px] text-xs text-slate-600 dark:text-slate-300">${p.date}</td>
                        <td class="p-[10px] font-semibold text-slate-800 dark:text-slate-100">${p.supplier}</td>
                        <td class="p-[10px] text-end font-semibold text-slate-800 dark:text-slate-100">৳ ${parseFloat(p.grand_subtotal || 0).toLocaleString()}</td>
                        <td class="p-[10px] text-end text-emerald-600 dark:text-emerald-400 font-semibold">৳ ${parseFloat(p.paid_amount || 0).toLocaleString()}</td>
                        <td class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400">৳ ${due.toLocaleString()}</td>
                        <td class="p-[10px] text-center">
                            ${due > 0 ? `
                                <button onclick="openPaymentModal(${p.id}, '${p.purchase_id}', '${escapeHtml(p.supplier)}', ${due})" class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-700 hover:bg-emerald-600 text-white rounded-lg text-xs font-semibold shadow-sm transition-all">
                                    <i class="fa-solid fa-plus"></i> Pay Due
                                </button>
                            ` : `<span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Settled</span>`}
                        </td>
                    </tr>
                `;

                mobileContainer.innerHTML += `
                    <div class="p-4 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-xs font-bold text-emerald-700">${p.purchase_id}</span>
                            <span class="text-xs font-bold text-rose-600">Due: ৳ ${due.toLocaleString()}</span>
                        </div>
                        <div class="font-bold text-slate-800 dark:text-white">${p.supplier}</div>
                        <div class="flex items-center justify-between text-xs text-slate-500 pt-1 border-t border-slate-100 dark:border-slate-800">
                            <span>Total: ৳ ${parseFloat(p.grand_subtotal || 0).toLocaleString()}</span>
                            <span>Paid: ৳ ${parseFloat(p.paid_amount || 0).toLocaleString()}</span>
                        </div>
                        <div class="pt-2 flex justify-end">
                            ${due > 0 ? `
                                <button onclick="openPaymentModal(${p.id}, '${p.purchase_id}', '${escapeHtml(p.supplier)}', ${due})" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-emerald-700 hover:bg-emerald-600 text-white rounded-xl text-xs font-semibold shadow-sm">
                                    <i class="fa-solid fa-plus"></i> Pay Due
                                </button>
                            ` : `<span class="text-xs font-semibold text-emerald-600">Fully Settled</span>`}
                        </div>
                    </div>
                `;
            });
        }

        document.getElementById('display-info').innerHTML = total > 0
            ? `Showing <strong>${start + 1}–${Math.min(start + pageSize, total)}</strong> of <strong>${total}</strong> records`
            : `0 records found`;

        renderPagination(totalPages);
    }

    function escapeHtml(text) {
        return text ? text.replace(/'/g, "\\'") : '';
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

    function goPage(page) { currentPage = page; renderPayments(); }

    async function openPaymentModal(id, purchaseId, supplier, due) {
        $('#payPurchaseId').val(id);
        $('#modalPurchaseId').text(purchaseId);
        $('#modalSupplierName').text(supplier);
        $('#modalDueAmount').text(due.toLocaleString());
        $('#modalPaidAmount').val(due);

        // Fetch existing payment details
        try {
            const res = await axios.post('/api/battery/purchase-payment-details-by-id', { id }, HeaderToken());
            if (res.data && res.data.status === 'success') {
                const history = res.data.paymentDetails || [];
                const histDiv = document.getElementById('modalPaymentHistory');
                if (history.length === 0) {
                    histDiv.innerHTML = '<span class="text-slate-400">No previous payment records.</span>';
                } else {
                    let hHtml = '';
                    history.forEach(h => {
                        hHtml += `<div class="p-1.5 rounded bg-slate-100 dark:bg-slate-800 flex justify-between"><span>${h.purchase_due_collection_date || h.created_at?.substring(0, 10)} (${h.payment_method || 'Cash'})</span><span class="font-bold text-emerald-600">৳ ${parseFloat(h.paid_amount || 0).toLocaleString()}</span></div>`;
                    });
                    histDiv.innerHTML = hHtml;
                }
            }
        } catch (e) {
            console.error(e);
        }

        $('#payPurchaseModal').modal('show');
    }

    async function submitPurchasePayment(e) {
        e.preventDefault();
        try {
            const id = $('#payPurchaseId').val();
            const paid_amount = $('#modalPaidAmount').val();
            const payment_method = $('#modalPayMethod').val();
            const transaction_id = $('#modalPayNote').val();

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/update-purchase-payment', {
                id, paid_amount, payment_method, transaction_id
            }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Payment recorded');
                $('#payPurchaseModal').modal('hide');
                getPurchasePayments();
            } else {
                errorToast(res.data.message || 'Payment failed');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            errorToast(err.response?.data?.message || 'Error saving payment');
        }
    }
</script>

@endsection
