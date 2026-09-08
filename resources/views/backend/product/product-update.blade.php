<style>
    /* Override duplicate outer box and dialog constraints */
    #exampleModal .modal-dialog {
        background: transparent !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
        max-width: 750px !important;
        width: 95% !important;
        margin: 1.75rem auto !important;
        height: auto !important;
        min-height: auto !important;
        text-align: left !important;
    }

    #exampleModal .modal-content {
        border-radius: 16px !important;
        overflow: hidden !important;
        background: #ffffff;
        padding: 0 !important;
        height: auto !important;
        min-height: auto !important;
        max-height: 90vh !important;
        display: flex !important;
        flex-direction: column !important;
        border: none !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35) !important;
        text-align: left !important;
    }

    #exampleModal form .form-row {
        margin-bottom: 0px;
    }

    #exampleModal form select,
    #exampleModal form input[type="text"],
    #exampleModal form input[type="number"],
    #exampleModal .form-control,
    #exampleModal .form-select {
        width: 100%;
        height: 42px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 8px 12px;
        font-size: 14px;
        color: #1e293b;
        background-color: #ffffff;
        transition: all 0.2s ease;
    }

    #exampleModal .form-control:focus,
    #exampleModal .form-select:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15);
    }

    #exampleModal label,
    #exampleModal .update-file-info,
    #exampleModal .form-row {
        color: #334155;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 3px;
        text-align: left !important;
    }

    /* Modal Close Button Compact Styling & Placement */
    #exampleModal .modal-dialog .close-btn,
    #exampleModal .modal-header .close-btn,
    #exampleModal .close-btn {
        position: relative !important;
        right: auto !important;
        top: auto !important;
        left: auto !important;
        bottom: auto !important;
        margin: 0 !important;
        width: 22px !important;
        height: 22px !important;
        min-width: 22px !important;
        min-height: 22px !important;
        border-radius: 50% !important;
        background: #ef4444 !important;
        color: #ffffff !important;
        font-size: 10px !important;
        padding: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border: none !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2) !important;
        cursor: pointer !important;
        flex-shrink: 0 !important;
    }

    #exampleModal .modal-dialog .close-btn i,
    #exampleModal .close-btn i {
        font-size: 10px !important;
        color: #ffffff !important;
        padding: 0 !important;
        margin: 0 !important;
        line-height: 1 !important;
        background: transparent !important;
    }

    #exampleModal .modal-dialog .close-btn:hover,
    #exampleModal .modal-dialog .close-btn i:hover,
    #exampleModal .close-btn:hover i {
        background: transparent !important;
    }

    /* Custom Searchable Select Dropdowns (Identical to POS Page & Add Product) */
    #exampleModal .custom-searchable-select {
        position: relative;
        flex: 1;
        min-width: 0;
        z-index: 1;
    }

    #exampleModal .custom-searchable-select.is-open {
        z-index: 9999 !important;
        position: relative !important;
    }

    #exampleModal .col-lg-6:has(.custom-searchable-select.is-open),
    #exampleModal .col-lg-6.has-open-dropdown {
        z-index: 9999 !important;
        position: relative !important;
    }

    #exampleModal .custom-searchable-select .select-trigger {
        height: 42px;
        border-radius: 8px;
        cursor: pointer !important;
        border: 1px solid #cbd5e1 !important;
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

    #exampleModal .custom-searchable-select .select-trigger:hover {
        border-color: #16a34a !important;
    }

    #exampleModal .custom-searchable-select.is-open .select-trigger {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.15) !important;
    }

    #exampleModal .custom-searchable-select .select-menu {
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

    #exampleModal .custom-searchable-select.is-open .select-menu {
        display: block !important;
    }

    #exampleModal .custom-searchable-select .search-wrap {
        padding: 4px 6px;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 4px;
        position: relative;
        background: #ffffff !important;
        z-index: 2;
    }

    #exampleModal .custom-searchable-select .search-wrap input {
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

    #exampleModal .custom-searchable-select .search-wrap input:focus {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.1) !important;
    }

    #exampleModal .custom-searchable-select .select-options-list {
        max-height: 180px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }

    #exampleModal .custom-searchable-select .select-options-list::-webkit-scrollbar {
        width: 4px;
    }

    #exampleModal .custom-searchable-select .select-option-item {
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

    #exampleModal .custom-searchable-select .select-option-item:hover {
        background-color: #f0fdf4;
        color: #15803d;
    }

    #exampleModal .custom-searchable-select .select-option-item.active {
        background-color: #dcfce7;
        color: #15803d;
        font-weight: 700;
    }

    /* Product Photo Preview Box & Upload Button matching Add Product */
    #exampleModal .update-img-box {
        width: 84px !important;
        height: 70px !important;
        border-radius: 8px !important;
        background: #f8fafc;
        border: 1.5px dashed #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        position: relative;
    }

    #exampleModal .update-img-box img {
        width: 100% !important;
        height: 100% !important;
        min-width: 100% !important;
        min-height: 100% !important;
        max-width: 100% !important;
        max-height: 100% !important;
        object-fit: cover !important;
        border-radius: 7px !important;
    }

    #exampleModal .update-file-btn-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 42px;
        border-radius: 8px;
        background: #ededed;
        color: #334155;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }

    #exampleModal .update-file-btn-wrapper:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    #exampleModal .update-file-btn-wrapper input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    /* Door Handedness Selector Styles for Update Modal */
    .door-hand-card-update {
        cursor: pointer;
        padding: 9px 12px;
        border-radius: 8px;
        border: 2px solid #e2e8f0;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
        user-select: none;
    }

    .door-hand-card-update:hover {
        border-color: #86efac;
        background: #f0fdf4;
    }

    .door-hand-radio-update:checked+.door-hand-card-update {
        background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important;
        border-color: #15803d !important;
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3) !important;
    }

    .door-hand-radio-update:checked+.door-hand-card-update .door-hand-text-update {
        color: #ffffff !important;
    }

    .door-hand-radio-update:checked+.door-hand-card-update .door-hand-icon-update {
        transform: scale(1.15);
    }

    /* Dark Mode Styling for Edit Product Modal */
    body[light-mode="dark"] #exampleModal .modal-content,
    html[light-mode="dark"] #exampleModal .modal-content,
    body[data-layout-mode="dark"] #exampleModal .modal-content,
    html.dark #exampleModal .modal-content,
    body.dark #exampleModal .modal-content,
    body.dark-mode #exampleModal .modal-content {
        background-color: #0f172a !important;
        color: #f1f5f9 !important;
        border: 1px solid #1e293b !important;
    }

    body[light-mode="dark"] #exampleModal .modal-body-scroll,
    html[light-mode="dark"] #exampleModal .modal-body-scroll,
    body[data-layout-mode="dark"] #exampleModal .modal-body-scroll {
        background-color: #0f172a !important;
    }

    body[light-mode="dark"] #exampleModal .modal-footer,
    html[light-mode="dark"] #exampleModal .modal-footer,
    body[data-layout-mode="dark"] #exampleModal .modal-footer,
    html.dark #exampleModal .modal-footer,
    body.dark #exampleModal .modal-footer,
    body.dark-mode #exampleModal .modal-footer {
        background-color: #0f172a !important;
        border-top-color: #1e293b !important;
    }

    body[light-mode="dark"] #exampleModal label,
    html[light-mode="dark"] #exampleModal label,
    body[data-layout-mode="dark"] #exampleModal label,
    html.dark #exampleModal label,
    body.dark #exampleModal label,
    body.dark-mode #exampleModal label {
        color: #cbd5e1 !important;
    }

    body[light-mode="dark"] #exampleModal .form-control,
    body[light-mode="dark"] #exampleModal .form-select,
    html[light-mode="dark"] #exampleModal .form-control,
    html[light-mode="dark"] #exampleModal .form-select,
    body[data-layout-mode="dark"] #exampleModal .form-control,
    body[data-layout-mode="dark"] #exampleModal .form-select,
    html.dark #exampleModal .form-control,
    html.dark #exampleModal .form-select,
    body.dark #exampleModal .form-control,
    body.dark #exampleModal .form-select {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] #exampleModal .form-control::placeholder,
    html[light-mode="dark"] #exampleModal .form-control::placeholder {
        color: #94a3b8 !important;
    }

    body[light-mode="dark"] #exampleModal .custom-searchable-select .select-trigger,
    html[light-mode="dark"] #exampleModal .custom-searchable-select .select-trigger,
    body[data-layout-mode="dark"] #exampleModal .custom-searchable-select .select-trigger,
    html.dark #exampleModal .custom-searchable-select .select-trigger,
    body.dark #exampleModal .custom-searchable-select .select-trigger,
    body.dark-mode #exampleModal .custom-searchable-select .select-trigger {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] #exampleModal .custom-searchable-select .selected-text,
    html[light-mode="dark"] #exampleModal .custom-searchable-select .selected-text,
    body[data-layout-mode="dark"] #exampleModal .custom-searchable-select .selected-text,
    html.dark #exampleModal .custom-searchable-select .selected-text,
    body.dark #exampleModal .custom-searchable-select .selected-text,
    body.dark-mode #exampleModal .custom-searchable-select .selected-text {
        color: #ffffff !important;
    }

    body[light-mode="dark"] #exampleModal .custom-searchable-select .select-menu,
    html[light-mode="dark"] #exampleModal .custom-searchable-select .select-menu,
    body[data-layout-mode="dark"] #exampleModal .custom-searchable-select .select-menu,
    html.dark #exampleModal .custom-searchable-select .select-menu,
    body.dark #exampleModal .custom-searchable-select .select-menu,
    body.dark-mode #exampleModal .custom-searchable-select .select-menu {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.6) !important;
    }

    body[light-mode="dark"] #exampleModal .custom-searchable-select .search-wrap,
    html[light-mode="dark"] #exampleModal .custom-searchable-select .search-wrap,
    body[data-layout-mode="dark"] #exampleModal .custom-searchable-select .search-wrap,
    html.dark #exampleModal .custom-searchable-select .search-wrap,
    body.dark #exampleModal .custom-searchable-select .search-wrap,
    body.dark-mode #exampleModal .custom-searchable-select .search-wrap {
        background-color: #0f172a !important;
        border-bottom-color: #334155 !important;
    }

    body[light-mode="dark"] #exampleModal .custom-searchable-select .search-wrap input,
    html[light-mode="dark"] #exampleModal .custom-searchable-select .search-wrap input,
    body[data-layout-mode="dark"] #exampleModal .custom-searchable-select .search-wrap input,
    html.dark #exampleModal .custom-searchable-select .search-wrap input,
    body.dark #exampleModal .custom-searchable-select .search-wrap input,
    body.dark-mode #exampleModal .custom-searchable-select .search-wrap input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] #exampleModal .custom-searchable-select .select-option-item,
    html[light-mode="dark"] #exampleModal .custom-searchable-select .select-option-item,
    body[data-layout-mode="dark"] #exampleModal .custom-searchable-select .select-option-item,
    html.dark #exampleModal .custom-searchable-select .select-option-item,
    body.dark #exampleModal .custom-searchable-select .select-option-item,
    body.dark-mode #exampleModal .custom-searchable-select .select-option-item {
        color: #cbd5e1 !important;
    }

    body[light-mode="dark"] #exampleModal .custom-searchable-select .select-option-item:hover,
    html[light-mode="dark"] #exampleModal .custom-searchable-select .select-option-item:hover,
    body[data-layout-mode="dark"] #exampleModal .custom-searchable-select .select-option-item:hover,
    html.dark #exampleModal .custom-searchable-select .select-option-item:hover,
    body.dark #exampleModal .custom-searchable-select .select-option-item:hover,
    body.dark-mode #exampleModal .custom-searchable-select .select-option-item:hover {
        background-color: #334155 !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] #exampleModal .custom-searchable-select .select-option-item.active,
    html[light-mode="dark"] #exampleModal .custom-searchable-select .select-option-item.active,
    body[data-layout-mode="dark"] #exampleModal .custom-searchable-select .select-option-item.active,
    html.dark #exampleModal .custom-searchable-select .select-option-item.active,
    body.dark #exampleModal .custom-searchable-select .select-option-item.active,
    body.dark-mode #exampleModal .custom-searchable-select .select-option-item.active {
        background-color: rgba(22, 163, 74, 0.25) !important;
        color: #4ade80 !important;
    }

    body[light-mode="dark"] #exampleModal .update-img-box,
    html[light-mode="dark"] #exampleModal .update-img-box {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #exampleModal .update-file-btn-wrapper,
    html[light-mode="dark"] #exampleModal .update-file-btn-wrapper {
        background-color: #1e293b !important;
        color: #cbd5e1 !important;
        border: 1px solid #334155 !important;
    }
    body[light-mode="dark"] #exampleModal .update-file-btn-wrapper:hover,
    html[light-mode="dark"] #exampleModal .update-file-btn-wrapper:hover {
        background-color: #334155 !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] #exampleModal #updateDoorHandednessContainer > div,
    html[light-mode="dark"] #exampleModal #updateDoorHandednessContainer > div {
        background: #1e293b !important;
        border-color: #16a34a !important;
    }

    body[light-mode="dark"] #exampleModal .door-hand-box-update,
    html[light-mode="dark"] #exampleModal .door-hand-box-update {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] #exampleModal .door-qty-input-update,
    html[light-mode="dark"] #exampleModal .door-qty-input-update {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }
