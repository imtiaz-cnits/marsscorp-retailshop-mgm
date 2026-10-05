<style>
    #editModal {
        z-index: 1060 !important;
        background: rgba(0, 0, 0, 0.65) !important;
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        display: none;
        align-items: center !important;
        justify-content: center !important;
        padding: 20px 10px !important;
        box-sizing: border-box !important;
    }
    #editModal .modal-dialog {
        background: transparent !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        text-align: left !important;
        max-width: 620px !important;
        width: 100% !important;
        max-height: 90vh !important;
        height: auto !important;
        margin: auto !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    @media screen and (max-width: 768px) {
        #editModal .modal-dialog {
            max-width: 95% !important;
            width: 95% !important;
            margin: auto !important;
        }
    }
    #editModal .modal-content {
        border-radius: 16px !important;
        overflow: hidden !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4) !important;
        background: #ffffff !important;
        text-align: left !important;
        max-height: 90vh !important;
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
        position: relative !important;
        transform: none !important;
        top: auto !important;
        left: auto !important;
    }
    body[light-mode="dark"] #editModal .modal-content,
    html[light-mode="dark"] #editModal .modal-content,
    body[data-layout-mode="dark"] #editModal .modal-content,
    html.dark #editModal .modal-content,
    body.dark #editModal .modal-content {
        background-color: #0f172a !important;
        border: 1px solid #1e293b !important;
    }
    body[light-mode="dark"] #editModal .modal-footer-sticky,
    html[light-mode="dark"] #editModal .modal-footer-sticky,
    body[data-layout-mode="dark"] #editModal .modal-footer-sticky,
    html.dark #editModal .modal-footer-sticky,
    body.dark #editModal .modal-footer-sticky {
        background-color: #0f172a !important;
        border-top-color: #1e293b !important;
    }
    #editModal .form-label-title {
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #334155 !important;
        margin-bottom: 6px !important;
        display: block !important;
        line-height: 1.3 !important;
        text-align: left !important;
    }
    body[light-mode="dark"] #editModal .form-label-title {
        color: #cbd5e1 !important;
    }
    #editModal input[type="text"],
    #editModal input[type="number"],
    #editModal input[type="date"] {
        width: 100% !important;
        height: 42px !important;
        font-size: 13.5px !important;
        color: #334155 !important;
        padding: 8px 14px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 8px !important;
        outline: none !important;
        background: #ffffff !important;
        transition: border-color 0.2s, box-shadow 0.2s !important;
        text-align: left !important;
        box-sizing: border-box !important;
    }
    #editModal input:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.2) !important;
    }
    body[light-mode="dark"] #editModal input[type="text"],
    body[light-mode="dark"] #editModal input[type="number"],
    body[light-mode="dark"] #editModal input[type="date"] {
        background-color: #1e293b !important;
        color: #f1f5f9 !important;
        border-color: #334155 !important;
    }
    #editModal .due-info-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        margin-bottom: 16px;
    }
    body[light-mode="dark"] #editModal .due-info-box {
        background: #1e293b;
        border-color: #334155;
    }
    #editModal .due-info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        font-size: 13px;
        border-bottom: 1px dashed #e2e8f0;
    }
    body[light-mode="dark"] #editModal .due-info-row {
        border-bottom-color: #334155;
    }
    #editModal .due-info-row:last-child {
        border-bottom: none;
    }
    .fully-paid-status {
        color: #15803d !important;
        font-weight: bold;
    }
    .partial-payment-status {
        color: #d97706 !important;
        font-weight: bold;
    }
    .unpaid-status {
        color: #dc2626 !important;
        font-weight: bold;
    }
</style>

