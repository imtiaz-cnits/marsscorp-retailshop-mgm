@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Supplier Due List - MARSS CORPORATION')
@section('content')

<!-- Flatpickr Styles & Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Hero Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-[calc(100vh-70px)] flex flex-col justify-between">
        <div class="data-table flex-grow">
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-10">

                    <!-- 1. Top Section: Page Title & Top Action Buttons -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Supplier Due List</h1>
                                <small class="text-slate-500 dark:text-slate-400 text-xs">Outstanding payables to battery suppliers & manufacturers</small>
                            </div>
                        </div>

                        <!-- Top Right Controls -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('battery.supplier.due.collection') }}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-800 active:scale-[0.98] text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                <span>Payment History</span>
                            </a>
                        </div>
                    </div>

                    <!-- 2. Controls & Filter Row: Search on Left, Show Entries & Filter Dropdown on Right -->
                    <div class="controls-row-wrapper mb-4 w-full">
                        <!-- Search Bar -->
                        <div class="search-input-wrapper unified-ui-border h-[38px] flex items-center bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding-left: 4px !important; padding-right: 4px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Searching Supplier Due..." />
                        </div>

                        <!-- Secondary Controls Group (Show Entries + Filter Dropdown) -->
                        <div class="controls-filter-group">
                            <div class="entries-wrapper unified-ui-border flex items-center gap-1.5 bg-white dark:bg-slate-800/90 h-[38px] rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 shadow-sm transition-all hover:border-emerald-500">
                                <span class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider whitespace-nowrap">SHOW:</span>
                                <select id="entries" class="bg-transparent border-0 text-xs sm:text-sm font-bold text-emerald-700 dark:text-emerald-400 focus:outline-none cursor-pointer py-1 pr-1 text-end" style="cursor: pointer;">
                                    <option value="15" selected class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">15</option>
                                    <option value="25" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">25</option>
                                    <option value="50" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">50</option>
                                    <option value="100" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">100</option>
                                    <option value="200" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">200</option>
                                </select>
                            </div>

                            <!-- Filter Dropdown -->
                            <div class="filter-dropdown-container">
                                <div class="custom-searchable-select custom-filter-dropdown w-full" id="filterDropdownWrap">
                                    <div class="select-trigger unified-ui-border flex items-center justify-between px-3 sm:px-3.5 h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-sm text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-200 cursor-pointer hover:border-emerald-500 transition-all duration-150 w-full" style="padding-left: 14px !important; padding-right: 12px !important;" onclick="toggleDueFilterDropdown(event)">
                                        <div class="flex items-center gap-1.5 overflow-hidden">
                                            <svg class="w-3.5 h-3.5 text-slate-500 dark:text-slate-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                                            </svg>
                                            <span id="selectedFilterLabel" class="selected-text truncate font-semibold">All time</span>
                                        </div>
                                        <svg class="w-3.5 h-3.5 text-slate-400 chevron-icon transition-transform duration-200 flex-shrink-0 ms-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </div>
                                    <div class="select-menu shadow-xl w-full" style="min-width: 170px;">
                                        <div class="select-options-list">
                                            <div class="select-option-item active" data-filter="all" onclick="selectDueFilter(event, 'all', 'All time')">
                                                <span>All time</span>
                                                <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </div>
                                            <div class="select-option-item" data-filter="today" onclick="selectDueFilter(event, 'today', 'Today')">
                                                <span>Today</span>
                                            </div>
                                            <div class="select-option-item" data-filter="7" onclick="selectDueFilter(event, '7', 'Last 7 Days')">
                                                <span>Last 7 Days</span>
                                            </div>
                                            <div class="select-option-item" data-filter="30" onclick="selectDueFilter(event, '30', 'Last Month')">
                                                <span>Last Month</span>
                                            </div>
                                            <div class="select-option-item" data-filter="365" onclick="selectDueFilter(event, '365', 'Last Year')">
                                                <span>Last Year</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Desktop Table (SL rounded-tl-2xl, Action rounded-tr-2xl, solid emerald header, single line, 10px padding) -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900 mb-4">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                    <th class="p-[10px] text-center w-[65px] whitespace-nowrap" style="width: 65px !important;">Image</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Supplier ID</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Name</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Company</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Previous Amount</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Invoice Amount</th>
                                    <th class="p-[10px] text-end whitespace-nowrap">Total Due</th>
                                    <th class="p-[10px] text-center w-[100px] whitespace-nowrap">Status</th>
                                    <th class="p-[10px] text-center w-[80px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableList" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                                <tr>
                                    <td colspan="10" class="text-center py-6 text-slate-400">Loading supplier dues...</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="bg-slate-50/80 dark:bg-slate-800/80 font-bold text-sm border-t border-slate-200 dark:border-slate-800">
                                    <td colspan="5" class="p-[10px] text-end font-bold text-slate-700 dark:text-slate-200">Total:</td>
                                    <td id="totalPayableaamountPrice" class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ 0.00</td>
                                    <td id="totalDueAmountPrice" class="p-[10px] text-end font-bold text-amber-600 dark:text-amber-400 whitespace-nowrap">৳ 0.00</td>
                                    <td id="grandTotalDueAmountPrice" class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ 0.00</td>
                                    <td colspan="2" class="p-[10px]"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- 4. Mobile Card List View -->
                    <div id="mobileCardList" class="block md:hidden mb-3 space-y-3"></div>

                    <!-- 5. Modern Smart Pagination and Display Info Footer -->
                    <div class="flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-800 gap-3">
                        <div id="display-info"></div>
                        <div id="pagination" class="flex items-center gap-1 sm:gap-1.5 flex-nowrap justify-center max-w-full overflow-x-auto pb-1"></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sticky Bottom Copyright Section -->
        <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)] mt-auto">
            <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
            </footer>
        </div>

    </div>
</div>
<!-- Hero Main Content End -->

