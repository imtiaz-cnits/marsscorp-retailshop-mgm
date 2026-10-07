@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Brands - MARSS CORPORATION')
@section('content')

<style>
    /* Card-body padding standard */
    .product-card-body {
        padding: 10px !important;
    }
    @media (min-width: 768px) {
        .product-card-body {
            padding: 16px !important;
        }
    }

    /* Controls Row & Elements: Desktop (Search big on left, Show Entries, All Status on right); Mobile (Row 1 Search, Row 2 Show Entries + Status) */
    .controls-row-wrapper {
        width: 100% !important;
        margin-bottom: 16px;
    }
    .search-input-wrapper {
        padding-left: 14px !important;
        padding-right: 14px !important;
    }
    /* Show Entries: Strictly content-width on both desktop & mobile */
    .entries-wrapper {
        width: max-content !important;
        flex-shrink: 0 !important;
        padding-left: 12px !important;
        padding-right: 8px !important;
    }

    /* Desktop View: Big Search on Left, then Show Entry, then All Status */
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

    /* Mobile View: Row 1 = Search (full width), Row 2 = Show Entries + All Status (side-by-side) */
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

    /* Unified UI Border Color for Light Mode across all fields, buttons, and table */
    .unified-ui-border {
        border: 1.5px solid #cbd5e1 !important;
    }

    /* Search input wrapper focus ring */
    .search-input-wrapper:focus-within {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.25) !important;
    }

    /* Dark Mode Support */
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
                                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                    <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Battery Brand List</h1>
                        </div>

                        <!-- Right Controls -->
                        <div class="flex items-center flex-wrap gap-2">
                            <button id="openModalBtns" type="button" data-bs-toggle="modal" data-bs-target="#brandCreateModal" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Create Brand</span>
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
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding-left: 4px !important; padding-right: 4px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search Battery Brand..." />
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
                                    <th class="p-[10px] text-center w-[65px] whitespace-nowrap" style="width: 65px !important;">Logo</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Brand Name</th>
                                    <th class="p-[10px] text-center w-[120px] whitespace-nowrap">Status</th>
                                    <th class="p-[10px] text-center w-[100px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="brandTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-slate-400">Loading battery brands...</td>
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

