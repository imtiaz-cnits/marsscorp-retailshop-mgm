function increaseQuantity(button) {
        var quantitySpan = button.previousElementSibling;
        var quantity = parseInt(quantitySpan.textContent);
        quantity++;
        quantitySpan.textContent = quantity;

        updateTotal(button, quantity);
    }

    function decreaseQuantity(button) {
        var quantitySpan = button.nextElementSibling;
        var quantity = parseInt(quantitySpan.textContent);
        if (quantity > 1) {
            quantity--;
            quantitySpan.textContent = quantity;

            updateTotal(button, quantity);
        }
    }

    function updateTotal(button, quantity) {
        var row = button.closest('tr');
        var price = parseFloat(row.querySelector('td:nth-child(5)').textContent.replace('$', ''));
        var total = quantity * price;
        row.querySelector('.total').textContent = '$' + total.toFixed(2);
    }