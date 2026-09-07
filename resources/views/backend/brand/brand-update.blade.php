<style>
    /* Dark mode styles for Brand Update Modal */
    body[light-mode="dark"] #brandUpdateModal .modal-content,
    html[light-mode="dark"] #brandUpdateModal .modal-content,
    body[data-layout-mode="dark"] #brandUpdateModal .modal-content,
    html.dark #brandUpdateModal .modal-content,
    body.dark #brandUpdateModal .modal-content,
    body.dark-mode #brandUpdateModal .modal-content {
        background-color: #0f172a !important;
        border: 1px solid #1e293b !important;
    }

    body[light-mode="dark"] #brandUpdateModal .modal-body,
    html[light-mode="dark"] #brandUpdateModal .modal-body,
    body[data-layout-mode="dark"] #brandUpdateModal .modal-body,
    html.dark #brandUpdateModal .modal-body,
    body.dark #brandUpdateModal .modal-body,
    body.dark-mode #brandUpdateModal .modal-body {
        background-color: #0f172a !important;
    }

    body[light-mode="dark"] #brandUpdateModal .card,
    html[light-mode="dark"] #brandUpdateModal .card,
    body[data-layout-mode="dark"] #brandUpdateModal .card,
    html.dark #brandUpdateModal .card,
    body.dark #brandUpdateModal .card,
    body.dark-mode #brandUpdateModal .card {
        background-color: #1e293b !important;
        border: 1px solid #334155 !important;
    }

    body[light-mode="dark"] #brandUpdateModal label,
    html[light-mode="dark"] #brandUpdateModal label,
    body[data-layout-mode="dark"] #brandUpdateModal label,
    html.dark #brandUpdateModal label,
    body.dark #brandUpdateModal label,
    body.dark-mode #brandUpdateModal label {
        color: #f1f5f9 !important;
    }

    body[light-mode="dark"] #brandUpdateModal .form-control,
    body[light-mode="dark"] #brandUpdateModal .form-select,
    html[light-mode="dark"] #brandUpdateModal .form-control,
    html[light-mode="dark"] #brandUpdateModal .form-select,
    body[data-layout-mode="dark"] #brandUpdateModal .form-control,
    body[data-layout-mode="dark"] #brandUpdateModal .form-select,
    html.dark #brandUpdateModal .form-control,
    html.dark #brandUpdateModal .form-select,
    body.dark #brandUpdateModal .form-control,
    body.dark #brandUpdateModal .form-select,
    body.dark-mode #brandUpdateModal .form-control,
    body.dark-mode #brandUpdateModal .form-select {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] #brandUpdateModal .form-control:focus,
    body[light-mode="dark"] #brandUpdateModal .form-select:focus,
    html[light-mode="dark"] #brandUpdateModal .form-control:focus,
    html[light-mode="dark"] #brandUpdateModal .form-select:focus,
    body[data-layout-mode="dark"] #brandUpdateModal .form-control:focus,
    body[data-layout-mode="dark"] #brandUpdateModal .form-select:focus,
    html.dark #brandUpdateModal .form-control:focus,
    html.dark #brandUpdateModal .form-select:focus,
    body.dark #brandUpdateModal .form-control:focus,
    body.dark #brandUpdateModal .form-select:focus,
    body.dark-mode #brandUpdateModal .form-control:focus,
    body.dark-mode #brandUpdateModal .form-select:focus {
        background-color: #0f172a !important;
        border-color: #10b981 !important;
        color: #ffffff !important;
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25) !important;
    }

    body[light-mode="dark"] #brandUpdateModal .form-control::placeholder,
    html[light-mode="dark"] #brandUpdateModal .form-control::placeholder,
    body[data-layout-mode="dark"] #brandUpdateModal .form-control::placeholder,
    html.dark #brandUpdateModal .form-control::placeholder,
    body.dark #brandUpdateModal .form-control::placeholder,
    body.dark-mode #brandUpdateModal .form-control::placeholder {
        color: #94a3b8 !important;
    }

    body[light-mode="dark"] #brandUpdateModal .form-select option,
    html[light-mode="dark"] #brandUpdateModal .form-select option,
    body[data-layout-mode="dark"] #brandUpdateModal .form-select option,
    html.dark #brandUpdateModal .form-select option,
    body.dark #brandUpdateModal .form-select option,
    body.dark-mode #brandUpdateModal .form-select option {
        background-color: #0f172a !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] #brandUpdateModal .text-muted,
    html[light-mode="dark"] #brandUpdateModal .text-muted,
    body[data-layout-mode="dark"] #brandUpdateModal .text-muted,
    html.dark #brandUpdateModal .text-muted,
    body.dark #brandUpdateModal .text-muted,
    body.dark-mode #brandUpdateModal .text-muted {
        color: #94a3b8 !important;
    }

    body[light-mode="dark"] #brandUpdateModal #updateBrandShowImage,
    html[light-mode="dark"] #brandUpdateModal #updateBrandShowImage,
    body[data-layout-mode="dark"] #brandUpdateModal #updateBrandShowImage,
    html.dark #brandUpdateModal #updateBrandShowImage,
    body.dark #brandUpdateModal #updateBrandShowImage,
    body.dark-mode #brandUpdateModal #updateBrandShowImage {
        background: #0f172a !important;
        border-color: #15803d !important;
    }
