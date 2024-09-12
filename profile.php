<?php
    include 'dbconn.php';
    session_start();

    if ( !isset($_SESSION['user_id'])) {
      header("Location: user_login_page.php?error=Please login first");
      exit();
    }	

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM user WHERE id='$user_id'";
    $result = $conn->query($sql);
    $users = $result->fetch_assoc();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Handle form data here
      // Update user profile data in the database
      // Redirect user to profile page after updating
      $username = $_POST['username'];

  }

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
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
<header class="navbar nowrap p-0 shadow" style="height: 150px; border: none; background-color: darkgreen;" data-bs-theme="dark">
<center><p style="color: white; font-size: 50px; font-weight: bold; margin-top: 5px; margin-left:110px;  text-align: center;">PROFILE</p>
<div class="product-imageModal">
            <img id="avatarImage" src="uploads/defaultprofile.jpg" style="width: 199px; height: 190px; margin-left: 110px; border-radius: 50%;" onclick="document.getElementById('profilePicture').click();" />
          </div>
<div class="container">
    <p style="color: maroon; font-size: 25px; margin-left:115px; margin-top: 15px; text-items: center;"><?php echo $users['username']; ?></p>
</div>
</header>
</center>

<div class="box" >
  <a href="user_dashboard.php" style="text-decoration: none; display: flex; align-items: center; margin-bottom:30px;">
    <span class="fas fa-store-alt" style="background-color: maroon; color: white; border-radius: 50%; padding: 13px;"></span>
    <span style="color: black; margin-left: 15px;">Dashboard</span>
</a>
<a href="Orderhistory.php" style="text-decoration: none; display: flex; align-items: center; margin-bottom:30px;">
    <span class="fa fa-shopping-basket" style="background-color: maroon; color: white; border-radius: 50%; padding: 13px;"></span>
    <span style="color: black; margin-left: 15px;">Order&nbsp;History</span>
</a>
<a href="about.php" style="text-decoration: none; display: flex; align-items: center; margin-bottom:30px;">
    <span class="fa fa-info-circle" style="background-color: maroon; color: white; border-radius: 50%; padding: 15px;"></span>
    <span style="color: black; margin-left: 15px;">About</span>
</a> 
<a href="loginpage.php" style="text-decoration: none; display: flex; align-items: center;">
    <span class="fa fa-sign-out" style="background-color: maroon; color: white; border-radius: 50%; padding: 15px;"></span>
    <span style="color: black; margin-left: 15px;">Logout</span>
</a>  
  </div>
  </div>
  </div>

  <div class="icon-bar" >
 <a class="active" href="user_dashboard.php">
 <i class="fas fa-store-alt" style="font-size: 25px;"><br>
<span style="font-size: 16px;">Home</span>
</a></i>
<a class="active" href="Myfavorite.php">
  <i class="fas fa-heart"><br>
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
  <i class="far fa-user-circle" style="font-size: 25px; color: maroon"><br>
  <span style="font-size: 16px;">Profile</span>
</a></i>


</body>
</html>