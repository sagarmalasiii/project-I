<?php
include('include/header.php');

// Assuming the employer is logged in and their ID is stored in the session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit;
}
$employer_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Job</title>
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
        <h1>Post a Job</h1>

        <form action="save_job.php" method="POST">
            <input type="hidden" name="employer_id" value="<?php echo $employer_id; ?>">
            
            <label for="job_title">Job Title</label>
            <input type="text" id="job_title" name="job_title" placeholder="Enter the job title" required>

            <label for="description">Job Description</label>
            <textarea id="description" name="description" rows="5" placeholder="Describe the job responsibilities, benefits, etc." required></textarea>

            <label for="requirements">Job Requirements</label>
            <textarea id="requirements" name="requirements" rows="3" placeholder="List the qualifications and skills required" required></textarea>

            <label for="location">Location</label>
            <input type="text" id="location" name="location" placeholder="Enter the job location" required>

            <label for="salary">Salary (Optional)</label>
            <input type="text" id="salary" name="salary" placeholder="Enter the salary range">

            <label for="deadline">Application Deadline</label>
            <input type="date" id="deadline" name="deadline" required>

            <button type="submit">Post Job</button>
            <button type="button" class="cancel" onclick="window.location.href='dashboard.php'">Cancel</button>
        </form>
    </div>
</body>

</html>
