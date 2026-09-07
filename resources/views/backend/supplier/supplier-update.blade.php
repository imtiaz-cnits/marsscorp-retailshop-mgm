<style>
    #exampleModal {
        z-index: 1060 !important;
        background: rgba(0, 0, 0, 0.65) !important;
    }
    #exampleModal .modal-dialog {
        background: transparent !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        text-align: left !important;
        max-width: 650px !important;
        width: 650px !important;
        max-height: 90vh !important;
        height: auto !important;
        margin: auto !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    @media screen and (max-width: 768px) {
        #exampleModal .modal-dialog {
            max-width: 95% !important;
            width: 95% !important;
            margin: auto !important;
        }
    }

    #exampleModal .modal-content,
    #exampleModal .modal-dialog .modal-content {
        border-radius: 16px !important;
        overflow: hidden !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4) !important;
        background: #ffffff !important;
        text-align: left !important;
        max-height: 90vh !important;
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
        position: relative !important;
    }

    body[light-mode="dark"] #exampleModal .modal-content,
    body[light-mode="dark"] #exampleModal .modal-dialog .modal-content {
        background-color: #0f172a !important;
        border: 1px solid #1e293b !important;
    }

    body[light-mode="dark"] #exampleModal .modal-footer-sticky {
        background-color: #0f172a !important;
        border-top-color: #1e293b !important;
    }

    .form-label-title {
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #334155 !important;
        margin-bottom: 6px !important;
        display: block !important;
        line-height: 1.3 !important;
        text-align: left !important;
    }
    body[light-mode="dark"] .form-label-title {
        color: #cbd5e1 !important;
    }

    #exampleModal input[type="text"],
    #exampleModal input[type="email"],
    #exampleModal input[type="number"],
    #exampleModal .form-select,
    #exampleModal select {
        width: 100% !important;
        height: 42px !important;
        font-size: 13.5px !important;
        color: #334155 !important;
        padding: 8px 14px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 8px !important;
        outline: none !important;
        background: #ffffff !important;
        transition: border-color 0.2s, box-shadow 0.2s !important;
        text-align: left !important;
    }
    #exampleModal input:focus,
    #exampleModal .form-select:focus,
    #exampleModal select:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.2) !important;
    }
    #exampleModal .modal-dialog .close-btn,
    #exampleModal .close-btn {
        position: static !important;
        top: auto !important;
        right: auto !important;
        bottom: auto !important;
        left: auto !important;
        width: 28px !important;
        height: 28px !important;
        min-width: 28px !important;
        min-height: 28px !important;
        border-radius: 50% !important;
        background-color: #dc2626 !important;
        color: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border: none !important;
        cursor: pointer !important;
        margin: 0 !important;
        padding: 0 !important;
        line-height: 1 !important;
        transition: all 0.15s ease !important;
    }

    body[light-mode="dark"] #exampleModal input[type="text"],
    body[light-mode="dark"] #exampleModal input[type="email"],
    body[light-mode="dark"] #exampleModal input[type="number"],
    body[light-mode="dark"] #exampleModal .form-select,
    body[light-mode="dark"] #exampleModal select {
        background-color: #1e293b !important;
        color: #f1f5f9 !important;
        border-color: #334155 !important;
    }
</style>