</style>

<!-- Action Button Edit Modal Start -->
<section class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg d-flex flex-column">
            <!-- POS Style Primary Green Sticky Header -->
            <div class="modal-header text-white py-2 px-4 d-flex align-items-center justify-content-between flex-shrink-0" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border-bottom: 1px solid rgba(255,255,255,0.1); position: sticky; top: 0; z-index: 20; padding: 12px 20px !important;">
                <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2 m-0 fs-5" id="exampleModalLabel">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Product Update
                </h5>
                <button type="button" class="close-btn closes d-flex align-items-center justify-content-center border-0 shadow-sm" data-bs-dismiss="modal" aria-label="Close" style="width: 22px !important; height: 22px !important; min-width: 22px !important; min-height: 22px !important; border-radius: 50% !important; background: #ef4444 !important; color: #ffffff !important; font-size: 10px !important; cursor: pointer; transition: all 0.2s ease; position: relative !important; right: auto !important; top: auto !important; margin: 0 !important; padding: 0 !important;" title="Close">
                    <i class="fa-solid fa-xmark" style="font-size: 10px !important; color: #ffffff !important;"></i>
                </button>
            </div>

            <!-- Scrollable Form Body -->
            <div class="modal-body-scroll" style="padding: 18px 24px; overflow-y: auto; flex: 0 1 auto !important; height: auto !important; max-height: calc(90vh - 120px);">
                <form id="updateProductForm" onsubmit="Update(event)">
                    <input type="hidden" id="updateID">

                    <!-- Brand & Category Row -->
                    <div class="row g-2.5">
                        <div class="col-lg-6">
                            <div class="form-row flex-column align-items-start text-start">
                                <label for="UpdateProductBrand" class="fw-semibold small text-start d-block" style="margin-bottom: 2px !important; font-size: 13px; text-align: left !important;">Brand</label>
                                <div class="d-flex align-items-center w-100 gap-2">
                                    <!-- Native select kept hidden for 100% backend & DOM compatibility -->
                                    <select id="UpdateProductBrand" class="form-select d-none">
                                        <option value="">Select Brand</option>
                                    </select>

                                    <!-- Custom Searchable Brand Dropdown -->
                                    <div class="custom-searchable-select flex-grow-1" id="updateBrandDropdown">
                                        <div class="select-trigger d-flex align-items-center justify-content-between px-3" onclick="toggleCustomUpdateDropdown('updateBrandDropdown')">
                                            <span class="selected-text text-truncate" style="font-size: 14px; font-weight: 500; color: #64748b;">Select Brand</span>
                                            <i class="fa-solid fa-chevron-down ms-1 text-muted" style="font-size: 12px; transition: transform 0.2s;"></i>
                                        </div>
                                        <div class="select-menu">
                                            <div class="search-wrap">
                                                <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="top: 50%; transform: translateY(-50%); left: 10px; font-size: 12px;"></i>
                                                <input type="text" placeholder="Search Brand..." oninput="filterCustomUpdateDropdown('updateBrandDropdown', this.value)">
                                            </div>
                                            <div class="select-options-list">
                                                <!-- Brand options will load here -->
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn text-white newbrand-open text-nowrap" onclick="openBrandModal()" style="height: 42px; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); font-size: 13px; font-weight: 600; padding: 0 16px; border-radius: 8px; border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center;">+ Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-row flex-column align-items-start text-start">
                                <label for="UpdateProductCategory" class="fw-semibold small text-start d-block" style="margin-bottom: 2px !important; font-size: 13px; text-align: left !important;">Category <span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center w-100 gap-2">
                                    <!-- Native select kept hidden for 100% backend & DOM compatibility -->
                                    <select required id="UpdateProductCategory" class="form-select d-none">
                                        <option value="">Select Category</option>
                                    </select>

                                    <!-- Custom Searchable Category Dropdown -->
                                    <div class="custom-searchable-select flex-grow-1" id="updateCategoryDropdown">
                                        <div class="select-trigger d-flex align-items-center justify-content-between px-3" onclick="toggleCustomUpdateDropdown('updateCategoryDropdown')">
                                            <span class="selected-text text-truncate" style="font-size: 14px; font-weight: 500; color: #64748b;">Select Category <span class="text-danger">*</span></span>
                                            <i class="fa-solid fa-chevron-down ms-1 text-muted" style="font-size: 12px; transition: transform 0.2s;"></i>
                                        </div>
                                        <div class="select-menu">
                                            <div class="search-wrap">
                                                <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="top: 50%; transform: translateY(-50%); left: 10px; font-size: 12px;"></i>
                                                <input type="text" placeholder="Search Category..." oninput="filterCustomUpdateDropdown('updateCategoryDropdown', this.value)">
                                            </div>
                                            <div class="select-options-list">
                                                <!-- Category options will load here -->
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn text-white newcategory-open text-nowrap" onclick="openCategoryModal()" style="height: 42px; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); font-size: 13px; font-weight: 600; padding: 0 16px; border-radius: 8px; border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center;">+ Add</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Door Handedness Dynamic Selection & Quantity Inputs (Shown only when Door category is selected) -->
                    <div class="row mt-2" id="updateDoorHandednessContainer" style="display: none;">
                        <div class="col-lg-12">
                            <div class="p-3 mb-2 rounded-3" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border: 1.5px dashed #86efac;">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="fw-bold text-success m-0 d-flex align-items-center gap-2" style="font-size: 13px;">
                                        <i class="fa-solid fa-door-open fs-5 text-success"></i>
                                        <span>Door Handedness & Specific Quantities</span>
                                    </label>
                                    <span class="badge bg-success text-white px-2 py-1 small fw-bold" id="updateDoorTotalBadge">Total Door Stock: 0</span>
                                </div>
                                <div class="row g-2 mt-1">
                                    <!-- Left Handed Card & Qty Input -->
                                    <div class="col-md-4 col-12">
                                        <div class="door-hand-box-update rounded-3 bg-white border border-2 border-slate-200 shadow-sm text-center" style="border-radius: 10px; padding: 10px 12px;">
                                            <div class="d-flex align-items-center justify-content-center gap-1.5 mb-2 text-primary fw-bold" style="font-size: 13px;">
                                                <span class="fs-5">👈</span>
                                                <span>Left Handed</span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <label for="updateDoorQtyLeft" class="fw-bold text-secondary m-0" style="font-size: 12px; letter-spacing: 0.5px;">QTY:</label>
                                                <input type="number" min="0" step="any" id="updateDoorQtyLeft" class="form-control text-center fw-bold text-dark door-qty-input-update" placeholder="0" oninput="calculateUpdateDoorTotal()" style="font-size: 14px; height: 36px; max-width: 130px; border-radius: 8px;">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Handed Card & Qty Input -->
                                    <div class="col-md-4 col-12">
                                        <div class="door-hand-box-update rounded-3 bg-white border border-2 border-slate-200 shadow-sm text-center" style="border-radius: 10px; padding: 10px 12px;">
                                            <div class="d-flex align-items-center justify-content-center gap-1.5 mb-2 text-success fw-bold" style="font-size: 13px;">
                                                <span class="fs-5">👉</span>
                                                <span>Right Handed</span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <label for="updateDoorQtyRight" class="fw-bold text-secondary m-0" style="font-size: 12px; letter-spacing: 0.5px;">QTY:</label>
                                                <input type="number" min="0" step="any" id="updateDoorQtyRight" class="form-control text-center fw-bold text-dark door-qty-input-update" placeholder="0" oninput="calculateUpdateDoorTotal()" style="font-size: 14px; height: 36px; max-width: 130px; border-radius: 8px;">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Both / Universal Card & Qty Input -->
                                    <div class="col-md-4 col-12">
                                        <div class="door-hand-box-update rounded-3 bg-white border border-2 border-slate-200 shadow-sm text-center" style="border-radius: 10px; padding: 10px 12px;">
                                            <div class="d-flex align-items-center justify-content-center gap-1.5 mb-2 text-info fw-bold" style="font-size: 13px;">
                                                <span class="fs-5">↔️</span>
                                                <span>Both / Universal</span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <label for="updateDoorQtyBoth" class="fw-bold text-secondary m-0" style="font-size: 12px; letter-spacing: 0.5px;">QTY:</label>
                                                <input type="number" min="0" step="any" id="updateDoorQtyBoth" class="form-control text-center fw-bold text-dark door-qty-input-update" placeholder="0" oninput="calculateUpdateDoorTotal()" style="font-size: 14px; height: 36px; max-width: 130px; border-radius: 8px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="updateSelectedDoorSide" value="">
                            </div>
                        </div>
                    </div>

                    <!-- Image Upload with Live Preview (matching Add Product layout) -->
                    <div class="row mt-2 g-2.5">
                        <div class="col-lg-12 text-start">
                            <label class="fw-semibold small text-start d-block" style="margin-bottom: 2px !important; font-size: 13px; text-align: left !important;">Product Photo</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="update-img-box flex-shrink-0" title="Product Image Preview">
                                    <img id="UpdateShowImage" src="{{ asset('backend/assets/img/product-img.svg') }}" alt="Product Image Preview">
                                </div>

                                <div class="flex-grow-1 text-start">
                                    <label class="update-file-btn-wrapper mb-1">
                                        <i class="fa-solid fa-arrow-up-from-bracket me-2 text-primary"></i> Upload Photo
                                        <input type="file" id="UpdateProductImage" accept="image/*" />
                                    </label>
                                    <div class="mt-1 update-file-info text-start" style="font-size: 12px; color: #64748b; line-height: 1.4; text-align: left !important;">
                                        <span style="text-align: left !important; display: block;">PNG, JPEG or GIF (up to 1 MB)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Name -->
                    <div class="row mt-2">
                        <div class="col-lg-12 text-start">
                            <div class="form-row flex-column align-items-start text-start">
                                <label for="UpdateProductName" class="fw-semibold small text-start d-block mb-1" style="font-size: 13px; text-align: left !important;">Product Name <span class="text-danger">*</span></label>
                                <input type="text" id="UpdateProductName" class="form-control" placeholder="Product Name *" required style="width: 100%; height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;" />
                            </div>
                        </div>
                    </div>

                    <!-- Quantity, Cost Price, Selling Price, Status -->
                    <div class="row mt-2 g-2.5">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-row flex-column align-items-start">
                                <label for="UpdateProductQuantity" class="fw-semibold small" style="display: block; margin-bottom: 2px !important; font-size: 13px;">Quantity</label>
                                <input type="number" step="any" id="UpdateProductQuantity" class="form-control" placeholder="Quantity" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-row flex-column align-items-start">
                                <label for="UpdateProductCostPrice" class="fw-semibold small" style="display: block; margin-bottom: 2px !important; font-size: 13px;">Cost Price</label>
                                <input type="number" step="any" id="UpdateProductCostPrice" class="form-control" placeholder="Cost Price" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-row flex-column align-items-start">
                                <label for="UpdateProductSellingPrice" class="fw-semibold small" style="display: block; margin-bottom: 2px !important; font-size: 13px;">Selling Price</label>
                                <input type="number" step="any" id="UpdateProductSellingPrice" class="form-control" placeholder="Selling Price" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-row flex-column align-items-start">
                                <label for="UpdateProductStatus" class="fw-semibold small" style="display: block; margin-bottom: 2px !important; font-size: 13px;">Status</label>
                                <select id="UpdateProductStatus" class="form-select" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;">
                                    <option value="Active">Active</option>
                                    <option value="InActive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Barcode Section -->
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <div class="form-row flex-column align-items-start">
                                <label for="ProductBarCodeInput" class="fw-semibold small" style="display: block; margin-bottom: 2px !important; font-size: 13px;">Barcode / Product Code</label>
                                <div class="d-flex align-items-center gap-2 w-100">
                                    <input type="text" id="ProductBarCodeInput" class="form-control" placeholder="Enter or scan barcode..." style="flex: 1; height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;" />
                                    <button type="button" class="btn text-white fw-bold text-nowrap d-flex align-items-center gap-2 px-3 shadow-sm" onclick="openProductUpdateCameraScanner()" style="height: 42px; border-radius: 8px; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none;">
                                        <i class="fa-solid fa-camera fs-5"></i>
                                        <span class="d-none d-sm-inline">Camera Scan</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Sticky Footer (Fixed at Bottom matching Add Product) -->
            <div class="modal-footer px-4 py-2.5 d-flex align-items-center justify-content-end gap-2 flex-shrink-0" style="position: sticky; bottom: 0; z-index: 20; border-top: 1px solid #e2e8f0 !important; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; background: #ffffff;">
                <button type="button" class="btn fw-semibold px-4" data-bs-dismiss="modal" style="height: 40px; border-radius: 8px; font-size: 14px; background-color: #dc2626 !important; color: #ffffff !important; border: none !important; cursor: pointer; transition: opacity 0.2s;">Close</button>
                <button type="button" onclick="Update(event)" class="btn text-white fw-bold px-5 shadow-sm" style="height: 40px; border-radius: 8px; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none; font-size: 14px; cursor: pointer;"><i class="fa-solid fa-check me-1"></i> Save Changes</button>
            </div>
        </div>
    </div>
