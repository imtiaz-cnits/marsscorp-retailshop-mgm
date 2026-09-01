<!-- Sales & Purchase Return Management Section -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid px-0">

            <!-- Page Header Bar -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div>
                    <h1 class="h3 fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-arrow-rotate-left text-success"></i> Return Management (পণ্য রিটার্ন ও সমন্বয়)
                    </h1>
                    <p class="text-muted mb-0 small">মার্স কর্পোরেশন (MARSS CORPORATION) - সেলস (বিক্রি) ও পারচেজ (ক্রয়) রিটার্ন ব্যবস্থাপনা</p>
                </div>
                <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
                    <button id="mainNewReturnBtn" onclick="triggerNewReturnModal()" class="btn btn-success fw-bold rounded-pill px-4 shadow-sm" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none;">
                        <i class="fa-solid fa-plus me-1"></i> New Sales Return (নতুন রিটার্ন)
                    </button>
                </div>
            </div>

            <!-- Mode Toggle Nav Tabs -->
            <div class="d-flex align-items-center gap-2 mb-4">
                <button id="tabSalesReturnBtn" onclick="switchReturnTab('sales')" class="btn btn-success fw-bold px-4 py-2 rounded-pill shadow-sm">
                    <i class="fa-solid fa-cart-shopping me-2"></i> Sales Return (সেলস রিটার্ন)
                </button>
                <button id="tabPurchaseReturnBtn" onclick="switchReturnTab('purchase')" class="btn btn-outline-secondary fw-bold px-4 py-2 rounded-pill">
                    <i class="fa-solid fa-truck-ramp-box me-2"></i> Purchase Return (পারচেজ রিটার্ন)
                </button>
            </div>

            <!-- Quick Search & Return Trigger Box -->
            <div id="searchCardBox" class="card border-0 shadow-sm mb-4" style="border-radius: 16px; background: linear-gradient(145deg, #ffffff, #f0fdf4); border-left: 5px solid #16a34a !important;">
                <div class="card-body p-4">
                    <h5 id="searchCardTitle" class="fw-bold text-dark mb-2 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass text-success"></i> Quick Invoice Search & Process Return
                    </h5>
                    <p id="searchCardDesc" class="text-muted small mb-3">ইনভয়েস নম্বর দিয়ে যেকোনো বিক্রি খুঁজুন এবং পণ্য রিটার্ন প্রসেস করুন:</p>
                    
                    <div class="row g-2 align-items-center">
                        <div class="col-md-9">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-end-0"><i id="searchCardIcon" class="fa-solid fa-receipt text-success fs-5"></i></span>
                                <input type="text" id="quickInvoiceSearchInput" class="form-control border-start-0 ps-0 fw-bold fs-6" placeholder="ইনভয়েস নম্বর লিখুন (যেমন: #InvID00001)..." onkeydown="if(event.key==='Enter') triggerQuickReturnSearch()" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button id="searchCardSubmitBtn" onclick="triggerQuickReturnSearch()" class="btn btn-success btn-lg w-100 fw-bold shadow-sm" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none;">
                                <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Search & Return
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History Table Card -->
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 id="historyTableTitle" class="fw-bold text-dark mb-0 fs-6">
                        <i class="fa-solid fa-clock-rotate-left text-primary me-2"></i> Sales Return History (রিটার্নকৃত মালের ইতিহাস)
                    </h5>
                    <span id="returnRecordCountBadge" class="badge bg-success-subtle text-success border px-3 py-1">Loading...</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0" id="printTable">
                            <thead class="bg-light">
                                <tr class="text-uppercase small fw-bold text-muted">
                                    <th class="ps-4" style="width: 60px;">SL</th>
                                    <th style="width: 140px;">Return Date</th>
                                    <th id="thInvoiceNo" style="width: 150px;">Invoice No</th>
                                    <th id="thPartyName">Customer Name</th>
                                    <th>Returned Product</th>
                                    <th class="text-center" style="width: 100px;">Qty</th>
                                    <th class="text-end pe-4" style="width: 140px;">Refund Amount</th>
                                </tr>
                            </thead>
                            <tbody id="tableList">
                                <tr><td colspan="7" class="text-center py-4 text-muted">Loading returns...</td></tr>
                            </tbody>
                            <tfoot class="bg-light fw-bold">
                                <tr>
                                    <td colspan="5" class="ps-4 text-end text-uppercase">Total Returned Refund Value:</td>
                                    <td id="tfootTotalQty" class="text-center text-dark">0 pcs</td>
                                    <td id="tfootTotalAmount" class="text-end pe-4 text-success fs-6">৳ 0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Footer copyright -->
            <div class="text-center text-muted py-3 border-top mt-4" style="font-size: 13px;">
                &copy; {{ date('Y') }} মার্স কর্পোরেশন (MARSS CORPORATION) | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-success fw-bold text-decoration-none">CodeNext IT</a>
            </div>

        </div>
    </div>
