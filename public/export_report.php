<?php
session_start();
include '../config/config.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

// Retrieve from_date and to_date from URL parameters
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';

if (!empty($from_date) && !empty($to_date)) {
    // Assuming 'paid' is a boolean field (0 for false, 1 for true)
    $sql = "
        SELECT 
            e.name AS employee_name, 
            e.bank_details AS bank, 
            SUM(t.hours * e.pay_rate) AS total_pay
        FROM 
            timesheets t
        JOIN 
            employees e ON t.employee_id = e.id
        WHERE 
            t.date BETWEEN :from_date AND :to_date 
            AND t.paid = 0 
        GROUP BY e.id, e.name, e.bank_details"; 

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':from_date', $from_date);
    $stmt->bindParam(':to_date', $to_date);

    try {
        $stmt->execute();
        $employee_pays = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        // Handle database errors gracefully
        echo "Error: " . $e->getMessage();
        exit();
    }

    if (count($employee_pays) > 0) {
        // Set headers for CSV export
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="paysheet_report.csv"');

        // Output CSV data
        $output = '';
        $output .= "Employee,Bank,Total Pay\n";
        foreach ($employee_pays as $employee_pay) {
            $output .= '"' . $employee_pay['employee_name'] . '",';
            $output .= '"' . $employee_pay['bank'] . '",';
            $output .= '"' . number_format($employee_pay['total_pay'], 2) . "\"\n";
        }

        echo $output;
        exit;
    } else {
        echo "No unpaid timesheets found for the selected period.";
    }
} else {
    echo "Invalid date range.";
}
?>