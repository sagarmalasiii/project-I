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
    <title>Admin Login | Hamro Job</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
 @import url("https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap");
/* Imports the "Poppins" font from Google Fonts for a clean and modern typography style */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}
/* Resets default margin and padding for all elements, sets the box model to border-box for consistent sizing, and applies the Poppins font globally */

html, body {
    height: 100%;
    width: 100%;
    background: url('img/login.jpg') no-repeat center center/cover;
    display: flex;
    flex-direction: column;
    align-items: center;
}
/* Ensures the full height and width of the page are utilized, sets a background image that covers the entire viewport, and centers content in a column layout */

header {
    background: #00bcd4;
    color: white;
    padding: 20px 0;
    text-align: center;
    width: 100%;
}
/* Styles the header with a solid background color, white text, and center-aligned content */

.header-container h1 {
    margin: 0;
    font-size: 24px;
}
/* Removes extra margin from the header text and sets an appropriate font size */

footer {
    background: #00bcd4;
    color: white;
    text-align: center;
    padding: 10px 0;
    margin-top: auto;
    width: 100%;
}
/* Styles the footer with the same background as the header, centers the text, and ensures it remains at the bottom */

.footer-container p {
    margin: 0;
    font-size: 14px;
}
/* Removes default margin from the paragraph inside the footer and sets a smaller font size */

.wrapper {
    width: 100%;
    max-width: 600px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 15px;
    box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.3);
    margin: 40px 0;
}
/* Styles the login form container with a maximum width, semi-transparent white background, rounded corners, and a shadow for depth */

.wrapper .title {
    font-size: 28px;
    font-weight: 600;
    text-align: center;
    line-height: 100px;
    color: #fff;
    user-select: none;
    border-radius: 15px 15px 0 0;
    background: #00bcd4;
}
/* Styles the login form title with a larger font, bold weight, centered text, a consistent height, and a background matching the theme */

.wrapper form {
    padding: 20px 40px 50px 40px;
}
/* Adds internal spacing to the form for better layout and readability */

.wrapper form .field {
    height: auto;
    width: 100%;
    margin-top: 20px;
    position: relative;
}
/* Sets each form field to full width and adds vertical spacing */

.wrapper form .field input {
    height: 50px;
    width: 100%;
    outline: none;
    font-size: 16px;
    padding-left: 20px;
    border: 1px solid lightgrey;
    border-radius: 25px;
    transition: all 0.3s ease;
    margin-bottom: 5px;
}
/* Styles input fields with a rounded shape, a light border, padding, and a smooth transition effect */

.wrapper form .field input:focus,
form .field input:valid {
    border-color: #00bcd4;
    outline: 2px solid #00bcd4;
}
/* Highlights input fields with a blue border when focused or valid */

.wrapper form .field label {
    position: absolute;
    top: 50%;
    left: 20px;
    color: #999999;
    font-weight: 400;
    font-size: 16px;
    pointer-events: none;
    transform: translateY(-50%);
    transition: all 0.3s ease;
}
/* Positions input labels inside the input field and moves them when the user types */

form .field input:focus ~ label,
form .field input:valid ~ label {
    top: 0%;
    font-size: 14px;
    color: #00bcd4;
    background: #fff;
    transform: translateY(-50%);
}
/* Animates labels upwards when input is focused or has a valid value */

.wrapper form .field .error {
    color: red;
    font-size: 14px;
    margin-top: 2px;
    margin-left: 5px;
    display: block;
}
/* Styles error messages with red text and appropriate spacing */

form .field input[type="submit"] {
    height: 50px;
    color: #fff;
    border: none;
    margin-top: -10px;
    font-size: 18px;
    font-weight: 500;
    cursor: pointer;
    background: #00bcd4;
    transition: all 0.3s ease;
}
/* Styles the submit button with a blue background, white text, and hover effect */

form .field input[type="submit"]:active {
    transform: scale(0.95);
}
/* Slightly shrinks the button when clicked for a subtle interaction effect */

@media (max-width: 480px) {
    .wrapper {
        width: 95%;
        max-width: 400px;
    }
}
/* Makes the form more responsive by reducing its width on smaller screens */

    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="header-container">
            <h1>Welcome to Admin Panel</h1>
        </div>
    </header>

    <!-- Admin Login Form -->
    <div class="wrapper">
        <div class="title">Admin Login</div>
        <form method="POST">
            <div class="field">
                <input type="text" name="username" id="username" required>
                <label for="username">Username</label>
            </div>
            <div class="field">
                <input type="password" name="password" id="password" required>
                <label for="password">Password</label>
            </div>
            <div class="field">
                <input type="submit" name="submit" value="Login">
            </div>
        </form>
    </div>

    <!-- Footer Section -->
    <footer>
        <div class="footer-container">
            <p>&copy; 2025 Hamro Job. All rights reserved.</p>
        </div>
    </footer>
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