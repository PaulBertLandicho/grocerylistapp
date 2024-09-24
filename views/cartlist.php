<?php
session_start(); // Start the session to access session variables

// Include your database connection file
include 'dbconn.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If user is not logged in, redirect to login page or handle the error accordingly
    header('Location: login.php');
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Check if the product ID is provided in the URL for deletion
if(isset($_GET['delete_product_id'])) {
    $delete_product_id = $_GET['delete_product_id'];

    // Delete the product from the cart
    $delete_sql = "DELETE FROM cart WHERE user_id = $user_id AND product_id = $delete_product_id";
    if($conn->query($delete_sql) === TRUE) {
        // Redirect back to this page after deletion
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Handle the error accordingly
        echo "Error deleting product: " . $conn->error;
    }
}

// Check if the product ID and quantity are provided in the URL for updating quantity
if(isset($_GET['update_quantity_id']) && isset($_GET['new_quantity'])) {
    $update_product_id = $_GET['update_quantity_id'];
    $new_quantity = $_GET['new_quantity'];

    // Update the quantity of the product in the cart
    $update_sql = "UPDATE cart SET quantity = $new_quantity WHERE user_id = $user_id AND product_id = $update_product_id";
    if($conn->query($update_sql) === TRUE) {
        // Redirect back to this page after updating quantity
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Handle the error accordingly
        echo "Error updating quantity: " . $conn->error;
    }
}

// Retrieve all products in the user's cart based on their user_id
$sql = "SELECT product.*, cart.quantity FROM product INNER JOIN cart ON product.id = cart.product_id WHERE cart.user_id = $user_id";
$result = $conn->query($sql);

// Initialize total price variable
$total_price = 0;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/my_shopping_list.css">
</head>

