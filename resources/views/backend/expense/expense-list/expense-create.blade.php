<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Create Expense Modal Start -->
<div class="modal fade" id="createExpenseModal" tabindex="-1" aria-labelledby="createExpenseModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
            <!-- Sticky Top Green Header -->
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.2); color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            <path d="M7 15h0M2 9.5h20"></path>
                        </svg>
                    </div>
                    <h5 class="modal-title m-0 text-white fw-bold" id="createExpenseModalLabel" style="font-size: 16px; color: #ffffff !important;">Create Expense</h5>
                </div>
                <!-- Circular Red Close Button with White Icon -->
                <button type="button" class="custom-modal-close-btn d-flex align-items-center justify-content-center border-0 shadow-sm" data-bs-dismiss="modal" onclick="closeExpenseModal()" aria-label="Close" style="position: relative !important; top: auto !important; right: auto !important; width: 26px !important; height: 26px !important; min-width: 26px !important; min-height: 26px !important; border-radius: 50% !important; background-color: #ef4444 !important; color: #ffffff !important; cursor: pointer !important; transition: all 0.2s ease; padding: 0 !important; margin: 0 !important; flex-shrink: 0 !important;" title="Close">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Scrollable Modal Body (ONLY between header and buttons, strictly left aligned) -->
            <div class="modal-body custom-scrollbar text-start" style="text-align: left !important;">
                <form id="expenseForm" onsubmit="return Save(event)" class="text-start" style="text-align: left !important;">
                    
                    <!-- Top Date & Quick Action Buttons (2 Column Row on desktop, stacked on mobile) -->
                    <div class="row g-2.5 mb-3 align-items-end text-start">
                        <div class="col-md-6 col-12 text-start">
                            <label for="ExpenseDate" class="custom-modal-label text-start" style="text-align: left !important;">
                                <i class="fa-regular fa-calendar-days text-emerald-600 me-1"></i> Expense Date <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="custom-modal-input text-start" id="ExpenseDate" required placeholder="YYYY-MM-DD" style="text-align: left !important; cursor: pointer;" />
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="d-flex flex-column flex-md-row gap-2 mt-2 mt-md-0">
                                <button type="button" class="btn btn-quick-newtype fw-semibold w-100 d-inline-flex align-items-center justify-content-center gap-1.5 shadow-sm newbrand-open" onclick="openBrandModal()">
                                    <i class="fa-solid fa-folder-plus"></i> + Create New Type
                                </button>
                                <button type="button" class="btn btn-quick-newstaff fw-semibold w-100 d-inline-flex align-items-center justify-content-center gap-1.5 shadow-sm" onclick="openStaffQuickModal()">
                                    <i class="fa-solid fa-user-plus"></i> + Add New Staff
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Multi-Expense Checkbox Selection List -->
                    <div class="expense-type-box rounded-2xl p-3 border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-900/50 mb-2">
                        <div class="d-flex align-items-center justify-content-between mb-2.5 pb-2 border-b border-slate-200 dark:border-slate-800">
                            <h6 class="fw-bold text-slate-800 dark:text-slate-100 mb-0 text-sm d-flex align-items-center gap-2">
                                <i class="fa-solid fa-list-check text-emerald-600"></i> Select Expense Type and Enter Amount:
                            </h6>
                            <small class="text-slate-500 dark:text-slate-400 text-xs">
                                <i class="fa-solid fa-circle-info text-indigo-500 me-1"></i> Select staff when paying salary
                            </small>
                        </div>

                        <div id="ExpenseTypesContainer" class="d-flex flex-column gap-2" style="max-height: 380px; overflow-y: auto;">
                            <div class="text-center py-4 text-slate-400">
                                <i class="fa-solid fa-circle-notch fa-spin me-2"></i> Loading expense types...
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Sticky Bottom Footer with Red Cancel & Green Save Buttons (Strict 38px height) -->
            <div class="modal-footer d-flex align-items-center justify-content-end gap-2 flex-shrink-0">
                <button type="button" onclick="closeExpenseModal()" class="btn fw-semibold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important; cursor: pointer; transition: opacity 0.2s;">
                    Cancel
                </button>
                <button type="button" onclick="Save(event)" class="btn text-white fw-bold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; font-size: 13.5px !important; cursor: pointer;">
                    Submit
                </button>
            </div>

        </div>
    </div>
</div>
<!-- Create Expense Modal End -->

<!-- Legacy Container Support if needed -->
<section id="createProduct" class="financemodal" style="display: none;"></section>

