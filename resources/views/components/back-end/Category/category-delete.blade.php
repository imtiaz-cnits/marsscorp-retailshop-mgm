<!-- Category Delete Confirmation Modal Start -->
<div class="modal fade" id="categoryDeleteModal" tabindex="-1" aria-labelledby="categoryDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 shadow-lg text-center p-4" style="border-radius: 16px;">
            <div class="text-danger mb-3">
                <i class="fa-solid fa-triangle-exclamation" style="font-size: 48px;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Are you sure?</h5>
            <p class="text-muted small mb-4">আপনি কি নিশ্চিতভাবে এই ক্যাটাগরিটি ডিলিট করতে চান? এই একশন ফিরিয়ে নেওয়া যাবে না।</p>
            <input type="hidden" id="deleteCategoryID" />
            <div class="d-flex align-items-center justify-content-center gap-2">
                <button type="button" class="btn btn-secondary px-4 py-2 fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                <button type="button" onclick="CategoryItemDelete()" class="btn btn-danger px-4 py-2 fw-bold" style="border-radius: 8px;">
                    <i class="fa-solid fa-trash me-1"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Category Delete Confirmation Modal End -->

<script>
    async function CategoryItemDelete() {
        try {
            let id = document.getElementById('deleteCategoryID').value;
            if (!id) {
                errorToast("Category ID is missing.");
                return;
            }

            showLoader();
            let res = await axios.post("/api/delete-category", { id: id }, HeaderToken());
            hideLoader();

            if (res.data && res.data.status === "success") {
                successToast(res.data.message || "Category deleted successfully");
                $("#categoryDeleteModal").modal('hide');

                if (typeof getList === 'function') {
                    await getList();
                } else {
                    location.reload();
                }
            } else {
                errorToast(res.data ? res.data.message : "Failed to delete category.");
            }
        } catch (e) {
            hideLoader();
            console.error("Category Delete Error:", e);
            errorToast("An error occurred while deleting.");
        }
    }
</script>
