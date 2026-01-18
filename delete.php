<?php
session_start();
require "db.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET["id"] ?? 0;
$conn->query("DELETE FROM posts WHERE id=$id");

header("Location: index.php");
exit;
?>
