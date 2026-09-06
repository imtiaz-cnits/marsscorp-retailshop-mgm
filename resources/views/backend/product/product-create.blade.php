<style>
    .financemodal .modal-content {
        /* margin: 100px 0px 100px 0px; */
        border-radius: 10px;
        width: 60%;
    }

    @media screen and (max-width: 992px) {
        .financemodal .modal-content {
            width: 90%;
            /* margin: 400px 0px 100px 0px; */


        }
    }

    .financemodal .modal-content .col-lg-6,
    .financemodal .modal-content .col-lg-4 {
        padding: 0 6px !important;
    }

    #createProduct.financemodal,
    .financemodal {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        margin: 0 !important;
        margin-left: 0 !important;
        padding: 20px 10px !important;
        box-sizing: border-box !important;
        background: rgba(15, 23, 42, 0.65) !important;
        backdrop-filter: blur(8px) !important;
        -webkit-backdrop-filter: blur(8px) !important;
        z-index: 99999 !important;
        display: none;
        overflow-y: auto !important;
    }

    #createProduct.financemodal.show,
    #createProduct.financemodal.show-modal,
    .financemodal.show,
    .financemodal.show-modal {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }

    #createProduct .modal-content,
    .financemodal .modal-content {
        position: relative !important;
        top: auto !important;
        left: auto !important;
        transform: none !important;
        margin: auto !important;
        max-height: 90vh !important;
        overflow-y: auto !important;
        border-radius: 12px !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35) !important;
    }

    /* Custom Searchable Select Dropdowns (Identical to POS Page) */
    .custom-searchable-select {
        position: relative;
        flex: 1;
        min-width: 0;
        z-index: 1;
    }

    .custom-searchable-select.is-open {
        z-index: 9999 !important;
        position: relative !important;
    }

    #createProduct .col-lg-6:has(.custom-searchable-select.is-open),
    #createProduct .col-lg-6.has-open-dropdown {
        z-index: 9999 !important;
        position: relative !important;
    }

    .custom-searchable-select .select-trigger {
        height: 42px;
        border-radius: 8px;
        cursor: pointer !important;
        border: 1px solid #d1d5db !important;
        background: #ffffff;
        transition: all 0.2s ease;
        user-select: none;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 14px;
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
    }

    .custom-searchable-select .select-trigger:hover {
        border-color: #16a34a !important;
    }

    .custom-searchable-select.is-open .select-trigger {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.15) !important;
    }

    .custom-searchable-select .select-menu {
        display: none;
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        width: 100%;
        min-width: 100%;
        z-index: 99999 !important;
        background: #ffffff !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 10px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.25), 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        padding: 6px;
    }

    .custom-searchable-select.is-open .select-menu {
        display: block !important;
    }

    .custom-searchable-select .search-wrap {
        padding: 4px 6px;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 4px;
        position: relative;
        background: #ffffff !important;
        z-index: 2;
    }

    .custom-searchable-select .search-wrap input {
        height: 34px !important;
        font-size: 13px !important;
        border-radius: 6px !important;
        border: 1px solid #cbd5e1 !important;
        padding-left: 30px !important;
        padding-right: 8px !important;
        width: 100% !important;
        outline: none !important;
        box-sizing: border-box !important;
        background: #ffffff !important;
    }

    .custom-searchable-select .search-wrap input:focus {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.1) !important;
    }

    .custom-searchable-select .select-options-list {
        max-height: 180px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }

    .custom-searchable-select .select-options-list::-webkit-scrollbar {
        width: 4px;
    }
    .custom-searchable-select .select-options-list::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .custom-searchable-select .select-option-item {
        padding: 8px 10px;
        font-size: 13px;
        cursor: pointer !important;
        border-radius: 6px;
        margin: 1px 2px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #334155;
        transition: all 0.15s ease;
        user-select: none;
    }

    .custom-searchable-select .select-option-item:hover {
        background-color: #f0fdf4;
        color: #15803d;
    }

    .custom-searchable-select .select-option-item.active {
        background-color: #dcfce7;
        color: #15803d;
        font-weight: 700;
    }

    /* General pointer cursor for select fields in modal */
    #createProduct select,
    .financemodal select,
    .financemodal .form-row select,
    .btn-add {
        cursor: pointer !important;
    }

    /* Dark mode support */
    body[light-mode="dark"] .custom-searchable-select .select-trigger {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .custom-searchable-select .select-trigger .selected-text {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .custom-searchable-select .select-menu {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.6) !important;
    }
    body[light-mode="dark"] .custom-searchable-select .search-wrap {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .custom-searchable-select .search-wrap input {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .custom-searchable-select .select-option-item {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .custom-searchable-select .select-option-item:hover {
        background-color: #334155 !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] .custom-searchable-select .select-option-item.active {
        background-color: rgba(22, 163, 74, 0.25) !important;
        color: #4ade80 !important;
    }

    /* Clean Modern Modal Styling for Add New Brand & Add New Category */
    .newbrand,
    .newcategory {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        margin: 0 !important;
        margin-left: 0 !important;
        padding: 0 !important;
        background: rgba(15, 23, 42, 0.6) !important;
        display: none;
        justify-content: center !important;
        align-items: center !important;
        z-index: 999999 !important;
        backdrop-filter: blur(4px);
    }

    .newbrand.show,
    .newcategory.show {
        display: flex !important;
    }

    .newbrand-content,
    .newcategory-content {
        position: relative !important;
        top: auto !important;
        left: auto !important;
        right: auto !important;
        bottom: auto !important;
        transform: none !important;
        margin: auto !important;
        background: #ffffff !important;
        padding: 24px 28px !important;
        border-radius: 16px !important;
        width: 440px !important;
        max-width: 90vw !important;
        max-height: 90vh !important;
        overflow-y: auto !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
        border: 1px solid #f1f5f9;
    }

    /* Modal Header */
    .newmodal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .newmodal-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .newmodal-close-btn {
        background: #f1f5f9;
        color: #64748b;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .newmodal-close-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Image Upload Area */
    .newmodal-upload-area {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
        background: #f8fafc;
        padding: 14px;
        border-radius: 12px;
        border: 1px dashed #cbd5e1;
    }

    .newmodal-img-preview {
        width: 72px;
        height: 72px;
        border-radius: 10px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .newmodal-img-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .newmodal-img-preview i {
        font-size: 26px;
        color: #94a3b8;
    }

    .newmodal-upload-info {
        flex: 1;
    }

    .newmodal-file-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 14px;
        background: #ffffff;
        color: #334155;
        font-size: 13px;
        font-weight: 600;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .newmodal-file-btn:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }

    .newmodal-upload-info p {
        margin: 6px 0 0 0;
        font-size: 11px;
        color: #64748b;
    }

    /* Form Fields */
    .newmodal-form-group {
        margin-bottom: 16px;
    }

    .newmodal-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }

    .newmodal-input,
    .newmodal-select {
        width: 100%;
        height: 42px;
        padding: 8px 14px;
        font-size: 14px;
        color: #1e293b;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        outline: none;
        transition: all 0.2s ease;
    }

    .newmodal-input:focus,
    .newmodal-select:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15);
    }

    .newmodal-select-wrapper {
        position: relative;
        width: 100%;
    }

    .newmodal-select-wrapper select {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 36px;
    }

    .newmodal-select-wrapper i {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: #64748b;
        font-size: 12px;
    }

    /* Action Buttons */
    .newmodal-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 22px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    .newmodal-btn-cancel {
        padding: 9px 18px;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .newmodal-btn-cancel:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    .newmodal-btn-save {
        padding: 9px 22px;
        font-size: 13px;
        font-weight: 600;
        color: #ffffff;
        background: linear-gradient(135deg, #16a34a, #15803d);
        border: none;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);
        transition: all 0.2s ease;
    }

    .newmodal-btn-save:hover {
        background: linear-gradient(135deg, #15803d, #166534);
        box-shadow: 0 6px 16px rgba(22, 163, 74, 0.35);
        transform: translateY(-1px);
    }

    /* Door Handedness Selector Styles */
    .door-hand-card {
        cursor: pointer;
        padding: 10px 14px;
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
        user-select: none;
    }

    .door-hand-card:hover {
        border-color: #86efac;
        background: #f0fdf4;
    }

    .door-hand-radio:checked+.door-hand-card {
        background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important;
        border-color: #15803d !important;
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3) !important;
    }

    .door-hand-radio:checked+.door-hand-card .door-hand-text {
        color: #ffffff !important;
    }

    .door-hand-radio:checked+.door-hand-card .door-hand-icon {
        transform: scale(1.15);
    }

    /* Product Image Upload & Preview */
    #createProduct .upload-profile .item .img-box {
        width: 84px !important;
        height: 70px !important;
        border-radius: 8px !important;
        background: #f8fafc !important;
        border: 1.5px dashed #cbd5e1 !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        overflow: hidden !important;
        position: relative !important;
        flex-shrink: 0 !important;
    }

    #createProduct #ProductImagePreview {
        width: 100% !important;
        height: 100% !important;
        min-width: 100% !important;
        min-height: 100% !important;
        max-width: 100% !important;
        max-height: 100% !important;
        object-fit: cover !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        border-radius: 7px !important;
        z-index: 10 !important;
        display: none;
    }

    #createProduct .upload-profile .item .img-box img {
        width: 100% !important;
        height: 100% !important;
        max-width: 100% !important;
        max-height: 100% !important;
        object-fit: cover !important;
    }

    #createProduct .upload-profile .item .custom-file-input-wrapper {
        cursor: pointer !important;
    }
