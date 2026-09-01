This is my js code->
   async function SavePaymentInfo(event) {
        event.preventDefault();  // Prevent the form from reloading the page

        try {
            const UpdateDueAmountclear = parseFloat(document.getElementById('UpdateDueAmountclear').value) || 0;
            const UpdateDiscountAmountclear = parseFloat(document.getElementById('UpdateDiscountAmountclear').value) || 0;
            const ShowtotalDuePayable = parseFloat(document.getElementById('ShowtotalDuePayable').innerText.replace('৳', '')) || 0;
            const transactionInput = document.getElementById('TransactionNo').value; // Transaction ID field
            const ShowpaymentStatusDisplay = document.getElementById('ShowpaymentStatusDisplay').innerText;
            const updateID = document.getElementById('updateID').value;
            const selectedPaymentMethod = document.getElementById('PaymentMethodSelect').value; // Get selected payment method

            if (!UpdateDueAmountclear) {
                return errorToast('Please update the due amount.');
            }

            if (!ShowpaymentStatusDisplay) {
                return errorToast('Please display the payment status.');
            }

            if (!selectedPaymentMethod) {
                return errorToast('Please select a payment method.');
            }

            // Prepare form data
            let formData = new FormData();
            formData.append('paid_amount', UpdateDueAmountclear);
            formData.append('due_amount', ShowtotalDuePayable);
            formData.append('discount_amount', UpdateDiscountAmountclear);
            formData.append('payment_status', ShowpaymentStatusDisplay);
            formData.append('transaction_id', transactionInput);
            formData.append('id', updateID);
            formData.append('payment_method', selectedPaymentMethod);

            // Set the request configuration with headers
            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    ...HeaderToken().headers // Add authorization headers
                }
            };

            showLoader(); // Show loader when submitting

            // Make the request to update the customer payment
            let res = await axios.post("/api/customer-payment-details-update", formData, config);

            hideLoader(); // Hide loader after request completion

            if (res.data.status === "success") {
                successToast(res.data.message);
                const updatemodal1 = document.getElementById('editModal');
                closeModal(updatemodal1);  // Close the modal
                window.location.reload();  // Reload the page after the update
            } else {
                errorToast(res.data.message);
            }

        } catch (e) {
            unauthorized(e.response.status); // Handle unauthorized or other errors
        }
    }

This is my controller code->  
 public function CustomerPaymentDetailsUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id = Auth::id();
            $customer = Customer::findOrFail($request->input('id'));

            $inputPaidAmount = $request->paid_amount ?? 0;
            $paymentMethod = $request->payment_method ?? null;
            $inputDiscountAmount = $request->discount_amount ?? 0;
            $dueCollectionDate = $request->due_collection_date ?? null;
            $transactionId = $request->transaction_id ?? null;

            $totalAvailablePaid = $inputPaidAmount;

            // Check if there are any due invoices for this customer
            $dueOrders = Invoice::where('customer_id', $customer->id)
                ->where('due_amount', '>', 0)
                ->orderBy('created_at', 'asc')  // Process the oldest invoice first
                ->get();

            if ($dueOrders->isEmpty()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'No due invoices found for this customer.'
                ]);
            }

            // Calculate the total due amount
            $totalDueAmount = $dueOrders->sum('due_amount');

            // If there's due amount, start applying the payment
            if ($totalAvailablePaid > 0) {
                foreach ($dueOrders as $invoice) {
                    if ($totalAvailablePaid <= 0) break;

                    $orderDue = $invoice->due_amount;
                    $percentage = $orderDue / $totalDueAmount;
                    $shouldPay = round($percentage * $inputPaidAmount, 2);

                    // Determine the amount that can be paid to this invoice
                    $payable = min($shouldPay, $orderDue, $totalAvailablePaid);

                    // Update the invoice amounts
                    $invoice->update([
                        'due_amount' => max(0, $invoice->due_amount - $payable),
                        'paid_amount' => $invoice->paid_amount + $payable,
                    ]);

                    // Insert payment details into the InvoicePaymentDetails table
                    InvoicePaymentDetails::create([
                        'invoice_id' => $invoice->id,
                        'paid_amount' => $payable,
                        'discount_amount' => $inputDiscountAmount,  // Assuming no discount for now
                        'payment_status' => ($invoice->due_amount == 0) ? 'Paid' : 'Partial Paid',
                        'payment_method' => $paymentMethod,
                        'due_collection_date' => $dueCollectionDate,
                        'transaction_id' => $transactionId,
                        'user_id' => $user_id,
                    ]);

                    // Subtract the paid amount from the total available
                    $totalAvailablePaid -= $payable;
                }
            }

            // Commit the transaction if everything is successful
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Customer payment updated successfully.'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }


some one to problem face . my problem is a discount

example:
my 2 invoice and discount in 600 
please you can devied in two invoice 
invoice_1 => 300
invoice_2 => 300

please chekc and give me correct code 