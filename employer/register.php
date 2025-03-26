<?php

include('../connection.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = md5(trim($_POST['password']));

    // Validate required fields
    if (empty($full_name) || empty($email) || empty($username) || empty($password)) {
        echo "All fields are required.";
        exit;
    }

    $sql = "SELECT * FROM employer WHERE username ='$username' OR email= '$email' ";
    $execute = mysqli_query($conn,$sql);

    if($execute){
        echo "Credentials Taken!";
        echo "<a href = 'register.php'> Register </a>";
        exit();
    }

    $query = "INSERT INTO employer (full_name,email, username, password) VALUES('$full_name', '$email','$username', '$password')";
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
    <title>Employer Registration Form | Hamro Job</title>

    <!-- Import Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap" rel="stylesheet" />

    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        html,
        body {
            height: 100%;
        }

        /* Body background image */
        body {
            background: url('img/login.jpg') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Remove extra padding/margin */
        }

        header,
        footer {
            background: #00bcd4;
            color: white;
            text-align: center;
            padding: 15px 0;
            width: 100%;
        }

        /* Remove gap above header */
        header {
            margin-top: 0;
        }

        main {
            margin: 20px 0;
        }

        /* Fixed-size form container with vertical scroll */
        .wrapper {
            width: 400px;
            /* Fixed width */
            height: 550px;
            /* Fixed height */
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.3);
            padding: 20px 40px 50px 40px;
            overflow-y: auto;
            /* Enable vertical scrolling if needed */
        }

        /* Title styling */
        .title {
            font-size: 28px;
            font-weight: 600;
            text-align: center;
            line-height: 100px;
            color: #fff;
            background: #00bcd4;
            border-radius: 15px 15px 0 0;
            margin: -20px -40px 20px -40px;
        }

        /* Field container */
        .field {
            margin-top: 20px;
            position: relative;
            width: 100%;
        }

        /* Input styling */
        .field input {
            height: 50px;
            width: 100%;
            outline: none;
            font-size: 16px;
            padding-left: 20px;
            border: 1px solid lightgrey;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        /* Floating label styling */
        .field label {
            position: absolute;
            top: 50%;
            left: 20px;
            color: #999;
            font-size: 16px;
            transform: translateY(-50%);
            transition: all 0.3s ease;
            pointer-events: none;
        }

        /* Move label on focus/valid */
        .field input:focus~label,
        .field input:valid~label {
            top: 0;
            font-size: 14px;
            color: #00bcd4;
            background: #fff;
            transform: translateY(-50%);
        }

        /* Error message styling with fixed space */
        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            display: block;
            width: 100%;
            min-height: 18px;
            /* Reserve space for error messages */
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
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
            transition: all 0.3s ease;
        }

        /* Signup link styling */
        .signup-link {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }

        .signup-link a {
            color: #00bcd4;
            font-weight: 600;
            text-decoration: none;
        }

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
            <div class="title">Employer Register</div>

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

    <!-- JavaScript Validation Code -->
    <script>
        function validateField(field, regex, errorMsg) {
            const errorElement = document.getElementById(`${field.id}_error`);
            if (!regex.test(field.value.trim())) {
                errorElement.textContent = errorMsg;
                return false;
            } else {
                errorElement.textContent = "";
                return true;
            }
        }

        function validateForm() {
            const fullName = document.getElementById("full_name");
            const email = document.getElementById("email");
            const username = document.getElementById("username");
            const password = document.getElementById("password");
            const confirmPassword = document.getElementById("confirm_password");

            const isFullNameValid = validateField(
                fullName,
                /^[a-zA-Z\s]+$/,
                "Full Name is required and should only contain letters."
            );
            const isEmailValid = validateField(
                email,
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                "Please enter a valid email address."
            );
            const isUsernameValid = validateField(
                username,
                /^[a-zA-Z0-9_]+$/,
                "Username is required and should only contain alphanumeric characters."
            );
            const isPasswordValid = validateField(
                password,
                /.{6,}/,
                "Password must be at least 6 characters long."
            );
            const isConfirmPasswordValid = password.value === confirmPassword.value;

            if (!isConfirmPasswordValid) {
                document.getElementById("confirm_password_error").textContent = "Passwords do not match.";
            } else {
                document.getElementById("confirm_password_error").textContent = "";
            }

            return (
                isFullNameValid &&
                isEmailValid &&
                isUsernameValid &&
                isPasswordValid &&
                isConfirmPasswordValid
            );
        }

        function addRealTimeValidation() {
            document.getElementById("full_name").addEventListener("input", (e) => {
                validateField(
                    e.target,
                    /^[a-zA-Z\s]+$/,
                    "Full Name is required."
                );
            });
            document.getElementById("email").addEventListener("input", (e) => {
                validateField(
                    e.target,
                    /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                    "Please enter a valid email address."
                );
            });
            document.getElementById("username").addEventListener("input", (e) => {
                validateField(
                    e.target,
                    /^[a-zA-Z0-9_]+$/,
                    "Username is required ."
                );
            });
            document.getElementById("password").addEventListener("input", (e) => {
                validateField(
                    e.target,
                    /.{6,}/,
                    "Password must be at least 6 characters long."
                );
            });
            document.getElementById("confirm_password").addEventListener("input", (e) => {
                const password = document.getElementById("password");
                const confirmPassword = e.target;
                const errorElement = document.getElementById("confirm_password_error");
                if (password.value !== confirmPassword.value) {
                    errorElement.textContent = "Passwords do not match.";
                } else {
                    errorElement.textContent = "";
                }
            });
        }

        window.onload = addRealTimeValidation;
    </script>
</body>

</html>