</style>

<!-- Create Product Modal Start -->
<section id="createProduct" class="financemodal">
    <div class="modal-content border-0 shadow-lg d-flex flex-column" style="border-radius: 16px; overflow: hidden; background: #ffffff; padding: 0 !important; max-width: 750px; width: 95%; max-height: 90vh;">
        <!-- POS Style Primary Green Sticky Header -->
        <div class="modal-header text-white py-2.5 px-4 d-flex align-items-center justify-content-between flex-shrink-0" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border-bottom: 1px solid rgba(255,255,255,0.1); position: sticky; top: 0; z-index: 20;">
            <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2 m-0 fs-5">
                <i class="fa-solid fa-cart-plus me-1"></i> Add New Product
            </h5>
            <button type="button" class="close-btn closes d-flex align-items-center justify-content-center border-0 shadow-sm" onclick="closeProductModal()" style="width: 24px; height: 24px; border-radius: 50%; background: #ef4444; color: #ffffff; font-size: 11px; cursor: pointer; transition: all 0.2s ease;" title="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Scrollable Form Body -->
        <div id="popup-modal" style="padding: 18px 24px; overflow-y: auto; flex: 1 1 auto; max-height: calc(90vh - 120px);">
            <form onsubmit="return ProductDataSave(event)" id="signup">
                <!-- Select Dropdowns with Add Buttons -->
                <div class="row g-2.5">
                    <div class="col-lg-6">
                        <div class="form-row flex-column align-items-start gap-1">
                            <label for="ProductBrand" class="fw-bold small" style="color: #334155; display: block; margin-bottom: 0px !important; font-size: 13px;">Brand</label>
                            <div class="d-flex align-items-center w-100 gap-2">
                                <!-- Native select kept hidden for 100% backend & DOM compatibility -->
                                <select class="form-select input-style d-none" id="ProductBrand"
                                    aria-label="Default select example">
                                    <option value="none">Select Brand</option>
                                </select>

                                <!-- Custom Searchable Brand Dropdown (Identical to POS Page) -->
                                <div class="custom-searchable-select flex-grow-1" id="createBrandDropdown">
                                    <div class="select-trigger d-flex align-items-center justify-content-between px-3" onclick="toggleCustomProductDropdown('createBrandDropdown')">
                                        <span class="selected-text text-truncate" style="font-size: 14px; font-weight: 500; color: #64748b;">Select Brand</span>
                                        <i class="fa-solid fa-chevron-down ms-1 text-muted" style="font-size: 12px; transition: transform 0.2s;"></i>
                                    </div>
                                    <div class="select-menu">
                                        <div class="search-wrap">
                                            <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="top: 50%; transform: translateY(-50%); left: 10px; font-size: 12px;"></i>
                                            <input type="text" placeholder="Search Brand..." oninput="filterCustomProductDropdown('createBrandDropdown', this.value)">
                                        </div>
                                        <div class="select-options-list">
                                            <!-- Brand options will load here -->
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn-add newbrand-open text-nowrap" style="height: 42px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; border-radius: 8px; font-weight: 600;">+ Add</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-row flex-column align-items-start gap-1">
                            <label for="ProductCategoryDataID" class="fw-bold small" style="color: #334155; display: block; margin-bottom: 0px !important; font-size: 13px;">Category <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center w-100 gap-2">
                                <!-- Native select kept hidden for 100% backend & DOM compatibility -->
                                <select class="d-none" id="ProductCategoryDataID">
                                    <option value="none" selected>Select Category</option>
                                </select>

                                <!-- Custom Searchable Category Dropdown (Identical to POS Page) -->
                                <div class="custom-searchable-select flex-grow-1" id="createCategoryDropdown">
                                    <div class="select-trigger d-flex align-items-center justify-content-between px-3" onclick="toggleCustomProductDropdown('createCategoryDropdown')">
                                        <span class="selected-text text-truncate" style="font-size: 14px; font-weight: 500; color: #64748b;">Select Category <span class="text-danger">*</span></span>
                                        <i class="fa-solid fa-chevron-down ms-1 text-muted" style="font-size: 12px; transition: transform 0.2s;"></i>
                                    </div>
                                    <div class="select-menu">
                                        <div class="search-wrap">
                                            <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="top: 50%; transform: translateY(-50%); left: 10px; font-size: 12px;"></i>
                                            <input type="text" placeholder="Search Category..." oninput="filterCustomProductDropdown('createCategoryDropdown', this.value)">
                                        </div>
                                        <div class="select-options-list">
                                            <!-- Category options will load here -->
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn-add newcategory-open text-nowrap" style="height: 42px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; border-radius: 8px; font-weight: 600;">
                                    + Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Door Handedness Dynamic Selection & Quantity Inputs (Shown only when Door category is selected) -->
                <div class="row mt-2" id="doorHandednessContainer" style="display: none;">
                    <div class="col-lg-12">
                        <div class="p-3 mb-2 rounded-3" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border: 1.5px dashed #86efac;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="fw-bold text-success m-0 d-flex align-items-center gap-2" style="font-size: 13px;">
                                    <i class="fa-solid fa-door-open fs-5 text-success"></i>
                                    <span>Door Handedness & Specific Quantities</span>
                                </label>
                                <span class="badge bg-success text-white px-2 py-1 small fw-bold" id="createDoorTotalBadge">Total Door Stock: 0</span>
                            </div>
                            <div class="row g-2 mt-1">
                                <!-- Left Handed Card & Qty Input -->
                                <div class="col-md-4 col-12">
                                    <div class="door-hand-box-create rounded-3 bg-white border border-2 border-slate-200 shadow-sm text-center" style="border-radius: 10px; padding: 10px 12px;">
                                        <div class="d-flex align-items-center justify-content-center gap-1.5 mb-2 text-primary fw-bold" style="font-size: 13px;">
                                            <span class="fs-5">👈</span>
                                            <span>Left Handed</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <label for="createDoorQtyLeft" class="fw-bold text-secondary m-0" style="font-size: 12px; letter-spacing: 0.5px;">QTY:</label>
                                            <input type="number" min="0" step="any" id="createDoorQtyLeft" class="form-control text-center fw-bold text-dark door-qty-input-create" placeholder="0" oninput="calculateCreateDoorTotal()" style="font-size: 14px; height: 36px; max-width: 130px; border-radius: 8px;">
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Handed Card & Qty Input -->
                                <div class="col-md-4 col-12">
                                    <div class="door-hand-box-create rounded-3 bg-white border border-2 border-slate-200 shadow-sm text-center" style="border-radius: 10px; padding: 10px 12px;">
                                        <div class="d-flex align-items-center justify-content-center gap-1.5 mb-2 text-success fw-bold" style="font-size: 13px;">
                                            <span class="fs-5">👉</span>
                                            <span>Right Handed</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <label for="createDoorQtyRight" class="fw-bold text-secondary m-0" style="font-size: 12px; letter-spacing: 0.5px;">QTY:</label>
                                            <input type="number" min="0" step="any" id="createDoorQtyRight" class="form-control text-center fw-bold text-dark door-qty-input-create" placeholder="0" oninput="calculateCreateDoorTotal()" style="font-size: 14px; height: 36px; max-width: 130px; border-radius: 8px;">
                                        </div>
                                    </div>
                                </div>

                                <!-- Both / Universal Card & Qty Input -->
                                <div class="col-md-4 col-12">
                                    <div class="door-hand-box-create rounded-3 bg-white border border-2 border-slate-200 shadow-sm text-center" style="border-radius: 10px; padding: 10px 12px;">
                                        <div class="d-flex align-items-center justify-content-center gap-1.5 mb-2 text-info fw-bold" style="font-size: 13px;">
                                            <span class="fs-5">↔️</span>
                                            <span>Both / Universal</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <label for="createDoorQtyBoth" class="fw-bold text-secondary m-0" style="font-size: 12px; letter-spacing: 0.5px;">QTY:</label>
                                            <input type="number" min="0" step="any" id="createDoorQtyBoth" class="form-control text-center fw-bold text-dark door-qty-input-create" placeholder="0" oninput="calculateCreateDoorTotal()" style="font-size: 14px; height: 36px; max-width: 130px; border-radius: 8px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="selectedDoorSide" value="">
                        </div>
                    </div>
                </div>

                <div class="row mt-2 g-2.5">
                    <div class="col-lg-12">
                        <div class="upload-profile">
                            <label class="fw-bold small" style="color: #334155; display: block; margin-bottom: 6px !important; font-size: 13px;">Product Photo</label>
                            <div class="item align-items-center">
                                <div class="img-box" id="ProductImageBox" title="Product Image Preview" style="width: 84px; height: 70px; border-radius: 8px; background: #f8fafc; border: 1.5px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; position: relative;">
                                    <div id="ProductImageDefaultIcon" class="d-flex align-items-center justify-content-center w-100 h-100">
                                        <i class="fa-regular fa-image fs-3 text-secondary"></i>
                                    </div>
                                    <img id="ProductImagePreview" src="" alt="Product Preview" style="width: 100% !important; height: 100% !important; min-width: 100% !important; min-height: 100% !important; max-width: 100% !important; max-height: 100% !important; object-fit: cover !important; position: absolute !important; top: 0 !important; left: 0 !important; z-index: 10 !important; border-radius: 7px !important; display: none;" />
                                </div>

                                <div class="profile-wrapper">
                                    <label class="custom-file-input-wrapper mb-1">
                                        <input type="file" class="custom-file-input" id="ProductImage"
                                            accept="image/*" onchange="previewProductImage(event)" aria-label="Upload Photo" />
                                    </label>
                                    <div id="ProductImageFileInfo" class="mt-1" style="font-size: 12px; color: #64748b; line-height: 1.4;">
                                        <span>PNG, JPEG or GIF (up to 1 MB)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mt-2">
                        <div class="form-row flex-column align-items-start gap-1">
                            <label for="ProductName" class="fw-bold small" style="color: #334155; display: block; margin-bottom: 0px !important; font-size: 13px;">Product Name <span class="text-danger">*</span></label>
                            <input type="text" placeholder="Product Name *" id="ProductName" class="form-control" style="width: 100%; height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;" />
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-row flex-column align-items-start gap-1">
                            <label for="ProductQuantity" class="fw-bold small" style="color: #334155; display: block; margin-bottom: 0px !important; font-size: 13px;">Product Quantity</label>
                            <input type="text" placeholder="Quantity" id="ProductQuantity" class="form-control" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-row flex-column align-items-start gap-1">
                            <label for="ProductCostPrice" class="fw-bold small" style="color: #334155; display: block; margin-bottom: 0px !important; font-size: 13px;">Cost Price</label>
                            <input type="text" placeholder="Cost Price" id="ProductCostPrice" class="form-control" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-row flex-column align-items-start gap-1">
                            <label for="ProductSellingPrice" class="fw-bold small" style="color: #334155; display: block; margin-bottom: 0px !important; font-size: 13px;">Selling Price</label>
                            <input type="text" placeholder="Selling Price" id="ProductSellingPrice" class="form-control" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;" />
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-row flex-column align-items-start gap-1">
                            <label for="ProductCodeInput" class="fw-bold small" style="color: #334155; display: block; margin-bottom: 0px !important; font-size: 13px;">Barcode / Product Code</label>
                            <div class="d-flex align-items-center gap-2 w-100">
                                <input type="text" id="ProductCodeInput" class="form-control" placeholder="Enter or scan barcode..." style="flex: 1; height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;" />
                                <button type="button" class="btn text-white fw-bold text-nowrap d-flex align-items-center gap-2 px-3 shadow-sm" onclick="openProductCreateCameraScanner()" style="height: 42px; border-radius: 8px; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none;">
                                    <i class="fa-solid fa-camera fs-5"></i>
                                    <span class="d-none d-sm-inline">Camera Scan</span>
                                </button>
                            </div>
                        </div>
                        <div id="BarcodeContainer" class="d-flex flex-wrap gap-2 mt-2 mb-1"></div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sticky Footer (Fixed at Bottom) -->
        <div class="modal-footer px-4 py-2.5 bg-white d-flex align-items-center justify-content-end gap-2 flex-shrink-0" style="position: sticky; bottom: 0; z-index: 20; border-top: 1px solid #e2e8f0 !important;">
            <button type="button" onclick="resetProductForm()" class="btn btn-outline-secondary px-4 fw-semibold" style="height: 40px; border-radius: 8px; font-size: 14px;">Reset</button>
            <button type="button" onclick="ProductDataSave(event)" class="btn text-white fw-bold px-5 shadow-sm" style="height: 40px; border-radius: 8px; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none; font-size: 14px;">Submit</button>
        </div>
    </div>
