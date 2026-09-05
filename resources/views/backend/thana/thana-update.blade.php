<style>
    #editModal .modal-content {
        width: 40%;
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
        <h2 class="heading">Thana Update</h2>
        <div id="popup-modal">
            <form>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-row">
                            <select class="status-select" id="UpdateDistrictTypeInfoID">
                                <option disabled selected>Select District</option>
                            </select>
                            <input class="d-none" id="updateID">

                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-row">
                            <select class="status-select" id="UpdateUpazilaTypeInfoID">
                                <option disabled selected>Select Upazila</option>
                            </select>
                        </div>
                    </div>

                        <div class="form-row">
                            <input type="text" placeholder="Thana Name *" id="UpdateThanaName"  />
                        </div>
                            <div class="form-row">
                                <select class="status-select" id="ThanaUpdateSelectStatus">
                                    <option disabled selected>Select UpazThana Status</option>
                                    <option value="Active">Active</option>
                                    <option value="InActive">Inactive</option>
                                </select>
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
    DistrictTypeData();
    UpdateUpazilaTypeData();

    async function DistrictTypeData() {
        try {
            let res = await axios.get("/api/district-list", HeaderToken());
            let optionsHtml = res.data.DistrictData.map(District => `<option value="${District.id}">${District.district_name}</option>`).join('');
            $("#UpdateDistrictTypeInfoID").html(`<option value="none" selected>Select District</option>` + optionsHtml);
        } catch (error) {
            console.error("Error fetching brands:", error);
        }
    }

    async function UpdateUpazilaTypeData() {
        try {
            let res = await axios.get("/api/upazila-list", HeaderToken());
            let optionsHtml = res.data.UpazilasData.map(Upazila => `<option value="${Upazila.id}">${Upazila.upazila_name}</option>`).join('');
            $("#UpdateUpazilaTypeInfoID").html(`<option value="none" selected>Select Upazila</option>` + optionsHtml);
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
                let res = await axios.post("/api/thana-by-id", {
                    id: id.toString()
                }, HeaderToken());
                hideLoader();

                // Populate the form with the fetched data
                let data = res.data.rows;
                document.getElementById('UpdateDistrictTypeInfoID').value = data.district_id;
                document.getElementById('UpdateUpazilaTypeInfoID').value = data.upazila_id;
                document.getElementById('UpdateThanaName').value = data.Thana_name;
                document.getElementById('ThanaUpdateSelectStatus').value = data.status;
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
            formData.append('upazila_id', $('#UpdateUpazilaTypeInfoID').val());
            formData.append('Thana_name', $('#UpdateThanaName').val());
            formData.append('status', $('#ThanaUpdateSelectStatus').val());
            formData.append('id', $('#updateID').val());

            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            showLoader();
            let res = await axios.post("/api/update-thana", formData, config);
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
