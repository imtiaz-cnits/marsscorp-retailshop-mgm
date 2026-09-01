<style>
    #confirmationModal {
        z-index: 1060 !important;
    }
</style>

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
            <form action="" onsubmit="return false;">
                <p>Are you sure you want to delete this item?</p>
                <input type="hidden" id="deleteID" />
                <div class="modal-buttons">
                    <button type="button" onclick="itemDelete()" class="confirmYes">Yes</button>
                    <button type="button" class="confirmNo close" data-bs-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('#confirmationModal').appendTo("body");
    });
    // Delete Supplier function
    async function itemDelete() {
        try {
            let id = document.getElementById('deleteID').value;

            if (!id) {
                errorToast("Supplier ID is missing. Please try again.");
                return;
            }

            showLoader();

            let res = await axios.post(
                "/api/delete-supplier", {
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
                errorToast(res.data ? res.data.message : "Failed to delete supplier.");
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            errorToast("An error occurred. Please try again.");
        }
    }
</script>
