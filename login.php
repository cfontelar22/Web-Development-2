<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the connection file
include("connect.php");

// Function to authenticate a user
function authenticateUser($username, $password) {
    global $db;

    // Modify this query based on your database structure
    $query = "SELECT * FROM `users` WHERE `username` = :username";
    $statement = $db->prepare($query);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Password is correct
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // Store the user's role in the session
        return true;
    }

    // Check if the user exists in the admins table
    $query = "SELECT * FROM `admins` WHERE `username` = :username";
    $statement = $db->prepare($query);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();
    $admin = $statement->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        // Password is correct
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['username'] = $admin['username'];
        $_SESSION['role'] = $admin['role']; // Store the admin's role in the session
        return true;
    }

    // Password is incorrect
    return false;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // If the form is submitted, attempt to authenticate
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);


    if (authenticateUser($username, $password)) {
        // Authentication successful, set session variables
        if ($_SESSION['role'] === 'admin') {
            // Redirect admin to admin dashboard or CRUD page
            header("Location: admin_dashboard.php");
            exit();
        } else {
            // Redirect regular user to user dashboard or homepage
            header("Location: index.php");
            exit();
        }
    } else {
        // Authentication failed, show an error message
        $_SESSION['error'] = "Invalid username or password";
        header("Location: login.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - SVPB E-Commerce and Smart Solutions</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="index.css"> 
</head>
<body>
    <!-- Header -->
    <header id="header" class="fixed-header">
    <a href="index.php">    
        <img src="images/lbglogo.png" alt="Logo" class="logo">
    </a>
        <nav id="navigation">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li class="dropdown">
                    <a href="#">Solutions</a>
                    <div class="dropdown-content">
                        <a href="solutions.html">Security Solutions</a>
                        <a href="solutions.html">Network Solutions</a>
                        <a href="solutions.html">ICT Infrastructure</a>
                    </div>
                </li>
                <li><a href="#">Events</a></li>
                <li><a href="#">Jobs</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($loginError)) : ?>
            <p class="error-message"><?php echo $loginError; ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <p>New Here? <a href="register.php">Register</a></p>
    </div>

    <!-- Footer -->
    <footer id="footer">
        <div class="footer-division">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>
        <div class="footer-division">
            <h3>Solutions</h3>
            <ul>
                <li><a href="solutions.html">Security Solutions</a></li>
                <li><a href="solutions.html">Network Solutions</a></li>
                <li><a href="solutions.html">ICT Infrastructure</a></li>
            </ul>
        </div>
        <div class="footer-division">
            <a href="index.php">
                <div><img src="images/lbglogo.png" alt="Logo" class="logo">
                    <p>© Copyright Jay Fontelar<br>All rights reserved. 2023.</p>
                </div>
            </a>
        </div>
    </footer>
</body>
</html>
