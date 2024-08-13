<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;

$sql = "SELECT * FROM Inventory_Items WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$inventory_item = $result->fetch_assoc();

if ($inventory_item) {
    echo json_encode($inventory_item);
    http_response_code(200);
} else {
    echo json_encode(['error' => 'Item not found']);
    http_response_code(404);
}

$stmt->close();
?>
