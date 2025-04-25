<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
  header("Location: login.php");
  exit();
}

// Get timesheet ID from URL
$timesheet_id = $_GET['id'];

// Fetch timesheet details
$stmt = $conn->prepare("SELECT * FROM timesheets WHERE id = :id");
$stmt->bindParam(':id', $timesheet_id);
$stmt->execute();
$timesheet = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch employees and worksites for dropdown
$stmt = $conn->query("SELECT id, name FROM employees");
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query("SELECT id, name FROM worksites");
$worksites = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $employee_id = $_POST['employee_id'];
  $worksite_id = $_POST['worksite_id'];
  $date = $_POST['date'];
  $hours = $_POST['hours'];
  $paid = isset($_POST['paid']) ? 1 : 0; // 1 for Paid, 0 for Unpaid

  // Data Validation
  if (empty($employee_id)) {
    $error_message = "Please select an employee.";
  } elseif (empty($worksite_id)) {
    $error_message = "Please select a worksite.";
  } elseif (empty($date)) {
    $error_message = "Please enter a date.";
  } elseif (empty($hours) || !is_numeric($hours) || $hours <= 0) {
    $error_message = "Please enter valid hours worked.";
  } else {
    try {
      // Update timesheet in database
      $sql = "UPDATE timesheets SET employee_id = :employee_id, worksite_id = :worksite_id, date = :date, hours = :hours, paid = :paid WHERE id = :id, remarks = :remarks";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':employee_id', $employee_id);
      $stmt->bindParam(':worksite_id', $worksite_id);
      $stmt->bindParam(':date', $date);
      $stmt->bindParam(':hours', $hours);
      $stmt->bindParam(':remarks', $remarks);
      $stmt->bindParam(':paid', $paid, PDO::PARAM_INT); 
      $stmt->bindParam(':id', $timesheet_id);
      $stmt->execute();

      header("Location: timesheets.php?success=2"); // Redirect to timesheets page with success message
      exit();

    } catch(PDOException $e) {
      $error_message = "Error updating timesheet: " . $e->getMessage();
      // Log the error for debugging
      error_log("Error updating timesheet: " . $e->getMessage(), 3, "error.log");
    }
  }
}

?>

<h2>Edit Timesheet</h2>
<?php if (isset($error_message)): ?>
  <div class="alert alert-danger"><?php echo $error_message; ?></div>
<?php endif; ?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $timesheet_id); ?>">
  <div class="form-group">
    <label for="employee_id">Employee:</label>
    <select class="form-control" id="employee_id" name="employee_id">
      <option value="">Select Employee</option>
      <?php foreach ($employees as $employee): ?>
        <option value="<?php echo $employee['id']; ?>" <?php if ($timesheet['employee_id'] == $employee['id']) echo 'selected'; ?>><?php echo $employee['name']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="form-group">
    <label for="worksite_id">Worksite:</label>
    <select class="form-control" id="worksite_id" name="worksite_id">
      <option value="">Select Worksite</option>
      <?php foreach ($worksites as $worksite): ?>
        <option value="<?php echo $worksite['id']; ?>" <?php if ($timesheet['worksite_id'] == $worksite['id']) echo 'selected'; ?>><?php echo $worksite['name']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="form-group">
    <label for="date">Date:</label>
    <input type="date" class="form-control" id="date" name="date" value="<?php echo $timesheet['date']; ?>" required>
  </div>
  <div class="form-group">
    <label for="hours">Hours Worked:</label>
    <input type="number" step="0.01" class="form-control" id="hours" name="hours" value="<?php echo $timesheet['hours']; ?>" required>
  </div>
  <div class="form-group">
    <label for="remarks">Remarks:</label>
    <textarea class="form-control" id="remarks" name="remarks" rows="3"><?php echo $timesheet['remarks']; ?></textarea>
</div>
  <div class="form-group">
    <label for="paid">Status:</label>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="paid" id="paid" <?php if ($timesheet['paid'] == 1) echo 'checked'; ?>>
      <label class="form-check-label" for="paid">Paid</label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Update Timesheet</button>
</form>

<?php
include '../partials/footer.php';
?>