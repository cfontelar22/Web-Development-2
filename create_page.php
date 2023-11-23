<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in and is an admin
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || $_SESSION['role'] !== 'admin') {
    // Redirect or handle the case where the user is not logged in or is not an admin
    // You can redirect them to a login page or show an error message
}

// Include your database connection script
include("connect.php");

// Fetch categories from the database
$categorySql = "SELECT category_id, name FROM Categories";
$categoryStmt = $db->query($categorySql);
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize form data
    $productName = isset($_POST['product_name']) ? htmlspecialchars($_POST['product_name']) : '';
    $productDescription = isset($_POST['product_description']) ? htmlspecialchars($_POST['product_description']) : '';
    $productPrice = isset($_POST['product_price']) ? floatval($_POST['product_price']) : 0.0; // Assuming the price is a float
    $categoryID = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0; // Assuming the category_id is an integer
    $stockQuantity = isset($_POST['stock_quantity']) ? intval($_POST['stock_quantity']) : 0; // Assuming stock_quantity is an integer

    // Insert data into the database
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Product</title>
</head>
<body>
    <h1>Create New Product</h1>
    <form action="create_page.php" method="post">
    <label for="product_name">Product Name:</label>
    <input type="text" id="product_name" name="product_name" required>

    <label for="product_description">Product Description:</label>
    <textarea id="product_description" name="product_description" required></textarea>

    <label for="product_price">Product Price:</label>
    <input type="number" id="product_price" name="product_price" step="0.01" required>

    <label for="stock_quantity">Stock Quantity:</label>
    <input type="number" id="stock_quantity" name="stock_quantity" required>


    <label for="category_id">Category Name:</label>
    <select id="category_id" name="category_id" required>
        <!-- Populate this dropdown with categories from the database -->
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
        <?php endforeach; ?>
    </select>

    

    <button type="submit">Add Product</button>
</form>

</body>
</html>
