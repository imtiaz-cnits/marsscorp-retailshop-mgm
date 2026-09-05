@extends('layouts.dashboard-sidenav')
@section('title', 'Daily Income & Expense Ledger Report - মার্স কর্পোরেশন (MARSS CORPORATION)')
@section('content')

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #printableLedgerArea, #printableLedgerArea * {
            visibility: visible;
        }
        #printableLedgerArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
    }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid px-0">

            <!-- Breadcrumb Header -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom no-print">
                <div>
                    <h1 class="h3 fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-book-journal-whills text-success"></i> Daily Income & Expense Ledger (দৈনিক আয়-ব্যয় লেজার)
                    </h1>
                    <p class="text-muted mb-0 small">মার্স কর্পোরেশন (MARSS CORPORATION) - বিস্তারিত কালানুক্রমিক ক্যাশ খাতা ও লেজার বিবরণী</p>
                </div>
                <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
                    <button onclick="window.print()" class="btn btn-outline-success fw-bold rounded-pill px-4 shadow-sm">
                        <i class="fa-solid fa-print me-1"></i> Print Ledger
                    </button>
                    <a href="/admin-dashboard" class="btn btn-secondary fw-bold rounded-pill px-3">
                        <i class="fa-solid fa-arrow-left me-1"></i> Dashboard
                    </a>
                </div>
            </div>

            <!-- Date Range & Preset Filter Bar -->
            <div class="card border-0 shadow-sm mb-4 no-print" style="border-radius: 16px;">
                <div class="card-body p-3">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">Start Date (শুরুর তারিখ)</label>
                            <input type="date" id="startDate" class="form-control fw-semibold" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small mb-1">End Date (শেষের তারিখ)</label>
                            <input type="date" id="endDate" class="form-control fw-semibold" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small mb-1">Quick Filter</label>
                            <div class="btn-group w-100" role="group">
                                <button type="button" onclick="setPreset('today')" class="btn btn-outline-success btn-sm fw-semibold">Today</button>
                                <button type="button" onclick="setPreset('yesterday')" class="btn btn-outline-success btn-sm fw-semibold">Yesterday</button>
                                <button type="button" onclick="setPreset('this_month')" class="btn btn-outline-success btn-sm fw-semibold">This Month</button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button onclick="fetchDailyLedger()" class="btn btn-success fw-bold w-100 shadow-sm" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none;">
                                <i class="fa-solid fa-filter me-1"></i> Filter Ledger
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PRINTABLE LEDGER CONTAINER START -->
            <div id="printableLedgerArea">

                <!-- Print Header (Visible only during printing) -->
                <div class="d-none d-print-block text-center mb-4 border-bottom pb-3">
                    <h2 class="fw-bold mb-1" style="color: #15803d;">মার্স কর্পোরেশন (MARSS CORPORATION)</h2>
                    <p class="mb-0 fs-6 text-muted">প্রোপাইটর: মো: আনিসুর রহমান | খুচরা ও পাইকারী বিক্রেতা</p>
                    <h4 class="fw-bold text-dark mt-2 text-decoration-underline">দৈনিক আয়-ব্যয় লেজার রিপোর্ট</h4>
                    <p class="mb-0 text-muted small">সময়কাল: <span id="printDateRange"></span></p>
                </div>

                <!-- 4 Financial Summary Cards -->
                <div class="row g-3 mb-4">
                    <!-- Total Inflow -->
                    <div class="col-md-3 col-6">
                        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 14px; border-left: 4px solid #16a34a !important; background: #f0fdf4;">
                            <span class="text-muted small fw-bold text-uppercase d-block mb-1">Total Inflow (মোট আয়/জমা)</span>
                            <h3 id="summaryInflow" class="fw-bold text-success mb-0">৳ 0.00</h3>
                        </div>
                    </div>

                    <!-- Total Outflow -->
                    <div class="col-md-3 col-6">
                        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 14px; border-left: 4px solid #ef4444 !important; background: #fef2f2;">
                            <span class="text-muted small fw-bold text-uppercase d-block mb-1">Total Outflow (মোট খরচ/ব্যয়)</span>
                            <h3 id="summaryOutflow" class="fw-bold text-danger mb-0">৳ 0.00</h3>
                        </div>
                    </div>

                    <!-- Net Balance -->
                    <div class="col-md-3 col-6">
                        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 14px; border-left: 4px solid #0284c7 !important; background: #f0f9ff;">
                            <span class="text-muted small fw-bold text-uppercase d-block mb-1">Net Cash Balance (অবশিষ্ট ক্যাশ)</span>
                            <h3 id="summaryNetBalance" class="fw-bold text-primary mb-0">৳ 0.00</h3>
                        </div>
                    </div>

                    <!-- Transaction Count -->
                    <div class="col-md-3 col-6">
                        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 14px; border-left: 4px solid #8b5cf6 !important; background: #f5f3ff;">
                            <span class="text-muted small fw-bold text-uppercase d-block mb-1">Total Transactions</span>
                            <h3 id="summaryTxCount" class="fw-bold text-purple mb-0" style="color: #7c3aed;">0 Entries</h3>
                        </div>
                    </div>
                </div>

                <!-- Ledger Data Table -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0 fs-6">
                            <i class="fa-solid fa-list-check text-success me-2"></i> Transactions Ledger Sheet (ক্যাশ লেজার খাতা)
                        </h5>
                        <span id="ledgerPeriodBadge" class="badge bg-light text-dark border fw-bold px-3 py-1">Period: Today</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle table-hover mb-0" id="ledgerTable">
                                <thead class="bg-light">
                                    <tr class="text-uppercase small fw-bold text-muted">
                                        <th class="ps-4" style="width: 60px;">SL</th>
                                        <th style="width: 170px;">Date & Time</th>
                                        <th style="width: 140px;">Ref / Voucher</th>
                                        <th>Particulars (বিবরণ)</th>
                                        <th>Party / Category</th>
                                        <th class="text-end text-success" style="width: 130px;">Cash In (আয়)</th>
                                        <th class="text-end text-danger" style="width: 130px;">Cash Out (ব্যয়)</th>
                                        <th class="text-end pe-4" style="width: 150px;">Running Cash</th>
                                    </tr>
                                </thead>
                                <tbody id="ledgerTbody">
                                    <tr><td colspan="8" class="text-center py-4 text-muted">Loading ledger entries...</td></tr>
                                </tbody>
                                <tfoot class="bg-light fw-bold border-top">
                                    <tr>
                                        <td colspan="5" class="ps-4 text-end text-uppercase">Total Summary:</td>
                                        <td id="tfootTotalInflow" class="text-end text-success">৳ 0.00</td>
                                        <td id="tfootTotalOutflow" class="text-end text-danger">৳ 0.00</td>
                                        <td id="tfootNetBalance" class="text-end pe-4 text-primary">৳ 0.00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Print Footer Signatures -->
                <div class="d-none d-print-block mt-5 pt-4">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border-top border-dark pt-2 fw-semibold">ক্যাশিয়ার এর স্বাক্ষর</div>
                        </div>
                        <div class="col-4">
                            <div class="border-top border-dark pt-2 fw-semibold">হিসাবরক্ষক এর স্বাক্ষর</div>
                        </div>
                        <div class="col-4">
                            <div class="border-top border-dark pt-2 fw-semibold">মালিক এর স্বাক্ষর</div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- PRINTABLE LEDGER CONTAINER END -->

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const today = new Date().toISOString().split("T")[0];
        document.getElementById("startDate").value = today;
        document.getElementById("endDate").value = today;
        fetchDailyLedger();
    });

    function setPreset(type) {
        const todayObj = new Date();
        const yyyy = todayObj.getFullYear();
        const mm = String(todayObj.getMonth() + 1).padStart(2, '0');
        const dd = String(todayObj.getDate()).padStart(2, '0');
        const todayStr = `${yyyy}-${mm}-${dd}`;

        if (type === 'today') {
            document.getElementById("startDate").value = todayStr;
            document.getElementById("endDate").value = todayStr;
        } else if (type === 'yesterday') {
            const yestObj = new Date(todayObj);
            yestObj.setDate(todayObj.getDate() - 1);
            const yestStr = yestObj.toISOString().split("T")[0];
            document.getElementById("startDate").value = yestStr;
            document.getElementById("endDate").value = yestStr;
        } else if (type === 'this_month') {
            const firstDayStr = `${yyyy}-${mm}-01`;
            document.getElementById("startDate").value = firstDayStr;
            document.getElementById("endDate").value = todayStr;
        }
        fetchDailyLedger();
    }

    async function fetchDailyLedger() {
        const startDate = document.getElementById("startDate").value;
        const endDate = document.getElementById("endDate").value;

        if (!startDate || !endDate) {
            alert("Please select both start and end dates.");
            return;
        }

        try {
            if (typeof showLoader === "function") showLoader();
            const res = await axios.get(`/api/daily-ledger-report-list?start_date=${startDate}&end_date=${endDate}`, HeaderToken());
            if (typeof hideLoader === "function") hideLoader();

            if (res.data && res.data.status === 'success') {
                const summary = res.data.summary || {};
                const list = res.data.ledgerData || [];

                // --- 1. Populate Cards & Footers ---
                document.getElementById('summaryInflow').innerText = '৳ ' + formatMoney(summary.total_inflow);
                document.getElementById('summaryOutflow').innerText = '৳ ' + formatMoney(summary.total_outflow);
                document.getElementById('summaryNetBalance').innerText = '৳ ' + formatMoney(summary.net_balance);
                document.getElementById('summaryTxCount').innerText = (summary.total_count || 0) + ' Entries';

                document.getElementById('tfootTotalInflow').innerText = '৳ ' + formatMoney(summary.total_inflow);
                document.getElementById('tfootTotalOutflow').innerText = '৳ ' + formatMoney(summary.total_outflow);
                document.getElementById('tfootNetBalance').innerText = '৳ ' + formatMoney(summary.net_balance);

                const periodText = summary.start_date === summary.end_date ? summary.start_date : `${summary.start_date} to ${summary.end_date}`;
                document.getElementById('ledgerPeriodBadge').innerText = 'Period: ' + periodText;
                document.getElementById('printDateRange').innerText = periodText;

                // --- 2. Populate Ledger Table Rows ---
                const tbody = document.getElementById('ledgerTbody');
                tbody.innerHTML = '';

                if (list.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-muted">No transactions found for the selected period.</td></tr>`;
                    return;
                }

                list.forEach((item, index) => {
                    const isInflow = item.type === 'inflow';
                    const badgeClass = isInflow ? 'bg-success-subtle text-success border-success-subtle' : 'bg-danger-subtle text-danger border-danger-subtle';
                    const typeLabel = isInflow ? 'INCOME' : 'EXPENSE';

                    const row = `
                        <tr>
                            <td class="ps-4 fw-semibold text-muted">${index + 1}</td>
                            <td class="fw-semibold text-dark small">${item.date}</td>
                            <td><span class="badge bg-light text-dark border font-monospace">${item.ref_no}</span></td>
                            <td>
                                <div class="fw-bold text-dark">${item.particulars}</div>
                                <span class="badge ${badgeClass} border px-2 py-0" style="font-size: 10px;">${typeLabel} - ${item.category}</span>
                            </td>
                            <td class="fw-semibold text-secondary">${item.party_name}</td>
                            <td class="text-end fw-bold text-success">${item.inflow > 0 ? '৳ ' + formatMoney(item.inflow) : '-'}</td>
                            <td class="text-end fw-bold text-danger">${item.outflow > 0 ? '৳ ' + formatMoney(item.outflow) : '-'}</td>
                            <td class="text-end pe-4 fw-bold ${item.running_balance >= 0 ? 'text-primary' : 'text-danger'}">৳ ${formatMoney(item.running_balance)}</td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });

            } else {
                alert('Failed to fetch ledger report: ' + (res.data.message || 'Unknown error'));
            }

        } catch (e) {
            if (typeof hideLoader === "function") hideLoader();
            console.error("Ledger Fetch Error:", e);
        }
    }

    function formatMoney(amount) {
        if (amount === null || isNaN(amount)) return "0.00";
        return parseFloat(amount).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }
</script>

@endsection
