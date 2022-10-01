<?php

include_once("../../controller/dbconnect.php");

// Filter the excel data 
function filterData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Excel file name for download 
$fileName = "visitor-data_" . date('Y-m-d') . ".xls";

// Column names 
$fields = array('ID', 'FULL NAME', 'COMPANY NAME', 'ADDRESS', 'PHONE NO', 'PERSON TO MEET', 'VISIT DATE', 'TIME', 'REASON', 'APPLY DATE', 'USER ID');

// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n";

// Fetch records from database 
$query = $conn->query("SELECT * FROM applicationform ORDER BY id ASC");
if ($query->rowCount() > 0){
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $status = ($row['status'] == 1) ? 'Active' : 'Inactive';
        $lineData = array($row['id'], $row['fullname'], $row['compname'], $row['address'], $row['phoneno'], $row['person'], $row['bdate'], $row['time'], $row['reason'], $row['regdate'], $row['user_id']);
        array_walk($lineData, 'filterData');
        $excelData .= implode("\t", array_values($lineData)) . "\n";
    }
} else {
    $excelData .= 'No records found...' . "\n";
}

// Headers for download 
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$fileName\"");

// Render excel data 
echo $excelData;

exit;

?>