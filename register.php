<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('DB_DSN', 'mysql:host=localhost;dbname=svpbdatabase;charset=utf8');
define('DB_USER', 'serveruser');
define('DB_PASS', 'fontelar');

try {
    // Try creating a new PDO connection to MySQL.
    $db = new PDO(DB_DSN, DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}

// Initialize variables
$username = $email = $password = $confirm_password = '';
$registration_status = ''; // Variable to store registration status message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are set
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
        // Sanitize user input to prevent SQL injection
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $confirm_password = htmlspecialchars($_POST['confirm_password']);

        // Validate passwords match
        if ($password === $confirm_password) {
            // Hash the password before storing it in the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and execute the SQL query to insert a new user
            $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $registration_status = "<p class='success-message'>User registered successfully!</p>";
            } else {
                $registration_status = "<p class='error-message'>Error registering user!</p>";
            }
        } else {
            $registration_status = "<p class='error-message'>Passwords do not match!</p>";
        }
    } else {
        $registration_status = "<p class='error-message'>All fields are required!</p>";
    }
}
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

        <!-- Registration Status Message Box -->
        <div class="registration-status-box">
            <?php echo $registration_status; ?>
        </div>

        <!-- Registration Form -->
        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" required value="<?php echo $username; ?>">

            <label for="email">Email:</label>
            <input type="email" name="email" required value="<?php echo $email; ?>">

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
