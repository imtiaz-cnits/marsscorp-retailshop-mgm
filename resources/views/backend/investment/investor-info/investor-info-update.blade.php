<style>
    #editModal .modal-content {
        width: 50%;
        margin: 0;
    }

    #editModal .modal-content .row .col-lg-4 {
        padding: 0px 6px !important
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
        <h2 class="heading">Investor Info Update</h2>
        <div id="popup-modal">
            <form>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-row">
                            <input type="text" placeholder="Enter Your Name" id="UpdateInvestorName" required />
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="form-row">
                            <input type="text" placeholder="Enter Your Number" id="UpdateInvestoNumber" required />
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="form-row">
                            <input type="text" placeholder="Enter Your Email" id="UpdateInvestorEmail" required />
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-row">
                            <input type="text" placeholder="Enter Your Address" id="UpdateInvestorAddress" required />
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="form-row">
                            <label class="country">
                                <select name="status" id="UpdateSelectStatus" required>
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="InActive">Inactive</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <input class="d-none" id="updateID">
                    <div class="col-lg-4">

                    </div>
                </div>

                    <div class="actions">
                        <button onclick="Update()" class="btn-save">Submit</button>
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
            // Set the category id in the hidden input
            document.getElementById('updateID').value = id;
            showLoader();

            // Fetch the category data by ID
            let res = await axios.post("/api/investor-info-by-id", { id: id.toString() }, HeaderToken());
            hideLoader();

            // Populate the form with the fetched data
            let data = res.data.rows;
            document.getElementById('UpdateInvestorName').value = data.name;
            document.getElementById('UpdateInvestoNumber').value = data.mobile;
            document.getElementById('UpdateInvestorEmail').value = data.email;
            document.getElementById('UpdateInvestorAddress').value = data.address;
            document.getElementById('UpdateSelectStatus').value = data.status;

            // Open the modal after filling the form
            const modal = document.getElementById('custom-modal-1');
            openModal(modal);

        } catch (e) {
            unauthorized(e.response.status);
        }
    }

    // Update Category Script
    async function Update() {
        try {
            let UpdateInvestorName = document.getElementById('UpdateInvestorName').value;
            let UpdateInvestoNumber = document.getElementById('UpdateInvestoNumber').value;
            let UpdateInvestorAddress = document.getElementById('UpdateInvestorAddress').value;
            let UpdateInvestorEmail = document.getElementById('UpdateInvestorEmail').value;
            let UpdateSelectStatus = document.getElementById('UpdateSelectStatus').value;
            let updateID = document.getElementById('updateID').value;


            // Validate required fields
            if (!UpdateInvestorName || !UpdateInvestoNumber || !UpdateInvestorAddress || !UpdateSelectStatus) {
                return errorToast('Please fill out all required fields.');
            }

            // Prepare form data
            let formData = new FormData();
            formData.append('name', UpdateInvestorName);
            formData.append('mobile', UpdateInvestoNumber);
            formData.append('address', UpdateInvestorAddress);
            formData.append('email', UpdateInvestorEmail);
            formData.append('status', UpdateSelectStatus);
            formData.append('id', updateID);

            // Set the request configuration with headers
            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers // Add authorization headers
                }
            };

            showLoader(); // Show loader when submitting

            // Make the request to update the category
            let res = await axios.post("/api/update-investor-info", formData, config);
            hideLoader(); // Hide loader after request completion

            if (res.data.status === "success") {
                successToast(res.data.message);
                const updatemodal1 = document.getElementById('custom-modal-1');
                closeModal(updatemodal1);
                await getList(); // Refresh the category list
            } else {
                errorToast(res.data.message);
            }

        } catch (e) {
            unauthorized(e.response.status); // Handle unauthorized or other errors
        }
    }
</script>
