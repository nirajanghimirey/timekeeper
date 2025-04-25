<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

$error_message = "";
$success_message = "";
$timesheets = [];

$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// 1. Generate Report
if (isset($_POST['generate_report'])) {
    if (empty($start_date) || empty($end_date)) {
        $error_message = "Please select both start and end dates.";
    } else if ($start_date > $end_date) {
        $error_message = "Start date cannot be after end date.";
    } else {
        try {
            $db_start_date = date('Y-m-d', strtotime($start_date));
            $db_end_date = date('Y-m-d', strtotime($end_date));

            if ($db_start_date === false || $db_end_date === false) {
                throw new Exception("Invalid date format.");
            }

            $stmt = $conn->prepare("SELECT t.*, e.name AS employee_name, w.name AS worksite_name, e.pay_rate AS rate
                                    FROM timesheets t
                                    INNER JOIN employees e ON t.employee_id = e.id
                                    INNER JOIN worksites w ON t.worksite_id = w.id
                                    WHERE t.date BETWEEN :start_date AND :end_date");

            $stmt->bindValue(':start_date', $db_start_date, PDO::PARAM_STR);
            $stmt->bindValue(':end_date', $db_end_date, PDO::PARAM_STR);
            $stmt->execute();
            $timesheets = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($timesheets)) {
                $error_message = "No timesheets found for the selected criteria.";
            } else {
                $success_message = "Report preview generated.";
            }

        } catch (Exception $e) {
            $error_message = "Error generating report: " . $e->getMessage();
            error_log($error_message, 3, "error.log");
        } catch (PDOException $e) {
            $error_message = "Database Error: " . $e->getMessage();
            error_log($error_message, 3, "error.log");
        }
    }
}

// 2. Finalize and Save Payrun
if (isset($_POST['finalize_payroll'])) {
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
    $total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : '';
    $selected_timesheets = $_POST['selected_timesheets'] ?? [];
    $excluded_timesheets = $_POST['excluded_timesheets'] ?? [];
    $notes = $_POST['notes'] ?? '';

    $timesheets_to_process = array_diff($selected_timesheets, $excluded_timesheets);

    if (empty($timesheets_to_process)) {
        $error_message = "Please select at least one timesheet to include in the payrun.";
    } else if (empty($total_amount) || !is_numeric($total_amount)) {
        $error_message = "Please generate the report preview first.";
    } else {
        try {
            $conn->beginTransaction();

            // Calculate excluded amount and employee names for notes
            $excluded_amount = 0;
            $excluded_employee_names = [];
            foreach ($excluded_timesheets as $timesheet_id) {
                foreach ($timesheets as $timesheet) {
                    if ($timesheet['id'] == $timesheet_id) {
                        $excluded_amount += $timesheet['hours'] * $timesheet['rate'];
                        $excluded_employee_names[] = $timesheet['employee_name'];
                        break;
                    }
                }
            }
            $excluded_amount = number_format($excluded_amount, 2);

            $formatted_excluded_employee_names = implode(", ", $excluded_employee_names);

            $notes .= "\nExcluded Amount: $" . $excluded_amount;
            if(!empty($formatted_excluded_employee_names)){
                $notes .= "\nExcluded Employees: " . $formatted_excluded_employee_names;
            }


            // 1. Insert into payroll_runs
            $stmt = $conn->prepare("INSERT INTO payroll_runs (start_date, end_date, total_amount, notes) VALUES (:start_date, :end_date, :total_amount, :notes)");
            $stmt->bindValue(':start_date', $start_date);
            $stmt->bindValue(':end_date', $end_date);
            $stmt->bindValue(':total_amount', $total_amount);
            $stmt->bindValue(':notes', $notes);
            $stmt->execute();
            $payroll_run_id = $conn->lastInsertId();

            // 2. Insert into payroll_run_items
            foreach ($timesheets_to_process as $timesheet_id) {
                $stmt = $conn->prepare("INSERT INTO payroll_run_items (payroll_run_id, timesheet_id) VALUES (:payroll_run_id, :timesheet_id)");
                $stmt->bindValue(':payroll_run_id', $payroll_run_id, PDO::PARAM_INT);
                $stmt->bindValue(':timesheet_id', $timesheet_id, PDO::PARAM_INT);
                $stmt->execute();
            }

            $conn->commit();
            $success_message = "Payroll run finalized and saved.";

        } catch (PDOException $e) {
            $conn->rollBack();
            $error_message = "Error finalizing payroll run: " . $e->getMessage();
            error_log($error_message, 3, "error.log");
        }
    }
}
?>
<h2>Create Payroll Report</h2>

