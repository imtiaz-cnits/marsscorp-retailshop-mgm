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

    /* ── Image 4 & 5 Custom Permission Hierarchy Styles ── */
    .perm-module-card {
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        background: #ffffff;
        margin-bottom: 12px;
        overflow: hidden;
        transition: all 0.2s ease;
    }
    .perm-module-card:hover {
        border-color: #cbd5e1;
    }
    .perm-module-header {
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        user-select: none;
    }
    .perm-submenus-wrapper {
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        padding: 10px 14px 6px 14px;
    }
    .perm-submenu-item {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 9px 14px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        transition: all 0.15s ease;
        user-select: none;
    }
    .perm-submenu-item:hover {
        border-color: #10b981;
        background-color: #f0fdf4;
    }
    .perm-custom-checkbox {
        width: 20px;
        height: 20px;
        min-width: 20px;
        border-radius: 6px;
        cursor: pointer;
        accent-color: #16a34a;
    }
    body[light-mode="dark"] .perm-module-card,
    body[data-layout-mode="dark"] .perm-module-card,
    html.dark .perm-module-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .perm-submenus-wrapper,
    body[data-layout-mode="dark"] .perm-submenus-wrapper,
    html.dark .perm-submenus-wrapper {
        background-color: #0f172a !important;
        border-color: #1e293b !important;
    }
    body[light-mode="dark"] .perm-submenu-item,
    body[data-layout-mode="dark"] .perm-submenu-item,
    html.dark .perm-submenu-item {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .perm-submenu-item:hover,
    body[data-layout-mode="dark"] .perm-submenu-item:hover,
    html.dark .perm-submenu-item:hover {
        background-color: #14532d !important;
        border-color: #10b981 !important;
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

    /* ── Delete Confirmation Modal Project Design & Dead-Center Alignment ── */
    #deleteUserModal.modal {
        display: none;
        background: rgba(15, 23, 42, 0.6) !important;
        backdrop-filter: blur(4px) !important;
        -webkit-backdrop-filter: blur(4px) !important;
        z-index: 1060 !important;
    }
    #deleteUserModal.modal.show {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    #deleteUserModal .modal-dialog {
        position: static !important;
        top: auto !important;
        left: auto !important;
        transform: none !important;
        margin: auto !important;
        max-width: 440px !important;
        width: 92% !important;
        background: transparent !important;
        background-color: transparent !important;
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
        min-width: auto !important;
        overflow: visible !important;
    }
    #deleteUserModal .modal-content {
        border: none !important;
        border-radius: 1rem !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        overflow: hidden !important;
        background-color: #ffffff !important;
    }
    body[light-mode="dark"] #deleteUserModal .modal-content,
    html.dark #deleteUserModal .modal-content,
    body.dark #deleteUserModal .modal-content,
    body[data-layout-mode="dark"] #deleteUserModal .modal-content {
        background-color: #0f172a !important;
        border: 1px solid #1e293b !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6) !important;
    }
    body[light-mode="dark"] #deleteUserModal .modal-footer,
    html.dark #deleteUserModal .modal-footer,
    body.dark #deleteUserModal .modal-footer,
    body[data-layout-mode="dark"] #deleteUserModal .modal-footer {
        background-color: #0f172a !important;
        border-color: #1e293b !important;
    }
    body[light-mode="dark"] #deleteUserModal .modal-dialog,
    html.dark #deleteUserModal .modal-dialog,
    body.dark #deleteUserModal .modal-dialog,
    body[data-layout-mode="dark"] #deleteUserModal .modal-dialog {
        background: transparent !important;
        background-color: transparent !important;
    }

    /* Disabled Delete Button Styling */
    .user-action-btn-delete:disabled,
    .user-action-btn-delete[disabled] {
        opacity: 0.35 !important;
        cursor: not-allowed !important;
        filter: grayscale(0.8) !important;
        pointer-events: auto !important;
    }
    .user-action-btn-delete:disabled:hover,
    .user-action-btn-delete[disabled]:hover {
        background-color: #fee2e2 !important;
        color: #ef4444 !important;
        border-color: #fecaca !important;
        transform: none !important;
    }
    body[light-mode="dark"] .user-action-btn-delete:disabled,
    body[light-mode="dark"] .user-action-btn-delete[disabled],
    html.dark .user-action-btn-delete:disabled,
    html.dark .user-action-btn-delete[disabled] {
        background-color: rgba(225, 29, 72, 0.1) !important;
        border-color: rgba(225, 29, 72, 0.2) !important;
        color: #94a3b8 !important;
        opacity: 0.35 !important;
    }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="w-full">
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
                            <span class="user-stat-title">Staff (স্টাফ)</span>
                            <div class="user-stat-icon user-stat-icon--cashier">
                                <i class="fa-solid fa-user-tag"></i>
                            </div>
                        </div>
                        <h2 class="user-stat-val text-amber-600 dark:text-amber-400" id="cashierCount">0</h2>
                    </div>
                </div>

                <div class="col-6 col-md-6 col-xl-3">
                    <div class="user-stat-card user-stat-card--manager shadow-sm h-100">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="user-stat-title">Manager (ম্যানেজার)</span>
                            <div class="user-stat-icon user-stat-icon--manager">
                                <i class="fa-solid fa-user-gear"></i>
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