</section>
<!-- Action Button Edit Modal End -->

<script>
    let isFormLoading = false;

    // Custom Searchable Dropdown Helper Functions for Update Modal
    function toggleCustomUpdateDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        if (!dropdown) return;
        const isOpen = dropdown.classList.contains('is-open');

        closeAllCustomUpdateDropdowns();

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
                filterCustomUpdateDropdown(dropdownId, '');
                setTimeout(() => searchInput.focus(), 60);
            }
        }
    }

    function closeAllCustomUpdateDropdowns() {
        document.querySelectorAll('#exampleModal .custom-searchable-select').forEach(d => {
            d.classList.remove('is-open');
            const chevron = d.querySelector('.fa-chevron-down');
            if (chevron) chevron.style.transform = 'rotate(0deg)';
        });
        document.querySelectorAll('#exampleModal .col-lg-6').forEach(col => {
            col.classList.remove('has-open-dropdown');
            col.style.zIndex = '';
            col.style.position = '';
        });
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#exampleModal .custom-searchable-select')) {
            closeAllCustomUpdateDropdowns();
        }
    });

    function filterCustomUpdateDropdown(dropdownId, searchVal) {
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
                noResultEl.textContent = 'No results found';
                listEl.appendChild(noResultEl);
            }
        } else if (noResultEl) {
            noResultEl.remove();
        }
    }

    function selectCustomUpdateDropdownItem(dropdownId, hiddenInputId, val, label) {
        const dropdown = document.getElementById(dropdownId);
        const hiddenInput = document.getElementById(hiddenInputId);
        const triggerText = dropdown ? dropdown.querySelector('.selected-text') : null;

        if (hiddenInput) {
            hiddenInput.value = val;
            $(hiddenInput).trigger('change');
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

        closeAllCustomUpdateDropdowns();
    }

    function updateCustomDropdownSelected(dropdownId, val) {
        const dropdown = document.getElementById(dropdownId);
        if (!dropdown) return;
        const triggerText = dropdown.querySelector('.selected-text');
        let matchedLabel = '';

        dropdown.querySelectorAll('.select-option-item').forEach(item => {
            if (item.getAttribute('data-value') === String(val)) {
                item.classList.add('active');
                matchedLabel = item.getAttribute('data-label');
                if (!item.querySelector('.fa-check')) {
                    item.innerHTML = `<span>${matchedLabel}</span><i class="fa-solid fa-check small text-success"></i>`;
                }
            } else {
                item.classList.remove('active');
                const check = item.querySelector('.fa-check');
                if (check) check.remove();
            }
        });

        if (matchedLabel && triggerText) {
            triggerText.textContent = matchedLabel;
            triggerText.style.color = '#0f172a';
        }
    }

    function resetCustomUpdateDropdown(dropdownId, hiddenInputId, defaultText = "Select Option", defaultVal = "") {
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
        filterCustomUpdateDropdown(dropdownId, '');

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

    // Door Handedness helpers for Update Modal
    function calculateUpdateDoorTotal() {
        let left = parseFloat($('#updateDoorQtyLeft').val()) || 0;
        let right = parseFloat($('#updateDoorQtyRight').val()) || 0;
        let both = parseFloat($('#updateDoorQtyBoth').val()) || 0;
        let total = left + right + both;

        $('#updateDoorTotalBadge').text(`Total Door Stock: ${total}`);
        $('#UpdateProductQuantity').val(total);

        // Highlight active cards
        $('#updateDoorQtyLeft').closest('.door-hand-box-update').toggleClass('border-primary shadow', left > 0);
        $('#updateDoorQtyRight').closest('.door-hand-box-update').toggleClass('border-success shadow', right > 0);
        $('#updateDoorQtyBoth').closest('.door-hand-box-update').toggleClass('border-info shadow', both > 0);

        // Set primary door side value
        if (left > 0 && right === 0 && both === 0) {
            $('#updateSelectedDoorSide').val('Left Handed');
        } else if (right > 0 && left === 0 && both === 0) {
            $('#updateSelectedDoorSide').val('Right Handed');
        } else if (both > 0 && left === 0 && right === 0) {
            $('#updateSelectedDoorSide').val('Both Handed');
        } else if (total > 0) {
            $('#updateSelectedDoorSide').val('Multi Handed');
        } else {
            $('#updateSelectedDoorSide').val('');
        }
    }

    function resetUpdateDoorSide() {
        $('#updateDoorQtyLeft').val('');
        $('#updateDoorQtyRight').val('');
        $('#updateDoorQtyBoth').val('');
        $('#updateSelectedDoorSide').val('');
        $('#updateDoorTotalBadge').text('Total Door Stock: 0');
        $('#updateDoorHandednessContainer').hide();
        $('.door-hand-box-update').removeClass('border-primary border-success border-info shadow');
    }

    function checkUpdateDoorCategory() {
        const selectedText = ($('#UpdateProductCategory option:selected').text() || '').toLowerCase().trim();
        if (selectedText.includes('door')) {
            $('#updateDoorHandednessContainer').slideDown(200);
            calculateUpdateDoorTotal();
        } else {
            $('#updateDoorHandednessContainer').slideUp(200);
            resetUpdateDoorSide();
        }
    }

    $(document).ready(function() {
        // Category change listener for door check
        $('#UpdateProductCategory').on('change', checkUpdateDoorCategory);

        // Image preview listener
        $('#UpdateProductImage').on('change', function() {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#UpdateShowImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        // Modal hidden listener to reset form
        $('#exampleModal').on('hidden.bs.modal', function() {
            $('#updateProductForm')[0].reset();
            $('#updateID').val('');
            $('#UpdateShowImage').attr('src', "{{ asset('backend/assets/img/product-img.svg') }}");
            resetUpdateDoorSide();
            closeAllCustomUpdateDropdowns();
            resetCustomUpdateDropdown('updateBrandDropdown', 'UpdateProductBrand', 'Select Brand', '');
            resetCustomUpdateDropdown('updateCategoryDropdown', 'UpdateProductCategory', 'Select Category *', '');
        });

        // Modal show listener (bootstrap fallback)
        $('#exampleModal').on('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            if (button) {
                const id = $(button).attr('data-id') || $(button).data('id') || $(button).closest('[data-id]').attr('data-id');
                if (id) {
                    FillUpUpdateForm(id);
                }
            }
        });
    });

    // Helper functions to load dropdown options
    async function ProductCategoryShow(selectedCategoryId = null) {
        try {
            const res = await axios.get("/api/category-list", HeaderToken());
            if (res.status === 200 && res.data.CategoryData) {
                const optionsHtml = res.data.CategoryData.map(Category =>
                    `<option value="${Category.id}">${Category.category_name}</option>`
                ).join('');
                $('#UpdateProductCategory').html(`<option value="">Select Category</option>` + optionsHtml);
                if (selectedCategoryId) {
                    $('#UpdateProductCategory').val(String(selectedCategoryId));
                }

                // Populate custom searchable category dropdown
                const catCustomList = document.querySelector('#updateCategoryDropdown .select-options-list');
                const catTriggerText = document.querySelector('#updateCategoryDropdown .selected-text');
                if (catCustomList) {
                    let currentVal = selectedCategoryId ? String(selectedCategoryId) : ($('#UpdateProductCategory').val() || '');
                    let defaultLabel = 'Select Category *';

                    let html = `<div class="select-option-item ${(!currentVal || currentVal === 'none') ? 'active' : ''}" data-value="" data-label="Select Category" onclick="selectCustomUpdateDropdownItem('updateCategoryDropdown', 'UpdateProductCategory', '', 'Select Category *')">
                        <span>Select Category</span>
                        ${(!currentVal || currentVal === 'none') ? '<i class="fa-solid fa-check small text-success"></i>' : ''}
                    </div>`;

                    res.data.CategoryData.forEach(c => {
                        const isSelected = String(currentVal) === String(c.id);
                        if (isSelected) defaultLabel = c.category_name;
                        html += `<div class="select-option-item ${isSelected ? 'active' : ''}" data-value="${c.id}" data-label="${c.category_name}" onclick="selectCustomUpdateDropdownItem('updateCategoryDropdown', 'UpdateProductCategory', '${c.id}', '${c.category_name}')">
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
            }
        } catch (error) {
            console.error("Category Load Error:", error);
        }
    }

    async function ProductBrandShow(selectedBrandId = null) {
        try {
            const res = await axios.get("/api/brand-list", HeaderToken());
            if (res.status === 200 && res.data.BrandData) {
                const optionsHtml = res.data.BrandData.map(Brand =>
                    `<option value="${Brand.id}">${Brand.name}</option>`
                ).join('');
                $('#UpdateProductBrand').html(`<option value="">Select Brand</option>` + optionsHtml);
                if (selectedBrandId) {
                    $('#UpdateProductBrand').val(String(selectedBrandId));
                }

                // Populate custom searchable brand dropdown
                const brandCustomList = document.querySelector('#updateBrandDropdown .select-options-list');
                const brandTriggerText = document.querySelector('#updateBrandDropdown .selected-text');
                if (brandCustomList) {
                    let currentVal = selectedBrandId ? String(selectedBrandId) : ($('#UpdateProductBrand').val() || '');
                    let defaultLabel = 'Select Brand';

                    let html = `<div class="select-option-item ${(!currentVal || currentVal === 'none') ? 'active' : ''}" data-value="" data-label="Select Brand" onclick="selectCustomUpdateDropdownItem('updateBrandDropdown', 'UpdateProductBrand', '', 'Select Brand')">
                        <span>Select Brand</span>
                        ${(!currentVal || currentVal === 'none') ? '<i class="fa-solid fa-check small text-success"></i>' : ''}
                    </div>`;

                    res.data.BrandData.forEach(b => {
                        const isSelected = String(currentVal) === String(b.id);
                        if (isSelected) defaultLabel = b.name;
                        html += `<div class="select-option-item ${isSelected ? 'active' : ''}" data-value="${b.id}" data-label="${b.name}" onclick="selectCustomUpdateDropdownItem('updateBrandDropdown', 'UpdateProductBrand', '${b.id}', '${b.name}')">
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
            }
        } catch (error) {
            console.error("Brand Load Error:", error);
        }
    }

    // Main Edit Form Population Function
    async function FillUpUpdateForm(id) {
        if (!id) return;

        try {
            $('#updateID').val(id);

            // Find data in window cache or call API
            let data = null;
            if (window.allProductsList && Array.isArray(window.allProductsList)) {
                data = window.allProductsList.find(p => String(p.id) === String(id));
            }

            if (!data) {
                showLoader();
                let res = await axios.post("/api/product-by-id", {
                    id: String(id)
                }, HeaderToken());
                hideLoader();
                data = res.data.rows || res.data.product || res.data;
            }

            if (!data) {
                return errorToast("Product data not found!");
            }

            // Fill form inputs
            $('#UpdateProductName').val(data.product_name || '');
            $('#UpdateProductQuantity').val(data.quantity !== undefined ? data.quantity : '');
            $('#UpdateProductCostPrice').val(data.cost_price !== undefined ? data.cost_price : '');
            $('#UpdateProductSellingPrice').val(data.sell_price !== undefined ? data.sell_price : '');
            $('#UpdateProductStatus').val(data.status || 'Active');

            // Load dropdowns and preselect current values
            await Promise.all([
                ProductBrandShow(data.brand_id),
                ProductCategoryShow(data.category_id)
            ]);

            if (data.brand_id) {
                $('#UpdateProductBrand').val(String(data.brand_id));
                updateCustomDropdownSelected('updateBrandDropdown', String(data.brand_id));
            } else {
                resetCustomUpdateDropdown('updateBrandDropdown', 'UpdateProductBrand', 'Select Brand', '');
            }
            if (data.category_id) {
                $('#UpdateProductCategory').val(String(data.category_id));
                updateCustomDropdownSelected('updateCategoryDropdown', String(data.category_id));
                checkUpdateDoorCategory();
            } else {
                resetCustomUpdateDropdown('updateCategoryDropdown', 'UpdateProductCategory', 'Select Category *', '');
            }

            // Image preview
            const defaultImg = "{{ asset('backend/assets/img/product-img.svg') }}";
            let imgUrl = defaultImg;
            if (data.img_url) {
                imgUrl = data.img_url.startsWith('http') ? data.img_url : '/' + data.img_url.replace(/^\/+/, '');
            }
            $('#UpdateShowImage').attr('src', imgUrl);

            // Barcode value directly into input
            let barcodeVal = '';
            if (typeof data.product_code === 'string') {
                try {
                    let parsed = JSON.parse(data.product_code);
                    if (Array.isArray(parsed)) {
                        barcodeVal = parsed.join(', ');
                    } else if (parsed) {
                        barcodeVal = String(parsed);
                    }
                } catch (e) {
                    barcodeVal = data.product_code;
                }
            } else if (Array.isArray(data.product_code)) {
                barcodeVal = data.product_code.join(', ');
            } else if (data.product_code) {
                barcodeVal = String(data.product_code);
            }
            $('#ProductBarCodeInput').val(barcodeVal);

            // Check and populate Door Handedness & Quantities
            const categoryName = (data.category ? data.category.category_name : $('#UpdateProductCategory option:selected').text() || '').toLowerCase();
            if (categoryName.includes('door') || data.door_side) {
                $('#updateDoorHandednessContainer').show();

                let leftQty = 0;
                let rightQty = 0;
                let bothQty = 0;

                if (window.allProductsList && Array.isArray(window.allProductsList)) {
                    let pName = (data.product_name || '').trim().toLowerCase();
                    let catId = data.category_id;
                    let brandId = data.brand_id;

                    let sameVariants = window.allProductsList.filter(p => {
                        let matchName = (p.product_name || '').trim().toLowerCase() === pName;
                        let matchCat = String(p.category_id) === String(catId);
                        let matchBrand = (!brandId && !p.brand_id) || String(p.brand_id) === String(brandId);
                        return matchName && matchCat && matchBrand;
                    });

                    if (sameVariants.length > 0) {
                        sameVariants.forEach(v => {
                            let side = (v.door_side || '').toLowerCase();
                            let q = parseFloat(v.quantity) || 0;
                            if (side.includes('left')) leftQty += q;
                            else if (side.includes('right')) rightQty += q;
                            else if (side.includes('both')) bothQty += q;
                            else if (data.door_side) {
                                if (data.door_side.toLowerCase().includes('left')) leftQty += q;
                                else if (data.door_side.toLowerCase().includes('right')) rightQty += q;
                                else if (data.door_side.toLowerCase().includes('both')) bothQty += q;
                            } else {
                                leftQty += q;
                            }
                        });
                    }
                }

                if (leftQty === 0 && rightQty === 0 && bothQty === 0) {
                    let side = (data.door_side || '').toLowerCase();
                    let q = parseFloat(data.quantity) || 0;
                    if (side.includes('left')) leftQty = q;
                    else if (side.includes('right')) rightQty = q;
                    else if (side.includes('both')) bothQty = q;
                    else leftQty = q;
                }

                $('#updateDoorQtyLeft').val(leftQty > 0 ? leftQty : '');
                $('#updateDoorQtyRight').val(rightQty > 0 ? rightQty : '');
                $('#updateDoorQtyBoth').val(bothQty > 0 ? bothQty : '');
                calculateUpdateDoorTotal();
            } else {
                resetUpdateDoorSide();
            }

        } catch (e) {
            hideLoader();
            console.error("FillUpUpdateForm Error:", e);
            errorToast("Error loading product data!");
        }
    }

    // Submit Update
    async function Update(e) {
        if (e) e.preventDefault();
        try {
            const id = $('#updateID').val();
            if (!id) return errorToast("Product ID missing!");

            const categoryId = $('#UpdateProductCategory').val();
            if (!categoryId || categoryId === "none" || categoryId === "") return errorToast("Category is required!");

            const brandId = $('#UpdateProductBrand').val();
            const status = $('#UpdateProductStatus').val() || 'Active';

            const productName = $('#UpdateProductName').val().trim();
            if (!productName) return errorToast("Product Name is required!");

            const quantityVal = $('#UpdateProductQuantity').val() ? String($('#UpdateProductQuantity').val()).trim() : '';
            const costPriceVal = $('#UpdateProductCostPrice').val() ? String($('#UpdateProductCostPrice').val()).trim() : '';
            const sellPriceVal = $('#UpdateProductSellingPrice').val() ? String($('#UpdateProductSellingPrice').val()).trim() : '';

            const quantity = (quantityVal !== "" && !isNaN(quantityVal)) ? quantityVal : 0;
            const costPrice = (costPriceVal !== "" && !isNaN(costPriceVal)) ? costPriceVal : 0;
            const sellPrice = (sellPriceVal !== "" && !isNaN(sellPriceVal)) ? sellPriceVal : 0;

            // Barcode input value directly
            const rawBarcode = $('#ProductBarCodeInput').val().trim();
            const barcodeArr = rawBarcode ? rawBarcode.split(',').map(s => s.trim()).filter(Boolean) : [];

            let formData = new FormData();
            formData.append('id', id);
            formData.append('product_name', productName);
            formData.append('quantity', quantity);
            formData.append('cost_price', costPrice);
            formData.append('sell_price', sellPrice);
            formData.append('status', status);
            formData.append('product_code', JSON.stringify(barcodeArr));

            if (brandId && brandId !== "none") formData.append('brand_id', brandId);
            if (categoryId && categoryId !== "none") formData.append('category_id', categoryId);

            const isDoorVisible = $('#updateDoorHandednessContainer').is(':visible');
            if (isDoorVisible) {
                const leftQty = parseFloat($('#updateDoorQtyLeft').val()) || 0;
                const rightQty = parseFloat($('#updateDoorQtyRight').val()) || 0;
                const bothQty = parseFloat($('#updateDoorQtyBoth').val()) || 0;

                formData.append('door_qty_left', leftQty);
                formData.append('door_qty_right', rightQty);
                formData.append('door_qty_both', bothQty);

                const selectedDoorSide = $('#updateSelectedDoorSide').val();
                if (selectedDoorSide) {
                    formData.append('door_side', selectedDoorSide);
                }
            } else {
                formData.append('door_side', '');
            }

            const imageInput = document.getElementById('UpdateProductImage');
            if (imageInput && imageInput.files && imageInput.files[0]) {
                formData.append('img_url', imageInput.files[0]);
            }

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            showLoader();
            let res = await axios.post("/api/update-product", formData, config);
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message || "Product updated successfully");
                $('#exampleModal').modal('hide');
                if (typeof getList === 'function') {
                    await getList();
                } else {
                    location.reload();
                }
            } else {
                errorToast(res.data.message || "Update failed");
            }
        } catch (e) {
            hideLoader();
            console.error("Update Error:", e);
            errorToast(e.response && e.response.data && e.response.data.message ? e.response.data.message : "Something went wrong!");
        }
    }
</script>

<!-- Update Product Camera Barcode Scanner Modal -->
<div class="modal fade" id="productUpdateCameraScanModal" tabindex="-1" aria-labelledby="productUpdateCameraScanModalLabel" aria-hidden="true" data-bs-backdrop="static" style="z-index: 999999 !important;">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 18px; overflow: hidden;">
            <div class="modal-header text-white py-3" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%);">
                <h5 class="modal-title fw-bold" id="productUpdateCameraScanModalLabel">
                    <i class="fa-solid fa-camera me-2"></i> Barcode Camera Scanner (Edit)
                </h5>
                <button type="button" class="btn-close btn-close-white" onclick="stopProductUpdateCameraScanner()"></button>
            </div>
            <div class="modal-body p-3 text-center">
                <div id="productUpdateCameraScannerStatus" class="alert alert-info py-2 small mb-3" style="border-radius: 10px;">
                    <i class="fa-solid fa-circle-notch fa-spin me-1"></i> Starting camera... Hold barcode in front of camera.
                </div>

                <!-- Reader Viewport -->
                <div id="product-update-reader" style="width: 100%; min-height: 270px; background: #000; border-radius: 14px; overflow: hidden;" class="shadow-sm"></div>

                <div class="d-flex align-items-center justify-content-between mt-3 px-1">
                    <span id="productUpdateLastScannedText" class="badge bg-success fs-6 py-2 px-3" style="border-radius: 10px;">Scanned Code: -</span>
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="switchProductUpdateCamera()">
                        <i class="fa-solid fa-rotate me-1"></i> Switch Camera
                    </button>
                </div>
            </div>
            <div class="modal-footer bg-light py-2 justify-content-between">
                <small class="text-muted"><i class="fa-solid fa-bolt text-warning me-1"></i> Barcode will be entered automatically upon scan</small>
                <button type="button" class="btn btn-secondary px-4 fw-bold rounded-pill" onclick="stopProductUpdateCameraScanner()">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    let productUpdateHtml5QrCode = null;
    let productUpdateFacingMode = "environment";
    let productUpdateLastCode = "";

    function openProductUpdateCameraScanner() {
        const modalEl = document.getElementById('productUpdateCameraScanModal');
        const modalObj = new bootstrap.Modal(modalEl);
        modalObj.show();
        setTimeout(() => {
            modalEl.style.zIndex = "999999";
            const backdrops = document.querySelectorAll('.modal-backdrop');
            if (backdrops.length > 0) {
                backdrops[backdrops.length - 1].style.zIndex = "999990";
            }
            startProductUpdateCameraScanner();
        }, 300);
    }

    function startProductUpdateCameraScanner() {
        if (productUpdateHtml5QrCode && productUpdateHtml5QrCode.isScanning) {
            productUpdateHtml5QrCode.stop().then(() => initProductUpdateHtml5QrCode()).catch(() => initProductUpdateHtml5QrCode());
        } else {
            initProductUpdateHtml5QrCode();
        }
    }

    function initProductUpdateHtml5QrCode() {
        const statusEl = document.getElementById("productUpdateCameraScannerStatus");
        if (statusEl) {
            statusEl.className = "alert alert-info py-2 small mb-3";
            statusEl.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-1"></i> Starting camera... Bring barcode in front of camera.';
        }

        if (!productUpdateHtml5QrCode) {
            productUpdateHtml5QrCode = new Html5Qrcode("product-update-reader");
        }

        const config = {
            fps: 15,
            qrbox: {
                width: 260,
                height: 160
            },
            aspectRatio: 1.333334
        };

        productUpdateHtml5QrCode.start({
                facingMode: productUpdateFacingMode
            },
            config,
            onProductUpdateBarcodeDetected,
            onProductUpdateBarcodeError
        ).then(() => {
            if (statusEl) {
                statusEl.className = "alert alert-success py-2 small mb-3";
                statusEl.innerHTML = '<i class="fa-solid fa-video me-1"></i> Camera active! Scanned barcode will be added directly.';
            }
        }).catch(err => {
            console.error("Camera start error:", err);
            if (statusEl) {
                statusEl.className = "alert alert-danger py-2 small mb-3";
                statusEl.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> Could not access camera! Please allow camera permissions in browser.';
            }
        });
    }

    function onProductUpdateBarcodeDetected(decodedText) {
        if (!decodedText || decodedText === productUpdateLastCode) return;

        productUpdateLastCode = decodedText;
        const lastTextEl = document.getElementById("productUpdateLastScannedText");
        if (lastTextEl) lastTextEl.innerText = `Scanned: ${decodedText}`;

        if (navigator.vibrate) navigator.vibrate(100);

        // Fill barcode into ProductBarCodeInput
        const input = document.getElementById("ProductBarCodeInput");
        if (input) {
            input.value = decodedText;
        }

        stopProductUpdateCameraScanner();
    }

    function onProductUpdateBarcodeError(msg) {}

    function switchProductUpdateCamera() {
        productUpdateFacingMode = (productUpdateFacingMode === "environment") ? "user" : "environment";
        startProductUpdateCameraScanner();
    }

    function stopProductUpdateCameraScanner() {
        if (productUpdateHtml5QrCode && productUpdateHtml5QrCode.isScanning) {
            productUpdateHtml5QrCode.stop().then(() => {
                productUpdateHtml5QrCode.clear();
                hideProductUpdateCameraModal();
            }).catch(() => {
                hideProductUpdateCameraModal();
            });
        } else {
            hideProductUpdateCameraModal();
        }
    }

    function hideProductUpdateCameraModal() {
        const modalEl = document.getElementById('productUpdateCameraScanModal');
        const instance = bootstrap.Modal.getInstance(modalEl);
        if (instance) instance.hide();
    }
</script>