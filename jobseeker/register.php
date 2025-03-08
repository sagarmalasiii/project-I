<?php


include('../connection.php');



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate required fields
    if (empty($full_name) || empty($email) || empty($username) || empty($password)) {
        echo "All fields are required.";
        exit;
    }


    $query = "INSERT INTO job_seeker (full_name,email, username, password) VALUES('$full_name', '$email','$username', '$password')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        header('location: login.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Jobseeker Registration Form | Hamro Job</title>

    <!-- Link to external JavaScript file for form validation -->
    <script src="js/register.js" defer></script>

    <style>
        /* Importing Google Font: Poppins */
        @import url("https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap");

        /* Reset default margin, padding, and box-sizing for all elements */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
            /* Setting default font */
        }

        /* Styling the HTML and Body elements */
        html,
        body {
            height: 100%;
            width: 100%;
            background: url('img/login.jpg') no-repeat center center/cover;
            /* Setting background image */
            display: flex;
            flex-direction: column;
            /* Stack elements in a column */
            align-items: center;
            /* Center align content horizontally */
        }

        /* Styling for the header and footer */
        header,
        footer {
            background: #00bcd4;
            /* Blue background color */
            color: white;
            /* White text */
            text-align: center;
            /* Center align text */
            padding: 15px 0;
            /* Add vertical padding */
            width: 100%;
            /* Full width */
        }

        /* Wrapper for the registration form */
        .wrapper {
            width: 100%;
            max-width: 600px;
            /* Limit max width */
            background: rgba(255, 255, 255, 0.9);
            /* Semi-transparent white background */
            border-radius: 15px;
            /* Rounded corners */
            box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.3);
            /* Box shadow for depth */
            margin: 40px 0;
            /* Space above and below */
        }

        /* Title section inside the form */
        .wrapper .title {
            font-size: 28px;
            font-weight: 600;
            text-align: center;
            line-height: 100px;
            /* Adjust vertical alignment */
            color: #fff;
            /* White text */
            border-radius: 15px 15px 0 0;
            /* Rounded corners at the top */
            background: #00bcd4;
            /* Same blue background as header */
        }

        /* Form styling */
        .wrapper form {
            padding: 20px 40px 50px 40px;
            /* Space inside the form */
        }

        /* Styling for each input field container */
        .field {
            margin-top: 20px;
            /* Space between fields */
            position: relative;
            /* Needed for label animation */
        }

        /* Styling for input fields */
        .field input {
            height: 50px;
            width: 100%;
            outline: none;
            /* Remove default outline */
            font-size: 16px;
            padding-left: 20px;
            /* Padding inside input */
            border: 1px solid lightgrey;
            /* Light grey border */
            border-radius: 25px;
            /* Rounded corners */
            transition: all 0.3s ease;
            /* Smooth transition */
        }

        /* Styling for floating labels inside input fields */
        .field label {
            position: absolute;
            top: 50%;
            left: 20px;
            color: #999;
            /* Grey text color */
            font-size: 16px;
            transform: translateY(-50%);
            /* Center text vertically */
            transition: all 0.3s ease;
            /* Smooth transition */
        }

        /* Move label up when input is focused or has content */
        .field input:focus~label,
        .field input:valid~label {
            top: 0;
            font-size: 14px;
            color: #00bcd4;
            /* Change color to blue */
            background: #fff;
            /* White background */
            transform: translateY(-50%);
        }

        /* Error message styling */
        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }

        /* Submit button styling */
        .field input[type="submit"] {
            height: 50px;
            color: #fff;
            border: none;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            background: #00bcd4;
            /* Blue background */
            transition: all 0.3s ease;
            /* Smooth hover effect */
        }

        /* Signup link text below form */
        .signup-link {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }

        /* Signup link styling */
        .signup-link a {
            color: #00bcd4;
            font-weight: 600;
            text-decoration: none;
        }

        /* Underline effect on hover for signup link */
        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <header>
        <h1>Welcome to Job Portal</h1>
    </header>

    <!-- Main Content -->
    <main>
        <div class="wrapper">
            <!-- Form Title -->
            <div class="title">Job Seeker Register</div>

            <!-- Registration Form -->
            <form name="registrationForm" action="register.php" method="post" onsubmit="return validateForm()">

                <!-- Full Name Field -->
                <div class="field">
                    <input type="text" id="full_name" name="full_name" required />
                    <label for="full_name">Full Name</label>
                    <span class="error" id="full_name_error"></span>
                </div>

                <!-- Email Field -->
                <div class="field">
                    <input type="email" id="email" name="email" required />
                    <label for="email">Email</label>
                    <span class="error" id="email_error"></span>
                </div>

                <!-- Username Field -->
                <div class="field">
                    <input type="text" id="username" name="username" required />
                    <label for="username">Username</label>
                    <span class="error" id="username_error"></span>
                </div>

                <!-- Password Field -->
                <div class="field">
                    <input type="password" id="password" name="password" required />
                    <label for="password">Password</label>
                    <span class="error" id="password_error"></span>
                </div>

                <!-- Confirm Password Field -->
                <div class="field">
                    <input type="password" id="confirm_password" name="confirm_password" required />
                    <label for="confirm_password">Confirm Password</label>
                    <span class="error" id="confirm_password_error"></span>
                </div>

                <!-- Submit Button -->
                <div class="field">
                    <input type="submit" value="Create an Account" />
                </div>

                <!-- Link to Login Page -->
                <div class="signup-link">
                    Already a member? <a href="login.php">Login now</a>
                </div>

            </form>
        </div>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2025 Job Portal. All rights reserved.</p>
    </footer>
</body>

</html>