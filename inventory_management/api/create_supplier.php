<?php
require_once '../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'];
$contact_info = $data['contact_info'];

$sql = "INSERT INTO Suppliers (name, contact_info) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $name, $contact_info);

if ($stmt->execute()) {
    $response = [
        'id' => $stmt->insert_id,
        'name' => $name,
        'contact_info' => $contact_info,
        'created_at' => date('Y-m-d H:i:s')
    ];
    echo json_encode($response);
    http_response_code(201);
} else {
    echo json_encode(['error' => $stmt->error]);
    http_response_code(500);
}

$stmt->close();
?>
