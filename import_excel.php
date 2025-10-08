<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel to Database Import</title>
    <link rel="icon" type="image/x-icon" href="EARIST_Logo (1).ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #d9e1eeff;
            padding: 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        body.dark-mode {
            background: #181c23 !important;
            color: #e0e6ef !important;
        }
        
        body.dark-mode .container {
            background: #232b36 !important;
            color: #e0e6ef !important;
        }

        body.dark-mode .container h1 {
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

        body.dark-mode .container .info-box{
            background: #424f59ff !important;
        }

        body.dark-mode .container .import-section{
            background: #424f59ff !important;
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        body.dark-mode .form-group label{
            color: white;
        }
        




        .container {
            max-width: 800px;
            margin-left: 100px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        h1 i {
            color: #667eea;
        }

        .subtitle {
            color: #7f8c8d;
            margin-bottom: 30px;
        }

        .import-section {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        select, input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e6ed;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .progress-container {
            display: none;
            margin-top: 20px;
        }

        .progress-bar {
            width: 100%;
            height: 30px;
            background: #e0e6ed;
            border-radius: 15px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            width: 0%;
            transition: width 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .status-message {
            margin-top: 10px;
            padding: 10px;
            border-radius: 8px;
            display: none;
        }

        .status-message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .info-box i {
            color: #2196f3;
            margin-right: 10px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
        }

        .back-link:hover {
            color: #764ba2;
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
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-file-import"></i> Excel to Database Import</h1>
        <p class="subtitle">Import employee data from Excel files to database</p>

        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            <strong>Instructions:</strong> Select a department and the Excel file will be automatically imported. Make sure your Excel file is in the <code>excels2/</code> folder.
        </div>

        <div class="import-section">
            <form id="importForm">
                <div class="form-group">
                    <label for="department">Select Department</label>
                    <select id="department" name="department" required>
                        <option value="">Choose Department...</option>
                        <option value="General Administration">General Administration</option>
                        <option value="Auxiliary">Auxiliary</option>
                        <option value="Advance Education">Advance Education</option>
                        <option value="College of Engineering">College of Engineering</option>
                        <option value="College of Industrial Technology">College of Industrial Technology</option>
                        <option value="College of Business Administration and Accountancy">College of Business Administration and Accountancy</option>
                        <option value="College of Arts and Sciences">College of Arts and Sciences</option>
                        <option value="College of Architecture and Fine Arts">College of Architecture and Fine Arts</option>
                        <option value="College of Education">College of Education</option>
                        <option value="Physical Education">Physical Education</option>
                        <option value="Research">Research</option>
                        <option value="Cavite Extension">Cavite Extension</option>
                        <option value="Temporary Employee">Temporary Employee</option>
                        <option value="New Employee Batch 3">New Employee Batch 3</option>
                        <option value="New Employee Batch 4">New Employee Batch 4</option>
                        <option value="New Employee Batch A">New Employee Batch A</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" id="importBtn">
                    <i class="fas fa-upload"></i> Start Import
                </button>
            </form>

            <div class="progress-container" id="progressContainer">
                <div class="progress-bar">
                    <div class="progress-fill" id="progressFill">0%</div>
                </div>
                <div class="status-message" id="statusMessage"></div>
            </div>
        </div>
    </div>

    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="EARIST_Logo (1).png" alt="Logo" class="sidebar-logo">
            <span class="sidebar-title">HUMAN RESOURCES MANAGEMENT SYSTEM</span>
        </div>
        <ul class="sidebar-menu">
            <li><i class="fas fa-tachometer-alt"></i> Dashboard</li>
            <li class="activeTab"><i class="fas fa-file-excel"></i>Import Excel</li>
            <li><i class="fas fa-user"></i> Employees</li>
            <li><i class="fas fa-file-invoice"></i> Payslip Generator</li>
            <li><i class="fas fa-history"></i> Payslip History</li>
            <li><i class="fas fa-chart-bar"></i> Reports</li>
            <li class="mode-toggle" onclick="toggleDarkMode()"><i class="fas fa-moon"></i> Dark/Light Mode</li>
        </ul>
        <div class="credit">Payslip Generator System © 2025 Karris Project. Developed for EARIST HRMS. All Rights Reserved.</div>
    </nav>

    <script>


        document.querySelectorAll('.sidebar-menu li').forEach(item => {
            item.addEventListener('click', function() {
                if (this.textContent.includes('Dashboard')) window.location.href = 'dashboard.php';
                if (this.textContent.includes('Excel')) window.location.href = 'import_excel.php';
                if (this.textContent.includes('Employees')) window.location.href = 'employee.php';
                if (this.textContent.includes('Payslip Generator')) window.location.href = 'index.php';
                if (this.textContent.includes('Payslip History')) window.location.href = 'payslip_history.php';
                if (this.textContent.includes('Reports')) window.location.href = 'reports.php';
                if (this.textContent.includes('Account Settings')) window.location.href = 'account_settings.php';
                if (this.classList.contains('mode-toggle')) toggleMode();
            });
        });


        document.getElementById('importForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const department = document.getElementById('department').value;
            const importBtn = document.getElementById('importBtn');
            const progressContainer = document.getElementById('progressContainer');
            const progressFill = document.getElementById('progressFill');
            const statusMessage = document.getElementById('statusMessage');

            if (!department) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Department Selected',
                    text: 'Please select a department first.',
                });
                return;
            }

            // Disable button and show progress
            importBtn.disabled = true;
            progressContainer.style.display = 'block';
            statusMessage.style.display = 'none';
            progressFill.style.width = '10%';
            progressFill.textContent = '10%';

            try {
                const response = await fetch('process_import.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `department=${encodeURIComponent(department)}`
                });

                const data = await response.json();

                progressFill.style.width = '100%';
                progressFill.textContent = '100%';

                if (data.success) {
                    statusMessage.className = 'status-message success';
                    statusMessage.style.display = 'block';
                    statusMessage.innerHTML = `
                        <strong>Import Successful!</strong><br>
                        Total Records: ${data.total_records}<br>
                        Successfully Imported: ${data.imported}<br>
                        Failed: ${data.failed}
                    `;

                    Swal.fire({
                        icon: 'success',
                        title: 'Import Complete!',
                        html: `
                            <p><strong>Total Records:</strong> ${data.total_records}</p>
                            <p><strong>Successfully Imported:</strong> ${data.imported}</p>
                            <p><strong>Failed:</strong> ${data.failed}</p>
                        `,
                        confirmButtonColor: '#667eea'
                    });
                } else {
                    throw new Error(data.error || 'Import failed');
                }

            } catch (error) {
                statusMessage.className = 'status-message error';
                statusMessage.style.display = 'block';
                statusMessage.innerHTML = `<strong>Error:</strong> ${error.message}`;

                Swal.fire({
                    icon: 'error',
                    title: 'Import Failed',
                    text: error.message,
                });
            } finally {
                importBtn.disabled = false;
            }
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
