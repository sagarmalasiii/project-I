<?php
include('../connection.php');



$id = $_GET['id'];

$query = "DELETE FROM job_seeker WHERE job_seeker_id=$id";

$result = mysqli_query($conn, $query);


header('Location: job_seeker.php');
