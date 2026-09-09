<!-- Expense Type Edit Modal Start -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
            <!-- Sticky Top Green Header -->
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.2); color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                            <path d="M12 20h9"></path>
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                        </svg>
                    </div>
                    <h5 class="modal-title m-0 text-white fw-bold" id="exampleModalLabel" style="font-size: 16px; color: #ffffff !important;">Update Expense Type</h5>
                </div>
                <!-- Circular Red Close Button with White Icon -->
                <button type="button" class="custom-modal-close-btn d-flex align-items-center justify-content-center border-0 shadow-sm" data-bs-dismiss="modal" aria-label="Close" style="position: relative !important; top: auto !important; right: auto !important; width: 26px !important; height: 26px !important; min-width: 26px !important; min-height: 26px !important; border-radius: 50% !important; background-color: #ef4444 !important; color: #ffffff !important; cursor: pointer !important; transition: all 0.2s ease; padding: 0 !important; margin: 0 !important; flex-shrink: 0 !important;" title="Close">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Scrollable Modal Body (strictly left aligned) -->
            <div class="modal-body custom-scrollbar text-start" style="text-align: left !important;">
                <form id="updateForm" class="text-start" style="text-align: left !important;">
                    <div class="row g-2.5 text-start" style="text-align: left !important;">
                        
                        <!-- Expense Type Name -->
                        <div class="col-12 text-start" style="text-align: left !important;">
                            <label for="UpdateExpenseTypeName" class="custom-modal-label text-start" style="text-align: left !important;">Expense Type Name <span class="text-danger">*</span></label>
                            <input type="text" placeholder="Update Expense Type Name *" id="UpdateExpenseTypeName" required class="custom-modal-input text-start" style="text-align: left !important;" />
                        </div>

                        <!-- Status -->
                        <div class="col-12 text-start" style="text-align: left !important;">
                            <label for="UpdateSelectStatus" class="custom-modal-label text-start" style="text-align: left !important;">Status <span class="text-danger">*</span></label>
                            <select id="UpdateSelectStatus" required class="custom-modal-input text-start" style="text-align: left !important;">
                                <option value="" disabled>Select Expense Type status</option>
                                <option value="Active">Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                            <input type="hidden" id="updateID">
                        </div>

                    </div>
                </form>
            </div>

            <!-- Sticky Bottom Footer with Red Cancel & Green Update Buttons (Strict 38px height) -->
            <div class="modal-footer d-flex align-items-center justify-content-end gap-2 flex-shrink-0">
                <button type="button" data-bs-dismiss="modal" class="btn fw-semibold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important; cursor: pointer; transition: opacity 0.2s;">
                    Cancel
                </button>
                <button type="button" onclick="Update()" class="btn text-white fw-bold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; font-size: 13.5px !important; cursor: pointer;">
                    Update
                </button>
            </div>

        </div>
    </div>
</div>
<!-- Expense Type Edit Modal End -->

<style>
    #exampleModal {
        overflow-y: hidden !important;
        padding-right: 0 !important;
    }
    #exampleModal .modal-dialog {
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
    #exampleModal .modal-content {
        border-radius: 16px !important;
        overflow: hidden !important;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        display: flex !important;
        flex-direction: column !important;
        max-height: 90vh !important;
    }

    #exampleModal .modal-header {
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

    #exampleModal .modal-body {
        padding: 16px 20px !important;
        overflow-y: auto !important;
        max-height: calc(90vh - 125px) !important;
        background-color: #ffffff !important;
        text-align: left !important;
    }

    #exampleModal .modal-footer {
        padding: 10px 20px !important;
        background-color: #f8fafc !important;
        border-top: 1px solid #e2e8f0 !important;
        position: relative !important;
        flex-shrink: 0 !important;
    }

    /* Dark Mode */
    body[light-mode="dark"] #exampleModal .modal-content,
    body[data-layout-mode="dark"] #exampleModal .modal-content,
    html.dark #exampleModal .modal-content,
    body.dark-mode #exampleModal .modal-content,
    body.dark #exampleModal .modal-content {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #exampleModal .modal-body,
    body[data-layout-mode="dark"] #exampleModal .modal-body,
    html.dark #exampleModal .modal-body,
    body.dark-mode #exampleModal .modal-body,
    body.dark #exampleModal .modal-body {
        background-color: #0f172a !important;
    }
    body[light-mode="dark"] #exampleModal .modal-footer,
    body[data-layout-mode="dark"] #exampleModal .modal-footer,
    html.dark #exampleModal .modal-footer,
    body.dark-mode #exampleModal .modal-footer,
    body.dark #exampleModal .modal-footer {
        background-color: #1e293b !important;
        border-top-color: #334155 !important;
    }
    body[light-mode="dark"] #exampleModal .custom-modal-label,
    body[data-layout-mode="dark"] #exampleModal .custom-modal-label,
    html.dark #exampleModal .custom-modal-label,
    body.dark-mode #exampleModal .custom-modal-label,
    body.dark #exampleModal .custom-modal-label {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] #exampleModal .custom-modal-input,
    body[data-layout-mode="dark"] #exampleModal .custom-modal-input,
    html.dark #exampleModal .custom-modal-input,
    body.dark-mode #exampleModal .custom-modal-input,
    body.dark #exampleModal .custom-modal-input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
</style>

<script>
    // Function to fill the form when editing
    async function FillUpUpdateForm(id) {
        try {
            document.getElementById('updateID').value = id;
            showLoader();

            let res = await axios.post("/api/expense-type-by-id", {
                id: id.toString()
            }, HeaderToken());
            hideLoader();

            if (res.data && res.data.rows) {
                let data = res.data.rows;
                document.getElementById('UpdateExpenseTypeName').value = data.type_name || '';
                document.getElementById('UpdateSelectStatus').value = data.status || 'Active';
                $("#exampleModal").modal('show');
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    // Update Category/Expense Type Script
    async function Update() {
        try {
            let UpdateExpenseTypeName = document.getElementById('UpdateExpenseTypeName').value.trim();
            let updateID = document.getElementById('updateID').value;
            let UpdateSelectStatus = document.getElementById('UpdateSelectStatus').value;

            if (!UpdateExpenseTypeName) {
                return errorToast('Expense Type Name Required!');
            }
            if (!UpdateSelectStatus) {
                return errorToast('Please select a valid status.');
            }

            let formData = new FormData();
            formData.append('type_name', UpdateExpenseTypeName);
            formData.append('status', UpdateSelectStatus);
            formData.append('id', updateID);

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            showLoader();
            let res = await axios.post("/api/update-expense-type", formData, config);
            hideLoader();

            if (res.data && res.data.status === "success") {
                successToast(res.data.message);
                $("#exampleModal").modal('hide');
                if (typeof getList === 'function') {
                    await getList();
                } else {
                    setTimeout(() => location.reload(), 500);
                }
            } else {
                errorToast(res.data ? res.data.message : "Failed to update.");
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }
</script>
