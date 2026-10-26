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
                            <span class="badge bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-300 dark:border-slate-800 px-2.5 py-1 fw-bold text-xs" id="selectedItemsCounter">
                                0 Selected
                            </span>
                        </div>

                        <div id="ExpenseTypesContainer">
                            <div class="text-center py-4 text-slate-400">
                                <i class="fa-solid fa-circle-notch fa-spin me-2"></i> Loading expense types...
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Sticky Bottom Footer with Red Cancel & Green Save Buttons (Strict 38px height) -->
            <div class="modal-footer d-flex align-items-center justify-content-end gap-2 flex-shrink-0">
                <button type="button" data-bs-dismiss="modal" onclick="closeExpenseModal()" class="btn fw-semibold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important; cursor: pointer; transition: opacity 0.2s;">
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

<!-- Item Expense Details Sub-Modal Start -->
<div class="newbrand" id="itemExpenseDetailsModal" style="z-index: 9999995;">
    <div class="newbrand-content shadow-lg border-0" style="border-radius: 16px; width: 95%; max-width: 580px; padding: 22px 24px;">
        <div class="d-flex align-items-center justify-content-between mb-3.5 pb-2 border-bottom border-slate-100 dark:border-slate-800">
            <h5 class="fw-bold text-slate-800 dark:text-slate-100 mb-0 d-flex align-items-center gap-2" style="font-size: 16px;">
                <i class="fa-solid fa-pen-to-square text-emerald-600"></i>
                <span id="itemDetailsModalTypeName">Expense Details</span>
            </h5>
            <button type="button" class="custom-modal-close-btn d-flex align-items-center justify-content-center border-0 shadow-sm" onclick="closeItemDetailsModal()" aria-label="Close" style="width: 26px !important; height: 26px !important; min-width: 26px !important; min-height: 26px !important; border-radius: 50% !important; background-color: #ef4444 !important; color: #ffffff !important; cursor: pointer !important; padding: 0 !important; margin: 0 !important;" title="Close">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <form id="itemDetailsForm" onsubmit="return saveItemDetailsModal(event)">
            <input type="hidden" id="modalActiveTypeId" value="" />

            <!-- General Expense Fields Container -->
            <div id="modalGeneralExpenseFields">
                <div class="row g-3 mb-3 text-start" style="text-align: left !important;">
                    <div class="col-12 col-md-6 text-start" style="text-align: left !important;">
                        <label for="modalExpenseAmount" class="custom-modal-label text-start">Amount (৳) <span class="text-danger">*</span></label>
                        <input type="number" step="any" min="0.01" id="modalExpenseAmount" class="custom-modal-input text-start fw-bold text-rose-600" placeholder="0.00" style="font-size: 15px;" />
                    </div>
                    <div class="col-12 col-md-6 text-start" style="text-align: left !important;">
                        <label for="modalExpenseDetails" class="custom-modal-label text-start">Details / Note</label>
                        <input type="text" id="modalExpenseDetails" class="custom-modal-input text-start" placeholder="Enter expense details..." />
                    </div>
                </div>
            </div>

            <!-- Salary Expense Fields Container -->
            <div id="modalSalaryExpenseFields" class="d-none">
                <!-- Row 1: Select Staff (1 row full width) -->
                <div class="row g-2.5 mb-2.5 text-start" style="text-align: left !important;">
                    <div class="col-12 text-start" style="text-align: left !important;">
                        <label for="modalSalaryStaff" class="custom-modal-label text-start" style="text-align: left !important;">Select Staff <span class="text-danger">*</span></label>
                        <select id="modalSalaryStaff" class="custom-modal-input text-start" style="text-align: left !important; cursor: pointer;">
                            <option value="">-- Select Staff --</option>
                        </select>
                    </div>
                </div>
                <!-- Row 2: Amount & Details / Note (1 row 2 columns) -->
                <div class="row g-2.5 mb-3 text-start" style="text-align: left !important;">
                    <div class="col-6 text-start" style="text-align: left !important;">
                        <label for="modalSalaryAmount" class="custom-modal-label text-start" style="text-align: left !important;">Amount (৳) <span class="text-danger">*</span></label>
                        <input type="number" step="any" min="0.01" id="modalSalaryAmount" class="custom-modal-input text-start fw-bold text-rose-600" placeholder="0.00" style="font-size: 15px; text-align: left !important;" />
                    </div>
                    <div class="col-6 text-start" style="text-align: left !important;">
                        <label for="modalSalaryDetails" class="custom-modal-label text-start" style="text-align: left !important;">Details / Note</label>
                        <input type="text" id="modalSalaryDetails" class="custom-modal-input text-start" placeholder="Monthly Salary" style="text-align: left !important;" />
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="d-flex justify-content-end gap-2 pt-2 border-top border-slate-100 dark:border-slate-800">
                <button type="button" class="btn text-white px-4 fw-semibold shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; border: none !important; cursor: pointer;" onclick="closeItemDetailsModal()">Cancel</button>
                <button type="submit" class="btn text-white px-4 fw-bold shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; cursor: pointer;">Save Details</button>
            </div>
        </form>
    </div>
