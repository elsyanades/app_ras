<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Origin: *");

include_once '../config/database.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';

$sql = "DELETE FROM performance_reviews WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Performance review deleted successfully.']);
    http_response_code(200);
} else {
    echo json_encode(['error' => $stmt->error]);
    http_response_code(500);
}

$stmt->close();
$conn->close();
?>