</section>
<!-- Create Product Modal End -->

<!-- Add Product modal to Add New Brand Modal Start -->
<div class="newbrand" id="addBrandModal">
    <div class="newbrand-content">
        <div class="newmodal-header">
            <h3>Add New Brand</h3>
            <button type="button" class="newmodal-close-btn newbrand-close" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="addBrandForm" onsubmit="BrandSave(event)">
            <div class="newmodal-upload-area">
                <div class="newmodal-img-preview" id="BrandImgBox">
                    <i class="fa-regular fa-image" id="BrandImgIcon"></i>
                    <img id="BrandImgPreview" src="" alt="Preview" style="display: none;" />
                </div>
                <div class="newmodal-upload-info">
                    <label for="CreateBrandImg" class="newmodal-file-btn">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Upload Photo
                    </label>
                    <input type="file" id="CreateBrandImg" accept="image/*" style="display: none;" />
                    <p>PNG, JPG or GIF (up to 1 MB)</p>
                </div>
            </div>

            <div class="newmodal-form-group">
                <label class="newmodal-label" for="CreateBrandName">Brand Name <span class="text-danger">*</span></label>
                <input type="text" id="CreateBrandName" class="newmodal-input" placeholder="Enter brand name" required />
            </div>

            <div class="newmodal-form-group">
                <label class="newmodal-label" for="BrandSelectStatus">Status <span class="text-danger">*</span></label>
                <div class="newmodal-select-wrapper">
                    <select id="BrandSelectStatus" class="newmodal-select" required>
                        <option value="Active" selected>Active</option>
                        <option value="InActive">Inactive</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
            </div>

            <div class="newmodal-actions">
                <button type="button" class="newmodal-btn-cancel newbrand-close">Cancel</button>
                <button type="submit" class="newmodal-btn-save">Save Brand</button>
            </div>
        </form>
    </div>
</div>
<!-- Add Product modal to New Brand Modal End -->

<!-- Add Product modal to New Category Modal Start -->
<div class="newcategory" id="addCategoryModal">
    <div class="newcategory-content">
        <div class="newmodal-header">
            <h3>Add New Category</h3>
            <button type="button" class="newmodal-close-btn newcategory-close" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="addCategoryForm" onsubmit="CategorySave(event)">
            <div class="newmodal-upload-area">
                <div class="newmodal-img-preview" id="CategoryImgBox">
                    <i class="fa-regular fa-image" id="CategoryImgIcon"></i>
                    <img id="CategoryImgPreview" src="" alt="Preview" style="display: none;" />
                </div>
                <div class="newmodal-upload-info">
                    <label for="CategoryImg" class="newmodal-file-btn">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Upload Photo
                    </label>
                    <input type="file" id="CategoryImg" accept="image/*" style="display: none;" />
                    <p>PNG, JPG or GIF (up to 1 MB)</p>
                </div>
            </div>

            <div class="newmodal-form-group">
                <label class="newmodal-label" for="CategoryName">Category Name <span class="text-danger">*</span></label>
                <input type="text" id="CategoryName" class="newmodal-input" placeholder="Enter category name" required />
            </div>

            <div class="newmodal-form-group">
                <label class="newmodal-label" for="CategorySelectStatus">Status <span class="text-danger">*</span></label>
                <div class="newmodal-select-wrapper">
                    <select id="CategorySelectStatus" class="newmodal-select" required>
                        <option value="Active" selected>Active</option>
                        <option value="InActive">Inactive</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
            </div>

            <div class="newmodal-actions">
                <button type="button" class="newmodal-btn-cancel newcategory-close">Cancel</button>
                <button type="submit" class="newmodal-btn-save">Save Category</button>
            </div>
        </form>
    </div>
