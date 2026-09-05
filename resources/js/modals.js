// Modal Binders & Null-Safe Helpers

export function bindSimpleModal(modalSelector, openSelector, closeSelector, cancelSelector) {
    const modal = document.querySelector(modalSelector);
    const openBtn = document.querySelector(openSelector);
    if (!modal || !openBtn) return;

    const closeBtn = closeSelector ? modal.querySelector(closeSelector) : null;
    const cancelBtn = cancelSelector ? modal.querySelector(cancelSelector) : null;

    openBtn.addEventListener("click", () => {
        modal.classList.add("show");
        modal.style.display = "flex";
    });

    if (closeBtn) {
        closeBtn.addEventListener("click", () => {
            modal.classList.remove("show");
            modal.style.display = "none";
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener("click", () => {
            modal.classList.remove("show");
            modal.style.display = "none";
        });
    }

    modal.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.classList.remove("show");
            modal.style.display = "none";
        }
    });
}

export function initGlobalModals() {
    bindSimpleModal(".newbrand", ".newbrand-open", ".newbrand-close", ".cancel-btn");
    bindSimpleModal(".newcategory", ".newcategory-open", ".newcategory-close");
    bindSimpleModal(".addnewwarehouse", ".addnewwarehouse-open", ".addnewwarehouse-close");
    bindSimpleModal(".addnewbrand", ".addnewbrand-open", ".addnewbrand-close");
    bindSimpleModal(".selectsupplier-modal", ".selectsupplier-modal-open", ".selectsupplier-modal-close");
    bindSimpleModal(".selectunit-modal", ".selectunit-modal-open", ".selectunit-modal-close");
    bindSimpleModal(".addnewcategory", ".addnewcategory-open", ".addnewcategory-close");

    // Add Product Modal
    const openAddProductModal = document.getElementById("addProductButton");
    const closeAddProductModal = document.getElementById("closeAddProductModal");
    const addProductModal = document.querySelector(".add-product-modal");

    if (openAddProductModal && addProductModal) {
        openAddProductModal.addEventListener("click", () => {
            document.body.style.overflow = "hidden";
            addProductModal.style.display = "flex";
            setTimeout(() => addProductModal.classList.add("show"), 10);
        });
    }

    if (closeAddProductModal && addProductModal) {
        closeAddProductModal.addEventListener("click", () => {
            addProductModal.classList.remove("show");
            setTimeout(() => {
                addProductModal.style.display = "none";
                document.body.style.overflow = "";
            }, 300);
        });

        window.addEventListener("click", (e) => {
            if (e.target === addProductModal) {
                closeAddProductModal.click();
            }
        });
    }

    // Unique Warehouse Modal
    const uniqueModal = document.getElementById("uniqueWarehouseModal");
    const uniqueOpenModalBtn = document.getElementById("uniqueOpenModalBtn");
    const uniqueCancelBtn = document.getElementById("uniqueCancelBtn");

    if (uniqueModal && uniqueOpenModalBtn) {
        uniqueOpenModalBtn.addEventListener("click", () => {
            uniqueModal.classList.add("show");
            uniqueModal.style.display = "flex";
        });
    }
    if (uniqueModal && uniqueCancelBtn) {
        uniqueCancelBtn.addEventListener("click", () => {
            uniqueModal.classList.remove("show");
            uniqueModal.style.display = "none";
        });
    }

    // Add Customer Modal
    const addCustomerModal = document.getElementById("addCustomerModal");
    const addCustomerOpenModalBtn = document.getElementById("addCustomerBtn");
    const addCustomerCancelBtn = document.getElementById("addCustomerCancelBtn");

    if (addCustomerModal && addCustomerOpenModalBtn) {
        addCustomerOpenModalBtn.addEventListener("click", () => {
            addCustomerModal.classList.add("show");
            addCustomerModal.style.display = "flex";
        });
    }
    if (addCustomerModal && addCustomerCancelBtn) {
        addCustomerCancelBtn.addEventListener("click", () => {
            addCustomerModal.classList.remove("show");
            addCustomerModal.style.display = "none";
        });
    }
}
