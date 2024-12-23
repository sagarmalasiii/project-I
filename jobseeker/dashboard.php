<?php
session_start();

// Check if the user is logged in via cookie or session
if (isset($_COOKIE['username'])) {
    $username = $_COOKIE['username'];
} elseif (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // Redirect to login page if the user is not logged in
    header('Location: login.html');
    exit;
}
?>
<h2>Hello, <?php echo $username; ?></h2>

<a href="logout.php">Logout</a>
</body>