<!-- Action Button Edit Modal Start -->
<div id="editModal" class="payment-edit modal" onclick="if(event.target===this) closeModal(this)">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Sticky Green Header with White Text & Red Close Icon -->
            <div style="background-color: #15803d; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 20; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <h2 style="font-size: 18px; font-weight: 700; color: #ffffff; margin: 0; padding: 0; line-height: 1.2;">Supplier Due collection</h2>
                <button type="button" class="close-btn close" onclick="closeModal(document.getElementById('editModal'))" style="position: static !important; width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #dc2626; color: #ffffff; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.15s ease; margin: 0; padding: 0;" title="Close">
                    <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 14px;"></i>
                </button>
            </div>

            <!-- Scrollable Body Content -->
            <div id="popup-modal" style="padding: 20px 24px; overflow-y: auto; flex: 1 1 auto; max-height: calc(90vh - 130px); text-align: left;">
                <form id="paymentForm">
                    <input type="hidden" id="updateID">

                    <!-- Date input with top-bottom padding -->
                    <div class="mb-3">
                        <label for="DueCollectionDate" class="form-label-title">Due collection Date</label>
                        <input type="date" name="" id="DueCollectionDate">
                    </div>

                    <!-- Due Info Summary Box -->
                    <div class="due-info-box">
                        <div class="due-info-row">
                            <span class="text-slate-600 dark:text-slate-300 font-medium">Supplier Previous Due</span>
                            <span id="SupplierPreviousDue" class="font-bold text-slate-800 dark:text-slate-100">৳ 0</span>
                        </div>
                        <div class="due-info-row">
                            <span class="text-slate-600 dark:text-slate-300 font-medium">Purchase Previous Due</span>
                            <span id="PurchasePreviousDue" class="font-bold text-slate-800 dark:text-slate-100">৳ 0</span>
                        </div>
                        <div class="due-info-row">
                            <span class="text-slate-700 dark:text-slate-200 font-bold">Total Previous Due</span>
                            <span id="TotalPreviousDue" class="font-bold text-emerald-600 dark:text-emerald-400">৳ 0</span>
                        </div>
                    </div>

                    <!-- Input Fields with top-bottom padding -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="DiscountAmount" class="form-label-title">Enter Discount Amount</label>
                            <input type="number" id="DiscountAmount" oninput="calculateDuePayment()" placeholder="Enter Discount">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="PayAmount" class="form-label-title">Enter Pay Amount</label>
                            <input type="number" id="PayAmount" oninput="calculateDuePayment()" placeholder="Enter Pay Amount">
                        </div>
                    </div>

                    <!-- Final Due & Status Box -->
                    <div class="due-info-box">
                        <div class="due-info-row">
                            <span class="text-slate-700 dark:text-slate-200 font-bold">Final Due Amount</span>
                            <span id="FinalDueAmount" class="font-bold text-rose-600 dark:text-rose-400 text-sm">৳ 0</span>
                        </div>
                        <div class="due-info-row">
                            <span class="text-slate-700 dark:text-slate-200 font-bold">Status</span>
                            <span id="ShowpaymentStatusDisplay" class="font-bold">Pending</span>
                        </div>
                    </div>
                </form>

                <!-- Payment Method Section -->
                <div id="payment">
                    <div class="payments mt-3">
                        <label class="form-label-title mb-2">Payment Method</label>
                        <form action="#">
                            <input type="radio" name="payment" id="cash" />
                            <input type="radio" name="payment" id="bkash" />
                            <input type="radio" name="payment" id="nagad" />
                            <input type="radio" name="payment" id="rocket" />
                            <input type="radio" name="payment" id="bank" />
                            <input type="radio" name="payment" id="mastercard" />

                            <div class="category-wrapper">
                                <div class="category">
                                    <label for="cash" class="cashMethod" onclick="toggleTransactionInput('cash')">
                                        <input type="radio" name="payment" id="cash" />
                                        <div class="imgName">
                                            <div class="imgContainer cash">
                                                <img src="{{ asset('backend/assets/img/payment-cash.png') }}" alt="" />
                                            </div>
                                            <h1>Cash</h1>
                                        </div>
                                        <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                                    </label>

                                    <label for="bkash" class="bkashMethod" onclick="toggleTransactionInput('bkash')">
                                        <div class="imgName">
                                            <div class="imgContainer bkash">
                                                <img src="{{ asset('backend/assets/img/payment-bkash.png') }}" alt="" />
                                            </div>
                                            <h1>bKash</h1>
                                        </div>
                                        <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                                    </label>

                                    <label for="nagad" class="nagadMethod">
                                        <div class="imgName">
                                            <div class="imgContainer nagad">
                                                <img src="{{ asset('backend/assets/img/payment-nagad.png') }}" alt="" />
                                            </div>
                                            <h1>Nagad</h1>
                                        </div>
                                        <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                                    </label>
                                    <input type="hidden" id="selectedPaymentMethod">

                                    <label for="rocket" class="rocketMethod">
                                        <div class="imgName">
                                            <div class="imgContainer rocket">
                                                <img src="{{ asset('backend/assets/img/payment-rocket.png') }}" alt="" />
                                            </div>
                                            <h1>Rocket</h1>
                                        </div>
                                        <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                                    </label>

                                    <label for="bank" class="bankMethod">
                                        <div class="imgName">
                                            <div class="imgContainer bank">
                                                <img src="{{ asset('backend/assets/img/payment-bank.png') }}" alt="" />
                                            </div>
                                            <h1>Bank</h1>
                                        </div>
                                        <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                                    </label>

                                    <label for="mastercard" class="mastercardMethod">
                                        <div class="imgName">
                                            <div class="imgContainer mastercard">
                                                <img src="{{ asset('backend/assets/img/payment-card.png') }}" alt="" />
                                            </div>
                                            <h1>Card</h1>
                                        </div>
                                        <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="transaction mt-2">
                        <label for="transactionInput" class="form-label-title">Transaction ID</label>
                        <input type="text" id="transactionInput" placeholder="Enter Transaction ID" />
                    </div>
                </div>
            </div>

            <!-- Sticky Bottom Footer with Submit Button -->
            <div style="padding: 12px 24px 16px; background: #ffffff; border-top: 1px solid #f1f5f9; flex-shrink: 0; position: sticky; bottom: 0; z-index: 20;" class="modal-footer-sticky submit-btn">
                <button type="submit" onclick="SavePaymentInfo(event)" class="submit btn-save" style="width: 100% !important; height: 42px !important; background-color: #15803d !important; color: #ffffff !important; border-radius: 8px !important; font-weight: 600 !important; font-size: 15px !important; border: none !important; cursor: pointer !important; display: flex; align-items: center; justify-content: center; transition: background-color 0.2s ease;">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- Action Button Edit Modal End -->
