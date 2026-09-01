<style>
    #invoiceFullEditModal {
        z-index: 1060 !important;
    }
    #invoiceFullEditModal .modal-dialog {
        max-width: 880px;
        margin: 1.75rem auto;
    }
    #invoiceFullEditModal .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }
    #invoiceFullEditModal .form-control,
    #invoiceFullEditModal .form-select {
        height: 40px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        padding: 6px 10px;
    }
    #invoiceFullEditModal .qty-input {
        width: 60px;
        text-align: center;
        font-weight: 700;
    }
    #invoiceFullEditModal .table-items th {
        background-color: #f8fafc;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
    }
    #fullEditProductSearchResults .dropdown-item {
        padding: 10px 14px;
        cursor: pointer;
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    #fullEditProductSearchResults .dropdown-item:hover {
        background-color: #f0fdf4;
    }
</style>

<!-- Full Invoice & Product Item Edit Modal Start -->
<section class="modal fade" id="invoiceFullEditModal" tabindex="-1" aria-labelledby="invoiceFullEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-3">
            <div class="modal-header border-0 pb-2">
                <h5 class="modal-title fw-bold text-info d-flex align-items-center gap-2" id="invoiceFullEditModalLabel">
                    <i class="fa-solid fa-cart-flatbed-suitcases"></i>
                    <span>Edit Invoice & Product Items (ইনভয়েস ও প্রোডাক্ট আইটেম এডিট)</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pt-0">
                <form id="fullEditInvoiceForm" onsubmit="return SaveFullInvoiceEdit(event)">
                    <input type="hidden" id="fullEditInvoiceID">

                    <!-- Top Order Info -->
                    <div class="row g-2 mb-3 bg-light p-3 rounded-4 border">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-secondary mb-1">Invoice No (ইনভয়েস নম্বর)</label>
                            <input type="text" class="form-control bg-white fw-bold text-dark" id="fullEditOrderNo" readonly />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-secondary mb-1">Invoice Date (তারিখ)</label>
                            <input type="date" class="form-control bg-white" id="fullEditInvoiceDate" required />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-secondary mb-1">Customer (কাস্টমার)</label>
                            <select class="form-select bg-white" id="fullEditCustomerSelect">
                                <option value="">Select Customer</option>
                            </select>
                        </div>
                    </div>

                    <!-- Add New Product Search Bar & Camera Scanner -->
                    <div class="card border-0 bg-light p-2 mb-3 rounded-3" style="border: 1px dashed #cbd5e1 !important;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="flex-grow-1 position-relative">
                                <input type="text" id="fullEditSearchInput" class="form-control bg-white" placeholder="🔍 বারকোড স্ক্যান করুন অথবা কোড/নাম লিখুন..." autocomplete="off" style="height: 44px; font-size: 14px; border-radius: 10px;" />
                                
                                <!-- Dynamic Autocomplete Results Dropdown -->
                                <div id="fullEditProductSearchResults" class="dropdown-menu shadow-lg w-100 p-0 overflow-auto" style="max-height: 280px; display: none; position: absolute; z-index: 1070; top: 100%; left: 0; border-radius: 10px;"></div>
                            </div>

                            <button type="button" class="btn text-white fw-bold px-3 d-flex align-items-center gap-2 text-nowrap" onclick="openFullEditCameraScannerModal()" style="height: 44px; border-radius: 10px; background-color: #059669; border: none;">
                                <i class="fa-solid fa-camera fs-5"></i>
                                <span>ক্যামেরা স্ক্যান</span>
                            </button>
                        </div>
                    </div>

                    <!-- Products Table -->
                    <div class="table-responsive mb-3 border rounded-3 overflow-hidden">
                        <table class="table table-hover align-middle mb-0 table-items">
                            <thead>
                                <tr>
                                    <th class="ps-3 py-2" style="width: 40px;">#</th>
                                    <th class="py-2">Product Info (পণ্য)</th>
                                    <th class="py-2 text-center" style="width: 130px;">Price (দর ৳)</th>
                                    <th class="py-2 text-center" style="width: 140px;">Quantity (পরিমাণ)</th>
                                    <th class="py-2 text-end" style="width: 120px;">Subtotal (৳)</th>
                                    <th class="pe-3 py-2 text-center" style="width: 50px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="fullEditItemsTableBody">
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fa-solid fa-circle-notch fa-spin me-2"></i> প্রোডাক্ট ডাটা লোড হচ্ছে...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Financial Summary & Note -->
                    <div class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary mb-1">Order Note (ইনভয়েস নোট)</label>
                            <textarea class="form-control" id="fullEditOrderNote" rows="3" placeholder="Enter order notes / comments..." style="height: auto;"></textarea>
                        </div>

                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded-4 border">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fw-bold text-secondary small">Sub-Total (মোট বিল):</span>
                                    <span class="fw-extrabold fs-6 text-dark" id="fullEditSubTotalDisplay">৳ 0.00</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fw-bold text-secondary small">Discount Amount (ছাড়):</span>
                                    <div style="width: 120px;">
                                        <input type="number" step="any" class="form-control text-end fw-bold py-1" id="fullEditDiscount" oninput="recalculateFullEditFinancials()" value="0" style="height: 34px;" />
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fw-bold text-secondary small">Paid Amount (পরিশোধ):</span>
                                    <div style="width: 120px;">
                                        <input type="number" step="any" class="form-control text-end fw-bold text-success py-1" id="fullEditPaid" oninput="recalculateFullEditFinancials()" value="0" style="height: 34px;" />
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                    <span class="fw-bold text-danger small">Due Amount (বকেয়া):</span>
                                    <span class="fw-extrabold fs-6 text-danger" id="fullEditDueDisplay">৳ 0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="d-flex align-items-center justify-content-end gap-2 mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-light px-4 py-2 fw-bold text-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                        <button type="submit" class="btn btn-info text-white px-4 py-2 fw-bold" style="border-radius: 8px; background-color: #0284c7; border: none;">
                            <i class="fa-solid fa-check me-1"></i> Update Invoice & Products
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Full Invoice Edit Modal End -->

