<style>
    #exampleModal .modal-dialog {
        max-width: 1080px !important;
        width: 95% !important;
        margin: 1.75rem auto;
    }

    #exampleModal .modal-content {
        border-radius: 20px !important;
        border: none !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35) !important;
        overflow: hidden;
        background: #ffffff;
    }

    #exampleModal .purchase-modal-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        padding: 18px 24px;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #exampleModal .purchase-modal-header h4 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    #exampleModal .purchase-modal-header .btn-close-custom {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    #exampleModal .purchase-modal-header .btn-close-custom:hover {
        background: rgba(239, 68, 68, 0.8);
        transform: rotate(90deg);
    }

    #exampleModal .purchase-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 20px;
    }

    #exampleModal .purchase-card-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    #exampleModal .search-barcode-box {
        background: #ffffff;
        border: 2px solid #0d9488;
        border-radius: 12px;
        padding: 4px;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.1);
        transition: all 0.2s ease;
    }

    #exampleModal .search-barcode-box:focus-within {
        box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.25);
    }

    #exampleModal #productInputData {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        font-size: 15px;
        font-weight: 600;
        padding: 10px 16px;
        background: transparent;
    }

    #exampleModal #productDropdown {
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        overflow: hidden;
        margin-top: 6px;
    }

    #exampleModal #productDropdown .list-group-item {
        cursor: pointer;
        transition: background-color 0.15s ease;
    }

    #exampleModal #productDropdown .list-group-item:hover {
        background-color: #f0fdf4;
    }

    #exampleModal .table-container {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        margin: 10px 0 20px 0;
        background: #ffffff;
    }

    #exampleModal .responsive-table {
        width: 100%;
        margin: 0;
        border-collapse: collapse;
    }

    #exampleModal .table-header {
        background: #0f172a;
        color: #ffffff;
    }

    #exampleModal .header-cell {
        padding: 12px 14px;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #f8fafc;
        border: none;
    }

    #exampleModal .body-row {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.2s ease;
    }

    #exampleModal .body-row:hover {
        background-color: #f8fafc;
    }

    #exampleModal .summary-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px;
    }

    #exampleModal .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px dashed #e2e8f0;
        font-size: 14px;
    }

    #exampleModal .summary-row:last-child {
        border-bottom: none;
    }

    #exampleModal .net-payable-badge {
        background: #0f172a;
        color: #ffffff;
        padding: 12px 16px;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 10px 0;
    }

    #exampleModal .btn-submit-purchase {
        background: linear-gradient(135deg, #0d9488 0%, #059669 100%);
        color: #ffffff;
        font-size: 16px;
        font-weight: 700;
        padding: 14px 28px;
        border-radius: 12px;
        border: none;
        width: 100%;
        box-shadow: 0 10px 20px -5px rgba(13, 148, 136, 0.4);
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
    }

    #exampleModal .btn-submit-purchase:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 25px -5px rgba(13, 148, 136, 0.5);
        background: linear-gradient(135deg, #0f766e 0%, #047857 100%);
    }

    .partial-payment-status {
        background-color: #fef3c7;
        color: #92400e;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: bold;
        font-size: 12px;
    }

    .fully-paid-status {
        background-color: #dcfce7;
        color: #166534;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: bold;
        font-size: 12px;
    }
</style>

