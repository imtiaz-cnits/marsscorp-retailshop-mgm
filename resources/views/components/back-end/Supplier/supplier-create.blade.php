<style>
    /* Styled identically to Add New Brand / Add New Category modals */
    #myModal.newbrand,
    #supplierCreateModal,
    #supplierCreateModal.newbrand {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        margin: 0 !important;
        padding: 0 !important;
        background: rgba(0, 0, 0, 0.65) !important;
        display: none;
        justify-content: center !important;
        align-items: center !important;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        z-index: 999999 !important;
    }

    #myModal.newbrand.show,
    #myModal.newbrand.show-modal,
    #supplierCreateModal.show,
    #supplierCreateModal.show-modal,
    #supplierCreateModal.newbrand.show,
    #supplierCreateModal.newbrand.show-modal {
        display: flex !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    #myModal .newbrand-content,
    #supplierCreateModal .newbrand-content {
        position: relative !important;
        left: auto !important;
        top: auto !important;
        transform: scale(0.9) !important;
        transition: transform 0.3s ease !important;
        background: #ffffff !important;
        padding: 24px !important;
        border-radius: 12px !important;
        width: 650px !important;
        max-width: 92% !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4) !important;
        margin: auto !important;
    }

    #myModal.newbrand.show .newbrand-content,
    #myModal.newbrand.show-modal .newbrand-content,
    #supplierCreateModal.show .newbrand-content,
    #supplierCreateModal.show-modal .newbrand-content {
        transform: scale(1) !important;
    }

    #myModal .newbrand-content h2 {
        font-size: 22px;
        font-weight: 600;
        color: #192045;
        text-align: center;
        margin-bottom: 20px;
    }

    #myModal .form-group {
        width: 100%;
        margin-bottom: 15px;
    }

    #myModal input[type="text"],
    #myModal input[type="email"],
    #myModal input[type="number"] {
        width: 100%;
        font-size: 14px;
        color: #333;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        outline: none;
        transition: border-color 0.2s;
    }

    #myModal input:focus {
        border-color: #0d9488;
    }

    #myModal .status-select {
        width: 100%;
        font-size: 14px;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        outline: none;
        background: #fff;
    }

    #myModal .button-group {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 20px;
    }

    #myModal .cancel-btn {
        background: #ededed;
        color: #555;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
    }

    #myModal .save-btn,
    #myModal .btn-save {
        background: #0d9488 !important;
        color: #fff !important;
        border: none !important;
        padding: 10px 28px !important;
        border-radius: 8px !important;
        font-weight: 600 !important;
        font-size: 15px !important;
        cursor: pointer !important;
        transition: background-color 0.2s ease !important;
    }

    #myModal .save-btn:hover,
    #myModal .btn-save:hover {
        background: #0f766e !important;
    }

    .financemodal .modal-content .col-lg-6,
    .financemodal .modal-content .col-lg-4 {
        padding: 0 6px !important;
    }

    .newbrand .upload-profile .item,
    .newcategory .upload-profile .item {
        width: 100%;
        display: flex !important;
        gap: 10px;
        margin-bottom: 15px;
    }

    .newbrand .upload-profile .item .img-box,
    .newcategory .upload-profile .item .img-box {
        width: 84px;
        height: 70px;
        border-radius: 6px;
        background: #f2f2f2;
        display: flex !important;
        justify-content: center;
        align-items: center;
    }

    .newbrand .profile-wrapper,
    .newcategory .profile-wrapper {
        width: 100%;
    }

    .newbrand .parent,
    .newcategory .parent {
        width: 100%;
        height: 100%;
        display: inline-flex;
        justify-content: space-between;
        flex-direction: column;
    }

    .newbrand .profile-wrapper p,
    .newcategory .profile-wrapper p {
        margin: 8px 0px 0px 0px;
        font-size: 14px;
        color: #aaaaaa;
    }

    .newbrand .custom-file-input-wrapper,
    .newcategory .custom-file-input-wrapper {
        font-family: var(--primary-font);
        position: relative;
        width: 100%;
        height: 46px;
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 16px;
        color: #666;
        background: #ededed;
        cursor: pointer;
    }

    .newbrand .custom-file-input,
    .newcategory .custom-file-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        z-index: 2;
        cursor: pointer;
    }

    .newbrand .custom-file-input-wrapper input[type="file"],
    .newcategory .custom-file-input-wrapper input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        z-index: -2;
        cursor: pointer;
    }

    .newbrand .custom-file-input-wrapper::before,
    .newcategory .custom-file-input-wrapper::before {
        content: "";
        position: absolute;
        margin: 0px 118px 0px auto;
        width: 20px;
        height: 20px;
        background-image: url("../icons/upload-photo-icon.svg");
        background-size: cover;
        background-position: center;
    }

    .newbrand .custom-file-input-wrapper::after,
    .newcategory .custom-file-input-wrapper::after {
        content: "Upload Photo";
        margin-right: -20px !important;
    }

    .newbrand .upload p,
    .newcategory .upload p {
        font-size: 12px;
        color: #777;
    }
