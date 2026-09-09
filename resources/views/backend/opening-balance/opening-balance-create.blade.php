<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- Add Opening Balance Modal Start -->
<div class="modal fade" id="createOpeningBalanceModal" tabindex="-1" aria-labelledby="createOpeningBalanceModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
            <!-- Sticky Top Green Header -->
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.2); color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <h5 class="modal-title m-0 text-white fw-bold" id="createOpeningBalanceModalLabel" style="font-size: 16px; color: #ffffff !important;">Add New Opening Balance</h5>
                </div>
                <!-- Circular Red Close Button with White Icon -->
                <button type="button" class="custom-modal-close-btn d-flex align-items-center justify-content-center border-0 shadow-sm" data-bs-dismiss="modal" onclick="closeOpeningBalanceModal()" aria-label="Close" style="position: relative !important; top: auto !important; right: auto !important; width: 26px !important; height: 26px !important; min-width: 26px !important; min-height: 26px !important; border-radius: 50% !important; background-color: #ef4444 !important; color: #ffffff !important; cursor: pointer !important; transition: all 0.2s ease; padding: 0 !important; margin: 0 !important; flex-shrink: 0 !important;" title="Close">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Scrollable Modal Body (strictly left aligned) -->
            <div class="modal-body custom-scrollbar text-start" style="text-align: left !important;">
                <form id="openingBalanceForm" onsubmit="return SaveOpeningBalance(event)" class="text-start" style="text-align: left !important;">
                    <input type="hidden" id="obId" value="" />
                    <div class="row g-2.5 text-start" style="text-align: left !important;">
                        
                        <!-- Date -->
                        <div class="col-12 text-start" style="text-align: left !important;">
                            <label for="obDate" class="custom-modal-label text-start" style="text-align: left !important;">
                                <i class="fa-regular fa-calendar-days text-emerald-600 me-1"></i> Date <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="custom-modal-input text-start" id="obDate" required style="text-align: left !important;" placeholder="YYYY-MM-DD" autocomplete="off" />
                        </div>

                        <!-- Amount -->
                        <div class="col-12 text-start" style="text-align: left !important;">
                            <label for="obAmount" class="custom-modal-label text-start" style="text-align: left !important;">Opening Balance Amount (৳) <span class="text-danger">*</span></label>
                            <input type="number" step="any" placeholder="0.00" id="obAmount" required class="custom-modal-input text-start fw-bold text-rose-600" style="text-align: left !important;" />
                        </div>

                        <!-- Note -->
                        <div class="col-12 text-start" style="text-align: left !important;">
                            <label for="obNote" class="custom-modal-label text-start" style="text-align: left !important;">Note (Optional)</label>
                            <textarea name="obNote" id="obNote" rows="2" placeholder="Enter note or details..." class="custom-modal-input text-start" style="height: 64px !important; padding: 8px 14px !important; resize: none; text-align: left !important;"></textarea>
                        </div>

                    </div>
                </form>
            </div>

            <!-- Sticky Bottom Footer with Red Cancel & Green Save Buttons (Strict 38px height) -->
            <div class="modal-footer d-flex align-items-center justify-content-end gap-2 flex-shrink-0">
                <button type="button" onclick="closeOpeningBalanceModal()" class="btn fw-semibold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important; cursor: pointer; transition: opacity 0.2s;">
                    Cancel
                </button>
                <button type="button" onclick="SaveOpeningBalance(event)" class="btn text-white fw-bold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; font-size: 13.5px !important; cursor: pointer;">
                    Submit
                </button>
            </div>

        </div>
    </div>
</div>
<!-- Add Opening Balance Modal End -->

<!-- Legacy Container Support if needed -->
<section id="createProduct" class="financemodal" style="display: none;"></section>

