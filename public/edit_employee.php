<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
  header("Location: login.php");
  exit();
}

// Get employee ID from URL
$employee_id = $_GET['id'];

// Fetch employee details
$stmt = $conn->prepare("SELECT * FROM employees WHERE id = :id");
$stmt->bindParam(':id', $employee_id);
$stmt->execute();
$employee = $stmt->fetch(PDO::FETCH_ASSOC);

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
      $stmt = $conn->prepare("UPDATE employees SET name = :name, phone = :phone, email = :email, pay_rate = :pay_rate, bank_details = :bank_details WHERE id = :id");
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':phone', $phone);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':pay_rate', $pay_rate);
      $stmt->bindParam(':bank_details', $bank_details);
      $stmt->bindParam(':id', $employee_id);
      $stmt->execute();

      header("Location: employees.php?success=2"); // Redirect to employees page with success message
      exit();

    } catch(PDOException $e) {
      $error_message = "Error updating employee: " . $e->getMessage();
      // Log the error for debugging
      error_log("Error updating employee: " . $e->getMessage(), 3, "error.log");
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Employee</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    /* Basic styling - customize as needed */
    body {
      font-family: sans-serif;
      background-color: #f8f9fa;
    }
    .container {
      margin-top: 50px;
    }
    .card {
      border: 0;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .card-header {
      background-color: #007bff;
      color: #fff;
      border-radius: 5px 5px 0 0;
    }
    .card-body {
      padding: 30px;
    }
    .form-group label {
      font-weight: bold;
    }
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3>Edit Employee</h3>
          </div>
          <div class="card-body">
            <?php if (isset($error_message)): ?>
              <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $employee_id); ?>"> 
              <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($employee['name']); ?>" required>
              </div>
              <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($employee['phone']); ?>" required>
              </div>
              <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required>
              </div>
              <div class="form-group">
                <label for="pay_rate">Pay Rate:</label>
                <input type="number" step="0.01" class="form-control" id="pay_rate" name="pay_rate" value="<?php echo htmlspecialchars($employee['pay_rate']); ?>" required>
              </div>
              <div class="form-group">
                <label for="bank_details">Bank Details:</label>
                <input type="text" class="form-control" id="bank_details" name="bank_details" value="<?php echo htmlspecialchars($employee['bank_details']); ?>" 
                       placeholder="Enter BSB: Account Number or PAYID" required>
              </div>
              <button type="submit" class="btn btn-primary">Update Employee</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>

</body>
</html>