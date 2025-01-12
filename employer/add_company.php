<?php
include('include/header.php');




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
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 700px;
            margin: 30px auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        textarea:focus,
        select:focus {
            border-color: #9b59b6;
            outline: none;
        }

        textarea {
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #9b59b6;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #6a3e92;
        }

        .cancel {
            background-color: #6c757d;
            margin-top: 10px;
        }

        .cancel:hover {
            background-color: #5a6268;
        }

        /* Responsive Styles */
        @media(max-width: 768px) {
            .container {
                padding: 20px;
                margin: 10px;
            }

            h1 {
                font-size: 1.5rem;
            }
        }

        @media(max-width: 480px) {
            .container {
                padding: 15px;
            }

            input[type="text"],
            input[type="date"],
            textarea,
            select {
                font-size: 14px;
            }
        }

        button {
            width: 48%;
            margin-right: 2%;
            display: inline-block;
        }

        button:last-child {
            margin-right: 0;
        }
    </style>
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