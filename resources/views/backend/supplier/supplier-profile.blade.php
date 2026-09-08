<!-- Flatpickr Styles & Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

{{-- ═════════════════════════════════════════════════════════════════
     SUPPLIER PROFILE PAGE (MATCHING PRODUCT LIST THEME & RULES)
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
    .sp-btn-primary {
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
    .sp-btn-primary:hover {
        background-color: #166534 !important;
        color: #ffffff !important;
        transform: translateY(-1px);
    }
    .sp-btn-primary:active {
        transform: translateY(0);
    }

    /* ─── Supplier Info Box ─── */
    .supplier-info-box {
        background: #ffffff;
        border-radius: 16px;
        transition: all 0.2s ease;
    }
    body[light-mode="dark"] .supplier-info-box,
    body[data-layout-mode="dark"] .supplier-info-box,
    html.dark .supplier-info-box,
    body.dark .supplier-info-box {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    .supplier-avatar-img {
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
    body[light-mode="dark"] .supplier-avatar-img,
    html.dark .supplier-avatar-img,
    body.dark .supplier-avatar-img {
        border-color: #16a34a !important;
    }

    /* ─── Stat Cards Grid (Responsive, Fits 100% without overflow) ─── */
    .sp-stat-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
        width: 100%;
        max-width: 100%;
        margin-bottom: 16px;
        box-sizing: border-box;
    }
    @media (min-width: 768px) and (max-width: 1199px) {
        .sp-stat-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }
    }
    @media (min-width: 1200px) {
        .sp-stat-grid {
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 12px;
        }
    }
    .sp-stat-card {
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
    .sp-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
    }
    body[light-mode="dark"] .sp-stat-card,
    body[data-layout-mode="dark"] .sp-stat-card,
    html.dark .sp-stat-card,
    body.dark .sp-stat-card {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }

    .sp-stat-icon {
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
    .sp-stat-icon.icon-sky {
        background-color: #f0f9ff;
        color: #0284c7;
    }
    .sp-stat-icon.icon-emerald {
        background-color: #ecfdf5;
        color: #059669;
    }
    .sp-stat-icon.icon-teal {
        background-color: #f0fdfa;
        color: #0d9488;
    }
    .sp-stat-icon.icon-rose {
        background-color: #fff1f2;
        color: #e11d48;
    }

    body[light-mode="dark"] .sp-stat-icon.icon-sky,
    body[data-layout-mode="dark"] .sp-stat-icon.icon-sky,
    html.dark .sp-stat-icon.icon-sky,
    body.dark .sp-stat-icon.icon-sky {
        background-color: rgba(2, 132, 199, 0.2) !important;
        color: #38bdf8 !important;
    }
    body[light-mode="dark"] .sp-stat-icon.icon-emerald,
    body[data-layout-mode="dark"] .sp-stat-icon.icon-emerald,
    html.dark .sp-stat-icon.icon-emerald,
    body.dark .sp-stat-icon.icon-emerald {
        background-color: rgba(5, 150, 105, 0.2) !important;
        color: #34d399 !important;
    }
    body[light-mode="dark"] .sp-stat-icon.icon-teal,
    body[data-layout-mode="dark"] .sp-stat-icon.icon-teal,
    html.dark .sp-stat-icon.icon-teal,
    body.dark .sp-stat-icon.icon-teal {
        background-color: rgba(13, 148, 136, 0.2) !important;
        color: #2dd4bf !important;
    }
    body[light-mode="dark"] .sp-stat-icon.icon-rose,
    body[data-layout-mode="dark"] .sp-stat-icon.icon-rose,
    html.dark .sp-stat-icon.icon-rose,
    body.dark .sp-stat-icon.icon-rose {
        background-color: rgba(225, 29, 72, 0.2) !important;
        color: #fb7185 !important;
    }

    .sp-stat-label {
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
    body[light-mode="dark"] .sp-stat-label,
    html.dark .sp-stat-label,
    body.dark .sp-stat-label {
        color: #94a3b8 !important;
    }
    .sp-stat-val {
        font-size: clamp(0.9rem, 1.2vw, 1.1rem);
        font-weight: 800;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .sp-stat-sub {
        font-size: 10px;
        color: #94a3b8;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    body[light-mode="dark"] .sp-stat-sub,
    html.dark .sp-stat-sub,
    body.dark .sp-stat-sub {
        color: #64748b !important;
    }

    /* ─── Modern Tabs (Active = Primary Green #15803d, Horizontal Scroll on Mobile) ─── */
    .sp-tab-nav {
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
    .sp-tab-nav::-webkit-scrollbar {
        display: none;
    }
    .sp-tab-btn {
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
    .sp-tab-btn:hover {
        border-color: #16a34a;
        color: #15803d;
        background-color: #f0fdf4;
    }
    .sp-tab-btn.active {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(21, 128, 61, 0.3) !important;
    }
    .sp-tab-btn .tab-count {
        font-size: 11px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 9999px;
        background-color: #e2e8f0;
        color: #334155;
        transition: all 0.18s ease-in-out;
    }
    .sp-tab-btn.active .tab-count {
        background-color: rgba(255, 255, 255, 0.25) !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] .sp-tab-btn,
    html.dark .sp-tab-btn,
    body.dark .sp-tab-btn {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }
    body[light-mode="dark"] .sp-tab-btn:hover,
    html.dark .sp-tab-btn:hover,
    body.dark .sp-tab-btn:hover {
        background-color: #0f2d1f !important;
        border-color: #16a34a !important;
        color: #4ade80 !important;
    }
    body[light-mode="dark"] .sp-tab-btn.active,
    html.dark .sp-tab-btn.active,
    body.dark .sp-tab-btn.active {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] .sp-tab-btn .tab-count,
    html.dark .sp-tab-btn .tab-count,
    body.dark .sp-tab-btn .tab-count {
        background-color: #334155;
        color: #cbd5e1;
    }

    .sp-tab-pane {
        display: none;
    }
    .sp-tab-pane.active {
        display: block;
    }

    /* ─── Table Design (Product List Page Matching) ─── */
    .sp-table thead th {
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
    .sp-table tbody td {
        padding: 10px 12px !important;
        font-size: 13px !important;
        vertical-align: middle !important;
    }
    .sp-table tbody tr {
        transition: background-color 0.12s ease;
    }
    .sp-table tbody tr:hover {
        background-color: #f8fafc !important;
    }
    body[light-mode="dark"] .table-responsive,
    body[data-layout-mode="dark"] .table-responsive,
    html.dark .table-responsive,
    body.dark .table-responsive {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .sp-table,
    body[data-layout-mode="dark"] .sp-table,
    html.dark .sp-table,
    body.dark .sp-table {
        background-color: #0f172a !important;
        color: #f1f5f9 !important;
    }
    body[light-mode="dark"] .sp-table tbody tr:hover,
    html.dark .sp-table tbody tr:hover,
    body.dark .sp-table tbody tr:hover {
        background-color: #1e293b !important;
    }
    body[light-mode="dark"] .sp-table tbody td,
    body[data-layout-mode="dark"] .sp-table tbody td,
    html.dark .sp-table tbody td,
    body.dark .sp-table tbody td {
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }

    /* ─── Mobile Box Cards & Summary Box ─── */
    .sp-mobile-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 14px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        margin-bottom: 12px;
    }
    .sp-mobile-summary-box {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px 12px;
    }
    body[light-mode="dark"] .sp-mobile-card,
    body[data-layout-mode="dark"] .sp-mobile-card,
    html.dark .sp-mobile-card,
    body.dark .sp-mobile-card {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .sp-mobile-summary-box,
    body[data-layout-mode="dark"] .sp-mobile-summary-box,
    html.dark .sp-mobile-summary-box,
    body.dark .sp-mobile-summary-box {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }

    /* ─── Action Eye Button (Icon Only, No Text) ─── */
    .sp-action-view-btn {
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
    .sp-action-view-btn:hover {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
        transform: translateY(-1px);
    }
    body[light-mode="dark"] .sp-action-view-btn,
    html.dark .sp-action-view-btn,
    body.dark .sp-action-view-btn {
        background-color: #064e3b !important;
        border-color: #065f46 !important;
        color: #34d399 !important;
    }
    body[light-mode="dark"] .sp-action-view-btn:hover,
    html.dark .sp-action-view-btn:hover,
    body.dark .sp-action-view-btn:hover {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }

    /* ─── Badges ─── */
    .sp-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 2px 8px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }
    .sp-badge-success { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
    .sp-badge-warning { background: #fef9c3; color: #92400e; border: 1px solid #fde68a; }
    .sp-badge-danger  { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
    .sp-badge-teal    { background: #ccfbf1; color: #0d9488; border: 1px solid #99f6e4; }
    .sp-badge-blue    { background: #dbeafe; color: #1d4ed8; border: 1px solid #93c5fd; }
    .sp-badge-id      { background: #f0fdf4; color: #15803d; border: 1px solid #86efac; font-family: monospace; }

    body[light-mode="dark"] .sp-badge-success { background: #064e3b; color: #6ee7b7; border-color: #047857; }
    body[light-mode="dark"] .sp-badge-warning { background: #451a03; color: #fcd34d; border-color: #78350f; }
    body[light-mode="dark"] .sp-badge-danger  { background: #450a0a; color: #fca5a5; border-color: #7f1d1d; }
    body[light-mode="dark"] .sp-badge-teal    { background: #042f2e; color: #5eead4; border-color: #115e59; }
    body[light-mode="dark"] .sp-badge-blue    { background: #172554; color: #93c5fd; border-color: #1e40af; }
    body[light-mode="dark"] .sp-badge-id      { background: #064e3b; color: #6ee7b7; border-color: #047857; }

    /* ─── Modal Rules (Matching Product List Page) ─── */
    #paySupplierDueModal .modal-dialog {
        max-width: 620px;
        margin: 1.75rem auto;
        max-height: calc(100vh - 3.5rem);
        display: flex;
        align-items: center;
    }
    #paySupplierDueModal .modal-content {
        border-radius: 16px !important;
        border: none !important;
        overflow: hidden !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        max-height: 90vh !important;
        display: flex !important;
        flex-direction: column !important;
        width: 100%;
    }
    #paySupplierDueModal form {
        display: flex !important;
        flex-direction: column !important;
        flex: 1 1 auto !important;
        overflow: hidden !important;
        min-height: 0 !important;
        margin: 0 !important;
    }
    #paySupplierDueModal .modal-body {
        overflow-y: auto !important;
        flex: 1 1 auto !important;
        max-height: calc(90vh - 130px) !important;
        scrollbar-width: thin;
        text-align: left !important;
    }
    #paySupplierDueModal label:not(.btn),
    #paySupplierDueModal .modal-body label:not(.btn) {
        text-align: left !important;
        display: block !important;
    }
    @media (max-width: 576px) {
        #paySupplierDueModal .modal-dialog {
            margin: 0.5rem auto !important;
            max-width: calc(100% - 1rem) !important;
            max-height: calc(100vh - 1rem) !important;
            height: auto !important;
        }
        #paySupplierDueModal .modal-content {
            max-height: 92vh !important;
        }
        #paySupplierDueModal .modal-body {
            max-height: calc(92vh - 125px) !important;
            padding: 12px 14px !important;
            text-align: left !important;
        }
    }
    body[light-mode="dark"] #paySupplierDueModal .modal-content,
    html.dark #paySupplierDueModal .modal-content,
    body.dark #paySupplierDueModal .modal-content {
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

    /* Red Circular Close Button (Matching Product Quick View) */
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

    /* Modal Supplier Info Box */
    .modal-supplier-info-box {
        background-color: #f0fdf4;
        border: 1.5px solid #bbf7d0;
        border-radius: 14px;
        padding: 12px 14px;
    }
    body[light-mode="dark"] .modal-supplier-info-box,
    body[data-layout-mode="dark"] .modal-supplier-info-box,
    html.dark .modal-supplier-info-box,
    body.dark .modal-supplier-info-box {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    /* Supplier Profile Header Left-Align on Desktop */
    .supplier-profile-details {
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        text-align: left !important;
    }
    .supplier-detail-item {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-start !important;
        text-align: left !important;
        gap: 8px !important;
        width: 100% !important;
    }
    @media (max-width: 767px) {
        .supplier-profile-details {
            align-items: center !important;
            text-align: center !important;
        }
        .supplier-detail-item {
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
    .btn-check:checked + .btn-target-type.type-pur {
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
    .sp-input {
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
    .sp-input:focus {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.2) !important;
    }
    body[light-mode="dark"] .sp-input,
    html.dark .sp-input,
    body.dark .sp-input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .sp-input:focus,
    html.dark .sp-input:focus,
    body.dark .sp-input:focus {
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

    .sp-btn-cancel {
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
    .sp-btn-cancel:hover {
        background-color: #b91c1c !important;
        color: #ffffff !important;
        transform: translateY(-1px);
    }

    /* Empty state */
    .sp-empty-state {
        padding: 40px 20px;
        text-align: center;
        color: #94a3b8;
        font-weight: 500;
        font-size: 13.5px;
    }
</style>

<!-- Hero Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-[calc(100vh-70px)] flex flex-col justify-between">
        <div class="data-table flex-grow">
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-8">

                    <!-- 1. Header Bar: Title Left, Pay Due Right -->
                    <div class="flex flex-wrap items-center justify-between gap-3 pb-3 mb-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="3" width="15" height="13"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Supplier Profile</h1>
                        </div>

                        <!-- Right Control: Pay Due Only -->
                        <div class="flex items-center">
                            <button type="button" onclick="$('#paySupplierDueModal').modal('show')" class="sp-btn-primary">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                                    <circle cx="12" cy="12" r="2"></circle>
                                    <path d="M6 12h.01M18 12h.01"></path>
                                </svg>
                                <span>Pay Due</span>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Supplier Details & Due Box (Left: Avatar Vertical on mobile + Multi-Row Details, Right: Net Payable Balance Box) -->
                    <div class="supplier-info-box unified-ui-border p-4 sm:p-5 mb-4 shadow-xs">
                        <div class="flex flex-col md:flex-row items-center md:items-center justify-between gap-5">

                            <!-- Left: Avatar (Vertical on Mobile, Horizontal on Desktop) + Details -->
                            <div class="flex flex-col md:flex-row items-center md:items-start gap-4 md:gap-5 flex-grow">
                                <div class="relative flex-shrink-0 pt-0.5">
                                    <img id="supplierImg"
                                         src="{{ asset('backend/assets/img/demo-img.jpeg') }}"
                                         alt="Supplier"
                                         class="supplier-avatar-img">
                                </div>
                                <div class="supplier-profile-details space-y-1.5">
                                    <!-- Row 1: Name + SUP ID Badge + Status Badge -->
                                    <div class="supplier-detail-item flex-wrap gap-2">
                                        <h2 id="supplierName" class="text-lg sm:text-xl font-bold text-slate-800 dark:text-white m-0 leading-tight">Loading...</h2>
                                        <span id="supplierIdBadge" class="sp-badge sp-badge-id font-mono">SUP-0000</span>
                                        <span id="supplierStatusBadge" class="sp-badge sp-badge-success">Active</span>
                                    </div>

                                    <!-- Row 2: Company Box -->
                                    <div class="supplier-detail-item">
                                        <div id="supplierCompany" class="text-slate-700 dark:text-slate-300 text-xs sm:text-sm font-medium inline-flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-md bg-amber-50 text-amber-600 dark:bg-amber-950/40 dark:text-amber-400 inline-flex items-center justify-center text-xs flex-shrink-0">
                                                <i class="fa-solid fa-building"></i>
                                            </span>
                                            <span>Company: N/A</span>
                                        </div>
                                    </div>

                                    <!-- Row 3: Call Box -->
                                    <div class="supplier-detail-item">
                                        <div id="supplierMobile" class="text-slate-700 dark:text-slate-300 text-xs sm:text-sm font-medium inline-flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-md bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400 inline-flex items-center justify-center text-xs flex-shrink-0">
                                                <i class="fa-solid fa-phone"></i>
                                            </span>
                                            <span>N/A</span>
                                        </div>
                                    </div>

                                    <!-- Row 4: Email Box (Under Call Line) -->
                                    <div class="supplier-detail-item">
                                        <div id="supplierEmail" class="text-slate-700 dark:text-slate-300 text-xs sm:text-sm font-medium inline-flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-md bg-sky-50 text-sky-600 dark:bg-sky-950/40 dark:text-sky-400 inline-flex items-center justify-center text-xs flex-shrink-0">
                                                <i class="fa-solid fa-envelope"></i>
                                            </span>
                                            <span>N/A</span>
                                        </div>
                                    </div>

                                    <!-- Row 5: Address Box -->
                                    <div class="supplier-detail-item">
                                        <div id="supplierAddress" class="text-slate-700 dark:text-slate-300 text-xs sm:text-sm font-medium inline-flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-md bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400 inline-flex items-center justify-center text-xs flex-shrink-0">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </span>
                                            <span>N/A</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Net Payable Balance Box (Right side of profile box) -->
                            <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-rose-50/80 to-slate-50 dark:from-rose-950/30 dark:to-slate-800/80 border border-rose-200/80 dark:border-rose-900/40 min-w-[240px] text-center md:text-right flex flex-col justify-center shadow-xs flex-shrink-0">
                                <span class="text-[10.5px] uppercase font-bold tracking-wider text-slate-500 dark:text-slate-400 block mb-1">Net Payable Balance</span>
                                <h3 id="supplierNetDue" class="text-2xl sm:text-3xl font-extrabold text-rose-600 dark:text-rose-400 m-0 leading-none">৳ 0.00</h3>
                                <span class="text-[11px] text-slate-400 dark:text-slate-500 block mt-1.5">Total Outstanding Due</span>
                            </div>

                        </div>
                    </div>

                    <!-- 3. KPI Stat Cards Row (100% Width Responsive Grid) -->
                    <div class="sp-stat-grid">
                        {{-- Purchases --}}
                        <div class="sp-stat-card unified-ui-border" style="border-left: 4px solid #0284c7 !important;">
                            <div class="min-w-0 overflow-hidden">
                                <div class="sp-stat-label">Purchases</div>
                                <div id="statTotalPurchases" class="sp-stat-val text-sky-600 dark:text-sky-400">0</div>
                                <div class="sp-stat-sub">Invoices</div>
                            </div>
                            <div class="sp-stat-icon icon-sky">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </div>
                        </div>

                        {{-- Total Billed --}}
                        <div class="sp-stat-card unified-ui-border" style="border-left: 4px solid #16a34a !important;">
                            <div class="min-w-0 overflow-hidden">
                                <div class="sp-stat-label">Total Billed</div>
                                <div id="statTotalBilled" class="sp-stat-val text-emerald-600 dark:text-emerald-400">৳ 0.00</div>
                                <div class="sp-stat-sub">Grand total</div>
                            </div>
                            <div class="sp-stat-icon icon-emerald">
                                <i class="fa-solid fa-money-bill-wave"></i>
                            </div>
                        </div>

                        {{-- Total Paid --}}
                        <div class="sp-stat-card unified-ui-border" style="border-left: 4px solid #059669 !important;">
                            <div class="min-w-0 overflow-hidden">
                                <div class="sp-stat-label">Total Paid</div>
                                <div id="statTotalPaid" class="sp-stat-val text-teal-600 dark:text-teal-400">৳ 0.00</div>
                                <div class="sp-stat-sub">Completed</div>
                            </div>
                            <div class="sp-stat-icon icon-teal">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                        </div>

                        {{-- Available Return Credit --}}
                        <div class="sp-stat-card unified-ui-border" style="border-left: 4px solid #0d9488 !important;">
                            <div class="min-w-0 overflow-hidden">
                                <div class="sp-stat-label">Return Credit</div>
                                <div id="statTotalReturns" class="sp-stat-val text-teal-700 dark:text-teal-300">৳ 0.00</div>
                                <div id="statReturnSubtitle" class="sp-stat-sub text-[10px]">Total: ৳0.00</div>
                            </div>
                            <div class="sp-stat-icon icon-teal">
                                <i class="fa-solid fa-truck-ramp-box"></i>
                            </div>
                        </div>

                        {{-- Net Payable Due --}}
                        <div class="sp-stat-card unified-ui-border" style="border-left: 4px solid #dc2626 !important;">
                            <div class="min-w-0 overflow-hidden">
                                <div class="sp-stat-label">Net Payable Due</div>
                                <div id="statTotalDue" class="sp-stat-val text-rose-600 dark:text-rose-400">৳ 0.00</div>
                                <div class="sp-stat-sub">Outstanding</div>
                            </div>
                            <div class="sp-stat-icon icon-rose">
                                <i class="fa-solid fa-circle-exclamation"></i>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Modern Tab Navigation (Active = Primary Green #15803d, Horizontal Scroll on Mobile) -->
                    <div class="mb-3">
                        <div class="sp-tab-nav">
                            <button type="button" class="sp-tab-btn active" onclick="switchSupTab(this, 'tab-purchases')">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                                <span>Purchase Invoices</span>
                                <span id="purchasesCount" class="tab-count">0</span>
                            </button>

                            <button type="button" class="sp-tab-btn" onclick="switchSupTab(this, 'tab-returns')">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="1 4 1 10 7 10"></polyline>
                                    <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                                </svg>
                                <span>Purchase Returns / Credit</span>
                                <span id="returnsCount" class="tab-count">0</span>
                            </button>

                            <button type="button" class="sp-tab-btn" onclick="switchSupTab(this, 'tab-transactions')">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                                <span>Payment & Transaction History</span>
                                <span id="transactionsCount" class="tab-count">0</span>
                            </button>
                        </div>
                    </div>

                    <!-- 5. Tab Contents (Desktop Table & Mobile Card Box Views) -->
                    <div>
                        {{-- ── Tab 1: Purchase Invoices ── --}}
                        <div id="tab-purchases" class="sp-tab-pane active">
                            <!-- Desktop Table -->
                            <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                                <table class="sp-table w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                            <th class="p-[10px] text-center w-[46px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                            <th class="p-[10px] text-center whitespace-nowrap">Purchase ID</th>
                                            <th class="p-[10px] text-center whitespace-nowrap">Date</th>
                                            <th class="p-[10px] text-start whitespace-nowrap">Barcodes</th>
                                            <th class="p-[10px] text-start whitespace-nowrap">Reference</th>
                                            <th class="p-[10px] text-end whitespace-nowrap">Grand Total</th>
                                            <th class="p-[10px] text-end whitespace-nowrap">Paid Amount</th>
                                            <th class="p-[10px] text-end whitespace-nowrap">Due Amount</th>
                                            <th class="p-[10px] text-center whitespace-nowrap">Status</th>
                                            <th class="p-[10px] text-center w-[60px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="purchasesTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                                        <tr><td colspan="10" class="sp-empty-state"><i class="fa-solid fa-receipt block text-3xl opacity-40 mb-2"></i>Loading purchase invoices...</td></tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile Card View -->
                            <div id="purchasesMobileCards" class="block md:hidden space-y-3">
                                <!-- Injected by JS -->
                            </div>
                        </div>

                        {{-- ── Tab 2: Purchase Returns ── --}}
                        <div id="tab-returns" class="sp-tab-pane">
                            <!-- Desktop Table -->
                            <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                                <table class="sp-table w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                            <th class="p-[10px] text-center w-[46px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                            <th class="p-[10px] text-center whitespace-nowrap">Return Date</th>
                                            <th class="p-[10px] text-center whitespace-nowrap">Purchase ID</th>
                                            <th class="p-[10px] text-start whitespace-nowrap">Returned Product</th>
                                            <th class="p-[10px] text-center whitespace-nowrap">Qty</th>
                                            <th class="p-[10px] text-end rounded-tr-2xl whitespace-nowrap">Credit / Refund</th>
                                        </tr>
                                    </thead>
                                    <tbody id="returnsTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                                        <tr><td colspan="6" class="sp-empty-state"><i class="fa-solid fa-truck-ramp-box block text-3xl opacity-40 mb-2"></i>Loading purchase return records...</td></tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile Card View -->
                            <div id="returnsMobileCards" class="block md:hidden space-y-3">
                                <!-- Injected by JS -->
                            </div>
                        </div>

                        {{-- ── Tab 3: Transactions ── --}}
                        <div id="tab-transactions" class="sp-tab-pane">
                            <!-- Desktop Table -->
                            <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                                <table class="sp-table w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                            <th class="p-[10px] text-center w-[46px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                            <th class="p-[10px] text-center whitespace-nowrap">Date & Time</th>
                                            <th class="p-[10px] text-center whitespace-nowrap">Invoice / Ref</th>
                                            <th class="p-[10px] text-end whitespace-nowrap">Paid Amount</th>
                                            <th class="p-[10px] text-end whitespace-nowrap">Discount</th>
                                            <th class="p-[10px] text-start whitespace-nowrap">Payment Method</th>
                                            <th class="p-[10px] text-start whitespace-nowrap">Transaction ID / Note</th>
                                            <th class="p-[10px] text-center rounded-tr-2xl whitespace-nowrap">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="transactionsTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                                        <tr><td colspan="8" class="sp-empty-state"><i class="fa-solid fa-hand-holding-dollar block text-3xl opacity-40 mb-2"></i>Loading transaction records...</td></tr>
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

        <!-- 6. Sticky Bottom Copyright Section (Matching Product List Page) -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)]">
            <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>

    </div>
</div>
<!-- Hero Main Content End -->

{{-- ════════════════════════════════════════════════
     PAY SUPPLIER DUE MODAL (PRODUCT LIST MODAL RULES)
════════════════════════════════════════════════ --}}
<div class="modal fade" id="paySupplierDueModal" tabindex="-1" aria-labelledby="paySupplierDueModalLabel" aria-hidden="true" style="display: none;">
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
                    <h5 class="text-base font-bold text-white tracking-tight mb-0" id="paySupplierDueModalLabel">Pay Supplier Due</h5>
                </div>

                <!-- Red Circular Close Button -->
                <button type="button" class="qv-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form id="paySupplierDueForm" onsubmit="submitSupplierPayment(event)" class="flex flex-col flex-1 overflow-hidden m-0 p-0" style="display: flex; flex-direction: column; flex: 1 1 auto; overflow: hidden; min-height: 0;">
                <div class="modal-body p-3 sm:p-4 space-y-2 text-start" style="text-align: left !important; overflow-y: auto;">

                    <!-- Supplier Quick Info Breakdown (Table on Desktop, Box Grid on Mobile) -->
                    <div class="modal-supplier-info-box">
                        <!-- Top Row: Name + SUP ID -->
                        <div class="flex justify-between items-center mb-2.5">
                            <div class="flex items-center gap-2">
                                <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400 inline-flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-truck"></i>
                                </span>
                                <span class="font-bold text-slate-800 dark:text-slate-100 text-sm sm:text-base" id="modalSupplierName">Supplier Name</span>
                            </div>
                            <span class="sp-badge sp-badge-id font-mono" id="modalSupplierId">ID</span>
                        </div>

                        <!-- Desktop Table Breakdown of Dues -->
                        <div class="modal-due-breakdown-box modal-due-breakdown-desktop mt-3 text-xs">
                            <table class="modal-due-breakdown-tbl w-full text-left border-collapse">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-3">Previous Due</th>
                                        <th class="py-2 px-3">Purchase Due</th>
                                        <th class="py-2 px-3 text-end text-rose-600 dark:text-rose-400">Total Target Due</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="font-semibold">
                                        <td class="py-2.5 px-3" id="modalPrevDueVal">৳ 0.00</td>
                                        <td class="py-2.5 px-3" id="modalPurchDueVal">৳ 0.00</td>
                                        <td class="py-2.5 px-3 text-end font-extrabold text-rose-600 dark:text-rose-400 text-sm" id="modalSupplierTotalDue">৳ 0.00</td>
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
                                <span class="text-[9.5px] uppercase font-bold text-slate-500 dark:text-slate-400 block">Purch Due</span>
                                <span class="text-xs font-bold text-slate-700 dark:text-slate-200 block mt-0.5" id="modalMobilePurchDueVal">৳ 0.00</span>
                            </div>
                            <div class="p-2 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-900/40">
                                <span class="text-[9.5px] uppercase font-bold text-rose-600 dark:text-rose-400 block">Target Due</span>
                                <span class="text-xs font-extrabold text-rose-600 dark:text-rose-400 block mt-0.5" id="modalMobileTotalDue">৳ 0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Target (Icons on Mobile, Text on Desktop) -->
                    <div class="text-start">
                        <label class="block text-start text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5 mt-3" style="text-align: left !important;">
                            Payment Target <span class="text-rose-500">*</span>
                        </label>
                        <div class="btn-group w-100 flex items-center" role="group" id="supplierCollectionTypeGroup">
                            <input type="radio" class="btn-check" name="supplier_collection_type" id="stype_all" value="all" checked onchange="onSupplierCollectionTypeChange()">
                            <label class="btn btn-target-type type-all flex-1 py-2 flex items-center justify-center text-center m-0" for="stype_all" title="Both Dues">
                                <i class="fa-solid fa-layer-group"></i>
                                <span class="target-type-text ms-1.5">Both Dues</span>
                            </label>

                            <input type="radio" class="btn-check" name="supplier_collection_type" id="stype_previous" value="previous" onchange="onSupplierCollectionTypeChange()">
                            <label class="btn btn-target-type type-prev flex-1 py-2 flex items-center justify-center text-center m-0" for="stype_previous" title="Previous Due">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                <span class="target-type-text ms-1.5">Previous Due</span>
                            </label>

                            <input type="radio" class="btn-check" name="supplier_collection_type" id="stype_purchase" value="purchase" onchange="onSupplierCollectionTypeChange()">
                            <label class="btn btn-target-type type-pur flex-1 py-2 flex items-center justify-center text-center m-0" for="stype_purchase" title="Purchase Due">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="target-type-text ms-1.5">Purchase Due</span>
                            </label>
                        </div>
                    </div>

                    <!-- Amount & Date (Mobile: Single Column Full Width, Desktop: 2 Columns) -->
                    <div class="row g-3 text-start">
                        <!-- Col 1: Payment Amount (No Taka Icon) -->
                        <div class="col-12 col-sm-6 text-start">
                            <label class="block text-start text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5 mt-2" for="supplierModalPaidAmount" style="text-align: left !important;">
                                Payment Amount (৳) <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" step="0.01" class="sp-input font-bold text-emerald-700 dark:text-emerald-400 text-sm"
                                   id="supplierModalPaidAmount" placeholder="0.00" required>
                        </div>

                        <!-- Col 2: Payment Date -->
                        <div class="col-12 col-sm-6 text-start">
                            <label class="block text-start text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5 mt-2" for="supplierModalCollectionDate" style="text-align: left !important;">
                                Payment Date
                            </label>
                            <input type="text" class="sp-input cursor-pointer"
                                   id="supplierModalCollectionDate"
                                   placeholder="Select date">
                        </div>
                    </div>

                    <!-- Payment Method Custom Dropdown -->
                    <div class="text-start">
                        <label class="block text-start text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5 mt-3" style="text-align: left !important;">
                            Payment Method
                        </label>
                        <input type="hidden" id="supplierModalPaymentMethod" value="Cash">
                        <div class="custom-modal-dropdown relative" id="paymentMethodDropdown">
                            <div class="select-trigger unified-ui-border flex items-center justify-between px-3 h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-xs text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200 cursor-pointer hover:border-emerald-500 transition-all" onclick="togglePaymentMethodDropdown()">
                                <span class="selected-text flex items-center gap-2">
                                    <i class="fa-solid fa-money-bill text-emerald-600"></i> Cash
                                </span>
                                <svg class="w-3.5 h-3.5 text-slate-400 chevron-icon transition-transform duration-200 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </div>
                            <div class="select-menu shadow-2xl" style="display: none;">
                                <div class="select-option-item active" data-value="Cash" onclick="selectPaymentMethodOption('Cash', '<i class=\'fa-solid fa-money-bill text-emerald-600\'></i> Cash')">
                                    <span class="flex items-center gap-2"><i class="fa-solid fa-money-bill text-emerald-600"></i> Cash</span>
                                </div>
                                <div class="select-option-item" data-value="Bank" onclick="selectPaymentMethodOption('Bank', '<i class=\'fa-solid fa-building-columns text-blue-600\'></i> Bank Transfer')">
                                    <span class="flex items-center gap-2"><i class="fa-solid fa-building-columns text-blue-600"></i> Bank Transfer</span>
                                </div>
                                <div class="select-option-item" data-value="bKash" onclick="selectPaymentMethodOption('bKash', '<i class=\'fa-solid fa-mobile-screen text-pink-600\'></i> bKash')">
                                    <span class="flex items-center gap-2"><i class="fa-solid fa-mobile-screen text-pink-600"></i> bKash</span>
                                </div>
                                <div class="select-option-item" data-value="Nagad" onclick="selectPaymentMethodOption('Nagad', '<i class=\'fa-solid fa-wallet text-orange-600\'></i> Nagad')">
                                    <span class="flex items-center gap-2"><i class="fa-solid fa-wallet text-orange-600"></i> Nagad</span>
                                </div>
                                <div class="select-option-item" data-value="Rocket" onclick="selectPaymentMethodOption('Rocket', '<i class=\'fa-solid fa-bolt text-purple-600\'></i> Rocket')">
                                    <span class="flex items-center gap-2"><i class="fa-solid fa-bolt text-purple-600"></i> Rocket</span>
                                </div>
                                <div class="select-option-item" data-value="Cheque" onclick="selectPaymentMethodOption('Cheque', '<i class=\'fa-solid fa-money-check text-slate-600\'></i> Cheque')">
                                    <span class="flex items-center gap-2"><i class="fa-solid fa-money-check text-slate-600"></i> Cheque</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Note -->
                    <div class="text-start">
                        <label class="block text-start text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-1.5 mt-3" for="supplierModalNote" style="text-align: left !important;">
                            Transaction Note / Ref
                        </label>
                        <input type="text" class="sp-input" id="supplierModalNote"
                               placeholder="Optional note or reference">
                    </div>

                </div>

                <!-- Modal Footer: Sticky Bottom, Cancel (Red) & Submit (Green) 38px -->
                <div class="modal-footer-sticky flex-shrink-0">
                    <button type="button" class="sp-btn-cancel" data-bs-dismiss="modal">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        <span>Cancel</span>
                    </button>
                    <button type="submit" class="sp-btn-primary">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Submit Payment</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    // ── Flatpickr on Modal Open & DOM (Day-Month-Year) ──
    let supplierDuePicker = null;
    function initSupplierDueDatePicker() {
        const dateInput = document.getElementById('supplierModalCollectionDate');
        if (dateInput && typeof flatpickr !== "undefined") {
            if (supplierDuePicker) {
                try { supplierDuePicker.destroy(); } catch (e) {}
            }
            supplierDuePicker = flatpickr(dateInput, {
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
    function switchSupTab(btn, tabId) {
        document.querySelectorAll('.sp-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.sp-tab-pane').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
        const target = document.getElementById(tabId);
        if (target) {
            target.classList.add('active');
        }
    }

    const modalElement = document.getElementById('paySupplierDueModal');
    if (modalElement) {
        modalElement.addEventListener('shown.bs.modal', function () {
            initSupplierDueDatePicker();
        });
    }

    // ── Custom Payment Method Dropdown Handlers (Dynamic Dropup / Dropdown) ──
    function togglePaymentMethodDropdown() {
        const dropdown = document.getElementById('paymentMethodDropdown');
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

    function selectPaymentMethodOption(value, html) {
        document.getElementById('supplierModalPaymentMethod').value = value;
        const dropdown = document.getElementById('paymentMethodDropdown');
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

    // Close custom dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('paymentMethodDropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            const menu = dropdown.querySelector('.select-menu');
            if (menu) menu.style.display = 'none';
        }
    });

    // ── Supplier profile ID from URL ──
    const pathParts = window.location.pathname.split('/');
    const supplierProfileId = pathParts[pathParts.length - 1];

    document.addEventListener("DOMContentLoaded", () => {
        initSupplierDueDatePicker();
        loadSupplierProfileData();
    });

    function onSupplierCollectionTypeChange() {
        const selectedType = document.querySelector('input[name="supplier_collection_type"]:checked')?.value || 'all';
        const modalTotalDue       = document.getElementById('modalSupplierTotalDue');
        const modalMobileTotalDue = document.getElementById('modalMobileTotalDue');
        const prevDueVal          = document.getElementById('modalPrevDueVal');
        const modalMobilePrevDue  = document.getElementById('modalMobilePrevDueVal');
        const purchDueVal         = document.getElementById('modalPurchDueVal');
        const modalMobilePurchDue = document.getElementById('modalMobilePurchDueVal');
        const inputAmount         = document.getElementById('supplierModalPaidAmount');

        let targetMax = 0;
        const prevVal  = window.supplierPreviousDueVal || 0;
        const purchVal = window.supplierPurchaseDueVal || 0;

        if (prevDueVal)         prevDueVal.innerText         = `৳ ${prevVal.toFixed(2)}`;
        if (modalMobilePrevDue) modalMobilePrevDue.innerText = `৳ ${prevVal.toFixed(2)}`;
        if (purchDueVal)         purchDueVal.innerText         = `৳ ${purchVal.toFixed(2)}`;
        if (modalMobilePurchDue) modalMobilePurchDue.innerText = `৳ ${purchVal.toFixed(2)}`;

        if (selectedType === 'previous') {
            targetMax = prevVal;
        } else if (selectedType === 'purchase') {
            targetMax = purchVal;
        } else {
            targetMax = window.supplierTotalDueVal || (prevVal + purchVal);
        }

        if (modalTotalDue)       modalTotalDue.innerText       = `৳ ${targetMax.toFixed(2)}`;
        if (modalMobileTotalDue) modalMobileTotalDue.innerText = `৳ ${targetMax.toFixed(2)}`;
        if (inputAmount) inputAmount.value = targetMax > 0 ? targetMax.toFixed(2) : '';
    }

    async function loadSupplierProfileData() {
        try {
            const res = await axios.get(`/api/supplier-profile-data/${supplierProfileId}`, HeaderToken());
            if (res.data.status === 'success') {
                const supplier     = res.data.supplier;
                const summary      = res.data.summary;
                const purchases    = res.data.purchases    || [];
                const returns      = res.data.returns      || [];
                const transactions = res.data.transactions || [];

                window.supplierDbId          = supplier.id;
                window.supplierPreviousDueVal = parseFloat(supplier.purchase_payable_amount || 0);
                window.supplierPurchaseDueVal = purchases.reduce((sum, p) => sum + parseFloat(p.due_amount || 0), 0);
                window.supplierReturnsVal     = parseFloat(summary.total_returns || 0);
                window.supplierTotalDueVal    = Math.max(0, window.supplierPreviousDueVal + window.supplierPurchaseDueVal - window.supplierReturnsVal);

                // Header & Info Box
                $('#supplierName').text(supplier.name || 'N/A');
                $('#supplierIdBadge').text(supplier.supplier_id || 'SUP-0000');
                $('#supplierCompany').html(`
                    <span class="w-6 h-6 rounded-md bg-amber-50 text-amber-600 dark:bg-amber-950/40 dark:text-amber-400 inline-flex items-center justify-center text-xs flex-shrink-0">
                        <i class="fa-solid fa-building"></i>
                    </span>
                    <span>Company: ${supplier.company || 'N/A'}</span>
                `);
                $('#supplierMobile').html(`
                    <span class="w-6 h-6 rounded-md bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400 inline-flex items-center justify-center text-xs flex-shrink-0">
                        <i class="fa-solid fa-phone"></i>
                    </span>
                    <span>${supplier.mobile || 'N/A'}</span>
                `);
                $('#supplierEmail').html(`
                    <span class="w-6 h-6 rounded-md bg-sky-50 text-sky-600 dark:bg-sky-950/40 dark:text-sky-400 inline-flex items-center justify-center text-xs flex-shrink-0">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <span>${supplier.email || 'N/A'}</span>
                `);
                $('#supplierAddress').html(`
                    <span class="w-6 h-6 rounded-md bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400 inline-flex items-center justify-center text-xs flex-shrink-0">
                        <i class="fa-solid fa-location-dot"></i>
                    </span>
                    <span>${supplier.address || 'N/A'}</span>
                `);
                if (supplier.img_url) {
                    $('#supplierImg').attr('src', '/' + supplier.img_url);
                }

                // Stats Cards
                $('#supplierNetDue').text(`৳ ${parseFloat(summary.total_due).toFixed(2)}`);
                $('#statTotalPurchases').text(summary.total_purchases);
                $('#statTotalBilled').text(`৳ ${parseFloat(summary.total_amount).toFixed(2)}`);
                $('#statTotalPaid').text(`৳ ${parseFloat(summary.total_paid).toFixed(2)}`);
                $('#statTotalReturns').text(`৳ ${parseFloat(summary.available_credit || 0).toFixed(2)}`);
                $('#statReturnSubtitle').text(`Total: ৳${parseFloat(summary.total_returns || 0).toFixed(2)} | Adj: ৳${parseFloat(summary.total_returns_adjusted || 0).toFixed(2)}`);
                $('#statTotalDue').text(`৳ ${parseFloat(summary.total_due).toFixed(2)}`);

                // Tab Counts
                $('#purchasesCount').text(purchases.length);
                $('#returnsCount').text(returns.length);
                $('#transactionsCount').text(transactions.length);

                // Modal info
                $('#modalSupplierName').text(supplier.name || 'N/A');
                $('#modalSupplierId').text(supplier.supplier_id || 'SUP-0000');
                onSupplierCollectionTypeChange();

                // ── Purchases Desktop Table & Mobile Cards ──
                const purchasesTbody = $('#purchasesTableBody');
                const purchasesCards = $('#purchasesMobileCards');
                purchasesTbody.empty();
                purchasesCards.empty();

                if (purchases.length === 0) {
                    purchasesTbody.html('<tr><td colspan="10" class="sp-empty-state"><i class="fa-solid fa-receipt block text-3xl opacity-40 mb-2"></i>No purchase records found for this supplier</td></tr>');
                    purchasesCards.html('<div class="p-6 text-center text-slate-400 sp-mobile-card"><i class="fa-solid fa-receipt block text-3xl opacity-40 mb-2"></i>No purchase records found</div>');
                } else {
                    purchases.forEach((item, index) => {
                        const statusClass = item.payment_status === 'Fully Paid'   ? 'sp-badge-success' :
                                            item.payment_status === 'Partial Paid' ? 'sp-badge-warning'  : 'sp-badge-danger';

                        let barcodesHtml = '<span class="text-slate-400 text-xs">N/A</span>';
                        if (item.barcodes && Array.isArray(item.barcodes) && item.barcodes.length > 0) {
                            barcodesHtml = item.barcodes.map(c =>
                                `<span class="sp-badge sp-badge-id me-1 font-mono">${c}</span>`
                            ).join('');
                        }

                        let paidDisplayHtml = `৳ ${parseFloat(item.paid_amount).toFixed(2)}`;
                        if (item.return_adjustment_amount && parseFloat(item.return_adjustment_amount) > 0) {
                            paidDisplayHtml += `<br><span class="sp-badge sp-badge-teal text-[10px] mt-0.5">+৳${parseFloat(item.return_adjustment_amount).toFixed(2)} Adj</span>`;
                        }

                        // Desktop Row
                        purchasesTbody.append(`
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/60 transition-colors">
                                <td class="text-center font-bold text-slate-500">${index + 1}</td>
                                <td class="text-center"><span class="sp-badge sp-badge-id">${item.purchase_id}</span></td>
                                <td class="text-center text-slate-600 dark:text-slate-300 whitespace-nowrap">${item.date}</td>
                                <td class="text-start">${barcodesHtml}</td>
                                <td class="text-start text-slate-600 dark:text-slate-300 font-medium">${item.referance_no || 'N/A'}</td>
                                <td class="text-end font-bold text-slate-800 dark:text-white">৳ ${parseFloat(item.grand_subtotal).toFixed(2)}</td>
                                <td class="text-end font-bold text-emerald-700 dark:text-emerald-400">${paidDisplayHtml}</td>
                                <td class="text-end font-bold ${item.due_amount > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-400'}">৳ ${parseFloat(item.due_amount).toFixed(2)}</td>
                                <td class="text-center"><span class="sp-badge ${statusClass}">${item.payment_status}</span></td>
                                <td class="text-center">
                                    <a href="/purchase-invoice/${item.id}" class="sp-action-view-btn" title="View Invoice">
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        `);

                        // Mobile Box Card
                        purchasesCards.append(`
                            <div class="sp-mobile-card">
                                <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100 dark:border-slate-800">
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[11px] font-bold">#${index + 1}</span>
                                        <span class="sp-badge sp-badge-id">${item.purchase_id}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="sp-badge ${statusClass}">${item.payment_status}</span>
                                        <a href="/purchase-invoice/${item.id}" class="sp-action-view-btn" title="View Invoice">
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
                                        <span class="font-semibold text-slate-700 dark:text-slate-200">${item.date}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[11px]">Ref:</span>
                                        <span class="font-medium text-slate-700 dark:text-slate-200">${item.referance_no || 'N/A'}</span>
                                    </div>
                                </div>
                                <div class="sp-mobile-summary-box flex items-center justify-between text-xs">
                                    <div>
                                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Total</span>
                                        <span class="font-extrabold text-slate-800 dark:text-white">৳ ${parseFloat(item.grand_subtotal).toFixed(2)}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px] uppercase font-bold text-center">Paid</span>
                                        <span class="font-extrabold text-emerald-600 dark:text-emerald-400">৳ ${parseFloat(item.paid_amount).toFixed(2)}</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Due</span>
                                        <span class="font-extrabold ${item.due_amount > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-400'}">৳ ${parseFloat(item.due_amount).toFixed(2)}</span>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                }

                // ── Returns Desktop Table & Mobile Cards ──
                const returnsTbody = $('#returnsTableBody');
                const returnsCards = $('#returnsMobileCards');
                returnsTbody.empty();
                returnsCards.empty();

                if (returns.length === 0) {
                    returnsTbody.html('<tr><td colspan="6" class="sp-empty-state"><i class="fa-solid fa-truck-ramp-box block text-3xl opacity-40 mb-2"></i>No purchase return records found for this supplier</td></tr>');
                    returnsCards.html('<div class="p-6 text-center text-slate-400 sp-mobile-card"><i class="fa-solid fa-truck-ramp-box block text-3xl opacity-40 mb-2"></i>No return records found</div>');
                } else {
                    returns.forEach((rItem, rIndex) => {
                        // Desktop Row
                        returnsTbody.append(`
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/60 transition-colors">
                                <td class="text-center font-bold text-slate-500">${rIndex + 1}</td>
                                <td class="text-center text-slate-700 dark:text-slate-300 whitespace-nowrap">${rItem.created_at_formatted || rItem.date}</td>
                                <td class="text-center"><span class="sp-badge sp-badge-teal font-mono">${rItem.purchase_no}</span></td>
                                <td class="text-start font-bold text-slate-800 dark:text-white">${rItem.product_name}</td>
                                <td class="text-center"><span class="sp-badge sp-badge-blue">${rItem.quantity} pcs</span></td>
                                <td class="text-end font-bold text-teal-700 dark:text-teal-300">৳ ${parseFloat(rItem.amount).toFixed(2)}</td>
                            </tr>
                        `);

                        // Mobile Box Card
                        returnsCards.append(`
                            <div class="sp-mobile-card">
                                <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100 dark:border-slate-800">
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[11px] font-bold">#${rIndex + 1}</span>
                                        <span class="sp-badge sp-badge-teal font-mono">${rItem.purchase_no}</span>
                                    </div>
                                    <span class="sp-badge sp-badge-blue">${rItem.quantity} pcs</span>
                                </div>
                                <div class="mb-2">
                                    <h4 class="font-bold text-slate-800 dark:text-white text-sm m-0">${rItem.product_name}</h4>
                                    <span class="text-slate-400 text-xs">${rItem.created_at_formatted || rItem.date}</span>
                                </div>
                                <div class="sp-mobile-summary-box flex items-center justify-between text-xs">
                                    <span class="text-teal-800 dark:text-teal-300 font-semibold">Credit Amount</span>
                                    <span class="font-extrabold text-teal-700 dark:text-teal-300 text-sm">৳ ${parseFloat(rItem.amount).toFixed(2)}</span>
                                </div>
                            </div>
                        `);
                    });
                }

                // ── Transactions Desktop Table & Mobile Cards ──
                const transactionsTbody = $('#transactionsTableBody');
                const transactionsCards = $('#transactionsMobileCards');
                transactionsTbody.empty();
                transactionsCards.empty();

                if (transactions.length === 0) {
                    transactionsTbody.html('<tr><td colspan="8" class="sp-empty-state"><i class="fa-solid fa-hand-holding-dollar block text-3xl opacity-40 mb-2"></i>No payment transaction records found</td></tr>');
                    transactionsCards.html('<div class="p-6 text-center text-slate-400 sp-mobile-card"><i class="fa-solid fa-hand-holding-dollar block text-3xl opacity-40 mb-2"></i>No transactions found</div>');
                } else {
                    transactions.forEach((trx, index) => {
                        // Desktop Row
                        transactionsTbody.append(`
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/60 transition-colors">
                                <td class="text-center font-bold text-slate-500">${index + 1}</td>
                                <td class="text-center text-slate-600 dark:text-slate-300 whitespace-nowrap">${trx.created_at_formatted}</td>
                                <td class="text-center"><span class="sp-badge sp-badge-blue font-mono">${trx.purchase_id}</span></td>
                                <td class="text-end font-bold text-emerald-700 dark:text-emerald-400">৳ ${parseFloat(trx.paid_amount).toFixed(2)}</td>
                                <td class="text-end text-slate-500 dark:text-slate-400">৳ ${parseFloat(trx.discount_amount || 0).toFixed(2)}</td>
                                <td class="text-start text-slate-700 dark:text-slate-300"><i class="fa-solid fa-wallet me-1 text-slate-400"></i>${trx.payment_method || 'Cash'}</td>
                                <td class="text-start text-slate-500 dark:text-slate-400 text-xs">${trx.transaction_id || 'N/A'}</td>
                                <td class="text-center"><span class="sp-badge sp-badge-success">${trx.payment_status || 'Success'}</span></td>
                            </tr>
                        `);

                        // Mobile Box Card
                        transactionsCards.append(`
                            <div class="sp-mobile-card">
                                <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100 dark:border-slate-800">
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[11px] font-bold">#${index + 1}</span>
                                        <span class="sp-badge sp-badge-blue font-mono">${trx.purchase_id}</span>
                                    </div>
                                    <span class="sp-badge sp-badge-success">${trx.payment_status || 'Success'}</span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-xs mb-2">
                                    <div>
                                        <span class="text-slate-400 block text-[11px]">Date:</span>
                                        <span class="font-semibold text-slate-700 dark:text-slate-200">${trx.created_at_formatted}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[11px]">Method:</span>
                                        <span class="font-medium text-slate-700 dark:text-slate-200"><i class="fa-solid fa-wallet me-1 text-slate-400"></i>${trx.payment_method || 'Cash'}</span>
                                    </div>
                                </div>
                                <div class="sp-mobile-summary-box flex items-center justify-between text-xs">
                                    <div>
                                        <span class="text-emerald-800 dark:text-emerald-300 font-semibold">Paid: <strong class="text-emerald-700 dark:text-emerald-400 text-sm">৳ ${parseFloat(trx.paid_amount).toFixed(2)}</strong></span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400">Discount: <strong>৳ ${parseFloat(trx.discount_amount || 0).toFixed(2)}</strong></span>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                }

            } else {
                alert("Error: " + (res.data.message || "Failed to load supplier profile data."));
            }
        } catch (err) {
            console.error(err);
            alert("Error: " + (err.response?.data?.message || err.message || "Error loading supplier profile."));
        }
    }

    async function submitSupplierPayment(event) {
        event.preventDefault();

        const collectionType = document.querySelector('input[name="supplier_collection_type"]:checked')?.value || 'all';
        const paidAmount     = parseFloat(document.getElementById('supplierModalPaidAmount').value) || 0;
        const paymentMethod  = document.getElementById('supplierModalPaymentMethod').value;
        const collectionDate = document.getElementById('supplierModalCollectionDate').value;
        const note           = document.getElementById('supplierModalNote').value;

        if (paidAmount <= 0) {
            alert("Please enter a valid payment amount greater than 0.");
            return;
        }

        try {
            if (typeof showLoader === 'function') showLoader();

            const payload = {
                supplier_id:    window.supplierDbId,
                collection_type: collectionType,
                paid_amount:    paidAmount,
                payment_method: paymentMethod,
                payment_date:   collectionDate,
                note:           note
            };

            const res = await axios.post('/supplier-payment-details-update', payload, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                if (typeof successToast === 'function') {
                    successToast(res.data.message || "Supplier payment recorded successfully!");
                } else {
                    alert(res.data.message || "Supplier payment recorded successfully!");
                }

                const modalEl = document.getElementById('paySupplierDueModal');
                const modal   = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                loadSupplierProfileData();
            } else {
                alert(res.data?.message || "Failed to submit supplier payment.");
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            alert("Error: " + (err.response?.data?.message || err.message || "Payment request failed."));
        }
    }
</script>