@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Purchases - MARSS CORPORATION')
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
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Battery Purchases</h1>
                                <small class="text-slate-500 dark:text-slate-400 text-xs">Manage inventory procurement orders and weighted average cost tracking</small>
                            </div>
                        </div>

                        <!-- Right Controls -->
                        <div class="flex items-center flex-wrap gap-2">
                            <a href="{{ route('battery.purchase.payments') }}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] min-h-[38px] max-h-[38px] bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-200 text-xs font-semibold rounded-xl border border-slate-300 dark:border-slate-700 transition-all shadow-sm">
                                <i class="fa-solid fa-credit-card"></i>
                                <span>Purchase Payments</span>
                            </a>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#purchaseCreateModal" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>New Purchase</span>
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
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding-left: 4px !important; padding-right: 4px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search by Purchase ID, Supplier or Reference..." />
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
                        <table class="w-full text-left border-collapse" id="purchaseTable">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">#</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Purchase ID</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Date</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Supplier</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Grand Total</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Paid</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Due</th>
                                    <th class="p-[10px] text-center whitespace-nowrap">Status</th>
                                    <th class="p-[10px] text-center w-[115px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="purchaseTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                                <tr>
                                    <td colspan="9" class="text-center py-6 text-slate-400">Loading battery purchases...</td>
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

<!-- Create Purchase Modal -->
<div class="modal fade" id="purchaseCreateModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-2xl border-0 shadow-lg overflow-hidden bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100">
            <div class="modal-header px-4 py-3 border-0" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; color: #ffffff !important;">
                <h5 class="modal-title font-bold text-base flex items-center gap-2 text-white m-0">
                    <i class="fa-solid fa-cart-plus text-white"></i> New Battery Purchase Order
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createPurchaseForm" onsubmit="saveBatteryPurchase(event)">
                <div class="modal-body p-4 space-y-4">
                    <!-- Top Info: Supplier, Date, Ref -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Supplier <span class="text-red-500">*</span></label>
                            <select id="createPurchaseSupplier" required class="form-select rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                                <option value="">Select Supplier</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Purchase Date <span class="text-red-500">*</span></label>
                            <input type="date" id="createPurchaseDate" value="{{ date('Y-m-d') }}" required class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                        </div>
                        <div>
                            <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Reference No</label>
                            <input type="text" id="createPurchaseRef" placeholder="Challan / Bill No" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                        </div>
                    </div>

                    <!-- Items Selection -->
                    <div class="border border-slate-200 dark:border-slate-800 rounded-xl p-3 bg-slate-50 dark:bg-slate-800/40">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-200">Purchased Battery Products</span>
                            <button type="button" onclick="addPurchaseRow()" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200">
                                <i class="fa-solid fa-plus me-1"></i> Add Product
                            </button>
                        </div>
                        <div class="table-responsive overflow-x-auto">
                            <table class="w-full text-xs text-left" id="purchaseItemsTable">
                                <thead>
                                    <tr class="text-slate-500 uppercase font-bold border-b border-slate-200 dark:border-slate-700">
                                        <th class="p-2 w-5/12">Product</th>
                                        <th class="p-2 w-2/12 text-center">Quantity</th>
                                        <th class="p-2 w-2/12 text-end">Cost Price (৳)</th>
                                        <th class="p-2 w-2/12 text-end">Subtotal (৳)</th>
                                        <th class="p-2 w-1/12 text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="purchaseItemsBody" class="divide-y divide-slate-200 dark:divide-slate-700">
                                    <!-- Dynamic Rows -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Financial Summary & Payment -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                        <div>
                            <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Discount (৳)</label>
                            <input type="number" step="0.01" id="purchaseDiscount" value="0" oninput="calculatePurchaseTotals()" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                        </div>
                        <div>
                            <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Delivery Charge (৳)</label>
                            <input type="number" step="0.01" id="purchaseDelivery" value="0" oninput="calculatePurchaseTotals()" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                        </div>
                        <div>
                            <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Grand Total (৳)</label>
                            <input type="number" step="0.01" id="purchaseGrandTotal" readonly class="form-control rounded-xl text-sm bg-slate-100 dark:bg-slate-800 font-bold text-slate-900 dark:text-white h-[42px]">
                        </div>
                        <div>
                            <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Paid Amount (৳)</label>
                            <input type="number" step="0.01" id="purchasePaid" value="0" oninput="calculatePurchaseTotals()" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-emerald-400 font-bold h-[42px]">
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <div class="text-sm font-semibold text-rose-600">
                            Due Amount: ৳ <span id="purchaseDueText">0.00</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-t border-slate-200 dark:border-slate-800 px-4 py-3 flex justify-end gap-2">
                    <button type="button" class="btn px-4 text-white font-semibold" style="background-color: #dc2626 !important; border-radius: 8px !important; height: 38px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4 text-white font-semibold" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; border-radius: 8px !important; height: 38px;">Save Purchase</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Purchase Modal -->
