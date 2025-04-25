<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
  header("Location: login.php");
  exit();
}

$company_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM companies WHERE id = :id");
$stmt->bindParam(':id', $company_id);
$stmt->execute();
$company = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $address = $_POST['address'];

  if (empty($name)) {
    $error_message = "Please enter a company name.";
  } elseif (empty($address)) {
    $error_message = "Please enter a company address.";
  } else {
    try {
      $stmt = $conn->prepare("UPDATE companies SET name = :name, address = :address WHERE id = :id");
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':address', $address);
      $stmt->bindParam(':id', $company_id);
      $stmt->execute();

      header("Location: companies.php?success=2"); // Redirect to companies page with success message
      exit();

    } catch(PDOException $e) {
      $error_message = "Error updating company: " . $e->getMessage();
      // Log the error for debugging
      error_log("Error updating company: " . $e->getMessage(), 3, "error.log");
    }
  }
}

?>

<h2>Edit Company</h2>
<?php if (isset($error_message)): ?>
  <div class="alert alert-danger"><?php echo $error_message; ?></div>
<?php endif; ?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $company_id); ?>">
  <div class="form-group">
    <label for="name">Company Name:</label>
    <input type="text" class="form-control" id="name" name="name" value="<?php echo $company['name']; ?>" required>
  </div>
  <div class="form-group">
    <label for="address">Company Address:</label>
    <input type="text" class="form-control" id="address" name="address" value="<?php echo $company['address']; ?>" required>
  </div>
  <button type="submit" class="btn btn-primary">Update Company</button>
</form>

<?php
include '../partials/footer.php';
?>