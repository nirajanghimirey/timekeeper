<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

// ... (session check)

if (isset($_GET['payroll_run_id']) && isset($_GET['employee_id'])) {
    $payroll_run_id = $_GET['payroll_run_id'];
    $employee_id = $_GET['employee_id'];

    // Get employee name for the heading
    $employee_name_stmt = $conn->prepare("SELECT name, email FROM employees WHERE id = :employee_id");
    $employee_name_stmt->bindParam(':employee_id', $employee_id);
    $employee_name_stmt->execute();
    $employee_data = $employee_name_stmt->fetch(PDO::FETCH_ASSOC);
    $employee_name = $employee_data['name'];
    $employee_email = $employee_data['email'];


    $stmt = $conn->prepare("SELECT t.*, w.name AS worksite_name, e.pay_rate AS rate
                            FROM payroll_run_items pri
                            INNER JOIN timesheets t ON pri.timesheet_id = t.id
                            INNER JOIN worksites w ON t.worksite_id = w.id
                            INNER JOIN employees e ON t.employee_id = e.id
                            WHERE pri.payroll_run_id = :payroll_run_id AND t.employee_id = :employee_id");

    $stmt->bindParam(':payroll_run_id', $payroll_run_id);
    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->execute();
    $timesheets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($timesheets === false) {
        var_dump($stmt->errorInfo());
        exit;
    }

    if (!$timesheets) {
        echo "No timesheets found for this employee in this payroll run.";
    } else {
        ?>
        <h2>Employee Timesheet Details</h2>
        <h3>Employee: <?php echo $employee_name; ?> (ID: <?php echo $employee_id; ?>)</h3>
        <button class="btn btn-primary" onclick="window.location.href='mailto:<?php echo $employee_email; ?>?subject=Timesheet Details&body=<?php echo urlencode(generateEmailBody($timesheets)); ?>'">Email Timesheet</button>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Worksite</th>
                    <th>Date</th>
                    <th>Hours</th>
                    <th>Rate</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($timesheets as $timesheet): ?>
                    <tr>
                        <td><?php echo $timesheet['worksite_name']; ?></td>
                        <td><?php echo date("l, j F, Y", strtotime($timesheet['date'])); ?></td>  <td><?php echo $timesheet['hours']; ?></td>
                        <td><?php echo $timesheet['rate']; ?></td>
                        <td><?php echo number_format($timesheet['hours'] * $timesheet['rate'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }
} else {
    echo "Invalid payroll run or employee ID.";
}

include '../partials/footer.php';

function generateEmailBody($timesheets) {
    $body = "Timesheet Details:\n\n";
    foreach ($timesheets as $timesheet) {
        $body .= "Worksite: " . $timesheet['worksite_name'] . "\n";
        $body .= "Date: " . date("l, j F, Y", strtotime($timesheet['date'])) . "\n";
        $body .= "Hours: " . $timesheet['hours'] . "\n";
        $body .= "Rate: " . $timesheet['rate'] . "\n";
        $body .= "Amount: " . number_format($timesheet['hours'] * $timesheet['rate'], 2) . "\n\n";
    }
    return $body;
}

?>