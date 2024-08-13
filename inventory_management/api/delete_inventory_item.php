<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;

$sql = "DELETE FROM Inventory_Items WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Item deleted successfully']);
    http_response_code(200);
} else {
    echo json_encode(['error' => $stmt->error]);
    http_response_code(500);
}

$stmt->close();
?>
