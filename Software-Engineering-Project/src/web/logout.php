<?php
// logout.php
session_start();

if (isset($_POST['logout'])) {
    // Logout logic
    $_SESSION = array(); // Unset all session variables
    session_destroy(); // Destroy the session
    setcookie(session_name(), '', time() - 42000); // Delete the session cookie
    header("Location: login.php");
    exit;
}
?>