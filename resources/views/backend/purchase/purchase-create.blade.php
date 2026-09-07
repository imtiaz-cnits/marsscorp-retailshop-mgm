<!-- Flatpickr Styles & Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
    /* Flatpickr Calendar on Top of Modals */
    .flatpickr-calendar {
        z-index: 999999 !important;
    }

    #exampleModal .modal-dialog {
        max-width: 1080px !important;
        width: 95% !important;
        margin: 1.75rem auto;
        padding: 0 !important;
    }

    #exampleModal .modal-content {
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
    body[light-mode="dark"] #exampleModal .modal-content,
    html[light-mode="dark"] #exampleModal .modal-content,
    body[data-layout-mode="dark"] #exampleModal .modal-content,
    html.dark #exampleModal .modal-content,
    body.dark #exampleModal .modal-content,
    body.dark-mode #exampleModal .modal-content {
        background-color: #0f172a !important;
        color: #f8fafc !important;
    }

    body[light-mode="dark"] #exampleModal .purchase-modal-body,
    html[light-mode="dark"] #exampleModal .purchase-modal-body,
    body[data-layout-mode="dark"] #exampleModal .purchase-modal-body,
    html.dark #exampleModal .purchase-modal-body,
    body.dark #exampleModal .purchase-modal-body,
    body.dark-mode #exampleModal .purchase-modal-body {
        background-color: #0f172a !important;
    }

    body[light-mode="dark"] #exampleModal .purchase-modal-footer,
    html[light-mode="dark"] #exampleModal .purchase-modal-footer,
    body[data-layout-mode="dark"] #exampleModal .purchase-modal-footer,
    html.dark #exampleModal .purchase-modal-footer,
    body.dark #exampleModal .purchase-modal-footer,
    body.dark-mode #exampleModal .purchase-modal-footer {
        background-color: #0f172a !important;
        border-top-color: #334155 !important;
    }

    body[light-mode="dark"] #exampleModal .purchase-clean-card,
    html[light-mode="dark"] #exampleModal .purchase-clean-card,
    body[data-layout-mode="dark"] #exampleModal .purchase-clean-card,
    html.dark #exampleModal .purchase-clean-card,
    body.dark #exampleModal .purchase-clean-card,
    body.dark-mode #exampleModal .purchase-clean-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #exampleModal .form-control,
    body[light-mode="dark"] #exampleModal .form-select,
    html[light-mode="dark"] #exampleModal .form-control,
    html[light-mode="dark"] #exampleModal .form-select,
    body[data-layout-mode="dark"] #exampleModal .form-control,
    body[data-layout-mode="dark"] #exampleModal .form-select,
    html.dark #exampleModal .form-control,
    html.dark #exampleModal .form-select,
    body.dark #exampleModal .form-control,
    body.dark #exampleModal .form-select,
    body.dark-mode #exampleModal .form-control,
    body.dark-mode #exampleModal .form-select {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] #supplierDropdownList,
    html[light-mode="dark"] #supplierDropdownList,
    body[data-layout-mode="dark"] #supplierDropdownList,
    html.dark #supplierDropdownList,
    body.dark #supplierDropdownList,
    body.dark-mode #supplierDropdownList {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #supplierDropdownList .supplier-select-item:hover,
    html[light-mode="dark"] #supplierDropdownList .supplier-select-item:hover,
    body[data-layout-mode="dark"] #supplierDropdownList .supplier-select-item:hover,
    html.dark #supplierDropdownList .supplier-select-item:hover,
    body.dark #supplierDropdownList .supplier-select-item:hover,
    body.dark-mode #supplierDropdownList .supplier-select-item:hover {
        background-color: #0f172a !important;
    }

    body[light-mode="dark"] #exampleModal .table-container,
    html[light-mode="dark"] #exampleModal .table-container,
    body[data-layout-mode="dark"] #exampleModal .table-container,
    html.dark #exampleModal .table-container,
    body.dark #exampleModal .table-container,
    body.dark-mode #exampleModal .table-container {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #exampleModal .responsive-table th,
    html[light-mode="dark"] #exampleModal .responsive-table th {
        background-color: #0f172a !important;
        color: #ffffff !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #exampleModal .responsive-table td,
    html[light-mode="dark"] #exampleModal .responsive-table td {
        border-color: #334155 !important;
        color: #ffffff !important;
    }

    #exampleModal label {
        text-align: left !important;
    }

    #exampleModal select,
    #exampleModal .form-select {
        cursor: pointer !important;
    }

    /* Modern Styled Select Dropdown */
    .modern-select-dropdown {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2310b981' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 12px center !important;
        background-size: 14px 10px !important;
        padding-right: 36px !important;
        appearance: none !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
    }

    #productDropdown:empty {
        display: none !important;
    }

    #productDropdown .list-group-item {
        padding: 8px 12px;
        transition: all 0.15s ease;
        border-color: #e2e8f0;
    }

    body[light-mode="dark"] #productDropdown,
    html[light-mode="dark"] #productDropdown,
    body[data-layout-mode="dark"] #productDropdown,
    html.dark #productDropdown,
    body.dark #productDropdown {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #productDropdown .list-group-item,
    html[light-mode="dark"] #productDropdown .list-group-item,
    body[data-layout-mode="dark"] #productDropdown .list-group-item,
    html.dark #productDropdown .list-group-item,
    body.dark #productDropdown .list-group-item {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }

    body[light-mode="dark"] #productDropdown .list-group-item:hover,
    html[light-mode="dark"] #productDropdown .list-group-item:hover,
    body[data-layout-mode="dark"] #productDropdown .list-group-item:hover,
    html.dark #productDropdown .list-group-item:hover,
    body.dark #productDropdown .list-group-item:hover {
        background-color: #0f172a !important;
    }

    /* Modern Badges */
    .partial-payment-status {
        background-color: #fef3c7;
        color: #92400e;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: bold;
        font-size: 12px;
    }

    .fully-paid-status {
        background-color: #dcfce7;
        color: #166534;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: bold;
        font-size: 12px;
    }
