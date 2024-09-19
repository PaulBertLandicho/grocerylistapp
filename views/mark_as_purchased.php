<?php
include 'dbconn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login_page.php?error=Please login first");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Update purchased status in the database
    $sql = "UPDATE product SET purchased = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        header("Location: my_shopping_list.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No product ID specified.";
}

$conn->close();
?>
