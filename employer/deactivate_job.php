<?php
include('../connection.php');

$id = $_GET['id'];

$query = "UPDATE jobs  SET current_status = 0 WHERE job_id = $id";

$result = mysqli_query($conn, $query);
if ($result) {
    echo "<script> alert('Job Deactivated Successfully');</script>";
   
    echo "<script>window.location.href = 'dashboard.php';</script>";
}else{
    echo "Error deactivating job: ". mysqli_error($conn);
}


