<?php
/**
 * SECURE VERSION - View Post
 * Uses prepared statements and htmlspecialchars() for output
 */
session_start();
require "db.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET["id"] ?? 0;

// SECURE: Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();
$stmt->close();

// SECURE: Use prepared statement for comments query
$stmt = $conn->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $id);
$stmt->execute();
$comments = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>View Post - Alki Corp</title>
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>
    <div class="container">
      <div class="card">
        <!-- SECURE: Use htmlspecialchars() to prevent XSS -->
        <h1><?php echo htmlspecialchars($post["title"] ?? ""); ?></h1>
        <p><?php echo htmlspecialchars($post["content"] ?? ""); ?></p>
        <p class="muted"><a href="index.php">Back to posts</a></p>
      </div>

      <div class="card">
        <h3>Comments</h3>
        <?php while ($row = $comments->fetch_assoc()) { ?>
          <!-- SECURE: Use htmlspecialchars() to prevent XSS -->
          <div class="card"><?php echo htmlspecialchars($row["comment_content"]); ?></div>
        <?php } ?>
      </div>

      <div class="card">
        <h3>Add Comment</h3>
        <form method="POST" action="add_comment.php">
          <input type="hidden" name="post_id" value="<?php echo (int)$id; ?>">
          <textarea name="comment" required></textarea>
          <button type="submit">Add Comment</button>
        </form>
      </div>
    </div>
  </body>
</html>
<?php $stmt->close(); ?>
