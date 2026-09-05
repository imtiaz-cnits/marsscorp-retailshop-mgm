<style>
    #exampleModal .modal-dialog {
        max-width: 40%;
        height: auto;
    }
</style>

<!-- Action Button Edit Modal-2 Start -->
<section class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close-btn close" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <h2 class="heading">Sub Category Update</h2>
            <div id="popup-modal">
                <form>
                    <div class="row">
                        <div class="col">
                            <div class="form-row">
                                <select class="status-select" id="UpdateProductCategory">
                                    <option disabled selected>Select Product Category</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-row">
                                <input type="text" placeholder="Sub Category *" id="UpdateSubCategory" />
                            </div>
                            <div class="form-row">
                                <select class="status-select" id="UpdateSelectStatus">
                                    <option disabled selected>Select brand status</option>
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
</section>
<!-- Action Button Edit Modal End -->

<script>
    ProductCategoryShow();
    async function ProductCategoryShow() {
        try {
            let res = await axios.get("/api/category-list", HeaderToken());
            let optionsHtml = res.data.CategoryData.map(Category =>
                `<option value="${Category.id}">${Category.category_name}</option>`).join('');
            $("#UpdateProductCategory").html(`<option value="none" selected>Select Category</option>` +
                optionsHtml);
        } catch (error) {
            console.error("Error fetching categories:", error);
        }
    }




    // Function to fill the form when editing
    async function FillUpUpdateForm(id) {
        try {
            // Set the brand id in the hidden input
            document.getElementById('updateID').value = id;
            showLoader();

            // Fetch the brand data by ID
            let res = await axios.post("/api/sub-category-by-id", {
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

    // Update Brand Script
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
