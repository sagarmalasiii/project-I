<?php


include('../connection.php');



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $company_name = trim($_POST['company_name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = md5(trim($_POST['password']));

    // Validate required fields
    if (empty($company_name) || empty($email) || empty($username) || empty($password)) {
        echo "All fields are required.";
        exit;
    }


    $query = "INSERT INTO employer (company_name,email, username, password) VALUES('$company_name', '$email','$username', '$password')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        header('location: login.html');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
