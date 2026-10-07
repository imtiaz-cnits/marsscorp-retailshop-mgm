@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Dashboard - MARSS CORPORATION')
@section('content')

<!-- ApexCharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<!-- Dashboard Main Content Start -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid px-0">
            
            <!-- Dashboard Welcome Header -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div>
                    <h1 class="h3 fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-car-battery text-success"></i> Battery Shop Summary
                    </h1>
                    <p class="text-muted mb-0 small">MARSS CORPORATION - Dedicated Battery Division Real-Time Analytics</p>
                </div>
                <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-bold">
                        <i class="fa-solid fa-calendar-day me-1"></i> Today: {{ date('d M Y') }}
                    </span>
                    <a href="{{ route('battery.pos') }}" class="btn btn-success fw-bold rounded-pill px-4 shadow-sm d-inline-flex align-items-center gap-1.5" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none; padding-top: 8px !important; padding-bottom: 8px !important; font-size: 13px;">
                        <i class="fa-solid fa-cart-shopping me-1"></i> New Battery POS Sale
                    </a>
                </div>
            </div>

            <!-- FINANCIAL METRICS & CHARTS WRAPPER -->
            <div id="batteryFinancialSections">
                <!-- ROW 1: TODAY'S KEY METRICS (4 Gradient Cards) -->
                <div class="row g-3 mb-4">
                    <!-- Today Net Profit -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 16px; border-left: 5px solid #16a34a !important; background: linear-gradient(145deg, #ffffff, #f0fdf4);">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-muted small fw-bold text-uppercase d-block mb-1">Today's Net Profit</span>
                                    <h2 id="todayNetProfit" class="fw-bold mb-0 text-success fs-3">৳ 0.00</h2>
                                    <small class="text-muted">Net after COGS & Expenses</small>
                                </div>
                                <div class="rounded-circle p-3 text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 55px; height: 55px; background: linear-gradient(135deg, #15803d, #22c55e);">
                                    <i class="fa-solid fa-sack-dollar fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today Total Sales -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 16px; border-left: 5px solid #0284c7 !important; background: linear-gradient(145deg, #ffffff, #f0f9ff);">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-muted small fw-bold text-uppercase d-block mb-1">Today's Total Sales</span>
                                    <h2 id="todayTotalSales" class="fw-bold mb-0 text-primary fs-3">৳ 0.00</h2>
                                    <small id="todaySalesCountBadge" class="text-muted">0 Invoices generated</small>
                                </div>
                                <div class="rounded-circle p-3 text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 55px; height: 55px; background: linear-gradient(135deg, #0369a1, #38bdf8);">
                                    <i class="fa-solid fa-receipt fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today Cash Collection -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 16px; border-left: 5px solid #8b5cf6 !important; background: linear-gradient(145deg, #ffffff, #f5f3ff);">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-muted small fw-bold text-uppercase d-block mb-1">Today's Cash Collection</span>
                                    <h2 id="todayCashCollection" class="fw-bold mb-0 style-purple fs-3" style="color: #7c3aed;">৳ 0.00</h2>
                                    <small class="text-muted">Total cash received today</small>
                                </div>
                                <div class="rounded-circle p-3 text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 55px; height: 55px; background: linear-gradient(135deg, #6d28d9, #a78bfa);">
                                    <i class="fa-solid fa-hand-holding-dollar fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today Operating Expense -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 16px; border-left: 5px solid #f59e0b !important; background: linear-gradient(145deg, #ffffff, #fffbeb);">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-muted small fw-bold text-uppercase d-block mb-1">Today's Expense</span>
                                    <h2 id="todayExpense" class="fw-bold mb-0 text-warning fs-3">৳ 0.00</h2>
                                    <small class="text-muted">Battery daily expenses</small>
                                </div>
                                <div class="rounded-circle p-3 text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 55px; height: 55px; background: linear-gradient(135deg, #d97706, #fbbf24);">
                                    <i class="fa-solid fa-file-invoice-dollar fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ROW 2: GRAPHICAL ANALYTICS CHARTS (Sales & Profit Trend + Financial Breakdown) -->
                <div class="row g-3 mb-4">
                    <!-- Area Chart: Sales vs Profit Trend -->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card border-0 shadow-sm h-100 p-4" style="border-radius: 16px;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-chart-area text-success"></i> Sales & Profit Trend (Last 7 Days)
                                    </h5>
                                    <small class="text-muted">Daily Revenue comparison against Net Profit</small>
                                </div>
                                <span class="badge bg-light text-muted border px-2 py-1 rounded">Daily</span>
                            </div>
                            <div id="salesProfitTrendChart" style="min-height: 280px;"></div>
                        </div>
                    </div>

                    <!-- Donut Chart: Financial Breakdown -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="card border-0 shadow-sm h-100 p-4" style="border-radius: 16px;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-chart-pie text-primary"></i> Monthly Breakdown
                                    </h5>
                                    <small class="text-muted">Collections, Receivables & Costs</small>
                                </div>
                            </div>
                            <div id="financialBreakdownDonutChart" style="min-height: 280px;" class="d-flex justify-content-center align-items-center"></div>
                        </div>
                    </div>
                </div>

                <!-- ROW 3: THIS MONTH'S OVERVIEW (4 Cards) -->
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1 rounded fw-bold text-uppercase small">
                                <i class="fa-regular fa-calendar-check me-1"></i> Current Month: {{ date('F Y') }}
                            </span>
                        </div>
                    </div>

                    <!-- Monthly Net Profit -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 14px;">
                            <span class="text-muted small fw-bold text-uppercase">Monthly Net Profit</span>
                            <h3 id="monthlyNetProfit" class="fw-bold text-success mb-0 mt-1">৳ 0.00</h3>
                            <small class="text-muted">Net profit this month</small>
                        </div>
                    </div>

                    <!-- Monthly Sales -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 14px;">
                            <span class="text-muted small fw-bold text-uppercase">Monthly Total Sales</span>
                            <h3 id="monthlySales" class="fw-bold text-primary mb-0 mt-1">৳ 0.00</h3>
                            <small class="text-muted">Gross billed invoices</small>
                        </div>
                    </div>

                    <!-- Monthly Collection -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 14px;">
                            <span class="text-muted small fw-bold text-uppercase">Monthly Collection</span>
                            <h3 id="monthlyCollection" class="fw-bold text-info mb-0 mt-1">৳ 0.00</h3>
                            <small class="text-muted">Total cash & payments received</small>
                        </div>
                    </div>

                    <!-- Monthly Purchase -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 14px;">
                            <span class="text-muted small fw-bold text-uppercase">Monthly Purchases</span>
                            <h3 id="monthlyPurchase" class="fw-bold text-secondary mb-0 mt-1">৳ 0.00</h3>
                            <small class="text-muted">Inventory procurement</small>
                        </div>
                    </div>
                </div>

                <!-- ROW 4: BALANCE SHEET & INVENTORY VALUATION (4 Cards) -->
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1 rounded fw-bold text-uppercase small">
                                <i class="fa-solid fa-scale-balanced me-1"></i> Balance Sheet & Inventory Status
                            </span>
                        </div>
                    </div>

                    <!-- Customer Due -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 14px; background: #fff5f5; border-left: 4px solid #ef4444 !important;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="text-danger small fw-bold text-uppercase">Customer Due (Receivable)</span>
                                    <h3 id="customerDue" class="fw-bold text-danger mb-0 mt-1">৳ 0.00</h3>
                                    <small class="text-muted">Total outstanding customer balance</small>
                                </div>
                                <i class="fa-solid fa-users text-danger-emphasis fs-4 opacity-50"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Supplier Payable -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 14px; background: #fffbeb; border-left: 4px solid #f59e0b !important;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="text-warning-emphasis small fw-bold text-uppercase">Supplier Payable</span>
                                    <h3 id="supplierPayable" class="fw-bold text-warning mb-0 mt-1">৳ 0.00</h3>
                                    <small class="text-muted">Total payable to suppliers</small>
                                </div>
                                <i class="fa-solid fa-truck-field text-warning fs-4 opacity-50"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Cost Stock Value -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 14px; background: #f0fdf4; border-left: 4px solid #16a34a !important;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="text-success small fw-bold text-uppercase">Cost Stock Value</span>
                                    <h3 id="costStockValue" class="fw-bold text-success mb-0 mt-1">৳ 0.00</h3>
                                    <small class="text-muted" id="productCountBadge">0 Products</small>
                                </div>
                                <i class="fa-solid fa-boxes-stacked text-success fs-4 opacity-50"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Sell Stock Value -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 14px; background: #f8fafc; border-left: 4px solid #64748b !important;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="text-slate-600 small fw-bold text-uppercase">Sell Stock Value</span>
                                    <h3 id="sellStockValue" class="fw-bold text-dark mb-0 mt-1">৳ 0.00</h3>
                                    <small class="text-muted" id="lowStockBadge">0 Low Stock Items</small>
                                </div>
                                <i class="fa-solid fa-tags text-secondary fs-4 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ROW 5: OPERATIONAL TABLES (Low Stock Alert & Recent Sales) -->
                <div class="row g-3">
                    <!-- Low Stock Alerts -->
                    <div class="col-xl-6 col-lg-12">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                            <div class="card-header bg-transparent border-0 pt-3 px-4 pb-2 d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold text-danger mb-0 d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-triangle-exclamation"></i> Low Stock Alert (Battery Inventory)
                                </h5>
                                <a href="{{ route('battery.products') }}" class="btn btn-sm btn-light border rounded-pill px-3 fw-bold small">View Catalog</a>
                            </div>
                            <div class="card-body px-0 pt-1">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" id="lowStockTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-4">Product Name</th>
                                                <th class="text-center">Code</th>
                                                <th class="text-center">Remaining</th>
                                                <th class="text-end pe-4">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="lowStockTbody">
                                            <tr>
                                                <td colspan="4" class="text-center py-4 text-muted">
                                                    <div class="spinner-border spinner-border-sm text-secondary me-2" role="status"></div> Loading stock alerts...
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Sales Table -->
                    <div class="col-xl-6 col-lg-12">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                            <div class="card-header bg-transparent border-0 pt-3 px-4 pb-2 d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-clock-rotate-left text-success"></i> Recent Battery Sales
                                </h5>
                                <a href="{{ route('battery.invoices') }}" class="btn btn-sm btn-light border rounded-pill px-3 fw-bold small">All Invoices</a>
                            </div>
                            <div class="card-body px-0 pt-1">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-4">Invoice No</th>
                                                <th>Customer</th>
                                                <th class="text-end">Amount</th>
                                                <th class="text-center pe-4">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="recentSalesTbody">
                                            <tr>
                                                <td colspan="4" class="text-center py-4 text-muted">
                                                    <div class="spinner-border spinner-border-sm text-secondary me-2" role="status"></div> Loading recent sales...
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- batteryFinancialSections End -->

        </div>
    </div>
