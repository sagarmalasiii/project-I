<?php
include('../connection.php');

$id = $_GET['id'];

$query = "DELETE FROM jobs WHERE job_id = $id";

$result = mysqli_query($conn, $query);


header('Location: jobs.php');