<form method="post" id="report-form">
    <input type="date" name="start_date" id="start_date" required>
    <input type="date" name="end_date" id="end_date" required>
    <button type="submit" name="generate_report">Generate Report Preview</button>
</form>

<?php if ($error_message): ?>
    <div class="alert alert-danger"><?php echo $error_message; ?></div>
<?php endif; ?>

<?php if ($success_message): ?>
    <div class="alert alert-success"><?php echo $success_message; ?></div>
<?php endif; ?>

<div id="timesheet-table-container">
    <?php if (!empty($timesheets)): ?>
        <form method="post">
            <input type="hidden" name="total_amount" id="total_amount" value="0">
            <table class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select_all"></th>
                        <th>Employee</th>
                        <th>Worksite</th>
                        <th>Date</th>
                        <th>Hours</th>
                        <th>Rate</th>
                        <th>Amount</th>
                        <th>Exclude</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($timesheets as $timesheet): ?>
                        <tr>
                            <td><input type="checkbox" name="selected_timesheets[]" value="<?php echo $timesheet['id']; ?>" checked></td>
                            <td><?php echo $timesheet['employee_name']; ?></td>
                            <td><?php echo $timesheet['worksite_name']; ?></td>
                            <td><?php echo $timesheet['date']; ?></td>
                            <td><?php echo $timesheet['hours']; ?></td>
                            <td><?php echo $timesheet['rate']; ?></td>
                            <td><?php echo number_format($timesheet['hours'] * $timesheet['rate'], 2); ?></td>
                            <td><input type="checkbox" name="excluded_timesheets[]" value="<?php echo $timesheet['id']; ?>"
                                <?php if (isset($_POST['excluded_timesheets']) && in_array($timesheet['id'], $_POST['excluded_timesheets'])) echo 'checked'; ?>></td>
                        </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>

            <label for="notes">Notes:</label>
            <textarea name="notes" rows="3"></textarea><br>

            <button type="submit" name="finalize_payroll">Finalize and Save Payrun</button>
        </form>
    <?php endif; ?>
</div>

<script>
    document.getElementById('select_all').addEventListener('change', function() {
        var includeCheckboxes = document.querySelectorAll('input[name="selected_timesheets[]"]');
        var excludeCheckboxes = document.querySelectorAll('input[name="excluded_timesheets[]"]');
        var isChecked = this.checked;

        includeCheckboxes.forEach((checkbox, index) => {
            if (!excludeCheckboxes[index].checked) {
                checkbox.checked = isChecked;
            }
        });
        calculateTotal();
    });


    const checkboxesInitial = document.querySelectorAll('input[name="selected_timesheets[]"]');
    const excludeCheckboxesInitial = document.querySelectorAll('input[name="excluded_timesheets[]"]');

    checkboxesInitial.forEach(checkbox => {
        checkbox.addEventListener('change', calculateTotal);
    });

    excludeCheckboxesInitial.forEach(checkbox => {
        checkbox.addEventListener('change', calculateTotal);
    });

    window.addEventListener('DOMContentLoaded', () => {
        calculateTotal();
    });

    function calculateTotal() {
        let currentTotal = 0;
        const includedTimesheets = document.querySelectorAll('input[name="selected_timesheets[]"]:checked');

        includedTimesheets.forEach(timesheetCheckbox => {
            const row = timesheetCheckbox.parentNode.parentNode;
            const amountCell = row.cells[6];
            const amount = parseFloat(amountCell.textContent.replace(/,/g, ''));
            const excludeCheckbox = row.cells[7].querySelector('input[name="excluded_timesheets[]"]');

            if (!excludeCheckbox.checked) {
                currentTotal += amount;
            }
        });

        const totalAmountInput = document.getElementById('total_amount');
        totalAmountInput.value = currentTotal.toFixed(2);
    }
</script>

<?php include '../partials/footer.php'; ?>