<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("connect.php");


// Check if the admin is logged in and the username is stored in the session
if (isset($_SESSION['username'])) {
    // Get the admin's username from the session
    $username = $_SESSION['username'];
} else {
    // Redirect to the login page if the admin is not logged in
    header("Location: login.php"); 
    exit();
}

// Function to fetch all categories from the database
function fetchAllCategories($db) {
    $categoryFetchSql = "SELECT category_id, name, category_description FROM categories";
    $categoryFetchStmt = $db->query($categoryFetchSql);
    return $categoryFetchStmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch category_name from GET parameters
$category_name = filter_input(INPUT_GET, 'category_name', FILTER_SANITIZE_STRING);


    $categorySql = "SELECT * FROM categories WHERE name = :category_name";
    $categoryStmt = $db->prepare($categorySql);
    $categoryStmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
    $categoryStmt->execute();
    $category = $categoryStmt->fetch(PDO::FETCH_ASSOC);

$categories = fetchAllCategories($db);
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
                                    // Modify the link to include product_id
                                    echo '<a href="product.php?product_id=' . $product['product_id'] . '">' . htmlspecialchars($product['name']) . '</a>';
                                }
                            ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
</div>

    <!-- Include the search form with categories -->
    <form id="search-form" action="search.php" method="get">
        <input type="text" id="search" name="search" placeholder="Search by Keyword">
        
        <!-- Add the dropdown menu for category restriction -->
        <select name="category">
            <option value="" selected>All Categories</option>
            <?php
                // Fetch categories from the database and populate the dropdown
                $categoryFetchSql = "SELECT category_id, name FROM categories";
                $categoryFetchStmt = $db->query($categoryFetchSql);
                $categories = $categoryFetchStmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($categories as $category) {
                    echo '<option value="' . $category['category_id'] . '">' . htmlspecialchars($category['name']) . '</option>';
                }
            ?>
        </select>
        <button type="submit">Search</button>
            </form>
            
    <div class="user-signin-container">
    <?php
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
        // Display user information or logout link
        echo '<div class="user-dropdown">
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
    
            <li><a href="admin_register.php">Admin Register</a></li>
        </ul>
    </nav>
</header>


<div id="welcome-container">
    <h2>Welcome, <?= $username ?>!</h2>

    <?php

    // Check if the user is an admin
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
    echo '<a href="admin_dashboard.php">Go to Admin Dashboard</a>';
}

?>
</div>

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
                <a href="product.php?product_id=<?php echo $product['product_id']; ?>" class="product-link">
                    <h2 class="product-title">
                        <?php echo htmlspecialchars($product['name']); ?>
                    </h2>
                </a>
                <div class="product-details">
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p class="product-price">$<?php echo $product['price']; ?></p>

                    <!-- Fetch and display associated images -->
                    <?php
                    $imagesSql = "SELECT * FROM images WHERE product_id = :product_id";
                    $imagesStmt = $db->prepare($imagesSql);
                    $imagesStmt->bindParam(':product_id', $product['product_id'], PDO::PARAM_INT);
                    $imagesStmt->execute();
                    $images = $imagesStmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <!-- Display images -->
                    <div class="product-images">
                        <?php foreach ($images as $image): ?>
                            <img src="uploads/<?= $image['filename'] ?>" alt="Product Image">
                        <?php endforeach; ?>
                        <a href="product.php?product_id=<?php echo $product['product_id']; ?>" class="add-to-cart-button">View Item</a>
                    </div>
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

// Update the searchProducts function in your script tag
function searchProducts() {
    const searchInput = document.getElementById('search');
    const searchTerm = searchInput.value.trim();

    if (searchTerm !== '') {
        // Get the current page from the URL (if available)
        const urlParams = new URLSearchParams(window.location.search);
        const currentPage = urlParams.get('page') || 1;

        // Send an AJAX request to the server for searching products and categories
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `search.php?search=${encodeURIComponent(searchTerm)}&page=${currentPage}`, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                // Replace the product grid content with the search results
                document.querySelector('.product-grid').innerHTML = xhr.responseText;

                // You may also update the pagination links here
                const paginationContainer = document.querySelector('.pagination-links');
                paginationContainer.innerHTML = xhr.response;
            }
        };

        xhr.send();
    }
}

</script>