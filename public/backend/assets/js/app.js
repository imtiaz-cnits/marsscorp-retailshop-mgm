// Sign in And Sign up Start.......
function switchCard(e) {
    if (e && e.preventDefault) e.preventDefault();
    const signInCard = document.getElementById("signInCard");
    const signUpCard = document.getElementById("signUpCard");

    if (signInCard && signUpCard) {
        if (signInCard.style.display === "none") {
            signInCard.style.display = "flex";
            signUpCard.style.display = "none";
        } else {
            signInCard.style.display = "none";
            signUpCard.style.display = "flex";
        }
        return;
    }

    const loginCard = document.querySelector(".container .card:nth-child(1)");
    const registerCard = document.querySelector(".container .card:nth-child(2)");

    if (loginCard && registerCard) {
        if (loginCard.style.display === "none") {
            loginCard.style.display = "block";
            registerCard.style.display = "none";
        } else {
            loginCard.style.display = "none";
            registerCard.style.display = "block";
        }
    }
}
// Sign in And Sign up End.....................


  // ..................... Invoice Sheet Print Function Start..............//
  function printMarksheet() {
    const marksheet = document.querySelector(".invoice-container");

    // Save the current visibility state of the body
    const originalContent = document.body.innerHTML;

    // Set the body to only contain the marksheet
    document.body.innerHTML = marksheet.outerHTML;

    // Trigger the print dialog
    window.print();

    // Restore the original content
    document.body.innerHTML = originalContent;

    // Rebind any event listeners (if necessary)
    location.reload(); // Reload the page to restore functionality
  }
  // ..................... Invoice Sheet Print Function End..............//



// ..................... Barcode Print page quantity Function Start..............//

const input = document.getElementById("ProductGenarateQuantity");

function increase() {
  let value = parseInt(input.value, 0) || 0;
  input.value = value + 1;
}

function decrease() {
  let value = parseInt(input.value, 0) || 0;
  if (value > 0) {
    input.value = value - 1;
  }
}
// ..................... Barcode Print page quantity Function End..............//
