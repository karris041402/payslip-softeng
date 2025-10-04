<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

$fileName = $_POST['file_name'] ?? '';
$employeeName = $_POST['employee_name'] ?? '';
$department = $_POST['department'] ?? '';
$months = $_POST['months'] ?? '';

// Since login is removed, use a default user ID (e.g., 1 for admin)
$userId = 1; // Or get from a different source if available

if (empty($fileName) || empty($employeeName) || empty($department) || empty($months)) {
    echo json_encode(['success' => false, 'error' => 'Missing required data']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO payslip_history (file_name, employee_name, department, months, download_time) VALUES (?, ?, ?, ?, NOW())");
$stmt->bind_param("ssss", $fileName, $employeeName, $department, $months);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$stmt->close();
$conn->close();
?>
