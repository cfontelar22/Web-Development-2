<?php
// Check session status and start if needed
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Include the database connection file
include("connect.php");


// Check if the admin is logged in and the username is stored in the session
if (isset($_SESSION['username'])) {
    // Get the admin's username from the session
    $adminUsername = $_SESSION['username'];
} else {
    // Redirect to the login page if the admin is not logged in
    header("Location: admin_dashboard.php"); 
    exit();
}

// Function to validate and sanitize numeric inputs
function sanitizeAndValidateNumeric($value) {
    return filter_var($value, FILTER_VALIDATE_INT, array('options' => array('min_range' => 1))) ?: null;
}

// Function to sanitize strings
function sanitizeString($input) {
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

// Function to fetch all categories from the database
function fetchAllCategories($db) {
    $categoryFetchSql = "SELECT category_id, name, category_description FROM categories";
    $categoryFetchStmt = $db->query($categoryFetchSql);
    return $categoryFetchStmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to fetch all products from the database
function fetchAllProducts($db) {
    $productFetchSql = "SELECT product_id, name, description, price, stock_quantity, category_id FROM products";
    $productFetchStmt = $db->query($productFetchSql);
    return $productFetchStmt->fetchAll(PDO::FETCH_ASSOC);
}


// Function to handle category creation
function createCategory($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $categoryName = isset($_POST['category_name']) ? sanitizeString($_POST['category_name']) : '';
        $categoryDescription = isset($_POST['category_description']) ? sanitizeString($_POST['category_description']) : '';
        $insertCategorySql = "INSERT INTO categories (name, category_description) VALUES (:name, :category_description)";
        $insertCategoryStmt = $db->prepare($insertCategorySql);
        $insertCategoryStmt->bindParam(':name', $categoryName);
        $insertCategoryStmt->bindParam(':category_description', $categoryDescription);

        if ($insertCategoryStmt->execute()) {
            echo "Category added successfully!";
        } else {
            echo "Error adding category: " . implode(", ", $insertCategoryStmt->errorInfo());
        }
    }
}

// Function to handle category update
function updateCategory($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['form_action'] === 'update_category') {
        $categoryId = isset($_POST['category_id']) ? sanitizeAndValidateNumeric($_POST['category_id']) : 0;
        $categoryName = isset($_POST['updated_category_name']) ? sanitizeString($_POST['updated_category_name']) : '';
        $categoryDescription = isset($_POST['updated_category_description']) ? sanitizeString($_POST['updated_category_description']) : '';
        
        $updateCategorySql = "UPDATE categories SET name = :name, category_description = :category_description WHERE category_id = :category_id";
        $updateCategoryStmt = $db->prepare($updateCategorySql);
        $updateCategoryStmt->bindParam(':category_id', $categoryId);
        $updateCategoryStmt->bindParam(':name', $categoryName);
        $updateCategoryStmt->bindParam(':category_description', $categoryDescription);

        if ($updateCategoryStmt->execute()) {
            echo "Category updated successfully!";
        } else {
            echo "Error updating category: " . implode(", ", $updateCategoryStmt->errorInfo());
        }
    }
}

// Function to handle category deletion
function deleteCategory($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $categoryId = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;

        $deleteCategorySql = "DELETE FROM categories WHERE category_id = :category_id";
        $deleteCategoryStmt = $db->prepare($deleteCategorySql);
        $deleteCategoryStmt->bindParam(':category_id', $categoryId);

        if ($deleteCategoryStmt->execute()) {
            echo "Category deleted successfully!";
        } else {
            echo "Error deleting category: " . implode(", ", $deleteCategoryStmt->errorInfo());
        }
    }
}



