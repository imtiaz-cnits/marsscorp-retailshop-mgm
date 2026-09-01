
// Create Product modal to New Brand Modal Start................
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.querySelector(".newbrand");
    const openModalBtn = document.querySelector(".newbrand-open");
    const closeModalBtn = modal.querySelector(".newbrand-close");
    const cancelBtn = modal.querySelector(".cancel-btn");

    // Open Modal
    openModalBtn.addEventListener("click", () => {
      modal.classList.add("show");
    });

    // Close Modal via close button
    closeModalBtn.addEventListener("click", () => {
      modal.classList.remove("show");
    });

    // Close Modal via cancel button
    cancelBtn.addEventListener("click", () => {
      modal.classList.remove("show");
    });

    // Close Modal when clicking outside the modal content
    modal.addEventListener("click", (event) => {
      if (event.target === modal) {
        modal.classList.remove("show");
      }
    });
  });

  // Create Product modal to New Brand Modal End................

  // Create Product modal to New Category Modal End................
  document.addEventListener("DOMContentLoaded", () => {
    const modal = document.querySelector(".newcategory");
    const openModalBtn = document.querySelector(".newcategory-open");
    const closeModalBtn = modal.querySelector(".newcategory-close");

    // Open Modal
    openModalBtn.addEventListener("click", () => {
      modal.classList.add("show");
    });

    // Close Modal
    closeModalBtn.addEventListener("click", () => {
      modal.classList.remove("show");
    });

    // Close Modal when clicking outside the modal content
    modal.addEventListener("click", (event) => {
      if (event.target === modal) {
        modal.classList.remove("show");
      }
    });
  });

  // Create Product modal to New Category Modal End................

  // Draft Delate Confirmation Modal Start....................
//   document.addEventListener("DOMContentLoaded", () => {
//     const modal = document.getElementById("confirmationModal");
//     const deleteButtons = document.querySelectorAll(".deleteButton");
//     const confirmButtons = [
//       document.getElementById("confirmYes"),
//       document.getElementById("confirmNo"),
//     ];

//     // Function to open modal
//     const openModal = () => {
//       modal.style.display = "flex";
//     };

//     // Function to close modal
//     const closeModal = () => {
//       modal.style.display = "none";
//     };

//     // Attach click event to all delete buttons
//     deleteButtons.forEach((button) => {
//       button.addEventListener("click", openModal);
//     });

//     // Attach click event to both Yes and No buttons
//     confirmButtons.forEach((button) => {
//       button.addEventListener("click", () => {
//         closeModal();
//       });
//     });

//     // Close modal when clicking outside of it
//     window.addEventListener("click", (event) => {
//       if (event.target === modal) {
//         closeModal();
//       }
//     });
//   });




