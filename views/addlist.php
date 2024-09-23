<?php
session_start();
include 'dbconn.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "error";
    exit();
}

// Get product ID from the AJAX request
$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;

if (!$product_id) {
    echo "error";
    exit();
}

// Get user ID
$user_id = $_SESSION['user_id'];

// Insert the product into the my_addlist table
$insert_sql = "INSERT INTO my_addlist (user_id, product_id) VALUES ($user_id, $product_id)";
if ($conn->query($insert_sql)) {

    // Redirect to my_shopping_list.php
    header("Location: my_shopping_list.php");
    exit();
} else {
    echo "error";
}
?>
