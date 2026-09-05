<!-- Create Category Modal Start -->
<div class="modal fade" id="categoryCreateModal" tabindex="-1" aria-labelledby="categoryCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white px-4 py-3" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2 m-0" id="categoryCreateModalLabel">
                    <i class="fa-solid fa-folder-tree"></i>
                    <span>Add New Category (নতুন ক্যাটাগরি)</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <form id="createCategoryForm" onsubmit="CategoryDataSave(event)">
                    <!-- Image Upload Container -->
                    <div class="card border-0 shadow-sm rounded-3 p-3 mb-3 text-center bg-white">
                        <div class="d-inline-block position-relative mb-2">
                            <img id="createCategoryShowImage" src="{{ asset('backend/assets/img/category-defult-img.svg') }}" alt="Category Image Preview" style="width: 85px; height: 85px; object-fit: contain; border-radius: 12px; border: 2px dashed #86efac; padding: 4px; background: #f0fdf4;" />
                        </div>
                        <div>
                            <label for="createCategoryImg" class="btn btn-sm btn-outline-success fw-bold px-3 py-1" style="border-radius: 6px; cursor: pointer; font-size: 12px;">
                                <i class="fa-solid fa-upload me-1"></i> Upload Category Image
                            </label>
                            <input type="file" id="createCategoryImg" class="d-none" accept="image/*" />
                            <div class="text-muted small mt-1" style="font-size: 11px;">PNG, JPG or GIF (Max 1MB)</div>
                        </div>
                    </div>

                    <!-- Category Form Fields -->
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                        <div class="mb-3">
                            <label for="createCategoryName" class="form-label fw-bold small text-dark">Category Name (ক্যাটাগরি নাম) <span class="text-danger">*</span></label>
                            <input type="text" id="createCategoryName" class="form-control" placeholder="e.g. Door, Fitting Stocks, WPC..." required style="height: 42px; border-radius: 8px;" />
                        </div>

                        <div class="mb-0">
                            <label for="createCategoryStatus" class="form-label fw-bold small text-dark">Status (স্ট্যাটাস) <span class="text-danger">*</span></label>
                            <select id="createCategoryStatus" class="form-select" required style="height: 42px; border-radius: 8px;">
                                <option value="Active" selected>Active (সক্রিয়)</option>
                                <option value="InActive">Inactive (নিষ্ক্রিয়)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary px-4 py-2 fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="background-color: #15803d; border-radius: 8px; border: none;">
                            <i class="fa-solid fa-check me-1"></i> Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Create Category Modal End -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#createCategoryImg').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#createCategoryShowImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        $('#categoryCreateModal').on('hidden.bs.modal', function () {
            $('#createCategoryForm')[0].reset();
            $('#createCategoryShowImage').attr('src', "{{ asset('backend/assets/img/category-defult-img.svg') }}");
        });
    });

    async function CategoryDataSave(event) {
        event.preventDefault();
        try {
            const categoryName = $('#createCategoryName').val().trim();
            const categoryStatus = $('#createCategoryStatus').val() || 'Active';
            const imgFile = document.getElementById('createCategoryImg').files[0];

            if (!categoryName) {
                return errorToast("Category Name is required!");
            }

            let formData = new FormData();
            formData.append('category_name', categoryName);
            formData.append('status', categoryStatus);
            if (imgFile) {
                formData.append('img_url', imgFile);
            }

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            showLoader();
            let res = await axios.post("/api/create-category", formData, config);
            hideLoader();

            if (res.data && res.data.status === "success") {
                successToast(res.data.message || "Category created successfully");
                $('#categoryCreateModal').modal('hide');
                $('#createCategoryForm')[0].reset();
                $('#createCategoryShowImage').attr('src', "{{ asset('backend/assets/img/category-defult-img.svg') }}");

                if (typeof getList === 'function') {
                    await getList();
                } else {
                    location.reload();
                }
            } else {
                errorToast(res.data ? res.data.message : "Failed to save category.");
            }
        } catch (e) {
            hideLoader();
            console.error("Category Save Error:", e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }
</script>
