@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Sub-Categories - MARSS CORPORATION')
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
                    
                    <!-- 1. Top Section: Page Title & Action Buttons -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="8" y1="6" x2="21" y2="6"></line>
                                    <line x1="8" y1="12" x2="21" y2="12"></line>
                                    <line x1="8" y1="18" x2="21" y2="18"></line>
                                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Battery Sub-Category List</h1>
                        </div>

                        <!-- Right Controls -->
                        <div class="flex items-center flex-wrap gap-2">
                            <button id="openModalBtns" type="button" data-bs-toggle="modal" data-bs-target="#subCategoryCreateModal" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Create Sub-Category</span>
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
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding-left: 4px !important; padding-right: 4px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search Battery Sub-Category..." />
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

                            <div class="filter-category-container">
                                <select id="filterCategory" class="unified-ui-border flex items-center px-3 sm:px-3.5 h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-sm text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-200 cursor-pointer hover:border-emerald-500 transition-all duration-150">
                                    <option value="">All Categories</option>
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
                                    <th class="p-[10px] text-start whitespace-nowrap">Sub-Category Name</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Parent Category</th>
                                    <th class="p-[10px] text-center w-[120px] whitespace-nowrap">Status</th>
                                    <th class="p-[10px] text-center w-[100px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="subCategoryTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-slate-400">Loading battery sub-categories...</td>
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

<!-- Create Sub-Category Modal -->
<div class="modal fade" id="subCategoryCreateModal" tabindex="-1" aria-labelledby="subCategoryCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white px-4 py-3" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2 m-0 text-white" id="subCategoryCreateModalLabel" style="color: #ffffff !important;">
                    <i class="fa-solid fa-sitemap text-white" style="color: #ffffff !important;"></i>
                    <span class="text-white" style="color: #ffffff !important;">Add New Sub-Category</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <form id="createSubCategoryForm" onsubmit="saveBatterySubCategory(event)">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                        <div class="mb-3">
                            <label for="createParentCategory" class="form-label fw-bold small text-dark">Parent Category <span class="text-danger">*</span></label>
                            <select id="createParentCategory" class="form-select unified-ui-border" required style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                <option value="">Select Category</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="createSubCategoryName" class="form-label fw-bold small text-dark">Sub-Category Name <span class="text-danger">*</span></label>
                            <input type="text" id="createSubCategoryName" class="form-control" placeholder="e.g. 100Ah, 150Ah, 200Ah..." required style="height: 42px; border-radius: 8px;" />
                        </div>

                        <div class="mb-0">
                            <label for="createSubCategoryStatus" class="form-label fw-bold small text-dark">Status <span class="text-danger">*</span></label>
                            <select id="createSubCategoryStatus" class="form-select unified-ui-border" required style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                <option value="Active" selected>Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                        <button type="button" class="btn px-4 py-2 fw-semibold text-white" data-bs-dismiss="modal" style="background-color: #dc2626 !important; color: #ffffff !important; border-radius: 8px; border: none !important;">Cancel</button>
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="background-color: #15803d; border-radius: 8px; border: none;">
                            <i class="fa-solid fa-check me-1"></i> Save Sub-Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Sub-Category Modal -->
<div class="modal fade" id="subCategoryUpdateModal" tabindex="-1" aria-labelledby="subCategoryUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white px-4 py-3" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2 m-0 text-white" id="subCategoryUpdateModalLabel" style="color: #ffffff !important;">
                    <i class="fa-solid fa-pen-to-square text-white" style="color: #ffffff !important;"></i>
                    <span class="text-white" style="color: #ffffff !important;">Edit Sub-Category</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <form id="updateSubCategoryForm" onsubmit="updateBatterySubCategory(event)">
                    <input type="hidden" id="updateSubCategoryId">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                        <div class="mb-3">
                            <label for="updateParentCategory" class="form-label fw-bold small text-dark">Parent Category <span class="text-danger">*</span></label>
                            <select id="updateParentCategory" class="form-select unified-ui-border" required style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                <option value="">Select Category</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="updateSubCategoryName" class="form-label fw-bold small text-dark">Sub-Category Name <span class="text-danger">*</span></label>
                            <input type="text" id="updateSubCategoryName" class="form-control" required style="height: 42px; border-radius: 8px;" />
                        </div>

                        <div class="mb-0">
                            <label for="updateSubCategoryStatus" class="form-label fw-bold small text-dark">Status <span class="text-danger">*</span></label>
                            <select id="updateSubCategoryStatus" class="form-select unified-ui-border" required style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                <option value="Active">Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                        <button type="button" class="btn px-4 py-2 fw-semibold text-white" data-bs-dismiss="modal" style="background-color: #dc2626 !important; color: #ffffff !important; border-radius: 8px; border: none !important;">Cancel</button>
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="background-color: #15803d; border-radius: 8px; border: none;">
                            <i class="fa-solid fa-check me-1"></i> Update Sub-Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Sub-Category Modal -->
