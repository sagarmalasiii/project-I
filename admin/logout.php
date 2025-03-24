<?php
session_start();



// Clear the session
session_unset();
session_destroy();
session_start();



// Redirect to login page
header("Location: login.php");
exit;
