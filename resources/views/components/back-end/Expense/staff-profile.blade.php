<div class="main-content">
    <div class="page-content">
        <div class="container-fluid py-2 px-1">
            <!-- Top Action Bar -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                <div>
                    <h3 class="fw-bold text-dark mb-1">
                        <i class="fa-solid fa-user-tie text-success me-2"></i> স্টাফ সেলারি প্রোফাইল
                    </h3>
                    <p class="text-muted small mb-0">স্টাফের বেতনের ইতিহাস ও সম্পূর্ণ রিলেটেড সেলারি রিপোর্ট</p>
                </div>
                <a href="{{ url('/admin-dashboard-expence-list') }}" class="btn btn-outline-secondary fw-semibold rounded-pill px-4 shadow-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> এক্সপেন্স তালিকায় ফিরুন
                </a>
            </div>

            <!-- Staff Summary Info Cards -->
            <div class="row g-3 mb-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 bg-white" style="border-left: 4px solid #16a34a !important;">
                        <div class="card-body p-3 d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-success-subtle text-success p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 24px;">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <small class="text-muted fw-semibold">স্টাফ নাম ও পদবী</small>
                                <h5 class="fw-bold text-dark text-truncate mb-0" id="staffName">লোড হচ্ছে...</h5>
                                <span class="badge bg-light text-success border border-success mt-1" id="staffRole">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 bg-white" style="border-left: 4px solid #0284c7 !important;">
                        <div class="card-body p-3 d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-info-subtle text-info p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 24px;">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <small class="text-muted fw-semibold">যোগাযোগ মাধ্যম</small>
                                <div class="fw-bold text-dark fs-6" id="staffMobile">-</div>
                                <div class="text-muted small text-truncate" id="staffEmail">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="card border-0 shadow-sm rounded-4 h-100 text-white" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%);">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <small class="text-white-50 fw-bold">সর্বমোট পরিশোধিত বেতন</small>
                                <h2 class="fw-extrabold text-white my-1" id="totalStaffSalary">৳ 0.00</h2>
                                <small class="text-white-50"><i class="fa-solid fa-circle-check me-1"></i> মোট সেলারি এন্ট্রি: <span id="totalSalaryCount">0</span> টি</small>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-4 p-3 text-white">
                                <i class="fa-solid fa-sack-dollar fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Salary History Table Card -->
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                <div class="card-header bg-white py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-3 border-bottom-0">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="fa-solid fa-receipt text-success me-2"></i> সেলারি প্রদানের হিস্ট্রি
                    </h5>
                    <div class="position-relative" style="min-width: 250px;">
                        <input type="text" id="salarySearch" class="form-control rounded-pill pe-4 ps-4" placeholder="🔍 সার্চ করুন..." onkeyup="filterSalaryTable()" />
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="salaryTable">
                            <thead class="bg-light text-muted small uppercase">
                                <tr>
                                    <th class="ps-4 py-3" style="width: 60px;">#</th>
                                    <th class="py-3">তারিখ</th>
                                    <th class="py-3">খাত / এক্সপেন্স টাইপ</th>
                                    <th class="py-3">বিবরণ / নোট</th>
                                    <th class="pe-4 py-3 text-end">প্রদানকৃত পরিমাণ (৳)</th>
                                </tr>
                            </thead>
                            <tbody id="salaryTableBody">
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="fa-solid fa-circle-notch fa-spin me-2"></i> স্টাফ সেলারি ডাটা লোড হচ্ছে...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetchStaffProfileData();
    });

    let salaryList = [];

    async function fetchStaffProfileData() {
        const urlParams = new URLSearchParams(window.location.search);
        const staffId = urlParams.get('id');

        if (!staffId) {
            Swal.fire('ত্রুটি', 'কোনো স্টাফ আইডি পাওয়া যায়নি!', 'error');
            return;
        }

        try {
            const res = await axios.get(`/api/staff-salary-history?id=${staffId}`, HeaderToken());
            if (res.data.status === 'success') {
                const staff = res.data.staff;
                salaryList = res.data.history || [];

                document.getElementById('staffName').innerText = staff.name || 'N/A';
                document.getElementById('staffRole').innerText = (staff.role || 'Staff').toUpperCase();
                document.getElementById('staffMobile').innerText = staff.mobile || 'N/A';
                document.getElementById('staffEmail').innerText = staff.email || 'N/A';
                document.getElementById('totalStaffSalary').innerText = `৳ ${(res.data.totalSalaryPaid || 0).toLocaleString('en-IN', {minimumFractionDigits: 2})}`;
                document.getElementById('totalSalaryCount').innerText = salaryList.length;

                renderSalaryTable(salaryList);
            } else {
                errorToast(res.data.message || 'ডাটা লোড করা যায়নি');
            }
        } catch (e) {
            console.error('Staff profile fetch error:', e);
            errorToast('স্টাফ সেলারি ডাটা লোড করতে সমস্যা দেখা দিয়েছে');
        }
    }

    function renderSalaryTable(data) {
        const tbody = document.getElementById('salaryTableBody');
        tbody.innerHTML = '';

        if (!data || data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="fa-solid fa-inbox fs-3 mb-2 d-block opacity-50"></i>
                        এই স্টাফের এখনও কোনো সেলারি প্রদানের তথ্য পাওয়া যায়নি।
                    </td>
                </tr>
            `;
            return;
        }

        data.forEach((item, index) => {
            const dateStr = item.date ? new Date(item.date).toLocaleDateString('en-GB') : '-';
            const typeName = item.expense_type ? item.expense_type.type_name : 'Salary';
            const amount = parseFloat(item.expense_amount || 0).toLocaleString('en-IN', {minimumFractionDigits: 2});

            const row = `
                <tr>
                    <td class="ps-4 fw-bold text-muted">${index + 1}</td>
                    <td class="fw-semibold text-dark"><i class="fa-regular fa-calendar-check text-success me-1"></i> ${dateStr}</td>
                    <td><span class="badge bg-success-subtle text-success border border-success px-3 py-1 rounded-pill">${typeName}</span></td>
                    <td class="text-secondary small">${item.expense_details || 'স্যালারি পেমেন্ট'}</td>
                    <td class="pe-4 text-end fw-extrabold text-success fs-6">৳ ${amount}</td>
                </tr>
            `;
            tbody.insertAdjacentHTML('beforeend', row);
        });
    }

    function filterSalaryTable() {
        const searchVal = document.getElementById('salarySearch').value.toLowerCase().trim();
        const filtered = salaryList.filter(item => {
            const details = (item.expense_details || '').toLowerCase();
            const dateStr = (item.date || '').toLowerCase();
            const amount = (item.expense_amount || '').toString();
            return details.includes(searchVal) || dateStr.includes(searchVal) || amount.includes(searchVal);
        });
        renderSalaryTable(filtered);
    }
</script>
