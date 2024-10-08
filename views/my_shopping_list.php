<?php
include 'dbconn.php';
session_start();

$user_id = $_SESSION['user_id'];

// Retrieve the search input from the query string, if it exists
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Sanitize the search input to prevent SQL injection
$search_query = $conn->real_escape_string($search_query);

// Determine sorting criteria
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'name'; // default to sorting by name
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'ASC'; // default to ascending order

// Construct the SQL query with a search filter and sorting to include product brand
$sql = "SELECT p.* 
        FROM my_addlist f 
        INNER JOIN product p ON f.product_id = p.id 
        WHERE f.user_id = $user_id 
        AND (p.name LIKE '%$search_query%' OR p.brand LIKE '%$search_query%' OR p.store LIKE '%$search_query%')
        ORDER BY 
            CASE 
                WHEN '$sort_by' = 'name' THEN p.name
                WHEN '$sort_by' = 'price' THEN p.price
            END $sort_order";

$result = $conn->query($sql);

// Fetch user data
$user_sql = "SELECT username FROM user WHERE id = $user_id";
$user_result = $conn->query($user_sql);

if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
} else {
    $user = ['username' => 'Guest']; // Fallback if no user found
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/addproductlist.css" />

</head>

<body>

    <!-- Header Navbar  -->
<header class="navbar" style="width: auto;" data-bs-theme="dark" id="navbar">
    <h2 id="greeting" style="font-weight: bold; margin-left: 10px;">Hello! <?php echo htmlspecialchars($user['username']); ?> </h2>


        <button class="menu-button">    
            <i class="fa fa-align-justify" style="color: darkgreen; margin-right: 15px; transition: transform 0.3s ease;"></i>
        </button>

        <!-- Menu content with icons -->
        <div class="menu-content">
            <a href="cartlist.php" title="Profile">
                <i class="fas fa-shopping-cart" style="color: darkgreen; font-size: 20px;"><span style="margin-left: 10px;">Cart</span></i>
            </a>
            <a href="profile.php" title="Profile">
                <i class="fas fa-user" style="color: darkgreen; font-size: 20px;"><span style="margin-left: 10px;">Profile</span></i>
            </a>
            <a href="javascript:void(0);" id="settings-link" title="Settings">
                <i class="fas fa-cog" style="color: darkgreen; font-size: 20px;"><span style="margin-left: 10px;">Settings</span></i>
            </a>
            <a href="javascript:void(0);" class="logout-link" onclick="document.getElementById('logout-form').submit();" title="Logout">
                <i class="fas fa-sign-out-alt" style="font-size: 20px; color: darkgreen;"><span style="margin-left: 10px;">Logout</span></i>
            </a>
            <form id="logout-form" action="logout.php" method="POST" style="display: none;">
                <!-- Form is hidden but used to perform POST request -->
            </form>
        </div>
    </header>

    <!-- Settings Modal -->
    <div id="settings-modal" class="settings-overlay" style="display: none;">
        <div class="modal-box">
            <span class="close-modal" id="close-settings-modal">&times;</span>
            <h2 style="color: maroon;">Settings</h2>
            <div class="settings-option">
                <label for="theme-toggle" style="color: black;">Dark Mode</label>
                <input type="checkbox" id="theme-toggle">
            </div>
        </div>
    </div>

    <!-- Search-Bar -->
    <div class="search-form">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search...">
            <button type="submit" class="search-button">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    <h1 style="font-weight: bold; font-size: 30px; text-align: center; color: darkgreen; margin-left: 10px;">My Shopping List</h1>
   
    <!-- Sorting Option -->
    <div class="sort-options">
        <form action="" method="GET" class="d-flex">
        <div class="form-group me-2">
            <select name="sort" onchange="this.form.submit()">
                <option value="name" <?php if ($sort_by == 'name') echo 'selected'; ?>>Sort by Name</option>
                <option value="category" <?php if ($sort_by == 'category') echo 'selected'; ?>>Sort by Category</option>
                <option value="price" <?php if ($sort_by == 'price') echo 'selected'; ?>>Sort by Price</option>
                <option value="store" <?php if ($sort_by == 'store') echo 'selected'; ?>>Sort by Store</option>
            </select>
            </div>
        </form>
    </div>

     <!-- Poduct-list Container -->
   <div class="product-list">
        <div class="list-wrapper">
            <?php $foundProduct = false;?>
                <?php while($product = $result->fetch_assoc()):
          $foundProduct = true;
          ?>
                    <div class="product-container" style="box-shadow: 0 2px 10px rgba(0, 0, 0, 100.2);">
                        <div class="product-image">
                            <img src="<?php echo $product['image']; ?>" alt="Product Image" style="width: 150px; height: 100px;">
                            <a href="javascript:void(0);" class="cart-btn" data-product-id="<?php echo $product['id']; ?>">
    <i id="cart-icon-<?php echo $product['id']; ?>" class="fas fa-shopping-cart" style="color:black; position: absolute; top: 10px; right: 10px; font-size: 25px; background-color: white; border-radius: 50%; padding: 5px;"></i>
</a>
                        </div>
                        <div class="product-details">
                            <?php if ($product['purchased'] == 1): ?>
                                <span style="color: blue;">
                            <i class="fas fa-check"></i> Purchased
                        </span>
                                <?php elseif ($product['available'] == 1): ?>
                                    <span style="color: green;">
                            <i class="fas fa-check-circle"></i> Available
                        </span>
                                    <?php else: ?>
                                        <span style="color: red;">
                            <i class="fas fa-times-circle"></i> Sold Out
                        </span>
                                        <?php endif; ?>
                                            <div class="product-name" style="font-weight: bold; color: maroon;">
                                                <?php echo $product['name']; ?>
                                            </div>
                                            <div class="product-price" style="font-size: 20px; font-weight: bold; color: black;">₱
                                                <?php echo $product['price']; ?>
                                                    <span class="product-weight" style="margin-left: 20px;font-size: 10px; color: black;"> <?php echo $product['weight']; ?></span></div>
                                            <div class="product-actions">

                                                <!-- Delete Icon -->
                                                <form action='remove_addlist.php' method='post'>
                               <input type='hidden' name='product_id' value='<?php echo htmlspecialchars($product['id']); ?>'>
                                  <button type="submit" class='button-white' style='border: none; background-color: transparent;'>
                                         <i class="fas fa-trash-alt" style="font-size: 17px; color: maroon; margin-right: 10px;"></i>
                                     </button>

                                              <!-- Mark as Purchased Button -->
                                      <?php if ($product['purchased'] == 0): ?>
                                  <a href="mark_as_purchased.php?id=<?= htmlspecialchars($product['id']); ?>" class="btn btn-warning" style="font-size: 15px;">
                              <i class="fas fa-check"></i>
                            </a>
                        <?php else: ?>
                <?php endif; ?>
                
                     <!-- Share Icon -->
                     <a href="mailto:?subject=Check out this product&body=I found this product that might interest you:%0A%0AName: <?= urlencode($product['name']); ?>%0APrice: <?= urlencode($product['price']); ?>%0AWeight: <?= urlencode($product['weight']); ?>%0A%0AHere is the link to the product: [Insert URL here]" class="share-btn" title="Share via Email">
                        <i class="fas fa-share" style="position: absolute; top: 200px; right: 8px; text-decoration: none; color: inherit; font-size: 20px;">
                    </a></i>
                    </form>
                  </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                        <?php if (!$foundProduct): ?>

                            <!-- no-product-found -->
                            <div class="no-product-found">
                                <image src="uploads/emptybag.png" style="margin-top: 40px;">
                                    <h3 style="text-align: center; opacity: 0.7; font-weight: bold; margin-top:50px;">Your List is Empty.</h3>
                            </div>
                            <?php endif; ?>
        </div>
    </div>

    <!-- addProductButton -->
    <form action="user_dashboard.php" method="GET">
        <button type="submit" class="btn btn-success" style="margin-left: 30px; padding: 15px; border-radius: 20px; margin-bottom: 5px; width: 350px;">
            <i class="far fa-plus-square" id="addProductButton"> Add List </i>
        </button>
    </form>
    </div>





    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/addproductlist.js">
    </script>
    <script src="js/settingsdarkmode.js"></script>

</body>

</html>
