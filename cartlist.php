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
$sql = "SELECT product.*, cart.quantity, cart.ready FROM product INNER JOIN cart ON product.id = cart.product_id WHERE cart.user_id = $user_id";
$result = $conn->query($sql);

// Initialize total price variable
$total_price = 0;

// Handle Place Order action
if(isset($_GET['place_order'])) {
    // Retrieve cart items for the user
    $cart_sql = "SELECT * FROM cart WHERE user_id = $user_id";
    $cart_result = $conn->query($cart_sql);

    // Insert cart items into order table
    while ($cart_row = $cart_result->fetch_assoc()) {
        $product_id = $cart_row['product_id'];
        $quantity = $cart_row['quantity'];
        $insert_order_sql = "INSERT INTO orders (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
        $conn->query($insert_order_sql);
    }

    // Clear the cart after placing the order
    $clear_cart_sql = "DELETE FROM cart WHERE user_id = $user_id";
    $conn->query($clear_cart_sql);

    // Redirect back to the cart page or any other page as needed
    header('Location: payment.php');
    exit();
}
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
    <link rel="stylesheet" href="css/myfavorite.css">
</head>

<body>
<center><h2><b>MY CART</b></center></h2><br><br>

<div class="scrollable-container" style="height: 648px;
">
<div class="products-list-container">
<?php
    // Check if products are found in the cart
    if ($result->num_rows > 0) {
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
            echo '<span class="product-total-price" style="font-size:20px;">₱' . $row['price'] . '</span>';
                        // Create a form for updating quantity
                        echo '<div class="quantity" style="margin-left: 55px;">';
                        echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="GET">';
                        echo '<input type="hidden" name="update_quantity_id" value="' . $row['id'] . '">';
                        echo '<button type="submit" name="new_quantity" value="' . $decreasedQuantity . '" style="background-color: maroon; border:none; margin-right: 15px;" ' . ($quantity <= 1 ? 'disabled' : '') . '><i class="fas fa-minus" style="color: white;"></i></button>';
                        echo '<span class="product-quantity" style="font-size: 20px; border: none; background-color: white; padding: 2px; border-radius: 4px;">' . htmlspecialchars($row['quantity']) . 'kg</span>';
                        echo '<button type="submit" name="new_quantity" value="' . $increasedQuantity . '" " style="background-color: maroon; border:none; margin-left: 15px;"><i class="fas fa-plus" style="color: white;"></i></button>';
                    echo '</form>';
                        // Calculate and display the total price for this product
                        $product_price = $row['price'] * $row['quantity'];
                        $total_price += $product_price; // Add to total price
                        echo '<span class="product-total-price" style="font-size:10px; font-weight: bold;">Total Price: ₱' . $product_price . '</span><br>';
                        // Add delete button with link to delete the product
                        echo '<a href="' . $_SERVER['PHP_SELF'] . '?delete_product_id=' . $row['id'] . '"><i class="fas fa-trash" style="margin-left:100px; color: maroon; font-size:15px;"></i></a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';

                    }
                } else {
                    // If the cart is empty, display a message to the user
                    
                    echo '<div class="no-product-found">
                    <h3 style="color: maroon; opacity: 0.7; margin-top: 5em;  text-align: center;">List is Empty.</h3>
                </div>';
                }
                ?>
                </div>
                </div>
                <a class="btn btn-primary" href="?place_order=true" style="margin-bottom: 25px;background-color: maroon; width: 150px; margin-left:135px; color: white; border-color:maroon; border-radius:10px; height:45px; font-size:20px;" role="button">Check Out</a></div>
<div class="icon-bar" >
 <a class="active" href="user_dashboard.php">
 <i class="fas fa-store-alt" style="font-size: 25px;"><br>
<span style="font-size: 16px;">Home</span>
</a></i>
<a class="active" href="Myfavorite.php">
  <i class="fas fa-heart"><br>
  <span style="font-size: 16px;">Favorite</span>
</a></i>
<a class="active" href="cartlist.php">
<i class="fas fa-shopping-cart" style="font-size: 25px; color: maroon"><br>
  <span style="font-size: 16px;">Cart</span>
</a></i>
<a class="active" href="addproductlist.php">
  <i class="fa fa-shopping-basket"style="font-size: 24px;"><br>
  <iconify-icon icon="ic:baseline-pending-actions" style="font-size: 24px;"></iconify-icon>
  <span style="font-size: 16px;">Lists</span>
</a></i>
<a class="active" href="profile.php">
  <i class="far fa-user-circle"style="font-size: 24px;"><br>
  <span style="font-size: 16px;">Profile</span>
</a></i>


</body>
</html>