// Function to handle product creation
function createProduct($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productName = isset($_POST['product_name']) ? sanitizeString($_POST['product_name']) : '';
        $productDescription = isset($_POST['product_description']) ? sanitizeString($_POST['product_description']) : '';
        $productPrice = isset($_POST['product_price']) ? floatval($_POST['product_price']) : 0.0;
        $categoryID = isset($_POST['category_id']) ? sanitizeAndValidateNumeric($_POST['category_id']) : 0;
        $stockQuantity = isset($_POST['stock_quantity']) ? sanitizeAndValidateNumeric($_POST['stock_quantity']) : 0;

        $insertProductSql = "INSERT INTO products (name, description, price, category_id, stock_quantity) VALUES (:name, :description, :price, :category_id, :stock_quantity)";
        $insertProductStmt = $db->prepare($insertProductSql);
        $insertProductStmt->bindParam(':name', $productName);
        $insertProductStmt->bindParam(':description', $productDescription);
        $insertProductStmt->bindParam(':price', $productPrice);
        $insertProductStmt->bindParam(':category_id', $categoryID);
        $insertProductStmt->bindParam(':stock_quantity', $stockQuantity);

        if ($insertProductStmt->execute()) {
            echo "Product added successfully!";
        } else {
            echo "Error adding product.";
        }
    }
}

// Function to handle product update
function updateProduct($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['form_action'] === 'update_product') {
        $productId = isset($_POST['product_id']) ? sanitizeAndValidateNumeric($_POST['product_id']) : 0;
        $productName = isset($_POST['updated_product_name']) ? sanitizeString($_POST['updated_product_name']) : '';
        $productDescription = isset($_POST['updated_product_description']) ? sanitizeString($_POST['updated_product_description']) : '';
        $productPrice = isset($_POST['updated_product_price']) ? floatval($_POST['updated_product_price']) : 0.0;
        $stockQuantity = isset($_POST['updated_stock_quantity']) ? sanitizeAndValidateNumeric($_POST['updated_stock_quantity']) : 0;
        $categoryId = isset($_POST['updated_category_id']) ? sanitizeAndValidateNumeric($_POST['updated_category_id']) : 0;

        $updateProductSql = "UPDATE products SET name = :name, description = :description, price = :price, stock_quantity = :stock_quantity, category_id = :category_id WHERE product_id = :product_id";
        $updateProductStmt = $db->prepare($updateProductSql);
        $updateProductStmt->bindParam(':product_id', $productId);
        $updateProductStmt->bindParam(':name', $productName);
        $updateProductStmt->bindParam(':description', $productDescription);
        $updateProductStmt->bindParam(':price', $productPrice);
        $updateProductStmt->bindParam(':stock_quantity', $stockQuantity);
        $updateProductStmt->bindParam(':category_id', $categoryId);

        if ($updateProductStmt->execute()) {
            echo "Product updated successfully!";
        } else {
            echo "Error updating product: " . implode(", ", $updateProductStmt->errorInfo());
        }
    }
}


// Function to handle product deletion
function deleteProduct($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productId = isset($_POST['product_id']) ? sanitizeAndValidateNumeric($_POST['product_id']) : 0;

        $deleteProductSql = "DELETE FROM products WHERE product_id = :product_id";
        $deleteProductStmt = $db->prepare($deleteProductSql);
        $deleteProductStmt->bindParam(':product_id', $productId);

        if ($deleteProductStmt->execute()) {
            echo "Product deleted successfully!";
        } else {
            echo "Error deleting product.";
        }
    }
}



// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formAction = isset($_POST['form_action']) ? $_POST['form_action'] : '';

    // Handle category creation
    if ($formAction === 'create_category') {
        createCategory($db);
    }

    // Handle category update
    elseif ($formAction === 'update_category') {
        updateCategory($db);
    }

    // Handle category deletion
    elseif ($formAction === 'delete_category') {
        deleteCategory($db);
    }

    // Handle product creation
    elseif ($formAction === 'create_product') {
        createProduct($db);
    }

    // Handle product update
    elseif ($formAction === 'update_product') {
        updateProduct($db);
    }

    // Handle product deletion
    elseif ($formAction === 'delete_product') {
        deleteProduct($db);
    }
}

// Fetch all categories
$categories = fetchAllCategories($db);

// Fetch all products
$products = fetchAllProducts($db);

// Extracting sorting parameters from the URL
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'name';
$sortDir = isset($_GET['sort_dir']) ? strtoupper($_GET['sort_dir']) : 'ASC';

