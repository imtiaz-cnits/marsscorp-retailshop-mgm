<!-- Create Product Modal Start -->
<section id="createProduct" class="financemodal">
<div class="modal-content">
    <a class="close-btn closes">
    <i class="fa-solid fa-xmark"></i>
    </a>
    <h2 class="heading">Add New District</h2>
    <div id="popup-modal">
    <form id="signup" onsubmit="return Save(event)">
        <div class="row">
            <div class="col">
                <div class="form-row">
                    <input type="text" placeholder="District Name *" id="DistrictName" required />
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
        let DistrictName = document.getElementById('DistrictName').value;
        let SelectStatus = document.getElementById('SelectStatus').value;

        // Validation
        if (DistrictName.length === 0) {
            errorToast("District Name Required !");
            return; // Exit the function if validation fails
        } else if (SelectStatus.length === 0) {
            errorToast("Status Required !");
            return;
        }
        else {
            // Creating form data for submission
            let formData = new FormData();
            formData.append('district_name', DistrictName);
            formData.append('status', SelectStatus);

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            // Sending the form data to the server
            let res = await axios.post("/api/create-district", formData, config);

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
