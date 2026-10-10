@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Purchase Returns - MARSS CORPORATION')
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
                            <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 dark:bg-rose-950/50 dark:text-rose-400 flex items-center justify-center border border-rose-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="1 4 1 10 7 10"></polyline>
                                    <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Battery Purchase Returns</h1>
                                <small class="text-slate-500 dark:text-slate-400 text-xs">Return defective or excess battery stock back to suppliers with payable deduction</small>
                            </div>
                        </div>

                        <!-- Right Controls -->
                        <div class="flex items-center flex-wrap gap-2">
                            <a href="{{ route('battery.sales.returns') }}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] min-h-[38px] max-h-[38px] bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-200 text-xs font-semibold rounded-xl border border-slate-300 dark:border-slate-700 transition-all shadow-sm">
                                <i class="fa-solid fa-arrow-rotate-left"></i>
                                <span>Sales Returns</span>
                            </a>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#purchaseReturnModal" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <i class="fa-solid fa-plus text-xs"></i>
                                <span>Process Return</span>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Controls & Filter Row -->
                    <div class="controls-row-wrapper mb-4 w-full">
                        <div class="search-input-wrapper unified-ui-border h-[38px] flex items-center bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding-left: 4px !important; padding-right: 4px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search by purchase ID, supplier or product..." />
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
                        <table class="w-full text-left border-collapse" id="purchaseReturnsTable">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">#</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Return Date</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Purchase ID</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Supplier</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Returned Product</th>
                                    <th class="p-[10px] text-center whitespace-nowrap">Qty</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Return Amount</th>
                                    <th class="p-[10px] text-center w-[90px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="purchaseReturnsTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                                <tr>
                                    <td colspan="8" class="text-center py-6 text-slate-400">Loading battery purchase returns...</td>
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