// Extracting sorting parameters from the URL
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'name';
$sortDir = isset($_GET['sort_dir']) ? strtoupper($_GET['sort_dir']) : 'ASC';

// Function to fetch all products from the database with sorting
function fetchAllProductsWithSorting($db, $sortBy, $sortDir) {
    $validSortColumns = ['name', 'price', 'stock_quantity'];
    $sortBy = in_array($sortBy, $validSortColumns) ? $sortBy : 'name';  // Change default to 'name'
    $sortDir = $sortDir === 'DESC' ? 'DESC' : 'ASC';

    $productFetchSql = "SELECT product_id, name, description, price, stock_quantity, created_at, updated_at, category_id FROM products ORDER BY $sortBy $sortDir";
    $productFetchStmt = $db->query($productFetchSql);
    return $productFetchStmt->fetchAll(PDO::FETCH_ASSOC);
}


// Fetch products with sorting
$products = fetchAllProductsWithSorting($db, $sortBy, $sortDir);


// Function to fetch product comments by product ID with user information
function fetchProductCommentsWithUserInfo($db, $productId) {
    $commentsFetchSql = "SELECT c.*, u.username as user_username FROM comments c
                        LEFT JOIN users u ON c.username = u.id
                        WHERE c.product_id = :product_id";
    $commentsFetchStmt = $db->prepare($commentsFetchSql);
    $commentsFetchStmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
    $commentsFetchStmt->execute();
    return $commentsFetchStmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to insert a comment for a specific product
function insertCommentForProduct($db, $productId, $userId, $comment) {
    $insertCommentSql = "INSERT INTO comments (product_id, username, comment_id), VALUES (:product_id, :username, :comment_id)";
    $insertCommentStmt = $db->prepare($insertCommentSql);
    $insertCommentStmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
    $insertCommentStmt->bindParam(':username', $userId);
    $insertCommentStmt->bindParam(':comment_id', $comment);

    return $insertCommentStmt->execute();
}


// Function to fetch all comments from the database
function fetchAllComments($db) {
    $commentFetchSql = "SELECT * FROM comments";
    $commentFetchStmt = $db->query($commentFetchSql);
    return $commentFetchStmt->fetchAll(PDO::FETCH_ASSOC);
}


// Function to handle user update
function updateUser($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['form_action'] === 'update_user') {
        $userId = isset($_POST['user_id']) ? sanitizeAndValidateNumeric($_POST['user_id']) : 0;
        $username = isset($_POST['updated_username']) ? sanitizeString($_POST['updated_username']) : '';
        $password = isset($_POST['updated_password']) ? password_hash($_POST['updated_password'], PASSWORD_DEFAULT) : ''; // Hash the updated password

        $updateUserSql = "UPDATE users SET username = :username, password = :password WHERE user_id = :user_id";
        $updateUserStmt = $db->prepare($updateUserSql);
        $updateUserStmt->bindParam(':user_id', $userId);
        $updateUserStmt->bindParam(':username', $username);
        $updateUserStmt->bindParam(':password', $password);

        if ($updateUserStmt->execute()) {
            echo "User updated successfully!";
        } else {
            echo "Error updating user.";
        }
    }
}

// Function to handle user deletion
function deleteUser($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['form_action'] === 'delete_user') {
        $userId = isset($_POST['user_id']) ? sanitizeAndValidateNumeric($_POST['user_id']) : 0;

        $deleteUserSql = "DELETE FROM users WHERE user_id = :user_id";
        $deleteUserStmt = $db->prepare($deleteUserSql);
        $deleteUserStmt->bindParam(':user_id', $userId);

        if ($deleteUserStmt->execute()) {
            echo "User deleted successfully!";
        } else {
            echo "Error deleting user.";
        }
    }
}

// Function to handle user creation

