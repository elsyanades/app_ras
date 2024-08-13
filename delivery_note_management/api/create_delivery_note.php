<?php
require_once '../config/database.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);

$delivery_note_number = $data['delivery_note_number'] ?? null;
$order_id = $data['order_id'] ?? null;
$delivery_date = $data['delivery_date'] ?? null;
$status = $data['status'] ?? null;

if ($delivery_note_number && $order_id && $delivery_date && $status) {
    $stmt = $conn->prepare("INSERT INTO Delivery_Notes (delivery_note_number, order_id, delivery_date, status, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("siss", $delivery_note_number, $order_id, $delivery_date, $status);

    if ($stmt->execute()) {
        echo json_encode([
            'id' => $stmt->insert_id,
            'delivery_note_number' => $delivery_note_number,
            'order_id' => $order_id,
            'delivery_date' => $delivery_date,
            'status' => $status,
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
