<section class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="heading-wrap">
                <button type="button" class="close-btn close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <h2 class="heading">Edit</h2>
            </div>
            <form action="">
                <p>Are you sure you want to delete this item?</p>
                <input type="hidden" id="deleteID" />
                <div class="modal-buttons">
                    <button onclick="itemDelete()" class="confirmYes">Yes</button>
                    <button class="confirmNo close">No</button>
                </div>
            </form>
        </div>
    </div>
</section>


<script>
    // Delete Brand function
    async function itemDelete() {
        try {
            let id = document.getElementById('deleteID').value; // Get ID from hidden input

            if (!id) {
                errorToast("Brand ID is missing. Please try again.");
                return;
            }

            showLoader();

            // Make the request to delete the Brand
            let res = await axios.post(
                "/api/delete-product", {
                    id: id
                }, // Pass ID in the payload
                HeaderToken()
            );

            hideLoader();

            if (res.data && res.data.status === "success") {
                successToast(res.data.message); // Show success message
                $("#confirmationModal").modal('hide'); // Close the delete modal

                setTimeout(() => {
                    location.reload(); // Reload the page after the modal closes
                }, 500); // Add a small delay for smooth UI experience
            } else {
                errorToast(res.data ? res.data.message : "Failed to delete brand.");
            }
        } catch (e) {
            hideLoader();
            console.error(e); // Log the error
            errorToast("An error occurred. Please try again.");
        }
    }
</script>
