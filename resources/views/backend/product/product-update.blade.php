<style>
    #exampleModal .modal-dialog {
        max-width: 65%;
        height: auto;
    }

    #exampleModal form .form-row {
        margin-bottom: 12px;
    }

    #exampleModal form select,
    #exampleModal form input[type="text"],
    #exampleModal form input[type="number"] {
        width: 100%;
        height: 44px;
        border-radius: 6px;
        border: 1px solid #ced4da;
        padding: 8px 12px;
        font-size: 14px;
    }

    #exampleModal .img-box-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
        background: #f8f9fa;
        padding: 10px;
        border-radius: 8px;
        border: 1px dashed #ced4da;
    }

    #exampleModal .img-box-preview {
        width: 80px;
        height: 80px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #ddd;
        background-color: #fff;
    }

    #exampleModal .btn-save {
        background-color: #15803d;
        color: #fff;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 6px;
        border: none;
        transition: background-color 0.2s ease;
    }

    #exampleModal .btn-save:hover {
        background-color: #166534;
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
</style>

<!-- Action Button Edit Modal Start -->
<section class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-3">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-success" id="exampleModalLabel">
                    <i class="fa-solid fa-pen-to-square me-2"></i>Product Update
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="updateProductForm" onsubmit="Update(event)">
                    <input type="hidden" id="updateID">

                    <!-- Brand & Category Row -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-row">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <label for="UpdateProductBrand" class="form-label fw-semibold small m-0">Brand</label>
                                    <button type="button" class="btn btn-sm text-white newbrand-open" onclick="openBrandModal()" style="background-color: #15803d; font-size: 12px; font-weight: 600; padding: 2px 10px; border-radius: 4px; border: none; cursor: pointer;">
                                        + Add
                                    </button>
                                </div>
                                <select id="UpdateProductBrand" class="form-select">
                                    <option value="">Select Brand</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-row">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <label for="UpdateProductCategory" class="form-label fw-semibold small m-0">Category <span class="text-danger">*</span></label>
                                    <button type="button" class="btn btn-sm text-white newcategory-open" onclick="openCategoryModal()" style="background-color: #15803d; font-size: 12px; font-weight: 600; padding: 2px 10px; border-radius: 4px; border: none; cursor: pointer;">
                                        + Add
                                    </button>
                                </div>
                                <select required id="UpdateProductCategory" class="form-select">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Door Handedness Dynamic Selection & Quantity Inputs (Shown only when Door category is selected) -->
                    <div class="row mt-1" id="updateDoorHandednessContainer" style="display: none;">
                        <div class="col-lg-12">
                            <div class="p-3 mb-2 rounded-3" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border: 1.5px dashed #86efac;">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="fw-bold text-success m-0 d-flex align-items-center gap-2" style="font-size: 13px;">
                                        <i class="fa-solid fa-door-open fs-5 text-success"></i>
                                        <span>Door Handedness & Specific Quantities (ডোর সাইড অনুযায়ী স্টক এন্ট্রি)</span>
                                    </label>
                                    <span class="badge bg-success text-white px-2 py-1 small fw-bold" id="updateDoorTotalBadge">মোট ডোর স্টক: 0</span>
                                </div>
                                <div class="row g-2 mt-1">
                                    <!-- Left Handed Card & Qty Input -->
                                    <div class="col-md-4 col-12">
                                        <div class="door-hand-box-update rounded-3 bg-white border border-2 border-slate-200 shadow-sm text-center" style="border-radius: 10px; padding: 10px 12px;">
                                            <div class="d-flex align-items-center justify-content-center gap-1.5 mb-2 text-primary fw-bold" style="font-size: 13px;">
                                                <span class="fs-5">👈</span>
                                                <span>Left Handed (বাম)</span>
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
                                                <span>Right Handed (ডান)</span>
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
                                                <span>Both / Universal (উভয়)</span>
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

                    <!-- Image Upload with Live Preview -->
                    <div class="row my-2">
                        <div class="col-lg-12">
                            <div class="img-box-wrapper">
                                <img id="UpdateShowImage" src="{{ asset('backend/assets/img/product-img.svg') }}" class="img-box-preview" alt="Product Image Preview">
                                <div class="flex-grow-1">
                                    <label for="UpdateProductImage" class="form-label fw-semibold small mb-1">Product Photo</label>
                                    <input type="file" id="UpdateProductImage" class="form-control" accept="image/*" />
                                    <div class="form-text text-muted small">JPG, PNG or GIF (Recommended max 1MB)</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Name & Translation -->
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <div class="form-row">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <label for="UpdateProductName" class="form-label fw-semibold small m-0 text-success">Product Name <span class="text-danger">*</span></label>
                                    <button type="button" id="translateUpdateBtn" onclick="translateUpdateProductName()" class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1 py-1 px-2" style="font-size: 12px; font-weight: 600;">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                        </svg>
                                        <span>বাংলায় রূপান্তর</span>
                                    </button>
                                </div>
                                <input type="text" id="UpdateProductName" class="form-control" placeholder="Enter Product Name (বাংলা / English)..." required />
                            </div>
                        </div>
                    </div>

                    <!-- Quantity, Cost Price, Selling Price, Status -->
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-row">
                                <label for="UpdateProductQuantity" class="form-label fw-semibold small mb-1">Quantity</label>
                                <input type="number" step="any" id="UpdateProductQuantity" class="form-control" placeholder="0" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-row">
                                <label for="UpdateProductCostPrice" class="form-label fw-semibold small mb-1">Cost Price</label>
                                <input type="number" step="any" id="UpdateProductCostPrice" class="form-control" placeholder="0.00" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-row">
                                <label for="UpdateProductSellingPrice" class="form-label fw-semibold small mb-1">Selling Price</label>
                                <input type="number" step="any" id="UpdateProductSellingPrice" class="form-control" placeholder="0.00" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-row">
                                <label for="UpdateProductStatus" class="form-label fw-semibold small mb-1">Status</label>
                                <select id="UpdateProductStatus" class="form-select">
                                    <option value="Active">Active</option>
                                    <option value="InActive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Barcode Section -->
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <div class="form-row">
                                <label for="ProductBarCodeInput" class="form-label fw-semibold small mb-1">Product Barcode</label>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="text" id="ProductBarCodeInput" class="form-control" placeholder="Enter or scan barcode..." />
                                    <button type="button" class="btn btn-primary fw-bold text-nowrap d-flex align-items-center gap-2 px-3 shadow-sm" onclick="openProductUpdateCameraScanner()" style="height: 38px; border-radius: 8px; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none;">
                                        <i class="fa-solid fa-camera fs-6"></i>
                                        <span class="d-none d-sm-inline">ক্যামেরা স্ক্যান</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 px-0 pb-0 mt-3">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn-save px-4"><i class="fa-solid fa-check me-1"></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Action Button Edit Modal End -->

