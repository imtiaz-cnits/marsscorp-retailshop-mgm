@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Customer List - MARSS CORPORATION')
@section('content')

    <!-- Hero Main Content Start -->
    <div class="main-content">
        <div class="page-content min-h-[calc(100vh-70px)] flex flex-col justify-between">
            <div class="data-table flex-grow">
                <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                    <div class="card-body product-card-body p-4 sm:p-6 md:p-10">
                        
                        <!-- 1. Top Section: Page Title & Create Customer Button (Fixed 38px) -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                            <!-- Page Title inside .card-body -->
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Customer List</h1>
                            </div>

                            <!-- Right Controls: + Create Customer Button (Fixed 38px, white text on hover) -->
                            <div class="flex items-center flex-wrap gap-2">
                                <button id="openModalBtns" onclick="openCustomerCreateModal()" type="button" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                    <span>Create Customer</span>
                                </button>
                            </div>
                        </div>

                        <!-- 2. Controls & Filter Row: Search Bar + Show Entry -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-2.5 sm:gap-3 mb-4">
                            <!-- Search Bar + Show Entry Side-by-Side -->
                            <div class="flex items-center gap-2 sm:gap-2.5 w-full md:w-auto">
                                <!-- Search Bar with perfectly aligned icon & placeholder -->
                                <div class="search-input-wrapper unified-ui-border flex-1 md:w-[280px] lg:w-[320px] h-[38px] flex items-center px-3 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                                    <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                    <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search Customer..." />
                                </div>

                                <!-- Entries Selector: Beside Search Bar in Mobile & Desktop -->
                                <div class="entries-wrapper unified-ui-border flex items-center gap-1 bg-white dark:bg-slate-800/90 px-3 h-[38px] rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 shadow-sm transition-all hover:border-emerald-500 flex-shrink-0">
                                    <span class="text-slate-400 dark:text-slate-400 text-[11px] uppercase tracking-wider font-bold">Show:</span>
                                    <select id="entries" class="bg-transparent border-0 text-xs font-bold text-emerald-700 dark:text-emerald-400 focus:outline-none cursor-pointer py-1 pr-1">
                                        <option value="15" selected class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">15</option>
                                        <option value="50" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">50</option>
                                        <option value="100" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">100</option>
                                        <option value="200" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">200</option>
                                        <option value="500" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200">500</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Desktop Table (SL header, Action on the far right, Unified container border) -->
                        <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                            <table id="printTable" class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                        <th class="p-[10px] text-center w-[40px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                        <th class="p-[10px] text-start w-[120px] whitespace-nowrap">Customer ID</th>
                                        <th class="p-[10px] text-center w-[60px] whitespace-nowrap">Image</th>
                                        <th class="p-[10px] text-start whitespace-nowrap">Customer Name</th>
                                        <th class="p-[10px] text-start w-[140px] whitespace-nowrap">Mobile</th>
                                        <th class="p-[10px] text-end w-[130px] whitespace-nowrap">Total Due Amount</th>
                                        <th class="p-[10px] text-center w-[90px] whitespace-nowrap">Status</th>
                                        <th class="p-[10px] text-center w-[75px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableList" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200"></tbody>
                                <tfoot class="bg-slate-50/90 dark:bg-slate-800/70 text-slate-800 dark:text-slate-100 font-bold border-t-2 border-emerald-600/30 dark:border-emerald-600/20 text-xs sm:text-sm">
                                    <tr>
                                        <td colspan="5" class="p-[10px] text-end font-bold text-slate-600 dark:text-slate-300">Total Due:</td>
                                        <td id="total_previous_due_amount" class="p-[10px] text-end font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">৳ 0.00</td>
                                        <td class="p-[10px]"></td>
                                        <td class="p-[10px]"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- 4. Mobile Card List View (Shown on Mobile Screens < 768px) -->
                        <div id="mobileCardList" class="block md:hidden mb-3 space-y-3"></div>

                        <!-- 5. Modern Smart Pagination and Display Info Footer -->
                        <div class="flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-800 gap-3">
                            <div id="display-info"></div>
                            <div id="pagination" class="flex items-center gap-1 sm:gap-1.5 flex-nowrap justify-center max-w-full overflow-x-auto pb-1"></div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- 6. Sticky Bottom Copyright Section -->
            <div class="copyright sticky bottom-0 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 py-3 text-center shadow-[0_-4px_12px_rgba(0,0,0,0.03)]">
                <footer class="footer text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                    &copy; {{ date('Y') }} MARSS CORPORATION | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-bold hover:underline transition-colors">CodeNext IT</a>
                </footer>
            </div>

        </div>
    </div>
    <!-- Hero Main Content End -->

    <!-- ==========================================
         CREATE CUSTOMER MODAL (Matching Image 2)
         ========================================== -->
    <div class="modal fade" id="createCustomerModal" tabindex="-1" aria-labelledby="createCustomerModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                
                <!-- Sticky Top Green Header -->
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.2); color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
                            </svg>
                        </div>
                        <h5 class="modal-title m-0 text-white fw-bold" id="createCustomerModalLabel" style="font-size: 16px; color: #ffffff !important;">Add New Customer</h5>
                    </div>
                    <!-- Circular Red Close Button with White Icon -->
                    <button type="button" class="custom-modal-close-btn closes d-flex align-items-center justify-content-center border-0 shadow-sm" data-bs-dismiss="modal" onclick="closeCustomerModal()" aria-label="Close" style="position: relative !important; top: auto !important; right: auto !important; width: 26px !important; height: 26px !important; min-width: 26px !important; min-height: 26px !important; border-radius: 50% !important; background-color: #ef4444 !important; color: #ffffff !important; cursor: pointer !important; transition: all 0.2s ease; padding: 0 !important; margin: 0 !important; flex-shrink: 0 !important;" title="Close">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <!-- Scrollable Modal Body -->
                <div class="modal-body custom-scrollbar text-start" style="text-align: left !important;">
                    <form onsubmit="return CustomerDataSave(event)" id="createCustomerForm" class="text-start" style="text-align: left !important;">
                        <div class="row g-2.5 text-start" style="text-align: left !important;">
                            
                            <!-- Customer Name -->
                            <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                                <label for="CreateCustomerName" class="customer-modal-label text-start" style="text-align: left !important;">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" id="CreateCustomerName" placeholder="Enter Customer Name" required class="customer-modal-input text-start" style="text-align: left !important;" />
                            </div>

                            <!-- Customer Mobile -->
                            <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                                <label for="CreateCustomerMobile" class="customer-modal-label text-start" style="text-align: left !important;">Customer Number <span class="text-danger">*</span></label>
                                <input type="text" id="CreateCustomerMobile" placeholder="Enter Customer Number" required class="customer-modal-input text-start" style="text-align: left !important;" />
                            </div>

                            <!-- Customer Email -->
                            <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                                <label for="CreateCustomerEmail" class="customer-modal-label text-start" style="text-align: left !important;">Customer Email</label>
                                <input type="email" id="CreateCustomerEmail" placeholder="Enter Customer Email" class="customer-modal-input text-start" style="text-align: left !important;" />
                            </div>

                            <!-- NID Number -->
                            <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                                <label for="CreateCustomerNIDNumber" class="customer-modal-label text-start" style="text-align: left !important;">NID Number</label>
                                <input type="text" id="CreateCustomerNIDNumber" placeholder="Enter NID Number" class="customer-modal-input text-start" style="text-align: left !important;" />
                            </div>

                            <!-- Previous Due Amount -->
                            <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                                <label for="CreateCustomerPreviousDue" class="customer-modal-label text-start" style="text-align: left !important;">Previous Due Amount</label>
                                <input type="number" step="any" id="CreateCustomerPreviousDue" placeholder="0.00" class="customer-modal-input text-start" style="text-align: left !important;" />
                            </div>

                            <!-- Address Details -->
                            <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                                <label for="CreateCustomerAddressDetails" class="customer-modal-label text-start" style="text-align: left !important;">Address Details</label>
                                <textarea id="CreateCustomerAddressDetails" rows="1" placeholder="Enter Address Details" class="customer-modal-input text-start" style="height: 42px; padding: 9px 14px; resize: none; text-align: left !important;"></textarea>
                            </div>

                            <!-- Upload Photo -->
                            <div class="col-12 text-start" style="text-align: left !important;">
                                <label class="customer-modal-label text-start" style="text-align: left !important;">Customer Photo</label>
                                <div class="customer-photo-upload-box d-flex align-items-center justify-content-start gap-3 text-start" style="text-align: left !important; justify-content: flex-start !important;">
                                    <div class="img-box position-relative flex-shrink-0" id="customerImagePreviewBox">
                                        <svg id="customerImageDefaultSvg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width: 28px; height: 28px; color: #94a3b8;">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                            <polyline points="21 15 16 10 5 21"></polyline>
                                        </svg>
                                        <img id="customerImagePreviewImg" src="" alt="Preview" style="display: none; width: 100%; height: 100%; object-fit: cover; border-radius: 7px;" />
                                    </div>

                                    <div class="flex-grow-1 min-w-0 text-start" style="text-align: left !important;">
                                        <div class="d-flex justify-content-start text-start" style="text-align: left !important;">
                                            <label class="customer-file-btn d-inline-flex align-items-center gap-2 px-3">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; color: #16a34a;">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                    <polyline points="17 8 12 3 7 8"></polyline>
                                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                                </svg>
                                                <span>Upload Photo</span>
                                                <input type="file" class="d-none" id="CreateCustomerImage" aria-label="Upload Photo" accept="image/*" onchange="previewCustomerImage(event)" />
                                            </label>
                                        </div>
                                        <p id="customerImageInfo" class="customer-photo-info mt-1.5 mb-0 text-start" style="text-align: left !important;">PNG, JPEG or GIF (up to 1 MB)</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <!-- Sticky Bottom Footer with Red Cancel & Green Save Buttons (Strict 38px height) -->
                <div class="modal-footer d-flex align-items-center justify-content-end gap-2 flex-shrink-0">
                    <button type="button" onclick="closeCustomerModal()" class="btn fw-semibold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important; cursor: pointer; transition: opacity 0.2s;">
                        Cancel
                    </button>
                    <button type="button" onclick="CustomerDataSave(event)" class="btn text-white fw-bold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; font-size: 13.5px !important; cursor: pointer;">
                        Submit
                    </button>
                </div>

            </div>
        </div>
    </div>    <!-- ==========================================
         EDIT CUSTOMER MODAL (Matching Retail)
         ========================================== -->
    <div class="modal fade" id="customerEditModal" tabindex="-1" aria-labelledby="customerEditModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                
                <!-- Sticky Top Green Header -->
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.2); color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L7 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                        <h5 class="modal-title m-0 text-white fw-bold" id="customerEditModalLabel" style="font-size: 16px; color: #ffffff !important;">Update Customer</h5>
                    </div>
                    <!-- Circular Red Close Button with White Icon -->
                    <button type="button" class="custom-modal-close-btn closes d-flex align-items-center justify-content-center border-0 shadow-sm" data-bs-dismiss="modal" aria-label="Close" style="position: relative !important; top: auto !important; right: auto !important; width: 26px !important; height: 26px !important; min-width: 26px !important; min-height: 26px !important; border-radius: 50% !important; background-color: #ef4444 !important; color: #ffffff !important; cursor: pointer !important; transition: all 0.2s ease; padding: 0 !important; margin: 0 !important; flex-shrink: 0 !important;" title="Close">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <!-- Scrollable Modal Body -->
                <div class="modal-body custom-scrollbar text-start" style="text-align: left !important;">
                    <form onsubmit="return Update(event)" class="text-start" style="text-align: left !important;">
                        <input class="d-none" id="updateID" type="hidden">

                        <div class="row g-2.5 text-start" style="text-align: left !important;">
                            
                            <!-- Customer Name -->
                            <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                                <label for="UpdateCustomerName" class="customer-modal-label text-start" style="text-align: left !important;">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" id="UpdateCustomerName" placeholder="Enter Customer Name" required class="customer-modal-input text-start" style="text-align: left !important;" />
                            </div>

                            <!-- Customer Mobile -->
                            <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                                <label for="UpdateCustomerNumber" class="customer-modal-label text-start" style="text-align: left !important;">Customer Number <span class="text-danger">*</span></label>
                                <input type="text" id="UpdateCustomerNumber" placeholder="Enter Customer Number" required class="customer-modal-input text-start" style="text-align: left !important;" />
                            </div>

                            <!-- Customer Email -->
                            <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                                <label for="UpdateCustomerEmail" class="customer-modal-label text-start" style="text-align: left !important;">Customer Email</label>
                                <input type="email" id="UpdateCustomerEmail" placeholder="Enter Customer Email" class="customer-modal-input text-start" style="text-align: left !important;" />
                            </div>

                            <!-- NID Number -->
                            <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                                <label for="UpdateCustomerNid" class="customer-modal-label text-start" style="text-align: left !important;">NID Number</label>
                                <input type="text" id="UpdateCustomerNid" placeholder="Enter NID Number" class="customer-modal-input text-start" style="text-align: left !important;" />
                            </div>

                            <!-- Previous Due Amount -->
                            <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                                <label for="UpdateCustomerPreviousDueAmount" class="customer-modal-label text-start" style="text-align: left !important;">Previous Due Amount</label>
                                <input type="number" step="any" id="UpdateCustomerPreviousDueAmount" placeholder="0.00" class="customer-modal-input text-start" style="text-align: left !important;" />
                            </div>

                            <!-- Address Details -->
                            <div class="col-md-6 col-12 text-start" style="text-align: left !important;">
                                <label for="UpdateMoreAddress" class="customer-modal-label text-start" style="text-align: left !important;">Address Details</label>
                                <textarea id="UpdateMoreAddress" rows="1" placeholder="Enter Address Details" class="customer-modal-input text-start" style="height: 42px; padding: 9px 14px; resize: none; text-align: left !important;"></textarea>
                            </div>

                            <!-- Upload Photo -->
                            <div class="col-12 text-start" style="text-align: left !important;">
                                <label class="customer-modal-label text-start" style="text-align: left !important;">Customer Photo</label>
                                <div class="customer-photo-upload-box d-flex align-items-center justify-content-start gap-3 text-start" style="text-align: left !important; justify-content: flex-start !important;">
                                    <div class="img-box position-relative flex-shrink-0" id="updateCustomerImagePreviewBox">
                                        <svg id="updateCustomerImageDefaultSvg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width: 28px; height: 28px; color: #94a3b8;">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                            <polyline points="21 15 16 10 5 21"></polyline>
                                        </svg>
                                        <img id="updateCustomerImagePreviewImg" src="" alt="Preview" style="display: none; width: 100%; height: 100%; object-fit: cover; border-radius: 7px;" />
                                    </div>

                                    <div class="flex-grow-1 min-w-0 text-start" style="text-align: left !important;">
                                        <div class="d-flex justify-content-start text-start" style="text-align: left !important;">
                                            <label class="customer-file-btn d-inline-flex align-items-center gap-2 px-3">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; color: #16a34a;">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                    <polyline points="17 8 12 3 7 8"></polyline>
                                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                                </svg>
                                                <span>Upload Photo</span>
                                                <input type="file" class="d-none" id="UpdateCustomerImage" aria-label="Upload Photo" accept="image/*" onchange="previewUpdateCustomerImage(event)" />
                                            </label>
                                        </div>
                                        <p id="updateCustomerImageInfo" class="customer-photo-info mt-1.5 mb-0 text-start" style="text-align: left !important;">PNG, JPEG or GIF (up to 1 MB)</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <!-- Sticky Bottom Footer with Red Cancel & Green Update Buttons (Strict 38px height) -->
                <div class="modal-footer d-flex align-items-center justify-content-end gap-2 flex-shrink-0">
                    <button type="button" data-bs-dismiss="modal" class="btn fw-semibold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; font-size: 13.5px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important; cursor: pointer; transition: opacity 0.2s;">
                        Cancel
                    </button>
                    <button type="button" onclick="Update(event)" class="btn text-white fw-bold px-4 shadow-sm" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; border-radius: 8px !important; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important; border: none !important; font-size: 13.5px !important; cursor: pointer;">
                        Update
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- ==========================================
         DELETE CUSTOMER CONFIRMATION MODAL
         ========================================== -->
    <div class="modal fade" id="customerDeleteModal" tabindex="-1" aria-labelledby="customerDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm sm:modal-md my-3" style="max-width: 440px;">
            <div class="modal-content bg-white dark:bg-slate-900 border-0 rounded-2xl shadow-2xl overflow-hidden transition-colors flex flex-col" style="border: none !important;">
                
                <!-- Sticky Top Header -->
                <div class="modal-header sticky top-0 z-20 px-4 sm:px-5 py-3.5 bg-rose-600 text-white flex items-center justify-between shadow-sm border-0 flex-shrink-0" style="background-color: #dc2626 !important; color: #ffffff !important; border: none !important;">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/20 text-white flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </div>
                        <h5 class="modal-title text-base font-bold text-white tracking-tight mb-0" id="customerDeleteModalLabel" style="color: #ffffff !important;">Delete Customer</h5>
                    </div>
                    <!-- Circular Red Close Button with White Icon -->
                    <button type="button" class="qv-close-btn" data-bs-dismiss="modal" aria-label="Close" style="width: 30px !important; height: 30px !important; min-width: 30px !important; min-height: 30px !important; border-radius: 50% !important; background-color: #991b1b !important; color: #ffffff !important; border: none !important; display: flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; padding: 0 !important; margin: 0 !important;">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body p-4 text-center">
                    <div class="w-14 h-14 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto mb-3.5 border border-rose-100 dark:border-slate-800">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                            <line x1="12" y1="9" x2="12" y2="13"></line>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                    </div>
                    <h4 class="text-base sm:text-lg font-bold text-slate-800 dark:text-slate-100 mb-1.5">Confirm Deletion</h4>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mb-0">Are you sure you want to delete this customer? This action cannot be undone.</p>
                    <input type="hidden" id="deleteID" />
                </div>

                <!-- Sticky Bottom Footer (Strict 38px buttons) -->
                <div class="modal-footer sticky bottom-0 z-20 px-4 sm:px-5 py-3 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 flex items-center justify-center gap-2.5 flex-shrink-0">
                    <button type="button" class="px-4 h-[38px] min-h-[38px] max-h-[38px] rounded-xl text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 unified-ui-border text-xs sm:text-sm font-semibold transition-all shadow-sm flex items-center justify-center cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" onclick="itemDelete()" class="px-5 h-[38px] min-h-[38px] max-h-[38px] rounded-xl text-white text-xs sm:text-sm font-semibold transition-all shadow-sm flex items-center justify-center cursor-pointer hover:bg-rose-700 active:scale-[0.98]" style="height: 38px !important; min-height: 38px !important; max-height: 38px !important; background-color: #dc2626 !important; color: #ffffff !important; border: none !important;">
                        Yes, Delete
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Styles -->
    <style>
        .product-card-body {
            padding: 10px !important;
        }
        @media (min-width: 768px) {
            .product-card-body {
                padding: 16px !important;
            }
        }

        .unified-ui-border {
            border: 1.5px solid #cbd5e1 !important;
        }

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

        #printTable thead th {
            white-space: nowrap !important;
            padding: 10px !important;
        }
        #printTable tbody td,
        #printTable tfoot td {
            padding: 10px !important;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.25rem 0.65rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
        }
        .badge.active-status {
            background-color: #10b981 !important;
            color: #ffffff !important;
            box-shadow: 0 1px 2px rgba(16, 185, 129, 0.2);
            font-size: 10px !important;
            padding: 2px 8px !important;
        }
        .badge.inactive-status {
            background-color: #ef4444 !important;
            color: #ffffff !important;
            box-shadow: 0 1px 2px rgba(239, 68, 68, 0.2);
            font-size: 10px !important;
            padding: 2px 8px !important;
        }

        /* + Create Customer Button Fix: strict 38px height & keep white text on hover */
        #openModalBtns {
            height: 38px !important;
            min-height: 38px !important;
            max-height: 38px !important;
            background-color: #15803d !important;
            color: #ffffff !important;
            border: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
        }
        #openModalBtns:hover,
        #openModalBtns:focus,
        #openModalBtns:active {
            background-color: #16a34a !important;
            color: #ffffff !important;
            border: none !important;
        }
        #openModalBtns * {
            color: #ffffff !important;
        }

        /* Action buttons light mode styling: Prevent turning white on hover */
        #printTable td .edit-link,
        #tableList td .edit-link,
        .customer-mobile-card .edit-link {
            background-color: #ecfdf5 !important;
            color: #15803d !important;
            border: 1px solid #bbf7d0 !important;
            transition: all 0.2s ease !important;
        }
        #printTable td .edit-link:hover,
        #tableList td .edit-link:hover,
        .customer-mobile-card .edit-link:hover {
            background-color: #16a34a !important;
            color: #ffffff !important;
            border-color: #16a34a !important;
        }
        #printTable td .edit-link:hover svg,
        #tableList td .edit-link:hover svg,
        .customer-mobile-card .edit-link:hover svg {
            color: #ffffff !important;
            stroke: #ffffff !important;
        }

        #printTable td .custom-delete-modal-btn,
        #tableList td .custom-delete-modal-btn,
        .customer-mobile-card .custom-delete-modal-btn {
            background-color: #fff1f2 !important;
            color: #e11d48 !important;
            border: 1px solid #fecdd3 !important;
            transition: all 0.2s ease !important;
        }
        #printTable td .custom-delete-modal-btn:hover,
        #tableList td .custom-delete-modal-btn:hover,
        .customer-mobile-card .custom-delete-modal-btn:hover {
            background-color: #e11d48 !important;
            color: #ffffff !important;
            border-color: #e11d48 !important;
        }
        #printTable td .custom-delete-modal-btn:hover svg,
        #tableList td .custom-delete-modal-btn:hover svg,
        .customer-mobile-card .custom-delete-modal-btn:hover svg {
            color: #ffffff !important;
            stroke: #ffffff !important;
        }

        /* Modal Centering & Reset */
        .modal {
            background: rgba(15, 23, 42, 0.6) !important;
            backdrop-filter: blur(4px) !important;
            -webkit-backdrop-filter: blur(4px) !important;
            z-index: 1060 !important;
        }
        .modal.show {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .modal .modal-dialog,
        #createCustomerModal .modal-dialog,
        #customerEditModal .modal-dialog,
        #exampleModal .modal-dialog,
        #customerDeleteModal .modal-dialog,
        #confirmationModal .modal-dialog {
            position: static !important;
            top: auto !important;
            left: auto !important;
            right: auto !important;
            bottom: auto !important;
            transform: none !important;
            margin: auto !important;
            background: transparent !important;
            background-color: transparent !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            min-width: auto !important;
            height: auto !important;
            max-height: none !important;
            overflow: visible !important;
        }
        .modal .modal-dialog form,
        #customerEditModal .modal-dialog form,
        #exampleModal .modal-dialog form,
        #customerDeleteModal .modal-dialog form,
        #confirmationModal .modal-dialog form {
            background: transparent !important;
            padding: 0 !important;
            margin: 0 !important;
            max-height: none !important;
            overflow: visible !important;
        }
        #createCustomerModal .modal-dialog,
        #customerEditModal .modal-dialog,
        #exampleModal .modal-dialog {
            max-width: 720px !important;
            width: 95% !important;
            margin: auto !important;
            max-height: 90vh !important;
            height: auto !important;
            display: flex !important;
            align-items: center !important;
        }
        #customerDeleteModal .modal-dialog,
        #confirmationModal .modal-dialog {
            max-width: 440px !important;
            width: 92% !important;
            margin: auto !important;
        }
        #createCustomerModal .modal-content,
        #customerEditModal .modal-content,
        #exampleModal .modal-content {
            border-radius: 16px !important;
            overflow: hidden !important;
            border: 1px solid #f1f5f9 !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            background: #ffffff !important;
            width: 100% !important;
            max-height: 90vh !important;
            display: flex !important;
            flex-direction: column !important;
        }
        #customerDeleteModal .modal-content,
        #confirmationModal .modal-content {
            border-radius: 16px !important;
            border: none !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            background: #ffffff !important;
            overflow: hidden !important;
        }
        #createCustomerModal .modal-header,
        #customerEditModal .modal-header,
        #exampleModal .modal-header {
            background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important;
            border-bottom: none !important;
            padding: 14px 20px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-shrink: 0 !important;
        }
        #createCustomerModal .modal-body,
        #customerEditModal .modal-body,
        #exampleModal .modal-body {
            padding: 20px 24px !important;
            overflow-y: auto !important;
            flex-grow: 1 !important;
            max-height: calc(90vh - 120px) !important;
        }
        #createCustomerModal .modal-footer,
        #customerEditModal .modal-footer,
        #exampleModal .modal-footer {
            background: #f8fafc !important;
            border-top: 1px solid #f1f5f9 !important;
            padding: 12px 24px !important;
        }

        .customer-modal-label {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #334155 !important;
            margin-bottom: 6px !important;
            display: block !important;
        }
        .customer-modal-input {
            width: 100% !important;
            height: 42px !important;
            border-radius: 8px !important;
            border: 1.5px solid #cbd5e1 !important;
            padding: 8px 14px !important;
            font-size: 13.5px !important;
            color: #1e293b !important;
            background-color: #ffffff !important;
            outline: none !important;
            transition: all 0.2s ease !important;
            box-sizing: border-box !important;
        }
        .customer-modal-input:focus {
            border-color: #15803d !important;
            box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.15) !important;
        }

        .customer-photo-upload-box {
            border: 1.5px dashed #cbd5e1 !important;
            border-radius: 12px !important;
            padding: 12px 16px !important;
            background: #f8fafc !important;
        }
        .customer-photo-upload-box .img-box {
            width: 54px !important;
            height: 54px !important;
            border-radius: 8px !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            overflow: hidden !important;
        }
        .customer-file-btn {
            background: #ffffff !important;
            border: 1.5px solid #cbd5e1 !important;
            border-radius: 8px !important;
            font-size: 12.5px !important;
            font-weight: 600 !important;
            color: #334155 !important;
            padding: 6px 12px !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }
        .customer-file-btn:hover {
            border-color: #15803d !important;
            color: #15803d !important;
        }
        .customer-photo-info {
            font-size: 11.5px !important;
            color: #64748b !important;
        }

        /* Dark mode overrides */
        body[light-mode="dark"] .card,
        html.dark .card {
            background-color: #0f172a !important;
            border-color: #334155 !important;
        }
        body[light-mode="dark"] .unified-ui-border,
        html.dark .unified-ui-border {
            border-color: #334155 !important;
        }
        body[light-mode="dark"] #printTable thead th {
            background-color: #14532d !important;
            color: #ffffff !important;
        }
        body[light-mode="dark"] #printTable tbody tr:hover {
            background-color: rgba(30, 41, 59, 0.6) !important;
        }
        body[light-mode="dark"] #printTable td,
        body[light-mode="dark"] #printTable tfoot td {
            color: #f1f5f9 !important;
            border-color: #334155 !important;
        }
        body[light-mode="dark"] #printTable tfoot tr {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
        body[light-mode="dark"] .copyright {
            background-color: rgba(15, 23, 42, 0.95) !important;
            border-color: #334155 !important;
        }
        body[light-mode="dark"] #createCustomerModal .modal-content,
        body[light-mode="dark"] #exampleModal .modal-content,
        html.dark #createCustomerModal .modal-content,
        html.dark #exampleModal .modal-content {
            background-color: #0f172a !important;
            border-color: #334155 !important;
        }
        body[light-mode="dark"] #createCustomerModal .modal-footer,
        body[light-mode="dark"] #exampleModal .modal-footer,
        html.dark #createCustomerModal .modal-footer,
        html.dark #exampleModal .modal-footer {
            background-color: #0f172a !important;
            border-top-color: #334155 !important;
        }
        body[light-mode="dark"] .customer-modal-label,
        html.dark .customer-modal-label {
            color: #cbd5e1 !important;
        }
        body[light-mode="dark"] .customer-modal-input,
        html.dark .customer-modal-input {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        body[light-mode="dark"] .customer-photo-upload-box,
        html.dark .customer-photo-upload-box {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
        body[light-mode="dark"] .customer-photo-upload-box .img-box,
        html.dark .customer-photo-upload-box .img-box {
            background-color: #0f172a !important;
            border-color: #334155 !important;
        }
        body[light-mode="dark"] .customer-file-btn,
        html.dark .customer-file-btn {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }
        body[light-mode="dark"] #printTable td .edit-link,
        html.dark #printTable td .edit-link {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #34d399 !important;
        }
        body[light-mode="dark"] #printTable td .custom-delete-modal-btn,
        html.dark #printTable td .custom-delete-modal-btn {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f87171 !important;
        }
    </style>

    <!-- Scripts -->
    <script>
        let rawCustomerData = [];
        let currentPage = 1;
        let pageSize = 15;

        $(document).ready(function () {
            // Append modals to body so stacking context / CSS transforms never offset them
            $('#createCustomerModal').appendTo('body');
            $('#customerEditModal').appendTo('body');
            $('#customerDeleteModal').appendTo('body');
            $('#exampleModal').appendTo('body');
            $('#confirmationModal').appendTo('body');

            getList();

            $("#entries").on("change", function () {
                pageSize = parseInt($(this).val()) || 15;
                currentPage = 1;
                renderPaginatedList();
            });

            $("#searchInput").on("keyup input", function () {
                currentPage = 1;
                renderPaginatedList();
            });

            $('#customerEditModal, #exampleModal').on('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (button) {
                    const id = $(button).data('id') || $(button).attr('data-id');
                    if (id) {
                        FillUpUpdateForm(id);
                    }
                }
            });
        });

        function formatBdCurrency(amount) {
            let num = parseFloat(amount) || 0;
            return num.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        async function getList() {
            try {
                if (typeof showLoader === 'function') showLoader();
                let res = await axios.get("/api/battery/customer-list", HeaderToken());
                if (typeof hideLoader === 'function') hideLoader();

                if (res.data.status === "success" && Array.isArray(res.data.CustomerData)) {
                    rawCustomerData = res.data.CustomerData;
                    renderPaginatedList();
                } else {
                    console.error("Failed to fetch customers: No data found.");
                }
            } catch (error) {
                if (typeof hideLoader === 'function') hideLoader();
                console.error("Error fetching customer list:", error);
                if (typeof unauthorized === 'function') {
                    unauthorized(error.response ? error.response.status : 500);
                }
            }
        }

        function renderPaginatedList() {
            if (!rawCustomerData) return;

            let searchTerm = $("#searchInput").val().toLowerCase().trim();

            // 1. Filter Customers
            let filtered = rawCustomerData.filter(function (item) {
                let customerId = (item.customer_id || "").toLowerCase();
                let name = (item.customer_name || "").toLowerCase();
                let mobile = (item.mobile || "").toLowerCase();

                return !searchTerm || customerId.includes(searchTerm) || name.includes(searchTerm) || mobile.includes(searchTerm);
            });

            // Ensure newly added records appear at the top
            filtered.sort((a, b) => (b.id || 0) - (a.id || 0));

            // 2. Calculate Totals
            let totalDueAmount = 0;
            filtered.forEach(item => {
                totalDueAmount += parseFloat(item.total_due) || 0;
            });
            $("#total_previous_due_amount").text(`৳ ${formatBdCurrency(totalDueAmount)}`);

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
                tableList.html('<tr><td colspan="8" class="text-center text-rose-500 p-8 font-semibold"><svg class="w-6 h-6 mx-auto mb-2 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>No customers found.</td></tr>');
                mobileCardList.html('<div class="p-6 text-center text-rose-500 font-semibold bg-white dark:bg-slate-800 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm">No customers found.</div>');
            } else {
                pageItems.forEach(function (item, idx) {
                    let realIndex = startIndex + idx;
                    const img_url = item.img_url ? (item.img_url.startsWith('http') || item.img_url.startsWith('/') ? item.img_url : '/' + item.img_url) : "{{ asset('backend/assets/img/brand-defult-img.svg') }}";
                    let totalDue = parseFloat(item.total_due) || 0;
                    let isActive = (item.status || 'Active') === 'Active';
                    let statusBadgeClass = isActive ? "active-status" : "inactive-status";
                    let statusText = item.status || 'Active';
                    let customerName = item.customer_name || 'N/A';

                    // Modern Action Buttons (Edit and Delete)
                    let actionHtml = `
                        <div class="flex items-center justify-center gap-1.5">
                            <button data-id="${item.id}" type="button" class="edit-link w-[30px] h-[30px] rounded-lg bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200/80 hover:border-emerald-600 dark:bg-emerald-950/40 dark:border-slate-800 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white flex items-center justify-center transition-all duration-150 shadow-sm" data-bs-toggle="modal" data-bs-target="#customerEditModal" title="Edit Customer">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9"></path>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                </svg>
                            </button>
                            <button data-id="${item.id}" type="button" class="custom-delete-modal-btn w-[30px] h-[30px] rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200/80 hover:border-rose-600 dark:bg-rose-950/40 dark:border-slate-800 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white flex items-center justify-center transition-all duration-150 shadow-sm" data-bs-toggle="modal" data-bs-target="#customerDeleteModal" title="Delete Customer">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </button>
                        </div>
                    `;

                    // Desktop Table Row
                    let row = `
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors border-b border-slate-100 dark:border-slate-800">
                            <td class="p-[10px] text-center font-semibold text-slate-400 dark:text-slate-500">${realIndex + 1}</td>
                            <td class="p-[10px] text-start whitespace-nowrap">
                                <a href="/battery/customer/profile/${item.id}" class="inline-flex items-center gap-1 font-mono font-bold text-xs text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 hover:underline">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    ${item.customer_id || 'N/A'}
                                </a>
                            </td>
                            <td class="p-[10px] text-center">
                                <img style="width: 32px !important; height: 32px !important; min-width: 32px !important; min-height: 32px !important; max-width: 32px !important; max-height: 32px !important; border-radius: 50% !important; object-fit: cover !important;" class="rounded-full border border-slate-300 dark:border-slate-800 shadow-sm mx-auto bg-slate-50 dark:bg-slate-800" alt="${customerName}" src="${img_url}" onerror="this.src='{{ asset('backend/assets/img/brand-defult-img.svg') }}'">
                            </td>
                            <td class="p-[10px] text-start">
                                <a href="/battery/customer/profile/${item.id}" class="font-bold text-slate-800 dark:text-slate-100 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors text-sm leading-snug">${customerName}</a>
                            </td>
                            <td class="p-[10px] text-start font-medium text-slate-600 dark:text-slate-300 whitespace-nowrap">${item.mobile || '-'}</td>
                            <td class="p-[10px] text-end font-bold ${totalDue > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-800 dark:text-slate-100'} whitespace-nowrap">৳ ${formatBdCurrency(totalDue)}</td>
                            <td class="p-[10px] text-center whitespace-nowrap">
                                <span class="badge ${statusBadgeClass}">${statusText}</span>
                            </td>
                            <td class="p-[10px] text-center">${actionHtml}</td>
                        </tr>`;
                    tableList.append(row);

                    // Mobile Card View
                    let mobileCard = `
                        <div class="customer-mobile-card unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800/90 shadow-sm transition-all mb-3">
                            <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100 dark:border-slate-800">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="badge bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold" style="font-size: 10px;">#${realIndex + 1}</span>
                                    <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-slate-800 font-semibold" style="font-size: 10px;">
                                        <i class="fa-solid fa-user me-1 text-emerald-600"></i>${item.customer_id || 'N/A'}
                                    </span>
                                </div>
                                <div>
                                    <span class="badge ${statusBadgeClass}">${statusText}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2.5 mb-2">
                                <img src="${img_url}" alt="${customerName}" style="width: 32px !important; height: 32px !important; min-width: 32px !important; min-height: 32px !important; max-width: 32px !important; max-height: 32px !important; border-radius: 50% !important; object-fit: cover !important;" class="rounded-full border border-slate-300 dark:border-slate-800 flex-shrink-0 shadow-sm bg-slate-50 dark:bg-slate-800" onerror="this.src='{{ asset('backend/assets/img/brand-defult-img.svg') }}'" />
                                <div class="overflow-hidden">
                                    <h6 class="font-bold text-slate-800 dark:text-slate-100 mb-0.5 truncate text-sm leading-snug">${customerName}</h6>
                                    <div class="flex items-center gap-1 text-slate-500 dark:text-slate-400 text-xs">
                                        <svg class="w-3.5 h-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        <span>${item.mobile || 'No Mobile'}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-2 bg-slate-50 dark:bg-slate-900/50 p-2.5 rounded-xl my-2 text-center items-center border border-slate-100 dark:border-slate-800">
                                <div class="border-r border-slate-300 dark:border-slate-800 text-start px-2">
                                    <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">Total Due</span>
                                    <span class="font-bold ${totalDue > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-800 dark:text-slate-100'} text-sm">৳ ${formatBdCurrency(totalDue)}</span>
                                </div>
                                <div class="text-start px-2">
                                    <span class="text-slate-400 block text-[9px] font-bold uppercase tracking-wider">Profile</span>
                                    <a href="/battery/customer/profile/${item.id}" class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">View Details &rarr;</a>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-2.5 mt-1 border-t border-slate-100 dark:border-slate-800">
                                <a href="/battery/customer/profile/${item.id}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-700 dark:text-slate-200 hover:text-emerald-600 dark:hover:text-emerald-400">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <span>Profile</span>
                                </a>
                                <div>${actionHtml}</div>
                            </div>
                        </div>
                    `;
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

        // ==========================================
        // CREATE CUSTOMER MODAL LOGIC
        // ==========================================
        function openCustomerCreateModal() {
            const signupForm = document.getElementById("createCustomerForm");
            if (signupForm) signupForm.reset();
            resetCustomerImagePreview();
            const modalEl = document.getElementById('createCustomerModal');
            if (modalEl) {
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            }
        }

        function closeCustomerModal() {
            const modalEl = document.getElementById('createCustomerModal');
            if (modalEl) {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            }
            const signupForm = document.getElementById("createCustomerForm");
            if (signupForm) signupForm.reset();
            resetCustomerImagePreview();
        }

        function previewCustomerImage(event) {
            const file = event.target.files && event.target.files[0];
            const previewImg = document.getElementById('customerImagePreviewImg');
            const defaultSvg = document.getElementById('customerImageDefaultSvg');
            const infoP = document.getElementById('customerImageInfo');

            if (file) {
                let sizeFormatted = file.size < 1048576 
                    ? (file.size / 1024).toFixed(1) + ' KB' 
                    : (file.size / (1024 * 1024)).toFixed(2) + ' MB';

                if (infoP) {
                    infoP.innerHTML = `<span style="color: #15803d; font-weight: 700;"><i class="fa-solid fa-circle-check me-1"></i>${file.name}</span> <span style="background: #e2e8f0; color: #334155; font-size: 11px; padding: 2px 6px; border-radius: 4px; font-weight: 600; margin-left: 4px;">${sizeFormatted}</span>`;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewImg) {
                        previewImg.src = e.target.result;
                        previewImg.style.display = 'block';
                    }
                    if (defaultSvg) {
                        defaultSvg.style.display = 'none';
                    }
                };
                reader.readAsDataURL(file);
            } else {
                resetCustomerImagePreview();
            }
        }

        function resetCustomerImagePreview() {
            const previewImg = document.getElementById('customerImagePreviewImg');
            const defaultSvg = document.getElementById('customerImageDefaultSvg');
            const infoP = document.getElementById('customerImageInfo');
            const fileInput = document.getElementById('CreateCustomerImage');
            if (fileInput) fileInput.value = '';
            if (previewImg) {
                previewImg.src = '';
                previewImg.style.display = 'none';
            }
            if (defaultSvg) {
                defaultSvg.style.display = 'block';
            }
            if (infoP) {
                infoP.textContent = 'PNG, JPEG or GIF (up to 1 MB)';
            }
        }

        async function CustomerDataSave(event) {
            if (event) event.preventDefault();

            try {
                let CustomerName = $('#CreateCustomerName').val().trim();
                let CustomerMobile = $('#CreateCustomerMobile').val().trim();
                let CustomerEmail = $('#CreateCustomerEmail').val().trim();
                let CustomerNIDNumber = $('#CreateCustomerNIDNumber').val().trim();
                let PreviousDueAmount = $('#CreateCustomerPreviousDue').val();
                let more_address_details = $('#CreateCustomerAddressDetails').val().trim();
                let ProductImageInput = document.getElementById('CreateCustomerImage')?.files[0];

                if (!CustomerName) {
                    return errorToast("Customer Name is required!");
                }
                if (!CustomerMobile) {
                    return errorToast("Customer Number is required!");
                }

                let formData = new FormData();
                formData.append('customer_name', CustomerName);
                formData.append('mobile', CustomerMobile);
                formData.append('email', CustomerEmail);
                formData.append('nid', CustomerNIDNumber);
                formData.append('previous_due_amount', PreviousDueAmount || 0);
                formData.append('address_details', more_address_details);
                if (ProductImageInput) {
                    formData.append('img', ProductImageInput);
                }

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data',
                        ...HeaderToken().headers
                    }
                };

                if (typeof showLoader === 'function') showLoader();
                let res = await axios.post("/api/battery/create-customer", formData, config);
                if (typeof hideLoader === 'function') hideLoader();

                if (res.data['status'] === "success") {
                    successToast(res.data['message']);
                    closeCustomerModal();
                    currentPage = 1;
                    await getList();
                } else {
                    errorToast(res.data['message']);
                }
            } catch (e) {
                if (typeof hideLoader === 'function') hideLoader();
                console.error(e);
                errorToast(e.response?.data?.message || 'Failed to save customer');
            }
            return false;
        }

        // ==========================================
        // EDIT CUSTOMER MODAL LOGIC
        // ==========================================
        function previewUpdateCustomerImage(event) {
            const file = event.target.files && event.target.files[0];
            const previewImg = document.getElementById('updateCustomerImagePreviewImg');
            const defaultSvg = document.getElementById('updateCustomerImageDefaultSvg');
            const infoP = document.getElementById('updateCustomerImageInfo');

            if (file) {
                let sizeFormatted = file.size < 1048576 
                    ? (file.size / 1024).toFixed(1) + ' KB' 
                    : (file.size / (1024 * 1024)).toFixed(2) + ' MB';

                if (infoP) {
                    infoP.innerHTML = `<span style="color: #15803d; font-weight: 700;"><i class="fa-solid fa-circle-check me-1"></i>${file.name}</span> <span style="background: #e2e8f0; color: #334155; font-size: 11px; padding: 2px 6px; border-radius: 4px; font-weight: 600; margin-left: 4px;">${sizeFormatted}</span>`;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewImg) {
                        previewImg.src = e.target.result;
                        previewImg.style.display = 'block';
                    }
                    if (defaultSvg) {
                        defaultSvg.style.display = 'none';
                    }
                };
                reader.readAsDataURL(file);
            }
        }

        function resetUpdateCustomerImagePreview() {
            const previewImg = document.getElementById('updateCustomerImagePreviewImg');
            const defaultSvg = document.getElementById('updateCustomerImageDefaultSvg');
            const infoP = document.getElementById('updateCustomerImageInfo');
            const fileInput = document.getElementById('UpdateCustomerImage');
            if (fileInput) fileInput.value = '';
            if (previewImg) {
                previewImg.src = '';
                previewImg.style.display = 'none';
            }
            if (defaultSvg) {
                defaultSvg.style.display = 'block';
            }
            if (infoP) {
                infoP.textContent = 'PNG, JPEG or GIF (up to 1 MB)';
            }
        }

        async function FillUpUpdateForm(id) {
            try {
                document.getElementById('updateID').value = id;
                resetUpdateCustomerImagePreview();
                if (typeof showLoader === 'function') showLoader();

                let res = await axios.post("/api/battery/customer-by-id", {
                    id: id.toString()
                }, HeaderToken());
                if (typeof hideLoader === 'function') hideLoader();

                let data = res.data.rows;
                if (data) {
                    document.getElementById('UpdateCustomerName').value = data.customer_name || '';
                    document.getElementById('UpdateMoreAddress').value = data.address_details || '';
                    document.getElementById('UpdateCustomerNumber').value = data.mobile || '';
                    document.getElementById('UpdateCustomerEmail').value = data.email || '';
                    document.getElementById('UpdateCustomerNid').value = data.nid || '';
                    document.getElementById('UpdateCustomerPreviousDueAmount').value = data.previous_due_amount || 0;

                    if (data.img_url) {
                        const previewImg = document.getElementById('updateCustomerImagePreviewImg');
                        const defaultSvg = document.getElementById('updateCustomerImageDefaultSvg');
                        const imgUrl = data.img_url.startsWith('http') || data.img_url.startsWith('/') ? data.img_url : '/' + data.img_url;
                        if (previewImg) {
                            previewImg.src = imgUrl;
                            previewImg.style.display = 'block';
                        }
                        if (defaultSvg) {
                            defaultSvg.style.display = 'none';
                        }
                    }
                }
            } catch (e) {
                if (typeof hideLoader === 'function') hideLoader();
                console.error(e);
                errorToast('Failed to load customer details');
            }
        }

        async function Update(event) {
            if (event) event.preventDefault();
            try {
                let CustomerName = $('#UpdateCustomerName').val().trim();
                let CustomerNumber = $('#UpdateCustomerNumber').val().trim();
                let CustomerEmail = $('#UpdateCustomerEmail').val().trim();
                let CustomerNid = $('#UpdateCustomerNid').val().trim();
                let CustomerPreviousDueAmount = $('#UpdateCustomerPreviousDueAmount').val();
                let more_address_details = $('#UpdateMoreAddress').val().trim();
                let updateID = $('#updateID').val();
                let ProductImageInput = document.getElementById('UpdateCustomerImage')?.files[0];

                if (!CustomerName) {
                    return errorToast("Customer Name is required!");
                }
                if (!CustomerNumber) {
                    return errorToast("Customer Number is required!");
                }

                let formData = new FormData();
                formData.append('id', updateID);
                formData.append('customer_name', CustomerName);
                formData.append('mobile', CustomerNumber);
                formData.append('email', CustomerEmail);
                formData.append('nid', CustomerNid);
                formData.append('previous_due_amount', CustomerPreviousDueAmount || 0);
                formData.append('address_details', more_address_details);
                if (ProductImageInput) {
                    formData.append('img', ProductImageInput);
                }

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data',
                        ...HeaderToken().headers
                    }
                };

                if (typeof showLoader === 'function') showLoader();
                let res = await axios.post("/api/battery/update-customer", formData, config);
                if (typeof hideLoader === 'function') hideLoader();

                if (res.data['status'] === "success") {
                    successToast(res.data['message']);
                    const modalEl = document.getElementById('customerEditModal') || document.getElementById('exampleModal');
                    if (modalEl) {
                        const modal = bootstrap.Modal.getInstance(modalEl);
                        if (modal) modal.hide();
                    }
                    await getList();
                } else {
                    errorToast(res.data['message']);
                }
            } catch (e) {
                if (typeof hideLoader === 'function') hideLoader();
                console.error(e);
                errorToast(e.response?.data?.message || 'Failed to update customer');
            }
            return false;
        }

        // ==========================================
        // DELETE CUSTOMER MODAL LOGIC
        // ==========================================
        $(document).on('click', '.custom-delete-modal-btn', function() {
            let id = $(this).data('id');
            $('#deleteID').val(id);
        });

        async function itemDelete() {
            try {
                let id = $('#deleteID').val();
                if (!id) return;

                if (typeof showLoader === 'function') showLoader();
                let res = await axios.post("/api/battery/delete-customer", { id: id }, HeaderToken());
                if (typeof hideLoader === 'function') hideLoader();

                if (res.data.status === "success") {
                    successToast(res.data.message);
                    const modalEl = document.getElementById('customerDeleteModal') || document.getElementById('confirmationModal');
                    if (modalEl) {
                        const modal = bootstrap.Modal.getInstance(modalEl);
                        if (modal) modal.hide();
                    }
                    await getList();
                } else {
                    errorToast(res.data.message);
                }
            } catch (e) {
                if (typeof hideLoader === 'function') hideLoader();
                console.error(e);
                errorToast(e.response?.data?.message || 'Failed to delete customer');
            }
        }
    </script>
@endsection
