<?php
session_start();
require_once 'db_connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit;
}

$id = $_POST['id'] ?? 0;
$userId = $_SESSION['user_id'];

if (empty($id)) {
    echo json_encode(['success' => false, 'error' => 'Invalid record ID']);
    exit;
}

// Verify the record belongs to the user
$stmt = $conn->prepare("DELETE FROM payslip_history WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$stmt->close();
$conn->close();
?>