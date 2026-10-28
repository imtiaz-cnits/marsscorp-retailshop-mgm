<!-- Flatpickr Styles & Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
    /* Flatpickr Calendar on Top of Modals */
    .flatpickr-calendar {
        z-index: 999999 !important;
    }

    #purchaseUpdateModal .modal-dialog {
        max-width: 1080px !important;
        width: 95% !important;
        margin: 1.75rem auto;
        padding: 0 !important;
    }

    #purchaseUpdateModal .modal-content {
        border-radius: 16px !important;
        border: none !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35) !important;
        overflow: hidden;
        background: #ffffff;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        padding: 0 !important;
    }

    /* Dark Mode Modal Content */
    body[light-mode="dark"] #purchaseUpdateModal .modal-content,
    html[light-mode="dark"] #purchaseUpdateModal .modal-content,
    body[data-layout-mode="dark"] #purchaseUpdateModal .modal-content,
    html.dark #purchaseUpdateModal .modal-content,
    body.dark #purchaseUpdateModal .modal-content,
    body.dark-mode #purchaseUpdateModal .modal-content {
        background-color: #0f172a !important;
        color: #f8fafc !important;
    }

    body[light-mode="dark"] #purchaseUpdateModal .purchase-modal-body,
    html[light-mode="dark"] #purchaseUpdateModal .purchase-modal-body,
    body[data-layout-mode="dark"] #purchaseUpdateModal .purchase-modal-body,
    html.dark #purchaseUpdateModal .purchase-modal-body,
    body.dark #purchaseUpdateModal .purchase-modal-body,
    body.dark-mode #purchaseUpdateModal .purchase-modal-body {
        background-color: #0f172a !important;
    }

    body[light-mode="dark"] #purchaseUpdateModal .purchase-modal-footer,
    html[light-mode="dark"] #purchaseUpdateModal .purchase-modal-footer,
    body[data-layout-mode="dark"] #purchaseUpdateModal .purchase-modal-footer,
    html.dark #purchaseUpdateModal .purchase-modal-footer,
    body.dark #purchaseUpdateModal .purchase-modal-footer,
    body.dark-mode #purchaseUpdateModal .purchase-modal-footer {
        background-color: #0f172a !important;
        border-top-color: #334155 !important;
    }

    body[light-mode="dark"] #purchaseUpdateModal .purchase-clean-card,
    html[light-mode="dark"] #purchaseUpdateModal .purchase-clean-card,
    body[data-layout-mode="dark"] #purchaseUpdateModal .purchase-clean-card,
    html.dark #purchaseUpdateModal .purchase-clean-card,
    body.dark #purchaseUpdateModal .purchase-clean-card,
    body.dark-mode #purchaseUpdateModal .purchase-clean-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #purchaseUpdateModal .form-control,
    body[light-mode="dark"] #purchaseUpdateModal .form-select,
    html[light-mode="dark"] #purchaseUpdateModal .form-control,
    html[light-mode="dark"] #purchaseUpdateModal .form-select,
    body[data-layout-mode="dark"] #purchaseUpdateModal .form-control,
    body[data-layout-mode="dark"] #purchaseUpdateModal .form-select,
    html.dark #purchaseUpdateModal .form-control,
    html.dark #purchaseUpdateModal .form-select,
    body.dark #purchaseUpdateModal .form-control,
    body.dark #purchaseUpdateModal .form-select,
    body.dark-mode #purchaseUpdateModal .form-control,
    body.dark-mode #purchaseUpdateModal .form-select {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] #updateSupplierDropdownList,
    html[light-mode="dark"] #updateSupplierDropdownList,
    body[data-layout-mode="dark"] #updateSupplierDropdownList,
    html.dark #updateSupplierDropdownList,
    body.dark #updateSupplierDropdownList,
    body.dark-mode #updateSupplierDropdownList {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #updateSupplierDropdownList .update-supplier-select-item:hover,
    html[light-mode="dark"] #updateSupplierDropdownList .update-supplier-select-item:hover,
    body[data-layout-mode="dark"] #updateSupplierDropdownList .update-supplier-select-item:hover,
    html.dark #updateSupplierDropdownList .update-supplier-select-item:hover,
    body.dark #updateSupplierDropdownList .update-supplier-select-item:hover,
    body.dark-mode #updateSupplierDropdownList .update-supplier-select-item:hover {
        background-color: #0f172a !important;
    }

    body[light-mode="dark"] #purchaseUpdateModal .table-container,
    html[light-mode="dark"] #purchaseUpdateModal .table-container,
    body[data-layout-mode="dark"] #purchaseUpdateModal .table-container,
    html.dark #purchaseUpdateModal .table-container,
    body.dark #purchaseUpdateModal .table-container,
    body.dark-mode #purchaseUpdateModal .table-container {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #purchaseUpdateModal .responsive-table th,
    html[light-mode="dark"] #purchaseUpdateModal .responsive-table th {
        background-color: #0f172a !important;
        color: #ffffff !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #purchaseUpdateModal .responsive-table td,
    html[light-mode="dark"] #purchaseUpdateModal .responsive-table td {
        border-color: #334155 !important;
        color: #ffffff !important;
    }

    #purchaseUpdateModal label {
        text-align: left !important;
    }

    #purchaseUpdateModal select,
    #purchaseUpdateModal .form-select {
        cursor: pointer !important;
    }

    #updateProductDropdown:empty {
        display: none !important;
    }

    #updateProductDropdown .list-group-item {
        padding: 8px 12px;
        transition: all 0.15s ease;
        border-color: #e2e8f0;
    }

    #updateProductDropdown .list-group-item:hover {
        background-color: #f1f5f9 !important;
    }

    body[light-mode="dark"] #updateProductDropdown,
    html[light-mode="dark"] #updateProductDropdown,
    body[data-layout-mode="dark"] #updateProductDropdown,
    html.dark #updateProductDropdown,
    body.dark #updateProductDropdown {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #updateProductDropdown .list-group-item,
    html[light-mode="dark"] #updateProductDropdown .list-group-item,
    body[data-layout-mode="dark"] #updateProductDropdown .list-group-item,
    html.dark #updateProductDropdown .list-group-item,
    body.dark #updateProductDropdown .list-group-item {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }

    body[light-mode="dark"] #updateProductDropdown .list-group-item:hover,
    html[light-mode="dark"] #updateProductDropdown .list-group-item:hover,
    body[data-layout-mode="dark"] #updateProductDropdown .list-group-item:hover,
    html.dark #updateProductDropdown .list-group-item:hover,
    body.dark #updateProductDropdown .list-group-item:hover {
        background-color: #0f172a !important;
    }
</style>