<!-- Action Button Edit Modal Start -->
<section class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Sticky Green Header with White Text & Red Close Icon -->
            <div style="background-color: #15803d; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 10; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <h2 style="font-size: 18px; font-weight: 700; color: #ffffff; margin: 0; padding: 0; line-height: 1.2;">Update Supplier</h2>
                <button type="button" class="close-btn close" data-bs-dismiss="modal" aria-label="Close" style="position: static !important; width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #dc2626; color: #ffffff; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.15s ease; margin: 0; padding: 0;" title="Close">
                    <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 14px;"></i>
                </button>
            </div>

            <!-- Form Wrapper -->
            <form onsubmit="return Update(event)" id="supplierUpdateForm" style="display: flex; flex-direction: column; flex: 1 1 auto; overflow: hidden; margin: 0;">
                <input class="d-none" id="updateID">

                <!-- Scrollable Body Content -->
                <div id="popup-modal" style="padding: 20px 24px; overflow-y: auto; flex: 1 1 auto; max-height: calc(90vh - 130px); text-align: left;">
                    <div class="row">
                        <div class="col-lg-6 mb-2">
                            <label for="UpdatesupplierName" class="form-label-title">Supplier Name <span style="color: #ef4444;">*</span></label>
                            <div class="form-row">
                                <input type="text" placeholder="Enter Supplier Name" id="UpdatesupplierName" required />
                            </div>
                        </div>
                        <div class="col-lg-6 mb-2">
                            <label for="UpdatesupplierMobile" class="form-label-title">Supplier Mobile <span style="color: #ef4444;">*</span></label>
                            <div class="form-row">
                                <input type="text" placeholder="Enter Supplier Mobile" id="UpdatesupplierMobile" required />
                            </div>
                        </div>

                        <div class="col-lg-6 mb-2">
                            <label for="UpdatesupplierCompany" class="form-label-title">Supplier Company</label>
                            <div class="form-row">
                                <input type="text" placeholder="Enter Supplier Company" id="UpdatesupplierCompany" />
                            </div>
                        </div>
                        <div class="col-lg-6 mb-2">
                            <label for="UpdatesupplierAddress" class="form-label-title">Supplier Address</label>
                            <div class="form-row">
                                <input type="text" placeholder="Enter Supplier Address" id="UpdatesupplierAddress" />
                            </div>
                        </div>

                        <div class="col-lg-6 mb-2">
                            <label for="UpdatesupplierEmail" class="form-label-title">Supplier Email</label>
                            <div class="form-row">
                                <input type="email" placeholder="Enter Supplier Email" id="UpdatesupplierEmail" />
                            </div>
                        </div>
                        <div class="col-lg-6 mb-2">
                            <label for="UpdatePurchasePayableAmount" class="form-label-title">Purchase Payable Amount</label>
                            <div class="form-row">
                                <input type="number" step="any" placeholder="Enter Purchase Payable Amount" id="UpdatePurchasePayableAmount" />
                            </div>
                        </div>

                        <div class="col-lg-6 mb-2">
                            <label for="UpdateSelectStatus" class="form-label-title">Status <span style="color: #ef4444;">*</span></label>
                            <div class="form-row">
                                <select class="form-select input-style" id="UpdateSelectStatus" style="cursor: pointer !important;">
                                    <option value="Active">Active</option>
                                    <option value="InActive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <!-- Upload Photo -->
                        <div class="col-lg-12 mb-1">
                            <label class="form-label-title">Supplier Image</label>
                            <div class="upload-profile">
                                <div class="item" style="display: flex; align-items: center; gap: 14px;">
                                    <div class="img-box" id="updateSupplierImgBox" style="width: 80px; height: 70px; min-width: 80px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1.5px dashed #cbd5e1;">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                            <polyline points="21 15 16 10 5 21"></polyline>
                                        </svg>
                                    </div>

                                    <div class="profile-wrapper" style="flex: 1;">
                                        <label class="custom-file-input-wrapper" style="cursor: pointer;">
                                            <input type="file" class="custom-file-input"
                                                aria-label="Upload Photo" id="UpdatesupplierImage" accept="image/*" style="cursor: pointer;" />
                                        </label>
                                        <p style="margin: 4px 0 0 0; font-size: 11px; color: #94a3b8;">PNG, JPEG or GIF (up to 1 MB)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sticky Bottom Footer with Submit Button -->
                <div style="padding: 12px 24px 16px; background: #ffffff; border-top: 1px solid #f1f5f9; flex-shrink: 0; position: sticky; bottom: 0; z-index: 10;" class="modal-footer-sticky">
                    <button type="submit" class="btn-save" style="width: 100% !important; height: 42px !important; background-color: #15803d !important; color: #ffffff !important; border-radius: 8px !important; font-weight: 600 !important; font-size: 15px !important; border: none !important; cursor: pointer !important; display: flex; align-items: center; justify-content: center; transition: background-color 0.2s ease;">Submit</button>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Action Button Edit Modal End -->

