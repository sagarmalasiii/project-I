<?php
session_start();
include('../connection.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT a.application_id, a.applied_date, a.application_status, 
                j.job_title, c.name AS company_name, j.location
        FROM applications a
        JOIN jobs j ON a.job_id = j.job_id
        JOIN companies c ON j.company_id = c.company_id
        WHERE a.job_seeker_id = '$user_id'
        ORDER BY a.applied_date DESC";


$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applied Jobs</title>

    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #00bcd4;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            margin: 0;
            font-size: 28px;
            /* Larger text for Applied Jobs */
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 5px 10px;
            margin-top: 10px;
            border-radius: 3px;
        }

        .navbar a:hover {
            background-color: #0097a7;
        }

        .content {
            padding: 20px;
            max-width: 900px;
            margin: 20px auto;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #00bcd4;
            color: white;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .content {
                padding: 10px;
            }

            table th,
            table td {
                font-size: 14px;
                padding: 8px;
            }

            .navbar h1 {
                font-size: 24px;
                /* Adjust size for smaller screens */
            }
        }
    </style>
</head>

<body>
    <div class="navbar">
        <h1>Applied Jobs</h1>
        <a href="dashboard.php" style="color: white;">Back to Dashboard</a>
    </div>

    <div class="content">
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Company Name</th>
                        <th>Location</th>
                        <th>Date Applied</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($job = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($job['job_title']); ?></td>
                            <td><?php echo htmlspecialchars($job['company_name']); ?></td>
                            <td><?php echo htmlspecialchars($job['location']); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($job['applied_date'])); ?></td>
                            <td><?php if ($job['application_status'] == 0) {
                                    echo "Processing";
                                } else if ($job['application_status'] == 1) {
                                    echo "Accepted";
                                } else {
                                    echo "Rejected";
                                } ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have not applied to any jobs yet.</p>
        <?php endif; ?>
    </div>
</body>

</html>