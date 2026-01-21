<?php
/**
 * SECURE VERSION - Login
 * Uses prepared statements and password_verify()
 */
session_start();
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    // SECURE: Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // SECURE: Use password_verify() for hashed password comparison
        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            header("Location: index.php");
            exit;
        }
    }
    $error = "Login failed.";
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Login - Alki Corp</title>
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>
    <div class="container">
      <div class="card">
        <h2>Login (Secure)</h2>
        <?php if (!empty($error)) { ?>
          <p class="muted"><?php echo htmlspecialchars($error); ?></p>
        <?php } ?>
        <form method="POST">
          <input name="username" placeholder="Username" required>
          <input name="password" placeholder="Password" required type="password">
          <button type="submit">Login</button>
        </form>
        <p class="muted">No account yet? <a href="register.php">Register</a></p>
      </div>
    </div>
  </body>
</html>
