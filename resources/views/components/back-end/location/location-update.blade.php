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
       <h2 class="heading">Edit Location</h2>
       <div id="popup-modal">
         <form>
           <div class="row">
             <div class="col-12">
               <div class="form-row col-12">
                 <label for="">Loction Name *</label>
                 <input
                   type="text"
                   placeholder="Brand Name"
                   id="UpdateLocationName"
                   required
                 />
               </div>
               <div class="form-row col-12">
                 <label for="">Select Status *</label>
                 <select class="status-select" id="UpdateSelectStatus">
                   <option disabled selected>Select brand status</option>
                   <option value="Active">Active</option>
                   <option value="InActive">Inactive</option>
               </select>
               <input class="d-none" id="updateID">
               </div>
             </div>
           </div>
             <div class="actions">
                <button onclick="Update()" class="btn-save">Submit</button>
             </div>

         </form>
       </div>
     </div>
   </div>
 </section>

 <!-- Action Button Edit Modal-2 Start -->
    <script>

        // Function to fill the form when editing
        async function FillUpUpdateForm(id) {
            try {
                // Set the brand id in the hidden input
                document.getElementById('updateID').value = id;
                showLoader();

                // Fetch the brand data by ID
                let res = await axios.post("/api/location-by-id", {
                    id: id.toString()
                }, HeaderToken());
                hideLoader();

                // Populate the form with the fetched data
                let data = res.data.rows;
                document.getElementById('UpdateLocationName').value = data.name;
                document.getElementById('UpdateSelectStatus').value = data.status;
                openModal(document.getElementById('editModal'));

            } catch (e) {
                unauthorized(e.response.status);
            }
        }

        // Update Brand Script
        async function Update() {
            try {
                let UpdateLocationName = document.getElementById('UpdateLocationName').value;
                let UpdateSelectStatus = document.getElementById('UpdateSelectStatus').value;
                let updateID = document.getElementById('updateID').value;

                // Validate required fields
                if (!UpdateLocationName || !UpdateSelectStatus) {
                    return errorToast('Please fill out all required fields.');
                }

                // Prepare form data
                let formData = new FormData();
                formData.append('name', UpdateLocationName);
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
                let res = await axios.post("/api/update-location", formData, config);
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