</div>
<!-- Add Product modal to New Category Modal End -->


<script>
    // Save brand function
    async function BrandSave(event) {
        event.preventDefault();

        try {
            const CreateBrandName = document.getElementById('CreateBrandName').value;
            const BrandSelectStatus = document.getElementById('BrandSelectStatus').value;
            const imgInput = document.getElementById('CreateBrandImg');
            const imgFile = imgInput.files[0];

            // Validation
            if (!CreateBrandName) {
                errorToast("Brand Name is required!");
                return;
            }
            if (!BrandSelectStatus) {
                errorToast("Brand Status is required!");
                return;
            }

            // Prepare form data
            const formData = new FormData();
            formData.append('name', CreateBrandName);
            formData.append('status', BrandSelectStatus);
            formData.append('img_url', imgFile);

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    ...HeaderToken().headers,
                },
            };

            // API call to save brand
            const res = await axios.post("/api/create-brand", formData, config);

            if (res.data.status === "success") {
                successToast(res.data.message);

                // Clear the form and close the modal
                document.getElementById('CreateBrandName').value = '';
                closeBrandModal();

                // Refresh the dropdown and select the newly created brand in both Create and Update forms
                if (typeof refreshBrandList === 'function') {
                    await refreshBrandList(res.data.newBrandId);
                }
                if (typeof ProductBrandShow === 'function') {
                    await ProductBrandShow(res.data.newBrandId);
                }
            } else {
                errorToast(res.data.message);
            }
        } catch (e) {
            unauthorized(e.response?.status || 500);
        }
    }

    // Refresh brand list and optionally select the newly added brand
    async function refreshBrandList(selectedBrandId = null) {
        try {
            const res = await axios.get("/api/brand-list", HeaderToken());
            const Brand = res.data.BrandData || [];

            const optionsHtmlBrand = Brand.map(brand =>
                `<option value="${brand.id}" ${selectedBrandId == brand.id ? 'selected' : ''}>${brand.name}</option>`
            ).join('');

            const brandDropdown = document.getElementById("ProductBrand");
            if (brandDropdown) {
                brandDropdown.innerHTML = `<option value="none" selected>Select Brand</option>` + optionsHtmlBrand;
                if (selectedBrandId) {
                    brandDropdown.value = String(selectedBrandId);
                }
            }

            // Populate custom searchable brand dropdown (POS style)
            const brandCustomList = document.querySelector('#createBrandDropdown .select-options-list');
            const brandTriggerText = document.querySelector('#createBrandDropdown .selected-text');
            if (brandCustomList) {
                let currentVal = selectedBrandId ? String(selectedBrandId) : (brandDropdown ? brandDropdown.value : 'none');
                let defaultLabel = 'Select Brand';

                let html = `<div class="select-option-item ${(currentVal === 'none' || !currentVal) ? 'active' : ''}" data-value="none" data-label="Select Brand" onclick="selectCustomProductDropdownItem('createBrandDropdown', 'ProductBrand', 'none', 'Select Brand')">
                    <span>Select Brand</span>
                    ${(currentVal === 'none' || !currentVal) ? '<i class="fa-solid fa-check small text-success"></i>' : ''}
                </div>`;

                Brand.forEach(b => {
                    const isSelected = String(currentVal) === String(b.id);
                    if (isSelected) defaultLabel = b.name;
                    html += `<div class="select-option-item ${isSelected ? 'active' : ''}" data-value="${b.id}" data-label="${b.name}" onclick="selectCustomProductDropdownItem('createBrandDropdown', 'ProductBrand', '${b.id}', '${b.name}')">
                        <span>${b.name}</span>
                        ${isSelected ? '<i class="fa-solid fa-check small text-success"></i>' : ''}
                    </div>`;
                });

                brandCustomList.innerHTML = html;
                if (brandTriggerText) {
                    brandTriggerText.textContent = defaultLabel;
                    brandTriggerText.style.color = (currentVal && currentVal !== 'none') ? '#0f172a' : '#64748b';
                }
            }
        } catch (error) {
            console.error("Error occurred while fetching brands:", error);
        }
    }

    // Modal handling (open/close)
    function closeBrandModal() {
        const modal = document.getElementById('addBrandModal');
        if (modal) {
            modal.style.display = 'none';
            modal.classList.remove('show');

            const inputName = document.getElementById('CreateBrandName');
            const inputStatus = document.getElementById('BrandSelectStatus');
            const inputImg = document.getElementById('CreateBrandImg');
            const preview = document.getElementById('BrandImgPreview');
            const icon = document.getElementById('BrandImgIcon');

            if (inputName) inputName.value = '';
            if (inputStatus) inputStatus.value = 'Active';
            if (inputImg) inputImg.value = '';
            if (preview) {
                preview.src = '';
                preview.style.display = 'none';
            }
            if (icon) icon.style.display = 'block';
        }
    }

    function openBrandModal() {
        const modal = document.getElementById('addBrandModal');
        if (modal) {
            modal.style.display = 'flex';
            modal.classList.add('show');
            modal.style.zIndex = '999999';
            setTimeout(() => {
                const input = document.getElementById('CreateBrandName');
                if (input) {
                    input.focus();
                }
            }, 100);
        }
    }

    // Prevent Bootstrap modal focus trap from stealing focus from sub-modals
    document.addEventListener('focusin', function(e) {
        const brandModal = document.getElementById('addBrandModal');
        const catModal = document.getElementById('addCategoryModal');
        if ((brandModal && brandModal.classList.contains('show') && brandModal.contains(e.target)) ||
            (catModal && catModal.classList.contains('show') && catModal.contains(e.target))) {
            e.stopImmediatePropagation();
        }
    }, true);

    // Trigger modal open/close
    document.querySelectorAll('.newbrand-open').forEach(btn =>
        btn.addEventListener('click', openBrandModal)
    );
    document.querySelectorAll('.newbrand-close').forEach(btn =>
        btn.addEventListener('click', closeBrandModal)
    );


    // Initial brand list fetch
    refreshBrandList();

    // Refresh unit list
    async function refreshUnitList(selectedUnitId = null) {
        try {
            const res = await axios.get("/api/unit-list", HeaderToken());
            const units = res.data.units;

            const optionsHtmlUnit = units.map(unit =>
                `<option value="${unit.id}" ${selectedUnitId == unit.id ? 'selected' : ''}>${unit.unit_name}</option>`
            ).join('');

            const unitDropdown = document.getElementById("ProductUnit");
            if (unitDropdown) {
                unitDropdown.innerHTML = `<option value="" disabled selected>Select Unit</option>` + optionsHtmlUnit;
            }
        } catch (error) {
            console.error("Error occurred while fetching units:", error);
        }
    }

    refreshUnitList();
</script>



