<?php
session_start();

// Unset specific session variable for student
unset($_SESSION['student_email']);

// Destroy the session
session_destroy();

// Redirect to the login page (change the URL as needed)
header('Location: index.html');
exit();
?>