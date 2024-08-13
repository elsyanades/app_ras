<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;

$sql = "DELETE FROM Suppliers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Supplier deleted successfully']);
    http_response_code(200);
} else {
    echo json_encode(['error' => $stmt->error]);
    http_response_code(500);
}

$stmt->close();
?>
