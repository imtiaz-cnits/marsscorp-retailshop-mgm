<style>
    #exampleModal {
        z-index: 1060 !important;
    }
    /* Fix duplicate outer box from all-modal.css.css */
    #exampleModal .modal-dialog {
        background: transparent !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
        max-width: 620px;
        margin: 1.75rem auto;
    }
    #exampleModal .modal-content {
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

    /* Dark Mode for Modal Content */
    body[light-mode="dark"] #exampleModal .modal-content,
    html[light-mode="dark"] #exampleModal .modal-content,
    body[data-layout-mode="dark"] #exampleModal .modal-content,
    html.dark #exampleModal .modal-content,
    body.dark #exampleModal .modal-content,
    body.dark-mode #exampleModal .modal-content {
        background-color: #0f172a !important;
        color: #f1f5f9 !important;
        border: 1px solid #1e293b !important;
    }

    #exampleModal .modal-body-scrollable {
        padding: 20px 24px;
        overflow-y: auto;
        flex: 1 1 auto;
        max-height: calc(90vh - 135px);
        text-align: left;
        background: transparent !important;
    }

    /* Remove background and padding from #paymentForm caused by all-modal.css.css */
    #exampleModal #paymentForm,
    #paymentForm {
        background: transparent !important;
        background-color: transparent !important;
        padding: 0 !important;
        border: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
    }

    #exampleModal .form-label-title {
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #334155 !important;
        margin-bottom: 6px !important;
        display: block !important;
    }

    /* Dark Mode Labels */
    body[light-mode="dark"] #exampleModal .form-label-title,
    html[light-mode="dark"] #exampleModal .form-label-title,
    body[data-layout-mode="dark"] #exampleModal .form-label-title,
    html.dark #exampleModal .form-label-title,
    body.dark #exampleModal .form-label-title,
    body.dark-mode #exampleModal .form-label-title {
        color: #e2e8f0 !important;
    }

    /* Summary Info Box */
    #exampleModal .modal-summary-box {
        background-color: #f8fafc;
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 14px;
    }
    body[light-mode="dark"] #exampleModal .modal-summary-box,
    html[light-mode="dark"] #exampleModal .modal-summary-box,
    body[data-layout-mode="dark"] #exampleModal .modal-summary-box,
    html.dark #exampleModal .modal-summary-box,
    body.dark #exampleModal .modal-summary-box,
    body.dark-mode #exampleModal .modal-summary-box {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #exampleModal .modal-summary-box .border-end,
    html[light-mode="dark"] #exampleModal .modal-summary-box .border-end,
    body[data-layout-mode="dark"] #exampleModal .modal-summary-box .border-end,
    html.dark #exampleModal .modal-summary-box .border-end,
    body.dark #exampleModal .modal-summary-box .border-end,
    body.dark-mode #exampleModal .modal-summary-box .border-end {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] #exampleModal .modal-summary-box .summary-label,
    html[light-mode="dark"] #exampleModal .modal-summary-box .summary-label,
    body[data-layout-mode="dark"] #exampleModal .modal-summary-box .summary-label,
    html.dark #exampleModal .modal-summary-box .summary-label,
    body.dark #exampleModal .modal-summary-box .summary-label,
    body.dark-mode #exampleModal .modal-summary-box .summary-label {
        color: #94a3b8 !important;
    }
    body[light-mode="dark"] #exampleModal #ShowSubTotalAmmount,
    html[light-mode="dark"] #exampleModal #ShowSubTotalAmmount,
    body[data-layout-mode="dark"] #exampleModal #ShowSubTotalAmmount,
    html.dark #exampleModal #ShowSubTotalAmmount,
    body.dark #exampleModal #ShowSubTotalAmmount,
    body.dark-mode #exampleModal #ShowSubTotalAmmount {
        color: #ffffff !important;
    }

    /* Ensure all form fields inside #paymentForm have 100% width and identical 42px height */
    #exampleModal #paymentForm input,
    #exampleModal #paymentForm input.form-control,
    #exampleModal #paymentForm .form-control,
    #exampleModal #paymentForm .flatpickr-input {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 100% !important;
        height: 42px !important;
        min-height: 42px !important;
        max-height: 42px !important;
        line-height: 42px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 8px !important;
        font-size: 13.5px !important;
        padding: 0 12px !important;
        text-align: left !important;
        box-sizing: border-box !important;
        background-color: #ffffff !important;
        color: #1e293b !important;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    #exampleModal #paymentForm input:focus,
    #exampleModal #paymentForm .form-control:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.2) !important;
        outline: none !important;
    }

    #exampleModal #paymentForm .status-display-box {
        width: 100% !important;
        height: 42px !important;
        min-height: 42px !important;
        max-height: 42px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 8px !important;
        background-color: #f8fafc !important;
        padding: 0 12px !important;
        display: flex !important;
        align-items: center !important;
        font-size: 13.5px !important;
        box-sizing: border-box !important;
    }

    /* Dark Mode for Inputs & Status Box */
    body[light-mode="dark"] #exampleModal #paymentForm input,
    body[light-mode="dark"] #exampleModal #paymentForm input.form-control,
    body[light-mode="dark"] #exampleModal #paymentForm .form-control,
    body[light-mode="dark"] #exampleModal #paymentForm .flatpickr-input,
    html[light-mode="dark"] #exampleModal #paymentForm input,
    html[light-mode="dark"] #exampleModal #paymentForm input.form-control,
    html[light-mode="dark"] #exampleModal #paymentForm .form-control,
    html[light-mode="dark"] #exampleModal #paymentForm .flatpickr-input,
    body[data-layout-mode="dark"] #exampleModal #paymentForm input,
    body[data-layout-mode="dark"] #exampleModal #paymentForm input.form-control,
    body[data-layout-mode="dark"] #exampleModal #paymentForm .form-control,
    body[data-layout-mode="dark"] #exampleModal #paymentForm .flatpickr-input,
    html.dark #exampleModal #paymentForm input,
    html.dark #exampleModal #paymentForm input.form-control,
    html.dark #exampleModal #paymentForm .form-control,
    html.dark #exampleModal #paymentForm .flatpickr-input,
    body.dark #exampleModal #paymentForm input,
    body.dark-mode #exampleModal #paymentForm input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] #exampleModal #paymentForm .status-display-box,
    html[light-mode="dark"] #exampleModal #paymentForm .status-display-box,
    body[data-layout-mode="dark"] #exampleModal #paymentForm .status-display-box,
    html.dark #exampleModal #paymentForm .status-display-box,
    body.dark #exampleModal #paymentForm .status-display-box,
    body.dark-mode #exampleModal #paymentForm .status-display-box {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    #exampleModal .payment-method-card {
        cursor: pointer;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        padding: 10px 14px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff;
    }
    #exampleModal .payment-method-card:hover {
        border-color: #15803d;
        background: #f0fdf4;
    }
    #exampleModal .payment-method-card.active {
        border-color: #15803d !important;
        background: #f0fdf4 !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.15);
    }

    /* Dark Mode for Payment Method Cards */
    body[light-mode="dark"] #exampleModal .payment-method-card,
    html[light-mode="dark"] #exampleModal .payment-method-card,
    body[data-layout-mode="dark"] #exampleModal .payment-method-card,
    html.dark #exampleModal .payment-method-card,
    body.dark #exampleModal .payment-method-card,
    body.dark-mode #exampleModal .payment-method-card {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }
    body[light-mode="dark"] #exampleModal .payment-method-card:hover,
    html[light-mode="dark"] #exampleModal .payment-method-card:hover,
    body[data-layout-mode="dark"] #exampleModal .payment-method-card:hover {
        border-color: #10b981 !important;
        background: rgba(6, 78, 59, 0.2) !important;
    }
    body[light-mode="dark"] #exampleModal .payment-method-card.active,
    html[light-mode="dark"] #exampleModal .payment-method-card.active,
    body[data-layout-mode="dark"] #exampleModal .payment-method-card.active,
    html.dark #exampleModal .payment-method-card.active,
    body.dark #exampleModal .payment-method-card.active,
    body.dark-mode #exampleModal .payment-method-card.active {
        border-color: #10b981 !important;
        background: rgba(6, 78, 59, 0.35) !important;
        color: #ffffff !important;
    }
    #exampleModal .payment-method-card img {
        width: 26px;
        height: 26px;
        object-fit: contain;
    }

    .fully-paid-status { color: #16a34a !important; font-weight: bold; }
    .partial-payment-status { color: #d97706 !important; font-weight: bold; }
    .unpaid-status { color: #dc2626 !important; font-weight: bold; }

    /* Sticky Footer */
    #exampleModal .modal-footer-sticky {
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

    /* Dark Mode Sticky Footer */
    body[light-mode="dark"] #exampleModal .modal-footer-sticky,
    html[light-mode="dark"] #exampleModal .modal-footer-sticky,
    body[data-layout-mode="dark"] #exampleModal .modal-footer-sticky,
    html.dark #exampleModal .modal-footer-sticky,
    body.dark #exampleModal .modal-footer-sticky,
    body.dark-mode #exampleModal .modal-footer-sticky {
        background: #0f172a !important;
        border-top: 1px solid #1e293b !important;
    }

    /* Flatpickr z-index in modal */
    .flatpickr-calendar {
        z-index: 999999 !important;
    }
</style>

<!-- Action Button Edit Modal Start -->
<section class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Sticky Green Header with White Text & Circular Red Close Icon -->
            <div style="background-color: #15803d; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 20; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-file-invoice" style="color: #ffffff; font-size: 18px;"></i>
                    <h2 style="font-size: 17px; font-weight: 700; color: #ffffff; margin: 0; padding: 0; line-height: 1.2;">Invoice & Due Update</h2>
                </div>
                <button type="button" data-bs-dismiss="modal" aria-label="Close" style="width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #dc2626; color: #ffffff; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.15s ease;" title="Close">
                    <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 14px;"></i>
                </button>
            </div>

            <!-- Scrollable Modal Body -->
            <div class="modal-body-scrollable">
                <form id="paymentForm" onsubmit="SavePaymentInfo(event)">
                    <input type="hidden" id="updateID">

                    <!-- Summary Info Box (English only, Dark mode compliant) -->
                    <div class="modal-summary-box p-3 mb-3">
                        <div class="row g-2 text-center" style="font-size: 13px;">
                            <div class="col-4 border-end">
                                <span class="summary-label d-block small fw-semibold">Invoice Subtotal</span>
                                <span class="fw-bold fs-6 text-dark" id="ShowSubTotalAmmount">৳ 0.00</span>
                            </div>
                            <div class="col-4 border-end">
                                <span class="summary-label d-block small fw-semibold">Previous Paid</span>
                                <span class="fw-bold fs-6 text-success" id="paidAmount">৳ 0.00</span>
                            </div>
                            <div class="col-4">
                                <span class="summary-label d-block small fw-semibold">Remaining Due</span>
                                <span class="fw-bold fs-6 text-danger" id="ShowtotalDuePayable">৳ 0.00</span>
                                <span id="CustomerDueAmount" class="d-none">0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Input Fields (English only, equal width & height) -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label-title" for="DueCollectionDate">Payment Date</label>
                            <input type="text" class="form-control" id="DueCollectionDate" placeholder="Select Date" required style="cursor: pointer;" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-title" for="UpdateDueAmountclear">Pay Due Amount (৳)</label>
                            <input type="number" step="any" class="form-control fw-bold text-success" id="UpdateDueAmountclear" oninput="calculateDuePayment()" placeholder="Enter Amount" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-title" for="UpdateDiscountAmountclear">Discount (৳)</label>
                            <input type="number" step="any" class="form-control fw-bold text-muted" value="0" id="UpdateDiscountAmountclear" oninput="calculateDuePayment()" placeholder="Enter Discount" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-title">Payment Status</label>
                            <div class="form-control status-display-box">
                                <span id="ShowpaymentStatusDisplay" class="fw-bold">Pending</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="mb-3">
                        <label class="form-label-title mb-2">Select Payment Method *</label>
                        <input type="hidden" id="selectedPaymentMethod" value="cash">

                        <div class="row g-2">
                            <div class="col-4 col-sm-4">
                                <div class="payment-method-card active" onclick="selectPaymentMethod('cash', this)">
                                    <img src="{{ asset('backend/assets/img/payment-cash.png') }}" alt="Cash" onerror="this.style.display='none'">
                                    <span class="fw-bold small">Cash</span>
                                </div>
                            </div>
                            <div class="col-4 col-sm-4">
                                <div class="payment-method-card" onclick="selectPaymentMethod('bkash', this)">
                                    <img src="{{ asset('backend/assets/img/payment-bkash.png') }}" alt="bKash" onerror="this.style.display='none'">
                                    <span class="fw-bold small">bKash</span>
                                </div>
                            </div>
                            <div class="col-4 col-sm-4">
                                <div class="payment-method-card" onclick="selectPaymentMethod('nagad', this)">
                                    <img src="{{ asset('backend/assets/img/payment-nagad.png') }}" alt="Nagad" onerror="this.style.display='none'">
                                    <span class="fw-bold small">Nagad</span>
                                </div>
                            </div>
                            <div class="col-4 col-sm-4">
                                <div class="payment-method-card" onclick="selectPaymentMethod('rocket', this)">
                                    <img src="{{ asset('backend/assets/img/payment-rocket.png') }}" alt="Rocket" onerror="this.style.display='none'">
                                    <span class="fw-bold small">Rocket</span>
                                </div>
                            </div>
                            <div class="col-4 col-sm-4">
                                <div class="payment-method-card" onclick="selectPaymentMethod('bank', this)">
                                    <img src="{{ asset('backend/assets/img/payment-bank.png') }}" alt="Bank" onerror="this.style.display='none'">
                                    <span class="fw-bold small">Bank</span>
                                </div>
                            </div>
                            <div class="col-4 col-sm-4">
                                <div class="payment-method-card" onclick="selectPaymentMethod('card', this)">
                                    <img src="{{ asset('backend/assets/img/payment-card.png') }}" alt="Card" onerror="this.style.display='none'">
                                    <span class="fw-bold small">Card</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction ID input (for digital methods) -->
                    <div class="mb-3" id="transactionInputWrapper" style="display: none;">
                        <label class="form-label-title" for="transactionInput">Transaction ID</label>
                        <input type="text" class="form-control" id="transactionInput" placeholder="Enter Transaction ID" />
                    </div>
                </form>
            </div>

            <!-- Sticky Bottom Footer with Red Cancel Button & Green Submit Button -->
            <div class="modal-footer-sticky">
                <button type="button" class="btn fw-bold px-4 py-2" data-bs-dismiss="modal" style="border-radius: 8px; background-color: #dc2626 !important; color: #ffffff !important; border: none; font-size: 14px; cursor: pointer; transition: opacity 0.2s;">
                    Cancel
                </button>
                <button type="button" onclick="SavePaymentInfo(event)" class="btn fw-bold px-4 py-2" style="border-radius: 8px; background-color: #15803d !important; color: #ffffff !important; border: none; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: opacity 0.2s;">
                    <i class="fa-solid fa-check"></i> Save Payment Info
                </button>
            </div>
        </div>
    </div>
</section>
<!-- Action Button Edit Modal End -->

<script>
    let dueDatePicker = null;

    function initDueDatePicker() {
        if (window.flatpickr) {
            dueDatePicker = flatpickr("#DueCollectionDate", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                altInputClass: "form-control",
                defaultDate: new Date().toISOString().split('T')[0],
                monthSelectorType: "static",
                disableMobile: true
            });
        } else {
            const today = new Date().toISOString().split('T')[0];
            const dateInput = document.getElementById('DueCollectionDate');
            if (dateInput) dateInput.value = today;
        }
    }

    $(document).ready(function() {
        $('#exampleModal').appendTo("body");

        initDueDatePicker();

        $('#exampleModal').on('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (button) {
                const id = $(button).attr('data-id') || $(button).data('id') || $(button).closest('[data-id]').attr('data-id');
                if (id) {
                    FillUpUpdateForm(id);
                }
            }
        });
    });

    function selectPaymentMethod(method, element) {
        document.querySelectorAll('.payment-method-card').forEach(el => el.classList.remove('active'));
        if (element) element.classList.add('active');
        document.getElementById('selectedPaymentMethod').value = method;

        const transWrapper = document.getElementById('transactionInputWrapper');
        if (method === 'cash') {
            if (transWrapper) transWrapper.style.display = 'none';
        } else {
            if (transWrapper) transWrapper.style.display = 'block';
            document.getElementById('transactionInput').placeholder = `Enter ${method.toUpperCase()} Transaction ID`;
        }
    }

    async function FillUpUpdateForm(id) {
        try {
            document.getElementById('updateID').value = id;

            // Reset date to today using flatpickr
            const today = new Date().toISOString().split('T')[0];
            if (dueDatePicker) {
                dueDatePicker.setDate(today, true);
            } else if (document.getElementById('DueCollectionDate')) {
                document.getElementById('DueCollectionDate').value = today;
            }

            let res = await axios.post("/api/invoice-payment-details-by-id", {
                id: id.toString()
            }, HeaderToken());

            if (res.data.status === "success") {
                const data = res.data.rows;

                const subTotal = parseFloat(data.sub_total) || 0;
                const paidAmount = parseFloat(data.paid_amount) || 0;
                const dueAmount = parseFloat(data.due_amount) || 0;

                document.getElementById('ShowSubTotalAmmount').textContent = `৳ ${subTotal.toFixed(2)}`;
                document.getElementById('paidAmount').textContent = `৳ ${paidAmount.toFixed(2)}`;
                document.getElementById('ShowtotalDuePayable').textContent = `৳ ${dueAmount.toFixed(2)}`;
                document.getElementById('CustomerDueAmount').textContent = dueAmount.toString();
                document.getElementById('UpdateDueAmountclear').value = dueAmount > 0 ? dueAmount : 0;
                document.getElementById('UpdateDiscountAmountclear').value = 0;

                calculateDuePayment();
            } else {
                console.error("Failed to fetch invoice details:", res.data.message);
            }
        } catch (e) {
            console.error("Error:", e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    function calculateDuePayment() {
        const initialDue = parseFloat(document.getElementById('CustomerDueAmount')?.textContent || 0);
        const payAmount = parseFloat(document.getElementById('UpdateDueAmountclear')?.value || 0);
        const discountAmount = parseFloat(document.getElementById('UpdateDiscountAmountclear')?.value || 0);

        const newRemainingDue = Math.max(0, initialDue - (payAmount + discountAmount));

        document.getElementById('ShowtotalDuePayable').textContent = `৳ ${newRemainingDue.toFixed(2)}`;

        const statusDisplay = document.getElementById('ShowpaymentStatusDisplay');
        if (statusDisplay) {
            statusDisplay.classList.remove("fully-paid-status", "partial-payment-status", "unpaid-status");

            if (newRemainingDue === 0) {
                statusDisplay.textContent = "Fully Paid";
                statusDisplay.classList.add("fully-paid-status");
            } else if (payAmount > 0) {
                statusDisplay.textContent = "Partial Paid";
                statusDisplay.classList.add("partial-payment-status");
            } else {
                statusDisplay.textContent = "Unpaid";
                statusDisplay.classList.add("unpaid-status");
            }
        }
    }

    async function SavePaymentInfo(event) {
        if (event) event.preventDefault();

        try {
            const payAmount = parseFloat(document.getElementById('UpdateDueAmountclear').value) || 0;
            const discountAmount = parseFloat(document.getElementById('UpdateDiscountAmountclear').value) || 0;
            const duePayableStr = document.getElementById('ShowtotalDuePayable').innerText.replace(/[^\d.-]/g, '');
            const finalDue = parseFloat(duePayableStr) || 0;
            const paymentStatus = document.getElementById('ShowpaymentStatusDisplay').innerText.trim();
            const collectionDate = document.getElementById('DueCollectionDate').value;
            const updateID = document.getElementById('updateID').value;
            const paymentMethod = document.getElementById('selectedPaymentMethod').value || 'cash';
            const transactionId = document.getElementById('transactionInput')?.value || null;

            if (payAmount < 0) {
                errorToast('Please enter a valid paid amount.');
                return false;
            }

            let formData = new FormData();
            formData.append('paid_amount', payAmount);
            formData.append('discount_amount', discountAmount);
            formData.append('due_amount', finalDue);
            formData.append('payment_status', paymentStatus);
            formData.append('due_collection_date', collectionDate);
            formData.append('transaction_id', transactionId);
            formData.append('id', updateID);
            formData.append('payment_method', paymentMethod);

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            showLoader();
            let res = await axios.post("/api/invoice-payment-details-update", formData, config);
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message);
                $("#exampleModal").modal('hide');
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
            errorToast("Failed to update payment information.");
        }
        return false;
    }
</script>