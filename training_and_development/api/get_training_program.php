<?php
require_once '../config/database.php';

header("Content-Type: application/json");

$id = $_GET['id'] ?? null;

if ($id) {
    $sql = "SELECT * FROM Training_Programs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $program = $result->fetch_assoc();
            echo json_encode($program);
        } else {
            echo json_encode(['error' => 'Training Program not found.']);
            http_response_code(404);
        }
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
