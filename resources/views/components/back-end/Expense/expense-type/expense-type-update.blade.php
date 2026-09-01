<style>
    #exampleModal .modal-dialog {
        max-width: 40%;
        height: auto;
    }
   </style>

   <!-- Action Button Edit Modal-2 Start -->
   <section
   class="modal fade"
   id="exampleModal"
   tabindex="-1"
   aria-labelledby="exampleModalLabel"
   aria-hidden="true"
 >
   <div class="modal-dialog">
     <div class="modal-content">
       <button
         type="button"
         class="close-btn close"
         data-bs-dismiss="modal"
         aria-label="Close"
       >
         <i class="fa-solid fa-xmark"></i>
       </button>
       <h2 class="heading">Edit Brand</h2>
       <div id="popup-modal">
         <form>
                    <div class="row">
                        <div class="col">
                            <div class="form-row">
                                <input type="text" placeholder="Update Expense Type Name *"
                                    id="UpdateExpenseTypeName" required />
                            </div>
                            <div class="form-row">
                                <select class="status-select" id="UpdateSelectStatus">
                                    <option disabled selected>Select Expense Type status</option>
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
                // Set the category id in the hidden input
                document.getElementById('updateID').value = id;
                showLoader();

                // Fetch the category data by ID
                let res = await axios.post("/api/expense-type-by-id", {
                    id: id.toString()
                }, HeaderToken());
                hideLoader();

                // Populate the form with the fetched data
                let data = res.data.rows;
                document.getElementById('UpdateExpenseTypeName').value = data.type_name;
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
                let UpdateExpenseTypeName = document.getElementById('UpdateExpenseTypeName').value;
                let updateID = document.getElementById('updateID').value;
                let UpdateSelectStatus = document.getElementById('UpdateSelectStatus').value;

                // Validate required fields
                if (!UpdateExpenseTypeName || !UpdateSelectStatus) {
                    return errorToast('Please fill out all required fields.');
                }

                // Prepare form data
                let formData = new FormData();
                formData.append('type_name', UpdateExpenseTypeName);
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
                let res = await axios.post("/api/update-expense-type", formData, config);
                hideLoader(); // Hide loader after request completion

                if (res.data.status === "success") {
                    successToast(res.data.message);
                    const updatemodal1 = document.getElementById('editModal');
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
