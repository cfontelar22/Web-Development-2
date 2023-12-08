<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("connect.php");

// Function to fetch search results from the database
function fetchSearchResults($db, $searchTerm, $category, $offset, $resultsPerPage) {
    // Customize this query based on your database schema
    $searchSql = "SELECT * FROM products WHERE 
                  (name LIKE :searchTerm OR description LIKE :searchTerm) 
                  AND (:category = '' OR category_id = :category)
                  LIMIT :offset, :resultsPerPage";

    $searchStmt = $db->prepare($searchSql);
    $searchStmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
    $searchStmt->bindValue(':category', $category, PDO::PARAM_INT);
    $searchStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $searchStmt->bindValue(':resultsPerPage', $resultsPerPage, PDO::PARAM_INT);
    $searchStmt->execute();

    return $searchStmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get the total count of search results
function getTotalResultsCount($db, $searchTerm, $category) {
    // Customize this query based on your database schema
    $countSql = "SELECT COUNT(*) FROM products WHERE 
                  (name LIKE :searchTerm OR description LIKE :searchTerm) 
                  AND (:category = '' OR category_id = :category)";

    $countStmt = $db->prepare($countSql);
    $countStmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
    $countStmt->bindValue(':category', $category, PDO::PARAM_INT);
    $countStmt->execute();

    return $countStmt->fetchColumn();
}

// Set the number of results per page
$resultsPerPage = 5;

// Get the page number from the query string
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the offset based on the current page
$offset = ($page - 1) * $resultsPerPage;

// Get the search term from the query string
$searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '';

// Get the category from the query string
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Fetch search results using LIMIT and OFFSET
$searchResults = fetchSearchResults($db, $searchTerm, $category, $offset, $resultsPerPage);

// Get the total count of search results for pagination links
$totalResults = getTotalResultsCount($db, $searchTerm, $category);

// Output search results.
foreach ($searchResults as $result) {
    echo '<div class="product-item">
            <a href="product.php?product_id=' . $result['product_id'] . '" class="product-link">
                <h2 class="product-title">' . htmlspecialchars($result['name']) . '</h2>
            </a>
            <div class="product-details">
                <p>' . htmlspecialchars($result['description']) . '</p>
                <p class="product-price">$' . $result['price'] . '</p>
                <a href="product.php?product_id=' . $result['product_id'] . '" class="add-to-cart-button">View Item</a>
            </div>
        </div>';
}

// Output pagination links
echo '<div class="pagination-links">';
// Calculate the total number of pages
$totalPages = ceil($totalResults / $resultsPerPage);

// Show pagination links only if there are more than one page
if ($totalPages > 1) {
    for ($i = 1; $i <= $totalPages; $i++) {
        // Include both search term and category in pagination links
        echo '<a href="search.php?page=' . $i . '&search=' . urlencode($searchTerm) . '&category=' . urlencode(is_array($category) ? implode(',', $category) : $category) . '">' . $i . '</a>';
    }
}
echo '</div>';

// Add "Go back to homepage" link
echo '<a href="index.php">Go back to homepage</a>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

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