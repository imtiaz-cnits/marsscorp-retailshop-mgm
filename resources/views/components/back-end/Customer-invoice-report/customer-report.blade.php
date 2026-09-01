   {{-- Customer Css Start  --}}


   <style>
       .select-box-wrapper {
           width: 100%;
           display: flex;
           gap: 10px;
           align-items: center;
           margin-bottom: 5px;
       }

       .select-box-wrapper .input {
           width: 100%;
       }

       .select-box-wrapper .add-warehouse-btn,
       .select-box-wrapper .add-customer-btn {
           width: 35%;
           white-space: nowrap;
           display: inline-block;
           background: var(--primary-color);
           color: var(--white);
           border-radius: 8px;
           font-size: 13px;
           font-weight: 500;
           padding: 8px 10px;
           transition: 0.3s;
       }

       .select-box-wrapper .add-warehouse-btn:hover,
       .select-box-wrapper .add-customer-btn:hover {
           opacity: 0.9;
       }

       .select-box-wrapper .add-warehouse-btn i {
           width: 20px;
           height: 20px;
       }

       .select-box-wrapper .add-customer-btn svg {
           width: 20px;
           height: 20px;
       }

       .select-box-wrapper label {
           width: 100%;
           color: var(--text-color);
       }

       .select-box-wrapper input {
           width: 100% !important;
           padding: 6px;
           font-size: 12px;
           border: 1px solid var(--gray);
           border-radius: 8px;
           outline: none;
           color: var(--gray);
       }

       .select-box-wrapper input:focus {
           border-color: var(--stroke);
           color: var(--text-color);
       }

       @media screen and (max-width: 992px) {
           .Order-list-wrapper {
               padding-top: 20px;
           }
       }

       @media screen and (max-width: 576px) {

           .select-box-wrapper .add-warehouse-btn,
           .select-box-wrapper .add-customer-btn {
               width: 48%;
               font-size: 12px;
           }

           .select-box-wrapper label {
               width: 52%;
           }

           .select-box-wrapper .add-customer-btn svg {
               width: 14px;
           }

           .select-box-wrapper select {
               padding: 8px 10px;
               font-size: 12px;
           }
       }

       .search-wraper {
           width: 100%;
           display: flex;
           align-items: end;
           gap: 10px;
           margin-top: 10px;
       }

       .search-wraper .wrap {
           width: 100%;
           display: flex;
           flex-direction: column;
       }

       .search-wraper #openModalBtns {
           display: block;
           height: 33px;
           white-space: nowrap;
           padding: 0px 16px;
           font-size: 16px;
           font-weight: 600;
           border-radius: 8px;
           margin: 0;
           background: var(--text-color2);
           color: var(--white);
           border: 1px solid var(--text-color2);
           transition: 0.4s;
       }


       .search-wraper input {
           /* width: 100% !important; */
           padding: 6px;
           font-size: 12px;
           border: 1px solid var(--gray);
           border-radius: 8px;
           outline: none;
           color: var(--gray);
       }

       .search-wraper label {
           width: 100%;
           color: var(--text-color);
       }

       .search-wraper input:focus {
           border-color: var(--stroke);
           color: var(--text-color);
       }


       /* select - 2 start css  */


       .select-box-dropdown {
           position: relative;
           width: 100%;
       }

       .select-box-dropdown select {
           display: none;
       }

       .select-dropdown-selected {
           padding: 6px;
           font-size: 12px;
           border: 1px solid var(--gray);
           border-radius: 8px;
           outline: none;
           color: var(--gray);
           display: flex;
           justify-content: space-between;
           align-items: center;
       }

       .select-dropdown-selected .icon {
           transition: transform 0.3s;
       }

       .select-dropdown-items {
           position: absolute;
           background-color: #fff;
           border: 1px solid #ccc;
           width: 100%;
           padding: 10px;
           z-index: 1000;
           display: none;
           max-height: 200px;
           overflow-y: auto;
           top: 100%;
       }

       .select-dropdown-items::-webkit-scrollbar {
           width: 8px;
           background-color: #e6e3e3e5;
           cursor: pointer;
       }

       .select-dropdown-items::-webkit-scrollbar-thumb {
           background: #008aee;
           ;
           width: 8px;
           border-radius: 5px;
           border-color: none !important;
       }

       .select-dropdown-items #CustomerSelectData .dropdown-item {
           padding: 10px;
           cursor: pointer;
           border-radius: 4px;
       }

       .select-dropdown-items #CustomerSelectData .dropdown-item:hover {
           background: #008aee;
           color: white;
       }

       .select-search-box {
           padding: 8px 12px;
           width: 100%;
           box-sizing: border-box;
           border-bottom: 1px solid #ccc;
           position: sticky;
           top: 0;
           background-color: #fff;
           z-index: 1;
           display: none;
           /* Initially hide the search input */
       }

       .show {
           display: block;
       }

       /* Rotate the icon when the dropdown is open */
       .select-dropdown-items.show+.select-dropdown-selected .icon {
           transform: rotate(180deg);
       }

       .select-dropdown-selected .icon {
           top: 0px !important;
       }

       /* select - 2 end  */
       .card-wrapper .product-price h1 {
           opacity: 0;
           visibility: hidden;
           transition: 0.4s;
           margin-left: -20px;
       }

       #product-card .card-wrapper {
           overflow: hidden;
       }

       #product-card .card-wrapper:hover .product-price h1 {
           opacity: 1;
           visibility: visible;
           margin-left: 0px;
       }
   </style>



