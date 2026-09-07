<style>
    /* Dark mode styles for Category Update Modal */
    body[light-mode="dark"] #categoryUpdateModal .modal-content,
    html[light-mode="dark"] #categoryUpdateModal .modal-content,
    body[data-layout-mode="dark"] #categoryUpdateModal .modal-content,
    html.dark #categoryUpdateModal .modal-content,
    body.dark #categoryUpdateModal .modal-content,
    body.dark-mode #categoryUpdateModal .modal-content {
        background-color: #0f172a !important;
        border: 1px solid #1e293b !important;
    }

    body[light-mode="dark"] #categoryUpdateModal .modal-body,
    html[light-mode="dark"] #categoryUpdateModal .modal-body,
    body[data-layout-mode="dark"] #categoryUpdateModal .modal-body,
    html.dark #categoryUpdateModal .modal-body,
    body.dark #categoryUpdateModal .modal-body,
    body.dark-mode #categoryUpdateModal .modal-body {
        background-color: #0f172a !important;
    }

    body[light-mode="dark"] #categoryUpdateModal .card,
    html[light-mode="dark"] #categoryUpdateModal .card,
    body[data-layout-mode="dark"] #categoryUpdateModal .card,
    html.dark #categoryUpdateModal .card,
    body.dark #categoryUpdateModal .card,
    body.dark-mode #categoryUpdateModal .card {
        background-color: #1e293b !important;
        border: 1px solid #334155 !important;
    }

    body[light-mode="dark"] #categoryUpdateModal label,
    html[light-mode="dark"] #categoryUpdateModal label,
    body[data-layout-mode="dark"] #categoryUpdateModal label,
    html.dark #categoryUpdateModal label,
    body.dark #categoryUpdateModal label,
    body.dark-mode #categoryUpdateModal label {
        color: #f1f5f9 !important;
    }

    body[light-mode="dark"] #categoryUpdateModal .form-control,
    body[light-mode="dark"] #categoryUpdateModal .form-select,
    html[light-mode="dark"] #categoryUpdateModal .form-control,
    html[light-mode="dark"] #categoryUpdateModal .form-select,
    body[data-layout-mode="dark"] #categoryUpdateModal .form-control,
    body[data-layout-mode="dark"] #categoryUpdateModal .form-select,
    html.dark #categoryUpdateModal .form-control,
    html.dark #categoryUpdateModal .form-select,
    body.dark #categoryUpdateModal .form-control,
    body.dark #categoryUpdateModal .form-select,
    body.dark-mode #categoryUpdateModal .form-control,
    body.dark-mode #categoryUpdateModal .form-select {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] #categoryUpdateModal .form-control:focus,
    body[light-mode="dark"] #categoryUpdateModal .form-select:focus,
    html[light-mode="dark"] #categoryUpdateModal .form-control:focus,
    html[light-mode="dark"] #categoryUpdateModal .form-select:focus,
    body[data-layout-mode="dark"] #categoryUpdateModal .form-control:focus,
    body[data-layout-mode="dark"] #categoryUpdateModal .form-select:focus,
    html.dark #categoryUpdateModal .form-control:focus,
    html.dark #categoryUpdateModal .form-select:focus,
    body.dark #categoryUpdateModal .form-control:focus,
    body.dark #categoryUpdateModal .form-select:focus,
    body.dark-mode #categoryUpdateModal .form-control:focus,
    body.dark-mode #categoryUpdateModal .form-select:focus {
        background-color: #0f172a !important;
        border-color: #10b981 !important;
        color: #ffffff !important;
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25) !important;
    }

    body[light-mode="dark"] #categoryUpdateModal .form-control::placeholder,
    html[light-mode="dark"] #categoryUpdateModal .form-control::placeholder,
    body[data-layout-mode="dark"] #categoryUpdateModal .form-control::placeholder,
    html.dark #categoryUpdateModal .form-control::placeholder,
    body.dark #categoryUpdateModal .form-control::placeholder,
    body.dark-mode #categoryUpdateModal .form-control::placeholder {
        color: #94a3b8 !important;
    }

    body[light-mode="dark"] #categoryUpdateModal .form-select option,
    html[light-mode="dark"] #categoryUpdateModal .form-select option,
    body[data-layout-mode="dark"] #categoryUpdateModal .form-select option,
    html.dark #categoryUpdateModal .form-select option,
    body.dark #categoryUpdateModal .form-select option,
    body.dark-mode #categoryUpdateModal .form-select option {
        background-color: #0f172a !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] #categoryUpdateModal .text-muted,
    html[light-mode="dark"] #categoryUpdateModal .text-muted,
    body[data-layout-mode="dark"] #categoryUpdateModal .text-muted,
    html.dark #categoryUpdateModal .text-muted,
    body.dark #categoryUpdateModal .text-muted,
    body.dark-mode #categoryUpdateModal .text-muted {
        color: #94a3b8 !important;
    }

    body[light-mode="dark"] #categoryUpdateModal #updateCategoryShowImage,
    html[light-mode="dark"] #categoryUpdateModal #updateCategoryShowImage,
    body[data-layout-mode="dark"] #categoryUpdateModal #updateCategoryShowImage,
    html.dark #categoryUpdateModal #updateCategoryShowImage,
    body.dark #categoryUpdateModal #updateCategoryShowImage,
    body.dark-mode #categoryUpdateModal #updateCategoryShowImage {
        background: #0f172a !important;
        border-color: #15803d !important;
    }
