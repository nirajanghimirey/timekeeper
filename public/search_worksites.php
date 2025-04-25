<?php
include '../config/config.php';

$search = $_GET['search'] ?? '';

$stmt = $conn->prepare("SELECT id, name FROM worksites WHERE name LIKE :search");
$stmt->bindValue(':search', '%' . $search . '%');
$stmt->execute();
$worksites = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($worksites);
?>