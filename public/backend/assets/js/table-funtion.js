// .............Table action three dot toggle Start................ //

document.addEventListener("DOMContentLoaded", function () {
    let currentOpenMenu = null; // Track the currently open menu

    // Function to close a specific menu
    function closeMenu(menuWrap) {
      const toggler = menuWrap.querySelector(".toggler");
      if (toggler) {
        toggler.checked = false; // Uncheck the checkbox
      }
    }

    // Function to initialize dropdown behavior for a specific menu
    function initDropdown(menuWrap) {
      const toggler = menuWrap.querySelector(".toggler");
      const links = menuWrap.querySelectorAll(".link"); // Select all dropdown links

      // Event listener to detect clicks outside the menu
      document.addEventListener("click", function (event) {
        if (!menuWrap.contains(event.target) && currentOpenMenu !== menuWrap) {
          if (currentOpenMenu) {
            closeMenu(currentOpenMenu);
          }
        }
      });

      // Prevent closing the menu if the menu itself is clicked
      menuWrap.addEventListener("click", function (event) {
        event.stopPropagation();
      });

      // Close menu when clicking on a dropdown link
      links.forEach((link) => {
        link.addEventListener("click", function () {
          closeMenu(menuWrap);
          currentOpenMenu = null; // Reset the current open menu
        });
      });

      // Toggle menu open/close
      toggler.addEventListener("change", function () {
        if (toggler.checked) {
          if (currentOpenMenu && currentOpenMenu !== menuWrap) {
            closeMenu(currentOpenMenu);
          }
          currentOpenMenu = menuWrap;
        } else {
          if (currentOpenMenu === menuWrap) {
            currentOpenMenu = null;
          }
        }
      });
    }

    // Initialize all dropdowns
    const allMenus = document.querySelectorAll("#menu-wrap");
    allMenus.forEach(initDropdown);
  });

  // .............Table action three dot toggle End................ //

  // ..............Table searchbar filter Start.......................//
  document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector("#searchInput");
    if (searchInput) {
      searchInput.addEventListener("input", function () {
        const filter = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll("#printTable tbody tr");

        rows.forEach((row) => {
          const cells = row.querySelectorAll("td");
          let isMatch = false;

          cells.forEach((cell) => {
            if (cell.textContent.toLowerCase().includes(filter)) {
              isMatch = true;
            }
          });

          row.style.display = isMatch ? "" : "none";
        });

        // Update table and pagination after filtering
        if (typeof updateTable === "function") updateTable();
        if (typeof updatePagination === "function") updatePagination();
      });
    }
  });
  // ..............Table searchbar filter End.......................//

  // .............Table copy,csv,pdf,xlse,print all file Start...............//

  $(document).ready(function () {
    // Copy table to clipboard
    $("#copyBtn").click(function () {
      const range = document.createRange();
      range.selectNode(document.querySelector("table"));
      window.getSelection().removeAllRanges();
      window.getSelection().addRange(range);
      document.execCommand("copy");
      window.getSelection().removeAllRanges();
      alert("Table copied to clipboard!");
    });

    // Export table to CSV
    $("#csvBtn").click(function () {
      let csv = [];
      const rows = document.querySelectorAll("table tr");

      rows.forEach((row) => {
        const cols = row.querySelectorAll("td, th");
        let rowData = [];
        cols.forEach((col) => rowData.push(col.innerText));
        csv.push(rowData.join(","));
      });

      const csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
      const downloadLink = document.createElement("a");
      downloadLink.download = "data.csv";
      downloadLink.href = window.URL.createObjectURL(csvFile);
      downloadLink.click();
    });

    // Export table to PDF
    $("#pdfBtn").click(function () {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();

      // Add the table content to the PDF
      doc.autoTable({
        html: "table",
        startY: 10,
      });

      // Save the PDF
      doc.save("data.pdf");
    });

    // Export table to XLSX
    $("#xlsxBtn").click(function () {
      const wb = XLSX.utils.table_to_book(document.querySelector("table"));
      XLSX.writeFile(wb, "data.xlsx");
    });

    // Print table
    $("#printBtn").click(function () {
      window.print();
    });
  });
  // .............Table copy,csv,pdf,xlse,print all file End...............//

  // ...............Filter Dropdown functionality Start...................//


  // ...............Filter Dropdown Daynamic functionality Start...................//

  document.addEventListener("DOMContentLoaded", function () {
    const filterLinks = document.querySelectorAll(".dropdown-menus a");
    const tableRows = document.querySelectorAll("#printTable tbody tr");
    const displayInfo = document.getElementById("display-info");

    function updateTable() {
      let visibleCount = 0;

      tableRows.forEach((row) => {
        if (row.style.display !== "none") {
          visibleCount++;
        }
      });

      // Update the display-info span with the count of visible entries
      displayInfo.textContent = `Showing ${visibleCount} entries`;
    }

    filterLinks.forEach((link) => {
      link.addEventListener("click", function (event) {
        event.preventDefault();
        const filterValue = this.getAttribute("data-filter");

        tableRows.forEach((row) => {
          const rowDate = new Date(row.getAttribute("data-date"));
          const today = new Date();
          let shouldShow = true;

          switch (filterValue) {
            case "all":
              shouldShow = true;
              break;
            case "today":
              shouldShow = rowDate.toDateString() === today.toDateString();
              break;
            case "7":
              shouldShow = (today - rowDate) / (1000 * 60 * 60 * 24) <= 7;
              break;
            case "30":
              shouldShow = (today - rowDate) / (1000 * 60 * 60 * 24) <= 30;
              break;
            case "365":
              shouldShow = (today - rowDate) / (1000 * 60 * 60 * 24) <= 365;
              break;
            default:
              shouldShow = true;
          }

          row.style.display = shouldShow ? "" : "none";
        });

        updateTable(); // Update the table view based on new filter
      });
    });

    updateTable(); // Initial call to set the correct count on page load
  });

  // ...............Filter Dropdown functionality End...................//

  // ................ Entries and Pagination Start.....................//
  document.addEventListener("DOMContentLoaded", () => {
    const table = document.querySelector("#printTable");
    const entriesSelect = document.querySelector("#entries");
    const displayInfo = document.querySelector("#display-info");
    const paginationContainer = document.querySelector("#pagination");

    let currentPage = 1;
    let entriesPerPage = parseInt(entriesSelect.value) || 5;
    let totalEntries = table.querySelectorAll("tbody tr").length;
    const pageLinksToShow = 3;

    function updateTable() {
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach((row, index) => {
            if (entriesPerPage === totalEntries) {
                row.style.display = "";
            } else {
                row.style.display =
                    index >= (currentPage - 1) * entriesPerPage &&
                    index < currentPage * entriesPerPage
                        ? ""
                        : "none";
            }
        });

        let showingCount = entriesPerPage === totalEntries
            ? totalEntries
            : Math.min(entriesPerPage * currentPage, totalEntries);

        displayInfo.textContent = `Showing ${showingCount} of ${totalEntries} entries`;
    }

    function updatePagination() {
        paginationContainer.innerHTML = "";

        // Hide pagination if "All" is selected
        if (entriesPerPage === totalEntries) return;

        let totalPages = Math.ceil(totalEntries / entriesPerPage);
        const startPage = Math.max(1, currentPage - Math.floor(pageLinksToShow / 2));
        const endPage = Math.min(totalPages, startPage + pageLinksToShow - 1);

        if (totalPages > 1) {
            if (currentPage > 1) {
                paginationContainer.innerHTML +=
                    '<button id="prevBtn" class="btn">Prev</button>';
            }

            for (let i = startPage; i <= endPage; i++) {
                paginationContainer.innerHTML += `
                    <a href="#" class="page-link ${i === currentPage ? 'active' : ''}">${i}</a>
                `;
            }

            if (currentPage < totalPages) {
                paginationContainer.innerHTML +=
                    '<button id="nextBtn" class="btn">Next</button>';
            }
        }

        // Page link event listeners
        document.querySelectorAll(".page-link").forEach((link) => {
            link.addEventListener("click", (e) => {
                e.preventDefault();
                currentPage = parseInt(e.target.textContent);
                updateTable();
                updatePagination();
            });
        });

        document.querySelector("#prevBtn")?.addEventListener("click", () => {
            if (currentPage > 1) {
                currentPage--;
                updateTable();
                updatePagination();
            }
        });

        document.querySelector("#nextBtn")?.addEventListener("click", () => {
            if (currentPage < totalPages) {
                currentPage++;
                updateTable();
                updatePagination();
            }
        });
    }

    entriesSelect.addEventListener("change", (e) => {
        const value = e.target.value;
        totalEntries = table.querySelectorAll("tbody tr").length;

        if (value === "all") {
            entriesPerPage = totalEntries; // Show all rows
        } else {
            entriesPerPage = parseInt(value);
        }

        currentPage = 1;
        updateTable();
        updatePagination();
    });

    // Initial setup
    updateTable();
    updatePagination();
});


  // ................ Entries and Pagination End.....................//





// ...................Bar Code Print Js Start,,,,,,,,,,,,,,,,,,,//
function printBarCard() {
    const printContent = document.querySelector(".barcode-preview").outerHTML;
    const originalContent = document.body.innerHTML;

    document.body.innerHTML = printContent; // Replace the body with the print content
    window.print(); // Open the print dialog
    document.body.innerHTML = originalContent; // Restore the original content
    window.location.reload(); // Reload the page to restore events and state
  }

  // ...................Bar Code Print Js End,,,,,,,,,,,,,,,,,,,//
