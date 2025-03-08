<?php
session_start();
include('connection.php');


// Get job ID from URL
$job_id = intval($_GET['job_id'] ?? 0);
$sql = "SELECT jobs.job_title, jobs.description, jobs.created_date,  
            jobs.requirements,
            jobs.location,
            jobs.deadline, 
               companies.name, employer.full_name
        FROM jobs
        JOIN employer ON jobs.employer_id = employer.employer_id
        JOIN employer_company ON employer.employer_id = employer_company.employer_id
        JOIN companies ON employer_company.company_id = companies.company_id
        WHERE jobs.job_id = $job_id AND jobs.current_status = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $job = $result->fetch_assoc();
} else {
    echo "<p>Job not found or inactive.</p>";
    exit;
}

// Get user details from session (example user_id)
$user_id = $_SESSION['jobseeker_id']  ?? null; // Get user_id from session
if (!$user_id) {
    echo "<p>Please login to apply for the job.</p>";
    exit;
}

// Fetch the existing resume of the job seeker from the database
$sql = "SELECT resume_path FROM job_seeker WHERE job_seeker_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $resume_path = $user['resume_path'];
} else {
    echo "<p>User not found.</p>";
    exit;
}

// Check if form is submitted (without file upload)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($resume_path) { // If resume exists, proceed with the application
        $sql = "INSERT INTO applications (job_seeker_id, job_id, resume_path, applied_date) 
                VALUES ($user_id, $job_id, '$resume_path', NOW())";
        if ($conn->query($sql) === TRUE) {
            // Set session variable or query to indicate application was successful
            $_SESSION['application_success'] = true;
        } else {
            echo "<p>Error applying for the job: " . $conn->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
    <link rel="stylesheet" href="css/job_details.css">
</head>

<body>
    <div class="navbar">
        <h1>Job Details</h1>
        <a href="index.php" style="color: white;">Back to Home</a>
    </div>

    <div class="content">
        <h1><?php echo htmlspecialchars($job['job_title']); ?></h1>
        <p><strong>Company:</strong> <?php echo htmlspecialchars($job['name']); ?></p>
        <p><strong>Posted by:</strong> <?php echo htmlspecialchars($job['full_name']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
        <p><strong>Posted on:</strong> <?php echo date('Y-m-d', strtotime($job['created_date'])); ?></p>
        <p><strong>Application Deadline:</strong> <?php echo date('Y-m-d', strtotime($job['deadline'])); ?></p>

        <h4>Job Description</h4>
        <p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>
        <h4>Requirements</h4>
        <p><?php echo nl2br(htmlspecialchars($job['requirements'])); ?></p>
        <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Jobs</a>

        <!-- Apply button -->
        <form method="POST" id="applyForm" action="./jobseeker/login.php">
            <button type="submit" class="apply-btn" id="applyButton" >Apply</button>
        </form>

        <?php if (!$resume_path): ?>
            <p style="color: red;">Please login to apply for this job.</p>
        <?php endif; ?>
    </div>

    <!-- Success Popup (only shows when application is successful) -->
    <div class="popup-overlay" id="popup-overlay" style="display: <?php echo isset($_SESSION['application_success']) ? 'block' : 'none'; ?>"></div>
    <div class="popup" id="popup" style="display: <?php echo isset($_SESSION['application_success']) ? 'block' : 'none'; ?>">
        <p>Applied Successfully!!!</p>
        <button onclick="closePopup()">Close</button>
    </div>

    <script>
        // JavaScript for popup functionality
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('popup-overlay').style.display = 'none';

            // Clear the success flag in the session
            <?php unset($_SESSION['application_success']); ?>
        }
    </script>
</body>

</html>