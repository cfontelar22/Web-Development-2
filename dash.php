<?php
session_start();
include("connect.php"); // Include the file where $db is initialized

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page or perform other actions
    header("Location: login.php");
    exit();
}

// Function to get total number of pages
function getTotalPagesCount($db) {
    $query = "SELECT COUNT(*) AS total FROM pages";
    $statement = $db->prepare($query);

    try {
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    } catch (PDOException $e) {
        // Handle errors if necessary
        return 0;
    }
}

// Get total number of pages
$totalPages = getTotalPagesCount($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your head content here -->
</head>
<body>

<div class="welcome-message">
    <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
    <p>Total Pages: <?php echo $totalPages; ?></p>
</div>

<div class="dashboard-links">
    <ul>
        <li><a href="create_page.php">Create Page</a></li>
        <li><a href="edit_pages.php">Edit Pages</a></li>
        <li><a href="view_pages.php">View Pages</a></li>
        <li><a href="create_category.php">Create Category</a></li>
        <li><a href="view_comments.php">Moderate Comments</a></li>
    </ul>
</div>

<!-- Add other content and functionalities as needed -->

</body>
</html>
