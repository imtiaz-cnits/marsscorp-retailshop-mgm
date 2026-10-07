@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Customers - MARSS CORPORATION')
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
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Battery Customer Directory</h1>
                                <small class="text-slate-500 dark:text-slate-400 text-xs">Manage retail & wholesale battery clients, credit profiles, and balances</small>
                            </div>
                        </div>

                        <!-- Right Controls -->
                        <div class="flex items-center flex-wrap gap-2">
                            <a href="{{ route('battery.customer.due') }}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] min-h-[38px] max-h-[38px] bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 text-xs font-semibold rounded-xl border border-rose-200 dark:border-rose-800 transition-all shadow-sm">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                <span>Customer Dues</span>
                            </a>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#customerCreateModal" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Create Customer</span>
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
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding-left: 4px !important; padding-right: 4px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search customers by name, phone or email..." />
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
                        <table class="w-full text-left border-collapse" id="customerTable">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">#</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Customer Name</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Mobile</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Address</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Total Due</th>
                                    <th class="p-[10px] text-center whitespace-nowrap">Status</th>
                                    <th class="p-[10px] text-center w-[100px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="customerTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                                <tr>
                                    <td colspan="7" class="text-center py-6 text-slate-400">Loading battery customers...</td>
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

<!-- Create Customer Modal -->
<div class="modal fade" id="customerCreateModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 540px;">
        <div class="modal-content rounded-2xl border-0 shadow-lg overflow-hidden bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100">
            <div class="modal-header px-4 py-3 border-0" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; color: #ffffff !important;">
                <h5 class="modal-title font-bold text-base flex items-center gap-2 text-white m-0">
                    <i class="fa-solid fa-user-plus text-white"></i> Add Battery Customer
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createCustomerForm" onsubmit="saveBatteryCustomer(event)">
                <div class="modal-body p-4 space-y-3">
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Customer Name <span class="text-red-500">*</span></label>
                        <input type="text" id="createCustomerName" required placeholder="Full name or Company" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Mobile Number <span class="text-red-500">*</span></label>
                        <input type="text" id="createCustomerMobile" required placeholder="017xxxxxxxx" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Email Address</label>
                        <input type="email" id="createCustomerEmail" placeholder="customer@example.com" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Address / Location</label>
                        <textarea id="createCustomerAddress" rows="2" placeholder="Full address" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white"></textarea>
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Previous Opening Due (৳)</label>
                        <input type="number" step="0.01" id="createCustomerDue" value="0" placeholder="0.00" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                    </div>
                </div>
                <div class="modal-footer border-t border-slate-200 dark:border-slate-800 px-4 py-3 flex justify-end gap-2">
                    <button type="button" class="btn px-4 text-white font-semibold" style="background-color: #dc2626 !important; border-radius: 8px !important; height: 38px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4 text-white font-semibold" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; border-radius: 8px !important; height: 38px;">Save Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Customer Modal -->
<div class="modal fade" id="customerUpdateModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 540px;">
        <div class="modal-content rounded-2xl border-0 shadow-lg overflow-hidden bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100">
            <div class="modal-header px-4 py-3 border-0" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; color: #ffffff !important;">
                <h5 class="modal-title font-bold text-base flex items-center gap-2 text-white m-0">
                    <i class="fa-solid fa-pen-to-square text-white"></i> Edit Battery Customer
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateCustomerForm" onsubmit="updateBatteryCustomer(event)">
                <input type="hidden" id="updateCustomerId">
                <div class="modal-body p-4 space-y-3">
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Customer Name <span class="text-red-500">*</span></label>
                        <input type="text" id="updateCustomerName" required class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Mobile <span class="text-red-500">*</span></label>
                        <input type="text" id="updateCustomerMobile" required class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Email</label>
                        <input type="email" id="updateCustomerEmail" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                    </div>
                    <div>
                        <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Address</label>
                        <textarea id="updateCustomerAddress" rows="2" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-t border-slate-200 dark:border-slate-800 px-4 py-3 flex justify-end gap-2">
                    <button type="button" class="btn px-4 text-white font-semibold" style="background-color: #dc2626 !important; border-radius: 8px !important; height: 38px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4 text-white font-semibold" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; border-radius: 8px !important; height: 38px;">Update Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Customer Modal -->
