<style>
    #editModal .modal-content {
        width: 30%;
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
        <h2 class="heading">Upazila Update</h2>
        <div id="popup-modal">
            <form>
                <div class="row">

                    <div class="col">
                        <div class="form-row">
                            <select class="status-select" id="UpdateDistrictTypeInfoID">
                                <option disabled selected>Select District Type</option>
                            </select>
                            <input class="d-none" id="updateID">

                        </div>
                        <div class="form-row">
                            <input type="text" placeholder="Upazila Name *" id="UpdateUpazilaName"  />
                        </div>
                            <div class="form-row">
                                <select class="status-select" id="UpazilaUpdateSelectStatus">
                                    <option disabled selected>Select Upazila Status</option>
                                    <option value="Active">Active</option>
                                    <option value="InActive">Inactive</option>
                                </select>
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
    // Fetch Brand, Category, Unit, Supplier
    DistrictTypeDataShow();

    async function DistrictTypeDataShow() {
        try {
            let res = await axios.get("/api/district-list", HeaderToken());
            let optionsHtml = res.data.DistrictData.map(District => `<option value="${District.id}">${District.district_name}</option>`).join('');
            $("#UpdateDistrictTypeInfoID").html(`<option value="none" selected>Select District</option>` + optionsHtml);
        } catch (error) {
            console.error("Error fetching brands:", error);
        }
    }



    // Function to fill the form when editing
    async function FillUpUpdateForm(id) {
            try {
                // Set the brand id in the hidden input
                document.getElementById('updateID').value = id;
                showLoader();

                // Fetch the brand data by ID
                let res = await axios.post("/api/upazila-by-id", {
                    id: id.toString()
                }, HeaderToken());
                hideLoader();

                // Populate the form with the fetched data
                let data = res.data.rows;
                document.getElementById('UpdateDistrictTypeInfoID').value = data.district_id;
                document.getElementById('UpdateUpazilaName').value = data.upazila_name;
                document.getElementById('UpazilaUpdateSelectStatus').value = data.status;
                openModal(document.getElementById('editModal'));

            } catch (e) {
                unauthorized(e.response.status);
            }
        }


    // Update Product
    async function Update() {
        try {
            let formData = new FormData();
            formData.append('district_id', $('#UpdateDistrictTypeInfoID').val());
            formData.append('upazila_name', $('#UpdateUpazilaName').val());
            formData.append('status', $('#UpazilaUpdateSelectStatus').val());
            formData.append('id', $('#updateID').val());

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            showLoader();
            let res = await axios.post("/api/update-upazila", formData, config);
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message);
                closeModal(document.getElementById('editModal'));
                await getList(); // Refresh product list
            } else {
                errorToast(res.data.message);
            }
        } catch (e) {
            console.error("Error:", e.response);
        }
    }
</script>
