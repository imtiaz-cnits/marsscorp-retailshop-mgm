@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Dashboard - MARSS CORPORATION')
@section('content')

<!-- ApexCharts & Flatpickr CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Dashboard Main Content Start -->
<div class="main-content">
    <div class="page-content">
        <div class="w-full">
            
            <!-- Dashboard Custom & Utility Styles -->
            <style>
                .dashboard-header-card {
                    border: 1px solid #e2e8f0;
                    border-radius: 16px;
                    background: #ffffff;
                    transition: background-color 0.2s, border-color 0.2s;
                }
                .dashboard-filter-btn {
                    border: 1px solid #cbd5e1;
                    border-radius: 50rem;
                    padding: 6px 16px;
                    background-color: #ffffff;
                    color: #334155;
                    font-size: 13px;
                    font-weight: 500;
                    display: inline-flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 12px;
                    cursor: pointer;
                    min-width: 125px;
                    height: 38px;
                    transition: all 0.15s ease-in-out;
                }
                .dashboard-filter-btn:hover {
                    border-color: #94a3b8;
                }
                .dashboard-filter-menu {
                    position: absolute;
                    top: calc(100% + 6px);
                    right: 0;
                    min-width: 160px;
                    background-color: #ffffff;
                    border: 1px solid #e2e8f0;
                    border-radius: 12px;
                    box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.04);
                    padding: 6px;
                    z-index: 1050;
                    display: none;
                }
                .dashboard-filter-item {
                    width: 100%;
                    text-align: left;
                    padding: 8px 12px;
                    border: 0;
                    background: transparent;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    border-radius: 8px;
                    font-size: 13px;
                    font-weight: 500;
                    color: #334155;
                    cursor: pointer;
                    transition: background-color 0.15s;
                }
                .dashboard-filter-item:hover {
                    background-color: #f1f5f9;
                }
                .dashboard-filter-item.active {
                    background-color: #0f4a8a !important;
                    color: #ffffff !important;
                }
                .dashboard-filter-item.active .check-icon {
                    display: inline-block !important;
                    color: #ffffff !important;
                }
                .dashboard-filter-item .check-icon {
                    display: none;
                }
                .dashboard-date-input {
                    height: 38px;
                    border-radius: 50rem;
                    border: 1px solid #cbd5e1;
                    background-color: #ffffff;
                    padding: 4px 8px 4px 34px;
                    font-size: 12px;
                    font-weight: 500;
                    color: #334155;
                    width: 132px;
                    outline: none;
                    cursor: pointer;
                }
                .dashboard-date-input:focus {
                    border-color: #0284c7;
                }
                .dashboard-refresh-btn {
                    width: 38px;
                    height: 38px;
                    min-width: 38px;
                    border-radius: 50rem;
                    border: 1px solid #cbd5e1;
                    background-color: #ffffff;
                    color: #475569;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    transition: all 0.2s;
                    cursor: pointer;
                    padding: 0;
                }
                .dashboard-refresh-btn:hover {
                    background-color: #f8fafc;
                    color: #0f172a;
                }
                .dashboard-btn-products {
                    height: 38px;
                    font-size: 13px;
                    border: 1px solid #cbd5e1;
                    background: #ffffff;
                    color: #334155;
                    text-decoration: none;
                    transition: all 0.15s;
                }
                .dashboard-btn-products:hover {
                    background: #f8fafc;
                    color: #0f172a;
                }
                .dashboard-metric-card {
                    border-radius: 14px;
                    background: #ffffff;
                    border: 1px solid #f1f5f9;
                    transition: all 0.2s ease-in-out;
                }
                .dashboard-entity-card {
                    transition: all 0.2s ease-in-out;
                }
                .dashboard-entity-card:hover {
                    background-color: #f8fafc;
                    transform: translateY(-1px);
                }
                @media (min-width: 768px) {
                    .border-end-md {
                        border-right: 1px solid #f1f5f9 !important;
                    }
                }

                /* Dark Mode Support */
                body[light-mode="dark"] .dashboard-header-card,
                html[light-mode="dark"] .dashboard-header-card,
                body[data-layout-mode="dark"] .dashboard-header-card,
                html.dark .dashboard-header-card,
                body.dark-mode .dashboard-header-card,
                body.dark .dashboard-header-card {
                    background-color: #0f172a !important;
                    border-color: #1e293b !important;
                }
                body[light-mode="dark"] .dashboard-header-card h4,
                html[light-mode="dark"] .dashboard-header-card h4 {
                    color: #f8fafc !important;
                }
                body[light-mode="dark"] .dashboard-header-card p,
                html[light-mode="dark"] .dashboard-header-card p {
                    color: #94a3b8 !important;
                }
                body[light-mode="dark"] .dashboard-filter-btn,
                html[light-mode="dark"] .dashboard-filter-btn {
                    background-color: #1e293b !important;
                    border-color: #334155 !important;
                    color: #f1f5f9 !important;
                }
                body[light-mode="dark"] .dashboard-filter-menu,
                html[light-mode="dark"] .dashboard-filter-menu {
                    background-color: #1e293b !important;
                    border-color: #334155 !important;
                }
                body[light-mode="dark"] .dashboard-filter-item,
                html[light-mode="dark"] .dashboard-filter-item {
                    color: #cbd5e1 !important;
                }
                body[light-mode="dark"] .dashboard-filter-item:hover,
                html[light-mode="dark"] .dashboard-filter-item:hover {
                    background-color: #334155 !important;
                }
                body[light-mode="dark"] .dashboard-filter-item.active,
                html[light-mode="dark"] .dashboard-filter-item.active {
                    background-color: #0284c7 !important;
                    color: #ffffff !important;
                }
                body[light-mode="dark"] .dashboard-date-input,
                html[light-mode="dark"] .dashboard-date-input {
                    background-color: #1e293b !important;
                    border-color: #334155 !important;
                    color: #f1f5f9 !important;
                }
                body[light-mode="dark"] .dashboard-refresh-btn,
                html[light-mode="dark"] .dashboard-refresh-btn {
                    background-color: #1e293b !important;
                    border-color: #334155 !important;
                    color: #cbd5e1 !important;
                }
                body[light-mode="dark"] .dashboard-refresh-btn:hover,
                html[light-mode="dark"] .dashboard-refresh-btn:hover {
                    background-color: #334155 !important;
                    color: #ffffff !important;
                }
                body[light-mode="dark"] .dashboard-btn-products,
                html[light-mode="dark"] .dashboard-btn-products {
                    background-color: #1e293b !important;
                    border-color: #334155 !important;
                    color: #cbd5e1 !important;
                }
                body[light-mode="dark"] .dashboard-metric-card,
                html[light-mode="dark"] .dashboard-metric-card {
                    background-color: #0f172a !important;
                    border-color: #1e293b !important;
                }
                body[light-mode="dark"] .dashboard-metric-card h3,
                body[light-mode="dark"] .dashboard-metric-card h4,
                html[light-mode="dark"] .dashboard-metric-card h3,
                html[light-mode="dark"] .dashboard-metric-card h4 {
                    color: #f8fafc !important;
                }
                body[light-mode="dark"] .dashboard-entity-card:hover,
                html[light-mode="dark"] .dashboard-entity-card:hover {
                    background-color: #1e293b !important;
                }
                body[light-mode="dark"] .border-end-md,
                html[light-mode="dark"] .border-end-md {
                    border-color: #334155 !important;
                }

                /* Flatpickr Light Mode Custom Theme */
                .flatpickr-calendar {
                    background: #ffffff !important;
                    border: 1px solid #cbd5e1 !important;
                    border-radius: 14px !important;
                    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.04) !important;
                    font-family: inherit !important;
                    padding: 8px !important;
                    max-width: calc(100vw - 20px) !important;
                }
                .flatpickr-calendar.rightMost,
                .flatpickr-calendar.arrowRight {
                    left: auto !important;
                    right: 15px !important;
                }
                .flatpickr-months {
                    background: transparent !important;
                }
                .flatpickr-months .flatpickr-month {
                    color: #0f172a !important;
                    fill: #0f172a !important;
                    height: 38px !important;
                }
                .flatpickr-current-month {
                    padding: 2px 0 0 0 !important;
                    color: #0f172a !important;
                }
                .flatpickr-current-month .flatpickr-monthDropdown-months {
                    background: #ffffff !important;
                    color: #0f172a !important;
                    font-weight: 700 !important;
                    font-size: 13px !important;
                    padding: 3px 8px !important;
                    border: 1px solid #cbd5e1 !important;
                    border-radius: 6px !important;
                    outline: none !important;
                    cursor: pointer !important;
                    appearance: auto !important;
                    -webkit-appearance: auto !important;
                }
                .flatpickr-current-month .flatpickr-monthDropdown-months option {
                    background-color: #ffffff !important;
                    color: #0f172a !important;
                }
                .flatpickr-current-month input.cur-year {
                    color: #0f172a !important;
                    font-weight: 700 !important;
                    font-size: 14px !important;
                }
                span.flatpickr-weekday {
                    color: #64748b !important;
                    font-weight: 600 !important;
                    font-size: 12px !important;
                }
                .flatpickr-day {
                    color: #0f172a !important;
                    font-weight: 500 !important;
                    border-radius: 8px !important;
                }
                .flatpickr-day:hover {
                    background: #f1f5f9 !important;
                    border-color: #cbd5e1 !important;
                }
                .flatpickr-day.today {
                    border-color: #0284c7 !important;
                    color: #0284c7 !important;
                }
                .flatpickr-day.selected,
                .flatpickr-day.startRange,
                .flatpickr-day.endRange {
                    background: #0284c7 !important;
                    border-color: #0284c7 !important;
                    color: #ffffff !important;
                }
                .flatpickr-day.prevMonthDay,
                .flatpickr-day.nextMonthDay {
                    color: #94a3b8 !important;
                    opacity: 0.6 !important;
                }

                /* Flatpickr Dark Mode Theme */
                body[light-mode="dark"] .flatpickr-calendar,
                html[light-mode="dark"] .flatpickr-calendar,
                body[data-layout-mode="dark"] .flatpickr-calendar,
                html.dark .flatpickr-calendar,
                body.dark-mode .flatpickr-calendar,
                body.dark .flatpickr-calendar {
                    background: #0f172a !important;
                    border: 1px solid #334155 !important;
                    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
                    color: #f1f5f9 !important;
                }
                body[light-mode="dark"] .flatpickr-calendar.arrowTop:before,
                body[light-mode="dark"] .flatpickr-calendar.arrowTop:after,
                html[light-mode="dark"] .flatpickr-calendar.arrowTop:before,
                html[light-mode="dark"] .flatpickr-calendar.arrowTop:after {
                    border-bottom-color: #0f172a !important;
                }
                body[light-mode="dark"] .flatpickr-calendar.arrowBottom:before,
                body[light-mode="dark"] .flatpickr-calendar.arrowBottom:after,
                html[light-mode="dark"] .flatpickr-calendar.arrowBottom:before,
                html[light-mode="dark"] .flatpickr-calendar.arrowBottom:after {
                    border-top-color: #0f172a !important;
                }
                body[light-mode="dark"] .flatpickr-months,
                body[light-mode="dark"] .flatpickr-months .flatpickr-month,
                html[light-mode="dark"] .flatpickr-months,
                html[light-mode="dark"] .flatpickr-months .flatpickr-month {
                    background: #0f172a !important;
                    color: #f1f5f9 !important;
                    fill: #f1f5f9 !important;
                }
                body[light-mode="dark"] .flatpickr-current-month,
                html[light-mode="dark"] .flatpickr-current-month {
                    color: #f1f5f9 !important;
                }
                body[light-mode="dark"] .flatpickr-current-month .flatpickr-monthDropdown-months,
                html[light-mode="dark"] .flatpickr-current-month .flatpickr-monthDropdown-months {
                    background: #1e293b !important;
                    border-color: #334155 !important;
                    color: #f1f5f9 !important;
                }
                body[light-mode="dark"] .flatpickr-current-month .flatpickr-monthDropdown-months option,
                html[light-mode="dark"] .flatpickr-current-month .flatpickr-monthDropdown-months option {
                    background: #1e293b !important;
                    color: #f1f5f9 !important;
                }
                body[light-mode="dark"] .flatpickr-current-month input.cur-year,
                html[light-mode="dark"] .flatpickr-current-month input.cur-year {
                    color: #f1f5f9 !important;
                }
                body[light-mode="dark"] .flatpickr-current-month .numInputWrapper span.arrowUp:after,
                html[light-mode="dark"] .flatpickr-current-month .numInputWrapper span.arrowUp:after {
                    border-bottom-color: #f1f5f9 !important;
                }
                body[light-mode="dark"] .flatpickr-current-month .numInputWrapper span.arrowDown:after,
                html[light-mode="dark"] .flatpickr-current-month .numInputWrapper span.arrowDown:after {
                    border-top-color: #f1f5f9 !important;
                }
                body[light-mode="dark"] span.flatpickr-weekday,
                html[light-mode="dark"] span.flatpickr-weekday {
                    background: #0f172a !important;
                    color: #94a3b8 !important;
                    font-weight: 600;
                }
                body[light-mode="dark"] .flatpickr-day,
                html[light-mode="dark"] .flatpickr-day {
                    color: #e2e8f0 !important;
                }
                body[light-mode="dark"] .flatpickr-day:hover,
                html[light-mode="dark"] .flatpickr-day:hover {
                    background: #1e293b !important;
                    border-color: #334155 !important;
                }
                body[light-mode="dark"] .flatpickr-day.prevMonthDay,
                body[light-mode="dark"] .flatpickr-day.nextMonthDay,
                html[light-mode="dark"] .flatpickr-day.prevMonthDay,
                html[light-mode="dark"] .flatpickr-day.nextMonthDay {
                    color: #475569 !important;
                }
                body[light-mode="dark"] .flatpickr-day.today,
                html[light-mode="dark"] .flatpickr-day.today {
                    border-color: #0284c7 !important;
                }
                body[light-mode="dark"] .flatpickr-day.selected,
                body[light-mode="dark"] .flatpickr-day.startRange,
                body[light-mode="dark"] .flatpickr-day.endRange,
                html[light-mode="dark"] .flatpickr-day.selected,
                html[light-mode="dark"] .flatpickr-day.startRange,
                html[light-mode="dark"] .flatpickr-day.endRange {
                    background: #0284c7 !important;
                    border-color: #0284c7 !important;
                    color: #ffffff !important;
                }
            </style>

            <!-- Overview Dashboard Header Card -->
            <div class="card border-0 shadow-sm mb-4 dashboard-header-card">
                <div class="card-body p-3 p-md-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3 flex-shrink-0">
                        <div class="rounded-3 d-flex align-items-center justify-content-center shadow-sm flex-shrink-0" style="width: 44px; height: 44px; min-width: 44px; background: #e0f2fe; color: #0284c7;">
                            <i class="fa-solid fa-arrow-trend-up fs-5"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-dark mb-0 fs-5">Overview Dashboard</h4>
                            <p class="text-muted small mb-0">Real-time sales, collections, expenses, dues &amp; business metrics</p>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2 ms-auto justify-content-end">
                        <!-- Custom Filter Dropdown -->
                        <div class="position-relative" id="dashboardFilterDropdownWrap">
                            <button type="button" id="dashboardFilterDropdownBtn" class="dashboard-filter-btn">
                                <span id="dashboardFilterSelectedText">Today</span>
                                <i class="fa-solid fa-chevron-down text-muted" id="dashboardFilterChevron" style="font-size: 11px; transition: transform 0.2s;"></i>
                            </button>
                            <div id="dashboardFilterMenu" class="dashboard-filter-menu">
                                <button type="button" class="dashboard-filter-item active" data-filter="today">
                                    <span>Today</span>
                                    <i class="fa-solid fa-check check-icon"></i>
                                </button>
                                <button type="button" class="dashboard-filter-item" data-filter="last_week">
                                    <span>Last Week</span>
                                    <i class="fa-solid fa-check check-icon"></i>
                                </button>
                                <button type="button" class="dashboard-filter-item" data-filter="last_month">
                                    <span>Last Month</span>
                                    <i class="fa-solid fa-check check-icon"></i>
                                </button>
                                <button type="button" class="dashboard-filter-item" data-filter="date_wise">
                                    <span>Date Wise</span>
                                    <i class="fa-solid fa-check check-icon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Date Range Pickers (Shown when Date Wise is selected) -->
                        <div id="dashboardDateRangeBox" class="d-none align-items-center gap-2">
                            <div class="position-relative d-inline-flex align-items-center">
                                <i class="fa-regular fa-calendar position-absolute text-success" style="left: 12px; font-size: 13px; pointer-events: none; z-index: 2;"></i>
                                <input type="text" id="dashboardStartDate" placeholder="From Date" class="dashboard-date-input" readonly>
                            </div>
                            <span class="text-muted small fw-medium">to</span>
                            <div class="position-relative d-inline-flex align-items-center">
                                <i class="fa-regular fa-calendar position-absolute text-success" style="left: 12px; font-size: 13px; pointer-events: none; z-index: 2;"></i>
                                <input type="text" id="dashboardEndDate" placeholder="To Date" class="dashboard-date-input" readonly>
                            </div>
                        </div>

                        <!-- Refresh Button -->
                        <button type="button" id="dashboardRefreshBtn" class="dashboard-refresh-btn" title="Reload Dashboard Data">
                            <i class="fa-solid fa-rotate" id="dashboardRefreshIcon" style="font-size: 13px;"></i>
                        </button>

                        <!-- POS Terminal Button -->
                        <a href="{{ route('battery.pos') }}" class="btn rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1.5 text-white shadow-sm" style="height: 38px; font-size: 13px; background: #0f4a8a; border-color: #0f4a8a; white-space: nowrap;">
                            <i class="fa-solid fa-cart-shopping me-1"></i> POS Terminal
                        </a>

                        <!-- Products Button -->
                        <a href="{{ route('battery.products') }}" class="btn dashboard-btn-products rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1.5 shadow-none" style="white-space: nowrap;">
                            <i class="fa-solid fa-circle-plus me-1 text-success"></i> Products
                        </a>
                    </div>
                </div>
            </div>
            </div>

            <!-- FINANCIAL METRICS & CHARTS WRAPPER -->
            <div id="batteryFinancialSections">
                <style>
                    #batteryFinancialSections .btn-outline-purple:hover {
                        background-color: #7c3aed !important;
                        color: #ffffff !important;
                    }
                    #batteryFinancialSections .btn-outline-purple:hover i,
                    #batteryFinancialSections .btn-outline-purple:hover span {
                        color: #ffffff !important;
                    }
                </style>
                <!-- ROW 1: TODAY'S KEY METRICS (INCOME, CASH COLLECTION, EXPENSE, PROFIT) -->
                <div class="row g-3 mb-4">
                    <!-- Income (Total Sales) -->
                    <div class="col-xl-3 col-md-6 today-metric-col">
                        <div class="card border-0 shadow-sm h-100 p-3 dashboard-metric-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.3px;">INCOME</span>
                                <span class="rounded-2 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background: #e0f2fe; color: #0284c7; font-size: 13px;">
                                    <i class="fa-solid fa-money-bill-wave"></i>
                                </span>
                            </div>
                            <h3 id="todayTotalSales" class="fw-bold mb-2 text-dark fs-4">৳ 0.00</h3>
                            <small class="text-primary d-flex align-items-center gap-1" style="font-size: 11.5px; font-weight: 500;">
                                <i class="fa-solid fa-arrow-trend-up"></i> Total Sales Revenue
                            </small>
                        </div>
                    </div>

                    <!-- Cash Collection -->
                    <div class="col-xl-3 col-md-6 today-metric-col">
                        <div class="card border-0 shadow-sm h-100 p-3 dashboard-metric-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.3px;">CASH COLLECTION</span>
                                <span class="rounded-2 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background: #dcfce7; color: #16a34a; font-size: 13px;">
                                    <i class="fa-solid fa-wallet"></i>
                                </span>
                            </div>
                            <h3 id="todayCashCollection" class="fw-bold mb-2 text-dark fs-4">৳ 0.00</h3>
                            <small class="text-success d-flex align-items-center gap-1" style="font-size: 11.5px; font-weight: 500;">
                                <i class="fa-solid fa-arrow-trend-up"></i> Paid at Counter &amp; Dues
                            </small>
                        </div>
                    </div>

                    <!-- Operating Expense -->
                    <div class="col-xl-3 col-md-6 today-metric-col">
                        <div class="card border-0 shadow-sm h-100 p-3 dashboard-metric-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.3px;">EXPENSE</span>
                                <span class="rounded-2 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background: #fef3c7; color: #d97706; font-size: 13px;">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                </span>
                            </div>
                            <h3 id="todayExpense" class="fw-bold mb-2 text-dark fs-4">৳ 0.00</h3>
                            <small class="text-warning d-flex align-items-center gap-1" style="font-size: 11.5px; font-weight: 500; color: #d97706 !important;">
                                <i class="fa-regular fa-clock"></i> Operating Expenses
                            </small>
                        </div>
                    </div>

                    <!-- Net Profit -->
                    <div class="col-xl-3 col-md-6" id="todayNetProfitCol">
                        <div class="card border-0 shadow-sm h-100 p-3 dashboard-metric-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.3px;">PROFIT</span>
                                <span class="rounded-2 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background: #e0f2fe; color: #0284c7; font-size: 13px;">
                                    <i class="fa-solid fa-chart-line"></i>
                                </span>
                            </div>
                            <h3 id="todayNetProfit" class="fw-bold mb-2 text-dark fs-4">৳ 0.00</h3>
                            <small class="text-info d-flex align-items-center gap-1" style="font-size: 11.5px; font-weight: 500; color: #0284c7 !important;">
                                <i class="fa-solid fa-arrow-trend-up"></i> Net Business Profit
                            </small>
                        </div>
                    </div>
                </div>

                <!-- ROW 2: COMPACT FINANCIAL METRICS (Receivable Due, Payable Due, Return, Discount) -->
                <div class="row g-3 mb-3">
                    <!-- Receivable Due -->
                    <div class="col-xl-3 col-md-6 col-sm-6">
                        <div class="card border-0 shadow-sm px-3 py-2.5 h-100" style="border-radius: 12px; background: #ffffff;">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 24px; height: 24px; min-width: 24px; background: #fef3c7; color: #d97706; font-size: 11px;">
                                    <i class="fa-solid fa-users"></i>
                                </span>
                                <span class="text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.3px;">RECEIVABLE DUE</span>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <h4 id="customerDue" class="fw-bold mb-0 text-dark" style="font-size: 17px;">৳ 0.00</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Payable Due -->
                    <div class="col-xl-3 col-md-6 col-sm-6">
                        <div class="card border-0 shadow-sm px-3 py-2.5 h-100" style="border-radius: 12px; background: #ffffff;">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 24px; height: 24px; min-width: 24px; background: #e0e7ff; color: #4f46e5; font-size: 11px;">
                                    <i class="fa-solid fa-truck-field"></i>
                                </span>
                                <span class="text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.3px;">PAYABLE DUE</span>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <h4 id="supplierPayable" class="fw-bold mb-0 text-dark" style="font-size: 17px;">৳ 0.00</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Return -->
                    <div class="col-xl-3 col-md-6 col-sm-6">
                        <div class="card border-0 shadow-sm px-3 py-2.5 h-100" style="border-radius: 12px; background: #ffffff;">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 24px; height: 24px; min-width: 24px; background: #ffe4e6; color: #e11d48; font-size: 11px;">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </span>
                                <span class="text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.3px;">RETURN</span>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <h4 id="totalReturnAmount" class="fw-bold mb-0 text-dark" style="font-size: 17px;">৳ 0.00</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Discount -->
                    <div class="col-xl-3 col-md-6 col-sm-6">
                        <div class="card border-0 shadow-sm px-3 py-2.5 h-100" style="border-radius: 12px; background: #ffffff;">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 24px; height: 24px; min-width: 24px; background: #f3e8ff; color: #9333ea; font-size: 11px;">
                                    <i class="fa-solid fa-percent"></i>
                                </span>
                                <span class="text-muted text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.3px;">DISCOUNT</span>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <h4 id="totalDiscountAmount" class="fw-bold mb-0 text-dark" style="font-size: 17px;">৳ 0.00</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ROW 3: UNIFIED 3-COLUMN ENTITIES CARD (Total Products, Total Customers, Total Suppliers) -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px; background: #ffffff;">
                    <div class="card-body p-2 p-md-3">
                        <div class="row g-2 g-md-0 align-items-center">
                            <!-- Total Products -->
                            <div class="col-md-4 border-end-md">
                                <a href="{{ route('battery.products') }}" class="d-flex align-items-center justify-content-between p-2 px-3 rounded-3 text-decoration-none dashboard-entity-card transition-all" style="color: inherit;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; min-width: 42px; background: #ffe4e6; color: #e11d48; font-size: 16px;">
                                            <i class="fa-solid fa-box-archive"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-6 mb-0">Total Products</div>
                                            <div class="text-muted small" style="font-size: 11.5px;">Active Battery Catalog</div>
                                        </div>
                                    </div>
                                    <div id="totalProductsCount" class="fs-4 fw-bold text-dark pe-2">0</div>
                                </a>
                            </div>
                            <!-- Total Customers -->
                            <div class="col-md-4 border-end-md">
                                <a href="{{ route('battery.customers') }}" class="d-flex align-items-center justify-content-between p-2 px-3 rounded-3 text-decoration-none dashboard-entity-card transition-all" style="color: inherit;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; min-width: 42px; background: #ccfbf1; color: #0d9488; font-size: 16px;">
                                            <i class="fa-solid fa-user-group"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-6 mb-0">Total Customers</div>
                                            <div class="text-muted small" style="font-size: 11.5px;">Registered Client Profiles</div>
                                        </div>
                                    </div>
                                    <div id="totalCustomersCount" class="fs-4 fw-bold text-dark pe-2">0</div>
                                </a>
                            </div>
                            <!-- Total Suppliers -->
                            <div class="col-md-4">
                                <a href="{{ route('battery.suppliers') }}" class="d-flex align-items-center justify-content-between p-2 px-3 rounded-3 text-decoration-none dashboard-entity-card transition-all" style="color: inherit;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; min-width: 42px; background: #ede9fe; color: #7c3aed; font-size: 16px;">
                                            <i class="fa-solid fa-building-user"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-6 mb-0">Total Suppliers</div>
                                            <div class="text-muted small" style="font-size: 11.5px;">Verified Battery Vendors</div>
                                        </div>
                                    </div>
                                    <div id="totalSuppliersCount" class="fs-4 fw-bold text-dark pe-2">0</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ROW 4: GRAPHICAL ANALYTICS CHARTS (Sales & Profit Trend + Financial Breakdown) -->
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
                                    <h3 id="customerDueBottom" class="fw-bold text-danger mb-0 mt-1">৳ 0.00</h3>
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
                                    <h3 id="supplierPayableBottom" class="fw-bold text-warning mb-0 mt-1">৳ 0.00</h3>
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
                                <a href="{{ route('battery.pos') }}" class="btn btn-outline-success w-100 py-3 d-flex flex-column align-items-center gap-2 rounded-3 shadow-sm border-2">
                                    <i class="fa-solid fa-cart-shopping fs-3"></i>
                                    <span class="fw-bold small">New POS Sale</span>
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6">
                                <a href="{{ route('battery.products') }}" class="btn btn-outline-primary w-100 py-3 d-flex flex-column align-items-center gap-2 rounded-3 shadow-sm border-2">
                                    <i class="fa-solid fa-box-open fs-3"></i>
                                    <span class="fw-bold small">Add Product</span>
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6">
                                <a href="{{ route('battery.purchases') }}" class="btn btn-outline-info w-100 py-3 d-flex flex-column align-items-center gap-2 rounded-3 shadow-sm border-2">
                                    <i class="fa-solid fa-truck-ramp-box fs-3"></i>
                                    <span class="fw-bold small">Purchase Stock</span>
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6">
                                <a href="{{ route('battery.customers') }}" class="btn btn-outline-purple w-100 py-3 d-flex flex-column align-items-center gap-2 rounded-3 shadow-sm border-2" style="color: #7c3aed; border-color: #7c3aed;">
                                    <i class="fa-solid fa-users fs-3"></i>
                                    <span class="fw-bold small">Customers</span>
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6">
                                <a href="{{ route('battery.suppliers') }}" class="btn btn-outline-dark w-100 py-3 d-flex flex-column align-items-center gap-2 rounded-3 shadow-sm border-2">
                                    <i class="fa-solid fa-truck-field fs-3"></i>
                                    <span class="fw-bold small">Suppliers</span>
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6">
                                <a href="{{ route('battery.customer.due') }}" class="btn btn-outline-danger w-100 py-3 d-flex flex-column align-items-center gap-2 rounded-3 shadow-sm border-2">
                                    <i class="fa-solid fa-hand-holding-dollar fs-3"></i>
                                    <span class="fw-bold small">Due Collection</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ROW 6: OPERATIONAL TABLES (Low Stock Alert & Recent Sales) -->
                <div class="row g-3">
                    <!-- Low Stock Alerts -->
                    <div class="col-xl-6 col-lg-12">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                            <div class="card-header bg-transparent border-0 pt-3 px-4 pb-2 d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold text-danger mb-0 d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-triangle-exclamation"></i> Low Stock Alert (Battery Inventory)
                                </h5>
                                <a href="{{ route('battery.products') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold small">View Catalog</a>
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
                                <a href="{{ route('battery.invoices') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold small">All Invoices</a>
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

    let currentDashboardFilter = 'today';
    let currentDashboardStartDate = '';
    let currentDashboardEndDate = '';
    let dashboardStartPicker = null;
    let dashboardEndPicker = null;

    function initBatteryDashboardFilter() {
        const wrap = document.getElementById('dashboardFilterDropdownWrap');
        const btn = document.getElementById('dashboardFilterDropdownBtn');
        const menu = document.getElementById('dashboardFilterMenu');
        const chevron = document.getElementById('dashboardFilterChevron');
        const selectedText = document.getElementById('dashboardFilterSelectedText');
        const dateBox = document.getElementById('dashboardDateRangeBox');
        const refreshBtn = document.getElementById('dashboardRefreshBtn');
        const refreshIcon = document.getElementById('dashboardRefreshIcon');

        if (!btn || !menu) return;

        // Toggle Dropdown Menu
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = menu.style.display === 'block';
            menu.style.display = isOpen ? 'none' : 'block';
            if (chevron) {
                chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (wrap && !wrap.contains(e.target)) {
                menu.style.display = 'none';
                if (chevron) chevron.style.transform = 'rotate(0deg)';
            }
        });

        // Dropdown Items Click
        const items = menu.querySelectorAll('.dashboard-filter-item');
        items.forEach(item => {
            item.addEventListener('click', function(e) {
                e.stopPropagation();
                items.forEach(i => {
                    i.classList.remove('active');
                    const ck = i.querySelector('.check-icon');
                    if (ck) ck.style.display = 'none';
                });
                this.classList.add('active');
                const ck = this.querySelector('.check-icon');
                if (ck) ck.style.display = 'inline-block';

                const filter = this.getAttribute('data-filter');
                currentDashboardFilter = filter;
                const textSpan = this.querySelector('span');
                if (selectedText && textSpan) {
                    selectedText.innerText = textSpan.innerText;
                }

                menu.style.display = 'none';
                if (chevron) chevron.style.transform = 'rotate(0deg)';

                if (filter === 'date_wise') {
                    if (dateBox) {
                        dateBox.classList.remove('d-none');
                        dateBox.classList.add('d-flex');
                    }
                    if (!currentDashboardStartDate) {
                        const now = new Date();
                        const y = now.getFullYear();
                        const m = String(now.getMonth() + 1).padStart(2, '0');
                        const d = String(now.getDate()).padStart(2, '0');
                        const todayFormatted = `${y}-${m}-${d}`;
                        currentDashboardStartDate = todayFormatted;
                        currentDashboardEndDate = todayFormatted;
                        if (dashboardStartPicker) dashboardStartPicker.setDate(todayFormatted, false);
                        if (dashboardEndPicker) dashboardEndPicker.setDate(todayFormatted, false);
                    }
                    loadBatteryDashboardData('date_wise', currentDashboardStartDate, currentDashboardEndDate || currentDashboardStartDate);
                } else {
                    if (dateBox) {
                        dateBox.classList.add('d-none');
                        dateBox.classList.remove('d-flex');
                    }
                    loadBatteryDashboardData(currentDashboardFilter);
                }
            });
        });

        // Flatpickr initialization
        if (typeof flatpickr !== 'undefined') {
            const handlePickerSync = () => {
                if (!dashboardStartPicker) return;
                const sDate = dashboardStartPicker.input.value;
                const eDate = dashboardEndPicker ? dashboardEndPicker.input.value : sDate;
                if (sDate) {
                    currentDashboardStartDate = sDate;
                    currentDashboardEndDate = eDate || sDate;
                    if (currentDashboardFilter === 'date_wise') {
                        loadBatteryDashboardData('date_wise', currentDashboardStartDate, currentDashboardEndDate);
                    }
                }
            };

            const flatpickrConfig = {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d M Y",
                altInputClass: "dashboard-date-input",
                allowInput: true,
                position: "auto right",
                onOpen: function(selectedDates, dateStr, instance) {
                    setTimeout(() => {
                        const cal = instance.calendarContainer;
                        if (cal) {
                            const rect = cal.getBoundingClientRect();
                            if (rect.right > (window.innerWidth - 10)) {
                                const overflow = rect.right - window.innerWidth + 15;
                                cal.style.left = Math.max(10, cal.offsetLeft - overflow) + 'px';
                            }
                        }
                    }, 10);
                },
                onChange: function(selectedDates, dateStr, instance) {
                    if (instance.element.id === 'dashboardStartDate') {
                        currentDashboardStartDate = dateStr;
                        if (dashboardEndPicker) {
                            dashboardEndPicker.set('minDate', dateStr);
                            if (!currentDashboardEndDate || currentDashboardEndDate < dateStr) {
                                currentDashboardEndDate = dateStr;
                                dashboardEndPicker.setDate(dateStr, false);
                            }
                        }
                    } else if (instance.element.id === 'dashboardEndDate') {
                        currentDashboardEndDate = dateStr;
                        if (!currentDashboardStartDate) {
                            currentDashboardStartDate = dateStr;
                            if (dashboardStartPicker) dashboardStartPicker.setDate(dateStr, false);
                        }
                    }
                    handlePickerSync();
                },
                onClose: function() {
                    handlePickerSync();
                }
            };

            const startEl = document.getElementById('dashboardStartDate');
            const endEl = document.getElementById('dashboardEndDate');
            if (startEl) dashboardStartPicker = flatpickr(startEl, { ...flatpickrConfig, placeholder: "From Date" });
            if (endEl) dashboardEndPicker = flatpickr(endEl, { ...flatpickrConfig, placeholder: "To Date" });
        }

        // Refresh Button Click
        if (refreshBtn) {
            refreshBtn.addEventListener('click', async () => {
                if (refreshIcon) refreshIcon.classList.add('fa-spin');
                await loadBatteryDashboardData(currentDashboardFilter, currentDashboardStartDate, currentDashboardEndDate);
                setTimeout(() => {
                    if (refreshIcon) refreshIcon.classList.remove('fa-spin');
                }, 400);
            });
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        initBatteryDashboardFilter();
        loadBatteryDashboardData();
    });

    async function loadBatteryDashboardData(filterType = currentDashboardFilter, startDate = currentDashboardStartDate, endDate = currentDashboardEndDate) {
        try {
            if (typeof showLoader === "function") showLoader();
            let queryParams = `?filter_type=${encodeURIComponent(filterType)}`;
            const s = startDate || currentDashboardStartDate;
            const e = endDate || currentDashboardEndDate || s;
            if (filterType === 'date_wise' && s) {
                queryParams += `&start_date=${encodeURIComponent(s)}&end_date=${encodeURIComponent(e)}`;
            }
            const res = await axios.get(`/api/battery/dashboard-all-calculation${queryParams}`, HeaderToken());
            if (typeof hideLoader === "function") hideLoader();

            if (res.data && res.data.status === 'success') {
                const data = res.data;
                const today = data.today || {};
                const monthly = data.monthly || {};
                const financial = data.financial || {};
                const chart = data.chart || {};

                // 1. Filtered Banner Cards (8 Key Metrics)
                if (document.getElementById('todayTotalSales')) document.getElementById('todayTotalSales').innerText = '৳ ' + formatMoney(today.sales_amount || 0);
                if (document.getElementById('todayCashCollection')) document.getElementById('todayCashCollection').innerText = '৳ ' + formatMoney(today.cash_collection || 0);
                if (document.getElementById('todayExpense')) document.getElementById('todayExpense').innerText = '৳ ' + formatMoney(today.expense || 0);
                if (document.getElementById('todayNetProfit')) document.getElementById('todayNetProfit').innerText = '৳ ' + formatMoney(today.net_profit || 0);
                if (document.getElementById('customerDue')) document.getElementById('customerDue').innerText = '৳ ' + formatMoney(today.customer_due !== undefined ? today.customer_due : (financial.customer_due || 0));
                if (document.getElementById('supplierPayable')) document.getElementById('supplierPayable').innerText = '৳ ' + formatMoney(today.supplier_payable !== undefined ? today.supplier_payable : (financial.supplier_payable || 0));
                if (document.getElementById('totalReturnAmount')) document.getElementById('totalReturnAmount').innerText = '৳ ' + formatMoney(today.total_return !== undefined ? today.total_return : (financial.total_return || 0));
                if (document.getElementById('totalDiscountAmount')) document.getElementById('totalDiscountAmount').innerText = '৳ ' + formatMoney(today.total_discount !== undefined ? today.total_discount : (financial.total_discount || 0));
                if (document.getElementById('todaySalesCountBadge')) document.getElementById('todaySalesCountBadge').innerText = (today.sales_count || 0) + ' Invoices generated';

                // 2. Monthly Cards
                document.getElementById('monthlyNetProfit').innerText = '৳ ' + formatMoney(monthly.net_profit || data.monthlyTotalProfit || 0);
                document.getElementById('monthlySales').innerText = '৳ ' + formatMoney(monthly.sales_amount || 0);
                document.getElementById('monthlyCollection').innerText = '৳ ' + formatMoney(monthly.cash_collection || 0);
                document.getElementById('monthlyPurchase').innerText = '৳ ' + formatMoney(monthly.purchase_amount || 0);

                // 3. Balance & Inventory
                const formattedCustDue = '৳ ' + formatMoney(financial.customer_due || 0);
                if (document.getElementById('customerDue')) document.getElementById('customerDue').innerText = formattedCustDue;
                if (document.getElementById('customerDueBottom')) document.getElementById('customerDueBottom').innerText = '৳ ' + formatMoney(financial.lifetime_customer_due || financial.customer_due || 0);

                const formattedSuppPay = '৳ ' + formatMoney(financial.supplier_payable || 0);
                if (document.getElementById('supplierPayable')) document.getElementById('supplierPayable').innerText = formattedSuppPay;
                if (document.getElementById('supplierPayableBottom')) document.getElementById('supplierPayableBottom').innerText = '৳ ' + formatMoney(financial.lifetime_supplier_payable || financial.supplier_payable || 0);

                if (document.getElementById('totalReturnAmount')) {
                    document.getElementById('totalReturnAmount').innerText = '৳ ' + formatMoney(financial.total_return || 0);
                }
                if (document.getElementById('totalDiscountAmount')) {
                    document.getElementById('totalDiscountAmount').innerText = '৳ ' + formatMoney(financial.total_discount || 0);
                }

                if (document.getElementById('totalProductsCount')) {
                    document.getElementById('totalProductsCount').innerText = financial.total_products || 0;
                }
                if (document.getElementById('totalCustomersCount')) {
                    document.getElementById('totalCustomersCount').innerText = financial.total_customers || 0;
                }
                if (document.getElementById('totalSuppliersCount')) {
                    document.getElementById('totalSuppliersCount').innerText = financial.total_suppliers || 0;
                }

                if (document.getElementById('costStockValue')) document.getElementById('costStockValue').innerText = '৳ ' + formatMoney(financial.cost_stock_value || 0);
                if (document.getElementById('sellStockValue')) document.getElementById('sellStockValue').innerText = '৳ ' + formatMoney(financial.sell_stock_value || 0);
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
