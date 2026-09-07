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
        padding: 0 !important;
        overflow: hidden !important;
        border-radius: 16px !important;
        width: 650px !important;
        max-width: 95% !important;
        max-height: 90vh !important;
        display: flex !important;
        flex-direction: column !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4) !important;
        margin: auto !important;
        text-align: left !important;
    }

    /* Dark Mode Rules for Supplier Create Modal */
    body[light-mode="dark"] #supplierCreateModal .newbrand-content,
    html[light-mode="dark"] #supplierCreateModal .newbrand-content,
    body[data-layout-mode="dark"] #supplierCreateModal .newbrand-content,
    html.dark #supplierCreateModal .newbrand-content,
    body.dark #supplierCreateModal .newbrand-content,
    body.dark-mode #supplierCreateModal .newbrand-content,
    [data-theme="dark"] #supplierCreateModal .newbrand-content {
        background-color: #0f172a !important;
        border: 1px solid #334155 !important;
        color: #f8fafc !important;
    }

    body[light-mode="dark"] #supplierCreateModal #popup-modal,
    html[light-mode="dark"] #supplierCreateModal #popup-modal,
    body[data-layout-mode="dark"] #supplierCreateModal #popup-modal,
    html.dark #supplierCreateModal #popup-modal,
    body.dark #supplierCreateModal #popup-modal,
    body.dark-mode #supplierCreateModal #popup-modal,
    [data-theme="dark"] #supplierCreateModal #popup-modal {
        background-color: #0f172a !important;
    }

    body[light-mode="dark"] #supplierCreateModal .modal-footer-sticky,
    html[light-mode="dark"] #supplierCreateModal .modal-footer-sticky,
    body[data-layout-mode="dark"] #supplierCreateModal .modal-footer-sticky,
    html.dark #supplierCreateModal .modal-footer-sticky,
    body.dark #supplierCreateModal .modal-footer-sticky,
    body.dark-mode #supplierCreateModal .modal-footer-sticky,
    [data-theme="dark"] #supplierCreateModal .modal-footer-sticky {
        background-color: #0f172a !important;
        border-top-color: #334155 !important;
    }

    .form-label-title {
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #334155 !important;
        margin-bottom: 6px !important;
        display: block !important;
        line-height: 1.3 !important;
    }
    body[light-mode="dark"] #supplierCreateModal .form-label-title,
    html[light-mode="dark"] #supplierCreateModal .form-label-title,
    body[data-layout-mode="dark"] #supplierCreateModal .form-label-title,
    html.dark #supplierCreateModal .form-label-title,
    body.dark #supplierCreateModal .form-label-title,
    body.dark-mode #supplierCreateModal .form-label-title,
    [data-theme="dark"] #supplierCreateModal .form-label-title {
        color: #cbd5e1 !important;
    }

    #supplierCreateModal input[type="text"],
    #supplierCreateModal input[type="email"],
    #supplierCreateModal input[type="number"],
    #supplierCreateModal .form-select,
    #supplierCreateModal select {
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
    }
    #supplierCreateModal input:focus,
    #supplierCreateModal .form-select:focus,
    #supplierCreateModal select:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.2) !important;
    }

    body[light-mode="dark"] #supplierCreateModal input[type="text"],
    body[light-mode="dark"] #supplierCreateModal input[type="email"],
    body[light-mode="dark"] #supplierCreateModal input[type="number"],
    body[light-mode="dark"] #supplierCreateModal .form-select,
    body[light-mode="dark"] #supplierCreateModal select,
    html[light-mode="dark"] #supplierCreateModal input[type="text"],
    html[light-mode="dark"] #supplierCreateModal input[type="email"],
    html[light-mode="dark"] #supplierCreateModal input[type="number"],
    html[light-mode="dark"] #supplierCreateModal .form-select,
    html[light-mode="dark"] #supplierCreateModal select,
    body[data-layout-mode="dark"] #supplierCreateModal input[type="text"],
    body[data-layout-mode="dark"] #supplierCreateModal input[type="email"],
    body[data-layout-mode="dark"] #supplierCreateModal input[type="number"],
    body[data-layout-mode="dark"] #supplierCreateModal .form-select,
    body[data-layout-mode="dark"] #supplierCreateModal select,
    html.dark #supplierCreateModal input[type="text"],
    html.dark #supplierCreateModal input[type="email"],
    html.dark #supplierCreateModal input[type="number"],
    html.dark #supplierCreateModal .form-select,
    html.dark #supplierCreateModal select,
    body.dark #supplierCreateModal input[type="text"],
    body.dark #supplierCreateModal input[type="email"],
    body.dark #supplierCreateModal input[type="number"],
    body.dark #supplierCreateModal .form-select,
    body.dark #supplierCreateModal select,
    body.dark-mode #supplierCreateModal input[type="text"],
    body.dark-mode #supplierCreateModal input[type="email"],
    body.dark-mode #supplierCreateModal input[type="number"],
    body.dark-mode #supplierCreateModal .form-select,
    body.dark-mode #supplierCreateModal select {
        background-color: #1e293b !important;
        color: #f8fafc !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #supplierCreateModal .custom-file-input-wrapper,
    html[light-mode="dark"] #supplierCreateModal .custom-file-input-wrapper,
    body[data-layout-mode="dark"] #supplierCreateModal .custom-file-input-wrapper,
    html.dark #supplierCreateModal .custom-file-input-wrapper,
    body.dark #supplierCreateModal .custom-file-input-wrapper,
    body.dark-mode #supplierCreateModal .custom-file-input-wrapper {
        background: #1e293b !important;
        color: #cbd5e1 !important;
        border: 1px solid #334155 !important;
    }

    body[light-mode="dark"] #supplierCreateModal #supplierCreateImgBox,
    html[light-mode="dark"] #supplierCreateModal #supplierCreateImgBox,
    body[data-layout-mode="dark"] #supplierCreateModal #supplierCreateImgBox,
    html.dark #supplierCreateModal #supplierCreateImgBox,
    body.dark #supplierCreateModal #supplierCreateImgBox,
    body.dark-mode #supplierCreateModal #supplierCreateImgBox {
        background: #1e293b !important;
        border-color: #334155 !important;
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
    <div class="newbrand-content" style="width: 650px; max-width: 95%; max-height: 90vh; margin: auto; border-radius: 16px; background: #fff; padding: 0; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.4); position: relative; display: flex; flex-direction: column;">
        <!-- Sticky Green Header with White Text & Red Close Icon -->
        <div style="background-color: #15803d; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 10; border-top-left-radius: 16px; border-top-right-radius: 16px;">
            <h2 style="font-size: 18px; font-weight: 700; color: #ffffff; margin: 0; padding: 0; line-height: 1.2;">Add New Supplier</h2>
            <button type="button" onclick="closeSupplierCreateModal()" class="close-btn closes" style="width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #dc2626; color: #ffffff; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.15s ease;" title="Close">
                <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 14px;"></i>
            </button>
        </div>

        <!-- Scrollable Modal Body -->
        <div id="popup-modal" style="padding: 20px 24px; overflow-y: auto; flex: 1 1 auto; max-height: calc(90vh - 130px); text-align: left;">
            <form onsubmit="return SupplierDataSave(event)" id="supplierCreateForm">
                <div class="row">
                    <div class="col-lg-6 mb-2">
                        <label for="supplierName" class="form-label-title">Supplier Name <span style="color: #ef4444;">*</span></label>
                        <div class="form-row">
                            <input type="text" placeholder="Enter Supplier Name" id="supplierName" required />
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label for="supplierMobile" class="form-label-title">Supplier Mobile <span style="color: #ef4444;">*</span></label>
                        <div class="form-row">
                            <input type="text" placeholder="Enter Supplier Mobile" id="supplierMobile" required />
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label for="supplierCompany" class="form-label-title">Supplier Company</label>
                        <div class="form-row">
                            <input type="text" placeholder="Enter Supplier Company" id="supplierCompany" />
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label for="supplierAddress" class="form-label-title">Supplier Address</label>
                        <div class="form-row">
                            <input type="text" placeholder="Enter Supplier Address" id="supplierAddress" />
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label for="supplierEmail" class="form-label-title">Supplier Email</label>
                        <div class="form-row">
                            <input type="email" placeholder="Enter Supplier Email" id="supplierEmail" />
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label for="supplierPurchasePayableAmount" class="form-label-title">Purchase Payable Amount</label>
                        <div class="form-row">
                            <input type="number" step="any" placeholder="Enter Purchase Payable Amount" id="supplierPurchasePayableAmount" />
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label for="supplierStatus" class="form-label-title">Status <span style="color: #ef4444;">*</span></label>
                        <div class="form-row">
                            <select class="form-select input-style" id="supplierStatus" style="cursor: pointer !important;">
                                <option value="Active" selected>Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Upload Photo -->
                    <div class="col-lg-12 mb-1">
                        <label class="form-label-title">Supplier Image</label>
                        <div class="upload-profile">
                            <div class="item" style="display: flex; align-items: center; gap: 14px;">
                                <div class="img-box" id="supplierCreateImgBox" style="width: 80px; height: 70px; min-width: 80px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1.5px dashed #cbd5e1;">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                </div>

                                <div class="profile-wrapper" style="flex: 1;">
                                    <label class="custom-file-input-wrapper" style="cursor: pointer;">
                                        <input type="file" class="custom-file-input" id="supplierImage"
                                            aria-label="Upload Photo" accept="image/*" style="cursor: pointer;" />
                                    </label>
                                    <p style="margin: 4px 0 0 0; font-size: 11px; color: #94a3b8;">PNG, JPEG or GIF (up to 1 MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sticky Bottom Footer with Submit Button -->
        <div style="padding: 12px 24px 16px; background: #ffffff; border-top: 1px solid #f1f5f9; flex-shrink: 0; position: sticky; bottom: 0; z-index: 10;" class="modal-footer-sticky">
            <button type="button" onclick="SupplierDataSave(event)" class="btn-save save-btn" style="width: 100% !important; height: 42px !important; background-color: #15803d !important; color: #ffffff !important; border-radius: 8px !important; font-weight: 600 !important; font-size: 15px !important; border: none !important; cursor: pointer !important; display: flex; align-items: center; justify-content: center; transition: background-color 0.2s ease;">Submit</button>
        </div>
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

    const defaultSupplierSvg = `<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
        <circle cx="8.5" cy="8.5" r="1.5"></circle>
        <polyline points="21 15 16 10 5 21"></polyline>
    </svg>`;

    function resetSupplierCreateModal() {
        const suppForm = document.getElementById("supplierCreateForm") || document.querySelector('#supplierCreateModal form');
        if (suppForm) suppForm.reset();
        const imgBox = document.getElementById('supplierCreateImgBox');
        if (imgBox) imgBox.innerHTML = defaultSupplierSvg;
    }

    function closeModal(modal) {
        if (!modal) modal = document.getElementById('supplierCreateModal') || document.getElementById('myModal');
        if (modal) {
            modal.classList.remove('show');
            modal.classList.remove('show-modal');
            modal.style.setProperty('display', 'none', 'important');
            modal.style.opacity = '0';
            modal.style.visibility = 'hidden';
            resetSupplierCreateModal();
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const fileInput = document.getElementById('supplierImage');
        const imgBox = document.getElementById('supplierCreateImgBox');
        if (fileInput && imgBox) {
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imgBox.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;" />`;
                    };
                    reader.readAsDataURL(file);
                } else {
                    imgBox.innerHTML = defaultSupplierSvg;
                }
            });
        }

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

            document.querySelectorAll('#supplierCreateModal .closes, #myModal .closes, #supplierCreateModal .close-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    closeSupplierCreateModal();
                });
            });

            // Close on backdrop click
            suppModal.addEventListener('click', function(e) {
                const content = suppModal.querySelector('.newbrand-content');
                if (e.target === suppModal || (content && !content.contains(e.target))) {
                    closeSupplierCreateModal();
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && (suppModal.classList.contains('show') || suppModal.classList.contains('show-modal') || suppModal.style.display === 'flex')) {
                    closeSupplierCreateModal();
                }
            });
        }
    });

    function closeSupplierCreateModal() {
        const modal = document.getElementById('supplierCreateModal') || document.getElementById('myModal');
        if (modal) {
            modal.style.setProperty('display', 'none', 'important');
            modal.style.setProperty('opacity', '0', 'important');
            modal.style.setProperty('visibility', 'hidden', 'important');
            modal.classList.remove('show');
            modal.classList.remove('show-modal');
            const form = document.getElementById('supplierCreateForm') || document.getElementById('signup');
            if (form) form.reset();
        }
    }

    // Prevent Bootstrap focus trap from stealing focus from nested supplier modal inputs
    document.addEventListener('focusin', function(e) {
        const suppModal = document.getElementById('supplierCreateModal') || document.getElementById('myModal');
        if (suppModal && (suppModal.classList.contains('show') || suppModal.classList.contains('show-modal') || suppModal.style.display === 'flex')) {
            if (suppModal.contains(e.target)) {
                e.stopImmediatePropagation();
            }
        }
    }, true);
</script>
