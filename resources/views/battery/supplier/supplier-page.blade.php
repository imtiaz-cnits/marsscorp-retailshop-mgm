@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Suppliers - MARSS CORPORATION')
@section('content')

<style>
    .product-card-body {
        padding: 10px !important;
    }
    @media (min-width: 768px) {
        .product-card-body {
            padding: 16px !important;
        }
    }

    .controls-row-wrapper {
        width: 100% !important;
        margin-bottom: 16px;
    }
    .search-input-wrapper {
        padding-left: 14px !important;
        padding-right: 14px !important;
    }
    .entries-wrapper {
        width: max-content !important;
        flex-shrink: 0 !important;
        padding-left: 12px !important;
        padding-right: 8px !important;
    }

    @media (min-width: 640px) {
        .controls-row-wrapper {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 14px !important;
        }
        .search-input-wrapper {
            flex: 1 1 auto !important;
            width: auto !important;
            min-width: 0 !important;
        }
        .controls-filter-group {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 12px !important;
            flex: 0 0 auto !important;
        }
        .entries-wrapper {
            flex: 0 0 auto !important;
            width: max-content !important;
        }
        .filter-status-container {
            flex: 0 0 170px !important;
            width: 170px !important;
            min-width: 170px !important;
        }
    }

    @media (max-width: 639px) {
        .controls-row-wrapper {
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
        }
        .search-input-wrapper {
            width: 100% !important;
        }
        .controls-filter-group {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 8px !important;
            width: 100% !important;
        }
        .entries-wrapper {
            flex: 0 0 auto !important;
            width: max-content !important;
        }
        .filter-status-container {
            flex: 1 1 auto !important;
            width: 100% !important;
            min-width: 0 !important;
        }
    }

    .unified-ui-border {
        border: 1.5px solid #cbd5e1 !important;
    }

    .search-input-wrapper:focus-within {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.25) !important;
    }

    body[light-mode="dark"] .unified-ui-border,
    body[data-layout-mode="dark"] .unified-ui-border,
    html.dark .unified-ui-border {
        border-color: #334155 !important;
    }
</style>

<!-- Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-[calc(100vh-70px)] flex flex-col justify-between">
        <div class="data-table flex-grow">
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-10">
                    
                    <!-- 1. Top Section: Page Title & Top Action Buttons -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="3" width="15" height="13"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Battery Supplier List</h1>
                        </div>

                        <!-- Right Controls -->
                        <div class="flex items-center flex-wrap gap-2">
                            <a href="{{ route('battery.supplier.due') }}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] min-h-[38px] max-h-[38px] bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 text-xs font-semibold rounded-xl border border-amber-200 dark:border-amber-800 transition-all">
                                <i class="fa-solid fa-hand-holding-dollar"></i>
                                <span>Supplier Due List</span>
                            </a>
                            <button id="openModalBtns" type="button" data-bs-toggle="modal" data-bs-target="#supplierCreateModal" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Create Supplier</span>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Controls & Filter Row -->
                    <div class="controls-row-wrapper mb-4 w-full">
                        <!-- Search Bar -->
                        <div class="search-input-wrapper unified-ui-border h-[38px] flex items-center bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding-left: 4px !important; padding-right: 4px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search Supplier..." />
                        </div>

                        <!-- Secondary Controls Group -->
                        <div class="controls-filter-group">
                            <div class="entries-wrapper unified-ui-border flex items-center gap-1.5 bg-white dark:bg-slate-800/90 h-[38px] rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 shadow-sm transition-all hover:border-emerald-500">
                                <span class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider whitespace-nowrap">SHOW:</span>
                                <select id="entries" class="bg-transparent border-0 text-xs sm:text-sm font-bold text-emerald-700 dark:text-emerald-400 focus:outline-none cursor-pointer py-1 pr-1 text-end" style="cursor: pointer;">
                                    <option value="15" selected class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">15</option>
                                    <option value="50" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">50</option>
                                    <option value="100" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">100</option>
                                    <option value="200" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">200</option>
                                    <option value="500" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">500</option>
                                </select>
                            </div>

                            <div class="filter-status-container">
                                <select id="filterStatus" class="unified-ui-border w-full flex items-center px-3 sm:px-3.5 h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-sm text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-200 cursor-pointer hover:border-emerald-500 transition-all duration-150">
                                    <option value="">All Status</option>
                                    <option value="Active">Active</option>
                                    <option value="InActive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Desktop Table -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900 mb-4">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Supplier Name</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Phone</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Email</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Address</th>
                                    <th class="p-[10px] text-center w-[120px] whitespace-nowrap">Status</th>
                                    <th class="p-[10px] text-center w-[100px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="supplierTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                                <tr>
                                    <td colspan="7" class="text-center py-6 text-slate-400">Loading battery suppliers...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- 4. Mobile Card List View -->
                    <div id="mobileCardList" class="block md:hidden mb-3 space-y-3"></div>

                    <!-- 5. Modern Smart Pagination and Display Info Footer -->
                    <div class="flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-800 gap-3">
                        <div id="display-info" class="text-xs text-slate-500 dark:text-slate-400"></div>
                        <div id="pagination" class="flex items-center gap-1 sm:gap-1.5 flex-nowrap justify-center max-w-full overflow-x-auto pb-1"></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sticky Bottom Copyright Section -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)] mt-auto">
            <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>

    </div>
