<?php
// Start or resume the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the connection file
include("connect.php");

// Function to insert a new comment
function insertComment($db, $productId, $username, $comment) {
    $commentInsertSql = "INSERT INTO comments (product_id, username, comment_text, created_at) VALUES (:product_id, :username, :comment, CURRENT_TIMESTAMP)";
    $commentInsertStmt = $db->prepare($commentInsertSql);
    $commentInsertStmt->bindParam(':product_id', $productId);
    $commentInsertStmt->bindParam(':username', $username);
    $commentInsertStmt->bindParam(':comment', $comment);
    return $commentInsertStmt->execute();
}

// Function to fetch product details by ID
function fetchProductDetails($db, $productId) {
    // Prepare SQL statement to select product details based on product_id
    $productFetchSql = "SELECT * FROM products WHERE product_id = :product_id";
    $productFetchStmt = $db->prepare($productFetchSql);
    
    // Bind parameter for product_id
    $productFetchStmt->bindParam(':product_id', $productId);
    
    // Execute the SQL statement
    $productFetchStmt->execute();
    
    // Fetch and return the product details as an associative array
    return $productFetchStmt->fetch(PDO::FETCH_ASSOC);
}

// Check if the product_id is set in the URL
if (isset($_GET['product_id'])) {
    // Get the product_id from the URL
    $productId = $_GET['product_id'];
}
    
    // Check if the user is logged in
    $userLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
    
// Fetch product details using the function
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];
    $productDetails = fetchProductDetails($db, $productId);

    if ($productDetails) {
        // Extract product details for easier use
        $productName = htmlspecialchars($productDetails['name']);
        $productDescription = htmlspecialchars($productDetails['description']);
        $productPrice = $productDetails['price'];
        $stockQuantity = $productDetails['stock_quantity'];
        $categoryId = $productDetails['category_id'];
        $createdAt = $productDetails['created_at'];
        $updatedAt = $productDetails['updated_at'];
        // Add more details as needed

    
        echo '<div>
                <h1>' . $productName . '</h1>
                <p>' . $productDescription . '</p>
                <p>Price: $' . $productPrice . '</p>
                <p>Stock Quantity: ' . $stockQuantity . '</p>
                <p>Category ID: ' . $categoryId . '</p>
                <p>Created At: ' . $createdAt . '</p>
                <p>Updated At: ' . $updatedAt . '</p>
                <!-- Add more details as needed -->';

        // Comment Section
        echo '<div>
                <h2>Comments</h2>';

        // Include the comment section here
        // Modify as needed based on your implementation
        include("comment_section.php");

        echo '</div>';

        // Display the comment form only if the user is logged in
        if ($userLoggedIn) {
            echo '
            <form action="" method="post">
                <label for="comment">Leave a Comment:</label>
                <textarea name="comment" required></textarea>
                <button type="submit">Submit Comment</button>
            </form>';
        } else {
            echo '<p><a href="login.php">Login</a> to leave a comment.</p>';
        }

        echo '</div>';
        
       
        echo '<p><a href="index.php">Go back to homepage!</a></p>';

        } else {
        // Product not found, handle accordingly (e.g., show an error message)
        echo "Product not found";
        }
    } else {
    // product_id not set in the URL, handle accordingly (e.g., redirect to homepage)
    header("Location: index.php");
    exit();
}
?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $productName; ?></title>
        <link rel="stylesheet" type="text/css" href="index.css">
    </head>
    <body>
    </body>
    </html>
    