<div class="modal fade" id="customerDeleteModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content rounded-2xl border-0 shadow-lg text-center p-4 bg-white dark:bg-slate-900">
            <input type="hidden" id="deleteCustomerId">
            <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-triangle-exclamation text-2xl" style="color: #dc2626;"></i>
            </div>
            <h5 class="font-bold text-slate-800 dark:text-white mb-1">Delete Customer?</h5>
            <p class="text-xs text-slate-500 mb-4">Ensure this customer has no order history. This action cannot be reversed.</p>
            <div class="flex justify-center gap-2">
                <button type="button" class="btn px-4 rounded-xl text-sm font-semibold border border-slate-300 text-slate-700 hover:bg-slate-100" data-bs-dismiss="modal">Cancel</button>
                <button type="button" onclick="confirmDeleteBatteryCustomer()" class="btn px-4 text-white rounded-xl text-sm font-semibold" style="background-color: #dc2626 !important; border: none !important;">Delete</button>
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
    let rawCustomers = [];
    let currentPage = 1;
    let pageSize = 15;

    document.addEventListener("DOMContentLoaded", function() {
        getBatteryCustomers();
        $('#searchInput').on('input', function() { currentPage = 1; renderCustomers(); });
        $('#entries').on('change', function() { pageSize = parseInt(this.value) || 15; currentPage = 1; renderCustomers(); });
    });

    async function getBatteryCustomers() {
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.get("/api/battery/customer-list", HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                rawCustomers = res.data.CustomerData || [];
                renderCustomers();
            } else {
                rawCustomers = [];
                renderCustomers();
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            errorToast("Failed to load battery customers");
        }
    }

    function renderCustomers() {
        const search = ($('#searchInput').val() || '').toLowerCase().trim();
        const filtered = rawCustomers.filter(c => {
            const nameMatch = (c.name || '').toLowerCase().includes(search);
            const mobileMatch = (c.mobile || '').toLowerCase().includes(search);
            const emailMatch = (c.email || '').toLowerCase().includes(search);
            return nameMatch || mobileMatch || emailMatch;
        });

        const total = filtered.length;
        const totalPages = Math.ceil(total / pageSize) || 1;
        if (currentPage > totalPages) currentPage = 1;

        const start = (currentPage - 1) * pageSize;
        const pageItems = filtered.slice(start, start + pageSize);

        const tbody = document.getElementById('customerTableBody');
        const mobileContainer = document.getElementById('mobileCardList');
        tbody.innerHTML = '';
        mobileContainer.innerHTML = '';

        if (pageItems.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center py-8 text-slate-400">No battery customers found.</td></tr>`;
            mobileContainer.innerHTML = `<div class="p-6 text-center text-slate-400 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">No battery customers found.</div>`;
        } else {
            pageItems.forEach((c, idx) => {
                const sl = start + idx + 1;
                const due = parseFloat(c.total_due || c.previous_due_amount || 0);
                const dueText = due > 0
                    ? `<span class="font-bold text-rose-600 dark:text-rose-400">৳ ${due.toLocaleString()}</span>`
                    : `<span class="text-emerald-600 font-semibold">৳ 0.00</span>`;

                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="p-[10px] text-center text-slate-400 font-medium">${sl}</td>
                        <td class="p-[10px] font-semibold text-slate-800 dark:text-slate-100">${c.name}</td>
                        <td class="p-[10px] text-slate-600 dark:text-slate-300 font-mono text-xs">${c.mobile}</td>
                        <td class="p-[10px] text-slate-500 text-xs">${c.address || '—'}</td>
                        <td class="p-[10px] text-end">${dueText}</td>
                        <td class="p-[10px] text-center">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Active</span>
                        </td>
                        <td class="p-[10px] text-center">
                            <div class="inline-flex items-center gap-1.5">
                                <button onclick="openEditCustomerModal(${c.id})" class="action-btn action-btn-edit" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button onclick="openDeleteCustomerModal(${c.id})" class="action-btn action-btn-delete" title="Delete">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;

                mobileContainer.innerHTML += `
                    <div class="p-4 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-mono text-slate-400">#${sl}</span>
                            <div>${dueText}</div>
                        </div>
                        <div class="font-bold text-slate-800 dark:text-white">${c.name}</div>
                        <div class="text-xs text-slate-500"><i class="fa-solid fa-phone me-1"></i>${c.mobile}</div>
                        ${c.address ? `<div class="text-xs text-slate-400"><i class="fa-solid fa-location-dot me-1"></i>${c.address}</div>` : ''}
                        <div class="pt-2 flex justify-end gap-2 border-t border-slate-100 dark:border-slate-800">
                            <button onclick="openEditCustomerModal(${c.id})" class="action-btn action-btn-edit" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button onclick="openDeleteCustomerModal(${c.id})" class="action-btn action-btn-delete" title="Delete">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
        }

        document.getElementById('display-info').innerHTML = total > 0
            ? `Showing <strong>${start + 1}–${Math.min(start + pageSize, total)}</strong> of <strong>${total}</strong> customers`
            : `0 customers found`;

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

    function goPage(page) { currentPage = page; renderCustomers(); }

    async function saveBatteryCustomer(e) {
        e.preventDefault();
        try {
            const name = $('#createCustomerName').val().trim();
            const mobile = $('#createCustomerMobile').val().trim();
            const email = $('#createCustomerEmail').val().trim();
            const address = $('#createCustomerAddress').val().trim();
            const previous_due_amount = $('#createCustomerDue').val() || 0;

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/create-customer', {
                name, mobile, email, address, previous_due_amount
            }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Customer created');
                $('#customerCreateModal').modal('hide');
                $('#createCustomerForm')[0].reset();
                getBatteryCustomers();
            } else {
                errorToast(res.data.message || 'Failed to create customer');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            errorToast(err.response?.data?.message || 'Error saving customer');
        }
    }

    async function openEditCustomerModal(id) {
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/customer-by-id', { id }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success' && res.data.data) {
                const c = res.data.data;
                $('#updateCustomerId').val(c.id);
                $('#updateCustomerName').val(c.name);
                $('#updateCustomerMobile').val(c.mobile);
                $('#updateCustomerEmail').val(c.email || '');
                $('#updateCustomerAddress').val(c.address || '');
                $('#customerUpdateModal').modal('show');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            errorToast('Failed to load customer details');
        }
    }

    async function updateBatteryCustomer(e) {
        e.preventDefault();
        try {
            const id = $('#updateCustomerId').val();
            const name = $('#updateCustomerName').val().trim();
            const mobile = $('#updateCustomerMobile').val().trim();
            const email = $('#updateCustomerEmail').val().trim();
            const address = $('#updateCustomerAddress').val().trim();

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/update-customer', {
                id, name, mobile, email, address
            }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Customer updated');
                $('#customerUpdateModal').modal('hide');
                getBatteryCustomers();
            } else {
                errorToast(res.data.message || 'Failed to update customer');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            errorToast(err.response?.data?.message || 'Error updating customer');
        }
    }

    function openDeleteCustomerModal(id) {
        $('#deleteCustomerId').val(id);
        $('#customerDeleteModal').modal('show');
    }

    async function confirmDeleteBatteryCustomer() {
        try {
            const id = $('#deleteCustomerId').val();
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/delete-customer', { id }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Customer deleted');
                $('#customerDeleteModal').modal('hide');
                getBatteryCustomers();
            } else {
                errorToast(res.data.message || 'Failed to delete customer');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            errorToast(err.response?.data?.message || 'Error deleting customer');
        }
    }
</script>

@endsection
