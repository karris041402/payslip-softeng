<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel to Database Import</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
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

        <a href="employee.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Employee Management
        </a>
    </div>

    <script>
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
    </script>
</body>
</html>