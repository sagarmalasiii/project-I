<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f9eb;
        }

        .sidebar {
            background-color: #228B22;
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 15px;
        }

        .sidebar a:hover {
            background-color: #166516;
        }

        .user-btn {
            border-radius: 50%;
            background-color: #228B22;
            color: white;
            padding: 10px;
            text-align: center;
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <div class="sidebar">
            <a href="#">Dashboard</a>
            <a href="post_job.php">Post a Job</a>
            <a href="#">View Job Applications</a>
            <a href="#">Messages</a>
        </div>
        <div class="main-content">
            <div class="user-btn">
                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-user"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your_fontawesome_kit_id.js" crossorigin="anonymous"></script>
</body>

</html>