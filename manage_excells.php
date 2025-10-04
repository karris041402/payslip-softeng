<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php'; // PhpSpreadsheet autoload

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

$excelDir = __DIR__ . '/excels2/';
$files = array_filter(scandir($excelDir), function($f) {
    return preg_match('/\.xlsx$/i', $f);
});

if (isset($_SESSION['upload_message'])) {
    $uploadMsg = $_SESSION['upload_message']['text'];
    $isSuccess = $_SESSION['upload_message']['success'];
    unset($_SESSION['upload_message']);
    
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            showPopover(".json_encode($uploadMsg).", ".($isSuccess ? 'true' : 'false').");
        });
    </script>";
}
$uploadMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
    if (isset($_FILES['excel_files']) && !empty($_FILES['excel_files']['name'][0])) {
        $uploadedFiles = [];
        $errors = [];
        
        foreach ($_FILES['excel_files']['tmp_name'] as $key => $tmpName) {
            $fileName = basename($_FILES['excel_files']['name'][$key]);
            $targetPath = $excelDir . $fileName;
            
            // Check if file is Excel
            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if ($fileType !== 'xlsx') {
                $errors[] = "File $fileName is not an Excel file (.xlsx)";
                continue;
            }
            
            // Check if file already exists
            if (file_exists($targetPath)) {
                $errors[] = "File $fileName already exists";
                continue;
            }
            
            // Move uploaded file
            if (move_uploaded_file($tmpName, $targetPath)) {
                $uploadedFiles[] = $fileName;
            } else {
                $errors[] = "Failed to upload $fileName";
            }
        }
        
        // Prepare upload message
       $files = array_filter(scandir($excelDir), function($f) {
            return preg_match('/\.xlsx$/i', $f);
        });
        
        // Redirect to prevent form resubmission
        if (!empty($uploadedFiles) || !empty($errors)) {
            $_SESSION['upload_message'] = [
                'text' => (!empty($uploadedFiles) ? "Successfully uploaded: " . implode(', ', $uploadedFiles) : '') . 
                        (!empty($errors) ? " | Errors: " . implode(', ', $errors) : ''),
                'success' => empty($errors)
            ];
            header("Location: manage_excells.php");
            exit;
        }
    } else {
        echo "<script>showPopover('No files selected or upload error.', false);</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && !empty($_POST['files'])) {
    $deleted = [];
    foreach ($_POST['files'] as $file) {
        $filePath = $excelDir . basename($file);
        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                $deleted[] = $file;
            }
        }
    }
    
    if (!empty($deleted)) {
        $msg = count($deleted) . " file(s) deleted: " . implode(', ', $deleted);
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showPopover(".json_encode($msg).", true);
            });
        </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showPopover('No files were deleted', false);
            });
        </script>";
    }
    // Refresh the file list
    $files = array_filter(scandir($excelDir), function($f) {
        return preg_match('/\.xlsx$/i', $f);
    });
}

