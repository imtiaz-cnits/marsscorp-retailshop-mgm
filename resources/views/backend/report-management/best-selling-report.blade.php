@extends('layouts.dashboard-sidenav')
@section('title','Best Selling Products Report')
@section('content')

    <div class="main-content">
        <div class="page-content">
          <div class="bredcam">
            <div class="bredcam-title">
              <a class="bredcam-invoice" href="#">Best Selling Products Report</a>
            </div>
          </div>
          <div class="data-table">
            <div class="card">
              <div class="card-body">
                <div class="date-wrapper mb-3">

                    <div class="item mb-2">
                      <div class="form-row w-100">
                        <label for="startDate">Start Date *</label> <br>
                        <input type="date" id="startDate" name="dateInput">
                      </div>
                    </div>

                    <div class="item mb-2">
                      <div class="form-row w-100">
                        <label for="endDate">End Date *</label> <br>
                        <input type="date" id="endDate" name="dateInput">
                      </div>
                    </div>

                    <button class="search-btn" id="searchBtn" onclick="fetchBestSellingReport()">Search</button>

                </div>
                
                <div class="table-wrapper mt-4">
                  <table id="printTable" class="table table-bordered table-hover">
                    <thead style="background-color: #f8f9fa;">
                      <tr>
                        <th>Serial No.</th>
                        <th>Product Name</th>
                        <th>Total Sold Quantity</th>
                        <th>Total Cost Amount</th>
                        <th>Total Sales Amount</th>
                        <th>Total Profit</th>
                    </tr>
                    </thead>
                    <tbody>
                        </tbody>
                    <tfoot>
                      <tr id="totalCounts" style="background-color: #f8f9fa; font-weight: bold;">
                          <th colspan="2">Total</th>
                          <th>0</th>
                          <th>0.00</th>
                          <th>0.00</th>
                          <th>0.00</th>
                      </tr>
                      </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="copyright">
            <footer class="footer text-center py-3 mt-4 text-muted small border-top">&copy; 2026 মার্স কর্পোরেশন (MARSS CORPORATION) | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-success fw-bold text-decoration-none">CodeNext IT</a></footer>
          </div>
        </div>
      </div>
      
<script>
   document.addEventListener("DOMContentLoaded", () => {
        // আজকের তারিখ বের করা
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0'); // মাস 0 থেকে শুরু হয়, তাই 1 যোগ করা হয়েছে
        const dd = String(today.getDate()).padStart(2, '0');

        // আজকের তারিখ (Format: YYYY-MM-DD)
        const todayDate = `${yyyy}-${mm}-${dd}`;
        
        // চলতি মাসের ১ তারিখ (Format: YYYY-MM-01)
        const firstDayOfMonth = `${yyyy}-${mm}-01`;

        // ইনপুট ফিল্ডে ভ্যালু সেট করা
        document.getElementById("startDate").value = firstDayOfMonth; // Start Date হবে মাসের ১ তারিখ
        document.getElementById("endDate").value = todayDate;         // End Date হবে আজকের তারিখ

        // পেজ লোড হওয়ার সাথে সাথে চলতি মাসের রিপোর্ট ফেচ করা
        fetchBestSellingReport();
    });

    async function fetchBestSellingReport() {
        const startDate = document.getElementById("startDate").value;
        const endDate = document.getElementById("endDate").value;

        if (!startDate || !endDate) {
            alert("Please select both start and end dates.");
            return;
        }

        await getBestSellingList(startDate, endDate);
    }

   async function getBestSellingList(startDate = '', endDate = '') {
        try {
            if(typeof showLoader === "function") showLoader();

            let res = await axios.get("/api/best-selling-products-report", {
                ...HeaderToken(),
                params: {
                    start_date: startDate,
                    end_date: endDate
                }
            });

            if(typeof hideLoader === "function") hideLoader();

            // --- ডিবাগিং এবং এরর হ্যান্ডলিং অংশ যুক্ত করা হলো ---
            console.log("API Response:", res.data); // এটি কনসোলে আসল এরর দেখাবে

            if (res.data.status === 'fail' || res.data.status === 'error') {
                alert("Backend Error: " + res.data.message);
                return; // কোড এখানেই থেমে যাবে, নিচে গিয়ে ক্র্যাশ করবে না
            }

            let tableList = $("#printTable tbody");
            tableList.empty();

            // ডাটা না থাকলে এম্পটি অ্যারে ধরে নিবে
            let sellingData = res.data.BestSellingData || [];

            let grandTotalQuantity = 0;
            let grandTotalCost = 0;
            let grandTotalSales = 0;
            let grandTotalProfit = 0;

            if (sellingData.length === 0) {
                tableList.append(`<tr><td colspan="6" class="text-center">No sales data found for the selected dates.</td></tr>`);
            } else {
                sellingData.forEach(function (item, index) {
                    let qty = parseFloat(item.total_quantity) || 0;
                    let cost = parseFloat(item.total_cost_amount) || 0;
                    let sales = parseFloat(item.total_selling_amount) || 0;
                    let profit = sales - cost;

                    grandTotalQuantity += qty;
                    grandTotalCost += cost;
                    grandTotalSales += sales;
                    grandTotalProfit += profit;

                    let row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.product_name}</td>
                            <td>${qty}</td>
                            <td>${cost.toFixed(2)}</td>
                            <td>${sales.toFixed(2)}</td>
                            <td class="${profit >= 0 ? 'text-success' : 'text-danger'}">${profit.toFixed(2)}</td>
                        </tr>`;
                    tableList.append(row);
                });
            }

            $("#totalCounts").html(`
                <th colspan="2">Total</th>
                <th>${grandTotalQuantity}</th>
                <th>${grandTotalCost.toFixed(2)}</th>
                <th>${grandTotalSales.toFixed(2)}</th>
                <th class="${grandTotalProfit >= 0 ? 'text-success' : 'text-danger'}">${grandTotalProfit.toFixed(2)}</th>
            `);
        } catch (e) {
            if(typeof hideLoader === "function") hideLoader();
            console.error('Axios Fetch Error:', e);
            if(e.response && typeof unauthorized === "function") {
                unauthorized(e.response.status);
            }
        }
    }
</script>

@endsection