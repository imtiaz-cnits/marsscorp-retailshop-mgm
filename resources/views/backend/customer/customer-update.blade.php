<!-- Action Button Edit Modal Start -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
            <!-- Sticky Top Green Header -->
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.2); color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </div>
                    <h5 class="modal-title m-0 text-white fw-bold" id="exampleModalLabel" style="font-size: 16px; color: #ffffff !important;">Update Customer</h5>
                </div>
                <!-- Circular Red Close Button with White Icon -->
                <button type="button" class="custom-modal-close-btn closes d-flex align-items-center justify-content-center border-0 shadow-sm" data-bs-dismiss="modal" aria-label="Close" style="position: relative !important; top: auto !important; right: auto !important; width: 26px !important; height: 26px !important; min-width: 26px !important; min-height: 26px !important; border-radius: 50% !important; background-color: #ef4444 !important; color: #ffffff !important; cursor: pointer !important; transition: all 0.2s ease; padding: 0 !important; margin: 0 !important; flex-shrink: 0 !important;" title="Close">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Scrollable Modal Body (ONLY between header and buttons, strictly left aligned) -->
            <div class="modal-body custom-scrollbar text-start" style="text-align: left !important;">
                <form onsubmit="return Update(event)" class="text-start" style="text-align: left !important;">
                    <input class="d-none" id="updateID" type="hidden">

                    <div class="row g-2.5 text-start" style="text-align: left !important;">
                        
                        <!-- Customer Name -->
                        <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                            <label for="UpdateCustomerName" class="customer-modal-label text-start" style="text-align: left !important;">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" id="UpdateCustomerName" placeholder="Enter Customer Name" required class="customer-modal-input text-start" style="text-align: left !important;" />
                        </div>

                        <!-- Customer Mobile -->
                        <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                            <label for="UpdateCustomerNumber" class="customer-modal-label text-start" style="text-align: left !important;">Customer Number <span class="text-danger">*</span></label>
                            <input type="text" id="UpdateCustomerNumber" placeholder="Enter Customer Number" required class="customer-modal-input text-start" style="text-align: left !important;" />
                        </div>

                        <!-- Customer Email -->
                        <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                            <label for="UpdateCustomerEmail" class="customer-modal-label text-start" style="text-align: left !important;">Customer Email</label>
                            <input type="email" id="UpdateCustomerEmail" placeholder="Enter Customer Email" class="customer-modal-input text-start" style="text-align: left !important;" />
                        </div>

                        <!-- NID Number -->
                        <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                            <label for="UpdateCustomerNid" class="customer-modal-label text-start" style="text-align: left !important;">NID Number</label>
                            <input type="text" id="UpdateCustomerNid" placeholder="Enter NID Number" class="customer-modal-input text-start" style="text-align: left !important;" />
                        </div>

                        <!-- Previous Due Amount -->
                        <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                            <label for="UpdateCustomerPreviousDueAmount" class="customer-modal-label text-start" style="text-align: left !important;">Previous Due Amount</label>
                            <input type="number" step="any" id="UpdateCustomerPreviousDueAmount" placeholder="0.00" class="customer-modal-input text-start" style="text-align: left !important;" />
                        </div>

                        <!-- Address Details -->
                        <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                            <label for="UpdateMoreAddress" class="customer-modal-label text-start" style="text-align: left !important;">Address Details</label>
                            <textarea id="UpdateMoreAddress" rows="1" placeholder="Enter Address Details" class="customer-modal-input text-start" style="height: 42px; padding: 9px 14px; resize: none; text-align: left !important;"></textarea>
                        </div>

                        <!-- Upload Photo (Full Width, strictly left aligned) -->
                        <div class="col-12 text-start" style="text-align: left !important;">
                            <label class="customer-modal-label text-start" style="text-align: left !important;">Customer Photo</label>
                            <div class="customer-photo-upload-box d-flex align-items-center justify-content-start gap-3 text-start" style="text-align: left !important; justify-content: flex-start !important;">
                                <!-- Preview Box -->
                                <div class="img-box position-relative flex-shrink-0" id="updateCustomerImagePreviewBox">
                                    <svg id="updateCustomerImageDefaultSvg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width: 28px; height: 28px; color: #94a3b8;">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                    <img id="updateCustomerImagePreviewImg" src="" alt="Preview" style="display: none; width: 100%; height: 100%; object-fit: cover; border-radius: 7px;" />
                                </div>

                                <!-- File Input & Info (strictly left aligned) -->
                                <div class="flex-grow-1 min-w-0 text-start" style="text-align: left !important;">
                                    <div class="d-flex justify-content-start text-start" style="text-align: left !important;">
                                        <label class="customer-file-btn d-inline-flex align-items-center gap-2 px-3">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; color: #16a34a;">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="17 8 12 3 7 8"></polyline>
                                                <line x1="12" y1="3" x2="12" y2="15"></line>
                                            </svg>
                                            <span>Upload New Photo</span>
                                            <input type="file" class="d-none" id="UpdateCustomerImage" aria-label="Upload Photo" accept="image/*" onchange="previewUpdateCustomerImage(event)" />
                                        </label>
                                    </div>
                                    <p id="updateCustomerImageInfo" class="customer-photo-info mt-1.5 mb-0 text-start" style="text-align: left !important;">PNG, JPEG or GIF (up to 1 MB)</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <!-- Sticky Bottom Footer with Red Cancel & Green Update Buttons (Strict 38px height) -->
            <div class="modal-footer d-flex align-items-center justify-content-end gap-2 flex-shrink-0">
                <button type="button" class="btn fw-semibold px-4 shadow-sm" data-bs-dismiss="modal" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important; cursor: pointer; transition: opacity 0.2s;">
                    Cancel
                </button>
                <button type="button" onclick="Update(event)" class="btn text-white fw-bold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; font-size: 13.5px !important; cursor: pointer;">
                    Update Customer
                </button>
            </div>

        </div>
    </div>
