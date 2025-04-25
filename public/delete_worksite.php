<?php
session_start();
include '../config/config.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $worksite_id = $_GET['id'];

    try {
        // Check if there are any associated timesheets
        $stmt = $conn->prepare("SELECT COUNT(*) FROM timesheets WHERE worksite_id = :worksite_id");
        $stmt->bindParam(':worksite_id', $worksite_id);
        $stmt->execute();
        $row = $stmt->fetchColumn();

        if ($row > 0) {
            // Display an error message (optional)
            echo "<script>alert('Cannot delete worksite. There are associated timesheets.');</script>";
            header("Location: worksites.php");
            exit();
        }

        // Delete the worksite
        $stmt = $conn->prepare("DELETE FROM worksites WHERE id = :id");
        $stmt->bindParam(':id', $worksite_id);
        $stmt->execute();

        // Redirect to worksites page on success
        header("Location: worksites.php?success=1");
        exit();

    } catch(PDOException $e) {
        echo "Error deleting worksite: " . $e->getMessage();
        // Log the error for debugging
        error_log("Error deleting worksite: " . $e->getMessage(), 3, "error.log");
    }
} else {
    // Handle invalid request
    header("Location: worksites.php");
    exit();
}
?>