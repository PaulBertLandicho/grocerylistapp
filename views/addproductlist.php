
<?php
include 'dbconn.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login_page.php?error=Please login first");
    exit();
}

$user_id = $_SESSION['user_id'];

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 16;
$offset = ($page - 1) * $records_per_page;

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Updated SQL query with sorting, store search, and user filter
$sql = "SELECT * FROM Product WHERE user_id = ? AND (Name LIKE ? OR Brand LIKE ? OR Store LIKE ?) LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%$search%";
$stmt->bind_param("isssii", $user_id, $searchTerm, $searchTerm, $searchTerm, $offset, $records_per_page);
$stmt->execute();
$result = $stmt->get_result();

// Total records query updated to include user filter
$total_records_query = "SELECT COUNT(*) FROM Product WHERE user_id = ? AND (Name LIKE ? OR Brand LIKE ? OR Store LIKE ?)";
$total_stmt = $conn->prepare($total_records_query);
$total_stmt->bind_param("isss", $user_id, $searchTerm, $searchTerm, $searchTerm);
$total_stmt->execute();
$total_records = $total_stmt->get_result()->fetch_row()[0];

// Total pages
$total_pages = ceil($total_records / $records_per_page);

// Close statements
$stmt->close();
$total_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/addproductlist.css" />

</head>

<body>

    <!-- Header Navbar  -->
    <header class="navbar" style="width: auto;;" data-bs-theme="dark">
        <h1 style="font-weight: bold; font-size: 35px; margin-left: 10px;">Add Product</h1>
        <button class="menu-button">
            <i class="fa fa-align-justify" style="color: darkgreen; margin-right: 15px; transition: transform 0.3s ease;"></i>
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
    <button type="submit" class="btn btn-success" style="margin-left: 15px;">
        <i class="far fa-plus-square" id="addProductButton"> Add Product
</button></i>
        <div class="product-list">
            <div class="list-wrapper">
                <?php $foundProduct = false;?>
                    <?php while($product = $result->fetch_assoc()):
          $foundProduct = true;
          ?>
                        <div class="product-container" style="box-shadow: 0 2px 10px rgba(0, 0, 0, 100.2);">
                            <div class="product-image">
                                <img src="<?php echo $product['image']; ?>" alt="Product Image" style="width: 150px; height: 100px;">

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

                                                    <!-- Edit Icon -->
                                                    <a href="adminupdate_product_form.php?Id=<?= htmlspecialchars($product['id']); ?>" class="update-btn">
                                                        <i class="far fa-edit" style="font-size: 18px; margin-left: 90px;">
                    </a></i>
                                                        <!-- Delete Icon -->
                                                        <a href="delete.php?Id=<?= htmlspecialchars($product['id']); ?>" class="delete-btn">
                                                            <i class="fas fa-trash-alt" style="font-size: 17px;">
                    </a></i>


                                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                            <?php if (!$foundProduct): ?>
                                <div class="no-product-found">
                                    <image src="uploads/emptybag.png" style="margin-top: 40px;">
                                        <h3 style="text-align: center; opacity: 0.7; font-weight: bold; margin-top: 1em;">Your List is Empty.</h3>
                                </div>
                                <?php endif; ?>

            </div>
        </div>

            <!-- Icon-bar Navbar -->
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
                            <i class="fas fa-shopping-basket" style="font-size: 24px; color: maroon;"><br>
  <span style="font-size: 16px;">Add</span>
</a></i>
                            <a class="active" href="profile.php">
                                <i class="fas fa-user-circle" style="font-size: 24px;"><br>
  <span style="font-size: 16px;">Profile</span>
</a></i>
        </div>

        <!-- Modal Overlay -->
        <div id="modalOverlay" class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <button id="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800"></button>
                    <div class="modal-body">

                        <!-- Modal content here -->
                        <form action="add_product.php" method="POST" enctype="multipart/form-data">
                            <div class="product-imageModal">
                                <img id="avatarImage" src="uploads/product.jpg" style="width: 199px; height: 190px; cursor: pointer;">
                                <input type="file" id="profilePicture" name="image" onchange="previewProfilePicture(this);" style="display: none;">
                            </div>
                            <div class="mb-3">
                                <label for="productName" class="form-label">Product Name :</label>
                                <input type="text" class="form-control" id="productName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Product Price :</label>
                                <input type="text" class="form-control" id="productPrice" name="price" placeholder="₱" required>
                            </div>
                            <div class="mb-3">
                                <label for="productCategory" class="form-label">Select Category :</label>
                                <select id="productCategory" name="category_id" class="form-control" required>
                                    <option value="1">Fruits</option>
                                    <option value="2">Protein</option>
                                    <option value="3">Snack</option>
                                    <option value="4">Beverage</option>
                                    <option value="5">Seafood</option>
                                    <option value="6">Baking</option>
                                    <option value="7">Vegetables</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="brand" class="form-label">Product Brand :</label>
                                <input type="text" class="form-control" id="brand" name="brand" required>
                                <label for="store" class="form-label">Product Store :</label>
                                <input type="text" class="form-control" id="store" name="store" required>
                                <input type="text" step="" name="weight" placeholder="Weight/Volume">
                            </div>
                            <button type="submit" class="btn btn-primary">Add Product</button>
                            <button type="button" class="btn btn-secondary" id="cancelButton">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>


            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="js/addproductlist.js">
            </script>
            <script src="js/settingsdarkmode.js"></script>

</body>

</html>