<script>
    // Save Category Function
    async function CategorySave(event) {
        event.preventDefault(); // Prevent form submission and reload

        try {
            const CategoryName = document.getElementById('CategoryName').value.trim();
            const CategorySelectStatus = document.getElementById('CategorySelectStatus').value;
            const imgInput = document.getElementById('CategoryImg');
            const imgFile = imgInput ? imgInput.files[0] : null;

            // Validation
            if (!CategoryName) {
                errorToast("Category Name is required!");
                return;
            }
            if (!CategorySelectStatus || CategorySelectStatus === 'Select category status') {
                errorToast("Category Status is required!");
                return;
            }

            // Prepare Form Data
            const formData = new FormData();
            formData.append('category_name', CategoryName);
            formData.append('status', CategorySelectStatus);
            if (imgFile) {
                formData.append('img_url', imgFile);
            }

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    ...HeaderToken().headers,
                },
            };

            const res = await axios.post("/api/create-category", formData, config);

            if (res.data.status === "success") {
                successToast(res.data.message);

                document.getElementById('CategoryName').value = '';
                document.getElementById('CategorySelectStatus').value = 'Select category status';
                if (imgInput) imgInput.value = '';

                closeCategoryModal();

                if (typeof refreshCategoryList === 'function') {
                    await refreshCategoryList(res.data.newCategoryId);
                }
                if (typeof ProductCategoryShow === 'function') {
                    await ProductCategoryShow(res.data.newCategoryId);
                }
            } else {
                errorToast(res.data.message || "Failed to save category.");
            }
        } catch (error) {
            console.error("Error saving category:", error);
            errorToast("An error occurred while saving the category. Please try again.");
        }
    }

    async function refreshCategoryList(selectedCategoryId = null) {
        try {
            const res = await axios.get("/api/category-list", HeaderToken());

            if (res.data.status === "success") {
                const categories = res.data.CategoryData || [];

                let optionsHtml = `<option value="none" selected>Select Category</option>`;
                optionsHtml += categories
                    .map(category => `<option value="${category.id}">${category.category_name}</option>`)
                    .join('');

                const categoryDropdown = document.getElementById("ProductCategoryDataID");
                if (categoryDropdown) {
                    categoryDropdown.innerHTML = optionsHtml;

                    if (selectedCategoryId) {
                        categoryDropdown.value = String(selectedCategoryId);
                    }

                    categoryDropdown.removeEventListener('change', handleCategoryChange);
                    categoryDropdown.addEventListener('change', handleCategoryChange);
                }

                // Populate custom searchable category dropdown (POS style)
                const catCustomList = document.querySelector('#createCategoryDropdown .select-options-list');
                const catTriggerText = document.querySelector('#createCategoryDropdown .selected-text');
                if (catCustomList) {
                    let currentVal = selectedCategoryId ? String(selectedCategoryId) : (categoryDropdown ? categoryDropdown.value : 'none');
                    let defaultLabel = 'Select Category *';

                    let html = `<div class="select-option-item ${(currentVal === 'none' || !currentVal) ? 'active' : ''}" data-value="none" data-label="Select Category" onclick="selectCustomProductDropdownItem('createCategoryDropdown', 'ProductCategoryDataID', 'none', 'Select Category *')">
                        <span>Select Category</span>
                        ${(currentVal === 'none' || !currentVal) ? '<i class="fa-solid fa-check small text-success"></i>' : ''}
                    </div>`;

                    categories.forEach(c => {
                        const isSelected = String(currentVal) === String(c.id);
                        if (isSelected) defaultLabel = c.category_name;
                        html += `<div class="select-option-item ${isSelected ? 'active' : ''}" data-value="${c.id}" data-label="${c.category_name}" onclick="selectCustomProductDropdownItem('createCategoryDropdown', 'ProductCategoryDataID', '${c.id}', '${c.category_name}')">
                            <span>${c.category_name}</span>
                            ${isSelected ? '<i class="fa-solid fa-check small text-success"></i>' : ''}
                        </div>`;
                    });

                    catCustomList.innerHTML = html;
                    if (catTriggerText) {
                        catTriggerText.textContent = defaultLabel;
                        catTriggerText.style.color = (currentVal && currentVal !== 'none') ? '#0f172a' : '#64748b';
                    }
                }
            } else {
                errorToast("Failed to update categories. Please try again.");
            }
        } catch (error) {
            console.error("Error fetching categories:", error);
            errorToast("An error occurred while updating the category list.");
        }
    }

    async function handleCategoryChange(event) {
        const categoryId = event.target.value;
        if (typeof checkDoorCategory === 'function') {
            checkDoorCategory(categoryId);
        }
        const subCategoryDropdown = document.getElementById("ProductSubCategoryID");
        if (!subCategoryDropdown) return;

        subCategoryDropdown.innerHTML = `<option value="none" selected>Select Sub Category</option>`;

        if (categoryId === "none") return;

        try {
            const res = await axios.get(`/api/sub-category-list/${categoryId}`, HeaderToken());

            if (res.data.status === "success") {
                const subCategories = res.data.subCategories;

                if (subCategories.length === 0) {
                    errorToast("No subcategories found for this category.");
                    return;
                }

                const optionsHtml = subCategories
                    .map(subCategory =>
                        `<option value="${subCategory.id}">${subCategory.sub_category_name}</option>`)
                    .join('');

                subCategoryDropdown.innerHTML += optionsHtml;
            } else {
                errorToast("No subcategories found for this category.");
            }
        } catch (error) {
            console.error("Error fetching subcategories:", error);
            errorToast("An error occurred while fetching subcategories. Please try again.");
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        refreshCategoryList();
    });

    document.addEventListener('DOMContentLoaded', () => {
        const catImgInput = document.getElementById('CategoryImg');
        if (catImgInput) {
            catImgInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('CategoryImgPreview');
                const icon = document.getElementById('CategoryImgIcon');
                if (file && preview) {
                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        preview.src = evt.target.result;
                        preview.style.display = 'block';
                        if (icon) icon.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        const brandImgInput = document.getElementById('CreateBrandImg');
        if (brandImgInput) {
            brandImgInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('BrandImgPreview');
                const icon = document.getElementById('BrandImgIcon');
                if (file && preview) {
                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        preview.src = evt.target.result;
                        preview.style.display = 'block';
                        if (icon) icon.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });

    function closeCategoryModal() {
        const modal = document.getElementById('addCategoryModal');
        if (modal) {
            modal.style.display = 'none';
            modal.classList.remove('show');

            const inputName = document.getElementById('CategoryName');
            const inputStatus = document.getElementById('CategorySelectStatus');
            const inputImg = document.getElementById('CategoryImg');
            const preview = document.getElementById('CategoryImgPreview');
            const icon = document.getElementById('CategoryImgIcon');

            if (inputName) inputName.value = '';
            if (inputStatus) inputStatus.value = 'Active';
            if (inputImg) inputImg.value = '';
            if (preview) {
                preview.src = '';
                preview.style.display = 'none';
            }
            if (icon) icon.style.display = 'block';
        }
    }

    function openCategoryModal() {
        const modal = document.getElementById('addCategoryModal');
        if (modal) {
            modal.style.display = 'flex';
            modal.classList.add('show');
            modal.style.zIndex = '999999';
            setTimeout(() => {
                const input = document.getElementById('CategoryName');
                if (input) {
                    input.focus();
                }
            }, 100);
        }
    }

    document.querySelectorAll('.newcategory-open').forEach(btn =>
        btn.addEventListener('click', openCategoryModal)
    );
    document.querySelectorAll('.newcategory-close').forEach(btn =>
        btn.addEventListener('click', closeCategoryModal)
    );

    // Initial Dropdown Refresh
    document.addEventListener('DOMContentLoaded', () => {
        refreshCategoryList();
    });
</script>


{{-- Category Create JS Code end  --}}


<script>
    let barcodeList = []; // Array to store barcodes

    function renderBarcodes() {
        const container = document.getElementById('BarcodeContainer');
        container.innerHTML = '';
        barcodeList.forEach((barcode, index) => {
            const chip = document.createElement('span');
            chip.className = 'badge bg-success d-inline-flex align-items-center gap-1 p-2 font-size-14';
            chip.style.borderRadius = '20px';
            chip.style.color = '#ffffff';
            chip.innerHTML = `${barcode} <a href="#" onclick="removeBarcode(${index})" style="color: #ffffff; text-decoration: none; font-weight: bold; margin-left: 5px;">&times;</a>`;
            container.appendChild(chip);
        });
    }

    function addBarcode() {
        const barcodeInput = document.getElementById('ProductCodeInput');
        const barcode = barcodeInput.value.trim();

        if (!barcode) {
            return;
        }

        if (barcodeList.includes(barcode)) {
            errorToast('This barcode is already added!');
            return;
        }

        barcodeList.push(barcode);
        renderBarcodes();
        barcodeInput.value = '';
    }

    function removeBarcode(index) {
        barcodeList.splice(index, 1);
        renderBarcodes();
    }

    // Support scanner / Enter keypress on input field
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('ProductCodeInput');
        if (input) {
            input.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    addBarcode();
                }
            });
        }
    });

    function getBarcodes() {
        return barcodeList;
    }

    function calculateCreateDoorTotal() {
        let left = parseFloat(document.getElementById('createDoorQtyLeft').value) || 0;
        let right = parseFloat(document.getElementById('createDoorQtyRight').value) || 0;
        let both = parseFloat(document.getElementById('createDoorQtyBoth').value) || 0;
        let total = left + right + both;

        const badge = document.getElementById('createDoorTotalBadge');
        if (badge) badge.innerText = `মোট ডোর স্টক: ${total}`;

        const qtyInput = document.getElementById('ProductQuantity');
        if (qtyInput) qtyInput.value = total;

        const hidden = document.getElementById('selectedDoorSide');
        if (hidden) {
            if (left > 0 && right === 0 && both === 0) hidden.value = 'Left Handed';
            else if (right > 0 && left === 0 && both === 0) hidden.value = 'Right Handed';
            else if (both > 0 && left === 0 && right === 0) hidden.value = 'Both Handed';
            else if (total > 0) hidden.value = 'Multi Handed';
            else hidden.value = '';
        }

        // Highlight cards
        $('#createDoorQtyLeft').closest('.door-hand-box-create').toggleClass('border-primary shadow', left > 0);
        $('#createDoorQtyRight').closest('.door-hand-box-create').toggleClass('border-success shadow', right > 0);
        $('#createDoorQtyBoth').closest('.door-hand-box-create').toggleClass('border-info shadow', both > 0);
    }

    function selectDoorSide(value) {
        const hidden = document.getElementById('selectedDoorSide');
        if (hidden) hidden.value = value;
    }

    function resetDoorSide() {
        const leftInput = document.getElementById('createDoorQtyLeft');
        const rightInput = document.getElementById('createDoorQtyRight');
        const bothInput = document.getElementById('createDoorQtyBoth');
        if (leftInput) leftInput.value = '';
        if (rightInput) rightInput.value = '';
        if (bothInput) bothInput.value = '';

        const hidden = document.getElementById('selectedDoorSide');
        if (hidden) hidden.value = '';

        const badge = document.getElementById('createDoorTotalBadge');
        if (badge) badge.innerText = 'মোট ডোর স্টক: 0';

        $('.door-hand-box-create').removeClass('border-primary border-success border-info shadow');
    }

    function checkDoorCategory(categoryId) {
        const categoryDropdown = document.getElementById("ProductCategoryDataID");
        const container = document.getElementById('doorHandednessContainer');
        if (!categoryDropdown || !container) return;

        const selectedOption = categoryDropdown.options[categoryDropdown.selectedIndex];
        const categoryText = selectedOption ? selectedOption.text.toLowerCase().trim() : '';

        if (categoryText.includes('door')) {
            container.style.display = 'block';
            calculateCreateDoorTotal();
        } else {
            container.style.display = 'none';
            resetDoorSide();
        }
    }

    function resetProductForm() {
        const signupForm = document.getElementById("signup");
        if (signupForm) {
            signupForm.reset();
        }
        barcodeList = [];
        renderBarcodes();
        resetDoorSide();
        const doorCont = document.getElementById('doorHandednessContainer');
        if (doorCont) doorCont.style.display = 'none';

        // Reset Brand & Category custom dropdowns
        resetCustomProductDropdown('createBrandDropdown', 'ProductBrand', 'Select Brand', 'none');
        resetCustomProductDropdown('createCategoryDropdown', 'ProductCategoryDataID', 'Select Category *', 'none');

        // Reset Product Image Preview and File info
        resetProductImagePreview();
    }

    // Image Preview and File Info Handler
    function previewProductImage(event) {
        const input = event.target;
        const file = input.files && input.files[0];
        const previewImg = document.getElementById('ProductImagePreview');
        const defaultIcon = document.getElementById('ProductImageDefaultIcon');
        const fileInfo = document.getElementById('ProductImageFileInfo');
        const imgBox = document.getElementById('ProductImageBox');

        if (file) {
            // Calculate file size formatted
            let sizeFormatted = '';
            if (file.size < 1024) {
                sizeFormatted = file.size + ' B';
            } else if (file.size < 1024 * 1024) {
                sizeFormatted = (file.size / 1024).toFixed(1) + ' KB';
            } else {
                sizeFormatted = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
            }

            const isOversize = file.size > (1024 * 1024);
            const badgeBg = isOversize ? '#fef2f2' : '#ecfdf5';
            const badgeColor = isOversize ? '#b91c1c' : '#047857';
            const badgeBorder = isOversize ? '#fecaca' : '#a7f3d0';

            // Show Preview Image in left box
            const reader = new FileReader();
            reader.onload = function(e) {
                if (previewImg) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                }
                if (defaultIcon) {
                    defaultIcon.style.display = 'none';
                }
                if (imgBox) {
                    imgBox.style.border = '1px solid #16a34a';
                    imgBox.style.background = '#ffffff';
                }
            };
            reader.readAsDataURL(file);

            // Show File Details (File name, size badge, and remove button)
            if (fileInfo) {
                fileInfo.innerHTML = `
                    <div class="d-flex align-items-center gap-2 flex-wrap" style="font-size: 12px; margin-top: 4px;">
                        <span class="text-truncate" style="max-width: 170px; font-weight: 600; color: #0f172a;" title="${file.name}">
                            <i class="fa-solid fa-image text-success me-1"></i>${file.name}
                        </span>
                        <span class="badge" style="background-color: ${badgeBg}; color: ${badgeColor}; border: 1px solid ${badgeBorder}; font-size: 11px; padding: 2px 7px; border-radius: 6px; font-weight: 600;">
                            <i class="fa-solid fa-hard-drive me-1"></i>${sizeFormatted}
                        </span>
                        <button type="button" onclick="removeProductImage()" class="btn btn-sm btn-link text-danger p-0 ms-1" style="font-size: 13px; text-decoration: none;" title="Remove image">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </button>
                    </div>
                `;
            }
        } else {
            resetProductImagePreview();
        }
    }

    function removeProductImage() {
        const input = document.getElementById('ProductImage');
        if (input) {
            input.value = '';
        }
        resetProductImagePreview();
    }

    function resetProductImagePreview() {
        const previewImg = document.getElementById('ProductImagePreview');
        const defaultIcon = document.getElementById('ProductImageDefaultIcon');
        const fileInfo = document.getElementById('ProductImageFileInfo');
        const imgBox = document.getElementById('ProductImageBox');

        if (previewImg) {
            previewImg.src = '';
            previewImg.style.display = 'none';
        }
        if (defaultIcon) {
            defaultIcon.style.display = 'flex';
        }
        if (imgBox) {
            imgBox.style.border = '1.5px dashed #cbd5e1';
            imgBox.style.background = '#f8fafc';
        }
        if (fileInfo) {
            fileInfo.innerHTML = '<span>PNG, JPEG or GIF (up to 1 MB)</span>';
        }
    }

    window.previewProductImage = previewProductImage;
    window.removeProductImage = removeProductImage;
    window.resetProductImagePreview = resetProductImagePreview;

    // Custom Searchable Dropdown Helper Functions (Identical to POS Page)
    function toggleCustomProductDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        if (!dropdown) return;
        const isOpen = dropdown.classList.contains('is-open');

        closeAllCustomProductDropdowns();

        if (!isOpen) {
            dropdown.classList.add('is-open');
            const parentCol = dropdown.closest('.col-lg-6');
            if (parentCol) {
                parentCol.classList.add('has-open-dropdown');
                parentCol.style.zIndex = '9999';
                parentCol.style.position = 'relative';
            }
            const chevron = dropdown.querySelector('.fa-chevron-down');
            if (chevron) chevron.style.transform = 'rotate(180deg)';
            const searchInput = dropdown.querySelector('.search-wrap input');
            if (searchInput) {
                searchInput.value = '';
                filterCustomProductDropdown(dropdownId, '');
                setTimeout(() => searchInput.focus(), 60);
            }
        }
    }

    function closeAllCustomProductDropdowns() {
        document.querySelectorAll('#createProduct .custom-searchable-select').forEach(d => {
            d.classList.remove('is-open');
            const chevron = d.querySelector('.fa-chevron-down');
            if (chevron) chevron.style.transform = 'rotate(0deg)';
        });
        document.querySelectorAll('#createProduct .col-lg-6').forEach(col => {
            col.classList.remove('has-open-dropdown');
            col.style.zIndex = '';
            col.style.position = '';
        });
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#createProduct .custom-searchable-select')) {
            closeAllCustomProductDropdowns();
        }
    });

    function filterCustomProductDropdown(dropdownId, searchVal) {
        const dropdown = document.getElementById(dropdownId);
        if (!dropdown) return;
        const listEl = dropdown.querySelector('.select-options-list');
        if (!listEl) return;
        const items = listEl.querySelectorAll('.select-option-item');
        const query = (searchVal || '').trim().toLowerCase();
        let matchCount = 0;

        items.forEach(item => {
            const text = (item.getAttribute('data-label') || '').toLowerCase();
            if (!query || text.includes(query)) {
                item.style.display = 'flex';
                matchCount++;
            } else {
                item.style.display = 'none';
            }
        });

        let noResultEl = listEl.querySelector('.no-results-msg');
        if (matchCount === 0) {
            if (!noResultEl) {
                noResultEl = document.createElement('div');
                noResultEl.className = 'no-results-msg text-center py-2 text-muted';
                noResultEl.style.fontSize = '12px';
                noResultEl.textContent = 'কোনো ফলাফল পাওয়া যায়নি';
                listEl.appendChild(noResultEl);
            }
        } else if (noResultEl) {
            noResultEl.remove();
        }
    }

    function selectCustomProductDropdownItem(dropdownId, hiddenInputId, val, label) {
        const dropdown = document.getElementById(dropdownId);
        const hiddenInput = document.getElementById(hiddenInputId);
        const triggerText = dropdown ? dropdown.querySelector('.selected-text') : null;

        if (hiddenInput) {
            hiddenInput.value = val;
            hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
        }

        if (triggerText) {
            triggerText.textContent = label;
            triggerText.style.color = (val && val !== 'none') ? '#0f172a' : '#64748b';
        }

        if (dropdown) {
            dropdown.querySelectorAll('.select-option-item').forEach(item => {
                if (item.getAttribute('data-value') === String(val)) {
                    item.classList.add('active');
                    if (!item.querySelector('.fa-check')) {
                        item.innerHTML = `<span>${item.getAttribute('data-label')}</span><i class="fa-solid fa-check small text-success"></i>`;
                    }
                } else {
                    item.classList.remove('active');
                    const check = item.querySelector('.fa-check');
                    if (check) check.remove();
                }
            });
        }

        closeAllCustomProductDropdowns();
    }

    function resetCustomProductDropdown(dropdownId, hiddenInputId, defaultText = "Select Option", defaultVal = "none") {
        const dropdown = document.getElementById(dropdownId);
        const hiddenInput = document.getElementById(hiddenInputId);
        if (hiddenInput) hiddenInput.value = defaultVal;
        if (!dropdown) return;
        const triggerText = dropdown.querySelector('.selected-text');
        const searchInput = dropdown.querySelector('.search-wrap input');

        if (triggerText) {
            triggerText.textContent = defaultText;
            triggerText.style.color = (defaultVal && defaultVal !== 'none') ? '#0f172a' : '#64748b';
        }
        if (searchInput) searchInput.value = '';
        filterCustomProductDropdown(dropdownId, '');

        dropdown.querySelectorAll('.select-option-item').forEach(item => {
            if (item.getAttribute('data-value') === String(defaultVal)) {
                item.classList.add('active');
                if (!item.querySelector('.fa-check')) {
                    item.innerHTML = `<span>${item.getAttribute('data-label')}</span><i class="fa-solid fa-check small text-success"></i>`;
                }
            } else {
                item.classList.remove('active');
                const check = item.querySelector('.fa-check');
                if (check) check.remove();
            }
        });
    }