<script>
    const defaultUpdateSupplierSvg = `<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
        <circle cx="8.5" cy="8.5" r="1.5"></circle>
        <polyline points="21 15 16 10 5 21"></polyline>
    </svg>`;

    $(document).ready(function() {
        $('#exampleModal').appendTo("body");

        $('#UpdatesupplierImage').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#updateSupplierImgBox').html(`<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;" />`);
                };
                reader.readAsDataURL(file);
            }
        });

        $('#exampleModal').on('hidden.bs.modal', function () {
            $('#updateSupplierImgBox').html(defaultUpdateSupplierSvg);
            $('#UpdatesupplierImage').val('');
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

    async function FillUpUpdateForm(id) {
        try {
            document.getElementById('updateID').value = id;

            let res = await axios.post("/api/supplier-by-id", {
                id: id.toString()
            }, HeaderToken());

            let data = res.data.rows;
            if (data) {
                document.getElementById('UpdatesupplierName').value = data.name || '';
                document.getElementById('UpdatesupplierCompany').value = data.company || '';
                document.getElementById('UpdatesupplierMobile').value = data.mobile || '';
                document.getElementById('UpdatesupplierAddress').value = data.address || '';
                document.getElementById('UpdatesupplierEmail').value = data.email || '';
                document.getElementById('UpdatePurchasePayableAmount').value = data.purchase_payable_amount || 0;
                if (document.getElementById('UpdateSelectStatus')) {
                    document.getElementById('UpdateSelectStatus').value = data.status || 'Active';
                }

                if (data.img_url) {
                    let imgPath = data.img_url.startsWith('http') ? data.img_url : '/' + data.img_url.replace(/^\/+/, '');
                    $('#updateSupplierImgBox').html(`<img src="${imgPath}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;" />`);
                } else {
                    $('#updateSupplierImgBox').html(defaultUpdateSupplierSvg);
                }
            }
        } catch (e) {
            console.error(e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    async function Update(event) {
        if (event) event.preventDefault();
        try {
            let supplierName = $('#UpdatesupplierName').val().trim();
            let supplierMobile = $('#UpdatesupplierMobile').val().trim();

            if (supplierName.length === 0) {
                errorToast("Supplier Name is required!");
                return false;
            }
            if (supplierMobile.length === 0) {
                errorToast("Supplier Mobile is required!");
                return false;
            }

            let formData = new FormData();
            formData.append('name', supplierName);
            formData.append('company', $('#UpdatesupplierCompany').val().trim());
            formData.append('mobile', supplierMobile);
            formData.append('address', $('#UpdatesupplierAddress').val().trim());
            formData.append('email', $('#UpdatesupplierEmail').val().trim());
            formData.append('purchase_payable_amount', $('#UpdatePurchasePayableAmount').val().trim() || 0);
            if ($('#UpdateSelectStatus').length) {
                formData.append('status', $('#UpdateSelectStatus').val() || 'Active');
            }
            formData.append('id', $('#updateID').val());

            let imgInput = $('#UpdatesupplierImage')[0]?.files[0];
            if (imgInput) {
                formData.append('img', imgInput);
            }

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            showLoader();
            let res = await axios.post("/api/update-supplier", formData, config);
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message);
                $("#exampleModal").modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                errorToast(res.data.message);
            }
        } catch (e) {
            hideLoader();
            console.error("Error:", e.response);
            errorToast("An error occurred. Please try again.");
        }
        return false;
    }
</script>