<!-- Process Purchase Return Modal -->
<div class="modal fade" id="purchaseReturnModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-2xl border-0 shadow-lg overflow-hidden bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100">
            <div class="modal-header px-4 py-3 border-0" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; color: #ffffff !important;">
                <h5 class="modal-title font-bold text-base flex items-center gap-2 text-white m-0">
                    <i class="fa-solid fa-truck-arrow-right text-white"></i> Return Stock to Supplier
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 space-y-4">
                <!-- Search Purchase -->
                <div class="flex gap-2">
                    <input type="text" id="returnSearchPurchase" placeholder="Enter Purchase ID (e.g. #PurID00001)" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                    <button type="button" onclick="searchPurchaseToReturn()" class="inline-flex items-center gap-1.5 px-4 h-[42px] bg-emerald-700 hover:bg-emerald-600 text-white rounded-xl text-xs font-semibold shadow-sm transition-all flex-shrink-0">
                        <i class="fa-solid fa-magnifying-glass"></i> Search
                    </button>
                </div>

                <!-- Purchase Details Box -->
                <div id="purchaseResultBox" class="p-3 bg-emerald-50/50 dark:bg-slate-800/60 rounded-xl border border-emerald-100 dark:border-slate-700 text-xs hidden space-y-3">
                    <div class="flex justify-between items-center border-b pb-2 border-slate-200 dark:border-slate-700">
                        <div>Purchase ID: <strong id="purIdText" class="font-mono text-emerald-700 font-bold"></strong></div>
                        <div>Date: <span id="purDateText"></span></div>
                        <div>Supplier: <strong id="purSupName"></strong></div>
                    </div>

                    <!-- Items Table -->
                    <div class="overflow-x-auto">
                        <span class="font-bold text-slate-700 dark:text-slate-300 uppercase block mb-1">Purchased Products:</span>
                        <table class="w-full text-xs">
                            <thead>
                                <tr class="text-slate-500 font-bold border-b border-slate-200 dark:border-slate-700">
                                    <th class="p-1.5">Product</th>
                                    <th class="p-1.5 text-center">Purchased Qty</th>
                                    <th class="p-1.5 text-end">Cost Price</th>
                                    <th class="p-1.5 text-center w-28">Return Qty</th>
                                </tr>
                            </thead>
                            <tbody id="purchaseItemsTbody" class="divide-y divide-slate-200 dark:divide-slate-700"></tbody>
                        </table>
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row justify-between items-center gap-3 border-t border-slate-200 dark:border-slate-700">
                        <div class="flex items-center gap-2">
                            <label class="font-bold whitespace-nowrap">Return Date:</label>
                            <input type="date" id="purchaseReturnDateInput" value="{{ date('Y-m-d') }}" class="form-control form-control-sm rounded-lg text-xs w-36 h-[34px]">
                        </div>
                        <button type="button" onclick="submitPurchaseReturn()" class="inline-flex items-center justify-center px-4 h-[36px] bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-semibold shadow-sm transition-all">
                            Confirm Return to Supplier
                        </button>
                    </div>
                </div>

            </div>
            <div class="modal-footer border-t border-slate-200 dark:border-slate-800 px-4 py-3 flex justify-end">
                <button type="button" class="btn px-4 text-white font-semibold" style="background-color: #dc2626 !important; border-radius: 8px !important; height: 38px;" data-bs-dismiss="modal">Close</button>
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
    let rawPurchaseReturns = [];
    let currentPurchaseRecord = null;
    let currentPage = 1;
    let pageSize = 15;

    document.addEventListener("DOMContentLoaded", function() {
        getBatteryPurchaseReturns();
        $('#searchInput').on('input', function() { currentPage = 1; renderPurchaseReturns(); });
        $('#entries').on('change', function() { pageSize = parseInt(this.value) || 15; currentPage = 1; renderPurchaseReturns(); });
    });

    async function getBatteryPurchaseReturns() {
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.get("/api/battery/purchase-return-product-list", HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                rawPurchaseReturns = res.data.PurchaseReturnData || [];
                renderPurchaseReturns();
            } else {
                rawPurchaseReturns = [];
                renderPurchaseReturns();
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            errorToast("Failed to load battery purchase returns");
        }
    }

    function renderPurchaseReturns() {
        const search = ($('#searchInput').val() || '').toLowerCase().trim();
        const filtered = rawPurchaseReturns.filter(r => {
            const id = (r.purchase_id || '').toLowerCase();
            const s = (r.supplier_name || r.supplier || '').toLowerCase();
            const p = (r.product_name || '').toLowerCase();
            return id.includes(search) || s.includes(search) || p.includes(search);
        });

        const total = filtered.length;
        const totalPages = Math.ceil(total / pageSize) || 1;
        if (currentPage > totalPages) currentPage = 1;

        const start = (currentPage - 1) * pageSize;
        const pageItems = filtered.slice(start, start + pageSize);

        const tbody = document.getElementById('purchaseReturnsTableBody');
        const mobileContainer = document.getElementById('mobileCardList');
        tbody.innerHTML = '';
        mobileContainer.innerHTML = '';

        if (pageItems.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center py-8 text-slate-400">No purchase return records found.</td></tr>`;
            mobileContainer.innerHTML = `<div class="p-6 text-center text-slate-400 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">No purchase return records found.</div>`;
        } else {
            pageItems.forEach((r, idx) => {
                const sl = start + idx + 1;
                const suppDisplay = r.supplier_name || r.supplier || 'N/A';
                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="p-[10px] text-center text-slate-400 font-medium">${sl}</td>
                        <td class="p-[10px] font-mono text-xs text-slate-600 dark:text-slate-300">${r.date}</td>
                        <td class="p-[10px] font-mono text-xs font-bold text-emerald-700 dark:text-emerald-400">${r.purchase_id}</td>
                        <td class="p-[10px] font-semibold text-slate-800 dark:text-slate-100">${suppDisplay}</td>
                        <td class="p-[10px] text-slate-700 dark:text-slate-200">${r.product_name}</td>
                        <td class="p-[10px] text-center font-bold">${r.quantity}</td>
                        <td class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400">৳ ${parseFloat(r.amount || 0).toLocaleString()}</td>
                        <td class="p-[10px] text-center whitespace-nowrap">
                            <a href="/battery/purchase-return/${r.id}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:text-emerald-300 dark:hover:bg-emerald-900/50 transition-all shadow-sm" title="View Purchase Return Details">
                                <i class="fa-solid fa-eye text-xs"></i>
                            </a>
                        </td>
                    </tr>
                `;

                mobileContainer.innerHTML += `
                    <div class="p-4 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-xs font-bold text-emerald-700">${r.purchase_id}</span>
                            <span class="text-xs font-bold text-rose-600">৳ ${parseFloat(r.amount || 0).toLocaleString()}</span>
                        </div>
                        <div class="font-bold text-slate-800 dark:text-white">${suppDisplay}</div>
                        <div class="text-xs text-slate-600 dark:text-slate-300">${r.product_name} (Qty: ${r.quantity})</div>
                        <div class="flex items-center justify-between pt-1 border-t border-slate-100 dark:border-slate-800">
                            <span class="text-xs text-slate-400">Date: ${r.date}</span>
                            <a href="/battery/purchase-return/${r.id}" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 dark:text-emerald-400 hover:underline">
                                <i class="fa-solid fa-eye text-[10px]"></i> View Details
                            </a>
                        </div>
                    </div>
                `;
            });
        }

        document.getElementById('display-info').innerHTML = total > 0
            ? `Showing <strong>${start + 1}–${Math.min(start + pageSize, total)}</strong> of <strong>${total}</strong> returns`
            : `0 returns found`;

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

    function goPage(page) { currentPage = page; renderPurchaseReturns(); }

    async function searchPurchaseToReturn() {
        const purId = $('#returnSearchPurchase').val().trim();
        if (!purId) {
            errorToast('Please enter a Purchase ID');
            return;
        }

        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.get(`/api/battery/search-purchase-for-return?purchase_id=${encodeURIComponent(purId)}`, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success' && res.data.purchase) {
                currentPurchaseRecord = res.data.purchase;
                $('#purIdText').text(currentPurchaseRecord.purchase_id);
                $('#purDateText').text(currentPurchaseRecord.date);
                $('#purSupName').text(currentPurchaseRecord.supplier);

                const tbody = document.getElementById('purchaseItemsTbody');
                tbody.innerHTML = '';

                (currentPurchaseRecord.details || []).forEach(item => {
                    tbody.innerHTML += `
                        <tr class="item-pur-return-row" data-detail-id="${item.id}" data-prod-id="${item.product_id}" data-max-qty="${item.quantity}">
                            <td class="p-1.5 font-semibold">${item.product_name}</td>
                            <td class="p-1.5 text-center font-bold">${item.quantity}</td>
                            <td class="p-1.5 text-end">৳ ${parseFloat(item.cost_price || 0).toLocaleString()}</td>
                            <td class="p-1.5 text-center">
                                <input type="number" min="0" max="${item.quantity}" value="0" class="form-control form-control-sm text-center return-qty-input rounded-lg w-20 mx-auto">
                            </td>
                        </tr>
                    `;
                });

                $('#purchaseResultBox').removeClass('hidden');
            } else {
                errorToast(res.data?.message || 'Purchase not found');
                $('#purchaseResultBox').addClass('hidden');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            errorToast('Error finding purchase');
        }
    }

    async function submitPurchaseReturn() {
        if (!currentPurchaseRecord) return;

        const returnItems = [];
        document.querySelectorAll('#purchaseItemsTbody tr.item-pur-return-row').forEach(row => {
            const detailId = row.getAttribute('data-detail-id');
            const prodId = row.getAttribute('data-prod-id');
            const qty = parseInt(row.querySelector('.return-qty-input').value) || 0;
            if (qty > 0) {
                returnItems.push({
                    purchase_details_id: detailId,
                    product_id: prodId,
                    quantity: qty
                });
            }
        });

        if (returnItems.length === 0) {
            errorToast('Please enter at least 1 returned item quantity');
            return;
        }

        const payload = {
            purchase_id: currentPurchaseRecord.id,
            supplier_id: currentPurchaseRecord.supplier_id,
            date: $('#purchaseReturnDateInput').val() || '{{ date("Y-m-d") }}',
            products: returnItems
        };

        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/create-purchase-return-product', payload, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Purchase return recorded');
                $('#purchaseReturnModal').modal('hide');
                $('#purchaseResultBox').addClass('hidden');
                $('#returnSearchPurchase').val('');
                getBatteryPurchaseReturns();
            } else {
                errorToast(res.data.message || 'Purchase return failed');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            errorToast(err.response?.data?.message || 'Error processing purchase return');
        }
    }
</script>

@endsection
