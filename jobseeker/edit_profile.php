<?php
session_start();
include('../connection.php');

// Check if user is logged in
if (!isset($_SESSION['jobseeker_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['jobseeker_id'];

// Fetch current user data
$sql = "SELECT full_name, email, username, profile_picture, resume_path FROM job_seeker WHERE job_seeker_id = '$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the new profile data from the form
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    // Handle file uploads
    $profile_picture = $user['profile_picture']; // Default to current profile picture
    $cv_file = $user['resume_path']; // Default to current CV file

    // Profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $profile_picture_name = $_FILES['profile_picture']['name'];
        $profile_picture_tmp = $_FILES['profile_picture']['tmp_name'];
        $profile_picture_ext = pathinfo($profile_picture_name, PATHINFO_EXTENSION);
        $profile_picture_new_name = 'profile_' . $user_id . '.' . $profile_picture_ext;

        $upload_dir = 'uploads/profile_pictures/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($profile_picture_tmp, $upload_dir . $profile_picture_new_name)) {
            $profile_picture = $upload_dir . $profile_picture_new_name;
        }
    }

    // CV file upload
    if (isset($_FILES['resume_path']) && $_FILES['resume_path']['error'] == 0) {
        $cv_file_name = $_FILES['resume_path']['name'];
        $cv_file_tmp = $_FILES['resume_path']['tmp_name'];
        $cv_file_ext = pathinfo($cv_file_name, PATHINFO_EXTENSION);

        // Generate a unique file name using a timestamp
        $cv_file_new_name = 'cv_' . $user_id . '_' . time() . '.' . $cv_file_ext;

        $upload_dir = 'uploads/cvs/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $new_cv_path = $upload_dir . $cv_file_new_name;

        // Move the uploaded file to the server
        if (move_uploaded_file($cv_file_tmp, $new_cv_path)) {
            // Delete the old CV file if it exists
            if (!empty($user['resume_path']) && file_exists($user['resume_path'])) {
                unlink($user['resume_path']);
            }

            // Update the CV file path
            $cv_file = $new_cv_path;
        } else {
            $cv_file = $user['resume_path']; // Keep the old CV if upload fails
        }
    } else {
        $cv_file = $user['resume_path']; // Keep the old CV if no new file was uploaded
    }

    // Update the profile in the database
    $update_sql = "UPDATE job_seeker 
               SET full_name = '$full_name', 
                   email = '$email', 
                   username = '$username', 
                   profile_picture = '$profile_picture', 
                   resume_path = '$cv_file' 
               WHERE job_seeker_id = '$user_id'";

    if ($conn->query($update_sql)) {
        header('Location: dashboard.php'); // Redirect after update
        exit();
    } else {
        echo "Error updating profile: " . $conn->error . "<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #00bcd4;
            color: white;
            padding: 10px 20px;
        }

        .navbar h1 {
            margin: 0;
        }

        .content {
            padding: 20px;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        .form-container input,
        .form-container select,
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .submit-btn {
            background-color: #00bcd4;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #0097a7;
        }

        .file-input {
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <h1>Edit Profile</h1>
        <a href="dashboard.php" style="color: white;">Back to Dashboard</a>
    </div>

    <div class="content">
        <div class="form-container">
            <form method="POST" enctype="multipart/form-data">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

                <label for="profile_picture">Profile Picture:</label>
                <input type="file" name="profile_picture" class="file-input" accept="image/*">

                <label for="resume_path">Upload CV:</label>
                <input type="file" name="resume_path" class="file-input" accept=".pdf,.doc,.docx,.txt">

                <button type="submit" class="submit-btn">Save Changes</button>
            </form>
        </div>
    </div>
</body>

</html>