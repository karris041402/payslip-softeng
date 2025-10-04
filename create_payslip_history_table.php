<?php
require_once 'db.php'; 
$sql = "CREATE TABLE IF NOT EXISTS payslip_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL,
    employee_name VARCHAR(255) NOT NULL,
    department VARCHAR(100) NOT NULL,
    months VARCHAR(255) NOT NULL,
    download_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_id INT NOT NULL
)";

if ($conn->query($sql)) {
    echo "Payslip history table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>