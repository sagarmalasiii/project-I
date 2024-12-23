<?php
include('../connection.php'); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employer_id = $_POST['employer_id']; // Fetch employer_id from POST data
    $job_title = $_POST['job_title'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $deadline = $_POST['deadline'];

    $sql = "INSERT INTO jobs (employer_id, job_title, description, requirements, location, salary, deadline) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $employer_id, $job_title, $description, $requirements, $location, $salary, $deadline);

    if ($stmt->execute()) {

        header("Location: dashboard.php"); // Redirect with success message
        exit;
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
