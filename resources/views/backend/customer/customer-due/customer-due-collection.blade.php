<!-- Action Button Due Collection Modal Start -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg my-3" style="max-height: 90vh;">
        <div class="modal-content bg-white dark:bg-slate-900 border-0 rounded-2xl shadow-2xl overflow-hidden transition-colors flex flex-col" style="max-height: 90vh; border: none !important;">
            
            <!-- Sticky Top Green Header -->
            <div class="modal-header sticky top-0 z-20 px-4 sm:px-5 py-3.5 bg-emerald-700 text-white flex items-center justify-between shadow-sm border-0 flex-shrink-0" style="background-color: #15803d !important; color: #ffffff !important; border: none !important;">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <line x1="2" y1="10" x2="22" y2="10"></line>
                        </svg>
                    </div>
                    <h5 class="modal-title text-base sm:text-lg font-bold text-white tracking-tight mb-0" id="editModalLabel" style="color: #ffffff !important;">Customer Due Collection</h5>
                </div>
                <!-- Circular Red Close Button with White Icon -->
                <button type="button" class="qv-close-btn" data-bs-dismiss="modal" onclick="closeModal(document.getElementById('editModal'))" aria-label="Close" style="width: 30px !important; height: 30px !important; min-width: 30px !important; min-height: 30px !important; border-radius: 50% !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important; display: flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; padding: 0 !important; margin: 0 !important;">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Scrollable Modal Body -->
            <div class="modal-body p-4 sm:p-6 overflow-y-auto custom-scrollbar flex-1" style="max-height: calc(90vh - 125px);">
                
                <!-- Financial Due Summary Cards Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 mb-4">
                    <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-center">
                        <span class="block text-[10px] font-semibold text-slate-400 dark:text-slate-400 uppercase tracking-wider mb-1">Previous Due</span>
                        <span id="PreviousDue" class="text-sm sm:text-base font-bold text-slate-800 dark:text-slate-100">৳ 0</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-center">
                        <span class="block text-[10px] font-semibold text-slate-400 dark:text-slate-400 uppercase tracking-wider mb-1">Order Due</span>
                        <span id="OrderDue" class="text-sm sm:text-base font-bold text-slate-800 dark:text-slate-100">৳ 0</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-rose-50 dark:bg-slate-800 border border-rose-200 dark:border-slate-700 text-center">
                        <span class="block text-[10px] font-semibold text-rose-600 dark:text-rose-400 uppercase tracking-wider mb-1">Total Due</span>
                        <span id="TotalDue" class="text-sm sm:text-base font-bold text-rose-600 dark:text-rose-400">৳ 0</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-emerald-50 dark:bg-slate-800 border border-emerald-200 dark:border-slate-700 text-center">
                        <span class="block text-[10px] font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-1">Remaining Due</span>
                        <span id="ShowtotalDuePayable" class="text-sm sm:text-base font-bold text-emerald-700 dark:text-emerald-300">৳ 0</span>
                    </div>
                </div>

                <!-- Hidden Reference Elements -->
                <span id="MyTotalDueAmount" style="display: none;">৳ 0</span>
                <span id="PreviousDueAmount" style="display: none;">৳ 0</span>
                <span id="ShowDiscountAmount" style="display: none;">৳ 0</span>
                <input type="hidden" id="updateID">
                <input type="hidden" id="selectedPaymentMethod" value="cash">

                <!-- Collection Inputs Grid -->
                <form id="paymentForm" onsubmit="return false;" class="space-y-3.5 mb-4">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Date -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5">Collection Date</label>
                            <div class="unified-ui-border h-[42px] flex items-center px-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20 transition-all">
                                <input type="date" id="DueCollectionDate" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 p-0 focus:ring-0" style="border: none !important; outline: none !important; box-shadow: none !important;" />
                            </div>
                        </div>
                        <!-- Pay Amount -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5">Pay Amount <span class="text-rose-500">*</span></label>
                            <div class="unified-ui-border h-[42px] flex items-center px-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20 transition-all">
                                <input type="number" step="any" id="UpdateDueAmountclear" oninput="calculateDuePayment()" placeholder="Enter Pay Amount" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 p-0 focus:ring-0 font-bold" style="border: none !important; outline: none !important; box-shadow: none !important;" />
                            </div>
                        </div>
                        <!-- Discount -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5">Discount Amount</label>
                            <div class="unified-ui-border h-[42px] flex items-center px-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20 transition-all">
                                <input type="number" step="any" value="0" id="UpdateDiscountAmountclear" oninput="calculateDuePayment()" placeholder="0.00" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 p-0 focus:ring-0" style="border: none !important; outline: none !important; box-shadow: none !important;" />
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status Badge Indicator -->
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-300">Payment Status:</span>
                        <span id="ShowpaymentStatusDisplay" class="badge px-3 py-1 font-bold text-xs bg-amber-500 text-white rounded-full">Pending</span>
                    </div>
                </form>

                <!-- Payment Methods Section -->
                <div class="pt-2 border-t border-slate-200 dark:border-slate-800">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-2.5">Select Payment Method</label>
                    
                    <div class="grid grid-cols-3 sm:grid-cols-6 gap-2 payment-method-grid">
                        <!-- Cash -->
                        <label for="cash" class="method-card cashMethod cursor-pointer flex flex-col items-center justify-center p-2.5 rounded-xl unified-ui-border bg-white dark:bg-slate-800 transition-all hover:border-emerald-500 active">
                            <input type="radio" name="payment" id="cash" checked class="hidden" />
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mb-1">
                                <img src="{{ asset('backend/assets/img/payment-cash.png') }}" class="w-7 h-7 object-contain" alt="Cash" onerror="this.src='{{ asset('backend/assets/img/brand-defult-img.svg') }}'" />
                            </div>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200">Cash</span>
                        </label>

                        <!-- bKash -->
                        <label for="bkash" class="method-card bkashMethod cursor-pointer flex flex-col items-center justify-center p-2.5 rounded-xl unified-ui-border bg-white dark:bg-slate-800 transition-all hover:border-emerald-500">
                            <input type="radio" name="payment" id="bkash" class="hidden" />
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mb-1">
                                <img src="{{ asset('backend/assets/img/payment-bkash.png') }}" class="w-7 h-7 object-contain" alt="bKash" onerror="this.src='{{ asset('backend/assets/img/brand-defult-img.svg') }}'" />
                            </div>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200">bKash</span>
                        </label>

                        <!-- Nagad -->
                        <label for="nagad" class="method-card nagadMethod cursor-pointer flex flex-col items-center justify-center p-2.5 rounded-xl unified-ui-border bg-white dark:bg-slate-800 transition-all hover:border-emerald-500">
                            <input type="radio" name="payment" id="nagad" class="hidden" />
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mb-1">
                                <img src="{{ asset('backend/assets/img/payment-nagad.png') }}" class="w-7 h-7 object-contain" alt="Nagad" onerror="this.src='{{ asset('backend/assets/img/brand-defult-img.svg') }}'" />
                            </div>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200">Nagad</span>
                        </label>

                        <!-- Rocket -->
                        <label for="rocket" class="method-card rocketMethod cursor-pointer flex flex-col items-center justify-center p-2.5 rounded-xl unified-ui-border bg-white dark:bg-slate-800 transition-all hover:border-emerald-500">
                            <input type="radio" name="payment" id="rocket" class="hidden" />
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mb-1">
                                <img src="{{ asset('backend/assets/img/payment-rocket.png') }}" class="w-7 h-7 object-contain" alt="Rocket" onerror="this.src='{{ asset('backend/assets/img/brand-defult-img.svg') }}'" />
                            </div>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200">Rocket</span>
                        </label>

                        <!-- Bank -->
                        <label for="bank" class="method-card bankMethod cursor-pointer flex flex-col items-center justify-center p-2.5 rounded-xl unified-ui-border bg-white dark:bg-slate-800 transition-all hover:border-emerald-500">
                            <input type="radio" name="payment" id="bank" class="hidden" />
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mb-1">
                                <img src="{{ asset('backend/assets/img/payment-bank.png') }}" class="w-7 h-7 object-contain" alt="Bank" onerror="this.src='{{ asset('backend/assets/img/brand-defult-img.svg') }}'" />
                            </div>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200">Bank</span>
                        </label>

                        <!-- Card -->
                        <label for="mastercard" class="method-card mastercardMethod cursor-pointer flex flex-col items-center justify-center p-2.5 rounded-xl unified-ui-border bg-white dark:bg-slate-800 transition-all hover:border-emerald-500">
                            <input type="radio" name="payment" id="mastercard" class="hidden" />
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mb-1">
                                <img src="{{ asset('backend/assets/img/payment-card.png') }}" class="w-7 h-7 object-contain" alt="Card" onerror="this.src='{{ asset('backend/assets/img/brand-defult-img.svg') }}'" />
                            </div>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200">Card</span>
                        </label>
                    </div>

                    <!-- Transaction ID Field (Hidden for Cash) -->
                    <div class="transaction-input-wrap mt-3" style="display: none;">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5">Transaction ID</label>
                        <div class="unified-ui-border h-[42px] flex items-center px-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20 transition-all">
                            <input type="text" id="transactionInput" placeholder="Enter Transaction ID" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 p-0 focus:ring-0" style="border: none !important; outline: none !important; box-shadow: none !important;" />
                        </div>
                    </div>
                </div>

            </div>

            <!-- Sticky Bottom Footer with Red Cancel & Green Submit Buttons (Strict 38px height) -->
            <div class="modal-footer sticky bottom-0 z-20 px-4 sm:px-5 py-3 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 flex items-center justify-end gap-2.5 flex-shrink-0">
                <button type="button" class="px-4 h-[38px] min-h-[38px] max-h-[38px] rounded-xl text-white text-xs sm:text-sm font-semibold transition-all shadow-sm flex items-center justify-center cursor-pointer hover:bg-red-700 active:scale-[0.98]" data-bs-dismiss="modal" onclick="closeModal(document.getElementById('editModal'))" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important;">
                    Cancel
                </button>
                <button type="button" onclick="SavePaymentInfo(event)" class="px-5 h-[38px] min-h-[38px] max-h-[38px] rounded-xl text-white text-xs sm:text-sm font-semibold transition-all shadow-sm flex items-center justify-center cursor-pointer hover:bg-emerald-600 active:scale-[0.98]" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; background-color: #15803d !important; color: #ffffff !important; border: none !important;">
                    Submit Collection
                </button>
            </div>

        </div>
    </div>