</div>
<!-- Action Button Edit Modal End -->

<style>
    /* Modal Container & Scroll Locks: Prevent outer page/modal scroll */
    #exampleModal {
        overflow-y: hidden !important;
        padding-right: 0 !important;
        text-align: left !important;
    }
    #exampleModal .modal-dialog {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        max-width: 720px !important;
        width: 95% !important;
        margin: 5vh auto !important;
        max-height: 90vh !important;
        height: auto !important;
        display: flex !important;
        align-items: center !important;
        padding: 0 !important;
        text-align: left !important;
    }
    #exampleModal .modal-content {
        border-radius: 16px !important;
        overflow: hidden !important;
        display: flex !important;
        flex-direction: column !important;
        max-height: 90vh !important;
        border: none !important;
        background: #ffffff !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35) !important;
        padding: 0 !important;
        text-align: left !important;
    }

    /* Sticky Green Header */
    #exampleModal .modal-header {
        position: sticky !important;
        top: 0 !important;
        z-index: 25 !important;
        flex-shrink: 0 !important;
        background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important;
        color: #ffffff !important;
        padding: 12px 18px !important;
        border: none !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        text-align: left !important;
    }
    #exampleModal .custom-modal-close-btn,
    #exampleModal .close-btn {
        position: relative !important;
        top: auto !important;
        right: auto !important;
        margin: 0 !important;
        flex-shrink: 0 !important;
    }

    /* Scrollable Body - ONLY between header and buttons */
    #exampleModal .modal-body {
        flex: 1 1 auto !important;
        overflow-y: auto !important;
        max-height: calc(90vh - 125px) !important;
        padding: 16px 22px !important;
        background-color: #ffffff;
        text-align: left !important;
    }

    /* Sticky Footer */
    #exampleModal .modal-footer {
        position: sticky !important;
        bottom: 0 !important;
        z-index: 25 !important;
        flex-shrink: 0 !important;
        padding: 10px 20px !important;
        background-color: #f8fafc !important;
        border-top: 1px solid #e2e8f0 !important;
    }

    /* Labels with margin-top & STRICT left alignment */
    #exampleModal .customer-modal-label,
    .customer-modal-label {
        display: block !important;
        text-align: left !important;
        margin-top: 10px !important;
        margin-bottom: 4px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #334155 !important;
        letter-spacing: 0.2px;
    }

    /* Input Fields with proper padding & unified look */
    #exampleModal .customer-modal-input,
    .customer-modal-input {
        width: 100% !important;
        height: 42px !important;
        padding: 0 14px !important;
        border-radius: 8px !important;
        border: 1px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        color: #1e293b !important;
        font-size: 13.5px !important;
        text-align: left !important;
        outline: none !important;
        box-shadow: none !important;
        transition: all 0.2s ease !important;
        box-sizing: border-box !important;
    }
    #exampleModal .customer-modal-input:focus,
    .customer-modal-input:focus {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.15) !important;
    }

    /* Image Upload Box (Clean, Left-Aligned & Dark Mode Safe) */
    #exampleModal .customer-photo-upload-box,
    .customer-photo-upload-box {
        background-color: #f8fafc !important;
        border: 1.5px dashed #cbd5e1 !important;
        border-radius: 12px !important;
        padding: 12px 14px !important;
        text-align: left !important;
        display: flex !important;
        align-items: center !important;
        justify-content: flex-start !important;
    }
    #exampleModal .customer-photo-upload-box .img-box,
    .customer-photo-upload-box .img-box {
        width: 72px !important;
        height: 60px !important;
        border-radius: 8px !important;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        overflow: hidden !important;
        flex-shrink: 0 !important;
    }
    #exampleModal .customer-file-btn,
    .customer-file-btn {
        height: 38px !important;
        border-radius: 8px !important;
        border: 1px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        color: #334155 !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        cursor: pointer !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
        transition: all 0.2s ease !important;
        margin-bottom: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: flex-start !important;
    }
    #exampleModal .customer-file-btn:hover,
    .customer-file-btn:hover {
        border-color: #16a34a !important;
        color: #15803d !important;
    }
    #exampleModal .customer-photo-info,
    .customer-photo-info {
        font-size: 11.5px !important;
        color: #64748b !important;
        text-align: left !important;
    }

    /* DARK MODE OVERRIDES (body[light-mode="dark"]) */
    body[light-mode="dark"] #exampleModal .modal-content {
        background-color: #0f172a !important;
        border: 1px solid #334155 !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7) !important;
    }
    body[light-mode="dark"] #exampleModal .modal-body {
        background-color: #0f172a !important;
    }
    body[light-mode="dark"] #exampleModal .modal-footer {
        background-color: #0f172a !important;
        border-top: 1px solid #334155 !important;
    }
    body[light-mode="dark"] #exampleModal .customer-modal-label,
    body[light-mode="dark"] .customer-modal-label {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] #exampleModal .customer-modal-input,
    body[light-mode="dark"] .customer-modal-input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] #exampleModal .customer-modal-input::placeholder,
    body[light-mode="dark"] .customer-modal-input::placeholder {
        color: #64748b !important;
    }
    body[light-mode="dark"] #exampleModal .customer-modal-input:focus,
    body[light-mode="dark"] .customer-modal-input:focus {
        border-color: #22c55e !important;
        box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2) !important;
    }
    body[light-mode="dark"] #exampleModal .customer-photo-upload-box,
    body[light-mode="dark"] .customer-photo-upload-box {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #exampleModal .customer-photo-upload-box .img-box,
    body[light-mode="dark"] .customer-photo-upload-box .img-box {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #exampleModal .customer-file-btn,
    body[light-mode="dark"] .customer-file-btn {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }
    body[light-mode="dark"] #exampleModal .customer-photo-info,
    body[light-mode="dark"] .customer-photo-info {
        color: #94a3b8 !important;
    }
</style>

<script>
    $(document).ready(function() {
        $('#exampleModal').appendTo("body");

        $('#exampleModal').on('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (button) {
                const id = $(button).data('id') || $(button).attr('data-id');
                if (id) {
                    FillUpUpdateForm(id);
                }
            }
        });
    });

    function previewUpdateCustomerImage(event) {
        const file = event.target.files && event.target.files[0];
        const previewImg = document.getElementById('updateCustomerImagePreviewImg');
        const defaultSvg = document.getElementById('updateCustomerImageDefaultSvg');
        const infoP = document.getElementById('updateCustomerImageInfo');

        if (file) {
            let sizeFormatted = file.size < 1048576 
                ? (file.size / 1024).toFixed(1) + ' KB' 
                : (file.size / (1024 * 1024)).toFixed(2) + ' MB';

            if (infoP) {
                infoP.innerHTML = `<span style="color: #15803d; font-weight: 700;"><i class="fa-solid fa-circle-check me-1"></i>${file.name}</span> <span style="background: #e2e8f0; color: #334155; font-size: 11px; padding: 2px 6px; border-radius: 4px; font-weight: 600; margin-left: 4px;">${sizeFormatted}</span>`;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                if (previewImg) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                }
                if (defaultSvg) {
                    defaultSvg.style.display = 'none';
                }
            };
            reader.readAsDataURL(file);
        }
    }

    function resetUpdateCustomerImagePreview() {
        const previewImg = document.getElementById('updateCustomerImagePreviewImg');
        const defaultSvg = document.getElementById('updateCustomerImageDefaultSvg');
        const infoP = document.getElementById('updateCustomerImageInfo');
        const fileInput = document.getElementById('UpdateCustomerImage');
        if (fileInput) fileInput.value = '';
        if (previewImg) {
            previewImg.src = '';
            previewImg.style.display = 'none';
        }
        if (defaultSvg) {
            defaultSvg.style.display = 'block';
        }
        if (infoP) {
            infoP.textContent = 'PNG, JPEG or GIF (up to 1 MB)';
        }
    }

    async function FillUpUpdateForm(id) {
        try {
            document.getElementById('updateID').value = id;
            resetUpdateCustomerImagePreview();
            showLoader();

            let res = await axios.post("/api/customer-by-id", {
                id: id.toString()
            }, HeaderToken());
            hideLoader();

            let data = res.data.rows;
            if (data) {
                document.getElementById('UpdateCustomerName').value = data.customer_name || '';
                document.getElementById('UpdateMoreAddress').value = data.address_details || '';
                document.getElementById('UpdateCustomerNumber').value = data.mobile || '';
                document.getElementById('UpdateCustomerEmail').value = data.email || '';
                document.getElementById('UpdateCustomerNid').value = data.nid || '';
                document.getElementById('UpdateCustomerPreviousDueAmount').value = data.previous_due_amount || 0;

                // Show existing image if available
                if (data.img_url) {
                    const previewImg = document.getElementById('updateCustomerImagePreviewImg');
                    const defaultSvg = document.getElementById('updateCustomerImageDefaultSvg');
                    if (previewImg) {
                        previewImg.src = data.img_url;
                        previewImg.style.display = 'block';
                    }
                    if (defaultSvg) {
                        defaultSvg.style.display = 'none';
                    }
                }
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    async function Update(event) {
        if (event) event.preventDefault();
        try {
            let CustomerName = $('#UpdateCustomerName').val().trim();
            let CustomerNumber = $('#UpdateCustomerNumber').val().trim();

            if (CustomerName.length === 0) {
                errorToast("Customer Name is required!");
                return false;
            }
            if (CustomerNumber.length === 0) {
                errorToast("Customer Number is required!");
                return false;
            }

            let formData = new FormData();
            formData.append('customer_name', CustomerName);
            formData.append('address_details', $('#UpdateMoreAddress').val().trim());
            formData.append('mobile', CustomerNumber);
            formData.append('email', $('#UpdateCustomerEmail').val().trim());
            formData.append('nid', $('#UpdateCustomerNid').val().trim());
            formData.append('previous_due_amount', $('#UpdateCustomerPreviousDueAmount').val().trim() || 0);
            formData.append('id', $('#updateID').val());

            let imgInput = document.getElementById('UpdateCustomerImage')?.files[0];
            if (imgInput) {
                formData.append('img', imgInput);
            }

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            showLoader();
            let res = await axios.post("/api/update-customer", formData, config);
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message);
                $("#exampleModal").modal('hide');
                if (typeof getList === 'function') {
                    await getList();
                } else {
                    setTimeout(() => location.reload(), 500);
                }
            } else {
                errorToast(res.data.message);
            }
        } catch (e) {
            hideLoader();
            console.error("Error:", e.response);
            errorToast("Failed to update customer.");
        }
        return false;
    }
</script>
