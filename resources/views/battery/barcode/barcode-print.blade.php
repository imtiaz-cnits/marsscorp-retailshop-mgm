@extends('layouts.dashboard-sidenav')
@section('title', 'Battery Barcode Generate & Print - MARSS CORPORATION')
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
    .unified-ui-border {
        border: 1.5px solid #cbd5e1 !important;
    }
    body[light-mode="dark"] .unified-ui-border,
    body[data-layout-mode="dark"] .unified-ui-border,
    html.dark .unified-ui-border {
        border-color: #334155 !important;
    }
    .barcode-form-control {
        height: 38px !important;
        padding-left: 14px !important;
        padding-right: 14px !important;
        border-radius: 10px !important;
        font-size: 13.5px !important;
    }
    .barcode-grid-box {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 16px;
    }
    .barcode-grid-box .grid-item {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        padding: 12px !important;
        text-align: center !important;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04) !important;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .barcode-grid-box .barcode-image svg {
        max-width: 100%;
        height: auto;
    }
    @media print {
        @page {
            size: A4;
            margin: 10mm;
        }
        body * {
            visibility: hidden !important;
        }
        #barcodeGrid, #barcodeGrid * {
            visibility: visible !important;
        }
        #barcodeGrid {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 12px !important;
            padding: 0 !important;
            margin: 0 !important;
            background: transparent !important;
            border: none !important;
        }
        .grid-item {
            border: 1px dashed #94a3b8 !important;
            box-shadow: none !important;
            page-break-inside: avoid;
        }
    }
</style>

