$(document).ready(function() {
    // Function to update cart icon
    function updateCartIcon(numItems) {
        if (numItems > 0) {
            $('#cart-icon').addClass('has-items');
            $('#cart-badge').text(numItems).show(); // Show badge and update text
        } else {
            $('#cart-icon').removeClass('has-items');
            $('#cart-badge').hide(); // Hide badge when no items
        }
    }

    // Example: Get the number of items in the cart (replace with your actual logic)
    var numItemsInCart = 2; // Replace with your actual code to get the number of items

    // Update cart icon initially
    updateCartIcon(numItemsInCart);
});

// Function to handle click on list icon
$(document).on('click', '.fa-list-alt', function() {
    var productId = $(this).attr('id').split('-')[2];
    
    // Make an AJAX request to add to favorites
    addToFavorites(productId);

    // Change color of the list icon to blue (or any color of your choice) by changing the class
    $(this).css('color', 'darkgreen');
});

function addToFavorites(productId) {
    // Make an AJAX request
    $.ajax({
        type: "POST",
        url: "addlist.php",
        data: { product_id: productId },
        success: function(response) {
            if (response === "added") {
                // If product is successfully added to favorites, you may handle it here
            } else {
                // Handle error or display a message
                console.error("Error adding product to favorites.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", error);
        }
    });
}

 

document.addEventListener("DOMContentLoaded", function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior
            
            const productId = this.getAttribute('data-product-id');
            	
            // AJAX request to add product to cart
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Trigger bounce animation
                        button.classList.add('bounce');
                        
                        // Remove bounce animation after completion
                        button.addEventListener('animationend', function() {
                            button.classList.remove('bounce');
                        });
                    } else {
                        // Error handling
                        console.error('Failed to add product to cart');
                    }
                }
            };
            xhr.open('GET', 'add_to_cart.php?product_id=' + productId, true);
            xhr.send();
        });
    });
});


// Get modal elements and close button
var modal = document.getElementById('product-modal');
var closeModal = document.querySelector('.close-modal');

// Function to open the modal with product details
function openModal(product) {
    document.getElementById('modal-image').src = product.image;
    document.getElementById('modal-product-name').textContent = product.name;
    document.getElementById('modal-product-price').textContent = '₱' + product.price;
    document.getElementById('modal-product-brand').textContent = product.brand;
    document.getElementById('modal-product-weight').textContent = '' + product.weight + '';
    document.getElementById('modal-product-store').textContent = '' + product.store; // Added store

    // Display the current date
    var currentDate = new Date();
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('modal-current-date').textContent = currentDate.toLocaleDateString(undefined, options);

    // Display product status
    var statusElement = document.getElementById('modal-product-status');
    statusElement.innerHTML = ''; // Clear previous status

    if (product.status === 'Available') {
        statusElement.innerHTML = '<span style="color: green;"><i class="fas fa-check-circle"></i> Available</span>';
    } else if (product.status === 'Sold Out') {
        statusElement.innerHTML = '<span style="color: red;"><i class="fas fa-times-circle"></i> Sold Out</span>';
    } else if (product.status === 'Purchased') {
        statusElement.innerHTML = '<span style="color: blue;"><i class="fas fa-check"></i> Purchased</span>';
    }

    modal.style.display = 'flex'; // Show modal
}

// Function to close the modal
function closeModalFunction() {
    modal.style.display = 'none';
}

// Event listener for close button
closeModal.addEventListener('click', closeModalFunction);

// Event listener for clicking outside of modal content to close it
window.addEventListener('click', function(event) {
    if (event.target === modal) {
        closeModalFunction();
    }
});

// Event listener for "See Details" button click to open modal
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.details-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var product = {
                id: this.getAttribute('data-product-id'),
                name: this.parentElement.getAttribute('data-name'),
                image: this.parentElement.getAttribute('data-image'),
                price: this.parentElement.getAttribute('data-price'),
                status: this.parentElement.getAttribute('data-status'), // Get product status
                brand: this.parentElement.getAttribute('data-brand'),
                weight: this.parentElement.getAttribute('data-weight'),
                store: this.parentElement.getAttribute('data-store') // Get store
            };
            openModal(product);
        });
    });
});


