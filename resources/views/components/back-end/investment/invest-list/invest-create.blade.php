<style>

    #addBrandModal .newbrand-content .row .col-lg-6,
    #addBrandModal .newbrand-content .row .col-lg-4 {
        padding: 0px 6px !important
    }


</style>

<!-- Create Product Modal Start -->
<section id="createProduct" class="financemodal">
            <div class="modal-content">
                <a class="close-btn closes">
                    <i class="fa-solid fa-xmark"></i>
                </a>
                <h2 class="heading">Create Invest</h2>
                <div id="popup-modal">
                    <form id="expenseForm" onsubmit="return Save(event)">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-row">
                                    <select class="form-select input-style" id="InvestorInfoNameType"
                                        aria-label="Default select example">
                                        <option value="none">Select investor</option>
                                    </select>
                                    <button type="button" class="btn-add newbrand-open">
                                        + Add Investor
                                    </button>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-row">
                                    <input type="text" placeholder="Invest Amount *" id="InvestAmount" required />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-row">
                                    <input type="text" class="form-control" placeholder="Invest Date *"
                                    id="InvestDate" onfocus="(this.type='date')" onblur="(this.type='text')">

                                </div>
                                <div class="form-row">
                                    <textarea class="input-style" id="InvestInfoDetails" placeholder="Invest Details *" rows="4" cols="50"></textarea>
                                </div>
                            </div>

                            <div class="actions">
                                <button onclick="InvestDataSave(event)" class="btn-save">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Create Product Modal End -->

        <!-- Add Product modal to Add New Brand Modal Start -->
        <div class="newbrand" id="addBrandModal">
            <div class="newbrand-content">
                <h2>Create Investor Info</h2>
                <form>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="text" placeholder="Enter Your Name" id="InvestorName" required />
                            </div>

                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="text" placeholder="Enter Your Number" id="InvestoNumber" required />
                            </div>


                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="text" placeholder="Enter Your Email" id="InvestorEmail" required />
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" placeholder="Enter Your Address" id="InvestorAddress" required />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="dropdown-wrapper">
                                    <select class="status-select" id="SelectStatus">
                                        <option disabled selected>Select expense status</option>
                                        <option value="Active">Active</option>
                                        <option value="InActive">Inactive</option>
                                    </select>
                                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                                </div>
                            </div>

                        </div>

                    </div>



                    <div class="button-group">
                        <button type="button" class="cancel-btn newbrand-close">
                            Cancel
                        </button>
                        <button onclick="saveExpenseType(event)" class="save-btn">Save Investor</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add Product modal to New Brand Modal End -->


<script>
    // Save brand function
    async function saveExpenseType(event) {
        event.preventDefault();

        try {
            const InvestorName = document.getElementById('InvestorName').value;
            const InvestoNumber = document.getElementById('InvestoNumber').value;
            const InvestorAddress = document.getElementById('InvestorAddress').value;
            const InvestorEmail = document.getElementById('InvestorEmail').value;
            const SelectStatus = document.getElementById('SelectStatus').value;

            // Validation
            if (!InvestorName) {
                errorToast("Investor Name is required!");
                return;
            }
            if (!InvestoNumber) {
                errorToast("Investo Number is required!");
                return;
            }
            if (!InvestorAddress) {
                errorToast("Investor Address is required!");
                return;
            }
            if (!SelectStatus) {
                errorToast("Select Status is required!");
                return;
            }

            // Prepare form data
            const formData = new FormData();
            formData.append('name', InvestorName);
            formData.append('mobile', InvestoNumber);
            formData.append('address', InvestorAddress);
            formData.append('email', InvestorEmail);
            formData.append('status', SelectStatus);

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    ...HeaderToken().headers,
                },
            };

            // API call to save Investor
            const res = await axios.post("/api/create-investor-info", formData, config);

            if (res.data.status === "success") {
                successToast(res.data.message);

                // Clear the form and close the modal
                document.getElementById('InvestorName').value = '';
                document.getElementById('InvestoNumber').value = '';
                document.getElementById('InvestorAddress').value = '';
                document.getElementById('InvestorEmail').value = '';
                document.getElementById('SelectStatus').value = '';
                closeBrandModal();

                // Refresh the dropdown and select the newly created expense type
                await refreshInvestList(res.data.newExpenseId);
            } else {
                errorToast(res.data.message);
            }
        } catch (e) {
            unauthorized(e.response?.status || 500);
        }
    }


    // Refresh expense list and optionally select the newly added expense type
    async function refreshInvestList(selectInvestorId = null) {
        try {
            const response = await axios.get('/api/investor-info-list', HeaderToken());
            const InvestorInfo = response.data.InvestorInfoData;

            // Build the options for the dropdown
            let optionsHtml = '<option value="none" selected>Select Investor</option>';
            optionsHtml += InvestorInfo
                .map((InvestorInfo) =>
                    `<option value="${InvestorInfo.id}" ${selectInvestorId === InvestorInfo.id ? 'selected' : ''}>${InvestorInfo.name}</option>`
                    )
                .join('');

            // Populate the dropdown
            document.getElementById('InvestorInfoNameType').innerHTML = optionsHtml;
        } catch (error) {
            console.error("Error occurred while fetching Invest Info:", error);
        }
    }

    // Modal handling (open/close)
    function closeBrandModal() {
        document.getElementById('addBrandModal').style.display = 'none';
    }

    function openBrandModal() {
        document.getElementById('addBrandModal').style.display = 'block';
    }

    // Trigger modal open/close
    document.querySelector('.newbrand-open').addEventListener('click', openBrandModal);
    document.querySelector('.newbrand-close').addEventListener('click', closeBrandModal);

    // Initial brand list fetch
    refreshInvestList();



    async function InvestDataSave (event) {
        event.preventDefault(); // Prevent form submission and page reload
        try {
            let InvestorInfoNameType = document.getElementById('InvestorInfoNameType').value;
           let InvestAmount = document.getElementById('InvestAmount').value;
           let InvestDate = document.getElementById('InvestDate').value;
           let InvestInfoDetails = document.getElementById('InvestInfoDetails').value;

           if (InvestorInfoNameType.length === 0) {
               errorToast("Investor Info Name Required!");
               return false;
           }
           else if (InvestAmount.length === 0) {
               errorToast("Invest Amount Required!");
               return false;
           }
           else if (InvestDate.length === 0) {
               errorToast("Invest Date Required!");
               return false;
           }

            else {
               let formData = new FormData();
               formData.append('investor_info_id', InvestorInfoNameType);
               formData.append('invest_amount', InvestAmount);
               formData.append('invest_details', InvestInfoDetails);
               formData.append('date', InvestDate);

               const config = {
                   headers: {
                       'content-type': 'multipart/form-data',
                       ...HeaderToken().headers
                   }
               };

               let res = await axios.post("/api/create-invest", formData, config);

                if (res.data['status'] === "success") {
                    successToast(res.data['message']);
                    document.getElementById("expenseForm").reset();
                    closeModal(document.getElementById('myModal'));
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

