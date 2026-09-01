<style>
    #editModal .modal-content {
        width: 50%;
        margin: 0;
    }

    @media screen and (max-width: 992px) {
        #editModal .modal-content {
            width: 90%;
            margin: 0;
        }
    }
</style>
<!-- Action Button Edit Modal Start -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <a class="close-btn close">
            <i class="fa-solid fa-xmark"></i>
        </a>
        <h2 class="heading">district Update</h2>
        <div id="popup-modal">
            <form>
                <div class="row">
                    <div class="col">
                        <div class="form-row">
                            <input type="text" placeholder="district Name *" id="UpdatedistrictName" />
                        </div>
                        <div class="form-row">
                            <select class="status-select" id="UpdateSelectStatus">
                                <option disabled selected>Select district status</option>
                                <option value="Active">Active</option>
                                <option value="InActive">Inactive</option>
                            </select>
                            <input class="d-none" id="updateID">

                        </div>
                    </div>
                    <div class="actions">
                        <button onclick="Update()" class="btn-save">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Action Button Edit Modal End -->

<script>

    // Function to fill the form when editing
    async function FillUpUpdateForm(id) {
        try {
            // Set the district id in the hidden input
            document.getElementById('updateID').value = id;
            showLoader();

            // Fetch the district data by ID
            let res = await axios.post("/api/district-by-id", {
                id: id.toString()
            }, HeaderToken());
            hideLoader();

            // Populate the form with the fetched data
            let data = res.data.rows;
            document.getElementById('UpdatedistrictName').value = data.district_name;
            document.getElementById('UpdateSelectStatus').value = data.status;
            openModal(document.getElementById('editModal'));

        } catch (e) {
            unauthorized(e.response.status);
        }
    }

    // Update district Script
    async function Update() {
        try {
            let UpdatedistrictName = document.getElementById('UpdatedistrictName').value;
            let UpdatedistrictStatus = document.getElementById('UpdateSelectStatus').value;
            let updateID = document.getElementById('updateID').value;

            // Validate required fields
            if (!UpdatedistrictName || !UpdatedistrictStatus) {
                return errorToast('Please fill out all required fields.');
            }

            // Prepare form data
            let formData = new FormData();
            formData.append('district_name', UpdatedistrictName);
            formData.append('status', UpdatedistrictStatus);
            formData.append('id', updateID);

            // Set the request configuration with headers
            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers // Add authorization headers
                }
            };

            showLoader(); // Show loader when submitting

            // Make the request to update the district
            let res = await axios.post("/api/update-district", formData, config);
            hideLoader(); // Hide loader after request completion

            if (res.data.status === "success") {
                successToast(res.data.message);
                const updatemodal1 = document.getElementById('editModal');
                closeModal(updatemodal1);
                await getList(); // Refresh the district list
            } else {
                errorToast(res.data.message);
            }

        } catch (e) {
            unauthorized(e.response.status); // Handle unauthorized or other errors
        }
    }
</script>
