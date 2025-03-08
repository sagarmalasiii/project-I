<?php
session_start();
include('connection.php');

// Get the search query from URL parameters
$query = isset($_GET['query']) ? trim($_GET['query']) : '';

// Redirect if search query is empty
if (empty($query)) {
    header("Location: index.php");
    exit;
}

// Ensure user is logged in and get user_id from session
if (!isset($_SESSION['jobseeker_id'])) {
    header("Location: jobseeker/login.php"); // Redirect if not logged in
    exit;
}
$user_id = $_SESSION['jobseeker_id']; // Get logged-in jobseeker's ID

$sql = "SELECT jobs.job_id, jobs.job_title, jobs.description, 
        DATE_FORMAT(jobs.created_date, '%Y-%m-%d') AS formatted_date,
        companies.name AS company_name
        FROM jobs
        JOIN employer ON jobs.employer_id = employer.employer_id
        JOIN employer_company ON employer.employer_id = employer_company.employer_id
        JOIN companies ON employer_company.company_id = companies.company_id
        LEFT JOIN applications a ON jobs.job_id = a.job_id AND a.job_seeker_id = '$user_id'
        WHERE jobs.current_status = 1 
        AND jobs.is_approved = 1
        AND a.application_id IS NULL
        AND jobs.company_id = employer_company.company_id
        AND companies.company_id = jobs.company_id
        AND (jobs.job_title LIKE ? OR companies.name LIKE ?)";  // Two placeholders here.

$stmt = $conn->prepare($sql);
$searchTerm = "%$query%";  // Search term to match in both job title and company name.
$stmt->bind_param("ss", $searchTerm, $searchTerm);  // Binding only two parameters.
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Hamro Job</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top bg-light shadow">
        <div class="container-fluid">
            <a class="navbar-brand me-auto" href="about.php">Hamro Job</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav justify-content-center flex-grow-1 pe-3"></ul>
                <div class="dropdown me-2">
                    <button class="btn admin-button dropdown-toggle" type="button" id="adminDropdown" data-bs-toggle="dropdown">
                        Admin
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="./admin/login.php">Login</a></li>
                    </ul>
                </div>
                <div class="dropdown me-2">
                    <button class="btn jobseeker-button dropdown-toggle" type="button" id="jobseekerDropdown" data-bs-toggle="dropdown">
                        JobSeeker
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="./jobseeker/login.php">Login</a></li>
                        <li><a class="dropdown-item" href="./jobseeker/register.php">Register</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn employer-button dropdown-toggle" type="button" id="employerDropdown" data-bs-toggle="dropdown">
                        Employer
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="./employer/login.php">Login</a></li>
                        <li><a class="dropdown-item" href="./employer/register.php">Register</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Search Bar -->
    <div class="container mt-5 pt-4">
        <form action="search_results.php" method="GET">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Search jobs..." value="<?php echo htmlspecialchars($query); ?>" required>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

    <!-- Job Results Section -->
    <div class="container mt-4">
        <h2>Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>

        <div class="row">
            <?php
            if ($result && $result->num_rows > 0) {
                while ($job = $result->fetch_assoc()) { ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($job['job_title']); ?></h5>
                                <p class="card-text"><strong>Company:</strong> <?php echo htmlspecialchars($job['company_name']); ?></p>
                                <p class="card-text"><strong>Posted on:</strong> <?php echo htmlspecialchars($job['formatted_date']); ?></p>
                                <a href="job_details.php?job_id=<?php echo $job['job_id']; ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
            <?php }
            } else {
                echo '<p class="text-danger">No jobs found matching your search criteria.</p>';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php $conn->close(); ?>