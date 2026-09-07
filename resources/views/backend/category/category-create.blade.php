<style>
    /* Dark mode styles for Category Create Modal */
    body[light-mode="dark"] #categoryCreateModal .modal-content,
    html[light-mode="dark"] #categoryCreateModal .modal-content,
    body[data-layout-mode="dark"] #categoryCreateModal .modal-content,
    html.dark #categoryCreateModal .modal-content,
    body.dark #categoryCreateModal .modal-content,
    body.dark-mode #categoryCreateModal .modal-content {
        background-color: #0f172a !important;
        border: 1px solid #1e293b !important;
    }

    body[light-mode="dark"] #categoryCreateModal .modal-body,
    html[light-mode="dark"] #categoryCreateModal .modal-body,
    body[data-layout-mode="dark"] #categoryCreateModal .modal-body,
    html.dark #categoryCreateModal .modal-body,
    body.dark #categoryCreateModal .modal-body,
    body.dark-mode #categoryCreateModal .modal-body {
        background-color: #0f172a !important;
    }

    body[light-mode="dark"] #categoryCreateModal .card,
    html[light-mode="dark"] #categoryCreateModal .card,
    body[data-layout-mode="dark"] #categoryCreateModal .card,
    html.dark #categoryCreateModal .card,
    body.dark #categoryCreateModal .card,
    body.dark-mode #categoryCreateModal .card {
        background-color: #1e293b !important;
        border: 1px solid #334155 !important;
    }

    body[light-mode="dark"] #categoryCreateModal label,
    html[light-mode="dark"] #categoryCreateModal label,
    body[data-layout-mode="dark"] #categoryCreateModal label,
    html.dark #categoryCreateModal label,
    body.dark #categoryCreateModal label,
    body.dark-mode #categoryCreateModal label {
        color: #f1f5f9 !important;
    }

    body[light-mode="dark"] #categoryCreateModal .form-control,
    body[light-mode="dark"] #categoryCreateModal .form-select,
    html[light-mode="dark"] #categoryCreateModal .form-control,
    html[light-mode="dark"] #categoryCreateModal .form-select,
    body[data-layout-mode="dark"] #categoryCreateModal .form-control,
    body[data-layout-mode="dark"] #categoryCreateModal .form-select,
    html.dark #categoryCreateModal .form-control,
    html.dark #categoryCreateModal .form-select,
    body.dark #categoryCreateModal .form-control,
    body.dark #categoryCreateModal .form-select,
    body.dark-mode #categoryCreateModal .form-control,
    body.dark-mode #categoryCreateModal .form-select {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] #categoryCreateModal .form-control:focus,
    body[light-mode="dark"] #categoryCreateModal .form-select:focus,
    html[light-mode="dark"] #categoryCreateModal .form-control:focus,
    html[light-mode="dark"] #categoryCreateModal .form-select:focus,
    body[data-layout-mode="dark"] #categoryCreateModal .form-control:focus,
    body[data-layout-mode="dark"] #categoryCreateModal .form-select:focus,
    html.dark #categoryCreateModal .form-control:focus,
    html.dark #categoryCreateModal .form-select:focus,
    body.dark #categoryCreateModal .form-control:focus,
    body.dark #categoryCreateModal .form-select:focus,
    body.dark-mode #categoryCreateModal .form-control:focus,
    body.dark-mode #categoryCreateModal .form-select:focus {
        background-color: #0f172a !important;
        border-color: #10b981 !important;
        color: #ffffff !important;
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25) !important;
    }

    body[light-mode="dark"] #categoryCreateModal .form-control::placeholder,
    html[light-mode="dark"] #categoryCreateModal .form-control::placeholder,
    body[data-layout-mode="dark"] #categoryCreateModal .form-control::placeholder,
    html.dark #categoryCreateModal .form-control::placeholder,
    body.dark #categoryCreateModal .form-control::placeholder,
    body.dark-mode #categoryCreateModal .form-control::placeholder {
        color: #94a3b8 !important;
    }

    body[light-mode="dark"] #categoryCreateModal .form-select option,
    html[light-mode="dark"] #categoryCreateModal .form-select option,
    body[data-layout-mode="dark"] #categoryCreateModal .form-select option,
    html.dark #categoryCreateModal .form-select option,
    body.dark #categoryCreateModal .form-select option,
    body.dark-mode #categoryCreateModal .form-select option {
        background-color: #0f172a !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] #categoryCreateModal .text-muted,
    html[light-mode="dark"] #categoryCreateModal .text-muted,
    body[data-layout-mode="dark"] #categoryCreateModal .text-muted,
    html.dark #categoryCreateModal .text-muted,
    body.dark #categoryCreateModal .text-muted,
    body.dark-mode #categoryCreateModal .text-muted {
        color: #94a3b8 !important;
    }

    body[light-mode="dark"] #categoryCreateModal #createCategoryShowImage,
    html[light-mode="dark"] #categoryCreateModal #createCategoryShowImage,
    body[data-layout-mode="dark"] #categoryCreateModal #createCategoryShowImage,
    html.dark #categoryCreateModal #createCategoryShowImage,
    body.dark #categoryCreateModal #createCategoryShowImage,
    body.dark-mode #categoryCreateModal #createCategoryShowImage {
        background: #0f172a !important;
        border-color: #15803d !important;
    }
</style>

<!-- Create Category Modal Start -->
<div class="modal fade" id="categoryCreateModal" tabindex="-1" aria-labelledby="categoryCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white px-4 py-3" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2 m-0 text-white" id="categoryCreateModalLabel" style="color: #ffffff !important;">
                    <i class="fa-solid fa-folder-tree text-white" style="color: #ffffff !important;"></i>
                    <span class="text-white" style="color: #ffffff !important;">Add New Category</span>
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
                            <label for="createCategoryName" class="form-label fw-bold small text-dark">Category Name <span class="text-danger">*</span></label>
                            <input type="text" id="createCategoryName" class="form-control" placeholder="e.g. Door, Fitting Stocks, WPC..." required style="height: 42px; border-radius: 8px;" />
                        </div>

                        <div class="mb-0">
                            <label for="createCategoryStatus" class="form-label fw-bold small text-dark">Status <span class="text-danger">*</span></label>
                            <select id="createCategoryStatus" class="form-select unified-ui-border" required style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                <option value="Active" selected>Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                        <button type="button" class="btn px-4 py-2 fw-semibold text-white" data-bs-dismiss="modal" style="background-color: #dc2626 !important; color: #ffffff !important; border-radius: 8px; border: none !important;">Cancel</button>
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
