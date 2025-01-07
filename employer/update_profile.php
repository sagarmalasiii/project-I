<?php
include('../connection.php'); // Include your database connection
session_start(); // Start session to get user_id from session

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Get the employer ID from the session
$employer_id = $_SESSION['user_id'];

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the posted data
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $companies = isset($_POST['companies']) ? $_POST['companies'] : [];

    // Validate the inputs (you can add more validation as needed)
    if (empty($full_name) || empty($email) || empty($username)) {
        echo "All fields are required.";
        exit;
    }

    // Update the employer's details in the database
    $update_query = "UPDATE employer SET full_name = '$full_name', email = '$email', username = '$username' WHERE employer_id = '$employer_id'";

    if (mysqli_query($conn, $update_query)) {
        // If the employer's details are updated successfully, update the companies
        // First, remove any existing associations
        $delete_query = "DELETE FROM employer_company WHERE employer_id = '$employer_id'";
        mysqli_query($conn, $delete_query);

        // Now insert the new associations for companies
        if (!empty($companies)) {
            foreach ($companies as $company_id) {
                $insert_query = "INSERT INTO employer_company (employer_id, company_id) VALUES ('$employer_id', '$company_id')";
                mysqli_query($conn, $insert_query);
            }
        }

        echo "Profile updated successfully.";
        header('Location: profile.php'); // Redirect to the profile page after updating
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn); // Close the database connection
