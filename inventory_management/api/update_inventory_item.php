<?php
require_once '../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$item_name = $data['item_name'];
$category = $data['category'];
$quantity = $data['quantity'];
$unit_price = $data['unit_price'];
$supplier_id = $data['supplier_id'];

$sql = "UPDATE Inventory_Items SET item_name = ?, category = ?, quantity = ?, unit_price = ?, supplier_id = ?, updated_at = NOW() WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssidi", $item_name, $category, $quantity, $unit_price, $supplier_id, $id);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Item updated successfully']);
    http_response_code(200);
} else {
    echo json_encode(['error' => $stmt->error]);
    http_response_code(500);
}

$stmt->close();
?>
