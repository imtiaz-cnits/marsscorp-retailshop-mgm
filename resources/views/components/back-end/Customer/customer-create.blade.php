<style>
    .financemodal .modal-content {
        border-radius: 10px;
        width: 60%;
    }

    @media screen and (max-width: 992px) {
        .financemodal .modal-content {
            width: 90%;
        }
    }

    .financemodal .modal-content .col-lg-6,
    .financemodal .modal-content .col-lg-4 {
        padding: 0 6px !important;
    }

    .newbrand .upload-profile .item,
    .newcategory .upload-profile .item {
        width: 100%;
        display: flex !important;
        gap: 10px;
        margin-bottom: 15px;
    }

    .newbrand .upload-profile .item .img-box,
    .newcategory .upload-profile .item .img-box {
        width: 84px;
        height: 70px;
        border-radius: 6px;
        background: #f2f2f2;
        display: flex !important;
        justify-content: center;
        align-items: center;
    }

    .newbrand .profile-wrapper,
    .newcategory .profile-wrapper {
        width: 100%;
    }

    .newbrand .parent,
    .newcategory .parent {
        width: 100%;
        height: 100%;
        display: inline-flex;
        justify-content: space-between;
        flex-direction: column;
    }

    .newbrand .profile-wrapper p,
    .newcategory .profile-wrapper p {
        margin: 8px 0px 0px 0px;
        font-size: 14px;
        color: #aaaaaa;
    }

    .newbrand .custom-file-input-wrapper,
    .newcategory .custom-file-input-wrapper {
        font-family: var(--primary-font);
        position: relative;
        width: 100%;
        height: 46px;
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 16px;
        color: #666;
        background: #ededed;
        cursor: pointer;
    }

    .newbrand .custom-file-input,
    .newcategory .custom-file-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        z-index: 2;
        cursor: pointer;
    }

    .newbrand .custom-file-input-wrapper input[type="file"],
    .newcategory .custom-file-input-wrapper input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        z-index: -2;
        cursor: pointer;
    }

    .newbrand .custom-file-input-wrapper::before,
    .newcategory .custom-file-input-wrapper::before {
        content: "";
        position: absolute;
        margin: 0px 118px 0px auto;
        width: 20px;
        height: 20px;
        background-image: url("../icons/upload-photo-icon.svg");
        background-size: cover;
        background-position: center;
    }

    .newbrand .custom-file-input-wrapper::after,
    .newcategory .custom-file-input-wrapper::after {
        content: "Upload Photo";
        margin-right: -20px !important;
    }

    .newbrand .upload p,
    .newcategory .upload p {
        font-size: 12px;
        color: #777;
    }
</style>

        <!-- Create Customer Modal Start -->
        <section id="createProduct" class="financemodal">
            <div class="modal-content">
                <a class="close-btn closes">
                    <i class="fa-solid fa-xmark"></i>
                </a>
                <h2 class="heading">Add New Customer</h2>
                <div id="popup-modal">
                    <form onsubmit="return Save(event)" id="signup">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-row">
                                    <input type="text" placeholder="Enter Customer Name *" id="CreateCustomerName" required />
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-row">
                                    <input type="text" placeholder="Enter Customer Number *" id="CreateCustomerMobile" required />
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-row">
                                    <input type="email" placeholder="Enter Customer Email" id="CreateCustomerEmail" />
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-row">
                                    <input type="text" placeholder="Enter Nid Number" id="CreateCustomerNIDNumber" />
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-row">
                                    <input type="number" step="any" placeholder="Enter Previous Due Amount" id="CreateCustomerPreviousDue" />
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-row">
                                    <textarea name="address_details" id="CreateCustomerAddressDetails" cols="30" rows="3"
                                        placeholder="Enter Address Details"></textarea>
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
                                                            xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAAMsklEQVR4Ae2daYwtRRmG34uAIF5RDMTlYkABvSJuP1BccMHgRtyiqNG4EI1bcCOBaDCaKEYMYlwIEBRRf7j9UHFBRBJQEgyIIJtKLmiAXGVRUAT35bzDNH40M13Vc/qcqT71VHLS1dN9znQ99T1dvVR3SSQIQAACEIAABCAAAQhAAAIQgAAEIAABCEAAAhCAAAQgAAEIQAACEIAABCAAAQhAAAIQgAAEIAABCEAAAhCAAAQgAAEIQAACEIAABCAAAQhAAAIQgAAEIAABCEAAAhCAAAQgAAEIQAACEIAABCAAAQhAAAIQgAAEIAABCEAAAhCAAAQgAAEIQAACEIAABCAAAQhAAAIQgAAEIAABCEAAAhCAAAQgAAEIQAACEIAABCAAAQhAAAIQgAAEInB0A/4Ps8I87+ZzL/0AAAAASUVORK5CYII=" />
                                                    </defs>
                                                </svg>
                                            </div>

                                            <div class="profile-wrapper">
                                                <label class="custom-file-input-wrapper">
                                                    <input type="file" class="custom-file-input" id="CreateCustomerImage"
                                                        aria-label="Upload Photo" />
                                                </label>
                                                <p>PNG, JPEG or GIF (up to 1 MB)</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="actions mt-3">
                                <button onclick="CustomerDataSave(event)" class="btn-save">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Create Customer Modal End -->