</div>

<!-- Create Supplier Modal -->
<div class="modal fade" id="supplierCreateModal" tabindex="-1" aria-labelledby="supplierCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white px-4 py-3" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2 m-0 text-white" id="supplierCreateModalLabel" style="color: #ffffff !important;">
                    <i class="fa-solid fa-truck-field text-white" style="color: #ffffff !important;"></i>
                    <span class="text-white" style="color: #ffffff !important;">Add New Supplier</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <form id="createSupplierForm" onsubmit="saveBatterySupplier(event)">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white mb-3">
                        <div class="mb-3">
                            <label for="createSupplierName" class="form-label fw-bold small text-dark">Supplier / Company Name <span class="text-danger">*</span></label>
                            <input type="text" id="createSupplierName" required placeholder="e.g. Rahimafrooz Batteries Ltd" class="form-control" style="height: 42px; border-radius: 8px;">
                        </div>

                        <div class="mb-3">
                            <label for="createSupplierPhone" class="form-label fw-bold small text-dark">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" id="createSupplierPhone" required placeholder="017xxxxxxxx" class="form-control" style="height: 42px; border-radius: 8px;">
                        </div>

                        <div class="mb-3">
                            <label for="createSupplierEmail" class="form-label fw-bold small text-dark">Email Address</label>
                            <input type="email" id="createSupplierEmail" placeholder="supplier@example.com" class="form-control" style="height: 42px; border-radius: 8px;">
                        </div>

                        <div class="mb-3">
                            <label for="createSupplierAddress" class="form-label fw-bold small text-dark">Address / Location</label>
                            <textarea id="createSupplierAddress" rows="2" placeholder="Warehouse address" class="form-control" style="border-radius: 8px;"></textarea>
                        </div>

                        <div class="mb-0">
                            <label for="createSupplierStatus" class="form-label fw-bold small text-dark">Status</label>
                            <select id="createSupplierStatus" class="form-select unified-ui-border" style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                <option value="Active" selected>Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                        <button type="button" class="btn px-4 py-2 fw-semibold text-white" data-bs-dismiss="modal" style="background-color: #dc2626 !important; color: #ffffff !important; border-radius: 8px; border: none !important;">Cancel</button>
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="background-color: #15803d; border-radius: 8px; border: none;">
                            <i class="fa-solid fa-check me-1"></i> Save Supplier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Supplier Modal -->
