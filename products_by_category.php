<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("connect.php");

// Check if the user is logged in
$isUserLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];

// Fetch the category ID from the URL
$categoryID = isset($_GET['category_id']) ? $_GET['category_id'] : null;

// Fetch all products in the selected category
$productSql = "SELECT * FROM products WHERE category_id = :category_id";
$productStmt = $db->prepare($productSql);
$productStmt->bindParam(':category_id', $categoryID);
$productStmt->execute();
$products = $productStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products by Category</title>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>

<div class="header-container">
<div class="header-container">
    <!-- Search Container -->
    <div class="search-container">
        <div class="search-input-container">
            <input type="text" id="search" name="search" placeholder="SEARCH BY CATEGORY">
            <button type="button" onclick="searchProducts()">
                <img src="images/icon.png" alt="Search" class="search-button-icon">
            </button>
        </div>
    </div>

    <!-- User Signin Container -->
    <div class="user-signin-container">
        <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            // Display user information or logout link
            echo '<div class="user-dropdown">
                    <span id="signin-link">
                        Welcome, ' . $_SESSION['username'] . '!
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
            <li><a href="#">Home</a></li>
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
        </ul>
    </nav>
</header>

    <div class="user-signin-container">
        <?php
        if ($isUserLoggedIn) {
            // Display user information or logout link
            echo '<div class="user-dropdown">
                    <span id="signin-link">
                        Welcome, ' . $_SESSION['username'] . '!
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
                        <a href="login.php">Sign In</a>
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

<!-- Display products in the selected category -->
<div class="product-listing">
    <h1>Products in Selected Category</h1>

    <?php
    foreach ($products as $product) {
        echo '<div class="product-item">';
        echo '<h2>' . $product['name'] . '</h2>';
        echo '<p>' . $product['description'] . '</p>';
        echo '<p>Price: $' . $product['price'] . '</p>';
        echo '<p>Stock Quantity: ' . $product['stock_quantity'] . '</p>';

        // Display additional information for logged-in users
        if ($isUserLoggedIn) {
            echo '<p>Product ID: ' . $product['product_id'] . '</p>';
            echo '<p>Created At: ' . $product['created_at'] . '</p>';
            echo '<p>Updated At: ' . $product['updated_at'] . '</p>';
        }

        echo '</div>';
    }
    ?>
</div>
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
