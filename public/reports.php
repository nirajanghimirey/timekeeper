<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="h2 text-center mb-4">Pay Report</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title text-center">Search Timesheets</h5>
                </div>
                <div class="card-body">
                    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="needs-validation" novalidate>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="from_date" class="form-label">From Date:</label>
                                <input type="date" class="form-control" id="from_date" name="from_date" value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>">
                                <div class="invalid-feedback">
                                    Please select a From Date.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="to_date" class="form-label">To Date:</label>
                                <input type="date" class="form-control" id="to_date" name="to_date" value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>">
                                <div class="invalid-feedback">
                                    Please select a To Date.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 text-end">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>

                    <?php
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
                        } catch(PDOException $e) {
                            // Handle database errors gracefully
                            echo "Error: " . $e->getMessage();
                            exit();
                        }

                        $employee_pays = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (count($employee_pays) > 0) {
                            ?>
                            <div class="row mt-4">
                                <div class="col-md-12 text-end">
                                    <a href="export_report.php?from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" class="btn btn-success">Export to Excel</a>
                                </div>
                            </div>

                            <table class="table table-sm table-hover mt-3" id="timesheet-table">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Bank</th>
                                        <th>Total Pay</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $total_company_pay = 0; 
                                        foreach ($employee_pays as $employee_pay): 
                                            $total_company_pay += $employee_pay['total_pay'];
                                    ?>
                                        <tr>
                                            <td><?php echo $employee_pay['employee_name']; ?></td>
                                            <td><?php echo $employee_pay['bank']; ?></td>
                                            <td><?php echo number_format($employee_pay['total_pay'], 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                           <p class="mt-3"><strong>Pay Forecast for</strong> <i><?php echo $from_date; ?> to <?php echo $to_date; ?></i><strong>: AUD <?php echo number_format($total_company_pay, 2); ?></strong></p>
                            <?php
                        } else {
                            ?>
                            <p class="text-center mt-3">No unpaid timesheets found for the selected period.</p>
                            <?php
                        }
                    } else {
                        ?>
                            <p class="text-center mt-3">Please select a date range.</p>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
include '../partials/footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6ZYgfuA2A+LcPZ+rVn16jB53L24MfwX00V+c2c4nxLXoHAJ0C8Z+Oi4s6J1th4r/KT" crossorigin="anonymous"></script>
</script>

