<div class="main-content">
    <div class="page-content">
        <div class="w-full">

            <!-- ── Page Header ── -->
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="activity-page-icon-badge shadow-xs">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-slate-800 dark:text-white" style="font-size: 20px; letter-spacing: -0.3px;">User Activity Logs & History</h4>
                        <p class="text-muted mb-0 text-xs text-slate-500 dark:text-slate-400">
                            Real-time audit trail of user logins, logouts, sales, and system changes
                        </p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold shadow-xs hover:bg-slate-100 dark:hover:bg-slate-800 transition-all" onclick="fetchActivityLogs(1)" title="Refresh Logs">
                        <i class="fa-solid fa-rotate text-emerald-600"></i>
                        <span class="text-slate-700 dark:text-slate-200">Refresh</span>
                    </button>
                    <button type="button" id="clearAllLogsBtn" class="btn btn-outline-danger d-flex align-items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold shadow-xs transition-all" style="display: none;" onclick="openClearLogsModal()" title="Super Admin Only">
                        <i class="fa-solid fa-trash-can"></i>
                        <span>Clear All Logs</span>
                    </button>
                </div>
            </div>

            <!-- ── 4 Top Stat Cards (Matching Reference Image) ── -->
            <div class="row g-3 mb-4">
                <!-- 1. Total Recorded Logs -->
                <div class="col-6 col-lg-3">
                    <div class="activity-metric-card activity-metric-card--total shadow-xs h-100">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="activity-metric-title">TOTAL RECORDED LOGS</span>
                            <div class="activity-metric-icon activity-metric-icon--pulse">
                                <i class="fa-solid fa-wave-square"></i>
                            </div>
                        </div>
                        <h3 class="activity-metric-value text-slate-800 dark:text-white" id="statTotalLogs">0</h3>
                    </div>
                </div>

                <!-- 2. Page Logins & Sessions -->
                <div class="col-6 col-lg-3">
                    <div class="activity-metric-card activity-metric-card--sessions shadow-xs h-100">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="activity-metric-title">PAGE LOGINS & SESSIONS</span>
                            <div class="activity-metric-icon activity-metric-icon--user">
                                <i class="fa-solid fa-user-check"></i>
                            </div>
                        </div>
                        <h3 class="activity-metric-value text-slate-800 dark:text-white" id="statLoginsSessions">0</h3>
                    </div>
                </div>

                <!-- 3. Data Modifications -->
                <div class="col-6 col-lg-3">
                    <div class="activity-metric-card activity-metric-card--mods shadow-xs h-100">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="activity-metric-title">DATA MODIFICATIONS</span>
                            <div class="activity-metric-icon activity-metric-icon--layers">
                                <i class="fa-solid fa-layer-group"></i>
                            </div>
                        </div>
                        <h3 class="activity-metric-value text-slate-800 dark:text-white" id="statDataModifications">0</h3>
                    </div>
                </div>

                <!-- 4. Registered Users -->
                <div class="col-6 col-lg-3">
                    <div class="activity-metric-card activity-metric-card--users shadow-xs h-100">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="activity-metric-title">REGISTERED USERS</span>
                            <div class="activity-metric-icon activity-metric-icon--shield">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                        </div>
                        <h3 class="activity-metric-value text-slate-800 dark:text-white" id="statRegisteredUsers">0</h3>
                    </div>
                </div>
            </div>

            <!-- ── Custom Filter Toolbar (Matching Reference Images 1, 2, 3, 4) ── -->
            <div class="activity-filter-toolbar-card shadow-xs mb-4">
                <!-- Live Search Bar -->
                <div class="activity-search-field-wrap">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    <input type="text" id="activitySearchInput" placeholder="Search user, action, description..." oninput="debounceSearch()" autocomplete="off" />
                    <button type="button" class="search-clear-btn" id="searchClearBtn" onclick="clearSearchInput()" style="display: none;">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Custom Dropdown 1: All System Users -->
                <div class="custom-dd-wrapper" id="userCustomDropdown">
                    <button type="button" class="custom-dd-btn" onclick="toggleCustomDropdown('userCustomDropdown')">
                        <i class="fa-solid fa-user dd-icon-lead"></i>
                        <span class="dd-btn-label" id="userSelectedLabel">All System Users</span>
                        <i class="fa-solid fa-chevron-down dd-chevron"></i>
                    </button>
                    <div class="custom-dd-popover shadow-lg">
                        <div class="custom-dd-search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="userSearchInMenu" placeholder="Search..." oninput="filterDropdownOptions('userCustomDropdown', this.value)" autocomplete="off" />
                        </div>
                        <div class="custom-dd-options-list" id="userOptionsList">
                            <div class="custom-dd-option active" data-val="all" onclick="selectDropdownOption('userCustomDropdown', 'all', 'All System Users')">
                                <span class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-users text-slate-400"></i> All System Users
                                </span>
                                <i class="fa-solid fa-check check-icon"></i>
                            </div>
                            <!-- Dynamic User items -->
                        </div>
                    </div>
                </div>

                <!-- Custom Dropdown 2: All Actions -->
                <div class="custom-dd-wrapper" id="actionCustomDropdown">
                    <button type="button" class="custom-dd-btn" onclick="toggleCustomDropdown('actionCustomDropdown')">
                        <i class="fa-solid fa-bolt dd-icon-lead"></i>
                        <span class="dd-btn-label" id="actionSelectedLabel">All Actions</span>
                        <i class="fa-solid fa-chevron-down dd-chevron"></i>
                    </button>
                    <div class="custom-dd-popover shadow-lg">
                        <div class="custom-dd-search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="actionSearchInMenu" placeholder="Search..." oninput="filterDropdownOptions('actionCustomDropdown', this.value)" autocomplete="off" />
                        </div>
                        <div class="custom-dd-options-list" id="actionOptionsList">
                            <div class="custom-dd-option active" data-val="all" onclick="selectDropdownOption('actionCustomDropdown', 'all', 'All Actions')">
                                <span class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-bolt text-slate-400"></i> All Actions
                                </span>
                                <i class="fa-solid fa-check check-icon"></i>
                            </div>
                            <!-- Dynamic Action items -->
                        </div>
                    </div>
                </div>

                <!-- Custom Dropdown 3: All Modules -->
                <div class="custom-dd-wrapper" id="moduleCustomDropdown">
                    <button type="button" class="custom-dd-btn" onclick="toggleCustomDropdown('moduleCustomDropdown')">
                        <i class="fa-solid fa-cube dd-icon-lead"></i>
                        <span class="dd-btn-label" id="moduleSelectedLabel">All Modules</span>
                        <i class="fa-solid fa-chevron-down dd-chevron"></i>
                    </button>
                    <div class="custom-dd-popover shadow-lg">
                        <div class="custom-dd-search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="moduleSearchInMenu" placeholder="Search..." oninput="filterDropdownOptions('moduleCustomDropdown', this.value)" autocomplete="off" />
                        </div>
                        <div class="custom-dd-options-list" id="moduleOptionsList">
                            <div class="custom-dd-option active" data-val="all" onclick="selectDropdownOption('moduleCustomDropdown', 'all', 'All Modules')">
                                <span class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-cube text-slate-400"></i> All Modules
                                </span>
                                <i class="fa-solid fa-check check-icon"></i>
                            </div>
                            <!-- Dynamic Module items -->
                        </div>
                    </div>
                </div>

                <!-- Solid Filter Button -->
                <button type="button" class="btn-activity-submit-filter" onclick="fetchActivityLogs(1)">
                    Filter
                </button>
                <button type="button" class="btn-activity-reset-filter" onclick="resetAllFilters()" title="Reset Filters">
                    <i class="fa-solid fa-rotate-left"></i>
                </button>
            </div>

            <!-- ── Main Data Card / Table Container ── -->
            <div class="activity-table-container shadow-xs mb-4">
                <!-- Desktop Table View -->
                <div id="activityDesktopTableWrapper" class="table-responsive">
                    <table class="table table-hover align-middle mb-0 activity-main-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 45px;">#</th>
                                <th style="min-width: 200px;">USER</th>
                                <th class="text-center" style="width: 130px;">ROLE</th>
                                <th class="text-center" style="width: 140px;">ACTION</th>
                                <th class="text-center" style="width: 130px;">MODULE</th>
                                <th style="min-width: 250px;">ACTIVITY DESCRIPTION</th>
                                <th class="text-end" style="width: 180px;">DATE &amp; TIME</th>
                            </tr>
                        </thead>
                        <tbody id="activityTableBody">
                            <tr>
                                <td colspan="7" class="text-center py-5 text-slate-400">
                                    <div class="spinner-border spinner-border-sm text-emerald-600 me-2" role="status"></div>
                                    <span>Loading activity logs...</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card Box View (Responsive for Mobile Screens) -->
                <div id="activityMobileList" class="p-3">
                    <!-- Populated dynamically via JS -->
                </div>

                <!-- Table Footer & Pagination -->
                <div class="p-3 border-top border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3 text-xs text-slate-600 dark:text-slate-300">
                    <div class="d-flex align-items-center gap-2">
                        <span>Show</span>
                        <select id="activityPerPage" class="form-select form-select-sm w-auto rounded-lg" onchange="fetchActivityLogs(1)">
                            <option value="15">15</option>
                            <option value="25" selected>25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span>entries</span>
                        <span class="ms-2 text-slate-400" id="activityPaginationInfo">Showing 0 to 0 of 0 entries</span>
                    </div>
                    <div class="pagination-wrapper">
                        <ul class="pagination pagination-sm mb-0 gap-1" id="activityPaginationList">
                            <!-- Populated via JS -->
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ── Clear All History Confirmation Modal (Strictly Super Admin Only) ── -->
<div class="modal fade" id="clearAllLogsModal" tabindex="-1" aria-labelledby="clearAllLogsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 18px; overflow: hidden;">
            <div class="modal-header border-0 bg-danger text-white py-3 px-4" style="background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);">
                <h5 class="modal-title fw-bold fs-6 d-flex align-items-center gap-2" id="clearAllLogsModalLabel">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Confirm Clear All History</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div style="width: 58px; height: 58px; border-radius: 50%; font-size: 26px; display: flex; align-items: center; justify-content: center; background: #fee2e2; color: #dc2626; margin: 0 auto 16px;">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <h6 class="fw-bold text-slate-800 dark:text-white mb-2">Are you sure you want to delete all activity logs?</h6>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">
                    This action will permanently wipe all user activity records, audit history, and login logs from the database.
                    <br><strong class="text-danger">This action cannot be undone!</strong>
                </p>
                <div class="p-2.5 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 text-start text-[11px] text-amber-800 dark:text-amber-300">
                    <i class="fa-solid fa-shield-halved me-1"></i>
                    <strong>Super Admin Exclusive:</strong> This command is only permitted for Super Administrators and will record a permanent security event.
                </div>
            </div>
            <div class="modal-footer border-0 bg-slate-50 dark:bg-slate-800/50 py-3 px-4 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-light border px-3 py-2 rounded-xl text-xs font-semibold" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmClearBtn" class="btn btn-danger px-3 py-2 rounded-xl text-xs font-bold text-white shadow-xs" style="background: #dc2626; border: none;" onclick="executeClearAllLogs()">
                    <i class="fa-solid fa-trash-can me-1"></i> Yes, Clear All Logs
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* ── Page Header Icon ── */
    .activity-page-icon-badge {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        flex-shrink: 0;
    }

    /* ── Metric Stat Cards (Matching Reference Layout) ── */
    .activity-metric-card {
        border-radius: 16px !important;
        padding: 16px 20px !important;
        border: 1.5px solid transparent;
        transition: all 0.2s ease;
        background: #ffffff;
    }
    .activity-metric-card:hover {
        transform: translateY(-2px);
    }
    .activity-metric-card--total {
        background: #f0fdf4;
        border-color: #bbf7d0;
    }
    .activity-metric-card--sessions {
        background: #f0f9ff;
        border-color: #bae6fd;
    }
    .activity-metric-card--mods {
        background: #fffbeb;
        border-color: #fde68a;
    }
    .activity-metric-card--users {
        background: #fff1f2;
        border-color: #fecdd3;
    }

    .activity-metric-title {
        font-size: 10.5px;
        font-weight: 800;
        letter-spacing: 0.6px;
        color: #475569;
        text-transform: uppercase;
    }
    .activity-metric-card--total .activity-metric-title { color: #15803d; }
    .activity-metric-card--sessions .activity-metric-title { color: #0284c7; }
    .activity-metric-card--mods .activity-metric-title { color: #b45309; }
    .activity-metric-card--users .activity-metric-title { color: #be123c; }

    .activity-metric-value {
        font-size: 28px;
        font-weight: 900;
        line-height: 1;
        margin: 0;
        letter-spacing: -0.5px;
    }
    .activity-metric-card--total .activity-metric-value { color: #166534; }
    .activity-metric-card--sessions .activity-metric-value { color: #0369a1; }
    .activity-metric-card--mods .activity-metric-value { color: #92400e; }
    .activity-metric-card--users .activity-metric-value { color: #9f1239; }

    .activity-metric-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13.5px;
    }
    .activity-metric-icon--pulse { background: #ffe4e6; color: #e11d48; }
    .activity-metric-icon--user  { background: #e0f2fe; color: #0284c7; }
    .activity-metric-icon--layers{ background: #fef3c7; color: #d97706; }
    .activity-metric-icon--shield{ background: #ffe4e6; color: #e11d48; }

    /* ── Custom Filter Toolbar (Images 1, 2, 3, 4) ── */
    .activity-filter-toolbar-card {
        border-radius: 16px !important;
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .activity-search-field-wrap {
        flex: 1 1 240px;
        position: relative;
        display: flex;
        align-items: center;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        padding: 0 12px;
        height: 42px;
        transition: all 0.2s ease;
    }
    .activity-search-field-wrap:focus-within {
        border-color: #15803d;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.12);
    }
    .activity-search-field-wrap .search-icon {
        color: #94a3b8;
        font-size: 13px;
        margin-right: 8px;
    }
    .activity-search-field-wrap input {
        width: 100%;
        border: none;
        outline: none;
        background: transparent;
        font-size: 13px;
        color: #1e293b;
    }
    .activity-search-field-wrap input::placeholder {
        color: #94a3b8;
    }
    .search-clear-btn {
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 2px 6px;
        font-size: 12px;
    }
    .search-clear-btn:hover { color: #ef4444; }

    /* ── Custom Searchable Dropdown ── */
    .custom-dd-wrapper {
        position: relative;
        flex: 0 0 auto;
    }
    .custom-dd-btn {
        height: 42px;
        padding: 0 14px;
        border-radius: 12px;
        border: 1.5px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
        user-select: none;
    }
    .custom-dd-btn:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }
    .custom-dd-wrapper.is-open .custom-dd-btn {
        border-color: #15803d;
        color: #15803d;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.12);
    }
    .custom-dd-wrapper.is-open .dd-chevron {
        transform: rotate(180deg);
    }
    .dd-icon-lead {
        font-size: 13px;
        color: #64748b;
    }
    .custom-dd-wrapper.is-open .dd-icon-lead {
        color: #15803d;
    }
    .dd-chevron {
        font-size: 10px;
        color: #94a3b8;
        margin-left: 2px;
        transition: transform 0.2s ease;
    }

    .custom-dd-popover {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        min-width: 240px;
        max-width: 320px;
        background: #ffffff;
        border-radius: 14px;
        border: 1.5px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        z-index: 1050;
        display: none;
        flex-direction: column;
        overflow: hidden;
        animation: ddFadeDown 0.15s ease-out forwards;
    }
    @keyframes ddFadeDown {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .custom-dd-wrapper.is-open .custom-dd-popover {
        display: flex;
    }

    .custom-dd-search-box {
        padding: 8px 10px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f8fafc;
    }
    .custom-dd-search-box i {
        font-size: 12px;
        color: #94a3b8;
    }
    .custom-dd-search-box input {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 5px 8px;
        font-size: 12px;
        outline: none;
        background: #ffffff;
    }
    .custom-dd-search-box input:focus {
        border-color: #15803d;
    }

    .custom-dd-options-list {
        max-height: 250px;
        overflow-y: auto;
        padding: 4px;
    }
    .custom-dd-option {
        padding: 8px 12px;
        border-radius: 9px;
        font-size: 12.5px;
        color: #334155;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        cursor: pointer;
        transition: all 0.15s ease;
        margin-bottom: 2px;
    }
    .custom-dd-option:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .custom-dd-option.active {
        background: #15803d !important;
        color: #ffffff !important;
        font-weight: 700;
    }
    .custom-dd-option.active i {
        color: #ffffff !important;
    }
    .custom-dd-option .check-icon {
        font-size: 12px;
        display: none;
    }
    .custom-dd-option.active .check-icon {
        display: inline-block;
    }

    /* Submit / Reset buttons */
    .btn-activity-submit-filter {
        height: 42px;
        padding: 0 24px;
        border-radius: 12px;
        background: #15803d;
        color: #ffffff;
        border: none;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(21, 128, 61, 0.25);
    }
    .btn-activity-submit-filter:hover {
        background: #166534;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(21, 128, 61, 0.35);
    }
    .btn-activity-reset-filter {
        height: 42px;
        width: 42px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-activity-reset-filter:hover {
        background: #fee2e2;
        border-color: #fca5a5;
        color: #dc2626;
    }

    /* ── Main Data Table ── */
    .activity-table-container {
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 16px !important;
        overflow: hidden !important;
        background-color: #ffffff;
    }
    .activity-main-table thead tr {
        background-color: #15803d !important;
    }
    .activity-main-table thead th {
        background-color: #15803d !important;
        color: #ffffff !important;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 13px 14px;
        border-bottom: none !important;
        white-space: nowrap;
    }
    .activity-main-table tbody td {
        padding: 12px 14px;
        font-size: 12.5px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }
    .activity-main-table tbody tr:hover {
        background-color: #f8fafc;
    }

    /* ── Action Badges (Matching Reference Images) ── */
    .badge-act {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3.5px 10px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .badge-act--delete      { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }
    .badge-act--update      { background: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
    .badge-act--due_collection { background: #cffafe; color: #0891b2; border: 1px solid #a5f3fc; }
    .badge-act--due_payment { background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; }
    .badge-act--create      { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; }
    .badge-act--login       { background: #dbeafe; color: #2563eb; border: 1px solid #bfdbfe; }
    .badge-act--logout      { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
    .badge-act--sale        { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .badge-act--purchase    { background: #f3e8ff; color: #7c3aed; border: 1px solid #ddd6fe; }
    .badge-act--return      { background: #ffe4e6; color: #e11d48; border: 1px solid #fecdd3; }
    .badge-act--status_change{ background: #ffedd5; color: #ea580c; border: 1px solid #fed7aa; }
    .badge-act--clear_logs  { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
    .badge-act--default     { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }

    /* ── Role Badges ── */
    .badge-user-role {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }
    .badge-user-role--super {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        color: #ffffff;
        box-shadow: 0 1px 3px rgba(234, 88, 12, 0.35);
    }
    .badge-user-role--admin {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #ffffff;
        box-shadow: 0 1px 3px rgba(220, 38, 38, 0.35);
    }
    .badge-user-role--manager {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }
    .badge-user-role--staff {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }
    .badge-user-role--default {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .badge-module-pill {
        display: inline-block;
        padding: 3px 9px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    /* ── Mobile Box View ── */
    #activityDesktopTableWrapper { display: block; }
    #activityMobileList { display: none; }

    @media (max-width: 991.98px) {
        .custom-dd-wrapper {
            flex: 1 1 calc(50% - 6px);
        }
        .custom-dd-btn {
            width: 100%;
            justify-content: space-between;
        }
        .custom-dd-popover {
            width: 100%;
            max-width: 100%;
        }
    }

    @media (max-width: 767.98px) {
        #activityDesktopTableWrapper { display: none !important; }
        #activityMobileList {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
        }
        .activity-mobile-card {
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 14px !important;
            background-color: #ffffff;
            padding: 14px;
            transition: all 0.2s ease;
        }
        .activity-mobile-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .activity-metric-card {
            padding: 12px 14px !important;
            border-radius: 14px !important;
        }
        .activity-metric-title { font-size: 9.5px !important; }
        .activity-metric-value { font-size: 22px !important; }
        .custom-dd-wrapper {
            flex: 1 1 100%;
        }
        .btn-activity-submit-filter {
            flex: 1 1 auto;
        }
    }

    /* ── Dark Mode ── */
    body[light-mode="dark"] .activity-metric-card,
    body[data-layout-mode="dark"] .activity-metric-card,
    html.dark .activity-metric-card,
    body.dark-mode .activity-metric-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .activity-filter-toolbar-card,
    body[data-layout-mode="dark"] .activity-filter-toolbar-card,
    html.dark .activity-filter-toolbar-card,
    body.dark-mode .activity-filter-toolbar-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .activity-search-field-wrap,
    body[data-layout-mode="dark"] .activity-search-field-wrap,
    html.dark .activity-search-field-wrap,
    body.dark-mode .activity-search-field-wrap {
        background: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .activity-search-field-wrap input,
    body[data-layout-mode="dark"] .activity-search-field-wrap input,
    html.dark .activity-search-field-wrap input,
    body.dark-mode .activity-search-field-wrap input {
        color: #f1f5f9 !important;
    }
    body[light-mode="dark"] .custom-dd-btn,
    body[data-layout-mode="dark"] .custom-dd-btn,
    html.dark .custom-dd-btn,
    body.dark-mode .custom-dd-btn {
        background: #0f172a !important;
        border-color: #334155 !important;
        color: #e2e8f0 !important;
    }
    body[light-mode="dark"] .custom-dd-popover,
    body[data-layout-mode="dark"] .custom-dd-popover,
    html.dark .custom-dd-popover,
    body.dark-mode .custom-dd-popover {
        background: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .custom-dd-search-box,
    body[data-layout-mode="dark"] .custom-dd-search-box,
    html.dark .custom-dd-search-box,
    body.dark-mode .custom-dd-search-box {
        background: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .custom-dd-search-box input,
    body[data-layout-mode="dark"] .custom-dd-search-box input,
    html.dark .custom-dd-search-box input,
    body.dark-mode .custom-dd-search-box input {
        background: #1e293b !important;
        border-color: #475569 !important;
        color: #f1f5f9 !important;
    }
    body[light-mode="dark"] .custom-dd-option,
    body[data-layout-mode="dark"] .custom-dd-option,
    html.dark .custom-dd-option,
    body.dark-mode .custom-dd-option {
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .custom-dd-option:hover,
    body[data-layout-mode="dark"] .custom-dd-option:hover,
    html.dark .custom-dd-option:hover,
    body.dark-mode .custom-dd-option:hover {
        background: #334155 !important;
    }
    body[light-mode="dark"] .activity-table-container,
    body[data-layout-mode="dark"] .activity-table-container,
    html.dark .activity-table-container,
    body.dark-mode .activity-table-container {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .activity-main-table tbody td,
    body[data-layout-mode="dark"] .activity-main-table tbody td,
    html.dark .activity-main-table tbody td,
    body.dark-mode .activity-main-table tbody td {
        border-bottom-color: #1e293b !important;
        color: #e2e8f0 !important;
    }
    body[light-mode="dark"] .activity-main-table tbody tr:hover,
    body[data-layout-mode="dark"] .activity-main-table tbody tr:hover,
    html.dark .activity-main-table tbody tr:hover,
    body.dark-mode .activity-main-table tbody tr:hover {
        background-color: #1e293b !important;
    }
    body[light-mode="dark"] .activity-mobile-card,
    body[data-layout-mode="dark"] .activity-mobile-card,
    html.dark .activity-mobile-card,
    body.dark-mode .activity-mobile-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
</style>

<script>
    let currentLogsPage = 1;
    let searchDebounceTimer = null;
    let isSuperAdminUser = false;

    // Filter states
    const currentFilters = {
        user_id: 'all',
        action: 'all',
        module: 'all'
    };

    document.addEventListener('DOMContentLoaded', function () {
        fetchActivityLogs(1);

        // Close dropdowns on outside click
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.custom-dd-wrapper')) {
                closeAllCustomDropdowns();
            }
        });
    });

    // ── Dropdown Control ──
    function toggleCustomDropdown(dropdownId) {
        const el = document.getElementById(dropdownId);
        if (!el) return;
        const wasOpen = el.classList.contains('is-open');
        closeAllCustomDropdowns();
        if (!wasOpen) {
            el.classList.add('is-open');
            // Focus internal search input
            const searchInput = el.querySelector('.custom-dd-search-box input');
            if (searchInput) {
                searchInput.value = '';
                filterDropdownOptions(dropdownId, '');
                setTimeout(() => searchInput.focus(), 50);
            }
        }
    }

    function closeAllCustomDropdowns() {
        document.querySelectorAll('.custom-dd-wrapper.is-open').forEach(el => {
            el.classList.remove('is-open');
        });
    }

    function filterDropdownOptions(dropdownId, query) {
        const q = (query || '').toLowerCase().trim();
        const wrapper = document.getElementById(dropdownId);
        if (!wrapper) return;
        const options = wrapper.querySelectorAll('.custom-dd-option');
        options.forEach(opt => {
            const text = opt.innerText.toLowerCase();
            if (!q || text.includes(q)) {
                opt.style.display = 'flex';
            } else {
                opt.style.display = 'none';
            }
        });
    }

    function selectDropdownOption(dropdownId, value, label) {
        if (dropdownId === 'userCustomDropdown') {
            currentFilters.user_id = value;
            document.getElementById('userSelectedLabel').innerText = label;
        } else if (dropdownId === 'actionCustomDropdown') {
            currentFilters.action = value;
            document.getElementById('actionSelectedLabel').innerText = label;
        } else if (dropdownId === 'moduleCustomDropdown') {
            currentFilters.module = value;
            document.getElementById('moduleSelectedLabel').innerText = label;
        }

        // Highlight active option
        const wrapper = document.getElementById(dropdownId);
        if (wrapper) {
            wrapper.querySelectorAll('.custom-dd-option').forEach(opt => {
                if (opt.getAttribute('data-val') === String(value)) {
                    opt.classList.add('active');
                } else {
                    opt.classList.remove('active');
                }
            });
        }

        closeAllCustomDropdowns();
        fetchActivityLogs(1);
    }

    function debounceSearch() {
        const val = document.getElementById('activitySearchInput').value.trim();
        const clearBtn = document.getElementById('searchClearBtn');
        if (clearBtn) {
            clearBtn.style.display = val.length > 0 ? 'inline-block' : 'none';
        }

        clearTimeout(searchDebounceTimer);
        searchDebounceTimer = setTimeout(function () {
            fetchActivityLogs(1);
        }, 350);
    }

    function clearSearchInput() {
        document.getElementById('activitySearchInput').value = '';
        const clearBtn = document.getElementById('searchClearBtn');
        if (clearBtn) clearBtn.style.display = 'none';
        fetchActivityLogs(1);
    }

    function resetAllFilters() {
        document.getElementById('activitySearchInput').value = '';
        const clearBtn = document.getElementById('searchClearBtn');
        if (clearBtn) clearBtn.style.display = 'none';

        currentFilters.user_id = 'all';
        currentFilters.action = 'all';
        currentFilters.module = 'all';

        document.getElementById('userSelectedLabel').innerText = 'All System Users';
        document.getElementById('actionSelectedLabel').innerText = 'All Actions';
        document.getElementById('moduleSelectedLabel').innerText = 'All Modules';

        // Reset active markers
        document.querySelectorAll('.custom-dd-option').forEach(opt => {
            if (opt.getAttribute('data-val') === 'all') {
                opt.classList.add('active');
            } else {
                opt.classList.remove('active');
            }
        });

        fetchActivityLogs(1);
    }

    // ── Fetch Activity Logs from Backend ──
    async function fetchActivityLogs(page = 1) {
        currentLogsPage = page;
        const tbody = $('#activityTableBody');
        const mobileList = $('#activityMobileList');

        tbody.html(`
            <tr>
                <td colspan="7" class="text-center py-5 text-slate-400">
                    <div class="spinner-border spinner-border-sm text-emerald-600 me-2" role="status"></div>
                    <span>Loading user activity logs...</span>
                </td>
            </tr>
        `);
        mobileList.html(`
            <div class="text-center py-5 text-slate-400">
                <div class="spinner-border spinner-border-sm text-emerald-600 me-2" role="status"></div>
                <span>Loading activity logs...</span>
            </div>
        `);

        try {
            const params = {
                page: page,
                per_page: document.getElementById('activityPerPage').value || 25,
                search: document.getElementById('activitySearchInput').value.trim(),
                user_id: currentFilters.user_id,
                action: currentFilters.action,
                module: currentFilters.module,
            };

            const res = await axios.get('/get-user-activity-logs', {
                params: params,
                ...HeaderToken()
            });

            if (res.data && res.data.status === 'success') {
                const data = res.data.data;
                const logs = data.logs || [];
                const metrics = data.metrics || {};
                const pagination = data.pagination || {};
                const currentUser = data.current_user || {};

                // Super admin check for clear button
                isSuperAdminUser = !!currentUser.is_super_admin;
                const clearBtn = document.getElementById('clearAllLogsBtn');
                if (clearBtn) {
                    clearBtn.style.display = isSuperAdminUser ? 'inline-flex' : 'none';
                }

                // Update metric stat cards (Image 1 convention)
                $('#statTotalLogs').text(metrics.total_logs ?? 0);
                $('#statLoginsSessions').text(metrics.logins_sessions ?? 0);
                $('#statDataModifications').text(metrics.data_modifications ?? 0);
                $('#statRegisteredUsers').text(metrics.registered_users ?? 0);

                // Populate custom dropdown options once
                populateDropdowns(data.users_list || [], data.actions_list || [], data.modules_list || []);

                // Render table and mobile view
                renderActivityLogs(logs, pagination);
                renderPagination(pagination);
            } else {
                tbody.html(`<tr><td colspan="7" class="text-center py-4 text-danger">${res.data.message || 'Failed to load logs'}</td></tr>`);
                mobileList.html(`<div class="text-center py-4 text-danger">${res.data.message || 'Failed to load logs'}</div>`);
            }
        } catch (err) {
            console.error('Activity logs fetch error:', err);
            const msg = err.response?.data?.message || err.message || 'Error loading activity logs';
            tbody.html(`<tr><td colspan="7" class="text-center py-4 text-danger"><i class="fa-solid fa-triangle-exclamation me-1"></i>${msg}</td></tr>`);
            mobileList.html(`<div class="text-center py-4 text-danger"><i class="fa-solid fa-triangle-exclamation me-1"></i>${msg}</div>`);
        }
    }

    // ── Populate Custom Searchable Dropdown Options ──
    let dropdownsPopulated = false;
    function populateDropdowns(users, actions, modules) {
        if (dropdownsPopulated) return;
        dropdownsPopulated = true;

        // 1. Users Dropdown
        const userListEl = document.getElementById('userOptionsList');
        if (userListEl && users.length > 0) {
            users.forEach(u => {
                const opt = document.createElement('div');
                opt.className = 'custom-dd-option';
                opt.setAttribute('data-val', u.id);
                opt.onclick = () => selectDropdownOption('userCustomDropdown', u.id, u.name);

                const avatarLetter = (u.name || 'U').charAt(0).toUpperCase();
                opt.innerHTML = `
                    <div class="d-flex align-items-center gap-2 min-w-0">
                        <div style="width: 24px; height: 24px; border-radius: 50%; background: #e0f2fe; color: #0284c7; font-size: 11px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            ${avatarLetter}
                        </div>
                        <div class="truncate text-start">
                            <div class="font-bold text-xs truncate" style="max-width: 180px;">${escapeHtml(u.name)}</div>
                            <div class="text-[10px] text-slate-400 truncate" style="max-width: 180px;">${escapeHtml(u.email || u.role || '')}</div>
                        </div>
                    </div>
                    <i class="fa-solid fa-check check-icon"></i>
                `;
                userListEl.appendChild(opt);
            });
        }

        // 2. Actions Dropdown
        const actionListEl = document.getElementById('actionOptionsList');
        if (actionListEl && actions.length > 0) {
            actions.forEach(a => {
                if (a.key === 'all') return;
                const opt = document.createElement('div');
                opt.className = 'custom-dd-option';
                opt.setAttribute('data-val', a.key);
                opt.onclick = () => selectDropdownOption('actionCustomDropdown', a.key, a.label);
                opt.innerHTML = `
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid ${a.icon || 'fa-bolt'} text-slate-400" style="font-size: 11px; width: 14px;"></i>
                        <span>${a.label}</span>
                    </span>
                    <i class="fa-solid fa-check check-icon"></i>
                `;
                actionListEl.appendChild(opt);
            });
        }

        // 3. Modules Dropdown
        const moduleListEl = document.getElementById('moduleOptionsList');
        if (moduleListEl && modules.length > 0) {
            modules.forEach(m => {
                if (m.key === 'all') return;
                const opt = document.createElement('div');
                opt.className = 'custom-dd-option';
                opt.setAttribute('data-val', m.key);
                opt.onclick = () => selectDropdownOption('moduleCustomDropdown', m.key, m.label);
                opt.innerHTML = `
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid ${m.icon || 'fa-cube'} text-slate-400" style="font-size: 11px; width: 14px;"></i>
                        <span>${m.label}</span>
                    </span>
                    <i class="fa-solid fa-check check-icon"></i>
                `;
                moduleListEl.appendChild(opt);
            });
        }
    }

    // ── Badges ──
    function getActionBadgeHtml(action) {
        const act = (action || '').toUpperCase().trim();
        let cls = 'badge-act--default';

        if (act.includes('DELETE')) cls = 'badge-act--delete';
        else if (act.includes('UPDATE')) cls = 'badge-act--update';
        else if (act.includes('DUE_COLLECTION')) cls = 'badge-act--due_collection';
        else if (act.includes('DUE_PAYMENT') || act.includes('PAYMENT')) cls = 'badge-act--due_payment';
        else if (act.includes('CREATE')) cls = 'badge-act--create';
        else if (act.includes('LOGIN')) cls = 'badge-act--login';
        else if (act.includes('LOGOUT')) cls = 'badge-act--logout';
        else if (act.includes('SALE')) cls = 'badge-act--sale';
        else if (act.includes('PURCHASE')) cls = 'badge-act--purchase';
        else if (act.includes('RETURN')) cls = 'badge-act--return';
        else if (act.includes('STATUS') || act.includes('ROLE')) cls = 'badge-act--status_change';
        else if (act.includes('CLEAR')) cls = 'badge-act--clear_logs';

        return `<span class="badge-act ${cls}">${escapeHtml(action)}</span>`;
    }

    function getRoleBadgeHtml(role) {
        const r = (role || 'User').toLowerCase();
        let cls = 'badge-user-role--default';
        let icon = '<i class="fa-solid fa-user"></i>';

        if (r.includes('super')) {
            cls = 'badge-user-role--super';
            icon = '<i class="fa-solid fa-crown"></i>';
        } else if (r.includes('admin')) {
            cls = 'badge-user-role--admin';
            icon = '<i class="fa-solid fa-crown"></i>';
        } else if (r.includes('manager')) {
            cls = 'badge-user-role--manager';
            icon = '<i class="fa-solid fa-user-tie"></i>';
        } else if (r.includes('staff')) {
            cls = 'badge-user-role--staff';
            icon = '<i class="fa-solid fa-user"></i>';
        }

        const displayRole = role ? (role.charAt(0).toUpperCase() + role.slice(1)) : 'User';
        return `<span class="badge-user-role ${cls}">${icon} ${displayRole}</span>`;
    }

    // ── Render Activity Rows & Mobile Cards ──
    function renderActivityLogs(logs, pagination) {
        const tbody = $('#activityTableBody');
        const mobileList = $('#activityMobileList');
        tbody.empty();
        mobileList.empty();

        if (logs.length === 0) {
            tbody.html(`
                <tr>
                    <td colspan="7" class="text-center py-5 text-slate-400">
                        <i class="fa-solid fa-folder-open block text-3xl opacity-30 mb-2"></i>
                        <p class="mb-0 text-sm">No activity records found matching the filter criteria</p>
                    </td>
                </tr>
            `);
            mobileList.html(`
                <div class="text-center py-5 text-slate-400">
                    <i class="fa-solid fa-folder-open block text-3xl opacity-30 mb-2"></i>
                    <p class="mb-0 text-sm">No activity records found</p>
                </div>
            `);
            return;
        }

        const startSL = ((pagination.current_page || 1) - 1) * (pagination.per_page || 25);

        logs.forEach((log, index) => {
            const sl = startSL + index + 1;
            const actionBadge = getActionBadgeHtml(log.action);
            const roleBadge = getRoleBadgeHtml(log.user_role);
            const avatarLetter = (log.user_name || 'U').charAt(0).toUpperCase();

            // Desktop Row (Matching Image 1, 2, 3, 4 table conventions)
            tbody.append(`
                <tr>
                    <td class="text-center font-bold text-slate-400">${sl}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2.5">
                            <div style="width: 34px; height: 34px; border-radius: 50%; background: #dcfce7; color: #15803d; font-weight: 800; font-size: 13px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                                ${avatarLetter}
                            </div>
                            <div class="min-w-0">
                                <div class="fw-bold text-slate-800 dark:text-white truncate" style="max-width: 180px; font-size: 13px;">${escapeHtml(log.user_name)}</div>
                                <div class="text-[11px] text-slate-400 truncate" style="max-width: 180px;">${escapeHtml(log.user_email || 'N/A')}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">${roleBadge}</td>
                    <td class="text-center">${actionBadge}</td>
                    <td class="text-center"><span class="badge-module-pill">${escapeHtml(log.module)}</span></td>
                    <td>
                        <div class="text-slate-700 dark:text-slate-200" style="word-break: break-word; font-size: 12.5px; line-height: 1.45;">
                            ${escapeHtml(log.description)}
                        </div>
                    </td>
                    <td class="text-end whitespace-nowrap">
                        <div class="font-bold text-slate-700 dark:text-slate-300 text-xs">${log.date}</div>
                        <div class="text-[10px] text-slate-400">${log.time_ago}</div>
                    </td>
                </tr>
            `);

            // Mobile Card Box (Box Type Card for Mobile Responsive Display)
            mobileList.append(`
                <div class="activity-mobile-card shadow-xs">
                    <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom border-slate-100 dark:border-slate-800">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[11px] font-bold">#${sl}</span>
                            <div class="fw-bold text-slate-800 dark:text-white text-xs">${escapeHtml(log.user_name)}</div>
                            ${roleBadge}
                        </div>
                        <div>${actionBadge}</div>
                    </div>
                    <div class="text-slate-700 dark:text-slate-200 text-xs mb-2.5 font-medium" style="word-break: break-word; line-height: 1.45;">
                        ${escapeHtml(log.description)}
                    </div>
                    <div class="d-flex align-items-center justify-content-between text-[11px] text-slate-400 pt-2 border-top border-slate-100 dark:border-slate-800">
                        <div class="d-flex align-items-center gap-1.5">
                            <span class="badge-module-pill">${escapeHtml(log.module)}</span>
                        </div>
                        <div class="text-end font-semibold text-slate-600 dark:text-slate-300">
                            ${log.date}
                        </div>
                    </div>
                </div>
            `);
        });
    }

    // ── Pagination Controls ──
    function renderPagination(pagination) {
        const total = pagination.total || 0;
        const currentPage = pagination.current_page || 1;
        const lastPage = pagination.last_page || 1;
        const perPage = pagination.per_page || 25;

        const from = total === 0 ? 0 : ((currentPage - 1) * perPage) + 1;
        const to = Math.min(currentPage * perPage, total);

        $('#activityPaginationInfo').text(`Showing ${from} to ${to} of ${total} entries`);

        const list = $('#activityPaginationList');
        list.empty();

        if (lastPage <= 1) return;

        // Prev Button
        list.append(`
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <button class="page-link rounded-lg text-xs" onclick="fetchActivityLogs(${currentPage - 1})">
                    <i class="fa-solid fa-chevron-left text-[10px]"></i>
                </button>
            </li>
        `);

        // Page Numbers
        let start = Math.max(1, currentPage - 2);
        let end = Math.min(lastPage, currentPage + 2);

        if (start > 1) {
            list.append(`<li class="page-item"><button class="page-link rounded-lg text-xs" onclick="fetchActivityLogs(1)">1</button></li>`);
            if (start > 2) list.append(`<li class="page-item disabled"><span class="page-link text-xs">...</span></li>`);
        }

        for (let p = start; p <= end; p++) {
            list.append(`
                <li class="page-item ${p === currentPage ? 'active' : ''}">
                    <button class="page-link rounded-lg text-xs font-bold" onclick="fetchActivityLogs(${p})">${p}</button>
                </li>
            `);
        }

        if (end < lastPage) {
            if (end < lastPage - 1) list.append(`<li class="page-item disabled"><span class="page-link text-xs">...</span></li>`);
            list.append(`<li class="page-item"><button class="page-link rounded-lg text-xs" onclick="fetchActivityLogs(${lastPage})">${lastPage}</button></li>`);
        }

        // Next Button
        list.append(`
            <li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
                <button class="page-link rounded-lg text-xs" onclick="fetchActivityLogs(${currentPage + 1})">
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </button>
            </li>
        `);
    }

    // ── Clear All History Modal & Action (Super Admin Only) ──
    function openClearLogsModal() {
        if (!isSuperAdminUser) {
            errorToast('Access Denied: Only Super Admin can clear activity history.');
            return;
        }
        const modal = new bootstrap.Modal(document.getElementById('clearAllLogsModal'));
        modal.show();
    }

    async function executeClearAllLogs() {
        const btn = document.getElementById('confirmClearBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Clearing...';

        try {
            const res = await axios.post('/clear-all-user-activity-logs', {}, HeaderToken());
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-trash-can me-1"></i> Yes, Clear All Logs';

            const modalEl = document.getElementById('clearAllLogsModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();

            if (res.data && res.data.status === 'success') {
                successToast(res.data.message || 'All activity logs cleared successfully.');
                fetchActivityLogs(1);
            } else {
                errorToast(res.data.message || 'Failed to clear activity logs.');
            }
        } catch (err) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-trash-can me-1"></i> Yes, Clear All Logs';
            console.error('Clear logs error:', err);
            errorToast(err.response?.data?.message || err.message || 'Error clearing logs.');
        }
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
</script>