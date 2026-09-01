<!-- Expense List Main Content Start -->
<div class="main-content">
    <div class="page-content">
        <!-- Page Title & Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div>
                <h3 class="fw-extrabold text-dark mb-1">
                    <i class="fa-solid fa-wallet text-success me-2"></i> এক্সপেন্স ও সেলারি ম্যানেজমেন্ট (Expense List)
                </h3>
                <p class="text-muted small mb-0">প্রতিষ্ঠানের সমস্থ খরচ এবং স্টাফদের বেতনের হিসেব ও রিপোর্ট</p>
            </div>
            <button type="button" onclick="openExpenseModal()" class="btn btn-success fw-bold px-4 py-2 rounded-pill shadow-sm d-flex align-items-center gap-2 ms-auto" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none;">
                <i class="fa-solid fa-plus-circle fs-5"></i> + Create Expense (নতুন খরচ)
            </button>
        </div>

        <!-- Live Summary Counter Cards (Responsive 2x2 grid on mobile) -->
        <div class="row g-2 g-md-3 mb-4">
            <!-- Total Expense -->
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white" style="border-left: 4px solid #dc2626 !important;">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted fw-bold uppercase d-block" style="font-size: 11px;">সর্বমোট খরচ</small>
                            <h4 class="fw-extrabold text-danger my-1" id="statTotalExpense">৳ 0.00</h4>
                            <small class="text-secondary d-none d-sm-inline" style="font-size: 11px;"><i class="fa-solid fa-receipt me-1"></i> সমস্থ এন্ট্রি</small>
                        </div>
                        <div class="rounded-circle bg-danger-subtle text-danger p-2 p-sm-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 18px;">
                            <i class="fa-solid fa-calculator"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Expense -->
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white" style="border-left: 4px solid #16a34a !important;">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted fw-bold uppercase d-block" style="font-size: 11px;">আজকের খরচ</small>
                            <h4 class="fw-extrabold text-success my-1" id="statTodayExpense">৳ 0.00</h4>
                            <small class="text-secondary d-none d-sm-inline" style="font-size: 11px;"><i class="fa-regular fa-calendar-check me-1"></i> আজকের মোট</small>
                        </div>
                        <div class="rounded-circle bg-success-subtle text-success p-2 p-sm-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 18px;">
                            <i class="fa-solid fa-calendar-day"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- This Month Expense -->
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white" style="border-left: 4px solid #0284c7 !important;">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted fw-bold uppercase d-block" style="font-size: 11px;">এই মাসের খরচ</small>
                            <h4 class="fw-extrabold text-info my-1" id="statMonthExpense">৳ 0.00</h4>
                            <small class="text-secondary d-none d-sm-inline" style="font-size: 11px;"><i class="fa-solid fa-chart-line me-1"></i> চলতি মাসের মোট</small>
                        </div>
                        <div class="rounded-circle bg-info-subtle text-info p-2 p-sm-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 18px;">
                            <i class="fa-solid fa-calendar-week"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Staff Salary Paid -->
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white" style="border-left: 4px solid #4f46e5 !important;">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted fw-bold uppercase d-block" style="font-size: 11px;">স্টাফ মোট বেতন</small>
                            <h4 class="fw-extrabold my-1" id="statSalaryExpense" style="color: #4f46e5;">৳ 0.00</h4>
                            <small class="text-secondary d-none d-sm-inline" style="font-size: 11px;"><i class="fa-solid fa-user-tie me-1"></i> বেতন পরিশোধ</small>
                        </div>
                        <div class="rounded-circle bg-primary-subtle text-indigo p-2 p-sm-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 18px; color: #4f46e5;">
                            <i class="fa-solid fa-hand-holding-dollar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expense Data Table Card -->
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
            <div class="card-header bg-white py-3 px-3 px-md-4 d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom-0">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-list-ol text-success me-2"></i> খরচ ও সেলারির তালিকা
                </h5>

                <div class="d-flex align-items-center gap-2 w-100 w-md-auto ms-auto justify-content-between">
                    <div class="position-relative flex-grow-1 flex-md-grow-0">
                        <input type="text" id="searchInput" class="form-control rounded-pill px-3 px-md-4" placeholder="🔍 টাইপ/বিবরণ/স্টাফ খুঁজুন..." style="min-width: 200px; height: 38px; font-size: 13px;" />
                    </div>
                    <select id="entries" class="form-select rounded-pill" style="width: auto; height: 38px; font-size: 13px;">
                        <option value="10">10</option>
                        <option value="25" selected>25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>

            <div class="card-body p-2 p-md-0">
                <!-- Desktop Table View (>= 768px) -->
                <div class="table-responsive d-none d-md-block">
                    <table id="printTable" class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small uppercase">
                            <tr>
                                <th class="ps-4 py-3" style="width: 60px;">#</th>
                                <th class="py-3">তারিখ (Date)</th>
                                <th class="py-3">খাত / টাইপ (Expense Type)</th>
                                <th class="py-3">স্টাফ নাম (Staff Profile)</th>
                                <th class="py-3">বিবরণ (Details)</th>
                                <th class="py-3">পরিমাণ (Amount ৳)</th>
                                <th class="pe-4 py-3 text-end">অ্যাকশন (Action)</th>
                            </tr>
                        </thead>
                        <tbody id="tableList">
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-circle-notch fa-spin me-2"></i> ডাটা লোড হচ্ছে...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card List View (< 768px) -->
                <div id="mobileCardList" class="d-block d-md-none p-1">
                    <div class="text-center py-4 text-muted">
                        <i class="fa-solid fa-circle-notch fa-spin me-2"></i> ডাটা লোড হচ্ছে...
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer text-center py-3 mt-4 text-muted small border-top">&copy; 2026 মার্স কর্পোরেশন (MARSS CORPORATION) | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-success fw-bold text-decoration-none">CodeNext IT</a></footer>
    </div>
