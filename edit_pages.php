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

// Fetch all products from the database
$productSql = "SELECT product_id, name, category_id FROM products";
$productStmt = $db->query($productSql);
$allProducts = $productStmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission for edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    // Similar to the previous code...
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    // Similar to the previous code...
} else {
    // Display the form with separate dropdowns for categories and products
    echo '<h1>Edit/Delete Product</h1>';
    echo '<form action="edit_delete_product.php" method="post">';
    
    // Dropdown for selecting category
    echo '<label for="category_id">Select Category:</label>';
    echo '<select id="category_id" name="category_id" required>';
    foreach ($categories as $category) {
        echo '<option value="' . $category['category_id'] . '">' . $category['name'] . '</option>';
    }
    echo '</select>';
    
    // Initially, display all products
    echo '<label for="product_id">Select Product:</label>';
    echo '<select id="product_id" name="product_id" required>';
    foreach ($allProducts as $product) {
        echo '<option value="' . $product['product_id'] . '">' . $product['name'] . '</option>';
    }
    echo '</select>';
    
    echo '<button type="submit" name="edit_product">Edit Product</button>';
    echo '<button type="submit" name="delete_product">Delete Product</button>';
    echo '</form>';

    // JavaScript to dynamically update product dropdown based on selected category
    echo '<script>
        document.getElementById("category_id").addEventListener("change", function() {
            var categoryId = this.value;
            var productDropdown = document.getElementById("product_id");
            
            // Clear existing options
            productDropdown.innerHTML = "";
            
            // Filter products based on the selected category
            var filteredProducts = ' . json_encode($allProducts) . '.filter(function(product) {
                return product.category_id == categoryId;
            });
            
            // Add filtered products to the dropdown
            filteredProducts.forEach(function(product) {
                var option = document.createElement("option");
                option.value = product.product_id;
                option.textContent = product.name;
                productDropdown.appendChild(option);
            });
        });
    </script>';
}
?>
