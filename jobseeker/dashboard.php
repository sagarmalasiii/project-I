<?php
session_start();
include('../connection.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

// Fetch jobs that the user hasn't applied for
$user_id = $_SESSION['user_id']; // Ensure the user is logged in and their ID is available

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
        AND employer_company.company_id = companies.company_id
        AND employer_company.company_id = jobs.company_id";


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
        <div id="searchresult" style="display: none;">Loading.....</div>

        <h1>Available Jobs</h1>

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
                echo '<p>No jobs available or you have applied for all available jobs.</p>';
            }
            ?>
        </div>
    </div>
    <script src="../jquery/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            let timeout;

            // Listen to the keyup event
            $("#search").keyup(function() {
                var input = $(this).val();

                // Clear the previous timeout to avoid multiple AJAX calls
                clearTimeout(timeout);

                // Trigger search after a small delay (debounce)
                timeout = setTimeout(function() {
                    if (input != "") {
                        // Show the #searchresult div with the "Loading..." message
                        $("#searchresult").html('Loading...').fadeIn();


                        // Send AJAX request
                        $.ajax({
                            url: "search_jobs.php",
                            method: "POST",
                            data: {
                                input: input
                            },
                            success: function(data) {
                                // Insert the fetched data into the #searchresult div
                                $("#searchresult").html(data); // Replace "Loading..." with the search results

                                // Use fadeIn to display the result smoothly
                                $("#searchresult").fadeIn(); // This will fade in the div


                            }
                        });
                    } else {
                        // Hide search results if the input is empty
                        $("#searchresult").fadeOut();
                    }
                }, 500); // Adjust the delay time for the debounce
            });
        });

        //Drop down feature

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