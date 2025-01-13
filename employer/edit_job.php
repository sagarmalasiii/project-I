<?php
session_start();
include('include/header.php');
include('../connection.php');



$employer_id = $_SESSION['user_id'];
$job_id = $_GET['id'];

// Fetch job details
$query = "SELECT * FROM jobs WHERE job_id = $job_id AND employer_id = $employer_id";

$result = mysqli_query($conn, $query);
$job = mysqli_fetch_assoc($result);

if (!$job) {
    echo "Job not found or you do not have permission to edit this job.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add the same styles as before -->
    <title>Update Job</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 700px;
            margin: 30px auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        textarea:focus {
            border-color: #9b59b6;
            outline: none;
        }

        textarea {
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #9b59b6;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #6a3e92;
        }

        .cancel {
            background-color: #6c757d;
            margin-top: 10px;
        }

        .cancel:hover {
            background-color: #5a6268;
        }

        /* Responsive Styles */
        @media(max-width: 768px) {
            .container {
                padding: 20px;
                margin: 10px;
            }

            h1 {
                font-size: 1.5rem;
            }
        }

        @media(max-width: 480px) {
            .container {
                padding: 15px;
            }

            input[type="text"],
            input[type="date"],
            textarea {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Update Job</h1>

        <form action="update_job.php" method="POST">
            <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
            <input type="hidden" name="employer_id" value="<?php echo $employer_id; ?>">

            <label for="job_title">Job Title</label>
            <input type="text" id="job_title" name="job_title" value="<?php echo $job['job_title']; ?>" required disabled>

            <label for="description">Job Description</label>
            <textarea id="description" name="description" rows="5" required><?php echo $job['description']; ?></textarea>

            <label for="requirements">Job Requirements</label>
            <textarea id="requirements" name="requirements" rows="3" required><?php echo $job['requirements']; ?></textarea>

            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="<?php echo $job['location']; ?>" required>

            <label for="salary">Salary (Optional)</label>
            <input type="text" id="salary" name="salary" value="<?php echo $job['salary']; ?>">

            <label for="deadline">Application Deadline</label>
            <input type="date" id="deadline" name="deadline" value="<?php echo $job['deadline']; ?>" required>

            <button type="submit">Update Job</button>
            <button type="button" class="cancel" onclick="window.location.href='dashboard.php'">Cancel</button>
        </form>
    </div>
</body>

</html>