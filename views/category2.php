<?php
include 'dbconn.php';
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login_page.php?error=Please login first");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_assoc();

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 10;
$offset = ($page - 1) * $records_per_page;

// Search functionality
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$searchTerm = "%$search%"; // Search term for LIKE query

// Define the category ID dynamically, if needed
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 2; // Default category_id

// Query to retrieve products added by the logged-in user
$sql = "SELECT * FROM product 
        WHERE category_id = ? 
        AND user_id = ? 
        AND (name LIKE ? OR brand LIKE ? OR store LIKE ?) 
        LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisssii", $category_id, $user_id, $searchTerm, $searchTerm, $searchTerm, $offset, $records_per_page);
$stmt->execute();
$result = $stmt->get_result();

// Query to count total records for pagination
$total_records_query = "SELECT COUNT(*) FROM product 
                        WHERE category_id = ? 
                        AND user_id = ? 
                        AND (name LIKE ? OR brand LIKE ? OR store LIKE ?)";
$total_stmt = $conn->prepare($total_records_query);
$total_stmt->bind_param("iisss", $category_id, $user_id, $searchTerm, $searchTerm, $searchTerm);
$total_stmt->execute();
$total_records = $total_stmt->get_result()->fetch_row()[0];

// Calculate total pages
$total_pages = ceil($total_records / $records_per_page);

// Close statements
$stmt->close();
$total_stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Protein</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/user_dashboard.css">
</head>

<body>
    <header class="navbar"data-bs-theme="dark">
        <h1>Protein Shop</h1>
        <button class="menu-button">
            <i class="fa fa-align-justify" style="color: darkgreen; margin-right: 15px; transition: transform 0.3s ease;"></i>
        </button>

        <!-- Menu content with icons -->
        <div class="menu-content">
            <a href="javascript:void(0);" id="settings-link" title="Settings">
                <i class="fas fa-cog"><span style="margin-left: 10px;">Settings</span></i>
            </a>


            <a href="profile.php" title="Profile">
                <i class="fas fa-user"><span style="margin-left: 10px;">Profile</span></i>
            </a>
            <a href="javascript:void(0);" class="logout-link" onclick="document.getElementById('logout-form').submit();" title="Logout">
                <i class="fas fa-sign-out-alt"><span style="margin-left: 10px;">Logout</span></i>
            </a>
            <form id="logout-form" action="logout.php" method="POST" style="display: none;">
                <!-- Form is hidden but used to perform POST request -->
            </form>
        </div>
    </header>
    <div class="categories-bar">
        <div class="categories">
            <div class="category">
                <a href="user_dashboard.php">
                    <img id="category-img" src="uploads/box.png" alt="Home" />
                </a>
                <p class="icon-text">All</p>
            </div>
            <div class="category">
                <a href="category1.php">
                    <img id="category-img" src="uploads/fruit.png" alt="Home" />
                </a>
                <p class="icon-text">Fruits</p>
            </div>
            <div class="category">
                <a href="category2.php">
                    <img id="category-img" src="uploads/protein.png" alt="Home" />
                </a>
                <p class="icon-text" style="color: green; font-weight: bold; border-bottom: 2px solid green;">Protein</p>
            </div>
            <div class="category">
                <a href="category3.php">
                    <img id="category-img" src="uploads/snacks.png" alt="Home" />
                </a>
                <p class="icon-text">Snacks</p>
            </div>
            <div class="category">
                <a href="category4.php">
                    <img id="category-img" src="uploads/beverages.png" alt="Home" />
                </a>
                <p class="icon-text">Beverage</p>
            </div>
            <div class="category">
                <a href="category5.php">
                    <img id="category-img" src="uploads/seafood.png" alt="Home" />
                </a>
                <p class="icon-text">Seafoods</p>
            </div>
            <div class="category">
                <a href="category6.php">
                    <img id="category-img" src="https://cdn-icons-png.flaticon.com/256/6030/6030105.png" alt="Home" />
                </a>
                <p class="icon-text">Baking</p>
            </div>
            <div class="category">
                <a href="category7.php">
                    <img id="category-img" src="https://cdn.icon-icons.com/icons2/3277/PNG/512/salad_bowl_food_vegetables_vegan_healthy_food_icon_208011.png" alt="Home" />
                </a>
                <p class="icon-text">Vegetables</p>
            </div>
        </div>
    </div>
    <br>
    <center>
        <div class="search-box" style="width: 380px;">
            <form method="GET" action="" class="d-flex" id="search-form">
                <div class="search-icon-container">
                    <i class="fas fa-search"></i>
                </div>
                <input type="search" id="search-bar" name="search" class="form-control me-2" placeholder="Search for products..." aria-label="Search" value="<?php echo htmlspecialchars($search); ?>">
            </form>
        </div>
        </div>
        <div class="products-list-container">
            <div id="product-list">
                <?php
        $foundProduct = false; 
        while($product = $result->fetch_assoc()): 
            $foundProduct = true; // Set flag to true if a product is found
        ?>
                    <div class="product-container">
                        <div class="product" data-id="<?php echo $product['id']; ?>" data-name="<?php echo htmlspecialchars($product['name']); ?>" data-image="<?php echo htmlspecialchars($product['image']); ?>" data-price="<?php echo htmlspecialchars($product['price']); ?>"
                        data-status="<?php echo $product['purchased'] == 1 ? 'Purchased' : ($product['available'] == 1 ? 'Available' : 'Sold Out'); ?>" data-brand="<?php echo htmlspecialchars($product['brand']); ?>" data-weight="<?php echo htmlspecialchars($product['weight']); ?>"
                        data-store="<?php echo htmlspecialchars($product['store']); ?>" style="position: relative;">
                            <img src="<?php echo $product['image']; ?>" alt="Product Image" style="width: 340px; height: 190px; border-radius: 15px;">
                            <a href="javascript:void(0);" class="list-btn" data-product-id="<?php echo $product['id']; ?>">
    <i id="list-icon-<?php echo $product['id']; ?>" class="fas fa-list-alt"></i>
