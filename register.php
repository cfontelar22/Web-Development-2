<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("connect.php");

$registration_status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $confirm_password = htmlspecialchars($_POST['confirm_password']);

        if ($password === $confirm_password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

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
            <input type="text" name="username" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>


</body>
</html>
