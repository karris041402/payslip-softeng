<?php
header('Content-Type: application/json');
require_once 'db.php';

function searchEmployee($department, $months, $employeeName) {
    global $conn;
    $results = [];
    
    // Get department_id
    $deptStmt = $conn->prepare("SELECT id FROM department WHERE department_name = ?");
    $deptStmt->bind_param("s", $department);
    $deptStmt->execute();
    $deptResult = $deptStmt->get_result();
    
    if ($deptResult->num_rows === 0) {
        return [['success' => false, 'error' => 'Department not found']];
    }
    
    $department_id = $deptResult->fetch_assoc()['id'];
    $deptStmt->close();

    foreach ($months as $month) {
        // Get month_id
        $monthStmt = $conn->prepare("SELECT id FROM month WHERE month_name = ?");
        $monthStmt->bind_param("s", $month);
        $monthStmt->execute();
        $monthResult = $monthStmt->get_result();
        
        if ($monthResult->num_rows === 0) {
            $results[] = ['month' => $month, 'success' => false, 'error' => 'Month not found'];
            $monthStmt->close();
            continue;
        }
        
        $month_id = $monthResult->fetch_assoc()['id'];
        $monthStmt->close();

        // Search for employee
        $sql = "SELECT 
                p.name,
                p.position,
                p.grossSalary as gross_salary,
                p.absent as absences,
                p.withHoldingTax as tax,
                p.netSalary as net_salary,
                p.pay1st as pay_first,
                p.pay2nd as pay_second,
                r.personalLifeRet as life_retirement,
                r.gsisSalaryLoan as gsis_salary_loan,
                r.gsisPolicyLoan as gsis_policy_loan,
                r.gfal as gsis_gfal,
                r.cpl as gsis_cpl,
                r.mpl as gsis_mpl,
                r.mplLite as gsis_mpl_lite,
                r.emergencyLoan as gsis_emergency_loan,
                r.pagibigFundCont as pagibig,
                r.multiPurpLoan as pagibig_mpl,
                r.pagibigCalamityLoan as pagibig_calamity_loan,
                r.philHealth as philhealth,
                r.landbankSalaryLoan as lbp,
                r.mtslaSalaryLoan as mtsla,
                r.earistCreditCoop as ecc,
                r.feu,
                r.disallowance,
                r.totalDeds as total_deductions,
                0 as gsis_housing_loan
            FROM employeedatapayroll p
            JOIN employeedataremittance r ON p.id = r.payroll_id
            WHERE p.department_id = ? 
            AND p.month_id = ? 
            AND p.name LIKE ?";
        
        $searchName = "%{$employeeName}%";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $department_id, $month_id, $searchName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $employeeData = $result->fetch_assoc();
            $employeeData['department'] = $department;
            $employeeData['month'] = $month;
            
            $results[] = [
                'month' => $month,
                'success' => true,
                'employee' => $employeeData
            ];
        } else {
            $results[] = [
                'month' => $month,
                'success' => false,
                'error' => 'Employee not found in this month.'
            ];
        }
        
        $stmt->close();
    }

    return $results;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $department = $_POST['department'] ?? '';
    $monthStr = $_POST['month'] ?? '';
    $employee = $_POST['employee'] ?? '';

    if (!$department || !$monthStr || !$employee) {
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        exit;
    }

    $months = explode(",", $monthStr);
    $data = searchEmployee($department, $months, $employee);

    echo json_encode([
        'success' => true,
        'results' => $data
    ]);
    exit;
}
