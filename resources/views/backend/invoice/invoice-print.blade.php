<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Bill Invoice - MARSS CORPORATION</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Google Fonts: Valley Sans & Baloo Da 2 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Da+2:wght@400;500;600;700;800&family=Valley+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <!-- Axios -->
    <script src="{{ asset('backend/assets/js/axios.min.js') }}"></script>

    <style>
        body {
            background-color: #f1f5f9;
            margin: 0;
            padding: 20px;
            font-family: 'Valley Sans', 'Baloo Da 2', Arial, sans-serif;
            color: #0f172a;
        }

        .no-print-wrapper {
            max-width: 8in;
            margin: 0 auto 15px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* Invoice Sheet Paper - A4 / Letter format matching client paper */
        .invoice-container {
            background: #ffffff;
            padding: 20px 25px;
            border: 1px solid #cbd5e1;
            width: 8in;
            min-height: 10.5in;
            margin: 0 auto;
            box-sizing: border-box;
            position: relative;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .brand-logo-box {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .logo-emblem {
            text-align: center;
        }

        .logo-emblem .marss-txt {
            color: #dc2626;
            font-size: 11px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 2px;
        }

        .logo-emblem .mc-box {
            width: 44px;
            height: 44px;
            border: 2px solid #15803d;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 22px;
            background: #fff;
            position: relative;
        }

        .mc-box .m-red {
            color: #dc2626;
        }

        .mc-box .c-green {
            color: #15803d;
        }

        .brand-titles {
            display: flex;
            flex-direction: column;
        }

        .company-name {
            color: #15803d;
            font-weight: 900;
            font-size: 24px;
            line-height: 1.1;
            letter-spacing: 0.5px;
            margin: 0;
            font-family: 'Valley Sans', 'Arial Black', sans-serif;
        }

        .company-name .text-marss-red {
            color: #dc2626;
        }

        .company-tagline {
            color: #166534;
            font-size: 11.5px;
            font-weight: 700;
            margin-top: 3px;
            border-top: 1.5px solid #15803d;
            padding-top: 2px;
        }

        .bill-badge-wrapper {
            margin-top: 10px;
        }

        .bill-badge {
            background-color: #15803d;
            color: #ffffff;
            font-size: 18px;
            font-weight: 800;
            padding: 4px 18px;
            border-radius: 6px;
            display: inline-block;
            letter-spacing: 1px;
            font-family: 'Georgia', serif;
        }

        .header-office-info {
            text-align: right;
            font-size: 10.5px;
            color: #334155;
            line-height: 1.35;
            max-width: 250px;
        }

        .header-office-info strong {
            color: #0f172a;
        }

        /* Form Metadata Rows matching bill lines */
        .meta-grid {
            width: 100%;
            margin-bottom: 12px;
            font-size: 12px;
            line-height: 1.8;
        }

        .meta-line {
            display: flex;
            align-items: flex-end;
            margin-bottom: 4px;
        }

        .meta-label {
            font-weight: 600;
            color: #0f172a;
            white-space: nowrap;
            margin-right: 5px;
        }

        .meta-dots {
            flex: 1;
            border-bottom: 1px dotted #64748b;
            padding-left: 6px;
            font-weight: 600;
            color: #0f172a;
            min-height: 20px;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 12px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #000 !important;
            padding: 6px 8px;
        }

        .items-table th {
            background-color: #f8fafc;
            font-weight: 700;
            text-align: center;
            color: #0f172a;
            font-size: 12px;
        }

        .items-table td.sl-col {
            text-align: center;
            width: 6%;
        }

        .items-table td.desc-col {
            text-align: left;
        }

        .items-table td.rate-col {
            text-align: right;
            width: 14%;
        }

        .items-table td.qty-col {
            text-align: center;
            width: 10%;
        }

        .items-table td.amount-col {
            text-align: right;
            width: 18%;
        }

        .bill-main-body {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .items-table tbody {
            min-height: 380px;
        }

        /* Bottom Calculation Grid */
        .bill-footer-section {
            margin-top: auto;
        }

        .calc-summary-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 25px;
        }

        .taka-words-box {
            width: 60%;
            font-size: 12px;
        }

        .taka-words-line {
            display: flex;
            align-items: flex-end;
        }

        .taka-words-val {
            flex: 1;
            border-bottom: 1px dotted #64748b;
            font-weight: 700;
            padding-left: 6px;
            color: #0f172a;
        }

        .totals-table-box {
            width: 38%;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .totals-table td {
            border: 1px solid #000 !important;
            padding: 5px 8px;
        }

        .totals-table td.lbl {
            font-weight: 700;
            text-align: left;
            background-color: #f8fafc;
            width: 50%;
        }

        .totals-table td.val {
            font-weight: 700;
            text-align: right;
            width: 50%;
        }

        /* Signatures */
        .signatures-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 35px;
            padding-bottom: 15px;
            font-size: 12px;
            font-weight: 600;
        }

        .sig-box {
            width: 40%;
            text-align: center;
            border-top: 1px dotted #000;
            padding-top: 4px;
        }

        /* Bottom Red Green Accent Banner matching image */
        .bottom-color-bar {
            display: flex;
            height: 12px;
            width: 100%;
            margin-left: -25px;
            margin-right: -25px;
            margin-bottom: -20px;
            width: calc(100% + 50px);
        }

        .bottom-color-bar .red-bar {
            width: 50%;
            background-color: #dc2626;
        }

        .bottom-color-bar .green-bar {
            width: 50%;
            background-color: #15803d;
        }

        /* Print Media Overrides */
        @media print {
            @page {
                size: portrait;
                margin: 0mm;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                box-sizing: border-box !important;
            }

            html,
            body {
                background: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .no-print-wrapper {
                display: none !important;
            }

            .invoice-container {
                width: 100% !important;
                min-height: 100vh !important;
                border: none !important;
                box-shadow: none !important;
                padding: 12mm 15mm 10mm 15mm !important;
            }
        }
    </style>
</head>

<body>

    <!-- Top Action Toolbar -->
    <div class="no-print-wrapper">
        <div>
            <button class="btn btn-success fw-bold px-4 shadow-sm" onclick="printInvoice()" style="background-color: #15803d; border-color: #15803d;">
                <i class="fa-solid fa-print me-2"></i> Print Bill (মেমো প্রিন্ট)
            </button>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ url('admin-dashboard-pos') }}" class="btn btn-warning fw-bold text-dark shadow-sm">
                <i class="fa-solid fa-cart-shopping me-1"></i> POS Screen
            </a>
            <a href="{{ url('admin-dashboard-invoice') }}" class="btn btn-secondary fw-bold shadow-sm">
                <i class="fa-solid fa-list me-1"></i> Invoice List
            </a>
        </div>
    </div>

    <!-- Official Printable Bill Document -->
    <div class="invoice-container" id="printArea">
        <div class="bill-main-body">

            <!-- Header Section -->
            <div class="header-top">
                <div class="brand-logo-box d-flex align-items-center">
                    <img src="{{ asset('backend/assets/icons/marss-corporation-icon.svg') }}" alt="MARSS Corporation Logo" style="height: 52px; width: 52px; object-fit: contain; margin-right: 10px;" />
                    <div class="brand-titles">
                        <h1 class="company-name"><span class="text-marss-red">MARSS</span> CORPORATION</h1>
                        <div class="company-tagline">All Kinds of Dry &amp; Gel Battery Supplier</div>
                    </div>
                </div>

                <div class="bill-badge-wrapper text-center">
                    <div class="bill-badge">Bill</div>
                </div>

                <div class="header-office-info">
                    <div><strong>Office:</strong> Success Super Market,</div>
                    <div>Sadar Police Fari, Ataikula Road Pabna.</div>
                    <div><strong>Mobile:</strong> 01975-703216, 01715-842083</div>
                    <div><strong>E-mail:</strong> marsscorporation2018@gmail.com</div>
                </div>
            </div>

            <!-- Customer & Bill Meta Grid -->
            <div class="meta-grid mt-3">
                <div class="row g-2">
                    <div class="col-7">
                        <div class="meta-line">
                            <span class="meta-label">Bill No:</span>
                            <span class="meta-dots" id="order_no"></span>
                        </div>
                        <div class="meta-line">
                            <span class="meta-label">Challan No:</span>
                            <span class="meta-dots" id="orderNote"></span>
                        </div>
                        <div class="meta-line">
                            <span class="meta-label">Name of Customer:</span>
                            <span class="meta-dots" id="CustomerName"></span>
                        </div>
                        <div class="meta-line">
                            <span class="meta-label">Address:</span>
                            <span class="meta-dots" id="CustomerAddress"></span>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="meta-line">
                            <span class="meta-label">Bill Date:</span>
                            <span class="meta-dots" id="invoice_date"></span>
                        </div>
                        <div class="meta-line">
                            <span class="meta-label">Delivery Date:</span>
                            <span class="meta-dots" id="delivery_date"></span>
                        </div>
                        <div class="meta-line">
                            <span class="meta-label">Mob:</span>
                            <span class="meta-dots" id="CustomerMob"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Items Table -->
            <table class="items-table">
                <thead>
                    <tr>
                        <th class="sl-col">Sl.No.</th>
                        <th class="desc-col">Description</th>
                        <th class="rate-col">Rate</th>
                        <th class="qty-col">Qty.</th>
                        <th class="amount-col">Amount</th>
                    </tr>
                </thead>
                <tbody id="order_details">
                    <!-- Dynamic Product Rows -->
                </tbody>
            </table>

        </div>

        <!-- Footer Calculations & Signatures -->
        <div class="bill-footer-section">

            <div class="calc-summary-wrapper">
                <div class="taka-words-box">
                    <div class="taka-words-line">
                        <span class="meta-label">Taka in Words:</span>
                        <span class="taka-words-val" id="taka_words"></span>
                    </div>
                </div>

                <div class="totals-table-box">
                    <table class="totals-table">
                        <tr>
                            <td class="lbl">Total Bill</td>
                            <td class="val" id="sub_total">0.00</td>
                        </tr>
                        <tr id="discountRow">
                            <td class="lbl">Discount</td>
                            <td class="val" id="discount_amount">0.00</td>
                        </tr>
                        <tr>
                            <td class="lbl">Net Amount</td>
                            <td class="val" id="net_amount">0.00</td>
                        </tr>
                        <tr>
                            <td class="lbl">Paid Amount</td>
                            <td class="val" id="paidamount">0.00</td>
                        </tr>
                        <tr>
                            <td class="lbl">Today Due</td>
                            <td class="val" id="due_amount">0.00</td>
                        </tr>
                        <tr id="prevDueRow">
                            <td class="lbl">Previous Due</td>
                            <td class="val" id="previous_due_amount">0.00</td>
                        </tr>
                        <tr id="totalDueRow">
                            <td class="lbl" style="font-weight: 700; background-color: #f1f5f9;">Total Due</td>
                            <td class="val" id="total_due_amount" style="font-weight: 700; background-color: #f1f5f9;">0.00</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Signature Lines -->
            <div class="signatures-row">
                <div class="sig-box">
                    Received by
                </div>
                <div class="sig-box">
                    For Marss Corporation
                </div>
            </div>

            <!-- Red & Green Bottom Accent Bar -->
            <div class="bottom-color-bar">
                <div class="red-bar"></div>
                <div class="green-bar"></div>
            </div>

        </div>
    </div>

    <script>
        function HeaderToken() {
            let token = localStorage.getItem('token');
            return {
                headers: {
                    "Authorization": "Bearer " + token
                }
            }
        }

        fetchInvoiceDetails();

        async function fetchInvoiceDetails() {
            try {
                const response = await axios.get("/api/invoice-print-receipt", HeaderToken());

                if (response.data && !response.data.hasOwnProperty('error')) {
                    const invoiceData = response.data;

                    // Load Metadata
                    document.getElementById('order_no').innerText = invoiceData.order_no || '';
                    document.getElementById('orderNote').innerText = invoiceData.order_note || '';
                    document.getElementById('invoice_date').innerText = invoiceData.invoice_date || '';
                    document.getElementById('delivery_date').innerText = invoiceData.invoice_date || '';

                    // Customer Information
                    if (invoiceData.customer) {
                        document.getElementById('CustomerName').innerText = invoiceData.customer.customer_name || '';
                        document.getElementById('CustomerAddress').innerText = invoiceData.customer.address || '';
                        document.getElementById('CustomerMob').innerText = invoiceData.customer.mobile || '';
                    }

                    // Populate Items Table
                    const orderDetailsTable = document.getElementById('order_details');
                    orderDetailsTable.innerHTML = '';

                    const items = invoiceData.order_details || [];
                    items.forEach((detail, index) => {
                        const row = document.createElement('tr');
                        const itemTotal = (parseFloat(detail.selling_price) * parseFloat(detail.quantity)).toFixed(2);
                        const pName = detail.product_name || (detail.product ? detail.product.product_name : '');
                        const doorSide = detail.door_side || (detail.product ? detail.product.door_side : '');
                        const doorText = doorSide ? ` [${doorSide}]` : '';
                        row.innerHTML = `
                        <td class="sl-col">${index + 1}</td>
                        <td class="desc-col">${pName}${doorText}</td>
                        <td class="rate-col">${parseFloat(detail.selling_price).toFixed(2)}</td>
                        <td class="qty-col">${detail.quantity}</td>
                        <td class="amount-col">${itemTotal}</td>
                    `;
                        orderDetailsTable.appendChild(row);
                    });

                    // Pad empty rows to maintain full printed height if needed
                    const minRows = 10;
                    for (let i = items.length; i < minRows; i++) {
                        const emptyRow = document.createElement('tr');
                        emptyRow.innerHTML = `
                        <td class="sl-col">&nbsp;</td>
                        <td class="desc-col">&nbsp;</td>
                        <td class="rate-col">&nbsp;</td>
                        <td class="qty-col">&nbsp;</td>
                        <td class="amount-col">&nbsp;</td>
                    `;
                        orderDetailsTable.appendChild(emptyRow);
                    }

                    // Financial calculations
                    const subTotalVal = parseFloat(invoiceData.sub_total) || 0;
                    const discountVal = parseFloat(invoiceData.discount_amount) || 0;
                    const netVal = subTotalVal - discountVal;
                    const paidVal = parseFloat(invoiceData.paid_amount) || 0;
                    const dueVal = parseFloat(invoiceData.due_amount) || 0;
                    const prevDueVal = parseFloat(invoiceData.previous_due_amount) || 0;
                    const totalDueVal = typeof invoiceData.total_due_amount !== 'undefined' ? parseFloat(invoiceData.total_due_amount) : (prevDueVal + dueVal);

                    document.getElementById('sub_total').innerText = subTotalVal.toFixed(2);
                    document.getElementById('discount_amount').innerText = discountVal.toFixed(2);
                    document.getElementById('net_amount').innerText = netVal.toFixed(2);
                    document.getElementById('paidamount').innerText = paidVal.toFixed(2);
                    document.getElementById('due_amount').innerText = dueVal.toFixed(2);
                    document.getElementById('previous_due_amount').innerText = prevDueVal.toFixed(2);
                    document.getElementById('total_due_amount').innerText = totalDueVal.toFixed(2);

                    // Hide discount row if 0
                    if (discountVal <= 0) {
                        document.getElementById('discountRow').style.display = 'none';
                    } else {
                        document.getElementById('discountRow').style.display = 'table-row';
                    }

                    // Convert Net Amount to Taka in words
                    document.getElementById('taka_words').innerText = numberToWords(Math.round(netVal > 0 ? netVal : subTotalVal));

                    // Auto trigger print window
                    setTimeout(() => {
                        window.print();
                    }, 500);

                } else {
                    console.error('Error fetching invoice data:', response.data.error);
                }
            } catch (error) {
                console.error("There was an error fetching the invoice data:", error);
            }
        }

        function printInvoice() {
            window.print();
        }

        function numberToWords(num) {
            const a = ['', 'One ', 'Two ', 'Three ', 'Four ', 'Five ', 'Six ', 'Seven ', 'Eight ', 'Nine ', 'Ten ', 'Eleven ', 'Twelve ', 'Thirteen ', 'Fourteen ', 'Fifteen ', 'Sixteen ', 'Seventeen ', 'Eighteen ', 'Nineteen '];
            const b = ['', '', 'Twenty ', 'Thirty ', 'Forty ', 'Fifty ', 'Sixty ', 'Seventy ', 'Eighty ', 'Ninety '];

            if ((num = num.toString()).length > 9) return 'overflow';
            let n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
            if (!n) return '';
            let str = '';
            str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'Crore ' : '';
            str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'Lakh ' : '';
            str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'Thousand ' : '';
            str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'Hundred ' : '';
            str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) : '';
            return str.trim() ? str.trim() + ' Taka Only' : 'Zero Taka';
        }
    </script>
</body>

</html>