<?php
session_start();
include('include/header.php');
include('../connection.php');


// Fetch employer ID from session
$employer_id = $_SESSION['user_id'];



$query = "SELECT jobs.job_id, jobs.job_title, jobs.deadline, companies.name AS company_name, 
                 COUNT(applications.job_id) AS num_applicants
          FROM jobs
          LEFT JOIN applications ON jobs.job_id = applications.job_id
          JOIN companies ON jobs.company_id = companies.company_id
          WHERE jobs.employer_id = $employer_id
          GROUP BY jobs.job_id, companies.name";



$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View Applicants</title>
    <link rel="stylesheet" href="css/view_applicants.css">
</head>

<body>

    <table class="job-table">
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Company</th>
                <th>Number of Applicants</th>
                <th>Deadline</th>
                <th>View Applicants</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch and display job data
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['job_title'] . "</td>";
                echo "<td>" . $row['company_name'] . "</td>"; // Display the company name
                echo "<td>" . $row['num_applicants'] . "</td>";
                echo "<td>" . $row['deadline'] . "</td>";
                echo "<td><a href='view_applicants_details.php?job_id=" . $row['job_id'] . "' class='btn-view'>View</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</body>

</html>