function createUser($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['form_action'] === 'create_user') {
        $username = isset($_POST['new_username']) ? sanitizeString($_POST['new_username']) : '';
        $password = isset($_POST['new_password']) ? password_hash($_POST['new_password'], PASSWORD_DEFAULT) : '';
        $email = isset($_POST['new_email']) ? sanitizeString($_POST['new_email']) : '';
        $role = isset($_POST['new_role']) ? sanitizeString($_POST['new_role']) : '';

        $createUserSql = "INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)";
        $createUserStmt = $db->prepare($createUserSql);
        $createUserStmt->bindParam(':username', $username);
        $createUserStmt->bindParam(':password', $password);
        $createUserStmt->bindParam(':email', $email);
        $createUserStmt->bindParam(':role', $role);

        if ($createUserStmt->execute()) {
            echo "User created successfully!";
        } else {
            echo "Error creating user.";
        }
    }
}


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formAction = isset($_POST['form_action']) ? $_POST['form_action'] : '';

    // Handle user creation
    if ($formAction === 'create_user') {
        createUser($db);
    }

    // Handle user update
    elseif ($formAction === 'update_user') {
        updateUser($db);
    }

    // Handle user deletion
    elseif ($formAction === 'delete_user') {
        deleteUser($db);
    }
}

// Function to fetch all users from the database
function fetchAllUsers($db) {
    $userFetchSql = "SELECT user_id, username, password FROM users"; 
    $userFetchStmt = $db->query($userFetchSql);
    return $userFetchStmt->fetchAll(PDO::FETCH_ASSOC);
}


// Fetch all users
$users = fetchAllUsers($db);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LBG E-COM AND SMART SOLUTIONS</title>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>

     <!-- Search Container -->
     <div class="search-container">
        <div class="search-input-container">
            <input type="text" id="search" name="search" placeholder="SEARCH BY CATEGORY">
            <button type="button" onclick="searchProducts()">
                <img src="images/icon.png" alt="Search" class="search-button-icon">
            </button>
        </div>
    </div>

    <div class="user-signin-container">
        <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            // Display user information or logout link
            // Display user information or logout link
echo '<div class="user-dropdown">
<span id="signin-link">
    Welcome, ' . sanitizeString($_SESSION['username']) . '!
</span>
<div class="dropdown-content">
    <a href="logout.php">Logout</a>
</div>
</div>';
        } else {
            // Display login and registration links
            echo '<div class="user-dropdown">
                    <a href="login.php" id="signin-link"> 
                        <img src="images/sign-in.png" alt="Sign In" class="dropbtn">
                    </a>
                    <div class="dropdown-content">
                        <a href="login.php">Sign In</a> <!-- Update the href here as well -->
                        <a href="registration.html">Register</a>
                    </div>
                </div>';
        }
        ?>

        <a href="addtocart.html">
            <img src="images/cart.png" alt="Cart" class="cart-icon">
        </a>
    </div>
</div>

<form id="login-form" action="login.php" method="post" style="display: none;">
    <input type="text" name="serveruser" placeholder="Username">
    <input type="password" name="fontelar" placeholder="Password">
    <button type="submit">Login</button>
</form>

<div id="header-separator"></div>
<header id="header" class="fixed-header">
    <a href="index.php">
        <img src="images/lbglogo.png" alt="Logo" class="logo">
    </a>
    
    <nav id="navigation">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li class="dropdown">
                <a href="#">Solutions</a>
                <div class="dropdown-content">
                    <a href="solutions.html">Security Solutions</a>
                    <a href="solutions.html">Network Solutions</a>
                    <a href="solutions.html">ICT Infrastructure</a>
                </div>
            </li>
            <li><a href="#">Events</a></li>
            <li><a href="#">Jobs</a></li>
            <li><a href="#">Contact Us</a></li>
            <!-- Add the new list item for Admin Register -->
            <li><a href="admin_register.php">Admin Register</a></li>
        </ul>
    </nav>
</header>

<div id="welcome-container">
    <h2>Welcome, <?= $adminUsername ?>!</h2>
    
 
    <a href="index.php">Go to Home</a>
</div>

    <h1>Admin Dashboard</h1>

    <!-- Category form -->
    <h1>Create, Update, and Delete Categories</h1>
    <form id="category_form" action="admin_dashboard.php" method="post">
        <label for="category_name">Category Name:</label>
        <input type="text" name="category_name" required>
        <label for="category_description">Category Description:</label>
        <input type="text" name="category_description">
        <input type="hidden" name="form_action" value="create_category">
        <button type="submit">Create Category</button>
    </form>

