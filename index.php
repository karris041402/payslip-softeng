
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Payslip Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        body.dark-mode {
            background: #181c23 !important;
            color: #e0e6ef !important;
        }

        body.dark-mode .container {
            background: #232b36 !important;
            color: #e0e6ef !important;
        }

        body.dark-mode label {
            color: #3498db !important;
        }

        body.dark-mode .search-title{
            color: #3498db !important;
            
        }
        body.dark-mode .header {
            background: linear-gradient(135deg, #232b36 0%, #2c3e50 100%) !important;
            color: #fff !important;
        }

        body.dark-mode .search-section,
        body.dark-mode .results-section {
            background: #232b36 !important;
            box-shadow: 6px 6px 10px rgba(0, 0, 0, 0.15), -6px -6px 10px rgba(0, 0, 0, 0.16) !important; 
            color: #e0e6ef !important;
        }

        body.dark-mode .form-control,
        body.dark-mode .dropdown-checkbox .dropdown-toggle {
            background: #232b36 !important;
            color: #e0e6ef !important;
            border-color: #444 !important;
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

        /* Force payslip to stay light even in dark mode */
        body.dark-mode .payslip,
        body.dark-mode .payslip-content,
        body.dark-mode .payslip table,
        body.dark-mode .payslip table td,
        body.dark-mode .payslip .certified,
        body.dark-mode .payslip .director {
            background: #fff !important;
            color: #222 !important;
            border-color: #000 !important;
        }

        body.dark-mode .payslip .table-header{
            background: linear-gradient(135deg, #771515ff 0%, #fa3706ff 100%) !important;
        }

        body.dark-mode .payslip .info-header{
            background-color: transparent !important;
        }

        body.dark-mode .payslip table td {
            background: #fff !important;
            color: #222 !important;
        }

        body.dark-mode .loading{
            color: white !important;
        }

        body.dark-mode .dropdown-checkbox .caret {
            border-top: 6px solid #eee !important;
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


        .header-container {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            display: flex;
            flex-direction: column;
            padding: 40px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            border-top-right-radius: 13px;
            border-top-left-radius: 13px;
        }

        .header-container h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .header-container p {
            font-size: 1.2em;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            display: flex;
            flex-direction: column;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
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

        .table-header{
            background: linear-gradient(135deg, #771515ff 0%, #fa3706ff 100%);
        }


        .main-content {
            padding: 40px;
        }

        .search-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #f8fcffff 100%);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
           box-shadow: 
        -6px -6px 10px rgba(0, 0, 0, 0.15), 
        4px  4px 15px rgba(163, 183, 212, 0.8); 

        }

        .search-title {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            color: #2c3e50;
            font-size: 1.5em;
            font-weight: 600;
        }

        .search-title i {
            margin-right: 10px;
            color: #3498db;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-group {
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            outline: none;
        }

        .dropdown-checkbox {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .dropdown-checkbox .dropdown-toggle {
            text-align: left;
            padding-right: 30px;
            position: relative;
            background: white;
            border: 1px solid #ced4da;
            width: 100%;
            height: calc(1.9em + .75rem + 2px);
            padding: .375rem .75rem;
            cursor: pointer;
        }

        .dropdown-checkbox .caret {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            border-top: 6px solid #555;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            transition: transform 0.3s ease;
        }

        .dropdown-checkbox .caret.rotate {
            transform: translateY(-50%) rotate(180deg);
        }

        .checkbox-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            width: 100%;
            border: 1px solid #ced4da;
            border-top: none;
            background: white;
            box-shadow: 0 6px 12px rgba(0,0,0,0.175);
            max-height: 300px;
            overflow-y: auto;
            border-bottom-left-radius: 20px;  
            border-bottom-right-radius: 20px; 
            max-height: 110px; 
            display: none;
        }

        .checkbox-menu li {
            list-style: none;
        }

        .checkbox-menu li label {
            display: flex;
            align-items: center;
            padding: 8px 15px;
            margin: 0;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .checkbox-menu li label:hover {
            background-color: #f8f9fa;
        }

        .checkbox-menu li input[type="checkbox"] {
            margin-right: 10px;
        }

        .form-text {
            margin-top: 5px;
        }


        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
        }

        .results-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #f8fcffff 100%);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 
                -6px -6px 10px rgba(0, 0, 0, 0.15),
                4px  4px 15px rgba(163, 183, 212, 0.8); 
            display: none;
        }

        .results-section.active {
            display: block;
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .download-section {
            text-align: center;
            margin-top: -140px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: black;
        }

        .loading i {
            font-size: 3em;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .employee-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .payslip-details {
                grid-template-columns: 1fr;
            }
        }

        .page-landscape {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            padding: 20px;
            width: 100%;
            box-sizing: border-box;
            gap: 10px;
        }
        .payslip-wrapper {
            margin-top: -150px;
            margin-left: -145px;
            display: flex;
            flex-wrap: nowrap;
            gap: 24px;
            justify-content: flex-start;
            width: 100%;
            max-width: 100%;
            transform: scale(0.6); 
        }
        .payslip {
            width: 560px !important;       
            max-width: 650px !important;   
            flex-shrink: 0;                 
            flex-grow: 0; 
            background-color: white;
            border: 1px solid #000;
            padding: 0;
            box-sizing: border-box;
            page-break-inside: avoid;
            height: auto;
            margin: 0 5px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            position: relative;
        }
        .payslip-content {
            width: 540px !important;        
            padding: 16px;
            flex-shrink: 0;  
        }

        .header {
            padding: 20px 20px 90px 20px;
            text-align: center;
            margin-bottom: 10px;
            position: relative;
            display: flex;
            justify-content: space-around;
            height: 13%;
        }

        .header img {
            width: 40%;
            margin-left: -20px;
            height: auto;
            position: absolute;
            left: 10px;
            top: 10px;
        }

        .info-header{
            width: 70%;
            position: absolute;
            right: 10px;
            top: 23px;
        }

        .header h2, .header h4 {
            text-align: center;
            font-size: 12px;
        }

        .label {
            font-weight: bold;
        }

        .employee-name{
            font-weight: bold;
            font-size: 17px;
        }

        .payslip table {
            width: 100%;
            border-collapse: collapse;
            font-size: 18px;
            margin-top: 10px;
        }

        .right{
            text-align: right;
        }

        .left{
            text-align: left;
        }

        .payslip table td {
            border: 1px solid #000;
            padding: 4px 8px;
            vertical-align: top;
        }

        .certified {
            margin-top: 20px;
            font-size: 16px;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .director strong {
            display: block;
            margin-top: 10px;
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
        <div class="header-container">
            <h1><i class="fas fa-building"></i> HR Payslip Management System</h1>
            <p>Professional Employee Payroll Management</p>
        </div>
        
        <div class="main-content">
            <div class="search-section">
                <div class="search-title">
                    <i class="fas fa-search"></i>
                    Employee Search
                </div>
                
                <form id="searchForm">
                    <div class="form-grid">
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
                                <option value="add_department" style="color: #3498db;">➕ Add Department</option>
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
                        
                        <div class="form-group" style="position: relative;">
                            <label for="employee">Employee Name</label>
                            <input type="text" id="employee" class="form-control" placeholder="Enter last name..." autocomplete="off" required>
                        </div>

                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search Employee
                    </button>
                </form>
            </div>
            
            <div id="results" class="results-section">
                <div id="loading" class="loading">
                    <i class="fas fa-spinner"></i>
                    <p>Searching for employee data...</p>
                </div>
                
                <div id="employeeData" style="display: none;">
                
                </div>
            
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
            <li><i class="fas fa-file-excel"></i> Excel Management</li>
            <li><i class="fas fa-user"></i> Employees</li>
            <li class="activeTab"><i class="fas fa-file-invoice"></i> Payslip Generator</li>
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
                    if (this.textContent.includes('Excel')) window.location.href = 'manage_excells.php';
                    if (this.textContent.includes('Employees')) window.location.href = 'employee.php';
                    if (this.textContent.includes('Payslip Generator')) window.location.href = 'index.php';
                    if (this.textContent.includes('Payslip History')) window.location.href = 'payslip_history.php';
                    if (this.textContent.includes('Reports')) window.location.href = 'reports.php';
                    if (this.textContent.includes('Account Settings')) window.location.href = 'account_settings.php';
                    if (this.classList.contains('mode-toggle')) toggleMode();
                });
            });

        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const department = document.getElementById('department').value;
            const month = document.getElementById('month').value;
            const employeeName = document.getElementById('employee').value;

            searchEmployee(department, month, employeeName);
        });

        function searchEmployee(department, months, employeeName) {
            const resultsSection = document.getElementById('results');
            const loading = document.getElementById('loading');
            const employeeData = document.getElementById('employeeData');

            resultsSection.classList.add('active');
            loading.style.display = 'block';
            employeeData.style.display = 'none';

            const formData = new FormData();
            formData.append('department', department);
            formData.append('month', months); 
            formData.append('employee', employeeName);

            fetch('search_employee.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    loading.style.display = 'none';

                    if (!data.success) {
                        // Hide the results section completely if there's a general error
                        resultsSection.classList.remove('active');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.error,
                            timer: 3500,
                            showConfirmButton: false
                        });
                        return;
                    }   
                    
                    // Clear previous results
                    employeeData.innerHTML = "";

                    let payslipsHTML = "";
                    let hasSuccessfulResults = false;
                    
                    data.results.forEach(result => {
                        if (result.success) {
                            payslipsHTML += generatePayslipHTML(result.employee);
                            hasSuccessfulResults = true;
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: `No Record Available!`,
                                text: result.error,
                                timer: 3500,
                                showConfirmButton: false
                            });
                        }
                    });

                    if (hasSuccessfulResults) {
                        employeeData.innerHTML = `
                            <div class="page-landscape">
                                <div class="payslip-wrapper">
                                    ${payslipsHTML}
                                </div>
                            </div>
                            <div class="download-section">
                                <button class="btn btn-success" onclick="downloadPayslips()">
                                    <i class="fas fa-print"></i> Download Payslips
                                </button>
                            </div>
                        `;
                        employeeData.style.display = "block";
                    } else {
                        // Hide the results section if no successful results
                        resultsSection.classList.remove('active');
                    }
                })
                .catch(err => {
                    loading.style.display = 'none';
                    // Hide the results section on fetch error
                    resultsSection.classList.remove('active');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while searching for employee data.',
                        timer: 3500,
                        showConfirmButton: false
                    });
                });
        }

        function generatePayslipHTML(data) {

        
            const plusPera = 2000.00;


            function safeAmount(value) {
                if (!value || isNaN(parseFloat(value))) return '0.00';
                return parseFloat(value).toLocaleString('en-PH', { minimumFractionDigits: 2 });
            }

            return `
                <div class="payslip">
                <h1 style="position: absolute; top: 40%; font-size: 200px; overflow: hidden; transform: rotate(290deg); color: rgb(0, 0, 0, 0.1)">HRMS</h1>
                    <div class="payslip-content">
                        <div class="header table-header">
                            <img style="width: 80px; position: absolute; left:10%; top: 15%; height: auto;" src="EARIST_Logo (1).png" alt="Logo">
                            <div class="info-header">
                                <h2>Republic of the Philippines</h2>
                                <h4>EULOGIO "AMANG" RODRIGUEZ INSTITUTE OF SCIENCE AND TECHNOLOGY</h4>
                                <h4>Nagtahan, Sampaloc, Manila</h4>     
                            </div>
                        </div>
                        <table>
                            <tr><td class="label name">NAME:</td><td class="employee-name">${data.name || 'N/A'}</td></tr>
                                        <tr><td class="left">PERIOD:</td><td class="right">${data.month} 2025</td></tr>
                                        <tr><td class="left">GROSS SALARY:</td><td class="right">₱${safeAmount(data.gross_salary)}</td></tr>
                                        <tr><td class="left">ABS.:</td><td class="right">${(data.absences)}</td></tr>
                                        <tr><td class="left">W/HOLDING TAX:</td><td class="right">₱${safeAmount(data.tax)}</td></tr>
                                        <tr><td class="left">L. RET:</td><td class="right">₱${safeAmount(data.life_retirement)}</td></tr>
                                        <tr><td class="left">GSIS SALARY LOAN:</td><td class="right">₱${safeAmount(data.gsis_salary_loan)}</td></tr>
                                        <tr><td class="left">POLICY:</td><td class="right">₱${safeAmount(data.gsis_policy_loan)}</td></tr>
                                        <tr><td class="left">HOUSING LOAN:</td><td class="right">₱${safeAmount(data.gsis_housing_loan)}</td></tr>
                                        <tr><td class="left">GFAL:</td><td class="right">₱${safeAmount(data.gsis_gfal)}</td></tr>
                                        <tr><td class="left">CPL:</td><td class="right">₱${safeAmount(data.gsis_cpl)}</td></tr>
                                        <tr><td class="left">MPL:</td><td class="right">₱${safeAmount(data.gsis_mpl)}</td></tr>
                                        <tr><td class="left">MPL LITE:</td><td class="right">₱${safeAmount(data.gsis_mpl_lite)}</td></tr>
                                        <tr><td class="left">EMERGENCY LOAN:</td><td class="right">₱${safeAmount(data.gsis_emergency_loan)}</td></tr>
                                        <tr><td class="left">PAG-IBIG:</td><td class="right">₱${safeAmount(data.pagibig)}</td></tr>
                                        <tr><td class="left">PAG-IBIG MPL:</td><td class="right">₱${safeAmount(data.pagibig_mpl)}</td></tr>
                                        <tr><td class="left">PAGIBIG CL:</td><td class="right">₱${safeAmount(data.pagibig_calamity_loan)}</td></tr>
                                        <tr><td class="left">PHILHEALTH:</td><td class="right">₱${safeAmount(data.philhealth)}</td></tr>
                                        <tr><td class="left">LBP LOAN:</td><td class="right">₱${safeAmount(data.lbp)}</td></tr>
                                        <tr><td class="left">MTSLA:</td><td class="right">₱${safeAmount(data.mtsla)}</td></tr>
                                        <tr><td class="left">ECC:</td><td class="right">₱${safeAmount(data.ecc)}</td></tr>
                                        <tr><td class="left">FEU:</td><td class="right">₱${safeAmount(data.feu)}</td></tr>   
                                        <tr><td class="left">DISALLOW.:</td><td class="right">₱${safeAmount(data.disallowance)}</td></tr>      
                                        <tr><td class="left">TOTAL DEDUCTIONS:</td><td class="right">₱${safeAmount(data.total_deductions)}</td></tr>
                                        <tr><td class="left">NET SALARY:</td><td class="right">₱${safeAmount(data.net_salary)}</td></tr>
                                        <tr><td class="left">1ST QUINCENA:</td><td class="right">₱${safeAmount(data.pay_first)}</td></tr>
                                        <tr><td class="left">2ND QUINCENA:</td><td class="right">₱${safeAmount(data.pay_second)}</td></tr>
                        </table>
                        <div class="certified">
                        <p>Certified Correct</p>
                        <p>plus PERA - ₱${safeAmount(plusPera)} </p>
                        </div>
                        <div class="director">
                            <strong>GIOVANNI L. AHUNIN</strong>
                            Director, Administrative Services
                        </div>
                    </div>
                </div>
            `;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const formControls = document.querySelectorAll('.form-control');
            formControls.forEach(control => {
                control.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });
                control.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });
        });



        function toggleMonthDropdown() {
            const dropdownMenu = document.querySelector(".checkbox-menu");
            const caret = document.querySelector(".caret");
            
            if (dropdownMenu.style.display === "block") {
                dropdownMenu.style.display = "none";
                caret.classList.remove("rotate");
            } else {
                dropdownMenu.style.display = "block";
                caret.classList.add("rotate");
            }
        }

        // Close dropdown if clicked outside
        document.addEventListener("click", function (event) {
            const dropdown = document.querySelector(".dropdown-checkbox");
            if (!dropdown.contains(event.target)) {
                document.querySelector(".checkbox-menu").style.display = "none";
                document.querySelector(".caret").classList.remove("rotate");
            }
        });

        // Update hidden input and limit to 3 selections
        document.querySelectorAll(".checkbox-menu input[type='checkbox']").forEach((checkbox) => {
            checkbox.addEventListener("change", function () {
                const selected = Array.from(
                    document.querySelectorAll(".checkbox-menu input[type='checkbox']:checked")
                ).map((cb) => cb.value);

                // Limit to 3 months
                if (selected.length > 3) {
                    this.checked = false; // undo last check
                    alert("You can only select up to 3 months.");
                    return;
                }

                document.getElementById("month").value = selected.join(",");
            });
        });


        function downloadPayslips() {
            const payslipPage = document.querySelector('.page-landscape');
            const { jsPDF } = window.jspdf;
            const settings = {
                orientation: 'l',
                format: 'a4',
                scale: 4, 
                marginLeft: -25,
                marginTop: -15,
                contentWidth: 360,
                backgroundColor: '#FFFFFF'
            };

            const nameElem = payslipPage.querySelector('.employee-name');
            let surname = 'employee';
            if (nameElem) {
                const fullName = nameElem.textContent.trim();
                surname = fullName.split(' ')[0] || 'employee';
            }
            const periodElem = payslipPage.querySelector('tr .right');
            let month = 'month';
            if (periodElem) {
                month = periodElem.textContent.trim().replace(/\s+/g, '_');
            }

            const fileName = `payslip_${surname}_${month}.pdf`;
            const department = document.getElementById('department').value;
            const months = document.getElementById('month').value;
            const employeeName = document.getElementById('employee').value;

            html2canvas(payslipPage, {
                scale: settings.scale,
                backgroundColor: settings.backgroundColor
            }).then(canvas => {
                const pdf = new jsPDF(settings.orientation, 'mm', settings.format);
                const imgWidth = settings.contentWidth;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;
                const imgData = canvas.toDataURL('image/jpeg', 0.7);

                pdf.addImage(
                    imgData,
                    'PNG',
                    settings.marginLeft,
                    settings.marginTop,
                    imgWidth,
                    imgHeight
                );
                pdf.save(fileName);

    
                const formData = new FormData();
                formData.append('file_name', fileName);
                formData.append('employee_name', employeeName);
                formData.append('department', department);
                formData.append('months', months);
                
                fetch('record_download.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        console.error('Failed to record download:', data.error);
                    }
                })
                .catch(err => {
                    console.error('Error recording download:', err);
                });
            });
        }

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
