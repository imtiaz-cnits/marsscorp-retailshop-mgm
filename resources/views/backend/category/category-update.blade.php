<!-- Update Category Modal Start -->
<div class="modal fade" id="categoryUpdateModal" tabindex="-1" aria-labelledby="categoryUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white px-4 py-3" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2 m-0" id="categoryUpdateModalLabel">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Update Category (ক্যাটাগরি তথ্য আপডেট)</span>
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
                            <label for="updateCategoryName" class="form-label fw-bold small text-dark">Category Name (ক্যাটাগরি নাম) <span class="text-danger">*</span></label>
                            <input type="text" id="updateCategoryName" class="form-control" placeholder="Enter category name..." required style="height: 42px; border-radius: 8px;" />
                        </div>

                        <div class="mb-0">
                            <label for="updateCategoryStatus" class="form-label fw-bold small text-dark">Status (স্ট্যাটাস) <span class="text-danger">*</span></label>
                            <select id="updateCategoryStatus" class="form-select" required style="height: 42px; border-radius: 8px;">
                                <option value="Active">Active (সক্রিয়)</option>
                                <option value="InActive">Inactive (নিষ্ক্রিয়)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary px-4 py-2 fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
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
