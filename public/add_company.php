<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $address = $_POST['address'];

    // Data validation
    if (empty($name)) {
        $error_message = "Please enter company name.";
    } elseif (empty($address)) {
        $error_message = "Please enter company address.";
    } else {
        try {
            // Insert company into database
            $stmt = $conn->prepare("INSERT INTO companies (name, address) VALUES (:name, :address)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':address', $address);
            $stmt->execute();

            header("Location: companies.php?success=1"); // Redirect to companies page with success message
            exit();

        } catch(PDOException $e) {
            $error_message = "Error adding company: " . $e->getMessage();
            // Log the error for debugging
            error_log("Error adding company: " . $e->getMessage(), 3, "error.log"); 
        }
    }
}

?>

<h2>Add Company</h2>
<?php if (isset($error_message)): ?>
    <div class="alert alert-danger"><?php echo $error_message; ?></div>
<?php endif; ?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="address">Address:</label>
        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Add Company</button>
</form>

<?php
include '../partials/footer.php';
?>