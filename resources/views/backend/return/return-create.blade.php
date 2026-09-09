<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- Sales & Purchase Return Processing Modal -->
<div class="modal fade" id="processReturnModal" tabindex="-1" aria-labelledby="processReturnModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Sticky Top Green Header -->
            <div id="modalHeaderBox" class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.2); color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                            <polyline points="1 4 1 10 7 10"></polyline>
                            <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                        </svg>
                    </div>
                    <h5 class="modal-title m-0 text-white fw-bold" id="processReturnModalLabel" style="font-size: 16px; color: #ffffff !important;">
                        <span id="modalHeaderTitle">Sales Return Processing</span>
                    </h5>
                </div>
                <!-- Circular Red Close Button with White Icon -->
                <button type="button" class="custom-modal-close-btn d-flex align-items-center justify-content-center border-0 shadow-sm" data-bs-dismiss="modal" aria-label="Close" style="position: relative !important; top: auto !important; right: auto !important; width: 26px !important; height: 26px !important; min-width: 26px !important; min-height: 26px !important; border-radius: 50% !important; background-color: #ef4444 !important; color: #ffffff !important; cursor: pointer !important; transition: all 0.2s ease; padding: 0 !important; margin: 0 !important; flex-shrink: 0 !important;" title="Close">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Scrollable Modal Body (strictly left aligned, internal scroll) -->
            <div class="modal-body custom-scrollbar text-start" style="text-align: left !important;">

                <!-- Search Bar inside Modal -->
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/60 p-3 mb-3 text-start">
                    <label id="modalSearchLabel" class="custom-modal-label text-start" style="margin-top: 0 !important;">Search Invoice Number</label>
                    <div class="flex items-center gap-2 mt-1.5">
                        <div class="search-input-wrapper unified-ui-border flex-1 h-[38px] flex items-center px-3 bg-white dark:bg-slate-700/60 rounded-xl shadow-sm focus-within:border-emerald-600">
                            <input type="text" id="modalInvoiceSearchInput" style="border: none !important; outline: none !important; box-shadow: none !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0" placeholder="e.g. #InvID00001 or PUR-0001" onkeydown="if(event.key==='Enter') searchInvoiceInModal()" />
                        </div>
                        <button id="modalSearchBtn" onclick="searchInvoiceInModal()" type="button" class="px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 text-white font-semibold text-xs sm:text-sm rounded-xl shadow-sm transition-all flex-shrink-0">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> Search
                        </button>
                    </div>
                </div>

                <!-- Invoice / Purchase Details Summary Card (Initially Hidden) -->
                <div id="invoiceSummaryCard" class="d-none mb-3 p-3 bg-emerald-50/70 dark:bg-emerald-950/30 border border-emerald-200 dark:border-slate-800 rounded-2xl text-start">
                    <div class="row g-2 text-slate-800 dark:text-slate-100">
                        <div class="col-md-6 col-12">
                            <span id="summaryNoLabel" class="text-slate-400 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider block">Invoice / Order No:</span>
                            <h5 id="modalOrderNo" class="font-bold text-emerald-700 dark:text-emerald-400 text-sm mb-1 font-mono">#InvID00001</h5>
                            <span id="summaryPartyLabel" class="text-slate-400 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider block">Customer Name:</span>
                            <span id="modalCustomerName" class="font-bold text-slate-800 dark:text-slate-100 text-xs sm:text-sm block">Rakib Hasan</span>
                        </div>
                        <div class="col-md-6 col-12 text-md-end">
                            <span class="text-slate-500 dark:text-slate-400 text-xs block"><span id="summaryDateLabel">Date</span>: <strong id="modalInvoiceDate" class="text-slate-800 dark:text-slate-100">01 Aug 2026</strong></span>
                            <span class="text-slate-500 dark:text-slate-400 text-xs block">Sub Total: <strong id="modalSubTotal" class="text-slate-800 dark:text-slate-100">৳ 0.00</strong></span>
                            <span class="text-slate-500 dark:text-slate-400 text-xs block">Paid: <strong id="modalPaidAmount" class="text-emerald-600 font-bold">৳ 0.00</strong> | Due: <strong id="modalDueAmount" class="text-rose-600 font-bold">৳ 0.00</strong></span>
                        </div>
                    </div>
                </div>

                <!-- Return Products Table (Initially Hidden) -->
                <div id="returnItemsContainer" class="d-none text-start">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="font-bold text-slate-800 dark:text-slate-100 mb-0 text-sm flex items-center gap-1.5">
                            <i class="fa-solid fa-square-check text-emerald-600"></i> Select items to return:
                        </h6>
                        <span class="badge bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 font-semibold" style="font-size: 10px;">Check item and enter quantity</span>
                    </div>

                    <div class="table-responsive unified-ui-border rounded-xl shadow-sm bg-white dark:bg-slate-900 mb-3">
                        <table class="w-full text-left border-collapse text-xs sm:text-sm">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-[11px] font-semibold uppercase tracking-wider">
                                    <th class="p-2.5 text-center w-[40px]">
                                        <input type="checkbox" id="selectAllReturnItems" class="cursor-pointer" onchange="toggleSelectAllReturnItems(this)" title="Select All Items" />
                                    </th>
                                    <th class="p-2.5 text-start">Product Name</th>
                                    <th class="p-2.5 text-center w-[90px]">Quantity</th>
                                    <th class="p-2.5 text-end w-[110px]">Unit Price</th>
                                    <th class="p-2.5 text-center w-[110px]">Return Qty</th>
                                    <th class="p-2.5 text-end w-[120px] pe-3">Refund Total</th>
                                </tr>
                            </thead>
                            <tbody id="returnItemsTbody" class="divide-y divide-slate-100 dark:divide-slate-800">
                                <!-- Populated dynamically -->
                            </tbody>
                            <tfoot class="font-bold border-t border-slate-200 dark:border-slate-700" style="background-color: #f8fafc;">
                                <tr>
                                    <td colspan="5" class="p-2.5 text-end text-xs uppercase text-slate-600">Total Refund Amount:</td>
                                    <td id="totalRefundText" class="p-2.5 text-end pe-3 font-extrabold text-rose-600 dark:text-rose-400">৳ 0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Return Date & Return Note (2 Columns) -->
                    <div class="row g-2.5 text-start">
                        <div class="col-md-6 col-12 text-start">
                            <label class="custom-modal-label text-start">Return Date <span class="text-danger">*</span></label>
                            <input type="text" id="modalReturnDate" class="custom-modal-input text-start" placeholder="YYYY-MM-DD" autocomplete="off" />
                        </div>
                        <div class="col-md-6 col-12 text-start">
                            <label class="custom-modal-label text-start">Return Reason / Note</label>
                            <input type="text" id="modalReturnNote" class="custom-modal-input text-start" placeholder="Optional return note..." />
                        </div>
                    </div>
                </div>

            </div>

            <!-- Sticky Bottom Footer with Red Cancel & Green Save Buttons (Strict 38px height) -->
            <div class="modal-footer d-flex align-items-center justify-content-end gap-2 flex-shrink-0">
                <button type="button" class="btn fw-semibold px-4 shadow-sm" data-bs-dismiss="modal" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important; cursor: pointer; transition: opacity 0.2s;">
                    Cancel
                </button>
                <button type="button" id="submitReturnBtn" onclick="submitReturnForm()" class="btn text-white fw-bold px-4 shadow-sm d-none" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; font-size: 13.5px !important; cursor: pointer;">
                    <i class="fa-solid fa-check me-1"></i> Process Return
                </button>
            </div>

        </div>
    </div>
