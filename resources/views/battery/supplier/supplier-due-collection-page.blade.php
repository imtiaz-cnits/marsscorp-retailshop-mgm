@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Supplier Due Collection History - MARSS CORPORATION')
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
                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Supplier Due Payment History</h1>
                                <small class="text-slate-500 dark:text-slate-400 text-xs">Record of payments disbursed towards supplier due settlements</small>
                            </div>
                        </div>

                        <!-- Right Controls -->
                        <div class="flex items-center flex-wrap gap-2">
                            <a href="{{ route('battery.supplier.due') }}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] min-h-[38px] max-h-[38px] bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-200 text-xs font-semibold rounded-xl border border-slate-300 dark:border-slate-700 transition-all shadow-sm">
                                <i class="fa-solid fa-arrow-left"></i>
                                <span>Back to Dues</span>
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
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding-left: 4px !important; padding-right: 4px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search payment records by supplier or payment method..." />
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
                        <table class="w-full text-left border-collapse" id="paymentHistoryTable">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">#</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Payment Date</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Supplier Name</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Paid Amount</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Discount</th>
                                    <th class="p-[10px] text-center whitespace-nowrap">Payment Method</th>
                                    <th class="p-[10px] text-start rounded-tr-2xl whitespace-nowrap">Reference / Note</th>
                                </tr>
                            </thead>
                            <tbody id="paymentHistoryTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                                <tr>
                                    <td colspan="7" class="text-center py-6 text-slate-400">Loading payment history...</td>
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
    let rawPayments = [];
    let currentPage = 1;
    let pageSize = 15;

    document.addEventListener("DOMContentLoaded", function() {
        getPaymentHistory();
        $('#searchInput').on('input', function() { currentPage = 1; renderPayments(); });
        $('#entries').on('change', function() { pageSize = parseInt(this.value) || 15; currentPage = 1; renderPayments(); });
    });

    async function getPaymentHistory() {
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.get("/api/battery/supplier-due-collection-list", HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                rawPayments = res.data.SupplierDueCollectionData || [];
                renderPayments();
            } else {
                rawPayments = [];
                renderPayments();
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            errorToast("Failed to load supplier payment history");
        }
    }

    function renderPayments() {
        const search = ($('#searchInput').val() || '').toLowerCase().trim();
        const filtered = rawPayments.filter(p => {
            const sName = p.supplier ? (p.supplier.name || '') : '';
            const method = p.payment_method || '';
            const note = p.transaction_id || '';
            return sName.toLowerCase().includes(search) || method.toLowerCase().includes(search) || note.toLowerCase().includes(search);
        });

        const total = filtered.length;
        const totalPages = Math.ceil(total / pageSize) || 1;
        if (currentPage > totalPages) currentPage = 1;

        const start = (currentPage - 1) * pageSize;
        const pageItems = filtered.slice(start, start + pageSize);

        const tbody = document.getElementById('paymentHistoryTableBody');
        const mobileContainer = document.getElementById('mobileCardList');
        tbody.innerHTML = '';
        mobileContainer.innerHTML = '';

        if (pageItems.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center py-8 text-slate-400">No payment history records found.</td></tr>`;
            mobileContainer.innerHTML = `<div class="p-6 text-center text-slate-400 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">No payment history records found.</div>`;
        } else {
            pageItems.forEach((p, idx) => {
                const sl = start + idx + 1;
                const date = p.due_collection_date || (p.created_at ? p.created_at.substring(0, 10) : '—');
                const sName = p.supplier ? p.supplier.name : 'N/A';
                const paid = parseFloat(p.paid_amount || 0);
                const discount = parseFloat(p.discount_amount || 0);

                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="p-[10px] text-center text-slate-400 font-medium">${sl}</td>
                        <td class="p-[10px] font-mono text-xs text-slate-600 dark:text-slate-300">${date}</td>
                        <td class="p-[10px] font-semibold text-slate-800 dark:text-slate-100">${sName}</td>
                        <td class="p-[10px] text-end font-bold text-emerald-600 dark:text-emerald-400">৳ ${paid.toLocaleString()}</td>
                        <td class="p-[10px] text-end text-slate-500">৳ ${discount.toLocaleString()}</td>
                        <td class="p-[10px] text-center">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">${p.payment_method || 'Cash'}</span>
                        </td>
                        <td class="p-[10px] text-xs text-slate-500">${p.transaction_id || '—'}</td>
                    </tr>
                `;

                mobileContainer.innerHTML += `
                    <div class="p-4 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-2">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-mono text-slate-400">#${sl} | ${date}</span>
                            <span class="font-semibold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700">${p.payment_method || 'Cash'}</span>
                        </div>
                        <div class="font-bold text-slate-800 dark:text-white">${sName}</div>
                        <div class="flex items-center justify-between text-xs pt-1 border-t border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500">Paid: <strong class="text-emerald-600 font-bold">৳ ${paid.toLocaleString()}</strong></span>
                            <span class="text-slate-500">Disc: ৳ ${discount.toLocaleString()}</span>
                        </div>
                        ${p.transaction_id ? `<div class="text-[11px] text-slate-400">Ref: ${p.transaction_id}</div>` : ''}
                    </div>
                `;
            });
        }

        document.getElementById('display-info').innerHTML = total > 0
            ? `Showing <strong>${start + 1}–${Math.min(start + pageSize, total)}</strong> of <strong>${total}</strong> payments`
            : `0 payments found`;

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

    function goPage(page) { currentPage = page; renderPayments(); }
</script>

@endsection
