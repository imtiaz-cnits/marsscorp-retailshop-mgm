<style>
    #editModal .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
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
                    <div class="subtotal">
                        <span>Previous Due Amount</span>
                        <span id="PreviousDue">৳ 0</span>
                    </div>
                    <div class="subtotal" style="display: none;">
                        <span>Previous Due Amount</span>
                        <span id="PreviousDueAmount">৳ 0</span>
                    </div>
                    <div class="subtotal">
                        <span> Enter Pay Amount</span>
                        <input type="number" id="UpdateDueAmountclear" oninput="calculateDuePayment()"
                            placeholder="Enter Pay Amount">
                    </div>
                    <div class="total">
                        <span>Due Amount</span>
                        <span id="ShowtotalDuePayable">৳0</span>
                    </div>
                    <div class="total">
                        <span>Status</span>
                        <span id="ShowpaymentStatusDisplay"></span>
                    </div>
                </div>
            </form>

            <div id="payment">
                <input type="hidden" id="updateID">

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
            // Set the brand id in the hidden input
            document.getElementById('updateID').value = id;
            showLoader();

            // Fetch the brand data by ID
            let res = await axios.post("/api/supplier-due-collection-details-by-id", {
                id: id.toString()
            }, HeaderToken());

            hideLoader();

            if (res.data.status === "success") {
                const data = res.data.rows;

                // Populate the modal with the fetched data
                document.getElementById('PreviousDue').textContent = `৳${data.purchase_payable_amount}`;
                document.getElementById('PreviousDueAmount').textContent = `৳${data.purchase_payable_amount}`;
                document.getElementById('ShowtotalDuePayable').textContent = `৳${data.purchase_payable_amount}`;
                document.getElementById('ShowpaymentStatusDisplay').textContent = data.payment_status || "Pending";
                document.getElementById('selectedPaymentMethod').textContent = data.payment_method ||
                    ""; // Populate payment method
                openModal(document.getElementById('editModal'));

            } else {
                console.error("Failed to fetch invoice details:", res.data.message);
            }
        } catch (e) {
            hideLoader(); // Ensure loader is hidden on error
            console.error("Error:", e); // Log the error for debugging
            unauthorized(e.response ? e.response.status : 500); // Handle unauthorized errors
        }
    }


    function calculateDuePayment() {
    // Always get the original previous due amount from the correct element
    const previousDueAmount = parseFloat(document.getElementById('PreviousDueAmount').innerText.replace(/[^\d.-]/g, '')) || 0;
    const enteredAmount = parseFloat(document.getElementById('UpdateDueAmountclear').value) || 0;

    // Calculate the new total due by subtracting entered amount from previous due
    const newTotalDue = parseFloat((previousDueAmount - enteredAmount).toFixed(2));

    // Prevent negative due amount
    const finalDueAmount = newTotalDue >= 0 ? newTotalDue : 0;

    // Update the UI
    document.getElementById('ShowtotalDuePayable').textContent = `৳${finalDueAmount.toFixed(2)}`;

    // Update payment status
    const paymentStatusDisplay = document.getElementById('ShowpaymentStatusDisplay');
    paymentStatusDisplay.classList.remove("fully-paid-status", "partial-payment-status", "unpaid-status");

    if (finalDueAmount === 0) {
        paymentStatusDisplay.textContent = "Fully Paid";
        paymentStatusDisplay.classList.add("fully-paid-status");
    } else if (finalDueAmount < previousDueAmount) {
        paymentStatusDisplay.textContent = "Partial Paid";
        paymentStatusDisplay.classList.add("partial-payment-status");
    } else {
        paymentStatusDisplay.textContent = "Unpaid";
        paymentStatusDisplay.classList.add("unpaid-status");
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
        const paidAmount = parseFloat(document.getElementById('UpdateDueAmountclear').value) || 0;
        const PreviousDue = parseFloat(document.getElementById('PreviousDue').innerText.replace(/[^\d.-]/g, '')) || 0; // Get the PreviousDue value
        const dueAmount = parseFloat(document.getElementById('ShowtotalDuePayable').innerText.replace(/[^\d.-]/g, '')) || 0;
        const transactionId = document.getElementById('transactionInput').value;
        const paymentStatus = document.getElementById('ShowpaymentStatusDisplay').innerText;
        const updateID = parseInt(document.getElementById('updateID').value); // ✅ Ensures integer
        const paymentMethod = document.querySelector('input[name="payment"]:checked')?.id;

        if (!paidAmount) return errorToast('Please update the due amount.');
        if (!paymentStatus) return errorToast('Payment status is missing.');
        if (!paymentMethod) return errorToast('Please select a payment method.');

        let formData = new FormData();
        formData.append('id', updateID); // ✅ Integer ID
        formData.append('paid_amount', paidAmount);
        formData.append('due_amount', dueAmount);
        formData.append('purchase_payable_amount', PreviousDue);
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
