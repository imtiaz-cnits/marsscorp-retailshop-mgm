<div class="main-content">
    <div class="page-content">
        <!-- Breadcrumb Header -->
        <div class="bredcam d-flex justify-content-between align-items-center mb-4">
            <div class="bredcam-title">
                <h1 class="h3 mb-0 text-gray-800 fw-bold">
                    <i class="fa-solid fa-truck-field text-success me-2"></i>Supplier Profile
                </h1>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-success fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#paySupplierDueModal">
                    <i class="fa-solid fa-hand-holding-dollar me-2"></i> Pay Due (পেমেন্ট করুন)
                </button>
                <a href="/admin-dashboard-supplier" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-2">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Suppliers
                </a>
            </div>
        </div>

        <div class="container-fluid px-0">
            <!-- Supplier Information Banner -->
            <div class="card border-0 shadow-sm mb-4 overflow-hidden" style="border-radius: 12px;">
                <div class="bg-success py-2 px-4" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important;"></div>
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-7 d-flex align-items-center gap-3">
                            <div class="position-relative">
                                <img id="supplierImg" src="{{ asset('backend/assets/img/demo-img.jpeg') }}" 
                                     alt="Supplier Image" 
                                     class="rounded-circle border border-3 border-success shadow-sm" 
                                     style="width: 85px; height: 85px; object-fit: cover;">
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <h2 id="supplierName" class="h4 fw-bold mb-0 text-dark">Loading Supplier...</h2>
                                    <span id="supplierIdBadge" class="badge bg-light text-success border border-success fw-bold px-2 py-1" style="font-size: 13px;">SUP-0000</span>
                                    <span id="supplierStatusBadge" class="badge bg-success px-2 py-1" style="font-size: 12px;">Active</span>
                                </div>
                                <p id="supplierCompany" class="text-muted mb-1 fw-semibold">
                                    <i class="fa-solid fa-building me-1 text-secondary"></i>Company: N/A
                                </p>
                                <div class="d-flex flex-wrap gap-3 text-muted small">
                                    <span id="supplierMobile"><i class="fa-solid fa-phone me-1 text-success"></i>N/A</span>
                                    <span id="supplierEmail"><i class="fa-solid fa-envelope me-1 text-primary"></i>N/A</span>
                                    <span id="supplierAddress"><i class="fa-solid fa-location-dot me-1 text-danger"></i>N/A</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 text-md-end mt-3 mt-md-0 border-start-md ps-md-4">
                            <div class="p-3 bg-light rounded-3 d-inline-block text-start" style="min-width: 220px;">
                                <span class="text-muted small text-uppercase fw-bold d-block mb-1">Net Payable Balance</span>
                                <h3 id="supplierNetDue" class="h3 fw-bold text-danger mb-0">৳ 0.00</h3>
                                <small class="text-muted d-block mb-2">Total Due to Supplier</small>
                                <button class="btn btn-sm btn-success fw-bold w-100 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#paySupplierDueModal">
                                    <i class="fa-solid fa-hand-holding-dollar me-1"></i> Pay Due (পেমেন্ট করুন)
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5 Metric Cards -->
            <div class="row g-3 mb-4">
                <div class="col-xl-2 col-md-4">
                    <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 12px; border-left: 4px solid #0284c7 !important;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small fw-bold text-uppercase">Purchases</p>
                                <h3 id="statTotalPurchases" class="fw-bold mb-0 text-dark">0</h3>
                                <small class="text-muted">Invoices</small>
                            </div>
                            <div class="rounded-circle bg-info-subtle p-2 text-info d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-cart-shopping fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-4">
                    <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 12px; border-left: 4px solid #16a34a !important;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small fw-bold text-uppercase">Total Billed</p>
                                <h3 id="statTotalBilled" class="fw-bold mb-0 text-success" style="font-size: 1.25rem;">৳ 0.00</h3>
                                <small class="text-muted">Grand total</small>
                            </div>
                            <div class="rounded-circle bg-success-subtle p-2 text-success d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-money-bill-wave fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-4">
                    <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 12px; border-left: 4px solid #059669 !important;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small fw-bold text-uppercase">Total Paid</p>
                                <h3 id="statTotalPaid" class="fw-bold mb-0 text-emerald" style="color: #059669; font-size: 1.25rem;">৳ 0.00</h3>
                                <small class="text-muted">Completed</small>
                            </div>
                            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #d1fae5; color: #059669;">
                                <i class="fa-solid fa-circle-check fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Available Return Credit Card -->
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 12px; border-left: 4px solid #0d9488 !important; background: #f0fdfa;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small fw-bold text-uppercase">Available Return Credit (অব্যবহৃত ক্রেডিট)</p>
                                <h3 id="statTotalReturns" class="fw-bold mb-0" style="color: #0d9488; font-size: 1.25rem;">৳ 0.00</h3>
                                <small id="statReturnSubtitle" class="text-muted" style="font-size: 11px;">Total Returns: ৳ 0.00</small>
                            </div>
                            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #ccfbf1; color: #0d9488;">
                                <i class="fa-solid fa-truck-ramp-box fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 12px; border-left: 4px solid #dc2626 !important;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small fw-bold text-uppercase">Net Payable Due</p>
                                <h3 id="statTotalDue" class="fw-bold mb-0 text-danger" style="font-size: 1.25rem;">৳ 0.00</h3>
                                <small class="text-muted">Outstanding balance</small>
                            </div>
                            <div class="rounded-circle bg-danger-subtle p-2 text-danger d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-circle-exclamation fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Section -->
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-0 pt-3 px-4">
                    <ul class="nav nav-tabs card-header-tabs border-bottom-0" id="supplierProfileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold text-success" id="purchases-tab" data-bs-toggle="tab" data-bs-target="#purchases-content" type="button" role="tab">
                                <i class="fa-solid fa-receipt me-2"></i>Purchase Invoices (<span id="purchasesCount">0</span>)
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold text-dark" id="returns-tab" data-bs-toggle="tab" data-bs-target="#returns-content" type="button" role="tab">
                                <i class="fa-solid fa-truck-ramp-box me-2 text-teal" style="color: #0d9488;"></i>Purchase Returns / Credit (<span id="returnsCount">0</span>)
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold text-secondary" id="transactions-tab" data-bs-toggle="tab" data-bs-target="#transactions-content" type="button" role="tab">
                                <i class="fa-solid fa-hand-holding-dollar me-2"></i>Payment & Transaction History (<span id="transactionsCount">0</span>)
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content" id="supplierProfileTabContent">

                        <!-- Tab 1: Purchases -->
                        <div class="tab-pane fade show active" id="purchases-content" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width: 50px;">SL</th>
                                            <th class="text-center">Purchase ID</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-start">Barcodes</th>
                                            <th class="text-start">Reference</th>
                                            <th class="text-end">Grand Total</th>
                                            <th class="text-end">Paid Amount</th>
                                            <th class="text-end">Due Amount</th>
                                            <th class="text-center">Payment Status</th>
                                            <th class="text-center" style="width: 100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="purchasesTableBody">
                                        <tr><td colspan="10" class="text-center py-4 text-muted">Loading purchase invoices...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab 2: Purchase Returns -->
                        <div class="tab-pane fade" id="returns-content" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width: 50px;">SL</th>
                                            <th class="text-center">Return Date</th>
                                            <th class="text-center">Purchase ID</th>
                                            <th class="text-start">Returned Product Name</th>
                                            <th class="text-center">Returned Qty</th>
                                            <th class="text-end">Credit / Refund Value</th>
                                        </tr>
                                    </thead>
                                    <tbody id="returnsTableBody">
                                        <tr><td colspan="6" class="text-center py-4 text-muted">Loading purchase return records...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab 3: Transactions -->
                        <div class="tab-pane fade" id="transactions-content" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width: 50px;">SL</th>
                                            <th class="text-center">Date & Time</th>
                                            <th class="text-center">Invoice / Ref</th>
                                            <th class="text-end">Paid Amount</th>
                                            <th class="text-end">Discount</th>
                                            <th class="text-start">Payment Method</th>
                                            <th class="text-start">Transaction ID / Note</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="transactionsTableBody">
                                        <tr><td colspan="8" class="text-center py-4 text-muted">Loading transaction records...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Pay Supplier Due Modal -->
