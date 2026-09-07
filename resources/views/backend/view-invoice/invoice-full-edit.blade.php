<style>
    #invoiceFullEditModal {
        z-index: 1060 !important;
    }
    /* Fix duplicate outer box from all-modal.css.css */
    #invoiceFullEditModal .modal-dialog {
        background: transparent !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
        max-width: 920px;
        margin: 1.75rem auto;
    }
    #invoiceFullEditModal .modal-content {
        background: #ffffff !important;
        border-radius: 16px !important;
        border: none !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3) !important;
        overflow: hidden !important;
        max-height: 90vh !important;
        display: flex !important;
        flex-direction: column !important;
        padding: 0 !important;
    }

    /* Dark Mode Modal Content */
    body[light-mode="dark"] #invoiceFullEditModal .modal-content,
    html[light-mode="dark"] #invoiceFullEditModal .modal-content,
    body[data-layout-mode="dark"] #invoiceFullEditModal .modal-content,
    html.dark #invoiceFullEditModal .modal-content,
    body.dark #invoiceFullEditModal .modal-content,
    body.dark-mode #invoiceFullEditModal .modal-content {
        background-color: #0f172a !important;
        color: #f1f5f9 !important;
        border: 1px solid #1e293b !important;
    }

    #invoiceFullEditModal .modal-body-scrollable {
        padding: 20px 24px;
        overflow-y: auto;
        flex: 1 1 auto;
        max-height: calc(90vh - 135px);
        text-align: left;
        background: transparent !important;
    }

    #invoiceFullEditModal .form-label-title {
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #334155 !important;
        margin-bottom: 6px !important;
        display: block !important;
    }

    /* Dark Mode Form Labels */
    body[light-mode="dark"] #invoiceFullEditModal .form-label-title,
    html[light-mode="dark"] #invoiceFullEditModal .form-label-title,
    body[data-layout-mode="dark"] #invoiceFullEditModal .form-label-title,
    html.dark #invoiceFullEditModal .form-label-title,
    body.dark #invoiceFullEditModal .form-label-title,
    body.dark-mode #invoiceFullEditModal .form-label-title {
        color: #e2e8f0 !important;
    }

    /* Top Order Info Box */
    #invoiceFullEditModal .modal-summary-box {
        background-color: #f8fafc;
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 14px;
    }
    body[light-mode="dark"] #invoiceFullEditModal .modal-summary-box,
    html[light-mode="dark"] #invoiceFullEditModal .modal-summary-box,
    body[data-layout-mode="dark"] #invoiceFullEditModal .modal-summary-box,
    html.dark #invoiceFullEditModal .modal-summary-box,
    body.dark #invoiceFullEditModal .modal-summary-box,
    body.dark-mode #invoiceFullEditModal .modal-summary-box {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    /* Form Controls */
    #invoiceFullEditModal .form-control,
    #invoiceFullEditModal .form-select {
        height: 42px;
        border-radius: 8px;
        border: 1.5px solid #cbd5e1;
        font-size: 13.5px;
        padding: 6px 12px;
        transition: border-color 0.2s, box-shadow 0.2s;
        background-color: #ffffff;
        color: #1e293b;
    }
    #invoiceFullEditModal .form-control:focus,
    #invoiceFullEditModal .form-select:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.2) !important;
    }

    /* Dark Mode Form Controls */
    body[light-mode="dark"] #invoiceFullEditModal .form-control,
    body[light-mode="dark"] #invoiceFullEditModal .form-select,
    html[light-mode="dark"] #invoiceFullEditModal .form-control,
    html[light-mode="dark"] #invoiceFullEditModal .form-select,
    body[data-layout-mode="dark"] #invoiceFullEditModal .form-control,
    body[data-layout-mode="dark"] #invoiceFullEditModal .form-select,
    html.dark #invoiceFullEditModal .form-control,
    html.dark #invoiceFullEditModal .form-select,
    body.dark #invoiceFullEditModal .form-control,
    body.dark #invoiceFullEditModal .form-select,
    body.dark-mode #invoiceFullEditModal .form-control,
    body.dark-mode #invoiceFullEditModal .form-select {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }

    /* Search Bar Box */
    #invoiceFullEditModal .modal-search-card {
        background-color: #f8fafc;
        border: 1.5px dashed #cbd5e1 !important;
        border-radius: 12px;
    }
    body[light-mode="dark"] #invoiceFullEditModal .modal-search-card,
    html[light-mode="dark"] #invoiceFullEditModal .modal-search-card,
    body[data-layout-mode="dark"] #invoiceFullEditModal .modal-search-card,
    html.dark #invoiceFullEditModal .modal-search-card,
    body.dark #invoiceFullEditModal .modal-search-card,
    body.dark-mode #invoiceFullEditModal .modal-search-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    #invoiceFullEditModal .qty-input {
        width: 60px;
        text-align: center;
        font-weight: 700;
        height: 32px !important;
        font-size: 12px !important;
    }
    #invoiceFullEditModal .table-items th {
        background-color: #f8fafc;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: #475569;
        border-bottom: 1.5px solid #e2e8f0;
    }
    body[light-mode="dark"] #invoiceFullEditModal .table-items th,
    html[light-mode="dark"] #invoiceFullEditModal .table-items th,
    body[data-layout-mode="dark"] #invoiceFullEditModal .table-items th,
    html.dark #invoiceFullEditModal .table-items th,
    body.dark #invoiceFullEditModal .table-items th,
    body.dark-mode #invoiceFullEditModal .table-items th {
        background-color: #1e293b !important;
        color: #cbd5e1 !important;
        border-bottom-color: #334155 !important;
    }
    body[light-mode="dark"] #invoiceFullEditModal .table-items td,
    html[light-mode="dark"] #invoiceFullEditModal .table-items td,
    body[data-layout-mode="dark"] #invoiceFullEditModal .table-items td,
    html.dark #invoiceFullEditModal .table-items td,
    body.dark #invoiceFullEditModal .table-items td,
    body.dark-mode #invoiceFullEditModal .table-items td {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] #invoiceFullEditModal .table-items td .text-dark,
    html[light-mode="dark"] #invoiceFullEditModal .table-items td .text-dark,
    body[data-layout-mode="dark"] #invoiceFullEditModal .table-items td .text-dark {
        color: #ffffff !important;
    }
    body[light-mode="dark"] #invoiceFullEditModal .table-items input,
    html[light-mode="dark"] #invoiceFullEditModal .table-items input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] #invoiceFullEditModal .table-items .btn-outline-secondary,
    html[light-mode="dark"] #invoiceFullEditModal .table-items .btn-outline-secondary {
        border-color: #334155 !important;
        color: #cbd5e1 !important;
        background-color: #1e293b !important;
    }

    /* Financial Summary Box */
    #invoiceFullEditModal .modal-financial-box {
        background-color: #f8fafc;
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 14px;
    }
    body[light-mode="dark"] #invoiceFullEditModal .modal-financial-box,
    html[light-mode="dark"] #invoiceFullEditModal .modal-financial-box,
    body[data-layout-mode="dark"] #invoiceFullEditModal .modal-financial-box,
    html.dark #invoiceFullEditModal .modal-financial-box,
    body.dark #invoiceFullEditModal .modal-financial-box,
    body.dark-mode #invoiceFullEditModal .modal-financial-box {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #invoiceFullEditModal .modal-financial-box .text-secondary,
    html[light-mode="dark"] #invoiceFullEditModal .modal-financial-box .text-secondary,
    body[data-layout-mode="dark"] #invoiceFullEditModal .modal-financial-box .text-secondary {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] #invoiceFullEditModal #fullEditSubTotalDisplay,
    html[light-mode="dark"] #invoiceFullEditModal #fullEditSubTotalDisplay,
    body[data-layout-mode="dark"] #invoiceFullEditModal #fullEditSubTotalDisplay {
        color: #ffffff !important;
    }
    body[light-mode="dark"] #invoiceFullEditModal .modal-financial-box .border-top,
    html[light-mode="dark"] #invoiceFullEditModal .modal-financial-box .border-top {
        border-color: #334155 !important;
    }

    /* Search Results Dropdown */
    #fullEditProductSearchResults .dropdown-item {
        padding: 10px 14px;
        cursor: pointer;
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    #fullEditProductSearchResults .dropdown-item:hover {
        background-color: #f0fdf4;
    }
    body[light-mode="dark"] #fullEditProductSearchResults,
    html[light-mode="dark"] #fullEditProductSearchResults,
    body[data-layout-mode="dark"] #fullEditProductSearchResults {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #fullEditProductSearchResults .dropdown-item,
    html[light-mode="dark"] #fullEditProductSearchResults .dropdown-item {
        border-bottom-color: #1e293b !important;
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] #fullEditProductSearchResults .dropdown-item:hover,
    html[light-mode="dark"] #fullEditProductSearchResults .dropdown-item:hover {
        background-color: #1e293b !important;
        color: #34d399 !important;
    }

    /* Select2 Searchable Dropdown Styling in Modal */
    #invoiceFullEditModal .select2-container {
        width: 100% !important;
    }
    #invoiceFullEditModal .select2-container--default .select2-selection--single {
        height: 42px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 8px !important;
        display: flex !important;
        align-items: center !important;
        padding: 0 6px !important;
        background-color: #ffffff !important;
    }
    #invoiceFullEditModal .select2-container--default .select2-selection--single:focus,
    #invoiceFullEditModal .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.2) !important;
    }
    #invoiceFullEditModal .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px !important;
        color: #1e293b !important;
        font-size: 13.5px !important;
        font-weight: 500 !important;
        padding-left: 6px !important;
    }
    #invoiceFullEditModal .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
        right: 8px !important;
    }
    .select2-dropdown {
        z-index: 999999 !important;
        border-radius: 8px !important;
        border: 1.5px solid #cbd5e1 !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 6px !important;
        padding: 6px 10px !important;
        outline: none !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        border-color: #15803d !important;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #15803d !important;
        color: white !important;
    }

    body[light-mode="dark"] #invoiceFullEditModal .select2-container--default .select2-selection--single,
    html[light-mode="dark"] #invoiceFullEditModal .select2-container--default .select2-selection--single,
    body[data-layout-mode="dark"] #invoiceFullEditModal .select2-container--default .select2-selection--single {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #invoiceFullEditModal .select2-container--default .select2-selection--single .select2-selection__rendered,
    html[light-mode="dark"] #invoiceFullEditModal .select2-container--default .select2-selection--single .select2-selection__rendered,
    body[data-layout-mode="dark"] #invoiceFullEditModal .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #ffffff !important;
    }
    body[light-mode="dark"] .select2-dropdown,
    html[light-mode="dark"] .select2-dropdown,
    body[data-layout-mode="dark"] .select2-dropdown {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] .select2-container--default .select2-search--dropdown .select2-search__field,
    html[light-mode="dark"] .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] .select2-container--default .select2-results__option[aria-selected=true],
    html[light-mode="dark"] .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #1e293b !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] .select2-results__option,
    html[light-mode="dark"] .select2-results__option {
        color: #cbd5e1 !important;
    }

    /* Sticky Footer */
    #invoiceFullEditModal .modal-footer-sticky {
        padding: 14px 24px;
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        flex-shrink: 0;
        position: sticky;
        bottom: 0;
        z-index: 20;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        border-bottom-left-radius: 16px;
        border-bottom-right-radius: 16px;
    }
    body[light-mode="dark"] #invoiceFullEditModal .modal-footer-sticky,
    html[light-mode="dark"] #invoiceFullEditModal .modal-footer-sticky,
    body[data-layout-mode="dark"] #invoiceFullEditModal .modal-footer-sticky,
    html.dark #invoiceFullEditModal .modal-footer-sticky,
    body.dark #invoiceFullEditModal .modal-footer-sticky,
    body.dark-mode #invoiceFullEditModal .modal-footer-sticky {
        background: #0f172a !important;
        border-top: 1px solid #1e293b !important;
    }

    /* Flatpickr z-index in modal */
    .flatpickr-calendar {
        z-index: 999999 !important;
    }
