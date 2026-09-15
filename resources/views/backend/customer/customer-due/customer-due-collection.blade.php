<!-- Action Button Due Collection Modal Start -->
<div class="modal fade" id="customerDueCollectModal" tabindex="-1" aria-labelledby="customerDueCollectModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-white dark:bg-slate-900 border-0 shadow-2xl overflow-hidden flex flex-col">

            <!-- Sticky Green Header -->
            <div class="modal-header-green flex-shrink-0 px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-white/20 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                            <circle cx="12" cy="12" r="2"></circle>
                            <path d="M6 12h.01M18 12h.01"></path>
                        </svg>
                    </div>
                    <h5 class="text-base font-bold text-white tracking-tight mb-0" id="customerDueCollectModalLabel">Collect Customer Due</h5>
                </div>

                <!-- Circular Red Close Button -->
                <button type="button" class="qv-close-btn" data-bs-dismiss="modal" onclick="closeModal(document.getElementById('customerDueCollectModal'))" aria-label="Close">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form id="paymentForm" onsubmit="SavePaymentInfo(event)" class="flex flex-col flex-1 overflow-hidden m-0 p-0">
                <div class="modal-body px-4 pt-3 pb-2 space-y-3 text-start overflow-y-auto">

                    <!-- Hidden Reference Elements -->
                    <span id="MyTotalDueAmount" style="display: none;">৳ 0</span>
                    <span id="PreviousDueAmount" style="display: none;">৳ 0</span>
                    <span id="ShowDiscountAmount" style="display: none;">৳ 0</span>
                    <input type="hidden" id="updateID">
                    <input type="hidden" id="selectedPaymentMethod" value="cash">

                    <!-- Customer Info Box -->
                    <div class="cdc-info-box">
                        <!-- Customer Name + ID Row -->
                        <div class="flex items-center justify-between mb-2.5">
                            <div class="flex items-center gap-2">
                                <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400 inline-flex items-center justify-center text-xs flex-shrink-0">
                                    <i class="fa-solid fa-user-tie"></i>
                                </span>
                                <span class="font-bold text-slate-800 dark:text-slate-100 text-sm" id="modalCustomerName">Customer</span>
                            </div>
                            <span class="cp-badge cp-badge-id font-mono text-xs" id="modalCustomerId">ID</span>
                        </div>

                        <!-- Due Breakdown Table -->
                        <div class="cdc-due-table-wrap">
                            <table class="cdc-due-table w-full">
                                <thead>
                                    <tr>
                                        <th>Previous Due</th>
                                        <th>Invoice Due</th>
                                        <th class="text-end">Total Target Due</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="PreviousDue">৳ 0.00</td>
                                        <td id="OrderDue">৳ 0.00</td>
                                        <td class="text-end font-extrabold text-rose-600 dark:text-rose-400" id="TotalDue">৳ 0.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Due Grid (hidden on desktop) -->
                        <div class="cdc-due-mobile-grid">
                            <div class="cdc-due-mobile-cell">
                                <span class="cdc-due-label">Prev Due</span>
                                <span class="cdc-due-val" id="mobilePreviousDue">৳ 0.00</span>
                            </div>
                            <div class="cdc-due-mobile-cell">
                                <span class="cdc-due-label">Invoice Due</span>
                                <span class="cdc-due-val" id="mobileOrderDue">৳ 0.00</span>
                            </div>
                            <div class="cdc-due-mobile-cell cdc-due-mobile-total">
                                <span class="cdc-due-label text-rose-600">Total Due</span>
                                <span class="cdc-due-val text-rose-600 dark:text-rose-400" id="mobileTotalDue">৳ 0.00</span>
                            </div>
                        </div>

                        <!-- Remaining Due + Status Pill -->
                        <div class="cdc-remaining-row mt-2.5 pt-2.5 border-t border-emerald-200/70 dark:border-slate-700/60 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-300">
                                Remaining Due:&nbsp;<strong id="ShowtotalDuePayable" class="text-emerald-700 dark:text-emerald-400 font-extrabold text-sm">৳ 0.00</strong>
                            </span>
                            <span id="ShowpaymentStatusDisplay" class="badge px-3 py-1 font-bold text-xs bg-amber-500 text-white rounded-full">Pending</span>
                        </div>
                    </div>

                    <!-- Collected Amount + Discount -->
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label class="cdc-label" for="UpdateDueAmountclear">
                                Collected Amount (৳) <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" step="any" id="UpdateDueAmountclear" oninput="calculateDuePayment()" placeholder="0.00" class="cp-modal-input font-bold text-emerald-700 dark:text-emerald-400" required />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="cdc-label" for="UpdateDiscountAmountclear">
                                Discount / Waiver (৳)
                            </label>
                            <input type="number" step="any" value="0" id="UpdateDiscountAmountclear" oninput="calculateDuePayment()" placeholder="0.00" class="cp-modal-input" />
                        </div>
                    </div>

                    <!-- Payment Method + Collection Date -->
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label class="cdc-label">Payment Method</label>
                            <div class="custom-modal-dropdown relative" id="modalPaymentDropdown">
                                <div class="select-trigger unified-ui-border flex items-center justify-between px-3 h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-xs text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200 cursor-pointer hover:border-emerald-500 transition-all" onclick="toggleDuePaymentDropdown()">
                                    <span class="selected-text flex items-center gap-2" id="selectedPaymentText">
                                        <i class="fa-solid fa-money-bill text-emerald-600"></i> Cash
                                    </span>
                                    <svg class="w-3.5 h-3.5 text-slate-400 chevron-icon transition-transform duration-200 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </div>
                                <div class="select-menu shadow-2xl" style="display: none;">
                                    <div class="select-option-item active" data-value="cash" onclick="selectDuePaymentOption('cash', '<i class=\'fa-solid fa-money-bill text-emerald-600\'></i> Cash')">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-money-bill text-emerald-600"></i> Cash</span>
                                    </div>
                                    <div class="select-option-item" data-value="bkash" onclick="selectDuePaymentOption('bkash', '<i class=\'fa-solid fa-mobile-screen text-pink-600\'></i> bKash')">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-mobile-screen text-pink-600"></i> bKash</span>
                                    </div>
                                    <div class="select-option-item" data-value="nagad" onclick="selectDuePaymentOption('nagad', '<i class=\'fa-solid fa-wallet text-orange-600\'></i> Nagad')">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-wallet text-orange-600"></i> Nagad</span>
                                    </div>
                                    <div class="select-option-item" data-value="rocket" onclick="selectDuePaymentOption('rocket', '<i class=\'fa-solid fa-bolt text-purple-600\'></i> Rocket')">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-bolt text-purple-600"></i> Rocket</span>
                                    </div>
                                    <div class="select-option-item" data-value="bank" onclick="selectDuePaymentOption('bank', '<i class=\'fa-solid fa-building-columns text-blue-600\'></i> Bank Transfer')">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-building-columns text-blue-600"></i> Bank Transfer</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label class="cdc-label" for="DueCollectionDate">Collection Date</label>
                            <input type="text" id="DueCollectionDate" placeholder="Select date" class="cp-modal-input cursor-pointer" />
                        </div>
                    </div>

                    <!-- Transaction ID / Note -->
                    <div>
                        <label class="cdc-label" for="transactionInput">Transaction ID / Note</label>
                        <input type="text" id="transactionInput" placeholder="e.g. TrxID / Receipt No" class="cp-modal-input" />
                    </div>

                </div>

                <!-- Sticky Footer: Cancel + Submit -->
                <div class="modal-footer-sticky flex-shrink-0">
                    <button type="button" class="cp-btn-cancel" data-bs-dismiss="modal" onclick="closeModal(document.getElementById('customerDueCollectModal'))">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        <span>Cancel</span>
                    </button>
                    <button type="submit" class="cp-btn-primary">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Submit Collection</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Action Button Due Collection Modal End -->


