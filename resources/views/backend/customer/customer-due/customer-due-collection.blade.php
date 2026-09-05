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
        <h2 class="heading">Customer Due collection</h2>
        <div class="table-wrapper">

            <form id="paymentForm">
                <div class="totals">
                    <div class="subtotal mb-3">
                        <span>Due collection Date</span>
                        <input type="date" name="" id="DueCollectionDate">
                    </div>
                    <div class="subtotal">
                        <span>Previous Due Amount</span>
                        <span id="PreviousDue">৳ 0</span>
                    </div>
                    <div class="subtotal">
                        <span>Order Due Amount</span>
                        <span id="OrderDue">৳ 0</span>
                    </div>

                    <div class="total">
                        <span>Total Due Amount</span>
                        <span id="TotalDue">৳ 0</span>
                    </div>
                    <div class="total" style="display: none;">
                        <span>Total Due Amount</span>
                        <span id="MyTotalDueAmount">৳ 0</span>
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
                    <div class="subtotal">
                        <span> Enter Discount Amount</span>
                        <input type="number" value="0" id="UpdateDiscountAmountclear" oninput="calculateDiscountPayment()"
                            placeholder="Enter Discount Amount">
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

            let res = await axios.post("/api/customer-due-collection-details-by-id", {
                id: id.toString()
            }, HeaderToken());

            hideLoader();

            if (res.data.status === "success") {
                const data = res.data;

                // Update Previous Due
                let previousDueElement = document.getElementById('PreviousDue');
                if (previousDueElement) {
                    previousDueElement.innerText = `৳ ${data.previous_due}`;
                }

                // Also update hidden Previous Due Amount (if needed)
                let previousDueHidden = document.getElementById('PreviousDueAmount');
                if (previousDueHidden) {
                    previousDueHidden.innerText = `৳ ${data.previous_due}`;
                }

                // Update Order Due
                let orderDueElement = document.getElementById('OrderDue');
                if (orderDueElement) {
                    orderDueElement.innerText = `৳ ${data.order_due}`;
                }

                // Update Total Due
                let totalDueElement = document.getElementById('TotalDue');
                if (totalDueElement) {
                    totalDueElement.innerText = `৳ ${data.total_due}`;
                }

                // Set the default Payable amount to Total Due
                let showTotalDuePayable = document.getElementById('ShowtotalDuePayable');
                if (showTotalDuePayable) {
                    showTotalDuePayable.innerText = `৳ ${data.total_due}`;
                }

                // Default Payment Status
                document.getElementById('ShowpaymentStatusDisplay').textContent = "Pending";

                openModal(document.getElementById('editModal'));
            } else {
                console.error("Failed to fetch invoice details:", res.data.message);
            }
        } catch (e) {
            hideLoader();
            console.error("Error:", e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }


    // function calculateDuePayment() {
    //     // Always get the Total Due Amount
    //     const totalDueAmount = parseFloat(document.getElementById('TotalDue').innerText.replace(/[^\d.-]/g, '')) || 0;

    //     // Get entered Pay Amount
    //     const enteredAmount = parseFloat(document.getElementById('UpdateDueAmountclear').value) || 0;

    //     // Get entered Discount Amount
    //     const discountAmount = parseFloat(document.getElementById('UpdateDiscountAmountclear').value) || 0;

    //     // Make sure discount does not exceed total due
    //     const applicableDiscount = discountAmount <= totalDueAmount ? discountAmount : totalDueAmount;

    //     // New Due Amount = Total Due - Pay Amount - Discount
    //     const newTotalDue = parseFloat((totalDueAmount - enteredAmount - applicableDiscount).toFixed(2));

    //     // Prevent negative amount
    //     const finalDueAmount = newTotalDue >= 0 ? newTotalDue : 0;

    //     // Update Due Amount in HTML
    //     document.getElementById('ShowtotalDuePayable').textContent = `৳${finalDueAmount.toFixed(2)}`;

    //     // Update Payment Status
    //     const paymentStatusDisplay = document.getElementById('ShowpaymentStatusDisplay');
    //     paymentStatusDisplay.classList.remove("fully-paid-status", "partial-payment-status", "unpaid-status");

    //     if (finalDueAmount === 0) {
    //         paymentStatusDisplay.textContent = "Fully Paid";
    //         paymentStatusDisplay.classList.add("fully-paid-status");
    //     } else if (finalDueAmount < totalDueAmount) {
    //         paymentStatusDisplay.textContent = "Partial Paid";
    //         paymentStatusDisplay.classList.add("partial-payment-status");
    //     } else {
    //         paymentStatusDisplay.textContent = "Unpaid";
    //         paymentStatusDisplay.classList.add("unpaid-status");
    //     }
    // }

    // // Discount input also recalculates
    // document.getElementById('UpdateDiscountAmountclear').addEventListener('input', calculateDuePayment);




    // function toggleTransactionInput(paymentMethod) {
    //     const transactionInput = document.getElementById('transactionInput');
    //     const transactionWrapper = document.querySelector('.transaction');

    //     // Show the transaction input field if the selected payment method requires it
    //     if (paymentMethod === 'cash') {
    //         transactionInput.style.display = 'none';
    //     } else {
    //         transactionInput.style.display = 'block';
    //     }

    //     // Add the selected payment method to a hidden input or directly to the form data later
    //     document.getElementById('selectedPaymentMethod').value = paymentMethod;
    // }

    // const paymentMethods = document.querySelectorAll(".category label");
    // const transactionInput = document.getElementById("transactionInput");

    // // Add an event listener to all payment methods
    // paymentMethods.forEach((method) => {
    //     method.addEventListener("click", () => {
    //         // Remove 'active' class from all methods
    //         paymentMethods.forEach((m) => m.classList.remove("active"));

    //         // Add 'active' class to the clicked method
    //         method.classList.add("active");

    //         // Show or hide the input field based on the selected method
    //         if (method.classList.contains("cashMethod")) {
    //             transactionInput.style.display = "none"; // Hide input for cash
    //         } else {
    //             transactionInput.style.display = "block"; // Show input for others

    //             // Change the placeholder text based on the selected method
    //             if (method.classList.contains("bkashMethod")) {
    //                 transactionInput.placeholder = "Enter BKash Transaction ID";
    //             } else if (method.classList.contains("nagadMethod")) {
    //                 transactionInput.placeholder = "Enter Nagad Transaction ID";
    //             } else if (method.classList.contains("rocketMethod")) {
    //                 transactionInput.placeholder = "Enter Rocket Transaction ID";
    //             } else if (method.classList.contains("bankMethod")) {
    //                 transactionInput.placeholder = "Enter Bank Transaction ID";
    //             } else if (method.classList.contains("mastercardMethod")) {
    //                 transactionInput.placeholder = "Enter Card Transaction ID";
    //             } else {
    //                 transactionInput.placeholder = "Enter Transaction ID";
    //             }
    //         }
    //     });
    // });

    // async function SavePaymentInfo(event) {
    //     event.preventDefault();

    //     try {
    //         const paidAmount = parseFloat(document.getElementById('UpdateDueAmountclear').value) || 0;
    //         const DiscountAmount = parseFloat(document.getElementById('UpdateDiscountAmountclear').value) || 0;
    //         const PreviousDue = parseFloat(document.getElementById('PreviousDue').innerText.replace(/[^\d.-]/g, '')) || 0; // Get the PreviousDue value
    //         const dueAmount = parseFloat(document.getElementById('ShowtotalDuePayable').innerText.replace(/[^\d.-]/g, '')) || 0;
    //         const transactionId = document.getElementById('transactionInput').value;
    //         const CollectionDate = document.getElementById('DueCollectionDate').value;
    //         const paymentStatus = document.getElementById('ShowpaymentStatusDisplay').innerText;
    //         const updateID = parseInt(document.getElementById('updateID').value);
    //         const paymentMethod = document.querySelector('input[name="payment"]:checked')?.id;

    //         if (!paidAmount) return errorToast('Please update the due amount.');
    //         if (!paymentStatus) return errorToast('Payment status is missing.');
    //         if (!paymentMethod) return errorToast('Please select a payment method.');

    //         let formData = new FormData();
    //         formData.append('id', updateID);
    //         formData.append('paid_amount', paidAmount);
    //         formData.append('discount_amount', DiscountAmount);
    //         formData.append('due_amount', dueAmount);
    //         formData.append('previous_due_amount', PreviousDue);
    //         formData.append('due_collection_date', CollectionDate);
    //         formData.append('payment_status', paymentStatus);
    //         formData.append('transaction_id', transactionId);
    //         formData.append('payment_method', paymentMethod);

    //         showLoader();
    //         let res = await axios.post("/api/customer-payment-details-update", formData, {
    //             headers: {
    //                 'Content-Type': 'multipart/form-data',
    //                 ...HeaderToken().headers
    //             }
    //         });
    //         hideLoader();

    //         if (res.data.status === "success") {
    //             successToast(res.data.message);
    //             closeModal(document.getElementById('editModal'));
    //             window.location.reload();
    //         } else {
    //             errorToast(res.data.message);
    //         }
    //     } catch (e) {
    //         hideLoader();
    //         console.error(e);
    //         unauthorized(e.response?.status || 500);
    //     }
    // }



// Function to calculate Due Payment
// function calculateDuePayment() {
//     // Always get the Total Due Amount
//     const totalDueAmount = parseFloat(document.getElementById('TotalDue').innerText.replace(/[^\d.-]/g, '')) || 0;

//     // Get entered Pay Amount
//     const enteredAmount = parseFloat(document.getElementById('UpdateDueAmountclear').value) || 0;

//     // Get entered Discount Amount
//     const discountAmount = parseFloat(document.getElementById('UpdateDiscountAmountclear').value) || 0;

//     // New Due Amount = Total Due - Pay Amount (Discount is not deducted from the due)
//     const newTotalDue = parseFloat((totalDueAmount - enteredAmount).toFixed(2));

//     // Prevent negative amount for the due
//     const finalDueAmount = newTotalDue >= 0 ? newTotalDue : 0;

//     // Update Due Amount in HTML
//     document.getElementById('ShowtotalDuePayable').textContent = `৳${finalDueAmount.toFixed(2)}`;

//     // Update Payment Status
//     const paymentStatusDisplay = document.getElementById('ShowpaymentStatusDisplay');
//     paymentStatusDisplay.classList.remove("fully-paid-status", "partial-payment-status", "unpaid-status");

//     if (finalDueAmount === 0) {
//         paymentStatusDisplay.textContent = "Fully Paid";
//         paymentStatusDisplay.classList.add("fully-paid-status");
//     } else if (finalDueAmount < totalDueAmount) {
//         paymentStatusDisplay.textContent = "Partial Paid";
//         paymentStatusDisplay.classList.add("partial-payment-status");
//     } else {
//         paymentStatusDisplay.textContent = "Unpaid";
//         paymentStatusDisplay.classList.add("unpaid-status");
//     }

//     // Show Discount Amount in HTML
//     document.getElementById('ShowDiscountAmount').textContent = `৳${discountAmount.toFixed(2)}`;
// }


function calculateDuePayment() {
    // Always get the Total Due Amount
    const totalDueAmount = parseFloat(document.getElementById('TotalDue').innerText.replace(/[^\d.-]/g, '')) || 0;

    // Get entered Pay Amount
    const enteredAmount = parseFloat(document.getElementById('UpdateDueAmountclear').value) || 0;

    // Get entered Discount Amount
    const discountAmount = parseFloat(document.getElementById('UpdateDiscountAmountclear').value) || 0;

    // New Due Amount = Total Due - (Pay + Discount)
    const totalPaidWithDiscount = enteredAmount + discountAmount;
    const newTotalDue = parseFloat((totalDueAmount - totalPaidWithDiscount).toFixed(2));

    // Prevent negative amount for the due
    const finalDueAmount = newTotalDue >= 0 ? newTotalDue : 0;

    // Update Due Amount in HTML
    document.getElementById('ShowtotalDuePayable').textContent = `৳${finalDueAmount.toFixed(2)}`;

    // Update Payment Status
    const paymentStatusDisplay = document.getElementById('ShowpaymentStatusDisplay');
    paymentStatusDisplay.classList.remove("fully-paid-status", "partial-payment-status", "unpaid-status");

    if (finalDueAmount === 0) {
        paymentStatusDisplay.textContent = "Fully Paid";
        paymentStatusDisplay.classList.add("fully-paid-status");
    } else if (finalDueAmount < totalDueAmount) {
        paymentStatusDisplay.textContent = "Partial Paid";
        paymentStatusDisplay.classList.add("partial-payment-status");
    } else {
        paymentStatusDisplay.textContent = "Unpaid";
        paymentStatusDisplay.classList.add("unpaid-status");
    }

    // Show Discount Amount in HTML
    document.getElementById('ShowDiscountAmount').textContent = `৳${discountAmount.toFixed(2)}`;
}


// Discount input also recalculates
document.getElementById('UpdateDiscountAmountclear').addEventListener('input', calculateDuePayment);

// Function to toggle the transaction input field based on selected payment method
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

// Add event listeners to payment methods
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

// Function to Save Payment Information
async function SavePaymentInfo(event) {
    event.preventDefault();

    try {
        const paidAmount = parseFloat(document.getElementById('UpdateDueAmountclear').value) || 0;
        const DiscountAmount = parseFloat(document.getElementById('UpdateDiscountAmountclear').value) || 0;
        const PreviousDue = parseFloat(document.getElementById('PreviousDue').innerText.replace(/[^\d.-]/g, '')) || 0; // Get the PreviousDue value
        const dueAmount = parseFloat(document.getElementById('ShowtotalDuePayable').innerText.replace(/[^\d.-]/g, '')) || 0;
        const transactionId = document.getElementById('transactionInput').value;
        const CollectionDate = document.getElementById('DueCollectionDate').value;
        const paymentStatus = document.getElementById('ShowpaymentStatusDisplay').innerText;
        const updateID = parseInt(document.getElementById('updateID').value);
        const paymentMethod = document.querySelector('input[name="payment"]:checked')?.id;

        if (!paidAmount) return errorToast('Please update the due amount.');
        if (!paymentStatus) return errorToast('Payment status is missing.');
        if (!paymentMethod) return errorToast('Please select a payment method.');

        let formData = new FormData();
        formData.append('id', updateID);
        formData.append('paid_amount', paidAmount);
        formData.append('discount_amount', DiscountAmount);
        formData.append('due_amount', dueAmount);
        formData.append('previous_due_amount', PreviousDue);
        formData.append('due_collection_date', CollectionDate);
        formData.append('payment_status', paymentStatus);
        formData.append('transaction_id', transactionId);
        formData.append('payment_method', paymentMethod);

        showLoader();
        let res = await axios.post("/api/customer-payment-details-update", formData, {
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


















