<?php
require_once '../config/database.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$order_number = $data['order_number'] ?? null;
$supplier_id = $data['supplier_id'] ?? null;
$order_date = $data['order_date'] ?? null;
$status = $data['status'] ?? null;
$total_amount = $data['total_amount'] ?? null;

if ($id && $order_number && $supplier_id && $order_date && $status && $total_amount !== null) {
    $stmt = $conn->prepare("UPDATE Purchase_Orders SET order_number = ?, supplier_id = ?, order_date = ?, status = ?, total_amount = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("siisdi", $order_number, $supplier_id, $order_date, $status, $total_amount, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'Order updated successfully']);
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