<style>
    /* ─── Modal: Fixed Width, Centered, No Page Scroll ─── */
    #customerDueCollectModal.modal,
    #editModal.modal {
        padding-left: 0 !important;
        padding-right: 0 !important;
        overflow-x: hidden !important;
        overflow-y: hidden !important;
    }
    #customerDueCollectModal .modal-dialog,
    #editModal .modal-dialog {
        max-width: 520px !important;
        width: 95% !important;
        margin: 1.5rem auto !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-height: calc(100% - 3rem) !important;
    }
    @media (max-width: 576px) {
        #customerDueCollectModal .modal-dialog,
        #editModal .modal-dialog {
            max-width: calc(100% - 20px) !important;
            width: calc(100% - 20px) !important;
            margin: 0.75rem auto !important;
            min-height: calc(100% - 1.5rem) !important;
        }
    }
    #customerDueCollectModal .modal-content,
    #editModal .modal-content {
        width: 100% !important;
        max-height: 88vh !important;
        margin: 0 !important;
        border-radius: 18px !important;
        border: none !important;
        display: flex !important;
        flex-direction: column !important;
        overflow: hidden !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
    }
    #customerDueCollectModal .modal-body,
    #editModal .modal-body {
        flex: 1 1 auto !important;
        max-height: calc(88vh - 125px) !important;
        overflow-y: auto !important;
        overscroll-behavior: contain !important;
        padding: 14px 18px !important;
    }

    /* Green Header */
    .modal-header-green {
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%) !important;
        color: #ffffff !important;
        border: none !important;
        padding: 12px 16px !important;
    }

    /* Red Circular Close Button */
    .qv-close-btn {
        width: 32px !important;
        height: 32px !important;
        min-width: 32px !important;
        min-height: 32px !important;
        max-width: 32px !important;
        max-height: 32px !important;
        border-radius: 50% !important;
        background-color: #dc2626 !important;
        border: none !important;
        color: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 !important;
        cursor: pointer !important;
        transition: all 0.15s ease-in-out !important;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.25) !important;
    }
    .qv-close-btn:hover { background-color: #b91c1c !important; transform: scale(1.08); }
    .qv-close-btn svg { width: 14px !important; height: 14px !important; stroke: #ffffff !important; display: block !important; }

    /* ─── CDC Customer Info Box ─── */
    .cdc-info-box {
        background: #f0fdf4;
        border: 1.5px solid #bbf7d0;
        border-radius: 14px;
        padding: 12px 14px;
    }
    html.dark .cdc-info-box,
    body.dark .cdc-info-box,
    body[data-layout-mode="dark"] .cdc-info-box {
        background: #1e293b !important;
        border-color: #334155 !important;
    }

    /* ─── Due Breakdown Table ─── */
    .cdc-due-table-wrap {
        border-radius: 10px;
        overflow: hidden;
        border: 1.5px solid #bbf7d0;
        background: #ffffff;
    }
    html.dark .cdc-due-table-wrap,
    body.dark .cdc-due-table-wrap,
    body[data-layout-mode="dark"] .cdc-due-table-wrap {
        background: #0f172a !important;
        border-color: #334155 !important;
    }
    .cdc-due-table { width: 100%; border-collapse: collapse; text-align: left; }
    .cdc-due-table thead tr { background: #f1f5f9; border-bottom: 1px solid #e2e8f0; }
    html.dark .cdc-due-table thead tr,
    body.dark .cdc-due-table thead tr,
    body[data-layout-mode="dark"] .cdc-due-table thead tr {
        background: #1e293b !important;
        border-bottom-color: #334155 !important;
    }
    .cdc-due-table th {
        padding: 9px 14px;
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #475569;
        white-space: nowrap;
    }
    html.dark .cdc-due-table th,
    body.dark .cdc-due-table th,
    body[data-layout-mode="dark"] .cdc-due-table th { color: #94a3b8 !important; }
    .cdc-due-table td {
        padding: 10px 14px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
    }
    html.dark .cdc-due-table td,
    body.dark .cdc-due-table td,
    body[data-layout-mode="dark"] .cdc-due-table td { color: #e2e8f0 !important; }

    /* ─── Mobile Due Grid (hidden by default, shown on small screens) ─── */
    .cdc-due-mobile-grid { display: none; }
    @media (max-width: 480px) {
        .cdc-due-table-wrap { display: none; }
        .cdc-due-mobile-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
            margin-top: 10px;
        }
    }
    .cdc-due-mobile-cell {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 6px;
        text-align: center;
    }
    html.dark .cdc-due-mobile-cell,
    body.dark .cdc-due-mobile-cell,
    body[data-layout-mode="dark"] .cdc-due-mobile-cell { background: #1e293b !important; border-color: #334155 !important; }
    .cdc-due-mobile-total { background: #fff1f2 !important; border-color: #fecdd3 !important; }
    html.dark .cdc-due-mobile-total,
    body.dark .cdc-due-mobile-total,
    body[data-layout-mode="dark"] .cdc-due-mobile-total { background: #4c0519 !important; border-color: #be123c !important; }
    .cdc-due-label { display: block; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; color: #64748b; margin-bottom: 2px; }
    .cdc-due-val { display: block; font-size: 12px; font-weight: 700; color: #334155; }
    html.dark .cdc-due-val,
    body.dark .cdc-due-val,
    body[data-layout-mode="dark"] .cdc-due-val { color: #e2e8f0 !important; }

    /* ─── Label ─── */
    .cdc-label {
        display: block;
        text-align: left !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #475569;
        margin-bottom: 6px;
        margin-top: 6px;
    }
    html.dark .cdc-label,
    body.dark .cdc-label,
    body[data-layout-mode="dark"] .cdc-label { color: #94a3b8 !important; }

    /* ─── Form Inputs ─── */
    .cp-modal-input {
        height: 38px !important;
        min-height: 38px !important;
        max-height: 38px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 12px !important;
        font-size: 13px !important;
        padding: 0 12px !important;
        width: 100% !important;
        background-color: #ffffff !important;
        color: #1e293b !important;
        outline: none !important;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .cp-modal-input:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.18) !important;
    }
    html.dark .cp-modal-input,
    body.dark .cp-modal-input,
    body[data-layout-mode="dark"] .cp-modal-input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }

    /* ─── Sticky Footer ─── */
    .modal-footer-sticky {
        position: sticky;
        bottom: 0;
        z-index: 20;
        padding: 10px 16px !important;
        border-top: 1px solid #e2e8f0;
        background-color: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }
    html.dark .modal-footer-sticky,
    body.dark .modal-footer-sticky,
    body[data-layout-mode="dark"] .modal-footer-sticky {
        background-color: #0f172a !important;
        border-top-color: #334155 !important;
    }

    /* ─── Buttons ─── */
    .cp-btn-cancel {
        height: 38px !important; min-height: 38px !important;
        padding: 0 18px !important; border-radius: 12px !important;
        background-color: #dc2626 !important; color: #ffffff !important;
        font-weight: 700 !important; font-size: 13px !important;
        display: inline-flex !important; align-items: center !important;
        justify-content: center !important; gap: 6px !important;
        border: none !important; cursor: pointer !important;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3) !important;
        transition: all 0.15s !important; white-space: nowrap !important;
    }
    .cp-btn-cancel:hover { background-color: #b91c1c !important; transform: translateY(-1px); }

    .cp-btn-primary {
        height: 38px !important; min-height: 38px !important;
        padding: 0 18px !important; border-radius: 12px !important;
        background-color: #15803d !important; color: #ffffff !important;
        font-weight: 700 !important; font-size: 13px !important;
        display: inline-flex !important; align-items: center !important;
        justify-content: center !important; gap: 6px !important;
        border: none !important; cursor: pointer !important;
        box-shadow: 0 2px 8px rgba(21, 128, 61, 0.3) !important;
        transition: all 0.15s !important; white-space: nowrap !important;
    }
    .cp-btn-primary:hover { background-color: #166534 !important; transform: translateY(-1px); }

    /* ─── Badges ─── */
    .cp-badge {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 2px 10px; border-radius: 9999px; font-size: 11px;
        font-weight: 700; white-space: nowrap;
    }
    .cp-badge-id { background: #f0fdf4; color: #15803d; border: 1px solid #86efac; font-family: monospace; }
    html.dark .cp-badge-id,
    body.dark .cp-badge-id,
    body[data-layout-mode="dark"] .cp-badge-id { background: #064e3b; color: #6ee7b7; border-color: #047857; }

    /* ─── Payment Dropdown ─── */
    .custom-modal-dropdown { position: relative; z-index: 9999; }
    .custom-modal-dropdown .select-menu {
        max-height: 220px; overflow-y: auto;
        position: absolute; top: calc(100% + 4px);
        left: 0; right: 0; z-index: 999999 !important;
        background: #ffffff; border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        box-shadow: 0 14px 35px rgba(0, 0, 0, 0.2) !important;
        padding: 4px;
    }
    .custom-modal-dropdown .select-option-item {
        padding: 8px 12px; border-radius: 8px; font-size: 13px; font-weight: 500;
        color: #334155; cursor: pointer;
        display: flex; align-items: center; justify-content: space-between;
        transition: all 0.15s;
    }
    .custom-modal-dropdown .select-option-item:hover { background: #f0fdf4 !important; color: #15803d !important; }
    .custom-modal-dropdown .select-option-item.active { background: #dcfce7 !important; color: #15803d !important; font-weight: 700; }
    html.dark .custom-modal-dropdown .select-menu,
    body.dark .custom-modal-dropdown .select-menu,
    body[data-layout-mode="dark"] .custom-modal-dropdown .select-menu { background: #1e293b !important; border-color: #334155 !important; }
    html.dark .custom-modal-dropdown .select-option-item,
    body.dark .custom-modal-dropdown .select-option-item,
    body[data-layout-mode="dark"] .custom-modal-dropdown .select-option-item { color: #cbd5e1 !important; }
    html.dark .custom-modal-dropdown .select-option-item:hover,
    body.dark .custom-modal-dropdown .select-option-item:hover,
    body[data-layout-mode="dark"] .custom-modal-dropdown .select-option-item:hover { background: #0f2d1f !important; color: #4ade80 !important; }
    html.dark .custom-modal-dropdown .select-option-item.active,
    body.dark .custom-modal-dropdown .select-option-item.active,
    body[data-layout-mode="dark"] .custom-modal-dropdown .select-option-item.active { background: #14532d !important; color: #4ade80 !important; }
</style>

<script>
    let dueListDatePicker = null;
    function initDueListDatePicker() {
        const dateInput = document.getElementById('DueCollectionDate');
        if (dateInput && typeof flatpickr !== "undefined") {
            if (dueListDatePicker) {
                try { dueListDatePicker.destroy(); } catch (e) {}
            }
            dueListDatePicker = flatpickr(dateInput, {
                dateFormat: 'Y-m-d',
                defaultDate: 'today',
                allowInput: true,
                disableMobile: true,
                appendTo: document.body
            });
        }
    }

    function toggleDuePaymentDropdown() {
        const dropdown = document.getElementById('modalPaymentDropdown');
        if (!dropdown) return;
        const trigger = dropdown.querySelector('.select-trigger');
        const menu = dropdown.querySelector('.select-menu');
        const isOpen = menu.style.display === 'block';

        if (isOpen) {
            menu.style.display = 'none';
        } else {
            const triggerRect = trigger.getBoundingClientRect();
            const modalBody = dropdown.closest('.modal-body');

            let spaceBelow = window.innerHeight - triggerRect.bottom;
            if (modalBody) {
                const modalBodyRect = modalBody.getBoundingClientRect();
                spaceBelow = modalBodyRect.bottom - triggerRect.bottom;
            }

            if (spaceBelow < 210) {
                menu.style.top = 'auto';
                menu.style.bottom = 'calc(100% + 6px)';
                menu.style.boxShadow = '0 -10px 25px rgba(0, 0, 0, 0.18)';
            } else {
                menu.style.top = 'calc(100% + 6px)';
                menu.style.bottom = 'auto';
                menu.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.18)';
            }
            menu.style.display = 'block';
        }
    }

    function selectDuePaymentOption(value, html) {
        document.getElementById('selectedPaymentMethod').value = value;
        const dropdown = document.getElementById('modalPaymentDropdown');
        if (dropdown) {
            dropdown.querySelector('.selected-text').innerHTML = html;
            dropdown.querySelectorAll('.select-option-item').forEach(el => {
                if (el.getAttribute('data-value') === value) {
                    el.classList.add('active');
                } else {
                    el.classList.remove('active');
                }
            });
            dropdown.querySelector('.select-menu').style.display = 'none';
        }
    }

    // Close payment dropdown on click outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('modalPaymentDropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            const menu = dropdown.querySelector('.select-menu');
            if (menu) menu.style.display = 'none';
        }
    });

    const collectModalEl = document.getElementById('customerDueCollectModal') || document.getElementById('editModal');
    if (collectModalEl) {
        collectModalEl.addEventListener('shown.bs.modal', function () {
            initDueListDatePicker();
        });
    }

    function openModal(modal) {
        const modalEl = modal || document.getElementById('customerDueCollectModal') || document.getElementById('editModal');
        if (!modalEl) return;
        if (window.bootstrap && window.bootstrap.Modal) {
            let modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modalInstance.show();
        } else if (typeof $ !== 'undefined' && $(modalEl).modal) {
            $(modalEl).modal('show');
        } else {
            modalEl.style.display = 'block';
            modalEl.classList.add('show');
        }
    }

    function closeModal(modal) {
        const modalEl = modal || document.getElementById('customerDueCollectModal') || document.getElementById('editModal');
        if (!modalEl) return;
        if (window.bootstrap && window.bootstrap.Modal) {
            let modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) {
                modalInstance.hide();
            } else {
                modalEl.style.display = 'none';
                modalEl.classList.remove('show');
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
            }
        } else if (typeof $ !== 'undefined' && $(modalEl).modal) {
            $(modalEl).modal('hide');
        } else {
            modalEl.style.display = 'none';
            modalEl.classList.remove('show');
            document.body.classList.remove('modal-open');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
        }
    }

    async function FillUpUpdateForm(id) {
        try {
            document.getElementById('updateID').value = id;
            openModal(document.getElementById('customerDueCollectModal') || document.getElementById('editModal'));
            showLoader();

            let res = await axios.post("/api/customer-due-collection-details-by-id", {
                id: id.toString()
            }, HeaderToken());

            hideLoader();

            if (res.data.status === "success") {
                const data = res.data;
                const customer = data.rows || {};

                // Name & ID
                $('#modalCustomerName').text(customer.customer_name || customer.name || 'Customer');
                $('#modalCustomerId').text(customer.customer_id || 'CUST-0000');

                let prevDue = parseFloat(data.previous_due || 0).toFixed(2);
                let orderDue = parseFloat(data.order_due || 0).toFixed(2);
                let totalDue = parseFloat(data.total_due || 0).toFixed(2);

                // Update Desktop & Mobile values
                $('#PreviousDue').text(`৳ ${prevDue}`);
                $('#mobilePreviousDue').text(`৳ ${prevDue}`);
                $('#OrderDue').text(`৳ ${orderDue}`);
                $('#mobileOrderDue').text(`৳ ${orderDue}`);
                $('#TotalDue').text(`৳ ${totalDue}`);
                $('#mobileTotalDue').text(`৳ ${totalDue}`);
                $('#MyTotalDueAmount').text(`৳ ${totalDue}`);
                $('#PreviousDueAmount').text(`৳ ${prevDue}`);
                $('#ShowtotalDuePayable').text(`৳ ${totalDue}`);

                // Reset inputs
                document.getElementById('UpdateDueAmountclear').value = totalDue > 0 ? totalDue : '';
                document.getElementById('UpdateDiscountAmountclear').value = '0';
                document.getElementById('transactionInput').value = '';

                // Calculate initial
                calculateDuePayment();

                // Default Payment Method: Cash
                selectDuePaymentOption('cash', '<i class="fa-solid fa-money-bill text-emerald-600"></i> Cash');

                initDueListDatePicker();
                openModal(document.getElementById('customerDueCollectModal') || document.getElementById('editModal'));
            } else {
                console.error("Failed to fetch customer details:", res.data.message);
                errorToast(res.data.message || "Failed to fetch customer due details.");
            }
        } catch (e) {
            hideLoader();
            console.error("Error:", e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    function calculateDuePayment() {
        const totalDueText = document.getElementById('TotalDue').innerText || '0';
        const totalDueAmount = parseFloat(totalDueText.replace(/[^\d.-]/g, '')) || 0;

        const enteredAmount = parseFloat(document.getElementById('UpdateDueAmountclear').value) || 0;
        const discountAmount = parseFloat(document.getElementById('UpdateDiscountAmountclear').value) || 0;

        const totalPaidWithDiscount = enteredAmount + discountAmount;
        const newTotalDue = parseFloat((totalDueAmount - totalPaidWithDiscount).toFixed(2));
        const finalDueAmount = newTotalDue >= 0 ? newTotalDue : 0;

        document.getElementById('ShowtotalDuePayable').textContent = `৳ ${finalDueAmount.toFixed(2)}`;

        const paymentStatusDisplay = document.getElementById('ShowpaymentStatusDisplay');
        if (finalDueAmount === 0 && enteredAmount > 0) {
            paymentStatusDisplay.textContent = "Fully Paid";
            paymentStatusDisplay.className = "badge px-3 py-1 font-bold text-xs bg-emerald-600 text-white rounded-full";
        } else if (enteredAmount > 0 && finalDueAmount < totalDueAmount) {
            paymentStatusDisplay.textContent = "Partial Paid";
            paymentStatusDisplay.className = "badge px-3 py-1 font-bold text-xs bg-blue-600 text-white rounded-full";
        } else {
            paymentStatusDisplay.textContent = "Unpaid";
            paymentStatusDisplay.className = "badge px-3 py-1 font-bold text-xs bg-rose-600 text-white rounded-full";
        }

        const showDiscount = document.getElementById('ShowDiscountAmount');
        if (showDiscount) {
            showDiscount.textContent = `৳ ${discountAmount.toFixed(2)}`;
        }
    }

    async function SavePaymentInfo(event) {
        if (event) event.preventDefault();

        try {
            const paidAmount = parseFloat(document.getElementById('UpdateDueAmountclear').value) || 0;
            const DiscountAmount = parseFloat(document.getElementById('UpdateDiscountAmountclear').value) || 0;
            const PreviousDue = parseFloat(document.getElementById('PreviousDue').innerText.replace(/[^\d.-]/g, '')) || 0;
            const dueAmount = parseFloat(document.getElementById('ShowtotalDuePayable').innerText.replace(/[^\d.-]/g, '')) || 0;
            const transactionId = document.getElementById('transactionInput').value;
            const CollectionDate = document.getElementById('DueCollectionDate').value;
            const paymentStatus = document.getElementById('ShowpaymentStatusDisplay').innerText;
            const updateID = parseInt(document.getElementById('updateID').value);
            const paymentMethod = document.getElementById('selectedPaymentMethod').value || 'cash';

            if (!paidAmount || paidAmount <= 0) {
                errorToast('Please enter a valid pay amount.');
                return;
            }
            if (!paymentStatus) {
                errorToast('Payment status is missing.');
                return;
            }

            let formData = new FormData();
            formData.append('id', updateID);
            formData.append('paid_amount', paidAmount);
            formData.append('discount_amount', DiscountAmount);
            formData.append('due_amount', dueAmount);
            formData.append('previous_due_amount', PreviousDue);
            formData.append('due_collection_date', CollectionDate);
            formData.append('payment_status', paymentStatus);
            formData.append('transaction_id', transactionId);
            formData.append('payment_method', paymentMethod);

            showLoader();
            let res = await axios.post("/api/customer-payment-details-update", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            });
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message || "Due collection updated successfully!");
                closeModal(document.getElementById('customerDueCollectModal') || document.getElementById('editModal'));
                
                // Refresh both lists
                await loadCustomerDueData();
                await loadCustomerDueCollectionData();
            } else {
                errorToast(res.data.message || "Failed to update collection.");
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            unauthorized(e.response?.status || 500);
        }
    }
</script>
