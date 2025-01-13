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
                    <div class="user-icon" onclick="toggleDropdown()">🤵</div>

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