<?php
include('connection/connection.php');

$id = $_GET['id'];

$query = "DELETE FROM employer WHERE employer_id = $id";

$result = mysqli_query($conn, $query);
if ($result) {
    echo "<script>Employer Deleted Successfully</script>";
}

header('Location: employer.php');
