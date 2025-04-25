<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
  header("Location: login.php");
  exit();
}

// Fetch companies for dropdown
$stmt = $conn->query("SELECT id, name FROM companies");
$companies = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  $name = $_POST['name'];
  $company_id = $_POST['company_id'];
  $address = $_POST['address'];

  // Data validation
  if (empty($name)) {
    $error_message = "Please enter worksite name.";
  } elseif (empty($company_id)) {
    $error_message = "Please select a company.";
  } elseif (empty($address)) {
    $error_message = "Please enter worksite address.";
  } else {
    // Check for existing worksite with the same name under the same company
    $stmt = $conn->prepare("SELECT * FROM worksites WHERE name = :name AND company_id = :company_id");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':company_id', $company_id);
    $stmt->execute();
    $existingWorksite = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingWorksite) {
      $error_message = "A worksite with this name already exists for the selected company.";
    } else {
      try {
        // Insert new worksite if it doesn't exist
        $stmt = $conn->prepare("INSERT INTO worksites (name, company_id, address) VALUES (:name, :company_id, :address)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':company_id', $company_id);
        $stmt->bindParam(':address', $address);
        $stmt->execute();

        header("Location: worksites.php");
        exit();

      } catch(PDOException $e) {
        $error_message = "Error adding worksite: " . $e->getMessage();
        // Log the error for debugging
        error_log("Error adding worksite: " . $e->getMessage(), 3, "error.log");
      }
    }
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Worksite</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
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
            <h3>Add Worksite</h3>
          </div>
          <div class="card-body">
            <?php if (isset($error_message)): ?>
              <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <div class="form-group">
                <label for="name">Worksite Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
              </div>
              <div class="form-group">
                <label for="company_id">Company:</label>
                <select class="form-control" id="company_id" name="company_id">
                  <option value="">Select Company</option>
                  <?php foreach ($companies as $company): ?>
                    <option value="<?php echo $company['id']; ?>"><?php echo $company['name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" required>
              </div>
              <button type="submit" class="btn btn-primary">Add Worksite</button>
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