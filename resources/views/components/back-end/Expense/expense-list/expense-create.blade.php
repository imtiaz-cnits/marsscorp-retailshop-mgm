<!-- Create Expense Modal Start -->
<section id="createProduct" class="financemodal">
            <div class="modal-content shadow-lg border-0" style="border-radius: 16px; width: 75%; max-width: 850px; overflow: hidden;">
                <div class="modal-header text-white py-3 px-4" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%);">
                    <h5 class="modal-title fw-bold mb-0 text-white">
                        <i class="fa-solid fa-file-circle-plus me-2"></i> এক্সপেন্স এন্ট্রি করুন (Create Expense)
                    </h5>
                    <a class="close-btn closes text-white text-decoration-none" onclick="closeExpenseModal()" style="cursor: pointer; font-size: 20px;">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                </div>

                <div id="popup-modal" class="p-4 bg-light">
                    <form id="expenseForm" onsubmit="return Save(event)">
                        <!-- Top Date & Add Type Row -->
                        <div class="row g-3 mb-3 bg-white p-3 rounded-3 shadow-sm border">
                            <div class="col-md-6">
                                <label for="ExpenseDate" class="form-label fw-bold small text-dark mb-1">
                                    <i class="fa-regular fa-calendar-days text-success me-1"></i> তারিখ (Expense Date) *
                                </label>
                                <input type="date" class="form-control fw-bold" id="ExpenseDate" required style="height: 44px; border-radius: 8px;" />
                            </div>
                            <div class="col-md-6 d-flex align-items-end gap-2">
                                <button type="button" class="btn btn-outline-success fw-bold w-100 d-flex align-items-center justify-content-center gap-2 newbrand-open" onclick="openBrandModal()" style="height: 44px; border-radius: 8px;">
                                    <i class="fa-solid fa-folder-plus"></i> + নতুন টাইপ তৈরি করুন
                                </button>
                                <button type="button" class="btn btn-outline-primary fw-bold w-100 d-flex align-items-center justify-content-center gap-2" onclick="openStaffQuickModal()" style="height: 44px; border-radius: 8px;">
                                    <i class="fa-solid fa-user-plus"></i> + নতুন স্টাফ যোগ করুন
                                </button>
                            </div>
                        </div>

                        <!-- Multi-Expense Checkbox Selection List -->
                        <div class="bg-white p-3 rounded-3 shadow-sm border mb-4">
                            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                <h6 class="fw-bold text-dark mb-0">
                                    <i class="fa-solid fa-list-check text-success me-2"></i> এক্সপেন্স টাইপ সিলেক্ট করুন এবং পরিমাণ বসান:
                                </h6>
                                <small class="text-muted"><i class="fa-solid fa-circle-info text-primary me-1"></i> সেলারি দেওয়ার সময় স্টাফ সিলেক্ট করে দিন</small>
                            </div>

                            <div id="ExpenseTypesContainer" class="d-flex flex-column gap-2" style="max-height: 360px; overflow-y: auto;">
                                <div class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-circle-notch fa-spin me-2"></i> এক্সপেন্স টাইপ লোড হচ্ছে...
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex align-items-center justify-content-end gap-2">
                            <button type="button" onclick="closeExpenseModal()" class="btn btn-outline-secondary px-4 fw-bold" style="height: 44px; border-radius: 8px;">ক্যান্সেল</button>
                            <button type="submit" class="btn btn-success px-5 fw-extrabold shadow-sm" style="height: 44px; border-radius: 8px; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none;">
                                <i class="fa-solid fa-check-circle me-1"></i> সাবমিট করুন (Submit)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- Create Expense Modal End -->

        <!-- Add New Expense Type Modal Start -->
        <div class="newbrand" id="addBrandModal" style="z-index: 999999;">
            <div class="newbrand-content shadow-lg border-0" style="border-radius: 16px;">
                <h4 class="fw-bold text-success mb-3"><i class="fa-solid fa-folder-plus me-2"></i> নতুন এক্সপেন্স টাইপ</h4>
                <form onsubmit="saveExpenseType(event)">
                    <div class="form-group mb-3">
                        <label class="form-label small fw-bold text-secondary">টাইপের নাম (Expense Type Name) *</label>
                        <input type="text" id="CreateExpenseTypeName" class="form-control" placeholder="যেমন: দোকান ভাড়া, সেলারি, বিদ্যুৎ বিল" required />
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label small fw-bold text-secondary">স্ট্যাটাস (Status) *</label>
                        <select class="form-select" id="ExpenseSelectStatus">
                            <option value="Active" selected>Active (সক্রিয়)</option>
                            <option value="InActive">Inactive (নিষ্ক্রিয়)</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary px-3 newbrand-close" onclick="closeBrandModal()">ক্যান্সেল</button>
                        <button type="submit" class="btn btn-success px-4 fw-bold">সেভ করুন</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add New Expense Type Modal End -->

        <!-- Quick Add New Staff Modal Start -->
        <div class="newbrand" id="addStaffQuickModal" style="z-index: 999999;">
            <div class="newbrand-content shadow-lg border-0" style="border-radius: 16px; width: 90%; max-width: 480px;">
                <h4 class="fw-bold text-primary mb-3"><i class="fa-solid fa-user-plus me-2"></i> নতুন স্টাফ যুক্ত করুন</h4>
                <form onsubmit="saveQuickStaff(event)">
                    <div class="form-group mb-3">
                        <label class="form-label small fw-bold text-secondary">স্টাফের পূর্ণ নাম (Staff Name) *</label>
                        <input type="text" id="QuickStaffName" class="form-control" placeholder="যেমন: মোঃ রফিক আহমেদ" required />
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label small fw-bold text-secondary">মোবাইল নম্বর (Mobile Number) *</label>
                        <input type="text" id="QuickStaffMobile" class="form-control" placeholder="017XXXXXXXX" required />
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label small fw-bold text-secondary">ইমেইল (Email - ঐচ্ছিক)</label>
                        <input type="email" id="QuickStaffEmail" class="form-control" placeholder="staff@anisstore.com" />
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label small fw-bold text-secondary">পদবী / রোল (Role) *</label>
                        <select class="form-select" id="QuickStaffRole">
                            <option value="staff" selected>Staff (কর্মচারী)</option>
                            <option value="cashier">Cashier (ক্যাশিয়ার)</option>
                            <option value="manager">Manager (ম্যানেজার)</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary px-3" onclick="closeStaffQuickModal()">ক্যান্সেল</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">সেভ স্টাফ</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Quick Add New Staff Modal End -->