<!-- Modal: Create New User (Matching Image 4 & Image 5) -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 no-shadow">
            <div class="modal-header border-0 sticky-modal-header text-white d-flex align-items-center justify-content-between" style="background-color: #15803d !important;">
                <h5 class="modal-title fw-bold m-0 d-flex align-items-center text-white" style="font-size: 15.5px;">
                    <i class="fa-solid fa-shield-halved me-2"></i> নতুন ব্যবহারকারী ও পারমিশন তৈরি
                </h5>
                <button type="button" class="modal-close-red-btn" data-bs-dismiss="modal" aria-label="Close" id="createUserModalCloseBtn" title="Close" style="width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #ef4444; border: none; display: flex; align-items: center; justify-content: center; color: #ffffff; cursor: pointer;">
                    <i class="fa-solid fa-xmark text-white" style="font-size: 13px;"></i>
                </button>
            </div>
            <form id="createUserForm">
                <div class="modal-body scrollable-modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-slate-700">পূর্ণ নাম (Full Name) <span class="text-danger">*</span></label>
                            <input type="text" id="new_name" class="form-control rounded-3" placeholder="যেমন: মোঃ রফিকুল ইসলাম" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-slate-700">মোবাইল নম্বর <span class="text-danger">*</span></label>
                            <input type="text" id="new_mobile" class="form-control rounded-3" placeholder="017XXXXXXXX" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-slate-700">ইমেইল এড্রেস (ঐচ্ছিক)</label>
                            <input type="email" id="new_email" class="form-control rounded-3" placeholder="admin@gmail.com">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-slate-700">পাসওয়ার্ড <span class="text-danger">*</span></label>
                            <input type="password" id="new_password" class="form-control rounded-3" placeholder="••••••••" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-slate-700">পদবী / রোল (System Role) <span class="text-danger">*</span></label>
                            <select id="new_role" class="form-select rounded-3" onchange="applyRolePresets('new', this.value)" required>
                                <option value="admin">👑 Admin (অ্যাডমিন)</option>
                                <option value="manager">👨‍💼 Manager (ম্যানেজার)</option>
                                <option value="staff" selected>👤 Staff (স্টাফ)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-slate-700">অ্যাকাউন্ট স্ট্যাটাস <span class="text-danger">*</span></label>
                            <select id="new_status" class="form-select rounded-3" required>
                                <option value="approved" selected>সক্রিয় (Approved / Active)</option>
                                <option value="pending">স্থগিত / পেন্ডিং (Pending)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Profile Image Upload (Matching Image 4) -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-slate-700">প্রোফাইল ছবি (ঐচ্ছিক)</label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-preview-wrap rounded-circle border d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px; overflow: hidden; background-color: #f1f5f9;">
                                <img id="new_avatar_preview" src="" class="w-100 h-100 object-fit-cover d-none" alt="Avatar">
                                <i id="new_avatar_icon" class="fa-regular fa-user text-muted fs-4"></i>
                            </div>
                            <div>
                                <input type="file" id="new_img_file" class="d-none" accept="image/*" onchange="previewUserImage('new', this)">
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-2" style="font-size: 13px; cursor: pointer;" onclick="document.getElementById('new_img_file').click()">
                                    <i class="fa-solid fa-camera text-slate-500"></i> ছবি আপলোড করুন
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Menu Access Permission Section (Image 4 & 5) -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-3 pb-2 border-top">
                        <div>
                            <h6 class="fw-bold mb-0 text-slate-800" style="font-size: 13.5px;">সাইডবার মেনু অ্যাক্সেস পারমিশন (MODULE ACCESS PERMISSIONS)</h6>
                            <small class="text-muted" style="font-size: 11px;">প্রত্যেকটি মেনু ও সাবমেনুর পারমিশন চেকবক্স দিয়ে নিয়ন্ত্রণ করুন</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm px-3 py-1 rounded-pill fw-semibold border-0" style="background-color: #dcfce7; color: #15803d; font-size: 12px; cursor: pointer;" onclick="toggleAllPermissions('new', true)">
                                সব নির্বাচন
                            </button>
                            <button type="button" class="btn btn-sm px-3 py-1 rounded-pill fw-semibold border-0" style="background-color: #f1f5f9; color: #475569; font-size: 12px; cursor: pointer;" onclick="toggleAllPermissions('new', false)">
                                সব বাতিল
                            </button>
                        </div>
                    </div>

                    <div id="new_permission_modules" class="mt-2">
                        <!-- Module 1: Dashboard -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox" type="checkbox" id="new_perm_dashboard" checked>
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_dashboard" style="font-size: 13px;">ড্যাশবোর্ড (Dashboard)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">মূল সার্বিক ড্যাশবোর্ড ওভারভিউ ও ব্যবসায়িক তথ্য</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 2: Sales Portal / POS -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox perm-parent-cb" data-module="pos" type="checkbox" id="new_perm_pos_parent" onchange="toggleModuleChildren('new', 'pos', this.checked)">
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_pos_parent" style="font-size: 13px;">বিক্রয় পোর্টাল (Sales Portal)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">পণ্য নির্বাচন, নগদ বিক্রয় ও দ্রুত ক্যাশ বিলিং</small>
                                    </div>
                                </div>
                                <span class="badge bg-slate-100 text-slate-700 border rounded-pill px-2.5 py-1" style="font-size: 10.5px;">2 টি সাবমেনু</span>
                            </div>
                            <div class="perm-submenus-wrapper">
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="pos" type="checkbox" id="new_perm_pos_terminal" onchange="syncParentCheckbox('new', 'pos')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_pos_terminal" style="font-size: 12.5px;">পজ টার্মিনাল (POS Terminal)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">কাউন্টার বিলিং ও দ্রুত বিক্রয় রসিদ তৈরি</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="pos" type="checkbox" id="new_perm_invoice_list" onchange="syncParentCheckbox('new', 'pos')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_invoice_list" style="font-size: 12.5px;">ইনভয়েস তালিকা (Invoice List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">বিক্রিত চালানের পূর্ণাঙ্গ তালিকা ও প্রিন্ট</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 3: Stock Management / Products -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox perm-parent-cb" data-module="product" type="checkbox" id="new_perm_product_parent" onchange="toggleModuleChildren('new', 'product', this.checked)">
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_product_parent" style="font-size: 13px;">স্টক মডিউল (Stock & Products)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">সকল পণ্যের লাইভ গুদাম ও মজুদ নিয়ন্ত্রণ</small>
                                    </div>
                                </div>
                                <span class="badge bg-slate-100 text-slate-700 border rounded-pill px-2.5 py-1" style="font-size: 10.5px;">5 টি সাবমেনু</span>
                            </div>
                            <div class="perm-submenus-wrapper">
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="product" type="checkbox" id="new_perm_product_list" onchange="syncParentCheckbox('new', 'product')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_product_list" style="font-size: 12.5px;">পণ্য তালিকা (Product List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">সকল পণ্যের ক্যাটালগ ও মূল্য নির্ধারণ</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="product" type="checkbox" id="new_perm_brand_list" onchange="syncParentCheckbox('new', 'product')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_brand_list" style="font-size: 12.5px;">ব্র্যান্ড তালিকা (Brand List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">কোম্পানি ও ব্র্যান্ড ভিত্তিক শ্রেণিবিন্যাস</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="product" type="checkbox" id="new_perm_category_list" onchange="syncParentCheckbox('new', 'product')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_category_list" style="font-size: 12.5px;">ক্যাটাগরি তালিকা (Category List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">পণ্যের ক্যাটাগরি ও সাব-ক্যাটাগরি পরিচালনা</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="product" type="checkbox" id="new_perm_barcode_print" onchange="syncParentCheckbox('new', 'product')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_barcode_print" style="font-size: 12.5px;">বারকোড প্রিন্ট (Barcode Print)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">বারকোড লেবেল ও স্টিকার প্রিন্ট জেনারেশন</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="product" type="checkbox" id="new_perm_stock_overview" onchange="syncParentCheckbox('new', 'product')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_stock_overview" style="font-size: 12.5px;">স্টক ওভারভিউ (Stock Overview)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">মজুদ স্টক ও সার্বিক গুদাম পর্যবেক্ষণ</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 4: Purchases & Supplier -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox perm-parent-cb" data-module="purchase" type="checkbox" id="new_perm_purchase_parent" onchange="toggleModuleChildren('new', 'purchase', this.checked)">
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_purchase_parent" style="font-size: 13px;">পণ্য ক্রয় ও সরবরাহকারী (Purchases & Supplier)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">পণ্য ও অন্যান্য ক্রয় এবং ইনওয়ার্ড স্টক</small>
                                    </div>
                                </div>
                                <span class="badge bg-slate-100 text-slate-700 border rounded-pill px-2.5 py-1" style="font-size: 10.5px;">4 টি সাবমেনু</span>
                            </div>
                            <div class="perm-submenus-wrapper">
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="purchase" type="checkbox" id="new_perm_purchase_entry" onchange="syncParentCheckbox('new', 'purchase')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_purchase_entry" style="font-size: 12.5px;">পণ্য ক্রয় (Purchase Stock)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">নতুন চালান ও সরবরাহকারীর পণ্য ক্রয়</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="purchase" type="checkbox" id="new_perm_supplier_list" onchange="syncParentCheckbox('new', 'purchase')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_supplier_list" style="font-size: 12.5px;">সরবরাহকারী তালিকা (Supplier List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">সকল সরবরাহকারী ও ভেন্ডর প্রোফাইল</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="purchase" type="checkbox" id="new_perm_supplier_due" onchange="syncParentCheckbox('new', 'purchase')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_supplier_due" style="font-size: 12.5px;">সরবরাহকারী বকেয়া (Supplier Due)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">ভেন্ডরদের প্রদেয় বকেয়া খতিয়ান</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="purchase" type="checkbox" id="new_perm_due_payment" onchange="syncParentCheckbox('new', 'purchase')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_due_payment" style="font-size: 12.5px;">বকেয়া পরিশোধ (Due Payment)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">সরবরাহকারী বকেয়া পরিশোধ এন্ট্রি</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 5: Customers & Dues -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox perm-parent-cb" data-module="customer" type="checkbox" id="new_perm_customer_parent" onchange="toggleModuleChildren('new', 'customer', this.checked)">
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_customer_parent" style="font-size: 13px;">কাস্টমার ও বাকি (Customers & Dues)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">গ্রাহক প্রোফাইল ও বাকি পাওনা খতিয়ান</small>
                                    </div>
                                </div>
                                <span class="badge bg-slate-100 text-slate-700 border rounded-pill px-2.5 py-1" style="font-size: 10.5px;">3 টি সাবমেনু</span>
                            </div>
                            <div class="perm-submenus-wrapper">
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="customer" type="checkbox" id="new_perm_customer_list" onchange="syncParentCheckbox('new', 'customer')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_customer_list" style="font-size: 12.5px;">কাস্টমার তালিকা (Customer List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">নিবন্ধিত সকল গ্রাহক প্রোফাইল</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="customer" type="checkbox" id="new_perm_customer_due" onchange="syncParentCheckbox('new', 'customer')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_customer_due" style="font-size: 12.5px;">কাস্টমার বকেয়া (Customer Due List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">গ্রাহকদের বাকি ও বকেয়ার লেজার</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="customer" type="checkbox" id="new_perm_customer_due_collection" onchange="syncParentCheckbox('new', 'customer')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_customer_due_collection" style="font-size: 12.5px;">বাকি কালেকশন (Due Collection)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">গ্রাহক কিস্তি ও বকেয়া আদায় এন্ট্রি</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 6: Expenses -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox perm-parent-cb" data-module="expense" type="checkbox" id="new_perm_expense_parent" onchange="toggleModuleChildren('new', 'expense', this.checked)">
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_expense_parent" style="font-size: 13px;">খরচসমূহ (Expenses)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">দৈনিক পরিচালনা ও বিভিন্ন ব্যয়ের হিসাব</small>
                                    </div>
                                </div>
                                <span class="badge bg-slate-100 text-slate-700 border rounded-pill px-2.5 py-1" style="font-size: 10.5px;">2 টি সাবমেনু</span>
                            </div>
                            <div class="perm-submenus-wrapper">
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="expense" type="checkbox" id="new_perm_expense_list" onchange="syncParentCheckbox('new', 'expense')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_expense_list" style="font-size: 12.5px;">খরচ তালিকা (Expense List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">দৈনিক খরচের এন্ট্রি ও তালিকা</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="expense" type="checkbox" id="new_perm_expense_category" onchange="syncParentCheckbox('new', 'expense')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_expense_category" style="font-size: 12.5px;">খরচের খাত (Expense Category)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">ব্যয়ের খাত ও ক্যাটাগরি তৈরি</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 7: Return Management -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox perm-parent-cb" data-module="return" type="checkbox" id="new_perm_return_parent" onchange="toggleModuleChildren('new', 'return', this.checked)">
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_return_parent" style="font-size: 13px;">রিটার্ন ব্যবস্থাপনা (Return Management)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">বিক্রয় ও ক্রয় পণ্য ফেরত হিসাব</small>
                                    </div>
                                </div>
                                <span class="badge bg-slate-100 text-slate-700 border rounded-pill px-2.5 py-1" style="font-size: 10.5px;">1 টি সাবমেনু</span>
                            </div>
                            <div class="perm-submenus-wrapper">
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="return" type="checkbox" id="new_perm_return_list" onchange="syncParentCheckbox('new', 'return')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_return_list" style="font-size: 12.5px;">রিটার্ন তালিকা (Return List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">পণ্য ফেরত খতিয়ান ও তালিকা</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 8: Reports & Analytics -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox perm-parent-cb" data-module="report" type="checkbox" id="new_perm_report_parent" onchange="toggleModuleChildren('new', 'report', this.checked)">
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_report_parent" style="font-size: 13px;">রিপোর্ট ও অ্যানালিটিক্স (Reports & Analytics)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">ব্যবসায়িক বিশ্লেষণ ও আর্থিক বিবরণী</small>
                                    </div>
                                </div>
                                <span class="badge bg-slate-100 text-slate-700 border rounded-pill px-2.5 py-1" style="font-size: 10.5px;">6 টি সাবমেনু</span>
                            </div>
                            <div class="perm-submenus-wrapper">
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="report" type="checkbox" id="new_perm_daily_ledger" onchange="syncParentCheckbox('new', 'report')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_daily_ledger" style="font-size: 12.5px;">দৈনিক আয়-ব্যয় খতিয়ান (Daily Ledger)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">দৈনিক সকল হিসাব ও সামগ্রিক সামারি</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="report" type="checkbox" id="new_perm_sales_report" onchange="syncParentCheckbox('new', 'report')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_sales_report" style="font-size: 12.5px;">বিক্রয় রিপোর্ট (Sales Report)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">পণ্য ও চালান ভিত্তিক বিস্তারিত সেলস রিপোর্ট</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="report" type="checkbox" id="new_perm_income_expense_report" onchange="syncParentCheckbox('new', 'report')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_income_expense_report" style="font-size: 12.5px;">আয় ও ব্যয় রিপোর্ট (Income & Expenses)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">সার্বিক আয়-ব্যয় এবং আর্থিক হিসাব</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="report" type="checkbox" id="new_perm_daily_receipt" onchange="syncParentCheckbox('new', 'report')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_daily_receipt" style="font-size: 12.5px;">দৈনিক জমা ও খরচ (Daily Receipt & Payment)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">নগদ গ্রহণ ও পরিশোধের বিস্তারিত রিপোর্ট</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="report" type="checkbox" id="new_perm_personal_trans" onchange="syncParentCheckbox('new', 'report')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_personal_trans" style="font-size: 12.5px;">ব্যক্তিগত লেনদেন (Personal Transaction)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">মালিক বা অংশীদারের ব্যক্তিগত লেনদেন</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="report" type="checkbox" id="new_perm_low_stock" onchange="syncParentCheckbox('new', 'report')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_low_stock" style="font-size: 12.5px;">লো স্টক রিপোর্ট (Low Stock Report)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">মজুদ সংকটপূর্ণ পণ্যের তালিকা</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 9: Settings & User Roles -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox perm-parent-cb" data-module="user" type="checkbox" id="new_perm_user_parent" onchange="toggleModuleChildren('new', 'user', this.checked)">
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_user_parent" style="font-size: 13px;">সিস্টেম সেটিংস ও রোল (Settings & Roles)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">সিস্টেম ব্যবহারকারী ও রোল ব্যবস্থাপনা</small>
                                    </div>
                                </div>
                                <span class="badge bg-slate-100 text-slate-700 border rounded-pill px-2.5 py-1" style="font-size: 10.5px;">1 টি সাবমেনু</span>
                            </div>
                            <div class="perm-submenus-wrapper">
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="user" type="checkbox" id="new_perm_user_role" onchange="syncParentCheckbox('new', 'user')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="new_perm_user_role" style="font-size: 12.5px;">ইউজার রোল ও পারমিশন (User Role & Permissions)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">ব্যবহারকারী তৈরি ও পারমিশন নিয়ন্ত্রণ</small>
                                    </div>
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

<!-- Modal: Edit User Role & Permissions (Matching Image 4 & Image 5) -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 no-shadow">
            <div class="modal-header border-0 sticky-modal-header text-white d-flex align-items-center justify-content-between" style="background-color: #15803d !important;">
                <h5 class="modal-title fw-bold m-0 d-flex align-items-center text-white" style="font-size: 15.5px;">
                    <i class="fa-solid fa-user-gear me-2"></i> ব্যবহারকারী ও পারমিশন সম্পাদন (Edit User)
                </h5>
                <button type="button" class="modal-close-red-btn" data-bs-dismiss="modal" aria-label="Close" id="editUserModalCloseBtn" title="Close" style="width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #ef4444; border: none; display: flex; align-items: center; justify-content: center; color: #ffffff; cursor: pointer;">
                    <i class="fa-solid fa-xmark text-white" style="font-size: 13px;"></i>
                </button>
            </div>
            <form id="editUserForm">
                <input type="hidden" id="edit_user_id">
                <div class="modal-body scrollable-modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-slate-700">পূর্ণ নাম (Full Name) <span class="text-danger">*</span></label>
                            <input type="text" id="edit_name" class="form-control rounded-3" placeholder="User Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-slate-700">মোবাইল নম্বর <span class="text-danger">*</span></label>
                            <input type="text" id="edit_mobile" class="form-control rounded-3" placeholder="017XXXXXXXX" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-slate-700">ইমেইল এড্রেস (ঐচ্ছিক)</label>
                            <input type="email" id="edit_email" class="form-control rounded-3" placeholder="user@domain.com">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-slate-700">নতুন পাসওয়ার্ড (ঐচ্ছিক)</label>
                            <input type="password" id="edit_password" class="form-control rounded-3" placeholder="পরিবর্তন না করতে চাইলে ফাঁকা রাখুন">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-slate-700">পদবী / রোল (System Role) <span class="text-danger">*</span></label>
                            <select id="edit_role" class="form-select rounded-3" onchange="applyRolePresets('edit', this.value)" required>
                                <option value="admin">👑 Admin (অ্যাডমিন)</option>
                                <option value="manager">👨‍💼 Manager (ম্যানেজার)</option>
                                <option value="staff">👤 Staff (স্টাফ)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-slate-700">অ্যাকাউন্ট স্ট্যাটাস <span class="text-danger">*</span></label>
                            <select id="edit_status" class="form-select rounded-3" required>
                                <option value="approved">সক্রিয় (Approved / Active)</option>
                                <option value="pending">স্থগিত / পেন্ডিং (Pending)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Profile Image Upload (Edit Modal) -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-slate-700">প্রোফাইল ছবি (ঐচ্ছিক)</label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-preview-wrap rounded-circle border d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px; overflow: hidden; background-color: #f1f5f9;">
                                <img id="edit_avatar_preview" src="" class="w-100 h-100 object-fit-cover d-none" alt="Avatar">
                                <i id="edit_avatar_icon" class="fa-regular fa-user text-muted fs-4"></i>
                            </div>
                            <div>
                                <input type="file" id="edit_img_file" class="d-none" accept="image/*" onchange="previewUserImage('edit', this)">
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-2" style="font-size: 13px; cursor: pointer;" onclick="document.getElementById('edit_img_file').click()">
                                    <i class="fa-solid fa-camera text-slate-500"></i> ছবি আপলোড করুন
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Menu Access Permission Section (Edit Modal) -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-3 pb-2 border-top">
                        <div>
                            <h6 class="fw-bold mb-0 text-slate-800" style="font-size: 13.5px;">সাইডবার মেনু অ্যাক্সেস পারমিশন (MODULE ACCESS PERMISSIONS)</h6>
                            <small class="text-muted" style="font-size: 11px;">প্রত্যেকটি মেনু ও সাবমেনুর পারমিশন চেকবক্স দিয়ে নিয়ন্ত্রণ করুন</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm px-3 py-1 rounded-pill fw-semibold border-0" style="background-color: #dcfce7; color: #15803d; font-size: 12px; cursor: pointer;" onclick="toggleAllPermissions('edit', true)">
                                সব নির্বাচন
                            </button>
                            <button type="button" class="btn btn-sm px-3 py-1 rounded-pill fw-semibold border-0" style="background-color: #f1f5f9; color: #475569; font-size: 12px; cursor: pointer;" onclick="toggleAllPermissions('edit', false)">
                                সব বাতিল
                            </button>
                        </div>
                    </div>

                    <div id="edit_permission_modules" class="mt-2">
                        <!-- Module 1: Dashboard -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox" type="checkbox" id="edit_perm_dashboard">
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_dashboard" style="font-size: 13px;">ড্যাশবোর্ড (Dashboard)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">মূল সার্বিক ড্যাশবোর্ড ওভারভিউ ও ব্যবসায়িক তথ্য</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 2: Sales Portal / POS -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox perm-parent-cb" data-module="pos" type="checkbox" id="edit_perm_pos_parent" onchange="toggleModuleChildren('edit', 'pos', this.checked)">
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_pos_parent" style="font-size: 13px;">বিক্রয় পোর্টাল (Sales Portal)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">পণ্য নির্বাচন, নগদ বিক্রয় ও দ্রুত ক্যাশ বিলিং</small>
                                    </div>
                                </div>
                                <span class="badge bg-slate-100 text-slate-700 border rounded-pill px-2.5 py-1" style="font-size: 10.5px;">2 টি সাবমেনু</span>
                            </div>
                            <div class="perm-submenus-wrapper">
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="pos" type="checkbox" id="edit_perm_pos_terminal" onchange="syncParentCheckbox('edit', 'pos')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_pos_terminal" style="font-size: 12.5px;">পজ টার্মিনাল (POS Terminal)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">কাউন্টার বিলিং ও দ্রুত বিক্রয় রসিদ তৈরি</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="pos" type="checkbox" id="edit_perm_invoice_list" onchange="syncParentCheckbox('edit', 'pos')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_invoice_list" style="font-size: 12.5px;">ইনভয়েস তালিকা (Invoice List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">বিক্রিত চালানের পূর্ণাঙ্গ তালিকা ও প্রিন্ট</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 3: Stock Management / Products -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox perm-parent-cb" data-module="product" type="checkbox" id="edit_perm_product_parent" onchange="toggleModuleChildren('edit', 'product', this.checked)">
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_product_parent" style="font-size: 13px;">স্টক মডিউল (Stock & Products)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">সকল পণ্যের লাইভ গুদাম ও মজুদ নিয়ন্ত্রণ</small>
                                    </div>
                                </div>
                                <span class="badge bg-slate-100 text-slate-700 border rounded-pill px-2.5 py-1" style="font-size: 10.5px;">5 টি সাবমেনু</span>
                            </div>
                            <div class="perm-submenus-wrapper">
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="product" type="checkbox" id="edit_perm_product_list" onchange="syncParentCheckbox('edit', 'product')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_product_list" style="font-size: 12.5px;">পণ্য তালিকা (Product List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">সকল পণ্যের ক্যাটালগ ও মূল্য নির্ধারণ</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="product" type="checkbox" id="edit_perm_brand_list" onchange="syncParentCheckbox('edit', 'product')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_brand_list" style="font-size: 12.5px;">ব্র্যান্ড তালিকা (Brand List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">কোম্পানি ও ব্র্যান্ড ভিত্তিক শ্রেণিবিন্যাস</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="product" type="checkbox" id="edit_perm_category_list" onchange="syncParentCheckbox('edit', 'product')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_category_list" style="font-size: 12.5px;">ক্যাটাগরি তালিকা (Category List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">পণ্যের ক্যাটাগরি ও সাব-ক্যাটাগরি পরিচালনা</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="product" type="checkbox" id="edit_perm_barcode_print" onchange="syncParentCheckbox('edit', 'product')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_barcode_print" style="font-size: 12.5px;">বারকোড প্রিন্ট (Barcode Print)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">বারকোড লেবেল ও স্টিকার প্রিন্ট জেনারেশন</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="product" type="checkbox" id="edit_perm_stock_overview" onchange="syncParentCheckbox('edit', 'product')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_stock_overview" style="font-size: 12.5px;">স্টক ওভারভিউ (Stock Overview)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">মজুদ স্টক ও সার্বিক গুদাম পর্যবেক্ষণ</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 4: Purchases & Supplier -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox perm-parent-cb" data-module="purchase" type="checkbox" id="edit_perm_purchase_parent" onchange="toggleModuleChildren('edit', 'purchase', this.checked)">
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_purchase_parent" style="font-size: 13px;">পণ্য ক্রয় ও সরবরাহকারী (Purchases & Supplier)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">পণ্য ও অন্যান্য ক্রয় এবং ইনওয়ার্ড স্টক</small>
                                    </div>
                                </div>
                                <span class="badge bg-slate-100 text-slate-700 border rounded-pill px-2.5 py-1" style="font-size: 10.5px;">4 টি সাবমেনু</span>
                            </div>
                            <div class="perm-submenus-wrapper">
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="purchase" type="checkbox" id="edit_perm_purchase_entry" onchange="syncParentCheckbox('edit', 'purchase')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_purchase_entry" style="font-size: 12.5px;">পণ্য ক্রয় (Purchase Stock)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">নতুন চালান ও সরবরাহকারীর পণ্য ক্রয়</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="purchase" type="checkbox" id="edit_perm_supplier_list" onchange="syncParentCheckbox('edit', 'purchase')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_supplier_list" style="font-size: 12.5px;">সরবরাহকারী তালিকা (Supplier List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">সকল সরবরাহকারী ও ভেন্ডর প্রোফাইল</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="purchase" type="checkbox" id="edit_perm_supplier_due" onchange="syncParentCheckbox('edit', 'purchase')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_supplier_due" style="font-size: 12.5px;">সরবরাহকারী বকেয়া (Supplier Due)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">ভেন্ডরদের প্রদেয় বকেয়া খতিয়ান</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="purchase" type="checkbox" id="edit_perm_due_payment" onchange="syncParentCheckbox('edit', 'purchase')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_due_payment" style="font-size: 12.5px;">বকেয়া পরিশোধ (Due Payment)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">সরবরাহকারী বকেয়া পরিশোধ এন্ট্রি</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 5: Customers & Dues -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox perm-parent-cb" data-module="customer" type="checkbox" id="edit_perm_customer_parent" onchange="toggleModuleChildren('edit', 'customer', this.checked)">
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_customer_parent" style="font-size: 13px;">কাস্টমার ও বাকি (Customers & Dues)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">গ্রাহক প্রোফাইল ও বাকি পাওনা খতিয়ান</small>
                                    </div>
                                </div>
                                <span class="badge bg-slate-100 text-slate-700 border rounded-pill px-2.5 py-1" style="font-size: 10.5px;">3 টি সাবমেনু</span>
                            </div>
                            <div class="perm-submenus-wrapper">
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="customer" type="checkbox" id="edit_perm_customer_list" onchange="syncParentCheckbox('edit', 'customer')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_customer_list" style="font-size: 12.5px;">কাস্টমার তালিকা (Customer List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">নিবন্ধিত সকল গ্রাহক প্রোফাইল</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="customer" type="checkbox" id="edit_perm_customer_due" onchange="syncParentCheckbox('edit', 'customer')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_customer_due" style="font-size: 12.5px;">কাস্টমার বকেয়া (Customer Due List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">গ্রাহকদের বাকি ও বকেয়ার লেজার</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="customer" type="checkbox" id="edit_perm_customer_due_collection" onchange="syncParentCheckbox('edit', 'customer')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_customer_due_collection" style="font-size: 12.5px;">বাকি কালেকশন (Due Collection)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">গ্রাহক কিস্তি ও বকেয়া আদায় এন্ট্রি</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 6: Expenses -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox perm-parent-cb" data-module="expense" type="checkbox" id="edit_perm_expense_parent" onchange="toggleModuleChildren('edit', 'expense', this.checked)">
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_expense_parent" style="font-size: 13px;">খরচসমূহ (Expenses)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">দৈনিক পরিচালনা ও বিভিন্ন ব্যয়ের হিসাব</small>
                                    </div>
                                </div>
                                <span class="badge bg-slate-100 text-slate-700 border rounded-pill px-2.5 py-1" style="font-size: 10.5px;">2 টি সাবমেনু</span>
                            </div>
                            <div class="perm-submenus-wrapper">
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="expense" type="checkbox" id="edit_perm_expense_list" onchange="syncParentCheckbox('edit', 'expense')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_expense_list" style="font-size: 12.5px;">খরচ তালিকা (Expense List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">দৈনিক খরচের এন্ট্রি ও তালিকা</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="expense" type="checkbox" id="edit_perm_expense_category" onchange="syncParentCheckbox('edit', 'expense')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_expense_category" style="font-size: 12.5px;">খরচের খাত (Expense Category)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">ব্যয়ের খাত ও ক্যাটাগরি তৈরি</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 7: Return Management -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox perm-parent-cb" data-module="return" type="checkbox" id="edit_perm_return_parent" onchange="toggleModuleChildren('edit', 'return', this.checked)">
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_return_parent" style="font-size: 13px;">রিটার্ন ব্যবস্থাপনা (Return Management)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">বিক্রয় ও ক্রয় পণ্য ফেরত হিসাব</small>
                                    </div>
                                </div>
                                <span class="badge bg-slate-100 text-slate-700 border rounded-pill px-2.5 py-1" style="font-size: 10.5px;">1 টি সাবমেনু</span>
                            </div>
                            <div class="perm-submenus-wrapper">
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="return" type="checkbox" id="edit_perm_return_list" onchange="syncParentCheckbox('edit', 'return')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_return_list" style="font-size: 12.5px;">রিটার্ন তালিকা (Return List)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">পণ্য ফেরত খতিয়ান ও তালিকা</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 8: Reports & Analytics -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox perm-parent-cb" data-module="report" type="checkbox" id="edit_perm_report_parent" onchange="toggleModuleChildren('edit', 'report', this.checked)">
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_report_parent" style="font-size: 13px;">রিপোর্ট ও অ্যানালিটিক্স (Reports & Analytics)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">ব্যবসায়িক বিশ্লেষণ ও আর্থিক বিবরণী</small>
                                    </div>
                                </div>
                                <span class="badge bg-slate-100 text-slate-700 border rounded-pill px-2.5 py-1" style="font-size: 10.5px;">6 টি সাবমেনু</span>
                            </div>
                            <div class="perm-submenus-wrapper">
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="report" type="checkbox" id="edit_perm_daily_ledger" onchange="syncParentCheckbox('edit', 'report')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_daily_ledger" style="font-size: 12.5px;">দৈনিক আয়-ব্যয় খতিয়ান (Daily Ledger)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">দৈনিক সকল হিসাব ও সামগ্রিক সামারি</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="report" type="checkbox" id="edit_perm_sales_report" onchange="syncParentCheckbox('edit', 'report')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_sales_report" style="font-size: 12.5px;">বিক্রয় রিপোর্ট (Sales Report)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">পণ্য ও চালান ভিত্তিক বিস্তারিত সেলস রিপোর্ট</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="report" type="checkbox" id="edit_perm_income_expense_report" onchange="syncParentCheckbox('edit', 'report')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_income_expense_report" style="font-size: 12.5px;">আয় ও ব্যয় রিপোর্ট (Income & Expenses)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">সার্বিক আয়-ব্যয় এবং আর্থিক হিসাব</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="report" type="checkbox" id="edit_perm_daily_receipt" onchange="syncParentCheckbox('edit', 'report')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_daily_receipt" style="font-size: 12.5px;">দৈনিক জমা ও খরচ (Daily Receipt & Payment)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">নগদ গ্রহণ ও পরিশোধের বিস্তারিত রিপোর্ট</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="report" type="checkbox" id="edit_perm_personal_trans" onchange="syncParentCheckbox('edit', 'report')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_personal_trans" style="font-size: 12.5px;">ব্যক্তিগত লেনদেন (Personal Transaction)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">মালিক বা অংশীদারের ব্যক্তিগত লেনদেন</small>
                                    </div>
                                </div>
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="report" type="checkbox" id="edit_perm_low_stock" onchange="syncParentCheckbox('edit', 'report')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_low_stock" style="font-size: 12.5px;">লো স্টক রিপোর্ট (Low Stock Report)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">মজুদ সংকটপূর্ণ পণ্যের তালিকা</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 9: Settings & User Roles -->
                        <div class="perm-module-card">
                            <div class="perm-module-header">
                                <div class="d-flex align-items-center gap-2.5">
                                    <input class="perm-custom-checkbox perm-parent-cb" data-module="user" type="checkbox" id="edit_perm_user_parent" onchange="toggleModuleChildren('edit', 'user', this.checked)">
                                    <div>
                                        <label class="fw-bold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_user_parent" style="font-size: 13px;">সিস্টেম সেটিংস ও রোল (Settings & Roles)</label>
                                        <small class="text-muted d-block" style="font-size: 11px;">সিস্টেম ব্যবহারকারী ও রোল ব্যবস্থাপনা</small>
                                    </div>
                                </div>
                                <span class="badge bg-slate-100 text-slate-700 border rounded-pill px-2.5 py-1" style="font-size: 10.5px;">1 টি সাবমেনু</span>
                            </div>
                            <div class="perm-submenus-wrapper">
                                <div class="perm-submenu-item">
                                    <input class="perm-custom-checkbox perm-child-cb" data-parent="user" type="checkbox" id="edit_perm_user_role" onchange="syncParentCheckbox('edit', 'user')">
                                    <div>
                                        <label class="fw-semibold mb-0 text-slate-800 cursor-pointer d-block" for="edit_perm_user_role" style="font-size: 12.5px;">ইউজার রোল ও পারমিশন (User Role & Permissions)</label>
                                        <small class="text-muted d-block" style="font-size: 10.5px;">ব্যবহারকারী তৈরি ও পারমিশন নিয়ন্ত্রণ</small>
                                    </div>
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

<!-- User Delete Confirmation Modal Start -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm sm:modal-md my-3" style="max-width: 440px;">
        <div class="modal-content bg-white dark:bg-slate-900 border-0 rounded-2xl shadow-2xl overflow-hidden transition-colors flex flex-col" style="border: none !important;">
            
            <!-- Sticky Top Header (Red) -->
            <div class="modal-header sticky top-0 z-20 px-4 sm:px-5 py-3.5 bg-rose-600 text-white flex items-center justify-between shadow-sm border-0 flex-shrink-0" style="background-color: #dc2626 !important; color: #ffffff !important; border: none !important;">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </div>
                    <h5 class="modal-title text-base font-bold text-white tracking-tight mb-0" id="deleteUserModalLabel" style="color: #ffffff !important;">Delete User</h5>
                </div>
                <!-- Circular Red Close Button with White Icon -->
                <button type="button" class="qv-close-btn" data-bs-dismiss="modal" onclick="closeDeleteUserModal()" aria-label="Close" style="width: 30px !important; height: 30px !important; min-width: 30px !important; min-height: 30px !important; border-radius: 50% !important; background-color: #991b1b !important; color: #ffffff !important; border: none !important; display: flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; padding: 0 !important; margin: 0 !important;">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4 text-center">
                <div class="w-14 h-14 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto mb-3.5 border border-rose-100 dark:border-slate-800">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <h4 class="text-base sm:text-lg font-bold text-slate-800 dark:text-slate-100 mb-1.5">Confirm Deletion</h4>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mb-0">Are you sure you want to delete <span id="deleteUserNameText" class="fw-bold text-slate-800 dark:text-slate-200"></span>? This action cannot be undone.</p>
                <input type="hidden" id="deleteUserID" />
            </div>

            <!-- Sticky Bottom Footer (Strict 38px buttons) -->
            <div class="modal-footer sticky bottom-0 z-20 px-4 sm:px-5 py-3 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 flex items-center justify-center gap-2.5 flex-shrink-0">
                <button type="button" class="px-4 h-[38px] min-h-[38px] max-h-[38px] rounded-xl text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 unified-ui-border text-xs sm:text-sm font-semibold transition-all shadow-sm flex items-center justify-center cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700" data-bs-dismiss="modal" onclick="closeDeleteUserModal()">
                    Cancel
                </button>
                <button type="button" id="confirmDeleteUserBtn" onclick="confirmDeleteUser()" class="px-5 h-[38px] min-h-[38px] max-h-[38px] rounded-xl text-white text-xs sm:text-sm font-semibold transition-all shadow-sm flex items-center justify-center cursor-pointer hover:bg-rose-700 active:scale-[0.98]" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important;">
                    Yes, Delete
                </button>
            </div>

        </div>
    </div>
</div>
<!-- User Delete Confirmation Modal End -->

<script>
    let allUsersData = [];

    // Image preview helper
    function previewUserImage(prefix, input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById(`${prefix}_avatar_preview`);
                const icon = document.getElementById(`${prefix}_avatar_icon`);
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                if (icon) {
                    icon.classList.add('d-none');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Toggle all checkboxes
    function toggleAllPermissions(prefix, checkAll) {
        const container = document.getElementById(`${prefix}_permission_modules`);
        if (!container) return;
        const checkboxes = container.querySelectorAll('.perm-custom-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = checkAll;
        });
    }

    // Toggle child checkboxes for a module
    function toggleModuleChildren(prefix, moduleName, isChecked) {
        const container = document.getElementById(`${prefix}_permission_modules`);
        if (!container) return;
        const children = container.querySelectorAll(`.perm-child-cb[data-parent="${moduleName}"]`);
        children.forEach(cb => {
            cb.checked = isChecked;
        });
    }

    // Sync parent checkbox state with children
    function syncParentCheckbox(prefix, moduleName) {
        const container = document.getElementById(`${prefix}_permission_modules`);
        if (!container) return;
        const parent = container.querySelector(`.perm-parent-cb[data-module="${moduleName}"]`);
        const children = container.querySelectorAll(`.perm-child-cb[data-parent="${moduleName}"]`);
        if (parent && children.length > 0) {
            const anyChecked = Array.from(children).some(cb => cb.checked);
            parent.checked = anyChecked;
        }
    }

    // Apply Default Preset Toggles based on 3 System Roles: admin, manager, staff
    function applyRolePresets(prefix, role) {
        const container = document.getElementById(`${prefix}_permission_modules`);
        if (!container) return;

        if (role === 'admin' || role === 'super_admin') {
            toggleAllPermissions(prefix, true);
        } else if (role === 'manager') {
            toggleAllPermissions(prefix, true);
            // Manager cannot access System Settings & User Roles
            const userParent = document.getElementById(`${prefix}_perm_user_parent`);
            if (userParent) {
                userParent.checked = false;
                toggleModuleChildren(prefix, 'user', false);
            }
        } else if (role === 'staff' || role === 'cashier' || role === 'users') {
            toggleAllPermissions(prefix, false);
            // Staff defaults to POS Billing & Sales
            const posParent = document.getElementById(`${prefix}_perm_pos_parent`);
            if (posParent) {
                posParent.checked = true;
                toggleModuleChildren(prefix, 'pos', true);
            }
            const dashboardEl = document.getElementById(`${prefix}_perm_dashboard`);
            if (dashboardEl) dashboardEl.checked = true;
        }
    }

    function resetCreateForm() {
        document.getElementById('createUserForm').reset();
        document.getElementById('new_role').value = 'staff';
        const preview = document.getElementById('new_avatar_preview');
        const icon = document.getElementById('new_avatar_icon');
        if (preview) {
            preview.src = '';
            preview.classList.add('d-none');
        }
        if (icon) icon.classList.remove('d-none');
        applyRolePresets('new', 'staff');
    }

    function collectToggles(prefix) {
        return {
            dashboard: !!document.getElementById(`${prefix}_perm_dashboard`)?.checked,
            pos: !!document.getElementById(`${prefix}_perm_pos_parent`)?.checked,
            pos_terminal: !!document.getElementById(`${prefix}_perm_pos_terminal`)?.checked,
            invoice_list: !!document.getElementById(`${prefix}_perm_invoice_list`)?.checked,
            product: !!document.getElementById(`${prefix}_perm_product_parent`)?.checked,
            product_list: !!document.getElementById(`${prefix}_perm_product_list`)?.checked,
            brand_list: !!document.getElementById(`${prefix}_perm_brand_list`)?.checked,
            category_list: !!document.getElementById(`${prefix}_perm_category_list`)?.checked,
            barcode_print: !!document.getElementById(`${prefix}_perm_barcode_print`)?.checked,
            stock_overview: !!document.getElementById(`${prefix}_perm_stock_overview`)?.checked,
            purchase: !!document.getElementById(`${prefix}_perm_purchase_parent`)?.checked,
            purchase_entry: !!document.getElementById(`${prefix}_perm_purchase_entry`)?.checked,
            supplier_list: !!document.getElementById(`${prefix}_perm_supplier_list`)?.checked,
            supplier_due: !!document.getElementById(`${prefix}_perm_supplier_due`)?.checked,
            due_payment: !!document.getElementById(`${prefix}_perm_due_payment`)?.checked,
            customer: !!document.getElementById(`${prefix}_perm_customer_parent`)?.checked,
            customer_list: !!document.getElementById(`${prefix}_perm_customer_list`)?.checked,
            customer_due: !!document.getElementById(`${prefix}_perm_customer_due`)?.checked,
            customer_due_collection: !!document.getElementById(`${prefix}_perm_customer_due_collection`)?.checked,
            expense: !!document.getElementById(`${prefix}_perm_expense_parent`)?.checked,
            expense_list: !!document.getElementById(`${prefix}_perm_expense_list`)?.checked,
            expense_category: !!document.getElementById(`${prefix}_perm_expense_category`)?.checked,
            return: !!document.getElementById(`${prefix}_perm_return_parent`)?.checked,
            return_list: !!document.getElementById(`${prefix}_perm_return_list`)?.checked,
            report: !!document.getElementById(`${prefix}_perm_report_parent`)?.checked,
            daily_ledger: !!document.getElementById(`${prefix}_perm_daily_ledger`)?.checked,
            sales_report: !!document.getElementById(`${prefix}_perm_sales_report`)?.checked,
            income_expense_report: !!document.getElementById(`${prefix}_perm_income_expense_report`)?.checked,
            daily_receipt: !!document.getElementById(`${prefix}_perm_daily_receipt`)?.checked,
            personal_trans: !!document.getElementById(`${prefix}_perm_personal_trans`)?.checked,
            low_stock: !!document.getElementById(`${prefix}_perm_low_stock`)?.checked,
            user: !!document.getElementById(`${prefix}_perm_user_parent`)?.checked,
            user_role: !!document.getElementById(`${prefix}_perm_user_role`)?.checked
        };
    }

    function setTogglesFromData(prefix, perms, role) {
        if (perms && typeof perms === 'object') {
            const setVal = (id, val) => {
                const el = document.getElementById(id);
                if (el) el.checked = !!val;
            };

            setVal(`${prefix}_perm_dashboard`, perms.dashboard !== undefined ? perms.dashboard : true);
            setVal(`${prefix}_perm_pos_parent`, perms.pos);
            setVal(`${prefix}_perm_pos_terminal`, perms.pos_terminal !== undefined ? perms.pos_terminal : perms.pos);
            setVal(`${prefix}_perm_invoice_list`, perms.invoice_list !== undefined ? perms.invoice_list : perms.pos);

            setVal(`${prefix}_perm_product_parent`, perms.product);
            setVal(`${prefix}_perm_product_list`, perms.product_list !== undefined ? perms.product_list : perms.product);
            setVal(`${prefix}_perm_brand_list`, perms.brand_list !== undefined ? perms.brand_list : perms.product);
            setVal(`${prefix}_perm_category_list`, perms.category_list !== undefined ? perms.category_list : perms.product);
            setVal(`${prefix}_perm_barcode_print`, perms.barcode_print !== undefined ? perms.barcode_print : perms.product);
            setVal(`${prefix}_perm_stock_overview`, perms.stock_overview !== undefined ? perms.stock_overview : perms.product);

            setVal(`${prefix}_perm_purchase_parent`, perms.purchase);
            setVal(`${prefix}_perm_purchase_entry`, perms.purchase_entry !== undefined ? perms.purchase_entry : perms.purchase);
            setVal(`${prefix}_perm_supplier_list`, perms.supplier_list !== undefined ? perms.supplier_list : perms.purchase);
            setVal(`${prefix}_perm_supplier_due`, perms.supplier_due !== undefined ? perms.supplier_due : perms.purchase);
            setVal(`${prefix}_perm_due_payment`, perms.due_payment !== undefined ? perms.due_payment : perms.purchase);

            setVal(`${prefix}_perm_customer_parent`, perms.customer);
            setVal(`${prefix}_perm_customer_list`, perms.customer_list !== undefined ? perms.customer_list : perms.customer);
            setVal(`${prefix}_perm_customer_due`, perms.customer_due !== undefined ? perms.customer_due : perms.customer);
            setVal(`${prefix}_perm_customer_due_collection`, perms.customer_due_collection !== undefined ? perms.customer_due_collection : perms.customer);

            setVal(`${prefix}_perm_expense_parent`, perms.expense);
            setVal(`${prefix}_perm_expense_list`, perms.expense_list !== undefined ? perms.expense_list : perms.expense);
            setVal(`${prefix}_perm_expense_category`, perms.expense_category !== undefined ? perms.expense_category : perms.expense);

            setVal(`${prefix}_perm_return_parent`, perms.return !== undefined ? perms.return : false);
            setVal(`${prefix}_perm_return_list`, perms.return_list !== undefined ? perms.return_list : perms.return);

            setVal(`${prefix}_perm_report_parent`, perms.report);
            setVal(`${prefix}_perm_daily_ledger`, perms.daily_ledger !== undefined ? perms.daily_ledger : perms.report);
            setVal(`${prefix}_perm_sales_report`, perms.sales_report !== undefined ? perms.sales_report : perms.report);
            setVal(`${prefix}_perm_income_expense_report`, perms.income_expense_report !== undefined ? perms.income_expense_report : perms.report);
            setVal(`${prefix}_perm_daily_receipt`, perms.daily_receipt !== undefined ? perms.daily_receipt : perms.report);
            setVal(`${prefix}_perm_personal_trans`, perms.personal_trans !== undefined ? perms.personal_trans : perms.report);
            setVal(`${prefix}_perm_low_stock`, perms.low_stock !== undefined ? perms.low_stock : perms.report);

            setVal(`${prefix}_perm_user_parent`, perms.user);
            setVal(`${prefix}_perm_user_role`, perms.user_role !== undefined ? perms.user_role : perms.user);
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
        let managers = users.filter(u => u.role === 'manager').length;
        let staff = users.filter(u => u.role === 'staff' || u.role === 'cashier' || u.role === 'users' || u.role === 'accountant').length;

        document.getElementById('adminCount').innerText = admins;
        document.getElementById('cashierCount').innerText = staff;
        document.getElementById('managerCount').innerText = managers;
    }

    function getRoleBadge(role) {
        switch(role) {
            case 'admin':
            case 'super_admin':
                return `<span class="user-role-badge role-admin"><i class="fa-solid fa-crown me-1"></i> Admin</span>`;
            case 'manager':
                return `<span class="user-role-badge role-manager"><i class="fa-solid fa-user-gear me-1"></i> Manager</span>`;
            case 'staff':
            case 'cashier':
            case 'users':
            case 'accountant':
                return `<span class="user-role-badge role-cashier"><i class="fa-solid fa-user me-1"></i> Staff</span>`;
            default:
                return `<span class="user-role-badge role-default"><i class="fa-solid fa-user me-1"></i> ${role}</span>`;
        }
    }

    function renderPermissionPills(perms, role) {
        if (!perms) {
            if (role === 'admin' || role === 'super_admin') {
                return `<span class="badge bg-success text-white px-2 py-1 me-1 mb-1">🟢 All Modules</span>`;
            }
            if (role === 'manager') {
                return `<span class="badge bg-primary text-white px-2 py-1 me-1 mb-1">🟢 Manager Access</span>`;
            }
            return `<span class="badge bg-success text-white px-2 py-1 me-1 mb-1">🟢 POS Only</span>`;
        }

        let html = '';
        if (perms.pos) html += `<span class="badge bg-success text-white px-2 py-1 me-1 mb-1">POS</span>`;
        if (perms.product) html += `<span class="badge bg-primary text-white px-2 py-1 me-1 mb-1">Product</span>`;
        if (perms.purchase) html += `<span class="badge bg-warning text-dark px-2 py-1 me-1 mb-1">Purchase</span>`;
        if (perms.customer) html += `<span class="badge bg-info text-white px-2 py-1 me-1 mb-1">Customer</span>`;
        if (perms.expense) html += `<span class="badge bg-danger text-white px-2 py-1 me-1 mb-1">Expenses</span>`;
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
            let statusText = rawStatus === 'approved' ? 'Approved' : 'Pending';
            let statusBadge = rawStatus === 'approved' 
                ? `<span class="user-status-badge status-approved">${statusText}</span>` 
                : `<span class="user-status-badge status-pending">${statusText}</span>`;

            let isSuperAdmin = (u.role === 'admin' || u.role === 'super_admin');
            let deleteBtnHtml = isSuperAdmin
                ? `<button type="button" disabled class="user-action-btn user-action-btn-delete" style="opacity: 0.35 !important; cursor: not-allowed !important; pointer-events: auto;" title="Admin cannot be deleted">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </button>`
                : `<button type="button" onclick="openDeleteUserModal(${u.id}, '${u.name.replace(/'/g, "\\'")}')" class="user-action-btn user-action-btn-delete" title="Delete User">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </button>`;

            // 1. Desktop Row
            tableHtml += `
                <tr>
                    <td class="ps-4 text-center font-bold text-slate-400" style="font-size: 12px;">${sl}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="${u.img_url}" class="rounded-circle border" style="width: 42px; height: 42px; object-fit: cover;" alt="${u.name}" onerror="this.src='/backend/assets/img/profile-img.png'">
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
                            ${deleteBtnHtml}
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
                        <img src="${u.img_url}" class="rounded-circle border" style="width: 42px; height: 42px; min-width: 42px; object-fit: cover;" alt="${u.name}" onerror="this.src='/backend/assets/img/profile-img.png'">
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
                        ${deleteBtnHtml}
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
            (u.email && u.email.toLowerCase().includes(q)) || 
            u.role.toLowerCase().includes(q)
        );
        renderUserTable(filtered);
    });

    // Create User Form Submit (supports file upload)
    document.getElementById('createUserForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        let saveBtn = document.getElementById('createUserSaveBtn');
        saveBtn.disabled = true;
        saveBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Saving...`;

        let formData = new FormData();
        formData.append('name', document.getElementById('new_name').value);
        formData.append('mobile', document.getElementById('new_mobile').value);
        formData.append('email', document.getElementById('new_email').value);
        formData.append('password', document.getElementById('new_password').value);
        formData.append('role', document.getElementById('new_role').value);
        formData.append('status', document.getElementById('new_status').value);
        formData.append('permissions', JSON.stringify(collectToggles('new')));

        const fileInput = document.getElementById('new_img_file');
        if (fileInput && fileInput.files && fileInput.files[0]) {
            formData.append('img', fileInput.files[0]);
        }

        try {
            const res = await axios.post('/create-user-admin', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
            if (res.data && res.data.status === 'success') {
                Swal.fire('সফল!', res.data.message, 'success');
                document.getElementById('createUserModalCloseBtn').click();
                resetCreateForm();
                loadAllUsers();
            } else {
                Swal.fire('ত্রুটি!', res.data.message || 'Could not create user.', 'error');
            }
        } catch (err) {
            let msg = err.response?.data?.message || 'ত্রুটি ঘটেছে। অনুগ্রহ করে তথ্য যাচাই করে পুনরায় চেষ্টা করুন।';
            Swal.fire('ত্রুটি!', msg, 'error');
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
        
        // Map role to 3 standard options: admin, manager, staff
        let roleVal = (u.role || 'staff').toLowerCase();
        if (roleVal === 'super_admin') roleVal = 'admin';
        if (roleVal === 'cashier' || roleVal === 'users' || roleVal === 'accountant') roleVal = 'staff';
        document.getElementById('edit_role').value = roleVal;
        
        document.getElementById('edit_status').value = u.status || 'approved';
        document.getElementById('edit_password').value = '';

        // Avatar preview
        const preview = document.getElementById('edit_avatar_preview');
        const icon = document.getElementById('edit_avatar_icon');
        if (u.img_url && !u.img_url.includes('profile-img.png') && !u.img_url.includes('default-avatar')) {
            preview.src = u.img_url;
            preview.classList.remove('d-none');
            if (icon) icon.classList.add('d-none');
        } else {
            preview.src = '';
            preview.classList.add('d-none');
            if (icon) icon.classList.remove('d-none');
        }

        setTogglesFromData('edit', u.permissions, roleVal);

        const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
        modal.show();
    }

    // Edit User Form Submit (supports file upload)
    document.getElementById('editUserForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        let saveBtn = document.getElementById('editUserSaveBtn');
        saveBtn.disabled = true;
        saveBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Updating...`;

        let formData = new FormData();
        formData.append('id', document.getElementById('edit_user_id').value);
        formData.append('name', document.getElementById('edit_name').value);
        formData.append('mobile', document.getElementById('edit_mobile').value);
        formData.append('email', document.getElementById('edit_email').value);
        formData.append('role', document.getElementById('edit_role').value);
        formData.append('status', document.getElementById('edit_status').value);
        const pwd = document.getElementById('edit_password').value;
        if (pwd) {
            formData.append('password', pwd);
        }
        formData.append('permissions', JSON.stringify(collectToggles('edit')));

        const fileInput = document.getElementById('edit_img_file');
        if (fileInput && fileInput.files && fileInput.files[0]) {
            formData.append('img', fileInput.files[0]);
        }

        try {
            const res = await axios.post('/update-user-role-status', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
            if (res.data && res.data.status === 'success') {
                Swal.fire('আপডেট হয়েছে!', res.data.message, 'success');
                document.getElementById('editUserModalCloseBtn').click();
                loadAllUsers();
            } else {
                Swal.fire('ত্রুটি!', res.data.message || 'Failed to update.', 'error');
            }
        } catch (err) {
            let msg = err.response?.data?.message || 'Error occurred. Please try again.';
            Swal.fire('ত্রুটি!', msg, 'error');
        } finally {
            saveBtn.disabled = false;
            saveBtn.innerHTML = `<i class="fa-solid fa-arrows-rotate me-1"></i> Update User`;
        }
    });

    // Open Delete User Modal
    function openDeleteUserModal(id, name) {
        let targetUser = allUsersData.find(u => u.id == id);
        if (targetUser && (targetUser.role === 'admin' || targetUser.role === 'super_admin')) {
            if (typeof errorToast === 'function') {
                errorToast("Admin cannot be deleted!");
            } else {
                Swal.fire('সতর্কতা', 'Admin cannot be deleted!', 'warning');
            }
            return;
        }

        document.getElementById('deleteUserID').value = id;
        document.getElementById('deleteUserNameText').innerText = `"${name}"`;

        const modalEl = document.getElementById('deleteUserModal');
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            let bsModal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            bsModal.show();
        } else if (typeof $ !== 'undefined' && $.fn.modal) {
            $('#deleteUserModal').modal('show');
        } else if (modalEl) {
            modalEl.classList.add('show');
            modalEl.style.display = 'flex';
        }
    }

    function closeDeleteUserModal() {
        const modalEl = document.getElementById('deleteUserModal');
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            let bsModal = bootstrap.Modal.getInstance(modalEl);
            if (bsModal) bsModal.hide();
        }
        if (typeof $ !== 'undefined' && $.fn.modal) {
            $('#deleteUserModal').modal('hide');
        }
        if (modalEl) {
            modalEl.classList.remove('show');
            modalEl.style.display = 'none';
        }
    }

    function deleteUser(id, name) {
        openDeleteUserModal(id, name);
    }

    // Confirm Delete User
    async function confirmDeleteUser() {
        const id = document.getElementById('deleteUserID').value;
        if (!id) return;

        let targetUser = allUsersData.find(u => u.id == id);
        if (targetUser && (targetUser.role === 'admin' || targetUser.role === 'super_admin')) {
            if (typeof errorToast === 'function') {
                errorToast("Admin cannot be deleted!");
            } else {
                Swal.fire('সতর্কতা', 'Admin cannot be deleted!', 'warning');
            }
            closeDeleteUserModal();
            return;
        }

        const deleteBtn = document.getElementById('confirmDeleteUserBtn');
        const originalBtnHtml = deleteBtn ? deleteBtn.innerHTML : 'Yes, Delete';
        if (deleteBtn) {
            deleteBtn.disabled = true;
            deleteBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Deleting...`;
        }

        try {
            const res = await axios.post('/delete-user-admin', { id: id });
            if (res.data && res.data.status === 'success') {
                closeDeleteUserModal();
                if (typeof successToast === 'function') {
                    successToast(res.data.message || 'User deleted successfully.');
                } else {
                    Swal.fire('Deleted!', res.data.message, 'success');
                }
                loadAllUsers();
            } else {
                if (typeof errorToast === 'function') {
                    errorToast(res.data.message || 'Could not delete user.');
                } else {
                    Swal.fire('Error!', res.data.message || 'Could not delete user.', 'error');
                }
            }
        } catch (err) {
            let msg = err.response?.data?.message || 'Error occurred while deleting user.';
            if (typeof errorToast === 'function') {
                errorToast(msg);
            } else {
                Swal.fire('Error!', msg, 'error');
            }
        } finally {
            if (deleteBtn) {
                deleteBtn.disabled = false;
                deleteBtn.innerHTML = originalBtnHtml;
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        loadAllUsers();
        applyRolePresets('new', 'staff');
    });
</script>
