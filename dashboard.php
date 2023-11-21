<?php
// dashboard.php

session_start();

// Include your authentication functions file
include("auth_function.php");

// Check if the user is not logged in
if (!isUserLoggedIn()) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
      
    </header>

    <main>
        <p>This is your dashboard content.</p>
    </main>

    <footer>
    </footer>
</body>
</html>
