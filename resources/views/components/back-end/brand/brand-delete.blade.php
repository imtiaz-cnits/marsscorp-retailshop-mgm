<!-- Brand Delete Confirmation Modal Start -->
<div class="modal fade" id="brandDeleteModal" tabindex="-1" aria-labelledby="brandDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 shadow-lg text-center p-4" style="border-radius: 16px;">
            <div class="text-danger mb-3">
                <i class="fa-solid fa-triangle-exclamation" style="font-size: 48px;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Are you sure?</h5>
            <p class="text-muted small mb-4">আপনি কি নিশ্চিতভাবে এই ব্র্যান্ডটি ডিলিট করতে চান? এই একশন ফিরিয়ে নেওয়া যাবে না।</p>
            <input type="hidden" id="deleteBrandID" />
            <div class="d-flex align-items-center justify-content-center gap-2">
                <button type="button" class="btn btn-secondary px-4 py-2 fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                <button type="button" onclick="BrandItemDelete()" class="btn btn-danger px-4 py-2 fw-bold" style="border-radius: 8px;">
                    <i class="fa-solid fa-trash me-1"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Brand Delete Confirmation Modal End -->

<script>
    async function BrandItemDelete() {
        try {
            let id = document.getElementById('deleteBrandID').value;
            if (!id) {
                errorToast("Brand ID is missing.");
                return;
            }

            showLoader();
            let res = await axios.post("/api/delete-brand", { id: id }, HeaderToken());
            hideLoader();

            if (res.data && res.data.status === "success") {
                successToast(res.data.message || "Brand deleted successfully");
                $("#brandDeleteModal").modal('hide');

                if (typeof getList === 'function') {
                    await getList();
                } else {
                    location.reload();
                }
            } else {
                errorToast(res.data ? res.data.message : "Failed to delete brand.");
            }
        } catch (e) {
            hideLoader();
            console.error("Brand Delete Error:", e);
            errorToast("An error occurred while deleting.");
        }
    }
</script>
