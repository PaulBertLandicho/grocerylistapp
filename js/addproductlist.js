
$(document).ready(function() {

    function updateCartIcon(numItems) {
          if (numItems > 0) {
              $('#cart-icon').addClass('has-items');
              $('#cart-badge').text(numItems).show(); 
          } else {
              $('#cart-icon').removeClass('has-items');
              $('#cart-badge').hide(); 
          }
      }
  
      var numItemsInCart = 2; 
  
      updateCartIcon(numItemsInCart);
  });
  
  $(document).on('click', '.cart-btn', function() {
      var productId = $(this).data('product-id');
      
      addToCart(productId);
  
      var cartIcon = $(this).find('.fa-shopping-cart');
      cartIcon.css('color', 'green'); 
  });
  
  function addToCart(productId) {
      $.ajax({
          type: "POST",
          url: "add_to_cart.php", 
          data: { product_id: productId },
          success: function(response) {
              if (response === "added") {
                  
                  updateCartIcon(response.numItemsInCart); 
              } else {
                  console.error("Error adding product to cart.");
              }
          },
          error: function(xhr, status, error) {
              console.error("AJAX error:", error);
          }
      });
  }
  
          const addProductButton = document.getElementById('addProductButton');
          const modalOverlay = document.getElementById('modalOverlay');
          const closeModal = document.getElementById('closeModal');
          const cancelButton = document.getElementById('cancelButton');
  
          addProductButton.addEventListener('click', () => {
              modalOverlay.classList.add('show');
          });
  
          closeModal.addEventListener('click', () => {
              modalOverlay.classList.remove('show');
          });
  
          cancelButton.addEventListener('click', () => {
              modalOverlay.classList.remove('show');
          });
  
          window.addEventListener('click', (event) => {
              if (event.target === modalOverlay) {
                  modalOverlay.classList.remove('show');
              }
          });
  
          function previewProfilePicture(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
  
              reader.onload = function (e) {
                  document.getElementById('avatarImage').src = e.target.result;
              }
  
              reader.readAsDataURL(input.files[0]);
          }
      }