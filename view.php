<?php
session_start();
require "db.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET["id"] ?? 0;
$post = $conn->query("SELECT * FROM posts WHERE id=$id")->fetch_assoc();
$comments = $conn->query("SELECT * FROM comments WHERE post_id=$id ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>View Post - Alki Corp</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="container">
      <div class="card">
        <h1><?php echo $post["title"]; ?></h1>
        <p><?php echo $post["content"]; ?></p>
        <p class="muted"><a href="index.php">Back to posts</a></p>
      </div>

      <div class="card">
        <h3>Comments</h3>
        <?php while ($row = $comments->fetch_assoc()) { ?>
          <div class="card"><?php echo $row["comment_content"]; ?></div>
        <?php } ?>
      </div>

      <div class="card">
        <h3>Add Comment</h3>
        <form method="POST" action="add_comment.php">
          <input type="hidden" name="post_id" value="<?php echo $id; ?>">
          <textarea name="comment" required></textarea>
          <button type="submit">Add Comment</button>
        </form>
      </div>
    </div>
  </body>
</html>
