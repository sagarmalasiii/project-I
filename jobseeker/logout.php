<?php
session_start();

// Clear the session
session_unset();
session_destroy();

// Clear the cookie
setcookie('username', '', time() - 3600, "/");  // Expire the cookie by setting a past time

// Redirect to login page
header("Location: jobseeker_login.php");
exit;
