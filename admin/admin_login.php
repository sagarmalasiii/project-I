<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.1/assets/img/favicons/favicon.ico">

    <title>Admin Log In</title>

    <!-- Custom styles for this template -->
    <link href="css/admin_login.css" rel="stylesheet">
    <link href="../boostrap/css/bootstrap.css" rel="stylesheet">
</head>

<body class="text-center">
    <form class="form-signin" id="admin_login" name="admin_login" method="post" action="admin_login.php">
        <img class="mb-4" src="img/logo.jpg" alt="" width="102" height="102">
        <h1 class="h3 mb-3 font-weight-normal">Please Login in</h1>
       
        <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required autofocus>
       
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>

        <input class="btn btn-lg btn-primary btn-block" id="submit" name="submit" value="Log In" type="submit" />
        <p class="mt-5 mb-3 text-muted">&copy; 2024-2025</p>
    </form>

    <script src="../boostrap/js/bootstrap.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- <script src="js/admin_login.js"></script> -->
</body>

</html>

<?php

include('connection/connection.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $query = "SELECT * FROM admin_login WHERE username = '$username' AND password = '$password'";

    $result = mysqli_query($conn, $query);

    if($result){

    
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