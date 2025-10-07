<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$user = 'root';
$password = '';
$db = 'payslip-generator';

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Collect form data for payroll
$name = $_POST['name'];
$department_name = $_POST['department'];
$month_name = $_POST['month'];
$position = $_POST['position'];
$rateNbc594 = $_POST['rateNbc594'] ?? 0;
$nbcDiffl597 = $_POST['nbcDiffl597'] ?? 0;
$increment = $_POST['increment'] ?? 0;
$grossSalary = $_POST['grossSalary'] ?? 0;
$absent = $_POST['absent'] ?? 0;
$days = $_POST['days'] ?? 0;
$hours = $_POST['hours'] ?? 0;
$minutes = $_POST['minutes'] ?? 0;
$deductedGrossSalary = $_POST['deductedGrossSalary'] ?? 0;
$withHoldingTax = $_POST['withHoldingTax'] ?? 0;
$totalGsisDeds = $_POST['totalGsisDeds'] ?? 0;
$totalPagibigDeds = $_POST['totalPagibigDeds'] ?? 0;
$philHealthEmployeeShare = $_POST['philHealthEmployeeShare'] ?? 0;
$totalOtherDeds = $_POST['totalOtherDeds'] ?? 0;
$totalDeds = $_POST['totalDeds'] ?? 0;
$pay1st = $_POST['pay1st'] ?? 0;
$pay2nd = $_POST['pay2nd'] ?? 0;
$rtIns = $_POST['rtIns'] ?? 0;
$employeesCompensation = $_POST['employeesCompensation'] ?? 0;
$philHealthGovernmentShare = $_POST['philHealthGovernmentShare'] ?? 0;
$pagibig = $_POST['pagibig'] ?? 0;
$netSalary = $_POST['netSalary'] ?? 0;

// Collect form data for remittances
$withholdingTaxRemit = $_POST['withholdingTaxRemit'] ?? 0;
$personalLifeRetRemit = $_POST['personalLifeRetRemit'] ?? 0;
$gsisSalaryLoanRemit = $_POST['gsisSalaryLoanRemit'] ?? 0;
$gsisPolicyLoanRemit = $_POST['gsisPolicyLoanRemit'] ?? 0;
$gfalRemit = $_POST['gfalRemit'] ?? 0;
$cplRemit = $_POST['cplRemit'] ?? 0;
$mplRemit = $_POST['mplRemit'] ?? 0;
$mplLiteRemit = $_POST['mplLiteRemit'] ?? 0;
$emergencyLoanRemit = $_POST['emergencyLoanRemit'] ?? 0;
$totalGsisDedsRemit = $_POST['totalGsisDedsRemit'] ?? 0;
$pagibigFundContRemit = $_POST['pagibigFundContRemit'] ?? 0;
$pagibig2Remit = $_POST['pagibig2Remit'] ?? 0;
$multiPurpLoanRemit = $_POST['multiPurpLoanRemit'] ?? 0;
$pagibigCalamityLoanRemit = $_POST['pagibigCalamityLoanRemit'] ?? 0;
$totalPagibigDedsRemit = $_POST['totalPagibigDedsRemit'] ?? 0;
$philHealthRemit = $_POST['philHealthRemit'] ?? 0;
$disallowanceRemit = $_POST['disallowanceRemit'] ?? 0;
$landbankSalaryLoanRemit = $_POST['landbankSalaryLoanRemit'] ?? 0;
$earistCreditCoopRemit = $_POST['earistCreditCoopRemit'] ?? 0;
$feuRemit = $_POST['feuRemit'] ?? 0;
$mtslaSalaryLoanRemit = $_POST['mtslaSalaryLoanRemit'] ?? 0;
$eslaRemit = $_POST['eslaRemit'] ?? 0;
$totalOtherDedsRemit = $_POST['totalOtherDedsRemit'] ?? 0;
$totalDedsRemit = $_POST['totalDedsRemit'] ?? 0;

// Start transaction
$conn->begin_transaction();

