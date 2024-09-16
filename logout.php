<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session to fully log out the user
session_destroy();

// Redirect the user back to the login page
header("Location: login.php");
exit();
?>
