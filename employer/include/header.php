<?php
session_start();

// Redirect if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Include the database connection file
include('../connection.php'); // Make sure to include the connection

// Retrieve employer details from the database
$employer_id = $_SESSION['user_id'];

// Fetch employer details from the database
$query = "SELECT * FROM employer WHERE employer_id = '$employer_id'";
$result = mysqli_query($conn, $query);

// Check if the employer exists
if ($result && mysqli_num_rows($result) > 0) {
    $employer = mysqli_fetch_assoc($result); // Fetch employer data
} else {
    // Redirect if employer not found
    header('Location: login.php');
    exit;
}

// Set the profile image if available, else use default
$profile_image = !empty($employer['profile_image']) && file_exists("uploads/" . urlencode($employer['profile_image']))
    ? "uploads/" . urlencode($employer['profile_image'])
    : "uploads/default.jpg";

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/header.css">




</head>

<body>
    <header>
        <div class="logo"><a href="dashboard.php">Hamro Job</a></div>
        <nav>
            <ul>
                <li><a href="dashboard.php" title="Home"><img src="img/house.svg" alt="Home" class="svg-icon"></a></li>
                <li><a href="create_jobs.php" title="Create Jobs"><img src="img/clipboard.svg" alt="Create Jobs" class="svg-icon"></a></li>
                <li><a href="view_applicants.php" title="View Applicants"><img src="img/book.svg" alt="View Applicants" class="svg-icon"></a></li>
                <li class="user-menu">
                    <!-- User Icon -->
                    <div class="user-icon" onclick="toggleDropdown()"><img src="<?php echo $profile_image; ?>" alt="Profile Picture"></div>

                    <!-- Dropdown Menu -->
                    <div class="dropdown">
                        <a href="profile.php">Profile</a>
                        <a href="logout.php">Logout</a>
                        <a href="add_company.php">Add Company</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>



    <script>
        // Toggle the dropdown visibility
        function toggleDropdown() {
            const userMenu = document.querySelector('.user-menu');
            userMenu.classList.toggle('active');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.querySelector('.user-menu');
            if (!userMenu.contains(event.target)) {
                userMenu.classList.remove('active');
            }
        });
    </script>