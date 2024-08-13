<?php
require_once '../config/database.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Origin: *");

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM Delivery_Note_Items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $delivery_note_item = $result->fetch_assoc();
        echo json_encode($delivery_note_item);
        http_response_code(200);
    } else {
        echo json_encode(['error' => 'Delivery note item not found']);
        http_response_code(404);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID is required']);
    http_response_code(400);
}

$conn->close();
?>