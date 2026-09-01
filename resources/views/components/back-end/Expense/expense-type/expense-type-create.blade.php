<style>
    #createProduct .modal-content {
        width: 30%;
        margin: 0;
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
      <h2 class="heading">Create Expense Type</h2>
      <div id="popup-modal">
        <form id="signup" onsubmit="return Save(event)">
            <div class="row">
                <div class="col">
                    <div class="form-row">
                        <input type="text" placeholder="Enter your Type name" id="ExpenseTypeName" required />
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
        let ExpenseTypeName = document.getElementById('ExpenseTypeName').value;
            let SelectStatus = document.getElementById('SelectStatus').value;


            if (ExpenseTypeName.length === 0) {
                errorToast("Expense Type Name Required!");
                return false;
            } else if (SelectStatus === '' || SelectStatus === 'Select Status') {
                errorToast("Status Required!");
                return false;
            } else {
                let formData = new FormData();
                formData.append('type_name', ExpenseTypeName);
                formData.append('status', SelectStatus);

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data',
                        ...HeaderToken().headers
                    }
                };


            // Sending the form data to the server
            let res = await axios.post("/api/create-expense-type", formData, config);

            if (res.data['status'] === "success") {
                successToast(res.data['message']);
                document.getElementById("signup").reset(); // Reset the form
                const modal = document.getElementById('myModal');
                closeModal(modal); // Close the modal smoothly
                setTimeout(() => {
                    location.reload(); // Reload the page after closing the modal
                }, 500); // Add a small delay to ensure modal closes smoothly
            } else {
                errorToast(res.data['message']);
            }
        }
    } catch (e) {
        unauthorized(e.response.status); // Handle authorization issues
    }
}

// Function to close the modal smoothly
function closeModal(modal) {
    modal.style.display = 'none'; // Hide the modal
}

</script>
