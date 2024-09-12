<?php
session_start();
include 'dbconn.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT p.* FROM favorites f INNER JOIN product p ON f.product_id = p.id WHERE f.user_id = $user_id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Favorite</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/myfavorite.css">

</head>
<body>
<center><h2><b>MY FAVORITE</b></center></h2><br><br>

<div class="scrollable-container">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Display product details
            echo '<div class="product-container">';
            echo '<div class="product-image">';
            echo "<img src='" . $row['image'] . "' alt='Product Image' style='margin-bottom:30px;width: 150px; height: 100px; border-radius: 15px;'>";
            echo '</div>';

            echo '<div class="product-details">';
            echo "<div style='color: maroon; font-size:22px;'><b>" . $row['name'] . "</b></div>";
            // Display "Time to Cook" with clock icon
            echo "<div><i class='fas fa-clock'style='color: green;'></i>" . $row['time_to_cook'] . "</div>";

            // Display availability with color and icon
            if ($row['available'] == 1) {
                echo "<div style='color: green;'><i class='fas fa-check-circle'></i> Available</div>";
            } else {
                echo "<div style='color: red;'><i class='fas fa-times-circle'></i> Not Available</div>";
            }
            echo "<a href='add_to_cart.php?product_id=" . $row['id'] . "' class='cart-btn' style='color: maroon; font-size: 22px;'><i class='fas fa-shopping-cart'></i></a>";
            // Display product price
            echo "<span style='font-size: 24px;'>₱" . $row['price'] . "</span>";        
            echo "<form action='remove_favorite.php' method='post'>";
            echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
            echo "<button type='submit' class='button-white' style='border: none; background-color: transparent;'><i class='fas fa-heart' style='font-size: 25px; color: red; margin-right:5px; margin-left:160px;'></i></button>";
            echo "</form>";

            echo "</div>";
            echo '</div>';
        }
    } else {
        echo '<div class="no-product-found">
                <h3 style="color: maroon; opacity: 0.7; margin-top: 5em; text-align: center;">List is Empty.</h3>
            </div>';
    }

    $conn->close();
    ?>
</div>

<div class="icon-bar" >
 <a class="active" href="user_dashboard.php">
 <i class="fas fa-store-alt" style="font-size: 25px;"><br>
<span style="font-size: 16px;">Home</span>
</a></i>
<a class="active" href="Myfavorite.php">
  <i class="fas fa-heart" style="font-size: 25px; color: maroon"><br>
  <span style="font-size: 16px;">Favorite</span>
</a></i>
<a class="active" href="cartlist.php">
<i class="fas fa-shopping-cart" style="font-size: 25px;"><br>
  <span style="font-size: 16px;">Cart</span>
</a></i>
<a class="active" href="addproductlist.php">
  <i class="fa fa-shopping-basket"style="font-size: 24px;"><br>
  <iconify-icon icon="ic:baseline-pending-actions" style="font-size: 24px;"></iconify-icon>
  <span style="font-size: 16px;">Lists</span>
</a></i>
<a class="active" href="profile.php">
  <i class="far fa-user-circle"style="font-size: 24px;"><br>
  <span style="font-size: 16px;">Profile</span>
</a></i>

</body>
</html>

