<?php
session_start();

include("connect.php");

// Function to fetch all categories from the database
function fetchAllCategories($db) {
    $categoryFetchSql = "SELECT category_id, name FROM categories";
    $categoryFetchStmt = $db->query($categoryFetchSql);
    return $categoryFetchStmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formAction = isset($_POST['form_action']) ? $_POST['form_action'] : '';

    // Handle category creation
    if ($formAction === 'create_category') {
        // Validate and sanitize form data
        $categoryName = isset($_POST['category_name']) ? htmlspecialchars($_POST['category_name']) : '';

        // Insert data into the database
        $insertCategorySql = "INSERT INTO categories (name) VALUES (:name)";
        $insertCategoryStmt = $db->prepare($insertCategorySql);
        $insertCategoryStmt->bindParam(':name', $categoryName);

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

// Fetch all categories from the database
$categories = fetchAllCategories($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Operations</title>
</head>
<body>
    <h1>Category Operations</h1>
    <form action="category_operations.php" method="post">
        <label for="category_id">Select Category:</label>
        <select id="category_id" name="category_id">
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="category_name">Category Name:</label>
        <input type="text" id="category_name" name="category_name" required>

        <input type="hidden" id="form_action" name="form_action" value="">
        <button type="button" onclick="submitForm('create_category')">Add</button>
        <button type="button" onclick="submitForm('update_category')">Update</button>
        <button type="button" onclick="submitForm('delete_category')">Delete</button>
    </form>

    <!-- Display all categories -->
    <h2>All Categories</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category['category_id'] ?></td>
                    <td><?= $category['name'] ?></td>
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
            document.forms[0].submit();
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
