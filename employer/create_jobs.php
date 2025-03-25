<?php
session_start();
include('include/header.php');
include('../connection.php');

$employer_id = $_SESSION['user_id'];

// Verify if the employer is verified
$checkVerification = "SELECT * FROM employer WHERE employer_id = '$employer_id' AND is_verified = 1";
$checkVerificationResult = mysqli_query($conn, $checkVerification);

if (mysqli_num_rows($checkVerificationResult) == 0) {
    echo "<script>alert('You need to verify your account before posting a job.');</script>";
    echo "<script>window.location.href = 'dashboard.php';</script>";
    exit;
}

// Fetch the companies associated with the employer
$companiesQuery = "SELECT c.company_id, c.name 
                   FROM companies c
                   JOIN employer_company ec ON c.company_id = ec.company_id
                   WHERE ec.employer_id = '$employer_id'";
$companiesResult = mysqli_query($conn, $companiesQuery);

// Check if the employer has any companies linked
if (mysqli_num_rows($companiesResult) == 0) {
    echo "<script>alert('You need to add a company before posting a job.');</script>";
    echo "<script>window.location.href = 'add_company.php';</script>";
    exit;
}

/// When submitting the job posting
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company_id = mysqli_real_escape_string($conn, $_POST['company_id']);
    $job_title = mysqli_real_escape_string($conn, $_POST['job_title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $requirements = mysqli_real_escape_string($conn, $_POST['requirements']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);
    $deadline = mysqli_real_escape_string($conn, $_POST['deadline']);

    // Ensure that the employer is posting for a valid company
    $checkCompanyQuery = "SELECT * FROM employer_company 
                          WHERE employer_id = '$employer_id' AND company_id = '$company_id'";
    $checkCompanyResult = mysqli_query($conn, $checkCompanyQuery);

    // If the employer is not associated with the selected company
    if (mysqli_num_rows($checkCompanyResult) == 0) {
        echo "<script>alert('You are not associated with this company.');</script>";
        echo "<script>window.location.href = 'dashboard.php';</script>";
        exit;
    }

    // Insert the job into the jobs table for the selected company
    $insertJob = "INSERT INTO jobs (employer_id, company_id, job_title, description, requirements, location, salary, deadline)
                  VALUES ('$employer_id', '$company_id', '$job_title', '$description', '$requirements', '$location', '$salary', '$deadline')";

    if (mysqli_query($conn, $insertJob)) {
        echo "<script>alert('Job posted successfully!');</script>";
        echo "<script>window.location.href = 'dashboard.php';</script>";
    } else {
        echo "<script>alert('Error posting job.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Job</title>
    <link rel="stylesheet" href="./css/create_jobs.css">
</head>

<body>
    <div class="container">
        <h1>Post a Job</h1>

        <form action="" method="POST">
            <label for="company_id">Select Company</label>
            <select id="company_id" name="company_id" required>
                <option value="">Select Company</option>
                <?php
                while ($row = mysqli_fetch_assoc($companiesResult)) {
                    echo "<option value='" . $row['company_id'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select>

            <label for="job_title">Job Title</label>
            <input type="text" id="job_title" name="job_title" placeholder="Enter the job title" required>

            <label for="description">Job Description</label>
            <textarea id="description" name="description" rows="5" placeholder="Describe the job responsibilities, benefits, etc." required></textarea>

            <label for="requirements">Job Requirements</label>
            <textarea id="requirements" name="requirements" rows="3" placeholder="List the qualifications and skills required" required></textarea>

            <label for="location">Location</label>
            <input type="text" id="location" name="location" placeholder="Enter the job location" required>

            <label for="salary">Salary (Optional)</label>
            <input type="text" id="salary" name="salary" placeholder="Enter the salary range">

            <label for="deadline">Application Deadline</label>
            <input type="date" id="deadline" name="deadline" required min="<?php echo date('Y-m-d'); ?>">

            <button type="submit">Post Job</button>
            <button type="button" class="cancel" onclick="window.location.href='dashboard.php'">Cancel</button>
        </form>
    </div>
</body>

</html>