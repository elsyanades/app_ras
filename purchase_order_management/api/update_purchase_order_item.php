<?php
require_once '../config/database.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$quantity = $data['quantity'] ?? null;
$unit_price = $data['unit_price'] ?? null;

if ($id && $quantity && $unit_price !== null) {
    $stmt = $conn->prepare("UPDATE Purchase_Order_Items SET quantity = ?, unit_price = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("dii", $quantity, $unit_price, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'Item updated successfully']);
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
