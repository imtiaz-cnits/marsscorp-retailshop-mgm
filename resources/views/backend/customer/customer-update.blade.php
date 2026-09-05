<style>
    #exampleModal {
        z-index: 1060 !important;
    }
    #exampleModal .modal-dialog {
        width: 50%;
        height: auto;
    }

    @media screen and (max-width: 992px) {
        #exampleModal .modal-dialog {
            width: 90%;
            height: auto;
        }
    }
</style>

<!-- Action Button Edit Modal Start -->
<section class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close-btn close" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <h2 class="heading">Customer Update</h2>
            <div id="popup-modal">
                <form onsubmit="return Update(event)">
                    <input class="d-none" id="updateID">

                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <div class="form-row">
                                <input type="text" placeholder="Enter Customer Name *" id="UpdateCustomerName" required />
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-row">
                                <input type="text" placeholder="Enter Customer Number *" id="UpdateCustomerNumber" required />
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-row">
                                <input type="email" placeholder="Enter Customer Email" id="UpdateCustomerEmail" />
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-row">
                                <input type="text" placeholder="Enter Customer NID" id="UpdateCustomerNid" />
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-row">
                                <input type="number" step="any" placeholder="Enter Previous Due Amount" id="UpdateCustomerPreviousDueAmount" />
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-row">
                                <textarea name="address_details" id="UpdateMoreAddress" cols="30" rows="3" placeholder="Enter Address Details"></textarea>
                            </div>
                        </div>

                        <!-- Upload Photo moved to bottom -->
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <div class="upload-profile">
                                    <div class="item">
                                        <div class="img-box">
                                            <svg width="32" height="32" viewBox="0 0 50 50" fill="red"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <rect width="50" height="50" fill="url(#pattern0_1204_6)"
                                                    fill-opacity="0.5" />
                                                <defs>
                                                    <pattern id="pattern0_1204_6"
                                                        patternContentUnits="objectBoundingBox" width="1"
                                                        height="1">
                                                        <use xlink:href="#image0_1204_6" transform="scale(0.005)" />
                                                    </pattern>
                                                    <image id="image0_1204_6" width="200" height="200"
                                                        xlink:href="data:image/png;base64,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" />
                                                </defs>
                                            </svg>
                                        </div>

                                        <div class="profile-wrapper">
                                            <label class="custom-file-input-wrapper">
                                                <input type="file" class="custom-file-input"
                                                    aria-label="Upload Photo" id="UpdateCustomerImage" />
                                            </label>
                                            <p>PNG, JPEG or GIF (up to 1 MB)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="actions mt-3">
                            <button type="submit" class="btn-save">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Action Button Edit Modal End -->

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

    async function FillUpUpdateForm(id) {
        try {
            document.getElementById('updateID').value = id;

            let res = await axios.post("/api/customer-by-id", {
                id: id.toString()
            }, HeaderToken());

            let data = res.data.rows;
            if (data) {
                document.getElementById('UpdateCustomerName').value = data.customer_name || '';
                document.getElementById('UpdateMoreAddress').value = data.address_details || '';
                document.getElementById('UpdateCustomerNumber').value = data.mobile || '';
                document.getElementById('UpdateCustomerEmail').value = data.email || '';
                document.getElementById('UpdateCustomerNid').value = data.nid || '';
                document.getElementById('UpdateCustomerPreviousDueAmount').value = data.previous_due_amount || 0;
            }
        } catch (e) {
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
