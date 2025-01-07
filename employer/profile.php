<?php
// Ensure the session is started at the beginning
include('include/header.php');
include('../connection.php');

// Get the logged-in user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch the employer's details
$query = "SELECT * FROM employer WHERE employer_id = '$user_id'";
$result = mysqli_query($conn, $query);
$employer = mysqli_fetch_assoc($result);

// Fetch the list of companies the employer is associated with
$companies_query = "SELECT c.company_id, c.name FROM companies c 
                    JOIN employer_company ec ON c.company_id = ec.company_id 
                    WHERE ec.employer_id = '$user_id'";
$companies_result = mysqli_query($conn, $companies_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Profile</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Add your custom CSS styles */
        .profile-container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 30px;
        }

        .profile-info p {
            font-size: 16px;
            margin: 5px 0;
        }

        .edit-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-button:hover {
            background-color: #0056b3;
        }

        .company-list {
            margin: 20px 0;
        }

        .company-list p {
            font-size: 16px;
        }

        .update-profile-form {
            display: none;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .update-profile-form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .update-profile-form button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .update-profile-form button:hover {
            background-color: #218838;
        }
    </style>
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
            <form action="update_profile.php" method="POST">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo $employer['full_name']; ?>" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $employer['email']; ?>" required>

                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo $employer['username']; ?>" required>




                <button type="submit">Save Changes</button>
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
    </script>

</body>

</html>