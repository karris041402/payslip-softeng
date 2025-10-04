<?php
// get_record.php - Updated without login requirement
require_once 'db.php';

header('Content-Type: application/json');

$id = $_GET['id'] ?? 0;

if (empty($id)) {
    echo json_encode(['success' => false, 'error' => 'Invalid record ID']);
    exit;
}

try {
    // Remove user_id condition since no login required
    $stmt = $conn->prepare("SELECT * FROM payslip_history WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $record = $result->fetch_assoc();

        $file_path = $record['file_path'] ?? 'uploads/payslips/' . $record['filename'];
        $file_exists = file_exists($file_path);
        
        echo json_encode([
            'success' => true, 
            'record' => $record,
            'file_exists' => $file_exists,
            'file_path' => $file_path,
            'filename' => $record['filename'] ?? 'payslip.pdf'
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Record not found']);
    }

    $stmt->close();
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
} finally {
    $conn->close();
}
?>