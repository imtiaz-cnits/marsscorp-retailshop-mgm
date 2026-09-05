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
        <h2 class="heading">Sub Category Update</h2>
        <div id="popup-modal">
            <form>
                <div class="row">

                    <div class="col">

                        <div class="form-row">
                            <input type="text" placeholder="Sub Category *" id="UpdateSubCategory"  />
                        </div>
                        <div class="form-row">
                            <select class="status-select" id="UpdateSelectStatus">
                                <option disabled selected>Select status</option>
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
                // Set the brand id in the hidden input
                document.getElementById('updateID').value = id;
                showLoader();

                // Fetch the brand data by ID
                let res = await axios.post("/", {
                    id: id.toString()
                }, HeaderToken());
                hideLoader();

                // Populate the form with the fetched data
                let data = res.data.rows;
                document.getElementById('UpdateProductCategory').value = data.category_id;
                document.getElementById('UpdateSubCategory').value = data.sub_category_name;
                document.getElementById('UpdateSelectStatus').value = data.status;
                openModal(document.getElementById('editModal'));

            } catch (e) {
                unauthorized(e.response.status);
            }
        }


    // Update Product
    async function Update() {
        try {
            let formData = new FormData();
            formData.append('', $('#UpdateProductCategory').val());
            formData.append('', $('#UpdateSubCategory').val());
            formData.append('', $('#UpdateSelectStatus').val());
            formData.append('', $('#updateID').val());

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            showLoader();
            let res = await axios.post("/", formData, config);
            hideLoader();


            if (res.data.status === "success") {
                    successToast(res.data.message);
                    const updatemodal1 = document.getElementById('editModal');
                    closeModal(updatemodal1);
                    await getList(); // Refresh the brand list
                } else {
                    errorToast(res.data.message);
                }

            } catch (e) {
                unauthorized(e.response.status); // Handle unauthorized or other errors
            }
    }





    async function Update() {
        try {
            let UpdateProductCategory = document.getElementById('UpdateProductCategory').value;
            let UpdateSubCategory = document.getElementById('UpdateSubCategory').value;
            let UpdateSelectStatus = document.getElementById('UpdateSelectStatus').value;
            let updateID = document.getElementById('updateID').value;


            // Prepare form data
            let formData = new FormData();
            formData.append('category_id', UpdateProductCategory);
            formData.append('sub_category_name', UpdateSubCategory);
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

            // Make the request to update the brand
            let res = await axios.post("/api/update-sub-category", formData, config);
            hideLoader(); // Hide loader after request completion

            if (res.data.status === "success") {
                successToast(res.data.message);
                const updatemodal1 = document.getElementById('editModal');
                closeModal(updatemodal1);
                await getList(); // Refresh the brand list
            } else {
                errorToast(res.data.message);
            }

        } catch (e) {
            unauthorized(e.response.status); // Handle unauthorized or other errors
        }
    }


</script>
