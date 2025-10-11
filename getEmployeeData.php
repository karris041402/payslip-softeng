<?php
require_once 'db.php';

// Get filter parameters
$department = isset($_GET['department']) ? $_GET['department'] : '';
$month = isset($_GET['month']) ? $_GET['month'] : '';
$dataType = isset($_GET['dataType']) ? $_GET['dataType'] : 'remittance';

// Base query with filters
$whereClauses = [];
$params = [];
$types = '';

if (!empty($department)) {
    $whereClauses[] = "d.department_name = ?";
    $params[] = $department;
    $types .= 's';
}

if (!empty($month)) {
    $whereClauses[] = "m.month_name = ?";
    $params[] = $month;
    $types .= 's';
}

$whereSQL = '';
if (count($whereClauses) > 0) {
    $whereSQL = 'WHERE ' . implode(' AND ', $whereClauses);
}

// Determine which data to fetch based on dataType
if ($dataType === 'payroll') {
    // Fetch Payroll Data
    $sql = "
    SELECT 
        p.id,
        p.name,
        p.position,
        p.rateNbc594,
        p.nbcDiffl597,
        p.increment,
        p.grossSalary,
        p.absent,
        p.days,
        p.hours,
        p.minutes,
        p.withHoldingTax,
        p.totalGsisDeds,
        p.totalPagibigDeds,
        p.philHealthEmployeeShare,
        p.totalOtherDeds,
        p.totalDeds,
        p.pay1st,
        p.pay2nd,
        p.rtIns,
        p.employeesCompensation,
        p.philHealthGovernmentShare,
        p.pagibig,
        p.netSalary,
        d.department_name,
        m.month_name
    FROM employeedatapayroll p
    LEFT JOIN department d ON p.department_id = d.id
    LEFT JOIN month m ON p.month_id = m.id
    $whereSQL
    ORDER BY p.name ASC
    ";
} else {
    // Fetch Remittance Data
    $sql = "
    SELECT 
        r.id,
        r.name,
        r.position,
        r.withHoldingTax,
        r.personalLifeRet,
        r.gsisSalaryLoan,
        r.gsisPolicyLoan,
        r.gfal,
        r.cpl,
        r.mpl,
        r.mplLite,
        r.emergencyLoan,
        r.totalGsisDeds,
        r.pagibigFundCont,
        r.pagibig2,
        r.multiPurpLoan,
        r.pagibigCalamityLoan,
        r.totalPagibigDeds,
        r.philHealth,
        r.disallowance,
        r.landbankSalaryLoan,
        r.earistCreditCoop,
        r.feu,
        r.mtslaSalaryLoan,
        r.esla,
        r.totalOtherDeds,
        r.totalDeds,
        d.department_name,
        m.month_name
    FROM employeedataremittance r
    LEFT JOIN department d ON r.department_id = d.id
    LEFT JOIN month m ON r.month_id = m.id
    $whereSQL
    ORDER BY r.name ASC
    ";
}

