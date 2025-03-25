<?php
session_start();
include('include/header.php');
include('../connection.php');

// Get the logged-in user ID from the session
$employer_id = $_SESSION['user_id'];

// Fetch the employer's details
$query = "SELECT * FROM employer WHERE employer_id = '$employer_id'";
$result = mysqli_query($conn, $query);
$employer = mysqli_fetch_assoc($result);

// Fetch the list of companies the employer is associated with
$companies_query = "SELECT c.company_id, c.name FROM companies c 
                    JOIN employer_company ec ON c.company_id = ec.company_id 
                    WHERE ec.employer_id = '$employer_id'";
$companies_result = mysqli_query($conn, $companies_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Profile</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">
    <script src="js/profile.js" defer></script> <!-- Add a script to handle real-time validation -->
</head>

<body>

    <div class="profile-container">
        <!-- Profile Overview -->
        <div class="profile-header">
            <h2>Welcome, <?php echo $employer['full_name']; ?>!</h2>
            <p>Your profile overview</p>
        </div>

        <!-- Profile Info -->
        <div class="profile-info">
            <p><strong>Full Name:</strong> <?php echo $employer['full_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $employer['email']; ?></p>
            <p><strong>Username:</strong> <?php echo $employer['username']; ?></p>
            <p><strong>Employer ID:</strong> <?php echo $employer['employer_id']; ?></p> <!-- Employer ID -->
        </div>

        <!-- List of Companies -->
        <div class="company-list">
            <h3>Companies You Are Associated With:</h3>
            <?php if (mysqli_num_rows($companies_result) > 0) : ?>
                <ul>
                    <?php while ($company = mysqli_fetch_assoc($companies_result)) : ?>
                        <li><?php echo $company['name']; ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php else : ?>
                <p>You are not associated with any company.</p>
            <?php endif; ?>
        </div>

        <!-- Edit Profile Button -->
        <button class="edit-button" onclick="toggleEditForm()">Edit Profile</button>

        <!-- Edit Profile Form -->
        <div class="update-profile-form" id="updateProfileForm">
            <h3>Edit Your Profile</h3>
            <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo $employer['full_name']; ?>" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $employer['email']; ?>" required>

                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo $employer['username']; ?>" required>

                <label for="profile_picture">Profile Picture</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" onchange="validateProfilePicture()" required>

                <span id="file_error" style="color: red;"></span> <!-- Error message for invalid file -->
                <button type="submit" id="save_changes" disabled>Save Changes</button> <!-- Disable the button initially -->
            </form>
        </div>

    </div>

    <script>
        // Function to toggle the edit profile form visibility
        function toggleEditForm() {
            const form = document.getElementById("updateProfileForm");

            if (form) {
                // Toggle the display of the form between block and none
                if (form.style.display === "none" || form.style.display === "") {
                    form.style.display = "block";
                } else {
                    form.style.display = "none";
                }
            } else {
                console.log("Edit profile form not found.");
            }
        }

        // Function to validate the profile picture
        function validateProfilePicture() {
            const fileInput = document.getElementById("profile_picture");
            const saveButton = document.getElementById("save_changes");
            const fileError = document.getElementById("file_error");

            const file = fileInput.files[0];

            if (file) {
                const validTypes = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
                if (!validTypes.includes(file.type)) {
                    fileError.textContent = "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
                    saveButton.disabled = true; // Disable the save button
                } else {
                    fileError.textContent = ""; // Clear the error
                    saveButton.disabled = false; // Enable the save button
                }
            } else {
                fileError.textContent = "";
                saveButton.disabled = false; // Enable the save button if no file is selected
            }
        }
    </script>

</body>

</html>