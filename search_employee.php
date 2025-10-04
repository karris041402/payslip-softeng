<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php-error.log');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

function detectColumnHeaders($worksheet) {
    $headerMap = [];
    $expectedHeaders = [
        'gross_salary' => ['GROSS SALARY'],
        'absences' => ['ABS.'],
        'net_salary' => ['NET SALARY'],
        'tax' => ['WITHHOLDING TAX'],
        'philhealth' => ['PHIL. HEALTH'],
        'pay_first' => ['PAY 1ST'],
        'pay_second' => ['PAY 2ND'],
        'life_retirement' => ['PERSONAL LIFE/RET INS.'],
        'gsis_salary_loan' => ['GSIS SALARY LOAN'],
        'gsis_policy_loan' => ['GSIS POLICY LOAN'],
        'gsis_gfal' => ['GFAL'],
        'gsis_cpl' => ['CPL'],
        'gsis_mpl' => ['MPL'],
        'gsis_mpl_lite' => ['MPL LITE'],
        'gsis_emergency_loan' => ['EMERGENCY LOAN (ELA)'],
        'pagibig' => ['PAGIBIG FUND CONT.'],
        'pagibig_mpl' => ['MULTI PURP. LOAN'],
        'feu' => ['FEU'],
        'mtsla' => ['MTSLA SALARY LOAN'],
        'ecc' => ['EARIST CREDIT COOP.'],
        'disallowance' => ['DISALLOWANCE'],
        'total_deductions' => ['TOTAL DEDS.'],
        'pagibig_calamity_loan' => ['PAGIBIG CALAMITY LOAN'],
        'gsis_housing_loan' => ['GSIS HOUSING LOAN'],
        'lbp' => ['LANDBANK SALARY LOAN']
        
    ];

    $highestColumn = $worksheet->getHighestColumn();
    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

    for ($col = 1; $col <= $highestColumnIndex; $col++) {
        $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);

        $combinedHeader = '';
        for ($row = 6; $row <= 10; $row++) {
            $cell = $worksheet->getCell($colLetter . $row);
            $cellValue = strtoupper(trim((string) $cell->getCalculatedValue()));
            if (!empty($cellValue)) {
                $combinedHeader .= ($combinedHeader ? ' ' : '') . $cellValue;
            }
        }

        $combinedHeader = trim($combinedHeader);

        foreach ($expectedHeaders as $key => $options) {
            foreach ($options as $header) {
                if ($combinedHeader === strtoupper($header)) {
                    $headerMap[$key] = $colLetter;
                    break 2;
                }
            }
        }
    }
    
    return $headerMap;
}


function searchEmployee($department, $months, $employeeName) {
    $results = [];

    foreach ($months as $month) {
        $filePath = "excels2/{$department}.xlsx";
        if (!file_exists($filePath)) {
            $results[] = ['month' => $month, 'success' => false, 'error' => 'Department file not found.'];
            continue;
        }

        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $reader->setLoadSheetsOnly([$month]); 

        $spreadsheet = $reader->load($filePath);
        $worksheet = $spreadsheet->getSheetByName($month);

         // ✅ Log memory after loading
        $usedMemoryMB = round(memory_get_usage(true) / 1024 / 1024, 2);
        error_log("🔄 Memory used after loading '{$month}' sheet: {$usedMemoryMB} MB");
        
        if (!$worksheet) {
            $results[] = ['month' => $month, 'success' => false, 'error' => 'Month sheet not found.'];
            
            // 🧼 CLEANUP
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);
            gc_collect_cycles();

             // ✅ Log memory after loading
            $usedMemoryMB = round(memory_get_usage(true) / 1024 / 1024, 2);
            error_log("🔄 Memory used after loading '{$month}' sheet: {$usedMemoryMB} MB");

            continue;
        }

        $headerMap = detectColumnHeaders($worksheet);
        $headerMap['name'] = 'B';

        $highestRow = $worksheet->getHighestRow();
        $found = false;

        for ($row = 9; $row <= $highestRow; $row++) {
            $name = trim((string) $worksheet->getCell($headerMap['name'] . $row)->getCalculatedValue());
            if (!empty($name) && stripos($name, $employeeName) !== false) {
                $employeeData = ['name' => $name, 'department' => $department, 'month' => $month];
                foreach ($headerMap as $key => $col) {
                    if ($key === 'name') continue;
                    $cellValue = $worksheet->getCell($col . $row)->getCalculatedValue();
                    $employeeData[$key] = is_numeric($cellValue) ? floatval($cellValue) : ($cellValue ?: '0');
                }
                $results[] = ['month' => $month, 'success' => true, 'employee' => $employeeData];
                $found = true;
                break;
            }
        }

        if (!$found) {
            error_log("Employee '$employeeName' not found in department '$department', month '$month'");
            $results[] = [
                'month' => $month,
                'success' => false,
                'error' => 'Employee not found in this month.'
            ];
        }

        // 🧼 CLEANUP – placed at the end of each iteration
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
        gc_collect_cycles();

         // ✅ Log memory after loading
        $usedMemoryMB = round(memory_get_usage(true) / 1024 / 1024, 2);
        error_log("🔄 Memory used after loading '{$month}' sheet: {$usedMemoryMB} MB");
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