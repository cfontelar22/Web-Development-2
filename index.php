<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("connect.php");

// Function to fetch all categories from the database
function fetchAllCategories($db) {
    $categoryFetchSql = "SELECT category_id, name, category_description FROM categories";
    $categoryFetchStmt = $db->query($categoryFetchSql);
    return $categoryFetchStmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to fetch featured solutions
function fetchFeaturedSolutions($db) {
    $featuredSolutionsSql = "SELECT Products.name AS product_name, Products.description AS product_description, Products.price AS product_price
                            FROM Products
                            JOIN Categories ON Products.category_id = Categories.category_id
                            WHERE Categories.name IN ('Network Solutions and Structured Cabling')";
    $featuredSolutionsStmt = $db->query($featuredSolutionsSql);

    $featuredSolutions = [];

    // Check if the query was successful and results were obtained
    if ($featuredSolutionsStmt !== false) {
        $featuredSolutions = $featuredSolutionsStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $featuredSolutions;
}

$categories = fetchAllCategories($db);
$featuredSolutions = fetchFeaturedSolutions($db);

$pageId = 1; 
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

<div class="header-container">
<div class="main-navigation">
    <nav id="main-nav">
        <ul>
           
            <?php foreach ($categories as $category) : ?>
                <li class="dropdown">
                    <a href="#"><?php echo htmlspecialchars($category['name']); ?></a>
                    <div class="dropdown-content">
                        <?php
                            // Fetch products for the current category
                            $categoryProducts = fetchProductsByCategory($db, $category['category_id']);

                            foreach ($categoryProducts as $product) {
                                echo '<a href="#">' . htmlspecialchars($product['name']) . '</a>';
                            }
                        ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</div>

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

<div class="product-listing">
    <h1 class="products-title">Explore Our Product Offerings</h1>
    <div class="product-grid">
        <?php foreach ($categories as $category) : ?>
            <?php
            // Fetch products for the current category
            $categoryProducts = fetchProductsByCategory($db, $category['category_id']);

            foreach ($categoryProducts as $product) :
            ?>
                <div class="product-item">
                    <a href="product.php?category=<?php echo urlencode($category['name']); ?>" class="product-link">
                        <img src="images/product_image.jpg" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h2 class="product-title">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </h2>
                    </a>
                    <div class="product-details">
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="product-price">$<?php echo $product['price']; ?></p>
                        <a href="#" class="add-to-cart-button">Add to Cart</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</div>


<?php


// Function to fetch products for a specific category
function fetchProductsByCategory($db, $categoryId) {
    $productSql = "SELECT * FROM products WHERE category_id = :category_id";
    $productStmt = $db->prepare($productSql);
    $productStmt->bindParam(':category_id', $categoryId);
    $productStmt->execute();
    return $productStmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCategoryDescription($categoryName)
{
    global $db;

    // Query the database to get the category description
    $descriptionSql = "SELECT category_description FROM categories WHERE name = :categoryName";
    $descriptionStmt = $db->prepare($descriptionSql);
    $descriptionStmt->bindParam(':categoryName', $categoryName);
    $descriptionStmt->execute();

    $result = $descriptionStmt->fetch(PDO::FETCH_ASSOC);

    // Return the description if available, or an empty string if not found
    return isset($result['category_description']) ? '<p>' . $result['category_description'] . '</p>' : '';
}
?>

<div id="text-box">
    <h1 id="h1">LBG E-COMMERCE AND SMART SOLUTIONS</h1>
    <h2 id="h2">Bright Solutions, Profitable Ideas</h2>
    <p>L.B.G E-COMMERCE AND SMART SOLUTIONS is a distinguished Information Technology service provider, specializing in providing cutting-edge computer parts and IT solutions to small, medium, and large organizations. With a strong focus on technological collaboration, they empower their clients to find the best computer parts and IT solutions to enhance their operations. L.B.G E-Commerce and Smart Solutions' mission is to assist businesses in fulfilling their IT needs, allowing them to concentrate on their core competencies while delivering high-quality computer parts built on simplicity, security, and scalability.</p>
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

<script>
const slideshowContainer = document.getElementById('slideshow-container');
const images = slideshowContainer.querySelectorAll('img');
let currentIndex = 0;

setInterval(() => {
    images[currentIndex].style.opacity = 0;
    currentIndex = (currentIndex + 1) % images.length;
    images[currentIndex].style.opacity = 1;
}, 3000);

const header = document.getElementById('header');
const headerHeight = header.offsetHeight;

window.addEventListener('scroll', () => {
    const scrollPosition = window.scrollY || window.pageYOffset;

    if (scrollPosition >= headerHeight) {
        header.classList.add('fixed-header');
    } else {
        header.classList.remove('fixed-header');
    }
});
</script>