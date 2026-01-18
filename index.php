<?php
session_start();
require "db.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
$result = $conn->query("SELECT * FROM posts ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Alki Corp Blog</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="container">
      <h1>Alki Corp Blog</h1>
      <p class="muted">
        Welcome, <?php echo $_SESSION["username"]; ?> |
        <a href="logout.php">Logout</a>
      </p>
      <p><a href="new_post.php">Create Post</a></p>
      <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="card">
          <h2><?php echo $row["title"]; ?></h2>
          <p><?php echo $row["content"]; ?></p>
          <p>
            <a href="view.php?id=<?php echo $row["id"]; ?>">View</a>
            |
            <a href="delete.php?id=<?php echo $row["id"]; ?>">Delete</a>
          </p>
        </div>
      <?php } ?>
    </div>
  </body>
</html>
