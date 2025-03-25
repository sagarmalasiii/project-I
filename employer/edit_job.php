<?php
session_start();
include('include/header.php');
include('../connection.php');



$employer_id = $_SESSION['user_id'];
$job_id = $_GET['id'];

// Fetch job details
$query = "SELECT * FROM jobs WHERE job_id = $job_id AND employer_id = $employer_id";

$result = mysqli_query($conn, $query);
$job = mysqli_fetch_assoc($result);

if (!$job) {
    echo "Job not found or you do not have permission to edit this job.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Update Job</title>
    <link rel="stylesheet" href="./css/edit_job.css">

</head>

<body>
    <div class="container">
        <h1>Update Job</h1>

        <form action="update_job.php" method="POST">
            <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
            <input type="hidden" name="employer_id" value="<?php echo $employer_id; ?>">

            <label for="job_title">Job Title</label>
            <input type="text" id="job_title" name="job_title" value="<?php echo $job['job_title']; ?>" required disabled>

            <label for="description">Job Description</label>
            <textarea id="description" name="description" rows="5" required><?php echo $job['description']; ?></textarea>

            <label for="requirements">Job Requirements</label>
            <textarea id="requirements" name="requirements" rows="3" required><?php echo $job['requirements']; ?></textarea>

            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="<?php echo $job['location']; ?>" required>

            <label for="salary">Salary (Optional)</label>
            <input type="text" id="salary" name="salary" value="<?php echo $job['salary']; ?>">

            <label for="deadline">Application Deadline</label>
            <input type="date" id="deadline" name="deadline" value="<?php echo $job['deadline']; ?>" required>

            <button type="submit">Update Job</button>
            <button type="button" class="cancel" onclick="window.location.href='dashboard.php'">Cancel</button>
        </form>
    </div>
</body>

</html>