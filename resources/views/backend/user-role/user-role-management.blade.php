<div class="main-content">
    <div class="page-content">
        <div class="container-fluid py-4">
            <!-- Page Header & Summary Cards -->
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <h4 class="fw-bold mb-1 text-dark d-flex align-items-center gap-2">
                        <i class="fa-solid fa-user-shield text-success fs-3"></i> User Role & Permission Management
                    </h4>
                    <p class="text-muted small mb-0">Configure module-based ON/OFF toggle permissions for system users</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <button class="btn btn-success px-4 py-2 rounded-3 shadow-sm fw-bold align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#createUserModal" onclick="resetCreateForm()">
                        <i class="fa-solid fa-user-plus me-1"></i> Add New User
                    </button>
                </div>
            </div>

            <!-- Metrics Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #064e3b 0%, #047857 100%); color: white;">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-white-50 small fw-bold text-uppercase">Total System Users</span>
                                <h2 class="fw-bold text-white mb-0 mt-1" id="totalUserCount">0</h2>
                            </div>
                            <div class="rounded-circle p-3 text-white fs-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; background: rgba(255,255,255,0.2);">
                                <i class="fa-solid fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); color: white;">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-white-50 small fw-bold text-uppercase">Admin / Super Admin</span>
                                <h2 class="fw-bold text-white mb-0 mt-1" id="adminCount">0</h2>
                            </div>
                            <div class="rounded-circle p-3 text-white fs-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; background: rgba(255,255,255,0.2);">
                                <i class="fa-solid fa-crown"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #7c2d12 0%, #ea580c 100%); color: white;">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-white-50 small fw-bold text-uppercase">Cashier / POS Operator</span>
                                <h2 class="fw-bold text-white mb-0 mt-1" id="cashierCount">0</h2>
                            </div>
                            <div class="rounded-circle p-3 text-white fs-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; background: rgba(255,255,255,0.2);">
                                <i class="fa-solid fa-cash-register"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #581c87 0%, #9333ea 100%); color: white;">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-white-50 small fw-bold text-uppercase">Accountant / Manager</span>
                                <h2 class="fw-bold text-white mb-0 mt-1" id="managerCount">0</h2>
                            </div>
                            <div class="rounded-circle p-3 text-white fs-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; background: rgba(255,255,255,0.2);">
                                <i class="fa-solid fa-calculator"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Table Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-user-group text-success"></i> System Users & Permissions List
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <div class="input-group" style="width: 280px;">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                            <input type="text" id="userSearchInput" class="form-control bg-light border-0" placeholder="Search user...">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="userTable">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4">User Info</th>
                                    <th>Mobile Number</th>
                                    <th>Role</th>
                                    <th>Active Module Permissions</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody">
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="spinner-border text-success spinner-border-sm me-2" role="status"></div>
                                        <span class="text-muted">Loading user list...</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Role Permission Matrix Info Box -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-sliders text-primary"></i> Module Permission Guidelines (Live Module Access)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="p-3 rounded-3 border h-100 bg-light-subtle">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-danger text-white px-2 py-1"><i class="fa-solid fa-crown me-1"></i> Admin / Super Admin</span>
                                </div>
                                <p class="small text-muted mb-0">All module toggles ON 🟢 (POS, Product, Purchase, Customer, Expense, Reports & Users).</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 rounded-3 border h-100 bg-light-subtle">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-primary text-white px-2 py-1"><i class="fa-solid fa-user-gear me-1"></i> Store Manager</span>
                                </div>
                                <p class="small text-muted mb-0">POS, Product, Purchase, Customer, Supplier & Reports ON 🟢. User management OFF 🔴.</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 rounded-3 border h-100 bg-light-subtle">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-success text-white px-2 py-1"><i class="fa-solid fa-cash-register me-1"></i> Cashier / POS</span>
                                </div>
                                <p class="small text-muted mb-0">POS Billing & Sales Return ON 🟢. Backoffice modules OFF 🔴.</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 rounded-3 border h-100 bg-light-subtle">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-purple text-white px-2 py-1" style="background-color: #8b5cf6;"><i class="fa-solid fa-calculator me-1"></i> Accountant</span>
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

