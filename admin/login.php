<?php
session_start();
if (isset($_SESSION['username'])) {
    header('location: admin_dashboard.php');
}
?>
<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Admin Login Form | Hamro Job</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="wrapper">
        <div class="title">
            Admin Login Form
        </div>
        <form method="POST">
            <div class="field">
                <input type="text" name="username" id="username">
                <label for="username">Username</label>
            </div>
            <div class="field">
                <input type="password" name="password" id="password">
                <label for="password">Password</label>
            </div>

            <div class="field">
                <input type="submit" name="submit" value="Login">
            </div>

        </form>
    </div>
</body>

</html>

<?php

include('../connection.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $query = "SELECT * FROM admin_login WHERE username = '$username' AND password = '$password'";

    $result = mysqli_query($conn, $query);

    if ($result) {


        if (mysqli_num_rows($result) > 0) {
            $_SESSION['username'] = $username;
            header('location: admin_dashboard.php');
        } else {
            echo "<script>
        alert('Invalid Username or Password!');
      
        </script>";
        }
    }
}

?>