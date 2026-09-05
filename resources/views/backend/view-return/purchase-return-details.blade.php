@extends('layouts.dashboard-sidenav')
@section('title', 'Purchase Product Return Page')
@section('content')

    <!-- Hero Main Content Start -->
    <div class="main-content">
        <div class="page-content">
            <div class="invoice-container">

                <div class="billing-section">
                    <div class="wrapper">
                        <div class="billing-to">
                            <h3><strong>Supplier Details</strong></h3>
                            <p>
                                <strong id="SupplierName">{{ $purchase->supplier->name ?? 'N/A' }}</strong>
                            </p>
                            <p id="SupplierAddress">{{ $purchase->supplier->address ?? '' }}</p>
                            <p>Phone: <span id="SupplierMobile">{{ $purchase->supplier->mobile ?? 'N/A' }}</span></p>
                        </div>

                        <div class="invoice-wrapper">
                            <table>
                                <tr>
                                    <td class="number">Purchase Ref No:</td>
                                    <td id="referance_no">{{ $purchase->referance_no ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="date">Purchase Date:</td>
                                    <td id="purchase_date">{{ \Carbon\Carbon::parse($purchase->date)->format('d-m-Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="logo-wrapper">
                        <h2><strong>Purchase Return</strong></h2>
                        <img src="{{ asset('backend/assets/icons/marss-corporation-logo.svg') }}" alt="MARSS CORPORATION Logo" style="max-height: 48px;" />
                        <div class="button">
                            <button class="print-icon" onclick="ReturnPurchaseSave(event)">
                                <span class="text p-4">Return</span>
                            </button>
                        </div>
                    </div>

                    <strong style="display: none" id="PurchaseID">{{ $purchase->id ?? 'N/A' }}</strong><br />
                    <strong style="display: none" id="SupplierID">{{ $purchase->supplier->id ?? 'N/A' }}</strong><br />

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
                    <tbody id="purchase_order_details">
                        @if ($purchase->orderDetails && $purchase->orderDetails->isNotEmpty())
                            @foreach ($purchase->orderDetails as $key => $detail)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $detail->product->product_name ?? 'N/A' }}</td>
                                    <td>{{ $detail->quantity ?? 'N/A' }}</td>
                                    <td>৳{{ number_format($detail->cost_price) }}</td>
                                    <td>
                                        <input type="number" class="return-quantity" name="return_quantity[]"
                                            min="1" max="{{ $detail->quantity }}" value="1"
                                            data-product-id="{{ $detail->product_id }}"
                                            data-order-detail-id="{{ $detail->id }}">
                                    </td>
                                    <td>
                                        <span class="checkbox">
                                            <input type="checkbox" class="return-checkbox" name="return_product[]"
                                                value="{{ $detail->id }}">
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
                            <td colspan="3" rowspan="4" id="payment_status" class="full-paid">
                                @if ($dueAmount <= 0)
                                    Fully Paid
                                @elseif($paidAmount > 0)
                                    Partial Paid
                                @else
                                    Unpaid
                                @endif
                            </td>
                            <td colspan="2" class="amount_text"><span>Sub Total:</span></td>
                            <td colspan="2" class="amount"><span id="sub_total">৳{{ number_format($subTotal) }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="amount_text"><span>Paid Amount:</span></td>
                            <td colspan="2" class="amount"><span id="paidamount">৳{{ number_format($paidAmount) }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="amount_text"><span>Due Amount:</span></td>
                            <td colspan="2" class="amount"><span>৳{{ number_format($dueAmount) }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="amount_text">Total Payable Amount:</td>
                            <td id="total_payable_amount" class="amount">৳{{ number_format($totalPayableAmount) }}</td>
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
                        Purchased goods can only be returned within 3 days of delivery with proper documentation.
                    </p>
                    <p class="google-text">
                        Damaged or used goods will not be accepted for return.
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
        async function ReturnPurchaseSave(event) {
            event.preventDefault();

            try {
                const selectedProducts = document.querySelectorAll('.return-checkbox:checked');
                if (selectedProducts.length === 0) {
                    alert('Please select at least one product to return.');
                    return;
                }

                const PurchaseID = document.getElementById('PurchaseID').innerText.trim();
                const purchase_date = document.getElementById('purchase_date').innerText.trim();
                const SupplierID = document.getElementById('SupplierID').innerText.trim();

                let returnData = [];

                selectedProducts.forEach(checkbox => {
                    let row = checkbox.closest('tr');
                    let quantityInput = row.querySelector('.return-quantity');

                    let orderDetailId = checkbox.value;
                    let productId = quantityInput.dataset.productId;
                    let returnQty = parseInt(quantityInput.value);

                    returnData.push({
                        purchase_order_detail_id: orderDetailId,
                        product_id: productId,
                        quantity: returnQty
                    });
                });

                let payload = {
                    purchase_id: PurchaseID,
                    date: purchase_date,
                    supplier_id: SupplierID,
                    products: returnData
                };

                const config = {
                    headers: {
                        'Content-Type': 'application/json',
                        ...HeaderToken().headers
                    }
                };

                showLoader();
                const res = await axios.post("/api/create-purchase-return", payload, config);
                hideLoader();

                if (res.data.status === "success") {
                    successToast(res.data.message);
                    setTimeout(() => {
                        window.location.href = '/admin-dashboard-purchase-return-list';
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