$employeeTable = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['view_employees']) && isset($_POST['selected_excel'])) {
    $file = basename($_POST['selected_excel']);
    $filePath = $excelDir . $file;
    
    if (file_exists($filePath)) {
        try {
            $spreadsheet = IOFactory::load($filePath);
            $sheetNames = $spreadsheet->getSheetNames();
            $selectedSheet = $_POST['sheet_name'] ?? $sheetNames[0];
            
            // Sheet selection form (same as before)
            $employeeTable .= '<div class="sheet-controls">';
            $employeeTable .= '<form method="post" id="sheetForm">';
            $employeeTable .= '<input type="hidden" name="selected_excel" value="'.htmlspecialchars($file).'">';
            $employeeTable .= '<label for="sheet_name">Select Sheet:</label>';
            $employeeTable .= '<select name="sheet_name" id="sheet_name" onchange="document.getElementById(\'sheetForm\').submit()">';
            foreach ($sheetNames as $name) {
                $selected = ($name === $selectedSheet) ? 'selected' : '';
                $employeeTable .= '<option value="'.htmlspecialchars($name).'" '.$selected.'>'.htmlspecialchars($name).'</option>';
            }
            $employeeTable .= '</select>';
            $employeeTable .= '<button type="submit" name="view_employees" class="btn" style="background:#3498db; margin-left:10px;">';
            $employeeTable .= '<i class="fas fa-sync-alt"></i> Load Sheet</button>';
            $employeeTable .= '</form>';
            $employeeTable .= '</div>';
            
            $sheet = $spreadsheet->getSheetByName($selectedSheet);
            $highestRow = $sheet->getHighestRow();
            $highestCol = $sheet->getHighestColumn();
            $highestColIndex = Coordinate::columnIndexFromString($highestCol);

            // Process header rows (6-10) - same as before
            $headerData = [];
            for ($row = 6; $row <= 10; $row++) {
                for ($col = 1; $col <= $highestColIndex; $col++) {
                    $cell = $sheet->getCell(Coordinate::stringFromColumnIndex($col) . $row);
                    $value = $cell->getValue();
                    
                    foreach ($sheet->getMergeCells() as $mergedRange) {
                        if ($cell->isInRange($mergedRange)) {
                            $value = $sheet->getCell(explode(':', $mergedRange)[0])->getValue();
                            break;
                        }
                    }
                    
                    if (!empty($value)) {
                        if (!isset($headerData[$col])) {
                            $headerData[$col] = [];
                        }
                        $headerData[$col][] = $value;
                    }
                }
            }

            // Combine header data - same as before
            $headers = [];
            foreach ($headerData as $col => $values) {
                $headers[$col] = implode(' ', array_unique(array_filter($values)));
            }

            $employeeTable .= '<div style="overflow-x:auto; margin-top:20px;">';
            $employeeTable .= '<table id="employeeTable" class="display" style="width:100%">';
            $employeeTable .= '<thead><tr>';
            
            // Output headers
            for ($col = 1; $col <= $highestColIndex; $col++) {
                $header = isset($headers[$col]) ? $headers[$col] : "Column $col";
                $employeeTable .= '<th>'.htmlspecialchars($header).'</th>';
            }
            
            $employeeTable .= '</tr></thead><tbody>';
             
            // Set maximum columns to display
            $maxColumns = 60; // Maximum columns to show
            $highestColIndex = min($highestColIndex, $maxColumns); // Limit to maxColumns

            // Start data from row 11 (assuming data starts after header)
            $maxRowsToProcess = 500; // Safety limit
            $rowCount = 0;

            for ($row = 11; $row <= $highestRow && $rowCount < $maxRowsToProcess; $row++) {
                $firstCellValue = $sheet->getCell(Coordinate::stringFromColumnIndex(1) . $row)->getValue();
                
                // Stop reading when we encounter "TOTAL DEDS."
                if (trim($firstCellValue) === "TOTAL DEDS.") {
                    break;
                }
                
                // Skip empty rows
                if (empty($firstCellValue)) continue;
                
                $employeeTable .= '<tr>';
                // Loop only through first 60 columns
                for ($col = 1; $col <= $maxColumns; $col++) {
                    $val = $sheet->getCell(Coordinate::stringFromColumnIndex($col) . $row)->getFormattedValue();
                    $employeeTable .= '<td>'.htmlspecialchars($val).'</td>';
                }
                $employeeTable .= '</tr>';
                
                $rowCount++;
            }
            
        } catch (Exception $e) {
            $employeeTable = '<div class="msg" style="background:#f8d7da;color:#721c24;">Error reading file: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    } else {
        $employeeTable = '<div class="msg" style="background:#f8d7da;color:#721c24;">File not found.</div>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Excel Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <style>

        /* Add this to your styles */
        #employeeTable_wrapper {
            margin-top: 20px;
        }

        #employeeTable th {
            white-space: nowrap;
            position: sticky;
            top: 0;
            background: #3498db;
            color: white;
            z-index: 10;
        }

        #employeeTable td {
            vertical-align: middle;
        }

        .dataTables_scrollBody #employeeTable th {
            position: static; /* Fix for sticky header in scrollable table */
        }

        /* Dark mode styles */
        body.dark-mode #employeeTable th {
            background: #2c3e50;
        }

        body.dark-mode .dataTables_wrapper .dataTables_filter input {
            background-color: #2d3748;
            color: white;
            border-color: #4a5568;
        }

        body.dark-mode .dataTables_wrapper .dataTables_length select {
            background-color: #2d3748;
            color: white;
            border-color: #4a5568;
        }

        .sheet-controls {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .sheet-controls label {
            font-weight: bold;
            margin-right: 10px;
        }

        .sheet-controls select {
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #ddd;
            min-width: 200px;
        }

        #employeeTable {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }

        #employeeTable th {
            background-color: #3498db;
            color: white;
            padding: 10px;
            text-align: left;
        }

        #employeeTable td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
        }

        #employeeTable tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #employeeTable tr:hover {
            background-color: #f1f1f1;
        }

        /* Dark mode styles */
        body.dark-mode #employeeTable th {
            background-color: #2c3e50;
        }

        body.dark-mode #employeeTable tr:nth-child(even) {
            background-color: #2d3748;
        }

        body.dark-mode #employeeTable tr:hover {
            background-color: #3a4556;
        }

        .popover-message {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
            animation: slideIn 0.3s ease-out, fadeOut 0.5s ease-in 1.5s forwards;
            transform: translateX(0);
            opacity: 1;
        }
        
        .popover-success {
            background: #4CAF50;
            color: white;
        }
        
        .popover-error {
            background: #F44336;
            color: white;
        }
        
        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        
        body.dark-mode .popover-success {
            background: #2E7D32;
        }
        
        body.dark-mode .popover-error {
            background: #C62828;
        }

        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease; 
            background: linear-gradient(135deg, #ffffff 0%, #e6ecf5 50%, #cddffb 100%);
            padding: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
       .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100%;
            background: linear-gradient(180deg, rgba(44, 62, 80, 0.98) 0%, rgba(52, 73, 94, 0.98) 100%);
            color: #fff;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            z-index: 999;
            display: flex;
            flex-direction: column;
            padding-top: 0;
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .sidebar-header {
            display: flex;
            padding: 30px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
            align-items: center;
        }

        .sidebar-logo {
            width: 55px;
            height: 55px;
            margin-left: 5px;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }

        .sidebar-title {
            font-size: 15px;
            font-weight: bold;
            letter-spacing: 1.5px;
            flex: 1;
            margin-left: 15px;
            line-height: 1.3;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 10px;
            margin: 0;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar-menu li {
            padding: 16px 20px;
            font-size: 1.05em;
            cursor: pointer;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: #3498db;
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .sidebar-menu li:hover::before,
        .sidebar-menu li.activeTab::before {
            transform: scaleY(1);
        }

        .sidebar-menu li:hover {
            background: linear-gradient(90deg, rgba(52, 152, 219, 0.8) 0%, rgba(41, 128, 185, 0.8) 100%);
            color: #fff;
            transform: translateX(5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .sidebar-menu .activeTab {
            background: linear-gradient(90deg, #3498db 0%, #2980b9 100%);
            color: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .sidebar-menu .mode-toggle {
            color: #ffe;
        }

        .credit {
            padding: 15px;
            font-size: 10px;
            color: #bbb;
            text-align: center;
            opacity: 0.6;
            letter-spacing: 0.5px;
            line-height: 1.4;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .container {
            position: relative;
            width: calc(100% - 300px); 
            margin-left: 260px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 45px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1), 
                        0 15px 30px rgba(0,0,0,0.15), 
                        0 20px 40px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0,0,0,0.05);
            overflow: hidden;
            padding: 32px;
            box-sizing: border-box; 
        }
        .container header {
            padding: 40px;
            font-size: 24px;
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            margin-bottom: 15px;
            border-top-right-radius: 13px;
            border-top-left-radius: 13px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            color: #fff;
        }

        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px 8px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #f1f3f6; }
        .btn { background: #e74c3c; color: #fff; border: none; padding: 10px 22px; border-radius: 6px; cursor: pointer; font-size: 1em; }
        .btn:disabled { background: #ccc; }
        .msg { background: #dff0d8; color: #3c763d; padding: 10px 16px; border-radius: 6px; margin-bottom: 18px; }
        .select-all { cursor: pointer; }
        .upload-form { margin-bottom: 24px; display: flex; align-items: center; gap: 16px; }
        .upload-form input[type="file"] { font-size: 1em; }
        .upload-form button { background: #3498db; }
        .excel-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 18px;
        }
        .tab-btn {
            padding: 10px 22px;
            border: none;
            background: #eee;
            color: #333;
            border-radius: 6px 6px 0 0;
            cursor: pointer;
            font-weight: bold;
        }
        .tab-btn.active {
            background: #3498db;
            color: #fff;
        }
        .tab-content { padding: 10px 0; }
        body.dark-mode {
            background: #181c23 !important;
            color: #e0e6ef !important;
        }
        body.dark-mode .container, body.dark-mode .main-content {
            background: #232b36 !important;
            color: #e0e6ef !important;
        }
         body.dark-mode .sidebar {
            background: #181c23 !important;
            color: #fff !important;
            box-shadow: 2px 0 20px rgba(207, 194, 194, 0.12) !important;
        }

        body.dark-mode .sidebar-menu li:hover {
            background: #3498db !important;
            color: #fff !important;
        }
        body.dark-mode table {
            background: #232b36 !important;
            color: #e0e6ef !important;
        }
        body.dark-mode th, body.dark-mode td {
            background: #232b36 !important;
            color: #e0e6ef !important;
        }
        body.dark-mode .btn {
            background: #217dbb !important;
        }

        .main-content {
            background: linear-gradient(135deg, #f8f9fa 0%, #f8fcffff 100%);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            margin-top: 40px;
            box-shadow: 
            2px 2px 10px rgba(0, 0, 0, 0.15), 
            4px  4px 15px rgba(163, 183, 212, 0.8); 
        }
        
    </style>
    <script>
        function toggleSelectAll(source) {
            const checkboxes = document.querySelectorAll('input[name="files[]"]');
            checkboxes.forEach(cb => cb.checked = source.checked);
        }
        function updateSelectAll() {
            const all = document.querySelectorAll('input[name="files[]"]');
            const checked = document.querySelectorAll('input[name="files[]"]:checked');
            document.getElementById('selectAll').checked = all.length === checked.length;
        }
        function goTo(page) {
            window.location.href = page;
        }
        function showTab(tab) {
            document.getElementById('manageTab').style.display = (tab === 'manage') ? 'block' : 'none';
            document.getElementById('viewTab').style.display = (tab === 'view') ? 'block' : 'none';
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelector('.tab-btn[onclick="showTab(\''+tab+'\')"]').classList.add('active');
        }
    </script>
</head>
<body>
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="EARIST_Logo (1).png" alt="Logo" class="sidebar-logo">
            <span class="sidebar-title">HUMAN RESOURCES MANAGEMENT SYSTEM</span>
        </div>
        <ul class="sidebar-menu">
            <li><i class="fas fa-tachometer-alt"></i> Dashboard</li>
            <li class="activeTab"><i class="fas fa-file-excel"></i> Excel Management</li>
            <li><i class="fas fa-user"></i> Employees</li>
            <li><i class="fas fa-file-invoice"></i> Payslip Generator</li>
            <li><i class="fas fa-history"></i> Payslip History</li>
            <li><i class="fas fa-chart-bar"></i> Reports</li>
            <li class="mode-toggle" onclick="toggleDarkMode()"><i class="fas fa-moon"></i> Dark/Light Mode</li>
        </ul>
        <div class="credit">Payslip Generator System © 2025 Karris Project. Developed for EARIST HRMS. All Rights Reserved.</div>
    </nav>

    
    <div class="container">
        <header>
            <h2><i class="fas fa-file-excel"></i> Excel File Management</h2>
        </header>
        
        <div class="main-content">
            <div class="excel-tabs">
                <button class="tab-btn active" onclick="showTab('manage')" type="button">Manage Files</button>
                <button class="tab-btn" onclick="showTab('view')" type="button">View Employee Data</button>
            </div>
            <div id="manageTab" class="tab-content" style="display:block;">
                <form class="upload-form" method="post" enctype="multipart/form-data">
                    <input type="file" name="excel_files[]" multiple accept=".xlsx" required>
                    <button type="submit" name="upload" class="btn"><i class="fas fa-upload"></i> Upload Excel</button>
                </form>
                <form method="post" onsubmit="return confirm('Are you sure you want to delete the selected file(s)?');">
                    <table>
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll" class="select-all" onclick="toggleSelectAll(this)"></th>
                                <th>Select All</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($files): foreach ($files as $file): ?>
                            <tr>
                                <td><input type="checkbox" name="files[]" value="<?= htmlspecialchars($file) ?>" onclick="updateSelectAll()"></td>
                                <td><?= htmlspecialchars($file) ?></td>
                                <td>
                                    <button type="submit" style="background:none; border:none; outline:none;" name="delete" value="1" onclick="this.form.files[<?= array_search($file, $files) ?>].checked=true;">
                                        <i style="margin-left: 20px; font-size:20px; color:white;" class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="3">No Excel files found.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                    <br>
                    <button type="submit" name="delete" value="1" class="btn " <?= $files ? '' : 'disabled' ?>>
                        <i class="fas fa-trash"></i> Delete Selected
                    </button>
                </form>
            </div>
            <div id="viewTab" class="tab-content" style="display:none;">
                <form method="post">
                    <label><b>Select Excel File:</b></label>
                    <select name="selected_excel" id="selected_excel" required>
                        <option value="">-- Select File --</option>
                        <?php foreach ($files as $file): ?>
                            <option value="<?= htmlspecialchars($file) ?>" <?= (isset($_POST['selected_excel']) && $_POST['selected_excel'] == $file) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($file) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="view_employees" class="btn" style="background:#3498db;"><i class="fas fa-eye"></i> View Employees</button>
                </form>
                <div style="margin-top:20px;">
                    <?= $employeeTable ?>
                </div>
            </div>
        </div>
        
    </div>

    <script>
        
        function showPopover(message, isSuccess = true) {
            const existing = document.querySelectorAll('.popover-message');
            existing.forEach(el => el.remove());
            
            const popover = document.createElement('div');
            popover.className = `popover-message ${isSuccess ? 'popover-success' : 'popover-error'}`;
            popover.textContent = message;
            document.body.appendChild(popover);
            
         
            popover.style.position = 'fixed';
            popover.style.top = '20px';
            popover.style.right = '20px';
            popover.style.padding = '15px 25px';
            popover.style.borderRadius = '8px';
            popover.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
            popover.style.zIndex = '1000';
            popover.style.animation = 'slideIn 0.3s ease-out, fadeOut 0.5s ease-in 1.5s forwards';
            

            setTimeout(() => {
                if (popover.parentNode) {
                    popover.remove();
                }
            }, 2300);
        }

        <?php if (isset($_POST['view_employees'])): ?>
            showTab('view');
        <?php else: ?>
            showTab('manage');
        <?php endif; ?>

        document.querySelectorAll('.sidebar-menu li').forEach(item => {
                item.addEventListener('click', function() {
                    if (this.textContent.includes('Dashboard')) window.location.href = 'dashboard.php';
                    if (this.textContent.includes('Excel')) window.location.href = 'manage_excells.php';
                    if (this.textContent.includes('Employees')) window.location.href = 'employee.php';
                    if (this.textContent.includes('Payslip Generator')) window.location.href = 'index.php';
                    if (this.textContent.includes('Payslip History')) window.location.href = 'payslip_history.php';
                    if (this.textContent.includes('Reports')) window.location.href = 'reports.php';
                    if (this.textContent.includes('Account Settings')) window.location.href = 'account_settings.php';
                    if (this.classList.contains('mode-toggle')) toggleMode();
                });
            });

        function toggleMode() {
            document.body.classList.toggle('dark-mode');
            const isDarkMode = document.body.classList.contains('dark-mode');
            localStorage.setItem('themeMode', isDarkMode ? 'dark' : 'light');
        }

     
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('themeMode');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
            }
        });
    </script>
</body>
</html>