</div>
<!-- Action Button Due Collection Modal End -->

<style>
    #editModal .modal-dialog {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
    #editModal .modal-content {
        border: none !important;
    }
    body[light-mode="dark"] #editModal .modal-content {
        background-color: #0f172a !important;
        border: 1px solid #334155 !important;
    }
    .method-card.active {
        border-color: #16a34a !important;
        background-color: #f0fdf4 !important;
        box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.25) !important;
    }
    body[light-mode="dark"] .method-card.active {
        background-color: rgba(22, 163, 74, 0.15) !important;
        border-color: #22c55e !important;
    }
</style>

<script>
    function openModal(modal) {
        if (modal) {
            $('#editModal').modal('show');
        }
    }

    function closeModal(modal) {
        $('#editModal').modal('hide');
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
                    previousDueElement.innerText = `৳ ${data.previous_due || '0.00'}`;
                }

                let previousDueHidden = document.getElementById('PreviousDueAmount');
                if (previousDueHidden) {
                    previousDueHidden.innerText = `৳ ${data.previous_due || '0.00'}`;
                }

                // Update Order Due
                let orderDueElement = document.getElementById('OrderDue');
                if (orderDueElement) {
                    orderDueElement.innerText = `৳ ${data.order_due || '0.00'}`;
                }

                // Update Total Due
                let totalDueElement = document.getElementById('TotalDue');
                if (totalDueElement) {
                    totalDueElement.innerText = `৳ ${data.total_due || '0.00'}`;
                }

                let myTotalDue = document.getElementById('MyTotalDueAmount');
                if (myTotalDue) {
                    myTotalDue.innerText = `৳ ${data.total_due || '0.00'}`;
                }

                // Set default Payable amount to Total Due
                let showTotalDuePayable = document.getElementById('ShowtotalDuePayable');
                if (showTotalDuePayable) {
                    showTotalDuePayable.innerText = `৳ ${data.total_due || '0.00'}`;
                }

                // Reset inputs
                document.getElementById('UpdateDueAmountclear').value = '';
                document.getElementById('UpdateDiscountAmountclear').value = '0';
                document.getElementById('transactionInput').value = '';

                // Default Payment Status
                const paymentStatusDisplay = document.getElementById('ShowpaymentStatusDisplay');
                paymentStatusDisplay.textContent = "Pending";
                paymentStatusDisplay.className = "badge px-3 py-1 font-bold text-xs bg-amber-500 text-white rounded-full";

                // Default Payment Method: Cash
                selectPaymentMethodOption('cash');

                $('#editModal').modal('show');
            } else {
                console.error("Failed to fetch invoice details:", res.data.message);
                errorToast(res.data.message || "Failed to fetch customer due details.");
            }
        } catch (e) {
            hideLoader();
            console.error("Error:", e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    function calculateDuePayment() {
        const totalDueText = document.getElementById('TotalDue').innerText || '0';
        const totalDueAmount = parseFloat(totalDueText.replace(/[^\d.-]/g, '')) || 0;

        const enteredAmount = parseFloat(document.getElementById('UpdateDueAmountclear').value) || 0;
        const discountAmount = parseFloat(document.getElementById('UpdateDiscountAmountclear').value) || 0;

        const totalPaidWithDiscount = enteredAmount + discountAmount;
        const newTotalDue = parseFloat((totalDueAmount - totalPaidWithDiscount).toFixed(2));
        const finalDueAmount = newTotalDue >= 0 ? newTotalDue : 0;

        document.getElementById('ShowtotalDuePayable').textContent = `৳ ${finalDueAmount.toFixed(2)}`;

        const paymentStatusDisplay = document.getElementById('ShowpaymentStatusDisplay');
        if (finalDueAmount === 0 && enteredAmount > 0) {
            paymentStatusDisplay.textContent = "Fully Paid";
            paymentStatusDisplay.className = "badge px-3 py-1 font-bold text-xs bg-emerald-600 text-white rounded-full";
        } else if (enteredAmount > 0 && finalDueAmount < totalDueAmount) {
            paymentStatusDisplay.textContent = "Partial Paid";
            paymentStatusDisplay.className = "badge px-3 py-1 font-bold text-xs bg-blue-600 text-white rounded-full";
        } else {
            paymentStatusDisplay.textContent = "Unpaid";
            paymentStatusDisplay.className = "badge px-3 py-1 font-bold text-xs bg-rose-600 text-white rounded-full";
        }

        const showDiscount = document.getElementById('ShowDiscountAmount');
        if (showDiscount) {
            showDiscount.textContent = `৳ ${discountAmount.toFixed(2)}`;
        }
    }

    function selectPaymentMethodOption(methodId) {
        $('.method-card').removeClass('active');
        $(`.${methodId}Method`).addClass('active');
        $(`#${methodId}`).prop('checked', true);

        const transactionWrap = $('.transaction-input-wrap');
        const transactionInput = $('#transactionInput');
        $('#selectedPaymentMethod').val(methodId);

        if (methodId === 'cash') {
            transactionWrap.hide();
        } else {
            transactionWrap.show();
            let label = methodId.toUpperCase();
            transactionInput.attr('placeholder', `Enter ${label} Transaction ID`);
        }
    }

    function toggleTransactionInput(paymentMethod) {
        selectPaymentMethodOption(paymentMethod);
    }

    $(document).ready(function() {
        $('#editModal').appendTo("body");

        // Set default date to today
        const today = new Date().toISOString().split('T')[0];
        const dateInput = document.getElementById('DueCollectionDate');
        if (dateInput && !dateInput.value) {
            dateInput.value = today;
        }

        // Method card click
        $(document).on('click', '.method-card', function() {
            const inputId = $(this).find('input[type="radio"]').attr('id');
            if (inputId) {
                selectPaymentMethodOption(inputId);
            }
        });
    });

    async function SavePaymentInfo(event) {
        if (event) event.preventDefault();

        try {
            const paidAmount = parseFloat(document.getElementById('UpdateDueAmountclear').value) || 0;
            const DiscountAmount = parseFloat(document.getElementById('UpdateDiscountAmountclear').value) || 0;
            const PreviousDue = parseFloat(document.getElementById('PreviousDue').innerText.replace(/[^\d.-]/g, '')) || 0;
            const dueAmount = parseFloat(document.getElementById('ShowtotalDuePayable').innerText.replace(/[^\d.-]/g, '')) || 0;
            const transactionId = document.getElementById('transactionInput').value;
            const CollectionDate = document.getElementById('DueCollectionDate').value;
            const paymentStatus = document.getElementById('ShowpaymentStatusDisplay').innerText;
            const updateID = parseInt(document.getElementById('updateID').value);
            const paymentMethod = document.getElementById('selectedPaymentMethod').value || 'cash';

            if (!paidAmount || paidAmount <= 0) {
                errorToast('Please enter a valid pay amount.');
                return;
            }
            if (!paymentStatus) {
                errorToast('Payment status is missing.');
                return;
            }

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
                $('#editModal').modal('hide');
                if (typeof getList === 'function') {
                    currentPage = 1;
                    await getList();
                } else {
                    setTimeout(() => window.location.reload(), 500);
                }
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
