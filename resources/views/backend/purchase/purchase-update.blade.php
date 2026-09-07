<!-- Flatpickr Styles & Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
    /* Flatpickr Calendar on Top of Modals */
    .flatpickr-calendar {
        z-index: 999999 !important;
    }
    #purchaseUpdateModal {
        z-index: 1060 !important;
    }
    #purchaseUpdateModal .modal-dialog {
        max-width: 620px;
        margin: 1.75rem auto;
    }
    #purchaseUpdateModal .modal-content {
        border-radius: 16px;
        border: none;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        background-color: #ffffff;
    }
    #purchaseUpdateModal .form-control,
    #purchaseUpdateModal .form-select {
        height: 38px !important;
        border-radius: 10px !important;
        border: 1px solid #cbd5e1 !important;
        font-size: 13px !important;
        padding: 6px 14px !important;
        cursor: pointer;
    }
    #purchaseUpdateModal input:not([readonly]) {
        cursor: text !important;
    }
    #purchaseUpdateModal .form-control:focus,
    #purchaseUpdateModal .form-select:focus {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2) !important;
    }

    /* Dark Mode Support */
    body[light-mode="dark"] #purchaseUpdateModal .modal-content,
    html[light-mode="dark"] #purchaseUpdateModal .modal-content,
    body[data-layout-mode="dark"] #purchaseUpdateModal .modal-content,
    html.dark #purchaseUpdateModal .modal-content,
    body.dark #purchaseUpdateModal .modal-content,
    body.dark-mode #purchaseUpdateModal .modal-content {
        background-color: #0f172a !important;
        color: #f8fafc !important;
    }

    body[light-mode="dark"] #purchaseUpdateModal .modal-body,
    html[light-mode="dark"] #purchaseUpdateModal .modal-body,
    body[data-layout-mode="dark"] #purchaseUpdateModal .modal-body,
    html.dark #purchaseUpdateModal .modal-body,
    body.dark #purchaseUpdateModal .modal-body,
    body.dark-mode #purchaseUpdateModal .modal-body {
        background-color: #0f172a !important;
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
        background-color: #1e293b !important;
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

    body[light-mode="dark"] #updateSupplierDropdownList .update-supplier-item:hover,
    html[light-mode="dark"] #updateSupplierDropdownList .update-supplier-item:hover,
    body[data-layout-mode="dark"] #updateSupplierDropdownList .update-supplier-item:hover,
    html.dark #updateSupplierDropdownList .update-supplier-item:hover,
    body.dark #updateSupplierDropdownList .update-supplier-item:hover,
    body.dark-mode #updateSupplierDropdownList .update-supplier-item:hover {
        background-color: #0f172a !important;
    }

    body[light-mode="dark"] #purchaseUpdateModal .modal-footer-wrap,
    html[light-mode="dark"] #purchaseUpdateModal .modal-footer-wrap,
    body[data-layout-mode="dark"] #purchaseUpdateModal .modal-footer-wrap,
    html.dark #purchaseUpdateModal .modal-footer-wrap,
    body.dark #purchaseUpdateModal .modal-footer-wrap,
    body.dark-mode #purchaseUpdateModal .modal-footer-wrap {
        border-top-color: #334155 !important;
    }

    #purchaseUpdateModal label {
        text-align: left !important;
    }
</style>

