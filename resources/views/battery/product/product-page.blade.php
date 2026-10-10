@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Products - MARSS CORPORATION')
@section('content')

<style>
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

    /* Unified UI Border Color for Light Mode across all fields, buttons, and table */
    .unified-ui-border {
        border: 1.5px solid #cbd5e1 !important;
    }

    /* Search input wrapper focus ring */
    .search-input-wrapper:focus-within {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.25) !important;
    }

    /* Table & Status Badges */
    .badge.available {
        background-color: #dcfce7 !important;
        color: #15803d !important;
        border: 1px solid #bbf7d0 !important;
        font-weight: 700;
        border-radius: 6px;
        padding: 4px 8px;
        font-size: 11px;
    }
    .badge.low-stock {
        background-color: #fef3c7 !important;
        color: #b45309 !important;
        border: 1px solid #fde68a !important;
        font-weight: 700;
        border-radius: 6px;
        padding: 4px 8px;
        font-size: 11px;
    }
    .badge.out-of-stock {
        background-color: #fee2e2 !important;
        color: #b91c1c !important;
        border: 1px solid #fecaca !important;
        font-weight: 700;
        border-radius: 6px;
        padding: 4px 8px;
        font-size: 11px;
    }

    /* Custom Searchable Select Dropdown Design (Matching Modal & Retail Filter) */
    .custom-filter-dropdown {
        position: relative;
        user-select: none;
    }
    .custom-filter-dropdown.is-open {
        z-index: 50 !important;
    }
    .custom-filter-dropdown .select-trigger {
        transition: all 0.2s ease;
    }
    .custom-filter-dropdown .select-trigger:hover {
        border-color: #16a34a !important;
    }
    .custom-filter-dropdown.is-open .select-trigger {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15) !important;
    }
    .custom-filter-dropdown .select-menu {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        min-width: 100%;
        width: max-content;
        max-width: 320px;
        z-index: 9999 !important;
        background: #ffffff !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 12px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.12), 0 4px 12px rgba(0, 0, 0, 0.06) !important;
        padding: 6px;
    }
    #filterCategoryDropdown .select-menu {
        right: 0 !important;
        left: auto !important;
    }
    .custom-filter-dropdown.is-open .select-menu {
        display: block !important;
    }
    .custom-filter-dropdown .search-wrap {
        padding: 4px 6px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 4px;
        background: #ffffff !important;
    }
    .custom-filter-dropdown .search-input-pill {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: flex-start !important;
        flex-wrap: nowrap !important;
        width: 100% !important;
        height: 34px !important;
        min-height: 34px !important;
        max-height: 34px !important;
        padding: 0 10px !important;
        background-color: #ffffff !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 8px !important;
        box-sizing: border-box !important;
        transition: all 0.15s ease !important;
        overflow: hidden !important;
    }
    .custom-filter-dropdown .search-input-pill:focus-within {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2) !important;
    }
    .custom-filter-dropdown .search-input-pill svg,
    .custom-filter-dropdown .search-input-pill .search-icon {
        width: 14px !important;
        height: 14px !important;
        min-width: 14px !important;
        max-width: 14px !important;
        color: #94a3b8 !important;
        flex: 0 0 14px !important;
        flex-shrink: 0 !important;
        margin: 0 8px 0 0 !important;
        pointer-events: none !important;
    }
    .custom-filter-dropdown .search-input-pill input {
        flex: 1 1 0% !important;
        width: 100% !important;
        min-width: 0 !important;
        height: 100% !important;
        border: none !important;
        outline: none !important;
        background: transparent !important;
        padding: 0 !important;
        margin: 0 !important;
        font-size: 12px !important;
        line-height: 34px !important;
        color: #1e293b !important;
        box-shadow: none !important;
    }
    .custom-filter-dropdown .select-options-list {
        max-height: 200px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }
    .custom-filter-dropdown .select-options-list::-webkit-scrollbar {
        width: 4px;
    }
    .custom-filter-dropdown .select-options-list::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .custom-filter-dropdown .select-option-item {
        background-color: #ffffff !important;
        color: #334155;
        padding: 8px 12px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer !important;
        border-radius: 6px;
        border-left: 4px solid transparent !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.15s ease-in-out;
        margin-bottom: 2px;
    }
    .custom-filter-dropdown .select-option-item:hover {
        background-color: #f0fdf4 !important;
        color: #15803d !important;
        border-left: 4px solid #16a34a !important;
    }
    .custom-filter-dropdown .select-option-item.active {
        background-color: #dcfce7 !important;
        color: #15803d !important;
        border-left: 4px solid #16a34a !important;
        font-weight: 600;
    }

    /* Modal Styling for Create & Update & Quick View */
    .financemodal {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        margin: 0 !important;
        padding: 20px 10px !important;
        box-sizing: border-box !important;
        background: rgba(15, 23, 42, 0.65) !important;
        backdrop-filter: blur(8px) !important;
        -webkit-backdrop-filter: blur(8px) !important;
        z-index: 99999 !important;
        display: none;
        overflow-y: auto !important;
    }
    .financemodal.show,
    .financemodal.show-modal {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }
    .financemodal .modal-content {
        position: relative !important;
        margin: auto !important;
        max-height: 90vh !important;
        overflow-y: auto !important;
        border-radius: 16px !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35) !important;
    }

    /* Custom Searchable Select Inside Modal */
    .custom-searchable-select {
        position: relative;
        flex: 1;
        min-width: 0;
        z-index: 1;
    }
    .custom-searchable-select.is-open {
        z-index: 9999 !important;
    }
    .custom-searchable-select .select-trigger {
        height: 42px;
        border-radius: 8px;
        cursor: pointer !important;
        border: 1px solid #cbd5e1 !important;
        background: #ffffff;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 14px;
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
    }
    .custom-searchable-select .select-trigger:hover {
        border-color: #16a34a !important;
    }
    .custom-searchable-select.is-open .select-trigger {
        border-color: #16a34a !important;
        box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.15) !important;
    }
    .custom-searchable-select .select-menu {
        display: none;
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        width: 100%;
        min-width: 100%;
        z-index: 99999 !important;
        background: #ffffff !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 10px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.15) !important;
        padding: 6px;
    }
    .custom-searchable-select.is-open .select-menu {
        display: block !important;
    }
    .custom-searchable-select .search-wrap {
        position: relative;
        padding: 4px;
        margin-bottom: 4px;
        border-bottom: 1px solid #f1f5f9;
    }
    .custom-searchable-select .search-wrap input {
        width: 100%;
        height: 32px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        padding: 4px 8px 4px 30px;
        font-size: 13px;
        outline: none;
    }
    .custom-searchable-select .select-options-list {
        max-height: 180px;
        overflow-y: auto;
    }
    .custom-searchable-select .select-option-item {
        padding: 8px 12px;
        font-size: 13px;
        cursor: pointer;
        border-radius: 6px;
        color: #334155;
        transition: all 0.15s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .custom-searchable-select .select-option-item:hover {
        background-color: #f0fdf4;
        color: #15803d;
    }
    .custom-searchable-select .select-option-item.active {
        background-color: #dcfce7;
        color: #15803d;
        font-weight: 700;
    }

    /* Quick Add Modal Styling */
    .newbrand,
    .newcategory,
    #addBrandModal,
    #addCategoryModal,
    #addSubCategoryModal {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        margin: 0 !important;
        background: rgba(15, 23, 42, 0.75) !important;
        display: none;
        justify-content: center !important;
        align-items: center !important;
        z-index: 99999999 !important;
        backdrop-filter: blur(6px) !important;
    }
    .newbrand.show,
    .newcategory.show,
    #addBrandModal.show,
    #addCategoryModal.show,
    #addSubCategoryModal.show {
        display: flex !important;
    }
    .newbrand-content,
    .newcategory-content {
        background: #ffffff !important;
        padding: 24px 28px !important;
        border-radius: 16px !important;
        width: 440px !important;
        max-width: 90vw !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35) !important;
    }
    .newmodal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }
    .newmodal-close-btn {
        background: #ef4444 !important;
        color: #ffffff !important;
        border: none;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .btn-add {
        background: linear-gradient(135deg, #15803d 0%, #16a34a 100%);
        border: none;
        color: #ffffff;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.15s;
    }
    .btn-add:hover {
        transform: scale(1.04);
    }

    /* Barcode Badges & Inputs */
    .barcode-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 8px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        border-radius: 6px;
        font-family: monospace;
        font-size: 12px;
        font-weight: 600;
    }
    .barcode-badge-pill .remove-code-btn {
        cursor: pointer;
        color: #ef4444;
        font-weight: bold;
    }

    /* Quick View Modal Close Button */
    .qv-close-btn {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #ef4444;
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        padding: 0;
    }
    .qv-close-btn:hover {
        background: #dc2626;
    }

    /* Centered Delete Modal */
    #confirmationModal.modal {
        background: rgba(15, 23, 42, 0.65) !important;
        backdrop-filter: blur(5px) !important;
    }
    #confirmationModal .modal-dialog {
        max-width: 420px !important;
        width: 92% !important;
        margin: auto !important;
    }
    #confirmationModal .modal-content {
        background: #ffffff !important;
        border-radius: 20px !important;
        padding: 30px 24px 26px 24px !important;
        text-align: center !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
    }
    #confirmationModal .delete-icon-circle {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: #fef2f2;
        border: 2px solid #fee2e2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px auto;
        box-shadow: 0 8px 16px rgba(220, 38, 38, 0.12);
    }

    /* Dark Mode Theme */
    body[light-mode="dark"] .unified-ui-border,
    body[data-layout-mode="dark"] .unified-ui-border,
    html.dark .unified-ui-border {
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .custom-filter-dropdown .select-trigger {
        background-color: #1e293b !important;
        color: #f1f5f9 !important;
    }
    body[light-mode="dark"] .custom-filter-dropdown .select-menu {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .custom-filter-dropdown .search-wrap input {
        background-color: #0f172a !important;
        color: #ffffff !important;
        border-color: #334155 !important;
    }
    body[light-mode="dark"] .custom-filter-dropdown .select-option-item {
        background-color: #1e293b !important;
        color: #cbd5e1 !important;
    }
    body[light-mode="dark"] .custom-filter-dropdown .select-option-item:hover {
        background-color: #334155 !important;
        color: #4ade80 !important;
    }
    body[light-mode="dark"] .custom-filter-dropdown .select-option-item.active {
        background-color: rgba(34, 197, 94, 0.15) !important;
        color: #4ade80 !important;
    }
    body[light-mode="dark"] .financemodal .modal-content,
    body[light-mode="dark"] .newbrand-content,
    body[light-mode="dark"] .newcategory-content,
    body[light-mode="dark"] #confirmationModal .modal-content,
    body[light-mode="dark"] #productQuickViewModal .modal-content {
        background: #0f172a !important;
        color: #f1f5f9 !important;
        border: 1px solid #334155 !important;
    }
</style>

<!-- Main Content Start -->
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
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Battery Product List</h1>
                        </div>

                        <!-- Right Controls: Barcode Print + Add Product Button -->
                        <div class="flex items-center flex-wrap gap-2">
                            <a href="{{ route('battery.barcode.generate') }}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] min-h-[38px] max-h-[38px] bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-200 text-xs font-semibold rounded-xl border border-slate-300 dark:border-slate-700 transition-all">
                                <i class="fa-solid fa-barcode text-sm"></i>
                                <span>Barcode Print</span>
                            </a>
                            <button id="openModalBtns" onclick="openProductCreateModal()" type="button" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-emerald-700 hover:bg-emerald-600 active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Add Product</span>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Controls & Filter Row: Search + Show Entries + Searchable Custom Dropdowns -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2.5 sm:gap-3 mb-4">
                        <!-- Group 1: Search Bar + Show Entry -->
                        <div class="flex items-center gap-2 sm:gap-2.5 w-full md:w-auto">
                            <!-- Search Bar -->
                            <div class="search-input-wrapper unified-ui-border flex-1 md:w-[260px] lg:w-[300px] h-[38px] flex items-center px-3 bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                                <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search Product, Barcode..." />
                            </div>

                            <!-- Entries Selector -->
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

                        <!-- Group 2: All Brands + All Categories Custom Dropdowns (Visual Reference 1) -->
                        <div class="flex items-center gap-2 sm:gap-2.5 w-full md:w-auto">
                            <!-- Brand Filter Dropdown -->
                            <select id="filterBrand" class="hidden">
                                <option value="">All Brands</option>
                            </select>
                            <div class="custom-filter-dropdown flex-1 min-w-0 md:w-[200px] lg:w-[230px]" id="filterBrandDropdown">
                                <div class="select-trigger unified-ui-border flex items-center justify-between px-3 sm:px-3.5 h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-sm text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-200 cursor-pointer hover:border-emerald-500 transition-all duration-150" onclick="toggleCustomListFilter('filterBrandDropdown')">
                                    <span class="selected-text text-truncate flex-1">All Brands</span>
                                    <svg class="w-3.5 h-3.5 text-slate-400 chevron-icon transition-transform duration-200 flex-shrink-0 ms-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </div>
                                <div class="select-menu">
                                    <div class="search-wrap">
                                        <div class="search-input-pill unified-ui-border flex items-center h-[34px] px-2.5 bg-white dark:bg-slate-900 rounded-lg">
                                            <svg class="search-icon text-slate-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                            <input type="text" placeholder="Search Brand..." oninput="filterCustomListOptions('filterBrandDropdown', this.value)" class="w-full h-full bg-transparent border-0 outline-none text-xs text-slate-800 dark:text-slate-100 placeholder:text-slate-400" />
                                        </div>
                                    </div>
                                    <div class="select-options-list">
                                        <div class="select-option-item active" data-value="" data-label="All Brands" onclick="selectCustomFilterOption('filterBrandDropdown', 'filterBrand', '', 'All Brands')">
                                            <span>All Brands</span>
                                            <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Category Filter Dropdown -->
                            <select id="filterCategory" class="hidden">
                                <option value="">All Categories</option>
                            </select>
                            <div class="custom-filter-dropdown flex-1 min-w-0 md:w-[200px] lg:w-[230px]" id="filterCategoryDropdown">
                                <div class="select-trigger unified-ui-border flex items-center justify-between px-3 sm:px-3.5 h-[38px] bg-white dark:bg-slate-800/90 rounded-xl shadow-sm text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-200 cursor-pointer hover:border-emerald-500 transition-all duration-150" onclick="toggleCustomListFilter('filterCategoryDropdown')">
                                    <span class="selected-text text-truncate flex-1">All Categories</span>
                                    <svg class="w-3.5 h-3.5 text-slate-400 chevron-icon transition-transform duration-200 flex-shrink-0 ms-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </div>
                                <div class="select-menu" style="right: 0 !important; left: auto !important;">
                                    <div class="search-wrap">
                                        <div class="search-input-pill unified-ui-border flex items-center h-[34px] px-2.5 bg-white dark:bg-slate-900 rounded-lg">
                                            <svg class="search-icon text-slate-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                            <input type="text" placeholder="Search Category..." oninput="filterCustomListOptions('filterCategoryDropdown', this.value)" class="w-full h-full bg-transparent border-0 outline-none text-xs text-slate-800 dark:text-slate-100 placeholder:text-slate-400" />
                                        </div>
                                    </div>
                                    <div class="select-options-list">
                                        <div class="select-option-item active" data-value="" data-label="All Categories" onclick="selectCustomFilterOption('filterCategoryDropdown', 'filterCategory', '', 'All Categories')">
                                            <span>All Categories</span>
                                            <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Desktop Table (Exact 100% Match to Retail Visual Reference 1) -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[40px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                    <th class="p-[10px] text-start w-[120px] whitespace-nowrap">Barcode</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Name</th>
                                    <th class="p-[10px] text-start w-[140px] whitespace-nowrap">Category</th>
                                    <th class="p-[10px] text-center w-[85px] whitespace-nowrap">Quantity</th>
                                    <th class="p-[10px] text-end w-[100px] whitespace-nowrap">Cost Price</th>
                                    <th class="p-[10px] text-end w-[120px] whitespace-nowrap">Total Cost Price</th>
                                    <th class="p-[10px] text-end w-[100px] whitespace-nowrap">Selling Price</th>
                                    <th class="p-[10px] text-center w-[85px] whitespace-nowrap">Stock</th>
                                    <th class="p-[10px] text-center w-[85px] rounded-tr-2xl whitespace-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableList" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                                <tr>
                                    <td colspan="10" class="text-center py-8 text-slate-400 font-medium">Loading battery products...</td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-slate-50/90 dark:bg-slate-800/70 text-slate-800 dark:text-slate-100 font-bold border-t-2 border-emerald-600/30 text-xs sm:text-sm">
                                <tr>
                                    <td colspan="4" class="p-[10px] text-end font-bold text-slate-600 dark:text-slate-300">Total:</td>
                                    <td id="totalQuantity" class="p-[10px] text-center font-bold text-slate-900 dark:text-white">0</td>
                                    <td id="totalCostPrice" class="p-[10px] text-end font-bold text-slate-900 dark:text-white">0.00</td>
                                    <td id="totalCostQuantityPrice" class="p-[10px] text-end font-bold text-emerald-700 dark:text-emerald-400">0.00</td>
                                    <td id="totalSellingPrice" class="p-[10px] text-end font-bold text-slate-900 dark:text-white">0.00</td>
                                    <td class="p-[10px]"></td>
                                    <td class="p-[10px]"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- 4. Mobile Card List View -->
                    <div id="mobileCardList" class="block md:hidden mb-3 space-y-3"></div>

                    <!-- 5. Modern Smart Pagination and Display Info Footer -->
                    <div class="flex flex-col sm:flex-row items-center justify-between pt-4 mt-4 border-t border-slate-200 dark:border-slate-800 gap-3">
                        <div id="display-info" class="text-xs text-slate-500 dark:text-slate-400"></div>
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

<!-- ==========================================
     QUICK VIEW PRODUCT DETAILS MODAL
     ========================================== -->
<div id="productQuickViewModal" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg my-3" style="max-height: 88vh;">
        <div class="modal-content bg-white dark:bg-slate-900 border-0 rounded-2xl shadow-2xl overflow-hidden flex flex-col" style="max-height: 88vh;">
            <!-- Modal Header -->
            <div class="modal-header sticky top-0 z-20 px-4 py-3 bg-emerald-700 text-white flex items-center justify-between shadow-sm border-0 flex-shrink-0" style="background-color: #15803d !important;">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/20 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </div>
                    <div>
                        <h5 class="modal-title text-base sm:text-lg font-bold text-white tracking-tight mb-0.5" id="qvProductName">Product Details</h5>
                        <div class="flex items-center gap-1.5 flex-wrap text-xs" id="qvHeaderBadges"></div>
                    </div>
                </div>
                <button type="button" class="qv-close-btn" data-bs-dismiss="modal" aria-label="Close" title="Close">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4 space-y-3.5 overflow-y-auto flex-1" style="max-height: calc(88vh - 120px);">
                <!-- KPI Cards Grid (4 columns) -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                    <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-center">
                        <span class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Stock Status</span>
                        <div id="qvStockBadgeWrap" class="inline-block"></div>
                    </div>
                    <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-center">
                        <span class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Total Quantity</span>
                        <span id="qvQuantity" class="text-sm sm:text-base font-bold text-slate-800 dark:text-slate-100">0</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-center">
                        <span class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Cost Price</span>
                        <span id="qvCostPrice" class="text-sm sm:text-base font-bold text-slate-700 dark:text-slate-200">৳ 0</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-emerald-50 dark:bg-slate-800 border border-emerald-200 dark:border-slate-700 text-center">
                        <span class="block text-[10px] font-semibold text-emerald-600 uppercase tracking-wider mb-1">Selling Price</span>
                        <span id="qvSellPrice" class="text-sm sm:text-base font-bold text-emerald-700 dark:text-emerald-300">৳ 0</span>
                    </div>
                </div>

                <!-- Product Specification Box -->
                <div class="rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden mt-3">
                    <div class="bg-slate-100 dark:bg-slate-800 px-5 sm:px-6 py-3 border-b border-slate-200 dark:border-slate-700 font-bold text-xs text-slate-700 dark:text-slate-200 uppercase tracking-wider flex items-center justify-between flex-wrap gap-2">
                        <span>Product Specification</span>
                        <span id="qvTotalCostValue" class="text-emerald-700 dark:text-emerald-400 font-bold">Total Value: ৳ 0</span>
                    </div>
                    <div class="divide-y divide-slate-200 dark:divide-slate-700 text-xs">
                        <div class="grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-white dark:bg-slate-800/90">
                            <span class="font-semibold text-slate-500">Barcode(s):</span>
                            <div id="qvBarcodes" class="col-span-2 flex flex-wrap gap-1 font-mono"></div>
                        </div>
                        <div class="grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-slate-50 dark:bg-slate-800/50">
                            <span class="font-semibold text-slate-500">Category:</span>
                            <span id="qvCategory" class="col-span-2 font-medium text-slate-800 dark:text-slate-200"></span>
                        </div>
                        <div class="grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-white dark:bg-slate-800/90">
                            <span class="font-semibold text-slate-500">Brand:</span>
                            <span id="qvBrand" class="col-span-2 font-medium text-slate-800 dark:text-slate-200"></span>
                        </div>
                        <div class="grid grid-cols-3 px-5 sm:px-6 py-2.5 bg-slate-50 dark:bg-slate-800/50">
                            <span class="font-semibold text-slate-500">Unit:</span>
                            <span id="qvUnit" class="col-span-2 font-medium text-slate-800 dark:text-slate-200"></span>
                        </div>
                    </div>
                </div>

                <!-- Price Batches & Records Section -->
                <div id="qvVariantsSection" style="display: none;" class="space-y-2 mt-3.5">
                    <h6 class="font-bold text-xs uppercase tracking-wider text-slate-600 flex items-center gap-1.5 mb-0 px-1">
                        <svg class="w-4 h-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 20V6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14"></path><path d="M2 20h20"></path></svg>
                        <span>Stock Records &amp; Price Batches</span>
                    </h6>
                    <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-100 dark:bg-slate-800 text-slate-600 font-bold border-b border-slate-200 dark:border-slate-700">
                                <tr>
                                    <th class="px-4 py-2.5">Record / Batch</th>
                                    <th class="px-4 py-2.5">Barcode</th>
                                    <th class="px-4 py-2.5 text-center">Stock</th>
                                    <th class="px-4 py-2.5 text-end">Cost Price</th>
                                    <th class="px-4 py-2.5 text-end">Selling Price</th>
                                    <th class="px-4 py-2.5 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody id="qvVariantsTableBody" class="divide-y divide-slate-200 dark:divide-slate-700"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer sticky bottom-0 z-20 px-4 py-2.5 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 flex justify-end flex-shrink-0">
                <button type="button" class="px-4 h-[38px] rounded-xl text-white text-xs sm:text-sm font-semibold transition-all shadow-sm border-0" data-bs-dismiss="modal" style="background-color: #dc2626 !important;">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================
     ADD NEW PRODUCT MODAL (Image 3 Parity)
     ========================================== -->
<section id="createProduct" class="financemodal">
    <div class="modal-content border-0 shadow-lg d-flex flex-column" style="border-radius: 16px; overflow: hidden; background: #ffffff; padding: 0 !important; max-width: 750px; width: 95%; max-height: 90vh;">
        <!-- Header: Green Gradient with Cart Icon & Red Close Button -->
        <div class="modal-header text-white py-2.5 px-4 d-flex align-items-center justify-content-between flex-shrink-0" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); position: sticky; top: 0; z-index: 20;">
            <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2 m-0 fs-5">
                <i class="fa-solid fa-cart-plus me-1"></i> Add New Product
            </h5>
            <button type="button" class="qv-close-btn" onclick="closeProductModal()" title="Close">
                <i class="fa-solid fa-xmark text-white" style="font-size: 11px;"></i>
            </button>
        </div>

        <!-- Scrollable Form Body -->
        <div id="popup-modal" style="padding: 18px 24px; overflow-y: auto; flex: 1 1 auto; max-height: calc(90vh - 120px);">
            <form onsubmit="return ProductDataSave(event)" id="createProductForm">
                <!-- Row 1: Brand (+), Category* (+), Sub-Category (+) -->
                <div class="row g-2.5">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="form-row flex-column align-items-start">
                            <label for="ProductBrand" class="fw-semibold small" style="color: #334155; margin-bottom: 2px !important; font-size: 13px;">Brand</label>
                            <div class="d-flex align-items-center w-100 gap-2">
                                <select class="d-none" id="ProductBrand">
                                    <option value="none">Select Brand</option>
                                </select>
                                <div class="custom-searchable-select flex-grow-1" id="createBrandDropdown">
                                    <div class="select-trigger d-flex align-items-center justify-content-between px-3" onclick="toggleCustomProductDropdown('createBrandDropdown')">
                                        <span class="selected-text text-truncate" style="font-size: 13px; font-weight: 500; color: #64748b;">Select Brand</span>
                                        <i class="fa-solid fa-chevron-down ms-1 text-muted" style="font-size: 11px;"></i>
                                    </div>
                                    <div class="select-menu">
                                        <div class="search-wrap">
                                            <input type="text" placeholder="Search Brand..." oninput="filterCustomProductDropdown('createBrandDropdown', this.value)">
                                        </div>
                                        <div class="select-options-list"></div>
                                    </div>
                                </div>
                                <button type="button" class="btn-add newbrand-open text-nowrap" onclick="openBrandModal()" style="width: 42px; height: 42px; min-width: 42px;" title="Add New Brand">
                                    <i class="fa-solid fa-plus text-white fs-6"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="form-row flex-column align-items-start">
                            <label for="ProductCategoryDataID" class="fw-semibold small" style="color: #334155; margin-bottom: 2px !important; font-size: 13px;">Category <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center w-100 gap-2">
                                <select class="d-none" id="ProductCategoryDataID">
                                    <option value="none" selected>Select Category</option>
                                </select>
                                <div class="custom-searchable-select flex-grow-1" id="createCategoryDropdown">
                                    <div class="select-trigger d-flex align-items-center justify-content-between px-3" onclick="toggleCustomProductDropdown('createCategoryDropdown')">
                                        <span class="selected-text text-truncate" style="font-size: 13px; font-weight: 500; color: #64748b;">Select Category <span class="text-danger">*</span></span>
                                        <i class="fa-solid fa-chevron-down ms-1 text-muted" style="font-size: 11px;"></i>
                                    </div>
                                    <div class="select-menu">
                                        <div class="search-wrap">
                                            <input type="text" placeholder="Search Category..." oninput="filterCustomProductDropdown('createCategoryDropdown', this.value)">
                                        </div>
                                        <div class="select-options-list"></div>
                                    </div>
                                </div>
                                <button type="button" class="btn-add newcategory-open text-nowrap" onclick="openCategoryModal()" style="width: 42px; height: 42px; min-width: 42px;" title="Add New Category">
                                    <i class="fa-solid fa-plus text-white fs-6"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 col-12">
                        <div class="form-row flex-column align-items-start">
                            <label for="ProductSubCategoryID" class="fw-semibold small" style="color: #334155; margin-bottom: 2px !important; font-size: 13px;">Sub-Category</label>
                            <div class="d-flex align-items-center w-100 gap-2">
                                <select class="d-none" id="ProductSubCategoryID">
                                    <option value="none" selected>Select Sub-Category</option>
                                </select>
                                <div class="custom-searchable-select flex-grow-1" id="createSubCategoryDropdown">
                                    <div class="select-trigger d-flex align-items-center justify-content-between px-3" onclick="toggleCustomProductDropdown('createSubCategoryDropdown')">
                                        <span class="selected-text text-truncate" style="font-size: 13px; font-weight: 500; color: #64748b;">Select Sub-Category</span>
                                        <i class="fa-solid fa-chevron-down ms-1 text-muted" style="font-size: 11px;"></i>
                                    </div>
                                    <div class="select-menu">
                                        <div class="search-wrap">
                                            <input type="text" placeholder="Search Sub-Category..." oninput="filterCustomProductDropdown('createSubCategoryDropdown', this.value)">
                                        </div>
                                        <div class="select-options-list"></div>
                                    </div>
                                </div>
                                <button type="button" class="btn-add newsubcategory-open text-nowrap" onclick="openSubCategoryModal()" style="width: 42px; height: 42px; min-width: 42px;" title="Add New Sub-Category">
                                    <i class="fa-solid fa-plus text-white fs-6"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Product Photo Upload Box -->
                <div class="row mt-2 g-2.5">
                    <div class="col-lg-12">
                        <label class="fw-semibold small" style="color: #334155; margin-bottom: 2px !important; font-size: 13px;">Product Photo</label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="img-box" id="ProductImageBox" style="width: 84px; height: 70px; border-radius: 8px; background: #f8fafc; border: 1.5px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                                <div id="ProductImageDefaultIcon" class="d-flex align-items-center justify-content-center w-100 h-100">
                                    <i class="fa-regular fa-image fs-3 text-secondary"></i>
                                </div>
                                <img id="ProductImagePreview" src="" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; display: none;" />
                            </div>
                            <div>
                                <label class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1.5 px-3 py-1.5" style="border-radius: 8px; cursor: pointer;">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <span>Upload Photo</span>
                                    <input type="file" id="ProductImage" accept="image/*" onchange="previewProductImage(event)" style="display: none;" />
                                </label>
                                <div class="mt-1 small text-muted" style="font-size: 11px;">PNG, JPEG, GIF or WEBP (up to 2 MB)</div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 3: Product Name* -->
                    <div class="col-lg-12 mt-2">
                        <label for="ProductName" class="fw-semibold small" style="color: #334155; margin-bottom: 2px !important; font-size: 13px;">Product Name <span class="text-danger">*</span></label>
                        <input type="text" placeholder="e.g. Lucas Super 150Ah Tubular Battery *" id="ProductName" class="form-control" style="width: 100%; height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;" oninput="checkDuplicateProductName()" />
                        <div id="productNameDuplicateAlert" class="mt-2 w-100 p-2.5 rounded-lg border border-amber-300 bg-amber-50 text-amber-900 text-xs font-medium" style="display: none; border-radius: 8px;">
                            <div class="d-flex items-start gap-2">
                                <i class="fa-solid fa-triangle-exclamation text-amber-600 text-sm mt-0.5 flex-shrink-0"></i>
                                <div id="productNameDuplicateText"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 4: Quantity, Cost Price, Selling Price (3 columns) -->
                    <div class="col-lg-4 mt-2">
                        <label for="ProductQuantity" class="fw-semibold small" style="color: #334155; margin-bottom: 2px !important; font-size: 13px;">Quantity</label>
                        <input type="number" step="1" placeholder="Quantity" id="ProductQuantity" class="form-control" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;" />
                    </div>
                    <div class="col-lg-4 mt-2">
                        <label for="ProductCostPrice" class="fw-semibold small" style="color: #334155; margin-bottom: 2px !important; font-size: 13px;">Cost Price (৳)</label>
                        <input type="number" step="0.01" placeholder="Cost Price" id="ProductCostPrice" class="form-control" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;" />
                    </div>
                    <div class="col-lg-4 mt-2">
                        <label for="ProductSellingPrice" class="fw-semibold small" style="color: #334155; margin-bottom: 2px !important; font-size: 13px;">Selling Price (৳)</label>
                        <input type="number" step="0.01" placeholder="Selling Price" id="ProductSellingPrice" class="form-control" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;" />
                    </div>

                    <!-- Row 5: Barcode / Product Code + Camera Scan button -->
                    <div class="col-lg-12 mt-2">
                        <label for="ProductCodeInput" class="fw-semibold small" style="color: #334155; margin-bottom: 2px !important; font-size: 13px;">Barcode / Product Code</label>
                        <div class="d-flex align-items-center gap-2 w-100">
                            <input type="text" id="ProductCodeInput" class="form-control" placeholder="Enter barcode and press Enter..." onkeydown="handleBarcodeKey(event)" style="flex: 1; height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;" />
                            <button type="button" class="btn text-white fw-bold text-nowrap d-flex align-items-center gap-2 px-3 shadow-sm" onclick="openProductCreateCameraScanner()" style="height: 42px; border-radius: 8px; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none;">
                                <i class="fa-solid fa-camera fs-6"></i>
                                <span class="d-none d-sm-inline">Camera Scan</span>
                            </button>
                        </div>
                        <div id="BarcodeContainer" class="d-flex flex-wrap gap-1.5 mt-2"></div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sticky Footer: Reset (Red) & Submit (Green) -->
        <div class="modal-footer px-4 py-2.5 d-flex align-items-center justify-content-end gap-2 flex-shrink-0" style="position: sticky; bottom: 0; z-index: 20; border-top: 1px solid #e2e8f0 !important; background: #ffffff;">
            <button type="button" onclick="resetProductForm()" class="btn fw-semibold px-4" style="height: 40px; border-radius: 8px; font-size: 14px; background-color: #dc2626 !important; color: #ffffff !important; border: none !important;">Reset</button>
            <button type="button" onclick="ProductDataSave(event)" class="btn text-white fw-bold px-5 shadow-sm" style="height: 40px; border-radius: 8px; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none; font-size: 14px;">Submit</button>
        </div>
    </div>
</section>

<!-- ==========================================
     EDIT PRODUCT MODAL
     ========================================== -->
<div class="modal fade" id="productUpdateModal" tabindex="-1" aria-labelledby="productUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden; background: #ffffff;">
            <div class="modal-header text-white py-2.5 px-4 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%);">
                <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2 m-0 fs-5">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit Battery Product
                </h5>
                <button type="button" class="qv-close-btn" data-bs-dismiss="modal" title="Close">
                    <i class="fa-solid fa-xmark text-white" style="font-size: 11px;"></i>
                </button>
            </div>
            <div class="modal-body p-4" style="max-height: calc(88vh - 120px); overflow-y: auto;">
                <form id="updateProductForm" onsubmit="updateBatteryProduct(event)">
                    <input type="hidden" id="updateProductId">
                    <div class="row g-2.5">
                        <div class="col-md-4">
                            <label class="fw-semibold small" style="color: #334155; font-size: 13px;">Brand</label>
                            <select id="updateProductBrand" class="form-select unified-ui-border" style="height: 42px; border-radius: 8px; font-size: 13.5px;"></select>
                        </div>
                        <div class="col-md-4">
                            <label class="fw-semibold small" style="color: #334155; font-size: 13px;">Category <span class="text-danger">*</span></label>
                            <select id="updateProductCategory" onchange="onCategoryChanged('update')" class="form-select unified-ui-border" style="height: 42px; border-radius: 8px; font-size: 13.5px;"></select>
                        </div>
                        <div class="col-md-4">
                            <label class="fw-semibold small" style="color: #334155; font-size: 13px;">Sub-Category</label>
                            <select id="updateProductSubCategory" class="form-select unified-ui-border" style="height: 42px; border-radius: 8px; font-size: 13.5px;"></select>
                        </div>

                        <div class="col-12 mt-2">
                            <label class="fw-semibold small" style="color: #334155; font-size: 13px;">Product Photo</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="img-box" style="width: 84px; height: 70px; border-radius: 8px; background: #f8fafc; border: 1.5px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                                    <img id="updateProductImagePreview" src="" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='{{ asset('backend/assets/img/product-img.svg') }}'">
                                </div>
                                <div>
                                    <label class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1.5 px-3 py-1.5" style="border-radius: 8px; cursor: pointer;">
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                        <span>Replace Photo</span>
                                        <input type="file" id="updateProductImage" accept="image/*" onchange="previewUpdateImage(event)" style="display: none;" />
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <label class="fw-semibold small" style="color: #334155; font-size: 13px;">Product Name <span class="text-danger">*</span></label>
                            <input type="text" id="updateProductName" required class="form-control" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;">
                        </div>

                        <div class="col-md-4 mt-2">
                            <label class="fw-semibold small" style="color: #334155; font-size: 13px;">Quantity</label>
                            <input type="number" step="1" id="updateProductQty" class="form-control" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;">
                        </div>
                        <div class="col-md-4 mt-2">
                            <label class="fw-semibold small" style="color: #334155; font-size: 13px;">Cost Price (৳)</label>
                            <input type="number" step="0.01" id="updateProductCost" class="form-control" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;">
                        </div>
                        <div class="col-md-4 mt-2">
                            <label class="fw-semibold small" style="color: #334155; font-size: 13px;">Selling Price (৳)</label>
                            <input type="number" step="0.01" id="updateProductSell" class="form-control" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;">
                        </div>

                        <div class="col-12 mt-2">
                            <label class="fw-semibold small" style="color: #334155; font-size: 13px;">Barcode(s)</label>
                            <input type="text" id="updateProductCodeInput" placeholder="Enter barcode and press Enter..." onkeydown="handleUpdateBarcodeKey(event)" class="form-control" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;">
                            <div id="updateBarcodeContainer" class="d-flex flex-wrap gap-1.5 mt-2"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer px-4 py-2.5 d-flex align-items-center justify-content-end gap-2" style="border-top: 1px solid #e2e8f0; background: #ffffff;">
                <button type="button" class="btn fw-semibold px-4 text-white" data-bs-dismiss="modal" style="height: 40px; border-radius: 8px; font-size: 14px; background-color: #dc2626 !important; border: none;">Cancel</button>
                <button type="button" onclick="updateBatteryProduct(event)" class="btn text-white fw-bold px-5 shadow-sm" style="height: 40px; border-radius: 8px; background: linear-gradient(135deg, #15803d 0%, #16a34a 100%); border: none; font-size: 14px;">Update</button>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================
     QUICK ADD BRAND MODAL
     ========================================== -->
<div class="newbrand" id="addBrandModal">
    <div class="newbrand-content">
        <div class="newmodal-header">
            <h5 class="fw-bold m-0 text-slate-800">Add New Brand</h5>
            <button type="button" class="newmodal-close-btn" onclick="closeBrandModal()" title="Close">
                <i class="fa-solid fa-xmark text-white" style="font-size: 11px;"></i>
            </button>
        </div>
        <form id="addBrandForm" onsubmit="BrandSave(event)">
            <div class="mb-3">
                <label class="fw-semibold small text-slate-700 mb-1 d-block">Brand Name <span class="text-danger">*</span></label>
                <input type="text" id="CreateBrandName" required placeholder="e.g. Lucas, Rahimafrooz..." class="form-control" style="height: 40px; border-radius: 8px;">
            </div>
            <div class="mb-3">
                <label class="fw-semibold small text-slate-700 mb-1 d-block">Brand Photo (Optional)</label>
                <input type="file" id="CreateBrandImg" accept="image/*" class="form-control" style="height: 40px; border-radius: 8px;">
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <button type="button" onclick="closeBrandModal()" class="btn btn-secondary px-3 py-1.5" style="border-radius: 8px;">Cancel</button>
                <button type="submit" class="btn btn-success px-4 py-1.5 text-white fw-bold" style="background-color: #15803d; border-radius: 8px;">Save Brand</button>
            </div>
        </form>
    </div>
</div>

<!-- ==========================================
     QUICK ADD CATEGORY MODAL
     ========================================== -->
<div class="newcategory" id="addCategoryModal">
    <div class="newcategory-content">
        <div class="newmodal-header">
            <h5 class="fw-bold m-0 text-slate-800">Add New Category</h5>
            <button type="button" class="newmodal-close-btn" onclick="closeCategoryModal()" title="Close">
                <i class="fa-solid fa-xmark text-white" style="font-size: 11px;"></i>
            </button>
        </div>
        <form id="addCategoryForm" onsubmit="CategorySave(event)">
            <div class="mb-3">
                <label class="fw-semibold small text-slate-700 mb-1 d-block">Category Name <span class="text-danger">*</span></label>
                <input type="text" id="CreateCategoryName" required placeholder="e.g. Tubular Battery, IPS Battery..." class="form-control" style="height: 40px; border-radius: 8px;">
            </div>
            <div class="mb-3">
                <label class="fw-semibold small text-slate-700 mb-1 d-block">Category Photo (Optional)</label>
                <input type="file" id="CreateCategoryImg" accept="image/*" class="form-control" style="height: 40px; border-radius: 8px;">
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <button type="button" onclick="closeCategoryModal()" class="btn btn-secondary px-3 py-1.5" style="border-radius: 8px;">Cancel</button>
                <button type="submit" class="btn btn-success px-4 py-1.5 text-white fw-bold" style="background-color: #15803d; border-radius: 8px;">Save Category</button>
            </div>
        </form>
    </div>
</div>

<!-- ==========================================
     QUICK ADD SUB-CATEGORY MODAL
     ========================================== -->
<div class="newcategory" id="addSubCategoryModal">
    <div class="newcategory-content">
        <div class="newmodal-header">
            <h5 class="fw-bold m-0 text-slate-800">Add New Sub-Category</h5>
            <button type="button" class="newmodal-close-btn" onclick="closeSubCategoryModal()" title="Close">
                <i class="fa-solid fa-xmark text-white" style="font-size: 11px;"></i>
            </button>
        </div>
        <form id="addSubCategoryForm" onsubmit="SubCategorySave(event)">
            <div class="mb-3">
                <label class="fw-semibold small text-slate-700 mb-1 d-block">Parent Category <span class="text-danger">*</span></label>
                <select id="CreateSubCategoryParent" required class="form-select" style="height: 40px; border-radius: 8px;"></select>
            </div>
            <div class="mb-3">
                <label class="fw-semibold small text-slate-700 mb-1 d-block">Sub-Category Name <span class="text-danger">*</span></label>
                <input type="text" id="CreateSubCategoryName" required placeholder="e.g. 150Ah, 200Ah, Solar Type..." class="form-control" style="height: 40px; border-radius: 8px;">
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <button type="button" onclick="closeSubCategoryModal()" class="btn btn-secondary px-3 py-1.5" style="border-radius: 8px;">Cancel</button>
                <button type="submit" class="btn btn-success px-4 py-1.5 text-white fw-bold" style="background-color: #15803d; border-radius: 8px;">Save Sub-Category</button>
            </div>
        </form>
    </div>
</div>

<!-- ==========================================
     CAMERA SCAN MODAL
     ========================================== -->
<div class="modal fade" id="productCreateCameraScanModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" style="z-index: 999999 !important;">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 18px; overflow: hidden;">
            <div class="modal-header text-white py-3" style="background: linear-gradient(135deg, #15803d 0%, #16a34a 100%);">
                <h5 class="modal-title fw-bold" id="productCreateCameraScanModalLabel">
                    <i class="fa-solid fa-camera me-2"></i> Barcode Camera Scanner
                </h5>
                <button type="button" class="btn-close btn-close-white" onclick="stopProductCreateCameraScanner()"></button>
            </div>
            <div class="modal-body p-3 text-center">
                <div id="productCreateCameraScannerStatus" class="alert alert-info py-2 small mb-3" style="border-radius: 10px;">
                    <i class="fa-solid fa-circle-notch fa-spin me-1"></i> Starting camera... Hold barcode in front of camera.
                </div>
                <div id="product-create-reader" style="width: 100%; min-height: 270px; background: #000; border-radius: 14px; overflow: hidden;" class="shadow-sm"></div>
                <div class="d-flex align-items-center justify-content-between mt-3 px-1">
                    <span id="productCreateLastScannedText" class="badge bg-success fs-6 py-2 px-3" style="border-radius: 10px;">Scanned Code: -</span>
                </div>
            </div>
            <div class="modal-footer bg-light py-2 justify-content-between">
                <small class="text-muted"><i class="fa-solid fa-bolt text-warning me-1"></i> Barcode will be entered automatically</small>
                <button type="button" class="btn btn-secondary px-4 fw-bold rounded-pill" onclick="stopProductCreateCameraScanner()">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================
     CENTERED DELETE CONFIRMATION MODAL
     ========================================== -->
<section class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form onsubmit="event.preventDefault(); return false;">
                <input type="hidden" id="deleteID" />
                <div class="delete-icon-circle">
                    <i class="fa-solid fa-trash-can" style="font-size: 26px;"></i>
                </div>
                <h4 class="fw-bold mb-2 text-slate-800">Delete Product?</h4>
                <p class="text-muted small mb-4">Are you sure you want to delete this battery product record? This action cannot be undone.</p>
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary px-4 py-2" style="border-radius: 8px;">Cancel</button>
                    <button type="button" onclick="itemDelete(event)" class="btn btn-danger px-4 py-2 fw-bold" style="border-radius: 8px;">
                        <i class="fa-solid fa-trash-can me-1"></i> Yes, Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- ==========================================
     SCRIPTS & DATA INTERACTION
     ========================================== -->
<script>
    let rawProductData = [];
    let brandsList = [];
    let categoriesList = [];
    let subCategoriesList = [];
    let unitsList = [];
    let currentPage = 1;
    let pageSize = 15;
    let barcodeList = [];
    let updateBarcodeList = [];
    let duplicateCheckTimeout = null;
    let isProductDuplicateDetected = false;

    // Helper: Currency formatting (Bangladeshi standard 2 decimals)
    function formatBdCurrency(val) {
        let n = parseFloat(val) || 0;
        return n.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    // Helper: Barcode badge array parser
    function formatProductCode(code) {
        if (!code) return '<span class="text-slate-400 text-xs">N/A</span>';
        let arr = [];
        try {
            let parsed = typeof code === 'string' ? JSON.parse(code) : code;
            if (Array.isArray(parsed)) arr = parsed;
            else if (parsed) arr = [parsed];
        } catch (e) {
            arr = [code];
        }
        arr = arr.filter(Boolean);
        if (arr.length === 0) return '<span class="text-slate-400 text-xs">N/A</span>';
        return arr.map(c => `<span class="barcode-badge-pill mr-1 mb-1">${c}</span>`).join('');
    }

    document.addEventListener("DOMContentLoaded", function() {
        loadFilterOptions();
        getBatteryProductList();

        $('#searchInput').on('input', function() { currentPage = 1; renderProducts(); });
        $('#filterBrand').on('change', function() { currentPage = 1; renderProducts(); });
        $('#filterCategory').on('change', function() { currentPage = 1; renderProducts(); });
        $('#entries').on('change', function() { pageSize = parseInt(this.value) || 15; currentPage = 1; renderProducts(); });

        // Accordion expand/collapse delegator
        $(document).on('click', '.toggle-variant-btn', function(e) {
            e.preventDefault();
            const targetId = $(this).attr('data-target');
            const targetRow = $('#' + targetId);
            const icon = $(this).find('.chevron-icon');
            if (targetRow.is(':visible')) {
                targetRow.hide();
                icon.css('transform', 'rotate(0deg)');
            } else {
                targetRow.show();
                icon.css('transform', 'rotate(180deg)');
            }
        });
    });

    // Custom List Filter Dropdown Handler
    function toggleCustomListFilter(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        if (!dropdown) return;
        const wasOpen = dropdown.classList.contains('is-open');
        closeAllCustomListFilters();
        if (!wasOpen) {
            dropdown.classList.add('is-open');
            const chevron = dropdown.querySelector('.chevron-icon');
            if (chevron) chevron.style.transform = 'rotate(180deg)';
            const input = dropdown.querySelector('.search-wrap input');
            if (input) {
                input.value = '';
                filterCustomListOptions(dropdownId, '');
                setTimeout(() => input.focus(), 50);
            }
        }
    }

    function closeAllCustomListFilters() {
        document.querySelectorAll('.custom-filter-dropdown').forEach(d => {
            d.classList.remove('is-open');
            const chevron = d.querySelector('.chevron-icon');
            if (chevron) chevron.style.transform = 'rotate(0deg)';
        });
    }

    $(document).on('click', function(e) {
        if (!e.target.closest('.custom-filter-dropdown')) {
            closeAllCustomListFilters();
        }
        if (!e.target.closest('.custom-searchable-select')) {
            closeAllCustomProductDropdowns();
        }
    });

    function filterCustomListOptions(dropdownId, searchVal) {
        const dropdown = document.getElementById(dropdownId);
        if (!dropdown) return;
        const listEl = dropdown.querySelector('.select-options-list');
        if (!listEl) return;
        const items = listEl.querySelectorAll('.select-option-item');
        const query = (searchVal || '').trim().toLowerCase();

        items.forEach(item => {
            const text = (item.getAttribute('data-label') || item.innerText || '').toLowerCase();
            if (!query || text.includes(query)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function selectCustomFilterOption(dropdownId, nativeSelectId, val, label) {
        const dropdown = document.getElementById(dropdownId);
        const nativeSelect = document.getElementById(nativeSelectId);

        if (nativeSelect) {
            $(nativeSelect).val(val).trigger('change');
        }

        if (dropdown) {
            const triggerText = dropdown.querySelector('.selected-text');
            if (triggerText) {
                triggerText.textContent = label;
            }

            dropdown.querySelectorAll('.select-option-item').forEach(item => {
                if (item.getAttribute('data-value') === String(val)) {
                    item.classList.add('active');
                    if (!item.querySelector('.check-icon')) {
                        item.innerHTML = `<span>${item.getAttribute('data-label')}</span><svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
                    }
                } else {
                    item.classList.remove('active');
                    const check = item.querySelector('.check-icon');
                    if (check) check.remove();
                }
            });
        }
        closeAllCustomListFilters();
    }

    // Modal Searchable Select Dropdown Handlers
    function toggleCustomProductDropdown(dropdownId) {
        const el = document.getElementById(dropdownId);
        if (!el) return;
        const wasOpen = el.classList.contains('is-open');
        closeAllCustomProductDropdowns();
        if (!wasOpen) {
            el.classList.add('is-open');
            const input = el.querySelector('.search-wrap input');
            if (input) {
                input.value = '';
                filterCustomProductDropdown(dropdownId, '');
                setTimeout(() => input.focus(), 60);
            }
        }
    }

    function closeAllCustomProductDropdowns() {
        document.querySelectorAll('.custom-searchable-select').forEach(el => el.classList.remove('is-open'));
    }

    function filterCustomProductDropdown(dropdownId, query) {
        const el = document.getElementById(dropdownId);
        if (!el) return;
        const items = el.querySelectorAll('.select-option-item');
        const q = (query || '').toLowerCase().trim();
        items.forEach(it => {
            const txt = (it.getAttribute('data-label') || it.innerText || '').toLowerCase();
            it.style.display = (!q || txt.includes(q)) ? 'flex' : 'none';
        });
    }

    function selectModalDropdownOption(dropdownId, hiddenSelectId, val, label) {
        const dropdown = document.getElementById(dropdownId);
        const hiddenSelect = document.getElementById(hiddenSelectId);
        if (hiddenSelect) {
            $(hiddenSelect).val(val).trigger('change');
        }
        if (dropdown) {
            const triggerText = dropdown.querySelector('.selected-text');
            if (triggerText) {
                triggerText.textContent = label;
                triggerText.style.color = '#1e293b';
            }
            dropdown.querySelectorAll('.select-option-item').forEach(it => {
                it.classList.toggle('active', it.getAttribute('data-value') === String(val));
            });
        }
        closeAllCustomProductDropdowns();

        if (hiddenSelectId === 'ProductCategoryDataID') {
            onCategorySelectedForSubCategory(val);
        }
    }

    function onCategorySelectedForSubCategory(catId) {
        const subList = subCategoriesList.filter(s => s.category_id == catId);
        let listHtml = '';
        subList.forEach(s => {
            listHtml += `<div class="select-option-item" data-value="${s.id}" data-label="${s.name}" onclick="selectModalDropdownOption('createSubCategoryDropdown', 'ProductSubCategoryID', '${s.id}', '${s.name}')">${s.name}</div>`;
        });
        const subMenu = document.querySelector('#createSubCategoryDropdown .select-options-list');
        if (subMenu) subMenu.innerHTML = listHtml || '<div class="p-2 text-muted small text-center">No Sub-Categories</div>';
        
        // Reset subcategory selection
        $('#ProductSubCategoryID').val('none');
        const subTrigger = document.querySelector('#createSubCategoryDropdown .selected-text');
        if (subTrigger) {
            subTrigger.textContent = 'Select Sub-Category';
            subTrigger.style.color = '#64748b';
        }
    }

    // Load filter dropdown data from backend
    async function loadFilterOptions() {
        try {
            const [bRes, cRes, scRes, uRes] = await Promise.all([
                axios.get('/api/battery/brand-list', HeaderToken()),
                axios.get('/api/battery/category-list', HeaderToken()),
                axios.get('/api/battery/sub-category-list', HeaderToken()),
                axios.get('/api/battery/unit-list', HeaderToken())
            ]);

            brandsList = bRes.data?.BrandData || [];
            categoriesList = cRes.data?.CategoryData || [];
            subCategoriesList = scRes.data?.SubCategoryData || [];
            unitsList = uRes.data?.units || [];

            // Populate Brand Filters & Modal Options
            let bNativeOpts = '<option value="">All Brands</option>';
            let bCustomList = '<div class="select-option-item active" data-value="" data-label="All Brands" onclick="selectCustomFilterOption(\'filterBrandDropdown\', \'filterBrand\', \'\', \'All Brands\')"><span>All Brands</span><svg class="w-3.5 h-3.5 text-emerald-600 check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg></div>';
            let bModalList = '';
            let bUpdateOpts = '<option value="">Select Brand</option>';

            brandsList.forEach(b => {
                bNativeOpts += `<option value="${b.id}">${b.name}</option>`;
                bCustomList += `<div class="select-option-item" data-value="${b.id}" data-label="${b.name}" onclick="selectCustomFilterOption(\'filterBrandDropdown\', \'filterBrand\', \'${b.id}\', \'${b.name}\')"><span>${b.name}</span></div>`;
                bModalList += `<div class="select-option-item" data-value="${b.id}" data-label="${b.name}" onclick="selectModalDropdownOption(\'createBrandDropdown\', \'ProductBrand\', \'${b.id}\', \'${b.name}\')"><span>${b.name}</span></div>`;
                bUpdateOpts += `<option value="${b.id}">${b.name}</option>`;
            });

            $('#filterBrand').html(bNativeOpts);
            $('#filterBrandDropdown .select-options-list').html(bCustomList);
            $('#createBrandDropdown .select-options-list').html(bModalList);
            $('#ProductBrand').html('<option value="none">Select Brand</option>' + bNativeOpts.replace('<option value="">All Brands</option>', ''));
            $('#updateProductBrand').html(bUpdateOpts);

            // Populate Category Filters & Modal Options
            let cNativeOpts = '<option value="">All Categories</option>';
            let cCustomList = '<div class="select-option-item active" data-value="" data-label="All Categories" onclick="selectCustomFilterOption(\'filterCategoryDropdown\', \'filterCategory\', \'\', \'All Categories\')"><span>All Categories</span><svg class="w-3.5 h-3.5 text-emerald-600 check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg></div>';
            let cModalList = '';
            let cUpdateOpts = '<option value="">Select Category</option>';

            categoriesList.forEach(c => {
                const name = c.category_name || c.name;
                cNativeOpts += `<option value="${c.id}">${name}</option>`;
                cCustomList += `<div class="select-option-item" data-value="${c.id}" data-label="${name}" onclick="selectCustomFilterOption(\'filterCategoryDropdown\', \'filterCategory\', \'${c.id}\', \'${name}\')"><span>${name}</span></div>`;
                cModalList += `<div class="select-option-item" data-value="${c.id}" data-label="${name}" onclick="selectModalDropdownOption(\'createCategoryDropdown\', \'ProductCategoryDataID\', \'${c.id}\', \'${name}\')"><span>${name}</span></div>`;
                cUpdateOpts += `<option value="${c.id}">${name}</option>`;
            });

            $('#filterCategory').html(cNativeOpts);
            $('#filterCategoryDropdown .select-options-list').html(cCustomList);
            $('#createCategoryDropdown .select-options-list').html(cModalList);
            $('#ProductCategoryDataID').html('<option value="none" selected>Select Category</option>' + cNativeOpts.replace('<option value="">All Categories</option>', ''));
            $('#updateProductCategory').html(cUpdateOpts);
            $('#CreateSubCategoryParent').html(cUpdateOpts);

        } catch (e) {
            console.error('Filter options load error:', e);
        }
    }

    // Fetch Products List
    async function getBatteryProductList() {
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.get('/api/battery/product-list', HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                rawProductData = res.data.ProductData || res.data.data || [];
                renderProducts();
            } else {
                rawProductData = [];
                renderProducts();
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            errorToast('Failed to load battery products');
        }
    }

    // Render Table with Retail Grouping Logic (Category, Brand, Name)
    function renderProducts() {
        const searchTerm = ($('#searchInput').val() || '').toLowerCase().trim();
        const selectedBrandId = $('#filterBrand').val();
        const selectedCatId = $('#filterCategory').val();

        const filtered = rawProductData.filter(item => {
            const pName = (item.product_name || item.name || '').toLowerCase();
            const bName = (item.brand?.name || '').toLowerCase();
            const cName = (item.category?.category_name || item.category?.name || '').toLowerCase();
            let codeStr = '';
            try {
                let parsed = typeof item.product_code === 'string' ? JSON.parse(item.product_code) : item.product_code;
                codeStr = Array.isArray(parsed) ? parsed.join(' ') : String(parsed || '');
            } catch (e) {
                codeStr = String(item.product_code || '');
            }
            codeStr = codeStr.toLowerCase();

            const matchSearch = !searchTerm || pName.includes(searchTerm) || bName.includes(searchTerm) || cName.includes(searchTerm) || codeStr.includes(searchTerm);
            const matchBrand = !selectedBrandId || String(item.brand_id) === String(selectedBrandId);
            const matchCat = !selectedCatId || String(item.category_id) === String(selectedCatId);

            return matchSearch && matchBrand && matchCat;
        });

        // Calculate Grand Totals for Filtered Items
        let totalQuantity = 0;
        let totalCostPrice = 0;
        let totalSellingPrice = 0;
        let totalCostQuantityPrice = 0;

        filtered.forEach(item => {
            const qty = parseFloat(item.quantity) || 0;
            const cost = parseFloat(item.cost_price) || 0;
            const sell = parseFloat(item.sell_price || item.price) || 0;
            totalQuantity += qty;
            totalCostPrice += cost;
            totalSellingPrice += sell;
            totalCostQuantityPrice += (cost * qty);
        });

        $('#totalQuantity').text(totalQuantity.toFixed(0));
        $('#totalCostPrice').text(formatBdCurrency(totalCostPrice));
        $('#totalCostQuantityPrice').text(formatBdCurrency(totalCostQuantityPrice));
        $('#totalSellingPrice').text(formatBdCurrency(totalSellingPrice));

        // Group Products by (category_id, brand_id, product_name)
        let groupedMap = {};
        let groupedList = [];

        filtered.forEach(item => {
            const catId = item.category_id || 0;
            const brandId = item.brand_id || 0;
            const pName = (item.product_name || item.name || '').trim().toLowerCase();
            const key = `${catId}_${brandId}_${pName}`;
            const itemId = parseInt(item.id) || 0;

            if (!groupedMap[key]) {
                groupedMap[key] = {
                    key: key,
                    maxId: itemId,
                    mainItem: item,
                    items: [],
                    totalQuantity: 0,
                    totalCostQuantityPrice: 0,
                    minCostPrice: parseFloat(item.cost_price) || 0,
                    maxCostPrice: parseFloat(item.cost_price) || 0,
                    minSellPrice: parseFloat(item.sell_price || item.price) || 0,
                    maxSellPrice: parseFloat(item.sell_price || item.price) || 0
                };
                groupedList.push(groupedMap[key]);
            } else {
                if (itemId > groupedMap[key].maxId) {
                    groupedMap[key].maxId = itemId;
                    groupedMap[key].mainItem = item;
                }
            }

            const g = groupedMap[key];
            g.items.push(item);
            const qty = parseFloat(item.quantity) || 0;
            const cost = parseFloat(item.cost_price) || 0;
            const sell = parseFloat(item.sell_price || item.price) || 0;

            g.totalQuantity += qty;
            g.totalCostQuantityPrice += (cost * qty);
            if (cost < g.minCostPrice) g.minCostPrice = cost;
            if (cost > g.maxCostPrice) g.maxCostPrice = cost;
            if (sell < g.minSellPrice) g.minSellPrice = sell;
            if (sell > g.maxSellPrice) g.maxSellPrice = sell;
        });

        groupedList.sort((a, b) => (b.maxId || 0) - (a.maxId || 0));

        // Pagination
        const totalItems = groupedList.length;
        const totalPages = Math.ceil(totalItems / pageSize) || 1;
        if (currentPage > totalPages) currentPage = 1;

        const startIndex = (currentPage - 1) * pageSize;
        const endIndex = Math.min(startIndex + pageSize, totalItems);
        const pageItems = groupedList.slice(startIndex, endIndex);

        const tableList = $('#tableList');
        const mobileCardList = $('#mobileCardList');
        tableList.empty();
        mobileCardList.empty();

        if (pageItems.length === 0) {
            tableList.html('<tr><td colspan="10" class="text-center text-rose-500 p-8 font-semibold"><i class="fa-solid fa-boxes-stacked fs-4 mb-2 d-block opacity-75"></i>No battery products found.</td></tr>');
            mobileCardList.html('<div class="p-6 text-center text-rose-500 font-semibold bg-white dark:bg-slate-800 rounded-2xl unified-ui-border shadow-sm">No battery products found.</div>');
        } else {
            pageItems.forEach((group, idx) => {
                const realIndex = startIndex + idx;
                const item = group.mainItem;
                const isMultiVariant = group.items.length > 1;
                const catName = item.category?.category_name || item.category?.name || '-';
                const brandName = item.brand?.name || '-';
                const unitName = item.unit?.unit_name || '';

                // Stock status badge
                let stockStatusBadge = '';
                if (group.totalQuantity <= 0) {
                    stockStatusBadge = '<span class="badge out-of-stock">Out of Stock</span>';
                } else if (group.totalQuantity <= 5) {
                    stockStatusBadge = '<span class="badge low-stock">Low Stock</span>';
                } else {
                    stockStatusBadge = '<span class="badge available">In Stock</span>';
                }

                // Barcodes combining
                let combinedCodes = [];
                group.items.forEach(sub => {
                    try {
                        let parsed = typeof sub.product_code === 'string' ? JSON.parse(sub.product_code) : sub.product_code;
                        if (Array.isArray(parsed)) combinedCodes.push(...parsed);
                        else if (parsed) combinedCodes.push(parsed);
                    } catch (e) {
                        if (sub.product_code) combinedCodes.push(sub.product_code);
                    }
                });
                combinedCodes = [...new Set(combinedCodes.filter(Boolean))];
                let allBarcodesHtml = combinedCodes.length > 0
                    ? combinedCodes.slice(0, 3).map(c => `<span class="barcode-badge-pill mr-1 mb-1">${c}</span>`).join('') + (combinedCodes.length > 3 ? `<span class="badge bg-slate-100 text-slate-600 border">+${combinedCodes.length - 3}</span>` : '')
                    : '<span class="text-slate-400 text-xs">N/A</span>';

                // Cost & Sell displays
                const costDisplay = group.minCostPrice === group.maxCostPrice
                    ? formatBdCurrency(group.minCostPrice)
                    : `${formatBdCurrency(group.minCostPrice)} - ${formatBdCurrency(group.maxCostPrice)}`;
                const sellDisplay = group.minSellPrice === group.maxSellPrice
                    ? formatBdCurrency(group.minSellPrice)
                    : `${formatBdCurrency(group.minSellPrice)} - ${formatBdCurrency(group.maxSellPrice)}`;

                // Badge in Name column
                const variantBadgeName = isMultiVariant
                    ? `<div class="mt-1"><span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-950/40 dark:text-amber-300"><i class="fa-solid fa-layer-group me-1"></i>${group.items.length} Stock Records</span></div>`
                    : '';

                // Action buttons
                let actionHtml = `
                    <div class="d-flex align-items-center justify-content-center gap-1.5">
                        <button type="button" onclick="openQuickViewModal('${item.id}')" class="w-[30px] h-[30px] rounded-lg border bg-slate-50 hover:bg-slate-100 text-slate-700 flex items-center justify-center transition-all shadow-sm" title="Quick View">
                            <i class="fa-regular fa-eye" style="font-size: 12px;"></i>
                        </button>
                        ${isMultiVariant ? `
                        <button type="button" class="w-[30px] h-[30px] rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 border flex items-center justify-center transition-all toggle-variant-btn shadow-sm" data-target="variant-row-${realIndex}" title="Show / Hide Stock Records (${group.items.length} items)">
                            <i class="fa-solid fa-chevron-down chevron-icon" style="font-size: 11px; transition: transform 0.2s;"></i>
                        </button>
                        ` : ''}
                        <button type="button" onclick="openProductUpdateModal('${item.id}')" class="w-[30px] h-[30px] rounded-lg bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200 flex items-center justify-center transition-all shadow-sm" title="Edit">
                            <i class="fa-solid fa-pencil" style="font-size: 11px;"></i>
                        </button>
                        <button type="button" onclick="openProductDeleteModal('${item.id}')" class="w-[30px] h-[30px] rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200 flex items-center justify-center transition-all shadow-sm" title="Delete">
                            <i class="fa-solid fa-trash-can" style="font-size: 11px;"></i>
                        </button>
                    </div>
                `;

                // Main Row
                const mainRow = `
                <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors border-b border-slate-100 dark:border-slate-800">
                    <td class="p-[10px] text-center font-semibold text-slate-400">${realIndex + 1}</td>
                    <td class="p-[10px] text-start">${allBarcodesHtml}</td>
                    <td class="p-[10px] text-start">
                        <div class="font-bold text-slate-800 dark:text-slate-100 text-sm leading-snug">${item.product_name || item.name}</div>
                        ${variantBadgeName}
                    </td>
                    <td class="p-[10px] text-start">
                        <span class="font-medium text-slate-700 dark:text-slate-200">${catName}</span>
                        ${brandName !== '-' ? `<div class="text-[11px] text-slate-500 mt-0.5"><i class="fa-solid fa-tag text-emerald-600 me-1"></i>${brandName}</div>` : ''}
                    </td>
                    <td class="p-[10px] text-center">
                        <span class="font-bold text-slate-800 dark:text-slate-100 text-sm">${group.totalQuantity} ${unitName}</span>
                    </td>
                    <td class="p-[10px] text-end font-medium text-slate-600 dark:text-slate-300 whitespace-nowrap">৳ ${costDisplay}</td>
                    <td class="p-[10px] text-end font-bold text-slate-900 dark:text-white whitespace-nowrap">৳ ${formatBdCurrency(group.totalCostQuantityPrice)}</td>
                    <td class="p-[10px] text-end font-semibold text-emerald-600 dark:text-emerald-400 whitespace-nowrap">৳ ${sellDisplay}</td>
                    <td class="p-[10px] text-center">${stockStatusBadge}</td>
                    <td class="p-[10px] text-center">${actionHtml}</td>
                </tr>`;

                tableList.append(mainRow);

                // Nested Sub-Table for Multiple Stock Records / Price Batches (Visual Reference 1)
                if (isMultiVariant) {
                    const subRows = group.items.map((sub, sIdx) => {
                        const subTotalCost = formatBdCurrency((parseFloat(sub.cost_price) || 0) * (parseFloat(sub.quantity) || 0));
                        const subStockBadge = (sub.quantity <= 0)
                            ? '<span class="badge out-of-stock" style="font-size: 10px;">Out of Stock</span>'
                            : (sub.quantity <= 5
                                ? '<span class="badge low-stock" style="font-size: 10px;">Low Stock</span>'
                                : '<span class="badge available" style="font-size: 10px;">In Stock</span>');

                        return `
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-3 py-2 text-start">
                                <span class="badge bg-slate-100 text-slate-700 border px-2 py-0.5 font-bold" style="font-size: 11px; border-radius: 6px;">
                                    🏷️ Entry #${sIdx + 1}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-start">${formatProductCode(sub.product_code)}</td>
                            <td class="px-3 py-2 text-center font-bold text-slate-800 dark:text-slate-100">${sub.quantity} ${unitName}</td>
                            <td class="px-3 py-2 text-end text-slate-600 whitespace-nowrap">৳ ${formatBdCurrency(sub.cost_price)}</td>
                            <td class="px-3 py-2 text-end font-bold text-slate-900 whitespace-nowrap">৳ ${subTotalCost}</td>
                            <td class="px-3 py-2 text-end text-emerald-600 font-semibold whitespace-nowrap">৳ ${formatBdCurrency(sub.sell_price || sub.price)}</td>
                            <td class="px-3 py-2 text-center">${subStockBadge}</td>
                            <td class="px-3 py-2 text-center">
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    <button type="button" onclick="openQuickViewModal('${sub.id}')" class="w-[26px] h-[26px] rounded-md border bg-white flex items-center justify-center" title="Quick View">
                                        <i class="fa-regular fa-eye" style="font-size: 10px;"></i>
                                    </button>
                                    <button type="button" onclick="openProductUpdateModal('${sub.id}')" class="w-[26px] h-[26px] rounded-md bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center" title="Edit">
                                        <i class="fa-solid fa-pencil" style="font-size: 10px;"></i>
                                    </button>
                                    <button type="button" onclick="openProductDeleteModal('${sub.id}')" class="w-[26px] h-[26px] rounded-md bg-rose-50 text-rose-600 border border-rose-200 flex items-center justify-center" title="Delete">
                                        <i class="fa-solid fa-trash-can" style="font-size: 10px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>`;
                    }).join('');

                    const accordionRow = `
                    <tr id="variant-row-${realIndex}" class="variant-accordion-row bg-slate-50/80 dark:bg-slate-900/60" style="display: none;">
                        <td colspan="10" class="p-4">
                            <div class="rounded-xl border border-emerald-200/80 shadow-sm p-4 bg-white dark:bg-slate-800/90">
                                <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom border-slate-100">
                                    <h6 class="font-bold text-slate-800 text-xs sm:text-sm d-flex align-items-center gap-2 mb-0">
                                        <i class="fa-solid fa-boxes-stacked text-emerald-600"></i>
                                        <span><strong>${item.product_name || item.name}</strong> - Stock Records &amp; Price Batches (${group.items.length} Records)</span>
                                    </h6>
                                    <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 font-semibold text-xs px-2.5 py-1">Total Stock: ${group.totalQuantity} ${unitName}</span>
                                </div>
                                <div class="overflow-x-auto rounded-lg border border-slate-200">
                                    <table class="w-full text-left border-collapse text-xs">
                                        <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                                            <tr>
                                                <th class="px-3 py-2 text-start w-[140px]">Record / Batch</th>
                                                <th class="px-3 py-2 text-start">Barcode</th>
                                                <th class="px-3 py-2 text-center w-[110px]">Stock Qty</th>
                                                <th class="px-3 py-2 text-end w-[110px]">Cost Price</th>
                                                <th class="px-3 py-2 text-end w-[110px]">Total Cost</th>
                                                <th class="px-3 py-2 text-end w-[110px]">Selling Price</th>
                                                <th class="px-3 py-2 text-center w-[90px]">Status</th>
                                                <th class="px-3 py-2 text-center w-[80px]">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            ${subRows}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>`;

                    tableList.append(accordionRow);
                }

                // Mobile Card View
                mobileCardList.append(`
                    <div class="unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800 shadow-sm flex items-center justify-between gap-3">
                        <div>
                            <div class="font-bold text-slate-800 dark:text-slate-100 text-sm">${item.product_name || item.name}</div>
                            <div class="text-xs text-slate-500 mt-0.5">${brandName} | ${catName}</div>
                            <div class="text-xs font-bold text-emerald-600 mt-1">৳${sellDisplay} | Stock: ${group.totalQuantity}</div>
                        </div>
                        <div class="d-flex align-items-center gap-1.5">
                            <button type="button" onclick="openQuickViewModal('${item.id}')" class="w-[30px] h-[30px] rounded-lg border bg-slate-50 flex items-center justify-center">
                                <i class="fa-regular fa-eye text-xs"></i>
                            </button>
                            <button type="button" onclick="openProductUpdateModal('${item.id}')" class="w-[30px] h-[30px] rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center">
                                <i class="fa-solid fa-pencil text-xs"></i>
                            </button>
                            <button type="button" onclick="openProductDeleteModal('${item.id}')" class="w-[30px] h-[30px] rounded-lg bg-rose-50 text-rose-600 border border-rose-200 flex items-center justify-center">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </div>
                    </div>
                `);
            });
        }

        // Display Info & Pagination
        $('#display-info').html(totalItems > 0
            ? `Showing <strong class="text-slate-700">${startIndex + 1}</strong> to <strong class="text-slate-700">${endIndex}</strong> of <strong class="text-slate-700">${totalItems}</strong> entries`
            : `Showing 0 to 0 of 0 entries`);

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        const p = $('#pagination');
        p.empty();
        if (totalPages <= 1) return;

        const btnClass = "h-8 min-w-[32px] px-2 rounded-lg text-xs font-semibold border flex items-center justify-center transition-all ";
        p.append(`<button onclick="goPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''} class="${btnClass} ${currentPage === 1 ? 'opacity-40 cursor-not-allowed border-slate-200 text-slate-400' : 'border-slate-200 hover:bg-slate-100 text-slate-700'}">‹</button>`);
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                p.append(`<button onclick="goPage(${i})" class="${btnClass} ${i === currentPage ? 'bg-emerald-700 text-white border-emerald-700' : 'border-slate-200 hover:bg-slate-100 text-slate-700'}">${i}</button>`);
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                p.append(`<span class="px-1 text-slate-400">…</span>`);
            }
        }
        p.append(`<button onclick="goPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''} class="${btnClass} ${currentPage === totalPages ? 'opacity-40 cursor-not-allowed border-slate-200 text-slate-400' : 'border-slate-200 hover:bg-slate-100 text-slate-700'}">›</button>`);
    }

    function goPage(page) {
        currentPage = page;
        renderProducts();
    }

    // ==========================================
    // QUICK VIEW MODAL
    // ==========================================
    function openQuickViewModal(productId) {
        const item = rawProductData.find(p => String(p.id) === String(productId));
        if (!item) return;

        const pName = item.product_name || item.name || '';
        const catName = item.category?.category_name || item.category?.name || '-';
        const brandName = item.brand?.name || '-';
        const unitName = item.unit?.unit_name || 'N/A';

        // Find related items in group
        const groupItems = rawProductData.filter(p => {
            return String(p.category_id) === String(item.category_id) &&
                   String(p.brand_id) === String(item.brand_id) &&
                   (p.product_name || p.name || '').trim().toLowerCase() === pName.trim().toLowerCase();
        });

        let totalQty = 0;
        let totalCostValue = 0;
        let minCost = parseFloat(item.cost_price) || 0;
        let maxCost = parseFloat(item.cost_price) || 0;
        let minSell = parseFloat(item.sell_price || item.price) || 0;
        let maxSell = parseFloat(item.sell_price || item.price) || 0;

        groupItems.forEach(g => {
            const q = parseFloat(g.quantity) || 0;
            const c = parseFloat(g.cost_price) || 0;
            const s = parseFloat(g.sell_price || g.price) || 0;
            totalQty += q;
            totalCostValue += (c * q);
            if (c < minCost) minCost = c;
            if (c > maxCost) maxCost = c;
            if (s < minSell) minSell = s;
            if (s > maxSell) maxSell = s;
        });

        $('#qvProductName').text(pName);
        $('#qvQuantity').text(totalQty);
        $('#qvCostPrice').text(minCost === maxCost ? `৳ ${formatBdCurrency(minCost)}` : `৳ ${formatBdCurrency(minCost)} - ${formatBdCurrency(maxCost)}`);
        $('#qvSellPrice').text(minSell === maxSell ? `৳ ${formatBdCurrency(minSell)}` : `৳ ${formatBdCurrency(minSell)} - ${formatBdCurrency(maxSell)}`);
        $('#qvTotalCostValue').text(`Total Value: ৳ ${formatBdCurrency(totalCostValue)}`);
        $('#qvCategory').text(catName);
        $('#qvBrand').text(brandName);
        $('#qvUnit').text(unitName);

        // Stock badge
        let badgeHtml = totalQty <= 0
            ? '<span class="badge out-of-stock">Out of Stock</span>'
            : (totalQty <= 5 ? '<span class="badge low-stock">Low Stock</span>' : '<span class="badge available">In Stock</span>');
        $('#qvStockBadgeWrap').html(badgeHtml);

        // Barcodes
        let combined = [];
        groupItems.forEach(g => {
            try {
                let parsed = typeof g.product_code === 'string' ? JSON.parse(g.product_code) : g.product_code;
                if (Array.isArray(parsed)) combined.push(...parsed);
                else if (parsed) combined.push(parsed);
            } catch (e) {
                if (g.product_code) combined.push(g.product_code);
            }
        });
        combined = [...new Set(combined.filter(Boolean))];
        $('#qvBarcodes').html(combined.length > 0 ? combined.map(c => `<span class="barcode-badge-pill">${c}</span>`).join(' ') : '<span class="text-muted">N/A</span>');

        // Multi batches section
        if (groupItems.length > 1) {
            let vHtml = groupItems.map((v, i) => {
                const q = parseFloat(v.quantity) || 0;
                return `
                <tr>
                    <td class="p-2.5 font-semibold text-slate-800">🏷️ Entry #${i + 1}</td>
                    <td class="p-2.5">${formatProductCode(v.product_code)}</td>
                    <td class="p-2.5 text-center font-bold text-slate-800">${q} ${unitName}</td>
                    <td class="p-2.5 text-end text-slate-600">৳ ${formatBdCurrency(v.cost_price)}</td>
                    <td class="p-2.5 text-end text-emerald-600 font-semibold">৳ ${formatBdCurrency(v.sell_price || v.price)}</td>
                    <td class="p-2.5 text-center">${q <= 0 ? '<span class="badge out-of-stock">Out of Stock</span>' : (q <= 5 ? '<span class="badge low-stock">Low Stock</span>' : '<span class="badge available">In Stock</span>')}</td>
                </tr>`;
            }).join('');
            $('#qvVariantsTableBody').html(vHtml);
            $('#qvVariantsSection').show();
        } else {
            $('#qvVariantsSection').hide();
        }

        const modalEl = document.getElementById('productQuickViewModal');
        const modalObj = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modalObj.show();
    }

    // ==========================================
    // ADD PRODUCT MODAL LOGIC (Image 3 Parity)
    // ==========================================
    function openProductCreateModal() {
        const modal = document.getElementById('createProduct');
        if (modal) {
            modal.classList.add('show');
            modal.classList.add('show-modal');
            modal.style.setProperty('display', 'flex', 'important');
            document.body.style.overflow = 'hidden';
            closeAllCustomProductDropdowns();
        }
    }

    function closeProductModal() {
        const modal = document.getElementById('createProduct');
        if (modal) {
            modal.classList.remove('show');
            modal.classList.remove('show-modal');
            modal.style.setProperty('display', 'none', 'important');
            document.body.style.overflow = '';
        }
        resetProductForm();
    }

    function resetProductForm() {
        document.getElementById('createProductForm').reset();
        barcodeList = [];
        renderBarcodes();
        resetProductImagePreview();
        isProductDuplicateDetected = false;
        $('#productNameDuplicateAlert').hide();
        $('#ProductBrand').val('none');
        $('#ProductCategoryDataID').val('none');
        $('#ProductSubCategoryID').val('none');

        const bText = document.querySelector('#createBrandDropdown .selected-text');
        if (bText) { bText.textContent = 'Select Brand'; bText.style.color = '#64748b'; }
        const cText = document.querySelector('#createCategoryDropdown .selected-text');
        if (cText) { cText.innerHTML = 'Select Category <span class="text-danger">*</span>'; cText.style.color = '#64748b'; }
        const sText = document.querySelector('#createSubCategoryDropdown .selected-text');
        if (sText) { sText.textContent = 'Select Sub-Category'; sText.style.color = '#64748b'; }
    }

    function previewProductImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#ProductImagePreview').attr('src', e.target.result).show();
                $('#ProductImageDefaultIcon').hide();
            };
            reader.readAsDataURL(file);
        }
    }

    function resetProductImagePreview() {
        $('#ProductImagePreview').attr('src', '').hide();
        $('#ProductImageDefaultIcon').show();
        $('#ProductImage').val('');
    }

    // Barcode Tags Input
    function handleBarcodeKey(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            const input = document.getElementById('ProductCodeInput');
            const code = input.value.trim();
            if (code && !barcodeList.includes(code)) {
                barcodeList.push(code);
                renderBarcodes();
                input.value = '';
            }
        }
    }

    function addBarcode(code) {
        const clean = (code || '').trim();
        if (clean && !barcodeList.includes(clean)) {
            barcodeList.push(clean);
            renderBarcodes();
        }
    }

    function removeBarcode(code) {
        barcodeList = barcodeList.filter(c => c !== code);
        renderBarcodes();
    }

    function renderBarcodes() {
        const container = document.getElementById('BarcodeContainer');
        if (!container) return;
        container.innerHTML = barcodeList.map(c => `
            <span class="barcode-badge-pill">
                <span>${c}</span>
                <span class="remove-code-btn" onclick="removeBarcode('${c}')">&times;</span>
            </span>
        `).join('');
    }

    // Dynamic Duplicate Check
    async function checkDuplicateProductName() {
        clearTimeout(duplicateCheckTimeout);
        duplicateCheckTimeout = setTimeout(async () => {
            const nameInput = document.getElementById('ProductName');
            const alertBox = document.getElementById('productNameDuplicateAlert');
            const alertText = document.getElementById('productNameDuplicateText');
            if (!nameInput || !alertBox || !alertText) return;

            const pName = nameInput.value.trim();
            const brandId = document.getElementById('ProductBrand')?.value;
            const catId = document.getElementById('ProductCategoryDataID')?.value;

            if (!pName || pName.length < 2) {
                alertBox.style.display = 'none';
                isProductDuplicateDetected = false;
                nameInput.style.borderColor = '#cbd5e1';
                return;
            }

            try {
                const res = await axios.post('/api/battery/check-duplicate-product', {
                    product_name: pName,
                    brand_id: brandId !== 'none' ? brandId : null,
                    category_id: catId !== 'none' ? catId : null
                }, HeaderToken());

                if (res.data?.exists && res.data?.product) {
                    isProductDuplicateDetected = true;
                    const existing = res.data.product;
                    const stockQty = parseInt(existing.quantity) || 0;
                    const costVal = parseFloat(existing.cost_price) || 0;
                    alertText.innerHTML = `<strong>সতর্কতা:</strong> এই নামের ব্যাটারি ইতিমধ্যে ডাটাবেজে রয়েছে! (বর্তমান স্টক: <strong>${stockQty}</strong>, কস্ট: <strong>৳${costVal}</strong>)। স্টক বাড়াতে <strong>Purchase</strong> বা <strong>Edit</strong> করুন।`;
                    alertBox.style.display = 'block';
                    nameInput.style.borderColor = '#f59e0b';
                } else {
                    isProductDuplicateDetected = false;
                    alertBox.style.display = 'none';
                    nameInput.style.borderColor = '#cbd5e1';
                }
            } catch (err) {
                console.error(err);
            }
        }, 300);
    }

    // Save Product
    async function ProductDataSave(event) {
        if (event && typeof event.preventDefault === 'function') event.preventDefault();
        try {
            const productName = $('#ProductName').val().trim();
            const brandId = $('#ProductBrand').val();
            const catId = $('#ProductCategoryDataID').val();
            const subCatId = $('#ProductSubCategoryID').val();
            const qty = $('#ProductQuantity').val().trim() || 0;
            const cost = $('#ProductCostPrice').val().trim() || 0;
            const sell = $('#ProductSellingPrice').val().trim() || 0;
            const imageFile = document.getElementById('ProductImage').files[0];

            if (!productName) {
                errorToast("Product Name is required!");
                return false;
            }
            if (!catId || catId === 'none') {
                errorToast("Product Category is required!");
                return false;
            }

            let finalBarcodes = [...barcodeList];
            const pendingCode = $('#ProductCodeInput').val().trim();
            if (pendingCode && !finalBarcodes.includes(pendingCode)) {
                finalBarcodes.push(pendingCode);
            }

            let formData = new FormData();
            formData.append('product_name', productName);
            formData.append('brand_id', brandId !== 'none' ? brandId : '');
            formData.append('category_id', catId !== 'none' ? catId : '');
            if (subCatId && subCatId !== 'none') formData.append('sub_category_id', subCatId);
            formData.append('quantity', qty);
            formData.append('cost_price', cost);
            formData.append('sell_price', sell);
            formData.append('product_code', JSON.stringify(finalBarcodes));
            formData.append('status', 'Active');
            if (imageFile) {
                formData.append('img_url', imageFile);
                formData.append('img', imageFile);
            }

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/create-product', formData, {
                headers: { 'Content-Type': 'multipart/form-data', ...HeaderToken().headers }
            });
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data?.status === 'success') {
                successToast(res.data.message || 'Battery Product Created Successfully');
                closeProductModal();
                getBatteryProductList();
            } else {
                errorToast(res.data?.message || 'Failed to create battery product');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to save product');
        }
        return false;
    }

    // ==========================================
    // EDIT PRODUCT MODAL LOGIC
    // ==========================================
    function openProductUpdateModal(id) {
        const item = rawProductData.find(p => String(p.id) === String(id));
        if (!item) return;

        $('#updateProductId').val(item.id);
        $('#updateProductName').val(item.product_name || item.name || '');
        $('#updateProductBrand').val(item.brand_id || '');
        $('#updateProductCategory').val(item.category_id || '');
        onCategoryChanged('update');
        $('#updateProductSubCategory').val(item.sub_category_id || '');
        $('#updateProductQty').val(item.quantity || 0);
        $('#updateProductCost').val(item.cost_price || 0);
        $('#updateProductSell').val(item.sell_price || item.price || 0);
        $('#updateProductImagePreview').attr('src', item.img_url ? (item.img_url.startsWith('http') ? item.img_url : `/${item.img_url}`) : "{{ asset('backend/assets/img/product-img.svg') }}");
        $('#updateProductImage').val('');

        updateBarcodeList = [];
        try {
            let parsed = typeof item.product_code === 'string' ? JSON.parse(item.product_code) : item.product_code;
            if (Array.isArray(parsed)) updateBarcodeList = parsed.filter(Boolean);
            else if (parsed) updateBarcodeList = [parsed];
        } catch (e) {
            if (item.product_code) updateBarcodeList = [item.product_code];
        }
        renderUpdateBarcodes();

        $('#productUpdateModal').modal('show');
    }

    function onCategoryChanged(mode) {
        const catId = mode === 'update' ? $('#updateProductCategory').val() : '';
        const target = $('#updateProductSubCategory');
        const filtered = subCategoriesList.filter(s => String(s.category_id) === String(catId));
        let opts = '<option value="">Select Sub-Category</option>';
        filtered.forEach(s => opts += `<option value="${s.id}">${s.name}</option>`);
        target.html(opts);
    }

    function previewUpdateImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#updateProductImagePreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    }

    function handleUpdateBarcodeKey(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            const input = document.getElementById('updateProductCodeInput');
            const code = input.value.trim();
            if (code && !updateBarcodeList.includes(code)) {
                updateBarcodeList.push(code);
                renderUpdateBarcodes();
                input.value = '';
            }
        }
    }

    function removeUpdateBarcode(code) {
        updateBarcodeList = updateBarcodeList.filter(c => c !== code);
        renderUpdateBarcodes();
    }

    function renderUpdateBarcodes() {
        const container = document.getElementById('updateBarcodeContainer');
        if (!container) return;
        container.innerHTML = updateBarcodeList.map(c => `
            <span class="barcode-badge-pill">
                <span>${c}</span>
                <span class="remove-code-btn" onclick="removeUpdateBarcode('${c}')">&times;</span>
            </span>
        `).join('');
    }

    async function updateBatteryProduct(e) {
        if (e && typeof e.preventDefault === 'function') e.preventDefault();
        try {
            const id = $('#updateProductId').val();
            const pName = $('#updateProductName').val().trim();
            if (!pName) {
                errorToast("Product Name is required!");
                return;
            }

            let finalCodes = [...updateBarcodeList];
            const pending = $('#updateProductCodeInput').val().trim();
            if (pending && !finalCodes.includes(pending)) finalCodes.push(pending);

            let formData = new FormData();
            formData.append('id', id);
            formData.append('product_name', pName);
            formData.append('brand_id', $('#updateProductBrand').val() || '');
            formData.append('category_id', $('#updateProductCategory').val() || '');
            formData.append('sub_category_id', $('#updateProductSubCategory').val() || '');
            formData.append('quantity', $('#updateProductQty').val() || 0);
            formData.append('cost_price', $('#updateProductCost').val() || 0);
            formData.append('sell_price', $('#updateProductSell').val() || 0);
            formData.append('product_code', JSON.stringify(finalCodes));
            formData.append('status', 'Active');

            const file = document.getElementById('updateProductImage').files[0];
            if (file) {
                formData.append('img_url', file);
                formData.append('img', file);
            }

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/update-product', formData, {
                headers: { 'Content-Type': 'multipart/form-data', ...HeaderToken().headers }
            });
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data?.status === 'success') {
                successToast(res.data.message || 'Product updated successfully');
                $('#productUpdateModal').modal('hide');
                getBatteryProductList();
            } else {
                errorToast(res.data?.message || 'Failed to update product');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to update product');
        }
    }

    // ==========================================
    // DELETE PRODUCT MODAL LOGIC
    // ==========================================
    function openProductDeleteModal(id) {
        $('#deleteID').val(id);
        $('#confirmationModal').modal('show');
    }

    async function itemDelete(event) {
        if (event && typeof event.preventDefault === 'function') event.preventDefault();
        try {
            const id = $('#deleteID').val();
            if (!id) return;

            if (typeof showLoader === 'function') showLoader();
            const res = await axios.post('/api/battery/delete-product', { id: id }, HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data?.status === 'success') {
                successToast(res.data.message || 'Product deleted successfully');
                $('#confirmationModal').modal('hide');
                getBatteryProductList();
            } else {
                errorToast(res.data?.message || 'Failed to delete product');
            }
        } catch (err) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(err);
            errorToast('Failed to delete product');
        }
    }

    // ==========================================
    // QUICK ADD BRAND, CATEGORY, SUBCATEGORY
    // ==========================================
    function openBrandModal() { $('#addBrandModal').addClass('show'); }
    function closeBrandModal() { $('#addBrandModal').removeClass('show'); $('#addBrandForm')[0].reset(); }
    async function BrandSave(e) {
        e.preventDefault();
        try {
            const name = $('#CreateBrandName').val().trim();
            if (!name) return;
            let fd = new FormData();
            fd.append('name', name);
            const img = document.getElementById('CreateBrandImg').files[0];
            if (img) fd.append('img_url', img);

            showLoader();
            const res = await axios.post('/api/battery/create-brand', fd, {
                headers: { 'Content-Type': 'multipart/form-data', ...HeaderToken().headers }
            });
            hideLoader();

            if (res.data?.status === 'success') {
                successToast('Brand created successfully');
                closeBrandModal();
                await loadFilterOptions();
                if (res.data.newBrandId) {
                    selectModalDropdownOption('createBrandDropdown', 'ProductBrand', res.data.newBrandId, name);
                }
            } else {
                errorToast(res.data?.message || 'Failed to create brand');
            }
        } catch (err) {
            hideLoader();
            console.error(err);
            errorToast('Failed to save brand');
        }
    }

    function openCategoryModal() { $('#addCategoryModal').addClass('show'); }
    function closeCategoryModal() { $('#addCategoryModal').removeClass('show'); $('#addCategoryForm')[0].reset(); }
    async function CategorySave(e) {
        e.preventDefault();
        try {
            const name = $('#CreateCategoryName').val().trim();
            if (!name) return;
            let fd = new FormData();
            fd.append('name', name);
            fd.append('category_name', name);
            const img = document.getElementById('CreateCategoryImg').files[0];
            if (img) fd.append('img_url', img);

            showLoader();
            const res = await axios.post('/api/battery/create-category', fd, {
                headers: { 'Content-Type': 'multipart/form-data', ...HeaderToken().headers }
            });
            hideLoader();

            if (res.data?.status === 'success') {
                successToast('Category created successfully');
                closeCategoryModal();
                await loadFilterOptions();
                if (res.data.newCategoryId) {
                    selectModalDropdownOption('createCategoryDropdown', 'ProductCategoryDataID', res.data.newCategoryId, name);
                }
            } else {
                errorToast(res.data?.message || 'Failed to create category');
            }
        } catch (err) {
            hideLoader();
            console.error(err);
            errorToast('Failed to save category');
        }
    }

    function openSubCategoryModal() {
        const catId = $('#ProductCategoryDataID').val();
        if (catId && catId !== 'none') {
            $('#CreateSubCategoryParent').val(catId);
        }
        $('#addSubCategoryModal').addClass('show');
    }
    function closeSubCategoryModal() { $('#addSubCategoryModal').removeClass('show'); $('#addSubCategoryForm')[0].reset(); }
    async function SubCategorySave(e) {
        e.preventDefault();
        try {
            const catId = $('#CreateSubCategoryParent').val();
            const name = $('#CreateSubCategoryName').val().trim();
            if (!catId || !name) {
                errorToast('Please select category and enter sub-category name');
                return;
            }

            showLoader();
            const res = await axios.post('/api/battery/sub-create-category', {
                category_id: catId,
                name: name,
                sub_category_name: name
            }, HeaderToken());
            hideLoader();

            if (res.data?.status === 'success') {
                successToast('Sub-Category created successfully');
                closeSubCategoryModal();
                await loadFilterOptions();
                if (catId) onCategorySelectedForSubCategory(catId);
                const newSubId = res.data.subCategory?.id;
                if (newSubId) {
                    selectModalDropdownOption('createSubCategoryDropdown', 'ProductSubCategoryID', newSubId, name);
                }
            } else {
                errorToast(res.data?.message || 'Failed to create sub-category');
            }
        } catch (err) {
            hideLoader();
            console.error(err);
            errorToast('Failed to save sub-category');
        }
    }

    // ==========================================
    // CAMERA SCANNER IMPLEMENTATION
    // ==========================================
    let productCreateHtml5QrCode = null;

    function openProductCreateCameraScanner() {
        const modalEl = document.getElementById('productCreateCameraScanModal');
        const modalObj = new bootstrap.Modal(modalEl);
        modalObj.show();
        setTimeout(() => {
            modalEl.style.zIndex = "999999";
            startProductCreateCameraScanner();
        }, 300);
    }

    function startProductCreateCameraScanner() {
        const statusEl = document.getElementById("productCreateCameraScannerStatus");
        if (statusEl) {
            statusEl.className = "alert alert-info py-2 small mb-3";
            statusEl.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-1"></i> Starting camera... Bring barcode in front of camera.';
        }

        if (!productCreateHtml5QrCode) {
            productCreateHtml5QrCode = new Html5Qrcode("product-create-reader");
        }

        const config = { fps: 15, qrbox: { width: 260, height: 180 } };
        productCreateHtml5QrCode.start(
            { facingMode: "environment" },
            config,
            (decodedText) => {
                if (decodedText) {
                    $('#productCreateLastScannedText').text(`Scanned Code: ${decodedText}`);
                    addBarcode(decodedText);
                    successToast(`Barcode added: ${decodedText}`);
                    stopProductCreateCameraScanner();
                }
            },
            (err) => {}
        ).catch(err => {
            if (statusEl) {
                statusEl.className = "alert alert-danger py-2 small mb-3";
                statusEl.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> Unable to access camera. Please enter barcode manually.';
            }
        });
    }

    function stopProductCreateCameraScanner() {
        if (productCreateHtml5QrCode && productCreateHtml5QrCode.isScanning) {
            productCreateHtml5QrCode.stop().then(() => {
                $('#productCreateCameraScanModal').modal('hide');
            }).catch(() => {
                $('#productCreateCameraScanModal').modal('hide');
            });
        } else {
            $('#productCreateCameraScanModal').modal('hide');
        }
    }
</script>

@endsection
