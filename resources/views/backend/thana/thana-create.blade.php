<style>
    .financemodal .modal-content {
        /* margin: 100px 0px 100px 0px; */
        border-radius: 10px;
        width: 40%;
    }

    @media screen and (max-width: 992px) {
        .financemodal .modal-content {
            width: 90%;
            /* margin: 400px 0px 100px 0px; */


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

        <!-- Create Product Modal Start -->
        <section id="createProduct" class="financemodal">
            <div class="modal-content">
                <a class="close-btn closes">
                    <i class="fa-solid fa-xmark"></i>
                </a>
                <h2 class="heading">Create Thana</h2>
                <div id="popup-modal">
                    <form onsubmit="return Save(event)" id="signup">
                        <!-- Select Dropdowns with Add Buttons -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <select id="DistrictSelectData">
                                        <option disabled selected>
                                            Select District <span class="star">*</span>
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-row">
                                    <select id="UpozelaSelectData">
                                        <option disabled selected>
                                            Select Upazila <span class="star">*</span>
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <input type="text" placeholder="Thana Name *" id="ThanaName"  />
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label class="country">
                                        <select name="status" id="ThanaSelectStatus" required>
                                            <option value="">Select Status</option>
                                            <option value="Active">Active</option>
                                            <option value="InActive">Inactive</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="actions">
                                <button onclick="ThanaDataSave(event)" class="btn-save">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Create Product Modal End -->


<script>
    let allUpazilas = [];

    // Load districts on page load
    DistrictList();

    async function DistrictList() {
        try {
            const response = await axios.get('/api/district-list', HeaderToken());
            const DistrictTypeList = response.data.DistrictData;

            // Build the options for the District dropdown
            let optionsHtml = '<option disabled selected>Select District</option>';
            optionsHtml += DistrictTypeList
                .map((type) => `<option value="${type.id}">${type.district_name}</option>`)
                .join('');
            document.getElementById('DistrictSelectData').innerHTML = optionsHtml;

            // Add event listener for District selection
            document.getElementById('DistrictSelectData').addEventListener('change', (e) => {
                const selectedDistrictId = e.target.value;
                filterUpazilasByDistrict(selectedDistrictId);
            });
        } catch (error) {
            console.error('Error occurred while fetching districts:', error);
        }
    }

    // Load all Upazilas
    async function UpazilaList() {
        try {
            const response = await axios.get('/api/upazila-list', HeaderToken());
            allUpazilas = response.data.UpazilasData; // Store all Upazilas for filtering
        } catch (error) {
            console.error('Error occurred while fetching upazilas:', error);
        }
    }

    // Filter Upazilas based on selected District
    function filterUpazilasByDistrict(districtId) {
        const filteredUpazilas = allUpazilas.filter((upazila) => upazila.district_id == districtId);

        // Build the options for the Upazila dropdown
        let optionsHtml = '<option disabled selected>Select Upazila</option>';
        optionsHtml += filteredUpazilas
            .map((type) => `<option value="${type.id}">${type.upazila_name}</option>`)
            .join('');
        document.getElementById('UpozelaSelectData').innerHTML = optionsHtml;
    }

    // Load Upazilas on page load
    UpazilaList();
</script>

{{-- Product Create JS Code Start  --}}

<script>
    async function ThanaDataSave(event) {
        event.preventDefault();
        try {

            let DistrictSelectData = document.getElementById('DistrictSelectData').value;
            let UpozelaSelectData = document.getElementById('UpozelaSelectData').value;
            let ThanaName = document.getElementById('ThanaName').value;
            let ThanaSelectStatus = document.getElementById('ThanaSelectStatus').value;


            if (DistrictSelectData.length === 0) {
                errorToast("District Select Data is required!");
                return false;
            } else if (UpozelaSelectData.length === 0) {
                errorToast("Upozela Select Data is required!");
                return false;
            }

            else if (ThanaName.length === 0) {
                errorToast("Thana Name is required!");
                return false;
            }

            else if (ThanaSelectStatus.length === 0) {
                errorToast("Thana Select Status is required!");
                return false;
            }

            else {
                let formData = new FormData();
                formData.append('district_id', DistrictSelectData);
                formData.append('upazila_id', UpozelaSelectData);
                formData.append('Thana_name', ThanaName);
                formData.append('status', ThanaSelectStatus);

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data',
                        ...HeaderToken().headers
                    }
                };

                let res = await axios.post("/api/create-thana", formData, config);

                if (res.data['status'] === "success") {
                    successToast(res.data['message']);
                    document.getElementById("signup").reset();
                    const modal = document.getElementById('myModal');
                    closeModal(modal);
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    errorToast(res.data['message']);
                }
            }
        } catch (e) {
            unauthorized(e.response.status);
        }
        return false;
    }

    function closeModal(modal) {
        modal.style.display = 'none';
    }
</script>
