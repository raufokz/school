<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page (or any other page)
header("Location: ../student/login.html");
exit();
?>
