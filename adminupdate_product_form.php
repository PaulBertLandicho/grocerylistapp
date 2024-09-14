<?php
include 'dbconn.php';

// Check if product ID is provided
if(isset($_GET['Id'])) {
    $product_id = $_GET['Id'];

    // Retrieve product details from the database
    $sql = "SELECT * FROM product WHERE id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    echo "Product ID not provided.";
    exit();
}

// Retrieve categories from the database
$category_sql = "SELECT id, name FROM category";
$category_result = $conn->query($category_sql);

// Update product details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = intval($_POST['category_id']); // Ensure this is an integer
    $brand = $_POST['brand'];
    $available = isset($_POST['available']) ? 1 : 0; // Check if checkbox is checked

     // Check if a new image is uploaded
     if ($_FILES['image']['size'] > 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        // Update product with the new image and Availability status
        $sql = "UPDATE product SET name='$name', price='$price', category_id='$category_id', brand='$brand', image='$target_file', available='$available' WHERE id=$product_id";
    } else {
        // Update product without changing the image but update ready status
        $sql = "UPDATE product SET name='$name', price='$price', category_id='$category_id', brand='$brand', available='$available' WHERE id=$product_id";
    }

    if ($conn->query($sql) === TRUE) {
        // Redirect to product list page
        header("Location: addproductlist.php");
        exit();
    } else {
        echo "Error updating product: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: lightgray;
            font-family: 'Roboto', sans-serif;
            color: #333;
        }
        .container {
            margin-top: 0px;
            padding: 20px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background: linear-gradient(to right, #00aaff, #00ff99);
            color: white;
            border-bottom: none;
            border-radius: 15px 15px 0 0;
        }
        .form-label {
            font-weight: bold;
            color: #333;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px;
        }
        .btn-custom {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .btn-custom:hover {
            background-color: #0056b3;
            border-color: #004080;
        }
        .btn-cancel {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .btn-cancel:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .form-check-input:checked {
            background-color: #007bff;
            border-color: #007bff;
        }
        .form-check-label {
            margin-left: 5px;
            font-size: 16px;
        }
        .image-preview {
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
            <div class="card-header text-center">
                <h2>Update Product</h2>
            </div>
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?Id=" . $product_id; ?>" method="post" enctype="multipart/form-data">
                    <?php if (!empty($product['image'])): ?>
                        <div class="mb-3 text-center">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Current Image" class="image-preview">
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price:</label>
                        <input type="number" id="price" name="price" class="form-control" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                    </div>

                    <div class="mb-3">
                    <label for="category_id" class="form-label">Category:</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <?php while ($category = $category_result->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($category['id']); ?>" 
                                    <?php if ($product['category_id'] == $category['id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                    <div class="mb-3">
                        <label for="brand" class="form-label">Product Brand:</label>
                        <input type="text" id="brand" name="brand" class="form-control" value="<?php echo htmlspecialchars($product['brand']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image:</label>
                        <input type="file" id="image" name="image" class="form-control" onchange="previewImage(event)">
                        <div class="mt-3">
                            <img id="image-preview" src="#" alt="Image Preview" class="image-preview" style="display: none;">
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" id="available" name="available" class="form-check-input" <?php if ($product['available']) echo "checked"; ?>>
                        <label for="available" class="form-check-label">Product Availability</label>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-custom">Update Product</button>
                        <a href="addproductlist.php" class="btn btn-cancel">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('image-preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-15Jw0p69NV4lfXrbQZpPvhI/p5o9bqA1MO4/xDlAywTiEwnBep9s3B+ThLgLcrd" crossorigin="anonymous"></script>
</body>
</html>
