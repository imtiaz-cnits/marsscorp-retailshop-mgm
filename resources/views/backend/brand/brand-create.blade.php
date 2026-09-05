<!-- Create Brand Modal Start -->
<div class="modal fade" id="brandCreateModal" tabindex="-1" aria-labelledby="brandCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white px-4 py-3" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2 m-0" id="brandCreateModalLabel">
                    <i class="fa-solid fa-tag"></i>
                    <span>Add New Brand (নতুন ব্র্যান্ড)</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <form id="createBrandForm" onsubmit="BrandDataSave(event)">
                    <!-- Logo Upload Container -->
                    <div class="card border-0 shadow-sm rounded-3 p-3 mb-3 text-center bg-white">
                        <div class="d-inline-block position-relative mb-2">
                            <img id="createBrandShowImage" src="{{ asset('backend/assets/img/brand-defult-img.svg') }}" alt="Brand Logo Preview" style="width: 85px; height: 85px; object-fit: contain; border-radius: 12px; border: 2px dashed #86efac; padding: 4px; background: #f0fdf4;" />
                        </div>
                        <div>
                            <label for="createBrandImage" class="btn btn-sm btn-outline-success fw-bold px-3 py-1" style="border-radius: 6px; cursor: pointer; font-size: 12px;">
                                <i class="fa-solid fa-upload me-1"></i> Upload Brand Logo
                            </label>
                            <input type="file" id="createBrandImage" class="d-none" accept="image/*" />
                            <div class="text-muted small mt-1" style="font-size: 11px;">PNG, JPG or GIF (Max 1MB)</div>
                        </div>
                    </div>

                    <!-- Brand Form Fields -->
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                        <div class="mb-3">
                            <label for="createBrandName" class="form-label fw-bold small text-dark">Brand Name (ব্র্যান্ড নাম) <span class="text-danger">*</span></label>
                            <input type="text" id="createBrandName" class="form-control" placeholder="e.g. Akij, Rosa, RFL..." required style="height: 42px; border-radius: 8px;" />
                        </div>

                        <div class="mb-0">
                            <label for="createBrandStatus" class="form-label fw-bold small text-dark">Status (স্ট্যাটাস) <span class="text-danger">*</span></label>
                            <select id="createBrandStatus" class="form-select" required style="height: 42px; border-radius: 8px;">
                                <option value="Active" selected>Active (সক্রিয়)</option>
                                <option value="InActive">Inactive (নিষ্ক্রিয়)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary px-4 py-2 fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="background-color: #15803d; border-radius: 8px; border: none;">
                            <i class="fa-solid fa-check me-1"></i> Save Brand
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Create Brand Modal End -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#createBrandImage').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#createBrandShowImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        $('#brandCreateModal').on('hidden.bs.modal', function () {
            $('#createBrandForm')[0].reset();
            $('#createBrandShowImage').attr('src', "{{ asset('backend/assets/img/brand-defult-img.svg') }}");
        });
    });

    async function BrandDataSave(event) {
        event.preventDefault();
        try {
            const brandName = $('#createBrandName').val().trim();
            const brandStatus = $('#createBrandStatus').val() || 'Active';
            const imgFile = document.getElementById('createBrandImage').files[0];

            if (!brandName) {
                return errorToast("Brand Name is required!");
            }

            let formData = new FormData();
            formData.append('name', brandName);
            formData.append('status', brandStatus);
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
            let res = await axios.post("/api/create-brand", formData, config);
            hideLoader();

            if (res.data && res.data.status === "success") {
                successToast(res.data.message || "Brand created successfully");
                $('#brandCreateModal').modal('hide');
                $('#createBrandForm')[0].reset();
                $('#createBrandShowImage').attr('src', "{{ asset('backend/assets/img/brand-defult-img.svg') }}");

                if (typeof getList === 'function') {
                    await getList();
                } else {
                    location.reload();
                }
            } else {
                errorToast(res.data ? res.data.message : "Failed to save brand.");
            }
        } catch (e) {
            hideLoader();
            console.error("Brand Save Error:", e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }
</script>
