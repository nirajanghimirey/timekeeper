<?php
session_start();
include '../config/config.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM employees WHERE id = :id");
        $stmt->bindParam(':id', $employee_id);
        $stmt->execute();

        // Redirect to employees page on success
        header("Location: employees.php?success=1");
        exit();

    } catch(PDOException $e) {
        echo "Error deleting employee: " . $e->getMessage();
        // Log the error for debugging
        error_log("Error deleting employee: " . $e->getMessage(), 3, "error.log");
    }
} else {
    // Handle invalid request
    header("Location: employees.php");
    exit();
}
?>