</style>

<!-- Action Button Edit Modal Start -->
<section class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" style="padding: 0 !important;">
        <div class="modal-content" style="padding: 0 !important;">
            <!-- Sticky Green Header with White Text & Red Close Icon -->
            <div style="background-color: #15803d; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 20; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <h2 style="font-size: 18px; font-weight: 700; color: #ffffff; margin: 0; padding: 0; line-height: 1.2; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-cart-flatbed text-white text-base"></i>
                    <span>Purchase Product</span>
                </h2>
                <button type="button" class="close-btn close" data-bs-dismiss="modal" aria-label="Close" style="position: static !important; width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #dc2626; color: #ffffff; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.15s ease; margin: 0; padding: 0;" title="Close">
                    <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 14px;"></i>
                </button>
            </div>

            <form onsubmit="return PurchaseDataSave(event)" id="purchaseCreateForm" style="display: flex; flex-direction: column; flex: 1 1 auto; overflow: hidden; margin: 0;">
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
                                    <div class="relative flex-grow" id="searchableSupplierWrapper">
                                        <input type="text" id="supplierSearchInput" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" placeholder="Search or Select Supplier *" autocomplete="off" />
                                        <input type="hidden" id="SupplierDataList" value="none">
                                        <div id="supplierDropdownList" class="dropdown-menu shadow-xl w-full p-0 overflow-auto rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800" style="max-height: 250px; display: none; position: absolute; z-index: 1050; top: 100%; left: 0;"></div>
                                    </div>
                                    <button type="button" class="inline-flex items-center gap-1 px-3 h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-150 border-0 flex-shrink-0 cursor-pointer" onclick="openSupplierCreateModal()">
                                        <i class="fa-solid fa-plus text-xs"></i>
                                        <span>New</span>
                                    </button>
                                </div>

                                <div id="supplierCreditNotice" class="mt-3 d-none">
                                    <div class="p-2.5 rounded-xl flex justify-between items-center bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/40">
                                        <span id="supplierCreditBadge" class="font-bold text-xs text-slate-800 dark:text-white">
                                            <i class="fa-solid fa-gift me-1 text-emerald-600 dark:text-emerald-400"></i> Return Credit Available: <strong>৳ 0.00</strong>
                                        </span>
                                        <label class="flex items-center gap-2 mb-0 px-2 py-1 bg-white dark:bg-slate-800 rounded-lg border border-emerald-300 dark:border-emerald-700 shadow-sm cursor-pointer">
                                            <input type="checkbox" id="useReturnCreditCheckboxBanner" onchange="syncReturnCreditCheckbox(this.checked)" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer">
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
                                        <input type="text" placeholder="Reference No *" id="ReferenceNo" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Purchase Date <span class="text-rose-500">*</span></label>
                                        <input type="text" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" id="PurchaseDate" placeholder="DD-MM-YYYY" autocomplete="off" required style="cursor: pointer;" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Payable Balance</label>
                                        <input type="text" readonly placeholder="Payable Amount" id="PurchasePayableAmount" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-100 dark:bg-slate-800/80 text-emerald-700 dark:text-emerald-400 text-xs font-bold" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Attach Invoice Doc</label>
                                        <input type="file" id="AttachDocument" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs" />
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
                                <input type="text" id="productInputData" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-medium focus:border-emerald-600 focus:outline-none" placeholder="Scan barcode or type product name/code (Auto-adds to list)..." autocomplete="off" />
                                <ul id="productDropdown" class="list-group absolute w-full shadow-xl rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 mt-1" style="z-index: 1050; max-height: 280px; overflow-y: auto; display: none;"></ul>
                            </div>
                            <button type="button" class="inline-flex items-center gap-1.5 px-4 h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-150 border-0 flex-shrink-0 cursor-pointer" onclick="openPurchaseCameraScanner()">
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
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800" id="orderTableBody">
                                <!-- Dynamic Items -->
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
                                        <select class="form-select modern-select-dropdown w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-semibold focus:border-emerald-600 focus:outline-none transition-all" id="paymentMethod" style="cursor: pointer;">
                                            <option value="" selected class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">Select Method</option>
                                            <option value="Cash" class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">Cash</option>
                                            <option value="Bkash" class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">Bkash</option>
                                            <option value="Nagad" class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">Nagad</option>
                                            <option value="Bank" class="bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">Bank</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Paid Amount (৳)</label>
                                        <input type="number" step="any" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs font-bold" id="paidAmount" value="0" />
                                    </div>
                                    <div class="col-12">
                                        <input type="text" id="paymentDetails" class="form-control w-full h-[38px] px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-xs mt-1" style="display: none;" placeholder="Enter transaction details..." />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="purchase-clean-card rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 p-4">
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between items-center py-1 border-b border-slate-200 dark:border-slate-800">
                                        <span class="text-slate-500 dark:text-slate-400 font-semibold">Total Quantity:</span>
                                        <span class="font-bold text-slate-800 dark:text-white text-sm" id="totalQuantity">0.00</span>
                                    </div>
                                    <div class="flex justify-between items-center py-1 border-b border-slate-200 dark:border-slate-800">
                                        <span class="text-slate-500 dark:text-slate-400 font-semibold">Grand Subtotal:</span>
                                        <span class="font-bold text-slate-800 dark:text-white text-sm">৳ <span id="totalSubTotal">0.00</span></span>
                                        <input type="hidden" id="grandSubtotal" value="0.00" />
                                    </div>
                                    <div class="flex justify-between items-center py-1" style="display: none;">
                                        <label class="inline-flex items-center gap-2 cursor-pointer mb-0">
                                            <input type="checkbox" id="useReturnCreditCheckbox" onchange="syncReturnCreditCheckbox(this.checked)" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                                            <span class="font-bold text-xs text-emerald-700 dark:text-emerald-400">Return Credit Adj</span>
                                        </label>
                                        <input type="number" step="0.01" min="0" class="form-control w-28 h-8 text-end font-bold rounded-lg text-xs" id="returnAdjustmentAmount" value="0.00" disabled oninput="calculateDuePayment()" />
                                    </div>
                                    <div class="flex justify-between items-center p-2.5 rounded-xl bg-slate-800 text-white dark:bg-slate-950 my-2">
                                        <span class="font-bold text-xs">Net Payable:</span>
                                        <span class="font-bold text-base text-emerald-400">৳ <span id="netPayableDisplay">0.00</span></span>
                                        <input type="hidden" id="netPayableAmount" value="0.00" />
                                    </div>
                                    <div class="flex justify-between items-center py-1 border-b border-slate-200 dark:border-slate-800">
                                        <span class="text-slate-500 dark:text-slate-400 font-semibold">Due Amount:</span>
                                        <span class="font-bold text-rose-600 dark:text-rose-400 text-sm">৳ <input type="text" id="dueAmount" value="0.00" readonly class="border-0 bg-transparent text-rose-600 dark:text-rose-400 font-bold text-end" style="width: 90px;" /></span>
                                    </div>
                                    <div class="flex justify-between items-center py-1">
                                        <span class="text-slate-500 dark:text-slate-400 font-semibold">Payment Status:</span>
                                        <span id="paymentStatusDisplay" class="partial-payment-status">Unpaid</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fixed Sticky Bottom Modal Footer with Left-Right Padding p-4 and Red Cancel Button -->
                <div class="purchase-modal-footer bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 p-4 flex items-center justify-between gap-3 flex-shrink-0" style="position: sticky; bottom: 0; z-index: 20;">
                    <button type="button" class="px-5 h-[38px] rounded-xl text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:scale-[0.98] transition-all shadow-sm border-0 cursor-pointer" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="flex-grow sm:flex-grow-0 sm:min-w-[240px] h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-xs font-bold rounded-xl shadow transition-all duration-150 flex items-center justify-center gap-2 border-0 cursor-pointer">
                        <i class="fa-solid fa-circle-check text-sm"></i>
                        <span>Submit Purchase Order</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Camera Scanner Modal for Purchase -->
