<?php
include 'dbconn.php';

// Retrieve and sanitize input
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Prepare and execute the query to check for existing username or email
$check_query = "SELECT * FROM user WHERE username=? OR email=?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<p style='font-size: 24px; color: #D5DEEF; position:absolute; top:50%; left:50%;transform: translate(-50%,50%);'>Error: Username or email already exists. <b><a href ='reglog.php'>Click here to register again.</a></b></p>";
    exit();
}

// Prepare and execute the insertion query
$sql = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $email, $password_hash);

if ($stmt->execute()) {
    // Set session variables if needed
    session_start();
    $_SESSION['username'] = $username;
    // Fetch user ID for further use
    $_SESSION['user_id'] = $stmt->insert_id;
    header('Location: user_dashboard.php');
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
