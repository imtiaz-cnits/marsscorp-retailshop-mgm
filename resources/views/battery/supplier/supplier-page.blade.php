@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Suppliers - MARSS CORPORATION')
@section('content')

<!-- Hero Main Content Start -->
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
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Supplier List</h1>
                        </div>

                        <!-- Right Controls: + Create Supplier Button -->
                        <div class="flex items-center flex-wrap gap-2">
                            <button id="openModalBtns" onclick="openSupplierCreateModal()" type="button" class="btn-create-supplier inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Create Supplier</span>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Controls & Filter Row: Desktop (Search big on left, Show Entries on right); Mobile (Row 1 Search, Row 2 Show Entries) -->
                    <div class="controls-row-wrapper mb-4 w-full">
                        <!-- Search Bar -->
                        <div class="search-input-wrapper unified-ui-border h-[38px] flex items-center bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding-left: 4px !important; padding-right: 4px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search Supplier..." />
                        </div>

                        <!-- Secondary Controls Group (Show Entries) -->
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
                        </div>
                    </div>

                    <!-- 3. Desktop Table (SL rounded-tl-2xl, Action rounded-tr-2xl, solid emerald header, single line, 10px padding) -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900 mb-4">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                    <th class="p-[10px] text-center w-[65px] whitespace-nowrap" style="width: 65px !important;">Image</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Supplier ID</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Name</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Company</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Payable Amount</th>
                                    <th class="p-[10px] text-center w-[100px] whitespace-nowrap">Status</th>
                                    <th class="p-[10px] text-center w-[90px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableList" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                                <tr>
                                    <td colspan="8" class="text-center py-6 text-slate-400">Loading battery suppliers...</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="bg-slate-50/80 dark:bg-slate-800/80 font-bold text-sm border-t border-slate-200 dark:border-slate-800">
                                    <td colspan="5" class="p-[10px] text-end font-bold text-slate-700 dark:text-slate-200">Total Payable:</td>
                                    <td id="totalPayableaamountPrice" class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap font-mono">৳ 0.00</td>
                                    <td colspan="2" class="p-[10px]"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- 4. Mobile Card List View (Shown on Mobile Screens < 768px) -->
                    <div id="mobileCardList" class="block md:hidden mb-3 space-y-3"></div>

                    <!-- 5. Modern Smart Pagination and Display Info Footer -->
                    <div class="flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-800 gap-3">
                        <div id="display-info" class="text-xs text-slate-500 dark:text-slate-400"></div>
                        <div id="pagination" class="flex items-center gap-1 sm:gap-1.5 flex-nowrap justify-center max-w-full overflow-x-auto pb-1"></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- 6. Sticky Bottom Copyright Section -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)] mt-auto">
            <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>

    </div>
</div>
<!-- Hero Main Content End -->

