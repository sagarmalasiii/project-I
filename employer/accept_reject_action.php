<?php
include('../connection.php');

// Ensure that job_id and applicant_id are provided
if (isset($_GET['job_id']) && isset($_GET['applicant_id']) && isset($_GET['action'])) {
    $job_id = $_GET['job_id'];
    $applicant_id = $_GET['applicant_id'];
    $action = $_GET['action'];

    // Validate action type (accept or reject)
    if ($action == 'accept') {
        $status = 1; // Accepted
    } elseif ($action == 'reject') {
        $status = 2; // Rejected
    } else {
        echo "<script>alert('Invalid action.'); window.location.href = 'view_applicants_details.php?job_id=" . $job_id . "';</script>";
        exit;
    }

    // Update the status of the application in the database
    $query = "UPDATE applications SET application_status = ? WHERE job_id = ? AND job_seeker_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $status, $job_id, $applicant_id);
    $stmt->execute();

    // Redirect back to the applicants view page
    echo "<script>alert('Applicant status updated successfully.'); window.location.href = 'view_applicants_details.php?job_id=" . $job_id . "';</script>";
} else {
    echo "<script>alert('Invalid parameters.'); window.location.href = 'dashboard.php';</script>";
}
?>
