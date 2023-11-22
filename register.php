<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("connect.php"); 


?>

<!DOCTYPE html>
<html lang="en">
<head>
   
    <title>Register - SVPB E-Commerce and Smart Solutions</title>
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

    <!-- Register Form -->
    <div class="register-container">
        <h2>Register</h2>
        <?php 
      
        ?>
        <form action="register.php" method="post">
            
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" required>
            
            

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
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
