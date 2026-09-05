@extends('layouts.dashboard-sidenav')
@section('title', 'Admin Dashboard - মার্স কর্পোরেশন (MARSS CORPORATION)')
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
                        <i class="fa-solid fa-chart-line text-success"></i> Retail Shop Summary
                    </h1>
                    <p class="text-muted mb-0 small">মার্স কর্পোরেশন (MARSS CORPORATION) - ব্যবসার সার্বিক হিসাব ও রিয়েল-টাইম ওভারভিউ</p>
                </div>
                <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-bold">
                        <i class="fa-solid fa-calendar-day me-1"></i> Today: {{ date('d M Y') }}
                    </span>
                    <a href="/admin-dashboard-pos" class="btn btn-success fw-bold rounded-pill px-4 shadow-sm d-inline-flex align-items-center gap-1.5" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none; padding-top: 8px !important; padding-bottom: 8px !important; font-size: 13px;">
                        <i class="fa-solid fa-cart-shopping me-1"></i> New POS Sale
                    </a>
                </div>
            </div>

            <!-- ADMIN ONLY FINANCIAL METRICS & CHARTS WRAPPER -->
            <div id="adminOnlyFinancialSections">
                <!-- ROW 1: TODAY'S KEY METRICS (4 Gradient Cards) -->
                <div class="row g-3 mb-4">
                    <!-- Today Net Profit (Admin Only) -->
                    <div class="col-xl-3 col-md-6" id="todayNetProfitCol">
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
                    <div class="col-xl-3 col-md-6 today-metric-col">
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
                    <div class="col-xl-3 col-md-6 today-metric-col">
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
                    <div class="col-xl-3 col-md-6 today-metric-col">
                        <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 16px; border-left: 5px solid #f59e0b !important; background: linear-gradient(145deg, #ffffff, #fffbeb);">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-muted small fw-bold text-uppercase d-block mb-1">Today's Expense</span>
                                    <h2 id="todayExpense" class="fw-bold mb-0 text-warning fs-3">৳ 0.00</h2>
                                    <small class="text-muted">Shop daily expenses</small>
                                </div>
                                <div class="rounded-circle p-3 text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 55px; height: 55px; background: linear-gradient(135deg, #d97706, #fbbf24);">
                                    <i class="fa-solid fa-file-invoice-dollar fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ROW 2: GRAPHICAL ANALYTICS CHARTS (Sales & Profit Trend + Financial Breakdown) -->
                <div class="row g-4 mb-4">
                    <!-- Sales vs Net Profit Area Trend Chart -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="fw-bold text-dark mb-0 fs-6" id="salesProfitChartTitle">
                                        <i class="fa-solid fa-chart-area text-success me-2"></i> Sales & Profit Trend (গত ১৫ দিনের বিক্রি ও নিট লাভ)
                                    </h5>
                                    <small class="text-muted" id="salesProfitChartSub">Daily sales revenue vs actual net profit</small>
                                </div>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 fw-bold rounded-pill">
                                    Live Analytics
                                </span>
                            </div>
                            <div class="card-body p-3">
                                <div id="salesProfitChart" style="min-height: 330px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Breakdown Donut Chart -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                            <div class="card-header bg-white py-3 border-0">
                                <h5 class="fw-bold text-dark mb-0 fs-6">
                                    <i class="fa-solid fa-chart-pie text-primary me-2"></i> Financial Distribution
                                </h5>
                                <small class="text-muted">Breakdown of collections, dues & profit</small>
                            </div>
                            <div class="card-body p-3 d-flex flex-column align-items-center justify-content-center">
                                <div id="financialDonutChart" style="min-height: 310px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ROW 3: THIS MONTH'S FINANCIAL SUMMARY (4 Cards) -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0 fs-6">
                            <i class="fa-solid fa-calendar-check text-success me-2"></i> This Month's Financial Summary ({{ date('F Y') }})
                        </h5>
                        <span class="badge bg-light text-dark border fw-bold px-3 py-1">Monthly Ledger</span>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="row g-3">
                            <div class="col-md-3 col-6" id="monthlyNetProfitCol">
                                <div class="p-3 bg-light rounded-3 text-center border">
                                    <span class="text-muted small fw-semibold d-block mb-1">Monthly Net Profit</span>
                                    <h4 id="monthlyNetProfit" class="fw-bold text-success mb-0">৳ 0.00</h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 monthly-summary-col">
                                <div class="p-3 bg-light rounded-3 text-center border">
                                    <span class="text-muted small fw-semibold d-block mb-1">Monthly Total Sales</span>
                                    <h4 id="monthlySales" class="fw-bold text-primary mb-0">৳ 0.00</h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 monthly-summary-col">
                                <div class="p-3 bg-light rounded-3 text-center border">
                                    <span class="text-muted small fw-semibold d-block mb-1">Monthly Collections</span>
                                    <h4 id="monthlyCollection" class="fw-bold style-purple mb-0" style="color: #7c3aed;">৳ 0.00</h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 monthly-summary-col">
                                <div class="p-3 bg-light rounded-3 text-center border">
                                    <span class="text-muted small fw-semibold d-block mb-1">Monthly Stock Purchases</span>
                                    <h4 id="monthlyPurchase" class="fw-bold text-info mb-0">৳ 0.00</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ROW 4: OUTSTANDING DUES & INVENTORY VALUATION (4 Cards) -->
                <div class="row g-3 mb-4">
                    <!-- Customer Outstanding Due -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 16px; border-top: 4px solid #ef4444 !important;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-bold text-uppercase">Customer Outstanding Due</span>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Receivable</span>
                            </div>
                            <h3 id="customerDue" class="fw-bold text-danger mb-1">৳ 0.00</h3>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Total Dues from Customers</small>
                                <a href="/admin-dashboard-customer-due-list" class="text-danger fw-bold small text-decoration-none">View All <i class="fa-solid fa-chevron-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Supplier Payable Due -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 16px; border-top: 4px solid #f97316 !important;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-bold text-uppercase">Supplier Payable Due</span>
                                <span class="badge bg-warning-subtle text-dark border border-warning-subtle px-2 py-1">Payable</span>
                            </div>
                            <h3 id="supplierPayable" class="fw-bold text-orange mb-1" style="color: #ea580c;">৳ 0.00</h3>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Total Payable to Suppliers</small>
                                <a href="/supplier-due-page" class="text-warning fw-bold small text-decoration-none">View All <i class="fa-solid fa-chevron-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory Stock Valuation (Cost) -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 16px; border-top: 4px solid #0d9488 !important;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-bold text-uppercase">Stock Cost Value</span>
                                <span id="productCountBadge" class="badge bg-teal-subtle text-teal border px-2 py-1" style="background-color: #ccfbf1; color: #0d9488;">0 Items</span>
                            </div>
                            <h3 id="costStockValue" class="fw-bold mb-1" style="color: #0d9488;">৳ 0.00</h3>
                            <small class="text-muted">Total inventory purchase cost</small>
                        </div>
                    </div>

                    <!-- Inventory Selling Valuation -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 16px; border-top: 4px solid #059669 !important;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-bold text-uppercase">Stock Selling Value</span>
                                <span id="lowStockBadge" class="badge bg-danger text-white px-2 py-1">0 Low Stock</span>
                            </div>
                            <h3 id="sellStockValue" class="fw-bold text-success mb-1">৳ 0.00</h3>
                            <small class="text-muted">Total estimated sales value</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END ADMIN ONLY FINANCIAL SECTIONS -->

            <!-- ROW 5: QUICK SHORTCUTS GRID -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold text-dark mb-0 fs-6">
                        <i class="fa-solid fa-bolt text-warning me-2"></i> Quick Actions & Shortcuts
                    </h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="row g-2">
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="/admin-dashboard-pos" class="btn btn-outline-success w-100 py-3 d-flex flex-column align-items-center gap-2 rounded-3 shadow-sm border-2">
                                <i class="fa-solid fa-cart-shopping fs-3"></i>
                                <span class="fw-bold small">New POS Sale</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="/admin-dashboard-product" class="btn btn-outline-primary w-100 py-3 d-flex flex-column align-items-center gap-2 rounded-3 shadow-sm border-2">
                                <i class="fa-solid fa-box-open fs-3"></i>
                                <span class="fw-bold small">Add Product</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="/admin-dashboard-Purchase" class="btn btn-outline-info w-100 py-3 d-flex flex-column align-items-center gap-2 rounded-3 shadow-sm border-2">
                                <i class="fa-solid fa-truck-ramp-box fs-3"></i>
                                <span class="fw-bold small">Purchase Stock</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="/admin-dashboard-customer" class="btn btn-outline-purple w-100 py-3 d-flex flex-column align-items-center gap-2 rounded-3 shadow-sm border-2" style="color: #7c3aed; border-color: #7c3aed;">
                                <i class="fa-solid fa-users fs-3"></i>
                                <span class="fw-bold small">Customers</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="/admin-dashboard-supplier" class="btn btn-outline-dark w-100 py-3 d-flex flex-column align-items-center gap-2 rounded-3 shadow-sm border-2">
                                <i class="fa-solid fa-truck-field fs-3"></i>
                                <span class="fw-bold small">Suppliers</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="/admin-dashboard-customer-due-list" class="btn btn-outline-danger w-100 py-3 d-flex flex-column align-items-center gap-2 rounded-3 shadow-sm border-2">
                                <i class="fa-solid fa-hand-holding-dollar fs-3"></i>
                                <span class="fw-bold small">Due Collection</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ROW 6: 2-COLUMN TABLES (Low Stock Alerts & Recent Sales) -->
            <div class="row g-4 mb-4">
                <!-- Low Stock Alerts Table -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-dark mb-0 fs-6">
                                <i class="fa-solid fa-triangle-exclamation text-danger me-2"></i> Low Stock Alert (কম স্টক)
                            </h5>
                            <a href="/admin-dashboard-product" class="btn btn-sm btn-outline-danger rounded-pill px-3">View All Stock</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle table-hover mb-0" id="lowStockTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4">Product Name</th>
                                            <th class="text-center">Code</th>
                                            <th class="text-center">Stock</th>
                                            <th class="text-end pe-4">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="lowStockTbody">
                                        <tr><td colspan="4" class="text-center py-4 text-muted">Loading low stock items...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Sales Table -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-dark mb-0 fs-6">
                                <i class="fa-solid fa-clock-rotate-left text-primary me-2"></i> Recent Sales Invoices (সাম্প্রতিক বিক্রি)
                            </h5>
                            <a href="/admin-dashboard-invoice" class="btn btn-sm btn-outline-primary rounded-pill px-3">All Invoices</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle table-hover mb-0" id="recentSalesTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4">Invoice No</th>
                                            <th>Customer</th>
                                            <th class="text-end">Amount</th>
                                            <th class="text-center pe-4">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="recentSalesTbody">
                                        <tr><td colspan="4" class="text-center py-4 text-muted">Loading recent sales invoices...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer copyright -->
            <div class="text-center text-muted py-3 border-top mt-4" style="font-size: 13px;">
                &copy; {{ date('Y') }} মার্স কর্পোরেশন (MARSS CORPORATION) | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-success fw-bold text-decoration-none">CodeNext IT</a>
            </div>

        </div>
    </div>