<!-- Create Supplier Modal (Matching Retail supplier-create.blade.php) -->
<div class="newbrand" id="supplierCreateModal" style="display: none;">
    <div class="newbrand-content" style="width: 650px; max-width: 95%; max-height: 90vh; margin: auto !important; position: relative !important; left: auto !important; top: auto !important; transform: none !important; border-radius: 16px; background: #fff; padding: 0; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.4); display: flex; flex-direction: column;">
        <!-- Sticky Green Header with White Text & Red Close Icon -->
        <div style="background-color: #15803d; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 10; border-top-left-radius: 16px; border-top-right-radius: 16px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-truck-field" style="color: #ffffff; font-size: 16px;"></i>
                <h2 style="font-size: 18px; font-weight: 700; color: #ffffff; margin: 0; padding: 0; line-height: 1.2;">Add New Supplier</h2>
            </div>
            <button type="button" onclick="closeSupplierCreateModal()" class="close-btn closes" style="width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #dc2626; color: #ffffff; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.15s ease;" title="Close">
                <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 14px;"></i>
            </button>
        </div>

        <!-- Scrollable Modal Body -->
        <div id="popup-modal" style="padding: 20px 24px; overflow-y: auto; flex: 1 1 auto; max-height: calc(90vh - 130px); text-align: left;">
            <form onsubmit="return SupplierDataSave(event)" id="supplierCreateForm">
                <div class="row">
                    <div class="col-lg-6 mb-2">
                        <label for="supplierName" class="form-label-title">Supplier Name <span style="color: #ef4444;">*</span></label>
                        <div class="form-row">
                            <input type="text" placeholder="Enter Supplier Name" id="supplierName" required class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label for="supplierMobile" class="form-label-title">Supplier Mobile <span style="color: #ef4444;">*</span></label>
                        <div class="form-row">
                            <input type="text" placeholder="Enter Supplier Mobile" id="supplierMobile" required class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label for="supplierCompany" class="form-label-title">Supplier Company</label>
                        <div class="form-row">
                            <input type="text" placeholder="Enter Supplier Company" id="supplierCompany" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label for="supplierAddress" class="form-label-title">Supplier Address</label>
                        <div class="form-row">
                            <input type="text" placeholder="Enter Supplier Address" id="supplierAddress" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label for="supplierPurchasePayableAmount" class="form-label-title">Opening Payable Amount</label>
                        <div class="form-row">
                            <input type="number" step="any" placeholder="0.00" id="supplierPurchasePayableAmount" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label for="supplierStatus" class="form-label-title">Status</label>
                        <div class="form-row">
                            <select class="form-select input-style" id="supplierStatus" style="cursor: pointer !important;">
                                <option value="Active" selected>Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Upload Photo -->
                    <div class="col-lg-12 mb-1">
                        <label class="form-label-title">Supplier Image</label>
                        <div class="upload-profile">
                            <div class="item" style="display: flex; align-items: center; gap: 14px;">
                                <div class="img-box" id="supplierCreateImgBox" style="width: 80px; height: 70px; min-width: 80px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1.5px dashed #cbd5e1;">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                </div>

                                <div class="profile-wrapper" style="flex: 1;">
                                    <label class="custom-file-input-wrapper" style="cursor: pointer; position: relative; width: 100%; height: 44px; border-radius: 8px; display: flex; justify-content: center; align-items: center; background: #f1f5f9; border: 1px solid #cbd5e1; font-size: 13px; font-weight: 600; color: #475569;">
                                        <span>Choose Photo</span>
                                        <input type="file" id="supplierImage" onchange="previewSupplierCreateImage(this)" accept="image/*" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer;" />
                                    </label>
                                    <p style="margin: 4px 0 0 0; font-size: 11px; color: #94a3b8;">PNG, JPEG or GIF (up to 2 MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sticky Bottom Footer with Submit Button -->
        <div style="padding: 12px 24px 16px; background: #ffffff; border-top: 1px solid #f1f5f9; flex-shrink: 0; position: sticky; bottom: 0; z-index: 10; display: flex; gap: 10px; justify-content: flex-end;" class="modal-footer-sticky">
            <button type="button" onclick="closeSupplierCreateModal()" class="btn px-4 py-2 font-semibold text-white" style="background-color: #dc2626 !important; color: #ffffff !important; border-radius: 8px; border: none !important; font-size: 14px;">Cancel</button>
            <button type="button" onclick="SupplierDataSave(event)" class="btn-save save-btn px-4 py-2" style="height: 40px !important; background-color: #15803d !important; color: #ffffff !important; border-radius: 8px !important; font-weight: 600 !important; font-size: 14px !important; border: none !important; cursor: pointer !important; display: flex; align-items: center; justify-content: center; gap: 6px;">
                <i class="fa-solid fa-check"></i> Submit
            </button>
        </div>
    </div>
</div>

<!-- Edit Supplier Modal (Matching Retail supplier-update.blade.php) -->
<div class="newbrand" id="supplierUpdateModal" style="display: none;">
    <div class="newbrand-content" style="width: 650px; max-width: 95%; max-height: 90vh; margin: auto !important; position: relative !important; left: auto !important; top: auto !important; transform: none !important; border-radius: 16px; background: #fff; padding: 0; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.4); display: flex; flex-direction: column;">
        <!-- Sticky Green Header -->
        <div style="background-color: #15803d; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 10; border-top-left-radius: 16px; border-top-right-radius: 16px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-pen-to-square" style="color: #ffffff; font-size: 16px;"></i>
                <h2 style="font-size: 18px; font-weight: 700; color: #ffffff; margin: 0; padding: 0; line-height: 1.2;">Edit Supplier</h2>
            </div>
            <button type="button" onclick="closeSupplierUpdateModal()" class="close-btn closes" style="width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #dc2626; color: #ffffff; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.15s ease;" title="Close">
                <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 14px;"></i>
            </button>
        </div>

        <!-- Scrollable Modal Body -->
        <div style="padding: 20px 24px; overflow-y: auto; flex: 1 1 auto; max-height: calc(90vh - 130px); text-align: left;">
            <form onsubmit="return SupplierDataUpdate(event)" id="supplierUpdateForm">
                <input type="hidden" id="updateSupplierId" />
                <div class="row">
                    <div class="col-lg-6 mb-2">
                        <label for="updateSupplierName" class="form-label-title">Supplier Name <span style="color: #ef4444;">*</span></label>
                        <div class="form-row">
                            <input type="text" id="updateSupplierName" required class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label for="updateSupplierMobile" class="form-label-title">Supplier Mobile <span style="color: #ef4444;">*</span></label>
                        <div class="form-row">
                            <input type="text" id="updateSupplierMobile" required class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label for="updateSupplierCompany" class="form-label-title">Supplier Company</label>
                        <div class="form-row">
                            <input type="text" id="updateSupplierCompany" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label for="updateSupplierAddress" class="form-label-title">Supplier Address</label>
                        <div class="form-row">
                            <input type="text" id="updateSupplierAddress" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label for="updateSupplierPurchasePayableAmount" class="form-label-title">Payable Amount</label>
                        <div class="form-row">
                            <input type="number" step="any" id="updateSupplierPurchasePayableAmount" class="form-control" />
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label for="updateSupplierStatus" class="form-label-title">Status</label>
                        <div class="form-row">
                            <select class="form-select input-style" id="updateSupplierStatus" style="cursor: pointer !important;">
                                <option value="Active">Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Upload Photo -->
                    <div class="col-lg-12 mb-1">
                        <label class="form-label-title">Supplier Image</label>
                        <div class="upload-profile">
                            <div class="item" style="display: flex; align-items: center; gap: 14px;">
                                <div class="img-box" id="supplierUpdateImgBox" style="width: 80px; height: 70px; min-width: 80px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1.5px dashed #cbd5e1;">
                                    <img id="updateImagePreview" src="{{ asset('backend/assets/img/demo-img.jpeg') }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='{{ asset('backend/assets/img/demo-img.jpeg') }}'" />
                                </div>

                                <div class="profile-wrapper" style="flex: 1;">
                                    <label class="custom-file-input-wrapper" style="cursor: pointer; position: relative; width: 100%; height: 44px; border-radius: 8px; display: flex; justify-content: center; align-items: center; background: #f1f5f9; border: 1px solid #cbd5e1; font-size: 13px; font-weight: 600; color: #475569;">
                                        <span>Change Photo</span>
                                        <input type="file" id="updateSupplierImage" onchange="previewSupplierUpdateImage(this)" accept="image/*" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer;" />
                                    </label>
                                    <p style="margin: 4px 0 0 0; font-size: 11px; color: #94a3b8;">PNG, JPEG or GIF (up to 2 MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sticky Bottom Footer with Update Button -->
        <div style="padding: 12px 24px 16px; background: #ffffff; border-top: 1px solid #f1f5f9; flex-shrink: 0; position: sticky; bottom: 0; z-index: 10; display: flex; gap: 10px; justify-content: flex-end;" class="modal-footer-sticky">
            <button type="button" onclick="closeSupplierUpdateModal()" class="btn px-4 py-2 font-semibold text-white" style="background-color: #dc2626 !important; color: #ffffff !important; border-radius: 8px; border: none !important; font-size: 14px;">Cancel</button>
            <button type="button" onclick="SupplierDataUpdate(event)" class="btn-save save-btn px-4 py-2" style="height: 40px !important; background-color: #15803d !important; color: #ffffff !important; border-radius: 8px !important; font-weight: 600 !important; font-size: 14px !important; border: none !important; cursor: pointer !important; display: flex; align-items: center; justify-content: center; gap: 6px;">
                <i class="fa-solid fa-check"></i> Update Supplier
            </button>
        </div>
    </div>
</div>

<!-- Delete Supplier Confirmation Modal (Matching Retail supplier-delete.blade.php) -->
<div class="modal fade" id="supplierDeleteModal" tabindex="-1" aria-labelledby="supplierDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content border-0 shadow-2xl text-center p-4 bg-white dark:bg-slate-900" style="border-radius: 16px;">
            <div class="text-rose-500 mb-3 flex justify-center">
                <div class="w-14 h-14 rounded-full bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/40 flex items-center justify-center">
                    <i class="fa-solid fa-trash-can text-rose-600 dark:text-rose-400 text-2xl"></i>
                </div>
            </div>
            <h5 class="font-bold text-slate-800 dark:text-white text-lg mb-1">Delete Supplier?</h5>
            <p class="text-slate-500 dark:text-slate-400 text-xs mb-4">Are you sure you want to delete this supplier? This action cannot be undone if no purchase records exist.</p>
            <input type="hidden" id="deleteSupplierId" />
            <div class="flex items-center justify-center gap-2">
                <button type="button" class="px-4 py-2 text-xs font-semibold rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition-colors" data-bs-dismiss="modal">Cancel</button>
                <button type="button" onclick="confirmDeleteBatterySupplier()" class="px-4 py-2 text-xs font-bold rounded-xl bg-rose-600 hover:bg-rose-700 text-white transition-colors flex items-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-trash-can text-xs"></i>
                    <span>Yes, Delete</span>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Full Height & Zoom-Out Sticky Footer Fix */
    html, body {
        min-height: 100vh !important;
    }
    .main-content {
        min-height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
    }
    .page-content {
        min-height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
        flex-grow: 1 !important;
        padding-bottom: 0 !important;
    }
    .data-table {
        flex-grow: 1 !important;
        background: transparent !important;
    }
    .copyright {
        margin-top: auto !important;
        width: 100% !important;
    }

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
    }

    @media (max-width: 639px) {
        .controls-row-wrapper {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 8px !important;
        }
        .search-input-wrapper {
            flex: 1 1 auto !important;
            min-width: 0 !important;
        }
        .controls-filter-group {
            flex: 0 0 auto !important;
        }
    }

    .unified-ui-border {
        border: 1.5px solid #cbd5e1 !important;
    }

    /* Solid Emerald Header across light & dark modes */
    #printTable thead tr,
    #printTable thead th {
        background-color: #15803d !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] #printTable thead tr,
    body[light-mode="dark"] #printTable thead th,
    html.dark #printTable thead tr,
    html.dark #printTable thead th {
        background-color: #15803d !important;
        color: #ffffff !important;
    }

    #printTable th, #printTable td {
        padding: 10px !important;
        vertical-align: middle !important;
    }

    body[light-mode="dark"] .unified-ui-border,
    body[data-layout-mode="dark"] .unified-ui-border,
    html.dark .unified-ui-border {
        border-color: #334155 !important;
    }

    /* Modal Backdrop & Viewport Centering */
    .newbrand,
    #supplierCreateModal,
    #supplierUpdateModal {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        margin: 0 !important;
        padding: 20px 10px !important;
        background: rgba(0, 0, 0, 0.65) !important;
        display: none;
        justify-content: center !important;
        align-items: center !important;
        z-index: 999999 !important;
        box-sizing: border-box !important;
    }
    .newbrand.show,
    #supplierCreateModal.show,
    #supplierUpdateModal.show {
        display: flex !important;
        opacity: 1 !important;
        visibility: visible !important;
    }
    .newbrand-content,
    #supplierCreateModal .newbrand-content,
    #supplierUpdateModal .newbrand-content {
        position: relative !important;
        left: auto !important;
        top: auto !important;
        right: auto !important;
        bottom: auto !important;
        margin: auto !important;
        transform: none !important;
        transition: none !important;
        max-height: 90vh !important;
        width: 650px !important;
        max-width: 95% !important;
        background: #ffffff !important;
        border-radius: 16px !important;
        overflow: hidden !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4) !important;
        display: flex !important;
        flex-direction: column !important;
    }
    .newbrand.show .newbrand-content,
    #supplierCreateModal.show .newbrand-content,
    #supplierUpdateModal.show .newbrand-content {
        transform: none !important;
        left: auto !important;
        top: auto !important;
        margin: auto !important;
    }

    /* Delete Supplier Modal Reset (No duplicate white box, dead-centered) */
    #supplierDeleteModal.modal {
        display: none;
        background: rgba(15, 23, 42, 0.65) !important;
        backdrop-filter: blur(4px) !important;
        -webkit-backdrop-filter: blur(4px) !important;
        z-index: 1060 !important;
    }
    #supplierDeleteModal.modal.show {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    #supplierDeleteModal .modal-dialog {
        position: static !important;
        transform: none !important;
        margin: auto !important;
        max-width: 420px !important;
        width: 92% !important;
        background: transparent !important;
        background-color: transparent !important;
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
    }
    #supplierDeleteModal .modal-content {
        background: #ffffff !important;
        border-radius: 20px !important;
        border: 1px solid rgba(226, 232, 240, 0.8) !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        padding: 24px !important;
        margin: 0 !important;
        width: 100% !important;
    }

    /* Button Hovers: Guarantee No White Text/Background Glitch in Light Mode */
    #openModalBtns,
    .btn-create-supplier,
    .btn-save,
    .save-btn {
        background-color: #15803d !important;
        color: #ffffff !important;
        border: none !important;
    }
    #openModalBtns:hover,
    #openModalBtns:focus,
    #openModalBtns:active,
    .btn-create-supplier:hover,
    .btn-create-supplier:focus,
    .btn-create-supplier:active,
    .btn-save:hover,
    .btn-save:focus,
    .btn-save:active,
    .save-btn:hover,
    .save-btn:focus,
    .save-btn:active {
        background-color: #166534 !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(21, 128, 61, 0.3) !important;
    }
    #openModalBtns *,
    #openModalBtns:hover *,
    .btn-create-supplier *,
    .btn-create-supplier:hover *,
    .btn-save *,
    .btn-save:hover *,
    .save-btn *,
    .save-btn:hover * {
        color: #ffffff !important;
        stroke: #ffffff !important;
    }

    .form-label-title {
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #334155 !important;
        margin-bottom: 6px !important;
        display: block !important;
    }
    body[light-mode="dark"] .form-label-title,
    html.dark .form-label-title {
        color: #cbd5e1 !important;
    }

    .form-control, .form-select {
        height: 42px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 8px !important;
        font-size: 13.5px !important;
        padding: 0 12px !important;
    }
    .form-control:focus, .form-select:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.2) !important;
        outline: none !important;
    }

    /* Dark Mode Modals */
    body[light-mode="dark"] .newbrand-content,
    html.dark .newbrand-content {
        background-color: #0f172a !important;
        border: 1px solid #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .modal-footer-sticky,
    html.dark .modal-footer-sticky {
        background-color: #0f172a !important;
        border-top-color: #334155 !important;
    }
    body[light-mode="dark"] .form-control,
    body[light-mode="dark"] .form-select,
    html.dark .form-control,
    html.dark .form-select {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }

    /* Action button styling with hover protection */
    .action-btn-custom {
        width: 30px !important;
        height: 30px !important;
        border-radius: 8px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.15s ease-in-out !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
    }
    .btn-action-edit {
        background-color: #ecfdf5 !important;
        color: #059669 !important;
        border: 1px solid #a7f3d0 !important;
    }
    .btn-action-edit:hover {
        background-color: #059669 !important;
        color: #ffffff !important;
        border-color: #059669 !important;
    }
    .btn-action-delete {
        background-color: #fff1f2 !important;
        color: #e11d48 !important;
        border: 1px solid #fecdd3 !important;
    }
    .btn-action-delete:hover {
        background-color: #e11d48 !important;
        color: #ffffff !important;
        border-color: #e11d48 !important;
    }
    body[light-mode="dark"] .btn-action-edit,
    html.dark .btn-action-edit {
        background-color: rgba(6, 78, 59, 0.4) !important;
        color: #34d399 !important;
        border-color: #065f46 !important;
    }
    body[light-mode="dark"] .btn-action-edit:hover,
    html.dark .btn-action-edit:hover {
        background-color: #059669 !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] .btn-action-delete,
    html.dark .btn-action-delete {
        background-color: rgba(136, 19, 55, 0.4) !important;
        color: #fb7185 !important;
        border-color: #9f1239 !important;
    }
    body[light-mode="dark"] .btn-action-delete:hover,
    html.dark .btn-action-delete:hover {
        background-color: #e11d48 !important;
        color: #ffffff !important;
    }

    /* Custom Pagination Button */
    .custom-pagination-btn {
        height: 32px;
        min-width: 32px;
        padding: 0 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background-color: #ffffff;
        color: #334155;
        transition: all 0.15s ease-in-out;
        cursor: pointer;
    }
    .custom-pagination-btn:hover:not(.disabled):not(.active) {
        background-color: #f1f5f9;
        border-color: #94a3b8;
        color: #0f172a;
    }
    .custom-pagination-btn.active {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
        box-shadow: 0 2px 4px rgba(21, 128, 61, 0.25);
    }
    .custom-pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        background-color: #f8fafc;
        border-color: #e2e8f0;
        color: #94a3b8;
    }
    body[light-mode="dark"] .custom-pagination-btn,
    html.dark .custom-pagination-btn {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .custom-pagination-btn.active,
    html.dark .custom-pagination-btn.active {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }
</style>

<script>
    let currentPage = 1;
    let pageSize = 15;
    let rawSupplierData = [];

    $(document).ready(function() {
        $('#supplierCreateModal').appendTo('body');
        $('#supplierUpdateModal').appendTo('body');
        $('#supplierDeleteModal').appendTo('body');
        $("#entries").val("15");
        getList();
    });

    $("#searchInput").on("keyup search input", function () {
        currentPage = 1;
        renderPaginatedList();
    });

    $("#entries").on("change", function () {
        pageSize = parseInt($(this).val()) || 15;
        currentPage = 1;
        renderPaginatedList();
    });

    function formatBdCurrency(amount) {
        let num = parseFloat(amount);
        if (isNaN(num)) return "0.00";
        return num.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    async function getList() {
        try {
            if (typeof showLoader === 'function') showLoader();
            let res = await axios.get("/api/battery/supplier-list", HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                rawSupplierData = res.data.SupplierData || res.data.data || [];
                rawSupplierData.sort((a, b) => (parseInt(b.id) || 0) - (parseInt(a.id) || 0));
            } else {
                rawSupplierData = [];
            }

            currentPage = 1;
            renderPaginatedList();

        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error("Supplier list fetch error:", e);
            if (typeof unauthorized === 'function') unauthorized(e.response ? e.response.status : 500);
        }
    }

    function renderPaginatedList() {
        if (!rawSupplierData) return;

        let searchTerm = ($("#searchInput").val() || "").toLowerCase().trim();

        // 1. Filter Suppliers
        let filtered = rawSupplierData.filter(function (item) {
            let supplierId = (item.supplier_id || "").toLowerCase();
            let name = (item.name || "").toLowerCase();
            let company = (item.company || "").toLowerCase();
            let mobile = (item.mobile || "").toLowerCase();

            return !searchTerm || supplierId.includes(searchTerm) || name.includes(searchTerm) || company.includes(searchTerm) || mobile.includes(searchTerm);
        });

        filtered.sort((a, b) => (parseInt(b.id) || 0) - (parseInt(a.id) || 0));

        // 2. Calculate Totals
        let totalPayableAmount = 0;
        filtered.forEach(item => {
            totalPayableAmount += parseFloat(item.purchase_payable_amount) || 0;
        });
        $("#totalPayableaamountPrice").text(`৳ ${formatBdCurrency(totalPayableAmount)}`);

        // 3. Pagination Calculations
        let totalItems = filtered.length;
        let totalPages = Math.ceil(totalItems / pageSize) || 1;
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        let startIndex = (currentPage - 1) * pageSize;
        let endIndex = Math.min(startIndex + pageSize, totalItems);
        let pageItems = filtered.slice(startIndex, endIndex);

        let tableList = $("#tableList");
        let mobileCardList = $("#mobileCardList");

        tableList.empty();
        mobileCardList.empty();

        if (pageItems.length === 0) {
            tableList.html('<tr><td colspan="8" class="text-center text-rose-500 font-bold p-6">❌ No suppliers found.</td></tr>');
            mobileCardList.html('<div class="p-6 text-center text-rose-500 font-bold bg-white dark:bg-slate-800 rounded-2xl unified-ui-border shadow-sm">❌ No suppliers found.</div>');
        } else {
            pageItems.forEach(function (item, idx) {
                let realIndex = startIndex + idx;
                const img_url = item.img_url ? ('/' + item.img_url) : "{{ asset('backend/assets/img/demo-img.jpeg') }}";
                let payableAmount = parseFloat(item.purchase_payable_amount) || 0;
                let statusVal = item.status || 'Active';

                let statusBadgeClass = statusVal === 'Active'
                    ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800/40'
                    : 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/40 dark:text-rose-400 dark:border-rose-800/40';

                // Desktop Row (SL, Image, Supplier ID, Name, Company, Payable Amount, Status, Action)
                let row = `
                    <tr data-row="${realIndex + 1}" class="hover:bg-slate-50/80 dark:hover:bg-slate-800/60 transition-colors">
                        <td class="p-[10px] text-center font-semibold text-slate-500 dark:text-slate-400 text-xs">${realIndex + 1}</td>
                        <td class="p-[10px] text-center w-[65px]" style="width: 65px !important;">
                            <div class="flex justify-center">
                                <img style="width: 38px; height: 38px; object-fit: cover;" class="rounded-full border border-slate-200 dark:border-slate-700 shadow-xs" alt="${item.name}" src="${img_url}" onerror="this.src='{{ asset('backend/assets/img/demo-img.jpeg') }}'">
                            </div>
                        </td>
                        <td class="p-[10px] text-start whitespace-nowrap">
                            <a href="/battery/supplier/profile/${item.id}" class="inline-flex items-center gap-1 font-semibold text-emerald-600 dark:text-emerald-400 hover:underline text-xs whitespace-nowrap">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="3" width="15" height="13"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                </svg>
                                <span>${item.supplier_id || ('SUP-' + item.id)}</span>
                            </a>
                        </td>
                        <td class="p-[10px] text-start whitespace-nowrap">
                            <a href="/battery/supplier/profile/${item.id}" class="font-bold text-slate-800 dark:text-slate-100 hover:text-emerald-600 transition-colors">${item.name}</a>
                        </td>
                        <td class="p-[10px] text-start whitespace-nowrap text-slate-600 dark:text-slate-400 font-medium">${item.company || '-'}</td>
                        <td class="p-[10px] text-end font-bold ${payableAmount > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-700 dark:text-slate-300'} whitespace-nowrap font-mono">৳ ${formatBdCurrency(payableAmount)}</td>
                        <td class="p-[10px] text-center w-[100px] whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold border ${statusBadgeClass}">
                                ${statusVal}
                            </span>
                        </td>
                        <td class="p-[10px] text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <button type="button" onclick="FillUpUpdateForm(${item.id})" class="action-btn-custom btn-action-edit" title="Edit">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="openDeleteSupplierModal(${item.id})" class="action-btn-custom btn-action-delete" title="Delete">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>`;
                tableList.append(row);

                // Mobile Card View
                let mobileCard = `
                    <div class="supplier-mobile-card unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800/60 shadow-sm mb-3">
                        <div class="flex items-center justify-between pb-2 mb-2.5 border-b border-slate-100 dark:border-slate-700/60">
                            <div class="flex items-center gap-1.5">
                                <span class="px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[11px] font-bold">#${realIndex + 1}</span>
                                <span class="px-2 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/40 text-emerald-700 dark:text-emerald-400 text-xs font-bold inline-flex items-center gap-1">
                                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="1" y="3" width="15" height="13"></rect>
                                        <polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon>
                                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                    </svg>
                                    ${item.supplier_id || ('SUP-' + item.id)}
                                </span>
                            </div>
                            <div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold border ${statusBadgeClass}">
                                    ${statusVal}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mb-2.5">
                            <img src="${img_url}" class="supplier-profile-avatar border border-slate-200 dark:border-slate-700 shadow-xs" style="width: 44px !important; height: 44px !important; min-width: 44px !important; min-height: 44px !important; max-width: 44px !important; max-height: 44px !important; border-radius: 50% !important; object-fit: cover !important; display: block !important; flex-shrink: 0 !important;" onerror="this.src='{{ asset('backend/assets/img/demo-img.jpeg') }}'">
                            <div class="overflow-hidden">
                                <h6 class="font-bold text-slate-800 dark:text-slate-100 text-sm truncate">${item.name}</h6>
                                <span class="text-slate-500 dark:text-slate-400 text-xs inline-flex items-center gap-1 truncate">
                                    <i class="fa-solid fa-building text-[10px]"></i>
                                    ${item.company || 'No Company'}
                                </span>
                                <div class="text-slate-500 dark:text-slate-400 text-xs font-mono mt-0.5">
                                    <i class="fa-solid fa-phone text-emerald-600 text-[10px]"></i> ${item.mobile || '-'}
                                </div>
                            </div>
                        </div>

                        <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/60 my-2 flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Payable Due:</span>
                            <span class="font-bold text-sm ${payableAmount > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-800 dark:text-slate-100'} font-mono">৳ ${formatBdCurrency(payableAmount)}</span>
                        </div>

                        <div class="flex items-center justify-between pt-2.5 mt-1 border-t border-slate-100 dark:border-slate-700/60">
                            <a href="/battery/supplier/profile/${item.id}" class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 dark:bg-emerald-950/40 dark:hover:bg-emerald-900/50 dark:text-emerald-400 text-xs font-semibold rounded-lg border border-emerald-200 dark:border-emerald-800/40 transition-colors">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                Profile
                            </a>
                            <div class="flex items-center gap-1.5">
                                <button type="button" onclick="FillUpUpdateForm(${item.id})" class="action-btn-custom btn-action-edit" title="Edit">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="openDeleteSupplierModal(${item.id})" class="action-btn-custom btn-action-delete" title="Delete">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>`;
                mobileCardList.append(mobileCard);
            });
        }

        // 4. Update Display Info & Pagination
        let fromCount = totalItems > 0 ? startIndex + 1 : 0;
        let toCount = endIndex;
        $("#display-info").html(`
            <div class="px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 flex-wrap bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Showing</span>
                <span class="px-2 py-0.5 rounded-md font-bold bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700">${fromCount} - ${toCount}</span>
                <span>of</span>
                <span class="px-2 py-0.5 rounded-md font-bold bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">${totalItems}</span>
                <span>suppliers</span>
            </div>
        `);

        renderPaginationUI(totalPages);
    }

    function renderPaginationUI(totalPages) {
        let pagination = $("#pagination");
        pagination.empty();

        if (totalPages <= 1) return;

        let prevDisabled = currentPage === 1 ? 'disabled' : '';
        pagination.append(`<button type="button" class="custom-pagination-btn ${prevDisabled}" onclick="goToPage(${currentPage - 1})"><i class="fa-solid fa-chevron-left text-[10px]"></i></button>`);

        let startP = Math.max(1, currentPage - 2);
        let endP = Math.min(totalPages, currentPage + 2);

        if (startP > 1) {
            pagination.append(`<button type="button" class="custom-pagination-btn" onclick="goToPage(1)">1</button>`);
            if (startP > 2) pagination.append(`<span class="px-1 text-slate-400">...</span>`);
        }

        for (let p = startP; p <= endP; p++) {
            let activeClass = p === currentPage ? 'active' : '';
            pagination.append(`<button type="button" class="custom-pagination-btn ${activeClass}" onclick="goToPage(${p})">${p}</button>`);
        }

        if (endP < totalPages) {
            if (endP < totalPages - 1) pagination.append(`<span class="px-1 text-slate-400">...</span>`);
            pagination.append(`<button type="button" class="custom-pagination-btn" onclick="goToPage(${totalPages})">${totalPages}</button>`);
        }

        let nextDisabled = currentPage === totalPages ? 'disabled' : '';
        pagination.append(`<button type="button" class="custom-pagination-btn ${nextDisabled}" onclick="goToPage(${currentPage + 1})"><i class="fa-solid fa-chevron-right text-[10px]"></i></button>`);
    }

    function goToPage(page) {
        let totalPages = Math.ceil(rawSupplierData.length / pageSize) || 1;
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderPaginatedList();
    }

    // Modal Operations
    function openSupplierCreateModal() {
        $('#supplierCreateForm')[0].reset();
        $('#supplierCreateImgBox').html(`
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                <polyline points="21 15 16 10 5 21"></polyline>
            </svg>
        `);
        const modal = document.getElementById('supplierCreateModal');
        if (modal) {
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('show'), 10);
        }
    }

    function closeSupplierCreateModal() {
        const modal = document.getElementById('supplierCreateModal');
        if (modal) {
            modal.classList.remove('show');
            setTimeout(() => modal.style.display = 'none', 250);
        }
    }

    function previewSupplierCreateImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#supplierCreateImgBox').html(`<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    async function SupplierDataSave(e) {
        if (e) e.preventDefault();
        try {
            const name = $('#supplierName').val().trim();
            const mobile = $('#supplierMobile').val().trim();
            const company = $('#supplierCompany').val().trim();
            const address = $('#supplierAddress').val().trim();
            const payable = $('#supplierPurchasePayableAmount').val().trim();
            const imgFile = document.getElementById('supplierImage')?.files[0];

            if (!name) {
                errorToast("Supplier Name is required!");
                return false;
            }
            if (!mobile) {
                errorToast("Supplier Mobile is required!");
                return false;
            }

            let formData = new FormData();
            formData.append('name', name);
            formData.append('mobile', mobile);
            formData.append('company', company);
            formData.append('address', address);
            formData.append('purchase_payable_amount', payable || 0);
            if (imgFile) {
                formData.append('img_url', imgFile);
            }

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            if (typeof showLoader === 'function') showLoader();
            let res = await axios.post("/api/battery/create-supplier", formData, config);
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || "Supplier Created Successfully");
                closeSupplierCreateModal();
                getList();
            } else {
                errorToast(res.data.message || "Failed to create supplier");
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast("Error creating supplier");
        }
        return false;
    }

    async function FillUpUpdateForm(id) {
        try {
            if (typeof showLoader === 'function') showLoader();
            let res = await axios.post("/api/battery/supplier-by-id", { id: id }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                const s = res.data.rows;
                $('#updateSupplierId').val(s.id);
                $('#updateSupplierName').val(s.name);
                $('#updateSupplierMobile').val(s.mobile);
                $('#updateSupplierCompany').val(s.company || '');
                $('#updateSupplierAddress').val(s.address || '');
                $('#updateSupplierPurchasePayableAmount').val(s.purchase_payable_amount || 0);
                $('#updateSupplierStatus').val(s.status || 'Active');

                if (s.img_url) {
                    $('#updateImagePreview').attr('src', '/' + s.img_url);
                } else {
                    $('#updateImagePreview').attr('src', "{{ asset('backend/assets/img/demo-img.jpeg') }}");
                }

                const modal = document.getElementById('supplierUpdateModal');
                if (modal) {
                    modal.style.display = 'flex';
                    setTimeout(() => modal.classList.add('show'), 10);
                }
            } else {
                errorToast("Failed to fetch supplier details");
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast("Failed to load supplier");
        }
    }

    function closeSupplierUpdateModal() {
        const modal = document.getElementById('supplierUpdateModal');
        if (modal) {
            modal.classList.remove('show');
            setTimeout(() => modal.style.display = 'none', 250);
        }
    }

    function previewSupplierUpdateImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#updateImagePreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    async function SupplierDataUpdate(e) {
        if (e) e.preventDefault();
        try {
            const id = $('#updateSupplierId').val();
            const name = $('#updateSupplierName').val().trim();
            const mobile = $('#updateSupplierMobile').val().trim();
            const company = $('#updateSupplierCompany').val().trim();
            const address = $('#updateSupplierAddress').val().trim();
            const payable = $('#updateSupplierPurchasePayableAmount').val().trim();
            const imgFile = document.getElementById('updateSupplierImage')?.files[0];

            if (!name) {
                errorToast("Supplier Name is required!");
                return false;
            }
            if (!mobile) {
                errorToast("Supplier Mobile is required!");
                return false;
            }

            let formData = new FormData();
            formData.append('id', id);
            formData.append('name', name);
            formData.append('mobile', mobile);
            formData.append('company', company);
            formData.append('address', address);
            formData.append('purchase_payable_amount', payable || 0);
            if (imgFile) {
                formData.append('img_url', imgFile);
            }

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            if (typeof showLoader === 'function') showLoader();
            let res = await axios.post("/api/battery/update-supplier", formData, config);
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || "Supplier updated successfully");
                closeSupplierUpdateModal();
                getList();
            } else {
                errorToast(res.data.message || "Failed to update supplier");
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast("Error updating supplier");
        }
        return false;
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
            let res = await axios.post("/api/battery/delete-supplier", { id: id }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || "Supplier deleted successfully");
                $('#supplierDeleteModal').modal('hide');
                getList();
            } else {
                errorToast(res.data.message || "Failed to delete supplier");
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast("Error deleting supplier");
        }
    }
</script>

@endsection