<style>
    /* Modal Container & Scroll Locks */
    #createOpeningBalanceModal {
        overflow-y: hidden !important;
        padding-right: 0 !important;
    }
    #createOpeningBalanceModal .modal-dialog {
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
    #createOpeningBalanceModal .modal-content {
        border-radius: 16px !important;
        overflow: hidden !important;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        display: flex !important;
        flex-direction: column !important;
        max-height: 90vh !important;
    }

    #createOpeningBalanceModal .modal-header {
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

    #createOpeningBalanceModal .modal-body {
        padding: 16px 20px !important;
        overflow-y: auto !important;
        max-height: calc(90vh - 125px) !important;
        background-color: #ffffff !important;
        text-align: left !important;
    }

    #createOpeningBalanceModal .modal-footer {
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
        margin-top: 8px !important;
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
    body[light-mode="dark"] #createOpeningBalanceModal .modal-content,
    body[data-layout-mode="dark"] #createOpeningBalanceModal .modal-content,
    html.dark #createOpeningBalanceModal .modal-content,
    body.dark-mode #createOpeningBalanceModal .modal-content,
    body.dark #createOpeningBalanceModal .modal-content {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #createOpeningBalanceModal .modal-body,
    body[data-layout-mode="dark"] #createOpeningBalanceModal .modal-body,
    html.dark #createOpeningBalanceModal .modal-body,
    body.dark-mode #createOpeningBalanceModal .modal-body,
    body.dark #createOpeningBalanceModal .modal-body {
        background-color: #0f172a !important;
    }
    body[light-mode="dark"] #createOpeningBalanceModal .modal-footer,
    body[data-layout-mode="dark"] #createOpeningBalanceModal .modal-footer,
    html.dark #createOpeningBalanceModal .modal-footer,
    body.dark-mode #createOpeningBalanceModal .modal-footer,
    body.dark #createOpeningBalanceModal .modal-footer {
        background-color: #1e293b !important;
        border-top-color: #334155 !important;
    }
    body[light-mode="dark"] #createOpeningBalanceModal .custom-modal-label,
    body[data-layout-mode="dark"] #createOpeningBalanceModal .custom-modal-label,
    html.dark #createOpeningBalanceModal .custom-modal-label,
    body.dark-mode #createOpeningBalanceModal .custom-modal-label,
    body.dark #createOpeningBalanceModal .custom-modal-label {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] #createOpeningBalanceModal .custom-modal-input,
    body[data-layout-mode="dark"] #createOpeningBalanceModal .custom-modal-input,
    html.dark #createOpeningBalanceModal .custom-modal-input,
    body.dark-mode #createOpeningBalanceModal .custom-modal-input,
    body.dark #createOpeningBalanceModal .custom-modal-input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
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
    window.obDatepicker = null;

    function initObDatepicker() {
        const dateInput = document.getElementById('obDate');
        if (dateInput && typeof flatpickr !== 'undefined') {
            if (window.obDatepicker) window.obDatepicker.destroy();
            window.obDatepicker = flatpickr(dateInput, {
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
        initObDatepicker();
    });

    // Re-init flatpickr every time the modal is fully shown (fixes positioning & mobile)
    $('#createOpeningBalanceModal').on('shown.bs.modal', function () {
        initObDatepicker();
    });

    function closeOpeningBalanceModal() {
        $('#createOpeningBalanceModal').modal('hide');
        document.getElementById('openingBalanceForm').reset();
        if (document.getElementById('obId')) document.getElementById('obId').value = '';
        if (window.obDatepicker) {
            window.obDatepicker.setDate(new Date(), true);
        } else {
            const dateInput = document.getElementById('obDate');
            if (dateInput) dateInput.value = new Date().toISOString().split('T')[0];
        }
        const legacyModal = document.getElementById('createProduct');
        if (legacyModal) legacyModal.style.display = 'none';
    }

    async function SaveOpeningBalance(event) {
        if (event && typeof event.preventDefault === 'function') event.preventDefault();

        const id = document.getElementById('obId') ? document.getElementById('obId').value : '';
        const date = document.getElementById('obDate').value;
        const amount = document.getElementById('obAmount').value;
        const note = document.getElementById('obNote').value.trim();

        if (!date) {
            errorToast("Date is required!");
            return;
        }
        if (!amount || parseFloat(amount) < 0) {
            errorToast("Valid Amount is required!");
            return;
        }

        let formData = new FormData();
        formData.append('date', date);
        formData.append('amount', amount);
        formData.append('note', note || '');
        if (id) formData.append('id', id);

        try {
            showLoader();

            let apiUrl = id ? "/api/update-opening-balance" : "/api/create-opening-balance";
            const res = await axios.post(apiUrl, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            });

            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message || "Opening Balance saved successfully!");
                closeOpeningBalanceModal();
                if (typeof getList === 'function') {
                    await getList();
                } else {
                    setTimeout(() => location.reload(), 500);
                }
            } else {
                errorToast(res.data.message || "Failed to save!");
            }

        } catch (e) {
            hideLoader();
            console.error(e);
            if (e.response?.status === 401) {
                unauthorized(401);
            } else {
                errorToast("Server error. Please try again.");
            }
        }
    }
</script>