</style>

<!-- Update Brand Modal Start -->
<div class="modal fade" id="brandUpdateModal" tabindex="-1" aria-labelledby="brandUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white px-4 py-3" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2 m-0 text-white" id="brandUpdateModalLabel" style="color: #ffffff !important;">
                    <i class="fa-solid fa-pen-to-square text-white" style="color: #ffffff !important;"></i>
                    <span class="text-white" style="color: #ffffff !important;">Update Brand</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                <form id="updateBrandForm" onsubmit="BrandUpdateSave(event)">
                    <input type="hidden" id="updateBrandID" />

                    <!-- Logo Upload Container -->
                    <div class="card border-0 shadow-sm rounded-3 p-3 mb-3 text-center bg-white">
                        <div class="d-inline-block position-relative mb-2">
                            <img id="updateBrandShowImage" src="{{ asset('backend/assets/img/brand-defult-img.svg') }}" alt="Brand Logo Preview" style="width: 85px; height: 85px; object-fit: contain; border-radius: 12px; border: 2px dashed #86efac; padding: 4px; background: #f0fdf4;" />
                        </div>
                        <div>
                            <label for="updateBrandImage" class="btn btn-sm btn-outline-success fw-bold px-3 py-1" style="border-radius: 6px; cursor: pointer; font-size: 12px;">
                                <i class="fa-solid fa-upload me-1"></i> Change Logo
                            </label>
                            <input type="file" id="updateBrandImage" class="d-none" accept="image/*" />
                            <div class="text-muted small mt-1" style="font-size: 11px;">PNG, JPG or GIF (Max 1MB)</div>
                        </div>
                    </div>

                    <!-- Brand Form Fields -->
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                        <div class="mb-3">
                            <label for="updateBrandName" class="form-label fw-bold small text-dark">Brand Name <span class="text-danger">*</span></label>
                            <input type="text" id="updateBrandName" class="form-control" placeholder="Enter brand name..." required style="height: 42px; border-radius: 8px;" />
                        </div>

                        <div class="mb-0">
                            <label for="updateBrandStatus" class="form-label fw-bold small text-dark">Status <span class="text-danger">*</span></label>
                            <select id="updateBrandStatus" class="form-select unified-ui-border" required style="height: 42px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
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
<!-- Update Brand Modal End -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('#updateBrandImage').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#updateBrandShowImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        $('#brandUpdateModal').on('hidden.bs.modal', function () {
            $('#updateBrandForm')[0].reset();
            $('#updateBrandID').val('');
            $('#updateBrandShowImage').attr('src', "{{ asset('backend/assets/img/brand-defult-img.svg') }}");
        });
    });

    async function FillUpUpdateForm(id) {
        try {
            $('#updateBrandID').val(id);
            showLoader();

            let res = await axios.post("/api/brand-by-id", { id: String(id) }, HeaderToken());
            hideLoader();

            if (res.data && res.data.status === "success" && res.data.rows) {
                const data = res.data.rows;
                $('#updateBrandName').val(data.name || '');
                $('#updateBrandStatus').val(data.status || 'Active');

                const logo = data.logo ? (data.logo.startsWith('http') ? data.logo : '/' + data.logo.replace(/^\/+/, '')) : "{{ asset('backend/assets/img/brand-defult-img.svg') }}";
                $('#updateBrandShowImage').attr('src', logo);

                $('#brandUpdateModal').modal('show');
            } else {
                errorToast("Brand data not found!");
            }
        } catch (e) {
            hideLoader();
            console.error("Brand Fetch Error:", e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    async function BrandUpdateSave(event) {
        event.preventDefault();
        try {
            const id = $('#updateBrandID').val();
            const brandName = $('#updateBrandName').val().trim();
            const brandStatus = $('#updateBrandStatus').val() || 'Active';
            const imgFile = document.getElementById('updateBrandImage').files[0];

            if (!id) return errorToast("Brand ID missing!");
            if (!brandName) return errorToast("Brand Name is required!");

            let formData = new FormData();
            formData.append('id', id);
            formData.append('name', brandName);
            formData.append('status', brandStatus);
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
            let res = await axios.post("/api/update-brand", formData, config);
            hideLoader();

            if (res.data && res.data.status === "success") {
                successToast(res.data.message || "Brand updated successfully");
                $('#brandUpdateModal').modal('hide');

                if (typeof getList === 'function') {
                    await getList();
                } else {
                    location.reload();
                }
            } else {
                errorToast(res.data ? res.data.message : "Failed to update brand.");
            }
        } catch (e) {
            hideLoader();
            console.error("Brand Update Error:", e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }
</script>
