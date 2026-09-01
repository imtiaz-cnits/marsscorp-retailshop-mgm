<!-- Sales & Purchase Return Processing Modal -->
<div class="modal fade" id="processReturnModal" tabindex="-1" aria-labelledby="processReturnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">

            <!-- Modal Header -->
            <div id="modalHeaderBox" class="modal-header bg-success text-white py-3" style="border-top-left-radius: 20px; border-top-right-radius: 20px; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important;">
                <h5 class="modal-title fw-bold text-white fs-5 d-flex align-items-center gap-2" id="processReturnModalLabel">
                    <i id="modalHeaderIcon" class="fa-solid fa-arrow-rotate-left"></i> <span id="modalHeaderTitle">Sales Return Processing</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">

                <!-- Search Bar inside Modal -->
                <div class="card border-0 bg-light p-3 mb-3" style="border-radius: 12px;">
                    <label id="modalSearchLabel" class="form-label fw-bold text-dark small mb-1">Search Invoice Number (ইনভয়েস নাম্বার লিখুন)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i id="modalSearchIcon" class="fa-solid fa-receipt text-success"></i></span>
                        <input type="text" id="modalInvoiceSearchInput" class="form-control border-start-0 ps-0 fw-bold" placeholder="e.g. #InvID00001 or PUR-0001" onkeydown="if(event.key==='Enter') searchInvoiceInModal()" />
                        <button id="modalSearchBtn" onclick="searchInvoiceInModal()" class="btn btn-success fw-bold px-4">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> Search
                        </button>
                    </div>
                </div>

                <!-- Invoice / Purchase Details Summary Card (Initially Hidden) -->
                <div id="invoiceSummaryCard" class="d-none mb-3 p-3 bg-success-subtle border border-success-subtle rounded-3">
                    <div class="row text-dark">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <span id="summaryNoLabel" class="text-muted small fw-semibold d-block">Invoice / Order No:</span>
                            <h5 id="modalOrderNo" class="fw-bold text-success mb-1">#InvID00001</h5>
                            <span id="summaryPartyLabel" class="text-muted small fw-semibold d-block">Customer Name:</span>
                            <span id="modalCustomerName" class="fw-bold d-block">Rakib Hasan</span>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <span class="text-muted small fw-semibold d-block"><span id="summaryDateLabel">Purchase Date</span>: <strong id="modalInvoiceDate" class="text-dark">01 Aug 2026</strong></span>
                            <span class="text-muted small fw-semibold d-block">Sub Total: <strong id="modalSubTotal" class="text-dark">৳ 0.00</strong></span>
                            <span class="text-muted small fw-semibold d-block">Paid: <strong id="modalPaidAmount" class="text-success">৳ 0.00</strong> | Due: <strong id="modalDueAmount" class="text-danger">৳ 0.00</strong></span>
                        </div>
                    </div>
                </div>

                <!-- Return Products Table (Initially Hidden) -->
                <div id="returnItemsContainer" class="d-none">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-square-check text-success me-1"></i> যে আইটেমগুলো রিটার্ন করবেন সেগুলো সিলেক্ট করুন:</h6>
                        <span class="badge bg-light text-dark border fw-semibold">টিক দিয়ে সংখ্যা ইনপুট দিন</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle table-bordered mb-0">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="text-center" style="width: 50px;">
                                        <input type="checkbox" id="selectAllReturnItems" class="form-check-input cursor-pointer" onchange="toggleSelectAllReturnItems(this)" title="Select All Items" />
                                    </th>
                                    <th>Product Name</th>
                                    <th class="text-center" style="width: 100px;">Quantity</th>
                                    <th class="text-end" style="width: 110px;">Unit Price</th>
                                    <th class="text-center" style="width: 120px;">Return Qty</th>
                                    <th class="text-end pe-3" style="width: 130px;">Refund Total</th>
                                </tr>
                            </thead>
                            <tbody id="returnItemsTbody">
                                <!-- Populated dynamically -->
                            </tbody>
                            <tfoot class="bg-light fw-bold">
                                <tr>
                                    <td colspan="5" class="text-end text-uppercase">Total Refund Amount (মোট রিফান্ড):</td>
                                    <td id="totalRefundText" class="text-end pe-3 text-success fs-6">৳ 0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Return Date (রিটার্ন তারিখ)</label>
                            <input type="date" id="modalReturnDate" class="form-control fw-semibold" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Return Reason / Note (কারণ)</label>
                            <input type="text" id="modalReturnNote" class="form-control fw-semibold" placeholder="Optional return note" />
                        </div>
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="modal-footer bg-light py-3" style="border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
                <button type="button" class="btn btn-secondary fw-bold rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="submitReturnBtn" onclick="submitReturnForm()" class="btn btn-success fw-bold rounded-pill px-5 d-none" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none;">
                    <i class="fa-solid fa-check me-1"></i> Process Return
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    let currentReturnMode = 'sales'; // 'sales' or 'purchase'
    let currentReturnOrderData = null;

    function openReturnModal(orderNo = '', mode = 'sales') {
        currentReturnMode = mode;
        currentReturnOrderData = null;

        const headerBox = document.getElementById('modalHeaderBox');
        const headerTitle = document.getElementById('modalHeaderTitle');
        const headerIcon = document.getElementById('modalHeaderIcon');
        const searchLabel = document.getElementById('modalSearchLabel');
        const searchIcon = document.getElementById('modalSearchIcon');

        if (mode === 'purchase') {
            headerTitle.innerText = 'Purchase Return Processing (পারচেজ রিটার্ন)';
            headerIcon.className = 'fa-solid fa-truck-ramp-box';
            headerBox.style.background = 'linear-gradient(135deg, #0d9488 0%, #14b8a6 100%)';
            searchLabel.innerText = 'Search Purchase Memo / Invoice (পারচেজ মেমো নম্বর লিখুন)';
            searchIcon.className = 'fa-solid fa-file-invoice text-teal';
            document.getElementById('modalInvoiceSearchInput').placeholder = 'e.g. #PurID00001 or 1';
            document.getElementById('summaryNoLabel').innerText = 'Purchase No:';
            document.getElementById('summaryPartyLabel').innerText = 'Supplier Name:';
            document.getElementById('summaryDateLabel').innerText = 'Purchase Date';
        } else {
            headerTitle.innerText = 'Sales Return Processing (সেলস রিটার্ন)';
            headerIcon.className = 'fa-solid fa-arrow-rotate-left';
            headerBox.style.background = 'linear-gradient(135deg, #15803d 0%, #16a34a 100%)';
            searchLabel.innerText = 'Search Invoice Number (ইনভয়েস নাম্বার লিখুন)';
            searchIcon.className = 'fa-solid fa-receipt text-success';
            document.getElementById('modalInvoiceSearchInput').placeholder = 'e.g. #InvID00001 or 1';
            document.getElementById('summaryNoLabel').innerText = 'Invoice / Order No:';
            document.getElementById('summaryPartyLabel').innerText = 'Customer Name:';
            document.getElementById('summaryDateLabel').innerText = 'Sale Date';
        }

        document.getElementById('modalInvoiceSearchInput').value = orderNo;
        document.getElementById('invoiceSummaryCard').classList.add('d-none');
        document.getElementById('returnItemsContainer').classList.add('d-none');
        document.getElementById('submitReturnBtn').classList.add('d-none');
        document.getElementById('returnItemsTbody').innerHTML = '';
        if (document.getElementById('selectAllReturnItems')) {
            document.getElementById('selectAllReturnItems').checked = false;
        }

        const today = new Date().toISOString().split("T")[0];
        document.getElementById('modalReturnDate').value = today;

        const modalEl = document.getElementById('processReturnModal');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();

        if (orderNo) {
            searchInvoiceInModal();
        }
    }

    async function searchInvoiceInModal() {
        const queryNo = document.getElementById('modalInvoiceSearchInput').value.trim();
        if (!queryNo) {
            alert(currentReturnMode === 'purchase' ? 'Please enter a purchase memo number' : 'Please enter an invoice number');
            return;
        }

        try {
            if (typeof showLoader === "function") showLoader();

            let url = '';
            if (currentReturnMode === 'purchase') {
                url = `/api/search-purchase-for-return?purchase_no=${encodeURIComponent(queryNo)}`;
            } else {
                url = `/api/search-invoice-for-return?order_no=${encodeURIComponent(queryNo)}`;
            }

            const res = await axios.get(url, HeaderToken());
            if (typeof hideLoader === "function") hideLoader();

            if (res.data && res.data.status === 'success') {
                if (currentReturnMode === 'purchase') {
                    const purchase = res.data.purchase;
                    currentReturnOrderData = purchase;

                    document.getElementById('modalOrderNo').innerText = purchase.purchase_no;
                    document.getElementById('modalCustomerName').innerText = `${purchase.supplier_name} (${purchase.supplier_mobile})`;
                    document.getElementById('modalInvoiceDate').innerText = purchase.purchase_date;
                    document.getElementById('modalSubTotal').innerText = '৳ ' + formatMoney(purchase.grand_subtotal);
                    document.getElementById('modalPaidAmount').innerText = '৳ ' + formatMoney(purchase.paid_amount);
                    document.getElementById('modalDueAmount').innerText = '৳ ' + formatMoney(purchase.due_amount);

                    renderReturnItems(purchase.items);
                } else {
                    const order = res.data.order;
                    currentReturnOrderData = order;

                    document.getElementById('modalOrderNo').innerText = order.order_no;
                    document.getElementById('modalCustomerName').innerText = `${order.customer_name} (${order.customer_mobile})`;
                    document.getElementById('modalInvoiceDate').innerText = order.invoice_date;
                    document.getElementById('modalSubTotal').innerText = '৳ ' + formatMoney(order.sub_total);
                    document.getElementById('modalPaidAmount').innerText = '৳ ' + formatMoney(order.paid_amount);
                    document.getElementById('modalDueAmount').innerText = '৳ ' + formatMoney(order.due_amount);

                    renderReturnItems(order.items);
                }

                document.getElementById('invoiceSummaryCard').classList.remove('d-none');
                document.getElementById('returnItemsContainer').classList.remove('d-none');
                document.getElementById('submitReturnBtn').classList.remove('d-none');
            } else {
                alert(res.data.message || (currentReturnMode === 'purchase' ? 'Purchase memo not found' : 'Invoice not found'));
            }
        } catch (e) {
            if (typeof hideLoader === "function") hideLoader();
            console.error('Invoice Search Error:', e);
            alert('Failed to search invoice');
        }
    }

    function renderReturnItems(items) {
        const tbody = document.getElementById('returnItemsTbody');
        tbody.innerHTML = '';

        if (!items || items.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center py-3 text-muted">No items found</td></tr>`;
            return;
        }

        items.forEach((item, idx) => {
            const detailId = currentReturnMode === 'purchase' ? item.purchase_order_detail_id : item.order_detail_id;
            const doorBadge = item.door_side ? `<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-0 ms-1 fw-normal" style="font-size: 10px;"><i class="fa-solid fa-door-open me-1"></i>${item.door_side}</span>` : '';
            const row = `
                <tr data-detail-id="${detailId}" data-product-id="${item.product_id}" data-unit-price="${item.unit_price}">
                    <td class="text-center">
                        <input type="checkbox" class="form-check-input cursor-pointer item-select-checkbox" onchange="onItemCheckboxChange(this)" />
                    </td>
                    <td>
                        <div class="fw-bold text-dark">${item.product_name} ${doorBadge}</div>
                        <span class="badge bg-light text-dark border font-monospace" style="font-size: 10px;">${item.product_code}</span>
                    </td>
                    <td class="text-center fw-bold">${item.quantity} pcs</td>
                    <td class="text-end fw-semibold">৳ ${formatMoney(item.unit_price)}</td>
                    <td class="text-center">
                        <input type="number" class="form-control form-control-sm text-center fw-bold return-qty-input" 
                               min="1" max="${item.quantity}" value="0" disabled
                               oninput="onQtyInputChange(this)" onblur="onQtyInputBlur(this)" />
                    </td>
                    <td class="text-end pe-3 fw-bold text-success refund-item-total">৳ 0.00</td>
                </tr>
            `;
            tbody.innerHTML += row;
        });

        recalculateTotalRefund();
    }

    function onItemCheckboxChange(chk) {
        const tr = chk.closest('tr');
        const qtyInput = tr.querySelector('.return-qty-input');
        const maxQty = parseInt(qtyInput.getAttribute('max')) || 1;

        if (chk.checked) {
            tr.classList.add('table-success');
            qtyInput.disabled = false;
            let val = parseInt(qtyInput.value) || 0;
            if (val <= 0) {
                qtyInput.value = 1;
            } else if (val > maxQty) {
                qtyInput.value = maxQty;
            }
            setTimeout(() => {
                qtyInput.focus();
                qtyInput.select();
            }, 50);
        } else {
            tr.classList.remove('table-success');
            qtyInput.value = 0;
            qtyInput.disabled = true;
        }
        recalculateTotalRefund();
    }

    function onQtyInputChange(input) {
        const tr = input.closest('tr');
        const chk = tr.querySelector('.item-select-checkbox');
        const maxQty = parseInt(input.getAttribute('max')) || 1;

        if (input.value !== '') {
            let val = parseInt(input.value);
            if (isNaN(val)) val = 0;

            if (val > maxQty) {
                input.value = maxQty;
            }

            if (val > 0 && !chk.checked) {
                chk.checked = true;
                tr.classList.add('table-success');
                input.disabled = false;
            }
        }

        recalculateTotalRefund();
    }

    function onQtyInputBlur(input) {
        const tr = input.closest('tr');
        const chk = tr.querySelector('.item-select-checkbox');
        const maxQty = parseInt(input.getAttribute('max')) || 1;

        let val = parseInt(input.value);
        if (isNaN(val) || val <= 0) {
            if (chk.checked) {
                input.value = 1;
            } else {
                input.value = 0;
            }
        } else if (val > maxQty) {
            input.value = maxQty;
        }
        recalculateTotalRefund();
    }

    function toggleSelectAllReturnItems(headerChk) {
        const checkboxes = document.querySelectorAll('.item-select-checkbox');
        checkboxes.forEach(chk => {
            chk.checked = headerChk.checked;
            onItemCheckboxChange(chk);
        });
    }

    function recalculateTotalRefund() {
        let grandTotalRefund = 0;
        const rows = document.querySelectorAll('#returnItemsTbody tr');

        rows.forEach(row => {
            const chk = row.querySelector('.item-select-checkbox');
            const unitPrice = parseFloat(row.getAttribute('data-unit-price')) || 0;
            const qtyInput = row.querySelector('.return-qty-input');
            const itemTotalTd = row.querySelector('.refund-item-total');

            let qty = 0;
            if (chk && chk.checked) {
                qty = parseInt(qtyInput.value) || 0;
                const maxQty = parseInt(qtyInput.getAttribute('max')) || 0;
                if (qty > maxQty) qty = maxQty;
            }

            const itemRefund = qty * unitPrice;
            itemTotalTd.innerText = '৳ ' + formatMoney(itemRefund);
            grandTotalRefund += itemRefund;
        });

        document.getElementById('totalRefundText').innerText = '৳ ' + formatMoney(grandTotalRefund);
    }

    async function submitReturnForm() {
        if (!currentReturnOrderData) {
            alert('No record loaded');
            return;
        }

        const returnDate = document.getElementById('modalReturnDate').value;
        if (!returnDate) {
            alert('Please select a return date');
            return;
        }

        const returnedProducts = [];
        const rows = document.querySelectorAll('#returnItemsTbody tr');

        rows.forEach(row => {
            const chk = row.querySelector('.item-select-checkbox');
            if (chk && chk.checked) {
                const detailId = row.getAttribute('data-detail-id');
                const productId = row.getAttribute('data-product-id');
                const qtyInput = row.querySelector('.return-qty-input');
                const qty = parseInt(qtyInput.value) || 0;

                if (qty > 0) {
                    if (currentReturnMode === 'purchase') {
                        returnedProducts.push({
                            purchase_order_detail_id: detailId,
                            product_id: productId,
                            quantity: qty
                        });
                    } else {
                        returnedProducts.push({
                            order_detail_id: detailId,
                            product_id: productId,
                            quantity: qty
                        });
                    }
                }
            }
        });

        if (returnedProducts.length === 0) {
            alert('Please select at least one product and enter a return quantity greater than 0.');
            return;
        }

        let payload = {};
        let apiUrl = '';

        if (currentReturnMode === 'purchase') {
            apiUrl = '/api/create-purchase-return';
            payload = {
                purchase_id: currentReturnOrderData.id,
                supplier_id: currentReturnOrderData.supplier_id,
                date: returnDate,
                products: returnedProducts
            };
        } else {
            apiUrl = '/api/create-return-product';
            payload = {
                order_id: currentReturnOrderData.id,
                customer_id: currentReturnOrderData.customer_id,
                date: returnDate,
                products: returnedProducts
            };
        }

        try {
            if (typeof showLoader === "function") showLoader();
            const res = await axios.post(apiUrl, payload, HeaderToken());
            if (typeof hideLoader === "function") hideLoader();

            if (res.data && res.data.status === 'success') {
                if (typeof successToast === "function") successToast(res.data.message || 'Return processed successfully');
                else alert('Return processed successfully');

                const modalEl = document.getElementById('processReturnModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                if (typeof fetchActiveReturnList === "function") fetchActiveReturnList();
            } else {
                alert(res.data.message || 'Failed to process return');
            }

        } catch (e) {
            if (typeof hideLoader === "function") hideLoader();
            console.error('Return Submit Error:', e);
            alert(e.response?.data?.message || 'Error processing return');
        }
    }
</script>