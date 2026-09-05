// Initialize Vanilla Datepicker
const vanillaInputs = document.querySelectorAll(".datepicker-input");

vanillaInputs.forEach((input) => {
  // Initialize each datepicker instance
  const picker = new Datepicker(input, {
    format: "dd/mm/yyyy",
    autohide: true,
  });

  // Open the picker when the input field is clicked
  input.addEventListener("click", function () {
    picker.show();
  });

  // Open the picker when the calendar icon is clicked
  input.nextElementSibling.addEventListener("click", function () {
    picker.show();
  });

  // Insert slashes automatically as the user types
  input.addEventListener("input", function (event) {
    let value = input.value.replace(/\D/g, "").substring(0, 8); // Remove non-numeric characters and limit to 8 digits (DDMMYYYY)

    // Clear the entire input (numeric and non-numeric) if backspace is pressed
    if (event.inputType === "deleteContentBackward") {
      value = ""; // Remove everything when backspace is pressed
      picker.setDate(new Date()); // Set to today's date
      picker.show(); // Show the picker again
    }

    // Insert slashes after every 2 digits
    if (value.length >= 2) {
      value = value.slice(0, 2) + "/" + value.slice(2);
    }
    if (value.length >= 5) {
      value = value.slice(0, 5) + "/" + value.slice(5);
    }

    // Update the input field with the formatted value
    input.value = value;
  });
});
