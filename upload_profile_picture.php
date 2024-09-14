<?php
include 'dbconn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login_page.php?error=Please login first");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['profile_picture'])) {
    $file = $_FILES['profile_picture'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');
    
    if (in_array($file_ext, $allowed_exts)) {
        if ($file_error === 0) {
            if ($file_size <= 2097152) { // 2MB limit
                $file_new_name = "profile_" . $user_id . "." . $file_ext;
                $file_destination = 'uploads/' . $file_new_name;
                
                if (move_uploaded_file($file_tmp, $file_destination)) {
                    // Update database with new profile picture path
                    $sql = "UPDATE user SET profile_picture='$file_new_name' WHERE id='$user_id'";
                    if ($conn->query($sql) === TRUE) {
                        // Redirect to profile page to show updated profile picture
                        header("Location: profile.php");
                        exit();
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                } else {
                    echo "Failed to move uploaded file.";
                }
            } else {
                echo "File size exceeds 2MB.";
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid file extension.";
    }
} else {
    echo "No file uploaded.";
}
?>