<div class="modal fade" id="purchaseCameraScanModal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <h5 class="modal-title fs-6 fw-bold">
                    <i class="fa-solid fa-barcode text-success me-2"></i> Product Barcode Scanner (Purchase)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" onclick="stopPurchaseCameraScanner()"></button>
            </div>
            <div class="modal-body p-3 text-center bg-light">
                <div id="purchaseCameraScannerStatus" class="alert alert-info py-2 small mb-3">
                    <i class="fa-solid fa-circle-notch fa-spin me-1"></i> Starting camera... Hold barcode in front of camera.
                </div>

                <div id="purchaseReader" style="width: 100%; min-height: 250px; background: #000; border-radius: 12px; overflow: hidden; margin: 0 auto;"></div>

                <div class="d-flex justify-content-between align-items-center mt-3 px-1">
                    <span id="purchaseLastScannedText" class="badge bg-dark text-wrap p-2" style="font-size: 13px;">Scanned: -</span>
                    <button type="button" class="btn btn-outline-dark btn-sm rounded-pill" onclick="switchPurchaseCamera()">
                        <i class="fa-solid fa-camera-rotate me-1"></i> Switch Camera
                    </button>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 py-2">
                <button type="button" class="btn btn-secondary btn-sm w-100 rounded-pill" data-bs-dismiss="modal" onclick="stopPurchaseCameraScanner()">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.createPurchaseDatepicker = null;

    function initCreateDatePicker() {
        const dateInput = document.getElementById("PurchaseDate");
        if (dateInput && typeof flatpickr !== "undefined") {
            if (window.createPurchaseDatepicker) {
                window.createPurchaseDatepicker.destroy();
            }
            window.createPurchaseDatepicker = flatpickr(dateInput, {
                dateFormat: "d-m-Y",
                allowInput: true,
                clickOpens: true,
                disableMobile: true
            });
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const paidAmountInput = document.getElementById("paidAmount");
        const dueAmountInput = document.getElementById("dueAmount");
        const grandSubtotalInput = document.getElementById("grandSubtotal");
        const paymentStatusDisplay = document.getElementById("paymentStatusDisplay");

        window.syncReturnCreditCheckbox = function(isChecked) {
            const tableCb = document.getElementById("useReturnCreditCheckbox");
            const bannerCb = document.getElementById("useReturnCreditCheckboxBanner");
            if (tableCb) tableCb.checked = isChecked;
            if (bannerCb) bannerCb.checked = isChecked;

            toggleReturnCreditAdjustment();
        };

        window.toggleReturnCreditAdjustment = function() {
            const checkbox = document.getElementById("useReturnCreditCheckbox");
            const returnAdjInput = document.getElementById("returnAdjustmentAmount");
            const maxCredit = parseFloat(window.availableSupplierCredit || 0);

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

            calculateDuePayment();
        };

        window.calculateDuePayment = function() {
            let grandSubtotal = parseFloat(grandSubtotalInput.value) || 0;
            let checkbox = document.getElementById("useReturnCreditCheckbox");
            let returnAdjInput = document.getElementById("returnAdjustmentAmount");
            let netPayableInput = document.getElementById("netPayableAmount");
            let netDisplay = document.getElementById("netPayableDisplay");

            let returnAdj = 0;
            if (checkbox && checkbox.checked) {
                let maxCredit = parseFloat(window.availableSupplierCredit || 0);
                returnAdj = parseFloat(returnAdjInput.value) || 0;

                if (returnAdj > maxCredit) {
                    returnAdj = maxCredit;
                    returnAdjInput.value = maxCredit.toFixed(2);
                }
                if (returnAdj > grandSubtotal) {
                    returnAdj = grandSubtotal;
                    returnAdjInput.value = grandSubtotal.toFixed(2);
                }
            } else {
                if (returnAdjInput) returnAdjInput.value = "0.00";
            }

            let netPayable = Math.max(0, grandSubtotal - returnAdj);
            if (netPayableInput) netPayableInput.value = netPayable.toFixed(2);
            if (netDisplay) netDisplay.textContent = netPayable.toFixed(2);

            let paidAmount = parseFloat(paidAmountInput.value) || 0;
            let dueAmount = Math.max(0, netPayable - paidAmount);

            dueAmountInput.value = dueAmount.toFixed(2);

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
        };

        paidAmountInput.addEventListener("input", calculateDuePayment);
        calculateDuePayment();

        // Initialize today's date formatted as DD-MM-YYYY
        const dateInput = document.getElementById('PurchaseDate');
        if (dateInput && !dateInput.value) {
            const now = new Date();
            const d = String(now.getDate()).padStart(2, '0');
            const m = String(now.getMonth() + 1).padStart(2, '0');
            const y = now.getFullYear();
            dateInput.value = `${d}-${m}-${y}`;
        }
        initCreateDatePicker();

        if (typeof $ !== "undefined") {
            $('#exampleModal').on('shown.bs.modal', function () {
                initCreateDatePicker();
            });
        }
    });