document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("confirmationModal");
    const deleteButtons = document.querySelectorAll(".deleteButton");
    const confirmButtons = [
        document.getElementById("confirmYes"),
        document.getElementById("confirmNo"),
    ];

    // Function to open modal
    const openModal = () => {
        modal.style.display = "flex";
        document.body.style.overflow = "hidden"; // Disable scrolling
        document.documentElement.style.overflow = "hidden"; // For <html>, if needed
    };

    // Function to close modal
    const closeModal = () => {
        modal.style.display = "none";
        const backdrops = document.querySelectorAll(".modal-backdrop");
        backdrops.forEach((backdrop) => backdrop.remove());
        document.body.style.overflow = ""; // Enable scrolling
        document.documentElement.style.overflow = ""; // For <html>, if needed
    };

    // Attach click event to all delete buttons
    deleteButtons.forEach((button) => {
        button.addEventListener("click", openModal);
    });

    // Attach click event to both Yes and No buttons
    confirmButtons.forEach((button) => {
        button.addEventListener("click", closeModal);
    });

    // Close modal when clicking outside of it
    window.addEventListener("click", (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });
});





  // Draft Delate Confirmation Modal End....................

  // Table Action Edit Modal Start....................
  document.addEventListener("DOMContentLoaded", () => {
    const editModal = document.getElementById("editModal");
    const editButtons = document.querySelectorAll(".editButton");
    const closeModalButtons = document.querySelectorAll(".close");

    // Function to open the modal and hide overflow
    const openModal = () => {
      editModal.style.display = "flex";
      document.body.style.overflow = "hidden"; // Hide scrollbar when modal is open
    };

    // Function to close the modal and restore overflow
    const closeModal = () => {
      editModal.style.display = "none";
      document.body.style.overflow = ""; // Restore the scrollbar when modal is closed
    };

    // Attach click event to all edit buttons
    editButtons.forEach((button) => {
      button.addEventListener("click", openModal);
    });

    // Attach click event to all close buttons
    closeModalButtons.forEach((button) => {
      button.addEventListener("click", closeModal);
    });

    // Close modal when clicking outside of it (on the overlay background)
    window.addEventListener("click", (event) => {
      if (event.target === editModal) {
        closeModal();
      }
    });
  });
  // Table Action Edit Modal End....................


  // Create Product Modal Start........
  document.addEventListener("DOMContentLoaded", () => {
    // Modal function
    function createModal(modalId, btnId, closeClass) {
      const modal = document.getElementById(modalId);
      const btn = document.getElementById(btnId);
      const closeBtn = modal.getElementsByClassName(closeClass)[0];

      // When the user clicks the button, open the modal
      btn.onclick = function () {
        modal.style.display = "block";
        document.documentElement.style.overflowY = "hidden"; // Disable scrolling
      };

      // When the user clicks on <span> (x), close the modal
      closeBtn.onclick = function () {
        modal.style.display = "none";
        document.documentElement.style.overflowY = "auto"; // Enable scrolling
      };

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function (event) {
        if (event.target == modal) {
          modal.style.display = "none";
          document.documentElement.style.overflowY = "auto"; // Enable scrolling
        }
      };
    }

    // Usage example for 'createProduct' modal
    createModal("createProduct", "openModalBtns", "closes");

    // You can add more modals here using the same function:
    // createModal("anotherModal", "openAnotherModalBtn", "close");
  });

  // Create Product Modal End........



  // Finance Pop Up Modal Start.............
  document.addEventListener("DOMContentLoaded", () => {
    // Modal function
    function createModal(modalId, btnId, closeClass) {
      const modal = document.getElementById(modalId);
      const btn = document.getElementById(btnId);
      const closeBtn = modal.getElementsByClassName(closeClass)[0];

      // When the user clicks the button, open the modal
      btn.onclick = function () {
        modal.style.display = "block";
        document.documentElement.style.overflowY = "hidden"; // Disable scrolling
      };

      // When the user clicks on <span> (x), close the modal
      closeBtn.onclick = function () {
        modal.style.display = "none";
        document.documentElement.style.overflowY = "auto"; // Enable scrolling
      };

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function (event) {
        if (event.target == modal) {
          modal.style.display = "none";
          document.documentElement.style.overflowY = "auto"; // Enable scrolling
        }
      };
    }

    // Usage example for 'createProduct' modal
    createModal("myModal", "openModalBtn", "close");

    // You can add more modals here using the same function:
    // createModal("anotherModal", "openAnotherModalBtn", "close");
  });
  // Finance Pop Up Modal End.............

  // Add New Product Modal Start................
  const openAddProductModal = document.getElementById("addProductButton");
  const closeAddProductModal = document.getElementById("closeAddProductModal");
  const addProductModal = document.querySelector(".add-product-modal");

  openAddProductModal.addEventListener("click", () => {
    // Hide scrollbar
    document.body.style.overflow = "hidden";

    addProductModal.style.display = "flex";
    setTimeout(() => addProductModal.classList.add("show"), 10);
  });

  closeAddProductModal.addEventListener("click", () => {
    addProductModal.classList.remove("show");
    setTimeout(() => {
      addProductModal.style.display = "none";
      // Restore scrollbar
      document.body.style.overflow = "";
    }, 300); // Matches the duration of the CSS transition
  });

  window.addEventListener("click", (e) => {
    if (e.target === addProductModal) {
      closeAddProductModal.click();
    }
  });

  // Add New Product Modal End................

  // Add New Product modal to Add New Warehouse Modal Start................
  document.addEventListener("DOMContentLoaded", () => {
    const modal = document.querySelector(".addnewwarehouse");
    const openModalBtn = document.querySelector(".addnewwarehouse-open");
    const closeModalBtn = modal.querySelector(".addnewwarehouse-close");

    // Open Modal
    openModalBtn.addEventListener("click", () => {
      modal.classList.add("show");
    });

    // Close Modal
    closeModalBtn.addEventListener("click", () => {
      modal.classList.remove("show");
    });

    // Close Modal when clicking outside the modal content
    modal.addEventListener("click", (event) => {
      if (event.target === modal) {
        modal.classList.remove("show");
      }
    });
  });
  // Add New Product modal to Add New Warehouse Modal End................

  // Add New Product modal to Add Customer Modal Start................
  document.addEventListener("DOMContentLoaded", () => {
    const modal = document.querySelector(".addnewbrand");
    const openModalBtn = document.querySelector(".addnewbrand-open");
    const closeModalBtn = modal.querySelector(".addnewbrand-close");

    // Open Modal
    openModalBtn.addEventListener("click", () => {
      modal.classList.add("show");
    });

    // Close Modal
    closeModalBtn.addEventListener("click", () => {
      modal.classList.remove("show");
    });

    // Close Modal when clicking outside the modal content
    modal.addEventListener("click", (event) => {
      if (event.target === modal) {
        modal.classList.remove("show");
      }
    });
  });
  // Add New Product modal to Add Customer Modal End................


  // Add New Product modal to Add New Select Supplier Modal start.................
  document.addEventListener("DOMContentLoaded", () => {
    const modal = document.querySelector(".selectsupplier-modal");
    const openModalBtn = document.querySelector(".selectsupplier-modal-open");
    const closeModalBtn = modal.querySelector(".selectsupplier-modal-close");

    // Open Modal
    openModalBtn.addEventListener("click", () => {
      modal.classList.add("show");
    });

    // Close Modal
    closeModalBtn.addEventListener("click", () => {
      modal.classList.remove("show");
    });

    // Close Modal when clicking outside the modal content
    modal.addEventListener("click", (event) => {
      if (event.target === modal) {
        modal.classList.remove("show");
      }
    });
  });

  // Add New Product modal to Add New Select Supplier Modal End.................

  // Add New Product modal to Add New Select Unit Modal Start.................
  document.addEventListener("DOMContentLoaded", () => {
    const modal = document.querySelector(".selectunit-modal");
    const openModalBtn = document.querySelector(".selectunit-modal-open");
    const closeModalBtn = modal.querySelector(".selectunit-modal-close");

    // Open Modal
    openModalBtn.addEventListener("click", () => {
      modal.classList.add("show");
    });

    // Close Modal
    closeModalBtn.addEventListener("click", () => {
      modal.classList.remove("show");
    });

    // Close Modal when clicking outside the modal content
    modal.addEventListener("click", (event) => {
      if (event.target === modal) {
        modal.classList.remove("show");
      }
    });
  });

  // Add New Product modal to Add New Select Unit Modal End.................

  // Add New Product modal to Add New Category Modal Start................
  document.addEventListener("DOMContentLoaded", () => {
    const modal = document.querySelector(".addnewcategory");
    const openModalBtn = document.querySelector(".addnewcategory-open");
    const closeModalBtn = modal.querySelector(".addnewcategory-close");

    // Open Modal
    openModalBtn.addEventListener("click", () => {
      modal.classList.add("show");
    });

    // Close Modal
    closeModalBtn.addEventListener("click", () => {
      modal.classList.remove("show");
    });

    // Close Modal when clicking outside the modal content
    modal.addEventListener("click", (event) => {
      if (event.target === modal) {
        modal.classList.remove("show");
      }
    });
  });
  // Add New Product modal to Add New Category Modal End................

  // Recent Draft modal open close Start..........
  document.addEventListener("DOMContentLoaded", function () {
    const orderModal = document.querySelector(".recent-draft-modal-wrapper");
    const openModalBtn = document.getElementById("recent-draftModal");
    const closeModalBtn = document.querySelector(".button-close");

    // Open Modal
    openModalBtn.addEventListener("click", function () {
      orderModal.classList.add("show");
      orderModal.classList.remove("hide");
    });

    // Close Modal
    closeModalBtn.addEventListener("click", function () {
      orderModal.classList.add("hide");
      setTimeout(() => {
        orderModal.classList.remove("show");
        orderModal.classList.remove("hide");
      }, 300);
    });

    // Close Modal when clicking outside of the modal content
    orderModal.addEventListener("click", function (e) {
      if (e.target === orderModal) {
        orderModal.classList.add("hide");
        setTimeout(() => {
          orderModal.classList.remove("show");
          orderModal.classList.remove("hide");
        }, 300);
      }
    });

    const orderItems = document.querySelectorAll(".order-item");
    const orderDetails = document.querySelectorAll(".order-details");
    const orderSummaries = document.querySelectorAll(".order-summary");

    orderItems.forEach((orderItem) => {
      orderItem.addEventListener("click", function () {
        const orderId = orderItem.dataset.order;
        orderItems.forEach((item) => item.classList.remove("active"));
        orderItem.classList.add("active");
        orderDetails.forEach((orderDetail) => {
          if (orderDetail.id === `order-${orderId}`) {
            orderDetail.classList.remove("hidden");
          } else {
            orderDetail.classList.add("hidden");
          }
        });
        orderSummaries.forEach((orderSummary) => {
          if (orderSummary.id === `summary-${orderId}`) {
            orderSummary.classList.remove("hidden");
          } else {
            orderSummary.classList.add("hidden");
          }
        });
      });
    });
  });

  // Recent Draft Table Function Start.............
  document.addEventListener("DOMContentLoaded", function () {
    const orderItems = document.querySelectorAll(".order-item");
    const orderDetails = document.querySelectorAll(".order-details");
    const orderSummaries = document.querySelectorAll(".order-summary");

    // Function to calculate and update subtotal
    function calculateSubtotal(orderId) {
      const tableRows = document.querySelectorAll(`#order-${orderId} tbody tr`);
      let subtotal = 0;

      // Sum up the prices in the table
      tableRows.forEach((row) => {
        const qty = parseInt(row.cells[2].textContent, 10); // Quantity column
        const price = parseFloat(row.cells[3].textContent.replace("$", "")); // Price column
        subtotal += qty * price;
      });

      // Update the subtotal in the summary
      const summarySubtotal = document.querySelector(
        `#summary-${orderId} p strong`
      );
      summarySubtotal.textContent = `Sub-Total: $${subtotal.toFixed(2)}`;

      // Recalculate tax and discount (for demonstration, using static values)
      const discountPercent = orderId === "1" ? 3 : 5; // Example: Discount % changes by order
      const discountAmount = (subtotal * discountPercent) / 100;
      const shippingCost = 20; // Example: Static shipping cost
      const tax = 0; // Example: Static tax rate

      // Update other summary fields
      const summary = document.getElementById(`summary-${orderId}`);
      summary.innerHTML = `
      <p><strong>Sub-Total:</strong> $${subtotal.toFixed(2)}</p>
      <p><strong>Tax (0.0%):</strong> $${tax.toFixed(2)}</p>
      <p><strong>Discount (${discountPercent}%):</strong> $${discountAmount.toFixed(
        2
      )}</p>
      <p><strong>Shipping Cost:</strong> $${shippingCost.toFixed(2)}</p>
    `;
    }

    // Function to show specific order details
    function showOrder(orderId) {
      // Hide all tables and summaries
      orderDetails.forEach((table) => table.classList.add("hidden"));
      orderSummaries.forEach((summary) => summary.classList.add("hidden"));

      // Remove active class from all items
      orderItems.forEach((item) => item.classList.remove("active"));

      // Show the specific table and summary
      document.getElementById(`order-${orderId}`).classList.remove("hidden");
      document.getElementById(`summary-${orderId}`).classList.remove("hidden");

      // Add active class to the clicked item
      document.querySelector(`#order-item-${orderId}`).classList.add("active");

      // Calculate and update subtotal for the selected order
      calculateSubtotal(orderId);
    }

    // Event listener for each order item
    orderItems.forEach((item) => {
      item.addEventListener("click", function () {
        const orderId = this.getAttribute("data-order");
        showOrder(orderId);
      });
    });

    // Show the first order by default
    showOrder(1);
  });
  // Recent draft modal open close End..........

  // Draft modal Start......
  document.addEventListener("DOMContentLoaded", function () {
    const orderModal = document.querySelector(".draftmodal-wrapper");
    const openModalBtn = document.getElementById("draftModal");
    const closeModalBtn = document.querySelector(".close-btn");

    // Open Modal
    openModalBtn.addEventListener("click", function () {
      orderModal.classList.add("show");
      orderModal.classList.remove("hide");
    });

    // Close Modal
    closeModalBtn.addEventListener("click", function () {
      orderModal.classList.add("hide");
      setTimeout(() => {
        orderModal.classList.remove("show");
        orderModal.classList.remove("hide");
      }, 300);
    });

    // Close Modal when clicking outside of the modal content
    orderModal.addEventListener("click", function (e) {
      if (e.target === orderModal) {
        orderModal.classList.add("hide");
        setTimeout(() => {
          orderModal.classList.remove("show");
          orderModal.classList.remove("hide");
        }, 300);
      }
    });
  });
  // Draft Modal End ....................

  // Add Warehouse Modal Start ................
  const uniqueModal = document.getElementById("uniqueWarehouseModal");
  const uniqueOpenModalBtn = document.getElementById("uniqueOpenModalBtn");
  const uniqueCancelBtn = document.getElementById("uniqueCancelBtn");

  uniqueOpenModalBtn.addEventListener("click", () => {
    uniqueModal.classList.add("show");
  });

  uniqueCancelBtn.addEventListener("click", () => {
    uniqueModal.classList.remove("show");
  });

  document.addEventListener("click", (e) => {
    if (e.target === uniqueModal) {
      uniqueModal.classList.remove("show");
    }
  });

  // Add Warehouse Modal End ................

  // Add Customer Modal End ................

  const addCustomerModal = document.getElementById("addCustomerModal");
  const addCustomerOpenModalBtn = document.getElementById("addCustomerBtn");
  const addCustomerCancelBtn = document.getElementById("addCustomerCancelBtn");

  addCustomerOpenModalBtn.addEventListener("click", () => {
    addCustomerModal.classList.add("show");
  });

  addCustomerCancelBtn.addEventListener("click", () => {
    addCustomerModal.classList.remove("show");
  });

  document.addEventListener("click", (e) => {
    if (e.target === addCustomerModal) {
      addCustomerModal.classList.remove("show");
    }
  });

  // Add Customer Modal End ................
