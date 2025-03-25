<?php
session_start(); // Start the session at the beginning

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php"); // Redirect to dashboard if logged in
    exit();
}

include('../connection.php');
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Both fields are required.";
    } else {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT employer_id, username FROM employer WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Fetch the user's data
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['employer_id'];
            $_SESSION['username'] = $row['username'];

            // Check for expired jobs and deactivate them
            $employer_id = $_SESSION['user_id'];
            $current_time = date('Y-m-d H:i:s'); // Get current date and time

            // Query to deactivate expired jobs
            $deactivate_sql = "UPDATE jobs 
                               SET current_status = 0
                               WHERE employer_id = ? AND deadline < ?";
            $deactivate_stmt = $conn->prepare($deactivate_sql);
            $deactivate_stmt->bind_param("is", $employer_id, $current_time);
            $deactivate_stmt->execute();
            $deactivate_stmt->close();

            // Redirect to the dashboard after login and job check
            header("Location: dashboard.php");
            exit();
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
    <title>Employer Login</title>
    <script src="js/login.js" defer></script>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <header>
        <h1>Welcome to Job Portal</h1>
    </header>
    <main class="login-section">
        <div class="wrapper">
            <div class="title">Employer Login</div>
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