</style>

<!-- Full Invoice & Product Item Edit Modal Start -->
<section class="modal fade" id="invoiceFullEditModal" tabindex="-1" aria-labelledby="invoiceFullEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Sticky Green Header with White Text & Circular Red Close Icon -->
            <div style="background-color: #15803d; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 20; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-cart-flatbed-suitcases" style="color: #ffffff; font-size: 18px;"></i>
                    <h2 style="font-size: 17px; font-weight: 700; color: #ffffff; margin: 0; padding: 0; line-height: 1.2;">Edit Invoice & Product Items</h2>
                </div>
                <button type="button" data-bs-dismiss="modal" aria-label="Close" style="width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #dc2626; color: #ffffff; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.15s ease;" title="Close">
                    <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 14px;"></i>
                </button>
            </div>

            <!-- Scrollable Modal Body -->
            <div class="modal-body-scrollable">
                <form id="fullEditInvoiceForm" onsubmit="return SaveFullInvoiceEdit(event)">
                    <input type="hidden" id="fullEditInvoiceID">

                    <!-- Top Order Info (English labels only, Dark mode compliant) -->
                    <div class="modal-summary-box row g-2 mb-3 p-3">
                        <div class="col-md-4">
                            <label class="form-label-title" for="fullEditOrderNo">Invoice No</label>
                            <input type="text" class="form-control fw-bold text-dark" id="fullEditOrderNo" readonly />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-title" for="fullEditInvoiceDate">Invoice Date</label>
                            <input type="text" class="form-control" id="fullEditInvoiceDate" placeholder="Select Date" required style="cursor: pointer;" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-title" for="fullEditCustomerSelect">Customer</label>
                            <select class="form-select bg-white" id="fullEditCustomerSelect" style="width: 100%;">
                                <option value="">Select Customer</option>
                            </select>
                        </div>
                    </div>

                    <!-- Add New Product Search Bar & Camera Scanner -->
                    <div class="card border-0 p-2 mb-3 modal-search-card">
                        <div class="d-flex align-items-center gap-2">
                            <div class="flex-grow-1 position-relative">
                                <input type="text" id="fullEditSearchInput" class="form-control" placeholder="🔍 Scan barcode or enter product name/code..." autocomplete="off" style="height: 42px; font-size: 13.5px; border-radius: 8px;" />
                                
                                <!-- Dynamic Autocomplete Results Dropdown -->
                                <div id="fullEditProductSearchResults" class="dropdown-menu shadow-lg w-100 p-0 overflow-auto" style="max-height: 280px; display: none; position: absolute; z-index: 1070; top: 100%; left: 0; border-radius: 8px;"></div>
                            </div>

                            <button type="button" class="btn text-white fw-bold px-3 d-flex align-items-center gap-2 text-nowrap" onclick="openFullEditCameraScannerModal()" style="height: 42px; border-radius: 8px; background-color: #15803d; border: none;">
                                <i class="fa-solid fa-camera fs-5"></i>
                                <span>Camera Scan</span>
                            </button>
                        </div>
                    </div>

                    <!-- Products Table -->
                    <div class="table-responsive mb-3 border rounded-3 overflow-hidden" style="border-color: #cbd5e1 !important;">
                        <table class="table table-hover align-middle mb-0 table-items">
                            <thead>
                                <tr>
                                    <th class="ps-3 py-2" style="width: 40px;">#</th>
                                    <th class="py-2">Product Info</th>
                                    <th class="py-2 text-center" style="width: 130px;">Price (৳)</th>
                                    <th class="py-2 text-center" style="width: 140px;">Quantity</th>
                                    <th class="py-2 text-end" style="width: 120px;">Subtotal (৳)</th>
                                    <th class="pe-3 py-2 text-center" style="width: 50px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="fullEditItemsTableBody">
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fa-solid fa-circle-notch fa-spin me-2"></i> Loading product items...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Financial Summary & Note -->
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <label class="form-label-title" for="fullEditOrderNote">Order Note</label>
                            <textarea class="form-control" id="fullEditOrderNote" rows="4" placeholder="Enter order notes / comments..." style="height: auto; border-radius: 8px;"></textarea>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 modal-financial-box">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fw-bold text-secondary small">Sub-Total:</span>
                                    <span class="fw-extrabold fs-6 text-dark" id="fullEditSubTotalDisplay">৳ 0.00</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fw-bold text-secondary small">Discount Amount:</span>
                                    <div style="width: 120px;">
                                        <input type="number" step="any" class="form-control text-end fw-bold py-1" id="fullEditDiscount" oninput="recalculateFullEditFinancials()" value="0" style="height: 36px; border-radius: 6px;" />
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fw-bold text-secondary small">Paid Amount:</span>
                                    <div style="width: 120px;">
                                        <input type="number" step="any" class="form-control text-end fw-bold text-success py-1" id="fullEditPaid" oninput="recalculateFullEditFinancials()" value="0" style="height: 36px; border-radius: 6px;" />
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                    <span class="fw-bold text-danger small">Due Amount:</span>
                                    <span class="fw-extrabold fs-6 text-danger" id="fullEditDueDisplay">৳ 0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Sticky Bottom Footer with Red Cancel Button & Green Submit Button -->
            <div class="modal-footer-sticky">
                <button type="button" class="btn fw-bold px-4 py-2" data-bs-dismiss="modal" style="border-radius: 8px; background-color: #dc2626 !important; color: #ffffff !important; border: none; font-size: 14px; cursor: pointer; transition: opacity 0.2s;">
                    Cancel
                </button>
                <button type="button" onclick="SaveFullInvoiceEdit(event)" class="btn fw-bold px-4 py-2" style="border-radius: 8px; background-color: #15803d !important; color: #ffffff !important; border: none; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: opacity 0.2s;">
                    <i class="fa-solid fa-check"></i> Update Invoice & Products
                </button>
            </div>
        </div>
    </div>
