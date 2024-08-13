<?php
require_once '../config/database.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$name = $data['name'] ?? null;
$description = $data['description'] ?? null;
$price = $data['price'] ?? null;

if ($id && $name && $description && $price !== null) {
    $stmt = $conn->prepare("UPDATE Services SET service_name = ?, description = ?, price = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("ssdi", $name, $description, $price, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'Service updated successfully']);
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
