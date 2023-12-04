<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("connect.php");



// Function to fetch search results from the database
function fetchSearchResults($db, $searchTerm, $offset, $resultsPerPage) {
    // Customize this query based on your database schema
    $searchSql = "SELECT * FROM products WHERE name LIKE :searchTerm OR description LIKE :searchTerm LIMIT :offset, :resultsPerPage";

    $searchStmt = $db->prepare($searchSql);
    $searchStmt->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);
    $searchStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $searchStmt->bindValue(':resultsPerPage', $resultsPerPage, PDO::PARAM_INT);
    $searchStmt->execute();

    return $searchStmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get the total count of search results
function getTotalResultsCount($db, $searchTerm) {
    // Customize this query based on your database schema
    $countSql = "SELECT COUNT(*) FROM products WHERE name LIKE :searchTerm OR description LIKE :searchTerm";

    $countStmt = $db->prepare($countSql);
    $countStmt->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);
    $countStmt->execute();

    return $countStmt->fetchColumn();
}

// Set the number of results per page
$resultsPerPage = 10;

// Get the page number from the query string
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the offset based on the current page
$offset = ($page - 1) * $resultsPerPage;

// Get the search term from the query string
$searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '';

// Fetch search results using LIMIT and OFFSET
$searchResults = fetchSearchResults($db, $searchTerm, $offset, $resultsPerPage);

// Output search results...
foreach ($searchResults as $result) {
    echo '<div class="product-item">
            <a href="product.php?product_id=' . $result['product_id'] . '" class="product-link">
                <img src="path/to/upload/directory/' . htmlspecialchars($result['image']) . '" alt="' . htmlspecialchars($result['name']) . '">
                <h2 class="product-title">' . htmlspecialchars($result['name']) . '</h2>
            </a>
            <div class="product-details">
                <p>' . htmlspecialchars($result['description']) . '</p>
                <p class="product-price">$' . $result['price'] . '</p>
                <a href="product.php?product_id=' . $result['product_id'] . '" class="add-to-cart-button">View Item</a>
            </div>
        </div>';
}

// Get the total count of search results for pagination links
$totalResults = getTotalResultsCount($db, $searchTerm);

// Output pagination links
echo '<div class="pagination-links">';
for ($i = 1; $i <= ceil($totalResults / $resultsPerPage); $i++) {
    echo '<a href="search.php?page=' . $i . '&search=' . urlencode($searchTerm) . '">' . $i . '</a>';
}
echo '</div>';
?>
