<style>
    #editModal .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .fully-paid-status {
        color: green;
        font-weight: bold;
    }

    .partial-payment-status {
        color: orange;
        font-weight: bold;
    }

    .unpaid-status {
        color: red;
        font-weight: bold;
    }
</style>

<!-- Action Button Edit Modal Start -->
<div id="editModal" class="payment-edit modal">
    <div class="modal-content">
        <a class="close-btn close">
            <i class="fa-solid fa-xmark"></i>
        </a>
        <h2 class="heading">Supplier Due collection</h2>
        <div class="table-wrapper">
            <form id="paymentForm">
                <div class="totals">
                    <div class="subtotal mb-3">
                        <span>Due collection Date</span>
                        <input type="date" name="" id="DueCollectionDate">
                    </div>
                    <div class="subtotal">
                        <span>Supplier Previous Due</span>
                        <span id="SupplierPreviousDue">৳ 0</span>
                    </div>
                    <div class="subtotal">
                        <span>Purchase Previous Due</span>
                        <span id="PurchasePreviousDue">৳ 0</span>
                    </div>
                    <div class="subtotal">
                        <span>Total Previous Due</span>
                        <span id="TotalPreviousDue">৳ 0</span>
                    </div>
                    <div class="subtotal">
                        <span>Enter Discount Amount</span>
                        <input type="number" id="DiscountAmount" oninput="calculateDuePayment()" placeholder="Enter Discount">
                    </div>
                    <div class="subtotal">
                        <span>Enter Pay Amount</span>
                        <input type="number" id="PayAmount" oninput="calculateDuePayment()" placeholder="Enter Pay Amount">
                    </div>
                    <div class="total">
                        <span>Final Due Amount</span>
                        <span id="FinalDueAmount">৳ 0</span>
                    </div>
                    <div class="total">
                        <span>Status</span>
                        <span id="ShowpaymentStatusDisplay">Pending</span>
                    </div>
                </div>
                <input type="hidden" id="updateID">

            </form>
            <div id="payment">

                <div class="payments">
                    <div class="heading">
                        <h2>Payment Method</h2>
                    </div>
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
                                            <img src="{{ asset('backend/assets/img/payment-cash.png') }}"
                                                alt="" />
                                        </div>
                                        <h1>Cash</h1>
                                    </div>
                                    <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                                </label>

                                <label for="bkash" class="bkashMethod" onclick="toggleTransactionInput('bkash')">
                                    <div class="imgName">
                                        <div class="imgContainer bkash">
                                            <img src="{{ asset('backend/assets/img/payment-bkash.png') }}"
                                                alt="" />
                                        </div>
                                        <h1>bKash</h1>
                                    </div>
                                    <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                                </label>

                                <label for="nagad" class="nagadMethod">
                                    <div class="imgName">
                                        <div class="imgContainer nagad">
                                            <img src="{{ asset('backend/assets/img/payment-nagad.png') }}"
                                                alt="" />
                                        </div>
                                        <h1>Nagad</h1>
                                    </div>
                                    <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                                </label>
                                <input type="hidden" id="selectedPaymentMethod">

                                <label for="rocket" class="rocketMethod">
                                    <div class="imgName">
                                        <div class="imgContainer rocket">
                                            <img src="{{ asset('backend/assets/img/payment-rocket.png') }}"
                                                alt="" />
                                        </div>
                                        <h1>Rocket</h1>
                                    </div>
                                    <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                                </label>

                                <label for="bank" class="bankMethod">
                                    <div class="imgName">
                                        <div class="imgContainer bank">
                                            <img src="{{ asset('backend/assets/img/payment-bank.png') }}"
                                                alt="" />
                                        </div>
                                        <h1>Bank</h1>
                                    </div>
                                    <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                                </label>

                                <label for="mastercard" class="mastercardMethod">
                                    <div class="imgName">
                                        <div class="imgContainer mastercard">
                                            <img src="{{ asset('backend/assets/img/payment-card.png') }}"
                                                alt="" />
                                        </div>
                                        <h1>Card</h1>
                                    </div>
                                    <span class="check"><i class="fa-solid fa-circle-check"></i></span>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="transaction">
                    <input type="text" id="transactionInput" placeholder="Enter Transaction ID" />
                </div>
                <div class="submit-btn">
                    <button type="submit" onclick="SavePaymentInfo(event)" class="submit">SUBMIT</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Action Button Edit Modal End -->
<script>
    // Call this function when the form is filled up to set the initial values

    // Function to open a modal by setting its display style to 'block'
    function openModal(modal) {
        if (modal) {
            modal.style.display = 'block';
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