<!-- Action Button Edit Modal Start -->
<section class="modal fade" id="purchaseUpdateModal" tabindex="-1" aria-labelledby="purchaseUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Sticky Green Header with White Text & Red Close Icon -->
            <div style="background-color: #15803d; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 10;">
                <h2 style="font-size: 18px; font-weight: 700; color: #ffffff; margin: 0; padding: 0; line-height: 1.2; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                    <span>Update Purchase</span>
                </h2>
                <button type="button" class="close-btn close" data-bs-dismiss="modal" aria-label="Close" style="position: static !important; width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #dc2626; color: #ffffff; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.15s ease; margin: 0; padding: 0;" title="Close">
                    <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 14px;"></i>
                </button>
            </div>

            <!-- Form Body -->
            <div class="modal-body p-4 sm:p-5" style="text-align: left;">
                <form onsubmit="return Update(event)">
                    <input type="hidden" id="updateID">

                    <div class="row g-3">
                        <div class="col-md-6 mb-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Reference No</label>
                            <input type="text" class="form-control" placeholder="Enter Reference No" id="UpdateReferanceNo" />
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Date <span class="text-rose-500">*</span></label>
                            <input type="text" class="form-control" id="UpdatePurchaseDate" placeholder="DD-MM-YYYY" autocomplete="off" required style="cursor: pointer;" />
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Grand Total (৳) <span class="text-rose-500">*</span></label>
                            <input type="number" step="any" class="form-control font-bold" placeholder="Grand Subtotal" id="UpdateGrandSubtotal" required />
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Paid Amount (৳)</label>
                            <input type="number" step="any" class="form-control font-bold text-emerald-600 dark:text-emerald-400" placeholder="Paid Amount" id="UpdatePaidAmount" />
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Due Amount (৳)</label>
                            <input type="number" step="any" class="form-control font-bold text-rose-600 dark:text-rose-400 bg-slate-50 dark:bg-slate-800/60" placeholder="Due Amount" id="UpdateDueAmount" readonly />
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1 text-left">Supplier</label>
                            <!-- Searchable Supplier Dropdown for Update Modal -->
                            <div class="relative" id="updateSearchableSupplierWrapper">
                                <input type="text" id="updateSupplierSearchInput" class="form-control w-full" placeholder="Search or Select Supplier..." autocomplete="off" style="cursor: pointer;" />
                                <input type="hidden" id="UpdateSupplierSelect" value="" />
                                <div id="updateSupplierDropdownList" class="dropdown-menu shadow-xl w-full p-0 overflow-auto rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800" style="max-height: 220px; display: none; position: absolute; z-index: 1070; top: 100%; left: 0;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Cancel button red with white text, Update button emerald with white text -->
                    <div class="modal-footer-wrap flex items-center justify-end gap-2 mt-4 pt-3 border-t border-slate-200 dark:border-slate-800">
                        <button type="button" class="px-4 h-[38px] rounded-xl text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:scale-[0.98] transition-all shadow-sm border-0 cursor-pointer" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="inline-flex items-center gap-1.5 px-5 h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-150 border-0 cursor-pointer">
                            <i class="fa-solid fa-check text-xs"></i>
                            <span>Update Purchase</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Action Button Edit Modal End -->

