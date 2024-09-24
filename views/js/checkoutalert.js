document.getElementById('checkout-btn').addEventListener('click', function () {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to place your order?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, place order!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Call a function to perform checkout
            placeOrder();
        }
    });
});

function placeOrder() {
    // Simulate the checkout process using a fetch request
    fetch('place_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action: 'place_order' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Successfully Checkout',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                // Clear cart items
                document.querySelector('.products-list-container').innerHTML = 
                    '<div class="no-product-found">' +
                    '<image src="uploads/emptybag.png" style="margin-top: 40px; margin-left: 100px;">' +
                    '<h3 style="color: maroon; opacity: 0.7; margin-top: 5em; text-align: center;">List is Empty.</h3>' +
                    '</div>';
            });
        } else {
            Swal.fire('Error', 'There was an issue placing the order.', 'error');
        }
    })
    .catch(error => {
        Swal.fire('Error', 'An error occurred. Please try again.', 'error');
    });
}