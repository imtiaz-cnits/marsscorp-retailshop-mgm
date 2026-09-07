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

    body[light-mode="dark"] .barcode-table th,
    html[light-mode="dark"] .barcode-table th {
        background-color: #1e293b !important;
        color: #f1f5f9 !important;
        border-color: #334155 !important;
    }

    body[light-mode="dark"] .barcode-table td,
    html[light-mode="dark"] .barcode-table td {
        background-color: #0f172a !important;
        color: #f1f5f9 !important;
        border-color: #334155 !important;
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

    .barcode-grid-box .barcode-image img {
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
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-0">Search product and generate barcodes to print on standard A4 format</p>
                        </div>
                    </div>

                    <!-- Search Product Input -->
                    <div class="mb-3">
                        <label for="ProducSearch" class="block text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">
                            Add Product <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="ProducSearch" placeholder="Search Product by name or code..." class="barcode-form-control w-full border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white focus:outline-none focus:border-emerald-600 dark:focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all" />
                    </div>

                    <!-- Product Table -->
                    <div class="table-responsive rounded-xl border border-slate-200 dark:border-slate-800 mb-3 overflow-hidden">
                        <table class="barcode-table w-full text-sm text-left">
                            <thead class="bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-bold uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-2.5 border-b border-slate-200 dark:border-slate-800">Product Name With Code</th>
                                    <th class="px-4 py-2.5 border-b border-slate-200 dark:border-slate-800 text-center">Available</th>
                                    <th class="px-4 py-2.5 border-b border-slate-200 dark:border-slate-800 text-center">Quantity</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                                <tr class="bg-white dark:bg-slate-900">
                                    <td class="px-4 py-2.5 font-semibold text-slate-800 dark:text-white"><span id="ProductName">-</span></td>
                                    <td class="px-4 py-2.5 text-center text-slate-600 dark:text-slate-300"><span id="ProductQuantity">-</span></td>
                                    <td class="px-4 py-2.5 text-center">
                                        <div class="inline-flex items-center gap-1">
                                            <button type="button" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold flex items-center justify-center transition-colors" onclick="decrease()">-</button>
                                            <input type="number" id="ProductGenarateQuantity" value="0" min="0" max="1000" disabled class="w-16 h-8 text-center rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white text-sm font-semibold focus:outline-none" />
                                            <button type="button" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold flex items-center justify-center transition-colors" onclick="increase()">+</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Fields Checkboxes -->
                    <div class="mb-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/60">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Display Fields:</label>
                        <div class="flex flex-wrap items-center gap-4 sm:gap-6">
                            <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                                <input type="checkbox" id="productNameCheckbox" checked class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 dark:bg-slate-700 dark:border-slate-600"> Product Name
                            </label>
                            <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                                <input type="checkbox" id="productCodeCheckbox" checked class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 dark:bg-slate-700 dark:border-slate-600"> Product Code
                            </label>
                            <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                                <input type="checkbox" id="productPriceCheckbox" checked class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 dark:bg-slate-700 dark:border-slate-600"> Product Price
                            </label>
                            <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                                <input type="checkbox" id="barcodeCheckbox" checked class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 dark:bg-slate-700 dark:border-slate-600"> Barcode
                            </label>
                        </div>
                    </div>

                    <!-- Actions Buttons: Exactly 38px height with proper padding and tight vertical margin -->
                    <div class="flex items-center gap-2 mb-4">
                        <button id="generateBtn" type="button" disabled class="btn-action-generate">
                            <i class="fa-solid fa-wand-magic-sparkles text-xs"></i>
                            <span>Generate</span>
                        </button>
                        <button class="btn-reset btn-action-reset" type="button">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function decrease() {
        const input = document.getElementById('ProductGenarateQuantity');
        let val = parseInt(input.value) || 0;
        if (val > 0) input.value = val - 1;
    }
    function increase() {
        const input = document.getElementById('ProductGenarateQuantity');
        let val = parseInt(input.value) || 0;
        input.value = val + 1;
    }

    $(document).ready(function() {
        let product = {}; // Store product data globally
        const barcodeBasePath = "{{ asset('backend/assets/img/product-barcode.png') }}";

        // Fetch product data on input change
        $('#ProducSearch').on('input', function() {
            const productId = $(this).val();

            if (!productId.trim()) {
                clearFields();
                return;
            }

            // Trigger AJAX request to fetch product data
            $.ajax({
                url: '/api/product-search',
                method: 'GET',
                data: {
                    product_id: productId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                success: function(response) {
                    if (response.status === 'success') {
                        product = response.product; // Store product data

                        // Update input fields with fetched product data
                        $('#ProductName').text(product.product_name);
                        $('#ProductQuantity').text(product.quantity);

                        // Enable the Generate Product Quantity input field and button
                        $('#ProductGenarateQuantity').prop('disabled', false);
                        $('#generateBtn').prop('disabled', false);
                    } else {
                        console.error(response.message);
                        clearFields();
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Clear fields
        function clearFields() {
            $('#ProductName').text('-');
            $('#ProductQuantity').text('-');
            $('#ProductGenarateQuantity').val(0).prop('disabled', true);
            $('#generateBtn').prop('disabled', true);
        }

        $('.btn-reset').on('click', function() {
            clearFields();
            $('#ProducSearch').val('');
            $('#barcodeGrid').empty();
        });

        // Handle barcode generation
        $('#generateBtn').on('click', function() {
            const quantity = parseInt($('#ProductGenarateQuantity').val(), 10);
            if (isNaN(quantity) || quantity <= 0) {
                alert('Please enter a valid quantity!');
                return;
            }

            const productName = product.product_name || '';
            const productCode = product.product_code ? JSON.parse(product.product_code)[0] : '';
            const productPrice = product.sell_price || 0;

            // Clear previous barcode previews
            $('#barcodeGrid').empty();

            for (let i = 0; i < quantity; i++) {
                const card = `
                    <div class="grid-item">
                        <div class="barcode-card-item w-full">
                            <div class="product-wrap mb-1">
                                ${$('#productNameCheckbox').prop('checked') ? `<p class="product-name text-xs font-bold text-slate-800 m-0">${productName}</p>` : ''}
                                ${$('#productPriceCheckbox').prop('checked') ? `<p class="price text-xs font-semibold text-slate-600 m-0">Tk ${productPrice}</p>` : ''}
                            </div>
                            <div class="details flex flex-col items-center">
                                <div class="barcode-image my-1">
                                    ${$('#barcodeCheckbox').prop('checked') ? `<img src="${barcodeBasePath}?data=${productCode}" alt="Barcode" class="mx-auto" />` : ''}
                                </div>
                                ${$('#productCodeCheckbox').prop('checked') ? `<p class="barcode-number text-xs font-mono font-bold text-slate-700 m-0">${productCode}</p>` : ''}
                            </div>
                        </div>
                    </div>
                `;

                $('#barcodeGrid').append(card);
            }
        });
    });

    function printBarCard() {
        window.print();
    }
</script>

@endsection
