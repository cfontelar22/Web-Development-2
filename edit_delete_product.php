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

// Handle form submission for edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    $selectedProductId = $_POST['product_id'];
    
    // Fetch the details of the selected product from the database
    $fetchProductSql = "SELECT * FROM products WHERE product_id = :product_id";
    $fetchProductStmt = $db->prepare($fetchProductSql);
    $fetchProductStmt->bindParam(':product_id', $selectedProductId);
    $fetchProductStmt->execute();
    $selectedProduct = $fetchProductStmt->fetch(PDO::FETCH_ASSOC);

    // Display a form for editing the selected product
    if ($selectedProduct) {
        echo '<h1>Edit Product</h1>';
        echo '<form action="process_edit_delete_product.php" method="post">';
        echo '<input type="hidden" name="product_id" value="' . $selectedProduct['product_id'] . '">';
        echo '<label for="product_name">Product Name:</label>';
        echo '<input type="text" id="product_name" name="product_name" value="' . $selectedProduct['name'] . '" required>';
        echo '<label for="product_description">Product Description:</label>';
        echo '<textarea id="product_description" name="product_description" required>' . $selectedProduct['description'] . '</textarea>';
        echo '<label for="product_price">Product Price:</label>';
        echo '<input type="number" id="product_price" name="product_price" step="0.01" value="' . $selectedProduct['price'] . '" required>';
        echo '<label for="stock_quantity">Stock Quantity:</label>';
        echo '<input type="number" id="stock_quantity" name="stock_quantity" value="' . $selectedProduct['stock_quantity'] . '" required>';
        echo '<button type="submit" name="update_product">Update Product</button>';
        echo '</form>';
    } else {
        echo 'Product not found.';
    }
    exit();
}

// Handle form submission for delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $selectedProductId = $_POST['product_id'];
    // Delete the selected product from the database
    $deleteProductSql = "DELETE FROM products WHERE product_id = :product_id";
    $deleteProductStmt = $db->prepare($deleteProductSql);
    $deleteProductStmt->bindParam(':product_id', $selectedProductId);

    if ($deleteProductStmt->execute()) {
        echo "Product deleted successfully!";
    } else {
        echo "Error deleting product.";
    }
    exit();
}

// If the form submission is not valid or the actions are not recognized, display an error message
echo "Invalid form submission or action.";
?>
