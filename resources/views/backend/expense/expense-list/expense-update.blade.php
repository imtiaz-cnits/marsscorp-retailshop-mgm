<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Expense Update Modal Start -->
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
                    <h5 class="modal-title m-0 text-white fw-bold" id="exampleModalLabel" style="font-size: 16px; color: #ffffff !important;">Update Expense</h5>
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
                <form onsubmit="return Update(event)" class="text-start" style="text-align: left !important;">
                    <input type="hidden" id="updateID">

                    <div class="row g-2.5 text-start" style="text-align: left !important;">
                        
                        <!-- Expense Type -->
                        <div class="col-12 text-start" style="text-align: left !important;">
                            <label class="custom-modal-label text-start" style="text-align: left !important;">Expense Type <span class="text-danger">*</span></label>
                            <select class="custom-modal-input text-start" id="UpdateExpenseTypeInfoID" onchange="checkUpdateExpenseSalaryType()" required style="text-align: left !important; cursor: pointer !important;">
                                <option value="">Select Expense Type</option>
                            </select>
                        </div>

                        <!-- Staff Select (Conditional) -->
                        <div class="col-12 text-start d-none" id="UpdateStaffContainer" style="text-align: left !important;">
                            <label class="custom-modal-label text-start" style="text-align: left !important;">Select Staff <span class="text-danger">*</span></label>
                            <select class="custom-modal-input text-start" id="UpdateStaffInfoID" style="text-align: left !important; cursor: pointer !important;">
                                <option value="">-- Select Staff --</option>
                            </select>
                        </div>

                        <!-- Expense Amount & Date (2 Columns) -->
                        <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                            <label class="custom-modal-label text-start" style="text-align: left !important;">Expense Amount (৳) <span class="text-danger">*</span></label>
                            <input type="number" step="any" class="custom-modal-input text-start fw-bold text-rose-600" placeholder="0.00" id="UpdateExpenseAmount" required style="text-align: left !important;" />
                        </div>
                        <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                            <label class="custom-modal-label text-start" style="text-align: left !important;">Expense Date <span class="text-danger">*</span></label>
                            <input type="text" class="custom-modal-input text-start" id="UpdateExpenseDate" required placeholder="YYYY-MM-DD" style="text-align: left !important; cursor: pointer;" />
                        </div>

                        <!-- Expense Details -->
                        <div class="col-12 text-start" style="text-align: left !important;">
                            <label class="custom-modal-label text-start" style="text-align: left !important;">Expense Details</label>
                            <textarea class="custom-modal-input text-start" placeholder="Expense Details..." id="UpdateExpenseDetails" rows="2" style="height: 60px !important; padding: 8px 14px !important; resize: none; text-align: left !important;"></textarea>
                        </div>

                    </div>
                </form>
            </div>

            <!-- Sticky Bottom Footer with Red Cancel & Green Update Buttons (Strict 38px height) -->
            <div class="modal-footer d-flex align-items-center justify-content-end gap-2 flex-shrink-0">
                <button type="button" data-bs-dismiss="modal" class="btn fw-semibold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important; cursor: pointer; transition: opacity 0.2s;">
                    Cancel
                </button>
                <button type="button" onclick="Update(event)" class="btn text-white fw-bold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; font-size: 13.5px !important; cursor: pointer;">
                    Update
                </button>
            </div>

        </div>
    </div>
</div>
<!-- Expense Update Modal End -->

