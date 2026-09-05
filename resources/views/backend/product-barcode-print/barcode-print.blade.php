@extends('layouts.dashboard-sidenav')
@section('title', 'BarCode Print Page')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <!-- Barcode Start -->
            <div class="barcode-print-wrapper">
                <header class="header">
                    <h2 class="title">Barcode Generate</h2>
                </header>
                <section class="main-form">
                    <div class="src-group">
                        <label for="product-id">Add Product:</label>
                        <input type="text" id="ProducSearch" placeholder="Search Product" />
                    </div>

                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product Name With Code</th>
                                    <th>Available</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span id="ProductName"></span></td>
                                    <td><span id="ProductQuantity"></span></td>
                                    <td>
                                        <div class="custom-number-input">
                                            <button class="decrement" onclick="decrease()">-
                                            </button>
                                            <input type="number" id="ProductGenarateQuantity" value="0" min="0"
                                                max="1000" />
                                            <button class="increment" onclick="increase()">+
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <label class="fields" for="fields">Fields:</label>
                        <div class="checkbox-group">
                            <label><input type="checkbox" id="productNameCheckbox" checked> Product Name</label>
                            <label><input type="checkbox" id="productCodeCheckbox" checked> Product Code</label>
                            <label><input type="checkbox" id="productPriceCheckbox" checked> Product Price</label>
                            <label><input type="checkbox" id="barcodeCheckbox" checked> Barcode</label>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button class="btn-generate" id="generateBtn">Generate</button>
                        <button class="btn-reset">Reset</button>
                    </div>
                </section>
                <section class="barcode-preview">
                    <div class="barcode-print-wrapper">
                        <button onclick="printBarCard()" class="btn-print">
                            Print A4
                        </button>
                        <div class="grid-container" id="barcodeGrid">

                        </div>
                    </div>
                </section>
            </div>
            <!-- Barcode End -->
            <div class="copyright">
                <footer class="footer text-center py-3 mt-4 text-muted small border-top">&copy; 2026 মার্স কর্পোরেশন (MARSS CORPORATION) | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-success fw-bold text-decoration-none">CodeNext IT</a></footer>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            let product = {}; // Store product data globally
            const barcodeBasePath = "{{ asset('backend/assets/img/product-barcode.png') }}";

            // Fetch product data on input change
            $('#ProducSearch').on('input', function() {
                const productId = $(this).val(); // Get the product name or code from the input field

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
                $('#ProductName').text('');
                $('#ProductQuantity').text('');
                $('#ProductGenarateQuantity').val(0).prop('disabled', true);
                $('#generateBtn').prop('disabled', true);
            }

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
                  <div class="barcode-card-item">
                    <div class="product-wrap">
                     ${$('#productNameCheckbox').prop('checked') ? `<p class="product-name">${productName}</p>` : ''}
                            ${$('#productPriceCheckbox').prop('checked') ? `<p class="price">${productPrice}</p>` : ''}

                    </div>
                    <div class="details">
                      <div class="barcode-image">
                              ${$('#barcodeCheckbox').prop('checked') ? `<img src="${barcodeBasePath}?data=${productCode}"  alt="Barcode" />` : ''}

                      </div>
                         ${$('#productCodeCheckbox').prop('checked') ? `<p class="barcode-number">${productCode}</p>` : ''}

                    </div>
                  </div>
                </div>

                    `;

                    $('#barcodeGrid').append(card);
                }
            });
        });
    </script>

@endsection
