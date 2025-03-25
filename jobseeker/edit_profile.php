<?php
session_start();
include('../connection.php');

if (!isset($_SESSION['jobseeker_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['jobseeker_id'];
$errors = [];

$sql = "SELECT full_name, email, username, profile_picture, resume_path FROM job_seeker WHERE job_seeker_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}

$form_data = $user;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);

    $allowedImageTypes = ['jpg', 'jpeg', 'png'];
    $allowedResumeTypes = ['pdf', 'doc', 'docx'];
    $allowedImageMimes = ['image/jpeg', 'image/png'];
    $allowedResumeMimes = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];

    $profile_picture = $user['profile_picture'];
    $cv_file = $user['resume_path'];

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['profile_picture'];
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $file_mime = mime_content_type($file['tmp_name']);

        if (!in_array($file_ext, $allowedImageTypes) || !in_array($file_mime, $allowedImageMimes)) {
            $errors[] = "Invalid profile picture format. Only JPG, JPEG, PNG allowed.";
        } else {
            $new_filename = 'profile_' . $user_id . '_' . uniqid() . '.' . $file_ext; // Added uniqid()
            $upload_dir = 'uploads/profile_pictures/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

            if (move_uploaded_file($file['tmp_name'], $upload_dir . $new_filename)) {
                $profile_picture = $upload_dir . $new_filename;
            } else {
                $errors[] = "Failed to upload profile picture.";
            }
        }
    }

    if (isset($_FILES['resume_path']) && $_FILES['resume_path']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['resume_path'];
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $file_mime = mime_content_type($file['tmp_name']);

        if (!in_array($file_ext, $allowedResumeTypes) || !in_array($file_mime, $allowedResumeMimes)) {
            $errors[] = "Invalid CV format. Only PDF, DOC, DOCX allowed.";
        } else {
            $new_filename = 'cv_' . $user_id . '_' . time() . '_' . uniqid() . '.' . $file_ext; // Added uniqid()
            $upload_dir = 'uploads/cvs/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

            if (move_uploaded_file($file['tmp_name'], $upload_dir . $new_filename)) {
                if (!empty($user['resume_path']) && file_exists($user['resume_path'])) {
                    unlink($user['resume_path']);
                }
                $cv_file = $upload_dir . $new_filename;
            } else {
                $errors[] = "Failed to upload CV.";
            }
        }
    }

    if (!empty($errors)) {
        $_SESSION['form_data'] = [
            'full_name' => $full_name,
            'email' => $email,
            'username' => $username
        ];
        $_SESSION['errors'] = $errors;
        header('Location: edit_profile.php');
        exit();
    }

    $setClauses = [];
    $params = [];
    $types = '';

    if (!empty($full_name)) {
        $setClauses[] = "full_name = ?";
        $params[] = &$full_name;
        $types .= 's';
    }
    if (!empty($email)) {
        $setClauses[] = "email = ?";
        $params[] = &$email;
        $types .= 's';
    }
    if (!empty($username)) {
        $setClauses[] = "username = ?";
        $params[] = &$username;
        $types .= 's';
    }

    if ($profile_picture !== $user['profile_picture']) {
        $setClauses[] = "profile_picture = ?";
        $params[] = &$profile_picture;
        $types .= 's';
    }

    if ($cv_file !== $user['resume_path']) {
        $setClauses[] = "resume_path = ?";
        $params[] = &$cv_file;
        $types .= 's';
    }

    if (!empty($setClauses)) {
        $sql = "UPDATE job_seeker SET " . implode(', ', $setClauses) . " WHERE job_seeker_id = ?";
        $params[] = &$user_id;
        $types .= 'i';

        $stmt = $conn->prepare($sql);
        call_user_func_array([$stmt, 'bind_param'], array_merge([$types], $params));

        if ($stmt->execute()) {
            header('Location: dashboard.php');
            exit();
        } else {
            $errors[] = "Database error: " . $conn->error;
            $_SESSION['errors'] = $errors;
            header('Location: edit_profile.php');
            exit();
        }
    } else {
        header('Location: dashboard.php'); //If no changes were made.
        exit();
    }
}

if (isset($_SESSION['form_data'])) {
    $form_data = $_SESSION['form_data'];
    unset($_SESSION['form_data']);
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

        .submit-btn:disabled {
            background-color: gray;
            cursor: not-allowed;
        }

        .submit-btn:hover:not(:disabled) {
            background-color: #0097a7;
        }

        .file-input {
            padding: 5px;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
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
                <input type="file" name="profile_picture" id="profile_picture" class="file-input" accept="image/*">
                <span id="profile_picture_error" class="error"></span>

                <label for="resume_path">Upload CV:</label>
                <input type="file" name="resume_path" id="resume_path" class="file-input" accept=".pdf,.doc,.docx">
                <span id="resume_path_error" class="error"></span>

                <button type="submit" class="submit-btn" id="save_changes">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const profileInput = document.getElementById("profile_picture");
            const resumeInput = document.getElementById("resume_path");
            const saveButton = document.getElementById("save_changes");

            function validateFile(input, allowedMimes, errorElement) {
                if (input.files.length > 0) {
                    const file = input.files[0];
                    const fileReader = new FileReader();

                    fileReader.onloadend = function() {
                        const arr = (new Uint8Array(fileReader.result)).subarray(0, 4);
                        let header = "";
                        for (let i = 0; i < arr.length; i++) {
                            header += arr[i].toString(16);
                        }

                        let fileTypeValid = allowedMimes.some(mime => header.startsWith(mime));
                        if (!fileTypeValid) {
                            errorElement.textContent = "Invalid file type!";
                            saveButton.disabled = true;
                        } else {
                            errorElement.textContent = "";
                            saveButton.disabled = false;
                        }
                    };

                    fileReader.readAsArrayBuffer(file);
                }
            }

            profileInput.addEventListener("change", function() {
                validateFile(profileInput, ["ffd8ff", "89504e47"], document.getElementById("profile_picture_error"));
            });

            resumeInput.addEventListener("change", function() {
                validateFile(resumeInput, ["25504446", "d0cf11e0", "504b34"], document.getElementById("resume_path_error"));
            });
        });
    </script>
</body>

</html>