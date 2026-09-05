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
        padding: 0 !important;
        z-index: 9991 !important;
    }

    .financemodal .modal-content {
        position: relative !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        margin: 0 !important;
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
</style>

<!-- Create Product Modal Start -->
<section id="createProduct" class="financemodal">
    <div class="modal-content">
        <a class="close-btn closes">
            <i class="fa-solid fa-xmark"></i>
        </a>
        <h2 class="heading">Add New Product</h2>
        <div id="popup-modal">
            <form onsubmit="return Save(event)" id="signup">
                <!-- Select Dropdowns with Add Buttons -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-row">
                            <select class="form-select input-style" id="ProductBrand"
                                aria-label="Default select example">
                                <option value="none">Select Brand</option>
                            </select>
                            <button type="button" class="btn-add newbrand-open">+ Add</button>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-row">
                            <select required id="ProductCategoryDataID">
                                <option disabled selected>
                                    Select Category <span class="star">*</span>
                                </option>
                            </select>
                            <button type="button" class="btn-add newcategory-open">
                                + Add
                            </button>
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
                                    <span>Door Handedness & Specific Quantities (ডোর সাইড অনুযায়ী স্টক এন্ট্রি)</span>
                                </label>
                                <span class="badge bg-success text-white px-2 py-1 small fw-bold" id="createDoorTotalBadge">মোট ডোর স্টক: 0</span>
                            </div>
                            <div class="row g-2 mt-1">
                                <!-- Left Handed Card & Qty Input -->
                                <div class="col-md-4 col-12">
                                    <div class="door-hand-box-create rounded-3 bg-white border border-2 border-slate-200 shadow-sm text-center" style="border-radius: 10px; padding: 10px 12px;">
                                        <div class="d-flex align-items-center justify-content-center gap-1.5 mb-2 text-primary fw-bold" style="font-size: 13px;">
                                            <span class="fs-5">👈</span>
                                            <span>Left Handed (বাম)</span>
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
                                            <span>Right Handed (ডান)</span>
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
                                            <span>Both / Universal (উভয়)</span>
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

                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="heading2">Product Information</h3>
                        <div class="mb-2">
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
                                            <input type="file" class="custom-file-input" id="ProductImage"
                                                aria-label="Upload Photo" />
                                        </label>
                                        <p>PNG,JPEG or GIF (up to 1 MB)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-12">
                        <div class="form-row mb-2">
                            <div class="d-flex align-items-center justify-content-between mb-1" style="width: 100%;">
                                <label for="ProductName" style="font-weight: 600; color: #15803d; margin: 0;">Product Name *</label>
                                <button type="button" id="translateBtn" onclick="translateProductName()" class="btn btn-sm text-white d-inline-flex align-items-center gap-1" style="background-color: #15803d; font-size: 13px; font-weight: 600; padding: 5px 14px; border-radius: 6px; border: none; cursor: pointer;">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                    </svg>
                                    <span>বাংলায় রূপান্তর (Translate to Bangla)</span>
                                </button>
                            </div>
                            <input type="text" placeholder="Product Name (বাংলা বা English) *" id="ProductName" style="width: 100%; height: 46px; border-radius: 6px;" />
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-row">
                            <input type="text" placeholder="Product Quantity" id="ProductQuantity" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-row">
                            <input type="text" placeholder="Product Cost Price" id="ProductCostPrice" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-row">
                            <input type="text" placeholder="Selling Price" id="ProductSellingPrice" />
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-row">
                            <div class="d-flex align-items-center gap-2">
                                <input type="text" id="ProductCodeInput" placeholder="Enter or scan barcode..." style="flex: 1; height: 46px; border-radius: 6px;" />
                                <button type="button" class="btn btn-primary fw-bold text-nowrap d-flex align-items-center gap-2 px-3 shadow-sm" onclick="openProductCreateCameraScanner()" style="height: 46px; border-radius: 8px; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none;">
                                    <i class="fa-solid fa-camera fs-5"></i>
                                    <span class="d-none d-sm-inline">ক্যামেরা স্ক্যান</span>
                                </button>
                            </div>
                        </div>
                        <div id="BarcodeContainer" class="d-flex flex-wrap gap-2 mt-2 mb-3"></div>
                    </div>
                    <div class="actions d-flex align-items-center justify-content-end gap-2 mt-3">
                        <button type="button" onclick="resetProductForm()" class="btn btn-outline-secondary px-4" style="height: 46px; border-radius: 8px; font-weight: 600;">Reset</button>
                        <button type="button" onclick="ProductDataSave(event)" class="btn-save" style="height: 46px; margin: 0;">Submit</button>
                    </div>
                </div>
            </form>
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
            const Brand = res.data.BrandData;

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
                const categories = res.data.CategoryData;

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

                    categoryDropdown.addEventListener('change', handleCategoryChange);
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
                    const modal = document.getElementById('myModal');
                    closeModal(modal);
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

    function closeModal(modal) {
        if (modal) {
            modal.style.display = 'none';
        }
        resetProductForm();
    }
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