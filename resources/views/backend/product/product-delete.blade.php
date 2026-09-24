<section class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="heading-wrap">
                <button type="button" class="close-btn close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <h2 class="heading">Delete Product</h2>
            </div>
            <form onsubmit="event.preventDefault(); return false;">
                <p>Are you sure you want to delete this product?</p>
                <input type="hidden" id="deleteID" />
                <div class="modal-buttons">
                    <button type="button" onclick="itemDelete(event)" class="confirmYes">Yes</button>
                    <button type="button" data-bs-dismiss="modal" class="confirmNo close">No</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    // Delete Product function
    async function itemDelete(event) {
        if (event && typeof event.preventDefault === 'function') {
            event.preventDefault();
        }
        try {
            let id = document.getElementById('deleteID').value;

            if (!id) {
                errorToast("Product ID is missing. Please try again.");
                return;
            }

            showLoader();

            let res = await axios.post(
                "/api/delete-product", {
                    id: id
                },
                HeaderToken()
            );

            hideLoader();

            if (res.data && res.data.status === "success") {
                successToast(res.data.message);
                $("#confirmationModal").modal('hide');

                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                errorToast(res.data ? res.data.message : "Failed to delete product.");
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            errorToast(e.response && e.response.data && e.response.data.message ? e.response.data.message : "An error occurred. Please try again.");
        }
    }
</script>
