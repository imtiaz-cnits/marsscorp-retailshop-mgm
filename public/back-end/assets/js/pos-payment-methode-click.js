const paymentMethods = document.querySelectorAll(".category label");
const transactionInput = document.getElementById("transactionInput");

// Add an event listener to all payment methods
paymentMethods.forEach((method) => {
  method.addEventListener("click", () => {
    // Remove 'active' class from all methods
    paymentMethods.forEach((m) => m.classList.remove("active"));

    // Add 'active' class to the clicked method
    method.classList.add("active");

    // Show or hide the input field based on the selected method
    if (method.classList.contains("cashMethod")) {
      transactionInput.style.display = "none"; // Hide input for cash
    } else {
      transactionInput.style.display = "block"; // Show input for others

      // Change the placeholder text based on the selected method
      if (method.classList.contains("bkashMethod")) {
        transactionInput.placeholder = "Enter BKash Transaction ID";
      } else if (method.classList.contains("nagadMethod")) {
        transactionInput.placeholder = "Enter Nagad Transaction ID";
      } else if (method.classList.contains("rocketMethod")) {
        transactionInput.placeholder = "Enter Rocket Transaction ID";
      } else if (method.classList.contains("bankMethod")) {
        transactionInput.placeholder = "Enter Bank Transaction ID";
      } else if (method.classList.contains("mastercardMethod")) {
        transactionInput.placeholder = "Enter Card Transaction ID";
      } else {
        transactionInput.placeholder = "Enter Transaction ID";
      }
    }
  });
});
