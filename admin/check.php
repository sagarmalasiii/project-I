<?php
session_start();

// Check if the session variable 'username' is set and not empty
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    // Redirect to login page if the session is not valid
    header("Location: login.php");
    exit; // Make sure to exit after header redirection to prevent further code execution
}
