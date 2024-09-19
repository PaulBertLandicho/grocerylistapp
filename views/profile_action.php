<?php
include 'dbconn.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM user WHERE username ='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $hashedPassword = $user['password'];
   
    if (password_verify($password, $hashedPassword)) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $conn->close();
        header('Location: user_dashboard.php'); // password encrypt og decrypt 
    } else {
    }
}
?>

<?php

include 'dbcon.php';

$username = $_POST['username'];
$password = $_POST['password'];

if ($username === "admin" && $password === "admin") {
    session_start();
    $_SESSION['admin'] = 'admin';
    header("Location: adminhome.php");
    exit(); // Terminate script after redirection
}

$sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $conn->close();
    header("Location: Profilesetup.php");
    exit(); // Terminate script after redirection
} else {
    header("Location: Profilesetup.php?error=Wrong Username/Password");
    exit(); // Terminate script after redirection
}
    

    