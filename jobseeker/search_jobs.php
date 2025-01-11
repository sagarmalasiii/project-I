<?php
session_start();
include('../connection.php');

// Get the search query from the request
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Ensure the user is logged in and get their user ID
$user_id = $_SESSION['user_id'];

// SQL query to search for jobs the user has not applied for
$sql = "SELECT jobs.job_id, jobs.job_title, jobs.description, 
        DATE_FORMAT(jobs.created_date, '%Y-%m-%d') AS formatted_date,
        companies.name
        FROM jobs
        JOIN employer ON jobs.employer_id = employer.employer_id
        JOIN employer_company ON employer.employer_id = employer_company.employer_id
        JOIN companies ON employer_company.company_id = companies.company_id
        LEFT JOIN applications a ON jobs.job_id = a.job_id AND a.job_seeker_id = '$user_id'
        WHERE jobs.current_status = 1 AND a.application_id IS NULL 
        AND (jobs.job_title LIKE '%$query%' OR companies.name LIKE '%$query%')";

$result = $conn->query($sql);

// Check if the query was successful
if ($result && $result->num_rows > 0) {
    while ($job = $result->fetch_assoc()) { ?>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $job['job_title']; ?></h5>
                    <p class="card-text text-muted">
                        Company: <?php echo $job['name']; ?>
                    </p>
                    <p class="card-text text-muted">
                        Posted: <?php echo $job['formatted_date']; ?>
                    </p>
                    <a href="job_details.php?job_id=<?php echo $job['job_id']; ?>" class="btn btn-primary">
                        View Details
                    </a>
                </div>
            </div>
        </div>
<?php }
} else {
    echo '<p>No jobs found matching your search criteria.</p>';
}

$conn->close();
?>