<?php
require_once '../config/database.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);

$delivery_note_id = $data['delivery_note_id'] ?? null;
$item_id = $data['item_id'] ?? null;
$quantity = $data['quantity'] ?? null;

if ($delivery_note_id && $item_id && $quantity) {
    $stmt = $conn->prepare("INSERT INTO Delivery_Note_Items (delivery_note_id, item_id, quantity, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("iii", $delivery_note_id, $item_id, $quantity);

    if ($stmt->execute()) {
        echo json_encode([
            'id' => $stmt->insert_id,
            'delivery_note_id' => $delivery_note_id,
            'item_id' => $item_id,
            'quantity' => $quantity,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        http_response_code(201);
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