</script>




{{-- Translation JS Code --}}
<script>
    async function translateProductName() {
        const nameInput = document.getElementById('ProductName');
        const text = nameInput ? nameInput.value.trim() : '';

        if (!text) {
            errorToast("অনুগ্রহ করে প্রথমে প্রোডাক্টের নাম লিখুন!");
            return;
        }

        const translateBtn = document.getElementById('translateBtn');
        const originalContent = translateBtn ? translateBtn.innerHTML : '';
        if (translateBtn) {
            translateBtn.disabled = true;
            translateBtn.innerHTML = `<span>অনুবাদ হচ্ছে...</span>`;
        }

        try {
            const url = `https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=bn&dt=t&q=${encodeURIComponent(text)}`;
            const res = await axios.get(url);

            if (res.data && res.data[0] && Array.isArray(res.data[0])) {
                const translatedText = res.data[0].map(item => item[0]).filter(Boolean).join('');
                if (translatedText) {
                    nameInput.value = translatedText;
                    successToast("বাংলায় রূপান্তর সফল হয়েছে!");
                } else {
                    errorToast("অনুবাদ ব্যর্থ হয়েছে। আবার চেষ্টা করুন।");
                }
            } else {
                errorToast("অনুবাদ ব্যর্থ হয়েছে।");
            }
        } catch (err) {
            console.error("Translation error:", err);
            errorToast("অনুবাদ করতে সমস্যা হয়েছে। ইন্টারনেট সংযোগ পরীক্ষা করুন।");
        } finally {
            if (translateBtn) {
                translateBtn.disabled = false;
                translateBtn.innerHTML = originalContent;
            }
        }
    }