</script>

<script>
    let allSuppliersData = [];

    function openSupplierCreateModal() {
        const modal = document.getElementById('supplierCreateModal') || document.getElementById('myModal');
        if (modal) {
            if (modal.parentNode && modal.parentNode !== document.body) {
                document.body.appendChild(modal);
            }
            modal.style.setProperty('display', 'flex', 'important');
            modal.style.opacity = '1';
            modal.style.visibility = 'visible';
            setTimeout(() => {
                modal.classList.add('show');
                modal.classList.add('show-modal');
                const firstInput = document.getElementById('supplierName');
                if (firstInput) firstInput.focus();
            }, 20);
        } else {
            errorToast("Supplier Create Modal not found!");
        }
    }

    async function refreshSupplierList(selectedSupplierId = null) {
        try {
            const res = await axios.get("/api/supplier-list", HeaderToken());
            allSuppliersData = res.data.SupplierData || [];

            renderSupplierDropdownItems(allSuppliersData);

            if (selectedSupplierId) {
                const found = allSuppliersData.find(s => s.id == selectedSupplierId);
                if (found) {
                    selectSupplierItem(found);
                }
            }
        } catch (error) {
            console.error("Error occurred while fetching Suppliers:", error);
        }
    }

    function renderSupplierDropdownItems(suppliers) {
        const listContainer = document.getElementById("supplierDropdownList");
        if (!listContainer) return;

        if (!suppliers || suppliers.length === 0) {
            listContainer.innerHTML = `<div class="p-2 text-muted text-center small">No suppliers found</div>`;
            return;
        }

        let html = suppliers.map(s => {
            const creditVal = parseFloat(s.return_credit_balance || 0);
            const creditLabel = creditVal > 0 ? `<span class="badge bg-teal ms-1" style="background:#0d9488;">🎁 ৳${creditVal.toFixed(2)}</span>` : '';
            const payable = parseFloat(s.purchase_payable_amount || 0);
            const payableLabel = payable > 0 ? `<span class="badge bg-danger ms-1">Due: ৳${payable.toFixed(2)}</span>` : '';

            return `
                <div class="dropdown-item px-3 py-2 border-bottom supplier-select-item"
                     data-id="${s.id}"
                     data-name="${s.name}"
                     data-payable="${payable}"
                     data-credit="${creditVal}"
                     style="cursor: pointer;">
                     <div class="fw-bold text-dark">${s.name} ${s.company ? `<small class="text-muted">(${s.company})</small>` : ''}</div>
                     <div class="small text-muted">${s.mobile || ''} ${payableLabel} ${creditLabel}</div>
                </div>
            `;
        }).join('');

        listContainer.innerHTML = html;

        listContainer.querySelectorAll('.supplier-select-item').forEach(item => {
            item.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const payable = this.getAttribute('data-payable');
                const credit = parseFloat(this.getAttribute('data-credit')) || 0;

                selectSupplierItem({
                    id,
                    name,
                    payable,
                    credit
                });
                listContainer.style.display = 'none';
            });
        });
    }

    function selectSupplierItem(s) {
        document.getElementById("SupplierDataList").value = s.id;
        document.getElementById("supplierSearchInput").value = s.name;
        document.getElementById("PurchasePayableAmount").value = s.payable || 0;

        window.availableSupplierCredit = s.credit || 0;

        const creditNotice = document.getElementById("supplierCreditNotice");
        const creditBadge = document.getElementById("supplierCreditBadge");
        const returnAdjInput = document.getElementById("returnAdjustmentAmount");

        if (typeof syncReturnCreditCheckbox === 'function') {
            syncReturnCreditCheckbox(false);
        }

        if (s.credit > 0) {
            creditBadge.innerHTML = `<i class="fa-solid fa-gift me-1" style="color: #0d9488;"></i> Return Credit Available: <strong>৳ ${s.credit.toFixed(2)}</strong>`;
            creditNotice.classList.remove("d-none");
            returnAdjInput.setAttribute("max", s.credit);
        } else {
            creditNotice.classList.add("d-none");
            returnAdjInput.setAttribute("max", "0");
        }

        if (typeof calculateDuePayment === 'function') {
            calculateDuePayment();
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const suppInput = document.getElementById("supplierSearchInput");
        const suppList = document.getElementById("supplierDropdownList");

        if (suppInput && suppList) {
            suppInput.addEventListener("focus", function() {
                suppList.style.display = "block";
                renderSupplierDropdownItems(allSuppliersData);
            });

            suppInput.addEventListener("input", function() {
                const query = this.value.toLowerCase().trim();
                suppList.style.display = "block";

                const filtered = allSuppliersData.filter(s =>
                    (s.name && s.name.toLowerCase().includes(query)) ||
                    (s.mobile && s.mobile.toLowerCase().includes(query)) ||
                    (s.company && s.company.toLowerCase().includes(query))
                );

                renderSupplierDropdownItems(filtered);
            });

            document.addEventListener("click", function(e) {
                const wrapper = document.getElementById("searchableSupplierWrapper");
                if (wrapper && !wrapper.contains(e.target)) {
                    suppList.style.display = "none";
                }
            });
        }
    });

    refreshSupplierList();

    /* ========================================================
       Camera Scanner for Purchase Product Input
       ======================================================== */
    let purchaseHtml5QrCode = null;
    let purchaseFacingMode = "environment";
    let lastPurchaseScannedCode = "";
    let purchaseScanTimer = null;

    function openPurchaseCameraScanner() {
        const modalEl = new bootstrap.Modal(document.getElementById('purchaseCameraScanModal'));
        modalEl.show();
        setTimeout(() => {
            startPurchaseCameraScanner();
        }, 350);
    }

    function startPurchaseCameraScanner() {
        if (purchaseHtml5QrCode && purchaseHtml5QrCode.isScanning) {
            purchaseHtml5QrCode.stop().then(() => initPurchaseHtml5QrCode()).catch(() => initPurchaseHtml5QrCode());
        } else {
            initPurchaseHtml5QrCode();
        }
    }

    function initPurchaseHtml5QrCode() {
        const statusEl = document.getElementById('purchaseCameraScannerStatus');
        if (statusEl) {
            statusEl.className = "alert alert-info py-2 small mb-3";
            statusEl.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-1"></i> Starting camera... Hold barcode in front of camera.';
        }

        purchaseHtml5QrCode = new Html5Qrcode("purchaseReader");
        const config = {
            fps: 15,
            qrbox: { width: 280, height: 160 },
            aspectRatio: 1.777778
        };

        purchaseHtml5QrCode.start(
            { facingMode: purchaseFacingMode },
            config,
            (decodedText, decodedResult) => {
                onPurchaseBarcodeSuccess(decodedText);
            },
            (errorMessage) => {}
        ).catch((err) => {
            console.error("Purchase Camera Start Error:", err);
            if (statusEl) {
                statusEl.className = "alert alert-danger py-2 small mb-3";
                statusEl.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> Camera permission denied or device not found.';
            }
        });
    }

    function onPurchaseBarcodeSuccess(code) {
        code = code.trim();
        if (!code) return;

        if (code === lastPurchaseScannedCode) return;
        lastPurchaseScannedCode = code;

        const lastScannedBadge = document.getElementById('purchaseLastScannedText');
        if (lastScannedBadge) {
            lastScannedBadge.textContent = "Scanned: " + code;
            lastScannedBadge.className = "badge bg-success text-wrap p-2";
        }

        const input = document.getElementById("productInputData");
        if (input) {
            input.value = code;
            input.dispatchEvent(new Event('input'));
        }

        stopPurchaseCameraScanner();
        const modalEl = bootstrap.Modal.getInstance(document.getElementById('purchaseCameraScanModal'));
        if (modalEl) modalEl.hide();

        setTimeout(() => {
            lastPurchaseScannedCode = "";
        }, 2000);
    }

    function switchPurchaseCamera() {
        purchaseFacingMode = purchaseFacingMode === "environment" ? "user" : "environment";
        startPurchaseCameraScanner();
    }

    function stopPurchaseCameraScanner() {
        if (purchaseHtml5QrCode) {
            purchaseHtml5QrCode.stop().then(() => {
                purchaseHtml5QrCode.clear();
            }).catch((err) => {
                console.error("Failed to stop purchase scanner:", err);
            });
        }
    }

    /* ========================================================
       Product Autocomplete, Barcode Scanning & Cart Logic
       ======================================================== */
    let productDetails = {};
    let UpdatebarcodeLists = {};
    let debounceTimer;

    const productInput = document.getElementById("productInputData");
    const productDropdown = document.getElementById("productDropdown");

    if (productInput) {
        productInput.addEventListener("keydown", function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
                const code = this.value.trim();
                if (code) {
                    processBarcodeOrSearchDirect(code);
                }
            }
        });

        productInput.addEventListener("input", function () {
            clearTimeout(debounceTimer);
            const query = this.value.trim();

            if (!query) {
                if (productDropdown) {
                    productDropdown.style.display = "none";
                    productDropdown.innerHTML = "";
                }
                return;
            }

            debounceTimer = setTimeout(async () => {
                try {
                    const res = await axios.post("/api/product-search-by-name", { query: query }, HeaderToken());
                    if (!productDropdown) return;
                    productDropdown.innerHTML = "";

                    if (res.data.status === "success" && res.data.data.length > 0) {
                        const exactBarcodeMatch = res.data.data.find(p => p.product_code && p.product_code.toLowerCase() === query.toLowerCase());

                        if (exactBarcodeMatch && res.data.data.length === 1) {
                            addProductToTable(exactBarcodeMatch, exactBarcodeMatch.product_code);
                            productInput.value = "";
                            productDropdown.style.display = "none";
                            productDropdown.innerHTML = "";
                            return;
                        }

                        productDropdown.style.display = "block";
                        res.data.data.forEach(product => {
                            const li = document.createElement("li");
                            li.className = "list-group-item d-flex justify-content-between align-items-center";
                            li.style.cursor = "pointer";
                            li.innerHTML = `
                                <div>
                                    <span class="fw-bold">${product.name}</span>
                                    <span class="badge bg-secondary ms-2">${product.product_code || ''}</span>
                                </div>
                                <span class="badge bg-success">৳${product.cost_price || 0}</span>
                            `;
                            li.addEventListener("click", () => {
                                addProductToTable(product);
                                productInput.value = "";
                                productDropdown.style.display = "none";
                                productDropdown.innerHTML = "";
                            });
                            productDropdown.appendChild(li);
                        });
                    } else {
                        productDropdown.style.display = "none";
                    }
                } catch (error) {
                    console.error("Product Search Error:", error);
                    if (productDropdown) productDropdown.style.display = "none";
                }
            }, 250);
        });

        // Hide dropdown on outside click
        document.addEventListener("click", function(e) {
            if (productDropdown && productInput && !productInput.contains(e.target) && !productDropdown.contains(e.target)) {
                productDropdown.style.display = "none";
            }
        });
    }

    async function processBarcodeOrSearchDirect(query) {
        try {
            const res = await axios.post("/api/product-search-by-name", { query: query }, HeaderToken());
            if (res.data.status === "success" && res.data.data.length > 0) {
                const found = res.data.data[0];
                addProductToTable(found, query);
                if (productInput) {
                    productInput.value = "";
                }
                if (productDropdown) {
                    productDropdown.style.display = "none";
                    productDropdown.innerHTML = "";
                }
            } else {
                errorToast("No product found matching: " + query);
            }
        } catch (e) {
            console.error("Direct barcode search error:", e);
        }
    }

    function addProductToTable(product, specificBarcode = null) {
        const tableBody = document.getElementById("orderTableBody");
        const existingRow = document.querySelector(`#orderTableBody tr[data-product-id="${product.id}"]`);

        if (existingRow) {
            const qtyInput = existingRow.querySelector(".quantity");
            qtyInput.value = parseInt(qtyInput.value) + 1;

            if (specificBarcode) {
                appendBarcodeToRow(existingRow, product.id, specificBarcode);
            }

            updateRowSubtotal(existingRow);
            updateTotals();
            return;
        }

        const initialBarcode = specificBarcode || product.product_code || '';
        UpdatebarcodeLists[product.id] = initialBarcode ? [initialBarcode] : [];

        const row = document.createElement("tr");
        row.setAttribute("data-product-id", product.id);
        row.className = "hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors";

        row.innerHTML = `
            <td class="p-2.5 font-bold text-slate-800 dark:text-slate-100">
                <span class="product-id-val d-none">${product.id}</span>
                <span>${product.name}</span>
                <div class="text-[11px] text-slate-400 font-normal">ID: ${product.product_id || product.id}</div>
            </td>
            <td class="p-2.5">
                <div class="d-flex align-items-center gap-1">
                    <input type="text" id="UpdateProductCode" class="form-control form-control-sm" style="font-size: 11px; width: 140px;" value="${initialBarcode}" readonly />
                    <button type="button" class="btn btn-sm btn-outline-secondary px-1.5 py-0.5" onclick="promptAddBarcode(this, ${product.id})" title="Add Barcode">
                        <i class="fa-solid fa-plus text-[10px]"></i>
                    </button>
                </div>
            </td>
            <td class="p-2.5 text-center">
                <input type="number" class="form-control form-control-sm quantity text-center font-bold" min="1" value="1" style="width: 70px; margin: 0 auto;" oninput="updateRowSubtotal(this.closest('tr')); updateTotals();" />
            </td>
            <td class="p-2.5 text-end">
                <input type="number" step="any" class="form-control form-control-sm cost-price text-end font-bold" value="${product.cost_price || 0}" style="width: 90px; margin-left: auto;" oninput="updateRowSubtotal(this.closest('tr')); updateTotals();" />
            </td>
            <td class="p-2.5 text-end font-bold text-slate-800 dark:text-white subtotal">৳ ${(product.cost_price || 0).toFixed(2)}</td>
            <td class="p-2.5 text-center">
                <button type="button" class="btn btn-sm btn-outline-danger p-1 rounded-lg" onclick="removeProductRow(this)" title="Remove">
                    <i class="fa-solid fa-trash text-xs"></i>
                </button>
            </td>
        `;

        tableBody.appendChild(row);
        updateTotals();
    }

    function appendBarcodeToRow(row, productId, barcode) {
        if (!UpdatebarcodeLists[productId]) UpdatebarcodeLists[productId] = [];
        if (!UpdatebarcodeLists[productId].includes(barcode)) {
            UpdatebarcodeLists[productId].push(barcode);
            const input = row.querySelector("#UpdateProductCode");
            if (input) input.value = UpdatebarcodeLists[productId].join(', ');
        }
    }

    function promptAddBarcode(btn, productId) {
        const barcode = prompt("Enter additional barcode for this product:");
        if (barcode && barcode.trim()) {
            const row = btn.closest("tr");
            appendBarcodeToRow(row, productId, barcode.trim());
        }
    }

    function updateRowSubtotal(row) {
        const qty = parseInt(row.querySelector(".quantity").value) || 0;
        const price = parseFloat(row.querySelector(".cost-price").value) || 0;
        const subtotal = qty * price;
        row.querySelector(".subtotal").innerText = `৳ ${subtotal.toFixed(2)}`;
    }

    function removeProductRow(btn) {
        const row = btn.closest("tr");
        const productId = row.getAttribute("data-product-id");
        delete UpdatebarcodeLists[productId];
        row.remove();
        updateTotals();
    }

    function updateTotals() {
        let totalQty = 0;
        let totalSub = 0;

        document.querySelectorAll("#orderTableBody tr").forEach(row => {
            const qty = parseInt(row.querySelector(".quantity").value) || 0;
            const price = parseFloat(row.querySelector(".cost-price").value) || 0;
            totalQty += qty;
            totalSub += qty * price;
        });

        document.getElementById("totalQuantity").innerText = totalQty;
        document.getElementById("totalSubTotal").innerText = totalSub.toFixed(2);
        document.getElementById("grandSubtotal").value = totalSub.toFixed(2);

        if (typeof calculateDuePayment === "function") {
            calculateDuePayment();
        }
    }

    async function PurchaseDataSave(event) {
        if (event) event.preventDefault();

        let products = [];
        const rows = document.querySelectorAll('#orderTableBody tr');

        rows.forEach(row => {
            const productId = row.querySelector('.product-id-val').innerText.trim();
            const quantity = parseInt(row.querySelector('.quantity').value) || 0;
            const costPrice = parseFloat(row.querySelector('.cost-price').value) || 0;
            const subtotalText = row.querySelector('.subtotal').innerText.replace(/[^\d.]/g, '');
            const subtotal = parseFloat(subtotalText) || (quantity * costPrice);
            const ProductCodes = UpdatebarcodeLists[productId] || [];

            if (quantity <= 0) {
                alert("Quantity must be greater than zero!");
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
            alert("At least one product must be added!");
            return;
        }

        let formData = new FormData();
        formData.append('supplier_id', document.getElementById('SupplierDataList').value);
        formData.append('purchase_payable_amount', document.getElementById('PurchasePayableAmount').value || 0);
        formData.append('date', document.getElementById('PurchaseDate').value);
        formData.append('purchase_due_collection_date', document.getElementById('PurchaseDate').value);
        formData.append('referance_no', document.getElementById('ReferenceNo').value);
        formData.append('payment_status', document.getElementById('paymentStatusDisplay').textContent.trim());
        formData.append('grand_subtotal', parseFloat(document.getElementById('grandSubtotal').value) || 0);
        formData.append('return_adjustment_amount', parseFloat(document.getElementById('returnAdjustmentAmount').value) || 0);
        formData.append('payment_method', document.getElementById('paymentMethod').value);
        formData.append('paid_amount', parseFloat(document.getElementById('paidAmount').value) || 0);
        formData.append('due_amount', parseFloat(document.getElementById('dueAmount').value) || 0);
        formData.append('transaction_id', document.getElementById('paymentDetails').value);
        formData.append('products', JSON.stringify(products));

        const imgInput = document.getElementById('AttachDocument');
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
            let res = await axios.post("/api/create-purchases", formData, config);

            if (res.data['status'] === "success") {
                successToast(res.data['message']);
                const formEl = document.getElementById("purchaseCreateForm") || document.getElementById("signup");
                if (formEl) formEl.reset();
                const modal = document.getElementById('exampleModal');
                closeModal(modal);
                location.reload();
            } else {
                errorToast(res.data['message']);
            }
        } catch (e) {
            console.error("Purchase Save Error:", e);
            unauthorized(e.response?.status);
        }
    }

    function closeModal(modal) {
        if (!modal) modal = document.getElementById('exampleModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }
</script>