<!-- Action Button Edit Modal Start -->
<section class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <!-- Sleek Header -->
            <div class="purchase-modal-header">
                <h4>
                    <i class="fa-solid fa-cart-flatbed text-teal me-1" style="color: #2dd4bf;"></i> Purchase Product (নতুন পণ্য ক্রয়)
                </h4>
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form onsubmit="return PurchaseDataSave(event)" id="purchaseCreateForm">
                <div class="p-4">
                    <!-- Top Info Cards: Supplier & Invoice Details -->
                    <div class="row g-3 mb-3">
                        <div class="col-lg-6">
                            <div class="purchase-card h-100 mb-0">
                                <div class="purchase-card-title">
                                    <i class="fa-solid fa-truck-field text-teal" style="color: #0d9488;"></i> Supplier Information (সাপ্লায়ার)
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="position-relative flex-grow-1" id="searchableSupplierWrapper">
                                        <input type="text" id="supplierSearchInput" class="form-control form-control-lg bg-white" placeholder="🔍 Search or Select Supplier *" autocomplete="off" style="font-size: 14px; border-radius: 10px;" />
                                        <input type="hidden" id="SupplierDataList" value="none">
                                        <div id="supplierDropdownList" class="dropdown-menu shadow-lg w-100 p-0 overflow-auto" style="max-height: 250px; display: none; position: absolute; z-index: 1050; top: 100%; left: 0;"></div>
                                    </div>
                                    <button type="button" class="btn text-white px-3 fw-bold text-nowrap d-flex align-items-center justify-content-center" onclick="openSupplierCreateModal()" style="border-radius: 10px; height: 48px; background-color: #0d9488;">
                                        <i class="fa-solid fa-plus me-1"></i> New
                                    </button>
                                </div>

                                <div id="supplierCreditNotice" class="mt-3 d-none">
                                    <div class="p-2 rounded-3 d-flex justify-content-between align-items-center" style="background-color: #e6fffa; border: 1.5px dashed #0d9488;">
                                        <span id="supplierCreditBadge" class="fw-bold text-dark" style="font-size: 13px;">
                                            <i class="fa-solid fa-gift me-1" style="color: #0d9488;"></i> ফেরত ব্যালেন্স আছে: <strong>৳ 0.00</strong>
                                        </span>
                                        <label class="d-flex align-items-center gap-2 mb-0 px-2 py-1 bg-white rounded border shadow-sm" style="cursor: pointer; border-color: #0d9488 !important;">
                                            <input type="checkbox" id="useReturnCreditCheckboxBanner" onchange="syncReturnCreditCheckbox(this.checked)" style="width: 18px; height: 18px; accent-color: #0d9488; cursor: pointer; margin: 0;">
                                            <span class="fw-bold small" style="color: #0d9488;">সমন্বয় করুন (Adjust)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="purchase-card h-100 mb-0">
                                <div class="purchase-card-title">
                                    <i class="fa-solid fa-file-invoice text-primary"></i> Invoice & Voucher Details
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted mb-1">Ref / Invoice No *</label>
                                        <input type="text" placeholder="Reference No *" id="ReferenceNo" class="form-control bg-white" style="border-radius: 8px; font-weight: 600;" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted mb-1">Purchase Date *</label>
                                        <input type="date" class="form-control bg-white" id="PurchaseDate" style="border-radius: 8px; font-weight: 600;" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted mb-1">Payable Balance</label>
                                        <input type="text" readonly placeholder="Payable Amount" id="PurchasePayableAmount" class="form-control bg-light fw-bold" style="border-radius: 8px; color: #0d9488;" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted mb-1">Attach Invoice Doc</label>
                                        <input type="file" id="AttachDocument" class="form-control bg-white" style="border-radius: 8px; font-size: 12px;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Search & Scanner Box -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark fs-6 mb-1 d-flex justify-content-between align-items-center">
                            <span><i class="fa-solid fa-barcode me-1" style="color: #0d9488;"></i> Scan Barcode or Select Product *</span>
                            <span class="badge bg-success-subtle text-success small font-monospace"><i class="fa-solid fa-bolt me-1"></i> Auto-Cart Enabled</span>
                        </label>
                        <div class="search-barcode-box d-flex align-items-center gap-2">
                            <div class="flex-grow-1 position-relative">
                                <input type="text" id="productInputData" class="form-control" placeholder="⚡ বারকোড স্ক্যান করুন বা প্রোডাক্টের নাম/কোড টাইপ করুন (Auto-adds to list)..." autocomplete="off" />
                                <ul id="productDropdown" class="list-group position-absolute w-100 shadow-lg" style="z-index: 1050; max-height: 280px; overflow-y: auto;"></ul>
                            </div>
                            <button type="button" class="btn text-white fw-bold px-3 py-2 d-inline-flex align-items-center gap-2 text-nowrap" onclick="openPurchaseCameraScanner()" style="background-color: #0d9488; border-radius: 10px; height: 46px;">
                                <i class="fa-solid fa-camera fa-lg"></i> ক্যামেরা স্ক্যান
                            </button>
                        </div>
                    </div>

                    <!-- Cart Item Table -->
                    <div class="table-container">
                        <table class="responsive-table">
                            <thead class="table-header">
                                <tr class="header-row">
                                    <th class="header-cell">Product Name</th>
                                    <th class="header-cell">Barcodes</th>
                                    <th class="header-cell text-center" style="width: 140px;">Qty</th>
                                    <th class="header-cell" style="width: 140px;">Cost Price (৳)</th>
                                    <th class="header-cell text-end" style="width: 130px;">Sub Total</th>
                                    <th class="header-cell text-center" style="width: 60px;">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-body" id="orderTableBody">
                                <!-- Dynamic Items -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Bottom Summary & Payment Details Card -->
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="purchase-card h-100 mb-0">
                                <div class="purchase-card-title">
                                    <i class="fa-solid fa-credit-card text-success"></i> Payment Method & Details
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted mb-1">Payment Method</label>
                                        <select class="form-select bg-white" id="paymentMethod" style="border-radius: 8px;">
                                            <option value="" selected>Select Method</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Bkash">Bkash</option>
                                            <option value="Nagad">Nagad</option>
                                            <option value="Bank">Bank</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted mb-1">Paid Amount (৳)</label>
                                        <input type="number" step="any" class="form-control bg-white fw-bold" id="paidAmount" value="0" style="border-radius: 8px;" />
                                    </div>
                                    <div class="col-12">
                                        <input type="text" id="paymentDetails" class="form-control mt-1" style="display: none; border-radius: 8px;" placeholder="Enter transaction details..." />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="summary-box">
                                <div class="summary-row">
                                    <span class="text-muted fw-semibold">Total Quantity:</span>
                                    <span class="fw-bold text-dark fs-6" id="totalQuantity">0.00</span>
                                </div>
                                <div class="summary-row">
                                    <span class="text-muted fw-semibold">Grand Subtotal:</span>
                                    <span class="fw-bold text-dark fs-6">৳ <span id="totalSubTotal">0.00</span></span>
                                    <input type="hidden" id="grandSubtotal" value="0.00" />
                                </div>
                                <div class="summary-row" style="display: none;">
                                    <label style="cursor: pointer; display: inline-flex; align-items: center; gap: 8px; margin: 0;">
                                        <input type="checkbox" id="useReturnCreditCheckbox" onchange="syncReturnCreditCheckbox(this.checked)" style="width: 18px; height: 18px; accent-color: #0d9488; cursor: pointer;">
                                        <span class="fw-bold small" style="color: #0d9488;">Return Credit Adj</span>
                                    </label>
                                    <input type="number" step="0.01" min="0" class="form-control form-control-sm text-end fw-bold" id="returnAdjustmentAmount" value="0.00" disabled style="width: 110px; color: #0d9488;" oninput="calculateDuePayment()" />
                                </div>
                                <div class="net-payable-badge">
                                    <span class="fw-bold">Net Payable (প্রকৃত দেনা):</span>
                                    <span class="fw-bold fs-5" style="color: #2dd4bf;">৳ <span id="netPayableDisplay">0.00</span></span>
                                    <input type="hidden" id="netPayableAmount" value="0.00" />
                                </div>
                                <div class="summary-row">
                                    <span class="text-muted fw-semibold">Due Amount:</span>
                                    <span class="fw-bold text-danger fs-6">৳ <input type="text" id="dueAmount" value="0.00" readonly class="border-0 bg-transparent text-danger fw-bold text-end" style="width: 90px;" /></span>
                                </div>
                                <div class="summary-row border-0 pt-2">
                                    <span class="text-muted fw-semibold">Payment Status:</span>
                                    <span id="paymentStatusDisplay" class="partial-payment-status">Unpaid</span>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn-submit-purchase">
                                        <i class="fa-solid fa-circle-check fs-5 me-1"></i> Submit Purchase Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Camera Scanner Modal for Purchase -->
