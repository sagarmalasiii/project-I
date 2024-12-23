<?php
// login.php

session_start();

include('../connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = md5(trim($_POST['password']));

    // Validate inputs
    if (empty($username) || empty($password)) {
        echo "<p style='color: red;'>Both fields are required.</p>";
    } else {
        // Check for user in the database
        $query = "SELECT * FROM employer WHERE username = '$username' AND password = '$password'";  // Fixed the missing quote here
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Error: " . mysqli_error($conn));
        }

        // Get the user's information from the result set
        $row = mysqli_fetch_assoc($result);
        $id = $row['employer_id'];
        $username = $row['username'];

        // If user exists, start the session and redirect to dashboard.php
        if (mysqli_num_rows($result) == 1) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<p style='color: red;'>Incorrect username or password.</p>";
        }
    }
    mysqli_close($conn);
}