<body>
    <header class="navbar" style="width: auto; margin-bottom: 20px;" data-bs-theme="dark">
        <h1 style="font-weight: bold; font-size: 35px; margin-left: 10px;">My Cart</h1>
        <button class="menu-button">
            <i class="fa fa-align-justify" style="color: darkgreen; margin-right: 15px; transition: transform 0.3s ease;"></i>
        </button>

        <!-- Menu content with icons -->
        <div class="menu-content">
            <a href="javascript:void(0);" id="settings-link" title="Settings">
                <i class="fas fa-cog" style="color: darkgreen; font-size: 20px;"><span style="margin-left: 10px;">Settings</span></i>
            </a>


            <a href="profile.php" title="Profile">
                <i class="fas fa-user" style="color: darkgreen; font-size: 20px;"><span style="margin-left: 10px;">Profile</span></i>
            </a>
            <a href="javascript:void(0);" class="logout-link" onclick="document.getElementById('logout-form').submit();" title="Logout">
                <i class="fas fa-sign-out-alt" style="font-size: 20px; color: darkgreen;"><span style="margin-left: 10px;">Logout</span></i>
            </a>
            <form id="logout-form" action="logout.php" method="POST" style="display: none;">
                <!-- Form is hidden but used to perform POST request -->
            </form>
        </div>
    </header>

    <div class="scrollable-container" style="height: 670px;">
    <div class="products-list-container">
        <?php
        // Check if products are found in the cart
        if ($result->num_rows > 0) {
            // Initialize total price
            $total_price = 0;

            // Display the products
            while ($row = $result->fetch_assoc()) {
                $productId = $row['id'];
                $quantity = $row['quantity'];
                $price = $row['price'];

                // Ensure the new quantity is at least 1
                $decreasedQuantity = max($quantity - 1, 1);
                $increasedQuantity = $quantity + 1;

                echo '<div class="product-container">';
                echo '<div class="product-image">';
                echo '<img src="' . $row['image'] . '" alt="Product Image" style="width: 150px; height: 100px; border-radius: 15px;"><br>';
                echo '</div>';
                echo '<div class="product-details">';
                echo '<span class="product-name" style="font-size: 20px; font-weight: bold; color: maroon">' . $row['name'] . '</span><br>';
                echo '<span class="product-total-price" style="font-size:20px; color: black;">₱' . $row['price'] . '</span>';

                // Create a form for updating quantity
                echo '<div class="quantity" style="margin-left: 55px;">';
                echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="GET">';
                echo '<input type="hidden" name="update_quantity_id" value="' . $row['id'] . '">';
                echo '<button type="submit" name="new_quantity" value="' . $decreasedQuantity . '" style="background-color: maroon; border:none; margin-right: 15px;" ' . ($quantity <= 1 ? 'disabled' : '') . '><i class="fas fa-minus" style="color: white;"></i></button>';
                echo '<span class="product-quantity" style="font-size: 20px; border: none; background-color: white; padding: 2px; border-radius: 4px; color: black;">' . htmlspecialchars($row['quantity']) . 'kg</span>';
                echo '<button type="submit" name="new_quantity" value="' . $increasedQuantity . '" style="background-color: maroon; border:none; margin-left: 15px;"><i class="fas fa-plus" style="color: white;"></i></button>';
                echo '</form>';

                // Calculate and display the total price for this product
                $product_price = $row['price'] * $row['quantity'];
                $total_price += $product_price; // Add to total price
                echo '<span class="product-total-price" style="font-size: 15px; color: black; font-weight: bold;">Total Price: ₱' . $product_price . '</span><br>';
                
                // Add delete button with link to delete the product
                echo '<a href="' . $_SERVER['PHP_SELF'] . '?delete_product_id=' . $row['id'] . '"><i class="fas fa-trash" style="margin-left:100px; color: maroon; font-size:15px;"></i></a>';
                echo '</div>'; // Close product-details
                echo '</div>'; // Close product-container
                echo '</div>'; // Close product-container

            }

            // Display total price
            echo '<div class="total payment" style="position: absolute; bottom: 0;  margin-bottom: 70px; left: 0; right: 0;  display: flex; align-items: center; justify-content: center;">';
            echo '<a id="checkout-btn" class="btn btn-primary" style="margin-bottom: 25px;background-color: maroon; width: 350px; color: white; border-color:maroon; border-radius:30px; height: 45px; font-size:20px; align-items: center;" role="button">';
            echo '<h1>Checkout <span style="margin-left: 110px;">  ₱' . $total_price . '</span></h1>';
            echo '</a></div>'; // Close total payment

        } else {
            // If the cart is empty, display a message to the user
            echo '<div class="no-product-found">
                <img src="uploads/emptybag.png" style="margin-top: 40px; margin-left: 100px;">
                <h3 style="color: maroon; opacity: 0.7; margin-top: 5em; text-align: center;">List is Empty.</h3>
            </div>';
        }
        ?>
    </div>
</div>



    <div class="icon-bar" style="margin-top: 68px;">
        <a class="active" href="user_dashboard.php">
            <i class="fas fa-store-alt"><br>
<span style="font-size: 16px;">Shop</span>
</a></i>
            <a class="active" href="my_shopping_list.php">
                <i class="fas fa-list-alt"><br>
  <span style="font-size: 16px;">Lists</span>
</a></i>
                <a class="active" href="cartlist.php">
                    <i class="fas fa-shopping-cart" style="font-size: 24px; color: maroon;"><br>
  <span style="font-size: 16px;">Cart</span>
</a></i>
                    <a class="active" href="addproductlist.php">
                        <i class="fas fa-shopping-basket"><br>
  <span style="font-size: 16px;">Add</span>
</a></i>
                        <a class="active" href="profile.php">
                            <i class="fas fa-user-circle" style="font-size: 24px;"><br>
  <span style="font-size: 16px;">Profile</span>
</a></i>
    </div>

    <!-- Settings Modal -->
    <div id="settings-modal" class="modal-overlay" style="display: none;">
        <div class="modal-box">
            <span class="close-modal" id="close-settings-modal">&times;</span>
            <h2 style="color: maroon;">Settings</h2>
            <div class="settings-option">
                <label for="theme-toggle" style="color: black;">Dark Mode</label>
                <input type="checkbox" id="theme-toggle">
            </div>
        </div>
    </div>

    <script src="js/settingsdarkmode.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <script src="js/checkoutalert.js"></script>

</body>

</html> 