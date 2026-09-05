@extends('layouts.dashboard-sidenav')
@section('title', 'Product Return Page')
@section('content')

    <!-- Hero Main Content Start -->
    <div class="main-content">
        <div class="page-content">
            <div class="invoice-container">


                <div class="billing-section">
                    <div class="wrapper">
                        <div class="billing-to">
                            <h3><strong>Billed to</strong></h3>
                            <p>
                                <strong id="CustomerName">{{ $invoice->customer->customer_name ?? 'N/A' }}</strong>
                            </p>
                            <p id="CustomerAddress">{{ $invoice->customer->address_details ??
                                '
                                              ' }}</p>
                            <p>Phone: <span id="CustomerMobile">{{ $invoice->customer->mobile ?? 'N/A' }}</span></p>
                        </div>

                        <div class="invoice-wrapper">
                            <table>
                                <tr>
                                    <td class="number">Invoice No:</td>
                                    <td id="order_no">{{ $invoice->order_no }}</td>
                                </tr>
                                <tr>
                                    <td class="date">Invoice Date:</td>
                                    <td id="invoice_date">{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-m-Y') }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="logo-wrapper">
                        <h2><strong>Invoice</strong></h2>
                        <img src="{{ asset('backend/assets/icons/marss-corporation-logo.svg') }}" alt="MARSS CORPORATION Logo" style="max-height: 48px;" />
                        <div class="button">
                            <button class="print-icon" onclick="ReturnProductSave(event)">
                                <span>

                                </span>
                                <span class="text p-4">Return</span>
                            </button>
                        </div>
                    </div>

                    <strong style="display: none" id="OrderID">{{ $invoice->id ?? 'N/A' }}</strong><br />
                    <strong style="display: none" id="CustomerID">{{ $invoice->customer->id ?? 'N/A' }}</strong><br />
                    <div class="shop-details">
                        <h3>
                            <strong>MARSS CORPORATION</strong>
                        </h3>
                        <div class="contact" style="display: flex; gap: 4px">
                            <p>Cell:</p>
                            <p>
                                <span>01975-703216</span>,
                                <span>01715-842083</span>
                            </p>
                        </div>
                        <p>Success Super Market,</p>
                        <p>Sadar Police Fari, Ataikula Road Pabna</p>
                        <p>marsscorporation2018@gmail.com</p>
                    </div>
                </div>

                <!-- Table Section -->
                <table class="invoice_table_list">
                    <thead>
                        <tr>
                            <th>SL. No.</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Return Quantity</th>
                            <th>Return</th>
                        </tr>
                    </thead>
                    <tbody id="order_details">
                        @if ($invoice->details && $invoice->details->isNotEmpty())
                            @foreach ($invoice->details as $key => $orderDetail)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $orderDetail->product->product_name ?? 'N/A' }}</td>
                                    <td>{{ $orderDetail->quantity ?? 'N/A' }}</td>
                                    <td id="SellingAmount">৳{{ $orderDetail->selling_price }}</td>
                                    <td>
                                        <input type="number" class="return-quantity" name="return_quantity[]"
                                            min="1" max="{{ $orderDetail->quantity }}" value="1"
                                            data-product-id="{{ $orderDetail->product_id }}"
                                            data-order-detail-id="{{ $orderDetail->id }}">
                                    </td>
                                    <td>
                                        <span class="checkbox">
                                            <input type="checkbox" class="return-checkbox" name="return_product[]"
                                                value="{{ $orderDetail->id }}">
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">No products available for return.</td>
                            </tr>
                        @endif

                        <tr>
                            <td colspan="3" rowspan="6" id="payment_status" class="full-paid">
                                @if ($invoice->due_amount <= 0)
                                    Fully Paid
                                @elseif($invoice->paid_amount > 0)
                                    Partial Paid
                                @else
                                    Unpaid
                                @endif
                            </td>
                            <td colspan="2" class="amount_text"><span>Sub Total:</span></td>
                            <td colspan="2" class="amount"><span id="sub_total">
                                    ৳{{ number_format($invoice->sub_total, 2) }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="amount_text table_bg">Discount Amount:</td>
                            <td class="amount table_bg" id="paidamount">৳ {{ number_format($invoice->discount_amount, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="amount_text"><span>Paid Amount:</span></td>
                            <td colspan="2" class="amount"><span id="paidamount">৳
                                    {{ number_format($invoice->paid_amount, 2) }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="amount_text"><span>Due Amount:</span></td>
                            <td colspan="2" class="amount"><span>৳0.00</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="amount_text">Previous Due Amount:</td>
                            <td id="previous_due_amount" class="amount">৳
                                {{ number_format($invoice->previous_due_amount ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="amount_text">Total Due Amount:</td>
                            <td id="total_due_amount" class="amount">৳
                                {{ number_format(($invoice->previous_due_amount ?? 0) + ($invoice->due_amount ?? 0), 2) }}
                            </td>
                        </tr>
                    </tbody>

                </table>

                <!-- Footer Message -->
                <div class="footer-message">
                    <p>
                        <strong style="border-bottom: 1px solid gray; font-size: 12px; font-weight: 800;">TERMS AND
                            CONDITIONS</strong>
                    </p>
                    <p class="google-text">
                        Goods once sold cannot be returned. Any exchange will result in a
                        minimum 20% deduction from the sale amount.
                    </p>
                    <p class="google-text">
                        3 Days Replacement Guaranty Without DISPLAY, CAMERA & SOFTWARE. No Service Warranty Available.
                    </p>
                    <p>
                        Developed By CodeNext IT - www.codenextit.com (+08801788428280)
                    </p>
                </div>
            </div>
            <div class="copyright">
                <footer class="footer text-center py-3 mt-4 text-muted small border-top">&copy; 2026 মার্স কর্পোরেশন (MARSS CORPORATION) | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-success fw-bold text-decoration-none">CodeNext IT</a></footer>
            </div>
        </div>
    </div>
    <!-- Hero Main Content End -->

    <script>

      async function ReturnProductSave(event) {
            event.preventDefault();

            try {
                const selectedProducts = document.querySelectorAll('.return-checkbox:checked');
                if (selectedProducts.length === 0) {
                    alert('Please select at least one product to return.');
                    return;
                }

                const OrderID = document.getElementById('OrderID').innerText.trim();
                const invoice_date = document.getElementById('invoice_date').innerText.trim();
                const CustomerID = document.getElementById('CustomerID').innerText.trim();

                let returnData = [];

                selectedProducts.forEach(checkbox => {
                    let row = checkbox.closest('tr');
                    let quantityInput = row.querySelector('.return-quantity');

                    let orderDetailId = checkbox.value;
                    let productId = quantityInput.dataset.productId;
                    let returnQty = parseInt(quantityInput.value);


                    returnData.push({
                        order_detail_id: orderDetailId,
                        product_id: productId,
                        quantity: returnQty
                    });
                });

                if (returnData.length === 0) {
                    alert('No valid product returns were selected.');
                    return;
                }

                let payload = {
                    order_id: OrderID,
                    date: invoice_date,
                    customer_id: CustomerID,
                    products: returnData
                };

                const config = {
                    headers: {
                        'Content-Type': 'application/json',
                        ...HeaderToken().headers
                    }
                };

                showLoader(); // Show loading indicator
                const res = await axios.post("/api/create-return-product", payload, config);
                hideLoader(); // Hide loading indicator

                if (res.data.status === "success") {
                    successToast(res.data.message);
                    setTimeout(() => {
                        window.location.href = '/admin-dashboard-return-list';
                    }, 1000);
                } else {
                    errorToast(res.data.message);
                }
            } catch (e) {
                hideLoader();
                if (e.response && e.response.status) {
                    unauthorized(e.response.status);
                } else {
                    errorToast('An error occurred while processing your request.');
                }
            }
        }
    </script>
@endsection

