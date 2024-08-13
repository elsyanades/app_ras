<?php
require_once '../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$name = $data['name'];
$contact_info = $data['contact_info'];

$sql = "UPDATE Suppliers SET name = ?, contact_info = ?, updated_at = NOW() WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $name, $contact_info, $id);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Supplier updated successfully']);
    http_response_code(200);
} else {
    echo json_encode(['error' => $stmt->error]);
    http_response_code(500);
}

$stmt->close();
?>
