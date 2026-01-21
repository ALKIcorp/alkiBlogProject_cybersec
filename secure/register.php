<?php
/**
 * SECURE VERSION - Register
 * Uses prepared statements and password_hash()
 */
session_start();
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    // SECURE: Hash the password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SECURE: Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);
    
    if ($stmt->execute()) {
        echo "Registered. <a href='login.php'>Login</a>";
    } else {
        echo "Registration failed. Username may already exist.";
    }
    $stmt->close();
    exit;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Register - Alki Corp</title>
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>
    <div class="container">
      <div class="card">
        <h2>Register (Secure)</h2>
        <form method="POST">
          <input name="username" placeholder="Username" required>
          <input name="password" placeholder="Password" required type="password">
          <button type="submit">Register</button>
        </form>
        <p class="muted">Already have an account? <a href="login.php">Login</a></p>
      </div>
    </div>
  </body>
</html>
