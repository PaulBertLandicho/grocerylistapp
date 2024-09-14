<?php
include 'dbconn.php';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 10;
$offset = ($page - 1) * $records_per_page;

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query with pagination and search
$sql = "SELECT * FROM product WHERE Name LIKE '%$search%' LIMIT $offset, $records_per_page";
$result = $conn->query($sql);

// Total records
$total_records = mysqli_num_rows($conn->query("SELECT * FROM product"));

// Total pages
$total_pages = ceil($total_records / $records_per_page);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/user_dashboard.css">
  </head>
  <body>
    <div class="floating-container">
      <div class="container">
        <form action="add_product.php" method="POST" enctype="multipart/form-data">
          <label for="image" style="font-weight:bold; font-size:22px;">Product Image:</label>
          <br>
          <img id="preview" src="" alt="Image Preview" style="max-width: 150px; display: none;">
          <input type="file" style="font-size:10px;" id="image" name="image" onchange="previewImage(event)">
          <label for="name" style="margin-right:60px; font-weight:bold; margin-top:15px;">Product Name: <input type="text" id="name" name="name">
            <label for="price" style="margin-top:15px;">Product Price: <input type="text" id="price" placeholder="₱" name="price">
              <br>
              <label for="category" style="margin-top:15px;margin-right:80px; font-weight:bold;">Select Category: <select id="category" name="category">
                  <option value="1">Fruits</option>
                  <option value="2">Protein</option>
                  <option value="3">Snack</option>
                  <option value="4">Beverage</option>
                  <option value="5">Seafood</option>
                  <option value="6">Baking</option>
                  <option value="7">Vegetables</option>
                </select>
                <label for="brand" style="margin-top:15px; margin-left:17px;">Time: <input type="text" id="brand" name="brand">
                </label>
                <br>
                <br>
                <input type="submit" value="Add Product" class="add-product-button" style="margin-left:20px;">
                <button type="button" onclick="window.location.href='addproductlist.php'" style="width: 100px; font-size: 17px; height: 40px; background-color: maroon; color: #fff; border: none; border-radius: 3px;">Cancel</button>
        </form>
        <script>
          function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
              var img = document.getElementById('preview');
              img.src = reader.result;
              img.style.display = 'block'; // Show the image
            };
            reader.readAsDataURL(input.files[0]);
          }
        </script>
  </body>
</html>