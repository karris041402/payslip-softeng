<?php
require_once 'db.php';
$query = "SELECT * FROM payslip_history ORDER BY download_time DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$history = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip History</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ffffff 0%, #e6ecf5 50%, #cddffb 100%);
            padding: 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .history-table th, .history-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        
        .history-table th {
            background-color: #3498db;
            color: white;
        }
        
        .history-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        .history-table tr:hover {
            background-color: #e9e9e9;
        }
        
        .action-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
            font-size: 12px;
            transition: all 0.3s ease;
        }
        
        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }
        
        .delete-btn:hover {
            background-color: #c0392b;
        }
        
        .download-btn {
            background-color: #2ecc71;
            color: white;
        }
        
        .download-btn:hover {
            background-color: #27ae60;
        }

        .container {
            position: relative;
            width: calc(100% - 300px);
            margin-left: 280px;
            margin-top: 4px;
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

        .header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            display: flex;
            flex-direction: column;
            text-align: center;
            padding: 40px;
            color: white;
            position: relative;
            overflow: hidden;
            border-top-right-radius: 13px;
            border-top-left-radius: 13px;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .header p {
            font-size: 1.2em;
            opacity: 0.9;
            position: relative;
            z-index: 1;
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

        body.dark-mode .dataTables_length,
        body.dark-mode .dataTables_filter,
        body.dark-mode .dataTables_info,
        body.dark-mode .dataTables_paginate,
        body.dark-mode .dataTables_length select,
        body.dark-mode .dataTables_filter input {
            color: white !important;
        }

        body.dark-mode .dataTables_length select {
            background-color: #2c3e50 !important;
            border-color: #3498db !important;
            color: white !important;
        }

        body.dark-mode .dataTables_filter input {
            background-color: #2c3e50 !important;
            border-color: #3498db !important;
            color: white !important;
        }

        body.dark-mode .paginate_button {
            color: white !important;
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

        /* DataTables custom styling */
        .dataTables_wrapper .dataTables_length select {
            padding: 5px 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .dataTables_wrapper .dataTables_filter input {
            padding: 5px 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-history"></i> Payslip History</h1>
            <p>View and manage your downloaded payslips</p>
        </div>
        
        <div class="main-content">
            <div class="search-section">
                <table id="historyTable" class="history-table">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th>Department</th>
                            <th>Month(s)</th>
                            <th>Downloaded On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($history as $record): ?>
                        <tr>
                            <td><?= htmlspecialchars($record['file_name']) ?></td>
                            <td><?= htmlspecialchars($record['department']) ?></td>
                            <td><?= htmlspecialchars($record['months']) ?></td>
                            <td><?= date('M d, Y h:i A', strtotime($record['download_time'])) ?></td>
                            <td>
                                <button class="action-btn download-btn" onclick="downloadRecord(<?= $record['id'] ?>)">
                                    <i class="fas fa-download"></i> Download
                                </button>
                                <button class="action-btn delete-btn" onclick="deleteRecord(<?= $record['id'] ?>)">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="EARIST_Logo (1).png" alt="Logo" class="sidebar-logo">
            <span class="sidebar-title">HUMAN RESOURCES MANAGEMENT SYSTEM</span>
        </div>
        <ul class="sidebar-menu">
            <li class="activeTab"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
            <li><i class="fas fa-file-excel"></i> Excel Management</li>
            <li><i class="fas fa-user"></i> Employees</li>
            <li><i class="fas fa-file-invoice"></i> Payslip Generator</li>
            <li><i class="fas fa-history"></i> Payslip History</li>
            <li><i class="fas fa-chart-bar"></i> Reports</li>
            <li class="mode-toggle" onclick="toggleDarkMode()"><i class="fas fa-moon"></i> Dark/Light Mode</li>
        </ul>
        <div class="credit">Payslip Generator System © 2025 Karris Project. Developed for EARIST HRMS. All Rights Reserved.</div>
    </nav>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    
    <script>
        // Sidebar navigation
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


        // Initialize DataTable with proper settings
        $(document).ready(function() {
            $('#historyTable').DataTable({
                responsive: true,
                ordering: false,     // Disable sorting for all columns
                paging: true,        // Enable pagination
                lengthChange: true,  // Show entries dropdown
                pageLength: 5,       // Default 5 entries per page
                lengthMenu: [[5, 10, 20, 40, -1], [5, 10, 20, 40, "All"]], // Options for entries dropdown
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records...",
                    lengthMenu: "Show _MENU_ entries per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
                // Removed order since ordering is disabled
            });
        });

        // Delete record function
        function deleteRecord(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait while we delete the record.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Make the delete request
                    fetch('delete_record.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'id=' + encodeURIComponent(id)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'The record has been deleted successfully.',
                                icon: 'success',
                                confirmButtonColor: '#2ecc71'
                            }).then(() => {
                                // Reload the page to reflect changes
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.error || 'Failed to delete record.',
                                icon: 'error',
                                confirmButtonColor: '#e74c3c'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Network error occurred. Please try again.',
                            icon: 'error',
                            confirmButtonColor: '#e74c3c'
                        });
                    });
                }
            });
        }

    function downloadRecord(id) {
    // Show loading
    Swal.fire({
        title: 'Preparing Download...',
        text: 'Please wait while we prepare your file.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Check if record exists first
    fetch('get_record.php?id=' + encodeURIComponent(id))
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Check if file exists on server
                if (data.file_exists) {
                    // Close the loading dialog
                    Swal.close();
                    
                    // Start the download
                    const downloadLink = document.createElement('a');
                    downloadLink.href = 'download_file.php?id=' + encodeURIComponent(id);
                    downloadLink.style.display = 'none';
                    downloadLink.download = data.filename; // Use actual filename
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                    
                    // Show success message
                    setTimeout(() => {
                        Swal.fire({
                            title: 'Success!',
                            text: `Downloading: ${data.filename}`,
                            icon: 'success',
                            confirmButtonColor: '#2ecc71',
                            timer: 2000,
                            timerProgressBar: true
                        });
                    }, 500);
                } else {
                    // File doesn't exist on server
                    Swal.fire({
                        title: 'File Not Available!',
                        text: 'The payslip file is no longer available on the server.',
                        icon: 'warning',
                        confirmButtonColor: '#f39c12',
                        showCancelButton: true,
                        confirmButtonText: 'Contact Support',
                        cancelButtonText: 'Close'
                    });
                }
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.error || 'Failed to retrieve record.',
                    icon: 'error',
                    confirmButtonColor: '#e74c3c'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Network error occurred. Please try again.',
                icon: 'error',
                confirmButtonColor: '#e74c3c'
            });
        });
}

// Alternative: Direct download with better error handling
function downloadRecordDirect(id) {
    const downloadUrl = 'download_file.php?id=' + encodeURIComponent(id);
    
    // Test if file is accessible
    fetch(downloadUrl, { method: 'HEAD' })
        .then(response => {
            if (response.ok) {
                // File is accessible, start download
                window.open(downloadUrl, '_blank');
                
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Download started',
                    showConfirmButton: false,
                    timer: 2000
                });
            } else {
                throw new Error('File not accessible');
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'File Not Available!',
                text: 'The requested file cannot be downloaded at this time.',
                icon: 'error',
                confirmButtonColor: '#e74c3c'
            });
        });
}

        // Dark mode toggle
        function toggleMode() {
            document.body.classList.toggle('dark-mode');
            const isDarkMode = document.body.classList.contains('dark-mode');
            localStorage.setItem('themeMode', isDarkMode ? 'dark' : 'light');
            
            // Update DataTables styling after mode change
            setTimeout(() => {
                $('#historyTable').DataTable().draw();
            }, 100);
        }

        // Load saved theme on page load
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('themeMode');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
            }
        });
    </script>
</body>
</html>