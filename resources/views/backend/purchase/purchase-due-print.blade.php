<style>
    #editModal .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>



<div id="editModal" class="payment-edit modal">
    <div class="modal-content">
        <a class="close-btn close" onclick="closeModal(document.getElementById('editModal'));">
            <i class="fa-solid fa-xmark"></i>
        </a>
        <h2 class="heading">Purchase Payment</h2>

        <form id="paymentForm">
            <div class="totals">
                <div class="subtotal">
                    <span>Purchase ID</span>
                    <span id="modalPurchaseId">৳ 0.00</span>
                </div>
                <div class="subtotal">
                    <span>Sub-Total</span>
                    <span id="ShowSubTotalAmount">৳ 0.00</span>
                </div>
                <div class="subtotal">
                    <span>Paid Amount</span>
                    <span id="paidAmountData">৳ 0</span>
                </div>
                <div class="subtotal">
                    <span>Enter Payment Amount</span>
                    <input type="number" id="UpdatePaidAmount" oninput="calculateDuePayment()"
                        placeholder="Enter Paid Amount">
                </div>
                <div class="total">
                    <span>Due Amount</span>
                    <span id="ShowTotalDue">৳0</span>
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
                                        <img src="{{ asset('backend/assets/img/payment-cash.png') }}" alt="" />
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
            <div class="transaction">
                <input type="text" id="transactionInput" placeholder="Enter Transaction ID" />
            </div>
            <div class="submit-btn">
                <button type="submit" onclick="SavePaymentInfo(event)" class="submit">SUBMIT</button>
            </div>
        </div>

    </div>
</div>




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

// async function FillUpUpdateForm(id) {
//     try {
//         document.getElementById('updateID').value = id;

//         showLoader();

//         // Fetch the brand data by ID
//         let res = await axios.post("/api/purchase-payment-details-by-id", {
//             id: id.toString()
//         }, HeaderToken());

//         hideLoader();

//         if (res.data.status === "success") {
//             const data = res.data.purchase;

//             console.log(res.data);

//             // Ensure values are properly formatted
//             let grandSubtotal = parseFloat(data.grand_subtotal) || 0;
//             let paidAmount = parseFloat(res.data.paid_amount) || 0;  // Ensure this is fetched correctly
//             let dueAmount = parseFloat(res.data.due_amount) || 0;

//             // Update the displayed values in the modal
//             document.getElementById('ShowSubTotalAmount').textContent = `৳ ${grandSubtotal.toFixed(2)}`;
//             document.getElementById('paidAmountData').textContent = `৳ ${paidAmount.toFixed(2)}`; // Ensure the paid amount is updated correctly
//             document.getElementById('ShowTotalDue').textContent = `৳ ${dueAmount.toFixed(2)}`;

//             // Open the modal
//             openModal(document.getElementById('editModal'));
//         } else {
//             console.error("Failed to fetch payment details:", res.data.message);
//         }
//     } catch (e) {
//         console.error("Error:", e);
//     }
// }

