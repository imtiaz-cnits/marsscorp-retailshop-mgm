<!-- Create Product Modal Start -->
<section id="createProduct" class="financemodal">
    <div class="modal-content">
        <a class="close-btn closes">
            <i class="fa-solid fa-xmark"></i>
        </a>
        <h2 class="heading">Add New Category</h2>
        <div id="popup-modal">
            <form id="signup" onsubmit="return Save(event)">
                <div class="row">
                    <div class="col">
                        <div class="mb-2">
                            <div class="upload-profile">
                                <div class="item">
                                    <div class="img-box">
                                        <img src="{{asset('back-end/assets/icons/upload-img.svg')}}" alt="">
                                    </div>
                                    <div class="profile-wrapper">
                                        <label class="custom-file-input-wrapper">
                                            <input type="file" id="CategoryImg" class="custom-file-input"
                                                aria-label="Upload Photo" />
                                        </label>
                                        <p>PNG, JPEG, or GIF (up to 1 MB)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-row">
                            <input type="text" placeholder="Category Name *" id="CategoryName" required />
                        </div>
                        <div class="form-row">
                            <label class="country">
                                <select name="status" id="SelectStatus" required>
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="InActive">Inactive</option>
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="actions">
                    <button type="submit" class="btn-save">Submit</button>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Create Product Modal End -->


<script>
    document.getElementById('CategoryImg').addEventListener('change', function(event) {
        const imgFile = event.target.files[0];
        const imgPreview = document.getElementById('imagePreview');

        if (imgFile) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result; // Set the image source to the file data
                imgPreview.style.display = 'block'; // Show the image preview
            }
            reader.readAsDataURL(imgFile); // Read the file as a data URL
        } else {
            imgPreview.src = ""; // Clear the preview if no file is selected
            imgPreview.style.display = 'none'; // Hide the preview
        }
    });





    // Function to close the modal
    // function closeModal() {
    //     const modal = document.getElementById('myModal');
    //     modal.style.display = 'none'; // Hide the modal
    // }

    async function Save(event) {
        event.preventDefault(); // Stop form from submitting and reloading the page
        try {
            let CategoryName = document.getElementById('CategoryName').value;
            let SelectStatus = document.getElementById('SelectStatus').value;

            let imgInput = document.getElementById('CategoryImg');
            let imgFile = imgInput.files[0];

            if (CategoryName.length === 0) {
                errorToast("Category Name Required!");
                return false;
            } else if (SelectStatus === '' || SelectStatus === 'Select Status') {
                errorToast("Status Required!");
                return false;
            } else {
                let formData = new FormData();
                formData.append('category_name', CategoryName);
                formData.append('status', SelectStatus);
                formData.append('img_url', imgFile); // Append image file

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data',
                        ...HeaderToken().headers
                    }
                };

                let res = await axios.post("/api/create-category", formData, config);

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
}




    function closeModal(modal) {
    modal.style.display = 'none';
}


</script>