<div class="modal fade" id="purchaseCameraScanModal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header bg-dark text-white border-0 py-3">
                <h5 class="modal-title fs-6 fw-bold">
                    <i class="fa-solid fa-barcode text-success me-2"></i> প্রোডাক্ট বারকোড স্ক্যানার (Purchase)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" onclick="stopPurchaseCameraScanner()"></button>
            </div>
            <div class="modal-body p-3 text-center bg-light">
                <div id="purchaseCameraScannerStatus" class="alert alert-info py-2 small mb-3">
                    <i class="fa-solid fa-circle-notch fa-spin me-1"></i> ক্যামেরা শুরু হচ্ছে... বারকোড ক্যামেরার সামনে আনুন।
                </div>

                <div id="purchaseReader" style="width: 100%; min-height: 250px; background: #000; border-radius: 12px; overflow: hidden; margin: 0 auto;"></div>

                <div class="d-flex justify-content-between align-items-center mt-3 px-1">
                    <span id="purchaseLastScannedText" class="badge bg-dark text-wrap p-2" style="font-size: 13px;">স্ক্যান কৃত: -</span>
                    <button type="button" class="btn btn-outline-dark btn-sm rounded-pill" onclick="switchPurchaseCamera()">
                        <i class="fa-solid fa-camera-rotate me-1"></i> ক্যামেরা সুইচ
                    </button>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 py-2">
                <button type="button" class="btn btn-secondary btn-sm w-100 rounded-pill" data-bs-dismiss="modal" onclick="stopPurchaseCameraScanner()">বন্ধ করুন (Close)</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const paidAmountInput = document.getElementById("paidAmount");
        const dueAmountInput = document.getElementById("dueAmount");
        const grandSubtotalInput = document.getElementById("grandSubtotal");
        const paymentStatusDisplay = document.getElementById("paymentStatusDisplay");

        window.syncReturnCreditCheckbox = function(isChecked) {
            const tableCb = document.getElementById("useReturnCreditCheckbox");
            const bannerCb = document.getElementById("useReturnCreditCheckboxBanner");
            if (tableCb) tableCb.checked = isChecked;
            if (bannerCb) bannerCb.checked = isChecked;

            toggleReturnCreditAdjustment();
        };

        window.toggleReturnCreditAdjustment = function() {
            const checkbox = document.getElementById("useReturnCreditCheckbox");
            const returnAdjInput = document.getElementById("returnAdjustmentAmount");
            const maxCredit = parseFloat(window.availableSupplierCredit || 0);

            if (checkbox && checkbox.checked) {
                returnAdjInput.disabled = false;
                returnAdjInput.style.backgroundColor = "#ffffff";
                returnAdjInput.setAttribute("max", maxCredit);
                returnAdjInput.value = maxCredit > 0 ? maxCredit.toFixed(2) : "0.00";
            } else {
                returnAdjInput.value = "0.00";
                returnAdjInput.disabled = true;
                returnAdjInput.style.backgroundColor = "#f1f5f9";
            }

            calculateDuePayment();
        };

        window.calculateDuePayment = function() {
            let grandSubtotal = parseFloat(grandSubtotalInput.value) || 0;
            let checkbox = document.getElementById("useReturnCreditCheckbox");
            let returnAdjInput = document.getElementById("returnAdjustmentAmount");
            let netPayableInput = document.getElementById("netPayableAmount");
            let netDisplay = document.getElementById("netPayableDisplay");

            let returnAdj = 0;
            if (checkbox && checkbox.checked) {
                let maxCredit = parseFloat(window.availableSupplierCredit || 0);
                returnAdj = parseFloat(returnAdjInput.value) || 0;

                if (returnAdj > maxCredit) {
                    returnAdj = maxCredit;
                    returnAdjInput.value = maxCredit.toFixed(2);
                }
                if (returnAdj > grandSubtotal) {
                    returnAdj = grandSubtotal;
                    returnAdjInput.value = grandSubtotal.toFixed(2);
                }
            } else {
                if (returnAdjInput) returnAdjInput.value = "0.00";
            }

            let netPayable = Math.max(0, grandSubtotal - returnAdj);
            if (netPayableInput) netPayableInput.value = netPayable.toFixed(2);
            if (netDisplay) netDisplay.textContent = netPayable.toFixed(2);

            let paidAmount = parseFloat(paidAmountInput.value) || 0;
            let dueAmount = Math.max(0, netPayable - paidAmount);

            dueAmountInput.value = dueAmount.toFixed(2);

            if (paidAmount === 0 && netPayable > 0) {
                paymentStatusDisplay.textContent = "Unpaid";
                paymentStatusDisplay.className = "partial-payment-status bg-danger text-white";
            } else if (paidAmount < netPayable) {
                paymentStatusDisplay.textContent = "Partial Paid";
                paymentStatusDisplay.className = "partial-payment-status";
            } else {
                paymentStatusDisplay.textContent = "Fully Paid";
                paymentStatusDisplay.className = "fully-paid-status";
            }
        };

        paidAmountInput.addEventListener("input", calculateDuePayment);
        calculateDuePayment();
    });
