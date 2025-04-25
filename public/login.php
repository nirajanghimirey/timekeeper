<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Fetch user from database
  $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE username = :username");
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
    // Verify password
    if (password_verify($password, $user['password_hash'])) {
      $_SESSION['user_id'] = $user['id']; // Store user ID in session
      $_SESSION['logged_in'] = true;
      header("Location: index.php");
      exit();
    } else {
      $error_message = "Invalid username or password.";
    }
  } else {
    $error_message = "Invalid username or password.";
  }
}

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
  ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3>Login</h3>
          </div>
          <div class="card-body">
            <?php if (isset($error_message)): ?>
              <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>
              <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <button type="submit" class="btn btn-primary">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
} else {
  // User is logged in, redirect to the desired page (e.g., index.php)
  header("Location: index.php");
  exit();
}

include '../partials/footer.php';
?>