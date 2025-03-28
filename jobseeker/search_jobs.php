<?php
session_start();
include('../connection.php');

if (!isset($_SESSION['jobseeker_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

// Get the search query from the request
$query = isset($_POST['input']) ? $_POST['input'] : '';

// Fetch search results based on job title
$user_id = $_SESSION['jobseeker_id'];

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
        AND (jobs.job_title LIKE ? OR companies.name LIKE ? OR jobs.requirements)";  // Two placeholders here.

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
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dashboard.css"> <!-- Ensure this path is correct -->
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <a href="dashboard.php" style="text-decoration: none; color: inherit;">
            <h1>Hamro Job</h1>
        </a>
        <div class="search-container">
            <form action="search_jobs.php" method="POST">
                <input type="text" id="search" name="input" placeholder="Search by Job Title..." value="<?php echo htmlspecialchars($query); ?>" required>
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="icons">
            <span id="Home" title="Home">🏠</span>
            <a href="applied_jobs.php"><span id="Applied jobs" title="Applied Jobs">📝</span></a>
            <span id="Profile" title="Profile" onclick="toggleDropdown()">👤</span>
            <div id="profile-dropdown" class="profile-dropdown">
                <a href="my_profile.php">My Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div class="container my-4">
        <h1>Search Results for "<?php echo htmlspecialchars($query); ?>"</h1>

        <div class="row g-4" id="job-list">
            <?php
            // Check if the query returned results
            if ($result && $result->num_rows > 0) {
                while ($job = $result->fetch_assoc()) { ?>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $job['job_title']; ?></h5>
                                <p class="card-text text-muted">
                                    Company: <?php echo $job['company_name']; ?>
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
            ?>
        </div>
    </div>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Dropdown feature for Profile
        function toggleDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
        }

        window.onclick = function(event) {
            if (!event.target.matches('#Profile')) {
                const dropdown = document.getElementById('profile-dropdown');
                if (dropdown.style.display === 'block') {
                    dropdown.style.display = 'none';
                }
            }
        }
    </script>
</body>

</html>

<?php $conn->close(); ?>