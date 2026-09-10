<style>
    /* ── Metric Stat Cards Modern Design with 16px border-radius ── */
    .user-stat-card {
        border-radius: 16px !important;
        padding: 16px 20px !important;
        border: 1.5px solid transparent;
        transition: all 0.2s ease;
        background: #ffffff;
    }
    .user-stat-card:hover {
        transform: translateY(-2px);
    }
    .user-stat-card--users {
        background: #f0fdf4;
        border-color: #bbf7d0;
    }
    .user-stat-card--users .user-stat-title { color: #15803d; }
    .user-stat-card--users .user-stat-icon { background: #dcfce7; color: #16a34a; }

    .user-stat-card--admin {
        background: #f0f9ff;
        border-color: #bae6fd;
    }
    .user-stat-card--admin .user-stat-title { color: #0369a1; }
    .user-stat-card--admin .user-stat-icon { background: #e0f2fe; color: #0284c7; }

    .user-stat-card--cashier {
        background: #fffbeb;
        border-color: #fde68a;
    }
    .user-stat-card--cashier .user-stat-title { color: #b45309; }
    .user-stat-card--cashier .user-stat-icon { background: #fef3c7; color: #d97706; }

    .user-stat-card--manager {
        background: #faf5ff;
        border-color: #e9d5ff;
    }
    .user-stat-card--manager .user-stat-title { color: #7e22ce; }
    .user-stat-card--manager .user-stat-icon { background: #f3e8ff; color: #9333ea; }

    .user-stat-title {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .user-stat-val {
        font-size: 24px;
        font-weight: 900;
        line-height: 1;
        margin: 0;
    }
    .user-stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    /* ── Mobile Responsive 2-Column Stat Cards ── */
    @media (max-width: 576px) {
        .user-stat-card {
            padding: 12px 12px !important;
            border-radius: 14px !important;
        }
        .user-stat-title {
            font-size: 10px !important;
            letter-spacing: 0.2px !important;
            line-height: 1.25 !important;
        }
        .user-stat-icon {
            width: 32px !important;
            height: 32px !important;
            min-width: 32px !important;
            font-size: 13px !important;
            border-radius: 8px !important;
        }
        .user-stat-val {
            font-size: 20px !important;
        }
    }

    /* ── Table Box Type Container & Header ── */
    .user-table-box {
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 16px !important;
        overflow: hidden !important;
        background-color: #ffffff;
    }
    .user-table-box .card-header {
        border-bottom: 1.5px solid #e2e8f0 !important;
        padding: 14px 20px !important;
    }
    body[light-mode="dark"] .user-table-box,
    body[data-layout-mode="dark"] .user-table-box,
    html.dark .user-table-box {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .user-table-box .card-header,
    body[data-layout-mode="dark"] .user-table-box .card-header,
    html.dark .user-table-box .card-header {
        background-color: #0f172a !important;
        border-bottom-color: #334155 !important;
    }

    /* ── Robust User Searchbar (Fixed Mobile Breaking) ── */
    .user-search-wrapper {
        width: 280px;
    }
    .user-search-group {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: stretch !important;
        height: 38px !important;
        width: 100% !important;
        border: 1.5px solid #cbd5e1 !important;
        background: #f8fafc !important;
    }
    .user-search-addon {
        border: none !important;
        background: transparent !important;
        height: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 12px !important;
        flex-shrink: 0 !important;
    }
    #userSearchInput {
        height: 100% !important;
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        font-size: 13px !important;
        padding: 6px 12px 6px 0 !important;
        flex-grow: 1 !important;
    }
    #userSearchInput:focus {
        background: transparent !important;
        outline: none !important;
    }
    body[light-mode="dark"] .user-search-group,
    body[data-layout-mode="dark"] .user-search-group,
    html.dark .user-search-group {
        border-color: #334155 !important;
        background: #1e293b !important;
    }
    body[light-mode="dark"] .user-search-addon,
    body[data-layout-mode="dark"] .user-search-addon,
    html.dark .user-search-addon {
        background: transparent !important;
        color: #94a3b8 !important;
    }
    body[light-mode="dark"] #userSearchInput,
    body[data-layout-mode="dark"] #userSearchInput,
    html.dark #userSearchInput {
        background: transparent !important;
        color: #f8fafc !important;
    }

    @media (max-width: 768px) {
        .user-search-wrapper {
            width: 100% !important;
            margin-top: 4px;
        }
    }

    /* ── Desktop Table & Mobile Boxed View Switch ── */
    #userDesktopTableWrapper {
        display: block !important;
    }
    #userMobileList {
        display: none !important;
    }

    @media (max-width: 767.98px) {
        #userDesktopTableWrapper {
            display: none !important;
        }
        #userMobileList {
            display: flex !important;
            flex-direction: column !important;
            gap: 16px !important;
            padding: 16px !important;
        }
        .user-mobile-card {
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 14px !important;
            background-color: #ffffff;
            margin-bottom: 0 !important;
            transition: all 0.2s ease;
        }
        .user-mobile-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
    }
    body[light-mode="dark"] .user-mobile-card,
    body[data-layout-mode="dark"] .user-mobile-card,
    html.dark .user-mobile-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .user-mobile-card .border-bottom,
    body[data-layout-mode="dark"] .user-mobile-card .border-bottom,
    html.dark .user-mobile-card .border-bottom,
    body[light-mode="dark"] .user-mobile-card .border-top,
    body[data-layout-mode="dark"] .user-mobile-card .border-top,
    html.dark .user-mobile-card .border-top {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .user-mobile-card .bg-slate-50,
    body[data-layout-mode="dark"] .user-mobile-card .bg-slate-50,
    html.dark .user-mobile-card .bg-slate-50 {
        background-color: rgba(15, 23, 42, 0.6) !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .user-mobile-card .badge.bg-slate-100,
    body[data-layout-mode="dark"] .user-mobile-card .badge.bg-slate-100,
    html.dark .user-mobile-card .badge.bg-slate-100 {
        background-color: #0f172a !important;
        border: 1px solid #334155 !important;
        color: #94a3b8 !important;
    }

    /* ── Guidelines Section Cards ── */
    .guideline-card {
        border-radius: 14px !important;
        padding: 14px 16px !important;
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        transition: all 0.2s ease;
    }

    /* ── Modal Customizations (Shadow Remove, Sticky Header/Footer, 38px Buttons) ── */
    .modal-content.no-shadow {
        box-shadow: none !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 18px !important;
        overflow: hidden;
    }
    .sticky-modal-header {
        position: sticky;
        top: 0;
        z-index: 20;
        padding: 14px 20px;
    }
    .sticky-modal-footer {
        position: sticky;
        bottom: 0;
        z-index: 20;
        padding: 12px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }
    .scrollable-modal-body {
        max-height: calc(85vh - 130px);
        overflow-y: auto;
        padding: 20px;
    }
    .modal-close-red-btn {
        width: 32px;
        height: 32px;
        min-width: 32px;
        border-radius: 8px;
        background: #e11d48 !important;
        color: #ffffff !important;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none !important;
        cursor: pointer;
        transition: opacity 0.15s;
    }
    .modal-close-red-btn:hover {
        opacity: 0.85;
    }
    .modal-btn-h38 {
        height: 38px !important;
        min-height: 38px !important;
        padding: 0 18px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        border-radius: 10px !important;
    }
    .modal-btn-cancel {
        background-color: #e11d48 !important;
        color: #ffffff !important;
        border: 1.5px solid #e11d48 !important;
    }
    .modal-btn-cancel:hover {
        background-color: #be123c !important;
        color: #ffffff !important;
        border-color: #be123c !important;
    }

    /* ── Comprehensive Dark Mode Rules ── */
    body[light-mode="dark"] .card,
    body[data-layout-mode="dark"] .card,
    html.dark .card {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .card-header,
    body[data-layout-mode="dark"] .card-header,
    html.dark .card-header {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .card-header h4,
    body[light-mode="dark"] .card-header h5,
    body[data-layout-mode="dark"] .card-header h4,
    body[data-layout-mode="dark"] .card-header h5,
    html.dark .card-header h4,
    html.dark .card-header h5 {
        color: #f8fafc !important;
    }

    /* Dark Mode Stat Cards */
    body[light-mode="dark"] .user-stat-card--users,
    body[data-layout-mode="dark"] .user-stat-card--users,
    html.dark .user-stat-card--users {
        background: #022c1e !important; border-color: #065f46 !important;
    }
    body[light-mode="dark"] .user-stat-card--users .user-stat-title,
    html.dark .user-stat-card--users .user-stat-title {
        color: #34d399 !important;
    }
    body[light-mode="dark"] .user-stat-card--users .user-stat-icon,
    html.dark .user-stat-card--users .user-stat-icon {
        background: rgba(16, 185, 129, 0.2) !important; color: #34d399 !important;
    }

    body[light-mode="dark"] .user-stat-card--admin,
    body[data-layout-mode="dark"] .user-stat-card--admin,
    html.dark .user-stat-card--admin {
        background: #082f49 !important; border-color: #0369a1 !important;
    }
    body[light-mode="dark"] .user-stat-card--admin .user-stat-title,
    html.dark .user-stat-card--admin .user-stat-title {
        color: #38bdf8 !important;
    }
    body[light-mode="dark"] .user-stat-card--admin .user-stat-icon,
    html.dark .user-stat-card--admin .user-stat-icon {
        background: rgba(14, 165, 233, 0.2) !important; color: #38bdf8 !important;
    }

    body[light-mode="dark"] .user-stat-card--cashier,
    body[data-layout-mode="dark"] .user-stat-card--cashier,
    html.dark .user-stat-card--cashier {
        background: #451a03 !important; border-color: #92400e !important;
    }
    body[light-mode="dark"] .user-stat-card--cashier .user-stat-title,
    html.dark .user-stat-card--cashier .user-stat-title {
        color: #fbbf24 !important;
    }
    body[light-mode="dark"] .user-stat-card--cashier .user-stat-icon,
    html.dark .user-stat-card--cashier .user-stat-icon {
        background: rgba(245, 158, 11, 0.2) !important; color: #fbbf24 !important;
    }

    body[light-mode="dark"] .user-stat-card--manager,
    body[data-layout-mode="dark"] .user-stat-card--manager,
    html.dark .user-stat-card--manager {
        background: #3b0764 !important; border-color: #7e22ce !important;
    }
    body[light-mode="dark"] .user-stat-card--manager .user-stat-title,
    html.dark .user-stat-card--manager .user-stat-title {
        color: #c084fc !important;
    }
    body[light-mode="dark"] .user-stat-card--manager .user-stat-icon,
    html.dark .user-stat-card--manager .user-stat-icon {
        background: rgba(168, 85, 247, 0.2) !important; color: #c084fc !important;
    }

    /* Dark Mode Guidelines Cards */
    body[light-mode="dark"] .guideline-card,
    body[data-layout-mode="dark"] .guideline-card,
    html.dark .guideline-card {
        background: #1e293b !important;
        border-color: #334155 !important;
    }

    /* ── Desktop Table Styling ── */
    #userTable {
        width: 100%;
        margin-bottom: 0 !important;
        border-collapse: collapse !important;
    }
    #userTable thead th {
        white-space: nowrap !important;
        font-size: 11px !important;
        letter-spacing: 0.5px !important;
        padding: 12px 16px !important;
        border-top: none !important;
        border-bottom: 1.5px solid #e2e8f0 !important;
    }
    #userTable tbody td {
        white-space: nowrap !important;
        padding: 12px 16px !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }
    #userTable tbody tr:last-child td {
        border-bottom: none !important;
    }
    body[light-mode="dark"] #userTable,
    body[data-layout-mode="dark"] #userTable,
    html.dark #userTable {
        background-color: transparent !important;
        color: #f1f5f9 !important;
    }
    body[light-mode="dark"] #userTable thead,
    body[data-layout-mode="dark"] #userTable thead,
    html.dark #userTable thead {
        background-color: #1e293b !important;
    }
    body[light-mode="dark"] #userTable thead th,
    body[data-layout-mode="dark"] #userTable thead th,
    html.dark #userTable thead th {
        background-color: #1e293b !important;
        color: #94a3b8 !important;
        border-bottom-color: #334155 !important;
    }
    body[light-mode="dark"] #userTable tbody tr:hover,
    body[data-layout-mode="dark"] #userTable tbody tr:hover,
    html.dark #userTable tbody tr:hover {
        background-color: #1e293b !important;
    }
    body[light-mode="dark"] #userTable tbody td,
    body[data-layout-mode="dark"] #userTable tbody td,
    html.dark #userTable tbody td {
        border-bottom-color: #334155 !important;
        color: #e2e8f0 !important;
    }

    /* ── Table Badges & Action Buttons (Light & Dark Mode) ── */
    .user-role-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 11.5px;
        font-weight: 700;
        line-height: 1.4;
        border: 1px solid transparent;
        transition: all 0.15s ease;
    }
    .user-role-badge.role-admin {
        background-color: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }
    .user-role-badge.role-manager {
        background-color: #eff6ff;
        color: #2563eb;
        border-color: #bfdbfe;
    }
    .user-role-badge.role-cashier {
        background-color: #f0fdf4;
        color: #16a34a;
        border-color: #bbf7d0;
    }
    .user-role-badge.role-accountant {
        background-color: #faf5ff;
        color: #7e22ce;
        border-color: #e9d5ff;
    }
    .user-role-badge.role-default {
        background-color: #f8fafc;
        color: #475569;
        border-color: #cbd5e1;
    }

    .user-status-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 600;
        line-height: 1.4;
        border: 1px solid transparent;
    }
    .user-status-badge.status-approved {
        background-color: #ecfdf5;
        color: #059669;
        border-color: #a7f3d0;
    }
    .user-status-badge.status-pending {
        background-color: #fffbeb;
        color: #d97706;
        border-color: #fde68a;
    }

    .user-action-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        transition: all 0.15s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    .user-action-btn-edit {
        background-color: #ecfdf5;
        color: #059669;
        border-color: #a7f3d0;
    }
    .user-action-btn-edit:hover {
        background-color: #059669;
        color: #ffffff;
        border-color: #059669;
    }
    .user-action-btn-delete {
        background-color: #fff1f2;
        color: #e11d48;
        border-color: #fecdd3;
    }
    .user-action-btn-delete:hover {
        background-color: #e11d48;
        color: #ffffff;
        border-color: #e11d48;
    }

    /* ── Dark Mode Fixes: strictly eliminate white borders on Table elements ── */
    body[light-mode="dark"] #userTable .border,
    body[data-layout-mode="dark"] #userTable .border,
    html.dark #userTable .border,
    body[light-mode="dark"] #userTable .badge,
    body[data-layout-mode="dark"] #userTable .badge,
    html.dark #userTable .badge,
    body[light-mode="dark"] #userTable button,
    body[data-layout-mode="dark"] #userTable button,
    html.dark #userTable button {
        border-color: #334155 !important;
    }

    body[light-mode="dark"] .user-role-badge.role-admin,
    body[data-layout-mode="dark"] .user-role-badge.role-admin,
    html.dark .user-role-badge.role-admin {
        background-color: rgba(239, 68, 68, 0.15) !important;
        border-color: rgba(239, 68, 68, 0.35) !important;
        color: #f87171 !important;
    }
    body[light-mode="dark"] .user-role-badge.role-manager,
    body[data-layout-mode="dark"] .user-role-badge.role-manager,
    html.dark .user-role-badge.role-manager {
        background-color: rgba(59, 130, 246, 0.15) !important;
        border-color: rgba(59, 130, 246, 0.35) !important;
        color: #60a5fa !important;
    }
    body[light-mode="dark"] .user-role-badge.role-cashier,
    body[data-layout-mode="dark"] .user-role-badge.role-cashier,
    html.dark .user-role-badge.role-cashier {
        background-color: rgba(16, 185, 129, 0.15) !important;
        border-color: rgba(16, 185, 129, 0.35) !important;
        color: #34d399 !important;
    }
    body[light-mode="dark"] .user-role-badge.role-accountant,
    body[data-layout-mode="dark"] .user-role-badge.role-accountant,
    html.dark .user-role-badge.role-accountant {
        background-color: rgba(168, 85, 247, 0.15) !important;
        border-color: rgba(168, 85, 247, 0.35) !important;
        color: #c084fc !important;
    }
    body[light-mode="dark"] .user-role-badge.role-default,
    body[data-layout-mode="dark"] .user-role-badge.role-default,
    html.dark .user-role-badge.role-default {
        background-color: rgba(148, 163, 184, 0.15) !important;
        border-color: rgba(148, 163, 184, 0.35) !important;
        color: #cbd5e1 !important;
    }

    body[light-mode="dark"] .user-status-badge.status-approved,
    body[data-layout-mode="dark"] .user-status-badge.status-approved,
    html.dark .user-status-badge.status-approved {
        background-color: rgba(16, 185, 129, 0.15) !important;
        border-color: rgba(16, 185, 129, 0.35) !important;
        color: #34d399 !important;
    }
    body[light-mode="dark"] .user-status-badge.status-pending,
    body[data-layout-mode="dark"] .user-status-badge.status-pending,
    html.dark .user-status-badge.status-pending {
        background-color: rgba(245, 158, 11, 0.15) !important;
        border-color: rgba(245, 158, 11, 0.35) !important;
        color: #fbbf24 !important;
    }

    body[light-mode="dark"] .user-action-btn-edit,
    body[data-layout-mode="dark"] .user-action-btn-edit,
    html.dark .user-action-btn-edit {
        background-color: rgba(16, 185, 129, 0.15) !important;
        border-color: rgba(16, 185, 129, 0.35) !important;
        color: #34d399 !important;
    }
    body[light-mode="dark"] .user-action-btn-edit:hover,
    body[data-layout-mode="dark"] .user-action-btn-edit:hover,
    html.dark .user-action-btn-edit:hover {
        background-color: #059669 !important;
        border-color: #059669 !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] .user-action-btn-delete,
    body[data-layout-mode="dark"] .user-action-btn-delete,
    html.dark .user-action-btn-delete {
        background-color: rgba(225, 29, 72, 0.15) !important;
        border-color: rgba(225, 29, 72, 0.35) !important;
        color: #fb7185 !important;
    }
    body[light-mode="dark"] .user-action-btn-delete:hover,
    body[data-layout-mode="dark"] .user-action-btn-delete:hover,
    html.dark .user-action-btn-delete:hover {
        background-color: #e11d48 !important;
        border-color: #e11d48 !important;
        color: #ffffff !important;
    }

    /* Dark Mode Modals, Inputs & Toggles */
    body[light-mode="dark"] .modal-content,
    body[data-layout-mode="dark"] .modal-content,
    html.dark .modal-content {
        background-color: #0f172a !important;
        border: 1.5px solid #334155 !important;
    }
    body[light-mode="dark"] .modal-body,
    body[data-layout-mode="dark"] .modal-body,
    html.dark .modal-body {
        background-color: #0f172a !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .modal-body .form-control,
    body[data-layout-mode="dark"] .modal-body .form-control,
    html.dark .modal-body .form-control,
    body[light-mode="dark"] .modal-body .form-select,
    body[data-layout-mode="dark"] .modal-body .form-select,
    html.dark .modal-body .form-select {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .modal-body .form-label,
    body[data-layout-mode="dark"] .modal-body .form-label,
    html.dark .modal-body .form-label {
        color: #e2e8f0 !important;
    }
    body[light-mode="dark"] .modal-toggles-wrapper,
    body[data-layout-mode="dark"] .modal-toggles-wrapper,
    html.dark .modal-toggles-wrapper {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .modal-toggle-item,
    body[data-layout-mode="dark"] .modal-toggle-item,
    html.dark .modal-toggle-item {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .modal-toggle-item .form-check-label,
    body[data-layout-mode="dark"] .modal-toggle-item .form-check-label,
    html.dark .modal-toggle-item .form-check-label {
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .sticky-modal-footer,
    body[data-layout-mode="dark"] .sticky-modal-footer,
    html.dark .sticky-modal-footer {
        background-color: #1e293b !important;
        border-top-color: #334155 !important;
    }

    /* Dark Mode Search Input on page */
    body[light-mode="dark"] #userSearchInput,
    body[data-layout-mode="dark"] #userSearchInput,
    html.dark #userSearchInput {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }
    body[light-mode="dark"] .user-search-group,
    body[data-layout-mode="dark"] .user-search-group,
    html.dark .user-search-group {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .user-search-addon,
    body[data-layout-mode="dark"] .user-search-addon,
    html.dark .user-search-addon {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid py-4">
            <!-- Page Header & Action -->
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <h4 class="fw-bold mb-1 text-slate-800 dark:text-slate-100 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-user-shield text-emerald-600 dark:text-emerald-400 fs-3"></i> User Role & Permission Management
                    </h4>
                    <p class="text-muted small mb-0">Configure module-based ON/OFF toggle permissions for system users</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <button class="btn btn-success modal-btn-h38 px-4 rounded-xl shadow-sm fw-bold d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#createUserModal" onclick="resetCreateForm()">
                        <i class="fa-solid fa-user-plus me-1"></i> Add New User
                    </button>
                </div>
            </div>

            <!-- Metrics Summary Cards (Modernized with 16px border-radius, 2-Col on Mobile) -->
            <div class="row g-2 g-sm-3 mb-4">
                <div class="col-6 col-md-6 col-xl-3">
                    <div class="user-stat-card user-stat-card--users shadow-sm h-100">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="user-stat-title">Total System Users</span>
                            <div class="user-stat-icon user-stat-icon--users">
                                <i class="fa-solid fa-users"></i>
                            </div>
                        </div>
                        <h2 class="user-stat-val text-emerald-600 dark:text-emerald-400" id="totalUserCount">0</h2>
                    </div>
                </div>

                <div class="col-6 col-md-6 col-xl-3">
                    <div class="user-stat-card user-stat-card--admin shadow-sm h-100">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="user-stat-title">Admin / Super Admin</span>
                            <div class="user-stat-icon user-stat-icon--admin">
                                <i class="fa-solid fa-crown"></i>
                            </div>
                        </div>
                        <h2 class="user-stat-val text-sky-600 dark:text-sky-400" id="adminCount">0</h2>
                    </div>
                </div>

                <div class="col-6 col-md-6 col-xl-3">
                    <div class="user-stat-card user-stat-card--cashier shadow-sm h-100">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="user-stat-title">Cashier / POS Operator</span>
                            <div class="user-stat-icon user-stat-icon--cashier">
                                <i class="fa-solid fa-cash-register"></i>
                            </div>
                        </div>
                        <h2 class="user-stat-val text-amber-600 dark:text-amber-400" id="cashierCount">0</h2>
                    </div>
                </div>

                <div class="col-6 col-md-6 col-xl-3">
                    <div class="user-stat-card user-stat-card--manager shadow-sm h-100">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="user-stat-title">Accountant / Manager</span>
                            <div class="user-stat-icon user-stat-icon--manager">
                                <i class="fa-solid fa-calculator"></i>
                            </div>
                        </div>
                        <h2 class="user-stat-val text-purple-600 dark:text-purple-400" id="managerCount">0</h2>
                    </div>
                </div>
            </div>

            <!-- User Table Card (Box Type with 16px Radius and Border) -->
            <div class="card user-table-box shadow-sm mb-4">
                <div class="card-header bg-white dark:bg-slate-900 py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="fw-bold text-slate-800 dark:text-slate-100 mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-user-group text-emerald-600 dark:text-emerald-400"></i> System Users & Permissions List
                    </h5>
                    <div class="user-search-wrapper">
                        <div class="input-group user-search-group flex-nowrap rounded-xl overflow-hidden">
                            <span class="input-group-text user-search-addon text-slate-400"><i class="fa-solid fa-magnifying-glass"></i></span>
                            <input type="text" id="userSearchInput" class="form-control" placeholder="Search user...">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- Desktop Table View (>= 768px) -->
                    <div class="table-responsive" id="userDesktopTableWrapper">
                        <table class="table table-hover align-middle mb-0" id="userTable">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4 text-center" style="width: 55px;">SL</th>
                                    <th>User Info</th>
                                    <th>Mobile Number</th>
                                    <th>Role</th>
                                    <th>Active Module Permissions</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody">
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="spinner-border text-success spinner-border-sm me-2" role="status"></div>
                                        <span class="text-muted">Loading user list...</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Boxed Cards View (< 768px) -->
                    <div id="userMobileList">
                        <div class="text-center py-4 text-muted">
                            <div class="spinner-border text-success spinner-border-sm me-2" role="status"></div>
                            <span>Loading user list...</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Role Permission Matrix Info Box (Modern Design with 16px Radius) -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white dark:bg-slate-900 py-3 border-0">
                    <h5 class="fw-bold text-slate-800 dark:text-slate-100 mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-sliders text-primary"></i> Module Permission Guidelines (Live Module Access)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="guideline-card h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-danger text-white px-2.5 py-1 rounded-pill"><i class="fa-solid fa-crown me-1"></i> Admin / Super Admin</span>
                                </div>
                                <p class="small text-muted mb-0">All module toggles ON 🟢 (POS, Product, Purchase, Customer, Expense, Reports & Users).</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="guideline-card h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-primary text-white px-2.5 py-1 rounded-pill"><i class="fa-solid fa-user-gear me-1"></i> Store Manager</span>
                                </div>
                                <p class="small text-muted mb-0">POS, Product, Purchase, Customer, Supplier & Reports ON 🟢. User management OFF 🔴.</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="guideline-card h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-success text-white px-2.5 py-1 rounded-pill"><i class="fa-solid fa-cash-register me-1"></i> Cashier / POS</span>
                                </div>
                                <p class="small text-muted mb-0">POS Billing & Sales Return ON 🟢. Backoffice modules OFF 🔴.</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="guideline-card h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge text-white px-2.5 py-1 rounded-pill" style="background-color: #8b5cf6;"><i class="fa-solid fa-calculator me-1"></i> Accountant</span>
                                </div>
                                <p class="small text-muted mb-0">Customer/Supplier Due, Daily Ledger & Reports ON 🟢.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Create New User (No Shadow, Sticky Header & Footer, Red Close, Green Cancel, Height 38px) -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 no-shadow">
            <div class="modal-header border-0 sticky-modal-header bg-success text-white d-flex align-items-center justify-content-between">
                <h5 class="modal-title fw-bold m-0 d-flex align-items-center">
                    <i class="fa-solid fa-user-plus me-2"></i> Create New User & Permissions
                </h5>
                <button type="button" class="modal-close-red-btn" data-bs-dismiss="modal" aria-label="Close" id="createUserModalCloseBtn" title="Close">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <form id="createUserForm">
                <div class="modal-body scrollable-modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">User Name <span class="text-danger">*</span></label>
                            <input type="text" id="new_name" class="form-control rounded-3" placeholder="Enter user name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" id="new_mobile" class="form-control rounded-3" placeholder="017XXXXXXXX" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Email Address (Optional)</label>
                            <input type="email" id="new_email" class="form-control rounded-3" placeholder="user@domain.com">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Password <span class="text-danger">*</span></label>
                            <input type="password" id="new_password" class="form-control rounded-3" placeholder="Minimum 4 characters" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">System Role <span class="text-danger">*</span></label>
                            <select id="new_role" class="form-select rounded-3" onchange="applyRolePresets('new', this.value)" required>
                                <option value="admin">👑 Admin / Super Admin</option>
                                <option value="manager">👨‍💼 Store Manager</option>
                                <option value="cashier" selected>🛒 Cashier / POS Operator</option>
                                <option value="accountant">📊 Accountant / Bookkeeper</option>
                                <option value="users">👤 General User</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Account Status <span class="text-danger">*</span></label>
                            <select id="new_status" class="form-select rounded-3" required>
                                <option value="approved" selected>Approved</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>

                    <!-- Modern Module Toggle Permission Section -->
                    <div class="border rounded-4 p-3 modal-toggles-wrapper bg-light-subtle">
                        <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-toggle-on text-success"></i> Module Access Permissions (ON / OFF)
                        </h6>
                        <div class="row g-3" id="new_permission_toggles">
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 modal-toggle-item bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold mb-0 cursor-pointer" for="new_perm_pos">
                                        <i class="fa-solid fa-cash-register text-success me-2"></i> POS Billing & Sales
                                    </label>
                                    <input class="form-check-input fs-4 m-0 cursor-pointer" type="checkbox" id="new_perm_pos" checked>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 modal-toggle-item bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold mb-0 cursor-pointer" for="new_perm_product">
                                        <i class="fa-solid fa-boxes-stacked text-primary me-2"></i> Product & Inventory
                                    </label>
                                    <input class="form-check-input fs-4 m-0 cursor-pointer" type="checkbox" id="new_perm_product">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 modal-toggle-item bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold mb-0 cursor-pointer" for="new_perm_purchase">
                                        <i class="fa-solid fa-truck text-warning me-2"></i> Purchase & Supplier
                                    </label>
                                    <input class="form-check-input fs-4 m-0 cursor-pointer" type="checkbox" id="new_perm_purchase">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 modal-toggle-item bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold mb-0 cursor-pointer" for="new_perm_customer">
                                        <i class="fa-solid fa-users text-info me-2"></i> Customer & Dues
                                    </label>
                                    <input class="form-check-input fs-4 m-0 cursor-pointer" type="checkbox" id="new_perm_customer">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 modal-toggle-item bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold mb-0 cursor-pointer" for="new_perm_expense">
                                        <i class="fa-solid fa-wallet text-danger me-2"></i> Expense & Financial Ledger
                                    </label>
                                    <input class="form-check-input fs-4 m-0 cursor-pointer" type="checkbox" id="new_perm_expense">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 modal-toggle-item bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold mb-0 cursor-pointer" for="new_perm_report">
                                        <i class="fa-solid fa-chart-pie text-secondary me-2"></i> Reports & Analytics
                                    </label>
                                    <input class="form-check-input fs-4 m-0 cursor-pointer" type="checkbox" id="new_perm_report">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 sticky-modal-footer d-flex justify-content-end gap-2">
                    <button type="button" class="btn modal-btn-h38 modal-btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn modal-btn-h38 btn-success fw-bold" id="createUserSaveBtn">
                        <i class="fa-solid fa-check me-1"></i> Save User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Edit User Role & Toggle Permissions -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 no-shadow">
            <div class="modal-header border-0 sticky-modal-header bg-success text-white d-flex align-items-center justify-content-between">
                <h5 class="modal-title fw-bold m-0 d-flex align-items-center">
                    <i class="fa-solid fa-user-gear me-2"></i> Edit User Role & Permissions
                </h5>
                <button type="button" class="modal-close-red-btn" data-bs-dismiss="modal" aria-label="Close" id="editUserModalCloseBtn" title="Close">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <form id="editUserForm">
                <input type="hidden" id="edit_user_id">
                <div class="modal-body scrollable-modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">User Name <span class="text-danger">*</span></label>
                            <input type="text" id="edit_name" class="form-control rounded-3" placeholder="User Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" id="edit_mobile" class="form-control rounded-3" placeholder="017XXXXXXXX" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Email Address (Optional)</label>
                            <input type="email" id="edit_email" class="form-control rounded-3" placeholder="user@domain.com">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">New Password (Optional)</label>
                            <input type="password" id="edit_password" class="form-control rounded-3" placeholder="Leave blank to keep unchanged">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">System Role <span class="text-danger">*</span></label>
                            <select id="edit_role" class="form-select rounded-3" onchange="applyRolePresets('edit', this.value)" required>
                                <option value="admin">👑 Admin / Super Admin</option>
                                <option value="manager">👨‍💼 Store Manager</option>
                                <option value="cashier">🛒 Cashier / POS Operator</option>
                                <option value="accountant">📊 Accountant / Bookkeeper</option>
                                <option value="users">👤 General User</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Status <span class="text-danger">*</span></label>
                            <select id="edit_status" class="form-select rounded-3" required>
                                <option value="approved">Approved</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>

                    <!-- Modern Edit Module Toggle Permission Section -->
                    <div class="border rounded-4 p-3 modal-toggles-wrapper bg-light-subtle">
                        <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-sliders text-primary"></i> Module Access Permissions (ON / OFF)
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 modal-toggle-item bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold mb-0 cursor-pointer" for="edit_perm_pos">
                                        <i class="fa-solid fa-cash-register text-success me-2"></i> POS Billing & Sales
                                    </label>
                                    <input class="form-check-input fs-4 m-0 cursor-pointer" type="checkbox" id="edit_perm_pos">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 modal-toggle-item bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold mb-0 cursor-pointer" for="edit_perm_product">
                                        <i class="fa-solid fa-boxes-stacked text-primary me-2"></i> Product & Inventory
                                    </label>
                                    <input class="form-check-input fs-4 m-0 cursor-pointer" type="checkbox" id="edit_perm_product">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 modal-toggle-item bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold mb-0 cursor-pointer" for="edit_perm_purchase">
                                        <i class="fa-solid fa-truck text-warning me-2"></i> Purchase & Supplier
                                    </label>
                                    <input class="form-check-input fs-4 m-0 cursor-pointer" type="checkbox" id="edit_perm_purchase">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 modal-toggle-item bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold mb-0 cursor-pointer" for="edit_perm_customer">
                                        <i class="fa-solid fa-users text-info me-2"></i> Customer & Dues
                                    </label>
                                    <input class="form-check-input fs-4 m-0 cursor-pointer" type="checkbox" id="edit_perm_customer">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 modal-toggle-item bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold mb-0 cursor-pointer" for="edit_perm_expense">
                                        <i class="fa-solid fa-wallet text-danger me-2"></i> Expense & Financial Ledger
                                    </label>
                                    <input class="form-check-input fs-4 m-0 cursor-pointer" type="checkbox" id="edit_perm_expense">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 modal-toggle-item bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold mb-0 cursor-pointer" for="edit_perm_report">
                                        <i class="fa-solid fa-chart-pie text-secondary me-2"></i> Reports & Analytics
                                    </label>
                                    <input class="form-check-input fs-4 m-0 cursor-pointer" type="checkbox" id="edit_perm_report">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 sticky-modal-footer d-flex justify-content-end gap-2">
                    <button type="button" class="btn modal-btn-h38 modal-btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn modal-btn-h38 btn-primary fw-bold" id="editUserSaveBtn">
                        <i class="fa-solid fa-arrows-rotate me-1"></i> Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let allUsersData = [];

    // Apply Default Preset Toggles based on Role
    function applyRolePresets(prefix, role) {
        const setToggles = (pos, prod, pur, cust, exp, rep) => {
            document.getElementById(`${prefix}_perm_pos`).checked = pos;
            document.getElementById(`${prefix}_perm_product`).checked = prod;
            document.getElementById(`${prefix}_perm_purchase`).checked = pur;
            document.getElementById(`${prefix}_perm_customer`).checked = cust;
            document.getElementById(`${prefix}_perm_expense`).checked = exp;
            document.getElementById(`${prefix}_perm_report`).checked = rep;
        };

        switch(role) {
            case 'admin':
            case 'super_admin':
                setToggles(true, true, true, true, true, true);
                break;
            case 'manager':
                setToggles(true, true, true, true, true, true);
                break;
            case 'cashier':
                setToggles(true, false, false, false, false, false);
                break;
            case 'accountant':
                setToggles(false, false, false, true, true, true);
                break;
            default:
                setToggles(true, false, false, false, false, false);
        }
    }

    function resetCreateForm() {
        document.getElementById('createUserForm').reset();
        document.getElementById('new_role').value = 'cashier';
        applyRolePresets('new', 'cashier');
    }

    function collectToggles(prefix) {
        return {
            pos: document.getElementById(`${prefix}_perm_pos`).checked,
            product: document.getElementById(`${prefix}_perm_product`).checked,
            purchase: document.getElementById(`${prefix}_perm_purchase`).checked,
            customer: document.getElementById(`${prefix}_perm_customer`).checked,
            expense: document.getElementById(`${prefix}_perm_expense`).checked,
            report: document.getElementById(`${prefix}_perm_report`).checked
        };
    }

    function setTogglesFromData(prefix, perms, role) {
        if (perms && typeof perms === 'object') {
            document.getElementById(`${prefix}_perm_pos`).checked = !!perms.pos;
            document.getElementById(`${prefix}_perm_product`).checked = !!perms.product;
            document.getElementById(`${prefix}_perm_purchase`).checked = !!perms.purchase;
            document.getElementById(`${prefix}_perm_customer`).checked = !!perms.customer;
            document.getElementById(`${prefix}_perm_expense`).checked = !!perms.expense;
            document.getElementById(`${prefix}_perm_report`).checked = !!perms.report;
        } else {
            applyRolePresets(prefix, role);
        }
    }

    // Load users list from API
    async function loadAllUsers() {
        try {
            const res = await axios.get('/get-all-users');
            if (res.data && res.data.status === 'success') {
                allUsersData = res.data.data || [];
                renderUserTable(allUsersData);
                updateUserMetrics(allUsersData);
            }
        } catch (e) {
            console.error('Error loading users:', e);
            const errHtml = `
                <div class="text-center text-danger py-4">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Failed to load user data.
                </div>
            `;
            if (document.getElementById('userTableBody')) {
                document.getElementById('userTableBody').innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center text-danger py-4">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> Failed to load user data.
                        </td>
                    </tr>
                `;
            }
            if (document.getElementById('userMobileList')) {
                document.getElementById('userMobileList').innerHTML = errHtml;
            }
        }
    }

    function updateUserMetrics(users) {
        document.getElementById('totalUserCount').innerText = users.length;
        
        let admins = users.filter(u => u.role === 'admin' || u.role === 'super_admin').length;
        let cashiers = users.filter(u => u.role === 'cashier').length;
        let managers = users.filter(u => u.role === 'manager' || u.role === 'accountant').length;

        document.getElementById('adminCount').innerText = admins;
        document.getElementById('cashierCount').innerText = cashiers;
        document.getElementById('managerCount').innerText = managers;
    }

    function getRoleBadge(role) {
        switch(role) {
            case 'admin':
            case 'super_admin':
                return `<span class="user-role-badge role-admin"><i class="fa-solid fa-crown me-1"></i> Super Admin</span>`;
            case 'manager':
                return `<span class="user-role-badge role-manager"><i class="fa-solid fa-user-gear me-1"></i> Manager</span>`;
            case 'cashier':
                return `<span class="user-role-badge role-cashier"><i class="fa-solid fa-cash-register me-1"></i> Cashier</span>`;
            case 'accountant':
                return `<span class="user-role-badge role-accountant"><i class="fa-solid fa-calculator me-1"></i> Accountant</span>`;
            default:
                return `<span class="user-role-badge role-default"><i class="fa-solid fa-user me-1"></i> ${role}</span>`;
        }
    }

    function renderPermissionPills(perms, role) {
        if (!perms) {
            if (role === 'admin' || role === 'super_admin' || role === 'manager') {
                return `<span class="badge bg-success text-white px-2 py-1 me-1 mb-1">🟢 All Modules</span>`;
            }
            if (role === 'cashier') {
                return `<span class="badge bg-success text-white px-2 py-1 me-1 mb-1">🟢 POS Only</span>`;
            }
            return `<span class="badge bg-info text-white px-2 py-1 me-1 mb-1">🟢 Accounts Only</span>`;
        }

        let html = '';
        if (perms.pos) html += `<span class="badge bg-success text-white px-2 py-1 me-1 mb-1">POS</span>`;
        if (perms.product) html += `<span class="badge bg-primary text-white px-2 py-1 me-1 mb-1">Product</span>`;
        if (perms.purchase) html += `<span class="badge bg-warning text-dark px-2 py-1 me-1 mb-1">Purchase</span>`;
        if (perms.customer) html += `<span class="badge bg-info text-white px-2 py-1 me-1 mb-1">Customer</span>`;
        if (perms.expense) html += `<span class="badge bg-danger text-white px-2 py-1 me-1 mb-1">Financials</span>`;
        if (perms.report) html += `<span class="badge bg-secondary text-white px-2 py-1 me-1 mb-1">Reports</span>`;

        return html || `<span class="badge bg-light text-muted px-2 py-1">No Active Toggles</span>`;
    }

    function renderUserTable(users) {
        const tbody = document.getElementById('userTableBody');
        const mobileContainer = document.getElementById('userMobileList');
        
        if (users.length === 0) {
            const emptyTableHtml = `
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-users-slash fs-2 mb-2 d-block text-secondary"></i>
                        No users found.
                    </td>
                </tr>
            `;
            const emptyMobileHtml = `
                <div class="text-center py-5 text-muted">
                    <i class="fa-solid fa-users-slash fs-2 mb-2 d-block text-secondary"></i>
                    No users found.
                </div>
            `;
            if (tbody) tbody.innerHTML = emptyTableHtml;
            if (mobileContainer) mobileContainer.innerHTML = emptyMobileHtml;
            return;
        }

        let tableHtml = '';
        let mobileHtml = '';

        users.forEach((u, index) => {
            let sl = index + 1;
            let rawStatus = (u.status || 'approved').toLowerCase();
            let statusText = rawStatus.charAt(0).toUpperCase() + rawStatus.slice(1);
            let statusBadge = rawStatus === 'approved' 
                ? `<span class="user-status-badge status-approved">${statusText}</span>` 
                : `<span class="user-status-badge status-pending">${statusText}</span>`;

            // 1. Desktop Row
            tableHtml += `
                <tr>
                    <td class="ps-4 text-center font-bold text-slate-400" style="font-size: 12px;">${sl}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="${u.img_url}" class="rounded-circle border" style="width: 42px; height: 42px; object-fit: cover;" alt="${u.name}" onerror="this.src='/assets/img/default-avatar.png'">
                            <div>
                                <h6 class="fw-bold mb-0 text-slate-800 dark:text-slate-100">${u.name}</h6>
                                <span class="small text-muted">${u.email || ''}</span>
                            </div>
                        </div>
                    </td>
                    <td class="fw-semibold text-slate-700 dark:text-slate-200">${u.mobile}</td>
                    <td>${getRoleBadge(u.role)}</td>
                    <td>${renderPermissionPills(u.permissions, u.role)}</td>
                    <td class="text-center">${statusBadge}</td>
                    <td class="text-end pe-4">
                        <div class="d-flex align-items-center justify-content-end gap-1.5">
                            <button type="button" onclick="openEditModal(${u.id})" class="user-action-btn user-action-btn-edit" title="Edit User">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9"></path>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                </svg>
                            </button>
                            <button type="button" onclick="deleteUser(${u.id}, '${u.name.replace(/'/g, "\\'")}')" class="user-action-btn user-action-btn-delete" title="Delete User">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;

            // 2. Mobile Boxed Card
            mobileHtml += `
                <div class="user-mobile-card p-3 rounded-3 mb-0 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom border-slate-100 dark:border-slate-800">
                        <div class="d-flex align-items-center gap-1.5 flex-wrap">
                            <span class="badge bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 font-bold px-2 py-1 rounded-md" style="font-size: 11px;">#${sl}</span>
                            ${getRoleBadge(u.role)}
                        </div>
                        <div>
                            ${statusBadge}
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2.5 mb-2.5">
                        <img src="${u.img_url}" class="rounded-circle border" style="width: 42px; height: 42px; min-width: 42px; object-fit: cover;" alt="${u.name}" onerror="this.src='/assets/img/default-avatar.png'">
                        <div class="overflow-hidden">
                            <h6 class="fw-bold mb-0 text-slate-800 dark:text-slate-100 text-sm text-truncate">${u.name}</h6>
                            <div class="small text-muted text-truncate" style="font-size: 11.5px;">
                                <i class="fa-solid fa-envelope me-1 text-slate-400"></i>${u.email || 'No email provided'}
                            </div>
                            <div class="small text-slate-600 dark:text-slate-300 mt-0.5 fw-semibold" style="font-size: 11.5px;">
                                <i class="fa-solid fa-phone me-1 text-success"></i>${u.mobile}
                            </div>
                        </div>
                    </div>

                    <div class="p-2.5 rounded-3 bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 mb-2.5">
                        <div class="text-muted small fw-bold mb-1.5 d-flex align-items-center gap-1" style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.5px;">
                            <i class="fa-solid fa-shield-halved text-emerald-600 dark:text-emerald-400"></i> Permissions:
                        </div>
                        <div class="d-flex flex-wrap gap-1">
                            ${renderPermissionPills(u.permissions, u.role)}
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-2 pt-2 border-top border-slate-100 dark:border-slate-800">
                        <button type="button" onclick="openEditModal(${u.id})" class="user-action-btn user-action-btn-edit" title="Edit User">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                        </button>
                        <button type="button" onclick="deleteUser(${u.id}, '${u.name.replace(/'/g, "\\'")}')" class="user-action-btn user-action-btn-delete" title="Delete User">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </button>
                    </div>
                </div>
            `;
        });

        if (tbody) tbody.innerHTML = tableHtml;
        if (mobileContainer) mobileContainer.innerHTML = mobileHtml;
    }

    // Filter Users in real-time
    document.getElementById('userSearchInput').addEventListener('keyup', function() {
        let q = this.value.toLowerCase();
        let filtered = allUsersData.filter(u => 
            u.name.toLowerCase().includes(q) || 
            u.mobile.toLowerCase().includes(q) || 
            u.email.toLowerCase().includes(q) || 
            u.role.toLowerCase().includes(q)
        );
        renderUserTable(filtered);
    });

    // Create User Form Submit
    document.getElementById('createUserForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        let saveBtn = document.getElementById('createUserSaveBtn');
        saveBtn.disabled = true;
        saveBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Saving...`;

        let payload = {
            name: document.getElementById('new_name').value,
            mobile: document.getElementById('new_mobile').value,
            email: document.getElementById('new_email').value,
            password: document.getElementById('new_password').value,
            role: document.getElementById('new_role').value,
            status: document.getElementById('new_status').value,
            permissions: collectToggles('new')
        };

        try {
            const res = await axios.post('/create-user-admin', payload);
            if (res.data && res.data.status === 'success') {
                Swal.fire('Success!', res.data.message, 'success');
                document.getElementById('createUserModalCloseBtn').click();
                resetCreateForm();
                loadAllUsers();
            } else {
                Swal.fire('Error!', res.data.message || 'Could not create user.', 'error');
            }
        } catch (err) {
            let msg = err.response?.data?.message || 'Error occurred. Please check info and try again.';
            Swal.fire('Error!', msg, 'error');
        } finally {
            saveBtn.disabled = false;
            saveBtn.innerHTML = `<i class="fa-solid fa-check me-1"></i> Save User`;
        }
    });

    // Open Edit Modal
    function openEditModal(id) {
        let u = allUsersData.find(x => x.id == id);
        if (!u) return;

        document.getElementById('edit_user_id').value = u.id;
        document.getElementById('edit_name').value = u.name;
        document.getElementById('edit_mobile').value = u.mobile;
        document.getElementById('edit_email').value = u.email && u.email !== 'N/A' ? u.email : '';
        document.getElementById('edit_role').value = u.role;
        document.getElementById('edit_status').value = u.status;
        document.getElementById('edit_password').value = '';

        setTogglesFromData('edit', u.permissions, u.role);

        const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
        modal.show();
    }

    // Edit User Form Submit
    document.getElementById('editUserForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        let saveBtn = document.getElementById('editUserSaveBtn');
        saveBtn.disabled = true;
        saveBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Updating...`;

        let payload = {
            id: document.getElementById('edit_user_id').value,
            name: document.getElementById('edit_name').value,
            mobile: document.getElementById('edit_mobile').value,
            email: document.getElementById('edit_email').value,
            role: document.getElementById('edit_role').value,
            status: document.getElementById('edit_status').value,
            password: document.getElementById('edit_password').value,
            permissions: collectToggles('edit')
        };

        try {
            const res = await axios.post('/update-user-role-status', payload);
            if (res.data && res.data.status === 'success') {
                Swal.fire('Updated!', res.data.message, 'success');
                document.getElementById('editUserModalCloseBtn').click();
                loadAllUsers();
            } else {
                Swal.fire('Error!', res.data.message || 'Failed to update.', 'error');
            }
        } catch (err) {
            let msg = err.response?.data?.message || 'Error occurred. Please try again.';
            Swal.fire('Error!', msg, 'error');
        } finally {
            saveBtn.disabled = false;
            saveBtn.innerHTML = `<i class="fa-solid fa-arrows-rotate me-1"></i> Update User`;
        }
    });

    // Delete User
    function deleteUser(id, name) {
        Swal.fire({
            title: 'Are you sure?',
            text: `"${name}" user will be deleted from system!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const res = await axios.post('/delete-user-admin', { id: id });
                    if (res.data && res.data.status === 'success') {
                        Swal.fire('Deleted!', res.data.message, 'success');
                        loadAllUsers();
                    } else {
                        Swal.fire('Error!', res.data.message || 'Could not delete user.', 'error');
                    }
                } catch (err) {
                    Swal.fire('Error!', err.response?.data?.message || 'Error occurred.', 'error');
                }
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        loadAllUsers();
        applyRolePresets('new', 'cashier');
    });
</script>
