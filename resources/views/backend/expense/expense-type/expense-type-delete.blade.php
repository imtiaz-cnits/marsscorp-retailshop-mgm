<!-- Expense Type Delete Confirmation Modal Start -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
            <div class="d-flex justify-content-center mb-3">
                <div class="rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-500 border border-rose-200 dark:border-rose-900/60 p-3.5 flex items-center justify-center shadow-sm">
                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
            </div>
            
            <h5 class="font-bold text-slate-800 dark:text-slate-100 text-lg mb-1">Delete Expense Type?</h5>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm mb-4">Are you sure you want to delete this expense type? This action cannot be undone.</p>
            <input type="hidden" id="deleteID" />
            
            <div class="flex items-center justify-center gap-2.5">
                <button type="button" data-bs-dismiss="modal" class="px-4 h-[38px] min-h-[38px] max-h-[38px] rounded-xl font-semibold text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-sm transition-all shadow-sm">
                    Cancel
                </button>
                <button type="button" onclick="itemDelete()" class="px-5 h-[38px] min-h-[38px] max-h-[38px] rounded-xl font-semibold text-white bg-rose-600 hover:bg-rose-700 active:scale-[0.98] text-sm transition-all shadow-sm">
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Expense Type Delete Confirmation Modal End -->

<style>
    #confirmationModal .modal-dialog {
        max-width: 420px !important;
        margin: 1.75rem auto !important;
    }
    #confirmationModal .modal-content {
        border-radius: 16px !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        background-color: #ffffff !important;
    }
    body[light-mode="dark"] #confirmationModal .modal-content,
    body[data-layout-mode="dark"] #confirmationModal .modal-content,
    html.dark #confirmationModal .modal-content,
    body.dark-mode #confirmationModal .modal-content,
    body.dark #confirmationModal .modal-content {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
</style>

<script>
    async function itemDelete() {
        try {
            let id = document.getElementById('deleteID').value;
            if (!id) {
                errorToast("Expense Type ID is missing.");
                return;
            }

            showLoader();
            let res = await axios.post("/api/delete-expense-type", { id: id }, HeaderToken());
            hideLoader();

            if (res.data && res.data.status === "success") {
                successToast(res.data.message);
                $("#confirmationModal").modal('hide');
                if (typeof getList === 'function') {
                    await getList();
                } else {
                    setTimeout(() => location.reload(), 500);
                }
            } else {
                errorToast(res.data ? res.data.message : "Failed to delete expense type.");
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }
</script>
