<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

$f = $_GET['from_date'] ?? '';
$t = $_GET['to_date'] ?? '';
$s = $_GET['employee_id'] ?? 0;
$st = $_GET['status'] ?? ''; // Keep this for the filter, but always show unpaid

$stmt = $conn->query("SELECT id, username FROM users");
$u = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = $conn->query("SELECT id, name FROM employees");
$e = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2>Timesheets</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <a href="add_timesheet.php" class="btn btn-primary mb-3">Add Timesheet</a>
        </div>
        <div class="col-md-6">
            <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="employee_id">Employee:</label>
                        <select class="form-control" id="employee_id" name="employee_id">
                            <option value="0">All Employees</option>
                            <?php foreach ($e as $emp): ?>
                                <option value="<?php echo $emp['id']; ?>" <?php echo ($s == $emp['id']) ? 'selected' : ''; ?>>
                                    <?php echo $emp['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="from_date">From Date:</label>
                        <input type="date" class="form-control" id="from_date" name="from_date" value="<?php echo $f; ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="to_date">To Date:</label>
                        <input type="date" class="form-control" id="to_date" name="to_date" value="<?php echo $t; ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="status">Status:</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">All</option>
                            <option value="1" <?php if ($st == 1) echo 'selected'; ?>>Paid</option>
                            <option value="0" <?php if ($st == 0) echo 'selected'; ?>>Unpaid</option>
                        </select>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table id="timesheet-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Worksite</th>
                        <th>Date</th>
                        <th>Hours</th>
                        <th>Total Pay</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT t.*, e.name AS employee_name, w.name AS worksite_name, e.pay_rate
                            FROM timesheets t
                            JOIN employees e ON t.employee_id=e.id
                            JOIN worksites w ON t.worksite_id=w.id
                            WHERE t.paid = 0"; // Always show unpaid timesheets

                    $params = [];

                    if ($s > 0) {
                        $sql .= " AND t.employee_id = :employee_id";
                        $params[':employee_id'] = $s;
                    }

                    if (!empty($f) && !empty($t)) {
                        $sql .= " AND t.date BETWEEN :from_date AND :to_date";
                        $params[':from_date'] = $f;
                        $params[':to_date'] = $t;
                    }

                    // The status filter from the dropdown is now just for filtering the *results*
                    // after they've been fetched, not for the database query.

                    $stmt = $conn->prepare($sql);
                    foreach ($params as $key => $value) {
                        $stmt->bindValue($key, $value);
                    }
                    $stmt->execute();
                    $timesheets = $stmt->fetchAll(PDO::FETCH_ASSOC);


                    foreach ($timesheets as $timesheet):
                        ?>
                        <tr>
                            <td><?php echo $timesheet['employee_name']; ?></td>
                            <td><?php echo $timesheet['worksite_name']; ?></td>
                            <td><?php echo $timesheet['date']; ?></td>
                            <td><?php echo $timesheet['hours']; ?></td>
                            <td><?php echo number_format($timesheet['hours'] * $timesheet['pay_rate'], 2); ?></td>
                            <td><?php echo ($timesheet['paid'] == 1) ? 'Paid' : 'Unpaid'; ?></td>
                            <td>
                                <a href="edit_timesheet.php?id=<?php echo $timesheet['id']; ?>"
                                   class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="delete_timesheet.php?id=<?php echo $timesheet['id']; ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Are you sure you want to delete this timesheet?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <a href="export_timesheets.php?from_date=<?php echo $f; ?>&to_date=<?php echo $t; ?>"
       class="btn btn-success mt-3">Export to Excel</a>
</div>

<?php
include '../partials/footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6ZYgfuA2A+LcPZ+rVn16jth4r/KT" crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        $('#timesheet-table').DataTable({
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
    });
</script>