</script>

<script>
    let allSuppliersData = [];

    function openSupplierCreateModal() {
        const modal = document.getElementById('supplierCreateModal') || document.getElementById('myModal');
        if (modal) {
            if (modal.parentNode && modal.parentNode !== document.body) {
                document.body.appendChild(modal);
            }
            modal.style.setProperty('display', 'flex', 'important');
            modal.style.opacity = '1';
            modal.style.visibility = 'visible';
            setTimeout(() => {
                modal.classList.add('show');
                modal.classList.add('show-modal');
                const firstInput = document.getElementById('supplierName');
                if (firstInput) firstInput.focus();
            }, 20);
        } else {
            errorToast("Supplier Create Modal not found!");
        }
    }

    async function refreshSupplierList(selectedSupplierId = null) {
        try {
            const res = await axios.get("/api/supplier-list", HeaderToken());
            allSuppliersData = res.data.SupplierData || [];

            renderSupplierDropdownItems(allSuppliersData);

            if (selectedSupplierId) {
                const found = allSuppliersData.find(s => s.id == selectedSupplierId);
                if (found) {
                    selectSupplierItem(found);
                }
            }
        } catch (error) {
            console.error("Error occurred while fetching Suppliers:", error);
        }
    }

    function renderSupplierDropdownItems(suppliers) {
        const listContainer = document.getElementById("supplierDropdownList");
        if (!listContainer) return;

        if (!suppliers || suppliers.length === 0) {
            listContainer.innerHTML = `<div class="p-2 text-muted text-center small">No suppliers found</div>`;
            return;
        }

        let html = suppliers.map(s => {
            const creditVal = parseFloat(s.return_credit_balance || 0);
            const creditLabel = creditVal > 0 ? `<span class="badge bg-teal ms-1" style="background:#0d9488;">🎁 ৳${creditVal.toFixed(2)}</span>` : '';
            const payable = parseFloat(s.purchase_payable_amount || 0);
            const payableLabel = payable > 0 ? `<span class="badge bg-danger ms-1">দেয়: ৳${payable.toFixed(2)}</span>` : '';

            return `
                <div class="dropdown-item px-3 py-2 border-bottom supplier-select-item"
                     data-id="${s.id}"
                     data-name="${s.name}"
                     data-payable="${payable}"
                     data-credit="${creditVal}"
                     style="cursor: pointer;">
                     <div class="fw-bold text-dark">${s.name} ${s.company ? `<small class="text-muted">(${s.company})</small>` : ''}</div>
                     <div class="small text-muted">${s.mobile || ''} ${payableLabel} ${creditLabel}</div>
                </div>
            `;
        }).join('');

        listContainer.innerHTML = html;

        listContainer.querySelectorAll('.supplier-select-item').forEach(item => {
            item.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const payable = this.getAttribute('data-payable');
                const credit = parseFloat(this.getAttribute('data-credit')) || 0;

                selectSupplierItem({
                    id,
                    name,
                    payable,
                    credit
                });
                listContainer.style.display = 'none';
            });
        });
    }

    function selectSupplierItem(s) {
        document.getElementById("SupplierDataList").value = s.id;
        document.getElementById("supplierSearchInput").value = s.name;
        document.getElementById("PurchasePayableAmount").value = s.payable || 0;

        window.availableSupplierCredit = s.credit || 0;

        const creditNotice = document.getElementById("supplierCreditNotice");
        const creditBadge = document.getElementById("supplierCreditBadge");
        const returnAdjInput = document.getElementById("returnAdjustmentAmount");

        if (typeof syncReturnCreditCheckbox === 'function') {
            syncReturnCreditCheckbox(false);
        }

        if (s.credit > 0) {
            creditBadge.innerHTML = `<i class="fa-solid fa-gift me-1" style="color: #0d9488;"></i> ফেরত ব্যালেন্স আছে: <strong>৳ ${s.credit.toFixed(2)}</strong>`;
            creditNotice.classList.remove("d-none");
            returnAdjInput.setAttribute("max", s.credit);
        } else {
            creditNotice.classList.add("d-none");
            returnAdjInput.setAttribute("max", "0");
        }

        if (typeof calculateDuePayment === 'function') {
            calculateDuePayment();
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const suppInput = document.getElementById("supplierSearchInput");
        const suppList = document.getElementById("supplierDropdownList");

        if (suppInput && suppList) {
            suppInput.addEventListener("focus", function() {
                suppList.style.display = "block";
                renderSupplierDropdownItems(allSuppliersData);
            });

            suppInput.addEventListener("input", function() {
                const query = this.value.toLowerCase().trim();
                suppList.style.display = "block";

                const filtered = allSuppliersData.filter(s =>
                    (s.name && s.name.toLowerCase().includes(query)) ||
                    (s.mobile && s.mobile.toLowerCase().includes(query)) ||
                    (s.company && s.company.toLowerCase().includes(query))
                );

                renderSupplierDropdownItems(filtered);
            });

            document.addEventListener("click", function(e) {
                const wrapper = document.getElementById("searchableSupplierWrapper");
                if (wrapper && !wrapper.contains(e.target)) {
                    suppList.style.display = "none";
                }
            });
        }
    });

    refreshSupplierList();

    /* ========================================================
       Camera Scanner for Purchase Product Input
       ======================================================== */
    let purchaseHtml5QrCode = null;
    let purchaseFacingMode = "environment";
    let lastPurchaseScannedCode = "";
    let purchaseScanTimer = null;

    function openPurchaseCameraScanner() {
        const modalEl = new bootstrap.Modal(document.getElementById('purchaseCameraScanModal'));
        modalEl.show();
        setTimeout(() => {
            startPurchaseCameraScanner();
        }, 350);
    }

    function startPurchaseCameraScanner() {
        if (purchaseHtml5QrCode && purchaseHtml5QrCode.isScanning) {
            purchaseHtml5QrCode.stop().then(() => initPurchaseHtml5QrCode()).catch(() => initPurchaseHtml5QrCode());
        } else {
            initPurchaseHtml5QrCode();
        }
    }

    function initPurchaseHtml5QrCode() {
        const statusEl = document.getElementById("purchaseCameraScannerStatus");
        if (statusEl) {
            statusEl.className = "alert alert-info py-2 small mb-3";
            statusEl.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-1"></i> ক্যামেরা শুরু হচ্ছে... বারকোড ক্যামেরার সামনে আনুন।';
        }

        if (!purchaseHtml5QrCode) {
            purchaseHtml5QrCode = new Html5Qrcode("purchaseReader");
        }

        const config = {
            fps: 15,
            qrbox: {
                width: 260,
                height: 160
            },
            aspectRatio: 1.333334
        };

        purchaseHtml5QrCode.start({
                facingMode: purchaseFacingMode
            },
            config,
            onPurchaseBarcodeDetectedSuccess,
            onPurchaseBarcodeDetectedError
        ).then(() => {
            if (statusEl) {
                statusEl.className = "alert alert-success py-2 small mb-3";
                statusEl.innerHTML = '<i class="fa-solid fa-video me-1"></i> ক্যামেরা সক্রিয়! বারকোড স্ক্যান করলে সরাসরি পারচেজ টেবিলে যোগ হবে।';
            }
        }).catch(err => {
            console.error("Purchase Camera start error:", err);
            if (statusEl) {
                statusEl.className = "alert alert-danger py-2 small mb-3";
                statusEl.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> ক্যামেরা চালু করা যায়নি! ব্রাউজারের ক্যামেরা পারমিশন এলাউ করুন।';
            }
        });
    }

    function onPurchaseBarcodeDetectedSuccess(decodedText) {
        if (!decodedText || decodedText === lastPurchaseScannedCode) return;

        lastPurchaseScannedCode = decodedText;
        const lastTextEl = document.getElementById("purchaseLastScannedText");
        if (lastTextEl) lastTextEl.innerText = `স্ক্যান কৃত: ${decodedText}`;

        if (navigator.vibrate) navigator.vibrate(100);
        playScanBeepSound();

        const codeClean = decodedText.trim().toLowerCase();
        const matched = allProducts.find(p => isExactCodeMatch(p, codeClean));

        if (matched) {
            addProductToOrder(matched);
            successToast(`স্ক্যান করা হয়েছে: ${matched.product_name}`);
        } else {
            errorToast(`প্রোডাক্ট পাওয়া যায়নি: ${decodedText}`);
        }

        clearTimeout(purchaseScanTimer);
        purchaseScanTimer = setTimeout(() => {
            lastPurchaseScannedCode = "";
        }, 1200);
    }

    function onPurchaseBarcodeDetectedError(msg) {}

    function switchPurchaseCamera() {
        purchaseFacingMode = (purchaseFacingMode === "environment") ? "user" : "environment";
        startPurchaseCameraScanner();
    }

    function stopPurchaseCameraScanner() {
        if (purchaseHtml5QrCode && purchaseHtml5QrCode.isScanning) {
            purchaseHtml5QrCode.stop().then(() => {
                purchaseHtml5QrCode.clear();
            }).catch(() => {});
        }
    }

    function playScanBeepSound() {
        try {
            const ctx = new(window.AudioContext || window.webkitAudioContext)();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.type = "sine";
            osc.frequency.setValueAtTime(880, ctx.currentTime);
            gain.gain.setValueAtTime(0.2, ctx.currentTime);
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.start();
            osc.stop(ctx.currentTime + 0.12);
        } catch (e) {}
    }
