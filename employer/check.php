<?php
session_start();

// Check if the session variable 'user_id' is set and not empty
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    // Redirect to login page with the current page URI to return after login
    header("Location: login.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
    exit; // Make sure to exit after header redirection to prevent further code execution
}

// Session is valid, you can proceed with the page logic
