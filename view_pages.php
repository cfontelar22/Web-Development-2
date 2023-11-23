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

// Handle sorting logic
$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'name';
$sortOrder = isset($_GET['order']) ? $_GET['order'] : 'asc';

$validColumns = ['name', 'created_at', 'updated_at'];

// Validate the sort column
if (!in_array($sortColumn, $validColumns)) {
    $sortColumn = 'name';
}

// Validate the sort order
$sortOrder = ($sortOrder === 'asc') ? 'asc' : 'desc';

// Fetch products from the database with sorting applied
$sortSql = "ORDER BY $sortColumn $sortOrder";
$productsSql = "SELECT * FROM products $sortSql";
$productsStmt = $db->query($productsSql);
$products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);

// Display the list of products
echo '<h1>List of Products</h1>';

// Indication of the current sorting
echo '<p>Sorting by ' . ucfirst($sortColumn) . ' (' . strtoupper($sortOrder) . ')</p>';

// Table header
echo '<table border="1">';
echo '<tr>';
echo '<th><a href="view_products.php?sort=name&order=' . ($sortColumn === 'name' && $sortOrder === 'asc' ? 'desc' : 'asc') . '">Product Name</a></th>';
echo '<th><a href="view_products.php?sort=created_at&order=' . ($sortColumn === 'created_at' && $sortOrder === 'asc' ? 'desc' : 'asc') . '">Created At</a></th>';
echo '<th><a href="view_products.php?sort=updated_at&order=' . ($sortColumn === 'updated_at' && $sortOrder === 'asc' ? 'desc' : 'asc') . '">Updated At</a></th>';
echo '</tr>';

// Table content
foreach ($products as $product) {
    echo '<tr>';
    echo '<td>' . $product['name'] . '</td>';
    echo '<td>' . $product['created_at'] . '</td>';
    echo '<td>' . $product['updated_at'] . '</td>';
    echo '</tr>';
}

echo '</table>';
?>