<!-- Modal: Create New User -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 bg-success text-white rounded-top-4">
                <h5 class="modal-title fw-bold">
                    <i class="fa-solid fa-user-plus me-2"></i> Create New User & Permissions
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" id="createUserModalCloseBtn"></button>
            </div>
            <form id="createUserForm">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-dark">User Name <span class="text-danger">*</span></label>
                            <input type="text" id="new_name" class="form-control rounded-3" placeholder="Enter user name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-dark">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" id="new_mobile" class="form-control rounded-3" placeholder="017XXXXXXXX" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-dark">Email Address (Optional)</label>
                            <input type="email" id="new_email" class="form-control rounded-3" placeholder="user@domain.com">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-dark">Password <span class="text-danger">*</span></label>
                            <input type="password" id="new_password" class="form-control rounded-3" placeholder="Minimum 4 characters" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-dark">System Role <span class="text-danger">*</span></label>
                            <select id="new_role" class="form-select rounded-3" onchange="applyRolePresets('new', this.value)" required>
                                <option value="admin">👑 Admin / Super Admin</option>
                                <option value="manager">👨‍💼 Store Manager</option>
                                <option value="cashier" selected>🛒 Cashier / POS Operator</option>
                                <option value="accountant">📊 Accountant / Bookkeeper</option>
                                <option value="users">👤 General User</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-dark">Account Status <span class="text-danger">*</span></label>
                            <select id="new_status" class="form-select rounded-3" required>
                                <option value="approved" selected>Approved</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>

                    <!-- Modern Module Toggle Permission Section -->
                    <div class="border rounded-4 p-3 bg-light-subtle">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-toggle-on text-success"></i> Module Access Permissions (ON / OFF)
                        </h6>
                        <div class="row g-3" id="new_permission_toggles">
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold text-dark mb-0 cursor-pointer" for="new_perm_pos">
                                        <i class="fa-solid fa-cash-register text-success me-2"></i> POS Billing & Sales
                                    </label>
                                    <input class="form-check-input fs-4 m-0" type="checkbox" id="new_perm_pos" checked>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold text-dark mb-0 cursor-pointer" for="new_perm_product">
                                        <i class="fa-solid fa-boxes-stacked text-primary me-2"></i> Product & Inventory
                                    </label>
                                    <input class="form-check-input fs-4 m-0" type="checkbox" id="new_perm_product">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold text-dark mb-0 cursor-pointer" for="new_perm_purchase">
                                        <i class="fa-solid fa-truck text-warning me-2"></i> Purchase & Supplier
                                    </label>
                                    <input class="form-check-input fs-4 m-0" type="checkbox" id="new_perm_purchase">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold text-dark mb-0 cursor-pointer" for="new_perm_customer">
                                        <i class="fa-solid fa-users text-info me-2"></i> Customer & Dues
                                    </label>
                                    <input class="form-check-input fs-4 m-0" type="checkbox" id="new_perm_customer">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold text-dark mb-0 cursor-pointer" for="new_perm_expense">
                                        <i class="fa-solid fa-wallet text-danger me-2"></i> Expense & Financial Ledger
                                    </label>
                                    <input class="form-check-input fs-4 m-0" type="checkbox" id="new_perm_expense">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold text-dark mb-0 cursor-pointer" for="new_perm_report">
                                        <i class="fa-solid fa-chart-pie text-secondary me-2"></i> Reports & Analytics
                                    </label>
                                    <input class="form-check-input fs-4 m-0" type="checkbox" id="new_perm_report">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-3 px-4 fw-bold" id="createUserSaveBtn">
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
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 bg-dark text-white rounded-top-4">
                <h5 class="modal-title fw-bold">
                    <i class="fa-solid fa-user-gear me-2"></i> Edit User Role & Permissions
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" id="editUserModalCloseBtn"></button>
            </div>
            <form id="editUserForm">
                <input type="hidden" id="edit_user_id">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-dark">User Name <span class="text-danger">*</span></label>
                            <input type="text" id="edit_name" class="form-control rounded-3" placeholder="User Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-dark">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" id="edit_mobile" class="form-control rounded-3" placeholder="017XXXXXXXX" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-dark">Email Address (Optional)</label>
                            <input type="email" id="edit_email" class="form-control rounded-3" placeholder="user@domain.com">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-dark">New Password (Optional)</label>
                            <input type="password" id="edit_password" class="form-control rounded-3" placeholder="Leave blank to keep unchanged">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-dark">System Role <span class="text-danger">*</span></label>
                            <select id="edit_role" class="form-select rounded-3" onchange="applyRolePresets('edit', this.value)" required>
                                <option value="admin">👑 Admin / Super Admin</option>
                                <option value="manager">👨‍💼 Store Manager</option>
                                <option value="cashier">🛒 Cashier / POS Operator</option>
                                <option value="accountant">📊 Accountant / Bookkeeper</option>
                                <option value="users">👤 General User</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-dark">Status <span class="text-danger">*</span></label>
                            <select id="edit_status" class="form-select rounded-3" required>
                                <option value="approved">Approved</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>

                    <!-- Modern Edit Module Toggle Permission Section -->
                    <div class="border rounded-4 p-3 bg-light-subtle">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-sliders text-primary"></i> Module Access Permissions (ON / OFF)
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold text-dark mb-0 cursor-pointer" for="edit_perm_pos">
                                        <i class="fa-solid fa-cash-register text-success me-2"></i> POS Billing & Sales
                                    </label>
                                    <input class="form-check-input fs-4 m-0" type="checkbox" id="edit_perm_pos">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold text-dark mb-0 cursor-pointer" for="edit_perm_product">
                                        <i class="fa-solid fa-boxes-stacked text-primary me-2"></i> Product & Inventory
                                    </label>
                                    <input class="form-check-input fs-4 m-0" type="checkbox" id="edit_perm_product">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold text-dark mb-0 cursor-pointer" for="edit_perm_purchase">
                                        <i class="fa-solid fa-truck text-warning me-2"></i> Purchase & Supplier
                                    </label>
                                    <input class="form-check-input fs-4 m-0" type="checkbox" id="edit_perm_purchase">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold text-dark mb-0 cursor-pointer" for="edit_perm_customer">
                                        <i class="fa-solid fa-users text-info me-2"></i> Customer & Dues
                                    </label>
                                    <input class="form-check-input fs-4 m-0" type="checkbox" id="edit_perm_customer">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold text-dark mb-0 cursor-pointer" for="edit_perm_expense">
                                        <i class="fa-solid fa-wallet text-danger me-2"></i> Expense & Financial Ledger
                                    </label>
                                    <input class="form-check-input fs-4 m-0" type="checkbox" id="edit_perm_expense">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between">
                                    <label class="form-check-label fw-bold text-dark mb-0 cursor-pointer" for="edit_perm_report">
                                        <i class="fa-solid fa-chart-pie text-secondary me-2"></i> Reports & Analytics
                                    </label>
                                    <input class="form-check-input fs-4 m-0" type="checkbox" id="edit_perm_report">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 fw-bold" id="editUserSaveBtn">
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
            document.getElementById('userTableBody').innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-danger py-4">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i> Failed to load user data.
                    </td>
                </tr>
            `;
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
                return `<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-pill fw-bold"><i class="fa-solid fa-crown me-1"></i> Super Admin</span>`;
            case 'manager':
                return `<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 rounded-pill fw-bold"><i class="fa-solid fa-user-gear me-1"></i> Manager</span>`;
            case 'cashier':
                return `<span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill fw-bold"><i class="fa-solid fa-cash-register me-1"></i> Cashier</span>`;
            case 'accountant':
                return `<span class="badge bg-purple text-white px-3 py-1 rounded-pill fw-bold" style="background-color: #8b5cf6;"><i class="fa-solid fa-calculator me-1"></i> Accountant</span>`;
            default:
                return `<span class="badge bg-secondary-subtle text-secondary px-3 py-1 rounded-pill fw-bold"><i class="fa-solid fa-user me-1"></i> ${role}</span>`;
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
        if (users.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-users-slash fs-2 mb-2 d-block text-secondary"></i>
                        No users found.
                    </td>
                </tr>
            `;
            return;
        }

        let html = '';
        users.forEach(u => {
            let statusBadge = u.status === 'approved' 
                ? `<span class="badge bg-success text-white px-2 py-1" style="font-size: 11px;">APPROVED</span>` 
                : `<span class="badge bg-warning text-dark px-2 py-1" style="font-size: 11px;">PENDING</span>`;

            html += `
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-3">
                            <img src="${u.img_url}" class="rounded-circle border" style="width: 44px; height: 44px; object-fit: cover;" alt="${u.name}">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">${u.name}</h6>
                                <span class="small text-muted">${u.email}</span>
                            </div>
                        </div>
                    </td>
                    <td class="fw-semibold text-dark">${u.mobile}</td>
                    <td>${getRoleBadge(u.role)}</td>
                    <td>${renderPermissionPills(u.permissions, u.role)}</td>
                    <td>${statusBadge}</td>
                    <td class="text-end pe-4">
                        <button class="btn btn-sm btn-outline-primary rounded-3 me-1 px-3" onclick="openEditModal(${u.id})">
                            <i class="fa-solid fa-sliders me-1"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger rounded-3 px-2" onclick="deleteUser(${u.id}, '${u.name.replace(/'/g, "\\'")}')">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        tbody.innerHTML = html;
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
