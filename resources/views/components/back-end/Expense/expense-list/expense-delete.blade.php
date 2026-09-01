<style>
    #confirmationModal {
        z-index: 1060 !important;
    }
    #confirmationModal .modal-dialog {
        max-width: 440px;
    }
    #confirmationModal .modal-content {
        border-radius: 14px;
        border: none;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }
</style>

<section class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 text-center">
            <div class="modal-header border-0 justify-content-center pb-0">
                <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center mb-2" style="width: 56px; height: 56px;">
                    <i class="fa-solid fa-triangle-exclamation fs-3"></i>
                </div>
            </div>
            <div class="modal-body py-2">
                <h5 class="fw-bold text-dark mb-2">Delete Expense?</h5>
                <p class="text-secondary small mb-0">Are you sure you want to delete this expense record? This action cannot be undone.</p>
                <input type="hidden" id="deleteID" />
            </div>
            <div class="modal-footer border-0 justify-content-center gap-2 pt-2">
                <button type="button" class="btn btn-light px-4 py-2 fw-bold text-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                <button type="button" onclick="itemDelete()" class="btn btn-danger px-4 py-2 fw-bold" style="border-radius: 8px;">
                    <i class="fa-solid fa-trash me-1"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('#confirmationModal').appendTo("body");
    });

    async function itemDelete() {
        try {
            let id = document.getElementById('deleteID').value;

            if (!id) {
                errorToast("Expense ID is missing. Please try again.");
                return;
            }

            showLoader();

            let res = await axios.post(
                "/api/delete-expense", {
                    id: id
                },
                HeaderToken()
            );

            hideLoader();

            if (res.data && res.data.status === "success") {
                successToast(res.data.message);
                $("#confirmationModal").modal('hide');

                if (typeof getExpenseList === 'function') {
                    await getExpenseList();
                } else {
                    setTimeout(() => location.reload(), 500);
                }
            } else {
                errorToast(res.data ? res.data.message : "Failed to delete expense.");
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            errorToast("An error occurred. Please try again.");
        }
    }
</script>
