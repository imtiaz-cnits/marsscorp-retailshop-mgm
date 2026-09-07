@extends('layouts.dashboard-sidenav')
@section('title', 'BarCode Print Page')
@section('content')

<style>
    /* Full Height & Sticky Footer */
    html, body {
        min-height: 100vh !important;
    }
    .main-content {
        min-height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
    }
    .barcode-page-content {
        min-height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
        flex-grow: 1 !important;
        /* Same gap top, left, right, bottom */
        padding: calc(70px + 16px) 16px 16px 16px !important;
        box-sizing: border-box !important;
    }
    @media (min-width: 768px) {
        .barcode-page-content {
            padding: calc(70px + 20px) 20px 20px 20px !important;
        }
    }
    .barcode-main-area {
        flex-grow: 1 !important;
        width: 100% !important;
    }
    .barcode-copyright {
        margin-top: auto !important;
        width: 100% !important;
        padding-top: 16px !important;
    }

    /* Input Field Styling with Generous Left-Right Padding */
    .barcode-form-control {
        height: 38px !important;
        padding-left: 16px !important;
        padding-right: 16px !important;
        border-radius: 10px !important;
        font-size: 13.5px !important;
        font-weight: 500 !important;
    }

    /* Buttons Standard: Height 38px */
    .btn-action-generate {
        height: 38px !important;
        min-height: 38px !important;
        max-height: 38px !important;
        padding: 0 20px !important;
        border-radius: 10px !important;
        font-size: 13.5px !important;
        font-weight: 600 !important;
        background-color: #15803d !important;
        color: #ffffff !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 7px !important;
        border: none !important;
        cursor: pointer !important;
        transition: all 0.15s ease !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
    }
    .btn-action-generate:hover:not(:disabled) {
        background-color: #166534 !important;
        color: #ffffff !important;
        transform: translateY(-1px);
    }
    .btn-action-generate:active:not(:disabled) {
        transform: scale(0.98);
    }

    .btn-action-reset {
        height: 38px !important;
        min-height: 38px !important;
        max-height: 38px !important;
        padding: 0 20px !important;
        border-radius: 10px !important;
        font-size: 13.5px !important;
        font-weight: 600 !important;
        background-color: #dc2626 !important;
        color: #ffffff !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 7px !important;
        border: none !important;
        cursor: pointer !important;
        transition: all 0.15s ease !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
    }
    .btn-action-reset:hover {
        background-color: #b91c1c !important;
        color: #ffffff !important;
        transform: translateY(-1px);
    }
    .btn-action-reset:active {
        transform: scale(0.98);
    }

    .btn-action-print {
        height: 38px !important;
        min-height: 38px !important;
        max-height: 38px !important;
        padding: 0 18px !important;
        border-radius: 10px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        background-color: #15803d !important;
        color: #ffffff !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 7px !important;
        border: none !important;
        cursor: pointer !important;
        transition: all 0.15s ease !important;
    }
    .btn-action-print:hover {
        background-color: #166534 !important;
        color: #ffffff !important;
    }

    /* Dark Mode Styling */
    body[light-mode="dark"] .barcode-card-container,
    html[light-mode="dark"] .barcode-card-container,
    body[data-layout-mode="dark"] .barcode-card-container,
    html.dark .barcode-card-container,
    body.dark .barcode-card-container,
    body.dark-mode .barcode-card-container {
        background-color: #0f172a !important;
        border-color: #1e293b !important;
    }

    body[light-mode="dark"] .barcode-form-control,
    html[light-mode="dark"] .barcode-form-control,
    body[data-layout-mode="dark"] .barcode-form-control,
    html.dark .barcode-form-control,
    body.dark .barcode-form-control,
    body.dark-mode .barcode-form-control {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] .barcode-form-control:focus,
    html[light-mode="dark"] .barcode-form-control:focus,
    body[data-layout-mode="dark"] .barcode-form-control:focus,
    html.dark .barcode-form-control:focus,
    body.dark .barcode-form-control:focus,
    body.dark-mode .barcode-form-control:focus {
        background-color: #1e293b !important;
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25) !important;
        color: #ffffff !important;
    }

    body[light-mode="dark"] .barcode-form-control::placeholder,
    html[light-mode="dark"] .barcode-form-control::placeholder,
    body[data-layout-mode="dark"] .barcode-form-control::placeholder,
    html.dark .barcode-form-control::placeholder,
    body.dark .barcode-form-control::placeholder,
    body.dark-mode .barcode-form-control::placeholder {
        color: #94a3b8 !important;
    }

    /* Grid Items for Barcodes */
    .barcode-grid-box {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 16px;
    }

    .barcode-grid-box .grid-item {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        padding: 14px !important;
        text-align: center !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04) !important;
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
            margin: 15mm;
        }

        body * {
            visibility: hidden;
        }

        #barcodeGrid, #barcodeGrid * {
            visibility: visible;
        }

        #barcodeGrid {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 15px !important;
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
    <div class="page-content barcode-page-content">
        <!-- Main Form & Content Area -->
        <div class="barcode-main-area">
            <div class="card barcode-card-container bg-white dark:bg-slate-900 rounded-2xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden mb-4 transition-colors">
                <div class="card-body p-4 sm:p-6 md:p-8">
                    
                    <!-- Header -->
                    <div class="flex items-center gap-3 mb-4 pb-3 border-b border-slate-200 dark:border-slate-800">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-slate-800 shadow-sm flex-shrink-0">
                            <i class="fa-solid fa-barcode text-base"></i>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-white tracking-tight leading-none m-0">Barcode Generate</h1>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-0">Generate sequential barcodes and print on standard A4 format</p>
                        </div>
                    </div>

                    <!-- Input Fields Form -->
                    <div class="space-y-3 mb-3">
                        <div>
                            <label for="StartBarCode" class="block text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">
                                Start BarCode <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="StartBarCode" placeholder="e.g. K-1 or 1" class="barcode-form-control w-full border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white focus:outline-none focus:border-emerald-600 dark:focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all" />
                        </div>
                        <div>
                            <label for="EndBarCode" class="block text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">
                                End BarCode <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="EndBarCode" placeholder="e.g. K-100 or 100" class="barcode-form-control w-full border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white focus:outline-none focus:border-emerald-600 dark:focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all" />
                        </div>
                    </div>

                    <!-- Actions Buttons: Tighter gap, height 38px -->
                    <div class="flex items-center gap-2 mb-4">
                        <button id="generateBtn" type="button" class="btn-action-generate">
                            <i class="fa-solid fa-wand-magic-sparkles text-xs"></i>
                            <span>Generate</span>
                        </button>
                        <button onclick="resetBarcodes()" type="button" class="btn-action-reset">
                            <i class="fa-solid fa-rotate-left text-xs"></i>
                            <span>Reset</span>
                        </button>
                    </div>

                    <!-- Preview Section: Tight top spacing -->
                    <div class="border-t border-slate-200 dark:border-slate-800 pt-3">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                            <div>
                                <h3 class="text-base font-bold text-slate-800 dark:text-white m-0">Barcode Preview</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 mb-0">Review generated barcodes below</p>
                            </div>
                            <button onclick="printBarCard()" type="button" class="btn-action-print">
                                <i class="fa-solid fa-print text-xs"></i>
                                <span>Print A4</span>
                            </button>
                        </div>

                        <!-- Barcode Grid Container -->
                        <div class="grid-container barcode-grid-box min-h-[140px] p-4 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 bg-slate-50/60 dark:bg-slate-950/40" id="barcodeGrid">
                            <!-- Dynamic barcode items will be appended here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Bottom Copyright Footer -->
        <div class="copyright barcode-copyright">
            <footer class="footer text-center py-3 text-slate-500 dark:text-slate-400 text-xs border-t border-slate-200 dark:border-slate-800">
                &copy; {{ date('Y') }} <span class="font-semibold text-slate-700 dark:text-slate-300">MARSS CORPORATION</span> | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-emerald-600 dark:text-emerald-400 font-bold hover:underline">CodeNext IT</a>
            </footer>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>