<div class="main-content">
    <div class="page-content">
        <div class="col-lg-5">
            <div class="search-wraper">
                <div class="wrap">
                    <label>Customer Search</label>
                    <div class="select-box-dropdown">
                        <div class="select-dropdown-selected">
                            <span>Select an option</span>
                            <span class="icon"><i class="fas fa-angle-down"></i></span>
                        </div>
                        <div class="select-dropdown-items">
                            <input type="text" class="select-search-box" placeholder="Search...">
                            <div id="CustomerSelectData"></div>
                        </div>
                    </div>
                </div>
                <button id="openModalBtns" type="button" class="create-invoice">+ Create Customer</button>
            </div>

            <!-- Customer Info Form -->
            <div class="select-box-wrapper mt-3">
                <div class="input">
                    <label>Customer Name</label>
                    <input type="text" id="CustomerName" placeholder="Enter Customer Name">
                </div>
                <div class="input">
                    <label>Customer ID</label>
                    <input type="text" id="customerId" placeholder="Enter Customer ID">
                </div>
                <div class="input">
                    <label>Mobile Number</label>
                    <input type="number" id="CustomerMobileNumber" placeholder="Enter Customer Number">
                </div>
            </div>

            <div class="select-box-wrapper">
                <div class="input">
                    <label>Customer Address</label>
                    <input type="text" id="CustomerAddress" placeholder="Enter Customer Address">
                </div>
                <div class="input">
                    <label>Customer Date</label>
                    <input type="date" id="CustomerDate">
                </div>
            </div>
        </div>

        <!-- Date Filter Section -->
        <div class="date-wrapper mb-3">
            <div class="item">
                <div class="form-row">
                    <label>Start Date *</label>
                    <input type="date" id="startDate">
                </div>
            </div>
            <div class="item">
                <div class="form-row">
                    <label>End Date *</label>
                    <input type="date" id="endDate">
                </div>
            </div>
            <button class="search-btn" id="fetchReportButton">Search</button>
        </div>

        <!-- Table for displaying reports -->
        <div class="table-wrapper">
            <table id="printTable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Serial No:</th>
                        <th>Invoice</th>
                        <th>Subtotal</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th>Previous Due</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody id="reportTableBody">
                    <!-- Invoice report rows will be dynamically added here -->
                </tbody>
            </table>
        </div>
    </div>
</div>



<script>

