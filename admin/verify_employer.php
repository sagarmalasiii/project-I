<?php
include('../connection.php');

$id = $_GET['id'];

$query = "UPDATE employer  SET is_verified = 1 WHERE employer_id = $id";

$result = mysqli_query($conn, $query);
if ($result) {

    header('Location: employer.php');
}