</script>

{{-- Product Create JS Code Start  --}}

<script>
    async function ProductDataSave(event) {
        event.preventDefault();
        try {
            let ProductImageInput = document.getElementById('ProductImage').files[0];
            let ProductName = document.getElementById('ProductName').value.trim();
            let ProductQuantity = document.getElementById('ProductQuantity').value.trim();
            let ProductCostPrice = document.getElementById('ProductCostPrice').value.trim();
            let ProductSellingPrice = document.getElementById('ProductSellingPrice').value.trim();
            let ProductSelectStatus = 'Active';
            let ProductBrand = document.getElementById('ProductBrand').value;
            let ProductCategoryDataID = document.getElementById('ProductCategoryDataID').value;
            let ProductSubCategoryEl = document.getElementById('ProductSubCategoryID');
            let ProductSubCategoryID = ProductSubCategoryEl ? ProductSubCategoryEl.value : '';
            let ProductUnitEl = document.getElementById('ProductUnit');
            let ProductUnit = ProductUnitEl ? ProductUnitEl.value : '';
            let selectedDoorSide = document.getElementById('selectedDoorSide') ? document.getElementById('selectedDoorSide').value : '';
            let doorContainer = document.getElementById('doorHandednessContainer');
            let isDoorVisible = doorContainer && doorContainer.style.display !== 'none';

            // Resolve final list of barcodes to submit
            let finalBarcodes = [];
            const barcodeInput = document.getElementById('ProductCodeInput');
            const pendingBarcode = barcodeInput ? barcodeInput.value.trim() : '';

            if (barcodeList.length > 0) {
                finalBarcodes = [...barcodeList];
                if (pendingBarcode.length > 0 && !finalBarcodes.includes(pendingBarcode)) {
                    finalBarcodes.push(pendingBarcode);
                }
            } else if (pendingBarcode.length > 0) {
                finalBarcodes = [pendingBarcode];
            }

            const ProductCodes = JSON.stringify(finalBarcodes);

            if (ProductBrand.length === 0 || ProductBrand === 'none') {
                errorToast("Product Brand is required!");
                return false;
            } else if (ProductCategoryDataID.length === 0 || ProductCategoryDataID === 'disabled') {
                errorToast("Product Category is required!");
                return false;
            } else if (ProductName.length === 0) {
                errorToast("Product Name is required!");
                return false;
            } else {
                let formData = new FormData();
                formData.append('product_name', ProductName);
                formData.append('quantity', ProductQuantity !== "" ? ProductQuantity : 0);
                formData.append('cost_price', ProductCostPrice !== "" ? ProductCostPrice : 0);
                formData.append('sell_price', ProductSellingPrice !== "" ? ProductSellingPrice : 0);
                formData.append('product_code', ProductCodes); // Add barcodes
                formData.append('status', ProductSelectStatus);
                formData.append('brand_id', ProductBrand);
                formData.append('category_id', ProductCategoryDataID);

                if (isDoorVisible) {
                    const leftQty = parseFloat(document.getElementById('createDoorQtyLeft').value) || 0;
                    const rightQty = parseFloat(document.getElementById('createDoorQtyRight').value) || 0;
                    const bothQty = parseFloat(document.getElementById('createDoorQtyBoth').value) || 0;

                    formData.append('door_qty_left', leftQty);
                    formData.append('door_qty_right', rightQty);
                    formData.append('door_qty_both', bothQty);
                }

                if (selectedDoorSide) formData.append('door_side', selectedDoorSide);
                if (ProductSubCategoryID) formData.append('sub_category_id', ProductSubCategoryID);
                if (ProductUnit) formData.append('unit_id', ProductUnit);
                if (ProductImageInput) formData.append('img', ProductImageInput);

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data',
                        ...HeaderToken().headers
                    }
                };

                let res = await axios.post("/api/create-product", formData, config);

                if (res.data['status'] === "success") {
                    successToast(res.data['message']);
                    document.getElementById("signup").reset();
                    barcodeList = [];
                    renderBarcodes();
                    resetDoorSide();
                    resetProductImagePreview();
                    closeProductModal();
                    if (typeof getList === 'function') {
                        await getList();
                    } else {
                        location.reload();
                    }
                } else {
                    errorToast(res.data['message']);
                }
            }
        } catch (e) {
            unauthorized(e.response ? e.response.status : 500);
        }
        return false;
    }

    function openProductCreateModal() {
        const modal = document.getElementById('createProduct') || document.querySelector('.financemodal');
        if (modal) {
            if (modal.parentNode && modal.parentNode !== document.body) {
                document.body.appendChild(modal);
            }
            modal.classList.add('show');
            modal.classList.add('show-modal');
            modal.style.setProperty('display', 'flex', 'important');
            modal.style.opacity = '1';
            modal.style.visibility = 'visible';
            document.body.style.overflow = 'hidden';
            closeAllCustomProductDropdowns();

            if (typeof refreshBrandList === 'function') {
                const brandDropdown = document.getElementById("ProductBrand");
                if (!brandDropdown || brandDropdown.options.length <= 1) {
                    refreshBrandList();
                }
            }
            if (typeof refreshCategoryList === 'function') {
                const catDropdown = document.getElementById("ProductCategoryDataID");
                if (!catDropdown || catDropdown.options.length <= 1) {
                    refreshCategoryList();
                }
            }
            if (typeof refreshUnitList === 'function') {
                const unitDropdown = document.getElementById("ProductUnit");
                if (!unitDropdown || unitDropdown.options.length <= 1) {
                    refreshUnitList();
                }
            }
        }
    }

    function closeProductModal(modal) {
        if (!modal || !(modal instanceof HTMLElement)) {
            modal = document.getElementById('createProduct') || document.querySelector('.financemodal');
        }
        if (modal) {
            modal.classList.remove('show');
            modal.classList.remove('show-modal');
            modal.style.setProperty('display', 'none', 'important');
            modal.style.opacity = '0';
            modal.style.visibility = 'hidden';
        }
        document.body.style.overflow = '';
        if (typeof resetProductForm === 'function') {
            resetProductForm();
        }
    }

    function closeModal(modal) {
        closeProductModal(modal);
    }

    window.openProductCreateModal = openProductCreateModal;
    window.closeProductModal = closeProductModal;
    window.closeModal = closeModal;
    window.Save = ProductDataSave;

    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById('createProduct');
        if (modal) {
            if (modal.parentNode && modal.parentNode !== document.body) {
                document.body.appendChild(modal);
            }

            modal.querySelectorAll('.close-btn, .closes').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    closeProductModal(modal);
                });
            });

            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeProductModal(modal);
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && (modal.classList.contains('show') || modal.style.display === 'flex')) {
                    const brandModal = document.getElementById('addBrandModal');
                    const catModal = document.getElementById('addCategoryModal');
                    if (brandModal && (brandModal.classList.contains('show') || brandModal.style.display === 'flex')) {
                        closeBrandModal();
                        return;
                    }
                    if (catModal && (catModal.classList.contains('show') || catModal.style.display === 'flex')) {
                        closeCategoryModal();
                        return;
                    }
                    closeProductModal(modal);
                }
            });
        }

        document.querySelectorAll('#openModalBtns, .create-invoice').forEach(btn => {
            if (btn.innerText.includes('Product') || window.location.pathname.includes('product')) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openProductCreateModal();
                });
            }
        });
    });