</style>

<div class="newbrand" id="supplierCreateModal" style="display: none;">
    <div class="newbrand-content" style="width: 650px; max-width: 95%; margin: auto; border-radius: 12px; background: #fff; padding: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
        <a class="close-btn closes" style="position: absolute; right: 20px; top: 20px; cursor: pointer; font-size: 20px;">
            <i class="fa-solid fa-xmark"></i>
        </a>
        <h2 style="font-size: 22px; font-weight: 600; text-align: center; margin-bottom: 20px; color: #192045;">Add New Supplier</h2>
        <div id="popup-modal">
                    <form onsubmit="return SupplierDataSave(event)" id="supplierCreateForm">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-row">
                                    <input type="text" placeholder="Enter Supplier Name *" id="supplierName" required />
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-row">
                                    <input type="text" placeholder="Enter Supplier Mobile *" id="supplierMobile" required />
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-row">
                                    <input type="text" placeholder="Enter Supplier Company" id="supplierCompany" />
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-row">
                                    <input type="text" placeholder="Enter Supplier Address" id="supplierAddress" />
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-row">
                                    <input type="email" placeholder="Enter Supplier Email" id="supplierEmail" />
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-row">
                                    <input type="number" step="any" placeholder="Enter Purchase Payable Amount" id="supplierPurchasePayableAmount" />
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-row">
                                    <select class="form-select input-style" id="supplierStatus">
                                        <option value="Active" selected>Active</option>
                                        <option value="InActive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Upload Photo moved to bottom -->
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <div class="upload-profile">
                                        <div class="item">
                                            <div class="img-box">
                                                <svg width="32" height="32" viewBox="0 0 50 50" fill="red"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <rect width="50" height="50" fill="url(#pattern0_1204_6)"
                                                        fill-opacity="0.5" />
                                                    <defs>
                                                        <pattern id="pattern0_1204_6"
                                                            patternContentUnits="objectBoundingBox" width="1"
                                                            height="1">
                                                            <use xlink:href="#image0_1204_6" transform="scale(0.005)" />
                                                        </pattern>
                                                        <image id="image0_1204_6" width="200" height="200"
                                                            xlink:href="data:image/png;base64,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" />
                                                    </defs>
                                                </svg>
                                            </div>

                                            <div class="profile-wrapper">
                                                <label class="custom-file-input-wrapper">
                                                    <input type="file" class="custom-file-input" id="supplierImage"
                                                        aria-label="Upload Photo" />
                                                </label>
                                                <p>PNG, JPEG or GIF (up to 1 MB)</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="actions mt-3">
                                <button type="button" onclick="SupplierDataSave(event)" class="btn-save save-btn">Submit</button>
                            </div>
                        </div>
                    </form>
    </div>
</div>