</div>

<style>
    /* Modal Container & Scroll Locks */
    #processReturnModal {
        overflow-y: hidden !important;
        padding-right: 0 !important;
    }
    #processReturnModal .modal-dialog {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        max-width: 820px !important;
        width: 95% !important;
        margin: 4vh auto !important;
        max-height: 92vh !important;
        height: auto !important;
        display: flex !important;
        align-items: center !important;
    }
    #processReturnModal .modal-content {
        border-radius: 16px !important;
        overflow: hidden !important;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        display: flex !important;
        flex-direction: column !important;
        max-height: 92vh !important;
        width: 100% !important;
    }

    #processReturnModal .modal-header {
        background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important;
        color: #ffffff !important;
        padding: 12px 20px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        position: relative !important;
        flex-shrink: 0 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15) !important;
    }

    #processReturnModal .modal-body {
        padding: 16px 20px !important;
        overflow-y: auto !important;
        max-height: calc(92vh - 125px) !important;
        background-color: #ffffff !important;
        text-align: left !important;
    }

    #processReturnModal .modal-footer {
        padding: 10px 20px !important;
        background-color: #f8fafc !important;
        border-top: 1px solid #e2e8f0 !important;
        position: relative !important;
        flex-shrink: 0 !important;
    }

    .custom-modal-label {
        display: block !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #334155 !important;
        margin-top: 6px !important;
        margin-bottom: 4px !important;
        text-align: left !important;
    }

    .custom-modal-input {
        width: 100% !important;
        height: 42px !important;
        padding: 0 14px !important;
        font-size: 13.5px !important;
        color: #0f172a !important;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        outline: none !important;
        transition: border-color 0.15s ease, box-shadow 0.15s ease !important;
        box-sizing: border-box !important;
        text-align: left !important;
    }
    .custom-modal-input:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.2) !important;
    }

    /* Dark Mode */
    body[light-mode="dark"] #processReturnModal .modal-content,
    body[data-layout-mode="dark"] #processReturnModal .modal-content,
    html.dark #processReturnModal .modal-content,
    body.dark-mode #processReturnModal .modal-content,
    body.dark #processReturnModal .modal-content {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #processReturnModal .modal-body,
    body[data-layout-mode="dark"] #processReturnModal .modal-body,
    html.dark #processReturnModal .modal-body,
    body.dark-mode #processReturnModal .modal-body,
    body.dark #processReturnModal .modal-body {
        background-color: #0f172a !important;
    }
    body[light-mode="dark"] #processReturnModal .modal-footer,
    body[data-layout-mode="dark"] #processReturnModal .modal-footer,
    html.dark #processReturnModal .modal-footer,
    body.dark-mode #processReturnModal .modal-footer,
    body.dark #processReturnModal .modal-footer {
        background-color: #1e293b !important;
        border-top-color: #334155 !important;
    }
    body[light-mode="dark"] #processReturnModal .custom-modal-label,
    body[data-layout-mode="dark"] #processReturnModal .custom-modal-label,
    html.dark #processReturnModal .custom-modal-label,
    body.dark-mode #processReturnModal .custom-modal-label,
    body.dark #processReturnModal .custom-modal-label {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] #processReturnModal .custom-modal-input,
    body[data-layout-mode="dark"] #processReturnModal .custom-modal-input,
    html.dark #processReturnModal .custom-modal-input,
    body.dark-mode #processReturnModal .custom-modal-input,
    body.dark #processReturnModal .custom-modal-input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    /* Dark mode: modal search box wrapper */
    body[light-mode="dark"] #processReturnModal .modal-body > div:first-child,
    body[data-layout-mode="dark"] #processReturnModal .modal-body > div:first-child,
    html.dark #processReturnModal .modal-body > div:first-child,
    body.dark-mode #processReturnModal .modal-body > div:first-child,
    body.dark #processReturnModal .modal-body > div:first-child {
        background-color: rgba(30, 41, 59, 0.6) !important;
        border-color: #334155 !important;
    }
    /* Dark mode: search input wrapper inside modal */
    body[light-mode="dark"] #processReturnModal .search-input-wrapper,
    body[data-layout-mode="dark"] #processReturnModal .search-input-wrapper,
    html.dark #processReturnModal .search-input-wrapper,
    body.dark-mode #processReturnModal .search-input-wrapper,
    body.dark #processReturnModal .search-input-wrapper {
        background-color: rgba(51, 65, 85, 0.6) !important;
        border-color: #334155 !important;
    }
    /* Dark mode: table tfoot inside modal */
    body[light-mode="dark"] #processReturnModal tfoot,
    body[data-layout-mode="dark"] #processReturnModal tfoot,
    html.dark #processReturnModal tfoot,
    body.dark-mode #processReturnModal tfoot,
    body.dark #processReturnModal tfoot {
        background-color: rgba(30, 41, 59, 0.6) !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }
    body[light-mode="dark"] #processReturnModal tfoot td,
    body[data-layout-mode="dark"] #processReturnModal tfoot td,
    html.dark #processReturnModal tfoot td,
    body.dark-mode #processReturnModal tfoot td,
    body.dark #processReturnModal tfoot td {
        color: #f1f5f9 !important;
    }

    /* Flatpickr Calendar Styling */
    .flatpickr-calendar {
        z-index: 99999999 !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.15), 0 8px 10px -6px rgba(0,0,0,0.1) !important;
        border: 1px solid #cbd5e1 !important;
    }
    /* Disable month dropdown — use prev/next arrows only */
    .flatpickr-monthDropdown-months {
        pointer-events: none !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        appearance: none !important;
        cursor: default !important;
        background: transparent !important;
        border: none !important;
        outline: none !important;
        font-weight: 600;
    }
    /* Flatpickr Dark Mode */
    body[data-layout-mode="dark"] .flatpickr-calendar,
    body[light-mode="dark"] .flatpickr-calendar,
    html.dark .flatpickr-calendar,
    body.dark-mode .flatpickr-calendar,
    body.dark .flatpickr-calendar {
        background: #1e293b !important;
        border-color: #334155 !important;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.5), 0 4px 10px -2px rgba(0,0,0,0.4) !important;
        color: #f1f5f9 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-months,
    body[light-mode="dark"] .flatpickr-months,
    html.dark .flatpickr-months,
    body.dark-mode .flatpickr-months,
    body.dark .flatpickr-months,
    body[data-layout-mode="dark"] .flatpickr-month,
    body[light-mode="dark"] .flatpickr-month,
    html.dark .flatpickr-month,
    body.dark-mode .flatpickr-month,
    body.dark .flatpickr-month {
        background: #0f172a !important;
        color: #f1f5f9 !important;
        fill: #f1f5f9 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-current-month,
    body[light-mode="dark"] .flatpickr-current-month,
    html.dark .flatpickr-current-month,
    body.dark-mode .flatpickr-current-month,
    body.dark .flatpickr-current-month,
    body[data-layout-mode="dark"] .flatpickr-current-month .numInputWrapper input,
    body[light-mode="dark"] .flatpickr-current-month .numInputWrapper input,
    html.dark .flatpickr-current-month .numInputWrapper input,
    body[data-layout-mode="dark"] .flatpickr-current-month .flatpickr-monthDropdown-months,
    body[light-mode="dark"] .flatpickr-current-month .flatpickr-monthDropdown-months,
    html.dark .flatpickr-current-month .flatpickr-monthDropdown-months,
    body.dark-mode .flatpickr-current-month .flatpickr-monthDropdown-months,
    body.dark .flatpickr-current-month .flatpickr-monthDropdown-months {
        color: #f1f5f9 !important;
        background: transparent !important;
    }
    body[data-layout-mode="dark"] .flatpickr-prev-month,
    body[light-mode="dark"] .flatpickr-prev-month,
    html.dark .flatpickr-prev-month,
    body.dark-mode .flatpickr-prev-month,
    body.dark .flatpickr-prev-month,
    body[data-layout-mode="dark"] .flatpickr-next-month,
    body[light-mode="dark"] .flatpickr-next-month,
    html.dark .flatpickr-next-month,
    body.dark-mode .flatpickr-next-month,
    body.dark .flatpickr-next-month {
        color: #94a3b8 !important;
        fill: #94a3b8 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-prev-month:hover,
    body[light-mode="dark"] .flatpickr-prev-month:hover,
    html.dark .flatpickr-prev-month:hover,
    body[data-layout-mode="dark"] .flatpickr-next-month:hover,
    body[light-mode="dark"] .flatpickr-next-month:hover,
    html.dark .flatpickr-next-month:hover {
        color: #10b981 !important;
        fill: #10b981 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-weekdays,
    body[light-mode="dark"] .flatpickr-weekdays,
    html.dark .flatpickr-weekdays,
    body.dark-mode .flatpickr-weekdays,
    body.dark .flatpickr-weekdays {
        background: #0f172a !important;
    }
    body[data-layout-mode="dark"] span.flatpickr-weekday,
    body[light-mode="dark"] span.flatpickr-weekday,
    html.dark span.flatpickr-weekday,
    body.dark-mode span.flatpickr-weekday,
    body.dark span.flatpickr-weekday {
        background: #0f172a !important;
        color: #64748b !important;
    }
    body[data-layout-mode="dark"] .flatpickr-day,
    body[light-mode="dark"] .flatpickr-day,
    html.dark .flatpickr-day,
    body.dark-mode .flatpickr-day,
    body.dark .flatpickr-day {
        color: #e2e8f0 !important;
        border-color: transparent !important;
    }
    body[data-layout-mode="dark"] .flatpickr-day:hover,
    body[light-mode="dark"] .flatpickr-day:hover,
    html.dark .flatpickr-day:hover,
    body.dark-mode .flatpickr-day:hover,
    body.dark .flatpickr-day:hover {
        background: #334155 !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-day.today,
    body[light-mode="dark"] .flatpickr-day.today,
    html.dark .flatpickr-day.today,
    body.dark-mode .flatpickr-day.today,
    body.dark .flatpickr-day.today {
        border-color: #10b981 !important;
        color: #10b981 !important;
    }
    body[data-layout-mode="dark"] .flatpickr-day.today:hover,
    body[light-mode="dark"] .flatpickr-day.today:hover,
    html.dark .flatpickr-day.today:hover {
        background: #10b981 !important;
        color: #ffffff !important;
    }
    body[data-layout-mode="dark"] .flatpickr-day.selected,
    body[light-mode="dark"] .flatpickr-day.selected,
    html.dark .flatpickr-day.selected,
    body.dark-mode .flatpickr-day.selected,
    body.dark .flatpickr-day.selected {
        background: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }
    body[data-layout-mode="dark"] .flatpickr-day.prevMonthDay,
    body[light-mode="dark"] .flatpickr-day.prevMonthDay,
    html.dark .flatpickr-day.prevMonthDay,
    body[data-layout-mode="dark"] .flatpickr-day.nextMonthDay,
    body[light-mode="dark"] .flatpickr-day.nextMonthDay,
    html.dark .flatpickr-day.nextMonthDay {
        color: #475569 !important;
    }
    body[data-layout-mode="dark"] .numInputWrapper span,
    body[light-mode="dark"] .numInputWrapper span,
    html.dark .numInputWrapper span {
        border-color: #334155 !important;
    }
    body[data-layout-mode="dark"] .numInputWrapper span:after,
    body[light-mode="dark"] .numInputWrapper span:after,
    html.dark .numInputWrapper span:after {
        border-top-color: #94a3b8 !important;
        border-bottom-color: #94a3b8 !important;
    }
</style>

<script>
    let currentReturnMode = 'sales'; // 'sales' or 'purchase'
    let currentReturnOrderData = null;

    window.returnDatepicker = null;

    function initReturnDatepicker() {
        const dateInput = document.getElementById('modalReturnDate');
        if (dateInput && typeof flatpickr !== 'undefined') {
            if (window.returnDatepicker) window.returnDatepicker.destroy();
            window.returnDatepicker = flatpickr(dateInput, {
                dateFormat: "Y-m-d",
                defaultDate: new Date(),
                allowInput: true,
                clickOpens: true,
                disableMobile: true,
                onOpen: function() {
                    $(document).off('focusin.bs.modal');
                }
            });
        }
    }

    // Re-init every time the modal is fully shown
    $('#processReturnModal').on('shown.bs.modal', function () {
        initReturnDatepicker();
    });

    function openReturnModal(orderNo = '', mode = 'sales') {
        currentReturnMode = mode;
        currentReturnOrderData = null;

        const headerBox = document.getElementById('modalHeaderBox');
        const headerTitle = document.getElementById('modalHeaderTitle');
        const searchLabel = document.getElementById('modalSearchLabel');

        if (mode === 'purchase') {
            headerTitle.innerText = 'Purchase Return Processing';
            headerBox.style.background = 'linear-gradient(135deg, #0d9488 0%, #14b8a6 100%)';
            searchLabel.innerText = 'Search Purchase Memo / Invoice';
            document.getElementById('modalInvoiceSearchInput').placeholder = 'e.g. #PurID00001 or 1';
            document.getElementById('summaryNoLabel').innerText = 'Purchase No:';
            document.getElementById('summaryPartyLabel').innerText = 'Supplier Name:';
            document.getElementById('summaryDateLabel').innerText = 'Purchase Date';
        } else {
            headerTitle.innerText = 'Sales Return Processing';
            headerBox.style.background = 'linear-gradient(135deg, #15803d 0%, #16a34a 100%)';
            searchLabel.innerText = 'Search Invoice Number';
            document.getElementById('modalInvoiceSearchInput').placeholder = 'e.g. #InvID00001 or 1';
            document.getElementById('summaryNoLabel').innerText = 'Invoice / Order No:';
            document.getElementById('summaryPartyLabel').innerText = 'Customer Name:';
            document.getElementById('summaryDateLabel').innerText = 'Sale Date';
        }

        document.getElementById('modalInvoiceSearchInput').value = orderNo;
        document.getElementById('invoiceSummaryCard').classList.add('d-none');
        document.getElementById('returnItemsContainer').classList.add('d-none');
        document.getElementById('submitReturnBtn').classList.add('d-none');
        document.getElementById('returnItemsTbody').innerHTML = '';
        if (document.getElementById('selectAllReturnItems')) {
            document.getElementById('selectAllReturnItems').checked = false;
        }

        // Set today's date via flatpickr if available
        if (window.returnDatepicker) {
            window.returnDatepicker.setDate(new Date(), true);
        } else {
            document.getElementById('modalReturnDate').value = new Date().toISOString().split('T')[0];
        }

        $('#processReturnModal').modal('show');

        if (orderNo) {
            searchInvoiceInModal();
        }
    }

    async function searchInvoiceInModal() {
        const queryNo = document.getElementById('modalInvoiceSearchInput').value.trim();
        if (!queryNo) {
            alert(currentReturnMode === 'purchase' ? 'Please enter a purchase memo number' : 'Please enter an invoice number');
            return;
        }

        try {
            if (typeof showLoader === "function") showLoader();

            let url = '';
            if (currentReturnMode === 'purchase') {
                url = `/api/search-purchase-for-return?purchase_no=${encodeURIComponent(queryNo)}`;
            } else {
                url = `/api/search-invoice-for-return?order_no=${encodeURIComponent(queryNo)}`;
            }

            const res = await axios.get(url, HeaderToken());
            if (typeof hideLoader === "function") hideLoader();

            if (res.data && res.data.status === 'success') {
                if (currentReturnMode === 'purchase') {
                    const purchase = res.data.purchase;
                    currentReturnOrderData = purchase;

                    document.getElementById('modalOrderNo').innerText = purchase.purchase_no;
                    document.getElementById('modalCustomerName').innerText = `${purchase.supplier_name} (${purchase.supplier_mobile})`;
                    document.getElementById('modalInvoiceDate').innerText = purchase.purchase_date;
                    document.getElementById('modalSubTotal').innerText = '৳ ' + formatMoney(purchase.grand_subtotal);
                    document.getElementById('modalPaidAmount').innerText = '৳ ' + formatMoney(purchase.paid_amount);
                    document.getElementById('modalDueAmount').innerText = '৳ ' + formatMoney(purchase.due_amount);

                    renderReturnItems(purchase.items);
                } else {
                    const order = res.data.order;
                    currentReturnOrderData = order;

                    document.getElementById('modalOrderNo').innerText = order.order_no;
                    document.getElementById('modalCustomerName').innerText = `${order.customer_name} (${order.customer_mobile})`;
                    document.getElementById('modalInvoiceDate').innerText = order.invoice_date;
                    document.getElementById('modalSubTotal').innerText = '৳ ' + formatMoney(order.sub_total);
                    document.getElementById('modalPaidAmount').innerText = '৳ ' + formatMoney(order.paid_amount);
                    document.getElementById('modalDueAmount').innerText = '৳ ' + formatMoney(order.due_amount);

                    renderReturnItems(order.items);
                }

                document.getElementById('invoiceSummaryCard').classList.remove('d-none');
                document.getElementById('returnItemsContainer').classList.remove('d-none');
                document.getElementById('submitReturnBtn').classList.remove('d-none');
            } else {
                alert(res.data.message || (currentReturnMode === 'purchase' ? 'Purchase memo not found' : 'Invoice not found'));
            }
        } catch (e) {
            if (typeof hideLoader === "function") hideLoader();
            console.error('Invoice Search Error:', e);
            alert('Failed to search invoice');
        }
    }

    function renderReturnItems(items) {
        const tbody = document.getElementById('returnItemsTbody');
        tbody.innerHTML = '';

        if (!items || items.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center py-3 text-slate-400">No items found</td></tr>`;
            return;
        }

        items.forEach((item, idx) => {
            const detailId = currentReturnMode === 'purchase' ? item.purchase_order_detail_id : item.order_detail_id;
            const doorBadge = item.door_side ? `<span class="badge bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300 border border-indigo-200 dark:border-slate-800 px-2 py-0 ms-1 font-normal" style="font-size: 10px;"><i class="fa-solid fa-door-open me-1"></i>${item.door_side}</span>` : '';
            const row = `
                <tr data-detail-id="${detailId}" data-product-id="${item.product_id}" data-unit-price="${item.unit_price}" class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors">
                    <td class="p-2.5 text-center">
                        <input type="checkbox" class="cursor-pointer item-select-checkbox" onchange="onItemCheckboxChange(this)" />
                    </td>
                    <td class="p-2.5">
                        <div class="font-bold text-slate-800 dark:text-slate-100">${item.product_name} ${doorBadge}</div>
                        <span class="badge bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 font-mono" style="font-size: 10px;">${item.product_code}</span>
                    </td>
                    <td class="p-2.5 text-center font-bold text-slate-700 dark:text-slate-200">${item.quantity} pcs</td>
                    <td class="p-2.5 text-end font-semibold text-slate-700 dark:text-slate-200">৳ ${formatMoney(item.unit_price)}</td>
                    <td class="p-2.5 text-center">
                        <input type="number" class="custom-modal-input text-center font-bold return-qty-input" style="height: 34px !important; padding: 0 6px !important;"
                               min="1" max="${item.quantity}" value="0" disabled
                               oninput="onQtyInputChange(this)" onblur="onQtyInputBlur(this)" />
                    </td>
                    <td class="p-2.5 text-end pe-3 font-bold text-rose-600 dark:text-rose-400 refund-item-total">৳ 0.00</td>
                </tr>
            `;
            tbody.innerHTML += row;
        });

        recalculateTotalRefund();
    }

    function onItemCheckboxChange(chk) {
        const tr = chk.closest('tr');
        const qtyInput = tr.querySelector('.return-qty-input');
        const maxQty = parseInt(qtyInput.getAttribute('max')) || 1;

        if (chk.checked) {
            tr.classList.add('bg-emerald-50/50', 'dark:bg-emerald-950/20');
            qtyInput.disabled = false;
            let val = parseInt(qtyInput.value) || 0;
            if (val <= 0) {
                qtyInput.value = 1;
            } else if (val > maxQty) {
                qtyInput.value = maxQty;
            }
            setTimeout(() => {
                qtyInput.focus();
                qtyInput.select();
            }, 50);
        } else {
            tr.classList.remove('bg-emerald-50/50', 'dark:bg-emerald-950/20');
            qtyInput.value = 0;
            qtyInput.disabled = true;
        }
        recalculateTotalRefund();
    }

    function onQtyInputChange(input) {
        const tr = input.closest('tr');
        const chk = tr.querySelector('.item-select-checkbox');
        const maxQty = parseInt(input.getAttribute('max')) || 1;

        if (input.value !== '') {
            let val = parseInt(input.value);
            if (isNaN(val)) val = 0;

            if (val > maxQty) {
                input.value = maxQty;
            }

            if (val > 0 && !chk.checked) {
                chk.checked = true;
                tr.classList.add('bg-emerald-50/50', 'dark:bg-emerald-950/20');
                input.disabled = false;
            }
        }

        recalculateTotalRefund();
    }

    function onQtyInputBlur(input) {
        const tr = input.closest('tr');
        const chk = tr.querySelector('.item-select-checkbox');
        const maxQty = parseInt(input.getAttribute('max')) || 1;

        let val = parseInt(input.value);
        if (isNaN(val) || val <= 0) {
            if (chk.checked) {
                input.value = 1;
            } else {
                input.value = 0;
            }
        } else if (val > maxQty) {
            input.value = maxQty;
        }
        recalculateTotalRefund();
    }

    function toggleSelectAllReturnItems(headerChk) {
        const checkboxes = document.querySelectorAll('.item-select-checkbox');
        checkboxes.forEach(chk => {
            chk.checked = headerChk.checked;
            onItemCheckboxChange(chk);
        });
    }

    function recalculateTotalRefund() {
        let grandTotalRefund = 0;
        const rows = document.querySelectorAll('#returnItemsTbody tr');

        rows.forEach(row => {
            const chk = row.querySelector('.item-select-checkbox');
            const unitPrice = parseFloat(row.getAttribute('data-unit-price')) || 0;
            const qtyInput = row.querySelector('.return-qty-input');
            const itemTotalTd = row.querySelector('.refund-item-total');

            let qty = 0;
            if (chk && chk.checked) {
                qty = parseInt(qtyInput.value) || 0;
                const maxQty = parseInt(qtyInput.getAttribute('max')) || 0;
                if (qty > maxQty) qty = maxQty;
            }

            const itemRefund = qty * unitPrice;
            itemTotalTd.innerText = '৳ ' + formatMoney(itemRefund);
            grandTotalRefund += itemRefund;
        });

        document.getElementById('totalRefundText').innerText = '৳ ' + formatMoney(grandTotalRefund);
    }

    async function submitReturnForm() {
        if (!currentReturnOrderData) {
            alert('No record loaded');
            return;
        }

        const returnDate = document.getElementById('modalReturnDate').value;
        if (!returnDate) {
            alert('Please select a return date');
            return;
        }

        const returnedProducts = [];
        const rows = document.querySelectorAll('#returnItemsTbody tr');

        rows.forEach(row => {
            const chk = row.querySelector('.item-select-checkbox');
            if (chk && chk.checked) {
                const detailId = row.getAttribute('data-detail-id');
                const productId = row.getAttribute('data-product-id');
                const qtyInput = row.querySelector('.return-qty-input');
                const qty = parseInt(qtyInput.value) || 0;

                if (qty > 0) {
                    if (currentReturnMode === 'purchase') {
                        returnedProducts.push({
                            purchase_order_detail_id: detailId,
                            product_id: productId,
                            quantity: qty
                        });
                    } else {
                        returnedProducts.push({
                            order_detail_id: detailId,
                            product_id: productId,
                            quantity: qty
                        });
                    }
                }
            }
        });

        if (returnedProducts.length === 0) {
            alert('Please select at least one product and enter a return quantity greater than 0.');
            return;
        }

        let payload = {};
        let apiUrl = '';

        if (currentReturnMode === 'purchase') {
            apiUrl = '/api/create-purchase-return';
            payload = {
                purchase_id: currentReturnOrderData.id,
                supplier_id: currentReturnOrderData.supplier_id,
                date: returnDate,
                products: returnedProducts
            };
        } else {
            apiUrl = '/api/create-return-product';
            payload = {
                order_id: currentReturnOrderData.id,
                customer_id: currentReturnOrderData.customer_id,
                date: returnDate,
                products: returnedProducts
            };
        }

        try {
            if (typeof showLoader === "function") showLoader();
            const res = await axios.post(apiUrl, payload, HeaderToken());
            if (typeof hideLoader === "function") hideLoader();

            if (res.data && res.data.status === 'success') {
                if (typeof successToast === "function") successToast(res.data.message || 'Return processed successfully');
                else alert('Return processed successfully');

                $('#processReturnModal').modal('hide');

                if (typeof fetchActiveReturnList === "function") fetchActiveReturnList();
            } else {
                alert(res.data.message || 'Failed to process return');
            }

        } catch (e) {
            if (typeof hideLoader === "function") hideLoader();
            console.error('Return Submit Error:', e);
            alert(e.response?.data?.message || 'Error processing return');
        }
    }
</script>