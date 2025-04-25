<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

// Pagination settings
$results_per_page = 10;
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$start_index = ($current_page - 1) * $results_per_page;

// Count total finalized payroll runs
$total_runs_stmt = $conn->query("SELECT COUNT(*) AS total FROM payroll_runs WHERE finalized = 1"); // Assuming 'finalized' column exists
$total_runs_row = $total_runs_stmt->fetch(PDO::FETCH_ASSOC);
$total_runs = $total_runs_row['total'];
$total_pages = ceil($total_runs / $results_per_page);

// Fetch finalized payroll runs for the current page
$stmt = $conn->prepare("SELECT * FROM payroll_runs WHERE finalized = 1 ORDER BY generated_at DESC LIMIT :start, :limit"); // Assuming 'generated_at' column exists
$stmt->bindValue(':start', $start_index, PDO::PARAM_INT);
$stmt->bindValue(':limit', $results_per_page, PDO::PARAM_INT);
$stmt->execute();
$payroll_runs = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<h2>Payroll Dashboard</h2>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <h3>Finalized Payroll Runs</h3>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="table-primary">
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Generated At</th>
                        <th>Total Amount</th>
                        <th>Notes</th>
                        <th>View Items</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payroll_runs as $run): ?>
                        <tr>
                            <td><?php echo $run['start_date']; ?></td>
                            <td><?php echo $run['end_date']; ?></td>
                            <td><?php echo $run['generated_at']; ?></td>
                            <td><?php echo number_format($run['total_amount'], 2); ?></td>
                            <td><?php echo $run['notes']; ?></td>
                            <td><a href="view_payroll_items.php?id=<?php echo $run['id']; ?>" class="btn btn-sm btn-info">View</a></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($payroll_runs)): ?>
                        <tr><td colspan="6" class="text-center">No finalized payroll runs found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($current_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo build_url(['page' => $current_page - 1]); ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                            <a class="page-link" href="<?php echo build_url(['page' => $i]); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo build_url(['page' => $current_page + 1]); ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        <div class="col-md-3">
            <h3>Create New Payrun</h3>
            <div class="card">
                <div class="card-body">
                    <form action="create_payroll_report.php" method="get">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date:</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date:</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Payrun</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../partials/footer.php'; ?>

<?php
// Helper function to build URLs with query parameters
function build_url(array $new_params = []) {
    $existing_params = $_GET;
    $merged_params = array_merge($existing_params, $new_params);
    return http_build_query($merged_params) ? '?' . http_build_query($merged_params) : '';
}
?>