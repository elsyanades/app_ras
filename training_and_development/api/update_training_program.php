<?php
require_once '../config/database.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$name = $data['name'] ?? null;
$description = $data['description'] ?? null;
$start_date = $data['start_date'] ?? null;
$end_date = $data['end_date'] ?? null;
$location = $data['location'] ?? null;

if ($id && $name && $description && $start_date && $end_date && $location) {
    $sql = "UPDATE Training_Programs SET title = ?, description = ?, start_date = ?, end_date = ?, location = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $name, $description, $start_date, $end_date, $location, $id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Training Program updated successfully.']);
    } else {
        echo json_encode(['error' => $stmt->error]);
        http_response_code(500);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid input data.']);
    http_response_code(400);
}

$conn->close();
?>
