@extends('layouts.dashboard-sidenav')
@section('title', 'Customer Profile')
@section('content')

<style>
    /* Custom Styling for Smart Look */
    .summary-card { border: none; border-radius: 12px; transition: transform 0.2s ease; }
    .summary-card:hover { transform: translateY(-5px); }
    .card-title-small { font-size: 0.78rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9; }
    
    .amount-text { 
        font-size: 1.3rem; 
        font-weight: 700; 
        line-height: 1.2; 
        margin: 0; 
        word-break: break-word; 
    }
    
    .currency-symbol { 
        font-size: 0.95rem; 
        font-weight: 500; 
        margin-right: 2px; 
    }
    
    .table-custom th { font-weight: 600; color: #555; border-bottom: 2px solid #eee; }
    .badge-soft-info { background-color: #e0f3ff; color: #007bff; border: 1px solid #b3d7ff; }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="bredcam d-flex justify-content-between align-items-center mb-4">
            <div class="bredcam-title">
                <h1 class="fw-bold text-primary"><i class="fa-solid fa-user-tie me-2"></i>Customer Profile</h1>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-success fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#collectCustomerDueModal">
                    <i class="fa-solid fa-hand-holding-dollar me-2"></i> Collect Due (বকেয়া আদায়)
                </button>
                <a href="javascript:history.back()" class="btn btn-outline-primary fw-bold px-4 rounded-pill shadow-sm">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to List
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card h-100 shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="text-primary fw-bold mb-3 border-bottom pb-2">Customer Details</h5>
                            <h4 id="c_name" class="fw-bold text-dark mb-2 fs-5">Loading...</h4>
                            <p class="mb-1 text-muted small"><strong class="text-dark">ID:</strong> <span id="c_id">...</span></p>
                            <p class="mb-1 text-muted small"><strong class="text-dark">Phone:</strong> <span id="c_phone">...</span></p>
                            <p class="mb-1 text-muted small"><strong class="text-dark">Address:</strong> <span id="c_address">...</span></p>
                            <p class="mb-0 text-muted small"><strong class="text-dark">Opening Due (পূর্বের বকেয়া):</strong> <span id="c_opening_due" class="badge bg-warning text-dark px-2 py-1">৳0.00</span></p>
                        </div>
                        <button class="btn btn-sm btn-success fw-bold w-100 mt-3 rounded-pill shadow-sm py-2" data-bs-toggle="modal" data-bs-target="#collectCustomerDueModal">
                            <i class="fa-solid fa-hand-holding-dollar me-1"></i> Collect Due (বকেয়া আদায়)
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="row h-100 g-2">
                    <div class="col-md-2 col-sm-4 mb-2">
                        <div class="card bg-info text-white h-100 text-center shadow-sm summary-card p-2">
                            <div class="card-body p-2 d-flex flex-column justify-content-center">
                                <span class="card-title-small mb-1">Invoices</span>
                                <h2 id="s_invoices" class="amount-text fs-4">0</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2.5 col-sm-4 mb-2" style="flex: 0 0 22%; max-width: 22%;">
                        <div class="card text-white h-100 text-center shadow-sm summary-card p-2" style="background-color: #5a5eb9;">
                            <div class="card-body p-2 d-flex flex-column justify-content-center">
                                <span class="card-title-small mb-1">Total Billed</span>
                                <div class="d-flex align-items-baseline justify-content-center">
                                    <span class="currency-symbol">৳</span>
                                    <span id="s_billed" class="amount-text fs-5">0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2.5 col-sm-4 mb-2" style="flex: 0 0 22%; max-width: 22%;">
                        <div class="card bg-success text-white h-100 text-center shadow-sm summary-card p-2">
                            <div class="card-body p-2 d-flex flex-column justify-content-center">
                                <span class="card-title-small mb-1">Total Paid</span>
                                <div class="d-flex align-items-baseline justify-content-center">
                                    <span class="currency-symbol">৳</span>
                                    <span id="s_paid" class="amount-text fs-5">0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- NEW: Available Return Credit Card -->
                    <div class="col-md-2.5 col-sm-6 mb-2" style="flex: 0 0 24%; max-width: 24%;">
                        <div class="card text-white h-100 text-center shadow-sm summary-card p-2" style="background-color: #0d9488;">
                            <div class="card-body p-2 d-flex flex-column justify-content-center">
                                <span class="card-title-small mb-1" style="font-size: 10px;">Available Return Credit</span>
                                <div class="d-flex align-items-baseline justify-content-center">
                                    <span class="currency-symbol">৳</span>
                                    <span id="s_returns" class="amount-text fs-5">0.00</span>
                                </div>
                                <small id="s_return_sub" style="font-size: 9px; opacity: 0.9;" class="d-block mt-1">Total: ৳0 | Adj: ৳0</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2.5 col-sm-6 mb-2" style="flex: 0 0 22%; max-width: 22%;">
                        <div class="card bg-danger text-white h-100 text-center shadow-sm summary-card p-2">
                            <div class="card-body p-2 d-flex flex-column justify-content-center">
                                <span class="card-title-small mb-1">Net Current Due</span>
                                <div class="d-flex align-items-baseline justify-content-center">
                                    <span class="currency-symbol">৳</span>
                                    <span id="s_due" class="amount-text fs-5">0.00</span>
                                </div>
                                <small id="s_due_sub" style="font-size: 9px; opacity: 0.9;" class="d-block mt-1">Prev: ৳0 | Inv: ৳0</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-header bg-white border-0 pt-3 px-4">
                <ul class="nav nav-tabs card-header-tabs border-bottom-0" id="customerProfileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold text-primary" id="invoices-tab" data-bs-toggle="tab" data-bs-target="#invoices-content" type="button" role="tab">
                            <i class="fa-solid fa-file-invoice me-2"></i>Invoice History (<span id="invoicesTabCount">0</span>)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold text-teal" id="returns-tab" data-bs-toggle="tab" data-bs-target="#returns-content" type="button" role="tab" style="color: #0d9488;">
                            <i class="fa-solid fa-arrow-rotate-left me-2"></i>Sales Returns / Credit (<span id="returnsTabCount">0</span>)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold text-success" id="transactions-tab" data-bs-toggle="tab" data-bs-target="#transactions-content" type="button" role="tab">
                            <i class="fa-solid fa-money-bill-transfer me-2"></i>Payment & Transaction History (<span id="transactionsTabCount">0</span>)
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content" id="customerProfileTabContent">

                    <!-- Tab 1: Invoices -->
                    <div class="tab-pane fade show active" id="invoices-content" role="tabpanel">
                        <div class="table-responsive">
                            <table id="customerInvoiceTable" class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center py-2" style="width: 50px;">SL</th>
                                        <th class="py-2">Invoice No</th>
                                        <th class="py-2">Date</th>
                                        <th class="text-end py-2">Subtotal</th>
                                        <th class="text-end py-2">Paid</th>
                                        <th class="text-end py-2">Due</th>
                                        <th class="text-center py-2">Status</th>
                                        <th class="text-center py-2" style="width: 80px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="8" class="text-center py-4 text-muted">Loading invoices...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 2: Sales Returns -->
                    <div class="tab-pane fade" id="returns-content" role="tabpanel">
                        <div class="table-responsive">
                            <table id="customerReturnsTable" class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center py-2" style="width: 50px;">SL</th>
                                        <th class="text-center py-2">Return Date</th>
                                        <th class="text-center py-2">Invoice Ref</th>
                                        <th class="text-start py-2">Returned Product Name</th>
                                        <th class="text-center py-2">Qty</th>
                                        <th class="text-end py-2">Refund / Credit Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="6" class="text-center py-4 text-muted">Loading return records...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 3: Transactions -->
                    <div class="tab-pane fade" id="transactions-content" role="tabpanel">
                        <div class="table-responsive">
                            <table id="transactionTable" class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="py-2">Date & Time</th>
                                        <th class="py-2">Reference / Note</th>
                                        <th class="py-2">Payment Method</th>
                                        <th class="text-end py-2">Paid Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="4" class="text-center py-4 text-muted">Loading transactions...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<!-- Collect Customer Due Modal -->
<div class="modal fade" id="collectCustomerDueModal" tabindex="-1" aria-labelledby="collectCustomerDueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header bg-success text-white py-3" style="border-top-left-radius: 16px; border-top-right-radius: 16px; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important;">
                <h5 class="modal-title fw-bold" id="collectCustomerDueModalLabel">
                    <i class="fa-solid fa-hand-holding-dollar me-2"></i>Collect Customer Due (বকেয়া আদায়)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="collectCustomerDueForm" onsubmit="submitCustomerDueCollection(event)">
                <div class="modal-body p-4">
                    <!-- Customer Info Card inside Modal -->
                    <div class="bg-light p-3 rounded-3 mb-3 border">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold text-dark" id="modalCustomerName">Customer Name</span>
                            <span class="badge bg-secondary" id="modalCustomerId">ID</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Target Outstanding Due:</span>
                            <span class="fw-bold text-danger fs-6" id="modalTotalDue">৳ 0.00</span>
                        </div>
                    </div>

                    <!-- Due Collection Target Selection -->
                    <div class="mb-3">
                        <label class="form-label fw-bold d-block text-dark">Collection Target (আদায়ের খাত) <span class="text-danger">*</span></label>
                        <div class="btn-group w-100" role="group" id="collectionTypeGroup">
                            <input type="radio" class="btn-check" name="collection_type" id="ctype_all" value="all" checked onchange="onCollectionTypeChange()">
                            <label class="btn btn-outline-success fw-bold py-2" for="ctype_all" title="আগের ও ইনভয়েসের উভয় বকেয়া কালেকশন">
                                <i class="fa-solid fa-layer-group me-1"></i> উভয় বকেয়া
                            </label>

                            <input type="radio" class="btn-check" name="collection_type" id="ctype_previous" value="previous" onchange="onCollectionTypeChange()">
                            <label class="btn btn-outline-primary fw-bold py-2" for="ctype_previous" title="শুধুমাত্র পুরানো বকেয়া কালেকশন">
                                <i class="fa-solid fa-clock-rotate-left me-1"></i> আগের বকেয়া
                            </label>

                            <input type="radio" class="btn-check" name="collection_type" id="ctype_invoice" value="invoice" onchange="onCollectionTypeChange()">
                            <label class="btn btn-outline-warning text-dark fw-bold py-2" for="ctype_invoice" title="শুধুমাত্র মেমো/ইনভয়েসের বকেয়া কালেকশন">
                                <i class="fa-solid fa-file-invoice-dollar me-1"></i> ইনভয়েস বকেয়া
                            </label>
                        </div>
                    </div>

                    <!-- Payment Details -->
                    <div class="mb-3">
                        <label for="modalPaidAmount" class="form-label fw-bold text-dark">Collected Amount (আদায়ের পরিমাণ ৳) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-white fw-bold">৳</span>
                            <input type="number" step="0.01" class="form-control fw-bold fs-5 text-success" id="modalPaidAmount" placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="modalDiscountAmount" class="form-label fw-bold text-dark">Discount / Waiver (ছাড় ৳)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white fw-bold">৳</span>
                            <input type="number" step="0.01" class="form-control" id="modalDiscountAmount" value="0.00">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="modalPaymentMethod" class="form-label fw-bold text-dark">Payment Method</label>
                            <select class="form-select fw-semibold" id="modalPaymentMethod">
                                <option value="Cash" selected>Cash (নগদ)</option>
                                <option value="bKash">bKash</option>
                                <option value="Nagad">Nagad</option>
                                <option value="Rocket">Rocket</option>
                                <option value="Bank">Bank Transfer</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="modalCollectionDate" class="form-label fw-bold text-dark">Collection Date</label>
                            <input type="date" class="form-control fw-semibold" id="modalCollectionDate">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="modalTransactionId" class="form-label fw-bold text-dark">Transaction ID / Note</label>
                        <input type="text" class="form-control" id="modalTransactionId" placeholder="e.g. TrxID / Receipt No">
                    </div>
                </div>
                <div class="modal-footer bg-light py-3" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                    <button type="button" class="btn btn-secondary fw-bold rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="btnSubmitCollection" class="btn btn-success fw-bold rounded-pill px-5 shadow-sm" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none;">
                        <i class="fa-solid fa-check me-1"></i> Submit Collection
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const customerId = "{{ $id }}";

    window.previousDueVal = 0;
    window.invoiceDueVal = 0;
    window.totalDueVal = 0;

    document.addEventListener("DOMContentLoaded", () => {
        fetchCustomerProfile();
    });

    function onCollectionTypeChange() {
        const selectedType = document.querySelector('input[name="collection_type"]:checked')?.value || 'all';
        const inputAmount = document.getElementById('modalPaidAmount');
        const modalTotalDue = document.getElementById('modalTotalDue');

        let targetMax = 0;
        let targetText = '';

        if (selectedType === 'previous') {
            targetMax = window.previousDueVal;
            targetText = `৳ ${targetMax.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})} (শুধুমাত্র আগের বকেয়া)`;
        } else if (selectedType === 'invoice') {
            targetMax = window.invoiceDueVal;
            targetText = `৳ ${targetMax.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})} (শুধুমাত্র ইনভয়েস বকেয়া)`;
        } else {
            targetMax = window.totalDueVal;
            targetText = `৳ ${targetMax.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})} (আগের: ৳${window.previousDueVal.toFixed(2)} | ইনভয়েস: ৳${window.invoiceDueVal.toFixed(2)})`;
        }

        modalTotalDue.innerText = targetText;
        inputAmount.value = targetMax > 0 ? targetMax.toFixed(2) : '';
    }

    async function fetchCustomerProfile() {
        try {
            if(typeof showLoader === "function") showLoader();

            let res = await axios.get(`/api/customer-profile-data/${customerId}`, HeaderToken());

            if(typeof hideLoader === "function") hideLoader();

            if (res.data.status === 'success') {
                let customer = res.data.customer;
                let summary = res.data.summary;
                let invoices = res.data.invoices || [];
                let returns = res.data.returns || [];
                let transactions = res.data.transactions || [];

                // Track due breakdown
                window.previousDueVal = parseFloat(customer.previous_due_amount || 0);
                window.invoiceDueVal = invoices.reduce((sum, inv) => sum + parseFloat(inv.due_amount || 0), 0);
                window.totalDueVal = Math.max(0, window.previousDueVal + window.invoiceDueVal - parseFloat(summary.available_credit || 0));

                // Set Customer Info
                document.getElementById('c_name').innerText = customer.name || customer.customer_name || 'N/A';
                document.getElementById('c_id').innerText = customer.customer_id || 'N/A';
                document.getElementById('c_phone').innerText = customer.mobile || customer.phone || 'N/A';
                document.getElementById('c_address').innerText = customer.address || 'N/A';
                
                const openingDue = parseFloat(summary.opening_due || customer.previous_due_amount || 0);
                const invDue = parseFloat(summary.invoice_due || window.invoiceDueVal || 0);
                document.getElementById('c_opening_due').innerText = `৳${openingDue.toFixed(2)}`;

                // Set Summary
                document.getElementById('s_invoices').innerText = summary.total_invoices;
                document.getElementById('s_billed').innerText = parseFloat(summary.total_billed).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                document.getElementById('s_paid').innerText = parseFloat(summary.total_paid).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                document.getElementById('s_returns').innerText = parseFloat(summary.available_credit || 0).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                document.getElementById('s_return_sub').innerText = `Total: ৳${parseFloat(summary.total_returns || 0).toFixed(2)} | Adj: ৳${parseFloat(summary.total_returns_adjusted || 0).toFixed(2)}`;
                document.getElementById('s_due').innerText = parseFloat(summary.total_due).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                
                const dueSubEl = document.getElementById('s_due_sub');
                if (dueSubEl) {
                    dueSubEl.innerText = `Prev: ৳${openingDue.toFixed(0)} | Inv: ৳${invDue.toFixed(0)}`;
                }

                document.getElementById('invoicesTabCount').innerText = invoices.length;
                document.getElementById('returnsTabCount').innerText = returns.length;
                document.getElementById('transactionsTabCount').innerText = transactions.length;

                // Pre-fill Modal Info
                document.getElementById('modalCustomerName').innerText = customer.name || customer.customer_name || 'N/A';
                document.getElementById('modalCustomerId').innerText = customer.customer_id || 'N/A';
                document.getElementById('modalCollectionDate').value = new Date().toISOString().split('T')[0];

                onCollectionTypeChange();

                // Set Invoices Table
                let invoiceTableList = $("#customerInvoiceTable tbody");
                invoiceTableList.empty();

                if (invoices.length === 0) {
                    invoiceTableList.append(`<tr><td colspan="8" class="text-center text-muted py-4">No invoices found.</td></tr>`);
                } else {
                    invoices.forEach(function(item, index) {
                        const subTotal = item.sub_total ? parseFloat(item.sub_total).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : '0.00';
                        const due = item.due_amount ? parseFloat(item.due_amount).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : '0.00';
                        const paid = parseFloat(item.paid_amount || 0);
                        const dueRaw = parseFloat(item.due_amount || 0);
                        
                        let paidDisplayHtml = `৳${paid.toFixed(2)}`;
                        if (item.return_adjustment_amount && parseFloat(item.return_adjustment_amount) > 0) {
                            paidDisplayHtml += `<br><span class="badge bg-teal-subtle text-teal border" style="font-size: 11px; color: #0d9488;">+৳${parseFloat(item.return_adjustment_amount).toFixed(2)} Adj</span>`;
                        }

                        let paymentStatus = '';
                        if (dueRaw === 0 && (paid > 0 || (item.return_adjustment_amount && parseFloat(item.return_adjustment_amount) > 0))) {
                            paymentStatus = '<span class="badge bg-success px-3 py-1 rounded-pill">Fully Paid</span>';
                        } else if (dueRaw > 0 && paid > 0) {
                            paymentStatus = '<span class="badge bg-warning text-dark px-3 py-1 rounded-pill">Partial Paid</span>';
                        } else if (dueRaw > 0 && paid === 0) {
                            paymentStatus = '<span class="badge bg-danger px-3 py-1 rounded-pill">Unpaid</span>';
                        } else {
                            paymentStatus = '<span class="badge bg-secondary px-3 py-1 rounded-pill">Unknown</span>';
                        }

                        let formattedDate = new Intl.DateTimeFormat('en-US', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(item.invoice_date || item.created_at));

                        let row = `
                            <tr>
                                <td class="text-center fw-bold text-muted">${index + 1}</td>
                                <td><a href="/invoice/${item.id}" class="fw-bold text-primary" style="text-decoration: none;">${item.order_no}</a></td>
                                <td>${formattedDate}</td>
                                <td class="text-end fw-semibold text-dark">৳${subTotal}</td>
                                <td class="text-end fw-semibold text-success">${paidDisplayHtml}</td>
                                <td class="text-end fw-semibold ${dueRaw > 0 ? 'text-danger' : 'text-muted'}">৳${due}</td>
                                <td class="text-center">${paymentStatus}</td>
                                <td class="text-center">
                                    <a href="/invoice/${item.id}" class="btn btn-sm btn-outline-primary px-2 py-1" title="View Invoice">
                                        <i class="fa-solid fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        `;
                        invoiceTableList.append(row);
                    });
                }

                // Set Sales Returns Table
                let returnsTableList = $("#customerReturnsTable tbody");
                returnsTableList.empty();
                if (returns.length === 0) {
                    returnsTableList.append(`<tr><td colspan="6" class="text-center text-muted py-4">No sales return records found.</td></tr>`);
                } else {
                    returns.forEach(function(rItem, rIndex) {
                        let row = `
                            <tr>
                                <td class="text-center fw-bold">${rIndex + 1}</td>
                                <td class="text-center fw-semibold text-dark">${rItem.created_at_formatted || rItem.date}</td>
                                <td class="text-center"><span class="badge bg-light text-primary border font-monospace">${rItem.order_no}</span></td>
                                <td class="text-start fw-bold text-dark">${rItem.product_name}</td>
                                <td class="text-center"><span class="badge bg-light text-dark border px-2 py-1 fw-bold">${rItem.quantity} pcs</span></td>
                                <td class="text-end fw-bold text-teal" style="color: #0d9488;">৳${parseFloat(rItem.amount).toFixed(2)}</td>
                            </tr>
                        `;
                        returnsTableList.append(row);
                    });
                }

                // Set Transactions Table
                let trxTableList = $("#transactionTable tbody");
                trxTableList.empty();

                if (!transactions || transactions.length === 0) {
                    trxTableList.append(`<tr><td colspan="4" class="text-center text-muted py-4">No payment history found.</td></tr>`);
                } else {
                    transactions.forEach(function(item) {
                        const amount = item.paid_amount ? parseFloat(item.paid_amount).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : '0.00';
                        const payMethod = item.payment_method || 'Cash';
                        
                        let formattedDate = new Intl.DateTimeFormat('en-US', { 
                            day: '2-digit', month: 'short', year: 'numeric', 
                            hour: 'numeric', minute: '2-digit', hour12: true 
                        }).format(new Date(item.created_at));

                        let row = `
                            <tr>
                                <td>
                                    <div class="fw-semibold text-dark" style="font-size: 0.9rem;">${formattedDate.split(',')[0]}</div>
                                    <small class="text-muted">${formattedDate.split(',')[1]}</small>
                                </td>
                                <td><span class="badge badge-soft-info" style="font-size: 12px;">${item.reference_no || item.order_no || 'Due Collection'}</span></td>
                                <td><span class="text-muted"><i class="fa-solid fa-wallet me-1"></i>${payMethod}</span></td>
                                <td class="text-end fw-bold text-success">৳${amount}</td>
                            </tr>
                        `;
                        trxTableList.append(row);
                    });
                }

            } else {
                alert("Error: " + res.data.message);
            }

        } catch (e) {
            if(typeof hideLoader === "function") hideLoader();
            console.error(e);
            alert("Something went wrong while fetching customer profile.");
        }
    }

    async function submitCustomerDueCollection(event) {
        event.preventDefault();

        const collectionType = document.querySelector('input[name="collection_type"]:checked')?.value || 'all';
        const paidAmount = parseFloat(document.getElementById('modalPaidAmount').value) || 0;
        const discountAmount = parseFloat(document.getElementById('modalDiscountAmount').value) || 0;
        const paymentMethod = document.getElementById('modalPaymentMethod').value;
        const collectionDate = document.getElementById('modalCollectionDate').value;
        const transactionId = document.getElementById('modalTransactionId').value;
        const btn = document.getElementById('btnSubmitCollection');

        if (paidAmount <= 0) {
            alert("Please enter a valid collected amount!");
            return;
        }

        try {
            if (typeof showLoader === "function") showLoader();
            btn.disabled = true;

            const payload = {
                id: customerId,
                customer_id: customerId,
                collection_type: collectionType,
                paid_amount: paidAmount,
                discount_amount: discountAmount,
                payment_method: paymentMethod,
                collection_date: collectionDate,
                due_collection_date: collectionDate,
                transaction_id: transactionId
            };

            let res = await axios.post('/api/customer-due-collection', payload, HeaderToken());

            if (typeof hideLoader === "function") hideLoader();
            btn.disabled = false;

            if (res.data.status === 'success') {
                if (typeof successToast === 'function') {
                    successToast(res.data.message || "Customer due collection recorded successfully!");
                } else {
                    alert(res.data.message || "Customer due collection recorded successfully!");
                }

                const modalEl = document.getElementById('collectCustomerDueModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                fetchCustomerProfile();
            } else {
                alert(res.data.message || "Failed to record due collection.");
            }
        } catch (e) {
            if (typeof hideLoader === "function") hideLoader();
            btn.disabled = false;
            console.error(e);
            alert("Error: " + (e.response?.data?.message || e.message || "Failed to submit due collection."));
        }
    }
</script>
@endsection