<?php
include('../connection.php');
include('./include/header.php');

// Get the job ID from the URL
$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch job details from the database
$sql = "SELECT * FROM jobs WHERE job_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $job = $result->fetch_assoc();
} else {
    echo "Job not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Job Details</h1>
        <p><strong>Job Title:</strong> <?php echo htmlspecialchars($job['job_title']); ?></p>
        <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($job['description'])); ?></p>
        <p><strong>Requirements:</strong> <?php echo nl2br(htmlspecialchars($job['requirements'])); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
        <p><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary']); ?></p>
        <p><strong>Deadline:</strong> <?php echo htmlspecialchars($job['deadline']); ?></p>
        <p><strong>Created Date:</strong> <?php echo htmlspecialchars($job['created_date']); ?></p>
        <button
            style=" background-color: red;
                                        color: #fff;
                                        border: none;
                                        padding: 8px 12px;
                                        border-radius: 4px;
                                        cursor: pointer;">
            <a href="delete_job.php?id=<?php echo $job['job_id']; ?>" style="text-decoration: none; color: white;">Delete</a>
        </button>
        <a href="dashboard.php" class="btn btn-secondary">Home</a>
    </div>
</body>

</html>