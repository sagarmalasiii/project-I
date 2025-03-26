<?php
session_start();
if (isset($_SESSION['jobseeker_id'])) {
    header('location: dashboard.php');
    exit;
}

include('../connection.php');
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get inputs and sanitize them
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Both fields are required.";
    } else {
        // Use prepared statement to fetch hashed password
        $stmt = $conn->prepare("SELECT job_seeker_id, username, password FROM job_seeker WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Fetch the user's data
            $row = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $row['password'])) {
                $_SESSION['jobseeker_id'] = $row['job_seeker_id'];
                $_SESSION['jobseeker_username'] = $row['username'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Incorrect username or password.";
            }
        } else {
            $error = "Incorrect username or password.";
        }
        $stmt->close();
    }
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Job Seeker Login</title>
    <script src="js/login.js" defer></script>
    <style>
        /* Importing Google Font: Poppins */
        @import url("https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap");

        /* Reset default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        /* Background and layout */
        html,
        body {
            height: 100%;
            width: 100%;
            background: url('img/login.jpg') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Header styling */
        header {
            background: #00bcd4;
            /* Sky blue */
            color: white;
            padding: 20px 0;
            text-align: center;
            width: 100%;
        }

        .header-container h1 {
            margin: 0;
            font-size: 24px;
        }

        /* Footer styling */
        footer {
            background: #00bcd4;
            /* Sky blue */
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
            width: 100%;
        }

        .footer-container p {
            margin: 0;
            font-size: 14px;
        }

        /* Wrapper for form */
        .wrapper {
            width: 100%;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.3);
            margin: 40px 0;
        }

        .wrapper .title {
            font-size: 28px;
            font-weight: 600;
            text-align: center;
            line-height: 100px;
            color: #fff;
            user-select: none;
            border-radius: 15px 15px 0 0;
            background: #00bcd4;
        }

        .wrapper form {
            padding: 20px 40px 50px 40px;
        }

        .wrapper form .field {
            height: auto;
            width: 100%;
            margin-top: 20px;
            position: relative;
        }

        .wrapper form .field input {
            height: 50px;
            width: 100%;
            outline: none;
            font-size: 16px;
            padding-left: 20px;
            border: 1px solid lightgrey;
            border-radius: 25px;
            transition: all 0.3s ease;
            margin-bottom: 5px;
        }

        /* Highlight input field on focus */
        .wrapper form .field input:focus,
        .wrapper form .field input:valid {
            border-color: #00bcd4;
            outline: 2px solid #00bcd4;
        }

        /* Label positioning inside input field */
        .wrapper form .field label {
            position: absolute;
            top: 50%;
            left: 20px;
            color: #999;
            font-weight: 400;
            font-size: 16px;
            pointer-events: none;
            transform: translateY(-50%);
            transition: all 0.3s ease;
        }

        .wrapper form .field input:focus~label,
        .wrapper form .field input:valid~label {
            top: 0;
            font-size: 14px;
            color: #00bcd4;
            background: #fff;
            transform: translateY(-50%);
        }

        /* Error message styling */
        .wrapper form .field .error {
            color: red;
            font-size: 14px;
            margin-top: 2px;
            margin-left: 5px;
            display: block;
        }

        .wrapper form .field input[type="submit"] {
            height: 50px;
            color: #fff;
            border: none;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            background: #00bcd4;
            transition: all 0.3s ease;
        }

        .wrapper form .field input[type="submit"]:active {
            transform: scale(0.95);
        }

        /* Sign-up link styling */
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

        /* Responsive Design */
        @media (max-width: 480px) {
            .wrapper {
                width: 95%;
                max-width: 400px;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>Welcome to Job Portal</h1>
    </header>
    <main class="login-section">
        <div class="wrapper">
            <div class="title">Job Seeker Login</div>
            <?php if (!empty($error)) { ?>
                <p style="color:red; text-align:center;"><?php echo $error; ?></p>
            <?php } ?>
            <form name="loginForm" action="login.php" method="post">
                <div class="field">
                    <input type="text" id="username" name="username" required />
                    <label for="username">Username</label>
                    <span class="error" id="username_error"></span>
                </div>
                <div class="field">
                    <input type="password" id="password" name="password" required />
                    <label for="password">Password</label>
                    <span class="error" id="password_error"></span>
                </div>
                <div class="field">
                    <input type="submit" value="Login" />
                </div>
                <div class="signup-link">
                    <span>Not a member?</span> <a href="register.php">Signup now</a>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 Job Portal. All rights reserved.</p>
    </footer>
</body>

</html>