<script>
    // Call this function when the form is filled up to set the initial values

    // Function to open a modal by setting its display style to 'flex'
    function openModal(modal) {
        if (modal) {
            modal.style.display = 'flex';
        }
    }

    // Function to close a modal by setting its display style to 'none'
    function closeModal(modal) {
        if (modal) {
            modal.style.display = 'none';
        }
    }



async function FillUpUpdateForm(id) {
    try {
        document.getElementById('updateID').value = id;
        showLoader();

        // id here should be the DB 'id' of Supplier, not 'supplier_id'
        const res = await axios.post("/api/supplier-due-collection-details-by-id", {
            id: id.toString()
        }, HeaderToken());

        hideLoader();

        console.log("API response:", res.data);

        if (res.data.status === "success") {
            const supplier_due = parseFloat(res.data.supplier_due ?? 0);
            const purchase_due = parseFloat(res.data.purchase_due ?? 0);
            const total_due = parseFloat(res.data.total_due ?? 0);

            const formatCurrency = (num) => `৳${num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}`;

            document.getElementById('SupplierPreviousDue').textContent = formatCurrency(supplier_due);
            document.getElementById('PurchasePreviousDue').textContent = formatCurrency(purchase_due);
            document.getElementById('TotalPreviousDue').textContent = formatCurrency(total_due);
            document.getElementById('TotalPreviousDue').dataset.raw = total_due;

            document.getElementById('DiscountAmount').value = '';
            document.getElementById('PayAmount').value = '';
            document.getElementById('FinalDueAmount').textContent = formatCurrency(total_due);
            document.getElementById('ShowpaymentStatusDisplay').textContent = 'Pending';

            openModal(document.getElementById('editModal'));
        } else {
            alert('❌ Error: Supplier data not found.');
        }
    } catch (error) {
        hideLoader();
        console.error("❌ API Error:", error);
        alert('Something went wrong. Please try again later.');
    }
}



    // function calculateDuePayment() {
    //     const totalPreviousDue = parseFloat(document.getElementById('TotalPreviousDue').dataset.raw) || 0;
    //     const discount = parseFloat(document.getElementById('DiscountAmount').value) || 0;
    //     const payAmount = parseFloat(document.getElementById('PayAmount').value) || 0;

    //     // Calculate final due amount
    //     let finalDue = totalPreviousDue - (discount + payAmount);
    //     if (finalDue < 0) finalDue = 0;

    //     // Update FinalDueAmount text
    //     document.getElementById('FinalDueAmount').textContent = `৳${finalDue.toFixed(2)}`;

    //     // Update payment status
    //     const statusEl = document.getElementById('ShowpaymentStatusDisplay');
    //     statusEl.classList.remove("fully-paid-status", "partial-payment-status", "unpaid-status");

    //     if (finalDue === 0 && (discount + payAmount) > 0) {
    //         statusEl.textContent = "Fully Paid";
    //         statusEl.classList.add("fully-paid-status");
    //     } else if (finalDue > 0 && (discount + payAmount) > 0) {
    //         statusEl.textContent = "Partial Paid";
    //         statusEl.classList.add("partial-payment-status");
    //     } else {
    //         statusEl.textContent = "Unpaid";
    //         statusEl.classList.add("unpaid-status");
    //     }
    // }