<script>
    document.getElementById('generateBtn').addEventListener('click', function() {
        // Get the start and end barcode values
        const startBarcode = document.getElementById('StartBarCode').value.trim();
        const endBarcode = document.getElementById('EndBarCode').value.trim();

        if (!startBarcode || !endBarcode) {
            alert('Please enter both start and end barcode values.');
            return;
        }

        // Initialize the prefix and number for the start barcode
        let startPrefix = '';
        let startNumber = 0;

        // If a prefix is provided (e.g., K-1), split it by '-'
        if (startBarcode.includes('-')) {
            const startParts = startBarcode.split('-');
            startPrefix = startParts[0]; // Get the prefix (e.g., 'K')
            startNumber = parseInt(startParts[1]); // Get the numeric part (e.g., '1')
        } else {
            // If no prefix, assume default number
            startPrefix = '';
            startNumber = parseInt(startBarcode);
        }

        // Do the same for the end barcode
        let endPrefix = '';
        let endNumber = 0;

        if (endBarcode.includes('-')) {
            const endParts = endBarcode.split('-');
            endPrefix = endParts[0]; // Get the prefix (e.g., 'K')
            endNumber = parseInt(endParts[1]); // Get the numeric part (e.g., '100')
        } else {
            endPrefix = '';
            endNumber = parseInt(endBarcode);
        }

        // Validate the numeric part
        if (isNaN(startNumber) || isNaN(endNumber)) {
            alert('Invalid barcode number. Please enter a valid number.');
            return;
        }

        // If the prefixes are different, show an alert
        if (startPrefix !== endPrefix && startPrefix !== '' && endPrefix !== '') {
            alert('The barcode prefix should be the same for both start and end.');
            return;
        }

        // If start number is greater than end number, show an alert
        if (startNumber > endNumber) {
            alert('Start barcode must be less than or equal to the end barcode.');
            return;
        }

        const barcodeGrid = document.getElementById('barcodeGrid');
        barcodeGrid.innerHTML = ''; // Clear previous barcodes

        // Generate barcodes in a loop
        for (let i = startNumber; i <= endNumber; i++) {
            const barcode = `${startPrefix ? startPrefix + '-' : ''}${i}`; // Keep format like K-1, A-2, etc.
            const barcodeCard = `
                <div class="grid-item">
                    <div class="barcode-card-item">
                        <!-- Display the dynamically generated barcode image -->
                        <div class="barcode-image">
                            <svg id="barcode-${barcode}"></svg>
                        </div>
                        <div class="details"></div>
                    </div>
                </div>
            `;
            barcodeGrid.innerHTML += barcodeCard;

            // Generate the barcode using JsBarcode
            JsBarcode(`#barcode-${barcode}`, barcode, {
                format: "CODE128",
                displayValue: true,
                width: 2,
                height: 40,
                margin: 10
            });
        }
    });

    // Reset the barcode generation
    function resetBarcodes() {
        document.getElementById('StartBarCode').value = '';
        document.getElementById('EndBarCode').value = '';
        document.getElementById('barcodeGrid').innerHTML = ''; // Clear generated barcodes
    }

    function printBarCard() {
        window.print(); // Trigger the print functionality for the page
    }
</script>

@endsection