<script>
    async function CustomerDataSave(event) {
        if (event) event.preventDefault();
        try {
            let ProductImageInput = document.getElementById('CreateCustomerImage')?.files[0];
            let CustomerName = document.getElementById('CreateCustomerName')?.value?.trim() || '';
            let more_address_details = document.getElementById('CreateCustomerAddressDetails')?.value?.trim() || '';
            let CustomerMobile = document.getElementById('CreateCustomerMobile')?.value?.trim() || '';
            let CustomerEmail = document.getElementById('CreateCustomerEmail')?.value?.trim() || '';
            let CustomerNIDNumber = document.getElementById('CreateCustomerNIDNumber')?.value?.trim() || '';
            let PreviousDueAmount = document.getElementById('CreateCustomerPreviousDue')?.value?.trim() || '0';

            if (CustomerName.length === 0) {
                errorToast("Customer Name is required!");
                return false;
            }
            if (CustomerMobile.length === 0) {
                errorToast("Customer Mobile is required!");
                return false;
            }

            let formData = new FormData();
            formData.append('customer_name', CustomerName);
            formData.append('mobile', CustomerMobile);
            formData.append('email', CustomerEmail);
            formData.append('nid', CustomerNIDNumber);
            formData.append('previous_due_amount', PreviousDueAmount || 0);
            formData.append('address_details', more_address_details);
            if (ProductImageInput) {
                formData.append('img', ProductImageInput);
            }

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            let res = await axios.post("/api/create-customer", formData, config);

            if (res.data['status'] === "success") {
                successToast(res.data['message']);
                
                const signupForm = document.getElementById("signup");
                if (signupForm) signupForm.reset();

                const modal = document.getElementById('createProduct') || document.getElementById('myModal');
                if (modal) modal.style.display = 'none';

                if (typeof CustomerTypeData === 'function') {
                    await CustomerTypeData();
                    if (res.data.customer) {
                        const cust = res.data.customer;
                        const itemEl = document.querySelector(`#CustomerSelectData .dropdown-item[data-id="${cust.id}"]`);
                        if (itemEl) {
                            itemEl.click();
                        } else {
                            const nameField = document.getElementById("CustomerName");
                            const idField = document.getElementById("CustomerID");
                            const mobileField = document.getElementById("CustomerMobileNumber");
                            const addressField = document.getElementById("CustomerAddress");
                            if (nameField) nameField.value = cust.customer_name;
                            if (idField) idField.value = cust.customer_id;
                            if (mobileField) mobileField.value = cust.mobile;
                            if (addressField) addressField.value = cust.address_details || '';
                        }
                    }
                } else {
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }
            } else {
                errorToast(res.data['message']);
            }
        } catch (e) {
            console.error(e);
            unauthorized(e.response ? e.response.status : 500);
        }
        return false;
    }

    function closeModal(modal) {
        if (modal) modal.style.display = 'none';
    }
</script>
