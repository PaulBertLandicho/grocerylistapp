<?php
include 'dbconn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: Profilesetup.php?error=Please login first");
    exit();
}	

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $status = $_POST['order_status']; // Get the selected status from the form

    // Update the user's status in the database
    $sql = "UPDATE user SET status='$status' WHERE id='$user_id'";
    if ($conn->query($sql) === TRUE) {
        // Redirect to user dashboard or any other page
        header("Location: Userorderlist.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
