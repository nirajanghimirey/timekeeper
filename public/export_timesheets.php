<?php
session_start();
include '../config/config.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

// Get filter options
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';

$sql = "SELECT 
            t.*, 
            e.name AS employee_name, 
            w.name AS worksite_name, 
            e.pay_rate 
        FROM 
            timesheets t 
        JOIN 
            employees e ON t.employee_id = e.id 
        JOIN 
            worksites w ON t.worksite_id = w.id";

if (!empty($from_date) && !empty($to_date)) {
    $sql .= " WHERE t.date BETWEEN :from_date AND :to_date";
}

$stmt = $conn->prepare($sql);

if (!empty($from_date) && !empty($to_date)) {
    $stmt->bindParam(':from_date', $from_date);
    $stmt->bindParam(':to_date', $to_date);
}

$stmt->execute();
$timesheets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Set headers for Excel export
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="timesheets.csv"');

// Output CSV data
$output = '';
$output .= "Employee,Worksite,Date,Hours,Total Pay\n";
foreach ($timesheets as $timesheet) {
    $output .= '"' . $timesheet['employee_name'] . '",';
    $output .= '"' . $timesheet['worksite_name'] . '",';
    $output .= '"' . $timesheet['date'] . '",';
    $output .= '"' . $timesheet['hours'] . '",';
    $output .= '"' . number_format($timesheet['hours'] * $timesheet['pay_rate'], 2) . "\"\n";
}

echo $output;
exit;
?>