<style>
    #exampleModal {
        overflow-y: hidden !important;
        padding-right: 0 !important;
        z-index: 1060 !important;
    }
    #exampleModal .modal-dialog {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        max-width: 560px !important;
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
    /* Month header */
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
    /* Month/Year text & dropdown */
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
    /* Weekday headers */
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
    /* Today */
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
    /* Prev/next month greyed days */
    body[data-layout-mode="dark"] .flatpickr-day.prevMonthDay,
    body[light-mode="dark"] .flatpickr-day.prevMonthDay,
    html.dark .flatpickr-day.prevMonthDay,
    body[data-layout-mode="dark"] .flatpickr-day.nextMonthDay,
    body[light-mode="dark"] .flatpickr-day.nextMonthDay,
    html.dark .flatpickr-day.nextMonthDay {
        color: #475569 !important;
    }
    /* Year spinner */
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
    let updateGlobalExpenseTypes = [];
    let updateGlobalStaffList = [];
    let updateDatepicker = null;

    $(document).ready(function() {
        $('#exampleModal').appendTo("body");
        ExpenseTypeDataShow();

        if (typeof flatpickr !== 'undefined') {
            if (updateDatepicker) {
                updateDatepicker.destroy();
            }
            updateDatepicker = flatpickr("#UpdateExpenseDate", {
                dateFormat: "Y-m-d",
                allowInput: true,
                clickOpens: true,
                disableMobile: true,
                onOpen: function() {
                    $(document).off('focusin.bs.modal');
                }
            });
        }

        // Re-init flatpickr every time the modal is fully shown
        $('#exampleModal').on('shown.bs.modal', function () {
            if (typeof flatpickr !== 'undefined') {
                if (updateDatepicker) {
                    updateDatepicker.destroy();
                }
                updateDatepicker = flatpickr("#UpdateExpenseDate", {
                    dateFormat: "Y-m-d",
                    allowInput: true,
                    clickOpens: true,
                    disableMobile: true,
                    onOpen: function() {
                        $(document).off('focusin.bs.modal');
                    }
                });
            }
        });

        $('#exampleModal').on('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (button) {
                const id = $(button).attr('data-id') || $(button).data('id') || $(button).closest('[data-id]').attr('data-id');
                if (id) {
                    FillUpUpdateForm(id);
                }
            }
        });
    });

    async function ExpenseTypeDataShow() {
        try {
            const [typeRes, staffRes] = await Promise.all([
                axios.get("/api/expense-type-list", HeaderToken()),
                axios.get("/api/staff-list", HeaderToken())
            ]);

            if (typeRes.data.ExpenseTypeData) {
                updateGlobalExpenseTypes = typeRes.data.ExpenseTypeData;
                let optionsHtml = updateGlobalExpenseTypes.map(type => `<option value="${type.id}">${type.type_name}</option>`).join('');
                $("#UpdateExpenseTypeInfoID").html(`<option value="" disabled selected>Select Expense Type</option>` + optionsHtml);
            }

            if (staffRes.data.status === 'success' && staffRes.data.StaffData) {
                updateGlobalStaffList = staffRes.data.StaffData;
                let staffHtml = updateGlobalStaffList.map(s => `<option value="${s.id}">${s.name} (${s.mobile || 'Staff'})</option>`).join('');
                $("#UpdateStaffInfoID").html(`<option value="">-- Select Staff --</option>` + staffHtml);
            }
        } catch (error) {
            console.error("Error fetching expense types/staff:", error);
        }
    }

    function checkUpdateExpenseSalaryType() {
        const selectedTypeId = document.getElementById('UpdateExpenseTypeInfoID').value;
        const selectedType = updateGlobalExpenseTypes.find(t => t.id == selectedTypeId);
        const container = document.getElementById('UpdateStaffContainer');
        
        if (selectedType) {
            const nameLower = (selectedType.type_name || '').toLowerCase();
            const keywords = [
                'salary', 'sallery', 'salery', 'salari', 'salry', 'salaries',
                'payroll', 'wage', 'wages', 'honorarium'
            ];
            const isSalary = keywords.some(k => nameLower.includes(k));
            if (isSalary) {
                container.classList.remove('d-none');
            } else {
                container.classList.add('d-none');
                document.getElementById('UpdateStaffInfoID').value = '';
            }
        }
    }

    async function FillUpUpdateForm(id) {
        try {
            document.getElementById('updateID').value = id;

            let res = await axios.post("/api/expense-by-id", {
                id: id.toString()
            }, HeaderToken());

            let data = res.data.rows;
            if (data) {
                document.getElementById('UpdateExpenseTypeInfoID').value = data.expense_type_id || '';
                checkUpdateExpenseSalaryType();
                document.getElementById('UpdateStaffInfoID').value = data.staff_id || '';
                document.getElementById('UpdateExpenseAmount').value = data.expense_amount || 0;
                if (updateDatepicker) {
                    updateDatepicker.setDate(data.date || '', true);
                } else {
                    document.getElementById('UpdateExpenseDate').value = data.date || '';
                }
                document.getElementById('UpdateExpenseDetails').value = data.expense_details || '';
            }
        } catch (e) {
            console.error(e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    async function Update(event) {
        if (event && typeof event.preventDefault === 'function') event.preventDefault();
        try {
            const typeId = $('#UpdateExpenseTypeInfoID').val();
            const staffId = $('#UpdateStaffInfoID').val();
            const container = document.getElementById('UpdateStaffContainer');

            if (container && !container.classList.contains('d-none') && !staffId) {
                errorToast("Staff selection is required for salary!");
                return false;
            }

            let formData = new FormData();
            formData.append('expense_type_id', typeId);
            formData.append('staff_id', staffId || '');
            formData.append('expense_amount', $('#UpdateExpenseAmount').val());
            formData.append('date', $('#UpdateExpenseDate').val());
            formData.append('expense_details', $('#UpdateExpenseDetails').val());
            formData.append('id', $('#updateID').val());

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            showLoader();
            let res = await axios.post("/api/update-expense", formData, config);
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message);
                $("#exampleModal").modal('hide');
                if (typeof getExpenseList === 'function') {
                    await getExpenseList();
                } else {
                    setTimeout(() => location.reload(), 500);
                }
            } else {
                errorToast(res.data.message);
            }
        } catch (e) {
            hideLoader();
            console.error("Error:", e.response);
            errorToast("Failed to update expense.");
        }
        return false;
    }
</script>
