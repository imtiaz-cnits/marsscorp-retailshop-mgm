<!-- Create Product Modal Start -->
<section id="createProduct" class="financemodal">
            <div class="modal-content">
                <a class="close-btn closes">
                    <i class="fa-solid fa-xmark"></i>
                </a>
                <h2 class="heading">Create Upazila</h2>
                <div id="popup-modal">
                    <form id="UpazilaForm" onsubmit="return Save(event)">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-row">
                                    <select class="form-select input-style" id="UpazilaTypeAll"
                                        aria-label="Default select example">
                                        <option value="none">Select Upazila Type</option>
                                    </select>
                                    <button type="button" class="btn-add newbrand-open">
                                        + Add Upazila Type
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">

                                <div class="form-row">
                                    <input type="text" placeholder="Enter Upazila Name*" id="UpazilaNameCreate" required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label class="country">
                                        <select name="status" id="UpazilaSelectStatus" required>
                                            <option value="">Select Status</option>
                                            <option value="Active">Active</option>
                                            <option value="InActive">Inactive</option>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="actions">
                                <button onclick="UpazilaDataSave(event)" class="btn-save">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Create Product Modal End -->

        <!-- Add Product modal to Add New Brand Modal Start -->
        <div class="newbrand" id="addBrandModal">
            <div class="newbrand-content">
                <h2>Create Upazila</h2>
                <form>
                    <div class="col-lg-6"></div><br>
                    <div class="form-group">
                        <input type="text" id="CreateDistrictTypeName" placeholder="Enter District Name" />

                    </div>
                    <div class="form-group">
                        <div class="dropdown-wrapper">
                            <select class="status-select" id="DistrictSelectStatus">
                                <option disabled selected>Select Upazila Status</option>
                                <option value="Active">Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </div>
                    </div>
                    <div class="button-group">
                        <button type="button" class="cancel-btn newbrand-close">
                            Cancel
                        </button>
                        <button onclick="UpazilaSaveType(event)" class="save-btn">Save Upazila Type</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add Product modal to New Brand Modal End -->


<script>
    // Save brand function
    async function UpazilaSaveType(event) {
    event.preventDefault();

    try {
        const DistrictTypeName = document.getElementById('CreateDistrictTypeName').value;
        const DistrictStatus = document.getElementById('DistrictSelectStatus').value;

        // Validation
        if (!DistrictTypeName) {
            errorToast("District Type Name is required!");
            return;
        }
        if (!DistrictStatus) {
            errorToast("District Select Status is required!");
            return;
        }

        // Prepare form data
        const formData = new FormData();
        formData.append('district_name', DistrictTypeName);
        formData.append('status', DistrictStatus);

        const config = {
            headers: {
                'Content-Type': 'multipart/form-data',
                ...HeaderToken().headers,
            },
        };

        // API call to save District type
        const res = await axios.post("/api/create-district", formData, config);

        if (res.data.status === "success") {
            successToast(res.data.message);

            // Clear the form and close the modal
            document.getElementById('CreateDistrictTypeName').value = '';
            document.getElementById('DistrictSelectStatus').value = '';
            closeBrandModal();

            // Refresh the dropdown and select the newly created District type
            await refreshDistrictList(res.data.NewDistrictId);
        } else {
            errorToast(res.data.message);
        }
    } catch (e) {
        unauthorized(e.response?.status || 500);
    }
}

// Refresh expense list and optionally select the newly added District type
async function refreshDistrictList(selectedDistrictId = null) {
    try {
        const response = await axios.get('/api/district-list', HeaderToken());
        const DistrictTypeList = response.data.DistrictData;

        // Build the options for the dropdown
        let optionsHtml = '<option value="none" selected>Select District Type</option>';
        optionsHtml += DistrictTypeList
            .map((type) => `<option value="${type.id}" ${selectedDistrictId === type.id ? 'selected' : ''}>${type.district_name}</option>`)
            .join('');

        // Populate the dropdown
        document.getElementById('UpazilaTypeAll').innerHTML = optionsHtml;
    } catch (error) {
        console.error("Error occurred while fetching expense types:", error);
    }
}




    // Modal handling (open/close)
    function closeBrandModal() {
        document.getElementById('addBrandModal').style.display = 'none';
    }

    function openBrandModal() {
        document.getElementById('addBrandModal').style.display = 'block';
    }

    // Trigger modal open/close
    document.querySelector('.newbrand-open').addEventListener('click', openBrandModal);
    document.querySelector('.newbrand-close').addEventListener('click', closeBrandModal);

    // Initial brand list fetch
    refreshDistrictList();




async function Save(event) {
    event.preventDefault(); // Prevent form submission and page reload
    try {
        let UpazilaTypeAll = document.getElementById('UpazilaTypeAll').value;
        let UpazilaNameCreate = document.getElementById('UpazilaNameCreate').value;
        let UpazilaStatus = document.getElementById('UpazilaSelectStatus').value;

        if (!UpazilaTypeAll) {
            errorToast("UpazilaTypeAll are required!");
            return false;
        } else if (!UpazilaNameCreate) {
            errorToast("Upazila Name Create is required!");
            return false;
        }
        else {
            let formData = new FormData();
            formData.append('district_id', UpazilaTypeAll);
            formData.append('upazila_name', UpazilaNameCreate);
            formData.append('status', UpazilaStatus);

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers,
                },
            };

            let res = await axios.post("/api/create-upazila", formData, config);

            if (res.data['status'] === "success") {
                successToast(res.data['message']);
                document.getElementById("UpazilaForm").reset();
                closeModal(document.getElementById('myModal'));
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
}

function closeModal(modal) {
    modal.style.display = 'none';
}
</script>
