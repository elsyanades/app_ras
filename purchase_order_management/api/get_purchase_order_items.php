<?php
require_once '../config/database.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Origin: *");

$order_id = $_GET['order_id'] ?? null;

if ($order_id) {
    $stmt = $conn->prepare("SELECT * FROM Purchase_Order_Items WHERE purchase_order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    echo json_encode($items);
    http_response_code(200);
    $stmt->close();
} else {
    echo json_encode(['error' => 'Order ID is required']);
    http_response_code(400);
}

$conn->close();
?>
