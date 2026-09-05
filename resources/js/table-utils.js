// Table Actions, Filters, Search & Printing Helpers

export function printBarCard() {
    const preview = document.querySelector(".barcode-preview");
    if (!preview) return;
    const printContent = preview.outerHTML;
    const originalContent = document.body.innerHTML;

    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;
    window.location.reload();
}

export function initTableUtils() {
    // 1. Table Action Dropdown Toggler
    let currentOpenMenu = null;
    function closeMenu(menuWrap) {
        const toggler = menuWrap.querySelector(".toggler");
        if (toggler) toggler.checked = false;
    }

    function initDropdown(menuWrap) {
        const toggler = menuWrap.querySelector(".toggler");
        const links = menuWrap.querySelectorAll(".link");
        if (!toggler) return;

        document.addEventListener("click", (event) => {
            if (!menuWrap.contains(event.target) && currentOpenMenu !== menuWrap) {
                if (currentOpenMenu) closeMenu(currentOpenMenu);
            }
        });

        menuWrap.addEventListener("click", (event) => event.stopPropagation());

        links.forEach((link) => {
            link.addEventListener("click", () => {
                closeMenu(menuWrap);
                currentOpenMenu = null;
            });
        });

        toggler.addEventListener("change", () => {
            if (toggler.checked) {
                if (currentOpenMenu && currentOpenMenu !== menuWrap) closeMenu(currentOpenMenu);
                currentOpenMenu = menuWrap;
            } else if (currentOpenMenu === menuWrap) {
                currentOpenMenu = null;
            }
        });
    }

    document.querySelectorAll("#menu-wrap").forEach(initDropdown);

    // 2. Table Search Filter
    const searchInput = document.querySelector("#searchInput");
    if (searchInput) {
        searchInput.addEventListener("input", () => {
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
        });
    }

    // 3. Export Actions (jQuery based if present)
    if (typeof $ !== 'undefined') {
        $("#copyBtn").off('click').on('click', function () {
            const range = document.createRange();
            const tbl = document.querySelector("table");
            if (!tbl) return;
            range.selectNode(tbl);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
            document.execCommand("copy");
            window.getSelection().removeAllRanges();
            alert("Table copied to clipboard!");
        });

        $("#csvBtn").off('click').on('click', function () {
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

        $("#pdfBtn").off('click').on('click', function () {
            if (window.jspdf) {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();
                if (typeof doc.autoTable === 'function') {
                    doc.autoTable({ html: "table", startY: 10 });
                    doc.save("data.pdf");
                }
            }
        });

        $("#xlsxBtn").off('click').on('click', function () {
            if (typeof XLSX !== 'undefined') {
                const tbl = document.querySelector("table");
                if (tbl) {
                    const wb = XLSX.utils.table_to_book(tbl);
                    XLSX.writeFile(wb, "data.xlsx");
                }
            }
        });

        $("#printBtn").off('click').on('click', function () {
            window.print();
        });
    }
}
