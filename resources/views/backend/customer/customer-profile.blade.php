@extends('layouts.dashboard-sidenav')
@section('title', 'Customer Profile - MARSS CORPORATION')

@section('topbar_back_button')
  <a href="javascript:void(0)" onclick="if(window.history.length > 1 && document.referrer && document.referrer !== window.location.href){ window.history.back(); } else { window.location.href = '{{ url('/customer-list') }}'; }" class="topbar-back-btn" title="Back">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back</span>
  </a>
@endsection

@section('content')

<!-- Flatpickr Styles & Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

{{-- ═════════════════════════════════════════════════════════════════
     CUSTOMER PROFILE PAGE (MATCHING SUPPLIER PROFILE THEME & RULES)
═════════════════════════════════════════════════════════════════ --}}

<style>
    /* ─── Flatpickr z-index on top of modals ─── */
    .flatpickr-calendar {
        z-index: 999999 !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25) !important;
        border: 1px solid #e2e8f0 !important;
    }
    body[light-mode="dark"] .flatpickr-calendar,
    html.dark .flatpickr-calendar,
    body.dark .flatpickr-calendar {
        background: #1e293b !important;
        border-color: #334155 !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6) !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .flatpickr-calendar .flatpickr-day,
    html.dark .flatpickr-calendar .flatpickr-day,
    body.dark .flatpickr-calendar .flatpickr-day {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .flatpickr-calendar .flatpickr-day.today,
    html.dark .flatpickr-calendar .flatpickr-day.today,
    body.dark .flatpickr-calendar .flatpickr-day.today {
        border-color: #16a34a !important;
    }
    body[light-mode="dark"] .flatpickr-calendar .flatpickr-day.selected,
    html.dark .flatpickr-calendar .flatpickr-day.selected,
    body.dark .flatpickr-calendar .flatpickr-day.selected {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] .flatpickr-calendar .flatpickr-current-month,
    html.dark .flatpickr-calendar .flatpickr-current-month,
    body.dark .flatpickr-calendar .flatpickr-current-month {
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .flatpickr-calendar .flatpickr-month,
    html.dark .flatpickr-calendar .flatpickr-month,
    body.dark .flatpickr-calendar .flatpickr-month {
        fill: #f8fafc !important;
    }
    body[light-mode="dark"] .flatpickr-calendar span.flatpickr-weekday,
    html.dark .flatpickr-calendar span.flatpickr-weekday,
    body.dark .flatpickr-calendar span.flatpickr-weekday {
        color: #94a3b8 !important;
    }

    /* ─── Global & Unified UI Design Tokens ─── */
    .unified-ui-border {
        border: 1px solid #e2e8f0 !important;
    }
    body[light-mode="dark"] .unified-ui-border,
    body[data-layout-mode="dark"] .unified-ui-border,
    html.dark .unified-ui-border,
    body.dark .unified-ui-border {
        border-color: #334155 !important;
    }

    /* ─── Profile Header Action Buttons (38px Standard Height) ─── */
    .cp-btn-primary {
        height: 38px !important;
        min-height: 38px !important;
        padding: 0 16px !important;
        border-radius: 12px !important;
        background-color: #15803d !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 13px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        border: none !important;
        cursor: pointer !important;
        box-shadow: 0 2px 6px rgba(21, 128, 61, 0.25) !important;
        transition: all 0.15s ease-in-out !important;
        white-space: nowrap !important;
    }
    .cp-btn-primary:hover {
        background-color: #166534 !important;
        color: #ffffff !important;
        transform: translateY(-1px);
    }
    .cp-btn-primary:active {
        transform: translateY(0);
    }

    /* ─── Customer Info Box ─── */
    .customer-info-box {
        background: #ffffff;
        border-radius: 16px;
        transition: all 0.2s ease;
    }
    body[light-mode="dark"] .customer-info-box,
    body[data-layout-mode="dark"] .customer-info-box,
    html.dark .customer-info-box,
    body.dark .customer-info-box {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    .customer-avatar-img {
        width: 80px;
        height: 80px;
        min-width: 80px;
        min-height: 80px;
        max-width: 80px;
        max-height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #86efac;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
    }
    body[light-mode="dark"] .customer-avatar-img,
    html.dark .customer-avatar-img,
    body.dark .customer-avatar-img {
        border-color: #16a34a !important;
    }

    /* ─── Stat Cards Grid (Responsive, Fits 100% without overflow) ─── */
    .cp-stat-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
        width: 100%;
        max-width: 100%;
        margin-bottom: 16px;
        box-sizing: border-box;
    }
    @media (min-width: 768px) and (max-width: 1199px) {
        .cp-stat-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }
    }
    @media (min-width: 1200px) {
        .cp-stat-grid {
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 12px;
        }
    }
    .cp-stat-card {
        background-color: #ffffff;
        border-radius: 14px;
        padding: 10px 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        min-width: 0;
        overflow: hidden;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        box-sizing: border-box;
    }
    .cp-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
    }
    body[light-mode="dark"] .cp-stat-card,
    body[data-layout-mode="dark"] .cp-stat-card,
    html.dark .cp-stat-card,
    body.dark .cp-stat-card {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }

    .cp-stat-icon {
        width: 36px;
        height: 36px;
        min-width: 36px;
        min-height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    .cp-stat-icon.icon-sky {
        background-color: #f0f9ff;
        color: #0284c7;
    }
    .cp-stat-icon.icon-emerald {
        background-color: #ecfdf5;
        color: #059669;
    }
    .cp-stat-icon.icon-teal {
        background-color: #f0fdfa;
        color: #0d9488;
    }
    .cp-stat-icon.icon-rose {
        background-color: #fff1f2;
        color: #e11d48;
    }

    body[light-mode="dark"] .cp-stat-icon.icon-sky,
    body[data-layout-mode="dark"] .cp-stat-icon.icon-sky,
    html.dark .cp-stat-icon.icon-sky,
    body.dark .cp-stat-icon.icon-sky {
        background-color: rgba(2, 132, 199, 0.2) !important;
        color: #38bdf8 !important;
    }
    body[light-mode="dark"] .cp-stat-icon.icon-emerald,
    body[data-layout-mode="dark"] .cp-stat-icon.icon-emerald,
    html.dark .cp-stat-icon.icon-emerald,
    body.dark .cp-stat-icon.icon-emerald {
        background-color: rgba(5, 150, 105, 0.2) !important;
        color: #34d399 !important;
    }
    body[light-mode="dark"] .cp-stat-icon.icon-teal,
    body[data-layout-mode="dark"] .cp-stat-icon.icon-teal,
    html.dark .cp-stat-icon.icon-teal,
    body.dark .cp-stat-icon.icon-teal {
        background-color: rgba(13, 148, 136, 0.2) !important;
        color: #2dd4bf !important;
    }
    body[light-mode="dark"] .cp-stat-icon.icon-rose,
    body[data-layout-mode="dark"] .cp-stat-icon.icon-rose,
    html.dark .cp-stat-icon.icon-rose,
    body.dark .cp-stat-icon.icon-rose {
        background-color: rgba(225, 29, 72, 0.2) !important;
        color: #fb7185 !important;
    }

    .cp-stat-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    body[light-mode="dark"] .cp-stat-label,
    html.dark .cp-stat-label,
    body.dark .cp-stat-label {
        color: #94a3b8 !important;
    }
    .cp-stat-val {
        font-size: clamp(0.9rem, 1.2vw, 1.1rem);
        font-weight: 800;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .cp-stat-sub {
        font-size: 10px;
        color: #94a3b8;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    body[light-mode="dark"] .cp-stat-sub,
    html.dark .cp-stat-sub,
    body.dark .cp-stat-sub {
        color: #64748b !important;
    }

    /* ─── Modern Tabs (Active = Primary Green #15803d, Horizontal Scroll on Mobile) ─── */
    .cp-tab-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        overflow-x: auto;
        flex-wrap: nowrap;
        white-space: nowrap;
        padding-bottom: 6px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .cp-tab-nav::-webkit-scrollbar {
        display: none;
    }
    .cp-tab-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 38px;
        min-height: 38px;
        padding: 0 16px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 12px;
        border: 1.5px solid #cbd5e1;
        background-color: #ffffff;
        color: #475569;
        cursor: pointer;
        white-space: nowrap;
        flex-shrink: 0;
        transition: all 0.18s ease-in-out;
    }
    .cp-tab-btn:hover {
        border-color: #16a34a;
        color: #15803d;
        background-color: #f0fdf4;
    }
    .cp-tab-btn.active {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(21, 128, 61, 0.3) !important;
    }
    .cp-tab-btn .tab-count {
        font-size: 11px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 9999px;
        background-color: #e2e8f0;
        color: #334155;
        transition: all 0.18s ease-in-out;
    }
    .cp-tab-btn.active .tab-count {
        background-color: rgba(255, 255, 255, 0.25) !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] .cp-tab-btn,
    html.dark .cp-tab-btn,
    body.dark .cp-tab-btn {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }
    body[light-mode="dark"] .cp-tab-btn:hover,
    html.dark .cp-tab-btn:hover,
    body.dark .cp-tab-btn:hover {
        background-color: #0f2d1f !important;
        border-color: #16a34a !important;
        color: #4ade80 !important;
    }
    body[light-mode="dark"] .cp-tab-btn.active,
    html.dark .cp-tab-btn.active,
    body.dark .cp-tab-btn.active {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] .cp-tab-btn .tab-count,
    html.dark .cp-tab-btn .tab-count,
    body.dark .cp-tab-btn .tab-count {
        background-color: #334155;
        color: #cbd5e1;
    }

    .cp-tab-pane {
        display: none;
    }
    .cp-tab-pane.active {
        display: block;
    }

    /* ─── Table Design (Supplier Profile / Product List Page Matching) ─── */
    .cp-table thead th {
        background-color: #15803d !important;
        color: #ffffff !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        white-space: nowrap !important;
        padding: 10px 12px !important;
        border: none !important;
    }
    .cp-table tbody td {
        padding: 10px 12px !important;
        font-size: 13px !important;
        vertical-align: middle !important;
    }
    .cp-table tbody tr {
        transition: background-color 0.12s ease;
    }
    .cp-table tbody tr:hover {
        background-color: #f8fafc !important;
    }
    body[light-mode="dark"] .table-responsive,
    body[data-layout-mode="dark"] .table-responsive,
    html.dark .table-responsive,
    body.dark .table-responsive {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .cp-table,
    body[data-layout-mode="dark"] .cp-table,
    html.dark .cp-table,
    body.dark .cp-table {
        background-color: #0f172a !important;
        color: #f1f5f9 !important;
    }
    body[light-mode="dark"] .cp-table tbody tr:hover,
    html.dark .cp-table tbody tr:hover,
    body.dark .cp-table tbody tr:hover {
        background-color: #1e293b !important;
    }
    body[light-mode="dark"] .cp-table tbody td,
    body[data-layout-mode="dark"] .cp-table tbody td,
    html.dark .cp-table tbody td,
    body.dark .cp-table tbody td {
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }

    /* ─── Mobile Box Cards & Summary Box ─── */
    .cp-mobile-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 14px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        margin-bottom: 12px;
    }
    .cp-mobile-summary-box {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px 12px;
    }
    body[light-mode="dark"] .cp-mobile-card,
    body[data-layout-mode="dark"] .cp-mobile-card,
    html.dark .cp-mobile-card,
    body.dark .cp-mobile-card {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .cp-mobile-summary-box,
    body[data-layout-mode="dark"] .cp-mobile-summary-box,
    html.dark .cp-mobile-summary-box,
    body.dark .cp-mobile-summary-box {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }

    /* ─── Action Eye Button (Icon Only, Matching Supplier Profile) ─── */
    .cp-action-view-btn {
        width: 30px !important;
        height: 30px !important;
        min-width: 30px !important;
        min-height: 30px !important;
        max-width: 30px !important;
        max-height: 30px !important;
        border-radius: 8px !important;
        background-color: #f0fdf4 !important;
        border: 1px solid #bbf7d0 !important;
        color: #15803d !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-decoration: none !important;
        transition: all 0.15s ease-in-out !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
    }
    .cp-action-view-btn:hover {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
        transform: translateY(-1px);
    }
    body[light-mode="dark"] .cp-action-view-btn,
    html.dark .cp-action-view-btn,
    body.dark .cp-action-view-btn {
        background-color: #064e3b !important;
        border-color: #065f46 !important;
        color: #34d399 !important;
    }
    body[light-mode="dark"] .cp-action-view-btn:hover,
    html.dark .cp-action-view-btn:hover,
    body.dark .cp-action-view-btn:hover {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }

    /* ─── Badges ─── */
    .cp-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 2px 8px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }
    .cp-badge-success { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
    .cp-badge-warning { background: #fef9c3; color: #92400e; border: 1px solid #fde68a; }
    .cp-badge-danger  { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
    .cp-badge-teal    { background: #ccfbf1; color: #0d9488; border: 1px solid #99f6e4; }
    .cp-badge-blue    { background: #dbeafe; color: #1d4ed8; border: 1px solid #93c5fd; }
    .cp-badge-id      { background: #f0fdf4; color: #15803d; border: 1px solid #86efac; font-family: monospace; }

    body[light-mode="dark"] .cp-badge-success { background: #064e3b; color: #6ee7b7; border-color: #047857; }
    body[light-mode="dark"] .cp-badge-warning { background: #451a03; color: #fcd34d; border-color: #78350f; }
    body[light-mode="dark"] .cp-badge-danger  { background: #450a0a; color: #fca5a5; border-color: #7f1d1d; }
    body[light-mode="dark"] .cp-badge-teal    { background: #042f2e; color: #5eead4; border-color: #115e59; }
    body[light-mode="dark"] .cp-badge-blue    { background: #172554; color: #93c5fd; border-color: #1e40af; }
    body[light-mode="dark"] .cp-badge-id      { background: #064e3b; color: #6ee7b7; border-color: #047857; }

    /* ─── Modal Rules (Matching Pay Supplier Due Modal) ─── */
    #collectCustomerDueModal .modal-dialog {
        max-width: 620px;
        margin: 1.75rem auto;
        max-height: calc(100vh - 3.5rem);
        display: flex;
        align-items: center;
    }
    #collectCustomerDueModal .modal-content {
        border-radius: 16px !important;
        border: none !important;
        overflow: hidden !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        max-height: 90vh !important;
        display: flex !important;
        flex-direction: column !important;
        width: 100%;
    }
    #collectCustomerDueModal form {
        display: flex !important;
        flex-direction: column !important;
        flex: 1 1 auto !important;
        overflow: hidden !important;
        min-height: 0 !important;
        margin: 0 !important;
    }
    #collectCustomerDueModal .modal-body {
        overflow-y: auto !important;
        flex: 1 1 auto !important;
        max-height: calc(90vh - 130px) !important;
        scrollbar-width: thin;
        text-align: left !important;
    }
    #collectCustomerDueModal label:not(.btn),
    #collectCustomerDueModal .modal-body label:not(.btn) {
        text-align: left !important;
        display: block !important;
    }
    @media (max-width: 576px) {
        #collectCustomerDueModal .modal-dialog {
            margin: 0.5rem auto !important;
            max-width: calc(100% - 1rem) !important;
            max-height: calc(100vh - 1rem) !important;
            height: auto !important;
        }
        #collectCustomerDueModal .modal-content {
            max-height: 92vh !important;
        }
        #collectCustomerDueModal .modal-body {
            max-height: calc(92vh - 125px) !important;
            padding: 12px 14px !important;
            text-align: left !important;
        }
    }
    body[light-mode="dark"] #collectCustomerDueModal .modal-content,
    html.dark #collectCustomerDueModal .modal-content,
    body.dark #collectCustomerDueModal .modal-content {
        background-color: #0f172a !important;
        border: 1px solid #334155 !important;
        color: #f8fafc !important;
    }

    .modal-header-green {
        background-color: #15803d !important;
        color: #ffffff !important;
        border: none !important;
        padding: 12px 16px !important;
    }

    /* Red Circular Close Button (Matching Pay Supplier Due Modal) */
    .qv-close-btn {
        width: 32px !important;
        height: 32px !important;
        min-width: 32px !important;
        min-height: 32px !important;
        max-width: 32px !important;
        max-height: 32px !important;
        border-radius: 50% !important;
        background-color: #dc2626 !important;
        border: none !important;
        color: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 !important;
        cursor: pointer !important;
        transition: all 0.15s ease-in-out !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2) !important;
    }
    .qv-close-btn:hover {
        background-color: #b91c1c !important;
        transform: scale(1.05);
    }
    .qv-close-btn svg {
        width: 14px !important;
        height: 14px !important;
        stroke: #ffffff !important;
        display: block !important;
    }

    /* Modal Customer Info Box */
    .modal-customer-info-box {
        background-color: #f0fdf4;
        border: 1.5px solid #bbf7d0;
        border-radius: 14px;
        padding: 12px 14px;
    }
    body[light-mode="dark"] .modal-customer-info-box,
    body[data-layout-mode="dark"] .modal-customer-info-box,
    html.dark .modal-customer-info-box,
    body.dark .modal-customer-info-box {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    /* Customer Profile Header Left-Align on Desktop */
    .customer-profile-details {
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        text-align: left !important;
    }
    .customer-detail-item {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-start !important;
        text-align: left !important;
        gap: 8px !important;
        width: 100% !important;
    }
    @media (max-width: 767px) {
        .customer-profile-details {
            align-items: center !important;
            text-align: center !important;
        }
        .customer-detail-item {
            justify-content: center !important;
            text-align: center !important;
        }
    }

    /* Modal Due Breakdown Responsive Display */
    .modal-due-breakdown-desktop {
        display: block !important;
    }
    .modal-due-breakdown-mobile {
        display: none !important;
    }
    .target-type-text {
        display: inline !important;
    }
    @media (max-width: 576px) {
        .modal-due-breakdown-desktop {
            display: none !important;
        }
        .modal-due-breakdown-mobile {
            display: grid !important;
        }
        .target-type-text {
            display: none !important;
        }
    }

    /* Modal Due Breakdown Table (Desktop) & Box (Mobile) */
    .modal-due-breakdown-box {
        border-radius: 12px;
        overflow: hidden;
        border: 1.5px solid #bbf7d0;
        background-color: #ffffff;
    }
    .modal-due-breakdown-tbl th {
        background-color: #f1f5f9;
        color: #475569;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 8px 12px;
        border-bottom: 1px solid #e2e8f0;
    }
    .modal-due-breakdown-tbl td {
        padding: 10px 12px;
        font-weight: 600;
        color: #334155;
    }

    body[light-mode="dark"] .modal-due-breakdown-box,
    body[data-layout-mode="dark"] .modal-due-breakdown-box,
    html.dark .modal-due-breakdown-box,
    body.dark .modal-due-breakdown-box {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .modal-due-breakdown-tbl th,
    body[data-layout-mode="dark"] .modal-due-breakdown-tbl th,
    html.dark .modal-due-breakdown-tbl th,
    body.dark .modal-due-breakdown-tbl th {
        background-color: #1e293b !important;
        color: #94a3b8 !important;
        border-bottom: 1px solid #334155 !important;
    }
    body[light-mode="dark"] .modal-due-breakdown-tbl td,
    body[data-layout-mode="dark"] .modal-due-breakdown-tbl td,
    html.dark .modal-due-breakdown-tbl td,
    body.dark .modal-due-breakdown-tbl td {
        background-color: #0f172a !important;
        color: #f1f5f9 !important;
        border-color: #334155 !important;
    }

    /* Payment Target Button Types in Modal */
    .btn-target-type {
        height: 38px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        gap: 6px !important;
        font-size: 12.5px !important;
        font-weight: 600 !important;
        border: 1.5px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        color: #475569 !important;
        cursor: pointer !important;
        transition: all 0.15s ease-in-out !important;
        padding: 0 10px !important;
        width: 100% !important;
    }
    .btn-check:checked + .btn-target-type.type-all {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }
    .btn-check:checked + .btn-target-type.type-prev {
        background-color: #0284c7 !important;
        border-color: #0284c7 !important;
        color: #ffffff !important;
    }
    .btn-check:checked + .btn-target-type.type-inv {
        background-color: #d97706 !important;
        border-color: #d97706 !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] .btn-target-type,
    html.dark .btn-target-type,
    body.dark .btn-target-type {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }

    /* Modal Form Controls (38px height) */
    .cp-input {
        height: 38px !important;
        min-height: 38px !important;
        max-height: 38px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 12px !important;
        font-size: 13px !important;
        padding: 0 12px !important;
        width: 100% !important;
        background-color: #ffffff !important;
        color: #1e293b !important;
        outline: none !important;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .cp-input:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.2) !important;
    }
    body[light-mode="dark"] .cp-input,
    html.dark .cp-input,
    body.dark .cp-input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .cp-input:focus,
    html.dark .cp-input:focus,
    body.dark .cp-input:focus {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.2) !important;
    }

    /* Custom Payment Method Dropdown styling */
    .custom-modal-dropdown {
        position: relative;
        z-index: 9999;
    }
    .custom-modal-dropdown .select-menu {
        max-height: 220px;
        overflow-y: auto;
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        z-index: 999999 !important;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        box-shadow: 0 14px 35px rgba(0, 0, 0, 0.25) !important;
        padding: 4px;
    }
    .custom-modal-dropdown .select-option-item {
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        color: #334155;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.15s ease;
    }
    .custom-modal-dropdown .select-option-item:hover {
        background-color: #f0fdf4 !important;
        color: #15803d !important;
    }
    .custom-modal-dropdown .select-option-item.active {
        background-color: #dcfce7 !important;
        color: #15803d !important;
        font-weight: 700;
    }
    body[light-mode="dark"] .custom-modal-dropdown .select-menu,
    html.dark .custom-modal-dropdown .select-menu,
    body.dark .custom-modal-dropdown .select-menu {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .custom-modal-dropdown .select-option-item,
    html.dark .custom-modal-dropdown .select-option-item,
    body.dark .custom-modal-dropdown .select-option-item {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .custom-modal-dropdown .select-option-item:hover,
    html.dark .custom-modal-dropdown .select-option-item:hover,
    body.dark .custom-modal-dropdown .select-option-item:hover {
        background-color: #0f2d1f !important;
        color: #4ade80 !important;
    }
    body[light-mode="dark"] .custom-modal-dropdown .select-option-item.active,
    html.dark .custom-modal-dropdown .select-option-item.active,
    body.dark .custom-modal-dropdown .select-option-item.active {
        background-color: #14532d !important;
        color: #4ade80 !important;
    }

    /* Modal Footer: Sticky Bottom, Cancel Red / Submit Green */
    .modal-footer-sticky {
        position: sticky;
        bottom: 0;
        z-index: 20;
        padding: 10px 16px !important;
        border-top: 1px solid #e2e8f0;
        background-color: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }
    body[light-mode="dark"] .modal-footer-sticky,
    html.dark .modal-footer-sticky,
    body.dark .modal-footer-sticky {
        background-color: #0f172a !important;
        border-top-color: #334155 !important;
    }

    .cp-btn-cancel {
        height: 38px !important;
        min-height: 38px !important;
        padding: 0 16px !important;
        border-radius: 12px !important;
        background-color: #dc2626 !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 13px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        border: none !important;
        cursor: pointer !important;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25) !important;
        transition: all 0.15s ease-in-out !important;
        white-space: nowrap !important;
    }
    .cp-btn-cancel:hover {
        background-color: #b91c1c !important;
        color: #ffffff !important;
        transform: translateY(-1px);
    }

    /* Empty state */
    .cp-empty-state {
        padding: 40px 20px;
        text-align: center;
        color: #94a3b8;
        font-weight: 500;
        font-size: 13.5px;
    }
</style>

<!-- Hero Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-screen flex flex-col justify-between">
        <div class="data-table flex-grow">
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-8">

                    <!-- 1. Header Bar: Title Left, Collect Due Right -->
                    <div class="flex flex-wrap items-center justify-between gap-3 pb-3 mb-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Customer Profile</h1>
                        </div>

                        <!-- Right Control: Collect Due Only -->
                        <div class="flex items-center">
                            <button type="button" onclick="$('#collectCustomerDueModal').modal('show')" class="cp-btn-primary">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                                    <circle cx="12" cy="12" r="2"></circle>
                                    <path d="M6 12h.01M18 12h.01"></path>
                                </svg>
                                <span>Collect Due</span>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Customer Details & Due Box (Left: Avatar + Multi-Row Details, Right: Net Current Due Box) -->
                    <div class="customer-info-box unified-ui-border p-4 sm:p-5 mb-4 shadow-xs">
                        <div class="flex flex-col md:flex-row items-center md:items-center justify-between gap-5">

                            <!-- Left: Avatar (Vertical on Mobile, Horizontal on Desktop) + Details -->
                            <div class="flex flex-col md:flex-row items-center md:items-start gap-4 md:gap-5 flex-grow">
                                <div class="relative flex-shrink-0 pt-0.5">
                                    <img id="customerImg"
                                         src="{{ asset('backend/assets/img/demo-img.jpeg') }}"
                                         alt="Customer"
                                         class="customer-avatar-img">
                                </div>
                                <div class="customer-profile-details space-y-1.5">
                                    <!-- Row 1: Name + CUST ID Badge + Status Badge -->
                                    <div class="customer-detail-item flex-wrap gap-2">
                                        <h2 id="c_name" class="text-lg sm:text-xl font-bold text-slate-800 dark:text-white m-0 leading-tight">Loading...</h2>
                                        <span id="c_id_badge" class="cp-badge cp-badge-id font-mono">CUST-0000</span>
                                        <span id="c_status_badge" class="cp-badge cp-badge-success">Active</span>
                                    </div>

                                    <!-- Row 2: Phone Box -->
                                    <div class="customer-detail-item">
                                        <div id="c_phone_box" class="text-slate-700 dark:text-slate-300 text-xs sm:text-sm font-medium inline-flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-md bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400 inline-flex items-center justify-center text-xs flex-shrink-0">
                                                <i class="fa-solid fa-phone"></i>
                                            </span>
                                            <span id="c_phone">N/A</span>
                                        </div>
                                    </div>

                                    <!-- Row 3: Address Box -->
                                    <div class="customer-detail-item">
                                        <div id="c_address_box" class="text-slate-700 dark:text-slate-300 text-xs sm:text-sm font-medium inline-flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-md bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400 inline-flex items-center justify-center text-xs flex-shrink-0">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </span>
                                            <span id="c_address">N/A</span>
                                        </div>
                                    </div>

                                    <!-- Row 4: Opening Due Badge Box -->
                                    <div class="customer-detail-item">
                                        <div class="text-slate-700 dark:text-slate-300 text-xs sm:text-sm font-medium inline-flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-md bg-amber-50 text-amber-600 dark:bg-amber-950/40 dark:text-amber-400 inline-flex items-center justify-center text-xs flex-shrink-0">
                                                <i class="fa-solid fa-clock-rotate-left"></i>
                                            </span>
                                            <span>Opening Due: <strong id="c_opening_due" class="text-amber-600 dark:text-amber-400 font-bold">৳ 0.00</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Net Current Due Box (Right side of profile box, matching Supplier Profile) -->
                            <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-rose-50/80 to-slate-50 dark:from-rose-950/30 dark:to-slate-800/80 border border-rose-200/80 dark:border-rose-900/40 min-w-[240px] text-center md:text-right flex flex-col justify-center shadow-xs flex-shrink-0">
                                <span class="text-[10.5px] uppercase font-bold tracking-wider text-slate-500 dark:text-slate-400 block mb-1">Net Current Due</span>
                                <h3 id="s_due_header" class="text-2xl sm:text-3xl font-extrabold text-rose-600 dark:text-rose-400 m-0 leading-none">৳ 0.00</h3>
                                <span id="s_due_sub_header" class="text-[11px] text-slate-400 dark:text-slate-500 block mt-1.5">Prev: ৳0 | Inv: ৳0</span>
                            </div>

                        </div>
                    </div>

                    <!-- 3. KPI Stat Cards Row (100% Width Responsive Grid) -->
                    <div class="cp-stat-grid">
                        {{-- Invoices --}}
                        <div class="cp-stat-card unified-ui-border" style="border-left: 4px solid #0284c7 !important;">
                            <div class="min-w-0 overflow-hidden">
                                <div class="cp-stat-label">Invoices</div>
                                <div id="s_invoices" class="cp-stat-val text-sky-600 dark:text-sky-400">0</div>
                                <div class="cp-stat-sub">Total Orders</div>
                            </div>
                            <div class="cp-stat-icon icon-sky">
                                <i class="fa-solid fa-file-invoice"></i>
                            </div>
                        </div>

                        {{-- Total Billed --}}
                        <div class="cp-stat-card unified-ui-border" style="border-left: 4px solid #16a34a !important;">
                            <div class="min-w-0 overflow-hidden">
                                <div class="cp-stat-label">Total Billed</div>
                                <div id="s_billed" class="cp-stat-val text-emerald-600 dark:text-emerald-400">৳ 0.00</div>
                                <div class="cp-stat-sub">Grand total</div>
                            </div>
                            <div class="cp-stat-icon icon-emerald">
                                <i class="fa-solid fa-money-bill-wave"></i>
                            </div>
                        </div>

                        {{-- Total Paid --}}
                        <div class="cp-stat-card unified-ui-border" style="border-left: 4px solid #059669 !important;">
                            <div class="min-w-0 overflow-hidden">
                                <div class="cp-stat-label">Total Paid</div>
                                <div id="s_paid" class="cp-stat-val text-teal-600 dark:text-teal-400">৳ 0.00</div>
                                <div class="cp-stat-sub">Completed</div>
                            </div>
                            <div class="cp-stat-icon icon-teal">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                        </div>

                        {{-- Available Return Credit --}}
                        <div class="cp-stat-card unified-ui-border" style="border-left: 4px solid #0d9488 !important;">
                            <div class="min-w-0 overflow-hidden">
                                <div class="cp-stat-label">Return Credit</div>
                                <div id="s_returns" class="cp-stat-val text-teal-700 dark:text-teal-300">৳ 0.00</div>
                                <div id="s_return_sub" class="cp-stat-sub text-[10px]">Total: ৳0.00</div>
                            </div>
                            <div class="cp-stat-icon icon-teal">
                                <i class="fa-solid fa-arrow-rotate-left"></i>
                            </div>
                        </div>

                        {{-- Net Current Due --}}
                        <div class="cp-stat-card unified-ui-border" style="border-left: 4px solid #dc2626 !important;">
                            <div class="min-w-0 overflow-hidden">
                                <div class="cp-stat-label">Net Current Due</div>
                                <div id="s_due" class="cp-stat-val text-rose-600 dark:text-rose-400">৳ 0.00</div>
                                <div class="cp-stat-sub" id="s_due_sub">Outstanding</div>
                            </div>
                            <div class="cp-stat-icon icon-rose">
                                <i class="fa-solid fa-circle-exclamation"></i>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Modern Tab Navigation (Active = Primary Green #15803d, Horizontal Scroll on Mobile) -->
                    <div class="mb-3">
                        <div class="cp-tab-nav">
                            <button type="button" class="cp-tab-btn active" onclick="switchCustTab(this, 'tab-invoices')">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                                <span>Invoice History</span>
                                <span id="invoicesTabCount" class="tab-count">0</span>
                            </button>

                            <button type="button" class="cp-tab-btn" onclick="switchCustTab(this, 'tab-returns')">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="1 4 1 10 7 10"></polyline>
                                    <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                                </svg>
                                <span>Sales Returns / Credit</span>
                                <span id="returnsTabCount" class="tab-count">0</span>
                            </button>

                            <button type="button" class="cp-tab-btn" onclick="switchCustTab(this, 'tab-transactions')">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                                <span>Payment & Transaction History</span>
                                <span id="transactionsTabCount" class="tab-count">0</span>
                            </button>
                        </div>
                    </div>

                    <!-- 5. Tab Contents (Desktop Table & Mobile Card Box Views) -->
                    <div>
                        {{-- ── Tab 1: Invoice History ── --}}
                        <div id="tab-invoices" class="cp-tab-pane active">
                            <!-- Desktop Table -->
                            <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                                <table class="cp-table w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                            <th class="p-[10px] text-center w-[46px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                            <th class="p-[10px] text-center whitespace-nowrap">Invoice No</th>
                                            <th class="p-[10px] text-center whitespace-nowrap">Date</th>
                                            <th class="p-[10px] text-end whitespace-nowrap">Subtotal</th>
                                            <th class="p-[10px] text-end whitespace-nowrap">Paid</th>
                                            <th class="p-[10px] text-end whitespace-nowrap">Due</th>
                                            <th class="p-[10px] text-center whitespace-nowrap">Status</th>
                                            <th class="p-[10px] text-center w-[60px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="customerInvoiceTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                                        <tr><td colspan="8" class="cp-empty-state"><i class="fa-solid fa-receipt block text-3xl opacity-40 mb-2"></i>Loading invoice history...</td></tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile Card View -->
                            <div id="invoicesMobileCards" class="block md:hidden space-y-3">
                                <!-- Injected by JS -->
                            </div>
                        </div>

                        {{-- ── Tab 2: Sales Returns ── --}}
                        <div id="tab-returns" class="cp-tab-pane">
                            <!-- Desktop Table -->
                            <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                                <table class="cp-table w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                            <th class="p-[10px] text-center w-[46px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                            <th class="p-[10px] text-center whitespace-nowrap">Return Date</th>
                                            <th class="p-[10px] text-center whitespace-nowrap">Invoice Ref</th>
                                            <th class="p-[10px] text-start whitespace-nowrap">Returned Product</th>
                                            <th class="p-[10px] text-center whitespace-nowrap">Qty</th>
                                            <th class="p-[10px] text-end rounded-tr-2xl whitespace-nowrap">Refund / Credit Value</th>
                                        </tr>
                                    </thead>
                                    <tbody id="customerReturnsTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                                        <tr><td colspan="6" class="cp-empty-state"><i class="fa-solid fa-arrow-rotate-left block text-3xl opacity-40 mb-2"></i>Loading return records...</td></tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile Card View -->
                            <div id="returnsMobileCards" class="block md:hidden space-y-3">
                                <!-- Injected by JS -->
                            </div>
                        </div>

                        {{-- ── Tab 3: Transactions ── --}}
                        <div id="tab-transactions" class="cp-tab-pane">
                            <!-- Desktop Table -->
                            <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                                <table class="cp-table w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                            <th class="p-[10px] text-center w-[46px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                            <th class="p-[10px] text-center whitespace-nowrap">Date & Time</th>
                                            <th class="p-[10px] text-center whitespace-nowrap">Reference / Note</th>
                                            <th class="p-[10px] text-start whitespace-nowrap">Payment Method</th>
                                            <th class="p-[10px] text-end rounded-tr-2xl whitespace-nowrap">Paid Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="transactionTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                                        <tr><td colspan="5" class="cp-empty-state"><i class="fa-solid fa-hand-holding-dollar block text-3xl opacity-40 mb-2"></i>Loading payment history...</td></tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile Card View -->
                            <div id="transactionsMobileCards" class="block md:hidden space-y-3">
                                <!-- Injected by JS -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- 6. Sticky Bottom Copyright Section (Matching Supplier Profile Page) -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)]">
            <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>

    </div>
</div>
<!-- Hero Main Content End -->

{{-- ════════════════════════════════════════════════════════════════
     COLLECT CUSTOMER DUE MODAL (SAME DESIGN AS PAY SUPPLIER DUE MODAL)
════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="collectCustomerDueModal" tabindex="-1" aria-labelledby="collectCustomerDueModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered my-3">
        <div class="modal-content bg-white dark:bg-slate-900 border-0 rounded-2xl shadow-2xl overflow-hidden transition-colors flex flex-col">

            <!-- Modal Header: Green Background, White Text, Circular Red Close Button -->
            <div class="modal-header-green sticky top-0 z-20 px-4 py-3 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-white/20 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                            <circle cx="12" cy="12" r="2"></circle>
                            <path d="M6 12h.01M18 12h.01"></path>
                        </svg>
                    </div>
                    <h5 class="text-base font-bold text-white tracking-tight mb-0" id="collectCustomerDueModalLabel">Collect Customer Due</h5>
                </div>

                <!-- Red Circular Close Button (Matching Pay Supplier Due Modal) -->
                <button type="button" class="qv-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form id="collectCustomerDueForm" onsubmit="submitCustomerDueCollection(event)" class="flex flex-col flex-1 overflow-hidden m-0 p-0" style="display: flex; flex-direction: column; flex: 1 1 auto; overflow: hidden; min-height: 0;">
                <div class="modal-body p-3 sm:p-4 space-y-2 text-start" style="text-align: left !important; overflow-y: auto;">

                    <!-- Customer Quick Info Breakdown (Table on Desktop, Box Grid on Mobile) -->
                    <div class="modal-customer-info-box">
                        <!-- Top Row: Name + CUST ID -->
                        <div class="flex justify-between items-center mb-2.5">
                            <div class="flex items-center gap-2">
                                <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400 inline-flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-user-tie"></i>
                                </span>
                                <span class="font-bold text-slate-800 dark:text-slate-100 text-sm sm:text-base" id="modalCustomerName">Customer Name</span>
                            </div>
                            <span class="cp-badge cp-badge-id font-mono" id="modalCustomerId">ID</span>
                        </div>

                        <!-- Desktop Table Breakdown of Dues -->
                        <div class="modal-due-breakdown-box modal-due-breakdown-desktop mt-3 text-xs">
                            <table class="modal-due-breakdown-tbl w-full text-left border-collapse">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-3">Previous Due</th>
                                        <th class="py-2 px-3">Invoice Due</th>
                                        <th class="py-2 px-3 text-end text-rose-600 dark:text-rose-400">Total Target Due</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="font-semibold">
                                        <td class="py-2.5 px-3" id="modalPrevDueVal">৳ 0.00</td>
                                        <td class="py-2.5 px-3" id="modalInvDueVal">৳ 0.00</td>
                                        <td class="py-2.5 px-3 text-end font-extrabold text-rose-600 dark:text-rose-400 text-sm" id="modalTotalDue">৳ 0.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Box Breakdown of Dues -->
                        <div class="modal-due-breakdown-mobile grid-cols-3 gap-1.5 mt-2.5 text-center">
                            <div class="p-2 rounded-xl bg-slate-100/90 dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700">
                                <span class="text-[9.5px] uppercase font-bold text-slate-500 dark:text-slate-400 block">Prev Due</span>
                                <span class="text-xs font-bold text-slate-700 dark:text-slate-200 block mt-0.5" id="modalMobilePrevDueVal">৳ 0.00</span>
                            </div>
                            <div class="p-2 rounded-xl bg-slate-100/90 dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700">
                                <span class="text-[9.5px] uppercase font-bold text-slate-500 dark:text-slate-400 block">Inv Due</span>
                                <span class="text-xs font-bold text-slate-700 dark:text-slate-200 block mt-0.5" id="modalMobileInvDueVal">৳ 0.00</span>
                            </div>
                            <div class="p-2 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-900/40">
                                <span class="text-[9.5px] uppercase font-bold text-rose-600 dark:text-rose-400 block">Target Due</span>
                                <span class="text-xs font-extrabold text-rose-600 dark:text-rose-400 block mt-0.5" id="modalMobileTotalDue">৳ 0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Collection Target Selection -->
                    <div class="text-start">
                        <label class="block text-start text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5 mt-3" style="text-align: left !important;">
                            Collection Target <span class="text-rose-500">*</span>
                        </label>
                        <div class="btn-group w-100 flex items-center" role="group" id="collectionTypeGroup">
                            <input type="radio" class="btn-check" name="collection_type" id="ctype_all" value="all" checked onchange="onCollectionTypeChange()">
                            <label class="btn btn-target-type type-all flex-1 py-2 flex items-center justify-center text-center m-0" for="ctype_all" title="Both Dues">
                                <i class="fa-solid fa-layer-group"></i>
                                <span class="target-type-text ms-1.5">Both Dues</span>
                            </label>

                            <input type="radio" class="btn-check" name="collection_type" id="ctype_previous" value="previous" onchange="onCollectionTypeChange()">
                            <label class="btn btn-target-type type-prev flex-1 py-2 flex items-center justify-center text-center m-0" for="ctype_previous" title="Previous Due">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                <span class="target-type-text ms-1.5">Previous Due</span>
                            </label>

                            <input type="radio" class="btn-check" name="collection_type" id="ctype_invoice" value="invoice" onchange="onCollectionTypeChange()">
                            <label class="btn btn-target-type type-inv flex-1 py-2 flex items-center justify-center text-center m-0" for="ctype_invoice" title="Invoice Due">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                <span class="target-type-text ms-1.5">Invoice Due</span>
                            </label>
                        </div>
                    </div>

                    <!-- Collected Amount & Discount (Mobile: Single Column Full Width, Desktop: 2 Columns) -->
                    <div class="row g-3 text-start">
                        <!-- Col 1: Collected Amount -->
                        <div class="col-12 col-sm-6 text-start">
                            <label class="block text-start text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5 mt-2" for="modalPaidAmount" style="text-align: left !important;">
                                Collected Amount (৳) <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" step="0.01" class="cp-input font-bold text-emerald-700 dark:text-emerald-400 text-sm"
                                   id="modalPaidAmount" placeholder="0.00" required>
                        </div>

                        <!-- Col 2: Discount / Waiver -->
                        <div class="col-12 col-sm-6 text-start">
                            <label class="block text-start text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5 mt-2" for="modalDiscountAmount" style="text-align: left !important;">
                                Discount / Waiver (৳)
                            </label>
                            <input type="number" step="0.01" class="cp-input"
                                   id="modalDiscountAmount" value="0.00" placeholder="0.00">
                        </div>
                    </div>

                    <!-- Payment Method & Collection Date (Desktop: 2 Columns, Mobile: 1 Column) -->
                    <div class="row g-3 text-start">
                        <!-- Col 1: Payment Method Custom Dropdown -->
                        <div class="col-12 col-sm-6 text-start">
                            <label class="block text-start text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5 mt-2" style="text-align: left !important;">
                                Payment Method
                            </label>
                            <input type="hidden" id="modalPaymentMethod" value="Cash">
                            <div class="custom-modal-dropdown relative" id="customerPaymentMethodDropdown">
                                <div class="select-trigger unified-ui-border flex items-center justify-between px-3 h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-xs text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200 cursor-pointer hover:border-emerald-500 transition-all" onclick="toggleCustPaymentMethodDropdown()">
                                    <span class="selected-text flex items-center gap-2">
                                        <i class="fa-solid fa-money-bill text-emerald-600"></i> Cash
                                    </span>
                                    <svg class="w-3.5 h-3.5 text-slate-400 chevron-icon transition-transform duration-200 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </div>
                                <div class="select-menu shadow-2xl" style="display: none;">
                                    <div class="select-option-item active" data-value="Cash" onclick="selectCustPaymentMethodOption('Cash', '<i class=\'fa-solid fa-money-bill text-emerald-600\'></i> Cash')">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-money-bill text-emerald-600"></i> Cash</span>
                                    </div>
                                    <div class="select-option-item" data-value="bKash" onclick="selectCustPaymentMethodOption('bKash', '<i class=\'fa-solid fa-mobile-screen text-pink-600\'></i> bKash')">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-mobile-screen text-pink-600"></i> bKash</span>
                                    </div>
                                    <div class="select-option-item" data-value="Nagad" onclick="selectCustPaymentMethodOption('Nagad', '<i class=\'fa-solid fa-wallet text-orange-600\'></i> Nagad')">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-wallet text-orange-600"></i> Nagad</span>
                                    </div>
                                    <div class="select-option-item" data-value="Rocket" onclick="selectCustPaymentMethodOption('Rocket', '<i class=\'fa-solid fa-bolt text-purple-600\'></i> Rocket')">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-bolt text-purple-600"></i> Rocket</span>
                                    </div>
                                    <div class="select-option-item" data-value="Bank" onclick="selectCustPaymentMethodOption('Bank', '<i class=\'fa-solid fa-building-columns text-blue-600\'></i> Bank Transfer')">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-building-columns text-blue-600"></i> Bank Transfer</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Col 2: Collection Date (Flatpickr) -->
                        <div class="col-12 col-sm-6 text-start">
                            <label class="block text-start text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5 mt-2" for="modalCollectionDate" style="text-align: left !important;">
                                Collection Date
                            </label>
                            <input type="text" class="cp-input cursor-pointer"
                                   id="modalCollectionDate"
                                   placeholder="Select date">
                        </div>
                    </div>

                    <!-- Transaction ID / Note -->
                    <div class="text-start">
                        <label class="block text-start text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5 mt-3" for="modalTransactionId" style="text-align: left !important;">
                            Transaction ID / Note
                        </label>
                        <input type="text" class="cp-input" id="modalTransactionId"
                               placeholder="e.g. TrxID / Receipt No">
                    </div>

                </div>

                <!-- Modal Footer: Sticky Bottom, Cancel (Red) & Submit (Green) 38px -->
                <div class="modal-footer-sticky flex-shrink-0">
                    <button type="button" class="cp-btn-cancel" data-bs-dismiss="modal">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        <span>Cancel</span>
                    </button>
                    <button type="submit" id="btnSubmitCollection" class="cp-btn-primary">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Submit Collection</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    const customerId = "{{ $id }}";

    window.previousDueVal = 0;
    window.invoiceDueVal = 0;
    window.totalDueVal = 0;

    // ── Flatpickr on Modal Open & DOM (Day-Month-Year) ──
    let customerDuePicker = null;
    function initCustomerDueDatePicker() {
        const dateInput = document.getElementById('modalCollectionDate');
        if (dateInput && typeof flatpickr !== "undefined") {
            if (customerDuePicker) {
                try { customerDuePicker.destroy(); } catch (e) {}
            }
            customerDuePicker = flatpickr(dateInput, {
                dateFormat: 'd-m-Y',
                defaultDate: 'today',
                allowInput: true,
                disableMobile: true,
                static: false,
                appendTo: document.body
            });
        }
    }

    // ── Tab Switcher Function ──
    function switchCustTab(btn, tabId) {
        document.querySelectorAll('.cp-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.cp-tab-pane').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
        const target = document.getElementById(tabId);
        if (target) {
            target.classList.add('active');
        }
    }

    const custModalElement = document.getElementById('collectCustomerDueModal');
    if (custModalElement) {
        custModalElement.addEventListener('shown.bs.modal', function () {
            initCustomerDueDatePicker();
        });
    }

    // ── Custom Payment Method Dropdown Handlers (Dynamic Dropup / Dropdown) ──
    function toggleCustPaymentMethodDropdown() {
        const dropdown = document.getElementById('customerPaymentMethodDropdown');
        if (!dropdown) return;
        const trigger = dropdown.querySelector('.select-trigger');
        const menu = dropdown.querySelector('.select-menu');
        const isOpen = menu.style.display === 'block';

        if (isOpen) {
            menu.style.display = 'none';
        } else {
            const triggerRect = trigger.getBoundingClientRect();
            const modalBody = dropdown.closest('.modal-body');

            // Calculate available space below
            let spaceBelow = window.innerHeight - triggerRect.bottom;
            if (modalBody) {
                const modalBodyRect = modalBody.getBoundingClientRect();
                spaceBelow = modalBodyRect.bottom - triggerRect.bottom;
            }

            // If space below is less than 210px (menu height + gap), open upwards (top-aligned dropup)
            if (spaceBelow < 210) {
                menu.style.top = 'auto';
                menu.style.bottom = 'calc(100% + 6px)';
                menu.style.boxShadow = '0 -10px 25px rgba(0, 0, 0, 0.18)';
            } else {
                menu.style.top = 'calc(100% + 6px)';
                menu.style.bottom = 'auto';
                menu.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.18)';
            }
            menu.style.display = 'block';
        }
    }

    function selectCustPaymentMethodOption(value, html) {
        document.getElementById('modalPaymentMethod').value = value;
        const dropdown = document.getElementById('customerPaymentMethodDropdown');
        if (dropdown) {
            dropdown.querySelector('.selected-text').innerHTML = html;
            dropdown.querySelectorAll('.select-option-item').forEach(el => {
                if (el.getAttribute('data-value') === value) {
                    el.classList.add('active');
                } else {
                    el.classList.remove('active');
                }
            });
            dropdown.querySelector('.select-menu').style.display = 'none';
        }
    }

    // Close custom dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('customerPaymentMethodDropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            const menu = dropdown.querySelector('.select-menu');
            if (menu) menu.style.display = 'none';
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
        initCustomerDueDatePicker();
        fetchCustomerProfile();
    });

    function onCollectionTypeChange() {
        const selectedType = document.querySelector('input[name="collection_type"]:checked')?.value || 'all';
        const inputAmount = document.getElementById('modalPaidAmount');
        const modalTotalDue = document.getElementById('modalTotalDue');
        const modalMobileTotalDue = document.getElementById('modalMobileTotalDue');
        const prevDueVal = document.getElementById('modalPrevDueVal');
        const modalMobilePrevDue = document.getElementById('modalMobilePrevDueVal');
        const invDueVal = document.getElementById('modalInvDueVal');
        const modalMobileInvDue = document.getElementById('modalMobileInvDueVal');

        const prevVal = window.previousDueVal || 0;
        const invVal = window.invoiceDueVal || 0;

        if (prevDueVal) prevDueVal.innerText = `৳ ${prevVal.toFixed(2)}`;
        if (modalMobilePrevDue) modalMobilePrevDue.innerText = `৳ ${prevVal.toFixed(2)}`;
        if (invDueVal) invDueVal.innerText = `৳ ${invVal.toFixed(2)}`;
        if (modalMobileInvDue) modalMobileInvDue.innerText = `৳ ${invVal.toFixed(2)}`;

        let targetMax = 0;

        if (selectedType === 'previous') {
            targetMax = prevVal;
        } else if (selectedType === 'invoice') {
            targetMax = invVal;
        } else {
            targetMax = window.totalDueVal;
        }

        if (modalTotalDue) modalTotalDue.innerText = `৳ ${targetMax.toFixed(2)}`;
        if (modalMobileTotalDue) modalMobileTotalDue.innerText = `৳ ${targetMax.toFixed(2)}`;
        if (inputAmount) inputAmount.value = targetMax > 0 ? targetMax.toFixed(2) : '';
    }

    async function fetchCustomerProfile() {
        try {
            if (typeof showLoader === "function") showLoader();

            let res = await axios.get(`/api/customer-profile-data/${customerId}`, HeaderToken());

            if (typeof hideLoader === "function") hideLoader();

            if (res.data.status === 'success') {
                let customer = res.data.customer;
                let summary = res.data.summary;
                let invoices = res.data.invoices || [];
                let returns = res.data.returns || [];
                let transactions = res.data.transactions || [];

                // Track due breakdown
                window.previousDueVal = parseFloat(customer.previous_due_amount || 0);
                window.invoiceDueVal = invoices.reduce((sum, inv) => sum + parseFloat(inv.due_amount || 0), 0);
                window.totalDueVal = Math.max(0, window.previousDueVal + window.invoiceDueVal - parseFloat(summary.available_credit || 0));

                // Header & Info Box
                document.getElementById('c_name').innerText = customer.name || customer.customer_name || 'N/A';
                document.getElementById('c_id_badge').innerText = customer.customer_id || 'CUST-0000';
                document.getElementById('c_phone').innerText = customer.mobile || customer.phone || 'N/A';
                document.getElementById('c_address').innerText = customer.address || 'N/A';

                const openingDue = parseFloat(summary.opening_due || customer.previous_due_amount || 0);
                const invDue = parseFloat(summary.invoice_due || window.invoiceDueVal || 0);
                document.getElementById('c_opening_due').innerText = `৳ ${openingDue.toFixed(2)}`;

                // Net Current Due Box (Top Right Card)
                const totalDueFormatted = `৳ ${parseFloat(summary.total_due).toFixed(2)}`;
                document.getElementById('s_due_header').innerText = totalDueFormatted;
                document.getElementById('s_due_sub_header').innerText = `Prev: ৳${openingDue.toFixed(0)} | Inv: ৳${invDue.toFixed(0)}`;

                // Set Summary KPI Stat Cards
                document.getElementById('s_invoices').innerText = summary.total_invoices;
                document.getElementById('s_billed').innerText = `৳ ${parseFloat(summary.total_billed).toFixed(2)}`;
                document.getElementById('s_paid').innerText = `৳ ${parseFloat(summary.total_paid).toFixed(2)}`;
                document.getElementById('s_returns').innerText = `৳ ${parseFloat(summary.available_credit || 0).toFixed(2)}`;
                document.getElementById('s_return_sub').innerText = `Total: ৳${parseFloat(summary.total_returns || 0).toFixed(2)} | Adj: ৳${parseFloat(summary.total_returns_adjusted || 0).toFixed(2)}`;
                document.getElementById('s_due').innerText = totalDueFormatted;
                document.getElementById('s_due_sub').innerText = `Prev: ৳${openingDue.toFixed(0)} | Inv: ৳${invDue.toFixed(0)}`;

                // Tab Counts
                document.getElementById('invoicesTabCount').innerText = invoices.length;
                document.getElementById('returnsTabCount').innerText = returns.length;
                document.getElementById('transactionsTabCount').innerText = transactions.length;

                // Pre-fill Modal Info
                document.getElementById('modalCustomerName').innerText = customer.name || customer.customer_name || 'N/A';
                document.getElementById('modalCustomerId').innerText = customer.customer_id || 'CUST-0000';

                onCollectionTypeChange();

                // ── Invoices Desktop Table & Mobile Cards ──
                let invoiceTableList = $("#customerInvoiceTableBody");
                let invoicesCards = $("#invoicesMobileCards");
                invoiceTableList.empty();
                invoicesCards.empty();

                if (invoices.length === 0) {
                    invoiceTableList.html(`<tr><td colspan="8" class="cp-empty-state"><i class="fa-solid fa-receipt block text-3xl opacity-40 mb-2"></i>No invoices found for this customer</td></tr>`);
                    invoicesCards.html('<div class="p-6 text-center text-slate-400 cp-mobile-card"><i class="fa-solid fa-receipt block text-3xl opacity-40 mb-2"></i>No invoices found</div>');
                } else {
                    invoices.forEach(function(item, index) {
                        const subTotal = item.sub_total ? parseFloat(item.sub_total).toFixed(2) : '0.00';
                        const due = item.due_amount ? parseFloat(item.due_amount).toFixed(2) : '0.00';
                        const paid = parseFloat(item.paid_amount || 0);
                        const dueRaw = parseFloat(item.due_amount || 0);

                        let paidDisplayHtml = `৳ ${paid.toFixed(2)}`;
                        if (item.return_adjustment_amount && parseFloat(item.return_adjustment_amount) > 0) {
                            paidDisplayHtml += `<br><span class="cp-badge cp-badge-teal text-[10px] mt-0.5">+৳${parseFloat(item.return_adjustment_amount).toFixed(2)} Adj</span>`;
                        }

                        let statusBadgeClass = '';
                        let paymentStatus = '';
                        if (dueRaw === 0 && (paid > 0 || (item.return_adjustment_amount && parseFloat(item.return_adjustment_amount) > 0))) {
                            statusBadgeClass = 'cp-badge-success';
                            paymentStatus = 'Fully Paid';
                        } else if (dueRaw > 0 && paid > 0) {
                            statusBadgeClass = 'cp-badge-warning';
                            paymentStatus = 'Partial Paid';
                        } else if (dueRaw > 0 && paid === 0) {
                            statusBadgeClass = 'cp-badge-danger';
                            paymentStatus = 'Unpaid';
                        } else {
                            statusBadgeClass = 'cp-badge-blue';
                            paymentStatus = 'Unknown';
                        }

                        let formattedDate = new Intl.DateTimeFormat('en-US', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(item.invoice_date || item.created_at));

                        // Desktop Row
                        let row = `
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/60 transition-colors">
                                <td class="text-center font-bold text-slate-500">${index + 1}</td>
                                <td class="text-center"><a href="/invoice/${item.id}" class="sp-badge cp-badge-id font-mono">${item.order_no}</a></td>
                                <td class="text-center text-slate-600 dark:text-slate-300 whitespace-nowrap">${formattedDate}</td>
                                <td class="text-end font-bold text-slate-800 dark:text-white">৳ ${subTotal}</td>
                                <td class="text-end font-bold text-emerald-700 dark:text-emerald-400">${paidDisplayHtml}</td>
                                <td class="text-end font-bold ${dueRaw > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-400'}">৳ ${due}</td>
                                <td class="text-center"><span class="cp-badge ${statusBadgeClass}">${paymentStatus}</span></td>
                                <td class="text-center">
                                    <a href="/invoice/${item.id}" class="cp-action-view-btn" title="View Invoice">
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        `;
                        invoiceTableList.append(row);

                        // Mobile Box Card
                        invoicesCards.append(`
                            <div class="cp-mobile-card">
                                <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100 dark:border-slate-800">
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[11px] font-bold">#${index + 1}</span>
                                        <span class="cp-badge cp-badge-id font-mono">${item.order_no}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="cp-badge ${statusBadgeClass}">${paymentStatus}</span>
                                        <a href="/invoice/${item.id}" class="cp-action-view-btn" title="View Invoice">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-xs mb-2">
                                    <div>
                                        <span class="text-slate-400 block text-[11px]">Date:</span>
                                        <span class="font-semibold text-slate-700 dark:text-slate-200">${formattedDate}</span>
                                    </div>
                                </div>
                                <div class="cp-mobile-summary-box flex items-center justify-between text-xs">
                                    <div>
                                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Total</span>
                                        <span class="font-extrabold text-slate-800 dark:text-white">৳ ${subTotal}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px] uppercase font-bold text-center">Paid</span>
                                        <span class="font-extrabold text-emerald-600 dark:text-emerald-400">${paidDisplayHtml}</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Due</span>
                                        <span class="font-extrabold ${dueRaw > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-400'}">৳ ${due}</span>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                }

                // ── Sales Returns Desktop Table & Mobile Cards ──
                let returnsTableList = $("#customerReturnsTableBody");
                let returnsCards = $("#returnsMobileCards");
                returnsTableList.empty();
                returnsCards.empty();

                if (returns.length === 0) {
                    returnsTableList.html(`<tr><td colspan="6" class="cp-empty-state"><i class="fa-solid fa-arrow-rotate-left block text-3xl opacity-40 mb-2"></i>No sales return records found for this customer</td></tr>`);
                    returnsCards.html('<div class="p-6 text-center text-slate-400 cp-mobile-card"><i class="fa-solid fa-arrow-rotate-left block text-3xl opacity-40 mb-2"></i>No return records found</div>');
                } else {
                    returns.forEach(function(rItem, rIndex) {
                        // Desktop Row
                        let row = `
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/60 transition-colors">
                                <td class="text-center font-bold text-slate-500">${rIndex + 1}</td>
                                <td class="text-center text-slate-600 dark:text-slate-300 whitespace-nowrap">${rItem.created_at_formatted || rItem.date}</td>
                                <td class="text-center"><span class="cp-badge cp-badge-teal font-mono">${rItem.order_no}</span></td>
                                <td class="text-start font-bold text-slate-800 dark:text-white">${rItem.product_name}</td>
                                <td class="text-center"><span class="cp-badge cp-badge-blue">${rItem.quantity} pcs</span></td>
                                <td class="text-end font-bold text-teal-700 dark:text-teal-300">৳ ${parseFloat(rItem.amount).toFixed(2)}</td>
                            </tr>
                        `;
                        returnsTableList.append(row);

                        // Mobile Box Card
                        returnsCards.append(`
                            <div class="cp-mobile-card">
                                <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100 dark:border-slate-800">
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[11px] font-bold">#${rIndex + 1}</span>
                                        <span class="cp-badge cp-badge-teal font-mono">${rItem.order_no}</span>
                                    </div>
                                    <span class="cp-badge cp-badge-blue">${rItem.quantity} pcs</span>
                                </div>
                                <div class="mb-2">
                                    <h4 class="font-bold text-slate-800 dark:text-white text-sm m-0">${rItem.product_name}</h4>
                                    <span class="text-slate-400 text-xs">${rItem.created_at_formatted || rItem.date}</span>
                                </div>
                                <div class="cp-mobile-summary-box flex items-center justify-between text-xs">
                                    <span class="text-teal-800 dark:text-teal-300 font-semibold">Credit Amount</span>
                                    <span class="font-extrabold text-teal-700 dark:text-teal-300 text-sm">৳ ${parseFloat(rItem.amount).toFixed(2)}</span>
                                </div>
                            </div>
                        `);
                    });
                }

                // ── Transactions Desktop Table & Mobile Cards ──
                let trxTableList = $("#transactionTableBody");
                let transactionsCards = $("#transactionsMobileCards");
                trxTableList.empty();
                transactionsCards.empty();

                if (!transactions || transactions.length === 0) {
                    trxTableList.html(`<tr><td colspan="5" class="cp-empty-state"><i class="fa-solid fa-hand-holding-dollar block text-3xl opacity-40 mb-2"></i>No payment history found for this customer</td></tr>`);
                    transactionsCards.html('<div class="p-6 text-center text-slate-400 cp-mobile-card"><i class="fa-solid fa-hand-holding-dollar block text-3xl opacity-40 mb-2"></i>No transactions found</div>');
                } else {
                    transactions.forEach(function(item, index) {
                        const amount = item.paid_amount ? parseFloat(item.paid_amount).toFixed(2) : '0.00';
                        const payMethod = item.payment_method || 'Cash';

                        let formattedDate = new Intl.DateTimeFormat('en-US', {
                            day: '2-digit', month: 'short', year: 'numeric',
                            hour: 'numeric', minute: '2-digit', hour12: true
                        }).format(new Date(item.created_at));

                        // Desktop Row
                        let row = `
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/60 transition-colors">
                                <td class="text-center font-bold text-slate-500">${index + 1}</td>
                                <td class="text-center text-slate-600 dark:text-slate-300 whitespace-nowrap">${formattedDate}</td>
                                <td class="text-center"><span class="cp-badge cp-badge-blue font-mono">${item.reference_no || item.order_no || 'Due Collection'}</span></td>
                                <td class="text-start text-slate-700 dark:text-slate-300"><i class="fa-solid fa-wallet me-1.5 text-slate-400"></i>${payMethod}</td>
                                <td class="text-end font-bold text-emerald-700 dark:text-emerald-400">৳ ${amount}</td>
                            </tr>
                        `;
                        trxTableList.append(row);

                        // Mobile Box Card
                        transactionsCards.append(`
                            <div class="cp-mobile-card">
                                <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100 dark:border-slate-800">
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[11px] font-bold">#${index + 1}</span>
                                        <span class="cp-badge cp-badge-blue font-mono">${item.reference_no || item.order_no || 'Due Collection'}</span>
                                    </div>
                                    <span class="cp-badge cp-badge-success">Success</span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-xs mb-2">
                                    <div>
                                        <span class="text-slate-400 block text-[11px]">Date:</span>
                                        <span class="font-semibold text-slate-700 dark:text-slate-200">${formattedDate}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[11px]">Method:</span>
                                        <span class="font-medium text-slate-700 dark:text-slate-200"><i class="fa-solid fa-wallet me-1 text-slate-400"></i>${payMethod}</span>
                                    </div>
                                </div>
                                <div class="cp-mobile-summary-box flex items-center justify-between text-xs">
                                    <div>
                                        <span class="text-emerald-800 dark:text-emerald-300 font-semibold">Paid Amount</span>
                                    </div>
                                    <div>
                                        <strong class="text-emerald-700 dark:text-emerald-400 text-sm font-extrabold">৳ ${amount}</strong>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                }

            } else {
                alert("Error: " + res.data.message);
            }

        } catch (e) {
            if (typeof hideLoader === "function") hideLoader();
            console.error(e);
            alert("Something went wrong while fetching customer profile.");
        }
    }

    async function submitCustomerDueCollection(event) {
        event.preventDefault();

        const collectionType = document.querySelector('input[name="collection_type"]:checked')?.value || 'all';
        const paidAmount = parseFloat(document.getElementById('modalPaidAmount').value) || 0;
        const discountAmount = parseFloat(document.getElementById('modalDiscountAmount').value) || 0;
        const paymentMethod = document.getElementById('modalPaymentMethod').value;
        const collectionDate = document.getElementById('modalCollectionDate').value;
        const transactionId = document.getElementById('modalTransactionId').value;
        const btn = document.getElementById('btnSubmitCollection');

        if (paidAmount <= 0) {
            alert("Please enter a valid collected amount!");
            return;
        }

        try {
            if (typeof showLoader === "function") showLoader();
            btn.disabled = true;

            const payload = {
                id: customerId,
                customer_id: customerId,
                collection_type: collectionType,
                paid_amount: paidAmount,
                discount_amount: discountAmount,
                payment_method: paymentMethod,
                collection_date: collectionDate,
                due_collection_date: collectionDate,
                transaction_id: transactionId
            };

            let res = await axios.post('/api/customer-due-collection', payload, HeaderToken());

            if (typeof hideLoader === "function") hideLoader();
            btn.disabled = false;

            if (res.data.status === 'success') {
                if (typeof successToast === 'function') {
                    successToast(res.data.message || "Customer due collection recorded successfully!");
                } else {
                    alert(res.data.message || "Customer due collection recorded successfully!");
                }

                const modalEl = document.getElementById('collectCustomerDueModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                fetchCustomerProfile();
            } else {
                alert(res.data.message || "Failed to record due collection.");
            }
        } catch (e) {
            if (typeof hideLoader === "function") hideLoader();
            btn.disabled = false;
            console.error(e);
            alert("Error: " + (e.response?.data?.message || e.message || "Failed to submit due collection."));
        }
    }
</script>
@endsection