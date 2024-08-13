<?php
require_once '../config/database.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$employee_id = $data['employee_id'] ?? null;
$training_program_id = $data['training_program_id'] ?? null;
$certification_date = $data['certification_date'] ?? null;

if ($employee_id && $training_program_id && $certification_date) {
    $sql = "INSERT INTO Certifications (employee_id, training_program_id, certification_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $employee_id, $training_program_id, $certification_date);

    if ($stmt->execute()) {
        $response = [
            'id' => $stmt->insert_id,
            'employee_id' => $employee_id,
            'training_program_id' => $training_program_id,
            'certification_date' => $certification_date,
            'created_at' => date('Y-m-d H:i:s')
        ];
        echo json_encode($response);
        http_response_code(201);
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
