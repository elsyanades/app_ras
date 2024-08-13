<?php
require_once '../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

$item_name = $data['item_name'];
$category = $data['category'];
$quantity = $data['quantity'];
$unit_price = $data['unit_price'];
$supplier_id = $data['supplier_id'];

$sql = "INSERT INTO Inventory_Items (item_name, category, quantity, unit_price, supplier_id) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssidi", $item_name, $category, $quantity, $unit_price, $supplier_id);

if ($stmt->execute()) {
    $response = [
        'id' => $stmt->insert_id,
        'item_name' => $item_name,
        'category' => $category,
        'quantity' => $quantity,
        'unit_price' => $unit_price,
        'supplier_id' => $supplier_id,
        'created_at' => date('Y-m-d H:i:s')
    ];
    echo json_encode($response);
    http_response_code(201);
} else {
    echo json_encode(['error' => $stmt->error]);
    http_response_code(500);
}

$stmt->close();
?>
