<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;

$sql = "SELECT * FROM Suppliers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$supplier = $result->fetch_assoc();

if ($supplier) {
    echo json_encode($supplier);
    http_response_code(200);
} else {
    echo json_encode(['error' => 'Supplier not found']);
    http_response_code(404);
}

$stmt->close();
?>
