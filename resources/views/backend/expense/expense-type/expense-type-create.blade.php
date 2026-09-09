<!-- Create Expense Type Modal Start -->
<div class="modal fade" id="createExpenseTypeModal" tabindex="-1" aria-labelledby="createExpenseTypeModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
            <!-- Sticky Top Green Header -->
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.2); color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            <line x1="12" y1="6" x2="12" y2="12"></line>
                            <line x1="9" y1="9" x2="15" y2="9"></line>
                        </svg>
                    </div>
                    <h5 class="modal-title m-0 text-white fw-bold" id="createExpenseTypeModalLabel" style="font-size: 16px; color: #ffffff !important;">Create Expense Type</h5>
                </div>
                <!-- Circular Red Close Button with White Icon -->
                <button type="button" class="custom-modal-close-btn d-flex align-items-center justify-content-center border-0 shadow-sm" data-bs-dismiss="modal" onclick="closeExpenseTypeModal()" aria-label="Close" style="position: relative !important; top: auto !important; right: auto !important; width: 26px !important; height: 26px !important; min-width: 26px !important; min-height: 26px !important; border-radius: 50% !important; background-color: #ef4444 !important; color: #ffffff !important; cursor: pointer !important; transition: all 0.2s ease; padding: 0 !important; margin: 0 !important; flex-shrink: 0 !important;" title="Close">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Scrollable Modal Body (ONLY between header and buttons, strictly left aligned) -->
            <div class="modal-body custom-scrollbar text-start" style="text-align: left !important;">
                <form onsubmit="return Save(event)" id="signup" class="text-start" style="text-align: left !important;">
                    <div class="row g-2.5 text-start" style="text-align: left !important;">
                        
                        <!-- Expense Type Name -->
                        <div class="col-12 text-start" style="text-align: left !important;">
                            <label for="ExpenseTypeName" class="custom-modal-label text-start" style="text-align: left !important;">Expense Type Name <span class="text-danger">*</span></label>
                            <input type="text" id="ExpenseTypeName" placeholder="Enter your Type name" required class="custom-modal-input text-start" style="text-align: left !important;" />
                        </div>

                        <!-- Status -->
                        <div class="col-12 text-start" style="text-align: left !important;">
                            <label for="SelectStatus" class="custom-modal-label text-start" style="text-align: left !important;">Status <span class="text-danger">*</span></label>
                            <select id="SelectStatus" required class="custom-modal-input text-start" style="text-align: left !important;">
                                <option value="">Select Status</option>
                                <option value="Active" selected>Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>

                    </div>
                </form>
            </div>

            <!-- Sticky Bottom Footer with Red Cancel & Green Save Buttons (Strict 38px height) -->
            <div class="modal-footer d-flex align-items-center justify-content-end gap-2 flex-shrink-0">
                <button type="button" onclick="closeExpenseTypeModal()" class="btn fw-semibold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important; cursor: pointer; transition: opacity 0.2s;">
                    Cancel
                </button>
                <button type="button" onclick="Save(event)" class="btn text-white fw-bold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; font-size: 13.5px !important; cursor: pointer;">
                    Submit
                </button>
            </div>

        </div>
    </div>
</div>
<!-- Create Expense Type Modal End -->

<style>
    #createExpenseTypeModal {
        overflow-y: hidden !important;
        padding-right: 0 !important;
    }
    #createExpenseTypeModal .modal-dialog {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        max-width: 520px !important;
        width: 95% !important;
        margin: 5vh auto !important;
        max-height: 90vh !important;
        height: auto !important;
        display: flex !important;
        align-items: center !important;
    }
    #createExpenseTypeModal .modal-content {
        border-radius: 16px !important;
        overflow: hidden !important;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        display: flex !important;
        flex-direction: column !important;
        max-height: 90vh !important;
    }

    #createExpenseTypeModal .modal-header {
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

    #createExpenseTypeModal .modal-body {
        padding: 16px 20px !important;
        overflow-y: auto !important;
        max-height: calc(90vh - 125px) !important;
        background-color: #ffffff !important;
        text-align: left !important;
    }

    #createExpenseTypeModal .modal-footer {
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
        margin-top: 10px !important;
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
    body[light-mode="dark"] #createExpenseTypeModal .modal-content,
    body[data-layout-mode="dark"] #createExpenseTypeModal .modal-content,
    html.dark #createExpenseTypeModal .modal-content,
    body.dark-mode #createExpenseTypeModal .modal-content,
    body.dark #createExpenseTypeModal .modal-content {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #createExpenseTypeModal .modal-body,
    body[data-layout-mode="dark"] #createExpenseTypeModal .modal-body,
    html.dark #createExpenseTypeModal .modal-body,
    body.dark-mode #createExpenseTypeModal .modal-body,
    body.dark #createExpenseTypeModal .modal-body {
        background-color: #0f172a !important;
    }
    body[light-mode="dark"] #createExpenseTypeModal .modal-footer,
    body[data-layout-mode="dark"] #createExpenseTypeModal .modal-footer,
    html.dark #createExpenseTypeModal .modal-footer,
    body.dark-mode #createExpenseTypeModal .modal-footer,
    body.dark #createExpenseTypeModal .modal-footer {
        background-color: #1e293b !important;
        border-top-color: #334155 !important;
    }
    body[light-mode="dark"] #createExpenseTypeModal .custom-modal-label,
    body[data-layout-mode="dark"] #createExpenseTypeModal .custom-modal-label,
    html.dark #createExpenseTypeModal .custom-modal-label,
    body.dark-mode #createExpenseTypeModal .custom-modal-label,
    body.dark #createExpenseTypeModal .custom-modal-label {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] #createExpenseTypeModal .custom-modal-input,
    body[data-layout-mode="dark"] #createExpenseTypeModal .custom-modal-input,
    html.dark #createExpenseTypeModal .custom-modal-input,
    body.dark-mode #createExpenseTypeModal .custom-modal-input,
    body.dark #createExpenseTypeModal .custom-modal-input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
</style>

<script>
    function closeExpenseTypeModal() {
        $('#createExpenseTypeModal').modal('hide');
        const legacyModal = document.getElementById('createProduct');
        if (legacyModal) legacyModal.style.display = 'none';
    }

    async function Save(event) {
        if (event && typeof event.preventDefault === 'function') event.preventDefault();

        try {
            let ExpenseTypeName = document.getElementById('ExpenseTypeName').value;
            let SelectStatus = document.getElementById('SelectStatus').value;

            if (ExpenseTypeName.trim().length === 0) {
                errorToast("Expense Type Name Required!");
                return false;
            } else if (SelectStatus === '' || SelectStatus === 'Select Status') {
                errorToast("Status Required!");
                return false;
            }

            let formData = new FormData();
            formData.append('type_name', ExpenseTypeName.trim());
            formData.append('status', SelectStatus);

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            showLoader();
            let res = await axios.post("/api/create-expense-type", formData, config);
            hideLoader();

            if (res.data['status'] === "success") {
                successToast(res.data['message']);
                document.getElementById("signup").reset();
                closeExpenseTypeModal();
                if (typeof getList === 'function') {
                    await getList();
                } else {
                    setTimeout(() => location.reload(), 500);
                }
            } else {
                errorToast(res.data['message']);
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }
</script>
