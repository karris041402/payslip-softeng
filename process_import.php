<?php
ini_set('display_errors', 0); // Disable display_errors in production
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Custom error handler to ensure JSON output for all errors
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return false;
    }
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Server Error: ' . $errstr,
        'details' => ['file' => $errfile, 'line' => $errline]
    ]);
    exit();
});

set_exception_handler(function ($exception) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Server Exception: ' . $exception->getMessage(),
        'details' => ['file' => $exception->getFile(), 'line' => $exception->getLine()]
    ]);
    exit();
});
ini_set('max_execution_time', 300); // 5 minutes
ini_set('memory_limit', '512M');

header('Content-Type: application/json');

require_once 'vendor/autoload.php';
require_once 'db.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

function detectColumnHeaders($worksheet) {
    $headerMap = [];
    $expectedHeaders = [
        'rateNbc594' => ['RATE NBC 594'],
        'nbcDiffl597' => ['NBC DIFFL 597'],
        'increment' => ['INCREMENT'],
        'grossSalary' => ['GROSS SALARY'],
        'absences' => ['ABS.'],
        'days' => ['DAYS'],
        'hours' => ['HOURS'],
        'minutes' => ['MINUTES'],
        'withHoldingTax' => ['WITHHOLDING TAX'],
        'totalGsisDeds' => ['TOTAL GSIS DEDS.'],
        'totalPagibigDeds' => ['TOTAL PAGIBIG DEDS.'],
        'philhealth1' => ['PHILHEALTH 1'],
        'philhealth2' => ['PHILHEALTHGOV'],
    
        'totalOtherDeds' => ['TOTAL OTHER DEDS.'],
        'totalDeds' => ['TOTAL DEDS.'],
        'payFirst' => ['PAY 1ST', '1ST PAY'],
        'paySecond' => ['PAY 2ND', '2ND PAY'],
        'rtIns' => ['RT. INS.'],
        'ec' => ['EC'],
        'pagibig' => ['PAGIBIG'],
        'netSalary' => ['NET SALARY'],
        
        'lifeRetirement' => ['PERSONAL LIFE/RET INS.'],
        'gsisSalaryLoan' => ['GSIS SALARY LOAN'],
        'gsisPolicyLoan' => ['GSIS POLICY LOAN'],
        'gsisGfal' => ['GFAL'],
        'gsisCpl' => ['CPL'],
        'gsisMpl' => ['MPL'],
        'gsisMplLite' => ['MPL LITE'],
        'gsisEmergencyLoan' => ['EMERGENCY LOAN (ELA)', 'EMERGENCY LOAN', 'ELA'],
        'pagibigFundCont' => ['PAGIBIG FUND CONT.'],
        'pagibig2' => ['PAG-IBIG 2', 'PAGIBIG 2'],
        'pagibigMultiPurpLoan' => ['MULTI PURP. LOAN'],
        'pagibig_calamity_loan' => ['PAGIBIG CL', 'PAG-IBIG CL'],
        'disallowance' => ['DISALLOWANCE'],
        'landbankSalaryLoan' => ['LANDBANK SALARY LOAN', 'LBP LOAN'],
        'ecc' => ['EARIST CREDIT COOP.', 'ECC'],
        'feu' => ['FEU'],
        'mtsla' => ['MTSLA SALARY LOAN', 'MTSLA'],
        'eslai' => ['SAVINGS & LOAN (ESLAI)', 'ESLAI'],        
        'position' => ['POSITION']
    ];

    $highestColumn = $worksheet->getHighestColumn();
    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

    for ($col = 1; $col <= $highestColumnIndex; $col++) {
        $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
        $combinedHeader = '';
        
        // Check rows 6-10 for headers
        for ($row = 6; $row <= 10; $row++) {
            $cell = $worksheet->getCell($colLetter . $row);
            $cellValue = strtoupper(trim((string) $cell->getCalculatedValue()));
            if (!empty($cellValue)) {
                $combinedHeader .= ($combinedHeader ? ' ' : '') . $cellValue;
            }
        }

        $combinedHeader = trim($combinedHeader);

        // Match against expected headers
        foreach ($expectedHeaders as $key => $options) {
            foreach ($options as $header) {
                $normalizedHeader = strtoupper($header);
                // Use strpos for partial matching to handle variations
                if ($combinedHeader === $normalizedHeader || 
                    strpos($combinedHeader, $normalizedHeader) !== false ||
                    strpos($normalizedHeader, $combinedHeader) !== false) {
                    
                    // Avoid overwriting if already mapped (prevents duplicates)
                    if (!isset($headerMap[$key])) {
                        $headerMap[$key] = $colLetter;
                        break 2;
                    }
                }
            }
        }
    }
    
    $headerMap['name'] = 'B'; // Name column is always B
    
    // Debug: Log detected headers
    error_log("Detected headers: " . json_encode($headerMap));
    
    return $headerMap;
}