<script>
    let isFormLoading = false;

    // Door Handedness helpers for Update Modal
    function calculateUpdateDoorTotal() {
        let left = parseFloat($('#updateDoorQtyLeft').val()) || 0;
        let right = parseFloat($('#updateDoorQtyRight').val()) || 0;
        let both = parseFloat($('#updateDoorQtyBoth').val()) || 0;
        let total = left + right + both;

        $('#updateDoorTotalBadge').text(`মোট ডোর স্টক: ${total}`);
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
        $('#updateDoorTotalBadge').text('মোট ডোর স্টক: 0');
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
            }
        } catch (error) {
            console.error("Brand Load Error:", error);
        }
    }

    async function translateUpdateProductName() {
        const nameInput = document.getElementById('UpdateProductName');
        const text = nameInput ? nameInput.value.trim() : '';

        if (!text) {
            errorToast("অনুগ্রহ করে প্রথমে প্রোডাক্টের নাম লিখুন!");
            return;
        }

        const translateBtn = document.getElementById('translateUpdateBtn');
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
            }
            if (data.category_id) {
                $('#UpdateProductCategory').val(String(data.category_id));
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
                    <i class="fa-solid fa-camera me-2"></i> বারকোড ক্যামেরা স্ক্যানার (Edit)
                </h5>
                <button type="button" class="btn-close btn-close-white" onclick="stopProductUpdateCameraScanner()"></button>
            </div>
            <div class="modal-body p-3 text-center">
                <div id="productUpdateCameraScannerStatus" class="alert alert-info py-2 small mb-3" style="border-radius: 10px;">
                    <i class="fa-solid fa-circle-notch fa-spin me-1"></i> ক্যামেরা শুরু হচ্ছে... বারকোড ক্যামেরার সামনে রাখুন।
                </div>

                <!-- Reader Viewport -->
                <div id="product-update-reader" style="width: 100%; min-height: 270px; background: #000; border-radius: 14px; overflow: hidden;" class="shadow-sm"></div>

                <div class="d-flex align-items-center justify-content-between mt-3 px-1">
                    <span id="productUpdateLastScannedText" class="badge bg-success fs-6 py-2 px-3" style="border-radius: 10px;">স্ক্যান কৃত কোড: -</span>
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="switchProductUpdateCamera()">
                        <i class="fa-solid fa-rotate me-1"></i> ক্যামেরা পাল্টান
                    </button>
                </div>
            </div>
            <div class="modal-footer bg-light py-2 justify-content-between">
                <small class="text-muted"><i class="fa-solid fa-bolt text-warning me-1"></i> বারকোড স্ক্যান করলেই ইনপুটে বসে যাবে</small>
                <button type="button" class="btn btn-secondary px-4 fw-bold rounded-pill" onclick="stopProductUpdateCameraScanner()">বন্ধ করুন</button>
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
            statusEl.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-1"></i> ক্যামেরা চালু হচ্ছে... বারকোড ক্যামেরার সামনে আনুন।';
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

    function onProductUpdateBarcodeDetected(decodedText) {
        if (!decodedText || decodedText === productUpdateLastCode) return;

        productUpdateLastCode = decodedText;
        const lastTextEl = document.getElementById("productUpdateLastScannedText");
        if (lastTextEl) lastTextEl.innerText = `স্ক্যান কৃত: ${decodedText}`;

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