<!-- Create Product Modal Start -->
<section id="createProduct" class="financemodal">
    <div class="modal-content">
      <a class="close-btn closes">
        <i class="fa-solid fa-xmark"></i>
      </a>
      <h2 class="heading">Add New Brand</h2>
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
                                        <input type="file" id="BrandImg" class="custom-file-input" aria-label="Upload Photo" />
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
                        <input type="text" placeholder="Brand Name *" id="BrandName" required />
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
    async function Save(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    try {
        let BrandName = document.getElementById('BrandName').value;
        let SelectStatus = document.getElementById('SelectStatus').value;

        let imgInput = document.getElementById('BrandImg');
        let imgFile = imgInput.files[0];

        // Validation
        if (BrandName.length === 0) {
            errorToast("Brand Name Required !");
            return; // Exit the function if validation fails
        } else if (SelectStatus.length === 0) {
            errorToast("Status Required !");
            return;
        }
        else {
            // Creating form data for submission
            let formData = new FormData();
            formData.append('name', BrandName);
            formData.append('status', SelectStatus);
            formData.append('img_url', imgFile); // Append image file

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            // Sending the form data to the server
            let res = await axios.post("/api/create-brand", formData, config);

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
