<?php
/**
 * SECURE VERSION - Add Comment
 * Uses prepared statements
 */
session_start();
require "db.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$post_id = $_POST["post_id"] ?? 0;
$comment = $_POST["comment"] ?? "";

// SECURE: Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO comments (post_id, comment_content) VALUES (?, ?)");
$stmt->bind_param("is", $post_id, $comment);
$stmt->execute();
$stmt->close();

header("Location: view.php?id=" . (int)$post_id);
exit;
?>
