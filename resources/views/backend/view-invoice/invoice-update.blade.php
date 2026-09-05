<style>
    #exampleModal {
        z-index: 1060 !important;
    }
    #exampleModal .modal-dialog {
        max-width: 650px;
        margin: 1.75rem auto;
    }
    #exampleModal .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }
    #exampleModal .payment-method-card {
        cursor: pointer;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px 14px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff;
    }
    #exampleModal .payment-method-card:hover {
        border-color: #0d9488;
        background: #f0fdf4;
    }
    #exampleModal .payment-method-card.active {
        border-color: #16a34a !important;
        background: #f0fdf4 !important;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15);
    }
    #exampleModal .payment-method-card img {
        width: 28px;
        height: 28px;
        object-fit: contain;
    }
    .fully-paid-status { color: #16a34a; font-weight: bold; }
    .partial-payment-status { color: #d97706; font-weight: bold; }
    .unpaid-status { color: #dc2626; font-weight: bold; }
</style>

<!-- Action Button Edit Modal Start -->
<section class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header border-0 pb-2">
                <h5 class="modal-title fw-bold text-success d-flex align-items-center gap-2" id="exampleModalLabel">
                    <i class="fa-solid fa-file-invoice"></i>
                    <span>Invoice & Due Update (ইনভয়েস পরিশোধ ও বকেয়া আপডেট)</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pt-0">
                <form id="paymentForm" onsubmit="SavePaymentInfo(event)">
                    <input type="hidden" id="updateID">

                    <!-- Summary Info Box -->
                    <div class="bg-light p-3 rounded-4 mb-3 border">
                        <div class="row g-2 text-center" style="font-size: 13px;">
                            <div class="col-4 border-end">
                                <span class="text-muted d-block small">ইনভয়েস সাবটোটাল</span>
                                <span class="fw-bold fs-6 text-dark" id="ShowSubTotalAmmount">৳ 0.00</span>
                            </div>
                            <div class="col-4 border-end">
                                <span class="text-muted d-block small">পূর্বের পরিশোধ</span>
                                <span class="fw-bold fs-6 text-success" id="paidAmount">৳ 0.00</span>
                            </div>
                            <div class="col-4">
                                <span class="text-muted d-block small">অবশিষ্ট বকেয়া</span>
                                <span class="fw-bold fs-6 text-danger" id="ShowtotalDuePayable">৳ 0.00</span>
                                <span id="CustomerDueAmount" class="d-none">0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Input Fields -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary mb-1">পরিশোধের তারিখ (Date)</label>
                            <input type="date" class="form-control" id="DueCollectionDate" required style="height: 44px; border-radius: 8px;" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary mb-1">জমা টাকার পরিমাণ (Pay Due ৳)</label>
                            <input type="number" step="any" class="form-control fw-bold text-success" id="UpdateDueAmountclear" oninput="calculateDuePayment()" placeholder="Enter Amount" required style="height: 44px; border-radius: 8px;" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary mb-1">অতিরিক্ত ছাড় (Discount ৳)</label>
                            <input type="number" step="any" class="form-control fw-bold text-muted" value="0" id="UpdateDiscountAmountclear" oninput="calculateDuePayment()" placeholder="Enter Discount" style="height: 44px; border-radius: 8px;" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary mb-1">পেমেন্ট স্ট্যাটাস (Status)</label>
                            <div class="form-control bg-light d-flex align-items-center fw-bold" style="height: 44px; border-radius: 8px;">
                                <span id="ShowpaymentStatusDisplay">Pending</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary mb-2">পেমেন্ট মাধ্যম সিলেক্ট করুন (Payment Method) *</label>
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
                        <label class="form-label small fw-bold text-secondary mb-1">ট্রানজ্যাকশন আইডি (Transaction ID)</label>
                        <input type="text" class="form-control" id="transactionInput" placeholder="Enter Transaction ID" style="height: 44px; border-radius: 8px;" />
                    </div>

                    <!-- Footer Actions -->
                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-light px-4 py-2 fw-bold text-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="border-radius: 8px; background-color: #15803d; border: none;">
                            <i class="fa-solid fa-check me-1"></i> Save Payment Info
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Action Button Edit Modal End -->

<script>
    $(document).ready(function() {
        $('#exampleModal').appendTo("body");

        // Set default date to today
        const today = new Date().toISOString().split('T')[0];
        if (document.getElementById('DueCollectionDate')) {
            document.getElementById('DueCollectionDate').value = today;
        }

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