// Prepare and execute statement
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$employees = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($dataType === 'payroll') {
            $employees[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'position' => $row['position'],
                'rateNbc594' => $row['rateNbc594'] ?? '0.00',
                'nbcDiffl597' => $row['nbcDiffl597'] ?? '0.00',
                'increment' => $row['increment'] ?? '0.00',
                'grossSalary' => $row['grossSalary'] ?? '0.00',
                'absent' => $row['absent'] ?? '0.00',
                'days' => $row['days'] ?? '0.00',
                'hours' => $row['hours'] ?? '0.00',
                'minutes' => $row['minutes'] ?? '0.00',
                'withHoldingTax' => $row['withHoldingTax'] ?? '0.00',
                'totalGsisDeds' => $row['totalGsisDeds'] ?? '0.00',
                'totalPagibigDeds' => $row['totalPagibigDeds'] ?? '0.00',
                'philHealthEmployeeShare' => $row['philHealthEmployeeShare'] ?? '0.00',
                'totalOtherDeds' => $row['totalOtherDeds'] ?? '0.00',
                'totalDeds' => $row['totalDeds'] ?? '0.00',
                'pay1st' => $row['pay1st'] ?? '0.00',
                'pay2nd' => $row['pay2nd'] ?? '0.00',
                'rtIns' => $row['rtIns'] ?? '0.00',
                'employeesCompensation' => $row['employeesCompensation'] ?? '0.00',
                'philHealthGovernmentShare' => $row['philHealthGovernmentShare'] ?? '0.00',
                'pagibig' => $row['pagibig'] ?? '0.00',
                'netSalary' => $row['netSalary'] ?? '0.00',
                'department_name' => $row['department_name'] ?? '',
                'month_name' => $row['month_name'] ?? ''
            ];
        } else {
            $employees[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'position' => $row['position'],
                'withHoldingTax' => $row['withHoldingTax'] ?? '0.00',
                'personalLifeRet' => $row['personalLifeRet'] ?? '0.00',
                'gsisSalaryLoan' => $row['gsisSalaryLoan'] ?? '0.00',
                'gsisPolicyLoan' => $row['gsisPolicyLoan'] ?? '0.00',
                'gfal' => $row['gfal'] ?? '0.00',
                'cpl' => $row['cpl'] ?? '0.00',
                'mpl' => $row['mpl'] ?? '0.00',
                'mplLite' => $row['mplLite'] ?? '0.00',
                'emergencyLoan' => $row['emergencyLoan'] ?? '0.00',
                'totalGsisDeds' => $row['totalGsisDeds'] ?? '0.00',
                'pagibigFundCont' => $row['pagibigFundCont'] ?? '0.00',
                'pagibig2' => $row['pagibig2'] ?? '0.00',
                'multiPurpLoan' => $row['multiPurpLoan'] ?? '0.00',
                'pagibigCalamityLoan' => $row['pagibigCalamityLoan'] ?? '0.00',
                'totalPagibigDeds' => $row['totalPagibigDeds'] ?? '0.00',
                'philHealth' => $row['philHealth'] ?? '0.00',
                'disallowance' => $row['disallowance'] ?? '0.00',
                'landbankSalaryLoan' => $row['landbankSalaryLoan'] ?? '0.00',
                'earistCreditCoop' => $row['earistCreditCoop'] ?? '0.00',
                'feu' => $row['feu'] ?? '0.00',
                'mtslaSalaryLoan' => $row['mtslaSalaryLoan'] ?? '0.00',
                'esla' => $row['esla'] ?? '0.00',
                'totalOtherDeds' => $row['totalOtherDeds'] ?? '0.00',
                'totalDeds' => $row['totalDeds'] ?? '0.00',
                'department_name' => $row['department_name'] ?? '',
                'month_name' => $row['month_name'] ?? ''
            ];
        }
    }
}

// Get total employees
$totalEmployees = $result->num_rows;

// Get total departments
$deptResult = $conn->query("SELECT COUNT(*) AS totalDepartments FROM department");
$totalDepartments = 0;
if ($deptResult && $deptResult->num_rows > 0) {
    $totalDepartments = $deptResult->fetch_assoc()['totalDepartments'];
}

// Get total payslips
$payslipResult = $conn->query("SELECT COUNT(*) AS totalPayslip FROM payslip_history");
$totalPayslip = 0;
if ($payslipResult && $payslipResult->num_rows > 0) {
    $totalPayslip = $payslipResult->fetch_assoc()['totalPayslip'];
}

// Get total gross salary
$grossSql = "SELECT SUM(grossSalary) AS totalGrossSalary FROM employeedatapayroll";
$grossResult = $conn->query($grossSql);
$totalGrossSalary = 0;
if ($grossResult && $grossResult->num_rows > 0) {
    $totalGrossSalary = $grossResult->fetch_assoc()['totalGrossSalary'] ?? 0;
}

header('Content-Type: application/json');
echo json_encode([
    'totalEmployees' => $totalEmployees,
    'totalDepartments' => $totalDepartments,
    'totalPayslip' => $totalPayslip,
    'totalGrossSalary' => number_format($totalGrossSalary, 2, '.', ''),
    'employees' => $employees,
    'dataType' => $dataType
]);

$stmt->close();
$conn->close();
?>
