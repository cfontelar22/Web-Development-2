g

<?php

// Function to fetch comments for a specific product
function fetchProductComments($db, $productId) {
    $commentFetchSql = "SELECT * FROM comments WHERE product_id = :product_id ORDER BY created_at DESC";
    $commentFetchStmt = $db->prepare($commentFetchSql);
    $commentFetchStmt->bindParam(':product_id', $productId);
    $commentFetchStmt->execute();
    return $commentFetchStmt->fetchAll(PDO::FETCH_ASSOC);
}


// Check if the form is submitted and user is logged in
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment']) && $userLoggedIn) {
    $comment = $_POST['comment'];
    $userId = $_SESSION['user_id']; // Assuming user_id is stored in the session

    if (insertComment($db, $productId, $userId, $comment)) {
        // Comment inserted successfully
        echo '<p>Comment added successfully!</p>';
    } else {
        // Error inserting comment
        echo '<p>Error adding comment. Please try again.</p>';
    }
}

// Fetch and display existing comments
$comments = fetchProductComments($db, $productId);

if ($comments) {
    echo '<h2>Comments</h2>';
    echo '<ul>';
    foreach ($comments as $comment) {
        echo '<li>' . htmlspecialchars($comment['comment']) . '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>No comments yet. Be the first to leave a comment!</p>';
}
?>

