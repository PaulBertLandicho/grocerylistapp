<?php
session_start();
include 'dbconn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];

    // Retrieve cart items
    $cart_sql = "SELECT * FROM cart WHERE user_id = $user_id";
    $cart_result = $conn->query($cart_sql);

    $order_successful = true;

    while ($cart_row = $cart_result->fetch_assoc()) {
        $product_id = $cart_row['product_id'];
        $quantity = $cart_row['quantity'];
        $insert_order_sql = "INSERT INTO orders (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";

        if (!$conn->query($insert_order_sql)) {
            $order_successful = false;
            break;
        }
    }

    if ($order_successful) {
        $clear_cart_sql = "DELETE FROM cart WHERE user_id = $user_id";
        $conn->query($clear_cart_sql);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}
?>
