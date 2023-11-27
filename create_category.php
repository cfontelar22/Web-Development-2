<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("connect.php");

// Function to fetch all categories from the database
function fetchAllCategories($db) {
    $categoryFetchSql = "SELECT category_id, name, category_description FROM categories";
    $categoryFetchStmt = $db->query($categoryFetchSql);
    return $categoryFetchStmt->fetchAll(PDO::FETCH_ASSOC);
}

$categories = fetchAllCategories($db);

// Initialize $formAction to avoid "Undefined variable" warnings
$formAction = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formAction = isset($_POST['form_action']) ? $_POST['form_action'] : '';

    // Handle category creation
    if ($formAction === 'create_category') {
        $categoryName = isset($_POST['category_name']) ? htmlspecialchars($_POST['category_name']) : '';
        $categoryDescription = isset($_POST['category_description']) ? htmlspecialchars($_POST['category_description']) : '';

        $insertCategorySql = "INSERT INTO categories (name, category_description) VALUES (:name, :category_description)";
        $insertCategoryStmt = $db->prepare($insertCategorySql);
        $insertCategoryStmt->bindParam(':name', $categoryName);
        $insertCategoryStmt->bindParam(':category_description', $categoryDescription);

        if ($insertCategoryStmt->execute()) {
            echo "Category added successfully!";
        } else {
            echo "Error adding category: " . implode(", ", $insertCategoryStmt->errorInfo());
        }
    }

    // Handle category update
    elseif ($formAction === 'update_category') {
        // Validate and sanitize form data
        $categoryId = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
        $categoryName = isset($_POST['category_name']) ? htmlspecialchars($_POST['category_name']) : '';

        // Update data in the database
        $updateCategorySql = "UPDATE categories SET name = :name WHERE category_id = :category_id";
        $updateCategoryStmt = $db->prepare($updateCategorySql);
        $updateCategoryStmt->bindParam(':category_id', $categoryId);
        $updateCategoryStmt->bindParam(':name', $categoryName);

        if ($updateCategoryStmt->execute()) {
            echo "Category updated successfully!";
        } else {
            echo "Error updating category: " . implode(", ", $updateCategoryStmt->errorInfo());
        }
    }

    // Handle category deletion (optional)
    elseif ($formAction === 'delete_category') {
        // Validate and sanitize form data
        $categoryId = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;

        // Delete category from the database
        $deleteCategorySql = "DELETE FROM categories WHERE category_id = :category_id";
        $deleteCategoryStmt = $db->prepare($deleteCategorySql);
        $deleteCategoryStmt->bindParam(':category_id', $categoryId);

        if ($deleteCategoryStmt->execute()) {
            echo "Category deleted successfully!";
        } else {
            echo "Error deleting category: " . implode(", ", $deleteCategoryStmt->errorInfo());
        }
    }
}

$categories = fetchAllCategories($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Category</title>
</head>
<body>
    <h1>Create New Category</h1>
    <form id="create_category_form" action="create_category.php" method="post">
        <label for="category_name">Category Name:</label>
        <input type="text" id="category_name" name="category_name" required>

        <label for="category_description">Category Description:</label>
        <textarea id="category_description" name="category_description" required></textarea>

        <input type="hidden" id="form_action" name="form_action" value="">
        <button type="button" onclick="submitForm('create_category')">Add</button>
    </form>

    <!-- Display all categories -->
    <h2>All Categories</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category['category_id'] ?></td>
                    <td><?= $category['name'] ?></td>
                    <td><?= isset($category['category_description']) ? $category['category_description'] : '' ?></td>
                    <td>
                        <button type="button" onclick="populateFormForUpdate(<?= $category['category_id'] ?>)">Update</button>
                        <button type="button" onclick="populateFormForDeletion(<?= $category['category_id'] ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- JavaScript to populate the form for update or deletion -->
    <script>
        function submitForm(action) {
            document.getElementById('form_action').value = action;
            document.getElementById('create_category_form').submit();
        }

        function populateFormForUpdate(categoryId) {
            document.getElementById('category_id').value = categoryId;
            // Submit the form for update
            submitForm('update_category');
        }

        function populateFormForDeletion(categoryId) {
            document.getElementById('category_id').value = categoryId;
            // Optionally confirm the deletion
            if (confirm('Are you sure you want to delete this category?')) {
                // Submit the form for deletion
                submitForm('delete_category');
            }
        }
    </script>
</body>
</html>
