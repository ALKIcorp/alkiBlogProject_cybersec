<?php
/**
 * SECURE VERSION - Logout
 * Same as original (no SQL involved)
 */
session_start();
session_destroy();
header("Location: login.php");
exit;
?>