</div>

<script>
    let salesProfitChartInstance = null;
    let financialDonutChartInstance = null;

    document.addEventListener("DOMContentLoaded", async () => {
        loadDashboardData();
    });

    async function loadDashboardData() {
        try {
            if (typeof showLoader === "function") showLoader();
            const res = await axios.get("/api/dashboard-all-calculation", HeaderToken());
            if (typeof hideLoader === "function") hideLoader();

            if (res.data && res.data.status === 'success') {
                const data = res.data;
                const today = data.today || {};
                const monthly = data.monthly || {};
                const financial = data.financial || {};
                const chart = data.chart || {};

                const userRole = (window.currentUserRole || localStorage.getItem('user_role') || '').toLowerCase();
                const isAdmin = (userRole === 'admin' || userRole === 'super_admin');

                if (document.getElementById('adminOnlyFinancialSections')) {
                    document.getElementById('adminOnlyFinancialSections').style.display = isAdmin ? 'block' : 'none';
                }

                // --- 1. Today's Cards ---
                document.getElementById('todayNetProfit').innerText = '৳ ' + formatMoney(today.net_profit || data.todayNetProfit || 0);
                document.getElementById('todayTotalSales').innerText = '৳ ' + formatMoney(today.sales_amount || data.todayTotalSalesAmount || 0);
                document.getElementById('todaySalesCountBadge').innerText = (today.sales_count || 0) + ' Invoices generated';
                document.getElementById('todayCashCollection').innerText = '৳ ' + formatMoney(today.cash_collection || data.todayTotalPaidAmount || 0);
                document.getElementById('todayExpense').innerText = '৳ ' + formatMoney(today.expense || data.todayTotalExpensesAmount || 0);

                // --- 2. Monthly Cards ---
                document.getElementById('monthlyNetProfit').innerText = '৳ ' + formatMoney(monthly.net_profit || data.monthlyTotalProfit || 0);
                document.getElementById('monthlySales').innerText = '৳ ' + formatMoney(monthly.sales_amount || 0);
                document.getElementById('monthlyCollection').innerText = '৳ ' + formatMoney(monthly.cash_collection || 0);
                document.getElementById('monthlyPurchase').innerText = '৳ ' + formatMoney(monthly.purchase_amount || 0);

                // --- 3. Financial & Inventory ---
                document.getElementById('customerDue').innerText = '৳ ' + formatMoney(financial.customer_due || 0);
                document.getElementById('supplierPayable').innerText = '৳ ' + formatMoney(financial.supplier_payable || 0);
                document.getElementById('costStockValue').innerText = '৳ ' + formatMoney(financial.cost_stock_value || 0);
                document.getElementById('sellStockValue').innerText = '৳ ' + formatMoney(financial.sell_stock_value || 0);

                document.getElementById('productCountBadge').innerText = (financial.total_products || 0) + ' Items';
                document.getElementById('lowStockBadge').innerText = (financial.low_stock_count || 0) + ' Low Stock';

                // --- 4. Render Interactive ApexCharts ---
                renderSalesProfitChart(chart.dates || [], chart.sales || [], chart.profits || []);
                renderFinancialDonutChart(
                    parseFloat(monthly.cash_collection || 0),
                    parseFloat(financial.customer_due || 0),
                    parseFloat(monthly.expense || 0),
                    parseFloat(monthly.net_profit || 0)
                );

                // --- 5. Low Stock Table ---
                const lowStockTbody = document.getElementById('lowStockTbody');
                lowStockTbody.innerHTML = '';
                const lowStockList = data.low_stock_products || [];
                if (lowStockList.length === 0) {
                    lowStockTbody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-success fw-bold"><i class="fa-solid fa-circle-check me-1"></i> All products are well stocked!</td></tr>`;
                } else {
                    lowStockList.forEach(item => {
                        let code = item.product_code || 'N/A';
                        if (Array.isArray(code)) code = code[0] || 'N/A';
                        else if (typeof code === 'string' && code.startsWith('[')) {
                            try { code = JSON.parse(code)[0]; } catch(e){}
                        }

                        const row = `
                            <tr>
                                <td class="ps-4 fw-bold text-dark">${item.product_name}</td>
                                <td class="text-center"><span class="badge bg-light text-dark border font-monospace">${code}</span></td>
                                <td class="text-center"><span class="badge bg-danger px-2 py-1 fw-bold">${item.quantity} ${item.unit || 'pcs'}</span></td>
                                <td class="text-end pe-4">
                                    <a href="/admin-dashboard-Purchase" class="btn btn-sm btn-outline-success rounded-pill px-2 py-1" title="Reorder / Purchase">
                                        <i class="fa-solid fa-cart-plus me-1"></i> Reorder
                                    </a>
                                </td>
                            </tr>
                        `;
                        lowStockTbody.innerHTML += row;
                    });
                }

                // --- 6. Recent Sales Table ---
                const recentSalesTbody = document.getElementById('recentSalesTbody');
                recentSalesTbody.innerHTML = '';
                const recentList = data.recent_invoices || [];
                if (recentList.length === 0) {
                    recentSalesTbody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-muted">No recent sales found</td></tr>`;
                } else {
                    recentList.forEach(inv => {
                        let statusBadge = inv.due_amount <= 0 ? '<span class="badge bg-success px-2 py-1">Paid</span>' :
                                          (inv.paid_amount > 0 ? '<span class="badge bg-warning text-dark px-2 py-1">Partial</span>' : '<span class="badge bg-danger px-2 py-1">Unpaid</span>');

                        const row = `
                            <tr>
                                <td class="ps-4"><a href="/invoice/${inv.id}" class="fw-bold text-success text-decoration-none">${inv.order_no}</a></td>
                                <td class="fw-semibold text-dark">${inv.customer_name}</td>
                                <td class="text-end fw-bold text-dark">৳ ${formatMoney(inv.grand_subtotal)}</td>
                                <td class="text-center pe-4">${statusBadge}</td>
                            </tr>
                        `;
                        recentSalesTbody.innerHTML += row;
                    });
                }

            } else {
                console.error("Dashboard calculation failed:", res.data);
            }

        } catch (e) {
            if (typeof hideLoader === "function") hideLoader();
            console.error("Error loading dashboard data:", e);
        }
    }

    // Render Area Trend Chart (Sales vs Profit)
    function renderSalesProfitChart(dates, sales, profits) {
        const userRole = (window.currentUserRole || '').toLowerCase();
        const isAdmin = (userRole === 'admin' || userRole === 'super_admin');

        let chartSeries = [{
            name: 'Total Sales (মোট বিক্রি)',
            data: sales
        }];
        let chartColors = ['#16a34a'];

        if (isAdmin) {
            chartSeries.push({
                name: 'Net Profit (নিট লাভ)',
                data: profits
            });
            chartColors.push('#0284c7');
        }

        const options = {
            series: chartSeries,
            chart: {
                type: 'area',
                height: 330,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif'
            },
            colors: chartColors,
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            xaxis: {
                categories: dates,
                labels: {
                    style: { colors: '#64748b', fontSize: '12px' }
                }
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return '৳ ' + val.toLocaleString('en-IN');
                    },
                    style: { colors: '#64748b', fontSize: '12px' }
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return '৳ ' + val.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                fontWeight: 600
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4
            }
        };

        if (salesProfitChartInstance) {
            salesProfitChartInstance.destroy();
        }
        salesProfitChartInstance = new ApexCharts(document.querySelector("#salesProfitChart"), options);
        salesProfitChartInstance.render();
    }

    // Render Financial Distribution Donut Chart
    function renderFinancialDonutChart(collections, dues, expenses, profit) {
        const userRole = (window.currentUserRole || '').toLowerCase();
        const isAdmin = (userRole === 'admin' || userRole === 'super_admin');

        let series = [collections, dues, expenses];
        let labels = ['Monthly Collection', 'Customer Dues', 'Monthly Expenses'];
        let colors = ['#7c3aed', '#ef4444', '#f59e0b'];

        if (isAdmin) {
            series.push(Math.max(0, profit));
            labels.push('Net Profit');
            colors.push('#16a34a');
        }

        const options = {
            series: series,
            labels: labels,
            chart: {
                type: 'donut',
                height: 310,
                fontFamily: 'Inter, sans-serif'
            },
            colors: colors,
            legend: {
                position: 'bottom',
                fontSize: '12px',
                fontWeight: 500
            },
            dataLabels: { enabled: false },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Volume',
                                formatter: function (w) {
                                    const sum = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    return '৳ ' + sum.toLocaleString('en-IN');
                                }
                            }
                        }
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return '৳ ' + val.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    }
                }
            }
        };

        if (financialDonutChartInstance) {
            financialDonutChartInstance.destroy();
        }
        financialDonutChartInstance = new ApexCharts(document.querySelector("#financialDonutChart"), options);
        financialDonutChartInstance.render();
    }

    function formatMoney(amount) {
        if (amount === null || isNaN(amount)) return "0.00";
        return parseFloat(amount).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }
</script>

@endsection