</style>

<!-- Update Category Modal Start -->
<div class="modal fade" id="categoryUpdateModal" tabindex="-1" aria-labelledby="categoryUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white px-4 py-3" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2 m-0 text-white" id="categoryUpdateModalLabel" style="color: #ffffff !important;">
                    <i class="fa-solid fa-pen-to-square text-white" style="color: #ffffff !important;"></i>
                    <span class="text-white" style="color: #ffffff !important;">Update Category</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <form id="updateCategoryForm" onsubmit="CategoryUpdateSave(event)">
                    <input type="hidden" id="updateCategoryID" />

                    <!-- Image Upload Container -->
                    <div class="card border-0 shadow-sm rounded-3 p-3 mb-3 text-center bg-white">
                        <div class="d-inline-block position-relative mb-2">
                            <img id="updateCategoryShowImage" src="{{ asset('backend/assets/img/category-defult-img.svg') }}" alt="Category Image Preview" style="width: 85px; height: 85px; object-fit: contain; border-radius: 12px; border: 2px dashed #86efac; padding: 4px; background: #f0fdf4;" />
                        </div>
                        <div>
                            <label for="updateCategoryImg" class="btn btn-sm btn-outline-success fw-bold px-3 py-1" style="border-radius: 6px; cursor: pointer; font-size: 12px;">
                                <i class="fa-solid fa-upload me-1"></i> Change Image
                            </label>
                            <input type="file" id="updateCategoryImg" class="d-none" accept="image/*" />
                            <div class="text-muted small mt-1" style="font-size: 11px;">PNG, JPG or GIF (Max 1MB)</div>
                        </div>
                    </div>

                    <!-- Category Form Fields -->
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                        <div class="mb-3">
                            <label for="updateCategoryName" class="form-label fw-bold small text-dark">Category Name <span class="text-danger">*</span></label>
                            <input type="text" id="updateCategoryName" class="form-control" placeholder="Enter category name..." required style="height: 42px; border-radius: 8px;" />
                        </div>

                        <div class="mb-0">
                            <label for="updateCategoryStatus" class="form-label fw-bold small text-dark">Status <span class="text-danger">*</span></label>
                            <select id="updateCategoryStatus" class="form-select unified-ui-border" required style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                <option value="Active">Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                        <button type="button" class="btn px-4 py-2 fw-semibold text-white" data-bs-dismiss="modal" style="background-color: #dc2626 !important; color: #ffffff !important; border-radius: 8px; border: none !important;">Cancel</button>
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="background-color: #15803d; border-radius: 8px; border: none;">
                            <i class="fa-solid fa-check me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Update Category Modal End -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#updateCategoryImg').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#updateCategoryShowImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        $('#categoryUpdateModal').on('hidden.bs.modal', function () {
            $('#updateCategoryForm')[0].reset();
            $('#updateCategoryID').val('');
            $('#updateCategoryShowImage').attr('src', "{{ asset('backend/assets/img/category-defult-img.svg') }}");
        });
    });

    async function FillUpCategoryUpdateForm(id) {
        try {
            $('#updateCategoryID').val(id);
            showLoader();

            let res = await axios.post("/api/category-by-id", { id: String(id) }, HeaderToken());
            hideLoader();

            if (res.data && res.data.status === "success" && res.data.rows) {
                const data = res.data.rows;
                $('#updateCategoryName').val(data.category_name || '');
                $('#updateCategoryStatus').val(data.status || 'Active');

                const img = data.img_url ? (data.img_url.startsWith('http') ? data.img_url : '/' + data.img_url.replace(/^\/+/, '')) : "{{ asset('backend/assets/img/category-defult-img.svg') }}";
                $('#updateCategoryShowImage').attr('src', img);

                $('#categoryUpdateModal').modal('show');
            } else {
                errorToast("Category data not found!");
            }
        } catch (e) {
            hideLoader();
            console.error("Category Fetch Error:", e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    async function CategoryUpdateSave(event) {
        event.preventDefault();
        try {
            const id = $('#updateCategoryID').val();
            const categoryName = $('#updateCategoryName').val().trim();
            const categoryStatus = $('#updateCategoryStatus').val() || 'Active';
            const imgFile = document.getElementById('updateCategoryImg').files[0];

            if (!id) return errorToast("Category ID missing!");
            if (!categoryName) return errorToast("Category Name is required!");

            let formData = new FormData();
            formData.append('id', id);
            formData.append('category_name', categoryName);
            formData.append('status', categoryStatus);
            if (imgFile) {
                formData.append('img', imgFile);
            }

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            showLoader();
            let res = await axios.post("/api/update-category", formData, config);
            hideLoader();

            if (res.data && res.data.status === "success") {
                successToast(res.data.message || "Category updated successfully");
                $('#categoryUpdateModal').modal('hide');

                if (typeof getList === 'function') {
                    await getList();
                } else {
                    location.reload();
                }
            } else {
                errorToast(res.data ? res.data.message : "Failed to update category.");
            }
        } catch (e) {
            hideLoader();
            console.error("Category Update Error:", e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }
</script>