</script>

<!-- Create Product Camera Barcode Scanner Modal -->
<div class="modal fade" id="productCreateCameraScanModal" tabindex="-1" aria-labelledby="productCreateCameraScanModalLabel" aria-hidden="true" data-bs-backdrop="static" style="z-index: 999999 !important;">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 18px; overflow: hidden;">
            <div class="modal-header text-white py-3" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%);">
                <h5 class="modal-title fw-bold" id="productCreateCameraScanModalLabel">
                    <i class="fa-solid fa-camera me-2"></i> বারকোড ক্যামেরা স্ক্যানার
                </h5>
                <button type="button" class="btn-close btn-close-white" onclick="stopProductCreateCameraScanner()"></button>
            </div>
            <div class="modal-body p-3 text-center">
                <div id="productCreateCameraScannerStatus" class="alert alert-info py-2 small mb-3" style="border-radius: 10px;">
                    <i class="fa-solid fa-circle-notch fa-spin me-1"></i> ক্যামেরা শুরু হচ্ছে... বারকোড ক্যামেরার সামনে রাখুন।
                </div>

                <!-- Reader Viewport -->
                <div id="product-create-reader" style="width: 100%; min-height: 270px; background: #000; border-radius: 14px; overflow: hidden;" class="shadow-sm"></div>

                <div class="d-flex align-items-center justify-content-between mt-3 px-1">
                    <span id="productCreateLastScannedText" class="badge bg-success fs-6 py-2 px-3" style="border-radius: 10px;">স্ক্যান কৃত কোড: -</span>
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="switchProductCreateCamera()">
                        <i class="fa-solid fa-rotate me-1"></i> ক্যামেরা পাল্টান
                    </button>
                </div>
            </div>
            <div class="modal-footer bg-light py-2 justify-content-between">
                <small class="text-muted"><i class="fa-solid fa-bolt text-warning me-1"></i> বারকোড স্ক্যান করলেই ইনপুটে বসে যাবে</small>
                <button type="button" class="btn btn-secondary px-4 fw-bold rounded-pill" onclick="stopProductCreateCameraScanner()">বন্ধ করুন</button>
            </div>
        </div>
    </div>
</div>

<script>
    let productCreateHtml5QrCode = null;
    let productCreateFacingMode = "environment";
    let productCreateLastCode = "";

    function openProductCreateCameraScanner() {
        const modalEl = document.getElementById('productCreateCameraScanModal');
        const modalObj = new bootstrap.Modal(modalEl);
        modalObj.show();
        setTimeout(() => {
            modalEl.style.zIndex = "999999";
            const backdrops = document.querySelectorAll('.modal-backdrop');
            if (backdrops.length > 0) {
                backdrops[backdrops.length - 1].style.zIndex = "999990";
            }
            startProductCreateCameraScanner();
        }, 300);
    }

    function startProductCreateCameraScanner() {
        if (productCreateHtml5QrCode && productCreateHtml5QrCode.isScanning) {
            productCreateHtml5QrCode.stop().then(() => initProductCreateHtml5QrCode()).catch(() => initProductCreateHtml5QrCode());
        } else {
            initProductCreateHtml5QrCode();
        }
    }

    function initProductCreateHtml5QrCode() {
        const statusEl = document.getElementById("productCreateCameraScannerStatus");
        if (statusEl) {
            statusEl.className = "alert alert-info py-2 small mb-3";
            statusEl.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-1"></i> ক্যামেরা চালু হচ্ছে... বারকোড ক্যামেরার সামনে আনুন।';
        }

        if (!productCreateHtml5QrCode) {
            productCreateHtml5QrCode = new Html5Qrcode("product-create-reader");
        }

        const config = {
            fps: 15,
            qrbox: {
                width: 260,
                height: 160
            },
            aspectRatio: 1.333334
        };

        productCreateHtml5QrCode.start({
                facingMode: productCreateFacingMode
            },
            config,
            onProductCreateBarcodeDetected,
            onProductCreateBarcodeError
        ).then(() => {
            if (statusEl) {
                statusEl.className = "alert alert-success py-2 small mb-3";
                statusEl.innerHTML = '<i class="fa-solid fa-video me-1"></i> ক্যামেরা সক্রিয়! বারকোড স্ক্যান করলে সরাসরি ইনপুটে যুক্ত হবে।';
            }
        }).catch(err => {
            console.error("Camera start error:", err);
            if (statusEl) {
                statusEl.className = "alert alert-danger py-2 small mb-3";
                statusEl.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> ক্যামেরা চালু করা যায়নি! ব্রাউজারের ক্যামেরা পারমিশন এলাউ (Allow) করুন।';
            }
        });
    }

    function onProductCreateBarcodeDetected(decodedText) {
        if (!decodedText || decodedText === productCreateLastCode) return;

        productCreateLastCode = decodedText;
        const lastTextEl = document.getElementById("productCreateLastScannedText");
        if (lastTextEl) lastTextEl.innerText = `স্ক্যান কৃত: ${decodedText}`;

        if (navigator.vibrate) navigator.vibrate(100);

        // Fill barcode into ProductCodeInput & trigger chip add
        const input = document.getElementById("ProductCodeInput");
        if (input) {
            input.value = decodedText;
            if (typeof addBarcode === "function") {
                addBarcode(decodedText);
            }
        }

        stopProductCreateCameraScanner();
    }

    function onProductCreateBarcodeError(msg) {}

    function switchProductCreateCamera() {
        productCreateFacingMode = (productCreateFacingMode === "environment") ? "user" : "environment";
        startProductCreateCameraScanner();
    }

    function stopProductCreateCameraScanner() {
        if (productCreateHtml5QrCode && productCreateHtml5QrCode.isScanning) {
            productCreateHtml5QrCode.stop().then(() => {
                productCreateHtml5QrCode.clear();
                hideProductCreateCameraModal();
            }).catch(() => {
                hideProductCreateCameraModal();
            });
        } else {
            hideProductCreateCameraModal();
        }
    }

    function hideProductCreateCameraModal() {
        const modalEl = document.getElementById('productCreateCameraScanModal');
        const instance = bootstrap.Modal.getInstance(modalEl);
        if (instance) instance.hide();
    }
</script>