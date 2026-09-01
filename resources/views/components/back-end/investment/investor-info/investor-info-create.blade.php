<style>
    #createProduct .modal-content {
        width: 50%;
        margin: 0;
    }
    #createProduct .modal-content .row .col-lg-4 {
        padding: 0px 6px !important
    }

    @media screen and (max-width: 992px) {
        #createProduct .modal-content {
            width: 90%;
            margin: 0px;
        }
    }
</style>

<!-- Create Product Modal Start -->
<section id="createProduct" class="financemodal">
<div class="modal-content">
    <a class="close-btn closes">
    <i class="fa-solid fa-xmark"></i>
    </a>
    <h2 class="heading">Create Investor Info</h2>
    <div id="popup-modal">
    <form id="signup" onsubmit="return Save(event)">
        <div class="row">
            <div class="col-lg-4">
                <div class="form-row">
                    <input type="text" placeholder="Enter Your Name" id="InvestorName" required />
                </div>

            </div>
            <div class="col-lg-4">
                <div class="form-row">
                    <input type="text" placeholder="Enter Your Number" id="InvestoNumber" required />
                </div>

            </div>
            <div class="col-lg-4">
                <div class="form-row">
                    <input type="text" placeholder="Enter Your Email" id="InvestorEmail" required />
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-row">
                    <input type="text" placeholder="Enter Your Address" id="InvestorAddress" required />
                </div>

            </div>
            <div class="col-lg-6">
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
            <div class="col-lg-4">

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

    try{
        let InvestorName = document.getElementById('InvestorName').value;
            let InvestoNumber = document.getElementById('InvestoNumber').value;
            let InvestorAddress = document.getElementById('InvestorAddress').value;
            let InvestorEmail = document.getElementById('InvestorEmail').value;
            let SelectStatus = document.getElementById('SelectStatus').value;


            if (InvestorName.length === 0) {
                errorToast("Investo Name Required!");
                return false;
            }

           else if (InvestoNumber.length === 0) {
                errorToast("Investo Number Required!");
                return false;
            }

           else if (InvestorAddress.length === 0) {
                errorToast("Investo Address Required!");
                return false;
            }

            else if (SelectStatus === '' || SelectStatus === 'Select Status') {
                errorToast("Status Required!");
                return false;
            } else {
                let formData = new FormData();
                formData.append('name', InvestorName);
                formData.append('mobile', InvestoNumber);
                formData.append('address', InvestorAddress);
                formData.append('email', InvestorEmail);
                formData.append('status', SelectStatus);

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data',
                        ...HeaderToken().headers
                    }
                };


                let res = await axios.post("/api/create-investor-info", formData, config);

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
