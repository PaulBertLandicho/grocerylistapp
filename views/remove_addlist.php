<?php
session_start();
include 'dbconn.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "error";
    exit();
}

// Get user ID
$user_id = $_SESSION['user_id'];

// Check if product ID is provided
if (isset($_POST['product_id'])) {
    // Sanitize the input
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    
    // Query to delete the favorite product for the user
    $delete_sql = "DELETE FROM my_addlist WHERE user_id = $user_id AND product_id = $product_id";
    
    // Execute the query
    if ($conn->query($delete_sql)) {
        
        // Redirect back to my_shopping_list.php
        header("Location: my_shopping_list.php");
        exit(); // Make sure to exit after redirecting
    } else {
        echo "error"; // Send error response back if deletion fails
    }
} else {
    echo "error"; // Product ID not provided, send error response
}

// Close the database connection
$conn->close();
?>
