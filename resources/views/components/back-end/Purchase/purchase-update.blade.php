<style>
    #purchaseUpdateModal {
        z-index: 1060 !important;
    }
    #purchaseUpdateModal .modal-dialog {
        max-width: 600px;
        margin: 1.75rem auto;
    }
    #purchaseUpdateModal .modal-content {
        border-radius: 14px;
        border: none;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }
    #purchaseUpdateModal .form-control,
    #purchaseUpdateModal .form-select {
        height: 44px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 14px;
        padding: 8px 12px;
    }
    #purchaseUpdateModal .form-control:focus,
    #purchaseUpdateModal .form-select:focus {
        border-color: #0d9488;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
    }
</style>

<!-- Action Button Edit Modal Start -->
<section class="modal fade" id="purchaseUpdateModal" tabindex="-1" aria-labelledby="purchaseUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header border-0 pb-2">
                <h5 class="modal-title fw-bold text-success d-flex align-items-center gap-2" id="purchaseUpdateModalLabel">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Purchase Update (পারচেজ তথ্য আপডেট)</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form onsubmit="return Update(event)">
                    <input type="hidden" id="updateID">

                    <div class="row g-3">
                        <div class="col-md-6 mb-2">
                            <label class="form-label small fw-bold text-secondary mb-1">Reference No</label>
                            <input type="text" class="form-control" placeholder="Enter Reference No" id="UpdateReferanceNo" />
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label small fw-bold text-secondary mb-1">Date</label>
                            <input type="date" class="form-control" id="UpdatePurchaseDate" required />
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label small fw-bold text-secondary mb-1">Grand Total (৳)</label>
                            <input type="number" step="any" class="form-control fw-bold text-dark" placeholder="Grand Subtotal" id="UpdateGrandSubtotal" required />
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label small fw-bold text-secondary mb-1">Paid Amount (৳)</label>
                            <input type="number" step="any" class="form-control fw-bold text-success" placeholder="Paid Amount" id="UpdatePaidAmount" />
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label small fw-bold text-secondary mb-1">Due Amount (৳)</label>
                            <input type="number" step="any" class="form-control fw-bold text-danger bg-light" placeholder="Due Amount" id="UpdateDueAmount" readonly />
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label small fw-bold text-secondary mb-1">Supplier</label>
                            <select class="form-select" id="UpdateSupplierSelect">
                                <option value="">Select Supplier</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-light px-4 py-2 fw-bold text-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="border-radius: 8px; background-color: #15803d; border: none;">
                            <i class="fa-solid fa-check me-1"></i> Update Purchase
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Action Button Edit Modal End -->

<script>
    $(document).ready(function() {
        $('#purchaseUpdateModal').appendTo("body");

        $('#purchaseUpdateModal').on('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (button) {
                const id = $(button).attr('data-id') || $(button).data('id') || $(button).closest('[data-id]').attr('data-id');
                if (id) {
                    FillUpUpdateForm(id);
                }
            }
        });

        // Recalculate due when subtotal or paid changes
        $('#UpdateGrandSubtotal, #UpdatePaidAmount').on('input', function() {
            let g = parseFloat($('#UpdateGrandSubtotal').val()) || 0;
            let p = parseFloat($('#UpdatePaidAmount').val()) || 0;
            $('#UpdateDueAmount').val(Math.max(0, g - p).toFixed(2));
        });
    });

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
                document.getElementById('UpdatePurchaseDate').value = data.date || '';
                document.getElementById('UpdateGrandSubtotal').value = data.grand_subtotal || 0;
                document.getElementById('UpdatePaidAmount').value = data.paid_amount || 0;
                document.getElementById('UpdateDueAmount').value = data.due_amount || 0;
                if (document.getElementById('UpdateSupplierSelect') && data.supplier_id) {
                    document.getElementById('UpdateSupplierSelect').value = data.supplier_id;
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
            let select = $('#UpdateSupplierSelect');
            select.find('option:not(:first)').remove();
            if (res.data.status === 'success' && res.data.rows) {
                res.data.rows.forEach(supp => {
                    select.append(`<option value="${supp.id}">${supp.name} (${supp.supplier_id || ''})</option>`);
                });
            }
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
