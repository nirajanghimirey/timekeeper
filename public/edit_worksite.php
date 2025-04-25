<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
  header("Location: login.php");
  exit();
}

$worksite_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM worksites WHERE id = :id");
$stmt->bindParam(':id', $worksite_id);
$stmt->execute();
$worksite = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $address = $_POST['address'];

  try {
    $stmt = $conn->prepare("UPDATE worksites SET name = :name, address = :address WHERE id = :id");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':id', $worksite_id);
    $stmt->execute();

    header("Location: worksites.php?success=2"); // Redirect to worksites page with success message
    exit();

  } catch(PDOException $e) {
    $error_message = "Error updating worksite: " . $e->getMessage();
    // Log the error for debugging
    error_log("Error updating worksite: " . $e->getMessage(), 3, "error.log");
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Worksite</title>
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
            <h3>Edit Worksite</h3>
          </div>
          <div class="card-body">
            <?php if (isset($error_message)): ?>
              <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $worksite_id); ?>">
              <div class="form-group">
                <label for="name">Worksite Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $worksite['name']; ?>" required>
              </div>
              <div class="form-group">
                <label for="address">Worksite Address:</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $worksite['address']; ?>" required>
              </div>
              <button type="submit" class="btn btn-primary">Update Worksite</button>
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