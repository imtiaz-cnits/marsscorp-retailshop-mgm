<style>
    #confirmationModal {
        z-index: 1060 !important;
    }
    #confirmationModal .modal-dialog {
        max-width: 420px;
    }
    #confirmationModal .modal-content {
        border-radius: 16px;
        border: none;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    /* Dark Mode */
    body[light-mode="dark"] #confirmationModal .modal-content,
    html[light-mode="dark"] #confirmationModal .modal-content,
    body[data-layout-mode="dark"] #confirmationModal .modal-content,
    html.dark #confirmationModal .modal-content,
    body.dark #confirmationModal .modal-content,
    body.dark-mode #confirmationModal .modal-content {
        background-color: #0f172a !important;
        color: #ffffff !important;
    }
</style>

<section class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4 text-center">
            <div class="modal-header border-0 justify-content-center pb-0">
                <div class="w-14 h-14 rounded-2xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center mb-2 border border-rose-100 dark:border-rose-900/40 shadow-sm mx-auto">
                    <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                </div>
            </div>
            <div class="modal-body py-2">
                <h5 class="font-bold text-slate-800 dark:text-white text-lg mb-2">Delete Purchase?</h5>
                <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm mb-0">Are you sure you want to delete this purchase record? Associated order items and payment details will be permanently removed.</p>
                <input type="hidden" id="deleteID" />
            </div>
            <div class="modal-footer border-0 justify-content-center gap-2 pt-3">
                <button type="button" class="px-4 h-[38px] rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 transition-colors border-0" data-bs-dismiss="modal">Cancel</button>
                <button type="button" onclick="itemDelete()" class="inline-flex items-center gap-1.5 px-5 h-[38px] bg-rose-600 hover:bg-rose-700 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-150 border-0">
                    <i class="fa-solid fa-trash text-xs"></i>
                    <span>Yes, Delete</span>
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
                errorToast("Purchase ID is missing. Please try again.");
                return;
            }

            showLoader();

            let res = await axios.post(
                "/api/delete-purchases", {
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
                errorToast(res.data ? res.data.message : "Failed to delete purchase.");
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            errorToast("An error occurred. Please try again.");
        }
    }
</script>