<div class="modal fade" id="paySupplierDueModal" tabindex="-1" aria-labelledby="paySupplierDueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header bg-success text-white py-3" style="border-top-left-radius: 16px; border-top-right-radius: 16px; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important;">
                <h5 class="modal-title fw-bold" id="paySupplierDueModalLabel">
                    <i class="fa-solid fa-hand-holding-dollar me-2"></i>Pay Supplier Due (সাপ্লাইয়ারের বকেয়া পরিশোধ)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="paySupplierDueForm" onsubmit="submitSupplierPayment(event)">
                <div class="modal-body p-4">
                    <!-- Supplier Quick Info Box -->
                    <div class="bg-light p-3 rounded-3 mb-3 border">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold text-dark" id="modalSupplierName">Supplier Name</span>
                            <span class="badge bg-secondary" id="modalSupplierId">ID</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Target Outstanding Due:</span>
                            <span class="fw-bold text-danger fs-6" id="modalSupplierTotalDue">৳ 0.00</span>
                        </div>
                    </div>

                    <!-- Payment Target Selector -->
                    <div class="mb-3">
                        <label class="form-label fw-bold d-block text-dark">Payment Target (পরিশোধের খাত) <span class="text-danger">*</span></label>
                        <div class="btn-group w-100" role="group" id="supplierCollectionTypeGroup">
                            <input type="radio" class="btn-check" name="supplier_collection_type" id="stype_all" value="all" checked onchange="onSupplierCollectionTypeChange()">
                            <label class="btn btn-outline-success fw-bold py-2" for="stype_all" title="আগের ও পারচেজের উভয় বকেয়া পরিশোধ">
                                <i class="fa-solid fa-layer-group me-1"></i> উভয় বকেয়া
                            </label>

                            <input type="radio" class="btn-check" name="supplier_collection_type" id="stype_previous" value="previous" onchange="onSupplierCollectionTypeChange()">
                            <label class="btn btn-outline-primary fw-bold py-2" for="stype_previous" title="শুধুমাত্র পুরানো বকেয়া পরিশোধ">
                                <i class="fa-solid fa-clock-rotate-left me-1"></i> আগের বকেয়া
                            </label>

                            <input type="radio" class="btn-check" name="supplier_collection_type" id="stype_purchase" value="purchase" onchange="onSupplierCollectionTypeChange()">
                            <label class="btn btn-outline-warning text-dark fw-bold py-2" for="stype_purchase" title="শুধুমাত্র পারচেজ ইনভয়েসের বকেয়া পরিশোধ">
                                <i class="fa-solid fa-cart-shopping me-1"></i> পারচেজ বকেয়া
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="supplierModalPaidAmount" class="form-label fw-bold text-dark">Payment Amount (পরিশোধের পরিমাণ ৳) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-white fw-bold">৳</span>
                            <input type="number" step="0.01" class="form-control fw-bold fs-5 text-success" id="supplierModalPaidAmount" placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="supplierModalPaymentMethod" class="form-label fw-bold text-dark">Payment Method</label>
                            <select class="form-select fw-semibold" id="supplierModalPaymentMethod">
                                <option value="Cash" selected>Cash (নগদ)</option>
                                <option value="Bank">Bank Transfer</option>
                                <option value="bKash">bKash</option>
                                <option value="Nagad">Nagad</option>
                                <option value="Rocket">Rocket</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="supplierModalCollectionDate" class="form-label fw-bold text-dark">Payment Date</label>
                            <input type="date" class="form-control fw-semibold" id="supplierModalCollectionDate">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="supplierModalNote" class="form-label fw-bold text-dark">Transaction Note / Ref</label>
                        <input type="text" class="form-control" id="supplierModalNote" placeholder="Optional transaction note">
                    </div>
                </div>
                <div class="modal-footer bg-light py-3" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                    <button type="button" class="btn btn-secondary fw-bold rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success fw-bold rounded-pill px-5 shadow-sm" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none;">
                        <i class="fa-solid fa-check me-1"></i> Submit Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const pathParts = window.location.pathname.split('/');
    const supplierProfileId = pathParts[pathParts.length - 1];

    document.addEventListener("DOMContentLoaded", () => {
        loadSupplierProfileData();
    });

    function onSupplierCollectionTypeChange() {
        const selectedType = document.querySelector('input[name="supplier_collection_type"]:checked')?.value || 'all';
        const modalTotalDue = document.getElementById('modalSupplierTotalDue');
        const inputAmount = document.getElementById('supplierModalPaidAmount');

        let targetMax = 0;
        let targetText = '';

        if (selectedType === 'previous') {
            targetMax = window.supplierPreviousDueVal;
            targetText = `৳ ${targetMax.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})} (শুধুমাত্র আগের বকেয়া)`;
        } else if (selectedType === 'purchase') {
            targetMax = window.supplierPurchaseDueVal;
            targetText = `৳ ${targetMax.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})} (শুধুমাত্র পারচেজ বকেয়া)`;
        } else {
            targetMax = window.supplierTotalDueVal;
            targetText = `৳ ${targetMax.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})} (আগের: ৳${window.supplierPreviousDueVal.toFixed(2)} | পারচেজ: ৳${window.supplierPurchaseDueVal.toFixed(2)})`;
        }

        modalTotalDue.innerText = targetText;
        inputAmount.value = targetMax > 0 ? targetMax.toFixed(2) : '';
    }

    async function loadSupplierProfileData() {
        try {
            const res = await axios.get(`/api/supplier-profile-data/${supplierProfileId}`, HeaderToken());
            if (res.data.status === 'success') {
                const supplier = res.data.supplier;
                const summary = res.data.summary;
                const purchases = res.data.purchases || [];
                const returns = res.data.returns || [];
                const transactions = res.data.transactions || [];

                window.supplierDbId = supplier.id;
                window.supplierPreviousDueVal = parseFloat(supplier.purchase_payable_amount || 0);
                window.supplierPurchaseDueVal = purchases.reduce((sum, p) => sum + parseFloat(p.due_amount || 0), 0);
                window.supplierReturnsVal = parseFloat(summary.total_returns || 0);
                window.supplierTotalDueVal = Math.max(0, window.supplierPreviousDueVal + window.supplierPurchaseDueVal - window.supplierReturnsVal);

                // Render Supplier Header
                $('#supplierName').text(supplier.name || 'N/A');
                $('#supplierIdBadge').text(supplier.supplier_id || 'SUP-0000');
                $('#supplierCompany').html(`<i class="fa-solid fa-building me-1 text-secondary"></i>Company: ${supplier.company || 'N/A'}`);
                $('#supplierMobile').html(`<i class="fa-solid fa-phone me-1 text-success"></i>${supplier.mobile || 'N/A'}`);
                $('#supplierEmail').html(`<i class="fa-solid fa-envelope me-1 text-primary"></i>${supplier.email || 'N/A'}`);
                $('#supplierAddress').html(`<i class="fa-solid fa-location-dot me-1 text-danger"></i>${supplier.address || 'N/A'}`);
                
                if (supplier.img_url) {
                    $('#supplierImg').attr('src', '/' + supplier.img_url);
                }

                // Render Summary Metrics
                $('#supplierNetDue').text(`৳ ${parseFloat(summary.total_due).toFixed(2)}`);
                $('#statTotalPurchases').text(summary.total_purchases);
                $('#statTotalBilled').text(`৳ ${parseFloat(summary.total_amount).toFixed(2)}`);
                $('#statTotalPaid').text(`৳ ${parseFloat(summary.total_paid).toFixed(2)}`);
                $('#statTotalReturns').text(`৳ ${parseFloat(summary.available_credit || 0).toFixed(2)}`);
                $('#statReturnSubtitle').text(`Total Returns: ৳${parseFloat(summary.total_returns || 0).toFixed(2)} | Adj: ৳${parseFloat(summary.total_returns_adjusted || 0).toFixed(2)}`);
                $('#statTotalDue').text(`৳ ${parseFloat(summary.total_due).toFixed(2)}`);

                $('#purchasesCount').text(purchases.length);
                $('#returnsCount').text(returns.length);
                $('#transactionsCount').text(transactions.length);

                // Pre-fill Modal Info
                $('#modalSupplierName').text(supplier.name || 'N/A');
                $('#modalSupplierId').text(supplier.supplier_id || 'SUP-0000');
                $('#supplierModalCollectionDate').val(new Date().toISOString().split('T')[0]);

                onSupplierCollectionTypeChange();

                // Render Purchases Table
                const purchasesTbody = $('#purchasesTableBody');
                purchasesTbody.empty();
                if (purchases.length === 0) {
                    purchasesTbody.html('<tr><td colspan="10" class="text-center py-4 text-muted">No purchase records found for this supplier</td></tr>');
                } else {
                    purchases.forEach((item, index) => {
                        const statusBadge = item.payment_status === 'Fully Paid' ? 'bg-success' :
                                            item.payment_status === 'Partial Paid' ? 'bg-warning text-dark' : 'bg-danger';

                        let barcodesHtml = '<span class="text-muted small">N/A</span>';
                        if (item.barcodes && Array.isArray(item.barcodes) && item.barcodes.length > 0) {
                            barcodesHtml = item.barcodes.map(c => `<span class="badge bg-light text-success border border-success me-1" style="font-family: monospace;">${c}</span>`).join('');
                        }

                        let paidDisplayHtml = `৳ ${parseFloat(item.paid_amount).toFixed(2)}`;
                        if (item.return_adjustment_amount && parseFloat(item.return_adjustment_amount) > 0) {
                            paidDisplayHtml += `<br><span class="badge bg-teal-subtle text-teal border" style="font-size: 11px; color: #0d9488;">+৳${parseFloat(item.return_adjustment_amount).toFixed(2)} Adj</span>`;
                        }

                        const row = `
                            <tr>
                                <td class="text-center fw-bold">${index + 1}</td>
                                <td class="text-center fw-bold text-success">${item.purchase_id}</td>
                                <td class="text-center">${item.date}</td>
                                <td class="text-start">${barcodesHtml}</td>
                                <td class="text-start">${item.referance_no}</td>
                                <td class="text-end fw-bold">৳ ${parseFloat(item.grand_subtotal).toFixed(2)}</td>
                                <td class="text-end text-success fw-bold">${paidDisplayHtml}</td>
                                <td class="text-end ${item.due_amount > 0 ? 'text-danger' : 'text-muted'} fw-bold">৳ ${parseFloat(item.due_amount).toFixed(2)}</td>
                                <td class="text-center"><span class="badge ${statusBadge} px-2 py-1">${item.payment_status}</span></td>
                                <td class="text-center">
                                    <a href="/purchase-invoice/${item.id}" class="btn btn-sm btn-outline-primary px-2 py-1" title="View Purchase Invoice">
                                        <i class="fa-solid fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        `;
                        purchasesTbody.append(row);
                    });
                }

                // Render Returns Table
                const returnsTbody = $('#returnsTableBody');
                returnsTbody.empty();
                if (returns.length === 0) {
                    returnsTbody.html('<tr><td colspan="6" class="text-center py-4 text-muted">No purchase return records found for this supplier</td></tr>');
                } else {
                    returns.forEach((rItem, rIndex) => {
                        const row = `
                            <tr>
                                <td class="text-center fw-bold">${rIndex + 1}</td>
                                <td class="text-center fw-semibold text-dark">${rItem.created_at_formatted || rItem.date}</td>
                                <td class="text-center"><span class="badge bg-teal-subtle text-teal border font-monospace">${rItem.purchase_no}</span></td>
                                <td class="text-start fw-bold text-dark">${rItem.product_name}</td>
                                <td class="text-center"><span class="badge bg-light text-dark border px-2 py-1 fw-bold">${rItem.quantity} pcs</span></td>
                                <td class="text-end fw-bold text-teal" style="color: #0d9488;">৳ ${parseFloat(rItem.amount).toFixed(2)}</td>
                            </tr>
                        `;
                        returnsTbody.append(row);
                    });
                }

                // Render Transactions Table
                const transactionsTbody = $('#transactionsTableBody');
                transactionsTbody.empty();
                if (transactions.length === 0) {
                    transactionsTbody.html('<tr><td colspan="8" class="text-center py-4 text-muted">No payment transaction records found</td></tr>');
                } else {
                    transactions.forEach((trx, index) => {
                        const row = `
                            <tr>
                                <td class="text-center fw-bold">${index + 1}</td>
                                <td class="text-center">${trx.created_at_formatted}</td>
                                <td class="text-center fw-bold text-primary">${trx.purchase_id}</td>
                                <td class="text-end text-success fw-bold">৳ ${parseFloat(trx.paid_amount).toFixed(2)}</td>
                                <td class="text-end text-muted">৳ ${parseFloat(trx.discount_amount || 0).toFixed(2)}</td>
                                <td class="text-start fw-semibold"><i class="fa-solid fa-wallet me-1 text-secondary"></i>${trx.payment_method || 'Cash'}</td>
                                <td class="text-start text-muted">${trx.transaction_id || 'N/A'}</td>
                                <td class="text-center"><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">${trx.payment_status || 'Success'}</span></td>
                            </tr>
                        `;
                        transactionsTbody.append(row);
                    });
                }

            } else {
                alert("Error: " + (res.data.message || "Failed to load supplier profile data."));
            }
        } catch (err) {
            console.error(err);
            alert("Error: " + (err.response?.data?.message || err.message || "Error loading supplier profile."));
        }
    }

    async function submitSupplierPayment(event) {
        event.preventDefault();

        const collectionType = document.querySelector('input[name="supplier_collection_type"]:checked')?.value || 'all';
        const paidAmount = parseFloat(document.getElementById('supplierModalPaidAmount').value) || 0;
        const paymentMethod = document.getElementById('supplierModalPaymentMethod').value;
        const collectionDate = document.getElementById('supplierModalCollectionDate').value;
        const note = document.getElementById('supplierModalNote').value;

        if (paidAmount <= 0) {
            alert("Please enter a valid payment amount greater than 0.");
            return;
        }

        try {
            if (typeof showLoader === 'function') showLoader();

            const payload = {
                supplier_id: window.supplierDbId,
                collection_type: collectionType,
                paid_amount: paidAmount,
                payment_method: paymentMethod,
                payment_date: collectionDate,
                note: note
            };

            const res = await axios.post('/supplier-payment-details-update', payload, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                if (typeof successToast === 'function') {
                    successToast(res.data.message || "Supplier payment recorded successfully!");
                } else {
                    alert(res.data.message || "Supplier payment recorded successfully!");
                }

                const modalEl = document.getElementById('paySupplierDueModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                loadSupplierProfileData();
            } else {
                alert(res.data?.message || "Failed to submit supplier payment.");
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            alert("Error: " + (err.response?.data?.message || err.message || "Payment request failed."));
        }
    }
</script>