<script>
    let globalExpenseTypes = [];
    let globalStaffList = [];

    document.addEventListener("DOMContentLoaded", function () {
        const today = new Date().toISOString().split('T')[0];
        const dateInput = document.getElementById('ExpenseDate');
        if (dateInput) dateInput.value = today;

        loadExpenseTypesAndStaff();
    });

    async function loadExpenseTypesAndStaff() {
        try {
            const [typesRes, staffRes] = await Promise.all([
                axios.get('/api/expense-type-list', HeaderToken()),
                axios.get('/api/staff-list', HeaderToken())
            ]);

            if (typesRes.data.status === 'success' || typesRes.data.ExpenseTypeData) {
                globalExpenseTypes = typesRes.data.ExpenseTypeData || [];
            }
            if (staffRes.data.status === 'success') {
                globalStaffList = staffRes.data.StaffData || [];
            }

            renderExpenseTypeCheckboxes();
        } catch (e) {
            console.error("Error loading expense types or staff:", e);
        }
    }

    let salaryRowCounters = {};

    function isSalaryTypeName(typeName) {
        if (!typeName) return false;
        const name = typeName.toLowerCase();
        const keywords = [
            'salary', 'sallery', 'salery', 'salari', 'salry', 'salaries',
            'বেতন', 'সেলারী', 'সেলারি', 'স্যালারি', 'স্যালারী',
            'staff', 'স্টাফ', 'payroll', 'wage', 'wages', 'honorarium', 'সম্মানী'
        ];
        return keywords.some(k => name.includes(k));
    }

    function addSalaryRow(typeId) {
        if (!salaryRowCounters[typeId]) salaryRowCounters[typeId] = 1;
        const rowIndex = salaryRowCounters[typeId]++;

        const listContainer = document.getElementById(`salary-rows-list-${typeId}`);
        if (!listContainer) return;

        const rowDiv = document.createElement('div');
        rowDiv.className = 'row g-2 align-items-center salary-row mt-2 pt-2 border-top border-light';
        rowDiv.id = `salary-row-${typeId}-${rowIndex}`;

        const staffOptionsHtml = globalStaffList.map(s => `<option value="${s.id}">${s.name} (${s.mobile || 'Staff'})</option>`).join('');

        rowDiv.innerHTML = `
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success text-white fw-bold" type="button" onclick="addSalaryRow(${typeId})" title="আরও স্টাফ যোগ করুন">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <select class="form-select staff-select" id="staff-${typeId}-${rowIndex}">
                        <option value="">-- স্টাফ নির্বাচন করুন --</option>
                        ${staffOptionsHtml}
                    </select>
                    <button class="btn btn-outline-primary" type="button" onclick="openStaffQuickModal()" title="নতুন স্টাফ যুক্ত করুন">
                        <i class="fa-solid fa-user-plus"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <input type="number" step="any" class="form-control form-control-sm amount-input fw-bold text-success" id="amount-${typeId}-${rowIndex}" placeholder="0.00" />
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control form-control-sm details-input" id="details-${typeId}-${rowIndex}" placeholder="মাসের বেতন / অ্যাডভান্স" />
            </div>
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-sm btn-outline-danger remove-salary-row-btn" onclick="removeSalaryRow(${typeId}, ${rowIndex})" title="মুছে ফেলুন">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        `;

        listContainer.appendChild(rowDiv);
        updateRemoveButtons(typeId);
    }

    function removeSalaryRow(typeId, rowIndex) {
        const row = document.getElementById(`salary-row-${typeId}-${rowIndex}`);
        if (row) row.remove();
        updateRemoveButtons(typeId);
    }

    function updateRemoveButtons(typeId) {
        const listContainer = document.getElementById(`salary-rows-list-${typeId}`);
        if (!listContainer) return;
        const rows = listContainer.querySelectorAll('.salary-row');
        rows.forEach(r => {
            const btn = r.querySelector('.remove-salary-row-btn');
            if (btn) {
                if (rows.length > 1) {
                    btn.classList.remove('d-none');
                } else {
                    btn.classList.add('d-none');
                }
            }
        });
    }

    function renderExpenseTypeCheckboxes() {
        const container = document.getElementById('ExpenseTypesContainer');
        if (!container) return;

        if (globalExpenseTypes.length === 0) {
            container.innerHTML = `<div class="text-muted py-3 text-center">কোনো এক্সপেন্স টাইপ পাওয়া যায়নি। উপরে "+ নতুন টাইপ তৈরি করুন" এ ক্লিক করুন।</div>`;
            return;
        }

        let html = '';
        globalExpenseTypes.forEach(type => {
            const isSalary = isSalaryTypeName(type.type_name);
            
            html += `
                <div class="expense-type-row border rounded-3 p-3 bg-light transition-all" id="type-row-${type.id}">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div class="form-check mb-0">
                            <input class="form-check-input type-checkbox" type="checkbox" value="${type.id}" id="chk-${type.id}" onchange="toggleTypeInputs(${type.id})" style="transform: scale(1.2); cursor: pointer;" />
                            <label class="form-check-label fw-bold text-dark ms-1" for="chk-${type.id}" style="cursor: pointer;">
                                ${type.type_name} ${isSalary ? '<span class="badge bg-primary-subtle text-primary border border-primary ms-1 small">👨‍💼 Staff Salary</span>' : ''}
                            </label>
                        </div>
                    </div>

                    <!-- Expandable Inputs when Checked -->
                    <div class="type-input-group mt-3 d-none" id="input-group-${type.id}">
                        ${isSalary ? `
                        <div class="salary-rows-wrapper" id="salary-wrapper-${type.id}">
                            <div class="salary-rows-list d-flex flex-column gap-2" id="salary-rows-list-${type.id}">
                                <div class="row g-2 align-items-center salary-row" id="salary-row-${type.id}-0">
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold text-secondary mb-1">
                                            স্টাফ সিলেক্ট করুন <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <button class="btn btn-success text-white fw-bold" type="button" onclick="addSalaryRow(${type.id})" title="আরও স্টাফ যোগ করুন">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <select class="form-select staff-select" id="staff-${type.id}-0">
                                                <option value="">-- স্টাফ নির্বাচন করুন --</option>
                                                ${globalStaffList.map(s => `<option value="${s.id}">${s.name} (${s.mobile || 'Staff'})</option>`).join('')}
                                            </select>
                                            <button class="btn btn-outline-primary" type="button" onclick="openStaffQuickModal()" title="নতুন স্টাফ যুক্ত করুন">
                                                <i class="fa-solid fa-user-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold text-secondary mb-1">টাকার পরিমাণ (Amount ৳) *</label>
                                        <input type="number" step="any" class="form-control form-control-sm amount-input fw-bold text-success" id="amount-${type.id}-0" placeholder="0.00" />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold text-secondary mb-1">বিবরণ / নোট (Details)</label>
                                        <input type="text" class="form-control form-control-sm details-input" id="details-${type.id}-0" placeholder="মাসের বেতন / অ্যাডভান্স" />
                                    </div>
                                    <div class="col-md-1 text-end pt-3">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-salary-row-btn d-none" onclick="removeSalaryRow(${type.id}, 0)" title="মুছে ফেলুন">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline-success fw-bold px-3 py-1" onclick="addSalaryRow(${type.id})" style="border-radius: 6px;">
                                    <i class="fa-solid fa-plus-circle me-1"></i> + আরও স্টাফ যোগ করুন (Add Staff)
                                </button>
                            </div>
                        </div>
                        ` : `
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary mb-1">টাকার পরিমাণ (Amount ৳) *</label>
                                <input type="number" step="any" class="form-control form-control-sm amount-input fw-bold text-success" id="amount-${type.id}" placeholder="0.00" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary mb-1">বিবরণ / নোট (Details)</label>
                                <input type="text" class="form-control form-control-sm details-input" id="details-${type.id}" placeholder="খরচের বিবরণ লিখুন..." />
                            </div>
                        </div>
                        `}
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
    }

    function toggleTypeInputs(typeId) {
        const chk = document.getElementById(`chk-${typeId}`);
        const group = document.getElementById(`input-group-${typeId}`);
        const row = document.getElementById(`type-row-${typeId}`);

        if (chk && chk.checked) {
            group.classList.remove('d-none');
            row.classList.add('bg-white', 'border-success', 'shadow-sm');
            row.classList.remove('bg-light');
        } else {
            group.classList.add('d-none');
            row.classList.remove('bg-white', 'border-success', 'shadow-sm');
            row.classList.add('bg-light');
        }
    }

    async function saveExpenseType(event) {
        event.preventDefault();
        try {
            const expenseTypeName = document.getElementById('CreateExpenseTypeName').value.trim();
            const expenseStatus = document.getElementById('ExpenseSelectStatus').value;

            if (!expenseTypeName) {
                errorToast("Expense Type Name is required!");
                return;
            }

            const formData = new FormData();
            formData.append('type_name', expenseTypeName);
            formData.append('status', expenseStatus);

            const config = { headers: { 'Content-Type': 'multipart/form-data', ...HeaderToken().headers } };
            const res = await axios.post("/api/create-expense-type", formData, config);

            if (res.data.status === "success") {
                successToast(res.data.message);
                document.getElementById('CreateExpenseTypeName').value = '';
                closeBrandModal();
                await loadExpenseTypesAndStaff();
            } else {
                errorToast(res.data.message);
            }
        } catch (e) {
            unauthorized(e.response?.status || 500);
        }
    }

    async function saveQuickStaff(event) {
        event.preventDefault();
        try {
            const name = document.getElementById('QuickStaffName').value.trim();
            const mobile = document.getElementById('QuickStaffMobile').value.trim();
            const email = document.getElementById('QuickStaffEmail').value.trim();
            const role = document.getElementById('QuickStaffRole').value;

            if (!name || !mobile) {
                errorToast("স্টাফের নাম এবং মোবাইল নম্বর আবশ্যক!");
                return;
            }

            const formData = new FormData();
            formData.append('name', name);
            formData.append('mobile', mobile);
            formData.append('email', email);
            formData.append('password', '123456'); // Default temp password
            formData.append('role', role);
            formData.append('status', 'approved');

            const res = await axios.post('/create-user-admin', formData, HeaderToken());

            if (res.data.status === 'success') {
                successToast(res.data.message || "নতুন স্টাফ যুক্ত করা হয়েছে!");
                document.getElementById('QuickStaffName').value = '';
                document.getElementById('QuickStaffMobile').value = '';
                document.getElementById('QuickStaffEmail').value = '';
                closeStaffQuickModal();
                await loadExpenseTypesAndStaff();
            } else {
                errorToast(res.data.message || "স্টাফ তৈরিতে সমস্যা দেখা দিয়েছে");
            }
        } catch (e) {
            console.error("Staff save error:", e);
            errorToast(e.response?.data?.message || "স্টাফ তৈরি করা যায়নি");
        }
    }

    async function Save(event) {
        event.preventDefault();
        try {
            const expenseDate = document.getElementById('ExpenseDate').value;
            if (!expenseDate) {
                errorToast("তারিখ সিলেক্ট করা আবশ্যক!");
                return false;
            }

            const checkedItems = [];
            const checkboxes = document.querySelectorAll('.type-checkbox:checked');

            if (checkboxes.length === 0) {
                errorToast("অন্তত একটি এক্সপেন্স টাইপ সিলেক্ট করুন!");
                return false;
            }

            let isValid = true;

            checkboxes.forEach(chk => {
                const typeId = chk.value;
                const salaryWrapper = document.getElementById(`salary-wrapper-${typeId}`);

                if (salaryWrapper) {
                    const rows = salaryWrapper.querySelectorAll('.salary-row');
                    rows.forEach(r => {
                        const staffEl = r.querySelector('.staff-select');
                        const amountEl = r.querySelector('.amount-input');
                        const detailsEl = r.querySelector('.details-input');

                        const amount = amountEl ? parseFloat(amountEl.value) : 0;
                        const details = detailsEl ? detailsEl.value.trim() : '';
                        const staffId = staffEl ? staffEl.value : null;

                        if (!amount || amount <= 0) {
                            errorToast("সিলেক্ট করা স্টাফের টাকার পরিমাণ প্রদান করুন!");
                            isValid = false;
                            return;
                        }

                        if (!staffId) {
                            errorToast("সেলারির ক্ষেত্রে স্টাফ নির্বাচন করা আবশ্যক!");
                            isValid = false;
                            return;
                        }

                        checkedItems.push({
                            expense_type_id: typeId,
                            staff_id: staffId,
                            expense_amount: amount,
                            expense_details: details,
                            date: expenseDate
                        });
                    });
                } else {
                    const amountEl = document.getElementById(`amount-${typeId}`);
                    const detailsEl = document.getElementById(`details-${typeId}`);

                    const amount = amountEl ? parseFloat(amountEl.value) : 0;
                    const details = detailsEl ? detailsEl.value.trim() : '';

                    if (!amount || amount <= 0) {
                        errorToast("সিলেক্ট করা এক্সপেন্সের টাকার পরিমাণ প্রদান করুন!");
                        isValid = false;
                        return;
                    }

                    checkedItems.push({
                        expense_type_id: typeId,
                        staff_id: null,
                        expense_amount: amount,
                        expense_details: details,
                        date: expenseDate
                    });
                }
            });

            if (!isValid || checkedItems.length === 0) return false;

            const payload = { items: checkedItems };
            const res = await axios.post("/api/create-expense", payload, HeaderToken());

            if (res.data.status === "success") {
                successToast(res.data.message);
                resetExpenseForm();
                closeExpenseModal();
                if (typeof getExpenseList === 'function') {
                    await getExpenseList();
                } else {
                    setTimeout(() => location.reload(), 500);
                }
            } else {
                errorToast(res.data.message || "সমস্যা দেখা দিয়েছে");
            }
        } catch (e) {
            console.error("Expense Save error:", e);
            errorToast("এক্সপেন্স সেভ করতে সমস্যা দেখা দিয়েছে!");
        }
    }

    function resetExpenseForm() {
        const form = document.getElementById('expenseForm');
        if (form) form.reset();

        salaryRowCounters = {};
        renderExpenseTypeCheckboxes();

        const today = new Date().toISOString().split('T')[0];
        const dateInput = document.getElementById('ExpenseDate');
        if (dateInput) dateInput.value = today;
    }

    function openBrandModal() {
        const modal = document.getElementById('addBrandModal');
        if (modal) {
            modal.classList.add('show');
            modal.style.display = 'flex';
            modal.style.opacity = '1';
            modal.style.visibility = 'visible';
            modal.style.zIndex = '999999';
        }
    }

    function closeBrandModal() {
        const modal = document.getElementById('addBrandModal');
        if (modal) {
            modal.classList.remove('show');
            modal.style.display = 'none';
            modal.style.opacity = '0';
            modal.style.visibility = 'hidden';
        }
    }

    function openStaffQuickModal() {
        const modal = document.getElementById('addStaffQuickModal');
        if (modal) {
            modal.classList.add('show');
            modal.style.display = 'flex';
            modal.style.opacity = '1';
            modal.style.visibility = 'visible';
            modal.style.zIndex = '999999';
        }
    }

    function closeStaffQuickModal() {
        const modal = document.getElementById('addStaffQuickModal');
        if (modal) {
            modal.classList.remove('show');
            modal.style.display = 'none';
            modal.style.opacity = '0';
            modal.style.visibility = 'hidden';
        }
    }

    function openExpenseModal() {
        const modalWrapper = document.getElementById('myModal');
        const modalSection = document.querySelector('.financemodal');
        if (modalWrapper) modalWrapper.style.display = 'block';
        if (modalSection) modalSection.style.display = 'block';
    }

    function closeExpenseModal() {
        resetExpenseForm();
        const modalWrapper = document.getElementById('myModal');
        const modalSection = document.querySelector('.financemodal');
        if (modalWrapper) modalWrapper.style.display = 'none';
        if (modalSection) modalSection.style.display = 'none';
    }

    document.querySelector('.newbrand-open')?.addEventListener('click', openBrandModal);
    document.querySelector('.newbrand-close')?.addEventListener('click', closeBrandModal);
</script>