<!-- Display all categories -->
<h1>All Categories</h1>
<table border="1">
    <tr>
        <th>Category ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Action</th>
    </tr>
    <?php foreach ($categories as $category): ?>
        <tr>
            <td><?= $category['category_id'] ?></td>
            <td><?= $category['name'] ?></td>
            <td><?= $category['category_description'] ?></td>
            <td>
                <form action="admin_dashboard.php" method="post">
                    <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>">

                    <!-- Include input fields for updated category name and description -->
                    <label for="updated_category_name">Updated Name:</label>
                    <input type="text" name="updated_category_name" value="<?= $category['name'] ?>" required>
                    
                    <label for="updated_category_description">Updated Description:</label>
                    <input type="text" name="updated_category_description" value="<?= $category['category_description'] ?>">

                    <input type="hidden" name="form_action" value="update_category">
                    <button type="submit">Update</button>
                </form>
                <form action="admin_dashboard.php" method="post">
                    <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>">
                    <input type="hidden" name="form_action" value="delete_category">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

    <!-- Product form -->
    <h1>Create, Update, and Delete Products</h1>
<form id="product_form" action="admin_dashboard.php" method="post">
    <label for="product_name">Product Name:</label>
    <input type="text" name="product_name" required>
    <label for="product_description">Product Description:</label>
    <input type="text" name="product_description">
    <label for="product_price">Product Price:</label>
    <input type="number" name="product_price" step="0.01" required>
    <label for="stock_quantity">Stock Quantity:</label>
    <input type="number" name="stock_quantity" required>
    <input type="hidden" name="form_action" value="create_product">
    <label for="category_id">Category Name:</label>
    <select id="category_id" name="category_id" required>
        <!-- Populate this dropdown with categories from the database -->
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Create Product</button>
    
</form>

<!-- Display all products -->
<h1>All Products</h1>
<table border="1">
    <tr>
        <th>Product ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Stock Quantity</th>
        <th>Category ID</th>
        <th>Action</th>
    </tr>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?= $product['product_id'] ?></td>
            <td><?= $product['name'] ?></td>
            <td><?= $product['description'] ?></td>
            <td><?= $product['price'] ?></td>
            <td><?= $product['stock_quantity'] ?></td>
            <td><?= $product['category_id'] ?></td>

            <td>
                <form action="admin_dashboard.php" method="post">
                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

                    <!-- Include input fields for updated product information -->
                    <label for="updated_product_name">Updated Name:</label>
                    <input type="text" name="updated_product_name" value="<?= $product['name'] ?>" required>

                    <label for="updated_product_description">Updated Description:</label>
                    <input type="text" name="updated_product_description" value="<?= $product['description'] ?>">

                    <label for="updated_product_price">Updated Price:</label>
                    <input type="text" name="updated_product_price" value="<?= $product['price'] ?>">

                    <label for="updated_stock_quantity">Updated Stock Quantity:</label>
                    <input type="text" name="updated_stock_quantity" value="<?= $product['stock_quantity'] ?>">

                    <label for="updated_category_id">Updated Category ID:</label>
                    <input type="text" name="updated_category_id" value="<?= $product['category_id'] ?>">

                    <input type="hidden" name="form_action" value="update_product">
                    <button type="submit">Update</button>
                </form>
                <form action="admin_dashboard.php" method="post">
                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                    <input type="hidden" name="form_action" value="delete_product">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>


<h1>Product Listing</h1>

<!-- Sorting options -->
<p>Sort by:
    <a href="admin_dashboard.php?sort_by=name&sort_dir=<?= $sortBy === 'name' && $sortDir === 'asc' ? 'desc' : 'asc' ?>">Name</a> |
    <a href="admin_dashboard.php?sort_by=price&sort_dir=<?= $sortBy === 'price' && $sortDir === 'asc' ? 'desc' : 'asc' ?>">Price</a> |
    <a href="admin_dashboard.php?sort_by=stock_quantity&sort_dir=<?= $sortBy === 'stock_quantity' && $sortDir === 'asc' ? 'desc' : 'asc' ?>">Stock Quantity</a>
