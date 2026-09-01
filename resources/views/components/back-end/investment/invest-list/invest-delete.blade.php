 <!-- Confirmation Modal Start -->
 <div id="confirmationModal" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to delete this item?</p>
        <input class="d-none" id="deleteID" />
        <div class="modal-buttons">
            <button onclick="itemDelete()" id="confirmYes">Yes</button>
            <button id="confirmNo">No</button>
        </div>
    </div>
</div>
<!-- Confirmation Modal End -->


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
                "/api/delete-invest", {
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
