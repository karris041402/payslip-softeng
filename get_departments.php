<?php
require_once 'db.php';
header('Content-Type: application/json');

$sql = "SELECT department_name FROM department ORDER BY department_name";
$result = $conn->query($sql);

$departments = [];
while ($row = $result->fetch_assoc()) {
    $departments[] = $row;
}

echo json_encode(['departments' => $departments]);
$conn->close();