<!-- Create Brand Modal -->
<div class="modal fade" id="brandCreateModal" tabindex="-1" aria-labelledby="brandCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white px-4 py-3" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2 m-0 text-white" id="brandCreateModalLabel" style="color: #ffffff !important;">
                    <i class="fa-solid fa-tag text-white" style="color: #ffffff !important;"></i>
                    <span class="text-white" style="color: #ffffff !important;">Add New Brand</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <form id="createBrandForm" onsubmit="saveBatteryBrand(event)">
                    <!-- Logo Upload Container -->
                    <div class="card border-0 shadow-sm rounded-3 p-3 mb-3 text-center bg-white">
                        <div class="d-inline-block position-relative mb-2">
                            <img id="createBrandPreview" src="{{ asset('backend/assets/img/brand-defult-img.svg') }}" alt="Brand Logo Preview" style="width: 85px; height: 85px; object-fit: contain; border-radius: 12px; border: 2px dashed #86efac; padding: 4px; background: #f0fdf4;" />
                        </div>
                        <div>
                            <label for="createBrandImage" class="btn btn-sm btn-outline-success fw-bold px-3 py-1" style="border-radius: 6px; cursor: pointer; font-size: 12px;">
                                <i class="fa-solid fa-upload me-1"></i> Upload Brand Logo
                            </label>
                            <input type="file" id="createBrandImage" class="d-none" accept="image/*" />
                            <div class="text-muted small mt-1" style="font-size: 11px;">PNG, JPG or GIF (Max 1MB)</div>
                        </div>
                    </div>

                    <!-- Brand Form Fields -->
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                        <div class="mb-3">
                            <label for="createBrandName" class="form-label fw-bold small text-dark">Brand Name <span class="text-danger">*</span></label>
                            <input type="text" id="createBrandName" class="form-control" placeholder="e.g. Lucas, Hamko, Rahimafrooz..." required style="height: 42px; border-radius: 8px;" />
                        </div>

                        <div class="mb-0">
                            <label for="createBrandStatus" class="form-label fw-bold small text-dark">Status <span class="text-danger">*</span></label>
                            <select id="createBrandStatus" class="form-select unified-ui-border" required style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                <option value="Active" selected>Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                        <button type="button" class="btn px-4 py-2 fw-semibold text-white" data-bs-dismiss="modal" style="background-color: #dc2626 !important; color: #ffffff !important; border-radius: 8px; border: none !important;">Cancel</button>
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="background-color: #15803d; border-radius: 8px; border: none;">
                            <i class="fa-solid fa-check me-1"></i> Save Brand
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Brand Modal -->
<div class="modal fade" id="brandUpdateModal" tabindex="-1" aria-labelledby="brandUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white px-4 py-3" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2 m-0 text-white" id="brandUpdateModalLabel" style="color: #ffffff !important;">
                    <i class="fa-solid fa-pen-to-square text-white" style="color: #ffffff !important;"></i>
                    <span class="text-white" style="color: #ffffff !important;">Edit Brand</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <form id="updateBrandForm" onsubmit="updateBatteryBrand(event)">
                    <input type="hidden" id="updateBrandId">
                    <!-- Logo Upload Container -->
                    <div class="card border-0 shadow-sm rounded-3 p-3 mb-3 text-center bg-white">
                        <div class="d-inline-block position-relative mb-2">
                            <img id="updateBrandPreview" src="{{ asset('backend/assets/img/brand-defult-img.svg') }}" alt="Brand Logo Preview" style="width: 85px; height: 85px; object-fit: contain; border-radius: 12px; border: 2px dashed #86efac; padding: 4px; background: #f0fdf4;" />
                        </div>
                        <div>
                            <label for="updateBrandImage" class="btn btn-sm btn-outline-success fw-bold px-3 py-1" style="border-radius: 6px; cursor: pointer; font-size: 12px;">
                                <i class="fa-solid fa-upload me-1"></i> Replace Logo
                            </label>
                            <input type="file" id="updateBrandImage" class="d-none" accept="image/*" />
                            <div class="text-muted small mt-1" style="font-size: 11px;">PNG, JPG or GIF (Max 1MB)</div>
                        </div>
                    </div>

                    <!-- Brand Form Fields -->
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                        <div class="mb-3">
                            <label for="updateBrandName" class="form-label fw-bold small text-dark">Brand Name <span class="text-danger">*</span></label>
                            <input type="text" id="updateBrandName" class="form-control" required style="height: 42px; border-radius: 8px;" />
                        </div>

                        <div class="mb-0">
                            <label for="updateBrandStatus" class="form-label fw-bold small text-dark">Status <span class="text-danger">*</span></label>
                            <select id="updateBrandStatus" class="form-select unified-ui-border" required style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                <option value="Active">Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                        <button type="button" class="btn px-4 py-2 fw-semibold text-white" data-bs-dismiss="modal" style="background-color: #dc2626 !important; color: #ffffff !important; border-radius: 8px; border: none !important;">Cancel</button>
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="background-color: #15803d; border-radius: 8px; border: none;">
                            <i class="fa-solid fa-check me-1"></i> Update Brand
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Brand Modal -->
<div class="modal fade" id="brandDeleteModal" tabindex="-1" aria-labelledby="brandDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 shadow-lg text-center p-4" style="border-radius: 16px;">
            <div class="text-danger mb-3">
                <i class="fa-solid fa-triangle-exclamation" style="font-size: 48px;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Are you sure?</h5>
            <p class="text-muted small mb-4">Are you sure you want to delete this battery brand? This action cannot be undone.</p>
            <input type="hidden" id="deleteBrandId" />
            <div class="d-flex align-items-center justify-content-center gap-2">
                <button type="button" class="btn btn-secondary px-4 py-2 fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                <button type="button" onclick="confirmDeleteBatteryBrand()" class="btn btn-danger px-4 py-2 fw-bold" style="border-radius: 8px;">
                    <i class="fa-solid fa-trash me-1"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let rawBrandData = [];
    let currentPage = 1;
    let pageSize = 15;

    document.addEventListener("DOMContentLoaded", function() {
        getBatteryBrandList();

        $('#createBrandImage').on('change', function() {
            previewImage(this, '#createBrandPreview');
        });
        $('#updateBrandImage').on('change', function() {
            previewImage(this, '#updateBrandPreview');
        });

        $('#searchInput').on('input', function() { currentPage = 1; renderBrands(); });
        $('#filterStatus').on('change', function() { currentPage = 1; renderBrands(); });
        $('#entries').on('change', function() { pageSize = parseInt(this.value) || 15; currentPage = 1; renderBrands(); });
    });

    function previewImage(input, target) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => $(target).attr('src', e.target.result);
            reader.readAsDataURL(input.files[0]);
        }
    }

    async function getBatteryBrandList() {
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.get("/api/battery/brand-list", HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                rawBrandData = res.data.BrandData || [];
                rawBrandData.sort((a, b) => (b.id || 0) - (a.id || 0));
                renderBrands();
            } else {
                rawBrandData = [];
                renderBrands();
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            errorToast("Failed to load battery brands");
        }
    }

    function renderBrands() {
        const search = ($('#searchInput').val() || '').toLowerCase().trim();
        const status = $('#filterStatus').val();

        const filtered = rawBrandData.filter(item => {
            const matchesSearch = (item.name || '').toLowerCase().includes(search);
            const matchesStatus = !status || item.status === status;
            return matchesSearch && matchesStatus;
        });

        const total = filtered.length;
        const totalPages = Math.ceil(total / pageSize) || 1;
        if (currentPage > totalPages) currentPage = 1;

        const start = (currentPage - 1) * pageSize;
        const pageItems = filtered.slice(start, start + pageSize);

        const tbody = document.getElementById('brandTableBody');
        const mobileContainer = document.getElementById('mobileCardList');
        tbody.innerHTML = '';
        if (mobileContainer) mobileContainer.innerHTML = '';

        if (pageItems.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center py-8 text-slate-400 font-medium">No battery brands found.</td></tr>`;
            if (mobileContainer) mobileContainer.innerHTML = `<div class="p-6 text-center text-slate-400 font-medium bg-white dark:bg-slate-800 rounded-xl unified-ui-border">No battery brands found.</div>`;
        } else {
            pageItems.forEach((b, idx) => {
                const sl = start + idx + 1;
                const statusBadge = b.status === 'Active'
                    ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Active</span>'
                    : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300">Inactive</span>';

                const imgUrl = b.img_url ? (b.img_url.startsWith('http') ? b.img_url : `/${b.img_url}`) : "{{ asset('backend/assets/img/brand-defult-img.svg') }}";

                // Desktop Table Row
                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="p-[10px] text-center text-slate-500 font-medium">${sl}</td>
                        <td class="p-[10px] text-center">
                            <div class="w-10 h-10 rounded-lg border border-slate-200 dark:border-slate-700 bg-white p-0.5 flex items-center justify-center mx-auto overflow-hidden shadow-sm">
                                <img src="${imgUrl}" class="w-full h-full object-contain" onerror="this.src='{{ asset('backend/assets/img/brand-defult-img.svg') }}'">
                            </div>
                        </td>
                        <td class="p-[10px] text-start font-semibold text-slate-800 dark:text-slate-100">${b.name}</td>
                        <td class="p-[10px] text-center">${statusBadge}</td>
                        <td class="p-[10px] text-center">
                            <div class="inline-flex items-center gap-1.5 justify-center">
                                <button onclick="openEditBrandModal(${b.id})" class="action-btn action-btn-edit edit-link w-[32px] h-[32px] rounded-lg inline-flex items-center justify-center bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:text-emerald-400 transition-colors" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button onclick="openDeleteBrandModal(${b.id})" class="action-btn action-btn-delete delete-link w-[32px] h-[32px] rounded-lg inline-flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-100 dark:bg-rose-950/40 dark:text-rose-400 transition-colors" title="Delete">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;

                // Mobile Card View
                if (mobileContainer) {
                    mobileContainer.innerHTML += `
                        <div class="unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800 shadow-sm flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl border border-slate-200 dark:border-slate-700 bg-white p-1 flex items-center justify-center overflow-hidden shrink-0">
                                    <img src="${imgUrl}" class="w-full h-full object-contain" onerror="this.src='{{ asset('backend/assets/img/brand-defult-img.svg') }}'">
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800 dark:text-slate-100 text-sm">${b.name}</div>
                                    <div class="mt-1">${statusBadge}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button onclick="openEditBrandModal(${b.id})" class="action-btn action-btn-edit edit-link w-[32px] h-[32px] rounded-lg inline-flex items-center justify-center bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:text-emerald-400" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button onclick="openDeleteBrandModal(${b.id})" class="action-btn action-btn-delete delete-link w-[32px] h-[32px] rounded-lg inline-flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-100 dark:bg-rose-950/40 dark:text-rose-400" title="Delete">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </div>
                    `;
                }
            });
        }

        // Info & Pagination
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
        renderBrands();
    }

    async function saveBatteryBrand(e) {
        e.preventDefault();
        try {
            const name = $('#createBrandName').val().trim();
            const status = $('#createBrandStatus').val();
            const file = document.getElementById('createBrandImage').files[0];

            let formData = new FormData();
            formData.append('name', name);
            formData.append('status', status);
            if (file) formData.append('img_url', file);

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/create-brand', formData, {
                headers: { 'Content-Type': 'multipart/form-data', ...HeaderToken().headers }
            });
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Battery Brand created successfully');
                $('#brandCreateModal').modal('hide');
                $('#createBrandForm')[0].reset();
                $('#createBrandPreview').attr('src', "{{ asset('backend/assets/img/brand-defult-img.svg') }}");
                getBatteryBrandList();
            } else {
                errorToast(res.data.message || 'Failed to create brand');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to save battery brand');
        }
    }

    function openEditBrandModal(id) {
        const b = rawBrandData.find(item => item.id == id);
        if (!b) return;

        $('#updateBrandId').val(b.id);
        $('#updateBrandName').val(b.name);
        $('#updateBrandStatus').val(b.status);
        const imgUrl = b.img_url ? (b.img_url.startsWith('http') ? b.img_url : `/${b.img_url}`) : "{{ asset('backend/assets/img/brand-defult-img.svg') }}";
        $('#updateBrandPreview').attr('src', imgUrl);
        $('#updateBrandImage').val('');

        $('#brandUpdateModal').modal('show');
    }

    async function updateBatteryBrand(e) {
        e.preventDefault();
        try {
            const id = $('#updateBrandId').val();
            const name = $('#updateBrandName').val().trim();
            const status = $('#updateBrandStatus').val();
            const file = document.getElementById('updateBrandImage').files[0];

            let formData = new FormData();
            formData.append('id', id);
            formData.append('name', name);
            formData.append('status', status);
            if (file) formData.append('img_url', file);

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/update-brand', formData, {
                headers: { 'Content-Type': 'multipart/form-data', ...HeaderToken().headers }
            });
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Battery Brand updated successfully');
                $('#brandUpdateModal').modal('hide');
                getBatteryBrandList();
            } else {
                errorToast(res.data.message || 'Failed to update brand');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to update battery brand');
        }
    }

    function openDeleteBrandModal(id) {
        $('#deleteBrandId').val(id);
        $('#brandDeleteModal').modal('show');
    }

    async function confirmDeleteBatteryBrand() {
        const id = $('#deleteBrandId').val();
        if (!id) return;

        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/delete-brand', { id: id }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Battery Brand deleted successfully');
                $('#brandDeleteModal').modal('hide');
                getBatteryBrandList();
            } else {
                errorToast(res.data.message || 'Failed to delete brand');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to delete battery brand');
        }
    }
</script>

@endsection
