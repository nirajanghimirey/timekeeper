<?php
session_start();
include '../config/config.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

// Get timesheet ID from URL
$timesheet_id = $_GET['id'];

try {
    // Start the transaction
    $conn->beginTransaction();

    // 1. Delete related records in payroll_run_items FIRST
    $stmt = $conn->prepare("DELETE FROM payroll_run_items WHERE timesheet_id = :timesheet_id");
    $stmt->bindParam(':timesheet_id', $timesheet_id);
    $stmt->execute();

    // 2. Now delete the timesheet
    $stmt = $conn->prepare("DELETE FROM timesheets WHERE id = :id");
    $stmt->bindParam(':id', $timesheet_id);
    $stmt->execute();

    // Commit the transaction
    $conn->commit();

    // Redirect to timesheets page with success message
    header("Location: timesheets.php?success=3");
    exit();

} catch (PDOException $e) {
    // Rollback the transaction on error
    $conn->rollBack();

    // Log the error for debugging (important!)
    $error_message = "Error deleting timesheet: " . $e->getMessage();
    error_log($error_message, 3, "error.log");

    
    // Simple error message
    echo "An error occurred while deleting the timesheet. Please try again later.";

    
}
?>