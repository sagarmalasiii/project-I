<?php
include('connection.php');

if (isset($_POST['register'])) {
   

    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    echo $query = "INSERT INTO job_seeker (full_name, email, username, password) VALUES ('$fullName', '$email', '$username', '$password')";
   
    $result = mysqli_query($conn, $query);
    if ($result) {
        header('location: jobseeker_login.php');
    } else {
        echo "<script>alert('Registration Failed!')</script>";
    }
}
?>