<?php
session_start();

// Unset specific session variable for admin
unset($_SESSION['admin_email']);

// Destroy the session
session_destroy();

// Redirect to the login page (change the URL as needed)
header('Location: admin-login.php');
exit();
?>