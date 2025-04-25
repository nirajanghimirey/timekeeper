<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

// ... (session check)

if (isset($_GET['id'])) {
    $payroll_run_id = $_GET['id'];

    // Get all employees associated with this payroll run (for the summary)
    $employees_stmt = $conn->prepare("SELECT DISTINCT e.id AS employee_id, e.name AS employee_name, e.bank_details
                                      FROM payroll_run_items pri
                                      INNER JOIN timesheets t ON pri.timesheet_id = t.id
                                      INNER JOIN employees e ON t.employee_id = e.id
                                      WHERE pri.payroll_run_id = :payroll_run_id");
    $employees_stmt->bindParam(':payroll_run_id', $payroll_run_id);
    $employees_stmt->execute();
    $employees = $employees_stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$employees) {
        echo "No employees found for this payroll run.";
    } else {
        ?>
        <h3>Employee Summary</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Bank Details</th>
                    <th>Total Shifts</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $employee_data = [];

                foreach ($employees as $employee):
                    $employee_id = $employee['employee_id'];

                    // Get timesheet data for this employee for this payroll run
                    $timesheets_stmt = $conn->prepare("SELECT t.*, w.name AS worksite_name, e.pay_rate AS pay_rate  -- Corrected: pay_rate (case-sensitive!)
                                                        FROM payroll_run_items pri
                                                        INNER JOIN timesheets t ON pri.timesheet_id = t.id
                                                        INNER JOIN worksites w ON t.worksite_id = w.id
                                                        INNER JOIN employees e ON t.employee_id = e.id  -- Join with employees table
                                                        WHERE pri.payroll_run_id = :payroll_run_id AND t.employee_id = :employee_id");

                    $timesheets_stmt->bindParam(':payroll_run_id', $payroll_run_id);
                    $timesheets_stmt->bindParam(':employee_id', $employee_id);
                    $timesheets_stmt->execute();
                    $timesheets = $timesheets_stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($timesheets === false) { // Check for query errors
                        var_dump($timesheets_stmt->errorInfo()); // Debugging: Display error info
                        exit; // Stop execution to prevent further issues
                    }

                    $total_amount = 0;
                    $timesheet_count = 0;
                    foreach ($timesheets as $timesheet) {
                        $total_amount += ($timesheet['hours'] * $timesheet['pay_rate']); // Use the correct alias
                        $timesheet_count++;
                    }

                    $employee_data[$employee_id] = [
                        'id' => $employee_id,
                        'name' => $employee['employee_name'],
                        'total_amount' => $total_amount,
                        'timesheet_count' => $timesheet_count,
                        'bank_details' => $employee['bank_details'],
                    ];
                    ?>
                    <tr>
                        <td><a href="employee_timesheet.php?payroll_run_id=<?php echo $payroll_run_id; ?>&employee_id=<?php echo $employee['employee_id']; ?>"><?php echo $employee['employee_name']; ?></a></td>
                        <td><?php echo $employee['bank_details']; ?></td>
                        <td><?php echo $timesheet_count; ?></td>
                        <td><?php echo number_format($total_amount, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }
} else {
    echo "Invalid payroll run ID.";
}

include '../partials/footer.php';
?>