</div>

<script>
    let activeReturnTab = 'sales'; // 'sales' or 'purchase'

    document.addEventListener("DOMContentLoaded", () => {
        fetchActiveReturnList();
    });

    function switchReturnTab(tab) {
        activeReturnTab = tab;
        const salesBtn = document.getElementById('tabSalesReturnBtn');
        const purchaseBtn = document.getElementById('tabPurchaseReturnBtn');
        const mainNewBtn = document.getElementById('mainNewReturnBtn');

        const searchCardBox = document.getElementById('searchCardBox');
        const searchTitle = document.getElementById('searchCardTitle');
        const searchDesc = document.getElementById('searchCardDesc');
        const searchIcon = document.getElementById('searchCardIcon');
        const searchInput = document.getElementById('quickInvoiceSearchInput');
        const searchSubmitBtn = document.getElementById('searchCardSubmitBtn');

        const historyTitle = document.getElementById('historyTableTitle');
        const thInvoiceNo = document.getElementById('thInvoiceNo');
        const thPartyName = document.getElementById('thPartyName');

        if (tab === 'purchase') {
            salesBtn.className = 'btn btn-outline-secondary fw-bold px-4 py-2 rounded-pill';
            purchaseBtn.className = 'btn btn-teal text-white fw-bold px-4 py-2 rounded-pill shadow-sm';
            purchaseBtn.style.background = 'linear-gradient(135deg, #0d9488 0%, #14b8a6 100%)';
            
            mainNewBtn.className = 'btn btn-teal text-white fw-bold rounded-pill px-4 shadow-sm';
            mainNewBtn.style.background = 'linear-gradient(135deg, #0d9488 0%, #14b8a6 100%)';
            mainNewBtn.innerHTML = `<i class="fa-solid fa-plus me-1"></i> New Purchase Return (নতুন পারচেজ রিটার্ন)`;

            searchCardBox.style.background = 'linear-gradient(145deg, #ffffff, #f0fdfa)';
            searchCardBox.style.borderLeft = '5px solid #14b8a6 !important';
            searchTitle.innerHTML = `<i class="fa-solid fa-magnifying-glass text-teal"></i> Quick Purchase Memo Search & Process Return`;
            searchDesc.innerText = `পারচেজ মেমো নম্বর দিয়ে যেকোনো কেনা খুঁজুন এবং সাপ্লাইয়ারের কাছে রিটার্ন প্রসেস করুন:`;
            searchIcon.className = `fa-solid fa-file-invoice text-teal fs-5`;
            searchInput.placeholder = `পারচেজ মেমো নম্বর লিখুন (যেমন: #PurID00001)...`;
            searchSubmitBtn.style.background = 'linear-gradient(135deg, #0d9488 0%, #14b8a6 100%)';

            historyTitle.innerHTML = `<i class="fa-solid fa-truck-ramp-box text-teal me-2"></i> Purchase Return History (সাপ্লাইয়ারের কাছে ফেরত দেওয়া মালের ইতিহাস)`;
            thInvoiceNo.innerText = 'Purchase Memo No';
            thPartyName.innerText = 'Supplier Name';

        } else {
            salesBtn.className = 'btn btn-success fw-bold px-4 py-2 rounded-pill shadow-sm';
            purchaseBtn.className = 'btn btn-outline-secondary fw-bold px-4 py-2 rounded-pill';
            purchaseBtn.style.background = 'none';

            mainNewBtn.className = 'btn btn-success fw-bold rounded-pill px-4 shadow-sm';
            mainNewBtn.style.background = 'linear-gradient(135deg, #15803d 0%, #16a34a 100%)';
            mainNewBtn.innerHTML = `<i class="fa-solid fa-plus me-1"></i> New Sales Return (নতুন রিটার্ন)`;

            searchCardBox.style.background = 'linear-gradient(145deg, #ffffff, #f0fdf4)';
            searchCardBox.style.borderLeft = '5px solid #16a34a !important';
            searchTitle.innerHTML = `<i class="fa-solid fa-magnifying-glass text-success"></i> Quick Invoice Search & Process Return`;
            searchDesc.innerText = `ইনভয়েস নম্বর দিয়ে যেকোনো বিক্রি খুঁজুন এবং পণ্য রিটার্ন প্রসেস করুন:`;
            searchIcon.className = `fa-solid fa-receipt text-success fs-5`;
            searchInput.placeholder = `ইনভয়েস নম্বর লিখুন (যেমন: #InvID00001)...`;
            searchSubmitBtn.style.background = 'linear-gradient(135deg, #15803d 0%, #16a34a 100%)';

            historyTitle.innerHTML = `<i class="fa-solid fa-clock-rotate-left text-primary me-2"></i> Sales Return History (রিটার্নকৃত মালের ইতিহাস)`;
            thInvoiceNo.innerText = 'Invoice No';
            thPartyName.innerText = 'Customer Name';
        }

        searchInput.value = '';
        fetchActiveReturnList();
    }

    function triggerNewReturnModal() {
        openReturnModal('', activeReturnTab);
    }

    function triggerQuickReturnSearch() {
        const val = document.getElementById('quickInvoiceSearchInput').value.trim();
        if (!val) {
            alert(activeReturnTab === 'purchase' ? 'Please enter a purchase memo number' : 'Please enter an invoice number');
            return;
        }
        openReturnModal(val, activeReturnTab);
    }

    async function fetchActiveReturnList() {
        try {
            if (typeof showLoader === "function") showLoader();

            let url = activeReturnTab === 'purchase' ? '/api/purchase-return-list' : '/api/return-product-list';
            const res = await axios.get(url, HeaderToken());
            if (typeof hideLoader === "function") hideLoader();

            const tbody = document.getElementById("tableList");
            tbody.innerHTML = '';

            if (res.data && res.data.status === 'success') {
                const list = (activeReturnTab === 'purchase' ? res.data.PurchaseReturnData : res.data.ProductReturnData) || [];
                document.getElementById('returnRecordCountBadge').innerText = list.length + ' Return Records';

                if (list.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-muted">No ${activeReturnTab === 'purchase' ? 'purchase' : 'sales'} returns found.</td></tr>`;
                    document.getElementById('tfootTotalQty').innerText = '0 pcs';
                    document.getElementById('tfootTotalAmount').innerText = '৳ 0.00';
                    return;
                }

                let sumQty = 0;
                let sumAmount = 0;

                list.forEach((item, index) => {
                    const qty = parseInt(item.quantity) || 0;
                    const amount = parseFloat(item.amount) || 0;
                    sumQty += qty;
                    sumAmount += amount;

                    const refNo = activeReturnTab === 'purchase' ? item.purchase_no : item.order_no;
                    const partyName = activeReturnTab === 'purchase' ? item.supplier_name : item.customer_name;
                    const badgeClass = activeReturnTab === 'purchase' ? 'bg-teal-subtle text-teal border' : 'bg-success-subtle text-success border border-success-subtle';

                    const row = `
                        <tr>
                            <td class="ps-4 fw-semibold text-muted">${index + 1}</td>
                            <td class="fw-semibold text-dark small">${formatReturnDate(item.date)}</td>
                            <td><span class="badge ${badgeClass} font-monospace">${refNo}</span></td>
                            <td class="fw-bold text-dark">${partyName}</td>
                            <td class="fw-semibold text-secondary">${item.product_name}</td>
                            <td class="text-center"><span class="badge bg-light text-dark border px-2 py-1 fw-bold">${qty} pcs</span></td>
                            <td class="text-end pe-4 fw-bold text-success">৳ ${formatMoney(amount)}</td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });

                document.getElementById('tfootTotalQty').innerText = sumQty + ' pcs';
                document.getElementById('tfootTotalAmount').innerText = '৳ ' + formatMoney(sumAmount);

            } else {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-danger">Failed to load return history</td></tr>`;
            }

        } catch (e) {
            if (typeof hideLoader === "function") hideLoader();
            console.error("Fetch Return List Error:", e);
        }
    }

    function formatReturnDate(dateString) {
        if (!dateString) return 'N/A';
        const options = { year: 'numeric', month: 'short', day: '2-digit' };
        return new Date(dateString).toLocaleDateString('en-US', options);
    }

    function formatMoney(amount) {
        if (amount === null || isNaN(amount)) return "0.00";
        return parseFloat(amount).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }
</script>
