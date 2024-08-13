<?php
require_once '../config/database.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$delivery_note_number = $data['delivery_note_number'] ?? null;
$order_id = $data['order_id'] ?? null;
$delivery_date = $data['delivery_date'] ?? null;
$status = $data['status'] ?? null;

if ($id && $delivery_note_number && $order_id && $delivery_date && $status) {
    $stmt = $conn->prepare("UPDATE Delivery_Notes SET delivery_note_number = ?, order_id = ?, delivery_date = ?, status = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("sissi", $delivery_note_number, $order_id, $delivery_date, $status, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'Delivery note updated successfully']);
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
