<?php
require_once '../config/database.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);

$order_number = $data['order_number'] ?? null;
$supplier_id = $data['supplier_id'] ?? null;
$order_date = $data['order_date'] ?? null;
$status = $data['status'] ?? null;
$total_amount = $data['total_amount'] ?? null;

if ($order_number && $supplier_id && $order_date && $status && $total_amount !== null) {
    $stmt = $conn->prepare("INSERT INTO Purchase_Orders (order_number, supplier_id, order_date, status, total_amount, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("siisd", $order_number, $supplier_id, $order_date, $status, $total_amount);

    if ($stmt->execute()) {
        echo json_encode([
            'id' => $stmt->insert_id,
            'order_number' => $order_number,
            'supplier_id' => $supplier_id,
            'order_date' => $order_date,
            'status' => $status,
            'total_amount' => $total_amount,
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