</script>

<script>
    function formatProductCode(productCode) {
        if (!productCode) return '';
        try {
            if (Array.isArray(JSON.parse(productCode))) {
                return JSON.parse(productCode).join(', ');
            }
        } catch (e) {
            return productCode;
        }
        return productCode;
    }
</script>

<script>
    const paymentMethodSelect = document.getElementById('paymentMethod');
    const paymentDetailsInput = document.getElementById('paymentDetails');

    paymentMethodSelect.addEventListener('change', function() {
        const selectedMethod = this.value;

        if (['Bkash', 'Nagad', 'Bank'].includes(selectedMethod)) {
            paymentDetailsInput.style.display = 'block';
            paymentDetailsInput.placeholder = `Enter ${selectedMethod} transaction details`;
        } else {
            paymentDetailsInput.style.display = 'none';
            paymentDetailsInput.value = '';
        }
    });

    let allProducts = [];

    async function ProductDataShow() {
        try {
            let res = await axios.get("/api/product-list", HeaderToken());
            allProducts = res.data.ProductData || [];
        } catch (error) {
            console.error("Error occurred while fetching products:", error);
        }
    }

    ProductDataShow();

    // Check if query matches exact code/barcode or exact name
    function isExactCodeMatch(product, query) {
        if (!product || !query) return false;
        const q = query.trim().toLowerCase();
        if (!q) return false;

        if (product.product_code) {
            let strCode = product.product_code.toString().toLowerCase();
            try {
                let parsed = JSON.parse(product.product_code);
                if (Array.isArray(parsed)) {
                    if (parsed.some(c => c.toString().trim().toLowerCase() === q)) return true;
                } else if (parsed.toString().trim().toLowerCase() === q) {
                    return true;
                }
            } catch (e) {
                if (strCode.trim() === q) return true;
            }
            if (strCode.trim() === q) return true;
        }

        if (product.product_name && product.product_name.trim().toLowerCase() === q) return true;

        return false;
    }

    // Auto-Add product when code is typed/scanned into input
    document.getElementById('productInputData').addEventListener('input', function() {
        const searchValue = this.value.trim().toLowerCase();
        const productDropdown = document.getElementById('productDropdown');

        if (!searchValue) {
            productDropdown.innerHTML = '';
            return;
        }

        // 1. Check for EXACT barcode/code match
        const exactMatch = allProducts.find(product => isExactCodeMatch(product, searchValue));
        if (exactMatch) {
            addProductToOrder(exactMatch);
            this.value = '';
            productDropdown.innerHTML = '';
            playScanBeepSound();
            successToast(`স্ক্যান করা হয়েছে: ${exactMatch.product_name}`);
            return;
        }

        // 2. Filter dropdown
        const filteredProducts = allProducts.filter(product => {
            const nameMatch = product.product_name && product.product_name.toLowerCase().includes(searchValue);
            const codeMatch = product.product_code && product.product_code.toString().toLowerCase().includes(searchValue);
            return nameMatch || codeMatch;
        });

        productDropdown.innerHTML = '';

        if (filteredProducts.length === 0) {
            productDropdown.innerHTML = '<li class="list-group-item text-muted text-center small py-2">কোনো প্রোডাক্ট পাওয়া যায়নি</li>';
            return;
        }

        filteredProducts.forEach(product => {
            const productItem = document.createElement('li');
            productItem.classList.add('list-group-item', 'list-group-item-action', 'd-flex', 'justify-content-between', 'align-items-center', 'py-2', 'px-3');

            const formattedCode = formatProductCode(product.product_code);
            const doorBadge = product.door_side ? `<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 ms-1" style="font-size: 10px;"><i class="fa-solid fa-door-open me-1"></i>${product.door_side}</span>` : '';
            productItem.innerHTML = `
                <div>
                    <strong class="text-dark">${product.product_name}</strong> ${doorBadge}
                    <div class="small text-muted">স্টক: ${product.quantity || 0} | কেনা মূল্য: ৳${parseFloat(product.cost_price || 0).toFixed(2)}</div>
                </div>
                <span class="badge bg-light text-dark border font-monospace">${formattedCode}</span>
            `;

            productItem.addEventListener('click', function() {
                addProductToOrder(product);
                productDropdown.innerHTML = '';
                document.getElementById('productInputData').value = '';
                document.getElementById('productInputData').focus();
            });

            productDropdown.appendChild(productItem);
        });
    });

    // Enter Keypress Handler for Barcode Guns
    document.getElementById('productInputData').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const searchValue = this.value.trim().toLowerCase();
            if (!searchValue) return;

            const exactMatch = allProducts.find(product => isExactCodeMatch(product, searchValue));
            const matched = exactMatch || allProducts.find(product => {
                const nameMatch = product.product_name && product.product_name.toLowerCase().includes(searchValue);
                const codeMatch = product.product_code && product.product_code.toString().toLowerCase().includes(searchValue);
                const doorMatch = product.door_side && product.door_side.toLowerCase().includes(searchValue);
                return nameMatch || codeMatch || doorMatch;
            });

            if (matched) {
                addProductToOrder(matched);
                this.value = '';
                document.getElementById('productDropdown').innerHTML = '';
                playScanBeepSound();
                successToast(`কার্টে যোগ হয়েছে: ${matched.product_name}`);
            } else {
                errorToast(`প্রোডাক্ট কোড বা নাম পাওয়া যায়নি: ${this.value}`);
            }
        }
    });

    function addProductToOrder(product) {
        const orderTableBody = document.getElementById('orderTableBody');

        // Check if product is already in table
        const existingRows = orderTableBody.querySelectorAll('tr.body-row');
        let existingRow = null;

        existingRows.forEach(row => {
            const pIdCell = row.cells[1] || row.querySelector('.product-id-val');
            if (pIdCell && pIdCell.innerText.trim() == product.id) {
                existingRow = row;
            }
        });

        if (existingRow) {
            // Increment quantity
            const qtyInput = existingRow.querySelector('.quantity');
            let currentQty = parseInt(qtyInput.value) || 0;
            qtyInput.value = currentQty + 1;

            // Highlight row with green flash animation
            existingRow.style.transition = 'background-color 0.3s ease';
            existingRow.style.backgroundColor = '#dcfce7';
            setTimeout(() => {
                existingRow.style.backgroundColor = '';
            }, 600);

            // Update subtotal
            updateRowSubtotal.call(qtyInput);
            return;
        }

        // Insert new row
        const costPrice = parseFloat(product.cost_price || 0);
        const newRow = orderTableBody.insertRow();
        newRow.className = 'body-row align-middle';

        const rowDoorBadge = product.door_side ? `<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 ms-1" style="font-size: 10px;"><i class="fa-solid fa-door-open me-1"></i>${product.door_side}</span>` : '';

        newRow.innerHTML = `
            <td class="body-cell py-3 px-3">
                <div class="fw-bold text-dark fs-6">${product.product_name} ${rowDoorBadge}</div>
                <div class="small text-muted">ID: #${product.id}</div>
            </td>
            <td style="display: none;" class="product-id-val">${product.id}</td>
            <td class="body-cell py-3 px-2">
                <div class="mb-1">
                    <input type="text" id="UpdateProductCode" class="form-control form-control-sm bg-light text-dark fw-bold font-monospace" value="${formatProductCode(product.product_code)}" placeholder="Barcodes" readonly style="font-size: 12px;" />
                </div>
                <div class="input-group input-group-sm">
                    <input class="enter_barcode form-control" id="ProductBarCodeInput" type="text" placeholder="Add Barcode" style="font-size: 12px;" />
                    <button type="button" class="btn btn-outline-teal btn-sm" onclick="ADDProductBarCode(this)" style="background:#0d9488; color:#fff; font-size:11px;">+ Add</button>
                </div>
            </td>
            <td class="body-cell py-3 px-2 text-center" style="width: 140px;">
                <div class="d-inline-flex align-items-center justify-content-center border rounded-3 p-1 bg-white shadow-sm" style="white-space: nowrap;">
                    <button type="button" class="btn btn-sm btn-light border-0 fw-bold px-2 py-0" onclick="changeRowQty(this, -1)" style="font-size: 16px; width: 28px; height: 28px; line-height: 1; border-radius: 6px; color: #475569;">-</button>
                    <input type="number" value="1" min="1" class="form-control form-control-sm text-center border-0 fw-bold quantity px-1" style="width: 45px; height: 28px; font-size: 14px; background: transparent; box-shadow: none;" />
                    <button type="button" class="btn btn-sm btn-light border-0 fw-bold px-2 py-0" onclick="changeRowQty(this, 1)" style="font-size: 16px; width: 28px; height: 28px; line-height: 1; border-radius: 6px; color: #475569;">+</button>
                </div>
            </td>
            <td class="body-cell py-3 px-2" style="width: 140px;">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light">৳</span>
                    <input type="number" step="any" value="${costPrice ? costPrice : ''}" id="EnterCostPrice" class="form-control cost-price fw-bold" placeholder="Cost" />
                </div>
            </td>
            <td class="subtotal body-cell py-3 px-3 text-end fw-bold text-success fs-6" style="width: 130px;">
                ৳ ${(1 * costPrice).toFixed(2)}
            </td>
            <td class="body-cell py-3 px-2 text-center" style="width: 60px;">
                <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-circle" onclick="removeRow(this)" title="Remove item">
                    <i class="fa-solid fa-trash-can fs-6"></i>
                </button>
            </td>
        `;

        newRow.querySelector('.quantity').addEventListener('input', updateRowSubtotal);
        newRow.querySelector('.cost-price').addEventListener('input', updateRowSubtotal);

        updateTotals();
    }

    function changeRowQty(btn, delta) {
        const row = btn.closest('tr');
        const qtyInput = row.querySelector('.quantity');
        let val = (parseInt(qtyInput.value) || 0) + delta;
        if (val < 1) val = 1;
        qtyInput.value = val;
        updateRowSubtotal.call(qtyInput);
    }

    function updateRowSubtotal() {
        const row = this.closest('tr');
        const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
        const costPrice = parseFloat(row.querySelector('.cost-price').value) || 0;
        const subtotal = quantity * costPrice;

        row.querySelector('.subtotal').innerText = '৳ ' + subtotal.toFixed(2);
        updateTotals();
    }

    function updateTotals() {
        let totalQuantity = 0;
        let totalSubTotal = 0;

        const rows = document.querySelectorAll('#orderTableBody tr');
        rows.forEach(row => {
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            const costPrice = parseFloat(row.querySelector('.cost-price').value) || 0;
            const subtotal = quantity * costPrice;

            totalQuantity += quantity;
            totalSubTotal += subtotal;

            row.querySelector('.subtotal').innerText = '৳ ' + subtotal.toFixed(2);
        });

        document.getElementById('totalQuantity').innerText = totalQuantity.toFixed(2);
        document.getElementById('totalSubTotal').innerText = totalSubTotal.toFixed(2);

        const grandSubtotal = totalSubTotal;
        document.getElementById('grandSubtotal').value = grandSubtotal.toFixed(2);

        if (typeof window.calculateDuePayment === 'function') {
            window.calculateDuePayment();
        }
    }

    function removeRow(button) {
        const row = button.closest('tr');
        if (row && row.parentElement) {
            row.parentElement.removeChild(row);
            updateTotals();
        }
    }

    let UpdatebarcodeLists = {};

    function ADDProductBarCode(button) {
        const row = button.closest('tr');
        const productId = row.querySelector('.product-id-val').innerText.trim();
        const barcodeInput = row.querySelector('#ProductBarCodeInput');
        const UpdateProductCode = row.querySelector('#UpdateProductCode');

        const barcode = barcodeInput.value.trim();

        if (!barcode) {
            alert("Please enter a barcode!");
            return;
        }

        if (!UpdatebarcodeLists[productId]) {
            UpdatebarcodeLists[productId] = [];
        }

        const existingBarcodes = UpdateProductCode.value.split(', ').filter(code => code.trim());
        UpdatebarcodeLists[productId] = Array.from(new Set([...UpdatebarcodeLists[productId], ...existingBarcodes]));

        if (UpdatebarcodeLists[productId].includes(barcode)) {
            alert('This barcode is already added!');
            return;
        }

        UpdatebarcodeLists[productId].push(barcode);
        UpdateProductCode.value = UpdatebarcodeLists[productId].join(', ');
        barcodeInput.value = '';
    }

    const today = new Date().toISOString().split('T')[0];
    if (document.getElementById('PurchaseDate')) {
        document.getElementById('PurchaseDate').value = today;
    }

    async function PurchaseDataSave(event) {
        if (event) event.preventDefault();

        let products = [];
        const rows = document.querySelectorAll('#orderTableBody tr');

        rows.forEach(row => {
            const productId = row.querySelector('.product-id-val').innerText.trim();
            const quantity = parseInt(row.querySelector('.quantity').value) || 0;
            const costPrice = parseFloat(row.querySelector('.cost-price').value) || 0;
            const subtotalText = row.querySelector('.subtotal').innerText.replace(/[^\d.]/g, '');
            const subtotal = parseFloat(subtotalText) || (quantity * costPrice);
            const ProductCodes = UpdatebarcodeLists[productId] || [];

            if (quantity <= 0) {
                alert("Quantity must be greater than zero!");
                return;
            }

            products.push({
                product_id: productId,
                quantity: quantity,
                product_code: ProductCodes,
                cost_price: costPrice,
                subtotal: subtotal
            });
        });

        if (products.length === 0) {
            alert("At least one product must be added!");
            return;
        }

        let formData = new FormData();
        formData.append('supplier_id', document.getElementById('SupplierDataList').value);
        formData.append('purchase_payable_amount', document.getElementById('PurchasePayableAmount').value || 0);
        formData.append('date', document.getElementById('PurchaseDate').value);
        formData.append('purchase_due_collection_date', document.getElementById('PurchaseDate').value);
        formData.append('referance_no', document.getElementById('ReferenceNo').value);
        formData.append('payment_status', document.getElementById('paymentStatusDisplay').textContent.trim());
        formData.append('grand_subtotal', parseFloat(document.getElementById('grandSubtotal').value) || 0);
        formData.append('return_adjustment_amount', parseFloat(document.getElementById('returnAdjustmentAmount').value) || 0);
        formData.append('payment_method', document.getElementById('paymentMethod').value);
        formData.append('paid_amount', parseFloat(document.getElementById('paidAmount').value) || 0);
        formData.append('due_amount', parseFloat(document.getElementById('dueAmount').value) || 0);
        formData.append('transaction_id', document.getElementById('paymentDetails').value);
        formData.append('products', JSON.stringify(products));

        const imgInput = document.getElementById('AttachDocument');
        if (imgInput && imgInput.files[0]) {
            formData.append('img', imgInput.files[0]);
        }

        const config = {
            headers: {
                'content-type': 'multipart/form-data',
                ...HeaderToken().headers
            }
        };

        try {
            let res = await axios.post("/api/create-purchases", formData, config);

            if (res.data['status'] === "success") {
                successToast(res.data['message']);
                const formEl = document.getElementById("purchaseCreateForm") || document.getElementById("signup");
                if (formEl) formEl.reset();
                const modal = document.getElementById('exampleModal');
                closeModal(modal);
                location.reload();
            } else {
                errorToast(res.data['message']);
            }
        } catch (e) {
            console.error("Purchase Save Error:", e);
            unauthorized(e.response?.status);
        }
    }

    function closeModal(modal) {
        if (!modal) modal = document.getElementById('exampleModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }
</script>