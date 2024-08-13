<?php
require_once '../config/database.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'] ?? null;
$description = $data['description'] ?? null;
$price = $data['price'] ?? null;

if ($name && $description && $price !== null) {
    $stmt = $conn->prepare("INSERT INTO Services (service_name, description, price, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("ssd", $name, $description, $price);

    if ($stmt->execute()) {
        echo json_encode([
            'id' => $stmt->insert_id,
            'service_name' => $name,
            'description' => $description,
            'price' => $price,
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
