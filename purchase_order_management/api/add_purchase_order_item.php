<?php
require_once '../config/database.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);

$purchase_order_id = $data['purchase_order_id'] ?? null;
$item_id = $data['item_id'] ?? null;
$quantity = $data['quantity'] ?? null;
$unit_price = $data['unit_price'] ?? null;

if ($purchase_order_id && $item_id && $quantity && $unit_price !== null) {
    $stmt = $conn->prepare("INSERT INTO Purchase_Order_Items (purchase_order_id, item_id, quantity, unit_price, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("iiid", $purchase_order_id, $item_id, $quantity, $unit_price);

    if ($stmt->execute()) {
        echo json_encode([
            'id' => $stmt->insert_id,
            'purchase_order_id' => $purchase_order_id,
            'item_id' => $item_id,
            'quantity' => $quantity,
            'unit_price' => $unit_price,
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