<!-- Action Button Edit Modal Start (Retail Matched Due Collection Modal) -->
<div id="editModal" class="payment-edit modal" onclick="if(event.target===this) closeModal(this)" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Sticky Green Header with White Text & Red Close Icon -->
            <div style="background-color: #15803d; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; position: sticky; top: 0; z-index: 20; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <h2 style="font-size: 18px; font-weight: 700; color: #ffffff; margin: 0; padding: 0; line-height: 1.2;">Supplier Due collection</h2>
                <button type="button" class="close-btn close" onclick="closeModal(document.getElementById('editModal'))" style="position: static !important; width: 28px; height: 28px; min-width: 28px; min-height: 28px; border-radius: 50%; background-color: #dc2626; color: #ffffff; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.15s ease; margin: 0; padding: 0;" title="Close">
                    <i class="fa-solid fa-xmark" style="color: #ffffff; font-size: 14px;"></i>
                </button>
            </div>

            <!-- Scrollable Body Content -->
            <div id="popup-modal" style="padding: 20px 24px; overflow-y: auto; flex: 1 1 auto; max-height: calc(90vh - 130px); text-align: left;">
                <form id="paymentForm">
                    <input type="hidden" id="updateID">

                    <!-- Date input with centered icon & placeholder -->
                    <div class="mb-3">
                        <label for="DueCollectionDate" class="form-label-title">Due collection Date</label>
                        <div class="due-date-wrapper" onclick="openDueCollectionDatePicker()" style="position: relative; width: 100% !important; height: 42px !important; border: 1.5px solid #cbd5e1; border-radius: 8px; background: #ffffff; display: flex; align-items: center; justify-content: center; gap: 0; cursor: pointer; transition: all 0.2s ease;">
                            <i class="fa-regular fa-calendar-days text-slate-500" style="color: #64748b; font-size: 15px; pointer-events: none;"></i>
                            <input type="text" id="DueCollectionDate" class="due-date-center-input border-0 outline-none focus:ring-0 focus:border-0 focus:outline-none" placeholder="DD-MM-YYYY" autocomplete="off" style="cursor: pointer; border: none !important; background: transparent !important; margin-left: 10px !important; padding: 0 !important;">
                        </div>
                    </div>

                    <!-- Due Info Summary Box -->
                    <div class="due-info-box">
                        <div class="due-info-row">
                            <span class="text-slate-600 dark:text-slate-300 font-medium">Supplier Previous Due</span>
                            <span id="SupplierPreviousDue" class="font-bold text-slate-800 dark:text-slate-100">৳ 0</span>
                        </div>
                        <div class="due-info-row">
                            <span class="text-slate-600 dark:text-slate-300 font-medium">Purchase Previous Due</span>
                            <span id="PurchasePreviousDue" class="font-bold text-slate-800 dark:text-slate-100">৳ 0</span>
                        </div>
                        <div class="due-info-row">
                            <span class="text-slate-700 dark:text-slate-200 font-bold">Total Previous Due</span>
                            <span id="TotalPreviousDue" class="font-bold text-emerald-600 dark:text-emerald-400">৳ 0</span>
                        </div>
                    </div>

                    <!-- Input Fields: Full Width & Proper Padding -->
                    <div style="display: flex; gap: 14px; margin-bottom: 16px; width: 100% !important; flex-wrap: wrap;">
                        <div style="flex: 1 1 220px; min-width: 0;">
                            <label for="DiscountAmount" class="form-label-title">Enter Discount Amount</label>
                            <input type="number" step="any" id="DiscountAmount" oninput="calculateDuePayment()" placeholder="Enter Discount" style="width: 100% !important; height: 42px !important; padding: 8px 14px !important; font-size: 13.5px !important; border-radius: 8px !important; border: 1.5px solid #cbd5e1 !important; outline: none !important; background: #ffffff !important; box-sizing: border-box !important;">
                        </div>
                        <div style="flex: 1 1 220px; min-width: 0;">
                            <label for="PayAmount" class="form-label-title">Enter Pay Amount</label>
                            <input type="number" step="any" id="PayAmount" oninput="calculateDuePayment()" placeholder="Enter Pay Amount" style="width: 100% !important; height: 42px !important; padding: 8px 14px !important; font-size: 13.5px !important; border-radius: 8px !important; border: 1.5px solid #cbd5e1 !important; outline: none !important; background: #ffffff !important; box-sizing: border-box !important;">
                        </div>
                    </div>

                    <!-- Final Due & Status Box -->
                    <div class="due-info-box">
                        <div class="due-info-row">
                            <span class="text-slate-700 dark:text-slate-200 font-bold">Final Due Amount</span>
                            <span id="FinalDueAmount" class="font-bold text-rose-600 dark:text-rose-400 text-sm">৳ 0</span>
                        </div>
                        <div class="due-info-row">
                            <span class="text-slate-700 dark:text-slate-200 font-bold">Status</span>
                            <span id="ShowpaymentStatusDisplay" class="font-bold">Pending</span>
                        </div>
                    </div>
                </form>

                <!-- Payment Method Section -->
                <div id="payment">
                    <div class="payments mt-3">
                        <label class="form-label-title mb-2">Payment Method</label>
                        <form action="#">
                            <input type="hidden" id="selectedPaymentMethod" value="cash">

                            <div class="category-wrapper">
                                <div class="category" style="display: flex; flex-wrap: wrap; gap: 8px;">
                                    <label for="cashRadio" class="cashMethod active" onclick="selectPaymentMethod('cash')" style="cursor: pointer; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 6px 12px; display: flex; align-items: center; gap: 8px;">
                                        <input type="radio" name="payment_choice" id="cashRadio" value="cash" checked style="display: none;" />
                                        <div class="imgName" style="display: flex; align-items: center; gap: 6px;">
                                            <div class="imgContainer cash" style="width: 24px; height: 24px;">
                                                <img src="{{ asset('backend/assets/img/payment-cash.png') }}" alt="Cash" style="width: 100%; height: 100%; object-fit: contain;" />
                                            </div>
                                            <span style="font-size: 13px; font-weight: 600;">Cash</span>
                                        </div>
                                    </label>

                                    <label for="bkashRadio" class="bkashMethod" onclick="selectPaymentMethod('bkash')" style="cursor: pointer; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 6px 12px; display: flex; align-items: center; gap: 8px;">
                                        <input type="radio" name="payment_choice" id="bkashRadio" value="bkash" style="display: none;" />
                                        <div class="imgName" style="display: flex; align-items: center; gap: 6px;">
                                            <div class="imgContainer bkash" style="width: 24px; height: 24px;">
                                                <img src="{{ asset('backend/assets/img/payment-bkash.png') }}" alt="bKash" style="width: 100%; height: 100%; object-fit: contain;" />
                                            </div>
                                            <span style="font-size: 13px; font-weight: 600;">bKash</span>
                                        </div>
                                    </label>

                                    <label for="nagadRadio" class="nagadMethod" onclick="selectPaymentMethod('nagad')" style="cursor: pointer; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 6px 12px; display: flex; align-items: center; gap: 8px;">
                                        <input type="radio" name="payment_choice" id="nagadRadio" value="nagad" style="display: none;" />
                                        <div class="imgName" style="display: flex; align-items: center; gap: 6px;">
                                            <div class="imgContainer nagad" style="width: 24px; height: 24px;">
                                                <img src="{{ asset('backend/assets/img/payment-nagad.png') }}" alt="Nagad" style="width: 100%; height: 100%; object-fit: contain;" />
                                            </div>
                                            <span style="font-size: 13px; font-weight: 600;">Nagad</span>
                                        </div>
                                    </label>

                                    <label for="rocketRadio" class="rocketMethod" onclick="selectPaymentMethod('rocket')" style="cursor: pointer; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 6px 12px; display: flex; align-items: center; gap: 8px;">
                                        <input type="radio" name="payment_choice" id="rocketRadio" value="rocket" style="display: none;" />
                                        <div class="imgName" style="display: flex; align-items: center; gap: 6px;">
                                            <div class="imgContainer rocket" style="width: 24px; height: 24px;">
                                                <img src="{{ asset('backend/assets/img/payment-rocket.png') }}" alt="Rocket" style="width: 100%; height: 100%; object-fit: contain;" />
                                            </div>
                                            <span style="font-size: 13px; font-weight: 600;">Rocket</span>
                                        </div>
                                    </label>

                                    <label for="bankRadio" class="bankMethod" onclick="selectPaymentMethod('bank')" style="cursor: pointer; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 6px 12px; display: flex; align-items: center; gap: 8px;">
                                        <input type="radio" name="payment_choice" id="bankRadio" value="bank" style="display: none;" />
                                        <div class="imgName" style="display: flex; align-items: center; gap: 6px;">
                                            <div class="imgContainer bank" style="width: 24px; height: 24px;">
                                                <img src="{{ asset('backend/assets/img/payment-bank.png') }}" alt="Bank" style="width: 100%; height: 100%; object-fit: contain;" />
                                            </div>
                                            <span style="font-size: 13px; font-weight: 600;">Bank</span>
                                        </div>
                                    </label>

                                    <label for="cardRadio" class="mastercardMethod" onclick="selectPaymentMethod('card')" style="cursor: pointer; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 6px 12px; display: flex; align-items: center; gap: 8px;">
                                        <input type="radio" name="payment_choice" id="cardRadio" value="card" style="display: none;" />
                                        <div class="imgName" style="display: flex; align-items: center; gap: 6px;">
                                            <div class="imgContainer mastercard" style="width: 24px; height: 24px;">
                                                <img src="{{ asset('backend/assets/img/payment-card.png') }}" alt="Card" style="width: 100%; height: 100%; object-fit: contain;" />
                                            </div>
                                            <span style="font-size: 13px; font-weight: 600;">Card</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Transaction ID Input -->
                            <div class="transaction mt-3">
                                <input type="text" id="transactionInput" placeholder="Enter Transaction ID" class="form-control" style="display: none; height: 42px; border-radius: 8px; font-size: 13.5px;" />
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <!-- Sticky Bottom Footer with Submit Button -->
            <div style="padding: 12px 24px 16px; background: #ffffff; border-top: 1px solid #f1f5f9; flex-shrink: 0; position: sticky; bottom: 0; z-index: 20;" class="modal-footer-sticky submit-btn">
                <button type="button" onclick="SavePaymentInfo(event)" class="submit btn-save" style="width: 100% !important; height: 42px !important; background-color: #15803d !important; color: #ffffff !important; border-radius: 8px !important; font-weight: 600 !important; font-size: 15px !important; border: none !important; cursor: pointer !important; display: flex; align-items: center; justify-content: center; transition: background-color 0.2s ease;">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- Action Button Edit Modal End -->

