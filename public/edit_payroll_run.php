<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

// ... (session check)

if (isset($_GET['id'])) {
    $payroll_run_id = $_GET['id'];

    // Fetch the payroll run details
    $stmt = $conn->prepare("SELECT * FROM payroll_runs WHERE id = :payroll_run_id");
    $stmt->bindParam(':payroll_run_id', $payroll_run_id);
    $stmt->execute();
    $payroll_run = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$payroll_run) {
        echo "Payroll run not found.";
    } else {
        ?>
        <h2>Edit Payroll Run</h2>
        <form method="post" action="update_payroll_run.php">  <input type="hidden" name="id" value="<?php echo $payroll_run_id; ?>">
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $payroll_run['start_date']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date:</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $payroll_run['end_date']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="total_amount" class="form-label">Total Amount:</label>
                <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount" value="<?php echo $payroll_run['total_amount']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">Notes:</label>
                <textarea class="form-control" id="notes" name="notes" rows="3"><?php echo $payroll_run['notes']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Payrun</button>
        </form>
        <?php
    }
} else {
    echo "Invalid payroll run ID.";
}

include '../partials/footer.php';
?>