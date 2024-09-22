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
        <center>
            <p style="color: white; font-size: 50px; font-weight: bold; margin-top: 5px; margin-left:110px; text-align: center;">PROFILE</p>
            <div class="product-imageModal">
                <!-- Display the user profile picture -->
                <img id="avatarImage" src="uploads/<?php echo htmlspecialchars($users['profile_picture']); ?>" style="width: 199px; height: 190px; margin-left: 110px; border-radius: 50%;" />
            </div>
            <div class="container">
                <p style="font-weight: bold; font-size: 25px; margin-left:115px; margin-top: 15px; text-items: center;">
                    <?php echo htmlspecialchars($users['username']); ?>
                </p>
            </div>
        </center>
    </header>

    <!-- Form for uploading the profile picture -->
    <form id="upload-form" action="upload_profile_picture.php" method="POST" enctype="multipart/form-data" style="display: none;">
        <input type="file" id="profilePicture" name="profile_picture" accept="image/*" onchange="document.getElementById('upload-form').submit();">
    </form>
    </center>


    <div class="box">
        <a href="user_dashboard.php" style="text-decoration: none; display: flex; align-items: center; font-weight: bold; margin-bottom:30px;">
            <span class="fas fa-store-alt" style="background-color: maroon; color: white; border-radius: 50%; padding: 13px;"></span>
            <span style="color: white; margin-left: 15px; text-shadow: 0 2px 10px rgba(0,0,0,2.1);">Grocery Shop</span>
        </a>
        <a href="addproductlist.php" style="text-decoration: none; display: flex; align-items: center; font-weight: bold; margin-bottom:30px;">
            <span class="fa fa-shopping-basket" style="background-color: maroon; color: white; border-radius: 50%; padding: 13px;"></span>
            <span style="color: white; margin-left: 15px; text-shadow: 0 2px 10px rgba(0,0,0,2.1);">Add Product</span>
        </a>
        <a href="my_shopping_list.php" style="text-decoration: none; display: flex; align-items: center; font-weight: bold; margin-bottom:30px;">
            <span class="fas fa-list-alt" style="background-color: maroon; color: white; border-radius: 50%; padding: 15px;"></span>
            <span style="color: white; margin-left: 15px; text-shadow: 0 2px 10px rgba(0,0,0,2.1);">My Shopping List</span>
        </a>
        <a href="javascript:void(0);" class="logout-link" onclick="document.getElementById('logout-form').submit();" title="Logout" style="text-decoration: none; display: flex; align-items: center;">
            <span class="fa fa-sign-out" style="background-color: maroon; color: white;  border-radius: 50%; padding: 15px;"></span>
            <span style="color: white; margin-left: 15px; font-weight: bold; text-shadow: 0 2px 10px rgba(0,0,0,2.1);">Logout</span>
        </a>
        <form id="logout-form" action="logout.php" method="POST" style="display: none;">
            <!-- Form is hidden but used to perform POST request -->
        </form>
    </div>
    </div>
    </div>

    <div class="icon-bar">
        <a class="active" href="user_dashboard.php">
            <i class="fas fa-store-alt"><br>
<span style="font-size: 16px;">Shop</span>
</a></i>
            <a class="active" href="my_shopping_list.php">
                <i class="fas fa-list-alt"><br>
  <span style="font-size: 16px;">Lists</span>
</a></i>
                <a class="active" href="cartlist.php">
                    <i class="fas fa-shopping-cart"><br>
  <span style="font-size: 16px;">Cart</span>
</a></i>
                    <a class="active" href="addproductlist.php">
                        <i class="fas fa-shopping-basket"><br>
  <span style="font-size: 16px;">Add</span>
</a></i>
                        <a class="active">
                            <button class="menu-button">
                                <i class="fa fa-align-justify" style="color: maroon; font-size: 40px; margin-right: 15px; transition: transform 0.3s ease;"></i>
                            </button>

                            <!-- Menu content with icons -->
                            <div class="menu-content">
                                <a href="javascript:void(0);" id="settings-link" title="Settings">
                                    <i class="fas fa-cog" style="color: darkgreen; font-size: 20px;"><span style="margin-left: 10px;">Settings</span></i>
                                </a>


                                <a href="profile.php" title="Profile">
                                    <i class="fas fa-user" style="color: darkgreen; font-size: 20px;"><span style="margin-left: 10px;">Profile</span></i>
                                </a>
                                <a href="javascript:void(0);" class="logout-link" onclick="document.getElementById('logout-form').submit();" title="Logout">
                                    <i class="fas fa-sign-out-alt" style="font-size: 20px; color: darkgreen;"><span style="margin-left: 10px;">Logout</span></i>
                                </a>
                                <form id="logout-form" action="logout.php" method="POST" style="display: none;">
                                    <!-- Form is hidden but used to perform POST request -->
                                </form>
                            </div>
                        </a>
                        </i>
    </div>

    <!-- Settings Modal -->
    <div id="settings-modal" class="modal-overlay" style="display: none;">
        <div class="modal-box">
            <span class="close-modal" id="close-settings-modal">&times;</span>
            <h2 style="color: maroon;">Settings</h2>
            <div class="settings-option">
                <label for="theme-toggle" style="color: black;">Dark Mode</label>
                <input type="checkbox" id="theme-toggle">
            </div>
        </div>
    </div>

    <script src="js/settingsdarkmode.js"></script>

</body>

</html>
