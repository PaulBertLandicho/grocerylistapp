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
        header('Location: my_shopping_list.php'); // password encrypt og decrypt 
    } else {
        header("Location: index.php?error=Middle"); // password na naka register pero wala na decrypt 
    }
} else {
    header("Location: index.php?error=Bottom"); // password na wala pa na register
}
?>


    