</div>
<!-- Expense List Main Content End -->

<style>
    body[light-mode="dark"] .expense-mobile-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .expense-mobile-card .text-dark {
        color: #f8fafc !important;
    }
    body[light-mode="dark"] .expense-mobile-card .bg-light {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
</style>

<script>
    let rawExpenseList = [];

    document.addEventListener("DOMContentLoaded", function () {
        getExpenseList();

        document.getElementById('searchInput')?.addEventListener('keyup', filterExpenseTable);
        document.getElementById('entries')?.addEventListener('change', filterExpenseTable);
    });

    async function getExpenseList() {
        try {
            showLoader();
            let res = await axios.get("/api/expense-list", HeaderToken());
            hideLoader();

            if (res.data.status === "success" || res.data.ExpenseData) {
                rawExpenseList = res.data.ExpenseData || [];

                // Set Counter Stats
                document.getElementById('statTotalExpense').innerText = `৳ ${(res.data.subTotal || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}`;
                document.getElementById('statTodayExpense').innerText = `৳ ${(res.data.todayExpense || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}`;
                document.getElementById('statMonthExpense').innerText = `৳ ${(res.data.thisMonthExpense || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}`;
                document.getElementById('statSalaryExpense').innerText = `৳ ${(res.data.totalSalaryPaid || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}`;

                renderExpenseTable(rawExpenseList);
            }
        } catch (e) {
            hideLoader();
            console.error("Expense List fetch error:", e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    function renderExpenseTable(data) {
        let tableList = $("#tableList");
        let mobileCardList = $("#mobileCardList");

        tableList.empty();
        mobileCardList.empty();

        if (!data || data.length === 0) {
            let emptyMsg = `
                <div class="text-center py-4 text-muted">
                    <i class="fa-solid fa-inbox fs-3 mb-2 d-block opacity-50"></i>
                    কোনো এক্সপেন্স ডাটা পাওয়া যায়নি।
                </div>
            `;
            tableList.append(`<tr><td colspan="7">${emptyMsg}</td></tr>`);
            mobileCardList.append(emptyMsg);
            return;
        }

        const entriesLimit = parseInt(document.getElementById('entries')?.value || 25);
        const displayData = data.slice(0, entriesLimit);

        displayData.forEach(function(item, index) {
            const dateFormatted = item.date ? new Date(item.date).toLocaleDateString('en-GB') : '-';
            const amountFormatted = parseFloat(item.expense_amount || 0).toLocaleString('en-IN', {minimumFractionDigits: 2});
            
            let staffBadge = '<span class="text-muted small">সাধারণ খরচ (General)</span>';
            if (item.staff_id && item.staff_name) {
                staffBadge = `
                    <a href="/admin-dashboard-staff-profile?id=${item.staff_id}" class="badge bg-primary-subtle text-primary border border-primary text-decoration-none px-3 py-1 rounded-pill" title="স্টাফের প্রোফাইল ও স্যালারি রিপোর্ট দেখুন">
                        <i class="fa-solid fa-user-tie me-1"></i> ${item.staff_name}
                    </a>
                `;
            } else if (item.staff_name) {
                staffBadge = `<span class="badge bg-light text-dark border px-2 py-1">${item.staff_name}</span>`;
            }

            // Desktop Table Row
            let row = `
                <tr>
                    <td class="ps-4 fw-bold text-muted">${index + 1}</td>
                    <td class="fw-semibold text-dark"><i class="fa-regular fa-calendar-check text-success me-1"></i> ${dateFormatted}</td>
                    <td><span class="badge bg-success-subtle text-success border border-success px-3 py-1 rounded-pill">${item.type_name || 'N/A'}</span></td>
                    <td>${staffBadge}</td>
                    <td class="text-secondary small">${item.expense_details || '-'}</td>
                    <td class="fw-extrabold text-danger fs-6">৳ ${amountFormatted}</td>
                    <td class="pe-4 text-end">
                        <div class="d-inline-flex gap-1">
                            <a href="#" data-id="${item.id}" class="btn btn-sm btn-outline-success rounded-circle edit-link" data-bs-toggle="modal" data-bs-target="#exampleModal" title="এডিট করুন">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="#" data-id="${item.id}" class="btn btn-sm btn-outline-danger rounded-circle custom-delete-modal-btn" data-bs-toggle="modal" data-bs-target="#confirmationModal" title="ডিলিট করুন">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            `;
            tableList.append(row);

            // Mobile Card Item View (< 768px)
            let mobileCard = `
                <div class="expense-mobile-card card border shadow-sm rounded-4 mb-3 p-3 position-relative bg-white">
                    <div class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom">
                        <div class="d-flex align-items-center gap-1">
                            <span class="badge bg-secondary-subtle text-secondary fw-bold" style="font-size: 10px;">#${index + 1}</span>
                            <span class="badge bg-light text-dark border fw-bold" style="font-size: 11px;">
                                <i class="fa-regular fa-calendar-check text-success me-1"></i>${dateFormatted}
                            </span>
                        </div>
                        <div>
                            <span class="badge bg-success-subtle text-success border border-success px-2 py-1 fw-bold" style="font-size: 10px; border-radius: 12px;">
                                ${item.type_name || 'N/A'}
                            </span>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <div class="fw-bold text-dark" style="font-size: 13px;">
                                ${staffBadge}
                            </div>
                        </div>
                        <div class="text-secondary small bg-light p-2 rounded-3 mt-1" style="font-size: 12px; border: 1px solid #f1f5f9;">
                            <i class="fa-solid fa-align-left me-1 text-muted"></i>${item.expense_details || 'কোনো বিবরণ নেই'}
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between pt-2 mt-2 border-top">
                        <div>
                            <span class="text-muted small fw-bold" style="font-size: 11px;">পরিমাণ (Amount):</span>
                            <div class="fw-extrabold text-danger fs-6">৳ ${amountFormatted}</div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <a href="#" data-id="${item.id}" class="edit-link btn btn-sm btn-outline-success border-2 rounded-circle d-flex align-items-center justify-content-center p-0" data-bs-toggle="modal" data-bs-target="#exampleModal" title="এডিট করুন" style="width: 36px; height: 36px;">
                                <i class="fa-solid fa-pen-to-square fs-6"></i>
                            </a>
                            <a href="#" data-id="${item.id}" class="custom-delete-modal-btn btn btn-sm btn-outline-danger border-2 rounded-circle d-flex align-items-center justify-content-center p-0" data-bs-toggle="modal" data-bs-target="#confirmationModal" title="ডিলিট করুন" style="width: 36px; height: 36px;">
                                <i class="fa-solid fa-trash fs-6"></i>
                            </a>
                        </div>
                    </div>
                </div>`;
            mobileCardList.append(mobileCard);
        });

        // Delete modal click handler
        $('.custom-delete-modal-btn').off('click').on('click', function(e) {
            let id = $(this).data('id');
            $("#deleteID").val(id);
        });
    }

    function filterExpenseTable() {
        const searchVal = (document.getElementById('searchInput')?.value || '').toLowerCase().trim();
        const filtered = rawExpenseList.filter(item => {
            const type = (item.type_name || '').toLowerCase();
            const details = (item.expense_details || '').toLowerCase();
            const staff = (item.staff_name || '').toLowerCase();
            const amount = (item.expense_amount || '').toString();
            return type.includes(searchVal) || details.includes(searchVal) || staff.includes(searchVal) || amount.includes(searchVal);
        });
        renderExpenseTable(filtered);
    }

    function openExpenseModal() {
        const modalWrapper = document.getElementById('myModal');
        const modalSection = document.querySelector('.financemodal');
        if (modalWrapper) modalWrapper.style.display = 'block';
        if (modalSection) modalSection.style.display = 'block';
    }
</script>