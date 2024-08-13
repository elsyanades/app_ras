<?php
require_once '../config/database.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$delivery_note_id = $data['delivery_note_id'] ?? null;
$item_id = $data['item_id'] ?? null;
$quantity = $data['quantity'] ?? null;

if ($id && $delivery_note_id && $item_id && $quantity) {
    $stmt = $conn->prepare("UPDATE Delivery_Note_Items SET delivery_note_id = ?, item_id = ?, quantity = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("iiii", $delivery_note_id, $item_id, $quantity, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'Delivery note item updated successfully']);
        http_response_code(200);
    } else {
        echo json_encode(['error' => $stmt->error]);
        http_response_code(500);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'Missing required fields']);
    http_response_code(400);
}

$conn->close();
?>
