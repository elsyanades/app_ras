<?php
require_once '../config/database.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$employee_id = $data['employee_id'] ?? null;
$training_program_id = $data['training_program_id'] ?? null;
$certification_date = $data['certification_date'] ?? null;

if ($id && $employee_id && $training_program_id && $certification_date) {
    $sql = "UPDATE Certifications SET employee_id = ?, training_program_id = ?, certification_date = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisi", $employee_id, $training_program_id, $certification_date, $id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Certification updated successfully.']);
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
