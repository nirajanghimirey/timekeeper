<?php

function generate_payroll_csv($conn, $from_date, $to_date) {

    $sql = "SELECT 
                e.name, 
                e.pay_rate, 
                SUM(t.hours) as total_hours, 
                SUM(t.hours) * e.pay_rate as total_pay 
            FROM 
                employees e 
            JOIN 
                timesheets t ON e.id = t.employee_id 
            WHERE 
                t.date BETWEEN :from_date AND :to_date 
            GROUP BY 
                e.id, e.name, e.pay_rate";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':from_date', $from_date);
    $stmt->bindParam(':to_date', $to_date);
    $stmt->execute();
    $employee_reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $csv = "Employee,Pay Rate,Total Hours,Total Pay\n";

    foreach ($employee_reports as $report) {
        $row = implode(',', array(
                $report['name'],
                $report['pay_rate'],
                $report['total_hours'],
                number_format($report['total_pay'], 2)
            )) . "\n";
        $csv .= $row;
    }

    return $csv;
}

?>