<!-- Action Button Edit Modal Start -->
<section class="modal fade" id="purchaseUpdateModal" tabindex="-1" aria-labelledby="purchaseUpdateModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered" style="padding: 0 !important;">
        <div class="modal-content" style="padding: 0 !important;">
            <!-- Sticky Green Header with White Text & Red Close Icon -->
            <div style="background-color: #15803d; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 20; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <h2 style="font-size: 18px; font-weight: 700; color: #ffffff; margin: 0; padding: 0; line-height: 1.2; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-pen-to-square text-white text-base"></i>
                    <span>Update Purchase</span>
                </h2>
                <button type="button" class="close-btn close" data-bs-dismiss="modal" aria-label="Close" style="position: static !important; width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #dc2626; color: #ffffff; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.15s ease; margin: 0; padding: 0;" title="Close">
                    <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 14px;"></i>
                </button>
            </div>

            <form onsubmit="return UpdatePurchaseSave(event)" id="purchaseUpdateForm" style="display: flex; flex-direction: column; flex: 1 1 auto; overflow: hidden; margin: 0;">
                <input type="hidden" id="updateID" value="" />

                <!-- Scrollable Body Content -->
                <div class="purchase-modal-body p-4 sm:p-5" style="overflow-y: auto; flex: 1 1 auto; max-height: calc(90vh - 130px); text-align: left;">
                    
                    <!-- Top Info Cards: Supplier & Invoice Details -->
                    <div class="row g-3 mb-3">
                        <div class="col-lg-6">
                            <div class="purchase-clean-card rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 p-4 h-100">
                                <h5 class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 flex items-center gap-1.5 mb-3 text-left">
                                    <i class="fa-solid fa-truck-field text-emerald-600 dark:text-emerald-400"></i>
                                    <span>Supplier Information</span>
                                </h5>
                                <div class="flex items-center gap-2">
                                    <div class="relative flex-grow" id="updateSearchableSupplierWrapper">
                                        <input type="text" id="updateSupplierSearchInput" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" placeholder="Search or Select Supplier *" autocomplete="off" />
                                        <input type="hidden" id="UpdateSupplierSelect" value="none">
                                        <div id="updateSupplierDropdownList" class="dropdown-menu shadow-xl w-full p-0 overflow-auto rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800" style="max-height: 250px; display: none; position: absolute; z-index: 1050; top: 100%; left: 0;"></div>
                                    </div>
                                    <button type="button" class="inline-flex items-center gap-1 px-3 h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-150 border-0 flex-shrink-0 cursor-pointer" onclick="openSupplierCreateModal()">
                                        <i class="fa-solid fa-plus text-xs"></i>
                                        <span>New</span>
                                    </button>
                                </div>

                                <div id="updateSupplierCreditNotice" class="mt-3 d-none">
                                    <div class="p-2.5 rounded-xl flex justify-between items-center bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/40">
                                        <span id="updateSupplierCreditBadge" class="font-bold text-xs text-slate-800 dark:text-white">
                                            <i class="fa-solid fa-gift me-1 text-emerald-600 dark:text-emerald-400"></i> Return Credit Available: <strong>৳ 0.00</strong>
                                        </span>
                                        <label class="flex items-center gap-2 mb-0 px-2 py-1 bg-white dark:bg-slate-800 rounded-lg border border-emerald-300 dark:border-emerald-700 shadow-sm cursor-pointer">
                                            <input type="checkbox" id="updateUseReturnCreditCheckboxBanner" onchange="syncUpdateReturnCreditCheckbox(this.checked)" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                                            <span class="font-bold text-xs text-emerald-700 dark:text-emerald-400">Adjust Return Credit</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="purchase-clean-card rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 p-4 h-100">
                                <h5 class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 flex items-center gap-1.5 mb-3 text-left">
                                    <i class="fa-solid fa-file-invoice text-emerald-600 dark:text-emerald-400"></i>
                                    <span>Invoice & Voucher Details</span>
                                </h5>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Ref / Invoice No <span class="text-rose-500">*</span></label>
                                        <input type="text" placeholder="Reference No *" id="UpdateReferanceNo" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Purchase Date <span class="text-rose-500">*</span></label>
                                        <input type="text" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" id="UpdatePurchaseDate" placeholder="DD-MM-YYYY" autocomplete="off" required style="cursor: pointer;" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Payable Balance</label>
                                        <input type="text" readonly placeholder="Payable Amount" id="UpdatePurchasePayableAmount" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-100 dark:bg-slate-800/80 text-emerald-700 dark:text-emerald-400 text-xs font-bold" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="flex items-center justify-between mb-1">
                                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-0 text-left">Attach Invoice Doc</label>
                                            <span id="updateCurrentDocLink" class="text-[11px] font-semibold text-emerald-600 dark:text-emerald-400"></span>
                                        </div>
                                        <input type="file" id="UpdateAttachDocument" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Search & Scanner Box -->
                    <div class="purchase-clean-card rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 p-4 mb-3">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2 flex justify-between items-center text-left">
                            <span><i class="fa-solid fa-barcode text-emerald-600 dark:text-emerald-400 me-1"></i> Scan Barcode or Select Product <span class="text-rose-500">*</span></span>
                            <span class="px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/40 text-emerald-700 dark:text-emerald-400 text-xs font-bold"><i class="fa-solid fa-bolt me-1"></i> Auto-Cart Enabled</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <div class="flex-grow relative">
                                <input type="text" id="updateProductInputData" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" placeholder="Scan barcode or type product name/code (Auto-adds to list)..." autocomplete="off" />
                                <ul id="updateProductDropdown" class="list-group absolute w-full shadow-xl rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 mt-1" style="z-index: 1050; max-height: 280px; overflow-y: auto; display: none;"></ul>
                            </div>
                            <button type="button" class="inline-flex items-center gap-1 px-3 h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-150 border-0 flex-shrink-0 cursor-pointer" onclick="openProductCreateModal()" title="Add New Product">
                                <i class="fa-solid fa-plus text-xs"></i>
                                <span>New</span>
                            </button>
                            <button type="button" class="inline-flex items-center gap-1.5 px-4 h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-150 border-0 flex-shrink-0 cursor-pointer" onclick="openUpdatePurchaseCameraScanner()">
                                <i class="fa-solid fa-camera text-xs"></i>
                                <span>Scan Camera</span>
                            </button>
                        </div>
                    </div>

                    <!-- Cart Item Table -->
                    <div class="table-container rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden mb-3 bg-white dark:bg-slate-900 shadow-sm">
                        <table class="responsive-table w-full text-left border-collapse text-xs">
                            <thead class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                <tr>
                                    <th class="p-2.5">Product Name</th>
                                    <th class="p-2.5">Barcodes</th>
                                    <th class="p-2.5 text-center" style="width: 130px;">Qty</th>
                                    <th class="p-2.5 text-end" style="width: 130px;">Cost Price (৳)</th>
                                    <th class="p-2.5 text-end" style="width: 130px;">Sub Total</th>
                                    <th class="p-2.5 text-center" style="width: 60px;">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800" id="updateOrderTableBody">
                                <!-- Dynamic Items Loaded Here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Bottom Summary & Payment Details Card -->
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="purchase-clean-card rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 p-4 h-100">
                                <h5 class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 flex items-center gap-1.5 mb-3 text-left">
                                    <i class="fa-solid fa-credit-card text-emerald-600 dark:text-emerald-400"></i>
                                    <span>Payment Method & Details</span>
                                </h5>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Payment Method</label>
                                        <select class="form-select modern-select-dropdown w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-semibold focus:border-emerald-600 focus:outline-none transition-all" id="updatePaymentMethod" onchange="handleUpdatePurchasePaymentMethodChange(this.value)" style="cursor: pointer;">
                                            <option value="Cash" class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">Cash</option>
                                            <option value="Bkash" class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">Bkash</option>
                                            <option value="Nagad" class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">Nagad</option>
                                            <option value="Rocket" class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">Rocket</option>
                                            <option value="Bank" class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">Bank</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Paid Amount (৳)</label>
                                        <input type="number" step="any" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-bold" id="UpdatePaidAmount" value="0" />
                                    </div>

                                    <!-- Mobile Banking Fields (Bkash / Nagad / Rocket) -->
                                    <div class="col-12 mt-1" id="updateMobileBankingFields" style="display: none;">
                                        <div class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-100/70 dark:bg-slate-800/60">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Payment Number</label>
                                                    <input type="text" id="updatePaymentNumber" class="form-control w-full h-[36px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" placeholder="e.g. 017xxxxxxxx" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Transaction ID</label>
                                                    <input type="text" id="updateTransactionIdInput" class="form-control w-full h-[36px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" placeholder="e.g. TRX12345678" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bank Banking Fields (Bank) -->
                                    <div class="col-12 mt-1" id="updateBankBankingFields" style="display: none;">
                                        <div class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-100/70 dark:bg-slate-800/60">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Bank Name</label>
                                                    <input type="text" id="updateBankNameInput" class="form-control w-full h-[36px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" placeholder="e.g. Islami Bank / DBBL" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Bank / Account Number</label>
                                                    <input type="text" id="updateBankNumberInput" class="form-control w-full h-[36px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" placeholder="e.g. 2050xxxxxxxx" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="purchase-clean-card rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 p-4">
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between items-center py-1 border-b border-slate-200 dark:border-slate-800">
                                        <span class="text-slate-500 dark:text-slate-400 font-semibold">Total Quantity:</span>
                                        <span class="font-bold text-slate-800 dark:text-white text-sm" id="updateTotalQuantity">0.00</span>
                                    </div>
                                    <div class="flex justify-between items-center py-1 border-b border-slate-200 dark:border-slate-800">
                                        <span class="text-slate-500 dark:text-slate-400 font-semibold">Grand Subtotal:</span>
                                        <span class="font-bold text-slate-800 dark:text-white text-sm">৳ <span id="updateTotalSubTotal">0.00</span></span>
                                        <input type="hidden" id="UpdateGrandSubtotal" value="0.00" />
                                    </div>
                                    <div class="flex justify-between items-center py-1 border-b border-slate-200 dark:border-slate-800">
                                        <label for="UpdateDeliveryCharge" class="text-slate-600 dark:text-slate-300 font-semibold mb-0 cursor-pointer">
                                            Delivery & Transport Charge:
                                        </label>
                                        <div class="flex items-center gap-1">
                                            <span class="text-slate-400 font-bold text-xs">৳</span>
                                            <input type="number" step="any" min="0" class="form-control w-28 h-8 text-end font-bold rounded-lg text-xs border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white focus:border-emerald-600 focus:outline-none" id="UpdateDeliveryCharge" value="0" placeholder="0.00" oninput="calculateUpdateDuePayment()" />
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center py-1 border-b border-slate-200 dark:border-slate-800">
                                        <label for="updatePurchaseDiscountInput" class="text-slate-600 dark:text-slate-300 font-semibold mb-0 cursor-pointer flex items-center gap-1">
                                            <span>Discount:</span>
                                            <span id="updatePurchaseDiscountSummaryDisplay" class="text-[11px] font-bold text-rose-500"></span>
                                        </label>
                                        <div class="flex items-center gap-1.5">
                                            <select id="updatePurchaseDiscountType" class="form-select h-8 px-2 py-0 text-xs font-bold rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white focus:border-emerald-600 focus:outline-none cursor-pointer" onchange="calculateUpdateDuePayment()" style="width: 58px;">
                                                <option value="fixed">৳</option>
                                                <option value="percent">%</option>
                                            </select>
                                            <input type="number" step="any" min="0" class="form-control w-28 h-8 text-end font-bold rounded-lg text-xs border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white focus:border-emerald-600 focus:outline-none" id="updatePurchaseDiscountInput" value="0" placeholder="0.00" oninput="calculateUpdateDuePayment()" />
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center py-1" style="display: none;">
                                        <label class="inline-flex items-center gap-2 cursor-pointer mb-0">
                                            <input type="checkbox" id="updateUseReturnCreditCheckbox" onchange="syncUpdateReturnCreditCheckbox(this.checked)" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                                            <span class="font-bold text-xs text-emerald-700 dark:text-emerald-400">Return Credit Adj</span>
                                        </label>
                                        <input type="number" step="0.01" min="0" class="form-control w-28 h-8 text-end font-bold rounded-lg text-xs" id="updateReturnAdjustmentAmount" value="0.00" disabled oninput="calculateUpdateDuePayment()" />
                                    </div>
                                    <div class="flex justify-between items-center p-2.5 rounded-xl bg-slate-800 text-white dark:bg-slate-950 my-2">
                                        <span class="font-bold text-xs">Net Payable:</span>
                                        <span class="font-bold text-base text-emerald-400">৳ <span id="updateNetPayableDisplay">0.00</span></span>
                                        <input type="hidden" id="updateNetPayableAmount" value="0.00" />
                                    </div>
                                    <div class="flex justify-between items-center py-1 border-b border-slate-200 dark:border-slate-800">
                                        <span class="text-slate-500 dark:text-slate-400 font-semibold">Due Amount:</span>
                                        <span class="font-bold text-rose-600 dark:text-rose-400 text-sm">৳ <input type="text" id="UpdateDueAmount" value="0.00" readonly class="border-0 bg-transparent text-rose-600 dark:text-rose-400 font-bold text-end" style="width: 90px;" /></span>
                                    </div>
                                    <div class="flex justify-between items-center py-1">
                                        <span class="text-slate-500 dark:text-slate-400 font-semibold">Payment Status:</span>
                                        <span id="updatePaymentStatusDisplay" class="partial-payment-status">Unpaid</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fixed Sticky Bottom Modal Footer -->
                <div class="purchase-modal-footer bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 p-4 flex items-center justify-between gap-3 flex-shrink-0" style="position: sticky; bottom: 0; z-index: 20;">
                    <button type="button" class="px-5 h-[38px] rounded-xl text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:scale-[0.98] transition-all shadow-sm border-0 cursor-pointer" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="flex-grow sm:flex-grow-0 sm:min-w-[240px] h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-xs font-bold rounded-xl shadow transition-all duration-150 flex items-center justify-center gap-2 border-0 cursor-pointer">
                        <i class="fa-solid fa-check text-sm"></i>
                        <span>Update Purchase</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Action Button Edit Modal End -->