<div class="modal fade" id="subCategoryDeleteModal" tabindex="-1" aria-labelledby="subCategoryDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 shadow-lg text-center p-4" style="border-radius: 16px;">
            <div class="text-danger mb-3">
                <i class="fa-solid fa-triangle-exclamation" style="font-size: 48px;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Are you sure?</h5>
            <p class="text-muted small mb-4">Are you sure you want to delete this sub-category? This action cannot be undone.</p>
            <input type="hidden" id="deleteSubCategoryId" />
            <div class="d-flex align-items-center justify-content-center gap-2">
                <button type="button" class="btn btn-secondary px-4 py-2 fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                <button type="button" onclick="confirmDeleteBatterySubCategory()" class="btn btn-danger px-4 py-2 fw-bold" style="border-radius: 8px;">
                    <i class="fa-solid fa-trash me-1"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let rawSubCategoryData = [];
    let rawCategoryList = [];
    let currentPage = 1;
    let pageSize = 15;

    document.addEventListener("DOMContentLoaded", function() {
        loadParentCategories();
        getBatterySubCategoryList();

        $('#searchInput').on('input', function() { currentPage = 1; renderSubCategories(); });
        $('#filterCategory').on('change', function() { currentPage = 1; renderSubCategories(); });
        $('#filterStatus').on('change', function() { currentPage = 1; renderSubCategories(); });
        $('#entries').on('change', function() { pageSize = parseInt(this.value) || 15; currentPage = 1; renderSubCategories(); });
    });

    async function loadParentCategories() {
        try {
            const res = await axios.get("/api/battery/category-list", HeaderToken());
            if (res.data && res.data.status === 'success') {
                rawCategoryList = res.data.CategoryData || [];
                let options = '<option value="">All Categories</option>';
                let modalOptions = '<option value="">Select Category</option>';
                rawCategoryList.forEach(c => {
                    options += `<option value="${c.id}">${c.name}</option>`;
                    modalOptions += `<option value="${c.id}">${c.name}</option>`;
                });
                $('#filterCategory').html(options);
                $('#createParentCategory').html(modalOptions);
                $('#updateParentCategory').html(modalOptions);
            }
        } catch (e) {
            console.error(e);
        }
    }

    async function getBatterySubCategoryList() {
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.get("/api/battery/sub-category-list", HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                rawSubCategoryData = res.data.SubCategoryData || [];
                rawSubCategoryData.sort((a, b) => (b.id || 0) - (a.id || 0));
                renderSubCategories();
            } else {
                rawSubCategoryData = [];
                renderSubCategories();
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            errorToast("Failed to load battery sub-categories");
        }
    }

    function renderSubCategories() {
        const search = ($('#searchInput').val() || '').toLowerCase().trim();
        const catId = $('#filterCategory').val();
        const status = $('#filterStatus').val();

        const filtered = rawSubCategoryData.filter(item => {
            const matchesSearch = (item.name || '').toLowerCase().includes(search);
            const matchesCat = !catId || item.category_id == catId;
            const matchesStatus = !status || item.status === status;
            return matchesSearch && matchesCat && matchesStatus;
        });

        const total = filtered.length;
        const totalPages = Math.ceil(total / pageSize) || 1;
        if (currentPage > totalPages) currentPage = 1;

        const start = (currentPage - 1) * pageSize;
        const pageItems = filtered.slice(start, start + pageSize);

        const tbody = document.getElementById('subCategoryTableBody');
        const mobileContainer = document.getElementById('mobileCardList');
        tbody.innerHTML = '';
        if (mobileContainer) mobileContainer.innerHTML = '';

        if (pageItems.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center py-8 text-slate-400 font-medium">No battery sub-categories found.</td></tr>`;
            if (mobileContainer) mobileContainer.innerHTML = `<div class="p-6 text-center text-slate-400 font-medium bg-white dark:bg-slate-800 rounded-xl unified-ui-border">No battery sub-categories found.</div>`;
        } else {
            pageItems.forEach((sc, idx) => {
                const sl = start + idx + 1;
                const statusBadge = sc.status === 'Active'
                    ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Active</span>'
                    : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300">Inactive</span>';

                const catName = sc.category ? sc.category.name : (rawCategoryList.find(c => c.id == sc.category_id)?.name || 'N/A');

                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="p-[10px] text-center text-slate-500 font-medium">${sl}</td>
                        <td class="p-[10px] text-start font-semibold text-slate-800 dark:text-slate-100">${sc.name}</td>
                        <td class="p-[10px] text-start text-slate-600 dark:text-slate-300">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-xs font-semibold">
                                <i class="fa-solid fa-folder text-emerald-600 text-[11px]"></i> ${catName}
                            </span>
                        </td>
                        <td class="p-[10px] text-center">${statusBadge}</td>
                        <td class="p-[10px] text-center">
                            <div class="inline-flex items-center gap-1.5 justify-center">
                                <button onclick="openEditSubCategoryModal(${sc.id})" class="action-btn action-btn-edit edit-link w-[32px] h-[32px] rounded-lg inline-flex items-center justify-center bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:text-emerald-400 transition-colors" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button onclick="openDeleteSubCategoryModal(${sc.id})" class="action-btn action-btn-delete delete-link w-[32px] h-[32px] rounded-lg inline-flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-100 dark:bg-rose-950/40 dark:text-rose-400 transition-colors" title="Delete">
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
                                <div class="font-bold text-slate-800 dark:text-slate-100 text-sm">${sc.name}</div>
                                <div class="text-xs text-slate-500 mt-0.5"><i class="fa-solid fa-folder text-emerald-600 text-[10px]"></i> ${catName}</div>
                                <div class="mt-1.5">${statusBadge}</div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button onclick="openEditSubCategoryModal(${sc.id})" class="action-btn action-btn-edit edit-link w-[32px] h-[32px] rounded-lg inline-flex items-center justify-center bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:text-emerald-400" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button onclick="openDeleteSubCategoryModal(${sc.id})" class="action-btn action-btn-delete delete-link w-[32px] h-[32px] rounded-lg inline-flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-100 dark:bg-rose-950/40 dark:text-rose-400" title="Delete">
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
        renderSubCategories();
    }

    async function saveBatterySubCategory(e) {
        e.preventDefault();
        try {
            const category_id = $('#createParentCategory').val();
            const name = $('#createSubCategoryName').val().trim();
            const status = $('#createSubCategoryStatus').val();

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/create-sub-category', {
                category_id: category_id,
                name: name,
                status: status
            }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Battery Sub-Category created successfully');
                $('#subCategoryCreateModal').modal('hide');
                $('#createSubCategoryForm')[0].reset();
                getBatterySubCategoryList();
            } else {
                errorToast(res.data.message || 'Failed to create sub-category');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to save sub-category');
        }
    }

    function openEditSubCategoryModal(id) {
        const sc = rawSubCategoryData.find(item => item.id == id);
        if (!sc) return;

        $('#updateSubCategoryId').val(sc.id);
        $('#updateParentCategory').val(sc.category_id);
        $('#updateSubCategoryName').val(sc.name);
        $('#updateSubCategoryStatus').val(sc.status);

        $('#subCategoryUpdateModal').modal('show');
    }

    async function updateBatterySubCategory(e) {
        e.preventDefault();
        try {
            const id = $('#updateSubCategoryId').val();
            const category_id = $('#updateParentCategory').val();
            const name = $('#updateSubCategoryName').val().trim();
            const status = $('#updateSubCategoryStatus').val();

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/update-sub-category', {
                id: id,
                category_id: category_id,
                name: name,
                status: status
            }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Battery Sub-Category updated successfully');
                $('#subCategoryUpdateModal').modal('hide');
                getBatterySubCategoryList();
            } else {
                errorToast(res.data.message || 'Failed to update sub-category');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to update sub-category');
        }
    }

    function openDeleteSubCategoryModal(id) {
        $('#deleteSubCategoryId').val(id);
        $('#subCategoryDeleteModal').modal('show');
    }

    async function confirmDeleteBatterySubCategory() {
        const id = $('#deleteSubCategoryId').val();
        if (!id) return;

        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/delete-sub-category', { id: id }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Battery Sub-Category deleted successfully');
                $('#subCategoryDeleteModal').modal('hide');
                getBatterySubCategoryList();
            } else {
                errorToast(res.data.message || 'Failed to delete sub-category');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to delete sub-category');
        }
    }
</script>

@endsection
