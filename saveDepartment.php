<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$user = 'root'; // change if needed
$password = ''; // change if needed
$db = 'payslip-generator';

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Collect form data for payroll
$department = $_POST['department'];

// Start transaction
$conn->begin_transaction();

try {
    // Insert into payroll table
    $sqlDepartment = "INSERT INTO department (
        department_name
    ) VALUES (
        ?
    )";

    $stmtDepartment = $conn->prepare($sqlDepartment);
    $sqlDepartment->bind_param(
        "s",
        $department
    );

    $departmentSuccess = $stmtDepartment->execute();
    $stmtDepartment->close();

    if ($departmentSuccess) {
        $conn->commit();
        echo "Department data saved successfully in department table.";
    } else {
        $conn->rollback();
        echo "Error: Failed to save department data.";
    }

} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>