function calculateDuePayment() {
    const totalPreviousDue = parseFloat(document.getElementById('TotalPreviousDue').dataset.raw) || 0;
    const discount = parseFloat(document.getElementById('DiscountAmount').value) || 0;
    const payAmount = parseFloat(document.getElementById('PayAmount').value) || 0;

    const totalInput = discount + payAmount;

    // Get submit button
    const submitBtn = document.querySelector('.submit-btn .submit');

    if (totalInput > totalPreviousDue) {
        alert("The amount you paid is more than the Total Previous Due Amount.");
        submitBtn.style.visibility = 'hidden';
    } else {
        submitBtn.style.visibility = 'visible';
    }

    // Calculate final due amount
    let finalDue = totalPreviousDue - totalInput;
    if (finalDue < 0) finalDue = 0;

    // Update FinalDueAmount text
    document.getElementById('FinalDueAmount').textContent = `৳${finalDue.toFixed(2)}`;

    // Update payment status
    const statusEl = document.getElementById('ShowpaymentStatusDisplay');
    statusEl.classList.remove("fully-paid-status", "partial-payment-status", "unpaid-status");

    if (finalDue === 0 && totalInput > 0) {
        statusEl.textContent = "Fully Paid";
        statusEl.classList.add("fully-paid-status");
    } else if (finalDue > 0 && totalInput > 0) {
        statusEl.textContent = "Partial Paid";
        statusEl.classList.add("partial-payment-status");
    } else {
        statusEl.textContent = "Unpaid";
        statusEl.classList.add("unpaid-status");
    }
}



    function toggleTransactionInput(paymentMethod) {
        const transactionInput = document.getElementById('transactionInput');
        const transactionWrapper = document.querySelector('.transaction');

        // Show the transaction input field if the selected payment method requires it
        if (paymentMethod === 'cash') {
            transactionInput.style.display = 'none';
        } else {
            transactionInput.style.display = 'block';
        }

        // Add the selected payment method to a hidden input or directly to the form data later
        document.getElementById('selectedPaymentMethod').value = paymentMethod;
    }





    const paymentMethods = document.querySelectorAll(".category label");
    const transactionInput = document.getElementById("transactionInput");

    // Add an event listener to all payment methods
    paymentMethods.forEach((method) => {
        method.addEventListener("click", () => {
            // Remove 'active' class from all methods
            paymentMethods.forEach((m) => m.classList.remove("active"));

            // Add 'active' class to the clicked method
            method.classList.add("active");

            // Show or hide the input field based on the selected method
            if (method.classList.contains("cashMethod")) {
                transactionInput.style.display = "none"; // Hide input for cash
            } else {
                transactionInput.style.display = "block"; // Show input for others

                // Change the placeholder text based on the selected method
                if (method.classList.contains("bkashMethod")) {
                    transactionInput.placeholder = "Enter BKash Transaction ID";
                } else if (method.classList.contains("nagadMethod")) {
                    transactionInput.placeholder = "Enter Nagad Transaction ID";
                } else if (method.classList.contains("rocketMethod")) {
                    transactionInput.placeholder = "Enter Rocket Transaction ID";
                } else if (method.classList.contains("bankMethod")) {
                    transactionInput.placeholder = "Enter Bank Transaction ID";
                } else if (method.classList.contains("mastercardMethod")) {
                    transactionInput.placeholder = "Enter Card Transaction ID";
                } else {
                    transactionInput.placeholder = "Enter Transaction ID";
                }
            }
        });
    });


    async function SavePaymentInfo(event) {
        event.preventDefault();

        try {
            const PayAmount = parseFloat(document.getElementById('PayAmount').value) || 0;
            const DiscountAmount = parseFloat(document.getElementById('DiscountAmount').value) || 0;

            // Fixed: Use correct elements that exist in your Blade
            const SupplierPreviousDue = parseFloat(document.getElementById('SupplierPreviousDue').innerText.replace(/[^\d.-]/g, '')) || 0;
            const PurchasePreviousDue = parseFloat(document.getElementById('PurchasePreviousDue').innerText.replace(/[^\d.-]/g, '')) || 0;

            const TotalPreviousDue = parseFloat(document.getElementById('TotalPreviousDue').dataset.raw) || 0;

            const dueAmount = TotalPreviousDue - (PayAmount + DiscountAmount);
            const transactionId = document.getElementById('transactionInput').value;
            const paymentStatus = document.getElementById('ShowpaymentStatusDisplay').innerText.trim();
            const updateID = parseInt(document.getElementById('updateID').value) || 0;
            const paymentMethod = document.querySelector('input[name="payment"]:checked')?.id;

            // Validation
            if (!PayAmount) return errorToast('Please enter the pay amount.');
            if (!paymentStatus) return errorToast('Payment status is missing.');
            if (!paymentMethod) return errorToast('Please select a payment method.');

            let formData = new FormData();
            formData.append('id', updateID);
            formData.append('paid_amount', PayAmount);
            formData.append('due_amount', dueAmount > 0 ? dueAmount : 0);
            formData.append('purchase_payable_amount', PurchasePreviousDue);
            formData.append('supplier_previous_due', SupplierPreviousDue);
            formData.append('due_collection_date', document.getElementById('DueCollectionDate').value);
            formData.append('discount_amount', DiscountAmount);
            formData.append('payment_status', paymentStatus);
            formData.append('transaction_id', transactionId);
            formData.append('payment_method', paymentMethod);

            showLoader();
            let res = await axios.post("/api/supplier-payment-details-update", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            });
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message);
                closeModal(document.getElementById('editModal'));
                window.location.reload();
            } else {
                errorToast(res.data.message);
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            unauthorized(e.response?.status || 500);
        }
    }
</script>

<script>
    // Set today's date in YYYY-MM-DD format
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('DueCollectionDate').value = today;
</script>