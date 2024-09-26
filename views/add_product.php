<?php
include 'dbconn.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login_page.php?error=Please login first");
    exit();
}

// Retrieve the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Retrieve form data
$name = $_POST['name'];
$price = $_POST['price'];
$category_id = $_POST['category_id']; 
$brand = $_POST['brand'];
$store = $_POST['store'];
$weight = $_POST['weight'];
$image = $_FILES['image']['name'];
$image_temp = $_FILES['image']['tmp_name'];
$image_destination = "uploads/" . $image;

move_uploaded_file($image_temp, $image_destination);

// Check if the category already exists
$checkCategory = "SELECT * FROM Category WHERE id = ?";
$stmt = $conn->prepare($checkCategory);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $categoryName = ''; 
    switch ($category_id) {
        case '1': $categoryName = 'Fruits'; break;
        case '2': $categoryName = 'Protein'; break;
        case '3': $categoryName = 'Snack'; break;
        case '4': $categoryName = 'Beverage'; break;
        case '5': $categoryName = 'Seafood'; break;
        case '6': $categoryName = 'Baking'; break;
        case '7': $categoryName = 'Vegetables'; break;
    }
    $insertCategory = "INSERT INTO Category (id, name) VALUES (?, ?)";
    $categoryStmt = $conn->prepare($insertCategory);
    $categoryStmt->bind_param("is", $category_id, $categoryName);
    $categoryStmt->execute();
    $categoryStmt->close();
}

// Insert product with user ID
$sql = "INSERT INTO Product (name, price, category_id, brand, store, image, weight, user_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sdissssi", $name, $price, $category_id, $brand, $store, $image_destination, $weight, $user_id);

if ($stmt->execute()) {
    header("Location: addproductlist.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