</section>
<!-- Full Invoice Edit Modal End -->

<!-- Camera Scanner Modal Start -->
<div class="modal fade" id="fullEditCameraScannerModal" tabindex="-1" aria-hidden="true" style="z-index: 1085 !important;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
            <div style="background-color: #15803d; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-camera" style="color: #ffffff; font-size: 18px;"></i>
                    <h5 style="font-size: 16px; font-weight: 700; color: #ffffff; margin: 0; padding: 0;">Camera Barcode Scanner</h5>
                </div>
                <button type="button" onclick="closeFullEditCameraScannerModal()" style="width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #dc2626; color: #ffffff; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer;" title="Close">
                    <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 14px;"></i>
                </button>
            </div>
            <div class="modal-body p-4 text-center">
                <div id="fullEditCameraReader" style="width: 100%; min-height: 250px; background: #000; border-radius: 12px; overflow: hidden;"></div>
                <div class="text-muted small mt-2">Hold the barcode or QR code in front of the camera.</div>
            </div>
        </div>
    </div>
</div>
<!-- Camera Scanner Modal End -->

<script>
    let fullEditItems = [];
    let allAvailableProducts = [];
    let fullEditHtml5QrCode = null;
    let fullEditDatePicker = null;

    function initFullEditDatePicker() {
        if (window.flatpickr) {
            fullEditDatePicker = flatpickr("#fullEditInvoiceDate", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                altInputClass: "form-control",
                monthSelectorType: "static",
                disableMobile: true
            });
        }
    }

    $(document).ready(function() {
        $('#invoiceFullEditModal').appendTo("body");
        $('#fullEditCameraScannerModal').appendTo("body");

        initFullEditDatePicker();

        $('#invoiceFullEditModal').on('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (button) {
                const id = $(button).attr('data-id') || $(button).data('id') || $(button).closest('[data-id]').attr('data-id');
                if (id) {
                    FillUpFullInvoiceEditForm(id);
                }
            }
        });

        // Search Input Keyup Listener for Live Search & Barcode Scan
        $("#fullEditSearchInput").on("keyup input", function(e) {
            let term = $(this).val().trim();
            if (e.key === "Enter" || e.keyCode === 13) {
                e.preventDefault();
                processFullEditBarcodeSearch(term);
                return false;
            }
            filterFullEditProductDropdown(term);
        });

        // Hide search dropdown on click outside
        $(document).on("click", function(e) {
            if (!$(e.target).closest("#fullEditSearchInput, #fullEditProductSearchResults").length) {
                $("#fullEditProductSearchResults").hide();
            }
        });
    });

    async function LoadAllProductsForInvoiceEdit() {
        try {
            let res = await axios.get("/api/product-list", HeaderToken());
            if (res.data.status === "success" || res.data.ProductData || res.data.data) {
                allAvailableProducts = res.data.ProductData || res.data.data || res.data.rows || [];
            }
        } catch (e) {
            console.error("Error loading products:", e);
        }
    }

    async function LoadInvoiceCustomerDropdown() {
        try {
            let res = await axios.get("/api/customer-list", HeaderToken());
            let select = $('#fullEditCustomerSelect');
            select.find('option:not(:first)').remove();
            if (res.data.status === 'success' && res.data.CustomerData) {
                res.data.CustomerData.forEach(cust => {
                    select.append(`<option value="${cust.id}">${cust.customer_name} (${cust.mobile || ''})</option>`);
                });
            }

            // Initialize or reinitialize Select2 searchable dropdown
            if ($.fn.select2) {
                select.select2({
                    dropdownParent: $('#invoiceFullEditModal'),
                    placeholder: 'Select Customer',
                    width: '100%',
                    allowClear: true
                });
            }
        } catch (e) {
            console.error("Error loading customers:", e);
        }
    }

    function filterFullEditProductDropdown(term) {
        let dropdown = $("#fullEditProductSearchResults");
        dropdown.empty();

        if (!term || term.length < 1) {
            dropdown.hide();
            return;
        }

        let searchTerm = term.toLowerCase();
        let matches = allAvailableProducts.filter(p => {
            let name = (p.product_name || '').toLowerCase();
            let code = (Array.isArray(p.product_code) ? p.product_code.join(' ') : (p.product_code || '')).toLowerCase();
            return name.includes(searchTerm) || code.includes(searchTerm);
        }).slice(0, 10);

        if (matches.length === 0) {
            dropdown.html(`<div class="p-3 text-center text-muted small">No products found</div>`).show();
            return;
        }

        matches.forEach(prod => {
            let codeStr = Array.isArray(prod.product_code) ? prod.product_code.join(', ') : (prod.product_code || '');
            let itemHtml = `
                <div class="dropdown-item d-flex align-items-center justify-content-between" onclick="selectProductFromFullEditDropdown(${prod.id})">
                    <div>
                        <div class="fw-bold text-dark" style="font-size: 13px;">${prod.product_name}</div>
                        ${codeStr ? `<span class="badge bg-light text-primary border" style="font-size: 10px;">${codeStr}</span>` : ''}
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-success" style="font-size: 13px;">৳ ${parseFloat(prod.sell_price || 0).toFixed(2)}</div>
                        <small class="text-muted" style="font-size: 10px;">Stock: ${prod.quantity || 0}</small>
                    </div>
                </div>
            `;
            dropdown.append(itemHtml);
        });

        dropdown.show();
    }

    function selectProductFromFullEditDropdown(productId) {
        let prod = allAvailableProducts.find(p => p.id == productId);
        if (prod) {
            addProductToFullEditItemsList(prod);
        }
        $("#fullEditSearchInput").val("");
        $("#fullEditProductSearchResults").hide();
    }

    function processFullEditBarcodeSearch(term) {
        if (!term) return;
        let searchTerm = term.toLowerCase();

        // Find exact match by barcode / code first
        let exactMatch = allAvailableProducts.find(p => {
            let codes = Array.isArray(p.product_code) ? p.product_code : [(p.product_code || '')];
            return codes.some(c => c.toString().toLowerCase() === searchTerm);
        });

        if (exactMatch) {
            addProductToFullEditItemsList(exactMatch);
            $("#fullEditSearchInput").val("");
            $("#fullEditProductSearchResults").hide();
            return;
        }

        // Partial match fallback
        let matches = allAvailableProducts.filter(p => {
            let name = (p.product_name || '').toLowerCase();
            let code = (Array.isArray(p.product_code) ? p.product_code : [(p.product_code || '')]);
            let codeStr = (Array.isArray(p.product_code) ? p.product_code.join(' ') : (p.product_code || '')).toLowerCase();
            return name.includes(searchTerm) || codeStr.includes(searchTerm);
        });

        if (matches.length === 1) {
            addProductToFullEditItemsList(matches[0]);
            $("#fullEditSearchInput").val("");
            $("#fullEditProductSearchResults").hide();
        } else if (matches.length > 1) {
            filterFullEditProductDropdown(term);
        } else {
            errorToast("Product not found!");
        }
    }

    function addProductToFullEditItemsList(prod) {
        let code = (Array.isArray(prod.product_code) ? prod.product_code[0] : prod.product_code) || '';
        let existingIndex = fullEditItems.findIndex(i => i.product_id == prod.id);

        if (existingIndex !== -1) {
            fullEditItems[existingIndex].quantity += 1;
        } else {
            fullEditItems.push({
                product_id: prod.id,
                product_name: prod.product_name,
                product_code: code,
                cost_price: parseFloat(prod.cost_price) || 0,
                selling_price: parseFloat(prod.sell_price) || 0,
                quantity: 1,
            });
        }

        successToast(`"${prod.product_name}" added!`);
        renderFullEditItemsTable();
    }

    // Camera Scanner Functions
    function openFullEditCameraScannerModal() {
        $("#fullEditCameraScannerModal").modal('show');
        setTimeout(() => {
            startFullEditCameraScanner();
        }, 400);
    }

    function closeFullEditCameraScannerModal() {
        stopFullEditCameraScanner();
        $("#fullEditCameraScannerModal").modal('hide');
    }

    function startFullEditCameraScanner() {
        if (!window.Html5Qrcode) {
            errorToast("Camera scanner library not available.");
            return;
        }

        if (fullEditHtml5QrCode) {
            stopFullEditCameraScanner();
        }

        fullEditHtml5QrCode = new Html5Qrcode("fullEditCameraReader");
        fullEditHtml5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 250, height: 150 }
            },
            (decodedText, decodedResult) => {
                processFullEditBarcodeSearch(decodedText);
                closeFullEditCameraScannerModal();
            },
            (errorMessage) => {
                // Ignore scanning errors
            }
        ).catch(err => {
            console.error("Camera access error:", err);
            errorToast("Unable to access camera! Please grant permission.");
        });
    }

    function stopFullEditCameraScanner() {
        if (fullEditHtml5QrCode) {
            fullEditHtml5QrCode.stop().then(() => {
                fullEditHtml5QrCode.clear();
                fullEditHtml5QrCode = null;
            }).catch(err => {
                fullEditHtml5QrCode = null;
            });
        }
    }

    async function FillUpFullInvoiceEditForm(id) {
        try {
            document.getElementById('fullEditInvoiceID').value = id;
            await Promise.all([LoadInvoiceCustomerDropdown(), LoadAllProductsForInvoiceEdit()]);

            showLoader();
            let res = await axios.post("/api/invoice-full-details-by-id", {
                id: id.toString()
            }, HeaderToken());
            hideLoader();

            if (res.data.status === "success") {
                const data = res.data.rows;

                document.getElementById('fullEditOrderNo').value = data.order_no || '';
                
                // Set date via flatpickr
                if (fullEditDatePicker && data.invoice_date) {
                    fullEditDatePicker.setDate(data.invoice_date, true);
                } else if (document.getElementById('fullEditInvoiceDate')) {
                    document.getElementById('fullEditInvoiceDate').value = data.invoice_date || '';
                }

                document.getElementById('fullEditDiscount').value = data.discount_amount || 0;
                document.getElementById('fullEditPaid').value = data.paid_amount || 0;
                document.getElementById('fullEditOrderNote').value = data.order_note || '';

                if (data.customer_id) {
                    if ($.fn.select2 && $('#fullEditCustomerSelect').data('select2')) {
                        $('#fullEditCustomerSelect').val(data.customer_id).trigger('change');
                    } else if (document.getElementById('fullEditCustomerSelect')) {
                        document.getElementById('fullEditCustomerSelect').value = data.customer_id;
                    }
                }

                // Populate Items
                fullEditItems = (data.details || []).map(item => ({
                    product_id: item.product_id,
                    product_name: item.product_name,
                    product_code: item.product_code,
                    cost_price: parseFloat(item.cost_price) || 0,
                    selling_price: parseFloat(item.selling_price) || 0,
                    quantity: parseFloat(item.quantity) || 1,
                }));

                renderFullEditItemsTable();
            }
        } catch (e) {
            hideLoader();
            console.error("Error fetching invoice details:", e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    function renderFullEditItemsTable() {
        let tbody = $("#fullEditItemsTableBody");
        tbody.empty();

        if (!fullEditItems || fullEditItems.length === 0) {
            tbody.append(`
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="fa-solid fa-inbox me-2 opacity-50"></i> No product items added.
                    </td>
                </tr>
            `);
            recalculateFullEditFinancials();
            return;
        }

        fullEditItems.forEach((item, index) => {
            let itemSubtotal = item.selling_price * item.quantity;

            let row = `
                <tr>
                    <td class="ps-3 fw-bold text-secondary">${index + 1}</td>
                    <td>
                        <div class="fw-bold text-dark">${item.product_name}</div>
                        ${item.product_code ? `<span class="badge bg-light text-primary border" style="font-size: 10px;">${item.product_code}</span>` : ''}
                    </td>
                    <td class="text-center">
                        <input type="number" step="any" class="form-control text-center py-1 fw-bold" value="${item.selling_price}" onchange="updateFullEditItemPrice(${index}, this.value)" style="height: 32px; font-size: 12px;" />
                    </td>
                    <td class="text-center">
                        <div class="d-inline-flex align-items-center gap-1">
                            <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0" onclick="changeFullEditQty(${index}, -1)">-</button>
                            <input type="number" step="any" class="form-control qty-input py-1" value="${item.quantity}" onchange="updateFullEditItemQty(${index}, this.value)" style="height: 32px; font-size: 12px;" />
                            <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0" onclick="changeFullEditQty(${index}, 1)">+</button>
                        </div>
                    </td>
                    <td class="text-end fw-extrabold text-dark fs-6">৳ ${itemSubtotal.toFixed(2)}</td>
                    <td class="pe-3 text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-circle" onclick="removeFullEditItem(${index})" title="Remove Item">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });

        recalculateFullEditFinancials();
    }

    function changeFullEditQty(index, delta) {
        if (fullEditItems[index]) {
            let newQty = fullEditItems[index].quantity + delta;
            if (newQty <= 0) {
                removeFullEditItem(index);
            } else {
                fullEditItems[index].quantity = newQty;
                renderFullEditItemsTable();
            }
        }
    }

    function updateFullEditItemQty(index, val) {
        let qty = parseFloat(val) || 0;
        if (qty <= 0) {
            removeFullEditItem(index);
        } else if (fullEditItems[index]) {
            fullEditItems[index].quantity = qty;
            renderFullEditItemsTable();
        }
    }

    function updateFullEditItemPrice(index, val) {
        let price = parseFloat(val) || 0;
        if (fullEditItems[index]) {
            fullEditItems[index].selling_price = price;
            renderFullEditItemsTable();
        }
    }

    function removeFullEditItem(index) {
        fullEditItems.splice(index, 1);
        renderFullEditItemsTable();
    }

    function recalculateFullEditFinancials() {
        let subtotal = 0;
        fullEditItems.forEach(item => {
            subtotal += (item.selling_price * item.quantity);
        });

        const discount = parseFloat(document.getElementById('fullEditDiscount')?.value || 0);
        const paid = parseFloat(document.getElementById('fullEditPaid')?.value || 0);
        const due = Math.max(0, subtotal - discount - paid);

        document.getElementById('fullEditSubTotalDisplay').textContent = `৳ ${subtotal.toFixed(2)}`;
        document.getElementById('fullEditDueDisplay').textContent = `৳ ${due.toFixed(2)}`;
    }

    async function SaveFullInvoiceEdit(event) {
        if (event) event.preventDefault();

        try {
            const id = document.getElementById('fullEditInvoiceID').value;
            let subtotal = 0;
            fullEditItems.forEach(item => {
                subtotal += (item.selling_price * item.quantity);
            });

            const discountAmount = parseFloat(document.getElementById('fullEditDiscount').value) || 0;
            const paidAmount = parseFloat(document.getElementById('fullEditPaid').value) || 0;
            const invoiceDate = document.getElementById('fullEditInvoiceDate').value;
            const customerId = document.getElementById('fullEditCustomerSelect').value;
            const orderNote = document.getElementById('fullEditOrderNote').value;

            if (fullEditItems.length === 0) {
                errorToast("Please add at least one product item.");
                return false;
            }

            let formData = new FormData();
            formData.append('id', id);
            formData.append('sub_total', subtotal);
            formData.append('discount_amount', discountAmount);
            formData.append('paid_amount', paidAmount);
            formData.append('invoice_date', invoiceDate);
            formData.append('customer_id', customerId);
            formData.append('order_note', orderNote);
            formData.append('items', JSON.stringify(fullEditItems));

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            showLoader();
            let res = await axios.post("/api/update-invoice-details", formData, config);
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message);
                $("#invoiceFullEditModal").modal('hide');
                if (typeof getList === 'function') {
                    await getList();
                } else if (typeof fetchInvoiceReport === 'function') {
                    await fetchInvoiceReport();
                } else {
                    setTimeout(() => location.reload(), 500);
                }
            } else {
                errorToast(res.data.message);
            }
        } catch (e) {
            hideLoader();
            console.error("Save error:", e);
            errorToast("Failed to update invoice & product items.");
        }
        return false;
    }
</script>