<!-- Add New Expense Type Sub-Modal Start -->
<div class="newbrand" id="addBrandModal" style="z-index: 9999999;">
    <div class="newbrand-content shadow-lg border-0" style="border-radius: 16px; width: 95%; max-width: 540px; padding: 22px 24px;">
        <div class="d-flex align-items-center justify-content-between mb-3.5 pb-2 border-bottom border-slate-100 dark:border-slate-800">
            <h5 class="fw-bold text-slate-800 dark:text-slate-100 mb-0 d-flex align-items-center gap-2" style="font-size: 16px;">
                <i class="fa-solid fa-folder-plus text-emerald-600"></i> New Expense Type
            </h5>
            <button type="button" class="custom-modal-close-btn d-flex align-items-center justify-content-center border-0 shadow-sm" onclick="closeBrandModal()" aria-label="Close" style="width: 26px !important; height: 26px !important; min-width: 26px !important; min-height: 26px !important; border-radius: 50% !important; background-color: #ef4444 !important; color: #ffffff !important; cursor: pointer !important; padding: 0 !important; margin: 0 !important;" title="Close">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <form onsubmit="saveExpenseType(event)">
            <div class="row g-3 mb-4 text-start" style="text-align: left !important;">
                <div class="col-12 col-md-6 text-start" style="text-align: left !important;">
                    <label for="CreateExpenseTypeName" class="custom-modal-label text-start" style="display: block !important; text-align: left !important; margin-bottom: 6px !important;">Expense Type Name <span class="text-danger">*</span></label>
                    <input type="text" id="CreateExpenseTypeName" class="custom-modal-input text-start" placeholder="e.g.: Shop Rent, Salary" required style="display: block !important; width: 100% !important; text-align: left !important; pointer-events: auto !important;" />
                </div>
                <div class="col-12 col-md-6 text-start" style="text-align: left !important;">
                    <label for="ExpenseSelectStatus" class="custom-modal-label text-start" style="display: block !important; text-align: left !important; margin-bottom: 6px !important;">Status <span class="text-danger">*</span></label>
                    <select class="custom-modal-input text-start" id="ExpenseSelectStatus" style="display: block !important; width: 100% !important; text-align: left !important; cursor: pointer !important; pointer-events: auto !important;">
                        <option value="Active" selected>Active</option>
                        <option value="InActive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 pt-2 border-top border-slate-100 dark:border-slate-800">
                <button type="button" class="btn text-white px-4 fw-semibold shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; border: none !important; cursor: pointer;" onclick="closeBrandModal()">Cancel</button>
                <button type="submit" class="btn text-white px-4 fw-bold shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; cursor: pointer;">Save</button>
            </div>
        </form>
    </div>
</div>
<!-- Add New Expense Type Sub-Modal End -->

<!-- Quick Add New Staff Sub-Modal Start -->
<div class="newbrand" id="addStaffQuickModal" style="z-index: 9999999;">
    <div class="newbrand-content shadow-lg border-0" style="border-radius: 16px; width: 95%; max-width: 580px; padding: 22px 24px;">
        <div class="d-flex align-items-center justify-content-between mb-3.5 pb-2 border-bottom border-slate-100 dark:border-slate-800">
            <h5 class="fw-bold text-slate-800 dark:text-slate-100 mb-0 d-flex align-items-center gap-2" style="font-size: 16px;">
                <i class="fa-solid fa-user-plus text-indigo-600"></i> Add New Staff
            </h5>
            <button type="button" class="custom-modal-close-btn d-flex align-items-center justify-content-center border-0 shadow-sm" onclick="closeStaffQuickModal()" aria-label="Close" style="width: 26px !important; height: 26px !important; min-width: 26px !important; min-height: 26px !important; border-radius: 50% !important; background-color: #ef4444 !important; color: #ffffff !important; cursor: pointer !important; padding: 0 !important; margin: 0 !important;" title="Close">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <form onsubmit="saveQuickStaff(event)">
            <div class="row g-3 mb-3 text-start" style="text-align: left !important;">
                <div class="col-12 col-md-6 text-start" style="text-align: left !important;">
                    <label for="QuickStaffName" class="custom-modal-label text-start" style="display: block !important; text-align: left !important; margin-bottom: 6px !important;">Staff Full Name <span class="text-danger">*</span></label>
                    <input type="text" id="QuickStaffName" class="custom-modal-input text-start" placeholder="e.g.: Md. Rafiq Ahmed" required style="display: block !important; width: 100% !important; text-align: left !important; pointer-events: auto !important;" />
                </div>
                <div class="col-12 col-md-6 text-start" style="text-align: left !important;">
                    <label for="QuickStaffMobile" class="custom-modal-label text-start" style="display: block !important; text-align: left !important; margin-bottom: 6px !important;">Mobile Number <span class="text-danger">*</span></label>
                    <input type="text" id="QuickStaffMobile" class="custom-modal-input text-start" placeholder="017XXXXXXXX" required style="display: block !important; width: 100% !important; text-align: left !important; pointer-events: auto !important;" />
                </div>
                <div class="col-12 col-md-6 text-start" style="text-align: left !important;">
                    <label for="QuickStaffEmail" class="custom-modal-label text-start" style="display: block !important; text-align: left !important; margin-bottom: 6px !important;">Email (Optional)</label>
                    <input type="email" id="QuickStaffEmail" class="custom-modal-input text-start" placeholder="staff@anisstore.com" style="display: block !important; width: 100% !important; text-align: left !important; pointer-events: auto !important;" />
                </div>
                <div class="col-12 col-md-6 text-start" style="text-align: left !important;">
                    <label for="QuickStaffRole" class="custom-modal-label text-start" style="display: block !important; text-align: left !important; margin-bottom: 6px !important;">Role / Status <span class="text-danger">*</span></label>
                    <select class="custom-modal-input text-start" id="QuickStaffRole" style="display: block !important; width: 100% !important; text-align: left !important; cursor: pointer !important; pointer-events: auto !important;">
                        <option value="staff" selected>Staff</option>
                        <option value="cashier">Cashier</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 pt-2 border-top border-slate-100 dark:border-slate-800">
                <button type="button" class="btn text-white px-4 fw-semibold shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; border: none !important; cursor: pointer;" onclick="closeStaffQuickModal()">Cancel</button>
                <button type="submit" class="btn text-white px-4 fw-bold shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; cursor: pointer;">Save Staff</button>
            </div>
        </form>
    </div>
