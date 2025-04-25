<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
  header("Location: login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $pay_rate = $_POST['pay_rate'];
  $bank_details = $_POST['bank_details'];

  if (empty($name)) {
    $error_message = "Please enter employee name.";
  } elseif (empty($phone)) {
    $error_message = "Please enter employee phone number.";
  } elseif (empty($email)) {
    $error_message = "Please enter employee email address.";
  } elseif (empty($pay_rate) || !is_numeric($pay_rate) || $pay_rate <= 0) {
    $error_message = "Please enter a valid pay rate.";
  } elseif (empty($bank_details)) {
    $error_message = "Please enter bank details.";
  } else {
    try {
      $stmt = $conn->prepare("INSERT INTO employees (name, phone, email, pay_rate, bank_details) 
                              VALUES (:name, :phone, :email, :pay_rate, :bank_details)");
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':phone', $phone);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':pay_rate', $pay_rate);
      $stmt->bindParam(':bank_details', $bank_details);
      $stmt->execute();

      header("Location: employees.php?success=1"); // Redirect to employees page with success message
      exit();

    } catch(PDOException $e) {
      $error_message = "Error adding employee: " . $e->getMessage();
      // Log the error for debugging
      error_log("Error adding employee: " . $e->getMessage(), 3, "error.log");
    }
  }
}

?>

<h2>Add Employee</h2>
<?php if (isset($error_message)): ?>
  <div class="alert alert-danger"><?php echo $error_message; ?></div>
<?php endif; ?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <div class="form-group">
    <label for="name">Name:</label>
    <input type="text" class="form-control" id="name" name="name" required>
  </div>
  <div class="form-group">
    <label for="phone">Phone:</label>
    <input type="text" class="form-control" id="phone" name="phone" required>
  </div>
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="form-group">
    <label for="pay_rate">Pay Rate:</label>
    <input type="number" step="0.01" class="form-control" id="pay_rate" name="pay_rate" required>
  </div>
  <div class="form-group">
    <label for="bank_details">Bank Details:</label>
    <input type="text" class="form-control" id="bank_details" name="bank_details" 
           placeholder="Enter BSB: Account Number or PAYID" required> 
  </div>
  <button type="submit" class="btn btn-primary">Add Employee</button>
</form>

<?php
include '../partials/footer.php';
?>