</div>
<!-- Dashboard Main Content End -->

<script>
    let salesProfitChartInstance = null;
    let financialDonutChartInstance = null;

    document.addEventListener("DOMContentLoaded", function () {
        loadBatteryDashboardData();
    });

    async function loadBatteryDashboardData() {
        try {
            if (typeof showLoader === "function") showLoader();
            const res = await axios.get("/api/battery/dashboard-all-calculation", HeaderToken());
            if (typeof hideLoader === "function") hideLoader();

            if (res.data && res.data.status === 'success') {
                const data = res.data;
                const today = data.today || {};
                const monthly = data.monthly || {};
                const financial = data.financial || {};
                const chart = data.chart || {};

                // 1. Today Cards
                document.getElementById('todayNetProfit').innerText = '৳ ' + formatMoney(today.net_profit || data.todayNetProfit || 0);
                document.getElementById('todayTotalSales').innerText = '৳ ' + formatMoney(today.sales_amount || data.todayTotalSalesAmount || 0);
                document.getElementById('todaySalesCountBadge').innerText = (today.sales_count || 0) + ' Invoices generated';
                document.getElementById('todayCashCollection').innerText = '৳ ' + formatMoney(today.cash_collection || data.todayTotalPaidAmount || 0);
                document.getElementById('todayExpense').innerText = '৳ ' + formatMoney(today.expense || data.todayTotalExpensesAmount || 0);

                // 2. Monthly Cards
                document.getElementById('monthlyNetProfit').innerText = '৳ ' + formatMoney(monthly.net_profit || data.monthlyTotalProfit || 0);
                document.getElementById('monthlySales').innerText = '৳ ' + formatMoney(monthly.sales_amount || 0);
                document.getElementById('monthlyCollection').innerText = '৳ ' + formatMoney(monthly.cash_collection || 0);
                document.getElementById('monthlyPurchase').innerText = '৳ ' + formatMoney(monthly.purchase_amount || 0);

                // 3. Balance & Inventory
                document.getElementById('customerDue').innerText = '৳ ' + formatMoney(financial.customer_due || 0);
                document.getElementById('supplierPayable').innerText = '৳ ' + formatMoney(financial.supplier_payable || 0);
                document.getElementById('costStockValue').innerText = '৳ ' + formatMoney(financial.cost_stock_value || 0);
                document.getElementById('sellStockValue').innerText = '৳ ' + formatMoney(financial.sell_stock_value || 0);
                document.getElementById('productCountBadge').innerText = (financial.total_products || 0) + ' Battery Items';
                document.getElementById('lowStockBadge').innerText = (financial.low_stock_count || 0) + ' Low Stock';

                // 4. Render Charts
                renderBatterySalesProfitChart(chart.dates || [], chart.sales || [], chart.profits || []);
                renderBatteryFinancialDonutChart(
                    parseFloat(monthly.cash_collection || 0),
                    parseFloat(financial.customer_due || 0),
                    parseFloat(monthly.expense || 0),
                    parseFloat(monthly.net_profit || 0)
                );

                // 5. Low Stock Table
                const lowStockTbody = document.getElementById('lowStockTbody');
                lowStockTbody.innerHTML = '';
                const lowStockList = data.low_stock_products || [];
                if (lowStockList.length === 0) {
                    lowStockTbody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-success fw-bold"><i class="fa-solid fa-circle-check me-1"></i> All battery products are well stocked!</td></tr>`;
                } else {
                    lowStockList.forEach(item => {
                        const code = item.battery_code || item.product_code || ('BAT-' + item.id);
                        const row = `
                            <tr>
                                <td class="ps-4 fw-semibold text-dark">${item.name}</td>
                                <td class="text-center"><span class="badge bg-light text-dark border font-monospace">${code}</span></td>
                                <td class="text-center"><span class="badge bg-danger px-2 py-1 fw-bold">${item.quantity} ${item.unit || 'pcs'}</span></td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('battery.purchases') }}" class="btn btn-sm btn-outline-success rounded-pill px-2 py-1" title="Procure Battery">
                                        <i class="fa-solid fa-cart-plus me-1"></i> Reorder
                                    </a>
                                </td>
                            </tr>
                        `;
                        lowStockTbody.innerHTML += row;
                    });
                }

                // 6. Recent Sales Table
                const recentSalesTbody = document.getElementById('recentSalesTbody');
                recentSalesTbody.innerHTML = '';
                const recentList = data.recent_invoices || [];
                if (recentList.length === 0) {
                    recentSalesTbody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-muted">No recent battery sales found</td></tr>`;
                } else {
                    recentList.forEach(inv => {
                        let statusBadge = inv.due_amount <= 0 ? '<span class="badge bg-success px-2 py-1">Paid</span>' :
                                          (inv.paid_amount > 0 ? '<span class="badge bg-warning text-dark px-2 py-1">Partial</span>' : '<span class="badge bg-danger px-2 py-1">Unpaid</span>');

                        const row = `
                            <tr>
                                <td class="ps-4"><a href="{{ route('battery.invoices') }}" class="fw-bold text-success text-decoration-none">${inv.order_no}</a></td>
                                <td class="fw-semibold text-dark">${inv.customer_name || 'Walk-in'}</td>
                                <td class="text-end fw-bold text-dark">৳ ${formatMoney(inv.grand_subtotal)}</td>
                                <td class="text-center pe-4">${statusBadge}</td>
                            </tr>
                        `;
                        recentSalesTbody.innerHTML += row;
                    });
                }

            } else {
                console.error("Battery Dashboard calculation failed:", res.data);
            }

        } catch (e) {
            if (typeof hideLoader === "function") hideLoader();
            console.error("Error loading battery dashboard data:", e);
        }
    }

    function renderBatterySalesProfitChart(dates, sales, profits) {
        const seriesData = [
            { name: 'Total Sales', data: sales },
            { name: 'Net Profit', data: profits }
        ];

        const options = {
            series: seriesData,
            chart: {
                type: 'area',
                height: 280,
                toolbar: { show: false },
                zoom: { enabled: false }
            },
            colors: ['#0284c7', '#16a34a'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2.5 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [20, 100]
                }
            },
            xaxis: {
                categories: dates,
                labels: { style: { colors: '#64748b', fontSize: '12px' } }
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return '৳ ' + Number(val).toLocaleString();
                    },
                    style: { colors: '#64748b', fontSize: '11px' }
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return '৳ ' + Number(val).toLocaleString();
                    }
                }
            },
            legend: { position: 'top', horizontalAlign: 'right' },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4 }
        };

        if (salesProfitChartInstance) salesProfitChartInstance.destroy();
        salesProfitChartInstance = new ApexCharts(document.querySelector("#salesProfitTrendChart"), options);
        salesProfitChartInstance.render();
    }

    function renderBatteryFinancialDonutChart(collection, due, expense, profit) {
        const series = [collection, due, expense, Math.max(0, profit)];
        const labels = ['Cash Collection', 'Customer Due', 'Expenses', 'Net Profit'];

        const options = {
            series: series,
            labels: labels,
            chart: {
                type: 'donut',
                height: 280
            },
            colors: ['#0284c7', '#ef4444', '#f59e0b', '#16a34a'],
            legend: {
                position: 'bottom',
                fontSize: '11px',
                markers: { radius: 12 }
            },
            dataLabels: { enabled: false },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Inflow',
                                formatter: function (w) {
                                    const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    return '৳ ' + Number(total).toLocaleString();
                                }
                            }
                        }
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return '৳ ' + Number(val).toLocaleString();
                    }
                }
            }
        };

        if (financialDonutChartInstance) financialDonutChartInstance.destroy();
        financialDonutChartInstance = new ApexCharts(document.querySelector("#financialBreakdownDonutChart"), options);
        financialDonutChartInstance.render();
    }

    function formatMoney(amount) {
        return parseFloat(amount || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
</script>

@endsection
