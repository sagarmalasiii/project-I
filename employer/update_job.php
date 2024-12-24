<?php
include('../connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $job_id = $_POST['job_id'];


    $employer_id = $_POST['employer_id']; // Fetch employer_id from POST data

    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $deadline = $_POST['deadline'];

    $query = "UPDATE jobs 
              SET  
                  description = '$description', 
                  requirements = '$requirements', 
                  location = '$location', 
                  salary = '$salary', 
                  deadline = '$deadline' 
              WHERE job_id = $job_id AND employer_id = $employer_id";

    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php");
    } else {
        echo "Error updating job: " . mysqli_error($conn);
    }
}
