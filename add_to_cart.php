<?php
session_start(); // Start the session to access session variables

// Include your database connection file
include 'dbconn.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        // AJAX request
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    } else {
        // Regular HTTP request
        header('Location: login.php');
    }
    exit();
}

$product_id = $_REQUEST['product_id']; // Use $_REQUEST to handle both GET and POST requests
$user_id = $_SESSION['user_id'];

// Check if the product ID is valid (you may need additional validation here)
// For example, checking if it exists in your database

// Prepare and execute a statement to check if the product is already in the cart
$sql_check = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $user_id, $product_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Product is already in the cart
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        // AJAX request
        echo json_encode(['status' => 'success', 'message' => 'Product already in cart']);
    } else {
        // Regular HTTP request
        header('Location: cartlist.php');
    }
} else {
    // Product is not in the cart, so add it
    $sql_insert = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ii", $user_id, $product_id);

    if ($stmt_insert->execute()) {
        // Get the updated cart count
        $stmt_count = $conn->prepare("SELECT COUNT(*) FROM cart WHERE user_id = ?");
        $stmt_count->bind_param("i", $user_id);
        $stmt_count->execute();
        $numItemsInCart = $stmt_count->get_result()->fetch_row()[0];
        
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            // AJAX request
            echo json_encode(['status' => 'success', 'numItemsInCart' => $numItemsInCart]);
        } else {
            // Regular HTTP request
            header('Location: cartlist.php');
        }
    } else {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            // AJAX request
            echo json_encode(['status' => 'error', 'message' => 'Failed to add product to cart']);
        } else {
            // Regular HTTP request
            echo "Error: " . $conn->error;
        }
    }
}

$stmt_check->close();
$stmt_insert->close();
$stmt_count->close();
$conn->close();
?>