<div class="modal fade" id="supplierUpdateModal" tabindex="-1" aria-labelledby="supplierUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white px-4 py-3" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2 m-0 text-white" id="supplierUpdateModalLabel" style="color: #ffffff !important;">
                    <i class="fa-solid fa-pen-to-square text-white" style="color: #ffffff !important;"></i>
                    <span class="text-white" style="color: #ffffff !important;">Edit Supplier</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <form id="updateSupplierForm" onsubmit="updateBatterySupplier(event)">
                    <input type="hidden" id="updateSupplierId">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white mb-3">
                        <div class="mb-3">
                            <label for="updateSupplierName" class="form-label fw-bold small text-dark">Supplier / Company Name <span class="text-danger">*</span></label>
                            <input type="text" id="updateSupplierName" required class="form-control" style="height: 42px; border-radius: 8px;">
                        </div>

                        <div class="mb-3">
                            <label for="updateSupplierPhone" class="form-label fw-bold small text-dark">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" id="updateSupplierPhone" required class="form-control" style="height: 42px; border-radius: 8px;">
                        </div>

                        <div class="mb-3">
                            <label for="updateSupplierEmail" class="form-label fw-bold small text-dark">Email Address</label>
                            <input type="email" id="updateSupplierEmail" class="form-control" style="height: 42px; border-radius: 8px;">
                        </div>

                        <div class="mb-3">
                            <label for="updateSupplierAddress" class="form-label fw-bold small text-dark">Address / Location</label>
                            <textarea id="updateSupplierAddress" rows="2" class="form-control" style="border-radius: 8px;"></textarea>
                        </div>

                        <div class="mb-0">
                            <label for="updateSupplierStatus" class="form-label fw-bold small text-dark">Status</label>
                            <select id="updateSupplierStatus" class="form-select unified-ui-border" style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                <option value="Active">Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                        <button type="button" class="btn px-4 py-2 fw-semibold text-white" data-bs-dismiss="modal" style="background-color: #dc2626 !important; color: #ffffff !important; border-radius: 8px; border: none !important;">Cancel</button>
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="background-color: #15803d; border-radius: 8px; border: none;">
                            <i class="fa-solid fa-check me-1"></i> Update Supplier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Supplier Modal -->
