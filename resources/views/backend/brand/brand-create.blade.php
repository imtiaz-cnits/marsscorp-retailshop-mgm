<style>
    /* Dark mode styles for Brand Create Modal */
    body[light-mode="dark"] #brandCreateModal .modal-content,
    html[light-mode="dark"] #brandCreateModal .modal-content,
    body[data-layout-mode="dark"] #brandCreateModal .modal-content,
    html.dark #brandCreateModal .modal-content,
    body.dark #brandCreateModal .modal-content,
    body.dark-mode #brandCreateModal .modal-content {
        background-color: #0f172a !important;
        border: 1px solid #1e293b !important;
    }

    body[light-mode="dark"] #brandCreateModal .modal-body,
    html[light-mode="dark"] #brandCreateModal .modal-body,
    body[data-layout-mode="dark"] #brandCreateModal .modal-body,
    html.dark #brandCreateModal .modal-body,
    body.dark #brandCreateModal .modal-body,
    body.dark-mode #brandCreateModal .modal-body {
        background-color: #0f172a !important;
    }

    body[light-mode="dark"] #brandCreateModal .card,
    html[light-mode="dark"] #brandCreateModal .card,
    body[data-layout-mode="dark"] #brandCreateModal .card,
    html.dark #brandCreateModal .card,
    body.dark #brandCreateModal .card,
    body.dark-mode #brandCreateModal .card {
        background-color: #1e293b !important;
        border: 1px solid #334155 !important;
    }

    body[light-mode="dark"] #brandCreateModal label,
    html[light-mode="dark"] #brandCreateModal label,
    body[data-layout-mode="dark"] #brandCreateModal label,
    html.dark #brandCreateModal label,
    body.dark #brandCreateModal label,
    body.dark-mode #brandCreateModal label {
        color: #f1f5f9 !important;
    }

    body[light-mode="dark"] #brandCreateModal .form-control,
    body[light-mode="dark"] #brandCreateModal .form-select,
    html[light-mode="dark"] #brandCreateModal .form-control,
    html[light-mode="dark"] #brandCreateModal .form-select,
    body[data-layout-mode="dark"] #brandCreateModal .form-control,
    body[data-layout-mode="dark"] #brandCreateModal .form-select,
    html.dark #brandCreateModal .form-control,
    html.dark #brandCreateModal .form-select,
    body.dark #brandCreateModal .form-control,
    body.dark #brandCreateModal .form-select,
    body.dark-mode #brandCreateModal .form-control,
    body.dark-mode #brandCreateModal .form-select {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] #brandCreateModal .form-control:focus,
    body[light-mode="dark"] #brandCreateModal .form-select:focus,
    html[light-mode="dark"] #brandCreateModal .form-control:focus,
    html[light-mode="dark"] #brandCreateModal .form-select:focus,
    body[data-layout-mode="dark"] #brandCreateModal .form-control:focus,
    body[data-layout-mode="dark"] #brandCreateModal .form-select:focus,
    html.dark #brandCreateModal .form-control:focus,
    html.dark #brandCreateModal .form-select:focus,
    body.dark #brandCreateModal .form-control:focus,
    body.dark #brandCreateModal .form-select:focus,
    body.dark-mode #brandCreateModal .form-control:focus,
    body.dark-mode #brandCreateModal .form-select:focus {
        background-color: #0f172a !important;
        border-color: #10b981 !important;
        color: #ffffff !important;
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25) !important;
    }

    body[light-mode="dark"] #brandCreateModal .form-control::placeholder,
    html[light-mode="dark"] #brandCreateModal .form-control::placeholder,
    body[data-layout-mode="dark"] #brandCreateModal .form-control::placeholder,
    html.dark #brandCreateModal .form-control::placeholder,
    body.dark #brandCreateModal .form-control::placeholder,
    body.dark-mode #brandCreateModal .form-control::placeholder {
        color: #94a3b8 !important;
    }

    body[light-mode="dark"] #brandCreateModal .form-select option,
    html[light-mode="dark"] #brandCreateModal .form-select option,
    body[data-layout-mode="dark"] #brandCreateModal .form-select option,
    html.dark #brandCreateModal .form-select option,
    body.dark #brandCreateModal .form-select option,
    body.dark-mode #brandCreateModal .form-select option {
        background-color: #0f172a !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] #brandCreateModal .text-muted,
    html[light-mode="dark"] #brandCreateModal .text-muted,
    body[data-layout-mode="dark"] #brandCreateModal .text-muted,
    html.dark #brandCreateModal .text-muted,
    body.dark #brandCreateModal .text-muted,
    body.dark-mode #brandCreateModal .text-muted {
        color: #94a3b8 !important;
    }

    body[light-mode="dark"] #brandCreateModal #createBrandShowImage,
    html[light-mode="dark"] #brandCreateModal #createBrandShowImage,
    body[data-layout-mode="dark"] #brandCreateModal #createBrandShowImage,
    html.dark #brandCreateModal #createBrandShowImage,
    body.dark #brandCreateModal #createBrandShowImage,
    body.dark-mode #brandCreateModal #createBrandShowImage {
        background: #0f172a !important;
        border-color: #15803d !important;
    }
</style>

<!-- Create Brand Modal Start -->
<div class="modal fade" id="brandCreateModal" tabindex="-1" aria-labelledby="brandCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white px-4 py-3" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2 m-0 text-white" id="brandCreateModalLabel" style="color: #ffffff !important;">
                    <i class="fa-solid fa-tag text-white" style="color: #ffffff !important;"></i>
                    <span class="text-white" style="color: #ffffff !important;">Add New Brand</span>
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
                            <label for="createBrandName" class="form-label fw-bold small text-dark">Brand Name <span class="text-danger">*</span></label>
                            <input type="text" id="createBrandName" class="form-control" placeholder="e.g. Akij, Rosa, RFL..." required style="height: 42px; border-radius: 8px;" />
                        </div>

                        <div class="mb-0">
                            <label for="createBrandStatus" class="form-label fw-bold small text-dark">Status <span class="text-danger">*</span></label>
                            <select id="createBrandStatus" class="form-select unified-ui-border" required style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                <option value="Active" selected>Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
                        <button type="button" class="btn px-4 py-2 fw-semibold text-white" data-bs-dismiss="modal" style="background-color: #dc2626 !important; color: #ffffff !important; border-radius: 8px; border: none !important;">Cancel</button>
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
