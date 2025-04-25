<?php
$host = "localhost";
$username = "u258059409_time";
$password = "C0ll3gi4t3@#$";
$dbname = "u258059409_time";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>