<?php
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page (change the URL as needed)
header('Location: login.php');
exit();
?>