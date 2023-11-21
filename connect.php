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
?>