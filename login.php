<?php
session_start();


include("auth_function.php");

// Check if the user is logged in
if (!isUserLoggedIn()) {
    // User is not logged in, show the login form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // If the form is submitted, attempt to authenticate
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (authenticateUser($username, $password)) {
            // Authentication successful, set session variables
            $_SESSION['username'] = $username;

            // Redirect to the dashboard or another page
            header("Location: dashboard.php");
            exit();
        } else {
            // Authentication failed, show an error message
            $loginError = "Invalid username or password";
        }
    }
} else {
    // User is already logged in, allow them to manually enter credentials
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (authenticateUser($username, $password)) {
            // Authentication successful, set session variables
            $_SESSION['username'] = $username;

            // Redirect to the dashboard or another page
            header("Location: dashboard.php");
            exit();
        } else {
            // Authentication failed, show an error message
            $loginError = "Invalid username or password";
        }
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
                <li><a href="#">Home</a></li>
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
