<?php
include('../connection.php');

$id = $_GET['id'];

// Step 1: Delete employer-company associations from company_employer table
$deleteAssociationsQuery = "DELETE FROM employer_company WHERE employer_id = $id";
mysqli_query($conn, $deleteAssociationsQuery);

// Step 2: Delete the employer from the employer table
$query = "DELETE FROM employer WHERE employer_id = $id";
$result = mysqli_query($conn, $query);

// Step 3: (Optional) Delete companies that have no more employers associated
$deleteOrphanCompaniesQuery = "DELETE FROM companies 
                               WHERE company_id NOT IN (SELECT company_id FROM employer_company)";
mysqli_query($conn, $deleteOrphanCompaniesQuery);

if ($result) {
    header('Location: employer.php?success=Employer and associated data deleted successfully');
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
