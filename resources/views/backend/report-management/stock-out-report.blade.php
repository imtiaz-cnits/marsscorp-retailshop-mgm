@extends('layouts.dashboard-sidenav')
@section('title', 'Low Stock & Stock-Out Report - MARSS CORPORATION')
@section('content')

    <!-- Hero Main Content Start -->
    <div class="main-content">
        <div class="page-content">
            <!-- Table Start -->
            <div class="bredcam">
                <div class="bredcam-title">
                    <h1 class="text-danger fw-bold"><i class="fa-solid fa-triangle-exclamation me-2"></i> Low Stock & Stock-Out Report</h1>
                </div>
            </div>
            <div class="data-table">
                <div class="card shadow-sm border-0" style="border-radius: 14px;">
                    <div class="card-body p-4">
                        <div class="date-wrapper mb-3 d-flex align-items-center gap-3">
                            <div class="item mb-0">
                                <div class="form-row">
                                    <label for="startDate" class="fw-bold mb-1">Start Date</label>
                                    <input type="date" id="startDate" class="form-control" name="dateInput">
                                </div>
                            </div>
                            <div class="item mb-0">
                                <div class="form-row">
                                    <label for="endDate" class="fw-bold mb-1">End Date</label>
                                    <input type="date" id="endDate" class="form-control" name="dateInput">
                                </div>
                            </div>
                            <div class="align-self-end">
                                <button class="btn btn-success fw-bold px-4" style="height: 38px;" onclick="fetchInvoiceReport()">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i> Filter
                                </button>
                            </div>
                        </div>

                        <div class="button-wrapper mb-3 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <input type="text" id="searchInput" class="form-control fw-semibold" style="max-width: 300px;" placeholder="Search product or barcode..." />
                                <div class="entries-page d-flex align-items-center gap-2">
                                    <label for="entries" class="mb-0 fw-bold">Show:</label>
                                    <select id="entries" class="form-select form-select-sm" style="width: auto">
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="200">200</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="printTable" class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 8%;">Image</th>
                                        <th>Product Name</th>
                                        <th>Barcode / Code</th>
                                        <th>Category</th>
                                        <th class="text-center">Stock Quantity</th>
                                        <th class="text-end">Cost Price (৳)</th>
                                        <th class="text-end">Selling Price (৳)</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableList"></tbody>
                                <tfoot class="table-light fw-bold">
                                    <tr>
                                        <td colspan="5" class="text-end">Total Low Stock Product Quantity:</td>
                                        <td id="totalQuantity" class="text-center text-danger fs-6">0</td>
                                        <td id="totalCostPrice" class="text-end">0</td>
                                        <td id="totalSellingPrice" class="text-end">0</td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <footer class="footer text-center py-3 mt-4 text-muted small border-top">&copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-success fw-bold text-decoration-none">CodeNext IT</a></footer>
            </div>
        </div>
    </div>

    <style>
        .badge.low-stock {
            background-color: #f59e0b;
            color: #fff;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
        }
        .badge.out-of-stock {
            background-color: #ef4444;
            color: #fff;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
        }
    </style>

<script>
    fetchInvoiceReport();

    async function fetchInvoiceReport() {
        const startDate = document.getElementById("startDate").value;
        const endDate = document.getElementById("endDate").value;
        await getList(startDate, endDate);
    }

    async function getList(startDate = '', endDate = '') {
        try {
            showLoader();

            let res = await axios.get("/api/stock-out-product-list", HeaderToken(), {
                params: {
                    start_date: startDate,
                    end_date: endDate
                }
            });

            hideLoader();

            if (res.data.status !== 'success') {
                console.error('Error fetching product data:', res.data.message);
                return;
            }

            let ProductData = res.data.ProductData || [];
            let tableList = $("#tableList");
            let totalCostPrice = 0;
            let totalSellingPrice = 0;
            let totalQuantity = 0;

            tableList.empty();

            // Filter low stock and out-of-stock products (quantity <= 10)
            ProductData = ProductData.filter(item => parseFloat(item.quantity || 0) <= 10);

            if (ProductData.length === 0) {
                tableList.append('<tr><td colspan="10" class="text-center text-success py-4 fw-bold"><i class="fa-solid fa-circle-check fs-4 me-2"></i>All products have sufficient stock! (No stock below 10)</td></tr>');
            }

            ProductData.forEach(function(item, index) {
                const img_url = item.img_url ? item.img_url : "{{ asset('backend/assets/img/product-img.svg') }}";
                const qtyNum = parseFloat(item.quantity) || 0;
                const unitName = item.unit ? (item.unit.unit_name || item.unit.name) : 'pcs';
                const categoryName = item.category ? item.category.category_name : 'N/A';

                let stockStatusClass = qtyNum <= 0 ? "out-of-stock" : "low-stock";
                let stockStatusText = qtyNum <= 0 ? `Out of Stock (${qtyNum})` : `Low Stock (${qtyNum} ${unitName})`;

                totalCostPrice += parseFloat(item.cost_price) || 0;
                totalSellingPrice += parseFloat(item.sell_price) || 0;
                totalQuantity += qtyNum;

                let row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>
                            <img style="width: 45px; height: 45px; object-fit: contain;" class="rounded border p-1" alt="${item.product_name}" src="${img_url}">
                        </td>
                        <td class="fw-bold text-dark">${item.product_name}</td>
                        <td><span class="badge bg-light text-dark border fw-mono">${formatProductCode(item.product_code)}</span></td>
                        <td>${categoryName}</td>
                        <td class="text-center fw-bold fs-6 ${qtyNum <= 0 ? 'text-danger' : 'text-warning'}">${qtyNum} ${unitName}</td>
                        <td class="text-end fw-semibold text-danger">৳ ${parseFloat(item.cost_price || 0).toFixed(2)}</td>
                        <td class="text-end fw-semibold text-success">৳ ${parseFloat(item.sell_price || 0).toFixed(2)}</td>
                        <td class="text-center"><span class="badge ${stockStatusClass}">${stockStatusText}</span></td>
                        <td class="text-center">
                            <a href="/admin-dashboard-Purchase" class="btn btn-sm btn-outline-success fw-bold px-2 py-1" title="Purchase Stock">
                                <i class="fa-solid fa-cart-plus me-1"></i> Purchase
                            </a>
                        </td>
                    </tr>
                `;
                tableList.append(row);
            });

            // Update totals in the tfoot
            $("#totalCostPrice").text('৳ ' + totalCostPrice.toFixed(2));
            $("#totalSellingPrice").text('৳ ' + totalSellingPrice.toFixed(2));
            $("#totalQuantity").text(totalQuantity);

        } catch (e) {
            hideLoader();
            console.error('Error fetching product data:', e.message || e);
        }
    }

    function formatProductCode(productCode) {
        try {
            if (Array.isArray(JSON.parse(productCode))) {
                return JSON.parse(productCode).join(', ');
            }
        } catch (e) {
            return productCode;
        }
        return productCode;
    }

    // Search filter
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tableList tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
</script>

@endsection