document.addEventListener("DOMContentLoaded", function () {
    const fetchReportButton = document.getElementById("fetchReportButton");
    const customerIdField = document.getElementById("customerId");
    const customerNameField = document.getElementById("CustomerName");
    const customerMobileField = document.getElementById("CustomerMobileNumber");
    const customerAddressField = document.getElementById("CustomerAddress");
    const startDateField = document.getElementById("startDate");
    const endDateField = document.getElementById("endDate");
    const reportTableBody = document.getElementById("reportTableBody");

    // Dropdown Elements
    const dropdown = document.querySelector(".select-box-dropdown");
    const dropdownSelected = dropdown.querySelector(".select-dropdown-selected");
    const dropdownItems = dropdown.querySelector(".select-dropdown-items");
    const searchBox = dropdown.querySelector(".select-search-box");
    const customerSelectData = document.getElementById("CustomerSelectData");
    const icon = dropdown.querySelector(".icon i");

    // Toggle dropdown
    dropdownSelected.addEventListener("click", function (e) {
        e.stopPropagation();
        dropdownItems.classList.toggle("show");
        searchBox.style.display = dropdownItems.classList.contains("show") ? "block" : "none";
        icon.classList.toggle("fa-angle-up");
        icon.classList.toggle("fa-angle-down");
    });

    // Close dropdown if clicked outside
    document.addEventListener("click", function (e) {
        if (!dropdown.contains(e.target)) {
            dropdownItems.classList.remove("show");
            searchBox.style.display = "none";
            icon.classList.remove("fa-angle-up");
            icon.classList.add("fa-angle-down");
        }
    });

    // Search filter for customers
    searchBox.addEventListener("input", function () {
        const filter = searchBox.value.toLowerCase();
        const items = customerSelectData.querySelectorAll(".dropdown-item");

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(filter) ? "block" : "none";
        });
    });

    // Populate customer dropdown
    async function CustomerTypeData() {
        try {
            const res = await axios.get("/api/customer-list");
            if (res.data.CustomerData) {
                const customerOptions = res.data.CustomerData.map(customer => `
                    <div class="dropdown-item"
                        data-customer_id="${customer.customer_id}"
                        data-name="${customer.customer_name}"
                        data-mobile="${customer.mobile}"
                        data-address="${customer.address_details}">
                        ${customer.customer_id} - ${customer.customer_name}
                    </div>
                `).join('');
                customerSelectData.innerHTML = customerOptions;
            }
        } catch (error) {
            console.error("Error fetching customer list:", error);
        }
    }

    // Load customers when page loads
    CustomerTypeData();

    // Event delegation for selecting a customer
    customerSelectData.addEventListener("click", function (e) {
        const selectedItem = e.target.closest(".dropdown-item");
        if (selectedItem) {
            customerIdField.value = selectedItem.dataset.customer_id;
            customerNameField.value = selectedItem.dataset.name;
            customerMobileField.value = selectedItem.dataset.mobile;
            customerAddressField.value = selectedItem.dataset.address;
            dropdownSelected.querySelector("span").textContent = selectedItem.textContent;
            dropdownItems.classList.remove("show");
            searchBox.style.display = "none";
        }
    });

    // Fetch report on button click
    fetchReportButton.addEventListener("click", async function () {
        const customerId = customerIdField.value;
        const startDate = startDateField.value;
        const endDate = endDateField.value;

        if (!customerId || !startDate || !endDate) {
            alert("Please fill in all fields.");
            return;
        }

        try {
            const response = await axios.get("/api/customer-invoice-report", {
                params: {
                    customer_id: encodeURIComponent(customerId),
                    start_date: startDate,
                    end_date: endDate,
                },
            });

            const data = response.data;

            if (data.status === "success") {
                const customer = data.customer || {};
                const orders = data.orderPaymentDetails || []; // Fixing the correct key

                // Update customer info fields
                customerNameField.value = customer.customer_name || "";
                customerMobileField.value = customer.mobile || "";
                customerAddressField.value = customer.address_details || "";
                document.getElementById("CustomerDate").value = customer.date || "";

                // Check if orders exist before mapping
                if (orders.length === 0) {
                    reportTableBody.innerHTML = `<tr><td colspan="7" class="text-center">No orders found for this customer.</td></tr>`;
                    return;
                }

                // Update the table with order details
                reportTableBody.innerHTML = orders.map((order, index) => `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${order.order_no || "-"}</td>
                        <td>${order.sub_total || "0"}</td>
                        <td>${order.paid_amount || "0"}</td>
                        <td>${order.due_amount || "0"}</td>
                        <td>${order.previous_due_amount || "0"}</td>
                        <td>${order.created_at ? new Date(order.created_at).toLocaleDateString() : "-"}</td>
                    </tr>
                `).join("");

            } else {
                alert(data.message || "No data found.");
                reportTableBody.innerHTML = `<tr><td colspan="7" class="text-center">No data found.</td></tr>`;
            }
        } catch (error) {
            console.error("Error fetching report:", error);
            alert("An error occurred while fetching the report.");
        }
    });
});


</script>