</p>


<!-- Display all products with sorting -->
<table border="1">
    <tr>
        <th>Product ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Stock Quantity</th>
        <th>Category ID</th>
    </tr>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?= $product['product_id'] ?></td>
            <td><?= $product['name'] ?></td>
            <td><?= $product['description'] ?></td>
            <td><?= $product['price'] ?></td>
            <td><?= $product['stock_quantity'] ?></td>
            <td><?= $product['category_id'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h1>All Comments</h1>
<table border="1">
    <tr>
        <th>Comment ID</th>
        <th>Product ID</th>
        <th>Username</th>
        <th>Comment Text</th>
        <th>Created At</th>
    </tr>
    <?php
    // Fetch all comments
    $comments = fetchAllComments($db);

    // Display comments in a table
    foreach ($comments as $comment) {
        echo '<tr>';
        echo '<td>' . $comment['comment_id'] . '</td>';
        echo '<td>' . $comment['product_id'] . '</td>';
        echo '<td>' . $comment['username'] . '</td>';
        echo '<td>' . $comment['comment'] . '</td>';
        echo '<td>' . $comment['created_at'] . '</td>';
        echo '</tr>';
    }
    ?>
</table>

<!-- User Management Section -->
<h1>User Management</h1>

<!-- User form -->
<h2>Create, Update, and Delete Users</h2>

<form action="admin_dashboard.php" method="post">
    <label for="new_username">New Username:</label>
    <input type="text" name="new_username" required>

    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" required>

    <label for="new_email">New Email:</label>
    <input type="text" name="new_email" required>

    <label for="new_role">New Role:</label>
    <input type="text" name="new_role" required>

    <input type="hidden" name="form_action" value="create_user">
    <button type="submit">Create User</button>
</form>


<!-- Display all users -->

<h2>All Users</h2>
<table border="1">
    <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Action</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['user_id'] ?></td>
            <td><?= $user['username'] ?></td>
            <td>
                <form action="admin_dashboard.php" method="post">
                    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">

                    <!-- Include input fields for updated user information -->
                    <label for="updated_username">Updated Username:</label>
                    <input type="text" name="updated_username" value="<?= $user['username'] ?>" required>

                    <label for="updated_password">Updated Password:</label>
                    <input type="password" name="updated_password" value="" required>


                    <input type="hidden" name="form_action" value="update_user">
                    <button type="submit">Update</button>
                </form>
                <form action="admin_dashboard.php" method="post">
                    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                    <input type="hidden" name="form_action" value="delete_user">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>



<footer id="footer">
    <div class="footer-division">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#">Careers</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Contact Us</a></li>
        </ul>
    </div>
    <div class="footer-division">
        <h3>Solutions</h3>
        <ul>
            <li><a href="solutions.html">Security Solutions</a></li>
            <li><a href="solutions.html">Network Solutions</a></li>
            <li><a href="solutions.html">ICT Infrastructure</a></li>
        </ul>
    </div>
    <div class="footer-division">
        <a href="index.php">
            <div><img src="images/lbglogo.png" alt="Logo" class="logo">
                <p>© Copyright Jay Fontelar<br>All rights reserved. 2023.</p>
            </div>
        </a>
    </div>
</footer>
</body>
</html>

<script>
document.getElementById("category_id").addEventListener("change", function() {
    var categoryId = this.value;
    var productDropdown = document.getElementById("product_id");
    
    // Clear existing options
    productDropdown.innerHTML = "";
    
    // Filter products based on the selected category
    var filteredProducts = <?= json_encode($products) ?>.filter(function(product) {
        return product.category_id == categoryId;
    });
    
    // Add filtered products to the dropdown
    filteredProducts.forEach(function(product) {
        var option = document.createElement("option");
        option.value = product.product_id;
        option.textContent = product.name;
        productDropdown.appendChild(option);
    });
});
</script>