<?php
require_once '../config/database.php';

header("Content-Type: application/json");

$id = $_GET['id'] ?? null;

if ($id) {
    $sql = "DELETE FROM Training_Programs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Training Program deleted successfully.']);
    } else {
        echo json_encode(['error' => $stmt->error]);
        http_response_code(500);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'ID parameter is required.']);
    http_response_code(400);
}

$conn->close();
?>
