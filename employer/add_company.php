<?php
session_start();
include('include/header.php');
include('../connection.php');




$employer_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['ajax_check'])) {
    $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
    $company_address = mysqli_real_escape_string($conn, $_POST['company_address']);
    $company_industry = mysqli_real_escape_string($conn, $_POST['company_industry']);

    // Check if the company already exists for the logged-in employer
    $checkQuery = "SELECT company_id FROM companies WHERE name = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $company_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // The company already exists
        echo "<script>
            alert('A company with this name already exists!');
        </script>";
    } else {
        // Insert the new company
        $query = "INSERT INTO companies (name, address, industry) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $company_name, $company_address, $company_industry);

        if ($stmt->execute()) {
            $company_id = $stmt->insert_id;

            // Link employer to company
            $insertEmployerCompany = "INSERT INTO employer_company (employer_id, company_id) VALUES (?, ?)";
            $stmt = $conn->prepare($insertEmployerCompany);
            $stmt->bind_param("ii", $employer_id, $company_id);
            $stmt->execute();

            echo "<script>
                alert('Company added successfully!');
                window.location.href = 'dashboard.php';
            </script>";
        } else {
            echo "<script>
                alert('Error adding company.');
            </script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Company</title>
    <script src="../jquery/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="./css/add_company.css">
</head>

<body>
    <div class="container">
        <h1>Add a New Company</h1>

        <form id="addCompanyForm" method="POST">
            <label for="company_name">Company Name</label>
            <input type="text" id="company_name" name="company_name" placeholder="Enter the company name" required>
            <span id="error_company_name" style="color: red; font-size: 14px;"></span>

            <label for="company_address">Company Address</label>
            <input type="text" id="company_address" name="company_address" placeholder="Enter the company address" required>

            <label for="company_industry">Company Industry</label>
            <select id="company_industry" name="company_industry" required>
                <option value="">Select Industry</option>
                <option value="IT">IT</option>
                <option value="Healthcare">Healthcare</option>
                <option value="Finance">Finance</option>
                <option value="Education">Education</option>
                <option value="Manufacturing">Manufacturing</option>
                <option value="Retail">Retail</option>
                <option value="Construction">Construction</option>
                <option value="Real Estate">Real Estate</option>
                <option value="Telecommunications">Telecommunications</option>
                <option value="Hospitality">Hospitality</option>
                <option value="Transportation">Transportation</option>
            </select>

            <button type="submit">Add Company</button>
            <button type="button" class="cancel" onclick="window.location.href='dashboard.php'">Cancel</button>
        </form>
    </div>


</body>

</html>