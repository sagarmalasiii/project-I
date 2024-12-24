<?php
include('check.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
    <link rel="stylesheet" href="./css/styles.css">
    <style>
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #37B7C3;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.5em;
        }

        nav ul {
            list-style: none;
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin-left: 20px;
            position: relative;
        }

        .user-menu {
            position: relative;
        }

        .user-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #2D8C92;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            cursor: pointer;
            padding: 10px;
            margin-left: 20px;
            /* Ensures some space from the previous item */
            z-index: 9999;
        }

        .dropdown {
            display: none;
            position: absolute;
            top: 50px;
            /* Adjust this to control dropdown visibility */
            right: 0;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            min-width: 150px;
            z-index: 999;
        }

        .dropdown a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #071952;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .dropdown a:hover {
            background-color: #f0f0f0;
        }

        .user-menu.active .dropdown {
            display: block;
        }

        /* Ensure no clipping when icons are close to the edges */
        nav ul li:last-child {
            margin-right: 20px;
            /* Add space on the right side of the navigation */
        }
    </style>



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
                    <div class="user-icon" onclick="toggleDropdown()">U</div>

                    <!-- Dropdown Menu -->
                    <div class="dropdown">
                        <a href="profile.php">Profile</a>
                        <a href="logout.php">Logout</a>
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