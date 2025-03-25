<?php
session_start();
include('include/header.php');
include('../connection.php');

// Check if the job ID is provided
if (!isset($_GET['job_id'])) {
    echo "<script>alert('Job ID not specified!'); window.location.href = 'dashboard.php';</script>";
    exit;
}

$job_id = $_GET['job_id'];

// Query to get the job details (e.g., job title)
$queryJob = "SELECT job_title FROM jobs WHERE job_id = ?";
$stmtJob = $conn->prepare($queryJob);
$stmtJob->bind_param("i", $job_id);
$stmtJob->execute();
$resultJob = $stmtJob->get_result();

if ($resultJob->num_rows > 0) {
    $job = $resultJob->fetch_assoc(); // Fetch the job title
} else {
    echo "<script>alert('Job not found!'); window.location.href = 'dashboard.php';</script>";
    exit;
}

// Query to get job applicants along with their profile picture
$queryApplicants = "
    SELECT ja.job_seeker_id, js.full_name, js.email, js.username, js.profile_picture, js.resume_path, ja.application_status, ja.applied_date
    FROM applications ja
    JOIN job_seeker js ON ja.job_seeker_id = js.job_seeker_id
    WHERE ja.job_id = ?";

$stmtApplicants = $conn->prepare($queryApplicants);
$stmtApplicants->bind_param("i", $job_id);
$stmtApplicants->execute();
$resultApplicants = $stmtApplicants->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicants for Job - <?= htmlspecialchars($job['job_title']) ?></title>
    <link rel="stylesheet" href="css/view_app_details.css">
</head>

<body>
    <div class="container">
        <h1>Applicants for Job: <?= htmlspecialchars($job['job_title']) ?></h1>

        <?php if ($resultApplicants->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Profile Picture</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Resume</th>
                        <th>Application Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($applicant = $resultApplicants->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php if (!empty($applicant['profile_picture'])): ?>
                                    <img src="../jobseeker/<?= htmlspecialchars($applicant['profile_picture']) ?>" alt="Profile Picture" class="profile-pic">
                                <?php else: ?>
                                    <img src="default-profile.png" alt="Default Profile Picture" class="profile-pic">
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($applicant['full_name']) ?></td>
                            <td><?= htmlspecialchars($applicant['email']) ?></td>
                            <td><?= htmlspecialchars($applicant['username']) ?></td>
                            <td>
                                <a href="../jobseeker/<?= htmlspecialchars($applicant['resume_path']) ?>" target="_blank">View Resume</a>
                            </td>
                            <td><?= htmlspecialchars($applicant['applied_date']) ?></td>
                            <td>
                                <?php if ($applicant['application_status'] == 0): ?>
                                    <a href="accept_reject_action.php?job_id=<?= $job_id ?>&applicant_id=<?= $applicant['job_seeker_id'] ?>&action=accept" class="action-btn">Accept</a>
                                    <a href="accept_reject_action.php?job_id=<?= $job_id ?>&applicant_id=<?= $applicant['job_seeker_id'] ?>&action=reject" class="reject-btn">Reject</a>
                                <?php elseif ($applicant['application_status'] == 1): ?>
                                    <span>Accepted</span>
                                <?php elseif ($applicant['application_status'] == 2): ?>
                                    <span>Rejected</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No applicants found for this job.</p>
        <?php endif; ?>
    </div>
</body>

</html>

<?php
// Close connections
$stmtJob->close();
$stmtApplicants->close();
mysqli_close($conn);
?>