function importDepartment($department) {
    global $conn;
    
    $filePath = "excels2/{$department}.xlsx";
    
    if (!file_exists($filePath)) {
        return [
            'success' => false,
            'error' => "Excel file not found: {$filePath}"
        ];
    }

    // Get department_id
    $deptStmt = $conn->prepare("SELECT id FROM department WHERE department_name = ?");
    $deptStmt->bind_param("s", $department);
    $deptStmt->execute();
    $deptResult = $deptStmt->get_result();
    
    if ($deptResult->num_rows === 0) {
        return [
            'success' => false,
            'error' => "Department not found in database: {$department}"
        ];
    }
    
    $department_id = $deptResult->fetch_assoc()['id'];
    $deptStmt->close();

    $reader = IOFactory::createReader('Xlsx');
    $reader->setReadDataOnly(true);
    $spreadsheet = $reader->load($filePath);
    
    $sheetNames = $spreadsheet->getSheetNames();
    $totalRecords = 0;
    $imported = 0;
    $failed = 0;

    foreach ($sheetNames as $sheetName) {

        $reader->setLoadSheetsOnly($sheetName);
        $spreadsheet = $reader->load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();


        // Get month_id
        $monthStmt = $conn->prepare("SELECT id FROM month WHERE month_name = ?");
        $monthStmt->bind_param("s", $sheetName);
        $monthStmt->execute();
        $monthResult = $monthStmt->get_result();
        
        if ($monthResult->num_rows === 0) {
            error_log("Month not found: {$sheetName}");
            $monthStmt->close();

            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);
            gc_collect_cycles();
            continue;
        }
        
        $month_id = $monthResult->fetch_assoc()['id'];
        $monthStmt->close();

        // Try to get sheet regardless of case
        $worksheet = null;
        foreach ($spreadsheet->getSheetNames() as $actualSheetName) {
            if (strcasecmp(trim($actualSheetName), trim($sheetName)) === 0) {
                $worksheet = $spreadsheet->getSheetByName($actualSheetName);
                break;
            }
        }

        if ($worksheet === null) {
            error_log("Sheet not found (case mismatch?): {$sheetName}");
            continue;
        }

        $headerMap = detectColumnHeaders($worksheet);
        $highestRow = $worksheet->getHighestRow();

        for ($row = 11; $row <= $highestRow; $row++) {
            $name = trim((string) $worksheet->getCell($headerMap['name'] . $row)->getCalculatedValue());
            
            if (empty($name) || $name === 'TOTAL') {
                continue;
            }

            $totalRecords++;

            try {
                $conn->begin_transaction();

                // Extract data from Excel
                $position = isset($headerMap['position']) ? 
                    trim((string) $worksheet->getCell($headerMap['position'] . $row)->getCalculatedValue()) : 
                    'N/A';
                
                $rateNbc594 = isset($headerMap['rateNbc594']) ? 
                    floatval($worksheet->getCell($headerMap['rateNbc594'] . $row)->getCalculatedValue()) : 0;

                $nbcDiffl597 = isset($headerMap['nbcDiffl597']) ? 
                    floatval($worksheet->getCell($headerMap['nbcDiffl597'] . $row)->getCalculatedValue()) : 0;

                $increment = isset($headerMap['increment']) ? 
                    floatval($worksheet->getCell($headerMap['increment'] . $row)->getCalculatedValue()) : 0;

                $grossSalary = isset($headerMap['grossSalary']) ? 
                    floatval($worksheet->getCell($headerMap['grossSalary'] . $row)->getCalculatedValue()) : 0;
                
                $absences = isset($headerMap['absences']) ? 
                    floatval($worksheet->getCell($headerMap['absences'] . $row)->getCalculatedValue()) : 0;

                $days = isset($headerMap['days']) ? 
                    floatval($worksheet->getCell($headerMap['days'] . $row)->getCalculatedValue()) : 0;

                $hours = isset($headerMap['hours']) ? 
                    floatval($worksheet->getCell($headerMap['hours'] . $row)->getCalculatedValue()) : 0;

                $minutes = isset($headerMap['minutes']) ? 
                    floatval($worksheet->getCell($headerMap['minutes'] . $row)->getCalculatedValue()) : 0;

                $netSalary = isset($headerMap['netSalary']) ? 
                    floatval($worksheet->getCell($headerMap['netSalary'] . $row)->getCalculatedValue()) : 0;

                $withHoldingTax = isset($headerMap['withHoldingTax']) ? 
                    floatval($worksheet->getCell($headerMap['withHoldingTax'] . $row)->getCalculatedValue()) : 0;
                
                $totalGsisDeds = isset($headerMap['totalGsisDeds']) ? 
                    floatval($worksheet->getCell($headerMap['totalGsisDeds'] . $row)->getCalculatedValue()) : 0;
                
                $totalPagibigDeds = isset($headerMap['totalPagibigDeds']) ? 
                    floatval($worksheet->getCell($headerMap['totalPagibigDeds'] . $row)->getCalculatedValue()) : 0;

                $philhealth1 = isset($headerMap['philhealth1']) ? 
                    floatval($worksheet->getCell($headerMap['philhealth1'] . $row)->getCalculatedValue()) : 0; 
                
                $totalOtherDeds = isset($headerMap['totalOtherDeds']) ? 
                    floatval($worksheet->getCell($headerMap['totalOtherDeds'] . $row)->getCalculatedValue()) : 0;     
                
                $totalDeds = isset($headerMap['totalDeds']) ? 
                    floatval($worksheet->getCell($headerMap['totalDeds'] . $row)->getCalculatedValue()) : 0; 
                
                $payFirst = isset($headerMap['payFirst']) ? 
                    floatval($worksheet->getCell($headerMap['payFirst'] . $row)->getCalculatedValue()) : 0;
                
                $paySecond = isset($headerMap['paySecond']) ? 
                    floatval($worksheet->getCell($headerMap['paySecond'] . $row)->getCalculatedValue()) : 0;

                $rtIns = isset($headerMap['rtIns']) ? 
                    floatval($worksheet->getCell($headerMap['rtIns'] . $row)->getCalculatedValue()) : 0;
                
                $ec = isset($headerMap['ec']) ? 
                    floatval($worksheet->getCell($headerMap['ec'] . $row)->getCalculatedValue()) : 0;

                $philhealth2 = isset($headerMap['philhealth2']) ? 
                    floatval($worksheet->getCell($headerMap['philhealth2'] . $row)->getCalculatedValue()) : 0;
                
                $pagibig = isset($headerMap['pagibig']) ? 
                    floatval($worksheet->getCell($headerMap['pagibig'] . $row)->getCalculatedValue()) : 0;

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
                    $absences, $days, $hours, $minutes, $withHoldingTax,
                    $totalGsisDeds, $totalPagibigDeds, $philhealth1, $totalOtherDeds,
                    $totalDeds, $payFirst, $paySecond, $rtIns, $ec,
                    $philhealth2, $pagibig, $netSalary, $department_id, $month_id
                );

                $stmtPayroll->execute();
                $payroll_id = $conn->insert_id;
                $stmtPayroll->close();




                // Extract remittance data
                $lifeRetirement = isset($headerMap['lifeRetirement']) ? 
                    floatval($worksheet->getCell($headerMap['lifeRetirement'] . $row)->getCalculatedValue()) : 0;
                
                $gsisSalaryLoan = isset($headerMap['gsisSalaryLoan']) ? 
                    floatval($worksheet->getCell($headerMap['gsisSalaryLoan'] . $row)->getCalculatedValue()) : 0;
                
                $gsisPolicyLoan = isset($headerMap['gsisPolicyLoan']) ? 
                    floatval($worksheet->getCell($headerMap['gsisPolicyLoan'] . $row)->getCalculatedValue()) : 0;
                
                $gsisGfal = isset($headerMap['gsisGfal']) ? 
                    floatval($worksheet->getCell($headerMap['gsisGfal'] . $row)->getCalculatedValue()) : 0;
                
                $gsisCpl = isset($headerMap['gsisCpl']) ? 
                    floatval($worksheet->getCell($headerMap['gsisCpl'] . $row)->getCalculatedValue()) : 0;
                
                $gsisMpl = isset($headerMap['gsisMpl']) ? 
                    floatval($worksheet->getCell($headerMap['gsisMpl'] . $row)->getCalculatedValue()) : 0;
                
                $gsisMplLite = isset($headerMap['gsisMplLite']) ? 
                    floatval($worksheet->getCell($headerMap['gsisMplLite'] . $row)->getCalculatedValue()) : 0;
                
                $gsisEmergencyLoan = isset($headerMap['gsisEmergencyLoan']) ? 
                    floatval($worksheet->getCell($headerMap['gsisEmergencyLoan'] . $row)->getCalculatedValue()) : 0;
                
                $pagibigFundCont = isset($headerMap['pagibigFundCont']) ? 
                    floatval($worksheet->getCell($headerMap['pagibigFundCont'] . $row)->getCalculatedValue()) : 0;

                $pagibig2 = isset($headerMap['pagibig2']) ? 
                    floatval($worksheet->getCell($headerMap['pagibig2'] . $row)->getCalculatedValue()) : 0;
                
                $pagibigMultiPurpLoan = isset($headerMap['pagibigMultiPurpLoan']) ? 
                    floatval($worksheet->getCell($headerMap['pagibigMultiPurpLoan'] . $row)->getCalculatedValue()) : 0;
                
                $pagibigCalamityLoan = isset($headerMap['pagibig_calamity_loan']) ? 
                    floatval($worksheet->getCell($headerMap['pagibig_calamity_loan'] . $row)->getCalculatedValue()) : 0;
                
                $philHealth3 = isset($headerMap['philhealth3']) ? 
                    floatval($worksheet->getCell($headerMap['philhealth3'] . $row)->getCalculatedValue()) : 0;
                
                $disallowance = isset($headerMap['disallowance']) ? 
                    floatval($worksheet->getCell($headerMap['disallowance'] . $row)->getCalculatedValue()) : 0;
                
                $landbankSalaryLoan = isset($headerMap['landbankSalaryLoan']) ? 
                    floatval($worksheet->getCell($headerMap['landbankSalaryLoan'] . $row)->getCalculatedValue()) : 0;
                
                $ecc = isset($headerMap['ecc']) ? 
                    floatval($worksheet->getCell($headerMap['ecc'] . $row)->getCalculatedValue()) : 0;
                
                $feu = isset($headerMap['feu']) ? 
                    floatval($worksheet->getCell($headerMap['feu'] . $row)->getCalculatedValue()) : 0;
                
                $mtsla = isset($headerMap['mtsla']) ? 
                    floatval($worksheet->getCell($headerMap['mtsla'] . $row)->getCalculatedValue()) : 0;

                $eslai = isset($headerMap['eslai']) ? 
                    floatval($worksheet->getCell($headerMap['eslai'] . $row)->getCalculatedValue()) : 0;

                // Insert into remittance table using IDs
                    $sqlRemittance = "INSERT INTO employeedataremittance (
                        name, position, withHoldingTax, personalLifeRet, gsisSalaryLoan, gsisPolicyLoan,
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
                    $name, $position, $withHoldingTax, $lifeRetirement, $gsisSalaryLoan,
                    $gsisPolicyLoan, $gsisGfal, $gsisCpl, $gsisMpl, $gsisMplLite, $gsisEmergencyLoan,$totalGsisDeds,
                    $pagibigFundCont, $pagibig2,  $pagibigMultiPurpLoan, $pagibigCalamityLoan,  $totalPagibigDeds,
                    $philHealth1, $disallowance, $landbankSalaryLoan, $ecc,
                    $feu, $mtsla, $eslai, $totalOtherDeds, $totalDeds, $department_id, $month_id, $payroll_id
                );
                $stmtRemittance->execute();
                $stmtRemittance->close();

                $conn->commit();
                $imported++;

            } catch (Exception $e) {
                $conn->rollback();
                $failed++;
                error_log("Import error for {$name} in {$sheetName}: " . $e->getMessage());
            }
        }

        // Clean up memory
        $spreadsheet->disconnectWorksheets();
        unset($worksheet);
        gc_collect_cycles();
    }

    unset($spreadsheet);
    gc_collect_cycles();

    return [
        'success' => true,
        'total_records' => $totalRecords,
        'imported' => $imported,
        'failed' => $failed
    ];
}

// Main execution
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $department = $_POST["department"] ?? "";

        if (empty($department)) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "error" => "Department is required"
            ]);
            exit;
        }

        $result = importDepartment($department);
        echo json_encode($result);
        exit;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "error" => "Server Exception: " . $e->getMessage(),
            "details" => ["file" => $e->getFile(), "line" => $e->getLine()]
        ]);
        exit();
    }
}

http_response_code(405);
echo json_encode([
    "success" => false,
    "error" => "Invalid request method"
]);
?>
