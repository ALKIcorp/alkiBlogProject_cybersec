<?php
/**
 * SECURE VERSION - Index/Home
 * Uses htmlspecialchars() for output encoding
 */
session_start();
require "db.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// This query has no user input, so it's safe as-is
// But we still use htmlspecialchars() on output
$result = $conn->query("SELECT * FROM posts ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Alki Corp Blog</title>
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>
    <div class="container">
      <h1>Alki Corp Blog (Secure)</h1>
      <p class="muted">
        <!-- SECURE: Use htmlspecialchars() to prevent XSS -->
        Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?> |
        <a href="logout.php">Logout</a>
      </p>
      <p><a href="new_post.php">Create Post</a></p>
      <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="card">
          <!-- SECURE: Use htmlspecialchars() to prevent XSS -->
          <h2><?php echo htmlspecialchars($row["title"]); ?></h2>
          <p><?php echo htmlspecialchars($row["content"]); ?></p>
          <p>
            <a href="view.php?id=<?php echo (int)$row["id"]; ?>">View</a>
            |
            <a href="delete.php?id=<?php echo (int)$row["id"]; ?>">Delete</a>
          </p>
        </div>
      <?php } ?>
    </div>
  </body>
</html>