</div>
<!-- Item Expense Details Sub-Modal End -->

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
        display: none;
        position: fixed !important;
        inset: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        background: rgba(15, 23, 42, 0.65) !important;
        backdrop-filter: blur(4px) !important;
        -webkit-backdrop-filter: blur(4px) !important;
        z-index: 9999995 !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 16px !important;
        pointer-events: auto !important;
    }
    .newbrand.show,
    .newbrand[style*="display: flex"] {
        display: flex !important;
    }
    #addBrandModal, #addStaffQuickModal {
        z-index: 9999999 !important;
    }
    #itemExpenseDetailsModal {
        z-index: 9999995 !important;
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

    .expense-types-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 8px;
    }
    @media (min-width: 640px) {
        .expense-types-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
    }
    .available-expense-card {
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        background-color: #ffffff;
        padding: 7px 10px;
        transition: all 0.15s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        min-height: 38px;
        cursor: pointer;
        user-select: none;
    }
    .available-expense-card:hover {
        border-color: #10b981 !important;
        background-color: #f0fdf4 !important;
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(16, 185, 129, 0.12);
    }
    .available-expense-card .click-indicator-icon {
        color: #10b981;
        font-size: 11px;
        opacity: 0.8;
        transition: all 0.15s ease;
    }
    .available-expense-card:hover .click-indicator-icon {
        opacity: 1;
        transform: scale(1.15);
    }

    .selected-expense-item {
        border: 1.5px solid #10b981 !important;
        border-radius: 10px;
        background-color: #f0fdf4 !important;
        padding: 8px 12px;
        transition: all 0.15s ease;
        box-shadow: 0 1px 3px rgba(16, 185, 129, 0.1);
        cursor: pointer;
    }
    .selected-expense-item:hover {
        background-color: #dcfce7 !important;
        box-shadow: 0 3px 8px rgba(16, 185, 129, 0.18);
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

    body[data-layout-mode="dark"] .available-expense-card,
    body[light-mode="dark"] .available-expense-card,
    html.dark .available-expense-card,
    body.dark-mode .available-expense-card,
    body.dark .available-expense-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[data-layout-mode="dark"] .available-expense-card:hover,
    body[light-mode="dark"] .available-expense-card:hover,
    html.dark .available-expense-card:hover,
    body.dark-mode .available-expense-card:hover,
    body.dark .available-expense-card:hover {
        background-color: rgba(16, 185, 129, 0.15) !important;
        border-color: #10b981 !important;
    }
    body[data-layout-mode="dark"] .available-expense-card span,
    body[light-mode="dark"] .available-expense-card span,
    html.dark .available-expense-card span {
        color: #f8fafc !important;
    }

    body[data-layout-mode="dark"] .selected-expense-item,
    body[light-mode="dark"] .selected-expense-item,
    html.dark .selected-expense-item,
    body.dark-mode .selected-expense-item,
    body.dark .selected-expense-item {
        background-color: rgba(6, 78, 59, 0.25) !important;
        border-color: #10b981 !important;
    }
    body[data-layout-mode="dark"] .selected-expense-item:hover,
    body[light-mode="dark"] .selected-expense-item:hover,
    html.dark .selected-expense-item:hover {
        background-color: rgba(6, 78, 59, 0.4) !important;
    }

    /* Staff Tag Badge styling with Dark Mode support (prevents white tag in dark mode) */
    .staff-tag-badge {
        font-size: 9px !important;
        font-weight: 700 !important;
        padding: 2px 6px !important;
        border-radius: 6px !important;
        background-color: #eef2ff !important;
        color: #4338ca !important;
        border: 1px solid #c7d2fe !important;
        display: inline-flex !important;
        align-items: center !important;
        line-height: normal !important;
    }
    body[data-layout-mode="dark"] .staff-tag-badge,
    body[light-mode="dark"] .staff-tag-badge,
    html.dark .staff-tag-badge,
    body.dark-mode .staff-tag-badge,
    body.dark .staff-tag-badge {
        background-color: rgba(99, 102, 241, 0.22) !important;
        color: #a5b4fc !important;
        border-color: rgba(99, 102, 241, 0.45) !important;
    }
    body[data-layout-mode="dark"] .available-expense-card .badge,
    body[light-mode="dark"] .available-expense-card .badge,
    html.dark .available-expense-card .badge,
    body.dark-mode .available-expense-card .badge,
    body.dark .available-expense-card .badge,
    body[data-layout-mode="dark"] .selected-expense-item .badge,
    body[light-mode="dark"] .selected-expense-item .badge,
    html.dark .selected-expense-item .badge,
    body.dark-mode .selected-expense-item .badge,
    body.dark .selected-expense-item .badge {
        background-color: rgba(99, 102, 241, 0.22) !important;
        color: #a5b4fc !important;
        border-color: rgba(99, 102, 241, 0.45) !important;
    }

    body[data-layout-mode="dark"] .modal-salary-row,
    body[light-mode="dark"] .modal-salary-row,
    html.dark .modal-salary-row {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    /* Custom Search Filter Dropdown (Select2) in Item Expense Details Modal */
    #itemExpenseDetailsModal .select2-container {
        width: 100% !important;
        display: block !important;
    }
    #itemExpenseDetailsModal .select2-container--default .select2-selection--single {
        height: 42px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 8px !important;
        display: flex !important;
        align-items: center !important;
        padding: 0 10px !important;
        background-color: #ffffff !important;
        transition: border-color 0.15s ease, box-shadow 0.15s ease !important;
    }
    #itemExpenseDetailsModal .select2-container--default .select2-selection--single:focus,
    #itemExpenseDetailsModal .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.2) !important;
    }
    #itemExpenseDetailsModal .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px !important;
        color: #0f172a !important;
        font-size: 13.5px !important;
        font-weight: 500 !important;
        padding-left: 2px !important;
        padding-right: 20px !important;
    }
    #itemExpenseDetailsModal .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #94a3b8 !important;
    }
    #itemExpenseDetailsModal .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
        right: 10px !important;
    }
    .select2-dropdown {
        z-index: 9999999 !important;
        border-radius: 10px !important;
        border: 1.5px solid #cbd5e1 !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15) !important;
        overflow: hidden !important;
        background-color: #ffffff !important;
    }
    .select2-container--default .select2-search--dropdown {
        padding: 8px 10px !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 6px !important;
        padding: 6px 12px !important;
        outline: none !important;
        font-size: 13px !important;
        width: 100% !important;
        color: #0f172a !important;
        background-color: #ffffff !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 2px rgba(21, 128, 61, 0.2) !important;
    }
    .select2-container--default .select2-results__option {
        padding: 8px 12px !important;
        font-size: 13px !important;
        color: #334155 !important;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #15803d !important;
        color: #ffffff !important;
    }
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #ecfdf5 !important;
        color: #065f46 !important;
        font-weight: 600 !important;
    }

    /* Dark Mode Select2 Styles */
    body[light-mode="dark"] #itemExpenseDetailsModal .select2-container--default .select2-selection--single,
    html.dark #itemExpenseDetailsModal .select2-container--default .select2-selection--single,
    body[data-layout-mode="dark"] #itemExpenseDetailsModal .select2-container--default .select2-selection--single,
    body.dark #itemExpenseDetailsModal .select2-container--default .select2-selection--single {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #itemExpenseDetailsModal .select2-container--default .select2-selection--single .select2-selection__rendered,
    html.dark #itemExpenseDetailsModal .select2-container--default .select2-selection--single .select2-selection__rendered,
    body[data-layout-mode="dark"] #itemExpenseDetailsModal .select2-container--default .select2-selection--single .select2-selection__rendered,
    body.dark #itemExpenseDetailsModal .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .select2-dropdown,
    html.dark .select2-dropdown,
    body[data-layout-mode="dark"] .select2-dropdown,
    body.dark .select2-dropdown {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .select2-container--default .select2-search--dropdown .select2-search__field,
    html.dark .select2-container--default .select2-search--dropdown .select2-search__field,
    body[data-layout-mode="dark"] .select2-container--default .select2-search--dropdown .select2-search__field,
    body.dark .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .select2-container--default .select2-results__option,
    html.dark .select2-container--default .select2-results__option,
    body[data-layout-mode="dark"] .select2-container--default .select2-results__option,
    body.dark .select2-container--default .select2-results__option {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .select2-container--default .select2-results__option[aria-selected=true],
    html.dark .select2-container--default .select2-results__option[aria-selected=true],
    body[data-layout-mode="dark"] .select2-container--default .select2-results__option[aria-selected=true],
    body.dark .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: rgba(16, 185, 129, 0.2) !important;
        color: #34d399 !important;
    }
    body[light-mode="dark"] .select2-container--default .select2-results__option--highlighted[aria-selected],
    html.dark .select2-container--default .select2-results__option--highlighted[aria-selected],
    body[data-layout-mode="dark"] .select2-container--default .select2-results__option--highlighted[aria-selected],
    body.dark .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #15803d !important;
        color: #ffffff !important;
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
    let selectedExpenseData = {}; // keyed by type_id: { type_id, type_name, is_salary, amount, details, is_saved, staff_rows: [] }
    let activeEditingTypeId = null;

    function formatBdCurrencyHelper(num) {
        let n = parseFloat(num) || 0;
        return n.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

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

    function isSalaryTypeName(typeName) {
        if (!typeName) return false;
        const name = typeName.toLowerCase();
        const keywords = [
            'salary', 'sallery', 'salery', 'salari', 'salry', 'salaries',
            'payroll', 'wage', 'wages', 'honorarium', 'বেতন', 'সেলারী', 'স্যালারি'
        ];
        return keywords.some(k => name.includes(k));
    }

    function renderExpenseTypeCheckboxes() {
        const container = document.getElementById('ExpenseTypesContainer');
        if (!container) return;

        if (globalExpenseTypes.length === 0) {
            container.innerHTML = `<div class="text-slate-400 py-3 text-center">No expense types found. Click "+ Create New Type" above.</div>`;
            return;
        }

        const selectedKeys = Object.keys(selectedExpenseData).filter(k => selectedExpenseData[k] && selectedExpenseData[k].is_saved);
        const counterBadge = document.getElementById('selectedItemsCounter');
        if (counterBadge) {
            counterBadge.innerText = `${selectedKeys.length} Selected`;
        }

        let selectedHtml = '';
        if (selectedKeys.length > 0) {
            selectedHtml += `
                <div class="selected-expenses-section mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-xs fw-bold text-emerald-700 dark:text-emerald-400 text-uppercase tracking-wider">
                            <i class="fa-solid fa-circle-check me-1"></i> Selected Items (${selectedKeys.length}):
                        </span>
                        <small class="text-slate-400 text-xs">
                            <i class="fa-solid fa-pen text-emerald-600 me-1"></i> Click card to edit amount/details
                        </small>
                    </div>
                    <div class="d-flex flex-column gap-2">
            `;

            selectedKeys.forEach(typeId => {
                const item = selectedExpenseData[typeId];
                let summaryText = '';
                let totalAmount = 0;

                if (item.is_salary) {
                    const st = globalStaffList.find(s => s.id == (item.staff_id || (item.staff_rows && item.staff_rows[0]?.staff_id)));
                    const staffName = st ? st.name : (item.staff_name || 'Staff');
                    totalAmount = parseFloat(item.amount) || 0;
                    summaryText = `Staff: ${staffName}${item.details ? ' • Note: ' + item.details : ''}`;
                } else {
                    totalAmount = parseFloat(item.amount) || 0;
                    summaryText = item.details ? `Note: ${item.details}` : 'No details entered';
                }

                selectedHtml += `
                    <div class="selected-expense-item" onclick="openItemDetailsModal(${item.type_id})">
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <div class="d-flex align-items-center gap-2.5 flex-grow-1 min-w-0">
                                <span class="d-flex align-items-center justify-content-center rounded-circle bg-emerald-600 text-white flex-shrink-0" style="width: 24px; height: 24px; font-size: 11px;">
                                    <i class="fa-solid fa-check"></i>
                                </span>
                                <div class="min-w-0">
                                    <div class="d-flex align-items-center gap-1.5 flex-wrap">
                                        <span class="fw-bold text-slate-800 dark:text-slate-100 text-sm">${item.type_name}</span>
                                        ${item.is_salary ? '<span class="staff-tag-badge">👨‍💼 Staff Salary</span>' : ''}
                                    </div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400 text-truncate" style="max-width: 320px;">
                                        ${summaryText}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-shrink-0" onclick="event.stopPropagation()">
                                <span class="badge bg-white dark:bg-slate-800 text-rose-600 dark:text-rose-400 border border-slate-200 dark:border-slate-700 fw-bold px-2.5 py-1.5 text-xs shadow-xs">
                                    ৳ ${formatBdCurrencyHelper(totalAmount)}
                                </span>
                                <button type="button" class="btn btn-sm btn-outline-success d-inline-flex align-items-center justify-content-center p-0 rounded-circle" style="width: 28px; height: 28px;" title="Click to Edit" onclick="openItemDetailsModal(${item.type_id})">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center justify-content-center p-0 rounded-circle" style="width: 28px; height: 28px;" title="Remove / Unselect" onclick="unselectExpenseItem(${item.type_id})">
                                    <i class="fa-solid fa-xmark text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });

            selectedHtml += `
                    </div>
                </div>
            `;
        }

        // Available items — All types always remain visible (never blank / empty)
        let availableHtml = `
            <div class="available-expenses-section">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-xs fw-bold text-slate-600 dark:text-slate-400 text-uppercase tracking-wider">
                        Available Expense Types:
                    </span>
                    <small class="text-slate-400 text-xs">
                        <i class="fa-solid fa-arrow-pointer text-emerald-600 me-1"></i> Click card to enter amount
                    </small>
                </div>
                <div class="expense-types-grid">
        `;

        if (globalExpenseTypes.length === 0) {
            availableHtml += `<div class="text-slate-400 py-2 text-center text-xs" style="grid-column: 1 / -1;">No expense types found. Click "+ Create New Type" above.</div>`;
        } else {
            globalExpenseTypes.forEach(type => {
                const isSalary = isSalaryTypeName(type.type_name);
                const isSelected = selectedKeys.includes(String(type.id));
                const activeCardClass = isSelected ? 'border-emerald-500 bg-emerald-50/70 dark:bg-emerald-950/30 dark:border-emerald-600/60' : '';
                const checkIcon = isSelected 
                    ? `<i class="fa-solid fa-square-check text-emerald-600 dark:text-emerald-400 text-xs flex-shrink-0"></i>`
                    : `<i class="fa-regular fa-square text-slate-400 text-xs flex-shrink-0"></i>`;

                availableHtml += `
                    <div class="available-expense-card ${activeCardClass}" onclick="selectAndOpenItemModal(${type.id})" title="${isSelected ? 'Click to edit amount' : 'Click to select and enter amount'}">
                        <div class="d-flex align-items-center gap-2 min-w-0">
                            ${checkIcon}
                            <span class="text-slate-700 dark:text-slate-200 fw-semibold text-xs text-truncate">
                                ${type.type_name}
                            </span>
                            ${isSalary ? '<span class="staff-tag-badge">Staff</span>' : ''}
                        </div>
                        <span class="click-indicator-icon flex-shrink-0" title="${isSelected ? 'Edit' : 'Select'}">
                            <i class="${isSelected ? 'fa-solid fa-pen' : 'fa-solid fa-arrow-up-right-from-square'}"></i>
                        </span>
                    </div>
                `;
            });
        }

        availableHtml += `
                </div>
            </div>
        `;

        container.innerHTML = selectedHtml + availableHtml;
    }

    function selectAndOpenItemModal(typeId) {
        const typeObj = globalExpenseTypes.find(t => t.id == typeId);
        if (!typeObj) return;

        const isSalary = isSalaryTypeName(typeObj.type_name);
        if (!selectedExpenseData[typeId]) {
            selectedExpenseData[typeId] = {
                type_id: typeId,
                type_name: typeObj.type_name,
                is_salary: isSalary,
                staff_id: '',
                amount: '',
                details: '',
                is_saved: false
            };
        }
        openItemDetailsModal(typeId);
    }

    function openItemDetailsModal(typeId) {
        const typeObj = globalExpenseTypes.find(t => t.id == typeId);
        if (!typeObj) return;

        activeEditingTypeId = typeId;
        const isSalary = isSalaryTypeName(typeObj.type_name);

        if (!selectedExpenseData[typeId]) {
            selectedExpenseData[typeId] = {
                type_id: typeId,
                type_name: typeObj.type_name,
                is_salary: isSalary,
                staff_id: '',
                amount: '',
                details: '',
                is_saved: false
            };
        }

        const item = selectedExpenseData[typeId];

        const titleEl = document.getElementById('itemDetailsModalTypeName');
        if (titleEl) {
            titleEl.innerHTML = `<span class="text-emerald-600 dark:text-emerald-400">${item.type_name}</span> - Details`;
        }

        const activeInput = document.getElementById('modalActiveTypeId');
        if (activeInput) activeInput.value = typeId;

        const genContainer = document.getElementById('modalGeneralExpenseFields');
        const salContainer = document.getElementById('modalSalaryExpenseFields');

        if (isSalary) {
            if (genContainer) genContainer.classList.add('d-none');
            if (salContainer) salContainer.classList.remove('d-none');

            // Populate Staff Dropdown with Select2
            const staffSelect = $('#modalSalaryStaff');
            if (staffSelect.length) {
                if (staffSelect.data('select2')) {
                    staffSelect.select2('destroy');
                }
                const currentStaffId = item.staff_id || (item.staff_rows && item.staff_rows[0]?.staff_id) || '';
                let optionsHtml = '<option value="">-- Select Staff --</option>' + globalStaffList.map(s => 
                    `<option value="${s.id}" ${currentStaffId == s.id ? 'selected' : ''}>${s.name} (${s.mobile || 'Staff'})</option>`
                ).join('');
                staffSelect.html(optionsHtml);
                if (typeof $.fn.select2 !== 'undefined') {
                    staffSelect.select2({
                        dropdownParent: $('#itemExpenseDetailsModal'),
                        placeholder: '-- Select Staff --',
                        width: '100%',
                        allowClear: false
                    });
                }
                if (currentStaffId) {
                    staffSelect.val(currentStaffId).trigger('change.select2');
                }
            }

            const salAmt = document.getElementById('modalSalaryAmount');
            const salDet = document.getElementById('modalSalaryDetails');
            if (salAmt) salAmt.value = item.amount || (item.staff_rows && item.staff_rows[0]?.amount) || '';
            if (salDet) salDet.value = item.details || (item.staff_rows && item.staff_rows[0]?.details) || '';
        } else {
            if (genContainer) genContainer.classList.remove('d-none');
            if (salContainer) salContainer.classList.add('d-none');

            const amtInput = document.getElementById('modalExpenseAmount');
            const detInput = document.getElementById('modalExpenseDetails');
            if (amtInput) amtInput.value = item.amount || '';
            if (detInput) detInput.value = item.details || '';
        }

        const modal = document.getElementById('itemExpenseDetailsModal');
        if (modal) {
            modal.classList.add('show');
            modal.style.display = 'flex';
            modal.style.opacity = '1';
            modal.style.visibility = 'visible';
            modal.style.zIndex = '9999995';

            setTimeout(() => {
                if (isSalary) {
                    const staffVal = $('#modalSalaryStaff').val();
                    if (!staffVal && typeof $.fn.select2 !== 'undefined') {
                        $('#modalSalaryStaff').select2('open');
                    } else {
                        const salAmt = document.getElementById('modalSalaryAmount');
                        if (salAmt) salAmt.focus();
                    }
                } else {
                    const amtInput = document.getElementById('modalExpenseAmount');
                    if (amtInput) amtInput.focus();
                }
            }, 100);
        }
    }

    function refreshModalStaffDropdowns() {
        if (activeEditingTypeId && selectedExpenseData[activeEditingTypeId]?.is_salary) {
            const staffSelect = $('#modalSalaryStaff');
            if (staffSelect.length) {
                const curVal = staffSelect.val();
                if (staffSelect.data('select2')) {
                    staffSelect.select2('destroy');
                }
                staffSelect.html('<option value="">-- Select Staff --</option>' + globalStaffList.map(s => 
                    `<option value="${s.id}" ${curVal == s.id ? 'selected' : ''}>${s.name} (${s.mobile || 'Staff'})</option>`
                ).join(''));
                if (typeof $.fn.select2 !== 'undefined') {
                    staffSelect.select2({
                        dropdownParent: $('#itemExpenseDetailsModal'),
                        placeholder: '-- Select Staff --',
                        width: '100%',
                        allowClear: false
                    });
                }
                if (curVal) {
                    staffSelect.val(curVal).trigger('change.select2');
                }
            }
        }
    }

    function saveItemDetailsModal(event) {
        if (event && typeof event.preventDefault === 'function') event.preventDefault();
        if (!activeEditingTypeId || !selectedExpenseData[activeEditingTypeId]) return false;

        const item = selectedExpenseData[activeEditingTypeId];

        if (item.is_salary) {
            const staffId = $('#modalSalaryStaff').val() || '';
            const amtInput = document.getElementById('modalSalaryAmount');
            const detInput = document.getElementById('modalSalaryDetails');

            const amt = parseFloat(amtInput ? amtInput.value : 0);
            const details = detInput ? detInput.value.trim() : '';

            if (!staffId) {
                errorToast("Please select staff!");
                if (typeof $.fn.select2 !== 'undefined') $('#modalSalaryStaff').select2('open');
                return false;
            }
            if (isNaN(amt) || amt <= 0) {
                errorToast("Please enter a valid salary amount!");
                if (amtInput) amtInput.focus();
                return false;
            }

            const staffObj = globalStaffList.find(s => s.id == staffId);
            item.staff_id = staffId;
            item.staff_name = staffObj ? staffObj.name : 'Staff';
            item.amount = amt;
            item.details = details;
            item.staff_rows = [{ staff_id: staffId, amount: amt, details: details }];
            item.is_saved = true;
        } else {
            const amtInput = document.getElementById('modalExpenseAmount');
            const detInput = document.getElementById('modalExpenseDetails');

            const amt = parseFloat(amtInput ? amtInput.value : 0);
            const details = detInput ? detInput.value.trim() : '';

            if (isNaN(amt) || amt <= 0) {
                errorToast("Please enter a valid expense amount!");
                if (amtInput) amtInput.focus();
                return false;
            }

            item.amount = amt;
            item.details = details;
            item.is_saved = true;
        }

        closeItemDetailsModal(true);
        renderExpenseTypeCheckboxes();
        return false;
    }

    function closeItemDetailsModal(saved = false) {
        if (!saved && activeEditingTypeId && selectedExpenseData[activeEditingTypeId]) {
            if (!selectedExpenseData[activeEditingTypeId].is_saved) {
                delete selectedExpenseData[activeEditingTypeId];
            }
        }

        if (typeof $.fn.select2 !== 'undefined' && $('#modalSalaryStaff').data('select2')) {
            $('#modalSalaryStaff').select2('close');
        }

        const modal = document.getElementById('itemExpenseDetailsModal');
        if (modal) {
            modal.classList.remove('show');
            modal.style.display = 'none';
            modal.style.opacity = '0';
            modal.style.visibility = 'hidden';
        }

        activeEditingTypeId = null;
        renderExpenseTypeCheckboxes();
    }

    function unselectExpenseItem(typeId) {
        if (selectedExpenseData[typeId]) {
            delete selectedExpenseData[typeId];
            renderExpenseTypeCheckboxes();
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
                refreshModalStaffDropdowns();
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

            const selectedKeys = Object.keys(selectedExpenseData).filter(k => selectedExpenseData[k] && selectedExpenseData[k].is_saved);
            if (selectedKeys.length === 0) {
                errorToast("Please select at least one expense type and enter amount!");
                return false;
            }

            const checkedItems = [];
            let isValid = true;

            for (const typeId of selectedKeys) {
                const item = selectedExpenseData[typeId];
                if (item.is_salary) {
                    const staffId = item.staff_id || (item.staff_rows && item.staff_rows[0]?.staff_id);
                    const amt = parseFloat(item.amount || (item.staff_rows && item.staff_rows[0]?.amount));
                    const details = item.details || (item.staff_rows && item.staff_rows[0]?.details) || '';

                    if (!staffId) {
                        errorToast(`Staff selection is required for ${item.type_name}!`);
                        isValid = false;
                        break;
                    }
                    if (isNaN(amt) || amt <= 0) {
                        errorToast(`Please enter valid amount for ${item.type_name}!`);
                        isValid = false;
                        break;
                    }
                    checkedItems.push({
                        expense_type_id: typeId,
                        staff_id: staffId,
                        expense_amount: amt,
                        expense_details: details,
                        date: expenseDate
                    });
                } else {
                    const amount = parseFloat(item.amount);
                    if (isNaN(amount) || amount <= 0) {
                        errorToast(`Please enter amount for ${item.type_name}!`);
                        isValid = false;
                        break;
                    }
                    checkedItems.push({
                        expense_type_id: typeId,
                        staff_id: null,
                        expense_amount: amount,
                        expense_details: item.details || '',
                        date: expenseDate
                    });
                }
            }

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

        selectedExpenseData = {};
        activeEditingTypeId = null;
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
        if (typeof $ !== 'undefined') $(document).off('focusin.bs.modal');
        const modal = document.getElementById('addBrandModal');
        if (modal) {
            modal.classList.add('show');
            modal.style.display = 'flex';
            modal.style.opacity = '1';
            modal.style.visibility = 'visible';
            modal.style.zIndex = '9999999';
            setTimeout(() => {
                const input = document.getElementById('CreateExpenseTypeName');
                if (input) input.focus();
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
        if (typeof $ !== 'undefined') $(document).off('focusin.bs.modal');
        const modal = document.getElementById('addStaffQuickModal');
        if (modal) {
            modal.classList.add('show');
            modal.style.display = 'flex';
            modal.style.opacity = '1';
            modal.style.visibility = 'visible';
            modal.style.zIndex = '9999999';
            setTimeout(() => {
                const input = document.getElementById('QuickStaffName');
                if (input) input.focus();
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
        if (!dateInput) return;
        const today = new Date().toISOString().split('T')[0];
        if (!dateInput.value) {
            dateInput.value = today;
        }
        if (typeof flatpickr !== 'undefined') {
            try {
                if (window.expenseCreateFlatpickr) {
                    window.expenseCreateFlatpickr.destroy();
                }
                window.expenseCreateFlatpickr = flatpickr(dateInput, {
                    dateFormat: "Y-m-d",
                    defaultDate: dateInput.value || today,
                    allowInput: true,
                    clickOpens: true,
                    disableMobile: true,
                    onOpen: function() {
                        if (typeof $ !== 'undefined') $(document).off('focusin.bs.modal');
                    }
                });
            } catch (err) {
                console.warn("Flatpickr init error:", err);
            }
        }
    }

    $(document).ready(function() {
        initExpenseCreateDatepicker();
        loadExpenseTypesAndStaff();
    });

    $('#createExpenseModal').on('shown.bs.modal', function () {
        initExpenseCreateDatepicker();
        if (globalExpenseTypes.length === 0) {
            loadExpenseTypesAndStaff();
        }
    });

    function openExpenseModal() {
        const dateInput = document.getElementById('ExpenseDate');
        const today = new Date().toISOString().split('T')[0];
        if (dateInput && !dateInput.value) {
            dateInput.value = today;
        }
        initExpenseCreateDatepicker();

        if (globalExpenseTypes.length === 0) {
            loadExpenseTypesAndStaff();
        }

        const modalEl = document.getElementById('createExpenseModal');
        if (modalEl) {
            try {
                let modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modalInstance.show();
                return;
            } catch (e) {
                if (typeof $ !== 'undefined') $('#createExpenseModal').modal('show');
            }
        }
        const modalWrapper = document.getElementById('myModal');
        const modalSection = document.querySelector('.financemodal');
        if (modalWrapper) modalWrapper.style.display = 'block';
        if (modalSection) modalSection.style.display = 'block';
    }

    function closeExpenseModal() {
        try {
            const modalEl = document.getElementById('createExpenseModal');
            if (modalEl) {
                let modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
            }
        } catch (e) {
            console.warn("Bootstrap modal hide error:", e);
        }
        if (typeof $ !== 'undefined') {
            $('#createExpenseModal').modal('hide');
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css({ 'overflow': '', 'padding-right': '' });
        }
        resetExpenseForm();
        const modalWrapper = document.getElementById('myModal');
        const modalSection = document.querySelector('.financemodal');
        if (modalWrapper) modalWrapper.style.display = 'none';
        if (modalSection) modalSection.style.display = 'none';
    }

    document.querySelector('.newbrand-open')?.addEventListener('click', openBrandModal);
    document.querySelector('.newbrand-close')?.addEventListener('click', closeBrandModal);
</script>
