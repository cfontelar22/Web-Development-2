
<?php

// Function to check if the user is logged in
function isUserLoggedIn() {
    return isset($_SESSION['username']);
}

function authenticateUser($username, $password) {

    $validUsername = 'serveruser';
    $validPassword = 'fontelar';

    // Check if provided credentials match the valid ones
    if ($username === $validUsername && password_verify($password, password_hash($validPassword, PASSWORD_DEFAULT))) {
        // Authentication successful
        return true;
    } else {
        // Authentication failed
        return false;
    }
}
?>
