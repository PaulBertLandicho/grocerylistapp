<?php
include 'dbconn.php';

// Retrieve form data
$name = $_POST['name'];
$price = $_POST['price'];
$category_id = $_POST['category_id']; // Change to match your form field name
$brand = $_POST['brand'];
$weight = $_POST['weight'];
$volume = $_POST['volume'];

$image = $_FILES['image']['name'];
$image_temp = $_FILES['image']['tmp_name'];
$image_destination = "uploads/" . $image;

move_uploaded_file($image_temp, $image_destination);

// Check if the category already exists
$checkCategory = "SELECT * FROM Category WHERE id = '$category_id'";
$result = $conn->query($checkCategory);

if ($result->num_rows === 0) {
    // If category does not exist, insert it into the Category table
    $categoryName = ''; // Default or empty value for category name if needed

    switch ($category_id) {
        case '1':
            $categoryName = 'Fruits';
            break;
        case '2':
            $categoryName = 'Protein';
            break;
        case '3':
            $categoryName = 'Snack';
            break;
        case '4':
            $categoryName = 'Beverage';
            break;
        case '5':
            $categoryName = 'Seafood';
            break;
        case '6':
            $categoryName = 'Baking';
            break;
        case '7':
            $categoryName = 'Vegetables';
            break;
    }

    $insertCategory = "INSERT INTO Category (id, name) VALUES ('$category_id', '$categoryName')";
    $conn->query($insertCategory);
}

$sql = "INSERT INTO Product (name, price, category_id, brand, image, weight, volume) 
        VALUES ('$name', '$price', '$category_id', '$brand', '$image_destination', '$weight', '$volume')";

if ($conn->query($sql) === TRUE) {
    header("Location: addproductlist.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
