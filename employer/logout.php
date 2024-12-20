<?php
session_start();



// Clear the session
session_unset();
session_destroy();



// Redirect to login page
header("Location: employer_login.php");
exit;