<script>
    let updateAllSuppliersData = [];
    window.updatePurchaseDatepicker = null;

    function initUpdateDatePicker() {
        const dateInput = document.getElementById("UpdatePurchaseDate");
        if (dateInput && typeof flatpickr !== "undefined") {
            if (window.updatePurchaseDatepicker) {
                window.updatePurchaseDatepicker.destroy();
            }
            window.updatePurchaseDatepicker = flatpickr(dateInput, {
                dateFormat: "d-m-Y",
                allowInput: true,
                clickOpens: true,
                disableMobile: true
            });
        }
    }

    $(document).ready(function() {
        $('#purchaseUpdateModal').appendTo("body");

        initUpdateDatePicker();

        $('#purchaseUpdateModal').on('shown.bs.modal', function (event) {
            initUpdateDatePicker();
        });

        $('#purchaseUpdateModal').on('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (button) {
                const id = $(button).attr('data-id') || $(button).data('id') || $(button).closest('[data-id]').attr('data-id');
                if (id) {
                    FillUpUpdateForm(id);
                }
            }
        });

        // Searchable dropdown input listeners
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

            document.addEventListener("click", function(e) {
                const wrapper = document.getElementById("updateSearchableSupplierWrapper");
                if (wrapper && !wrapper.contains(e.target)) {
                    suppList.style.display = "none";
                }
            });
        }

        // Recalculate due when subtotal or paid changes
        $('#UpdateGrandSubtotal, #UpdatePaidAmount').on('input', function() {
            let g = parseFloat($('#UpdateGrandSubtotal').val()) || 0;
            let p = parseFloat($('#UpdatePaidAmount').val()) || 0;
            $('#UpdateDueAmount').val(Math.max(0, g - p).toFixed(2));
        });
    });

    function renderUpdateSupplierDropdownItems(suppliers) {
        const listContainer = document.getElementById("updateSupplierDropdownList");
        if (!listContainer) return;

        if (!suppliers || suppliers.length === 0) {
            listContainer.innerHTML = `<div class="p-2.5 text-slate-400 text-center text-xs">No suppliers found</div>`;
            return;
        }

        let html = suppliers.map(s => {
            return `
                <div class="dropdown-item px-3.5 py-2 border-b border-slate-100 dark:border-slate-800 update-supplier-item hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors"
                     data-id="${s.id}"
                     data-name="${s.name}"
                     style="cursor: pointer;">
                     <div class="font-bold text-slate-800 dark:text-slate-100 text-xs flex items-center justify-between">
                         <span>${s.name} ${s.company ? `<span class="text-[11px] font-normal text-slate-500 dark:text-slate-400">(${s.company})</span>` : ''}</span>
                         <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono">${s.supplier_id || ''}</span>
                     </div>
                </div>
            `;
        }).join('');

        listContainer.innerHTML = html;

        listContainer.querySelectorAll('.update-supplier-item').forEach(item => {
            item.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                document.getElementById("UpdateSupplierSelect").value = id;
                document.getElementById("updateSupplierSearchInput").value = name;
                listContainer.style.display = 'none';
            });
        });
    }

    async function FillUpUpdateForm(id) {
        try {
            document.getElementById('updateID').value = id;

            // Load suppliers dropdown
            await LoadSuppliersDropdown();

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
                        // Convert Y-m-d to d-m-Y
                        dateVal = `${parts[2]}-${parts[1]}-${parts[0]}`;
                    }
                }
                document.getElementById('UpdatePurchaseDate').value = dateVal;
                initUpdateDatePicker();
                if (window.updatePurchaseDatepicker) {
                    window.updatePurchaseDatepicker.setDate(dateVal, true, "d-m-Y");
                }

                document.getElementById('UpdateGrandSubtotal').value = data.grand_subtotal || 0;
                document.getElementById('UpdatePaidAmount').value = data.paid_amount || 0;
                document.getElementById('UpdateDueAmount').value = data.due_amount || 0;
                if (data.supplier_id) {
                    document.getElementById('UpdateSupplierSelect').value = data.supplier_id;
                    const foundSupp = updateAllSuppliersData.find(s => s.id == data.supplier_id);
                    if (foundSupp) {
                        document.getElementById('updateSupplierSearchInput').value = foundSupp.name;
                    } else if (data.supplier) {
                        document.getElementById('updateSupplierSearchInput').value = data.supplier;
                    }
                }
            }
        } catch (e) {
            console.error(e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    async function LoadSuppliersDropdown() {
        try {
            let res = await axios.get("/api/supplier-list", HeaderToken());
            updateAllSuppliersData = res.data.SupplierData || res.data.rows || [];
            renderUpdateSupplierDropdownItems(updateAllSuppliersData);
        } catch (e) {
            console.error("Error loading suppliers:", e);
        }
    }

    async function Update(event) {
        if (event) event.preventDefault();
        try {
            let id = $('#updateID').val();
            let grandSubtotal = $('#UpdateGrandSubtotal').val();
            let paidAmount = $('#UpdatePaidAmount').val() || 0;
            let dueAmount = $('#UpdateDueAmount').val() || 0;

            let formData = new FormData();
            formData.append('id', id);
            formData.append('referance_no', $('#UpdateReferanceNo').val().trim());
            formData.append('date', $('#UpdatePurchaseDate').val());
            formData.append('grand_subtotal', grandSubtotal);
            formData.append('paid_amount', paidAmount);
            formData.append('due_amount', dueAmount);
            formData.append('supplier_id', $('#UpdateSupplierSelect').val());

            const config = {
                headers: {
                    ...HeaderToken().headers
                }
            };

            showLoader();
            let res = await axios.post("/api/update-purchases", formData, config);
            hideLoader();

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
            hideLoader();
            console.error("Error:", e.response);
            errorToast("Failed to update purchase.");
        }
        return false;
    }
</script>
