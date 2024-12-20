
<?php
session_start();

include ('connection.php');

// Check if user is already logged in (using session)
if (isset($_SESSION['username'])) {
    header('location: jobseeker_dashboard.php');
}

// Check if user is already logged in (using cookies)
if (isset($_COOKIE['username'])) {
    header('location: jobseeker_dashboard.php');
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);


    $query = "SELECT * FROM job_seeker WHERE username = '$username' AND password = '$password'";

    $result = mysqli_query($conn, $query);
    if($result){

    if (mysqli_num_rows($result) > 1) {
        $row = mysqli_fetch_assoc($result);

         // If "Remember Me" is checked, set the cookie
         if (isset($_POST['remember'])) {
            setcookie('username', $row['username'], time() + (86400 * 30), "/");  // Expire in 30 days
        } else {
            // If "Remember Me" is not checked, store username in session
            $_SESSION['username'] = $row['username'];
        }


        // Redirect to the landing page after successful login

        header('location: jobseeker_dashboard.php');
        exit;
    } else {
        echo "<script> alert('Login Error,Incorrect Email or Password');</script>";
    }
}
    
}
?>