<script>
    async function SupplierDataSave(event) {
        if (event) event.preventDefault();
        try {
            let ProductImageInput = document.getElementById('supplierImage')?.files[0];
            let supplierName = document.getElementById('supplierName')?.value?.trim() || '';
            let supplierCompany = document.getElementById('supplierCompany')?.value?.trim() || '';
            let supplierMobile = document.getElementById('supplierMobile')?.value?.trim() || '';
            let supplierAddress = document.getElementById('supplierAddress')?.value?.trim() || '';
            let supplierEmail = document.getElementById('supplierEmail')?.value?.trim() || '';
            let supplierStatus = document.getElementById('supplierStatus')?.value?.trim() || 'Active';
            let PurchasePayableAmount = document.getElementById('supplierPurchasePayableAmount')?.value?.trim() || '0';

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
            formData.append('company', supplierCompany);
            formData.append('mobile', supplierMobile);
            formData.append('address', supplierAddress);
            formData.append('email', supplierEmail);
            formData.append('purchase_payable_amount', PurchasePayableAmount || 0);
            formData.append('status', supplierStatus || 'Active');
            if (ProductImageInput) {
                formData.append('img_url', ProductImageInput);
            }

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            let res = await axios.post("/api/create-supplier", formData, config);

            if (res.data['status'] === "success") {
                successToast(res.data['message']);

                // Reset form
                const suppForm = document.getElementById("supplierCreateForm") || document.querySelector('#supplierCreateModal form');
                if (suppForm) suppForm.reset();

                // Close modal immediately
                closeModal();

                // Refresh supplier dropdown/list if available
                const newSupplierId = res.data.supplier ? res.data.supplier.id : null;
                if (typeof refreshSupplierList === 'function') {
                    await refreshSupplierList(newSupplierId);
                } else if (typeof getList === 'function' && window.location.pathname.includes('supplier')) {
                    await getList();
                } else {
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }
            } else {
                errorToast(res.data['message']);
            }
        } catch (e) {
            console.error("Supplier Save Error:", e);
            unauthorized(e.response ? e.response.status : 500);
        }
        return false;
    }

    function openSupplierCreateModal() {
        const suppModal = document.getElementById('supplierCreateModal') || document.getElementById('myModal');
        if (suppModal) {
            if (suppModal.parentNode && suppModal.parentNode !== document.body) {
                document.body.appendChild(suppModal);
            }
            suppModal.classList.add('show');
            suppModal.classList.add('show-modal');
            suppModal.style.setProperty('display', 'flex', 'important');
            suppModal.style.opacity = '1';
            suppModal.style.visibility = 'visible';
        }
    }

    function closeModal(modal) {
        if (!modal) modal = document.getElementById('supplierCreateModal') || document.getElementById('myModal');
        if (modal) {
            modal.classList.remove('show');
            modal.classList.remove('show-modal');
            modal.style.setProperty('display', 'none', 'important');
            modal.style.opacity = '0';
            modal.style.visibility = 'hidden';
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const suppModal = document.getElementById('supplierCreateModal') || document.getElementById('myModal');
        if (suppModal) {
            if (suppModal.parentNode && suppModal.parentNode !== document.body) {
                document.body.appendChild(suppModal);
            }

            document.querySelectorAll('#openModalBtns, .create-invoice').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (btn.innerText.includes('Supplier') || window.location.pathname.includes('supplier')) {
                        e.preventDefault();
                        openSupplierCreateModal();
                    }
                });
            });

            document.querySelectorAll('#supplierCreateModal .closes, #myModal .closes').forEach(btn => {
                btn.addEventListener('click', () => {
                    closeModal(suppModal);
                });
            });

            // Close on backdrop click
            suppModal.addEventListener('click', function(e) {
                if (e.target === suppModal || e.target.classList.contains('page-content')) {
                    closeModal(suppModal);
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && (suppModal.classList.contains('show') || suppModal.classList.contains('show-modal'))) {
                    closeModal(suppModal);
                }
            });
        }
    });

    // Prevent Bootstrap focus trap from stealing focus from nested supplier modal inputs
    document.addEventListener('focusin', function(e) {
        const suppModal = document.getElementById('supplierCreateModal') || document.getElementById('myModal');
        if (suppModal && (suppModal.classList.contains('show') || suppModal.classList.contains('show-modal'))) {
            if (suppModal.contains(e.target)) {
                e.stopImmediatePropagation();
            }
        }
    }, true);
</script>