<div class="main-content">
    <div class="page-content min-h-[calc(100vh-70px)] flex flex-col justify-between">
        <div class="barcode-main-area">
            <div class="card bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body product-card-body p-4 sm:p-6 md:p-10">
                    
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-3 border-b border-slate-200 dark:border-slate-800">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                                <i class="fa-solid fa-barcode text-base"></i>
                            </div>
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0 p-0">Battery Barcode Generator</h1>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-0">Generate and print professional barcode labels for battery inventory</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('battery.products') }}" class="inline-flex items-center gap-1.5 px-3.5 h-[38px] min-h-[38px] max-h-[38px] bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-200 text-xs font-semibold rounded-xl border border-slate-300 dark:border-slate-700 transition-all">
                                <i class="fa-solid fa-arrow-left text-xs"></i>
                                <span>Back to Products</span>
                            </a>
                        </div>
                    </div>

                    <!-- Search Product or Sequential Generator Mode Tabs -->
                    <div class="mb-4">
                        <div class="flex gap-2 border-b border-slate-200 dark:border-slate-800 pb-2">
                            <button type="button" onclick="switchMode('product')" id="tabProduct" class="px-4 py-2 text-sm font-bold text-emerald-700 border-b-2 border-emerald-700 transition-colors">Product Barcode Label</button>
                            <button type="button" onclick="switchMode('sequence')" id="tabSequence" class="px-4 py-2 text-sm font-semibold text-slate-500 hover:text-slate-800 border-b-2 border-transparent transition-colors">Sequential Barcodes</button>
                        </div>
                    </div>

                    <!-- MODE 1: PRODUCT BARCODE -->
                    <div id="productBarcodeSection" class="space-y-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Select Battery Product</label>
                                <select id="barcodeProductSelect" onchange="onProductSelect()" class="form-select unified-ui-border rounded-xl text-sm h-[38px] dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                                    <option value="">Choose a battery product...</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Label Quantity</label>
                                <input type="number" id="labelQty" value="6" min="1" max="100" class="form-control unified-ui-border rounded-xl text-sm h-[38px] dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                            </div>
                            <div class="col-md-3 flex items-end">
                                <button type="button" onclick="generateProductLabels()" class="w-full h-[38px] min-h-[38px] max-h-[38px] rounded-xl font-semibold bg-[#15803d] hover:bg-[#166534] text-white border-0 flex items-center justify-center gap-2 shadow-sm transition-all duration-150 active:scale-[0.98]">
                                    <i class="fa-solid fa-wand-magic-sparkles text-xs"></i> <span>Generate Labels</span>
                                </button>
                            </div>
                        </div>

                        <!-- Product Quick Info Box -->
                        <div id="productInfoBox" class="p-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-200 dark:border-slate-700 text-xs hidden">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-slate-400">Selected:</span>
                                    <strong id="infoProdName" class="text-slate-800 dark:text-white ml-1"></strong>
                                </div>
                                <div>
                                    <span class="text-slate-400">Barcode:</span>
                                    <span id="infoProdCode" class="font-mono font-bold text-emerald-600 ml-1"></span>
                                </div>
                                <div>
                                    <span class="text-slate-400">Price:</span>
                                    <strong id="infoProdPrice" class="text-slate-800 dark:text-white ml-1"></strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MODE 2: SEQUENTIAL BARCODE -->
                    <div id="sequenceBarcodeSection" class="space-y-4 hidden">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">Start Barcode (e.g. BAT-1001)</label>
                                <input type="text" id="StartBarCode" placeholder="BAT-1001" class="form-control unified-ui-border rounded-xl text-sm h-[38px] dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">End Barcode (e.g. BAT-1020)</label>
                                <input type="text" id="EndBarCode" placeholder="BAT-1020" class="form-control unified-ui-border rounded-xl text-sm h-[38px] dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                            </div>
                            <div class="col-md-4 flex items-end">
                                <button type="button" onclick="generateSequentialLabels()" class="w-full h-[38px] min-h-[38px] max-h-[38px] rounded-xl font-semibold bg-[#15803d] hover:bg-[#166534] text-white border-0 flex items-center justify-center gap-2 shadow-sm transition-all duration-150 active:scale-[0.98]">
                                    <i class="fa-solid fa-list-ol text-xs"></i> <span>Generate Series</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Bar (Print & Reset) -->
                    <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-200 dark:border-slate-800">
                        <div class="text-xs text-slate-500" id="barcodeCountText">0 Barcodes Generated</div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="clearBarcodes()" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-200 text-xs font-semibold rounded-xl border border-slate-300 dark:border-slate-700 transition-all">Clear</button>
                            <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-4 h-[38px] min-h-[38px] max-h-[38px] bg-[#15803d] hover:bg-[#166534] text-white text-xs font-semibold rounded-xl shadow-sm transition-all duration-150 active:scale-[0.98]">
                                <i class="fa-solid fa-print"></i> <span>Print Barcodes</span>
                            </button>
                        </div>
                    </div>

                    <!-- Barcode Preview Grid Area -->
                    <div class="mt-6">
                        <div class="barcode-grid-box" id="barcodeGrid"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>

<script>
    let batteryProducts = [];

    document.addEventListener("DOMContentLoaded", function() {
        loadBatteryProducts();
    });

    function switchMode(mode) {
        if (mode === 'product') {
            $('#productBarcodeSection').removeClass('hidden');
            $('#sequenceBarcodeSection').addClass('hidden');
            $('#tabProduct').addClass('text-emerald-700 border-emerald-700').removeClass('text-slate-500 border-transparent font-semibold').addClass('font-bold');
            $('#tabSequence').removeClass('text-emerald-700 border-emerald-700 font-bold').addClass('text-slate-500 border-transparent font-semibold');
        } else {
            $('#productBarcodeSection').addClass('hidden');
            $('#sequenceBarcodeSection').removeClass('hidden');
            $('#tabSequence').addClass('text-emerald-700 border-emerald-700 font-bold').removeClass('text-slate-500 border-transparent font-semibold');
            $('#tabProduct').removeClass('text-emerald-700 border-emerald-700 font-bold').addClass('text-slate-500 border-transparent font-semibold');
        }
    }

    async function loadBatteryProducts() {
        try {
            const res = await axios.get('/api/battery/product-list', HeaderToken());
            if (res.data && res.data.status === 'success') {
                batteryProducts = res.data.ProductData || [];
                let opts = '<option value="">Choose a battery product...</option>';
                batteryProducts.forEach(p => {
                    let code = '';
                    if (p.product_code) {
                        try {
                            const parsed = typeof p.product_code === 'string' ? JSON.parse(p.product_code) : p.product_code;
                            code = Array.isArray(parsed) ? parsed[0] : parsed;
                        } catch (e) { code = p.product_code; }
                    }
                    opts += `<option value="${p.id}" data-name="${p.product_name}" data-code="${code || ('BAT-' + p.id)}" data-price="${p.sell_price}">${p.product_name} (${code || 'BAT-' + p.id})</option>`;
                });
                $('#barcodeProductSelect').html(opts);
            }
        } catch (e) {
            console.error(e);
        }
    }

    function onProductSelect() {
        const opt = $('#barcodeProductSelect option:selected');
        if (!opt.val()) {
            $('#productInfoBox').addClass('hidden');
            return;
        }
        $('#infoProdName').text(opt.data('name'));
        $('#infoProdCode').text(opt.data('code'));
        $('#infoProdPrice').text('৳ ' + parseFloat(opt.data('price') || 0).toLocaleString());
        $('#productInfoBox').removeClass('hidden');
    }

    function generateProductLabels() {
        const opt = $('#barcodeProductSelect option:selected');
        if (!opt.val()) {
            errorToast('Please select a battery product');
            return;
        }
        const qty = parseInt($('#labelQty').val()) || 6;
        const name = opt.data('name');
        const code = String(opt.data('code'));
        const price = parseFloat(opt.data('price') || 0).toLocaleString();

        const grid = document.getElementById('barcodeGrid');
        grid.innerHTML = '';

        for (let i = 0; i < qty; i++) {
            const id = `bc-prod-${i}`;
            grid.innerHTML += `
                <div class="grid-item">
                    <div class="text-[11px] font-bold text-slate-800 line-clamp-1 mb-1">${name}</div>
                    <div class="barcode-image">
                        <svg id="${id}"></svg>
                    </div>
                    <div class="text-xs font-bold text-emerald-700 mt-1">MRP: ৳ ${price}</div>
                </div>
            `;
            setTimeout(() => {
                JsBarcode(`#${id}`, code, {
                    format: "CODE128",
                    displayValue: true,
                    fontSize: 12,
                    height: 38,
                    margin: 6
                });
            }, 10);
        }

        $('#barcodeCountText').text(`${qty} Barcodes Generated`);
    }

    function generateSequentialLabels() {
        const start = $('#StartBarCode').val().trim();
        const end = $('#EndBarCode').val().trim();

        if (!start || !end) {
            errorToast('Please enter both Start and End barcodes');
            return;
        }

        let prefix = '', startNum = 0, endNum = 0;
        if (start.includes('-')) {
            const parts = start.split('-');
            prefix = parts[0] + '-';
            startNum = parseInt(parts[1]);
        } else {
            startNum = parseInt(start);
        }

        if (end.includes('-')) {
            endNum = parseInt(end.split('-')[1]);
        } else {
            endNum = parseInt(end);
        }

        if (isNaN(startNum) || isNaN(endNum) || startNum > endNum) {
            errorToast('Invalid range numbers');
            return;
        }

        const grid = document.getElementById('barcodeGrid');
        grid.innerHTML = '';
        let count = 0;

        for (let num = startNum; num <= endNum; num++) {
            const code = `${prefix}${num}`;
            const id = `bc-seq-${num}`;
            grid.innerHTML += `
                <div class="grid-item">
                    <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">MARSS BATTERY</div>
                    <div class="barcode-image">
                        <svg id="${id}"></svg>
                    </div>
                </div>
            `;
            setTimeout(() => {
                JsBarcode(`#${id}`, code, {
                    format: "CODE128",
                    displayValue: true,
                    fontSize: 12,
                    height: 38,
                    margin: 6
                });
            }, 10);
            count++;
        }

        $('#barcodeCountText').text(`${count} Barcodes Generated`);
    }

    function clearBarcodes() {
        $('#barcodeGrid').empty();
        $('#barcodeCountText').text('0 Barcodes Generated');
    }
</script>

@endsection