</div>
<!-- Quick Add New Staff Sub-Modal End -->

<style>
    /* Modal Container & Scroll Locks */
    #createExpenseModal {
        overflow-y: hidden !important;
        padding-right: 0 !important;
    }
    #createExpenseModal .modal-dialog {
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
    #createExpenseModal .modal-content {
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

    #createExpenseModal .modal-header {
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

    #createExpenseModal .modal-body {
        padding: 16px 20px !important;
        overflow-y: auto !important;
        max-height: calc(92vh - 125px) !important;
        background-color: #ffffff !important;
        text-align: left !important;
    }

    #createExpenseModal .modal-footer {
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
        border: 1.5px solid #cbd5e1 !important;
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

    /* Quick Action Buttons (Full width on mobile, side-by-side on desktop) */
    .btn-quick-newtype {
        height: 42px !important;
        border-radius: 8px !important;
        border: 1.5px solid #10b981 !important;
        color: #047857 !important;
        background-color: #ecfdf5 !important;
        font-size: 13px !important;
        transition: all 0.2s ease !important;
    }
    .btn-quick-newtype:hover {
        background-color: #d1fae5 !important;
        color: #065f46 !important;
    }

    .btn-quick-newstaff {
        height: 42px !important;
        border-radius: 8px !important;
        border: 1.5px solid #6366f1 !important;
        color: #4338ca !important;
        background-color: #eef2ff !important;
        font-size: 13px !important;
        transition: all 0.2s ease !important;
    }
    .btn-quick-newstaff:hover {
        background-color: #e0e7ff !important;
        color: #3730a3 !important;
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

    /* Sub-modal Styles Overrides */
    .newbrand {
        z-index: 9999999 !important;
        pointer-events: auto !important;
    }
    .newbrand-content {
        position: relative !important;
        left: auto !important;
        top: auto !important;
        transform: none !important;
        margin: auto !important;
        pointer-events: auto !important;
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
    }
    .newbrand-content .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    .newbrand-content .form-group {
        display: block !important;
        width: 100% !important;
    }
    .newbrand-content label {
        display: block !important;
        text-align: left !important;
        font-weight: 600 !important;
        color: #334155 !important;
        font-size: 13px !important;
        margin-bottom: 6px !important;
    }
    .newbrand-content input,
    .newbrand-content select {
        display: block !important;
        width: 100% !important;
        height: 42px !important;
        padding: 0 14px !important;
        border-radius: 8px !important;
        border: 1.5px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        font-size: 13.5px !important;
        color: #0f172a !important;
        outline: none !important;
        text-align: left !important;
        pointer-events: auto !important;
    }
    .newbrand-content input:focus,
    .newbrand-content select:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.2) !important;
    }

    .expense-item-card {
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        background-color: #ffffff;
        transition: all 0.15s ease;
    }
    .expense-item-card.is-checked {
        border-color: #10b981 !important;
        background-color: #f0fdf4 !important;
        box-shadow: 0 2px 6px rgba(16, 185, 129, 0.1) !important;
    }

    /* Dark Mode Overrides */
    body[data-layout-mode="dark"] #createExpenseModal .modal-content,
    body[light-mode="dark"] #createExpenseModal .modal-content,
    html.dark #createExpenseModal .modal-content,
    body.dark-mode #createExpenseModal .modal-content,
    body.dark #createExpenseModal .modal-content {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[data-layout-mode="dark"] #createExpenseModal .modal-body,
    body[light-mode="dark"] #createExpenseModal .modal-body,
    html.dark #createExpenseModal .modal-body,
    body.dark-mode #createExpenseModal .modal-body,
    body.dark #createExpenseModal .modal-body {
        background-color: #0f172a !important;
    }
    body[data-layout-mode="dark"] #createExpenseModal .modal-footer,
    body[light-mode="dark"] #createExpenseModal .modal-footer,
    html.dark #createExpenseModal .modal-footer,
    body.dark-mode #createExpenseModal .modal-footer,
    body.dark #createExpenseModal .modal-footer {
        background-color: #1e293b !important;
        border-top-color: #334155 !important;
    }
    body[data-layout-mode="dark"] #createExpenseModal .custom-modal-label,
    body[light-mode="dark"] #createExpenseModal .custom-modal-label,
    html.dark #createExpenseModal .custom-modal-label,
    body.dark-mode #createExpenseModal .custom-modal-label,
    body.dark #createExpenseModal .custom-modal-label {
        color: #cbd5e1 !important;
    }
    body[data-layout-mode="dark"] .custom-modal-input,
    body[light-mode="dark"] .custom-modal-input,
    html.dark .custom-modal-input,
    body.dark-mode .custom-modal-input,
    body.dark .custom-modal-input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[data-layout-mode="dark"] .custom-modal-input:focus,
    body[light-mode="dark"] .custom-modal-input:focus,
    html.dark .custom-modal-input:focus {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2) !important;
    }

    /* Dark Mode for Quick Action Buttons */
    body[data-layout-mode="dark"] .btn-quick-newtype,
    body[light-mode="dark"] .btn-quick-newtype,
    html.dark .btn-quick-newtype,
    body.dark-mode .btn-quick-newtype,
    body.dark .btn-quick-newtype {
        background-color: rgba(16, 185, 129, 0.15) !important;
        border-color: #059669 !important;
        color: #34d399 !important;
    }
    body[data-layout-mode="dark"] .btn-quick-newtype:hover,
    body[light-mode="dark"] .btn-quick-newtype:hover,
    html.dark .btn-quick-newtype:hover {
        background-color: rgba(16, 185, 129, 0.25) !important;
    }

    body[data-layout-mode="dark"] .btn-quick-newstaff,
    body[light-mode="dark"] .btn-quick-newstaff,
    html.dark .btn-quick-newstaff,
    body.dark-mode .btn-quick-newstaff,
    body.dark .btn-quick-newstaff {
        background-color: rgba(99, 102, 241, 0.15) !important;
        border-color: #4f46e5 !important;
        color: #a5b4fc !important;
    }
    body[data-layout-mode="dark"] .btn-quick-newstaff:hover,
    body[light-mode="dark"] .btn-quick-newstaff:hover,
    html.dark .btn-quick-newstaff:hover {
        background-color: rgba(99, 102, 241, 0.25) !important;
    }

    /* Dark Mode for Expense Types Box & Cards */
    body[data-layout-mode="dark"] .expense-type-box,
    body[light-mode="dark"] .expense-type-box,
    html.dark .expense-type-box,
    body.dark-mode .expense-type-box,
    body.dark .expense-type-box {
        background-color: rgba(15, 23, 42, 0.6) !important;
        border-color: #334155 !important;
    }
    body[data-layout-mode="dark"] .expense-type-box .border-b,
    body[light-mode="dark"] .expense-type-box .border-b,
    html.dark .expense-type-box .border-b {
        border-color: #334155 !important;
    }
    body[data-layout-mode="dark"] .expense-type-box h6,
    body[light-mode="dark"] .expense-type-box h6,
    html.dark .expense-type-box h6 {
        color: #f8fafc !important;
    }

    body[data-layout-mode="dark"] .expense-item-card,
    body[light-mode="dark"] .expense-item-card,
    html.dark .expense-item-card,
    body.dark-mode .expense-item-card,
    body.dark .expense-item-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[data-layout-mode="dark"] .expense-item-card label,
    body[light-mode="dark"] .expense-item-card label,
    html.dark .expense-item-card label {
        color: #f8fafc !important;
    }
    body[data-layout-mode="dark"] .expense-item-card.is-checked,
    body[light-mode="dark"] .expense-item-card.is-checked,
    html.dark .expense-item-card.is-checked,
    body.dark-mode .expense-item-card.is-checked,
    body.dark .expense-item-card.is-checked {
        border-color: #10b981 !important;
        background-color: rgba(6, 78, 59, 0.3) !important;
    }
    body[data-layout-mode="dark"] .expense-item-card .salary-row,
    body[light-mode="dark"] .expense-item-card .salary-row,
    html.dark .expense-item-card .salary-row {
        border-color: #334155 !important;
    }

    /* Dark Mode for Sub-Modals (New Expense Type & New Staff) */
    body[data-layout-mode="dark"] .newbrand-content,
    body[light-mode="dark"] .newbrand-content,
    html.dark .newbrand-content,
    body.dark-mode .newbrand-content,
    body.dark .newbrand-content {
        background-color: #0f172a !important;
        border: 1px solid #334155 !important;
        color: #f8fafc !important;
    }
    body[data-layout-mode="dark"] .newbrand-content h5,
    body[light-mode="dark"] .newbrand-content h5,
    html.dark .newbrand-content h5 {
        color: #f8fafc !important;
    }
    body[data-layout-mode="dark"] .newbrand-content .border-bottom,
    body[data-layout-mode="dark"] .newbrand-content .border-top,
    body[light-mode="dark"] .newbrand-content .border-bottom,
    body[light-mode="dark"] .newbrand-content .border-top,
    html.dark .newbrand-content .border-bottom,
    html.dark .newbrand-content .border-top {
        border-color: #334155 !important;
    }
    body[data-layout-mode="dark"] .newbrand-content label,
    body[light-mode="dark"] .newbrand-content label,
    html.dark .newbrand-content label,
    body.dark-mode .newbrand-content label,
    body.dark .newbrand-content label {
        color: #cbd5e1 !important;
    }
    body[data-layout-mode="dark"] .newbrand-content input,
    body[data-layout-mode="dark"] .newbrand-content select,
    body[light-mode="dark"] .newbrand-content input,
    body[light-mode="dark"] .newbrand-content select,
    html.dark .newbrand-content input,
    html.dark .newbrand-content select,
    body.dark-mode .newbrand-content input,
    body.dark-mode .newbrand-content select,
    body.dark .newbrand-content input,
    body.dark .newbrand-content select {
        background-color: #1e293b !important;
        border: 1px solid #334155 !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[data-layout-mode="dark"] .newbrand-content input:focus,
    body[data-layout-mode="dark"] .newbrand-content select:focus,
    body[light-mode="dark"] .newbrand-content input:focus,
    body[light-mode="dark"] .newbrand-content select:focus,
    html.dark .newbrand-content input:focus,
    html.dark .newbrand-content select:focus {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2) !important;
    }

    /* Flatpickr Dark Mode — comprehensive */
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
    /* Month header and navigation area */
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
    /* Month/Year text */
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
    /* Navigation arrows */
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
    /* Weekday headers (Sun Mon Tue...) */
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
    /* Day numbers */
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
    /* Today highlight */
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
    /* Selected day */
    body[data-layout-mode="dark"] .flatpickr-day.selected,
    body[light-mode="dark"] .flatpickr-day.selected,
    html.dark .flatpickr-day.selected,
    body.dark-mode .flatpickr-day.selected,
    body.dark .flatpickr-day.selected {
        background: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }
    /* Prev/next month days (greyed out) */
    body[data-layout-mode="dark"] .flatpickr-day.prevMonthDay,
    body[light-mode="dark"] .flatpickr-day.prevMonthDay,
    html.dark .flatpickr-day.prevMonthDay,
    body[data-layout-mode="dark"] .flatpickr-day.nextMonthDay,
    body[light-mode="dark"] .flatpickr-day.nextMonthDay,
    html.dark .flatpickr-day.nextMonthDay {
        color: #475569 !important;
    }
    /* Year input number spinner */
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
    let globalExpenseTypes = [];
    let globalStaffList = [];

    document.addEventListener("DOMContentLoaded", function () {
        const today = new Date().toISOString().split('T')[0];
        const dateInput = document.getElementById('ExpenseDate');
        if (dateInput) dateInput.value = today;

        loadExpenseTypesAndStaff();
    });

    async function loadExpenseTypesAndStaff() {
        try {
            const [typesRes, staffRes] = await Promise.all([
                axios.get('/api/expense-type-list', HeaderToken()),
                axios.get('/api/staff-list', HeaderToken())
            ]);

            if (typesRes.data.status === 'success' || typesRes.data.ExpenseTypeData) {
                globalExpenseTypes = typesRes.data.ExpenseTypeData || [];
            }
            if (staffRes.data.status === 'success') {
                globalStaffList = staffRes.data.StaffData || [];
            }

            renderExpenseTypeCheckboxes();
        } catch (e) {
            console.error("Error loading expense types or staff:", e);
        }
    }

    let salaryRowCounters = {};

    function isSalaryTypeName(typeName) {
        if (!typeName) return false;
        const name = typeName.toLowerCase();
        const keywords = [
            'salary', 'sallery', 'salery', 'salari', 'salry', 'salaries',
            'payroll', 'wage', 'wages', 'honorarium'
        ];
        return keywords.some(k => name.includes(k));
    }

    function addSalaryRow(typeId) {
        if (!salaryRowCounters[typeId]) salaryRowCounters[typeId] = 1;
        const rowIndex = salaryRowCounters[typeId]++;

        const listContainer = document.getElementById(`salary-rows-list-${typeId}`);
        if (!listContainer) return;

        const rowDiv = document.createElement('div');
        rowDiv.className = 'row g-2 align-items-center salary-row mt-2 pt-2 border-t border-slate-200 dark:border-slate-800';
        rowDiv.id = `salary-row-${typeId}-${rowIndex}`;

        const staffOptionsHtml = globalStaffList.map(s => `<option value="${s.id}">${s.name} (${s.mobile || 'Staff'})</option>`).join('');

        rowDiv.innerHTML = `
            <div class="col-md-5">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success text-white fw-bold" type="button" onclick="addSalaryRow(${typeId})" title="Add more staff">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <select class="form-select staff-select" id="staff-${typeId}-${rowIndex}" style="height: 38px;">
                        <option value="">-- Select Staff --</option>
                        ${staffOptionsHtml}
                    </select>
                    <button class="btn btn-outline-primary" type="button" onclick="openStaffQuickModal()" title="Add New Staff">
                        <i class="fa-solid fa-user-plus"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <input type="number" step="any" class="form-control amount-input fw-bold text-rose-600" id="amount-${typeId}-${rowIndex}" placeholder="Amount (৳)" style="height: 38px;" />
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control details-input" id="details-${typeId}-${rowIndex}" placeholder="Monthly Salary / Advance" style="height: 38px;" />
            </div>
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-sm btn-outline-danger remove-salary-row-btn" onclick="removeSalaryRow(${typeId}, ${rowIndex})" title="Remove" style="height: 36px; width: 36px;">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        `;

        listContainer.appendChild(rowDiv);
        updateRemoveButtons(typeId);
    }

    function removeSalaryRow(typeId, rowIndex) {
        const row = document.getElementById(`salary-row-${typeId}-${rowIndex}`);
        if (row) row.remove();
        updateRemoveButtons(typeId);
    }

    function updateRemoveButtons(typeId) {
        const listContainer = document.getElementById(`salary-rows-list-${typeId}`);
        if (!listContainer) return;
        const rows = listContainer.querySelectorAll('.salary-row');
        rows.forEach(r => {
            const btn = r.querySelector('.remove-salary-row-btn');
            if (btn) {
                if (rows.length > 1) {
                    btn.classList.remove('d-none');
                } else {
                    btn.classList.add('d-none');
                }
            }
        });
    }

    function renderExpenseTypeCheckboxes() {
        const container = document.getElementById('ExpenseTypesContainer');
        if (!container) return;

        if (globalExpenseTypes.length === 0) {
            container.innerHTML = `<div class="text-slate-400 py-3 text-center">No expense types found. Click "+ Create New Type" above.</div>`;
            return;
        }

        let html = '';
        globalExpenseTypes.forEach(type => {
            const isSalary = isSalaryTypeName(type.type_name);
            
            html += `
                <div class="expense-item-card p-3 transition-all" id="type-row-${type.id}">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div class="form-check mb-0 d-flex align-items-center gap-2">
                            <input class="form-check-input type-checkbox m-0" type="checkbox" value="${type.id}" id="chk-${type.id}" onchange="toggleTypeInputs(${type.id})" style="transform: scale(1.2); cursor: pointer;" />
                            <label class="form-check-label fw-bold text-slate-800 dark:text-slate-100 mb-0" for="chk-${type.id}" style="cursor: pointer; font-size: 14px;">
                                ${type.type_name} ${isSalary ? '<span class="badge bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300 border border-indigo-200 dark:border-slate-800 ms-1" style="font-size: 10px;">👨‍💼 Staff Salary</span>' : ''}
                            </label>
                        </div>
                    </div>

                    <!-- Expandable Inputs when Checked -->
                    <div class="type-input-group mt-3 d-none pt-2 border-t border-slate-200 dark:border-slate-800" id="input-group-${type.id}">
                        ${isSalary ? `
                        <div class="salary-rows-wrapper" id="salary-wrapper-${type.id}">
                            <div class="salary-rows-list d-flex flex-column gap-2" id="salary-rows-list-${type.id}">
                                <div class="row g-2 align-items-center salary-row" id="salary-row-${type.id}-0">
                                    <div class="col-md-5">
                                        <label class="custom-modal-label">Select Staff <span class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <button class="btn btn-success text-white fw-bold" type="button" onclick="addSalaryRow(${type.id})" title="Add more staff">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <select class="form-select staff-select" id="staff-${type.id}-0" style="height: 38px;">
                                                <option value="">-- Select Staff --</option>
                                                ${globalStaffList.map(s => `<option value="${s.id}">${s.name} (${s.mobile || 'Staff'})</option>`).join('')}
                                            </select>
                                            <button class="btn btn-outline-primary" type="button" onclick="openStaffQuickModal()" title="Add New Staff">
                                                <i class="fa-solid fa-user-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="custom-modal-label">Amount (৳) <span class="text-danger">*</span></label>
                                        <input type="number" step="any" class="form-control amount-input fw-bold text-rose-600" id="amount-${type.id}-0" placeholder="0.00" style="height: 38px;" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="custom-modal-label">Details / Note</label>
                                        <input type="text" class="form-control details-input" id="details-${type.id}-0" placeholder="Monthly Salary / Advance" style="height: 38px;" />
                                    </div>
                                    <div class="col-md-1 text-end pt-3">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-salary-row-btn d-none" onclick="removeSalaryRow(${type.id}, 0)" title="Remove" style="height: 36px; width: 36px;">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2.5">
                                <button type="button" class="btn btn-sm btn-outline-success fw-bold px-3 py-1.5" onclick="addSalaryRow(${type.id})" style="border-radius: 8px;">
                                    <i class="fa-solid fa-plus-circle me-1"></i> + Add More Staff
                                </button>
                            </div>
                        </div>
                        ` : `
                        <div class="row g-2.5">
                            <div class="col-md-6 text-start">
                                <label class="custom-modal-label">Amount (৳) <span class="text-danger">*</span></label>
                                <input type="number" step="any" class="custom-modal-input amount-input fw-bold text-rose-600" id="amount-${type.id}" placeholder="0.00" style="height: 38px;" />
                            </div>
                            <div class="col-md-6 text-start">
                                <label class="custom-modal-label">Details / Note</label>
                                <input type="text" class="custom-modal-input details-input" id="details-${type.id}" placeholder="Enter expense details..." style="height: 38px;" />
                            </div>
                        </div>
                        `}
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
    }

    function toggleTypeInputs(typeId) {
        const chk = document.getElementById(`chk-${typeId}`);
        const group = document.getElementById(`input-group-${typeId}`);
        const row = document.getElementById(`type-row-${typeId}`);

        if (chk && chk.checked) {
            group.classList.remove('d-none');
            row.classList.add('is-checked');
        } else {
            group.classList.add('d-none');
            row.classList.remove('is-checked');
        }
    }

    async function saveExpenseType(event) {
        event.preventDefault();
        try {
            const expenseTypeName = document.getElementById('CreateExpenseTypeName').value.trim();
            const expenseStatus = document.getElementById('ExpenseSelectStatus').value;

            if (!expenseTypeName) {
                errorToast("Expense Type Name is required!");
                return;
            }

            const formData = new FormData();
            formData.append('type_name', expenseTypeName);
            formData.append('status', expenseStatus);

            const config = { headers: { 'Content-Type': 'multipart/form-data', ...HeaderToken().headers } };
            const res = await axios.post("/api/create-expense-type", formData, config);

            if (res.data.status === "success") {
                successToast(res.data.message);
                document.getElementById('CreateExpenseTypeName').value = '';
                closeBrandModal();
                await loadExpenseTypesAndStaff();
            } else {
                errorToast(res.data.message);
            }
        } catch (e) {
            unauthorized(e.response?.status || 500);
        }
    }

    async function saveQuickStaff(event) {
        event.preventDefault();
        try {
            const name = document.getElementById('QuickStaffName').value.trim();
            const mobile = document.getElementById('QuickStaffMobile').value.trim();
            const email = document.getElementById('QuickStaffEmail').value.trim();
            const role = document.getElementById('QuickStaffRole').value;

            if (!name || !mobile) {
                errorToast("Staff name and mobile number are required!");
                return;
            }

            const formData = new FormData();
            formData.append('name', name);
            formData.append('mobile', mobile);
            formData.append('email', email);
            formData.append('password', '123456');
            formData.append('role', role);
            formData.append('status', 'approved');

            const res = await axios.post('/create-user-admin', formData, HeaderToken());

            if (res.data.status === 'success') {
                successToast(res.data.message || "New staff added successfully!");
                document.getElementById('QuickStaffName').value = '';
                document.getElementById('QuickStaffMobile').value = '';
                document.getElementById('QuickStaffEmail').value = '';
                closeStaffQuickModal();
                await loadExpenseTypesAndStaff();
            } else {
                errorToast(res.data.message || "Failed to create staff");
            }
        } catch (e) {
            console.error("Staff save error:", e);
            errorToast(e.response?.data?.message || "Could not create staff");
        }
    }

    async function Save(event) {
        if (event && typeof event.preventDefault === 'function') event.preventDefault();
        try {
            const expenseDate = document.getElementById('ExpenseDate').value;
            if (!expenseDate) {
                errorToast("Date selection is required!");
                return false;
            }

            const checkedItems = [];
            const checkboxes = document.querySelectorAll('.type-checkbox:checked');

            if (checkboxes.length === 0) {
                errorToast("Please select at least one expense type!");
                return false;
            }

            let isValid = true;

            checkboxes.forEach(chk => {
                const typeId = chk.value;
                const salaryWrapper = document.getElementById(`salary-wrapper-${typeId}`);

                if (salaryWrapper) {
                    const rows = salaryWrapper.querySelectorAll('.salary-row');
                    rows.forEach(r => {
                        const staffEl = r.querySelector('.staff-select');
                        const amountEl = r.querySelector('.amount-input');
                        const detailsEl = r.querySelector('.details-input');

                        const amount = amountEl ? parseFloat(amountEl.value) : 0;
                        const details = detailsEl ? detailsEl.value.trim() : '';
                        const staffId = staffEl ? staffEl.value : null;

                        if (!amount || amount <= 0) {
                            errorToast("Please enter amount for the selected staff!");
                            isValid = false;
                            return;
                        }

                        if (!staffId) {
                            errorToast("Staff selection is required for salary!");
                            isValid = false;
                            return;
                        }

                        checkedItems.push({
                            expense_type_id: typeId,
                            staff_id: staffId,
                            expense_amount: amount,
                            expense_details: details,
                            date: expenseDate
                        });
                    });
                } else {
                    const amountEl = document.getElementById(`amount-${typeId}`);
                    const detailsEl = document.getElementById(`details-${typeId}`);

                    const amount = amountEl ? parseFloat(amountEl.value) : 0;
                    const details = detailsEl ? detailsEl.value.trim() : '';

                    if (!amount || amount <= 0) {
                        errorToast("Please enter amount for the selected expense!");
                        isValid = false;
                        return;
                    }

                    checkedItems.push({
                        expense_type_id: typeId,
                        staff_id: null,
                        expense_amount: amount,
                        expense_details: details,
                        date: expenseDate
                    });
                }
            });

            if (!isValid || checkedItems.length === 0) return false;

            showLoader();
            const payload = { items: checkedItems };
            const res = await axios.post("/api/create-expense", payload, HeaderToken());
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message);
                resetExpenseForm();
                closeExpenseModal();
                if (typeof getExpenseList === 'function') {
                    await getExpenseList();
                } else {
                    setTimeout(() => location.reload(), 500);
                }
            } else {
                errorToast(res.data.message || "An error occurred");
            }
        } catch (e) {
            hideLoader();
            console.error("Expense Save error:", e);
            errorToast("Failed to save expense!");
        }
    }

    function resetExpenseForm() {
        const form = document.getElementById('expenseForm');
        if (form) form.reset();

        salaryRowCounters = {};
        renderExpenseTypeCheckboxes();

        const today = new Date().toISOString().split('T')[0];
        if (window.expenseCreateFlatpickr) {
            window.expenseCreateFlatpickr.setDate(today, true);
        } else {
            const dateInput = document.getElementById('ExpenseDate');
            if (dateInput) dateInput.value = today;
        }
    }

    function openBrandModal() {
        $(document).off('focusin.bs.modal');
        const modal = document.getElementById('addBrandModal');
        if (modal) {
            modal.classList.add('show');
            modal.style.display = 'flex';
            modal.style.opacity = '1';
            modal.style.visibility = 'visible';
            modal.style.zIndex = '9999999';
            setTimeout(() => {
                const input = document.getElementById('CreateExpenseTypeName');
                if (input) {
                    input.focus();
                }
            }, 100);
        }
    }

    function closeBrandModal() {
        const modal = document.getElementById('addBrandModal');
        if (modal) {
            modal.classList.remove('show');
            modal.style.display = 'none';
            modal.style.opacity = '0';
            modal.style.visibility = 'hidden';
        }
    }

    function openStaffQuickModal() {
        $(document).off('focusin.bs.modal');
        const modal = document.getElementById('addStaffQuickModal');
        if (modal) {
            modal.classList.add('show');
            modal.style.display = 'flex';
            modal.style.opacity = '1';
            modal.style.visibility = 'visible';
            modal.style.zIndex = '9999999';
            setTimeout(() => {
                const input = document.getElementById('QuickStaffName');
                if (input) {
                    input.focus();
                }
            }, 100);
        }
    }

    function closeStaffQuickModal() {
        const modal = document.getElementById('addStaffQuickModal');
        if (modal) {
            modal.classList.remove('show');
            modal.style.display = 'none';
            modal.style.opacity = '0';
            modal.style.visibility = 'hidden';
        }
    }

    function initExpenseCreateDatepicker() {
        const dateInput = document.getElementById('ExpenseDate');
        if (dateInput && typeof flatpickr !== 'undefined') {
            if (window.expenseCreateFlatpickr) {
                window.expenseCreateFlatpickr.destroy();
            }
            window.expenseCreateFlatpickr = flatpickr(dateInput, {
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

    $(document).ready(function() {
        initExpenseCreateDatepicker();
    });

    // Re-init flatpickr every time the modal is fully shown (fixes positioning & mobile)
    $('#createExpenseModal').on('shown.bs.modal', function () {
        initExpenseCreateDatepicker();
    });

    function openExpenseModal() {
        const bsModal = document.getElementById('createExpenseModal');
        if (bsModal) {
            $('#createExpenseModal').modal('show');
            return;
        }
        const modalWrapper = document.getElementById('myModal');
        const modalSection = document.querySelector('.financemodal');
        if (modalWrapper) modalWrapper.style.display = 'block';
        if (modalSection) modalSection.style.display = 'block';
    }

    function closeExpenseModal() {
        $('#createExpenseModal').modal('hide');
        resetExpenseForm();
        const modalWrapper = document.getElementById('myModal');
        const modalSection = document.querySelector('.financemodal');
        if (modalWrapper) modalWrapper.style.display = 'none';
        if (modalSection) modalSection.style.display = 'none';
    }

    document.querySelector('.newbrand-open')?.addEventListener('click', openBrandModal);
    document.querySelector('.newbrand-close')?.addEventListener('click', closeBrandModal);
</script>
