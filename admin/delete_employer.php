<?php
include('../connection.php');

$id = $_GET['id'];

$query = "DELETE FROM employer WHERE employer_id = $id";

$result = mysqli_query($conn, $query);

if ($result){
    
    header('Location: employer.php');
}


