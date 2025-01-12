<?php
include('../connection.php');

$id = $_GET['id'];

$query = "UPDATE jobs  SET is_approved = 1 WHERE job_id = $id";

$result = mysqli_query($conn, $query);
if ($result) {
    echo "<script> alert('Job Approved Successfully');</script>";
}

header('Location: jobs.php');
