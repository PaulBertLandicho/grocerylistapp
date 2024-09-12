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
        header("Location: loginpage.php?error=Middle"); // password na naka register pero wala na decrypt 
    }
} else {
    header("Location: loginpage.php?error=Bottom"); // password na wala pa na register
}
?>

<?php

include 'dbcon.php';

$username = $_POST['username'];
$password = $_POST['password'];

if ($username === "admin" && $password === "admin") {
    session_start();
    $_SESSION['admin'] = 'admin';
    header("Location: admin_dashboard.php");
    exit(); // Terminate script after redirection
}

$sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $conn->close();
    header("Location: user_dashboard.php");
    exit(); // Terminate script after redirection
} 
    // Check if the credentials match a super admin
if ($username === "superadmin" && $password === "superadmin") {
    session_start();
    $_SESSION['superadmin'] = 'superadmin';
    header("Location: superadmin_dashboard.php");
    exit(); // Terminate script after redirection
} else {
    header("Location: loginpage.php?error=Wrong Username/Password");
    exit(); // Terminate script after redirection
}


    