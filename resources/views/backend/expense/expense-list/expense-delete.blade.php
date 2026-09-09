<!-- Expense Delete Confirmation Modal Start -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm sm:modal-md my-3" style="max-width: 440px;">
        <div class="modal-content bg-white dark:bg-slate-900 border-0 rounded-2xl shadow-2xl overflow-hidden transition-colors flex flex-col" style="border: none !important;">
            
            <!-- Sticky Top Header (Red) -->
            <div class="modal-header sticky top-0 z-20 px-4 sm:px-5 py-3.5 bg-rose-600 text-white flex items-center justify-between shadow-sm border-0 flex-shrink-0" style="background-color: #dc2626 !important; color: #ffffff !important; border: none !important;">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </div>
                    <h5 class="modal-title text-base font-bold text-white tracking-tight mb-0" id="confirmationModalLabel" style="color: #ffffff !important;">Delete Expense</h5>
                </div>
                <!-- Circular Red Close Button with White Icon -->
                <button type="button" class="custom-modal-close-btn d-flex align-items-center justify-content-center border-0 shadow-sm" data-bs-dismiss="modal" aria-label="Close" style="position: relative !important; top: auto !important; right: auto !important; width: 26px !important; height: 26px !important; min-width: 26px !important; min-height: 26px !important; border-radius: 50% !important; background-color: #991b1b !important; color: #ffffff !important; cursor: pointer !important; transition: all 0.2s ease; padding: 0 !important; margin: 0 !important; flex-shrink: 0 !important;" title="Close">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body p-5 sm:p-6 text-center">
                <div class="w-14 h-14 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto mb-3.5 border border-rose-100 dark:border-slate-800">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <h4 class="text-base sm:text-lg font-bold text-slate-800 dark:text-slate-100 mb-1.5">Confirm Deletion</h4>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mb-0">Are you sure you want to delete this expense record? This action cannot be undone.</p>
                <input type="hidden" id="deleteID" />
            </div>

            <!-- Sticky Bottom Footer (Strict 38px buttons) -->
            <div class="modal-footer sticky bottom-0 z-20 px-4 sm:px-5 py-3 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 flex items-center justify-end gap-2.5 flex-shrink-0">
                <button type="button" class="px-4 h-[38px] min-h-[38px] max-h-[38px] rounded-xl text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 unified-ui-border text-xs sm:text-sm font-semibold transition-all shadow-sm flex items-center justify-center cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" onclick="itemDelete()" class="px-5 h-[38px] min-h-[38px] max-h-[38px] rounded-xl text-white text-xs sm:text-sm font-semibold transition-all shadow-sm flex items-center justify-center cursor-pointer hover:bg-rose-700 active:scale-[0.98]" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important;">
                    Yes, Delete
                </button>
            </div>

        </div>
    </div>
</div>
<!-- Expense Delete Confirmation Modal End -->

<style>
    #confirmationModal .modal-dialog {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
    #confirmationModal .modal-content {
        border-radius: 16px !important;
        overflow: hidden !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
    }
    body[light-mode="dark"] #confirmationModal .modal-content,
    body[data-layout-mode="dark"] #confirmationModal .modal-content,
    html.dark #confirmationModal .modal-content,
    body.dark-mode #confirmationModal .modal-content,
    body.dark #confirmationModal .modal-content {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #confirmationModal .modal-footer,
    body[data-layout-mode="dark"] #confirmationModal .modal-footer,
    html.dark #confirmationModal .modal-footer,
    body.dark-mode #confirmationModal .modal-footer,
    body.dark #confirmationModal .modal-footer {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
</style>

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
            unauthorized(e.response ? e.response.status : 500);
        }
    }
</script>
