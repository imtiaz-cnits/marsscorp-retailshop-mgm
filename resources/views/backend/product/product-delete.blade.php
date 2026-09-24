<style>
    /* Reset old legacy styles from all-modal.css and ensure dead-center positioning */
    #confirmationModal.modal {
        display: none;
        background: rgba(15, 23, 42, 0.65) !important;
        backdrop-filter: blur(5px) !important;
        -webkit-backdrop-filter: blur(5px) !important;
        z-index: 1055 !important;
    }
    #confirmationModal.modal.show {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    #confirmationModal .modal-dialog {
        position: static !important;
        top: auto !important;
        left: auto !important;
        transform: none !important;
        margin: auto !important;
        max-width: 420px !important;
        width: 92% !important;
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
    }
    #confirmationModal .modal-content {
        background: #ffffff !important;
        border-radius: 20px !important;
        border: 1px solid rgba(226, 232, 240, 0.8) !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(0, 0, 0, 0.05) !important;
        padding: 30px 24px 26px 24px !important;
        text-align: center !important;
        position: relative !important;
        overflow: hidden !important;
    }
    #confirmationModal .modal-dialog form {
        padding: 0 !important;
        margin: 0 !important;
        max-height: none !important;
        overflow: visible !important;
    }
    #confirmationModal .delete-icon-circle {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: #fef2f2;
        border: 2px solid #fee2e2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px auto;
        box-shadow: 0 8px 16px rgba(220, 38, 38, 0.12);
    }
    #confirmationModal .delete-modal-title {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
    }
    #confirmationModal .delete-modal-text {
        font-size: 13.5px;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 22px;
        padding: 0 10px;
    }
    #confirmationModal .delete-modal-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }
    #confirmationModal .btn-delete-cancel {
        flex: 1;
        height: 42px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 600;
        color: #475569;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    #confirmationModal .btn-delete-cancel:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    #confirmationModal .btn-delete-confirm {
        flex: 1;
        height: 42px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 600;
        color: #ffffff;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    #confirmationModal .btn-delete-confirm:hover {
        background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
        box-shadow: 0 6px 18px rgba(220, 38, 38, 0.35);
        transform: translateY(-1px);
    }
    #confirmationModal .btn-delete-close {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.2s ease;
    }
    #confirmationModal .btn-delete-close:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    /* Dark Mode Support */
    body[light-mode="dark"] #confirmationModal .modal-content,
    html.dark #confirmationModal .modal-content {
        background: #0f172a !important;
        border-color: #1e293b !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6) !important;
    }
    body[light-mode="dark"] #confirmationModal .delete-modal-title,
    html.dark #confirmationModal .delete-modal-title {
        color: #f8fafc !important;
    }
    body[light-mode="dark"] #confirmationModal .delete-modal-text,
    html.dark #confirmationModal .delete-modal-text {
        color: #94a3b8 !important;
    }
    body[light-mode="dark"] #confirmationModal .delete-icon-circle,
    html.dark #confirmationModal .delete-icon-circle {
        background: rgba(220, 38, 38, 0.15) !important;
        border-color: rgba(220, 38, 38, 0.3) !important;
        color: #f87171 !important;
    }
    body[light-mode="dark"] #confirmationModal .btn-delete-cancel,
    html.dark #confirmationModal .btn-delete-cancel {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] #confirmationModal .btn-delete-cancel:hover,
    html.dark #confirmationModal .btn-delete-cancel:hover {
        background: #334155 !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] #confirmationModal .btn-delete-close,
    html.dark #confirmationModal .btn-delete-close {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }
</style>

<!-- Modern Centered Product Delete Confirmation Modal -->
<section class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-delete-close" data-bs-dismiss="modal" aria-label="Close" title="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <form onsubmit="event.preventDefault(); return false;">
                <input type="hidden" id="deleteID" />
                <div class="delete-icon-circle">
                    <i class="fa-solid fa-trash-can" style="font-size: 26px;"></i>
                </div>
                <h4 class="delete-modal-title">Delete Product?</h4>
                <p class="delete-modal-text">Are you sure you want to delete this product record? This action cannot be undone.</p>
                <div class="delete-modal-actions">
                    <button type="button" data-bs-dismiss="modal" class="btn-delete-cancel">Cancel</button>
                    <button type="button" onclick="itemDelete(event)" class="btn-delete-confirm">
                        <i class="fa-solid fa-trash-can"></i>
                        <span>Yes, Delete</span>
                    </button>
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
                }, 400);
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
