<?php
/**
 * SECURE VERSION - Delete Post
 * Uses prepared statements
 */
session_start();
require "db.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET["id"] ?? 0;

// SECURE: Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: index.php");
exit;
?>
