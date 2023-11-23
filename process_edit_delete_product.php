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

// Handle form submission for updating product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $productId = $_POST['product_id'];
    $productName = htmlspecialchars($_POST['product_name']);
    $productDescription = htmlspecialchars($_POST['product_description']);
    $productPrice = floatval($_POST['product_price']);
    $stockQuantity = intval($_POST['stock_quantity']);

    // Update data in the database
    $updateProductSql = "UPDATE products SET name = :name, description = :description, price = :price, stock_quantity = :stock_quantity WHERE product_id = :product_id";
    $updateProductStmt = $db->prepare($updateProductSql);
    $updateProductStmt->bindParam(':product_id', $productId);
    $updateProductStmt->bindParam(':name', $productName);
    $updateProductStmt->bindParam(':description', $productDescription);
    $updateProductStmt->bindParam(':price', $productPrice);
    $updateProductStmt->bindParam(':stock_quantity', $stockQuantity);

    if ($updateProductStmt->execute()) {
        echo "Product updated successfully!";
    } else {
        echo "Error updating product.";
    }
    exit();
}

// If the form submission is not valid or the action is not recognized, display an error message
echo "Invalid form submission or action.";
?>
