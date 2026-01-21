<?php
/**
 * SECURE VERSION - New Post
 * Uses prepared statements
 */
session_start();
require "db.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"] ?? "";
    $content = $_POST["content"] ?? "";
    $author = $_SESSION["user_id"];

    // SECURE: Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO posts (title, content, author_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $content, $author);
    $stmt->execute();
    $stmt->close();
    
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>New Post - Alki Corp</title>
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>
    <div class="container">
      <div class="card">
        <h2>New Post (Secure)</h2>
        <form method="POST">
          <input name="title" placeholder="Title" required>
          <textarea name="content" placeholder="Content" required></textarea>
          <button type="submit">Create</button>
        </form>
        <p class="muted"><a href="index.php">Back to posts</a></p>
      </div>
    </div>
  </body>
</html>
