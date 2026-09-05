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
        <h2 class="heading">Expense Update</h2>
        <div id="popup-modal">
            <form>
                <div class="row">

                    <div class="col">
                        <div class="form-row">
                            <select class="status-select" id="UpdateInvestorInfoNameTypeID">
                                <option disabled selected>Select Investor Info</option>
                            </select>
                            <input class="d-none" id="updateID">

                        </div>
                        <div class="form-row">
                            <input type="text" placeholder="Invest Amount *" id="UpdateInvestAmount"  />
                        </div>
                        <div class="form-row">
                            <input type="text" class="form-control" placeholder="Invest Date *" id="UpdateInvestDate" onfocus="(this.type='date')" onblur="(this.type='text')">

                        </div>
                        <div class="form-row">
                            <textarea  class="input-style" placeholder="Invest Details *" id="UpdateInvestInfoDetails" class="input-style" rows="4" cols="50"></textarea>
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
    InvestorInfoTypeDataShow();

    async function InvestorInfoTypeDataShow() {
        try {
            let res = await axios.get("/api/investor-info-list", HeaderToken());
            let optionsHtml = res.data.InvestorInfoData.map(InvestorInfo => `<option value="${InvestorInfo.id}">${InvestorInfo.name}</option>`).join('');
            $("#UpdateInvestorInfoNameTypeID").html(`<option value="none" selected>Select Investor</option>` + optionsHtml);
        } catch (error) {
            console.error("Error fetching brands:", error);
        }
    }


    async function FillUpUpdateForm(id) {
            try {
                // Set the brand id in the hidden input
                document.getElementById('updateID').value = id;
                showLoader();

                // Fetch the brand data by ID
                let res = await axios.post("/api/invest-by-id", {
                    id: id.toString()
                }, HeaderToken());
                hideLoader();

                // Populate the form with the fetched data
                let data = res.data.rows;
                document.getElementById('UpdateInvestorInfoNameTypeID').value = data.investor_info_id;
            document.getElementById('UpdateInvestAmount').value = data.invest_amount;
            document.getElementById('UpdateInvestInfoDetails').value = data.invest_details;
            document.getElementById('UpdateInvestDate').value = data.date;

                openModal(document.getElementById('editModal'));

            } catch (e) {
                unauthorized(e.response.status);
            }
        }





        async function Update() {
            try {
                let UpdateInvestorInfoNameTypeID = document.getElementById('UpdateInvestorInfoNameTypeID').value;
                let UpdateInvestAmount = document.getElementById('UpdateInvestAmount').value;
                let UpdateInvestInfoDetails = document.getElementById('UpdateInvestInfoDetails').value;
                let UpdateInvestDate = document.getElementById('UpdateInvestDate').value;
                let updateID = document.getElementById('updateID').value;


                // Prepare form data
                let formData = new FormData();
                formData.append('investor_info_id', UpdateInvestorInfoNameTypeID);
                formData.append('invest_amount', UpdateInvestAmount);
                formData.append('invest_details', UpdateInvestInfoDetails);
                formData.append('date', UpdateInvestDate);
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
                let res = await axios.post("/api/update-invest", formData, config);
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
