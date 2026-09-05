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
            <label for="product-id">Start BarCode:</label>
            <input type="text" id="StartBarCode" placeholder="Start BarCode" />
          </div>
          <div class="src-group">
            <label for="product-id">End BarCode:</label>
            <input type="text" id="EndBarCode" placeholder="End BarCode" />
          </div>

          <div class="form-group mt-3">
            <button class="btn-generate" id="generateBtn">Generate</button>
            <button class="btn-reset" onclick="resetBarcodes()">Reset</button>
          </div>
        </section>
        <section class="barcode-preview">
          <div class="barcode-print-wrapper">
            <button onclick="printBarCard()" class="btn-print">
              Print A4
            </button>
            <div class="grid-container" id="barcodeGrid">
              <!-- Dynamic barcode items will be appended here -->
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
    // If no prefix, assume 'G' and the provided number is the start
    startPrefix = ''; // Default to no prefix if the user just enters a number
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
    // If no prefix, assume 'G' and the provided number is the end
    endPrefix = ''; // Default to no prefix if the user just enters a number
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
    const barcode = `${startPrefix ? startPrefix + '-' : ''}${i}`; // Keep the format like K-1, A-2, etc.
    const barcodeCard = `
      <div class="grid-item">
        <div class="barcode-card-item">
          <!-- Display the dynamically generated barcode image -->
          <div class="barcode-image">
            <svg id="barcode-${barcode}"></svg> <!-- Placeholder for barcode image -->
          </div>
          <!-- Display the barcode number -->
          <div class="details">
          </div>
        </div>
      </div>
    `;
    barcodeGrid.innerHTML += barcodeCard;

    // Generate the barcode using JsBarcode and append it to the SVG element
    JsBarcode(`#barcode-${barcode}`, barcode, {
      format: "CODE128", // Set barcode format (CODE128 is commonly used)
      displayValue: true, // Show the barcode value under the barcode
      width: 2, // Width of barcode bars
      height: 40, // Height of the barcode
      margin: 10 // Margin around the barcode
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