<div class="modal fade" id="supplierDeleteModal" tabindex="-1" aria-labelledby="supplierDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 shadow-lg text-center p-4" style="border-radius: 16px;">
            <div class="text-danger mb-3">
                <i class="fa-solid fa-triangle-exclamation" style="font-size: 48px;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Are you sure?</h5>
            <p class="text-muted small mb-4">Are you sure you want to delete this battery supplier? This action cannot be undone.</p>
            <input type="hidden" id="deleteSupplierId" />
            <div class="d-flex align-items-center justify-content-center gap-2">
                <button type="button" class="btn btn-secondary px-4 py-2 fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                <button type="button" onclick="confirmDeleteBatterySupplier()" class="btn btn-danger px-4 py-2 fw-bold" style="border-radius: 8px;">
                    <i class="fa-solid fa-trash me-1"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let rawSupplierData = [];
    let currentPage = 1;
    let pageSize = 15;

    document.addEventListener("DOMContentLoaded", function() {
        getBatterySupplierList();

        $('#searchInput').on('input', function() { currentPage = 1; renderSuppliers(); });
        $('#filterStatus').on('change', function() { currentPage = 1; renderSuppliers(); });
        $('#entries').on('change', function() { pageSize = parseInt(this.value) || 15; currentPage = 1; renderSuppliers(); });
    });

    async function getBatterySupplierList() {
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.get("/api/battery/supplier-list", HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                rawSupplierData = res.data.data || [];
                rawSupplierData.sort((a, b) => (b.id || 0) - (a.id || 0));
                renderSuppliers();
            } else {
                rawSupplierData = [];
                renderSuppliers();
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            errorToast("Failed to load battery suppliers");
        }
    }

    function renderSuppliers() {
        const search = ($('#searchInput').val() || '').toLowerCase().trim();
        const status = $('#filterStatus').val();

        const filtered = rawSupplierData.filter(item => {
            const matchesSearch = (item.name || '').toLowerCase().includes(search)
                || (item.mobile || item.phone || '').toLowerCase().includes(search)
                || (item.email || '').toLowerCase().includes(search);
            const matchesStatus = !status || item.status === status;
            return matchesSearch && matchesStatus;
        });

        const total = filtered.length;
        const totalPages = Math.ceil(total / pageSize) || 1;
        if (currentPage > totalPages) currentPage = 1;

        const start = (currentPage - 1) * pageSize;
        const pageItems = filtered.slice(start, start + pageSize);

        const tbody = document.getElementById('supplierTableBody');
        const mobileContainer = document.getElementById('mobileCardList');
        tbody.innerHTML = '';
        if (mobileContainer) mobileContainer.innerHTML = '';

        if (pageItems.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center py-8 text-slate-400 font-medium">No battery suppliers found.</td></tr>`;
            if (mobileContainer) mobileContainer.innerHTML = `<div class="p-6 text-center text-slate-400 font-medium bg-white dark:bg-slate-800 rounded-xl unified-ui-border">No battery suppliers found.</div>`;
        } else {
            pageItems.forEach((s, idx) => {
                const sl = start + idx + 1;
                const statusBadge = (s.status === 'Active' || !s.status)
                    ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Active</span>'
                    : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300">Inactive</span>';

                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="p-[10px] text-center text-slate-500 font-medium">${sl}</td>
                        <td class="p-[10px] text-start font-semibold text-slate-800 dark:text-slate-100">${s.name}</td>
                        <td class="p-[10px] text-start text-slate-600 dark:text-slate-300 font-mono">${s.mobile || s.phone || '—'}</td>
                        <td class="p-[10px] text-start text-slate-600 dark:text-slate-300">${s.email || '—'}</td>
                        <td class="p-[10px] text-start text-slate-600 dark:text-slate-300 text-xs">${s.address || '—'}</td>
                        <td class="p-[10px] text-center">${statusBadge}</td>
                        <td class="p-[10px] text-center">
                            <div class="inline-flex items-center gap-1.5 justify-center">
                                <button onclick="openEditSupplierModal(${s.id})" class="action-btn action-btn-edit edit-link w-[32px] h-[32px] rounded-lg inline-flex items-center justify-center bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:text-emerald-400 transition-colors" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button onclick="openDeleteSupplierModal(${s.id})" class="action-btn action-btn-delete delete-link w-[32px] h-[32px] rounded-lg inline-flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-100 dark:bg-rose-950/40 dark:text-rose-400 transition-colors" title="Delete">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;

                if (mobileContainer) {
                    mobileContainer.innerHTML += `
                        <div class="unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800 shadow-sm flex items-center justify-between gap-3">
                            <div>
                                <div class="font-bold text-slate-800 dark:text-slate-100 text-sm">${s.name}</div>
                                <div class="text-xs text-slate-500 font-mono mt-0.5"><i class="fa-solid fa-phone text-emerald-600 text-[10px]"></i> ${s.mobile || s.phone || '—'}</div>
                                <div class="mt-1.5">${statusBadge}</div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button onclick="openEditSupplierModal(${s.id})" class="action-btn action-btn-edit edit-link w-[32px] h-[32px] rounded-lg inline-flex items-center justify-center bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:text-emerald-400" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button onclick="openDeleteSupplierModal(${s.id})" class="action-btn action-btn-delete delete-link w-[32px] h-[32px] rounded-lg inline-flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-100 dark:bg-rose-950/40 dark:text-rose-400" title="Delete">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </div>
                    `;
                }
            });
        }

        document.getElementById('display-info').innerHTML = total > 0
            ? `Showing <strong class="text-slate-700 dark:text-slate-200">${start + 1}</strong> to <strong class="text-slate-700 dark:text-slate-200">${Math.min(start + pageSize, total)}</strong> of <strong class="text-slate-700 dark:text-slate-200">${total}</strong> entries`
            : `Showing 0 to 0 of 0 entries`;

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        const p = document.getElementById('pagination');
        p.innerHTML = '';
        if (totalPages <= 1) return;

        const btnClass = "h-8 min-w-[32px] px-2 rounded-lg text-xs font-semibold border flex items-center justify-center transition-all ";
        p.innerHTML += `<button onclick="goPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''} class="${btnClass} ${currentPage === 1 ? 'opacity-40 cursor-not-allowed border-slate-200 text-slate-400' : 'border-slate-200 dark:border-slate-700 hover:bg-slate-100 text-slate-700 dark:text-slate-200'}">‹</button>`;
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                p.innerHTML += `<button onclick="goPage(${i})" class="${btnClass} ${i === currentPage ? 'bg-emerald-700 text-white border-emerald-700' : 'border-slate-200 dark:border-slate-700 hover:bg-slate-100 text-slate-700 dark:text-slate-200'}">${i}</button>`;
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                p.innerHTML += `<span class="px-1 text-slate-400">…</span>`;
            }
        }
        p.innerHTML += `<button onclick="goPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''} class="${btnClass} ${currentPage === totalPages ? 'opacity-40 cursor-not-allowed border-slate-200 text-slate-400' : 'border-slate-200 dark:border-slate-700 hover:bg-slate-100 text-slate-700 dark:text-slate-200'}">›</button>`;
    }

    function goPage(page) {
        currentPage = page;
        renderSuppliers();
    }

    async function saveBatterySupplier(e) {
        e.preventDefault();
        try {
            const name = $('#createSupplierName').val().trim();
            const phone = $('#createSupplierPhone').val().trim();
            const email = $('#createSupplierEmail').val().trim();
            const address = $('#createSupplierAddress').val().trim();
            const status = $('#createSupplierStatus').val();

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/create-supplier', {
                name: name,
                mobile: phone,
                phone: phone,
                email: email,
                address: address,
                status: status
            }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Battery Supplier created successfully');
                $('#supplierCreateModal').modal('hide');
                $('#createSupplierForm')[0].reset();
                getBatterySupplierList();
            } else {
                errorToast(res.data.message || 'Failed to create supplier');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to save supplier');
        }
    }

    function openEditSupplierModal(id) {
        const s = rawSupplierData.find(item => item.id == id);
        if (!s) return;

        $('#updateSupplierId').val(s.id);
        $('#updateSupplierName').val(s.name);
        $('#updateSupplierPhone').val(s.mobile || s.phone || '');
        $('#updateSupplierEmail').val(s.email || '');
        $('#updateSupplierAddress').val(s.address || '');
        $('#updateSupplierStatus').val(s.status || 'Active');

        $('#supplierUpdateModal').modal('show');
    }

    async function updateBatterySupplier(e) {
        e.preventDefault();
        try {
            const id = $('#updateSupplierId').val();
            const name = $('#updateSupplierName').val().trim();
            const phone = $('#updateSupplierPhone').val().trim();
            const email = $('#updateSupplierEmail').val().trim();
            const address = $('#updateSupplierAddress').val().trim();
            const status = $('#updateSupplierStatus').val();

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/update-supplier', {
                id: id,
                name: name,
                mobile: phone,
                phone: phone,
                email: email,
                address: address,
                status: status
            }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Battery Supplier updated successfully');
                $('#supplierUpdateModal').modal('hide');
                getBatterySupplierList();
            } else {
                errorToast(res.data.message || 'Failed to update supplier');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to update supplier');
        }
    }

    function openDeleteSupplierModal(id) {
        $('#deleteSupplierId').val(id);
        $('#supplierDeleteModal').modal('show');
    }

    async function confirmDeleteBatterySupplier() {
        const id = $('#deleteSupplierId').val();
        if (!id) return;

        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/delete-supplier', { id: id }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Battery Supplier deleted successfully');
                $('#supplierDeleteModal').modal('hide');
                getBatterySupplierList();
            } else {
                errorToast(res.data.message || 'Failed to delete supplier');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to delete supplier');
        }
    }
</script>

@endsection
