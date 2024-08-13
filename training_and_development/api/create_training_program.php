<?php
require_once '../config/database.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'] ?? null;
$description = $data['description'] ?? null;
$start_date = $data['start_date'] ?? null;
$end_date = $data['end_date'] ?? null;
$location = $data['location'] ?? null;

if ($name && $description && $start_date && $end_date && $location) {
    $sql = "INSERT INTO Training_Programs (title, description, start_date, end_date, location) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $description, $start_date, $end_date, $location);

    if ($stmt->execute()) {
        $response = [
            'id' => $stmt->insert_id,
            'name' => $name,
            'description' => $description,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'location' => $location,
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
