<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            min-height: 100vh;
        }

        body.dark-mode {
            background: linear-gradient(135deg, #181c23 0%, #1a1f2e 50%, #0f1419 100%) !important;
            color: #e0e6ef !important;
        }

        body.dark-mode .container {
            background: rgba(35, 43, 54, 0.95) !important;
            color: #e0e6ef !important;
            border: 1px solid rgba(52, 152, 219, 0.2);
        }

        body.dark-mode .header-container {
            background: linear-gradient(135deg, #1a2332 0%, #2c3e50 100%) !important;
            border-bottom: 2px solid #3498db;
        }

        body.dark-mode .tab-navigation {
            background: #1a2332 !important;
            border-bottom: 1px solid #3498db;
        }

        body.dark-mode .tab-button {
            color: #a0aec0 !important;
            border-bottom: 3px solid transparent;
        }

        body.dark-mode .tab-button:hover {
            background: rgba(52, 152, 219, 0.1) !important;
            color: #3498db !important;
        }

        body.dark-mode .tab-button.active {
            color: #3498db !important;
            background: rgba(52, 152, 219, 0.15) !important;
            border-bottom: 3px solid #3498db;
        }
        body.dark-mode .form-section{
            box-shadow: 6px 6px 10px rgba(0, 0, 0, 0.15), -6px -6px 10px rgba(0, 0, 0, 0.16) !important; 
        }

        body.dark-mode .form-control,
        body.dark-mode input[type="text"],
        body.dark-mode input[type="number"],
        body.dark-mode select {
            background: #1a2332 !important;
            color: #e0e6ef !important;
            border: solid 1px #48535aff !important;
        }

        body.dark-mode .form-control:focus,
        body.dark-mode input[type="text"]:focus,
        body.dark-mode input[type="number"]:focus {
            border-color: solid 1px #48535aff !important;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2) !important;
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

        body.dark-mode .table {
            background: #1a2332 !important;
        }

        body.dark-mode .table th {
            background: #2c3e50 !important;
            color: #3498db !important;
        }

        body.dark-mode .table td {
            border-color: #3498db !important;
            color: #e0e6ef !important;
        }

        body.dark-mode .table tbody tr:hover {
            background: rgba(52, 152, 219, 0.1) !important;
        }

        body.dark-mode .btn-primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%) !important;
        }

        body.dark-mode .btn-secondary {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%) !important;
        }

        body.dark-mode .form-section {
            background: #232b36 !important;
        }

        body.dark-mode .form-section h3 {
            color: #3498db !important;
        }

        body.dark-mode .form-group label {
            color: #ffffffff !important;
        }

        body.dark-mode .section-header h2{
            color: #3498db !important;
        }

        .container {
            position: relative;
            width: calc(100% - 300px);
            margin-left: 280px;
            margin-top: 4px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1), 
                        0 20px 60px rgba(0,0,0,0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0,0,0,0.05);
            overflow: hidden;
            min-height: calc(100vh - 40px);
        }

        .header-container {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            padding: 35px 40px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .header-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 15s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(5%, 5%) scale(1.1); }
        }

        .header-container h1 {
            font-size: 2.5em;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .header-container h1 i {
            margin-right: 15px;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .header-container p {
            font-size: 1.1em;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        .tab-navigation {
            display: flex;
            background: #f8f9fa;
            border-bottom: 2px solid #e0e6ed;
            padding: 0;
        }

        .tab-button {
            flex: 1;
            padding: 18px 30px;
            background: transparent;
            border: none;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #5a6c7d;
            border-bottom: 3px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .tab-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(52, 152, 219, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .tab-button:hover::before {
            left: 100%;
        }

        .tab-button:hover {
            background: rgba(52, 152, 219, 0.05);
            color: #3498db;
        }

        .tab-button.active {
            color: #3498db;
            background: rgba(52, 152, 219, 0.1);
            border-bottom: 3px solid #3498db;
        }

        .tab-button i {
            margin-right: 10px;
            font-size: 1.2em;
        }

        .main-content {
            padding: 40px;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.4s ease-in-out;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .table-wrapper {
            overflow-x: auto;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

       .table-wrapper::-webkit-scrollbar {
            height: 6px;
            background: #f1f1f1;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background-color: #29659cff;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: #eee;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            border-bottom-left-radius: 0px;
            border-bottom-right-radius: 0px;
            overflow: hidden;
        }

        .table th {
            background: #3498db ;
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            border: 1px solid #e0e6ed;
            padding: 12px;
            text-align: left;
            font-size: 13px;
            white-space: nowrap;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: background 0.2s ease;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: rgba(52, 152, 219, 0.05);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .form-section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 
        -6px -6px 10px rgba(0, 0, 0, 0.15), 
        4px  4px 15px rgba(163, 183, 212, 0.8); 
            margin-bottom: 30px;
        }

        .form-section h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
            font-size: 1.4em;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #2c3e50;
            font-size: 0.95em;
        }

        .form-group input,
        .form-group select {
            padding: 12px;
            border: 2px solid #e0e6ed;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
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

        .btn i {
            font-size: 1.1em;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            box-shadow: 0 4px 6px rgba(52, 152, 219, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(52, 152, 219, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
            color: white;
            box-shadow: 0 4px 6px rgba(149, 165, 166, 0.3);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(149, 165, 166, 0.4);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-header h2 {
            color: #2c3e50;
            font-size: 1.8em;
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #95a5a6;
        }

        .empty-state i {
            font-size: 4em;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 1.2em;
        }

        .centered-popover {
            padding: 0;
            border: none;
            border-radius: 8px;
            background: #1a2332;
            box-shadow: 0 2px 20px rgba(255, 255, 255, 1);
            width: 400px;
            max-width: 90vw;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }

        /* Popover backdrop */
        .centered-popover::backdrop {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(2px);
        }

        .popover-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 20px 0 20px;
            margin-bottom: 15px;
        }

        .popover-header h3 {
            margin: 0;
            color: #333;
            font-size: 1.2rem;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: #666;
            padding: 5px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .close-btn:hover {
            background: #f5f5f5;
            color: #333;
        }

        #department-form {
            padding: 0 20px 20px 20px;
        }

        #department-form .form-group {
            margin-bottom: 20px;
        }

        #department-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        #department-form input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        #department-form input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
        }

        #department-form .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

       

        @media (max-width: 1024px) {
            .container {
                width: 100%;
                margin-left: 0;
                border-radius: 0;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .tab-button {
                padding: 15px 20px;
                font-size: 0.95em;
            }

            .header-container h1 {
                font-size: 1.8em;
            }
        }

    </style>
</head>
<body>
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="EARIST_Logo (1).png" alt="Logo" class="sidebar-logo">
            <span class="sidebar-title">HUMAN RESOURCES MANAGEMENT SYSTEM</span>
        </div>
        <ul class="sidebar-menu">
            <li><i class="fas fa-tachometer-alt"></i> Dashboard</li>
            <li><i class="fas fa-file-excel"></i> Excel Management</li>
            <li class="activeTab"><i class="fas fa-user"></i> Employees</li>
            <li><i class="fas fa-file-invoice"></i> Payslip Generator</li>
            <li><i class="fas fa-history"></i> Payslip History</li>
            <li><i class="fas fa-chart-bar"></i> Reports</li>
            <li class="mode-toggle" onclick="toggleDarkMode()"><i class="fas fa-moon"></i> Dark/Light Mode</li>
        </ul>
        <div class="credit">Payslip Generator System © 2025 Karris Project. Developed for EARIST HRMS. All Rights Reserved.</div>
    </nav>

    <div id="add-department-modal" popover class="centered-popover">
        <div class="popover-header">
            <h3 style="color: #3498db">Add New Department</h3>
            <button popovertarget="add-department-modal" popovertargetaction="hide" class="close-btn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="department-form"  method="POST" action="saveDepartment.php">
            <div class="form-group">
                <label for="new-department" style="color: #ffffff">Department Name:</label>
                <input type="text" id="new-department" name="department" required>
            </div>
            <div class="form-actions">
                <button type="button" popovertarget="add-department-modal" popovertargetaction="hide" class="btn btn-secondary">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Add Department
                </button>
            </div>
        </form>
    </div>

    <div class="container">
        <div class="header-container">
            <h1><i class="fas fa-users"></i>Employee Management</h1>
            <p>Manage your workforce efficiently and effectively</p>
        </div>

        <div class="tab-navigation">
            <button class="tab-button active" onclick="switchTab('view')">
                <i class="fas fa-list"></i> View Employees
            </button>
            <button class="tab-button" onclick="switchTab('add')">
                <i class="fas fa-user-plus"></i> Add Employee
            </button>
        </div>

        <div class="main-content">
            <div id="viewTab" class="tab-content active">
                <div class="main-wrapper-button">
                    <div class="wrapper-button">
                        <div class="button-group">
                            <label for="department">Department</label>
                            <select id="department" class="form-control" required>
                                <option value="">Select Department</option>
                                <option value="ADMIN">General Administration</option>
                                <option value="AUXILLIARY">Auxialliary</option>
                                <option value="ADVANCE">Advance Education</option>
                                <option value="CEN">College of Engineering</option>
                                <option value="CIT">College of Industrial Technology</option>
                                <option value="CBA">College of Business Administration and Accountancy</option>
                                <option value="CAS">College of Arts and Sciences</option>
                                <option value="CAFA">College of Architecture and Fine Arts</option>
                                <option value="CED">College of Education</option>
                                <option value="PE">Physical Education</option>
                                <option value="RESEARCH">Research</option>
                                <option value="EXTENSION">Cavite Extension</option>
                                <option value="TEMPO">Temporary Employee</option>
                                <option value="N EMPLOYEE 3">New Employee Batch 3</option>
                                <option value="N EMPLOYEE 4">New Employee Batch 4</option>
                                <option value="N EMPLOYEE A">New Employee Batch A</option>
                            </select> 
                        </div>

                        <div class="form-group">
                            <label>Months</label>
                            <div class="dropdown-checkbox">
                                <button class="form-control dropdown-toggle" type="button" onclick="toggleMonthDropdown()">
                                    Select Months <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu checkbox-menu" style="display:none;">
                                    <li><label><input type="checkbox" value="JANUARY"> January</label></li>
                                    <li><label><input type="checkbox" value="FEBRUARY"> February</label></li>
                                    <li><label><input type="checkbox" value="MARCH"> March</label></li>
                                    <li><label><input type="checkbox" value="APRIL"> April</label></li>
                                    <li><label><input type="checkbox" value="MAY"> May</label></li>
                                    <li><label><input type="checkbox" value="JUNE"> June</label></li>
                                    <li><label><input type="checkbox" value="JULY"> July</label></li>
                                    <li><label><input type="checkbox" value="AUGUST"> August</label></li>
                                    <li><label><input type="checkbox" value="SEPTEMBER"> September</label></li>
                                    <li><label><input type="checkbox" value="OCTOBER"> October</label></li>
                                    <li><label><input type="checkbox" value="NOVEMBER"> November</label></li>
                                    <li><label><input type="checkbox" value="DECEMBER"> December</label></li>
                                </ul>
                            </div>
                            <input type="hidden" id="month" name="month" required>
                        </div>
                    </div>

               
                    <div style="margin: 20px 0;">
                        <label><strong>Search Name:</strong></label>
                        <input type="text" id="nameFilter" placeholder="Enter name..." style="padding: 6px; width: 200px; margin-right: 20px;">

                        <label><strong>Select Column:</strong></label>
                        <select id="columnSelect" style="padding: 6px;">
                            <option value="17">PhilHealth</option>
                            <option value="2">Withholding Tax</option>
                            <option value="1">Position</option>
                        </select>
                    </div>

                    
                </div>


                <div class="table-wrapper">
                    <table class="table" id="employeeTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Withholding Tax</th>
                                <th>Personal Life Retirement</th>
                                <th>GSIS Salary Loan</th>
                                <th>GSIS Policy Loan</th>
                                <th>GFAL</th>
                                <th>CPL</th>
                                <th>MPL</th>
                                <th>MPL Lite</th>
                                <th>Emergency Loan</th>
                                <th>Total GSIS Deductions</th>
                                <th>PAG-IBIG Fund Contribution</th>
                                <th>PAG-IBIG 2</th>
                                <th>Multi-Purpose Loan</th>
                                <th>PAG-IBIG Calamity Loan</th>
                                <th>Total PAG-IBIG Deductions</th>
                                <th>PhilHealth</th>
                                <th>Disallowance</th>
                                <th>Landbank Salary Loan</th>
                                <th>Earist Credit Coop</th>
                                <th>FEU</th>
                                <th>MTSLA Salary Loan</th>
                                <th>ESLA</th>
                                <th>Total Other Deductions</th>
                                <th>Total Deductions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>    
                        <tbody id="employeeTableBody">
                            <!-- Employee data rows will be dynamically added here -->
                        </tbody>
                    </table>
                </div>
                <div id="emptyState" class="empty-state">
                    <i class="fas fa-users-slash"></i>
                    <p>No employees found. Add your first employee to get started!</p>
                </div>
            </div>

            <!-- Add Employee Tab -->
            <div id="addTab" class="tab-content">
                <div class="section-header">
                    <div class="title">
                        <h2>Add New Employee</h2>
                    </div>
                    <div class="add-department-button">
                        <button popovertarget="add-department-modal" type="submit" class="btn btn-primary">
                           <i class="fas fa-plus"></i>  Add Department
                        </button>
                    </div>
                </div>
                <form id="employeeForm" method="POST" action="savePayroll.php">
                    <div class="form-section">
                        <h3><i class="fas fa-user-circle"></i> Basic Information</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name">Employee Name *</label>
                                <input type="text" id="name" name="name" required placeholder="Enter full name">
                            </div>
                            <div class="form-group">
                                <label for="position">Position *</label>
                                <input type="text" id="position" name="position" required placeholder="Enter position">
                            </div>
                            <div class="form-group">
                                <label for="department">Department</label>
                                <select id="department" class="form-control" required>
                                    <option value="">Select Department</option>
                                    <option value="ADMIN">General Administration</option>
                                    <option value="AUXILLIARY">Auxialliary</option>
                                    <option value="ADVANCE">Advance Education</option>
                                    <option value="CEN">College of Engineering</option>
                                    <option value="CIT">College of Industrial Technology</option>
                                    <option value="CBA">College of Business Administration and Accountancy</option>
                                    <option value="CAS">College of Arts and Sciences</option>
                                    <option value="CAFA">College of Architecture and Fine Arts</option>
                                    <option value="CED">College of Education</option>
                                    <option value="PE">Physical Education</option>
                                    <option value="RESEARCH">Research</option>
                                    <option value="EXTENSION">Cavite Extension</option>
                                    <option value="TEMPO">Temporary Employee</option>
                                    <option value="N EMPLOYEE 3">New Employee Batch 3</option>
                                    <option value="N EMPLOYEE 4">New Employee Batch 4</option>
                                    <option value="N EMPLOYEE A">New Employee Batch A</option>
                                </select> 
                            </div>

                            <div class="form-group">
                                <label for="department">Month</label>
                                <select id="month" class="form-control" required>
                                    <option value="">Select Month</option>
                                    <option value="">January</option>
                                    <option value="">February</option>
                                    <option value="">March</option>
                                    <option value="">April</option>
                                    <option value="">May</option>
                                    <option value="">June</option>
                                    <option value="">July</option>
                                    <option value="">August</option>
                                    <option value="">Spetember</option>
                                    <option value="">October</option>
                                    <option value="">November</option>
                                    <option value="">December</option>
                                </select> 
                            </div>
                        </div>
                    </div>

                    <div class="form-section payroll-section">
                        <h3><i class="fas fa-file-invoice-dollar"></i> Employee Payroll</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="rateNbc594">rateNbc594</label>
                                <input type="number" step="0.01" id="rateNbc594" name="rateNbc594" placeholder="0.00">
                            </div>
                            <div class="form-group">
                                <label for="nbcDiff594">nbcDiff594</label>
                                <input type="number" step="0.01" id="nbcDiff594" name="nbcDiff594" placeholder="0.00">
                            </div>
                            <div class="form-group">
                                <label for="increment">Increment</label>
                                <input type="number" step="0.01" id="increment" name="increment" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="grossSalary">Gross Salary</label>
                                <input type="number" step="0.01" id="grossSalary" name="grossSalary" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="absent">Absent</label>
                                <input type="number" step="0.01" id="absent" name="absent" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="days">Days</label>
                                <input type="number" step="0.01" id="days" name="days" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="hours">Hours</label>
                                <input type="number" step="0.01" id="hours" name="hours" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="minutes">Minutes</label>
                                <input type="number" step="0.01" id="minutes" name="minutes" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="deductedGrossSalary">Deducted Gross Salary</label>
                                <input type="number" step="0.01" id="deductedGrossSalary" name="deductedGrossSalary" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="withHoldingTax">Withholding Tax</label>
                                <input type="number" step="0.01" id="withHoldingTax" name="withHoldingTax" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="totalGsisDeds">Total GSIS Deductions</label>
                                <input type="number" step="0.01" id="totalGsisDeds" name="totalGsisDeds" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="totalPagibigDeds">Total PAG-IBIG Deductions</label>
                                <input type="number" step="0.01" id="totalPagibigDeds" name="totalPagibigDeds" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="philHealthEmployeeShare">PhilHealth Employee Share</label>
                                <input type="number" step="0.01" id="philHealthEmployeeShare" name="philHealthEmployeeShare" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="totalOtherDeds">Total Other Deductions</label>
                                <input type="number" step="0.01" id="totalOtherDeds" name="totalOtherDeds" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="totalDeds">Total Deductions</label>
                                <input type="number" step="0.01" id="totalDeds" name="totalDeds" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="pay1st">1st Pay</label>
                                <input type="number" step="0.01" id="pay1st" name="pay1st" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="pay2nd">2nd Pay</label>
                                <input type="number" step="0.01" id="pay2nd" name="pay2nd" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="rtIns">RT Insurance</label>
                                <input type="number" step="0.01" id="rtIns" name="rtIns" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="employeesCompensation">Employee's Compensation</label>
                                <input type="number" step="0.01" id="employeesCompensation" name="employeesCompensation" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="philHealthGovernmentShare">PhilHealth Government Share</label>
                                <input type="number" step="0.01" id="philHealthGovernmentShare" name="philHealthGovernmentShare" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="pagibig">PAG-IBIG</label>
                                <input type="number" step="0.01" id="pagibig" name="pagibig" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="netSalary">Net Salary</label>
                                <input type="number" step="0.01" id="netSalary" name="netSalary" placeholder="0.00">
                            </div>

                        </div>
                    </div>

                    <div class="form-section remittance-section">
                        <h3><i class="fas fa-file-invoice-dollar"></i> Employee Remittance</h3> 
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="withholdingTax">Withholding Tax</label>
                                <input type="number" step="0.01" id="withholdingTax" name="withholdingTaxRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="personalLifeRet">Personal Life Retirement</label>
                                <input type="number" step="0.01" id="personalLifeRet" name="personalLifeRetRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="gsisSalaryLoan">GSIS Salary Loan</label>
                                <input type="number" step="0.01" id="gsisSalaryLoan" name="gsisSalaryLoanRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="gsisPolicyLoan">GSIS Policy Loan</label>
                                <input type="number" step="0.01" id="gsisPolicyLoan" name="gsisPolicyLoanRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="gfal">GFAL</label>
                                <input type="number" step="0.01" id="gfal" name="gfalRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="cpl">CPL</label>
                                <input type="number" step="0.01" id="cpl" name="cplRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="mpl">MPL</label>
                                <input type="number" step="0.01" id="mpl" name="mplRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="mplLite">MPL Lite</label>
                                <input type="number" step="0.01" id="mplLite" name="mplLiteRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="emergencyLoan">Emergency Loan</label>
                                <input type="number" step="0.01" id="emergencyLoan" name="emergencyLoanRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="totalGsisDeds">Total GSIS Deductions</label>
                                <input type="number" step="0.01" id="totalGsisDeds" name="totalGsisDedsRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="pagibigFundCont">PAG-IBIG Fund Contribution</label>
                                <input type="number" step="0.01" id="pagibigFundCont" name="pagibigFundContRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="pagibig2">PAG-IBIG 2</label>
                                <input type="number" step="0.01" id="pagibig2" name="pagibig2Remit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="multiPurpLoan">Multi-Purpose Loan</label>
                                <input type="number" step="0.01" id="multiPurpLoan" name="multiPurpLoanRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="pagibigCalamityLoan">PAG-IBIG Calamity Loan</label>
                                <input type="number" step="0.01" id="pagibigCalamityLoan" name="pagibigCalamityLoanRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="totalPagibigDeds">Total PAG-IBIG Deductions</label>
                                <input type="number" step="0.01" id="totalPagibigDeds" name="totalPagibigDedsRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="philHealth">PhilHealth</label>
                                <input type="number" step="0.01" id="philHealth" name="philHealthRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="disallowance">Disallowance</label>
                                <input type="number" step="0.01" id="disallowance" name="disallowanceRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="landbankSalaryLoan">Landbank Salary Loan</label>
                                <input type="number" step="0.01" id="landbankSalaryLoan" name="landbankSalaryLoanRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="earistCreditCoop">Earist Credit Coop</label>
                                <input type="number" step="0.01" id="earistCreditCoop" name="earistCreditCoopRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="feu">FEU</label>
                                <input type="number" step="0.01" id="feu" name="feuRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="mtslaSalaryLoan">MTSLA Salary Loan</label>
                                <input type="number" step="0.01" id="mtslaSalaryLoan" name="mtslaSalaryLoanRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="esla">ESLA</label>
                                <input type="number" step="0.01" id="esla" name="eslaRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="totalOtherDeds">Total Other Deductions</label>
                                <input type="number" step="0.01" id="totalOtherDeds" name="totalOtherDedsRemit" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="totalDeds">Total Deductions</label>
                                <input type="number" step="0.01" id="totalDeds" name="totalDedsRemit" placeholder="0.00">
                            </div>

                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-redo"></i> Reset Form
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>


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
        
            
        // Global employees array
        let employees = [];

        // Function to render employee table
        function renderEmployeeTable() {
            const tbody = document.getElementById('employeeTableBody');
            const emptyState = document.getElementById('emptyState');
            
            if (employees.length === 0) {
                tbody.innerHTML = '';
                emptyState.style.display = 'block';
                return;
            }
            
            emptyState.style.display = 'none';
            
            tbody.innerHTML = employees.map(employee => `
                <tr>
                    <td>${employee.name || ''}</td>
                    <td>${employee.position || ''}</td>
                    <td>${employee.withHoldingTax || '0.00'}</td>
                    <td>${employee.personalLifeRetRemit || '0.00'}</td>
                    <td>${employee.gsisSalaryLoanRemit || '0.00'}</td>
                    <td>${employee.gsisPolicyLoanRemit || '0.00'}</td>
                    <td>${employee.gfalRemit || '0.00'}</td>
                    <td>${employee.cplRemit || '0.00'}</td>
                    <td>${employee.mplRemit || '0.00'}</td>
                    <td>${employee.mplLiteRemit || '0.00'}</td>
                    <td>${employee.emergencyLoanRemit || '0.00'}</td>
                    <td>${employee.totalGsisDedsRemit || '0.00'}</td>
                    <td>${employee.pagibigFundContRemit || '0.00'}</td>
                    <td>${employee.pagibig2Remit || '0.00'}</td>
                    <td>${employee.multiPurpLoanRemit || '0.00'}</td>
                    <td>${employee.pagibigCalamityLoanRemit || '0.00'}</td>
                    <td>${employee.totalPagibigDedsRemit || '0.00'}</td>
                    <td>${employee.philHealthRemit || '0.00'}</td>
                    <td>${employee.disallowanceRemit || '0.00'}</td>
                    <td>${employee.landbankSalaryLoanRemit || '0.00'}</td>
                    <td>${employee.earistCreditCoopRemit || '0.00'}</td>
                    <td>${employee.feuRemit || '0.00'}</td>
                    <td>${employee.mtslaSalaryLoanRemit || '0.00'}</td>
                    <td>${employee.eslaRemit || '0.00'}</td>
                    <td>${employee.totalOtherDedsRemit || '0.00'}</td>
                    <td>${employee.totalDedsRemit || '0.00'}</td>
                    <td>
                        <button class="btn-edit" onclick="editEmployee(${employees.indexOf(employee)})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn-delete" onclick="deleteEmployee(${employees.indexOf(employee)})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            `).join('');
        }


        // Tab switching functionality
        function switchTab(tab) {
            const viewTab = document.getElementById('viewTab');
            const addTab = document.getElementById('addTab');
            const tabButtons = document.querySelectorAll('.tab-button');

            if (tab === 'view') {
                viewTab.classList.add('active');
                addTab.classList.remove('active');
                tabButtons[0].classList.add('active');
                tabButtons[1].classList.remove('active');
            } else {
                viewTab.classList.remove('active');
                addTab.classList.add('active');
                tabButtons[0].classList.remove('active');
                tabButtons[1].classList.add('active');
            }
        }

        // Dark mode toggle
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('themeMode');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
            }
        }); 

        // Load dark mode preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
        }

        // Form submission
        // Form submission
        document.getElementById('employeeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const employee = {};
            
            // Convert FormData to object
            formData.forEach((value, key) => {
                employee[key] = value || '0.00';
            });

            // Add to local array for immediate display
            employees.push(employee);
            renderEmployeeTable();
            resetForm();
            switchTab('view');
            
            // Send data to PHP backend
            fetch('savePayroll.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(formData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                console.log('Success:', data);
                alert('Employee added successfully!');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving employee data. Please try again.');
            });
        });



        document.getElementById('department-form').addEventListener('submit', function(e) {
            e.preventDefault();
            // Send data to PHP backend
            fetch('saveDepartment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(formData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                console.log('Success:', data);
                alert('Department added successfully!');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving employee data. Please try again.');
            });
        });


        

        // Reset form
        function resetForm() {
            document.getElementById('employeeForm').reset();
        }

        // Delete employee
        function deleteEmployee(index) {
            if (confirm('Are you sure you want to delete this employee?')) {
                employees.splice(index, 1);
                renderEmployeeTable();
            }
        }

        // Initial render
        renderEmployeeTable();
    </script>
</body>
</html>