</a>

                            <a href="javascript:void(0);" class="details-btn" data-product-id="<?php echo $product['id']; ?>" style="position: absolute; bottom: 95px; left: 5px; padding: 85px 110px; border-radius: 5px; text-decoration: none; font-size: 14px;"></a>
                            <div class="product-actions">
                                <div class="product-name" style="color: black;">
                                    <?php echo $product['name']; ?>
                                </div>
                                <a href="javascript:void(0);" class="add-to-cart-btn" data-product-id="<?php echo $product['id']; ?>">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                            </div>
                            <div class="product-status">
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
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                        <?php if (!$foundProduct): ?>
                            <div class="no-product-found">
                                <image src="uploads/notfound.png" style="margin-top: 40px;">
                                    <h3 style="color: maroon; opacity: 0.7; margin-top: 2em;">Product not found</h3>
                            </div>
                            <?php endif; ?>
            </div>
        </div>
    </center>

    <div class="icon-bar">
        <a class="active" href="user_dashboard.php">
            <i class="fas fa-store-alt" style="font-size: 24px; color: maroon;"><br>
<span style="font-size: 16px;">Shop</span>
</a></i>
            <a class="active" href="my_shopping_list.php">
                <i class="fas fa-list-alt"><br>
  <span style="font-size: 16px;">Lists</span>
</a></i>
                <a class="active" href="cartlist.php">
                    <i class="fas fa-shopping-cart" style="font-size: 25px;"><br>
  <span style="font-size: 16px;">Cart</span>
</a></i>
                    <a class="active" href="addproductlist.php">
                        <i class="fas fa-shopping-basket"><br>
  <span style="font-size: 16px;">Add</span>
</a></i>
                        <a class="active" href="profile.php">
                            <i class="fas fa-user-circle" style="font-size: 24px;"><br>
  <span style="font-size: 16px;">Profile</span>
</a></i>
    </div>

    <!-- Modal Overlay -->
    <div id="product-modal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-product-image">
                <img id="modal-image" src="" alt="Product Image" style="height: 170px;">
            </div>
            <h2 id="modal-product-name" style="font-weight: bold; font-size: 35px; color: maroon;"></h2>
            <div class="modal-product-details">
                <p style="font-weight: bold; color: darkgreen">Price:
                    <span id="modal-product-price" style="color: black;"></span>
                </p>
                <p style="font-weight: bold; color: darkgreen;">Brand:
                    <span id="modal-product-brand" style="color: black;"></span>
                </p>
                <p style="font-weight: bold; color: darkgreen;">Weight/Volume:
                    <span id="modal-product-weight" style="color: black;"></span>
                </p>
                <p style="font-weight: bold; color: darkgreen;">Volume:
                    <span id="modal-product-volume" style="color: black;"></span>
                </p>
                <p style="font-weight: bold; color: darkgreen;">Store:
                    <span id="modal-product-store" style="color: black;"></span>
                </p>
                <!-- Status section -->
                <p id="modal-product-status" style="font-weight: bold;">
                </p>
                <p>
                    <i class="fas fa-calendar-day" style="color: maroon;" id="calendar-icon"></i>
                    <span id="modal-current-date" style="color: black;"></span>
                </p>
            </div>
        </div>
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/user_dashboard.js">
    </script>
    <script src="js/settingsdarkmode.js"></script>

</body>

</html>