try {
    // Get department_id from department name
    $deptQuery = "SELECT id FROM department WHERE department_name = ?";
    $stmtDept = $conn->prepare($deptQuery);
    $stmtDept->bind_param("s", $department_name);
    $stmtDept->execute();
    $deptResult = $stmtDept->get_result();
    $department_id = $deptResult->fetch_assoc()['id'];
    $stmtDept->close();

    // Get month_id from month name
    $monthQuery = "SELECT id FROM month WHERE month_name = ?";
    $stmtMonth = $conn->prepare($monthQuery);
    $stmtMonth->bind_param("s", $month_name);
    $stmtMonth->execute();
    $monthResult = $stmtMonth->get_result();
    $month_id = $monthResult->fetch_assoc()['id'];
    $stmtMonth->close();

    // Insert into payroll table using IDs
    $sqlPayroll = "INSERT INTO employeedatapayroll (
        name, position, rateNbc594, nbcDiffl597, increment, grossSalary,
        absent, days, hours, minutes, withHoldingTax,
        totalGsisDeds, totalPagibigDeds, philHealthEmployeeShare, totalOtherDeds,
        totalDeds, pay1st, pay2nd, rtIns, employeesCompensation,
        philHealthGovernmentShare, pagibig, netSalary, department_id, month_id
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmtPayroll = $conn->prepare($sqlPayroll);
    $stmtPayroll->bind_param(
        "ssdddddddddddddddddddddii",
        $name, $position, $rateNbc594, $nbcDiffl597, $increment, $grossSalary,
        $absent, $days, $hours, $minutes, $withHoldingTax,
        $totalGsisDeds, $totalPagibigDeds, $philHealthEmployeeShare, $totalOtherDeds,
        $totalDeds, $pay1st, $pay2nd, $rtIns, $employeesCompensation,
        $philHealthGovernmentShare, $pagibig, $netSalary, $department_id, $month_id
    );
    $payrollSuccess = $stmtPayroll->execute();
    $payroll_id = $conn->insert_id; // Get the last inserted ID
    $stmtPayroll->close();

    // Insert into remittance table using IDs
    $sqlRemittance = "INSERT INTO employeedataremittance (
        name, position, witholdingTax, personalLifeRet, gsisSalaryLoan, gsisPolicyLoan,
        gfal, cpl, mpl, mplLite, emergencyLoan, totalGsisDeds, pagibigFundCont,
        pagibig2, multiPurpLoan, pagibigCalamityLoan, totalPagibigDeds, philHealth,
        disallowance, landbankSalaryLoan, earistCreditCoop, feu, mtslaSalaryLoan,
        esla, totalOtherDeds, totalDeds, department_id, month_id, payroll_id
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmtRemittance = $conn->prepare($sqlRemittance);
    $stmtRemittance->bind_param(
        "ssddddddddddddddddddddddddiii",
        $name, $position, $withholdingTaxRemit, $personalLifeRetRemit, $gsisSalaryLoanRemit, 
        $gsisPolicyLoanRemit, $gfalRemit, $cplRemit, $mplRemit, $mplLiteRemit, 
        $emergencyLoanRemit, $totalGsisDedsRemit, $pagibigFundContRemit, $pagibig2Remit,
        $multiPurpLoanRemit, $pagibigCalamityLoanRemit, $totalPagibigDedsRemit, 
        $philHealthRemit, $disallowanceRemit, $landbankSalaryLoanRemit, 
        $earistCreditCoopRemit, $feuRemit, $mtslaSalaryLoanRemit, $eslaRemit, 
        $totalOtherDedsRemit, $totalDedsRemit, $department_id, $month_id, $payroll_id
    );

    $remittanceSuccess = $stmtRemittance->execute();
    $stmtRemittance->close();

    if ($payrollSuccess && $remittanceSuccess) {
        $conn->commit();
        echo "Employee data saved successfully in both payroll and remittance tables.";
    } else {
        $conn->rollback();
        echo "Error: Failed to save employee data.";
    }

} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>