async function FillUpUpdateForm(id) {
    try {
        if (!id) return errorToast("Invalid Purchase ID");

        // ID সেভ
        const updateID = document.getElementById('updateID');
        if (updateID) updateID.value = id;

        showLoader();

        const res = await axios.post("/api/purchase-payment-details-by-id", { id }, HeaderToken());
        hideLoader();

        if (res.data.status === "success") {
            const d = res.data;

            // null-safe এলিমেন্ট সেট
            const setText = (id, value) => {
                const el = document.getElementById(id);
                if (el) el.textContent = value || 'N/A';
            };

            setText('modalPurchaseId', d.purchase_id);
            setText('modalDate', d.date);
            setText('modalReference', d.referance_no);

            $('#ShowSubTotalAmount').text(`৳ ${parseFloat(d.grand_total || 0).toFixed(2)}`);
            $('#paidAmountData').text(`৳ ${parseFloat(d.paid_amount || 0).toFixed(2)}`);
            $('#ShowTotalDue').text(`৳ ${parseFloat(d.due_amount || 0).toFixed(2)}`);

            const due = parseFloat(d.due_amount || 0);
            const paidInput = document.getElementById('UpdatePaidAmount');

            if (due <= 0) {
                if (paidInput) {
                    paidInput.disabled = true;
                    paidInput.value = '';
                    paidInput.placeholder = 'Fully Paid';
                }
                $('input[name="payment"]').prop('disabled', true);
                $('#transactionInput').prop('disabled', true);
                $('#submitPaymentBtn').prop('disabled', true).text('Fully Paid');
                successToast(`Purchase ${d.purchase_id} is fully paid!`);
            } else {
                if (paidInput) {
                    paidInput.disabled = false;
                    paidInput.value = '';
                    paidInput.max = due;
                    paidInput.placeholder = `Max: ৳${due.toFixed(2)}`;
                }
                $('input[name="payment"]').prop('disabled', false);
                $('#transactionInput').prop('disabled', false);
                $('#submitPaymentBtn').prop('disabled', false).text('Submit Payment');
            }

            openModal(document.getElementById('editModal'));

        } else {
            errorToast(res.data.message || "Failed to load data");
        }

    } catch (e) {
        hideLoader();
        console.error("Error:", e);
        errorToast("Server error. Please refresh page.");
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

// Add an event listener to all payment methods safely
if (paymentMethods && transactionInput) {
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
}

const paymentStatusDisplay = document.getElementById('ShowpaymentStatusDisplay');

function updatePaymentStatusDisplay(newDueAmount, ShowSubTotalAmmount) {
    if (newDueAmount === 0) {
        paymentStatusDisplay.textContent = "Fully Paid";
        paymentStatusDisplay.classList.remove("partial-payment-status", "unpaid-status");
        paymentStatusDisplay.classList.add("fully-paid-status");
    } else if (newDueAmount > 0 && newDueAmount < ShowSubTotalAmmount) {
        paymentStatusDisplay.textContent = "Partial Paid";
        paymentStatusDisplay.classList.add("partial-payment-status");
        paymentStatusDisplay.classList.remove("fully-paid-status", "unpaid-status");
    } else {
        paymentStatusDisplay.textContent = "Unpaid";
        paymentStatusDisplay.classList.remove("partial-payment-status", "fully-paid-status");
        paymentStatusDisplay.classList.add("unpaid-status");
    }
}

function calculateDuePayment() {
    let paidAmountInput = parseFloat(document.getElementById('UpdatePaidAmount').value) || 0;
    let subTotal = parseFloat(document.getElementById('ShowSubTotalAmount').innerText.replace('৳', '')) || 0;
    let paidAmountData = parseFloat(document.getElementById('paidAmountData').innerText.replace('৳', '')) || 0;

    let newTotalPaid = paidAmountData + paidAmountInput;
    let newDueAmount = subTotal - newTotalPaid;

    if (newTotalPaid > subTotal) {
        document.getElementById('UpdatePaidAmount').value = (subTotal - paidAmountData).toFixed(2);
        newDueAmount = 0;
    }

    document.getElementById('ShowTotalDue').textContent = `৳${newDueAmount.toFixed(2)}`;
    updatePaymentStatusDisplay(newDueAmount, subTotal);
}

async function SavePaymentInfo(event) {
    event.preventDefault();

    try {
        const paidAmount = parseFloat(document.getElementById('UpdatePaidAmount').value) || 0;
        const currentDue = parseFloat(document.getElementById('ShowTotalDue').textContent.replace('৳', '').trim()) || 0;
        const purchaseId = document.getElementById('updateID').value; // integer id
        const transactionId = document.getElementById('transactionInput').value.trim();
        const method = document.querySelector('input[name="payment"]:checked')?.id;

        if (paidAmount <= 0 || paidAmount > currentDue) {
            return errorToast(`Amount must be 0.01 to ৳${currentDue.toFixed(2)}`);
        }
        if (!method) return errorToast("Select payment method");
        if (method !== 'cash' && !transactionId) return errorToast("Transaction ID required");

        showLoader();

        const res = await axios.post("/api/update-purchase-payment", {
            id: purchaseId,
            paid_amount: paidAmount,
            payment_method: method,
            transaction_id: transactionId || null
        }, HeaderToken());

        hideLoader();

        if (res.data.status === "success") {
            successToast("Payment added successfully!");

            // Due & Paid আপডেট করো (রিলোড ছাড়াই)
            $('#paidAmountData').text(`৳ ${res.data.new_paid?.toFixed(2) || (parseFloat($('#paidAmountData').text().replace('৳', '')) + paidAmount).toFixed(2)}`);
            $('#ShowTotalDue').text(`৳ ${res.data.new_due?.toFixed(2) || (currentDue - paidAmount).toFixed(2)}`);

            // Due 0 হলে ডিজেবল
            if (res.data.new_due <= 0) {
                $('#UpdatePaidAmount, input[name="payment"], #transactionInput').prop('disabled', true);
                $('#submitPaymentBtn').prop('disabled', true).text('Fully Paid');
            }

            closeModal(document.getElementById('editModal'));
            refreshPurchaseList(); // লিস্ট রিফ্রেশ

        } else {
            errorToast(res.data.message || "Failed");
        }

    } catch (e) {
        hideLoader();
        errorToast("Server error. Try again.");
        console.error(e);
    }
}

// async function SavePaymentInfo(event) {
//     event.preventDefault();  // Prevent the form from reloading the page

//     try {
//         // Get the necessary values from the DOM
//         const UpdateDueAmountclear = parseFloat(document.getElementById('UpdatePaidAmount').value) || 0;
//         const ShowtotalDuePayable = parseFloat(document.getElementById('ShowTotalDue').textContent.replace('৳', '').trim()) || 0;
//         const transactionInput = document.getElementById('transactionInput').value.trim();
//         const ShowpaymentStatusDisplay = document.getElementById('ShowpaymentStatusDisplay').innerText;
//         const updateID = document.getElementById('updateID').value;
//         const selectedPaymentMethod = document.querySelector('input[name="payment"]:checked')?.id;

//         // Validation checks
//         if (UpdateDueAmountclear <= 0) {
//             return errorToast('Please enter a valid paid amount.');
//         }


//         if (!ShowpaymentStatusDisplay) {
//             return errorToast('Please display the payment status.');
//         }

//         if (!selectedPaymentMethod) {
//             return errorToast('Please select a payment method.');
//         }

//         // Ensure that transaction ID is entered when needed (for methods other than cash)
//         if (selectedPaymentMethod !== 'cash' && !transactionInput) {
//             return errorToast('Please enter a transaction ID.');
//         }

//         // Prepare form data
//         let formData = new FormData();
//         formData.append('paid_amount', UpdateDueAmountclear);
//         formData.append('due_amount', ShowtotalDuePayable);
//         formData.append('payment_status', ShowpaymentStatusDisplay);
//         formData.append('transaction_id', transactionInput);
//         formData.append('id', updateID);
//         formData.append('payment_method', selectedPaymentMethod);

//         // Set the request configuration with headers
//         const config = {
//             headers: {
//                 'Content-Type': 'multipart/form-data',
//                 ...HeaderToken().headers // Add authorization headers
//             }
//         };

//         showLoader(); // Show loader when submitting

//         // Make the request to update the payment details
//         let res = await axios.post("/api/update-purchase-payment", formData, config);
//         hideLoader(); // Hide loader after request completion

//         if (res.data.status === "success") {
//             successToast(res.data.message);
//             closeModal(document.getElementById('editModal'));  // Close the modal after success
//             window.location.reload();  // Reload the page after the update
//         } else {
//             errorToast(res.data.message);
//         }

//     } catch (e) {
//         console.error('Error:', e);
//         unauthorized(e.response?.status); // Handle unauthorized or other errors
//     }
// }

</script>

