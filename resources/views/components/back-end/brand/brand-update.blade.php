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
             <div class="col-12">
               <div class="mb-2">
                 <div class="upload-profile">
                   <div class="item">
                     <div class="img-box">
                       <svg
                         width="32"
                         height="32"
                         viewBox="0 0 50 50"
                         fill="red"
                         xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink"
                       >
                         <rect
                           width="50"
                           height="50"
                           fill="url(#pattern0_1204_6)"
                           fill-opacity="0.5"
                         />
                         <defs>
                           <pattern
                             id="pattern0_1204_6"
                             patternContentUnits="objectBoundingBox"
                             width="1"
                             height="1"
                           >
                             <use
                               xlink:href="#image0_1204_6"
                               transform="scale(0.005)"
                             />
                           </pattern>
                           <image
                             id="image0_1204_6"
                             width="200"
                             height="200"
                             xlink:href="data:image/png;base64,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"
                           />
                         </defs>
                       </svg>
                     </div>

                     <div class="profile-wrapper">
                       <label class="custom-file-input-wrapper">
                         <input
                           type="file"
                           id="UpdateBrandImage"
                           class="custom-file-input"
                           aria-label="Upload Photo"
                         />
                       </label>
                       <p>PNG,JPEG or GIF (up to 1 MB)</p>
                     </div>
                   </div>
                 </div>
               </div>

               <div class="form-row col-12">
                 <label for="">Brand Name *</label>
                 <input
                   type="text"
                   placeholder="Brand Name"
                   id="UpdateBrandName"
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
        async function updatePreview(input, imageUrl) {
            const oldImg = document.getElementById('oldImg');

            if (input.files && input.files[0]) {
                oldImg.src = window.URL.createObjectURL(input.files[0]);
            } else if (imageUrl) {
                oldImg.src = imageUrl;
            } else {
                oldImg.src = "{{ asset('images/default.jpg') }}";
            }
        }

        // Function to fill the form when editing
        async function FillUpUpdateForm(id) {
            try {
                // Set the brand id in the hidden input
                document.getElementById('updateID').value = id;
                showLoader();

                // Fetch the brand data by ID
                let res = await axios.post("/api/brand-by-id", {
                    id: id.toString()
                }, HeaderToken());
                hideLoader();

                // Populate the form with the fetched data
                let data = res.data.rows;
                document.getElementById('UpdateBrandName').value = data.name;
                document.getElementById('UpdateSelectStatus').value = data.status;
                updatePreview(document.getElementById('UpdateBrandImage'), data.logo);
                openModal(document.getElementById('editModal'));

            } catch (e) {
                unauthorized(e.response.status);
            }
        }

        // Update Brand Script
        async function Update() {
            try {
                let UpdateBrandName = document.getElementById('UpdateBrandName').value;
                let UpdateBrandImage = document.getElementById('UpdateBrandImage').files[0];
                let UpdateBrandStatus = document.getElementById('UpdateSelectStatus').value;
                let updateID = document.getElementById('updateID').value;

                // Validate required fields
                if (!UpdateBrandName || !UpdateBrandStatus) {
                    return errorToast('Please fill out all required fields.');
                }

                // Prepare form data
                let formData = new FormData();
                formData.append('name', UpdateBrandName);
                formData.append('status', UpdateBrandStatus);

                // Append the image if it exists
                if (UpdateBrandImage) {
                    formData.append('img', UpdateBrandImage);
                }
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
                let res = await axios.post("/api/update-brand", formData, config);
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