<style>
    /* Full Height Layout & Sticky Copyright */
    html, body {
        min-height: 100vh !important;
    }
    .main-content {
        min-height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
    }
    .page-content {
        min-height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
        flex-grow: 1 !important;
        padding-bottom: 0 !important;
    }
    .data-table {
        flex-grow: 1 !important;
        background: transparent !important;
    }
    .copyright {
        margin-top: auto !important;
        width: 100% !important;
    }

    /* Card-body padding standard */
    .product-card-body {
        padding: 10px !important;
    }
    @media (min-width: 768px) {
        .product-card-body {
            padding: 16px !important;
        }
    }

    /* Controls Row & Elements */
    .controls-row-wrapper {
        width: 100% !important;
        margin-bottom: 16px;
    }
    .search-input-wrapper {
        padding-left: 14px !important;
        padding-right: 14px !important;
    }
    .entries-wrapper {
        width: max-content !important;
        flex-shrink: 0 !important;
        padding-left: 12px !important;
        padding-right: 8px !important;
    }

    @media (min-width: 640px) {
        .controls-row-wrapper {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 14px !important;
        }
        .search-input-wrapper {
            flex: 1 1 auto !important;
            width: auto !important;
            min-width: 0 !important;
        }
        .controls-filter-group {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 12px !important;
            flex: 0 0 auto !important;
        }
        .entries-wrapper {
            flex: 0 0 auto !important;
            width: max-content !important;
        }
        .filter-dropdown-container {
            width: 170px !important;
            flex: 0 0 auto !important;
        }
    }

    @media (max-width: 639px) {
        .controls-row-wrapper {
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
        }
        .search-input-wrapper {
            width: 100% !important;
        }
        .controls-filter-group {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 8px !important;
            width: 100% !important;
        }
        .entries-wrapper {
            flex: 1 1 50% !important;
            width: 50% !important;
            justify-content: space-between !important;
            padding-left: 14px !important;
            padding-right: 10px !important;
        }
        .filter-dropdown-container {
            flex: 1 1 50% !important;
            width: 50% !important;
        }
    }

    /* Custom Filter Dropdown Styling */
    .custom-filter-dropdown {
        position: relative;
    }
    .custom-filter-dropdown .select-menu {
        display: none;
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        z-index: 9999;
        border-radius: 12px;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }
    .custom-filter-dropdown.open .select-menu {
        display: block !important;
    }
    .custom-filter-dropdown.open .chevron-icon {
        transform: rotate(180deg);
    }
    .select-options-list {
        padding: 4px;
        max-height: 250px;
        overflow-y: auto;
    }
    .select-option-item {
        padding: 8px 12px;
        font-size: 13px;
        font-weight: 500;
        color: #334155;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.15s ease;
    }
    .select-option-item:hover {
        background-color: #f1f5f9;
        color: #15803d;
    }
    .select-option-item.active {
        background-color: #f0fdf4;
        color: #15803d;
        font-weight: 700;
    }

    /* Unified UI Border Color */
    .unified-ui-border {
        border: 1.5px solid #cbd5e1 !important;
    }

    /* Search input wrapper focus ring */
    .search-input-wrapper:focus-within {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.25) !important;
    }

    #searchInput,
    #searchInput:focus,
    #searchInput:focus-visible,
    #searchInput:active,
    body[light-mode="dark"] #searchInput,
    body[light-mode="dark"] #searchInput:focus {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }

    /* Table styling */
    #printTable thead th {
        white-space: nowrap !important;
        font-weight: 600;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        background-color: #15803d !important;
        color: #ffffff !important;
        border: none !important;
        padding: 10px !important;
    }
    #printTable tbody td {
        padding: 10px !important;
        vertical-align: middle !important;
        white-space: nowrap !important;
    }
    #printTable th:nth-child(2),
    #printTable td:nth-child(2) {
        width: 65px !important;
        min-width: 65px !important;
        max-width: 65px !important;
        text-align: center !important;
        padding-left: 4px !important;
        padding-right: 4px !important;
    }

    /* Light Mode Button Hover Protection: Never Turn White! */
    .btn-create-supplier:hover,
    .btn-save:hover,
    .submit:hover,
    #openModalBtns:hover,
    #action_btn_wrap a:hover,
    .edit-link:hover {
        background-color: #166534 !important;
        color: #ffffff !important;
    }

    /* Pagination button styling */
    .custom-pagination-btn {
        height: 32px;
        min-width: 32px;
        padding: 0 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background-color: #ffffff;
        color: #334155;
        transition: all 0.15s ease-in-out;
        cursor: pointer;
    }
    .custom-pagination-btn:hover:not(.disabled):not(.active) {
        background-color: #f1f5f9;
        border-color: #94a3b8;
        color: #0f172a;
    }
    .custom-pagination-btn.active {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
        box-shadow: 0 2px 4px rgba(21, 128, 61, 0.25);
    }
    .custom-pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        background-color: #f8fafc;
        border-color: #e2e8f0;
        color: #94a3b8;
    }

    /* Edit Due Modal Styling: Centered with Backdrop */
    #editModal {
        z-index: 1060 !important;
        background: rgba(0, 0, 0, 0.65) !important;
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 20px 10px !important;
        box-sizing: border-box !important;
    }
    #editModal .modal-dialog {
        background: transparent !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        text-align: left !important;
        max-width: 620px !important;
        width: 100% !important;
        max-height: 90vh !important;
        height: auto !important;
        margin: auto !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    #editModal .modal-content {
        border-radius: 16px !important;
        overflow: hidden !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4) !important;
        background: #ffffff !important;
        text-align: left !important;
        max-height: 90vh !important;
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
        position: relative !important;
        transform: none !important;
    }
    #editModal .form-label-title {
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #334155 !important;
        margin-bottom: 6px !important;
        display: block !important;
    }
    #editModal .due-info-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        margin-bottom: 16px;
    }
    #editModal .due-info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        font-size: 13px;
        border-bottom: 1px dashed #e2e8f0;
    }
    #editModal .due-info-row:last-child {
        border-bottom: none;
    }
    .fully-paid-status { color: #15803d !important; font-weight: bold; }
    .partial-payment-status { color: #d97706 !important; font-weight: bold; }
    .unpaid-status { color: #dc2626 !important; font-weight: bold; }

    .category label.active {
        border-color: #15803d !important;
        background-color: #f0fdf4 !important;
        color: #15803d !important;
    }

    /* Full Width & Proper Padding for Due Collection Modal Inputs */
    #editModal input[type="text"]:not(.due-date-center-input),
    #editModal input[type="number"],
    #editModal input[type="date"],
    #editModal .form-control:not(.due-date-center-input) {
        width: 100% !important;
        height: 42px !important;
        font-size: 13.5px !important;
        color: #334155 !important;
        padding: 8px 14px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 8px !important;
        outline: none !important;
        background: #ffffff !important;
        box-sizing: border-box !important;
        display: block !important;
    }
    /* Centered Date Input Styling - borderless input 10px right of calendar icon */
    #editModal .due-date-wrapper input.due-date-center-input,
    #editModal .due-date-wrapper input[type="text"],
    #editModal input.due-date-center-input,
    .due-date-center-input {
        width: auto !important;
        min-width: 95px !important;
        max-width: 150px !important;
        height: 38px !important;
        line-height: 38px !important;
        border: none !important;
        border-width: 0 !important;
        outline: none !important;
        background: transparent !important;
        background-color: transparent !important;
        box-shadow: none !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        text-align: left !important;
        color: #1e293b !important;
        padding: 0 !important;
        margin: 0 !important;
        margin-left: 10px !important;
        cursor: pointer !important;
        display: inline-block !important;
    }
    #editModal .due-date-wrapper input.due-date-center-input:focus,
    #editModal .due-date-wrapper input[type="text"]:focus,
    .due-date-center-input:focus {
        outline: none !important;
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }
    .due-date-center-input::placeholder {
        color: #94a3b8 !important;
        font-weight: 500 !important;
        text-align: left !important;
    }
    .due-date-wrapper:hover {
        border-color: #10b981 !important;
    }
    .due-date-wrapper:focus-within {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.15) !important;
    }

    /* Flatpickr z-index on top of modals */
    .flatpickr-calendar {
        z-index: 999999 !important;
    }

    /* Dark Mode Overrides */
    body[light-mode="dark"] .unified-ui-border { border-color: #334155 !important; }
    body[light-mode="dark"] #printTable thead th { background-color: #14532d !important; color: #ffffff !important; }
    body[light-mode="dark"] #printTable tbody tr:hover { background-color: rgba(30, 41, 59, 0.6) !important; }
    body[light-mode="dark"] .card,
    body[light-mode="dark"] .table-responsive { background-color: #0f172a !important; border-color: #1e293b !important; }
    body[light-mode="dark"] #printTable tbody tr,
    body[light-mode="dark"] #printTable tbody td { color: #f1f5f9 !important; border-color: #1e293b !important; }
    body[light-mode="dark"] #printTable tfoot tr { background-color: #1e293b !important; border-color: #334155 !important; }
    body[light-mode="dark"] .copyright { background-color: rgba(15, 23, 42, 0.95) !important; border-color: #1e293b !important; }
    body[light-mode="dark"] #editModal .modal-content { background-color: #0f172a !important; border: 1px solid #1e293b !important; }
    body[light-mode="dark"] #editModal .modal-footer-sticky { background-color: #0f172a !important; border-top-color: #1e293b !important; }
    body[light-mode="dark"] #editModal .form-label-title { color: #cbd5e1 !important; }
    body[light-mode="dark"] #editModal .due-info-box { background: #1e293b !important; border-color: #334155 !important; }
    body[light-mode="dark"] #editModal .due-info-row { border-bottom-color: #334155 !important; }
    body[light-mode="dark"] .due-date-wrapper { background-color: #0f172a !important; border-color: #334155 !important; }
    body[light-mode="dark"] .due-date-wrapper i { color: #94a3b8 !important; }
    body[light-mode="dark"] .due-date-center-input { color: #f1f5f9 !important; }

    /* Flatpickr Dark Mode Standard */
    body[light-mode="dark"] .flatpickr-calendar,
    html.dark .flatpickr-calendar,
    body.dark .flatpickr-calendar {
        background: #0f172a !important;
        border-color: #334155 !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
    }
    body[light-mode="dark"] .flatpickr-calendar .flatpickr-day,
    html.dark .flatpickr-calendar .flatpickr-day,
    body.dark .flatpickr-calendar .flatpickr-day {
        color: #e2e8f0 !important;
    }
    body[light-mode="dark"] .flatpickr-calendar .flatpickr-day:hover,
    html.dark .flatpickr-calendar .flatpickr-day:hover,
    body.dark .flatpickr-calendar .flatpickr-day:hover {
        background: #1e293b !important;
    }
    body[light-mode="dark"] .flatpickr-calendar .flatpickr-day.today,
    html.dark .flatpickr-calendar .flatpickr-day.today,
    body.dark .flatpickr-calendar .flatpickr-day.today {
        border-color: #10b981 !important;
    }
    body[light-mode="dark"] .flatpickr-calendar .flatpickr-day.selected,
    html.dark .flatpickr-calendar .flatpickr-day.selected,
    body.dark .flatpickr-calendar .flatpickr-day.selected {
        background: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }
    body[light-mode="dark"] .flatpickr-calendar .flatpickr-current-month,
    html.dark .flatpickr-calendar .flatpickr-current-month,
    body.dark .flatpickr-calendar .flatpickr-current-month {
        color: #ffffff !important;
    }
    body[light-mode="dark"] .flatpickr-calendar .flatpickr-month,
    html.dark .flatpickr-calendar .flatpickr-month,
    body.dark .flatpickr-calendar .flatpickr-month {
        color: #ffffff !important;
        fill: #ffffff !important;
    }
    body[light-mode="dark"] .flatpickr-calendar span.flatpickr-weekday,
    html.dark .flatpickr-calendar span.flatpickr-weekday,
    body.dark .flatpickr-calendar span.flatpickr-weekday {
        color: #94a3b8 !important;
    }
</style>

<script>
    let currentPage = 1;
    let pageSize = 15;
    let rawSupplierDueData = [];
    let currentFilter = 'all';

    let dueDatePicker = null;

    function openDueCollectionDatePicker() {
        if (dueDatePicker) {
            dueDatePicker.open();
        }
    }

    function initDueCollectionFlatpickr() {
        if (typeof flatpickr === 'function') {
            if (dueDatePicker) {
                try { dueDatePicker.destroy(); } catch (e) {}
            }
            dueDatePicker = flatpickr("#DueCollectionDate", {
                monthSelectorType: "static",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                altInputClass: "due-date-center-input",
                defaultDate: "today",
                clickOpens: true,
                disableMobile: true
            });
        }
    }

    $(document).ready(function() {
        $("#entries").val("15");
        // Ensure modal is attached to body so it centers cleanly in viewport
        $('#editModal').appendTo('body');
        initDueCollectionFlatpickr();
        getList();
    });

    // Close dropdown on outside click
    document.addEventListener("click", function(event) {
        const wrap = document.getElementById("filterDropdownWrap");
        if (wrap && !wrap.contains(event.target)) {
            wrap.classList.remove("open");
        }
    });

    function toggleDueFilterDropdown(event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        const wrap = document.getElementById("filterDropdownWrap");
        if (wrap) {
            wrap.classList.toggle("open");
        }
    }

    function selectDueFilter(event, filterKey, filterLabel) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        currentFilter = filterKey;
        $("#selectedFilterLabel").text(filterLabel);

        const wrap = document.getElementById("filterDropdownWrap");
        if (wrap) {
            wrap.querySelectorAll(".select-option-item").forEach(item => {
                item.classList.remove("active");
                const existingCheck = item.querySelector(".check-icon");
                if (existingCheck) existingCheck.remove();

                if (item.getAttribute("data-filter") === filterKey) {
                    item.classList.add("active");
                    const checkSvg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                    checkSvg.setAttribute("class", "w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 check-icon");
                    checkSvg.setAttribute("viewBox", "0 0 24 24");
                    checkSvg.setAttribute("fill", "none");
                    checkSvg.setAttribute("stroke", "currentColor");
                    checkSvg.setAttribute("stroke-width", "2.5");
                    checkSvg.setAttribute("stroke-linecap", "round");
                    checkSvg.setAttribute("stroke-linejoin", "round");
                    checkSvg.innerHTML = '<polyline points="20 6 9 17 4 12"></polyline>';
                    item.appendChild(checkSvg);
                }
            });
            wrap.classList.remove("open");
        }

        currentPage = 1;
        renderPaginatedList();
    }

    $("#searchInput").on("keyup search input", function () {
        currentPage = 1;
        renderPaginatedList();
    });

    $("#entries").on("change", function () {
        pageSize = parseInt($(this).val()) || 15;
        currentPage = 1;
        renderPaginatedList();
    });

    function formatBdCurrency(amount) {
        let num = parseFloat(amount);
        if (isNaN(num)) return "0.00";
        return num.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    async function getList() {
        try {
            if (typeof showLoader === 'function') showLoader();
            let res = await axios.get("/api/battery/supplier-due-list", HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && Array.isArray(res.data['SupplierData'])) {
                rawSupplierDueData = res.data['SupplierData'];
                rawSupplierDueData.sort((a, b) => (parseInt(b.id) || 0) - (parseInt(a.id) || 0));
            } else {
                rawSupplierDueData = [];
            }

            currentPage = 1;
            renderPaginatedList();
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            unauthorized(e.response ? e.response.status : 500);
        }
    }

    function renderPaginatedList() {
        if (!rawSupplierDueData) return;

        let searchTerm = ($("#searchInput").val() || "").toLowerCase().trim();

        // 1. Filter Data
        let filtered = rawSupplierDueData.filter(function (item) {
            let supplierId = (item.supplier_id || "").toLowerCase();
            let name = (item.name || "").toLowerCase();
            let company = (item.company || "").toLowerCase();
            let status = (item.status || "").toLowerCase();

            let matchesSearch = !searchTerm || supplierId.includes(searchTerm) || name.includes(searchTerm) || company.includes(searchTerm) || status.includes(searchTerm);
            if (!matchesSearch) return false;

            // Date filtering if applicable
            if (currentFilter === 'all') return true;

            const rowDate = item.created_at ? new Date(item.created_at) : null;
            if (!rowDate || isNaN(rowDate.getTime())) return true;

            const now = new Date();
            const startOfToday = new Date(now.getFullYear(), now.getMonth(), now.getDate());

            if (currentFilter === 'today') {
                return rowDate >= startOfToday;
            } else if (currentFilter === '7') {
                const past7 = new Date(startOfToday);
                past7.setDate(past7.getDate() - 7);
                return rowDate >= past7;
            } else if (currentFilter === '30') {
                const past30 = new Date(startOfToday);
                past30.setDate(past30.getDate() - 30);
                return rowDate >= past30;
            } else if (currentFilter === '365') {
                const past365 = new Date(startOfToday);
                past365.setDate(past365.getDate() - 365);
                return rowDate >= past365;
            }
            return true;
        });

        filtered.sort((a, b) => (parseInt(b.id) || 0) - (parseInt(a.id) || 0));

        // 2. Calculate Totals
        let totalPayableAmount = 0;
        let totalDueAmount = 0;
        let grandTotalDue = 0;
        filtered.forEach(item => {
            let payable = parseFloat(item['purchase_payable_amount']) || 0;
            let due = parseFloat(item['total_due_amount']) || 0;
            totalPayableAmount += payable;
            totalDueAmount += due;
            grandTotalDue += (payable + due);
        });

        $("#totalPayableaamountPrice").text(`৳ ${formatBdCurrency(totalPayableAmount)}`);
        $("#totalDueAmountPrice").text(`৳ ${formatBdCurrency(totalDueAmount)}`);
        $("#grandTotalDueAmountPrice").text(`৳ ${formatBdCurrency(grandTotalDue)}`);

        // 3. Pagination Calculations
        let totalItems = filtered.length;
        let totalPages = Math.ceil(totalItems / pageSize) || 1;
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        let startIndex = (currentPage - 1) * pageSize;
        let endIndex = Math.min(startIndex + pageSize, totalItems);
        let pageItems = filtered.slice(startIndex, endIndex);

        let tableList = $("#tableList");
        let mobileCardList = $("#mobileCardList");

        tableList.empty();
        mobileCardList.empty();

        if (pageItems.length === 0) {
            tableList.html('<tr><td colspan="10" class="text-center text-rose-500 font-bold p-6">❌ No battery supplier due data found.</td></tr>');
            mobileCardList.html('<div class="p-6 text-center text-rose-500 font-bold bg-white dark:bg-slate-800 rounded-2xl unified-ui-border shadow-sm">❌ No battery supplier due data found.</div>');
        } else {
            pageItems.forEach(function (item, idx) {
                let realIndex = startIndex + idx;
                const img_url = item['img_url'] ? item['img_url'] : "{{ asset('backend/assets/img/demo-img.jpeg') }}";
                let payableAmount = parseFloat(item['purchase_payable_amount']) || 0;
                let totalDue = parseFloat(item['total_due_amount']) || 0;
                let grandDue = payableAmount + totalDue;

                let statusBadgeClass = item['status'] === 'Active' 
                    ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800/40' 
                    : 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/40 dark:text-rose-400 dark:border-rose-800/40';

                // Desktop Row
                let row = `
                    <tr data-row="${realIndex + 1}" class="hover:bg-slate-50/80 dark:hover:bg-slate-800/60 transition-colors">
                        <td class="p-[10px] text-center font-semibold text-slate-500 dark:text-slate-400 text-xs">${realIndex + 1}</td>
                        <td class="p-[10px] text-center w-[65px]" style="width: 65px !important;">
                            <div class="flex justify-center">
                                <img style="width: 38px; height: 38px; object-fit: cover;" class="rounded-full border border-slate-200 dark:border-slate-700 shadow-xs" alt="${item['name']}" src="${img_url}" onerror="this.src='{{ asset('backend/assets/img/demo-img.jpeg') }}'">
                            </div>
                        </td>
                        <td class="p-[10px] text-start whitespace-nowrap">
                            <a href="/battery/supplier/profile/${item['id']}" class="inline-flex items-center gap-1 font-semibold text-emerald-600 hover:text-emerald-700 hover:underline dark:text-emerald-400 dark:hover:text-emerald-300 text-xs whitespace-nowrap cursor-pointer" title="View Profile">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="3" width="15" height="13"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                </svg>
                                <span>${item['supplier_id']}</span>
                            </a>
                        </td>
                        <td class="p-[10px] text-start whitespace-nowrap font-bold text-slate-800 dark:text-slate-100">${item['name']}</td>
                        <td class="p-[10px] text-start whitespace-nowrap text-slate-600 dark:text-slate-400 font-medium">${item['company'] || '-'}</td>
                        <td class="p-[10px] text-end font-semibold text-slate-700 dark:text-slate-300 whitespace-nowrap">৳ ${formatBdCurrency(payableAmount)}</td>
                        <td class="p-[10px] text-end font-semibold text-amber-600 dark:text-amber-400 whitespace-nowrap">৳ ${formatBdCurrency(totalDue)}</td>
                        <td class="p-[10px] text-end font-bold ${grandDue > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-700 dark:text-slate-300'} whitespace-nowrap">৳ ${formatBdCurrency(grandDue)}</td>
                        <td class="p-[10px] text-center w-[100px] whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold border ${statusBadgeClass}">
                                ${item['status'] || 'Active'}
                            </span>
                        </td>
                        <td class="p-[10px] text-center">
                            <div id="action_btn_wrap" class="flex items-center justify-center gap-1.5">
                                <a href="#" onclick="FillUpUpdateForm(${item['id']}); return false;" class="link edit-link w-[30px] h-[30px] rounded-lg bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200/80 hover:border-emerald-600 dark:bg-emerald-950/40 dark:border-slate-800 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white flex items-center justify-center transition-all duration-150 shadow-sm" title="Collect Due">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>`;
                tableList.append(row);

                // Mobile Card View
                let mobileCard = `
                    <div class="supplier-mobile-card unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800/60 shadow-sm mb-3">
                        <div class="flex items-center justify-between pb-2 mb-2.5 border-b border-slate-100 dark:border-slate-700/60">
                            <div class="flex items-center gap-1.5">
                                <span class="px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[11px] font-bold">#${realIndex + 1}</span>
                                <a href="/battery/supplier/profile/${item['id']}" class="px-2 py-0.5 rounded-md bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/40 text-emerald-700 dark:text-emerald-400 text-xs font-bold inline-flex items-center gap-1 cursor-pointer" title="View Profile">
                                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="1" y="3" width="15" height="13"></rect>
                                        <polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon>
                                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                    </svg>
                                    ${item['supplier_id']}
                                </a>
                            </div>
                            <div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold border ${statusBadgeClass}">
                                    ${item['status'] || 'Active'}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mb-2.5">
                            <img src="${img_url}" class="rounded-full border border-slate-200 dark:border-slate-700 shadow-xs" style="width: 44px !important; height: 44px !important; object-fit: cover;" onerror="this.src='{{ asset('backend/assets/img/demo-img.jpeg') }}'">
                            <div class="overflow-hidden">
                                <h6 class="font-bold text-slate-800 dark:text-slate-100 text-sm truncate">${item['name']}</h6>
                                <span class="text-slate-500 dark:text-slate-400 text-xs">${item['company'] || 'No Company'}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 my-2.5">
                            <div class="p-2 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/60">
                                <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 block">Previous Due:</span>
                                <span class="font-bold text-xs text-slate-700 dark:text-slate-300">৳ ${formatBdCurrency(payableAmount)}</span>
                            </div>
                            <div class="p-2 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/60">
                                <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 block">Invoice Due:</span>
                                <span class="font-bold text-xs text-amber-600 dark:text-amber-400">৳ ${formatBdCurrency(totalDue)}</span>
                            </div>
                        </div>

                        <div class="p-2.5 rounded-xl bg-rose-50/60 dark:bg-rose-950/30 border border-rose-200/60 dark:border-rose-900/40 my-2 flex items-center justify-between">
                            <span class="text-xs font-semibold text-rose-700 dark:text-rose-400">Total Due:</span>
                            <span class="font-bold text-sm text-rose-600 dark:text-rose-400">৳ ${formatBdCurrency(grandDue)}</span>
                        </div>

                        <div class="flex items-center justify-end pt-2.5 mt-1 border-t border-slate-100 dark:border-slate-700/60">
                            <button type="button" onclick="FillUpUpdateForm(${item['id']})" class="edit-link inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg shadow-xs transition-colors">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9"></path>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                </svg>
                                Collect
                            </button>
                        </div>
                    </div>`;
                mobileCardList.append(mobileCard);
            });
        }

        // Display Info
        let fromCount = totalItems > 0 ? startIndex + 1 : 0;
        let toCount = endIndex;
        $("#display-info").html(`
            <div class="flex items-center gap-1.5 text-xs sm:text-sm font-medium text-slate-500 dark:text-slate-400">
                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                <span>Showing</span>
                <span class="font-bold text-slate-800 dark:text-slate-100 px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-800">${fromCount} – ${toCount}</span>
                <span>of</span>
                <span class="font-bold text-emerald-700 dark:text-emerald-400 px-1.5 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-slate-800">${totalItems}</span>
                <span>entries</span>
            </div>
        `);

        renderPaginationControls(totalPages);
    }

    function renderPaginationControls(totalPages) {
        let pagContainer = $("#pagination");
        pagContainer.empty();

        if (totalPages <= 1) return;

        let prevDisabled = currentPage === 1 ? 'disabled' : '';
        let prevBtn = `
            <button type="button" class="custom-pagination-btn ${prevDisabled}" ${currentPage === 1 ? 'disabled' : ''} onclick="goToPage(${currentPage - 1})">
                <svg class="w-3 h-3 me-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg> Prev
            </button>
        `;
        pagContainer.append(prevBtn);

        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, currentPage + 2);

        if (startPage > 1) {
            pagContainer.append(`<button type="button" class="custom-pagination-btn" onclick="goToPage(1)">1</button>`);
            if (startPage > 2) {
                pagContainer.append(`<span class="px-1 text-slate-400 font-bold">...</span>`);
            }
        }

        for (let p = startPage; p <= endPage; p++) {
            let activeClass = (p === currentPage) ? 'active' : '';
            let pageBtn = `<button type="button" class="custom-pagination-btn ${activeClass}" onclick="goToPage(${p})">${p}</button>`;
            pagContainer.append(pageBtn);
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                pagContainer.append(`<span class="px-1 text-slate-400 font-bold">...</span>`);
            }
            pagContainer.append(`<button type="button" class="custom-pagination-btn" onclick="goToPage(${totalPages})">${totalPages}</button>`);
        }

        let nextDisabled = currentPage === totalPages ? 'disabled' : '';
        let nextBtn = `
            <button type="button" class="custom-pagination-btn ${nextDisabled}" ${currentPage === totalPages ? 'disabled' : ''} onclick="goToPage(${currentPage + 1})">
                Next <svg class="w-3 h-3 ms-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
        `;
        pagContainer.append(nextBtn);
    }

    function goToPage(page) {
        currentPage = page;
        renderPaginatedList();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Modal Helpers
    function openModal(modal) {
        if (modal) {
            modal.style.display = 'flex';
        }
    }

    function closeModal(modal) {
        if (modal) {
            modal.style.display = 'none';
        }
    }

    function selectPaymentMethod(method) {
        document.getElementById('selectedPaymentMethod').value = method;
        document.querySelectorAll('.category label').forEach(lbl => lbl.classList.remove('active'));
        const activeLabel = document.querySelector(`.${method}Method`);
        if (activeLabel) activeLabel.classList.add('active');

        const transactionInput = document.getElementById('transactionInput');
        if (method === 'cash') {
            transactionInput.style.display = 'none';
        } else {
            transactionInput.style.display = 'block';
            transactionInput.placeholder = `Enter ${method.toUpperCase()} Transaction ID`;
        }
    }

    // Fill Up Due Collection Form
    async function FillUpUpdateForm(id) {
        try {
            document.getElementById('updateID').value = id;
            if (typeof showLoader === 'function') showLoader();

            const res = await axios.post("/api/battery/supplier-due-collection-details-by-id", {
                id: id.toString()
            }, HeaderToken());

            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === "success") {
                const supplier_due = parseFloat(res.data.supplier_due ?? 0);
                const purchase_due = parseFloat(res.data.purchase_due ?? 0);
                const total_due = parseFloat(res.data.total_due ?? 0);

                const formatCurrency = (num) => `৳${num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}`;

                document.getElementById('SupplierPreviousDue').textContent = formatCurrency(supplier_due);
                document.getElementById('PurchasePreviousDue').textContent = formatCurrency(purchase_due);
                document.getElementById('TotalPreviousDue').textContent = formatCurrency(total_due);
                document.getElementById('TotalPreviousDue').dataset.raw = total_due;

                document.getElementById('DiscountAmount').value = '';
                document.getElementById('PayAmount').value = '';
                document.getElementById('FinalDueAmount').textContent = formatCurrency(total_due);
                document.getElementById('ShowpaymentStatusDisplay').textContent = 'Pending';

                // Set Today's Date
                const today = new Date().toISOString().split('T')[0];
                if (!dueDatePicker) {
                    initDueCollectionFlatpickr();
                }
                if (dueDatePicker) {
                    dueDatePicker.setDate(today, true);
                } else {
                    document.getElementById('DueCollectionDate').value = today;
                }

                // Reset payment selection to cash
                selectPaymentMethod('cash');

                openModal(document.getElementById('editModal'));
            } else {
                errorToast('Error: Supplier data not found.');
            }
        } catch (error) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error("API Error:", error);
            errorToast('Failed to load supplier due details.');
        }
    }

    function calculateDuePayment() {
        const totalPreviousDue = parseFloat(document.getElementById('TotalPreviousDue').dataset.raw) || 0;
        const discount = parseFloat(document.getElementById('DiscountAmount').value) || 0;
        const payAmount = parseFloat(document.getElementById('PayAmount').value) || 0;

        const totalInput = discount + payAmount;
        const submitBtn = document.querySelector('.submit-btn .submit');

        if (totalInput > totalPreviousDue) {
            alert("The amount you entered is more than the Total Previous Due Amount.");
            if (submitBtn) submitBtn.style.visibility = 'hidden';
        } else {
            if (submitBtn) submitBtn.style.visibility = 'visible';
        }

        let finalDue = totalPreviousDue - totalInput;
        if (finalDue < 0) finalDue = 0;

        document.getElementById('FinalDueAmount').textContent = `৳${finalDue.toFixed(2)}`;

        const statusEl = document.getElementById('ShowpaymentStatusDisplay');
        statusEl.classList.remove("fully-paid-status", "partial-payment-status", "unpaid-status");

        if (finalDue === 0 && totalInput > 0) {
            statusEl.textContent = "Fully Paid";
            statusEl.classList.add("fully-paid-status");
        } else if (finalDue > 0 && totalInput > 0) {
            statusEl.textContent = "Partial Paid";
            statusEl.classList.add("partial-payment-status");
        } else {
            statusEl.textContent = "Unpaid";
            statusEl.classList.add("unpaid-status");
        }
    }

    async function SavePaymentInfo(event) {
        if (event) event.preventDefault();

        try {
            const PayAmount = parseFloat(document.getElementById('PayAmount').value) || 0;
            const DiscountAmount = parseFloat(document.getElementById('DiscountAmount').value) || 0;
            const TotalPreviousDue = parseFloat(document.getElementById('TotalPreviousDue').dataset.raw) || 0;
            const dueAmount = TotalPreviousDue - (PayAmount + DiscountAmount);
            const transactionId = document.getElementById('transactionInput').value;
            const paymentStatus = document.getElementById('ShowpaymentStatusDisplay').innerText.trim();
            const updateID = parseInt(document.getElementById('updateID').value) || 0;
            const paymentMethod = document.getElementById('selectedPaymentMethod').value || 'cash';

            if (!PayAmount && !DiscountAmount) {
                return errorToast('Please enter pay amount or discount.');
            }

            let formData = new FormData();
            formData.append('id', updateID);
            formData.append('supplier_id', updateID);
            formData.append('paid_amount', PayAmount);
            formData.append('due_amount', dueAmount > 0 ? dueAmount : 0);
            formData.append('discount_amount', DiscountAmount);
            formData.append('payment_date', document.getElementById('DueCollectionDate').value);
            formData.append('due_collection_date', document.getElementById('DueCollectionDate').value);
            formData.append('payment_status', paymentStatus);
            formData.append('transaction_id', transactionId);
            formData.append('payment_method', paymentMethod);

            if (typeof showLoader === 'function') showLoader();
            let res = await axios.post("/api/battery/supplier-payment-details-update", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    ...HeaderToken().headers
                }
            });
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === "success") {
                successToast(res.data.message || 'Payment recorded successfully');
                closeModal(document.getElementById('editModal'));
                getList();
            } else {
                errorToast(res.data?.message || 'Payment update failed');
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            errorToast(e.response?.data?.message || 'Error processing payment');
        }
    }
</script>

@endsection
