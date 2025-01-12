<?php
session_start();
include('../connection.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}
// Fetch jobs that the user hasn't applied for
$user_id = $_SESSION['user_id']; // Make sure the user is logged in and their ID is available

$sql = "SELECT jobs.job_id, jobs.job_title, jobs.description, 
        DATE_FORMAT(jobs.created_date, '%Y-%m-%d') AS formatted_date,
        companies.name
        FROM jobs
        JOIN employer ON jobs.employer_id = employer.employer_id
        JOIN employer_company ON employer.employer_id = employer_company.employer_id
        JOIN companies ON employer_company.company_id = companies.company_id
        LEFT JOIN applications a ON jobs.job_id = a.job_id AND a.job_seeker_id = '$user_id'
        WHERE jobs.current_status = 1 AND a.application_id IS NULL";

$result = $conn->query($sql);

// Check if the query was successful
if ($result === false) {
    echo "Error fetching jobs: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hamro Job Dashboard</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
    <div class="navbar">
        <h1>Hamro Job</h1>
        <div class="search-container">
            <input type="text" id="search" placeholder="Search jobs..." onkeyup="searchJobs()">
            <button onclick="searchJobs()">Search</button>
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

    <div class="container my-4">
        <h1>Available Jobs</h1>
        <div id="loading" style="display: none;">Loading...</div> <!-- Add a loading spinner -->
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
                echo '<p>No jobs available or you have applied for all available jobs.</p>';
            }
            ?>
        </div>
    </div>


    <script>
        let debounceTimer;

        function searchJobs() {
            clearTimeout(debounceTimer);
            document.getElementById('loading').style.display = 'block'; // Show loading spinner

            const searchQuery = document.getElementById('search').value;

            debounceTimer = setTimeout(function() {
                if (searchQuery.trim() !== '') {
                    // Send AJAX request to search jobs
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', 'search_jobs.php?query=' + encodeURIComponent(searchQuery), true);

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            // Hide the loading spinner
                            document.getElementById('loading').style.display = 'none';

                            // Update the job list with the search results
                            const jobListContainer = document.getElementById('job-list');
                            jobListContainer.innerHTML = xhr.responseText;
                        }
                    };

                    xhr.send();
                } else {
                    // If the search field is empty, reset the job list
                    document.getElementById('job-list').innerHTML = '';
                    document.getElementById('loading').style.display = 'none';
                }
            }, 500); // Add a delay before the AJAX request is sent
        }



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