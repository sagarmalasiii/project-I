<?php
session_start();

// Check if the session variable 'username' is set and not empty
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    // Redirect to login page if the session is not valid
    header("Location: login.html");
    exit; // Make sure to exit after header redirection to prevent further code execution
}

// Session is valid, you can proceed with the page logic
