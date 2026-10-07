@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Products - MARSS CORPORATION')
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

    @media (min-width: 768px) {
        .controls-row-wrapper {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 12px !important;
        }
    }

    @media (max-width: 767px) {
        .controls-row-wrapper {
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
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
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Battery Product List</h1>
                        </div>

                        <!-- Right Controls -->
                        <div class="flex items-center flex-wrap gap-2">
                            <a href="{{ route('battery.barcode.generate') }}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] min-h-[38px] max-h-[38px] bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-200 text-xs font-semibold rounded-xl border border-slate-300 dark:border-slate-700 transition-all">
                                <i class="fa-solid fa-barcode text-sm"></i>
                                <span>Barcode Print</span>
                            </a>
                            <button id="openModalBtns" type="button" data-bs-toggle="modal" data-bs-target="#productCreateModal" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Add Product</span>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Controls & Filter Row -->
                    <div class="controls-row-wrapper mb-4 w-full">
                        <!-- Group 1: Search + Show Entries -->
                        <div class="flex items-center gap-2 sm:gap-2.5 w-full md:w-auto flex-1">
                            <div class="search-input-wrapper unified-ui-border flex-1 md:w-[260px] lg:w-[320px] h-[38px] flex items-center px-3 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                                <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search Product, Barcode..." />
                            </div>

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

                        <!-- Group 2: Filters -->
                        <div class="flex items-center gap-2 sm:gap-2.5 w-full md:w-auto">
                            <select id="filterBrand" class="unified-ui-border px-3 h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-sm text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-200 cursor-pointer hover:border-emerald-500 transition-all flex-1 md:w-[150px]">
                                <option value="">All Brands</option>
                            </select>

                            <select id="filterCategory" class="unified-ui-border px-3 h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-sm text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-200 cursor-pointer hover:border-emerald-500 transition-all flex-1 md:w-[160px]">
                                <option value="">All Categories</option>
                            </select>
                        </div>
                    </div>

                    <!-- 3. Desktop Table -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900 mb-4">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[45px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                    <th class="p-[10px] text-center w-[55px] whitespace-nowrap">Image</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Product Name</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Barcode</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Brand / Category</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Cost (৳)</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Price (৳)</th>
                                    <th class="p-[10px] text-center whitespace-nowrap">Stock</th>
                                    <th class="p-[10px] text-center w-[90px] whitespace-nowrap">Status</th>
                                    <th class="p-[10px] text-center w-[85px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="productTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                                <tr>
                                    <td colspan="10" class="text-center py-6 text-slate-400">Loading battery products...</td>
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

<!-- Create Product Modal -->
<div class="modal fade" id="productCreateModal" tabindex="-1" aria-labelledby="productCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white px-4 py-3" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2 m-0 text-white" id="productCreateModalLabel" style="color: #ffffff !important;">
                    <i class="fa-solid fa-boxes-stacked text-white" style="color: #ffffff !important;"></i>
                    <span class="text-white" style="color: #ffffff !important;">Add Battery Product</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <form id="createProductForm" onsubmit="saveBatteryProduct(event)">
                    <!-- Form Fields Card -->
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white mb-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="createProductName" class="form-label fw-bold small text-dark">Product Name <span class="text-danger">*</span></label>
                                <input type="text" id="createProductName" required placeholder="e.g. Lucas Super 150Ah Tubular Battery" class="form-control" style="height: 42px; border-radius: 8px;">
                            </div>
                            <div class="col-md-6">
                                <label for="createProductCode" class="form-label fw-bold small text-dark">Barcode / Code</label>
                                <input type="text" id="createProductCode" placeholder="Scan or enter barcode" class="form-control" style="height: 42px; border-radius: 8px;">
                            </div>
                            <div class="col-md-4">
                                <label for="createProductBrand" class="form-label fw-bold small text-dark">Brand</label>
                                <select id="createProductBrand" class="form-select unified-ui-border" style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                    <option value="">Select Brand</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="createProductCategory" class="form-label fw-bold small text-dark">Category</label>
                                <select id="createProductCategory" onchange="onCategoryChanged('create')" class="form-select unified-ui-border" style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="createProductSubCategory" class="form-label fw-bold small text-dark">Sub-Category</label>
                                <select id="createProductSubCategory" class="form-select unified-ui-border" style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                    <option value="">Select Sub-Category</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="createProductUnit" class="form-label fw-bold small text-dark">Unit</label>
                                <select id="createProductUnit" class="form-select unified-ui-border" style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                    <option value="">Select Unit</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="createProductCost" class="form-label fw-bold small text-dark">Cost Price (৳) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" id="createProductCost" required placeholder="0.00" class="form-control" style="height: 42px; border-radius: 8px;">
                            </div>
                            <div class="col-md-4">
                                <label for="createProductSell" class="form-label fw-bold small text-dark">Selling Price (৳) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" id="createProductSell" required placeholder="0.00" class="form-control" style="height: 42px; border-radius: 8px;">
                            </div>
                            <div class="col-md-4">
                                <label for="createProductQty" class="form-label fw-bold small text-dark">Initial Stock</label>
                                <input type="number" step="1" id="createProductQty" value="0" class="form-control" style="height: 42px; border-radius: 8px;">
                            </div>
                            <div class="col-md-4">
                                <label for="createProductStatus" class="form-label fw-bold small text-dark">Status</label>
                                <select id="createProductStatus" class="form-select unified-ui-border" style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                    <option value="Active">Active</option>
                                    <option value="InActive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="createProductImage" class="form-label fw-bold small text-dark">Product Image</label>
                                <input type="file" id="createProductImage" accept="image/*" class="form-control" style="height: 42px; border-radius: 8px;">
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                        <button type="button" class="btn px-4 py-2 fw-semibold text-white" data-bs-dismiss="modal" style="background-color: #dc2626 !important; color: #ffffff !important; border-radius: 8px; border: none !important;">Cancel</button>
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="background-color: #15803d; border-radius: 8px; border: none;">
                            <i class="fa-solid fa-check me-1"></i> Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="productUpdateModal" tabindex="-1" aria-labelledby="productUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white px-4 py-3" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2 m-0 text-white" id="productUpdateModalLabel" style="color: #ffffff !important;">
                    <i class="fa-solid fa-pen-to-square text-white" style="color: #ffffff !important;"></i>
                    <span class="text-white" style="color: #ffffff !important;">Edit Battery Product</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <form id="updateProductForm" onsubmit="updateBatteryProduct(event)">
                    <input type="hidden" id="updateProductId">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white mb-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="updateProductName" class="form-label fw-bold small text-dark">Product Name <span class="text-danger">*</span></label>
                                <input type="text" id="updateProductName" required class="form-control" style="height: 42px; border-radius: 8px;">
                            </div>
                            <div class="col-md-6">
                                <label for="updateProductCode" class="form-label fw-bold small text-dark">Barcode / Code</label>
                                <input type="text" id="updateProductCode" class="form-control" style="height: 42px; border-radius: 8px;">
                            </div>
                            <div class="col-md-4">
                                <label for="updateProductBrand" class="form-label fw-bold small text-dark">Brand</label>
                                <select id="updateProductBrand" class="form-select unified-ui-border" style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                    <option value="">Select Brand</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="updateProductCategory" class="form-label fw-bold small text-dark">Category</label>
                                <select id="updateProductCategory" onchange="onCategoryChanged('update')" class="form-select unified-ui-border" style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="updateProductSubCategory" class="form-label fw-bold small text-dark">Sub-Category</label>
                                <select id="updateProductSubCategory" class="form-select unified-ui-border" style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                    <option value="">Select Sub-Category</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="updateProductUnit" class="form-label fw-bold small text-dark">Unit</label>
                                <select id="updateProductUnit" class="form-select unified-ui-border" style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                    <option value="">Select Unit</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="updateProductCost" class="form-label fw-bold small text-dark">Cost Price (৳) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" id="updateProductCost" required class="form-control" style="height: 42px; border-radius: 8px;">
                            </div>
                            <div class="col-md-4">
                                <label for="updateProductSell" class="form-label fw-bold small text-dark">Selling Price (৳) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" id="updateProductSell" required class="form-control" style="height: 42px; border-radius: 8px;">
                            </div>
                            <div class="col-md-4">
                                <label for="updateProductQty" class="form-label fw-bold small text-dark">Stock Quantity</label>
                                <input type="number" step="1" id="updateProductQty" class="form-control" style="height: 42px; border-radius: 8px;">
                            </div>
                            <div class="col-md-4">
                                <label for="updateProductStatus" class="form-label fw-bold small text-dark">Status</label>
                                <select id="updateProductStatus" class="form-select unified-ui-border" style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                    <option value="Active">Active</option>
                                    <option value="InActive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="updateProductImage" class="form-label fw-bold small text-dark">Replace Image</label>
                                <input type="file" id="updateProductImage" accept="image/*" class="form-control" style="height: 42px; border-radius: 8px;">
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                        <button type="button" class="btn px-4 py-2 fw-semibold text-white" data-bs-dismiss="modal" style="background-color: #dc2626 !important; color: #ffffff !important; border-radius: 8px; border: none !important;">Cancel</button>
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="background-color: #15803d; border-radius: 8px; border: none;">
                            <i class="fa-solid fa-check me-1"></i> Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Product Modal -->
<div class="modal fade" id="productDeleteModal" tabindex="-1" aria-labelledby="productDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 shadow-lg text-center p-4" style="border-radius: 16px;">
            <div class="text-danger mb-3">
                <i class="fa-solid fa-triangle-exclamation" style="font-size: 48px;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Are you sure?</h5>
            <p class="text-muted small mb-4">Are you sure you want to delete this battery product? This action cannot be undone.</p>
            <input type="hidden" id="deleteProductId" />
            <div class="d-flex align-items-center justify-content-center gap-2">
                <button type="button" class="btn btn-secondary px-4 py-2 fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                <button type="button" onclick="confirmDeleteBatteryProduct()" class="btn btn-danger px-4 py-2 fw-bold" style="border-radius: 8px;">
                    <i class="fa-solid fa-trash me-1"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let rawProductData = [];
    let brandsList = [];
    let categoriesList = [];
    let subCategoriesList = [];
    let unitsList = [];
    let currentPage = 1;
    let pageSize = 15;

    document.addEventListener("DOMContentLoaded", function() {
        loadFilterOptions();
        getBatteryProductList();

        $('#searchInput').on('input', function() { currentPage = 1; renderProducts(); });
        $('#filterBrand').on('change', function() { currentPage = 1; renderProducts(); });
        $('#filterCategory').on('change', function() { currentPage = 1; renderProducts(); });
        $('#entries').on('change', function() { pageSize = parseInt(this.value) || 15; currentPage = 1; renderProducts(); });
    });

    async function loadFilterOptions() {
        try {
            const [bRes, cRes, scRes, uRes] = await Promise.all([
                axios.get('/api/battery/brand-list', HeaderToken()),
                axios.get('/api/battery/category-list', HeaderToken()),
                axios.get('/api/battery/sub-category-list', HeaderToken()),
                axios.get('/api/battery/unit-list', HeaderToken())
            ]);

            brandsList = bRes.data?.BrandData || [];
            categoriesList = cRes.data?.CategoryData || [];
            subCategoriesList = scRes.data?.SubCategoryData || [];
            unitsList = uRes.data?.units || [];

            // Populate Brand Dropdowns
            let bOptions = '<option value="">All Brands</option>';
            let bModal = '<option value="">Select Brand</option>';
            brandsList.forEach(b => {
                bOptions += `<option value="${b.id}">${b.name}</option>`;
                bModal += `<option value="${b.id}">${b.name}</option>`;
            });
            $('#filterBrand').html(bOptions);
            $('#createProductBrand').html(bModal);
            $('#updateProductBrand').html(bModal);

            // Populate Category Dropdowns
            let cOptions = '<option value="">All Categories</option>';
            let cModal = '<option value="">Select Category</option>';
            categoriesList.forEach(c => {
                cOptions += `<option value="${c.id}">${c.name}</option>`;
                cModal += `<option value="${c.id}">${c.name}</option>`;
            });
            $('#filterCategory').html(cOptions);
            $('#createProductCategory').html(cModal);
            $('#updateProductCategory').html(cModal);

            // Populate Unit Dropdowns
            let uModal = '<option value="">Select Unit</option>';
            unitsList.forEach(u => {
                uModal += `<option value="${u.name}">${u.name} (${u.code || ''})</option>`;
            });
            $('#createProductUnit').html(uModal);
            $('#updateProductUnit').html(uModal);

        } catch (e) {
            console.error('Filter options load error:', e);
        }
    }

    function onCategoryChanged(mode) {
        const catId = mode === 'create' ? $('#createProductCategory').val() : $('#updateProductCategory').val();
        const target = mode === 'create' ? $('#createProductSubCategory') : $('#updateProductSubCategory');

        const filtered = subCategoriesList.filter(sc => sc.category_id == catId);
        let opts = '<option value="">Select Sub-Category</option>';
        filtered.forEach(sc => {
            opts += `<option value="${sc.id}">${sc.name}</option>`;
        });
        target.html(opts);
    }

    async function getBatteryProductList() {
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.get('/api/battery/product-list', HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                rawProductData = res.data.data || [];
                rawProductData.sort((a, b) => (b.id || 0) - (a.id || 0));
                renderProducts();
            } else {
                rawProductData = [];
                renderProducts();
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            errorToast('Failed to load battery products');
        }
    }

    function renderProducts() {
        const search = ($('#searchInput').val() || '').toLowerCase().trim();
        const brandId = $('#filterBrand').val();
        const catId = $('#filterCategory').val();

        const filtered = rawProductData.filter(item => {
            const matchesSearch = (item.name || '').toLowerCase().includes(search)
                || (item.code || '').toLowerCase().includes(search);
            const matchesBrand = !brandId || item.brand_id == brandId;
            const matchesCat = !catId || item.category_id == catId;
            return matchesSearch && matchesBrand && matchesCat;
        });

        const total = filtered.length;
        const totalPages = Math.ceil(total / pageSize) || 1;
        if (currentPage > totalPages) currentPage = 1;

        const start = (currentPage - 1) * pageSize;
        const pageItems = filtered.slice(start, start + pageSize);

        const tbody = document.getElementById('productTableBody');
        const mobileContainer = document.getElementById('mobileCardList');
        tbody.innerHTML = '';
        if (mobileContainer) mobileContainer.innerHTML = '';

        if (pageItems.length === 0) {
            tbody.innerHTML = `<tr><td colspan="10" class="text-center py-8 text-slate-400 font-medium">No battery products found.</td></tr>`;
            if (mobileContainer) mobileContainer.innerHTML = `<div class="p-6 text-center text-slate-400 font-medium bg-white dark:bg-slate-800 rounded-xl unified-ui-border">No battery products found.</div>`;
        } else {
            pageItems.forEach((p, idx) => {
                const sl = start + idx + 1;
                const statusBadge = (p.status === 'Active' || !p.status)
                    ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Active</span>'
                    : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300">Inactive</span>';

                const imgUrl = p.img_url ? (p.img_url.startsWith('http') ? p.img_url : `/${p.img_url}`) : "{{ asset('backend/assets/img/product-default.png') }}";
                const brandName = p.brand ? p.brand.name : (brandsList.find(b => b.id == p.brand_id)?.name || '—');
                const catName = p.category ? p.category.name : (categoriesList.find(c => c.id == p.category_id)?.name || '—');

                const stockBadge = (p.quantity || 0) <= 0
                    ? `<span class="inline-flex items-center px-2 py-0.5 rounded font-bold text-xs bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-400">${p.quantity || 0}</span>`
                    : (p.quantity <= 5
                        ? `<span class="inline-flex items-center px-2 py-0.5 rounded font-bold text-xs bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-400">${p.quantity}</span>`
                        : `<span class="inline-flex items-center px-2 py-0.5 rounded font-bold text-xs bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200">${p.quantity}</span>`);

                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="p-[10px] text-center text-slate-500 font-medium">${sl}</td>
                        <td class="p-[10px] text-center">
                            <div class="w-10 h-10 rounded-lg border border-slate-200 dark:border-slate-700 bg-white p-0.5 flex items-center justify-center mx-auto overflow-hidden shadow-sm">
                                <img src="${imgUrl}" class="w-full h-full object-contain" onerror="this.src='{{ asset('backend/assets/img/product-default.png') }}'">
                            </div>
                        </td>
                        <td class="p-[10px] text-start font-semibold text-slate-800 dark:text-slate-100">${p.name}</td>
                        <td class="p-[10px] text-start font-mono text-xs text-slate-600 dark:text-slate-300 font-bold">${p.code || '—'}</td>
                        <td class="p-[10px] text-start text-xs text-slate-600 dark:text-slate-300">
                            <div><span class="font-bold text-emerald-700 dark:text-emerald-400">${brandName}</span></div>
                            <div class="text-[11px] text-slate-400">${catName}</div>
                        </td>
                        <td class="p-[10px] text-end font-mono text-xs font-semibold text-slate-700 dark:text-slate-300">৳${parseFloat(p.cost_price || 0).toFixed(2)}</td>
                        <td class="p-[10px] text-end font-mono text-xs font-bold text-emerald-600 dark:text-emerald-400">৳${parseFloat(p.price || 0).toFixed(2)}</td>
                        <td class="p-[10px] text-center">${stockBadge}</td>
                        <td class="p-[10px] text-center">${statusBadge}</td>
                        <td class="p-[10px] text-center">
                            <div class="inline-flex items-center gap-1.5 justify-center">
                                <button onclick="openEditProductModal(${p.id})" class="action-btn action-btn-edit edit-link w-[32px] h-[32px] rounded-lg inline-flex items-center justify-center bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:text-emerald-400 transition-colors" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button onclick="openDeleteProductModal(${p.id})" class="action-btn action-btn-delete delete-link w-[32px] h-[32px] rounded-lg inline-flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-100 dark:bg-rose-950/40 dark:text-rose-400 transition-colors" title="Delete">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;

                if (mobileContainer) {
                    mobileContainer.innerHTML += `
                        <div class="unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800 shadow-sm flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl border border-slate-200 dark:border-slate-700 bg-white p-1 flex items-center justify-center overflow-hidden shrink-0">
                                    <img src="${imgUrl}" class="w-full h-full object-contain" onerror="this.src='{{ asset('backend/assets/img/product-default.png') }}'">
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800 dark:text-slate-100 text-sm">${p.name}</div>
                                    <div class="text-xs text-slate-500">${brandName} | Code: <span class="font-mono">${p.code || '—'}</span></div>
                                    <div class="text-xs font-bold text-emerald-600 mt-0.5">৳${parseFloat(p.price || 0).toFixed(2)} | Stock: ${p.quantity || 0}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button onclick="openEditProductModal(${p.id})" class="action-btn action-btn-edit edit-link w-[32px] h-[32px] rounded-lg inline-flex items-center justify-center bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:text-emerald-400" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button onclick="openDeleteProductModal(${p.id})" class="action-btn action-btn-delete delete-link w-[32px] h-[32px] rounded-lg inline-flex items-center justify-center bg-rose-50 text-rose-600 hover:bg-rose-100 dark:bg-rose-950/40 dark:text-rose-400" title="Delete">
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
        renderProducts();
    }

    async function saveBatteryProduct(e) {
        e.preventDefault();
        try {
            const form = document.getElementById('createProductForm');
            let formData = new FormData();
            formData.append('name', $('#createProductName').val().trim());
            formData.append('code', $('#createProductCode').val().trim());
            formData.append('brand_id', $('#createProductBrand').val() || '');
            formData.append('category_id', $('#createProductCategory').val() || '');
            formData.append('sub_category_id', $('#createProductSubCategory').val() || '');
            formData.append('unit', $('#createProductUnit').val() || '');
            formData.append('cost_price', $('#createProductCost').val());
            formData.append('price', $('#createProductSell').val());
            formData.append('quantity', $('#createProductQty').val() || '0');
            formData.append('status', $('#createProductStatus').val());

            const file = document.getElementById('createProductImage').files[0];
            if (file) formData.append('img_url', file);

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/create-product', formData, {
                headers: { 'Content-Type': 'multipart/form-data', ...HeaderToken().headers }
            });
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Battery Product created successfully');
                $('#productCreateModal').modal('hide');
                form.reset();
                getBatteryProductList();
            } else {
                errorToast(res.data.message || 'Failed to create product');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to save product');
        }
    }

    function openEditProductModal(id) {
        const p = rawProductData.find(item => item.id == id);
        if (!p) return;

        $('#updateProductId').val(p.id);
        $('#updateProductName').val(p.name);
        $('#updateProductCode').val(p.code || '');
        $('#updateProductBrand').val(p.brand_id || '');
        $('#updateProductCategory').val(p.category_id || '');
        onCategoryChanged('update');
        $('#updateProductSubCategory').val(p.sub_category_id || '');
        $('#updateProductUnit').val(p.unit || '');
        $('#updateProductCost').val(p.cost_price || 0);
        $('#updateProductSell').val(p.price || 0);
        $('#updateProductQty').val(p.quantity || 0);
        $('#updateProductStatus').val(p.status || 'Active');
        $('#updateProductImage').val('');

        $('#productUpdateModal').modal('show');
    }

    async function updateBatteryProduct(e) {
        e.preventDefault();
        try {
            const id = $('#updateProductId').val();
            let formData = new FormData();
            formData.append('id', id);
            formData.append('name', $('#updateProductName').val().trim());
            formData.append('code', $('#updateProductCode').val().trim());
            formData.append('brand_id', $('#updateProductBrand').val() || '');
            formData.append('category_id', $('#updateProductCategory').val() || '');
            formData.append('sub_category_id', $('#updateProductSubCategory').val() || '');
            formData.append('unit', $('#updateProductUnit').val() || '');
            formData.append('cost_price', $('#updateProductCost').val());
            formData.append('price', $('#updateProductSell').val());
            formData.append('quantity', $('#updateProductQty').val() || '0');
            formData.append('status', $('#updateProductStatus').val());

            const file = document.getElementById('updateProductImage').files[0];
            if (file) formData.append('img_url', file);

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/update-product', formData, {
                headers: { 'Content-Type': 'multipart/form-data', ...HeaderToken().headers }
            });
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Battery Product updated successfully');
                $('#productUpdateModal').modal('hide');
                getBatteryProductList();
            } else {
                errorToast(res.data.message || 'Failed to update product');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to update product');
        }
    }

    function openDeleteProductModal(id) {
        $('#deleteProductId').val(id);
        $('#productDeleteModal').modal('show');
    }

    async function confirmDeleteBatteryProduct() {
        const id = $('#deleteProductId').val();
        if (!id) return;

        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/delete-product', { id: id }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Battery Product deleted successfully');
                $('#productDeleteModal').modal('hide');
                getBatteryProductList();
            } else {
                errorToast(res.data.message || 'Failed to delete product');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to delete product');
        }
    }
</script>

@endsection
