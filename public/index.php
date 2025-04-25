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

<div class="container-fluid p-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="h2">Dashboard</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card-header bg-success text-white"">
                <div class="card-body">
                    <h5 class="card-title">Paycycle Report</h3>
                    <a href="reports.php" class="btn btn-lg btn-warning btn-block">Create Report</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title">Add Timesheets</h5>
                </div>
                <div class="card-body">
                    <a href="timesheets.php" class="btn btn-lg btn-warning btn-block">Start</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h5 class="card-title">Total Worksites</h5>
                </div>
                <div class="card-body">
                    <?php
                    $stmt = $conn->query("SELECT COUNT(*) as total_worksites FROM worksites");
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo "<p class='h4'>" . $row['total_worksites'] . "</p>";
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title">Check Estimated Pay</h5>
                </div>
                <div class="card-body">
                    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="from_date" class="col-form-label">From Date:</label>
                                <input type="date" class="form-control" id="from_date" name="from_date" value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="to_date" class="col-form-label">To Date:</label>
                                <input type="date" class="form-control" id="to_date" name="to_date" value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="employee" class="col-form-label">Employee:</label>
                                <select class="form-control" id="employee" name="employee">
                                    <option value="">Select Employee</option>
                                    <?php
                                    $stmt = $conn->query("SELECT id, name FROM employees");
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $selected = ($row['id'] == $_GET['employee']) ? 'selected' : '';
                                        echo "<option value='" . $row['id'] . "' " . $selected . ">" . $row['name'] . "</option>";
                                    }
                                    ?>
                                </select>
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
                    $employee_id = isset($_GET['employee']) ? $_GET['employee'] : ''; 

                    if (!empty($from_date) && !empty($to_date)) {
                        $sql = "
                            SELECT
                                e.name AS employee_name,
                                SUM(t.hours * e.pay_rate) AS total_pay
                            FROM
                                employees e
                            JOIN
                                timesheets t ON e.id = t.employee_id
                            WHERE
                                t.date BETWEEN :from_date AND :to_date ";

                        if (!empty($employee_id)) {
                            $sql .= " AND e.id = :employee_id";
                        }

                        $sql .= " GROUP BY
                                e.id, e.name";

                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':from_date', $from_date);
                        $stmt->bindParam(':to_date', $to_date);
                        if (!empty($employee_id)) {
                            $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT); 
                        }
                        $stmt->execute();
                        $employee_pay = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (count($employee_pay) > 0) {
                            ?>
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Total Pay</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($employee_pay as $pay): ?>
                                        <tr>
                                            <td><?php echo $pay['employee_name']; ?></td>
                                            <td><?php echo number_format($pay['total_pay'], 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php
                        } else {
                            ?>
                            <p class="text-center">No data found for the selected period.</p>
                            <?php
                        }
                    } else {
                        ?>
                            <p class="text-center">Please select a date range.</p>
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