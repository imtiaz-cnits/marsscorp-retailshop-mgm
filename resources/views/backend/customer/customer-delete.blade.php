<!-- Delete Confirmation Modal Start -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm sm:modal-md my-3" style="max-width: 440px;">
        <div class="modal-content bg-white dark:bg-slate-900 border-0 rounded-2xl shadow-2xl overflow-hidden transition-colors flex flex-col" style="border: none !important;">
            
            <!-- Sticky Top Header -->
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
                    <h5 class="modal-title text-base font-bold text-white tracking-tight mb-0" id="confirmationModalLabel" style="color: #ffffff !important;">Delete Customer</h5>
                </div>
                <!-- Circular Red Close Button with White Icon -->
                <button type="button" class="qv-close-btn" data-bs-dismiss="modal" aria-label="Close" style="width: 30px !important; height: 30px !important; min-width: 30px !important; min-height: 30px !important; border-radius: 50% !important; background-color: #991b1b !important; color: #ffffff !important; border: none !important; display: flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; padding: 0 !important; margin: 0 !important;">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
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
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mb-0">Are you sure you want to delete this customer? This action cannot be undone.</p>
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
<!-- Delete Confirmation Modal End -->

<style>
    #confirmationModal .modal-dialog {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
    #confirmationModal .modal-content {
        border: none !important;
    }
    body[light-mode="dark"] #confirmationModal .modal-content {
        background-color: #0f172a !important;
        border: 1px solid #334155 !important;
    }
</style>

<script>
    $(document).ready(function() {
        $('#confirmationModal').appendTo("body");
    });

    // Delete Customer function
    async function itemDelete() {
        try {
            let id = document.getElementById('deleteID').value;

            if (!id) {
                errorToast("Customer ID is missing. Please try again.");
                return;
            }

            showLoader();

            let res = await axios.post(
                "/api/delete-customer", {
                    id: id
                },
                HeaderToken()
            );

            hideLoader();

            if (res.data && res.data.status === "success") {
                successToast(res.data.message);
                $("#confirmationModal").modal('hide');

                if (typeof getList === 'function') {
                    await getList();
                } else {
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }
            } else {
                errorToast(res.data ? res.data.message : "Failed to delete customer.");
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            errorToast((e.response && e.response.data && e.response.data.message) ? e.response.data.message : (e.message || "An error occurred. Please try again."));
        }
    }
</script>
