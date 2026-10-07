@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Units - MARSS CORPORATION')
@section('content')

<style>
    .product-card-body {
        padding: 10px !important;
    }
    @media (min-width: 768px) {
        .product-card-body {
            padding: 16px !important;
        }
    }

    .controls-row-wrapper {
        width: 100% !important;
        margin-bottom: 16px;
    }
    .search-input-wrapper {
        padding-left: 14px !important;
        padding-right: 14px !important;
    }

    .unified-ui-border {
        border: 1.5px solid #cbd5e1 !important;
    }

    .search-input-wrapper:focus-within {
        border-color: #15803d !important;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.25) !important;
    }

    body[light-mode="dark"] .unified-ui-border,
    body[data-layout-mode="dark"] .unified-ui-border,
    html.dark .unified-ui-border {
        border-color: #334155 !important;
    }
</style>

<!-- Main Content Start -->
<div class="main-content">
    <div class="page-content min-h-[calc(100vh-70px)] flex flex-col justify-between">
        <div class="data-table flex-grow">
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-10">
                    
                    <!-- 1. Top Section: Page Title -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Battery Unit List</h1>
                        </div>
                    </div>

                    <!-- 2. Controls & Search Row -->
                    <div class="controls-row-wrapper mb-4 w-full">
                        <div class="search-input-wrapper unified-ui-border h-[38px] flex items-center bg-white dark:bg-slate-800/90 rounded-xl shadow-sm transition-all focus-within:border-emerald-600 focus-within:ring-2 focus-within:ring-emerald-600/20">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-400 flex-shrink-0 mr-2.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="searchInput" style="border: none !important; outline: none !important; box-shadow: none !important; width: 100% !important; padding-left: 4px !important; padding-right: 4px !important;" class="w-full h-full bg-transparent border-0 outline-none text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-0 m-0 leading-normal focus:ring-0 focus:border-0 focus:outline-none" placeholder="Search Battery Units..." />
                        </div>
                    </div>

                    <!-- 3. Desktop Table -->
                    <div class="table-responsive unified-ui-border hidden md:block w-full max-w-full overflow-x-auto rounded-2xl shadow-sm bg-white dark:bg-slate-900 mb-4">
                        <table id="printTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#15803d] text-white text-xs font-semibold uppercase tracking-wider">
                                    <th class="p-[10px] text-center w-[50px] rounded-tl-2xl whitespace-nowrap">SL</th>
                                    <th class="p-[10px] text-start whitespace-nowrap">Unit Name</th>
                                    <th class="p-[10px] text-center w-[160px] whitespace-nowrap">Short Code / Symbol</th>
                                    <th class="p-[10px] text-center w-[120px] rounded-tr-2xl whitespace-nowrap">Status</th>
                                </tr>
                            </thead>
                            <tbody id="unitTableBody" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                                <tr>
                                    <td colspan="4" class="text-center py-6 text-slate-400">Loading battery units...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- 4. Mobile Card List View -->
                    <div id="mobileCardList" class="block md:hidden mb-3 space-y-3"></div>

                    <!-- 5. Display Info Footer -->
                    <div class="pt-4 mt-4 border-t border-slate-200 dark:border-slate-800">
                        <div id="unitInfo" class="text-xs text-slate-500 dark:text-slate-400"></div>
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

<script>
    let rawUnits = [];

    document.addEventListener("DOMContentLoaded", function() {
        getBatteryUnits();
        $('#searchInput').on('input', renderUnits);
    });

    async function getBatteryUnits() {
        try {
            if (typeof showLoader === 'function') showLoader();
            const res = await axios.get("/api/battery/unit-list", HeaderToken());
            if (typeof hideLoader === 'function') hideLoader();

            if (res.data && res.data.status === 'success') {
                rawUnits = res.data.units || [];
                renderUnits();
            } else {
                rawUnits = [];
                renderUnits();
            }
        } catch (e) {
            if (typeof hideLoader === 'function') hideLoader();
            console.error(e);
            errorToast("Failed to load battery units");
        }
    }

    function renderUnits() {
        const search = ($('#searchInput').val() || '').toLowerCase().trim();
        const filtered = rawUnits.filter(u => (u.name || '').toLowerCase().includes(search) || (u.code || '').toLowerCase().includes(search));

        const tbody = document.getElementById('unitTableBody');
        const mobileContainer = document.getElementById('mobileCardList');
        tbody.innerHTML = '';
        if (mobileContainer) mobileContainer.innerHTML = '';

        if (filtered.length === 0) {
            tbody.innerHTML = `<tr><td colspan="4" class="text-center py-8 text-slate-400 font-medium">No battery units found.</td></tr>`;
            if (mobileContainer) mobileContainer.innerHTML = `<div class="p-6 text-center text-slate-400 font-medium bg-white dark:bg-slate-800 rounded-xl unified-ui-border">No battery units found.</div>`;
        } else {
            filtered.forEach((u, idx) => {
                const sl = idx + 1;
                const statusBadge = (u.status === 'Active' || !u.status)
                    ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Active</span>'
                    : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300">Inactive</span>';

                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="p-[10px] text-center text-slate-500 font-medium">${sl}</td>
                        <td class="p-[10px] text-start font-semibold text-slate-800 dark:text-slate-100">${u.name}</td>
                        <td class="p-[10px] text-center text-slate-600 dark:text-slate-300 font-mono font-bold">${u.code || u.symbol || 'N/A'}</td>
                        <td class="p-[10px] text-center">${statusBadge}</td>
                    </tr>
                `;

                if (mobileContainer) {
                    mobileContainer.innerHTML += `
                        <div class="unified-ui-border rounded-2xl p-3.5 bg-white dark:bg-slate-800 shadow-sm flex items-center justify-between gap-3">
                            <div>
                                <div class="font-bold text-slate-800 dark:text-slate-100 text-sm">${u.name}</div>
                                <div class="text-xs text-slate-500 font-mono mt-0.5">Code: ${u.code || u.symbol || 'N/A'}</div>
                            </div>
                            <div>${statusBadge}</div>
                        </div>
                    `;
                }
            });
        }

        document.getElementById('unitInfo').innerHTML = filtered.length > 0
            ? `Showing <strong class="text-slate-700 dark:text-slate-200">${filtered.length}</strong> unit entries`
            : `Showing 0 entries`;
    }
</script>

@endsection