<div class="modal fade" id="purchaseDeleteModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content rounded-2xl border-0 shadow-lg text-center p-4 bg-white dark:bg-slate-900">
            <input type="hidden" id="deletePurchaseId">
            <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-triangle-exclamation text-2xl" style="color: #dc2626;"></i>
            </div>
            <h5 class="font-bold text-slate-800 dark:text-white mb-1">Delete Purchase?</h5>
            <p class="text-xs text-slate-500 mb-4">Stock will be adjusted accordingly. This action cannot be undone.</p>
            <div class="flex justify-center gap-2">
                <button type="button" class="btn px-4 rounded-xl text-sm font-semibold border border-slate-300 text-slate-700 hover:bg-slate-100" data-bs-dismiss="modal">Cancel</button>
                <button type="button" onclick="confirmDeleteBatteryPurchase()" class="btn px-4 text-white rounded-xl text-sm font-semibold" style="background-color: #dc2626 !important; border: none !important;">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Purchase Modal -->
<div class="modal fade" id="purchaseEditModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-2xl border-0 shadow-lg overflow-hidden bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100">
            <div class="modal-header px-4 py-3 border-0" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; color: #ffffff !important;">
                <h5 class="modal-title font-bold text-base flex items-center gap-2 text-white m-0">
                    <i class="fa-solid fa-pen-to-square text-white"></i> Edit Battery Purchase Order
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPurchaseForm" onsubmit="saveEditBatteryPurchase(event)">
                <input type="hidden" id="editPurchaseId">
                <div class="modal-body p-4 space-y-4">
                    <!-- Top Info: Supplier, Date, Ref, Attachment -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <div>
                            <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Supplier <span class="text-red-500">*</span></label>
                            <select id="editPurchaseSupplier" required class="form-select rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                                <option value="">Select Supplier</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Purchase Date <span class="text-red-500">*</span></label>
                            <input type="date" id="editPurchaseDate" required class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                        </div>
                        <div>
                            <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Reference No</label>
                            <input type="text" id="editPurchaseRef" placeholder="Challan / Bill No" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                        </div>
                        <div>
                            <div class="flex items-center justify-between">
                                <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Attach Document</label>
                                <span id="editCurrentDocLink" class="text-[11px] font-semibold text-emerald-600 dark:text-emerald-400"></span>
                            </div>
                            <input type="file" id="editPurchaseAttachDocument" class="form-control rounded-xl text-xs dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                        </div>
                    </div>

                    <!-- Items Selection -->
                    <div class="border border-slate-200 dark:border-slate-800 rounded-xl p-3 bg-slate-50 dark:bg-slate-800/40">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-200">Purchased Battery Products</span>
                            <button type="button" onclick="addEditPurchaseRow()" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800">
                                <i class="fa-solid fa-plus me-1"></i> Add Product
                            </button>
                        </div>
                        <div class="table-responsive overflow-x-auto">
                            <table class="w-full text-xs text-left" id="editPurchaseItemsTable">
                                <thead>
                                    <tr class="text-slate-500 uppercase font-bold border-b border-slate-200 dark:border-slate-700">
                                        <th class="p-2 w-5/12">Product</th>
                                        <th class="p-2 w-2/12 text-center">Quantity</th>
                                        <th class="p-2 w-2/12 text-end">Cost Price (৳)</th>
                                        <th class="p-2 w-2/12 text-end">Subtotal (৳)</th>
                                        <th class="p-2 w-1/12 text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="editPurchaseItemsBody" class="divide-y divide-slate-200 dark:divide-slate-700">
                                    <!-- Dynamic Rows -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Financial Summary & Payment -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                        <div>
                            <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Discount (৳)</label>
                            <input type="number" step="0.01" id="editPurchaseDiscount" value="0" oninput="calculateEditPurchaseTotals()" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                        </div>
                        <div>
                            <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Delivery Charge (৳)</label>
                            <input type="number" step="0.01" id="editPurchaseDelivery" value="0" oninput="calculateEditPurchaseTotals()" class="form-control rounded-xl text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white h-[42px]">
                        </div>
                        <div>
                            <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Grand Total (৳)</label>
                            <input type="number" step="0.01" id="editPurchaseGrandTotal" readonly class="form-control rounded-xl text-sm bg-slate-100 dark:bg-slate-800 font-bold text-slate-900 dark:text-white h-[42px]">
                        </div>
                        <div>
                            <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Paid Amount (৳)</label>
                            <input type="number" step="0.01" id="editPurchasePaid" value="0" readonly class="form-control rounded-xl text-sm bg-slate-100 dark:bg-slate-800 text-slate-500 cursor-not-allowed dark:border-slate-700 font-bold h-[42px]">
                            <small id="editPurchasePaidHint" class="text-[11px] text-amber-600 dark:text-amber-400 font-medium block mt-1">Read-only: ledger-derived. Payments must be recorded in <a href="{{ route('battery.purchase.payments') }}" class="underline font-bold text-emerald-600 dark:text-emerald-400">Purchase Payments</a>.</small>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <div class="text-sm font-semibold text-rose-600 dark:text-rose-400">
                            Due Amount: ৳ <span id="editPurchaseDueText">0.00</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-t border-slate-200 dark:border-slate-800 px-4 py-3 flex justify-end gap-2">
                    <button type="button" class="btn px-4 text-white font-semibold" style="background-color: #dc2626 !important; border-radius: 8px !important; height: 38px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4 text-white font-semibold" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; border-radius: 8px !important; height: 38px;">Update Purchase</button>
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
    .action-btn {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.15s ease;
    }
    .action-btn-view {
        background-color: #ecfdf5;
        color: #059669;
    }
    .action-btn-view:hover {
        background-color: #d1fae5;
        color: #047857;
    }
    body[light-mode="dark"] .action-btn-view,
    html.dark .action-btn-view {
        background-color: rgba(5, 150, 105, 0.2);
        color: #34d399;
    }
    .action-btn-edit {
        background-color: #fef3c7;
        color: #d97706;
    }
    .action-btn-edit:hover {
        background-color: #fde68a;
        color: #b45309;
    }
    body[light-mode="dark"] .action-btn-edit,
    html.dark .action-btn-edit {
        background-color: rgba(217, 119, 6, 0.2);
        color: #fbbf24;
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
    let rawPurchases = [];
    let suppliersList = [];
    let productsList = [];
    let currentPage = 1;
    let pageSize = 15;

    document.addEventListener("DOMContentLoaded", function() {
        loadPurchasePrerequisites();
        getBatteryPurchases();

        $('#searchInput').on('input', function() { currentPage = 1; renderPurchases(); });
        $('#entries').on('change', function() { pageSize = parseInt(this.value) || 15; currentPage = 1; renderPurchases(); });
    });

    async function loadPurchasePrerequisites() {
        try {
            const [sRes, pRes] = await Promise.all([
                axios.get('/api/battery/supplier-list', HeaderToken()),
                axios.get('/api/battery/product-list', HeaderToken())
            ]);

            if (sRes.data && sRes.data.status === 'success') {
                suppliersList = sRes.data.data || sRes.data.SupplierData || [];
                let sOpts = '<option value="">Select Supplier</option>';
                suppliersList.forEach(s => { sOpts += `<option value="${s.id}">${s.name}</option>`; });
                $('#createPurchaseSupplier').html(sOpts);
            }

            if (pRes.data && pRes.data.status === 'success') {
                productsList = pRes.data.ProductData || [];
            }
        } catch (e) {
            console.error(e);
        }
    }

    function addPurchaseRow() {
        const tbody = document.getElementById('purchaseItemsBody');
        let prodOptions = '<option value="">Select Battery Product</option>';
        productsList.forEach(p => {
            prodOptions += `<option value="${p.id}" data-cost="${p.cost_price}">${p.product_name}</option>`;
        });

        const row = document.createElement('tr');
        row.className = 'item-row';
        row.innerHTML = `
            <td class="p-2">
                <select class="form-select text-xs item-product rounded-lg h-[36px]" onchange="onItemProductChange(this)">
                    ${prodOptions}
                </select>
            </td>
            <td class="p-2 text-center">
                <input type="number" min="1" value="1" class="form-control text-xs text-center item-qty rounded-lg h-[36px]" oninput="calculatePurchaseTotals()">
            </td>
            <td class="p-2 text-end">
                <input type="number" step="0.01" value="0" class="form-control text-xs text-end item-cost rounded-lg h-[36px]" oninput="calculatePurchaseTotals()">
            </td>
            <td class="p-2 text-end font-bold text-slate-700 dark:text-slate-200 item-subtotal">
                ৳ 0.00
            </td>
            <td class="p-2 text-center">
                <button type="button" onclick="this.closest('tr').remove(); calculatePurchaseTotals();" class="text-rose-500 hover:text-rose-700 p-1">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    }

    function onItemProductChange(sel) {
        const opt = sel.options[sel.selectedIndex];
        const cost = opt.getAttribute('data-cost') || 0;
        const row = sel.closest('tr');
        row.querySelector('.item-cost').value = cost;
        calculatePurchaseTotals();
    }

    function calculatePurchaseTotals() {
        let itemsSum = 0;
        document.querySelectorAll('#purchaseItemsBody tr.item-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
            const cost = parseFloat(row.querySelector('.item-cost').value) || 0;
            const sub = qty * cost;
            row.querySelector('.item-subtotal').innerText = '৳ ' + sub.toLocaleString();
            itemsSum += sub;
        });

        const discount = parseFloat($('#purchaseDiscount').val()) || 0;
        const delivery = parseFloat($('#purchaseDelivery').val()) || 0;
        const grandTotal = Math.max(0, itemsSum - discount + delivery);
        $('#purchaseGrandTotal').val(grandTotal.toFixed(2));

        const paid = parseFloat($('#purchasePaid').val()) || 0;
        const due = Math.max(0, grandTotal - paid);
        $('#purchaseDueText').text(due.toLocaleString());
    }

    async function getBatteryPurchases() {
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.get("/api/battery/purchases-list", HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                rawPurchases = res.data.PurchasessData || [];
                renderPurchases();
            } else {
                rawPurchases = [];
                renderPurchases();
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            errorToast("Failed to load battery purchases");
        }
    }

    function renderPurchases() {
        const search = ($('#searchInput').val() || '').toLowerCase().trim();
        const filtered = rawPurchases.filter(p => {
            const idMatch = (p.purchase_id || '').toLowerCase().includes(search);
            const supMatch = (p.supplier || '').toLowerCase().includes(search);
            const refMatch = (p.referance_no || '').toLowerCase().includes(search);
            return idMatch || supMatch || refMatch;
        });

        const total = filtered.length;
        const totalPages = Math.ceil(total / pageSize) || 1;
        if (currentPage > totalPages) currentPage = 1;

        const start = (currentPage - 1) * pageSize;
        const pageItems = filtered.slice(start, start + pageSize);

        const tbody = document.getElementById('purchaseTableBody');
        const mobileContainer = document.getElementById('mobileCardList');
        tbody.innerHTML = '';
        mobileContainer.innerHTML = '';

        if (pageItems.length === 0) {
            tbody.innerHTML = `<tr><td colspan="9" class="text-center py-8 text-slate-400">No battery purchases found.</td></tr>`;
            mobileContainer.innerHTML = `<div class="p-6 text-center text-slate-400 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">No battery purchases found.</div>`;
        } else {
            pageItems.forEach((p, idx) => {
                const sl = start + idx + 1;
                const statusBadge = p.due_amount <= 0
                    ? '<span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Paid</span>'
                    : (p.paid_amount > 0 ? '<span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300">Partial</span>' : '<span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300">Unpaid</span>');

                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="p-[10px] text-center text-slate-400 font-medium">${sl}</td>
                        <td class="p-[10px] font-mono text-xs font-bold text-emerald-700 dark:text-emerald-400">${p.purchase_id}</td>
                        <td class="p-[10px] text-xs text-slate-600 dark:text-slate-300">${p.date}</td>
                        <td class="p-[10px] font-semibold text-slate-800 dark:text-slate-100">
                            ${p.supplier_db_id ? `
                                <a href="/battery/supplier/profile/${p.supplier_db_id}" class="text-emerald-700 dark:text-emerald-400 font-bold hover:underline" title="View Supplier Profile">${p.supplier}</a>
                            ` : p.supplier}
                        </td>
                        <td class="p-[10px] text-end font-bold text-slate-800 dark:text-slate-100">৳ ${parseFloat(p.grand_subtotal || 0).toLocaleString()}</td>
                        <td class="p-[10px] text-end text-emerald-600 dark:text-emerald-400 font-semibold">৳ ${parseFloat(p.paid_amount || 0).toLocaleString()}</td>
                        <td class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 font-semibold">৳ ${parseFloat(p.due_amount || 0).toLocaleString()}</td>
                        <td class="p-[10px] text-center">${statusBadge}</td>
                        <td class="p-[10px] text-center">
                            <div class="inline-flex items-center gap-1.5 justify-center">
                                <a href="/battery/purchase-invoice/${p.id}" class="action-btn action-btn-view" title="View Memo / Print">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <button onclick="openEditPurchaseModal(${p.id})" class="action-btn action-btn-edit" title="Edit Purchase">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button onclick="openDeletePurchaseModal(${p.id})" class="action-btn action-btn-delete" title="Delete">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;

                mobileContainer.innerHTML += `
                    <div class="p-4 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-xs font-bold text-emerald-700">${p.purchase_id}</span>
                            <div>${statusBadge}</div>
                        </div>
                        <div class="font-bold text-slate-800 dark:text-white">
                            ${p.supplier_db_id ? `
                                <a href="/battery/supplier/profile/${p.supplier_db_id}" class="text-emerald-700 dark:text-emerald-400 hover:underline">${p.supplier}</a>
                            ` : p.supplier}
                        </div>
                        <div class="text-xs text-slate-500">Date: ${p.date} ${p.referance_no ? '| Ref: ' + p.referance_no : ''}</div>
                        <div class="grid grid-cols-3 text-xs pt-1 border-t border-slate-100 dark:border-slate-800">
                            <div>Total: <strong>৳ ${parseFloat(p.grand_subtotal || 0).toLocaleString()}</strong></div>
                            <div class="text-emerald-600">Paid: ৳ ${parseFloat(p.paid_amount || 0).toLocaleString()}</div>
                            <div class="text-end text-rose-600">Due: ৳ ${parseFloat(p.due_amount || 0).toLocaleString()}</div>
                        </div>
                        <div class="pt-2 flex justify-end gap-1.5 border-t border-slate-100 dark:border-slate-800">
                            <a href="/battery/purchase-invoice/${p.id}" class="action-btn action-btn-view" title="View Memo / Print">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <button onclick="openEditPurchaseModal(${p.id})" class="action-btn action-btn-edit" title="Edit Purchase">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button onclick="openDeletePurchaseModal(${p.id})" class="action-btn action-btn-delete" title="Delete">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
        }

        document.getElementById('display-info').innerHTML = total > 0
            ? `Showing <strong>${start + 1}–${Math.min(start + pageSize, total)}</strong> of <strong>${total}</strong> purchases`
            : `0 purchases found`;

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

    function goPage(page) { currentPage = page; renderPurchases(); }

    async function saveBatteryPurchase(e) {
        e.preventDefault();
        try {
            const supplier_id = $('#createPurchaseSupplier').val();
            const date = $('#createPurchaseDate').val();
            const referance_no = $('#createPurchaseRef').val();
            const discount_amount = $('#purchaseDiscount').val() || 0;
            const delivery_charge = $('#purchaseDelivery').val() || 0;
            const grand_subtotal = $('#purchaseGrandTotal').val();
            const paid_amount = $('#purchasePaid').val() || 0;
            const due_amount = Math.max(0, parseFloat(grand_subtotal) - parseFloat(paid_amount));

            const products = [];
            document.querySelectorAll('#purchaseItemsBody tr.item-row').forEach(row => {
                const pId = row.querySelector('.item-product').value;
                const qty = row.querySelector('.item-qty').value;
                const cost = row.querySelector('.item-cost').value;
                if (pId && qty > 0) {
                    products.push({
                        product_id: pId,
                        quantity: qty,
                        cost_price: cost,
                        line_total: parseFloat(qty) * parseFloat(cost)
                    });
                }
            });

            if (products.length === 0) {
                errorToast('Please add at least one battery product');
                return;
            }

            let payload = {
                supplier_id, date, referance_no, discount_amount, delivery_charge,
                grand_subtotal, paid_amount, due_amount,
                products: JSON.stringify(products)
            };

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/create-purchases', payload, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Battery purchase created');
                $('#purchaseCreateModal').modal('hide');
                $('#createPurchaseForm')[0].reset();
                $('#purchaseItemsBody').empty();
                getBatteryPurchases();
            } else {
                errorToast(res.data.message || 'Failed to create purchase');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            errorToast(err.response?.data?.message || 'Error saving purchase');
        }
    }

    function openDeletePurchaseModal(id) {
        $('#deletePurchaseId').val(id);
        $('#purchaseDeleteModal').modal('show');
    }

    async function confirmDeleteBatteryPurchase() {
        try {
            const id = $('#deletePurchaseId').val();
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/delete-purchases', { id: id }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Purchase deleted');
                $('#purchaseDeleteModal').modal('hide');
                getBatteryPurchases();
            } else {
                errorToast(res.data.message || 'Failed to delete purchase');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            errorToast(err.response?.data?.message || 'Error deleting purchase');
        }
    }

    let currentEditReturnAdj = 0;

    async function openEditPurchaseModal(id) {
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/purchases-by-id', { id: id }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                const p = res.data.rows;
                $('#editPurchaseId').val(p.id);

                let sOpts = '<option value="">Select Supplier</option>';
                suppliersList.forEach(s => {
                    const sel = (s.id == p.supplier_id) ? 'selected' : '';
                    sOpts += `<option value="${s.id}" ${sel}>${s.name}</option>`;
                });
                $('#editPurchaseSupplier').html(sOpts);

                let dVal = p.date ? p.date.substring(0, 10) : '';
                $('#editPurchaseDate').val(dVal);
                $('#editPurchaseRef').val(p.referance_no || '');
                $('#editPurchaseDiscount').val(parseFloat(p.discount_amount || 0).toFixed(2));
                $('#editPurchaseDelivery').val(parseFloat(p.delivery_charge || 0).toFixed(2));
                $('#editPurchaseGrandTotal').val(parseFloat(p.grand_subtotal || 0).toFixed(2));

                currentEditReturnAdj = parseFloat(p.return_adjustment_amount || 0);

                const payments = p.payment_details || p.paymentDetails || [];
                let totalLedgerPaid = 0;
                if (Array.isArray(payments) && payments.length > 0) {
                    totalLedgerPaid = payments.reduce((sum, item) => sum + (parseFloat(item.paid_amount) || 0), 0);
                } else {
                    totalLedgerPaid = parseFloat(p.paid_amount || 0);
                }
                $('#editPurchasePaid').val(totalLedgerPaid.toFixed(2));
                $('#editPurchasePaid').prop('readonly', true).addClass('bg-slate-100 dark:bg-slate-800 text-slate-500 cursor-not-allowed');
                $('#editPurchasePaidHint').removeClass('hidden').html('Read-only: ledger-derived. Payments must be recorded in <a href="{{ route("battery.purchase.payments") }}" class="underline font-bold text-emerald-600 dark:text-emerald-400">Purchase Payments</a>.');

                $('#editPurchaseAttachDocument').val('');
                if (p.attach_document) {
                    $('#editCurrentDocLink').html(`<a href="/${p.attach_document}" target="_blank" class="hover:underline flex items-center gap-1 text-emerald-600 dark:text-emerald-400 font-semibold"><i class="fa-solid fa-file"></i> View Current</a>`);
                } else {
                    $('#editCurrentDocLink').empty();
                }

                const tbody = document.getElementById('editPurchaseItemsBody');
                tbody.innerHTML = '';
                const details = p.order_details || p.orderDetails || [];
                if (details.length > 0) {
                    details.forEach(item => {
                        addEditPurchaseRow(item.product_id, item.quantity, item.cost_price);
                    });
                } else {
                    addEditPurchaseRow();
                }

                calculateEditPurchaseTotals();
                $('#purchaseEditModal').modal('show');
            } else {
                errorToast(res.data?.message || 'Failed to load purchase details');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Error loading purchase details');
        }
    }

    function addEditPurchaseRow(productId = '', qty = 1, cost = 0) {
        const tbody = document.getElementById('editPurchaseItemsBody');
        let prodOptions = '<option value="">Select Battery Product</option>';
        productsList.forEach(p => {
            const sel = (p.id == productId) ? 'selected' : '';
            prodOptions += `<option value="${p.id}" data-cost="${p.cost_price}" ${sel}>${p.product_name}</option>`;
        });

        const row = document.createElement('tr');
        row.className = 'edit-item-row';
        row.innerHTML = `
            <td class="p-2">
                <select class="form-select text-xs edit-item-product rounded-lg h-[36px]" onchange="onEditItemProductChange(this)">
                    ${prodOptions}
                </select>
            </td>
            <td class="p-2 text-center">
                <input type="number" min="1" value="${qty}" class="form-control text-xs text-center edit-item-qty rounded-lg h-[36px]" oninput="calculateEditPurchaseTotals()">
            </td>
            <td class="p-2 text-end">
                <input type="number" step="0.01" value="${cost}" class="form-control text-xs text-end edit-item-cost rounded-lg h-[36px]" oninput="calculateEditPurchaseTotals()">
            </td>
            <td class="p-2 text-end font-bold text-slate-700 dark:text-slate-200 edit-item-subtotal">
                ৳ 0.00
            </td>
            <td class="p-2 text-center">
                <button type="button" onclick="this.closest('tr').remove(); calculateEditPurchaseTotals();" class="text-rose-500 hover:text-rose-700 p-1">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
        calculateEditPurchaseTotals();
    }

    function onEditItemProductChange(sel) {
        const opt = sel.options[sel.selectedIndex];
        const cost = opt.getAttribute('data-cost') || 0;
        const row = sel.closest('tr');
        row.querySelector('.edit-item-cost').value = cost;
        calculateEditPurchaseTotals();
    }

    function calculateEditPurchaseTotals() {
        let itemsSum = 0;
        document.querySelectorAll('#editPurchaseItemsBody tr.edit-item-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.edit-item-qty').value) || 0;
            const cost = parseFloat(row.querySelector('.edit-item-cost').value) || 0;
            const sub = qty * cost;
            row.querySelector('.edit-item-subtotal').innerText = '৳ ' + sub.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
            itemsSum += sub;
        });

        const discount = parseFloat($('#editPurchaseDiscount').val()) || 0;
        const delivery = parseFloat($('#editPurchaseDelivery').val()) || 0;
        const grandTotal = Math.max(0, itemsSum - discount + delivery);
        $('#editPurchaseGrandTotal').val(grandTotal.toFixed(2));

        const paid = parseFloat($('#editPurchasePaid').val()) || 0;
        const effectivePaid = paid + currentEditReturnAdj;
        const due = Math.max(0, grandTotal - effectivePaid);
        $('#editPurchaseDueText').text(due.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    }

    async function saveEditBatteryPurchase(e) {
        e.preventDefault();
        try {
            const id = $('#editPurchaseId').val();
            const supplier_id = $('#editPurchaseSupplier').val();
            const date = $('#editPurchaseDate').val();
            const referance_no = $('#editPurchaseRef').val();
            const discount_amount = $('#editPurchaseDiscount').val() || 0;
            const delivery_charge = $('#editPurchaseDelivery').val() || 0;
            const grand_subtotal = $('#editPurchaseGrandTotal').val();
            const paid_amount = $('#editPurchasePaid').val() || 0;
            const due_amount = Math.max(0, parseFloat(grand_subtotal) - (parseFloat(paid_amount) + currentEditReturnAdj));

            const products = [];
            document.querySelectorAll('#editPurchaseItemsBody tr.edit-item-row').forEach(row => {
                const pId = row.querySelector('.edit-item-product').value;
                const qty = row.querySelector('.edit-item-qty').value;
                const cost = row.querySelector('.edit-item-cost').value;
                if (pId && qty > 0) {
                    products.push({
                        product_id: pId,
                        quantity: qty,
                        cost_price: cost,
                        subtotal: parseFloat(qty) * parseFloat(cost)
                    });
                }
            });

            if (products.length === 0) {
                errorToast('Please add at least one battery product');
                return;
            }

            let formData = new FormData();
            formData.append('id', id);
            formData.append('supplier_id', supplier_id);
            formData.append('date', date);
            formData.append('referance_no', referance_no);
            formData.append('discount_amount', discount_amount);
            formData.append('delivery_charge', delivery_charge);
            formData.append('grand_subtotal', grand_subtotal);
            formData.append('paid_amount', paid_amount);
            formData.append('due_amount', due_amount);
            formData.append('products', JSON.stringify(products));

            const docInput = document.getElementById('editPurchaseAttachDocument');
            if (docInput && docInput.files[0]) {
                formData.append('img', docInput.files[0]);
            }

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/update-purchases', formData, {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            });
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'Battery purchase updated successfully');
                $('#purchaseEditModal').modal('hide');
                getBatteryPurchases();
            } else {
                errorToast(res.data?.message || 'Failed to update purchase');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast(err.response?.data?.message || 'Error updating purchase');
        }
    }
</script>

@endsection
