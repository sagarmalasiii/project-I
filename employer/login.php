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

            // Redirect to dashboard after successful login
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
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/login.js" defer></script>
    <style>
        .error-message {
            color: #ff4d4d;
            background-color: #ffe6e6;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ff4d4d;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="title">Employer Login</div>
        <form name="loginForm" action="login.php" method="post">
            <div class="field">
                <input type="text" id="username" name="username" required />
                <label for="username">Username</label>
            </div>
            <div class="field">
                <input type="password" id="password" name="password" required />
                <label for="password">Password</label>
            </div>
            <?php if (!empty($error)) : ?>
                <div class="error-message">
                    <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <div class="field">
                <input type="submit" value="Login" />
            </div>
            <div class="signup-link">
                Not a member? <a href="register.php">Signup now</a>
            </div>
        </form>
    </div>
</body>

</html>