<!-- Camera Scanner Modal for Purchase Update -->
<div class="modal fade" id="updatePurchaseCameraScanModal" tabindex="-1" aria-hidden="true" style="z-index: 1070;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <h5 class="modal-title fs-6 fw-bold">
                    <i class="fa-solid fa-barcode text-success me-2"></i> Product Barcode Scanner (Update Purchase)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" onclick="stopUpdatePurchaseCameraScanner()"></button>
            </div>
            <div class="modal-body p-3 text-center bg-light">
                <div id="updatePurchaseCameraScannerStatus" class="alert alert-info py-2 small mb-3">
                    <i class="fa-solid fa-circle-notch fa-spin me-1"></i> Starting camera... Hold barcode in front of camera.
                </div>

                <div id="updatePurchaseReader" style="width: 100%; min-height: 250px; background: #000; border-radius: 12px; overflow: hidden; margin: 0 auto;"></div>

                <div class="d-flex justify-content-between align-items-center mt-3 px-1">
                    <span id="updatePurchaseLastScannedText" class="badge bg-dark text-wrap p-2" style="font-size: 13px;">Scanned: -</span>
                    <button type="button" class="btn btn-outline-dark btn-sm rounded-pill" onclick="switchUpdatePurchaseCamera()">
                        <i class="fa-solid fa-camera-rotate me-1"></i> Switch Camera
                    </button>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 py-2">
                <button type="button" class="btn btn-secondary btn-sm w-100 rounded-pill" data-bs-dismiss="modal" onclick="stopUpdatePurchaseCameraScanner()">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    let updateAllSuppliersData = [];
    let updateBarcodeLists = {};
    let updateDebounceTimer;
    window.updatePurchaseDatepicker = null;
    window.updateAvailableSupplierCredit = 0;
    window.updatePurchaseRawSubtotal = 0;

    function initUpdateDatePicker() {
        const dateInput = document.getElementById("UpdatePurchaseDate");
        if (dateInput && typeof flatpickr !== "undefined") {
            if (window.updatePurchaseDatepicker) {
                try { window.updatePurchaseDatepicker.destroy(); } catch(e) {}
            }
            window.updatePurchaseDatepicker = flatpickr(dateInput, {
                dateFormat: "d-m-Y",
                allowInput: true,
                clickOpens: true,
                disableMobile: true
            });
        }
    }

    function syncUpdateReturnCreditCheckbox(isChecked) {
        const tableCb = document.getElementById("updateUseReturnCreditCheckbox");
        const bannerCb = document.getElementById("updateUseReturnCreditCheckboxBanner");
        if (tableCb) tableCb.checked = isChecked;
        if (bannerCb) bannerCb.checked = isChecked;

        toggleUpdateReturnCreditAdjustment();
    }

    function toggleUpdateReturnCreditAdjustment() {
        const checkbox = document.getElementById("updateUseReturnCreditCheckbox");
        const returnAdjInput = document.getElementById("updateReturnAdjustmentAmount");
        const maxCredit = parseFloat(window.updateAvailableSupplierCredit || 0);

        if (checkbox && checkbox.checked) {
            returnAdjInput.disabled = false;
            returnAdjInput.style.backgroundColor = "#ffffff";
            returnAdjInput.setAttribute("max", maxCredit);
            returnAdjInput.value = maxCredit > 0 ? maxCredit.toFixed(2) : "0.00";
        } else {
            returnAdjInput.value = "0.00";
            returnAdjInput.disabled = true;
            returnAdjInput.style.backgroundColor = "#f1f5f9";
        }

        calculateUpdateDuePayment();
    }

    function calculateUpdateDuePayment() {
        const grandSubtotalInput = document.getElementById("UpdateGrandSubtotal");
        const deliveryInput = document.getElementById("UpdateDeliveryCharge");
        const discountInput = document.getElementById("updatePurchaseDiscountInput");
        const discountTypeSelect = document.getElementById("updatePurchaseDiscountType");
        const discountSummaryDisplay = document.getElementById("updatePurchaseDiscountSummaryDisplay");
        const netPayableInput = document.getElementById("updateNetPayableAmount");
        const netDisplay = document.getElementById("updateNetPayableDisplay");
        const returnAdjInput = document.getElementById("updateReturnAdjustmentAmount");
        const checkbox = document.getElementById("updateUseReturnCreditCheckbox");
        const paidAmountInput = document.getElementById("UpdatePaidAmount");
        const dueAmountInput = document.getElementById("UpdateDueAmount");
        const paymentStatusDisplay = document.getElementById("updatePaymentStatusDisplay");

        let rawSubtotal = window.updatePurchaseRawSubtotal || parseFloat(grandSubtotalInput?.value) || 0;
        let delivery = parseFloat(deliveryInput?.value) || 0;
        let discountNum = parseFloat(discountInput?.value) || 0;
        let discountType = discountTypeSelect ? discountTypeSelect.value : 'fixed';

        let discountAmount = (discountType === 'percent') ? (rawSubtotal * discountNum / 100) : discountNum;
        if (discountAmount > rawSubtotal) discountAmount = rawSubtotal;
        if (discountAmount < 0) discountAmount = 0;

        if (discountSummaryDisplay) {
            discountSummaryDisplay.textContent = (discountAmount > 0) 
                ? (discountType === 'percent' ? `(-৳${discountAmount.toFixed(2)})` : '')
                : '';
        }

        let totalWithDelivery = Math.max(0, (rawSubtotal - discountAmount) + delivery);
        let returnAdj = 0;
        if (checkbox && checkbox.checked) {
            let maxCredit = parseFloat(window.updateAvailableSupplierCredit || 0);
            returnAdj = parseFloat(returnAdjInput?.value) || 0;

            if (returnAdj > maxCredit) {
                returnAdj = maxCredit;
                returnAdjInput.value = maxCredit.toFixed(2);
            }
            if (returnAdj > totalWithDelivery) {
                returnAdj = totalWithDelivery;
                returnAdjInput.value = totalWithDelivery.toFixed(2);
            }
        } else {
            if (returnAdjInput) returnAdjInput.value = "0.00";
        }

        let netPayable = Math.max(0, totalWithDelivery - returnAdj);
        if (netPayableInput) netPayableInput.value = netPayable.toFixed(2);
        if (netDisplay) netDisplay.textContent = netPayable.toFixed(2);

        let paidAmount = parseFloat(paidAmountInput?.value) || 0;
        let dueAmount = Math.max(0, netPayable - paidAmount);

        if (dueAmountInput) dueAmountInput.value = dueAmount.toFixed(2);

        if (paymentStatusDisplay) {
            if (paidAmount === 0 && netPayable > 0) {
                paymentStatusDisplay.textContent = "Unpaid";
                paymentStatusDisplay.className = "partial-payment-status bg-danger text-white";
            } else if (paidAmount < netPayable) {
                paymentStatusDisplay.textContent = "Partial Paid";
                paymentStatusDisplay.className = "partial-payment-status";
            } else {
                paymentStatusDisplay.textContent = "Fully Paid";
                paymentStatusDisplay.className = "fully-paid-status";
            }
        }
    }

    function handleUpdatePurchasePaymentMethodChange(method) {
        const mobileFields = document.getElementById('updateMobileBankingFields');
        const bankFields = document.getElementById('updateBankBankingFields');

        if (['Bkash', 'Nagad', 'Rocket'].includes(method)) {
            if (mobileFields) mobileFields.style.display = 'block';
            if (bankFields) bankFields.style.display = 'none';
        } else if (method === 'Bank') {
            if (mobileFields) mobileFields.style.display = 'none';
            if (bankFields) bankFields.style.display = 'block';
        } else {
            if (mobileFields) mobileFields.style.display = 'none';
            if (bankFields) bankFields.style.display = 'none';
        }
    }

    async function LoadUpdateSuppliersDropdown() {
        try {
            let res = await axios.get("/api/supplier-list", HeaderToken());
            updateAllSuppliersData = res.data.SupplierData || res.data.rows || [];
            renderUpdateSupplierDropdownItems(updateAllSuppliersData);
        } catch (e) {
            console.error("Error loading suppliers:", e);
        }
    }

    function renderUpdateSupplierDropdownItems(suppliers) {
        const listContainer = document.getElementById("updateSupplierDropdownList");
        if (!listContainer) return;

        if (!suppliers || suppliers.length === 0) {
            listContainer.innerHTML = `<div class="p-2.5 text-slate-400 text-center text-xs">No suppliers found</div>`;
            return;
        }

        let html = suppliers.map(s => {
            const creditVal = parseFloat(s.return_credit_balance || 0);
            const creditLabel = creditVal > 0 ? `<span class="badge bg-teal ms-1" style="background:#0d9488;">🎁 ৳${creditVal.toFixed(2)}</span>` : '';
            const payable = parseFloat(s.purchase_payable_amount || 0);
            const payableLabel = payable > 0 ? `<span class="badge bg-danger ms-1">Due: ৳${payable.toFixed(2)}</span>` : '';
            const suppIdBadge = s.supplier_id ? `<span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 me-1 font-mono">${s.supplier_id}</span>` : '';

            return `
                <div class="dropdown-item px-3.5 py-2 border-b border-slate-100 dark:border-slate-800 update-supplier-select-item hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors"
                     data-id="${s.id}"
                     data-name="${s.name}"
                     data-payable="${payable}"
                     data-credit="${creditVal}"
                     style="cursor: pointer;">
                     <div class="font-bold text-slate-800 dark:text-slate-100 text-xs flex items-center justify-between">
                         <span>${suppIdBadge} ${s.name} ${s.company ? `<span class="text-[11px] font-normal text-slate-500 dark:text-slate-400">(${s.company})</span>` : ''}</span>
                         <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono">${s.mobile || ''}</span>
                     </div>
                     <div class="text-[11px] text-slate-400 mt-0.5">${payableLabel} ${creditLabel}</div>
                </div>
            `;
        }).join('');

        listContainer.innerHTML = html;

        listContainer.querySelectorAll('.update-supplier-select-item').forEach(item => {
            item.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const payable = this.getAttribute('data-payable');
                const credit = parseFloat(this.getAttribute('data-credit')) || 0;

                selectUpdateSupplierItem({
                    id,
                    name,
                    payable,
                    credit
                });
                listContainer.style.display = 'none';
            });
        });
    }

    function selectUpdateSupplierItem(s) {
        document.getElementById("UpdateSupplierSelect").value = s.id;
        document.getElementById("updateSupplierSearchInput").value = s.name;
        document.getElementById("UpdatePurchasePayableAmount").value = s.payable || 0;

        window.updateAvailableSupplierCredit = s.credit || 0;

        const creditNotice = document.getElementById("updateSupplierCreditNotice");
        const creditBadge = document.getElementById("updateSupplierCreditBadge");
        const returnAdjInput = document.getElementById("updateReturnAdjustmentAmount");

        if (typeof syncUpdateReturnCreditCheckbox === 'function') {
            syncUpdateReturnCreditCheckbox(false);
        }

        if (s.credit > 0) {
            creditBadge.innerHTML = `<i class="fa-solid fa-gift me-1" style="color: #0d9488;"></i> Return Credit Available: <strong>৳ ${s.credit.toFixed(2)}</strong>`;
            creditNotice.classList.remove("d-none");
            if (returnAdjInput) returnAdjInput.setAttribute("max", s.credit);
        } else {
            creditNotice.classList.add("d-none");
            if (returnAdjInput) returnAdjInput.setAttribute("max", "0");
        }

        calculateUpdateDuePayment();
    }

    function addUpdateProductToTable(product, specificBarcode = null, initialQty = 1, initialCost = null) {
        const tableBody = document.getElementById("updateOrderTableBody");
        const existingRow = document.querySelector(`#updateOrderTableBody tr[data-product-id="${product.id}"]`);

        if (existingRow && !initialCost) {
            const qtyInput = existingRow.querySelector(".quantity");
            qtyInput.value = parseInt(qtyInput.value) + 1;

            if (specificBarcode) {
                appendBarcodeToUpdateRow(existingRow, product.id, specificBarcode);
            }

            updateUpdateRowSubtotal(existingRow);
            updateUpdateTotals();
            return;
        }

        let initialBarcode = specificBarcode || '';
        if (!initialBarcode) {
            if (Array.isArray(product.all_codes) && product.all_codes.length > 0) {
                initialBarcode = product.all_codes[0];
            } else if (product.product_code) {
                if (Array.isArray(product.product_code)) {
                    initialBarcode = product.product_code.join(', ');
                } else {
                    try {
                        const parsed = JSON.parse(product.product_code);
                        initialBarcode = Array.isArray(parsed) ? parsed.join(', ') : product.product_code;
                    } catch(e) {
                        initialBarcode = product.product_code;
                    }
                }
            }
        }

        const barcodeArr = initialBarcode ? initialBarcode.split(',').map(b => b.trim()).filter(Boolean) : [];
        updateBarcodeLists[product.id] = barcodeArr;

        const row = document.createElement("tr");
        row.setAttribute("data-product-id", product.id);
        row.className = "hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors";

        const productName = product.name || product.product_name || 'Product';
        const costPrice = initialCost !== null ? parseFloat(initialCost) : (parseFloat(product.cost_price) || 0);
        const subtotal = initialQty * costPrice;

        row.innerHTML = `
            <td class="p-2.5 font-bold text-slate-800 dark:text-slate-100">
                <span class="product-id-val d-none">${product.id}</span>
                <span>${productName}</span>
                <div class="text-[11px] text-slate-400 font-normal">ID: ${product.product_id || product.id}</div>
            </td>
            <td class="p-2.5">
                <div class="d-flex align-items-center gap-1">
                    <input type="text" class="form-control form-control-sm update-row-barcode" style="font-size: 11px; width: 140px;" value="${initialBarcode}" readonly />
                    <button type="button" class="btn btn-sm btn-outline-secondary px-1.5 py-0.5" onclick="promptUpdateAddBarcode(this, ${product.id})" title="Add Barcode">
                        <i class="fa-solid fa-plus text-[10px]"></i>
                    </button>
                </div>
            </td>
            <td class="p-2.5 text-center">
                <input type="number" class="form-control form-control-sm quantity text-center font-bold" min="1" value="${initialQty}" style="width: 70px; margin: 0 auto;" oninput="updateUpdateRowSubtotal(this.closest('tr')); updateUpdateTotals();" />
            </td>
            <td class="p-2.5 text-end">
                <input type="number" step="any" class="form-control form-control-sm cost-price text-end font-bold" value="${costPrice}" style="width: 90px; margin-left: auto;" oninput="updateUpdateRowSubtotal(this.closest('tr')); updateUpdateTotals();" />
            </td>
            <td class="p-2.5 text-end font-bold text-slate-800 dark:text-white subtotal">৳ ${subtotal.toFixed(2)}</td>
            <td class="p-2.5 text-center">
                <button type="button" class="btn btn-sm btn-outline-danger p-1 rounded-lg" onclick="removeUpdateProductRow(this)" title="Remove">
                    <i class="fa-solid fa-trash text-xs"></i>
                </button>
            </td>
        `;

        tableBody.appendChild(row);
        updateUpdateTotals();
    }

    function appendBarcodeToUpdateRow(row, productId, barcode) {
        if (!updateBarcodeLists[productId]) updateBarcodeLists[productId] = [];
        if (!updateBarcodeLists[productId].includes(barcode)) {
            updateBarcodeLists[productId].push(barcode);
            const input = row.querySelector(".update-row-barcode");
            if (input) input.value = updateBarcodeLists[productId].join(', ');
        }
    }

    function promptUpdateAddBarcode(btn, productId) {
        const barcode = prompt("Enter additional barcode for this product:");
        if (barcode && barcode.trim()) {
            const row = btn.closest("tr");
            appendBarcodeToUpdateRow(row, productId, barcode.trim());
        }
    }

    function updateUpdateRowSubtotal(row) {
        const qty = parseInt(row.querySelector(".quantity").value) || 0;
        const price = parseFloat(row.querySelector(".cost-price").value) || 0;
        const subtotal = qty * price;
        row.querySelector(".subtotal").innerText = `৳ ${subtotal.toFixed(2)}`;
    }

    function removeUpdateProductRow(btn) {
        const row = btn.closest("tr");
        const productId = row.getAttribute("data-product-id");
        delete updateBarcodeLists[productId];
        row.remove();
        updateUpdateTotals();
    }

    function updateUpdateTotals() {
        let totalQty = 0;
        let totalSub = 0;

        document.querySelectorAll("#updateOrderTableBody tr").forEach(row => {
            const qty = parseInt(row.querySelector(".quantity").value) || 0;
            const price = parseFloat(row.querySelector(".cost-price").value) || 0;
            totalQty += qty;
            totalSub += qty * price;
        });

        window.updatePurchaseRawSubtotal = totalSub;
        const totalQtyEl = document.getElementById("updateTotalQuantity");
        const totalSubEl = document.getElementById("updateTotalSubTotal");
        const grandSubEl = document.getElementById("UpdateGrandSubtotal");

        if (totalQtyEl) totalQtyEl.innerText = totalQty;
        if (totalSubEl) totalSubEl.innerText = totalSub.toFixed(2);
        if (grandSubEl) grandSubEl.value = totalSub.toFixed(2);

        calculateUpdateDuePayment();
    }

    async function FillUpUpdateForm(id) {
        try {
            document.getElementById('updateID').value = id;
            updateBarcodeLists = {};

            const tableBody = document.getElementById("updateOrderTableBody");
            if (tableBody) tableBody.innerHTML = "";

            await LoadUpdateSuppliersDropdown();

            let res = await axios.post("/api/purchases-by-id", {
                id: id.toString()
            }, HeaderToken());

            let data = res.data.rows;
            if (data) {
                document.getElementById('UpdateReferanceNo').value = data.referance_no || '';

                let dateVal = data.date || '';
                if (dateVal && dateVal.includes('-')) {
                    let parts = dateVal.split('-');
                    if (parts[0].length === 4) {
                        dateVal = `${parts[2]}-${parts[1]}-${parts[0]}`;
                    }
                }
                document.getElementById('UpdatePurchaseDate').value = dateVal;
                initUpdateDatePicker();
                if (window.updatePurchaseDatepicker) {
                    window.updatePurchaseDatepicker.setDate(dateVal, true, "d-m-Y");
                }

                document.getElementById('UpdateDeliveryCharge').value = data.delivery_charge || 0;
                document.getElementById('UpdatePaidAmount').value = data.paid_amount || 0;

                // Discount
                const discTypeSelect = document.getElementById('updatePurchaseDiscountType');
                const discInput = document.getElementById('updatePurchaseDiscountInput');
                if (discTypeSelect) discTypeSelect.value = data.discount_type || 'fixed';
                if (discInput) {
                    if (data.discount_type === 'percent' && data.discount_rate) {
                        discInput.value = data.discount_rate;
                    } else {
                        discInput.value = data.discount_amount || 0;
                    }
                }

                // Return Adjustment
                const returnAdjInput = document.getElementById('updateReturnAdjustmentAmount');
                if (returnAdjInput) returnAdjInput.value = data.return_adjustment_amount || 0;

                // Reset file input & show current document link
                const docInput = document.getElementById('UpdateAttachDocument');
                if (docInput) docInput.value = '';

                const docLink = document.getElementById('updateCurrentDocLink');
                if (docLink) {
                    if (data.attach_document) {
                        let docSrc = data.attach_document.startsWith('http') || data.attach_document.startsWith('/') ? data.attach_document : `/${data.attach_document}`;
                        docLink.innerHTML = `<a href="${docSrc}" target="_blank" class="hover:underline flex items-center gap-1 text-emerald-600 dark:text-emerald-400 font-semibold"><i class="fa-solid fa-file"></i> View Current</a>`;
                    } else {
                        docLink.innerHTML = '';
                    }
                }

                // Supplier
                if (data.supplier_id) {
                    document.getElementById('UpdateSupplierSelect').value = data.supplier_id;
                    const foundSupp = updateAllSuppliersData.find(s => s.id == data.supplier_id);
                    if (foundSupp) {
                        selectUpdateSupplierItem(foundSupp);
                    } else if (data.supplier) {
                        selectUpdateSupplierItem({
                            id: data.supplier_id,
                            name: typeof data.supplier === 'object' ? data.supplier.name : data.supplier,
                            payable: data.purchase_payable_amount || 0,
                            credit: 0
                        });
                    }
                }

                // Payment Method & Trx Details
                const firstPayment = (data.payment_details && data.payment_details.length > 0) ? data.payment_details[0] : null;
                const pMethod = firstPayment?.payment_method || 'Cash';
                const methodSelect = document.getElementById('updatePaymentMethod');
                if (methodSelect) {
                    methodSelect.value = pMethod;
                    handleUpdatePurchasePaymentMethodChange(pMethod);
                }

                if (firstPayment && firstPayment.transaction_id) {
                    const trx = firstPayment.transaction_id;
                    if (['Bkash', 'Nagad', 'Rocket'].includes(pMethod)) {
                        const parts = trx.split('|').map(s => s.trim());
                        parts.forEach(p => {
                            if (p.toLowerCase().startsWith('number:')) {
                                const num = p.split(':')[1]?.trim() || '';
                                const el = document.getElementById('updatePaymentNumber');
                                if (el) el.value = num;
                            } else if (p.toLowerCase().startsWith('trxid:')) {
                                const t = p.split(':')[1]?.trim() || '';
                                const el = document.getElementById('updateTransactionIdInput');
                                if (el) el.value = t;
                            }
                        });
                    } else if (pMethod === 'Bank') {
                        const parts = trx.split('|').map(s => s.trim());
                        parts.forEach(p => {
                            if (p.toLowerCase().startsWith('bank:')) {
                                const b = p.split(':')[1]?.trim() || '';
                                const el = document.getElementById('updateBankNameInput');
                                if (el) el.value = b;
                            } else if (p.toLowerCase().startsWith('a/c:')) {
                                const a = p.split(':')[1]?.trim() || '';
                                const el = document.getElementById('updateBankNumberInput');
                                if (el) el.value = a;
                            }
                        });
                    }
                }

                // Load Products into Items Table
                const details = data.order_details || data.orderDetails || [];
                details.forEach(od => {
                    const prod = od.product || {};
                    addUpdateProductToTable({
                        id: od.product_id,
                        name: prod.name || prod.product_name,
                        product_id: prod.product_id,
                        cost_price: od.cost_price,
                        product_code: prod.product_code
                    }, null, parseInt(od.quantity) || 1, parseFloat(od.cost_price) || 0);
                });

                updateUpdateTotals();
            }
        } catch (e) {
            console.error("FillUpUpdateForm error:", e);
            if (typeof unauthorized === 'function') {
                unauthorized(e.response ? e.response.status : 500);
            }
        }
    }

    async function UpdatePurchaseSave(event) {
        if (event) event.preventDefault();

        // 1. Validate Supplier
        let supplierIdVal = document.getElementById('UpdateSupplierSelect')?.value;
        const suppInputVal = document.getElementById('updateSupplierSearchInput')?.value.trim();

        if ((!supplierIdVal || supplierIdVal === 'none') && suppInputVal && updateAllSuppliersData.length > 0) {
            const query = suppInputVal.toLowerCase();
            const matched = updateAllSuppliersData.find(s => 
                (s.supplier_id && s.supplier_id.toLowerCase() === query) ||
                (s.name && s.name.toLowerCase() === query) ||
                (s.mobile && s.mobile === query)
            );
            if (matched) {
                selectUpdateSupplierItem(matched);
                supplierIdVal = matched.id;
            }
        }

        if (!supplierIdVal || supplierIdVal === 'none' || supplierIdVal.trim() === '') {
            errorToast("Please select a Supplier!");
            document.getElementById('updateSupplierSearchInput')?.focus();
            return false;
        }

        // 2. Validate Reference No
        const refNoVal = document.getElementById('UpdateReferanceNo')?.value.trim();
        if (!refNoVal) {
            errorToast("Please enter Reference No!");
            document.getElementById('UpdateReferanceNo')?.focus();
            return false;
        }

        // 3. Validate Purchase Date
        const purchaseDateVal = document.getElementById('UpdatePurchaseDate')?.value.trim();
        if (!purchaseDateVal) {
            errorToast("Please select a Purchase Date!");
            document.getElementById('UpdatePurchaseDate')?.focus();
            return false;
        }

        // 4. Validate Products
        const products = [];
        const rows = document.querySelectorAll('#updateOrderTableBody tr');

        rows.forEach(row => {
            const productId = row.querySelector('.product-id-val').innerText.trim();
            const quantity = parseInt(row.querySelector('.quantity').value) || 0;
            const costPrice = parseFloat(row.querySelector('.cost-price').value) || 0;
            const subtotalText = row.querySelector('.subtotal').innerText.replace(/[^\d.]/g, '');
            const subtotal = parseFloat(subtotalText) || (quantity * costPrice);
            const ProductCodes = updateBarcodeLists[productId] || [];

            if (quantity <= 0) {
                errorToast("Quantity must be greater than zero!");
                return;
            }

            products.push({
                product_id: productId,
                quantity: quantity,
                product_code: ProductCodes,
                cost_price: costPrice,
                subtotal: subtotal
            });
        });

        if (products.length === 0) {
            errorToast("At least one product must be added to the purchase!");
            return false;
        }

        const selectedMethod = document.getElementById('updatePaymentMethod')?.value || 'Cash';
        let trxDetails = '';
        if (['Bkash', 'Nagad', 'Rocket'].includes(selectedMethod)) {
            const pNum = document.getElementById('updatePaymentNumber')?.value.trim() || '';
            const tId = document.getElementById('updateTransactionIdInput')?.value.trim() || '';
            trxDetails = [pNum ? 'Number: ' + pNum : '', tId ? 'TrxID: ' + tId : ''].filter(Boolean).join(' | ');
        } else if (selectedMethod === 'Bank') {
            const bName = document.getElementById('updateBankNameInput')?.value.trim() || '';
            const bNum = document.getElementById('updateBankNumberInput')?.value.trim() || '';
            trxDetails = [bName ? 'Bank: ' + bName : '', bNum ? 'A/C: ' + bNum : ''].filter(Boolean).join(' | ');
        }

        let formData = new FormData();
        formData.append('id', $('#updateID').val());
        formData.append('supplier_id', supplierIdVal);
        formData.append('purchase_payable_amount', document.getElementById('UpdatePurchasePayableAmount')?.value || 0);
        formData.append('date', document.getElementById('UpdatePurchaseDate').value);
        formData.append('referance_no', document.getElementById('UpdateReferanceNo').value);
        formData.append('payment_status', document.getElementById('updatePaymentStatusDisplay')?.textContent.trim() || 'Unpaid');
        formData.append('grand_subtotal', parseFloat(document.getElementById('UpdateGrandSubtotal').value) || 0);
        formData.append('delivery_charge', parseFloat(document.getElementById('UpdateDeliveryCharge')?.value) || 0);

        let rawSubVal = window.updatePurchaseRawSubtotal || parseFloat(document.getElementById('UpdateGrandSubtotal').value) || 0;
        let discTypeVal = document.getElementById('updatePurchaseDiscountType')?.value || 'fixed';
        let discNumVal = parseFloat(document.getElementById('updatePurchaseDiscountInput')?.value) || 0;
        let discAmountVal = (discTypeVal === 'percent') ? (rawSubVal * discNumVal / 100) : discNumVal;
        if (discAmountVal < 0) discAmountVal = 0;
        formData.append('discount_amount', discAmountVal || 0);
        formData.append('discount_type', discTypeVal);
        formData.append('discount_rate', discTypeVal === 'percent' ? discNumVal : '');

        formData.append('return_adjustment_amount', parseFloat(document.getElementById('updateReturnAdjustmentAmount')?.value) || 0);
        formData.append('payment_method', selectedMethod);
        formData.append('paid_amount', parseFloat(document.getElementById('UpdatePaidAmount')?.value) || 0);
        formData.append('due_amount', parseFloat(document.getElementById('UpdateDueAmount')?.value) || 0);
        formData.append('transaction_id', trxDetails);
        formData.append('products', JSON.stringify(products));

        const imgInput = document.getElementById('UpdateAttachDocument');
        if (imgInput && imgInput.files[0]) {
            formData.append('img', imgInput.files[0]);
        }

        const config = {
            headers: {
                'content-type': 'multipart/form-data',
                ...HeaderToken().headers
            }
        };

        try {
            if (typeof showLoader === 'function') showLoader();
            let res = await axios.post("/api/update-purchases", formData, config);
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message);
                $("#purchaseUpdateModal").modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                errorToast(res.data.message);
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error("Update Purchase error:", e);
            errorToast(e.response?.data?.message || "Failed to update purchase.");
        }
        return false;
    }

    // Alias for existing callers
    window.Update = UpdatePurchaseSave;

    /* ========================================================
       Camera Scanner for Update Purchase
       ======================================================== */
    let updatePurchaseHtml5QrCode = null;
    let updatePurchaseFacingMode = "environment";
    let lastUpdatePurchaseScannedCode = "";

    function openUpdatePurchaseCameraScanner() {
        const modalEl = new bootstrap.Modal(document.getElementById('updatePurchaseCameraScanModal'));
        modalEl.show();
        setTimeout(() => {
            startUpdatePurchaseCameraScanner();
        }, 350);
    }

    function startUpdatePurchaseCameraScanner() {
        if (updatePurchaseHtml5QrCode && updatePurchaseHtml5QrCode.isScanning) {
            updatePurchaseHtml5QrCode.stop().then(() => initUpdatePurchaseHtml5QrCode()).catch(() => initUpdatePurchaseHtml5QrCode());
        } else {
            initUpdatePurchaseHtml5QrCode();
        }
    }

    function initUpdatePurchaseHtml5QrCode() {
        const statusEl = document.getElementById('updatePurchaseCameraScannerStatus');
        if (statusEl) {
            statusEl.className = "alert alert-info py-2 small mb-3";
            statusEl.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-1"></i> Starting camera... Hold barcode in front of camera.';
        }

        updatePurchaseHtml5QrCode = new Html5Qrcode("updatePurchaseReader");
        const config = {
            fps: 15,
            qrbox: { width: 280, height: 160 },
            aspectRatio: 1.777778
        };

        updatePurchaseHtml5QrCode.start(
            { facingMode: updatePurchaseFacingMode },
            config,
            (decodedText) => {
                onUpdatePurchaseBarcodeSuccess(decodedText);
            },
            () => {}
        ).catch((err) => {
            console.error("Camera Start Error:", err);
            if (statusEl) {
                statusEl.className = "alert alert-danger py-2 small mb-3";
                statusEl.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> Camera permission denied or device not found.';
            }
        });
    }

    function onUpdatePurchaseBarcodeSuccess(code) {
        code = code.trim();
        if (!code) return;

        if (code === lastUpdatePurchaseScannedCode) return;
        lastUpdatePurchaseScannedCode = code;

        const badge = document.getElementById('updatePurchaseLastScannedText');
        if (badge) {
            badge.textContent = "Scanned: " + code;
            badge.className = "badge bg-success text-wrap p-2";
        }

        const input = document.getElementById("updateProductInputData");
        if (input) {
            input.value = code;
            processUpdateBarcodeOrSearchDirect(code);
        }

        stopUpdatePurchaseCameraScanner();
        const modalEl = bootstrap.Modal.getInstance(document.getElementById('updatePurchaseCameraScanModal'));
        if (modalEl) modalEl.hide();

        setTimeout(() => {
            lastUpdatePurchaseScannedCode = "";
        }, 2000);
    }

    function switchUpdatePurchaseCamera() {
        updatePurchaseFacingMode = updatePurchaseFacingMode === "environment" ? "user" : "environment";
        startUpdatePurchaseCameraScanner();
    }

    function stopUpdatePurchaseCameraScanner() {
        if (updatePurchaseHtml5QrCode) {
            updatePurchaseHtml5QrCode.stop().then(() => {
                updatePurchaseHtml5QrCode.clear();
            }).catch((err) => {
                console.error("Failed to stop scanner:", err);
            });
        }
    }

    async function processUpdateBarcodeOrSearchDirect(query) {
        try {
            const res = await axios.post("/api/product-search-by-name", { query: query }, HeaderToken());
            if (res.data.status === "success" && res.data.data && res.data.data.length > 0) {
                const found = res.data.data.find(p => 
                    (p.product_code && p.product_code.toLowerCase() === query.toLowerCase()) ||
                    (Array.isArray(p.all_codes) && p.all_codes.some(c => String(c).toLowerCase() === query.toLowerCase()))
                ) || res.data.data[0];

                addUpdateProductToTable(found, query);
                const input = document.getElementById("updateProductInputData");
                if (input) input.value = "";
                const dd = document.getElementById("updateProductDropdown");
                if (dd) {
                    dd.style.display = "none";
                    dd.innerHTML = "";
                }
            } else {
                errorToast("No product found matching: " + query);
            }
        } catch (e) {
            console.error("Direct barcode search error:", e);
        }
    }

    $(document).ready(function() {
        $('#purchaseUpdateModal').appendTo("body");
        initUpdateDatePicker();

        const paidAmountInput = document.getElementById("UpdatePaidAmount");
        if (paidAmountInput) {
            paidAmountInput.addEventListener("input", calculateUpdateDuePayment);
        }

        // Supplier search input listeners
        const suppInput = document.getElementById("updateSupplierSearchInput");
        const suppList = document.getElementById("updateSupplierDropdownList");

        if (suppInput && suppList) {
            suppInput.addEventListener("focus", function() {
                suppList.style.display = "block";
                renderUpdateSupplierDropdownItems(updateAllSuppliersData);
            });

            suppInput.addEventListener("input", function() {
                const query = this.value.toLowerCase().trim();
                suppList.style.display = "block";

                const filtered = updateAllSuppliersData.filter(s =>
                    (s.name && s.name.toLowerCase().includes(query)) ||
                    (s.mobile && s.mobile.toLowerCase().includes(query)) ||
                    (s.company && s.company.toLowerCase().includes(query)) ||
                    (s.supplier_id && s.supplier_id.toLowerCase().includes(query))
                );

                renderUpdateSupplierDropdownItems(filtered);
            });

            suppInput.addEventListener("change", function() {
                const query = this.value.trim().toLowerCase();
                if (!query) {
                    document.getElementById("UpdateSupplierSelect").value = "none";
                    return;
                }
                const match = updateAllSuppliersData.find(s => 
                    (s.supplier_id && s.supplier_id.toLowerCase() === query) ||
                    (s.name && s.name.toLowerCase() === query) ||
                    (s.mobile && s.mobile === query)
                );
                if (match) {
                    selectUpdateSupplierItem(match);
                }
            });

            document.addEventListener("click", function(e) {
                const wrapper = document.getElementById("updateSearchableSupplierWrapper");
                if (wrapper && !wrapper.contains(e.target)) {
                    suppList.style.display = "none";
                }
            });
        }

        // Product search input listeners for update
        const pInput = document.getElementById("updateProductInputData");
        const pDropdown = document.getElementById("updateProductDropdown");

        if (pInput) {
            pInput.addEventListener("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    const code = this.value.trim();
                    if (code) {
                        processUpdateBarcodeOrSearchDirect(code);
                    }
                }
            });

            pInput.addEventListener("focus", function() {
                if (this.value.trim() && pDropdown && pDropdown.children.length > 0) {
                    pDropdown.style.display = "block";
                }
            });

            pInput.addEventListener("input", function() {
                clearTimeout(updateDebounceTimer);
                const query = this.value.trim();

                if (!query) {
                    if (pDropdown) {
                        pDropdown.style.display = "none";
                        pDropdown.innerHTML = "";
                    }
                    return;
                }

                updateDebounceTimer = setTimeout(async () => {
                    try {
                        const res = await axios.post("/api/product-search-by-name", { query: query }, HeaderToken());
                        if (!pDropdown) return;
                        pDropdown.innerHTML = "";

                        if (res.data.status === "success" && res.data.data && res.data.data.length > 0) {
                            const exactMatch = res.data.data.find(p => 
                                (p.product_code && p.product_code.toLowerCase() === query.toLowerCase()) ||
                                (Array.isArray(p.all_codes) && p.all_codes.some(c => String(c).toLowerCase() === query.toLowerCase()))
                            );

                            if (exactMatch && res.data.data.length === 1) {
                                addUpdateProductToTable(exactMatch, query);
                                pInput.value = "";
                                pDropdown.style.display = "none";
                                pDropdown.innerHTML = "";
                                return;
                            }

                            pDropdown.style.display = "block";
                            res.data.data.forEach(product => {
                                const li = document.createElement("li");
                                li.className = "list-group-item d-flex justify-content-between align-items-center py-2 px-3";
                                li.style.cursor = "pointer";

                                const barcodeText = product.display_codes || product.product_code;
                                const barcodeBadge = barcodeText
                                    ? `<span class="badge bg-secondary text-white ms-2" style="font-size: 11px; font-weight: 500;">${barcodeText}</span>`
                                    : '';
                                const doorBadge = product.door_side
                                    ? `<span class="badge bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 ms-1" style="font-size: 10px;">${product.door_side}</span>`
                                    : '';

                                li.innerHTML = `
                                    <div class="d-flex align-items-center flex-wrap">
                                        <span class="fw-bold text-dark dark:text-light" style="font-size: 13px;">${product.name || product.product_name}</span>
                                        ${doorBadge}
                                        ${barcodeBadge}
                                    </div>
                                    <span class="badge bg-success font-bold" style="font-size: 12px;">৳ ${(parseFloat(product.cost_price) || 0).toFixed(2)}</span>
                                `;
                                li.addEventListener("click", () => {
                                    addUpdateProductToTable(product);
                                    pInput.value = "";
                                    pDropdown.style.display = "none";
                                    pDropdown.innerHTML = "";
                                });
                                pDropdown.appendChild(li);
                            });
                        } else {
                            pDropdown.style.display = "block";
                            pDropdown.innerHTML = `<li class="list-group-item text-center text-muted py-2 small">No product found for "${query}"</li>`;
                        }
                    } catch(err) {
                        console.error("Product Search Error:", err);
                        if (pDropdown) pDropdown.style.display = "none";
                    }
                }, 250);
            });

            document.addEventListener("click", function(e) {
                if (pDropdown && pInput && !pInput.contains(e.target) && !pDropdown.contains(e.target)) {
                    pDropdown.style.display = "none";
                }
            });
        }
    });
</script>
