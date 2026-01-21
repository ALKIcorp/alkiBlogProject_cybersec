<?php
/**
 * SECURE VERSION - Database Connection
 * Uses a least-privilege database user instead of root
 * 
 * To create this user in MySQL:
 * CREATE USER 'alkicorp_app'@'localhost' IDENTIFIED BY 'secure_password_here';
 * GRANT SELECT, INSERT, UPDATE ON alkicorp.* TO 'alkicorp_app'@'localhost';
 * FLUSH PRIVILEGES;
 */

$host = "localhost";
$user = "alkicorp_app";  // Least-privilege user (not root)
$pass = "secure_password_here";  // Change this to your secure password
$db   = "alkicorp";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}
?>
