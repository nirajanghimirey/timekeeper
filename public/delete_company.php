<?php
session_start();
include '../config/config.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $company_id = $_GET['id'];

    try {
        // Check if there are any associated worksites
        $stmt = $conn->prepare("SELECT COUNT(*) FROM worksites WHERE company_id = :company_id");
        $stmt->bindParam(':company_id', $company_id);
        $stmt->execute();
        $row = $stmt->fetchColumn();

        if ($row > 0) {
            // Display an error message (optional)
            echo "<script>alert('Cannot delete company. There are associated worksites.');</script>";
            header("Location: companies.php");
            exit();
        }

        // Delete the company
        $stmt = $conn->prepare("DELETE FROM companies WHERE id = :id");
        $stmt->bindParam(':id', $company_id);
        $stmt->execute();

        // Redirect to companies page on success
        header("Location: companies.php?success=1");
        exit();

    } catch(PDOException $e) {
        echo "Error deleting company: " . $e->getMessage();
        // Log the error for debugging
        error_log("Error deleting company: " . $e->getMessage(), 3, "error.log");
    }
} else {
    // Handle invalid request
    header("Location: companies.php");
    exit();
}
?>