<!-- Camera Scanner Modal Start -->
<div class="modal fade" id="fullEditCameraScannerModal" tabindex="-1" aria-hidden="true" style="z-index: 1085 !important;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 text-center">
            <div class="modal-header border-0 pb-1">
                <h5 class="modal-title fw-bold text-success d-flex align-items-center gap-2">
                    <i class="fa-solid fa-camera"></i>
                    <span>ক্যামেরা বারকোড স্ক্যানার</span>
                </h5>
                <button type="button" class="btn-close" onclick="closeFullEditCameraScannerModal()"></button>
            </div>
            <div class="modal-body py-2">
                <div id="fullEditCameraReader" style="width: 100%; min-height: 250px; background: #000; border-radius: 12px; overflow: hidden;"></div>
                <div class="text-muted small mt-2">ক্যামেরার সামনে পণ্যের বারকোড বা কিউআর কোডটি ধরুন</div>
            </div>
        </div>
    </div>
</div>
<!-- Camera Scanner Modal End -->

<script>
    let fullEditItems = [];
    let allAvailableProducts = [];
    let fullEditHtml5QrCode = null;

    $(document).ready(function() {
        $('#invoiceFullEditModal').appendTo("body");
        $('#fullEditCameraScannerModal').appendTo("body");

        $('#invoiceFullEditModal').on('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (button) {
                const id = $(button).attr('data-id') || $(button).data('id') || $(button).closest('[data-id]').attr('data-id');
                if (id) {
                    FillUpFullInvoiceEditForm(id);
                }
            }
        });

        // Search Input Keyup Listener for Live Search & Barcode Scan
        $("#fullEditSearchInput").on("keyup input", function(e) {
            let term = $(this).val().trim();
            if (e.key === "Enter" || e.keyCode === 13) {
                e.preventDefault();
                processFullEditBarcodeSearch(term);
                return false;
            }
            filterFullEditProductDropdown(term);
        });

        // Hide search dropdown on click outside
        $(document).on("click", function(e) {
            if (!$(e.target).closest("#fullEditSearchInput, #fullEditProductSearchResults").length) {
                $("#fullEditProductSearchResults").hide();
            }
        });
    });

    async function LoadAllProductsForInvoiceEdit() {
        try {
            let res = await axios.get("/api/product-list", HeaderToken());
            if (res.data.status === "success" || res.data.ProductData || res.data.data) {
                allAvailableProducts = res.data.ProductData || res.data.data || res.data.rows || [];
            }
        } catch (e) {
            console.error("Error loading products:", e);
        }
    }

    async function LoadInvoiceCustomerDropdown() {
        try {
            let res = await axios.get("/api/customer-list", HeaderToken());
            let select = $('#fullEditCustomerSelect');
            select.find('option:not(:first)').remove();
            if (res.data.status === 'success' && res.data.CustomerData) {
                res.data.CustomerData.forEach(cust => {
                    select.append(`<option value="${cust.id}">${cust.customer_name} (${cust.mobile || ''})</option>`);
                });
            }
        } catch (e) {
            console.error("Error loading customers:", e);
        }
    }

    function filterFullEditProductDropdown(term) {
        let dropdown = $("#fullEditProductSearchResults");
        dropdown.empty();

        if (!term || term.length < 1) {
            dropdown.hide();
            return;
        }

        let searchTerm = term.toLowerCase();
        let matches = allAvailableProducts.filter(p => {
            let name = (p.product_name || '').toLowerCase();
            let code = (Array.isArray(p.product_code) ? p.product_code.join(' ') : (p.product_code || '')).toLowerCase();
            return name.includes(searchTerm) || code.includes(searchTerm);
        }).slice(0, 10);

        if (matches.length === 0) {
            dropdown.html(`<div class="p-3 text-center text-muted small">❌ কোনো প্রোডাক্ট পাওয়া যায়নি</div>`).show();
            return;
        }

        matches.forEach(prod => {
            let codeStr = Array.isArray(prod.product_code) ? prod.product_code.join(', ') : (prod.product_code || '');
            let itemHtml = `
                <div class="dropdown-item d-flex align-items-center justify-content-between" onclick="selectProductFromFullEditDropdown(${prod.id})">
                    <div>
                        <div class="fw-bold text-dark" style="font-size: 13px;">${prod.product_name}</div>
                        ${codeStr ? `<span class="badge bg-light text-primary border" style="font-size: 10px;">${codeStr}</span>` : ''}
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-success" style="font-size: 13px;">৳ ${parseFloat(prod.sell_price || 0).toFixed(2)}</div>
                        <small class="text-muted" style="font-size: 10px;">স্টক: ${prod.quantity || 0}</small>
                    </div>
                </div>
            `;
            dropdown.append(itemHtml);
        });

        dropdown.show();
    }

    function selectProductFromFullEditDropdown(productId) {
        let prod = allAvailableProducts.find(p => p.id == productId);
        if (prod) {
            addProductToFullEditItemsList(prod);
        }
        $("#fullEditSearchInput").val("");
        $("#fullEditProductSearchResults").hide();
    }

    function processFullEditBarcodeSearch(term) {
        if (!term) return;
        let searchTerm = term.toLowerCase();

        // Find exact match by barcode / code first
        let exactMatch = allAvailableProducts.find(p => {
            let codes = Array.isArray(p.product_code) ? p.product_code : [(p.product_code || '')];
            return codes.some(c => c.toString().toLowerCase() === searchTerm);
        });

        if (exactMatch) {
            addProductToFullEditItemsList(exactMatch);
            $("#fullEditSearchInput").val("");
            $("#fullEditProductSearchResults").hide();
            return;
        }

        // Partial match fallback
        let matches = allAvailableProducts.filter(p => {
            let name = (p.product_name || '').toLowerCase();
            let code = (Array.isArray(p.product_code) ? p.product_code.join(' ') : (p.product_code || '')).toLowerCase();
            return name.includes(searchTerm) || code.includes(searchTerm);
        });

        if (matches.length === 1) {
            addProductToFullEditItemsList(matches[0]);
            $("#fullEditSearchInput").val("");
            $("#fullEditProductSearchResults").hide();
        } else if (matches.length > 1) {
            filterFullEditProductDropdown(term);
        } else {
            errorToast("প্রোডাক্ট পাওয়া যায়নি!");
        }
    }

    function addProductToFullEditItemsList(prod) {
        let code = (Array.isArray(prod.product_code) ? prod.product_code[0] : prod.product_code) || '';
        let existingIndex = fullEditItems.findIndex(i => i.product_id == prod.id);

        if (existingIndex !== -1) {
            fullEditItems[existingIndex].quantity += 1;
        } else {
            fullEditItems.push({
                product_id: prod.id,
                product_name: prod.product_name,
                product_code: code,
                cost_price: parseFloat(prod.cost_price) || 0,
                selling_price: parseFloat(prod.sell_price) || 0,
                quantity: 1,
            });
        }

        successToast(`"${prod.product_name}" যুক্ত করা হয়েছে!`);
        renderFullEditItemsTable();
    }

    // Camera Scanner Functions
    function openFullEditCameraScannerModal() {
        $("#fullEditCameraScannerModal").modal('show');
        setTimeout(() => {
            startFullEditCameraScanner();
        }, 400);
    }

    function closeFullEditCameraScannerModal() {
        stopFullEditCameraScanner();
        $("#fullEditCameraScannerModal").modal('hide');
    }

    function startFullEditCameraScanner() {
        if (!window.Html5Qrcode) {
            errorToast("Camera scanner library not available.");
            return;
        }

        if (fullEditHtml5QrCode) {
            stopFullEditCameraScanner();
        }

        fullEditHtml5QrCode = new Html5Qrcode("fullEditCameraReader");
        fullEditHtml5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 250, height: 150 }
            },
            (decodedText, decodedResult) => {
                processFullEditBarcodeSearch(decodedText);
                closeFullEditCameraScannerModal();
            },
            (errorMessage) => {
                // Ignore scanning errors
            }
        ).catch(err => {
            console.error("Camera access error:", err);
            errorToast("ক্যামেরা ওপেন করা সম্ভব হয়নি! পারমিশন দিন।");
        });
    }

    function stopFullEditCameraScanner() {
        if (fullEditHtml5QrCode) {
            fullEditHtml5QrCode.stop().then(() => {
                fullEditHtml5QrCode.clear();
                fullEditHtml5QrCode = null;
            }).catch(err => {
                fullEditHtml5QrCode = null;
            });
        }
    }

    async function FillUpFullInvoiceEditForm(id) {
        try {
            document.getElementById('fullEditInvoiceID').value = id;
            await Promise.all([LoadInvoiceCustomerDropdown(), LoadAllProductsForInvoiceEdit()]);

            showLoader();
            let res = await axios.post("/api/invoice-full-details-by-id", {
                id: id.toString()
            }, HeaderToken());
            hideLoader();

            if (res.data.status === "success") {
                const data = res.data.rows;

                document.getElementById('fullEditOrderNo').value = data.order_no || '';
                document.getElementById('fullEditInvoiceDate').value = data.invoice_date || '';
                document.getElementById('fullEditDiscount').value = data.discount_amount || 0;
                document.getElementById('fullEditPaid').value = data.paid_amount || 0;
                document.getElementById('fullEditOrderNote').value = data.order_note || '';

                if (document.getElementById('fullEditCustomerSelect') && data.customer_id) {
                    document.getElementById('fullEditCustomerSelect').value = data.customer_id;
                }

                // Populate Items
                fullEditItems = (data.details || []).map(item => ({
                    product_id: item.product_id,
                    product_name: item.product_name,
                    product_code: item.product_code,
                    cost_price: parseFloat(item.cost_price) || 0,
                    selling_price: parseFloat(item.selling_price) || 0,
                    quantity: parseFloat(item.quantity) || 1,
                }));

                renderFullEditItemsTable();
            }
        } catch (e) {
            hideLoader();
            console.error("Error fetching invoice details:", e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    function renderFullEditItemsTable() {
        let tbody = $("#fullEditItemsTableBody");
        tbody.empty();

        if (!fullEditItems || fullEditItems.length === 0) {
            tbody.append(`
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="fa-solid fa-inbox me-2 opacity-50"></i> কোনো প্রোডাক্ট আইটেম নেই।
                    </td>
                </tr>
            `);
            recalculateFullEditFinancials();
            return;
        }

        fullEditItems.forEach((item, index) => {
            let itemSubtotal = item.selling_price * item.quantity;

            let row = `
                <tr>
                    <td class="ps-3 fw-bold text-secondary">${index + 1}</td>
                    <td>
                        <div class="fw-bold text-dark">${item.product_name}</div>
                        ${item.product_code ? `<span class="badge bg-light text-primary border" style="font-size: 10px;">${item.product_code}</span>` : ''}
                    </td>
                    <td class="text-center">
                        <input type="number" step="any" class="form-control text-center py-1 fw-bold" value="${item.selling_price}" onchange="updateFullEditItemPrice(${index}, this.value)" style="height: 32px; font-size: 12px;" />
                    </td>
                    <td class="text-center">
                        <div class="d-inline-flex align-items-center gap-1">
                            <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0" onclick="changeFullEditQty(${index}, -1)">-</button>
                            <input type="number" step="any" class="form-control qty-input py-1" value="${item.quantity}" onchange="updateFullEditItemQty(${index}, this.value)" style="height: 32px; font-size: 12px;" />
                            <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0" onclick="changeFullEditQty(${index}, 1)">+</button>
                        </div>
                    </td>
                    <td class="text-end fw-extrabold text-dark fs-6">৳ ${itemSubtotal.toFixed(2)}</td>
                    <td class="pe-3 text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-circle" onclick="removeFullEditItem(${index})" title="Remove Item">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });

        recalculateFullEditFinancials();
    }

    function changeFullEditQty(index, delta) {
        if (fullEditItems[index]) {
            let newQty = fullEditItems[index].quantity + delta;
            if (newQty <= 0) {
                removeFullEditItem(index);
            } else {
                fullEditItems[index].quantity = newQty;
                renderFullEditItemsTable();
            }
        }
    }

    function updateFullEditItemQty(index, val) {
        let qty = parseFloat(val) || 0;
        if (qty <= 0) {
            removeFullEditItem(index);
        } else if (fullEditItems[index]) {
            fullEditItems[index].quantity = qty;
            renderFullEditItemsTable();
        }
    }

    function updateFullEditItemPrice(index, val) {
        let price = parseFloat(val) || 0;
        if (fullEditItems[index]) {
            fullEditItems[index].selling_price = price;
            renderFullEditItemsTable();
        }
    }

    function removeFullEditItem(index) {
        fullEditItems.splice(index, 1);
        renderFullEditItemsTable();
    }

    function recalculateFullEditFinancials() {
        let subtotal = 0;
        fullEditItems.forEach(item => {
            subtotal += (item.selling_price * item.quantity);
        });

        const discount = parseFloat(document.getElementById('fullEditDiscount')?.value || 0);
        const paid = parseFloat(document.getElementById('fullEditPaid')?.value || 0);
        const due = Math.max(0, subtotal - discount - paid);

        document.getElementById('fullEditSubTotalDisplay').textContent = `৳ ${subtotal.toFixed(2)}`;
        document.getElementById('fullEditDueDisplay').textContent = `৳ ${due.toFixed(2)}`;
    }

    async function SaveFullInvoiceEdit(event) {
        if (event) event.preventDefault();

        try {
            const id = document.getElementById('fullEditInvoiceID').value;
            let subtotal = 0;
            fullEditItems.forEach(item => {
                subtotal += (item.selling_price * item.quantity);
            });

            const discountAmount = parseFloat(document.getElementById('fullEditDiscount').value) || 0;
            const paidAmount = parseFloat(document.getElementById('fullEditPaid').value) || 0;
            const invoiceDate = document.getElementById('fullEditInvoiceDate').value;
            const customerId = document.getElementById('fullEditCustomerSelect').value;
            const orderNote = document.getElementById('fullEditOrderNote').value;

            if (fullEditItems.length === 0) {
                errorToast("Please add at least one product item.");
                return false;
            }

            let formData = new FormData();
            formData.append('id', id);
            formData.append('sub_total', subtotal);
            formData.append('discount_amount', discountAmount);
            formData.append('paid_amount', paidAmount);
            formData.append('invoice_date', invoiceDate);
            formData.append('customer_id', customerId);
            formData.append('order_note', orderNote);
            formData.append('items', JSON.stringify(fullEditItems));

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            };

            showLoader();
            let res = await axios.post("/api/update-invoice-details", formData, config);
            hideLoader();

            if (res.data.status === "success") {
                successToast(res.data.message);
                $("#invoiceFullEditModal").modal('hide');
                if (typeof getList === 'function') {
                    await getList();
                } else if (typeof fetchInvoiceReport === 'function') {
                    await fetchInvoiceReport();
                } else {
                    setTimeout(() => location.reload(), 500);
                }
            } else {
                errorToast(res.data.message);
            }
        } catch (e) {
            hideLoader();
            console.error("Save error:", e);
            errorToast("Failed to update invoice & product items.");
        }
        return false;
    }
</script>
