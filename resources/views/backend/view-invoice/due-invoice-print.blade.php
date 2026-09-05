<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Bill Invoice {{ $invoice->order_no }} - MARSS CORPORATION</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Google Fonts: Valley Sans & Baloo Da 2 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Da+2:wght@400;500;600;700;800&family=Valley+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

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
        }

        .mc-box .m-red {
            color: #dc2626;
        }

        .mc-box .c-green {
            color: #15803d;
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
        }

        .bill-main-body {
            flex: 1;
            display: flex;
            flex-direction: column;
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

    <!-- Control Buttons -->
    <div class="no-print-wrapper">
        <button class="btn btn-success fw-bold px-4 shadow-sm" onclick="window.print()" style="background-color: #15803d; border-color: #15803d;">
            <i class="fa-solid fa-print me-2"></i> Print Bill (মেমো প্রিন্ট)
        </button>
        <div class="d-flex gap-2">
            <a href="{{ url('admin-dashboard-invoice') }}" class="btn btn-secondary fw-bold shadow-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Invoice List
            </a>
        </div>
    </div>

    @php
    $subTotalVal = $invoice->sub_total ?? 0;
    $discountVal = $invoice->discount_amount ?? 0;
    $paidVal = $invoice->paid_amount ?? 0;
    $dueVal = $invoice->due_amount ?? 0;
    $billTotalVal = $subTotalVal - $discountVal;
    @endphp

    <!-- Printable Invoice Container -->
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

            <!-- Meta Information -->
            <div class="meta-grid mt-3">
                <div class="row g-2">
                    <div class="col-7">
                        <div class="meta-line">
                            <span class="meta-label">Bill No:</span>
                            <span class="meta-dots">{{ $invoice->order_no }}</span>
                        </div>
                        <div class="meta-line">
                            <span class="meta-label">Challan No:</span>
                            <span class="meta-dots">{{ $invoice->order_note ?? '' }}</span>
                        </div>
                        <div class="meta-line">
                            <span class="meta-label">Name of Customer:</span>
                            <span class="meta-dots">{{ $invoice->customer->customer_name ?? '' }}</span>
                        </div>
                        <div class="meta-line">
                            <span class="meta-label">Address:</span>
                            <span class="meta-dots">{{ $invoice->customer->address_details ?? $invoice->customer->address ?? '' }}</span>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="meta-line">
                            <span class="meta-label">Bill Date:</span>
                            <span class="meta-dots">{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-m-Y') }}</span>
                        </div>
                        <div class="meta-line">
                            <span class="meta-label">Delivery Date:</span>
                            <span class="meta-dots">{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-m-Y') }}</span>
                        </div>
                        <div class="meta-line">
                            <span class="meta-label">Mob:</span>
                            <span class="meta-dots">{{ $invoice->customer->mobile ?? '' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Table -->
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 6%;">Sl.No.</th>
                        <th>Description</th>
                        <th style="width: 14%; text-align: right;">Rate</th>
                        <th style="width: 10%; text-align: center;">Qty.</th>
                        <th style="width: 18%; text-align: right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $orderDetailsList = $invoice->details ?? $invoice->orderDetails ?? [];
                    @endphp
                    @foreach($orderDetailsList as $index => $detail)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>{{ $detail->product->product_name ?? 'Product' }}</td>
                        <td style="text-align: right;">{{ number_format($detail->selling_price, 2) }}</td>
                        <td style="text-align: center;">{{ $detail->quantity }}</td>
                        <td style="text-align: right;">{{ number_format($detail->selling_price * $detail->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <!-- Footer Calculations & Signatures -->
        <div class="bill-footer-section">
            <div class="calc-summary-wrapper">
                <div class="taka-words-box">
                    <div class="taka-words-line">
                        <span class="meta-label">Taka in Words:</span>
                        <span class="taka-words-val" id="taka_words_due"></span>
                    </div>
                </div>

                <div class="totals-table-box">
                    <table class="totals-table">
                        <tr>
                            <td class="lbl">Total Bill</td>
                            <td class="val">{{ number_format($subTotalVal, 2) }}</td>
                        </tr>
                        @if($discountVal > 0)
                        <tr>
                            <td class="lbl">Discount</td>
                            <td class="val">{{ number_format($discountVal, 2) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="lbl">Net Amount</td>
                            <td class="val">{{ number_format($billTotalVal, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Paid Amount</td>
                            <td class="val">{{ number_format($paidVal, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Today Due</td>
                            <td class="val">{{ number_format($dueVal, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Previous Due</td>
                            <td class="val">{{ number_format($actualPreviousDue ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="lbl" style="font-weight: 700; background-color: #f1f5f9;">Total Due</td>
                            <td class="val" style="font-weight: 700; background-color: #f1f5f9;">{{ number_format(($actualPreviousDue ?? 0) + $dueVal, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="signatures-row">
                <div class="sig-box">Received by</div>
                <div class="sig-box">For Marss Corporation</div>
            </div>

            <div class="bottom-color-bar">
                <div class="red-bar"></div>
                <div class="green-bar"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let totalVal = Math.round({
                {
                    $subTotalVal
                }
            });
            document.getElementById('taka_words_due').innerText = numberToWords(totalVal);
        });

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