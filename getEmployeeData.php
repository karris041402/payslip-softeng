<?php
// Database connection
require_once 'db.php';
// Query: join remittance + payroll tables
$sql = "
SELECT 
    r.id AS remittance_id,
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
    r.totalGsisDeds AS totalGsisDedsRemit,
    r.pagibigFundCont,
    r.pagibig2,
    r.multiPurpLoan,
    r.pagibigCalamityLoan,
    r.totalPagibigDeds AS totalPagibigDedsRemit,
    r.philHealth,
    r.disallowance,
    r.landbankSalaryLoan,
    r.earistCreditCoop,
    r.feu,
    r.mtslaSalaryLoan,
    r.esla,
    r.totalOtherDeds AS totalOtherDedsRemit,
    r.totalDeds AS totalDedsRemit,

    -- Payroll table fields
    p.grossSalary,
    p.netSalary,
    p.totalDeds AS totalDedsPayroll,
    p.withHoldingTax AS withHoldingTaxPayroll,
    p.totalGsisDeds AS totalGsisDedsPayroll,
    p.totalPagibigDeds AS totalPagibigDedsPayroll,
    p.philHealthEmployeeShare,
    p.pay1st,
    p.pay2nd,
    p.department_id,
    p.month_id

FROM employeedataremittance r
INNER JOIN employeedatapayroll p 
    ON r.payroll_id = p.id
ORDER BY r.name ASC
";

$result = $conn->query($sql);
$employees = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = [
            'name' => $row['name'],
            'position' => $row['position'],
            'withHoldingTax' => $row['withHoldingTax'],
            'personalLifeRetRemit' => $row['personalLifeRet'],
            'gsisSalaryLoanRemit' => $row['gsisSalaryLoan'],
            'gsisPolicyLoanRemit' => $row['gsisPolicyLoan'],
            'gfalRemit' => $row['gfal'],
            'cplRemit' => $row['cpl'],
            'mplRemit' => $row['mpl'],
            'mplLiteRemit' => $row['mplLite'],
            'emergencyLoanRemit' => $row['emergencyLoan'],
            'totalGsisDedsRemit' => $row['totalGsisDedsRemit'],
            'pagibigFundContRemit' => $row['pagibigFundCont'],
            'pagibig2Remit' => $row['pagibig2'],
            'multiPurpLoanRemit' => $row['multiPurpLoan'],
            'pagibigCalamityLoanRemit' => $row['pagibigCalamityLoan'],
            'totalPagibigDedsRemit' => $row['totalPagibigDedsRemit'],
            'philHealthRemit' => $row['philHealth'],
            'disallowanceRemit' => $row['disallowance'],
            'landbankSalaryLoanRemit' => $row['landbankSalaryLoan'],
            'earistCreditCoopRemit' => $row['earistCreditCoop'],
            'feuRemit' => $row['feu'],
            'mtslaSalaryLoanRemit' => $row['mtslaSalaryLoan'],
            'eslaRemit' => $row['esla'],
            'totalOtherDedsRemit' => $row['totalOtherDedsRemit'],
            'totalDedsRemit' => $row['totalDedsRemit'],

            // Payroll fields
            'grossSalary' => $row['grossSalary'],
            'netSalary' => $row['netSalary'],
            'totalDedsPayroll' => $row['totalDedsPayroll'],
            'philHealthEmployeeShare' => $row['philHealthEmployeeShare'],
            'pay1st' => $row['pay1st'],
            'pay2nd' => $row['pay2nd']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($employees);
$conn->close();
?>
